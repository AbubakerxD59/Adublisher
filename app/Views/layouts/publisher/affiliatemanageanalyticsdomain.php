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
            <h2 class="text-center mt-4"> Analytics domains</h2>
            <p class="text-center text-muted">Domains to be used for calculating traffic via google analytics. <a
                href="#">Learn more</a>
              <br>
              <a href="#" class="" data-toggle="modal" data-target="#adddomain"><i class="fa fa-plus"></i> Add New</a>
            </p>
            <div class="row p-10 m-0">
              <div class="col-md-12">
                <div class="card simple-card">
                  <div class="card-body">

                    <div class="table-responsive m-10">
                      <table id="myTable" class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Domain</th>

                            <th style="width: 220px;">Google Analytics View-ID</th>
                            <th style="width: 120px;">Status</th>
                            <th class="no-sort" style="width: 250px;"><i class="fa fa-usd"></i> PPC Rates</th>
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
                                                                        </td>
                                                                       
                                                                        <td>
                                                                        <input class="form-control form-control-sm form-control-line m-t-0  m-b-0" id="property_' . $row->id . '" value="' . $row->property_id . '" disabled="disabled" >  
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

                            echo '<td>
                                                                        <select name="status" class="form-control form-control-sm m-t-0  m-b-0" style="width:50%;" id="rates_priority_' . $row->id . '" disabled="disabled">';

                            if ($row->rates_priority == "yes") {
                              echo '<option value="yes" selected="selected">Active</option>
                                                                            <option value="default">Inactive</option>';
                            } else {

                              echo '<option value="yes" >Active</option>
                                                                            <option value="default" selected="selected">Inactive</option>';
                            }
                            echo '</select>
                                                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-outline-secondary  ml-1 edit-rates rates rates_' . $row->id . '" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-usd"></i> Set rates</button>
                                                                    
                                                                        </td>';

                            echo '
                                                                        <td>
                                                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-outline-secondary mt-1 edit-cat edit edit_' . $row->id . '" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-pencil"></i> Edit</button>

                                                                        <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm  mt-1 btn-outline-secondary   save_' . $row->id . ' save" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-save"></i> Save</button>

                                                                        <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm mt-1 btn-outline-secondary   cancel_' . $row->id . ' cancel" data-id="' . $row->id . '" data-domain="' . $row->domain . '"> <i class="fa fa-pencil"></i> Cancel</button>
                                                                        </td>
                                                                    <td>
                                                                    <button type="button" class="btn waves-effect waves-light btn-sm btn-outline-secondary mt-1 " data-record-title="' . $row->domain . '" data-toggle="modal" data-target="#confirm-delete" data-record-id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</button>
                                                                    </td>
                                                                    </tr>';
                          }
                          ?>


                        </tbody>
                      </table>


                    </div>
                    <div>Please add <strong>shabby@adublisher-193617.iam.gserviceaccount.com</strong> in your Analytics
                      dashboard and allow <b>Read & Analyze</b> permissions
                    </div>
                  </div>
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
                <label for="domain" class="control-label">Google Analytics View ID: GA-</label>
                <input type="number" class="form-control" id="property" name="property" />
                <small> Don't include GA-, only input number</small>
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


    <div class="modal fade" id="userRates" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">SET DOMAINS LEVEL RATES</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <div class="modal-footer">
            <button type="button" id="saverates" class="btn btn-outline-secondary"> <i class="fa fa-floppy-o"></i>
              Save</button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="domain_id" value="" />
            <table id="myTable" class="table table-bordered">
              <thead>
                <tr>
                  <th>Country</th>
                  <th class="no-sort">Rate Per Click</th>
                </tr>
              </thead>
              <tbody id="rates_body">


              </tbody>
            </table>

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


      $(document).on('click', '#saverates', function () {

        var ratesarray = [];
        $(".ratesinputs").each(function () {
          ratesarray.push({ id: $(this).data('cid'), value: $(this).val() });
        });

        $.ajax({
          url: 'add_update_rate_owner',
          type: 'POST',
          data: { res_id: $('#domain_id').val(), identifier: 'domain', rates: JSON.stringify(ratesarray) },
          success: function (data) {
            alertbox("Success", "Settings Updated Successfully", "success");
            $("#userRates").modal('hide');
          },
          error: function (data) {

            alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");

          }
        });

      });

      $(".rates").click(function () {
        $("#rates_body").html("");
        id = $(this).data('id');
        $("#domain_id").val(id);

        $.ajax({
          url: '<?= BASEURL ?>get_rate_settings_owner',
          type: 'GET',
          data: { identifier: 'domain', res_id: id },
          success: function (response) {

            $(response.data).each(function (key, value) {



              row = '<tr ng-repeat="item in ratestable">' +
                '<td><img src="assets/general/flags/' + value.code + '.png"> ' + value.name + '</td>' +
                '<td><input data-cid="' + value.id + '"  class="ratesinputs input-sm" value="' + value.rate + '" ></td>' +
                '</tr>';
              $("#rates_body").append(row);
            });
            $("#userRates").modal('show');

          },
          error: function (data) {
            alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");
          }
        });


      });
      $(".edit").click(function () {

        id = $(this).data('id');
        $("#domain_" + id).removeAttr('disabled');
        $("#status_" + id).removeAttr('disabled');

        $("#property_" + id).removeAttr('disabled');
        $("#rates_priority_" + id).removeAttr('disabled');


        $(this).hide();
        $('.save_' + id).show();
        $('.cancel_' + id).show();
      });

      $(".cancel").click(function () {

        id = $(this).data('id');
        $("#domain_" + id).attr('disabled', 'disabled');
        $("#status_" + id).attr('disabled', 'disabled');

        $("#property_" + id).attr('disabled', 'disabled');
        $("#rates_priority_" + id).attr('disabled', 'disabled');

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
            url: "affiliate_analytics_domain_edit",
            data: dataOBJ,
            dataType: "json",
            success: function (response) {
              if (response.status) {
                alertbox("Success", "domain updated Successfully", "success");
                $("#domain_" + id).attr('disabled', 'disabled');
                $("#status_" + id).attr('disabled', 'disabled');

                $("#property_" + id).attr('disabled', 'disabled');
                $("#rates_priority_" + id).attr('disabled', 'disabled');


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
            url: "affiliate_analytics_domain_delete",
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
            url: "affiliate_analytics_domain_add",
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