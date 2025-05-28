
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Currency Settings</h3>
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
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Flag</th>
                                                <th>Country</th>
                                                <th class="no-sort">Rate Per Click</th>
                                                <th style="min-width: 150px;" class="no-sort">Edit</th>
                                        
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
<?php
    foreach ($countries as $row) {
      
        echo "<tr id='".$row->id."' >
        <td>
        ".$row->id."

        </td>
        <td>
        <img src='assets/general/flags/".$row->code.".png'>
        </td>
        <td>
        
        ".$row->name."

        </td>
        ";
        echo '<td>
        <form class="form-material" style="padding:0px!important;">
        <input class="form-control form-control-line" type="number" id="country_'.$row->id.'" value="'.$row->rate.'" disabled="disabled" >
        
        </form>
        </td>';
        echo '<td>
        <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" data-country="'.$row->name.'"> <i class="fa fa-pencil"></i> EDIT</button>

         <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'" data-country="'.$row->name.'"> <i class="fa fa-pencil"></i> SAVE</button>

          <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" data-country="'.$row->name.'"> <i class="fa fa-pencil"></i> CANCEL</button>

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
            "displayLength": 50,
            "order": [
                    [0, 'asc']
                ],
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ]
        });


  $('#myTable tbody').on('click', '.edit', function(){

      id = $(this).data('id');
       $("#country_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();


   });

    $('#myTable tbody').on('click', ".cancel", function(){

      id = $(this).data('id');
      $("#country_"+id).attr('disabled', 'disabled');
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();


   });


  $('#myTable tbody').on('click', ".save", function(){

      id = $(this).data('id');
      amount = $("#country_"+id).val();
      if($.trim(amount) == ""){
        alertbox("Failed" , "Please entery Category name" ,  "error");
        return false;
      }else{

      var dataOBJ = {
        'id': id,
        'amount':amount ,
      }
      $.ajax({
        type: "POST",
        url: "country_edit_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response) {
            alertbox("Success" , "Country Rate updated Successfully" ,  "success");
            $("#country_"+id).attr('disabled', 'disabled');
              $('#myTable tbody .save_'+id).hide();
              $('#myTable tbody .cancel_'+id).hide();
              $('#myTable tbody .edit_'+id).show();
          }
        },
        error: function() {
            alertbox("Information" , "Nothing Has been changed, Edit values and try again" ,  "info");
        }
      });
      }
   });








    });
</script>