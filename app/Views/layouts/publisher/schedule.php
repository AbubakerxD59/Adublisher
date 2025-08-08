<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $this->load->view('templates/publisher/seo');
    $this->load->view('templates/publisher/styling');
    $this->load->view("layouts/publisher/views/schedule/style");
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo ASSETURL . 'images/logo-icon.png'; ?>" alt="Adublisher-Logo" height="60" width="60">
        </div> -->
        <!-- Navbar -->
        <?php
        $this->load->view("templates/publisher/navbar");
        ?>
        <!-- Main Sidebar Container -->
        <?php
        App::Session()->get('team_role') == "affiliate" ? $this->load->view('templates/publisher/affiliate-aside') : $this->load->view('templates/publisher/owner-aside');
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php echo loader(); ?>
                        <div class="col-md-12 col-xlg-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php $this->load->view("layouts/publisher/views/schedule/index", $data) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="<?php echo SITEURL; ?>">Adublisher</a>.</strong>
        All rights reserved.
    </footer>
    <?php
    $this->load->view("templates/publisher/scripts");
    $this->load->view("layouts/publisher/views/schedule/manifest");
    $this->load->view('templates/publisher/external_head_scripts');
    $this->load->view("layouts/publisher/views/schedule/script");
    ?>
</body>

</html>