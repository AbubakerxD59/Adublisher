<!DOCTYPE html>
<html lang="en" ng-app="adub">

<head>
    <?php
    $this->load->view('templates/publisher/seo');
    $this->load->view('templates/publisher/external_head_scripts');
    $this->load->view('templates/publisher/styling')
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo ASSETURL . 'images/logo-icon.png'; ?>" alt="Adublisher-Logo" height="60" width="60">
        </div>
    </d iv>
    <div id="main-wrapper">
        <!-- Navbar -->
        <?php $this->load->view("templates/publisher/navbar"); ?>
        <!-- Navbar -->
        <!-- Main Sidebar Container -->
        <?php
        App::Session()->get('team_role') == "affiliate" ? $this->load->view('templates/publisher/affiliate-aside') : $this->load->view('templates/publisher/owner-aside');
        ?>
        <!-- Main Sidebar Container -->

        <input type="hidden" id="SITEURL" value="<?php echo SITEURL ?>" />
        <script>
            var SITEURL = "<?php echo SITEURL ?>";
        </script>
        <?php $this->load->view("templates/publisher/scripts") ?>
        <input type="hidden" id="loggedUsername" value="<?php echo App::Session()->get('MMP_username') ?>" />
        <input type="hidden" id="loggeduserid" value="<?php echo App::Session()->get('userid') ?>" />

</body>

</html>