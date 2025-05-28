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
                        <h2 class="text-center">Traffic Report</h2>
                        <p class="text-center text-muted">Traffic Report for your account, Filter by date, affiliate,
                            country and campaigns.</p>
                        <div class="row d-flex justify-content-between mt-4">
                            <div class="form-group col-md-3">
                                <select class="form-control" name="report_filter" id="report_filter">
                                    <option value="affiliate">AFFILIATE</option>
                                    <option value="campaign" selected>CAMPAIGN</option>
                                    <option value="country">COUNTRY</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 info_tab text-center" style="display: none;">
                                <small>EARNING:</small>
                                <b><span class="earning"></span></b>
                            </div>
                            <div class="form-group col-md-3 info_tab text-center" style="display: none;">
                                <small>TOTAL CLICKS:</small>
                                <b><span class="total_clicks"></span></b>
                            </div>
                            <div id="usersdaterange" class="col-md-3 form-control p-2">
                                <i class="fa fa-calendar"></i> &nbsp; <span></span> &nbsp;<b
                                    class="fa fa-caret-down"></b>&nbsp;
                            </div>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="60%">Name</th>
                                        <th width="20%">Clicks</th>
                                        <th width="20%">Earning</th>
                                    </tr>
                                </thead>
                                <tbody id="report_data">
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="row m-0 p-10">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-pie-chart"></i> Affiliate traffic reports</h4>
                                                <p class="card-text">Check traffic by your affilites in one page, earning and clicks reports list view.</p>
                                                <a href="<?= SITEURL ?>affiliate-traffic-summary-user-wise" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-pie-chart"></i> Campaigns traffic reports</h4>
                                                <p class="card-text">Check traffic by your campaigns in one page, earning and clicks reports list view.</p>
                                                <a href="<?= SITEURL ?>affiliate-traffic-summary-campaign-wise" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" >
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-pie-chart"></i> Country traffic reports</h4>
                                                <p class="card-text">Check traffic by country, user filter is availabe, earning and clicks reports list view.</p>
                                                <a href="<?= SITEURL ?>affiliate-traffic-summary-country-wise" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
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
    <script>
        $(document).ready(function () {
            var start = moment().subtract(1, 'year');
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
            $('#usersdaterange').on('apply.daterangepicker', function (ev1, picker1) {
                var report_filter = $('#report_filter').val();
                if (report_filter == 'affiliate') {
                    populate_user_table();
                }
                if (report_filter == 'campaign') {
                    populate_campaign_table();
                }
                if (report_filter == 'country') {
                    populate_country_table();
                }

            });
            $('#report_filter').on('change', function () {
                $('#usersdaterange').trigger('apply.daterangepicker');
            });

            // User wise report
            $(document).on('click', '.spec_aff_country', function () {
                if (!$(this).hasClass("collapsed")) {
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
                            $('.' + card_id).html(data.data.table);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alertbox('Error', 'No data found', 'error');
                        }
                    });
                }
            });
            function populate_user_table() {
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
                    success: function (response) {
                        $("#report_data").html("");
                        if (response.data.length > 0) {
                            var earning = 0;
                            var total_clicks = 0;
                            $.each(response.data, function (i, elem) {
                                earning = parseFloat(earning) + parseFloat(elem.earning);
                                total_clicks = parseFloat(total_clicks) + parseFloat(elem.count);
                                $('#report_data').append(
                                    '<tr>' +
                                    '<td width="60%">' + elem.name + '<button id="' + elem.user + '" class="pull-right spec_aff_country btn btn-outline-secondary btn-xs" data-toggle="collapse" data-target="#collapse_' + elem.user + '"> Country wise traffic</button>' +
                                    '<br><div class="collapse" id="collapse_' + elem.user + '">' +
                                    '<div class="card-body card col-md-12">' +
                                    '<table  class="table table-striped table-hover">' +
                                    '<thead>' +
                                    '<tr>' +
                                    '<th>Flag</th>' +
                                    '<th>Country</th>' +
                                    '<th>Clicks</th>' +
                                    '<th>Earning</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody class="card_' + elem.user + '">' +
                                    '</tbody>' +
                                    '</table>' +
                                    '</div></div></td>' +
                                    '<td width="20%">' + elem.count + '</td>' +
                                    '<td width="20%">$' + parseFloat(elem.earning).toFixed(2) + '</td>' +
                                    '</tr>');
                            });
                            $('.info_tab').show();
                            $('.earning').html('$' + earning.toFixed('3'));
                            $('.total_clicks').html(total_clicks);
                        }
                        else {
                            $('.info_tab').hide();
                            $("#report_data").html("");
                            $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                        }
                    },
                    error: function () {
                        $("#databody").html("No data found, Please provide Valid Date Range");
                    }
                });
            }

            // Campaign wise report
            function populate_campaign_table() {
                var start = $('#usersdaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var end = $('#usersdaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                $.ajax({
                    url: 'affiliate_campaign_traffic_summary',
                    type: 'POST',
                    dataType: "json",
                    data: { start_date: start, end_date: end, username: "" },
                    success: function (response) {
                        $('#report_data').html("");
                        if (response.data.length > 0) {
                            var earning = 0;
                            var total_clicks = 0;
                            $.each(response.data, function (i, elem) {
                                earning = parseFloat(earning) + parseFloat(elem.earn);
                                total_clicks = parseFloat(total_clicks) + parseFloat(elem.click);
                                $('#report_data').append('<tr>' +
                                    '<td width="60%">' + (elem.text).substr(0, 90) + '...' +
                                    '<button id="' + elem.cpid + '" class="pull-right spec_camp_country btn btn-outline-secondary btn-xs" data-toggle="collapse" data-target="#collapse_' + elem.cpid + '"> Country wise traffic</button>' +
                                    '<br><div class="collapse" id="collapse_' + elem.cpid + '">' +
                                    '<div class="card_' + elem.cpid + ' card-body card col-md-12"> </div> </div></td>' +
                                    '<td width="20%">' + elem.click + ' ' +
                                    '<td width="20%">$' + parseFloat(elem.earn).toFixed(3) + '</td>' +
                                    '</td>');
                            });
                            $('.info_tab').show();
                            $('.earning').html('$' + earning.toFixed('3'));
                            $('.total_clicks').html(total_clicks);
                        } else {
                            $('.info_tab').hide();
                            $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                        }
                    }
                });
            }
            $(document).on('click', '.spec_camp_country', function () {
                if (!$(this).hasClass("collapsed")) {
                    var card_id = 'card_' + $(this).attr('id');
                    var start = $('#usersdaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#usersdaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
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

            // Country wise report
            function populate_country_table() {
                var start = $('#usersdaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var end = $('#usersdaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var dataOBJ = {
                    'username': '',
                    'start': start,
                    'end': end,
                }
                $.ajax({
                    type: "POST",
                    url: "affiliate_country_traffic_summary",
                    data: dataOBJ,
                    dataType: "json",
                    success: function (response) {
                        $('#report_data').html('');
                        if (response.status) {
                            var earning = 0;
                            var total_clicks = 0;
                            $.each(response.data, function (i, elem) {
                                earning = parseFloat(earning) + parseFloat(elem.earn);
                                total_clicks = parseFloat(total_clicks) + parseFloat(elem.click);
                                var row = '<tr>';
                                row += '<td width="60%"><img class="mr-2" src="assets/general/flags/' + elem.code + '.png">' + elem.country + '</td>';
                                row += '<td width="60%">' + elem.click + '</td>';
                                row += '<td width="60%">$' + elem.earn + '</td>';
                                row += '</tr>';
                                $('#report_data').append(row);
                            });
                            $('.info_tab').show();
                            $('.earning').html('$' + earning.toFixed('3'));
                            $('.total_clicks').html(total_clicks);
                        }
                        else {
                            $('.info_tab').hide();
                            $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                        }
                    },
                    error: function () {
                        $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                    }
                });
            }

            $('#report_filter').trigger('change');
        });
    </script>