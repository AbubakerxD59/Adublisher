
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Features</h3>
                      
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
                               <button type="button" class="btn waves-effect waves-light btn-primary pull-right" data-toggle="modal" data-target="#addfeature" ><i class="fa fa-plus"></i> Add New  </button>
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NAME</th>
                                  
                                                <th class="no-sort" style="min-width: 140px;">Edit</th>
                                                <th class="no-sort">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
<?php
    foreach ($features as $row) {
      
        echo "<tr id='".$row->id."' >
        <td>
        ".$row->id."
        </td>";
        echo '<td>
        <form class="form-material m-t-0 p-0 row">
        <div class="form-group m-t-0  m-b-0 col-md-8">
        <input class="form-control form-control-line m-t-0  m-b-0" id="name_'.$row->id.'" value="'.$row->name.'" disabled="disabled" >    
        </div>
        <div class="form-group m-t-0  m-b-0 col-md-3">        
        <select name="status" class="form-control m-t-0  m-b-0" id="status_'.$row->id.'" disabled="disabled">';
          if($row->status == "active"){
            echo '<option value="active" selected="selected">Active</option>
             <option value="inactive">Inactive</option>';
          }else{
             echo '<option value="active" >Active</option>
             <option value="inactive" selected="selected">Inactive</option>';
          }
        echo '</select>
        </div>                              
        </form>
        </td>';
        echo '<td>
        <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" data-name="'.$row->name.'"> <i class="fa fa-pencil"></i> EDIT</button>
         <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'" data-name="'.$row->name.'"> <i class="fa fa-pencil"></i> SAVE</button>
          <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" data-name="'.$row->name.'"> <i class="fa fa-pencil"></i> CANCEL</button>
        </td>
       <td>
       <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" data-record-title="'.$row->name.'" data-toggle="modal" data-target="#confirm-delete" data-record-id="'.$row->id.'"><i class="fa fa-trash"></i> DELETE</button>
       </td>
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
                          <p>You are about to delete <b><i class="title"></i></b> Feature, this procedure is irreversible.</p>
                          <p>Do you want to proceed?</p>
                      </div>
                      <div class="modal-footer">
                         
                          <button type="button" class="btn btn-danger btn-ok">Delete</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>

          <div class="modal fade" id="addfeature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Add New Feature</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="name" class="control-label">Feature Name:</label>
                                                        <input class="form-control" id="name" name="name" />
                                                    </div> 
                                                    <div class="form-group">
                                                     
                                                      <label for="status" class="control-label">Feature Status:</label>
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


   $(".edit").click(function(){

      id = $(this).data('id');
       $("#name_"+id).removeAttr('disabled');
       $("#status_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();


   });

    $(".cancel").click(function(){

      id = $(this).data('id');
      $("#name_"+id).attr('disabled', 'disabled');
      $("#status_"+id).attr('disabled', 'disabled');
      
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();


   });


  $(".save").click(function(){

      id = $(this).data('id');
      name_ = $("#name_"+id).val();
      status_ = $("#status_"+id).val();
      if($.trim(name_) == ""){
        alertbox("Failed" , "Please entery Feature name" ,  "error");
        return false;
      }else{

      var dataOBJ = {
        'id': id,
        'name':name_ ,
        'status' : status_
      }
      $.ajax({
        type: "POST",
        url: "feature_edit_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            alertbox("Success" , "Feature updated Successfully" ,  "success");
            $("#name_"+id).attr('disabled', 'disabled');
            $("#status_"+id).attr('disabled', 'disabled');
            $('.save_'+id).hide();
            $('.cancel_'+id).hide();
            $('.edit_'+id).show();
          }
        },
        error: function() {
           alertbox("Information" , "Nothing Has been changed, Edit values and try again" ,  "info");
        }
      });

     

      }
     


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
            url: "feature_delete_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Feature Deleted Successfully" ,  "success");
                $("#table-body tr#" + id).remove();
              }
            },
            error: function() {
              alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");
             
            }
          });
        }

      setTimeout(function() {
        $modalDiv.modal('hide').removeClass('loading');
      }, 1000);

    });

  $('#confirm-delete').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('.title', this).text(data.recordTitle);
    $('.btn-ok', this).data('recordId', data.recordId);
  });



  $('#addfeature').on('click', '.btn-primary', function(e) {

        var $modalDiv = $(e.delegateTarget);
        var name_ = $("#name").val();
        var status  = $("#status").val();
       if($.trim(name_) == ""){
            alertbox("Failed" , "Please entery Feature name" ,  "error");
            return false;
          }
          else{

          var id = id;
          var dataOBJ = {
            'name': name_,
            'status' : status
          }
          $.ajax({
            type: "POST",
            url: "feature_add_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Feature Added Successfully" ,  "success");
               
              }
              setTimeout(function(){

                location.reload();

              }, 2500);
            },
            error: function() {
              alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");
             
            }
          });
          setTimeout(function() {
            $modalDiv.modal('hide').removeClass('loading');
          }, 1000);
    }
    });


    });
</script>