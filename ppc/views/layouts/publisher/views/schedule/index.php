<!-- #channel_settings -->
<div class="row">
    <input type="hidden" id="action_name" value="" />
    <div class="col-md-12 m-b-10" id="channels"></div>
    <div class="col-md-12 scroll-bar">
    </div>
    <div class="col-12 social_content">
        <div class="col-md-12 m-t-10">
            <textarea style="display:none;" class="form-control"
                id="channel_title" name="channel_title" rows="2"
                placeholder="Paste your link here"></textarea>
            <textarea class="form-control" id="channel_title_visible"
                name="comment_title" rows="2"
                placeholder="Paste your link here"></textarea>
            <span id="charCount">0 / 100 characters</span>
            <input type="hidden" id="channel_comment" name="channel_comment">
            <div id="previewbox"></div>
        </div>
        <div class="col-md-12">
            <div class="content-wrap dropzonewidget">
                <div class="nest" id="DropZoneClose">
                    <div class="title-alt">
                    </div>
                    <div class="body-nest " id="DropZone">
                        <div id="myDropZone" style="border-radius: 10px;"
                            class="dropzone">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 my-3">
            <div class="facebook_comment_content" style="display:none;">
                <textarea class="form-control" id="post_comment"
                    name="post_comment" rows="2"
                    placeholder="Write your comment here!"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="float-right my-3">
                <button id="schedule"
                    class="btn btn-info btn-md border">Queue</button>
                <button id="publish"
                    class="btn btn-info  btn-md border">Publish</button>
            </div>
        </div>
    </div>
    <div class="row youtube_content col-md-12" style="display:none;">
        <div class="row col-12">
            <div class="col-md-6 p-4">
                <div class="content-wrap dropzonewidget">
                    <div class="nest" id="DropZoneClose">
                        <div class="title-alt">
                        </div>
                        <div class="body-nest " id="DropZone">
                            <div id="youtubeDropZone"
                                style="border-radius: 10px;" class="dropzone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="thumbnail">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail"
                            class="form-control" accept=".jpg,.jpeg,.png">
                    </div>
                    <div>
                        <span class="text-danger">For verified accounts only.
                            <a target="_blank" href="https://www.youtube.com/verify">
                                Check verification!
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <?php $youtube_settings = get_youtube_settings(); ?>
            <div class="col-md-6 p-3">
                <div class="form-group">
                    <input type="hidden" name="video_path" id="video_path">
                    <label for="video_title">Title <span
                            class="text-danger">*</span></label>
                    <input type="text" name="video_title" id="video_title"
                        class="form-control">
                    <span id="video_title_count">0 / 99 characters</span>
                </div>
                <div class="form-group">
                    <label for="video_description">Description</label>
                    <textarea name="video_description" id="video_description"
                        class="form-control"><?php echo !empty($youtube_settings) ? rtrim($youtube_settings->description) : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="selected_tags" id="selected_tags"
                        value="<?php echo !empty($youtube_settings) ? $youtube_settings->tags : ''; ?>">
                    <label for="tags">Tags</label>
                    <input id="tags" type="text" name="tags[]"
                        placeholder="Add tags" class="form-control"
                        data-role="tagsinput">
                </div>
                <div class="form-group">
                    <input type="hidden" name="selected_category"
                        id="selected_category"
                        value="<?php echo !empty($youtube_settings) ? $youtube_settings->category_id : ''; ?>">
                    <label for="video_category">Category <span
                            class="text-danger">*</span></label>
                    <select name="video_category" id="video_category"
                        class="form-control">
                        <option value="">Select Category</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="privacyStatus">Privacy</label>
                    <select name="privacyStatus" id="privacyStatus"
                        class="form-control">
                        <option value="">Select Privacy</option>
                        <option value="public" <?php echo !empty($youtube_settings) && $youtube_settings->privacy == "public" ? "selected" : ""; ?>>
                            Public</option>
                        <option value="private" <?php echo !empty($youtube_settings) && $youtube_settings->privacy == "private" ? "selected" : ""; ?>>
                            Private</option>
                        ?>
                    </select>
                </div>
                <div class="form-group d-flex align-items-baseline">
                    <label for="kids" class="col-2">For Kids</label>
                    <input type="checkbox" name="kids" id="kids" value="kids"
                        style="position: unset; opacity: 1;" <?php echo !empty($youtube_settings) && $youtube_settings->for_kids ? "checked" : ""; ?>>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="float-right my-3">
                <button id="video_schedule"
                    class="btn btn-info btn-md border">Queue</button>
                <button id="video_publish"
                    class="btn btn-info  btn-md borde">Publish</button>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <hr />
    </div>
    <div class="col-md-12 m-t-10 text-left">
        <b class="m-l-5">Filter </b> : <i class="mdi mdi-help-circle-outline"
            data-toggle="tooltip" data-placement="bottom" title=""
            data-original-title="Here you can manage the existing posts on channels. Select channel to load posts"></i>
        <span class="channelsdisplay">
            <select class="m-2 m-2 form-control w-25" id="channel_filter">
                <option value="all" selected>All</option>
                <?php
                if (isset($user_pages)) {
                    foreach ($user_pages as $fb_page) {
                ?>
                        <option value="<?= $fb_page->id; ?>" data-type="facebook">
                            <?= $fb_page->page_name . ' - Facebook'; ?>
                        </option>
                    <?php
                    }
                }
                if (isset($fb_groups)) {
                    foreach ($fb_groups as $fb_group) {
                    ?>
                        <option value="<?= $fb_group->id; ?>" data-type="fb_group">
                            <?= $fb_group->name ?>
                        </option>
                    <?php
                    }
                }
                if (isset($pinterest_boards)) {
                    foreach ($pinterest_boards as $board_item) {
                    ?>
                        <option value="<?= $board_item->id; ?>" data-type="pinterest">
                            <?= $board_item->name . ' - Pinterest'; ?>
                        </option>
                    <?php
                    }
                }
                if (isset($ig_accounts)) {
                    foreach ($ig_accounts as $ig_account) {
                    ?>
                        <option value="<?= $ig_account->id; ?>" data-type="instagram">
                            <?= $ig_account->instagram_username . ' - Instagram'; ?>
                        </option>
                    <?php
                    }
                }
                if (isset($tiktoks)) {
                    foreach ($tiktoks as $tiktok) {
                    ?>
                        <option value="<?php echo $tiktok->id; ?>" data-type="tiktok">
                            <?php echo $tiktok->username . ' - TikTok'; ?>
                        </option>
                <?php
                    }
                }
                ?>
            </select>
        </span>
    </div>
    <div class="col-md-12 d-flex justify-content-between">
        <div class="d-flex">
            <button class="btn btn-info bulk_upload_scheduled mx-1">Scheduled
                Posts</button>
            <button class="btn btn-secondary bulk_upload_published mx-1">Published
                Posts</button>
        </div>
        <div class="d-flex">
            <button class="btn btn-outline-info refresh m-l-5  pull-right mr-3"
                style="display: none;">
                <i class="fa fa-hourglass pointer"></i> Refresh
            </button>
            <button class="btn btn-outline-success shuffle m-l-5 pull-right mr-3"
                style="display: none;">
                <i class="fa fa-refresh pointer"></i> Shuffle
            </button>
            <button class="btn btn-outline-danger deleteall m-l-5  pull-right mr-3"
                style="display: none;">
                <i class="fa fa-trash pointer"></i> Delete All
            </button>
        </div>
    </div>
</div>
<div class="row mt-4  el-element-overlay popup-gallery" id="sceduled"></div>

<!-- youtube section -->
<div class="col-md-6 m-t-10"></div>