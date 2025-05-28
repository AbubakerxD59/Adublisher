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
                        <h2 class="text-center mt-4"> Notifications </h2>
                        <p class="text-center text-muted">Platform notifications area, you can check all notifications here</p>
                        <div class="row p-10 m-0">
                        <div class="col-md-12 col-xlg-12">
                        <div class="card">
                            <div class="card-body">
                               <div class="table-responsive">
                               <div class="message-box contact-box position-relative">
                                    <div class="message-widget contact-widget position-relative">
                                        <!-- notifications -->
                                     <?php
                                            foreach($notifications as $notif)
                                            {
                                            ?>
                                                <a href="#" class="py-3 px-2 border-bottom d-block text-decoration-none">
                                                    <div class="user-img position-relative d-inline-block mr-2">
                                                    <?php echo notification_icon($notif['type']); ?>
                                                    </div>
                                                    <div class="mail-contnet d-inline-block align-middle">
                                                    <div class="mail-desc" style="text-overflow: unset;overflow: inherit;white-space: inherit;"> <?=$notif['text']?></div>
                                                    <span class="mail-desc font-12 text-truncate overflow-hidden text-nowrap d-block"><?=$notif['publish_date'];?></span>
                                                    </div>
                                                </a>
                                          
                                            <?php
                                            }
                                            ?>
                                        </div>
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