<?php
/**
 * Category Manager
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: _category_create.tpl.php, v1.00 2020-01-08 10:12:05 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');
?>
<h2>Create Category</h2>
<form method="post" id="wojo_form" name="wojo_form" enctype="multipart/form-data">
    <div class="wojo segment form">
        <div class="row">
            <div class="field col-md-6 my-2">
                <label>CATEGORY TITLE
                    <i class="icon asterisk"></i></label>
                <div class="wojo input">
                    <input type="text" placeholder="CATEGORY TITLE" name="title" id="title" required>
                </div>
            </div>
            <div class="field col-md-6 my-2">
                <label>CATEGORY SLUG
                    <i class="icon asterisk"></i></label>
                <div class="wojo input">
                    <input type="text" placeholder="CATEGORY SLUG" name="slug" id="slug" required>
                </div>
            </div>
            <div class="field col-md-6 my-2">
                <label>DESCRIPTION
                    <i class="icon asterisk"></i></label>
                <textarea style="height: 44px; min-height: 44px;" placeholder="CATEGORY DESCRIPTION" name="description"
                    required></textarea>
            </div>
            <div class="field col-md-6 my-2">
                <label>STATUS</label>
                <select name="status" id="status" required>
                    <option value="1">ACTIVE</option>
                    <option value="0">INACTIVE</option>
                </select>
            </div>
        </div>
        <!-- ACTION BUTTONS -->
        <div class="center aligned">
            <a href="<?php echo Url::url("/admin/categories"); ?>"
                class="wojo small simple button"><?php echo Lang::$word->CANCEL; ?></a>
            <button type="button" data-action="processCategory" name="dosubmit" class="wojo primary button">New
                Category</button>
        </div>
    </div>
</form>
<script>
    var makeSlug = function (title, name) {
        var slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/^-|-$/g, '');
        $('#' + name).val(slug);
    }
    var validate_form = function () {
        var isValid = true;
        // required input fields
        var requiredInput = $('#wojo_form').find('input[required]');
        // required text area
        var requiredTextarea = $('#wojo_form').find('textarea[required]');
        // validate required input fields
        requiredInput.each(function () {
            if ($(this).val() == '' || $(this).val() == null || $(this).val() == undefined) {
                $(this).addClass('border border-danger');
                isValid = false;
            } else {
                $(this).removeClass('border border-danger');
            }
        });
        // validate required text area
        requiredTextarea.each(function () {
            if ($(this).val() == '' || $(this).val() == null || $(this).val() == undefined) {
                $(this).addClass('border border-danger');
                isValid = false;
            } else {
                $(this).removeClass('border border-danger');
            }
        });
        if (!isValid) {
            $('button[name="dosubmit"]').removeClass('loading').attr('disabled', false);
            $.wNotice('Please fill all required fields!', {
                autoclose: 12000,
                type: 'error',
                title: 'Error'
            });
        }
        else {
            return true;
        }
    }
    $(document).ready(function () {
        $('#title').on('keyup', function () {
            var title = $(this).val();
            makeSlug(title, 'slug');
        });
        $('#wojo_form').on('submit', function (event) {
            event.preventDefault();
            $('button[name="dosubmit"]').addClass('loading').attr('disabled', true);
            var validated = validate_form();
            if (validated) {
                var formData = new FormData(this);
                formData.append('action', "processCategory");
                $.ajax({
                    url: "<?php echo ADMINVIEW . '/controller.php'; ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        response = JSON.parse(response);
                        var url = "<?php echo SITEURL . '/accounts/admin/categories'; ?>";
                        if (response.type === "success") {
                            $.wNotice('A new category added Successfully!', {
                                autoclose: 1500,
                                type: 'success',
                                title: 'Success',
                            });
                            setTimeout(function () {
                                window.location.href = url;
                            }, 1500);
                        }
                    }
                });
            }
        });
    });
</script>