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
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                    <div class="section-heading text-center mb-3">
                       
                        <h2 class="text-white">Recover Your Password</h2>
                        <p>Already have an account? <a href="<?=SITEURL?>signin" class="text-warning m-l-5"><b>Sign In</b></a></p>

                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 mb-5">
                    <div class="contact-form">
                        <form class="form-horizontal form-material" id="forgotform" method="post">                   
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="email"> Email</label>
                                    <input class="form-control" type="email" name="email" id="email" required placeholder="Enter registered email address">
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <div class="col-xs-12 contact-btn text-center">
                                   
                                    <div id="small_loader" style="display:none;"><i class="fa fa-spinner fa-spin fa-2x fa-fw margin-bottom"></i></div>
                                    <br>
                                    <button class="" type="button" id="forgot"><i class="fa fa-mail-forward" aria-hidden="true"></i> Sumbit request</button>
                                </div>
                            </div>
                           
                        </form>
                        </div>
                </div>
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

           