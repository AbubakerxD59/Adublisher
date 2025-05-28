<style>
	.modal-lg {
		max-width: 90% !important;
	}
</style>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
<link href="<?= GeneralAssets ?>plugins/tablesaw-master/dist/tablesaw.css" rel="stylesheet" type="text/css">
<!--<link href="<?= GeneralAssets ?>plugins/time/css/timepicker.css" rel="stylesheet" type="text/css">-->
<link href="<?= GeneralAssets ?>plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet"
	type="text/css">
<link href=" <?= GeneralAssets ?>plugins/jquery-datetime/jquery.datetimepicker.min.css" rel="stylesheet"
	type="text/css">
<?php
date_default_timezone_set($user->gmt);
$utc_offset = date('Z') / 3600;
if ($utc_offset > 0) {
	if ($utc_offset < 10) {
		$utc_offset = "UTC+0" . $utc_offset;
	} else {
		$utc_offset = "UTC+" . $utc_offset;
	}
} else {
	$utc_offset = "UTC-" . $utc_offset;
}
?>
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
						<p class="text-center text-muted">
							<a href="<?= SITEURL ?>add-campaign" class="m-t-2 text-center"> <i class="fa fa-plus"></i>
								Add campaign</a>
						</p>
						<div class="row m-0 p-10">
							<div class="col-md-12">
								<form class="input-form p-0 m-t-10" style="line-height: 0;" id="searchform">
									<div class="input-group">
										<input type="text" class="form-control m-l-5" id="searchtext"
											placeholder="Search for...">
										<span class="input-group-btn">
											<button class="btn btn-primary" type="button" id="searchsubmit">Search!
											</button>
										</span>
									</div>
								</form>
							</div>
							<div class="col-md-12 px-1 py-3">
								<div id="collapseExample">
									<div class="card">
										<div class="card-body">
											<div class="row px-2">
												<div class="col-md-12 row">
													<?php
													$popularity = "";
													if (!empty($save_filter)) {
														$popularity = $save_filter->popularity;
														$domain = $save_filter->domain;
														$cat = $save_filter->cat;
													}
													?>
													<div class="col-md-6 p-2">
														<label>Popularity</label>
														<select class="form-control" name="popularity" id="popularity">
															<option value="">Latest</option>
															<option value="today" <?php echo (!empty($popularity) && $popularity == 'today') ? 'selected' : '' ?>>Today's
																Top</option>
															<option value="week" <?php echo (!empty($popularity) && $popularity == 'week') ? 'selected' : '' ?>>Week's Top
															</option>
															<!--  <option value="month"  <?php echo (!empty($popularity) && $popularity == 'month') ? 'selected' : '' ?>>Month's Top</option>-->
															<option value="all" <?php echo (!empty($popularity) && $popularity == 'all') ? 'selected' : '' ?>>All Time
																Top</option>
														</select>
													</div>
													<div class="col-md-6 p-2">
														<label>Domains</label>
														<select class="form-control" name="domain" id="domain">
															<option value="all">All Domains</option>
															<?php foreach ($all_domains as $value) {
																if (trim($value['domain']) == "") {
																	continue;
																}
																?>
																<option value="<?= $value['domain']; ?>" <?php echo (!empty($domain) && $domain == $value['domain']) ? 'selected' : '' ?>> <?= $value['domain']; ?>
																</option>
																<?php
															} ?>
														</select>
													</div>
												</div>
												<div class="col-md-12 row">
													<div class="col-md-6 p-2">
														<label>Category</label>
														<select class="form-control chosen-select" name="cat" id="cat"
															multiple data-live-search="true">
															<?php
															$cata = explode('|', $cat);
															?>
															<option value="all" <?php echo in_array('all', $cata) || empty($cat) ? 'selected' : ''; ?>>All Categories
															</option>
															<?php
															foreach ($all_categories as $value) {

																$selected = in_array($value->id, $cata) ? 'selected' : '';
																echo '<option value="' . $value->id . '"' . $selected . '>' . ucfirst($value->categury) . '</option>';
															}
															?>
														</select>
													</div>
												</div>
												<div class="col-md-12 m-t-5 m-r-5">
													<div class="form-group text-lg-right m-r-5">
														<button id="recomended" title="Recommended for you"
															class="btn btn-outline-secondary">
															<i class="fa fa-history" aria-hidden="true">
															</i> Recommended
														</button>
														<button class="btn btn-outline-info settings"
															data-toggle="modal" data-target=".settings-modal-lg">
															<i class="fa fa-gear"></i> Settings
														</button>
														<!-- <button id="save_filter" title="Save Filter"
															class="btn btn-outline-secondary">
															<i class="fa fa-save" aria-hidden="true">
															</i> Save Filter
														</button> -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row" id="campiagns_html"></div>
							</div>
							<!-- <div class="col-md-12 text-center my-5">
								<nav aria-label="Page navigation example" id="campiagns_pagination">
									<ul id="pagination" class="pagination pagination-sm justify-content-center">
									</ul>
								</nav>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- settings modal -->
<div class="modal fade settings-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header pb-0">
				<ul class="nav nav-tabs border-0">
					<li class="nav-item">
						<a class="nav-link active font-weight-bold pointer" data-current="autoposting">Autoposting</a>
					</li>
					<li class="nav-item">
						<a class="nav-link pointer" data-current="redirect_domains">Redirect Domains</a>
					</li>
					<li class="nav-item">
						<a class="nav-link pointer" data-current="domain_analytics">Domain Analytics</a>
					</li>
					<li class="nav-item">
						<a class="nav-link pointer" data-current="affiliates">Affiliates</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link pointer">Link</a>
					</li> -->
				</ul>
				<button type="button" class="close settings-modal-close pointer">×</button>
			</div>
			<div class="modal-body">
				<div class="autoposting tab_body" style="display:block;">
					<table class='tablesaw table-bordered table-hover table'>
						<thead>
							<tr>
								<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
									data-tablesaw-priority="persist">Page</th>
								<th class="text-center" scope="col" data-tablesaw-priority="3" style="width: 140px;">
									Status <i class="mdi mdi-help-circle-outline" data-toggle="tooltip"
										data-placement="bottom" title=""
										data-original-title="You can turn Auto Posting ON/OFF, If you want to update [upcoming posts and Posts / day ] this value must be ON."></i>
								</th>
								<th class="text-center" scope="col" data-tablesaw-priority="2">Posts <i
										class="mdi mdi-help-circle-outline" data-toggle="tooltip"
										data-placement="bottom" title=""
										data-original-title="Here you can view a list of upcoming posts on your page. Only pending posts are shown."></i>
								</th>
								<th class="text-center" scope="col" data-tablesaw-priority="3" style="width: 140px;">
									Randomize <i class="mdi mdi-help-circle-outline" data-toggle="tooltip"
										data-placement="bottom" title=""
										data-original-title="If enabled, Scheduled posts shown in View List will be posted randomly."></i>
								</th>
								<th class="text-center" scope="col" data-tablesaw-priority="3" style="width: 140px;">
									Loop <i class="mdi mdi-help-circle-outline" data-toggle="tooltip"
										data-placement="bottom" title=""
										data-original-title="You can turn Loop ON/OFF, if you want to loop posts available in View list."></i>
								</th>
								<th class="text-center" scope="col" data-tablesaw-priority="1">Domains <i
										class="mdi mdi-help-circle-outline" data-toggle="tooltip"
										data-placement="bottom" title=""
										data-original-title="Add specific domains to pages and autoposting will fetch posts from those domains only."></i>
								</th>
								<th class="text-center" scope="col" data-tablesaw-priority="1">Timeslots <i
										class="mdi mdi-help-circle-outline" data-toggle="tooltip"
										data-placement="bottom" title=""
										data-original-title="Here you can set number of posts per day, which will be posted on daily basis."></i>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($pages as $page) {
								$checked = "";
								if ($page->auto_posting == "on") {
									$checked = "checked";
									$is_active = '';
								} else {
									$is_active = 'disabled="true"';
								}
								$random = $page->random_auto_posting == 1 ? "checked" : "";
								$loop = $page->loop_auto_posting == 1 ? "checked" : "";
								?>
								<tr class="">
									<td class="title"> <img style="width:50px;height:50px;"
											src="<?= GeneralAssets ?>images/facebook_logo.png" class="rounded"
											alt="profile_pic"> <b><?php echo $page->page_name; ?></b></td>
									<td class="text-center">
										<div class="switch">
											<label>
												OFF
												<input type="checkbox" <?= $checked; ?> class="autoposting"
													data-id="<?= $page->id ?>" data-type="facebook">
												<span class="lever switch-col-light-blue"></span>
												ON
											</label>
										</div>
									</td>
									<td class="text-center">
										<button class="btn btn-outline-secondary btn-sm browselist" <?= $is_active; ?>
											id="list_<?= $page->id ?>" data-name="<?= $page->page_name ?>"
											data-id="<?= $page->id ?>" data-type="facebook">
											<span class="mdi mdi-format-list-bulleted"></span>
											View List
										</button>
									</td>
									<td class="text-center">
										<div class="switch">
											<label>
												OFF
												<input type="checkbox" <?= $random; ?> class="random_auto_posting"
													data-id="<?= $page->id ?>">
												<span class="lever switch-col-light-blue"></span>
												ON
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="switch">
											<label>
												OFF
												<input type="checkbox" <?= $loop; ?> class="loop_auto_posting"
													data-id="<?= $page->id ?>">
												<span class="lever switch-col-light-blue"></span>
												ON
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="d-flex align-items-center">
											<?php
											$clean = json_decode($page->time_slots_auto, true);
											?>
											<select id="domains_<?= $page->id ?>" multiple
												data-placeholder="Select domains to post..." data-pageid="<?= $page->id ?>"
												class="chosen-select chosen-domains form-control" data-type="facebook">
												<?php
												if (count($user_domains) > 0) {
													?>
													<option value="all" class="all">Select All</option>
													<?php
												}
												?>
												<?php
												$selected_domains = [];
												$selected_domains = json_decode($page->domains_auto, true);
												foreach ($user_domains as $key => $domain) {
													if (in_array((string) $domain->id, $selected_domains)) {
														?>
														<option selected="selected" value="<?= $domain->id; ?>">
															<?= $domain->domain; ?>
														</option>
														<?php
													} else {
														?>
														<option value="<?= $domain->id; ?>"><?= $domain->domain; ?></option>
														<?php
													}
												}
												?>
											</select>
											<?php
											if ($page->auto_posting == "off") {
												?>
												<script>
													$(document).ready(function () {
														$('#timeslots_' + <?= $page->id ?>).prop('disabled', true).trigger("chosen:updated");
													});
												</script>
												<?php
											}
											?>
											<span class="px-2 reset_chosen pointer text-danger">x</span>
										</div>
									</td>
									<td class="text-center">
										<?php
										$clean = json_decode($page->time_slots_auto, true);
										?>
										<select id="timeslots_<?= $page->id ?>" multiple
											data-placeholder="Select Hours to post..." data-pageid="<?= $page->id ?>"
											class="chosen-select chosen-timeslots form-control" data-type="facebook">
											<?php
											for ($i = 0; $i < 24; $i++) {
												if (in_array((string) $i, $clean)) {
													?>
													<option selected="selected" value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
														<?= $i >= 12 ? 'pm' : 'am' ?>
													</option>
													<?php
												} else {
													?>
													<option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
														<?= $i >= 12 ? 'pm' : 'am' ?>
													</option>
													<?php
												}
											}
											?>
										</select>
										<?php
										if ($page->auto_posting == "off") {
											?>
											<script>
												$(document).ready(function () {
													$('#timeslots_' + <?= $page->id ?>).prop('disabled', true).trigger("chosen:updated");
												});
											</script>
											<?php
										}
										?>
									</td>
								</tr>
								<?php
							}
							?>

							<?php
							foreach ($boards as $board) {
								$checked = "";
								if ($board->auto_posting == "on") {
									$checked = "checked";
									$is_active = '';
								} else {
									$is_active = 'disabled="true"';
								}
								$random = $board->random_auto_posting == 1 ? "checked" : "";
								$loop = $board->loop_auto_posting == 1 ? "checked" : "";
								?>
								<tr class="">
									<td class="title"> <img style="width:50px;height:50px;"
											src="<?= GeneralAssets ?>images/pinterest_logo.png" class="rounded"
											alt="profile_pic"> <b><?php echo $board->name; ?></b></td>
									<td class="text-center">
										<div class="switch">
											<label>
												OFF
												<input type="checkbox" <?= $checked; ?> class="autoposting"
													data-id="<?= $board->id ?>" data-type="pinterest">
												<span class="lever switch-col-light-blue"></span>
												ON
											</label>
										</div>
									</td>
									<td class="text-center">
										<button class="btn btn-outline-secondary btn-sm browselist" <?= $is_active; ?>
											id="list_<?= $board->id ?>" data-name="<?= $board->name ?>"
											data-id="<?= $board->id ?>" data-type="pinterest">
											<span class="mdi mdi-format-list-bulleted"></span>
											View List
										</button>
									</td>
									<td class="text-center">
										<div class="switch">
											<label>
												OFF
												<input type="checkbox" <?= $random; ?> class="random_auto_posting"
													data-id="<?= $board->id ?>">
												<span class="lever switch-col-light-blue"></span>
												ON
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="switch">
											<label>
												OFF
												<input type="checkbox" <?= $loop; ?> class="loop_auto_posting"
													data-id="<?= $page->id ?>">
												<span class="lever switch-col-light-blue"></span>
												ON
											</label>
										</div>
									</td>
									<td class="text-center">
										<div class="d-flex align-items-center">
											<?php
											$clean = json_decode($board->time_slots_auto, true);
											?>
											<select id="domains_<?= $board->id ?>" multiple
												data-placeholder="Select domains to post..." data-pageid="<?= $board->id ?>"
												class="chosen-select chosen-domains form-control" data-type="pinterest">
												<?php
												if (count($user_domains) > 0) {
													?>
													<option value="all" class="all">Select All</option>
													<?php
												}
												?>
												<?php
												$selected_domains = [];
												$selected_domains = json_decode($board->domains_auto, true);
												foreach ($user_domains as $key => $domain) {
													if (in_array((string) $domain->id, $selected_domains)) {
														?>
														<option selected="selected" value="<?= $domain->id; ?>">
															<?= $domain->domain; ?>
														</option>
														<?php
													} else {
														?>
														<option value="<?= $domain->id; ?>"><?= $domain->domain; ?></option>
														<?php
													}
												}
												?>
											</select>
											<?php
											if ($board->auto_posting == "off") {
												?>
												<script>
													$(document).ready(function () {
														$('#timeslots_' + <?= $board->id ?>).prop('disabled', true).trigger("chosen:updated");
													});
												</script>
												<?php
											}
											?>
											<span class="px-2 reset_chosen pointer text-danger">x</span>
										</div>
									</td>
									<td class="text-center">
										<?php
										$clean = json_decode($board->time_slots_auto, true);
										?>
										<select id="timeslots_<?= $board->id ?>" multiple
											data-placeholder="Select Hours to post..." data-pageid="<?= $board->id ?>"
											class="chosen-select chosen-timeslots form-control" data-type="pinterest">
											<?php
											for ($i = 0; $i < 24; $i++) {
												if (in_array((string) $i, $clean)) {
													?>
													<option selected="selected" value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
														<?= $i >= 12 ? 'pm' : 'am' ?>
													</option>
													<?php
												} else {
													?>
													<option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
														<?= $i >= 12 ? 'pm' : 'am' ?>
													</option>
													<?php
												}
											}
											?>
										</select>
										<?php
										if ($page->auto_posting == "off") {
											?>
											<script>
												$(document).ready(function () {
													$('#timeslots_' + <?= $page->id ?>).prop('disabled', true).trigger("chosen:updated");
												});
											</script>
											<?php
										}
										?>
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="affiliates tab_body" style="display:none;">
					<h2 class="text-center">Manage Affiliates</h2>
					<p class="text-center">Add, Remove , Edit your affiliate members, Set PPC Rates for
						Individual
						member <br> Restrict/Assign particular domain to affiliate and much more.<br>
						<a href="#" class="add_affiliate_member" data-toggle="modal" data-target="#affiliateAdd"> <i
								class="fa fa-plus"></i> Add affiliate</a>
					</p>
					<div class="card simple-card">
						<div class="row m-0 p-10">
							<div class="col-md-12 d-flex justify-content-end">
								<a href="<?php echo SITEURL . 'affiliate-manage-ppc-rates'; ?>"
									class="btn btn-info mb-3" target="_blank"><i class="fa fa-money"></i>Default PPC
									Rates</a>
							</div>
							<div class="col-md-12">
								<input id="myInput" type="text" placeholder="Search.."
									class="form-control input pull-right">
								</h4>
								<br>
								<hr>
							</div>
							<?php
							foreach ($users as $key => $row) {
								$pending = 0;
								$you = "";
								if ($user->id == $row->id) {
									$you = "<label class='label label-default text-info'>You</label>";
								}

								$status = "<label class='label label-default text-success'>Active</label>";
								if (trim($row->active) != "y") {
									$status = "<label class='label label-default text-danger'>Block</label>";

								}
								$pending = @($row->totalearn - $row->paid_amu);
								?>
								<div class="col-md-4 filter px-1" data-filter="<?= $row->fname . ' ' . $row->lname ?>">
									<div class="card p-3">
										<div class="card-body">
											<h4 class="card-title"><i class="mdi mdi-account"></i>
												<?= $row->fname . ' ' . $row->lname ?> <small><?= $you; ?></small>
												<small><?= $status ?></small>
											</h4>
											<div class="row text-center p-0">
												<div class="col-lg-4 col-md-4 mt-3">
													<h6 class="mb-0 font-weight-light">
														$<?= @round($row->totalearn, 2); ?>
													</h6><small class="text-black">Earning</small>
												</div>
												<div class="col-lg-4 col-md-4 mt-3">
													<h6 class="mb-0 font-weight-light">
														$<?= @round($row->paid_amu, 2); ?>
													</h6><small class="text-black">Paid Amount</small>
												</div>
												<div class="col-lg-4 col-md-4 mt-3">
													<h6 class="mb-0 font-weight-light ">$<?= @round($pending, 2); ?>
													</h6>
													<small class="text-black">Pending</small>
												</div>
											</div>
										</div>
										<div class="card-footer bg-white px-0 text-right">
											<a href="<?= SITEURL ?>affiliate-manage?profile=<?= $row->id ?>"
												class="btn btn-sm btn-outline-secondary" target="_blank">Manage</a>
											<?php
											if ($pending > 0) {
												echo '<button type="button" class="btn btn-outline-secondary btn-sm pay-now pull-right" data-toggle="modal"  data-name="' . ucfirst($row->fname . ' ' . $row->lname) . "<br>Pending Amount is: $ " . $pending . '" data-recordid="' . $row->id . '" data-target="#paynow" > <i class="mdi mdi-coin"></i> Pay Now  </button>';
											}
											?>
										</div>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="redirect_domains tab_body" style="display: none;">
					<h2 class="text-center"> Redirect domains</h2>
					<p class="text-center text-muted">You must provide us domains to be used for redirect for
						campaigns links.
						<br>
						<a href="#" class="" data-toggle="modal" data-target="#adddomain"><i class="fa fa-plus"></i>Add
							New</a>
					</p>
					<div class="row">
						<div class="col-md-12 d-flex justify-content-end">
							<button class="btn btn-info mb-3" data-toggle="modal" data-target="#redirect_link_settings">
								<i class="fa fa-gear"></i> Settings
							</button>
						</div>
						<div class="col-md-12">
							<div class="table-responsive m-10">
								<table id="myTable" class="table table-bordered">
									<thead>
										<tr>
											<th>Domain</th>
											<th style="width: 120px;">Status</th>
											<th class="no-sort" style="min-width: 120px;">Edit</th>
											<th class="no-sort">Delete</th>
										</tr>
									</thead>
									<tbody id="redirect-table-body">
										<?php
										foreach ($domains as $row) {
											?>
											<tr id="<?php echo $row->id; ?>">
												<td>
													<input class="form-control form-control-line m-t-0 m-b-0"
														id="<?php echo 'domain_' . $row->id; ?>"
														value="<?php echo $row->domain; ?>" disabled="disabled">
												</td>
												<td>
													<select name="status" class="form-control m-t-0 m-b-0"
														id="<?php echo 'status_' . $row->id; ?>" disabled="disabled">';
														<option value="active" <?php echo $row->status == "active" ? "selected" : ""; ?>>
															Active
														</option>
														<option value="inactive" <?php echo $row->status == "active" ? "" : "selected"; ?>>
															Inactive
														</option>
													</select>
												</td>
												<td>
													<button type="button"
														class="btn waves-effect waves-light btn-sm btn-outline-secondary  edit-cat edit <?php echo 'edit_' . $row->id; ?>"
														data-id="<?php echo $row->id; ?>"
														data-domain="<?php echo $row->domain; ?>">
														<i class="fa fa-pencil"></i> Edit
													</button>

													<button style="display:none" type="button"
														class="btn waves-effect waves-light btn-sm btn-outline-secondary save <?php echo 'save_' . $row->id; ?>"
														data-id="<?php echo $row->id; ?>"
														data-domain="<?php echo $row->domain; ?>">
														<i class="fa fa-save"></i> Save
													</button>

													<button style="display:none" type="button"
														class="btn waves-effect waves-light btn-sm btn-outline-secondary cancel <?php echo 'cancel_' . $row->id; ?>"
														data-id="<?php echo $row->id; ?>"
														data-domain="<?php echo $row->domain; ?>">
														<i class="fa fa-pencil"></i> Cancel
													</button>
												</td>
												<td>
													<button type="button"
														class="btn waves-effect waves-light btn-sm btn-outline-secondary"
														data-record-title="<?php echo $row->domain; ?>" data-toggle="modal"
														data-target="#confirm-delete-domain"
														data-record-id="<?php echo $row->id; ?>">
														<i class="fa fa-trash"></i> Delete
													</button>
												</td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="domain_analytics tab_body" style="display: none;">
					<h2 class="text-center"> Analytics domains</h2>
					<p class="text-center text-muted">Domains to be used for calculating traffic via google analytics.
						<!-- <a href="#">Learn more</a> -->
						<br>
						<a href="#" class="" data-toggle="modal" data-target="#add_analytic_domain"><i
								class="fa fa-plus"></i> Add
							New</a>
					</p>
					<div class="row p-10 m-0">
						<div class="col-md-12">
							<div class="card simple-card">
								<div class="card-body">
									<div class="table-responsive m-10">
										<table id="myTable" class="table table-bordered">
											<thead>
												<tr>
													<th>Domain</th>
													<th style="width: 220px;">Google Analytics View-ID</th>
													<th>Status</th>
													<th class="no-sort"><i class="fa fa-usd"></i>
														PPC Rates</th>
													<th class="no-sort" style="min-width: 120px;">Edit</th>
													<th class="no-sort">Delete</th>
												</tr>
											</thead>
											<tbody id="analytics-table-body">
												<?php
												foreach ($analytic_domains as $row) {
													?>
													<tr id="<?php echo $row->id; ?>">
														<td>
															<input
																class="form-control form-control-sm form-control-line m-t-0 m-b-0"
																id="<?php echo 'domain_' . $row->id; ?>"
																value="<?php echo $row->domain; ?>" disabled="disabled">
														</td>
														<td>
															<input
																class="form-control form-control-sm form-control-line m-t-0 m-b-0"
																id="<?php echo 'property_' . $row->id; ?>"
																value="<?php echo $row->property_id; ?>"
																disabled="disabled">
														</td>
														<td>
															<select name="status" id="<?php echo 'status_' . $row->id; ?>"
																class="form-control form-control-sm m-t-0 m-b-0"
																disabled="disbaled">
																<option value="active" <?php echo $row->status == 'active' ? 'selected' : ''; ?>>Active</option>
																<option value="inactive" <?php echo $row->status == 'active' ? '' : 'selected'; ?>>Inactive</option>
															</select>
														</td>
														<td>
															<select name="status"
																class="form-control form-control-sm m-t-0 m-b-0"
																style="width:50%;"
																id="<?php echo 'rates_priority_' . $row->id; ?>"
																disabled="disabled">
																<option value="yes" <?php echo $row->rates_priority == 'yes' ? 'selected' : ''; ?>>Active</option>
																<option value="default" <?php echo $row->rates_priority == 'yes' ? '' : 'selected'; ?>>
																	Inactive</option>
															</select>
															<button type="button"
																class="btn waves-effect waves-light btn-sm btn-outline-secondary  ml-1 edit-rates rates <?php echo 'rates_' . $row->id; ?>"
																data-id="<?php echo $row->id; ?>"
																data-domain="<?php echo $row->domain; ?>"><i
																	class="fa fa-usd"></i>
																Set rates
															</button>
														</td>
														<td>
															<button type="button"
																class="btn btn-sm btn-outline-secondary edit-cat edit_analytic <?php echo 'edit_' . $row->id; ?>"
																data-id="<?php echo $row->id; ?>"
																data-domain="<?php echo $row->domain; ?>">
																<i class="fa fa-pencil"></i> Edit
															</button>

															<button style="display:none" type="button"
																class="btn btn-sm  btn-outline-secondary save_analytic <?php echo 'save_' . $row->id; ?>"
																data-id="<?php echo $row->id; ?>"
																data-domain="<?php echo $row->domain; ?>">
																<i class="fa fa-save"></i> Save
															</button>

															<button style="display:none" type="button"
																class="btn btn-sm btn-outline-secondary cancel_analytic <?php echo 'cancel_' . $row->id; ?>"
																data-id="<?php echo $row->id; ?>"
																data-domain="<?php echo $row->domain; ?>">
																<i class="fa fa-pencil"></i> Cancel
															</button>
														</td>
														<td>
															<button type="button" class="btn btn-sm btn-outline-secondary"
																data-record-title="<?php echo $row->domain; ?>"
																data-toggle="modal" data-target="#delete-analytic-modal"
																data-record-id="<?php echo $row->id; ?>">
																<i class="fa fa-trash"></i> Delete
															</button>
														</td>
													</tr>
													<?php
												}
												?>
											</tbody>
										</table>
									</div>
									<p>
										Please add <b>shabby@adublisher-193617.iam.gserviceaccount.com</b> in
										your Analytics dashboard and allow <b>Read & Analyze</b> permissions
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary settings-modal-close">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- settings modal -->

<!-- Add Affiliates modal -->
<div class="modal fade" id="affiliateAdd" tabindex="-1" role="dialog" aria-labelledby="affiliateAddModalLabel1"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="affiliateAddModalLabel1">Add New Affiliate</h4>
				<button type="button" class="close affilited-modal-close pointer"><span
						aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal form-material" method="post" id="affiliatesignupform" action="#"
					autocomplete="off">

					<div class="row m-r-5">
						<div class="form-group col-md-6">
							<div class="col-xs-12">
								<label for="name"> First Name</label>
								<input class="form-control" type="text" name="fname" id="fname" required
									placeholder="First Name" autocomplete="off" oninput="restrictToAlphabets('fname')">
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="col-xs-12">
								<label for="name"> Last Name</label>
								<input class="form-control" type="text" name="lname" id="lname" placeholder="Last Name"
									autocomplete="off" oninput="restrictToAlphabets('lname')">
							</div>
						</div>

						<div class="form-group col-md-12">
							<div class="col-xs-12">
								<label for="username"> Username</label>
								<input class="form-control" type="text" name="username" id="username" required
									placeholder="Username" autocomplete="off" oninput="restrictToAlphabets('username')">
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-xs-12">
								<label for="email"> Email</label>
								<input class="form-control" type="text" name="email" id="email" required
									placeholder="Email" autocomplete="off">
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="col-xs-12">
								<label for="Password"> Password</label>
								<input class="form-control" autocomplete="off" type="password" name="password"
									id="password" required autocomplete="new-password">
							</div>
						</div>
						<input type="hidden" name="timezone" id="timezone">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary affilited-modal-close">Close</button>
						<button type="submit" class="btn btn-outline-secondary">Add Account</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- Add Affiliates modal -->

<!-- confirm delete modal -->
<div class="modal fade" id="confirm-delete-campaign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
				<button type="button" class="close campaign-delete-close pointer">×</button>
			</div>
			<div class="modal-body m-b-10">
				<p>You are about to delete <br><b><i class="title"></i></b> Campaign, this procedure is irreversible.
				</p>
				<div class="row p-3">
					<div class="col-md-12">
						<div class="switch">
							delete all schedule data for this campaign ?? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label class="text-right m-l-5">NO<input id="delete_schdule" type="checkbox"><span
									class="lever"></span>YES</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer m-t-15">
				<p class="text-danger m-t-15">Do you really want to proceed?</p>
				<button type="button" class="btn btn-outline-secondary  btn-ok">Yes delete it</button>
				<button type="button" class="btn btn-default campaign-delete-close">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- confirm delete modal -->

<!-- show list modal -->
<div class="modal fade bs-example-modal-lg" id="comingposts" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel">Upcoming posts for: <b id="page_name"></b></h4>
				<button type="button" class="close confirm-delete-close pointer">×</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<p class="pl-3">Timezone: <?php echo $user->gmt . " " . $utc_offset ?></p>
					</div>
					<div class="col-md-6" id="actions" style="display: none;">
						<input type="hidden" id="page_id" value="">
						<input type="hidden" id="type" value="">
						<button class="btn btn-danger deleteall m-l-5 btn-sm pull-right mr-3"><i
								class="fa fa-trash pointer"></i> Delete All</button>
						<button class="btn btn-success shuffle m-l-5 btn-sm pull-right mr-3"><i
								class="fa fa-refresh pointer"></i> Shuffle</button>
					</div>
				</div>
				<div class="comment-widgets" id="poststable">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger confirm-delete-close">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- show list modal -->

<!-- Delete Domain modal -->
<div class="modal fade" id="confirm-delete-domain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
				<button type="button" class="close domain-delete-close pointer">×</button>
			</div>
			<div class="modal-body">
				<p>You are about to delete <b><i class="title"></i></b> Domain, this procedure is irreversible.</p>
				<p>Do you want to proceed?</p>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-outline-secondary  btn-ok">Delete</button>
				<button type="button" class="btn btn-default domain-delete-close">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- Delete Domain modal -->

<!-- Add Domain modal -->
<div class="modal fade" id="adddomain" tabindex="-1" role="dialog" aria-labelledby="adddomainLabel"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="adddomainLabel">Add New Domain</h4>
				<button type="button" class="close add-domain-close pointer"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="domain" class="control-label">Domain:</label>
						<input class="form-control" id="add_modal_domain" name="domain">
					</div>

					<div class="form-group">
						<label for="domain" class="control-label">Domain Status:</label>
						<select name="status" class="form-control" id="add_modal_status">
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default add-domain-close">Close</button>
				<button type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- Add Domain modal -->

<!-- Redirect Link Setting modal -->
<div class="modal fade" id="redirect_link_settings" tabindex="-1" role="dialog" aria-labelledby="redirectsettingLabel"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="redirectsettingLabel">Redirect Links Settings</h4>
				<button type="button" class="close redirect-setting-close pointer"><span
						aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<div>
					<h2 class="text-center mt-2 m-b-0"> Redirect & Domain Settings</h2>
					<p class="text-center text-muted">Redirect or Direct Link settings for your affiliates,
						change/select domain
						in case of redirect.
						<!-- <a href="#">Learn more</a></p> -->
					<div class="row m-0 p-10">
						<div class="col-md-12">
							<div class="card p-10">
								<div class="card-body">
									<form>
										<div class="row">
											<div class="col-md-8">
												<p>Redirect feature for publishing content on your social media</p>
											</div>
											<div class="col-md-4 text-right">
												<div class="switch">
													<label>OFF
														<?php
														$redirect = "";
														if ($user->direct_link == "indirect") {
															?>
															<input id="redirect-switch" type="checkbox" checked><span
																class="lever switch-col-light-blue"></span>ON</label>
														<?php
														} else {
															$redirect = "hide";
															?>
														<input id="redirect-switch" type="checkbox"><span
															class="lever switch-col-light-blue"></span>ON</label>
														<?php
														}
														?>
												</div>
											</div>
										</div>

										<div class="row <?= $redirect ?> domains">
											<div class="col-md-8">
												<p>Please choose redirect domain to be used in links</p>
											</div>
											<div class="col-md-4">
												<div class="input-group col-md-12">
													<?php
													$all_domains = $redirect_links['all_domains'];
													$current_domain = $redirect_links['current_domain'];
													if (sizeof($all_domains) > 0) {
														?>
														<select class="form-control" id="redirect_domain">
															<?php
															foreach ($all_domains as $domain) {
																if ($domain->status == "inactive") {
																	echo '<option disabled="disabled" value="' . $domain->id . '">' . $domain->domain . ' (In-Active)</option>';
																} else {
																	if ($domain->domain == $current_domain) {
																		echo '<option value="' . $domain->id . '" selected>' . $domain->domain . '</option>';
																	} else {
																		echo '<option value="' . $domain->id . '">' . $domain->domain . '</option>';
																	}
																}
															}
															?>
														</select>
														<?php
													} else {
														echo '<a href="#" class="no_redirect" data-toggle="modal" data-target="#adddomain"><i class="fa fa-plus"></i>No redirect domain found, Please add and come again</a>';
													}
													?>
												</div>
											</div>
										</div>
									</form>
									<div class="px-4">
										<h5> <i class="fa fa-exclamation-circle"></i> Direct Link</h5>
										<p class="text-muted">
											By using direct link, when user will click on your social
											media link shared by
											Adublisher will directly go to orignal link
										</p>
										<h5 class=""> <i class="fa fa-exclamation-circle"></i> Redirect Link</h5>
										<p class="text-muted">
											By Using redirect link, when user will click on your
											social media link shared
											by Adublisher will first come on your selected domain and than redirected to
											orignal link
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default redirect-setting-close">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Redirect Link Setting modal -->

<!-- Add Analytic Domain Modal -->
<div class="modal fade" id="add_analytic_domain" tabindex="-1" role="dialog" aria-labelledby="addanalyticLabel"
	style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="addanalyticLabel">Add New Domain</h4>
				<button type="button" class="close add_analytic_close pointer"><span
						aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="domain" class="control-label">Domain:</label>
						<input class="form-control" id="analytic_domain" name="domain">
					</div>
					<div class="form-group">
						<label for="domain" class="control-label">Google Analytics View ID: GA-</label>
						<input type="number" class="form-control" id="analytic_property" name="property">
						<small> Don't include GA-, only input number</small>
					</div>
					<div class="form-group">
						<label for="domain" class="control-label">Domain Status:</label>
						<select name="status" class="form-control" id="analytic_status">
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default add_analytic_close">Close</button>
				<button type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- Add Analytic Domain Modal -->

<!-- Delete Analytic Domain Modal -->
<div class="modal fade" id="delete-analytic-modal" tabindex="-1" role="dialog" aria-labelledby="deleteanalyticLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="deleteanalyticLabel">Confirm Delete</h4>
				<button type="button" class="close delete-analytic-close pointer">×</button>
			</div>
			<div class="modal-body">
				<p>You are about to delete <b><i class="title"></i></b> Domain, this procedure is irreversible.</p>
				<p>Do you want to proceed?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-ok">Delete</button>
				<button type="button" class="btn btn-default delete-analytic-close">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- Delete Analytic Domain Modal -->

<!-- User Rates Modal -->
<div class="modal fade" id="userRates" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">SET DOMAINS LEVEL RATES</h4>
				<button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			<div class="modal-footer">
				<button type="button" id="saverates" class="btn btn-outline-secondary"> <i class="fa fa-floppy-o"></i>
					Save</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="domain_id" value="" />
				<table id="myTable" class="table table-bordered">
					<thead>
						<tr>
							<th>Country</th>
							<th class="no-sort">Rate Per Click</th>
						</tr>
					</thead>
					<tbody id="rates_body">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- User Rates Modal -->

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" id="pagesmodel" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel">Your Facebook Pages
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 my-5 text-center" id="loader_box" style="display:none;">
						<div class="row bg-white my-5">
							<svg class="circular" viewBox="25 25 50 50">
								<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
									stroke-miterlimit="10"></circle>
							</svg>
						</div>
						<p>Posting content to facebook please wait....</p>
					</div>
					<div class="col-md-12" id="page_box">
						<div class="card simple-card">
							<div class="card-body">
								<div class="table-responsive m-t-20">
									<table class="table stylish-table">
										<thead>
											<tr>
												<?php
												if (count($pages) > 0 || count($boards) > 0) {
													?>
													<th>Channel
													</th>
													<th>Post on Channel
													</th>
												<?php } ?>
											</tr>
										</thead>
										<tbody id="pagetable">
											<?php
											if (count($pages) > 0) {
												foreach ($pages as $page) {
													?>
													<tr>

														<td style="width:80%">
															<img style="width:50px;height:50px;"
																src="<?= GeneralAssets ?>images/facebook_logo.png"
																class="rounded" alt="profile_pic">
															<?php echo $page->page_name; ?>
														</td>
														<td style="width:20%">
															<button class="btn btn-outline-facebook autopost btn-block"
																data-page="<?= $page->id ?>" type="button">
																<span class="btn-label">
																	<i class="fa fa-paper-plane-o">
																	</i>
																</span>
																publish on this page
															</button>
														</td>
													</tr>
													<?php
												}
											} else {
												echo "<tr><td colspan='3'>Opps, No pages found.<br> It Seems either you have not connected your facebook account OR you dont have Facebook pages.
												<br>Please <a href='" . SITEURL . "facebook'><b>CLICK HERE</b> </a> And you will be redirected to page, Where you can connect your  FACEBOOK Account with Adublisher.com</td></tr>";
											}

											if (count($fb_groups) > 0) {
												foreach ($fb_groups as $group) {
													?>
													<tr>
														<td style="width:80%">
															<img style="width:35px;height:35px;"
																src="<?= GeneralAssets ?>images/fb_group_logo.png"
																class="rounded" alt="profile_pic"> <?php echo $group->name; ?>
														</td>
														<td style="width:20%">
															<button class="btn btn-outline-fbgroup fbgroup-autopost btn-block"
																data-fbgroup="<?= $group->id ?>" type="button">
																<span class="btn-label">
																	<i class="fa fa-paper-plane-o">
																	</i>
																</span>
																publish on this group
															</button>
														</td>
													</tr>
													<?php
												}
											} else {
												echo "<tr><td colspan='3'>Opps, No groups found.<br> It Seems either you have not connected your facebook account OR you dont have Facebook groups.
												<br>Please <a href='" . SITEURL . "facebook'><b>CLICK HERE</b> </a> And you will be redirected to page, Where you can connect your  FACEBOOK Account with Adublisher.com</td></tr>";
											}

											if (count($boards) > 0) {
												foreach ($boards as $board) {
													?>
													<tr>

														<td style="width:80%">
															<img style="width:50px;height:50px;"
																src="<?= GeneralAssets ?>images/pinterest_logo.png"
																class="rounded" alt="profile_pic"> <?php echo $board->name; ?>
														</td>
														<td style="width:20%">
															<button class="btn btn-outline-pinterest board-autopost btn-block"
																data-board="<?= $board->id ?>" type="button">
																<span class="btn-label">
																	<i class="fa fa-paper-plane-o">
																	</i>
																</span>
																publish on this board
															</button>
														</td>
													</tr>
													<?php
												}
											} else {
												echo "<tr><td colspan='3'>Opps, No boards found.<br> It Seems either you have not connected your pinterest account OR you dont have Pinterest boards.
												<br>Please <a href='$pinterest_login_url'><b>CLICK HERE</b> </a> And you will be redirected to page, Where you can connect your  PINTEREST Account with Adublisher.com</td></tr>";
											}

											if (count($ig_users) > 0) {
												foreach ($ig_users as $ig_user) {
													?>
													<tr>
														<td style="width:80%">
															<img style="width:35px;height:35px;"
																src="<?= GeneralAssets ?>images/instagram_logo.png"
																class="rounded mx-2" alt="profile_pic">
															<?php echo $ig_user->instagram_username; ?>
														</td>
														<td style="width:20%">
															<button class="btn btn-outline-instagram ig-autopost btn-block"
																data-ig="<?= $ig_user->id ?>" type="button">
																<span class="btn-label">
																	<i class="fa fa-paper-plane-o">
																	</i>
																</span>
																publish on this account
															</button>
														</td>
													</tr>
													<?php
												}
											} else {
												echo "<tr><td colspan='3'>Opps, No boards found.<br> It Seems either you have not connected your instagram account.
												<br>Please <a href='" . $instagram_login_url . "'><b>CLICK HERE</b> </a> And you will be redirected to page, Where you can connect your  INSTAGRAM Account with Adublisher.com</td></tr>";
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary text-left" data-dismiss="modal">close it
				</button>
			</div>
		</div>
	</div>
</div>
<!-- /.modal -->

<input type="text" id="request" value="filter" style="display: none;">
<input type="text" id="data_to_post" style="display: none;">
<input type="text" id="id_to_post" style="display: none;">
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<?php $this->load->view('templates/publisher/footer'); ?>
<script src="<?= GeneralAssets ?>plugins/pagination/jquery.twbsPagination.min.js"></script>

<script src="<?= GeneralAssets ?>plugins/tablesaw-master/dist/tablesaw.js"></script>
<script src="<?= GeneralAssets ?>plugins/tablesaw-master/dist/tablesaw-init.js"></script>
<!--<script src="<?= GeneralAssets ?>plugins/time/js/timepicker.js"></script>-->
<script src="<?= GeneralAssets ?>plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="<?= GeneralAssets ?>plugins/jquery-datetime/jquery.datetimepicker.full.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<script src="<?php echo PublisherAssets . '/js/campaigns/main.js'; ?>"></script>
<script src="<?php echo PublisherAssets . '/js/campaigns/autoposting.js'; ?>"></script>
<script src="<?php echo PublisherAssets . '/js/campaigns/affiliates.js'; ?>"></script>
<script src="<?php echo PublisherAssets . '/js/campaigns/domains.js'; ?>"></script>
<script src="<?php echo PublisherAssets . '/js/campaigns/redirect-links.js'; ?>"></script>
<script src="<?php echo PublisherAssets . '/js/campaigns/analytic-domain.js'; ?>"></script>