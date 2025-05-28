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
<?php
?>
<h2>Edit Blog</h2>
<form method="post" id="wojo_form" name="wojo_form" enctype="multipart/form-data">
    <div class="wojo segment form">
        <div class="row col-md-12 p-0">
            <input type="hidden" name="id" value="<?php echo $this->data[0]->id; ?>">
            <!-- BLOG CONTENT -->
            <div class="col-md-12">
                <!-- SUB TITLE -->
                <div class="field my-2">
                    <label>SHORT DESCRIPTION
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <textarea name="short_description" id="short_description" style="min-height: 44px;"
                            placeholder="BLOG SUB TITLE"
                            required><?php echo $this->data[0]->short_description; ?></textarea>
                    </div>
                </div>
                <!-- TITLE -->
                <div class="field my-2">
                    <label>TITLE
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="BLOG TITLE" id="title" name="title"
                            value="<?php echo $this->data[0]->title; ?>" required>
                    </div>
                </div>
                <!-- PERMALINK/SLUG -->
                <div class="field my-2">
                    <label>SLUG
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="BLOG SLUG" name="slug" id="slug"
                            value="<?php echo $this->data[0]->slug; ?>" required>
                    </div>
                </div>
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
                                <img class="" src="<?php echo SITEURL . 'assets/blogs/' . $this->data[0]->thumbnail; ?>"
                                    alt="" id="thumbnail_preview" height="200">
                            </div>
                        </div>
                    </div>
                    <!-- STATUS -->
                    <div class="col-md-4">
                        <label>STATUS
                            <i class="icon asterisk"></i></label>
                        <select name="status" id="status" required>
                            <option value="1" <?php echo $this->data[0]->status == 1 ? 'selected' : ''; ?>>PUBLISH
                            </option>
                            <option value="0" <?php echo $this->data[0]->status == 0 ? 'selected' : ''; ?>>DRAFT</option>
                        </select>
                    </div>
                    <!-- CATEGORY -->
                    <div class="col-md-4">
                        <label>CATEGORIES
                            <i class="icon asterisk"></i></label>
                        <div class="categories_container">
                            <?php
                            $selected_categories = [];
                            foreach ($this->data as $key => $blog) {
                                $selected_categories[$key] = $blog->category_id;
                            }
                            foreach ($this->categories as $category) {
                                ?>
                                <input type="checkbox" id="<?php echo $category->id; ?>" name="categories[]"
                                    value="<?php echo $category->id; ?>" <?php echo in_array($category->id, $selected_categories) ? 'checked' : ''; ?>>
                                <label class="px-1"
                                    for="<?php echo $category->id; ?>"><?php echo $category->title; ?></label>
                                <br>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- DESCRIPTION -->
                <div class="fields my-2">
                    <div class="field">
                        <label>DESCRIPTION
                            <i class="icon asterisk"></i></label>
                        <textarea id="long_description" placeholder="Blog Description">
                            <?php echo $this->data[0]->long_description; ?>
                        </textarea>
                    </div>
                </div>
            </div>
            <!-- BLOG DETAILS -->
            <div class="col-md-4">

            </div>
            <!-- SEO DATA -->
            <div class="col-md-12 border-top">
                <div class="field my-2 col-md-8">
                    <label>SEO TITLE
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="SEO TITLE" name="seo_title" id="seo_title"
                            value="<?php echo $this->data[0]->seo_title; ?>" required>
                    </div>
                </div>
                <div class="field my-2 col-md-8">
                    <label>SEO SLUG
                        <i class="icon asterisk"></i></label>
                    <div class="wojo input">
                        <input type="text" placeholder="SEO SLUG" name="seo_slug" id="seo_slug"
                            value="<?php echo $this->data[0]->seo_slug; ?>" required>
                    </div>
                </div>
                <div class="field my-2 col-md-8">
                    <label>META DESCRIPTION
                        <i class="icon asterisk"></i></label>
                    <textarea placeholder="SEO DESCRIPTION" name="seo_description" required>
                        <?php echo trim($this->data[0]->seo_description, ' '); ?>
                    </textarea>
                </div>
            </div>
        </div>
        <!-- ACTION BUTTONS -->
        <div class="center aligned">
            <a href="<?php echo Url::url("/admin/blogs"); ?>"
                class="wojo small simple button"><?php echo Lang::$word->CANCEL; ?></a>
            <button type="button" data-action="updateBlog" name="dosubmit" class="wojo primary button">Update
                Blog</button>
        </div>
    </div>
</form>
<div id="setcontent" class="d-none">
    <?php echo $this->data[0]->description; ?>
</div>

<script>
    var initialContent = $('#setcontent').html();
    $('#setcontent').remove();
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
        init_instance_callback: function (editor) {
            editor.setContent(initialContent);
        },
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
            formData.append('action', "updateBlog");
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
                        $.wNotice('Blog updated Successfully!', {
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
</script>