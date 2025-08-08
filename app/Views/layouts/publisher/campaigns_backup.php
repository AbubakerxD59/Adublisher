
<style type="text/css">
  #pagination{
  display: inline-block;
  margin: 0 auto;
}
#pagination li{
  display: inline-block;
}
.page-link{
    margin: 5px;
    padding-left: 12px!important;
    padding-right: 12px!important;
}
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper bg-white">
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
  <div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
      <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Campaigns 
        </h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo SITEURL ?>dashboard">Dashboard
            </a>
          </li>
          <li class="breadcrumb-item active">Campaigns
          </li>
        </ol>
      </div>
      <div class="col-md-7 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
          <div class="d-flex m-r-20 m-l-10 hidden-md-down">
            <?php echo $rates ?>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row el-element-overlay">
      <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 col-xlg-9" >
        <div class="row m-l-5 m-r-30">
          <div class="col-sm-12 col-xs-12">
            <form class="input-form p-0 m-t-10" style="line-height: 0;" id="searchform">
              <div class="row">       
                <div class="col-lg-12">
                  <div class="input-group">
                    <input type="text" class="form-control m-l-5" id="searchtext" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="button" id="searchsubmit">Search!
                      </button>
                    </span>
                  </div>
                </div>
              </div>
              <br>
              <!-- form-group -->
            </form>
          </div>
        </div>
        <div class="row m-l-5 m-r-5" id="loaders" style="display: none;">
          <?php
          for ($i=0; $i < 9; $i++) { 
          echo '<div class="col-lg-4 col-md-6 p-r-10 p-t-10 campaignCard">
          <div class="timeline-item">
          <div class="animated-background">
          <div class="background-masker header-top"></div>
          <div class="background-masker header-left"></div>
          <div class="background-masker header-right"></div>
          <div class="background-masker header-bottom"></div>
          <div class="background-masker subheader-right"></div>
          <div class="background-masker subheader-bottom"></div>
          <div class="background-masker subsubheader-right"></div>
          <div class="background-masker content-top"></div>
          <div class="background-masker content-first-end"></div>
          <div class="background-masker content-second-end"></div>
          </div>
          </div>
          </div>';
          }
          ?>
        </div>
        <div class="row mx-2 my-5" id="campiagns_html">
        </div>
        <br>
        <div class="row m-l-5 m-r-5 " id="campiagns_pagination">
          <ul id="pagination" class="pagination-sm">
          </ul>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
      </div>
      <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 col-xlg-3 p-10 p-r-20">
        <div class="row row card p-r-10">
          <h4 class="p-10">
            <b>
              <i class="fa fa-filter">
              </i>
            </b> FILTERS
          </h4>
          <div class="col-lg-12">
            <div class="form-group">
              <label>Popularity
              </label>
              <?php
              $popularity = "";
              if(!empty($save_filter)){
              $popularity = $save_filter->popularity;
              $domain = $save_filter->domain;
              $cat = $save_filter->cat;
              }
              ?>
              <select  class="form-control" name="popularity" id="popularity" >
                <option value="" >Select Popularity
                </option>
                <option value="today" 
                        <?php echo (!empty($popularity) && $popularity == 'today')? 'selected':''?> >Today's Top
                </option>
              <option value="week"  
                      <?php echo (!empty($popularity) && $popularity == 'week')? 'selected':''?>>Week's Top 
              </option>
            <!--  <option value="month"  <?php echo (!empty($popularity) && $popularity == 'month')? 'selected':''?>>Month's Top</option>-->
            <option value="all"  
                    <?php echo (!empty($popularity) && $popularity == 'all')? 'selected':''?>>All Time Top
            </option>
          </select>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="form-group">
        <label>Advertisers
        </label>
        <select  class="form-control" name="domain" id="domain">
          <option value="all">All Advertisers
          </option>
          <?php foreach($all_domains as $value){
          if(trim($value['domain']) == ""){
          continue;
          }
          ?>
          <option value="<?php echo $value['domain'];?>" 
                  <?php echo (!empty($domain) && $domain == $value['domain'])? 'selected':''?>>
          <?php echo ucfirst($value['domain']);?>
          </option>
        <?php } ?>
        </select>
    </div>
    <div class="col-lg-12">
      <div class="form-group">
        <label>Category
        </label>
        <select class="form-control selectpicker" name="cat" id="cat" multiple data-live-search="true">
          <option value="all">All Categories
          </option>
          <?php
          foreach($all_categories as $value)
          {
          $cata = explode('|', $cat);
          $selected = in_array($value->id,$cata)?'selected':'';
          echo '<option value="' . $value->id . '"'.$selected.'>' . ucfirst($value->categury) . '</option>';
          }
          ?>
        </select>
      </div>
    </div>
    <div class="col-lg-12 m-t-10">
      <div class="form-group" >
        <button  id="recomended" title="Recommended for you" class="btn btn-primary btn-block">
          <i class="fa fa-history" aria-hidden="true">
          </i> Recommended
        </button>
        <button  id="save_filter" title="Save Filter" class="btn btn-primary btn-block">
          <i class="fa fa-save" aria-hidden="true">
          </i> Save Filter
        </button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" id="pagesmodel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Your Facebook Pages
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive m-t-20">
          <table class="table stylish-table">
            <thead>
              <tr>
                <?php
                if(count($pages) > 0){
                ?>
                <th colspan="2">Page
                </th>
                <th>Post On Page
                </th>
                <?php } ?>
              </tr>
            </thead>
            <tbody id="pagetable">
              <?php
              if(count($pages) > 0){
              foreach ($pages as $page){
              ?>
              <tr>
                <td style="width:30px;">
                  <img style="width:30px;height:30px;" src="<?=$page->image_url ?>"  class="rounded b-all" alt="logo">
                </td>
                <td>
                  <?php echo $page->page_name; ?>
                </td>
                <td>
                  <button class="btn btn-facebook waves-effect waves-light autopost" data-page="<?=$page->id ?>" type="button">
                    <span class="btn-label">
                      <i class="fa fa-facebook">
                      </i>
                    </span>
                    Post Now
                  </button>
                </td>
              </tr>
              <?php
              }
              }
              else{
              echo "<tr><td colspan='3'>Opps, No pages found.<br> It Seems either you have not connected your facebook account OR you dont have Facebook pages.
              <br>Please <a href='".SITEURL."facebook'><b>CLICK HERE</b> </a> And you will be redirected to page, Where you can connect your  FACEBOOK Account with Adublisher.com</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close
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
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<?php
$this->load->view('templates/publisher/footer'); ?>


<script src="<?=GeneralAssets ?>plugins/pagination/jquery.twbsPagination.min.js"></script>

<script type="text/javascript">
$(function ()
{
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
	$(document).on('click', ".facebook", function ()
	{
		var current_user = $("#loggeduserid").val();
		$("#data_to_post").val($(this).data('caption'));
		$("#pagesmodel").modal();
	});
	$(document).on('click', ".autopost", function ()
	{
		var page_id = $(this).data('page');
		var data_to_post = $("#data_to_post").val();
		var dataobj = {
			id: page_id,
			data_to_post: data_to_post
		}
		$.ajax(
		{
			type: "POST",
			url: "facebook_posting",
			data: dataobj,
			dataType: "json",
			success: function (response)
			{
				if (response.status)
				{
					swal(
					{
						title: "Successfully Posted on Facebook",
						text: data_to_post,
						type: "success",
						timer: 60000,
						showConfirmButton: true
					});
				}
				else
				{
					swal(
					{
						title: "Something Went Wrong!",
						text: "Error, while posting on facebook. please contact support if you facing this error all the time.",
						type: "error",
						timer: 60000,
						showConfirmButton: true
					});
				}
			},
			error: function ()
			{
				swal(
				{
					title: "Something Went Wrong!",
					text: "Error, while posting on facebook. please contact support if you facing this error all the time.",
					type: "error",
					timer: 60000,
					showConfirmButton: true
				});
			}
		});
	});
	$(document).on('change', "#popularity ,#domain, #cat", function ()
	{
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
	$(document).on('click', "#recomended", function ()
	{
		$("#request").val("recomended");
		var dataOBJ = {
			request: "recomended",
			page: 1
		};
		ajaxCallP(dataOBJ);
	})
	$(document).on('click', "#searchsubmit", function ()
	{
		if ($.trim($("#searchtext").val()) == "")
		{
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
	$(document).on('submit', "#searchform", function ()
	{
		if ($.trim($("#searchtext").val()) == "")
		{
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
	$(document).on('click', ".caption", function ()
	{
		clipboard.copy($(this).data('caption'));
		alertbox("Information", "Text Copied to Clipboard", 'info');
	});
})

function ajaxCallP(dataobj)
{
	$("#loaders").show();
	$.ajax(
	{
		type: "POST",
		url: "getcampaigns",
		data: dataobj,
		dataType: "json",
		success: function (response)
		{
			if (response.status)
			{
				if (response.data.count > 0)
				{
					appendcp(response.data.campaigns);
					pagination(response.data.count, response.data.pagesize);
				}
				else
				{
					$("#campiagns_html").html('<div class="alert alert-warning" style="margin: 40px auto;"> No data Found, try to change filter/search criteria.</div>');
				}
			}
			else
			{
				$("#campiagns_html").html('<div class="alert alert-warning" style="margin: 40px auto;"> No data Found, try to change filter/search criteria.</div>');
			}
			$("#loaders").hide();
		},
		error: function ()
		{
			$("#loaders").hide();
		}
	});
}

function ajaxCallPagination(dataobj)
{
	$("#loaders").show();
	$.ajax(
	{
		type: "POST",
		url: "getcampaigns",
		data: dataobj,
		dataType: "json",
		success: function (response)
		{
			if (response.status)
			{
				appendcp(response.data.campaigns);
			}
			else
			{}
			$("#loaders").hide();
		},
		error: function ()
		{
			$("#loaders").hide();
		}
	});
}

function appendcp(campaigns)
{
	$("#campiagns_html").html("");
	$(campaigns).each(function (e)
	{
		var _blank = "_blank";
		var campaign = $(this)[0];
		oncl = "window.open(" + "'" + campaign.campaign_link + "'" + "," + "'_blank')";
		var node = '<div class="col-lg-4 col-md-12">'
		node += '<div class="card blog-widget">'
		node += '<div class="card-body">'
		node += '<div class="blog-image cursor-pointer" onclick=' + oncl + ' ><img  style="min-height:165px;" src="' + campaign.img + '" alt="img" class="img-fluid blog-img-height w-100"></div>'
		node += '<p class="my-2" style="height:80px;overflow: hidden;" >' + campaign.campaign_heading + '</p>'
		node += '<div class="d-flex align-items-center">'
		node += '<div class="read"><a href="' + campaign.campaign_link + '" target="_blank" class="link font-medium">Read More</a></div>'
		node += '<div class="ml-auto">'
		node += '<a  class="link mr-2 h6" data-toggle="tooltip" title="Total Views" data-original-title="Hits on this campaign"><i class="mdi mdi-poll"></i> ' + campaign.total_clicks + ' </button>'
		node += '<a data-caption="' + campaign.withcaption + '" class="link mr-2 caption cursor-pointer h6" data-toggle="tooltip" title="Copy link address" data-original-title="Copy link to share manually"><i class="mdi mdi-content-copy"></i></button>'
		node += '<a data-caption="' + campaign.withoutcaption + '" class="link cursor-pointer facebook h6" data-toggle="tooltip" title="Share on facebook" data-original-title="Share"><i class="mdi mdi-share-variant"></i></button>'
		node += '</div>'
		node += '</div>'
		node += '</div>'
		node += '</div>'
		node += '</div>';
		/*var node = '<div class="col-lg-4 col-md-6 p-r-10 p-t-10">';
		node += '<div class="card">';
		node += '<div class="el-card-item" style="padding-bottom:10px;">';
		node += '<div class="el-card-avatar el-overlay-1" style="cursor: pointer" '; 
		node += 'onclick='+oncl;
		node += '>';
		node += '<img style="height:165px;" src="'+campaign.img+'" alt="image">';
		node += '</div>';
		node += '<div class="m-l-5" style="height:75px;overflow: hidden;">';
		node += '<strong>'+campaign.campaign_heading+'</strong>';
		node += '<br> ';
		node += '</div>';
		node += '<div class="m-l-5">';
		node += '<small>'+campaign.total_clicks+' views</small>';
		node += '</div>';
		node += '<div class="el-card-content p-t-5">';
		node += '<button class="btn btn-xs btn-primary facebook pull-left m-l-5" data-caption="'+campaign.withoutcaption+'" title="Share Link on your Registered Facebook pages"><i class="fa fa-facebook" aria-hidden="true"></i> Post On Facebook</button>&nbsp;';
		node += '<button class="btn btn-xs btn-primary caption pull-right m-r-5" data-caption="'+campaign.withcaption+'" title="Copy capaign link without caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> Copy Link</button>';
		node += '</div>';
		node += '</div>';
		node += '</div>';
		node += '</div>';*/
		$("#campiagns_html").append(node);
		$('[data-toggle="tooltip"]').tooltip()
		$('img').on("error", function ()
		{
			$(this).attr('src', '<?=GeneralAssets ?>/images/noimage.png');
		});
	})
}

function pagination(count, pagesize)
{
	var total_pages = parseInt(Math.ceil(count / pagesize));
	$('#campiagns_pagination').html("");
	$('#campiagns_pagination').html('<ul id="pagination" class="pagination-sm"></ul>');
	$('#pagination').twbsPagination(
	{
		totalPages: total_pages,
		visiblePages: 10,
		next: 'Next',
		prev: 'Prev',
		onPageClick: function (event, page)
		{
			//fetch content and render here
			var request = $("#request").val();
			var dataOBJ = {
				request: "",
				page: page
			};
			if (request == "filter")
			{
				dataOBJ = {
					request: "filter",
					cat: $("#cat").val(),
					popularity: $('#popularity').find(":selected").val(),
					domain: $("#domain").val(),
					keyword: "",
					page: page
				};
			}
			else if (request == "recomended")
			{
				dataOBJ = {
					cat: $("#cat").val(),
					popularity: $('#popularity').find(":selected").val(),
					domain: $("#domain").val(),
					request: "recomended",
					page: page
				};
			}
			else if (request == "search")
			{
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
$(document).on('click', "#save_filter", function ()
{
	var cat = $("#cat").val();
	var popularity = $("#popularity").val();
	var domain = $("#domain").val();
	var dataobj = {
		cat: cat,
		popularity: popularity,
		domain: domain
	};
	///console.log(dataOBJ);
	$.ajax(
	{
		type: "POST",
		url: "save_filter",
		data: dataobj,
		dataType: "json",
		complete: function (response)
		{
			alertbox("Success", "Settings are saved now", "success");
		}
	});
});

</script>