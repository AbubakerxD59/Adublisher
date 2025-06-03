<?php
date_default_timezone_set($user->gmt);
$utc_offset = date('Z') / 3600;
?>

<div class="row">
    <p class="col-md-12 text-center">
        <a href="<?= SITEURL ?>add-campaign" class="m-t-2 text-center"> <i class="fa fa-plus"></i>
            Add campaign</a>
    </p>
    <div class="col-md-12">
        <form class="input-form p-0 m-t-10" style="line-height: 0;" id="searchform">
            <div class="input-group">
                <input type="text" class="form-control m-l-5" id="searchtext"
                    placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" id="searchsubmit">Search!
                    </button>
                </span>
            </div>
        </form>
    </div>
    <div class="col-md-12 px-1 py-3">
        <div id="collapseExample">
            <div class="row px-2">
                <div class="col-md-12 row">
                    <?php
                    $popularity = "";
                    if (!empty($save_filter)) {
                        $popularity = $save_filter->popularity;
                        $domain = $save_filter->domain;
                        $cat = $save_filter->cat;
                    } else {
                        $cat = '';
                    }
                    ?>
                    <div class="col-md-6 p-2">
                        <label>Popularity</label>
                        <select class="form-control" name="popularity" id="popularity">
                            <option value="">Latest</option>
                            <option value="today" <?php echo (!empty($popularity) && $popularity == 'today') ? 'selected' : '' ?>>Today's
                                Top</option>
                            <option value="week" <?php echo (!empty($popularity) && $popularity == 'week') ? 'selected' : '' ?>>Week's Top
                            </option>
                            <!--  <option value="month"  <?php echo (!empty($popularity) && $popularity == 'month') ? 'selected' : '' ?>>Month's Top</option>-->
                            <option value="all" <?php echo (!empty($popularity) && $popularity == 'all') ? 'selected' : '' ?>>All Time
                                Top</option>
                        </select>
                    </div>
                    <div class="col-md-6 p-2">
                        <label>Domains</label>
                        <select class="form-control" name="domain" id="domain">
                            <option value="all">All Domains</option>
                            <?php foreach ($all_domains as $value) {
                                if (trim($value['domain']) == "") {
                                    continue;
                                }
                            ?>
                                <option value="<?= $value['domain']; ?>" <?php echo (!empty($domain) && $domain == $value['domain']) ? 'selected' : '' ?>> <?= $value['domain']; ?>
                                </option>
                            <?php
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="col-md-6 p-2">
                        <label>Category</label>
                        <select class="form-control chosen-select" name="cat" id="cat"
                            multiple data-live-search="true">
                            <?php
                            $cata = explode('|', $cat);
                            ?>
                            <option value="all" <?php echo in_array('all', $cata) || empty($cat) ? 'selected' : ''; ?>>All Categories
                            </option>
                            <?php
                            foreach ($all_categories as $value) {

                                $selected = in_array($value->id, $cata) ? 'selected' : '';
                                echo '<option value="' . $value->id . '"' . $selected . '>' . ucfirst($value->categury) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 m-t-5 m-r-5">
                    <div class="form-group text-lg-right m-r-5">
                        <button id="recomended" title="Recommended for you"
                            class="btn btn-outline-secondary">
                            <i class="fa fa-history" aria-hidden="true">
                            </i> Recommended
                        </button>
                        <button class="btn btn-outline-info settings"
                            data-toggle="modal" data-target=".settings-modal-lg">
                            <i class="fa fa-gear"></i> Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row" id="campiagns_html"></div>
    </div>
</div>
<!-- Modals -->
<?php $this->load->view('layouts/publisher/views/affiliate_campaign/modals'); ?>
<!-- Modals -->

<input type="text" id="request" value="filter" style="display: none;">
<input type="text" id="data_to_post" style="display: none;">
<input type="text" id="id_to_post" style="display: none;">