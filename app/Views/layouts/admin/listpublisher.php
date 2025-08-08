
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Manage Publishers</h3>
                      
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
                                                <th style="width:400px;">User</th>
                                                <th class="no-sort">Manage</th>
                                                <th class="no-sort" style="min-width: 130px;">Edit</th>
                                                <th class="no-sort">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
<?php
    foreach ($users as $row) {
      
        echo "<tr id='".$row->id."' >
        <td>
        ".$row->id."

        </td>
        <td>
       <a title='Open Profile and Adjust settings for this user' target='_blank' href='publishers-profiles?profile=".$row->id."'> <img src='".$row->img."' width='35' class='img-circle' alt='image'>
        <strong>".ucfirst($row->name)." <i class='fa fa-link'></i></strong> </a> <br><a  href='#demo".$row->id."' class='btn btn-primary btn-xs' data-toggle='collapse'>Quick View Details</a>
        <div id='demo".$row->id."' class='collapse row' style='width:450px;'>";

echo '<div class="col-md-12 col-lg-12 col-xlg-12">
            <div class="ribbon-wrapper card">
                           <div class="row">
                         <div class="ribbon ribbon-bookmark  ribbon-primary ">'.$row->name.'</div>
                        <div class="col-md-4 col-lg-2 text-center">
                            <a href="app-contact-detail.html"><img src="'.$row->img.'" alt="user" class="img-circle img-responsive"></a>
                        </div>
                        <div class="col-md-4 col-lg-5">
                            <address>
                                <small class="text-muted">Name: '.$row->name.'</small><br>
                                <small class="text-muted">Username: '.$row->username.'</small>
                               
                                
                            </address>
                        </div>
                        <div class="col-md-4 col-lg-5">
                          
                            <address>
                                 <button class="btn btn-circle btn-secondary"><a href="tel:'.$row->ph.'"><i class="fa fa-phone"></i></a></button>
                                  <button class="btn btn-circle btn-secondary"><a href="mailto:'.$row->email.'"><i class="fa fa-envelope-open-o"></i></a></button>
                                <button class="btn btn-circle btn-secondary"><a href="'.$row->fbprofile.'" target="_blank"><i class="fa fa-facebook"></i></a></button>
                              
                            </address>
                        </div>
                         <div class="col-md-12 col-lg-12">
                            <address>
                             <small class="text-muted">Email: '.$row->email.'</small><br>
                                <small class="text-muted">Phone: '.$row->ph.'</small><br>
                                 <small class="text-muted">FB Profile: '.$row->fbprofile.'</small><br>
                                <small class="text-muted">FB Page: '.$row->fbpage.'</small>
                            </address>
                        </div>
                    </div>
              
            </div>
            </div>';
        echo "</div>
        </td>";
        echo '<td>
        <form class="form-material m-t-0 p-0 row">

        <div class="form-group m-t-0  m-b-0 col-md-6">        
        <select name="status" class="form-control m-t-0  m-b-0" id="status_'.$row->id.'" disabled="disabled">';
        $status = array('approve' => 'Approve' , 'disapprove'=> 'Disapprove' , 'pending' => 'Pending' , 'ban'=> 'Ban');
        foreach($status  as $key => $status){
          $selected='';
          if($key == $row->status){

               $selected='selected="selected"';
          }

            echo '<option value="'.$key.'"  '.$selected.' >'.$status.'</option>';

          }
        echo '</select>
        </div>  
        <div class="form-group m-t-0  m-b-0 col-md-5"> 
        <select name="acm" class="form-control m-t-0  m-b-0" id="acm_'.$row->id.'" disabled="disabled">';
        
         foreach($accountmanager as $acm){
          $selected='';
          if($acm->id == $row->acm_id){

               $selected='selected="selected"';
          }

            echo '<option value="'.$acm->id.'"  '.$selected.' >'.$acm->name.'</option>';

          }


        echo ' </select> </div>
        </form>
        </td><td>
        <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" > <i class="fa fa-pencil"></i> EDIT</button>

         <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'"  data-email="'.$row->email.'"  data-name="'.$row->name.'"  > <i class="fa fa-pencil"></i> SAVE</button>

          <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" > <i class="fa fa-pencil"></i> CANCEL</button>

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
                          <p>You are about to delete <b><i class="title"></i></b> Publisher, this procedure is irreversible.</p>
                          <p>Do you want to proceed?</p>
                      </div>
                      <div class="modal-footer">
                         
                          <button type="button" class="btn btn-danger btn-ok">Delete</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>

      <div class="modal fade" id="notificationemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Status Change Email</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="emailcontent" class="control-label">Notification Text:</label>
                                                        <textarea class="form-control" rows="10" id="emailcontent" name="emailcontent"></textarea> 
                                                    </div> 
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<input type="text" id="previous_status" style="display: none;">
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


    $('#myTable tbody').on('click', ".edit", function(){

      id = $(this).data('id');
       $("#acm_"+id).removeAttr('disabled');
       $("#status_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();
 
      status = $('#myTable tbody #status_'+id).val();
       $("#previous_status").val(status);

   });

    $('#myTable tbody').on('click', ".cancel", function(){

      id = $(this).data('id');
      $("#acm_"+id).attr('disabled', 'disabled');
      $("#status_"+id).attr('disabled', 'disabled');
      
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();


   });


   $('#myTable tbody').on('click', ".save", function(){

      id = $(this).data('id');
      name = $(this).data('name');
      email = $(this).data('email');
      acm_ = $("#acm_"+id).val();
      status_ = $("#status_"+id).val();

      previous_status = $("#previous_status").val();

      if(previous_status != status_){

        $("#notificationemail").modal("show");
        if(status_ == "disapprove"){
              $("#emailcontent").val("Hi "+name+",\n\n" + 

              "Thank you for submitting your information to Adublisher. Unfortunately it wasn’t approved.We would need more information to approve your account. Please signup again and make sure to provide these details. \n" +
              "1- On your page post this status Like Our Page \n"+ 
              "2- On signup Page, please upload your page insights photo.\n"+
             

              "You can Sign up again with updated information and we would be glad to review your account again.\n\n"+

              "Regards,\n"+
              "Adublisher Team.");
        }
          
        else  if(status_ == "ban"){
                $("#emailcontent").val("Hi "+name+",\n\n" + 

                "Thank you for submitting your information to Adublisher. Unfortunately it Ban for the following reason: \n" +
                "1-\n"+ 
                "2-\n"+
                "3-\n" +


                "You can contact support to assist you.\n\n"+

                "Regards,\n"+
                "Adublisher Team.\n\n");
        }
        
        else  if(status_ == "approve"){
                $("#emailcontent").val("Hi "+name+",\n\n" + 

                "Congratulations Your Account has been approved. NOW! You can login to www.adublisher.com\n\n"+
                "Regards,\n"+
                "Adublisher Team.\n\n");
        }
         else  if(status_ == "pending"){
                $("#emailcontent").val("Hi "+name+",\n\n" + 

                "Thank you for submitting your information to Adublisher. Your Account is under review once we verify all your information we will update you via EMAIL. \n\n"+
                "Regards,\n"+
                "Adublisher Team.\n\n");
        }

        $('#notificationemail').on('click', '.btn-primary', function(e) {

          message = $("#emailcontent").val();
         if( message == ""){
           alertbox("Error" , "Please Provide message to send publisher" ,  "error");
         }else{

          var dataOBJ = {
          'id': id,
          'acm_id':acm_ ,
          'status' : status_,
          'message' : message,
          'email' : email
        }
        $.ajax({
          type: "POST",
          url: "publisher_edit_rest",
          data: dataOBJ,
          dataType: "json",
          success: function(response) {
            if(response.status){
              alertbox("Success" , "Publisher Updated And notification sent Successfully" ,  "success");
              $("#acm_"+id).attr('disabled', 'disabled');
              $("#status_"+id).attr('disabled', 'disabled');
              $('.save_'+id).hide();
              $('.cancel_'+id).hide();
              $('.edit_'+id).show();
            
            $('#notificationemail').modal("hide");
            }

          },
          error: function() {
             alertbox("Information" , "Nothing Has been changed, Edit values and try again" ,  "info");
          }
        });

         }
        });


      }else{
          var dataOBJ = {
          'id': id,
          'acm_id':acm_ ,
          'status' : status_,
          'message' : '',
           'email' : email
        }
        $.ajax({
          type: "POST",
          url: "publisher_edit_rest",
          data: dataOBJ,
          dataType: "json",
          success: function(response) {
            if (response.status) {
              alertbox("Success" , "publisher updated Successfully" ,  "success");
              $("#acm_"+id).attr('disabled', 'disabled');
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
            url: "publisher_delete_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "User Deleted Successfully" ,  "success");
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





    });
</script>