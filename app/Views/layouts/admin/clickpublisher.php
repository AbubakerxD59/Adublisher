
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Publishers Clicks Summary</h3>
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
                                                <th>User</th>
                                                <th>US</th>
                                                <th>UK</th>
                                                <th>Australia</th>
                                                <th>India</th>
                                                <th>Pakistan</th>
                                                <th>Other</th>
                                                <th>Total</th>
                                                <th>Earn</th>

                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                          <?php
                                              foreach ($users as $row) {
                                                  echo "<tr>
                                                  <td>".$row['id']."</td>
                                                  <td>
                                                  <img src='".$row['img']."' width='35' class='img-circle' alt='image'>
                                                  ".ucfirst($row['name'])."
                                                  </td>
                                                  <td>".$row['usa']."</td>
                                                  <td>".$row['uk']."</td>
                                                  <td>".$row['aus']."</td>
                                                  <td>".$row['ind']."</td>
                                                  <td>".$row['pak']."</td>
                                                  <td>".$row['other']."</td>
                                                  <td>".$row['total']."</td>
                                                  <td>$ ".$row['earn']."</td>
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
                    [9, 'desc']
                ],
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ]
        });
   });
</script>