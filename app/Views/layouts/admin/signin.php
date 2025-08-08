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
    <title>Admin | Signin</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=GeneralAssets ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=AdminAssets ?>css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?=AdminAssets ?>css/colors/purple.css" id="theme" rel="stylesheet">
      <link href="<?=GeneralAssets ?>plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url(<?=GeneralAssets ?>images/background/login-register.jpg);">        
            <div class="login-box card" style="background-color: rgba(255, 255, 255, 0.2);">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform"  novalidate>
                <a href="javascript:void(0)" class="text-center db"><img src="assets/general/images/logo-icon.png" alt="Home"><br><img src="assets/general/images/logo-text.png" alt="Home"></a>

                  <br>
                  <br>
                    <div class="form-group ">
                        <div class="col-xs-12">
                        <input class="form-control text-white" type="text" name="username" id="username"  required placeholder="Username"  >

                     </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control text-white" name="password" id="password" type="password" required placeholder="Password">  </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                  
                    
                </form>
            </div>
          </div>
        </div>
        
    </section>
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
    <script src="<?=AdminAssets ?>js/jquery.slimscroll.js"></script>
    <script src="<?=AdminAssets ?>js/validation.js"></script>
    <!--Wave Effects -->
    <script src="<?=AdminAssets ?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?=AdminAssets ?>js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?=GeneralAssets ?>plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?=GeneralAssets ?>plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=AdminAssets ?>js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?=GeneralAssets ?>plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="<?=GeneralAssets ?>plugins/toast-master/js/jquery.toast.js"></script>
    <script src="<?=AdminAssets ?>js/admin.js"></script>
<script>


 $(document).ready(function() {

  $("input,textarea,select").jqBootstrapValidation(
                    {
          preventSubmit: true,
          submitError: function($form, event, errors) {
              // Here I do nothing, but you could do something like display 
              // the error messages to the user, log, etc.
          },
          submitSuccess: function($form, event) {
                            event.preventDefault();
                      
                       var  dataOBJ = $("#loginform").serialize();
                        $.ajax({
                            url: "admin_login_post",
                            type: 'POST',
                            dataType: 'json',
                            cache: false,
                            data:dataOBJ,
                            success: function(data) {
                              
                                if (data == null) {

                                    alertbox("Login Failed" , "Invalid Username or Password" ,  "error");
                                } 
                                else {

                                       window.location.replace("admin_dashboard");
                                }
                            },
                            error: function(data) {
                              alertbox("Login Failed" , "Invalid Username or Password" , "error");
                            }
                        });

           
          },
          filter: function() {
              return $(this).is(":visible");
          }
      }
  );


    });
</script>
</body>

</html>