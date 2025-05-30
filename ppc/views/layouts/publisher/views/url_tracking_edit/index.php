<div class="col-lg-12">
    <div class="newsletter-form mt-3">
        <div class="row">
            <div class="col-lg-11">
                <form action="<?php echo SITEURL . 'update_url/' . $utms[0]['id']; ?>" method="POST">
                    <div class="newsletter-form">
                        <div class="form-group">
                            <input type="url" id="url"
                                class="form-control form-control-input border" name="url"
                                placeholder="Please enter your domain here!"
                                value="<?php echo $utms[0]['scheme'] . '://' . $utms[0]['url'] ?>" required>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-2 mx-1">
                                <input type="text" value="utm_campaign"
                                    class="form-control border" readonly>
                            </div>
                            <div class="col-2 mx-1">
                                <select name="utm_campaign_value" id="utm_campaign_value"
                                    class="form-control">
                                    <option value="social_network"
                                        <?php echo $utms[0]['value'] == 'social_network' ? 'selected' : ''; ?>>Social Network</option>
                                    <option value="social_profile"
                                        <?php echo $utms[0]['value'] == 'social_profile' ? 'selected' : ''; ?>>Social Profile</option>
                                    <option value="custom" <?php echo $utms[0]['value'] != 'social_network' && $utms[0]['value'] != 'social_profile' ? 'selected' : ''; ?>>Custom Value</option>
                                </select>
                            </div>
                            <?php
                            $campaing_custom = $utms[0]['value'] != 'social_network' && $utms[0]['value'] != 'social_profile' ? true : false;
                            ?>
                            <div class="col-2 campaign_custom_value" style="<?php echo $utms[0]['value'] != 'social_network' && $utms[0]['value'] != 'social_profile' ? '' : 'display:none'; ?>">
                                <input type="text" name="campaign_custom_value"
                                    id="campaign_custom_value" placeholder="Custom Value"
                                    class="form-control border" value="<?php echo $campaing_custom ? $utms[0]['value'] : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-2 mx-1">
                                <input type="text" value="utm_medium"
                                    class="form-control border" readonly>
                            </div>
                            <div class="col-2 mx-1">
                                <select name="utm_medium_value" id="utm_medium_value"
                                    class="form-control">
                                    <option value="social_network"
                                        <?php echo $utms[1]['value'] == 'social_network' ? 'selected' : ''; ?>>Social Network</option>
                                    <option value="social_profile"
                                        <?php echo $utms[1]['value'] == 'social_profile' ? 'selected' : ''; ?>>Social Profile</option>
                                    <option value="custom" <?php echo $utms[1]['value'] != 'social_network' && $utms[1]['value'] != 'social_profile' ? 'selected' : ''; ?>>Custom Value</option>
                                </select>
                            </div>
                            <?php
                            $medium_custom = $utms[1]['value'] != 'social_network' && $utms[1]['value'] != 'social_profile' ? true : false;
                            ?>
                            <div class="col-2 medium_custom_value" style="<?php echo $utms[1]['value'] != 'social_network' && $utms[1]['value'] != 'social_profile' ? '' : 'display:none'; ?>;">
                                <input type="text" name="medium_custom_value"
                                    id="medium_custom_value" placeholder="Custom Value"
                                    class="form-control border" value="<?php echo $medium_custom ? $utms[1]['value'] : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-2 mx-1">
                                <input type="text" value="utm_source"
                                    class="form-control border" readonly>
                            </div>
                            <div class="col-2 mx-1">
                                <input type="text" name="utm_source_value" id="utm_source_value"
                                    placeholder="Custom Value" class="form-control border"
                                    value="<?php echo $utms[2]['value']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group custom_content">
                            <?php
                            for ($i = 3; $i < count($utms); $i++) {
                            ?>
                                <div class="form-group d-flex">
                                    <div class="col-2 mx-1">
                                        <input type="text" name="tracking_tag[]" value="<?php echo $utms[$i]['type']; ?>" class="form-control border tracking_tag">
                                    </div>
                                    <div class="col-2 mx-1">
                                        <select name="tracking_tag_value[]" class="form-control tracking_tag_value">
                                            <option value="social_network"
                                                <?php echo $utms[$i]['value'] == 'social_network' ? 'selected' : ''; ?>>Social Network</option>
                                            <option value="social_profile"
                                                <?php echo $utms[$i]['value'] == 'social_profile' ? 'selected' : ''; ?>>Social Profile</option>
                                            <option value="custom"
                                                <?php echo $utms[$i]['value'] != 'social_network' && $utms[$i]['value'] != 'social_profile' ? 'selected' : ''; ?>>Custom Value</option>
                                        </select>
                                    </div>
                                    <div class="col-2 mx-1 tracking_tag_custom_value" style="<?php echo $utms[$i]['value'] != 'social_network' && $utms[$i]['value'] != 'social_profile' ? '' : 'display:none'; ?>;">
                                        <input type="text" name="tracking_tag_custom_value[]" placeholder="Custom Value"
                                            class="form-control border tracking_tag_custom_val" value="Adublisher">
                                    </div>
                                    <div class="col-2 mx-1" style="text-align:center; align-content:center;">
                                        <span class="remove_custom btn btn-outline-danger" style="cursor:pointer;">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <span class="text-primary add_custom_param"
                                style="cursor:pointer;">+ Add custom parameter</span>
                        </div>
                        <div class="form-group float-right my-3">
                            <button
                                class="btn btn-info btn-md border submit_url">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="custom_parameter" style="display:none;">
    <div class="form-group d-flex">
        <div class="col-2 mx-1">
            <input type="text" name="tracking_tag[]" value="Tracking tag" class="form-control border tracking_tag">
        </div>
        <div class="col-2 mx-1">
            <select name="tracking_tag_value[]" class="form-control tracking_tag_value">
                <option value="social_network">Social Network</option>
                <option value="social_profile">Social Profile</option>
                <option value="custom" selected>Custom Value</option>
            </select>
        </div>
        <div class="col-2 mx-1 tracking_tag_custom_value" style="display:block;">
            <input type="text" name="tracking_tag_custom_value[]" placeholder="Custom Value"
                class="form-control border tracking_tag_custom_val" value="Adublisher">
        </div>
        <div class="col-2 mx-1" style="text-align:center; align-content:center;">
            <span class="remove_custom btn btn-outline-danger" style="cursor:pointer;">
                <i class="fa fa-trash"></i>
            </span>
        </div>
    </div>
</div>