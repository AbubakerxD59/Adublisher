<!-- Large modal -->
<button type="button" class="border-0" data-toggle="modal" data-target=".yt_channels_modal">
    <span>
        <i class="fa-brands fa-youtube text-danger" style="font-size: 2rem; cursor: pointer;"></i>
    </span>
    <!-- <img style="width:32px;height:32px;" src="<?php echo SITEURL . "assets/general/images/youtube_logo.png"; ?>" class="rounded" alt="profile_pic"> -->
</button>

<div class="modal fade yt_channels_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">YouTube Channels</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="text-center p-2">
                        <span>
                            <b>Username: </b><?php echo $this->data->username; ?>
                        </span>
                        <span>
                            <b>Email: </b><?php echo $this->data->email; ?>
                        </span>
                    </div>
                    <table class="table table-responsive table-stripped table-bordered">
                        <thead>
                            <th>Sr#</th>
                            <th>Title</th>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Date Added</th>
                            <th>Country</th>
                            <th>Autoposting</th>
                            <th>Status</th>
                            <th>Channel Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $ytChannels = $this->youtube_count;
                            ?>
                            <?php
                            foreach ($ytChannels as $key => $yt) {
                                ?>
                                <tr>
                                    <td align="center">
                                        <?php
                                        echo $key + 1;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <a href="<?php echo "https://www.youtube.com/channel/".$yt->channel_id ?>" target="_blank">
                                            <?php echo $yt->channel_title; ?>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo $yt->channel_id;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <img style="width:100px;" src="<?php echo $yt->channel_thumbnail ?>" alt="">
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo date("Y-m-d", strtotime($yt->created_at));
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo $yt->country;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $auto_class = $yt->auto_post ? "fa fa-check text-success" : "fa fa-times text-danger";
                                        ?>
                                        <span>
                                            <i class="<?php echo $auto_class; ?>"></i>
                                        </span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $status = $yt->active ? "badge-success" : "badge-danger";
                                        $text = $yt->active ? "Active" : "Inactive";
                                        ?>
                                        <span class="badge <?php echo $status; ?>"><?php echo $text; ?></span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $channel_status = $yt->channel_active ? "badge-success" : "badge-danger";
                                        $channel_text = $yt->channel_active ? "Active" : "Inactive";
                                        ?>
                                        <span
                                            class="badge <?php echo $channel_status; ?>"><?php echo $channel_text; ?></span>
                                    </td>
                                    <td align="center">
                                    <a href="<?php echo "https://www.youtube.com/channel/".$yt->channel_id ?>" target="_blank">
                                        <span><i class="fa fa-eye text-primary"></i></span>
                                    </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>