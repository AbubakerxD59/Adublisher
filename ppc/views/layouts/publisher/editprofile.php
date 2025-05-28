
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
                                <h2 class="text-center mt-2 m-b-0"> Personal info</h2>
                                <p class="text-center text-muted">Update personal details like name, contact, timezone that you use on Adublisher.</p>
                              
                                <div class="row m-0 p-10">
                                    <div class="col-md-12">
                        <div class="card view_form" >
                            <div class="card-body">
                                <form class="form-horizontal">
                                    <div class="form-body">
                                        <h3 class="p-2 rounded-title">Person Info
                                        <button type="button" class="btn btn btn-outline-secondary pull-right edit_enable"> <i class="fa fa-pencil"></i> Edit</button>
                                        </h3>
                                        <hr class="mt-0 mb-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">First Name:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$fname?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Last Name:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$lname?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Email:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$email?> 
                                                            <!-- <i class="fa fa-lock"></i>  -->
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6"> Username:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$username?> <i class="fa fa-lock"></i> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Phone Number:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$ph?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Facebook Profile Link:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$fb_profile?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Facebook Page Link:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$fb_page?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Time Zone:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$gmt?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                          
                                        </div>
                                        <!--/row-->
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                        <div class="col-md-6"> </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-6">
                                                       
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                           
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card hide edit_form" >
                            <div class="card-body">
                                <form class="form-horizontal" id="update_profile_form">
                                    <div class="form-body">
                                        <h3 class="p-2 rounded-title">Updating Info
                                        <button type="submit" class="btn btn btn-outline-secondary pull-right" > <i class="fa fa-floppy-o"></i> Update Profile</button>
                                    </h3>
                                        <hr class="mt-0 mb-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">First Name:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <input type="text" value="<?=$fname?>" name="fname"  id="fname"  class="form-control form-control-line" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Last Name:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <input type="text" value="<?=$lname?>" name="lname"  id="lname"  class="form-control form-control-line" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Email:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <input type="text" value="<?=$email?>" name="email"  id="email"  class="form-control form-control-line" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6"> Username:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$username?> <i class="fa fa-lock"></i> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Phone Number:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <input type="text" value="<?=$ph?>" name="ph"  id="ph" class="form-control form-control-line" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Facebook Profile Link:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <input type="text" value="<?=$fb_profile?>" name="fbprofile"  id="fbprofile"  class="form-control form-control-line">

                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Facebook Page Link:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <input type="text" value="<?=$fb_page?>" name="fbpage"  id="fbpage"  class="form-control form-control-line">

                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <!--/span-->
                                            <style>
                                                .select2-container {
                                                   width : 100% !important; 
                                                }
                                            </style>
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6" id="gmt" data-val="<?=$gmt?>">Time Zone:</label>
                                                    <div class="col-lg-9 col-6">
                                                    <select id="time" name="gmt" class="form-control"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                          
                                        </div>
                                        <!--/row-->
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#time').select2();
});
</script>

<?php 
$this->load->view('templates/publisher/footer');
?>
