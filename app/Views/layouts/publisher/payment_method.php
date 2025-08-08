
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
                <div class="row">
                    <div class="col-12">
                        <div class="card simple-card">
                            <div class="card-body">
                                <h2 class="text-center mt-4"> You incoming payment methods</h2>
                                <p class="text-center text-muted">Update/Add your payment details so your employeer can send you payment on time.</p>
                                <div class="row m-0 p-10">
                    <div class="col-md-12">
                                <div class="card view_form" >
                            <div class="card-body">
                                <form class="form-horizontal" role="form">
                                    <div class="form-body">
                                        <h3 class="p-2 rounded-title">Payment info
                                        <button type="button" class="btn btn btn-outline-secondary pull-right edit_enable"> <i class="fa fa-pencil"></i> Edit</button>
                                        </h3>
                                        <hr class="mt-0 mb-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Paypal Email:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$user->paypal_email?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Payoneer Email:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <p class="form-control-static"> <?=$user->payoneer_email?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                       
                                    </div>
                                    
                                </form>
                            </div>
                        </div>

                        <div class="card hide edit_form" >
                            <div class="card-body">
                                <form class="form-horizontal" role="form" method="post"  action="<?=SITEURL.'add_paymentmethod'?>">
                                    <div class="form-body">
                                        <h3 class="p-2 rounded-title">Updating Payment info
                                        <button type="submit" class="btn btn btn-outline-secondary pull-right" > <i class="fa fa-floppy-o"></i> Save </button>
                                    </h3>
                                        <hr class="mt-0 mb-5">
                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Paypal Email:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <input type="email" name="paypal_email" required="required"  class="form-control" value="<?=$user->paypal_email?>"> 
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-lg-right col-lg-3 col-6">Payoneer Email:</label>
                                                    <div class="col-lg-9 col-6">
                                                        <input type="email" name="payoneer_email"  class="form-control" value="<?=$user->payoneer_email?>">
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
           