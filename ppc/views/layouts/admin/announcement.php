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
                        <h3 class="text-themecolor m-b-0 m-t-0">Announcements</h3>
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
                               <button type="button" class="btn waves-effect waves-light btn-primary pull-right" data-toggle="modal" data-target="#adddomain" >
                                <i class="fa fa-plus"> </i> Add New  
                               </button>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="announce_table">
                                            <thead>
                                                <th> ID </th>
                                                <th> Announcement </th>
                                                <th class="no-sort"> Edit </th>
                                                <th class="no-sort"> Delete </th>
                                            </thead>       
                                            
                                            <tbody id="table-body"> 
                                                <?php foreach ($announces as $announce)
                                                {
                                                    echo "<tr> 

                                                            <td> $announce[id] </td>
                                                            <td> 
                                                             <form class='form-material m-t-0 p-0 row'>
                                                            <div class='form-group m-t-0 m-b-0 col-md-8'>
                                                            <input class='form-control form-control-line m-t-0  m-b-0' id='text_$announce[id]' value='$announce[text]' disabled='disabled'> </div>

                                                            <div class='form-group m-t-0  m-b-0 col-md-3'>        
                                                                <select name='status' class='status_$announce[id] form-control m-t-0  m-b-0' id='' disabled='disabled'>";
                                                            
                                                    if($announce['status']=='Active')
                                                        {
                                                           echo "<option selected> Active </option> 
                                                            <option> InActive </option>
                                                           </select";
                                                        }
                                                    else
                                                        {
                                                            echo 
                                                             "<option selected> Active </option> 
                                                            <option> InActive </option>
                                                           </select>";
                                                        }
                                                         echo "</select> </div> </form> </td>
                                                        <td>
                                                        <button type='button' id='edit_$announce[id]' class='edit btn waves-effect waves-light btn-sm btn-primary text-white'> <i class='fa fa-pencil'></i> EDIT
                                                        </button>

                                                         <button id='save_$announce[id]' name='$announce[status]' style='display:none' type='button' class='save btn waves-effect waves-light btn-sm btn-success text-white' > <i class='fa fa-pencil'></i> SAVE
                                                         </button> 
                                                         <button id='cancel_$announce[id]'' style='display:none' type='button' class='cancel btn waves-effect waves-light btn-sm btn-danger text-white' > <i class='fa fa-pencil'></i> CANCEL
                                                         </button>
                                                         </td>
                                                        <td>
                                                          <button id='del_$announce[id]' type='button' class='del btn waves-effect waves-light btn-sm btn-danger'> <i class='fa fa-trash'></i> DELETE</button>

                                                        </form> </td> </tr>";
             

                                                }?> 
                                            </tbody> 
                                     </table>
                                    </div>   
                                </div>
                            </div>
                        </div> 
                    </div>
            </div>
           <div class="modal fade" id="adddomain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">Add New Announcement</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="domain" class="control-label">Announcement Text :</label>
                                        <input class="form-control" id="created_text" name="created_text" />
                                    </div> 
                                 </form>  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="create btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
            </div>
 

</div>
<script src="<?=GeneralAssets ?>plugins/datatables/jquery.dataTables.min.js"></script>            
<script src="<?=AdminAssets ?>js/annoucement.js"></script>


