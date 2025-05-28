<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <div class="container-fluid">

    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div>
      <div>
        <div class="card simple-card">
          <div class="card-body">
            <h2 class="text-center mt-4"> Redirect domains</h2>
            <p class="text-center text-muted">You must provide us domains to be used for redirect for campaigns links.
              <a href="#">Learn more</a>
              <br>
              <a href="#" class="" data-toggle="modal" data-target="#adddomain"><i class="fa fa-plus"></i> Add New</a>

            </p>
            <div class="row p-10 m-0">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">

                    <div class="table-responsive m-10">
                      <table id="myTable" class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Domain</th>
                            <th style="width: 120px;">Status</th>
                            <th class="no-sort" style="min-width: 120px;">Edit</th>
                            <th class="no-sort">Delete</th>
                          </tr>
                        </thead>
                        <tbody id="table-body">
                          <?php
                          foreach ($domains as $row) {

                            echo "<tr id='" . $row->id . "' >";
                            echo '<td>
                                                                        <input class="form-control form-control-sm form-control-line m-t-0  m-b-0" id="domain_' . $row->id . '" value="' . $row->domain . '" disabled="disabled" >
                                                                        </td>';

                            echo '<td>
                                                                        <select name="status" class="form-control form-control-sm m-t-0  m-b-0" id="status_' . $row->id . '" disabled="disabled">';

                            if ($row->status == "active") {
                              echo '<option value="active" selected="selected">Active</option>
                                                                            <option value="inactive">Inactive</option>';
                            } else {
                              echo '<option value="active" >Active</option>
                                                                            <option value="inactive" selected="selected">Inactive</option>';
                            }
                            echo '</select>
                                                                        </td>';

                            echo '
                                                                        <td>
                                                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-outline-secondary  edit-cat edit edit_' . $row->id . '" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-pencil"></i> Edit</button>

                                                                        <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm   btn-outline-secondary   save_' . $row->id . ' save" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-save"></i> Save</button>

                                                                        <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm  btn-outline-secondary   cancel_' . $row->id . ' cancel" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-pencil"></i> Cancel</button>
                                                                        </td>
                                                                    <td>
                                                                    <button type="button" class="btn waves-effect waves-light btn-sm btn-outline-secondary  " data-record-title="' . $row->domain . '" data-toggle="modal" data-target="#confirm-delete" data-record-id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</button>
                                                                    </td>
                                                                    </tr>';
                          }
                          ?>


                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                <p>You are about to delete <b><i class="title"></i></b> Domain, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
              </div>
              <div class="modal-footer">

                <button type="button" class="btn btn-outline-secondary  btn-ok">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="adddomain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
          style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Add New Domain</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="domain" class="control-label">Domain:</label>
                    <input class="form-control" id="domain" name="domain" />
                  </div>

                  <div class="form-group">
                    <label for="domain" class="control-label">Domain Status:</label>
                    <select name="status" class="form-control" id="status">
                      <option value="active">Active</option>
                      <option value="inactive">Inactive</option>
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->

      </div>
      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
      <?php $this->load->view('templates/publisher/footer'); ?>

      <script src="<?= GeneralAssets ?>plugins/datatables/jquery.dataTables.min.js"></script>
      <script>
        $(document).ready(function () {



          $(".edit").click(function () {
            id = $(this).data('id');
            $("#domain_" + id).removeAttr('disabled');
            $("#status_" + id).removeAttr('disabled');
            $(this).hide();
            $('.save_' + id).show();
            $('.cancel_' + id).show();
          });

          $(".cancel").click(function () {
            id = $(this).data('id');
            $("#domain_" + id).attr('disabled', 'disabled');
            $("#status_" + id).attr('disabled', 'disabled');
            $(this).hide();
            $('.save_' + id).hide();
            $('.edit_' + id).show();
          });


          $(".save").click(function () {
            id = $(this).data('id');
            domain_ = $("#domain_" + id).val();
            status_ = $("#status_" + id).val();
            property_ = $("#property_" + id).val();
            rates_priority_ = $("#rates_priority_" + id).val();
            if ($.trim(domain_) == "") {
              alertbox("Failed", "Please enter domain name", "error");
              return false;
            }
            else {
              var dataOBJ = {
                'id': id,
                'domain': domain_,
                'status': status_,
                'property': property_,
                'rates_priority': rates_priority_
              }
              $.ajax({
                type: "POST",
                url: "affiliate_redirect_domain_edit",
                data: dataOBJ,
                dataType: "json",
                success: function (response) {
                  if (response.status) {
                    alertbox("Success", "domain updated Successfully", "success");
                    $("#domain_" + id).attr('disabled', 'disabled');
                    $("#status_" + id).attr('disabled', 'disabled');
                    $('.save_' + id).hide();
                    $('.cancel_' + id).hide();
                    $('.edit_' + id).show();
                  }
                },
                error: function () {
                  alertbox("Information", "Nothing Has been changed, Edit values and try again", "info");
                }
              });
            }
          });


          $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('recordId');
            if (id < 0 || id == "") {
              alertbox("Error", "Something Went Wrong.. please try again after refresh page", "error");
            } else {
              var id = id;
              var dataOBJ = {
                'id': id
              }
              $.ajax({
                type: "POST",
                url: "affiliate_redirect_domain_delete",
                data: dataOBJ,
                dataType: "json",
                success: function (response) {
                  if (response.status) {
                    alertbox("Success", "domain Deleted Successfully", "success");
                    $("#table-body tr#" + id).remove();
                  }
                },
                error: function () {
                  alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");

                }
              });
            }

            setTimeout(function () {
              $modalDiv.modal('hide').removeClass('loading');
            }, 1000);

          });

          $('#confirm-delete').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();
            $('.title', this).text(data.recordTitle);
            $('.btn-ok', this).data('recordId', data.recordId);
          });



          $('#adddomain').on('click', '.btn-primary', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var domain_ = $("#domain").val();
            var status = $("#status").val();
            var property_ = $("#property").val();
            if ($.trim(domain_) == "") {
              alertbox("Failed", "Please entery domain name", "error");
              return false;
            }
            else {
              var id = id;
              var dataOBJ = {
                'domain': domain_,
                'status': status,
                'property': property_
              }
              $.ajax({
                type: "POST",
                url: "affiliate_redirect_domain_add",
                data: dataOBJ,
                dataType: "json",
                success: function (response) {
                  if (response.status) {
                    alertbox("Success", "domain Added Successfully", "success");

                  }
                  setTimeout(function () {

                    location.reload();

                  }, 1500);
                },
                error: function () {
                  alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");

                }
              });
              setTimeout(function () {
                $modalDiv.modal('hide').removeClass('loading');
              }, 1000);
            }
          });


        });
      </script>