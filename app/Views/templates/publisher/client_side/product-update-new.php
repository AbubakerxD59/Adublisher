
<div class="blog__navbar">
    <div class="container">
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
<!-- Product Updates Page Main Container -->
<div class="container-fluid blog__Category__main">
    <div class="container">
        <div class="row">
            <!-- Headings -->
            <div class="col-12">
                <div class="text-wrapper">
                    <h3>
                        Product Updates
                    </h3>
                    <p>
                        Stay updated with the latest enhancements and features of the Adublisher tool.
                    </p>
                </div>
            </div>
            <!-- Blogs Are Added here -->
            <?php
            foreach ($blogs as $blog) {
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="<?php echo SITEURL . 'blog/' . $blog->slug; ?>">
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

<!-- Icons Integration Area -->
<div class="blog__market_decoration container-fluid">
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