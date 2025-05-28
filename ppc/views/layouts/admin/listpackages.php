
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Packages</h3>
                      
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
                               <button type="button" class="btn waves-effect waves-light btn-primary pull-right" data-toggle="modal" data-target="#addPackage" ><i class="fa fa-plus"></i> Add New  </button>
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Package Details</th>
                                                
                                  
                                                <th class="no-sort" style="min-width: 140px;">Edit</th>
                                                <th class="no-sort">Features</th>
                                                <th class="no-sort">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
<?php
    foreach ($packages as $row) {
      
        echo "<tr id='".$row->id."' >
        <td>
        ".$row->id."

        </td>";
        echo '<td>
        <form class="form-material m-t-0 p-0 row">
        <div class="form-group m-t-0  m-b-0 col-md-6">
        <input class="form-control form-control-line m-t-0  m-b-0" id="name_'.$row->id.'" value="'.$row->name.'" disabled="disabled" >    
        </div>
        <div class="form-group m-t-0  m-b-0 col-md-2">
        <input class="form-control form-control-line m-t-0  m-b-0" id="price_'.$row->id.'" value="'.$row->price.'" disabled="disabled" >    
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
        <button type="button" class="btn waves-effect waves-light btn-xs btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" data-name="'.$row->name.'" data-price="'.$row->price.'"> <i class="fa fa-pencil"></i> EDIT</button>

         <button style="display:none" type="button" class="btn waves-effect waves-light btn-xs btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'" data-name="'.$row->name.'" data-price="'.$row->price.'"> <i class="fa fa-pencil"></i> SAVE</button>

          <button style="display:none" type="button" class="btn waves-effect waves-light btn-xs btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" data-name="'.$row->name.'"> <i class="fa fa-pencil" data-price="'.$row->price.'"></i> CANCEL</button>

        </td>
        <td>
        <button type="button" class="btn waves-effect waves-light btn-xs btn-success features" data-record-title="'.$row->name.'" data-id="'.$row->id.'"><i class="fa fa-link"></i> FEATURES</button>
        </td>
       <td>
       <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" data-record-title="'.$row->name.'" data-toggle="modal" data-target="#confirm-delete" data-record-id="'.$row->id.'"><i class="fa fa-trash"></i> DELETE</button>
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
                          <p>You are about to delete <b><i class="title"></i></b> Package, this procedure is irreversible.</p>
                          <p>Do you want to proceed?</p>
                      </div>
                      <div class="modal-footer">
                         
                          <button type="button" class="btn btn-danger btn-ok">Delete</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Update Package Features</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body"> 
                                <div class="table-responsive m-10">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Feature</th>
                                                <th>Limit/Month</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="feature-modal-body">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                              
                            </div>
                        </div>
                        
   


          <div class="modal fade" id="addPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Add New Package</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="name" class="control-label">name:</label>
                                                        <input class="form-control" id="name" name="name" />
                                                    </div> 
                                                    <div class="form-group">
                                                        <label for="price" class="control-label">price:</label>
                                                        <input class="form-control" id="price" name="price" />
                                                    </div> 
                                                    <div class="form-group">
                                                     
                                                      <label for="name" class="control-label">Package Status:</label>
                                                      <select name="status" class="form-control" id="status">
                                                           <option value="active">Active</option>
                                                           <option value="inactive">Inactive</option>
                                                      </select>
                                                  </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button"  id="addnewpackage" class="btn btn-primary">Save</button>
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
      $("#price_"+id).removeAttr('disabled');
       $("#status_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();


   });

    $(".cancel").click(function(){

      id = $(this).data('id');
      $("#name_"+id).attr('disabled', 'disabled');
      $("#price_"+id).removeAttr('disabled');
      $("#status_"+id).attr('disabled', 'disabled');
      
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();


   });

   $(".features").click(function(){
   
   var pid = $(this).data('id');
        	$.ajax({
                url:'get_package_features_rest?pid='+$(this).data('id'),
                type:'GET',
                data:{'pid':$(this).data('id')},
                success:function(res){
                  $('#feature-modal-body').html('');
                  var content = '';
                  $.each(res.data, function (i, e) { 
                  var active = '' ;
                  var inactive = '' ;

                  if(e.status != 'active'){
                    var inactive = 'selected' ;
                  }else{
                    var active = 'selected' ;
                  }
                  content += 
                  '<tr><td>'+e.id+'</td>'+
                  '<td>'+e.name+'</td>'+
                  '<td>'+
                  '<input  type="number" class="m-t-0  m-b-0 input-sm package_feature_change"  style="width:80px;" data-action="feature_limit" value="'+e.limit+'" data-fid="'+e.id+'" data-pid="'+pid+'" >'+   
                  '</td>'+
                  '<td>'+       
                  '<select  style="width:80px;"  class="m-t-0  m-b-0 input-sm package_feature_change" data-action="status" data-fid="'+e.id+'" data-pid="'+pid+'" >'+
                      '<option value="active" '+active+'>Active</option>'+
                      '<option value="inactive" '+inactive+'>Inactive</option>'+
                  '</select>'+
                  '</td></tr>';                              
                  });
                  $('#feature-modal-body').html(content);
                        $('#myModal').modal('show'); 
                },
                error:function(xhr, ajaxOptions, errorThrown){
                	alertbox("Error" , "Something went wrong" ,  "error"); 
                }

            });
   })
   $(document).on( 'change' , '.package_feature_change' , function(){
     elem = $(this);
     var action = elem.data('action');
     var pid = elem.data('pid');
     var fid = elem.data('fid');
     var value = elem.val();
     var dataOBJ = {
        'action': action,
        'pid':pid ,
        'fid':fid ,
        'value' : value
      }
      $.ajax({
        type: "POST",
        url: "package_features_edit_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            alertbox("Success" , "Package updated Successfully" ,  "success");
          }
        },
        error: function() {
           alertbox("Information" , "Nothing Has been changed, Edit values and try again" ,  "info");
        }
      });

   });

  $(".save").click(function(){

      id = $(this).data('id');
      name_ = $("#name_"+id).val();
      price_ = $("#price_"+id).val();
      status_ = $("#status_"+id).val();
      if($.trim(name_) == ""){
        alertbox("Failed" , "Please entery package name" ,  "error");
        return false;
      }else{

      var dataOBJ = {
        'id': id,
        'name':name_ ,
        'price':price_ ,
        'status' : status_
      }
      $.ajax({
        type: "POST",
        url: "package_edit_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            alertbox("Success" , "name updated Successfully" ,  "success");
            $("#name_"+id).attr('disabled', 'disabled');
            $("#price_"+id).attr('disabled', 'disabled');
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
            url: "package_delete_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Package Deleted Successfully" ,  "success");
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
  $('#addPackage').on('click', '.btn-primary', function(e) {

        var $modalDiv = $(e.delegateTarget);
        var name_ = $("#name").val();
        var price_ = $("#price").val();
        var status  = $("#status").val();
       if($.trim(name_) == ""){
            alertbox("Failed" , "Please entery package name" ,  "error");
            return false;
          }
          else{

          var id = id;
          var dataOBJ = {
            'name': name_,
            'price': price_,
            'status' : status
          }
          $.ajax({
            type: "POST",
            url: "package_add_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "package Added Successfully" ,  "success");
               
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