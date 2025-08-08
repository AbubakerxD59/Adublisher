
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
                <form class="input-form p-0 m-t-10" style="line-height: 0;">
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
    <?php

foreach($campaigns as $campaign)
    {
    echo '<div class="col-lg-4 col-md-6 p-r-10 p-t-10">
                            <div class="card">
                                <div class="el-card-item">';
?>

       <div class="el-card-avatar el-overlay-1" style="cursor: pointer" onclick = 'window.open("<?php
    echo $campaign['campaign_link'] ?>", "_blank")' >

    <?php
    echo '<img style="height:165px;" src="' . $campaign['img'] . '" alt="image" />
                                       
                                    </div>
                                    <div class="m-l-5" style="height:75px;overflow: hidden;">
                                        <strong>' . $campaign['campaign_heading'] . '</strong>
                                        <br/> 
                                    </div>
                                       <!--  <div class="m-l-5">
                                         <small color: #26c6da;><b>' . $campaign['cplink'] . '</b></small> 
                                        </div> -->
                                        <div class="m-l-5">
                                        <small>' . $campaign['total_clicks'] . ' views</small>
                                        </div>
                                        <div class="el-card-content">
                                        
        <button class="btn btn-xs btn-primary caption" data-caption="' . $campaign['withcaption'] . '" title="Copy capaign link with caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> With Caption</button>
        <button class="btn btn-xs btn-primary caption"  data-caption="' . $campaign['withoutcaption'] . '" title="Copy capaign link without caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> Without Caption</button>

                                 </div>
                                </div>
                            </div>
                        </div>';
    }

?>
                       

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
                            <option value="month"  >Month's Top</option>
                            <option value="all"  >All Time Top</option>
                        </select>
                    </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="form-group">
                     <label>Category</label>
                    <select  class="form-control" name="cat" id="cat">
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
                      <button  id="recomended" title="Recommended for you" class="btn btn-primary btn-block">
                        <i class="fa fa-history" aria-hidden="true"></i> Recommended
                      </button>
                    
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
$this->load->view('templates/publisher/footer'); ?>


      <script type="text/javascript">
    $(function(){

        $(document).on('change' , "#popularity , #cat" , function(){

              var dataOBJ = {
                  request : "filter",
                  cat: $("#cat").val(),
                  popularity: $("#popularity").val(),
                  keyword: ""
              };
              ajaxCall(dataOBJ); 
        })

       $(document).on('click' , "#recomended" , function(){

              var dataOBJ = {
                  request : "recomended"
              };
              ajaxCall(dataOBJ); 
        })

        $(document).on('click' , "#searchsubmit" , function(){

              if($.trim($("#searchtext").val()) == "" ){
                alertbox("Warning" , "Please enter text to search campaings" , "warning" );
                return false;
              }
              var dataOBJ = {
                  request : "search",
                  keyword: $("#searchtext").val()
              };
              ajaxCall(dataOBJ); 
        })

        $(document).on('click' , ".caption" , function(){
            clipboard.copy($(this).data('caption'));
            alertbox("Information" , "Text Copied to Clipboard", 'info');
        });



})

function ajaxCall(dataobj){


            $("#loaders").show();
            
            $.ajax({
                type: "POST",
                url: "getcampaigns",
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

       $("#campiagns_html").html("");
       $(campaigns).each(function(e){
                        
                        var campaign = $(this)[0];
                        var node = '<div class="col-lg-4 col-md-6 p-r-10 p-t-10">';
                            node += '<div class="card">';
                            node += ' <div class="el-card-item">';

        node += ' <div class="el-card-avatar el-overlay-1" style="cursor: pointer" onclick="window.open("", "")">';
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
                                        
        node += '<button class="btn btn-xs btn-primary caption" data-caption="'+campaign.withcaption+'" title="Copy capaign link with caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> With Caption</button>';
       node += '   <button class="btn btn-xs btn-primary caption" data-caption="'+campaign.withoutcaption+'" title="Copy capaign link without caption to Clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> Without Caption</button>';

                          node += '         </div>';
                       node += '           </div>';
                     node += '         </div>';
                     node += '     </div>';
                        $("#campiagns_html").append(node);

                    })
    }
    

</script>