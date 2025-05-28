<!-- URL Link Shortner Banner -->
<div class="container-fluid">
    <div class="container mt-48 py-5">
        <div class="text-wrapper center">
            <div class="animated-text">
                Shorten URL's for <span></span>
            </div>
            <p>
                Paste the URL of the post or media and press to download in HD.
            </p>
        </div>
        <input type="hidden" name="auth" class="auth" value="<?php echo check_user_login() ? '1' : '0'; ?>">
        <input type="hidden" name="user_id" class="user_id" value="<?php echo check_user_login() ? get_auth_user()->id : '0'; ?>">
        <div class="col-12">
            <div class="url-shortner wdth-80 mx-auto">
                <form action="#" method="post" id="shorten_link" class="col-12 shortner__form-container">
                    <input type="text" placeholder="Shorten your link" id="url" class="short-linker-field my-2"
                        required>
                    <button class="btn btn-link-shortner" type="submit">Shorten <i class="fa-solid fa-scissors"></i></button>
                </form>
                <div id="shorted_link_container">
                </div>
            </div>
            <div class="row d-flex align-items-center justify-content-between">
                <div class="utm-code-invoicer">
                    <div class="text-wrapper w-100 d-flex align-items-center justify-content-between position-relative">
                        <p>
                            No ads. No watermarks. No registration.
                            <br>
                            Issues? <a href="#">Contact us</a> .
                        </p>
                        <button id="toggleButton">
                            <div id="toggleCircle"></div>
                        </button>
                    </div>
                    <div class="utm-tooltip" id="UTM-tooltip">
                        <p>
                            UTM-code deactivated
                        </p>
                    </div>
                </div>
            </div>
            <!-- <div class="url_tracking mx-auto d-flex justify-content-end">
                <span class="px-3" style="font-weight: bolder;">URL TRACKING</span>
                <button id="toggleButton">
                    <div id="toggleCircle"></div>
                </button>
            </div> -->
        </div>
    </div>
</div>

<!-- URL Link Shortner Features -->
<div class="container-fluid bg-light-white py-5">
    <div class="container py-5">
        <div class="col-12">
            <div class="text-wrapper center mb-5">
                <h2>
                    Track Links for Free. Join now!
                </h2>
                <p>
                    Track your links effortlessly and gain insights into clicks and performance.
                    <br class="d-none d-lg-flex">
                    Sign up now to start using our free URL tracking tool!
                </p>
                <?php
                $url = check_user_login() ? SITEURL . 'url-tracking' : SITEURL . 'login';
                ?>
                <a class="btn btn-colored" href="<?php echo $url; ?>">Start using URL Tracking</a>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="share__content-item-container">
                        <div class="share__content__item" data-image="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__Instagram.png'; ?>">
                            <div class="share__content__link">
                                <h3>
                                    <i class='bx bxl-instagram'></i>
                                    Instagram photos, videos, stories and reels
                                </h3>
                                <i class="bx bx-chevron-down"></i>
                            </div>
                            <div class="share__content">
                                <p>
                                    Download Instagram photos, videos, stories, and reels in high quality. Perfect for repurposing and sharing engaging content across your social platforms. Keep your audience hooked with fresh, visually appealing posts.
                                </p>
                                <p>
                                    Whether it’s a stunning photo, a trending reel, or a behind-the-scenes story, easily save and share Instagram content to boost your social media presence.
                                </p>
                                <button class="btn btn__underline__text bly">Read our documentation <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="share__content__item" data-image="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__Pinterest.png'; ?>">
                            <div class="share__content__link">
                                <h3>
                                    <i class='bx bxl-tiktok'></i>
                                    TikTok videos without a watermark.
                                </h3>
                                <i class="bx bx-chevron-down"></i>
                            </div>
                            <div class="share__content">
                                <p>
                                    Save TikTok videos without watermarks for a clean, professional look. Easily share them on other platforms to boost your reach.
                                </p>
                                <p>
                                    From viral trends to creative clips, download TikTok videos seamlessly and repurpose them to captivate your audience across all channels.
                                </p>
                                <button class="btn btn__underline__text bly">Check latest update <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="share__content__item" data-image="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__Youtube.png'; ?>">
                            <div class="share__content__link">
                                <h3>
                                    <i class='bx bxl-youtube'></i>
                                    Youtube videos and shorts
                                </h3>
                                <i class="bx bx-chevron-down"></i>
                            </div>
                            <div class="share__content">
                                <p>
                                    Download YouTube videos and shorts effortlessly. Share them natively on your social accounts to keep your audience hooked.
                                </p>
                                <button class="btn btn__underline__text bly">Start creating videos <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="share__content__item" data-image="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__Facebook.png'; ?>">
                            <div class="share__content__link">
                                <h3>
                                    <i class='bx bxl-facebook-square'></i>
                                    Facebook videos
                                </h3>
                                <i class="bx bx-chevron-down"></i>
                            </div>
                            <div class="share__content">
                                <p>
                                    Extract Facebook posts and videos in seconds. Repurpose them for your campaigns or social feeds to maximize engagement.
                                </p>
                                <p>
                                    From inspiring posts to engaging videos, save and share Facebook content to connect with your audience and grow your online presence.
                                </p>
                                <button class="btn btn__underline__text bly">Explore more <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="share__content__item" data-image="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__LinkedIN.png'; ?>">
                            <div class="share__content__link">
                                <h3>
                                    <i class='bx bxl-linkedin'></i>
                                    LinkedIn Videos & Posts
                                </h3>
                                <i class="bx bx-chevron-down"></i>
                            </div>
                            <div class="share__content">
                                <p>
                                    Download LinkedIn posts and share them across platforms. Enhance your professional presence with consistent, high-quality content.
                                </p>
                                <button class="btn btn__underline__text bly">Read our documentation <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="share__content__item" data-image="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__Twitter.png'; ?>">
                            <div class="share__content__link">
                                <h3>
                                    <i class='bx bxl-twitter'></i>
                                    Twitter photos and videos
                                </h3>
                                <i class="bx bx-chevron-down"></i>
                            </div>
                            <div class="share__content">
                                <p>
                                    Save Twitter photos and videos quickly. Share them natively to keep your audience engaged and your content fresh.
                                </p>
                                <p>
                                    From eye-catching visuals to trending clips, download and repurpose Twitter content to amplify your social media impact.
                                </p>
                                <button class="btn btn__underline__text bly">Get started <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </div>
                        <button class="btn btn-featured">Start repurposing content</button>
                    </div>
                </div>
                <div class="d-none d-lg-flex col-12 col-md-6 col-lg-7">
                    <div class="featured-images">
                        <img id="dynamic-image" src="<?php echo NewLandingAssets . 'images/URL__Link_Shortner__Instagram.png'; ?>" alt="Dynamic Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule -->
<div id="schedule" class="py-24 container-fluid bg-img-holder">
    <div class="container">
        <div class="col-12">
            <div class="text-wrapper align-items-center justify-content-center text-center">
                <h2>
                    Schedule your social media posts
                </h2>
                <p>
                    With a suite of powerful tools and a user-friendly interface, you will be able to craft, preview,
                    <br class="d-none d-md-flex">
                    schedule, and analyze your online content with ease.
                </p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="container img-container-center">
            <img src="<?php echo NewLandingAssets . 'images/composer.png'; ?>" class="h-100 w-100">
        </div>
    </div>
</div>

<!-- Map Container Area -->
<div class="container-fluid position-relative py-24 my-48">
    <div class="container p-0 position-relative">
        <div class="text-wrapper center">
            <h2>
                Unified URL Tracking Solutions
                <br class="d-none d-md-block">
                in a Single Platform
            </h2>
            <!-- <p>
                Adublisher streamlines your workflow by allowing you to post, schedule, analyze, and monitor all your social media accounts 
                <br class="d-none d-md-block">
                from one intuitive platform. Save time, stay organized, and boost engagement effortlessly.
            </p>
            <button class="btn btn__gradient__colored"><a href="pages/users/signup.html">Get started for free</a></button> -->
        </div>
        <div class="hollowform__container">
            <div class="our-operate-container">
                <div class="operate-content">
                    <h2>Centralized Tracking Hub</h2>
                    <p>
                        Manage all URL tracking tools seamlessly in one place.
                    </p>
                </div>
                <img src="<?php echo NewLandingAssets . 'images/Centralized.png'; ?>" alt="">
            </div>
            <div class="our-operate-container">
                <div class="operate-content">
                    <h2>Real Time Analytics</h2>
                    <p>
                        Monitor live traffic, engagement, and conversions effortlessly.
                    </p>
                </div>
                <img src="<?php echo NewLandingAssets . 'images/Real__Time__URL__Analyzing.png'; ?>" alt="">
            </div>
            <div class="our-operate-container">
                <div class="operate-content">
                    <h2>Custom UTM Builder</h2>
                    <p>
                        Create and manage UTM parameters for accurate tracking.
                    </p>
                </div>
                <img src="<?php echo NewLandingAssets . 'images/UTM-Management.png'; ?>" alt="">
            </div>
            <div class="our-operate-container">
                <div class="operate-content">
                    <h2>Cross Platform Integration</h2>
                    <p>
                        Track performance across social media, email, and ads.
                    </p>
                </div>
                <img src="<?php echo NewLandingAssets . 'images/Compatibility__Check.png'; ?>" alt="">
            </div>
        </div>
    </div>
    <div class="blur-6"></div>
</div>


<!-- Testimonials -->
<div class="container-fluid bg-dark-globe p-0 overflow-hidden p-5">
    <div class="container py-150-150 text-center justify-content-center">
        <div class="row">
            <div class="col-12 p-0 m-0">
                <div class="text-wrapper center">
                    <h2>
                        Trusted by Agencies and Brands Worldwide
                    </h2>
                    <p>
                        Adublishers is part of daily lives of thousands of social media marketers
                        <br class="d-none d-md-block">
                        and highly recoomended for it's capabilities.
                    </p>
                    <div class="user-pic-holder">
                        <img src="<?php echo NewLandingAssets . 'images/Users-pics.png'; ?>">
                    </div>
                    <div class="buttons__area">
                        <button class="btn btn__darkbg-white"><a href="pages/users/signup.html">Get started for free</a></button>
                        <button class="btn btn-colored dark__shader"><a href="pages/users/signup.html">Join community</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Browser Integrations -->
<div class="container-fluid py-24">
    <div class="container py-24">
        <div class="col-12">
            <div class="text-wrapper center">
                <h2>
                    Social Media Across Multiple Browsers
                </h2>
                <p>
                    Enjoy a smooth, browser-optimized experience for all your social media needs!
                </p>
            </div>
        </div>
        <div class="row pb-5">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="review-container left">
                    <img src="<?php echo NewLandingAssets . 'images/Chrome__Icon.png'; ?>">
                    <h3>Google Chrome</h3>
                    <p>
                        Adublisher works seamlessly on Chrome, offering fast performance for creating, scheduling, and managing social media posts effortlessly.
                    </p>
                    <a href="#">Install now</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="review-container left">
                    <img src="<?php echo NewLandingAssets . 'images/Edge__Icon.png'; ?>">
                    <h3>Mozilla Firefox</h3>
                    <p>
                        Adublisher is optimized for Firefox, providing secure browsing and efficient scheduling for all your social media accounts.
                    </p>
                    <a href="#">Install now</a>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="review-container left">
                    <img src="<?php echo NewLandingAssets . 'images/Safari__Icon.png'; ?>">
                    <h3>Safari</h3>
                    <p>
                        Adublisher runs flawlessly on Safari, delivering a smooth, user-friendly experience for managing and analyzing social media posts.
                    </p>
                    <a href="#">Install now</a>
                </div>
            </div>
            <div class="col-12 p-0">
                <div class="adublisher__view">
                    <div class="boost__img">
                        <img src="<?php echo NewLandingAssets . 'images/Booster__arrow.png'; ?>">
                    </div>
                    <div class="adublisher__boost">
                        <h3>
                            Simplify Social Media Scheduling and
                            <br class="d-none d-lg-flex">
                            Publishing Effortlessly
                        </h3>
                        <button class="btn btn-colored">Start 14-days Free Trial</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="custom_parameter" style="display:none;">
    <div class="form-group d-flex">
        <div class="col-2">
            <input type="text" name="tracking_tag[]" value="Tracking tag"
                class="form-control border-0 bg-transparent tracking_tag">
        </div>
        <div class="col-3">
            <select name="tracking_tag_value[]" class="form-control tracking_tag_value">
                <option value="social_network">Social Network</option>
                <option value="social_profile">Social Profile</option>
                <option value="custom" selected>Custom Value</option>
            </select>
        </div>
        <div class="col-2 tracking_tag_custom_value mx-1" style="display:block;">
            <input type="text" name="tracking_tag_custom_value[]" placeholder="Custom Value"
                class="form-control border tracking_tag_custom_val" value="Adublisher">
        </div>
        <div class="col-2" style="text-align:center; align-content:center;">
            <span class="remove_custom text-danger" style="cursor:pointer;">
                <i class="fa fa-trash"></i>
            </span>
        </div>
    </div>
</div>
<!-- landing page faq -->
<?php $this->load->view('templates/publisher/client_side/landing-faq-new'); ?>
<!-- landing page newsletter -->
<?php $this->load->view('templates/publisher/client_side/landing-newsletter-new'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo GeneralAssets . 'plugins/clipboard-master/clipboard.min.js'; ?>"></script>
<script>
    $(document).ready(function() {
        var clipboard = '';
        var utm_tracking = false;
        var auth = $('.auth').val();
        var tooltip = function(id) {
            $('#' + id).show().fadeOut(3500);
        }
        $('#shorten_link').on('submit', function(e) {
            e.preventDefault();
            var url = $("#url").val();
            var utm = utm_tracking ? '1' : '0';
            var user_id = $('.user_id').val();
            $.ajax({
                type: "POST",
                url: "https://adub.link/short_my_link",
                // url: "<?php echo SITEURL . 'short_my_link'; ?>",
                data: {
                    'url': url,
                    'utm': utm,
                    'user_id': user_id
                },
                dataType: "json",
                success: function(response) {
                    $("#shorted_link_container").html("");
                    if (response.status) {
                        $("#shorted_link_container").addClass('url-shortner mx-auto p-0');
                        $("#shorted_link_container").html(
                            '<div class="col-md-12">' +
                            '<div class="features-single p-3 mb-2" >' +
                            '<div class="content mb-0 pl-4 pr-3 pt-1">' +
                            '<h4 class="click_to_copy_url pointer" title="copy shorten url" data-clipboard-text="' + response.link + '" >' + response.link + '</h4>' +
                            '<div id="url_tooltip"><span class="tooltiptext">Link Copied!</span></div>' +
                            '<p style="color: #555;">' + response.alias + '</p>' +
                            '</div>' +
                            '<div class="icon pr-0 click_to_copy pointer" title="copy shorten url" data-clipboard-text="' + response.link + '">' +
                            '<div id="icon_tooltip"><span class="tooltiptext">Link Copied!</span></div>' +
                            '<i class="icofont-copy"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                        var clipboard = new ClipboardJS('.click_to_copy');
                    } else {
                        $("#shorted_link_container").html(
                            '<div class="col-md-12">' +
                            '<div class="features-single p-3 mb-2" style="border-bottom: 2px solid #f44336;">' +
                            '<div class="content mb-0 pl-4 pr-3 pt-1">' +
                            '<h4 class="text-danger" >Something Went Wrong</h4>' +
                            '<p class="text-danger">' + response.message + '</p>' +
                            '</div>' +
                            '<div class="icon pr-0">' +
                            '<i class="icofont-error text-danger"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                    }
                }
            });
        });
        $(document).on('click', '.click_to_copy_url', function() {
            tooltip('url_tooltip');
        });
        $(document).on('click', '.click_to_copy', function() {
            tooltip('icon_tooltip');
        });
        $('#toggleButton').on('click', function() {
            var check = $(this).hasClass('active');
            var auth = $('.auth').val();
            if (check) {
                if (auth == '1') {
                    utm_tracking = true;
                } else {
                    $(this).removeClass('active');
                    window.open(
                        '<?php echo SITEURL . 'login'; ?>',
                        '_blank' // <- This is what makes it open in a new window.
                    );
                }
            } else {
                utm_tracking = false;
            }

        });
    });
</script>