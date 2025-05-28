<?php
  /**
   * Header
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2020
   * @version $Id: header.tpl.php, v1.00 2020-10-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');

    
     
     require_once('../ppc/views/templates/publisher/seo.php'); 
     require_once('../ppc/views/templates/publisher/external_head_scripts.php'); 
     
  
 ?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php echo isset($this) ? $this->title : App::Core()->company;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<script type="text/javascript" src="<?php echo SITEURLMM;?>/assets/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITEURLMM;?>/assets/global.js"></script>
<link href="<?php echo FRONTVIEW . '/cache/' . Cache::cssCache(array('base.css','transition.css','label.css','form.css','dropdown.css','input.css','button.css','message.css','image.css','list.css','table.css','icon.css','card.css','modal.css','editor.css','tooltip.css','menu.css','progress.css','utility.css','style.css'), FRONTBASE);?>" rel="stylesheet" type="text/css" />
    <!--icofont css-->
    <!--bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?=LANDINGASSETS ?>/css/bootstrap.min.css">
    <!--icofont css-->
    <link rel="stylesheet" type="text/css" href="<?=LANDINGASSETS ?>/css/icofont.min.css">
    <!--main css-->
    <link rel="stylesheet" type="text/css" href="<?=LANDINGASSETS ?>/css/style.css">

</head>
<body>
    <!--start preloader-->

    <!--end preloader-->
    <!--start header-->
    <header id="header">
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-lg justify-content-center">
                <a class="logo" href="<?=SITEURL?>"><img src="<?=LANDINGASSETS ?>/images/logo.png" alt="logo"></a>
            </nav>
        </div>
    </header>
<section id="contact-area" data-scroll-index="7"  style="background-image: url(<?=LANDINGASSETS ?>/images/banner-4.jpg)">
        <div class="container">