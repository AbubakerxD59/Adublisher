
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Pay Publishers</h3>
                        
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
                                                <th>Total Earning</th>
                                                <th>Paid Amount</th>
                                                <th>Pending Amount</th>
                                                <th>Pay Now</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                          <?php
                                              foreach ($users as $row) {
                                                  
                                                  if($row['totalearn'] == 0){
                                                      continue;
                                                  }
                                                $pending =@ round($row['totalearn'] - $row['paidamount'],2);
                                                  if($pending == 0){
                                                      continue;
                                                  }
                                                  echo "<tr>
                                                  <td>".$row['id']."</td>
                                                  <td>
                                                  <img src='".$row['img']."' width='35' class='img-circle' alt='image'>
                                                  ".ucfirst($row['name'])."
                                                  </td>
                                                  <td>".$row['totalearn']."</td>
                                                  <td>".$row['paidamount']."</td>
                                                  <td>$ ". $pending  ."</td><td>";
                                                  if($pending > 0){

                                                    echo '<button type="button" class="btn waves-effect waves-light btn-primary  btn-sm pay-now" data-toggle="modal"  data-name="'.ucfirst($row['name']). "<br>Pending Amount is: $ ". $pending  .'" data-recordid="'.$row['id'].'" data-target="#paynow" ><i class="fa fa-plus"></i> Pay Now  </button>';
                                                  }
                                                  else{


                                                  }

                                                  echo "</td></tr>";
                                              }
                                          ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                              <div class="modal fade" id="paynow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Pay to Publisher</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                               <p>You are about Pay to <b><i class="title text-primary"></i></b> </p>
                                                <form>
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Amount $:</label>
                                                        <input class="form-control" type="number" min="0" id="amount" name="amount" />
                                                         <input style="display: none;" class="form-control" id="id" value="" type="ext" />
                                                    </div> 
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="payamount" class="btn btn-primary btn-ok" data-recordid="">Pay</button>
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
                    [2, 'desc']
                ],
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ]
        });
  


  $('#paynow').on('click', '#payamount', function(e) {
     
        var $modalDiv = $(e.delegateTarget);
        var id = $("#id").val();
        var amount = $("#amount").val();
         var dataOBJ = {
            'id': id ,
            'amount' : amount,
          }
        if(amount <= 0 || amount == "") {

          alertbox("Error" , "Please enter valid amount and try again." ,  "error");
          return false;
        } 
        else
          {
          $.ajax({
            type: "POST",
            url: "publisher_pay_rest",
            data: dataOBJ,
            dataType: "json",
            success: function(response) {
              if(response.status) {
                alertbox("Success" , "Amount Paid Successfully" ,  "success");
                setTimeout(function(){
                  location.reload();

                },2000)
               
              }
            },
            error: function() {
              alertbox("Error" , "Something Went Wrong. please try again after refresh page" ,  "error");
             
            }
          });
        }

    $modalDiv.modal('hide');

    });

    $('#paynow').on('show.bs.modal', function(e) {
    var data = $(e.relatedTarget).data();
    $('#amount').val("");
    $('.title', this).html(data.name);
    $('#id', this).val(data.recordid);
  });


 });
</script>