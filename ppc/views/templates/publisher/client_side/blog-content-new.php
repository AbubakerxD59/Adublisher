

<div class="blog__navbar">
    <div class="container blog__container">
        <ul>
            <li>
                <a href="<?php echo SITEURL.'product-updates'; ?>">Product Updates</a>
            </li>
            <li>
                <a href="">Latest Articles</a>
            </li>
            <li>
                <a href="">Reviews</a>
            </li>
        </ul>
    </div>
</div>
<!-- Blog Banner -->
<div class="container-fluid blog-banner-wrapper">
    <!-- <div class="container-fluid mt-48 py-24"> -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="blog__banner__thumbnail">
                    <a href="<?php echo SITEURL . 'blog/' . @$latest_blog[0]->slug; ?>">
                        <img class="img-fluid w-100 h-100" alt="Thumbail"
                            src="<?php echo SITEURL . '/assets/blogs/' . @$latest_blog[0]->thumbnail; ?>">
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="blog-banner-content h-100">
                    <div class="col-12">
                        <div class="blog-hashtag-holder">
                            <div class="blog-hashtag lg-blight">
                                <span class="blog-title">LinkedIn</span>
                            </div>
                            <div class="blog-hashtag lg-zephorn">
                                <span class="blog-title">Product Updates</span>
                            </div>
                            <div class="blog-hashtag lg-seraphin">
                                <span class="blog-title">Tiktok</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h1 class="p-0 my-4 mx-0">
                            <a href="<?php echo SITEURL . 'blog/' . @$latest_blog[0]->slug ?>">
                                <?php echo @$latest_blog[0]->title; ?>
                            </a>
                        </h1>
                        <p>
                            <?php echo @$latest_blog[0]->short_description; ?>
                        </p>
                    </div>
                    <div class="blog__author">
                        <div class="author__details">
                            <div class="author__icons">
                                <img src="<?php echo NewLandingAssets . 'images/Adublisher__Footer__banner.png'; ?>" alt="">
                            </div>
                            <p class="author__banner__name blog-bnr">Drm Yii</p>
                        </div>
                        <span class="date">
                            <?php echo date('F d, Y', strtotime(@$latest_blog[0]->published_at)); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Articles -->
<div class="container-fluid blog-latest-wrapper">
    <div class="container">
        <div class="blog-containers">
            <div class="row">
                <div class="col-12 d-flex align-items-start justify-content-between">
                    <div class="text-wrapper w-75 m-0">
                        <h2>
                            Latest Articles
                        </h2>
                        <p>
                            Explore the Latest News, Trends, and Updates on Social Media & Adublisher
                        </p>
                    </div>
                    <div class="view-btn-holder d-none d-xl-flex">
                        <button class="btn btn-over-dark">
                            <a href="latest.html">View All</a>
                        </button>
                    </div>
                </div>
                <!-- Blogs Are Added here -->
                <?php
                foreach ($blogs as $blog) {
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <a href="<?php echo SITEURL . 'blog/' . $blog->slug; ?> ">
                            <div class="blog-content-manage">
                                <!-- Hashtags -->
                                <div class="blog-contentArea">
                                    <div class="blog-contentImage">
                                        <img src="<?php echo SITEURL . '/assets/blogs/' . $blog->thumbnail; ?>">
                                    </div>
                                    <div class="blog__content__container">
                                        <div class="col-12 p-0">
                                            <div class="blog-hashtag-holder">
                                                <div class="blog-hashtag lg-blight">
                                                    <span class="blog-title">LinkedIn</span>
                                                </div>
                                                <div class="blog-hashtag lg-zephorn">
                                                    <span class="blog-title">Product Updates</span>
                                                </div>
                                                <div class="blog-hashtag lg-seraphin">
                                                    <span class="blog-title">Tiktok</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?php echo SITEURL . 'blog/' . $blog->slug; ?>">
                                            <?php echo $blog->title; ?>
                                        </a>
                                        <p>
                                            <?php echo htmlspecialchars_decode(stripslashes($blog->short_description)); ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="blog__time__end">
                                    <?php echo date('F d, Y', strtotime($blog->published_at)); ?>
                                </span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Marketing Content Area -->
<div class="container-fluid">
    <div class="container">
        <div class="col-12 p-0 m-0">
            <h1 class="ms-content-header">Social Media Tips and Tricks</h1>
        </div>
        <div class="market-specific-container">
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <p>Social Media Content</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-comments"></i>
                    <p>Social Media Engagement</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-bullhorn"></i>
                    <p>Social Media Advertising</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-bullseye"></i>
                    <p>Social Media Marketing</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <p>Social Media Tools</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-arrow-up-right-dots"></i>
                    <p>Social Media Growth</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-bars-staggered"></i>
                    <p>Social Media Strategy</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <p>Social Media Trends</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
            <div class="ms-content-holder">
                <div class="content-ms">
                    <i class="fa-solid fa-chart-line"></i>
                    <p>Social Media Analytics</p>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </div>
    </div>
</div>

<!-- Icons Integration Area -->
<div class="container-fluid blog__market_decoration">
    <div class="container">
        <div class="media__integrate-decoration">
            <div class="content">
                <h3>
                    Control All Your Social Media
                    <br class="d-none d-xl-flex">
                    Activities in One Hub
                </h3>
                <p>
                    Manage Facebook, Instagram, Twitter, TikTok, YouTube, LinkedIn, Pinterest, and Shopify all in one place.
                </p>
            </div>
            <img src="<?php echo NewLandingAssets . 'images/Icons.png'; ?>">
        </div>
    </div>
</div>

<!-- Explore More Section -->
<!-- <div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-wrapper">
                    <h1>More to Explore</h1>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-content-manage">
                    <div class="blog-contentImage">
                        <img src="<?php echo NewLandingAssets . 'images/blog11.jpg'; ?>">
                    </div>
                    <div class="col-12">
                        <div class="blog-hashtag-holder">
                            <div class="blog-hashtag lg-blight">
                                <span class="blog-title">LinkedIn</span>
                            </div>
                            <div class="blog-hashtag lg-zephorn">
                                <span class="blog-title">Product Updates</span>
                            </div>
                            <div class="blog-hashtag lg-seraphin">
                                <span class="blog-title">Tiktok</span>
                            </div>
                        </div>
                    </div>
                    <div class="blog-contentArea">
                        <a href="#">
                            Boost Your Engagement: Schedule 35-Image TikTok Carousels With Adublisher
                        </a>
                        <p>
                            Discover how to schedule TikTok carousels with up to 35 photos using Adublisher. Enhance your
                            engagement with our comprehensive guide and elevate your content strategy.
                        </p>
                        <span>
                            September 03, 2024
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-content-manage">
                    <div class="blog-contentImage">
                        <img src="<?php echo NewLandingAssets . 'images/blog12.jpg'; ?>">
                    </div>
                    <div class="col-12">
                        <div class="blog-hashtag-holder">
                            <div class="blog-hashtag lg-blight">
                                <span class="blog-title">LinkedIn</span>
                            </div>
                            <div class="blog-hashtag lg-zephorn">
                                <span class="blog-title">Product Updates</span>
                            </div>
                            <div class="blog-hashtag lg-seraphin">
                                <span class="blog-title">Tiktok</span>
                            </div>
                        </div>
                    </div>
                    <div class="blog-contentArea">
                        <a href="#">
                            Boost Your Engagement: Schedule 35-Image TikTok Carousels With Adublisher
                        </a>
                        <p>
                            Discover how to schedule TikTok carousels with up to 35 photos using Adublisher. Enhance your
                            engagement with our comprehensive guide and elevate your content strategy.
                        </p>
                        <span>
                            September 03, 2024
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="blog-content-manage">
                    <div class="blog-contentImage">
                        <img src="<?php echo NewLandingAssets . 'images/blog7.jpg'; ?>">
                    </div>
                    <div class="col-12">
                        <div class="blog-hashtag-holder">
                            <div class="blog-hashtag lg-blight">
                                <span class="blog-title">LinkedIn</span>
                            </div>
                            <div class="blog-hashtag lg-zephorn">
                                <span class="blog-title">Product Updates</span>
                            </div>
                            <div class="blog-hashtag lg-seraphin">
                                <span class="blog-title">Tiktok</span>
                            </div>
                        </div>
                    </div>
                    <div class="blog-contentArea">
                        <a href="#">
                            Boost Your Engagement: Schedule 35-Image TikTok Carousels With Adublisher
                        </a>
                        <p>
                            Discover how to schedule TikTok carousels with up to 35 photos using Adublisher. Enhance your
                            engagement with our comprehensive guide and elevate your content strategy.
                        </p>
                        <span>
                            September 03, 2024
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->


<!-- Footer Head -->
<div class="container-fluid blog-foot-decoration">
    <div class="container">
        <div class="row align-items-center foot-reverse__sm">
            <div class="col-12 col-lg-6 pxr-24">
                <div class="featured-images">
                    <img class="w-100 h-100" alt="Featured Image about Calender"
                        src="<?php echo NewLandingAssets . 'images/Adublisher__Footer__banner.png'; ?>">
                </div>
            </div>
            <div class="col-12 col-lg-6 pxl-24 mx-auto px-5">
                <div class="text-wrapper center">
                    <div class="logo">
                        <img src="<?php echo NewLandingAssets . 'images/logo.svg'; ?>" alt="">
                    </div>
                    <p class="m-2">
                        Powerful Social Media Management Platform
                    </p>
                    <p class="desc-small">
                        Trusted by 350,000+ social media managers, marketers, and global brands
                    </p>
                    <img src="<?php echo NewLandingAssets . 'images/Users-pics.png'; ?>" class="user__img__small">
                    <button class="btn btn-colored">
                        <a href="<?php echo SITEURL . 'register'; ?>">Try it for free</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- landing page newsletter -->
<?php $this->load->view('templates/publisher/client_side/landing-newsletter-new'); ?>