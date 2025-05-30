<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="newsletter-form mt-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newsletter-form">
                        <div class="form-group">
                            <input type="url" id="url"
                                class="form-control form-control-input border"
                                placeholder="Please enter your domain here!" required>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-2 mx-1">
                                <input type="text" name="utm_campaign" value="utm_campaign"
                                    class="form-control border" readonly>
                            </div>
                            <div class="col-2 mx-1">
                                <select name="utm_campaign_value" id="utm_campaign_value"
                                    class="form-control">
                                    <option value="social_network">Social Network</option>
                                    <option value="social_profile">Social Profile</option>
                                    <option value="custom">Custom Value</option>
                                </select>
                            </div>
                            <div class="col-2 campaign_custom_value" style="display:none;">
                                <input type="text" name="campaign_custom_value"
                                    id="campaign_custom_value" placeholder="Custom Value"
                                    class="form-control border">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-2 mx-1">
                                <input type="text" name="utm_medium" value="utm_medium"
                                    class="form-control border" readonly>
                            </div>
                            <div class="col-2 mx-1">
                                <select name="utm_medium_value" id="utm_medium_value"
                                    class="form-control">
                                    <option value="social_network">Social Network</option>
                                    <option value="social_profile" selected>Social Profile
                                    </option>
                                    <option value="custom">Custom Value</option>
                                </select>
                            </div>
                            <div class="col-2 medium_custom_value" style="display:none;">
                                <input type="text" name="medium_custom_value"
                                    id="medium_custom_value" placeholder="Custom Value"
                                    class="form-control border">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="col-2 mx-1">
                                <input type="text" name="utm_source" value="utm_source"
                                    class="form-control border" readonly>
                            </div>
                            <div class="col-2 mx-1">
                                <input type="text" name="utm_source_value" id="utm_source_value"
                                    placeholder="Custom Value" class="form-control border"
                                    value="Adublisher" readonly>
                            </div>
                        </div>
                        <div class="form-group custom_content"></div>
                        <div class="form-group">
                            <span class="text-primary add_custom_param"
                                style="cursor:pointer;">+ Add custom parameter</span>
                        </div>
                        <div class="form-group float-right my-3">
                            <button
                                class="btn btn-info btn-md border submit_url">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xlg-12">
        <div class="form-group">
            <table class="table table-bordered table-hover" id="url_tacking_table">
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Url</th>
                        <th>Campaign</th>
                        <th>Medium</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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