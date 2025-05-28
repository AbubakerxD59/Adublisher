<nav class="navbar navbar-expand-lg fixed-top bg-lighter-light container-fluid">
    <div class="container">
        <a class="navbar-brand" href="<?php echo SITEURL; ?>">
            <img src="<?php echo ASSETURL . 'images/logo.svg'; ?>" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse px-4" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-between">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#featuresDropdown">
                        Features
                    </a>
                    <ul class="nav-show-hide collapse dropdown-menu row" id="featuresDropdown">
                        <li class="col-12 col-lg-4">
                            <a href="<?php echo SITEURL . 'calendar-view'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bx-customize'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>Calender View</h4>
                                    <p class=" d-none d-lg-block">
                                        Easily schedule, manage, and visualize your events.
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="col-12 col-lg-4">
                            <a href="<?php echo SITEURL . 'analytic'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bxs-bar-chart-alt-2'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>Analytics</h4>
                                    <p class=" d-none d-lg-block">
                                        Track, analyze, and optimize your data.
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="col-12 col-lg-4">
                            <a href="<?php echo SITEURL . 'automations'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bx-link'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>Automation</h4>
                                    <p class=" d-none d-lg-block">
                                        Stay updated with the latest content through RSS.
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="col-12 col-lg-4">
                            <a href="<?php echo SITEURL . 'bulk-schedule'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bxs-layer'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>Bulk Scheduling</h4>
                                    <p class=" d-none d-lg-block">
                                        Plan and schedule multiple posts at once.
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="col-12 col-lg-4">
                            <a href="<?php echo SITEURL . 'recycling'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bx-link'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>Recycling</h4>
                                    <p class=" d-none d-lg-block">
                                        Convert waste into reusable resources.
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="col-12 col-lg-4">
                            <a href="<?php echo SITEURL . 'curate-post'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bx-list-ul'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>Curate Post</h4>
                                    <p class=" d-none d-lg-block">
                                        Discover, organize, and publish the best posts.
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" data-bs-toggle="collapse" data-bs-target="#toolsdropdown">
                        Free tools
                    </a>
                    <ul class="nav-show-hide small collapse dropdown-menu row" id="toolsdropdown">
                        <li class="col-12">
                            <a href="<?php echo SITEURL . 'link-shortener'; ?>" class="nav-link nav-inner-link">
                                <div class="inner-link-icon d-none d-lg-block">
                                    <i class='bx bx-customize'></i>
                                </div>
                                <div class="inner-link-content">
                                    <h4>URL Link Shortner</h4>
                                    <p class=" d-none d-lg-block">
                                        Easily schedule, manage, and visualize your events.
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITEURL . 'pricing'; ?>">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITEURL . 'blogs'; ?>">Blog</a>
                </li>
            </ul>
            <div class="d-block d-lg-flex">
                <?php
                if (check_user_login()) {
                ?>
                    <button class="btn nav-btn btn-colored" type="button">
                        <a href="<?php echo SITEURL . 'dashboard'; ?>">
                            Dashboard
                        </a>
                    </button>
                <?php
                } else {
                ?>
                    <button class="btn nav-btn btn-transparent align-items-center" href="#features" type="button">
                        <a href="<?php echo SITEURL . 'login'; ?>">
                            <i class='bx bx-log-in-circle'></i> Login
                        </a>
                    </button>
                    <button class="btn nav-btn btn-colored" type="button">
                        <a href="<?php echo SITEURL . 'register'; ?>">
                            Sign up
                        </a>
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>