
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
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
              <div class="row">
                <div class="col-12">
                <?php
                        $upr  =  user_pr();
                        $account = $upr['ptu']->active;
                ?>

                  <div class="card simple-card">
                    <div class="card-body">
                      <h2 class="text-center mt-2 m-b-0"> RSS to facebook posts<small><label class="label label-default text-success"> Experimental <i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Our Rss Auto Feed feature is in beta version, if you find any bug please email it on info@adublisher.com"></i> </small></label></h2>
                      <p class="text-center text-muted m-b-0">You can use the this service to auto-post an RSS feed to your Facebook Page.<br> This is a huge time saver if you like to consistently post blog articles, news updates, and other things to Facebook.</p>
                     
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
                        <!-- Column -->
                        <?php 
                         if($account == '1'){
                            if(sizeof($user_pages) > 0){
                         ?>
                        <div class="card my-2">
                            <div class="card-body">
                                <div class="row my-2">
                                  <div class="form-group col-md-4">

                                      <label><b>Step 1-</b>  Select Page: <i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="First step is to select page, your page must have published status on facebook."></i>
                                      </label>
                                        <input type="hidden" id="title" value="This is the test Tile">
                                      <select id="pages" class=" form-control" >
                                          <option value="">Select Page</option>
                                         
                                          <?php 
                                          foreach($user_pages as $page){
                                          ?>
                                          
                                          <option value="<?=$page->id;?>"><?=$page->page_name;?></option>
                                     
                                          <?php
                                              
                                          }
                                
                                          ?>
                                      </select> 
                                       
                                       
                                     </div> 
                                  <div class="form-group col-md-4">
                                      <label><b>Step 2-</b>  Select hours:<i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Second step is to select time slots, You can max select 24 time slots per day. Select Atleast one time slot to enable RSS FEED input box."></i>
                                      </label>
                                    
                                      <select id="timeslots" multiple data-placeholder="Select Hours to post..."  class="chosen-select form-control">
                                      <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                      <?php endfor ?>
                                      </select>
                                      <small><i class="fa fa-check text-success"></i> Time slots will automatically save upon changing.</small>
                                  </div>
                                  <div class="form-group col-md-4">
                                          <label><b>Step 3-</b>  Feed URL: <i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Third step is to input Rss Feed Link"></i>
                                          </label>
                                          <div class="input-group">
                                              <input type="url" id="rss_feed" class="form-control" placeholder="Please enter url...">
                                              <div class="input-group-append">
                                                  <button class="btn btn-info" id="submit_rss" type="button">Submit URL!</button>
                                              </div>
                                          </div>
                                        <div class="row py-2 on_off" style="display: none;">
                                          <div class="col-md-7 pl-3"> <small> Delete rss if you don't need anymore</small> </div>
                                          <div class="col-md-5">
                                            <i class="fa fa-trash-o text-danger pointer delete_rss"></i>
                                          </div>
                                        </div>
                                        <div class="row on_off" style="display: none;">
                                          <div class="col-md-7 pl-3"> <small> Turn Rss posting ON and OFF</small> </div>
                                          <div class="col-md-5">
                                              <div class="switch">
                                                <label>OFF<input type="checkbox"  class="rssposting" ><span class="lever switch-col-light-blue"></span>ON</label>
                                              </div>
                                          </div>
                                        </div>
                                         
                                        
                                  </div>
                              </div>
                        </div>
                        <!-- Column -->
                    </div>
                        
                         <div class="card ">
                            <div class="card-header ">
                               
                                 <div class="row">
                                    <div class="col-md-12 m-t-10 text-left">
                                        <b>Manage Scheduled Posts </b> <span id="pagenamedisplay"></span>: <i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Here you can manage the existing posts on pages. Select Page to load posts"></i>
                                       
                                        <button class="btn btn-danger deleteall m-l-5 btn-sm pull-right mr-3" style="display: none;" data-error="all" ><i class="fa fa-trash pointer" ></i> Delete All</button>
                                        <button class="btn btn-danger deleteall m-l-5 btn-sm pull-right mr-3" style="display: none;" data-error="error"><i class="fa fa-trash pointer" ></i> Delete Rejected</button>
                                        <button class="btn btn-success shuffle m-l-5 btn-sm pull-right mr-3" style="display: none;" ><i class="fa fa-refresh pointer" ></i> Shuffle</button>
                                    </div>
                                </div>
                             </div>
                               <div class="card-body b-t" >
                                   <div class="col-md-12 row el-element-overlay" id="sceduled">
                                   </div>
                             </div>
                         </div>
                         <?php
                            }else{
                             ?>
                              <div class="card simple-card">
                                <div class="card-body" >
                                  <div class="col-md-12 text-center" >
                                    <div class="alert alert-warning">
                                      <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Facebook not connected </h3> 
                                      <p><br>Connecting and authorizing facebook pages is required, Click  <a href="<?php echo $this->facebook->addpage_url(); ?>"> HERE </a> to connect right now.  so Adublisher can publish posts you schedule/set.<br>
                                      <b>Note - we will NEVER send anything to your friends or post anything that you haven't scheduled/set first!</b></p>
                                      <p>Later you can disconnect this app, just like any other social media based app.</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                         <?php
                            }
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
   
   $(function() {

	$("#pages").change(function() {
		$(".deleteall").hide();
		$(".shuffle").hide();
		var page = $("#pages").val();
		if (page != "") {
			//Here load sceduled posts into below are 
			$("#loader").show();
			$("#pagenamedisplay").html("| " + $(this).find("option:selected").text());
			$("#sceduled").html("");
			var dataOBJ = {
				'id': page
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL;?>getrssscheduled",
				data: dataOBJ,
				dataType: "json",
				success: function(response) {
					$("#loader").hide();
          $(".on_off").show();
					$('#rss_feed').val(response.rss_link);
          if(response.rss_active === "1"){
            $(".rssposting").attr("checked","true");
          }else{
            $(".rssposting").removeAttr("checked");
          }
					if (response.time_slots) {
						$('#timeslots').val($.parseJSON(response.time_slots)).trigger("chosen:updated");
					} else {
						$('#timeslots').val("").trigger("chosen:updated");
					}
					if (response.status) {
						if (response.data) {
							$(".deleteall").show();
							$(".shuffle").show();
						}
						$.each(response.data, function(index, elem) {
							/* tr = '<div class="col-lg-2 col-md-3" id="card_'+elem.id+'">'+
							          '<div class="card">'+
							              '<div class="el-card-item">'+
							                '  <div class="el-card-avatar el-overlay-1"> <a href="'+elem.url+'" target="_blank"> <img class="img-responsive" src="'+elem.link+'" />'+
							                '  </a></div>'+
							                ' <div class="el-card-content">'+
							                  '   <h6 class="p-2 rounded-title">'+elem.title +'</h6> <small>'+elem.post_date +'</small>'+
							                  '    <i class="fa fa-trash delbulkone text-danger pointer" data-id="'+elem.id+'"></i>  </div>'+
							            '  </div>'+
							        ' </div>'+
							      '</div>';*/
							var icon = "mdi mdi-calendar-clock text-info mdi-24px"
							var error = "";
							if (elem.posted == 1) {
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
							node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="min-height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
							node += '<p class="my-2" style="height:40px;overflow: hidden;" ><strong> <i class="' + icon + '"></i> ' + elem.post_date + '</strong></p>'
							node += '<p class="my-0">' + error + '</p>'
							node += '<div class="d-flex align-items-center">'
							node += '<div class="read"><a href="' + elem.url + '" target="_blank" class="link font-medium">Read More</a></div>'
							node += '<div class="ml-auto">'
							node += '<a href="javascript:void(0);" class="link h5  cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this image" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>'
							node += '</div>'
							node += '</div>'
							node += '</div>'
							node += '</div>'
							node += '</div>';
							$("#sceduled").append(node);
						});
					}
				},
				error: function() {
					$("#sceduled").html("");
					$("#loader").hide();
				}
			});
		}else{
      $(".on_off").hide();
      $('#timeslots').val("").trigger("chosen:updated");
      $("#sceduled").html("");
      $('#rss_feed').val("");
    }
	});

  $(".rssposting").click(function() {
    var page = $("#pages").val();
		if (page != "") {
				$("#loader").show();
        var status = "0";
        if(this.checked) {
          status = "1";
            }

				var dataOBJ = {
					'page': page,
          			'rss_active' : status
				}
				$.ajax({
					type: "POST",
					url: "<?php echo SITEURL;?>rssfeedonoff",
					data: dataOBJ,
					dataType: "json",
					success: function(response) {
						$("#loader").hide();
						swal({
							title: "Success!",
							text: "Rss has been changed successfully!",
							type: "success",
							showConfirmButton: false,
							timer: 1500
						});
					},
					error: function() {}
				});
		}
	});
	$(".delete_rss").click(function() {
		if ($("#rss_feed").val() != "") {
			swal({
				title: "Delete RSS???",
				text: "Are you sure to delete RSS link for this page!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete!",
				closeOnConfirm: false
			}, function() {
				$("#rss_feed").val('');
				var page = $("#pages").val();
				var time_slots = $(".chosen-select").val();
				var rss_url = $("#rss_feed").val();
				var publisher = $("#loggeduserid").val();
				$(".delete_rss").attr("disabled", true);
				$("#loader").show();
				var dataOBJ = {
					'rss_link': '',
					'publisher': publisher,
					'timeslots': time_slots,
					'page': page
				}
				$.ajax({
					type: "POST",
					url: "<?php echo SITEURL;?>rss_feed_engine",
					data: dataOBJ,
					dataType: "json",
					success: function(response) {
						$(".delete_rss").attr("disabled", false);
						$("#loader").hide();
						swal({
							title: "Success!",
							text: "Rss has been deleted from your page!",
							type: "success",
							showConfirmButton: false,
							timer: 1500
						});
					},
					error: function() {}
				});
			});
		}
	});
	$("#submit_rss").click(function() {
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
		if (rss_url == "") {
			alertbox("Error", "Please Provide Rss Feed URL first , and try again", "error");
			return false;
		}
		if (page != "" && time_slots != "" && rss_url != "") {
			$("#preloader_ajax").show();
			$("#submit_rss").attr("disabled", true);
			$("#loader").show();
			var dataOBJ = {
				'rss_link': rss_url,
				'publisher': publisher,
				'timeslots': time_slots,
				'page': page
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL;?>rss_feed_engine",
				data: dataOBJ,
				dataType: "json",
				success: function(response) {
					$("#preloader_ajax").hide();
					$("#loader").hide();
					$("#submit_rss").attr("disabled", false);
					if(response.status){
						
						$('#pages').trigger('change');
						swal({
						title: "Success!",
						text: response.message,
						type: "success",
						showConfirmButton: false,
						timer: 2500
					});

					}else{

						swal({
						title: "Error!",
						text: response.message,
						type: "error",
						showConfirmButton: false,
						timer: 6000
					});

					}
					
					
					
					
				},
				error: function() {
					$("#preloader_ajax").hide();
				}
			});
		}
	});
	$(".chosen-select").change(function() {
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
				url: "<?php echo SITEURL;?>update_page_timeslots_rss",
				data: dataOBJ,
				dataType: "json",
				success: function(response) {},
				error: function() {}
			});
		}
	});
	$(".chosen-select").chosen({
		no_results_text: "Oops, nothing found!"
	});
	$(document).on('click', '.deleteall', function() {
		var page = $("#pages").val();
		var error = $(this).data('error');
		swal({
			title: "Delete ALL Posts???",
			text: "You will not be able to recover these posts again!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete ALL!",
			closeOnConfirm: false
		}, function() {
			$("#loader").show();
			var dataOBJ = {
				'page': page,
				'error': error
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL;?>deletersspostall",
				data: dataOBJ,
				dataType: "json",
				success: function(response) {
					$(".deleteall").hide();
					$(".shuffle").hide();
					$("#loader").hide();
					if (response.status) {
            $('#pages').trigger('change');
						swal({
							title: "Deleted!",
							text: "Your scheduled posts Removed Successfully!",
							type: "success",
							showConfirmButton: false,
							timer: 1500
						});
					}
				},
				error: function() {
					$("#loader").hide();
					// alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
					swal("Error", "Nothing Has been deleted, please try again", "error");
				}
			});
		});
	});
	$(document).on('click', '.shuffle', function() {
		var page = $("#pages").val();
		swal({
			title: "Shuffle All Posts???",
			text: "You will not be able to recover order of these posts again!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Shuffle All!",
			closeOnConfirm: false
		}, function() {
			$("#loader").show();
			var dataOBJ = {
				'page': page
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL;?>shufflersspostall",
				data: dataOBJ,
				dataType: "json",
				success: function(response) {
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
				error: function() {
					$("#loader").hide();
					swal("Error", "Nothing Has been changed, please try again", "error");
				}
			});
		});
	});
	$(document).on('click', '.delbulkone', function() {
		id = $(this).data('id');
		row = $("#card_" + id);
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this post again!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
		}, function() {
			var dataOBJ = {
				'id': id
			}
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL;?>deletersspost",
				data: dataOBJ,
				dataType: "json",
				success: function(response) {
					if (response.status) {


						var icon = "mdi mdi-calendar-clock text-info mdi-24px"
							var error = "";
							var elem = response.data;
							if (elem.posted == 1) {
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
							node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="min-height:165px;" loading="lazy" src="' + elem.link + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
							node += '<p class="my-2" style="height:40px;overflow: hidden;" ><strong> <i class="' + icon + '"></i> ' + elem.post_date + '</strong></p>'
							node += '<p class="my-0">' + error + '</p>'
							node += '<div class="d-flex align-items-center">'
							node += '<div class="read"><a href="' + elem.url + '" target="_blank" class="link font-medium">Read More</a></div>'
							node += '<div class="ml-auto">'
							node += '<a href="javascript:void(0);" class="link h5  cursor-pointer delbulkone"  data-id="' + elem.id + '"  data-toggle="tooltip" title="Delete this image" data-original-title="Delete"><i class="mdi mdi-delete-forever"></i></a>'
							node += '</div>'
							node += '</div>'
							node += '</div>'
							node += '</div>'
							node += '</div>';
						$('#card_' + elem.id).remove();
						row.replaceWith(node);
						//$('#pages').trigger('change');
						swal({
							title: "Deleted!",
							text: "Your scheduled post Removed Successfully!",
							type: "success",
							showConfirmButton: false,
							timer: 1500
						});
					}
				},
				error: function() {
					// alertbox("Error" , "Nothing Has been deleted, try again" ,  "error");
					swal("Error", "Nothing Has been deleted, please try again", "error");
				}
			});
		});
	})
});
    
</script>