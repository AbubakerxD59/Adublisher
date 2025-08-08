<div class="card-body">
    <h2 class="text-center mt-2 m-b-0"> Personal info</h2>
    <p class="text-center text-muted">Update personal details like name, contact, timezone that you use on Adublisher.</p>
    <div class="row m-0 p-10">
        <div class="col-md-12">
            <div class="card view_form">
                <div class="card-body">
                    <form class="form-horizontal" id="user_profile_form">
                        <div class="form-body">
                            <h3 class="p-2 rounded-title d-flex justify-content-between">Personal Info
                                <button type="button" class="btn btn btn-outline-secondary pull-right edit_enable"> <i class="fa fa-pencil"></i> Edit</button>
                            </h3>
                            <hr class="mt-0 mb-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row justify-conten-center">
                                        <label class="control-label col-lg-3 col-6">First Name:</label>
                                        <div class="col-lg-9 col-6">
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $fname; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row justify-conten-center">
                                        <label class="control-label col-lg-3 col-6">Last Name:</label>
                                        <div class="col-lg-9 col-6">
                                            <input type="text" name="last_name" id="last_name" class="form-control" value=" <?php echo $lname; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group row justify-conten-center">
                                        <label class="control-label col-lg-3 col-6">Email: <i class='fa fa-lock'></i></label>
                                        <div class="col-lg-9 col-6">
                                            <input type="email" name="email" id="email" class="form-control" value=" <?php echo $email; ?>" disabled readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row justify-conten-center">
                                        <label class="control-label col-lg-3 col-6"> Username:</label>
                                        <div class="col-lg-9 col-6">
                                            <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row justify-conten-center">
                                        <label class="control-label col-lg-3 col-6">Phone Number:</label>
                                        <div class="col-lg-9 col-6">
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $ph; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row justify-conten-center">
                                        <label class="control-label col-lg-3 col-6">Time Zone:</label>
                                        <div class="col-lg-9 col-6">
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $gmt; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>