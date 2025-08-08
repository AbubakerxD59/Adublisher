
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <style>
            .tooltip {
                position: absolute;
                display: none;
                padding: 5px;
                background-color: #333;
                color: white;
                border-radius: 5px;
                z-index: 1;
            }
            .justify-only {
                text-align: justify;
                letter-spacing: -0.6px;
                word-spacing: -0.6px;
                line-height: 1.5 !important;
            }
            .view-errors-style {
                text-align: justify;
                letter-spacing: -0.6px;
                word-spacing: -0.6px;
                line-height: 1.9 !important;
                background-color: yellow;
                padding: 4px 8px;
                border-radius: 10px;
            }
            .view_errors_style {
                text-align: justify;
                letter-spacing: -0.6px;
                word-spacing: -0.6px;
                line-height: 1.9 !important;
                background-color: yellow;
                padding: 4px 8px;
                border-radius: 10px;
            }

            .status-container {
                display: flex;
                justify-content: space-between;
            }

            span::before,
            span::after {
                content: "";
                display: inline-block;
                width: 10px;
                height: 10px;
                margin-right: 5px; /* Adjust the margin as needed */
            }

            #status-good::before {
                background-color: #198754; /* Color for status good */
            }

            #status-false::before {
                background-color: #dc3545; /* Color for status false */
            }


        </style>

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

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4 bg-light">
                                <h2 class="text-center mt-4"> Account Health : <strong id="create-post"></strong></h2>
                                <br>
                                <p class="text-center text-muted">Track your errors, bugs, and more to make Adublisher work better for you</p>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-4 bg-light">
                                <h2 class="text-center mt-4"> Account Stats </h2>
                                <center><div id="donut-chart"></div></center>
                                <div class="status-container">
                                    <span style="float: left; font-weight: 800;" id="status-good"></span>
                                    <span style="float: right; font-weight: 800;" id="status-false"></span>
                                </div>
                                    <!-- <div class="progress">
                                        <div id="healthProgressBar" style="background:#198754;" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <br>
                                    <div class="progress">
                                        <div id="lossProgressBar" style="background:#dc3545;" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> -->
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <br>
                        <!-- <h2 class="text-center mt-4"> Account Health : <strong id="create-post"></strong></h2> -->
                        <!-- <h2 class="text-center mt-4"> Account Health <div id="donut-chart"></div></h2> -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab1" data-toggle="tab" href="#table1">Create Post Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab2" data-toggle="tab" href="#table2">Rss Feed Logs</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- Tab 1 Content -->
                            <div id="table1" class="container tab-pane active table-responsive-lg">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">No#</th>
                                            <th style="width:17%;">Name</th>
                                            <th style="width:8%;">Date</th>
                                            <th style="width:65%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; $successCount = 0; foreach($get_connected_channels['fbpages'] as $fbpages):?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><img style='width:25px;height:25px;margin-top:-3px;' src='<?= GeneralAssets ?>images/facebook_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Facebook Page'>&nbsp;<?php echo $fbpages['page_name'];?></td>
                                            <td><?php echo $fbpages['date'];?></td>
                                            <td><?php if($fbpages['error'] == 'Looks Good'){
                                                   echo '<span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">'. $fbpages['error'].'</span>';
                                                   $successCount++;
                                                } else {
                                                    echo '<p class="justify-only" style="background-color:red; color:white; padding: 4px 8px; border-radius: 10px;">'.$fbpages['error'].'</p>';
                                                }?>   
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                        <?php foreach($get_connected_channels['boards'] as $boards):?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><img style='width:25px;height:25px;margin-top:-3px;' src='<?= GeneralAssets ?>images/pinterest_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Pinterest Board'>&nbsp;<?php echo $boards['name'];?></td>
                                            <td><?php echo $boards['date'];?></td>
                                            <td><?php if($boards['error'] == 'Looks Good'){
                                                   echo '<span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">'. $boards['error'].'</span>';
                                                   $successCount++;
                                                } else {
                                                    echo '<p class="justify-only" style="background-color:red; color:white; padding: 4px 8px; border-radius: 10px;">'.$boards['error'].'</p>';
                                                }?>   
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                        <?php foreach($get_connected_channels['ig_accounts'] as $ig_accounts):?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><img style='width:18px;height:18px;margin-left:3.5px;margin-top:-3px;' src='<?= GeneralAssets ?>images/instagram_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Instagram Account'>&nbsp;&nbsp;<?php echo $ig_accounts['instagram_username'];?></td>
                                            <td><?php echo $ig_accounts['date'];?></td>
                                            <td><?php if($ig_accounts['error'] == 'Looks Good'){
                                                   echo '<span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">'. $ig_accounts['error'].'</span>';
                                                   $successCount++;
                                                } else {
                                                    echo '<p class="justify-only" style="background-color:red; color:white; padding: 4px 8px; border-radius: 10px;">'.$ig_accounts['error'].'</p>';
                                                }?>   
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                        <?php foreach($get_connected_channels['fb_groups'] as $fb_groups):?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><img style='width:18px;height:18px;margin-left:3.5px;margin-top:-3px;' src='<?= GeneralAssets ?>images/fb_group_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Facebook Group'>&nbsp;&nbsp;<?php echo $fb_groups['name'];?></td>
                                            <td><?php echo $fb_groups['date'];?></td>
                                            <td><?php if($fb_groups['error'] == 'Looks Good'){
                                                   echo '<span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">'. $fb_groups['error'].'</span>';
                                                   $successCount++;
                                                } else {
                                                    echo '<p class="justify-only" style="background-color:red; color:white; padding: 4px 8px; border-radius: 10px;">'.$fb_groups['error'].'</p>';
                                                }?>   
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach;?>
                                        <?php
                                            $totalCount = $i - 1;
                                            $successCount;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tab 2 Content -->
                            <div id="table2" class="container tab-pane fade table-responsive-lg">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">No#</th>
                                            <th style="width:20%;">Name</th>
                                            <th style="width:10%;">Date</th>
                                            <th style="width:15%;">Url</th>
                                            <th style="width:50%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $totalCountRss = 0;
                                        $successCountRss = 0;
                                        foreach($get_connected_channels['fbpages'] as $fbpages):
                                            $modalIdFbPages = 'errorModal_' . $i; // Generate a unique ID for each modal
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img style='width:25px;height:25px;margin-top:-3px;' src='<?= GeneralAssets ?>images/facebook_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Facebook Page'>&nbsp;<?php echo $fbpages['page_name'];?>
                                                </td>
                                                <?php
                                                if (!empty($fbpages['rss_error_array'])) {
                                                    foreach ($fbpages['rss_error_array'] as $solo) {
                                                        if ($solo['rss_error'] == 'Looks Good') {
                                                            echo '<td><span>' . $solo['rss_date'] . '</span></td>
                                                                      <td>' . $solo['url'] . '</td>
                                                                      <td><span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">' . $solo['rss_error'] . '</span></td>';
                                                            $successCountRss++;
                                                        } else {
                                                            $rowData = [
                                                                'date' => $solo['rss_date'],
                                                                'url' => $solo['url'],
                                                                'status' => $solo['rss_error']
                                                            ];
                                                            $errorData[$modalIdFbPages][] = $rowData;
                                                            $elseerrors[] = $rowData;
                                                            // Output nothing in the table for other conditions
                                                        }
                                                    }
                                                    if(!empty($elseerrors)){
                                                        echo '<td></td>
                                                            <td></td>
                                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$modalIdFbPages.'">View Errors</button></td>';
                                                    }
                                                }
                                                ?>
                                            </tr>

                                            <?php if (!empty($errorData[$modalIdFbPages])) : ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?= $modalIdFbPages ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $modalIdFbPages ?>Label" aria-hidden="true">
                                                    <div style="max-width: 1140px;" class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?= $modalIdFbPages ?>Label">Error Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-none d-md-block">
                                                                    <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                        <div class="col-xl-1 col-lg-2 col-md-2">Date</div>
                                                                        <div class="col-xl-4 col-lg-4 col-md-4">Url</div>
                                                                        <div class="col-xl-7 col-lg-6 col-md-6">Status</div>
                                                                    </div>
                                                                    <?php foreach ($errorData[$modalIdFbPages] as $row) : ?>
                                                                        <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <div class="col-xl-1 col-lg-2 col-md-2"><p class="view-errors-style"><?= $row['date'] ?></p></div>
                                                                            <div class="col-xl-4 col-lg-4 col-md-4"><p class="view-errors-style"><?= $row['url'] ?></p></div>
                                                                            <div class="col-xl-7 col-lg-6 col-md-6"><p style="background:red; color:white;" class="view-errors-style"><?= $row['status'] ?></p></div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                                <div class="d-block d-md-none">
                                                                    <?php foreach ($errorData[$modalIdFbPages] as $row) : ?>
                                                                        <div class="p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <strong>Date:</strong>&nbsp;<span class="view_errors_style"><?= $row['date'] ?></span>
                                                                            <br>
                                                                            <strong>Url:</strong><br><p class="view_errors_style"><?= $row['url'] ?></p>
                                                                            <br>
                                                                            <strong>Status:</strong><br><p class="view_errors_style" style="background:red; color: white;"><?= $row['status'] ?></p>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php
                                            $i++;
                                            $elseerrors = null;
                                        endforeach;
                                        ?>

                                        <?php
                                        foreach($get_connected_channels['boards'] as $boards):
                                            $modalIdPinterest = 'errorModal_' . $i; // Generate a unique ID for each modal
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img style='width:25px;height:25px;margin-top:-3px;' src='<?= GeneralAssets ?>images/pinterest_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Pinterest Board'>&nbsp;<?php echo $boards['name'];?>
                                                </td>
                                                <?php
                                                if (!empty($boards['rss_error_array'])) {
                                                    foreach ($boards['rss_error_array'] as $solo) {
                                                        if ($solo['rss_error'] == 'Looks Good') {
                                                            echo '<td><span>' . $solo['rss_date'] . '</span></td>
                                                                      <td>' . $solo['url'] . '</td>
                                                                      <td><span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">' . $solo['rss_error'] . '</span></td>';
                                                            $successCountRss++;
                                                        } else {
                                                            $rowData = [
                                                                'date' => $solo['rss_date'],
                                                                'url' => $solo['url'],
                                                                'status' => $solo['rss_error']
                                                            ];
                                                            $errorData[$modalIdPinterest][] = $rowData;
                                                            $elseerrors[] = $rowData;
                                                            // Output nothing in the table for other conditions
                                                        }
                                                    }
                                                    if(!empty($elseerrors)){
                                                        echo '<td></td>
                                                            <td></td>
                                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$modalIdPinterest.'">View Errors</button></td>';
                                                    }
                                                }
                                                ?>
                                            </tr>

                                            <?php if (!empty($errorData[$modalIdPinterest])) : ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?= $modalIdPinterest ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $modalIdPinterest ?>Label" aria-hidden="true">
                                                    <div style="max-width: 1140px;" class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?= $modalIdPinterest ?>Label">Error Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-none d-md-block">
                                                                    <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                        <div class="col-xl-1 col-lg-2 col-md-2">Date</div>
                                                                        <div class="col-xl-4 col-lg-4 col-md-4">Url</div>
                                                                        <div class="col-xl-7 col-lg-6 col-md-6">Status</div>
                                                                    </div>
                                                                    <?php foreach ($errorData[$modalIdPinterest] as $row) : ?>
                                                                        <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <div class="col-xl-1 col-lg-2 col-md-2"><p class="view-errors-style"><?= $row['date'] ?></p></div>
                                                                            <div class="col-xl-4 col-lg-4 col-md-4"><p class="view-errors-style"><?= $row['url'] ?></p></div>
                                                                            <div class="col-xl-7 col-lg-6 col-md-6"><p style="background:red; color:white;" class="view-errors-style"><?= $row['status'] ?></p></div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                                <div class="d-block d-md-none">
                                                                    <?php foreach ($errorData[$modalIdPinterest] as $row) : ?>
                                                                        <div class="p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <strong>Date:</strong>&nbsp;<span class="view_errors_style"><?= $row['date'] ?></span>
                                                                            <br>
                                                                            <strong>Url:</strong><br><p class="view_errors_style"><?= $row['url'] ?></p>
                                                                            <br>
                                                                            <strong>Status:</strong><br><p class="view_errors_style" style="background:red; color: white;"><?= $row['status'] ?></p>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php
                                            $i++;
                                            $elseerrors = null;
                                        endforeach;
                                        ?>

                                        <?php
                                        foreach($get_connected_channels['ig_accounts'] as $ig_accounts):
                                            $modalIdInsta = 'errorModal_' . $i; // Generate a unique ID for each modal
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img style='width:18px;height:18px;margin-left:3.5px;margin-top:-3px;' src='<?= GeneralAssets ?>images/instagram_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Instagram Account'>&nbsp;&nbsp;<?php echo $ig_accounts['instagram_username'];?>
                                                </td>
                                                <?php
                                                if (!empty($ig_accounts['rss_error_array'])) {
                                                    foreach ($ig_accounts['rss_error_array'] as $solo) {
                                                        if ($solo['rss_error'] == 'Looks Good') {
                                                            echo '<td><span>' . $solo['rss_date'] . '</span></td>
                                                                      <td>' . $solo['url'] . '</td>
                                                                      <td><span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">' . $solo['rss_error'] . '</span></td>';
                                                            $successCountRss++;                                                       
                                                        } else {
                                                            $rowData = [
                                                                'date' => $solo['rss_date'],
                                                                'url' => $solo['url'],
                                                                'status' => $solo['rss_error']
                                                            ];
                                                            $errorData[$modalIdInsta][] = $rowData;
                                                            $elseerrors[] = $rowData;
                                                            // Output nothing in the table for other conditions
                                                        }
                                                    }
                                                    if(!empty($elseerrors)){
                                                        echo '<td></td>
                                                            <td></td>
                                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$modalIdInsta.'">View Errors</button></td>';
                                                    }
                                                }
                                                ?>
                                            </tr>

                                            <?php if (!empty($errorData[$modalIdInsta])) : ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?= $modalIdInsta ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $modalIdInsta ?>Label" aria-hidden="true">
                                                    <div style="max-width: 1140px;" class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?= $modalIdInsta ?>Label">Error Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-none d-md-block">
                                                                    <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                        <div class="col-xl-1 col-lg-2 col-md-2">Date</div>
                                                                        <div class="col-xl-4 col-lg-4 col-md-4">Url</div>
                                                                        <div class="col-xl-7 col-lg-6 col-md-6">Status</div>
                                                                    </div>
                                                                    <?php foreach ($errorData[$modalIdInsta] as $row) : ?>
                                                                        <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <div class="col-xl-1 col-lg-2 col-md-2"><p class="view-errors-style"><?= $row['date'] ?></p></div>
                                                                            <div class="col-xl-4 col-lg-4 col-md-4"><p class="view-errors-style"><?= $row['url'] ?></p></div>
                                                                            <div class="col-xl-7 col-lg-6 col-md-6"><p style="background:red; color:white;" class="view-errors-style"><?= $row['status'] ?></p></div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                                <div class="d-block d-md-none">
                                                                    <?php foreach ($errorData[$modalIdInsta] as $row) : ?>
                                                                        <div class="p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <strong>Date:</strong>&nbsp;<span class="view_errors_style"><?= $row['date'] ?></span>
                                                                            <br>
                                                                            <strong>Url:</strong><br><p class="view_errors_style"><?= $row['url'] ?></p>
                                                                            <br>
                                                                            <strong>Status:</strong><br><p class="view_errors_style" style="background:red; color: white;"><?= $row['status'] ?></p>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php
                                            $i++;
                                            $elseerrors = null;
                                        endforeach;
                                        ?>

                                        <?php
                                        foreach ($get_connected_channels['fb_groups'] as $fb_groups) :
                                            $modalIdFbgroup = 'errorModal_' . $i; // Generate a unique ID for each modal
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img style='width:18px;height:18px;margin-left:3.5px;margin-top:-3px;' src='<?= GeneralAssets ?>images/fb_group_logo.png' class='rounded' alt='profile_pic' data-toggle='popover' data-content='Facebook Group'>&nbsp;&nbsp;<?php echo $fb_groups['name']; ?>
                                                </td>
                                                <?php
                                                if (!empty($fb_groups['rss_error_array'])) {
                                                    foreach ($fb_groups['rss_error_array'] as $solo) {
                                                        if ($solo['rss_error'] == 'Looks Good') {
                                                            echo '<td><span>' . $solo['rss_date'] . '</span></td>
                                                                      <td>' . $solo['url'] . '</td>
                                                                      <td><span style="background-color:#28a745; color:white; padding: 4px 10px; border-radius: 10px;">' . $solo['rss_error'] . '</span></td>';
                                                            $successCountRss++;
                                                        } else {
                                                            $rowData = [
                                                                'date' => $solo['rss_date'],
                                                                'url' => $solo['url'],
                                                                'status' => $solo['rss_error']
                                                            ];
                                                            $errorData[$modalIdFbgroup][] = $rowData;
                                                            $elseerrors[] = $rowData;
                                                            // Output nothing in the table for other conditions
                                                        }
                                                    }
                                                    if(!empty($elseerrors)){
                                                        echo '<td></td>
                                                            <td></td>
                                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$modalIdFbgroup.'">View Errors</button></td>';
                                                    }
                                                }
                                                ?>
                                            </tr>

                                            <?php if (!empty($errorData[$modalIdFbgroup])) : ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?= $modalIdFbgroup ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $modalIdFbgroup ?>Label" aria-hidden="true">
                                                    <div style="max-width: 1140px;" class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?= $modalIdFbgroup ?>Label">Error Details</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-none d-md-block">
                                                                    <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                        <div class="col-xl-1 col-lg-2 col-md-2">Date</div>
                                                                        <div class="col-xl-4 col-lg-4 col-md-4">Url</div>
                                                                        <div class="col-xl-7 col-lg-6 col-md-6">Status</div>
                                                                    </div>
                                                                    <?php foreach ($errorData[$modalIdFbgroup] as $row) : ?>
                                                                        <div class="row p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <div class="col-xl-1 col-lg-2 col-md-2"><p class="view-errors-style"><?= $row['date'] ?></p></div>
                                                                            <div class="col-xl-4 col-lg-4 col-md-4"><p class="view-errors-style"><?= $row['url'] ?></p></div>
                                                                            <div class="col-xl-7 col-lg-6 col-md-6"><p style="background:red; color:white;" class="view-errors-style"><?= $row['status'] ?></p></div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                                <div class="d-block d-md-none">
                                                                    <?php foreach ($errorData[$modalIdFbgroup] as $row) : ?>
                                                                        <div class="p-2" style="border-bottom: 1px solid #d0d0d0;">
                                                                            <strong>Date:</strong>&nbsp;<span class="view_errors_style"><?= $row['date'] ?></span>
                                                                            <br>
                                                                            <strong>Url:</strong><br><p class="view_errors_style"><?= $row['url'] ?></p>
                                                                            <br>
                                                                            <strong>Status:</strong><br><p class="view_errors_style" style="background:red; color: white;"><?= $row['status'] ?></p>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php
                                            $i++;
                                            $elseerrors = null;
                                        endforeach;
                                        ?>
                                        <?php
                                            $totalCountRss = $i -1;
                                            $successCountRss;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Tab panes End-->

                    </div><!--col-md-12-->
                </div><!--row-->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Add Bootstrap and jQuery scripts if not already included -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


            <script>
                // Ensure that Bootstrap and jQuery scripts are loaded before this script
                $(document).ready(function () {
                    // Clear the modal content when it is hidden
                    $('[id^="errorModal_"]').on('hidden.bs.modal', function () {
                        $(this).removeData('bs.modal');
                    });
                });
            </script>
            <script>
                $(document).ready(function () {
                    $('[data-toggle="popover"]').popover({
                        trigger: 'hover',
                        placement: 'top',
                        html: true
                    });
                });
            </script>
            <script>
            // Script to handle tab switching
                $(document).ready(function () {
                    $('#myTabs a').click(function (e) {
                        e.preventDefault()
                        $(this).tab('show')
                    })
                });
            </script>

            <script>
            $(document).ready(function () {
                // Initialize counts with data from PHP
                var totalCountTab1 = <?php echo $totalCount; ?>;
                var successCountTab1 = <?php echo $successCount; ?>;
                var totalCountTab2 = <?php echo $totalCountRss; ?>;
                var successCountTab2 = <?php echo $successCountRss; ?>;
                
                // Declare myDoughnutChart globally
                var myDoughnutChart;

                // Function to calculate and update the percentage and donut chart
                function updatePercentage(tab) {
                    var totalCount, successCount;
                    if (tab === 'tab1') {
                        totalCount = totalCountTab1;
                        successCount = successCountTab1;
                    } else if (tab === 'tab2') {
                        totalCount = totalCountTab2;
                        successCount = successCountTab2;
                    }

                    var AccountHealthPercentage = parseFloat(((successCount / totalCount) * 100).toFixed(2));
                    var AccountHealthLostPerc = parseFloat((100 - AccountHealthPercentage).toFixed(2));
                    var AccountHealthPercentage = parseFloat(((successCount / totalCount) * 100).toFixed(2));
                    var AccountHealthLostPerc = parseFloat((100 - AccountHealthPercentage).toFixed(2));

                    // Update the content of the spans with the calculated values
                    document.getElementById("status-good").innerText ="Good" + ": " + AccountHealthPercentage + "%";
                    document.getElementById("status-false").innerText ="Bad" + ": " + AccountHealthLostPerc + "%";


                    // Update background color and text color based on conditions
                    // var HealthColor;
                    // if (AccountHealthPercentage >= 85) {
                    //     HealthColor = '#28a745';
                    // } else if (AccountHealthPercentage >= 70) {
                    //     HealthColor = '#28a254';
                    // } else if (AccountHealthPercentage >= 50) {
                    //     HealthColor = '#ffc107';
                    // } else {
                    //     HealthColor = '#17a2b8';
                    // }

                    // var LossColor;
                    // if (AccountHealthLostPerc >= 85) {
                    //     LossColor = '#28a745';
                    // } else if (AccountHealthLostPerc >= 70) {
                    //     LossColor = '#28a254';
                    // } else if (AccountHealthLostPerc >= 50) {
                    //     LossColor = '#ffc107';
                    // } else {
                    //     LossColor = '#17a2b8';
                    // }

                    // Update donut chart with dynamic values
                    var options = {
                        chart: {
                            width: 130,
                            type: "donut" // Change the chart type to "circle"
                        },
                        // colors: [LossColor, HealthColor], // Swap the positions of colors
                        colors: ["#dc3545", "#198754"], // Swap the positions of colors
                        dataLabels: {
                            enabled: false
                        },
                        series: [AccountHealthLostPerc, AccountHealthPercentage], // Swap the positions of percentages
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function (val) {
                                    return val + "%"
                                },
                                title: {
                                    formatter: function (seriesName) {
                                        return ''
                                    }
                                }
                            }
                        },
                        legend: {
                            show: false
                        }
                    };

                    // Render or update the chart
                    if (!myDoughnutChart) {
                        myDoughnutChart = new ApexCharts(document.querySelector("#donut-chart"), options);
                        myDoughnutChart.render();
                    } else {
                        myDoughnutChart.updateOptions(options);
                    }
                }

                // Handle tab change event
                $('#myTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var activeTab = $(e.target).attr('id');
                    updatePercentage(activeTab);
                });

                // Call updatePercentage with the initial tab value (tab1)
                updatePercentage('tab1');
            });
            </script>



            <script>
                $(document).ready(function () {
                    // Initialize counts with data from PHP
                    var totalCountTab1 = <?php echo $totalCount; ?>;
                    var successCountTab1 = <?php echo $successCount; ?>;
                    var totalCountTab2 = <?php echo $totalCountRss; ?>;
                    var successCountTab2 = <?php echo $successCountRss; ?>;

                    // Function to calculate and update the percentage and apply text classes
                    function updatePercentage(tab) {
                        var totalCount, successCount;
                        if (tab === 'tab1') {
                            totalCount = totalCountTab1;
                            successCount = successCountTab1;
                        } else if (tab === 'tab2') {
                            totalCount = totalCountTab2;
                            successCount = successCountTab2;
                        }

                        var overallPercentage = (successCount / totalCount) * 100;
                        $('#create-post').html(overallPercentage.toFixed(2) + '%');

                        // Apply Bootstrap text classes based on percentage
                        var textClass = '';
                        if (overallPercentage >= 85) {
                            textClass = 'text-success bg-white p-1 rounded';
                        } else if (overallPercentage >= 70) {
                            textClass = 'text-info bg-dark p-1 rounded';
                        } else if (overallPercentage >= 50) {
                            textClass = 'text-warning bg-dark p-1 rounded';
                        } else {
                            textClass = 'text-danger bg-white p-1 rounded';
                        }

                        // Update the text class on the element
                        $('#create-post').removeClass('text-success text-info text-warning text-danger').addClass(textClass);
                    }

                    // Handle tab change event
                    $('#myTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                        var activeTab = $(e.target).attr('id');
                        updatePercentage(activeTab);
                    });

                    // Initial update for the default active tab
                    var defaultActiveTab = $('#myTabs .active').attr('id');
                    updatePercentage(defaultActiveTab);
                });
            </script>

<?php 
$this->load->view('templates/publisher/footer');
?>
