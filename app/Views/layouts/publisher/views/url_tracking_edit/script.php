<script>
    $(document).ready(function() {
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
        // add custom parameter
        $('.add_custom_param').on('click', function() {
            var custom_content = $('.custom_content');
            var custom_parameter = $('.custom_parameter').find('.form-group');
            custom_parameter.clone().appendTo(custom_content);
        });
        $(document).on('click', '.remove_custom', function() {
            $(this).closest('.form-group').remove();
        });
    });
</script>