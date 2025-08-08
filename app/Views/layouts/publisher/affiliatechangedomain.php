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
            <h2 class="text-center mt-2 m-b-0"> Redirect & Domain Settings</h2>
            <p class="text-center text-muted">Redirect or Direct Link settings for your affiliates, change/select domain
              in case of redirect. <a href="#">Learn more</a></p>
            <div class="row m-0 p-10">
              <div class="col-md-12">
                <div class="card p-10">
                  <div class="card-body">
                    <form class="m-b-30">
                      <div class="row mt-5">
                        <div class="col-md-8">
                          <p>Redirect feature for publishing content on your social media</p>
                        </div>
                        <div class="col-md-4 text-right">
                          <div class="switch">
                            <label>OFF
                              <?php
                              $redirect = "";
                              if ($user->direct_link == "indirect") {

                                ?>
                                <input id="redirect-switch" type="checkbox" checked><span
                                  class="lever switch-col-light-blue"></span>ON</label>
                              <?php
                              } else {
                                $redirect = "hide";
                                ?>
                              <input id="redirect-switch" type="checkbox"><span
                                class="lever switch-col-light-blue"></span>ON</label>
                              <?php
                              }
                              ?>
                          </div>
                        </div>
                      </div>
                      <div class="row <?= $redirect ?> redirect_domains mt-5">
                        <div class="col-md-8">
                          <p>Please choose redirect domain to be used in links</p>
                        </div>
                        <div class="col-md-4">
                          <div class="input-group col-md-12">
                            <?php
                            if (sizeof($all_domains) > 0) {
                              ?>
                              <select class="form-control" id="redirect_domain">
                                <?php
                                foreach ($all_domains as $domain) {
                                  if ($domain->status == "inactive") {
                                    echo '<option disabled="disabled" value="' . $domain->id . '">' . $domain->domain . ' (In-Active)</option>';
                                  } else {
                                    if ($domain->domain == $current_domain) {
                                      echo '<option value="' . $domain->id . '" selected>' . $domain->domain . '</option>';
                                    } else {
                                      echo '<option value="' . $domain->id . '">' . $domain->domain . '</option>';
                                    }
                                  }
                                }
                                ?>
                              </select>
                              <?php
                            } else {
                              echo '<a href="' . SITEURL . 'affiliate-manage-redirect-domain"> redirect domains not found, please add and come again</a>';
                            }

                            ?>

                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-body">
                    <hr class="mt-0">
                    <h5 class="mt-4"> <i class="fa fa-exclamation-circle"></i> Direct Link</h5>
                    <p class="text-muted">By using direct link, when user will click on your social media link shared by
                      Adublisher will directly go to orignal link</p>

                    <h5 class=""> <i class="fa fa-exclamation-circle"></i> Redirect Link</h5>
                    <p class="text-muted">By Using redirect link, when user will click on your social media link shared
                      by Adublisher will first come on your selected domain and than redirected to orignal link</p>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End PAge Content -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Right sidebar -->
      <!-- ============================================================== -->
      <!-- .right-sidebar -->

      <!-- ============================================================== -->
      <!-- End Right sidebar -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <?php $this->load->view('templates/publisher/footer'); ?>


    <script>
      $(document).ready(function () {
        var SITEURL = $("#SITEURL").val();
        $("#redirect-switch").change(function () {
          var value = "";
          if (this.checked) {
            var value = "indirect";
            $(".domains").show();
          } else {
            var value = "direct";
            $(".domains").hide();
          }
          var dataOBJ = {
            'value': value,
          }
          $.ajax({
            url: SITEURL + "redirectlink",
            type: 'POST',
            dataType: 'json',
            type: "POST",
            data: dataOBJ,
            success: function (response) {
              if (response) {
                alertbox("Success", "Redirect settings changed successfully", "success");
              }
            },
            error: function () {
              alertbox("Information", "Nothing Has been Changed.", "info");
            }
          });
          //
        });

        $("#domain").change(function () {

          domain_id = $(this).val();
          var dataOBJ = {
            'domain_id': domain_id,
          }
          $.ajax({
            type: "POST",
            url: "domainchange",
            data: dataOBJ,
            dataType: "json",
            success: function (response) {
              if (response) {
                alertbox("Success", "Redirect domain changed successfully", "success");
              }
            },
            error: function () {
              alertbox("Information", "Nothing Has been Changed.", "info");
            }
          });
        });


      });
    </script>