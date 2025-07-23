<script type="text/javascript">
    $(function() {
        var offset, limit;
        $('#pages').change(function() {
            $('.info_tab').hide();
            offset = 0;
            limit = 20;
            var selected_id = $(this).val();
            var text = $(this).find('option:selected').text();
            var selected_type = $(this).find('option:selected').data('type');
            var schedule_url = '';
            if (selected_type == 'pinterest') {
                schedule_url = 'get_pinterest_rssscheduled';
            } else if (selected_type == 'facebook') {
                schedule_url = 'getrssscheduled';
            } else if (selected_type == 'fb_group') {
                schedule_url = 'get_fb_group_rssscheduled';
            } else if (selected_type == 'instagram') {
                schedule_url = 'get_ig_rssscheduled';
            } else if (selected_type == 'tiktok') {
                schedule_url = 'get_tiktok_rssscheduled';
            }
            if (selected_id != '' && selected_id != null) {
                save_default(selected_id);
            }
            get_rssscheduled(schedule_url);
        });

        var save_default = function(selected_id) {
            $.ajax({
                url: "<?php echo SITEURL; ?>save_default",
                type: "POST",
                data: {
                    'selected_id': selected_id
                }
            });
        }

        var get_rssscheduled = function(schedule_url) {
            $(".deleteall").hide();
            $(".refresh_timeslots").hide();
            $(".shuffle").hide();
            var page = $("#pages").val();
            if (page != "") {
                $("#sceduled").html("");
                // This line checks if div is Rss, Shopify or Youtube then will get the same data from database
                var activeDivId = $(".automation-socials.active").attr("id");
                var dataOBJ = {
                    'id': page,
                    'activedivid': activeDivId,
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + schedule_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        // $('#preloader_ajax').hide();
                        function splitData(data) {
                            if (typeof data === "string") {
                                return data.split(',');
                            } else if (Array.isArray(data)) {
                                return data;
                            } else {
                                return [];
                            }
                        }

                        var lastRunShopify = response.last_shopify_run;
                        // Last Run Shopify //
                        if (lastRunShopify === '' || lastRunShopify === null) {
                            $(".last-run-shopify-small").html('<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data');
                        } else {
                            $(".last-run-shopify-small").html('<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + lastRunShopify);
                        }
                        // End //

                        var originalContainer = document.querySelector(".to-be-cloned-container");
                        var retrievedData = response.rss_link;
                        // Check if retrievedData is not empty
                        if (retrievedData.length > 0) {
                            // Clear the existing cloned containers except the original one
                            var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
                            for (var i = 1; i < clonedContainers.length; i++) {
                                clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
                            }

                            // Set the value of the original input field and corresponding last run time
                            originalContainer.querySelector(".original-input").value = retrievedData[0].link;

                            if (retrievedData[0].last_run === '' || retrievedData[0].last_run === null) {
                                originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
                            } else {
                                originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[0].last_run;
                            }
                            // Clone and append additional input field containers for the remaining URLs and last run times
                            for (var i = 1; i < retrievedData.length; i++) {
                                var clone = originalContainer.cloneNode(true);
                                clone.querySelector(".original-input").value = retrievedData[i].link;
                                if (retrievedData[i].last_run === '' || retrievedData[i].last_run === null) {
                                    clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
                                } else {
                                    clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[i].last_run;
                                }
                                originalContainer.parentNode.insertBefore(clone, originalContainer.nextSibling);
                            }
                        }

                        // $("#loader").hide();

                        if (activeDivId == 'rss') {
                            $(".on_off").show();
                            $(".forshopify").hide();
                            $(".foryoutube").hide();
                        } else if (activeDivId == 'shopify') {
                            $(".on_off").hide();
                            $(".forshopify").show();
                            $(".foryoutube").hide();
                        } else if (activeDivId == 'youtube') {
                            $(".on_off").hide();
                            $(".forshopify").hide();
                            $(".foryoutube").show();
                        }
                        $(".fetch_ten_more").show();

                        if (response.rss_active === "1") {
                            $(".rssposting").prop("checked", true);
                        } else {
                            $(".rssposting").prop("checked", false);
                        }

                        if (response.auto_shuffle === "1") {
                            $(".autoshuffling").prop("checked", true);
                        } else {
                            $(".autoshuffling").prop("checked", false);
                        }

                        if (response.shopify_active === "1") {
                            $(".shopifyposting").prop("checked", true);
                        } else {
                            $(".shopifyposting").prop("checked", false);
                        }


                        if (response.time_slots) {
                            $('#timeslots').val($.parseJSON(response.time_slots)).trigger("chosen:updated");
                        } else {
                            $('#timeslots').val("").trigger("chosen:updated");
                        }
                        if (response.status) {
                            if (response.data) {
                                $('.info_tab').show();
                                $('.total_posts').html(response.count);
                                $('.scheduled_until').html(response.scheduled_until);
                                $(".deleteall").show();
                                $(".refresh_timeslots").show();
                                $(".shuffle").show();
                            }
                            $.each(response.data, function(index, elem) {
                                var icon = "mdi mdi-calendar-clock text-info mdi-24px"
                                var error = "";
                                if (elem.posted == -1) {
                                    if (elem.error) {
                                        icon = "mdi mdi-alert-circle-outline text-danger mdi-24px";
                                        error = '<div class="alert alert-danger">' + elem.error + '</div>';
                                    } else {
                                        icon = "mdi mdi-check-circle-outline text-success mdi-24px";
                                    }
                                }
                                // oncl = "window.open('"+elem.url+",_blank')";
                                oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
                                var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
                                node += '<div class="card blog-widget">'
                                node += '<div class="card-body">'
                                node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
                                node += '<p><strong style="cursor:pointer;" title="' + elem.title + '">' + elem.title.slice(0, 22) + '...</strong></p>';
                                node += '<a href="' + elem.url + '" target="_blank"><p><strong title="' + elem.url + '">' + elem.url.slice(0, 25) + '...</strong></p></a>';
                                if (error) {
                                    node += '<p class="my-0">' + error + '</p>'
                                }
                                node += '<div class="d-flex align-items-center" style="border-top: 1px solid #e6dbdb; padding-top: 5px;">'
                                node += '<div class="read"><p class="my-2""><strong> <i class="mdi mdi-calendar-clock text-info mdi-24px"></i>' + elem.post_date + '</strong></p></div>'
                                node += '</div>'
                                node += '<div class="d-flex float-right">'
                                node += '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success" id="publish_now" data-id="' + elem.id + '"  data-toggle="tooltip" title="Publish this post!">Publish</a>'
                                node += '<a href="javascript:void(0);" class="h5 cursor-pointer delbulkone btn btn-sm btn-outline-danger" data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
                                node += '</div>'
                                node += '</div>'
                                node += '</div>'
                                node += '</div>';
                                $("#sceduled").append(node);
                            });
                            if (response.data) {
                                // load more button
                                var load_more = "<div class='col-12 d-flex justify-content-center'>";
                                load_more += "<button class='btn btn-outline-info load_more d-none'>Load More</button>";
                                load_more += "</div>";
                                $("#sceduled").append(load_more);
                            }
                        }
                    },
                    error: function() {
                        $("#sceduled").html("");
                        // $("#loader").hide();
                    }
                });
            } else {
                $('#timeslots').val("").trigger("chosen:updated");
                $("#sceduled").html("");
                // Set the 'rss_feed' input field to an empty value
                $('#rss_feed').val("");
                // Remove any additional cloned containers
                var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
                for (var i = 1; i < clonedContainers.length; i++) {
                    clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
                }
            }
        };
        // rss posting
        $(".rssposting").click(function() {
            var selected_type = $('#pages').find('option:selected').data('type');
            if (selected_type == 'pinterest') {
                rss_feed_on_off_url = 'pinterest_rss_feed_onoff';
            } else if (selected_type == 'facebook') {
                rss_feed_on_off_url = 'rssfeedonoff';
            } else if (selected_type == 'fb_group') {
                rss_feed_on_off_url = 'fb_group_rss_feed_onoff'
            } else if (selected_type == 'instagram') {
                rss_feed_on_off_url = 'ig_rss_feed_onoff';
            } else if (selected_type == 'tiktok') {
                rss_feed_on_off_url = 'tiktok_rss_feed_onoff';
            }
            rss_feed_on_off(rss_feed_on_off_url);
        });
        var rss_feed_on_off = function() {
            var page = $("#pages").val();
            if (page != "") {
                $("#loader").show();
                var status = "0";
                if ($(".rssposting").is(":checked")) {
                    status = "1";
                }
                var dataOBJ = {
                    'page': page,
                    'rss_active': status
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + rss_feed_on_off_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $("#loader").hide();
                        swal({
                            title: "Success!",
                            text: "Rss has been changed successfully!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function() {}
                });
            }
        };
        // auto shuffling
        $(".autoshuffling").click(function() {
            var selected_type = $('#pages').find('option:selected').data('type');
            auto_shuffle_on_off = "rss_auto_shufflling_toggle";
            auto_shuffle_toggle(auto_shuffle_on_off, selected_type);
        });

        function auto_shuffle_toggle(auto_shuffle_on_off, type) {
            var page = $("#pages").val();
            if (page != "") {
                $("#loader").show();
                var status = "0";
                if ($(".autoshuffling").is(":checked")) {
                    status = "1";
                }
                var dataOBJ = {
                    'page': page,
                    'auto_shuffle': status,
                    'type': type
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + auto_shuffle_on_off,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $("#loader").hide();
                        swal({
                            title: "Success!",
                            text: "Auto Shuffle has been changed successfully!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function() {}
                });
            }
        };

        $(".shopifyposting").click(function() {
            var selected_type = $('#pages').find('option:selected').data('type');
            if (selected_type == 'pinterest') {
                shopify_automation_on_off_url = 'shopify_pinterest_automation_onoff';
            } else if (selected_type == 'facebook') {
                shopify_automation_on_off_url = 'shopify_fb_page_automation_onoff';
            } else if (selected_type == 'fb_group') {
                shopify_automation_on_off_url = 'shopify_fb_group_automation_onoff'
            } else {
                shopify_automation_on_off_url = 'shopify_insta_automation_onoff';
            }
            shopify_automation_on_off(shopify_automation_on_off_url);
        });
        var shopify_automation_on_off = function() {
            var page = $("#pages").val();
            if (page != "") {
                $("#loader").show();
                var status = "0";
                if ($(".shopifyposting").is(":checked")) {
                    status = "1";
                }
                var dataOBJ = {
                    'page': page,
                    'shopify_active': status
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + shopify_automation_on_off_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $("#loader").hide();
                        swal({
                            title: "Success!",
                            text: "Shopify Automation has been changed successfully!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function() {}
                });
            }
        };


        $(document).on("click", ".shopify-disconnect-button", function() {
            swal({
                title: "Disconnect Shopify Account!",
                html: true, // Enable HTML in the text
                text: "Are you sure you want to disconnect <strong>Shopify</strong><br>All your scheduled <strong>products</strong> will be deleted too.?",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#1e88e5",
                confirmButtonText: "Yes, Disconnect!",
                closeOnConfirm: true // Automatically close on confirm
            }, function(confirmed) {
                if (confirmed) {
                    disconnect_shopify_account();
                }
            });
        });
        var disconnect_shopify_account = function() {
            var user_id = "<?php echo $user[0]->id; ?>";
            $("#preloader_ajax").show();
            $("#loader").show();
            var dataOBJ = {
                'user_id': user_id
            };
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + "disconnect_shopify_account",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    // Handle success, e.g., display a success message
                    $("#preloader_ajax").hide();
                    $("#loader").hide();
                    swal({
                        title: "Success!",
                        text: "Your Shopify Account is Disconnected!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    window.location.reload();
                },
                error: function(response) {
                    // Handle errors if the AJAX request fails
                    $("#preloader_ajax").hide();
                    $("#loader").hide();
                    var response = JSON.parse(response.responseText);
                    var message = response.message;
                    var status = response.status;
                    var page_trigger = response.page_trigger;
                    if (page_trigger) {
                        $('#pages').trigger('change');
                    }
                    swal({
                        title: "Error!",
                        text: message,
                        // text: "You need to store this link first |or| You can not fetch empty link posts",
                        type: "error",
                        showConfirmButton: false,
                        timer: 4000
                    });
                }
            });
        };

        // load more button
        var loading = false;
        $(document).on('click', '.load_more', function() {
            if (loading) {
                return;
            }
            loading = true;
            var page_id = $("#pages").val();
            var selected_type = $('#pages').find('option:selected').data('type');
            var activeDivId = $(".automation-socials.active").attr("id");
            offset += limit;
            load_more_posts(page_id, selected_type, activeDivId);
        });

        var load_more_posts = function(page_id, selected_type, activeDivId) {
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + "loadmoreposts",
                data: {
                    'page_id': page_id,
                    'type': selected_type,
                    'activeDivId': activeDivId,
                    'offset': offset,
                    'limit': limit,
                },
                success: function(response) {
                    $('.load_more').remove();
                    if (response.count > 0) {
                        $.each(response.data, function(index, elem) {
                            var icon = "mdi mdi-calendar-clock text-info mdi-24px"
                            var error = "";
                            if (elem.posted == -1) {
                                if (elem.error) {
                                    icon = "mdi mdi-alert-circle-outline text-danger mdi-24px";
                                    error = '<div class="alert alert-danger">' + elem.error + '</div>';
                                } else {
                                    icon = "mdi mdi-check-circle-outline text-success mdi-24px";
                                }
                            }
                            oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
                            var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
                            node += '<div class="card blog-widget">'
                            node += '<div class="card-body">'
                            node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
                            node += '<p><strong style="cursor:pointer;" title="' + elem.title + '">' + elem.title.slice(0, 22) + '...</strong></p>';
                            node += '<a href="' + elem.url + '" target="_blank"><p><strong title="' + elem.url + '">' + elem.url.slice(0, 25) + '...</strong></p></a>';
                            if (error) {
                                node += '<p class="my-0">' + error + '</p>'
                            }
                            node += '<div class="d-flex align-items-center" style="border-top: 1px solid #e6dbdb; padding-top: 5px;">'
                            node += '<div class="read"><p class="my-2""><strong> <i class="mdi mdi-calendar-clock text-info mdi-24px"></i>' + elem.post_date + '</strong></p></div>'
                            node += '</div>'
                            node += '<div class="d-flex float-right">'
                            node += '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success" id="publish_now" data-id="' + elem.id + '"  data-toggle="tooltip" title="Publish this post!">Publish</a>'
                            node += '<a href="javascript:void(0);" class="h5 cursor-pointer delbulkone btn btn-sm btn-outline-danger" data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
                            node += '</div>'
                            node += '</div>'
                            node += '</div>'
                            node += '</div>';
                            $("#sceduled").append(node);
                        });
                        if (response.count == 20) {
                            // load more button
                            var load_more = "<div class='col-12 d-flex justify-content-center'>";
                            load_more += "<button class='btn btn-outline-info load_more d-none'>Load More</button>";
                            load_more += "</div>";
                            $("#sceduled").append(load_more);
                        }
                        loading = false;
                    }
                }
            });
        }
        // Shopify getting products 
        $(document).on("click", ".shopify-rss-button", function() {
            // Find the input field with the class "original-input" within the closest ancestor element with the class "to-be-cloned-container"
            // var inputField = $(this).closest('.to-be-cloned-container').find('.original-input');

            // Get the URL value from the input field
            // var rss_link_to_fetch_posts = inputField.val();

            // Determine the value of the "selected_type" based on the selected option in an element with the ID "pages"
            var selected_type = $('#pages').find('option:selected').data('type');
            var selected_name = $('#pages').find('option:selected').data('name');
            var rss_feed_engine_url;

            // Set the "rss_feed_engine_url" based on the "selected_type"
            if (selected_type == 'pinterest') {
                rss_feed_engine_url = 'pinterest_rss_feed_engine';
            } else if (selected_type == 'facebook') {
                rss_feed_engine_url = 'rss_feed_engine';
            } else if (selected_type == 'fb_group') {
                rss_feed_engine_url = 'fb_group_rss_feed_engine';
            } else {
                rss_feed_engine_url = 'ig_rss_feed_engine';
            }

            // Change the class of the closest ancestor element to 'begone'
            // var currentConatiner = $(this).closest('.to-be-cloned-container');

            // Show a confirmation dialog using the "swal" library
            swal({
                title: "Fetch Shopify store Products!",
                html: true, // Enable HTML in the text
                text: "Are you sure you want to fetch shopify products for<br><strong>" + selected_name + "</strong>?",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#1e88e5",
                confirmButtonText: "Yes, Fetch!",
                closeOnConfirm: true // Automatically close on confirm
            }, function(confirmed) {
                // Check if the user confirmed the delete operation
                if (confirmed) {
                    fetch_shopify_products(rss_feed_engine_url, selected_name);
                }
            });
        });

        // Define the "delete_rss" function
        var fetch_shopify_products = function(rss_feed_engine_url, selected_name) {
            // Perform the delete operation using an AJAX request
            var page = $("#pages").val();
            var time_slots = $(".chosen-select").val();
            var publisher = $("#loggeduserid").val();

            $("#preloader_ajax").show();
            $("#loader").show();

            var dataOBJ = {
                'publisher': publisher,
                'timeslots': time_slots,
                'page': page,
                'if_shopify_fetch': 'yes'
            };

            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    // Handle success, e.g., display a success message
                    $("#preloader_ajax").hide();
                    $("#loader").hide();
                    $('#pages').trigger('change');

                    if (response.produplicate == true) {
                        swal({
                            title: "No New Product!",
                            text: "Attension! There are no New Products to fetch right now for " + selected_name + "!",
                            type: "info",
                            showConfirmButton: false,
                            timer: 2500
                        });
                    } else {
                        swal({
                            title: "Success!",
                            text: "Products has been fetched for " + selected_name + "!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function() {
                    $("#preloader_ajax").hide();
                    $("#loader").hide();
                    // var response = JSON.parse(response.responseText);
                    // var message = response.message;
                    // var status = response.status;
                    swal({
                        title: "Error!",
                        text: "Either your Credentails are wrong or Something Bad Happen",
                        type: "error",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    /*setTimeout(function() {
                    	  window.location.reload();
                      }, 4000);*/
                }
            });
        };
        //  Shopify End

        // Sitemap for getting 10 more posts code start
        $(document).on("click", ".fetch_ten_more", function() {
            // Find the input field with the class "original-input" within the closest ancestor element with the class "to-be-cloned-container"
            // var inputField = $(this).closest('.to-be-cloned-container').find('.original-input');

            // Find the input field with the class "to-be-cloned-input" within the closest ancestor element with the class "to-be-cloned-container"
            var inputField = $(this).closest('.to-be-cloned-container').find('.to-be-cloned-input');

            // Get the URL value from the input field
            var rss_link_to_fetch_posts = inputField.val();

            // Determine the value of the "selected_type" based on the selected option in an element with the ID "pages"
            var selected_type = $('#pages').find('option:selected').data('type');
            var rss_feed_engine_url;

            // Set the "rss_feed_engine_url" based on the "selected_type"
            if (selected_type == 'pinterest') {
                rss_feed_engine_url = 'pinterest_rss_feed_engine';
            } else if (selected_type == 'facebook') {
                rss_feed_engine_url = 'rss_feed_engine';
            } else if (selected_type == 'fb_group') {
                rss_feed_engine_url = 'fb_group_rss_feed_engine';
            } else if (selected_type == 'instagram') {
                rss_feed_engine_url = 'ig_rss_feed_engine';
            } else if (selected_type == 'tiktok') {
                rss_feed_engine_url = 'tiktok_rss_feed_engine';
            }

            // Change the class of the closest ancestor element to 'begone'
            var currentConatiner = $(this).closest('.to-be-cloned-container');

            // Show a confirmation dialog using the "swal" library
            swal({
                title: "Fetch more posts!",
                html: true, // Enable HTML in the text
                // text: "<strong>" + rss_link_to_fetch_posts + "</strong><br>Are you sure you want to fetch 20 more posts for this link?",
                text: rss_link_to_fetch_posts + "<br>Are you sure you want to fetch more posts for this link?",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#1e88e5",
                confirmButtonText: "Yes, Fetch!",
                closeOnConfirm: true // Automatically close on confirm
            }, function(confirmed) {
                // Check if the user confirmed the delete operation
                if (confirmed) {
                    fetch_ten_posts(rss_feed_engine_url, rss_link_to_fetch_posts, currentConatiner);
                }
            });
        });

        // Define the "delete_rss" function
        var fetch_ten_posts = function(rss_feed_engine_url, rss_link_to_fetch_posts, currentConatiner) {
            // Perform the delete operation using an AJAX request
            var page = $("#pages").val();
            var time_slots = $(".chosen-select").val();
            var rss_url = $("#rss_feed").val();
            var publisher = $("#loggeduserid").val();
            $("#preloader_ajax").show();
            $("#loader").show();
            var dataOBJ = {
                'sitemap_rss_link': rss_link_to_fetch_posts,
                'publisher': publisher,
                'timeslots': time_slots,
                'page': page,
                'if_rss_fetch': 'yes'
            };
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    // Handle success, e.g., display a success message
                    $("#preloader_ajax").hide();
                    $("#loader").hide();
                    $('#pages').trigger('change');
                    if (response.status) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('.fetch_ten_more').attr('disabled', true);
                        setTimeout(function() { //calls click event after a certain time
                            console.log('1');
                            $('#pages').trigger('change');
                        }, 3000);
                    } else {
                        alertbox('Error', response.message, 'error');
                    }
                },
                error: function(response) {
                    // Handle errors if the AJAX request fails
                    $("#preloader_ajax").hide();
                    $("#loader").hide();
                    var response = JSON.parse(response.responseText);
                    var message = response.message;
                    var status = response.status;
                    var page_trigger = response.page_trigger;
                    if (page_trigger) {
                        $('#pages').trigger('change');
                    }
                    swal({
                        title: "Error!",
                        text: message,
                        // text: "You need to store this link first |or| You can not fetch empty link posts",
                        type: "error",
                        showConfirmButton: false,
                        timer: 4000
                    });
                    currentConatiner.find('.original-input').val('');
                }
            });
        };
        // Sitemap for getting 10 posts code end

        $(document).on("click", ".delete_rss", function() {
            // Find the input field with the class "original-input" within the closest ancestor element with the class "to-be-cloned-container"
            var inputField = $(this).closest('.to-be-cloned-container').find('.original-input');

            // Get the URL value from the input field
            var rss_link_to_delete = inputField.val();

            // Determine the value of the "selected_type" based on the selected option in an element with the ID "pages"
            var selected_type = $('#pages').find('option:selected').data('type');
            var rss_feed_engine_url;

            // Set the "rss_feed_engine_url" based on the "selected_type"
            if (selected_type == 'pinterest') {
                rss_feed_engine_url = 'pinterest_rss_feed_engine';
            } else if (selected_type == 'facebook') {
                rss_feed_engine_url = 'rss_feed_engine';
            } else if (selected_type == 'fb_group') {
                rss_feed_engine_url = 'fb_group_rss_feed_engine';
            } else if (selected_type == 'instagram') {
                rss_feed_engine_url = 'ig_rss_feed_engine';
            } else if (selected_type == 'tiktok') {
                rss_feed_engine_url = 'tiktok_rss_feed_engine';
            }

            // Change the class of the closest ancestor element to 'begone'
            var containerToRemove = $(this).closest('.to-be-cloned-container');
            var containersLeft = $('.to-be-cloned-container').length;
            var OriginalcontainersLength = $('.to-be-cloned-container').find('.original-input').length;

            // Show a confirmation dialog using the "swal" library
            swal({
                title: "Delete this RSS link?",
                html: true, // Enable HTML in the text
                text: "<strong>" + rss_link_to_delete + "</strong><br>Are you sure you want to delete the RSS link for this page?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                closeOnConfirm: true // Automatically close on confirm
            }, function(confirmed) {
                // Check if the user confirmed the delete operation
                if (confirmed) {
                    delete_rss(rss_feed_engine_url, rss_link_to_delete, containerToRemove, containersLeft, OriginalcontainersLength);
                }
            });
        });

        // Define the "delete_rss" function
        var delete_rss = function(rss_feed_engine_url, rss_link_to_delete, containerToRemove, containersLeft, OriginalcontainersLength) {
            // Perform the delete operation using an AJAX request
            var page = $("#pages").val();
            var time_slots = $(".chosen-select").val();
            var rss_url = $("#rss_feed").val();
            var publisher = $("#loggeduserid").val();

            var dataOBJ = {
                'rss_link': rss_link_to_delete,
                'publisher': publisher,
                'timeslots': time_slots,
                'page': page,
                'if_rss_delete': 'yes'
            };

            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    // Handle success, e.g., display a success message
                    if (containersLeft > 1) {
                        if (OriginalcontainersLength > 1) {
                            containerToRemove.remove();
                        } else {
                            containerToRemove.find('.original-input').val('');
                            containerToRemove.find('.original-input').prop('disabled', false);
                        }
                        // If more than one container, remove it
                    } else {
                        // If only one container left, clear the input value
                        containerToRemove.find('.original-input').val('');
                        containerToRemove.find('.original-input').prop('disabled', false);
                    }
                    swal({
                        title: "Success!",
                        text: "Rss has been deleted from your page!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function() {
                    // Handle errors if the AJAX request fails
                    swal({
                        title: "Error!",
                        text: "You need to store this link first |or| You can not delete empty input",
                        type: "error",
                        showConfirmButton: false,
                        timer: 3500
                    });
                    containerToRemove.find('.original-input').val('');
                }
            });
        };

        $(document).ready(function() {
            // $("#submit_rss").click(function() {
            $(document).on("click", "#submit_rss", function() {
                var rss_urls = [];
                // Iterate over the cloned input fields and push their values to the array
                $(".to-be-cloned-input").each(function() {
                    var cloned_rss_url = $(this).val();
                    rss_urls.push(cloned_rss_url);
                });
                var selected_type = $('#pages').find('option:selected').data('type');
                if (selected_type == 'pinterest') {
                    rss_feed_engine_url = 'pinterest_rss_feed_engine';
                } else if (selected_type == 'facebook') {
                    rss_feed_engine_url = 'rss_feed_engine';
                } else if (selected_type == 'fb_group') {
                    rss_feed_engine_url = 'fb_group_rss_feed_engine';
                } else if (selected_type == 'instagram') {
                    rss_feed_engine_url = 'ig_rss_feed_engine'
                } else if (selected_type == 'tiktok') {
                    rss_feed_engine_url = 'tiktok_rss_feed_engine';
                }
                submit_rss(rss_feed_engine_url, rss_urls);
            });
        });
        var submit_rss = function(rss_feed_engine_url, rss_urls) {
            var chosen = $(".chosen-select").val().length;
            var page = $("#pages").val();
            var time_slots = $(".chosen-select").val();
            var rss_url = $("#rss_feed").val();
            var publisher = $("#loggeduserid").val();
            if (page == "") {
                alertbox("Error", "Please Select Page first , and try again", "error");
                return false;
            }
            if (time_slots == "") {
                alertbox("Error", "Please Select Time Slots first , and try again", "error");
                return false;
            }
            /*if (rss_urls === ",") {
            	alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
            	return false;
            }*/
            if (rss_urls.length === 1 && rss_url === "") {
                alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
                return false;
            }
            // if (rss_url == "") {
            // 	alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
            // 	return false;
            // }
            if (page != "" && time_slots != "") {
                if (rss_url != "") {
                    $("#preloader_ajax").show();
                    // $("#submit_rss").attr("disabled", true);
                    $("#loader").show();
                    var dataOBJ = {
                        'rss_link': rss_urls,
                        'publisher': publisher,
                        'timeslots': time_slots,
                        'page': page
                    }
                    $.ajax({
                        type: "POST",
                        url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response) {
                            $("#preloader_ajax").hide();
                            $("#loader").hide();
                            $("#submit_rss").attr("disabled", false);

                            var message = response.message;
                            // if (response.strong) {
                            //     message = '<b>' + message + '</b>';
                            // }

                            if (response.status) {
                                $('#pages').trigger('change');
                                swal({
                                    title: "Success!",
                                    text: message,
                                    type: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: '#28a745',
                                    timer: 2500
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: message,
                                    type: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: '#f27474',
                                    timer: 4000
                                });
                            }
                        },
                        error: function(response) {
                            console.log(response.status);
                            console.log(response.statusText); // Log the status text for more details
                            console.log(response.responseText);
                            var response = JSON.parse(response.responseText);
                            var message = response.message;
                            var status = response.status;
                            var is_alert = response.is_alert;

                            /*if (response.strong) {
                            	$('#pages').trigger('change');
                            }*/
                            // console.log(status);
                            $("#preloader_ajax").hide();
                            $("#loader").hide();
                            $('#pages').trigger('change');
                            if (status == true) {
                                swal({
                                    title: "Success!",
                                    text: message,
                                    type: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: '#28a745',
                                    timer: 2500
                                });
                            } else if (status == false && is_alert == false) {
                                swal({
                                    title: "Error!",
                                    text: message,
                                    type: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: '#f27474',
                                    timer: 4000
                                });
                            } else if (status == false && is_alert == true) {
                                swal({
                                    title: "Alert!",
                                    text: message,
                                    type: "warning",
                                    showConfirmButton: true,
                                    confirmButtonColor: '#f8c486',
                                    timer: 4000
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: "Your provided link has not valid RSS feed |or| Something went wrong",
                                    type: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: '#f27474',
                                    timer: 4000
                                });
                            }
                        }
                    });
                } else {
                    alertbox("Error", "First Input Field can not be empty", "error");
                }
            }
        };
        $(".chosen-select").change(function() {
            var selected_type = $('#pages').find('option:selected').data('type');
            if (selected_type == 'pinterest') {
                update_timeslots_url = 'update_board_timeslots_rss';
            } else if (selected_type == 'facebook') {
                update_timeslots_url = 'update_page_timeslots_rss';
            } else if (selected_type == 'fb_group') {
                update_timeslots_url = 'update_fb_group_timeslots_rss'
            } else if (selected_type == 'instagram') {
                update_timeslots_url = 'update_ig_timeslots_rss'
            } else if (selected_type == 'tiktok') {
                update_timeslots_url = 'update_tiktok_timeslots_rss'
            }
            update_timeslots_rss(update_timeslots_url);
        });
        var update_timeslots_rss = function(update_timeslots_url) {
            $('#preloader_ajax').show();
            var chosen = $(".chosen-select").val().length;
            var page = $("#pages").val();
            var time_slots = $(".chosen-select").val();
            if (page != "") {
                var dataOBJ = {
                    'time_slots': time_slots,
                    'page': page
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + update_timeslots_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $('#preloader_ajax').hide();
                        $('#pages').trigger('change');
                    },
                    error: function() {}
                });
            }
        };
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });


        $(".deleteall").click(function() {
            var error = $(this).data('error');
            var selected_type = $('#pages').find('option:selected').data('type');
            // console.log(type);
            if (selected_type == 'pinterest') {
                delete_rss_all_url = 'delete_pinterest_rss_post_all';
            } else if (selected_type == 'facebook') {
                delete_rss_all_url = 'deletersspostall';
            } else if (selected_type == 'fb_group') {
                delete_rss_all_url = 'delete_fb_group_rss_post_all';
            } else if (selected_type == 'instagram') {
                delete_rss_all_url = 'delete_ig_rss_post_all';
            } else if (selected_type == 'tiktok') {
                delete_rss_all_url = 'delete_tiktok_rss_post_all';
            }
            delete_all(delete_rss_all_url, error);
        });
        var delete_all = function(delete_rss_all_url, error) {

            var page = $("#pages").val();
            var activeDivId = $(".automation-socials.active").attr("id");
            if (activeDivId == 'rss') {
                var maintitle = 'Delete ALL Posts???';
                var maintext = 'You will not be able to recover these posts again!';
                var deletetype = 'rss';
            } else if (activeDivId == 'shopify') {
                var maintitle = 'Delete ALL Products???';
                var maintext = 'You will not be able to recover these products again!';
                var deletetype = 'shopify';
            }

            swal({
                title: maintitle,
                text: maintext,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete ALL!",
                closeOnConfirm: false
            }, function() {
                $("#loader").show();
                var dataOBJ = {
                    'page': page,
                    'error': error,
                    'type': deletetype
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + delete_rss_all_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $(".deleteall").hide();
                        $(".refresh_timeslots").hide();
                        $(".shuffle").hide();
                        $("#loader").hide();
                        if (response.status) {
                            $('#pages').trigger('change');
                            if (error == 'all') {
                                if (deletetype == 'rss') {
                                    var text = "Your scheduled posts Removed Successfully!";
                                } else if (deletetype == 'shopify') {
                                    var text = "Your scheduled products Removed Successfully!";
                                }
                            } else {
                                if (deletetype == 'rss') {
                                    var text = "Your rejected posts Removed Successfully!";
                                } else if (deletetype == 'shopify') {
                                    var text = "Your rejected products Removed Successfully!";
                                }
                            }
                            swal({
                                title: "Deleted!",
                                text: text,
                                type: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        $("#loader").hide();
                        swal("Error", "Nothing Has been deleted, please try again", "error");
                    }
                });
            });
        };

        $(document).on('click', '.shuffle', function() {
            var selected_type = $('#pages').find('option:selected').data('type');
            if (selected_type == 'pinterest') {
                shuffle_rss_posts_url = 'shuffle_pinterest_rss_post_all';
            } else if (selected_type == 'facebook') {
                shuffle_rss_posts_url = 'shufflersspostall';
            } else if (selected_type == 'fb_group') {
                shuffle_rss_posts_url = 'shuffle_fb_group_rss_post_all'
            } else {
                shuffle_rss_posts_url = 'shuffle_ig_rss_post_all'
            }
            shuffle_rss_posts(shuffle_rss_posts_url);
        });

        $(document).on('click', '.refresh_timeslots', function() {
            refresh_rss_posts();
        });

        var refresh_rss_posts = function() {
            var chosen = $(".chosen-select").val().length;
            var page = $("#pages").val();
            var time_slots = $(".chosen-select").val();
            var selected_type = $('#pages').find('option:selected').data('type');
            swal({
                title: "Refresh all posts?",
                text: "Are you sure you want to refresh all posts!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Refresh All!",
                closeOnConfirm: false
            }, function() {
                $('#preloader_ajax').show();
                var dataOBJ = {
                    'page': page,
                    'timeslots': time_slots,
                    'selected_type': selected_type
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>refresh_rss_posts",
                    data: dataOBJ,
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
                                $('#pages').trigger('change');
                            }, 2500);
                        }
                    },
                    error: function() {
                        $('#preloader_ajax').hide();
                        swal("Error", "Nothing Has been changed, please try again", "error");
                    }
                });
            });
        }

        var shuffle_rss_posts = function(shuffle_rss_posts_url) {
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
                    url: "<?php echo SITEURL; ?>" + shuffle_rss_posts_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $("#loader").hide();
                        $('#pages').trigger('change');
                        if (response.status) {
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
        $(document).on('click', '.delbulkone', function() {
            var id = $(this).data('id');

            var selected_type = $('#pages').find('option:selected').data('type');
            if (selected_type == 'pinterest') {
                delete_rss_post_url = 'delete_pinterest_rss_post';
            } else if (selected_type == 'facebook') {
                delete_rss_post_url = 'deletersspost';
            } else if (selected_type == 'fb_group') {
                delete_rss_post_url = 'delete_fb_group_rss_post';
            } else {
                delete_rss_post_url = 'delete_ig_rss_post'
            }
            // $('#preloader_ajax').show();
            del_bulk_one(delete_rss_post_url, id);
        });
        var del_bulk_one = function(delete_rss_post_url, id) {
            row = $("#card_" + id);
            row.remove();
            var dataOBJ = {
                'id': id
            }
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + delete_rss_post_url,
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                    // $('#preloader_ajax').hide();
                    if (response.status) {
                        var icon = "mdi mdi-calendar-clock text-info mdi-24px"
                        var error = "";
                        var elem = response.data;
                        // if (elem.posted == 1) {
                        // 	if (elem.error) {
                        // 		icon = "mdi mdi-alert-circle-outline text-danger mdi-24px";
                        // 		error = '<div class="alert alert-danger">' + elem.error + '</div>';
                        // 	} else {
                        // 		icon = "mdi mdi-check-circle-outline text-success mdi-24px";
                        // 	}
                        // }
                        // oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
                        // var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
                        // node += '<div class="card blog-widget">'
                        // node += '<div class="card-body">'
                        // node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="min-height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
                        // node += '<p class="my-2" style="height:40px;overflow: hidden;" ><strong> <i class="' + icon + '"></i> ' + elem.post_date + '</strong></p>'
                        // node += '<p class="my-0">' + error + '</p>'
                        // node += '<div class="d-flex align-items-center">'
                        // node += '<div class="read"><a href="' + elem.url + '" target="_blank" class="link font-medium">Read More</a></div>'
                        // node += '<div class="ml-auto">'
                        // node += '<a href="javascript:void(0);" class="link h5  cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this image" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>'
                        // node += '</div>'
                        // node += '</div>'
                        // node += '</div>'
                        // node += '</div>'
                        // node += '</div>';
                        // $('#card_' + elem.id).remove();
                        // row.replaceWith(node);
                        // $('#pages').trigger('change');
                        alertbox('Success', 'Your scheduled post Removed Successfully!', 'success');
                    }
                },
                error: function() {
                    $('#preloader_ajax').hide();
                    alertbox('Error', 'Nothing Has been deleted, please try again', 'error');
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#publish_now', function() {
            var id = $(this).data('id');
            var selected_type = $('#pages').find('option:selected').data('type');
            var page_id = $('#pages').find('option:selected').val();
            if (selected_type == 'facebook') {
                var publish_url = 'publishNowFacebookPost';
            } else if (selected_type == 'pinterest') {
                var publish_url = 'publishNowPinterestPost';
            } else if (selected_type == 'instagram') {
                var publish_url = 'publishNowInstagramPost';
            }
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
                    publishNow(id, page_id, publish_url);
                }
            });
        });
        var publishNow = function(post_id, page_id, url) {
            $('#preloader_ajax').show();
            $.ajax({
                type: "POST",
                url: "<?php SITEURL ?>" + url,
                data: {
                    'id': post_id,
                    'page_id': page_id,
                },
                success: function(response) {
                    $('#preloader_ajax').hide();
                    if (response.status) {
                        row = $("#card_" + post_id);
                        row.remove();
                        alertbox('Success', response.data, 'success');
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
        $("#pages").on("change", function() {
            var selectedOption = $(this).find("option:selected");
            var selectedType = selectedOption.data("type");
            // Show the button if an option with data-type is selected
            if (selectedType) {
                $("#showButton").show();
                $("#shopifyRssButton").show();
            } else {
                $("#showButton").hide();
                $("#shopifyRssButton").hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var isCloning = false;
        // var allowedClones = (<?php echo $package_feature_user_quota - $package_feature_user_limit; ?>) - 1;
        var allowedClones = 1000;
        var allowedClonesInitial = allowedClones;

        $('#pages').change(function() {
            setTimeout(function() {
                var originalInputs = $('.original-input');
                if (originalInputs.length === 1 && originalInputs.val() === "") {
                    originalInputs.prop('disabled', false);
                    originalInputs.css({
                        'color': 'black',
                        'cursor': 'text',
                        'font-weight': '500'
                    });
                } else {
                    originalInputs.prop('disabled', true);
                    // Apply CSS rules to .original-input
                    originalInputs.css({
                        'color': 'black',
                        'cursor': 'text',
                        'font-weight': '800'
                    });
                }
            }, 500);
        });

        // Add a click event handler to elements with class "duplicate-button"
        // $(".duplicate-button").click(function() {
        $(document).on("click", ".duplicate-button", function() {
            if (isCloning || allowedClones <= 0) {
                alertbox("Error", 'You cannot make more RSS fields than your bulk upload limit = ' + (allowedClonesInitial + 1) + '. Now 0 remaining', "error");
                return;
            }

            isCloning = true;

            // Clone the div with class "to-be-cloned-container" and its contents
            var originalContainer = $(this).closest(".form-group.col-md-4").find(".to-be-cloned-container:last");
            var clonedContainer = originalContainer.clone();

            // Remove the "original-input" class from the cloned input field
            clonedContainer.find(".to-be-cloned-input").removeClass("original-input");
            clonedContainer.find(".to-be-cloned-input").removeAttr("disabled");

            clonedContainer.find("button.on_off").removeClass("fa-trash-o delete_rss");
            clonedContainer.find("button.on_off").addClass("fa-remove remove-clone");

            clonedContainer.find(".last-run-small").html('<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data');

            // Clear the input field in the cloned container
            var clonedInput = clonedContainer.find(".to-be-cloned-input");
            clonedInput.val("");

            // Display the element with class "delete_rss"
            clonedContainer.find(".delete_rss").css("display", "block");

            // Insert the cloned container below the original one
            originalContainer.after(clonedContainer);

            allowedClones--; // Decrease the remaining allowed clones
            isCloning = false;
        });

        // Add a click event handler to elements with class "delete_rss"
        $(document).on("click", ".remove-clone", function() {
            // Check if it's a cloned element (not the original)
            var isCloned = !$(this).closest(".to-be-cloned-container").find(".original-input").length;

            if (isCloned) {
                // Remove the relative clone
                var relativeClone = $(this).closest(".to-be-cloned-container");
                relativeClone.remove();
                // Increment the allowedClones count
                allowedClones++;
            }
        });
    });
</script>
<script>
    function showImage(imageUrl) {
        $('#popupImage').attr('src', imageUrl);
        $('#imagePopupOverlay').fadeIn();
    }

    function closeImagePopup() {
        $('#imagePopupOverlay').fadeOut();
    }
    $(document).ready(function() {
        $("#ShopifyCredentials").click(function(e) {
            // Prevent the default form submission behavior
            e.preventDefault();

            var apiKey = $("#apiKey").val();
            var apiSecretKey = $("#apiSecretKey").val();
            var adminApiAccessToken = $("#adminApiAccessToken").val();
            var storeName = $("#storeName").val();

            // Validate if any field is empty
            if (!apiKey || !apiSecretKey || !adminApiAccessToken || !storeName) {
                // Delay the alert to allow SweetAlert to display first
                swal({
                    title: "Empty Field!",
                    text: 'Please Fill all the fields first',
                    type: "warning",
                    showConfirmButton: false,
                    timer: 1500
                });
                return; // Prevent further execution if fields are empty
            }

            // AJAX request
            store_shopify_credntials = 'store_shopify_credntials';
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>" + store_shopify_credntials,
                data: {
                    apiKey: apiKey,
                    apiSecretKey: apiSecretKey,
                    adminApiAccessToken: adminApiAccessToken,
                    storeName: storeName
                },
                dataType: "json",
                success: function(response) {
                    swal({
                        title: "Account Connected!",
                        text: 'You Are All Set To Go',
                        type: "success",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    $('#staticBackdrop').modal('hide');
                    window.location.reload();
                },
                error: function(response) {
                    swal("Error", "Authentication failed. Please provide accurate information.", "error");
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var socials = document.querySelectorAll('.automation-socials');
        var socialActiveColor = document.querySelector('.social-active-color');

        var rssdiv = document.getElementById("step-3-rss");
        var shpoifydiv = document.getElementById("step-3-shopify");
        var youtubediv = document.getElementById("step-3-youtube");

        // Set default border color of .social-active-color
        if (socialActiveColor) {
            socialActiveColor.style.borderColor = '#f78422';
        }

        var shopify_adminApiAccessToken = "<?php echo $user[0]->shopify_adminApiAccessToken; ?>";
        // Attach click event to each social link
        socials.forEach(function(social) {
            social.addEventListener('click', function() {
                // Remove 'active' class from all elements
                socials.forEach(function(item) {
                    item.classList.remove('active');
                });
                // Add 'active' class to the clicked element
                this.classList.add('active');
                // Set border color of .social-active-color based on the clicked element
                if (this.id === 'rss') {
                    socialActiveColor.style.borderColor = '#f78422';
                    rssdiv.style.display = "block";
                    shpoifydiv.style.display = "none";
                    youtubediv.style.display = "none";

                    document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function(elem) {
                        elem.disabled = false;
                    });
                    document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function(elem) {
                        elem.disabled = false;
                    });
                    document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function(elem) {
                        elem.disabled = false;
                    });
                    $('#pages').trigger('change');
                } else if (this.id === 'shopify') {
                    socialActiveColor.style.borderColor = '#94be46';
                    rssdiv.style.display = "none";
                    shpoifydiv.style.display = "block";
                    youtubediv.style.display = "none";

                    // Check if shopify_adminApiAccessToken is empty
                    if (shopify_adminApiAccessToken === '') {
                        // If it's empty, disable Step 1 and Step 2
                        document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function(elem) {
                            elem.disabled = true;
                        });
                        document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function(elem) {
                            elem.disabled = true;
                        });
                        document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function(elem) {
                            elem.disabled = true;
                        });
                    } else {
                        document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function(elem) {
                            elem.disabled = false;
                        });
                        document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function(elem) {
                            elem.disabled = false;
                        });
                        document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function(elem) {
                            elem.disabled = false;
                        });
                        $('#pages').trigger('change');
                    }
                } else if (this.id === 'youtube') {
                    socialActiveColor.style.borderColor = '#ff0000';
                    rssdiv.style.display = "none";
                    shpoifydiv.style.display = "none";
                    youtubediv.style.display = "block";

                    document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function(elem) {
                        elem.disabled = true;
                    });
                    document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function(elem) {
                        elem.disabled = true;
                    });
                    document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function(elem) {
                        elem.disabled = true;
                    });
                    $('#pages').trigger('change');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#pages').trigger('change');
        $(document).on('mouseover', '.original-input', function() {
            $(this).attr('disabled', false);
        });
        $(document).on('mouseleave', '.original-input', function() {
            $(this).attr('disabled', true);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.rss_posts_tab_scheduled').on('click', function() {
            $(this).addClass('btn-info');
            $(this).removeClass('btn-secondary');
            $('.rss_posts_tab_published').addClass('btn-secondary');
            $('.rss_posts_tab_published').removeClass('btn-info');
            $('.deleteall, .shuffle, .refresh_timeslots').attr('disabled', false);
            $('#pages').trigger('change');
        });
        $('.rss_posts_tab_published').on('click', function() {
            $(this).addClass('btn-info');
            $(this).removeClass('btn-secondary');
            $('.rss_posts_tab_scheduled').addClass('btn-secondary');
            $('.rss_posts_tab_scheduled').removeClass('btn-info');
            $('.deleteall, .shuffle, .refresh_timeslots').attr('disabled', true);
            // get published rss posts
            var text = $('#pages').find('option:selected').text();
            var selected_type = $('#pages').find('option:selected').data('type');
            var schedule_url = '';
            if (selected_type == 'pinterest') {
                schedule_url = 'get_pinterest_rssspublished';
            } else if (selected_type == 'facebook') {
                schedule_url = 'getrssspublished';
            } else if (selected_type == 'fb_group') {
                schedule_url = 'get_fb_group_rssspublished';
            } else {
                schedule_url = 'get_ig_rssspublished';
            }
            getpublishedrss(schedule_url);
        });

        var getpublishedrss = function(schedule_url) {
            $(".deleteall").hide();
            $(".refresh_timeslots").hide();
            $(".shuffle").hide();
            var page = $("#pages").val();
            if (page != "") {
                // $('#preloader_ajax').show();
                // $("#loader").show();
                //$("#pagenamedisplay").html("| " + $(this).find("option:selected").text());
                $("#sceduled").html("");

                // This line checks if div is Rss, Shopify or Youtube then will get the same data from database
                var activeDivId = $(".automation-socials.active").attr("id");

                var dataOBJ = {
                    'id': page,
                    'activedivid': activeDivId
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>" + schedule_url,
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        // $('#preloader_ajax').hide();
                        function splitData(data) {
                            if (typeof data === "string") {
                                return data.split(',');
                            } else if (Array.isArray(data)) {
                                return data;
                            } else {
                                return [];
                            }
                        }

                        var lastRunShopify = response.last_shopify_run;
                        // Last Run Shopify //
                        if (lastRunShopify === '' || lastRunShopify === null) {
                            $(".last-run-shopify-small").html('<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data');
                        } else {
                            $(".last-run-shopify-small").html('<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + lastRunShopify);
                        }
                        // End //

                        var originalContainer = document.querySelector(".to-be-cloned-container");
                        var retrievedData = response.rss_link;
                        // Check if retrievedData is not empty
                        if (retrievedData.length > 0) {
                            // Clear the existing cloned containers except the original one
                            var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
                            for (var i = 1; i < clonedContainers.length; i++) {
                                clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
                            }

                            // Set the value of the original input field and corresponding last run time
                            originalContainer.querySelector(".original-input").value = retrievedData[0].link;

                            if (retrievedData[0].last_run === '' || retrievedData[0].last_run === null) {
                                originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
                            } else {
                                originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[0].last_run;
                            }
                            // Clone and append additional input field containers for the remaining URLs and last run times
                            for (var i = 1; i < retrievedData.length; i++) {
                                var clone = originalContainer.cloneNode(true);
                                clone.querySelector(".original-input").value = retrievedData[i].link;
                                if (retrievedData[i].last_run === '' || retrievedData[i].last_run === null) {
                                    clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
                                } else {
                                    clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[i].last_run;
                                }
                                originalContainer.parentNode.insertBefore(clone, originalContainer.nextSibling);
                            }
                        }

                        // $("#loader").hide();

                        if (activeDivId == 'rss') {
                            $(".on_off").show();
                            $(".forshopify").hide();
                            $(".foryoutube").hide();
                        } else if (activeDivId == 'shopify') {
                            $(".on_off").hide();
                            $(".forshopify").show();
                            $(".foryoutube").hide();
                        } else if (activeDivId == 'youtube') {
                            $(".on_off").hide();
                            $(".forshopify").hide();
                            $(".foryoutube").show();
                        }
                        $(".fetch_ten_more").show();

                        if (response.rss_active === "1") {
                            $(".rssposting").prop("checked", true);
                        } else {
                            $(".rssposting").prop("checked", false);
                        }
                        if (response.auto_shuffle === "1") {
                            $(".autoshuffling").prop("checked", true);
                        } else {
                            $(".autoshuffling").prop("checked", false);
                        }

                        if (response.shopify_active === "1") {
                            $(".shopifyposting").prop("checked", true);
                        } else {
                            $(".shopifyposting").prop("checked", false);
                        }


                        if (response.time_slots) {
                            $('#timeslots').val($.parseJSON(response.time_slots)).trigger("chosen:updated");
                        } else {
                            $('#timeslots').val("").trigger("chosen:updated");
                        }
                        if (response.status) {
                            if (response.data) {
                                $(".deleteall").show();
                                $(".refresh_timeslots").show();
                                $(".shuffle").show();
                            }
                            $.each(response.data, function(index, elem) {
                                var icon = "mdi mdi-calendar-clock text-info mdi-24px"
                                var error = "";
                                oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
                                var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
                                node += '<div class="card blog-widget">'
                                node += '<div class="card-body">'
                                node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
                                node += '<p><strong style="cursor:pointer;" title="' + elem.title + '">' + elem.title.slice(0, 22) + '...</strong></p>';
                                node += '<a href="' + elem.url + '" target="_blank"><p><strong title="' + elem.url + '">' + elem.url.slice(0, 25) + '...</strong></p></a>';
                                if (error) {
                                    node += '<p class="my-0">' + error + '</p>'
                                }
                                node += '<div class="d-flex align-items-center" style="border-top: 1px solid #e6dbdb; padding-top: 5px;">'
                                node += '<div class="read"><p class="my-2""><strong> <i class="mdi mdi-calendar-clock text-info mdi-24px"></i>' + elem.post_date + '</strong></p></div>'
                                node += '</div>'
                                node += '</div>'
                                node += '</div>'
                                node += '</div>';
                                $("#sceduled").append(node);
                            });
                        }
                    },
                    error: function() {
                        $("#sceduled").html("");
                        // $("#loader").hide();
                    }
                });
            } else {
                // $(".on_off").hide();
                // $(".fetch_ten_more").hide();
                $('#timeslots').val("").trigger("chosen:updated");
                $("#sceduled").html("");

                // Set the 'rss_feed' input field to an empty value
                $('#rss_feed').val("");

                // Remove any additional cloned containers
                var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
                for (var i = 1; i < clonedContainers.length; i++) {
                    clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
                }
            }
        };
        $(window).on('scroll load', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) { // Adjust threshold as needed
                $('.load_more').trigger('click');
            }
        });

    });

    function get_running_rss_status() {
        var type = $('#pages').find('option:selected').data('type');
        var page_id = $("#pages").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL . 'get_running_rss_status'; ?>",
            data: {
                'page_id': page_id,
                'type': type
            },
            success: function(response) {
                if (response.status) {
                    $('.fetch_ten_more').attr('disabled', false);
                } else {
                    $('.fetch_ten_more').attr('disabled', true);
                }
            }
        });
    }
    setInterval(function() {
        get_running_rss_status();
    }, 3000);
</script>