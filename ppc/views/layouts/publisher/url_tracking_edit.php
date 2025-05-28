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
        <?php
        $utm = $utms[0];
        ?>
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
                                            <form action="<?php echo SITEURL.'update_url/'.$utm['id']; ?>" method="POST">
                                                <div class="newsletter-form">
                                                    <div class="form-group">
                                                        <input type="url" id="url"
                                                            class="form-control form-control-input border" name="url"
                                                            placeholder="Please enter your domain here!"
                                                            value="<?php echo $utm['scheme'].'://'.$utm['url'] ?>" required>
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
                                                                <?php echo $utms[0]['value'] == 'social_network' ? 'selected' : ''; ?> >Social Network</option>
                                                                <option value="social_profile" 
                                                                <?php echo $utms[0]['value'] == 'social_profile' ? 'selected' : ''; ?> >Social Profile</option>
                                                                <option value="custom" <?php echo $utms[0]['value'] != 'social_network' && $utms[0]['value'] != 'social_profile' ? 'selected' : ''; ?> >Custom Value</option>
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
                                                                <?php echo $utms[1]['value'] == 'social_network' ? 'selected' : ''; ?> >Social Network</option>
                                                                <option value="social_profile" 
                                                                <?php echo $utms[1]['value'] == 'social_profile' ? 'selected' : ''; ?> >Social Profile</option>
                                                                <option value="custom" <?php echo $utms[1]['value'] != 'social_network' && $utms[1]['value'] != 'social_profile' ? 'selected' : ''; ?> >Custom Value</option>
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
                                                        for($i=3; $i<count($utms); $i++){
                                                        ?>
                                                            <div class="form-group d-flex">
                                                                <div class="col-2 mx-1">
                                                                    <input type="text" name="tracking_tag[]" value="<?php echo $utms[$i]['type']; ?>" class="form-control border tracking_tag">
                                                                </div>
                                                                <div class="col-2 mx-1">
                                                                    <select name="tracking_tag_value[]" class="form-control tracking_tag_value">
                                                                        <option value="social_network"
                                                                        <?php echo $utms[$i]['value'] == 'social_network' ? 'selected' : ''; ?> >Social Network</option>
                                                                        <option value="social_profile"
                                                                        <?php echo $utms[$i]['value'] == 'social_profile' ? 'selected' : ''; ?> >Social Profile</option>
                                                                        <option value="custom" 
                                                                        <?php echo $utms[$i]['value'] != 'social_network' && $utms[$i]['value'] != 'social_profile' ? 'selected' : ''; ?> >Custom Value</option>
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
        // add custom parameter
        $('.add_custom_param').on('click', function () {
            var custom_content = $('.custom_content');
            var custom_parameter = $('.custom_parameter').find('.form-group');
            custom_parameter.clone().appendTo(custom_content);
        });
        $(document).on('click', '.remove_custom', function () {
            $(this).closest('.form-group').remove();
        });
    });
</script>