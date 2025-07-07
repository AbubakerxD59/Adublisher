<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require(APPPATH.'libraries/REST_Controller.php');
/*class home extends REST_Controller  {*/
class ChannelCrons extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Publisher_model');
		$this->load->library('facebook');
	}

	public function index()
	{
		echo "Hello";
	}

	// With exception handling
	public function facebookPublish()
	{
		$posts = $this->Publisher_model->getScheduledPostsFromChannels('channels_scheduler', 'facebook');
		foreach ($posts as $post) {
			$this->Publisher_model->update_record('channels_scheduler', ['status' => '2', 'response' => 'Processing'], $post->id);
			$user_id = $post->user_id;
			$page = $this->Publisher_model->get_allrecords('facebook_pages', ['user_id' => $user_id, 'id' => $post->channel_id]);
			if (count($page) == 0) {
				$this->Publisher_model->delete_record('channels_scheduler', $post->id);
				continue;
			}
			$page = $page[0];
			$error_postData = ['title' => $post->post_title, 'image' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? $post->link : BulkAssets . $post->link];
			// check feature limit
			if (!limit_check(POST_SCHEDULING_FB_ID, 2, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				notify_via_email($error_postData, $page, 'Facebook', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
			}

			// check bulkupload limit for 3 posts in 15 minutes
			// $bulkupload_limit_check = bulkupload_limit_check($user_id, $page->page_id);
			// if (!$bulkupload_limit_check['status']) {
			// 	print_pre('1');
			// 	continue;
			// }

			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				print_pre('2');
				$error_message = $user_check['message'];
				notify_via_email($error_postData, $page, 'Facebook', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
				continue;
			}

			$access_token = (string) $page->access_token;
			// check if post is quote only
			$quote = empty($post->link) && empty($post->site_us_pc) && empty($post->video_path) ? true : false;
			if ($quote) { //for quote publishing
				$result = $this->facebook->request('POST', "/" . $page->page_id . "/feed", ['message' => $post->post_title], $access_token);
			} else if (!empty($post->video_path)) { //for video publishing
				$file_url = get_from_s3bucket($post->video_path);
				if ($file_url['status']) {
					$file_name = $file_url['file_name'];
					$postData = [
						'description' => $post->post_title,
						'file_url' => BulkAssets . $file_name
					];
					$result = $this->facebook->request('POST', '/' . $page->page_id . '/videos', $postData, $access_token);
				} else {
					$response = array(
						'status' => false,
						'error' => 'Error processing Video'
					);
				}
			} else if (strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false) { //for link posting
				$postData["message"] = $post->post_title;
				$postData["link"] = $post->site_us_pc;
				$result = $this->facebook->request('POST', "/" . $page->page_id . "/feed", $postData, $access_token);
			} else { //for photo posting
				$image_path = BulkAssets . $post->link;
				$postData["url"] = $image_path;
				$postData['caption'] = $post->post_title;
				$result = $this->facebook->request('POST', "/" . $page->page_id . "/photos", $postData, $access_token);
			}
			// for comment posting
			if ($result['id']) {
				$response = array('status' => '1', 'response' => $result['id'], 'post_id' => $result['id']);
				$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);

				remove_file($post->link);
				remove_from_s3bucket($post->video_path);
				if (!empty($post->post_comment)) {
					$this->Publisher_model->publish_comments($result['id'], $post->post_comment, $access_token);
				}
			} else {
				resources_update('down', POST_SCHEDULING_FB_ID, $user_id);
				if (isset($result['error'])) {
					$error_message = $result['message'];
				} else {
					$error_message = 'Internal Error found, no other information available!';
				}
				$response = array('status' => '-1', 'response' => $error_message);
				$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);
				notify_via_email($error_postData, $page, 'Facebook', $error_message);
			}
		}
	}

	public function pinterestPublish()
	{
		$posts = $this->Publisher_model->getScheduledPostsFromChannels('channels_scheduler', 'pinterest');
		foreach ($posts as $post) {
			$user_id = $post->user_id;
			$this->Publisher_model->update_record('channels_scheduler', ['status' => '2', 'response' => 'Processing'], $post->id);
			$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', ['user_id' => $user_id]);
			$board = $this->Publisher_model->get_allrecords('pinterest_boards', ['user_id' => $user_id, 'id' => $post->channel_id]);
			if (count($pinterest_user) > 0 && count($board) > 0) {
				$pinterest_user = $pinterest_user[0];
				$board = $board[0];
			} else {
				$this->Publisher_model->delete_record('channels_scheduler', $post->id);
				continue;
			}
			$error_postData = ['title' => $post->post_title, 'image' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? $post->link : BulkAssets . $post->link];
			// check feature limit
			if (!limit_check(POST_SCHEDULING_PIN_ID, 2, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				notify_via_email($error_postData, $board, 'Pinterest', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
				continue;
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				notify_via_email($error_postData, $board, 'Pinterest', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
				continue;
			}
			$post->post_title = strlen($post->post_title) > 101 ? substr($post->post_title, 0, 100) : $post->post_title;
			$post->post_title = !empty($post->post_title) ? $post->post_title : " ";
			if (!empty($post->video_path)) { //for video publishing
				$data = [
					'title' => $post->post_title,
					'description' => $post->post_title,
					'video_path' => $post->video_path,
					'board_id' => $board->board_id,
					'access_token' => $pinterest_user->access_token
				];
				$result = $this->Publisher_model->publish_video_pin_curl($data);
			} else {
				if (strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false) {
					$image_path = $post->link;
				} else {
					$image_path = BulkAssets . $post->link;
				}
				$post->post_title = !empty($post->post_title) ? $post->post_title : "";
				$request_url = !empty($post->site_us_pc) ? $post->site_us_pc : "";
				$data = [
					'title' => $post->post_title,
					'description' => $post->post_title,
					'board_id' => $board->board_id,
					'link' => $request_url,
					'image' => $image_path,
					'content_type' => 'image_path',
					'access_token' => $pinterest_user->access_token,
				];
				$result = $this->Publisher_model->publish_pin_curl($data);
			}
			$result = json_decode($result, true);
			if (isset($result['id'])) {
				$response = array('status' => '1', 'response' => "Your post has been Published Successfully!", 'post_id' => $result['id']);
				$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);

				remove_file($post->link);
				remove_from_s3bucket($post->video_path);
			} else {
				resources_update('down', POST_SCHEDULING_PIN_ID, $user_id);
				if (isset($result['code'])) {
					$error_message = $result['message'];
				} else {
					$error_message = 'Internal Error found, no other information available!';
				}
				$response = array('status' => '-1', 'response' => $error_message);
				$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);
				notify_via_email($error_postData, $board, 'Pinterest', $error_message);
			}
		}
	}

	public function igPublish()
	{
		$posts = $this->Publisher_model->getScheduledPostsFromChannels('channels_scheduler', 'instagram');
		foreach ($posts as $post) {
			$this->Publisher_model->update_record('channels_scheduler', ['status' => '2', 'response' => 'Processing'], $post->id);
			$user_id = $post->user_id;
			$ig_user = $this->Publisher_model->get_allrecords('instagram_users', ['user_id' => $user_id, 'id' => $post->channel_id]);

			$error_postData = ['title' => $post->post_title, 'image' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? $post->link : BulkAssets . $post->link];
			// check feature limit
			if (!limit_check(POST_SCHEDULING_INST_ID, 2, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
				continue;
			}
			$image_path = strpos($post->link, 'http') !== false ? $post->link : BulkAssets . $post->link;
			$post->post_title = !empty($post->post_title) ? $post->post_title : " ";

			$container = $this->Publisher_model->create_ig_media_container($ig_user[0]->instagram_id, $ig_user[0]->access_token, $image_path, $post->post_title);
			if (isset($container['id'])) {
				$result = $this->Publisher_model->publish_ig_media_container($post->user_id, $container['id']);
				if (isset($result['id'])) {
					$response = array('status' => '1', 'response' => $result['id'], 'post_id' => $result['id']);
					$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);

					remove_file($post->link);
					remove_from_s3bucket($post->video_path);
				} else {
					resources_update('down', POST_SCHEDULING_INST_ID, $user_id);
					$error_message = 'Error while publishing IG media container!';
					$response = array('status' => '-1', 'response' => $error_message);
					$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);
					notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				}
			} else {
				resources_update('down', POST_SCHEDULING_INST_ID, $user_id);
				$error_message = $container['error']['message'];
				$response = array('status' => '-1', 'response' => $error_message);
				$this->Publisher_model->update_record('channels_scheduler', $response, $post->id);
				notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
			}
		}
	}

	public function tiktokPublish()
	{
		$posts = $this->Publisher_model->getScheduledPostsFromChannels('channels_scheduler', 'tiktok');
		foreach ($posts as $post) {
			$this->Publisher_model->update_record('channels_scheduler', ['status' => '2', 'response' => 'Processing'], $post->id);
			$user_id = $post->user_id;
			$tiktok_user = $this->Publisher_model->get_allrecords('tiktok', ['user_id' => $user_id, 'id' => $post->channel_id]);
			if (count($tiktok_user) == 0) {
				$this->Publisher_model->delete_record('channels_scheduler', $post->id);
				continue;
			} else {
				$tiktok_user = $tiktok_user[0];
			}

			$error_postData = ['title' => $post->post_title, 'image' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? $post->link : BulkAssets . $post->link];
			// check feature limit
			if (!limit_check(POST_SCHEDULING_INST_ID, 2, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				notify_via_email($error_postData, tiktok_user, 'TikTok', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				notify_via_email($error_postData, tiktok_user, 'TikTok', $error_message);
				$this->Publisher_model->update_record('channels_scheduler', ['status' => '-1', 'response' => $error_message], $post->id);
				continue;
			}
			$type = !empty($post->video_path) ? 'video' : 'image';

			$this->load->library('tiktok');
			$access_token = refresh_tiktok_access_token($tiktok_user->access_token);
			if ($type == 'image') {
				$postData = array('title' => $post->post_title, 'url' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? BulkAssets . $post->link : BulkAssets . $post->link);
				$response = $this->tiktok->publish_photo($postData, $access_token);
			} else if ($type == 'video') {
				$video = get_from_s3bucket($post->video_path);
				$postData = array('title' => $post->post_title, 'url' => BulkAssets . $video['file_name']);
				$response = $this->tiktok->publish_video($postData, $access_token);
			}
			if (isset($response['publish_id'])) {
				do {
					sleep(0.5);
					$publish = $this->tiktok->fetch_status($access_token, $response['publish_id']);
				} while (!in_array($publish['status'], ['PUBLISH_COMPLETE', 'FAILED']));
				if (isset($publish['status']) && $publish['status'] == 'PUBLISH_COMPLETE') {
					remove_file($post->link);
					remove_from_s3bucket($post->video_path);
					$this->Publisher_model->update_record('channels_scheduler', array('status' => '1', 'response' => $response['publish_id'], 'post_id' => $response['publish_id']), $post->id);
				} else {
					$error_message = isset($publish['fail_reason']) ? $publish['fail_reason'] : 'Something went wrong!';
					$this->Publisher_model->update_record('channels_scheduler', array('status' => '-1', 'response' => $error_message), $post->id);
					notify_via_email($error_postData, $tiktok_user, 'TikTok', $error_message);
				}
			} else {
				$error_message = isset($response['error_description']) ? $response['error_description'] : 'Something went wrong!';
				$this->Publisher_model->update_record('channels_scheduler', array('status' => '-1', 'response' => $error_message), $post->id);
				notify_via_email($error_postData, $tiktok_user, 'TikTok', $response['error_description']);
			}
		}
	}

	public function rssFbPublish()
	{
		$this->load->library('facebook');
		$posts = $this->Publisher_model->rsssceduler_posts("rsssceduler");

		foreach ($posts as $post) {
			$this->Publisher_model->update_record('rsssceduler', ['posted' => '2', 'error' => 'Processing'], $post->id);

			$user_id = $post->user_id;
			$page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'id' => $post->page_id));
			// check for any unknown/bugged timeslots
			if ($post->post_datetime == "0000-00-00 00:00:00") {
				$this->Publisher_model->delete_record('rsssceduler', $post->id);
				continue;
			}
			// check if page exists or not
			if (count($page) == 0) {
				$this->Publisher_model->delete_record('rsssceduler', $post->id);
				continue;
			} else {
				$page = $page[0];
			}
			$error_postData = ['title' => $post->post_title, 'image' => $post->link];
			// feature limit check
			if (!limit_check(RSS_FEED_POST_PUBLISH_ID, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				$this->Publisher_model->update_record('rsssceduler', ['posted' => '-1', 'error' => $error_message], $post->id);
				notify_via_email($error_postData, $page, 'Facebook', $error_message);
				continue;
			}
			// check for bulkupload check for 3 posts in 15 minutes
			$bulkupload_limit_check = bulkupload_limit_check($user_id, $page->page_id);
			if (!$bulkupload_limit_check['status']) {
				continue;
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				$this->Publisher_model->update_record('rsssceduler', ['posted' => '-1', 'error' => $error_message], $post->id);
				notify_via_email($error_postData, $page, 'Facebook', $error_message);
				continue;
			}

			$access_token = (string) $page->access_token;
			if ($page->shopify_active && strpos($post->link, 'cdn.shopify.com') !== false) { //for shopify links
				$message = $post->post_title . "\nBuy Here: " . $post->url;
				$imageURL = $post->link;
				$postData = [
					'message' => $message,
					'url' => $imageURL,
				];
				$result = $this->facebook->request('POST', '/' . $page->page_id . '/photos', $postData, $access_token);
			} elseif ($page->rss_active && strpos($post->link, 'cdn.shopify.com') === false) { //for links
				$postData = [
					'message' => $post->post_title,
					'link' => $post->url
				];
				$result = $this->facebook->request('POST', "/" . $page->page_id . "/feed", $postData, (string) $page->access_token);
			} else {
				//Now reschedule this post and keep continue
				$post_date_time = $this->Publisher_model->getNextPostTime('rsssceduler', $page->user_id, $post->page_id, $page->time_slots_rss);
				// Now update its posting time
				$this->Publisher_model->update_record('rsssceduler', ['post_datetime' => $post_date_time], $post->id);
				continue;
			}
			if (isset($result['id'])) {
				resources_update('up', RSS_FEED_POST_PUBLISH_ID, $user_id);
				$this->Publisher_model->update_record('rsssceduler', ['posted' => '1', 'error' => $result['id'], 'post_id' => $result['id']], $post->id);
				remove_file($post->url);
			} else {
				if (isset($result['error'])) {
					$error_message = $result['error'];
				} else {
					$error_message = 'Something went wrong while Publishing.';
				}
				$this->Publisher_model->update_record('rsssceduler', ['posted' => '-1', 'error' => $error_message], $post->id);
			}
		}
	}

	public function rssPinterestPublish()
	{
		$posts = $this->Publisher_model->rsssceduler_posts("pinterest_scheduler");
		foreach ($posts as $key => $post) {
			$this->Publisher_model->update_record('pinterest_scheduler', array('published' => 2, 'error' => 'Processing'), $post->id);
			if ($post->publish_datetime == "0000-00-00 00:00:00") {
				$this->Publisher_model->delete_record('pinterest_scheduler', $post->id);
				continue;
			}
			// do not publish previous day posts		
			$user_id = $post->user_id;
			$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $user_id));
			$board = $this->Publisher_model->retrieve_record('pinterest_boards', $post->board_id);
			if (count($pinterest_user) == 0 || empty($board)) {
				$this->Publisher_model->delete_record('pinterest_scheduler', $post->id);
				continue;
			}
			$error_postData = ['title' => $post->post_title, 'image' => $post->image_link];
			// feature limit check
			if (!limit_check(RSS_FEED_POST_PUBLISH_ID, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				$this->Publisher_model->update_record('pinterest_scheduler', ['published' => '-1', 'error' => $error_message], $post->id);
				notify_via_email($error_postData, $board, 'Pinterest', $error_message);
				continue;
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				$this->Publisher_model->update_record('pinterest_scheduler', ['published' => '-1', 'error' => $error_message], $post->id);
				notify_via_email($error_postData, $board, 'Pinterest', $error_message);
				continue;
			}
			$request_url = $post->url;
			$title = strlen($post->post_title) > 100 ? substr($post->post_title, 0, 95) : $post->post_title;
			// End //
			if ($board->rss_active && strpos($post->image_link, 'cdn.shopify.com') === false) { //for shopify
				$image_link = isImage($post->image_link) ? $post->image_link : fetchImage($request_url, 'pinterest');
				$data = [
					'title' => $title,
					'description' => $title,
					'link' => $request_url,
					'board_id' => $board->board_id,
					'image' => $image_link,
					'content_type' => 'image_url',
					'access_token' => $pinterest_user[0]->access_token
				];
				$result = $this->Publisher_model->publish_pin_curl($data);
				$result = json_decode($result, true);
			} elseif ($board->shopify_active && strpos($post->image_link, 'cdn.shopify.com') !== false) { //for link
				$request_url = $post->url;
				$image_link = isImage($post->image_link) ? $post->image_link : fetchImage($request_url, 'pinterest');
				$data = [
					'title' => $title,
					'description' => $title,
					'link' => $request_url,
					'board_id' => $board->board_id,
					'image' => $image_link,
					'content_type' => 'image_url',
					'access_token' => $pinterest_user[0]->access_token
				];
				$result = $this->Publisher_model->publish_pin_curl($data);
				$result = json_decode($result, true);
			} else {
				// Now reschedule this post and keep continue
				$post_data['publish_datetime'] = $this->Publisher_model->getNextPostTime('pinterest_scheduler', $user_id, $post->board_id, $board->time_slots_rss);
				$this->Publisher_model->update_record('pinterest_scheduler', $post_data, $post->id);
				continue;
			}
			if (isset($result['id'])) {
				$response = array('published' => '1', 'error' => $result['id'], 'post_id' => $result['id']);
				$this->Publisher_model->update_record('pinterest_scheduler', $response, $post->id);
				remove_file($post->image_link);
			} else {
				resources_update('down', RSS_FEED_POST_PUBLISH_ID, $user_id);
				if (isset($result['code'])) {
					$error_message = $result['message'];
				} else {
					$error_message = 'Internal Error found, no other information available!';
				}
				$response = array('published' => '-1', 'error' => $error_message);
				$this->Publisher_model->update_record('pinterest_scheduler', $response, $post->id);
				notify_via_email($error_postData, $board, 'Pinterest', $error_message);
			}
		}
	}

	public function rssTikTokPublish()
	{
		$unpublished_posts = $this->Publisher_model->rsssceduler_posts("tiktok_scheduler");
		print_pre($unpublished_posts);
		foreach ($unpublished_posts as $post) {
			$this->Publisher_model->update_record('tiktok_scheduler', array('published' => 2, 'response' => 'Processing!'), $post->id);
			$user_id = $post->user_id;
			if ($post->post_datetime == "0000-00-00 00:00:00") {
				$this->Publisher_model->delete_record('tiktok_scheduler', $post->id);
				continue;
			}
			$tiktok = $this->Publisher_model->retrieve_record('tiktok', $post->tiktok_id);
			if (empty($tiktok)) {
				$this->Publisher_model->delete_record('tiktok_scheduler', $post->id);
				continue;
			}
			$desitnationPath = rand();
			$error_postData = ['title' => $post->post_title, 'image' => $post->url];
			// feature limit check
			if (!limit_check(RSS_FEED_POST_PUBLISH_ID, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				notify_via_email($error_postData, $tiktok, 'TikTok', $error_message);
				$this->Publisher_model->update_record('tiktok_scheduler', ['published' => '-1', 'response' => $error_message], $post->id);
				continue;
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				notify_via_email($error_postData, $tiktok, 'TikTok', $error_message);
				$this->Publisher_model->update_record('tiktok_scheduler', ['published' => '-1', 'response' => $error_message], $post->id);
				continue;
			}
			$access_token = refresh_tiktok_access_token($tiktok->access_token);
			$postData = array(
				'title' => $post->post_title,
				'url' => BulkAssets . tiktok_image_url($post->link, $tiktok),
			);
			$this->load->library('tiktok');
			$response = $this->tiktok->publish_photo($postData, $access_token);
			if (isset($response['publish_id'])) {
				do {
					sleep(0.5);
					$publish = $this->tiktok->fetch_status($access_token, $response['publish_id']);
				} while (!in_array($publish['status'], ['PUBLISH_COMPLETE', 'FAILED']));
				if (isset($publish['status']) && $publish['status'] == 'PUBLISH_COMPLETE') {
					$this->Publisher_model->update_record('tiktok_scheduler', array('published' => '1', 'response' => $response['publish_id']), $post->id);
				} else {
					$this->Publisher_model->update_record('tiktok_scheduler', array('published' => '-1', 'response' => $publish['fail_reason']), $post->id);
					notify_via_email($error_postData, $tiktok, 'TikTok', $publish['fail_reason']);
				}
			} else {
				$this->Publisher_model->update_record('tiktok_scheduler', array('published' => '-1', 'response' => $response['error_description']), $post->id);
				notify_via_email($error_postData, $tiktok, 'TikTok', $response['error_description']);
			}
			exit;
		}
	}

	public function rssIgPublish()
	{
		$posts = $this->Publisher_model->rsssceduler_posts("instagram_scheduler");
		foreach ($posts as $post) {
			$this->Publisher_model->update_record('instagram_scheduler', ['published' => 2, 'error' => 'Processing'], $post->id);
			if ($post->publish_datetime == "0000-00-00 00:00:00") {
				$this->Publisher_model->delete_record('instagram_scheduler', $post->id);
				continue;
			}
			$user_id = $post->user_id;
			$ig_user = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $user_id, 'id' => $post->ig_id));
			if (count($ig_user) == 0) {
				$this->Publisher_model->delete_record('instagram_scheduler', $post->id);
				continue;
			} else {
				$ig_user = $ig_user[0];
			}
			$error_postData = ['title' => $post->post_title, 'image' => $post->image_link];
			// feature limit check
			if (!limit_check(RSS_FEED_POST_PUBLISH_ID, $user_id)) {
				$error_message = 'Your resource limit has been reached';
				notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				$this->Publisher_model->update_record('instagram_scheduler', ['published' => '-1', 'error' => $error_message], $post->id);
				continue;
			}
			// check user membership and user existence
			$user_check = user_check($user_id);
			if (!$user_check['status']) {
				$error_message = $user_check['message'];
				notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				$this->Publisher_model->update_record('instagram_scheduler', ['published' => '-1', 'error' => $error_message], $post->id);
				continue;
			}

			if ($ig_user->rss_active && strpos($post->image_link, 'cdn.shopify.com') === false) { //for shopify
				$image = strpos($post->image_link, 'http') !== false || strpos($post->image_link, 'https') !== false ? $post->image_link : BulkAssets . $post->image_link;
				$title = !empty($post->post_title) ? $post->post_title : " ";

				$container = $this->Publisher_model->create_ig_media_container($ig_user->instagram_id, $ig_user->access_token, $image, $title);
				if (isset($container['id'])) {
					$result = $this->Publisher_model->publish_ig_media_container($post->user_id, $container['id']);
					if (isset($result['id'])) {
						$response = array('published' => '1', 'error' => $result['id'], 'post_id' => $result['id']);
						$this->Publisher_model->update_record('instagram_scheduler', $response, $post->id);
						remove_file($post->link);
						resources_update('up', RSS_FEED_POST_PUBLISH_ID, $user_id);
					} else {
						$error_message = 'Error while publishing IG media container!';
						$response = array('published' => '-1', 'error' => $error_message);
						$this->Publisher_model->update_record('instagram_scheduler', $response, $post->id);
						notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
					}
				} else {
					$error_message = $container['error']['message'];
					$response = array('published' => '-1', 'error' => $error_message);
					$this->Publisher_model->update_record('instagram_scheduler', $response, $post->id);
					notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				}
			} elseif ($ig_user->shopify_active && strpos($post->image_link, 'cdn.shopify.com') !== false) { //for shopify
				$image = strpos($post->image_link, 'http') !== false || strpos($post->image_link, 'https') !== false ? $post->image_link : BulkAssets . $post->image_link;
				$title = !empty($post->post_title) ? $post->post_title : " ";
				$caption = $post->post_title . "\nBuy Here: " . $post->url;

				$container = $this->Publisher_model->create_ig_media_container($ig_user->instagram_id, $ig_user->access_token, $image, $caption);
				if (isset($container['id'])) {
					$result = $this->Publisher_model->publish_ig_media_container($post->user_id, $container['id']);
					if (isset($result['id'])) {
						$response = array('published' => '1', 'error' => $result['id'], 'post_id' => $result['id']);
						$this->Publisher_model->update_record('instagram_scheduler', $response, $post->id);
						remove_file($post->link);
						resources_update('up', RSS_FEED_POST_PUBLISH_ID, $user_id);
					} else {
						$error_message = 'Error while publishing IG media container!';
						$response = array('published' => '-1', 'error' => $error_message);
						$this->Publisher_model->update_record('instagram_scheduler', $response, $post->id);
						notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
					}
				} else {
					$error_message = container['error']['message'];
					$response = array('published' => '-1', 'error' => $error_message);
					$this->Publisher_model->update_record('instagram_scheduler', $response, $post->id);
					notify_via_email($error_postData, $ig_user, 'Instagram', $error_message);
				}
			} else {
				//Now reschedule this post and keep continue
				$post_data['publish_datetime'] = $this->Publisher_model->getNextPostTime('instagram_scheduler', $post->user_id, $post->ig_id, $ig_user[0]->time_slots_rss);
				$this->Publisher_model->update_record('instagram_scheduler', $post_data, $post->id);
				continue;
			}
		}
	}

	public function shopify_auto_products_for_pinterest_boards()
	{
		$pinterest_users = $this->Publisher_model->select_active_pinterest_users();
		foreach ($pinterest_users as $pinterest_user) {
			$user_id = $pinterest_user->user_id;
			$user = $this->Publisher_model->retrieve_record('user', $pinterest_user->user_id);
			$pkinfo = $this->Publisher_model->userPackageforCron($user);
			if ($pkinfo->active == '1') {
				$boards = $this->Publisher_model->get_all_boards($user->id);
				foreach ($boards as $board) {
					if (!$board->shopify_active) {
						continue;
					}
					$shopifyStore = $user->shopify_storeName;
					$apiVersion = '2024-01';
					$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
					$accessToken = $user->shopify_adminApiAccessToken;
					$headers = [
						'X-Shopify-Access-Token: ' . $accessToken,
					];
					// Initialize cURL session
					$ch = curl_init($endpoint);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$response = curl_exec($ch);
					$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);

					if ($httpCode === 200) {
						$result = json_decode($response, true);
						$src = array(); // Initialize $src as an empty array before the loop
						foreach ($result['products'] as $product) {
							// Title of Product as Caption of Post
							$title = $product['title'];
							// Getting Short Url Process Start
							$productHandle = $product['handle'];
							$productUrl = "https://{$shopifyStore}/products/{$productHandle}";
							$shortenUrlEndpoint = 'https://adub.link/short_my_link';
							// Build the request data
							$data = [
								'url' => $productUrl,
							];
							// Create HTTP context with POST data
							$options = [
								'http' => [
									'header' => 'Content-type: application/x-www-form-urlencoded',
									'method' => 'POST',
									'content' => http_build_query($data),
								],
							];
							$context = stream_context_create($options);
							// Send the request and get the response
							$shortProductUrlResponse = file_get_contents($shortenUrlEndpoint, false, $context);
							if ($shortProductUrlResponse !== FALSE) {
								$shortArray = json_decode($shortProductUrlResponse, true);
								if ($shortArray !== null) {
									$FinalUrl = $shortArray['link'];
								}
							} else {
								$FinalUrl = $productUrl;
							}

							// Checking for Product Duplication
							$this->db->select('url')->from('pinterest_scheduler')->where('user_id', $user->id)->where('board_id', $board->id)->where('url', $FinalUrl);
							$isDuplicateProduct = $this->db->get()->result();
							if (!empty($isDuplicateProduct)) {
								continue;
							}
							// Product Image
							$src = $product['image']['src'];
							if (empty($src)) {
								// $src = base_url('assets/general/images/no_image_found.jpg');
								continue;
							}
							$this->Publisher_model->create_single_pinterest_rss_feed($user->id, $board->id, $title, $src, $FinalUrl, $board->time_slots_rss);
						}
					}
				} // foreach
			} // pkg info
		}
	}

	// With Exception Handling
	public function refresh_pinterest_accesstoken_cronjob()
	{
		try {
			$pinterest_users = $this->Publisher_model->get_allrecords('pinterest_users', ['access_token !=' => '']);
			foreach ($pinterest_users as $pinterest_user) {
				$user_id = $pinterest_user->user_id;
				$now = time();
				$expires_in = $pinterest_user->expires_in;
				if ($now >= $expires_in) {
					$refreshed_access_token = $this->Publisher_model->refresh_pinterest_access_token($pinterest_user->refresh_token);
					if (isset($refreshed_access_token['access_token'])) {
						$data = [];
						$data['access_token'] = $refreshed_access_token['access_token'];
						$data['expires_in'] = $refreshed_access_token['expires_in'];
						$data['updated_at'] = date('Y-m-d H:i:s');
						$updated = $this->Publisher_model->update_record('pinterest_users', $data, $pinterest_user->id);

						if ($updated) {
							echo "Access token refreshed and updated successfully";
							$removeError = removeCronJobError($user_id, $error_column_name); // helper function
						} else {
							echo "Something went wrong Access token not updated";
						}
					} else {
						$error_msg = $refreshed_access_token['message'] . ' Please ReAutorize your Pinterest Account';
						$json_error_msg = updateCronJobError($user_id, $error_column_name, 'refreshe_pinterest_access_token', $function_name, $error_msg); // helper function
						echo $json_error_msg;
					}
				} else {
					echo "Access token already updated";
				}
				echo "<br>";
			}
		} catch (Exception $e) {
			// Handle the exception
			$error_msg = $e . $refreshed_access_token['message'] . ' Something went wrong, Please try again';
			$json_error_msg = updateCronJobError($user_id, $error_column_name, 'refreshe_pinterest_access_token', $function_name, $error_msg); // helper function
			echo $json_error_msg;
		}
	}
	// With Exception Handling
	public function rss_ig_cronjob()
	{
		exit;
		echo "<pre>";
		$ig_users = $this->Publisher_model->get_rss_active_ig_uesrs();

		foreach ($ig_users as $key => $ig_user) {
			try {
				$this->Publisher_model->update_last_run($ig_user->id, 'last_run', 'instagram_users');
				$user = $this->Publisher_model->retrieve_record('user', $ig_user->user_id);
				echo "<ul>" . $user->fname;

				$pkinfo = $this->Publisher_model->userPackageforCron($user);

				$user_id = $user->id;
				$error_column_name = 'instagram_error';
				$function_name = 'rss_ig_cronjob';
				$channel_name = $ig_user->instagram_username;

				// check user membership and user existence
				$user_check = user_check($user_id);
				if (!$user_check['status']) {
					$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $user_check['message']); // helper function
					continue;
				}
				if ($pkinfo->active == '1') {
					if (!$ig_user->rss_active) {

						continue;
					}
					if (empty($ig_user->rss_link)) {
						echo "</ul>";
						continue;
					}

					echo "<ul> <b>" . $ig_user->instagram_username . "<b><hr>";

					$arrContextOptions = array(
						"ssl" => array(
							"verify_peer" => false,
							"verify_peer_name" => false,
						),
					);

					if (strpos($ig_user->rss_link, '.atom') !== false) {
						echo "</ul>";
						continue;
					}
					if (strpos($ig_user->rss_link, '.xml') === false) {
						// continue;
					}

					$rss_linke = json_decode($ig_user->rss_link);
					if (empty($rss_linke)) { // This means the rss link was never encoded before so you cant decode for the first time
						$rss_linke[] = $ig_user->rss_link;
					}
					$feed = [];
					foreach ($rss_linke as $links) {
						$single_feed = file_get_contents($links, false, stream_context_create($arrContextOptions));
						if (!$single_feed) {
							echo '<h2>Feed of ' . $links . ' is false</h2>';
							$false_link = $links;
							$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, 'Failed to fetch the RSS feed from' . $false_link); // helper function
						} else {
							$feed[] = $single_feed;
							echo '<h2>Feed of ' . $links . ' is true</h2>';
						}
					}

					if ($feed) {
						foreach ($feed as $data) {
							$rss = simplexml_load_string($data);
							if ($rss) {
								if (isset($rss->channel->item)) {
									foreach ($rss->channel->item as $item) {
										$title = (string) $item->title;
										$link = (string) $item->link;

										$where_rss = [];
										$where_rss[0]['key'] = 'user_id';
										$where_rss[0]['value'] = $ig_user->user_id;
										$where_rss[1]['key'] = 'ig_id';
										$where_rss[1]['value'] = $ig_user->id;
										$where_rss[2]['key'] = 'url';
										$where_rss[2]['value'] = $link;
										$present = $this->Publisher_model->count_records('instagram_scheduler', $where_rss);

										if (!$present) {

											$content = $item->children('content', 'http://purl.org/rss/1.0/modules/content/');
											// $html_string = $content->encoded;
											$dom = new DOMDocument();
											libxml_use_internal_errors(true);
											// $dom->loadHTML($html_string);
											$dom->loadHTML($content);
											libxml_clear_errors();
											$images = $dom->getElementsByTagName('img');
											$best_image = null;

											foreach ($images as $image) {
												echo $src = $image->getAttribute('src');
												echo '<br>';
												list($width, $height) = getimagesize($src);
												$aspect_ratio = $width / $height;
												$aspect_ratio = round($aspect_ratio, 2);

												if ($aspect_ratio <= 1.91 && $aspect_ratio >= 4 / 5) {
													$best_image = $src;
													break;
												}
											}

											if (!empty($link)) {
												// utm checks on url
												$utm_details = [];
												$utm_check = false;
												$url_detail = getDomain($link);
												if (!empty($url_detail['url'])) {
													$domain = $url_detail['url'];
													$utm_details = getUtm($domain, $user_id);
													if (count($utm_details) > 0) {
														$utm_check = true;
													}
												}
												$page_detail = $this->Publisher_model->retrieve_record('instagram_users', $ig_user->id);
												if ($utm_check) {
													$link = make_utm_url($link, $utm_details, $page_detail->page_name, 'instagram');
												}
											}

											if ($link && $title && $best_image) {

												echo "<ul>" . $ig_user->time_slots_rss . "</ul>";
												echo $created = $this->Publisher_model->create_single_ig_rss_feed($ig_user->user_id, $ig_user->id, $title, $best_image, $link, $ig_user->time_slots_rss);
												echo "<li>" . $title . "</li>";
												if ($created) {
													$removeError = removeCronJobError($user_id, $error_column_name); // helper function
												}
											}
										}
									}
								}
							}
						} // foreach
					} // if feed
					unset($feed);
					echo "</ul>";
				}
				echo "</ul>";
			} catch (Exception $ex) {
				// Handle the exception
				$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $ex . ' Something went wrong, Please try again.');
			}
		}
	}

	public function shopify_auto_products_for_instagram()
	{
		$ig_users = $this->Publisher_model->get_all_active_ig_uesrs();
		foreach ($ig_users as $key => $ig_user) {
			try {
				$user = $this->Publisher_model->retrieve_record('user', $ig_user->user_id);
				$pkinfo = $this->Publisher_model->userPackageforCron($user);
				if ($pkinfo->active == '1') {
					if (!$ig_user->shopify_active) {
						continue;
					}
					$shopifyStore = $user->shopify_storeName;
					$apiVersion = '2024-01';
					$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
					$accessToken = $user->shopify_adminApiAccessToken;
					$headers = [
						'X-Shopify-Access-Token: ' . $accessToken,
					];
					// Initialize cURL session
					$ch = curl_init($endpoint);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$response = curl_exec($ch);
					$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);

					if ($httpCode === 200) {
						$result = json_decode($response, true);
						$src = array(); // Initialize $src as an empty array before the loop
						foreach ($result['products'] as $product) {
							// Title of Product as Caption of Post
							$title = $product['title'];
							// Getting Short Url Process Start
							$productHandle = $product['handle'];
							$productUrl = "https://{$shopifyStore}/products/{$productHandle}";
							$shortenUrlEndpoint = 'https://adub.link/short_my_link';
							// Build the request data
							$data = [
								'url' => $productUrl,
							];
							// Create HTTP context with POST data
							$options = [
								'http' => [
									'header' => 'Content-type: application/x-www-form-urlencoded',
									'method' => 'POST',
									'content' => http_build_query($data),
								],
							];
							$context = stream_context_create($options);
							// Send the request and get the response
							$shortProductUrlResponse = file_get_contents($shortenUrlEndpoint, false, $context);
							if ($shortProductUrlResponse !== FALSE) {
								$shortArray = json_decode($shortProductUrlResponse, true);
								if ($shortArray !== null) {
									$FinalUrl = $shortArray['link'];
								}
							} else {
								$FinalUrl = $productUrl;
							}

							// Checking for Product Duplication
							$this->db->select('url')->from('instagram_scheduler')->where('user_id', $user->id)->where('ig_id', $ig_user->id)->where('url', $FinalUrl);
							$isDuplicateProduct = $this->db->get()->result();
							if (!empty($isDuplicateProduct)) {
								continue;
							}
							// Product Image
							$src = $product['image']['src'];
							if (empty($src)) {
								// $src = base_url('assets/general/images/no_image_found.jpg');
								continue;
							}
							$this->Publisher_model->create_single_ig_rss_feed($ig_user->user_id, $ig_user->id, $title, $src, $FinalUrl, $ig_user->time_slots_rss);
						}
					}
				} // pkg info

			} catch (Exception $ex) {
			}
		}
	}

	public function publishYoutubeCronJob()
	{
		// get scheduled videos
		$get_youtube_scheduled_videos = $this->Publisher_model->getYoutubeScheduledVideos();
		if (count($get_youtube_scheduled_videos) > 0) {
			// lopp the videos
			foreach ($get_youtube_scheduled_videos as $key => $video) {
				// get user id
				$user_id = $video->user_id;
				// check feature limit
				// check feature limit
				if (!limit_check(POST_SCHEDULING_YT_ID, 2, $user_id)) {
					updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, 'Your resource limit has been reached'); // helper function
					continue;
				}
				// check user membership and user existence
				$user_check = user_check($user_id);
				if (!$user_check['status']) {
					$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $user_check['message']); // helper function
					continue;
				}
				// get channel id
				$channel_id = $video->channel_id;
				// get channel info by channel id
				$channel = $this->Publisher_model->retrieve_record('youtube_channels', $channel_id);
				$channel_name = $channel->channel_title;
				// column name in user table
				$error_column_name = 'youtube_channel_error';
				// function name for error table
				$function_name = 'publishYoutubeCronJob';
				// get user info by user id
				$user = $this->Publisher_model->retrieve_record('user', $user_id);
				// data array for publishing video
				$data = [];
				$data['video_title'] = $video->video_title;
				$data['video_description'] = $video->video_description;
				$data['video_category'] = $video->video_category;
				$data['privacyStatus'] = $video->privacy_status;
				$data['kids'] = $video->kids;
				$s3_key = $video->video_link;
				$data['thumbnail'] = $video->thumbnail_link;
				$data['tags'] = $video->tags;
				// get video saved to S3 Bucket and save it to local storage
				$file = get_from_s3bucket($s3_key);
				if ($file['status']) {
					$file_name = $file['file_name'];
				} else {
					$response = 'Error processing Video!';
					$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $response); // helper function
					continue;
				}
				// store thumbnail link to a variable
				$thumbnail_name = $video->thumbnail_link;
				// get access_token
				$google_id = $channel->google_id;
				$access_token = fetch_channel_access_token($google_id);
				// publish video to youtube
				$result = $this->Publisher_model->publish_to_youtube($data, $file_name, $thumbnail_name, $access_token);
				$response = '';
				$status = 0;
				if ($result['status']) {
					$status = 1;
					$response = 'Video published!';
					// delete path for removing video after upload
					remove_file($file_name);
					// delete thumbanail
					remove_file($thumbnail_name);
					// remove file from s3 bucket
					remove_from_s3bucket($s3_key);
				} else {
					$status = -1;
					$response = $result['error'];
				}
				$dataUpdate = array(
					'published' => $status,
					'error' => $response
				);
				$this->Publisher_model->update_record('youtube_scheduler', $dataUpdate, $video->id);
				if ($status == 1) {
					removeCronJobError($user_id, $error_column_name);
				} else {
					resources_update('down', POST_SCHEDULING_YT_ID, $user_id);
					$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $response); // helper function
					$response = $json_error_msg;
				}
			}
		}
	}

	// this function fetch insights data and page posts from Graph API 
	public function get_fb_posts_by_api()
	{
		$where = array(
			[
				'key' => 'published',
				'value' => 0,
			],
			[
				'key' => 'type',
				'value' => 'facebook',
			]
		);
		$cronjob_record = $this->Publisher_model->list_records('analytics_cronjob', 0, 1, $where);
		if (count($cronjob_record) > 0) {
			$row = $cronjob_record[0];
			$cron_id = $row->id;
			$user_id = $row->user_id;
			$page_id = $row->pageid;
			$post_count = 0;
			// check user availablity
			$user_row = $this->Publisher_model->get_allrecords('user', array('id' => $user_id));
			if (count($user_row) > 0) {
				// get facebook page
				$facebook_page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id));
				if (count($facebook_page) > 0) {
					$value = $facebook_page[0];
					// get access token
					$access_token = $value->access_token;
					// fetch facebook page posts
					$after = '';
					$posts_array = [];
					do {
						$recent_posts = recent_posts_api($page_id, $user_id, $access_token, 10, $after);
						print_pre($recent_posts);
						$after = isset($recent_posts['paging']['cursors']['after']) ? $recent_posts['paging']['cursors']['after'] : '';
						if (count($recent_posts) <= 0 || (isset($recent_posts['data']) && count($recent_posts['data']) == 0)) {
							break;
						}
						foreach ($recent_posts['data'] as $key => $post) {
							$post_count++;
							// store posts upto 3 months
							$published = date('Y-m-d H:i:s', strtotime($post['created_time']));
							$previous_date = date('Y-m-d 00:00:00', strtotime('-91 days'));
							if ((strtotime($previous_date) >= strtotime($published))) {
								$after = '';
								continue;
							}
							if ($post['status_type'] == 'shared_story') {
								$type = 'Link';
							} elseif ($post['status_type'] == 'mobile_status_update') {
								$type = 'Status Update';
							} elseif ($post['status_type'] == 'added_video') {
								$type = 'Video';
							} elseif ($post['status_type'] == 'added_photos') {
								$type = 'Photo';
							} else {
								$type = 'N/A';
							}
							$post_id = $post['id'];
							$title = isset($post['message']) ? $post['message'] : '';
							$post_image = isset($post['full_picture']) ? saveImageFromUrl($post['full_picture'], $user_id, $post_id) : '';
							// create or update post
							$get_post = $this->Publisher_model->get_allrecords('facebook_posts', array('page_id' => $page_id, 'post_id' => $post_id, 'user_id' => $user_id));
							if (count($get_post) == 0) {
								$data = array(
									'page_id' => $page_id,
									'post_id' => $post_id,
									'user_id' => $user_id,
									'post_title' => $title,
									'post_image' => $post_image,
									'type' => $type,
									'published_at' => $published
								);
								$this->Publisher_model->create_record('facebook_posts', $data);
							} else {
								$get_post = $get_post[0];
								$data = array(
									'post_title' => $title,
									'post_image' => $post_image,
									'type' => $type,
									'published_at' => $published,
								);
								$this->Publisher_model->update_record('facebook_posts', $data, $get_post->id);
							}
							// update cronjob row
							$this->Publisher_model->update_record('analytics_cronjob', array('posts_count' => $post_count), $cron_id);
						}
					} while (!empty($after));
					print_pre($post_count);
				}
			}
			// update cronjob row
			$response = $post_count == 0 ? 'No posts were fetched!' : 'Posts fetched successfully!';
			$this->Publisher_model->update_record('analytics_cronjob', array('published' => 1, 'published_at' => date('Y-m-d H:i:s'), 'response' => $response), $cron_id);
		}
		echo 'Finished!';
	}

	// loop each post of a facebook page
	public function add_facebook_posts_to_cron_table()
	{
		$where = [
			[
				'key' => 'posts_cronjob',
				'value' => 0
			],
			[
				'key' => 'published',
				'value' => 1
			]
		];
		$get_facebook_pages_cronjob = $this->Publisher_model->list_records('analytics_cronjob', 0, 1, $where, 'id', 'asc');
		foreach ($get_facebook_pages_cronjob as $fb_page) {
			$id = $fb_page->id;
			$user_id = $fb_page->user_id;
			$page_id = $fb_page->pageid;
			$where_post = [
				'user_id' => $user_id,
				'page_id' => $page_id,
			];
			$facebook_posts = $this->Publisher_model->get_allrecords('facebook_posts', $where_post);
			foreach ($facebook_posts as $key => $value) {
				$user_id = $value->user_id;
				$post_id = $value->post_id;
				$where = array(
					[
						'key' => 'user_id',
						'value' => $user_id,
					],
					[
						'key' => 'page_id',
						'value' => $page_id,
					],
					[
						'key' => 'post_id',
						'value' => $post_id,
					],
				);
				$check_post = $this->Publisher_model->list_records('facebook_posts_cronjob', 0, 1, $where);
				if (count($check_post) > 0) {
					$row = $check_post[0];
					$update = array(
						'published' => 0,
						'response' => null,
						'start_time' => null,
						'published_at' => null
					);
					$this->db->where('id', $row->id);
					$this->db->update('facebook_posts_cronjob', $update);
				} else {
					$data = array(
						'user_id' => $user_id,
						'page_id' => $page_id,
						'post_id' => $post_id,
						'published' => 0,
					);
					$this->db->insert('facebook_posts_cronjob', $data);
				}
			}
			$this->db->where('id', $id);
			$this->db->update('analytics_cronjob', array('posts_cronjob' => 1));
		}
		echo 'finished!';
	}

	// loop each post of a facebook page and fetch their insights
	public function update_facebook_posts_analytics()
	{
		$where = array(
			[
				'key' => 'published',
				'value' => 0,
			],
		);
		$facebook_posts = $this->Publisher_model->list_records('facebook_posts_cronjob', 0, 500, $where, 'id', 'asc');
		foreach ($facebook_posts as $key => $value) {
			$user_id = $value->user_id;
			$page_id = $value->page_id;
			$post_id = $value->post_id;
			$cron_id = $value->id;
			$this->db->where('id', $cron_id);
			$update = array(
				'published' => 1,
				'start_time' => date("Y-m-d H:i:s"),
			);
			$this->db->update('facebook_posts_cronjob', $update);
			// get facebook page
			$facebook_page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id));
			if (count($facebook_page) > 0) {
				$value = $facebook_page[0];
				// get facebook page insights
				$facebook_page_insights = $this->Publisher_model->get_allrecords('page_insights', array('user_id' => $user_id, 'page_id' => $value->page_id));
				$facebook_page_insights = count($facebook_page_insights) > 0 ? $facebook_page_insights[0] : [];
				$access_token = $value->access_token;
				$data = [
					'clicks' => 0,
					'post_clicks' => 0,
					'link_clicks' => 0,
					'impressions' => 0,
					'follower_reach' => 0,
					'reach' => 0,
					'reach_rate' => 0,
					'eng_rate' => 0,
					'ctr' => 0,
					'likes' => 0,
					'comments' => 0,
					'shares' => 0,
					'engagements' => 1,
					'reactions' => 0,
					'video_views' => 0,
				];
				// load post insights
				$post_insight = post_insight($post_id, $access_token);
				if (isset($post_insight['data']) && count($post_insight['data']) > 0) {
					foreach ($post_insight['data'] as $p_ins) {
						// total post clicks
						if ($p_ins['name'] == 'post_clicks') {
							foreach ($p_ins['values'] as $impr_value) {
								$data['clicks'] = $impr_value['value'];
							}
						}
						// clicks by type
						if ($p_ins['name'] == 'post_clicks_by_type') {
							foreach ($p_ins['values'] as $clicks_value) {
								if (count($clicks_value['value']) > 0) {
									$clicks = $clicks_value['value'];
									foreach ($clicks as $type => $val) {
										if ($type == 'other clicks') {
											$data['post_clicks'] = $val;
										} else {
											$data['link_clicks'] = $val;
										}
									}
								}
							}
						}
						// number of times the post has entered a feed (views)
						if ($p_ins['name'] == 'post_impressions') {
							foreach ($p_ins['values'] as $impr_value) {
								$data['impressions'] = $impr_value['value'];
							}
						}
						// number of people who has seen the post and liked the page
						if ($p_ins['name'] == 'post_impressions_fan') {
							foreach ($p_ins['values'] as $impr_value) {
								$data['follower_reach'] = $impr_value['value'];
							}
						}
						// number of people who have seen the post(reach)
						if ($p_ins['name'] == 'post_impressions_unique') {
							foreach ($p_ins['values'] as $impr_value) {
								$data['reach'] = $impr_value['value'];
							}
						}
						// number of reactions by type
						if ($p_ins['name'] == 'post_reactions_by_type_total') {
							foreach ($p_ins['values'] as $reactions_value) {
								if (count($reactions_value['value']) > 0) {
									$reactions = $reactions_value['value'];
									foreach ($reactions as $type => $count) {
										if ($type == 'like') {
											$data['likes'] = $count;
										}
									}
								}
							}
						}
						// number of unique people who interact with post (like, share, comment)
						if ($p_ins['name'] == 'post_activity_by_action_type_unique') {
							foreach ($p_ins['values'] as $activity_value) {
								if (count($activity_value['value']) > 0) {
									$activity = $activity_value['value'];
									foreach ($activity as $type => $val) {
										if ($type == 'shares') {
											$data['shares'] = $val;
										} elseif ($type == 'like') {
											$data['reactions'] = $val;
										} elseif ($type == 'comment') {
											$data['comments'] = $val;
										}
									}
								}
							}
						}
					}
					$data['engagements'] = $data['shares'] + $data['reactions'] + $data['comments'] + $data['clicks'];
					$data['engagements'] = empty($data['engagements']) ? 1 : $data['engagements'];
					$page_likes = isset($facebook_page_insights->followers) ? $facebook_page_insights->followers : 1;
					$data['reach_rate'] = number_format(($data['reach'] / $page_likes) * 100, 1);
					$data['eng_rate'] = number_format(($data['engagements'] / $data['reach']) * 100, 1);
					$data['ctr'] = number_format(($data['clicks'] / $data['reach']) * 100, 1);
					$data['engagements'] = empty($data['engagements']) ? 0 : $data['engagements'];
				}
				// update analytics of the post
				$this->db->where('post_id', $post_id);
				$this->db->update('facebook_posts', $data);
			}
			$this->db->where('id', $cron_id);
			$update = array(
				'response' => 'Analytics synced successfully!',
				'published_at' => date("Y-m-d H:i:s"),
			);
			$this->db->update('facebook_posts_cronjob', $update);
		}
		echo 'Finished!';
	}

	// fetch daily insight of facebook page 
	public function update_facebook_pages_daily_insights()
	{
		$where = [
			[
				'key' => 'insight_cronjob',
				'value' => 0
			]
		];
		$facebook_pages = $this->Publisher_model->list_records('analytics_cronjob', 0, 100000, $where, 'id', 'asc');
		$this->load->library('facebook');
		foreach ($facebook_pages as $key => $value) {
			$page = $this->Publisher_model->get_allrecords('facebook_pages', array('page_id' => $value->pageid, 'user_id' => $value->user_id));
			$page = $page[0];
			$page_id = $page->page_id;
			$access_token = $page->access_token;
			$metric_array = [
				'page_post_engagements', //number of times people have engaged with posts
				'page_impressions', //nunumber of times any content from your Page or about your Page entered a person's screen
				// 'page_actions_post_reactions_like_total', //daily total post "like" reactions of a page.
				// 'page_actions_post_reactions_love_total', //daily total post "love" reactions of a page.
				// 'page_actions_post_reactions_wow_total', //daily total post "wow" reactions of a page.
				// 'page_actions_post_reactions_haha_total', //daily total post "haha" reactions of a page.
				// 'page_actions_post_reactions_sorry_total', //daily total post "sorry" reactions of a page.
				// 'page_actions_post_reactions_anger_total', //daily total post "anger" reactions of a page.
				'page_video_views', // number of times your Page's videos played for at least 3 seconds or more.
				'page_fans', // number of people who have liked page
			];
			$metric = implode(',', $metric_array);
			// start date
			$since = strtotime(date('Y-m-d', strtotime('-90 days')));
			// end date
			$until = strtotime(date('Y-m-d H:i:s'));
			// api call
			$insights = $this->facebook->request('get', '/' . $page_id . '/insights?access_token=' . $access_token . '&metric=' . $metric . '&period=day' . '&since=' . $since . '&until=' . $until);
			if (isset($insights['data'])) {
				for ($i = 0; $i < 90; $i++) {
					$insight_data = $insights['data'];
					$days = 90 - $i;
					$published_at = date('Y-m-d 00:00:00', strtotime('- ' . $days . ' days'));
					$data = array(
						'page_id' => $page_id,
						'total_engagements' => isset($insight_data[0]['values'][$i]['value']) ? $insight_data[0]['values'][$i]['value'] : 0,
						'total_reach' => isset($insight_data[1]['values'][$i]['value']) ? $insight_data[1]['values'][$i]['value'] : 0,
						'total_video_views' => isset($insight_data[2]['values'][$i]['value']) ? $insight_data[2]['values'][$i]['value'] : 0,
						'total_followers' => isset($insight_data[3]['values'][$i]['value']) ? $insight_data[3]['values'][$i]['value'] : 0,
						'published_at' => $published_at,
					);
					$check_insight = $this->Publisher_model->get_allrecords('facebook_page_daily_insights', array('page_id' => $page_id, 'published_at' => $published_at));
					if (count($check_insight) > 0) {
						$check_insight = $check_insight[0];
						$this->db->where('id', $check_insight->id);
						$this->db->update('facebook_page_daily_insights', $data);
					} else {
						$this->db->insert('facebook_page_daily_insights', $data);
					}
				}
			}
			$this->db->where('id', $value->id);
			$this->db->update('analytics_cronjob', array('insight_cronjob' => 1));
		}
		echo 'Finished!';
	}

	// refresh facebook posts, posts insights and page insight
	public function update_facebook_analytics()
	{
		$where = [
			['key' => 'published', 'value' => '1']
		];
		$facebook_analytic_records = $this->Publisher_model->list_records('analytics_cronjob', 0, 100000, $where, 'id', 'asc');
		foreach ($facebook_analytic_records as $key => $value) {
			$user_id = $value->user_id;
			$page_id = $value->pageid;
			$page = $this->Publisher_model->get_allrecords('facebook_pages', ['user_id' => $user_id, 'page_id' => $page_id]);
			$user_check = user_check($user_id);
			if (count($page) == 0) {
				$this->Publisher_model->delete_record('analytics_cronjob', $value->id);
				continue;
			}
			if (!$user_check['status']) {
				$this->Publisher_model->delete_record('analytics_cronjob', $value->id);
				continue;
			}
			$this->db->where('id', $value->id);
			$this->db->update('analytics_cronjob', ['published' => 0, 'posts_cronjob' => 0, 'insight_cronjob' => 0]);
		}
		echo 'Finished!';
	}

	// delete posts that are older than 3 months
	public function delete_previous_posts()
	{
		$date = date('Y-m-d 00:00:00', strtotime('-90 days'));
		$where = array('published_at <' => $date);
		$this->db->where($where);
		$query = $this->db->delete('facebook_posts');
		echo 'Finished!';
	}

	public function fetch_rss_latest_posts_pinterest()
	{
		try {
			$pinterest_users = $this->Publisher_model->select_active_pinterest_users();
			foreach ($pinterest_users as $pinterest_user) {
				$user_id = $pinterest_user->user_id;
				$error_column_name = 'pinterest_error';
				$function_name = 'fetch_rss_latest_posts_pinterest';
				$user = $this->Publisher_model->retrieve_record('user', $pinterest_user->user_id);
				if (!empty($user)) {
					$pkinfo = $this->Publisher_model->userPackageforCron($user);
					if ($pkinfo->active == '1') {
						$boards = $this->Publisher_model->get_rss_boards($user->id);
						foreach ($boards as $board) {
							$this->Publisher_model->update_last_run($board->id, 'last_run', 'pinterest_boards');
							$page = $board->id;
							$channel_name = $board->name;
							// check user membership and user existence
							$user_check = user_check($user_id);
							if (!$user_check['status']) {
								$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $user_check['message']); // helper function
								continue;
							}
							if (!$board->rss_active || empty($board->rss_link) || strpos($board->rss_link, '.atom') !== false) {
								continue;
							}
							$rss_linke = json_decode($board->rss_link);
							if (empty($rss_linke)) { // This means the rss link was never encoded before so you cant decode for the first time
								$rss_linke[] = $board->rss_link;
							}
							foreach ($rss_linke as $links) {
								$response = pin_board_fetch_more_posts($links, $page, $user_id, json_decode($board->time_slots_rss, true), $links);
								if (!$response['status']) {
									updateCronJobError($user->id, $error_column_name, $channel_name, $function_name, 'Failed to fetch the RSS feed from ' . $links);
								}
							}
						}
					}
				}
			}
		} catch (Exception $e) {
			// Handle the exception
			$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $e . ' Something went wrong, Please try again.'); // helper function
		}
	}

	public function fetch_rss_latest_posts_facebook()
	{
		try {
			$users = $this->Publisher_model->selectactivefacebookusers();
			foreach ($users as $user) {
				$user_id = $user->id;
				$error_column_name = 'facebook_page_error';
				$function_name = 'fetch_rss_latest_posts_facebook';
				if (!empty($user)) {
					$pkinfo = $this->Publisher_model->userPackageforCron($user);
					if ($pkinfo->active == '1') {
						$pages = $this->Publisher_model->get_rsspages($user->id);
						foreach ($pages as $page) {
							$page_id = $page->id;
							$timeslots = json_decode($page->time_slots_rss, true);
							$this->Publisher_model->update_last_run($page_id, 'last_run', 'facebook_pages');
							$channel_name = $page->page_name;
							$user_check = user_check($user_id);
							if (!$user_check['status']) {
								$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $user_check['message']); // helper function
								continue;
							}
							if (!$page->rss_active || empty($page->rss_link) || $page->rss_link == 'null' || strpos($page->rss_link, '.atom') !== false) {
								continue;
							}
							$rss_linke = json_decode($page->rss_link);
							if (empty($rss_linke)) { // This means the rss link was never encoded before so you cant decode for the first time
								$rss_linke[] = $page->rss_link;
							}
							foreach ($rss_linke as $links) {
								$response = fb_page_fetch_more_posts($links, $page_id, $user_id, $timeslots, 0);
								if ($response['status']) {
									removeCronJobError($user_id, $error_column_name);
								} else {
									updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, 'Failed to fetch the RSS feed from' . $links); // helper function
								}
							}
						}
					}
				}
			}
		} catch (Exception $e) {
			// Handle the exception
			$json_error_msg = updateCronJobError($user->id, $error_column_name, $channel_name, $function_name, $e . ' Something went wrong, Please try again.'); // helper function
		}
	}

	public function fetch_rss_latest_posts_instagram()
	{
		try {
			$ig_users = $this->Publisher_model->get_rss_active_ig_uesrs();
			foreach ($ig_users as $ig_user) {
				// update last run
				$this->Publisher_model->update_last_run($ig_user->id, 'last_run', 'instagram_users');
				// get user
				$user = $this->Publisher_model->retrieve_record('user', $ig_user->user_id);
				$user_id = $user->id;
				// timeslots
				$timeslots = json_decode($ig_user->time_slots_rss, true);
				// check user package info
				$pkinfo = $this->Publisher_model->userPackageforCron($user);
				// error name
				$error_column_name = 'instagram_error';
				// function name
				$function_name = 'fetch_rss_latest_posts_instagram';
				// channel name
				$channel_name = $ig_user->instagram_username;
				// check user membership and user existence
				$user_check = user_check($user_id);
				if (!$user_check['status']) {
					$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $user_check['message']); // helper function
					continue;
				}
				if ($pkinfo->active == '1') {
					if (!$ig_user->rss_active || empty($ig_user->rss_link) || strpos($ig_user->rss_link, '.atom') !== false) {
						continue;
					}
					// rss links
					$rss_linke = json_decode($ig_user->rss_link);
					if (empty($rss_linke)) { // This means the rss link was never encoded before so you cant decode for the first time
						$rss_linke[] = $ig_user->rss_link;
					}
					foreach ($rss_linke as $link) {
						$response = ig_user_fetch_more_posts($link, $ig_user->id, $user_id, $timeslots, 0);
						if ($response['status']) {
							removeCronJobError($user_id, $error_column_name);
						} else {
							updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, 'Failed to fetch the RSS feed from' . $link); // helper function
						}
					}
				}
			}
		} catch (Exception $e) {
			// Handle the exception
			$json_error_msg = updateCronJobError($user->id, $error_column_name, $channel_name, $function_name, $e . ' Something went wrong, Please try again.'); // helper function
		}
	}

	public function publish_facebook_posts()
	{
		$where = [['key' => 'type', 'value' => 'facebook'], ['key' => 'published', 'value' => 0]];
		$unpublished_posts = $this->Publisher_model->list_records('publish_posts', 0, 1, $where, 'id', 'asc');
		foreach ($unpublished_posts as $key => $value) {
			// $debug = debug($value->user_id);
			// change status to publish
			$this->Publisher_model->update_record('publish_posts', array('published' => '1'), $value->id);
			if (empty($value->link) && empty($value->image) && empty($value->video_path)) {
				$type = 'quote';
			} elseif (!empty($value->link)) {
				$type = 'link';
			} elseif (!empty($value->video_path)) {
				$type = 'video';
			} else {
				$type = 'photo';
			}
			$facebook_page = $this->Publisher_model->get_allrecords('facebook_pages', array('page_id' => $value->page_id, 'user_id' => $value->user_id));
			if (count($facebook_page) > 0) {
				$this->load->library('facebook');
				$page = $facebook_page[0];
				$access_token = $page->access_token;
				$error_postData = [];
				$error_postData['title'] = $value->title;
				if ($type == 'photo') { //for image
					$image_path = BulkAssets . $value->image;
					$error_postData['image'] = $image_path;
					$postData = ['caption' => $value->title, 'url' => $image_path];
					$result = $this->facebook->request('POST', "/" . $page->page_id . "/photos", $postData, (string) $access_token);
				}
				if ($type == 'link') { //for link
					$fetch_from_url = metaOfUrlt($value->link, 'other');
					$image_path = isset($fetch_from_url['image']) && !empty($fetch_from_url['image']) ? saveImageFromUrl($fetch_from_url['image'], $value->user_id, $value->id) : '';
					$error_postData['image'] = BulkAssets . $image_path;
					$postData = ['message' => $value->title, 'link' => $value->link];
					$result = $this->facebook->request('post', '/' . $value->page_id . '/feed', $postData, (string) $access_token);
				}
				if ($type == 'quote') { //for text only
					$error_postData['image'] = '';
					$postData = ['message' => $value->title];
					$result = $this->facebook->request('post', '/' . $value->page_id . '/feed', $postData, (string) $access_token);
				}
				if ($type == 'video') { //for video
					$error_postData['image'] = '';
					$file_url = get_from_s3bucket($value->video_path);
					if ($file_url['status']) {
						$file_name = BulkAssets . $file_url['file_name'];
						$postData = ['description' => $value->title, 'file_url' => $file_name];
						$result = $this->facebook->request('POST', '/' . $page->page_id . '/videos', $postData, $access_token);
						remove_file($file_url['file_name']);
					}
				}
				remove_file($value->image);
				remove_from_s3bucket($value->video_path);
				if (isset($result['id'])) {
					resources_update('up', POST_PUBLISHING_FB_ID);
					if (!empty($value->comment)) {
						$this->Publisher_model->publish_comments($result['id'], $value->comment, (string) $access_token);
					}
					$this->Publisher_model->update_record('publish_posts', array('published' => '1', 'error' => $result['id']), $value->id);
				} else {
					$this->Publisher_model->update_record('publish_posts', array('published' => '-1', 'error' => $result['message']), $value->id);
					notify_via_email($error_postData, $page, 'Facebook', $result['message']);
				}
				isset($image_path) ? remove_file($image_path) : '';
			} else {
				$this->Publisher_model->delete_record('publish_posts', $value->id);
				continue;
			}
		}
	}

	public function publish_pinterest_posts()
	{
		$where = [
			['key' => 'type', 'value' => 'pinterest'],
			['key' => 'published', 'value' => 0]
		];
		$unpublished_posts = $this->Publisher_model->list_records('publish_posts', 0, 10, $where, 'id', 'asc');
		print_pre($unpublished_posts);
		foreach ($unpublished_posts as $key => $value) {
			// change status to publish
			$this->Publisher_model->update_record('publish_posts', array('published' => 1), $value->id);
			$type = $value->content_type;
			$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $value->user_id));
			if (count($pinterest_user) > 0) {
				$pinterest_user = $pinterest_user[0];
				$boards = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $value->user_id, 'board_id' => $value->page_id));
				$board = $boards[0];
				$error_postData = [];
				$error_postData['title'] = $value->title;
				$access_token = $pinterest_user->access_token;
				if ($type == 'image_url') {
					$fetch_from_url = metaOfUrlt($value->link, 'pinterest');
					$image_path = isset($fetch_from_url['image']) && !empty($fetch_from_url['image']) ? saveImageFromUrl($fetch_from_url['image'], $value->user_id, $value->id) : '';
					$error_postData['image'] = BulkAssets . $image_path;
					$image_path = isImage($value->image) ? $value->image : fetchImage($value->link, 'pinterest');
					$data = [
						'title' => $value->title,
						'description' => $value->title,
						'link' => $value->link,
						'image' => $image_path,
						'board_id' => $value->page_id,
						'content_type' => $value->content_type,
						'access_token' => $access_token,
					];
					$response = $this->Publisher_model->publish_pin_curl($data);
				}

				if ($type == 'image_path') {
					$image_path = make_image_url($value->image);
					$error_postData['image'] = $image_path;
					$data = [
						'title' => $value->title,
						'description' => $value->title,
						'link' => $value->link,
						'image' => $image_path,
						'board_id' => $value->page_id,
						'content_type' => $value->content_type,
						'access_token' => $access_token,
					];
					$response = $this->Publisher_model->publish_pin_curl($data);
				}

				if ($type == 'video_path') {
					$error_postData['image'] = '';
					$data = [
						'title' => $value->title,
						'description' => $value->title,
						'video_path' => $value->video_path,
						'board_id' => $value->page_id,
						'access_token' => $access_token
					];
					$response = $this->Publisher_model->publish_video_pin_curl($data);
				}
				$response = json_decode($response, true);
				print_pre($response);
				if (isset($response['id']) && !empty($response['id'])) {
					$this->Publisher_model->update_record('publish_posts', array('published' => '1', 'error' => $response['id']), $value->id);
					resources_update('up', POST_PUBLISHING_PIN_ID);
				} else {
					$this->Publisher_model->update_record('publish_posts', array('published' => '-1', 'error' => $response['message']), $value->id);
					notify_via_email($error_postData, $board, 'Pinterest', $response['message']);
				}
				isset($image_path) ? remove_file($image_path) : '';
				remove_file($value->image);
				remove_file($value->video_path);
				remove_from_s3bucket($value->video_path);
			} else {
				$this->db->where('id', $value->id);
				$this->db->delete('publish_posts');
				continue;
			}
		}
	}

	public function publish_tiktok_posts()
	{
		$where = [
			[
				'key' => 'type',
				'value' => 'tiktok'
			],
			[
				'key' => 'published',
				'value' => 0
			]
		];
		$unpublished_posts = $this->Publisher_model->list_records('publish_posts', 0, 10, $where, 'id', 'asc');
		foreach ($unpublished_posts as $key => $value) {
			// change status to publish
			$update = [
				'published' => 1,
			];
			$this->db->where('id', $value->id);
			$this->db->update('publish_posts', $update);
			// change status to publish
			$type = !empty($value->image) ? 'image' : 'video';
			$tiktok_acc = $this->Publisher_model->get_allrecords('tiktok', array('user_id' => $value->user_id, 'open_id' => $value->page_id));
			if (count($tiktok_acc) > 0) {
				$this->load->library('tiktok');
				$tiktok_acc = $tiktok_acc[0];
				$access_token = refresh_tiktok_access_token($tiktok_acc->access_token);
				$error_postData = ['title' => $value->title, 'image' => $type == 'image' ? BulkAssets . $value->image : ''];
				if ($type == 'image') {
					$postData = array(
						'title' => $value->title,
						'url' => BulkAssets . $value->image,
					);
					$response = $this->tiktok->publish_photo($postData, $access_token);
				}
				if ($type == 'video') {
					$video = get_from_s3bucket($value->video_path);
					$postData = array(
						'title' => $value->title,
						'url' => BulkAssets . $video['file_name'],
					);
					$response = $this->tiktok->publish_video($postData, $access_token);
				}
				if (isset($response['publish_id'])) {
					do {
						sleep(0.5);
						$publish = $this->tiktok->fetch_status($access_token, $response['publish_id']);
					} while (!in_array($publish['status'], ['PUBLISH_COMPLETE', 'FAILED']));
					if (isset($publish['status']) && $publish['status'] == 'PUBLISH_COMPLETE') {
						remove_file($value->image);
						$this->Publisher_model->update_record('publish_posts', array('published' => '1', 'error' => $response['publish_id']), $value->id);
					} else {
						$this->Publisher_model->update_record('publish_posts', array('published' => '-1', 'error' => $publish['fail_reason']), $value->id);
						notify_via_email($error_postData, $tiktok_acc, 'TikTok', $publish['fail_reason']);
					}
				} else {
					$this->Publisher_model->update_record('publish_posts', array('published' => '-1', 'error' => $response['error_description']), $value->id);
					notify_via_email($error_postData, $tiktok_acc, 'TikTok', $response['error_description']);
				}
			} else {
				continue;
			}
		}
	}

	public function publish_instagram_posts()
	{
		$where = [
			[
				'key' => 'type',
				'value' => 'instagram'
			],
			[
				'key' => 'published',
				'value' => 0
			]
		];
		$unpublished_posts = $this->Publisher_model->list_records('publish_posts', 0, 10, $where, 'id', 'asc');
		foreach ($unpublished_posts as $key => $value) {
			// change status to in progress
			// $this->Publisher_model->update_record('publish_posts', array('published' => '2'), $value->id);
			// change status to in progress
			$type = !empty($value->image) ? 'image' : 'video';
			$ig_user = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $value->user_id, 'instagram_id' => $value->page_id));
			if (count($ig_user) > 0) {
				$ig_user = $ig_user[0];
				if ($type == 'image') {
					$response = publish_ig_single_media($ig_user->instagram_id, $ig_user->access_token, $value->image, $value->title, $value->user_id);
					if ($response['status']) {
						$this->Publisher_model->update_record('publish_posts', array('published' => '1', 'error' => 'Posts are published on Instagram successfully.'), $value->id);
					} else {
						$this->Publisher_model->update_record('publish_posts', array('published' => '-1', 'error' => 'Failed to publish on Instagram.'), $value->id);
					}
				}
				if ($type == "video") {
					$video_path = get_from_s3bucket($value->video_path, 1);
					dd([$video_path]);
					$video_path = BulkAssets . $video_path["file_name"];
					$response = publish_reels_to_instagram($ig_user->instagram_id, $ig_user->access_token, $video_path, $value->title, $value->user_id);
					if ($response['status']) {
						$this->Publisher_model->update_record('publish_posts', array('published' => '1', 'error' => 'Posts are published on Instagram successfully.'), $value->id);
					} else {
						$this->Publisher_model->update_record('publish_posts', array('published' => '-1', 'error' => $response["message"]), $value->id);
					}
				}
			} else {
				continue;
			}
		}
	}

	public function fetch_rss_feed()
	{
		$where = [
			[
				'key' => 'published',
				'value' => 0
			]
		];
		$unpublished_links = $this->Publisher_model->list_records('rss_links', 0, 1, $where, 'id', 'asc');
		foreach ($unpublished_links as $key => $value) {
			// update publish column
			$this->Publisher_model->update_record('rss_links', ['published' => '2'], $value->id);
			// update publish column
			$type = $value->type;
			if ($type == 'facebook') {
				$facebook_page = $this->Publisher_model->get_allrecords('facebook_pages', array('page_id' => $value->page_id, 'user_id' => $value->user_id));
				if (count($facebook_page) > 0) {
					$page = $facebook_page[0];
					$timeslots = json_decode($page->time_slots);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						$response = fb_page_fetch_more_posts($value->url, $page->id, $value->user_id, $timeslots, 0);
					}
				}
			}
			if ($type == 'pinterest') {
				$pinterest_board = $this->Publisher_model->get_allrecords('pinterest_boards', array('id' => $value->page_id));
				if (count($pinterest_board) > 0) {
					$board = $pinterest_board[0];
					$timeslots = json_decode($board->time_slots_rss);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						$count = 1;
						do {
							$response = pin_board_fetch_more_posts($value->url, $value->page_id, $value->user_id, $timeslots, 0);
							$count++;
							sleep(rand(2, 5));
						} while (!$response["status"] && $count <= 3);
					}
				}
			}
			if ($type == 'instagram') {
				$ig_user = $this->Publisher_model->retrieve_record('instagram_users', $value->page_id);
				if ($ig_user) {
					$timeslots = json_decode($ig_user->time_slots_rss);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						$response = ig_user_fetch_more_posts($value->url, $value->page_id, $value->user_id, $timeslots, 0);
					}
				}
			}
			if ($type == 'tiktok') {
				$tiktok = $this->Publisher_model->retrieve_record('tiktok', $value->page_id);
				print_pre($tiktok);
				if ($tiktok) {
					$timeslots = json_decode($tiktok->time_slots_rss);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						$response = tiktok_fetch_more_posts($value->url, $value->page_id, $value->user_id, $timeslots, 0);
					}
				}
			}
			$this->Publisher_model->update_record('rss_links', ['published' => '1'], $value->id);
		}
	}

	public function refresh_rss_feed()
	{
		$where = [
			[
				'key' => 'published',
				'value' => 0
			]
		];
		$unpublished_feeds = $this->Publisher_model->list_records('refresh_feeds', 0, 1, $where, 'id', 'asc');
		foreach ($unpublished_feeds as $key => $feed) {
			// update publsihed status
			$this->db->where('id', $feed->id);
			$this->db->update('refresh_feeds', array('published' => 1));
			$timeslots = explode(',', $feed->timeslots);
			$response = refresh_posts($feed->user_id, $feed->page_id, $timeslots, $feed->rss_table, $feed->id_column, $feed->status_column, $feed->id);
			// update response column
			$this->db->where('id', $feed->id);
			$this->db->update('refresh_feeds', array('completed_at' => date('Y-m-d H:i:s')));
		}
	}

	public function fetch_past_rss_feed()
	{
		$where = [
			[
				'key' => 'published',
				'value' => 0
			]
		];
		$unpublished_links = $this->Publisher_model->list_records('rss_links', 0, 1, $where, 'id', 'asc');
		foreach ($unpublished_links as $key => $value) {
			// update publish column
			$this->Publisher_model->update_record('rss_links', ['published' => '2'], $value->id);
			// update publish column
			$type = $value->type;
			if ($type == 'facebook_past') {
				print_pre('1');
				$facebook_page = $this->Publisher_model->get_allrecords('facebook_pages', array('id' => $value->page_id, 'user_id' => $value->user_id));
				if (count($facebook_page) > 0) {
					$page = $facebook_page[0];
					$timeslots = json_decode($page->time_slots_rss);
					print_pre('2');
					if (count($timeslots) > 0) {
						print_pre('3');
						$timeslots = implode(',', $timeslots);
						$count = 1;
						do {
							$response = fb_page_fetch_past_posts($value->url, $page->id, $value->user_id, $timeslots, 0);
							$count++;
							sleep(rand(2, 5));
						} while (!$response["status"] && $count <= 3);
					}
				}
			}
			if ($type == 'pinterest_past') {
				$pinterest_board = $this->Publisher_model->get_allrecords('pinterest_boards', array('id' => $value->page_id));
				if (count($pinterest_board) > 0) {
					$board = $pinterest_board[0];
					$timeslots = json_decode($board->time_slots_rss);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						$count = 1;
						do {
							$response = pin_board_fetch_past_posts($value->url, $value->page_id, $value->user_id, 0);
							$count++;
							sleep(rand(2, 5));
						} while (!$response["status"] && $count <= 3);
					}
				}
			}
			if ($type == 'instagram_past') {
				$ig_user = $this->Publisher_model->retrieve_record('instagram_users', $value->page_id);
				if ($ig_user) {
					$timeslots = json_decode($ig_user->time_slots_rss);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						$response = ig_user_fetch_past_posts($value->url, $value->page_id, $value->user_id, $timeslots, 0);
					}
				}
			}
			if ($type == 'tiktok_past') {
				$tiktok = $this->Publisher_model->retrieve_record('tiktok', $value->page_id);
				print_pre($tiktok);
				if ($tiktok) {
					$timeslots = json_decode($tiktok->time_slots_rss);
					if (count($timeslots) > 0) {
						$timeslots = implode(',', $timeslots);
						print_pre($timeslots);
						$response = tiktok_fetch_past_posts($value->url, $value->page_id, $value->user_id, $timeslots, 0);
					}
				}
			}
			$this->Publisher_model->update_record('rss_links', ['published' => '1'], $value->id);
		}
	}

	public function publish_queue_now()
	{
		$where = [
			['key' => 'published', 'value' => 0],
			['key' => 'type', 'value' => array('facebook', 'pinterest', 'instagram', 'tiktok')]
		];
		$unpublshed_posts = $this->Publisher_model->list_records('publish_now', 0, 10, $where, 'id', 'asc');
		foreach ($unpublshed_posts as $post) {
			$type = $post->type;
			// update publish column
			$this->Publisher_model->update_record('publish_now', array('published' => 1), $post->id);
			$this->Publisher_model->update_record('channels_scheduler', array('status' => 2, 'response' => 'Processing'), $post->id);
			if ($type == 'facebook') {
				$page = $this->Publisher_model->retrieve_record('facebook_pages', $post->page_id);
				if (!empty($page)) {
					$post_data = $this->Publisher_model->retrieve_record('channels_scheduler', $post->post_id);
					$response = fb_page_queue_publish_now($post_data, $page);
					if (!$response['status']) {
						resources_update('down', POST_SCHEDULING_FB_ID, $post->user_id);
					}
				} else {
					resources_update('down', POST_SCHEDULING_FB_ID, $post->user_id);
					$this->Publisher_model->delete_record('publish_now', $post->id);
				}
			}
			if ($type == 'pinterest') {
				$board = $this->Publisher_model->retrieve_record('pinterest_boards', $post->page_id);
				if (!empty($board)) {
					$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', ['user_id' => $post->user_id]);
					$post_data = $this->Publisher_model->retrieve_record('channels_scheduler', $post->post_id);
					$response = pin_board_queue_publish_now($post_data, $board, $pinterest_user);
					if (!$response['status']) {
						resources_update('down', POST_SCHEDULING_PIN_ID, $post->user_id);
					}
				} else {
					resources_update('down', POST_SCHEDULING_PIN_ID, $post->user_id);
					$this->Publisher_model->delete_record('publish_now', $post->id);
				}
			}
			if ($type == 'instagram') {
				$ig_user = $this->Publisher_model->retrieve_record('instagram_users', $post->page_id);
				if (!empty($ig_user)) {
					$post_data = $this->Publisher_model->retrieve_record('channels_scheduler', $post->post_id);
					$response = ig_user_queue_publish_now($post_data, $ig_user, $post->user_id);
					if (!$response['status']) {
						resources_update('down', POST_SCHEDULING_INST_ID, $post->user_id);
					}
				} else {
					resources_update('down', POST_SCHEDULING_INST_ID, $post->user_id);
					$this->Publisher_model->delete_record('publish_now', $post->id);
				}
			}
			if ($type == 'tiktok') {
				$tiktok_acc = $this->Publisher_model->retrieve_record('tiktok', $post->page_id);
				if (!empty($tiktok_acc)) {
					$this->load->library('tiktok');
					$post_data = $this->Publisher_model->retrieve_record('channels_scheduler', $post->post_id);
					$access_token = refresh_tiktok_access_token($tiktok_acc->access_token);
					if (!empty($post_data->video_path)) {
						$error_postData = ['title' => $post_data->post_title, 'image' => ''];
						$video = get_from_s3bucket($post_data->video_path);
						$postData = array('title' => $post_data->post_title, 'url' => BulkAssets . $video['file_name']);
						$response = $this->tiktok->publish_video($postData, $access_token);
					} else {
						$error_postData = ['title' => $post_data->post_title, 'image' => strpos($post_data->link, 'http://') !== false || strpos($post_data->link, 'https://') !== false ? $post_data->link : BulkAssets . $post_data->link];
						$postData = array('title' => $post_data->post_title, 'url' => strpos($post_data->link, 'http://') !== false || strpos($post_data->link, 'https://') !== false ? $post_data->link : BulkAssets . $post_data->link);
						$response = $this->tiktok->publish_photo($postData, $access_token);
					}
					if (isset($response['publish_id'])) {
						do {
							sleep(0.5);
							$publish = $this->tiktok->fetch_status($access_token, $response['publish_id']);
						} while (!in_array($publish['status'], ['PUBLISH_COMPLETE', 'FAILED']));
						if (isset($publish['status']) && $publish['status'] == 'PUBLISH_COMPLETE') {
							remove_file($post_data->link);
							remove_from_s3bucket($post_data->video_path);
							$response = [
								'status' => true,
								'message' => $response['publish_id'],
								'post_id' => $response['publish_id']
							];
						} else {
							$response = [
								'status' => false,
								'error' => $publish['fail_reason']
							];
							notify_via_email($error_postData, $tiktok_acc, 'TikTok', $publish['fail_reason']);
						}
					} else {
						$response = [
							'status' => false,
							'error' => $response['error_description']
						];
						notify_via_email($error_postData, $tiktok_acc, 'TikTok', $response['error_description']);
					}
				} else {
					$this->Publisher_model->delete_record('publish_now', $post->id);
				}
			}
			if (!$response['status']) {
				$response_data = [
					'status' => '-1',
					'response' => $response['error']
				];
			} else {
				$response_data = [
					'status' => '1',
					'response' => $response['message'],
					'post_id' => $response['post_id']
				];
			}
			// update post response/status
			$this->db->where('id', $post->post_id);
			$this->db->update('channels_scheduler', $response_data);
		}
	}

	public function publish_rss_now()
	{
		$where = [
			['key' => 'published', 'value' => 0],
			['key' => 'type', 'value' => array('facebook_rss', 'pinterest_rss', 'instagram_rss')],
		];
		$unpublshed_posts = $this->Publisher_model->list_records('publish_now', 0, 10, $where, 'id', 'asc');
		foreach ($unpublshed_posts as $post) {
			// update publish column
			$this->db->where('id', $post->id);
			$this->db->update('publish_now', array('published' => 1));
			$type = $post->type;
			if ($type == 'facebook_rss') {
				$table = 'rsssceduler';
				$status_column = 'posted';
				$page = $this->Publisher_model->retrieve_record('facebook_pages', $post->page_id);
				if (!empty($page)) {
					$post_data = $this->Publisher_model->retrieve_record('rsssceduler', $post->post_id);
					$response = fb_page_publish_now($post_data, $page, $post->user_id);
				} else {
					if ($post->post_type == 'latest') {
						resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID, $post->user_id);
					} elseif ($post->post_type == 'past') {
						resources_update('down', RSS_FEED_OLD_POST_FETCH_ID, $post->user_id);
					}
					$this->Publisher_model->delete_record('publish_now', $post->id);
				}
			}
			if ($type == 'pinterest_rss') {
				$table = 'pinterest_scheduler';
				$status_column = 'published';
				$page = $this->Publisher_model->retrieve_record('pinterest_boards', $post->page_id);
				if (!empty($page)) {
					$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $post->user_id));
					$post_data = $this->Publisher_model->retrieve_record('pinterest_scheduler', $post->post_id);
					$response = pin_board_publish_now($post_data, $page, $pinterest_user);
				} else {
					if ($post->post_type == 'latest') {
						resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID, $post->user_id);
					} elseif ($post->post_type == 'past') {
						resources_update('down', RSS_FEED_OLD_POST_FETCH_ID, $post->user_id);
					}
					$this->Publisher_model->delete_record('publish_now', $post->id);
				}
			}
			if (!$response['status']) {
				if ($post->post_type == 'latest') {
					resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID, $post->user_id);
				} elseif ($post->post_type == 'past') {
					resources_update('down', RSS_FEED_OLD_POST_FETCH_ID, $post->user_id);
				}
				$response_data[$status_column] = '1';
				$this->Publisher_model->update_record($table, $response_data, $post->id);
			} else {
				resources_update('up', RSS_FEED_POST_PUBLISH_ID, $post->user_id);
			}
		}
	}

	public function email_sending()
	{
		$pending_emails = $this->Publisher_model->get_allrecords('email_cron', array('status' => '0'));
		foreach ($pending_emails as $pending_email) {
			$this->Publisher_model->update_record('email_cron', array('status' => '1'), $pending_email->id);
			$types = array('welcomeEmail', 'regMailPending', 'regMail', 'regMailPending', 'post_publishing_fail');
			if (in_array($pending_email->type, $types)) {
				$mailer = Mailer::sendMail();
				$msg = (new Swift_Message())
					->setSubject($pending_email->subject)
					->setFrom(array($pending_email->site_email => $pending_email->company_name))
					->setTo(array($pending_email->email => $pending_email->email))
					->setBody(
						$pending_email->body,
						'text/html'
					);
				$res = $mailer->send($msg);
			}
		}
	}

	public function tiktokAnalytics()
	{
		$unpublished_crons = $this->Publisher_model->get_allrecords('analytics_cronjob', array('type' => 'tiktok', 'published' => '0'));
		foreach ($unpublished_crons as $cron) {
			$this->load->library('tiktok');
			$tiktok = $this->Publisher_model->retrieve_record('tiktok', $cron->pageid);
			$user = $this->Publisher_model->retrieve_record('user', $cron->user_id);
			if (empty($tiktok) || empty($user)) {
				$this->Publisher_model->delete_record('analytics_cronjob', $cron->id);
			}
			$next_cursor = '';
			do {
				$access_token = refresh_tiktok_access_token($tiktok->access_token);
				$tiktok_posts = $this->tiktok->get_videos($access_token);
				$next_cursor = $tiktok_posts['debug']->cursorNext;
				foreach ($tiktok_posts['data']['videos'] as $key => $post) {
					$cover_image = saveImageFromUrl($post['cover_image_url'], $user->id, $tiktok->id, rand());
					$check_post = $this->Publisher_model->get_allrecords('tiktok_posts', array('user_id' => $user->id, 'tiktok_id' => $tiktok->id, 'post_id' => $post['id']));
					if (count($check_post) > 0) {
						$check_post = $check_post[0];
						remove_file($check_post->cover_image);
						$data = [
							'post_title' => $post['title'],
							'cover_image' => $cover_image,
							'post_url' => $post['share_url'],
							'view_count' => $post['view_count'],
							'like_count' => $post['like_count'],
							'comment_count' => $post['comment_count'],
							'share_count' => $post['share_count'],
							'published_at' => date('Y-m-d H:i:s', $post['create_time']),
						];
						$this->Publisher_model->update_record('tiktok_posts', $data, $check_post->id);
					} else {
						$data = [
							'user_id' => $user->id,
							'tiktok_id' => $tiktok->id,
							'post_id' => $post['id'],
							'title' => $post['title'],
							'cover_image' => $cover_image,
							'post_url' => $post['share_url'],
							'view_count' => $post['view_count'],
							'like_count' => $post['like_count'],
							'comment_count' => $post['comment_count'],
							'share_count' => $post['share_count'],
							'published_at' => date('Y-m-d H:i:s', $post['create_time']),
						];
						$this->Publisher_model->create_record('tiktok_posts', $data);
					}
					$published = date('Y-m-d H:i:s', $post['create_time']);
					$previous_date = date('Y-m-d 00:00:00', strtotime('-91 days'));
					if ((strtotime($previous_date) >= strtotime($published))) {
						break;
					}
				}
			} while (!empty($next_cursor));
			$this->Publisher_model->update_record('analytics_cronjob', array('published' => 1), $cron->id);
			print_pre('Finished');
		}
	}
}
