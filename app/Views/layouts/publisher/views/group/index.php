<div class="row">
    <div class="col-md-12">
        <?php
        if (sizeof($user_pages) > 0) {
        ?>
            <div class="card with-chrisbg d-none">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa fa-calendar"></i> INTRODUCING EVENTS
                        GROUPING</h4>
                    <p class="card-text">In this feature you can create events by selecting start
                        and end dates. now upload images which will be scheduled between the start
                        and end dates. In this way you can plan whole year posting in few minutes.
                    </p>
                </div>
            </div>
            <div class="card with-chrisbg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title mb-1">Facebook Page <small><i
                                        class="mdi mdi-help-circle-outline" data-toggle="tooltip"
                                        data-placement="bottom" title=""
                                        data-original-title="Select facebook page, your page must have published status on facebook, and you must have admin level permission"></i></small>
                            </h4>

                            <select id="pages" class="form-control" data-action="page">
                                <?php
                                foreach ($user_pages as $page_item) {
                                    $seleced = "";
                                    if ($page != 0) {
                                        if ($page_item->id == $page) {
                                            $seleced = "selected='selected'";
                                        }
                                    }
                                ?>
                                    <option value="<?= $page_item->id; ?>" <?= $seleced; ?>>
                                        <?= $page_item->page_name; ?> </option>
                                <?php


                                }
                                ?>
                            </select>
                            <small class="mt-2"> Missing page ? Click <a
                                    href="<?php echo $this->facebook->addpage_url(); ?>"> HERE </a>
                                to add it. </small>


                        </div>


                        <div class="form-group col-md-6">
                            <h4 class="card-title mb-1">Image Caption <small><i
                                        class="mdi mdi-help-circle-outline" data-toggle="tooltip"
                                        data-placement="bottom" title=""
                                        data-original-title="You can now add default image caption while posting to facebook."></i></small>
                            </h4>
                            <div class="input-group">
                                <textarea class="form-control" id="title"
                                    style=" height: 37px; "></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-info" id="caption" type="button">Save
                                        Caption!</button>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-12">
                            <hr>
                            <h4 class="card-title mb-1">Event Group
                                <small>
                                    <i class="mdi mdi-help-circle-outline" data-action="event"
                                        data-toggle="tooltip" data-placement="bottom" title=""
                                        data-original-title="Events are groups which have start and end date. It helps you to schedule hasslefree posts for a specific duration."></i>
                                </small>
                            </h4>
                            <select id="events" class="form-control d-none">
                            </select>
                            <div id="event_buttons">
                            </div>
                            <button class="btn btn-sm btn-outline-default mt-2 pull-right c_e"> <i
                                    class="fa fa-plus"></i> create event group </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card simple-card sceduled_p" style="display:none;">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                            href="#scheduling" role="tab" aria-selected="true"> <span class="">
                                Scheduling</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings"
                            role="tab" aria-selected="false"><span class="">Settings</span></a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active " id="scheduling" role="tabpanel">
                        <div class="card rounded-0 bt-0">
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group  col-md-12">
                                        <label class="d-none"> <b>Upload files</b> (Posting time
                                            must be set to enable this area) : <i
                                                class="mdi mdi-help-circle-outline"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title=""
                                                data-original-title="Third step is to select upload bulk images, every image must be equal to or less than 2MB."></i>
                                        </label>
                                        <div class="content-wrap dropzonewidget"
                                            style="display:none;">
                                            <div class="nest" id="DropZoneClose">
                                                <div class="title-alt">
                                                </div>
                                                <div class="body-nest " id="DropZone">
                                                    <div id="myDropZone" class="dropzone min-250">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-md-12 m-t-10 text-left">
                                        <b>Queue </b> <span class="pagenamedisplay"></span>: <i
                                            class="mdi mdi-help-circle-outline"
                                            data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="Here you can manage the existing posts on pages. Select Page to load posts"></i>
                                        <button
                                            class="btn btn-outline-danger deleteall m-l-5 btn-sm pull-right mr-3"
                                            style="display: none;"><i
                                                class="fa fa-trash pointer"></i> Delete All</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body b-t">
                                <div class="row el-element-overlay popup-gallery" id="sceduled">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="settings" role="tabpanel">
                        <div class="card simple-card">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                                        href="#psettings" role="tab" aria-selected="true"> <span
                                            class=""> Page</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab"
                                        href="#esettings" role="tab" aria-selected="false"><span
                                            class="">Events</span></a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="psettings" role="tabpanel">
                                    <div class="card rounded-0 bt-0">
                                        <div class="card-body my-3">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label>Posting Schedule <i
                                                            class="mdi mdi-help-circle-outline"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom" title=""
                                                            data-original-title="You can max select 24 time slots per day. Select Atleast one time slot to open upload area."></i>
                                                    </label>
                                                    <select id="page_ts" multiple
                                                        data-placeholder="Posting Schedule..."
                                                        class="chosen-select form-control">
                                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                                            <option value="<?= $i; ?>">
                                                                <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                                        <?php endfor ?>
                                                    </select>
                                                    <small><i class="fa fa-check text-success"></i>
                                                        Auto saving on changes.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="esettings" role="tabpanel">
                                    <div class="card rounded-0 bt-0">
                                        <div class="card-body my-3">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <button
                                                        class="btn btn-sm btn-outline-danger mt-2 pull-right deleteevent mr-3">
                                                        <i class="fa fa-trash"></i> Delete </button>
                                                </div>
                                            </div>

                                            <form class="form" id="u_e_form">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="eventname">Event Name</label>
                                                        <input type="text" id="eventname"
                                                            class="form-control" name="name"
                                                            required></input>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Posting Schedule <i
                                                                class="mdi mdi-help-circle-outline"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom" title=""
                                                                data-original-title="You can max select 24 time slots per day. Select Atleast one time slot to open upload area."></i>
                                                        </label>
                                                        <select id="eventstimeslots" name="t_r"
                                                            multiple
                                                            data-placeholder="Posting Schedule..."
                                                            class="chosen-select form-control">
                                                            <?php for ($i = 0; $i < 24; $i++): ?>
                                                                <option value="<?= $i; ?>">
                                                                    <?= $i % 12 ? $i % 12 : 12 ?>:00
                                                                    <?= $i >= 12 ? 'pm' : 'am' ?>
                                                                </option>
                                                            <?php endfor ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="ue_event_day">Occurrence</label>
                                                        <select name="ue_event_day"
                                                            id="ue_event_day" class="form-control">
                                                            <option value="alldays">Every Day
                                                            </option>
                                                            <option value="monday">Monday</option>
                                                            <option value="tuesday">Tuesday</option>
                                                            <option value="wednesday">Wednesday
                                                            </option>
                                                            <option value="thursday">Thursday
                                                            </option>
                                                            <option value="friday">Friday</option>
                                                            <option value="saturday">Saturday
                                                            </option>
                                                            <option value="sunday">Sunday</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                    </div>
                                                    <div class="form-group col-md-6 ue_alldays">
                                                        <label for="eventstartdate">Start
                                                            Date</label>
                                                        <input type="date" id="eventstartdate"
                                                            class="form-control"
                                                            name="start_date"></input>
                                                    </div>
                                                    <div class="form-group col-md-6 ue_alldays">
                                                        <label for="eventenddate">End Date</label>
                                                        <input type="date" id="eventenddate"
                                                            class="form-control"
                                                            name="end_date"></input>
                                                    </div>
                                                    <div class="form-group col-md-6 ue_alldays">
                                                        <label for="repeating">Repeat every
                                                            year</label>
                                                        <div class="switch">
                                                            <label>OFF<input id="repeating"
                                                                    type="checkbox"><span
                                                                    class="lever switch-col-light-blue "></span>ON</label>
                                                        </div>
                                                    </div>





                                                    <div class="form-group col-md-12">

                                                        <button
                                                            class="btn btn-sm btn-outline-success mt-2 pull-right"
                                                            type="submit"> <i
                                                                class="fa fa-save"></i> Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php

        } else {
        ?>
            <div class="col-md-12 text-center">
                <div class="alert alert-danger">
                    <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i>
                        Facebook not connected </h3>
                    <p><br>Connecting and authorizing facebook pages is required, Click <a
                            href="<?php echo $this->facebook->addpage_url(); ?>"> HERE </a>
                        to connect right now. so Adublisher can publish posts you
                        schedule/set.<br>
                        <b>Note - we will NEVER send anything to your friends or post
                            anything that you haven't scheduled/set first!</b>
                    </p>
                    <p>Later you can disconnect this app, just like any other social media
                        based app.</p>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->

        <!--- Modal Start ---->
        <div class="modal fade" id="newevent" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> <i class="fa fa-plus"></i> Create New Event
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <form class="form" id="c_e_form"></form>
                    <div class="modal-body ">
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label for="c_e_name">Event Name</label>
                                <input type="text" id="c_e_name" name="name"
                                    class="form-control" required></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="c_e_timeslots">Posting Schedule <i
                                        class="mdi mdi-help-circle-outline"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title=""
                                        data-original-title="You can max select 24 time slots per day."></i>
                                </label>
                                <select id="c_e_timeslots" name="times_lots_raw" multiple
                                    data-placeholder="Posting Schedule..."
                                    class="chosen-select form-control">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i; ?>">
                                            <?= $i % 12 ? $i % 12 : 12 ?>:00
                                            <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="event_day">Occurrence</label>
                                <select name="event_day" id="event_day"
                                    class="form-control">
                                    <option value="alldays">Every Day</option>
                                    <option value="monday">Monday</option>
                                    <option value="tuesday">Tuesday</option>
                                    <option value="wednesday">Wednesday</option>
                                    <option value="thursday">Thursday</option>
                                    <option value="friday">Friday</option>
                                    <option value="saturday">Saturday</option>
                                    <option value="sunday">Sunday</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 alldays">
                                <label for="c_e_startdate">Start Date</label>
                                <input type="date" id="c_e_startdate" name="start_date"
                                    class="form-control"></input>
                            </div>
                            <div class="form-group col-md-6 alldays">
                                <label for="c_e_enddate">End Date</label>
                                <input type="date" id="c_e_enddate" name="end_date"
                                    class="form-control"></input>
                            </div>
                            <div class="form-group col-md-6 alldays">
                                <label for="c_e_repeating">Repeat every year</label>
                                <div class="switch">
                                    <label>OFF<input id="c_e_repeating"
                                            type="checkbox"><span
                                            class="lever switch-col-light-blue "></span>ON</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal"
                            class="btn btn-outline-secondary"> Cancel</button>
                        <button type="submit" class="btn btn-outline-success"> <i
                                class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>