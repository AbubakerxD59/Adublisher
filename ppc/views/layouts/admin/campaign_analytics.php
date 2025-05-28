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
                        <h3 class="text-themecolor m-b-0 m-t-0">Campaigns Clicks Summary</h3>
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
                        <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header ">
                                <div class="row">
                                  
                                   <select id="category" class="form-control" style="display:none;">
                                          <option value="country">Country</option>
                                          <option value="campaign">Campaigns</option>
                                          
                                  </select> 
                                    <div class="col-md-8 col-sm-8 col-xs-12 m-t-10">
                                       Filter By Date:
                                    <div id="reportrange" class=" form-control">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;<b class="caret "></b>&nbsp;<span id="check"></span> 
                                    </div>
                                    </div>
                                     <div class="col-md-4">
                                        <span id="summary">
                                              <table class="table">
                                                <tbody>
                                                   <tr>
                                                    <td id="total_clicks" style="padding-left: 0px;border:0px;"></td>
                                                    <td id="total_earns" style="border:0px;"> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </span>
                                         <i class="fa fa-cog  fa-spin fa-1x fa-fw pull-right" id="loader" style="display: none"></i>
                                      </div>

                                     
                            </div>                             
                              <div class="card-body b-t collapse show" style="" id="campaign_table" >
                                <table width="100%" class="table v-middle">
                                       <thead>
                                              <tr>
                                                  <th width="80%">Campaign </th>
                                                  <th width="10%">Clicks</th>
                                                  <th width="10%">Earning </th>
                                              </tr>
                                          </thead>
                                          <tbody id="cpdatabody">
                                          </tbody>
                                        </table>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
           
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            
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
      setTimeout(function(){
        $("#category").val("campaign").change();
      },1500);
      var date = new Date();
      var currentDate = date.getDate();
      var start =  moment(date);
      var max =  moment(date);
      var min =  new Date("2018", "01", "01");
      var end = moment(date);
      minAllDate = new Date("2018", "01", "01");
      function cb(start, end) {
          $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
      }
    $('#reportrange').daterangepicker({
		minDate:min,
		maxDate:max,
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Week': [moment().subtract(7, 'days'), moment()],
            'All Time': [minAllDate, moment()]
        }
    }, cb);
    cb(start, end);
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          $("#loader").show();
            var start = picker.startDate.format('YYYY-MM-DD');
            var end = picker.endDate.format('YYYY-MM-DD');
            
              populate_table(start,end)
           
          });
       $('#category').on('change',function(){
          var start=$('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
          var end=$('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
          populate_table(start,end);
        });

    function populate_table(start,end)
    {
      
      var total_cliks=0;
      var total_earn=0;
      $.ajax({
            url:'campaignwise',            // call method to show table based on category
            type:'POST',
            dataType: "json",
            data:{cat:$('#category').val(), start_date:start,end_date:end,username: ""},
            success:function(response)
            {
              $("#loader").hide(); 
              $('#cpdatabody').html("");
              if(response.status != "false"){
                $.each(response.data, function(i, elem){
                var row = response.data[i];
                total_cliks=parseFloat(total_cliks)+parseFloat(row.vclick);
                total_earn=parseFloat(total_earn)+parseFloat(row.earn);
                $('#cpdatabody').append('<tr>'+
                                            '<td width="80%"><img class="img-circle" alt="image" src="' + row.img + '" width="50" height="50" /> '+(row.text).substr(0,90)+'...'+
                                             '<button id="'+row.cpid +'" class="m-t-10 pull-right spec_country btn btn-success btn-sm" data-toggle="collapse" data-target="#collapse_'+row.cpid+'"> Traffic Details</button>'+
                                              '<div class="collapse" id="collapse_'+row.cpid+'">'+
                                              '<div class="card_'+row.cpid+' card-body card"> </div> </div></td>'+
                                             '<td width="10%">'+row.click+' '+
                                            '<td width="10%">'+parseFloat(row.earn).toFixed(3)+'</td>'+
                                            '</td>' );
               });
               total_clicks_earns(total_cliks,total_earn);
             }else{

                $("#cpdatabody").html("<tr><td colspan='4' class='text-center'>No data found, Please provide Valid Date Range</td></tr>");
             }
              
             }
            });
              
        
    }

    $(document).on('click','.spec_country',function(){
      
      var card_id='card_'+$(this).attr('id');

      var start=$('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
      var end=$('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        $.ajax({
          type:'GET',
          url:'individual_country_click',
          data:{cpid: $(this).attr('id'),username: $("#loggedUsername").val(),start_date:start,end_date:end},
          success:function(data)
          {
             $('.'+card_id).html(data.card_content);
           

          },
          error:function(xhr, ajaxOptions, thrownError)
          {
            alert('some problem occur');
          }

        });

      });
    
    
    function total_clicks_earns(total_cliks,total_earn)
    {
       $('#summary').html('<table class="table">'+
                '<tbody>'+
                   '<tr>'+
                    '<td style="padding-left: 0px;border:0px;">EARNING: $'+ total_earn.toFixed(5) +'</td>'+
                   '<td style="border:0px;">CLICKS: '+ total_cliks +'</td>'+
                    '</tr>'+
                '</tbody>'+
            '</table>');
      $('#compaign_table').append('</tbody> </table>');
    }
    
    
});
</script>
