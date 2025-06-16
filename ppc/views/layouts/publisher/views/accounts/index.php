<input type="hidden" id="limit_check"
    value="<?php echo limit_check(AUTHORIZE_SOCIAL_ACCOUNTS_ID, 2) ? '1' : '0'; ?>">
<div class="col-md-12 p-3">
    <div class="row">
        <!-- Facebook -->
        <div class="col-md-6 col-12 text-center pb-3">
            <?php
            if (empty($user->facebook_id && $user->facebook_name)) {
            ?>
                <img style="width:40px;height:40px;"
                    src="<?php echo ASSETURL . 'images/Icons/facebook-circle.svg'; ?>"
                    class="rounded mr-3" alt="profile_pic">
                <a href="<?php echo $connect_facebook; ?>"
                    class="btn btn-info btn-sm authorize">Authorize Facebook</a>
            <?php
            } elseif (!empty($user->facebook_id && $user->facebook_name)) {
            ?>
                <div class="overall">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-6">
                            <div class="connected">
                                <img style="width:40px;height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/facebook-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic"><br>
                                <!-- <i style="font-size: 20px; color:#295396;" class="fa fa-check"></i>&nbsp; -->
                                <span
                                    class="fw-bold h6"><?php echo $user->facebook_name; ?></span>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-6 align-self-center">
                            <small class="m-2"> Missing page ? Click <a
                                    class="reconnect"
                                    href="<?php echo $connect_facebook; ?>"> HERE
                                </a> to add it. </small>
                        </div>
                    </div><!--row inside-->
                    <div class="disconnect">
                        <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                            disconnect Facebook ? &nbsp;<button
                                class="btn btn-outline-danger btn-sm"
                                id="disconnect-facebook"><span
                                    class="fa fa-unlink"></span> click here
                            </button></h6>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>
        <!-- Pinterest -->
        <div class="col-md-6 col-12 text-center pb-3">
            <?php
            if (empty($pinterest_boards)) {
            ?>
                <img style="width:40px;height:40px;"
                    src="<?php echo ASSETURL . 'images/Icons/pinterest-circle.svg'; ?>"
                    class="rounded mr-3" alt="profile_pic">
                <!-- make the above anchor link into button -->
                <a href="<?php echo $pinterest_login_url ?>"
                    class="btn btn-info btn-sm authorize">Authorize Pinterest</a>
            <?php
            } elseif (!empty($pinterest_boards)) {
            ?>
                <div class="overall">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-6">
                            <div class="connected">
                                <img style="width:40px;height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/pinterest-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic"><br>
                                <!-- <i class="fa fa-check" style="font-size: 20px; color:#e71b22;"></i>&nbsp; -->
                                <span
                                    class="fw-bold h6"><?php echo $pinterest_account[0]->username; ?></span>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-6 align-self-center">
                            <small class="m-2"> Missing Boards ? Click <a
                                    class="reconnect"
                                    href="<?php echo $pinterest_login_url ?>"> HERE
                                </a> to add it. </small>
                        </div>
                    </div><!--row inside-->
                    <div class="disconnect">
                        <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                            disconnect Pinterest ? &nbsp;<button
                                class="btn btn-outline-danger btn-sm"
                                id="disconnect-pinterest"><span
                                    class="fa fa-unlink"></span> click here
                            </button></h6>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>
        <!-- Instagram -->
        <div class="col-md-6 col-12 text-center pb-3">
            <?php
            if (empty($ig_accounts)) {
            ?>
                <img style="width:40px;height:40px;"
                    src="<?php echo ASSETURL . 'images/Icons/instagram-circle.svg'; ?>"
                    class="rounded mr-3" alt="profile_pic">
                <a style="margin-left: 5px;"
                    href="<?php echo $instagram_login_url ?>"
                    class="btn btn-info btn-sm authorize">Authorize Instagram</a>
            <?php
            } elseif (!empty($ig_accounts)) {
            ?>
                <div class="overall">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-6">
                            <div class="connected">
                                <img style="width:40px;height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/instagram-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic"><br>
                                <span
                                    class="fw-bold h6"><?php echo $ig_accounts[0]->instagram_username; ?></span>
                                <!-- &nbsp;<i class="fa fa-check my-1" style="font-size:20px; color:#fe7203;"></i> -->
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-6 align-self-center">
                            <small class="m-2"> Missing account ? Click <a
                                    class="reconnect"
                                    href="<?php echo $instagram_login_url ?>"> HERE
                                </a> to add.</small>
                        </div>
                    </div><!--row inside-->
                    <div class="disconnect">
                        <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                            disconnect Instagram ? &nbsp;<button
                                class="btn btn-outline-danger btn-sm"
                                id="disconnect-instagram"><span
                                    class="fa fa-unlink"></span> click here
                            </button></h6>
                    </div>
                </div>
                <br>
            <?php } ?>

        </div>
        <!-- YouTube -->
        <div class="col-md-6 col-12 text-center pb-3">
            <?php
            $userID = App::Session()->get('userid');
            if (count($youtube_google_auth) == 0) {
            ?>
                <img style="width:40px; height:40px;"
                    src="<?php echo ASSETURL . 'images/Icons/youtube-circle.svg'; ?>"
                    class="rounded mr-3" alt="profile_pic">
                <a style="margin-left: 5px;" href="<?php echo $google_login_url ?>"
                    class="btn btn-info btn-sm authorize">Authorize YouTube</a>
                <br>
            <?php
            }
            if (count($youtube_google_auth) > 0) {
            ?>
                <div class="overall">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-6">
                            <div class="connected">
                                <img style="width:40px; height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/youtube-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic"><br>
                                <span
                                    class="fw-bold h6"><?php echo $user->google_name; ?></span>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-6 align-self-center">
                            <small class="m-2"> Missing Channels ? Click <a
                                    class="reconnect"
                                    href="<?php echo $google_login_url ?>"> HERE
                                </a> to add it. </small>
                        </div>
                    </div><!--row inside-->
                    <div class="disconnect">
                        <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                            disconnect Youtube ? &nbsp;<button
                                class="btn btn-outline-danger btn-sm"
                                id="disconnect-youtube"><span
                                    class="fa fa-unlink"></span> click here
                            </button></h6>
                    </div>
                </div>
                <br>
            <?php
            }
            ?>
        </div>
        <!-- TikTok -->
        <div class="col-md-6 col-12 text-center pb-3">
            <?php
            $userID = App::Session()->get('userid');
            if (count($tiktoks) == 0) {
            ?>
                <img style="width:40px; height:40px;"
                    src="<?php echo ASSETURL . 'images/Icons/tiktok-circle.svg'; ?>" class="rounded mr-3"
                    alt="profile_pic">
                <a style="margin-left: 5px;" href="<?php echo $tiktok_login ?>"
                    class="btn btn-info btn-sm authorize">Authorize TikTok</a>
                <br>
            <?php
            }
            if (count($tiktoks) > 0) {
            ?>
                <div class="overall">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-6">
                            <div class="connected">
                                <img style="width:40px; height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/tiktok-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic"><br>
                                <span
                                    class="fw-bold h6"><?php echo $tiktoks[0]->username; ?></span>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-6 align-self-center">
                            <small class="m-2"> Missing Channels ? Click <a
                                    class="reconnect"
                                    href="<?php echo $tiktok_login ?>"> HERE
                                </a> to add it. </small>
                        </div>
                    </div><!--row inside-->
                    <div class="disconnect">
                        <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                            disconnect TikTok ? &nbsp;<button
                                class="btn btn-outline-danger btn-sm"
                                id="disconnect-tiktok"><span
                                    class="fa fa-unlink"></span> click here
                            </button></h6>
                    </div>
                </div>
                <br>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
if (count($user_pages) > 0 || count($pinterest_boards) > 0 || count($ig_accounts) > 0 || count($fb_groups) > 0 || count($youtube_channels) || count($tiktoks)) {
?>
    <hr>
    <div class="row <?= REVIEW_REQUEST; ?>">
        <div class="col-md-12">
            <div class="col-5 d-inline m-3 pt-3">
                <label class="mt-4"> <b> Select timeslot for all channels
                    </b></label>
            </div>
            <div class="col-7 float-right  m-3 mr-2">
                <select id="all_channels_timeslots" multiple
                    data-placeholder="Select Hours to post..."
                    class="chosen-select chosen-all_channels_timeslots form-control">
                    <?php
                    for ($i = 0; $i < 24; $i++) {
                        if (in_array($i, $clean)) {
                    ?>
                            <option selected="selected" value="<?= $i; ?>">
                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                <?= $i >= 12 ? 'pm' : 'am' ?>
                            </option>
                        <?php
                        } else {
                        ?>
                            <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
                                <?= $i >= 12 ? 'pm' : 'am' ?>
                            </option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row <?= REVIEW_REQUEST; ?>">
        <div class="col-md-12">
            <!-- table to show userpages with additional column to save the timeslots -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-md-3">Channels Names</th>
                        <th class="col-md-8">Posting Hours</th>
                        <th class="col-md-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($user_pages as $page_item) {
                    ?>
                        <tr>
                            <td class="title"> <img style="width:40px;height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/facebook-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic">
                                <b><?php echo $page_item->page_name ?></b>
                            </td>
                            <td>
                                <?php
                                $clean = explode(',', $page_item->channel_slots); ?>

                                <select id="fbpages_timeslots<?= $page_item->id; ?>"
                                    multiple data-placeholder="Select Hours to post..."
                                    data-pageid="<?= $page_item->id; ?>"
                                    class="chosen-select chosen-fbpages_timeslots form-control">
                                    <?php
                                    for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) {
                                    ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <td align="center">
                                <span class="delete-button btn btn-outline-danger"
                                    style="opacity:0.5;" data-type="facebook"
                                    data-id="<?php echo $page_item->id; ?>"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    <?php }
                    foreach ($pinterest_boards as $board_item) {
                    ?>
                        <tr>
                            <td class="title"> <img style="width:40px;height:40px;"
                                    src="<?php echo ASSETURL . 'images/Icons/pinterest-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic">
                                <b><?php echo $board_item->name; ?></b>
                            </td>
                            <td>
                                <?php $clean = explode(',', $board_item->channel_slots); ?>
                                <select id="boards_timeslots<?= $board_item->id; ?>"
                                    multiple data-placeholder="Select Hours to post..."
                                    data-boardid="<?= $board_item->id; ?>"
                                    class="chosen-select chosen-boards_timeslots form-control">
                                    <?php for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) { ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <td align="center">
                                <span class="delete-button btn btn-outline-danger"
                                    style="opacity:0.5;" data-type="pinterest"
                                    data-id="<?php echo $board_item->id; ?>"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    <?php }
                    foreach ($ig_accounts as $ig_item) {
                    ?>
                        <tr>
                            <td class="title"> <img
                                    style="width:30px;height:30px;margin:0px 5px;"
                                    src="<?php echo ASSETURL . 'images/Icons/instagram-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic">
                                <b><?php echo $ig_item->instagram_username; ?></b>
                            </td>
                            <td>
                                <?php $clean = explode(',', $ig_item->channel_slots); ?>
                                <select id="ig_timeslots<?= $ig_item->id; ?>" multiple
                                    data-placeholder="Select Hours to post..."
                                    data-igid="<?= $ig_item->id; ?>"
                                    class="chosen-select chosen-ig_timeslots form-control">
                                    <?php for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) { ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <td align="center">
                                <span class="delete-button btn btn-outline-danger"
                                    style="opacity:0.5;" data-type="instagram"
                                    data-id="<?php echo $ig_item->id; ?>"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    <?php
                    }
                    foreach ($fb_groups as $fb_group) {
                    ?>
                        <tr>
                            <td class="title"> <img
                                    style="width:30px;height:30px;margin:0px 5px;"
                                    src="<?php echo ASSETURL . 'images/fb_group_logo.png'; ?>"
                                    class="rounded" alt="profile_pic">
                                <b><?php echo $fb_group->name; ?></b>
                            </td>
                            <td>
                                <?php $clean = explode(',', $fb_group->channel_slots); ?>
                                <select id="fbgroup_timeslots<?= $fb_group->id; ?>"
                                    multiple data-placeholder="Select Hours to post..."
                                    data-fbgroupid="<?= $fb_group->id; ?>"
                                    class="chosen-select chosen-fbgroup_timeslots form-control">
                                    <?php for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) { ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <td align="center">
                                <span class="delete-button btn btn-outline-danger"
                                    style="opacity:0.5;" data-type="fbgroup"
                                    data-id="<?php echo $fb_group->id; ?>"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    <?php
                    }
                    foreach ($youtube_channels as $youtube_channel) {
                    ?>
                        <tr>
                            <td class="title"> <img style="width:35px;margin:0px 5px;"
                                    src="<?php echo ASSETURL . 'images/Icons/youtube-circle.svg'; ?>"
                                    class="rounded" alt="profile_pic">
                                <b><?php echo $youtube_channel->channel_title; ?></b>
                            </td>
                            <td>
                                <?php $clean = explode(',', $youtube_channel->channel_slots); ?>
                                <select
                                    id="yt_channel_slots<?= $youtube_channel->id; ?>"
                                    multiple data-placeholder="Select Hours to post..."
                                    data-ytchannelid="<?= $youtube_channel->id; ?>"
                                    class="chosen-select chosen-yt_channel_slots form-control">
                                    <?php for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) { ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <td align="center">
                                <span class="delete-button btn btn-outline-danger"
                                    style="opacity:0.5;" data-type="youtube"
                                    data-id="<?php echo $youtube_channel->id; ?>"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    <?php
                    }
                    foreach ($tiktoks as $tiktok) {
                    ?>
                        <tr>
                            <td class="title"> <img style="width:35px;margin:0px 5px;"
                                    src="<?= BulkAssets . $tiktok->profile_pic; ?>"
                                    class="rounded" alt="profile_pic">
                                <b><?php echo $tiktok->username; ?></b>
                            </td>
                            <td>
                                <?php $clean = explode(',', $tiktok->channel_slots); ?>
                                <select id="tiktok-time-slots<?= $tiktok->id; ?>"
                                    multiple data-placeholder="Select Hours to post..."
                                    data-tiktok-id="<?= $tiktok->id; ?>"
                                    class="chosen-select chosen-tiktok-time-slots form-control">
                                    <?php for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) { ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </td>
                            <td align="center">
                                <span class="delete-button btn btn-outline-danger"
                                    style="opacity:0.5;" data-type="tiktok"
                                    data-id="<?php echo $tiktok->id; ?>"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
} ?>

<!-- popup modal to show facebook pages -->
<div class="modal fade bd-example-modal-lg" id="channels_settings" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Channels Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <!-- <div class="col-md-12  px-3" > Connection Settings </div> -->
                    <div class="col-md-12  p-3">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <?php
                                if (empty($user->facebook_id && $user->facebook_name)) {
                                ?>
                                    <img style="width:40px;height:40px;"
                                        src="<?php echo ASSETURL . 'images/Icons/facebook-circle.svg'; ?>"
                                        class="rounded" alt="profile_pic">
                                    <a href="<?php echo $connect_facebook; ?>"
                                        class="btn btn-info btn-sm authorize">Authorize Facebook</a>
                                <?php
                                } elseif (!empty($user->facebook_id && $user->facebook_name)) {
                                ?>
                                    <div class="overall">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-6">
                                                <div class="connected">
                                                    <img style="width:40px;height:40px;"
                                                        src="<?php echo ASSETURL . 'images/Icons/facebook-circle.svg'; ?>"
                                                        class="rounded" alt="profile_pic"><br>
                                                    <!-- <i style="font-size: 20px; color:#295396;" class="fa fa-check"></i>&nbsp; -->
                                                    <span
                                                        class="fw-bold h6"><?php echo $user->facebook_name; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-6 align-self-center">
                                                <small class="m-2"> Missing page ? Click <a
                                                        class="reconnect"
                                                        href="<?php echo $connect_facebook; ?>">
                                                        HERE </a> to add it. </small>
                                            </div>
                                        </div><!--row inside-->
                                        <div class="disconnect">
                                            <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                                                disconnect Facebook ? &nbsp;<button
                                                    class="btn btn-outline-danger btn-sm"
                                                    id="disconnect-facebook"><span
                                                        class="fa fa-unlink"></span> click here
                                                </button></h6>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <?php
                                if (empty($pinterest_boards)) {
                                ?>
                                    <img style="width:40px;height:40px;"
                                        src="<?php echo ASSETURL . 'images/Icons/pinterest-circle.svg'; ?>"
                                        class="rounded" alt="profile_pic">
                                    <!-- make the above anchor link into button -->
                                    <a href="<?php echo $pinterest_login_url ?>"
                                        class="btn btn-danger btn-sm authorize">Authorize
                                        Pinterest</a>
                                <?php
                                } elseif (!empty($pinterest_boards)) {
                                ?>
                                    <div class="overall">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-6">
                                                <div class="connected">
                                                    <img style="width:40px;height:40px;"
                                                        src="<?php echo ASSETURL . 'images/Icons/pinterest-circle.svg'; ?>"
                                                        class="rounded" alt="profile_pic"><br>
                                                    <!-- <i class="fa fa-check" style="font-size: 20px; color:#e71b22;"></i>&nbsp; -->
                                                    <span
                                                        class="fw-bold h6"><?php echo $pinterest_account[0]->username; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-6 align-self-center">
                                                <small class="m-2"> Missing Boards ? Click <a
                                                        class="reconnect"
                                                        href="<?php echo $pinterest_login_url ?>">
                                                        HERE </a> to add it. </small>
                                            </div>
                                        </div><!--row inside-->
                                        <div class="disconnect">
                                            <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                                                disconnect Pinterest ? &nbsp;<button
                                                    class="btn btn-outline-danger btn-sm"
                                                    id="disconnect-pinterest"><span
                                                        class="fa fa-unlink"></span> click here
                                                </button></h6>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <?php
                                if (empty($ig_accounts)) {
                                ?>
                                    <img style="width:30px;height:30px; margin-left: 5px;"
                                        src="<?php echo ASSETURL . 'images/Icons/instagram-circle.svg'; ?>"
                                        class="rounded" alt="profile_pic">
                                    <a style="margin-left: 5px;"
                                        href="<?php echo $instagram_login_url ?>"
                                        class="btn btn-info btn-sm authorize">Authorize
                                        Instagram</a>
                                <?php
                                } elseif (!empty($ig_accounts)) {
                                ?>
                                    <div class="overall">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-6">
                                                <div class="connected">
                                                    <img style="width:30px;height:30px;"
                                                        src="<?php echo ASSETURL . 'images/Icons/instagram-circle.svg'; ?>"
                                                        class="rounded" alt="profile_pic"><br>
                                                    <span
                                                        class="fw-bold h6"><?php echo $ig_accounts[0]->instagram_username; ?></span>
                                                    <!-- &nbsp;<i class="fa fa-check my-1" style="font-size:20px; color:#fe7203;"></i> -->
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-6 align-self-center">
                                                <small class="m-2"> Missing account ? Click <a
                                                        class="reconnect"
                                                        href="<?php echo $instagram_login_url ?>">
                                                        HERE </a> to add.</small>
                                            </div>
                                        </div><!--row inside-->
                                        <div class="disconnect">
                                            <h6 class="text-muted text-center m-r-20 mt-2"> Want to
                                                disconnect Instagram ? &nbsp;<button
                                                    class="btn btn-outline-danger btn-sm"
                                                    id="disconnect-instagram"><span
                                                        class="fa fa-unlink"></span> click here
                                                </button></h6>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (count($user_pages) > 0 || count($pinterest_boards) > 0 || count($ig_accounts) > 0 || count($fb_groups) > 0 || count($youtube_channels)) {
                ?>
                    <hr>
                    <div class="row <?= REVIEW_REQUEST; ?>">
                        <div class="col-md-12">
                            <div class="col-5 d-inline m-3 pt-3">
                                <label class="mt-4"> <b> Select timeslot for all channels
                                    </b></label>
                            </div>
                            <div class="col-7 float-right  m-3 mr-2">
                                <select id="all_channels_timeslots" multiple
                                    data-placeholder="Select Hours to post..."
                                    class="chosen-select chosen-all_channels_timeslots form-control">
                                    <?php
                                    for ($i = 0; $i < 24; $i++) {
                                        if (in_array($i, $clean)) {
                                    ?>
                                            <option selected="selected" value="<?= $i; ?>">
                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row <?= REVIEW_REQUEST; ?>">
                        <div class="col-md-12">
                            <!-- table to show userpages with additional column to save the timeslots -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-md-4">Channels Names</th>
                                        <th class="col-md-8">Posting Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($user_pages as $page_item) {
                                    ?>
                                        <tr>
                                            <td class="title"> <img style="width:40px;height:40px;"
                                                    src="<?php echo ASSETURL . 'images/Icons/facebook-circle.svg'; ?>"
                                                    class="rounded" alt="profile_pic">
                                                <b><?php echo $page_item->page_name ?></b>
                                            </td>
                                            <td>
                                                <?php
                                                $clean = explode(',', $page_item->channel_slots); ?>

                                                <select id="fbpages_timeslots<?= $page_item->id; ?>"
                                                    multiple data-placeholder="Select Hours to post..."
                                                    data-pageid="<?= $page_item->id; ?>"
                                                    class="chosen-select chosen-fbpages_timeslots form-control">
                                                    <?php
                                                    for ($i = 0; $i < 24; $i++) {
                                                        if (in_array($i, $clean)) {
                                                    ?>
                                                            <option selected="selected" value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php }
                                    foreach ($pinterest_boards as $board_item) {
                                    ?>
                                        <tr>
                                            <td class="title"> <img style="width:40px;height:40px;"
                                                    src="<?php echo ASSETURL . 'images/Icons/pinterest-circle.svg'; ?>"
                                                    class="rounded" alt="profile_pic">
                                                <b><?php echo $board_item->name; ?></b>
                                            </td>
                                            <td>
                                                <?php $clean = explode(',', $board_item->channel_slots); ?>
                                                <select id="boards_timeslots<?= $board_item->id; ?>"
                                                    multiple data-placeholder="Select Hours to post..."
                                                    data-boardid="<?= $board_item->id; ?>"
                                                    class="chosen-select chosen-boards_timeslots form-control">
                                                    <?php for ($i = 0; $i < 24; $i++) {
                                                        if (in_array($i, $clean)) { ?>
                                                            <option selected="selected" value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php }
                                    foreach ($ig_accounts as $ig_item) {
                                    ?>
                                        <tr>
                                            <td class="title"> <img
                                                    style="width:30px;height:30px;margin:0px 5px;"
                                                    src="<?php echo ASSETURL . 'images/Icons/instagram-circle.svg'; ?>"
                                                    class="rounded" alt="profile_pic">
                                                <b><?php echo $ig_item->instagram_username; ?></b>
                                            </td>
                                            <td>
                                                <?php $clean = explode(',', $ig_item->channel_slots); ?>
                                                <select id="ig_timeslots<?= $ig_item->id; ?>" multiple
                                                    data-placeholder="Select Hours to post..."
                                                    data-igid="<?= $ig_item->id; ?>"
                                                    class="chosen-select chosen-ig_timeslots form-control">
                                                    <?php for ($i = 0; $i < 24; $i++) {
                                                        if (in_array($i, $clean)) { ?>
                                                            <option selected="selected" value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    foreach ($fb_groups as $fb_group) {
                                    ?>
                                        <tr>
                                            <td class="title"> <img
                                                    style="width:30px;height:30px;margin:0px 5px;"
                                                    src="<?php echo ASSETURL . 'images/fb_group_logo.png'; ?>"
                                                    class="rounded" alt="profile_pic">
                                                <b><?php echo $fb_group->name; ?></b>
                                            </td>
                                            <td>
                                                <?php $clean = explode(',', $fb_group->channel_slots); ?>
                                                <select id="fbgroup_timeslots<?= $fb_group->id; ?>"
                                                    multiple data-placeholder="Select Hours to post..."
                                                    data-fbgroupid="<?= $fb_group->id; ?>"
                                                    class="chosen-select chosen-fbgroup_timeslots form-control">
                                                    <?php for ($i = 0; $i < 24; $i++) {
                                                        if (in_array($i, $clean)) { ?>
                                                            <option selected="selected" value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    foreach ($youtube_channels as $youtube_channel) {
                                    ?>
                                        <tr>
                                            <td class="title"> <img style="width:35px;margin:0px 5px;"
                                                    src="<?php echo ASSETURL . 'images/Icons/youtube-circle.svg'; ?>"
                                                    class="rounded" alt="profile_pic">
                                                <b><?php echo $youtube_channel->channel_title; ?></b>
                                            </td>
                                            <td>
                                                <?php $clean = explode(',', $youtube_channel->channel_slots); ?>
                                                <select
                                                    id="yt_channel_slots<?= $youtube_channel->id; ?>"
                                                    multiple data-placeholder="Select Hours to post..."
                                                    data-ytchannelid="<?= $youtube_channel->id; ?>"
                                                    class="chosen-select chosen-yt_channel_slots form-control">
                                                    <?php for ($i = 0; $i < 24; $i++) {
                                                        if (in_array($i, $clean)) { ?>
                                                            <option selected="selected" value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                            <td align="center">
                                                <span class="delete-button btn btn-outline-danger"
                                                    style="opacity:0.5;" data-type="youtube"
                                                    data-id="<?php echo $youtube_channel->id; ?>"><i
                                                        class="fa fa-trash"></i></span>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    foreach ($tiktoks as $tiktok) {
                                    ?>
                                        <tr>
                                            <td class="title"> <img style="width:35px;margin:0px 5px;"
                                                    src="<?= BulkAssets . $tiktok->profile_pic; ?>"
                                                    class="rounded" alt="profile_pic">
                                                <b><?php echo $tiktok->username; ?></b>
                                            </td>
                                            <td>
                                                <?php $clean = explode(',', $tiktok->channel_slots); ?>
                                                <select id="tiktok-time-slots<?= $tiktok->id; ?>"
                                                    multiple data-placeholder="Select Hours to post..."
                                                    data-tiktok-id="<?= $tiktok->id; ?>"
                                                    class="chosen-select chosen-tiktok-time-slots form-control">
                                                    <?php for ($i = 0; $i < 24; $i++) {
                                                        if (in_array($i, $clean)) { ?>
                                                            <option selected="selected" value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </td>
                                            <td align="center">
                                                <span class="delete-button btn btn-outline-danger"
                                                    style="opacity:0.5;" data-type="tiktok"
                                                    data-id="<?php echo $tiktok->id; ?>"><i
                                                        class="fa fa-trash"></i></span>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>