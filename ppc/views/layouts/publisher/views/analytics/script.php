<script src="<?php echo ASSETURL . 'js/dashboard.js'; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<script type="text/javascript" src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    $(document).ready(function() {
        // fetch recent post function
        var recent_posts = $('#recent_posts_table').DataTable({
            serverSide: true,
            searching: false,
            lengthChange: false,
            paging: false,
            processing: $('.infinity_preload').html(),
            iDisplayLength: '10',
            order: [
                [0, 'desc']
            ],
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>recent_posts',
                data: function(data) {
                    data.social_type = $('#social_type').val();
                    data.sub_social = $('#page_board_channel').val();
                    data.search = $('#search_recent_posts').val();
                    data.current_page = $('#current_page').val();
                    data.date = $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val();
                    data.type = $('#selected_type').val();
                    data.paging = $('#recent_posts_pagination').val();
                },
                complete: function(response) {
                    response = response.responseJSON;
                    var status = response.status;
                    var message = response.message;
                    if (status) {
                        $('.post__insights__pagination__container').show();
                        var current_page = response.current_page;
                        var total_pages = response.total_pages;
                        var pagination_message = 'Page ' + current_page + ' of ' + total_pages;
                        $('#current_page').val(current_page);
                        $('#total_pages').val(total_pages);
                        $('.pagination__info').html(pagination_message);
                        var total_posts = response.iTotalRecords + ' Posts';
                        $('.posts_count').html(total_posts);
                    } else {
                        $('.posts_count').html('0 Posts');
                        $('.post__insights__pagination__container').hide();
                    }
                    var page_id = $('#page_board_channel').val();
                    var social_type = $('#social_type').val();
                    fetch_page_insight(page_id, social_type);
                    get_countries(page_id, social_type);
                    get_cities(page_id, social_type);
                }
            },
            columns: [{
                    data: 'post',
                    "orderable": true
                },
                {
                    data: 'type',
                    "orderable": false
                },
                {
                    data: 'reach',
                    "orderable": true
                },
                {
                    data: 'reach_rate',
                    "orderable": false
                },
                {
                    data: 'eng_rate',
                    "orderable": false
                },
                {
                    data: 'reactions',
                    "orderable": true
                },
                {
                    data: 'comments',
                    "orderable": true
                },
                {
                    data: 'shares',
                    "orderable": true
                },
                {
                    data: 'video_views',
                    "orderable": true
                },
                {
                    data: 'link_clicks',
                    "orderable": true
                },
                {
                    data: 'ctr',
                    "orderable": false
                },
                {
                    data: 'action',
                    "orderable": false
                },
            ]
        });
        var get_recent_posts = $('#get_recent_posts').DataTable({
            ordering: false,
            serverSide: true,
            searching: false,
            lengthChange: false,
            paging: false,
            processing: "<i class='fa fa-refresh fa-spin'></i>",
            iDisplayLength: '10',
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>get_recent_posts',
                data: function(data) {
                    data.social_type = $('#social_type').val();
                    data.sub_social = $('#page_board_channel').val();
                },
            },
            columns: [{
                    data: 'post'
                },
                {
                    data: 'type'
                },
                {
                    data: 'reach'
                },
                {
                    data: 'reach_rate'
                },
                {
                    data: 'eng_rate'
                },
                {
                    data: 'reactions'
                },
                {
                    data: 'comments'
                },
                {
                    data: 'shares'
                },
                {
                    data: 'video_views'
                },
                {
                    data: 'link_clicks'
                },
                {
                    data: 'ctr'
                },
                {
                    data: 'action'
                },
            ]
        });
        // ajax call for search in dataTable
        $('#search_recent_posts').on('keyup', function() {
            reset_current_page();
            reload_datatable();
        });
        // reset posts searchbar 
        $('#clear_posts_search').on('click', function() {
            reset_post_search();
            reset_current_page();
            $('#search_recent_posts').trigger('keyup');
        });
        // ajax call for selected date
        $('.date_pick').on('click', function() {
            reset_post_search();
            reset_current_page();
            $('.date_pick').removeClass('active_date');
            $(this).addClass('active_date');
            var selected_date = $(this).data('value');
            $('#selected_date').val(selected_date);
            var date_name = $(this).html();
            $('.selected_date').html(date_name);
            reload_datatable();
        });
        $('.type_pick').on('click', function() {
            reset_post_search();
            reset_current_page();
            $('.type_pick').removeClass('active_type');
            $(this).addClass('active_type');
            var selected_type = $(this).data('value');
            $('#selected_type').val(selected_type);
            var date_name = $(this).html();
            $('.selected_type').html(date_name);
            reload_datatable();
        });
        $('#recent_posts_pagination').on('change', function() {
            reload_datatable();
        });
        // ajax call for pagination in dataTable
        $('.previous_page').on('click', function() {
            var current_page = $('#current_page').val();
            if (current_page == 1 || current_page == null || current_page == '') {
                return false;
            } else {
                current_page = parseInt(current_page) - 1;
                $('#current_page').val(current_page);
                reload_datatable();
            }
        });
        $('.next_page').on('click', function() {
            var current_page = $('#current_page').val();
            var total_pages = $('#total_pages').val();
            if (current_page == total_pages) {
                return false;
            } else {
                current_page = parseInt(current_page) + 1;
                $('#current_page').val(current_page);
                reload_datatable();
            }
        });
        // datatable functions
        var reset_current_page = function() {
            $('#current_page').val(1);
        }
        var reset_post_search = function() {
            $('#search_recent_posts').val('');
        }
        var reload_datatable = function() {
            recent_posts.ajax.reload();
        }
        // ajax call for fetch page insight
        var fetch_page_insight = function(page_id, social_type) {
            var insights_array = ['followers_count', 'post_reach_count', 'engagements_count', 'video_views_count', 'link_clicks_count', 'ctr_count', 'eng_rate_count', 'reach_rate_count'];
            var infinity_preloader = $('.infinity_preload').html();
            $.each(insights_array, function(index, value) {
                $('.' + value).html(infinity_preloader);
            });
            $.ajax({
                url: "<?php echo SITEURL; ?>page_insights",
                type: "GET",
                data: {
                    page_type: social_type,
                    page_id: page_id,
                    date: $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val()
                },
                success: function(response) {
                    var data = response.data[0];
                    $.each(data, function(index, value) {
                        count = value.value > 0 ? value.value : 0
                        $('.' + index + '_count').html(value.value);
                        $('.' + index + '_chart_area').html(value.html);
                    });
                }
            })
        }
        // facebook page click
        $('.active_account__detail').on('click', function() {
            reset_current_page();
            var page_id = $(this).find('.select_account').data('id');
            var page_type = $(this).find('.select_account').data('type');
            var page_name = $(this).find('.select_account').data('name');
            var profile_pic = $(this).find('.select_account').data('image');
            $('#page_board_channel').val(page_id);
            $('#social_type').val(page_type);
            $('.page__name').html(page_name);
            if (page_id != '' && page_id != null && page_id != undefined) {
                check_insights_status(page_id, page_type);
                $('.sync__button').show();
            }
            if (profile_pic != '' && profile_pic != null && profile_pic != undefined) {
                profile_pic = "<?php echo SITEURL . '/assets/bulkuploads/' ?>" + profile_pic;
                $('.page__img img').attr('src', profile_pic);
            }
            $('.active_account__detail').removeClass('active_account badge-pill bg-secondary');
            $(this).addClass('active_account badge-pill bg-secondary');
            $('#page_board_channel').trigger('change');
        });
        // page(s) input
        $('#page_board_channel').on('change', function() {
            reload_datatable();
        });
        // refresh page and post insights
        $(document).on('click', '.refresh', function() {
            var page = $('#page_board_channel').val();
            var social = $('#social_type').val();
            page = (page == '' || page == null || page == undefined) ? 'all' : page;
            refresh_data(social, page);
        });
    });
    var refresh_data = function(social, page) {
        $.ajax({
            'url': '<?php echo SITEURL ?>refresh_insights',
            'type': 'POST',
            data: {
                'social': social,
                'page': page
            },
            success: function(response) {
                $('.refresh').addClass('bg-success');
                $('.fa-refresh').html('');
                var message = response.message;
                $('.refresh').html(message);
                $('.refresh').removeClass('refresh');
            }
        });
    }
    // insights status of facebook page
    var check_insights_status = function(page_id, page_type) {
        $.ajax({
            url: "<?php SITEURL ?>check_insights_status",
            type: "GET",
            data: {
                'page_id': page_id,
                'type': page_type
            },
            success: function(response) {
                var message = response.message;
                message = "<i class='fa fa-refresh mr-1'></i> " + message;
                if (response.status) {
                    $('.sync__button').removeClass('bg-success');
                    $('.sync__button').addClass('refresh');
                } else {
                    $('.sync__button').removeClass('refresh');
                    $('.sync__button').addClass('bg-success');
                }
                // add message
                $('.sync__button').html(message);
            }
        });
    }
    $(document).on('click', '.menu__list__post__toggler', function(event) {
        event.preventDefault();
        $(this).closest('.overview__post__menu').find('.menu__list__post').toggle();
    });
    $(document).on('click', '#recent_posts_table tbody tr', function(e) {
        var target = e.target;
        if (target.tagName === 'TD') {
            // Get the index of the cell
            var index = $(target).parent().children().index(target);
            // Check if the index is not the last column (assuming 0-based indexing)
            if (index !== $(target).parent().children().length - 1) {
                var post_id = $(this).find('.post__header').data('id');
                var post_type = $(this).find('.post__header').data('type');
                post_detail(post_id, post_type);
            } else {
                e.preventDefault();
            }
        }
    });
    $(document).on('click', '#get_recent_posts tbody tr', function() {
        var post_id = $(this).find('.post__header').data('id');
        var post_type = $(this).find('.post__header').data('type');
        post_detail(post_id, post_type);
    });
    $(document).on('click', '.post__content__data', function() {
        var post_id = $(this).find('.post__header').data('id');
        var post_type = $(this).find('.post__header').data('type');
        post_detail(post_id, post_type);
    });
    var post_detail = function(post_id, post_type) {
        var infinity_preloader = $('.infinity_preload').html();
        $('.popup-body-content').addClass('d-flex justify-content-center').html(infinity_preloader);
        $('#popup').show();
        $.ajax({
            url: "<?php echo SITEURL ?>get_post_info",
            type: "GET",
            data: {
                'id': post_id,
                'type': post_type
            },
            success: function(response) {
                if (response.status) {
                    $('.popup-body-content').removeClass('d-flex justify-content-center').html(response.data);
                    if (response.followers > 0 || response.non_followers > 0) {
                        var follower_config = {
                            xValue: response.followers + ' Followers',
                            yValue: response.followers,
                            barColor: "#2b5797",
                        }
                        var non_follower_config = {
                            xValue: response.non_followers + ' Non-ollowers',
                            yValue: response.non_followers,
                            barColor: "#1e7145",
                        }
                        chart(follower_config, non_follower_config);
                    }
                }
            }
        });
    }

    var top_count_chart = '';
    var get_countries = function(page_id, social_type) {
        $.ajax({
            url: "get_countires_data",
            type: "GET",
            data: {
                page_type: social_type,
                page_id: page_id,
                date: $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val()
            },
            success: function(response) {
                var data = response.data;
                if (response.count > 0) {
                    var labels = response.dates;
                    var dataset = [];
                    var borderColors = ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0'];
                    var backgroundColors = ['#cb433580', '#1F618D80', '#F1C40F80', '#27AE6080', '#884EA080'];
                    var i = 0;
                    $.each(data, function(country_name, array) {
                        var value_array = Object.values(array);
                        var temp_obj = {
                            label: country_name,
                            data: value_array,
                            borderColor: borderColors[i],
                            backgroundColor: backgroundColors[i],
                            borderWidth: 0.5
                        };
                        dataset.push(temp_obj);
                        i++;
                    });

                    $('#top_countries_container').html('');
                    if (top_count_chart != '' && top_count_chart != null) {
                        destroyCountryChart();
                    }
                    top_countries_chart(labels, dataset);
                } else {
                    $('.top_countries_no_result').show();
                    $('#top_countries_container').hide();
                }
            }
        });
    }

    var top_city_chart = '';
    var get_cities = function(page_id, social_type) {
        $.ajax({
            url: "get_cities_data",
            type: "GET",
            data: {
                page_type: social_type,
                page_id: page_id,
                date: $('#selected_date').val() == '' || $('#selected_date').val() == null ? 'last_7_days' : $('#selected_date').val()
            },
            success: function(response) {
                var data = response.data;
                if (response.count > 0) {
                    var labels = response.dates;
                    var dataset = [];
                    var borderColors = ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0'];
                    var backgroundColors = ['#cb433580', '#1F618D80', '#F1C40F80', '#27AE6080', '#884EA080'];
                    var i = 0;
                    $.each(data, function(city_name, array) {
                        var value_array = Object.values(array);
                        var temp_obj = {
                            label: city_name,
                            data: value_array,
                            borderColor: borderColors[i],
                            backgroundColor: backgroundColors[i],
                            borderWidth: 0.5
                        };
                        dataset.push(temp_obj);
                        i++;
                    });

                    $('#top_cities_container').html('');
                    if (top_city_chart != '' && top_city_chart != null) {
                        destroyCitiesChart();
                    }
                    top_cities_chart(labels, dataset);
                } else {
                    $('.top_cities_no_result').show();
                    $('#top_cities_container').hide();
                }
            }
        });
    }
    // horizontal chart for top cities
    var top_cities_chart = function(labels, datasets) {
        const xAxisLabels = labels;
        const data = {
            labels: xAxisLabels,
            datasets: datasets,
        };

        top_city_chart = new Chart("top_cities_container", {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    }
    // horizontal chart for top countries
    var top_countries_chart = function(labels, datasets) {
        const xAxisLabels = labels;
        const data = {
            labels: xAxisLabels,
            datasets: datasets,
        };

        top_count_chart = new Chart("top_countries_container", {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    }

    function destroyCountryChart() {
        top_count_chart.destroy();
    }

    function destroyCitiesChart() {
        top_city_chart.destroy();
    }
    // doughnot chart for post reach 
    var chart = function(follower_config, non_follower_config) {
        var xValues = [follower_config.xValue, non_follower_config.xValue];
        var yValues = [follower_config.yValue, non_follower_config.yValue];
        var barColors = [
            follower_config.barColor,
            non_follower_config.barColor
        ];
        new Chart("reach_chart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                    hoverOffset: 10
                }],
            }
        });
    };
    $(document).on('click', '.close-button', function() {
        $('#popup').hide();
    });
</script>