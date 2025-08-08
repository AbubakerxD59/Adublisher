<script src="<?=GeneralAssets ?>plugins/angular/ownerdashboard.js"></script>
<link href="<?=GeneralAssets ?>plugins/css-chart/css-chart.css" rel="stylesheet">
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper" ng-controller="ownerdashboard">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->

<div class="container-fluid">
<div>
	<div>
    <?php
        $upr  =  user_pr();
        $account = $upr['ptu']->active;
    ?>
		<div class="card simple-card">
			<div class="card-body">
				<!-- <h2 class="text-center mt-2 m-b-0">Welcome, <?=App::Session()->get('fullname');?></h2>
				<p class="text-center text-muted">Your current {{resources.trial}} <span class="font-bold">{{resources.package.title}} Package</span> {{resources.package.price |currency:"$" }}/Month  will end on <?=App::Session()->get('mem_expire')?>  <a href="<?=SITEURL?>payments-and-subscriptions">Manage..</a></p> -->
                <?php
                 echo @$upr['pxn'];
                 echo loader();
                 ?>
                <div class="row m-0 col-12">
                    <div class="col-md-12">

                        <?php if(!empty($user->pinterest_error && $pinterest_boards)){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong><img style='width:25px;height:25px; margin-left: -5px; margin-top: -2px;' src='<?= GeneralAssets ?>images/pinterest_logo.png' class='rounded' alt='profile_pic'>Attention Required!</strong><br>
                            We have identified issues with your Pinterest account. <strong><?php print_r($user->pinterest_error);?></strong>
                          <button type="button" class="close close_alert" aria-label="Close" style="top:-1.35rem;" data-type="pinterest" data-id="<?= $user->id ?>">
                            <span class="hover" aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?php }?>

                        <?php if(!empty($user->facebook_page_error && $user_pages)){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong><img style='width:25px;height:25px; margin-left: -5px; margin-top: -2px;' src='<?= GeneralAssets ?>images/facebook_logo.png' class='rounded' alt='profile_pic'>Attention Required!</strong><br>
                            We have identified issues with your Facebook account. <strong><?php print_r($user->facebook_page_error);?></strong>
                          <button type="button" class="close close_alert" aria-label="Close" style="top:-1.35rem;" data-type="fb_page" data-id="<?= $user->id ?>">
                            <span class="hover" aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?php }?>

                        <?php if(!empty($user->instagram_error && $ig_accounts)){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong><img style='width:18px;height:18px;' src='<?= GeneralAssets ?>images/instagram_logo.png' class='rounded' alt='profile_pic'>&nbsp;Attention Required!</strong><br>
                            We have identified issues with your Instagram account. <strong><?php print_r($user->instagram_error);?></strong>
                          <button type="button" class="close close_alert" aria-label="Close" style="top:-1.35rem;" data-type="instagram" data-id="<?= $user->id ?>">
                            <span class="hover" aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?php }?>

                        <?php if(!empty($user->facebook_group_error && $fb_groups)){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong><img style='width:18px;height:18px;' src='<?= GeneralAssets ?>images/fb_group_logo.png' class='rounded' alt='profile_pic'>&nbsp;Attention Required!</strong><br>
                            We have identified issues with your Facebook account. <strong><?php print_r($user->facebook_group_error);?></strong>
                          <button type="button" class="close close_alert" aria-label="Close" style="top:-1.35rem;" data-type="fb_group" data-id="<?= $user->id ?>">
                            <span class="hover" aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <?php }?>

                        <div class="card card-body">
                            <form class="input-form p-0 m-t-10" style="line-height: 0;" action="#" method="post" id="shorten_link">
                                <div class="input-group">
                                    <input type="url" id="url" class="form-control m-l-5" placeholder="Shorten your link...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Shorten!
                                    </button>
                                    </span>
                                </div>
                                <div class="row mt-2" id="shorted_link_container" > 
                                   
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col pr-0 align-self-center">
                                    <h2 class="font-weight-light mb-0">{{resources.affiliates}}/{{resources.affiliates_quota}}</h2>
                                    <h6 class="text-muted"><a class="link" href="<?=SITEURL?>affiliate-team">Affiliates <i class="fa fa-external-link"></i></a></h6>
                                    <h6 class="text-muted">left {{resources.affiliates_left}} </h6>
                                </div>
                                <!-- Column -->
                                <div class="col text-right align-self-center">
                                    <div data-label="{{resources.affiliates_percent}}%" class="css-bar mb-0 {{resources.affiliates_class}} css-bar-{{resources.affiliates_percent_c}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col pr-0 align-self-center">
                                    <h2 class="font-weight-light mb-0">{{resources.campaigns}}/{{resources.campaigns_quota}}</h2>
                                    <h6 class="text-muted"><a class="link" href="<?=SITEURL?>campaigns">Campaigns <i class="fa fa-external-link"></i></a></h6>
                                    <h6 class="text-muted">left {{resources.campaigns_left}}</h6>
                                </div>
                                <!-- Column -->
                                <div class="col text-right align-self-center">
                                    <div data-label="{{resources.campaigns_percent}}%" class="css-bar mb-0 {{resources.campaigns_class}} css-bar-{{resources.campaigns_percent_c}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col pr-0 align-self-center">
                                    <h2 class="font-weight-light mb-0">{{resources.bulkupload}}/{{resources.bulkupload_quota}}</h2>
                                    <h6 class="text-muted"><a class="link" href="<?=SITEURL?>facebookbulkupload">Bulk Uploads <i class="fa fa-external-link"></i></a></h6>
                                    <h6 class="text-muted">left  {{resources.bulkupload_left}}</h6>
                                </div>
                                <!-- Column -->
                                <div class="col text-right align-self-center">
                                    <div data-label="{{resources.bulkupload_percent}}%" class="css-bar mb-0 {{resources.bulkupload_class}} css-bar-{{resources.bulkupload_percent_c}}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hide">
                        <div class="card card-body">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col pr-0 align-self-center">
                                    <h2 class="font-weight-light mb-0">unlimited</h2>
                                    <h6 class="text-muted">Rss and auto post</h6>
                                    <h6 class="text-muted">no-limit</h6>
                                </div>
                                <!-- Column -->
                                <div class="col text-right align-self-center">
                                    <div data-label="no-limit" class="css-bar mb-0 css-bar-success css-bar-20"></div>
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <h3 class="card-title">Clicks summary</h3>
                                <div class="ml-auto">
                                   <a class="btn btn-outline-secondary" href="<?=SITEURL?>affiliate-traffic-summary">Goto details</a>
                                </div>
                            </div>
								<div class="d-flex align-items-center flex-row ">
									<div class="p-2 display-5 text-info"><i class="wi wi-day-sunny"></i>
										<span>{{today_clicks}}</span>
									</div>
									<div class="p-2">
										<h3 class="m-b-0">TODAY</h3>
										<small>clicks</small>
									</div>
								</div>
								<table class="table table-borderless m-b-0">
									<tbody>
										<tr>
											<td></td>
											<td class="font-medium">Clicks</td>
											<td class="font-medium">Earnings</td>
										</tr>
										<tr>
											<td>Today</td>
											<td class="font-medium">{{today_clicks | number}}</td>
											<td class="font-medium">{{today_earning | currency:"$"}}</td>
										</tr>
										<tr>
											<td>Week</td>
											<td class="font-medium">{{dashboard.widgets.weekly_clicks | number}}</td>
											<td class="font-medium">{{dashboard.widgets.weekly_earning | currency:"$"}}</td>
										</tr>
										<tr>
											<td>All Time</td>
											<td class="font-medium">{{alltime_clicks | number}}</td>
											<td class="font-medium">{{alltime_earning  | currency:"$"}}</td>
										</tr>
									</tbody>
								</table>
                               <hr class="m-t-0 m-b-0">
                               <ul class="list-unstyled row text-center city-weather-days">
                                    <li class="col p-b-0">
                                        <i class="mdi mdi-currency-usd"></i><span>TOTAL</span>
                                        <h3>{{alltime_earning | currency:"$"}}</h3>
                                    </li>
                                    <li class="col p-b-0">
                                        <i class="mdi mdi-arrow-top-right"></i><span>PAID</span>
                                        <h3>{{total_paid | currency:"$"}}</h3>
                                    </li>
                                    <li class="col p-b-0">
                                        <i class="mdi mdi-bank"></i><span>UNPAID</span>
                                        <h3>{{unpaid | currency:"$" || number:2 }} </h3>
                                    </li>
                                </ul>
							</div>
						</div>
					</div>
					<div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                    <div class="p-1">
										<h3 class="card-title m-b-0">Weekly Stats</h3>
										<small>grouped by weekdays</small>
									</div>
                              
                                <div class="ml-auto">
                                   <a  class="btn btn-outline-secondary" href="<?=SITEURL?>affiliate-traffic-summary">Goto details</a>
                                </div>
                            </div>
                           
                                <canvas chart-options=""  class="chart chart-bar"  chart-data="weekclicks"  chart-labels="weeklabels"> </canvas>
                            </div>
                        </div>
					</div>

					
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center flex-row">
									<div class="p-2">
										<h3 class="m-b-0">Weekly Stats</h3>
										<small>grouped by country</small>
									</div>
								</div>
							</div>
							<div class="card-body p-1">
								<canvas  chart-options=""  class="chart chart-bar"  chart-data="weeklycountryclicks"  chart-labels="weeklycountrylabels"> </canvas>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center flex-row">
									<div class="p-2">
										<h3 class="m-b-0">Our Visitors</h3>
										<small>Different Devices Used to Visit</small>
									</div>
								</div>
							</div>
							<div class="card-body p-0">
								<canvas  chart-options="options" class="chart chart-doughnut"
									chart-data="datadevice" chart-colors="" chart-labels="labelsdevice">
								</canvas>
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
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<?php $this->load->view('templates/publisher/footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/angular-chart.min.js"></script>  
<script src="<?=AdminAssets ?>js/dashboard.js?v=<?=BUILDNUMBER?>"></script>
<script type="text/javascript">
	$(function(){
	
        $(document).on('click', ".caption", function ()
        {
            clipboard.copy($(this).data('caption'));
            alertbox("Information", "Text Copied to Clipboard", 'info');
        });

	    $('#country_traffic').slimScroll({
	        height: '435px'
	    });
	    $('#top_users').slimScroll({
	        height: '490px'
	    });
        $('#shorten_link').submit(function(e) {
        e.preventDefault();
        var url = $("#url").val();
        $.ajax({
            type: "POST",
            url: "<?php echo ADUBSHORTLINK;?>short_my_link",
            data: {'url':url},
            dataType: "json",
            success: function(response) {
                $("#shorted_link_container").html("");
                if (response.status) {
                    console.log(response);
                    $("#shorted_link_container").html(
                    '<div class="col-md-12 pl-4 pt-2">'+
                            '<p><a href="javascript:void(0);" class="link mr-2 caption h5  cursor-pointer" data-caption="'+response.link+'" data-toggle="tooltip" title="" data-original-title="Copy link address"> '+response.link+' <i class="mdi mdi-content-copy"></i></a></p>'+
                    '</div>');
                    $('[data-toggle="tooltip"]').tooltip()

                var clipboard = new ClipboardJS('.click_to_copy');
                }else{

                    $("#shorted_link_container").html(
                    '<div class="col-md-12">'+
                    '<div class="features-single p-3 mb-2" style="border-bottom: 2px solid #f44336;">'+
                    '<div class="content mb-0 pl-4 pr-3 pt-1">'+
                    '<h4 class="text-danger" >Something Went Wrong</h4>'+
                    '<p class="text-danger">'+response.message+'</p>'+
                    '</div>'+
                    '<div class="icon pr-0">'+
                    '<i class="icofont-error text-danger"></i>'+
                    '</div>'+
                    '</div>'+
                    '</div>');
                   
                }
            },
            error: function() {
            alertbox("Error" , "Nothing Has been changed, try again" ,  "error");
            }
        });       
    });
	
	});
</script>
<script>
    $(document).ready(function () {
        $('.close_alert').click(function () {
            var type = $(this).data('type');
            var id = $(this).data('id');
            var closeButton = $(this);
            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you have fixed the respective error?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Are you sure ?',
                cancelButtonText: 'Cancel',
            }, function (isConfirmed) {
                if (isConfirmed) {
                    $.ajax({
                        url: "<?php echo SITEURL; ?>" + 'cron_job_error',
                        method: 'POST',
                        data: { id: id, type: type },
                        success: function (response) {
                            // On success, manually close the alert
                            closeButton.closest('.alert').alert('close');
                            swal("Cleared!", "The respective error is cleared Successfully", "success");
                        },
                        error: function (xhr, status, error) {
                            // Handle errors here
                            console.error(error);
                            swal("Cleared!", "Something went wrong please try again", "failed");
                        }
                    });
                }
            });
        });
    });
</script>