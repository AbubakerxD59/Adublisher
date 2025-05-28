<!-- Large modal -->
<button type="button" class="border-0" data-toggle="modal" data-target=".fb_pages_modal">
    <span>
        <i class="fa-brands fa-facebook text-primary" style="font-size: 2rem; cursor: pointer;"></i>
    </span>
</button>

<div class="modal fade fb_pages_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facebook Pages</h5>
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
                        <br>
                        <span>
                            <b>Facebook Name: </b><?php echo $this->data->facebook_name; ?>
                        </span>
                        <span>
                            <b>Facebook Email: </b><?php echo $this->data->facebook_email; ?>
                        </span>
                    </div>
                    <table class="table table-responsive table-stripped table-bordered">
                        <thead>
                            <th>Sr#</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Date Added</th>
                            <th>Auto Posting</th>
                            <th width="60px;">Time Slots</th>
                            <th width="60px;">Rss Link</th>
                            <th>Rss Status</th>
                            <th>Channel Status</th>
                            <th>Page Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $fbpages = $this->facebook_count;
                            ?>
                            <?php
                            foreach ($fbpages as $key => $fb) {
                                ?>
                                <tr>
                                    <td align="center">
                                        <?php
                                        echo $key + 1;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <a href="<?php echo "https://www.facebook.com/profile.php?id=".$fb->page_id ?>" target="_blank"><?php echo $fb->page_name; ?></a>
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo $fb->page_id;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        echo date("Y-m-d", strtotime($fb->date_added));
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $auto_class = $fb->auto_posting ? "fa fa-check text-success" : "fa fa-times text-danger";
                                        ?>
                                        <span>
                                            <i class="<?php echo $auto_class; ?>"></i>
                                        </span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $time_slots = json_decode($fb->time_slots);
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
                                        $proper_url = htmlspecialchars_decode(trim($fb->rss_link, '[]'));
                                        $proper_url = str_replace('\/', '/', $proper_url);
                                        echo $proper_url;
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $rss_status = $fb->rss_active ? "badge-success" : "badge-danger";
                                        $rss_text = $fb->rss_active ? "Active" : "Inactive";
                                        ?>
                                        <span class="badge <?php echo $rss_status; ?>"><?php echo $rss_text; ?></span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $channel_status = $fb->channel_active ? "badge-success" : "badge-danger";
                                        $channel_text = $fb->channel_active ? "Active" : "Inactive";
                                        ?>
                                        <span
                                            class="badge <?php echo $channel_status; ?>"><?php echo $channel_text; ?></span>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $status = $fb->active_deactive_status ? "badge-success" : "badge-danger";
                                        $text = $fb->active_deactive_status ? "Active" : "Inactive";
                                        ?>
                                        <span class="badge <?php echo $status; ?>"><?php echo $text; ?></span>
                                    </td>
                                    <td align="center">
                                    <a href="<?php echo "https://www.facebook.com/profile.php?id=".$fb->page_id ?>" target="_blank">
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