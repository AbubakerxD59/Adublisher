
<script src="<?=GeneralAssets ?>plugins/angular/managepublishers.js"></script>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper" ng-controller="adubdashboard">
    
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
            <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Publisher's Profile</h3>
                      
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                    </div>
                </div>
        
        
        <div class="row ">
            
               <!-- Column -->
            <div class="col-lg-3 col-md-6">
                 <div class="card">
                       <div class="card-body little-profile text-center p-10 ">
                                <div class="pro-img mt-0 "><img onerror="this.src='assets/general/images/user_avatar.png';"
                                 src="{{dashboard.publisher.img}}" alt="user"></div>
                                <h3 class="m-b-0">{{dashboard.publisher.name}}</h3>
                                <p>Username, {{dashboard.publisher.username}}</p> 
                           <span class="mytooltip tooltip-effect-2">
                                     <span class="tooltip-item" style="border-radius: 18px;"><i class="fa fa-info"></i></span>
                                      <span class="tooltip-content clearfix">                                    
                             <span class="tooltip-text p-10"> 
                                 <table class="table ">
                                
                                <tr>
                                <td class="text-left">Email</td>    
                                <td class="text-right">{{dashboard.publisher.email}}</td>    
                                </tr>
                               <tr>
                                <td class="text-left">Phone</td>    
                                <td class="text-right">{{dashboard.publisher.ph}}</td>    
                                </tr>
                                    
                                <tr>
                                <td class="text-left">Social Profile</td>    
                                <td class="text-right">{{dashboard.publisher.fbprofile}}</td>    
                                </tr>
                                    
                                 <tr>
                                <td class="text-left">Publish Source</td>    
                                <td class="text-right">{{dashboard.publisher.fbpage}}</td>    
                                </tr>
                                <tr>
                                <td class="text-left">PayPal Email</td>    
                                <td class="text-right">{{dashboard.publisher.paypal_email}}</td>    
                                </tr>
                                    
                                </table>  
                            </span>
                                    </span>
                                   </span>
                             </div>
                </div>
                <div class="card earning-widget">
                            <div class="card-header">
                                <h4 class="card-title m-b-0"><i class="fa fa-bank"></i> Calculate Salary</h4> <br>
                                 <h4 class="card-title m-b-0">
                                      <small>Select Date Range</small>
                                    <div id="usersdaterange" class="form-control form-control-sm pull-right"></div>
                                    
                                </h4>
                                
                            </div>
                     <div class="card-body little-profile text-center p-10 " id="topusersdata">
                    </div>
                    
                        </div>
                    </div>
            
                    <div class="col-md-8 col-xs-12 col-sm-12">
                   
                        <div class="card">
                            <div class="card-body">
                                       <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                               <!-- <li class="nav-item"> <a class="nav-link active customtab2" data-toggle="tab" href="#account" role="tab" aria-selected="false">Account Details</a> </li>-->
                                <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#summary" role="tab" aria-selected="false">Earning  & Clicks Summary</a> </li>
                                 <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#campaigns" role="tab" aria-selected="true">Weekly Top Campaigns</a> </li>
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab" aria-selected="true">Settings</a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                             <!--   <div class="tab-pane active" id="account" role="tabpanel">
                                    <div class="card-body">
                                               <table class="table stylish-table">
                                
                                <tr>
                                <td class="text-left">Email</td>    
                                <td class="text-right">{{dashboard.publisher.email}}</td>    
                                </tr>
                               <tr>
                                <td class="text-left">Phone</td>    
                                <td class="text-right">{{dashboard.publisher.ph}}</td>    
                                </tr>
                                    
                                <tr>
                                <td class="text-left">Social Profile</td>    
                                <td class="text-right">{{dashboard.publisher.fbprofile}}</td>    
                                </tr>
                                    
                                 <tr>
                                <td class="text-left">Publish Source</td>    
                                <td class="text-right">{{dashboard.publisher.fbpage}}</td>    
                                </tr>
                                <tr>
                                <td class="text-left">PayPal Email</td>    
                                <td class="text-right">{{dashboard.publisher.paypal_email}}</td>    
                                </tr>
                                    
                                </table>  
                         
                                    </div>
                                </div>-->
                                <!--second tab-->
                                <div class="tab-pane" id="summary" role="tabpanel">
                                    <div class="card-body">
                                                        <div class="row text-left  p-10" style="background: #9e9e9e1f;">
                                    <div class="col-lg-12 col-md-12 m-t-10">
                                        <h3 class="m-b-0 font-light">Earning Summary  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i> </h3></div>
                     
                                    <div class="col-md-12 m-b-10"></div>
                                 </div> 
                                   
                                <div class="d-flex flex-row text-center">
                                     <div class="p-20  b-r">
                                    <h5 class="m-b-0"><small>YESTERDAY</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.yesterday_earn | currency}}</h6>
                                    </div>
                                    <div class="p-20  b-r">
                                    <h5 class="m-b-0"><strong class="text-success">TODAY</strong></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.todayearn | currency}}</h6>
                                    </div>
                                    <div class="p-20  b-r">
                                    <h5 class="m-b-0"><small>WEEK</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.week_earn | currency}}</h6>
                                    </div>
                                    <div class="p-20  b-r">
                                    <h5 class="m-b-0"><small>ALL TIME</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.alltime_earning | currency}}</h6>
                                    </div>
                                    <div class="p-20  b-r">
                                       <h5 class="m-b-0"><small class="text-danger">WITHDRAWAL</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.total_paid | currency}}</h6>
                                    </div>
                                    <div class="p-20 ">
                                        <h5 class="m-b-0"><small>BALANCE</small></h5>
                                        <h6 class="m-t-0 text-default"> {{dashboard.widgets.totalpending | currency}}</h6>
                                    </div>

                                     

                                </div>
                                        
                                <div class="row text-left  p-10" style="background: #9e9e9e1f;">
                                    <div class="col-lg-12 col-md-12 m-t-10">
                                        <h3 class="m-b-0 font-light">Clicks Summary  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i> </h3></div>
                     
                                    <div class="col-md-12 m-b-10"></div>
                                 </div> 
                                <div class="d-flex flex-row text-center">
                                     <div class="p-20  b-r">
                                    <h5 class="m-b-0"><small>YESTERDAY</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.yesterday_clicks}}</h6>
                                    </div>
                                    <div class="p-20  b-r">
                                    <h5 class="m-b-0"><strong class="text-success">TODAY</strong></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.todayclick}}</h6>
                                    </div>
                                   
                                     <div class="p-20  b-r">
                                    <h5 class="m-b-0"><small>WEEK</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.week_clicks}}</h6>
                                    </div>
                                    <div class="p-20  b-r">
                                    <h5 class="m-b-0"><small>ALL TIME</small></h5>
                                    <h6 class="m-t-0 text-default">{{dashboard.widgets.alltime_clicks}}</h6>
                                    </div>
                                   </div>
                                       
                                    </div>
                                </div>
                                <div class="tab-pane" id="campaigns" role="tabpanel">
                                    <div class="card-body">
                                     <table class="table v-middle no-border">
                                        <tr>
                                            <th>Campaign</th>
                                            <th>Clicks</th>
                                            <th>Earning</th>
                                        </tr>
                                            <tbody>
                                        
                                        <tr  ng-repeat="cce in dashboard.campaign_click_earn" >
                                            <td> <img src="{{cce.img}}" onerror="this.src='assets/general/images/user_avatar.png';" width="35" height="35" class="img-circle" alt="image"> {{cce.text.substring(0,70)+"..."}} </td>
                                             <td>{{cce.click}}</td>
                                             <td>{{cce.Earn | currency}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                        
                                     </div>
                                </div>
                                <div class="tab-pane active" id="settings" role="tabpanel">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material p-0">
                                            
                                             <div class="row text-left  p-10" style="background: #9e9e9e1f;">
                                                <div class="col-lg-12 col-md-12 m-t-10">
                                                    <h3 class="m-b-0 font-light">RATES SETTINGS</h3></div>
                                                <div class="col-md-12 m-b-10"></div>
                                             </div> 
                                            <br>
                                            <input type="hidden" value="{{dashboard.publisher.id}}" id="pub_id" />
                                            <input type="hidden" value="{{dashboard.publisher.username}}" id="MMP_username" />
                                            <div class="form-group">
                                                 <div class="radio">
                                                    <label> &nbsp; <input type="radio" name="optradio" class="optradio"  value="yes" ng-model="dashboard.publisher.rates_priority"> &nbsp; USE USER SPECIFIC RATES</label>
                                                     &nbsp;&nbsp;
                                                     <button class="btn btn-sm btn-primary pull-right"  id="setuserrates" ><i class="fa fa-pencil"></i> Set Rates</button>
                                                    </div>
                                                    
                                                    <div class="radio">
                                                      <label> &nbsp; <input type="radio" class="optradio" name="optradio"  value="default" ng-model="dashboard.publisher.rates_priority"> &nbsp; USE SYSTEM RATES</label>
                                                    </div>
                                            </div>
                                            
                                             <div class="row text-left  p-10" style="background: #9e9e9e1f;">
                                                <div class="col-lg-12 col-md-12 m-t-10">
                                                    <h3 class="m-b-0 font-light">ASSIGN ADVERTISERS <small>({{dashboard.publisher.name}} can Share campaigns of )</small></h3></div>
                                                <div class="col-md-12 m-b-10"></div>
                                             </div> 
                                             <br>
                                             <div class="form-group">
                                                 <div class="radio">
                                                    <label> &nbsp; <input type="radio" name="advchoice" class="advchoice"  value="all" ng-model="dashboard.publisher.adv_priority"> &nbsp; ALL ADVERTISERS</label>
                                                    
                                                    </div>
                                                    
                                                    <div class="radio">
                                                      <label> &nbsp; <input type="radio" class="advchoice" name="advchoice"  value="custom" ng-model="dashboard.publisher.adv_priority"> &nbsp; SPECIFIC ADVERTISERS</label>
                                                        
                                                     <button class="btn btn-sm btn-primary pull-right"  id="setuseradv" ><i class="fa fa-pencil"></i> Assign Advertisers</button>
                                                        
                                                    </div>
                                            </div>
                                            
                                            
                                            <div class="row text-left  p-10 soft-hide" style="background: #9e9e9e1f;">
                                                <div class="col-lg-12 col-md-12 m-t-10">
                                                    <h3 class="m-b-0 font-light">CHANGE USER STATUS</h3></div>
                                                <div class="col-md-12 m-b-10"></div>
                                             </div> 
                                            
                                            <div class="form-group">
                                               
                                                <div class="col-sm-12">
                                                   
                                                </div>
                                            </div>
                                            
                                             <div class="row text-left soft-hide  p-10" style="background: #9e9e9e1f;">
                                                <div class="col-lg-12 col-md-12 m-t-10">
                                                    <h3 class="m-b-0 font-light">ACCESS MANAGEMENT</h3></div>
                                                <div class="col-md-12 m-b-10"></div>
                                             </div> 
                                         
                                        </form>
                                    </div>
                                </div>
                            </div>
                
                            </div>
                            
                        </div>
                        
                    </div>
                    <!-- Column -->
                 
            
          
        </div>
     </div>
    <div class="modal fade" id="userRates" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">USER RATES SETTINGS</h4>
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
                         <td><img src='assets/general/flags/{{item.code}}.png'> {{item.name}}</td>
                         <td><input data-cid={{item.id}}  class="ratesinputs input-sm" value="{{item.rate}}" ></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
       
      </div>

    </div>
</div>
  <div class="modal fade" id="userAdv" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ASSIGN ADVERTISERS</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
       
        <div class="modal-body">
               <div class="form-group">
                    <div class="input-group">
                        <ul class="icheck-list">
                            <li ng-repeat="item in domains">
                                <span ng-if="item.status == 'active'">
                                 <input type="checkbox"  data-did={{item.id}} class="check advinputs" id="minimal-checkbox-{{item.id}}" checked="true">
                                 <label for="minimal-checkbox-{{item.id}}">{{item.domain}}</label>
                                </span>
                                 <span ng-if="item.status == 'inactive'">
                                 <input type="checkbox"  data-did={{item.id}} class="check advinputs" id="minimal-checkbox-{{item.id}}">
                                 <label for="minimal-checkbox-{{item.id}}">{{item.domain}}</label>
                                </span>
                               
                            </li>                            
                        </ul>
                    </div>
                </div>
           
        </div>
          
        <div class="modal-footer">
          <button type="button" id="saveadv" class="btn btn-primary" >Save</button>
        </div>
       
      </div>

    </div>
</div>

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
<?php 
$this->load->view('templates/publisher/footer'); 
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script src="<?=GeneralAssets ?>plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/angular-chart.min.js"></script>  
<script>    
   
$(function () {
 var start = moment();
 var end = moment();
    function topusers(start, end) {
        $('#usersdaterange').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    }

    $('#usersdaterange').daterangepicker({
        startDate: start,
        endDate: end,
    }, topusers);
        topusers(start,end);
   
  $('#usersdaterange').on('apply.daterangepicker',function(ev1,picker1)
    {
   
        var dataOBJ = {
                'username' : $("#MMP_username").val(),
                'start' : picker1.startDate.format('YYYY-MM-DD'),
                'end' : picker1.endDate.format('YYYY-MM-DD'),
             }
             $.ajax({
              type: "GET",
              url: "user_salary",
              data : dataOBJ,
              dataType: "json",
              success : function(result)
              {
                console.log(result);
                $("#topusersdata").html("<h3>$"+result.data.earning+"</h3>");
               
                
                
                 
              },
              error: function(){
                $("#databody").html("No data found");
              }
             });
    });
   
$(document).on('click','#saverates',function(){
    
    var ratesarray = [];
    $(".ratesinputs").each(function() {
         ratesarray.push({id : $(this).data('cid') , value : $(this).val()});
    });
    
     $.ajax({
            url:'add_update_rate',
            type:'POST',
            data :{res_id : $('#pub_id').val(), identifier : 'user',  rates : JSON.stringify(ratesarray)},
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

$(document).on('click','#saveadv',function(){
    
    var domainsarray = [];
    $(".advinputs").each(function() {
        val_c = "inactive";
        if($(this).prop('checked')){
           val_c = "active";
         }
         domainsarray.push({id : $(this).data('did') , value : val_c});
    });
    
     $.ajax({
            url:'add_update_assignadv_settings',
            type:'POST',
            data :{res_id : $('#pub_id').val(), identifier : 'user',  domains : JSON.stringify(domainsarray)},
            success : function(data){
             alertbox("Success" , "Settings Updated Successfully" ,  "success");
            $("#userAdv").modal('hide');   
            },
            error:function(data)
            {
                
             alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");

            }
        });
    
});

$(document).on('click','#setuseradv',function(){
    $("#userAdv").modal('show');
 });  
    
$(document).on('change','.advchoice',function(){

        value  =  $(this).val();
        if(value == "custom"){
            $("#setuseradv").show();
           
        }else{
             $("#setuseradv").hide();
        }
         $.ajax({

            url:'update_assignadv_settings',
            type:'POST',
            data : {value : value, identifier : 'user' , res_id : $('#pub_id').val()},
            success : function(data){
               
              if(value == "custom"){
                  
                    alertbox("Success" , "Settings Updated Successfully" ,  "success");
                    setTimeout(function(){
                        
                        $("#userAdv").modal('show');
                        
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
   
$(document).on('change','.optradio',function(){
     
      
        value  =  $(this).val();
        
        if(value == "yes"){
            $("#setuserrates").show();
        }else{
             $("#setuserrates").hide();
        }
        $.ajax({

            url:'update_rate_settings',
            type:'POST',
            data : {value : value, identifier : 'user' , res_id : $('#pub_id').val()},
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
   $(document).on('click','.change_status',function(){
       
    $.ajax({

            url:'change_announce_view',
            type:'GET',
            data : {announce_id : $(this).attr('id'), res_id : $('#loggeduserid').val()},
            success : function(data){
             location.reload();
            },
            error:function(data)
            {
              location.reload();
            }

    });

       
   });

});

</script>
