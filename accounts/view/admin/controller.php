<?php
/**
 * Controller
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: controller.php, v1.00 2020-02-05 10:12:05 gewa Exp $
 */
define("_WOJO", true);
require_once("../../init.php");
if (!App::Auth()->is_Admin())
    exit;

$delete = Validator::post('delete');
$trash = Validator::post('trash');
$action = Validator::post('action');
$restore = Validator::post('restore');
$title = Validator::post('title') ? Validator::sanitize($_POST['title']) : null;

/* == Delete Actions == */
switch ($delete):
    /* == Delete Custom Field == */
    case "deleteField":
        if ($row = Db::run()->delete(Content::cfTable, array("id" => Filter::$id))):
            Db::run()->delete(Users::cfTable, array("field_id" => Filter::$id));
            $json['type'] = "success";
        endif;

        $json['title'] = Lang::$word->SUCCESS;
        $json['message'] = str_replace("[NAME]", $title, Lang::$word->CF_DEL_OK);
        print json_encode($json);
        break;

    /* == Delete Database == */
    case "deleteBackup":
        File::deleteFile(UPLOADS . '/backups/' . $title);

        $json['title'] = Lang::$word->SUCCESS;
        $json['message'] = str_replace("[NAME]", $title, Lang::$word->DBM_DEL_OK);
        print json_encode($json);
        break;

    /* == Delete File == */
    case "deleteFile":
        if ($row = Db::run()->first(Content::fTable, null, array("id" => Filter::$id))):
            File::deleteFile(App::Core()->file_dir . $row->name);
            Db::run()->delete(Content::fTable, array("id" => $row->id));
            $json['type'] = "success";
        endif;

        $json['title'] = Lang::$word->SUCCESS;
        $json['message'] = str_replace("[NAME]", $title, Lang::$word->FM_DEL_OK);
        print json_encode($json);
        break;

    /* == Delete Trash == */
    case "trashAll":
        Db::run()->truncate(Core::txTable);
        Message::msgReply(true, 'success', Lang::$word->TRASH_DEL_OK);
        break;

    /* == Delete User == */
    case "deleteUser":
        try {
            $trash = Db::run()->first('trash', null, array("id" => Filter::$id));
            if(!empty($trash)){
                $current_user = json_decode($trash->dataset);
                $user_id = $current_user->id;
                if ($current_user->team_role == "owner") {
                    // delete user package record
                    $user_packages = Db::run()->select('package_to_user', null, array("uid" => $user_id), "ORDER BY id")->results();
                    foreach ($user_packages as $key => $user_package) {
                        $multiple = Db::run()->delete('package_to_user', array('id' => $user_package->id));
                    }
                    // delete user package features
                    $package_features = Db::run()->select('package_feature_user_limit', null, array("uid" => $user_id), "ORDER BY id")->results();
                    foreach ($package_features as $key => $package_feature) {
                        $multiple = Db::run()->delete('package_feature_user_limit', array('id' => $package_feature->id));
                    }
                    //delete affiliates
                    $affiliate_rows = Db::run()->select('user', null, array("team_id" => $current_user->team_id, 'team_role' => 'affiliate'), "ORDER BY id")->results();
                    if (sizeof($affiliate_rows) > 0) {
                        foreach ($affiliate_rows as $key => $affiliate) {
                            $multiple = Db::run()->delete('user', array('id' => $affiliate->id));
                            $multiple = Db::run()->delete('user_domains', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('acm_users', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('facebook_pages', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('bulkupload', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('sceduler', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('rsssceduler', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('tempclick', array('user' => $affiliate->username));
                            $multiple = Db::run()->delete('recomendation', array('userid' => $affiliate->id));
                            $multiple = Db::run()->delete('menu_assign', array('user' => $affiliate->id));
                            $multiple = Db::run()->delete('user_domains', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('user_rates', array('f_id' => $affiliate->id));
                            $multiple = Db::run()->delete('user_cdomains', array('user_id' => $affiliate->id));
                            $multiple = Db::run()->delete('recomendation', array('userid' => $affiliate->id));
                        }
                    }
                    //delete campaigns
                    $link_rows = Db::run()->select('link', null, array("user_id" => $user_id), "ORDER BY id")->results();
                    if (sizeof($link_rows) > 0) {
                        foreach ($link_rows as $key => $post) {
                            try {
                                //deleting rates
                                $multiple = Db::run()->delete('link_rates', array('f_id' => $post->id));
                                //delete from clicks backup
                                $multiple = Db::run()->delete('clicksbackup', array('cpid' => $post->id));
                                //delete clicks
                                $multiple = Db::run()->delete('click', array('cpid' => $post->id));
                                //delete from collective data
                                $multiple = Db::run()->delete('revenue', array('campaign_id' => $post->id));
                                //delete all Scheduled data for this post
                                $multiple = Db::run()->delete('sceduler', array('post_id' => $post->id));
                                //Now delete it
                                $multiple = Db::run()->delete('link', array('id' => $post->id));
                            } catch (Exception $e) {
                            }
                        }
                    }
    
                    //delete bulkuploads
                    $bulk_rows = Db::run()->select('bulkupload', null, array("user_id" => $user_id), "ORDER BY id")->results();
                    if (sizeof($bulk_rows) > 0) {
                        foreach ($bulk_rows as $key => $post) {
                            //start clearing data of bulk
                            $img_path = $post->link;
                            if ("::1" == $_SERVER['REMOTE_ADDR']) {
                                $delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $img_path;
                            } else {
                                $delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $img_path;
                            }
                            if (Db::run()->delete('bulkupload', array('id' => $post->id, 'user_id' => $uid))) {
                                try {
                                    $unlink = unlink($delete_path);
                                } catch (Exception $e) {
    
                                }
                            }
    
                        }
    
                    }
                    // delete transactions
                    $res = Db::run()->delete(Core::txTable, array("id" => $user_id));
                    $multiple = Db::run()->delete('package_to_user', array('uid' => $user_id));
                    $multiple = Db::run()->delete('package_feature_user_limit', array('uid' => $user_id));
                    $multiple = Db::run()->delete('user_domains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('acm_users', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('facebook_pages', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('bulkupload', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('sceduler', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('rsssceduler', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('recomendation', array('userid' => $user_id));
                    $multiple = Db::run()->delete('domains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('menu_assign', array('user' => $user_id));
                    $multiple = Db::run()->delete('user_domains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('user_rates', array('f_id' => $user_id));
                    $multiple = Db::run()->delete('team_rates', array('f_id' => $current_user->team_id));
                    $multiple = Db::run()->delete('user_cdomains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('recomendation', array('userid' => $user_id));
                } else {
                    $res = Db::run()->delete(Core::txTable, array("id" => $user_id));
                    $multiple = Db::run()->delete('user_domains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('acm_users', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('facebook_pages', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('bulkupload', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('sceduler', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('rsssceduler', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('recomendation', array('userid' => $user_id));
                    $multiple = Db::run()->delete('menu_assign', array('user' => $user_id));
                    $multiple = Db::run()->delete('user_domains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('user_rates', array('f_id' => $user_id));
                    $multiple = Db::run()->delete('user_cdomains', array('user_id' => $user_id));
                    $multiple = Db::run()->delete('recomendation', array('userid' => $user_id));
                    $multiple = Db::run()->delete('package_to_user', array('uid' => $user_id));
                    $multiple = Db::run()->delete('package_feature_user_limit', array('uid' => $user_id));
                }
            }
        } catch (Exception $e) {
        }
        Message::msgReply($res, 'success', str_replace("[NAME]", $title, Lang::$word->M_DELETE_OK));
        break;

    /* == Delete Coupon == */
    case "deleteCoupon":
        $res = Db::run()->delete(Core::txTable, array("id" => Filter::$id));
        Message::msgReply($res, 'success', str_replace("[NAME]", $title, Lang::$word->DC_DELETE_OK));
        break;

    /* == Delete News == */
    case "deleteNews":
        $res = Db::run()->delete(Core::txTable, array("id" => Filter::$id));
        Message::msgReply($res, 'success', str_replace("[NAME]", $title, Lang::$word->NW_DELETE_OK));
        break;

    /* == Delete Membership == */
    case "deleteMembership":
        $res = Db::run()->delete(Core::txTable, array("id" => Filter::$id));
        Message::msgReply($res, 'success', str_replace("[NAME]", $title, Lang::$word->MEM_DELETE_OK));
        break;

    /* == Delete Blog == */
    case "deleteBlog":
        $res = Db::run()->delete(Blog::bTable, array("id" => Filter::$id));
        $blog_trash_message = "Blog [NAME] deleted successfully..";
        $message = str_replace("[NAME]", $title, $blog_trash_message);
        Message::msgReply($res, 'success', $message);
        break;
    /* == Delete Category == */
    case "deleteCategory":
        Db::run()->delete(Blog::bcTable, array("category_id" => Filter::$id));
        $res = Db::run()->delete(Category::cTable, array("id" => Filter::$id));
        $blog_trash_message = "Category [NAME] deleted successfully..";
        $message = str_replace("[NAME]", $title, $blog_trash_message);
        Message::msgReply($res, 'success', $message);
        break;
endswitch;

/* == Trash Actions == */
switch ($trash):
    /* == Trash User == */
    case "trashUser":
        if ($row = Db::run()->first(Users::mTable, "*", array("id =" => Filter::$id, "AND type <>" => "owner"))):
            $data = array(
                'type' => "user",
                'parent_id' => Filter::$id,
                'dataset' => json_encode($row)
            );
            Db::run()->insert(Core::txTable, $data);
            Db::run()->delete(Users::mTable, array("id" => $row->id));
        endif;

        $message = str_replace("[NAME]", $title, Lang::$word->M_TRASH_OK);
        Message::msgReply(Db::run()->affected(), 'success', $message);
        break;

    /* == Trash Membership == */
    case "trashMembership":
        if ($row = Db::run()->first(Membership::mTable, "*", array("id =" => Filter::$id))):
            $data = array(
                'type' => "membership",
                'parent_id' => Filter::$id,
                'dataset' => json_encode($row)
            );
            Db::run()->insert(Core::txTable, $data);
            Db::run()->delete(Membership::mTable, array("id" => $row->id));
        endif;

        $message = str_replace("[NAME]", $title, Lang::$word->MEM_TRASH_OK);
        Message::msgReply(Db::run()->affected(), 'success', $message);
        break;


    /* == Trash Coupon == */
    case "trashCoupon":
        if ($row = Db::run()->first(Content::dcTable, "*", array("id =" => Filter::$id))):
            $data = array(
                'type' => "coupon",
                'parent_id' => Filter::$id,
                'dataset' => json_encode($row)
            );
            Db::run()->insert(Core::txTable, $data);
            Db::run()->delete(Content::dcTable, array("id" => $row->id));
        endif;

        $message = str_replace("[NAME]", $title, Lang::$word->DC_TRASH_OK);
        Message::msgReply(Db::run()->affected(), 'success', $message);
        break;

    /* == Trash News == */
    case "trashNews":
        if ($row = Db::run()->first(Content::nTable, "*", array("id =" => Filter::$id))):
            $data = array(
                'type' => "news",
                'parent_id' => Filter::$id,
                'dataset' => json_encode($row)
            );
            Db::run()->insert(Core::txTable, $data);
            Db::run()->delete(Content::nTable, array("id" => $row->id));
        endif;

        $message = str_replace("[NAME]", $title, Lang::$word->NW_TRASH_OK);
        Message::msgReply(Db::run()->affected(), 'success', $message);
        break;
endswitch;

/* == Restore Actions == */
switch ($restore):
    /* == Restore Database == */
    case "restoreBackup":
        dbTools::doRestore($title);
        break;

    /* == Restore User == */
    case "restoreUser":
        if ($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
            $array = Utility::jSonToArray($result->dataset);
            Core::restoreFromTrash($array, Users::mTable);
            Db::run()->delete(Core::txTable, array("id" => filter::$id));

            $json['type'] = 'success';
            $json['title'] = Lang::$word->SUCCESS;
            $json['message'] = str_replace("[NAME]", $title, Lang::$word->M_RESTORE_OK);
        else:
            $json['type'] = 'alert';
            $json['title'] = Lang::$word->ALERT;
            $json['message'] = Lang::$word->NOPROCCESS;
        endif;

        print json_encode($json);
        break;


    /* == Restore Coupon == */
    case "restoreCoupon":
        if ($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
            $array = Utility::jSonToArray($result->dataset);
            Core::restoreFromTrash($array, Content::dcTable);
            Db::run()->delete(Core::txTable, array("id" => filter::$id));

            $json['type'] = 'success';
            $json['title'] = Lang::$word->SUCCESS;
            $json['message'] = str_replace("[NAME]", $title, Lang::$word->DC_RESTORE_OK);
        else:
            $json['type'] = 'alert';
            $json['title'] = Lang::$word->ALERT;
            $json['message'] = Lang::$word->NOPROCCESS;
        endif;

        print json_encode($json);
        break;

    /* == Restore News == */
    case "restoreNews":
        if ($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
            $array = Utility::jSonToArray($result->dataset);
            Core::restoreFromTrash($array, Content::nTable);
            Db::run()->delete(Core::txTable, array("id" => filter::$id));

            $json['type'] = 'success';
            $json['title'] = Lang::$word->SUCCESS;
            $json['message'] = str_replace("[NAME]", $title, Lang::$word->NW_RESTORE_OK);
        else:
            $json['type'] = 'alert';
            $json['title'] = Lang::$word->ALERT;
            $json['message'] = Lang::$word->NOPROCCESS;
        endif;

        print json_encode($json);
        break;

    /* == Restore Membership == */
    case "restoreMembership":
        if ($result = Db::run()->first(Core::txTable, array('dataset'), array("id" => filter::$id))):
            $array = Utility::jSonToArray($result->dataset);
            Core::restoreFromTrash($array, Membership::mTable);
            Db::run()->delete(Core::txTable, array("id" => filter::$id));

            $json['type'] = 'success';
            $json['title'] = Lang::$word->SUCCESS;
            $json['message'] = str_replace("[NAME]", $title, Lang::$word->MEM_RESTORE_OK);
        else:
            $json['type'] = 'alert';
            $json['title'] = Lang::$word->ALERT;
            $json['message'] = Lang::$word->NOPROCCESS;
        endif;

        print json_encode($json);
        break;
endswitch;

/* == Actions == */
switch ($action):
    /* == Process User == */
    case "processUser":
        App::Users()->processUser();
        break;
    /* == Process Membership == */
    case "processMembership":
        App::Membership()->processMembership();
        break;
    /* == Process Template == */
    case "processTemplate":
        App::Content()->processTemplate();
        break;
    /* == Process Country == */
    case "processCountry":
        App::Content()->processCountry();
        break;
    /* == Process Coupon == */
    case "processCoupon":
        App::Content()->processCoupon();
        break;
    /* == Process Field == */
    case "processField":
        App::Content()->processField();
        break;
    /* == Process News == */
    case "processNews":
        App::Content()->processNews();
        break;
    /* == Update Account == */
    case "updateAccount":
        App::Admin()->updateAccount();
        break;
    /* == Update Password == */
    case "updatePassword":
        App::Admin()->updateAdminPassword();
        break;
    /* == Process Gateway == */
    case "processGateway":
        App::Admin()->processGateway();
        break;
    /* == Process Mailer == */
    case "processMailer":
        App::Admin()->processMailer();
        break;
    /* == Delete Inactive users == */
    case "processMInactive":
        Stats::deleteInactive(intval($_POST['days']));
        break;
    /* == Delete Banned Users == */
    case "processMIBanned":
        Stats::deleteBanned();
        break;
    /* == Delete Cart == */
    case "processMCart":
        Stats::emptyCart();
        break;
    /* == Page Builder == */
    case "pageBuilder":
        Admin::pageBuilder();
        break;
    /* == Process Configuration == */
    case "processConfig":
        App::Core()->processConfig();
        break;
    /* == Process Blog == */
    case "processBlog":
        App::Blog()->processBlog();
        break;
    /* == Update Blog == */
    case "updateBlog":
        App::Blog()->updateBlog();
        break;
    /* == Get Categories == */
    case "getCategories":
        App::Blog()->getCategories();
        break;
    /* == Process Categories == */
    case "processCategory":
        App::Category()->processCategory();
        break;
    /* == Add New Categories == */
    case "addNewCategory":
        App::Blog()->addNewCategory();
        break;
    /* == Update Category == */
    case "updateCategory":
        App::Category()->updateCategory();
        break;
endswitch;