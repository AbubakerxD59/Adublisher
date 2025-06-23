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