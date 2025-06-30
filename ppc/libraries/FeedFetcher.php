<?php
defined('BASEPATH') or exit('No direct script access allowed');

use DOMDocument;
use SimpleXMLElement;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use DOMXPath;

class FeedFetcher
{

    protected $CI;
    protected $guzzleClient;
    protected $timeout = 10; // seconds for network requests

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->guzzleClient = new Client([
            'timeout'  => $this->timeout,
            'allow_redirects' => true,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);
        log_message('debug', 'FeedFetcher Library Initialized');
    }

    /**
     * Main method to fetch RSS items from a given website URL.
     * @param string $websiteUrl The URL of the website.
     * @param int $mode 0 for Pinterest, 1 for other platforms.
     * @return array|false An array of feed items or false on failure.
     */
    public function fetchFeedItems($websiteUrl, $mode = 1) // Default to mode 1 (other platforms)
    {
        // 1. Sanitize and Validate URL
        if (filter_var($websiteUrl, FILTER_VALIDATE_URL) === FALSE) {
            log_message('error', 'Invalid website URL provided: ' . $websiteUrl);
            return ['error' => 'Invalid website URL.'];
        }

        // 2. Discover RSS Feed URL
        $rssFeedUrl = $this->discoverRssFeed($websiteUrl);

        if (!$rssFeedUrl) {
            log_message('info', 'No RSS feed found for: ' . $websiteUrl);
            return ['error' => 'No RSS feed found for this website.'];
        }

        log_message('info', 'Discovered RSS Feed URL: ' . $rssFeedUrl);

        // 3. Fetch and Parse RSS Feed
        $feedData = $this->parseRssFeed($rssFeedUrl, $mode); // Pass mode to parseRssFeed

        if (!$feedData || empty($feedData['items'])) {
            log_message('error', 'Failed to fetch or parse RSS feed from: ' . $rssFeedUrl);
            return ['error' => 'Failed to fetch or parse the RSS feed.'];
        }

        log_message('info', 'Successfully fetched ' . count($feedData['items']) . ' items from feed.');
        return ['success' => true, 'feed_info' => $feedData['info'], 'items' => $feedData['items']];
    }

    /**
     * Main method to fetch items from a website's sitemap.
     * @param string $websiteUrl The base URL of the website (e.g., https://ispecially.com/).
     * @param int $mode 0 for Pinterest, 1 for other platforms.
     * @param int $limit Max number of items to fetch and process.
     * @return array An array of processed items or an error.
     */
    public function fetchSitemapItems($websiteUrl, $mode = 1, $limit = 10)
    {
        if (filter_var($websiteUrl, FILTER_VALIDATE_URL) === FALSE) {
            log_message('error', 'Invalid website URL provided for sitemap: ' . $websiteUrl);
            return ['error' => 'Invalid website URL.'];
        }

        // Ensure base URL ends with a slash for proper resolution
        $baseUrl = rtrim($websiteUrl, '/') . '/';

        log_message('info', 'Starting sitemap fetch for: ' . $baseUrl . ' with mode: ' . $mode);

        $sitemapUrl = $this->discoverSitemap($baseUrl);

        if (!$sitemapUrl) {
            log_message('info', 'No sitemap found for: ' . $baseUrl);
            return ['error' => 'No sitemap found for this website.'];
        }

        log_message('info', 'Discovered Sitemap URL: ' . $sitemapUrl);

        $urls = $this->parseSitemap($sitemapUrl, []); // Use an empty array to track processed URLs
        if (empty($urls)) {
            log_message('error', 'No URLs found in sitemap(s) from: ' . $sitemapUrl);
            return ['error' => 'No URLs found in the sitemap.'];
        }

        $processedItems = [];
        $count = 0;

        foreach ($urls as $url) {
            if ($count >= $limit) {
                break; // Stop after reaching the limit
            }

            log_message('debug', 'Processing sitemap URL: ' . $url);
            // Simulate an RSS item for the existing parseFeedItem structure
            // This is a bit of a hack, but reuses the logic efficiently.
            $fakeItem = new SimpleXMLElement('<item><link>' . html_escape($url) . '</link><title>Loading</title></item>');
            $processedItem = $this->parseFeedItem($fakeItem, 'sitemap_mock', $mode); // Use 'rss' type, pass the mode

            // For sitemap items, we don't have a title until we parse the page.
            // We should fetch the page's title explicitly if not gotten via og:title or similar during image fetch.
            // For simplicity, we'll try to get it from the page here if it's not already in `processedItem`.
            if (empty($processedItem['title'])) {
                try {
                    $response = $this->guzzleClient->get($url);
                    $html = (string)$response->getBody();
                    $dom = new DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML($html);
                    libxml_clear_errors();
                    $xpath = new DOMXPath($dom);
                    $titleNode = $xpath->query('//head/title');
                    if ($titleNode->length > 0) {
                        $processedItem['title'] = (string)$titleNode->item(0)->nodeValue;
                    } else {
                        $processedItem['title'] = 'No Title Found';
                        continue;
                    }
                } catch (RequestException $e) {
                    log_message('error', 'Network error fetching page for title: ' . $url . ': ' . $e->getMessage());
                    $processedItem['title'] = 'Error Fetching Title';
                    continue;
                } catch (Exception $e) {
                    log_message('error', 'Error parsing page for title: ' . $url . ': ' . $e->getMessage());
                    $processedItem['title'] = 'Error Parsing Title';
                    continue;
                }
            }


            $processedItems[] = $processedItem;
            $count++;
        }

        log_message('info', 'Successfully processed ' . $count . ' sitemap items.');
        return ['success' => true, 'items' => $processedItems];
    }

    /**
     * Discovers the RSS feed URL from a given website URL by parsing its HTML.
     * @param string $websiteUrl
     * @return string|false The discovered RSS feed URL or false if not found.
     */
    protected function discoverRssFeed($websiteUrl)
    {
        try {
            $response = $this->guzzleClient->get($websiteUrl);
            $html = (string)$response->getBody();

            $dom = new DOMDocument();
            // Suppress warnings for malformed HTML
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();

            $xpath = new DOMXPath($dom);

            // Look for common RSS/Atom link tags
            // <link rel="alternate" type="application/rss+xml" href="..." />
            // <link rel="alternate" type="application/atom+xml" href="..." />
            $nodes = $xpath->query('//link[@rel="alternate" and (contains(@type, "rss+xml") or contains(@type, "atom+xml"))]');

            foreach ($nodes as $node) {
                $href = $node->getAttribute('href');
                if ($href) {
                    // Ensure the feed URL is absolute
                    if (strpos($href, 'http') === 0) {
                        return $href;
                    } else {
                        // Resolve relative URLs
                        return rtrim($websiteUrl, '/') . '/' . ltrim($href, '/');
                    }
                }
            }
        } catch (RequestException $e) {
            log_message('error', 'Network error discovering RSS for ' . $websiteUrl . ': ' . $e->getMessage());
        } catch (Exception $e) {
            log_message('error', 'Error discovering RSS for ' . $websiteUrl . ': ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Fetches and parses an RSS/Atom feed URL.
     * @param string $feedUrl The URL of the RSS feed.
     * @param int $mode 0 for Pinterest, 1 for other platforms.
     * @return array|false An array containing 'info' and 'items', or false on failure.
     */
    protected function parseRssFeed($feedUrl, $mode)
    {
        try {
            $response = $this->guzzleClient->get($feedUrl);
            $xmlString = (string)$response->getBody();

            $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);

            if ($xml === false) {
                log_message('error', 'Failed to parse XML from feed: ' . $feedUrl);
                return false;
            }

            $feedInfo = [
                'title' => (string)$xml->channel->title,
                'link'  => (string)$xml->channel->link,
            ];

            $items = [];

            if (isset($xml->channel->item)) {
                foreach ($xml->channel->item as $item) {
                    $items[] = $this->parseFeedItem($item, 'rss', $mode); // Pass mode here
                }
            } elseif (isset($xml->entry)) {
                $feedInfo = [
                    'title' => (string)$xml->title,
                    'link'  => (string)$xml->link['href'],
                ];
                foreach ($xml->entry as $item) {
                    $items[] = $this->parseFeedItem($item, 'atom', $mode); // Pass mode here
                }
            } else {
                log_message('warning', 'Unknown feed format for: ' . $feedUrl);
                return false;
            }

            return ['info' => $feedInfo, 'items' => $items];
        } catch (RequestException $e) {
            log_message('error', 'Network error fetching feed ' . $feedUrl . ': ' . $e->getMessage());
        } catch (Exception $e) {
            log_message('error', 'Error parsing feed ' . $feedUrl . ': ' . $e->getMessage());
        }

        return false;
    }

    /**
     * Discovers the sitemap URL(s) for a given website.
     * Checks robots.txt first, then common locations.
     * @param string $websiteUrl The base URL of the website.
     * @return string|false The discovered sitemap URL or false if not found.
     */
    protected function discoverSitemap($websiteUrl)
    {
        $robotsTxtUrl = rtrim($websiteUrl, '/') . '/robots.txt';
        log_message('debug', 'Checking robots.txt for sitemap: ' . $robotsTxtUrl);

        try {
            $response = $this->guzzleClient->get($robotsTxtUrl, ['http_errors' => false]); // Don't throw for 404
            if ($response->getStatusCode() === 200) {
                $body = (string)$response->getBody();
                if (preg_match('/Sitemap:\s*(.*?)\s*\n/i', $body, $matches)) {
                    $sitemapUrl = trim($matches[1]);
                    log_message('info', 'Sitemap found in robots.txt: ' . $sitemapUrl);
                    return $sitemapUrl;
                }
            } else {
                log_message('debug', 'robots.txt not found or inaccessible: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            log_message('warning', 'Error fetching robots.txt: ' . $e->getMessage());
        }

        // Fallback to common sitemap locations if not in robots.txt or robots.txt not found
        $commonSitemaps = [
            rtrim($websiteUrl, '/') . '/sitemap.xml',
            rtrim($websiteUrl, '/') . '/sitemap_index.xml', // For WordPress typically
            rtrim($websiteUrl, '/') . '/sitemap/sitemap.xml',
            rtrim($websiteUrl, '/') . '/sitemap.php',
            rtrim($websiteUrl, '/') . '/sitemap.txt',
        ];

        foreach ($commonSitemaps as $sitemapCandidate) {
            log_message('debug', 'Checking common sitemap candidate: ' . $sitemapCandidate);
            try {
                $response = $this->guzzleClient->head($sitemapCandidate, ['http_errors' => false]);
                if ($response->getStatusCode() === 200 && str_contains($response->getHeaderLine('Content-Type'), 'xml')) {
                    log_message('info', 'Sitemap found at common location: ' . $sitemapCandidate);
                    return $sitemapCandidate;
                }
            } catch (RequestException $e) {
                log_message('warning', 'Error checking sitemap candidate ' . $sitemapCandidate . ': ' . $e->getMessage());
            }
        }

        return false;
    }

    /**
     * Parses a sitemap (or sitemap index) XML to extract URLs.
     * Handles recursive parsing for sitemap index files.
     * @param string $sitemapUrl The URL of the sitemap XML.
     * @param array $processedUrls Array to prevent infinite loops for recursive sitemaps.
     * @return array An array of URLs found in the sitemap(s).
     */
    protected function parseSitemap($sitemapUrl, $processedUrls)
    {
        $urls = [];

        if (in_array($sitemapUrl, $processedUrls)) {
            log_message('debug', 'Already processed sitemap: ' . $sitemapUrl);
            return []; // Avoid infinite recursion
        }
        $processedUrls[] = $sitemapUrl; // Mark as processed

        try {
            $response = $this->guzzleClient->get($sitemapUrl);
            $xmlString = (string)$response->getBody();
            $xml = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);

            if ($xml === false) {
                log_message('error', 'Failed to parse sitemap XML from: ' . $sitemapUrl);
                return [];
            }

            // Check if it's a sitemap index (contains <sitemap> tags)
            if (isset($xml->sitemap)) {
                log_message('debug', 'Sitemap is an index file: ' . $sitemapUrl);
                foreach ($xml->sitemap as $sitemapEntry) {
                    if (isset($sitemapEntry->loc)) {
                        $childSitemapUrl = (string)$sitemapEntry->loc;
                        log_message('debug', 'Parsing child sitemap: ' . $childSitemapUrl);
                        $urls = array_merge($urls, $this->parseSitemap($childSitemapUrl, $processedUrls));
                    }
                }
            }
            // Otherwise, it's a regular sitemap (contains <url> tags)
            elseif (isset($xml->url)) {
                log_message('debug', 'Sitemap is a URL set: ' . $sitemapUrl);
                foreach ($xml->url as $urlEntry) {
                    if (isset($urlEntry->loc)) {
                        $urls[] = (string)$urlEntry->loc;
                    }
                }
            } else {
                log_message('warning', 'Unknown sitemap format for: ' . $sitemapUrl);
            }
        } catch (RequestException $e) {
            log_message('error', 'Network error fetching sitemap ' . $sitemapUrl . ': ' . $e->getMessage());
        } catch (Exception $e) {
            log_message('error', 'Error parsing sitemap ' . $sitemapUrl . ': ' . $e->getMessage());
        }

        return $urls;
    }

    /**
     * Parses a single feed item (RSS or Atom) to extract title, main image, and all images,
     * applying mode-specific logic for image selection.
     * @param SimpleXMLElement $item The SimpleXMLElement object for the feed item.
     * @param string $type 'rss' or 'atom'
     * @param int $mode 0 for Pinterest, 1 for other platforms.
     * @return array
     */
    protected function parseFeedItem($item, $type = 'rss', $mode = 1)
    {
        $title = '';
        $link = '';
        $mainImage = '';
        $allImages = [];

        // Basic parsing for title and link from RSS/Atom item
        if ($type === 'rss') {
            $title = (string)$item->title;
            $link = (string)$item->link;
        } elseif ($type === 'atom') {
            $title = (string)$item->title;
            if (isset($item->link['href'])) {
                $link = (string)$item->link['href'];
            } elseif (isset($item->link[0]['href'])) {
                $link = (string)$item->link[0]['href'];
            }
        }
        // For sitemap items, we just get the link from the mock item.
        // Title will be fetched later if needed.
        // The image fetching logic (getPinterestImageFromArticle/getThumbnailFromArticle)
        // will handle fetching the actual page.
        elseif ($type === 'sitemap_mock') {
            $link = (string)$item->link; // Get link from the mock item
        }


        // --- Mode-specific Image Selection ---
        if (empty($link)) { // No link means we can't fetch the page for images
            log_message('warning', 'No link provided for item, cannot fetch images for mode ' . $mode);
        } else if ($mode == 0) { // Pinterest Mode
            log_message('debug', 'Pinterest mode selected. Checking images from article link: ' . $link);
            $pinImage = $this->getPinterestImageFromArticle($link);
            if ($pinImage) {
                $mainImage = $pinImage;
                $allImages[] = $pinImage; // Add it to allImages as well
            }
            if (empty($mainImage)) {
                $thumbnailImage = $this->getThumbnailFromArticle($link);
                if ($thumbnailImage) {
                    $mainImage = $thumbnailImage;
                    $allImages[] = $thumbnailImage; // Add it to allImages as well
                } else {
                    // Fallback to RSS feed's direct image if no specific thumbnail found on page
                    // This will only run if it's an actual RSS item, not a sitemap item as sitemap items won't have these.
                    if ($type !== 'sitemap_mock') {
                        log_message('debug', 'No specific thumbnail found from article, falling back to RSS content images.');
                        $rssImages = $this->extractImagesFromFeedContent($item, $type);
                        if (!empty($rssImages)) {
                            $mainImage = $rssImages[0]; // Take the first one as main
                            $allImages = array_merge($allImages, $rssImages);
                        }
                    }
                }
            }
        } elseif ($mode == 1) { // Other Platforms Mode (Thumbnail from Blog Page)
            log_message('debug', 'Other platforms mode selected. Attempting to get thumbnail from article link: ' . $link);
            $thumbnailImage = $this->getThumbnailFromArticle($link);
            if ($thumbnailImage) {
                $mainImage = $thumbnailImage;
                $allImages[] = $thumbnailImage; // Add it to allImages as well
            } else {
                // Fallback to RSS feed's direct image if no specific thumbnail found on page
                // This will only run if it's an actual RSS item, not a sitemap item as sitemap items won't have these.
                if ($type !== 'sitemap_mock') {
                    log_message('debug', 'No specific thumbnail found from article, falling back to RSS content images.');
                    $rssImages = $this->extractImagesFromFeedContent($item, $type);
                    if (!empty($rssImages)) {
                        $mainImage = $rssImages[0]; // Take the first one as main
                        $allImages = array_merge($allImages, $rssImages);
                    }
                }
            }
        }

        // Ensure allImages are unique and clean (even if gathered from multiple sources)
        $allImages = array_values(array_unique(array_filter($allImages)));

        return [
            'title'     => $title, // May be empty here for sitemap items, will be populated later
            'link'      => $link,
            'main_image' => $mainImage,
            'all_images' => $allImages,
        ];
    }

    /**
     * Extracts images from the RSS item's description or content:encoded field.
     * This is a helper to encapsulate the previous common image parsing.
     * @param SimpleXMLElement $item
     * @param string $type 'rss' or 'atom'
     * @return array All image URLs found within the content.
     */
    protected function extractImagesFromFeedContent($item, $type)
    {
        $images = [];

        // 1. Media content (xmlns:media="http://search.yahoo.com/mrss/")
        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content) && isset($media->content['url'])) {
            $images[] = (string)$media->content['url'];
        } elseif (isset($media->thumbnail) && isset($media->thumbnail['url'])) {
            $images[] = (string)$media->thumbnail['url'];
        }
        // 2. Enclosure tag
        elseif (isset($item->enclosure) && isset($item->enclosure['url']) && str_contains((string)$item->enclosure['type'], 'image')) {
            $images[] = (string)$item->enclosure['url'];
        }

        // 3. Images within description or content:encoded (HTML parsing)
        $contentHtml = '';
        if ($type === 'rss') {
            if (isset($item->children('http://purl.org/rss/1.0/modules/content/')->encoded)) {
                $contentHtml = (string)$item->children('http://purl.org/rss/1.0/modules/content/')->encoded;
            } elseif (isset($item->description)) {
                $contentHtml = (string)$item->description;
            }
        } elseif ($type === 'atom') {
            if (isset($item->content)) {
                $contentHtml = (string)$item->content;
            } elseif (isset($item->summary)) {
                $contentHtml = (string)$item->summary;
            }
        }

        if (!empty($contentHtml)) {
            $extractedImagesFromHtml = $this->extractImagesFromHtml($contentHtml);
            $images = array_merge($images, $extractedImagesFromHtml);
        }

        return array_values(array_unique(array_filter($images)));
    }


    /**
     * Gets the Pinterest-specific image from the linked article page.
     * @param string $articleUrl The URL of the article to fetch.
     * @return string|false The Pinterest-compliant image URL or false if not found.
     */
    protected function getPinterestImageFromArticle($articleUrl)
    {
        if (empty($articleUrl) || filter_var($articleUrl, FILTER_VALIDATE_URL) === FALSE) {
            log_message('warning', 'Invalid article URL for Pinterest image search: ' . $articleUrl);
            return false;
        }

        try {
            $response = $this->guzzleClient->get($articleUrl);
            $html = (string)$response->getBody();

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            $imgNodes = $xpath->query('//img'); // Get all image tags on the page
            $pinterestImage = false;

            foreach ($imgNodes as $img) {
                $src = $img->getAttribute('src');
                if (empty($src)) continue;

                $imageWidth = $img->getAttribute('width');
                $imageHeight = $img->getAttribute('height');

                // If dimensions are not in attributes, try to get them
                if (empty($imageWidth) || empty($imageHeight)) {
                    // Prepend base URL if src is relative
                    $absoluteSrc = $this->resolveRelativeUrl($src, $articleUrl);
                    log_message('debug', 'Attempting to get dimensions for: ' . $absoluteSrc);

                    // IMPORTANT: getimagesize() will make ANOTHER HTTP REQUEST for each image.
                    // This can be very slow and resource-intensive.
                    // Consider caching or finding meta tags instead of direct fetching.
                    try {
                        // Use Guzzle to fetch only headers to avoid downloading entire image
                        $headResponse = $this->guzzleClient->head($absoluteSrc, ['http_errors' => false]); // Don't throw exceptions on 404/500
                        if ($headResponse->getStatusCode() === 200) {
                            $contentType = $headResponse->getHeaderLine('Content-Type');
                            if (str_contains($contentType, 'image')) {
                                // For accurate dimensions, getimagesize from a stream might be better
                                // or download temporarily.
                                // For now, let's assume it downloads or finds it quickly.
                                // A more performant way is to download small part or use a dedicated image service.
                                $dimensions = @getimagesize($absoluteSrc); // @ to suppress warnings for broken images
                                if ($dimensions) {
                                    $imageWidth = $dimensions[0];
                                    $imageHeight = $dimensions[1];
                                    log_message('debug', 'Dimensions found via getimagesize: W=' . $imageWidth . ' H=' . $imageHeight);
                                } else {
                                    log_message('debug', 'Could not get dimensions for ' . $absoluteSrc);
                                }
                            }
                        } else {
                            log_message('debug', 'HEAD request failed for image: ' . $absoluteSrc . ' Status: ' . $headResponse->getStatusCode());
                        }
                    } catch (RequestException $e) {
                        log_message('error', 'Error fetching image head for dimensions: ' . $absoluteSrc . ' - ' . $e->getMessage());
                    }
                }

                $heightArray = ["1128", "900", "1000", "1024"];
                $widthArray = ["564", "700", "1500", "512", "513"];

                // Round up dimensions for comparison as per your logic
                $roundedHeight = ceil((float)$imageHeight);
                $roundedWidth = ceil((float)$imageWidth);

                if ($roundedHeight > 0 && $roundedWidth > 0 && in_array($roundedHeight, $heightArray) && in_array($roundedWidth, $widthArray)) {
                    $pinterestImage = $this->resolveRelativeUrl($src, $articleUrl); // Make sure URL is absolute
                    log_message('info', 'Found Pinterest image: ' . $pinterestImage . ' (W:' . $roundedWidth . ', H:' . $roundedHeight . ')');
                    return $pinterestImage; // Found the first matching Pinterest image, return it
                }
            }
        } catch (RequestException $e) {
            log_message('error', 'Network error fetching article for Pinterest image: ' . $articleUrl . ': ' . $e->getMessage());
        } catch (Exception $e) {
            log_message('error', 'Error processing article for Pinterest image: ' . $articleUrl . ': ' . $e->getMessage());
        }

        log_message('info', 'No Pinterest-compliant image found for: ' . $articleUrl);
        return false;
    }

    /**
     * Gets the main thumbnail image from the linked article page.
     * Prioritizes Open Graph 'og:image' or the first reasonable image.
     * @param string $articleUrl The URL of the article to fetch.
     * @return string|false The thumbnail image URL or false if not found.
     */
    protected function getThumbnailFromArticle($articleUrl)
    {
        if (empty($articleUrl) || filter_var($articleUrl, FILTER_VALIDATE_URL) === FALSE) {
            log_message('warning', 'Invalid article URL for thumbnail search: ' . $articleUrl);
            return false;
        }

        try {
            $response = $this->guzzleClient->get($articleUrl);
            $html = (string)$response->getBody();

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // 1. Try to get og:image (Open Graph image - highly reliable for social sharing)
            $ogImageNode = $xpath->query('//meta[@property="og:image"]/@content');
            if ($ogImageNode->length > 0) {
                $ogImageUrl = $ogImageNode->item(0)->nodeValue;
                if (!empty($ogImageUrl)) {
                    log_message('info', 'Found og:image: ' . $ogImageUrl);
                    return $this->resolveRelativeUrl($ogImageUrl, $articleUrl);
                }
            }

            // 2. Try to get a Twitter Card image
            $twitterImageNode = $xpath->query('//meta[@name="twitter:image"]/@content');
            if ($twitterImageNode->length > 0) {
                $twitterImageUrl = $twitterImageNode->item(0)->nodeValue;
                if (!empty($twitterImageUrl)) {
                    log_message('info', 'Found twitter:image: ' . $twitterImageUrl);
                    return $this->resolveRelativeUrl($twitterImageUrl, $articleUrl);
                }
            }

            // 3. Fallback: Get the first reasonable image from the body content
            // We can reuse the extractImagesFromHtml logic for this
            log_message('debug', 'No specific meta thumbnail found, trying first image from body.');
            $imgNodes = $xpath->query('//body//img'); // Limit to body to avoid logos/icons in header/footer
            foreach ($imgNodes as $img) {
                $src = $img->getAttribute('src');
                if (!empty($src)) {
                    // You might add basic dimension checks here (e.g., min-width/height to avoid tiny icons)
                    // For now, just return the first valid image source.
                    $absSrc = $this->resolveRelativeUrl($src, $articleUrl);
                    log_message('info', 'Found first body image: ' . $absSrc);
                    return $absSrc;
                }
            }
        } catch (RequestException $e) {
            log_message('error', 'Network error fetching article for thumbnail: ' . $articleUrl . ': ' . $e->getMessage());
        } catch (Exception $e) {
            log_message('error', 'Error processing article for thumbnail: ' . $articleUrl . ': ' . $e->getMessage());
        }

        log_message('info', 'No suitable thumbnail image found for: ' . $articleUrl);
        return false;
    }

    /**
     * Extracts all image URLs from an HTML string using DOMDocument.
     * This is primarily for RSS feed content, not the linked article.
     * @param string $html The HTML string to parse.
     * @return array An array of image src URLs.
     */
    protected function extractImagesFromHtml($html)
    {
        $images = [];
        if (empty($html)) {
            return $images;
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<body>' . $html . '</body>');
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $imgNodes = $xpath->query('//img');

        foreach ($imgNodes as $img) {
            $src = $img->getAttribute('src');
            if (!empty($src)) {
                $images[] = $src;
            }
        }
        return $images;
    }

    /**
     * Resolves a relative URL to an absolute URL based on a base URL.
     * @param string $relativeUrl The relative URL.
     * @param string $baseUrl The base URL to resolve against.
     * @return string The absolute URL.
     */
    protected function resolveRelativeUrl($relativeUrl, $baseUrl)
    {
        // If it's already absolute, return it
        if (filter_var($relativeUrl, FILTER_VALIDATE_URL)) {
            return $relativeUrl;
        }

        // Parse base URL
        $baseParts = parse_url($baseUrl);
        $scheme = isset($baseParts['scheme']) ? $baseParts['scheme'] . '://' : '';
        $host = isset($baseParts['host']) ? $baseParts['host'] : '';
        $port = isset($baseParts['port']) ? ':' . $baseParts['port'] : '';
        $path = isset($baseParts['path']) ? $baseParts['path'] : '';

        // Handle path
        if (str_starts_with($relativeUrl, '/')) {
            // Root-relative
            return $scheme . $host . $port . $relativeUrl;
        } else {
            // Directory-relative
            $dir = dirname($path);
            if ($dir === '.') $dir = ''; // Handle root directory case
            return $scheme . $host . $port . $dir . '/' . $relativeUrl;
        }
    }
}
