<script>
    function previewFile(input) {
        var file = $("input[type=file]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            console.log(reader.result);
            reader.onload = function () {
                $("#cpimagec").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
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
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12 col-xlg-12">


                <div class="card simple-card">
                    <div class="card-body">

                        <h2 class="text-center mt-2 m-b-0"> Add new campaign</h2>
                        <p class="text-center text-muted m-b-0">
                        <div class="row p-10 m-0">
                            <div class="col-md-12">
                                <div class="card simple-card">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#standard"
                                                role="tab" aria-selected="true"> <span class=""> Add Standard Campaign
                                                    (Link Base)</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                                                href="#customimage" role="tab" aria-selected="false"><span class="">Add
                                                    Custom Campaign (Image and Link)</span></a> </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane" id="standard" role="tabpanel">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form class="form" id="formdata">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="form-group m-t-10">
                                                                    <label class="m-t-5">Paste campaign/article
                                                                        Link</label>
                                                                    <input class="form-control" name="cpuspc" required
                                                                        id="cpuspc" type="text">
                                                                    <small class="text-center text-muted">Paste link of
                                                                        your blog campaign, and title and image will be
                                                                        automatically fetched.</small>
                                                                </div>
                                                                <div class="form-group m-t-10">
                                                                    <label class="m-t-5">Title</label>
                                                                    <input class="form-control" name="cpname"
                                                                        id="cpname" required type="text">
                                                                </div>
                                                                <div class="form-group m-t-10">
                                                                    <label class="m-t-5">Image Link</label>
                                                                    <input class="form-control" name="cpimg" id="cpimg"
                                                                        required type="text">
                                                                    <input name="user_id" id="user_id" type="hidden"
                                                                        value="<?= App::Session()->get('userid'); ?>">
                                                                    <input name="c_type" id="c_type" type="hidden"
                                                                        value="1">
                                                                </div>
                                                                <div class="row pr-2">
                                                                    <div class="form-group col-md-6 m-t-10">
                                                                        <label class="m-t-5">Status</label>
                                                                        <select name="cpstatus" class="form-control"
                                                                            required>
                                                                            <option value="">Select</option>
                                                                            <option value="enable" selected>Enable
                                                                            </option>
                                                                            <option value="disable">Disable</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6 m-t-10">
                                                                        <label class="m-t-5">Category</label>
                                                                        <select name="cpcat" class="form-control"
                                                                            required>
                                                                            <option value="">Select</option>
                                                                            <?php

                                                                            foreach ($categories as $row) {
                                                                                echo '<option value="' . $row->id . '">' . $row->categury . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group m-t-10">
                                                                    <label class="m-t-5">Thumbnail Image</label>
                                                                    <img style="height:300px;"
                                                                        class="img-responsive responsive" id="cpimage"
                                                                        src="assets/general/images/placeholder.png">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <button class="btn btn-outline-primary" type="submit"><i
                                                                        class="fa fa-floppy-o"></i> Save
                                                                    Campaign</button>
                                                            </div>
                                                            <div class="form-group col-md-6 m-t-10 hide">
                                                                <label class="m-b-0">Star</label>
                                                                <select name="star" class="form-control">
                                                                    <option value="false">No</option>
                                                                    <option value="true">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane active" id="customimage" role="tabpanel">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form class="form" id="formdatac" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="row pr-2">
                                                                    <div class="form-group m-t-10 col-md-12">
                                                                        <label class="m-t-5">Caption</label>
                                                                        <textarea class="form-control" name="cpname"
                                                                            required id="cpnamec"
                                                                            style=" height: 50px; "></textarea>
                                                                        <small class="text-center text-muted"> Paste
                                                                            Caption/Link (Link must have this format |
                                                                            https://www.websitename.com | or start with
                                                                            | https://)</small>
                                                                        <input name="user_id" type="hidden"
                                                                            value="<?= App::Session()->get('userid'); ?>">
                                                                        <input name="c_type" type="hidden" value="2">
                                                                    </div>


                                                                    <div class="form-group col-md-12">
                                                                        <label class="m-t-5">Status</label>
                                                                        <select name="cpstatus" class="form-control"
                                                                            required>
                                                                            <option value="">Select</option>
                                                                            <option value="enable" selected>Enable
                                                                            </option>
                                                                            <option value="disable">Disable</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <label class="m-t-5">Category</label>
                                                                        <select name="cpcat" class="form-control"
                                                                            required>
                                                                            <option value="">Select</option>
                                                                            <?php
                                                                            foreach ($categories as $row) {
                                                                                echo '<option value="' . $row->id . '">' . $row->categury . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group m-t-10">
                                                                    <label class="m-t-5">Thumbnail Image</label>
                                                                    <input type="file" name="photo" id="photo"
                                                                        onchange="previewFile(this);" required>
                                                                    <img style="height:300px;"
                                                                        class="img-responsive responsive" id="cpimagec"
                                                                        src="assets/general/images/placeholder.png">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <button class="btn btn-outline-primary" type="submit"><i
                                                                        class="fa fa-floppy-o"></i> Save
                                                                    Campaign</button>
                                                            </div>
                                                            <div class="form-group col-md-6 m-t-10 hide">
                                                                <label class="m-b-0">Star</label>
                                                                <select name="star" class="form-control">
                                                                    <option value="false">No</option>
                                                                    <option value="true">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
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
                        <?php $this->load->view('templates/publisher/footer'); ?>
                        <script src="<?= PublisherAssets ?>js/campaign_add.js"></script>