$(document).ready(function () {
    // AlertBox function
    function alertbox(heading, message, type) {
        if (type == 'success') {
            toastr.success(message);
        }
        if (type == 'error') {
            toastr.error(message);
        }
        if (type == 'warning') {
            toastr.warning(message);
        }
    }
    // Clipboard initialization
    var clipboard = new ClipboardJS('.click_to_copy');
    // Click to copy
    $(document).on('click', '.click_to_copy', function () {
        alertbox('Success', 'Email Copied!', 'success');
    });
});