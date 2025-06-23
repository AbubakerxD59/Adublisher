<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="channel_settings_modal_lg"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Channels Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <?php
                if (count($user_pages) > 0 || count($pinterest_boards) > 0 || count($ig_accounts) > 0 || count($fb_groups) > 0 || count($youtube_channels) || count($tiktoks)) {
                ?>
                    <div class="row <?= REVIEW_REQUEST; ?>">
                        <div class="col-md-12 d-flex my-3">
                            <div class="col-5">
                                <label>
                                    <b> Select timeslot for all channels</b>
                                </label>
                            </div>
                            <div class="col-7">
                                <select id="all_channels_timeslots" multiple
                                    data-placeholder="Select Hours to post..."
                                    class="chosen-select chosen_all_channels_timeslots form-control">
                                    <?php
                                    for ($i = 0; $i < 24; $i++) {
                                    ?>
                                        <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
                                            <?= $i >= 12 ? 'pm' : 'am' ?>
                                        </option>
                                    <?php
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
                                                    src="<?php echo BulkAssets . $page_item->profile_pic; ?>"
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
                                                <span class="delete-button-modal btn btn-outline-danger"
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
                                                <span class="delete-button-modal btn btn-outline-danger"
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
                                                <span class="delete-button-modal btn btn-outline-danger"
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
                                                <span class="delete-button-modal btn btn-outline-danger"
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
                                                <span class="delete-button-modal btn btn-outline-danger"
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
                                                <span class="delete-button-modal btn btn-outline-danger"
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
        </div>
    </div>
</div>