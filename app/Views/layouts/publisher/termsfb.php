<?php $this->load->view('templates/publisher/landing-header'); ?>
<body>
    <!--start preloader-->
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell align-middle">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
    </div>
    <!--end preloader-->
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
                       
                    </ul>
                    <ul class="nav navbar-nav flex-row justify-content-center flex-nowrap download-btn">
                    <li class="nav-item"><a class="nav-link" href="<?=SITEURL?>signin"><i class="icofont-login mr-1"></i> Sign In</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!--end header-->
    <section id="contact-area" data-scroll-index="7"  style="background-image: url(<?=PubLandingpageAssets ?>/images/banner-4.jpg)">
        <div class="container">
            <div class="row">
                <!--start section heading-->
                <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3">
                    <div class="section-heading text-center mb-3">
                       
                        <h2 class="text-white">Terms of Service ("Terms")</h2>
                        <p>Please read these Terms of Service ("Terms", "Terms of Service") carefully before using the adublisher.com website (the "Service") operated by ExtremePlanner Software, Inc. ("us", "we", or "our").</p>
                        <p>Last Updated:  <?php echo date("Y-m-d", strtotime("-7 days")); ?> </p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="contact-form">
                    <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>
                    <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>
                    <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time without notice. By continuing to access or use our Service after those revisions have been made, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service. You may always view the most recent copy of the Terms of Service here: http://adublisher.com/terms/</p>
                    <h2>Account Terms</h2>
                    <p>Each user is also responsible for the security of their account information. Do not share, or make public, any of your sensitive account and login information.</p>
                    <h2>Termination</h2>
                    <p>We reserve the right to terminate any account at any time without notice and deny future service to anyone for any reason. Upon termination, your right to use the Service will immediately cease.</p>
                    <h2>Refunds and cancelation</h2>
                    <p>You can easily cancel your subscription at any time. There are no cancellation fees, though no refunds are provided.</p>
                    <h2>General Terms</h2>
                    <p>The use of Service is at “your own risk.” The Service is offered “as is” and we makes no guarantees concerning the availability or “uptime” of the service.</p>
                    <p>We are not liable for any direct or indirect damages to users of the Service as a result of using the Service in any way.</p>
                    <p>We are not liable for the failure to enforce the Terms of Service and such incident does not negate the Terms of Service and the rights it provides.</p>
                    <p>We have no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services.</p>
                    <h2>Rights</h2>
                    <p>We do not claim ownership of any content that you post on or through the Service. Instead, you hereby grant us a non-exclusive, fully paid and royalty-free, transferable, sub-licensable, worldwide license to use the Content that you post on or through the Service.</p>
                    <p>You represent and warrant that: (i) you own the Content posted by you on or through the Service or otherwise have the right to grant the rights and licenses set forth in these Terms of Use; (ii) the posting and use of your Content on or through the Service does not violate, misappropriate or infringe on the rights of any third party, including, without limitation, privacy rights, publicity rights, copyrights, trademark and/or other intellectual property rights; (iii) you agree to pay for all royalties, fees, and any other monies owed by reason of Content you post on or through the Service; and (iv) you have the legal right and capacity to enter into these Terms of Use in your jurisdiction.</p>
                    <h2>Governing Law</h2>
                    <p>These Terms shall be governed and construed in accordance with the laws of the state of California, USA, without regard to its conflict of law provisions.</p>
                    <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>
                    <h2>Changes To These Terms</h2>
                    <p>We may update our Terms of Service from time to time. We will notify you of any changes by posting the new Terms of Service on this page.</p>
                    <p>You are advised to review this Privacy Policy periodically for any changes. Changes to these Terms or Service are effective when they are posted on this page.</p>
                      <h3>Last Updated:  <?php echo date("Y-m-d", strtotime("-7 days")); ?> </h3>
                  </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('templates/publisher/landing-footer'); ?>
 <!--Custom JavaScript -->
 <script src="<?=PublisherAssets ?>js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
</body>

</html>
