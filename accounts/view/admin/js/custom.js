$(document).ready(function () {
    // display thumbnail image
    $('#thumbnail').change(function () {
        if (this.files.length > 0) {
            var reader = new FileReader();
            reader.onload = function (event) {
                $('#thumbnail_preview').removeClass('absolute');
                $('#thumbnail_preview').attr('src', event.target.result);
            };
            if (this.files.length > 0) {
                reader.readAsDataURL(this.files[0]);
            }
        }
        else {
            $('#thumbnail_preview').addClass('absolute');
            $('#thumbnail_preview').attr('src', '');
        }
    });
});