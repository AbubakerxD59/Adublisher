
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Add New Admin</h3>
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
                  <div class="col-md-12 col-xlg-12">
                    <div class="card earning-widget">
                    <div class="card-body">
                      <form class="form-horizontal form-material"  novalidate id="formdata" >
                        <h3 class="box-title m-t-40 m-b-0">Register New Admin</h3>
                        <div class="form-group m-t-20">
                          <div class="col-xs-12">
                            <input class="form-control" name="name"  id="name"  type="text" required placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group m-t-20">
                          <div class="col-xs-12">
                            <input class="form-control" name="username" id="username" type="text" required placeholder="User Name">
                          </div>
                        </div>
                        <div class="form-group ">
                          <div class="col-xs-12">
                            <input class="form-control" name="email" id="email"  type="text" required placeholder="Email">
                          </div>
                        </div>
                        <div class="form-group ">
                          <div class="col-xs-12">
                            <input class="form-control" type="password" id="password" name="password" required placeholder="Password">
                          </div>
                        </div>
                        
                        <div class="form-group text-center m-t-20">
                          <div class="col-xs-12">
                            <button class="btn btn-primary text-uppercase waves-effect waves-light float-left" type="submit">Add Admin</button>
                          </div>
                        </div>
                      </form>
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

 <script src="<?=GeneralAssets ?>plugins/datatables/jquery.dataTables.min.js"></script>
 
<script>
    
$(document).ready(function() {

  $("input,textarea,select").jqBootstrapValidation(
                    {
          preventSubmit: true,
          submitError: function($form, event, errors) {
              // Here I do nothing, but you could do something like display 
              // the error messages to the user, log, etc.
          },
          submitSuccess: function($form, event) {
              event.preventDefault();
                $("#loader").show();
                data = $("#formdata").serialize();
                $.ajax({
                type: "POST",
                url: "admin_add_rest",
                data: data,
                cache: false,
                dataType: 'json',
                success: function(data){
                if(data.status){
                     $("#name").val("");
                     $("#username").val("");
                     $("#password").val("");
                     $("#email").val("");
                     alertbox("Success" , "Admin Added Successfully" ,  "success");
                        
                }else{
                  alertbox("Failed" , "Something bad happened try agian" ,  "error");
                }
                $("#loader").hide();
                
            }, error:function(){
                 
                 $("#loader").hide();
                 alertbox("Failed" , "Something bad happened try agian" ,  "error");
            }
            });

           
          },
          filter: function() {
              return $(this).is(":visible");
          }
      }
  );


    });
</script>