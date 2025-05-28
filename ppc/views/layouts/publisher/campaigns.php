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
						<h2 class="text-center mt-2 m-b-0"> Campaigns</h2>
						<p class="text-center text-muted">Directly share campaigns/links to your facebook pages as an
							affiliate, you can filter campaigns.</p>
						<?php
						echo loader();
						?>
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
							<div class="col-md-12">
								<a class="link" data-toggle="collapse" href="#collapseExample" aria-expanded="false"
									aria-controls="collapseExample">
									<h6 class="p-10"><b><i class="fa fa-filter"> </i></b> More Filterss</h6>
								</a>
								<div class="collapse" id="collapseExample">
									<div class="card">
										<div class="card-body">
											<div class="row px-2">
												<div class="col-md-12">
													<h4 class="p-10"><b><i class="fa fa-filter"></i></b> FILTERS</h4>
												</div>

												<div class="col-md-6">
													<div class="form-group row">
														<label
															class="control-label text-lg-right col-lg-3">Popularity</label>
														<?php
														$popularity = "";
														if (!empty($save_filter)) {
															$popularity = $save_filter->popularity;
															$domain = $save_filter->domain;
															$cat = $save_filter->cat;
														}
														?>
														<div class="col-lg-9">
															<select class="form-control" name="popularity"
																id="popularity">
																<option value="">Select Popularity</option>
																<option value="today" <?php echo (!empty($popularity) && $popularity == 'today') ? 'selected' : '' ?>>Today's
																	Top</option>
																<option value="week" <?php echo (!empty($popularity) && $popularity == 'week') ? 'selected' : '' ?>>Week's Top
																</option>
																<!--  <option value="month"  <?php echo (!empty($popularity) && $popularity == 'month') ? 'selected' : '' ?>>Month's Top</option>-->
																<option value="all" <?php echo (!empty($popularity) && $popularity == 'all') ? 'selected' : '' ?>>All Time
																	Top</option>
															</select>
														</div>
													</div>
													<div class="form-group row ">
														<label
															class="control-label text-lg-right col-lg-3">Advertisers</label>
														<div class="col-lg-9 pr-2">
															<select class="form-control" name="domain" id="domain">
																<option value="all">All Advertisers</option>
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
												</div>
												<div class="col-md-6">
													<div class="form-group row m-r-5">
														<label
															class="control-label text-lg-right col-lg-3">Category</label>
														<div class="col-lg-9">
															<select class="form-control selectpicker" name="cat"
																id="cat" multiple data-live-search="true">
																<option value="all">All Categories</option>
																<?php
																foreach ($all_categories as $value) {
																	$cata = explode('|', $cat);
																	$selected = in_array($value->id, $cata) ? 'selected' : '';
																	echo '<option value="' . $value->id . '"' . $selected . '>' . ucfirst($value->categury) . '</option>';
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-12 m-t-5 m-r-5">
													<div class="form-group text-lg-right m-r-5">
														<button id="recomended" title="Recommended for you"
															class="btn btn-outline-secondary">
															<i class="fa fa-history" aria-hidden="true">
															</i> Recommended
														</button>
														<button id="save_filter" title="Save Filter"
															class="btn btn-outline-secondary">
															<i class="fa fa-save" aria-hidden="true">
															</i> Save Filter
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row bg-white" id="loaders">
									<svg class="circular" viewBox="25 25 50 50">
										<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
											stroke-miterlimit="10"></circle>
									</svg>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row" id="campiagns_html"></div>
							</div>

							<div class="col-md-12 text-center my-5">
								<nav aria-label="Page navigation example" id="campiagns_pagination">
									<ul id="pagination" class="pagination pagination-sm justify-content-center">
									</ul>
								</nav>
							</div>
						</div>
						<?php
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
												if (count($pages) > 0) {
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
											if (count($pages) > 0 || count($boards) > 0) {
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
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<input type="text" id="request" value="filter" style="display: none;">
<input type="text" id="data_to_post" style="display: none;">
<input type="text" id="id_to_post" style="display: none;">

<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<?php
$this->load->view('templates/publisher/footer'); ?>
<script src="<?= GeneralAssets ?>plugins/pagination/jquery.twbsPagination.min.js"></script>
<script type="text/javascript">
	$(function () {
		//$('.selectpicker').selectpicker();
		var cat = $('#cat').val();
		var domain = $('#domain').find(":selected").val();
		var popularity = $('#popularity').find(":selected").val();
		var dataLoad = {
			request: "filter",
			cat: cat,
			popularity: popularity,
			domain: domain,
			page: 1
		};
		ajaxCallP(dataLoad);
		$(document).on('click', ".facebook", function () {
			var current_user = $("#loggeduserid").val();
			$("#data_to_post").val($(this).data('caption'));
			$("#id_to_post").val($(this).data('id'));
			$("#pagesmodel").modal();
		});
		$(document).on('click', ".autopost", function () {
			$("#page_box").hide();
			$("#loader_box").show();
			var page_id = $(this).data('page');
			var data_to_post = $("#data_to_post").val();
			var id_to_post = $("#id_to_post").val();
			var dataobj = {
				id: page_id,
				data_to_post: data_to_post,
				id_to_post: id_to_post
			}
			$.ajax({
				type: "POST",
				url: "facebook_posting",
				data: dataobj,
				dataType: "json",
				success: function (response) {
					if (response.status) {
						swal({
							title: "Successfully Posted on Facebook",
							// text: data_to_post,
							type: "success",
							timer: 60000,
							showConfirmButton: true
						});
					} else {
						swal({
							title: "Something Went Wrong!",
							text: response.message,
							type: "error",
							timer: 60000,
							showConfirmButton: true
						});
					}
					$("#page_box").show();
					$("#loader_box").hide();
				},
				error: function () {
					$("#page_box").show();
					$("#loader_box").hide();
					swal({
						title: "Something Went Wrong!",
						text: "Error, while posting on facebook. please contact support if you facing this error all the time.",
						type: "error",
						timer: 60000,
						showConfirmButton: true
					});
				}
			});
		});

		$(document).on('click', ".fbgroup-autopost", function () {
			$("#page_box").hide();
			$("#loader_box").show();
			var ig_id = $(this).data('fbgroup');
			var data_to_post = $("#data_to_post").val();
			var id_to_post = $("#id_to_post").val();
			var dataobj = {
				id: ig_id,
				data_to_post: data_to_post,
				id_to_post: id_to_post
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL; ?>facebook_group_posting",
				data: dataobj,
				dataType: "json",
				success: function (response) {
					if (response.status) {
						swal({
							title: "Successfully Posted on Facebook Group",
							// text: data_to_post,
							type: "success",
							timer: 60000,
							showConfirmButton: true
						});
					} else {
						swal({
							title: "Something Went Wrong!",
							text: response.message,
							type: "error",
							timer: 60000,
							showConfirmButton: true
						});
					}
					$("#page_box").show();
					$("#loader_box").hide();
				},
				error: function () {
					$("#page_box").show();
					$("#loader_box").hide();
					swal({
						title: "Something Went Wrong!",
						text: "Error, while posting on facebook group. please contact support if you facing this error all the time.",
						type: "error",
						timer: 60000,
						showConfirmButton: true
					});
				}
			});
		});

		$(document).on('click', ".board-autopost", function () {
			$("#page_box").hide();
			$("#loader_box").show();
			var board_id = $(this).data('board');
			var data_to_post = $("#data_to_post").val();
			var id_to_post = $("#id_to_post").val();
			var dataobj = {
				id: board_id,
				data_to_post: data_to_post,
				id_to_post: id_to_post
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL; ?>pinterest_posting",
				data: dataobj,
				dataType: "json",
				success: function (response) {
					if (response.status) {
						swal({
							title: "Successfully Posted on Pinterest",
							// text: data_to_post,
							type: "success",
							timer: 60000,
							showConfirmButton: true
						});
					} else {
						swal({
							title: "Something Went Wrong!",
							text: response.message,
							type: "error",
							timer: 60000,
							showConfirmButton: true
						});
					}
					$("#page_box").show();
					$("#loader_box").hide();
				},
				error: function () {
					$("#page_box").show();
					$("#loader_box").hide();
					swal({
						title: "Something Went Wrong!",
						text: "Error, while posting on pinterest. please contact support if you facing this error all the time.",
						type: "error",
						timer: 60000,
						showConfirmButton: true
					});
				}
			});
		});

		$(document).on('click', ".ig-autopost", function () {
			$("#page_box").hide();
			$("#loader_box").show();
			var ig_id = $(this).data('ig');
			var data_to_post = $("#data_to_post").val();
			var id_to_post = $("#id_to_post").val();
			var dataobj = {
				id: ig_id,
				data_to_post: data_to_post,
				id_to_post: id_to_post
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL; ?>ig_posting",
				data: dataobj,
				dataType: "json",
				success: function (response) {
					if (response.status) {
						swal({
							title: "Successfully Posted on Instagram",
							// text: data_to_post,
							type: "success",
							timer: 60000,
							showConfirmButton: true
						});
					} else {
						swal({
							title: "Something Went Wrong!",
							text: response.message,
							type: "error",
							timer: 60000,
							showConfirmButton: true
						});
					}
					$("#page_box").show();
					$("#loader_box").hide();
				},
				error: function () {
					$("#page_box").show();
					$("#loader_box").hide();
					swal({
						title: "Something Went Wrong!",
						text: "Error, while posting on instagram. please contact support if you facing this error all the time.",
						type: "error",
						timer: 60000,
						showConfirmButton: true
					});
				}
			});
		});

		$(document).on('change', "#popularity ,#domain, #cat", function () {
			$("#request").val("filter");
			var dataOBJ = {
				request: "filter",
				cat: $("#cat").val(),
				popularity: $("#popularity").val(),
				domain: $("#domain").val(),
				keyword: "",
				page: 1
			};
			ajaxCallP(dataOBJ);
		})
		$(document).on('click', "#recomended", function () {
			$("#request").val("recomended");
			var dataOBJ = {
				request: "recomended",
				page: 1
			};
			ajaxCallP(dataOBJ);
		})
		$(document).on('click', "#searchsubmit", function () {
			if ($.trim($("#searchtext").val()) == "") {
				alertbox("Warning", "Please enter text to search campaings", "warning");
				return false;
			}
			$("#request").val("search");
			var dataOBJ = {
				request: "search",
				cat: $("#cat").val(),
				popularity: $('#popularity').find(":selected").val(),
				domain: $("#domain").val(),
				keyword: $("#searchtext").val(),
				page: 1
			};
			ajaxCallP(dataOBJ);
		})
		$(document).on('submit', "#searchform", function () {
			if ($.trim($("#searchtext").val()) == "") {
				alertbox("Warning", "Please enter text to search campaings", "warning");
				return false;
			}
			$("#request").val("search");
			var dataOBJ = {
				request: "search",
				cat: $("#cat").val(),
				popularity: $('#popularity').find(":selected").val(),
				domain: $("#domain").val(),
				keyword: $("#searchtext").val(),
				page: 1
			};
			ajaxCallP(dataOBJ);
			return false;
		})
		$(document).on('click', ".caption", function () {
			clipboard.copy($(this).data('caption'));
			alertbox("Information", "Text Copied to Clipboard", 'info');
		});
	})

	function ajaxCallP(dataobj) {
		$("#loaders").show();
		$.ajax({
			type: "POST",
			url: "getcampaigns",
			data: dataobj,
			dataType: "json",
			success: function (response) {
				if (response.status) {
					if (response.data.count > 0) {
						appendcp(response.data.campaigns);
						pagination(response.data.count, response.data.pagesize);
					} else {
						$("#campiagns_html").html('<div class="col-md-12 text-center"><div class="alert alert-warning" > No data Found, try to change filter/search criteria.</div></div>');
					}
				} else {
					$("#campiagns_html").html('<div class="col-md-12 text-center"><div class="alert alert-warning" > No data Found, try to change filter/search criteria.</div></div>');

				}
				$("#loaders").hide();
			},
			error: function () {
				$("#loaders").hide();
			}
		});
	}

	function ajaxCallPagination(dataobj) {
		$("#loaders").show();
		$.ajax({
			type: "POST",
			url: "getcampaigns",
			data: dataobj,
			dataType: "json",
			success: function (response) {
				if (response.status) {
					appendcp(response.data.campaigns);
				} else { }
				$("#loaders").hide();
			},
			error: function () {
				$("#loaders").hide();
			}
		});
	}

	function appendcp(campaigns) {
		$("#campiagns_html").html("");
		$(campaigns).each(function (e) {
			var _blank = "_blank";
			var campaign = $(this)[0];
			oncl = "window.open(" + "'" + campaign.campaign_link + "'" + "," + "'_blank')";
			var node = '<div class="col-lg-3 col-md-6">'
			node += '<div class="card blog-widget">'
			node += '<div class="card-body">'
			node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:250px;" loading="lazy" src="' + campaign.img + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
			node += '<p class="my-2" style="height:80px;overflow: hidden;" ><a href="' + campaign.campaign_heading + '">' + campaign.campaign_heading + '</a></p>'
			// node += '<p class="my-2" style="height:80px;overflow: hidden;" ><a href="' + campaign.campaign_heading + '"</a></p>'
			node += '<div class="d-flex align-items-center">'
			node += '<div class="read"><a href="' + campaign.campaign_link + '" target="_blank" class="link font-medium">Read More</a></div>'
			node += '<div class="ml-auto">'
			node += '<a  class="link mr-2" data-toggle="tooltip" title="Total Views" data-original-title="Hits on this campaign"><i class="mdi mdi-poll h5"></i> ' + campaign.total_clicks + ' </a>'
			node += '<a  class="link mr-2 caption h5  cursor-pointer"  data-caption="' + campaign.withcaption + '"  data-toggle="tooltip" title="Copy link address" data-original-title="Copy link to share manually"><i class="mdi mdi-content-copy"></i></a>'
			node += '<a  class="link h5  cursor-pointer facebook" data-id="' + campaign.id + '"  data-caption="' + campaign.withoutcaption + '"  data-toggle="tooltip" title="Share on channels" data-original-title="Share"><i class="mdi mdi-share-variant"></i></a>'
			node += '</div>'
			node += '</div>'
			node += '</div>'
			node += '</div>'
			node += '</div>';
			$("#campiagns_html").append(node);
			$('[data-toggle="tooltip"]').tooltip()
			$('img').on("error", function () {
				$(this).attr('src', '<?= GeneralAssets ?>/images/noimage.png');
			});
		})
	}

	function pagination(count, pagesize) {
		var total_pages = parseInt(Math.ceil(count / pagesize));
		$('#campiagns_pagination').html("");
		$('#campiagns_pagination').html('<ul id="pagination" class="pagination-sm"></ul>');
		$('#pagination').twbsPagination({
			totalPages: total_pages,
			visiblePages: 10,
			next: 'Next',
			prev: 'Prev',
			onPageClick: function (event, page) {
				//fetch content and render here
				var request = $("#request").val();
				var dataOBJ = {
					request: "",
					page: page
				};
				if (request == "filter") {
					dataOBJ = {
						request: "filter",
						cat: $("#cat").val(),
						popularity: $('#popularity').find(":selected").val(),
						domain: $("#domain").val(),
						keyword: "",
						page: page
					};
				} else if (request == "recomended") {
					dataOBJ = {
						cat: $("#cat").val(),
						popularity: $('#popularity').find(":selected").val(),
						domain: $("#domain").val(),
						request: "recomended",
						page: page
					};
				} else if (request == "search") {
					dataOBJ = {
						cat: $("#cat").val(),
						popularity: $('#popularity').find(":selected").val(),
						domain: $("#domain").val(),
						request: "search",
						page: page
					};
				}
				ajaxCallPagination(dataOBJ);
			}
		});
	}
	$(document).on('click', "#save_filter", function () {
		var cat = $("#cat").val();
		var popularity = $("#popularity").val();
		var domain = $("#domain").val();
		var dataobj = {
			cat: cat,
			popularity: popularity,
			domain: domain
		};
		///console.log(dataOBJ);
		$.ajax({
			type: "POST",
			url: "save_filter",
			data: dataobj,
			dataType: "json",
			complete: function (response) {
				alertbox("Success", "Settings are saved now", "success");
			}
		});
	});
</script>