<?php
/**
 * Class Blog
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: admin.class.php, v1.00 2020-02-20 18:20:24 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');


class Blog
{
    const bTable = "blogs";
    const bcTable = "blog_categories";
    const cTable = "categories";
    const gTable = "gallery";
    private static $db;
    public function __construct()
    {
        self::$db = Db::run();
    }
    /**
     * Admin::Index()
     * 
     * @return
     */
    public function Index()
    {
        $find = isset($_POST['find']) ? Validator::sanitize($_POST['find'], "default", 30) : null;

        $pager = Paginator::instance();
        $pager->default_ipp = App::Core()->perpage;
        $pager->path = Url::url(Router::$path, "?");
        $pager->paginate();

        $sql = " SELECT * from blogs";
        $tpl = App::View(BASEPATHMM . 'view/');
        $tpl->data = self::$db->pdoQuery($sql)->results();
        $tpl->dir = "admin/";
        $tpl->template = 'admin/blogs.tpl.php';
        $tpl->title = "Blogs";
    }

    public function Save()
    {
        $tpl = App::View(BASEPATHMM . 'view/');
        $tpl->dir = "admin/";
        $tpl->title = "Create Blog";
        $tpl->template = 'admin/blog_create.tpl.php';
    }

    /**
     * Users::processBlog()
     * 
     * @return
     */
    public function processBlog()
    {
        $this->addBlog();
    }

    /**
     * Users::addBlog()
     * 
     * @return
     */
    public function addBlog()
    {
        error_reporting(-1);
        ini_set('display_errors', 1);
        $categories = $_POST['categories'];
        $data = [
            'title' => $_POST['title'],
            'slug' => $_POST['slug'],
            'short_description' => $_POST['short_description'],
            'description' => $_POST['content'],
            'seo_title' => $_POST['seo_title'],
            'seo_slug' => $_POST['seo_slug'],
            'seo_description' => $_POST['seo_description'],
            'status' => $_POST['status'],
        ];
        // upload thumbnail
        $last_idx = Db::run()->insert(Blog::bTable, $data)->getLastInsertId();
        if ($last_idx) {
            $thumbnail = $_FILES['thumbnail'];
            $thumbnail_path = [
                'thumbnail' => Helper::upload_image($thumbnail, 'thumbnail')
            ];
            self::$db->update(self::bTable, $thumbnail_path, array("id" => $last_idx));
            // add categories
            foreach ($categories as $value) {
                $blog_category = [
                    'blog_id' => $last_idx,
                    'category_id' => $value
                ];
                Db::run()->insert(Blog::bcTable, $blog_category);
            }
        }
        $message = 'Blog added Successfully!';
        Message::msgReply(true, 'success', $message);
    }

    public function imageUpload()
    {
        $image = $_FILES['file'];
        $image_upload = Helper::upload_image($image, 'file');
        $location = SITEURL . "/assets/blogs/" . $image_upload;
        // return json_encode(['location' => $image_uploada]);
    }

    public function Edit($id)
    {
        $tpl = App::View(BASEPATHMM . 'view/');
        $tpl->dir = "admin/";
        $blogs_sql = "select blogs.*, blog_categories.category_id, blog_categories.blog_id from blogs left join blog_categories on blogs.id=blog_categories.blog_id where blogs.id=" . $id;
        $blogs = self::$db->pdoQuery($blogs_sql)->results();
        if (!$blogs) {
            $tpl->template = 'admin/error.tpl.php';
            $tpl->error = DEBUG ? "Invalid ID ($id) detected [blog.class.php, ln.:" . __LINE__ . "]" : Lang::$word->META_ERROR;
        } else {
            $sql = " SELECT * from " . Blog::cTable . " WHERE status = 1";
            $categories = self::$db->pdoQuery($sql)->results();
            $tpl->data = $blogs;
            $tpl->categories = $categories;
            $tpl->title = "Edit Blog";
            $tpl->template = 'admin/blog_edit.tpl.php';
        }
    }

    public function updateBlog()
    {
        $id = $_POST['id'];
        $blog = Db::run()->first(self::bTable, null, array("id =" => $id));
        if ($blog) {
            $categories = $_POST['categories'];
            $data = [
                'short_description' => $_POST['short_description'],
                'title' => $_POST['title'],
                'slug' => $_POST['slug'],
                'status' => $_POST['status'],
                'description' => $_POST['content'],
                'seo_title' => $_POST['seo_title'],
                'seo_slug' => $_POST['seo_slug'],
                'seo_description' => $_POST['seo_description'],
            ];
            // upload thumbnail
            self::$db->update(self::bTable, $data, array("id" => $id));
            if ($id) {
                if (isset($_FILES['thumbnail']) && !empty($_FILES['thumbnail']['name'])) {
                    $thumbnail = $_FILES['thumbnail'];
                    $thumbnail_path = [
                        'thumbnail' => Helper::upload_image($thumbnail, 'thumbnail')
                    ];
                    self::$db->update(self::bTable, $thumbnail_path, array("id" => $id));
                }
                Db::run()->delete(Blog::bcTable, array("blog_id" => $id));
                foreach ($categories as $value) {
                    $blog_category = [
                        'blog_id' => $id,
                        'category_id' => $value
                    ];
                    Db::run()->insert(Blog::bcTable, $blog_category);
                }
            }
            $status = true;
            $type = 'success';
            $message = 'Blog updated Successfully!';
        } else {
            $status = false;
            $type = 'error';
            $message = 'Blog not found!';
        }
        Message::msgReply($status, $type, $message);
    }

    public function getCategories()
    {
        $table = Blog::cTable;
        $sql = " SELECT * from " . $table . " WHERE status = 1";
        $result = self::$db->pdoQuery($sql)->results();
        Message::msgReply(true, 'Success', $result);
    }

    public function addNewCategory()
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $_POST['slug'],
            'status' => 1,
        ];
        $last_idx = Db::run()->insert(Blog::cTable, $data)->getLastInsertId();
        if ($last_idx) {
            Message::msgReply(true, 'Success', $last_idx);
        }
    }
}