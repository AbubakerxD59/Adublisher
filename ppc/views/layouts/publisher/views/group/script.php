<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(function() {

        $("#event_day").change(function() {
            if ($(this).val() == "alldays") {
                $(".alldays").show();

            } else {
                $(".alldays").hide();

            }
        });

        $("#ue_event_day").change(function() {
            if ($(this).val() == "alldays") {
                $(".ue_alldays").show();

            } else {
                $(".ue_alldays").hide();

            }
        });

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

        var Current_File = 1;
        var myDropzone = new Dropzone("div#myDropZone", {
            url: "<?php echo SITEURL; ?>save_fb_bulkschedule",
            maxFiles: 450,
            paramName: "file",
            maxFilesize: 10,
            acceptedFiles: 'image/*',
            parallelUploads: 5,
            init: function() {
                this.on("addedfile", function(file) {

                    var page = $("#pages").val();
                    var chosen = $("#page_ts.chosen-select").val();

                });
                this.on("sending", function(file, xhr, data) {


                    data.append("totalfiles", this.getAcceptedFiles().length);
                    data.append("current_file", Current_File);
                    data.append("title", $("#title").val());
                    data.append("page", $("#pages").val());
                    data.append("event", $("#events").val());
                    data.append("timeslots", $("#page_ts.chosen-select").val());
                    data.append("etimeslots", $("#eventstimeslots.chosen-select").val());
                    data.append("event_day", $("#ue_event_day").val());

                    Current_File = Current_File + 1;
                });
                this.on("success", function(file, response) {

                    //image uploaded
                    if (response.status) {
                        /*var block = '<div class="col-lg-2 col-md-3" id="card_'+response.data.id+'">'+
                               '<div class="card">'+
                                   '<div class="el-card-item">'+
                                     '  <div class="el-card-avatar el-overlay-1" > <img src="assets/bulkuploads/'+response.data.link+'"  style="min-height:120px;" alt="image">'+
                                     '  </div>'+
                                      ' <div class="el-card-content">'+
                                        '<small>'+response.data.post_date +'</small>'+
                                        '   | <i class="fa fa-trash delbulkone text-danger pointer" data-id="'+response.data.id+'"></i>  </div>'+
                                 '  </div>'+
                              ' </div>'+
                           '</div>';*/
                        var block = create_block(response.data);
                        $("#sceduled").append(block);
                        $("#left").text(parseInt($("#left").text()) - 1);
                    } else {
                        myDropzone.removeAllFiles(true);
                        obj_error = JSON.parse(response);
                        alertbox("Error", obj_error.message, "error");

                    }

                });
            },
            accept: function(file, done) {

                var page = $("#pages").val();
                var chosen = $("#page_ts.chosen-select").val();

                if (page == "") {

                    done("Please First Select Page");

                } else if (chosen == null) {

                    done("Please First Select Time slots");
                } else {
                    $(".deleteall").show();
                    done();
                }
            }

        });

        setTimeout(() => {
            $(".sceduled_p").hide();
            $("#pages").trigger("change");
            setTimeout(() => {
                $(".sceduled_p").show();
                if ("<?php echo $event; ?>" != 0) {

                    $('#events').trigger('change');

                }
            }, 500);
        }, 500);
        $(".c_e").click(function() {
            $("#newevent").modal("show");
        });
        $("#c_e_form").on("submit", function(e) {

            var page = $("#pages").val();
            var chosen = $("#c_e_timeslots.chosen-select").val().length;
            var time_slots = $("#c_e_timeslots.chosen-select").val();
            var event_day = $("#event_day").val();
            if (page == "") {
                swal("Error", "Please Select Page", "error");
                return false;
            }
            if (chosen == 0) {
                swal("Error", "Please Select Time slots", "error");
                return false;
            }
            if (event_day == "alldays") {
                if ($("#c_e_startdate").val() == "") {
                    swal("Error", "Please Select Start date", "error");
                    return false;
                }
                if ($("#c_e_enddate").val() == "") {
                    swal("Error", "Please Select end date", "error");
                    return false;
                }
            }
            e.preventDefault();
            var form = document.getElementById('c_e_form');
            var form_data = new FormData(form);
            form_data.append("page_id", $("#pages").val());
            form_data.append("time_slots", time_slots);
            var repeating = "off";
            if ($("#c_e_repeating").is(':checked')) {
                repeating = "on";
            }

            var dataOBJ = {
                'page_id': $("#pages").val(),
                'time_slots': time_slots,
                'name': $("#c_e_name").val(),
                'start_date': $("#c_e_startdate").val(),
                'end_date': $("#c_e_enddate").val(),
                'event_day': $("#event_day").val(),
                'repeating': repeating
            }

            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>addnewevent",
                dataType: "json",
                data: dataOBJ,
                success: function(response) {
                    $("#loader").hide();
                    if (response.status == true) {

                        $('#events').append($('<option/>', {
                            value: response.id,
                            text: $("#c_e_name").val()
                        }));
                        var page_link = 'facebookbulkupload?page=' + $("#pages").val() + '&event=' + response.id;
                        $(".event_select").removeClass("btn-outline-success").removeClass("selected").addClass("btn-outline-secondary").removeClass("active");
                        $('#event_buttons').append(' <a href="<?php echo SITEURL; ?>' + page_link + '" class="btn mr-1 btn-outline-success pull-left active selected event_select mb-1 event_' + response.id + '" data-id="' + response.id + '" > <i class="fa fa-calendar"></i> ' + $("#c_e_name").val() + ' </a>');
                        $('#events').val(response.id).trigger('change');
                        $("#newevent").modal("hide");

                        alertbox("Success", response.message, "success");

                    } else {
                        alertbox("Error", response.message, "error");
                    }
                },
                error: function() {
                    $("#loader").hide();
                }
            });

        });
        //Update
        $("#u_e_form").on("submit", function(e) {

            var page = $("#pages").val();
            var chosen = $("#eventstimeslots.chosen-select").val().length;
            var time_slots = $("#eventstimeslots.chosen-select").val();
            var event_id = $("#events").val();
            var repeating = $("#repeating").val();
            var repeating = "off";
            var event_day = $("#ue_event_day").val();
            if ($("#repeating").is(':checked')) {
                repeating = "on";
            }

            if (event_id == 0) {
                swal("Error", "Please Select event to update", "error");
                return false;
            }
            if (page == "") {
                swal("Error", "Please Select Page", "error");
                return false;
            }
            if (chosen == 0) {
                swal("Error", "Please Select Time slots", "error");
                return false;
            }
            if (event_day == "alldays") {
                if ($("#eventstartdate").val() == "") {
                    swal("Error", "Please Select Start date", "error");
                    return false;
                }
                if ($("#eventenddate").val() == "") {
                    swal("Error", "Please Select end date", "error");
                    return false;
                }
            }
            e.preventDefault();
            var dataOBJ = {
                'id': $("#events").val(),
                'page_id': $("#pages").val(),
                'time_slots': time_slots,
                'name': $("#eventname").val(),
                'start_date': $("#eventstartdate").val(),
                'end_date': $("#eventenddate").val(),
                'event_day': $("#ue_event_day").val(),
                'repeating': repeating
            }
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>updateevent",
                dataType: "json",
                data: dataOBJ,
                success: function(response) {
                    $("#loader").hide();
                    if (response.status == true) {
                        alertbox("Success", response.message, "success");
                        //here add this event into the dropdown and select it. 
                    } else {
                        alertbox("Error", response.message, "error");
                    }
                },
                error: function() {
                    $("#loader").hide();
                }
            });

        });

        $(document).on("change", "#pages, #events", function() {
            $(".deleteall").hide();
            myDropzone.removeAllFiles(true);
            Current_File = 1;
            var action = $(this).data("action")
            var page = $("#pages").val();
            var event = $("#events").val();
            $(".dropzonewidget").hide();
            if (page != "") {
                //Here load sceduled posts into below are 
                $("#loader").show();
                $(".pagenamedisplay").html("| " + $(this).find("option:selected").text());
                $("#sceduled").html("");
                var dataOBJ = {
                    'id': page,
                    'event_id': event
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>gefacebooktbulkscheduled",
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $('#page_ts').val($.parseJSON(response.time_slots)).trigger("chosen:updated");
                        $('#title').val(response.caption);
                        var chosen = $("#page_ts.chosen-select").val().length;
                        if (chosen > 0) {
                            $(".dropzonewidget").fadeIn('slow');
                        }
                        if (response.status) {
                            if (response.data) {
                                $(".deleteall").show();
                            }
                            $.each(response.data, function(index, elem) {
                                tr = create_block(elem);
                                $("#sceduled").append(tr);
                            });
                            if (action == "page") {
                                $("#eventstimeslots.chosen-select").val("").trigger("chosen:updated");
                                $("#u_e_form").trigger("reset");
                                $('#event_buttons').html("");
                                if (response.events.length > 0) {

                                    $("#events").html("");

                                    $('#events').append($('<option/>', {
                                        value: 0,
                                        text: "Select event group(optional)"
                                    }));


                                    $.each(response.events, function(index, elem) {



                                        var page_link = 'facebookbulkupload?page=' + page + '&event=' + elem.id;
                                        if ("<?php echo $event; ?>" == elem.id) {
                                            $('#events').append($('<option/>', {
                                                value: elem.id,
                                                text: elem.name,
                                                selected: true
                                            }));
                                            $('#event_buttons').append(' <a href="<?php echo SITEURL; ?>' + page_link + '" class="btn mr-1 mb-1 btn-outline-success pull-left active selected event_select event_' + elem.id + '" data-id="' + elem.id + '" > <i class="fa fa-calendar"></i> ' + elem.name + ' </a>');
                                        } else {
                                            $('#events').append($('<option/>', {
                                                value: elem.id,
                                                text: elem.name
                                            }));
                                            $('#event_buttons').append(' <a href="<?php echo SITEURL; ?>' + page_link + '" class="btn mr-1 mb-1 btn-outline-secondary pull-left event_select event_' + elem.id + '" data-id="' + elem.id + '" > <i class="fa fa-calendar"></i> ' + elem.name + ' </a>');
                                        }


                                    });
                                } else {
                                    $("#events").html("");
                                    $('#events').append($('<option/>', {
                                        value: 0,
                                        text: "Nothing found, Try Create event"
                                    }));


                                }
                            } else {
                                $('#eventstimeslots').val("").trigger("chosen:updated");
                                $('#eventname').val("");
                                $('#eventstartdate').val("");
                                $('#eventenddate').val("");
                                $("#repeating").prop('checked', false);
                                $.each(response.events, function(index, elem) {

                                    if (event == elem.id) {
                                        $('#eventstimeslots').val($.parseJSON(elem.time_slots)).trigger("chosen:updated");
                                        $('#eventname').val(elem.name);
                                        $('#eventstartdate').val(elem.start_date);
                                        $('#eventenddate').val(elem.end_date);
                                        $('#ue_event_day').val(elem.event_day);
                                        if (elem.event_day == "alldays") {
                                            $(".ue_alldays").show();
                                        } else {
                                            $(".ue_alldays").hide();
                                        }
                                        if (elem.repeating == "on") {
                                            $("#repeating").prop('checked', true);
                                        } else {

                                            $("#repeating").prop('checked', false);
                                        }
                                    }

                                });
                            }

                        }


                        $("#loader").hide();
                    },
                    error: function() {
                        $("#sceduled").html("");
                        $("#loader").hide();
                        //swal("Opps", "Nothing found related to this page, please upload and try again" , "error");
                        //alertbox("Opps" , "Nothing found related to this page, please upload and try again" ,  "error")
                    }
                });
            }


        });
        $("#page_ts.chosen-select").change(function() {
            myDropzone.removeAllFiles(true);
            Current_File = 1;
            var chosen = $("#page_ts.chosen-select").val().length;
            var page = $("#pages").val();
            var time_slots = $("#page_ts.chosen-select").val();
            if (page != "") {

                var dataOBJ = {
                    'time_slots': time_slots,
                    'page': page
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>update_page_timeslots",
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $('#pages').trigger('change');
                    },
                    error: function() {}
                });

            }
            if ((page != "") && (chosen > 0)) {
                $(".dropzonewidget").fadeIn('slow');
            }
            if ((page == "") || (chosen == 0)) {
                $(".dropzonewidget").hide();
            }


        });

        $(document).on('click', '.event_select', function(e) {
            e.preventDefault();
            $(".event_select").removeClass("btn-outline-success").removeClass("selected").addClass("btn-outline-secondary").removeClass("active");
            $(this).addClass("btn-outline-success").addClass("selected").addClass("active");
            $('#events').val($(this).data("id")).trigger('change');
        });

        $("#caption").click(function() {

            var page = $("#pages").val();
            var caption = $("#title").val();
            var publisher = $("#loggeduserid").val();
            if (page == "") {
                alertbox("Error", "Please Select Page first , and try again", "error");
                return false;
            }
            /* if(caption == ""){
                 alertbox("Error", "Please Provide Caption first , and try again" , "error");
                 return false;
             }*/
            // if(page != "" && caption != ""){
            if (page != "") {

                $("#loader").show();
                var dataOBJ = {
                    'caption': caption,
                    'publisher': publisher,
                    'page': page
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>facebookpagecatption",
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        $("#loader").hide();
                        $('#pages').trigger('change');
                        swal({
                            title: "Success!",
                            text: response.message,
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function() {}
                });

            }
        });

        $(document).on('click', '.deleteevent', function() {
            // $(".deleteevent").hide();
            var event = $("#events").val();
            if (event == 0) {
                swal("Error", "Please Select event to delete", "error");
                return false;
            }
            swal({
                title: "Really want to delete event???",
                text: "You will not be able to recover its posts again!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete event!",
                closeOnConfirm: false
            }, function() {

                $("#loader").show();
                var dataOBJ = {
                    'id': event
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>disconnectfacebookevent",
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        myDropzone.removeAllFiles(true);
                        $(".deleteevent").show();
                        $("#loader").hide();
                        if (response.status) {
                            $("#left").text(parseInt($("#left").text()) + parseInt(response.total));
                            $("#sceduled").html("");
                            $("#events option[value=" + event + "]").remove();
                            $(".event_" + event).remove();
                            $('#events').val(0).trigger('change');
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
                        swal("Error", "Nothing Has been deleted, please try again", "error");
                    }
                });
            });
        })

        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });


        $(document).on('click', '.deleteall', function() {

            var page = $("#pages").val();
            var event = $("#events").val();
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
                var dataOBJ = {
                    'page': page,
                    'event_id': event
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>deletefacebookbulkpostall",
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        myDropzone.removeAllFiles(true);
                        $(".deleteall").hide();
                        $("#loader").hide();
                        if (response.status) {
                            $("#left").text(parseInt($("#left").text()) + parseInt(response.total));
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
                        // alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
                        swal("Error", "Nothing Has been deleted, please try again", "error");
                    }
                });


            });
        })
        $(document).on('click', '.delbulkone', function() {
            id = $(this).data('id');
            row = $("#card_" + id);
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this post again!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function() {
                var dataOBJ = {
                    'id': id
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>deletefacebookbulkpost",
                    data: dataOBJ,
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            $("#left").text(parseInt($("#left").text()) + 1);
                            row.remove();
                            swal({
                                title: "Deleted!",
                                text: "Your scheduled post Removed Successfully!",
                                type: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        // alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
                        swal("Error", "Nothing Has been deleted, please try again", "error");
                    }
                });


            });
        })

        function create_block(elem) {

            var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">';
            node += '<div class="card blog-widget">';
            node += '<div class="card-body">';
            node += '<div class="blog-image cursor-pointer"><a class="gallery" href="assets/bulkuploads/' + elem.link + '" title="' + elem.post_date + '"><img  style="height:250px;" loading="lazy" src="assets/bulkuploads/' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100" /></a></div>';
            // node += '<p class="my-2" style="height:80px;overflow: auto;" ><strong> <i class="mdi mdi-closed-caption"></i> ' + elem.title +'</strong></p>';
            node += '<p class="my-2" style="height:80px;overflow: auto;" ><strong class="d-flex align-items-center"> <i class="mdi mdi-closed-caption"></i><input type="text" value="' + elem.title + '" name="title" class="form-control mx-2 blog-title" disabled></strong></p>';
            node += '<div class="d-flex align-items-center" style=" border-top: 1px solid #e6dbdb; padding-top: 5px; ">';
            node += '<div class="read"><a href="#" class="link font-medium"> <i class="mdi mdi-calendar"></i> ' + elem.post_day + ' ' + elem.post_time + ' <br> &nbsp;&nbsp; &nbsp;&nbsp;' + elem.post_date + '</a></div>';
            node += '<div class="ml-auto">';
            node += '<a href="javascript:void(0);" class="link h5 cursor-pointer"><i class="mdi mdi-close close-update" style="display:none;"></i></a>';
            node += '<a href="javascript:void(0);" class="link h5 cursor-pointer"><i class="mdi mdi-check confirm-update" style="display:none;" id="' + elem.id + '"></i></a>';
            node += '<a href="javascript:void(0);" class="link h5 cursor-pointer" data-toggle="tooltip" title="Edit this imagek" data-original-title="Delete"><i class="mdi mdi-pencil blog-edit"></i></a>';
            node += '<a href="javascript:void(0);" class="link h5 cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this imagek" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>';
            node += '</div>';
            node += '</div>';
            node += '</div>';
            node += '</div>';
            node += '</div>';
            return node;

        }
    });

    $(document).on('click', '.blog-edit', function() {
        var parent_div = $(this).closest('.ml-auto');
        // show close and confirm button
        parent_div.find('.close-update').show();
        parent_div.find('.confirm-update').show();
        // hide edit icon
        $(this).hide();
        // make input field title enable
        $(this).closest('.card-body').find('.blog-title').prop('disabled', false);

    });

    $(document).on('click', '.close-update', function() {
        var parent_div = $(this).closest('.ml-auto');
        // show edit button
        parent_div.find('.blog-edit').show();
        // hide cloe and confirm edit button
        parent_div.find('.confirm-update').hide();
        $(this).hide();
        // make input field titel disabled
        $(this).closest('.card-body').find('.blog-title').prop('disabled', true);
    });

    $(document).on('click', '.confirm-update', function() {
        var confirm_btn = $(this);
        swal({
            title: "Update image caption?",
            text: "Are you sure you want to update this image caption!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, update it!",
            closeOnConfirm: true
        }, function() {
            $("#loader").show();
            var data = {
                "title": confirm_btn.closest('.card-body').find('.blog-title').val(),
                "id": confirm_btn.attr('id'),
                "event_id": $("#events").val()
            };
            $.ajax({
                url: "<?php echo SITEURL; ?>update_fb_bulkschedule",
                method: "POST",
                data: data,
                success: function(resp) {
                    $("#loader").hide();
                    if (resp.status) {
                        // show success dialog
                        var parent_div = confirm_btn.closest('.ml-auto');
                        // set value to input field and disable it
                        confirm_btn.closest('.card-body').find('.blog-title').prop('disabled', true);
                        // click cancel button to hide action buttons
                        parent_div.find('.close-update').trigger('click');
                        swal({
                            title: "Updated!",
                            text: "Image caption updated Successfully!",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        swal("Error", "Unable to update caption!", "error");
                    }
                }
            });
        });
    });
</script>