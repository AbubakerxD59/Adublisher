
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
                <div>
                    <div>
                        <div class="card simple-card">
                            <div class="card-body">
                                <!-- <h2 class="text-center mt-4">Affiliate dashboard </h2>
                                <p class="text-center text-muted">Manage your affiliate marketing rates, build affiliates team, manage team and much more.</p> -->
                                <div class="row m-0 p-10">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="mdi mdi-account-multiple"></i> Manage affiliates</h4>
                                                <p class="card-text">Always add highly productive affiliates to promote your campaigns, its key for success.</p>
                                                <a href="<?=SITEURL?>affiliate-team" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="mdi mdi-coin"></i> Manage ppc rates</h4>
                                                <p class="card-text">You can set default pay per click rates with for your all affiliates, also you can customize.</p>
                                                <a href="<?=SITEURL?>affiliate-manage-ppc-rates" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-external-link"></i> Redirect link settings</h4>
                                                <p class="card-text">Redirect or direct link settings for your affiliates, select domain in case of redirect. <a href="#">Learn more</a></p>
                                                <a href="<?=SITEURL?>affiliate-redirect-links" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-globe"></i>  Redirect domains</h4>
                                                <p class="card-text">You must provide us domains to be used for redirect for campaigns links. <a href="#">Learn more</a></p>
                                                <a href="<?=SITEURL?>affiliate-manage-redirect-domain" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-signal"></i>  Analytics domains</h4>
                                                <p class="card-text">Domains to be used for calculating traffic via google analytics. <a href="#">Learn more</a></p>
                                                <a href="<?=SITEURL?>affiliate-manage-analytics-domain" class="btn btn-outline-secondary">Goto page</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><i class="fa fa-pie-chart"></i> Traffic Summary</h4>
                                                <p class="card-text">Traffic summary for your account, Filter by date, affiliate, country and campaigns.</p>
                                                <a href="<?=SITEURL?>affiliate-traffic-summary" class="btn btn-outline-secondary">Goto page</a>
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
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
<?php
$this->load->view('templates/publisher/footer');
?>
