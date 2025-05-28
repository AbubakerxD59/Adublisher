<style>
	button.on_off {
		color: #fff !important;
	}

	button.on_off:hover {
		color: #111 !important;
	}

	.image-popup-overlay {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 97%;
		height: 97%;
		background: rgba(0, 0, 0, 0.7);
		justify-content: center;
		align-items: center;
		z-index: 9999;
	}

	.image-popup-content {
		text-align: center;
		position: relative;
	}

	.close-btn {
		position: absolute;
		top: 10px;
		right: 10px;
		font-size: 24px;
		color: #fff;
		cursor: pointer;
	}

	#popupImage {
		max-width: 90%;
		max-height: 90%;
	}

	.image-popup-fit-width:hover {
		cursor: pointer;
	}

	.automation-socials {
		border: 1px solid #d7dfe3;
		border-radius: 4px;
		padding: 6px;
		-webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
		box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
	}

	/* Border color based on active state */
	.automation-socials.active#rss {
		border-color: #f78422;
	}

	.automation-socials.active#shopify {
		border-color: #94be46;
	}

	.automation-socials.active#youtube {
		border-color: #ff0000;
	}

	/* Hover */
	.automation-socials:hover {
		cursor: pointer;
	}

	.btn-info,
	.btn-info.disabled {
		background: #1e88e5;
		border: 1px solid #1e88e5;
		-webkit-transition: 0.2s ease-in;
		-o-transition: 0.2s ease-in;
		transition: 0.2s ease-in;
		font-size: 14px;
		padding: 8px 18px;
		border-radius: 5px;
		height: auto;
	}
</style>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
	integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div>
			<div>
				<div class="card simple-card">
					<div class="card-body">
						<!-- ============================================================== -->
						<!-- End Bread crumb and right sidebar toggle -->
						<!-- ============================================================== -->
						<!-- ============================================================== -->
						<!-- Start Page Content -->
						<!-- ============================================================== -->
						<?php
						echo @$upr['pxn'];
						echo loader();
						?>
						<div class="row p-10 m-0" id="content_area">
							<div class="col-md-12 col-xlg-12">
								<?php
								if (count(get_all_social_accounts()) == 0) {
									?>
									<div class="col-md-12 text-center">
										<div class="alert alert-warning">
											<h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> No Social
												Account connected </h3>
											<p><br>Click <a href="<?php echo SITEURL . 'social-accounts'; ?>"> HERE </a> to
												connect right now. so Adublisher can publish posts you schedule/set.<br>
												<b>Note - we will NEVER send anything to your friends or post anything that
													you haven't scheduled/set first!</b>
											</p>
											<p>Later you can disconnect this app, just like any other social media based
												app.</p>
										</div>
									</div>
								</div>
								<?php
								}

								?>
							<!-- Column -->
							<?php
							if (count($user_pages) > 0 || count($pinterest_boards) > 0 || count($ig_accounts) > 0 || count($fb_groups) > 0) {
								?>
								<div class="container">
									<div class="row">
										<!-- Rss -->
										<div class="col-md-4 automation-socials p-2 active" id="rss">
											<img src="<?= GeneralAssets ?>images/rss_logo.png" width="80"><br><br>
											<small>Your Regular <strong>Rss Feed</strong></small>
										</div>
										<!-- Shopify -->
										<!-- <div class="col-md-4 automation-socials" id="shopify">
			 <div class="row p-2">
				 <div class="col-md-8">
					<img src="<?= GeneralAssets ?>images/shopify_attachments/shopify_logo.png" width="80">
				 </div>
				 <div class="col-md-4">
					 <?php if (empty($user[0]->shopify_adminApiAccessToken)): ?>
					  <button type="button" class="btn btn-info btn-sm shopify-attach-button float-right" data-toggle="modal" data-target="#staticBackdrop">
						  <i class="fa-brands fa-shopify">&nbsp;</i> Attach Shopify
					  </button>
				   <?php else: ?>
					  <button type="button" class="btn btn-info btn-sm shopify-disconnect-button float-right">
						  <i class="fa-brands fa-shopify">&nbsp;</i> Disconnect Shopify
					  </button>
				   <?php endif; ?>
				 </div>
			 </div>
			<br>
			<small>Want to fetch your Shopify Store products? Click Here <a data-toggle="modal" href="#shopify-modal">more info!</a></small>
		 </div> -->
										<!-- youtube -->
										<!-- <div class="col-md-4 automation-socials p-2" id="youtube">
			<img src="<?= GeneralAssets ?>images/youtube_logo.png" width="50"><br><br>
			<small>Coming Soon!</small>
		 </div> -->
									</div>
								</div>
								<!-- End -->
								<!-- <div class="col-md-4 align-self-center">
	  <?php if (empty($user[0]->shopify_adminApiAccessToken)): ?>
		  <button type="button" class="btn btn-info shopify-attach-button float-right" data-toggle="modal" data-target="#staticBackdrop">
			  <i class="fa-brands fa-shopify">&nbsp;</i> Attach Shopify
		  </button>
	  <?php else: ?>
		  <button type="button" class="btn btn-info shopify-disconnect-button float-right">
			  <i class="fa-brands fa-shopify">&nbsp;</i> Disconnect Shopify
		  </button>
	  <?php endif; ?>
	  </div> -->
								<div class="card my-2 social-active-color" id="allstepsdiv">
									<div class="card-body">
										<div class="row my-2">
											<div class="form-group col-md-4" id="step1">
												<label><b>Step 1-</b> Select Channel: <i class="mdi mdi-help-circle-outline"
														data-toggle="tooltip" data-placement="bottom" title=""
														data-original-title="First step is to select channel, your channel must have published status on channel's account."></i>
												</label>
												<input type="hidden" id="title" value="This is the test Tile">
												<select id="pages" class=" form-control">
													<option value="">Select Channel</option>
													<?php
													if (count($user_pages) > 0) {
														foreach ($user_pages as $page) {
															?>
															<option value="<?= $page->id; ?>" <?php echo $user[0]->selected_rss == $page->id ? "selected" : ""; ?>
																data-type="facebook" data-name="<?= $page->page_name; ?>">
																<?= $page->page_name; ?> / FACEBOOK
															</option>
															<?php
														}
													}
													if (count($fb_groups) > 0) {
														foreach ($fb_groups as $group) {
															?>
															<option value="<?= $group->id ?>" <?php echo $user[0]->selected_rss == $group->id ? "selected" : ""; ?>
																data-type="fb_group" data-name="<?= $group->name ?>">
																<?= $group->name ?> / FB-GROUP
															</option>
															<?php
														}
													}
													if (count($pinterest_boards) > 0) {
														foreach ($pinterest_boards as $board_item) {
															?>
															<option value="<?= $board_item->id; ?>" <?php echo $user[0]->selected_rss == $board_item->id ? "selected" : ""; ?>
																data-type="pinterest" data-name="<?= $board_item->name; ?>">
																<?= $board_item->name; ?> / PINTEREST
															</option>
															<?php
														}
													}
													if (count($ig_accounts) > 0) {
														foreach ($ig_accounts as $ig_item) {
															?>
															<option value="<?= $ig_item->id; ?>" <?php echo $user[0]->selected_rss == $ig_item->id ? "selected" : ""; ?>
																data-type="instagram"
																data-name="<?= $ig_item->instagram_username; ?>">
																<?= $ig_item->instagram_username; ?> / INSTAGRAM
															</option>
															<?php
														}
													}
													if (count($tiktoks) > 0) {
														foreach ($tiktoks as $tiktok) {
															?>
															<option value="<?= $tiktok->id; ?>" <?php echo $user[0]->selected_rss == $tiktok->id ? "selected" : ""; ?>
																data-type="tiktok" data-name="<?= $tiktok->username; ?>">
																<span>
																	<?php echo $tiktok->username; ?> / TIKTOK
																</span>
															</option>
															<?php
														}
													}
													?>
												</select>
												<br><br>
												<div class="row on_off" style="display: none;">
													<div class="col-md-7 pl-3"> <small> Turn Rss posting ON and
															OFF</small> </div>
													<div class="col-md-5">
														<div class="switch">
															<label>OFF<input type="checkbox" class="rssposting"><span
																	class="lever switch-col-light-blue"></span>ON</label>
														</div>
													</div>
												</div>
												<div class="row forshopify" style="display: none;">
													<div class="col-md-7 pl-3"> <small> Turn Shopify posting ON and
															OFF</small> </div>
													<div class="col-md-5">
														<div class="switch">
															<label>OFF<input type="checkbox" class="shopifyposting"><span
																	class="lever switch-col-light-blue"></span>ON</label>
														</div>
													</div>
												</div>
												<div class="row foryoutube" style="display: none;">
													<div class="col-md-7 pl-3"> <small> Turn Youtube posting ON and
															OFF</small> </div>
													<div class="col-md-5">
														<div class="switch">
															<label>OFF<input type="checkbox" class="youtubeposting"><span
																	class="lever switch-col-light-blue"></span>ON</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group col-md-4" id="step2">
												<label><b>Step 2-</b> Select hours:<i class="mdi mdi-help-circle-outline"
														data-toggle="tooltip" data-placement="bottom" title=""
														data-original-title="Second step is to select time slots, You can max select 24 time slots per day. Select Atleast one time slot to enable RSS FEED input box."></i>
												</label>
												<select id="timeslots" multiple data-placeholder="Select Hours to post..."
													class="chosen-select form-control">
													<?php for ($i = 0; $i < 24; $i++): ?>
														<option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00
															<?= $i >= 12 ? 'pm' : 'am' ?>
														</option>
													<?php endfor ?>
												</select>
												<small><i class="fa fa-check text-success"></i> Time slots will
													automatically save upon changing.</small>
											</div>
											<div class="form-group col-md-4" id="step3">
												<div id="step-3-rss">
													<label><b>Step 3-</b> Feed URL: <i class="mdi mdi-help-circle-outline"
															data-toggle="tooltip" data-placement="bottom" title=""
															data-original-title="Third step is to input Rss Feed Link"></i>
													</label>
													<div class="to-be-cloned-container">
														<div class="input-group">
															<input type="url"
																class="form-control to-be-cloned-input original-input"
																style="cursor:pointer;" id="rss_feed"
																placeholder="Please enter url..." autocomplete="off">
															<div class="input-group-append">
																<button
																	class="on_off btn btn-sm btn-danger fa fa-trash-o text-danger pointer delete_rss"
																	style="display:block; border: 1px solid red !important; border-radius: 0; padding: 12px;">
																	<!-- <button class="on_off btn btn-sm btn-danger fa fa-trash-o text-danger pointer delete_rss" style="display:none; border: 1px solid red !important; border-radius: 0; padding: 12px;"> -->
																	<!-- <i class="on_off fa fa-trash-o text-danger pointer delete_rss" style="display:none; margin-left: 3px;"></i> -->
																</button>
															</div>
															<br>
															<!-- fa fa-get-pocket -->
															<button
																class="fetch_ten_more btn btn-sm btn-info pointer fa-brands fa-get-pocket"
																style="display:block; border: 1px solid #1e88e5 !important; border-radius: 0; padding: 12px;"></button>
															<!-- <button class="fetch_ten_more btn btn-sm btn-info pointer fa-brands fa-get-pocket" style="display:none; border: 1px solid #1e88e5 !important; border-radius: 0; padding: 12px;"></button> -->
														</div>
														<small class="last-run-small"></small>
													</div>
													<br>
													<button class="btn btn-info float-right duplicate-button"
														id="showButton"
														style="display: block; padding: 8px 11px; border-radius: 0;"><i
															class="fa fa-plus"></i></button><br><br><br>
													<!-- <button class="btn btn-sm btn-info float-right" id="submit_rss" type="button">Submit</button> -->
												</div>
												<div id="step-3-shopify" style="display:none;">
													<label><b>Step 3-</b> Shopify: <i class="mdi mdi-help-circle-outline"
															data-toggle="tooltip" data-placement="bottom" title=""
															data-original-title="Third step is to input Rss Feed Link"></i>
													</label>
													<br>
													<button class="btn btn-info float-right shopify-rss-button"
														id="shopifyRssButton"
														style=" display:none; padding: 8px 11px; border-radius: 0;"><i
															class="fa-brands fa-shopify"></i>&nbsp;Fetch Shopfy Store
														Products</button>
													<br><br>
													<small class="last-run-shopify-small float-right"></small>
												</div>
												<div id="step-3-youtube" style="display:none;">
													<label><b>Step 3-</b> Youtube: <i class="mdi mdi-help-circle-outline"
															data-toggle="tooltip" data-placement="bottom" title=""
															data-original-title="Third step is to input Rss Feed Link"></i>
													</label>
													<p>Coming Soon!</p>
												</div>
											</div>
										</div>
										<!--row-->
										<!-- <div class="row">
			<div class="col-lg-4 col-md-4 col-sm-3 col-2 text-center">
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6 col-8 text-center">
				<button class="btn btn-sm btn-info" id="submit_rss" type="button">Submit RSS Data!</button>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-3 col-2 text-center">
			</div>
			</div> --><!--row-->
									</div>
									<!-- Column -->
								</div>
								<!-- Shopify Attach Modal -->
								<div class="shopify" style="display: inline;">
									<!-- <p class="m-2">Must read <a data-toggle="modal" href="#shopify-modal">this info! </a> while connecting Shopify Store.</p> -->
									<!-- Button trigger modal -->
									<!-- <button type="button" style="padding: 8px 11px; border-radius: 0;" class="btn btn-info float-left shopify-int-button" data-toggle="modal" data-target="#staticBackdrop">Attach Shopify</button> -->
									<!-- Modal -->
									<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false"
										tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="staticBackdropLabel">Add Credentials
													</h5>
													<button type="button" class="close" data-dismiss="modal"
														aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form>
														<div class="form-group">
															<label for="apiKey">API Key</label>
															<input type="text" class="form-control" id="apiKey"
																placeholder="Enter API Key">
														</div>
														<div class="form-group">
															<label for="apiSecretKey">API Secret Key</label>
															<input type="text" class="form-control" id="apiSecretKey"
																placeholder="Enter API Secret Key">
														</div>
														<div class="form-group">
															<label for="adminApiAccessToken">Admin API Access
																Token</label>
															<input type="text" class="form-control" id="adminApiAccessToken"
																placeholder="Enter Admin API Access Token">
														</div>
														<div class="form-group">
															<label for="storeName">Store Name</label>
															<input type="text" class="form-control" id="storeName"
																placeholder="Enter Store Name">
														</div>
													</form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary"
														data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-primary"
														id="ShopifyCredentials">Submit</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Shopify Info Modal -->
								<div class="modal fade" id="shopify-modal" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Connecting Shopify Store
												</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<p> To link a Shopify Store and schedule products through Adublisher,
													authentication is required through your Shopify Store.</p>
												<hr>
												<article>
													<header>
														<h3 style="display:inline;">Connecting Shopify Store <small><a
																	href="https://admin.shopify.com/" target="_blank">Click
																	here</a></small></h3>
														<br>
													</header>
													<div>
														<p>You will need to complete these steps</p>
														<ol class="list-colored">
															<li>
																<p>Log into your Shopify account</p>
															</li>
															<li>
																<p>Copy the <strong>Store Name</strong> from the
																	<em>URL</em> for Later Use and then Click
																	<em><strong>Settings</strong></em> on the left hand
																	side.
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/1.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/1.png')">
																</p>
															</li>
															<li>
																<p>Find the <em><strong>Apps and sales channels in Menu
																			section </strong></em>towards the bottom of
																	the page and then click on it <em><strong>Apps and
																			sales channels</strong></em>.</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/2.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/2.png')">
																</p>
															</li>
															<!-- <li>
						   <p>Copy Your <em><strong>Store Name for later use</strong></em>.</p>
						   <p>
							  <img class="image-popup-fit-width" src="<?= GeneralAssets ?>images/shopify_attachments/3.png" width="600" onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/3.png')">
						   </p>
						</li> -->
															<li>
																<p>Click On Develop apps.</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/4.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/4.png')">
																</p>
															</li>
															<li>
																<p>Click On Create an app.</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/5.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/5.png')">
																</p>
															</li>
															<li>
																<p>Give Your App any Name <em><strong>(Example :
																			Adublisher)</strong></em> and then click on
																	Create app.</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/6.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/6.png')">
																</p>
															</li>
															<li>
																<p>Click on <em><strong>Configure Admin Api
																			Scopes</strong></em> </p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/7.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/7.png')">
																</p>
															</li>
															<li>
																<p>Search for <em><strong>read_product</strong></em>
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/8.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/8.png')">
																</p>
															</li>
															<li>
																<p>Check the <em><strong>read_products
																			checkbox</strong></em> and click on Save in
																	upper right corner.</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/9.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/9.png')">
																</p>
															</li>
															<li>
																<p>Click on <em><strong>API credentials
																			tab</strong></em></p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/10.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/10.png')">
																</p>
															</li>
															<li>
																<p>Scroll Down to get <em><strong>API key and Api Secret
																			key</strong></em> Make sure to copy them for
																	later use</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/11.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/11.png')">
																</p>
															</li>
															<li>
																<p>Scroll Above again to install your app, Click on
																	<em><strong>Install app </strong></em>button in the
																	upper right corner
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/12.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/12.png')">
																</p>
															</li>
															<li>
																<p>Just Click on <em><strong>Install</strong></em>
																	button</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/13.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/13.png')">
																</p>
															</li>
															<li>
																<p>Reveal your token by clicking <em><strong>Reveal
																			token once </strong></em></p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/14.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/14.png')">
																</p>
															</li>
															<li>
																<p>Make sure to copy and save this token for later use
																	<em><strong>You can only get this Token one time
																		</strong></em>
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/15.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/15.png')">
																</p>
															</li>
															<li>
																<p>Click On <strong>Attach Shopify</strong> button <em>
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/16.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/16.png')">
																</p>
															</li>
															<li>
																<p>Now Paste all the Credentials in the <strong>Attach
																		Shopify</strong> modal that you copied earlier
																	<em><strong>1 - Api Key , 2 - Api Secret Key , 3 -
																			Admin Api Access Token , 4 - Store Name
																		</strong></em>and click on Submit
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/17.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/17.png')">
																</p>
															</li>
															<li>
																<p>Now select any <strong>Channel</strong> from
																	<em><strong>Step 1 - Select Channel</strong></em>
																	and click on <strong>Fetch Products</strong> button
																	to fetch Product for the selected channel
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/18.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/18.png')">
																</p>
															</li>
															<li>
																<p>Your Shopify <strong>Scheduled Products</strong><em>
																</p>
																<p>
																	<img class="image-popup-fit-width"
																		src="<?= GeneralAssets ?>images/shopify_attachments/19.png"
																		width="600"
																		onclick="showImage('<?= GeneralAssets ?>images/shopify_attachments/19.png')">
																</p>
															</li>
														</ol>
													</div>
												</article>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary"
													data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								<!-- Showing Shopify Instruction Images on POP Up -->
								<div class="image-popup-overlay" id="imagePopupOverlay">
									<div class="image-popup-content">
										<span class="close-btn" onclick="closeImagePopup()">&times;</span>
										<img id="popupImage" class="img-fluid" src="" alt="Popup Image">
									</div>
								</div>
								<!-- End Shopify -->
								<div class="card ">
									<div class="card-header ">
										<div class="row">
											<div
												class="col-md-12 m-t-10 text-left d-block d-md-flex justify-content-between">
												<div>
													<button class="btn btn-info rss_posts_tab_scheduled"
														data-toggle="tooltip" data-placement="bottom" title=""
														data-original-title="Here you can manage the existing posts on pages. Select Page to load posts">Scheduled
														Posts</button>
													<button class="btn btn-secondary rss_posts_tab_published"
														data-toggle="tooltip" data-placement="bottom" title=""
														data-original-title="Select Page to load published posts.">Published
														Posts</button>
													<!-- <b>Manage Scheduled Posts </b> <span id="pagenamedisplay"></span>: <i class="mdi mdi-help-circle-outline" ></i> -->
												</div>
												<div class="row info_tab" style="display: none;">
													<div class="form-group col-md-12 text-center">
														<div>
															<small>TOTAL POSTS: </small>
															<span class="total_posts" style="font-weight: 800;"></span>
														</div>
														<div>
															<small class="pl-3">SCHEDULED UNTIL: </small>
															<span class="scheduled_until" style="font-weight: 800;"></span>
														</div>
													</div>
												</div>
												<div class="d-flex justify-content-end">
													<button class="btn btn-danger deleteall btn-sm"
														style="display: none; height: fit-content;" data-error="all"
														data-toggle="tooltip" data-placement="bottom" title=""
														data-original-title="Deletes current Feed."><i
															class="fa fa-trash pointer"></i> Delete All</button>
													<button class="btn btn-success shuffle btn-sm mx-2"
														style="display: none; height: fit-content;" data-toggle="tooltip"
														data-placement="bottom" title=""
														data-original-title="Shuffles current Feed."><i
															class="fa fa-refresh pointer"></i> Shuffle</button>
													<button class="btn btn-info refresh_timeslots btn-sm"
														style="display: none; height: fit-content;" data-toggle="tooltip"
														data-placement="bottom" title=""
														data-original-title="Refresh timeslots of current Feed. Fill the missing timeslots."><i
															class="fa fa-hourglass pointer"></i> Refresh</button>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body b-t">
										<div class="col-md-12 row el-element-overlay" id="sceduled">
										</div>
									</div>
								</div>
								<?php
							}
							if (!(count($user_pages) > 0 || count($fb_groups))) {
								?>
								<!-- <div class="card simple-card">
	  <div class="card-body">
		 <div class="col-md-12 text-center">
			<div class="alert alert-warning">
			   <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Facebook not connected </h3>
			   <p><br>Connecting and authorizing facebook pages is required, Click <a href="<?php echo $this->facebook->addpage_url(); ?>"> HERE </a> to connect right now. so Adublisher can publish posts you schedule/set.<br>
				  <b>Note - we will NEVER send anything to your friends or post anything that you haven't scheduled/set first!</b>
			   </p>
			   <p>Later you can disconnect this app, just like any other social media based app.</p>
			</div>
		 </div>
	  </div>
   </div> -->
								<?php
							}
							?>
							<!-- ============================================================== -->
							<!-- End PAge Content -->
							<!-- ============================================================== -->
						</div>
						<!-- ============================================================== -->
						<!-- End Container fluid  -->
						<!-- ============================================================== -->
						<!-- ============================================================== -->
						<?php $this->load->view('templates/publisher/footer'); ?>
						<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
						<script type="text/javascript">
							$(function () {
								var offset, limit;
								$('#pages').change(function () {
									$('.info_tab').hide();
									offset = 0;
									limit = 20;
									var selected_id = $(this).val();
									var text = $(this).find('option:selected').text();
									var selected_type = $(this).find('option:selected').data('type');
									var schedule_url = '';
									if (selected_type == 'pinterest') {
										schedule_url = 'get_pinterest_rssscheduled';
									} else if (selected_type == 'facebook') {
										schedule_url = 'getrssscheduled';
									} else if (selected_type == 'fb_group') {
										schedule_url = 'get_fb_group_rssscheduled';
									} else if (selected_type == 'instagram') {
										schedule_url = 'get_ig_rssscheduled';
									} else if (selected_type == 'tiktok') {
										schedule_url = 'get_tiktok_rssscheduled';
									}
									if (selected_id != '' && selected_id != null) {
										save_default(selected_id);
									}
									get_rssscheduled(schedule_url);
								});

								var save_default = function (selected_id) {
									$.ajax({
										url: "<?php echo SITEURL; ?>save_default",
										type: "POST",
										data: {
											'selected_id': selected_id
										}
									});
								}

								var get_rssscheduled = function (schedule_url) {
									$(".deleteall").hide();
									$(".refresh_timeslots").hide();
									$(".shuffle").hide();
									var page = $("#pages").val();
									if (page != "") {
										$("#sceduled").html("");
										// This line checks if div is Rss, Shopify or Youtube then will get the same data from database
										var activeDivId = $(".automation-socials.active").attr("id");
										var dataOBJ = {
											'id': page,
											'activedivid': activeDivId,
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + schedule_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												// $('#preloader_ajax').hide();
												function splitData(data) {
													if (typeof data === "string") {
														return data.split(',');
													} else if (Array.isArray(data)) {
														return data;
													} else {
														return [];
													}
												}

												var lastRunShopify = response.last_shopify_run;
												// Last Run Shopify //
												if (lastRunShopify === '' || lastRunShopify === null) {
													$(".last-run-shopify-small").html('<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data');
												} else {
													$(".last-run-shopify-small").html('<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + lastRunShopify);
												}
												// End //

												var originalContainer = document.querySelector(".to-be-cloned-container");
												var retrievedData = response.rss_link;
												// Check if retrievedData is not empty
												if (retrievedData.length > 0) {
													// Clear the existing cloned containers except the original one
													var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
													for (var i = 1; i < clonedContainers.length; i++) {
														clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
													}

													// Set the value of the original input field and corresponding last run time
													originalContainer.querySelector(".original-input").value = retrievedData[0].link;

													if (retrievedData[0].last_run === '' || retrievedData[0].last_run === null) {
														originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
													} else {
														originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[0].last_run;
													}
													// Clone and append additional input field containers for the remaining URLs and last run times
													for (var i = 1; i < retrievedData.length; i++) {
														var clone = originalContainer.cloneNode(true);
														clone.querySelector(".original-input").value = retrievedData[i].link;
														if (retrievedData[i].last_run === '' || retrievedData[i].last_run === null) {
															clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
														} else {
															clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[i].last_run;
														}
														originalContainer.parentNode.insertBefore(clone, originalContainer.nextSibling);
													}
												}

												// $("#loader").hide();

												if (activeDivId == 'rss') {
													$(".on_off").show();
													$(".forshopify").hide();
													$(".foryoutube").hide();
												} else if (activeDivId == 'shopify') {
													$(".on_off").hide();
													$(".forshopify").show();
													$(".foryoutube").hide();
												} else if (activeDivId == 'youtube') {
													$(".on_off").hide();
													$(".forshopify").hide();
													$(".foryoutube").show();
												}
												$(".fetch_ten_more").show();

												if (response.rss_active === "1") {
													$(".rssposting").prop("checked", true);
												} else {
													$(".rssposting").prop("checked", false);
												}

												if (response.shopify_active === "1") {
													$(".shopifyposting").prop("checked", true);
												} else {
													$(".shopifyposting").prop("checked", false);
												}


												if (response.time_slots) {
													$('#timeslots').val($.parseJSON(response.time_slots)).trigger("chosen:updated");
												} else {
													$('#timeslots').val("").trigger("chosen:updated");
												}
												if (response.status) {
													if (response.data) {
														$('.info_tab').show();
														$('.total_posts').html(response.count);
														$('.scheduled_until').html(response.scheduled_until);
														$(".deleteall").show();
														$(".refresh_timeslots").show();
														$(".shuffle").show();
													}
													$.each(response.data, function (index, elem) {
														var icon = "mdi mdi-calendar-clock text-info mdi-24px"
														var error = "";
														if (elem.posted == -1) {
															if (elem.error) {
																icon = "mdi mdi-alert-circle-outline text-danger mdi-24px";
																error = '<div class="alert alert-danger">' + elem.error + '</div>';
															} else {
																icon = "mdi mdi-check-circle-outline text-success mdi-24px";
															}
														}
														// oncl = "window.open('"+elem.url+",_blank')";
														oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
														var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
														node += '<div class="card blog-widget">'
														node += '<div class="card-body">'
														node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
														node += '<p><strong style="cursor:pointer;" title="' + elem.title + '">' + elem.title.slice(0, 22) + '...</strong></p>';
														node += '<a href="' + elem.url + '" target="_blank"><p><strong title="' + elem.url + '">' + elem.url.slice(0, 25) + '...</strong></p></a>';
														if (error) {
															node += '<p class="my-0">' + error + '</p>'
														}
														node += '<div class="d-flex align-items-center" style="border-top: 1px solid #e6dbdb; padding-top: 5px;">'
														node += '<div class="read"><p class="my-2""><strong> <i class="mdi mdi-calendar-clock text-info mdi-24px"></i>' + elem.post_date + '</strong></p></div>'
														node += '</div>'
														node += '<div class="d-flex float-right">'
														node += '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success" id="publish_now" data-id="' + elem.id + '"  data-toggle="tooltip" title="Publish this post!">Publish</a>'
														node += '<a href="javascript:void(0);" class="h5 cursor-pointer delbulkone btn btn-sm btn-outline-danger" data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
														node += '</div>'
														node += '</div>'
														node += '</div>'
														node += '</div>';
														$("#sceduled").append(node);
													});
													if (response.data) {
														// load more button
														var load_more = "<div class='col-12 d-flex justify-content-center'>";
														load_more += "<button class='btn btn-outline-info load_more d-none'>Load More</button>";
														load_more += "</div>";
														$("#sceduled").append(load_more);
													}
												}
											},
											error: function () {
												$("#sceduled").html("");
												// $("#loader").hide();
											}
										});
									} else {
										$('#timeslots').val("").trigger("chosen:updated");
										$("#sceduled").html("");
										// Set the 'rss_feed' input field to an empty value
										$('#rss_feed').val("");
										// Remove any additional cloned containers
										var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
										for (var i = 1; i < clonedContainers.length; i++) {
											clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
										}
									}
								};

								$(".rssposting").click(function () {
									var selected_type = $('#pages').find('option:selected').data('type');
									if (selected_type == 'pinterest') {
										rss_feed_on_off_url = 'pinterest_rss_feed_onoff';
									} else if (selected_type == 'facebook') {
										rss_feed_on_off_url = 'rssfeedonoff';
									} else if (selected_type == 'fb_group') {
										rss_feed_on_off_url = 'fb_group_rss_feed_onoff'
									} else if (selected_type == 'instagram') {
										rss_feed_on_off_url = 'ig_rss_feed_onoff';
									} else if (selected_type == 'tiktok') {
										rss_feed_on_off_url = 'tiktok_rss_feed_onoff';
									}
									rss_feed_on_off(rss_feed_on_off_url);
								});
								var rss_feed_on_off = function () {
									var page = $("#pages").val();
									if (page != "") {
										$("#loader").show();
										var status = "0";
										if ($(".rssposting").is(":checked")) {
											status = "1";
										}
										var dataOBJ = {
											'page': page,
											'rss_active': status
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + rss_feed_on_off_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												$("#loader").hide();
												swal({
													title: "Success!",
													text: "Rss has been changed successfully!",
													type: "success",
													showConfirmButton: false,
													timer: 1500
												});
											},
											error: function () { }
										});
									}
								};

								$(".shopifyposting").click(function () {
									var selected_type = $('#pages').find('option:selected').data('type');
									if (selected_type == 'pinterest') {
										shopify_automation_on_off_url = 'shopify_pinterest_automation_onoff';
									} else if (selected_type == 'facebook') {
										shopify_automation_on_off_url = 'shopify_fb_page_automation_onoff';
									} else if (selected_type == 'fb_group') {
										shopify_automation_on_off_url = 'shopify_fb_group_automation_onoff'
									} else {
										shopify_automation_on_off_url = 'shopify_insta_automation_onoff';
									}
									shopify_automation_on_off(shopify_automation_on_off_url);
								});
								var shopify_automation_on_off = function () {
									var page = $("#pages").val();
									if (page != "") {
										$("#loader").show();
										var status = "0";
										if ($(".shopifyposting").is(":checked")) {
											status = "1";
										}
										var dataOBJ = {
											'page': page,
											'shopify_active': status
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + shopify_automation_on_off_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												$("#loader").hide();
												swal({
													title: "Success!",
													text: "Shopify Automation has been changed successfully!",
													type: "success",
													showConfirmButton: false,
													timer: 1500
												});
											},
											error: function () { }
										});
									}
								};


								$(document).on("click", ".shopify-disconnect-button", function () {
									swal({
										title: "Disconnect Shopify Account!",
										html: true, // Enable HTML in the text
										text: "Are you sure you want to disconnect <strong>Shopify</strong><br>All your scheduled <strong>products</strong> will be deleted too.?",
										type: "info",
										showCancelButton: true,
										confirmButtonColor: "#1e88e5",
										confirmButtonText: "Yes, Disconnect!",
										closeOnConfirm: true // Automatically close on confirm
									}, function (confirmed) {
										if (confirmed) {
											disconnect_shopify_account();
										}
									});
								});
								var disconnect_shopify_account = function () {
									var user_id = "<?php echo $user[0]->id; ?>";
									$("#preloader_ajax").show();
									$("#loader").show();
									var dataOBJ = {
										'user_id': user_id
									};
									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + "disconnect_shopify_account",
										data: dataOBJ,
										dataType: "json",
										success: function (response) {
											// Handle success, e.g., display a success message
											$("#preloader_ajax").hide();
											$("#loader").hide();
											swal({
												title: "Success!",
												text: "Your Shopify Account is Disconnected!",
												type: "success",
												showConfirmButton: false,
												timer: 1500
											});
											window.location.reload();
										},
										error: function (response) {
											// Handle errors if the AJAX request fails
											$("#preloader_ajax").hide();
											$("#loader").hide();
											var response = JSON.parse(response.responseText);
											var message = response.message;
											var status = response.status;
											var page_trigger = response.page_trigger;
											if (page_trigger) {
												$('#pages').trigger('change');
											}
											swal({
												title: "Error!",
												text: message,
												// text: "You need to store this link first |or| You can not fetch empty link posts",
												type: "error",
												showConfirmButton: false,
												timer: 4000
											});
										}
									});
								};

								// load more button
								var loading = false;
								$(document).on('click', '.load_more', function () {
									if (loading) {
										return;
									}
									loading = true;
									var page_id = $("#pages").val();
									var selected_type = $('#pages').find('option:selected').data('type');
									var activeDivId = $(".automation-socials.active").attr("id");
									offset += limit;
									load_more_posts(page_id, selected_type, activeDivId);
								});

								var load_more_posts = function (page_id, selected_type, activeDivId) {
									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + "loadmoreposts",
										data: {
											'page_id': page_id,
											'type': selected_type,
											'activeDivId': activeDivId,
											'offset': offset,
											'limit': limit,
										},
										success: function (response) {
											$('.load_more').remove();
											if (response.count > 0) {
												$.each(response.data, function (index, elem) {
													var icon = "mdi mdi-calendar-clock text-info mdi-24px"
													var error = "";
													if (elem.posted == -1) {
														if (elem.error) {
															icon = "mdi mdi-alert-circle-outline text-danger mdi-24px";
															error = '<div class="alert alert-danger">' + elem.error + '</div>';
														} else {
															icon = "mdi mdi-check-circle-outline text-success mdi-24px";
														}
													}
													oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
													var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
													node += '<div class="card blog-widget">'
													node += '<div class="card-body">'
													node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
													node += '<p><strong style="cursor:pointer;" title="' + elem.title + '">' + elem.title.slice(0, 22) + '...</strong></p>';
													node += '<a href="' + elem.url + '" target="_blank"><p><strong title="' + elem.url + '">' + elem.url.slice(0, 25) + '...</strong></p></a>';
													if (error) {
														node += '<p class="my-0">' + error + '</p>'
													}
													node += '<div class="d-flex align-items-center" style="border-top: 1px solid #e6dbdb; padding-top: 5px;">'
													node += '<div class="read"><p class="my-2""><strong> <i class="mdi mdi-calendar-clock text-info mdi-24px"></i>' + elem.post_date + '</strong></p></div>'
													node += '</div>'
													node += '<div class="d-flex float-right">'
													node += '<a href="javascript:void(0);" class="h5 cursor-pointer mx-1 btn btn-sm btn-outline-success" id="publish_now" data-id="' + elem.id + '"  data-toggle="tooltip" title="Publish this post!">Publish</a>'
													node += '<a href="javascript:void(0);" class="h5 cursor-pointer delbulkone btn btn-sm btn-outline-danger" data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this post!" data-original-title="Delete">Delete</a>'
													node += '</div>'
													node += '</div>'
													node += '</div>'
													node += '</div>';
													$("#sceduled").append(node);
												});
												if (response.count == 20) {
													// load more button
													var load_more = "<div class='col-12 d-flex justify-content-center'>";
													load_more += "<button class='btn btn-outline-info load_more d-none'>Load More</button>";
													load_more += "</div>";
													$("#sceduled").append(load_more);
												}
												loading = false;
											}
										}
									});
								}
								// Shopify getting products 
								$(document).on("click", ".shopify-rss-button", function () {
									// Find the input field with the class "original-input" within the closest ancestor element with the class "to-be-cloned-container"
									// var inputField = $(this).closest('.to-be-cloned-container').find('.original-input');

									// Get the URL value from the input field
									// var rss_link_to_fetch_posts = inputField.val();

									// Determine the value of the "selected_type" based on the selected option in an element with the ID "pages"
									var selected_type = $('#pages').find('option:selected').data('type');
									var selected_name = $('#pages').find('option:selected').data('name');
									var rss_feed_engine_url;

									// Set the "rss_feed_engine_url" based on the "selected_type"
									if (selected_type == 'pinterest') {
										rss_feed_engine_url = 'pinterest_rss_feed_engine';
									} else if (selected_type == 'facebook') {
										rss_feed_engine_url = 'rss_feed_engine';
									} else if (selected_type == 'fb_group') {
										rss_feed_engine_url = 'fb_group_rss_feed_engine';
									} else {
										rss_feed_engine_url = 'ig_rss_feed_engine';
									}

									// Change the class of the closest ancestor element to 'begone'
									// var currentConatiner = $(this).closest('.to-be-cloned-container');

									// Show a confirmation dialog using the "swal" library
									swal({
										title: "Fetch Shopify store Products!",
										html: true, // Enable HTML in the text
										text: "Are you sure you want to fetch shopify products for<br><strong>" + selected_name + "</strong>?",
										type: "info",
										showCancelButton: true,
										confirmButtonColor: "#1e88e5",
										confirmButtonText: "Yes, Fetch!",
										closeOnConfirm: true // Automatically close on confirm
									}, function (confirmed) {
										// Check if the user confirmed the delete operation
										if (confirmed) {
											fetch_shopify_products(rss_feed_engine_url, selected_name);
										}
									});
								});

								// Define the "delete_rss" function
								var fetch_shopify_products = function (rss_feed_engine_url, selected_name) {
									// Perform the delete operation using an AJAX request
									var page = $("#pages").val();
									var time_slots = $(".chosen-select").val();
									var publisher = $("#loggeduserid").val();

									$("#preloader_ajax").show();
									$("#loader").show();

									var dataOBJ = {
										'publisher': publisher,
										'timeslots': time_slots,
										'page': page,
										'if_shopify_fetch': 'yes'
									};

									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
										data: dataOBJ,
										dataType: "json",
										success: function (response) {
											// Handle success, e.g., display a success message
											$("#preloader_ajax").hide();
											$("#loader").hide();
											$('#pages').trigger('change');

											if (response.produplicate == true) {
												swal({
													title: "No New Product!",
													text: "Attension! There are no New Products to fetch right now for " + selected_name + "!",
													type: "info",
													showConfirmButton: false,
													timer: 2500
												});
											} else {
												swal({
													title: "Success!",
													text: "Products has been fetched for " + selected_name + "!",
													type: "success",
													showConfirmButton: false,
													timer: 1500
												});
											}
										},
										error: function () {
											$("#preloader_ajax").hide();
											$("#loader").hide();
											// var response = JSON.parse(response.responseText);
											// var message = response.message;
											// var status = response.status;
											swal({
												title: "Error!",
												text: "Either your Credentails are wrong or Something Bad Happen",
												type: "error",
												showConfirmButton: false,
												timer: 2500
											});
											/*setTimeout(function() {
												  window.location.reload();
											  }, 4000);*/
										}
									});
								};
								//  Shopify End

								// Sitemap for getting 10 more posts code start
								$(document).on("click", ".fetch_ten_more", function () {
									// Find the input field with the class "original-input" within the closest ancestor element with the class "to-be-cloned-container"
									// var inputField = $(this).closest('.to-be-cloned-container').find('.original-input');

									// Find the input field with the class "to-be-cloned-input" within the closest ancestor element with the class "to-be-cloned-container"
									var inputField = $(this).closest('.to-be-cloned-container').find('.to-be-cloned-input');

									// Get the URL value from the input field
									var rss_link_to_fetch_posts = inputField.val();

									// Determine the value of the "selected_type" based on the selected option in an element with the ID "pages"
									var selected_type = $('#pages').find('option:selected').data('type');
									var rss_feed_engine_url;

									// Set the "rss_feed_engine_url" based on the "selected_type"
									if (selected_type == 'pinterest') {
										rss_feed_engine_url = 'pinterest_rss_feed_engine';
									} else if (selected_type == 'facebook') {
										rss_feed_engine_url = 'rss_feed_engine';
									} else if (selected_type == 'fb_group') {
										rss_feed_engine_url = 'fb_group_rss_feed_engine';
									} else if (selected_type == 'instagram') {
										rss_feed_engine_url = 'ig_rss_feed_engine';
									} else if (selected_type == 'tiktok') {
										rss_feed_engine_url = 'tiktok_rss_feed_engine';
									}

									// Change the class of the closest ancestor element to 'begone'
									var currentConatiner = $(this).closest('.to-be-cloned-container');

									// Show a confirmation dialog using the "swal" library
									swal({
										title: "Fetch more posts!",
										html: true, // Enable HTML in the text
										// text: "<strong>" + rss_link_to_fetch_posts + "</strong><br>Are you sure you want to fetch 20 more posts for this link?",
										text: rss_link_to_fetch_posts + "<br>Are you sure you want to fetch more posts for this link?",
										type: "info",
										showCancelButton: true,
										confirmButtonColor: "#1e88e5",
										confirmButtonText: "Yes, Fetch!",
										closeOnConfirm: true // Automatically close on confirm
									}, function (confirmed) {
										// Check if the user confirmed the delete operation
										if (confirmed) {
											fetch_ten_posts(rss_feed_engine_url, rss_link_to_fetch_posts, currentConatiner);
										}
									});
								});

								// Define the "delete_rss" function
								var fetch_ten_posts = function (rss_feed_engine_url, rss_link_to_fetch_posts, currentConatiner) {
									// Perform the delete operation using an AJAX request
									var page = $("#pages").val();
									var time_slots = $(".chosen-select").val();
									var rss_url = $("#rss_feed").val();
									var publisher = $("#loggeduserid").val();
									$("#preloader_ajax").show();
									$("#loader").show();
									var dataOBJ = {
										'sitemap_rss_link': rss_link_to_fetch_posts,
										'publisher': publisher,
										'timeslots': time_slots,
										'page': page,
										'if_rss_fetch': 'yes'
									};
									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
										data: dataOBJ,
										dataType: "json",
										success: function (response) {
											// Handle success, e.g., display a success message
											$("#preloader_ajax").hide();
											$("#loader").hide();
											$('#pages').trigger('change');
											if (response.status) {
												swal({
													title: "Success!",
													text: response.message,
													type: "success",
													showConfirmButton: false,
													timer: 1500
												});
												$('.fetch_ten_more').attr('disabled', true);
												setTimeout(function () {   //calls click event after a certain time
													console.log('1');
													$('#pages').trigger('change');
												}, 3000);
											}
											else {
												alertbox('Error', response.message, 'error');
											}
										},
										error: function (response) {
											// Handle errors if the AJAX request fails
											$("#preloader_ajax").hide();
											$("#loader").hide();
											var response = JSON.parse(response.responseText);
											var message = response.message;
											var status = response.status;
											var page_trigger = response.page_trigger;
											if (page_trigger) {
												$('#pages').trigger('change');
											}
											swal({
												title: "Error!",
												text: message,
												// text: "You need to store this link first |or| You can not fetch empty link posts",
												type: "error",
												showConfirmButton: false,
												timer: 4000
											});
											currentConatiner.find('.original-input').val('');
										}
									});
								};
								// Sitemap for getting 10 posts code end

								$(document).on("click", ".delete_rss", function () {
									// Find the input field with the class "original-input" within the closest ancestor element with the class "to-be-cloned-container"
									var inputField = $(this).closest('.to-be-cloned-container').find('.original-input');

									// Get the URL value from the input field
									var rss_link_to_delete = inputField.val();

									// Determine the value of the "selected_type" based on the selected option in an element with the ID "pages"
									var selected_type = $('#pages').find('option:selected').data('type');
									var rss_feed_engine_url;

									// Set the "rss_feed_engine_url" based on the "selected_type"
									if (selected_type == 'pinterest') {
										rss_feed_engine_url = 'pinterest_rss_feed_engine';
									} else if (selected_type == 'facebook') {
										rss_feed_engine_url = 'rss_feed_engine';
									} else if (selected_type == 'fb_group') {
										rss_feed_engine_url = 'fb_group_rss_feed_engine';
									} else if (selected_type == 'instagram') {
										rss_feed_engine_url = 'ig_rss_feed_engine';
									} else if (selected_type == 'tiktok') {
										rss_feed_engine_url = 'tiktok_rss_feed_engine';
									}

									// Change the class of the closest ancestor element to 'begone'
									var containerToRemove = $(this).closest('.to-be-cloned-container');
									var containersLeft = $('.to-be-cloned-container').length;
									var OriginalcontainersLength = $('.to-be-cloned-container').find('.original-input').length;

									// Show a confirmation dialog using the "swal" library
									swal({
										title: "Delete this RSS link?",
										html: true, // Enable HTML in the text
										text: "<strong>" + rss_link_to_delete + "</strong><br>Are you sure you want to delete the RSS link for this page?",
										type: "warning",
										showCancelButton: true,
										confirmButtonColor: "#DD6B55",
										confirmButtonText: "Yes, delete!",
										closeOnConfirm: true // Automatically close on confirm
									}, function (confirmed) {
										// Check if the user confirmed the delete operation
										if (confirmed) {
											delete_rss(rss_feed_engine_url, rss_link_to_delete, containerToRemove, containersLeft, OriginalcontainersLength);
										}
									});
								});

								// Define the "delete_rss" function
								var delete_rss = function (rss_feed_engine_url, rss_link_to_delete, containerToRemove, containersLeft, OriginalcontainersLength) {
									// Perform the delete operation using an AJAX request
									var page = $("#pages").val();
									var time_slots = $(".chosen-select").val();
									var rss_url = $("#rss_feed").val();
									var publisher = $("#loggeduserid").val();

									var dataOBJ = {
										'rss_link': rss_link_to_delete,
										'publisher': publisher,
										'timeslots': time_slots,
										'page': page,
										'if_rss_delete': 'yes'
									};

									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
										data: dataOBJ,
										dataType: "json",
										success: function (response) {
											// Handle success, e.g., display a success message
											if (containersLeft > 1) {
												if (OriginalcontainersLength > 1) {
													containerToRemove.remove();
												}
												else {
													containerToRemove.find('.original-input').val('');
													containerToRemove.find('.original-input').prop('disabled', false);
												}
												// If more than one container, remove it
											} else {
												// If only one container left, clear the input value
												containerToRemove.find('.original-input').val('');
												containerToRemove.find('.original-input').prop('disabled', false);
											}
											swal({
												title: "Success!",
												text: "Rss has been deleted from your page!",
												type: "success",
												showConfirmButton: false,
												timer: 1500
											});
										},
										error: function () {
											// Handle errors if the AJAX request fails
											swal({
												title: "Error!",
												text: "You need to store this link first |or| You can not delete empty input",
												type: "error",
												showConfirmButton: false,
												timer: 3500
											});
											containerToRemove.find('.original-input').val('');
										}
									});
								};

								$(document).ready(function () {
									// $("#submit_rss").click(function() {
									$(document).on("click", "#submit_rss", function () {
										var rss_urls = [];
										// Iterate over the cloned input fields and push their values to the array
										$(".to-be-cloned-input").each(function () {
											var cloned_rss_url = $(this).val();
											rss_urls.push(cloned_rss_url);
										});
										var selected_type = $('#pages').find('option:selected').data('type');
										if (selected_type == 'pinterest') {
											rss_feed_engine_url = 'pinterest_rss_feed_engine';
										} else if (selected_type == 'facebook') {
											rss_feed_engine_url = 'rss_feed_engine';
										} else if (selected_type == 'fb_group') {
											rss_feed_engine_url = 'fb_group_rss_feed_engine';
										} else if (selected_type == 'instagram') {
											rss_feed_engine_url = 'ig_rss_feed_engine'
										} else if (selected_type == 'tiktok') {
											rss_feed_engine_url = 'tiktok_rss_feed_engine';
										}
										submit_rss(rss_feed_engine_url, rss_urls);
									});
								});
								var submit_rss = function (rss_feed_engine_url, rss_urls) {
									var chosen = $(".chosen-select").val().length;
									var page = $("#pages").val();
									var time_slots = $(".chosen-select").val();
									var rss_url = $("#rss_feed").val();
									var publisher = $("#loggeduserid").val();
									if (page == "") {
										alertbox("Error", "Please Select Page first , and try again", "error");
										return false;
									}
									if (time_slots == "") {
										alertbox("Error", "Please Select Time Slots first , and try again", "error");
										return false;
									}
									/*if (rss_urls === ",") {
										alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
										return false;
									}*/
									if (rss_urls.length === 1 && rss_url === "") {
										alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
										return false;
									}
									// if (rss_url == "") {
									// 	alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
									// 	return false;
									// }
									if (page != "" && time_slots != "") {
										if (rss_url != "") {
											$("#preloader_ajax").show();
											// $("#submit_rss").attr("disabled", true);
											$("#loader").show();
											var dataOBJ = {
												'rss_link': rss_urls,
												'publisher': publisher,
												'timeslots': time_slots,
												'page': page
											}
											$.ajax({
												type: "POST",
												url: "<?php echo SITEURL; ?>" + rss_feed_engine_url,
												data: dataOBJ,
												dataType: "json",
												success: function (response) {
													$("#preloader_ajax").hide();
													$("#loader").hide();
													$("#submit_rss").attr("disabled", false);

													var message = response.message;
													// if (response.strong) {
													//     message = '<b>' + message + '</b>';
													// }

													if (response.status) {
														$('#pages').trigger('change');
														swal({
															title: "Success!",
															text: message,
															type: "success",
															showConfirmButton: true,
															confirmButtonColor: '#28a745',
															timer: 2500
														});
													} else {
														swal({
															title: "Error!",
															text: message,
															type: "error",
															showConfirmButton: true,
															confirmButtonColor: '#f27474',
															timer: 4000
														});
													}
												},
												error: function (response) {
													console.log(response.status);
													console.log(response.statusText); // Log the status text for more details
													console.log(response.responseText);
													var response = JSON.parse(response.responseText);
													var message = response.message;
													var status = response.status;
													var is_alert = response.is_alert;

													/*if (response.strong) {
														$('#pages').trigger('change');
													}*/
													// console.log(status);
													$("#preloader_ajax").hide();
													$("#loader").hide();
													$('#pages').trigger('change');
													if (status == true) {
														swal({
															title: "Success!",
															text: message,
															type: "success",
															showConfirmButton: true,
															confirmButtonColor: '#28a745',
															timer: 2500
														});
													} else if (status == false && is_alert == false) {
														swal({
															title: "Error!",
															text: message,
															type: "error",
															showConfirmButton: true,
															confirmButtonColor: '#f27474',
															timer: 4000
														});
													} else if (status == false && is_alert == true) {
														swal({
															title: "Alert!",
															text: message,
															type: "warning",
															showConfirmButton: true,
															confirmButtonColor: '#f8c486',
															timer: 4000
														});
													} else {
														swal({
															title: "Error!",
															text: "Your provided link has not valid RSS feed |or| Something went wrong",
															type: "error",
															showConfirmButton: true,
															confirmButtonColor: '#f27474',
															timer: 4000
														});
													}
												}
											});
										}
										else {
											alertbox("Error", "First Input Field can not be empty", "error");
										}
									}
								};
								$(".chosen-select").change(function () {
									var selected_type = $('#pages').find('option:selected').data('type');
									if (selected_type == 'pinterest') {
										update_timeslots_url = 'update_board_timeslots_rss';
									} else if (selected_type == 'facebook') {
										update_timeslots_url = 'update_page_timeslots_rss';
									} else if (selected_type == 'fb_group') {
										update_timeslots_url = 'update_fb_group_timeslots_rss'
									} else if (selected_type == 'instagram') {
										update_timeslots_url = 'update_ig_timeslots_rss'
									} else if (selected_type == 'tiktok') {
										update_timeslots_url = 'update_tiktok_timeslots_rss'
									}
									update_timeslots_rss(update_timeslots_url);
								});
								var update_timeslots_rss = function (update_timeslots_url) {
									$('#preloader_ajax').show();
									var chosen = $(".chosen-select").val().length;
									var page = $("#pages").val();
									var time_slots = $(".chosen-select").val();
									if (page != "") {
										var dataOBJ = {
											'time_slots': time_slots,
											'page': page
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + update_timeslots_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												$('#preloader_ajax').hide();
												$('#pages').trigger('change');
											},
											error: function () { }
										});
									}
								};
								$(".chosen-select").chosen({
									no_results_text: "Oops, nothing found!"
								});


								$(".deleteall").click(function () {
									var error = $(this).data('error');
									var selected_type = $('#pages').find('option:selected').data('type');
									// console.log(type);
									if (selected_type == 'pinterest') {
										delete_rss_all_url = 'delete_pinterest_rss_post_all';
									} else if (selected_type == 'facebook') {
										delete_rss_all_url = 'deletersspostall';
									} else if (selected_type == 'fb_group') {
										delete_rss_all_url = 'delete_fb_group_rss_post_all';
									} else if(selected_type == 'instagram') {
										delete_rss_all_url = 'delete_ig_rss_post_all';
									} else if(selected_type == 'tiktok') {
										delete_rss_all_url = 'delete_tiktok_rss_post_all';
									}
									delete_all(delete_rss_all_url, error);
								});
								var delete_all = function (delete_rss_all_url, error) {

									var page = $("#pages").val();
									var activeDivId = $(".automation-socials.active").attr("id");
									if (activeDivId == 'rss') {
										var maintitle = 'Delete ALL Posts???';
										var maintext = 'You will not be able to recover these posts again!';
										var deletetype = 'rss';
									}
									else if (activeDivId == 'shopify') {
										var maintitle = 'Delete ALL Products???';
										var maintext = 'You will not be able to recover these products again!';
										var deletetype = 'shopify';
									}

									swal({
										title: maintitle,
										text: maintext,
										type: "warning",
										showCancelButton: true,
										confirmButtonColor: "#DD6B55",
										confirmButtonText: "Yes, delete ALL!",
										closeOnConfirm: false
									}, function () {
										$("#loader").show();
										var dataOBJ = {
											'page': page,
											'error': error,
											'type': deletetype
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + delete_rss_all_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												$(".deleteall").hide();
												$(".refresh_timeslots").hide();
												$(".shuffle").hide();
												$("#loader").hide();
												if (response.status) {
													$('#pages').trigger('change');
													if (error == 'all') {
														if (deletetype == 'rss') {
															var text = "Your scheduled posts Removed Successfully!";
														}
														else if (deletetype == 'shopify') {
															var text = "Your scheduled products Removed Successfully!";
														}
													} else {
														if (deletetype == 'rss') {
															var text = "Your rejected posts Removed Successfully!";
														}
														else if (deletetype == 'shopify') {
															var text = "Your rejected products Removed Successfully!";
														}
													}
													swal({
														title: "Deleted!",
														text: text,
														type: "success",
														showConfirmButton: false,
														timer: 1500
													});
												}
											},
											error: function () {
												$("#loader").hide();
												swal("Error", "Nothing Has been deleted, please try again", "error");
											}
										});
									});
								};

								$(document).on('click', '.shuffle', function () {
									var selected_type = $('#pages').find('option:selected').data('type');
									if (selected_type == 'pinterest') {
										shuffle_rss_posts_url = 'shuffle_pinterest_rss_post_all';
									} else if (selected_type == 'facebook') {
										shuffle_rss_posts_url = 'shufflersspostall';
									} else if (selected_type == 'fb_group') {
										shuffle_rss_posts_url = 'shuffle_fb_group_rss_post_all'
									} else {
										shuffle_rss_posts_url = 'shuffle_ig_rss_post_all'
									}
									shuffle_rss_posts(shuffle_rss_posts_url);
								});

								$(document).on('click', '.refresh_timeslots', function () {
									refresh_rss_posts();
								});

								var refresh_rss_posts = function () {
									var chosen = $(".chosen-select").val().length;
									var page = $("#pages").val();
									var time_slots = $(".chosen-select").val();
									var selected_type = $('#pages').find('option:selected').data('type');
									swal({
										title: "Refresh all posts?",
										text: "Are you sure you want to refresh all posts!",
										type: "warning",
										showCancelButton: true,
										confirmButtonColor: "#DD6B55",
										confirmButtonText: "Yes, Refresh All!",
										closeOnConfirm: false
									}, function () {
										$('#preloader_ajax').show();
										var dataOBJ = {
											'page': page,
											'timeslots': time_slots,
											'selected_type': selected_type
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>refresh_rss_posts",
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												$('#preloader_ajax').hide();
												if (response.status) {
													swal({
														title: "Success!",
														text: response.data,
														type: "success",
														showConfirmButton: false,
														timer: 2500
													});
													setTimeout(function () {
														$('#pages').trigger('change');
													}, 2500);
												}
											},
											error: function () {
												$('#preloader_ajax').hide();
												swal("Error", "Nothing Has been changed, please try again", "error");
											}
										});
									});
								}

								var shuffle_rss_posts = function (shuffle_rss_posts_url) {
									var page = $("#pages").val();
									swal({
										title: "Shuffle All Posts???",
										text: "You will not be able to recover order of these posts again!",
										type: "warning",
										showCancelButton: true,
										confirmButtonColor: "#DD6B55",
										confirmButtonText: "Yes, Shuffle All!",
										closeOnConfirm: false
									}, function () {
										$("#loader").show();
										var dataOBJ = {
											'page': page
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + shuffle_rss_posts_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												$("#loader").hide();
												$('#pages').trigger('change');
												if (response.status) {
													swal({
														title: "Success!",
														text: "Your scheduled posts are shuffled in random order Successfully!",
														type: "success",
														showConfirmButton: false,
														timer: 1500
													});
												}
											},
											error: function () {
												$("#loader").hide();
												swal("Error", "Nothing Has been changed, please try again", "error");
											}
										});
									});
								};
								$(document).on('click', '.delbulkone', function () {
									var id = $(this).data('id');

									var selected_type = $('#pages').find('option:selected').data('type');
									if (selected_type == 'pinterest') {
										delete_rss_post_url = 'delete_pinterest_rss_post';
									} else if (selected_type == 'facebook') {
										delete_rss_post_url = 'deletersspost';
									} else if (selected_type == 'fb_group') {
										delete_rss_post_url = 'delete_fb_group_rss_post';
									} else {
										delete_rss_post_url = 'delete_ig_rss_post'
									}
									// $('#preloader_ajax').show();
									del_bulk_one(delete_rss_post_url, id);
								});
								var del_bulk_one = function (delete_rss_post_url, id) {
									row = $("#card_" + id);
									row.remove();
									var dataOBJ = {
										'id': id
									}
									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + delete_rss_post_url,
										data: dataOBJ,
										dataType: "json",
										success: function (response) {
											// $('#preloader_ajax').hide();
											if (response.status) {
												var icon = "mdi mdi-calendar-clock text-info mdi-24px"
												var error = "";
												var elem = response.data;
												// if (elem.posted == 1) {
												// 	if (elem.error) {
												// 		icon = "mdi mdi-alert-circle-outline text-danger mdi-24px";
												// 		error = '<div class="alert alert-danger">' + elem.error + '</div>';
												// 	} else {
												// 		icon = "mdi mdi-check-circle-outline text-success mdi-24px";
												// 	}
												// }
												// oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
												// var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
												// node += '<div class="card blog-widget">'
												// node += '<div class="card-body">'
												// node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="min-height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
												// node += '<p class="my-2" style="height:40px;overflow: hidden;" ><strong> <i class="' + icon + '"></i> ' + elem.post_date + '</strong></p>'
												// node += '<p class="my-0">' + error + '</p>'
												// node += '<div class="d-flex align-items-center">'
												// node += '<div class="read"><a href="' + elem.url + '" target="_blank" class="link font-medium">Read More</a></div>'
												// node += '<div class="ml-auto">'
												// node += '<a href="javascript:void(0);" class="link h5  cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this image" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>'
												// node += '</div>'
												// node += '</div>'
												// node += '</div>'
												// node += '</div>'
												// node += '</div>';
												// $('#card_' + elem.id).remove();
												// row.replaceWith(node);
												// $('#pages').trigger('change');
												alertbox('Success', 'Your scheduled post Removed Successfully!', 'success');
											}
										},
										error: function () {
											$('#preloader_ajax').hide();
											alertbox('Error', 'Nothing Has been deleted, please try again', 'error');
										}
									});
								}
							});
						</script>
						<script>
							$(document).ready(function () {
								$(document).on('click', '#publish_now', function () {
									var id = $(this).data('id');
									var selected_type = $('#pages').find('option:selected').data('type');
									var page_id = $('#pages').find('option:selected').val();
									if (selected_type == 'facebook') {
										var publish_url = 'publishNowFacebookPost'
									}
									else if (selected_type == 'pinterest') {
										var publish_url = 'publishNowPinterestPost'
									}
									swal({
										title: "Publish Now!",
										html: true,
										text: "Are you sure you want to Publish this post Now?",
										type: "info",
										showCancelButton: true,
										confirmButtonColor: "#1e88e5",
										confirmButtonText: "Publish Now!",
										closeOnConfirm: true // Automatically close on confirm
									}, function (confirmed) {
										// Check if the user confirmed the delete operation
										if (confirmed) {
											publishNow(id, page_id, publish_url);
										}
									});
								});
								var publishNow = function (post_id, page_id, url) {
									$('#preloader_ajax').show();
									$.ajax({
										type: "POST",
										url: "<?php SITEURL ?>" + url,
										data: {
											'id': post_id,
											'page_id': page_id,
										},
										success: function (response) {
											$('#preloader_ajax').hide();
											if (response.status) {
												row = $("#card_" + post_id);
												row.remove();
												alertbox('Success', response.data, 'success');
											}
											else {
												alertbox('Error', response.data, 'error');
											}
										}
									});
								}
							});
						</script>
						<script>
							$(document).ready(function () {
								$("#pages").on("change", function () {
									var selectedOption = $(this).find("option:selected");
									var selectedType = selectedOption.data("type");
									// Show the button if an option with data-type is selected
									if (selectedType) {
										$("#showButton").show();
										$("#shopifyRssButton").show();
									} else {
										$("#showButton").hide();
										$("#shopifyRssButton").hide();
									}
								});
							});
						</script>
						<script>
							$(document).ready(function () {
								var isCloning = false;
								// var allowedClones = (<?php echo $package_feature_user_quota - $package_feature_user_limit; ?>) - 1;
								var allowedClones = 1000;
								var allowedClonesInitial = allowedClones;

								$('#pages').change(function () {
									setTimeout(function () {
										var originalInputs = $('.original-input');
										if (originalInputs.length === 1 && originalInputs.val() === "") {
											originalInputs.prop('disabled', false);
											originalInputs.css({
												'color': 'black',
												'cursor': 'text',
												'font-weight': '500'
											});
										} else {
											originalInputs.prop('disabled', true);
											// Apply CSS rules to .original-input
											originalInputs.css({
												'color': 'black',
												'cursor': 'text',
												'font-weight': '800'
											});
										}
									}, 500);
								});

								// Add a click event handler to elements with class "duplicate-button"
								// $(".duplicate-button").click(function() {
								$(document).on("click", ".duplicate-button", function () {
									if (isCloning || allowedClones <= 0) {
										alertbox("Error", 'You cannot make more RSS fields than your bulk upload limit = ' + (allowedClonesInitial + 1) + '. Now 0 remaining', "error");
										return;
									}

									isCloning = true;

									// Clone the div with class "to-be-cloned-container" and its contents
									var originalContainer = $(this).closest(".form-group.col-md-4").find(".to-be-cloned-container:last");
									var clonedContainer = originalContainer.clone();

									// Remove the "original-input" class from the cloned input field
									clonedContainer.find(".to-be-cloned-input").removeClass("original-input");
									clonedContainer.find(".to-be-cloned-input").removeAttr("disabled");

									clonedContainer.find("button.on_off").removeClass("fa-trash-o delete_rss");
									clonedContainer.find("button.on_off").addClass("fa-remove remove-clone");

									clonedContainer.find(".last-run-small").html('<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data');

									// Clear the input field in the cloned container
									var clonedInput = clonedContainer.find(".to-be-cloned-input");
									clonedInput.val("");

									// Display the element with class "delete_rss"
									clonedContainer.find(".delete_rss").css("display", "block");

									// Insert the cloned container below the original one
									originalContainer.after(clonedContainer);

									allowedClones--; // Decrease the remaining allowed clones
									isCloning = false;
								});

								// Add a click event handler to elements with class "delete_rss"
								$(document).on("click", ".remove-clone", function () {
									// Check if it's a cloned element (not the original)
									var isCloned = !$(this).closest(".to-be-cloned-container").find(".original-input").length;

									if (isCloned) {
										// Remove the relative clone
										var relativeClone = $(this).closest(".to-be-cloned-container");
										relativeClone.remove();
										// Increment the allowedClones count
										allowedClones++;
									}
								});
							});
						</script>
						<script>
							function showImage(imageUrl) {
								$('#popupImage').attr('src', imageUrl);
								$('#imagePopupOverlay').fadeIn();
							}

							function closeImagePopup() {
								$('#imagePopupOverlay').fadeOut();
							}
							$(document).ready(function () {
								$("#ShopifyCredentials").click(function (e) {
									// Prevent the default form submission behavior
									e.preventDefault();

									var apiKey = $("#apiKey").val();
									var apiSecretKey = $("#apiSecretKey").val();
									var adminApiAccessToken = $("#adminApiAccessToken").val();
									var storeName = $("#storeName").val();

									// Validate if any field is empty
									if (!apiKey || !apiSecretKey || !adminApiAccessToken || !storeName) {
										// Delay the alert to allow SweetAlert to display first
										swal({
											title: "Empty Field!",
											text: 'Please Fill all the fields first',
											type: "warning",
											showConfirmButton: false,
											timer: 1500
										});
										return; // Prevent further execution if fields are empty
									}

									// AJAX request
									store_shopify_credntials = 'store_shopify_credntials';
									$.ajax({
										type: "POST",
										url: "<?php echo SITEURL; ?>" + store_shopify_credntials,
										data: {
											apiKey: apiKey,
											apiSecretKey: apiSecretKey,
											adminApiAccessToken: adminApiAccessToken,
											storeName: storeName
										},
										dataType: "json",
										success: function (response) {
											swal({
												title: "Account Connected!",
												text: 'You Are All Set To Go',
												type: "success",
												showConfirmButton: false,
												timer: 2500
											});
											$('#staticBackdrop').modal('hide');
											window.location.reload();
										},
										error: function (response) {
											swal("Error", "Authentication failed. Please provide accurate information.", "error");
										}
									});
								});
							});

						</script>
						<script>
							document.addEventListener("DOMContentLoaded", function () {
								var socials = document.querySelectorAll('.automation-socials');
								var socialActiveColor = document.querySelector('.social-active-color');

								var rssdiv = document.getElementById("step-3-rss");
								var shpoifydiv = document.getElementById("step-3-shopify");
								var youtubediv = document.getElementById("step-3-youtube");

								// Set default border color of .social-active-color
								if (socialActiveColor) {
									socialActiveColor.style.borderColor = '#f78422';
								}

								var shopify_adminApiAccessToken = "<?php echo $user[0]->shopify_adminApiAccessToken; ?>";
								// Attach click event to each social link
								socials.forEach(function (social) {
									social.addEventListener('click', function () {
										// Remove 'active' class from all elements
										socials.forEach(function (item) {
											item.classList.remove('active');
										});
										// Add 'active' class to the clicked element
										this.classList.add('active');
										// Set border color of .social-active-color based on the clicked element
										if (this.id === 'rss') {
											socialActiveColor.style.borderColor = '#f78422';
											rssdiv.style.display = "block";
											shpoifydiv.style.display = "none";
											youtubediv.style.display = "none";

											document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function (elem) {
												elem.disabled = false;
											});
											document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function (elem) {
												elem.disabled = false;
											});
											document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function (elem) {
												elem.disabled = false;
											});
											$('#pages').trigger('change');
										} else if (this.id === 'shopify') {
											socialActiveColor.style.borderColor = '#94be46';
											rssdiv.style.display = "none";
											shpoifydiv.style.display = "block";
											youtubediv.style.display = "none";

											// Check if shopify_adminApiAccessToken is empty
											if (shopify_adminApiAccessToken === '') {
												// If it's empty, disable Step 1 and Step 2
												document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function (elem) {
													elem.disabled = true;
												});
												document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function (elem) {
													elem.disabled = true;
												});
												document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function (elem) {
													elem.disabled = true;
												});
											}
											else {
												document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function (elem) {
													elem.disabled = false;
												});
												document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function (elem) {
													elem.disabled = false;
												});
												document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function (elem) {
													elem.disabled = false;
												});
												$('#pages').trigger('change');
											}
										} else if (this.id === 'youtube') {
											socialActiveColor.style.borderColor = '#ff0000';
											rssdiv.style.display = "none";
											shpoifydiv.style.display = "none";
											youtubediv.style.display = "block";

											document.getElementById("step1").querySelectorAll("select, input, button, option").forEach(function (elem) {
												elem.disabled = true;
											});
											document.getElementById("step2").querySelectorAll("select, input, button, option").forEach(function (elem) {
												elem.disabled = true;
											});
											document.getElementById("step3").querySelectorAll("select, input, button, option").forEach(function (elem) {
												elem.disabled = true;
											});
											$('#pages').trigger('change');
										}
									});
								});
							});
						</script>
						<script>
							$(document).ready(function () {
								$('#pages').trigger('change');
								$(document).on('mouseover', '.original-input', function () {
									$(this).attr('disabled', false);
								});
								$(document).on('mouseleave', '.original-input', function () {
									$(this).attr('disabled', true);
								});
							});
						</script>
						<script>
							$(document).ready(function () {
								$('.rss_posts_tab_scheduled').on('click', function () {
									$(this).addClass('btn-info');
									$(this).removeClass('btn-secondary');
									$('.rss_posts_tab_published').addClass('btn-secondary');
									$('.rss_posts_tab_published').removeClass('btn-info');
									$('.deleteall, .shuffle, .refresh_timeslots').attr('disabled', false);
									$('#pages').trigger('change');
								});
								$('.rss_posts_tab_published').on('click', function () {
									$(this).addClass('btn-info');
									$(this).removeClass('btn-secondary');
									$('.rss_posts_tab_scheduled').addClass('btn-secondary');
									$('.rss_posts_tab_scheduled').removeClass('btn-info');
									$('.deleteall, .shuffle, .refresh_timeslots').attr('disabled', true);
									// get published rss posts
									var text = $('#pages').find('option:selected').text();
									var selected_type = $('#pages').find('option:selected').data('type');
									var schedule_url = '';
									if (selected_type == 'pinterest') {
										schedule_url = 'get_pinterest_rssspublished';
									} else if (selected_type == 'facebook') {
										schedule_url = 'getrssspublished';
									} else if (selected_type == 'fb_group') {
										schedule_url = 'get_fb_group_rssspublished';
									} else {
										schedule_url = 'get_ig_rssspublished';
									}
									getpublishedrss(schedule_url);
								});

								var getpublishedrss = function (schedule_url) {
									$(".deleteall").hide();
									$(".refresh_timeslots").hide();
									$(".shuffle").hide();
									var page = $("#pages").val();
									if (page != "") {
										// $('#preloader_ajax').show();
										// $("#loader").show();
										//$("#pagenamedisplay").html("| " + $(this).find("option:selected").text());
										$("#sceduled").html("");

										// This line checks if div is Rss, Shopify or Youtube then will get the same data from database
										var activeDivId = $(".automation-socials.active").attr("id");

										var dataOBJ = {
											'id': page,
											'activedivid': activeDivId
										}
										$.ajax({
											type: "POST",
											url: "<?php echo SITEURL; ?>" + schedule_url,
											data: dataOBJ,
											dataType: "json",
											success: function (response) {
												// $('#preloader_ajax').hide();
												function splitData(data) {
													if (typeof data === "string") {
														return data.split(',');
													} else if (Array.isArray(data)) {
														return data;
													} else {
														return [];
													}
												}

												var lastRunShopify = response.last_shopify_run;
												// Last Run Shopify //
												if (lastRunShopify === '' || lastRunShopify === null) {
													$(".last-run-shopify-small").html('<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data');
												} else {
													$(".last-run-shopify-small").html('<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + lastRunShopify);
												}
												// End //

												var originalContainer = document.querySelector(".to-be-cloned-container");
												var retrievedData = response.rss_link;
												// Check if retrievedData is not empty
												if (retrievedData.length > 0) {
													// Clear the existing cloned containers except the original one
													var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
													for (var i = 1; i < clonedContainers.length; i++) {
														clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
													}

													// Set the value of the original input field and corresponding last run time
													originalContainer.querySelector(".original-input").value = retrievedData[0].link;

													if (retrievedData[0].last_run === '' || retrievedData[0].last_run === null) {
														originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
													} else {
														originalContainer.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[0].last_run;
													}
													// Clone and append additional input field containers for the remaining URLs and last run times
													for (var i = 1; i < retrievedData.length; i++) {
														var clone = originalContainer.cloneNode(true);
														clone.querySelector(".original-input").value = retrievedData[i].link;
														if (retrievedData[i].last_run === '' || retrievedData[i].last_run === null) {
															clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-remove text-danger"></i>&nbsp;Last Run : No Data';
														} else {
															clone.querySelector(".last-run-small").innerHTML = '<i class="fa fa-check text-success"></i>&nbsp;Last Run : ' + retrievedData[i].last_run;
														}
														originalContainer.parentNode.insertBefore(clone, originalContainer.nextSibling);
													}
												}

												// $("#loader").hide();

												if (activeDivId == 'rss') {
													$(".on_off").show();
													$(".forshopify").hide();
													$(".foryoutube").hide();
												} else if (activeDivId == 'shopify') {
													$(".on_off").hide();
													$(".forshopify").show();
													$(".foryoutube").hide();
												} else if (activeDivId == 'youtube') {
													$(".on_off").hide();
													$(".forshopify").hide();
													$(".foryoutube").show();
												}
												$(".fetch_ten_more").show();

												if (response.rss_active === "1") {
													$(".rssposting").prop("checked", true);
												} else {
													$(".rssposting").prop("checked", false);
												}

												if (response.shopify_active === "1") {
													$(".shopifyposting").prop("checked", true);
												} else {
													$(".shopifyposting").prop("checked", false);
												}


												if (response.time_slots) {
													$('#timeslots').val($.parseJSON(response.time_slots)).trigger("chosen:updated");
												} else {
													$('#timeslots').val("").trigger("chosen:updated");
												}
												if (response.status) {
													if (response.data) {
														$(".deleteall").show();
														$(".refresh_timeslots").show();
														$(".shuffle").show();
													}
													$.each(response.data, function (index, elem) {
														var icon = "mdi mdi-calendar-clock text-info mdi-24px"
														var error = "";
														oncl = "window.open(" + "'" + elem.url + "'" + "," + "'_blank')";
														var node = '<div class="col-lg-3 col-md-6" id="card_' + elem.id + '">'
														node += '<div class="card blog-widget">'
														node += '<div class="card-body">'
														node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
														node += '<p><strong style="cursor:pointer;" title="' + elem.title + '">' + elem.title.slice(0, 22) + '...</strong></p>';
														node += '<a href="' + elem.url + '" target="_blank"><p><strong title="' + elem.url + '">' + elem.url.slice(0, 25) + '...</strong></p></a>';
														if (error) {
															node += '<p class="my-0">' + error + '</p>'
														}
														node += '<div class="d-flex align-items-center" style="border-top: 1px solid #e6dbdb; padding-top: 5px;">'
														node += '<div class="read"><p class="my-2""><strong> <i class="mdi mdi-calendar-clock text-info mdi-24px"></i>' + elem.post_date + '</strong></p></div>'
														node += '</div>'
														node += '</div>'
														node += '</div>'
														node += '</div>';
														$("#sceduled").append(node);
													});
												}
											},
											error: function () {
												$("#sceduled").html("");
												// $("#loader").hide();
											}
										});
									} else {
										// $(".on_off").hide();
										// $(".fetch_ten_more").hide();
										$('#timeslots').val("").trigger("chosen:updated");
										$("#sceduled").html("");

										// Set the 'rss_feed' input field to an empty value
										$('#rss_feed').val("");

										// Remove any additional cloned containers
										var clonedContainers = document.querySelectorAll(".to-be-cloned-container");
										for (var i = 1; i < clonedContainers.length; i++) {
											clonedContainers[i].parentNode.removeChild(clonedContainers[i]);
										}
									}
								};
								$(window).on('scroll load', function () {
									if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) { // Adjust threshold as needed
										$('.load_more').trigger('click');
									}
								});

							});
							function get_running_rss_status() {
								var type = $('#pages').find('option:selected').data('type');
								var page_id = $("#pages").val();
								$.ajax({
									type: "POST",
									url: "<?php echo SITEURL . 'get_running_rss_status'; ?>",
									data: {
										'page_id': page_id,
										'type': type
									},
									success: function (response) {
										if (response.status) {
											$('.fetch_ten_more').attr('disabled', false);
										}
										else {
											$('.fetch_ten_more').attr('disabled', true);
										}
									}
								});
							}
							setInterval(function () {
								get_running_rss_status();
							}, 3000);
						</script>