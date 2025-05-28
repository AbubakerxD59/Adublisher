<style>
    .slimScrollDiv{
height:100%!important;
overflow-y:auto!important;
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
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card simple-card">
                    <div class="card-body">
                        <h2 class="text-center mt-4"> Announcements </h2>
                        <p class="text-center text-muted">Platform announcements area, you can check all announcements here</p>
                        <div class="row m-0 p-10">
                                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                            <div class="message-box contact-box position-relative">
                                    <div class="message-widget contact-widget position-relative">
                                        <!-- Message -->
                                     <?php
                                        $count = 0 ;
                                        ?>
                                       
                                            <?php
                                            $announces= publisher_annoucements();
                                            foreach($announces as $announces)
                                            {
                                                ?>
                                                <a href="#" class="py-3 px-2 border-bottom d-block text-decoration-none">
                                                    <div class="user-img position-relative d-inline-block mr-2">
                                                    <div class='btn btn-success btn-circle'><i class='fa fa-bullhorn'></i></div>  
                                                    </div>
                                                    <div class="mail-contnet d-inline-block align-middle">
                                                    <div class="mail-desc" style="text-overflow: unset;overflow: inherit;white-space: inherit;"> <?=$announces['text']?></div>
                                                    <span class="mail-desc font-12 text-truncate overflow-hidden text-nowrap d-block"><?=$announces['publish_date'];?></span>
                                                    </div>
                                                </a>
                                          
                                            <?php
                                            }?>
                                       
                                        </div>
                            </div>  
                            </div>    
                    </div>  
                    </div>
                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->

        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
 <?php $this->load->view('templates/publisher/footer'); ?>