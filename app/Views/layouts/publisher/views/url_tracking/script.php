<script>
    $(document).ready(function() {
        // fetch recent post function
        var url_tacking_table = $('#url_tacking_table').DataTable({
            searching: false,
            ordering: false,
            serverSide: true,
            iDisplayLength: '25',
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>url_tracks',
                complete: function() {
                    $("#preloader_ajax").hide();
                }
            },
            columnDefs: [{
                width: 300,
                targets: 1
            }],
            columns: [{
                    data: 'sr'
                },
                {
                    data: 'url'
                },
                {
                    data: 'campaign'
                },
                {
                    data: 'medium'
                },
                {
                    data: 'source'
                },
                {
                    data: 'status'
                },
                {
                    data: 'published'
                },
                {
                    data: 'action'
                },
            ]
        });
        // custom value utms
        $('#utm_campaign_value').on('change', function() {
            var value = $(this).val();
            if (value == 'custom') {
                $('.campaign_custom_value').show();
            } else {
                $('.campaign_custom_value').hide();
            }
        });
        $('#utm_medium_value').on('change', function() {
            var value = $(this).val();
            if (value == 'custom') {
                $('.medium_custom_value').show();
            } else {
                $('.medium_custom_value').hide();
            }
        });
        $(document).on('change', '.tracking_tag_value', function() {
            var value = $(this).val();
            var div = $(this).closest('.form-group');
            if (value == 'custom') {
                div.find('.tracking_tag_custom_value').show();
            } else {
                div.find('.tracking_tag_custom_value').hide();
            }

        });
        // show preloader on paging
        $('.dt-length select').on('change', function() {
            $("#preloader_ajax").show();
        });
        // save url along with utm codes
        $('.submit_url').on('click', function() {
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
            $.each(tracking_tags, function(index) {
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
        var save_url_utm = function(url, campaign, medium, source, custom_tags_name, custom_tags_value) {
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
                success: function(response) {
                    $("#preloader_ajax").hide();
                    if (response.status) {
                        $('#url').val('');
                        alertbox('Success', 'Domain with utm defaults has been saved successfully!', 'success');
                        url_tacking_table.ajax.reload();
                    } else {
                        alertbox('Error', response.message, 'error');
                    }
                },
            });
        }
        // add custom parameter
        $('.add_custom_param').on('click', function() {
            var custom_content = $('.custom_content');
            var custom_parameter = $('.custom_parameter').find('.form-group');
            custom_parameter.clone().appendTo(custom_content);
        });
        $(document).on('click', '.remove_custom', function() {
            $(this).closest('.form-group').remove();
        });
        $(document).on('click', '.delete_url', function() {
            var id = $(this).data('id');
            if (confirm('Confirm to delete this URL!')) {
                $.ajax({
                    url: '<?php echo SITEURL . 'delete_url'; ?>',
                    type: 'GET',
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status) {
                            url_tacking_table.ajax.reload();
                            alertbox('Success', response.message, 'success');
                        } else {
                            alertbox('Error', response.message, 'error');
                        }
                    }
                });
            } else {
                return false;
            }
        });
        $(document).on('change', '.track_status', function() {
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
                success: function(response) {
                    if (response.status) {
                        url_tacking_table.ajax.reload();
                        alertbox('Success', response.message, 'success');
                    } else {
                        alertbox('Error', response.message, 'error');
                    }
                }
            });
        });
    });
</script>