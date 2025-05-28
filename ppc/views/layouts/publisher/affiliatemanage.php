
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
<script src="<?=GeneralAssets ?>plugins/angular/managepublisherbyowner.js"></script>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper" ng-controller="adubpublisherprofile">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->

		<!-- ============================================ Edit Affiliate ================================================== -->
		<div class="modal fade" id="affiliateEdit" tabindex="-1" role="dialog" aria-labelledby="affiliateEditModalLabel1" style="display: none;" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="affiliateEditModalLabel1">Edit Affiliate</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                      </div>
                      <div class="modal-body">
                      <form class="form-horizontal form-material"  method="post" id="affiliatesignupform" action="#" autocomplete="off">

                            <div class="row m-r-5">
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                    <label for="name"> First Name</label>
                                    <input class="form-control" type="text" name="fname" id="fname" required placeholder="First Name" autocomplete="off" value="{{dashboard.publisher.fname}}" oninput="restrictToAlphabets('fname')">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="col-xs-12">
                                    <label for="name"> Last Name</label>
                                    <input class="form-control" type="text" name="lname" id="lname" placeholder="Last Name" autocomplete="off" value="{{dashboard.publisher.lname}}" oninput="restrictToAlphabets('lname')">
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="col-xs-12">
                                    <label for="username"> Username</label>
                                    <input class="form-control" type="text" name="username" id="username" required placeholder="Username" autocomplete="off" value="{{dashboard.publisher.username}}" oninput="restrictToAlphabets('username')">
                                </div>
                            </div>
                                                        <div class="form-group col-md-12">
                                <div class="col-xs-12">
                                <label for="email"> Email</label>
                                    <input class="form-control" type="text"  name="email" id="email" required placeholder="Email" autocomplete="off" value="{{dashboard.publisher.email}}">
                                </div>
                            </div>
                            <!-- <div class="form-group col-md-12">
                                <div class="col-xs-12">
                                <label for="Password"> Password</label>
                                    <input class="form-control" autocomplete="off" type="password"  name="password" id="password" required autocomplete="new-password">
                                </div>
                            </div> -->
                           <input type="hidden" name="timezone" id="timezone"  >
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                <button id="submitbutton"  class="btn btn-outline-secondary">Edit Account</button>
                            </div>
                            

                            </form>
                      </div>
                  </div>
              </div>
    </div>
    <!-- ========================================================= end edit ================================================= -->



		<div class="row">
			<div class="col-12">
				<div class="card simple-card">
					<div class="card-body">
						<h2 class="text-center mt-2 m-b-0"> Currently managing, {{dashboard.publisher.name}}</h2>
						<p class="text-center text-muted">Remove , edit your affiliate members, set ppc rates for individual member <br> Restrict/Assign particular domain to affiliate and much more.</p>
						<div class="row p-10 m-0">
						<div class="col-md-12">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs profile-tab" role="tablist">
							<li class="nav-item"> <a class="nav-link active customtab2" data-toggle="tab" href="#account" role="tab" aria-selected="false">Account Details</a> </li>
							<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#summary" role="tab" aria-selected="false">Performance</a> </li>
							<li class="nav-item hide"> <a class="nav-link" data-toggle="tab" href="#earning" role="tab" aria-selected="true">Earnings</a> </li>
							<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-selected="true">Affiliate settings</a> </li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="account" role="tabpanel">
								<div class="p-3">
									<div class="row">
										<div class="col-md-8">
											<p>Change status (Block/Approve affiliate account)</p>
										</div>
										<div class="col-md-4 text-right">
											<div class="switch">
												<label>BLOCK
													<input id="user-status-switch" ng-attr-data-id="{{dashboard.publisher.id}}" type="checkbox"    ng-model="userstatus"  ><span class="lever switch-col-light-blue"></span>APPROVE</label>
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<form class="form-horizontal" role="form">
											<div class="form-body">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Status:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"><label id="user-status-label" class="label label-default {{status}} ">{{dashboard.publisher.status}}</label> </p>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Full Name:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"> {{dashboard.publisher.fname}} {{dashboard.publisher.lname}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Email:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"> {{dashboard.publisher.email}} </p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6"> Username:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"> {{dashboard.publisher.username}} </p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Phone Number:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"> {{dashboard.publisher.ph}} </p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Facebook Profile Link:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"> {{dashboard.publisher.fbprofile}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Facebook Page Link:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static"> {{dashboard.publisher.fbpage}} </p>
															</div>
														</div>
													</div>
													<!--/span-->
													<!--/span-->
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Time Zone:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static">{{dashboard.publisher.gmt}} </p>
															</div>
														</div>
													</div>
													<!--/span-->
													<!--/span-->
													<div class="col-md-12">
														<div class="form-group row">
															<label class="control-label text-lg-left col-lg-3 col-6">Paypal Email:</label>
															<div class="col-lg-9 col-6">
																<p class="form-control-static">{{dashboard.publisher.paypal_email}} </p>
															</div>
														</div>
													</div>
													<!--/span-->
													<!--/span-->
													<div class="col-md-12">
														<div class="form-group row">
															<div class="col-md-12">
																<button class="btn btn-sm btn-outline-secondary pull-right mr-5" id="delete-user" ng-attr-data-id="{{dashboard.publisher.id}}"><i class="fa fa-trash"></i> delete account</button>
																<button class="btn btn-sm btn-outline-secondary pull-right mr-5" id="edit-user" ng-attr-data-id="{{dashboard.publisher.id}}"><i class="fa fa-pencil"></i> edit account</button>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="earning" role="tabpanel">
								<div class="p-3">
									<h4>Calculate Earnings, <small>You can calculate affiliate's earning for specific date range</small></h4>
								</div>
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-md-8 text-left">
												Select Date Range  
												<div id="salarydaterange" class="form-control form-control-sm pull-right"></div>
											</div>
											<div class="col-md-4 text-right mt-3 pr-3" id="earningsalary"> </div>
										</div>
									</div>
								</div>
							</div>
							<!--second tab-->
							<div class="tab-pane" id="summary" role="tabpanel">
								<div class="p-3">
									<h4>Affiliate's Performance, <small>You can evaluate affiliate's performance here</small></h4>
								</div>
								<div class="card">
									<div class="card-body">
										<div class="row text-left  p-10 pr-0 pl-0" style="background: #9e9e9e1f;">
											<div class="col-lg-12 col-md-12 m-t-10">
												<h3 class="m-b-0 font-light">Earning Summary  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i> </h3>
											</div>
											<div class="col-md-12 m-b-10"></div>
										</div>
										<div class="d-flex flex-row text-center">
											<div class="p-20  b-r">
												<h5 class="m-b-0"><small>YESTERDAY</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.yesterday_earn | currency}}</h6>
											</div>
											<div class="p-20  b-r">
												<h5 class="m-b-0"><strong class="text-success">TODAY</strong></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.todayearn | currency}}</h6>
											</div>
											<div class="p-20  b-r">
												<h5 class="m-b-0"><small>WEEK</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.week_earn | currency}}</h6>
											</div>
											<div class="p-20  b-r">
												<h5 class="m-b-0"><small>ALL TIME</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.alltime_earning | currency}}</h6>
											</div>
											<div class="p-20  b-r">
												<h5 class="m-b-0"><small class="text-danger">WITHDRAWAL</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.total_paid | currency}}</h6>
											</div>
											<div class="p-20 ">
												<h5 class="m-b-0"><small>BALANCE</small></h5>
												<h6 class="m-t-0 text-default"> {{dashboard.widgets.totalpending | currency}}</h6>
											</div>
										</div>
										<div class="row text-left  p-10" style="background: #9e9e9e1f;">
											<div class="col-lg-12 col-md-12 m-t-10">
												<h3 class="m-b-0 font-light">Clicks Summary  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i> </h3>
											</div>
											<div class="col-md-12 m-b-10"></div>
										</div>
										<div class="d-flex flex-row text-center">
											<div class="p-20  b-r">
												<h5 class="m-b-0"><small>YESTERDAY</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.yesterday_clicks}}</h6>
											</div>
											<div class="p-20  b-r">
												<h5 class="m-b-0"><strong class="text-success">TODAY</strong></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.todayclick}}</h6>
											</div>
											<div class="p-20  b-r">
												<h5 class="m-b-0"><small>WEEK</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.week_clicks}}</h6>
											</div>
											<div class="p-20 ">
												<h5 class="m-b-0"><small>ALL TIME</small></h5>
												<h6 class="m-t-0 text-default">{{dashboard.widgets.alltime_clicks}}</h6>
											</div>
										</div>
										<div class="row text-left  p-10" style="background: #9e9e9e1f;">
											<div class="col-lg-12 col-md-12 m-t-10">
												<h3 class="m-b-0 font-light">Weekly top campaigns shared by {{dashboard.publisher.name}}  <i ng-hide="dashboard.widgets"  class="fa fa-refresh fa-spin"></i> </h3>
											</div>
											<div class="col-md-12 m-b-10"></div>
										</div>
										<table class="table v-middle no-border">
											<tr>
												<th>Campaign</th>
												<th>Clicks</th>
												<th>Earning</th>
											</tr>
											<tbody>
												<tr  ng-repeat="cce in dashboard.campaign_click_earn" >
													<td> <img src="{{cce.img}}" onerror="this.src='assets/general/images/user_avatar.png';" width="35" height="35" class="img-circle" alt="image"> {{cce.text.substring(0,70)+"..."}} </td>
													<td>{{cce.click}}</td>
													<td>{{cce.Earn | currency}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="settings" role="tabpanel">
								<div class="p-3">
									<h4>Affiliate's Settings, <small>You set affiliate's rates, assign/restrict campaign's domain and much more</small></h4>
								</div>
								<div class="card">
									<div class="card-body">
										<form class="form-horizontal form-material p-0">
											<div class="row text-left  p-10" style="background: #9e9e9e1f;">
												<div class="col-lg-12 col-md-12 m-t-10">
													<h3 class="m-b-0 font-light">PPC RATES SETTINGS</h3>
												</div>
												<div class="col-md-12 m-b-10"></div>
											</div>
											<br>
											<input type="hidden" value="{{dashboard.publisher.id}}" id="pub_id" />
											<input type="hidden" value="{{dashboard.publisher.username}}" id="MMP_username" />
											<div class="form-group">
												<div class="radio">
													<label> &nbsp; <input type="radio" name="optradio" class="optradio"  value="yes" ng-model="dashboard.publisher.rates_priority"> &nbsp; USE SPECIFIC RATES FOR THIS USER</label>
													&nbsp;&nbsp;
													<button class="btn btn-sm btn-outline-secondary pull-right"  id="setuserrates" ><i class="fa fa-pencil"></i> Set Rates</button>
												</div>
												<div class="radio">
													<label> &nbsp; <input type="radio" class="optradio" name="optradio"  value="default" ng-model="dashboard.publisher.rates_priority"> &nbsp; USE DEFAULT RATES</label>
												</div>
											</div>
											<div class="row text-left  p-10" style="background: #9e9e9e1f;">
												<div class="col-lg-12 col-md-12 m-t-10">
													<h3 class="m-b-0 font-light">ASSIGN ADVERTISERS <small>({{dashboard.publisher.name}} can Share campaigns of )</small></h3>
												</div>
												<div class="col-md-12 m-b-10"></div>
											</div>
											<br>
											<div class="form-group">
												<div class="radio">
													<label> &nbsp; <input type="radio" name="advchoice" class="advchoice"  value="all" ng-model="dashboard.publisher.adv_priority"> &nbsp; ALL ADVERTISERS</label>
												</div>
												<div class="radio">
													<label> &nbsp; <input type="radio" class="advchoice" name="advchoice"  value="custom" ng-model="dashboard.publisher.adv_priority"> &nbsp; SPECIFIC ADVERTISERS</label>
													<button class="btn btn-sm btn-outline-secondary pull-right"  id="setuseradv" ><i class="fa fa-pencil"></i> Assign Advertisers</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Column -->
		</div>
	</div>
	<div class="modal fade" id="userRates" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">USER RATES SETTINGS</h4>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>
				<div class="modal-footer">
					<button type="button" id="saverates" class="btn btn-outline-secondary"><i class="fa fa-floppy-o"></i> Save</button>
				</div>
				<div class="modal-body">
					<table id="myTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Country</th>
								<th class="no-sort">Rate Per Click</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="item in ratestable">
								<td><img src='assets/general/flags/{{item.code}}.png'> {{item.name}}</td>
								<td><input data-cid={{item.id}}  class="ratesinputs input-sm" value="{{item.rate}}" ></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="userAdv" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">ASSIGN ADVERTISERS</h4>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="input-group">
							<ul class="icheck-list">
								<li ng-repeat="item in domains">
									<span ng-if="item.status == 'active'">
									<input type="checkbox"  data-did={{item.id}} class="check advinputs" id="minimal-checkbox-{{item.id}}" checked="true">
									<label for="minimal-checkbox-{{item.id}}">{{item.domain}}</label>
									</span>
									<span ng-if="item.status == 'inactive'">
									<input type="checkbox"  data-did={{item.id}} class="check advinputs" id="minimal-checkbox-{{item.id}}">
									<label for="minimal-checkbox-{{item.id}}">{{item.domain}}</label>
									</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="saveadv" class="btn btn-outline-secondary " > <i class="fa fa-floppy-o"></i> Save</button>
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
<script src="<?=GeneralAssets ?>plugins/bootstrap-switch/bootstrap-switch.min.js"></script>
<script>    
$(function () {

	var SITEURL = $("#SITEURL").val();
	var start = moment();
	var end = moment();
	function salaryinit(start, end) {
		$('#salarydaterange').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
	}
	$('#salarydaterange').daterangepicker({
		startDate: start,
		endDate: end,
	}, salaryinit);
	salaryinit(start, end);
	$('#salarydaterange').on('apply.daterangepicker', function (ev1, picker1) {

		var dataOBJ = {
			'username': $("#MMP_username").val(),
			'start': picker1.startDate.format('YYYY-MM-DD'),
			'end': picker1.endDate.format('YYYY-MM-DD'),
		}
		$.ajax({
			type: "GET",
			url: "user_salary",
			data: dataOBJ,
			dataType: "json",
			success: function (result) {
				if (result.data.earning) {
					$("#earningsalary").html("<h3>$" + result.data.earning + "</h3>");
				} else {
					$("#earningsalary").html("<h3>$0.00</h3>");
				}
			},
			error: function () {
				$("#databody").html("No data found");
			}
		});
	});

	$("#user-status-switch").change(function(){
		var value = "";
		var user_id = $(this).data("id");
		if(this.checked) {
			var value = "approve";
			$("#user-status-label").removeClass("text-danger").addClass("text-success").text("Approve");
		
		}else{
			var value = "disapprove";
			$("#user-status-label").removeClass("text-success").addClass("text-danger").text("Block")
		}
		var dataOBJ = {
			'user_id' : user_id,
			'status': value,
		}
		$.ajax({
			url: SITEURL + "updateaffiliate",
			type: 'POST',
			dataType: 'json',
			type: "POST",
			data: dataOBJ,
			success: function(response){
			if (response) {
				alertbox("Success" , "user status updated successfully" ,  "success");
			}
			},
			error: function() {
			alertbox("Information" , "Nothing Has been Changed." ,  "info");
			}
		});
	
	});
	$("#delete-user").click(function(){
        id = $(this).data('id');
      
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this affiliate again!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        }, function(){   
            
           
            var dataOBJ = {
                        'id': id
                      }
                      $.ajax({
                        type: "POST",
                        url: SITEURL + "deleteaffiliate",
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response){
							if (response) {
								alertbox("Success" , "affiliate's account deleted successfully" ,  "success");
								setTimeout(() => {
									window.location.replace(SITEURL + "affiliate-team");
								}, 1500);
							}else{
								alertbox("Information" , "Nothing has been changed." ,  "info");
							}
                        },
                        error: function() {
                          alertbox("Information" , "Nothing has been deleted." ,  "info");
                        }
                      });    


        });
    });

    $("#edit-user").on("click", function() {
    	// Get the data-id attribute value
    	var userId = $(this).data("id");
        // Open the modal
        $("#affiliateEdit").modal("show");
        // Store the userId as a data attribute of the modal (data- prefix is not necessary)
        $("#affiliateEdit").data("userId", userId);
    });

    // Handle the click event of the "Submit" button within the modal
    $("#submitbutton").on("click", function(event) {
    	event.preventDefault();
        // Get input field values
        var userId = $("#affiliateEdit").data("userId");
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var username = $("#username").val();
        var email = $("#email").val();
        // var password = $("#password").val();
        // Make an AJAX request to send form data to the controller
        $.ajax({
            type: "POST",
            url:  SITEURL + "editaffiliate",
            data: {
            	userId: userId,
                fname: fname,
                lname: lname,
                username: username,
                email: email,
            },
            dataType: "json",
            success: function(response) {
            	if (response) {
					alertbox("Success" , "affiliate's account edited successfully" ,  "success");
					setTimeout(() => {
						window.location.replace(SITEURL + "affiliate-team");
					}, 1500);
				}else{
					alertbox("Information" , "Nothing has been changed." ,  "info");
				}
                $("#affiliateEdit").modal("hide");
            },
            error: function(error) {
                console.error("Error submitting form:", error);
            }
        });
    });
	  
	$(document).on('click', '#saverates', function () {

		var ratesarray = [];
		$(".ratesinputs").each(function () {
			ratesarray.push({
				id: $(this).data('cid'),
				value: $(this).val()
			});
		});
		$.ajax({
			url: 'add_update_rate_owner',
			type: 'POST',
			data: {
				res_id: $('#pub_id').val(),
				identifier: 'user',
				rates: JSON.stringify(ratesarray)
			},
			success: function (data) {
				alertbox("Success", "Settings Updated Successfully", "success");
				$("#userRates").modal('hide');
			},
			error: function (data) {

				alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");

			}
		});

	});

	$(document).on('click', '#setuserrates', function () {
		$("#userRates").modal('show');
	});
	$(document).on('click', '#saveadv', function () {

		var domainsarray = [];
		$(".advinputs").each(function () {
			val_c = "inactive";
			if ($(this).prop('checked')) {
				val_c = "active";
			}
			domainsarray.push({
				id: $(this).data('did'),
				value: val_c
			});
		});

		$.ajax({
			url: 'add_update_assignadv_settings_owner',
			type: 'POST',
			data: {
				res_id: $('#pub_id').val(),
				identifier: 'user',
				domains: JSON.stringify(domainsarray)
			},
			success: function (data) {
				alertbox("Success", "Settings Updated Successfully", "success");
				$("#userAdv").modal('hide');
			},
			error: function (data) {

				alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");

			}
		});

	});
	$(document).on('click', '#setuseradv', function () {
		$("#userAdv").modal('show');
	});
	$(document).on('change', '.advchoice', function () {

		value = $(this).val();
		if (value == "custom") {
			$("#setuseradv").show();

		} else {
			$("#setuseradv").hide();
		}
		$.ajax({

			url: 'update_assignadv_settings_owner',
			type: 'POST',
			data: {
				value: value,
				identifier: 'user',
				res_id: $('#pub_id').val()
			},
			success: function (data) {

				if (value == "custom") {

					alertbox("Success", "Settings Updated Successfully", "success");
					setTimeout(function () {

						$("#userAdv").modal('show');

					}, 1500);

				} else {

					alertbox("Success", "Settings Updated Successfully", "success");
				}
			},
			error: function (data) {
				alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");
			}
		});


	});
	$(document).on('change', '.optradio', function () {


		value = $(this).val();

		if (value == "yes") {
			$("#setuserrates").show();
		} else {
			$("#setuserrates").hide();
		}
		$.ajax({

			url: 'update_rate_settings_owner',
			type: 'POST',
			data: {
				value: value,
				identifier: 'user',
				res_id: $('#pub_id').val()
			},
			success: function (data) {

				if (value == "yes") {

					alertbox("Success", "Settings Updated Successfully", "success");
					setTimeout(function () {

						$("#setuserrates").click();

					}, 1500);

				} else {

					alertbox("Success", "Settings Updated Successfully", "success");
				}
			},
			error: function (data) {
				alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");
			}
		});
    });
	$(document).on('click', '.change_status', function () {
		$.ajax({
			url: 'change_announce_view',
			type: 'GET',
			data: {
				announce_id: $(this).attr('id'),
				res_id: $('#loggeduserid').val()
			},
			success: function (data) {
				location.reload();
			},
			error: function (data) {
				location.reload();
			}

		});
	});

});
</script>
<script>
function restrictToAlphabets(inputId) {
    var inputField = document.getElementById(inputId);
    inputField.value = inputField.value.replace(/[^A-Za-z]/g, '');
}
</script>