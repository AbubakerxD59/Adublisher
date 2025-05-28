<style>
  .range_inputs {
    font-size: 0px;
  }

  .range_inputs * {
    display: none;
  }

  .ranges li:last-child {
    display: none;
  }
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div>
      <div>
        <div class="card simple-card">
          <div class="card-body">
            <h2 class="text-center mt-2 m-b-0">Affiliate traffic reports</h2>
            <p class="text-center text-muted m-b-0">Check traffic by your affilites in one page, earning and clicks
              reports list view.</p>
            <?php
            echo loader();
            ?>
            <div class="row m-0 p-10">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header mt-3">
                    <div class="card-actions">
                      <div id="usersdaterange" class="form-control form-control-sm pull-right">
                        <i class="fa fa-calendar"></i> &nbsp; <span></span> &nbsp;<b class="fa fa-caret-down"></b>&nbsp;
                      </div>
                    </div>
                    <h4 class="card-title m-b-0">Affiliate Clicks/Earnings</h4>
                  </div>

                  <div class="card-body" id="top_users">
                    <table id='topusers_table' class="table v-middle table table-striped table-hover">
                      <thead>
                        <tr>
                          <th width="80%">Name</th>
                          <th width="10%">Clicks</th>
                          <th width="10%">Earning</th>
                        </tr>
                      </thead>
                      <tbody id="topusersdata">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Container fluid  -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <?php
  $this->load->view('templates/publisher/footer');
  ?>
  <script type="text/javascript">
    $(function () {

      var start = moment().subtract(1, 'weeks');
      var end = moment();

      function topusers(start, end) {
        $('#usersdaterange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
      }

      $('#usersdaterange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(1, 'weeks'), moment()],
          'All Time': [moment().subtract(1, 'year'), moment()]
        }
      }, topusers);
      topusers(start, end);
    });
    setTimeout(function () {

      populate_table();

    }, 1500);

    $('#usersdaterange').on('apply.daterangepicker', function (ev1, picker1) {
      populate_table();
    });



    $(document).on('click', '.spec_country', function () {
      if (!$(this).hasClass("collapsed")) {
        $("#loader").show();
        var card_id = 'card_' + $(this).attr('id');
        var start = $('#usersdaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
        var end = $('#usersdaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
        var dataOBJ = {
          'username': $(this).attr('id'),
          'start': start,
          'end': end,
          'action': 'getcountrywise',
        }
        $.ajax({
          type: 'GET',
          url: 'getcountrywisepublisher',
          data: dataOBJ,
          success: function (data) {
            $("#loader").hide();
            $('.' + card_id).html(data.data.table);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            $("#loader").hdie();
            alert('no data found');
          }

        });
      }
    });

    function populate_table() {
      $("#loader").show();
      var start = $('#usersdaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
      var end = $('#usersdaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
      var dataOBJ = {
        'username': "",
        'start': start,
        'end': end,
      }

      $.ajax({
        type: "GET",
        url: "affiliate_owner_traffic_summary",
        data: dataOBJ,
        dataType: "json",
        success: function (result) {
          $("#loader").hide();
          $("#topusersdata").html("");
          if (result.data.length > 0) {
            for (i = 0; i < result.data.length; i++) {

              $('#topusersdata').append(
                '<tr>' +
                '<td width="80%">' + result.data[i].name + '<button id="' + result.data[i].user + '" class="pull-right spec_country btn btn-outline-secondary btn-xs" data-toggle="collapse" data-target="#collapse_' + result.data[i].user + '"> Country wise traffic</button>' +
                '<br><div class="collapse" id="collapse_' + result.data[i].user + '">' +
                '<div class="card-body card">' +
                '<table  class="table table-striped table-hover">' +
                '<thead>' +
                '<tr>' +
                '<th>Flag</th>' +
                '<th>Country</th>' +
                '<th>Clicks</th>' +
                '<th>Earning</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody class="card_' + result.data[i].user + '">' +
                '</tbody>' +
                '</table>' +
                '</div></div></td>' +
                '<td width="10%">' + result.data[i].count + '</td>' +
                '<td width="10%">$' + parseFloat(result.data[i].earning).toFixed(2) + '</td>' +
                '</tr>');
            }
          }
          else {
            $("#topusersdata").html("");
            $("#topusersdata").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
          }

        },
        error: function () {
          $("#loader").hide();
          $("#databody").html("No data found, Please provide Valid Date Range");
        }
      });

    }

  </script>