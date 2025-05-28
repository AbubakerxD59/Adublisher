
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Access Management for Publishers</h3>
                      
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
                                    <table id="myTable" class="table table-resposnsive table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th> Manage Access</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                        <?php
                                        foreach($publishers as $publisher)
                                        { ?>
                                            <tr> 
                                                <td> <?=$publisher['id'] ?> </td>
                                                <td><img src='<?=$publisher['img'] ?>' width='35' class='img-circle' alt='image'> <?=$publisher['name'] ?> </td>
                                                <td> <?=$publisher['username'] ?> </td>
                                                <td> <?=$publisher['status'] ?> </td>
                                                <td> <buttton name="<?=$publisher['id']?>" class="show_modal btn btn-sm btn-primary"> Assign Roles</buttton> </td>
                                            </tr>   
                                        <?php } ?>    
                                    </tbody>
                                 </table>  
                             </div>
                         </div>
                     </div>
                        </div>
                       <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Update Roles</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body"> 
                                
                                </div>
                                <div class="modal-footer">
                                  <button type="button" id="save" class="btn btn-default" data-dismiss="modal">Save</button>
                                </div>
                              </div>
                              
                            </div>
                        </div>
                         <div class="modal fade" id="error" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Update Roles</h4>
                                </div>
                                <div class="modal-body m-l-10"> 
                                <p>There is no data related to that user</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" id="" class="btn btn-default" data-dismiss="modal">Save</button>
                                </div>
                              </div>
                              
                            </div>
                        </div>
   

                </div>   
            </div>  
        </div>
        <?php $this->load->view('templates/admin/footer'); ?>

 <script src="<?=GeneralAssets ?>plugins/datatables/jquery.dataTables.min.js"></script>                                      
<script>

    $(document).ready(function(){
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
       
        var id='';
        var count=0;
        var actual_array=[];
        $(document).on('click','.show_modal',function(){
            id=$(this).attr('name');
        	$.ajax({
                url:'get_roles',
                type:'GET',
                data:{'user_id':$(this).attr('name')},
                success:function(res){
                    
                    // $('.modal-body').html('');
                	actual_array=[];
                	for (var i = 0; i< res.data.length; i++) {
                		actual_array.push(res.data[i].status);
                	}
                    
                    if(res.data.length == 0)                  //check either user has existing roles in database
                    {

                        $('.modal-body').html(''); 
                        $('#myModal').modal('show');  
                        $('.modal-body').html('<p> there is no data related to that user </p>');
                    }
                   	else
                    {
                        
                        $('.modal-body').html('');
                        $('#myModal').modal('show'); 
                        $('.modal-body').html(res.menu); 
                    }
                       count=res.count;                                          
                                             
                },
                error:function(xhr, ajaxOptions, errorThrown){
                	alertbox("Error" , "Something went wrong" ,  "error"); 
                }

            });
        }); 

    
    $(document).on('click','#save',function(){
        var roles=[];
        var modified=[];
        var roles_obj={};
        menues=0;
       
        if(count != 0 )
        {
            $('.check_status').each(function( index ) 
            {
                if(menues < count)
                {
                    if( ($(this).prop("checked"))==true)
                    {
                       roles_obj={
                            menu_id:$(this).attr('name'),
                            status:'Active',
                        };
                        modified.push('Active');
                        roles.push(roles_obj);
                    }
                    else
                    {
                        roles_obj={
                            menu_id:$(this).attr('name'),
                            status:'InActive',
                        };
                        modified.push('InActive')
                        roles.push(roles_obj); 
                    }
                    menues++;
                }

            });

            is_same=check_equal_arrays(actual_array,modified);
           	if(is_same==true)                                       //to check either change is made or not
           	{
           		alertbox("Information" , "Nothing is Changed" ,  "info");
           	}

            else
            {
                update_roles(roles,id)
		    }
        }
    else
    {
        alertbox("Warning" , "No roles defined for this user" ,  "warning");
    }
        
    });

    function check_equal_arrays(actual_array,modified)
    {
        var is_same = modified.length == actual_array.length && modified.every(function(element, index) {
                return element === actual_array[index]; 
        });
        return is_same;
    }

    function update_roles(roles_array,user_id)
    {
        $.ajax
            ({
                url:'update_rolls',                           //update the roles
                type:'GET',
                data:{'roles':roles_array,'user_id':user_id},
                success:function(data){
                    
                    if(data==true) 
                        alertbox("Success" , "Roles Updated Successfully" ,  "success");
                    else
                        alertbox("Error" , "Something went wrong" ,  "error");
                },
                error:function(xhr,ajaxOptions,errorThrown)
                {
                        alertbox("Error" , "Something went wrong" ,  "error");               
                }

            });
    }
});

</script>    