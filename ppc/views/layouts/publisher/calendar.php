<link rel="stylesheet" href="<?php echo PublisherAssets . 'css/calendar.css'; ?>">
<link rel="stylesheet" href="<?php echo NewLandingAssets . 'infinity_preloader.css'; ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="page-wrapper">
    <div class="container-fluid">
        <div>
            <div>
                <div class="card simple-card">
                    <div class="card-body py-0">
                        <div class="card-body py-0">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade event-info-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content popup-body-content">
        </div>
    </div>
</div>
<!-- infinity preloader -->
<div class="infinity_preload">
    <?php echo infinity_preloader(); ?>
</div>
<?php
$this->load->view('templates/publisher/footer');
?>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js">
</script>
<!-- <script src="<?php echo AdminAssets . 'js/custom.min.js'; ?>"></script> -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script type="text/javascript" src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var calendar;
    // var fb_offset = 0;
    // var fb_page = 1;
    // Get list of Events from ajax call
    var get_calendar_events = function (info, successCallback) {
        var type = $('.fc-button-active').html();
        $.ajax({
            type: 'GET',
            url: '<?php echo SITEURL; ?>calendar_events',
            data: {
                start: info.startStr,
                end: info.endStr,
                type: type,
                // fb_offset: fb_offset
            },
            success: function (response) {
                var data = response.data;
                var eventsArray = [];
                $.each(data, function (key, value) {
                    var event = {
                        id: value.id,
                        title: value.title,
                        start: value.start,
                        className: value.className,
                    }
                    eventsArray.push(event);
                });
                successCallback(eventsArray);
            }
        });
    }

    var clear_cache = function () {
        var type = $('.fc-button-active').html();
        var date = $('#fc-dom-1').html();
        $.ajax({
            type: 'GET',
            url: '<?php echo SITEURL; ?>clear_calendar_cache',
            data: {
                type: type,
                date: date
            },
            success: function (response) {
                $('.fc-button-active').trigger('click');
                alertbox('Success', 'Cache cleared Successfully!', 'success');
            }
        });
    }

    // Render Calendar View
    var calendar_render = function () {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "timeGridDay",
            showNonCurrentDates: false,
            customButtons: {
                clearCache: {
                    text: 'Clear Cache',
                    click: function () {
                        clear_cache();
                    }
                }
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'clearCache,dayGridMonth,timeGridWeek,timeGridDay'
            },
            titleFormat: {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            },
            buttonText: {
                today: 'TODAY',
                month: 'MONTH',
                week: 'WEEK',
                day: 'DAY',
            },
            height: 'auto',
            events: function (info, successCallback, failureCallback) {
                get_calendar_events(info, successCallback);
            },
            eventContent: function (info) {
                return {
                    html: info.event.title
                };
            },
            eventClick: function (info) {
                var id = info.event.id;
                if (id == 'us_event' || id.includes('pending')) {
                    return true;
                }
                var infinity_preloader = $('.infinity_preload').html();
                $('.event-info-modal').modal('toggle');
                $('.modal-content').addClass('d-flex justify-content-center align-items-center').html(infinity_preloader);
                get_event_info(id);
            }
        });
        calendar.render();
    }
    calendar_render();
    // Re-render calendar
    $(document).on('click', '.fc-dayGridMonth-button, .fc-timeGridWeek-button, .fc-timeGridDay-button', function () {
        calendar.refetchEvents();
    });
    $('.fc-timeGridDay-button').trigger('click');
    // Get Event Info
    var get_event_info = function (id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo SITEURL; ?>get_event_info',
            data: { id: id },
            success: function (response) {
                if (response != null && response != '' && response != undefined) {
                    $('.modal-content').removeClass('d-flex justify-content-center align-items-center').html(response.data);
                    if (response.followers > 0 || response.non_followers > 0) {
                        console.log('here');
                        console.log(response.followers);
                        console.log(response.non_followers);
                        chart(response.followers, response.non_followers);
                    }
                }
            }
        });
    }
    // Followers/Non-Followers Chart
    var chart = function (followers, non_followers) {
        var xValues = ["Followers", "Non-followers"];
        var yValues = [followers, non_followers];
        var barColors = [
            "#2b5797",
            "#1e7145"
        ];
        new Chart("reach_chart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
            }
        });
    };
</script>