<script>
    $(document).ready(function() {
        $('#time').select2();
    });
    $('.edit_enable').on('click', function() {
        var form = $('#user_profile_form');
        var input = form.find('input');
        $.each(input, function() {
            $(this).attr('disabled', (i, v) => !v);
        });
    })
</script>