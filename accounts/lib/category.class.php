<?php
/**
 * Class Category
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: admin.class.php, v1.00 2020-02-20 18:20:24 gewa Exp $
 */
if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');


class Category
{
    const cTable = "categories";
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

        $sql = " SELECT * from categories";
        $tpl = App::View(BASEPATHMM . 'view/');
        $tpl->data = self::$db->pdoQuery($sql)->results();
        $tpl->dir = "admin/";
        $tpl->template = 'admin/categories.tpl.php';
        $tpl->title = "Categories";
    }

    public function Save()
    {
        $tpl = App::View(BASEPATHMM . 'view/');
        $tpl->dir = "admin/";
        $tpl->title = "Create Categoy";
        $tpl->template = 'admin/category_create.tpl.php';
    }

    public function processCategory()
    {
        $this->addCategory();
    }

    public function addCategory()
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $_POST['slug'],
            'description' => $_POST['description'],
            'status' => $_POST['status'],
        ];
        $last_idx = Db::run()->insert(self::cTable, $data)->getLastInsertId();
        if ($last_idx) {
            $message = 'Category added successfully!';
            Message::msgReply(true, 'success', $message);
        }
    }

    public function Edit($id)
    {
        $tpl = App::View(BASEPATHMM . 'view/');
        $tpl->dir = "admin/";
        $category = Db::run()->first(self::cTable, null, array("id =" => $id));
        if (!$category) {
            $tpl->template = 'admin/error.tpl.php';
            $tpl->error = DEBUG ? "Invalid ID ($id) detected [category.class.php, ln.:" . __LINE__ . "]" : Lang::$word->META_ERROR;
        } else {
            $tpl->data = $category;
            $tpl->title = "Edit Category";
            $tpl->template = 'admin/category_edit.tpl.php';
        }
    }

    public function updateCategory()
    {
        $id = $_POST['id'];
        $category = Db::run()->first(self::cTable, null, array("id =" => $id));
        if ($category) {
            $data = [
                'title' => $_POST['title'],
                'slug' => $_POST['slug'],
                'description' => $_POST['description'],
                'status' => $_POST['status'],
            ];
            self::$db->update(self::cTable, $data, array("id" => $id));
            $status = true;
            $type = 'success';
            $message = 'Category updated Successfully!';
        } else {
            $status = false;
            $type = 'error';
            $message = 'Category not found!';
        }
        Message::msgReply($status, $type, $message);
    }
}