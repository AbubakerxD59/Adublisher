<?php
$membership_id = App::Session()->get('membership_id');
$inactive_lock = "";
if ($membership_id == "0") {
    $inactive_lock = "<i class='fa fa-lock'></i>";
}
?>
<style>
    .waves-dark {
        font-weight: 800 !important;
    }
</style>
<div class="col-2 p-0 m-0">
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?php echo SITEURL; ?>" class="brand-link d-flex">
            <img src="<?php echo ASSETURL . 'images/logo.svg'; ?>" alt="Adublisher-Logo" class="brand-image w-100"
                style="opacity: .8">
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo ASSETURL . 'images/avatar3.png'; ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="<?php echo SITEURL . 'personal-info'; ?>" class="d-block"><?php echo get_auth_user()->username; ?></a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">SOCIAL MEDIA</li>
                    <li class="nav-item">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("schedule") ? "active" : ""; ?> " href="<?= SITEURL; ?>schedule">
                            <i class="nav-icon mdi mdi-calendar-clock"></i>
                            <p class="hide-menu">Schedule
                                <?= $inactive_lock ?>
                                <?php limit_check(POST_PUBLISHING_FB_ID, 1) || limit_check(POST_PUBLISHING_INST_ID, 1) || limit_check(POST_PUBLISHING_PIN_ID, 1) || limit_check(POST_PUBLISHING_YT_ID, 1) || limit_check(POST_SCHEDULING_FB_ID, 1) || limit_check(POST_SCHEDULING_INST_ID, 1) || limit_check(POST_SCHEDULING_PIN_ID, 1) || limit_check(POST_SCHEDULING_YT_ID, 1) ? '' : "<i class='fa fa-lock'></i>"; ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item <?= REVIEW_REQUEST; ?>">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("groups") ? "active" : ""; ?> " href="<?= SITEURL; ?>groups">
                            <i class="nav-icon mdi mdi-view-dashboard"></i>
                            <p class="hide-menu">Group <?= $inactive_lock ?>
                                <?php limit_check(GROUP_POSTING_ID, 1) ? '' : "<i class='fa fa-lock'></i>"; ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item <?= REVIEW_REQUEST; ?>">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("automation") ? "active" : ""; ?> " href="<?= SITEURL; ?>automation" aria-expanded="false">
                            <i class="nav-icon mdi mdi-rss"></i>
                            <p class="hide-menu">Automation <?= $inactive_lock ?>
                                <?php limit_check(RSS_FEED_LATEST_POST_FETCH_ID, 1) || limit_check(RSS_FEED_OLD_POST_FETCH_ID, 1) || limit_check(RSS_FEED_CATEGORY_FETCH_ID, 1) || limit_check(RSS_FEED_POST_PUBLISH_ID, 1) ? '' : "<i class='fa fa-lock'></i>"; ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item <?= REVIEW_REQUEST; ?>">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("analytics") ? "active" : ""; ?> " href="<?= SITEURL; ?>analytics" aria-expanded="false">
                            <i class="nav-icon mdi mdi-chart-bar"></i>
                            <p class="hide-menu">Analytics
                                <?= $inactive_lock ?>
                                <?php limit_check(FACEBOOK_ANALYTICS_ID, 1) ? '' : "<i class='fa fa-lock'></i>" ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item <?= REVIEW_REQUEST; ?>">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("url-tracking") || url_segments("edit_url") ? "active" : ""; ?> " href="<?= SITEURL; ?>url-tracking" aria-expanded="false">
                            <i class="nav-icon mdi mdi-map-marker"></i>
                            <p class="hide-menu">Url Tracking
                                <?= $inactive_lock ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item <?= REVIEW_REQUEST; ?>">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("calendar") ? "active" : ""; ?> " href="<?= SITEURL; ?>calendar" aria-expanded="false">
                            <i class="nav-icon mdi mdi-calendar"></i>
                            <p class="hide-menu">Calendar
                                <?= $inactive_lock ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-devider mb-2 mt-1"></li>
                    <li class="nav-header">EVERGREEN</li>
                    <li class="nav-item">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("recycle") || url_segments('add-campaign') ? "active" : ""; ?> " href="<?= SITEURL; ?>recycle" aria-expanded="false">
                            <i class="nav-icon mdi mdi-bullhorn"></i>
                            <p class="hide-menu">Recycle <?= $inactive_lock ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("traffic-reports") ? "active" : ""; ?> " href="<?= SITEURL ?>traffic-reports" aria-expanded="false">
                            <i class="nav-icon mdi mdi-chart-pie"></i>
                            <p class="hide-menu">Traffic Reports
                                <?= $inactive_lock ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-devider mb-2 mt-1"></li>
                    <li class="nav-header">ACCOUNTS</li>
                    <li class="nav-item">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("social-accounts") ? "active" : ""; ?> " href="<?= SITEURL; ?>social-accounts" aria-expanded="false">
                            <i class="nav-icon mdi mdi-account"></i>
                            <p class="hide-menu">Social Accounts <?= $inactive_lock ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="waves-effect waves-dark nav-link <?php echo url_segments("settings") ? "active" : ""; ?> " href="<?= SITEURL; ?>settings" aria-expanded="false">
                            <i class="nav-icon mdi mdi-cog"></i>
                            <p class="hide-menu">Settings <?= $inactive_lock ?>
                            </p>
                        </a>
                    </li>
                    <li class="nav-devider"></li>
                    <li class="nav-item">
                        <a class="waves-effect waves-dark nav-link" href="<?= SITEURL; ?>logout">
                            <i class="nav-icon mdi mdi-power"></i>
                            <p class="hide-menu">Logout

                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</div>