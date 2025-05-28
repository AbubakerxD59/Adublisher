<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box shadow">
            <div class="inner">
                <h3><?php echo $insights['followers']; ?></h3>
                <p><strong>Fans</strong></p>
            </div>
            <div class="icon">
                <i class="fa fa-user text-sky-blue"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box shadow">
            <div class="inner">
                <h3><?php echo $insights['impressions']; ?></h3>
                <p><strong>Impressions</strong></p>
            </div>
            <div class="icon">
                <i class="fa fa-earth-americas text-sky-blue"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box shadow">
            <div class="inner">
                <h3><?php echo $insights['engagements']; ?></h3>
                <p><strong>Post Engagement</strong></p>
            </div>
            <div class="icon">
                <i class="fa fa-users text-sky-blue"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box shadow">
            <div class="inner">
                <h3><?php echo $insights['likes']; ?></h3>
                <p><strong>Page Likes</strong></p>
            </div>
            <div class="icon">
                <i class="fa fa-thumbs-up text-sky-blue"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card card-danger col-6">
        <div class="card-header">
            <h3 class="card-title"><strong>Reactions</strong></h3>
        </div>
        <div class="card-body">
            <canvas id="pieChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
    <div class="card card-primary col-6">
        <div class="card-header">
            <h3 class="card-title"><strong>Interactions</strong></h3>
        </div>
        <div class="card-body">
            <canvas id="pieChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
</div>


<script>
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChart1Canvas = $('#pieChart1').get(0).getContext('2d')
    var donutData1 = {
        labels: [
            'Like',
            'Love',
            'Haha',
            'Wow',
            'Cry',
            'Anger',
        ],
        datasets: [
            {
                data: [<?php echo $insights['likes'].','.$insights['love'].','.$insights['haha'].','.$insights['wow'].','.$insights['cry'].','.(int) $insights['anger']; ?>],
                backgroundColor: ['#00a65a', '#dc3545', '#35dc3a', '#e6f092', '#92f0e2', '#de7f4f'],
            }
        ]
    }
    var pieData1 = donutData1;
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChart1Canvas, {
        type: 'pie',
        data: pieData1,
        options: pieOptions
    })
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChart2Canvas = $('#pieChart2').get(0).getContext('2d')
    var donutData2 = {
        labels: [
            'Reactions',
            'Shares',
            'Link Clicks',
            'Photo Vews',
            'Video views'
        ],
        datasets: [
            {
                data: [<?php echo $insights['reactions'].','.$insights['shares'].','.$insights['link_clicks'].','.$insights['photo_views'].','.$insights['video_views']; ?>],
                backgroundColor: ['#00a65a', '#dc3545', '#35dc3a', '#e6f092', '#92f0e2', '#de7f4f'],
            }
        ]
    }
    var pieData2 = donutData2;
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChart2Canvas, {
        type: 'pie',
        data: pieData2,
        options: pieOptions
    })
</script>