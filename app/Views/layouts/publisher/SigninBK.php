<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=GeneralAssets ?>images/favicon.png">
    <title>Adublisher | Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=GeneralAssets ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=GeneralAssets ?>plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="<?=GeneralAssets ?>plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
   
    <!-- Custom CSS -->
    <link href="<?=PublisherAssets ?>css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?=PublisherAssets ?>css/colors/blue.css" id="theme" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
 <div id="main-wrapper">
       
        <header class="topheader" id="top" style="background: linear-gradient(to right, #543ecf 0%, #6230c7 100%);">
            <div class="fix-width">
                <nav class="navbar navbar-expand-md navbar-light p-l-0">
                    <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon" style="color:white;"></span> </button>
                    <!-- Logo will be here -->
                    <a href="javascript:void(0)">
                       <img src="assets/general/images/logo-light-text.png" alt="Home"></a>

                    <!-- This is the navigation menu -->
                    <div class="collapse navbar-collapse p-10" id="navbarNavDropdown">
                        <ul class="navbar-nav ml-auto stylish-nav">
                             <li class="nav-item">
                              <a class="nav-link js-scroll-trigger text-white" href="<?=SITEURL?>" >HOME</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger  text-white" href="<?=SITEURL?>signin" >LOGIN</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link js-scroll-trigger  text-white" href="<?=SITEURL?>signup" >SIGN UP</a>
                            </li>
                             <li class="nav-item">
                              <a class="nav-link js-scroll-trigger  text-white" href="<?=SITEURL?>terms" >TERMS AND CONDITIONS</a>
                            </li>
                        
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="padding: 5% 0;position: relative;min-height: 1000px;background: url(<?=GeneralAssets ?>images/background/network-background.jpg);background-size: cover;">     
            <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" action="index.html" method="post">
                   <a href="javascript:void(0)" class="text-center db"><img src="assets/general/images/logo-icon.png" alt="Home"><br><img src="assets/general/images/logo-text.png" alt="Home"></a>
                   
                  <br>
                  <br>
                 
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control " type="text" required placeholder="Username" name="Username" id="Username"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control " type="password" required placeholder="Password" name="Password" id="Password"> </div>
                    </div>
                   
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary  btn-block text-uppercase waves-effect waves-light" type="button" id="submit">Log In</button>
                        </div>
                    </div>
                  <!--  <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            <div class="social">
                                <a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>
                                <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>
                            </div>
                        </div>
                    </div> 
                    -->
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p class="text-center">Don't have an account? <a href="<?=SITEURL?>signup" class="text-info m-l-5"><b>Sign Up Now</b></a></p>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required placeholder="Email"> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
        
    </section>

</div>
    <input type="hidden" id="SITEURL" value="<?=SITEURL?>" />
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?=GeneralAssets ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=GeneralAssets ?>plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?=GeneralAssets ?>plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=PublisherAssets ?>js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?=PublisherAssets ?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=PublisherAssets ?>js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?=GeneralAssets ?>plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?=GeneralAssets ?>plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?=GeneralAssets ?>plugins/toast-master/js/jquery.toast.js"></script>
    <script src="<?=GeneralAssets ?>plugins/sweetalert/sweetalert.min.js"></script>
   
    <!--Custom JavaScript -->
    <script src="<?=PublisherAssets ?>js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?=PublisherAssets ?>js/publisher.js"></script>
    
</body>

</html>