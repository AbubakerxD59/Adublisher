
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css" rel="stylesheet"/>



<style>
    .range_inputs { font-size: 0px; }
.range_inputs * { display: none; }
.ranges li:last-child { display: none; }
    .chosen-container {
    width: 90%!important;
    font-size: 14px!important;
    }
    .dropzone .dz-preview .dz-error-message {
    color: white;
    
}

</style>
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
                        <h3 class="text-themecolor m-b-0 m-t-0"><i class="ti-instagram"></i> Story Bulk Upload <small>Beta Version </small><i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Our Bulk upload feature is in beta version, if you find any bug please email it on info@adublisher.com"></i></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=SITEURL?>dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bulk Upload & Schedule</li>
                        </ol>
                    </div>
                    <?php
                 echo loader();
                 ?>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                     <div class="col-md-12 col-xlg-12">
                        <!-- Column -->
                        <?php 
                         $class="";
                    if(($user->ig_username != "") && ($user->ig_pass != "")){
                        $class="hide";
                         ?>
                        <div class="card ig-widget">
                            <div class="card-body b-t p-b-15">
                                <div class="row">
                                  <div class="col-md-2 col-sm-2 col-xs-12 m-t-10 text-left">
                                      <b> &nbsp; <i class="fa fa-check text-success text-green"></i> Step 1 - </b>Link Account<i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="First step is to add your instagram account. make sure to enter correct username and password"></i>
                                  </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 m-t-10">
                                        <input type="hidden" id="title" value="title for post">
                                        <input type="hidden" id="type" value="story">
                                        
                                        <img src="<?=GeneralAssets?>images/instaicon.png" alt="Instagram" width="30"> <?php echo $user->ig_username; ?> &nbsp; &nbsp; 
                                        <button class="btn btn-sm btn-warning" id="changeinsta"> <i class="fa fa-gear"></i> | update account </button>
                                        
                                     </div> 
                              <div class="col-md-2 col-sm-2 col-xs-12 m-t-10 text-left">
                                  <b>Step 2- </b> Select hours<i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Second step is to select time slots, You can max select 24 time slots per day. Select Atleast one time slot to open upload area."></i>
                                 
                                  </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 m-t-10">
                                    <select multiple data-placeholder="Select Hours to post..."  class="chosen-select">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                      <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                    <?php endfor ?>
                                    </select>
                                    </div>
                                    
                            </div>
                                
                        </div>
                            
                            

                                
                                 

                         
                        <!-- Column -->
                    </div>
                         <div class="card ig-widget" >
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-md-12 m-t-10 text-left">
                                        <b>Step 3- </b> Drop Files here: <i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Third step is to select upload bulk images, every image must be equal to or less than 2MB."></i>
                                    </div>
                                </div>
                                
                             </div>
                               <div class="card-body b-t" >
                                   
                                 <div class="content-wrap dropzonewidget" style="display:none;">
                                   <div class="row">
                                      <div class="col-md-12">
                                         <div class="nest p-10" id="DropZoneClose">
                                            <div class="title-alt">
                                            
                                            </div>
                                            <div class="body-nest" id="DropZone">
                                               <div id="myDropZone" class="dropzone" >
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                         </div>
                         <div class="card ig-widget">
                            <div class="card-header ">
                               
                                 <div class="row">
                                    <div class="col-md-12 m-t-10 text-left">
                                        <b>Manage Scheduled Posts </b> <span id="pagenamedisplay"></span>: <i class="mdi mdi-help-circle-outline"  data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Here you can manage the existing posts on pages. Select Page to load posts"></i>
                                        
                                    </div>
                                </div>
                             </div>
                             
                               <div class="card-body b-t" >
                                   <div class="col-md-12 row el-element-overlay" id="sceduled">
                                   
                                       
                                   </div>
                             </div>
                         </div>
                         <?php
                            }
                             ?>
                          <div class="card set-widget <?=$class;?>">
                               <div class="card-body b-t" >
                                
                                 <div class="col-md-12 text-center" style="margin-top:50px;" >
                                 <a href="javascript:void(0)" class="text-center db"><img src="<?=GeneralAssets?>images/instagram.png" alt="Instagram"></a>
                                    <div class="login">
                                         <div class="col-md-4 text-center" style="margin:auto">
                                         <form class="orm-material" id="saveinstagram" action="#" method="post">
                                             <p>Please enter your Instagram Account </p>
                                                <div class="form-group validate">
                                                    <div class="col-xs-12">
                                                    <input class="form-control" tabindex="1" type="text" name="ig_username" id="ig_username" required placeholder="Instagram Username" aria-invalid="false" value="<?=$user->ig_username;?>" >
                                                 </div>
                                                </div>
                                                <div class="form-group validate">
                                                    <div class="col-xs-12">
                                                        <input class="form-control" tabindex="2" name="ig_pass" id="ig_pass" type="text" required placeholder="Instagram Password" area-invalid="false"  value="<?=$user->ig_pass;?>">
                                                    </div>
                                                </div>
                                             
                                                <div class="form-group text-center m-t-20">
                                                    <div class="col-xs-12">
                                                       
                                                        
                                                        
                                                         <a href="#" class="btn btn-danger text-uppercase" tabindex="3" id="cancelsave" ><i class="fa fa-arrow-left"></i>  Back  </a>
                                                        
                                                        <button class="btn btn-warning text-uppercase" tabindex="3" type="submit"><i class="fa fa-lock"></i> Save  </button>
                                                        
                                                    </div>
                                             </div>                                               
                                            </form>
                                         </div>
                                      
                                        <b>Note - we will NEVER send anything to your friends or post anything that you haven't scheduled/set first!</b>
                                         <p>Later you can disconnect this app, just like any other social media based app.</p>
                                                </div>
                                        </div>
                         </div>
                         </div>
                         
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
           <?php $this->load->view('templates/publisher/footer'); ?>
                    
                   
                     
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(function() {  
        
         $("#loader").show();
        setTimeout(function(){
               
               myDropzone.removeAllFiles(true); 
               Current_File = 1;
               var chosen = $(".chosen-select").val().length;
               var type   = $("#type").val();               
                $("#sceduled").html("");
                 var dataOBJ = {
                       
                        'type' : type
                      }
                      $.ajax({
                        type: "POST",
                        url: "<?php echo SITEURL;?>getinstagrambulkscheduled",
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response) {
                             $("#loader").hide();
                          if (response.status){
                             $.each(response.data , function(index, elem){
                              
                                 tr = '<div class="col-lg-2 col-md-3" id="card_'+elem.id+'">'+
                                    '<div class="card">'+
                                        '<div class="el-card-item">'+
                                          '  <div class="el-card-avatar el-overlay-1"> <img src="assets/bulkuploads/'+elem.link+'" alt="user">'+
                                          '  </div>'+
                                           ' <div class="el-card-content">'+
                                             '   <h5 class="p-2 rounded-title">'+elem.title +'</h5> <small>'+elem.post_date +'</small>'+
                                             '   | <i class="fa fa-trash delbulkone text-danger pointer" data-id="'+elem.id+'"></i>  </div>'+
                                      '  </div>'+
                                   ' </div>'+
                                '</div>';
                                 $("#sceduled").append(tr);
                             });
                          }
                        },
                        error: function() {
                             $("#loader").hide();
                             $("#sceduled").html("");
                             //swal("Opps", "Nothing found related to this page, please upload and try again" , "error");
                             //alertbox("Opps" , "Nothing found related to this page, please upload and try again" ,  "error")
                        }
                      });       
        
       
       
   },2000);
  
        
        $("#changeinsta").click(function(){
           $(".ig-widget").hide();
           $(".set-widget").show();
            
        });
         $("#cancelsave").click(function(){
           $(".ig-widget").show();
           $(".set-widget").hide();
            
        });
        
       $("#saveinstagram").submit(function(e) {
           e.preventDefault();
           var form = $(this);
         
                      $.ajax({
                        type: "POST",
                        url: "<?php echo SITEURL;?>saveinstagram",
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                          
                          
                            swal({
                                    title: "Success!",   
                                    text: "Username and password saved Successfully!",   
                                    type: "success",   
                                    showConfirmButton: false,
                                    timer: 1500
                                
                            }); 
                              setTimeout(function(){
                                  
                                  location.reload();
                                  
                              },1500)
                         
                        },
                        error: function() {
                        
                           swal("Error", "Nothing Has been saved, please try again" , "error");
                        }
                      });    
           
           return false;
        
      });
    

       var Current_File = 1;
       var myDropzone = new Dropzone("div#myDropZone", {
       
          url : "<?php echo SITEURL; ?>save_ig_bulkschedule",
          paramName: "file", 
          maxFilesize: 2,
          acceptedFiles: 'image/*',
          parallelUploads:5,
          init: function() {
               
            this.on("addedfile", function(file) { 
                
                var type = $("#type").val();
                var chosen = $(".chosen-select").val();
            
            });
            this.on("sending", function(file, xhr, data) {
                        
                        
                        data.append("totalfiles",  this.getAcceptedFiles().length);
                        data.append("current_file",  Current_File);
                        data.append("title",  $("#title").val());
                        data.append("type",  $("#type").val());
                        data.append("timeslots",  $(".chosen-select").val());
                        Current_File = Current_File +1;
            });
            this.on("success", function(file, response) {
               
                //image uploaded
                if(response.status){
                    
                         
                             var block = '<div class="col-lg-2 col-md-3" id="card_'+response.data.id+'">'+
                                    '<div class="card">'+
                                        '<div class="el-card-item">'+
                                          '  <div class="el-card-avatar el-overlay-1"> <img src="assets/bulkuploads/'+response.data.link+'" alt="user">'+
                                          '  </div>'+
                                           ' <div class="el-card-content">'+
                                             '   <h5 class="p-2 rounded-title">'+response.data.title +'</h5> <small>'+response.data.post_date +'</small>'+
                                             '   | <i class="fa fa-trash delbulkone text-danger pointer" data-id="'+response.data.id+'"></i>  </div>'+
                                      '  </div>'+
                                   ' </div>'+
                                '</div>';
                                 $("#sceduled").append(block);
                        
                    }else{
                        alert(response.message);
                    }
                
               });
              
          },
          accept: function(file, done) {
              
           
            var chosen = $(".chosen-select").val();
              
            if(chosen == null){
                  
                done("Please First Select Time slots");
              }
            else {
                done(); 
            }
          }
       
    });
       $(".chosen-select").change(function(){
       myDropzone.removeAllFiles(true); 
       Current_File = 1;
       var chosen = $(".chosen-select").val().length;
          if(chosen > 0 ){
          
           $(".dropzonewidget").fadeIn('slow');
       }
       if(chosen == 0){
          $(".dropzonewidget").hide();
       }
       
       
   });

  $(".chosen-select").chosen({
       no_results_text: "Oops, nothing found!"
      });
  
    $(document).on('click', '.delbulkone', function(){
        id = $(this).data('id');
        row = $("#card_"+id);
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this post again!",   
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
                        url: "<?php echo SITEURL;?>deleteinstagrambulkpost",
                        data: dataOBJ,
                        dataType: "json",
                        success: function(response){
                          if (response.status) {
                            row.remove();
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
                           swal("Error", "Nothing Has been deleted, please try again" , "error");
                        }
                      });    


        });
      })

});
           </script>