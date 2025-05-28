<style>
    body {
        font-family: 'Roboto' !important;
    }

    #recent_posts_table_info,
    .dt-info {
        display: none !important;
    }

    #recent_posts_table_processing {
        top: 10% !important;
    }

    .active_chart__bar::before {
        height: 100% !important;
    }

    #recent_posts_table>tbody>tr {
        cursor: pointer !important;
    }

    #get_recent_posts>tbody>tr {
        cursor: pointer !important;
    }

    .sm__lg__content {
        font-size: 14px !important;
        font-weight: 400 !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
<link rel="stylesheet" href="<?php echo NewLandingAssets . 'dashboard.css'; ?>">
<link rel="stylesheet" href="<?php echo NewLandingAssets . 'infinity_preloader.css'; ?>">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<!-- Sidebar Holder -->
<div class="page-wrapper">
    <div class="container-fluid m-0 p-0">
        <div>
            <div>
                <div class="simple-card">
                    <div class="m-0 p-0">
                        <div class="row analytics-row-setup">
                            <!-- This container is added just now....
                            So you will have to update is as well 
                            -->
                            <div class="overview__side__account__container d-none d-xl-flex">
                                <div class="top__cover__container">
                                    <div class="account__insights__btn">
                                        <div class="input__group">
                                            <i class='bx bx-search'></i>
                                            <input type="text" class="search__major" placeholder="View Insights for">
                                        </div>
                                    </div>
                                    <div class="accounts__added">
                                        <input type="hidden" id="page_board_channel">
                                        <input type="hidden" id="social_type">
                                        <input type="hidden" id="current_page" value="1">
                                        <input type="hidden" id="total_pages" value="">
                                        <input type="hidden" id="selected_date" value="">
                                        <input type="hidden" id="selected_type" value="">
                                        <?php
                                        foreach ($facebook_pages as $facebook_page) {
                                            ?>
                                            <div
                                                class="account__detail active_account__detail inactive_account cursor-pointer">
                                                <div>
                                                    <img src="<?php echo BulkAssets . $facebook_page->profile_pic; ?>"
                                                        class="round">
                                                </div>
                                                <div class="account__name px-2">
                                                    <span data-name="<?php echo $facebook_page->page_name; ?>"
                                                        data-id="<?php echo $facebook_page->page_id; ?>"
                                                        data-image="<?php echo $facebook_page->profile_pic; ?>"
                                                        data-type="facebook"
                                                        class="select_account"><?php echo $facebook_page->page_name; ?></a></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        foreach ($tiktoks as $tiktok) {
                                            ?>
                                            <div
                                                class="account__detail active_account__detail inactive_account cursor-pointer">
                                                <div>
                                                    <img src="<?php echo BulkAssets . $tiktok->profile_pic; ?>"
                                                        class="round">
                                                </div>
                                                <div class="account__name px-2">
                                                    <span data-name="<?php echo $tiktok->username; ?>"
                                                        data-id="<?php echo $tiktok->id; ?>"
                                                        data-image="<?php echo $tiktok->profile_pic; ?>" data-type="tiktok"
                                                        class="select_account"><?php echo $tiktok->username; ?></a></span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <!-- More accounts will be added here......... -->
                                    </div>
                                </div>
                                <div class="bottom__cover__container">
                                    <div class="">
                                        <a href="#" class="btn__group right">
                                            <i class='bx bx-plus'></i>
                                            Add account.
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="analytics__main__container">
                                <div class="col-12 w-100 d-xl-none">
                                    <div class="overview__side__account__container__sm">
                                        <div class="left__cover__container">
                                            <div class="mr-1">
                                                <a href="#" class="btn__group center">
                                                    <i class='bx bx-search'></i>
                                                </a>
                                            </div>
                                            <div class="account__detail sm">
                                                <div class="account__img">
                                                    <img src="<?php echo NewLandingAssets . 'images/blog9.jpg'; ?>">
                                                </div>
                                            </div>
                                            <div class="account__detail sm">
                                                <div class="account__img">
                                                    <img src="<?php echo NewLandingAssets . 'images/blog12.jpg'; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right__cover__container">
                                            <div class="">
                                                <a href="#" class="btn__group center">
                                                    <i class='bx bx-plus'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="overview__container m-0">
                                        <!-- Nav Header Area -->
                                        <div class="row g-0 m-0 p-0">
                                            <div class="top__nav__area col-12">
                                                <div class="col-12">
                                                    <div class="page__details">
                                                        <div class="page__content__details">
                                                            <div class="page__img">
                                                                <img
                                                                    src="<?php echo NewLandingAssets . 'images/avatar2.png'; ?>">
                                                            </div>
                                                            <div class="page__name">
                                                                <?php echo get_auth_user()->fname . ' ' . get_auth_user()->lname; ?>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="selection__route large__container d-block d-md-none">
                                                            <button
                                                                class="custom-dropdown-toggle d-flex d-lg-none">Overview<i
                                                                    class='fa fa-angle-down'></i> </button>
                                                            <ul class="custom-dropdown-menu small-screen">
                                                                <li class="toggle page_overview active"
                                                                    data-target="overview__container__contains">
                                                                    <a href="#">Overview</a>
                                                                </li>
                                                                <li class="toggle recent_posts"
                                                                    data-target="postinsights__container__contains">
                                                                    <a href="#">Post</a>
                                                                </li>
                                                                <!-- <li class="toggle hastags"
                                                                    data-target="hashtag__container__contains">
                                                                    <a href="#">Hashtag</a>
                                                                </li> -->
                                                                <!-- <li class="toggle competitors"
                                                                    data-target="competitor__container__contains">
                                                                    <a href="#">Competitor</a>
                                                                </li> -->
                                                            </ul>
                                                        </div>
                                                        <div class="selection__route small__changeable">
                                                            <button
                                                                class="sync__button button__sm__icons px-3 text-muted"
                                                                style="display:none;">
                                                                <i class='fa fa-refresh mr-1'></i>
                                                                Sync Insights
                                                            </button>
                                                            <button
                                                                class="selection__button__export button__sm__icons px-3 text-muted d-flex align-items-center">
                                                                <i class='bx bx-download'></i><span
                                                                    class="px-1">Export</span><i
                                                                    class='fa fa-angle-down'></i>
                                                            </button>
                                                            <div class="selection__menu__export">
                                                                <a href="" class="nav-link">Export view as PDF</a>
                                                                <a href="" class="nav-link">Export view as Excel/CSV</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="sm__navbar__management">
                                                        <div class="selection__route large__container d-none d-md-flex">
                                                            <ul class="custom-dropdown-menu d-lg-flex">
                                                                <li class="toggle toggle__selection__lg__btn page_overview active"
                                                                    data-target="overview__container__contains">
                                                                    <a href="#">Overview</a>
                                                                </li>
                                                                <li class="toggle toggle__selection__lg__btn recent_posts"
                                                                    data-target="postinsights__container__contains">
                                                                    <a href="#">Post</a>
                                                                </li>
                                                                <!-- <li class="toggle toggle__selection__lg__btn hastags"
                                                                    data-target="hashtag__container__contains">
                                                                    <a href="#">Hashtag</a>
                                                                </li>
                                                                <li class="toggle toggle__selection__lg__btn competitors"
                                                                    data-target="competitor__container__contains">
                                                                    <a href="#">Competitor</a>
                                                                </li> -->
                                                            </ul>
                                                        </div>
                                                        <div class="buttons__area">
                                                            <div class="selection__route">
                                                                <button
                                                                    class="selection__button__export border__changeable">
                                                                    <span
                                                                        class="px-1"><?php echo get_auth_user()->fname . ' ' . get_auth_user()->lname; ?></span><i
                                                                        class='fa fa-angle-down'></i>
                                                                </button>
                                                                <div class="selection__menu__export">
                                                                    <!-- <a class="nav-link cursor-pointer">All members</a> -->
                                                                    <a
                                                                        class="nav-link cursor-pointer active_date"><?php echo get_auth_user()->fname . ' ' . get_auth_user()->lname ?></a>
                                                                </div>
                                                            </div>
                                                            <div class="selection__route">
                                                                <button
                                                                    class="selection__button__export border__changeable">
                                                                    <span class="px-1 selected_date">Last 7
                                                                        Days</span><i class='fa fa-angle-down'></i>
                                                                </button>
                                                                <div class="selection__menu__export">
                                                                    <a class="border-0 col-12 nav-link text-left w-100 cursor-pointer date_pick active_date"
                                                                        data-value="last_7_days">
                                                                        Last 7 Days
                                                                    </a>
                                                                    <a class="border-0 col-12 nav-link text-left w-100 cursor-pointer date_pick"
                                                                        data-value="last_14_days">
                                                                        Last 14 Days
                                                                    </a>
                                                                    <a class="border-0 col-12 nav-link text-left w-100 cursor-pointer date_pick"
                                                                        data-value="last_28_days">
                                                                        Last 28 Days
                                                                    </a>
                                                                    <a class="border-0 col-12 nav-link text-left w-100 cursor-pointer date_pick"
                                                                        data-value="last_90_days">
                                                                        Last 90 Days
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Overview -->
                                        <div class="overview__container__contains active">
                                            <!-- Top Charts -->
                                            <div class="row g-0">
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Followers</h2>
                                                        <p class="lg__md__heading followers_count">0</p>
                                                        <div class="d-flex chart__area followers_chart_area">
                                                            <div class="chart__bar followers_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Post Reach</h2>
                                                        <p class="lg__md__heading post_reach_count">0</p>
                                                        <div class="d-flex chart__area post_reach_chart_area">
                                                            <div class="chart__bar post_reach_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Post Engagements</h2>
                                                        <p class="lg__md__heading engagements_count">0</p>
                                                        <div class="d-flex chart__area engagements_chart_area">
                                                            <div class="chart__bar engagements_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Talking About</h2>
                                                        <p class="lg__md__heading talking_about_count">0</p>
                                                        <div class="d-flex chart__area talking_about_chart_area">
                                                            <div class="chart__bar talking_about_chart"></div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Video Views</h2>
                                                        <p class="lg__md__heading video_views_count">0</p>
                                                        <div class="d-flex chart__area video_views_chart_area">
                                                            <div class="chart__bar video_views_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Link Clicks</h2>
                                                        <p class="lg__md__heading link_clicks_count">0</p>
                                                        <div class="d-flex chart__area link_clicks_chart_area">
                                                            <div class="chart__bar link_clicks_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Click Through Rate</h2>
                                                        <p class="lg__md__heading ctr_count">0%</p>
                                                        <div class="d-flex chart__area ctr_chart_area">
                                                            <div class="chart__bar ctr_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Engagement Rate</h2>
                                                        <p class="lg__md__heading eng_rate_count">0%</p>
                                                        <div class="d-flex chart__area eng_rate_chart_area">
                                                            <div class="chart__bar eng_rate_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-4 col-xxl-3 p-0 m-0">
                                                    <div class="chart__display__area">
                                                        <h2 class="sm__md__heading">Reach Rate</h2>
                                                        <p class="lg__md__heading reach_rate_count">0%</p>
                                                        <div class="d-flex chart__area reach_rate_chart_area">
                                                            <div class="chart__bar reach_rate_chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Cities and Countries -->
                                            <div class="country__city__charts">
                                                <div class="row g-0">
                                                    <div class="col-12 col-md-12 m-0 p-0">
                                                        <div class="country__chart__container">
                                                            <div class="text-wrapper bottombordered">
                                                                <p class="sm__lg__content">
                                                                    Facebook data, sorted by
                                                                    <b>COUNTRY</b>
                                                                    (top 5), about the people who like your Page
                                                                </p>
                                                            </div>
                                                            <div class="results__container__internal top_countries_no_result"
                                                                style="display:none;">
                                                                <div class="no__result__content">
                                                                    <p>No result found</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 m-0 p-0">
                                                                <canvas id="top_countries_container"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 m-0 p-0">
                                                        <div class="country__chart__container">
                                                            <div class="text-wrapper bottombordered">
                                                                <p class="sm__lg__content">
                                                                    Facebook data, sorted by
                                                                    <b>CITY</b> (top 5), about the people who like your
                                                                    Page
                                                                </p>
                                                            </div>
                                                            <div class="results__container__internal top_cities_no_result"
                                                                style="display:none;">
                                                                <div class="no__result__content">
                                                                    <p>No result found</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-12 m-0 p-0">
                                                                <canvas id="top_cities_container"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Post Overview Insights -->
                                            <div class="row g-0">
                                                <div class="col-12 m-0 p-0">
                                                    <div class="post__insights__container borderable">
                                                        <div class="text-wrapper bottombordered">
                                                            <div class="text_wrapper_content">
                                                                <h2 class="sm__md__header">
                                                                    Post Insights
                                                                </h2>
                                                                <p class="sm__md__content">
                                                                    Your most recent posts
                                                                </p>
                                                            </div>
                                                            <button
                                                                class="btn-over-light j-end toggle toggle__selection__lg__btn recent_posts"
                                                                data-target="postinsights__container__contains">
                                                                <a href="#">
                                                                    View all posts</a>
                                                            </button>
                                                        </div>
                                                        <div class="posts__insight__table">
                                                            <table class="table table-hover m-0" id="get_recent_posts">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="recent-posts">RECENT POSTS</th>
                                                                        <th>TYPE</th>
                                                                        <th>REACH</th>
                                                                        <th>REACH RATE</th>
                                                                        <th>ENG. RATE</th>
                                                                        <th>REACTIONS</th>
                                                                        <th>COMMENTS</th>
                                                                        <th>SHARES</th>
                                                                        <th>VIDEO VIEWS</th>
                                                                        <th>LINK CLICKS</th>
                                                                        <th>CTR</th>
                                                                        <th>ACTION</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Hashtag Analysis -->
                                            <!-- <div class="row g-0">
                                                <div class="col-12 m-0 p-0">
                                                    <div class="hashtag__analysis__container">
                                                        <div class="text-wrapper bottombordered">
                                                            <div class="text_wrapper_content">
                                                                <h2 class="sm__md__header">
                                                                    Hashtag Analysis
                                                                </h2>
                                                                <p class="sm__md__content">
                                                                    Your highest performing hashtags
                                                                </p>
                                                            </div>
                                                            <button class="btn-over-light j-end">
                                                                <a href="#">Show more</a>
                                                            </button>
                                                        </div>
                                                        <div class="posts__insight__table">
                                                            <table class="table m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="recent-posts">Hashtag</th>
                                                                        <th>Reach</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="results__container__internal">
                                                                                <div class="no__result__content">
                                                                                    <p>No result found</p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="results__container__internal">
                                                                                <div class="no__result__content">
                                                                                    <p>No result found</p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- Members -->
                                            <!-- <div class="row g-0">
                                                <div class="col-12 m-0 p-0">
                                                    <div class="hashtag__analysis__container">
                                                        <div class="text-wrapper bottombordered">
                                                            <div class="text_wrapper_content">
                                                                <h2 class="sm__md__header">
                                                                    Members
                                                                </h2>
                                                                <p class="sm__md__content">
                                                                    Activity of members
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="posts__insight__table">
                                                            <table class="table m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="recent-posts">Name</th>
                                                                        <th>Reach</th>
                                                                        <th>Engagement</th>
                                                                        <th>Posts</th>
                                                                        <th>Social Accounts</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="added__post__content__overview">
                                                                        <td class="post__header">
                                                                            Shahroze Masood
                                                                        </td>
                                                                        <td>
                                                                            <span>Reach</span>
                                                                            12
                                                                        </td>
                                                                        <td>
                                                                            <span>Engagement</span>
                                                                            3
                                                                        </td>
                                                                        <td>
                                                                            <span>Posts</span>
                                                                            15
                                                                        </td>
                                                                        <td>
                                                                            <span>Social Accounts</span>
                                                                            Social Account
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- Hashtag Analysis -->
                                        <!-- <div class="hashtag__container__contains">
                                            <div class="row g-0" id="hashtag-analysis">
                                                <div class="col-12 m-0 p-0">
                                                    <div class="post__insights__container active">
                                                        <div class="text_wrapper_content">
                                                            <h2 class="sm__md__header">
                                                                Hashtag Analysis
                                                            </h2>
                                                            <p class="sm__md__content">
                                                                Detailed metrics for each hashtag
                                                            </p>
                                                        </div>
                                                        <div class="search__bar__area">
                                                            <div class="input__group">
                                                                <i class='bx bx-search'></i>
                                                                <input type="text" placeholder="Search">
                                                            </div>
                                                        </div>
                                                        <div class="posts__insight__table">
                                                            <table class="table m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="recent-posts">Recent Posts</th>
                                                                        <th>Impressions</th>
                                                                        <th>Likes</th>
                                                                        <th>Comments</th>
                                                                        <th>Shares</th>
                                                                        <th>engagements</th>
                                                                        <th>Published</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Adublisher
                                                                                    </p>
                                                                                    <p class="post__description">
                                                                                        With every heartbeat, dreams
                                                                                        take flight
                                                                                        and
                                                                                        soar, chasing shadows of the
                                                                                        past,
                                                                                        seeking
                                                                                        something more.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog12.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>1000</td>
                                                                        <td>150</td>
                                                                        <td>30</td>
                                                                        <td>5</td>
                                                                        <td>Active</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Dreams</p>
                                                                                    <p class="post__description">
                                                                                        Dreams remain just dreams
                                                                                        without
                                                                                        action.
                                                                                        Hard work turns visions into
                                                                                        reality.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog11.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div
                                                                                class="overview__post__menu colm__fixed">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Success</p>
                                                                                    <p class="post__description">
                                                                                        Success isn't final, and failure
                                                                                        isn't
                                                                                        fatal. What matters is the
                                                                                        courage to
                                                                                        continue.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog8.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Destination
                                                                                    </p>
                                                                                    <p class="post__description">
                                                                                        Life is full of twists and
                                                                                        turns.
                                                                                        Embrace
                                                                                        the journey, not just the
                                                                                        destination.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog5.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Happiness
                                                                                    </p>
                                                                                    <p class="post__description">
                                                                                        Happiness isn't found in things,
                                                                                        but in
                                                                                        moments. Cherish the little joys
                                                                                        around
                                                                                        you.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog3.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- Post Insights -->
                                        <div class="postinsights__container__contains">
                                            <div class="row g-0" id="post-insights">
                                                <div class="col-12 m-0 p-0">
                                                    <div>
                                                        <div class="text-wrapper">
                                                            <h2 class="sm__md__header posts_count">
                                                                Posts
                                                            </h2>
                                                            <p class="sm__md__content">
                                                                Detailed metrics for each post
                                                            </p>
                                                        </div>
                                                        <div class="search__bar__area">
                                                            <div class="input__group">
                                                                <label for="search_recent_posts"
                                                                    class="cursor-pointer p-0 m-0">
                                                                    <i class='bx bx-search'></i></label>
                                                                <input type="text" placeholder="Search"
                                                                    id="search_recent_posts">
                                                                <span class="px-1 cursor-pointer"
                                                                    style="font-size: 15px;"
                                                                    id="clear_posts_search">x</span>
                                                            </div>
                                                            <div class="selection__route">
                                                                <button class="selection__button">
                                                                    <span class="px-1 selected_type">
                                                                        All Post Types
                                                                    </span>
                                                                    <i class='fa fa-angle-down'></i>
                                                                </button>
                                                                <div class="selection__menu">
                                                                    <a class="nav-link cursor-pointer type_pick active_type"
                                                                        data-value="">All Post Types</a>
                                                                    <a class="nav-link cursor-pointer type_pick"
                                                                        data-value="Shared Post">Status Update</a>
                                                                    <a class="nav-link cursor-pointer type_pick"
                                                                        data-value="Link">Link</a>
                                                                    <a class="nav-link cursor-pointer type_pick"
                                                                        data-value="Carousel">Carousel</a>
                                                                    <a class="nav-link cursor-pointer type_pick"
                                                                        data-value="Photo">Photo</a>
                                                                    <a class="nav-link cursor-pointer type_pick"
                                                                        data-value="GIF">Gif</a>
                                                                    <a class="nav-link cursor-pointer type_pick"
                                                                        data-value="Video">Video</a>
                                                                </div>
                                                            </div>
                                                            <div class="selection__route">
                                                                <select name="pagination" id="recent_posts_pagination"
                                                                    class="selection__button">
                                                                    <option value="10">10</option>
                                                                    <option value="50">50</option>
                                                                    <option value="100">100</option>
                                                                    <option value="250">250</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="posts__insight__table">
                                                            <table class="table table-hover m-0"
                                                                id="recent_posts_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="recent-posts">RECENT POSTS</th>
                                                                        <th>TYPE</th>
                                                                        <th>REACH</th>
                                                                        <th>REACH RATE</th>
                                                                        <th>ENG. RATE</th>
                                                                        <th>REACTIONS</th>
                                                                        <th>COMMENTS</th>
                                                                        <th>SHARES</th>
                                                                        <th>VIDEO VIEWS</th>
                                                                        <th>LINK CLICKS</th>
                                                                        <th>CTR</th>
                                                                        <th>ACTION</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="post__insights__pagination__container">
                                                            <ul class="pagination">
                                                                <li class="pagination__item">
                                                                    <i
                                                                        class='pagination__link bx bx-chevron-left cursor-pointer previous_page'></i>
                                                                </li>
                                                                <li class="pagination__item pagination__info">Page 1
                                                                    of 15
                                                                </li>
                                                                <li class="pagination__item">
                                                                    <i
                                                                        class='pagination__link bx bx-chevron-right cursor-pointer next_page'></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Competitor Analysis -->
                                        <!-- <div class="competitor__container__contains">
                                            <div class="row g-0" id="hashtag-analysis">
                                                <div class="col-12 m-0 p-0">
                                                    <div class="post__insights__container">
                                                        <div class="text_wrapper_content">
                                                            <h2 class="sm__md__header">
                                                                Competitor Analysis
                                                            </h2>
                                                            <p class="sm__md__content">
                                                                Compare the performance of your page with others.
                                                            </p>
                                                        </div>
                                                        <div class="search__bar__area">
                                                            <div class="input__group">
                                                                <i class='bx bx-search'></i>
                                                                <input type="text" placeholder="Search">
                                                            </div>
                                                        </div>
                                                        <div class="posts__insight__table">
                                                            <table class="table m-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="recent-posts">Page</th>
                                                                        <th>Followers</th>
                                                                        <th>Reach</th>
                                                                        <th>Posts</th>
                                                                        <th>Engagement</th>
                                                                        <th>ENG. Rate</th>
                                                                        <th>Videos</th>
                                                                        <th>Photos</th>
                                                                        <th>Links</th>
                                                                        <th>Text</th>
                                                                        <th>Best Time</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Adublisher
                                                                                    </p>
                                                                                    <p class="post__description">
                                                                                        With every heartbeat, dreams
                                                                                        take flight
                                                                                        and
                                                                                        soar, chasing shadows of the
                                                                                        past,
                                                                                        seeking
                                                                                        something more.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog12.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>1000</td>
                                                                        <td>150</td>
                                                                        <td>30</td>
                                                                        <td>5</td>
                                                                        <td>Active</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Dreams</p>
                                                                                    <p class="post__description">
                                                                                        Dreams remain just dreams
                                                                                        without
                                                                                        action.
                                                                                        Hard work turns visions into
                                                                                        reality.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog11.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div
                                                                                class="overview__post__menu colm__fixed">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Success</p>
                                                                                    <p class="post__description">
                                                                                        Success isn't final, and failure
                                                                                        isn't
                                                                                        fatal. What matters is the
                                                                                        courage to
                                                                                        continue.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog8.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Destination
                                                                                    </p>
                                                                                    <p class="post__description">
                                                                                        Life is full of twists and
                                                                                        turns.
                                                                                        Embrace
                                                                                        the journey, not just the
                                                                                        destination.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog5.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        class="added__post__content__overview colm__fixed">
                                                                        <td>
                                                                            <div class="post__content__data">
                                                                                <div class="post__text__content">
                                                                                    <p class="post__header">Happiness
                                                                                    </p>
                                                                                    <p class="post__description">
                                                                                        Happiness isn't found in things,
                                                                                        but in
                                                                                        moments. Cherish the little joys
                                                                                        around
                                                                                        you.
                                                                                    </p>
                                                                                    <span
                                                                                        class="post__date">2024-09-24</span>
                                                                                </div>
                                                                                <div class="post__img__container">
                                                                                    <img src="<?php echo NewLandingAssets . 'images/blog3.jpg'; ?>"
                                                                                        alt="Image description">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>2000</td>
                                                                        <td>250</td>
                                                                        <td>50</td>
                                                                        <td>10</td>
                                                                        <td>Inactive</td>
                                                                        <td>
                                                                            <div class="overview__post__menu">
                                                                                <button
                                                                                    class="menu__list__post__toggler">
                                                                                    <i class='bx bx-dots-horizontal-rounded'
                                                                                        onclick="setupToggleButtons(event)"></i>
                                                                                </button>
                                                                                <div id="menu-toggle"
                                                                                    class="menu__list__post">
                                                                                    <a href="#" class="nav-link">Reuse
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">Share
                                                                                        Post</a>
                                                                                    <a href="#" class="nav-link">View
                                                                                        Post</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- post pop up modal -->
<div id="popup" class="popup" style="display:none;">
    <div class="popup-container">
        <div class="popup-body-content">
            <div class="popup-body p-0 m-0">
                <div class="row g-0 m-0">
                    <div class="col-12 col-md-6">
                        <div class="popup__post__analytics__header d-flex d-md-none mb-5">
                            <h2 class="sm__md__header">Post Analytics</h2>
                            <span class="close-button">&times;</span>
                        </div>
                        <div class="popup__post__content__area">
                            <div class="popup__heading__area">
                                <p class="popup__head__page__name"></p>
                                <p class="popup__head__description"></p>
                            </div>
                            <div class="popup__post__image__area">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="popup__post__analytics__area">
                            <div class="popup__post__analytics__header d-none d-md-flex">
                                <h2 class="sm__md__header">Post Analytics</h2>
                                <span class="close-button">&times;</span>
                            </div>
                            <div class="popup__post__analytics__container">
                                <div class="row g-0  m-0">
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Reactions
                                            </p>
                                            <p class="large__heading">
                                                0
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Comments
                                            </p>
                                            <p class="large__heading">
                                                0
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Shares
                                            </p>
                                            <p class="large__heading">
                                                0
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Post Clicks
                                            </p>
                                            <p class="large__heading">
                                                0
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Link Clicks
                                            </p>
                                            <p class="large__heading">
                                                0
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Reach
                                            </p>
                                            <p class="large__heading">
                                                0
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Video Views
                                            </p>
                                            <p class="large__heading">
                                                --
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Engagement Rate
                                            </p>
                                            <p class="large__heading">
                                                0%
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Click Through Rate
                                            </p>
                                            <p class="large__heading">
                                                0%
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0">
                                        <div class="analytics__small__container">
                                            <p class="small__heading">
                                                Reach Rate
                                            </p>
                                            <p class="large__heading">
                                                0%
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="post__analytics__button__holder">
                                    <button class="btn-shady-dark mlight-3">
                                        Edit Post
                                    </button>
                                    <button class="btn-colored mlight-3">
                                        View Post
                                    </button>
                                    <div class="upward-menu-container">
                                        <button class="upward-menu-toggler mlight-3">
                                            <i class="bx bx-chevron-up"></i>
                                        </button>
                                        <div class="upward-menu" style="display: none;">
                                            <a href="#" class="nav-link">Reuse Post</a>
                                            <a href="#" class="nav-link">Share Post</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- infinity preloader -->
<div class="infinity_preload">
    <?php echo infinity_preloader(); ?>
</div>
<?php
$this->load->view('templates/publisher/footer');
?>
<script src="<?php echo NewLandingAssets . 'dashboard.js'; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    $(document).ready(function () {
        // fetch recent post function
        var recent_posts = $('#recent_posts_table').DataTable({
            serverSide: true,
            searching: false,
            lengthChange: false,
            paging: false,
            processing: $('.infinity_preload').html(),
            iDisplayLength: '10',
            order: [[0, 'desc']],
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>recent_posts',
                data: function (data) {
                    data.social_type = $('#social_type').val();
                    data.sub_social = $('#page_board_channel').val();
                    data.search = $('#search_recent_posts').val();
                    data.current_page = $('#current_page').val();
                    data.date = $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val();
                    data.type = $('#selected_type').val();
                    data.paging = $('#recent_posts_pagination').val();
                },
                complete: function (response) {
                    response = response.responseJSON;
                    var status = response.status;
                    var message = response.message;
                    if (status) {
                        $('.post__insights__pagination__container').show();
                        var current_page = response.current_page;
                        var total_pages = response.total_pages;
                        var pagination_message = 'Page ' + current_page + ' of ' + total_pages;
                        $('#current_page').val(current_page);
                        $('#total_pages').val(total_pages);
                        $('.pagination__info').html(pagination_message);
                        var total_posts = response.iTotalRecords + ' Posts';
                        $('.posts_count').html(total_posts);
                    } else {
                        $('.posts_count').html('0 Posts');
                        $('.post__insights__pagination__container').hide();
                    }
                    var page_id = $('#page_board_channel').val();
                    var social_type = $('#social_type').val();
                    fetch_page_insight(page_id, social_type);
                    get_countries(page_id, social_type);
                    get_cities(page_id, social_type);
                }
            },
            columns: [{
                data: 'post',
                "orderable": true
            },
            {
                data: 'type',
                "orderable": false
            },
            {
                data: 'reach',
                "orderable": true
            },
            {
                data: 'reach_rate',
                "orderable": false
            },
            {
                data: 'eng_rate',
                "orderable": false
            },
            {
                data: 'reactions',
                "orderable": true
            },
            {
                data: 'comments',
                "orderable": true
            },
            {
                data: 'shares',
                "orderable": true
            },
            {
                data: 'video_views',
                "orderable": true
            },
            {
                data: 'link_clicks',
                "orderable": true
            },
            {
                data: 'ctr',
                "orderable": false
            },
            {
                data: 'action',
                "orderable": false
            },
            ]
        });
        var get_recent_posts = $('#get_recent_posts').DataTable({
            ordering: false,
            serverSide: true,
            searching: false,
            lengthChange: false,
            paging: false,
            processing: "<i class='fa fa-refresh fa-spin'></i>",
            iDisplayLength: '10',
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>get_recent_posts',
                data: function (data) {
                    data.social_type = $('#social_type').val();
                    data.sub_social = $('#page_board_channel').val();
                },
            },
            columns: [{
                data: 'post'
            },
            {
                data: 'type'
            },
            {
                data: 'reach'
            },
            {
                data: 'reach_rate'
            },
            {
                data: 'eng_rate'
            },
            {
                data: 'reactions'
            },
            {
                data: 'comments'
            },
            {
                data: 'shares'
            },
            {
                data: 'video_views'
            },
            {
                data: 'link_clicks'
            },
            {
                data: 'ctr'
            },
            {
                data: 'action'
            },
            ]
        });
        // ajax call for search in dataTable
        $('#search_recent_posts').on('keyup', function () {
            reset_current_page();
            reload_datatable();
        });
        // reset posts searchbar 
        $('#clear_posts_search').on('click', function () {
            reset_post_search();
            reset_current_page();
            $('#search_recent_posts').trigger('keyup');
        });
        // ajax call for selected date
        $('.date_pick').on('click', function () {
            reset_post_search();
            reset_current_page();
            $('.date_pick').removeClass('active_date');
            $(this).addClass('active_date');
            var selected_date = $(this).data('value');
            $('#selected_date').val(selected_date);
            var date_name = $(this).html();
            $('.selected_date').html(date_name);
            reload_datatable();
        });
        $('.type_pick').on('click', function () {
            reset_post_search();
            reset_current_page();
            $('.type_pick').removeClass('active_type');
            $(this).addClass('active_type');
            var selected_type = $(this).data('value');
            $('#selected_type').val(selected_type);
            var date_name = $(this).html();
            $('.selected_type').html(date_name);
            reload_datatable();
        });
        $('#recent_posts_pagination').on('change', function () {
            reload_datatable();
        });
        // ajax call for pagination in dataTable
        $('.previous_page').on('click', function () {
            var current_page = $('#current_page').val();
            if (current_page == 1 || current_page == null || current_page == '') {
                return false;
            }
            else {
                current_page = parseInt(current_page) - 1;
                $('#current_page').val(current_page);
                reload_datatable();
            }
        });
        $('.next_page').on('click', function () {
            var current_page = $('#current_page').val();
            var total_pages = $('#total_pages').val();
            if (current_page == total_pages) {
                return false;
            }
            else {
                current_page = parseInt(current_page) + 1;
                $('#current_page').val(current_page);
                reload_datatable();
            }
        });
        // datatable functions
        var reset_current_page = function () {
            $('#current_page').val(1);
        }
        var reset_post_search = function () {
            $('#search_recent_posts').val('');
        }
        var reload_datatable = function () {
            recent_posts.ajax.reload();
        }
        // ajax call for fetch page insight
        var fetch_page_insight = function (page_id, social_type) {
            var insights_array = ['followers_count', 'post_reach_count', 'engagements_count', 'video_views_count', 'link_clicks_count', 'ctr_count', 'eng_rate_count', 'reach_rate_count'];
            var infinity_preloader = $('.infinity_preload').html();
            $.each(insights_array, function (index, value) {
                $('.' + value).html(infinity_preloader);
            });
            $.ajax({
                url: "<?php echo SITEURL; ?>page_insights",
                type: "GET",
                data: {
                    page_type: social_type,
                    page_id: page_id,
                    date: $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val()
                },
                success: function (response) {
                    var data = response.data[0];
                    $.each(data, function (index, value) {
                        count = value.value > 0 ? value.value : 0
                        $('.' + index + '_count').html(value.value);
                        $('.' + index + '_chart_area').html(value.html);
                    });
                }
            })
        }
        // facebook page click
        $('.active_account__detail').on('click', function () {
            reset_current_page();
            var page_id = $(this).find('.select_account').data('id');
            var page_type = $(this).find('.select_account').data('type');
            var page_name = $(this).find('.select_account').data('name');
            var profile_pic = $(this).find('.select_account').data('image');
            $('#page_board_channel').val(page_id);
            $('#social_type').val(page_type);
            $('.page__name').html(page_name);
            if (page_id != '' && page_id != null && page_id != undefined) {
                check_insights_status(page_id, page_type);
                $('.sync__button').show();
            }
            if (profile_pic != '' && profile_pic != null && profile_pic != undefined) {
                profile_pic = "<?php echo SITEURL . '/assets/bulkuploads/' ?>" + profile_pic;
                $('.page__img img').attr('src', profile_pic);
            }
            $('.active_account__detail').removeClass('active_account badge-pill bg-secondary');
            $(this).addClass('active_account badge-pill bg-secondary');
            $('#page_board_channel').trigger('change');
        });
        // page(s) input
        $('#page_board_channel').on('change', function () {
            reload_datatable();
        });
        // refresh page and post insights
        $(document).on('click', '.refresh', function () {
            var page = $('#page_board_channel').val();
            var social = $('#social_type').val();
            page = (page == '' || page == null || page == undefined) ? 'all' : page;
            refresh_data(social, page);
        });
    });
    var refresh_data = function (social, page) {
        $.ajax({
            'url': '<?php echo SITEURL ?>refresh_insights',
            'type': 'POST',
            data: {
                'social': social,
                'page': page
            },
            success: function (response) {
                $('.refresh').addClass('bg-success');
                $('.fa-refresh').html('');
                var message = response.message;
                $('.refresh').html(message);
                $('.refresh').removeClass('refresh');
            }
        });
    }
    // insights status of facebook page
    var check_insights_status = function (page_id, page_type) {
        $.ajax({
            url: "<?php SITEURL ?>check_insights_status",
            type: "GET",
            data: {
                'page_id': page_id,
                'type': page_type
            },
            success: function (response) {
                var message = response.message;
                message = "<i class='fa fa-refresh mr-1'></i> " + message;
                if (response.status) {
                    $('.sync__button').removeClass('bg-success');
                    $('.sync__button').addClass('refresh');
                }
                else {
                    $('.sync__button').removeClass('refresh');
                    $('.sync__button').addClass('bg-success');
                }
                // add message
                $('.sync__button').html(message);
            }
        });
    }
    $(document).on('click', '.menu__list__post__toggler', function (event) {
        event.preventDefault();
        $(this).closest('.overview__post__menu').find('.menu__list__post').toggle();
    });
    $(document).on('click', '#recent_posts_table tbody tr', function (e) {
        var target = e.target;
        if (target.tagName === 'TD') {
            // Get the index of the cell
            var index = $(target).parent().children().index(target);
            // Check if the index is not the last column (assuming 0-based indexing)
            if (index !== $(target).parent().children().length - 1) {
                var post_id = $(this).find('.post__header').data('id');
                var post_type = $(this).find('.post__header').data('type');
                post_detail(post_id, post_type);
            }
            else {
                e.preventDefault();
            }
        }
    });
    $(document).on('click', '#get_recent_posts tbody tr', function () {
        var post_id = $(this).find('.post__header').data('id');
        var post_type = $(this).find('.post__header').data('type');
        post_detail(post_id, post_type);
    });
    $(document).on('click', '.post__content__data', function () {
        var post_id = $(this).find('.post__header').data('id');
        var post_type = $(this).find('.post__header').data('type');
        post_detail(post_id, post_type);
    });
    var post_detail = function (post_id, post_type) {
        var infinity_preloader = $('.infinity_preload').html();
        $('.popup-body-content').addClass('d-flex justify-content-center').html(infinity_preloader);
        $('#popup').show();
        $.ajax({
            url: "<?php echo SITEURL ?>get_post_info",
            type: "GET",
            data: {
                'id': post_id,
                'type' : post_type
            },
            success: function (response) {
                if (response.status) {
                    $('.popup-body-content').removeClass('d-flex justify-content-center').html(response.data);
                    if (response.followers > 0 || response.non_followers > 0) {
                        var follower_config = {
                            xValue: response.followers + ' Followers',
                            yValue: response.followers,
                            barColor: "#2b5797",
                        }
                        var non_follower_config = {
                            xValue: response.non_followers + ' Non-ollowers',
                            yValue: response.non_followers,
                            barColor: "#1e7145",
                        }
                        chart(follower_config, non_follower_config);
                    }
                }
            }
        });
    }

    var top_count_chart = '';
    var get_countries = function (page_id, social_type) {
        $.ajax({
            url: "get_countires_data",
            type: "GET",
            data: {
                page_type: social_type,
                page_id: page_id,
                date: $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val()
            },
            success: function (response) {
                var data = response.data;
                if (response.count > 0) {
                    var labels = response.dates;
                    var dataset = [];
                    var borderColors = ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0'];
                    var backgroundColors = ['#cb433580', '#1F618D80', '#F1C40F80', '#27AE6080', '#884EA080'];
                    var i = 0;
                    $.each(data, function (country_name, array) {
                        var value_array = Object.values(array);
                        var temp_obj = {
                            label: country_name,
                            data: value_array,
                            borderColor: borderColors[i],
                            backgroundColor: backgroundColors[i],
                            borderWidth: 0.5
                        };
                        dataset.push(temp_obj);
                        i++;
                    });

                    $('#top_countries_container').html('');
                    if (top_count_chart != '' && top_count_chart != null) {
                        destroyCountryChart();
                    }
                    top_countries_chart(labels, dataset);
                }
                else {
                    $('.top_countries_no_result').show();
                    $('#top_countries_container').hide();
                }
            }
        });
    }

    var top_city_chart = '';
    var get_cities = function (page_id, social_type) {
        $.ajax({
            url: "get_cities_data",
            type: "GET",
            data: {
                page_type: social_type,
                page_id: page_id,
                date: $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val()
            },
            success: function (response) {
                var data = response.data;
                if (response.count > 0) {
                    var labels = response.dates;
                    var dataset = [];
                    var borderColors = ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0'];
                    var backgroundColors = ['#cb433580', '#1F618D80', '#F1C40F80', '#27AE6080', '#884EA080'];
                    var i = 0;
                    $.each(data, function (city_name, array) {
                        var value_array = Object.values(array);
                        var temp_obj = {
                            label: city_name,
                            data: value_array,
                            borderColor: borderColors[i],
                            backgroundColor: backgroundColors[i],
                            borderWidth: 0.5
                        };
                        dataset.push(temp_obj);
                        i++;
                    });

                    $('#top_cities_container').html('');
                    if (top_city_chart != '' && top_city_chart != null) {
                        destroyCitiesChart();
                    }
                    top_cities_chart(labels, dataset);
                }
                else {
                    $('.top_cities_no_result').show();
                    $('#top_cities_container').hide();
                }
            }
        });
    }
    // horizontal chart for top cities
    var top_cities_chart = function (labels, datasets) {
        const xAxisLabels = labels;
        const data = {
            labels: xAxisLabels,
            datasets: datasets,
        };

        top_city_chart = new Chart("top_cities_container", {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    }
    // horizontal chart for top countries
    var top_countries_chart = function (labels, datasets) {
        const xAxisLabels = labels;
        const data = {
            labels: xAxisLabels,
            datasets: datasets,
        };

        top_count_chart = new Chart("top_countries_container", {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    }

    function destroyCountryChart() {
        top_count_chart.destroy();
    }
    function destroyCitiesChart() {
        top_city_chart.destroy();
    }
    // doughnot chart for post reach 
    var chart = function (follower_config, non_follower_config) {
        var xValues = [follower_config.xValue, non_follower_config.xValue];
        var yValues = [follower_config.yValue, non_follower_config.yValue];
        var barColors = [
            follower_config.barColor,
            non_follower_config.barColor
        ];
        new Chart("reach_chart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                    hoverOffset: 10
                }],
            }
        });
    };
    $(document).on('click', '.close-button', function () {
        $('#popup').hide();
    });
</script>