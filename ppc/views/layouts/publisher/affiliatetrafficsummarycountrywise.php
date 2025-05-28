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
                        <h2 class="text-center mt-2 m-b-0">Country traffic reports</h2>
                        <p class="text-center text-muted m-b-0">Check traffic by your campaigns in one page, earning and
                            clicks reports list view.</p>
                        <?php
                        echo loader();
                        ?>
                        <div class="row m-0 p-10">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header mt-3">
                                        <div class="row m-0 p-10">
                                            <div class="col-md-6">
                                                <h4 class="card-title m-b-0">Country traffic reports</h4>
                                            </div>
                                            <div class="col-md-3">

                                                <select id="userfilter" class="form-control form-control-sm">
                                                    <option value="">All Affiliates</option>
                                                    <?php
                                                    foreach ($users as $row) {
                                                        echo '<option value="' . $row->username . '">' . $row->fname . " " . $row->lname . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <div id="reportrange" class="form-control form-control-sm pull-right">
                                                    <i class="fa fa-calendar"></i> &nbsp; <span></span> &nbsp;<b
                                                        class="fa fa-caret-down"></b>&nbsp;
                                                </div>
                                            </div>
                                        </div>
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
                                                    <th>Flag</th>
                                                    <th>Country</th>
                                                    <th>Clicks</th>
                                                    <th>Earning </th>
                                                </tr>
                                            </thead>
                                            <tbody id="databody">
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

            var start_article = moment().subtract(6, 'days');
            var start = moment().subtract(1, 'weeks');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Week': [moment().subtract(1, 'weeks'), moment()],
                    'All Time': [moment().subtract(1, 'year'), moment()]
                }
            }, cb);


            cb(start, end);
            setTimeout(function () {

                populate_table();

            }, 1500);
            $("#userfilter").change(function () {

                populate_table();
            });

            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {

                populate_table();


            });
            function populate_table() {

                $("#loader").show();
                var username = $("#userfilter").val();
                var start = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var end = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var dataOBJ = {
                    'username': username,
                    'start': start,
                    'end': end,
                    'action': 'getcountrywise',
                }
                $.ajax({
                    type: "GET",
                    url: "getcountrywisepublisher",
                    data: dataOBJ,
                    dataType: "json",
                    success: function (response) {
                        $("#loader").hide();
                        if (response.status) {
                            $("#databody").html(response.data.table);
                            $("#summary").html(response.data.summary);
                        } else {
                            $("#summary").html("");
                            $("#databody").html("<tr><td colspan='4' class='text-center'>No data found, Please provide Valid Date Range</td></tr>");
                        }
                    },
                    error: function () {
                        $("#loader").hide();
                        $("#summary").html("");
                        $("#databody").html("<tr><td colspan='4' class='text-center'>No data found, Please provide Valid Date Range</td></tr>");

                    }
                });


            }
        });

    </script>