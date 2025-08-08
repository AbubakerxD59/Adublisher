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
                        <h2 class="text-center mt-4">Manage Affiliates</h2>
                        <p class="text-center">Add, Remove , Edit your affiliate members, Set PPC Rates for Individual
                            member <br> Restrict/Assign particular domain to affiliate and much more.<br>
                            <a href="#" class="add_affiliate_member" data-toggle="modal" data-target="#affiliateAdd"> <i
                                    class="fa fa-plus"></i> Add affiliate</a>
                        </p>
                        <div class="card simple-card">
                            <div class="row m-0 p-10">
                                <div class="col-md-12 p-3">
                                    <input id="myInput" type="text" placeholder="Search.." class="input pull-right">
                                    </h4>
                                    <br>
                                    <hr>
                                </div>
                                <?php
                                foreach ($users as $key => $row) {
                                    $pending = 0;
                                    $you = "";
                                    if ($user->id == $row->id) {
                                        $you = "<label class='label label-default text-info'>You</label>";
                                    }

                                    $status = "<label class='label label-default text-success'>Active</label>";
                                    if (trim($row->active) != "y") {
                                        $status = "<label class='label label-default text-danger'>Block</label>";

                                    }
                                    $pending = @($row->totalearn - $row->paid_amu);
                                    ?>
                                    <div class="col-md-4 filter" data-filter="<?= $row->fname . ' ' . $row->lname ?>">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-1"><i class="mdi mdi-account"></i>
                                                    <?= $row->fname . ' ' . $row->lname ?> <small><?= $you; ?></small>
                                                    <small><?= $status ?></small>
                                                </h4>
                                                <div class="row text-center">
                                                    <div class="col-lg-4 col-md-4 mt-3">
                                                        <h6 class="mb-0 font-weight-light">
                                                            $<?= @round($row->totalearn, 2); ?>
                                                        </h6><small class="text-black">Earning</small>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 mt-3">
                                                        <h6 class="mb-0 font-weight-light">
                                                            $<?= @round($row->paid_amu, 2); ?>
                                                        </h6><small class="text-black">Paid Amount</small>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 mt-3">
                                                        <h6 class="mb-0 font-weight-light ">$<?= @round($pending, 2); ?>
                                                        </h6>
                                                        <small class="text-black">Pending</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-white">
                                                <a href="<?= SITEURL ?>affiliate-manage?profile=<?= $row->id ?>"
                                                    class="btn btn-sm btn-outline-secondary">Manage</a>
                                                <?php
                                                if ($pending > 0) {
                                                    echo '<button type="button" class="btn btn-outline-secondary btn-sm pay-now pull-right" data-toggle="modal"  data-name="' . ucfirst($row->fname . ' ' . $row->lname) . "<br>Pending Amount is: $ " . $pending . '" data-recordid="' . $row->id . '" data-target="#paynow" > <i class="mdi mdi-coin"></i> Pay Now  </button>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="paynow" tabindex="-1" role="dialog" aria-labelledby="paynowModalLabel"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="paynowModalLabel">Pay to Affiliate</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <p>You are paying to <b><i class="title text-primary"></i></b> </p>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Amount $:</label>
                                <input class="form-control" type="number" min="0" id="amount" name="amount" />
                                <input style="display: none;" class="form-control" id="id" value="" type="ext" />
                                <p class="text-info"> Note: This is for record keeping, make sure to pay directly. </p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="payamount" class="btn btn-outline-secondary btn-ok" data-recordid="">
                            <i class="mdi mdi-coin"></i> Confirm payment</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="affiliateAdd" tabindex="-1" role="dialog" aria-labelledby="affiliateAddModalLabel1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="affiliateAddModalLabel1">Add New Affiliate</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" method="post" id="affiliatesignupform" action="#"
                            autocomplete="off">

                            <div class="row m-r-5">
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="name"> First Name</label>
                                        <input class="form-control" type="text" name="fname" id="fname" required
                                            placeholder="First Name" autocomplete="off"
                                            oninput="restrictToAlphabets('fname')">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-xs-12">
                                        <label for="name"> Last Name</label>
                                        <input class="form-control" type="text" name="lname" id="lname"
                                            placeholder="Last Name" autocomplete="off"
                                            oninput="restrictToAlphabets('lname')">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="username"> Username</label>
                                        <input class="form-control" type="text" name="username" id="username" required
                                            placeholder="Username" autocomplete="off"
                                            oninput="restrictToAlphabets('username')">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="email"> Email</label>
                                        <input class="form-control" type="text" name="email" id="email" required
                                            placeholder="Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-xs-12">
                                        <label for="Password"> Password</label>
                                        <input class="form-control" autocomplete="off" type="password" name="password"
                                            id="password" required autocomplete="new-password">
                                    </div>
                                </div>
                                <input type="hidden" name="timezone" id="timezone">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-secondary">Add Account</button>
                            </div>


                        </form>


                    </div>

                </div>
            </div>
        </div>

        <input type="hidden" id="SITEURL" value="<?= SITEURL ?>" />
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

    <?php $this->load->view('templates/publisher/footer'); ?>

    <script>
        $(document).ready(function () {

            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".filter").filter(function () {
                    $(this).toggle($(this).data('filter').toLowerCase().indexOf(value) > -1)
                });
            });

            $('#paynow').on('show.bs.modal', function (e) {
                var data = $(e.relatedTarget).data();
                $('#amount').val("");
                $('.title', this).html(data.name);
                $('#id', this).val(data.recordid);
            });
            $('#paynow').on('click', '#payamount', function (e) {

                var $modalDiv = $(e.delegateTarget);
                var id = $("#id").val();
                var amount = $("#amount").val();
                var dataOBJ = {
                    'id': id,
                    'amount': amount,
                }
                if (amount <= 0 || amount == "") {
                    alertbox("Error", "Please enter valid amount and try again.", "error");
                    return false;
                }
                else {
                    $.ajax({
                        type: "POST",
                        url: "affiliate_pay",
                        data: dataOBJ,
                        dataType: "json",
                        success: function (response) {
                            if (response.status) {
                                alertbox("Success", "Amount added successfully to affiliate account", "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 500)
                            }
                        },
                        error: function () {
                            alertbox("Error", "Something Went Wrong. please try again after refresh page", "error");
                        }
                    });
                }
                $modalDiv.modal('hide');

            });
            $("#timezone").val(Intl.DateTimeFormat().resolvedOptions().timeZone);
            $('#affiliatesignupform').submit(function (e) {
                // this code prevents form from actually being submitted
                e.preventDefault();
                e.returnValue = false;
                var email = $("#email").val();
                var username = $("#username").val();
                if (!validateEmail(email)) {
                    alertbox("Error", "Invalid Email", "error");
                    return false;
                }
                var SITEURL = $("#SITEURL").val();
                var form = $(this);
                // this is the important part. you want to submit
                // the form but only after the ajax call is completed
                $.ajax({
                    url: SITEURL + "affiliate_create_account",
                    async: false,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: form.serialize(),
                    success: function (response) {
                        if (response.status) {
                            swal({
                                title: "Success",
                                text: response.message,
                                type: "success",
                                timer: 3000,
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 500);

                        } else {
                            alertbox("Error", response.message, "error");
                        }
                    },
                    error: function () {
                        // your error handler
                        alertbox("Error", "Something went wrong. please try again", "error");
                    },
                    complete: function () {
                        // make sure that you are no longer handling the submit event; clear handler
                        // actually submit the form
                    }
                });
            });
        });
    </script>

    <script>
        function restrictToAlphabets(inputId) {
            var inputField = document.getElementById(inputId);
            inputField.value = inputField.value.replace(/[^A-Za-z]/g, '');
        }
    </script>