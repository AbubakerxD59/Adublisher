
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Weekly Earning Summary</h3>
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
                  
                     <div class="col-md-12 col-xlg-12">
                      <div class="card">
                            <div class="card-body">
                             
                                <div class="table-responsive m-10">
                                    <table id="myTable" class="table table-bordered">
                                        <thead>
                                            <tr>

                                                <th>ID</th>
                                                <th style="min-width:200px;">User</th>
                                                <th>Current Week</th>
                                                <th>Last 1st Week</th>
                                                <th>Last 2nd Week</th>
                                                <th>Last 3rd Week</th>
                                                <th>Last 4th Week</th>
                                                <th>Total Earning</th>
                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                              foreach ($users as $row) {
                                                  echo "<tr>
                                                  <td>".$row['id']."</td>
                                                  <td>
                                                  <img src='".$row['img']."' width='35' class='img-circle' alt='image'>
                                                  ".ucfirst($row['name'])."
                                                  </td>
                                                  <td> ".$row['currentWeek']."</td>
                                                  <td> ".$row['week2']."</td>
                                                  <td> ".$row['week3']."</td>
                                                  <td> ".$row['week4']."</td>
                                                  <td> ".$row['week5']."</td>
                                                  <td> ".$row['totalearn']."</td>
                                                
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

                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
             
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
 <?php $this->load->view('templates/admin/footer'); ?>

 <script src="<?=GeneralAssets ?>plugins/datatables/jquery.dataTables.min.js"></script>
 
<script>
    $(document).ready(function() {
        $('#myTable').DataTable( 
        {
            "displayLength": 100,
            "order": [
                    [7, 'desc']
                ],
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ]
        });
   });
</script>