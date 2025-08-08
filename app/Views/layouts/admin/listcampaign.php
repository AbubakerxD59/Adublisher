
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Campaigns</h3>
                      
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
                      <div class="card">
                            <div class="card-body">
                              
                        <a href="<?=SITEURL;?>campaign_add" class="btn waves-effect waves-light btn-primary pull-right"><i class="fa fa-plus"></i> Add New  </a>
                       
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th style="width: 60%;">Title</th>
                                                <th style="min-width: 100px;">Status</th>
                                                <th style="min-width: 100px;">Clicks</th>
                                                <th class="no-sort" style="min-width: 200px;">Action</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            
                                           

                                            <?php

                                                foreach ($campaigns as $row) {
                                                    $href = "campaign_edit/".$row->id;
                                                    echo "<tr id='".$row->id."' ><td>".$row->id."</td>";
                                                    echo '<td><img src="'.$row->img.'" width="50" height="50" alt="image"> '.$row->text.'  <a href="'.$row->site_us_pc.'" target="_blank" class="btn waves-effect waves-light btn-xs btn-default"><i class="fa fa-link"></i></a>
                                                    </td>';
                                                    echo "<td>".$row->status."</td>";
                                                    echo "<td>".$row->total_click."</td>";
                                                    echo '<td>
                                                    <a href='.$href.' class="btn waves-effect waves-light btn-sm btn-primary text-white"><i class="fa fa-pencil"></i> EDIT</a>

                                                    <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" data-record-title="'.$row->text.'" data-toggle="modal" data-target="#confirm-delete" data-record-id="'.$row->id.'"><i class="fa fa-trash"></i> DELETE</button></td>
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

          <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          
                          <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      </div>
                      <div class="modal-body">
                          <p>You are about to delete <b><i class="title"></i></b> Campaign, this procedure is irreversible.</p>
                          <p>Do you want to proceed?</p>
                      </div>
                      <div class="modal-footer">
                        
                          <button type="button" class="btn btn-danger btn-ok">Delete</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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

        $('#myTable').DataTable( 
        {
            "displayLength": 100,
            "order": [
                    [0, 'desc']
                ],
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ]
        });

   $('#confirm-delete').on('click', '.btn-ok', function(e) {

        var $modalDiv = $(e.delegateTarget);
        var id = $(this).data('recordId');
        if (id < 0 || id == "") {
          alertbox("Error" , "Something Went Wrong.. please try again after refresh page" ,  "error");
        } else {

         
          var id = id;
          var dataOBJ = {
            'id': id
          }
          $.ajax({
            type: "POST",
            url: "campaign_delete_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Campaign Deleted Successfully" ,  "success");
                $("#table-body tr#" + id).remove();
              }
            },
            error: function() {
              alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");
             
            }
          });
        }
  
      $modalDiv.addClass('loading');
      setTimeout(function() {
        $modalDiv.modal('hide').removeClass('loading');
      }, 1000);

    });

  $('#confirm-delete').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.title', this).text(data.recordTitle);
    $('.btn-ok', this).data('recordId', data.recordId);
  });
    });
</script>