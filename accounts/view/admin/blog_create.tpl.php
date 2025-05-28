<?php
/**
 * Blog Manager
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: _blogs_create.tpl.php, v1.00 2020-01-08 10:12:05 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');
?>
<h2>Create Blog</h2>
<form method="post" id="wojo_form" name="wojo_form" enctype="multipart/form-data">
    <div class="wojo segment form">
        <div class="row col-md-12 p-0">
            <!-- BLOG CONTENT -->
            <div class="col-md-12">
                <!-- SUB TITLE -->
                <div class="field my-2">
                    <label>SHORT DESCRIPTION
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <textarea name="short_description" id="short_description" style="min-height: 44px;"
                            placeholder="BLOG SUB TITLE" required></textarea>
                    </div>
                </div>
                <!-- TITLE -->
                <div class="field my-2">
                    <label>TITLE
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="BLOG TITLE" id="title" name="title" required>
                    </div>
                </div>
                <!-- PERMALINK/SLUG -->
                <div class="field my-2">
                    <label>SLUG
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="BLOG SLUG" id="slug" name="slug" required>
                    </div>
                </div>
                <!-- BLOG DETAILS -->
                <div class="d-flex my-2">
                    <div class="col-md-4">
                        <!-- THUMBNAIL -->
                        <div class="field my-2">
                            <label>THUMBNAIL
                                <i class="icon asterisk"></i></label>
                            <div class="wojo input">
                                <input type="file" name="thumbnail" id="thumbnail">
                            </div>
                        </div>
                        <!-- THUMNBAIL PREVIEW -->
                        <div>
                            <div class="field">
                                <img class="absolute" src="" alt="" id="thumbnail_preview" height="200">
                            </div>
                        </div>
                    </div>
                    <!-- STATUS -->
                    <div class="col-md-4">
                        <label>STATUS
                            <i class="icon asterisk"></i></label>
                        <select name="status" id="status" required>
                            <option value="1">ACTIVE</option>
                            <option value="0">INACTIVE</option>
                        </select>
                    </div>
                    <!-- CATEGORY -->
                    <div class="col-md-2">
                        <label>CATEGORIES
                            <i class="icon asterisk"></i></label>
                        <div class="categories_container"></div>
                        <!-- ADD NEW -->
                        <div class="field my-2">
                            <label class="text-primary add_category" style="cursor: pointer;"><ins>ADD NEW
                                    CATEGORY</ins></label>
                        </div>
                    </div>
                    <div class="add_category_content col-md-2" style="display:none;">
                        <div class="field my-2">
                            <label>TITLE
                                <i class="icon asterisk"></i></label>
                            <div class="wojo input">
                                <input type="text" placeholder="CATEGORY TITLE" id="category_title"
                                    name="category_title">
                            </div>
                        </div>
                        <div class="field my-2">
                            <label>SLUG
                                <i class="icon asterisk"></i></label>
                            <div class="wojo input">
                                <input type="text" placeholder="CATEGORY SLUG" id="category_slug" name="category_slug"
                                    class="category_slug bg-light" readonly>
                            </div>
                        </div>
                        <div class="field my-2">
                            <button type="button" data-action="addNewCategory"
                                class="wojo primary button btn btn-outline-primary add_category_btn">ADD NEW
                                CATEGORY</button>
                        </div>
                    </div>
                </div>
                <!-- DESCRIPTION -->
                <div class="fields my-2">
                    <div class="field">
                        <label>DESCRIPTION
                            <i class="icon asterisk"></i></label>
                        <textarea id="long_description" placeholder="Blog Description"></textarea>
                    </div>
                </div>
            </div>
            <!-- SEO DATA -->
            <div class="col-md-12 border-top">
                <div class="field my-2 col-md-8">
                    <label>SEO TITLE
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="SEO TITLE" name="seo_title" id="seo_title" required>
                    </div>
                </div>
                <div class="field my-2 col-md-8">
                    <label>SEO SLUG
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="SEO SLUG" name="seo_slug" id="seo_slug" required>
                    </div>
                </div>
                <div class="field my-2 col-md-8">
                    <label>META DESCRIPTION
                        <i class="icon asterisk"></i></label>
                    <textarea placeholder="SEO DESCRIPTION" name="seo_description" required></textarea>
                </div>
            </div>
        </div>
        <!-- ACTION BUTTONS -->
        <div class="center aligned">
            <a href="<?php echo Url::url("/admin/blogs"); ?>"
                class="wojo small simple button"><?php echo Lang::$word->CANCEL; ?></a>
            <button type="button" data-action="processBlog" name="dosubmit" class="wojo primary button">New
                Blog</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        // make slug function
        var makeSlug = function (title, name) {
            var slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/^-|-$/g, '');
            $('#' + name).val(slug);
        }
        // on title keyup
        $('#title').on('keyup', function () {
            var title = $(this).val();
            makeSlug(title, 'slug');
        });
        $('#seo_title').on('keyup', function () {
            var title = $(this).val();
            makeSlug(title, 'seo_slug');
        });
        // make dynamic category checkboxes
        function fetch_categories() {
            $.ajax({
                url: "<?php echo ADMINVIEW . '/controller.php'; ?>",
                type: "POST",
                data: {
                    'action': "getCategories"
                },
                success: function (response) {
                    response = JSON.parse(response);
                    var categories = response.message;
                    // Create a container to hold the checkboxes
                    var checkboxContainer = $('.categories_container');
                    // Iterate through the array and create checkboxes
                    categories.forEach(function (item) {

                        var checkbox = $("<input>")
                            .attr("type", "checkbox")
                            .attr("id", item.id)
                            .attr("name", 'categories[]')
                            .val(item.id);

                        var label = $("<label class='px-1'>")
                            .attr("for", item.id)
                            .text(item.title);
                        checkboxContainer.append(checkbox, label, "<br>");
                    });

                    // Append the checkbox container to the desired element
                    $("#your-container-id").append(checkboxContainer);
                }
            });
        }
        fetch_categories();

        // add new category
        $('.add_category').on('click', function () {
            $('.add_category_content').toggle();
        });
        //add category ajax
        $('input[name="category_title"]').on('keyup', function () {
            var cat_title = $(this).val();
            if (cat_title != '' && cat_title != null && cat_title != undefined) {
                makeSlug(cat_title, 'category_slug');
            }
        });
        $('.add_category_btn').on('click', function () {
            var cat_title = $('input[name="category_title"]').val();
            var cat_slug = $('.category_slug').val();
            if (cat_title == '' || cat_title == null || cat_title == undefined) {
                $('input[name="category_title"]').addClass('border border-danger');
            }
            else {
                $.ajax({
                    url: "<?php echo ADMINVIEW . '/controller.php'; ?>",
                    type: "POST",
                    data: {
                        'action': 'addNewCategory',
                        'title': cat_title,
                        'slug': cat_slug
                    },
                    success: function (response) {
                        $('input[name="category_title"]').val('');
                        $('input[name="category_slug"]').val('');
                        $('.categories_container').empty();
                        $('.add_category_content').toggle();
                        fetch_categories();
                    }
                });
            }
        });
    });
</script>
<script>
    const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '<?php echo Url::url("/admin/blogs/image_upload") ?>');
        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };
        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                return;
            }
            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }
            const json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
            }
            resolve(json.location);
        };
        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    });

    tinymce.init({
        selector: '#long_description',
        toolbar_sticky: true,
        height: 1000,
        plugins: "image, link, lists",
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | image link',

        images_file_types: 'jpg,png,webp',
        images_upload_url: '<?php echo Url::url("/admin/blogs/image_upload") ?>',
        images_upload_handler: image_upload_handler_callback
    });
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
    $('#wojo_form').on('submit', function (event) {
        event.preventDefault();
        $('button[name="dosubmit"]').addClass('loading').attr('disabled', true);
        var validated = validate_form();
        if (validated) {
            var content = tinyMCE.get('long_description').getContent();
            var formData = new FormData(this);
            // formData.push({ name: 'thumbnail', value: $('#thumbnail')[0].files[0] });
            formData.append('content', content);
            formData.append('action', "processBlog");
            $.ajax({
                url: "<?php echo ADMINVIEW . '/controller.php'; ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    response = JSON.parse(response);
                    var url = "<?php echo SITEURL . '/accounts/admin/blogs'; ?>";
                    if (response.type === "success") {
                        $.wNotice('A new blog added Successfully!', {
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
</script>