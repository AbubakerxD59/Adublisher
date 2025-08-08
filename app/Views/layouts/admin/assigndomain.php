
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Publisher Domains</h3>
                      
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
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Active Domain</th>
                                                <th>Assign Domains</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                  <?php

                                   foreach( $users as $row)
                                   {

                                    $domian_id = $row->domain;
                                   
                                $allDomains = $this->db->query("SELECT * FROM domains WHERE status ='active'")->result();
                                $userDomains = $this->db->query("SELECT * FROM user_domains WHERE user_id= ".$row->id)->result();
                                $uds_row = "";
                                foreach($userDomains as $uds){
                                  $uds_row .= $uds->domain_id."_";
                                }
                               // $uds_row =  substr(trim($uds_row), 0, -1);

                                    echo "<tr>";
                                    echo "<td>".$row->id."</td>";
                                    echo "<td>".$row->name."<br><a  href='#demo".$row->id."' class='btn btn-primary btn-xs' data-toggle='collapse'>View Assigned Domains (".count($userDomains).")</a>
                                    <div id='demo".$row->id."' class='collapse col-md-12' style='width:200px;'>";

                                    if(count($userDomains) > 0){
                                      foreach ($userDomains as $uds) {
                                    echo "<small class='text-muted text-center'>"
                                    .$this->db->query("SELECT * FROM domains WHERE id = ".$uds->domain_id)->row()->domain .
                                     "</small><br>";
                                      }
                                    }else{
                                      echo "<small class='text-danger text-center'>No domain assigned, using default or system domain</small>";
                                    }

                                     

                                     echo "</div></td>";
                                     echo "<td>".$row->username."</td>";
                                     echo '<td><form class="form-material m-t-0 p-0 row">
                                    <div class="form-group m-t-0  m-b-0 col-md-7">
                                     <select name="status" class="form-control m-t-0  m-b-0" id="domain_'.$row->id.'" disabled="disabled">
                                     <option value="">N/A</option>';
                                     foreach ($allDomains as $row_d) {

                                        if($row_d->id ==  $domian_id){
                                          
                                          echo '<option value="'.$row_d->id.'" selected="selected" >'.$row_d->domain.'</option>';
                                          
                                        }else{
                                         
                                         echo '<option value="'.$row_d->id.'" >'.$row_d->domain.'</option>';
                                        }

                                       }    

                                  echo '</select></div>';
                                  echo '<div class="form-group m-t-0  m-b-0 col-md-5">
                                  <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat edit edit_'.$row->id.'" data-id="'.$row->id.'" data-domain="'.$row->domain.'"> <i class="fa fa-pencil"></i> EDIT</button>

                                   <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-success text-white save_'.$row->id.' save" data-id="'.$row->id.'" data-domain="'.$row->domain.'"> <i class="fa fa-pencil"></i> SAVE</button>

                                    <button style="display:none" type="button" class="btn waves-effect waves-light btn-sm btn-danger text-white cancel_'.$row->id.' cancel" data-id="'.$row->id.'" data-domain="'.$row->domain.'"> <i class="fa fa-pencil"></i> CANCEL</button>

                                  </div></form></td>';

                                  echo '<td> <button type="button" class="btn waves-effect waves-light btn-sm btn-primary text-white edit-cat assign assign_'.$row->id.'"  data-toggle="modal" data-target="#adddomain" data-id="'.$row->id.'"  data-domains="'.$uds_row.'" > <i class="fa fa-globe"></i> Assign Domains</button>
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

        
          <div class="modal fade" id="adddomain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Assiging Domains</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                  <div class="row demo-checkbox">
                                                    <?php
                                                    foreach ($allDomains as $row_d) {

                                                      echo '<div  class="form-group m-t-0  m-b-0 col-md-6" >
                                                            <input type="checkbox" data-id="'.$row_d->id.'" id="md_checkbox_'.$row_d->id.'" class="filled-in chk-col-deep-purple all_checkboxes" >
                                                            <label for="md_checkbox_'.$row_d->id.'">'.$row_d->domain.'</label>
                                                            </div>';
                                                        }    
                                                    ?>
                                                  
                                                  </div>

                                                  <input type="text" id="userid" class="hide" >
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary btn-ok">Save</button>
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
       $("#domain_"+id).removeAttr('disabled');
       $("#status_"+id).removeAttr('disabled');
      $(this).hide();
      $('.save_'+id).show();
      $('.cancel_'+id).show();


   });

    $(".cancel").click(function(){

      id = $(this).data('id');
      $("#domain_"+id).attr('disabled', 'disabled');
      $("#status_"+id).attr('disabled', 'disabled');
      
      $(this).hide();
      $('.save_'+id).hide();
      $('.edit_'+id).show();


   });


  $(".save").click(function(){

      id = $(this).data('id');
      domain_ = $("#domain_"+id).val();
     
      if($.trim(domain_) == ""){
        alertbox("Failed" , "Please Select a Valid domain" ,  "error");
        return false;
      }else{

      var dataOBJ = {
        'id': id,
        'domain':domain_ ,
      }
      $.ajax({
        type: "POST",
        url: "active_domain_user_rest",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            alertbox("Success" , "User Active domain updated Successfully" ,  "success");
            $("#domain_"+id).attr('disabled', 'disabled');
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



$('#adddomain').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    var domains_str = data.domains;
    $('#userid').val(data.id);
    $(".all_checkboxes").prop('checked',false);
    if(domains_str.indexOf('_') > -1){
      var domains = domains_str.split("_");
    }
    else{
      var domains = data.domains;
    }
    $.each(domains, function( index, value ) {
 
      if(value){
        // alert( index + ": " + value );
         $("#md_checkbox_"+value).prop('checked',true);
      }
    });
    
  });

   $('#adddomain').on('click', '.btn-ok', function(e) {

        var $modalDiv = $(e.delegateTarget);
        var id = $("#userid").val();
        if (id < 0 || id == "") {
          alertbox("Error" , "Something Went Wrong.. please try again after refresh page" ,  "error");
        } 
        else {

          // $(".all_checkboxes").prop('checked',false);
         var domains = "";
          $.each($('.all_checkboxes:checkbox:checked'), function (index, elem ) {

             if(elem){
           
                domains += $(elem).data("id")+ "_";
                
              }

            });
          domains = domains.slice(0,-1);
         
          var dataOBJ = {
            'id': id,
            'domains' : domains
          }
 


          $.ajax({
            type: "POST",
            url: "update_user_domains_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "User domains updated Successfully" ,  "success");
                setTimeout(function() {
                    location.reload();
                  }
                  , 2000);
                
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

});

</script>