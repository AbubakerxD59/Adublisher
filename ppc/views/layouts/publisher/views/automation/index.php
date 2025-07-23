<div class="row" id="content_area">
    <div class="col-md-12">
        <?php
        if (count(get_all_social_accounts()) == 0) {
        ?>
            <div class="col-md-12 text-center">
                <div class="alert alert-danger">
                    <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> No Social
                        Account connected </h3>
                    <p><br>Click <a href="<?php echo SITEURL . 'social-accounts'; ?>"> HERE </a> to
                        connect right now. so Adublisher can publish posts you schedule/set.<br>
                        <b>Note - we will NEVER send anything to your friends or post anything that
                            you haven't scheduled/set first!</b>
                    </p>
                    <p>Later you can disconnect this app, just like any other social media based
                        app.</p>
                </div>
            </div>
    </div>
<?php
        }

?>
<!-- Column -->
<?php
if (count($user_pages) > 0 || count($pinterest_boards) > 0 || count($ig_accounts) > 0 || count($fb_groups) > 0) {
?>
    <div>
        <div>
            <!-- Rss -->
            <div class="col-md-4 automation-socials p-2 active" id="rss">
                <img src="<?= ASSETURL ?>images/rss_logo.png" width="80"><br><br>
                <small>Your Regular <strong>Rss Feed</strong></small>
            </div>
            <!-- Shopify -->
            <!-- <div class="col-md-4 automation-socials" id="shopify">
                <div class="row p-2">
                    <div class="col-md-8">
                        <img src="<?= GeneralAssets ?>images/shopify_attachments/shopify_logo.png" width="80">
                    </div>
                    <div class="col-md-4">
                        <?php if (empty($user[0]->shopify_adminApiAccessToken)): ?>
                            <button type="button" class="btn btn-info btn-sm shopify-attach-button float-right" data-toggle="modal" data-target="#staticBackdrop">
                                <i class="fa-brands fa-shopify">&nbsp;</i> Attach Shopify
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-info btn-sm shopify-disconnect-button float-right">
                                <i class="fa-brands fa-shopify">&nbsp;</i> Disconnect Shopify
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <br>
                <small>Want to fetch your Shopify Store products? Click Here <a data-toggle="modal" href="#shopify-modal">more info!</a></small>
            </div> -->
            <!-- youtube -->
            <!-- <div class="col-md-4 automation-socials p-2" id="youtube">
                <img src="<?= GeneralAssets ?>images/youtube_logo.png" width="50"><br><br>
                <small>Coming Soon!</small>
            </div> -->
        </div>
    </div>
    <!-- End -->
    <!-- <div class="col-md-4 align-self-center">
        <?php if (empty($user[0]->shopify_adminApiAccessToken)): ?>
            <button type="button" class="btn btn-info shopify-attach-button float-right" data-toggle="modal" data-target="#staticBackdrop">
                <i class="fa-brands fa-shopify">&nbsp;</i> Attach Shopify
            </button>
        <?php else: ?>
            <button type="button" class="btn btn-info shopify-disconnect-button float-right">
                <i class="fa-brands fa-shopify">&nbsp;</i> Disconnect Shopify
            </button>
        <?php endif; ?>
    </div> -->
    <div class="card my-2 social-active-color" id="allstepsdiv">
        <div class="card-body">
            <div class="row my-2">
                <div class="form-group col-md-4" id="step1">
                    <label><b>Step 1-</b> Select Channel: <i class="mdi mdi-help-circle-outline"
                            data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="First step is to select channel, your channel must have published status on channel's account."></i>
                    </label>
                    <input type="hidden" id="title" value="This is the test Tile">
                    <select id="pages" class=" form-control">
                        <option value="">Select Channel</option>
                        <?php
                        if (count($user_pages) > 0) {
                            foreach ($user_pages as $page) {
                        ?>
                                <option value="<?= $page->id; ?>" <?php echo $user[0]->selected_rss == $page->id ? "selected" : ""; ?>
                                    data-type="facebook" data-name="<?= $page->page_name; ?>">
                                    <?= $page->page_name; ?> / FACEBOOK
                                </option>
                            <?php
                            }
                        }
                        if (count($fb_groups) > 0) {
                            foreach ($fb_groups as $group) {
                            ?>
                                <option value="<?= $group->id ?>" <?php echo $user[0]->selected_rss == $group->id ? "selected" : ""; ?>
                                    data-type="fb_group" data-name="<?= $group->name ?>">
                                    <?= $group->name ?> / FB-GROUP
                                </option>
                            <?php
                            }
                        }
                        if (count($pinterest_boards) > 0) {
                            foreach ($pinterest_boards as $board_item) {
                            ?>
                                <option value="<?= $board_item->id; ?>" <?php echo $user[0]->selected_rss == $board_item->id ? "selected" : ""; ?>
                                    data-type="pinterest" data-name="<?= $board_item->name; ?>">
                                    <?= $board_item->name; ?> / PINTEREST
                                </option>
                            <?php
                            }
                        }
                        if (count($ig_accounts) > 0) {
                            foreach ($ig_accounts as $ig_item) {
                            ?>
                                <option value="<?= $ig_item->id; ?>" <?php echo $user[0]->selected_rss == $ig_item->id ? "selected" : ""; ?>
                                    data-type="instagram"
                                    data-name="<?= $ig_item->instagram_username; ?>">
                                    <?= $ig_item->instagram_username; ?> / INSTAGRAM
                                </option>
                            <?php
                            }
                        }
                        if (count($tiktoks) > 0) {
                            foreach ($tiktoks as $tiktok) {
                            ?>
                                <option value="<?= $tiktok->id; ?>" <?php echo $user[0]->selected_rss == $tiktok->id ? "selected" : ""; ?>
                                    data-type="tiktok" data-name="<?= $tiktok->username; ?>">
                                    <span>
                                        <?php echo $tiktok->username; ?> / TIKTOK
                                    </span>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <br><br>
                    <!-- rss posting -->
                    <div class="row on_off" style="display: none;">
                        <div class="col-md-7 pl-3">
                            <small>
                                Turn Rss posting ON and OFF
                            </small>
                        </div>
                        <div class="col-md-5">
                            <label class="switch">
                                <input type="checkbox" class="rssposting" checked="">
                                <div class="slider"></div>
                                <div class="slider-card">
                                    <div class="slider-card-face slider-card-front"></div>
                                    <div class="slider-card-face slider-card-back"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <!-- auto shuffling -->
                    <div class="row on_off" style="display: none;">
                        <div class="col-md-7 pl-3">
                            <small>
                                Turn Auto Shuffling ON and OFF
                            </small>
                        </div>
                        <div class="col-md-5">
                            <label class="switch">
                                <input type="checkbox" class="autoshuffling" checked="">
                                <div class="slider"></div>
                                <div class="slider-card">
                                    <div class="slider-card-face slider-card-front"></div>
                                    <div class="slider-card-face slider-card-back"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="row forshopify" style="display: none;">
                        <div class="col-md-7 pl-3"> <small> Turn Shopify posting ON and
                                OFF</small> </div>
                        <div class="col-md-5">
                            <div class="switch">
                                <label>OFF<input type="checkbox" class="shopifyposting"><span
                                        class="lever switch-col-light-blue"></span>ON</label>
                            </div>
                        </div>
                    </div>
                    <div class="row foryoutube" style="display: none;">
                        <div class="col-md-7 pl-3"> <small> Turn Youtube posting ON and
                                OFF</small> </div>
                        <div class="col-md-5">
                            <div class="switch">
                                <label>OFF<input type="checkbox" class="youtubeposting"><span
                                        class="lever switch-col-light-blue"></span>ON</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4" id="step2">
                    <label><b>Step 2-</b> Select hours:<i class="mdi mdi-help-circle-outline"
                            data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="Second step is to select time slots, You can max select 24 time slots per day. Select Atleast one time slot to enable RSS FEED input box."></i>
                    </label>
                    <select id="timeslots" multiple data-placeholder="Select Hours to post..."
                        class="chosen-select form-control">
                        <?php for ($i = 0; $i < 24; $i++): ?>
                            <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
                                <?= $i >= 12 ? 'pm' : 'am' ?>
                            </option>
                        <?php endfor ?>
                    </select>
                    <small><i class="fa fa-check text-success"></i> Time slots will
                        automatically save upon changing.</small>
                </div>
                <div class="form-group col-md-4" id="step3">
                    <div id="step-3-rss">
                        <label>
                            <b>Step 3-</b> Feed URL:
                            <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Third step is to input Rss Feed Link"></i>
                        </label>
                        <div class="to-be-cloned-container">
                            <div class="input-group">
                                <input type="url"
                                    class="form-control to-be-cloned-input original-input"
                                    style="cursor:pointer;" id="rss_feed"
                                    placeholder="Please enter url..." autocomplete="off">
                                <button
                                    class="on_off btn btn-sm btn-danger fa fa-trash-o text-danger pointer delete_rss"
                                    style="display:block; border: 1px solid red !important; border-radius: 0; padding: 12px;">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <button
                                    class="fetch_ten_more btn btn-sm btn-info pointer"
                                    style="display:block; border: 1px solid #1e88e5 !important; border-radius: 0; padding: 12px;">
                                    <i class="fas fa-arrow-alt-circle-down"></i>
                                </button>
                            </div>
                            <small class="last-run-small"></small>
                        </div>
                        <br>
                        <button class="btn btn-info float-right duplicate-button"
                            id="showButton"
                            style="display: block; padding: 8px 11px; border-radius: 0;"><i
                                class="fa fa-plus"></i></button><br><br><br>
                    </div>
                    <div id="step-3-shopify" style="display:none;">
                        <label><b>Step 3-</b> Shopify: <i class="mdi mdi-help-circle-outline"
                                data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Third step is to input Rss Feed Link"></i>
                        </label>
                        <br>
                        <button class="btn btn-info float-right shopify-rss-button"
                            id="shopifyRssButton"
                            style=" display:none; padding: 8px 11px; border-radius: 0;"><i
                                class="fa-brands fa-shopify"></i>&nbsp;Fetch Shopfy Store
                            Products</button>
                        <br><br>
                        <small class="last-run-shopify-small float-right"></small>
                    </div>
                    <div id="step-3-youtube" style="display:none;">
                        <label><b>Step 3-</b> Youtube: <i class="mdi mdi-help-circle-outline"
                                data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Third step is to input Rss Feed Link"></i>
                        </label>
                        <p>Coming Soon!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shopify Attach Modal -->
    <!-- <div class="shopify" style="display: inline;">
        <p class="m-2">Must read <a data-toggle="modal" href="#shopify-modal">this info! </a> while connecting Shopify Store.</p>
        <button type="button" style="padding: 8px 11px; border-radius: 0;" class="btn btn-info float-left shopify-int-button" data-toggle="modal" data-target="#staticBackdrop">Attach Shopify</button>
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Credentials
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="apiKey">API Key</label>
                                <input type="text" class="form-control" id="apiKey"
                                    placeholder="Enter API Key">
                            </div>
                            <div class="form-group">
                                <label for="apiSecretKey">API Secret Key</label>
                                <input type="text" class="form-control" id="apiSecretKey"
                                    placeholder="Enter API Secret Key">
                            </div>
                            <div class="form-group">
                                <label for="adminApiAccessToken">Admin API Access
                                    Token</label>
                                <input type="text" class="form-control" id="adminApiAccessToken"
                                    placeholder="Enter Admin API Access Token">
                            </div>
                            <div class="form-group">
                                <label for="storeName">Store Name</label>
                                <input type="text" class="form-control" id="storeName"
                                    placeholder="Enter Store Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"
                            id="ShopifyCredentials">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Shopify Info Modal -->
    <!-- <div class="modal fade" id="shopify-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Connecting Shopify Store
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> To link a Shopify Store and schedule products through Adublisher,
                        authentication is required through your Shopify Store.</p>
                    <hr>
                    <article>
                        <header>
                            <h3 style="display:inline;">Connecting Shopify Store <small><a
                                        href="https://admin.shopify.com/" target="_blank">Click
                                        here</a></small></h3>
                            <br>
                        </header>
                        <div>
                            <p>You will need to complete these steps</p>
                            <ol class="list-colored">
                                <li>
                                    <p>Log into your Shopify account</p>
                                </li>
                                <li>
                                    <p>Copy the <strong>Store Name</strong> from the
                                        <em>URL</em> for Later Use and then Click
                                        <em><strong>Settings</strong></em> on the left hand
                                        side.
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/1.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/1.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Find the <em><strong>Apps and sales channels in Menu
                                                section </strong></em>towards the bottom of
                                        the page and then click on it <em><strong>Apps and
                                                sales channels</strong></em>.</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/2.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/2.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Click On Develop apps.</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/4.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/4.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Click On Create an app.</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/5.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/5.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Give Your App any Name <em><strong>(Example :
                                                Adublisher)</strong></em> and then click on
                                        Create app.</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/6.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/6.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Click on <em><strong>Configure Admin Api
                                                Scopes</strong></em> </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/7.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/7.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Search for <em><strong>read_product</strong></em>
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/8.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/8.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Check the <em><strong>read_products
                                                checkbox</strong></em> and click on Save in
                                        upper right corner.</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/9.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/9.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Click on <em><strong>API credentials
                                                tab</strong></em></p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/10.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/10.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Scroll Down to get <em><strong>API key and Api Secret
                                                key</strong></em> Make sure to copy them for
                                        later use</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/11.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/11.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Scroll Above again to install your app, Click on
                                        <em><strong>Install app </strong></em>button in the
                                        upper right corner
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/12.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/12.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Just Click on <em><strong>Install</strong></em>
                                        button</p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/13.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/13.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Reveal your token by clicking <em><strong>Reveal
                                                token once </strong></em></p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/14.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/14.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Make sure to copy and save this token for later use
                                        <em><strong>You can only get this Token one time
                                            </strong></em>
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/15.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/15.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Click On <strong>Attach Shopify</strong> button <em>
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/16.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/16.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Now Paste all the Credentials in the <strong>Attach
                                            Shopify</strong> modal that you copied earlier
                                        <em><strong>1 - Api Key , 2 - Api Secret Key , 3 -
                                                Admin Api Access Token , 4 - Store Name
                                            </strong></em>and click on Submit
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/17.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/17.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Now select any <strong>Channel</strong> from
                                        <em><strong>Step 1 - Select Channel</strong></em>
                                        and click on <strong>Fetch Products</strong> button
                                        to fetch Product for the selected channel
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/18.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/18.png')">
                                    </p>
                                </li>
                                <li>
                                    <p>Your Shopify <strong>Scheduled Products</strong><em>
                                    </p>
                                    <p>
                                        <img class="image-popup-fit-width"
                                            src="<?= GeneralAssets ?>images/shopify_attachments/19.png"
                                            width="600"
                                            onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/19.png')">
                                    </p>
                                </li>
                            </ol>
                        </div>
                    </article>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Showing Shopify Instruction Images on POP Up -->
    <!-- <div class="image-popup-overlay" id="imagePopupOverlay">
        <div class="image-popup-content">
            <span class="close-btn" onclick="closeImagePopup()">&times;</span>
            <img id="popupImage" class="img-fluid" src="" alt="Popup Image">
        </div>
    </div> -->
    <!-- End Shopify -->
    <div class="card ">
        <div class="card-header ">
            <div class="row">
                <div
                    class="col-md-12 m-t-10 text-left d-block d-md-flex justify-content-between">
                    <div>
                        <button class="btn btn-info rss_posts_tab_scheduled"
                            data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="Here you can manage the existing posts on pages. Select Page to load posts">Scheduled
                            Posts</button>
                        <button class="btn btn-secondary rss_posts_tab_published"
                            data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="Select Page to load published posts.">Published
                            Posts</button>
                        <!-- <b>Manage Scheduled Posts </b> <span id="pagenamedisplay"></span>: <i class="mdi mdi-help-circle-outline" ></i> -->
                    </div>
                    <div class="row info_tab" style="display: none;">
                        <div class="form-group col-md-12 text-center">
                            <div>
                                <small>TOTAL POSTS: </small>
                                <span class="total_posts" style="font-weight: 800;"></span>
                            </div>
                            <div>
                                <small class="pl-3">SCHEDULED UNTIL: </small>
                                <span class="scheduled_until" style="font-weight: 800;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger deleteall btn-sm"
                            style="display: none; height: fit-content;" data-error="all"
                            data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="Deletes current Feed."><i
                                class="fa fa-trash pointer"></i> Delete All</button>
                        <button class="btn btn-success shuffle btn-sm mx-2"
                            style="display: none; height: fit-content;" data-toggle="tooltip"
                            data-placement="bottom" title=""
                            data-original-title="Shuffles current Feed."><i
                                class="fa fa-sync pointer"></i> Shuffle</button>
                        <button class="btn btn-primary refresh_timeslots btn-sm"
                            style="display: none; height: fit-content;" data-toggle="tooltip"
                            data-placement="bottom" title=""
                            data-original-title="Refresh timeslots of current Feed. Fill the missing timeslots."><i
                                class="fa fa-hourglass pointer"></i> Refresh</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body b-t">
            <div class="col-md-12 row el-element-overlay" id="sceduled">
            </div>
        </div>
    </div>
<?php
}
?>
</div>