<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require_once BASEPATH."../instagram/vendor/autoload.php";
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';


/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Authrest extends REST_Controller
{

    function __construct()
    {

        // Construct the parent class
        parent::__construct();
        $this->load->model('Publisher_model');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key

    }
    public function changepass_post()
    {

        $this->form_validation->set_rules('currentpass', 'Current Password', 'trim|required|min_length[5]|max_length[20]');
        $this->form_validation->set_rules('newpass', 'New Password', 'trim|required|min_length[5]|max_length[20]');
        if ($this->form_validation->run()) {
            require_once("accounts/init.php");
            $userID = App::Session()->get('userid');
            $username = App::Session()->get('MMP_username');
            $password = $this->post('currentpass');
            $newpass = $this->post('newpass');
            $status = App::Auth()->checkStatus($username, $password);
            if ($status == 'y') {
                //Update password here
                $salt = '';
                $hash = App::Auth()->create_hash(Validator::cleanOut($newpass), $salt);
                $data['hash'] = $hash;
                $data['salt'] = $salt;
                $result = $this->Publisher_model->update_record('user', $data, $userID);
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'Password Updated Successfully'
                ), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

            } else {
                // Set the response and exit
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'You have provided invalid current password',
                ), REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

            }
        } else {
            $errors = validation_errors();
            $this->response([
                'status' => FALSE,
                'message' => $errors,
            ], REST_Controller::HTTP_OK);
        }
    }
    public function login_post()
    {


        require_once("accounts/init.php");



        $this->form_validation->set_rules('username', 'User name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run()) {
            $username = $this->post('username');
            $password = $this->post('password');
            $login = App::Auth()->loginRest($username, $password);

            // $users = $this->Publisher_model->process_login($username,$password);
            if ($login['type'] == "success") {

                $this->response([
                    'status' => $login['user']->status,
                    'name' => $login['user']->fname,
                    'img' => $login['user']->avatar,
                    'message' => 'user found'
                ], REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => $login['message']
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            $errors = validation_errors();
            $this->response([
                'status' => FALSE,
                'message' => $errors,
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function signup_post()
    {
        require_once("accounts/init.php");
        App::Front()->Registration();
    }
    public function signupaffiliate_post()
    {
        // limit_check(AFFILIATE_FEATURE_ID);
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|min_length[3]|max_length[30]|alpha');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|min_length[3]|max_length[30]|alpha');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[20]');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[10]|alpha');


        if ($this->form_validation->run()) {
            $username = $this->post('username');
            $password = $this->post('password');
            $fname = $this->post('fname');
            $lname = $this->post('lname');
            $email = $this->post('email');
            $gmt = $this->post('timezone');
            $team_id = App::Session()->get('team_id');
            if (!$this->Publisher_model->check_username($username)) {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'This username already taken, please try different'
                ], REST_Controller::HTTP_OK);
                exit();
            } else if (!$this->Publisher_model->check_email($email)) {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'This email already exists in system'
                ], REST_Controller::HTTP_OK);
                exit();
            } else {
                $salt = Utility::randNumbers();
                $hash = App::Auth()->create_hash($password, $salt);
                $this->Publisher_model->register_affiliate($fname, $lname, $email, "N/A", $username, $hash, $salt, "N/A", "N/A", $gmt, $team_id);
                $core = App::Core();
                $mailer = Mailer::sendMail();
                $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'welcomeEmail'));
                $body = str_replace(array(
                    '[LOGO]',
                    '[DATE]',
                    '[LINK]',
                    '[COMPANY]',
                    '[USERNAME]',
                    '[PASSWORD]',
                    '[FB]',
                    '[TW]',
                    '[SITEURLMM]'
                ), array(
                    Utility::getLogo(),
                    date('Y'),
                    SITEURL,
                    $core->company,
                    $username,
                    $password,
                    $core->social->facebook,
                    $core->social->twitter,
                    SITEURL
                ), $tpl->body);

                $msg = (new Swift_Message())
                    ->setSubject($tpl->subject)
                    ->setFrom(array($core->site_email => $core->company))
                    ->setTo(array($email => $fname . ' ' . $lname))
                    ->setBody(
                        $body,
                        'text/html'
                    );
                $res = $mailer->send($msg);
                $this->response([
                    'status' => TRUE,
                    'message' => 'Great, Your awesome affiliate has been added, confirmation email has been sent'
                ], REST_Controller::HTTP_OK);

                exit();
            }
        } else {
            $errors = validation_errors();
            $this->response([
                'status' => FALSE,
                'message' => $errors,
            ], REST_Controller::HTTP_OK);
        }
    }
    public function resetpass_post()
    {
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required');
        if ($this->form_validation->run($this) == FALSE) {
            $this->response(array(
                'status' => "false",
                'message' => 'Email Is Required.',
            ), REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            exit;
        }

        $email = urldecode($_POST['email'] ?? '');
        if (!$email) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
            exit;
        }
        $pass = generateRandomString(6);
        $users = $this->Publisher_model->reset_password($email, $pass);

        if ($users) {
            $sql = "SELECT * FROM `user` WHERE `email`= '" . $email . "'";
            $row = $this->db->query($sql)->row();
            $title = "Password Updated Successfully";
            $name = $row->fname . $row->lname;
            $link = SITEURL . 'signin';
            $core = App::Core();
            $message = Lang::$word->M_INFO7;
            $mailer = Mailer::sendMail();
            $tpl = Db::run()->first(Content::eTable, array("body", "subject"), array('typeid' => 'userPassResetNotFromAccount'));
            $body = str_replace(array(
                '[COMPANY]',
                '[NAME]',
                '[EMAIL]',
                '[PASSWORD]',
                '[LINK]',
                '[SITEURL]'
            ), array(
                $core->company,
                $name,
                $email,
                $pass,
                $link,
                SITEURLMM
            ), $tpl->body);
            $msg = (new Swift_Message())
                ->setSubject($title)
                ->setFrom(array($core->site_email => $core->company))
                ->setTo(array($email => $name))
                ->setBody(
                    $body,
                    'text/html'
                );
            $email_res = $mailer->send($msg);
            if ($email_res) {
                $this->response(array(
                    'status' => "true",
                    'message' => 'Password Updated Successfully, Please Check your email for Login Details.'
                ), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(array(
                    'status' => "false",
                    'message' => 'Your email address is not valid, please provide correct email id.',
                ), REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            // Set the response and exit
            $this->response(array(
                'status' => "false",
                'message' => 'This email is not registered in our system, please provide correct email id.',
            ), REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function pagePosting_post()
    {

        $this->load->library('facebook');
        $id = trim($this->post('id'));
        $id_to_post = trim($this->post('id_to_post'));
        $posting = "";
        $post = $this->Publisher_model->retrieve_record('link', $id_to_post);
        $user = $this->Publisher_model->retrieve_record('user', $post->user_id);
        $type = $post->c_type;
        $page = $this->Publisher_model->retrieve_record('facebook_pages', $id);
        if ($type == 1) {
            $postData["link"] = trim($this->post('data_to_post'));
            $posting = $this->facebook->request('post', '/' . $page->page_id . '/feed', $postData, $page->access_token);
        } else {
            $postData["url"] = $post->img;
            //Here we need link replaced with short link and add into caption
            //First find from shorten links
            $with_utm = get_cp_link($post->id, $user, $post->site_us_pc);
            $short_link = get_create_shortlink($with_utm);
            $updated_cp['text'] = str_replace($post->site_us_pc, $short_link, $post->text);
            $postData["caption"] = str_replace('\r\n', "\n", $updated_cp['text']);
            $posting = $this->facebook->request('POST', "/" . $page->page_id . "/photos", $postData, (string) $page->access_token);
        }
        if ($posting) {
            if (!isset($posting['error'])) {
                $this->response(
                    [
                        'status' => TRUE,
                        'data' => $posting
                    ],
                    REST_Controller::HTTP_OK
                );
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => $posting['message']
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    // facebook group posting
    public function groupPosting_post()
    {
        $id = trim($this->post('id'));
        $id_to_post = trim($this->post('id_to_post'));
        $posting = "";
        $post = $this->Publisher_model->retrieve_record('link', $id_to_post);
        $user = $this->Publisher_model->retrieve_record('user', $post->user_id);
        $type = $post->c_type;
        $group = $this->Publisher_model->retrieve_record('facebook_groups', $id);

        if ($type == 1) {
            $link = trim($this->post('data_to_post'));
            $caption = $post->caption;

            $posting = $this->Publisher_model->publish_to_facebook_group($group->group_id, $link, $caption, true);
        } else {
            $link = $post->img;

            $with_utm = get_cp_link($post->id, $user, $post->site_us_pc);
            $short_link = get_create_shortlink($with_utm);
            $updated_cp['text'] = str_replace($post->site_us_pc, $short_link, $post->text);
            $caption = str_replace('\r\n', "\n", $updated_cp['text']);

            $posting = $this->Publisher_model->publish_to_facebook_group($group->group_id, $link, $caption, true);
        }
        if ($posting) {
            if (!isset($posting['error'])) {
                $this->response(
                    [
                        'status' => TRUE,
                        'data' => $posting
                    ],
                    REST_Controller::HTTP_OK
                );
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => $posting
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function boardPosting_post()
    {
        $id = trim($this->post('id'));
        $id_to_post = trim($this->post('id_to_post'));
        $data_link = trim($this->post('data_to_post'));
        $data_link = str_replace('utm_source=facebook', 'utm_source=pinterest', $data_link);
        $posting = "";
        $post = $this->Publisher_model->retrieve_record('link', $id_to_post);
        $user = $this->Publisher_model->retrieve_record('user', $post->user_id);
        $type = $post->c_type;

        $wheres = array(
            'user_id' => $post->user_id
        );
        $pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', $wheres);
        $board = $this->Publisher_model->retrieve_record('pinterest_boards', $id);


        if ($type == 1) {
            $data = [
                'title' => $post->text,
                'description' => $post->description,
                'link' => $data_link,
                'board_id' => $board->board_id,
                'image' => $post->img,
                'content_type' => 'image_url',
                'access_token' => $pinterest_user[0]->access_token,
            ];
        } else {
            $data = [
                'title' => $post->text,
                'description' => $post->description,
                'link' => $data_link,
                'board_id' => $board->board_id,
                'image' => $post->img,
                'content_type' => 'image_path',
                'access_token' => $pinterest_user[0]->access_token
            ];
        }
        // print_r($data);
        // die;
        if (isset($data)) {
            $posting = $this->Publisher_model->publish_pin_curl($data);
        }
        if ($posting) {
            if (!isset($posting['error'])) {
                $this->response(
                    [
                        'status' => TRUE,
                        'data' => $posting
                    ],
                    REST_Controller::HTTP_OK
                );
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => $posting['message']
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function igPosting_post()
    {
        $id = trim($this->post('id'));
        $id_to_post = trim($this->post('id_to_post'));
        $data_link = trim($this->post('data_to_post'));
        $data_link = str_replace('utm_source=facebook', 'utm_source=instagram', $data_link);
        $posting = "";
        $post = $this->Publisher_model->retrieve_record('link', $id_to_post);

        $wheres = array(
            'id' => $id
        );
        $ig_user = $this->Publisher_model->get_allrecords('instagram_users', $wheres);

        // PUblish Single Media Posts - Instagram
        // Step 1 of 2: Create Container
        $container = $this->Publisher_model->create_ig_media_container($ig_user[0]->instagram_id, $ig_user[0]->access_token, $post->img, $post->text);

        if (isset($container['id'])) {

            // Step 2 of 2: Publish Container
            $result = $this->Publisher_model->publish_ig_media_container($ig_user[0]->user_id, $container['id']);

            if (isset($result['id'])) {
                $this->response(
                    [
                        'status' => TRUE,
                        'data' => $result
                    ],
                    REST_Controller::HTTP_OK
                );
            } else {
                $this->response(
                    [
                        'status' => FALSE,
                        'data' => $result,
                        'message' => 'Something went wrong while publishing instagram post.'
                    ],
                    REST_Controller::HTTP_OK
                );
            }
        } else {
            $this->response(
                [
                    'status' => FALSE,
                    'data' => $container,
                    'message' => 'Something went wrong while publishing instagram container.'
                ],
                REST_Controller::HTTP_OK
            );
        }
    }

    public function activeAutoPost_post()
    {
        $id = trim($this->post('id'));
        $status = trim($this->post('status'));
        $type = $this->post('type');
        if ($type == 'facebook') {
            $result = $this->Publisher_model->update_record('facebook_pages', array('auto_posting' => $status), $id);
        } elseif ($type == 'pinterest') {
            $result = $this->Publisher_model->update_record('pinterest_boards', array('auto_posting' => $status), $id);
        }
        if ($result) {
            if ($status == "on") {
                $result_posting = $this->Publisher_model->renewAutoPostsList($id, $type);
            }
        }
        $this->response(
            [
                'status' => TRUE,
                'data' => $result
            ],
            REST_Controller::HTTP_OK
        ); // OK (200) being the HTTP response code
    }

    public function updateRandomAutoPosting_POST()
    {
        $id = trim($this->post('id'));
        $status = trim($this->post('status'));
        $result = $this->Publisher_model->retrieve_record('facebook_pages', $id);
        if (!empty($result)) {
            $status = $status == "ON" ? 1 : 0;
            $update = $this->Publisher_model->update_record('facebook_pages', array('random_auto_posting' => $status), $id);
            if ($update == 1) {
                $response = [
                    'status' => true,
                    'message' => 'Updated Successfully!'
                ];
            } else {
                $response = [
                    'status' => true,
                    'message' => 'Unknown error, please try again!'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Page not Found!'
            ];
        }
        $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    public function updateLoopAutoPosting_POST()
    {
        $id = trim($this->post('id'));
        $status = trim($this->post('status'));
        $result = $this->Publisher_model->retrieve_record('facebook_pages', $id);
        if (!empty($result)) {
            $status = $status == "ON" ? 1 : 0;
            $update = $this->Publisher_model->update_record('facebook_pages', array('loop_auto_posting' => $status), $id);
            if ($update == 1) {
                $response = [
                    'status' => true,
                    'message' => 'Updated Successfully!'
                ];
            } else {
                $response = [
                    'status' => true,
                    'message' => 'Unknown error, please try again!'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Page not Found!'
            ];
        }
        $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    public function youtubeAutoPost_post()
    {

        $id = trim($this->post('id'));
        $status = trim($this->post('status'));
        if ($status == "on") {
            $status = 1;
        }
        if ($status == "off") {
            $status = 0;
        }

        $result = $this->Publisher_model->update_record('youtube_channels', array('active' => $status), $id);
        if ($result) {
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function markreadNotification_post()
    {

        $id = trim($this->post('id'));
        $result = $this->Publisher_model->update_record('notifications', array('seen' => 1), $id);
        if ($result) {
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function disconnectFacebook_post()
    {
        $this->load->library('facebook');
        $userID = App::Session()->get('userid');
        $user_data = [];
        $user_data['facebook_id'] = "";
        $user_data['facebook_name'] = "";
        $user_data['facebook_email'] = "";
        $user_data['facebook_permanent_token'] = NULL;
        $user_data['facebook_permanent_token_genarated_date'] = NULL;
        $user_data['facebook_permanent_token'] = NULL;
        $user_data['facebook_dp'] = NULL;
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Facebook account not disconnected'], REST_Controller::HTTP_OK);
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $user = get_auth_user();
            $access_token = $user->facebook_permanent_token;
            $revoke = $this->facebook->request('DELETE', '/permissions', [], $access_token);
            $result = $this->Publisher_model->update_record('user', $user_data, $userID);
            $fb_pages = $this->Publisher_model->list_records('facebook_pages', 0, 1000, array('key' => 'user_id', 'value' => $userID), 'id', 'ASC');
            foreach ($fb_pages as $key => $value) {
                // revoke access token
                // delete queued posts
                $queued_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'channel_id', 'value' => $value->id],
                    ['key' => 'type', 'value' => 'facebook'],
                ];
                $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
                foreach ($queued_posts as $queued_post) {
                    $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                    remove_file($queued_post->link);
                    if ($queued_post->status == 0) {
                        resources_update('down', POST_SCHEDULING_FB_ID);
                    }
                }
                // delete group events
                $event_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'page_id', 'value' => $value->id],
                ];
                $events = $this->Publisher_model->list_records('events', 0, 100000, $event_where, 'id', 'ASC');
                foreach ($events as $event) {
                    $this->Publisher_model->delete_record('events', $event->id);
                    resources_update('down', GROUP_POSTING_ID);
                }
                // delete group bulkupload posts
                $bulkupload_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'page_id', 'value' => $value->id],
                ];
                $bulkupload_posts = $this->Publisher_model->list_records('bulkupload', 0, 100000, $bulkupload_where, 'id', 'ASC');
                foreach ($bulkupload_posts as $bulkupload_post) {
                    $this->Publisher_model->delete_record('bulkupload', $bulkupload_post->id);
                    remove_file($bulkupload_post->link);
                }
                // delete rss scheduled posts
                $rss_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'page_id', 'value' => $value->id],
                ];
                $rss_posts = $this->Publisher_model->list_records('rsssceduler', 0, 100000, $rss_where, 'id', 'ASC');
                foreach ($rss_posts as $rss_post) {
                    $this->Publisher_model->delete_record('rsssceduler', $rss_post->id);
                    if ($rss_post->posted == 0) {
                        if ($rss_post->post_type == 'latest') {
                            resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                        }
                        if ($rss_post->post_type == 'past') {
                            resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                        }
                    }
                }
                // delete facebook page
                $this->Publisher_model->delete_record('facebook_pages', $value->id);
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            }
            // delete facebook
            $facebooks = $this->Publisher_model->get_allrecords("facebook", array("user_id" => $userID));
            foreach ($facebooks as $facebook) {
                $this->Publisher_model->delete_record('facebook', $facebook->id);
            }
            // delete facebook
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            );
        }
    }

    public function disconnectYoutube_POST()
    {
        $userID = App::Session()->get('userid');
        $user_data = [];
        $user_data['google_id'] = NULL;
        $user_data['google_name'] = NULL;
        $user_data['google_email'] = NULL;
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'YouTube account not disconnected'], REST_Controller::HTTP_OK);
            // $result = $this->Publisher_model->update_record('user', $user_data, $userID);
            // $multiple = $this->Publisher_model->delete_multiple('google_users', 'user_id', $userID);
            // if ($result && $multiple) {
            //     $this->response(['status' => true, 'message' => 'YouTube account disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            // } else {
            //     $this->response(['status' => false, 'message' => 'YouTube account not disconnected'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            // }
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $result = $this->Publisher_model->update_record('user', $user_data, $userID);
            $yt_channels = $this->Publisher_model->list_records('youtube_channels', 0, 1000, array('key' => 'user_id', 'value' => $userID), 'id', 'ASC');
            foreach ($yt_channels as $key => $value) {
                // delete queued posts
                $queued_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'channel_id', 'value' => $value->id],
                ];
                $queued_posts = $this->Publisher_model->list_records('youtube_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
                foreach ($queued_posts as $queued_post) {
                    $this->Publisher_model->delete_record('youtube_scheduler', $queued_post->id);
                    // remove video from AWS
                    remove_from_s3bucket($queued_post->video_link);
                    // remove video thumbnail
                    remove_file($queued_post->thumbnail_link);
                    if ($queued_post->published == 0) {
                        resources_update('down', POST_SCHEDULING_YT_ID);
                    }
                }
                // delete google user
                $google_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'google_id', 'value' => $value->google_id],
                ];
                $google_users = $this->Publisher_model->list_records('google_users', 0, 100000, $google_where, 'id', 'ASC');
                foreach ($google_users as $google_user) {
                    $this->Publisher_model->delete_record('google_users', $google_user->id);
                }
                // delete youtube channel
                $this->Publisher_model->delete_record('youtube_channels', $value->id);
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            }
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            );
        }
    }

    public function disconnectTiktok_POST()
    {
        $userID = App::Session()->get('userid');
        $user_data = [];
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Facebook account not disconnected'], REST_Controller::HTTP_OK);
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $tiktoks = $this->Publisher_model->list_records('tiktok', 0, 1000, array('key' => 'user_id', 'value' => $userID), 'id', 'ASC');
            foreach ($tiktoks as $key => $value) {
                $this->load->library('tiktok');
                $revoke = $this->tiktok->revokeAccess($value->access_token);
                // delete queued posts
                $queued_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'channel_id', 'value' => $value->id],
                    ['key' => 'type', 'value' => 'tiktok'],
                ];
                $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
                foreach ($queued_posts as $queued_post) {
                    $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                    remove_file($queued_post->link);
                    if ($queued_post->status == 0) {
                        // resources_update('down', POST_SCHEDULING_FB_ID);
                    }
                }
                // delete rss scheduled posts
                $rss_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'open_id', 'value' => $value->id],
                ];
                $rss_posts = $this->Publisher_model->list_records('tiktok_scheduler', 0, 100000, $rss_where, 'id', 'ASC');
                foreach ($rss_posts as $rss_post) {
                    $this->Publisher_model->delete_record('tiktok_scheduler', $rss_post->id);
                    if ($rss_post->posted == 0) {
                        if ($rss_post->post_type == 'latest') {
                            // resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                        }
                        if ($rss_post->post_type == 'past') {
                            // resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                        }
                    }
                }
                // delete facebook page
                $this->Publisher_model->delete_record('tiktok', $value->id);
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            }
            $this->response(
                [
                    'status' => TRUE,
                    'data' => 1
                ],
                REST_Controller::HTTP_OK
            );
        }
    }

    public function updateUserActiveHours_post()
    {

        $userID = trim($this->post('id'));
        $user_data = [];

        $start = $this->post('start'); //$this->Publisher_model->time_pop();
        $end = $this->post('end'); //$this->Publisher_model->time_pop($this->post('end'));
        $user = $this->Publisher_model->retrieve_record('user', $userID);
        $user_data['posting_start'] = localToUTC($start, $user->gmt, 'H:i:s');
        $user_data['posting_end'] = localToUTC($end, $user->gmt, 'H:i:s');
        $user_data['posting_interval'] = trim($this->post('interval'));
        $result = $this->Publisher_model->update_record('user', $user_data, $userID);
        if ($result) {
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function updateUserIG_post()
    {


        $userID = App::Session()->get('userid');
        $user_data = [];
        $user_data['ig_username'] = $this->post('ig_username');
        $user_data['ig_pass'] = $this->post('ig_pass');

        /////// CONFIG ///////
        $username = $user_data['ig_username'];
        $password = $user_data['ig_pass'];
        $debug = true;
        $truncatedDebug = false;
        //////////////////////
        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        //////////////////////
        $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
        try {

            $loginResponse = $ig->login($username, $password);
            print_r($loginResponse);
            die();
            if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) {
                $twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();

                $this->response([
                    'status' => FALSE,
                    'message' => 'Please Enter code you got via sms'
                ], REST_Controller::HTTP_OK);

                //$verificationCode = trim(fgets(STDIN));
                //$ig->finishTwoFactorLogin($username, $password, $twoFactorIdentifier, $verificationCode);
            }
        } catch (\Exception $e) {
            echo 'Something went wrong: ' . $e->getMessage() . "\n";
        }

        $result = $this->Publisher_model->update_record('user', $user_data, $userID);
        if ($result) {
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function disconnectFacebookPage_post()
    {
        $pageId = trim($this->post('id'));
        $multiple = $this->Publisher_model->delete_multiple('facebook_pages', 'id', $pageId);
        if ($multiple) {
            //select bulk uploads scheduled posts by page id;
            $result_bulk = $this->Publisher_model->list_records('bulkupload', 0, 10000, array('key' => 'page_id', 'value' => $pageId), 'id', 'DESC');
            if ($result_bulk) {
                if ("::1" == $_SERVER['REMOTE_ADDR']) {

                    $delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/";
                } else {

                    $delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/";
                }
                foreach ($result_bulk as $key => $row) {
                    if ($this->Publisher_model->delete_record('bulkupload', $row->id)) {
                        resources_update('down', BULKIMAGES_FEATURE_ID);
                        $unlink = unlink($delete_path . $row->link);
                    }
                }
            }

            $result = $this->Publisher_model->delete_multiple('sceduler', 'page_id', $pageId);
            $result = $this->Publisher_model->delete_multiple('rsssceduler', 'page_id', $pageId);
            $delete_events = $this->Publisher_model->delete_multiple('events', 'page_id', $pageId);

            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function disconnectYoutubeChannel_POST()
    {
        $userID = App::Session()->get('userid');
        $pageId = trim($this->post('id'));
        $multiple = $this->Publisher_model->delete_multiple('youtube_channels', 'id', $pageId);
        if ($multiple) {
            $result = $this->db->query("SELECT * from youtube_channels where user_id='$userID' ");
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function disconnectFacebookEvent_post()
    {
        $eventId = trim($this->post('id'));
        $multiple = $this->Publisher_model->delete_record('events', $eventId);
        if ($multiple) {
            //select bulk uploads scheduled posts by page id;
            $result_bulk = $this->Publisher_model->list_records('bulkupload', 0, 10000, array('key' => 'event_id', 'value' => $eventId), 'id', 'DESC');
            $total = count($result_bulk);
            if ($result_bulk) {
                if ("::1" == $_SERVER['REMOTE_ADDR']) {

                    $delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/";
                } else {

                    $delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/";
                }
                foreach ($result_bulk as $key => $row) {
                    if ($this->Publisher_model->delete_record('bulkupload', $row->id)) {
                        resources_update('down', BULKIMAGES_FEATURE_ID);
                        $unlink = unlink($delete_path . $row->link);
                    }
                }
            }
            resources_update('down', GROUP_POSTING_ID);
            $this->response(
                [
                    'total' => $total,
                    'status' => TRUE,
                    'data' => $multiple
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function disconnectFacebookPost_post()
    {
        $postId = trim($this->post('id'));
        if ($postId == "all") {
            $pageId = trim($this->post('page'));
            $result = $this->Publisher_model->delete_multiple('sceduler', 'page_id', $pageId);
            $page_data['last_post_id'] = null;
            $this->Publisher_model->update_record('facebook_pages', $page_data, $pageId);
            $this->Publisher_model->renewAutoPostsList($pageId, "facebook");
        } else {
            $result = $this->Publisher_model->delete_autopostsingle($postId, 'facebook');
        }
        if ($result) {
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function disconnecPinterestPost_post()
    {
        $postId = trim($this->post('id'));
        if ($postId == "all") {
            $pageId = trim($this->post('page'));
            $result = $this->Publisher_model->delete_multiple('sceduler', 'page_id', $pageId);
            $page_data['last_post_id'] = null;
            $this->Publisher_model->update_record('pinterest_boards', $page_data, $pageId);
            $this->Publisher_model->renewAutoPostsList($pageId, "pinterest");
        } else {
            $result = $this->Publisher_model->delete_autopostsingle($postId, 'pinterest');
        }
        if ($result) {
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function updateFacebookPost_post()
    {
        $id = trim($this->post('id'));
        $text = trim($this->post('text'));
        $post_time = trim($this->post('time'));
        $user_id = trim($this->post('user_id'));


        $post_data = [];
        $post_data['post_title'] = $text;
        // $pop = $this->Publisher_model->time_pop($post_time);
        $user = $this->Publisher_model->retrieve_record('user', $user_id);
        $post_data['post_datetime'] = localToUTC($post_time, $user->gmt, "Y-m-d H:i:s");
        $result = $this->Publisher_model->update_record('sceduler', $post_data, $id);
        if ($result) {

            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function quantityAutoPost_post()
    {

        $id = trim($this->post('id'));
        $value = trim($this->post('value'));
        $result = $this->Publisher_model->update_record('facebook_pages', array('number_of_posts' => $value), $id);
        // $result2 = $this->Publisher_model->scedule_posts($id);
        if ($result) {

            $this->response(
                [
                    'status' => TRUE,
                    'data' => $result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function commingPosts_post()
    {
        $id = trim($this->post('id'));
        $user_id = trim($this->post('user_id'));
        $result = $this->Publisher_model->list_records('sceduler', 0, 1000, array('key' => 'page_id', 'value' => $id), 'post_datetime', 'ASC');
        if ($result) {
            $new_result = [];
            $user = $this->Publisher_model->retrieve_record('user', $user_id);
            foreach ($result as $key => $row) {
                $post = $this->Publisher_model->retrieve_record('link', $row->post_id);
                $new_result[$key]['id'] = $row->id;
                $new_result[$key]['img'] = $post->img;
                $new_result[$key]['text'] = $row->post_title;
                $new_result[$key]['link'] = $post->site_us_pc;
                $new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "F j, Y, g:i a");
                $new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "H:i A");
                $new_result[$key]['type'] = $row->type;
            }
            $this->response(
                [
                    'status' => TRUE,
                    'data' => $new_result
                ],
                REST_Controller::HTTP_OK
            ); // OK (200) being the HTTP response code
        } else {
            //Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Please try again'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function get_campaigns_post()
    {
        $userID = App::Session()->get('userid');
        $user = $this->Publisher_model->retrieve_record('user', $userID);
        $team_id = App::Session()->get('team_id');
        $team_role = App::Session()->get('team_role');
        $page = @$this->post('page');
        $request = @$this->post('request');
        $cat = @$this->post('cat');
        $popularity = @$this->post('popularity');
        $keyword = @$this->post('keyword');
        $domain = @$this->post('domain');
        $campaign_results = $this->Publisher_model->owner_get_campaigns($request, $cat, $popularity, $keyword, $page, $domain, $team_id);
        $campaigns = [];
        $data = [];
        $i = 0;
        foreach ($campaign_results['campaigns'] as $row) {
            $campaigns[$i]['campaign_link'] = $row->site_us_pc;
            $cplink = get_cp_link($row->id, $user, $row->site_us_pc);
            $campaigns[$i]['cplink'] = $cplink;
            $campaign_link = $row->site_us_pc;
            $text_of_campaign = $row->text;
            $caption = $row->caption;
            $withcaption = $text_of_campaign . " " . $cplink;
            if (strlen($caption) > 0) {
                $withcaption = $caption . " " . $cplink;
            }
            if (strlen($text_of_campaign) > 120) {
                $text_of_campaign = substr($text_of_campaign, 0, 120) . " ...";
            }
            $campaigns[$i]['id'] = $row->id;
            $campaigns[$i]['withcaption'] = $withcaption;
            $campaigns[$i]['withoutcaption'] = $cplink;
            $total_clicks = $this->Publisher_model->get_clicks($popularity, $row->id);
            $campaigns[$i]['total_clicks'] = cnf($total_clicks, 1);
            $campaigns[$i]['img'] = $row->img;
            $campaigns[$i]['campaign_heading'] = $text_of_campaign;
            $i++;
        }

        if ($request == "filter") {
            //usort($campaigns, $this->make_comparer(['total_clicks', SORT_DESC]));
        }
        $data['campaigns'] = $campaigns;
        $data['count'] = $campaign_results['count'];
        $data['pagesize'] = $campaign_results['pagesize'];
        if ($team_role == "owner") {
            $data['is_owner'] = TRUE;
        } else {
            $data['is_owner'] = FALSE;
        }

        $this->response([
            'status' => TRUE,
            'data' => $data,
            'message' => 'campaigns request fullfilled'
        ], REST_Controller::HTTP_OK);
    }

    public function load_more_getcampaigns_POST()
    {
        $userID = App::Session()->get('userid');
        $user = $this->Publisher_model->retrieve_record('user', $userID);
        $team_id = App::Session()->get('team_id');
        $team_role = App::Session()->get('team_role');
        $page = @$this->post('page');
        $request = @$this->post('request');
        $cat = @$this->post('cat');
        $popularity = @$this->post('popularity');
        $keyword = @$this->post('keyword');
        $domain = @$this->post('domain');
        $campaign_results = $this->Publisher_model->owner_get_campaigns($request, $cat, $popularity, $keyword, $page, $domain, $team_id);
        $campaigns = [];
        $data = [];
        $i = 0;
        foreach ($campaign_results['campaigns'] as $row) {
            $campaigns[$i]['campaign_link'] = $row->site_us_pc;
            $cplink = get_cp_link($row->id, $user, $row->site_us_pc);
            $campaigns[$i]['cplink'] = $cplink;
            $campaign_link = $row->site_us_pc;
            $text_of_campaign = $row->text;
            $caption = $row->caption;
            $withcaption = $text_of_campaign . " " . $cplink;
            if (strlen($caption) > 0) {
                $withcaption = $caption . " " . $cplink;
            }
            if (strlen($text_of_campaign) > 120) {
                $text_of_campaign = substr($text_of_campaign, 0, 120) . " ...";
            }
            $campaigns[$i]['id'] = $row->id;
            $campaigns[$i]['withcaption'] = $withcaption;
            $campaigns[$i]['withoutcaption'] = $cplink;
            $total_clicks = $this->Publisher_model->get_clicks($popularity, $row->id);
            $campaigns[$i]['total_clicks'] = cnf($total_clicks, 1);
            $campaigns[$i]['img'] = $row->img;
            $campaigns[$i]['campaign_heading'] = $text_of_campaign;
            $i++;
        }

        if ($request == "filter") {
            //usort($campaigns, $this->make_comparer(['total_clicks', SORT_DESC]));
        }
        $data['campaigns'] = $campaigns;
        $data['count'] = $campaign_results['count'];
        $data['pagesize'] = $campaign_results['pagesize'];
        if ($team_role == "owner") {
            $data['is_owner'] = TRUE;
        } else {
            $data['is_owner'] = FALSE;
        }

        $this->response([
            'status' => TRUE,
            'data' => $data,
            'message' => 'campaigns request fullfilled'
        ], REST_Controller::HTTP_OK);
    }

    function clean($string)
    {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return $string = str_replace('-', ' ', preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
    }
    public function getcountrywise_GET()
    {
        $rangedata = [];
        $rangedata['start'] = $this->get('start');
        $rangedata['end'] = $this->get('end');
        $rangedata['username'] = $this->get('username');
        $response = [];
        $response_table = "";
        if ($rangedata['start'] != "" || $rangedata['end'] != "") {
            $response = [];
            $total_clicks = 0;
            $total_earn = 0;
            $result = $this->Publisher_model->getcountrywise($rangedata);
            if ($result) {
                foreach ($result as $row) {
                    $response_table .= "<tr>
                    <td><img src='assets/general/flags/" . $row['code'] . ".png'></td>
                    <td>" . $row['country'] . "</td>
                    <td>" . cnf($row['click'], 2) . "</td>
                    <td>$" . $row['earn'] . "</td>
                </tr>";
                    $total_clicks += $row['click'];
                    $total_earn += $row['earn'];
                }
                $data['summary'] =
                    '<table class="table v-middle table table-striped table-hover">
                    <tbody>
                    <tr>
                        <td style="padding-left: 0px;border:0px;">EARNING: $ ' . round($total_earn, 2) . '</td>
                        <td style="border:0px;" >CLICKS: ' . cnf($total_clicks, 2) . '</td>
                        </tr>
                    </tbody>
                </table>';

                $data['table'] = $response_table;
                $response['status'] = true;
                $response['message'] = "data found successfully";
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = "No data found, Please provide Valid Date Range";
            }
        } else {

            $response['status'] = false;
            $response['message'] = "No data found, Please provide Valid Date Range";
        }

        $this->response($response, REST_Controller::HTTP_OK);
    }
    public function make_comparer()
    {
        // Normalize criteria up front so that the comparer finds everything tidy
        $criteria = func_get_args();
        foreach ($criteria as $index => $criterion) {
            $criteria[$index] = is_array($criterion)
                ? array_pad($criterion, 3, null)
                : array($criterion, SORT_ASC, null);
        }

        return function ($first, $second) use ($criteria) {
            foreach ($criteria as $criterion) {
                // How will we compare this round?
                list($column, $sortOrder, $projection) = $criterion;
                $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

                // If a projection was defined project the values now
                if ($projection) {
                    $lhs = call_user_func($projection, $first[$column]);
                    $rhs = call_user_func($projection, $second[$column]);
                } else {
                    $lhs = $first[$column];
                    $rhs = $second[$column];
                }

                // Do the actual comparison; do not return if equal
                if ($lhs < $rhs) {
                    return -1 * $sortOrder;
                } else if ($lhs > $rhs) {
                    return 1 * $sortOrder;
                }
            }

            return 0; // tiebreakers exhausted, so $first == $second
        };
    }

    public function disconnectPinterest_post()
    {
        $userID = App::Session()->get('userid');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Pinterest account not disconnected'], REST_Controller::HTTP_OK);
            // $result = $this->Publisher_model->update_record_mc('pinterest_users', $pinterest_user, $wheres);
            // $multiple = $this->Publisher_model->delete_multiple('pinterest_boards', 'user_id', $userID);
            // if ($result && $multiple) {
            //     $this->response(['status' => true, 'message' => 'Pinterest account disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            // } else {
            //     $this->response(['status' => false, 'message' => 'Pinterest account not disconnected'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            // }
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $pin_boards = $this->Publisher_model->list_records('pinterest_boards', 0, 1000, array('key' => 'user_id', 'value' => $userID), 'id', 'ASC');
            foreach ($pin_boards as $key => $value) {
                // delete queued posts
                $queued_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'channel_id', 'value' => $value->id],
                    ['key' => 'type', 'value' => 'pinterest'],
                ];
                $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
                foreach ($queued_posts as $queued_post) {
                    $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                    remove_file($queued_post->link);
                    if ($queued_post->status == 0) {
                        resources_update('down', POST_SCHEDULING_PIN_ID);
                    }
                }
                // delete rss scheduled posts
                $rss_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'board_id', 'value' => $value->id],
                ];
                $rss_posts = $this->Publisher_model->list_records('pinterest_scheduler', 0, 100000, $rss_where, 'id', 'ASC');
                foreach ($rss_posts as $rss_post) {
                    $this->Publisher_model->delete_record('pinterest_scheduler', $rss_post->id);
                    if ($rss_post->published == 0) {
                        if ($rss_post->post_type == 'latest') {
                            resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                        }
                        if ($rss_post->post_type == 'past') {
                            resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                        }
                    }
                }
                // delete pinterest board
                $this->Publisher_model->delete_record('pinterest_boards', $value->id);
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            }
            // delete pinterest user
            $this->Publisher_model->delete_multiple('pinterest_users', 'user_id', $userID);
            $this->response(
                [
                    'status' => TRUE,
                ],
                REST_Controller::HTTP_OK
            );
        }
    }

    public function disconnectIg_post()
    {
        $userID = App::Session()->get('userid');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Instagram account not disconnected'], REST_Controller::HTTP_OK);
            // $multiple = $this->Publisher_model->delete_multiple('instagram_users', 'user_id', $userID);
            // if ($multiple) {
            //     $this->response(['status' => true, 'message' => 'Instagram account disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            // } else {
            //     $this->response(['status' => false, 'message' => 'Instagram account not disconnected'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            // }
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $ig_users = $this->Publisher_model->list_records('instagram_users', 0, 1000, array('key' => 'user_id', 'value' => $userID), 'id', 'ASC');
            foreach ($ig_users as $key => $value) {
                // delete queued posts
                $queued_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'channel_id', 'value' => $value->id],
                    ['key' => 'type', 'value' => 'instagram'],
                ];
                $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
                foreach ($queued_posts as $queued_post) {
                    $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                    remove_file($queued_post->link);
                    if ($queued_post->status == 0) {
                        resources_update('down', POST_SCHEDULING_INST_ID);
                    }
                }
                // delete rss scheduled posts
                $rss_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'ig_id', 'value' => $value->id],
                ];
                $rss_posts = $this->Publisher_model->list_records('instagram_scheduler ', 0, 100000, $rss_where, 'id', 'ASC');
                foreach ($rss_posts as $rss_post) {
                    $this->Publisher_model->delete_record('rsssceduler', $rss_post->id);
                    if ($rss_post->published == 0) {
                        if ($rss_post->post_type == 'latest') {
                            resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                        }
                        if ($rss_post->post_type == 'past') {
                            resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                        }
                    }
                }
                // delete instagram user
                $this->Publisher_model->delete_record('instagram_users', $value->id);
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            }
            $this->response(
                [
                    'status' => TRUE,
                ],
                REST_Controller::HTTP_OK
            );
        }
    }

    public function disconnect_fb_groups_post()
    {
        $user_id = App::Session()->get('userid');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $multiple = $this->Publisher_model->delete_multiple('facebook_groups', 'user_id', $user_id);
            if ($multiple) {
                $this->response(['status' => true, 'message' => 'Facebook groups disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(['status' => false, 'message' => 'Facebook groups not disconnected'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $multiple = $this->Publisher_model->delete_multiple('facebook_groups', 'user_id', $user_id);
            if ($multiple) {
                $del_fb_group_scheduler = $this->Publisher_model->delete_multiple('facebook_group_scheduler', 'user_id', $user_id);

                $wheres[0]['key'] = "user_id";
                $wheres[0]['value'] = $user_id;
                $wheres[1]['key'] = "type";
                $wheres[1]['value'] = "fb_groups";
                $result_channels_scheduler = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $wheres, 'id', 'DESC');
                if ($result_channels_scheduler) {
                    foreach ($result_channels_scheduler as $key => $row) {
                        $this->Publisher_model->delete_record('channels_scheduler', $row->id);
                    }
                }
                $this->response(['status' => true, 'message' => 'Facebook groups disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(['status' => false, 'message' => 'Facebook groups not disconnected'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function deletefbpage_post()
    {
        $userID = App::Session()->get('userid'); //user id
        $id = $this->input->post('id'); //page id
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            // get facebook page
            $value = $this->Publisher_model->retrieve_record('facebook_pages', $id);
            if (!empty($value)) {
                // delete queued posts
                $queued_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'channel_id', 'value' => $value->id],
                ];
                $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
                foreach ($queued_posts as $queued_post) {
                    $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                    remove_file($queued_post->link);
                    if ($queued_post->status == 0) {
                        resources_update('down', POST_SCHEDULING_FB_ID);
                    }
                }
                // delete group events
                $event_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'page_id', 'value' => $value->id],
                ];
                $events = $this->Publisher_model->list_records('events', 0, 100000, $event_where, 'id', 'ASC');
                foreach ($events as $event) {
                    $this->Publisher_model->delete_record('events', $event->id);
                    resources_update('down', GROUP_POSTING_ID);
                }
                // delete group bulkupload posts
                $bulkupload_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'page_id', 'value' => $value->id],
                ];
                $bulkupload_posts = $this->Publisher_model->list_records('bulkupload', 0, 100000, $bulkupload_where, 'id', 'ASC');
                foreach ($bulkupload_posts as $bulkupload_post) {
                    $this->Publisher_model->delete_record('bulkupload', $bulkupload_post->id);
                    remove_file($bulkupload_post->link);
                }
                // delete rss scheduled posts
                $rss_where = [
                    ['key' => 'user_id', 'value' => $userID],
                    ['key' => 'page_id', 'value' => $value->id],
                ];
                $rss_posts = $this->Publisher_model->list_records('rsssceduler', 0, 100000, $rss_where, 'id', 'ASC');
                foreach ($rss_posts as $rss_post) {
                    $this->Publisher_model->delete_record('rsssceduler', $rss_post->id);
                    if ($rss_post->posted == 0) {
                        if ($rss_post->post_type == 'latest') {
                            resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                        }
                        if ($rss_post->post_type == 'past') {
                            resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                        }
                    }
                }
                // delete facebook page
                $this->Publisher_model->delete_record('facebook_pages', $value->id);
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            }
            $this->response(['status' => true, 'message' => 'Facebook page disconnected successfully!'], REST_Controller::HTTP_OK);
        }
    }
    public function deletepinterestboard_post()
    {
        $userID = App::Session()->get('userid'); //user id
        $id = $this->input->post('id'); //board id
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $value = $this->Publisher_model->retrieve_record('pinterest_boards', $id);
            // delete queued posts
            $queued_where = [
                ['key' => 'user_id', 'value' => $userID],
                ['key' => 'channel_id', 'value' => $value->id],
                ['key' => 'type', 'value' => 'pinterest'],
            ];
            $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
            foreach ($queued_posts as $queued_post) {
                $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                remove_file($queued_post->link);
                if ($queued_post->status == 0) {
                    resources_update('down', POST_SCHEDULING_PIN_ID);
                }
            }
            // delete rss scheduled posts
            $rss_where = [
                ['key' => 'user_id', 'value' => $userID],
                ['key' => 'board_id', 'value' => $value->id],
            ];
            $rss_posts = $this->Publisher_model->list_records('pinterest_scheduler', 0, 100000, $rss_where, 'id', 'ASC');
            foreach ($rss_posts as $rss_post) {
                $this->Publisher_model->delete_record('pinterest_scheduler', $rss_post->id);
                if ($rss_post->published == 0) {
                    if ($rss_post->post_type == 'latest') {
                        resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                    }
                    if ($rss_post->post_type == 'past') {
                        resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                    }
                }
            }
            // delete pinterest board
            $this->Publisher_model->delete_record('pinterest_boards', $value->id);
            resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            $this->response(['status' => true, 'message' => 'Pinterest board disconnected successfully!'], REST_Controller::HTTP_OK);
        }
    }
    public function deleteinstaaccount_post()
    {
        $userID = App::Session()->get('userid'); //user id
        $id = $this->input->post('id');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $value = $this->Publisher_model->retrieve_record('instagram_users', $id);
            // delete queued posts
            $queued_where = [
                ['key' => 'user_id', 'value' => $userID],
                ['key' => 'channel_id', 'value' => $value->id],
                ['key' => 'type', 'value' => 'instagram'],
            ];
            $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
            foreach ($queued_posts as $queued_post) {
                $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                remove_file($queued_post->link);
                if ($queued_post->status == 0) {
                    resources_update('down', POST_SCHEDULING_INST_ID);
                }
            }
            // delete rss scheduled posts
            $rss_where = [
                ['key' => 'user_id', 'value' => $userID],
                ['key' => 'ig_id', 'value' => $value->id],
            ];
            $rss_posts = $this->Publisher_model->list_records('instagram_scheduler ', 0, 100000, $rss_where, 'id', 'ASC');
            foreach ($rss_posts as $rss_post) {
                $this->Publisher_model->delete_record('rsssceduler', $rss_post->id);
                if ($rss_post->published == 0) {
                    if ($rss_post->post_type == 'latest') {
                        resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                    }
                    if ($rss_post->post_type == 'past') {
                        resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                    }
                }
            }
            // delete instagram user
            $this->Publisher_model->delete_record('instagram_users', $value->id);
            resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            $this->response(['status' => true, 'message' => 'Instagram account disconnected successfully!'], REST_Controller::HTTP_OK);
        }
    }
    public function deletefbgroup_post()
    {
        $user_id = App::Session()->get('userid'); //user id
        $id = $this->input->post('id');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->db->select('*')->from('channels_scheduler')->where('channel_id', $id)->where('user_id', $user_id)->where('type', 'fb_groups');
            $query = $this->db->get()->result_array();
            if (!empty($query)) {
                $this->db->where('channel_id', $id);
                $this->db->where('user_id', $user_id);
                $this->db->where('type', 'fb_groups');
                $this->db->set('active_deactive_status', 0);
                $this->db->update('channels_scheduler');
            }
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->set('active_deactive_status', 0);
            if ($this->db->update('facebook_groups')) {
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
                $this->response(['status' => true, 'message' => 'This Facebook Group is disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $this->db->select('*')->from('channels_scheduler')->where('channel_id', $id)->where('user_id', $user_id)->where('type', 'fb_groups');
            $query = $this->db->get()->result_array();
            if (!empty($query)) {
                $this->db->where('channel_id', $id);
                $this->db->where('user_id', $user_id);
                $this->db->where('type', 'fb_groups');
                $this->db->delete('channels_scheduler');
            }
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->set('active_deactive_status', 0);
            if ($this->db->delete('facebook_groups')) {
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
                $this->response(['status' => true, 'message' => 'This Facebook Group is disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function deleteyoutube_post()
    {
        $user_id = App::Session()->get('userid'); //user id
        $id = $this->input->post('id');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->db->select('*')->from('youtube_channels')->where('id', $id)->where('user_id', $user_id);
            $query = $this->db->get()->result_array();
            if (!empty($query)) {
                $this->db->where('channel_id', $id);
                $this->db->where('user_id', $user_id);
                $this->db->where('type', 'youtube');
                $this->db->set('active_deactive_status', 0);
                $this->db->update('channels_scheduler');
            }
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->set('active', 0);
            $this->db->set('channel_active', 0);
            if ($this->db->update('youtube_channels')) {
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
                $this->response(['status' => true, 'message' => 'This YouTube Channel is disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {

                $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $this->db->select('*')->from('youtube_scheduler')->where('channel_id', $id)->where('user_id', $user_id);
            $query = $this->db->get()->result_array();
            if (!empty($query)) {
                $this->db->where('channel_id', $id);
                $this->db->where('user_id', $user_id);
                $this->db->delete('youtube_scheduler');
            }
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            $this->db->set('active', 0);
            $this->db->set('channel_active', 0);
            if ($this->db->delete('youtube_channels')) {
                resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
                $this->response(['status' => true, 'message' => 'This YouTube Channel is disconnected successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function deletetiktok_POST()
    {
        $userID = App::Session()->get('userid'); //user id
        $id = $this->input->post('id');
        $disconnect_variable = $this->input->post('action');
        if ($disconnect_variable === 'disconnect_only') {
            $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST);
        } elseif ($disconnect_variable === 'disconnect_and_delete') {
            $value = $this->Publisher_model->retrieve_record('tiktok', $id);
            // delete queued posts
            $queued_where = [
                ['key' => 'user_id', 'value' => $userID],
                ['key' => 'channel_id', 'value' => $value->id],
                ['key' => 'type', 'value' => 'tiktok'],
            ];
            $queued_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $queued_where, 'id', 'ASC');
            foreach ($queued_posts as $queued_post) {
                $this->Publisher_model->delete_record('channels_scheduler', $queued_post->id);
                remove_file($queued_post->link);
                if ($queued_post->status == 0) {
                    // resources_update('down', POST_SCHEDULING_PIN_ID);
                }
            }
            // delete rss scheduled posts
            $rss_where = [
                ['key' => 'user_id', 'value' => $userID],
                ['key' => 'open_id', 'value' => $value->id],
            ];
            $rss_posts = $this->Publisher_model->list_records('tiktok_scheduler', 0, 100000, $rss_where, 'id', 'ASC');
            foreach ($rss_posts as $rss_post) {
                $this->Publisher_model->delete_record('tiktok_scheduler', $rss_post->id);
                if ($rss_post->published == 0) {
                    if ($rss_post->post_type == 'latest') {
                        // resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
                    }
                    if ($rss_post->post_type == 'past') {
                        // resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
                    }
                }
            }
            // delete pinterest board
            $this->Publisher_model->delete_record('tiktok', $value->id);
            resources_update('down', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
            $this->response(['status' => true, 'message' => 'TikTok Account disconnected successfully!'], REST_Controller::HTTP_OK);
        }
    }

    public function clearcronjoberror_post()
    {
        $id = $this->input->post('id'); //user id
        $type = $this->input->post('type'); // means which channel
        if ($type == 'pinterest') {
            $error_column_name = 'pinterest_error';
        } elseif ($type == 'fb_page') {
            $error_column_name = 'facebook_page_error';
        } elseif ($type == 'instagram') {
            $error_column_name = 'instagram_error';
        } elseif ($type == 'fb_group') {
            $error_column_name = 'facebook_group_error';
        }
        $this->db->where('id', $id);
        $this->db->set($error_column_name, null); // Set the 'error_column' to an empty string
        if ($this->db->update('user')) {
            $this->response(['status' => true, 'message' => 'Error Cleared Successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->response(['status' => false, 'message' => 'Something went wrong please try again'], REST_Controller::HTTP_BAD_REQUEST); // NOT_FOUND (404) being the HTTP response code
        }
    }
}
