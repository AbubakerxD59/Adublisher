


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
                <h3 class="text-themecolor">Dashboard</h3>
               
            </div>
            <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-tcontainer-fluid-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TOTAL PAID</small></h6>
                                    <h4 class="m-t-0 text-info">$ <?php echo round($widgets['total_paid'],2); ?></h4></div>
                               
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TOTAL UNPAID</small></h6>
                                    <h4 class="m-t-0 text-info">$ <?php

                                    $unpaid = bcsub($widgets['alltime_earning'],  $widgets['total_paid']);

                                     echo sprintf("%.2f", $unpaid); ?></h4></div>
                              
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>TOTAL EARNINGS</small></h6>
                                    <h4 class="m-t-0 text-primary">$ <?php echo round($widgets['alltime_earning'],2); ?></h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
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
     
       
         <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-info"><i class="mdi mdi-cursor-default-outline"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-light"><?=$widgets['todayclick']?></h3>
                                        <h5 class="text-muted m-b-0">Today's Clicks</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-currency-usd"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">$ <?=$widgets['todayearn']?></h3>
                                        <h5 class="text-muted m-b-0">Today's Earnings</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="mdi  mdi-arrow-up-bold-hexagon-outline"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">$ <?=$widgets['todayrpm']?></h3>
                                        <h5 class="text-muted m-b-0">Today's RPM</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="mdi mdi-dna"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?=$widgets['totalclick']?></h3>
                                        <h5 class="text-muted m-b-0">Total Clicks</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
         </div>

          <!-- Row -->
        <div class="row">

             <div class="col-md-6 col-xlg-6">
                    <!-- Column -->
                        <div class="card earning-widget">
                            <div class="card-header">
                                <div class="card-actions">
                                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                                 </div>
                                <h4 class="card-title m-b-0">Top Earners</h4>
                            </div>
                            <div class="card-body b-t collapse show" style="">
                                <table class="table v-middle no-border">
                                <tr>
                                    <th >User</th>
                                    <th>Clicks</th>
                                    <th>Earning</th>
                                </tr>
                                    <tbody>
                                         <?php 
                                           
                                                 foreach ($widgets['alltime_top_earning'] as $row)
                                                 {
                                                  echo '<tr>
                                                   <td>
                                                   <img src="'.$row['img'].'" width="35" class="img-circle" alt="image"> '.ucfirst($row['name']).'
                                                   </td>
                                                   <td>'.$row['c'].'</td>
                                                   <td>$ '.$row['e'].'</td>
                                                   </tr>';
                                                 }
                                            ?>
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            

        <div class="col-md-6 col-lg-6 col-xlg-6">
            <div class="ribbon-wrapper card">
                           <div class="row">
                         <div class="ribbon ribbon-bookmark  ribbon-primary ">Account manager</div>
                        <div class="col-md-4 col-lg-2 text-center">
                            <a href="app-contact-detail.html"><img src="http://localhost:82/adublisher/assets/general/images/users/1.jpg" alt="user" class="img-circle img-responsive"></a>
                        </div>
                        <div class="col-md-4 col-lg-5">
                            <h3 class="box-title m-b-0"><?=$acm->name?></h3>
                            <address>
                                <small class="text-muted fa fa-envelope-open-o">    <?=$acm->email?></small>
                                <small class="text-muted  fa  fa-phone">   <?=$acm->ph?></small>
                            </address>
                        </div>
                        <div class="col-md-4 col-lg-5">
                          
                            <address>
                                 <button class="btn btn-circle btn-secondary"><a href="tel:<?=$acm->ph?>" ><i class="fa fa-phone"></i></a></button>
                                  <button class="btn btn-circle btn-secondary"><a href="mailto:<?=$acm->email?>" ><i class="fa fa-envelope-open-o"></i></a></button>
                                <button class="btn btn-circle btn-secondary"><a href="<?=$acm->fbprofile?>" target="_blank"><i class="fa fa-facebook"></i></a></button>
                                <button class="btn btn-circle btn-secondary"><a href="skype:<?=$acm->skype?>" ><i class="fa fa-skype"></i></a></button>
                            </address>
                        </div>
                    </div>
              
            </div>
            </div>

           
        </div>
        <!-- Row -->
        <!-- Row -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
