<!-- <aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="<?= SITEURL ?>dashboard" aria-expanded="false"><i class="mdi mdi-home"></i><span class="hide-menu">Home </span></a>
                </li>
                <li class="nav-devider mb-2 mt-1"></li>
                <li class="nav-small-cap">AFFILIATE</li>
                <li>
                    <a class="waves-effect waves-dark" href="<?= SITEURL; ?>campaigns" aria-expanded="false">
                        <i class="fa fa-bullhorn"></i><span class="hide-menu">Campaigns <?= $inactive_lock ?></span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="<?= SITEURL; ?>facebook" aria-expanded="false">
                        <i class="mdi mdi-facebook-box"></i><span class="hide-menu">Social Accounts <?= $inactive_lock ?></span>
                    </a>
                </li>
                <li>
                    <a class="waves-effect waves-dark" href="<?= SITEURL; ?>traffic" aria-expanded="false">
                        <i class="fa fa-pie-chart"></i><span class="hide-menu">Traffic Summary <?= $inactive_lock ?> </span>
                    </a>
                </li>
                <li class="nav-devider mb-2 mt-1"></li>

                <li class="nav-small-cap">ACCOUNTS</li>
                <li>
                    <a class="waves-effect waves-dark" href="<?= SITEURL; ?>settings" aria-expanded="false">
                        <i class="ti-settings"></i><span class="hide-menu">Settings</span>
                    </a>
                </li>

                <li class="nav-devider"></li>
                <li>
                    <a class="waves-effect waves-dark" href="<?= SITEURL; ?>logout">
                        <i class="fa fa-power-off"></i><span class="hide-menu"> Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside> -->

<?php
$membership_id = App::Session()->get('membership_id');
$inactive_lock = $membership_iD == 0 ? "<i class='fa fa-lock'></i>" : "";
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo SITEURL; ?>" class="brand-link">
        <img src="<?php echo ASSETURL . 'images/logo.svg'; ?>" alt="Adublisher-Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Adublisher</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo ASSETURL . 'images/avatar3.png'; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo get_auth_user()->username; ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo SITEURL . 'dashboard'; ?>" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo SITEURL . 'campaigns'; ?>" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Campaigns <?= $inactive_lock ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo SITEURL . 'social-accounts'; ?>" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Social Accounts <?= $inactive_lock ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo SITEURL . 'traffic'; ?>" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Traffic Summary <?= $inactive_lock ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo SITEURL . 'settings'; ?>" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo SITEURL . 'logout'; ?>" class="nav-link active">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>