
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
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">System Domain</h3>
                      
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                           <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
               
                <div class="row">
                  
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card"> <img class="card-img" src="assets/general/images/background/socialbg.jpg" alt="Card image">
                            <div class="card-img-overlay card-inverse social-profile d-flex ">
                                <div class="align-self-center"> <img src="assets/general/images/users/earth.png" class="img-circle" width="100">
                                <h4 class="card-title" id="currentdomain"><?php echo $systemdomain; ?></h4>
                                <h4 class="card-title m-t-40">Change System Domain</h4>
                                <form class="m-b-30">
                                    <div class="row justify-content-center">
                                        
                                            <div class="input-group">
                                                <select class="form-control" id="domain">
                                                   <?php
                                                     foreach ($alldomains as $domain){
                                                       echo '<option value="'.$domain->id.'">'.$domain->domain.'</option>';
                                                     }
                                                   ?>
                                                </select>
                                                <button class="btn btn-primary updatesystemdomain" type="button">Update</button>
                                           
                                            </div>
                                       
                                    </div>
                                </form>
                                <!-- / Form -->
                                <!-- div -->
                                   
                                </div>
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
 <?php $this->load->view('templates/admin/footer'); ?>

 
<script>
    $(document).ready(function() {

    $(".updatesystemdomain").click(function(){

      domain_id = $("#domain").val();
      domain_ = $("#domain option:selected").text();

          var dataOBJ = {
        'id': 1,
        'domain_id':domain_id ,
      }
      $.ajax({
        type: "POST",
        url: "systemdomain_edit_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response) {
            alertbox("Success" , "System Domain updated Successfully" ,  "success");
           $("#currentdomain").text(domain_);
          }
        },
        error: function() {
           alertbox("Error" , "Something Went Wrong.. please try again after refresh page" ,  "error");
        }
      });


    });


    });
</script>