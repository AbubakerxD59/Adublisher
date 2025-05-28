
<link href="<?=GeneralAssets ?>plugins/wizard/steps.css" rel="stylesheet">

<style type="text/css">
    .wizard-rows{
            margin: 0px;
            padding-left: 50px;
            padding-right: 50px;
            padding-top: 50px;
            border-top: 3px solid #f3f3f3;
    }
</style>

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
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
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Website Widgets</h3>
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=SITEURL?>dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Website Widgets</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                           <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
               
                <div class="row">
                  
                   <div class="col-12">
                        <div class="card">
                            <div class="card-body wizard-content">
                            <div  class="tab-wizard wizard-circle">
                                  
                                  <!--<h6>Select Website</h6>
                                    <section>
                                       
                                        <div class="row wizard-rows">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="website">Select Website:</label>
                                                    <select class="custom-select form-control" id="website" name="location">
                                                        <option value="1">www.readlyhub.com</option>
                                                        <option value="2_3" disabled="true">www.readlyhub.com</option>
                                                        <option value="3_3" disabled="true">www.readlyhub.com</option>
                                                    </select>
                                                    <help>Note: do not have resgistered any website yet ? <a href="#">Click To register website</a></help>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </section>
                                    -->
                                    <!-- Step 1 -->
                                    <h6>Widget Size & Layout</h6>
                                    <section>
                                       
                                        <div class="row wizard-rows">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="layout">Select Layout:</label>
                                                    <select class="custom-select form-control" id="layout" name="location">
                                                        <option value="1_3">1 Row With 3 ads each row</option>
                                                        <option value="2_3" disabled="true">2 Row With 3 ads each row</option>
                                                        <option value="3_3" disabled="true">3 Row With 3 ads each row</option>
                                                    </select>
                                                    <help>Note: For now we only provide <strong>1 Row With 3 ads each row</strong></help>
                                                </div>
                                            </div>
                                          
                                        </div>
                                    </section>
                                    <!-- Step 2 -->
                                    <h6>Choose Categories</h6>
                                    <section>
                                        <div class="row wizard-rows">
                                            <?php 
                                            foreach ($all_categories as $cat) {
                                                
                                           
                                            ?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    
                                                    <input type="checkbox" class="form-control" disabled="true" id="cat_<?php echo $cat->id; ?>"> 
                                                     <label for="cat_<?php echo $cat->id; ?>" > <?php echo $cat->categury; ?></label>
                                                </div>
                                                   
                                            </div>
                                           
                                           <?php
                                       }
                                           ?>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    
                                                    <input type="checkbox" class="form-control" checked="true" id="all"> 
                                                     <label for="" > All Latest Ads</label>
                                                </div>
                                                   
                                            </div>
                                        <div class="col-md-12">
                                             <help>Note: For now we only provide <strong>All Latest Ads</strong></help>
                                        </div>
                                        </div>
                                    </section>
                                    <!-- Step 3 -->
                                    <h6>Widget Code</h6>
                                    <section>
                                        <div class="row wizard-rows">

                                            <div class="col-md-12">
                                               

                                        <blockquote style="border-left: 3px solid #6e24c1;">
                                            <p class="font-weight-bold text-muted">  <button type="button" class="btn btn-primary btn-circle btn-sm"><i class="fa fa-clipboard"></i> </button>  Copy and paste the following JS where you want the widget to appear.</p>
                                            <small class="text-muted">- Instruction! <cite title="Instruction" >Please allow up to 30 minutes to see any changes on your widget. You only need to copy and paste the following JS, the first time that you create the widget.</cite></small>
                                        </blockquote>

                                                <div class="form-group">

                                                  <textarea class="form-control bg-white" style="color:#000;" rows="15" readonly="true">
                                                   
<?php
$random_id = App::Session()->get('userid')."_".rand();
$publisher = App::Session()->get('userid');
$username = App::Session()->get('MMP_username');
?>
<div id="autoloadjs_<?=$random_id;?>"></div>
<script type="text/javascript">
(function() {
    var elem = document.createElement("script");
    elem.type = 'text/javascript';
    elem.src = "<?=BASEURL;?>server.js.php?target=autoloadjs_<?=$random_id ?>&enginefor=<?=$username?>&publisher=<?=$publisher?>&layout=1_3&width=" + (window.outerWidth || document.documentElement.clientWidth);
    elem.async = true;
    var auds = document.getElementById("autoloadjs_<?=$random_id;?>");
    auds.appendChild(elem);
})();
</script>

                                                   </textarea>
                                                </div>
                                              
                                               
                                            </div>
                                           
                                        </div>
                                    </section>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
             
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
 <?php $this->load->view('templates/publisher/footer'); ?>

 <script src="<?=GeneralAssets ?>plugins/moment/min/moment.min.js"></script>
  <script src="<?=GeneralAssets ?>plugins/wizard/jquery.steps.min.js"></script>
  <script src="<?=GeneralAssets ?>plugins/wizard/jquery.validate.min.js"></script>
  <script src="<?=GeneralAssets ?>plugins/wizard/steps.js"></script>

  
 
<script>
    $(document).ready(function() {
        $("#example-basic").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true
        });
    $(".updatesystemdomain").click(function(){

      domain_id = $("#domain").val();
      domain_ = $("#domain option:selected").text();

      var dataOBJ = {
        'id': $("#user_id").val(),
        'domain_id': domain_id ,
      }
      $.ajax({
        type: "POST",
        url: "domainchange",
        data: dataOBJ,
        dataType: "json",
        success: function(response) {
          if (response) {
            alertbox("Success" , "Domain updated Successfully" ,  "success");
           $("#currentdomain").text(domain_);
          }
        },
        error: function() {
           alertbox("Information" , "Nothing Has been Changed.. please try again after changing domain" ,  "info");
        }
      });


    });


    });
</script>