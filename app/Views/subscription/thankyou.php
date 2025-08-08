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
                    <li class="nav-item"><a class="nav-link" href="<?=SITEURL?>signup"><i class="icofont-cart mr-1"></i> Create Account</a></li>
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
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center">
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                        <h2 class="text-white">Thank You!</h2>
                        <?php if(!empty($price)) { ?>
                        <h3>Successfully charged $<?php print $price;?>!</h3>
                      <?php } ?>
                      <p class="lead"><strong>Please check your email</strong> for further instructions on how to complete your account setup.</p>
                      <hr>
                      <p>
                      Having trouble? <a href="mailto:info@adublisher.com">Contact us</a>
                    </p>
                    <p class="lead">
                    <a class="btn btn-primary btn-sm" href="<?=SITEURL?>" role="button">Continue to homepage</a>
                  </p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
        </div>
    </section>
    <input type="hidden" id="SITEURL" value="<?=SITEURL?>" />
<?php $this->load->view('templates/publisher/landing-footer'); ?>
 <!--Custom JavaScript -->
 <script src="<?=PublisherAssets ?>js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
<script src="<?=PublisherAssets ?>js/publisher.js"></script>
</body>

</html>
