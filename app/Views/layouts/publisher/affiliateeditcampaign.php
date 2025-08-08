<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/managecampaignratesbyowner.js"></script>
<script>
            function previewFile(input){
                var file = $("input[type=file]").get(0).files[0];
                if(file){
                    var reader = new FileReader();
                    console.log(reader.result);
                    reader.onload = function(){
                        $("#cpimage").attr("src", reader.result);
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" ng-controller="campaignrates">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                    <div class="card simple-card">
                        <div class="card-body">
                            <h2 class="text-center mt-2 m-b-0"> Edit Campaign</h2>
                            <p class="text-center text-muted m-b-0">Edit campaign, Also you can set rates for this individual link/campaign.</p>
                          
                              
                        <div class="row p-10 m-0">
                        <?php
                        echo loader();
                        ?>
                         
                             <div class="col-md-7">
                        <!-- Column -->
                         <div class="card">
                            <div class="card-header ">
                                <h6 class="card-title m-b-0">Campaign data</h6>
                            </div>
                            <div class="card-body b-t collapse show" style="">
                            <form class="form" novalidate id="formdata" enctype="multipart/form-data">
                                <div class="row">
                                     <input  name="id" id="id" type="hidden" value="<?php echo $campaign->id; ?>" >
                                    <div class="form-group col-md-12 m-b-5">
                                        <label class="m-b-0">Link</label>
                                        <?php
                                        if($campaign->c_type == 2){
                                            ?>
                                        <input class="form-control" name="cpuspc" required data-validation-required-message="This field is required" id="cpuspcc" type="text" value="<?php echo $campaign->site_us_pc; ?>" >
                                        <?php
                                        }else{
                                            ?>
                                            <input class="form-control" name="cpuspc" required data-validation-required-message="This field is required" id="cpuspc" type="text" value="<?php echo $campaign->site_us_pc; ?>" >
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group col-md-12 m-b-5">
                                            <label class="m-t-20">Title</label>
                                            <input class="form-control" name="cpname" id="cpname"  required data-validation-required-message="This field is required" type="text" value="<?php echo $campaign->text; ?>">
                                    </div>
                                    <div class="form-group col-md-12 m-b-5">
                                        <label class="m-t-20">Image Link</label>
                                        <input class="form-control" name="cpimg" id="cpimg" required data-validation-required-message="This field is required" type="text"  value="<?php echo $campaign->img; ?>">
                                        <?php
                                        if($campaign->c_type == 2){
                                            ?>

                                             <label class="m-t-5">Upload Thumbnail Image</label>
                                                <input type="file" name="photo" id="photo" onchange="previewFile(this);" >
                                            <?php
                                        }else{
                                            ?>
                                            <input style="display:none;" type="file" name="photo" id="photo" onchange="previewFile(this);" >
                                        <?php
                                        }
                                        ?>
                                       
                                    </div>                                   
                                    <div class="form-group col-md-6 m-b-5">
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
                                    <div class="form-group col-md-6 m-b-5">
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
                                  
                                    <div class="form-group col-md-4  hide m-b-5">
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
                                        <button class="btn btn-outline-secondary pull-right" type="submit"> <i class="fa fa-floppy-o"></i> Save Campaign</button>
                                    </div>
                            </div>
                        </form>
                                
    
                                
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                     <div class="col-md-5">
                      <div class="row">
                        <div class="col-md-12">
                           <div class="card">
                                <div class="card-header">
                                   
                                    <h6 class="card-title m-b-0">RATES SETTINGS</h6>
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
                                <div class="card-body b-t " style="">
                                     <div class="">       
                                     <div class="radio">
                                        <label> &nbsp; <input type="radio" name="optradio" class="optradio"  value="yes" <?=$checked_yes?>> &nbsp; USE CAMPAIGN SPECIFIC RATES</label>
                                         &nbsp;&nbsp;
                                         <button class="btn btn-sm btn-outline-secondary pull-right"  id="setuserrates" ><i class="fa fa-money"></i> Set Rates</button>
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
                            <div class="card simple-card">
                                <div class="card-header">
                                    
                                    <h6 class="card-title m-b-0">Thumbnail Preview</h6>
                                </div>
                                <div class="card-body b-t" style="">
                                     
                                     <img class="img-responsive" id="cpimage" src="<?php echo $campaign->img; ?>">
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
                    <button type="button" id="saverates" class="btn btn-outline-secondary" ><i class="fa fa-floppy-o"> </i> Save rates</button>
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
<?php $this->load->view('templates/publisher/footer'); ?>
<script src="<?=PublisherAssets ?>js/campaign_edit.js"></script>
<script>       
$(function () {
    $(document).on('click','#saverates',function(){
        
        var ratesarray = [];
        $(".ratesinputs").each(function() {
            ratesarray.push({id : $(this).data('cid') , value : $(this).val()});
        });
        
        $.ajax({
                url: SITEURL +  'add_update_rate_owner',
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

                url: SITEURL + 'update_rate_settings_owner',
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