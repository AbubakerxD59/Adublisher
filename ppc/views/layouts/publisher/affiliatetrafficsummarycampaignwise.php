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
                        <h2 class="text-center mt-2 m-b-0">Campaigns traffic reports</h2>
                        <p class="text-center text-muted m-b-0">Check traffic by your campaigns in one page, earning and
                            clicks reports list view.</p>
                        <div class="row m-0 p-10">
                            <?php
                            echo loader();
                            ?>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header mt-3">

                                        <div class="card-actions">
                                            <div id="reportrange" class="form-control form-control-sm pull-right">
                                                <i class="fa fa-calendar"></i> &nbsp; <span></span> &nbsp;<b
                                                    class="fa fa-caret-down"></b>&nbsp;
                                            </div>
                                        </div>
                                        <h4 class="card-title m-b-0">Campaigns traffic reports</h4>
                                    </div>

                                    <div class="card-body" style="" id="campaign_table">
                                        <div class="">


                                            <div class="col-md-12">
                                                <span id="summary">
                                                    <table class="table v-middle table table-striped table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <td id="total_clicks"
                                                                    style="padding-left: 0px;border:0px;"></td>
                                                                <td id="total_earns" style="border:0px;"> </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </span>
                                            </div>

                                        </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="category" value="campaign" />
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
            setTimeout(function () {

                $("#category").val("campaign").change();

            }, 1500);
            var date = new Date();
            var currentDate = date.getDate();
            var start = moment(date).subtract(1, 'weeks');
            var max = moment(date);
            var min = new Date("2018", "01", "01");
            var end = moment(date);
            minAllDate = new Date("2018", "01", "01");
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            }
            $('#reportrange').daterangepicker({
                minDate: min,
                maxDate: max,
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Week': [moment().subtract(1, 'weeks'), moment()],
                    'All Time': [minAllDate, moment()]
                }
            }, cb);
            cb(start, end);
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                $("#loader").show();
                var start = picker.startDate.format('YYYY-MM-DD');
                var end = picker.endDate.format('YYYY-MM-DD');

                populate_table(start, end)

            });
            $('#category').on('change', function () {
                var start = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var end = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                populate_table(start, end);
            });

            function populate_table(start, end) {

                var total_cliks = 0;
                var total_earn = 0;
                $.ajax({
                    url: 'affiliate_campaign_traffic_summary',            // call method to show table based on category
                    type: 'POST',
                    dataType: "json",
                    data: { cat: $('#category').val(), start_date: start, end_date: end, username: "" },
                    success: function (response) {
                        $("#loader").hide();
                        $('#cpdatabody').html("");
                        if (response.status != "false") {
                            $.each(response.data, function (i, elem) {
                                var row = response.data[i];
                                total_cliks = parseFloat(total_cliks) + parseFloat(row.vclick);
                                total_earn = parseFloat(total_earn) + parseFloat(row.earn);
                                $('#cpdatabody').append('<tr>' +
                                    '<td width="80%">' + (row.text).substr(0, 90) + '...' +
                                    '<button id="' + row.cpid + '" class="pull-right spec_country btn btn-outline-secondary btn-xs" data-toggle="collapse" data-target="#collapse_' + row.cpid + '"> Country wise traffic</button>' +
                                    '<br><div class="collapse" id="collapse_' + row.cpid + '">' +
                                    '<div class="card_' + row.cpid + ' card-body card"> </div> </div></td>' +
                                    '<td width="10%">' + row.click + ' ' +
                                    '<td width="10%">' + parseFloat(row.earn).toFixed(3) + '</td>' +
                                    '</td>');
                            });
                            total_clicks_earns(total_cliks, total_earn);
                        } else {

                            $("#cpdatabody").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                        }

                    }
                });


            }

            $(document).on('click', '.spec_country', function () {
                if (!$(this).hasClass("collapsed")) {
                    var card_id = 'card_' + $(this).attr('id');
                    var start = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    $.ajax({
                        type: 'GET',
                        url: 'affiliate_individual_country_traffic_summary',
                        data: { cpid: $(this).attr('id'), username: null, start_date: start, end_date: end },
                        success: function (data) {
                            $('.' + card_id).html(data.card_content);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert('some problem occur');
                        }
                    });
                }
            });


            function total_clicks_earns(total_cliks, total_earn) {
                $('#summary').html('<table class="table">' +
                    '<tbody>' +
                    '<tr>' +
                    '<td style="padding-left: 0px;border:0px;">EARNING: $' + total_earn.toFixed(5) + '</td>' +
                    '<td style="border:0px;">CLICKS: ' + total_cliks + '</td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>');
                $('#compaign_table').append('</tbody> </table>');
            }


        });
    </script>