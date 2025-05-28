<!-- Large modal -->
<button type="button" class="border-0" data-toggle="modal" data-target=".pin_boards_modal">
    <span>
        <i class="fa-brands fa-pinterest text-danger" style="font-size: 2rem; cursor: pointer;"></i>
    </span>
</button>

<div class="modal fade pin_boards_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pinterest Boards</h5>
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
                            <th>Name</th>
                            <th>ID</th>
                            <th>Privacy</th>
                            <th>Date Added</th>
                            <th width="60px;">Time Slots</th>
                            <th>Rss Link</th>
                            <th>Rss Status</th>
                            <th>Status</th>
                            <th>Channel Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $pinBoards = $this->pinterest_count;
                            $pinUser = $this->pinterestUser[0];
                            ?>
                            <?php
                            foreach ($pinBoards as $key => $pin) {
                                ?>
                                <tr>
                                    <td align="center">
                                        <?php
                                        echo $key + 1;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <a href="<?php echo "https://www.pinterest.com/".$pinUser->username.'/'.str_replace(' ', '-', $pin->name) ?>" target="_blank"><?php echo $pin->name; ?></a>
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo $pin->board_id;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $privacy_class = $pin->privacy == "PUBLIC" ? "icon eye" : "icon lock";
                                        $privacy_title = $pin->privacy == "PUBLIC" ? "Public" : "Private";
                                        ?>

                                        <span><i class="<?php echo $privacy_class; ?>"
                                                title="<?php echo $privacy_title; ?>"></i></span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo date("Y-m-d", strtotime($pin->created_at));
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $time_slots = json_decode($pin->time_slots_rss);
                                        $response = '';
                                        foreach ($time_slots as $key => $slot) {
                                            $time = $slot % 12 ? $slot % 12 : 12;
                                            $zone = $slot >= 12 ? "pm" : "am";
                                            $response .= "<span class='badge badge-success mx-1'>" . $time . $zone . "</span>";
                                        }
                                        echo $response;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $proper_url = htmlspecialchars_decode(trim($pin->rss_link, '[]'));
                                        $proper_url = str_replace('\/', '/', $proper_url);
                                        echo $proper_url;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $rss_status = $pin->rss_active ? "badge-success" : "badge-danger";
                                        $rss_text = $pin->rss_active ? "Active" : "Inactive";
                                        ?>
                                        <span class="badge <?php echo $rss_status; ?>"><?php echo $rss_text; ?></span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $status = $pin->active_deactive_status ? "badge-success" : "badge-danger";
                                        $text = $pin->active_deactive_status ? "Active" : "Inactive";
                                        ?>
                                        <span class="badge <?php echo $status; ?>"><?php echo $text; ?></span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $channel_status = $pin->channel_active ? "badge-success" : "badge-danger";
                                        $channel_text = $pin->channel_active ? "Active" : "Inactive";
                                        ?>
                                        <span
                                            class="badge <?php echo $channel_status; ?>"><?php echo $channel_text; ?></span>
                                    </td>
                                    <td align="center">
                                        <a href="<?php echo "https://www.pinterest.com/".$pinUser->username.'/'.str_replace(' ', '-', $pin->name) ?>" target="_blank">
                                            <span>
                                                <i class="fa fa-eye text-primary"></i>
                                            </span>
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