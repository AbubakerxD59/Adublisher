<style>
.range_inputs { font-size: 0px; }
.range_inputs * { display: none; }
.ranges li:last-child { display: none; }
</style>

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
            <?php
                          $upr  =  user_pr();
                          $account = $upr['ptu']->active;
                  ?>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card simple-card">
                            <div class="card-body">
                                <h2 class="text-center mt-2 m-b-0"> Traffic/Views summary</h2>
                                <p class="text-center text-muted">Its your main reporting page, you can view traffic history of campaigns shared by you.</p>
                               
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <?php
                 echo @$upr['pxn'];
                 echo loader();
                 ?>
                <div class="row p-10 m-0">
                
                <?php if($account == '1'){ ?>
                     <div class="col-md-12 col-xlg-12">
                        <!-- Column -->
                        <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12 ">
                                  <h4><b><i class="fa fa-filter"></i></b> FILTERS</h4>
                                </div>
                                <div class="col-md-6 px-3">
                                  <div class="form-group  m-b-0">
                                    <label class="control-label">Report Type</label>
                                      <select id="category" class="form-control">
                                      <option value="campaign">Campaigns</option>
                                      <option value="country">Country</option>
                                      </select> 
                                  </div>
                                </div>
                                <div class="col-md-6 px-3">
                                  <div class="form-group m-b-0">
                                    <label class="control-label">Filter Date</label>
                                      <input id="reportrange" class="form-control">
                                         &nbsp;<b class="caret "></b>&nbsp;<span id="check"></span> 
                                      </input>
                                  </div>
                                </div>
                                <div class="col-md-12 px-3" >
                                    <div class="form-group">
                                    <label class="control-label">Totals:</label>
                                      <div id="summary">
                                        <table class="table v-middle table table-striped table-hover">
                                          <tbody>
                                              <tr>
                                              <td id="total_clicks" style="padding-left: 0px;border:0px;">Earning : $ <?=round($today_earning,2) ?> </td>
                                              <td id="total_earns" style="border:0px;">Clicks: <?=round($today_clicks,2) ?> </td>
                                              </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                               
                            <div class="card-body " style="display: none;" id="country_table">
                                <table class="table v-middle table table-striped table-hover">
                                     <thead>
                                            <tr>
                                                <th>Flag</th>
                                                <th>Country</th>
                                                <th>Clicks</th>
                                                <th>Earning</th>
                                            </tr>
                                        </thead>
                                        <tbody id="databody">
                                            <tr>
                                            <?php
                                                foreach($today_summary as $row){
                                                      echo  "<tr>
                                                            <td><img src='assets/general/flags/".$row['code'].".png'></td>
                                                            <td>".$row['country']."</td>
                                                            <td>". $row['count']."</td>
                                                            <td>$".$row['total_earn']."</td>
                                                        </tr>";                                                 
                                                  }
                                                ?>
                                            </tr>
                                           
                                        </tbody>
                                </table>

                            </div>
                             
                              <div class="card-body" style="" id="campaign_table" >

                                <table width="100%" class="table v-middle table table-striped table-hover">
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
                    <?php } ?>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
           <?php $this->load->view('templates/publisher/footer'); ?>

<script type="text/javascript">
    $(function() {
      setTimeout(function(){

        $("#category").val("campaign").change();
      },1500);
    //var start = moment().subtract(6, 'days');
	var date = new Date();
	var currentDate = date.getDate();
    //var start = moment();
    //var end = moment();
	var start =  moment(date).subtract(7,'days');
	var max =  moment(date);
	var min =  new Date("2018", "01", "01");
    var end = moment(date);
	//minDate: new Date(currentYear, currentMonth, currentDate)
	//startDate: moment(date).add(1,'days')
	// endDate: moment(date).add(2,'days')
    minAllDate = new Date("2018", "01", "01");
    //var end = moment();
    $('#campaign_table').hide();

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
            if($('#category').val()=='country')
            {
              countrywise(start,end);
            }
            else
            {
              populate_table(start,end)
            }
          });
    function countrywise(start,end)
    {
              $('#country_table').show();
              $('#campaign_table').hide();
              var dataOBJ = {
              'username' : $("#loggedUsername").val(),
              'start' : start,
              'end' : end,
              'action':'getcountrywise',
           }
          
          $.ajax({
            type: "GET",
            url: "getcountrywisepublisher",
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

    }


    $('#category').on('change',function(){
      var start=$('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
      var end=$('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
      if($('#category').val()=='country')
      {
        countrywise(start,end);
      }
      else{
      populate_table(start,end);
    }
    });

    function populate_table(start,end)
    {
      
      var total_cliks=0;
      var total_earn=0;
      $.ajax({
            url:'campaignwise',            // call method to show table based on category
            type:'POST',
            dataType: "json",
            data:{cat:$('#category').val(), start_date:start,end_date:end,username: $("#loggedUsername").val()},
            success:function(response)
            {
              //console.log(data);
              $('#country_table').hide();
              $('#campaign_table').show();
              $("#loader").hide(); 
              $('#cpdatabody').html("");
              if(response.status != "false"){
              
             /* for(var i=0 ; i < response.data.length;i++)
              {
                var row = response.data[i];
               */
                $.each(response.data, function(i, elem){
                var row = response.data[i];
                total_cliks=parseFloat(total_cliks)+parseFloat(row.vclick);
                total_earn=parseFloat(total_earn)+parseFloat(row.earn);
                $('#cpdatabody').append('<tr>'+
                                            '<td width="80%">'+(row.text).substr(0,90)+'...'+
                                             '<button id="'+row.cpid +'" class="m-t-10 pull-right spec_country btn btn-outline-secondary btn-xs" data-toggle="collapse" data-target="#collapse_'+row.cpid+'"> Traffic Details</button>'+
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
      if(!$(this).hasClass("collapsed")){
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
        }

      });
    
    
    function total_clicks_earns(total_cliks,total_earn)
    {
       $('#summary').html('<table class="table v-middle table table-striped table-hover">'+
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