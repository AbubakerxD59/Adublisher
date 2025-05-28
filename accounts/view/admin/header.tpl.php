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

if (!App::Auth()->is_Admin()) {
  Url::redirect(SITEURLMM . '/admin/login/');
  exit;
}
?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <title><?php echo $this->title; ?></title>
  <script type="text/javascript" src="<?php echo SITEURLMM; ?>/assets/jquery.js"></script>
  <script type="text/javascript"
    src="<?php echo SITEURL; ?>/assets/general/plugins/bootstrap/js/popper.min.js"></script>
  <script type="text/javascript"
    src="<?php echo SITEURL; ?>/assets/general/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo SITEURLMM; ?>/assets/global.js"></script>
  <link rel="stylesheet" href="<?php echo SITEURL; ?>/assets/landingpage/css/bootstrap.min.css">
  <!-- tinyMCE -->
  <script src="https://cdn.tiny.cloud/1/hbz84h9hpks3wdu06h5osyrs5t89xxlwhdqfp3r6xzv4uys6/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
  <!-- tinyMCE -->

  <!-- Summernote -->
  <!-- include summernote css/js -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
  <!-- Summernote -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?php echo ADMINVIEW; ?>/css/custom.css">
  <!-- <link rel="stylesheet" href="<?php echo SITEURL; ?>/assets/landingpage/plugins/css/font-awesome/all.min.css"> -->
  <link
    href="<?php echo ADMINVIEW . '/cache/' . Cache::cssCache(array('base.css', 'transition.css', 'label.css', 'form.css', 'dropdown.css', 'input.css', 'button.css', 'message.css', 'image.css', 'list.css', 'table.css', 'icon.css', 'card.css', 'modal.css', 'editor.css', 'tooltip.css', 'menu.css', 'progress.css', 'utility.css', 'style.css'), ADMINBASE); ?>"
    rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
</head>

<body>
  <header>
    <?php
    $writer = App::Auth()->email == "writer@mailplux.com" ? true : false;
    ?>
    <div class="wojo-grid">
      <div class="row horizontal small gutters align middle">
        <div class="columns">
          <a href="<?php echo Url::url("/admin"); ?>" class="logo">
            <?php echo (App::Core()->logo) ? '<img src="' . SITEURLMM . '/uploads/' . $this->core->logo . '" alt="' . $this->core->company . '">' : $this->core->company; ?>
          </a>
        </div>
        <div class="columns auto">
          <div class="wojo buttons" data-dropdown="#dropdown-uMenu" id="uName">
            <div class="wojo transparent button"><?php echo App::Auth()->name; ?></div>
            <div class="wojo primary inverted icon button"><?php echo Utility::getInitials(App::Auth()->name); ?></div>
          </div>
          <div class="wojo small dropdown top-right" id="dropdown-uMenu">
            <div class="wojo small circular center image">
              <img
                src="<?php echo UPLOADURL; ?>/avatars/<?php echo (App::Auth()->avatar) ? App::Auth()->avatar : "blank.svg"; ?>"
                alt="">
            </div>
            <h5 class="wojo small dimmed text center aligned"><?php echo App::Auth()->name; ?></h5>
            <a class="item" href="<?php echo Url::url("/admin/myaccount"); ?>"><i class="icon user"></i>
              <?php echo Lang::$word->M_MYACCOUNT; ?></a>
            <a class="item" href="<?php echo Url::url("/admin/myaccount/password"); ?>"><i class="icon lock"></i>
              <?php echo Lang::$word->M_SUB2; ?></a>
            <div class="divider"></div>
            <a class="item" href="<?php echo Url::url("/admin/logout"); ?>"><i class="icon power"></i>
              <?php echo Lang::$word->LOGOUT; ?></a>
          </div>
        </div>
        <?php if (Auth::checkAcl("owner")): ?>
          <?php
          if (!$writer) {
            ?>
            <div class="columns auto">
              <a data-dropdown="#dropdown-aMenu" class="wojo icon simple transparent button">
                <i class="icon cogs"></i>
              </a>
              <div class="wojo small dropdown top-right" id="dropdown-aMenu">
                <a class="item" href="<?php echo Url::url("/admin/configuration"); ?>"><i
                    class="icon sliders vertical alt"></i>
                  <?php echo Lang::$word->ADM_CONFIG; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/permissions"); ?>"><i class="icon lock"></i>
                  <?php echo Lang::$word->ADM_PERMS; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/language"); ?>"><i class="icon flag"></i>
                  <?php echo Lang::$word->ADM_LNGMNG; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/maintenance"); ?>"><i class="icon settings alt"></i>
                  <?php echo Lang::$word->ADM_MTNC; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/system"); ?>"><i class="icon laptop"></i>
                  <?php echo Lang::$word->ADM_SYSTEM; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/backup"); ?>"><i class="icon database"></i>
                  <?php echo Lang::$word->ADM_BACKUP; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/gateways"); ?>"><i class="icon wallet"></i>
                  <?php echo Lang::$word->ADM_GATE; ?></a>
                <a class="item" href="<?php echo Url::url("/admin/transactions"); ?>"><i class="icon credit card"></i>
                  <?php echo Lang::$word->ADM_TRANS; ?></a>
                <div class="divider"></div>
                <a class="item" href="<?php echo Url::url("/admin/trash"); ?>"><i class="icon trash"></i>
                  <?php echo Lang::$word->ADM_TRASH; ?></a>
              </div>
            </div>
            <?php
          }
          ?>
        <?php endif; ?>
        <div class="columns auto hide-all" id="mobileToggle">
          <a class="wojo transparent icon button menu-mobile"><i class="icon white reorder"></i></a>
        </div>
      </div>
    </div>
  </header>
  <div class="navbar">
    <div class="wojo-grid">
      <nav class="wojo menu">
        <ul>
          <li <?php if (Utility::in_array_any(["templates", "countries", "coupons", "fields", "news", "mailer"], $this->segments))
            echo ' class="active"'; ?>>
            <a href="#">
              <img src="<?php echo ADMINVIEW; ?>/images/content.svg">
              <span class="title"><?php echo Lang::$word->ADM_CONTENT; ?></span>
              <i class="icon chevron down"></i>
            </a>
            <ul>
              <?php if (!$writer) { ?>
                <li>
                  <a <?php if (in_array("templates", $this->segments))
                    echo ' class="active"'; ?>
                    href="<?php echo Url::url("/admin/templates"); ?>"><?php echo Lang::$word->ADM_EMTPL; ?></a>
                </li>
                <li>
                  <a <?php if (in_array("countries", $this->segments))
                    echo ' class="active"'; ?>
                    href="<?php echo Url::url("/admin/countries"); ?>"><?php echo Lang::$word->ADM_CNTR; ?></a>
                </li>
                <li>
                  <a <?php if (in_array("coupons", $this->segments))
                    echo ' class="active"'; ?>
                    href="<?php echo Url::url("/admin/coupons"); ?>"><?php echo Lang::$word->ADM_COUPONS; ?></a>
                </li>
                <li>
                  <a <?php if (in_array("fields", $this->segments))
                    echo ' class="active"'; ?>
                    href="<?php echo Url::url("/admin/fields"); ?>"><?php echo Lang::$word->ADM_CFIELDS; ?></a>
                </li>
                <li>
                  <a <?php if (in_array("news", $this->segments))
                    echo ' class="active"'; ?>
                    href="<?php echo Url::url("/admin/news"); ?>"><?php echo Lang::$word->ADM_NEWS; ?></a>
                </li>
                <li>
                  <a <?php if (in_array("mailer", $this->segments))
                    echo ' class="active"'; ?>
                    href="<?php echo Url::url("/admin/mailer"); ?>"><?php echo Lang::$word->ADM_NEWSL; ?></a>
                </li>
              <?php } ?>
              <li>
                <a <?php if (in_array("categories", $this->segments))
                  echo ' class="active"'; ?>
                  href="<?php echo Url::url("/admin/categories"); ?>"><?php echo "Categories"; ?></a>
              <li>
                <a <?php if (in_array("blogs", $this->segments))
                  echo ' class="active"'; ?>
                  href="<?php echo Url::url("/admin/blogs"); ?>"><?php echo "Blogs"; ?></a>
              </li>
            </ul>
          </li>
          <?php
          if (!$writer) {
            ?>
            <li <?php if (in_array("memberships", $this->segments))
              echo ' class="active"'; ?>>
              <a href="<?php echo Url::Url("/admin/memberships"); ?>">
                <img src="<?php echo ADMINVIEW; ?>/images/memberships.svg">
                <span class="title"><?php echo Lang::$word->ADM_MEMBS; ?></span>
              </a>
            </li>
            <li <?php if (Utility::in_array_any(["users"], $this->segments))
              echo ' class="active"'; ?>>
              <a href="#">
                <img src="<?php echo ADMINVIEW; ?>/images/users.svg">
                <span class="title"><?php echo Lang::$word->ADM_USERS; ?></span>
                <i class="icon chevron down"></i></a>
              <ul>
                <li><a <?php in_array("users", $this->segments) ? "style='font-weight:bold;'" : "" ?>
                    href="<?php echo Url::url("/admin/users"); ?>"><?php echo Lang::$word->ADM_USERS; ?></a>
                </li>
                <li><a <?php in_array("active", $this->segments) ? "style='font-weight:bold;'" : "" ?>
                    href="<?php echo Url::url("/admin/users/active"); ?>"><?php echo "Active Users"; ?></a>
                <li><a <?php in_array("inactive", $this->segments) ? "style='font-weight:bold;'" : "" ?>
                    href="<?php echo Url::url("/admin/users/inactive"); ?>"><?php echo "Inactive Users"; ?></a>
                </li>
              </ul>
            </li>
            <li <?php if (in_array("files", $this->segments))
              echo ' class="active"'; ?>>
              <a href="<?php echo Url::Url("/admin/files"); ?>">
                <img src="<?php echo ADMINVIEW; ?>/images/files.svg">
                <span class="title"><?php echo Lang::$word->ADM_FILES; ?></span>
              </a>
            </li>
            <li <?php if (in_array("help", $this->segments))
              echo ' class="active"'; ?>>
              <a href="<?php echo Url::Url("/admin/help"); ?>">
                <img src="<?php echo ADMINVIEW; ?>/images/help.svg">
                <span class="title"><?php echo Lang::$word->ADM_HELP; ?></span>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
      </nav>
    </div>
  </div>
  <main>
    <div class="wojo-grid">
      <div class="wojo small breadcrumb">
        <?php echo Url::crumbs($this->crumbs ? $this->crumbs : $this->segments, "//", Lang::$word->HOME); ?>
      </div>