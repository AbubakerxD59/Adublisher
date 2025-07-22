<script type="text/javascript">
    var facebook_page_icon = pinterest_board_icon = tiktok_account_icon = instagram_account_icon = youtube_icon = '';
    var facebook_logo = "<?= ASSETURL . 'images/Icons/facebook-circle.svg'; ?>";
    var pinterest_logo = "<?= ASSETURL . 'images/Icons/pinterest-circle.svg' ?>";
    var instagram_logo = "<?= ASSETURL . 'images/Icons/instagram-circle.svg' ?>";
    var tiktok_logo = "<?= ASSETURL . 'images/Icons/tiktok-circle.svg' ?>";
    var youtube_logo = "<?= ASSETURL . 'images/Icons/youtube-circle.svg' ?>";
    var currentActionButton = '';
    Dropzone.autoDiscover = false;
    $(function() {
        setTimeout(() => {
            get_channels_scheduled();
        }, 1000);
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
            } else if (urlRegex.test(visible_input) && $("#previewbox")
                .attr("hidden") !== undefined) {
                preview();
            }
        });

        function preview() {
            var text = $('#channel_title').val();
            var urlRegex = /(https?:\/\/[^\s]+)/g;
            var urls = text.match(urlRegex);
            if (urls) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo SITEURL; ?>active_channels",
                    success: function(response) {
                        if (response.status) {
                            setTimeout(function() {
                                var lastUrlIndex = urls.length - 1;
                                fetchedUrl = urls[lastUrlIndex];
                                fetchedThumbnail =
                                    '<webhighlights-link-preview url="' +
                                    urls[lastUrlIndex] +
                                    '"></webhighlights-link-preview>';
                                $("#previewbox").removeAttr(
                                    "hidden");
                                $("#previewbox").html(fetchedThumbnail);
                            }, 500);
                        } else {
                            $('#channel_title_visible').val('');
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            alertbox("Error", response.message, "error");
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                })
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
                    return '<small>will be posted on </small> ' + item
                        .el.attr('title');
                }
            }
        });
        var Current_File = 0;

        function processQueueWithDelay(filesCopy) {
            if (Current_File < filesCopy.length) {
                var file = filesCopy[Current_File];
                myDropzone.processFile(file);
            } else {
                // All files processed
                $("#channel_title").val('');
                Current_File = 0; // Reset for future uploads
            }
        }
        // Youtube DropZone
        var myDropzone = new Dropzone("div#myDropZone", {
            autoProcessQueue: false,
            url: "<?php echo SITEURL; ?>save_channels_bulkupload",
            maxFiles: 450,
            paramName: "file",
            maxFilesize: 100,
            acceptedFiles: 'image/*, video/*',
            parallelUploads: 1,
            addRemoveLinks: true,
            dictRemoveFile: "×",
            dictCancelUpload: "X",
            init: function() {
                this.on("addedfile", function(file) {
                    document.getElementById('previewbox').style.display = 'none';
                    NoPreviewIfFile = true;
                    var supportedFormats = ['image/jpeg', 'image/jpg', 'image/png', 'video/mp4', 'video/quicktime', 'video/mpg', 'video/webm', 'video/mov'];
                    var fileExtension = file.name.split('.').pop().toLowerCase();
                    if (supportedFormats.indexOf(file.type) === -1 ||
                        (fileExtension !== 'jpg' &&
                            fileExtension !== 'jpeg' &&
                            fileExtension !== 'png' &&
                            fileExtension !== 'bmp' &&
                            fileExtension !== 'gif' &&
                            fileExtension !== 'tiff' &&
                            fileExtension !== 'webp' &&
                            fileExtension !== 'mp4' &&
                            fileExtension !== 'mkv' &&
                            fileExtension !== 'mov' &&
                            fileExtension !== 'mpeg' &&
                            fileExtension !== 'webm'
                        )
                    ) {
                        alertbox("Failed", "This image format is not supported. Please upload image/s in these formats: JPG, JPEG and PNG", "error");
                        this.removeFile(file);
                    } else {
                        var channel_title = $("#channel_title").val();
                    }
                });
                this.on("removedfile", function(file) {
                    // Check if there are any files remaining after removal
                    NoPreviewIfFile = false;
                    var channelTitleValue = document.getElementById('channel_title').value;

                    if (this.files.length === 0 && channelTitleValue !== '') {
                        // If no files are left, display the preview box
                        document.getElementById('previewbox').style.display = 'block';
                    }
                });
                this.on("sending", function(file, xhr, data) {
                    data.append("totalfiles", this.getAcceptedFiles().length);
                    data.append("current_file", Current_File);
                    data.append("channel_title", $("#channel_title_visible").val());
                    data.append("channel_comment", $("#post_comment").val());
                    data.append("action", $("#action_name").val());
                });
                this.on("success", function(file, response) {
                    enableButton(currentActionButton);
                    firstPreview = true;
                    NoPreviewIfFile = false;
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            response = {};
                        }
                    }
                    if (typeof response === 'object' && 'message' in response) {
                        if (response.status) {
                            $("#left").text(parseInt($("#left").text()) - 1);
                            enableButton(currentActionButton);
                            alertbox("Success", response.message, "success");
                        } else {
                            enableButton(currentActionButton);
                            alertbox("Error", response.message, "error");
                        }
                    } else {
                        // Handle the case where response is not in the expected format.
                        enableButton(currentActionButton);
                        console.error('Invalid response:', response);
                    }
                    // console.log(Current_File + 1, myDropzone.files);
                    this.removeFile(file);
                    if (myDropzone.files.length < 1) {
                        $("#preloader_ajax").hide();
                    }
                    processQueueWithDelay(myDropzone.files);
                });
                this.on("error", function(file, response) {
                    enableButton(currentActionButton);
                    $("#preloader_ajax").hide();
                    this.removeFile(file);
                    processQueueWithDelay(myDropzone.files);
                    alertbox("Error", response, "error");
                });
                this.on("complete", function(file) {
                    enableButton(currentActionButton);
                    document.getElementById('previewbox').style.display = 'block';
                    document.getElementById('previewbox').innerHTML = '';
                    if ($("#action_name").val() != "publish") {
                        get_channels_scheduled();
                    }
                    this.removeFile(file);
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        $("#channel_title").val('');
                        $("#channel_title_visible").val('');
                        $("#post_comment").val('');
                    }
                });
            },
            accept: function(file, done) {
                done();
            }
        });

        // Youtube DropZone
        var youtubeDropZone = new Dropzone("div#youtubeDropZone", {
            autoProcessQueue: true,
            url: "<?php echo SITEURL; ?>move_video_to_server",
            maxFiles: 450,
            paramName: "file",
            maxFilesize: 256000,
            timeout: 300000,
            acceptedFiles: 'video/*',
            parallelUploads: 1,
            addRemoveLinks: true,
            dictRemoveFile: "×",
            dictCancelUpload: "X",
            init: function() {
                this.on("addedfile", function(file) {
                    var supportedFormats = [
                        'video/mp4, video/mkv, video/mpg, video/webm, video/mov'
                    ];
                    var fileExtension = file.name.split('.').pop().toLowerCase();
                    if (
                        fileExtension !== 'mp4' &&
                        fileExtension !== 'mkv' &&
                        fileExtension !== 'mpg' &&
                        fileExtension !== 'bmp' &&
                        fileExtension !== 'webm' &&
                        fileExtension !== 'mov'
                    ) {
                        $('#preloader_ajax').hide();
                        alertbox("Failed",
                            "This video format is not supported. Please upload video/s in these formats: MP4, MKV, MPG, WEBM, MOB",
                            "error");
                        this.removeFile(file);
                    }
                    $('#video_publish').attr('disabled', true);
                    $('#video_schedule').attr('disabled', true);
                });
                this.on("removedfile", function(file) {
                    // Check if there are any files remaining after removal
                });
                this.on("success", function(file, response) {
                    if (response.status) {
                        $('#video_publish').attr('disabled',
                            false);
                        $('#video_schedule').attr('disabled',
                            false);
                        $('#video_path').val(response.message);
                        alertbox("Success",
                            "Video uploaded successfully!",
                            "success");
                    } else {
                        var error = response.message;
                        alertbox("Error", error, "error");
                    }
                });
                this.on("error", function(file, response) {
                    $("#preloader_ajax").hide();
                    // alertbox("Error", response.data.error.message, "error");
                    alertbox("Error", response, "error");
                    this.removeFile(file);
                });
                this.on("complete", function(file) {});
            },
            accept: function(file, done) {
                done();
            }
        });


        $("#schedule").click(function(e) {
            $("#action_name").val("schedule");
            var channel_title = $("#channel_title").val();
            $("#loader").show();
            myDropzone.processQueue();
            $("#loader").hide();
        });
        $("#publish").click(function(e) {
            $("#action_name").val("publish");
            var filesCopy = [...myDropzone.files];
            processQueueWithDelay(filesCopy);
        });

        var video_action = '';

        var youtube_data = function() {
            var video_path = $('#video_path').val();
            var video_title = $("#video_title").val();
            var video_description = $("#video_description").val();
            var video_category = $("#video_category option:selected").val();
            var privacyStatus = $("#privacyStatus option:selected").val();
            var kids = $('#kids').is(":checked") ? '1' : '0';
            var tags = $("#tags").tagsinput('items');
            var thumbnail = $('#thumbnail')[0].files[0];
            var formData = new FormData();
            formData.append('thumbnail', thumbnail);
            formData.append('video_path', video_path);
            formData.append('video_title', video_title);
            formData.append('video_description', video_description);
            formData.append('video_category', video_category);
            formData.append('privacyStatus', privacyStatus);
            formData.append('kids', kids);
            formData.append('tags', tags);
            formData.append('action', video_action);

            return formData;
        }

        function youtube_upload() {
            $("#loader").show();
            $("#preloader_ajax").show();
            var dataOBJ = youtube_data();

            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: "<?php echo SITEURL; ?>upload_to_youtube",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    enableButton(currentActionButton);
                    $("#loader").hide();
                    $("#preloader_ajax").hide();
                    if (response.status) {
                        alertbox("Success", response.message, "success");
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    } else {
                        alertbox("Error", response.message, "error");
                    }
                },
                error: function(response) {
                    $("#loader").hide();
                    $("#preloader_ajax").hide();
                    enableButton(currentActionButton);
                    alertbox("Error", response.message, "error");
                }
            });

        }


        $("#video_publish").click(function(e) {
            currentActionButton = $(this);
            var videoPublish = $(this);
            video_action = 'publish';
            var video_title = $("#video_title").val();
            var filled = true;
            if (video_title == "" || video_title == null) {
                filled = false;
                alertbox("Error", "Video title field is required", "error");
            } else {
                if (video_title.length >= 99) {
                    filled = false;
                    alertbox("Error", "Video title can't be more than 99 characters!", "error");
                }
            }
            var video_category = $("#video_category").val();
            if (video_category == "" || video_category == null) {
                filled = false;
                alertbox("Error", "Video Category field is required", "error");
            }
            var video_path = $("#video_path").val();
            if (video_path == "" || video_path == null) {
                filled = false;
                alertbox("Error", "Video is missing!", "error");
            }
            if (filled) {
                disableButton(currentActionButton, "Publish");
                youtube_upload();
            }
        });
        $("#video_schedule").click(function(e) {
            currentActionButton = $(this);
            video_action = 'schedule'
            var video_title = $("#video_title").val();
            var filled = true;
            if (video_title == "" || video_title == null) {
                filled = false;
                alertbox("Error", "Video title field is required", "error");
            } else {
                if (video_title.length >= 99) {
                    filled = false;
                    alertbox("Error", "Video title can't be more than 99 characters!", "error");
                }
            }
            var video_category = $("#video_category").val();
            if (video_category == "" || video_category == null) {
                filled = false;
                alertbox("Error", "Video Category field is required", "error");
            }
            var video_path = $("#video_path").val();
            if (video_path == "" || video_path == null) {
                filled = false;
                alertbox("Error", "Video is missing!", "error");
            }
            if (filled) {
                disableButton(currentActionButton, "Publish");
                youtube_upload();
            }
        });
        $("#save").click(function(e) {
            $("#action_name").val("save");
            var channel_title = $("#channel_title").val();
            myDropzone.processQueue();
        });

        var text_area = function() {
            var textareaValue = $("#channel_title").val();
            // add the fetchedUrl to the textareaValue if it is not already present in the textareaValue 

            if (fetchedUrl && textareaValue.indexOf(fetchedUrl) == -1) {
                textareaValue = textareaValue + " " + fetchedUrl;
            }
            var linkRegex = /(https?:\/\/[^\s]+)/g;
            var linkMatches = textareaValue.match(linkRegex);
            var link = linkMatches ? linkMatches[0] : "";

            // Get the text other than link
            // var title = textareaValue.replace(link, "");
            var title = $("#channel_title_visible").val();

            // Validate the link to check if it is a valid URL
            if (link && !link.match(
                    /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/
                )) {
                alertbox("Error", "Please enter a valid link.", "error");

            }
            var linkValue = link;
            var titleValue = title;
            titleValue = titleValue.trim();

            var comment_title = $("#comment_title").val();

            var channel_comment = $("#post_comment").val();

            var dataOBJ = {
                'channel_link': linkValue,
                'channel_title': titleValue,
                'channel_comment': channel_comment
            }
            return dataOBJ;
        };

        $("#publish").click(function(e) {
            currentActionButton = $(this);
            disableButton($(currentActionButton), "Publish");
            $("#loader").show();
            var dataOBJ = text_area();
            var channel_title = $("#channel_title_visible").val();
            if (myDropzone.getAcceptedFiles().length == 0) {
                if (channel_title != "" || fetchedUrl != "") {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo SITEURL; ?>publish_channels_to_link",
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response) {
                            enableButton(currentActionButton);
                            firstPreview = true;
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            if (response.status) {
                                alertbox("Success", response.message, "success");
                                get_channels_scheduled();
                                $("#channel_title").val('');
                                $("#post_comment").val('');
                                $("#channel_comment").val('');
                                $("#channel_title_visible").val('');
                                $("#previewbox").html("");
                                fetchedUrl = "";
                                fetchedThumbnail = "";
                            } else {
                                alertbox("Error", response.message, "error");
                            }
                        },
                        error: function(response) {
                            enableButton(currentActionButton);
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            alertbox("Error", response.message, "error");
                        }
                    });
                } else {
                    enableButton(currentActionButton);
                    $("#loader").hide();
                    $("#preloader_ajax").hide();
                    alertbox("Error", "Please Provide Post Title", "error");
                }

            }
        });

        $("#schedule").click(function(e) {
            currentActionButton = $(this);
            disableButton(currentActionButton, "Queue");
            $("#loader").show();
            $("#preloader_ajax").show();
            var dataOBJ = text_area();
            var channel_title = $("#channel_title_visible").val();
            if (myDropzone.getAcceptedFiles().length == 0) {
                if (channel_title != "" || fetchedUrl != "") {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo SITEURL; ?>schedule_channels_to_link",
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response) {
                            enableButton(currentActionButton);
                            firstPreview = true;
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            if (response.status) {
                                alertbox("Success", response.message, "success");
                                get_channels_scheduled();
                                $("#channel_title").val('');
                                $("#post_comment").val('');
                                $("#channel_comment").val('');
                                $("#channel_title_visible").val('');
                                $("#previewbox").html("");
                                fetchedUrl = "";
                                fetchedThumbnail = "";
                            } else {
                                alertbox("Error", response.message, "error");
                            }
                        },
                        error: function(response) {
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            enableButton(currentActionButton);
                            alertbox("Error", "Something went wrong", "error");
                        }
                    });
                } else {
                    $("#loader").hide();
                    $("#preloader_ajax").hide();
                    enableButton(currentActionButton);
                    alertbox("Error", "Please Provide Post Title", "error");
                }
            }

        });

        $(document).on('click', '#save', function() {
            $("#loader").show();
            $("#preloader_ajax").show();
            var dataOBJ = text_area();

            var channel_title = $("#channel_title").val();

            if (myDropzone.getAcceptedFiles().length == 0) {

                if (channel_title != "" || fetchedUrl != "") {

                    $.ajax({
                        type: "POST",
                        url: "<?php echo SITEURL; ?>save_channels_to_link",
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response) {
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            if (response.status) {
                                alertbox("Success", response
                                    .message, "success");
                                $("#previewbox").html("");
                                $("#channel_title").val('');
                                $("#post_comment").val('');
                                fetchedUrl = "";
                                fetchedThumbnail = "";

                            } else {
                                alertbox("Error", response
                                    .message, "error");
                            }
                        },
                        error: function() {
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            alertbox("Failed",
                                "Something went wrong please try agian",
                                "error");
                        }
                    });

                } else {
                    $("#loader").hide();
                    $("#preloader_ajax").hide();
                    alertbox("Error", "Please Provide Post Title", "error");
                }

            }
        });


        // delbulkone
        $(document).on('click', '.delbulkone', function() {
            $('#preloader_ajax').show();
            id = $(this).data('id');
            row = $("#card_" + id);
            var dataOBJ = {
                'id': id
            }
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>channel_bulk_scheduled_delete",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        $("#left").text(parseInt($("#left")
                            .text()) + 1);
                        $('#preloader_ajax').hide();
                        row.remove();
                        alertbox('Success',
                            'Your scheduled post Removed Successfully!',
                            'success');
                    }
                },
                error: function() {
                    $('#preloader_ajax').hide();
                    alertbox("Error",
                        "Nothing Has been deleted, try again",
                        "error");
                    // swal("Error", "Nothing Has been deleted, please try again", "error");
                }
            });
        });

        // delete_yt_schedule
        $(document).on('click', '.delete_yt_schedule', function() {
            $('#preloader_ajax').show();
            id = $(this).data('id');
            row = $("#card_" + id);
            var dataOBJ = {
                'id': id
            }
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>delete_youtube_queued_post",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        $("#left").text(parseInt($("#left")
                            .text()) + 1);
                        $('#preloader_ajax').hide();
                        row.remove();
                        alertbox('Success',
                            'Your scheduled post Removed Successfully!',
                            'success');
                    }
                },
                error: function() {
                    $('#preloader_ajax').hide();
                    alertbox("Error",
                        "Nothing Has been deleted, try again",
                        "error");
                    // swal("Error", "Nothing Has been deleted, please try again", "error");
                }
            });
        });

        // deleteall
        $(document).on('click', '.deleteall', function() {
            swal({
                title: "Delete ALL Posts???",
                text: "You will not be able to recover these posts again!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete ALL!",
                closeOnConfirm: false
            }, function() {
                $("#loader").show();
                $("#preloader_ajax").show();
                var channel_filter = $("#channel_filter").val();
                var dataOBJ = {
                    'channel': channel_filter,
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>channel_bulk_scheduled_delete_all",
                    data: dataOBJ,
                    success: function(response) {
                        $(".shuffle").hide();
                        $(".deleteall").hide();
                        $(".refresh").hide();
                        $("#loader").hide();
                        $("#preloader_ajax").hide();
                        if (response.status) {
                            $("#left").text(parseInt($(
                                        "#left")
                                    .text()) +
                                parseInt(response
                                    .total));
                            $("#sceduled").html("");
                            swal({
                                title: "Deleted!",
                                text: "Your scheduled posts Removed Successfully!",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        $("#loader").hide();
                        $("#preloader_ajax").hide();
                        swal("Error", "Nothing Has been deleted, please try again", "error");
                    }
                });
            });
        })
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });
    });
    var shuffle_posts = function() {
        var page = $("#pages").val();
        swal({
            title: "Shuffle All Posts???",
            text: "You will not be able to recover order of these posts again!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Shuffle All!",
            closeOnConfirm: false
        }, function() {
            $("#loader").show();
            var dataOBJ = {
                'page': page
            }
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>shuffle_scheduled_posts",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    $("#loader").hide();
                    $('#pages').trigger('change');
                    if (response.status) {
                        get_channels_scheduled();
                        swal({
                            title: "Success!",
                            text: "Your scheduled posts are shuffled in random order Successfully!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function() {
                    $("#loader").hide();
                    swal("Error", "Nothing Has been changed, please try again", "error");
                }
            });
        });
    };
    $('.shuffle').on('click', function() {
        shuffle_posts();
    });

    function create_block(elem) {
        var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
        node += '<div class="card blog-widget">'
        node += '<div class="card-body">';
        if (elem.link_type == "full") {
            node += '<div class="blog-image cursor-pointer"><a class="gallery" href="' +
                elem.link + '" title="' + elem.post_date +
                '"><img  style="height:250px;" loading="lazy" src="' + elem.link +
                '" alt="img" class="img-fluid blog-img-height w-100" /></a></div>'
        } else {
            node += '<div class="blog-image cursor-pointer"><a class="gallery" href="<?= BulkAssets ?>' + elem.link + '" title="' + elem.post_date +
                '"><img  style="height:250px;" loading="lazy" src="<?= BulkAssets ?>' + elem.link +
                '" alt="img" class="img-fluid blog-img-height w-100" /></a></div>'
        }
        if (elem.title != '') {
            node += '<p class="my-1" style="height:35px;overflow: auto;" title="' + elem.title +
                '"><strong>' + elem.title.slice(0, 30) + '</strong></p>'
        }
        if (elem.status == '-1') {
            node += '<div class="alert alert-danger">' + elem.message + '</div>';
        }
        // chech if type is facebook 
        if (elem.type == "facebook") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green; zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + facebook_page_icon + '" class="rounded-circle mr-2" alt="' + facebook_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'

        } else if (elem.type == "pinterest") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + pinterest_board_icon + '" class="rounded-circle mr-2" alt="' + pinterest_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        } else if (elem.type == "instagram") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + instagram_account_icon + '" class="rounded-circle mr-2" alt="' + instagram_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        } else if (elem.type == "fb_groups") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + facebook_page_icon + '" class="rounded-circle mr-2" alt="' + facebook_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        } else if (elem.type == 'youtube') {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + youtube_icon + '" class="rounded-circle mr-2" alt="' + youtube_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        } else if (elem.type == 'tiktok') {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + tiktok_account_icon + '" class="rounded-circle mr-2" alt="' + tiktok_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        }

        var date = new Date(elem.post_date);
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var monthName = monthNames[date.getMonth()];

        var date_ = date.getDate() + " " + monthName + ", " + date.getFullYear();
        // var date_ = date.getDate();

        var day = date.getDay();
        var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
            "Saturday"
        ];
        var dayName = dayName[day];
        // console.log(dayName);  
        if (elem.type == "pinterest" || elem.type == "facebook") {
            node +=
                '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
            node +=
                '<div class="read"><p><strong><i class="mdi mdi-calendar-clock text-info mdi-24px"></i> ' +
                elem.post_date + ', ' + elem.post_time + '</strong></p></div>'
            node += '<div class="ml-auto">'
            node += '</div>'
            node += '</div>'
            node += '<div class="d-flex float-right">'
            node +=
                '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success publish_now" data-id="' + elem.id + '" data-toggle="tooltip" title="Publish this post!">Publish</a>'
            node +=
                '<a href="javascript:void(0);" class="h5 cursor-pointer delbulkone btn btn-sm btn-outline-danger" data-id="' + elem.id + '" data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
            node += '</div>'
        } else if (elem.type == 'youtube') {
            node +=
                '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
            node +=
                '<div class="read"><p><strong><i class="mdi mdi-calendar-clock text-info mdi-24px"></i> ' +
                date_ + ', ' + elem.post_time + '</strong></p></div>'
            node += '<div class="ml-auto">'
            node += '</div>'
            node += '</div>'
            node += '<div class="d-flex float-right">'
            node += '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success publish_now" data-id="' + elem.id + '" data-toggle="tooltip" title="Publish this post!">Publish</a>'
            node += '<a href="javascript:void(0);" class="h5 cursor-pointer delete_yt_schedule btn btn-sm btn-outline-danger" data-id="' + elem.id + '" data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
            node += '</div>';
        } else {
            node +=
                '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
            node +=
                '<div class="read"><p><strong><i class="mdi mdi-calendar-clock text-info mdi-24px"></i> ' +
                date_ + ', ' + elem.post_time + '</strong></p></div>'
            node += '<div class="ml-auto">'
            node += '</div>'
            node += '</div>'
            node += '<div class="d-flex float-right">'
            node +=
                '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success publish_now"  data-id="' + elem.id + '" data-toggle="tooltip" title="Publish this post!">Publish</a>'
            node +=
                '<a href="javascript:void(0);" class="h5 cursor-pointer delbulkone btn btn-sm btn-outline-danger" data-id="' + elem.id + '" data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
            node += '</div>'
        }
        return node;
    }

    function create_publish_block(elem) {

        var post_id = elem.post_id;
        var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
        node += '<div class="card blog-widget">'
        node += '<div class="card-body">';
        if (elem.link_type == "full") {
            node += '<div class="blog-image cursor-pointer">';
            node += '<a class="gallery" href="' + elem.link + '" title="' + elem.post_date + '">';
            node += '<img  style="height:250px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100" />';
            node += '</a></div>';
        } else {
            node += '<div class="blog-image cursor-pointer">';
            node += '<a class="gallery" href="<?php echo BulkAssets; ?>' + elem.link + '" title="' + elem.post_date + '">';
            node += '<img  style="height:250px;" loading="lazy" src="<?php echo BulkAssets; ?>' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100" />';
            node += '</a></div>';

        }
        node += '<p class="my-1" style="height:35px;overflow: auto;" title="' + elem.title + '">';
        node += '<strong>' + elem.title.slice(0, 30) + '...</strong></p>';
        // chech if type is facebook 
        if (elem.type == "facebook") {
            node += '<div class="d-flex justify-content-between">';
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green; zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + facebook_logo + '" class="rounded-circle mr-2" alt="' + facebook_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
            node +=
                '<button class="btn btn-rounded p-1 px-2 m-2 text-danger delete_post" style="border: 1px solid red; zoom:0.80;" data-id="' + post_id + '" data-account="' + elem.channel_name + '" data-account_id="' + elem.channel_id + '" data-type="Facebook"><b><p class="m-0"><span>Delete</span></p></b></button>'
            node += '</div>';
        } else if (elem.type == "pinterest") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + facebook_page_icon + '" class="rounded-circle mr-2" alt="' + pinterest_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'

        } else if (elem.type == "instagram") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + instagram_account_icon + '" class="rounded-circle mr-2" alt="' + instagram_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        } else if (elem.type == "fb_groups") {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + instagram_account_icon + '" class="rounded-circle mr-2" alt="' + instagram_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        } else if (elem.type == 'youtube') {
            node +=
                '<button class="btn btn-rounded p-1 pr-2 m-2" style="border: 1px solid green;zoom:0.80;"> <p class="m-0"><img style="width:35px;height:35px;" src="' + youtube_icon + '" class="rounded-circle mr-2" alt="' + instagram_logo + '">' +
                '<b>' + elem.channel_name + '</b></p> </button>'
        }

        var date = new Date(elem.post_date);
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var monthName = monthNames[date.getMonth()];

        var date_ = date.getDate() + " " + monthName + ", " + date.getFullYear();
        // var date_ = date.getDate();

        var day = date.getDay();
        var dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
            "Saturday"
        ];
        var dayName = dayName[day];
        // console.log(dayName);  
        if (elem.type == "pinterest" || elem.type == "facebook") {
            node +=
                '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
            node +=
                '<div class="read"><p><strong><i class="mdi mdi-calendar-clock text-info mdi-24px"></i> ' +
                elem.post_date + ', ' + elem.post_time + '</strong></p></div>'
            node += '<div class="ml-auto">'
            node += '</div>'
            node += '</div>'
        } else if (elem.type == 'youtube') {
            node +=
                '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
            node +=
                '<div class="read"><p><strong><i class="mdi mdi-calendar-clock text-info mdi-24px"></i> ' +
                date_ + ', ' + elem.post_time + '</strong></p></div>'
            node += '</div>'
        } else {
            node +=
                '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">'
            node +=
                '<div class="read"><p><strong><i class="mdi mdi-calendar-clock text-info mdi-24px"></i> ' +
                date_ + ', ' + elem.post_time + '</strong></p></div>'
            node += '</div>'
        }
        return node;
    }

    // $(document).ready(function() {

    //     var multipleCancelButton = new Choices('.choices-multiple-remove-button', {
    //         removeItemButton: true,
    //         // maxItemCount:5,
    //         // searchResultLimit:5,
    //         // renderChoiceLimit:5
    //     });
    // });

    // $('#pinForm').submit(function(event) {
    //     event.preventDefault();

    //     if ($.trim($("#image").val()) === "" || $.trim($("#title").val()) === "" || $.trim($("#description").val()) === "") {
    //         alert('You did not fill out all the fields');
    //         return false;
    //     } else {

    //         var dataOBJ = {
    //             'image': $("#image").val(),
    //             'title': $("#title").val(),
    //             'description': $("#description").val(),
    //         }

    //         $.ajax({
    //             type: "POST",
    //             url: "<?php echo SITEURL; ?>create_pin",
    //             dataType: "json",
    //             data: dataOBJ,
    //             success: function(response) {
    //                 // alertbox('Success: ' + respone.success);
    //                 swal("Success:", response.success, "success");
    //             },
    //             error: function(response) {
    //                 // alertbox('Error: ' + respone.error);
    //                 swal("Error:", response.error, "error");
    //             }
    //         });
    //     }
    // });

    // var save_channel_settings = function(event) {
    //     event.preventDefault();
    //     // console.log($("#facebook").val());
    //     // console.log($("#pinterest").val());

    //     var dataOBJ = {
    //         'facebook': $("#facebook").val(),
    //         'pinterest': $("#pinterest").val(),
    //     }

    //     $.ajax({
    //         type: "POST",
    //         url: "<?php echo SITEURL; ?>channel_settings",
    //         dataType: "json",
    //         data: dataOBJ,
    //         success: function(response) {
    //             alertbox('Success: ' + response.success);
    //         },
    //         error: function(response) {
    //             alertbox('Error: ' + response.error);
    //         }
    //     });
    // }

    // if ($.trim($("#facebook").val()) === "" || $.trim($("#pinterest").val()) === "") {
    //     alertbox('You did not select out all the fields of channels');
    // }

    // if ($.trim($("#facebook").val()) !== "" || $.trim($("#pinterest").val()) !== "") {
    //     // $(document).change(save_channel_settings);
    //     $(".save_channel_settings").on('change', save_channel_settings);
    // } else {
    //     alertbox('You did not select out all the fields of channels');
    // }

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
                    get_channels_scheduled();
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
                    get_channels_scheduled();
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
                    get_channels_scheduled();
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
                    get_channels_scheduled();
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
                $(".chosen-fbpages_timeslots").trigger(
                    "chosen:updated");
                $(".chosen-boards_timeslots").val(time_slots);
                $(".chosen-boards_timeslots").trigger("chosen:updated");
                $(".chosen-ig_timeslots").val(time_slots);
                $(".chosen-ig_timeslots").trigger("chosen:updated")
                $(".chosen-fbgroup_timeslots").val(time_slots);
                $(".chosen-fbgroup_timeslots").trigger("chosen:updated")
                get_channels_scheduled();
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
                    alertbox("Success",
                        "Page Auto Posting Updated Successfully",
                        "success");
                }
            },
            error: function() {
                alertbox("Error", "Nothing Has been changed, try again",
                    "error");
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
                    alertbox("Success",
                        "Page Auto Posting Updated Successfully",
                        "success");
                }
            },
            error: function() {
                alertbox("Error", "Nothing Has been changed, try again",
                    "error");
            }
        });
    });

    var get_channels_settings = function() {
        $.ajax({
            type: "GET",
            url: "<?php echo SITEURL; ?>get_channels_settings",
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#channels").html("");
                    if (response.data.fbpages.length > 0) {
                        var youtube_check = false;
                        var facebook_check = false;
                        $.each(response.data.fbpages, function(index, value) {
                            facebook_page_icon = "<?= BulkAssets; ?>" + value.profile_pic;
                            if (empty(facebook_page_icon)) {
                                facebook_page_icon = facebook_logo;
                            }
                            if (value.channel_active == 1) {
                                facebook_check = true;
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 fb_channel channel-button' data-type='facebook' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + facebook_page_icon + "' class='rounded-circle mr-2' alt='" + facebook_logo + "'> " +
                                    '<b>' + value.page_name + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right fb_channel channel-button active' data-type='facebook' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;height:35px;' src='" + facebook_page_icon + "' class='rounded-circle mr-2' alt='" + facebook_logo + "'> " +
                                    '<b>' + value.page_name + '</b>' +
                                    "</button>");
                            }
                        });
                    }
                    if (response.data.boards.length > 0) {
                        $.each(response.data.boards, function(index, value) {
                            pinterest_board_icon = "<?= BulkAssets ?>" + value.profile_pic;
                            if (empty(pinterest_board_icon)) {
                                pinterest_board_icon = pinterest_logo;
                            }
                            if (value.channel_active == 1) {
                                facebook_check = false;
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 board_channel channel-button' data-type='pinterest' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + pinterest_board_icon + "' class='rounded-circle mr-2' alt='" + pinterest_logo + "'> " +
                                    '<b>' + value.name + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right board_channel channel-button active' data-type='pinterest' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;height:35px;' src='" + pinterest_board_icon + "' class='rounded-circle mr-2' alt='" + pinterest_logo + "'> " +
                                    '<b>' + value.name + '</b>' +
                                    "</button>");
                            }
                        });
                    }
                    if (response.data.ig_accounts.length > 0) {
                        $.each(response.data.ig_accounts, function(index, value) {
                            instagram_account_icon = "<?= BulkAssets ?>" + value.profile_pic;
                            if (empty(instagram_account_icon)) {
                                instagram_account_icon = instagram_logo;
                            }
                            if (value.channel_active == 1) {
                                facebook_check = false;
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 ig_channel channel-button' data-type='instagram' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                    '<b>' + value.instagram_username + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right ig_channel channel-button active' data-type='instagram' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                    '<b>' + value.instagram_username + '</b>' +
                                    "</button>");
                            }
                        });
                    }
                    if (response.data.fb_groups.length > 0) {
                        $.each(response.data.fb_groups, function(index, value) {
                            if (value.active == 'y') {
                                if (value.channel_active == 1) {
                                    facebook_check = false;
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 fbgroup_channel channel-button' data-type='fbgroup' data-id='" +
                                        value.id +
                                        "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                        '<b>' + value.name + '</b>' +
                                        "</button>");
                                } else {
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right fbgroup_channel channel-button active' data-type='fbgroup' data-id='" +
                                        value.id +
                                        "' ><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                        '<b>' + value.name + '</b>' +
                                        "</button>");
                                }
                            }
                        });
                    }
                    if (response.data.yt_channels.length > 0) {
                        $.each(response.data.yt_channels, function(index, value) {
                            youtube_icon = "<?= BulkAssets ?>" + value.channel_thumbnail;
                            if (empty(youtube_icon)) {
                                youtube_icon = youtube_logo;
                            }
                            if (value.active == '1') {
                                if (value.channel_active == 1) {
                                    youtube_check = true;
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 yt_channel channel-button' data-type='youtube' data-id='" +
                                        value.id +
                                        "' style='border: 2px solid green;'><img style='width:35px;' src='" + youtube_icon + "' class='rounded-circle mr-2' alt='" + youtube_logo + "'> " +
                                        '<b>' + value.channel_title + '</b>' +
                                        "</button>");
                                } else {
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right yt_channel channel-button active' data-type='youtube' data-id='" +
                                        value.id +
                                        "' ><img style='width:35px;' src='" + youtube_icon + "' class='rounded-circle mr-2' alt='" + youtube_logo + "'> " +
                                        '<b>' + value.channel_title + '</b>' +
                                        "</button>");
                                }
                            }
                        });
                    }
                    if (response.data.tiktoks.length > 0) {
                        $.each(response.data.tiktoks, function(index, value) {
                            tiktok_account_icon = "<?= BulkAssets ?>" + value.profile_pic;
                            if (empty(tiktok_account_icon)) {
                                tiktok_account_icon = tiktok_logo;
                            }
                            if (value.channel_active == 1) {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 tiktok_acc channel-button' data-type='tiktok' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;' src='" + tiktok_account_icon + "' class='rounded-circle mr-2' alt='" + tiktok_logo + "'> " +
                                    '<b>' + value.username + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right tiktok_acc channel-button active' data-type='tiktok' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;' src='" + tiktok_account_icon + "' class='rounded-circle mr-2' alt='" + tiktok_logo + "'> " +
                                    '<b>' + value.username + '</b>' +
                                    "</button>");
                            }
                        });
                    }
                    if (youtube_check) {
                        toggle_buttons();
                        youtube_content();
                        youtube_content();
                        fetch_categories();
                    } else {
                        $('.social_content').show();
                        $('.youtube_content').hide();
                    }
                    if (facebook_check) {
                        facebook_comment();
                    } else {
                        $('.social_content_div').show();
                        // $('.facebook_comment_content').hide();
                    }

                } else {
                    alertbox("Error", "Channels Not Found", "error");
                }
            },
            error: function() {
                alertbox("Error", "Channels Not Found", "error");
            }
        });
    }

    var get_published_channels_settings = function() {
        $.ajax({
            type: "GET",
            url: "<?php echo SITEURL; ?>get_published_channels_settings",
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#channels").html("");
                    if (response.data.fbpages.length > 0) {
                        var youtube_check = false;
                        var facebook_check = false;
                        $.each(response.data.fbpages, function(index, value) {
                            if (value.channel_active == 1) {
                                facebook_check = true;
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 fb_channel channel-button' data-type='facebook' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + facebook_page_icon + "' class='rounded-circle mr-2' alt='" + facebook_logo + "'> " +
                                    '<b>' + value.page_name + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right fb_channel channel-button active' data-type='facebook' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;height:35px;' src='" + facebook_page_icon + "' class='rounded-circle mr-2' alt='" + facebook_logo + "'> " +
                                    '<b>' + value.page_name + '</b>' +
                                    "</button>");
                            }
                        });
                    }

                    if (response.data.boards.length > 0) {
                        $.each(response.data.boards, function(index, value) {
                            if (value.channel_active == 1) {
                                facebook_check = false;
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 board_channel channel-button' data-type='pinterest' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + pinterest_board_icon + "' class='rounded-circle mr-2' alt='" + pinterest_logo + "'> " +
                                    '<b>' + value.name + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right board_channel channel-button active' data-type='pinterest' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;height:35px;' src='" + pinterest_board_icon + "' class='rounded-circle mr-2' alt='" + pinterest_logo + "'> " +
                                    '<b>' + value.name + '</b>' +
                                    "</button>");
                            }
                        });
                    }

                    if (response.data.ig_accounts.length > 0) {
                        $.each(response.data.ig_accounts, function(index, value) {
                            if (value.channel_active == 1) {
                                facebook_check = false;
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 ig_channel channel-button' data-type='instagram' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                    '<b>' + value.instagram_username + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right ig_channel channel-button active' data-type='instagram' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                    '<b>' + value.instagram_username + '</b>' +
                                    "</button>");
                            }
                        });
                    }

                    if (response.data.fb_groups.length > 0) {
                        $.each(response.data.fb_groups, function(index, value) {
                            if (value.active == 'y') {
                                if (value.channel_active == 1) {
                                    facebook_check = false;
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 fbgroup_channel channel-button' data-type='fbgroup' data-id='" +
                                        value.id +
                                        "' style='border: 2px solid green;'><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                        '<b>' + value.name + '</b>' +
                                        "</button>");
                                } else {
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right fbgroup_channel channel-button active' data-type='fbgroup' data-id='" +
                                        value.id +
                                        "' ><img style='width:35px;height:35px;' src='" + instagram_account_icon + "' class='rounded-circle mr-2' alt='" + instagram_logo + "'> " +
                                        '<b>' + value.name + '</b>' +
                                        "</button>");
                                }
                            }
                        });
                    }
                    if (response.data.yt_channels.length > 0) {
                        $.each(response.data.yt_channels, function(index, value) {
                            if (value.active == '1') {
                                if (value.channel_active == 1) {
                                    youtube_check = true;
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 yt_channel channel-button' data-type='youtube' data-id='" +
                                        value.id +
                                        "' style='border: 2px solid green;'><img style='width:35px;' src='" + youtube_icon + "' class='rounded-circle mr-2' alt='" + youtube_logo + "'> " +
                                        '<b>' + value.channel_title + '</b>' +
                                        "</button>");
                                } else {
                                    $("#channels").append(
                                        "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right yt_channel channel-button active' data-type='youtube' data-id='" +
                                        value.id +
                                        "' ><img style='width:35px;' src='" + youtube_icon + "' class='rounded-circle mr-2' alt='" + youtube_logo + "'> " +
                                        '<b>' + value.channel_title + '</b>' +
                                        "</button>");
                                }
                            }
                        });
                    }
                    if (response.data.tiktoks.length > 0) {
                        $.each(response.data.tiktoks, function(index, value) {
                            if (value.channel_active == 1) {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1  tiktok_acc channel-button' data-type='tiktok' data-id='" +
                                    value.id +
                                    "' style='border: 2px solid green;'><img style='width:35px;' src='" + tiktok_account_icon + "' class='rounded-circle mr-2' alt='" + tiktok_logo + "'> " +
                                    '<b>' + value.username + '</b>' +
                                    "</button>");
                            } else {
                                $("#channels").append(
                                    "<button class='btn btn-sm btn-rounded p-1 pr-3 m-1 border-right tiktok_acc channel-button active' data-type='tiktok' data-id='" +
                                    value.id +
                                    "' ><img style='width:35px;' src='" + tiktok_account_icon + "' class='rounded-circle mr-2' alt='" + tiktok_logo + "'> " +
                                    '<b>' + value.username + '</b>' +
                                    "</button>");
                            }
                        });
                    }
                    if (youtube_check) {
                        toggle_buttons();
                        youtube_content();
                        youtube_content();
                        fetch_categories();
                    } else {
                        $('.social_content').show();
                        $('.youtube_content').hide();
                    }
                    if (facebook_check) {
                        facebook_comment();
                    } else {
                        $('.social_content_div').show();
                        // $('.facebook_comment_content').hide();
                    }

                } else {
                    alertbox("Error", "Channels Not Found", "error");
                }
            },
            error: function() {
                alertbox("Error", "Channels Not Found", "error");
            }
        });
    }

    $(document).ready(get_channels_settings);

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
                    alertbox("Success",
                        "Channel Status Changed Successfully",
                        "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed",
                        "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed",
                    "error");
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
                    alertbox("Success",
                        "Channel Status Changed Successfully",
                        "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed",
                        "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed",
                    "error");
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
                    alertbox("Success",
                        "Channel Status Changed Successfully",
                        "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed",
                        "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed",
                    "error");
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
                    alertbox("success",
                        "Channel Status Changed Successfully",
                        "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed",
                        "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed",
                    "error");
            }
        });
    });

    $(document).on("click touchstart", ".yt_channel", function() {
        var id = $(this).data("id");
        var dataOBJ = {
            'channel_id': id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>yt_channel_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("success",
                        "Channel Status Changed Successfully",
                        "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed",
                        "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed",
                    "error");
            }
        });
    });

    $(document).on("click touchstart", ".tiktok_acc", function() {
        var id = $(this).data("id");
        var dataOBJ = {
            'channel_id': id,
        }
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>tiktok_acc_active",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alertbox("Success",
                        "Channel Status Changed Successfully",
                        "success");
                    get_channels_settings();
                } else {
                    alertbox("Error", "Channel Status Not Changed",
                        "error");
                }
            },
            error: function() {
                alertbox("Error", "Channel Status Not Changed",
                    "error");
            }
        });
    });

    var toggle_buttons = function() {
        var all_channel_buttons = $('.channel-button');
        $.each(all_channel_buttons, function(index, item) {
            var data_type = $(this).attr('data-type');
            if (data_type != 'youtube') {
                $(this).prop('disabled', true);
                $(this).css('border', '');
                $(this).find('.delete-button').remove();
            }
        });
    }

    var youtube_content = function() {
        $('.youtube_content').show();
        $('.social_content').hide();
    }

    var facebook_comment = function() {
        $('.facebook_comment_content').show();
        $('.social_content_div').hide();
    }

    var fetch_categories = function() {
        $.ajax({
            type: "GET",
            url: "<?php echo SITEURL; ?>fetch_youtube_categories",
            success: function(response) {
                $.each(response.data, function(key, category) {
                    $('#video_category').append($('<option>', {
                        value: category.id,
                        text: category.snippet.title
                    }));
                });
                var selected_category_id = $("#selected_category").val();
                $('#video_category').val(selected_category_id).prop(
                    'selected', true);
            },
            error: function(response) {
                // swal("Error", 'Something went wrong', "error");
            }
        });
    }

    var get_channels_scheduled = function() {
        var channel = $("#channel_filter").val();
        var type = '';
        if (channel != 'all') {
            type = $("#channel_filter").find(":selected").data('type');
        }
        $.ajax({
            type: "GET",
            url: "<?php echo SITEURL; ?>get_channels_scheduled?channel=" + channel + "&type=" + type,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#sceduled").html("");
                    if (response.data) {
                        $(".shuffle").show();
                        $(".deleteall").show();
                        $(".refresh").show();
                    }
                    $.each(response.data, function(index, elem) {
                        tr = create_block(elem);
                        $("#sceduled").append(tr);
                    });
                }
            },
            error: function() {
                $("#sceduled").html("");
            }
        });
    }

    var get_published_channels_scheduled = function() {
        var channel = $("#channel_filter").val();
        var type = '';
        if (channel != 'all') {
            type = $("#channel_filter").find(":selected").data('type');
        }
        $.ajax({
            type: "GET",
            url: "<?php echo SITEURL; ?>get_published_channels_scheduled?channel=" + channel + "&type=" + type,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#sceduled").html("");
                    if (response.data) {
                        $(".shuffle").show();
                        $(".deleteall").show();
                        $(".refresh").show();
                    }
                    $.each(response.data, function(index, elem) {
                        tr = create_publish_block(elem);
                        $("#sceduled").append(tr);
                    });
                }
            },
            error: function() {
                $("#sceduled").html("");
            }
        });
    }
    $(document).on("change", "#channel_filter", get_channels_scheduled);

    function disconnectSocialMedia(accountType, disconnectAction, customUrl) {
        swal({
            title: `Confirm Disconnect ${accountType} Account`,
            text: `You are about to Disconnect Your ${accountType} Account from Adublisher.com. Do you want to proceed?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, I am sure",
            closeOnConfirm: false
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
                                swal("Success",
                                    `${accountType} Account Disconnected Successfully`,
                                    "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal("Error",
                                    `${accountType} Account Not Disconnected`,
                                    "error");
                            }
                        }).fail(function(response) {
                            $("#loader").hide();
                            $("#preloader_ajax").hide();
                            swal("Error",
                                `${accountType} Account Not Disconnected`,
                                "error");
                        });
                    });
                }
            }
        });
    }

    $(document).on('click', '#disconnect-facebook', function() {
        disconnectSocialMedia("Facebook", true,
            "<?php echo SITEURL; ?>disconnectfacebook");
    });

    $(document).on('click', '#disconnect-pinterest', function() {
        disconnectSocialMedia("Pinterest", true,
            "<?php echo SITEURL; ?>disconnectpinterest");
    });

    $(document).on('click', '#disconnect-instagram', function() {
        disconnectSocialMedia("Instagram", true,
            "<?php echo SITEURL; ?>disconnectinstagram");
    });

    $(document).on('click', '#disconnect-fbgroups', function() {
        disconnectSocialMedia("Facebook Groups", true,
            "<?php echo SITEURL; ?>disconnect_fb_groups");
    });

    // Get the current URL
    var currentUrl = window.location.href;

    // Check if either query parameter exists in the URL
    if (currentUrl.includes('?status=true#_=_') || currentUrl.includes(
            '?status=false#_=_')) {
        // Remove the query parameter from the URL
        var updatedUrl = currentUrl.replace('?status=true#_=_', '').replace(
            '?status=false#_=_', '');

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
                        url: "<?php echo SITEURL; ?>" +
                            'cron_job_error',
                        method: 'POST',
                        data: {
                            id: id,
                            type: type
                        },
                        success: function(response) {
                            // On success, manually close the alert
                            closeButton.closest(
                                '.alert').alert(
                                'close');
                            swal("Cleared!",
                                "The respective error is cleared Successfully",
                                "success");
                        },
                        error: function(xhr, status,
                            error) {
                            // Handle errors here
                            console.error(error);
                            swal("Cleared!",
                                "Something went wrong please try again",
                                "failed");
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#channel_title_visible').on('input', function() {
            countCharacters();
        });

        function countCharacters() {
            const textarea = document.getElementById('channel_title_visible');
            const charCount = document.getElementById('charCount');
            const currentLength = textarea.value.length;

            charCount.textContent = `${currentLength} characters`;
        }
    });
    $(document).ready(function() {
        var tags = $('#selected_tags').val();
        if (tags != '' && tags != null) {
            tagsArray = tags.split(",");
            $.each(tagsArray, function(index, value) {
                $('#tags').tagsinput('add', value);
            });
        }
    });
    $(document).ready(function() {
        $('#video_title').on('input', function() {
            countCharacters();
        });

        function countCharacters() {
            const textarea = document.getElementById('video_title');
            const video_title_count = document.getElementById('video_title_count');
            const currentLength = textarea.value.length;

            video_title_count.textContent = `${currentLength} /99 characters`;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.publish_now', function() {
            currentActionButton = $(this);
            var id = $(this).data('id');
            var publish_url = 'publishNowQueuedPost'
            swal({
                title: "Publish Now!",
                html: true,
                text: "Are you sure you want to Publish this post Now?",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#1e88e5",
                confirmButtonText: "Publish Now!",
                closeOnConfirm: true // Automatically close on confirm
            }, function(confirmed) {
                // Check if the user confirmed the delete operation
                if (confirmed) {
                    publishNow(id, publish_url);
                }
            });
        });
        var publishNow = function(post_id, url) {
            $('#preloader_ajax').show();
            $.ajax({
                type: "POST",
                url: "<?php SITEURL ?>" + url,
                data: {
                    'id': post_id
                },
                success: function(response) {
                    $('#preloader_ajax').hide();
                    if (response.status) {
                        row = $("#card_" + post_id);
                        row.remove();
                        alertbox('Success',
                            'Your post has been Published Successfully!',
                            'success');
                    } else {
                        alertbox('Error', response.data, 'error');
                    }
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        var offset = 0;
        $('.bulk_upload_scheduled').on('click', function() {
            $(this).addClass('btn-info');
            $(this).removeClass('btn-secondary');
            $('.bulk_upload_published').addClass('btn-secondary');
            $('.bulk_upload_published').removeClass('btn-info');
            $('.deleteall, .shuffle, .refresh').attr('disabled', false);
            get_channels_scheduled();
        });
        $('.bulk_upload_published').on('click', function() {
            $(this).addClass('btn-info');
            $(this).removeClass('btn-secondary');
            $('.bulk_upload_scheduled').addClass('btn-secondary');
            $('.bulk_upload_scheduled').removeClass('btn-info');
            $('.deleteall, .shuffle, .refresh').attr('disabled', true);
            // get published bulk posts
            get_published_channels_scheduled();
        });
        var loading = false;
        var load_more = function() {
            var channel = $("#channel_filter").val();
            var type = '';
            if (channel != 'all') {
                type = $("#channel_filter").find(":selected").data('type');
            }
            offset += 20;
            $.ajax({
                type: "GET",
                url: "<?php echo SITEURL; ?>load_more_channels_scheduled?channel=" + channel + "&type=" + type,
                data: {
                    offset: offset
                },
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        if (response.data) {
                            $(".shuffle").show();
                            $(".deleteall").show();
                            $(".refresh").show();
                        }
                        $.each(response.data, function(index, elem) {
                            tr = create_block(elem);
                            $("#sceduled").append(tr);
                        });
                    }
                    loading = false;
                },
                error: function() {
                    $("#sceduled").html("");
                }
            });
        }
        $(window).on('scroll load', function() {
            if (loading) {
                return;
            }
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) { // Adjust threshold as needed
                loading = true;
                load_more();
            }
        });
        // refresh posts
        $(document).on('click', '.refresh', function() {
            refresh_scheduled_posts();
        });
        var refresh_scheduled_posts = function() {
            var channel = $("#channel_filter").val();
            var type = '';
            if (channel != 'all') {
                type = $("#channel_filter").find(":selected").data('type');
            }
            swal({
                title: "Refresh all posts?",
                text: "Are you sure you want to refresh all posts!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Refresh All!",
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    type: "GET",
                    url: "<?php echo SITEURL; ?>refresh_channels_scheduled?channel=" + channel + "&type=" + type,
                    dataType: "json",
                    success: function(response) {
                        $('#preloader_ajax').hide();
                        if (response.status) {
                            swal({
                                title: "Success!",
                                text: response.data,
                                type: "success",
                                showConfirmButton: false,
                                timer: 2500
                            });
                            setTimeout(function() {
                                $('#channel_filter').trigger('change');
                            }, 2500);
                        }
                    },
                    error: function() {
                        $('#preloader_ajax').hide();
                        swal("Error", "Nothing Has been changed, please try again", "error");
                    }
                });
            });
        };
    });
</script>

<script>
    $(".chosen_all_channels_timeslots").on('change', function() {
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
                    $('.delete-button-modal[data-id="' + id + '"]').closest('tr').remove();
                    $('.channel-button[data-id="' + id + '"]').remove();
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
    var deleteButton = $('.delete-button-modal'); // Find the delete button inside the channel-button
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

    $(document).on("click", ".delete_post", function() {
        var post_id = $(this).data("id");
        var account = $(this).data("account");
        var account_id = $(this).data("account_id");
        var type = $(this).data("type");
        swal({
            title: `Delete POST from ${account}`,
            text: `You are about to Delete this Post from ${account} on ${type}. Do you want to proceed?`,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, I am sure",
            closeOnConfirm: false
        }, function(isConfirmed) {
            if (isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo SITEURL; ?>delete_post",
                    data: {
                        "type": type,
                        "account": account,
                        "post_id": post_id,
                        "account_id": account_id,
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.bulk_upload_published').trigger("click");
                            alertbox("Success", response.message, "success");
                        } else {
                            alertbox("Error", response.message, "error");
                        }
                    }
                });
            }
        });
    })
</script>