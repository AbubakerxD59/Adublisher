
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Default Domains</h3>
                      
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
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Default domain</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                  <?php

                                   foreach( $users as $row)
                                   {

                                    echo "<tr>";
                                    $domian_id = $row->domain_default;
                                   
                                      $allDomains = $this->db->query("SELECT * FROM domains WHERE status ='active'")->result();
                                  
                             
                                  

                                     echo "<td>".$row->name."</td>";
                                     echo "<td>".$row->username."</td>";
                                     echo '<td><form class="form-material m-t-0 p-0 row">
                                      <div class="form-group m-t-0  m-b-0 col-md-11">
                                     <select name="status" class="form-control m-t-0  m-b-0" id="default_'.$row->id.'" disabled="disabled">
                                     <option value="">N/A</option>';
                                     foreach ($allDomains as $row_d) {

                                        if($row_d->id ==  $domian_id){
                                          
                                          echo '<option value="'.$row_d->id.'" selected="selected" >'.$row_d->domain.'</option>';
                                          
                                        }else{
                                         
                                         echo '<option value="'.$row_d->id.'" >'.$row_d->domain.'</option>';
                                        }

                                       }    

                                    echo '</select></div></form></td>';
                                  echo '<td>
                                  <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" data-domain="'.$row->domain_default.'"> <i class="fa fa-pencil"></i> EDIT</button>

                                   <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'" data-domain="'.$row->domain_default.'"> <i class="fa fa-pencil"></i> SAVE</button>

                                    <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" data-domain="'.$row->domain_default.'"> <i class="fa fa-pencil"></i> CANCEL</button>

                                  </td>';
                                   echo "</tr>";
                                   }
                                  ?>
                                               
                                            
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
       $("#default_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();


   });

    $(".cancel").click(function(){

      id = $(this).data('id');
      $("#default_"+id).attr('disabled', 'disabled');
      
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();

   });


  $(".save").click(function(){

      id = $(this).data('id');
      default_ = $("#default_"+id).val();
    
      if($.trim(default_) == ""){
        alertbox("Failed" , "Please Select any valid domain" ,  "error");
        return false;
      }else{

      var dataOBJ = {
        'id': id,
        'domain_default':default_ 
      }
      $.ajax({
        type: "POST",
        url: "default_domain_user_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            alertbox("Success" , "Default domain updated Successfully" ,  "success");
            $("#default_"+id).attr('disabled', 'disabled');
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

    });
</script>