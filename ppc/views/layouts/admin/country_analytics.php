<script src="<?=GeneralAssets ?>plugins/angular/countryanalytics.js"></script>
  
<style>
    .range_inputs { font-size: 0px; }
.range_inputs * { display: none; }
.ranges li:last-child { display: none; }
</style>
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" ng-controller="countryreport">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Country Clicks Summary</h3>
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
                  
                        <div class="col-md-7 col-xlg-7">
                        <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header ">
                                <div class="row">
                                
                                <div class="col-md-4 pull-left"><h4 class="card-title m-b-0">Traffic summary</h4>
                                   
                                    
                               
                                    </div>
                                  <div class="col-md-5 col-sm-12 col-xs-12">
                                    
                                    <div id="reportrange" class=" form-control form-control-sm pull-right">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;<b class="caret"></b>&nbsp;<span></span> 
                                    
                                </div>
                                    </div>
                                     <div class="col-md-3 col-sm-12 col-xs-12">
                             
                                      <select id="userfilter" class="form-control form-control-sm">
                                      <option value="">All Users</option>
									  <option  ng-repeat="cce in all_users_dropdown" value="{{cce.username}}">{{cce.username}}
                                     </option>
                                      </select>
                                      <i class="fa fa-cog  fa-spin fa-1x fa-fw pull-right" id="loader" style="display: none"></i>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <span id="summary" class="m-l-10">
                                      <table class="table">
                                        <tbody>
                                           <tr>
                                            <td style="padding-left: 0px;">EARNING :
											{{today_earning | currency:"$"}}
											
											<i ng-hide="today_summary"  class="fa fa-refresh fa-spin"></i>											
											</td>
                                            <td>CLICKS: {{today_clicks}}
											
											<i ng-hide="today_summary"  class="fa fa-refresh fa-spin"></i>	
											</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </span>
                                </div>

                                    
                                    
                                 
                            </div>
                            <div class="card-body b-t collapse show" id="country_traffic">
                                <table class="table v-middle no-border">
                                     <thead>
                                            <tr>
                                                <th>Flag</th>
                                                <th>Country</th>
                                                <th>Clicks</th>
                                                <th>Earning</th>
                                            </tr>
                                        </thead>
                                        <tbody id="databody">
										<tr  ng-repeat="cce in today_summary" >
                                            <td> <img src="assets/general/flags/{{cce.code}}.png" width="35" height="35" class="" alt="image"> </td>
                                             <td>{{cce.country}}</td>
                                             <td>{{cce.count}}</td>
                                             <td>{{cce.total_earn | currency:"$"}}</td>
                                        </tr> 
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                  
                     <div class="col-lg-5 col-md-5">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">Top 10 Countries (Weekly)
                                        <i ng-hide="datacountry"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-12">
                                               
                                              <canvas id="doughnut" chart-options="options" class="chart chart-doughnut"
                                                  chart-data="datacountry" chart-colors="colors" chart-labels="labelscountry">
                                              </canvas> 
                                            </div>
                                        </div>
                                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/angular-chart.min.js"></script>  
<script type="text/javascript">
    $(function() {
    var start_article = moment().subtract(6, 'days');
    var start = moment();
    var end = moment();

    function cb(start, end) {
      $('#reportrange').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));

    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		    'All Time': [moment().subtract(1, 'year'), moment()]
        }
    }, cb);

    
    cb(start, end);
    
    $("#userfilter").change(function(){

            var username = $("#userfilter").val();
            var start = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var end = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');

            var dataOBJ = {
              'username' : username,
              'start' : start,
              'end' : end,
              'action':'getcountrywise',
           }
          $("#loader").show();
          $.ajax({
            type: "GET",
            url: "admin_getcountrywise",
            data: dataOBJ,
            dataType: "json",
             success: function(response) {
              $("#loader").hide();          
              if(response.status){
               $("#databody").html(response.data.table);
               $("#summary").html(response.data.summary);
              }else{
                $("#summary").html("");
                $("#databody").html("<tr><td colspan='4' class='text-center'>No data found, Please provide Valid Date Range</td></tr>");
              }
            },
            error: function(){
              $("#loader").hide();
              
              $("#databody").html("No data found, Please provide Valid Date Range");
            }
        });

    });



    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {

        
           $("#loader").show();
              var username = $("#userfilter").val();
              var start = picker.startDate.format('YYYY-MM-DD');
              var end = picker.endDate.format('YYYY-MM-DD');

              var dataOBJ = {
                'username' : username,
                'start' : start,
                'end' : end,
                'action':'getcountrywise',
             }
            
            $.ajax({
              type: "GET",
              url: "admin_getcountrywise",
              data: dataOBJ,
              dataType: "json",
               success: function(response) {
                $("#loader").hide();          
                if(response.status){
                 $("#databody").html(response.data.table);
                 $("#summary").html(response.data.summary);
                }else{
                  $("#summary").html("");
                  $("#databody").html("<tr><td colspan='4' class='text-center'>No data found, Please provide Valid Date Range</td></tr>");
                }
              },
              error: function(){
                $("#loader").hide();
                
                $("#databody").html("No data found, Please provide Valid Date Range");
              }
          });
        
         
    });

});

</script>
