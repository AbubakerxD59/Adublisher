
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
<!-- Blog Header -->
<?php
$blog = $blog[0];
?>
<div class="container-fluid bg-light-gradient blog__head__margin">
    <div class="container">
            <div class="col-12">
                <div class="blog-hashtag-holder justify-content-center">
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
        <div class="col-12">
            <div class="text-wrapper center mt-5">
                <h2 class="fw-900">
                    <?php echo $blog->title; ?>
                </h2>
            </div>
        </div>
        <div class="col-12">
            <div class="author__details">
                <div class="author__icons">
                    <img src="<?php echo SITEURL . '/assets/blogs/' . $blog->thumbnail ?>" alt="">
                </div>
                <p class="author__banner__name">Drm Yii</p>
                <span>-</span>
                <p class="publish__date">January 31,2025</p>
            </div>
        </div>
    </div>
</div>

<!-- Blog Scroller -->
<div class="container-fluid p-0">
    <div class="container margin-auto p-0">
        <div id="blog__columns">
            <div class=" sticky-content left">
                <div class="table__of__content">
                    <?php
                    $toc = generateTableOfContents($blog->description);
                    ?>
                    <?php

                    if ($toc['status']) {
                        ?>
                        <h4>Table of Content</h4>
                        <?php echo $toc['body'] ?>
                        <?php
                    } ?>
                    <h4>Share this article</h4>
                    <ul class="table-of-content-lists">
                        <div class="article-share-icons">
                            <i class='bx bxl-facebook'></i>
                            <i class='bx bxl-linkedin' ></i>
                            <i class='bx bxl-twitter' ></i>
                            <i class='bx bxl-tiktok' ></i>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="main__blog__area">
                <div class="blog__content__area">
                    <div class="blog__thumbnail">
                        <img src="<?php echo SITEURL . '/assets/blogs/' . $blog->thumbnail ?>" alt="">
                    </div>
                    <div class="blog__content">
                        <p>
                            <?php echo $blog->description; ?>
                        </p>
                    </div>
                </div>
                <div class="author__detailed__wrapper">
                    <img src="<?php echo SITEURL . '/assets/blogs/' . $blog->thumbnail ?>" class="author__icon" alt="">
                    <div class="author__description">
                        <div class="author__links">
                            <h2 class="author__name">Drm Yii</h2>
                            <div class="author__link-icons">
                                <i class="bx bxl-facebook"></i>
                                <i class="bx bxl-instagram"></i>
                                <i class="bx bxl-linkedin"></i>
                                <i class="bx bxl-twitter"></i>
                            </div>
                        </div>
                        <p class="author__profession">CEO at Adublisher</p>
                        <p class="author__short__desc">
                            With over 10 years of experience in software development, entrepreneurship, digital marketing, and social media, I strive every day to bring the best solutions that will empower your online presence through Adublisher.
                        </p>
                    </div>
                </div>
            </div>
            <div class="sidebar__advertisments">
                <div class="sticky-content right">
                    <div class="dynamic__marketing__letter">
                        <h2>
                            Schedule Your TikTok Carousels!
                        </h2>
                        <p>
                            Connect Your TikTok Account Now To Boost Your Engagement & Go Viral!
                        </p>
                        <button class="btn-over-dark small mx-auto">Get Started!</button>
                    </div>
                    <div class="newsletter-colored small">
                        <h2>
                            Subscribe to our Newsletter
                        </h2>
                        <div class="newsletter-btn-holder small d-flex align-items-center col-12 m-auto gap-20">
                            <input type="email" placeholder="Your email here....">
                            <button class="btn btn-letter">Subcribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Explore More Section -->
<div class="container-fluid py-24 m-30">
    <div class="container">
        <div class="row">
            <div class="col-12 p-0">
                <div class="text-wrapper">
                    <h3>More to Explore</h3>
                </div>
                <!-- <div class="no-blog-content">
                    <div class="no__result__content">
                        No Result Found
                    </div>
                </div> -->
            </div>
            <?php
            foreach ($more_to_explore as $key => $value) {
                if ($value->id != $blog->id) {
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="blog-content-manage">
                            <div class="blog-contentArea">
                                <div class="blog-contentImage">
                                    <a href="<?php echo SITEURL . 'blog/' . $value->slug; ?>">
                                        <img src="<?php echo SITEURL . '/assets/blogs/' . $value->thumbnail; ?>">
                                    </a>
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
                                    <a href="<?php echo SITEURL . 'blog/' . $value->slug; ?>">
                                        <?php echo $value->title; ?>
                                    </a>
                                    <p>
                                        <?php echo $value->short_description; ?>
                                    </p>
                                </div>
                            </div>
                            <span class="text-muted">
                                <?php echo date('F d, Y', strtotime($value->published_at)); ?>
                            </span>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- Marketing Content Area -->
<div class="container-fluid p-0">
    <div class="container pb-50 my-5 mx-auto">
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
                    <i class="fa-solid fa-calendar-check"></i>
                    <p>Best Time to Post on Social Media</p>
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