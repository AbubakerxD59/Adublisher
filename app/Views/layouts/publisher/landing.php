<?php $this->load->view('templates/publisher/landing-header'); ?>
<style>
    .pointer{
        cursor: pointer;
    }
</style>
<body>
    <!--start header-->
    <header id="header">
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-lg justify-content-center">
                <a class="logo" href="<?=SITEURL?>"><img src="<?=PubLandingpageAssets ?>/images/logo.png" alt="logo"></a>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#NavbarContent">
                    <span class="icofont-navigation-menu"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="NavbarContent">
                    <ul class="navbar-nav mx-auto text-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?=SITEURL?>" data-scroll-nav="0">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-scroll-nav="1">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-scroll-nav="2">Features</a>
                        </li>
                       <!-- <li class="nav-item">
                            <a class="nav-link" href="#" data-scroll-nav="4">Testimonial</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-scroll-nav="5">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://blog.adublisher.com" target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=SITEURLMM?>/contact">Contact</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav flex-row justify-content-center flex-nowrap download-btn">
                    <li class="nav-item"><a class="nav-link" href="<?=SIGNIN?>"><i class="icofont-login mr-1"></i> Sign In</a></li>
                    <li class="nav-item"><a class="nav-link" href="#product-area"><i class="icofont-hand-drawn-right mr-1"></i> Start Free Trial</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!--end header-->
    <!--start home area-->
    <section id="home-area" data-scroll-index="0" style="background-image: url(<?=PubLandingpageAssets ?>/images/banner-1.png)">
        <div class="container">

            <div class="row caption">
               
                <!--start caption-->
                <div class="col-lg-6 col-md-7 ">
                    <div class=" d-table mt-10">
                        <div class="d-table-cell align-middle">
                            <h1 class="pt-5 mt-5">Automatically grow & monetise your facebook page while you sleep</h1>
                            <p></p>
                            <a  href="#product-area"><i class="icofont-hand-drawn-right"></i> Start Free Trial</a>
                            <a  href="<?=SITEURL?>signin"><i class="icofont-login"></i> Sign In</a>
                            
                        </div>
                    </div>
                </div>
                 <!--start caption image-->
                 <div class="col-lg-6 col-md-5 ">
                    <div class="caption-img text-center d-table mt-10">
                        <div class="d-table-cell align-middle">
                            <img src="<?=PubLandingpageAssets ?>/images/adublisher-11.png" class="img-fluid pt-5 mt-5" alt="">
                            
                        </div>
                    </div>
                </div>
                <!--end caption image-->
                <div class="col-lg-12 col-md-12">
                    <div class="newsletter-form mt-3">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="newsletter-form">
                                    <form action="#" method="post" id="shorten_link">
                                        <input type="url" id="url" class="form-control" required placeholder="Shorten your link">
                                        <button type="submit" class="pr-5 pl-5">Shorten</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="shorted_link_container" > 
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
    <!--end home area-->
    <!--start about area-->
    <section id="about-area" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <!--start about content-->
                <div class="col-lg-6 col-md-7">
                    <div class="about-content">
                        <h5>About Bulk Upload</h5>
                        <h2>Schedule For Months In Minutes.</h2>
                        <p>Use our bulk upload feature to upload 100s of images together and schedule unlimited posts on your facebook page in just few minutes.</p>
                        <p>Gain more organic likes, organic engagement and organic shares on facebook.</p>
                        <div class="row about-info">
                            <!--start about info single-->
                            <div class="col-md-4 p-md-1">
                                <div class="about-info-single">
                                    <i class="icofont-layers"></i>
                                    <h6>More Likes</h6>
                                </div>
                            </div>
                            <!--end about info single-->
                            <!--start about info single-->
                            <div class="col-md-4 p-md-1">
                                <div class="about-info-single">
                                    <i class="icofont-electron"></i>
                                    <h6>More Enagement</h6>
                                </div>
                            </div>
                            <!--end about info single-->
                            <!--start about info single-->
                            <div class="col-md-4 p-md-1">
                                <div class="about-info-single">
                                    <i class="icofont-chart-pie-alt"></i>
                                    <h6>More Shares</h6>
                                </div>
                            </div>
                            <!--end about info single-->
                        </div>
                    </div>
                </div>
                <!--end about content-->
                <!--start about image-->
                <div class="col-lg-6 col-md-5">
                    <div class="about-img text-center">
                        <img src="<?=PubLandingpageAssets ?>/images/adublisher-2.png" class="img-fluid" alt="">
                    </div>
                </div>
                <!--end about image-->
            </div>
        </div>
    </section>
    <!--end about area-->
    <!--start features area-->
    <section id="features-area" data-scroll-index="2">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Features</h5>
                        <h2>YouTube Integration</h2>
                        <span><i class="fa-brands fa-youtube text-danger" style="font-size:50px;"></i></span>
                        <p>Effortlessly connect your YouTube account for a streamlined video management experience.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <!--start feature single-->
                <div class="col-md-6">
                    <div class="features-single">
                        <div class="icon">
                            <i class="fa fa-video"></i>
                        </div>
                        <div class="content">
                            <h4>Direct Video Uploading</h4>
                            <p>Upload your videos directly to your YouTube channel, saving you time and hassle.</p>
                        </div>
                    </div>
                </div>
                <!--end feature single-->
                <!--start feature single-->
                <div class="col-md-6">
                    <div class="features-single">
                        <div class="icon">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div class="content">
                            <h4>Scheduled Uploads</h4>
                            <p>Plan and schedule your video uploads in advance to optimize your content release strategy.</p>
                        </div>
                    </div>
                </div>
                <!--end feature single-->
                <!--start feature single-->
                <div class="col-md-6">
                    <div class="features-single">
                        <div class="icon">
                            <i class="fa fa-image"></i>
                        </div>
                        <div class="content">
                            <h4>Custom Thumbnail</h4>
                            <p>Design and upload unique thumbnails for your videos to enhance visual appeal and engagement.</p>
                        </div>
                    </div>
                </div>
                <!--end feature single-->
                <!--start feature single-->
                <div class="col-md-6">
                    <div class="features-single">
                        <div class="icon">
                            <i class="fa fa-code"></i>
                        </div>
                        <div class="content">
                            <h4>Comprehensive Metadata</h4>
                            <p>Customize your video's metadata to improve search visibility and audience targeting.</p>
                        </div>
                    </div>
                </div>
                <!--end feature single-->
            </div>
        </div>
    </section>
    <!--end features area-->
    <!--start why choose area-->
    <section id="why-choose-area">
        <div class="container">
            <div class="row">
                <!--start why chosse image-->
                <div class="col-md-5">
                    <div class="why-choose-img d-table text-center">
                        <div class="d-table-cell align-middle">
                            <img src="<?=PubLandingpageAssets ?>/images/rss.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <!--end why chosse image-->
                <div class="col-md-7">
                    <div class="section-heading">
                        <h2 class="text-white">Fetch Rss</h2>
                        <p class="text-white">Autopost rss feeds on your facebook page. You can also traffic traffic summary for rss feeds in your dashboard.</p>
                    </div>
                    <!--start why choose single-->
                    <div class="why-choose-single row">
                        <div class="col-md-6">
                            <div class="content text-center">
                                <i class="icofont-diamond"></i>
                                <h4>Auto Fetch</h4>
                                <p>Simply paste Rss feed url to auto fetch the feeds.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="content text-center">
                                <i class="icofont-truck-loaded"></i>
                                <h4>Auto Schedule</h4>
                                <p>Select and save post times for your Rss feeds.</p>
                            </div>
                        </div>
                    </div>
                    <!--end why choose single-->
                    <!--start why choose single-->
                    <div class="why-choose-single row">
                        <div class="col-md-6">
                            <div class="content text-center">
                                <i class="icofont-cart"></i>
                                <h4>Select Page</h4>
                                <p>Post Rss feeds on unlimiated pages.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="content text-center">
                                <i class="icofont-support"></i>
                                <h4>Auto Post On Facebook</h4>
                                <p>Your Rss feeds get Scheduled and published on facebook page automatically.</p>
                            </div>
                        </div>
                    </div>
                    <!--end why choose single-->
                </div>
            </div>
        </div>
    </section>
    <!--end why choose area-->
    <!--start core feature area-->
    <section id="core-feat-area">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Core Features</h5>
                        <h2>Hire Affiliates</h2>
                        <p>Create your own affiliate network to hire and manage affiliates to make more money through your links.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <!--start core feature box-->
                <div class="col-md-4">
                    <div class="core-feat-single">
                        <i class="icofont-snapchat"></i>
                        <h4>Define PPC Rates</h4>
                        <p>You can assign PPC rates for each affiliate separately.</p>
                    </div>
                    <div class="core-feat-single">
                        <i class="icofont-chat"></i>
                        <h4>Add Unlimited Domains</h4>
                        <p>Add as many domains as you want in your campaigns.</p>
                    </div>
                </div>
                <!--end core features box-->
                <!--start core feature image-->
                <div class="col-md-4">
                    <div class="core-feat-img text-center">
                        <img src="<?=PubLandingpageAssets ?>/images/adublisher-4.png" class="img-fluid" alt="">
                    </div>
                </div>
                <!--end core features image-->
                <!--start core feature box-->
                <div class="col-md-4">
                    <div class="core-feat-single left">
                        <i class="icofont-ui-video-message"></i>
                        <h4>Assign Domains To Affiliates</h4>
                        <p>You can assign any single or multiple domains to any affiliate.</p>
                    </div>
                    <div class="core-feat-single left">
                        <i class="icofont-ui-call"></i>
                        <h4>Assign Redirect Domains</h4>
                        <p>You can create redirect domains for your affiliates to avoid spam.</p>
                    </div>
                </div>
                <!--end core features box-->
            </div>
        </div>
    </section>
    <!--end core feature area-->
    <!--start video area-->
    <section id="video-area">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Adublisher Demo</h5>
                        <h2>Watch A Quick Demo</h2>
                        <p>Watch how easy it is.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <!--start video box-->
                <div class="col-lg-10 offset-lg-1">
                    <div class="video-box">
                        <div class="video-content text-center">
                            <div class="video-overlay"></div>
                            <a class="popup-video" href="https://www.youtube.com/watch?v=nN_b3tT_xXo"><i class="icofont-ui-play"></i></a>
                        </div>
                    </div>
                </div>
                <!--sendtart video box-->
            </div>
        </div>
    </section>
    <!--end video area-->
    <!--start product area-->
    <section id="product-area" data-scroll-index="3">
        <div class="container pricing">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Subscribe</h5>
                        <h2>You Deserve better, You Deserve Adublisher</h2>
                        <p>Just give it a try, its FREE.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
            <?php

            foreach($packages as $key => $row){
              ?>
           
            <div class="col-lg-3 col-md-6 ">
              <div class="card mb-5 mb-lg-0">
                <div class="card-body ">
                  <h5 class="card-title text-success text-uppercase text-center"><?=$row->title;?></h5>
                  <h6 class="card-price text-center">$<?=$row->price;?><span class="period">/Month</span></h6>
                  <hr>
                  <ul class="fa-ul">
                    <?php 
                    foreach($row->features as $inKey => $feature){
                      $class="fa-check text-success";
                      if($feature['status'] != "active"){
                        $class="fa-times text-danger";
                      }
                      if($feature['limit'] == 0){
                        $feature['limit'] = '';
                    }
                      echo '<li><span class="fa-li"><i class="fas '.$class.'"></i></span><strong>'.$feature['limit'].' '.$feature['name'].'</strong></li>';
                     }
                    ?>
                    </ul>

                     <div class="text-center">
                      <a class="button" href="<?=SIGNUP?>?trial=true&package_=<?=$row->title;?>&package=<?=$row->id;?>"><i class="icofont-stylish-right"></i>
                        <?php if($row->title == 'Basic'){
                            echo 'Start for free';
                        }
                        else{
                            echo 'Start free trial';
                        }
                        ?>
                      </a>
                      </div>
                    <?php 
                    /*<form action="<?=SITEURL?>subscription/create" method="post" class="frmStripePayment">
                        <input name="plan" type="hidden" value="<?=$row->name;?>" />         
                        <input name="interval" type="hidden" value="month" />         
                        <input name="price" type="hidden" value="<?=$row->price;?>" />         
                        <input name="currency" type="hidden" value="usd" />
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="<?php echo STRIPE_PUBLISHABLE_KEY; ?>"
                            data-name="<?=$row->name;?>"
                            data-description="<?=$row->name;?>"
                            data-panel-label="Pay Now"
                            data-label="Sign Up"
                            data-locale="auto">
                        </script>
                    </form>
                    */
                ?>
                </div>
              </div>
            </div>
         <?php 
         }
        ?>

            </div>
        </div>
    </section>
    <!--end product area-->
    <!--start newsletter area-->
    <section id="newsletter-area">
        <div class="container">
            <div class="newsletter-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="newsletter-cont">
                            <h2 class="text-white m-0">Subscribe Our Newsletter</h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="newsletter-form">
                            <form action="#" method="post">
                                <input type="email" class="form-control" placeholder="Write Your Email">
                                <button type="submit">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end newsletter area-->
    <!--start testimonial area-->
    <section id="testimonial-area" data-scroll-index="4">
        <div class="container">
            <div class="row">
                <!--start heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Testimonial</h5>
                        <h2>Client's Feedback</h2>
                        <p>We constantly receive positive feedback.</p>
                    </div>
                </div>
                <!--end heading-->
            </div>
            <!--start testimonial carousel-->
            <div class="testi-carousel owl-carousel">
                <!--start testimonial single-->
                <div class="testi-single">
                    <div class="client-comment">
                        <p>I have been using Adublisher from past 2 years. Since then i have been able to successfully grow many of my facebook pages. What i really like as Social media manager is the ease to schedule content for months in advance in minutes.</p>
                        <p><span><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></span></p>
                    </div>
                    <div class="client-details">
                        <div class="client-info">
                            <img src="<?=PubLandingpageAssets ?>/images/thomas.jpg" class="img-fluid" alt="">
                            <h5>Adam Smith</h5>
                            <p>Social Media Manager</p>
                        </div>
                        <div class="quote">
                            <i class="icofont-quote-right"></i>
                        </div>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="testi-single">
                    <div class="client-comment">
                        <p>What makes Adublisher so unique is that one hand you can manage, grow, and monetise your social media. And on the other hand you hire affiliates to promote your content. As an affiliate marketer this feature has helped me so much and i made thousands of extra buck because of being able to hire more affiliates so easily.</p>
                        <p><span><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></span></p>
                    </div>
                    <div class="client-details">
                        <div class="client-info">
                            <img src="<?=PubLandingpageAssets ?>/images/shane.jpg" class="img-fluid" alt="">
                            <h5>Shane Thomas</h5>
                            <p>Affiliate Marketer</p>
                        </div>
                        <div class="quote">
                            <i class="icofont-quote-right"></i>
                        </div>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="testi-single">
                    <div class="client-comment">
                        <p>I haven't seen a mixture of such amazing features on any other platform. Organically growing my facebook page while not working so hard for it has given me the immense satisfaction.</p>
                        <p><span><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></span></p>
                    </div>
                    <div class="client-details">
                        <div class="client-info">
                            <img src="<?=PubLandingpageAssets ?>/images/emma.jpg" class="img-fluid" alt="">
                            <h5>Emma Smith</h5>
                            <p>Affiliate Marketer</p>
                        </div>
                        <div class="quote">
                            <i class="icofont-quote-right"></i>
                        </div>
                    </div>
                </div>
                <!--end testimonial single-->
                <!--start testimonial single-->
                <div class="testi-single">
                    <div class="client-comment">
                        <p>I have been a permanent member since i started in 2017. What i really like about Adublisher is that its so easy to use and basically it helps me to do everything on autopilot.</p>
                        <p><span><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></span></p>
                    </div>
                    <div class="client-details">
                        <div class="client-info">
                            <img src="<?=PubLandingpageAssets ?>/images/client-2.jpg" class="img-fluid" alt="">
                            <h5>Sopia Smith</h5>
                            <p>Product Researcher</p>
                        </div>
                        <div class="quote">
                            <i class="icofont-quote-right"></i>
                        </div>
                    </div>
                </div>
                <!--end testimonial single-->
            </div>
            <!--end testimonial carousel-->
        </div>
    </section>
    <!--end testimonial area-->
    <!--start faq area-->
    <section id="faq-area" data-scroll-index="5">
        <div class="container">
            <div class="row">
                <!--start heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>FAQ</h5>
                        <h2>Frequently Asked Questions</h2>
                        <p>Here is a list of most frequently asked questions.</p>
                    </div>
                </div>
                <!--end heading-->
            </div>
            <div class="row">
                <!--start faq accordian-->
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div id="accordion" role="tablist">
                        <!--start faq single-->
                        <div class="card">
                            <div class="card-header active" role="tab" id="faq1">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">Do You Offer A Free Trial?</a>
                                </h5>
                            </div>
                            <div id="collapse1" class="collapse show" role="tabpanel" aria-labelledby="faq1" data-parent="#accordion">
                                <div class="card-body">Yes, You get free trial for 7 days. During that time you can test each feature that Adublisher offers.</div>
                            </div>
                        </div>
                        <!--end faq single-->
                        <!--start faq single-->
                        <div class="card">
                            <div class="card-header" role="tab" id="faq2">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false" aria-controls="collapse2">Can I Get Refund If i Am Not Satisfied?</a>
                                </h5>
                            </div>
                            <div id="collapse2" class="collapse" role="tabpanel" aria-labelledby="faq2" data-parent="#accordion">
                                <div class="card-body">If you are not satified with your memebership then you can cancel your membership anytime and get full refund.</div>
                            </div>
                        </div>
                        <!--end faq single-->
                        <!--start faq single-->
                        <div class="card">
                            <div class="card-header" role="tab" id="faq3">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false" aria-controls="collapse3">How Are Better Than Other Platforms, Why Should I Subscribe?</a>
                                </h5>
                            </div>
                            <div id="collapse3" class="collapse" role="tabpanel" aria-labelledby="faq3" data-parent="#accordion">
                                <div class="card-body">Adublisher offers a very unique set of features. We take care of each aspect of your business. From automatic scheduling of your facebook page to organic increase in your page likes to monetising your facebook page on auto also. We offer you all those tools. Simply link your facebook page and let the adublisher do rest for you.</div>
                            </div>
                        </div>
                        <!--end faq single-->
                        <!--start faq single-->
                        <div class="card">
                            <div class="card-header" role="tab" id="faq4">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false" aria-controls="collapse4">How can I get refund?</a>
                                </h5>
                            </div>
                            <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="faq4" data-parent="#accordion">
                                <div class="card-body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra,
                                    tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.</div>
                            </div>
                        </div>
                        <!--end faq single-->
                    </div>
                </div>
                <!--end faq accordian-->
            </div>
        </div>
    </section>
    <!--end faq area-->
    <!--start blog area
    <section id="blog-area" data-scroll-index="6">
        <div class="container">
           
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                <div class="section-heading text-center">
                    <h5>Up To Date</h5>
                    <h2>Our Latest News</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis.</p>
                </div>
            </div>
           
            <div class="row">
            
                <div class="col-md-4">
                    <div class="blog-single">
                        <a href="blog-single.html"><img src="<?=PubLandingpageAssets ?>/images/blog-1.jpg" class="img-fluid" alt=""></a>
                        <div class="post-content">
                            <h6 class="m-0">By: <a href="">Admin</a><small>/</small><a href="">25 Jun, 2018</a></h6>
                            <h3 class="m-0"><a href="blog-single.html">How To Install Watch Apps</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati eveniet porro tenetur omnis saepe vitae sapiente eum consectetur.</p>
                        </div>
                    </div>
                </div>
              
                <div class="col-md-4">
                    <div class="blog-single">
                        <a href="blog-single.html"><img src="<?=PubLandingpageAssets ?>/images/blog-2.jpg" class="img-fluid" alt=""></a>
                        <div class="post-content">
                            <h6 class="m-0">By: <a href="">Admin</a><small>/</small><a href="">28 Jun, 2018</a></h6>
                            <h3 class="m-0"><a href="blog-single.html">How To Active All Features </a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati eveniet porro tenetur omnis saepe vitae sapiente eum consectetur.</p>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="blog-single">
                        <a href="blog-single.html"><img src="<?=PubLandingpageAssets ?>/images/blog-3.jpg" class="img-fluid" alt=""></a>
                        <div class="post-content">
                            <h6 class="m-0">By: <a href="">Admin</a><small>/</small><a href="">30 Jun, 2018</a></h6>
                            <h3 class="m-0"><a href="blog-single.html">How To Chat With Users</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati eveniet porro tenetur omnis saepe vitae sapiente eum consectetur.</p>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    </section>
  end blog area-->
    <section id="contact-area" data-scroll-index="7">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                        <h5>Need Help?</h5>
                        <h2 class="text-white">Contact Us</h2>
                        <p>Send us an email or simply start a chat.</p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="contact-form">
                        <form id="ajax-contact" action="contact.php" method="post">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name*" required="required" data-error="name is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email*" required="required" data-error="valid email is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="message" name="message" rows="10" placeholder="Write Your Message*" required="required" data-error="Please, leave us a message."></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="contact-btn text-center">
                                <button type="submit">Submit</button>
                            </div>
                            <div class="messages"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('templates/publisher/landing-footer'); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#shorten_link').submit(function(e) {
        e.preventDefault();
        var url = $("#url").val();
        $.ajax({
            type: "POST",
            url: "<?php echo ADUBSHORTLINK;?>short_my_link",
            data: {'url':url},
            dataType: "json",
            success: function(response) {
                $("#shorted_link_container").html("");
                if (response.status) {
                    console.log(response);
                    $("#shorted_link_container").html(
                    '<div class="col-md-12">'+
                        '<div class="features-single p-3 mb-2" >'+
                            '<div class="content mb-0 pl-4 pr-3 pt-1">'+
                                '<h4 class="click_to_copy pointer" title="copy shorten url" data-clipboard-text="'+response.link+'" >'+response.link+'</h4>'+
                                '<p style="color: #555;">'+url+'</p>'+
                            '</div>'+
                            '<div class="icon pr-0 click_to_copy pointer" title="copy shorten url" data-clipboard-text="'+response.link+'">'+
                                '<i class="icofont-copy"></i>'+
                            '</div>'+
                        '</div>'+
                    '</div>');
                var clipboard = new ClipboardJS('.click_to_copy');
                }else{

                    $("#shorted_link_container").html(
                    '<div class="col-md-12">'+
                    '<div class="features-single p-3 mb-2" style="border-bottom: 2px solid #f44336;">'+
                    '<div class="content mb-0 pl-4 pr-3 pt-1">'+
                    '<h4 class="text-danger" >Something Went Wrong</h4>'+
                    '<p class="text-danger">'+response.message+'</p>'+
                    '</div>'+
                    '<div class="icon pr-0">'+
                    '<i class="icofont-error text-danger"></i>'+
                    '</div>'+
                    '</div>'+
                    '</div>');
                   
                }
            },
            error: function() {
            alertbox("Error" , "Nothing Has been changed, try again" ,  "error");
            }
        });       
    });
});
</script>
</body>

</html>