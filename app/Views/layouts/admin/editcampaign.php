<script src="<?=GeneralAssets ?>plugins/angular/managecampaignrates.js"></script>
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper"  ng-controller="adubdashboard">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Edit Campaign</h3>
                      
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
                  
                     <div class="col-md-6 col-xlg-9">
                        <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header ">
                                <h4 class="card-title m-b-0">Edit Campaign </h4>
                                <i class="fa fa-cog  fa-spin fa-fw pull-right" id="loader" style="display: none"></i>
                            </div>
                            <div class="card-body b-t collapse show" style="">
                                       
                                
                            <form class="m-t-40 form-material" novalidate id="formdata">
                                <div class="row">
                                      
                                       <input  name="id" id="id" type="hidden" value="<?php echo $campaign->id; ?>" >

                                        <div class="form-group col-md-12 m-b-5">
                                            <label class="m-b-0">Link</label>
                                            <input class="form-control" name="cpuspc" required data-validation-required-message="This field is required" id="cpuspc" type="text" value="<?php echo $campaign->site_us_pc; ?>" >
                                        </div>
                                       
                                   
                                  
                                    <div class="form-group col-md-12 m-b-5">
                                            <label class="m-t-20">Title</label>
                                            <input class="form-control" name="cpname" id="cpname"  required data-validation-required-message="This field is required" type="text" value="<?php echo $campaign->text; ?>">
                                        </div>
                                       <div class="form-group col-md-12 m-b-5">
                                            <label class="m-t-20">Image Link</label>
                                            <input class="form-control" name="cpimg" id="cpimg" required data-validation-required-message="This field is required" type="text"  value="<?php echo $campaign->img; ?>">
                                        </div>

                                   
                                       <div class="form-group col-md-4 m-b-5">
                                            <label class="m-t-20">Status</label>
                                            <select name="cpstatus" class="form-control">
                                                

                                         <?php
                                            if($campaign->status == 'enable'){
                                                ?>

                                                 <option value="enable" selected="selected">Enable</option>
                                                 <option value="disable" >Disable</option>

                                                <?php

                                            }
                                            else{

                                                ?>
                                                  <option value="enable" >Enable</option>
                                                 <option value="disable" selected="selected">Disable</option>
                                                <?php
                                            }
                                            ?>

                                            </select>
                                        </div>
                                  
                                     <div class="form-group col-md-4 m-b-5">
                                        <label class="m-t-20">Category</label>
                                        <select name="cpcat" class="form-control">
                                            <?php
                                           
                                            foreach($categories as $row)
                                            {
                                                if($campaign->categury == $row->id){

                                                 echo'<option  selected="selected" value="'.$row->id.'">'.$row->categury.'</option>';
                                                }else{
                                                     echo'<option value="'.$row->id.'">'.$row->categury.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                  
                                         <div class="form-group col-md-4 m-b-5">
                                            <label class="m-t-20">Star</label>
                                            <select name="star" class="form-control">
                                            <?php
                                            if($campaign->star == true){
                                                ?>
                                                <option value="false">No</option>
                                                 <option value="true" selected="selected">Yes</option>

                                                <?php

                                            }
                                            else{

                                                ?>
                                                  <option selected="selected" value="false">No</option>
                                                 <option value="true" >Yes</option>
                                                <?php
                                            }
                                            ?>
                                                
                                            </select>
                                        </div>
                                  
                                       
                                       <div class="form-group col-md-12 m-b-0 p-10" style="align-self: flex-end;">
                                            <input class="btn btn-primary pull-right" value="Save" type="submit">
                                        </div>
                                
                            </div>
                        </form>
                                
    
                                
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                     <div class="col-md-4 col-xlg-3">
                      <div class="row">
                        <div class="col-md-12">
                           <div class="card earning-widget">
                                <div class="card-header">
                                    <div class="card-actions">
                                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                                     </div>
                                    <h4 class="card-title m-b-0">RATES SETTINGS</h4>
                                </div>
                               <?php
                               $checked_yes = "";
                               $checked_def = "";
                               if($campaign->rates_priority == "yes"){
                                    $checked_yes = "checked";
                               }else{
                                    $checked_def = "checked";
                               }
                              
                               ?>
                                <div class="card-body b-t collapse show" style="">
                                     <div class="form-group">       
                                     <div class="radio">
                                        <label> &nbsp; <input type="radio" name="optradio" class="optradio"  value="yes" <?=$checked_yes?>> &nbsp; USE CAMPAIGN SPECIFIC RATES</label>
                                         &nbsp;&nbsp;
                                         <button class="btn btn-sm btn-primary pull-right"  id="setuserrates" ><i class="fa fa-pencil"></i> Set Rates</button>
                                        </div>

                                        <div class="radio">
                                          <label> &nbsp; <input type="radio" class="optradio" name="optradio"  value="default" <?=$checked_def?>> &nbsp; USE SYSTEM RATES</label>
                                        </div>

                                </div>
                                </div>
                            </div>
                            
                          </div>   
                          <div class="col-md-12">
                           <!-- Column -->
                            <div class="card earning-widget">
                                <div class="card-header">
                                    <div class="card-actions">
                                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                                     </div>
                                    <h4 class="card-title m-b-0">Image Preview</h4>
                                </div>
                                <div class="card-body b-t collapse show" style="">
                                     <img  width="340px" height="305px" id="cpimage" src="<?php echo $campaign->img; ?>">
                                </div>
                            </div>
                        <!-- Column -->
                          
                          </div>
                      </div>

                        

                    </div>
                 
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
              <div class="modal fade" id="userRates" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">CAMPAIGN'S RATE SETTINGS</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-footer">
          <button type="button" id="saverates" class="btn btn-primary" >Save</button>
        </div>
        <div class="modal-body">
            <table id="myTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th class="no-sort">Rate Per Click</th>                                        
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in ratestable">
                         <td><img src='../assets/general/flags/{{item.code}}.png'> {{item.name}}</td>
                         <td><input data-cid={{item.id}}  class="ratesinputs input-sm" value="{{item.rate}}" ></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
      
      </div>

    </div>
</div>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
 <?php $this->load->view('templates/admin/footer'); ?>
 <script src="<?=AdminAssets ?>js/campaign_edit.js"></script>
<script>       
    $(function () {

 $(document).on('click','#saverates',function(){
    
    var ratesarray = [];
    $(".ratesinputs").each(function() {
         ratesarray.push({id : $(this).data('cid') , value : $(this).val()});
    });
    
     $.ajax({
            url:'<?=BASEURL?>add_update_rate',
            type:'POST',
            data :{res_id : $('#id').val(), identifier : 'link',  rates : JSON.stringify(ratesarray)},
            success : function(data){
             alertbox("Success" , "Settings Updated Successfully" ,  "success");
             $("#userRates").modal('hide');   
            },
            error:function(data)
            {
                
             alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");

            }
        });
    
});

 $(document).on('click','#setuserrates',function(){
    $("#userRates").modal('show');
 });
        
 $(document).on('click','.optradio',function(){
     
      
        value  =  $(this).val();
        
        if(value == "yes"){
            $("#setuserrates").show();
        }else{
             $("#setuserrates").hide();
        }
        $.ajax({

            url:'<?=BASEURL?>update_rate_settings',
            type:'POST',
            data : {value : value, identifier : 'link' , res_id : $('#id').val()},
            success : function(data){
               
              if(value == "yes"){
                  
                    alertbox("Success" , "Settings Updated Successfully" ,  "success");
                    setTimeout(function(){
                        
                        $("#setuserrates").click();
                        
                    }, 1500);
                    
                }else{
                    
                    alertbox("Success" , "Settings Updated Successfully" ,  "success");
                }  
            },
            error:function(data)
            {
             alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");
            }
        });
      });
    });
</script>