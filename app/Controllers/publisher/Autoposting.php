<?php

/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - index()
 * - facebookbulkupload()
 * - instagrambulkupload()
 * - dailysceduler()
 * - indexbackup()
 * Classes list:
 * - Autoposting extends CI_Controller
 */
defined('BASEPATH') or exit('No direct script access allowed');
//require(APPPATH.'libraries/REST_Controller.php');
/*class home extends REST_Controller  {*/
class Autoposting extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Publisher_model');
	}

	public function index()
	{
		$this->load->library('facebook');
		$posts = $this->Publisher_model->sceduler_posts();
		foreach ($posts as $post) {
			$this->Publisher_model->update_record('sceduler', array('status' => '2'), $post->id);
			if ($post->type == 'facebook') {
				$page = $this->Publisher_model->retrieve_record('facebook_pages', $post->page_id);
			} elseif ($post->type == 'pinterest') {
				$page = $this->Publisher_model->retrieve_record('pinterest_boards', $post->page_id);
			} else {
				$page = $this->Publisher_model->retrieve_record('facebook_pages', $post->page_id);
			}
			if (!$page) {
				$dello = $this->Publisher_model->delete_record('sceduler', $post->id);
				continue;
			}
			$user_check = user_check($post->user_id);
			if (!$user_check['status']) {
				$dello = $this->Publisher_model->delete_record('sceduler', $post->id);
				continue;
			}

			if ($post->type == 'facebook') {
				$bulkupload_limit_check = bulkupload_limit_check($page->user_id, $page->page_id);
				if (!$bulkupload_limit_check['status']) {
					continue;
				}
			}
			// check for loop
			$loop = $page->loop_auto_posting ? true : false;
			// check for randomize, if enabled select any other post
			$random_check = $page->random_auto_posting ? true : false;
			if ($random_check) {
				$random_post = $this->Publisher_model->random_post($page, $post);
				if (count($random_post) > 0) {
					$post = $random_post[0];
				}
			}
			$user = $this->Publisher_model->retrieve_record('user', $post->user_id);
			if ($user->active == "y" && $page->auto_posting == "on") {
				$post_type = $this->Publisher_model->retrieve_record('link', $post->post_id);
				$type = $post_type->c_type;
				$postData = [];
				if ($post->type == 'facebook' || empty($post->type)) {
					if ($type == 1) {
						$postData["link"] = $post_type->site_us_pc;
						$postData["message"] = $post->post_title;
						$posting = $this->facebook->request('POST', "/" . $page->page_id . "/feed", $postData, (string) $page->access_token);
					} else {
						$postData["url"] = $post_type->img;
						$short_link = get_create_shortlink($post->link);
						$updated_cp['text'] = str_replace($post_type->site_us_pc, $short_link, $post_type->text);
						$postData["caption"] = str_replace('\r\n', "\n", $updated_cp['text']);
						$posting = $this->facebook->request('POST', "/" . $page->page_id . "/photos", $postData, (string) $page->access_token);
					}
				} elseif ($post->type == 'pinterest') {
					$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $post->user_id));
					if ($type == 1) {
						$img = isImage($post_type->img) ? $post_type->img : fetchImage($post->link, 'pinterest');
						$data = [
							'title' => $post->post_title,
							'description' => $post->post_title,
							'link' => $post->link,
							'image' => $img,
							'board_id' => $page->board_id,
							'content_type' => 'image_url',
							'access_token' => $pinterest_user[0]->access_token,
						];
						$id = $this->Publisher_model->publish_pin_curl($data);
					} else {
						$img = $post_type->img;
						$data = [
							'title' => $post->post_title,
							'description' => $post->post_title,
							'link' => $post->link,
							'image' => $img,
							'board_id' => $page->board_id,
							'content_type' => 'image_path',
							'access_token' => $pinterest_user[0]->access_token,
						];
						$id = $this->Publisher_model->publish_pin_curl($data);
					}
				}
				$type = $post->type;
				$this->Publisher_model->delete_record('sceduler', $post->id);
				if ($loop) {
					$scheduled = $this->Publisher_model->renewAutoPostsList($page->id, $post->type);
				}
			} else {
				$this->Publisher_model->delete_record('sceduler', $post->id);
			}
		}
	}

	public function facebookbulkupload()
	{
		$this->load->library('facebook');
		$posts = $this->Publisher_model->bulksceduler_posts("bulkupload");
		foreach ($posts as $post) {
			$this->Publisher_model->update_record('bulkupload', array('status' => '2'), $post->id);
			$page = $this->Publisher_model->retrieve_record('facebook_pages', $post->page_id);
			if (!$page) {
				$dello = $this->Publisher_model->delete_record('bulkupload', $post->id);
				continue;
			}
			// check user
			$user_check = user_check($page->user_id);
			if (!$user_check['status']) {
				continue;
			}
			$bulkupload_limit_check = bulkupload_limit_check($page->user_id, $page->page_id);
			if (!$bulkupload_limit_check['status']) {
				continue;
			}
			$postData = [];
			$image_path = BulkAssets . $post->link;
			$postData["caption"] = !empty($post->post_title) ? $post->post_title : ""; 
			$postData["url"] = $image_path;
			$posting = $this->facebook->request('POST', "/" . $page->page_id . "/photos", $postData, (string) $page->access_token);
			$dello = $this->Publisher_model->delete_record('bulkupload', $post->id);
			remove_file($post->link);
		}
	}

	public function instagrambulkupload()
	{

		require './instagram/vendor/autoload.php';
		$posts = $this->Publisher_model->bulksceduler_posts("igbulkupload");

		foreach ($posts as $post) {

			$user = $this->Publisher_model->retrieve_record('user', $post->user_id);

			/////// CONFIG ///////
			$username = $user->ig_username;
			$password = $user->ig_pass;
			$debug = false;
			$truncatedDebug = false;

			\InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
			$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
			try {
				$ig->login($username, $password);
			} catch (\Exception $e) {

				echo 'Something went wrong: ' . $e->getMessage() . "\n";
				exit(0);
			}

			$postData = [];

			if ("::1" == $_SERVER['REMOTE_ADDR']) {
				$image_path = "http://localhost/adublisher/assets/bulkuploads/" . $post->link;
				$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $post->link;
			} else {
				$image_path = BulkAssets . $post->link;
				$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $post->link;
			}
			$postData["url"] = $image_path;
			$postData["url"] = $delete_path; //"https://www.adublisher.com/assets/general/images/background/network-background.jpg";
			$postData["caption"] = "Test Post from Adub"; // $post->post_title;
			try {

				// Also note that it has lots of options, so read its class documentation!
				$photo = new \InstagramAPI\Media\Photo\InstagramPhoto($postData["url"]);
				$ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $postData["caption"]]);
				$posting = false;
				if ($posting) {

					if ($this->Publisher_model->delete_record('bulkupload', $post->id)) {
						$unlink = unlink($delete_path);
					}

				}
			} catch (\Exception $e) {
				echo 'Something went wrong: ' . $e->getMessage() . "\n";
			}
		}
	}

	public function dailysceduler()
	{
		$users = $this->Publisher_model->selectactivefacebookusers();
		foreach ($users as $user) {
			$user_id = $user->id;
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				continue;
			}
			echo "<ul>" . $user->fname;
			$pkinfo = $this->Publisher_model->userPackageforCron($user);

			//User or its employeer's package is active
			if ($pkinfo->active == '1') {
				$facebook_pages = $this->Publisher_model->selectactivefacebookpages($user->id);
				foreach ($facebook_pages as $page) {
					echo "<ul>" . $page->page_name;
					if ($page->loop_auto_posting) {
						$scheduled = $this->Publisher_model->renewAutoPostsList($page->id, "facebook");
					}
					echo "</ul>";
				}
			}
			echo "</ul>";
		}
	}


	public function indexbackup()
	{

		$this->load->library('facebook');

		$where = [];
		$where[0]['key'] = 'active';
		$where[0]['value'] = '1';

		$users = $this->Publisher_model->list_records('user', 0, 10, $where, 'id', 'ASC');
		foreach ($users as $user) {
			if ($user->facebook_id != "" && $user->facebook_permanent_token != "" && $user->facebook_permanent_token_genarated_date != "") {
				$till_valid_date = date('Y-m-d', strtotime("+59 days", strtotime($user->facebook_permanent_token_genarated_date)));
				if (date('Y-m-d') < $till_valid_date) {
					//$this->facebook->user_setDefaultAccessToken($user->facebook_permanent_token);
					$postData = [];
					$pages = $this->Publisher_model->list_records('facebook_pages', 0, 100, array(
						'key' => 'auto_posting',
						'value' => 'on'
					), 'id', 'ASC');

					foreach ($pages as $page) {

						$user_domain = $this->Publisher_model->get_userdomain($user->username);
						$this_post_id = $page->last_post_id;
						$postId = $this->Publisher_model->getNextPost($this_post_id);

						$postData["link"] = $user_domain . "/ref/" . $postId . "/" . $user->id;
						$posting = $this->facebook->request('post', '/' . $page->page_id . '/feed', $postData, $page->access_token);

						if ($posting) {
							$page_data = [];
							$page_data['last_post_id'] = $postId;
							$page_data['last_post_datetime'] = gmdate("Y-m-d h:i:s");
							$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page->id);
						}
					}
				}
			}
		}
	}
}
