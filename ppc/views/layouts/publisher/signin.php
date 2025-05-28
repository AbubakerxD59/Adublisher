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
                    <ul class="nav navbar-nav flex-row justify-content-center flex-nowrap download-btn">
                    <li class="nav-item"><a class="nav-link" href="<?=SITEURL?>signup"><i class="icofont-hand-drawn-right mr-1"></i> Create Account</a></li>
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
                        <h2 class="text-white">Sign In</h2>
                        <p>Don't have an account? <a href="<?=SITEURL?>signup" class="text-warning m-l-5"><b>Create Account</b></a></p>
                    </div>
                </div>
                <!--end section heading-->
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 ">
                    <div class="contact-form">
                        <form id="ajax-contact" action="#" method="post">
                            <div class="row">
                            <div class="form-group col-md-12">
                            <label for="Username"> Email</label>
                                <input class="form-control " type="text" required placeholder="Username" name="Username" id="Username" data-error="username is required." value="<?=@$_GET['username'];?>"> 
                            <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-md-12">
                            <label for="Password"> Password</label>
                                <input class="form-control" type="password" required placeholder="Password" name="Password" id="Password" data-error="password is required."> </div>
                            <div class="help-block with-errors">

                            </div>
                            
                            <div class="contact-btn text-left col-md-6 mt-5">
                                <button class="" type="button" id="submit">Log In</button>
                            </div>
                            <div class="col-md-6 text-right mt-5">
                                <p class="text-right">Forgot Password? <a href="<?=SITEURL?>forgot" class="text-info m-l-5"><b>Click here</b></a></p>
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
