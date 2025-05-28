
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Add Campaign</h3>
                      
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
                  
                     <div class="col-md-8 col-xlg-9">
                        <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header ">
                                <h4 class="card-title m-b-0">New Campaign </h4>
                                <i class="fa fa-cog  fa-spin fa-fw pull-right" id="loader" style="display: none"></i>
                            </div>
                            <div class="card-body b-t collapse show" style="">

                            <form class="m-t-40 form-material" novalidate id="formdata">
                                <div class="row">
                                    
                                       <div class="form-group col-md-12 m-b-5">
                                            <label class="m-b-0">Link</label>
                                            <input class="form-control" name="cpuspc" required data-validation-required-message="This field is required" id="cpuspc" type="text">
                                        </div>
                                       
                                   
                                    <div class="form-group col-md-6 m-b-5">
                                            <label class="m-t-20">Title</label>
                                            <input class="form-control" name="cpname" id="cpname"  required data-validation-required-message="This field is required" type="text">
                                        </div> 
                                       <div class="form-group col-md-6 m-b-5">
                                            <label class="m-t-20">Image Link</label>
                                            <input class="form-control" name="cpimg" id="cpimg" required data-validation-required-message="This field is required" type="text">
                                        </div>

                                   
                                       <div class="form-group col-md-3 m-b-5">
                                            <label class="m-t-20">Status</label>
                                            <select name="cpstatus" class="form-control">
                                                 <option value="enable">Enable</option>
                                                 <option value="disable">Disable</option>
                                            </select>
                                        </div>
                                  
                                    <div class="form-group col-md-3 m-b-5">
                                        <label class="m-t-20">Category</label>
                                        <select name="cpcat" class="form-control">
                                            <?php
                                           
                                            foreach($categories as $row)
                                            {
                                                 echo'<option value="'.$row->id.'">'.$row->categury.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                  
                                       <div class="form-group col-md-3 m-b-5">
                                            <label class="m-t-20">Star</label>
                                            <select name="star" class="form-control">
                                                 <option value="false">No</option>
                                                 <option value="true">Yes</option>
                                            </select>
                                        </div>
                                  
                                   
                                       <div class="form-group col-md-3 pull-right m-b-0" style="align-self: flex-end;">
                                            <input class="btn btn-primary btn-block" value="Add" type="submit">
                                        </div>
                                
                            </div>
                        </form>
                               
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                     <div class="col-md-4 col-xlg-3">
                      

                         <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                                 </div>
                                <h4 class="card-title m-b-0">Image Preview</h4>
                            </div>
                            <div class="card-body b-t collapse show" style="">
                                 <img  width="340px" height="305px" id="cpimage" src="assets/general/images/placeholder.png">
                            </div>
                        </div>
                        <!-- Column -->

                    </div>
                    <div class="col-md-4 col-xlg-3">
                       
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
 <script src="<?=AdminAssets ?>js/campaign_add.js"></script>
