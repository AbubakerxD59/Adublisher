<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(function() {
        var NoPreviewIfFile = false;
        var firstPreview = true;
        var fetchedThumbnail;
        var fetchedUrl = "";
        $('#channel_title_visible').on('input', function() {
            var visible_input = $('#channel_title_visible').val();
            var old_input_now_hidden = $('#channel_title').val();

            if (visible_input === '') {
                $('#channel_title').val('');
                preview();
                return;
            }
            var final_input = visible_input;

            var urlRegex = /(https?:\/\/[^\s]+)/;
            var urlMatches = old_input_now_hidden.match(urlRegex);
            if (urlMatches) {
                for (var i = 0; i < urlMatches.length; i++) {
                    final_input = urlMatches[i] + " " + visible_input;
                }
            }
            $('#channel_title').val(final_input);

            if (NoPreviewIfFile) {
                return;
            }

            if (urlRegex.test(visible_input) && firstPreview) {
                preview();
                firstPreview = false;
            } else if (urlRegex.test(visible_input) && $("#previewbox").attr("hidden") !== undefined) {
                preview();
            }
        });

        function preview() {
            var text = $('#channel_title').val();
            var urlRegex = /(https?:\/\/[^\s]+)/g;
            var urls = text.match(urlRegex);
            if (urls) {
                setTimeout(function() {
                    var lastUrlIndex = urls.length - 1;
                    fetchedUrl = urls[lastUrlIndex];
                    fetchedThumbnail = '<webhighlights-link-preview url="' + urls[lastUrlIndex] + '"></webhighlights-link-preview>';
                    $("#previewbox").removeAttr("hidden");
                    $("#previewbox").html(fetchedThumbnail);
                }, 500);
            } else {
                // Hide the preview box if no URL is found
                $("#previewbox").attr("hidden", "hidden");
            }
        }

        $('.popup-gallery').magnificPopup({
            delegate: 'a.gallery',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return '<small>will be posted on </small> ' + item.el.attr('title');
                }
            }
        });

        var Current_File = 0;

        function processQueueWithDelay(filesCopy) {
            // console.log('Index',Current_File);
            // console.log('filescopy',filesCopy);
            if (Current_File < filesCopy.length) {
                var file = filesCopy[Current_File];
                // console.log('Current File', file);
                myDropzone.processFile(file);
            } else {
                // All files processed
                $("#channel_title").val('');
                Current_File = 0; // Reset for future uploads
            }
        }
    });

    $(document).ready(function() {
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });
    });

    $(".chosen-boards_timeslots").on('change', function() {
        var board_id = $(this).data('boardid')
        var time_slots = $(this).val();

        var dataOBJ = {
            'timeslots': time_slots,
            'board_id': board_id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>boards_channel_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", response.message, "success");
                } else {
                    alertbox("Error", response.message, "error");
                }
            },
            error: function() {
                alertbox("Error", "Something went wrong", "error");
            }
        });
    });

    $(".chosen-fbpages_timeslots").on('change', function() {
        var page_id = $(this).data('pageid')
        var time_slots = $(this).val();

        var dataOBJ = {
            'timeslots': time_slots,
            'page_id': page_id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>fbpages_channel_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", response.message, "success");
                } else {
                    alertbox("Error", response.message, "error");
                }
            },
            error: function() {
                alertbox("Error", "Something went wrong!", "error");
            }
        });
    });

    $(".chosen-ig_timeslots").on('change', function() {
        var ig_id = $(this).data('igid')
        var time_slots = $(this).val();

        var dataOBJ = {
            'timeslots': time_slots,
            'ig_id': ig_id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ig_channel_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", response.message, "success");
                } else {
                    alertbox("Error", response.message, "error");
                }
            },
            error: function() {
                alertbox("Error", "Something went wrong", "error");
            }
        });
    });

    $(".chosen-fbgroup_timeslots").on('change', function() {
        var fbgroup_id = $(this).data('fbgroupid')
        var time_slots = $(this).val();

        var dataOBJ = {
            'timeslots': time_slots,
            'fbgroup_id': fbgroup_id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>fbgroup_channel_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", response.message, "success");
                } else {
                    alertbox("Error", response.message, "error");
                }
            },
            error: function() {
                alertbox("Error", "Something went wrong", "error");
            }
        });
    });

    $(".chosen-yt_channel_slots").on('change', function() {
        var ytchannelid = $(this).data('ytchannelid')
        var time_slots = $(this).val();

        var dataOBJ = {
            'timeslots': time_slots,
            'yt_channel_id': ytchannelid,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>youtube_channel_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", response.message, "success");
                } else {
                    alertbox("Error", response.message, "error");
                }
            },
            error: function() {
                alertbox("Error", "Something went wrong", "error");
            }
        });
    });

    $(".chosen-tiktok-time-slots").on('change', function() {
        var tiktok_id = $(this).data('tiktok-id')
        var time_slots = $(this).val();

        var dataOBJ = {
            'timeslots': time_slots,
            'tiktok_id': tiktok_id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>tiktok_channel_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", response.message, "success");
                } else {
                    alertbox("Error", response.message, "error");
                }
            },
            error: function() {
                alertbox("Error", "Something went wrong", "error");
            }
        });
    });

    $(".chosen-all_channels_timeslots").on('change', function() {
        var time_slots = $(this).val();
        var dataOBJ = {
            'timeslots': time_slots,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>all_channels_slots",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                alertbox("Success", response.message, "success");
                $(".chosen-fbpages_timeslots").val(time_slots);
                $(".chosen-fbpages_timeslots").trigger("chosen:updated");
                $(".chosen-boards_timeslots").val(time_slots);
                $(".chosen-boards_timeslots").trigger("chosen:updated");
                $(".chosen-ig_timeslots").val(time_slots);
                $(".chosen-ig_timeslots").trigger("chosen:updated")
                $(".chosen-fbgroup_timeslots").val(time_slots);
                $(".chosen-fbgroup_timeslots").trigger("chosen:updated")
                $(".chosen-yt_channel_slots").val(time_slots);
                $(".chosen-yt_channel_slots").trigger("chosen:updated")
                $(".chosen-tiktok-time-slots").val(time_slots);
                $(".chosen-tiktok-time-slots").trigger("chosen:updated")
            },
            error: function() {
                alertbox("Error", response.message, "error");
            }
        });
    });

    $(document).on('change', '.fbpages_channel_active', function() {
        var id = $(this).data("id");
        var status_ = false;
        if (this.checked) {
            status_ = true;
        }
        var dataOBJ = {
            'id': id,
            'status': status_
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>fbpages_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", "Page Auto Posting Updated Successfully", "success");
                }
            },
            error: function() {
                alertbox("Error", "Nothing Has been changed, try again", "error");
            }
        });
    });

    $(document).on('change', '.boards_channel_active', function() {
        var id = $(this).data("id");
        var status_ = false;
        if (this.checked) {
            status_ = true;
        }
        var dataOBJ = {
            'id': id,
            'status': status_
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>boards_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", "Page Auto Posting Updated Successfully", "success");
                }
            },
            error: function() {
                alertbox("Error", "Nothing Has been changed, try again", "error");
            }
        });
    });


    $(document).on("click touchstart", ".fb_channel", function() {
        var id = $(this).data("id");
        var dataOBJ = {
            'channel_id': id
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>fb_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", "Channel Status Changed Successfully", "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed", "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed", "error");
            }
        });
    });

    $(document).on("click touchstart", ".board_channel", function() {
        var id = $(this).data("id");
        var dataOBJ = {
            'channel_id': id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>board_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", "Channel Status Changed Successfully", "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed", "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed", "error");
            }
        });
    });

    $(document).on("click touchstart", ".ig_channel", function() {
        var id = $(this).data("id");
        var dataOBJ = {
            'channel_id': id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ig_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success", "Channel Status Changed Successfully", "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed", "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed", "error");
            }
        });
    });

    $(document).on("click touchstart", ".fbgroup_channel", function() {
        var id = $(this).data("id");
        var dataOBJ = {
            'channel_id': id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>fbgroup_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("success", "Channel Status Changed Successfully", "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed", "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed", "error");
            }
        });
    });


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
    // Function to handle delete action
    function handleDelete(id, pageType, button, action) {
        var rss_feed_engine_url;

        if (pageType == 'facebook') {
            rss_feed_engine_url = 'deletefbpage';
        } else if (pageType == 'pinterest') {
            rss_feed_engine_url = 'deletepinterestboard';
        } else if (pageType == 'instagram') {
            rss_feed_engine_url = 'deleteinstaaccount';
        } else if (pageType == 'fbgroup') {
            rss_feed_engine_url = 'deletefbgroup';
        } else if (pageType == 'youtube') {
            rss_feed_engine_url = 'deleteyoutube';
        } else if (pageType == 'tiktok') {
            rss_feed_engine_url = 'deletetiktok';
        }

        // Send an AJAX request to delete the page
        $.ajax({
            url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
            method: 'POST',
            data: {
                id: id,
                action: action
            }, // Include the action in the request
            success: function(response) {
                // Handle the success response as needed
                // For example, remove the button on success
                if (response.status) {
                    $('.delete-button[data-id="' + id + '"]').closest('tr').remove();
                    $('#limit_check').val('1');
                    swal({
                        title: "Success",
                        text: response.message,
                        type: "success",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK!",
                        closeOnConfirm: true
                    });
                    // setTimeout(function () {
                    //     location.reload();
                    // }, 2000);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error(error);
            }
        });
    }

    // Event delegation to handle hover and delete
    var deleteButton = $('.delete-button'); // Find the delete button inside the channel-button
    // Mouse enter, show the delete button by setting opacity to 1
    deleteButton.on("mouseenter", function() {
        $(this).css('opacity', '1');
    });
    deleteButton.on("mouseleave", function() {
        $(this).css('opacity', '0.5');
    });

    deleteButton.on("click", function(e) {
        e.stopPropagation(); // Prevent the button click from triggering the button's click event
        var id = $(this).data("id");
        var pageType = $(this).data("type"); // Get the type of the clicked button
        // Defining text and button text variables depending on the channel 
        var confirmationText;
        var confirmationTextInside;
        var disconnectOnly;
        var disconnectDeleteScheduledPosts;
        if (pageType == 'facebook') {
            confirmationText = "Are you sure you want to delete this Facebook page?";
            confirmationTextInside = "Disconnect This Facebook Page Only |or| Also Delete It's Scheduled Posts?";
            disconnectOnly = "Disconnect Facebook Page Only";
            disconnectDeleteScheduledPosts = "Disconnect Facebook Page and Delete Scheduled Posts";
        } else if (pageType == 'pinterest') {
            confirmationText = "Are you sure you want to delete this Pinterest board?";
            confirmationTextInside = "Disconnect This Pinterest Board Only |or| Also Delete It's Scheduled Posts?";
            disconnectOnly = "Disconnect Pinterest Board Only";
            disconnectDeleteScheduledPosts = "Disconnect Pinterest Board and Delete Scheduled Posts";
        } else if (pageType == 'instagram') {
            confirmationText = "Are you sure you want to delete this Instagram account?";
            confirmationTextInside = "Disconnect Instagram Only |or| Also Delete It's Scheduled Posts?";
            disconnectOnly = "Disconnect Instagram Only";
            disconnectDeleteScheduledPosts = "Disconnect Instagram and Delete Scheduled Posts";
        } else if (pageType == 'fbgroup') {
            confirmationText = "Are you sure you want to delete this Facebook group?";
            confirmationTextInside = "Disconnect This Facebook Group Only |or| Also Delete It's Scheduled Posts?";
            disconnectOnly = "Disconnect Facebook Group Only";
            disconnectDeleteScheduledPosts = "Disconnect Facebook Group and Delete Scheduled Posts";
        } else if (pageType == 'youtube') {
            confirmationText = "Are you sure you want to delete this YouTube channel?";
            confirmationTextInside = "Disconnect This YouTube channel Only |or| Also Delete It's Scheduled Posts?";
            disconnectOnly = "Disconnect YouTube channel Only";
            disconnectDeleteScheduledPosts = "Disconnect YouTube channel and Delete Scheduled Posts";
        } else if (pageType == 'tiktok') {
            confirmationText = "Are you sure you want to delete this TikTok account?";
            confirmationTextInside = "Disconnect This Tiktok Account Only |or| Also Delete It's Scheduled Posts?";
            disconnectOnly = "Disconnect TikTok channel Only";
            disconnectDeleteScheduledPosts = "Disconnect TikTok account and Delete Scheduled Posts";
        }
        // Show a SweetAlert confirmation dialog with an additional option
        swal({
            title: "Are you sure?",
            text: confirmationText,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            closeOnConfirm: true
        }, function(isConfirmed) {
            var action = "disconnect_and_delete"
            handleDelete(id, pageType, deleteButton, action);
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