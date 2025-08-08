<!DOCTYPE html>
<html lang="en" ng-app="adub">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110091171-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-110091171-1');
</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/general/images/logo-icon.png">
    <title>Adublisher</title>
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
    
  
  
    <?php
    if( $this->uri->segment(1) == "dashboard"){
        ?>
    
         <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
    
        <?php
        
        }      
    ?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="fix-header fix-sidebar card-no-border">
    <div id="preloader_ajax"><span id="inner_text">Please Wait...</span></div>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
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
                    <a class="navbar-brand" href="<?=SITEURL.'dashboard'; ?>">
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
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Notifications"> 
                                <i class="mdi mdi-earth"></i>
                                <!-- <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                               
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                       
                                        <div class="message-center">
                                            <?php
                                           
                                            $notifications=publisher_notifications();
                                            foreach($notifications as $notification)
                                            {
                                               
                                               echo 
                                                    "<a href='".$notification['link']."'>
                                                    ".notification_icon($notification['type'])."
                                                    <div class='mail-contnet'>
                                                    <h5>".$notification['title']."</h5>
                                                    <span class='mail-desc'>".$notification['text']."</span> 
                                                        <span class='time'>
                                                        ".$notification['publish_date']; 

                                                if($notification['seen']=='0')
                                                    {
                                                   
                                                       echo  "<div data-id=$notification[id] class='change_status pull-right pointer text-muted'> 
                                                        <i  data-toggle='tooltip'  data-placement='top'  data-original-title='Mark as Read' class='fa fa-check'>
                                                        </i> 
                                                        </div>";  
                                                    
                                                    }
                                                    else
                                                    {
                                                     echo 
                                                     "<i class='fa fa-check pull-right text-success'>
                                                        </i> " ;
                                                    }
                                                    echo "</span>
                                                     </div>
                                                    </a>  ";
                                               
                                            }?>

                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="<?=SITEURL.'notifications_area' ?>"> <strong>Check all Notifications</strong> <i class="fa fa-angle-right"></i> </a>

                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Announcements"> 
                                <i class="fa fa-bullhorn"></i>
                                <!-- <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Announcements</div>
                                    </li>
                                    <li>
                                        <?php
                                            $count = 0 ;
                                            $notifications=publisher_annoucements();
                                        ?>
                                        <div class="message-center">
                                            <?php
                                            $notifications=publisher_annoucements();
                                            foreach($notifications as $notification)
                                            {
                                            echo 
                                            "<a href='#'>
                                            <div class='btn btn-success btn-circle'><i class='fa fa-bullhorn'></i></div>
                                            <div class='mail-contnet'>
                                                <span class='mail-desc'>$notification[text]
                                                </span> <span class='time'>".$notification['publish_date']
                                                 ."</span> </div>
                                            </a>  ";
                                               
                                            }?>

                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="<?=SITEURL.'annoucement_area'?>"> <strong>Check all Announcements</strong> <i class="fa fa-angle-right"></i> </a>

                                    </li>

                                </ul>
                            </div>
                        </li>
               
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                      <!--  -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?=App::Session()->get('fullname') ?>   <img src="<?=SITEURL.App::Session()->get('avatar') ?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?=SITEURL.App::Session()->get('avatar') ?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?=App::Session()->get('fullname')?></h4>
                                                </div>
                                                <p class="text-muted"><?=App::Session()->get('email')?></p>
                                        </div>
                                    </li>
                                  <li role="separator" class="divider"></li>
                                    <li><a href="<?=SITEURL?>update_profile"><i class="ti-user"></i> Update Profile</a></li>
                                 
                                    <li role="separator" class="dividers"></li>
                                    <li><a href="<?=SITEURL?>update_password"><i class="ti-settings"></i> Change Password</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li  ><a href="<?=SITEURL?>index.php/logout" ><i class="fa fa-power-off"></i> Logout</a></li>
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
                             <a class="waves-effect waves-dark" href="<?=SITEURL?>dashboard" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard </span></a>
                        </li>

                        <?php 
                        $update=false;
                            foreach($roles as $role) {


                            if($role['menu_name']=='Facebook Auto Post')
                            {

                    echo '<li>
                            <a class="waves-effect waves-dark" href="'.SITEURL.'facebook" aria-expanded="false"><i class="mdi mdi-facebook-box"></i><span class="hide-menu">Connect Facebook</span></a>
                         </li>';
                            }
                           

                                if($role['menu_name']=='Rss Feed')
                            {

                    echo '<li>
                            <a class="waves-effect waves-dark" href="'.SITEURL.'rssfeed" aria-expanded="false"><i class="fa fa-feed"></i><span class="hide-menu">Rss Feed</span></a>
                         </li>';
                            }
                           
                                
                             
                               
                            
                            
                            else if($role['menu_name']=='Campaign')
                            {
                                echo '<li>
                                <a class="waves-effect waves-dark" href="'.SITEURL.'campaigns" aria-expanded="false"><i class="mdi mdi-flag"></i><span class="hide-menu">Campaigns </span></a>
                                    </li>';
                            }
                            else if($role['menu_name']=='Traffic Summary')
                            {


                       echo ' 
                        <li>
                            <a class="waves-effect waves-dark" href="'.SITEURL.'traffic" aria-expanded="false"><i class="mdi mdi-chart-line"></i><span class="hide-menu">Traffic Summary </span></a>
                        </li>';
                    }

                     else if($role['menu_name']=='Change Domain')
                        {

                            echo 
                        '<li>
                            <a class="waves-effect waves-dark" href="'.SITEURL.'change_domain" aria-expanded="false"><i class="mdi mdi-earth"></i><span class="hide-menu">Change Domain</span></a>
                           
                        </li>';
                    }
                    else if($role['menu_name']=='Website Widgets')
                    {


                         echo '<li>
                            <a class="waves-effect waves-dark" href="'.SITEURL.'widget_area" aria-expanded="false"><i class="mdi mdi-widgets"></i><span class="hide-menu">Website Widgets</span></a>
                           
                        </li>';
                    }
                 
                    else if($role['menu_name']=='Payments Method')
                    {

                        echo 
                        '<li>
                            <a class="waves-effect waves-dark" href="'.SITEURL.'payment_method" aria-expanded="false"><i class="mdi mdi-bank"></i><span class="hide-menu">Payments Method</span></a>
                           
                        </li>';
                    }
                    

                
                    else if($role['menu_name']=='Update Profile'){

                        $update=true;
                        echo '<li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings  </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="'.SITEURL.'update_profile"><i class="ti-user"></i> Update Profile</a></li>';
                                 
                                    
                        
                        }
                        if($role['menu_name']=='Change Password' && $update==true)
                        {
                            echo '<li role="separator" class="dividers"></li>
                                    <li><a href="'.SITEURL.'update_password"><i class="ti-settings"></i> Change Password</a></li>
                            </ul> </li>';

                        }
                        else if($role['menu_name']=='Change Password')
                        {
                            echo '<li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings  </span></a>
                            <ul aria-expanded="false" class="collapse">
                            <li><a href="'.SITEURL.'update_password"> <i class="ti-settings"></i> Change Password</a></li>';
                        }

                       
                        }
                                          
                        echo '<li>
                            <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-upload"></i><span class="hide-menu">Bulk Upload</span></a>
                            <ul aria-expanded="false" class="collapse">';
                               
                        foreach($roles as $role) { 
                               
                            if($role['menu_name'] == 'Facebook Bulk Upload'){
                                echo '<li><a href="'.SITEURL.'facebookbulkupload"><i class="fa fa-facebook-square"></i> Facebook Pages</a></li>';
                            }
                               
                            if($role['menu_name'] == 'Facebook Story Bulk Upload'){
                               // echo '<li><a href="#"><i class="fa fa-facebook-square"></i> Facebook Story</a></li>';
                            }
                               
                            
                            if($role['menu_name'] == 'Instagram Bulk Upload'){
                                echo ' <li><a href="'.SITEURL.'instagrambulkupload"><i class="ti-instagram"></i> Instagram</a></li>';
                            }
                               
                            if($role['menu_name'] == 'Instagram Story Bulk Upload'){
                                
                                echo '<li><a href="'.SITEURL.'instagramstorybulkupload"><i class="ti-instagram"></i> Instagram Story</a></li>';
                            }
                        }
                          echo '</ul></li>'; 
                                           
                                           
                        ?>     

                        <li class="nav-devider"></li>

                         <li>
                            <a class="waves-effect waves-dark" href="<?=SITEURL;?>index.php/logout">
                                <i class="fa fa-power-off"></i><span class="hide-menu"> Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <input type="hidden" id="SITEURL" value="<?=SITEURL?>" />
        <input type="hidden" id="loggedUsername" value="<?=App::Session()->get('MMP_username')?>" />
        <input type="hidden" id="loggeduserid" value="<?=App::Session()->get('userid')?>" />



     
 