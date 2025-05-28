
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Articles</h3>
                      
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
                            <div class="card-header ">
                                <div class="row">
                                
                                <div class="col-md-4 pull-left"><h4 class="card-title m-b-0">Articles</h4>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    
                                    <div id="articlereportrange" class=" form-control form-control-sm pull-right">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;<b class="caret"></b>&nbsp;<span></span> 
                                    
                                    </div>

                                </div>
                                <div class="col-md-2 pull-right">

                                    <select id="articleStatus" class="form-control form-control-sm articlefilter">
                                       <option value="all">All Status</option>
                                       <option value="pending" selected="selected">New/Pending</option>
                                       <option value="rework">Pending Rework</option>
                                       <option value="resubmitted">Re Submitted</option>
                                       <option value="locked">Approved/Lock</option>
                                       <option value="published">Published</option>
                                    </select>
                                </div>
                                  
                                     <div class="col-md-3 col-sm-12 col-xs-12">
                             
                                      <select id="articleUserfilter" class="form-control form-control-sm articlefilter">
                                      <option value="all">All Users</option>
                                       <?php
                                    
                                              foreach($all_users as $row) {
                                                 echo  "<option value=".$row->id.">".ucfirst($row->name)."</option>";
                                              }
                                            ?>
                                      </select>
                                      <i class="fa fa-cog  fa-spin fa-1x fa-fw pull-right" id="articleloader" style="display: none"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body b-t collapse show" id="articles">
                                <table class="table v-middle no-border">
                                     <thead>
                                            <tr>
                                                <th style="width: 60%;">Title</th>
                                               
                                                <th>Status </th>
                                               
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="databodyarticles">
                                          
                                           
                                        </tbody>
                                </table>
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
                           <div class="modal fade bs-example-modal"  id="publish_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Publish Article!</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <input class="form-control" type="hidden" id="article_id_p">
                                                 <input class="form-control" type="hidden" id="user_id_p">

                                               
<p class="p_messages helper_message">
 
</p>
<div class="form-group p_messages hide">
    <label><b>Select Website to publish article</b></label>
    <select class="form-control" id="article_domain">
        
    </select>
</div>

<p class="p_messages_2 helper_message_2">
 
</p>
<div class="form-group p_messages_2 hide">
    <label><b>Select Categories to publish article</b></label>
    <select class="form-control" id="article_cat">
        
    </select>
</div>


                                            </div>
                                            <div class="modal-footer">
                                                 <button type="button" id="submit_publish" disabled="disabled" class="btn btn-success waves-effect text-left">Publish</button>
                                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

             <div class="modal fade bs-example-modal-lg"  id="reason_rejection_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Why Rejected ?</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <input class="form-control" type="hidden" id="article_id_m" >
                                                <input class="form-control" type="hidden" id="user_id_m" >
<textarea class="form-control" rows="10" id="reason_rework">
Please make the following changes before submitting again:

Thanks for your submission!
In our continuing effort to help you improve your content, please make the following changes:
1- 
2-
3- 

</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                 <button type="button" id="submit_rejection" class="btn btn-success waves-effect text-left">Submit</button>
                                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

              <div class="modal fade bs-example-modal-lg"   id="article_preview_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg" style="max-width: 90%;!important">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Article Preview</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body" >

                              <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" id="tab_1" href="#article" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-book-open-page-variant"></i></span> <span class="hidden-xs-down">Article</span></a> </li>
                                     <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#meta" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-code-tags-check"></i></span> <span class="hidden-xs-down">Meta Information</span></a> </li>

                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#history" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-history"></i></span> <span class="hidden-xs-down">History</span></a> </li>
                                  
                                </ul>

                                 <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="article" role="tabpanel">
                                        <div class="p-10" id="modal_body">
                                           
                                        </div>
                                    </div>
                                    <div class="tab-pane  p-10" id="meta" role="tabpanel">2</div>
                                    <div class="tab-pane  p-10" id="history" role="tabpanel">2</div>
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
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
 <?php $this->load->view('templates/admin/footer'); ?>

 <script src="<?=GeneralAssets ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=AdminAssets ?>js/dashboard.js?v=<?=BUILDNUMBER?>"></script>

<script>
    $(document).ready(function(){
      $("#articleStatus").val("all").change();
    });
</script>