
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Categories</h3>
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
                        
                        <button type="button" class="btn waves-effect waves-light btn-primary pull-right" data-toggle="modal" data-target="#addcategory" ><i class="fa fa-plus"></i> Add New  </button>
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th class="no-sort">Edit</th>
                                                <th class="no-sort">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
<?php
    foreach ($categories as $row) {
      
        echo "<tr id='".$row->id."' >
        <td>
        ".$row->id."

        </td>";
        echo '<td>
        <form class="form-material" style="padding:0px!important;">
        <input class="form-control form-control-line" id="category_'.$row->id.'" value="'.$row->categury.'" disabled="disabled" >
        
        </form>
        </td>';
        echo '<td>
        <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" data-category="'.$row->categury.'"> <i class="fa fa-pencil"></i> EDIT</button>

         <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'" data-category="'.$row->categury.'"> <i class="fa fa-pencil"></i> SAVE</button>

          <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" data-category="'.$row->categury.'"> <i class="fa fa-pencil"></i> CANCEL</button>

        </td>
       <td>
       <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" data-record-title="'.$row->categury.'" data-toggle="modal" data-target="#confirm-delete" data-record-id="'.$row->id.'"><i class="fa fa-trash"></i> DELETE</button>
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
                          <p>You are about to delete <b><i class="title"></i></b> Category, this procedure is irreversible.</p>
                          <p>Do you want to proceed?</p>
                      </div>
                      <div class="modal-footer">
                         
                          <button type="button" class="btn btn-danger btn-ok">Delete</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>

          <div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Add New Category</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Category:</label>
                                                        <input class="form-control" id="categury" name="categury" />
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
       $("#category_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();


   });

    $(".cancel").click(function(){

      id = $(this).data('id');
      $("#category_"+id).attr('disabled', 'disabled');
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();


   });


  $(".save").click(function(){

      id = $(this).data('id');
      category = $("#category_"+id).val();
      if($.trim(category) == ""){
        alertbox("Failed" , "Please entery Category name" ,  "error");
        return false;
      }else{

      var dataOBJ = {
        'id': id,
        'categury':category ,
      }
      $.ajax({
        type: "POST",
        url: "category_edit_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response) {
            alertbox("Success" , "Category updated Successfully" ,  "success");
            $("#category_"+id).attr('disabled', 'disabled');
           
            $('.cancel_'+id).hide();
            $('.save_'+id).hide();
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

         
         // var id = id;
          var dataOBJ = {
            'id': id
          }
          $.ajax({
            type: "POST",
            url: "category_delete_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Category Deleted Successfully" ,  "success");
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



  $('#addcategory').on('click', '.btn-primary', function(e) {

        var $modalDiv = $(e.delegateTarget);
        var category = $("#categury").val();
       if($.trim(category) == ""){
            alertbox("Failed" , "Please entery Category name" ,  "error");
            return false;
          }
          else{

          var id = id;
          var dataOBJ = {
            'categury': category
          }
          $.ajax({
            type: "POST",
            url: "category_add_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Category Added Successfully" ,  "success");
               
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