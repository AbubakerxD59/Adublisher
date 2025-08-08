<script src="<?=GeneralAssets ?>plugins/angular/ngdashboardupdates.js"></script>


<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper" ng-controller="adubdashboard">
<!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                <?php
                    $upr  =  user_pr();
                    $account = $upr['ptu']->active;
                ?>
                  <div class="card simple-card">
                    <div class="card-body">
                      <!-- <h2 class="text-center mt-4">Welcome, <?=App::Session()->get('fullname');?></h2>
                      <p class="text-center text-muted">You are, the part of Adublisher affiliate program.<br> you can share campaigns and auto schedule by using our powerfull tools <a href="">Learn more..</a></p> -->
                      <?php
                            echo @$upr['pxn'];
                            echo loader();
                        ?> 
                        <div class="row m-0 p-10"> 
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
                                    We have identified issues with your Facebbok account. <strong><?php print_r($user->facebook_group_error);?></strong>
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                    <ul class="list-unstyled row text-center city-weather-days">
                                                <li class="col"><i class="mdi mdi-currency-usd"></i><span>TOTAL</span>
                                                    <h3>{{dashboard.widgets.alltime_earning | currency}}</h3>
                                                </li>
                                                <li class="col"><i class="mdi mdi-arrow-top-right"></i><span>WITHDRAW</span>
                                                    <h3>{{dashboard.widgets.total_paid | currency}}</h3>
                                                </li>
                                                <li class="col"><i class="mdi mdi-bank"></i><span>BALANCE</span>
                                                    <h3>{{dashboard.widgets.totalpending | currency}}</h3>
                                                </li>
                                                
                                            </ul>
                                    </div>
                                </div>
                            </div>        
                            
                            
                            <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                            </div>
                                            <div class="d-flex align-items-center flex-row m-t-30">
                                                <div class="p-2 display-5 text-info"><i class="wi wi-day-sunny"></i>
                                                    <span>{{dashboard.widgets.todayclick}}</span>
                                                </div>
                                                <div class="p-2">
                                                    <h3 class="m-b-0">TODAY</h3><small>clicks</small>
                                                </div>
                                            </div>
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td class="font-medium">Clicks</td>
                                                        <td class="font-medium">Earnings</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Yesterday</td>
                                                        <td class="font-medium">{{dashboard.widgets.yesterday_clicks}}</td>
                                                        <td class="font-medium">{{dashboard.widgets.yesterday_earn | currency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Today</td>
                                                        <td class="font-medium">{{dashboard.widgets.todayclick}}</td>
                                                        <td class="font-medium">{{dashboard.widgets.todayearn | currency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Week</td>
                                                        <td class="font-medium">{{dashboard.widgets.week_clicks}}</td>
                                                        <td class="font-medium">{{dashboard.widgets.week_earn | currency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>All Time</td>
                                                        <td class="font-medium">{{dashboard.widgets.alltime_clicks}}</td>
                                                        <td class="font-medium">{{dashboard.widgets.alltime_earning  | currency}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas style="max-height:350px;" id="line" class="chart chart-bar" chart-data="data"
                                                chart-labels="labels" chart-series="series" chart-options="options"
                                                chart-dataset-override="datasetOverride" chart-click="onClick">
                                        </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
<?php 
$this->load->view('templates/publisher/footer'); 
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/angular-chart.min.js"></script>  
<script>    
$(function () {

   
    $(document).on('click', ".caption", function ()
        {
            clipboard.copy($(this).data('caption'));
            alertbox("Information", "Text Copied to Clipboard", 'info');
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
    $('#top_users').slimScroll({
        height: '350px'
    });

      $('#top_campaigns').slimScroll({
        height: '350px'
    });

   $.ajax({
    url:'get_gmt_status',
    data:{gmt:Intl.DateTimeFormat().resolvedOptions().timeZone , id:$('#loggeduserid').val()},
    type:'GET',
    success:function(data){
        if(data.status===false)
        {
         //  swal({   
         //         title: "TimeZone Changed",   
         //         text: "Hi,"+ $('#loggedUsername').val() +" "+data.Message+". Please Select your current Time zone by navigating to update profile menu.",   
         //         type: "info",   
         //     });
        }
    },
    error:function(data)
    {
      
    }

   });

   $(document).on('click','.change_status',function(){
    $.ajax({

            url:'change_announce_view',
            type:'GET',
            data : {announce_id : $(this).attr('id'), pub_id : $('#loggeduserid').val()},
            success : function(data){
             location.reload();

            },
            error:function(data)
            {
              location.reload();
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