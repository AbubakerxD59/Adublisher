
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
                       <h3 class="text-themecolor m-b-0 m-t-0">Articles</h3>
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=SITEURL?>dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Article </li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->                       
               <!-- ================================ ============================== -->
                            <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
               
                <div class="row">
                     <div class="col-md-12 col-xlg-12">
                      <div class="card">
                            <div class="card-body">

                                <div class="alert alert-info">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                            <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> What Does Status Mean ?</h3> <b><span class="badge badge-special badge-info"><i class="fa   fa-clock-o"></i> Pending</span></b> Your article is still not reviewed by Admin. <br /> 
                                            <b><span class="badge badge-special badge-warning"><i class="fa  fa-lock"></i> Approved</span></b> Your article is approved by admin and you can not change anything.<br>
                                            <b><span class="badge badge-special badge-danger"><i class="fa  fa-edit"></i> Rework</span></b> Your article needs improvements, you will get email and notification about suggestions or improvements.<br> 
                                            <b><span class="badge badge-special badge-success"><i class="fa  fa-check-circle-o"></i> Published</span></b> Your article is publised on website and your earning is started. you can not change anything once its published.
                                        </div>
                               <a class="btn btn-primary btn-sm pull-right m-b-5" href="<?=SITEURL?>createarticles"><i class="fa fa-plus"></i> New Article</a>
                                   <br>
                        <!-- <a href="<?=SITEURL;?>campaign_add" class="btn waves-effect waves-light btn-primary pull-right"><i class="fa fa-plus"></i> Add New  </a> -->
                       
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 60%;">Title</th>
                                                <th>Status </th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <tbody id="table-body">
                                            
                                           

                                            <?php

                                                foreach ($articles as $article) {
                                                    
                                                    echo "<tr id='".$article['id']."_row"."' >
                                                    <td>".$article['title']."</td>";
                                                    
                                                    echo "<td>";

                                                    echo article_badge($article['status']);

                                                    echo "</td>
                                                    <td>";
                                                    if($article['status'] != "published"){
                                                      
                                                      echo "<a target='_blank' href='preview/$article[id]' class='btn waves-effect waves-light btn-xs btn-primary text-white'><i class='fa fa-eye'></i> Preview</a>&nbsp;";
                                                    }

                                                    if($article['status'] == "pending" || $article['status'] == "rework"){
            
                          echo "<a target='_blank' href='".SITEURL.'edit_article/'.$article['id']."' class='btn waves-effect waves-light btn-xs btn-primary text-white'><i class='fa fa-pencil'></i> EDIT</a>
                                                    <button  id='".$article['id']."' class='del_article btn waves-effect waves-light btn-xs btn-danger' data-record-title='' data-toggle='modal' data-target='#confirm-delete' data-record-id=''><i class='fa fa-trash'></i> DELETE</button>";
                                                    }else if($article['status'] == "locked"){

                                                      // echo  "<i class='fa fa-lock'></i>";
                                                    }
                                                    else if($article['status'] == "published"){
                                                         echo "<a target='_blank' href='$article[article_wp_link]' class='btn waves-effect waves-light btn-xs btn-primary text-white'><i class='fa fa-link'></i> Visit Article</a>";
                                                    }


                                                    echo "</td>
                                                    </tr>";

                                                    
                                                }

                                            ?>
                                               
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
  <?php $this->load->view('templates/publisher/footer') ?>              
<script type="text/javascript">

 $(function(){


    $(document).on('click','.del_article',function(e)
    {

        var article = $(this).attr('id');
         e.preventDefault();

        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this article!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        }, function(){  

        $.ajax({

          url:"<?php echo SITEURL?>"+'delete_article',
          type:'GET',
          data :{'article_id' : article},
          success:function(data){
           
           $("#"+article+"_row").remove();
            swal("Deleted!", "Your article has been deleted.", "success"); 
            
          },
          error:function(data)
          {
            alertbox('error','something went wrong','error'); 
          }

         });

            
        });


       
        
    });
});

 </script>