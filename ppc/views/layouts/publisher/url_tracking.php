<style>
    .dt-paging {
        display: none !important;
    }

    .newsletter-form {
        position: relative;
    }

    .form-control-input {
        height: 50px;
        border-radius: 30px;
        padding-left: 20px;
        border: 0;
        font-size: 14px;
        font-weight: 500;
    }

    @media screen and (prefers-reduced-motion: reduce) {
        .form-control-input {
            transition: none;
        }
    }

    .features-single {
        background-color: #fff;
        padding: 30px 20px 15px;
        -webkit-box-shadow: 0 0 30px rgba(0, 0, 0, 0.06);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border-radius: 4px;
        border-bottom: 2px solid #1d46f5;
        margin: 0 0 30px;
    }

    #home-area .content {
        /* padding: 0 10%; */
        margin: 0 0 40px;
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .features-single .content {
            width: 73%;
        }
    }

    .features-single .content {
        width: 75%;
        float: left;
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .features-single .icon {
            width: 27%;
        }
    }

    .features-single .icon {
        width: 20%;
        float: left;
        margin: 8px 0 0;
        text-align: center;
        padding-right: 15px;
    }

    .pointer {
        cursor: pointer;
    }

    .features-single i {
        color: #1d46f5;
        font-size: 30px;
        display: inline-block;
        width: 65px;
        height: 65px;
        background-color: #f5f5ff;
        border-radius: 50%;
        line-height: 60px;
        -webkit-box-shadow: 0 0 10px rgba(29, 70, 245, 0.8);
        box-shadow: 0 0 10px rgba(29, 70, 245, 0.8);
        border: 3px solid #fff;
    }
</style>
<!--icofont css-->
<link rel="stylesheet" type="text/css" href="<?= LANDINGASSETS ?>/css/icofont.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
<div class="page-wrapper">
    <div class="container-fluid">
        <div>
            <div>
                <div class="card simple-card">
                    <div class="card-body py-0">
                        <div class="row">
                            <?php echo loader(); ?>
                            <div class="col-lg-12 col-md-12">
                                <div class="newsletter-form mt-3">
                                    <div class="row">
                                        <div class="col-lg-11">
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
                    </div>
                </div>
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
<?php
$this->load->view('templates/publisher/footer');
?>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        // fetch recent post function
        var url_tacking_table = $('#url_tacking_table').DataTable({
            searching: false,
            ordering: false,
            serverSide: true,
            iDisplayLength: '25',
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>url_tracks',
                complete: function () {
                    $("#preloader_ajax").hide();
                }
            },
            columnDefs: [{ width: 300, targets: 1 }],
            columns: [
                { data: 'sr' },
                { data: 'url' },
                { data: 'campaign' },
                { data: 'medium' },
                { data: 'source' },
                { data: 'status' },
                { data: 'published' },
                { data: 'action' },
            ]
        });
        // custom value utms
        $('#utm_campaign_value').on('change', function () {
            var value = $(this).val();
            if (value == 'custom') {
                $('.campaign_custom_value').show();
            }
            else {
                $('.campaign_custom_value').hide();
            }
        });
        $('#utm_medium_value').on('change', function () {
            var value = $(this).val();
            if (value == 'custom') {
                $('.medium_custom_value').show();
            }
            else {
                $('.medium_custom_value').hide();
            }
        });
        $(document).on('change', '.tracking_tag_value', function () {
            var value = $(this).val();
            var div = $(this).closest('.form-group');
            if (value == 'custom') {
                div.find('.tracking_tag_custom_value').show();
            }
            else {
                div.find('.tracking_tag_custom_value').hide();
            }

        });
        // show preloader on paging
        $('.dt-length select').on('change', function () {
            $("#preloader_ajax").show();
        });
        // save url along with utm codes
        $('.submit_url').on('click', function () {
            var all_filled = true;
            var url = $('#url').val();
            var campaign = $('#utm_campaign_value').val();
            var medium = $('#utm_medium_value').val();
            var source = $('#utm_source_value').val();
            var tracking_tags = $('.custom_content').find('.tracking_tag');
            var custom_tags_name = [];
            var custom_tags_value = [];
            if (campaign == 'custom') {
                campaign = $('#campaign_custom_value').val();
            }
            if (medium == 'custom') {
                medium = $('#medium_custom_value').val();
            }
            // check if any is empty
            if (url == '' || url == null || url == undefined) {
                all_filled = false;
                alertbox('Error', 'Url field is required!', 'error');
                return;
            }
            if (campaign == '' || campaign == null || campaign == undefined) {
                all_filled = false;
                alertbox('Error', 'Campaign field is required!', 'error');
                return;
            }
            if (medium == '' || medium == null || medium == undefined) {
                all_filled = false;
                alertbox('Error', 'Medium field is required!', 'error');
                return;
            }
            if (source == '' || source == null || source == undefined) {
                all_filled = false;
                alertbox('Error', 'Source field is required!', 'error');
                return;
            }
            // custom tracking value
            $.each(tracking_tags, function (index) {
                name = $(this).val().trim();
                var tracking_tag_value = $(this).closest('.form-group').find('.tracking_tag_value').val();
                if (tracking_tag_value == 'custom') {
                    tracking_tag_value = $(this).closest('.form-group').find('.tracking_tag_custom_val').val();
                }
                if (tracking_tag_value == '' || tracking_tag_value == null || tracking_tag_value == undefined) {
                    all_filled = false;
                    alertbox('Error', $(this).val().charAt(0).toUpperCase() + ' field is required!', 'error');
                    return;
                }
                custom_tags_name.push(name);
                custom_tags_value.push(tracking_tag_value);
            });
            if (all_filled) {
                $("#preloader_ajax").show();
                save_url_utm(url, campaign, medium, source, custom_tags_name, custom_tags_value);
            }
        });
        // function for storing url with utm codes
        var save_url_utm = function (url, campaign, medium, source, custom_tags_name, custom_tags_value) {
            $.ajax({
                'url': '<?php echo SITEURL; ?>save_url_utm',
                'type': 'POST',
                data: {
                    'url': url,
                    'campaign': campaign,
                    'medium': medium,
                    'source': source,
                    'custom_tags_name': custom_tags_name,
                    'custom_tags_value': custom_tags_value
                },
                success: function (response) {
                    $("#preloader_ajax").hide();
                    if (response.status) {
                        $('#url').val('');
                        alertbox('Success', 'Domain with utm defaults has been saved successfully!', 'success');
                        url_tacking_table.ajax.reload();
                    }
                    else {
                        alertbox('Error', response.message, 'error');
                    }
                },
            });
        }
        // add custom parameter
        $('.add_custom_param').on('click', function () {
            var custom_content = $('.custom_content');
            var custom_parameter = $('.custom_parameter').find('.form-group');
            custom_parameter.clone().appendTo(custom_content);
        });
        $(document).on('click', '.remove_custom', function () {
            $(this).closest('.form-group').remove();
        });
        $(document).on('click', '.delete_url', function () {
            var id = $(this).data('id');
            if (confirm('Confirm to delete this URL!')) {
                $.ajax({
                    url: '<?php echo SITEURL . 'delete_url'; ?>',
                    type: 'GET',
                    data: {
                        'id': id
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.status) {
                            url_tacking_table.ajax.reload();
                            alertbox('Success', response.message, 'success');
                        }
                        else {
                            alertbox('Error', response.message, 'error');
                        }
                    }
                });
            }
            else {
                return false;
            }
        });
        $(document).on('change', '.track_status', function () {
            var id = $(this).data("id");
            var status = 'OFF';
            if (this.checked) {
                status = 'ON';
            }
            $.ajax({
                url: '<?php echo SITEURL . 'track_status'; ?>',
                type: 'POST',
                data: {
                    'id': id,
                    'status': status
                },
                success: function (response) {
                    if (response.status) {
                        url_tacking_table.ajax.reload();
                        alertbox('Success', response.message, 'success');
                    }
                    else {
                        alertbox('Error', response.message, 'error');
                    }
                }
            });
        });
    });
</script>