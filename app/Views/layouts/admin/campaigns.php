
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Campaigns </h3>
                         <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo SITEURL ?>dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Campaigns</li>
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
                                  <button class="btn btn-primary" type="button" id="searchsubmit">Search!</button>
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

 <div class="row m-l-5 m-r-5 " id="campiagns_html">
 

  </div>
<br>
  <div class="row m-l-5 m-r-5 " id="campiagns_pagination">
    <ul id="pagination" class="pagination-sm"></ul>
 
  </div>
                    
                    
                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                </div>
              
             <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 col-xlg-3 p-10 p-r-20">
                <div class="row row card p-r-10">
                    <h4 class="p-10"><b><i class="fa fa-filter"></i></b> FILTERS</h4>
                 <div class="col-lg-12">
                    <div class="form-group">
                        <label>Popularity</label>
                        <select  class="form-control" name="popularity" id="popularity" >
                            <option value="" >All Campaings</option>
                            <option value="today"  >Today's Top</option>
                            <option value="week"  >Week's Top </option>
                           <!-- <option value="month"  >Month's Top</option>-->
                            <option value="all"  >All Time Top</option>
                        </select>
                    </div>
                    </div>
					
					<div class="col-lg-12">
                    <div class="form-group">
                     <label>Doamin</label>
					
                    <select  class="form-control" name="domain" id="domain">
                        <option value="all">All Doamins</option>
                        <?php foreach($all_domains as $value):?>
						 <option value="<?php echo $value['domain'];?>"><?php echo ucfirst($value['domain']);?></option>
						<?php endforeach;?>
                  </select>
                    </div>
                </div>
					
                    <div class="col-lg-12">
                    <div class="form-group">
                    
                     <label>Category</label>
                    <select  class="form-control selectpicker" name="cat" id="cat" multiple data-live-search="true">
                        <option value="all">All Categories</option>
                        <?php 

foreach($all_categories as $value)
    {
    echo '<option value="' . $value->id . '">' . ucfirst($value->categury) . '</option>';
    }

?>


                  </select>
                    </div>
                </div>
                <div class="col-lg-12 m-t-10">
                     <div class="form-group" >
                      <button  id="save_filter" title="Save Filter" class="btn btn-primary btn-block">
                        <i class="fa fa-save" aria-hidden="true"></i> Save
                      </button>
                    
                     </div>
                </div>
                </div>

                <div class="row row card p-r-10">
                    <h4 class="p-10"><b><i class="mdi mdi-bullhorn"></i></b> Publisher Account</h4>
                 <div class="col-lg-12">

                  <img src="<?php echo $linked_publisher->img; ?>" width='50' class='img-circle' alt='image'><br>

                  <small class="text-muted">ID: <?php echo $linked_publisher->id; ?></small><br>
                  <small class="text-muted">NAME: <?php echo $linked_publisher->name; ?>'</small><br>
                  <small class="text-muted">USERNAME: <?php echo $linked_publisher->username; ?></small><br>
                  <small class="text-muted">PHONE: <?php echo $linked_publisher->ph; ?></small><br>
                   <small class="text-muted">DOMAIN: <?php echo $linked_publisher->active_domain; ?></small><br>
                  <small class="text-muted">EMAIL: <?php echo $linked_publisher->email; ?></small>

                 </div>
               </div>

                </div>


    </div>
</div>
<input type="text" id="request" style="display: none;">
</div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
<?php
$this->load->view('templates/admin/footer'); ?>


<script src="<?=GeneralAssets ?>plugins/pagination/jquery.twbsPagination.min.js"></script>

      <script type="text/javascript">
	  $(document).ready(function () {
        $('.selectpicker').selectpicker();
		});
    $(function(){

      

             var dataLoad = {
                  request : "",
                  page:1
              };
              ajaxCall(dataLoad); 

        $(document).on('change' , "#popularity,#domain , #cat" , function(){

              $("#request").val("filter");
              var dataOBJ = {
                  request : "filter",
                  cat: $("#cat").val(),
                  popularity: $("#popularity").val(),
                  domain: $("#domain").val(),
                  keyword: "",
                  page:1
              };
              ajaxCall(dataOBJ); 
        })

       $(document).on('click' , "#recomended" , function(){

              $("#request").val("recomended");
           
              var dataOBJ = {
                  request : "recomended",
                  page:1
              };
              ajaxCall(dataOBJ); 
			 
        })
		$(document).on('click' , "#save_filter" , function(){

			  var cat = $("#cat").val();
			  var popularity = $("#popularity").val();
			  var domain = $("#domain").val();
           
              var dataobj = {
                  cat : cat,
                  popularity : popularity,
                  domain : domain
              };
              ///console.log(dataOBJ);
			    $.ajax({
                type: "POST",
                url: "save_filter",
                data: dataobj,
                dataType: "json",
					success: function(response) {
					}
				});
        });

        $(document).on('click' , "#searchsubmit" , function(){


              if($.trim($("#searchtext").val()) == "" ){
                alertbox("Warning" , "Please enter text to search campaings" , "warning" );
                return false;
              }

              $("#request").val("search");
           
              var dataOBJ = {
                  request : "search",
                  keyword: $("#searchtext").val(),
                  page:1
              };
              ajaxCall(dataOBJ); 
        })

$(document).on('submit' , "#searchform" , function(){


              if($.trim($("#searchtext").val()) == "" ){
                alertbox("Warning" , "Please enter text to search campaings" , "warning" );
                return false;
              }

              $("#request").val("search");
           
              var dataOBJ = {
                  request : "search",
                  keyword: $("#searchtext").val(),
                  page:1
              };
              ajaxCall(dataOBJ); 

              return false;
        })



        $(document).on('click' , ".caption" , function(){
            clipboard.copy($(this).data('caption'));
            alertbox("Information" , "Text Copied to Clipboard", 'info');
        });



})

function ajaxCall(dataobj){

           
            $("#loaders").show();
            $("#campiagns_html").html("");
            
            $.ajax({
                type: "POST",
                url: "getcampaigns_admin",
                data: dataobj,
                dataType: "json",
                success: function(response) {

                  if (response.status) {
                    
                    if(response.data.count > 0){
                       appendcp(response.data.campaigns);
                       pagination(response.data.count , response.data.pagesize);
                    }
                    else{
$("#campiagns_html").html('<div class="alert alert-warning" style="margin: 40px auto;"> No data Found, try to change filter/search criteria.</div>');
                  }
                    
                   
                  }else{
                       $("#campiagns_html").html('<div class="alert alert-warning" style="margin: 40px auto;"> No data Found, try to change filter/search criteria.</div>');
                  }
                  
                  $("#loaders").hide();
                },
                error: function() {
                  $("#loaders").hide();
                 
                }
       });

}

function ajaxCallPagination(dataobj){

           
            $("#loaders").show();
             $("#campiagns_html").html("");
            
            $.ajax({
                type: "POST",
                url: "getcampaigns_admin",
                data: dataobj,
                dataType: "json",
                success: function(response) {

                  if (response.status) {

                    appendcp(response.data.campaigns);
                   
                  }else{

                  }

                  $("#loaders").hide();
                },
                error: function() {
                  $("#loaders").hide();
                 
                }
       });

}

    function appendcp(campaigns){

       
       $(campaigns).each(function(e){
                        var _blank = "_blank";
                        var campaign = $(this)[0];
                        oncl = "window.open("+"'"+campaign.campaign_link+"'"+ "," +"'_blank')";
                        var node = '<div class="col-lg-4 col-md-6 p-r-10 p-t-10">';
                            node += '<div class="card">';
                            node += ' <div class="el-card-item">';

        node += ' <div class="el-card-avatar el-overlay-1" style="cursor: pointer" '; 
        node += 'onclick='+oncl;
        node += '>';
        node += '<img style="height:165px;" src="'+campaign.img+'" alt="image">';
                                       
                                   node += ' </div>';
                                  node += ' <div class="m-l-5" style="height:75px;overflow: hidden;">';
                                    node += '    <strong>'+campaign.campaign_heading+'</strong>';
                                     node += '   <br> ';
                                  node += '  </div>';
                              node += '  <div class="m-l-5">';
                              node += '  <small>'+campaign.total_clicks+' views</small>';
                             node += '   </div>';
                            node += '    <div class="el-card-content">';
                                        
        node += '<button class="btn btn-xs btn-primary caption " data-caption="'+campaign.withcaption+'" title="Copy capaign link with caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> With Caption</button>';
       node += '   <button class="btn btn-xs btn-primary caption " data-caption="'+campaign.withoutcaption+'" title="Copy capaign link without caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> Without Caption</button>';

                          node += '         </div>';
                       node += '           </div>';
                     node += '         </div>';
                     node += '     </div>';
                        $("#campiagns_html").append(node);

                    })
    }
    
   function pagination(count , pagesize){

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
                  request : "",
                 page:page
              };
            if(request == "filter"){
                  dataOBJ = {
                  request : "filter",
                  cat: $("#cat").val(),
                  popularity: $("#popularity").val(),
                  domain: $("#domain").val(),
                  keyword: "",
                  page:page
              };
            }
            else if(request == "recomended") {
                  dataOBJ = {
                  request : "recomended",
                  page:page
              };
            }
            else if(request == "search") {
                  dataOBJ = {
                  request : "search",
                 page:page
              };
            }

            ajaxCallPagination(dataOBJ);
           
        }
    });

    }

</script>
