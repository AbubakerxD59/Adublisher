<div class="">
    <div class="row analytics-row-setup">
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
                                <img src="<?php echo ASSETURL . 'images/blog9.jpg'; ?>">
                            </div>
                        </div>
                        <div class="account__detail sm">
                            <div class="account__img">
                                <img src="<?php echo ASSETURL . 'images/blog12.jpg'; ?>">
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
                                                src="<?php echo ASSETURL . 'images/avatar2.png'; ?>">
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
                                        </ul>
                                    </div>
                                    <div class="buttons__area">
                                        <div class="selection__route">
                                            <button
                                                class="selection__button__export border__changeable">
                                                <span
                                                    class="px-1"><?php echo get_auth_user()->username ?></span><i
                                                    class='fa fa-angle-down'></i>
                                            </button>
                                            <div class="selection__menu__export">
                                                <a class="nav-link cursor-pointer active_date"><?php echo get_auth_user()->username ?></a>
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
                    </div>
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