<script src="<?=GeneralAssets ?>plugins/angular/admindashboard.js"></script>
 <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" ng-controller="admindashboard">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Admin Dashboard</h3>
                      
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-tcontainer-fluid-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TODAYS RPM</small></h6>
                                    <h4 class="m-t-0 text-info">
										<div ng-if="today_clicks > 0">
											{{1000*(today_earning / today_clicks) | currency:"$"}}
										</div>
										<div ng-if="today_clicks < 1">
											$0
										</div>
									<span ng-bind="{{today_clicks}}"></span>
										<i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i>
									</h4></div>
                               
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TOTAL PAID</small></h6>
                                    <h4 class="m-t-0 text-info">
									{{total_paid | currency:"$"}}
									<span ng-bind="{{dashboard.widgets}}"></span>
										<i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i>
									</h4></div>
                               
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TOTAL UNPAID</small></h6>
                                    <h4 class="m-t-0 text-info">
									{{unpaid | currency:"$" || number:2 }} 
									<span ng-bind="{{dashboard.widgets}}"></span>
									<i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i>
									</h4></div>
                              
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TOTAL EARNINGS</small></h6>
                                    <h4 class="m-t-0 text-primary">
									{{alltime_earning | currency:"$"}}
									<span ng-bind="{{dashboard.widgets}}"></span>
									<i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i>
									
									</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                   
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">CAMPAIGNS <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-4 b-r">
                                                <h3 class="font-medium">{{all_campaings.all}}</h3>
                                                <h5 class="text-muted">All</h5></div>
                                             <div class="col-4 b-r">
                                                <h3 class="font-medium">{{all_campaings.enable}}</h3>
                                                <h5 class="text-muted">Active</h5></div>
                                            <div class="col-4">
                                                <h3 class="font-medium">{{all_campaings.disable}}</h3>
                                                <h5 class="text-muted">In-Active</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">PUBLISHERS {{all_users.all}}  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-4 b-r">
                                                <h3 class="font-medium">{{all_users.approve}}</h3>
                                                <h5 class="text-muted">Active</h5></div>
                                               <div class="col-4 b-r">
                                                <h3 class="font-medium">{{all_users.pending}}</h3>
                                                <h5 class="text-muted">Pending</h5></div>
                                            <div class="col-4">
                                                <h3 class="font-medium">{{all_users.disapprove}}</h3>
                                                <h5 class="text-muted">Ban</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">ADVERTISERS  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                              <div class="col-4 b-r">
                                                <h3 class="font-medium">0</h3>
                                                <h5 class="text-muted">All</h5></div>
                                               <div class="col-4 b-r">
                                                <h3 class="font-medium">0</h3>
                                                <h5 class="text-muted">Active</h5></div>
                                            <div class="col-4">
                                                <h3 class="font-medium">0</h3>
                                                <h5 class="text-muted">Ban</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                </div>
                
            <div class="row">
                 <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">Today <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-6 b-r">
                                                <h3 class="font-medium">{{today_clicks}} </h3>
                                                <h5 class="text-muted">Clicks</h5></div>
                                             <div class="col-6 b-r">
                                                <h3 class="font-medium">{{today_earning | currency:"$"}}</h3>
                                                <h5 class="text-muted">Revenue</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                
                 <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">Weekly <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-6 b-r">
                                                <h3 class="font-medium">{{dashboard.widgets.weekly_clicks}}  </h3>
                                                <h5 class="text-muted">Clicks</h5></div>
                                             <div class="col-6 b-r">
                                                <h3 class="font-medium">{{dashboard.widgets.weekly_earning | currency:"$"}}</h3>
                                                <h5 class="text-muted">Revenue</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                
                    
                   <!-- Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">All Time <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-6 b-r">
                                                <h3 class="font-medium">{{alltime_clicks}} </h3>
                                                <h5 class="text-muted">Clicks</h5></div>
                                             <div class="col-6 b-r">
                                                <h3 class="font-medium">{{alltime_earning | currency:"$"}}</h3>
                                                <h5 class="text-muted">Revenue</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               
                 <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">Country top 10(Weekly)
 <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
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
                
                  <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">Visit source(Weekly)
 <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-12">
                                               
                                              <canvas id="doughnut" chart-options="options" class="chart chart-doughnut"
                      chart-data="datadevice" chart-colors="colors" chart-labels="labelsdevice">
                    </canvas> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                  
                
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
               
                <div class="row hide">
                  
                     <div class="col-md-6 col-xlg-6">
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
											<span ng-bind="{{dashboard.widgets}}"></span>
											<i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i>											
											</td>
                                            <td>CLICKS: {{today_clicks}}
											<span ng-bind="{{dashboard.widgets}}"></span>
											<i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i>	
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
                    <div class="col-md-6 col-xlg-6">
                        <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header">
                                <div class="card-actions">
                                    <div id="usersdaterange" class="form-control form-control-sm pull-right"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;<b class="caret"></b>&nbsp;<span></span>
                                    </div>
                                 </div>
                                <h4 class="card-title m-b-0">Top Users</h4>
                            </div>
                            <div class="card-body b-t collapse show" id="top_users">
                               <i class="fa fa-cog  fa-spin fa-1x fa-fw pull-right" id="userloader" style="display:none"></i>
                               
                                   
                                <table id='topusers_table' class="table v-middle no-border">
                                <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Clicks</th>
                                                <th>Earning</th>
                                            </tr>
                                        </thead>
                                    <tbody id="topusersdata">
										<tr  ng-repeat="cce in top_users" >
                                            <td> <img src="{{cce.img}}" width="35" height="35" class="img-circle" alt="image"> {{cce.user}} </td>
                                            
                                             <td>{{cce.count}}</td>
                                             <td>{{cce.earning | currency:"$"}}</td>
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Column -->


                         <!-- Column -->
                      
                    
                </div>


                <!-- Row -->
                
                </div>




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
            
            <script src="<?=AdminAssets ?>js/dashboard.js?v=<?=BUILDNUMBER?>"></script>
            <script type="text/javascript">
                $(function(){

                    $('#country_traffic').slimScroll({
                        height: '435px'
                    });
                    $('#top_users').slimScroll({
                        height: '490px'
                    });

                });
            </script>
            