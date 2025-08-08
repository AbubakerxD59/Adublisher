<!DOCTYPE html>
<html lang="en" ng-app="admin">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=GeneralAssets ?>images/logo-icon.png">
    <title>Adublisher Admin</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=GeneralAssets ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="<?=GeneralAssets ?>plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
     <link href="<?=GeneralAssets ?>plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="<?=PublisherAssets ?>css/style.css?v=<?=BUILDNUMBER?>" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?=PublisherAssets ?>css/colors/purple.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=GeneralAssets ?>plugins/bootstrap-daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?=GeneralAssets ?>plugins/select2/dist/css/select2.min.css">
  
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
  
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border">
    <div id="preloader_ajax"><span id="inner_text">Please Wait...</span></div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
   <!--  <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?=SITEURL;?>admin_dashboard">
                        <input id="BASEURL" value="<?=SITEURL;?>" type="hidden" />
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="<?=GeneralAssets ?>images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="<?=GeneralAssets ?>images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                         <!-- dark Logo text -->
                         <img src="<?=GeneralAssets ?>images/logo-text.png" alt="homepage" class="dark-logo" />
                         <!-- Light Logo text -->    
                         <img src="<?=GeneralAssets ?>images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                     
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo App::Session()->get('admin_avatar'); ?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo App::Session()->get('admin_avatar'); ?>" alt="user">
                                            </div>
                                            <div class="u-text">
                                                <h4><?php echo App::Session()->get('admin_name'); ?> </h4>
                                                <a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                            </div>
                                             <p class="text-muted"><?php echo App::Session()->get('admin_email'); ?></p>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=SITEURL;?>currency_list"><i class="ti-settings"></i> Rates Settings</a></li>

                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Password Setting</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=SITEURL;?>admin_logout"><i class="fa fa-power-off"></i> Logout</a></li>

                                </ul>
                            </div>
                        </li>
                       
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                         <li>
                            <a class="waves-effect waves-dark" href="<?=SITEURL;?>admin_dashboard" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                           
                        </li>
                        <li> 

                        <a class="waves-effect waves-dark" href="<?=SITEURL;?>category_list" aria-expanded="false"><i class="mdi mdi-view-grid"></i><span class="hide-menu">Categories</span></a>
                         
                           
                        </li>

                        <li>
                              <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-flag"></i><span class="hide-menu">Campaigns </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=SITEURL;?>campaigns_admin"> All</a>
                                </li>
                                <li>
                                     <a href="<?=SITEURL;?>campaign_add"> Add New</a>
                                </li>
                                 <li>
                                    <a href="<?=SITEURL;?>campaign_list"> Manage </a>
                                </li>
                            </ul>
                           
                        </li>                        

                      
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-earth"></i><span class="hide-menu">Domains </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=SITEURL;?>domain_list"> All</a>
                                </li>
                                 <li>
                                    <a href="<?=SITEURL;?>article_domains"> 
                                     Analytics domains</a>
                                </li>
                                 <li>
                                    <a href="<?=SITEURL;?>domain_assign"> Assign to Publishers </a>
                                </li>
                                <li>
                                    <a href="<?=SITEURL;?>domain_default"> Default For Publishers </a>
                                </li>
                            </ul>
                        </li>
                       

                       <li class="">
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-network"></i><span class="hide-menu">Packages </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=SITEURL;?>packages_all"> Management </a>
                                </li>
                                <li>
                                    <a href="<?=SITEURL;?>packages_features"> Package Features</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu"> Reports  </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=SITEURL;?>publisher_analytics"> Publisher Reports</a>
                                </li>
                                <li>
                                    <a  href="<?=SITEURL;?>campaign_analytics" >Campaigns Reports</a>
                                <li>
                                 <li>
                                    <a  href="<?=SITEURL;?>country_analytics" >Country Reports</a>
                                <li>
                                <li>
                                    <a  href="#" title="comming soon" >Advertiser Reports</a>
                                <li>
                            </ul>
                        </li>      


						<li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullhorn"></i><span class="hide-menu">Manage Publishers  </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=SITEURL;?>publisher_list"> All</a>
                                   
                                </li>
                                <li>
                                    <a  href="<?=SITEURL;?>manage_roll" >Access Management</a>
                                <li>
                              <!--  <li>
                                    <a href="<?=SITEURL;?>publisher_clicks"> Clicks</a>
                                </li>
        						<li>
                                    <a href="<?=SITEURL;?>publisher_weekly"> Weekly Earning</a>
                                   
                                </li>-->
        						<li>
                                    <a href="<?=SITEURL;?>publisher_pay"> Publisher Pay</a>
                                   
                                </li>



                            </ul>
                        </li>      

                        <li class="hide">
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cast"></i><span class="hide-menu">Advertisers   </span></a>
                            <ul aria-expanded="false" class="collapse">
                               
                         	    <li>

                                <a href="#"> All</a>
                                </li>

                                <li>
                                    <a href="#"> Campaigns</a>
                                </li>
        						<li>
                                    <a href="#"> Finance</a>
                              </li>
                            </ul>
                        </li>     
                        <li>

                         <a class="waves-effect waves-dark" href="<?=SITEURL;?>announcements" aria-expanded="false"><i class="mdi mdi-volume-high"></i><span class="hide-menu"> Announcements </span>
                        </a>
                        </li>   
                        
                        <li>
                              <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">System Settings </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="<?=SITEURL;?>currency_list" > PPC Rates </a>
                                </li>
                                <li>
                                     <a href="<?=SITEURL;?>admin_add" > Add Admin</a>
                                </li>
                                  <li>
                                    <a href="<?=SITEURL;?>domain_system"> System Domain  </a>
                                </li>
                                
                                 <li>
                                    <a href="<?=SITEURL;?>direct_link"> Direct Link  </a>
                                </li>
                            </ul>
                           
                        </li>                        


                            
                        

                        
                            <a class="waves-effect waves-dark" href="<?=SITEURL;?>admin_logout">
                                <i class="fa fa-power-off"></i><span class="hide-menu"> Logout</span>
                            </a>
                        </li>
                       
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>
        <!-- ============================================================== -->