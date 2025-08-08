<script type="text/javascript">
    function disconnectSocialMedia(accountType, disconnectAction, customUrl) {
        swal({
            title: `Confirm Disconnect ${accountType} Account`,
            text: `You are about to Disconnect Your ${accountType} Account from Adublisher.com. Do you want to proceed?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, I am sure",
            closeOnConfirm: true
        }, function(isConfirmed) {
            if (isConfirmed) {
                if (disconnectAction) {
                    swal({
                        title: "Select Your Action",
                        text: `Disconnect ${accountType} Only |or| Also Delete Scheduled Posts?`,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        cancelButtonText: `Disconnect ${accountType} Only`,
                        confirmButtonText: `Disconnect ${accountType} and Delete Posts`,
                        closeOnConfirm: false
                    }, function(innerIsConfirmed) {
                        $("#loader").show();
                        $("#preloader_ajax").show();

                        var ajaxData = {
                            type: "POST",
                            url: customUrl // Use the custom URL for Facebook Groups
                        };

                        if (innerIsConfirmed) {
                            ajaxData.data = {
                                action: "disconnect_and_delete"
                            };
                        } else {
                            ajaxData.data = {
                                action: "disconnect_only"
                            };
                        }

                        $.ajax(ajaxData).done(function(response) {
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            if (response.status == 1) {
                                swal("Success", `${accountType} Account Disconnected Successfully`, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal("Error", `${accountType} Account Not Disconnected`, "error");
                            }
                        }).fail(function(response) {
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            swal("Error", `${accountType} Account Not Disconnected`, "error");
                        });
                    });
                } else {
                    $("#loader").show();
                    $("#preloader_ajax").show();
                    var ajaxData = {
                        type: "POST",
                        url: customUrl // Use the custom URL for Facebook Groups
                    };
                    ajaxData.data = {
                        action: "disconnect_and_delete"
                    };
                    $.ajax(ajaxData).done(function(response) {
                        $("#loader").hide();
                        $("#preloader_ajax").hide();
                        if (response.status == 1) {
                            swal("Success", `${accountType} Account Disconnected Successfully`, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Error", `${accountType} Account Not Disconnected`, "error");
                        }
                    }).fail(function(response) {
                        $("#loader").hide();
                        $("#preloader_ajax").hide();
                        swal("Error", `${accountType} Account Not Disconnected`, "error");
                    });
                }
            }
        });
    }

    $(document).on('click', '#disconnect-facebook', function() {
        disconnectSocialMedia("Facebook", false, "<?php echo SITEURL; ?>disconnectfacebook");
    });

    $(document).on('click', '#disconnect-youtube', function() {
        disconnectSocialMedia("YouTube", false, "<?php echo SITEURL; ?>disconnectyoutube");
    });

    $(document).on('click', '#disconnect-tiktok', function() {
        disconnectSocialMedia("TikTok", false, "<?php echo SITEURL; ?>disconnecttiktok");
    });

    $(document).on('click', '#disconnect-pinterest', function() {
        disconnectSocialMedia("Pinterest", false, "<?php echo SITEURL; ?>disconnectpinterest");
    });

    $(document).on('click', '#disconnect-instagram', function() {
        disconnectSocialMedia("Instagram", false, "<?php echo SITEURL; ?>disconnectinstagram");
    });

    $(document).on('click', '#disconnect-fbgroups', function() {
        disconnectSocialMedia("Facebook Groups", false, "<?php echo SITEURL; ?>disconnect_fb_groups");
    });
    // Get the current URL
    var currentUrl = window.location.href;
    // Check if either query parameter exists in the URL
    if (currentUrl.includes('?status=true#_=_') || currentUrl.includes('?status=false#_=_')) {
        // Remove the query parameter from the URL
        var updatedUrl = currentUrl.replace('?status=true#_=_', '').replace('?status=false#_=_', '');
        // Update the URL without the query parameter
        window.history.replaceState({}, '', updatedUrl);
    }
    $(document).ready(function() {
        $('.image-popup-fit-width').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            image: {
                verticalFit: false
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var limit_check = $('#limit_check').val();
        $('.close_alert').click(function() {
            var type = $(this).data('type');
            var id = $(this).data('id');
            var closeButton = $(this);
            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you have fixed the respective error?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Are you sure ?',
                cancelButtonText: 'Cancel',
            }, function(isConfirmed) {
                if (isConfirmed) {
                    $.ajax({
                        url: "<?php echo SITEURL; ?>" + 'cron_job_error',
                        method: 'POST',
                        data: {
                            id: id,
                            type: type
                        },
                        success: function(response) {
                            // On success, manually close the alert
                            closeButton.closest('.alert').alert('close');
                            swal("Cleared!", "The respective error is cleared Successfully", "success");
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            console.error(error);
                            swal("Cleared!", "Something went wrong please try again", "failed");
                        }
                    });
                }
            });
        });
        $(document).on('click', '.reconnect, .authorize', function(event) {
            if (limit_check == 0) {
                event.preventDefault();
                alertbox("Error!", "Your resource limit has been reached", "error");
            }
        });
    });
</script>