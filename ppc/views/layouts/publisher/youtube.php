<!-- Page wrapper  -->
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
<?php
date_default_timezone_set($user->gmt);
$utc_offset =  date('Z') / 3600;
if ($utc_offset > 0) {
  if ($utc_offset < 10) {
    $utc_offset = "UTC+0" . $utc_offset;
  } else {
    $utc_offset = "UTC+" . $utc_offset;
  }
} else {
  $utc_offset = "UTC-" . $utc_offset;
}
?>
<link href="<?= GeneralAssets ?>plugins/tablesaw-master/dist/tablesaw.css" rel="stylesheet" type="text/css">
<!--<link href="<?= GeneralAssets ?>plugins/time/css/timepicker.css" rel="stylesheet" type="text/css">-->
<link href="<?= GeneralAssets ?>plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<link href=" <?= GeneralAssets ?>plugins/jquery-datetime/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css">




<!-- ============================================================== -->
<div class="page-wrapper bg-white">
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <?php
        $upr  =  user_pr();
        $account = $upr['ptu']->active;
        ?>
        <div class="card simple-card">
          <div class="card-body">
            <!-- <h2 class="text-center mt-2 m-b-0">Facebook auto posting</h2>
            <p class="text-center text-muted">You can use the this service to schedule posts/campaigns to your facebook Pages.<br> This is a huge time saver if you like to post regular updates, media, and other things to Facebook.</p> -->

            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <?php
            echo @$upr['pxn'];
            echo loader();
            ?>
            <div class="row p-10 m-0">

              <?php
              if ($account == '1') {
                if ($registered == "not_registered") { ?>

                  <div class="col-md-12 text-center">
                    <div class="card simple-card">
                      <div class="card-body">
                        <div class="col-md-12 text-center">
                          <div class="alert alert-warning">
                            <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Facebook not connected </h3>
                            <p><br>Connecting and authorizing facebook pages is required, Click <a href="<?php echo $this->facebook->login_url(); ?>"> HERE </a> to connect right now. so Adublisher can publish posts you schedule/set.<br>
                              <b>Note - we will NEVER send anything to your friends or post anything that you haven't scheduled/set first!</b>
                            </p>
                            <p>Later you can disconnect this app, just like any other social media based app.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                } 
                else {
                    ?>
                      <div class="card earning-widget col-12">
                        <div class="card-body row m-b-0 m-t-10 ">
                          <div class="col-md-6 ">
                            <h6 class="card-subtitle pull-left m-r-20" style="">
                              <a href="<?php echo $google_login_url; ?>" class="btn btn-outline-secondary btn-sm"> <i class="fa fa-plus"></i> Add YouTube Channel </a>
                            </h6>
                          </div>
                          <div class="col-md-6 ">
                            <!-- <h6 class="text-muted pull-right m-r-20" style=""> Want to disconnect all channels ? &nbsp;<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#confirm-delete" data-id="<?php echo $user->id; ?>"><span class="fa fa-unlink"></span> click here </button></h6> -->
                          </div>
                        </div>
                        <?php 
                            if (count($youtube_channels) > 0) {
                        ?>
                            <div class="card-body b-t">
                            <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="columntoggle" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                                <thead>
                                <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="persist">Page</th>
                                    <th class="text-center" scope="col" data-tablesaw-priority="3">Status <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="You can turn Auto Posting ON/OFF, If you want to update [upcoming posts and Posts / day ] this value must be ON."></i></th>
                                    <!-- <th class="text-center" scope="col" data-tablesaw-priority="2">Posts <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Here you can view a list of upcoming posts on your page. Only pending posts are shown."></i> </th>
                                    <th class="text-center" scope="col" data-tablesaw-priority="1">Posting Domains <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Add specific domains to pages and autoposting will fetch posts from those domains only."></i></th> -->
                                    <th class="text-center" scope="col" data-tablesaw-priority="1">Posting Hours <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Here you can set number of posts per day, which will be posted on daily basis."></i></th>
                                    <th class="text-center" scope="col" data-tablesaw-priority="2">Actions <i class="mdi mdi-help-circle-outline" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="You can remove your page from adublisher anytime you want, this will not remove your page from facebook."></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($youtube_channels as $page) {
                                    $checked = "";
                                    if ($page->active) {
                                    $checked = "checked";
                                    $is_active = '';
                                    } else {
                                    $is_active = 'disabled="true"';
                                    }
                                ?>
                                    <tr class="">
                                    <td class="title"> <img style="width:60px;" src="<?= GeneralAssets ?>images/youtube_logo.png" class="rounded" alt="profile_pic"> <b><?php echo $page->channel_title; ?></b></td>
                                    <td class="text-center">
                                        <div class="switch">
                                        <label>OFF<input type="checkbox" <?= $checked; ?> class="autoposting" data-id="<?= $page->id ?>"><span class="lever switch-col-light-blue"></span>ON</label>
                                        </div>
                                    </td>
                                    <!-- <td class="text-center">
                                        <button class="btn btn-outline-secondary btn-sm browselist" <?= $is_active; ?> id="list_<?= $page->id ?>" data-name="<?= $page->page_name ?>" data-id="<?= $page->id ?>"><span class="mdi mdi-format-list-bulleted"></span> View List</button>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        // $clean =  json_decode($page->channel_slots, true);
                                        ?>
                                        <select id="domains_<?= $page->id ?>" multiple data-placeholder="Select domains to post..." data-pageid="<?= $page->id ?>" class="chosen-select chosen-domains form-control">
                                        <?php
                                        //   $selected_domains = [];
                                        //   $selected_domains   =  json_decode($page->domains_auto, true);
                                        //   foreach ($user_domains as $key => $domain) {

                                        //     if (in_array((string)$domain->id,  $selected_domains)) {
                                        ?>
                                            <option selected="selected" value="<?= $domain->id; ?>"><?= $domain->domain; ?></option>
                                            <?php
                                            // } else {
                                            ?>
                                            <option value="<?= $domain->id; ?>"><?= $domain->domain; ?></option>
                                        <?php
                                        //     }
                                        //   }

                                        ?>

                                        </select>
                                        <?php
                                        if ($page->auto_posting == "off") {
                                        ?>
                                        <script>
                                            $(document).ready(function() {
                                            $('#timeslots_' + <?= $page->id ?>).prop('disabled', true).trigger("chosen:updated");
                                            });
                                        </script>
                                        <?php
                                        }
                                        ?>
                                    </td> -->


                                    <td class="text-center">
                                        <?php
                                        $clean =  json_decode($page->channel_slots, true);
                                        ?>
                                        <select id="timeslots_<?= $page->id ?>" multiple data-placeholder="Select Hours to post..." data-pageid="<?= $page->id ?>" class="chosen-select chosen-timeslots form-control">
                                        <?php
                                        for ($i = 0; $i < 24; $i++) {
                                            if (in_array((string)$i, $clean)) {
                                        ?>
                                            <option selected="selected" value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                            <?php
                                            } else {
                                            ?>
                                            <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                        <?php
                                        if (!$page->active) {
                                        ?>
                                        <script>
                                            $(document).ready(function() {
                                            $('#timeslots_' + <?= $page->id ?>).prop('disabled', true).trigger("chosen:updated");
                                            });
                                        </script>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-danger btn-sm deletepage " id="delete_<?= $page->id ?>" data-src="<?= $page->channel_thumbnail ?>" data-toggle="modal" data-target="#confirm-remove" data-name="<?= $page->channel_title ?>" data-id="<?= $page->id ?>"><span class="icon-trash"></span> Remove
                                        </button>
                                    </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            </div>
                        <?php 
                            }
                        ?>
                      </div>
                <?php
                  }
                }
                ?>
                  </div>
                  <!-- ============================================================== -->
                  <!-- End PAge Content -->
                  <!-- ============================================================== -->
            </div>

            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel">Confirm Diconnect</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <p>You are about to Diconnect Your <b><i class="title">Facebook</i></b> Account From, Adublisher.com</p>
                    <p>Do you want to proceed?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-ok">Yes, I am Sure</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="active-hours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Update Active hours</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <p>
                      Select active hours for Posting on facebook, You will get posts between these hours. </p>

                    <!-- Start Time <input class="form-control form-control-sm" type="text" style="" id="time_start" value="<?php echo $user->posting_start; ?>">
                        End Time <input class="form-control form-control-sm" type="text" style="" id="time_end" value="<?php echo $user->posting_end;  ?>">
                       
                        Interval(in hours) <input class="form-control form-control-sm" min="1" max="12" type="number"  id="interval" value="<?php echo $user->posting_interval; ?>">
                        <small>Between 1 and 12</small> -->
                    <p>Timezone: <?php echo $user->gmt . " " . $utc_offset ?></p>

                    Start Time
                    <div class="input-append input-group date">

                      <span class="input-group-addon add-on">
                        <i class="fa fa-clock-o" data-date-icon="fa fa-calendar"></i>
                      </span>
                      <input type="text" class="datetimepicker  form-control form-control-sm" id="time_start" data-format="HH:mm PP" value="<?php echo $user->posting_start; ?>"></input>
                    </div>
                    End Time
                    <div class=" input-append input-group date">

                      <span class="input-group-addon add-on">
                        <i class="fa fa-clock-o" data-date-icon="fa fa-calendar"></i>
                      </span>
                      <input type="text" class=" datetimepicker form-control form-control-sm" id="time_end" data-format="HH:mm PP" value="<?php echo $user->posting_end; ?>"></input>
                    </div>

                    <br>
                    <br>

                    <p><b class="text-danger">Note</b> This Change will reflect your posting very next day.</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-ok">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="confirm-remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel">Confirm Please</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <p class="text-center"> <img style="width:300px;" id="caution_image" src="<?= GeneralAssets ?>images/youtube_logo.png" class="rounded b-all" alt="image">
                      <br>
                      <b><i class="title">Page</i></b>
                    </p class="text-center">
                    <p>You are about to Remove <span class="title"></span> page From, Adublisher.com
                        <br>
                      You Can Re-Connect Your YouTube channel to get this page here</p>
                  </div>
                  <div class="modal-footer">

                    <button type="button" class="btn btn-danger btn-ok">Yes, I am Sure</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>


            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" id="comingposts" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Upcoming posts for: <b id="page_name"></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-6">
                        <p class="pl-3">Timezone: <?php echo $user->gmt . " " . $utc_offset ?></p>
                      </div>
                      <div class="col-md-6" id="actions" style="display: none;">
                        <input type="hidden" id="page_id" value="">
                        <button class="btn btn-danger deleteall m-l-5 btn-sm pull-right mr-3"><i class="fa fa-trash pointer"></i> Delete All</button>
                        <button class="btn btn-success shuffle m-l-5 btn-sm pull-right mr-3"><i class="fa fa-refresh pointer"></i> Shuffle</button>
                      </div>
                    </div>
                    <div class="comment-widgets" id="poststable">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

          </div>

        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <?php
      $this->load->view('templates/publisher/footer');
      if (isset($_GET['status'])) {
        $status = str_replace(array("#", "_", "="), "", $_GET['status']);
        if ($status == "true") {
      ?>
          <script type="text/javascript">
            $(document).ready(function() {
                console.log('here');
              swal({
                title: "Congratulations!",
                text: "Your YouTube Channel is Successfully Attached With Adublisher.com",
                imageUrl: "<?= $user->facebook_dp; ?>"
              });
            });
          </script>
        <?php

        } else if ($status == "false") {

        ?>
          <script type="text/javascript">
            $(document).ready(function() {
              swal({
                title: "Error!",
                text: "Something Went wrong, Please try again. Contact Support if you facing this error multiple times.",
                type: "error"
              });
            });
          </script>
      <?php

        }
      }
      ?>

      <script src="<?= GeneralAssets ?>plugins/tablesaw-master/dist/tablesaw.js"></script>
      <script src="<?= GeneralAssets ?>plugins/tablesaw-master/dist/tablesaw-init.js"></script>
      <!--<script src="<?= GeneralAssets ?>plugins/time/js/timepicker.js"></script>-->
      <script src="<?= GeneralAssets ?>plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
      <script src="<?= GeneralAssets ?>plugins/jquery-datetime/jquery.datetimepicker.full.js"></script>
      <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

      <script type="text/javascript">
        $(document).ready(function() {

          $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
          });

          $(".chosen-timeslots").change(function() {

            var chosen = $(this).val().length;
            var page = $(this).data('pageid');
            var time_slots = $(this).val();
            if (page != "") {
              var dataOBJ = {
                'time_slots': time_slots,
                'page': page
              }
              $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>update_youtube_timeslots_auto",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                  alertbox("Success", "Posting time Updated Successfully", "success");
                },
                error: function() {}
              });
            }
          });

          $(".chosen-domains").change(function() {

            var chosen = $(this).val().length;
            var page = $(this).data('pageid');
            var domains = $(this).val();
            if (page != "") {
              var dataOBJ = {
                'domains': domains,
                'page': page
              }
              $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>update_page_domains_auto",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                  alertbox("Success", "Posting domains Updated Successfully", "success");
                },
                error: function() {}
              });
            }
          });

          $(".add-on").on('click', function() {
            $(this).next('input').datetimepicker('show');
          });
          user_id = $("#loggeduserid").val();
          $('.datetimepicker').datetimepicker({
            // pickDate: false,
            // maskInput: false,
            format: "H:i",
            datepicker: false,
            // pickSeconds: false,
            // language: 'en',
            // pick12HourFormat: false
          });
          $(document).on('change', '.autoposting', function() {

            var id = $(this).data("id");
            var status_ = "off";
            if (this.checked) {
              status_ = "on";
            }
            var dataOBJ = {
              'id': id,
              'status': status_
            }
            $.ajax({
              type: "POST",
              url: "<?php echo SITEURL; ?>updateyoutubeautopost",
              data: dataOBJ,
              dataType: "json",
              success: function(response) {
                if (response.status) {
                  alertbox("Success", "Page Auto Posting Updated Successfully", "success");
                  if (status_ == "on") {

                    $("#list_" + id).prop("disabled", false);
                    $('#timeslots_' + id).prop('disabled', false).trigger("chosen:updated");
                    $("#quantity_" + id).prop("disabled", false);


                  } else {
                    $("#list_" + id).prop("disabled", true);
                    $('#timeslots_' + id).prop('disabled', true).trigger("chosen:updated");
                    $("#quantity_" + id).prop("disabled", true);
                  }

                }
              },
              error: function() {
                alertbox("Error", "Nothing Has been changed, try again", "error");
              }
            });
          });
          $(document).on('change', '.autopostingquantity', function() {

            var id = $(this).data("id");
            var value = $(this).val();

            var dataOBJ = {
              'id': id,
              'value': value
            }
            $.ajax({
              type: "POST",
              url: "<?php echo SITEURL; ?>updatepageautopostquantity",
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

          $(document).on('click', '.browselist', function() {
            var id = $(this).data("id");
            $("#page_id").val(id);
            $("#page_name").html($(this).data("name"));
            $("#actions").hide();
            refillposts(id);
          });

          $('#confirm-delete').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('.btn-ok', this).data('recordId', data.id);
          });

          $('#confirm-delete').on('click', '.btn-ok', function(e) {

            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');

            var dataOBJ = {
              'id': id

            }
            $.ajax({
              type: "POST",
              url: "<?php echo SITEURL; ?>disconnectfacebook",
              data: dataOBJ,
              dataType: "json",
              success: function(response) {
                if (response.status) {
                  alertbox("Success", "Your facebook Account disconnected Successfully", "success");
                }
                setTimeout(function() {
                  location.reload();
                }, 2000);
              },
              error: function() {
                alertbox("Error", "Nothing Has been changed, try again", "error");
              }
            });
          });

          $('#confirm-remove').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('.btn-ok', this).data('recordId', data.id);
            $('.title', this).text(data.name);
          });

          $('#confirm-remove').on('click', '.btn-ok', function(e) {

            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');

            var dataOBJ = {
              'id': id
            }
            $.ajax({
              type: "POST",
              url: "<?php echo SITEURL; ?>duscountyoutubechannel",
            //   disconnectfacebookpage",
              data: dataOBJ,
              dataType: "json",
              success: function(response) {
                if (response.status) {
                  alertbox("Success", "Your facebook Page Removed Successfully", "success");
                }
                setTimeout(function() {
                  location.reload();
                }, 2000);
              },
              error: function() {
                alertbox("Error", "Nothing Has been changed, try again", "error");
              }
            });
          });

          $('#active-hours').on('click', '.btn-ok', function(e) {
            var id = $("#loggeduserid").val();
            var start = $("#time_start").val().replace(' AM', '').replace(' PM', '');
            var end = $("#time_end").val().replace(' AM', '').replace(' PM', '');
            var interval = 2; //$("#interval").val();
            var dataOBJ = {
              'id': id,
              'start': start,
              'end': end,
              'interval': interval
            }
            $.ajax({
              type: "POST",
              url: "<?php echo SITEURL; ?>updateuseractivehours",
              data: dataOBJ,
              dataType: "json",
              success: function(response) {
                if (response.status) {
                  $('#active-hours').modal('hide');
                  swal("Success", "Your  posting hours updated Successfully, this will reflect on very next day", "success");
                }

              },
              error: function() {
                alertbox("Error", "Nothing Has been changed, try again", "error");
              }
            });
          });
          $(document).on('click', '.editpost', function() {

            id = $(this).data('id');
            $('#save_' + id).show();
            $('#cancel_' + id).show();
            $('#text_' + id).hide();
            $('#timeshow_' + id).hide();
            $('#time_' + id).show();
            $('#timebox_' + id).show();
            $('#textarea_' + id).show().focus();
            $('#link_' + id).hide();
            $('#edit_' + id).hide();
            $('#delete_' + id).hide();


          });


          $(document).on('click', '.cancelpost', function() {

            id = $(this).data('id');
            $('#save_' + id).hide();
            $('#textarea_' + id).hide();
            $('#timeshow_' + id).show();
            $('#time_' + id).hide();
            $('#timebox_' + id).hide();


            $('#text_' + id).show();
            $('#cancel_' + id).hide();
            $('#link_' + id).show();
            $('#edit_' + id).show();
            $('#delete_' + id).show();
          });


          $(document).on('click', '.savepost', function() {

            id = $(this).data('id');
            text = $('#textarea_' + id).val();
            time = $('#time_' + id).val();
            if (text.trim() == "") {

              alertbox("Error", "Please enter post tile, it can not be empty.", "error");


            } else {

              var dataOBJ = {
                'id': id,
                'text': text,
                'time': time,
                'user_id': user_id
              }
              $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>updatefacebookpost",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                  if (response.status) {

                    $('#text_' + id).text(text);
                    $('#save_' + id).hide();
                    $('#textarea_' + id).hide();
                    $('#timeshow_' + id).text(time).show();
                    $('#time_' + id).hide();
                    $('#timebox_' + id).hide();
                    $('#text_' + id).show();
                    $('#cancel_' + id).hide();
                    $('#link_' + id).show();
                    $('#edit_' + id).show();
                    $('#delete_' + id).show();
                    swal("Success!", "Your scheduled post Updated Successfully", "success");
                  }
                },
                error: function() {
                  // alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
                  swal("Error", "Nothing Has been changed, please try again", "error");
                }
              });


            }
          });
          $(document).on('click', '.deleteall', function() {
            page_id = $("#page_id").val();
            swal({
              title: "Are you sure?",
              text: "You will not be able to recover these posts again!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete all!",
              closeOnConfirm: true
            }, function() {
              var dataOBJ = {
                'id': 'all',
                'page': page_id
              }
              $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>deletefacebookpost",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                  if (response.status) {
                    //Refill posts
                    refillposts(page_id);
                  }
                },
                error: function() {
                  swal("Error", "Nothing Has been deleted, please try again", "error");
                }
              });
            });
          });

          $(document).on('click', '.shuffle', function() {
            var page = $("#page_id").val();
            swal({
              title: "Shuffle All Posts???",
              text: "You will not be able to recover order of these posts again!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, Shuffle All!",
              closeOnConfirm: true
            }, function() {
              var dataOBJ = {
                'page': page
              }
              $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>shufflefacebookposts",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                  refillposts(page);
                },
                error: function() {
                  swal("Error", "Nothing Has been changed, please try again", "error");
                }
              });
            });
          });

          $(document).on('click', '.deletepost', function() {
            id = $(this).data('id');
            row = $("#row_" + id);
            swal({
              title: "Are you sure?",
              text: "You will not be able to recover this post again!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: true
            }, function() {

              var dataOBJ = {
                'id': id
              }
              $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>deletefacebookpost",
                data: dataOBJ,
                dataType: "json",
                success: function(response) {
                  if (response.status) {
                    var elem = response.data;
                    var tr = '<div class="d-flex flex-row comment-row" style="padding: 5px;border-bottom: 1px solid #e6e0e0;" id="' + 'row_' + elem.id + '">' +
                      '<div class="p-2"><img src="' + elem.img + '" alt="image" class="radius" width="50" height="50"></div>' +
                      '<div class="comment-text active w-100" style="padding-top:5px;padding-bottom:5px;">' +
                      '<p class="m-b-5"  id="' + 'text_' + elem.id + '">' + elem.text + '</p>' +
                      '<p class="m-b-5" style="max-height: 53px;" ><textarea class="form-control" style="display:none;" id="' + 'textarea_' + elem.id + '">' + elem.text + '</textarea></p>' +
                      '<div class="comment-footer "><span class="label label-light-success" id="' + 'timeshow_' + elem.id + '">' + elem.post_date + '</span>' +
                      '<div  class=" input-append input-group date" style="display:none;" id="' + 'timebox_' + elem.id + '">' +
                      '<span class="input-group-addon add-on">' +
                      '<i class="fa fa-calendar" data-date-icon=""></i>' +
                      '</span>' +
                      '<input type="text" class=" timepicker form-control form-control-sm"  id="' + 'time_' + elem.id + '" value="' + elem.post_date + '" ></input>' +
                      '</div>' +
                      '<span class="action-icons active pull-right">' +
                      '<a href="' + elem.link + '" target="_blank" class="linkpost p-r-5 p-l-5" title="Click to view post" id="' + 'link_' + elem.id + '" data-id="' + elem.id + '"><i class="ti-link text-info"></i></a>' +
                      '<a href="javascript:void(0)" style="display:none;" class="editpost m-r-5 m-l-5" title="Click to Edit post" id="' + 'edit_' + elem.id + '" data-id="' + elem.id + '"><i class="ti-pencil-alt text-warning"></i></a>' +
                      '<a href="javascript:void(0)" style="display:none;" class="savepost m-r-5 m-l-5" id="' + 'save_' + elem.id + '" title="Click to Save" data-id="' + elem.id + '"  ><i class="fa  fa-save text-success" ></i></a>' +
                      '<a href="javascript:void(0)" class="cancelpost m-r-5 m-l-5" style="display:none;" id="' + 'cancel_' + elem.id + '" title="Click to cancel" data-id="' + elem.id + '"  ><i class="icon-close text-danger"></i></a>' +
                      '<a href="javascript:void(0)" class="deletepost m-r-5 m-l-5" id="' + 'delete_' + elem.id + '" title="Click to Remove post" data-id="' + elem.id + '"  ><i class="icon-trash text-danger"></i></a>' +
                      '</span> </div>' +
                      '</div>' +
                      '</div>';
                    row.replaceWith(tr);

                  }
                },
                error: function() {
                  swal("Error", "Nothing Has been deleted, please try again", "error");
                }
              });
            });
          })

          function refillposts(page_id) {
            var user_id = $("#loggeduserid").val();
            var dataOBJ = {
              'id': page_id,
              'user_id': user_id
            }
            $.ajax({
              type: "POST",
              url: "<?php echo SITEURL; ?>getcommingposts",
              data: dataOBJ,
              dataType: "json",
              success: function(response) {
                if (response.status) {
                  $("#comingposts").modal('show');
                  $("#actions").show();
                  $("#poststable").html("");
                  $.each(response.data, function(index, elem) {
                    tr = '<div class="d-flex flex-row comment-row" style="padding: 5px;border-bottom: 1px solid #e6e0e0;" id="' + 'row_' + elem.id + '">' +
                      '<div class="p-2"><img src="' + elem.img + '" alt="image" class="radius" width="50" height="50"></div>' +
                      '<div class="comment-text active w-100" style="padding-top:5px;padding-bottom:5px;">' +
                      '<p class="m-b-5"  id="' + 'text_' + elem.id + '">' + elem.text + '</p>' +
                      '<p class="m-b-5" style="max-height: 53px;" ><textarea class="form-control" style="display:none;" id="' + 'textarea_' + elem.id + '">' + elem.text + '</textarea></p>' +
                      '<div class="comment-footer "><span class="label label-light-success" id="' + 'timeshow_' + elem.id + '">' + elem.post_date + '</span>' +
                      '<div  class=" input-append input-group date" style="display:none;" id="' + 'timebox_' + elem.id + '">' +
                      '<span class="input-group-addon add-on">' +
                      '<i class="fa fa-calendar" data-date-icon=""></i>' +
                      '</span>' +
                      '<input type="text" class=" timepicker form-control form-control-sm"  id="' + 'time_' + elem.id + '" value="' + elem.post_date + '" ></input>' +
                      '</div>' +
                      '<span class="action-icons active pull-right">' +
                      '<a href="' + elem.link + '" target="_blank" class="linkpost p-r-5 p-l-5" title="Click to view post" id="' + 'link_' + elem.id + '" data-id="' + elem.id + '"><i class="ti-link text-info"></i></a>' +
                      '<a href="javascript:void(0)" style="display:none;" class="editpost m-r-5 m-l-5" title="Click to Edit post" id="' + 'edit_' + elem.id + '" data-id="' + elem.id + '"><i class="ti-pencil-alt text-warning"></i></a>' +
                      '<a href="javascript:void(0)" style="display:none;" class="savepost m-r-5 m-l-5" id="' + 'save_' + elem.id + '" title="Click to Save" data-id="' + elem.id + '"  ><i class="fa  fa-save text-success" ></i></a>' +
                      '<a href="javascript:void(0)" class="cancelpost m-r-5 m-l-5" style="display:none;" id="' + 'cancel_' + elem.id + '" title="Click to cancel" data-id="' + elem.id + '"  ><i class="icon-close text-danger"></i></a>' +
                      '<a href="javascript:void(0)" class="deletepost m-r-5 m-l-5" id="' + 'delete_' + elem.id + '" title="Click to Remove post" data-id="' + elem.id + '"  ><i class="icon-trash text-danger"></i></a>' +
                      '</span> </div>' +
                      '</div>' +
                      '</div>';
                    $("#poststable").append(tr);
                  });
                }
              },
              error: function() {
                $("#comingposts").modal('show');
                $("#poststable").html("");
                tr = 'No Posts found against this page, Make sure to update posts per day value  next to the list button after turning ON auto posting';
                $("#poststable").append(tr);
                $("#actions").hide();
              }
            });
          }

        });
      </script>