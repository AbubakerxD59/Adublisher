<script src="<?=GeneralAssets ?>plugins/angular/publisheranalytics.js"></script>
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
        <div class="page-wrapper" ng-controller="publisherreport">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Publishers Clicks Summary</h3>
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
                        <div class="card earning-widget">
                            <div class="card-header">
                                <div class="card-actions">
                                    <div id="usersdaterange"   class="form-control form-control-sm pull-right"> <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;<b class="caret"></b>&nbsp;<span></span>
                                    </div>
                                 </div>
                                <h4 class="card-title m-b-0">Publishers Clicks</h4>
                            </div>
                            <div class="card-body b-t collapse show" id="top_users">
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
                    </div>
                     <div class="col-lg-5 col-md-5">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 p-r-15 p-l-15">
                                    <div class="social-widget">
                                        <div class="soc-header box-custom">Top 10 Users (Weekly)
                                        <i ng-hide="top_users"  class="fa fa-refresh fa-spin"></i></div>
                                        <div class="soc-content">
                                            <div class="col-12">
                                               
                                              <canvas id="doughnut" chart-options="options" class="chart chart-doughnut"
                                                  chart-data="datausers" chart-colors="colors" chart-labels="labelsusers">
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
    $(function(){
        
    var start = moment();
    var end = moment();
        
   function topusers(start, end) {
        $('#usersdaterange').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    }

    $('#usersdaterange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(7, 'days'), moment()],
		   'All Time': [moment().subtract(1, 'year'), moment()]
        }
    }, topusers);
        topusers(start,end);
    });
    
    $('#usersdaterange').on('apply.daterangepicker',function(ev1,picker1)
    {
   
        var dataOBJ = {
                'username' : "",
                'start' : picker1.startDate.format('YYYY-MM-DD'),
                'end' : picker1.endDate.format('YYYY-MM-DD'),
             }
             $.ajax({
              type: "GET",
              url: "top_users",
              data : dataOBJ,
              dataType: "json",
              success : function(result)
              {
                $("#topusersdata").html("");
               
                if(result.data.length > 0)
                {
                  for(i=0;i<result.data.length;i++)
                    {

                      $('#topusersdata').append(
                                  '<tr>' +
                                    '<td>'+'<img src="'+(result.data[i].img)+'" class="img-circle" width="35px"> '+result.data[i].user+'</td>' + 
                                    '<td>'+result.data[i].count+'</td>' +
                                    '<td> $'+parseFloat(result.data[i].earning).toFixed(2)+'</td>'+
                                    '</td>'+
                                  '</tr>');
                    }
                }
                else
                {
                  $("#topusersdata").html("");
                  $("#topusersdata").html("<tr><td colspan='4' class='text-center'>No data found, Please provide Valid Date Range</td></tr>");
                }  
                 
              },
              error: function(){
                $("#databody").html("No data found, Please provide Valid Date Range");
              }
             });
    });

</script>
