 <script>
     $(document).ready(function() {
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
         $('#usersdaterange').on('apply.daterangepicker', function(ev1, picker1) {
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
         $('#report_filter').on('change', function() {
             $('#usersdaterange').trigger('apply.daterangepicker');
         });

         // User wise report
         $(document).on('click', '.spec_aff_country', function() {
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
                     success: function(data) {
                         $('.' + card_id).html(data.data.table);
                     },
                     error: function(xhr, ajaxOptions, thrownError) {
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
                 success: function(response) {
                     $("#report_data").html("");
                     if (response.data.length > 0) {
                         var earning = 0;
                         var total_clicks = 0;
                         $.each(response.data, function(i, elem) {
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
                     } else {
                         $('.info_tab').hide();
                         $("#report_data").html("");
                         $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                     }
                 },
                 error: function() {
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
                 data: {
                     start_date: start,
                     end_date: end,
                     username: ""
                 },
                 success: function(response) {
                     $('#report_data').html("");
                     if (response.data.length > 0) {
                         var earning = 0;
                         var total_clicks = 0;
                         $.each(response.data, function(i, elem) {
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
         $(document).on('click', '.spec_camp_country', function() {
             if (!$(this).hasClass("collapsed")) {
                 var card_id = 'card_' + $(this).attr('id');
                 var start = $('#usersdaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                 var end = $('#usersdaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                 $.ajax({
                     type: 'GET',
                     url: 'affiliate_individual_country_traffic_summary',
                     data: {
                         cpid: $(this).attr('id'),
                         username: null,
                         start_date: start,
                         end_date: end
                     },
                     success: function(data) {
                         $('.' + card_id).html(data.card_content);
                     },
                     error: function(xhr, ajaxOptions, thrownError) {
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
                 success: function(response) {
                     $('#report_data').html('');
                     if (response.status) {
                         var earning = 0;
                         var total_clicks = 0;
                         $.each(response.data, function(i, elem) {
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
                     } else {
                         $('.info_tab').hide();
                         $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                     }
                 },
                 error: function() {
                     $("#report_data").html("<tr><td colspan='4' class='text-center'>No data found</td></tr>");
                 }
             });
         }

         $('#report_filter').trigger('change');
     });
 </script>