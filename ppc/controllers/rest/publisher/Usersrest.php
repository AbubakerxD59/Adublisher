<?php

/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - updateprofile_POST()
 * - sessioncheck()
 * - ownerdashboardwidgets_GET()
 * - dashboardwidgets_GET()
 * - redirectlink_POST()
 * - updateCampaign_post()
 * - addCampaign_post()
 * - deleteCampaign_post()
 * - affiliateanalyticsdomainedelete_post()
 * - affiliateanalyticsdomainedit_post()
 * - affiliateanalyticsdomainadd_post()
 * - affiliateredirectdomainedelete_post()
 * - affiliateredirectdomainedit_post()
 * - affiliateredirectdomainadd_post()
 * - updateaffiliate_post()
 * - affiliatepay_post()
 * - deleteaffiliate_post()
 * - editaffiliate_post()
 * - updateGenrates_post()
 * - userSalary_get()
 * - getGenratesowner_get()
 * - getGenrates_get()
 * - setUpdateGenrates_post()
 * - setUpdateAdvDomains_post()
 * - updateGenassignAdv_post()
 * - affiliateownertrafficsummary_GET()
 * - affiliatecampaigntrafficsummary_POST()
 * - affiliateindividualcountrytrafficsummary_GET()
 * - campaignwise_POST()
 * - specific_country_click_GET()
 * - getAdvDomains_get()
 * - changedomain_post()
 * - dashboardforProfile_GET()
 * - loadFacebookPages_POST()
 * - recusriveCall()
 * - gmt_status_GET()
 * - change_announce_view_GET()
 * - metaOfUrl_POST()
 * - metaOfUrlt()
 * - create_instagram_bulkupload_POST()
 * - create_facebook_bulkupload_POST()
 * - update_facebook_bulkupoad_POST()
 * - getinstagrambulkscheduled_post()
 * - gefacebooktbulkscheduled_post()
 * - getrssscheduled_post()
 * - rss_feed_POST()
 * - rss_cronjob_get()
 * - create_single_rss_feed()
 * - getNextPostTime()
 * - updatetimeslotsrss_POST()
 * - updatetimeslots_POST()
 * - update_article_POST()
 * - facebookbulksceduleddelete_POST()
 * - facebookbulksceduleddeleteall_POST()
 * - deletersspost_POST()
 * - deletersspostall_POST()
 * - instagrambulksceduleddelete_POST()
 * - upload_bulk_image()
 * - save_filter_post()
 * - get_google_access_token_GET()
 * Classes list:
 * - Users extends REST_Controller
 */
//
defined('BASEPATH') or exit('No direct script access allowed');

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
class Usersrest extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('Publisher_model');
	}
	public function updateprofile_POST()
	{
		$this->sessioncheck();
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('ph', 'Phone Number', 'trim|required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('gmt', 'Time Zone', 'required');
		if ($this->form_validation->run()) {
			$userID = App::Session()->get('userid');
			$update_data['fname'] = $this->post('fname');
			$update_data['lname'] = $this->post('lname');
			$update_data['email'] = $this->post('email');
			$update_data['ph'] = $this->post('ph');
			$update_data['fbprofile'] = $this->post('fbprofile');
			$update_data['fbpage'] = $this->post('fbpage');
			$update_data['gmt'] = $this->post('gmt');
			$result = $this->Publisher_model->update_record('user', $update_data, $userID);

			App::Session()->set('fullname', $update_data['fname'] . ' ' . $update_data['lname']);
			App::Session()->set('phone', $update_data['ph']);
			App::Session()->set('gmt', $update_data['gmt']);

			$this->response(['status' => true, 'message' => "Profile information has been updated successfully",], REST_Controller::HTTP_OK);
		} else {
			$errors = validation_errors();
			$this->response(['status' => false, 'message' => $errors,], REST_Controller::HTTP_OK);
		}
	}
	//Update /Add Evetns
	public function addnewevent_POST()
	{
		limit_check(GROUP_POSTING_ID);
		$this->form_validation->set_rules('name', 'Event Name', 'trim|required|min_length[3]|max_length[30]');
		$event_day = $this->post('event_day');
		if ($event_day == "alldays") {
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		}
		$this->form_validation->set_rules('page_id', 'Page', 'required');
		if ($this->form_validation->run()) {
			$data["name"] = $this->post('name');
			$data["time_slots"] = json_encode($this->post('time_slots'));
			$data["start_date"] = $this->post('start_date');
			$data["end_date"] = $this->post('end_date');
			$data["page_id"] = $this->post('page_id');
			$data["event_day"] = $this->post('event_day');
			$data["repeating"] = $this->post('repeating');
			$data["user_id"] = App::Session()->get('userid');
			$event_id = $this->Publisher_model->create_record('events', $data);
			if ($event_id) {
				resources_update('up', GROUP_POSTING_ID);
				$this->response(['status' => true, 'message' => "New event has been added successfully", 'id' => $event_id], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
				//Set the response and exit
				$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		} else {
			$errors = validation_errors();
			$this->response(['status' => false, 'message' => $errors,], REST_Controller::HTTP_OK);
		}
	}

	public function updateevent_POST()
	{
		$this->form_validation->set_rules('name', 'Event Name', 'trim|required|min_length[3]|max_length[30]');
		//$this->form_validation->set_rules('time_slots', 'Schedule Time', 'trim|required');
		$event_day = $this->post('event_day');
		if ($event_day == "alldays") {
			$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

			// For Future use already schedule posts time change //
			/*$timeslots = implode(",", $this->post('time_slots'));

																																																																																																																																																																																																																																																																																																																																																		 $this->db->select('*')->from('bulkupload')->where('page_id',$this->post('page_id'))->where('event_id',$this->post('id'))->where('user_id',App::Session()->get('userid'))->where('post_datetime > NOW()');
																																																																																																																																																																																																																																																																																																																																																		 $schedule_posts = $this->db->get()->result();

																																																																																																																																																																																																																																																																																																																																																		 $for_update = array('get_first_slot' => true, 'get_next_slot' => '');

																																																																																																																																																																																																																																																																																																																																																		 foreach($schedule_posts as $posts){
																																																																																																																																																																																																																																																																																																																																																			 $primary_id = $posts->id;
																																																																																																																																																																																																																																																																																																																																																			 $userID = $posts->user_id;
																																																																																																																																																																																																																																																																																																																																																			 $post_date_time = $this->getEventNextPostTime("bulkupload", App::Session()->get('userid'), $this->post('page_id'), $timeslots, $this->post('id'), $for_update);

																																																																																																																																																																																																																																																																																																																																																			 $for_update['get_first_slot'] = false;
																																																																																																																																																																																																																																																																																																																																																			 $for_update['get_next_slot'] = $post_date_time;
																																																																																																																																																																																																																																																																																																																																																			 
																																																																																																																																																																																																																																																																																																																																																			 $this->Publisher_model->updateBulkSchedule($primary_id, $post_date_time);
																																																																																																																																																																																																																																																																																																																																																		 }*/
		}

		$this->form_validation->set_rules('page_id', 'Page', 'required');
		$this->form_validation->set_rules('id', 'Event ID', 'required');
		if ($this->form_validation->run()) {
			$data["name"] = $this->post('name');
			$data["time_slots"] = json_encode($this->post('time_slots'));
			$data["start_date"] = $this->post('start_date');
			$data["end_date"] = $this->post('end_date');
			$data["page_id"] = $this->post('page_id');
			$data["repeating"] = $this->post('repeating');
			$data["event_day"] = $this->post('event_day');

			$id = $this->post('id');
			$where[0]['key'] = 'user_id';
			$where[0]['value'] = App::Session()->get('userid');
			$where[1]['key'] = 'page_id';
			$where[1]['value'] = $data["page_id"];
			$haveit = $this->Publisher_model->retrieve_record('events', $id, $where);
			if ($haveit) {
				$result = $this->Publisher_model->update_record('events', $data, $id);
				$this->response(['status' => true, 'message' => 'Event has been updated successfully', 'data' => $result], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		} else {
			$errors = validation_errors();
			$this->response(['status' => false, 'message' => $errors,], REST_Controller::HTTP_OK);
		}
	}

	public function cancelmembership_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$membership_id = App::Session()->get('membership_id');
		$mid = $this->post('membership');
		$update_data['membership_id'] = 0;
		$update_data['mem_expire'] = NULL;
		$result = $this->Publisher_model->update_record('user', $update_data, $userID);
		if ($result) {

			App::Session()->set('membership_id', 0);
			App::Session()->set('mem_expire', NULL);
			$this->response(['status' => true, 'message' => "your membership has been terminated successfully",], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => "Something went wrong",], REST_Controller::HTTP_OK);
		}
	}
	public function sessioncheck()
	{

		if (!$this->Publisher_model->check_logged()) {
			redirect(SITEURL);
		}
	}
	public function ownerdashboardwidgets_GET()
	{
		$this->sessioncheck();
		$is_logged_in = App::Session()->get('userid');
		if (!isset($is_logged_in) || $is_logged_in != true) {
			redirect(SITEURL);
		}
		$userID = App::Session()->get('userid');
		$username = App::Session()->get('MMP_username');
		$phone = App::Session()->get('phone');
		$name = App::Session()->get('fullname');
		$email = App::Session()->get('email');
		$avatar = App::Session()->get('avatar');
		$data['name'] = $name;
		$data['phone'] = $phone;
		$data['email'] = $email;
		$data['avatar'] = $avatar;
		$data['widgets'] = $this->Publisher_model->owner_dashboard();
		$this->response(array(
			'status' => true,
			'Message' => 'data found',
			'data' => $data,
		), REST_Controller::HTTP_OK);
	}

	public function dashboardwidgets_GET()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$username = App::Session()->get('MMP_username');
		$phone = App::Session()->get('phone');
		$name = App::Session()->get('fullname');
		$email = App::Session()->get('email');
		$avatar = App::Session()->get('avatar');
		$data['name'] = $name;
		$data['phone'] = $phone;
		$data['email'] = $email;
		$data['avatar'] = $avatar;
		if ($this->Publisher_model->get_acm($userID)) {

			$acmrow = $this->Publisher_model->get_acm($userID);
			$data['acm'] = $acmrow;
		}
		$widgets = $this->Publisher_model->dashboard_widget($username);
		$data['widgets'] = $widgets;
		//$data['campaign_click_earn'] = $this->Publisher_model->campaign_click_earn($username);
		$this->response(array(
			'status' => true,
			'Message' => 'data found',
			'data' => $data,
		), REST_Controller::HTTP_OK);
	}
	public function redirectlink_POST()
	{
		$this->sessioncheck();
		$id = App::Session()->get('userid');
		$value = $this->post('value');
		$result = $this->Publisher_model->update_record('user', array(
			'direct_link' => $value
		), $id);
		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	##########
	public function updateCampaign_post()
	{

		$this->sessioncheck();
		$id = $this->post('id');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$link = $this->Publisher_model->retrieve_record('link', $id, $where);

		if ($link) {
			$type = $link->c_type;
			if ($type == 1) {
				$data['text'] = addslashes($this->post('cpname'));
				$data['caption'] = $this->post('cpname');
				$data['description'] = $this->post('cpname');
				$data['img'] = $this->post('cpimg');
				$data['site_us_pc'] = $this->post('cpuspc');
				$data['status'] = $this->post('cpstatus');
				$data['categury'] = $this->post('cpcat');
				$data['star'] = $this->post('star');
				$result = $this->Publisher_model->update_record('link', $data, $id);
				$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

			}
			if ($type == 2) {

				$data['text'] = addslashes($this->post('cpname'));
				$data['caption'] = $this->post('cpname');
				$data['description'] = $this->post('cpname');

				$pattern = '~[a-z]+://\S+~';
				$found = preg_match_all($pattern, $data['text'], $match);
				$data['site_us_pc'] = $match[0][0];
				$parse = parse_url($data['site_us_pc']);
				$data['domain'] = $parse['host'];

				$data['status'] = $this->post('cpstatus');
				$data['categury'] = $this->post('cpcat');
				$data['star'] = $this->post('star');
				$delete_path = "";
				$linkedimg = basename($link->img);
				if ($_FILES['photo']['size'] > 0) {
					if ("::1" == $_SERVER['REMOTE_ADDR']) {
						$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $linkedimg;
					} else {
						$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $linkedimg;
					}
					if ($this->upload_bulk_image('photo')) {
						$upload_data = $this->upload->data();
						$data['img'] = SITEURL . "assets/bulkuploads/" . $upload_data['file_name'];
					}
				}

				$result = $this->Publisher_model->update_record('link', $data, $id);
				if ($delete_path) {
					unlink($delete_path);
				}
				$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

			}
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function addCampaign_post()
	{
		$this->sessioncheck();
		$type = $this->post('c_type');
		if ($type == 1) {
			$data = [];
			$data['text'] = addslashes($this->post('cpname'));
			$data['caption'] = $this->post('cpname');
			$data['c_type'] = 1;
			$data['description'] = $this->post('cpname');
			$data['img'] = $this->post('cpimg');
			$data['site_us_pc'] = $this->post('cpuspc');
			$parse = parse_url($data['site_us_pc']);
			$data['domain'] = $parse['host'];
			$data['status'] = $this->post('cpstatus');
			$data['categury'] = $this->post('cpcat');
			$data['user_id'] = $this->post('user_id');
			$data['star'] = $this->post('star');
			$link = $this->Publisher_model->create_record('link', $data);
			if ($link) {
				$this->response(['status' => true, 'message' => $link], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
				//Set the response and exit
				$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

			}
		} else if ($type == 2) {
			$data = [];
			$data['text'] = addslashes($this->post('cpname'));
			$data['caption'] = $this->post('cpname');
			$data['description'] = $this->post('cpname');
			$pattern = '~[a-z]+://\S+~';
			$found = preg_match_all($pattern, $data['text'], $match);
			$data['site_us_pc'] = $match[0][0];
			$parse = parse_url($data['site_us_pc']);
			$data['domain'] = $parse['host'];
			$data['c_type'] = 2;
			$data['status'] = $this->post('cpstatus');
			$data['categury'] = $this->post('cpcat');
			$data['user_id'] = $this->post('user_id');
			$data['star'] = $this->post('star');
			if ($this->upload_bulk_image('photo')) {
				$upload_data = $this->upload->data();
				$data['img'] = SITEURL . "assets/bulkuploads/" . $upload_data['file_name'];
			}
			$link = $this->Publisher_model->create_record('link', $data);
			if ($link) {
				$this->response(['status' => true, 'message' => $link], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
				//Set the response and exit
				$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
	}
	public function deleteCampaign_post()
	{

		$this->sessioncheck();
		$id = $this->post('id');
		$delete_views = $this->post('delete_views');
		$delete_schedule = $this->post('delete_schedule');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$link = $this->Publisher_model->retrieve_record('link', $id, $where);
		if ($link) {
			//he is the owner he can delete
			$multiple = $this->Publisher_model->delete_multiple('link_rates', 'f_id', $id);
			if ($delete_views == "true") {
				$multiple = $this->Publisher_model->delete_multiple('clicksbackup', 'cpid', $id);
				$multiple = $this->Publisher_model->delete_multiple('click', 'cpid', $id);
				$multiple = $this->Publisher_model->delete_multiple('revenue', 'campaign_id', $id);
			}
			if ($delete_schedule == "true") {
				$multiple = $this->Publisher_model->delete_multiple('sceduler', 'post_id', $id);
			}
			$result = $this->Publisher_model->delete_record('link', $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateanalyticsdomainedelete_post()
	{
		$this->sessioncheck();
		$id = $this->post('id');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$where[1]['key'] = 'id';
		$where[1]['value'] = $id;
		$articledomain = $this->Publisher_model->retrieve_record('articledomains', $id, $where);
		if ($articledomain) {
			$result = $this->Publisher_model->delete_record('articledomains', $id);
			$multiple = $this->Publisher_model->delete_multiple('domain_rates', 'f_id', $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateanalyticsdomainedit_post()
	{

		$this->sessioncheck();
		$id = $this->post('id');

		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$where[1]['key'] = 'id';
		$where[1]['value'] = $id;
		$articledomain = $this->Publisher_model->retrieve_record('articledomains', $id, $where);

		if ($articledomain) {
			$data['domain'] = $this->post('domain');
			$data['status'] = $this->post('status');
			$data['property_id'] = $this->post('property');
			$data['rates_priority'] = $this->post('rates_priority');
			$result = $this->Publisher_model->update_record('articledomains', $data, $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateanalyticsdomainadd_post()
	{

		$this->sessioncheck();
		$data = [];
		$data['domain'] = $this->post('domain');
		$data['status'] = $this->post('status');
		$data['property_id'] = $this->post('property');
		$data['user_id'] = App::Session()->get('userid');
		$result = $this->Publisher_model->create_record('articledomains', $data);

		if ($result) {
			$this->response(['status' => True, 'message' => 'record created'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateredirectdomainedelete_post()
	{

		$this->sessioncheck();
		$id = $this->post('id');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$where[1]['key'] = 'id';
		$where[1]['value'] = $id;
		$articledomain = $this->Publisher_model->retrieve_record('domains', $id, $where);
		if ($articledomain) {
			$result = $this->Publisher_model->delete_record('domains', $id);
			$multiple = $this->Publisher_model->delete_multiple('user_domains', 'domain_id', $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateredirectdomainedit_post()
	{
		$this->sessioncheck();
		$id = $this->post('id');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$where[1]['key'] = 'id';
		$where[1]['value'] = $id;
		$articledomain = $this->Publisher_model->retrieve_record('domains', $id, $where);
		if ($articledomain) {
			$data['domain'] = $this->post('domain');
			$data['status'] = $this->post('status');
			$result = $this->Publisher_model->update_record('domains', $data, $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateredirectdomainadd_post()
	{

		$this->sessioncheck();
		$data = [];
		$data['domain'] = $this->post('domain');
		$data['status'] = $this->post('status');
		$data['user_id'] = App::Session()->get('userid');
		$result = $this->Publisher_model->create_record('domains', $data);
		if ($result) {
			$this->response(['status' => True, 'message' => 'record created'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function updateaffiliate_post()
	{

		$this->sessioncheck();
		$id = trim($this->post('user_id'));
		$datauser['status'] = trim($this->post('status'));
		if ($datauser['status'] == "approve") {
			$active = 'y';
		} else {
			$active = 'n';
		}
		$where[0]['key'] = 'team_id';
		$where[0]['value'] = App::Session()->get('team_id');
		$user = $this->Publisher_model->retrieve_record('user', $id, $where);
		if ($user) {
			$result = $this->Publisher_model->update_record('user', array(
				'active' => $active
			), $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}


	public function affiliatepay_post()
	{

		$this->sessioncheck();
		$id = $this->post('id');
		$where[0]['key'] = 'team_id';
		$where[0]['value'] = App::Session()->get('team_id');
		$user = $this->Publisher_model->retrieve_record('user', $id, $where);
		if ($user) {

			$amount = $this->post('amount');
			$paid_amu = $this->db->query("Select paid_amu from user where id=" . $id)->row()->paid_amu;
			$total_paid = $amount;
			if ($paid_amu > 0) {
				$total_paid = round($amount + $paid_amu, 2);
			}
			$result = $this->Publisher_model->update_record('user', array(
				'paid_amu' => $total_paid
			), $id);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function deleteaffiliate_post()
	{
		$this->sessioncheck();
		$id = $this->post('id');
		$where[0]['key'] = 'team_id';
		$where[0]['value'] = App::Session()->get('team_id');
		$user = $this->Publisher_model->retrieve_record('user', $id, $where);
		if ($user) {
			$result = $this->Publisher_model->delete_record('user', $id);
			$multiple = $this->Publisher_model->delete_multiple('user_domains', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('acm_users', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('facebook_pages', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('bulkupload', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('sceduler', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('rsssceduler', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('tempclick', 'user', $user->username);
			$multiple = $this->Publisher_model->delete_multiple('recomendation', 'userid', $id);
			$multiple = $this->Publisher_model->delete_multiple('menu_assign', 'user', $id);
			$multiple = $this->Publisher_model->delete_multiple('user_rates', 'f_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('user_domains', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('user_cdomains', 'user_id', $id);
			$multiple = $this->Publisher_model->delete_multiple('recomendation', 'userid', $id);
			//Limit updating
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function editaffiliate_post()
	{
		$userid = $this->post('userId');
		$fname = $this->post('fname');
		$lname = $this->post('lname');
		$username = $this->post('username');
		$email = $this->post('email');

		$this->db->select('*')->from('user')->where('id', $userid);
		$user = $this->db->get()->result_array();
		if ($user) {
			$data['fname'] = $fname;
			$data['lname'] = $lname;
			$data['username'] = $username;
			$data['email'] = $email;
			$result = $this->Publisher_model->update_record('user', $data, $userid);
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function updateGenrates_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('res_id'));
		$value = trim($this->post('value'));

		$table = $this->input->post('identifier');

		$result = $this->Publisher_model->update_record($table, array(
			'rates_priority' => $value
		), $id);
		if ($result) {

			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function userSalary_get()
	{
		$user = $this->input->get('username');
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$sql = "SELECT round(sum(earn),2) as earning FROM `clicksbackup` WHERE date >= '" . $start . "' AND date <= '" . $end . "' AND user = '" . $user . "'";
		$query = $this->db->query($sql);
		$newone = $query->result_array();
		$this->response(['status' => true, 'data' => $newone[0]], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

	}
	public function getGenratesowner_get()
	{
		$this->sessioncheck();
		$id = App::Session()->get('team_id');
		$table = "team_rates";
		$exists = $this->Publisher_model->list_records($table, 0, 1000, array(
			'key' => 'f_id',
			'value' => $id
		), 'id', 'DESC');
		if ($exists) {
			$sql = "SELECT c.id, c.code, c.name,u.rate  FROM `country` as c LEFT JOIN $table as u  on c.id = u.c_id WHERE u.f_id = " . $id;
			$query = $this->db->query($sql);
			$newone = $query->result_array();
		} else {
			$newone = $this->Publisher_model->list_records('country', 0, 1000);
		}

		$this->response(['status' => true, 'data' => $newone], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code



	}
	public function getGenrates_get()
	{
		$this->sessioncheck();
		$id = $this->input->get('res_id');
		$table = $this->input->get('identifier') . "_rates";
		$exists = $this->Publisher_model->list_records($table, 0, 1000, array(
			'key' => 'f_id',
			'value' => $id
		), 'id', 'DESC');
		if ($exists) {
			$sql = "SELECT c.id, c.code, c.name,u.rate  FROM `country` as c LEFT JOIN $table as u  on c.id = u.c_id WHERE u.f_id = " . $id;
			$query = $this->db->query($sql);
			$newone = $query->result_array();
		} else {

			$id = App::Session()->get('team_id');
			$sql = "SELECT c.id, c.code, c.name,u.rate  FROM `country` as c LEFT JOIN team_rates as u  on c.id = u.c_id WHERE u.f_id = " . $id;
			$query = $this->db->query($sql);
			$newone = $query->result_array();
			/*$newone = $this->Publisher_model->list_records('country', 0, 1000);*/
		}

		$this->response(['status' => true, 'data' => $newone], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

	}

	public function setUpdateGenrates_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('res_id'));
		$table = $this->input->post('identifier') . "_rates";
		$rates = $this->post('rates');
		$rates = json_decode($rates);
		$exists = $this->Publisher_model->list_records($table, 0, 1000, array(
			'key' => 'f_id',
			'value' => $id
		), 'id', 'DESC');
		if ($exists) {

			foreach ($rates as $key => $val) {

				$where_user_rate[0]['key'] = "f_id";
				$where_user_rate[0]['value'] = $id;
				$where_user_rate[1]['key'] = "c_id";
				$where_user_rate[1]['value'] = $val->id;
				$update = $this->Publisher_model->update_record_mc($table, array(
					'rate' => $val->value
				), $where_user_rate);
			}
		} else {
			foreach ($rates as $key => $val) {
				$data_user_rate['f_id'] = $id;
				$data_user_rate['c_id'] = $val->id;
				$data_user_rate['rate'] = $val->value;
				$created_result = $this->Publisher_model->create_record($table, $data_user_rate);
			}
		}

		$this->response(['status' => true, 'data' => "Success"], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

	}
	public function setUpdateAdvDomains_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('res_id'));
		$table = "user_cdomains";
		$domains = $this->post('domains');
		$domains = json_decode($domains);
		foreach ($domains as $key => $val) {

			$where[0]['key'] = 'user_id';
			$where[0]['value'] = $id;
			$where[1]['key'] = 'domain_id';
			$where[1]['value'] = $val->id;
			$exists = $this->Publisher_model->list_records($table, 0, 1, $where, 'id', 'DESC');
			if ($exists) {

				$update = $this->Publisher_model->update_record_mc(
					$table,
					array(
						'status' => $val->value
					),
					$where
				);
			} else {
				$data_domain['user_id'] = $id;
				$data_domain['domain_id'] = $val->id;
				$data_domain['status'] = $val->value;
				$created_result = $this->Publisher_model->create_record($table, $data_domain);
			}
		}
		$this->response(['status' => true, 'data' => "Success"], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

	}
	public function updateGenassignAdv_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('res_id'));
		$value = trim($this->post('value'));
		$table = $this->input->post('identifier');

		$result = $this->Publisher_model->update_record($table, array(
			'adv_priority' => $value
		), $id);
		if ($result) {

			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function affiliateownertrafficsummary_GET()
	{
		$this->sessioncheck();
		$team_id = App::Session()->get('team_id');
		$top_users_data = $this->Publisher_model->affiliateownertrafficsummary($team_id, $this->get('start'), $this->get('end'));
		if ($top_users_data !== false) {
			if (count($top_users_data) > 0) {

				$this->response(array(
					'status' => true,
					'data' => $top_users_data,
				), REST_Controller::HTTP_OK);
			} else {
				$this->response(array(
					'status' => true,
					'data' => [],
				), REST_Controller::HTTP_OK);
			}
		} else {
			$this->response(array(
				'status' => false,
				'data' => [],
			), REST_Controller::HTTP_OK);
		}
	}

	public function affiliatecampaigntrafficsummary_POST()
	{
		$this->sessioncheck();
		$start = $this->post('start_date');
		$end = $this->post('end_date');
		$username = $this->post('username');
		$data = $this->Publisher_model->owner_show_table($start, $end, $username);
		if ($data) {
			$return_data['status'] = true;
			$return_data['data'] = $data;
		} else {
			$return_data['status'] = 'false';
			$return_data['data'] = [];
		}

		$this->response($return_data, REST_Controller::HTTP_OK);
	}

	public function affiliatecountrytrafficsummary_POST()
	{
		$this->sessioncheck();
		$start = $this->post('start');
		$end = $this->post('end');
		$username = $this->post('username');
		$range_data = [
			'start' => $start,
			'end' => $end,
			'username' => $username,
		];
		$data = $this->Publisher_model->getcountrywise($range_data);
		if (!empty($data)) {
			$return_data['status'] = true;
			$return_data['data'] = $data;
		} else {
			$return_data['status'] = false;
			$return_data['data'] = [];
		}

		$this->response($return_data, REST_Controller::HTTP_OK);
	}

	public function affiliateindividualcountrytrafficsummary_GET()
	{
		$this->sessioncheck();
		$data = $this->Publisher_model->owner_specific_country_click($this->get('cpid'), $this->get('username'), $this->get('start_date'), $this->get('end_date'));
		$return_data = [];
		$card_data = '';
		if ($data) {
			$card_data .= '<table width="100%" class="table v-middle">
			<thead>
			  <tr> <th> Flag </th> <th> Country </th> <th> Clicks </th> <th> Earning </th> </tr>
		   </thead>';
			foreach ($data as $row) {

				$card_data .= '<tr> <td> <img src="assets/general/flags/' . $row['code'] . '.png ">
			</td>
				<td> ' . $row['country'] . '</td>' . '<td>' . cnf($row['click'], 2) . '</td>
				<td>' . round($row['earn'], 3) . '</td>
			</tr>';
			}
			$card_data .= '</table>';
			$return_data['status'] = true;
			$return_data['card_content'] = $card_data;
		} else {
			$return_data['status'] = false;
			$return_data['card_content'] = '<p> Please Try Again </p>';
		}

		$this->response($return_data, REST_Controller::HTTP_OK);
	}
	public function campaignwise_POST()
	{
		$this->sessioncheck();
		$start = $this->post('start_date');
		$end = $this->post('end_date');
		$username = $this->post('username');
		$data = $this->Publisher_model->show_table($start, $end, $username);
		if ($data) {
			$return_data['status'] = true;
			$return_data['data'] = $data;
		} else {
			$return_data['status'] = false;
			$return_data['data'] = '<p> No data found </p>';
		}

		$this->response($return_data, REST_Controller::HTTP_OK);
	}
	public function specific_country_click_GET()
	{

		$this->sessioncheck();
		$data = $this->Publisher_model->specific_country_click($this->get('cpid'), $this->get('username'), $this->get('start_date'), $this->get('end_date'));

		$return_data = [];
		$card_data = '';
		if ($data) {
			$card_data .= '<table width="100%" class="table v-middle">
			<thead>
			  <tr> <th> Flag </th> <th> Country </th> <th> Clicks </th> <th> Earning </th> </tr>
		   </thead>';
			foreach ($data as $row) {

				$card_data .= '<tr> <td> <img src="assets/general/flags/' . $row['code'] . '.png ">
			</td>
				<td> ' . $row['country'] . '</td>' . '<td>' . cnf($row['click'], 2) . '</td>
				<td>' . round($row['earn'], 3) . '</td>
			</tr>';
			}
			$card_data .= '</table>';
			$return_data['status'] = true;
			$return_data['card_content'] = $card_data;
		} else {
			$return_data['status'] = false;
			$return_data['card_content'] = '<p> Please Try Again </p>';
		}

		$this->response($return_data, REST_Controller::HTTP_OK);
	}
	public function getAdvDomains_get()
	{
		$this->sessioncheck();
		$id = $this->input->get('res_id');
		$userID = App::Session()->get('userid');

		$where_e[0]['key'] = 'user_id';
		$where_e[0]['value'] = $userID;
		$where_e[1]['key'] = 'status';
		$where_e[1]['value'] = 'active';
		$all_domains = $this->Publisher_model->list_records('articledomains', 0, 10000, $where_e);

		$table = "user_cdomains";
		$exists = $this->Publisher_model->list_records($table, 0, 1000, array(
			'key' => 'user_id',
			'value' => $id
		), 'id', 'DESC');

		foreach ($all_domains as $key => $value) {
			if ($exists) {
				foreach ($exists as $index => $row) {
					if ($row->domain_id == $value->id) {
						$all_domains[$key]->status = $row->status;
					}
				}
			} else {
				$all_domains[$key]->status = "inactive";
			}
		}




		//	print_r($all_domains);
		//	die();
		$this->response(['status' => true, 'data' => $all_domains], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}

	##########
	public function changedomain_post()
	{
		$this->sessioncheck();
		$id = App::Session()->get('userid');
		$domain_id = $this->post('domain_id');
		$result = $this->Publisher_model->update_record('user', array(
			'domain' => $domain_id
		), $id);
		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function dashboardforProfile_GET()
	{
		$this->sessioncheck();
		$userID = $this->input->get('profile');

		$pulisher = $this->Publisher_model->retrieve_record('user', $userID);

		$data['publisher'] = $pulisher;

		$widgets = $this->Publisher_model->dashboard_widget($pulisher->username, $userID);
		$data['widgets'] = $widgets;
		$data['campaign_click_earn'] = $this->Publisher_model->campaign_click_earn($pulisher->username);
		$this->response(array(
			'status' => true,
			'Message' => 'data found',
			'data' => $data,
		), REST_Controller::HTTP_OK);
	}

	public function loadFacebookPages_POST()
	{
		$this->sessioncheck();
		$this->load->library('facebook');
		$userID = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$this->facebook->user_setDefaultAccessToken($user->facebook_permanent_token);
		$pages = $this->facebook->request('get', '/me/accounts?type=page&limit=1&fields=id,name,access_token');

		$page = $pages['data'][0];

		$page_data['page_id'] = $page['id'];
		$page_data['page_name'] = $page['name'];
		$page_data['access_token'] = $page['access_token'];
		$data_all_pages = [];

		array_push($data_all_pages, $page_data);

		if (isset($pages['paging']['next'])) {

			$data_al = $this->recusriveCall($data_all_pages, $pages['paging']['next']);
			$data_all_pages = array_merge($data_all_pages, $data_al);
		}

		//print_r($data_all_pages);
		die();

		$this->response(array(
			'status' => true,
			'data' => $page_data,
		), REST_Controller::HTTP_OK);
	}

	public function recusriveCall($data_all, $next)
	{
		$this->sessioncheck();
		$contents = file_get_contents($next);
		$page_org = json_decode($contents, true);
		print_r($page_org);

		$page = $page_org['data'][0];
		$page_data['page_id'] = $page['id'];
		$page_data['page_name'] = $page['name'];
		$page_data['access_token'] = $page['access_token'];
		$result = [];
		$result = array_merge($result, $data_all);

		array_push($result, $page_data);
		if (isset($page_org['paging']['next'])) {
			$this->recusriveCall($result, $page_org['paging']['next']);
		} else {

			// print_r($result);
			//    die();
			//    return $result;

		}
	}
	public function gmt_status_GET()
	{
		$this->sessioncheck();
		$gmt = $this->get('gmt');
		$user_id = $this->get('id');
		$gmt_db = $this->Publisher_model->get_gmt_status($gmt, $user_id);
		if ($gmt_db == $gmt) {
			$this->response(array(
				'status' => true,

			), REST_Controller::HTTP_OK);
		} else if ($gmt_db != $gmt) {
			$this->response(array(
				'status' => false,
				'Message' => 'Your Gmt is not according to our record',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => '',
				'Message' => 'Problem occured in fetching gmt'

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function change_announce_view_GET()
	{

		$this->sessioncheck();
		$pub_id = $this->get('pub_id');
		$announce_id = $this->get('announce_id');
		if ($pub_id == '' || $announce_id == '') {
			$this->response(array(
				'status' => false,
				'Message' => 'Problem Occured'
			), REST_Controller::HTTP_NOT_FOUND);
		}
		if ($this->Publisher_model->change_announcement_seen($announce_id, $pub_id)) {
			$this->response(array(
				'status' => true,
				'Message' => 'Status Changed'
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'Message' => 'Status Changed'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function metaOfUrl_POST($request_url = null)
	{
		$this->sessioncheck();
		if ($this->post('url')) {
			$request_url = $this->post('url');
		}
		// $request_url = @$this->post('url');
		$amazon = preg_match("/(^(https?:\/\/(?:www\.)?|(?:www\.))?|\s(https?:\/\/(?:www\.)?|(?:www\.))?)amazon\.com/", $request_url);
		$entityReplacements = array(
			"&#039;" => "'",
			"&#8211;" => "-",
			"&#8212;" => "--",
		);
		if ($amazon) {
			$this->load->library('amazon');
			$info = $this->amazon->get_info($request_url);
			$response['title'] = str_replace(array_keys($entityReplacements), array_values($entityReplacements), $info['title']);
			$response['image'] = $info['image'];
			$response['status'] = true;
		}
		if ($request_url != '') {
			$this->load->library('getMetaInfo');
			$info = $this->getmetainfo->get_info($request_url);
			$response['title'] = str_replace(array_keys($entityReplacements), array_values($entityReplacements), $info['title']);
			$response['image'] = $info['image'];
			$response['status'] = true;
		} else {
			$response['title'] = '';
			$response['image'] = '';
			$response['status'] = false;
		}
		if ($this->post('url')) {
			// $encoded_response = json_encode($response);
			$this->response(array(
				'status' => $response['status'],
				'data' => $response,
				'message' => "Title and Image fetched successfully",
			), REST_Controller::HTTP_OK);
		}
		return $response;
	}

	public function metaOfUrlt($request_url)
	{
		$response['image'] = '';
		$response['status'] = false;

		if (!empty($request_url)) {
			$this->load->library('getMetaInfo');
			$info = $this->getmetainfo->get_info($request_url);

			if (!empty($info['image'])) {
				$response['image'] = $info['image'];
				$response['status'] = true;
			}
			// Do not set status and image when cURL error occurs
		}
		return $response;
	}

	public function create_instagram_bulkupload_POST()
	{
		$this->sessioncheck();
		$title = $this->post('title');
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$type = $this->post('type');
		$totalfiles = $this->post('totalfiles');
		$current_file = $this->post('current_file');
		$userID = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$timeslots = $this->post('timeslots');
		$time_slots_arr = explode(",", $timeslots);
		$time_slots_size = count($time_slots_arr);
		$last_time_slot_element = $time_slots_arr[$time_slots_size - 1];

		$last_scedule = $this->db->query("SELECT post_datetime FROM igbulkupload WHERE post_type = '" . $type . "' AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
		$lastpostscheduled_already = "";
		if (count($last_scedule->result()) > 0) {

			$lastpostscheduled_already = @$last_scedule->row()->post_datetime;
		}

		$next_post_DT = "";

		$lastpostscheduled_local = localToUTC(date("Y-m-d H:i:s"), SERVER_TZ, "Y-m-d  H:i:s");

		$lastpostscheduled_local = utcToLocal($lastpostscheduled_local, $user->gmt, "Y-m-d  H:i:s");
		//if page has some sceduled posts
		if ($lastpostscheduled_already) {
			//check if already scheduled posts are in future or in backdates
			if ($lastpostscheduled_already < $lastpostscheduled_local) {

				$next_post_DT = $lastpostscheduled_local;
			} else {

				$next_post_DT = $lastpostscheduled_already;
			}
		} else {

			//There is no posts sceduled already for this page so far start from scratch
			$next_post_DT = $lastpostscheduled_local;
		}

		$next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
		$date_for_dt = strtotime($next_post_DT);
		$last_date = date('Y-m-d', $date_for_dt);
		$last_hour = date('H', $date_for_dt);
		//Check if the last time slot comes in today or its passed, if passed date posting will be next day
		if ($last_hour >= $last_time_slot_element) {
			$last_date = date('Y-m-d', strtotime($next_post_DT . ' +1 day'));
			//time will be the first time slot of the next day;
			$next_hour = $time_slots_arr[0];
		} else {

			//Find next hour from array based on last_hour
			foreach ($time_slots_arr as $val) {
				if ($val > $last_hour) {
					$next_hour = $val;
					break;
				}
			}
		}

		$next_post_date_time = $last_date . " " . $next_hour . ":00";
		$next_post_date_time = localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");

		if ($this->upload_bulk_image('file')) {

			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
			$img_path = $file_name;
			$this_id = $this->Publisher_model->post_igbulkschedule($userID, $type, $title, $img_path, $next_post_date_time);
			if ($this_id) {
				$new_result = [];
				$new_result['id'] = $this_id;
				$new_result['title'] = ucwords(strtolower(stripslashes($title)));
				$new_result['link'] = $img_path;
				$new_result['post_date'] = utcToLocal($next_post_date_time, $user->gmt, "F j, Y, g:i a");
				$new_result['post_time'] = utcToLocal($next_post_date_time, $user->gmt, "H:i A");

				$this->response(array(
					'status' => true,
					'data' => $new_result,
					'message' => "File uploaded successfully",
				), REST_Controller::HTTP_OK);
			}
		}

		$this->response(array(
			'status' => false,
			'message' => 'Some Problem occured',

		), REST_Controller::HTTP_OK);
	}

	public function create_facebook_bulkupload_POST()
	{
		$this->sessioncheck();
		$title = $this->post('title');
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$page = $this->post('page');
		$event = $this->post('event');
		$totalfiles = $this->post('totalfiles');
		$current_file = $this->post('current_file');
		$userID = App::Session()->get('userid');
		$timeslots = $this->post('timeslots');
		$etimeslots = $this->post('etimeslots');
		$event_day = $this->post('event_day');
		if ($event > 0) {
			if ($event_day == "alldays") {
				$next_post_date_time = $this->getEventNextPostTime("bulkupload", $userID, $page, $etimeslots, $event);
			} else {
				$next_post_date_time = $this->getEventNextPostTimeWeekly("bulkupload", $userID, $page, $etimeslots, $event);
			}
			if (!$next_post_date_time) {
				$this->response(array(
					' status' => false,
					'message' => 'You have already scheduled upto the end date of event',
				), REST_Controller::HTTP_OK);
				exit;
			}
		} else {
			$next_post_date_time = getNextPostTime("bulkupload", $userID, $page, $timeslots);
		}
		$user = $this->Publisher_model->retrieve_record('user', $userID);
		if ($this->upload_bulk_image('file')) {
			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
			$img_path = $file_name;
			$this_id = $this->Publisher_model->post_bulkschedule($userID, $page, $title, $img_path, $next_post_date_time, $event);
			if ($this_id) {
				$new_result = [];
				$new_result['id'] = $this_id;
				$new_result['title'] = ucwords(strtolower(stripslashes($title)));
				$new_result['link'] = $img_path;
				$new_result['event_id'] = $event;
				$new_result['post_day'] = utcToLocal($next_post_date_time, $user->gmt, "l");
				$new_result['post_date'] = utcToLocal($next_post_date_time, $user->gmt, "d F, Y");
				$new_result['post_time'] = utcToLocal($next_post_date_time, $user->gmt, "g:i a");
				$this->response(array(
					'status' => true,
					'data' => $new_result,
					'message' => "File uploaded successfully",
				), REST_Controller::HTTP_OK);
			}
		}
		$this->response(array(
			'status' => false,
			'message' => 'too large or invalid files are not allowed',
		), REST_Controller::HTTP_OK);
	}

	public function update_facebook_bulkupoad_POST()
	{
		$this->sessioncheck();
		$id = $this->post('id');
		$title = $this->post('title');
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$event_id = $this->post('event_id');
		$params = ['post_title' => $title];
		$where = [
			'id' => $id,
			'event_id' => $event_id
		];
		$result = $this->Publisher_model->update_bulkupload('bulkupload', $params, $where);
		if ($result != '-1') {
			$post = $this->Publisher_model->retrieve_record('bulkupload', $id);
			$this->response(array(
				'status' => true,
				'data' => $post,
				'message' => "Image caption updated successfully",
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Unable to update Caption',
			), REST_Controller::HTTP_OK);
		}
	}

	public function getinstagrambulkscheduled_post()
	{
		$this->sessioncheck();
		$type = trim($this->post('type'));
		$user_id = App::Session()->get('userid');
		$where[0]['key'] = 'post_type';
		$where[0]['value'] = $type;
		$where[1]['key'] = 'user_id';
		$where[1]['value'] = $user_id;
		$result = $this->Publisher_model->list_records('igbulkupload', 0, 10000, $where, 'id', 'DESC');

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);

			foreach ($result as $key => $row) {

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = ucwords(strtolower(stripslashes($row->post_title)));
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "H:i A");
			}
			$this->response(['status' => true, 'data' => $new_result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}
	//
	public function gefacebooktbulkscheduled_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$event = trim($this->post('event_id'));
		$user_id = App::Session()->get('userid');
		if ($event) {
			$where_e[0]['key'] = 'page_id';
			$where_e[0]['value'] = $id;
			$where_e[1]['key'] = 'event_id';
			$where_e[1]['value'] = $event;
			$result = $this->Publisher_model->list_records('bulkupload', 0, 10000, $where_e, 'id', 'asc');
		} else {
			$where_e[0]['key'] = 'page_id';
			$where_e[0]['value'] = $id;
			$where_e[1]['key'] = 'event_id';
			$where_e[1]['value'] = 0;
			$result = $this->Publisher_model->list_records('bulkupload', 0, 10000, $where_e, 'id', 'asc');
		}


		$page = $this->Publisher_model->retrieve_record('facebook_pages', $id);
		$where_events[0]['key'] = 'page_id';
		$where_events[0]['value'] = $id;
		$where_events[1]['key'] = 'user_id';
		$where_events[1]['value'] = $user_id;
		$result_events = $this->Publisher_model->list_records('events', 0, 10000, $where_events, 'id', 'asc');
		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);

			foreach ($result as $key => $row) {

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = ucwords(strtolower(stripslashes($row->post_title)));
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['post_day'] = utcToLocal($row->post_datetime, $user->gmt, "l");
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "d F, Y");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "g:i a");
			}

			$this->response(['status' => true, 'data' => $new_result, 'caption' => $page->caption, 'events' => $result_events, 'time_slots' => $page->time_slots], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again', 'caption' => $page->caption, 'events' => $result_events, 'time_slots' => $page->time_slots], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}
	public function getrssscheduled_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		$where = [
			['key' => 'page_id', 'value' => $id],
			['key' => 'posted', 'value' => array(0, -1)],
			['key' => 'link', 'value' => 'cdn.shopify.com'],
			['key' => 'link', 'value' => 'youtube.com'],
		];
		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			$this->db->like($where[3]['key'], $where[3]['value']);
		}
		// result
		$result = $this->Publisher_model->list_records('rsssceduler', 0, 20, null, 'post_datetime', 'ASC');
		$where = [
			['key' => 'user_id', 'value' => $user_id],
			['key' => 'page_id', 'value' => $id],
			['key' => 'posted', 'value' => 0],
		];
		// total posts count
		$count = $this->Publisher_model->list_records('rsssceduler', 0, 10000, $where, 'post_datetime', 'ASC');
		// scheduled until
		$scheduled_until = $this->Publisher_model->list_records('rsssceduler', 0, 1, $where, 'post_datetime', 'DESC');
		$scheduled_until = count($scheduled_until) > 0 ? utcToLocal($scheduled_until[0]->post_datetime, $user->gmt, "F j, Y, g:i a") : '';
		$page = $this->Publisher_model->retrieve_record('facebook_pages', $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $page->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('rsssceduler')->where('page_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = count($query) > 0 ? $query[0]['created_at'] : '';

				$last_run = $last_run ? utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s") : '';
				// check for last run
				$fb_page = $this->Publisher_model->get_allrecords('facebook_pages', array('id' => $id));
				$page_row = $fb_page[0];
				if (!empty($page_row->last_run)) {
					$last_run = $page_row->last_run;
				}

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		// $this->db->select('*')->from('rsssceduler')->where('page_id', $id)->where('user_id', $user_id);
		// $this->db->like('link', 'cdn.shopify.com');
		// $this->db->order_by('id', 'DESC')->limit(1);
		// $query = $this->db->get()->result_array();
		// $last_shopify_run = $query[0]['created_at'];
		// if (empty($last_shopify_run)) {
		// 	$last_shopify_run = '';
		// } else {
		// 	$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
		// }
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->posted;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "H:i A");
			}
			$this->response(['status' => true, 'data' => $new_result, 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => $page->shopify_active, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run, 'count' => count($count), 'scheduled_until' => $scheduled_until], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again', 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => $page->shopify_active, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function load_more_posts_POST()
	{
		$this->sessioncheck();
		$user_id = App::Session()->get('userid');
		$id = trim($this->post('page_id'));
		$activedivid = $this->post('activedivid');
		$type = trim($this->post('type'));
		$offset = trim($this->post('offset'));
		$limit = trim($this->post('limit'));

		$table = $date_column = $sub_table = $page_column = $status_column = '';
		if ($type == 'facebook') {
			$table = 'rsssceduler';
			$date_column = 'post_datetime';
			$sub_table = 'facebook_pages';
			$page_column = 'page_id';
			$status_column = 'posted';
		} elseif ($type == 'pinterest') {
			$table = 'pinterest_scheduler';
			$date_column = 'publish_datetime';
			$sub_table = 'pinterest_boards';
			$page_column = 'board_id';
			$status_column = 'published';
		} elseif ($type == 'instagram') {
			$table = 'instagram_scheduler';
			$date_column = 'publish_datetime';
			$sub_table = 'instagram_users';
			$page_column = 'ig_id';
			$status_column = 'published';
		}

		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		$where = [
			['key' => $page_column, 'value' => $id],
			['key' => $status_column, 'value' => array(0, -1)],
			['key' => 'link', 'value' => 'cdn.shopify.com'],
			['key' => 'link', 'value' => 'youtube.com'],
		];
		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records($table, $offset, $limit, null, $date_column, 'ASC');
		$page = $this->Publisher_model->retrieve_record($sub_table, $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = $page->rss_link;
		}
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}
				$this->db->select('*')->from($table)->where($page_column, $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = $query[0]['created_at'];

				$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");
				// check for last run
				$fb_page = $this->Publisher_model->get_allrecords($sub_table, array('id' => $id));
				$page_row = $fb_page[0];
				if (!empty($page_row->last_run)) {
					$last_run = $page_row->last_run;
				}
				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}
		// For Shopify Last Run //
		$last_shopify_run = '';
		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$date_time = isset($row->post_datetime) ? $row->post_datetime : $row->publish_datetime;
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = isset($row->link) ? $row->link : $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = isset($row->posted) ? $row->posted : $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = isset($date_time) ? utcToLocal($date_time, $user->gmt, "F j, Y, g:i a") : $row->published;
				$new_result[$key]['post_time'] = isset($date_time) ? utcToLocal($date_time, $user->gmt, "H:i A") : $row->published;
			}
			$this->response(['status' => true, 'data' => $new_result, 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => $page->shopify_active, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run, 'count' => count($new_result)], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again', 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => $page->shopify_active, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function getrssspublished_post()
	{

		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'page_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'posted';
		// $where[1]['value'] = 0;
		$where[1]['value'] = array(1);

		$where[2]['key'] = 'link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('rsssceduler', 0, 10000, null, 'post_datetime', 'DESC');
		// $result = $this->Publisher_model->list_records('rsssceduler', 0, 10000, $where, 'post_datetime', 'ASC');

		$page = $this->Publisher_model->retrieve_record('facebook_pages', $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $page->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('rsssceduler')->where('page_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = count($query) > 0 ? $query[0]['created_at'] : '';

				$last_run = $last_run ? utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s") : '';
				// check for last run
				$fb_page = $this->Publisher_model->get_allrecords('facebook_pages', array('id' => $id));
				$page_row = $fb_page[0];
				if (!empty($page_row->last_run)) {
					$last_run = $page_row->last_run;
				}

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		// $this->db->select('*')->from('rsssceduler')->where('page_id', $id)->where('user_id', $user_id);
		// $this->db->like('link', 'cdn.shopify.com');
		// $this->db->order_by('id', 'DESC')->limit(1);
		// $query = $this->db->get()->result_array();
		// $last_shopify_run = $query[0]['created_at'];
		// if (empty($last_shopify_run)) {
		// 	$last_shopify_run = '';
		// } else {
		// 	$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
		// }
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->posted;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "H:i A");
			}
			$this->response(['status' => true, 'data' => $new_result, 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => $page->shopify_active, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again', 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => $page->shopify_active, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function rssfeedonoff_POST()
	{
		$this->sessioncheck();
		$page = $this->post('page');
		$page_data['rss_active'] = $this->post('rss_active');
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function shopify_fb_page_automation_onoff_POST()
	{
		$this->sessioncheck();
		$page = $this->post('page');
		$page_data['shopify_active'] = $this->post('shopify_active');
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function rss_feed_POST()
	{
		$this->sessioncheck();
		$user = get_auth_user();
		$userID = $user->id;
		$page = $this->post('page'); //this is getting primary id
		$timeslots = implode(",", $this->post('timeslots'));
		$rss_link = $this->post('rss_link');

		$if_shopify_fetch = $this->post('if_shopify_fetch'); // Means this function is for deleting rss_links
		if (!empty($if_shopify_fetch) && $if_shopify_fetch == 'yes') {

			$data_sopify = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$shopifyStore = $data_sopify[0]->shopify_storeName;
			$apiVersion = '2024-01';
			$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
			$accessToken = $data_sopify[0]->shopify_adminApiAccessToken;
			$headers = [
				'X-Shopify-Access-Token: ' . $accessToken,
			];
			$ch = curl_init($endpoint);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpCode === 200) {
				$result = json_decode($response, true);
			} else {
				$this->response(['status' => false, 'message' => "Either your Credentails are wrong or Something Bad Happen"], REST_Controller::HTTP_BAD_REQUEST);
			}
			$src = array(); // Initialize $src as an empty array before the loop
			$new_products = 0;
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
				$this->db->select('url')->from('rsssceduler')->where('user_id', $userID)->where('page_id', $page)->where('url', $FinalUrl);
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
				$this->create_single_rss_feed($userID, $page, $title, $src, $FinalUrl, $timeslots);
				$new_products++;
				// print_r($this->db->last_query());
			}
			if ($new_products > 0) {
				$this->response(['status' => true, 'message' => 'Good Work! We are setting up your awesome feed, Please Wait.'], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => true, 'message' => 'Attension! There are no New Products to fetch right now.', 'produplicate' => true], REST_Controller::HTTP_OK);
			}
		}

		$if_rss_delete = $this->post('if_rss_delete'); // Means this function is for deleting rss_links
		if (!empty($if_rss_delete) && $if_rss_delete == 'yes') {
			if (!empty($rss_link)) {
				$this->db->select('rss_link')->from('facebook_pages')->where('id', $page);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link)) {
					$this->response(['status' => false, 'message' => 'The selected rss is removed from input (not found in database)'], REST_Controller::HTTP_BAD_REQUEST);
				}
				$decoded_rss_link = json_decode($result[0]->rss_link, true); // Convert to an associative array
				$index = array_search($rss_link, $decoded_rss_link);
				if ($index !== false) {
					unset($decoded_rss_link[$index]);
					$decoded_rss_link = array_values($decoded_rss_link); // Reset keys
				}
				// Check if the array is empty
				if (empty($decoded_rss_link)) {
					$encode_updated_link = ''; // Set it to an empty string
				} else {
					$encode_updated_link = json_encode($decoded_rss_link);
				}
				$this->db->set('rss_link', $encode_updated_link);
				$this->db->where('id', $page);

				if ($this->db->update('facebook_pages')) {
					$this->response(['status' => true, 'message' => 'The selected rss has been deleted successfully'], REST_Controller::HTTP_OK);
				} else {
					$this->response(['status' => false, 'message' => 'Something went wrong, please try again'], REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$this->response(['status' => false, 'message' => 'There is nothing to delete'], REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			$encode_rss_links = json_encode($rss_link);

			//-----------------------------------------------Site mapping Start------------------------------------------------//
			$if_rss_fetch = $this->post('if_rss_fetch'); // Means this logic is for fetching sitemap 10 posts
			if (!empty($if_rss_fetch) && $if_rss_fetch == 'yes') {
				$sitemap_rss_link = $this->post('sitemap_rss_link'); // The rss link for which more posts 	are demanded //
				// check if link is already in page
				$this->db->select('rss_link')->from('facebook_pages')->where('id', $page);
				$result = $this->db->get()->result();

				$decoded_rss_link = json_decode($result[0]->rss_link, true);
				$decoded_rss_link = $decoded_rss_link ?? [];
				if (in_array($sitemap_rss_link, $decoded_rss_link)) {
					// old post
					limit_check(RSS_FEED_OLD_POST_FETCH_ID);
					// $response = fb_page_fetch_past_posts($sitemap_rss_link, $page, $userID, $timeslots, 1);
					$data = [
						'user_id' => $userID,
						'page_id' => $page,
						'type' => 'facebook_past',
						'url' => $sitemap_rss_link,
						'published' => 0
					];
					$this->db->insert('rss_links', $data);
					$cron_url = 'https://www.adublisher.com/fetchPastRssFeed';
				} else {
					// latest posts
					limit_check(RSS_FEED_LATEST_POST_FETCH_ID);
					$data = [
						'user_id' => $userID,
						'page_id' => $page,
						'type' => 'facebook',
						'url' => $sitemap_rss_link,
						'published' => 0
					];
					$this->db->insert('rss_links', $data);
					$cron_url = 'https://www.adublisher.com/fetchRssFeed';
				}
				$store_rss_link[] = $this->post('sitemap_rss_link'); // The rss link for which more posts 	are demanded // 
				$this->db->select('rss_link')->from('facebook_pages')->where('id', $page);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link) || $result[0]->rss_link == 'null') {
					$encode_rss_links = json_encode($store_rss_link);
				} else {
					$decoded_rss_link = json_decode($result[0]->rss_link, true);
					// Check if the link already exists in $decoded_rss_link
					if (($key = array_search($store_rss_link[0], $decoded_rss_link)) !== false) {
						$store_rss_link = []; // Set $store_rss_link to empty array if it already exists
					}
					$all_links = array_merge($decoded_rss_link, $store_rss_link);
					$all_links = array_values($all_links); // Reset keys
					$encode_rss_links = json_encode($all_links);
				}
				$page_data['rss_link'] = $encode_rss_links;
				$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page);
				$removeError = removeCronJobError($userID, 'facebook_page_error');
				// run cronjob for fetching rss feed
				run_php_background($cron_url);
				$this->response(['status' => true, 'message' => "Good Work!! We are setting up your awesome feed, Please Wait"], REST_Controller::HTTP_OK);
			} // if condition
			//-------------------------------------------------Site mapping End------------------------------------------------//
		}
	}
	public function facebookpagecatption_POST()
	{
		$this->sessioncheck();
		$userID = $this->post('publisher');
		$page = $this->post('page');
		$caption = $this->post('caption');
		$page_row = $this->Publisher_model->retrieve_record('facebook_pages', $page);
		$page_data['caption'] = trim($caption);
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page);
		$this->response(['status' => true, 'message' => 'Good Work!! Your awesome caption is saved to page'], REST_Controller::HTTP_OK);
	}

	public function rss_cronjob_get()
	{
		exit;
		try {
			$users = $this->Publisher_model->selectactivefacebookusers();
			foreach ($users as $user) {
				$user_id = $user->id;
				$error_column_name = 'facebook_page_error';
				$function_name = 'rss_cronjob_get';
				$pkinfo = $this->Publisher_model->userPackageforCron($user);
				if ($pkinfo->active == '1') {
					$pages = $this->Publisher_model->get_rsspages($user->id);
					foreach ($pages as $page) {
						$timeslots = $page->time_slots_rss;
						$this->Publisher_model->update_last_run($page->id, 'last_run', 'facebook_pages');
						$channel_name = $page->page_name;
						$user_check = user_check($user_id);
						if (!$user_check['status']) {
							$json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $user_check['message']); // helper function
							continue;
						}
						if (!$page->rss_active) {
							continue;
						}
						if (empty($page->rss_link) || $page->rss_link == 'null') {
							continue;
						}
						if (strpos($page->rss_link, '.atom') !== false) {
							continue;
						}

						$rss_linke = json_decode($page->rss_link);
						if (empty($rss_linke)) { // This means the rss link was never encoded before so you cant decode for the first time
							$rss_linke[] = $page->rss_link;
						}
						$arrContextOptions = array(
							'http' => [
								'method' => "GET",
								'header' => "User-Agent: curl/7.68.0\r\n",
								'ignore_errors' => true
							],
							"ssl" => array(
								"verify_peer" => false,
								"verify_peer_name" => false,
							),
						);
						foreach ($rss_linke as $links) {
							$parsed_url = parse_url($links);
							// Extract the protocol, domain, and append "sitemap.xml" to it
							if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
								$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
								$http_domain = 'http://' . $parsed_url['host'];
								$sitemapUrl = $main_domain . '/sitemap.xml';
							}
							$xml = simplexml_load_file($sitemapUrl);
							if (!$xml) {
								$sitemapContent = file_get_contents($sitemapUrl, false, stream_context_create($arrContextOptions));
								if (!empty($sitemapContent)) {
									$xml = simplexml_load_string($sitemapContent);
								}
							}

							if (count($xml) == 0) {
								$false_link = $links;
								$json_error_msg = updateCronJobError($user->id, $error_column_name, $channel_name, $function_name, 'Failed to fetch the RSS feed from ' . $false_link); // helper function
							} else {
								$filteredSitemaps = [];
								foreach ($xml->sitemap as $sitemap) {
									$loc = (string) $sitemap->loc;
									// Check if the <loc> element contains "post-sitemap" or "sitemap-post"
									if (strpos($loc, "post-sitemap") !== false || strpos($loc, "sitemap-post") !== false || strpos($loc, "sitemap-") !== false) {
										$filteredSitemaps[] = $sitemap;
									}
								}
								usort($filteredSitemaps, function ($a, $b) {
									$numberA = intval(preg_replace('/\D/', '', $a->loc));
									$numberB = intval(preg_replace('/\D/', '', $b->loc));
									return $numberB - $numberA; // Sort in descending order
								});
								$desiredPostCount = 5;
								foreach ($filteredSitemaps as $sitemap) {
									$loc = (string) $sitemap->loc;
									// Check if the <loc> element contains "post-sitemap"
									if (strpos($loc, "post-sitemap") !== false || strpos($loc, "sitemap-post") !== false || strpos($loc, "sitemap-") !== false) {
										$sitemapUrl = $loc; // Use the filtered URL
										$sitemapXml = simplexml_load_file($sitemapUrl);
										if (!$sitemapXml) {
											$sitemapContent = file_get_contents($sitemapUrl, false, stream_context_create($arrContextOptions));
											if (!empty($sitemapContent)) {
												$sitemapXml = simplexml_load_string($sitemapContent);
											}
										}
										// Now here we will sort the URL in descending order based on the last modified date so we will get the latest posts first //
										$urlLastModArray = [];
										foreach ($sitemapXml->url as $url) {
											$urlString = (string) $url->loc;
											$lastModString = (string) $url->lastmod;
											$lastModTimestamp = strtotime($lastModString);
											// Store URLs and last modification dates in a multidimensional array
											$urlLastModArray[$lastModTimestamp][] = [
												'loc' => $urlString,
												'lastmod' => $lastModString
											];
										}
										// Sort the multidimensional array by keys (last modification dates) in descending order
										krsort($urlLastModArray);
										$newSitemapXml = new SimpleXMLElement('<urlset></urlset>');
										foreach ($urlLastModArray as $lastModTimestamp => $urls) {
											foreach ($urls as $urlData) {
												$urlNode = $newSitemapXml->addChild('url');
												$urlNode->addChild('loc', $urlData['loc']);
												$urlNode->addChild('lastmod', $urlData['lastmod']);
											}
										}
										// descending order complete with same structure as xml//
										$postUrls = array();
										foreach ($newSitemapXml->url as $url) {
											$postUrl = (string) $url->loc; // Cast to string to get the URL
											if ($postUrl == $main_domain . '/' || $postUrl == $http_domain . '/') {
												continue; // Skip the first iteration
											}
											// Check if the URL is already in the database
											$this->db->select('url')->from('rsssceduler')->where('url', $postUrl)->where('page_id', $page->id);
											$query = $this->db->get()->result_array();

											// Check if the URL is already in the array
											$isDuplicate = false;
											foreach ($postUrls as $existingUrl) {
												if ($postUrl === $existingUrl) {
													$isDuplicate = true;
													break;
												}
											}
											// If it's not in the database and not a duplicate in the array, add it
											if (count($query) === 0 && !$isDuplicate) {
												// Concatenate "/feed" to the URL and add it to the array
												$postUrls[] = $postUrl;

												// If you have reached the desired count, break the loop
												if (count($postUrls) >= $desiredPostCount) {
													break;
												}
											}
										}
										if (!empty($postUrls)) {
											foreach ($postUrls as $solo_urls) {
												// Fetching Single Post data
												$data = array();
												$options = array(
													CURLOPT_URL => $solo_urls,
													CURLOPT_RETURNTRANSFER => true,
													CURLOPT_FOLLOWLOCATION => true,
													CURLOPT_CONNECTTIMEOUT => 30,
													CURLOPT_TIMEOUT => 30,
													CURLOPT_MAXREDIRS => 10,
													CURLOPT_SSL_VERIFYPEER => false,
													CURLOPT_SSL_VERIFYHOST => false,
													CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
												);
												$curl = curl_init();
												curl_setopt_array($curl, $options);
												$response = curl_exec($curl);
												// print_r($response);exit;
												$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
												curl_close($curl);
												if ($httpCode >= 200 && $httpCode < 300) {
													//Count Words of post
													$headers = array(
														'Content-type: application/json'
													);
													$opts = array(
														'http' =>
														array(
															'method' => 'GET',
															'header' => $headers,
															'ignore_errors' => true
														)
													);
													$context = stream_context_create($opts);
													$dom = new DOMDocument();
													libxml_use_internal_errors(true);
													$dom->loadHTML($response);
													libxml_clear_errors();
													$metaTitle = "";
													$ogimage = "";
													$ogimagesecure = "";
													$metaImage = "";
													$metaPublishTime = "";
													$metaTags = $dom->getElementsByTagName('meta');
													foreach ($metaTags as $meta) {
														if ($meta->getAttribute('property') == 'article:published_time') {
															$metaPublishTime = $meta->getAttribute('content');
															$dateTime = new DateTime($metaPublishTime);
															$metaPublishTime = $dateTime->format("Y-m-d h:i:s");
														}
														if ($meta->getAttribute('property') == 'og:title') {
															$metaTitle = $meta->getAttribute('content');
														}

														if ($meta->getAttribute('property') == 'og:image') {
															$ogimage = $meta->getAttribute('content');
														}
														if ($meta->getAttribute('property') == 'og:image:secure_url') {
															$ogimagesecure = $meta->getAttribute('content');
														}

														if (empty($metaTitle) && $meta->getAttribute('name') == 'twitter:title') {
															$metaTitle = $meta->getAttribute('content');
														}

														if (empty($ogimage) && $meta->getAttribute('name') == 'twitter:image') {
															$ogimage = $meta->getAttribute('content');
														}
													}

													if ($ogimage && $ogimagesecure && $ogimage == $ogimagesecure) {
														$metaImage = $ogimage;
													} elseif ($ogimagesecure) {
														$metaImage = $ogimagesecure;
													} else {
														$metaImage = $ogimage;
													}

													if (empty($metaImage)) {
														$scripts = $dom->getElementsByTagName('script');
														foreach ($scripts as $script) {
															if (strpos($script->getAttribute('type'), 'ld+json') !== false) {
																$jsonLdData = json_decode($script->nodeValue, true);
																if (isset($jsonLdData['@graph'][0]['thumbnailUrl'])) {
																	$metaImage = $jsonLdData['@graph'][0]['thumbnailUrl'];
																	break;
																}
															}
														}
													}
													if (!$metaImage) {
														$metaImage = base_url('assets/general/images/no_image_found.jpg');
													}
													// utm checks on url
													$utm_details = [];
													$utm_check = false;
													$url_detail = getDomain($solo_urls);
													if (!empty($url_detail['url'])) {
														$domain = $url_detail['url'];
														$utm_details = getUtm($domain);
														if (count($utm_details) > 0) {
															$utm_check = true;
														}
													}
													$page_detail = $this->Publisher_model->retrieve_record('facebook_pages', $page->id);
													if ($utm_check) {
														$solo_urls = make_utm_url($solo_urls, $utm_details, $page_detail->page_name, 'facebook');
													}
													$created_id = $this->create_single_rss_feed($user->id, $page->id, $metaTitle, $metaImage, $solo_urls, $timeslots);
													if ($created_id) {
														$removeError = removeCronJobError($user_id, $error_column_name); // helper function
													}
												} else {
													echo 'No Data found for this rss link ' . $solo_urls . '<br>';
												}
												// Ending single post data
											}
										}
									}
								}
							}
						}
						echo "</ul>";
					}
				}
				echo "</ul>";
			}
		} catch (Exception $e) {
			// Handle the exception
			$json_error_msg = updateCronJobError($user->id, $error_column_name, $channel_name, $function_name, $e . ' Something went wrong, Please try again.'); // helper function
			// $json_error_msg = updateCronJobError($user_id, $error_column_name, $channel_name, $e.' Failed to fetch the RSS feed from'. $page->rss_link);
			// You can log the exception or perform other error handling here
		}
	}

	// $this->db->select('*')->from('user')->where('id',2165);
	// $users = $this->db->get()->result();
	public function shopify_auto_products_for_fb_pages_get()
	{
		try {
			// Shopify Products Fetching
			// Below data Coming from User table Perfect.
			$users = $this->Publisher_model->selectactivefacebookusers();
			foreach ($users as $user) {

				$shopify_attached = $user->shopify_adminApiAccessToken;
				if (empty($shopify_attached)) {
					continue;
				}

				$pkinfo = $this->Publisher_model->userPackageforCron($user);
				if ($pkinfo->active == '1') {
					$pages = $this->Publisher_model->get_allpages($user->id);

					foreach ($pages as $page) {
						if (!$page->shopify_active) {
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
								$this->db->select('url')->from('rsssceduler')->where('user_id', $user->id)->where('page_id', $page->id)->where('url', $FinalUrl);
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
								$time_slots = $page->time_slots_rss;
								$time_slots = str_replace("[", '', $time_slots);
								$time_slots = str_replace("]", '', $time_slots);
								$time_slots = str_replace('"', '', $time_slots);
								$this->create_single_rss_feed($user->id, $page->id, $title, $src, $FinalUrl, $time_slots);
							}
						}
					} // pages foreach
				} // pkg info if
			} // foreach
			// Shopify Products Ending
		} catch (Exception $e) {
			echo 'Error: ' . $e->getMessage();
		}
	}



	public function create_single_rss_feed($userID, $page, $title, $img_path, $url, $timeslots)
	{
		$post_date_time = getNextPostTime("rsssceduler", $userID, $page, $timeslots);
		$this_id = $this->Publisher_model->post_rssschedule($userID, $page, $title, $img_path, $url, $post_date_time);
		return $this_id;
	}

	// backup
	public function getEventNextPostTime($table, $userID, $page, $timeslots, $event)
	{

		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$time_slots_arr = explode(",", $timeslots);
		$time_slots_size = count($time_slots_arr);
		$last_time_slot_element = $time_slots_arr[$time_slots_size - 1];

		$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND event_id = $event ORDER BY post_datetime DESC LIMIT 1");

		$last_post_scheduled = "";
		if (count($last_scedule->result()) > 0) {
			$last_post_scheduled = @$last_scedule->row()->post_datetime;
		}

		$next_post_DT = "";
		//here get event
		$event = $this->Publisher_model->retrieve_record('events', $event);

		$start_date = $event->start_date . " 00:00:00";
		$end_date = $event->end_date; //." 11:59:59";

		//$start_date = localToUTC($start_date , SERVER_TZ, "Y-m-d  H:i:s");
		//$start_date = utcToLocal($start_date, $user->gmt, "Y-m-d  H:i:s");
		//$end_date = localToUTC($end_date , SERVER_TZ, "Y-m-d  H:i:s");
		//$end_date = utcToLocal($end_date, $user->gmt, "Y-m-d  H:i:s");
		//if page has some sceduled posts

		if ($last_post_scheduled) {
			//check if already scheduled posts are in future or in backdates
			if ($last_post_scheduled < $start_date) {
				$next_post_DT = $start_date;
			} else {
				$next_post_DT = $last_post_scheduled;
				$next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
			}
		} else {
			//There is no posts sceduled already for this page so far start from scratch
			$next_post_DT = $start_date;
		}

		//$next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
		$date_for_dt = strtotime($next_post_DT);
		$last_date = date('Y-m-d', $date_for_dt);
		$last_year = date('Y', $date_for_dt);
		$last_hour = date('H', $date_for_dt);
		//Check if the last time slot comes in today or its passed, if passed date posting will be next day
		if ($last_hour >= $last_time_slot_element) {

			$last_date = date('Y-m-d', strtotime($next_post_DT . ' +1 day'));
			//time will be the first time slot of the next day;
			$next_hour = $time_slots_arr[0];
		} else {
			//Find next hour from array based on last_hour
			foreach ($time_slots_arr as $val) {
				if ($val > $last_hour) {
					$next_hour = $val;
					break;
				}
			}
		}
		$next_post_date_time = $last_date . " " . $next_hour . ":00";
		if ($event->repeating == "on") {

			$last_year = date('Y', $date_for_dt);
			$last_date = date("m-d", strtotime($event->end_date));
			$new_comparison = $last_year . "-" . $last_date . " 23:59";

			if (strtotime($next_post_date_time) > strtotime($new_comparison)) {

				$new_next_ts = $last_year . "-" . date("m-d", strtotime($event->start_date));
				$last_date = date('Y-m-d', strtotime($new_next_ts . ' +1 year'));
				$next_post_date_time = $last_date . " " . $time_slots_arr[0] . ":00";
			}
			return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
		} else {
			if ($last_date > $end_date) {
				return false;
			} else {
				return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
			}
		}
	}

	// Future use
	/*public function getEventNextPostTime($table, $userID, $page, $timeslots, $event, $for_update = array())
																																																																																																																   {
																																																																																																																	   $user = $this->Publisher_model->retrieve_record('user', $userID);
																																																																																																																	   $time_slots_arr = explode(",", $timeslots);
																																																																																																																	   $time_slots_size = count($time_slots_arr);
																																																																																																																	   $last_time_slot_element = $time_slots_arr[$time_slots_size - 1];

																																																																																																																	   // ================================= For Update ============================================// 		
																																																																																																																	   if(!empty($for_update) && $for_update['get_first_slot'] == true){
																																																																																																																		   $last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND event_id = $event ORDER BY post_datetime DESC LIMIT 1");
																																																																																																																		   if ($last_scedule->num_rows() > 0) {
																																																																																																																			   $last_scedule->row()->post_datetime = '';
																																																																																																																		   }
																																																																																																																	   }
																																																																																																																	   elseif(!empty($for_update) && isset($for_update['get_next_slot'])){
																																																																																																																		   $last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND event_id = $event ORDER BY post_datetime ASC LIMIT 1");
																																																																																																																		   if ($last_scedule->num_rows() > 0) {
																																																																																																																			   $last_scedule->row()->post_datetime = $for_update['get_next_slot'];
																																																																																																																		   }
																																																																																																																	   }
																																																																																																																	   // ================================= For Insert ============================================// 
																																																																																																																	   else {
																																																																																																																		   $last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND event_id = $event ORDER BY post_datetime DESC LIMIT 1");
																																																																																																																	   }

																																																																																																																	   $last_post_scheduled = "";
																																																																																																																	   if (count($last_scedule->result()) > 0) {
																																																																																																																		   $last_post_scheduled = @$last_scedule->row()->post_datetime;
																																																																																																																	   }

																																																																																																																	   $next_post_DT = "";
																																																																																																																	   //here get event
																																																																																																																	   $event = $this->Publisher_model->retrieve_record('events', $event);

																																																																																																																	   $start_date = $event->start_date . " 00:00:00";
																																																																																																																	   $end_date = $event->end_date; //." 11:59:59";

																																																																																																																	   //$start_date = localToUTC($start_date , SERVER_TZ, "Y-m-d  H:i:s");
																																																																																																																	   //$start_date = utcToLocal($start_date, $user->gmt, "Y-m-d  H:i:s");
																																																																																																																	   //$end_date = localToUTC($end_date , SERVER_TZ, "Y-m-d  H:i:s");
																																																																																																																	   //$end_date = utcToLocal($end_date, $user->gmt, "Y-m-d  H:i:s");
																																																																																																																	   //if page has some sceduled posts

																																																																																																																	   if ($last_post_scheduled) {
																																																																																																																		   //check if already scheduled posts are in future or in backdates
																																																																																																																		   // $last_post_scheduled = '2024-02-22 08:00:00';
																																																																																																																		   // $start_date = '2024-02-22 00:00:00';
																																																																																																																		   if ($last_post_scheduled < $start_date) {
																																																																																																																			   $next_post_DT = $start_date;

																																																																																																																			   echo 'if';
																																																																																																																			   print_r(array('last' => $last_post_scheduled));
																																																																																																																			   echo '<br>';
																																																																																																																			   print_r(array('start' =>$start_date));
																																																																																																																			   exit;

																																																																																																																		   } else {
																																																																																																																			   $next_post_DT = $last_post_scheduled;
																																																																																																																			   $next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
																																																																																																																		   }
																																																																																																																	   } else {
																																																																																																																		   //There is no posts sceduled already for this page so far start from scratch
																																																																																																																		   $next_post_DT = $start_date;
																																																																																																																	   }

																																																																																																																	   //$next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
																																																																																																																	   $date_for_dt = strtotime($next_post_DT);
																																																																																																																	   $last_date = date('Y-m-d', $date_for_dt);
																																																																																																																	   $last_year = date('Y', $date_for_dt);
																																																																																																																	   $last_hour = date('H', $date_for_dt);
																																																																																																																	   //Check if the last time slot comes in today or its passed, if passed date posting will be next day
																																																																																																																	   if ($last_hour >= $last_time_slot_element) {

																																																																																																																		   $last_date = date('Y-m-d', strtotime($next_post_DT . ' +1 day'));
																																																																																																																		   //time will be the first time slot of the next day;
																																																																																																																		   $next_hour = $time_slots_arr[0];
																																																																																																																	   } else {
																																																																																																																		   //Find next hour from array based on last_hour
																																																																																																																		   foreach ($time_slots_arr as $val) {
																																																																																																																			   if ($val > $last_hour) {
																																																																																																																				   $next_hour = $val;
																																																																																																																				   break;
																																																																																																																			   }
																																																																																																																		   }
																																																																																																																	   }
																																																																																																																	   $next_post_date_time = $last_date . " " . $next_hour . ":00";
																																																																																																																	   if ($event->repeating == "on") {

																																																																																																																		   $last_year = date('Y', $date_for_dt);
																																																																																																																		   $last_date = date("m-d", strtotime($event->end_date));
																																																																																																																		   $new_comparison = $last_year . "-" . $last_date . " 23:59";

																																																																																																																		   if (strtotime($next_post_date_time) > strtotime($new_comparison)) {

																																																																																																																			   $new_next_ts = $last_year . "-" . date("m-d", strtotime($event->start_date));
																																																																																																																			   $last_date = date('Y-m-d', strtotime($new_next_ts . ' +1 year'));
																																																																																																																			   $next_post_date_time = $last_date . " " . $time_slots_arr[0] . ":00";
																																																																																																																		   }
																																																																																																																		   return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
																																																																																																																	   } else {
																																																																																																																		   if ($last_date > $end_date) {
																																																																																																																			   return false;
																																																																																																																		   } else {
																																																																																																																			   return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
																																																																																																																		   }
																																																																																																																	   }
																																																																																																																   }*/

	public function getEventNextPostTimeWeekly($table, $userID, $page, $timeslots, $event)
	{

		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$time_slots_arr = explode(",", $timeslots);
		$time_slots_size = count($time_slots_arr);
		$last_time_slot_element = $time_slots_arr[$time_slots_size - 1];
		$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND event_id = $event ORDER BY post_datetime DESC LIMIT 1");
		$lastpostscheduled_already = "";
		if (count($last_scedule->result()) > 0) {

			$lastpostscheduled_already = @$last_scedule->row()->post_datetime;
		}
		$event = $this->Publisher_model->retrieve_record('events', $event);


		$next_post_DT = "";
		$lastpostscheduled_local = localToUTC(date("Y-m-d H:i:s"), SERVER_TZ, "Y-m-d  H:i:s");
		$lastpostscheduled_local = utcToLocal($lastpostscheduled_local, $user->gmt, "Y-m-d  H:i:s");
		//if page has some sceduled posts
		if ($lastpostscheduled_already) {
			//check if already scheduled posts are in future or in backdates
			if ($lastpostscheduled_already < $lastpostscheduled_local) {

				$next_post_DT = $lastpostscheduled_local;
			} else {

				$next_post_DT = $lastpostscheduled_already;
				$next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
			}
		} else {
			//There is no posts sceduled already for this page so far start from scratch
			$date = new DateTime($lastpostscheduled_local);
			$next_post_DT = $date->modify("next " . $event->event_day)->format("Y-m-d") . " 00:00:00";
			//$next_post_DT = $lastpostscheduled_local;
		}

		$date_for_dt = strtotime($next_post_DT);
		$last_date = date('Y-m-d', $date_for_dt);
		$last_hour = date('H', $date_for_dt);
		//Check if the last time slot comes in today or its passed, if passed date posting will be next day
		if ($last_hour >= $last_time_slot_element) {

			$last_date = date('Y-m-d', strtotime($next_post_DT . ' +1 week'));
			//time will be the first time slot of the next day;
			$next_hour = $time_slots_arr[0];
		} else {

			//Find next hour from array based on last_hour
			foreach ($time_slots_arr as $val) {
				if ($val > $last_hour) {
					$next_hour = $val;
					break;
				}
			}
		}

		$next_post_date_time = $last_date . " " . $next_hour . ":00";

		return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
	}

	// $update_arsp_slots means Update Already Scheduled Posts Slots
	public function getNextPostTime($table, $userID, $page, $timeslots, $for_update = array())
	{
		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$time_slots_arr = explode(",", $timeslots);
		$time_slots_size = count($time_slots_arr);
		$last_time_slot_element = $time_slots_arr[$time_slots_size - 1];
		if ($table == "bulkupload") {
			// ================================= For Update ============================================// 
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->post_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
			}
			// ============================= End of Bulk Upload ========================================// 
		} else if ($table == "channels_scheduler") {
			// ================================= For Update ============================================// 
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE channel_id = $page AND user_id = $userID AND status = 1 ORDER BY post_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->post_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
			}
			// ============================= End of Channel Scheduler ==================================// 
		} else if ($table == "pinterest_scheduler") {
			// ================================= For Update ============================================// 
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
			}
			// ============================== End of Pinterest Scheduler ===============================// 
		} else if ($table == "instagram_scheduler") {
			// ================================= For Update ============================================// 
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
			}
			// ============================= End of Instagram Scheduler ================================// 
		} else if ($table == "facebook_group_scheduler") {
			// ================================= For Update ============================================// 
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
			}
			// ========================== End of Facebbok Group Scheduler ===============================// 
		} elseif ($table == "youtube_scheduler") {
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE channel_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
			}
		}
		// Start of Youtube Scheduling
		else {
			// ================================= For Update ============================================// 
			if (!empty($for_update) && $for_update['get_first_slot'] == true) {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND posted = 1 ORDER BY post_datetime DESC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->post_datetime = '';
				}
			} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
				if ($last_scedule->num_rows() > 0) {
					$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
				}
			}
			// ================================= For Insert ============================================// 
			else {
				$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
			}
			// =========================== End of others like rssscheduler =============================// 
		}
		$lastpostscheduled_already = "";
		if (count($last_scedule->result()) > 0) {

			$lastpostscheduled_already = @$last_scedule->row()->post_datetime;

			if ($table == "pinterest_scheduler" || $table == "instagram_scheduler" || $table == "facebook_group_scheduler" || $table == 'youtube_scheduler') {
				$lastpostscheduled_already = @$last_scedule->row()->publish_datetime;
			}
		}
		$next_post_DT = "";
		$lastpostscheduled_local = localToUTC(date("Y-m-d H:i:s"), SERVER_TZ, "Y-m-d  H:i:s");
		//if page has some sceduled posts
		if ($lastpostscheduled_already) {
			//check if already scheduled posts are in future or in backdates
			if ($lastpostscheduled_already < $lastpostscheduled_local) {

				$next_post_DT = $lastpostscheduled_local;
			} else {

				$next_post_DT = $lastpostscheduled_already;
				$next_post_DT = utcToLocal($next_post_DT, $user->gmt, "Y-m-d  H:i:s");
			}
		} else {

			$lastpostscheduled_local = utcToLocal($lastpostscheduled_local, $user->gmt, "Y-m-d  H:i:s");
			//There is no posts sceduled already for this page so far start from scratch
			$next_post_DT = $lastpostscheduled_local;
		}

		$date_for_dt = strtotime($next_post_DT);
		$last_date = date('Y-m-d', $date_for_dt);
		$last_hour = date('H', $date_for_dt);
		//Check if the last time slot comes in today or its passed, if passed date posting will be next day
		if ($last_hour >= $last_time_slot_element) {
			$last_date = date('Y-m-d', strtotime($next_post_DT . ' +1 day'));
			//time will be the first time slot of the next day;
			$next_hour = $time_slots_arr[0];
		} else {

			//Find next hour from array based on last_hour
			foreach ($time_slots_arr as $val) {
				if ($val > $last_hour) {
					$next_hour = $val;
					break;
				}
			}
		}

		if ($next_hour == '' && $next_hour == null && empty($next_hour)) {
			$next_hour = "00";
		}

		$next_post_date_time = $last_date . " " . $next_hour . ":00";

		return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
	}

	public function updatetimeslotsrss_POST()
	{
		$this->sessioncheck();
		$pageid = trim($this->post('page'));
		$page_data['time_slots_rss'] = json_encode($this->post('time_slots'));
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $pageid);

		$count_slots = count($this->post('time_slots'));

		$timeslots = implode(",", $this->post('time_slots'));
		if ($count_slots > 0) {
			$this->db->select('*')->from('rsssceduler')->where('page_id', $pageid)->where('posted', 0);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_date_time = getNextPostTime("rsssceduler", $userID, $pageid, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_date_time;

				$this->Publisher_model->update_rssschedule($primary_id, $post_date_time);
			}
		}

		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function updatetimeslotsauto_POST()
	{
		$this->sessioncheck();
		$result = $this->Publisher_model->managetimeslotsupdateauto();
		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function updateyoutubetimeslotsauto_POST()
	{
		$this->sessioncheck();
		$result = $this->Publisher_model->managetyoutubeimeslotsupdateauto();
		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function upddomainsautoauto_POST()
	{
		$this->sessioncheck();
		$result = $this->Publisher_model->managedomainsupdateauto();
		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}



	public function updatetimeslots_POST()
	{
		$this->sessioncheck();
		$pageid = trim($this->post('page'));
		$page_data['time_slots'] = json_encode($this->post('time_slots'));
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $pageid);

		$count_slots = count($this->post('time_slots'));

		$timeslots = implode(",", $this->post('time_slots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('bulkupload')->where('page_id', $pageid)->where('event_id', 0);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_datetime = getNextPostTime("bulkupload", $userID, $pageid, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_datetime;

				$this->Publisher_model->updateBulkSchedule($primary_id, $post_datetime);
			}
		}

		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}


	public function update_article_POST()
	{

		$title = $this->post('title');
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$content = $this->post('content');
		$userid = $this->post('userid');
		$category = $this->post('category');
		$tags = $this->post('tags');
		$article_id = $this->post('article_id');
		$article = $this->Publisher_model->retrieve_record('article', $article_id);
		$img_path = $article->image;
		$unlink_previous = $article->image;

		if (!empty($_FILES)) {

			if ($this->upload_article_image('image')) {

				$upload_data = $this->upload->data();
				$img_path = $upload_data['file_name'];
				$unlink_previous = $_SERVER['DOCUMENT_ROOT'] . "/assets/articles/" . $unlink_previous;
				$unlink = unlink($unlink_previous);
			}
		}
		if ($this->Publisher_model->update_article($title, $content, $article_id, $category, $tags, $img_path)) {
			$this->response(array(
				'status' => true,
				'message' => 'Your changes  are saved, You will get notification and email regarding updates.',
			), REST_Controller::HTTP_OK);
		} else {

			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}
	public function facebookbulksceduleddelete_POST()
	{
		$this->sessioncheck();
		$post_id = $this->post('id');

		$post = $this->Publisher_model->retrieve_record('bulkupload', $post_id);
		$img_path = $post->link;

		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $img_path;
		} else {
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $img_path;
		}

		if ($this->Publisher_model->delete_record('bulkupload', $post_id)) {
			$unlink = unlink($delete_path);
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled post Removed Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}
	// 
	public function facebookbulksceduleddeleteall_POST()
	{
		$this->sessioncheck();
		$page_id = $this->post('page');
		$event_id = $this->post('event_id');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$where[1]['key'] = 'page_id';
		$where[1]['value'] = $page_id;

		if ($event_id > 0) {
			$where[2]['key'] = 'event_id';
			$where[2]['value'] = $event_id;
		} else {
			$where[2]['key'] = 'event_id';
			$where[2]['value'] = 0;
		}

		$result = $this->Publisher_model->list_records('bulkupload', 0, 10000, $where, 'id', 'DESC');
		$total = count($result);
		if ($result) {

			foreach ($result as $key => $row) {

				$post_id = $row->id;
				$post = $this->Publisher_model->retrieve_record('bulkupload', $post_id);
				$img_path = $post->link;
				if ("::1" == $_SERVER['REMOTE_ADDR']) {
					$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $img_path;
				} else {
					$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $img_path;
				}
				$del = $this->Publisher_model->delete_record('bulkupload', $post_id);
				$unlink = unlink($delete_path);
			}

			$this->response(array(
				'total' => $total,
				'status' => true,
				'message' => 'Your scheduled posts Removed Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}
	public function deletersspost_POST()
	{
		$this->sessioncheck();
		$post_id = $this->post('id');
		//Here get its time and date
		$new_result = [];
		$post = $this->Publisher_model->retrieve_record('rsssceduler', $post_id);
		if ($post->post_type == 'past') {
			$past = true;
		} elseif ($post->post_type == 'latest') {
			$past = false;
		}
		if ($this->Publisher_model->delete_record('rsssceduler', $post_id)) {
			if (isset($past)) {
				$past ? resources_update('down', RSS_FEED_OLD_POST_FETCH_ID) : resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
			}
			$this->response(array(
				'status' => true,
				'data' => $new_result,
				'message' => 'Your scheduled post Removed Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'data' => '',
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function deletersspostall_POST()
	{
		$this->sessioncheck();
		$page_id = $this->post('page');
		$with_error = $this->post('error');
		$type = $this->post('type');

		if ($with_error == "all" && $type == 'rss') {
			$result = $this->db->query("SELECT * FROM rsssceduler WHERE page_id = $page_id AND link NOT LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "all" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('rsssceduler', 'page_id', $id);
			$result = $this->db->query("SELECT * FROM rsssceduler WHERE page_id = $page_id AND link LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "error" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('rsssceduler', 'page_id', $id);
			$result = $this->db->query("SELECT * FROM rsssceduler WHERE page_id = $page_id AND link NOT LIKE '%cdn.shopify.com%' AND posted =-1 AND error IS NOT NULL");
		} elseif ($with_error == "error" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('rsssceduler', 'page_id', $id);
			$result = $this->db->query("SELECT * FROM rsssceduler WHERE page_id = $page_id AND link LIKE '%cdn.shopify.com%' AND posted =-1 AND error IS NOT NULL");
		}

		foreach ($result->result_array() as $key => $value) {
			$post_id = $value['id'];
			if ($value['post_type'] == 'past') {
				$past = true;
			} elseif ($value['post_type'] == 'latest') {
				$past = false;
			}

			if ($value['posted'] == 1) {
				continue;
			}

			if ($this->Publisher_model->delete_record('rsssceduler', $post_id)) {
				if (isset($past)) {
					$past ? resources_update('down', RSS_FEED_OLD_POST_FETCH_ID) : resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
				}
			}
		}

		if ($result) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts Removed Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function shufflefacebookposts_POST()
	{
		$this->sessioncheck();
		$page_id = $this->post('page');
		$query = $this->db->query("SELECT post_datetime FROM sceduler WHERE page_id =$page_id ORDER BY rand()");
		$random_slots = $query->result_array();
		$query_all = $this->db->query("SELECT * FROM sceduler WHERE page_id =$page_id  ORDER BY post_datetime ASC");
		$all_posts = $query_all->result_array();
		foreach ($all_posts as $key => $post) {
			$post_data['post_datetime'] = $random_slots[$key]['post_datetime'];
			$updated = $this->Publisher_model->update_record('sceduler', $post_data, $post['id']);
		}
		if ($all_posts) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts shuffled Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function shufflepinterestposts_POST()
	{
		$this->sessioncheck();
		$page_id = $this->post('page');
		$query = $this->db->query("SELECT post_datetime FROM sceduler WHERE page_id =$page_id ORDER BY rand()");
		$random_slots = $query->result_array();
		$query_all = $this->db->query("SELECT * FROM sceduler WHERE page_id =$page_id  ORDER BY post_datetime ASC");
		$all_posts = $query_all->result_array();
		foreach ($all_posts as $key => $post) {
			$post_data['post_datetime'] = $random_slots[$key]['post_datetime'];
			$updated = $this->Publisher_model->update_record('sceduler', $post_data, $post['id']);
		}
		if ($all_posts) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts shuffled Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function shufflersspostall_POST()
	{
		$this->sessioncheck();
		$page_id = $this->post('page');

		$query = $this->db->query("SELECT post_datetime FROM rsssceduler WHERE page_id =$page_id AND posted = 0 ORDER BY rand()");
		$random_slots = $query->result_array();

		$query_all = $this->db->query("SELECT * FROM rsssceduler WHERE page_id =$page_id AND posted = 0 ORDER BY post_datetime ASC");
		$all_posts = $query_all->result_array();
		foreach ($all_posts as $key => $post) {
			$post_data['post_datetime'] = $random_slots[$key]['post_datetime'];
			$updated = $this->Publisher_model->update_record('rsssceduler', $post_data, $post['id']);
		}
		if ($all_posts) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts shuffled Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function refresh_rss_posts_POST()
	{
		$user_id = App::Session()->get('userid');
		$page_id = $this->post('page');
		$timeslots = $this->post('timeslots');
		$rss_table = '';
		$status_column = '';
		$id_column = '';
		$selected_type = $this->post('selected_type');

		if ($selected_type == 'facebook') {
			$rss_table = 'rsssceduler';
			$id_column = 'page_id';
			$status_column = 'posted';
		} else if ($selected_type == 'pinterest') {
			$rss_table = 'pinterest_scheduler';
			$id_column = 'board_id';
			$status_column = 'published';
		} else if ($selected_type == 'fb_group') {
			$rss_table = 'facebook_group_scheduler';
			$id_column = 'published';
			$status_column = 'fb_group_id';
		} else {
			$rss_table = 'instagram_scheduler';
			$id_column = 'published';
			$status_column = 'ig_id';
		}
		if (!empty($rss_table)) {
			$data = [
				'user_id' => $user_id,
				'page_id' => $page_id,
				'timeslots' => implode(',', $timeslots),
				'rss_table' => $rss_table,
				'id_column' => $id_column,
				'status_column' => $status_column,
				'published' => 0
			];
			$response = $this->db->insert('refresh_feeds', $data);
			run_php_background("https://www.adublisher.com/refreshRssFeed");
			// refresh_posts($page_id, $timeslots, $rss_table, $id_column, $status_column);
			$this->response(['status' => true, 'data' => 'Your Feed is being refreshed!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			$this->response(['status' => false, 'data' => 'Something went wrong!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
	}

	public function publish_now_facebook_post_POST()
	{
		limit_check(RSS_FEED_POST_PUBLISH_ID);
		$post_id = $this->post('id');
		$page_id = $this->post('page_id');
		$user_id = App::Session()->get('userid');
		$page = $this->Publisher_model->retrieve_record('facebook_pages', $page_id);
		$bulkupload_limit_check = bulkupload_limit_check($user_id, $page->page_id);
		if ($bulkupload_limit_check['status']) {
			$post = $this->Publisher_model->retrieve_record('rsssceduler', $post_id);
			if ($post->post_datetime == "0000-00-00 00:00:00") {
				$this->Publisher_model->delete_record('publish_now', $post->id);
				$this->response(['status' => false, 'data' => 'Something went wrong!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			$data = [
				'user_id' => $user_id,
				'page_id' => $page_id,
				'post_id' => $post->id,
				'type' => 'facebook_rss',
				'published' => 0
			];
			$this->db->insert('publish_now', $data);
			run_php_background('https://www.adublisher.com/publishRssNow');
			$this->response(['status' => true, 'data' => 'Your post is being Published!'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'data' => $bulkupload_limit_check['message']], REST_Controller::HTTP_OK);
		}
	}

	public function publish_now_queued_post_POST()
	{
		$post_id = $this->post('id');
		$post = $this->Publisher_model->retrieve_record('channels_scheduler', $post_id);
		$user_id = App::Session()->get('userid');
		if (!empty($post)) {
			if ($post->post_datetime == "0000-00-00 00:00:00") {
				$this->response(['status' => false, 'data' => 'Something went wrong!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
				$type = $post->type;
				if ($type == 'facebook') {
					$page_id = $post->channel_id;
					$page = $this->Publisher_model->retrieve_record('facebook_pages', $page_id);
					limit_check(POST_SCHEDULING_FB_ID);
					$bulkupload_limit_check = bulkupload_limit_check($user_id, $page->page_id);
					if (!$bulkupload_limit_check['status']) {
						$result = [
							'status' => false,
							'error' => $bulkupload_limit_check['message']
						];
					} else {
						$data = [
							'user_id' => $user_id,
							'page_id' => $page_id,
							'post_id' => $post->id,
							'type' => 'facebook',
							'published' => 0
						];
						$this->db->insert('publish_now', $data);
						$result = [
							'status' => true,
							'message' => 'Your post is being Published!'
						];
					}
				}
				if ($type == 'pinterest') {
					limit_check(POST_SCHEDULING_PIN_ID);
					$page_id = $post->channel_id;
					$data = [
						'user_id' => $user_id,
						'page_id' => $page_id,
						'post_id' => $post->id,
						'type' => 'pinterest',
						'published' => 0
					];
					$this->db->insert('publish_now', $data);
					$result = [
						'status' => true,
						'message' => 'Your post is being Published!'
					];
				}
				if ($type == 'instagram') {
					limit_check(POST_PUBLISHING_INST_ID);
					$page_id = $post->channel_id;
					$data = [
						'user_id' => $user_id,
						'page_id' => $page_id,
						'post_id' => $post->id,
						'type' => 'instagram',
						'published' => 0
					];
					$this->db->insert('publish_now', $data);
					$result = [
						'status' => true,
						'message' => 'Your post is being Published!'
					];
				}
				if ($type == 'tiktok') {
					// limit_check(POST_PUBLISHING_INST_ID);
					$page_id = $post->channel_id;
					$data = [
						'user_id' => $user_id,
						'page_id' => $page_id,
						'post_id' => $post->id,
						'type' => 'tiktok',
						'published' => 0
					];
					$this->db->insert('publish_now', $data);
					$result = [
						'status' => true,
						'message' => 'Your post is being Published!'
					];
				}
			}
		}
		if ($result['status']) {
			run_php_background('https://www.adublisher.com/publishQueueNow');
			$this->response(['status' => true, 'data' => $result['message']], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'data' => $result['error']], REST_Controller::HTTP_OK);
		}
	}

	public function publish_now_pinterest_post_POST()
	{
		$user_id = App::Session()->get('userid');
		$post_id = $this->post('id');
		$page_id = $this->post('page_id');
		$post = $this->Publisher_model->retrieve_record('pinterest_scheduler', $post_id);
		if ($post->publish_datetime == "0000-00-00 00:00:00") {
			$this->Publisher_model->delete_record('publish_now', $post->id);
			$this->response(['status' => false, 'data' => 'Something went wrong!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		$data = [
			'user_id' => $user_id,
			'page_id' => $page_id,
			'post_id' => $post->id,
			'type' => 'pinterest_rss',
			'published' => 0
		];
		$this->db->insert('publish_now', $data);
		run_php_background('https://www.adublisher.com/publishRssNow');
		$this->response(['status' => true, 'data' => 'Your post is being Published!'], REST_Controller::HTTP_OK);
	}

	public function publish_now_instagram_post_POST()
	{
		$user_id = App::Session()->get('userid');
		$post_id = $this->post('id');
		$page_id = $this->post('page_id');
		$post = $this->Publisher_model->retrieve_record('instagram_scheduler', $post_id);
		if ($post->publish_datetime == "0000-00-00 00:00:00") {
			$this->Publisher_model->delete_record('publish_now', $post->id);
			$this->Publisher_model->delete_record('instagram_scheduler', $post->id);
			$this->response(['status' => false, 'data' => 'Something went wrong!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		$data = [
			'user_id' => $user_id,
			'page_id' => $page_id,
			'post_id' => $post->id,
			'type' => 'instagram_rss',
			'published' => 0
		];
		$this->db->insert('publish_now', $data);
		run_php_background('https://www.adublisher.com/publishRssNow');
		$this->response(['status' => true, 'data' => 'Your post is being Published!'], REST_Controller::HTTP_OK);
	}

	public function shuffle_scheduled_posts_POST()
	{
		$this->sessioncheck();
		$user_id = App::Session()->get('userid');
		$where_e[0]['key'] = 'channel_id';
		$where_e[1]['key'] = 'user_id';
		$where_e[1]['value'] = $user_id;
		$where_e[2]['key'] = 'status';
		$where_e[2]['value'] = 0;
		$where_e[3]['key'] = 'active_deactive_status';
		$where_e[3]['value'] = 1;
		// shuffle pinterest queued posts
		$pinterest_boards = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $user_id));
		$query = $this->db->query("SELECT post_datetime FROM channels_scheduler WHERE type = 'pinterest' AND user_id = $user_id AND status = 0 AND active_deactive_status = 1 ORDER BY rand()");
		$random_slots = $query->result_array();
		$count = 0;
		foreach ($pinterest_boards as $board) {
			$board_id = $board->id;
			$where_e[0]['value'] = $board_id;
			if (count($random_slots) > 0) {
				$all_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_e, 'id', 'asc');
				foreach ($all_posts as $key => $post) {
					$post_data['post_datetime'] = $random_slots[$count]['post_datetime'];
					$count++;
					$updated = $this->Publisher_model->update_record('channels_scheduler', $post_data, $post->id);
				}
			}
		}
		// shuffle facebook queued posts
		$facebook_pages = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id));
		$query = $this->db->query("SELECT post_datetime FROM channels_scheduler WHERE type = 'facebook' AND user_id = $user_id AND status = 0 AND active_deactive_status = 1 ORDER BY rand()");
		$random_slots = $query->result_array();
		$count = 0;
		foreach ($facebook_pages as $page) {
			$page_id = $page->id;
			$where_e[0]['value'] = $page_id;
			if (count($random_slots) > 0) {
				$all_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_e, 'id', 'asc');
				foreach ($all_posts as $key => $post) {
					$post_data['post_datetime'] = $random_slots[$count]['post_datetime'];
					$count++;
					$updated = $this->Publisher_model->update_record('channels_scheduler', $post_data, $post->id);
				}
			}
		}
		// shuffle facebook group queued posts
		$facebook_groups = $this->Publisher_model->get_allrecords('facebook_groups', array('user_id' => $user_id, 'active' => 'y'));
		$query = $this->db->query("SELECT post_datetime FROM channels_scheduler WHERE type = 'fb_groups' AND user_id = $user_id AND status = 0 AND active_deactive_status = 1 ORDER BY rand()");
		$random_slots = $query->result_array();
		$count = 0;
		foreach ($facebook_groups as $group) {
			$id = $group['id'];
			$where_e[0]['value'] = $id;
			if (count($random_slots) > 0) {
				$all_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_e, 'id', 'asc');
				foreach ($all_posts as $key => $post) {
					$post_data['post_datetime'] = $random_slots[$count]['post_datetime'];
					$count++;
					$updated = $this->Publisher_model->update_record('channels_scheduler', $post_data, $post->id);
				}
			}
		}
		// shuffle instagram queued posts
		$instagram_pages = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $user_id, 'active' => 'y'));
		$query = $this->db->query("SELECT post_datetime FROM channels_scheduler WHERE type = 'instagram' AND user_id = $user_id AND status = 0 AND active_deactive_status = 1 ORDER BY rand()");
		$random_slots = $query->result_array();
		$count = 0;
		foreach ($instagram_pages as $ig_page) {
			// $ig_id = $ig_page['id'];
			$ig_id = $ig_page->id;
			$where_e[0]['value'] = $ig_id;
			if (count($random_slots) > 0) {
				$all_posts = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_e, 'id', 'asc');
				foreach ($all_posts as $key => $post) {
					$post_data['post_datetime'] = $random_slots[$count]['post_datetime'];
					$count++;
					$updated = $this->Publisher_model->update_record('channels_scheduler', $post_data, $post->id);
				}
			}
		}
		$this->response(array(
			'status' => true,
			'message' => 'Your scheduled posts shuffled Successfully',

		), REST_Controller::HTTP_OK);
	}



	public function instagrambulksceduleddelete_POST()
	{

		$post_id = $this->post('id');
		$post = $this->Publisher_model->retrieve_record('igbulkupload', $post_id);
		$img_path = $post->link;
		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $img_path;
		} else {
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $img_path;
		}

		if ($this->Publisher_model->delete_record('igbulkupload', $post_id)) {

			$unlink = unlink($delete_path);
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled post Removed Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	private function upload_bulk_image($image)
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');

		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/";
		} else {
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/";
		}

		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['overwrite'] = true;
		$config['max_size'] = '65536';
		$config['file_name'] = $userID . "_" . time() . "_" . $_FILES[$image]["name"];
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($image)) {
			return false;
			// $errors = $this->upload->display_errors();
			// print_r($errors);
			// exit;

		} else {
			return true;
		}
	}

	public function save_filter_post()
	{
		$this->sessioncheck();
		$cat = $this->post('cat');
		$popularity = $this->post('popularity');
		$domain = $this->post('domain');
		$user_id = App::Session()->get('userid');
		if (!empty($cat) && is_array($cat)) {
			$cat = implode("|", $cat);
		}

		if (!empty($user_id)) {
			//echo 'test';die;
			$is_avail = $this->Publisher_model->already_save_filter($user_id);
			$data = ['cat' => $cat, 'popularity' => $popularity, 'domain' => $domain,];
			if (!$is_avail) {
				//Insert
				$this->Publisher_model->save_filter($user_id, $data);
			} else {
				//Update
				$this->Publisher_model->update_save_filter($user_id, $data);
			}
		}
		return true;
	}

	public function channel_settings_POST()
	{
		try {
			$user_id = App::Session()->get('userid');
			$facebook = $this->post('facebook');
			$pinterest = $this->post('pinterest');

			$fb = json_encode($facebook);
			$pin = json_encode($pinterest);

			$data = ['user_id' => $user_id, 'facebook' => $fb, 'pinterest' => $pin];

			$this->load->model('Publisher_model');
			$this->Publisher_model->channel_settings($data);

			$this->response(['status' => true, 'success' => 'Channels Settings saved successfully']);
		} catch (Exception $e) {
			$this->response(['status' => false, 'error' => 'Nothing has been saved, Please try again']);
		}
	}


	public function channel_settings_GET()
	{
		try {
			$user_id = App::Session()->get('userid');
			$this->load->model('Publisher_model');
			$settings = $this->Publisher_model->get_channel_settings($user_id);
			$saved_settings = [];
			if ($settings) {
				$saved_settings['facebook'] = json_decode($settings->facebook);
				$saved_settings['pinterest'] = json_decode($settings->pinterest);
			}
			$this->response(['status' => true, 'settings' => $settings]);
		} catch (Exception $e) {
			$this->response(['status' => false, 'error' => 'Nothing has been saved, Please try again']);
		}
	}

	// update channels settings
	public function update_channel_settings_POST()
	{
		try {
			$user_id = App::Session()->get('userid');
			$facebook = $this->post('facebook');
			$pinterest = $this->post('pinterest');

			$data = ['facebook' => $facebook, 'pinterest' => $pinterest];

			$this->load->model('Publisher_model');
			$this->Publisher_model->update_channel_settings($user_id, $data);

			$this->response(['status' => true, 'success' => 'Channels Settings saved successfully']);
		} catch (Exception $e) {
			$this->response(['status' => false, 'error' => 'Nothing has been saved, Please try again']);
		}
	}

	public function boards_channel_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$board_id = $this->post('board_id');
		$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';

		$count_slots = count($this->post('timeslots'));

		$timeslots = implode(",", $this->post('timeslots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('channels_scheduler')->where('channel_id', $board_id)->where('status', 0)->where('type', 'pinterest')->where('active_deactive_status', 1);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_datetime = getNextPostTime("channels_scheduler", $userID, $board_id, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_datetime;

				$this->Publisher_model->UpdatescheduleOnChannel($primary_id, $post_datetime);
			}
		}

		if ($board_id) {
			$this->Publisher_model->post_boards_channel_slots($userID, $board_id, $timeslots);
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function fbpages_channel_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$page_id = $this->post('page_id');
		$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';

		$count_slots = count($this->post('timeslots'));

		$timeslots = implode(",", $this->post('timeslots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('channels_scheduler')->where('channel_id', $page_id)->where('status', 0)->where('type', 'facebook')->where('active_deactive_status', 1);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_datetime = getNextPostTime("channels_scheduler", $userID, $page_id, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_datetime;

				$this->Publisher_model->UpdatescheduleOnChannel($primary_id, $post_datetime);
			}
		}

		if ($page_id) {
			$this->Publisher_model->post_fbpages_channel_slots($userID, $page_id, $timeslots);
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function ig_channel_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$ig_id = $this->post('ig_id');
		$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';

		$count_slots = count($this->post('timeslots'));

		$timeslots = implode(",", $this->post('timeslots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('channels_scheduler')->where('channel_id', $ig_id)->where('status', 0)->where('type', 'instagram')->where('active_deactive_status', 1);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_datetime = getNextPostTime("channels_scheduler", $userID, $ig_id, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_datetime;

				$this->Publisher_model->UpdatescheduleOnChannel($primary_id, $post_datetime);
			}
		}

		if ($ig_id) {
			$this->Publisher_model->post_ig_channel_slots($userID, $ig_id, $timeslots);
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function fbgroup_channel_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$fbgroup_id = $this->post('fbgroup_id');
		$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';

		$count_slots = count($this->post('timeslots'));

		$timeslots = implode(",", $this->post('timeslots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('channels_scheduler')->where('channel_id', $fbgroup_id)->where('status', 0)->where('type', 'fb_groups')->where('active_deactive_status', 1);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_datetime = getNextPostTime("channels_scheduler", $userID, $fbgroup_id, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_datetime;

				$this->Publisher_model->UpdatescheduleOnChannel($primary_id, $post_datetime);
			}
		}

		if ($fbgroup_id) {
			$this->Publisher_model->post_fbgroup_channel_slots($userID, $fbgroup_id, $timeslots);
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function youtube_channel_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$yt_channel_id = $this->post('yt_channel_id');
		$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';
		$count_slots = $this->post('timeslots');
		$timeslots = implode(",", $this->post('timeslots'));
		if (count($count_slots) > 0) {
			$this->Publisher_model->post_youtube_channel_slots($userID, $yt_channel_id, $timeslots);
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function all_channels_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';

		$wheres[0]['key'] = "user_id";
		$wheres[0]['value'] = $userID;
		$params['channel_slots'] = $timeslots;
		$result_b = $this->Publisher_model->update_record_mc('pinterest_boards', $params, $wheres);
		$result_p = $this->Publisher_model->update_record_mc('facebook_pages', $params, $wheres);
		$result_i = $this->Publisher_model->update_record_mc('instagram_users', $params, $wheres);
		$result_fb_g = $this->Publisher_model->update_record_mc('facebook_groups', $params, $wheres);
		$result_yt = $this->Publisher_model->update_record_mc('youtube_channels', $params, $wheres);
		$result_tiktok = $this->Publisher_model->update_record_mc('tiktok', $params, $wheres);
		$count_slots = count($this->post('timeslots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('channels_scheduler')->where('user_id', $userID)->where('status', 0)->where('active_deactive_status', 1)->order_by('type');
			$schedule_posts = $this->db->get()->result();
			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {
				$channel_id = $posts->channel_id;
				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_datetime = getNextPostTime("channels_scheduler", $userID, $channel_id, $timeslots, $for_update);
				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_datetime;
				$this->Publisher_model->UpdatescheduleOnChannel($primary_id, $post_datetime);
			}
		}

		if ($result_b || $result_p || $result_fb_g || $result_i || $result_yt || $result_tiktok) {
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}


	// get_channels_settings
	public function get_channels_settings_GET()
	{
		$userID = App::Session()->get('userid');
		$result = $this->Publisher_model->get_channels_settings($userID);
		if ($result) {
			$this->response(
				[
					'status' => TRUE,
					'data' => $result
				],
				REST_Controller::HTTP_OK
			); // OK (200) being the HTTP response code
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Please try again'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	// fb_channel_active
	public function fb_channel_active_POST()
	{
		$userID = App::Session()->get('userid');
		$channel_id = trim($this->post('channel_id'));

		$result = $this->Publisher_model->fb_channel_active($userID, $channel_id);
		if ($result) {
			$this->response(
				[
					'status' => TRUE,
					'data' => $result
				],
				REST_Controller::HTTP_OK
			); // OK (200) being the HTTP response code
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Please try again'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	// board_channel_active
	public function board_channel_active_POST()
	{
		$userID = App::Session()->get('userid');
		$channel_id = trim($this->post('channel_id'));

		$result = $this->Publisher_model->board_channel_active($userID, $channel_id);
		if ($result) {
			$this->response(
				[
					'status' => TRUE,
					'data' => $result
				],
				REST_Controller::HTTP_OK
			); // OK (200) being the HTTP response code
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Please try again'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function ig_channel_active_POST()
	{
		$userID = App::Session()->get('userid');
		$channel_id = trim($this->post('channel_id'));

		$result = $this->Publisher_model->ig_channel_active($userID, $channel_id);

		if ($result) {
			$this->response(
				[
					'status' => TRUE,
					'data' => $result
				],
				REST_Controller::HTTP_OK
			); // OK (200) being the HTTP response code
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Please try again'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function fbgroup_channel_active_POST()
	{
		$userID = App::Session()->get('userid');
		$channel_id = trim($this->post('channel_id'));

		$result = $this->Publisher_model->fbgroup_channel_active($userID, $channel_id);

		if ($result) {
			$this->response(
				[
					'status' => TRUE,
					'data' => $result
				],
				REST_Controller::HTTP_OK
			); // OK (200) being the HTTP response code
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Please try again'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function yt_channel_active_POST()
	{
		$userID = App::Session()->get('userid');
		$channel_id = trim($this->post('channel_id'));
		$result = $this->Publisher_model->yt_channel_active($userID, $channel_id);
		if ($result) {
			$this->response(
				[
					'status' => TRUE,
					'data' => $result
				],
				REST_Controller::HTTP_OK
			); // OK (200) being the HTTP response code
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'Please try again'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function create_channels_bulkupload_POST()
	{
		$this->sessioncheck();
		$action = trim($this->post('action'));
		if ($action == "schedule") {
			$this->create_channels_bulkupload_inner();
		} elseif ($action == "publish") {
			$this->publish_channels();
		} elseif ($action == "save") {
			$this->save_channels_to_link_2_POST();
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Invalid action defined in the request, please refresh your page and try again',
			), REST_Controller::HTTP_OK);
		}
	}

	public function save_channels_to_link_2_POST()
	{
		$data = [];
		$this->sessioncheck();
		$user_id = App::Session()->get('userid');
		$request_url = $this->post('channel_title');
		$request_url = !empty($request_url) ? cleanString(urlencode($request_url)) : $request_url;
		$images = $_FILES['file'];

		if (empty($request_url)) {
			$this->response(array(
				'status' => false,
				'message' => 'Please enter a valid URL',
			), REST_Controller::HTTP_OK);
		} else {
			$result = $this->metaOfUrl_POST($request_url);
		}

		$site_us_pc = $request_url;
		$parse = parse_url($site_us_pc);
		$domain = $parse['host'];

		$data = [
			'text' => $result['title'],
			'caption' => $result['title'],
			'description' => $result['title'],
			'img' => $result['image'],
			'user_id' => $user_id,
			'site_us_pc' => $site_us_pc,
			'domain' => $domain,
			'status' => 'enable',
			'c_type' => 2,
			'deleted' => 'F'
		];

		if ($this->upload_bulk_image('file')) {
			$upload_data = $this->upload->data();
			$data['img'] = SITEURL . "assets/bulkuploads/" . $upload_data['file_name'];
		}
		$where = ['user_id' => $user_id, 'site_us_pc' => $site_us_pc, 'c_type' => 2];
		$link = $this->Publisher_model->create_or_update_record('link', $data, $where);

		if ($link) {
			resources_update('up', CAMPAIGNS_FEATURE_ID);
			$this->response(['status' => true, 'data' => $link, 'message' => "Campaign Added Successfully "], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function save_channels_to_link_POST()
	{
		$this->sessioncheck();
		$user_id = App::Session()->get('userid');
		$title = trim($this->post('channel_title'));
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$request_url = $this->post('channel_link');
		if (empty($request_url)) {
			$this->response(array(
				'status' => false,
				'message' => 'Please enter a valid URL',
			), REST_Controller::HTTP_OK);
		} else {
			$result = $this->metaOfUrl_POST($request_url);
		}

		if ($title != "") {
			$result['title'] = $title;
		}

		if (empty($result['title']) || empty($result['image'])) {
			$this->response(array(
				'status' => false,
				'message' => 'Please enter a valid URL of a website',
			), REST_Controller::HTTP_OK);
		} else {

			$site_us_pc = $request_url;
			$parse = parse_url($site_us_pc);
			$domain = $parse['host'];

			$data = [
				'text' => $result['title'],
				'caption' => $result['title'],
				'description' => $result['title'],
				'img' => $result['image'],
				'user_id' => $user_id,
				'site_us_pc' => $site_us_pc,
				'domain' => $domain,
				'status' => 'enable',
				'deleted' => 'F'
			];

			$where = ['user_id' => $user_id, 'site_us_pc' => $site_us_pc, 'c_type' => 1];

			$link = $this->Publisher_model->create_or_update_record('link', $data, $where);

			if ($link) {
				resources_update('up', CAMPAIGNS_FEATURE_ID);
				$this->response(['status' => true, 'data' => $link, 'message' => "Campaign Added Successfully"], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			} else {
				//Set the response and exit
				$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
	}

	public function publish_channels_to_link_POST()
	{
		$this->sessioncheck();
		$user_id = App::Session()->get('userid');
		$title = trim($this->post('channel_title'));
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$request_url = $this->post('channel_link');
		$comment = $this->post('channel_comment');
		$comment = !empty($comment) ? cleanString(urlencode($comment)) : $comment;
		$quote = !empty($title) && empty($request_url) ? true : false;
		if (!$quote) {
			if (empty($request_url)) {
				$this->response(array(
					'status' => false,
					'message' => 'Please enter a valid URL',
				), REST_Controller::HTTP_OK);
			} else {
				$result = $this->metaOfUrl_POST($request_url);
			}
		}

		// check for utm codes
		$utm_details = [];
		$utm_check = false;
		if (!$quote) {
			$url_detail = getDomain($request_url);
			if (!empty($url_detail['url'])) {
				$domain = $url_detail['url'];
				$utm_details = getUtm($domain);
				if (count($utm_details) > 0) {
					$utm_check = true;
				}
			}
		}
		// check link and attach utm to title
		$title_utm = [];
		if ($title != "") {
			$url_check = check_for_url($title);
			if ($url_check) {
				$title_utm = utm_check_details($url_check);
			}
			$result['title'] = $title;
		}
		// check link and attach utm to comment
		$comment_utm = [];
		if (!empty($comment)) {
			$url_check = check_for_url($comment);
			if ($url_check) {
				$comment_utm = utm_check_details($url_check);
			}
			$result['comment'] = $comment;
		}

		if (empty($result['title']) && empty($result['image'])) {
			$this->response(array(
				'status' => false,
				'message' => 'Please enter a valid URL of a website',
			), REST_Controller::HTTP_OK);
		} else {
			$active_channels = $this->Publisher_model->get_active_channels_settings($user_id);
			$fbpages = $active_channels['fbpages'];
			$boards = $active_channels['boards'];
			$ig_accounts = $active_channels['ig_accounts'];
			$fb_groups = $active_channels['fb_groups'];
			$tiktoks = $active_channels['tiktoks'];
			$error_array = [];
			$success_array = [];
			if (count($boards) > 0) {
				if (empty($result['image'])) {
					$this->response(array(
						'status' => false,
						'message' => 'No image is provided',
					), REST_Controller::HTTP_OK);
				}
			}
			$size = count($fbpages) + count($boards) + count($ig_accounts) + count($fb_groups) + count($tiktoks);
			if ($size > 0) {
				if (count($boards) > 0) {
					limit_check(POST_PUBLISHING_PIN_ID);
					$dom = new DOMDocument();
					@$dom->loadHTMLFile($request_url);
					$img = $dom->getElementsByTagName('img');
					$greatest_image = '';
					$greatest = 0;
					foreach ($img as $image) {
						$height = $image->getAttribute('height');
						if (!empty($height)) {
							if ($height > $greatest) {
								$greatest = $height;
								$greatest_image = $image->getAttribute('src');
							}
						}
					}
					if (empty($greatest_image)) {
						$greatest_image = $result['image'];
					}
					// check for title length
					// max length 100 characters
					$title_length = 0;
					if (!empty($result['title'])) {
						$title_length = strlen($result['title']);
					}
					if ($title_length >= 100) {
						$post_title = $result['title'];
						$result['title'] = !empty($post_title) ? substr($post_title, 0, 100) : $post_title;
					}
					// check for title length
					foreach ($boards as $board) {
						$wheres = array(
							'user_id' => $user_id
						);
						$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', $wheres);
						// utm check on link
						if ($utm_check) {
							$request_url = make_utm_url($request_url, $utm_details, $pinterest_user['0']->username, 'pinterest');
						}
						// utm check on title
						if (isset($title_utm['utm_check'])) {
							$result['title'] = make_utm_string($result['title'], $title_utm['utm_details'], $pinterest_user['0']->username, 'pinterest');
						}
						$data = [
							'user_id' => $user_id,
							'page_id' => $board['board_id'],
							'type' => 'pinterest',
							'title' => $result['title'],
							'link' => $request_url,
							'image' => $greatest_image,
							'content_type' => 'image_url',
							'published' => 0
						];
						$response = $this->db->insert('publish_posts', $data);
						$pinterest_result = 'Your post(s) are being Published!';
						$removeError = removeCronJobError($user_id, 'pinterest_error');
					}
				}
				if (count($fbpages) > 0) {
					foreach ($fbpages as $page) {
						limit_check(POST_PUBLISHING_FB_ID);
						$bulkupload_limit_check = bulkupload_limit_check($user_id, $page['page_id']);
						if (!$bulkupload_limit_check['status']) {
							$fb_result = $bulkupload_limit_check['message'];
							array_push($error_array, $fb_result);
						} else {
							// utm check on link
							$link = $utm_check ? make_utm_url($request_url, $utm_details, $page['page_name'], 'facebook') : $request_url;
							// utm check on title
							$result['title'] = isset($title_utm['utm_check']) ? make_utm_string($result['title'], $title_utm['utm_details'], $page['page_name'], 'facebook') : $result['title'];
							// utm check on comment
							$comment = isset($comment_utm['utm_check']) ? make_utm_string($comment, $comment_utm['utm_details'], $page['page_name'], 'facebook') : $comment;
							// store request in a cronjob for publishing
							$data = [
								'user_id' => $user_id,
								'page_id' => $page['page_id'],
								'type' => 'facebook',
								'title' => $result["title"],
								'comment' => !empty($comment) ? $comment : '',
								'link' => $link,
								'published' => 0
							];
							$response = $this->db->insert('publish_posts', $data);
							$fb_result = 'Your post(s) are being Published!';
						}
					}
				}
				if (count($fb_groups) > 0) {
					foreach ($fb_groups as $group) {
						$link = $request_url . '?utm_source=facebook';
						$message = $result['title'];
						$fb_group_result = $this->Publisher_model->publish_to_facebook_group($group['group_id'], $link, $message, true);
					}
				}

				if (count($ig_accounts) > 0) {
					foreach ($ig_accounts as $account) {
						$dom = new DOMDocument();
						@$dom->loadHTMLFile($request_url);
						$images = $dom->getElementsByTagName('img');
						$best_image = null;
						foreach ($images as $image) {
							$src = $image->getAttribute('src');
							list($width, $height) = getimagesize($src);
							$aspect_ratio = $width / $height;
							$aspect_ratio = round($aspect_ratio, 2);
							if ($aspect_ratio <= 1.91 && $aspect_ratio >= 4 / 5) {
								$best_image = $src;
								break;
							}
						}
						if ($best_image !== null) {
							// Post to Instagram
							// Step 1 of 2: Create Container
							$container = $this->Publisher_model->create_ig_media_container($account['instagram_id'], $account['access_token'], $best_image, $result['title']);

							if (isset($container['id'])) {
								// Step 2 of 2: Publish Container
								$result = $this->Publisher_model->publish_ig_media_container($user_id, $container['id']);

								if (isset($result['id'])) {
									$ig_result['id'] = $result;
									$removeError = removeCronJobError($user_id, 'instagram_error');
								} else {
									$ig_result['error_'] = 'Your post could not be shared. You can try again with another link.';
								}
							}
						} else {
							$ig_result['error_'] = 'No suitable image found. Your post could not be shared. You can try again with another link.';
						}
					}
				}
				isset($fb_group_result) ? $fb_group_result : $fb_group_result = '';
				isset($ig_result) ? $ig_result : $ig_result = '';

				if (isset($fb_result)) {
					$success_array[] = $fb_result;
				}
				if (isset($fb_group_result)) {
					$success_array[] = $fb_group_result;
				}
				if (isset($pinterest_result)) {
					$success_array[] = $pinterest_result;
				}
				if (isset($ig_result)) {
					$success_array[] = $ig_result;
				}
				// cronjob for publishing Facebook posts
				if (isset($fb_result) && !empty($fb_result)) {
					run_php_background("https://www.adublisher.com/publishFacebookPosts");
				}
				if (isset($pinterest_result) && !empty($pinterest_result)) {
					run_php_background("https://www.adublisher.com/publishPinterestPosts");
				}
				if (count($success_array) > 0 && count($error_array) == 0) {
					$this->response(array(
						'status' => true,
						'message' => 'Your post(s) are being Published!',
						'result' => array(
							'pinterest_result' => isset($pinterest_result) ? $pinterest_result : [],
							'fb_result' => isset($fb_result) ? $fb_result : [],
							'fb_group_result' => isset($fb_group_result) ? $fb_group_result : [],
							'ig_result' => isset($ig_result) ? $ig_result : []
						)
					), REST_Controller::HTTP_OK);
				} else {
					$error_message = '';
					if (isset($pinterest_result)) {
						$error_message = $pinterest_result;
					} else if (isset($fb_result)) {
						$error_message = $fb_result;
					} else if (isset($ig_result)) {
						$error_message = $ig_result;
					}
					$this->response(array(
						'status' => false,
						'message' => $error_message,
						// 'message' => 'Your post did not publish on all channels, please try again later',
						'pinterest_result' => isset($pinterest_result) ? $pinterest_result : '',
						'fb_result' => isset($fb_result) ? $fb_result : '',
						'fb_group_result' => isset($fb_group_result) ? $fb_group_result : '',
						'ig_result' => isset($ig_result) ? $ig_result : ''
					), REST_Controller::HTTP_OK);
				}
			} else {
				$this->response(array(
					'status' => false,
					'message' => 'Please add atleast one channel',
				), REST_Controller::HTTP_OK);
			}
		}
	}

	public function schedule_channels_to_link_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$title = trim($this->post('channel_title'));
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$post_comment = $this->post('channel_comment');
		$post_comment = !empty($post_comment) ? urlencode($post_comment) : $post_comment;
		$request_url = $this->post('channel_link');
		$quote = !empty($title) && empty($request_url) ? true : false;
		if (!$quote) {
			if (empty($request_url)) {
				$this->response(array(
					'status' => false,
					'message' => 'Please enter a valid URL',
				), REST_Controller::HTTP_OK);
			} else {
				$result = $this->metaOfUrl_POST($request_url);
			}
		}
		if ($title != "") {
			$result['title'] = $title;
		}
		$result['post_comment'] = $post_comment;
		if (empty($result['title']) && empty($result['image'])) {
			$this->response(array(
				'status' => false,
				'message' => 'Please enter a valid URL',
			), REST_Controller::HTTP_OK);
		} else {
			$site_us_pc = $request_url;
			// utm check
			if (!empty($site_us_pc)) {
				// check for utm codes
				$utm_details = [];
				$utm_check = false;
				$url_detail = getDomain($request_url);
				if (!empty($url_detail['url'])) {
					$domain = $url_detail['url'];
					$utm_details = getUtm($domain);
					if (count($utm_details) > 0) {
						$utm_check = true;
					}
				}
			}
			// check link and attach utm to title
			$title_utm = [];
			if ($title != "") {
				$url_check = check_for_url($title);
				if ($url_check) {
					$title_utm = utm_check_details($url_check);
				}
			}
			// check link and attach utm to comment
			$comment_utm = [];
			if ($post_comment != "") {
				$url_check = check_for_url($post_comment);
				if ($url_check) {
					$comment_utm = utm_check_details($url_check);
				}
			}

			$active_channels = $this->Publisher_model->get_active_channels_settings($userID);
			$fbpages = $active_channels['fbpages'];
			$boards = $active_channels['boards'];
			$ig_accounts = $active_channels['ig_accounts'];
			$fb_groups = $active_channels['fb_groups'];
			$tiktoks = $active_channels['tiktoks'];

			$size = count($fbpages) + count($boards) + count($ig_accounts) + count($fb_groups) + count($tiktoks);

			if ($size > 0) {
				if (count($fbpages) > 0) {
					foreach ($fbpages as $key => $page) {
						// utm check on link
						if (isset($utm_check)) {
							$site_us_pc = make_utm_url($site_us_pc, $utm_details, $page['page_name'], 'facebook');
						}
						// utm check on title
						if (isset($title_utm['utm_check'])) {
							$result['title'] = make_utm_string($title, $title_utm['utm_details'], $page['page_name'], 'facebook');
						}
						// utm check on comment
						if (isset($comment_utm['utm_check'])) {
							$result['post_comment'] = make_utm_string($post_comment, $comment_utm['utm_details'], $page['page_name'], 'facebook');
						}
						$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $page['id'], $page['channel_slots']);
						$result['image'] = isset($result['image']) ? $result['image'] : '';
						$this_id = $this->Publisher_model->scheduleOnChannel($userID, $page['id'], $result['title'], $result['image'], $site_us_pc, $next_post_date_time, "facebook", $result['post_comment']);
					}
				}
				if (count($boards) > 0) {
					foreach ($boards as $key => $board) {
						// utm check on link
						$pin_user = $this->Publisher_model->get_allrecords('pinterest_users', ['user_id' => $userID]);
						$pin_user = $pin_user[0];
						if ($utm_check) {
							$site_us_pc = make_utm_url($site_us_pc, $utm_details, $pin_user->username, 'pinterest');
						}
						// utm check on title
						if (isset($title_utm['utm_check'])) {
							$result['title'] = make_utm_string($title, $title_utm['utm_details'], $pin_user->username, 'pinterest');
						}

						$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $board['id'], $board['channel_slots']);
						$this_id = $this->Publisher_model->scheduleOnChannel($userID, $board['id'], $result['title'], $result['image'], $site_us_pc, $next_post_date_time, "pinterest");
					}
				}

				if (count($fb_groups) > 0) {
					foreach ($fb_groups as $group) {
						$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $group['id'], $group['channel_slots']);
						$this_id = $this->Publisher_model->scheduleOnChannel($userID, $group['id'], $result['title'], $result['image'], $site_us_pc, $next_post_date_time, "fb_groups", $result['post_comment']);
					}
				}

				if (count($ig_accounts) > 0) {
					foreach ($ig_accounts as $account) {
						$dom = new DOMDocument();
						@$dom->loadHTMLFile($request_url);
						$images = $dom->getElementsByTagName('img');
						$best_image = null;

						foreach ($images as $image) {
							$src = $image->getAttribute('src');
							list($width, $height) = getimagesize($src);
							$aspect_ratio = $width / $height;
							$aspect_ratio = round($aspect_ratio, 2);

							if ($aspect_ratio <= 1.91 && $aspect_ratio >= 4 / 5) {
								$best_image = $src;
								break;
							}
						}

						if ($best_image !== null) {
							// utm check on link
							if ($utm_check) {
								$site_us_pc = make_utm_url($site_us_pc, $utm_details, $account['fb_page_name'], 'instagram');
							}
							// utm check on title
							if (isset($title_utm['utm_check'])) {
								$result['title'] = make_utm_string($title, $title_utm['utm_details'], $account['fb_page_name'], 'instagram');
							}

							$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $account['id'], $account['channel_slots']);
							$this_id = $this->Publisher_model->scheduleOnChannel($userID, $account['id'], $result['title'], $best_image, $site_us_pc, $next_post_date_time, "instagram");
						} else {
							$ig_message = "No appropriate image found for Instagram, please try again with another link";
						}
					}
				}

				if (count($tiktoks) > 0) {
					foreach ($tiktoks as $key => $tiktok) {
						// utm check on title
						if (isset($title_utm['utm_check'])) {
							$title = make_utm_string($title, $title_utm['utm_details'], $tiktok['username'], 'tiktok');
						}
						$image = saveImageFromUrl($result['image'], $userID, $tiktok['id'], strtotime(date('Y-m-d H:i:s')));
						$image = BulkAssets . $image;
						$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $tiktok['id'], $tiktok['channel_slots']);
						$this_id = $this->Publisher_model->scheduleOnChannel($userID, $tiktok['id'], $title, $image, $site_us_pc, $next_post_date_time, "tiktok");
					}
				}

				if ($this_id) {
					$new_result = [];
					$user = $this->Publisher_model->retrieve_record('user', $userID);
					$new_result['id'] = $this_id;
					$new_result['title'] = ucwords(strtolower(stripslashes($result['title'])));
					$new_result['link'] = $result['image'];
					$new_result['post_date'] = utcToLocal($next_post_date_time, $user->gmt, "F j, Y, g:i a");
					$new_result['post_time'] = utcToLocal($next_post_date_time, $user->gmt, "H:i A");

					if (isset($ig_message)) {
						$this->response(array(
							'status' => true,
							'message' => 'Channels scheduled successfully',
							'data' => $new_result,
							'ig_message' => $ig_message,
						), REST_Controller::HTTP_OK);
					} else {
						$this->response(array(
							'status' => true,
							'message' => 'Channels scheduled successfully',
							'data' => $new_result,
						), REST_Controller::HTTP_OK);
					}
				} else {
					$this->response(array(
						'status' => false,
						'message' => 'too large or invalid files are not allowed',
					), REST_Controller::HTTP_OK);
				}
			} else {
				$this->response(array(
					'status' => false,
					'message' => 'Please add atleast one channel',
				), REST_Controller::HTTP_OK);
			}
		}
	}

	public function create_channels_bulkupload_inner()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$title = $this->post('channel_title');
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$comment = $this->post('channel_comment');
		$comment = !empty($comment) ? urlencode($comment) : $comment;
		$site_us_pc = '';
		$active_channels = $this->Publisher_model->get_active_channels_settings($userID);
		$fbpages = $active_channels['fbpages'];
		$boards = $active_channels['boards'];
		$ig_users = $active_channels['ig_accounts'];
		$fb_groups = $active_channels['fb_groups'];
		$tiktoks = $active_channels['tiktoks'];
		$img_path = '';
		$video_path = '';
		// utm checks
		// check link and attach utm to title
		$title_utm = [];
		if ($title != "") {
			$url_check = check_for_url($title);
			if ($url_check) {
				$title_utm = utm_check_details($url_check);
			}
		}
		// check link and attach utm to comment
		$comment_utm = [];
		if ($comment != "") {
			$url_check = check_for_url($comment);
			if ($url_check) {
				$comment_utm = utm_check_details($url_check);
			}
		}

		$size = count($fbpages) + count($boards) + count($ig_users) + count($fb_groups) + count($tiktoks);
		if ($size > 0) {
			$has_video = false;
			$file_type = $_FILES['file']['type'];
			if (strpos($file_type, 'video') !== false) {
				$has_video = true;
				$file_path = move_to_s3_bucket('file');
				if ($file_path['status']) {
					$file_name = $file_path['file_name'];
					$video_path = $file_name;
				} else {
					$this->response([
						'status' => FALSE,
						'message' => $file_path['error']
					], REST_Controller::HTTP_OK);
				}
			} else {
				if ($this->upload_bulk_image('file')) {
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
					$img_path = $file_name;
				}
			}

			if (count($fbpages) > 0) {
				// check post scheduling for Facebook
				limit_check(POST_SCHEDULING_FB_ID);
				foreach ($fbpages as $key => $page) {
					// utm check on title
					if (isset($title_utm['utm_check'])) {
						$title = make_utm_string($title, $title_utm['utm_details'], $page['page_name'], 'facebook');
					}
					// utm check on comment
					if (isset($comment_utm['utm_check'])) {
						$comment = make_utm_string($comment, $comment_utm['utm_details'], $page['page_name'], 'facebook');
					}
					$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $page['id'], $page['channel_slots']);
					$link = $img_path;
					$this_id = $this->Publisher_model->scheduleOnChannel($userID, $page['id'], $title, $img_path, $site_us_pc, $next_post_date_time, 'facebook', $comment, $video_path);
					resources_update('up', POST_SCHEDULING_FB_ID);
				}
			}

			if (count($fb_groups) > 0) {
				foreach ($fb_groups as $group) {
					$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $group['id'], $group['channel_slots']);
					$link = $img_path;
					$this_id = $this->Publisher_model->scheduleOnChannel($userID, $group['id'], $title, $link, $site_us_pc, $next_post_date_time, "fb_groups");
				}
			}

			if (count($boards) > 0) {
				// check post scheduling for Pinterest
				limit_check(POST_SCHEDULING_PIN_ID);
				foreach ($boards as $key => $board) {
					$data = $this->titleWithLink($title);
					$site_us_pc = $data['hasLink'] ? $data['link'] : '';
					$title = $data['hasLink'] ? $data['title'] : $title;
					// utm check on title
					if (isset($title_utm['utm_check'])) {
						$title = make_utm_string($title, $title_utm['utm_details'], $board['username'], 'pinterest');
					}
					// utm check on comment
					if (isset($comment_utm['utm_check'])) {
						$comment = make_utm_string($comment, $comment_utm['utm_details'], $board['username'], 'pinterest');
					}
					$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $board['id'], $board['channel_slots']);
					$link = $img_path;
					$this_id = $this->Publisher_model->scheduleOnChannel($userID, $board['id'], $title, $link, $site_us_pc, $next_post_date_time, "pinterest", '', $video_path);
					resources_update('up', POST_SCHEDULING_PIN_ID);
				}
			}

			if (count($ig_users) > 0) {
				// check post scheduling for Instagram
				limit_check(POST_SCHEDULING_INST_ID);
				foreach ($ig_users as $ig_user) {
					// utm check on title
					if (isset($title_utm['utm_check'])) {
						$title = make_utm_string($title, $title_utm['utm_details'], $ig_user['fb_page_name'], 'instagram');
					}
					// utm check on comment
					if (isset($comment_utm['utm_check'])) {
						$comment = make_utm_string($comment, $comment_utm['utm_details'], $ig_user['fb_page_name'], 'instagram');
					}
					$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $ig_user['id'], $ig_user['channel_slots']);
					$link = $img_path;
					$this_id = $this->Publisher_model->scheduleOnChannel($userID, $ig_user['id'], $title, $link, $site_us_pc, $next_post_date_time, "instagram");
					resources_update('up', POST_SCHEDULING_INST_ID);
				}
			}

			if (count($tiktoks) > 0) {
				foreach ($tiktoks as $tiktok) {
					// utm check on title
					if (isset($title_utm['utm_check'])) {
						$title = make_utm_string($title, $title_utm['utm_details'], $tiktok['username'], 'tiktok');
					}
					// utm check on comment
					if (isset($comment_utm['utm_check'])) {
						$comment = make_utm_string($comment, $comment_utm['utm_details'], $tiktok['username'], 'tiktok');
					}
					$next_post_date_time = getNextPostTime("channels_scheduler", $userID, $tiktok['id'], $tiktok['channel_slots']);
					$link = $img_path;
					$this_id = $this->Publisher_model->scheduleOnChannel($userID, $tiktok['id'], $title, $link, $site_us_pc, $next_post_date_time, "tiktok", '', $video_path);
				}
			}

			if ($this_id) {
				$new_result = [];
				$user = $this->Publisher_model->retrieve_record('user', $userID);
				$new_result['id'] = $this_id;
				$new_result['title'] = ucwords(strtolower(stripslashes($title)));
				$new_result['link'] = !empty($video_path) ? $video_path : $link;
				$new_result['post_date'] = utcToLocal($next_post_date_time, $user->gmt, "F j, Y, g:i a");
				$new_result['post_time'] = utcToLocal($next_post_date_time, $user->gmt, "H:i A");

				$this->response(array(
					'status' => true,
					'data' => $new_result,
					'message' => "File uploaded successfully",
				), REST_Controller::HTTP_OK);
			} else {
				$this->response(array(
					'status' => false,
					'message' => 'too large or invalid files are not allowed',
				), REST_Controller::HTTP_OK);
			}
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Please add atleast one channel',
			), REST_Controller::HTTP_OK);
		}
	}

	public function titleWithLink($title)
	{
		// check if the title contains a link or not
		if (strpos($title, "\n") !== false) {
			$lines = explode("\n", $title);
		} else {
			$lines = array($title);
		}
		$linkRegex = '/https?:\/\/[^\s]+/';
		$link = '';
		$hasLink = false;
		$title_array = [];
		foreach ($lines as $line) {
			if (preg_match($linkRegex, $line)) {
				$hasLink = true;
				$link = $line;
			} else {
				array_push($title_array, $line);
			}
		}
		if (count($title_array) > 1) {
			$title = implode("\n", $title_array);
		} else {
			$title = trim($title_array[0]);
		}
		$data = array(
			'hasLink' => $hasLink,
			'title' => $title,
			'link' => $link,
		);
		return $data;
		// check if the title contains a link or not
	}

	public function publish_channels()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$title = $this->post('channel_title');
		$title = !empty($title) ? cleanString(urlencode($title)) : $title;
		$comment = $this->post('channel_comment');
		// check link and attach utm to title
		$title_utm = [];
		if ($title != "") {
			$url_check = check_for_url($title);
			if ($url_check) {
				$title_utm = utm_check_details($url_check);
			}
		}
		// check link and attach utm to comment
		$comment_utm = [];
		if ($comment != "") {
			$url_check = check_for_url($comment);
			if ($url_check) {
				$comment_utm = utm_check_details($url_check);
			}
		}

		$active_channels = $this->Publisher_model->get_active_channels_settings($userID);
		$fbpages = $active_channels['fbpages'];
		$boards = $active_channels['boards'];
		$ig_users = $active_channels['ig_accounts'];
		$fb_groups = $active_channels['fb_groups'];
		$tiktoks = $active_channels['tiktoks'];
		$this_id = false;
		$success_message = array();
		$error_message = array();
		$upload_data = [];
		$video_path = '';
		$img_path = '';
		$has_video = false;
		$file_type = $_FILES['file']['type'];
		if (strpos($file_type, 'video') !== false) {
			$has_video = true;
			$file_path = move_to_s3_bucket('file');
			if ($file_path['status']) {
				$file_name = $file_path['file_name'];
				$video_path = $file_name;
			} else {
				$this->response([
					'status' => FALSE,
					'message' => $file_path['error']
				], REST_Controller::HTTP_OK);
			}
		} else {
			if ($this->upload_bulk_image('file')) {
				$upload_data = $this->upload->data();
				$file_path = $upload_data['file_path'];
				$file_name = $upload_data['file_name'];
				$img_path = $file_path . $file_name;
			} else {
				$this->response(array(
					'status' => false,
					'message' => $this->upload->display_errors() . 'there is something wrong with this specific image',
				), REST_Controller::HTTP_OK);
			}
		}
		// Publish on Pinterest
		if (count($boards) > 0) {
			foreach ($boards as $board) {
				limit_check(POST_PUBLISHING_PIN_ID);
				$wheres = array('user_id' => $userID);
				$pinterest_user = $this->Publisher_model->get_allrecords('pinterest_users', $wheres);
				// check if the title contains a link or not
				if (strpos($title, "\n") !== false) {
					$lines = explode("\n", $title);
				} else {
					$lines = array($title);
				}
				$linkRegex = '/https?:\/\/[^\s]+/';
				$link = '';
				$hasLink = false;
				$title_array = [];
				foreach ($lines as $line) {
					if (preg_match($linkRegex, $line)) {
						$hasLink = true;
						$link = $line;
					} else {
						array_push($title_array, $line);
					}
				}
				if (count($title_array) > 1) {
					$title = implode("\n", $title_array);
				} else {
					$title = trim($title_array[0]);
				}
				// check if the title contains a link or not
				if ($hasLink) {
					$request_url = $link;
					// check for utm codes
					$utm_details = [];
					$utm_check = false;
					$url_detail = getDomain($request_url);
					if (!empty($url_detail['url'])) {
						$domain = $url_detail['url'];
						$utm_details = getUtm($domain);
						if (count($utm_details) > 0) {
							$utm_check = true;
						}
					}
					if ($utm_check) {
						$link = make_utm_url($request_url, $utm_details, $pinterest_user['0']->username, 'pinterest');
					} else {
						$link = $link . '?utm_source=pinterest';
					}
				}
				// utm check on title
				if (isset($title_utm['utm_check'])) {
					$title = make_utm_string($title, $title_utm['utm_details'], $pinterest_user['0']->username, 'pinterest');
				}
				$data = [
					'user_id' => $userID,
					'page_id' => $board['board_id'],
					'type' => 'pinterest',
					'title' => $title,
					'link' => $hasLink ? $link : '',
					'image' => $img_path,
					'video_path' => $video_path,
					'content_type' => !empty($img_path) ? 'image_path' : 'video_path',
					'published' => 0
				];
				$pinterest_response = $this->db->insert('publish_posts', $data);
				if ($pinterest_response) {
					$success_message[] = "Your post(s) are being Published!";
					// $removeError = removeCronJobError($userID, 'pinterest_error');
				} else {
					$error_message[] = "Failed to publish on Pinterest.";
				}
			}
		}
		// Publish on Facebook Pages
		if (count($fbpages) > 0) {
			foreach ($fbpages as $page) {
				limit_check(POST_PUBLISHING_FB_ID);
				// check for daily published posts limit
				$bulkupload_limit_check = bulkupload_limit_check($userID, $page['page_id']);
				if (!$bulkupload_limit_check['status']) {
					$error_message[] = $bulkupload_limit_check['message'];
				} else {
					// utm check on title
					if (isset($title_utm['utm_check'])) {
						$title = make_utm_string($title, $title_utm['utm_details'], $page['page_name'], 'facebook');
					}
					// utm check on comment
					if (isset($comment_utm['utm_check'])) {
						$comment = make_utm_string($comment, $comment_utm['utm_details'], $page['page_name'], 'facebook');
					}
					// store request in a cronjob for publishing
					$file_name = $has_video ? $file_name : '';
					$data = [
						'user_id' => $userID,
						'page_id' => $page['page_id'],
						'type' => 'facebook',
						'title' => $title,
						'comment' => $comment,
						'image' => $file_name,
						'video_path' => $video_path,
						'published' => 0
					];
					$facebook_response = $this->db->insert('publish_posts', $data);
					if ($facebook_response) {
						$success_message[] = "Your post(s) are being Published!";
						// $removeError = removeCronJobError($userID, 'facebook_page_error');
					} else {
						$error_message[] = "Failed to publish on Facebook.";
					}
				}
			}
		}
		// Publish on TikTok Account
		if (count($tiktoks) > 0) {
			foreach ($tiktoks as $tiktok) {
				// limit_check(POST_PUBLISHING_FB_ID);
				// utm check on title
				if (isset($title_utm['utm_check'])) {
					$title = make_utm_string($title, $title_utm['utm_details'], $tiktok['username'], 'type');
				}
				// utm check on comment
				if (isset($comment_utm['utm_check'])) {
					$comment = make_utm_string($comment, $comment_utm['utm_details'], $tiktok['username'], 'type');
				}
				// store request in a cronjob for publishing
				$file_name = $has_video ? $file_name : '';
				$data = [
					'user_id' => $userID,
					'page_id' => $tiktok['open_id'],
					'type' => 'tiktok',
					'title' => $title,
					'comment' => $comment,
					'image' => $file_name,
					'video_path' => $video_path,
					'published' => 0
				];
				$tiktok_response = $this->db->insert('publish_posts', $data);
				if ($tiktok_response) {
					$success_message[] = "Your post(s) are being Published!";
				} else {
					$error_message[] = "Failed to publish on Tiktok.";
				}
			}
		}
		$image_path = SITEURL . "assets/bulkuploads/" . $file_name;
		// Publish on Instagram Accounts
		if (count($ig_users) > 0) {
			// Check the ratio of the image
			if (empty($video_path)) {
				$aspect_ratio = $upload_data['image_width'] / $upload_data['image_height'];
				$aspect_ratio = round($aspect_ratio, 2);
				if ($aspect_ratio <= 1.91 && $aspect_ratio >= 4 / 5) {
					foreach ($ig_users as $ig_user) {
						if ($has_video) {
							continue;
						}
						limit_check(POST_PUBLISHING_INST_ID);
						$data = [
							'user_id' => $userID,
							'page_id' => $ig_user['instagram_id'],
							'type' => 'instagram',
							'title' => $title,
							'image' => $image_path,
							'published' => 0
						];
						$instagram_response = $this->db->insert('publish_posts', $data);
						if ($instagram_response) {
							$success_message[] = "Your post(s) are being Published!";
						} else {
							$error_message[] = "Failed to publish on Instagram.";
						}
					}
				} else {
					$error_message[] = "Insatagram:- The image aspect ratio is not within the required range.";
				}
			} else {
				foreach ($ig_users as $ig_user) {
					limit_check(POST_PUBLISHING_INST_ID);
					$data = [
						'user_id' => $userID,
						'page_id' => $ig_user['instagram_id'],
						'type' => 'instagram',
						'title' => $title,
						'image' => '',
						'video_path' => $video_path,
						'published' => 0
					];
					$instagram_response = $this->db->insert('publish_posts', $data);
					if ($instagram_response) {
						$success_message[] = "Your post(s) are being Published!";
					} else {
						$error_message[] = "Failed to publish on Instagram.";
					}
				}
			}
		}
		// cronjob for publishing facebook posts
		if (isset($facebook_response)) {
			run_php_background("https://www.adublisher.com/publishFacebookPosts");
		}
		// cronjob for publishing pinterest posts
		if (isset($pinterest_response)) {
			run_php_background("https://www.adublisher.com/publishPinterestPosts");
		}
		// cronjob for publishing tiktok posts
		if (isset($tiktok_response)) {
			run_php_background("https://www.adublisher.com/publishTiktokPosts");
		}
		// cronjob for publishing instagram posts
		if (isset($instagram_response)) {
			run_php_background("https://www.adublisher.com/publishInstagramPosts");
		}
		// Return response based on success or error message
		if (count($success_message) > 0 && count($error_message) == 0) {
			$this->response(array(
				'status' => true,
				'message' => $success_message,
			), REST_Controller::HTTP_OK);
		} elseif (count($error_message) > 0 && count($success_message) == 0) {
			$this->response(array(
				'status' => false,
				'message' => $error_message,
			), REST_Controller::HTTP_OK);
		} elseif (count($success_message) > 0 && count($error_message) > 0) {
			$this->response(array(
				'status' => false,
				'message' => array_merge($success_message, $error_message),
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => "Please add atleast one channel <br> Or Something went wrong. Please try again later.",
			), REST_Controller::HTTP_OK);
		}
	}

	public function createOrUpdateYoutube($data)
	{
		$userid = App::Session()->get('userid');
		$query = $this->db->get_where('youtube_settings', ['user_id' => $userid]);
		$updatedData = array(
			'description' => $data['video_description'],
			'tags' => $data['tags'],
			'category_id' => $data['video_category'],
			'privacy' => $data['privacyStatus'],
			'for_kids' => $data['kids'],
		);
		if (!empty($query->row())) {
			$this->db->update('youtube_settings', $updatedData, ['user_id' => $userid]);
		} else {
			$updatedData['user_id'] = $userid;
			$this->db->insert('youtube_settings', $updatedData);
		}
		return true;
	}

	public function upload_to_youtube_POST()
	{
		// make data array
		$action = $this->post('action');
		$data['video_title'] = $this->post('video_title');
		$data['video_description'] = $this->post('video_description');
		$data['video_category'] = $this->post('video_category');
		$data['privacyStatus'] = $this->post('privacyStatus');
		$data['kids'] = $this->post('kids');
		$data['video_path'] = $this->post('video_path');
		$data['thumbnail'] = isset($_FILES['thumbnail']) ? $_FILES['thumbnail']['name'] : '';
		$data['tags'] = $this->post('tags');
		if ($action == 'publish') {
			limit_check(POST_PUBLISHING_YT_ID);
		} elseif ($action == 'schedule') {
			limit_check(POST_SCHEDULING_YT_ID);
		}
		// check thumbnail size
		// max thumbnail size is 2Mb
		$max_size = 2 * 1024;
		$thumbnail_size = isset($_FILES['thumbnail']) ? ($_FILES['thumbnail']['size'] / 1024) : '';
		if (!empty($thumbnail_size)) {
			if ($thumbnail_size >= $max_size) {
				return $this->response(array(
					'status' => false,
					'message' => "Max file size for thumbnail is 2Mb",
				), REST_Controller::HTTP_OK);
			}
		}
		// create or update youtube settings
		$this->createOrUpdateYoutube($data);
		// publish video to YouTube
		if ($action == "publish") {
			$response = $this->publish_youtube_video($data);
			if ($response['status']) {
				$this->response(array(
					'status' => true,
					'message' => 'Your video has been published to YouTube successfully!',
				), REST_Controller::HTTP_OK);
			} else {
				$this->response(array(
					'status' => false,
					'message' => $response['error'],
				), REST_Controller::HTTP_OK);
			}
		}
		if ($action == "schedule") {
			$response = $this->schedule_youtube_video($data);
			if ($response['status']) {
				$this->response(array(
					'status' => true,
					'message' => $response['message'],
				), REST_Controller::HTTP_OK);
			} else {
				$this->response(array(
					'status' => false,
					'message' => $response['error'],
				), REST_Controller::HTTP_OK);
			}
		}
	}

	public function publish_youtube_video($data)
	{
		// get auth user from session
		$user_id = App::Session()->get('userid');
		$thumbnail = $data['thumbnail'];
		// key of file in s3 bucket
		$s3_key = $data['video_path'];
		$file = get_from_s3bucket($s3_key);
		if ($file['status']) {
			$file_name = $file['file_name'];
		} else {
			return array(
				'status' => 'false',
				'error' => 'Error processing Video!'
			);
		}
		$thumbnail_name = '';
		// get active YouTube channels
		$active_channels = $this->Publisher_model->get_active_channels_settings($user_id);
		$yt_channels = $active_channels['yt_channels'];
		$success_message = [];
		$error_message = [];
		if (count($yt_channels) > 0) {
			if (!empty($thumbnail)) {
				// move thumbnail to server assets folder
				if ($thumbnail_data = $this->move_thumbnail_to_server($thumbnail)) {
					// get saved thumbnail from asset folder
					$thumbnail_name = $thumbnail_data['file_name'];
				} else {
					return array(
						'status' => false,
						'error' => 'Some problem occured!'
					);
				}
			}
			foreach ($yt_channels as $key => $channel) {
				// check link and attach utm to title
				$title_utm = [];
				if ($data['video_title'] != "") {
					$url_check = check_for_url($data['video_title']);
					if ($url_check) {
						$title_utm = utm_check_details($url_check);
					}
				}
				// utm check on title
				if (count($title_utm) > 0 && $title_utm['utm_check']) {
					$data['video_title'] = make_utm_string($data['video_title'], $title_utm['utm_details'], $channel['channel_title'], 'youtube');
				}
				// check link and attach utm to description
				$description_utm = [];
				if ($data['video_description'] != "") {
					$url_check = check_for_url($data['video_description']);
					if ($url_check) {
						$description_utm = utm_check_details($url_check);
					}
				}
				// utm check on comment
				if (count($description_utm) > 0 && $description_utm['utm_check']) {
					$data['video_description'] = make_utm_string($data['video_description'], $description_utm['utm_details'], $channel['channel_title'], 'youtube');
				}

				// publish video to YouTuve channel(s)

				$google_id = $channel['google_id'];
				$access_token = fetch_channel_access_token($google_id);
				$publish_response = $this->Publisher_model->publish_video($data, $file_name, $thumbnail_name, $access_token);
				if ($publish_response['status']) {
					resources_update('up', POST_PUBLISHING_YT_ID);
					$success_message[] = "Video published to YouTube successfully.";
				} else {
					$error_message[] = $publish_response['error'];
				}
			}
			// delete path for removing video after upload
			remove_file($file_name);
			// delete thumbanail
			remove_file($thumbnail_name);
			// remove video from s3 bucket
			remove_from_s3bucket($s3_key);
		} else {
			return array(
				'status' => false,
				'error' => "Please add atleast one channel <br> Or Something went wrong. Please try again later.",
			);
		}

		if (count($success_message) > 0 && count($error_message) == 0) {
			return array(
				'status' => true,
				'error' => $success_message,
			);
		} elseif (count($success_message) == 0 && count($error_message) > 0) {
			return array(
				'status' => false,
				'error' => $error_message,
			);
		} elseif (count($success_message) > 0 && count($error_message) > 0) {
			return array(
				'status' => false,
				'error' => array_merge($success_message, $error_message),
			);
		}
	}

	public function schedule_youtube_video($data)
	{
		$user_id = App::Session()->get('userid');
		$active_channels = $this->Publisher_model->get_active_channels_settings($user_id);
		$yt_channels = $active_channels['yt_channels'];
		if ($yt_channels) {
			// save thumbnail to server
			if ($thumbnail_data = $this->move_thumbnail_to_server($data['thumbnail'])) {
				$thumbnail_name = $thumbnail_data['file_name'];
			} else {
				return array(
					'status' => false,
					'error' => 'Some problem occured upload the Thumbnail!'
				);
			}
			$data['thumbnail_link'] = $thumbnail_name;
			foreach ($yt_channels as $key => $channel) {
				$next_post_date_time = getNextPostTime("youtube_scheduler", $user_id, $channel['id'], $channel['channel_slots']);
				$schedule = $this->Publisher_model->schedule_video_to_youtube($channel['id'], $data, $next_post_date_time);
				if ($schedule) {
					resources_update('up', POST_SCHEDULING_YT_ID);
					return array(
						'status' => true,
						'message' => 'Video has been scheduled to YouTube successfully!'
					);
				} else {
					return array(
						'status' => false,
						'error' => 'Some problem occured!!'
					);
				}
			}
		} else {
			return array(
				'status' => false,
				'error' => 'No YouTube channel selected!'
			);
		}
	}

	public function move_video_to_server_POST()
	{
		$this->sessioncheck();
		$file_path = move_to_s3_bucket('file');
		if ($file_path['status']) {
			$this->response(array(
				'status' => true,
				'message' => $file_path['file_name'],
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => $file_path['error'],
			), REST_Controller::HTTP_OK);
		}
	}

	public function move_thumbnail_to_server($file)
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$this->load->library('upload');
		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/";
		} else {
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/";
		}

		$config['allowed_types'] = 'image/jpg|image/JPG|image/jpeg|image/JPEG|image/png|image/PNG|jpg|jpeg|png';
		$config['max_size'] = '102400';
		$config['overwrite'] = false;
		$config['file_name'] = $userID . "_" . time() . "_" . $file;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('thumbnail')) {
			$error = array('error' => $this->upload->display_errors());
			$response = array(
				'status' => false,
				'error' => $error
			);
		} else {
			$response = $this->upload->data();
		}
		return $response;
	}

	public function get_channels_scheduled_GET()
	{
		$this->sessioncheck();
		$channel = trim($this->get('channel'));
		$type = $this->get('type');
		$user_id = App::Session()->get('userid');
		$channels = [];
		if ($channel == "all") {
			$where_e[0]['key'] = 'user_id';
			$where_e[0]['value'] = $user_id;
			$where_e[1]['key'] = 'status';
			$where_e[1]['value'] = array(0, -1);
			$where_e[2]['key'] = 'active_deactive_status';
			$where_e[2]['value'] = 1;
			$channels = $this->Publisher_model->list_records('channels_scheduler', 0, 20, $where_e, 'post_datetime', 'asc');
		} else {
			$where_e[0]['key'] = 'channel_id';
			$where_e[0]['value'] = $channel;
			$where_e[1]['key'] = 'user_id';
			$where_e[1]['value'] = $user_id;
			$where_e[1]['key'] = 'type';
			$where_e[1]['value'] = $type;
			$where_e[2]['key'] = 'status';
			$where_e[2]['value'] = array(0, -1);
			$where_e[3]['key'] = 'active_deactive_status';
			$where_e[3]['value'] = 1;
			$channels = $this->Publisher_model->list_records('channels_scheduler', 0, 20, $where_e, 'post_datetime', 'asc');
		}
		// get youtube scheduled
		$yt_where = array(
			[
				'key' => 'user_id',
				'value' => $user_id
			],
			[
				'key' => 'published',
				'value' => array(0, -1)
			],
		);
		$yt_scheduled = $this->Publisher_model->list_records('youtube_scheduler', 0, 20, $yt_where, 'publish_datetime', 'asc');
		if ($channels || $yt_scheduled) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			$user_channels = $this->Publisher_model->get_channels_settings($user_id);
			$fbpages = $user_channels['fbpages'];
			$boards = $user_channels['boards'];
			$ig_accounts = $user_channels['ig_accounts'];
			$fb_groups = $user_channels['fb_groups'];
			$yt_channels = $user_channels['yt_channels'];
			$tiktoks = $user_channels['tiktoks'];

			foreach ($channels as $key => $row) {
				if ($row->type == "pinterest" && empty($boards)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "facebook" && empty($fbpages)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "instagram" && empty($ig_accounts)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "fb_groups" && empty($fb_groups)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "tiktok" && empty($tiktoks)) {
					// Skip items of type 'tiktok' when $boards is empty
					continue;
				}

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['channel_id'] = $row->channel_id;

				if ($row->type == "facebook") {
					if (!empty($fbpages)) {
						$key_search = array_search($row->channel_id, array_column($fbpages, 'id'));
						$new_result[$key]['channel_name'] = $fbpages[$key_search]['page_name'];
					} else {
						continue;
					}
				} else if ($row->type == "pinterest") {
					if (!empty($boards)) {
						$key_search = array_search($row->channel_id, array_column($boards, 'id'));
						$new_result[$key]['channel_name'] = $boards[$key_search]['name'];
					} else {
						continue;
					}
				} else if ($row->type == "instagram") {
					if (!empty($ig_accounts)) {
						$key_search = array_search($row->channel_id, array_column($ig_accounts, 'id'));
						$new_result[$key]['channel_name'] = $ig_accounts[$key_search]['instagram_username'];
					} else {
						continue;
					}
				} else if ($row->type == "fb_groups") {
					if (!empty($fb_groups)) {
						$key_search = array_search($row->channel_id, array_column($fb_groups, 'id'));
						$new_result[$key]['channel_name'] = $fb_groups[$key_search]['name'];
					} else {
						continue;
					}
				} else if ($row->type == "tiktok") {
					if (!empty($tiktoks)) {
						$key_search = array_search($row->channel_id, array_column($tiktoks, 'id'));
						$new_result[$key]['channel_name'] = $tiktoks[$key_search]['username'];
					} else {
						continue;
					}
				} else {
					$new_result[$key]['channel_name'] = "N/A";
				}
				$new_result[$key]['title'] = ucwords(strtolower(stripslashes(urldecode($row->post_title))));
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['link_type'] = "full";
				$pos = strpos($row->link, 'http');
				if ($pos === false) {
					$new_result[$key]['link_type'] = "partial";
				}
				$new_result[$key]['type'] = $row->type;
				$new_result[$key]['post_day'] = utcToLocal($row->post_datetime, $user->gmt, "l");
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "d F, Y");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "g:i a");
				$new_result[$key]['status'] = $row->status;
				$new_result[$key]['message'] = $row->response;
			}
			foreach ($yt_scheduled as $yt_key => $yt_row) {
				if (empty($yt_channels)) {
					continue;
				}
				$yt_record = [];
				$yt_key_search = array_search($yt_row->channel_id, array_column($yt_channels, 'id'));
				$yt_record = array(
					'id' => $yt_row->id,
					'channel_id' => $yt_row->channel_id,
					'channel_name' => $yt_channels[$yt_key_search]['channel_title'],
					'title' => $yt_row->video_title,
					'link' => $yt_row->thumbnail_link,
					'link_type' => 'partial',
					'type' => 'youtube',
					'post_day' => utcToLocal($yt_row->publish_datetime, $user->gmt, "l"),
					'post_date' => utcToLocal($yt_row->publish_datetime, $user->gmt, "d F, Y"),
					'post_time' => utcToLocal($yt_row->publish_datetime, $user->gmt, "g:i a"),
					'status' => $yt_row->published
				);
				array_push($new_result, $yt_record);
			}

			$this->response(['status' => true, 'data' => $new_result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function refresh_channels_scheduled_GET()
	{
		$user_id = App::Session()->get('userid');
		$channel = $this->get('channel');
		$type = $this->get('type');
		$rss_table = 'channels_scheduler';
		$status_column = 'status';
		$id_column = $type;
		$page = 'all';
		if ($channel != 'all') {
			if ($type == 'facebook') {
				$page = $this->Publisher_model->retrieve_record('facebook_pages', $channel);
			} else if ($type == 'pinterest') {
				$page = $this->Publisher_model->retrieve_record('pinterest_boards', $channel);
			} else if ($type == 'instagram') {
				$page = $this->Publisher_model->retrieve_record('instagram_users', $channel);
			} else if ($type == 'tiktok') {
				$page = $this->Publisher_model->retrieve_record('tiktok', $channel);
			} else if ($type == 'youtube') {
				$page = $this->Publisher_model->retrieve_record('youtube_channels', $channel);
			}
		}
		if ($page) {
			$timeslots = $page == 'all' ? '' : $page->channel_slots;
			$data = [
				'user_id' => $user_id,
				'page_id' => $channel == 'all' ? 'all' : $channel,
				'timeslots' => $timeslots,
				'rss_table' => $rss_table,
				'id_column' => $id_column,
				'status_column' => $status_column,
				'published' => 0
			];
			$this->db->insert('refresh_feeds', $data);
			run_php_background("https://www.adublisher.com/refreshRssFeed");
			// refresh_posts($page_id, $timeslots, $rss_table, $id_column, $status_column);
			$this->response(['status' => true, 'data' => 'Your Feed is being refreshed!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			$this->response(['status' => false, 'data' => 'Something went wrong!'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
	}

	public function load_more_channels_scheduled_GET()
	{
		$this->sessioncheck();
		$channel = trim($this->get('channel'));
		$type = $this->get('type');
		$user_id = App::Session()->get('userid');
		$offset = $this->get('offset');
		$channels = [];
		if ($channel == "all") {

			$where_e[0]['key'] = 'user_id';
			$where_e[0]['value'] = $user_id;
			$where_e[1]['key'] = 'status';
			$where_e[1]['value'] = array(0, -1);
			$where_e[2]['key'] = 'active_deactive_status';
			$where_e[2]['value'] = 1;
			$channels = $this->Publisher_model->list_records('channels_scheduler', $offset, 20, $where_e, 'post_datetime', 'asc');
		} else {
			$where_e[0]['key'] = 'channel_id';
			$where_e[0]['value'] = $channel;
			$where_e[1]['key'] = 'user_id';
			$where_e[1]['value'] = $user_id;
			$where_e[1]['key'] = 'type';
			$where_e[1]['value'] = $type;
			$where_e[2]['key'] = 'status';
			$where_e[2]['value'] = array(0, -1);
			$where_e[3]['key'] = 'active_deactive_status';
			$where_e[3]['value'] = 1;
			$channels = $this->Publisher_model->list_records('channels_scheduler', $offset, 20, $where_e, 'post_datetime', 'asc');
		}
		// get youtube scheduled
		$yt_where = array(
			[
				'key' => 'user_id',
				'value' => $user_id
			],
			[
				'key' => 'published',
				'value' => array(0, -1)
			],
		);
		$yt_scheduled = $this->Publisher_model->list_records('youtube_scheduler', $offset, 20, $yt_where, 'publish_datetime', 'asc');
		if ($channels || $yt_scheduled) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			$user_channels = $this->Publisher_model->get_channels_settings($user_id);
			$fbpages = $user_channels['fbpages'];
			$boards = $user_channels['boards'];
			$ig_accounts = $user_channels['ig_accounts'];
			$fb_groups = $user_channels['fb_groups'];
			$yt_channels = $user_channels['yt_channels'];

			foreach ($channels as $key => $row) {
				if ($row->type == "pinterest" && empty($boards)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "facebook" && empty($fbpages)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "instagram" && empty($ig_accounts)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "fb_groups" && empty($fb_groups)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['channel_id'] = $row->channel_id;

				if ($row->type == "facebook") {
					if (!empty($fbpages)) {
						$key_search = array_search($row->channel_id, array_column($fbpages, 'id'));
						$new_result[$key]['channel_name'] = $fbpages[$key_search]['page_name'];
					} else {
						continue;
					}
				} else if ($row->type == "pinterest") {
					if (!empty($boards)) {
						$key_search = array_search($row->channel_id, array_column($boards, 'id'));
						$new_result[$key]['channel_name'] = $boards[$key_search]['name'];
					} else {
						continue;
					}
				} else if ($row->type == "instagram") {
					if (!empty($ig_accounts)) {
						$key_search = array_search($row->channel_id, array_column($ig_accounts, 'id'));
						$new_result[$key]['channel_name'] = $ig_accounts[$key_search]['instagram_username'];
					} else {
						continue;
					}
				} else if ($row->type == "fb_groups") {
					if (!empty($fb_groups)) {
						$key_search = array_search($row->channel_id, array_column($fb_groups, 'id'));
						$new_result[$key]['channel_name'] = $fb_groups[$key_search]['name'];
					} else {
						continue;
					}
				} else {
					$new_result[$key]['channel_name'] = "N/A";
				}
				$new_result[$key]['title'] = ucwords(strtolower(stripslashes($row->post_title)));
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['link_type'] = "full";
				$pos = strpos($row->link, 'http');
				if ($pos === false) {
					$new_result[$key]['link_type'] = "partial";
				}
				$new_result[$key]['type'] = $row->type;
				$new_result[$key]['post_day'] = utcToLocal($row->post_datetime, $user->gmt, "l");
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "d F, Y");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "g:i a");
				$new_result[$key]['status'] = $row->status;
				$new_result[$key]['message'] = $row->response;
			}
			foreach ($yt_scheduled as $yt_key => $yt_row) {
				if (empty($yt_channels)) {
					continue;
				}
				$yt_record = [];
				$yt_key_search = array_search($yt_row->channel_id, array_column($yt_channels, 'id'));
				$yt_record = array(
					'id' => $yt_row->id,
					'channel_id' => $yt_row->channel_id,
					'channel_name' => $yt_channels[$yt_key_search]['channel_title'],
					'title' => $yt_row->video_title,
					'link' => $yt_row->thumbnail_link,
					'link_type' => 'partial',
					'type' => 'youtube',
					'post_day' => utcToLocal($yt_row->publish_datetime, $user->gmt, "l"),
					'post_date' => utcToLocal($yt_row->publish_datetime, $user->gmt, "d F, Y"),
					'post_time' => utcToLocal($yt_row->publish_datetime, $user->gmt, "g:i a"),
					'status' => $yt_row->published
				);
				array_push($new_result, $yt_record);
			}

			$this->response(['status' => true, 'data' => $new_result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function get_published_channels_scheduled_GET()
	{
		$this->sessioncheck();
		$channel = trim($this->get('channel'));
		$type = $this->get('type');
		$user_id = App::Session()->get('userid');
		$channels = [];
		if ($channel == "all") {

			$where_e[0]['key'] = 'user_id';
			$where_e[0]['value'] = $user_id;
			$where_e[1]['key'] = 'status';
			$where_e[1]['value'] = 1;
			$where_e[2]['key'] = 'active_deactive_status';
			$where_e[2]['value'] = 1;
			$channels = $this->Publisher_model->list_records('channels_scheduler', 0, 100000, $where_e, 'post_datetime', 'DESC');
		} else {
			$where_e[0]['key'] = 'channel_id';
			$where_e[0]['value'] = $channel;
			$where_e[1]['key'] = 'user_id';
			$where_e[1]['value'] = $user_id;
			$where_e[1]['key'] = 'type';
			$where_e[1]['value'] = $type;
			$where_e[2]['key'] = 'status';
			$where_e[2]['value'] = 1;
			$where_e[3]['key'] = 'active_deactive_status';
			$where_e[3]['value'] = 1;
			$channels = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_e, 'post_datetime', 'DESC');
		}
		// get youtube scheduled
		$yt_where = array(
			[
				'key' => 'user_id',
				'value' => $user_id
			],
			[
				'key' => 'published',
				'value' => 1
			],
		);
		$yt_scheduled = $this->Publisher_model->list_records('youtube_scheduler', 0, 10000, $yt_where, 'publish_datetime', 'asc');
		if ($channels || $yt_scheduled) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			$user_channels = $this->Publisher_model->get_channels_settings($user_id);
			$fbpages = $user_channels['fbpages'];
			$boards = $user_channels['boards'];
			$ig_accounts = $user_channels['ig_accounts'];
			$fb_groups = $user_channels['fb_groups'];
			$yt_channels = $user_channels['yt_channels'];

			foreach ($channels as $key => $row) {
				if ($row->type == "pinterest" && empty($boards)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "facebook" && empty($fbpages)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "instagram" && empty($ig_accounts)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}
				if ($row->type == "fb_groups" && empty($fb_groups)) {
					// Skip items of type 'pinterest' when $boards is empty
					continue;
				}

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['channel_id'] = $row->channel_id;

				if ($row->type == "facebook") {
					if (!empty($fbpages)) {
						$key_search = array_search($row->channel_id, array_column($fbpages, 'id'));
						$new_result[$key]['channel_name'] = $fbpages[$key_search]['page_name'];
					} else {
						continue;
					}
				} else if ($row->type == "pinterest") {
					if (!empty($boards)) {
						$key_search = array_search($row->channel_id, array_column($boards, 'id'));
						$new_result[$key]['channel_name'] = $boards[$key_search]['name'];
					} else {
						continue;
					}
				} else if ($row->type == "instagram") {
					if (!empty($ig_accounts)) {
						$key_search = array_search($row->channel_id, array_column($ig_accounts, 'id'));
						$new_result[$key]['channel_name'] = $ig_accounts[$key_search]['instagram_username'];
					} else {
						continue;
					}
				} else if ($row->type == "fb_groups") {
					if (!empty($fb_groups)) {
						$key_search = array_search($row->channel_id, array_column($fb_groups, 'id'));
						$new_result[$key]['channel_name'] = $fb_groups[$key_search]['name'];
					} else {
						continue;
					}
				} else {
					$new_result[$key]['channel_name'] = "N/A";
				}
				$new_result[$key]['title'] = ucwords(strtolower(stripslashes($row->post_title)));
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['link_type'] = "full";
				$pos = strpos($row->link, 'http');
				if ($pos === false) {
					$new_result[$key]['link_type'] = "partial";
				}
				$new_result[$key]['type'] = $row->type;
				$new_result[$key]['post_day'] = utcToLocal($row->post_datetime, $user->gmt, "l");
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "d F, Y");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "g:i a");
			}
			foreach ($yt_scheduled as $yt_key => $yt_row) {
				if (empty($yt_channels)) {
					continue;
				}
				$yt_record = [];
				$yt_key_search = array_search($yt_row->channel_id, array_column($yt_channels, 'id'));
				$yt_record = array(
					'id' => $yt_row->id,
					'channel_id' => $yt_row->channel_id,
					'channel_name' => $yt_channels[$yt_key_search]['channel_title'],
					'title' => $yt_row->video_title,
					'link' => $yt_row->thumbnail_link,
					'link_type' => 'partial',
					'type' => 'youtube',
					'post_day' => utcToLocal($yt_row->publish_datetime, $user->gmt, "l"),
					'post_date' => utcToLocal($yt_row->publish_datetime, $user->gmt, "d F, Y"),
					'post_time' => utcToLocal($yt_row->publish_datetime, $user->gmt, "g:i a"),
				);
				array_push($new_result, $yt_record);
			}

			$this->response(['status' => true, 'data' => $new_result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function channel_bulk_scheduled_delete_all_POST()
	{
		$this->sessioncheck();
		$channel = trim($this->post('channel'));
		$user_id = App::Session()->get('userid');
		$where_e[0]['key'] = 'user_id';
		$where_e[0]['value'] = $user_id;
		$where_e[1]['key'] = 'status';
		$where_e[1]['value'] = array(0, -1);
		if ($channel != "all") {
			$where_e[1]['key'] = 'channel_id';
			$where_e[1]['value'] = $channel;
		}
		$result = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_e, 'id', 'DESC');
		// youtube schedule
		$yt_where = array(
			[
				'key' => 'user_id',
				'value' => $user_id
			],
			[
				'key' => 'published',
				'value' => 0
			]
		);
		$youtube_result = $this->Publisher_model->list_records('youtube_scheduler', 0, 10000, $yt_where, 'id', 'DESC');
		if ($result || $youtube_result) {
			$total = 0;
			foreach ($result as $key => $row) {
				$post_id = $row->id;
				$img_path = $row->link;
				$video_path = $row->video_path;
				$where[0]['key'] = 'link';
				$where[0]['value'] = $img_path;
				$results = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where, 'id', 'DESC');
				$total = count($results);
				$delete = $this->Publisher_model->delete_record('channels_scheduler', $post_id);
				// delete path for removing video after upload
				remove_file($img_path);
				// remove file from s3 bucket
				remove_from_s3bucket($video_path);
				if ($row->type == 'facebook') {
					resources_update('down', POST_SCHEDULING_FB_ID);
				} elseif ($row->type == 'pinterest') {
					resources_update('down', POST_SCHEDULING_PIN_ID);
				} elseif ($row->type == 'instagram') {
					resources_update('down', POST_SCHEDULING_INST_ID);
				} elseif ($row->type == 'tiktok') {
					// resources_update('down', POST_SCHEDULING_INST_ID);
				}
			}

			foreach ($youtube_result as $yt_key => $yt_row) {
				$video_id = $yt_row->id;
				$video_path = $yt_row->video_link;
				$thumbnail_path = $yt_row->thumbnail_link;
				$yt_delete = $this->Publisher_model->delete_record('youtube_scheduler', $video_id);
				// delete thumbnail	
				remove_file($thumbnail_path);
				// delete video from AWS
				remove_from_s3bucket($video_path);
				if ($yt_delete) {
					resources_update('down', POST_SCHEDULING_YT_ID);
				}
				$total++;
			}
			$this->response(array(
				'total' => $total,
				'status' => true,
				'message' => 'All of your scheduled posts are removed successfully.',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Something went wrong please try again.',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function channel_bulk_scheduled_delete_POST()
	{
		$this->sessioncheck();
		$post_id = $this->post('id');
		$post = $this->Publisher_model->retrieve_record('channels_scheduler', $post_id);
		if ($post) {
			$img_path = $post->link;
			$video_path = $post->video_path;
			$where[0]['key'] = 'link';
			$where[0]['value'] = $img_path;
			$results = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where, 'id', 'DESC');
			// check post type
			if ($post->type == 'facebook') {
				resources_update('down', POST_SCHEDULING_FB_ID);
			} elseif ($post->type == 'pinterest') {
				resources_update('down', POST_SCHEDULING_PIN_ID);
			} elseif ($post->type == 'instagram') {
				resources_update('down', POST_SCHEDULING_INST_ID);
			} elseif ($post->type == 'tiktok') {
				// resources_update('down', POST_SCHEDULING_INST_ID);
			}
			$total = count($results);
			$delete = $this->Publisher_model->delete_record('channels_scheduler', $post_id);
			// delete path for removing video after upload
			remove_file($img_path);
			// remove file from s3 bucket
			remove_from_s3bucket($video_path);
		}
		if ($delete) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled post is removed successfully.',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function delete_youtube_queued_post_POST()
	{
		$this->sessioncheck();
		$post_id = $this->post('id');
		$yt_post = $this->Publisher_model->retrieve_record('youtube_scheduler', $post_id);
		if ($yt_post) {
			$thumbnail_path = $yt_post->thumbnail_link;
			$video_path = $yt_post->video_link;
			$delete = $this->Publisher_model->delete_record('youtube_scheduler', $post_id);
			// remove thumbnail
			remove_file($thumbnail_path);
			// remove video
			remove_from_s3bucket($video_path);
		}
		if ($delete) {
			resources_update('down', POST_SCHEDULING_YT_ID);
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled post is removed successfully.',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}
	// bulk_channel_filter
	public function bulk_channel_filter_POST()
	{
		$this->sessioncheck();
		$channel_id = $this->post('channel_id');
		$user_id = App::Session()->get('userid');

		if ($channel_id == 'all') {
			$where[0]['key'] = 'user_id';
			$where[0]['value'] = $user_id;

			$result = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where, 'id', 'DESC');
			// check if type is facebook or pinterest and get channel name from facebook_pages table or pinterest_boards table
			foreach ($result as $key => $value) {
				if ($value->type == 'facebook') {
					$where[0]['key'] = 'id';
					$where[0]['value'] = $value->channel_id;

					$channel = $this->Publisher_model->list_records('facebook_pages', 0, 10000, $where, 'id', 'DESC');
					$result[$key]->channel_name = $channel[0]->page_name;
				} else if ($value->type == 'pinterest') {
					$where[0]['key'] = 'id';
					$where[0]['value'] = $value->channel_id;

					$channel = $this->Publisher_model->list_records('pinterest_boards', 0, 10000, $where, 'id', 'DESC');
					$result[$key]->channel_name = $channel[0]->name;
				}
			}
		} else {
			$where_[0]['key'] = 'user_id';
			$where_[0]['value'] = $user_id;
			$where_[1]['key'] = 'channel_id';
			$where_[1]['value'] = $channel_id;

			$result = $this->Publisher_model->list_records('channels_scheduler', 0, 10000, $where_, 'id', 'DESC');

			foreach ($result as $key => $value) {
				if ($value->type == 'facebook') {
					$where[0]['key'] = 'id';
					$where[0]['value'] = $value->channel_id;

					$channel = $this->Publisher_model->list_records('facebook_pages', 0, 10000, $where, 'id', 'DESC');
					$result[$key]->channel_name = $channel[0]->page_name;
				} else if ($value->type == 'pinterest') {
					$where[0]['key'] = 'id';
					$where[0]['value'] = $value->channel_id;

					$channel = $this->Publisher_model->list_records('pinterest_boards', 0, 10000, $where, 'id', 'DESC');
					$result[$key]->channel_name = $channel[0]->name;
				}
			}
		}


		if ($result) {
			$user = $this->Publisher_model->retrieve_record('user', $user_id);

			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['channel_id'] = $row->channel_id;
				$new_result[$key]['channel_name'] = $row->channel_name;
				$new_result[$key]['title'] = ucwords(strtolower(stripslashes($row->post_title)));
				$new_result[$key]['link'] = $row->link;
				$new_result[$key]['type'] = $row->type;
				$new_result[$key]['post_day'] = utcToLocal($row->post_datetime, $user->gmt, "l");
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "d F, Y");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "g:i a");
			}

			$this->response(['status' => true, 'data' => $new_result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function save_default_POST()
	{
		$selected_id = $this->post('selected_id');
		$user_id = App::Session()->get('userid');
		$this->db->set('selected_rss', $selected_id);
		$this->db->where('id', $user_id);
		$this->db->update('user');
		return $this->response(['status' => true]);
	}

	public function pinterest_rssfeed_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$page = $this->post('page');

		$timeslots = $this->post('timeslots') ? implode(",", $this->post('timeslots')) : '';
		$rss_link = $this->post('rss_link');

		$if_shopify_fetch = $this->post('if_shopify_fetch'); // Means this function is for deleting rss_links
		if (!empty($if_shopify_fetch) && $if_shopify_fetch == 'yes') {

			$data_sopify = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$shopifyStore = $data_sopify[0]->shopify_storeName;
			$apiVersion = '2024-01';
			$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
			$accessToken = $data_sopify[0]->shopify_adminApiAccessToken;
			$headers = [
				'X-Shopify-Access-Token: ' . $accessToken,
			];
			$ch = curl_init($endpoint);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpCode === 200) {
				$result = json_decode($response, true);
			} else {
				$this->response(['status' => false, 'message' => "Either your Credentails are wrong or Something Bad Happen"], REST_Controller::HTTP_BAD_REQUEST);
			}
			$src = array(); // Initialize $src as an empty array before the loop
			$new_products = 0;
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
				$this->db->select('url')->from('pinterest_scheduler')->where('user_id', $userID)->where('board_id', $page)->where('url', $FinalUrl);
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
				$this->create_single_pinterest_rss_feed($userID, $page, $title, $src, $FinalUrl, $timeslots);
				$new_products++;
				// print_r($this->db->last_query());
			}
			if ($new_products > 0) {
				$this->response(['status' => true, 'message' => 'Good Work! We are setting up your awesome feed, Please Wait.'], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => true, 'message' => 'Attension! There are no New Products to fetch right now.', 'produplicate' => true], REST_Controller::HTTP_OK);
			}
		}

		$if_rss_delete = $this->post('if_rss_delete'); // Means this function is for deleting rss_links
		if (!empty($if_rss_delete) && $if_rss_delete == 'yes') {
			if (!empty($rss_link)) {
				$this->db->select('rss_link')->from('pinterest_boards')->where('id', $page);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link)) {
					$this->response(['status' => true, 'message' => 'The selected rss is removed from input successfully'], REST_Controller::HTTP_OK);
				}
				$decoded_rss_link = json_decode($result[0]->rss_link, true); // Convert to an associative array
				$index = array_search($rss_link, $decoded_rss_link);
				if ($index !== false) {
					unset($decoded_rss_link[$index]);
					$decoded_rss_link = array_values($decoded_rss_link); // Reset keys
				}
				// Check if the array is empty
				if (empty($decoded_rss_link)) {
					$encode_updated_link = ''; // Set it to an empty string
				} else {
					$encode_updated_link = json_encode($decoded_rss_link);
				}
				$this->db->set('rss_link', $encode_updated_link);
				$this->db->where('id', $page);

				if ($this->db->update('pinterest_boards')) {
					$this->response(['status' => true, 'message' => 'The selected rss has been deleted successfully'], REST_Controller::HTTP_OK);
				} else {
					$this->response(['status' => false, 'message' => 'Something went wrong, please try again'], REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$this->response(['status' => false, 'message' => 'There is nothing to delete'], REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			$encode_rss_links = json_encode($rss_link);
			//-----------------------------------------------Site mapping Start------------------------------------------------//
			$if_rss_fetch = $this->post('if_rss_fetch'); // Means this logic is for fetching sitemap 10 posts
			if (!empty($if_rss_fetch) && $if_rss_fetch == 'yes') {
				$sitemap_rss_link = $this->post('sitemap_rss_link'); // The rss link for which more posts are demanded //
				$this->db->select('rss_link')->from('pinterest_boards')->where('id', $page);
				$result = $this->db->get()->result();
				$decoded_rss_link = !empty($result[0]->rss_link) ? json_decode($result[0]->rss_link, true) : [];
				if (in_array($sitemap_rss_link, $decoded_rss_link)) {
					limit_check(RSS_FEED_OLD_POST_FETCH_ID);
					$data = [
						'user_id' => $userID,
						'page_id' => $page,
						'type' => 'pinterest_past',
						'url' => $sitemap_rss_link,
						'published' => 0
					];
					$this->db->insert('rss_links', $data);
					// $response = pin_board_fetch_past_posts($sitemap_rss_link, $page, $userID, 1);
					$cron_url = 'https://www.adublisher.com/fetchPastRssFeed';
				} else {
					limit_check(RSS_FEED_LATEST_POST_FETCH_ID);
					$data = [
						'user_id' => $userID,
						'page_id' => $page,
						'type' => 'pinterest',
						'url' => $sitemap_rss_link,
						'published' => 0
					];
					$this->db->insert('rss_links', $data);
					// $response = pin_board_fetch_more_posts($sitemap_rss_link, $page, $userID, $timeslots, 1);
					$cron_url = 'https://www.adublisher.com/fetchRssFeed';
				}
				// if ($response['status']) {
				$store_rss_link[] = $this->post('sitemap_rss_link'); // The rss link for which more posts 	are demanded // 
				$this->db->select('rss_link')->from('pinterest_boards')->where('id', $page);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link)) {
					$encode_rss_links = json_encode($store_rss_link);
				} else {
					$decoded_rss_link = json_decode($result[0]->rss_link, true);
					// Check if the link already exists in $decoded_rss_link
					if (($key = array_search($store_rss_link[0], $decoded_rss_link)) !== false) {
						$store_rss_link = []; // Set $store_rss_link to empty array if it already exists
					}
					$all_links = array_merge($decoded_rss_link, $store_rss_link);
					$all_links = array_values($all_links); // Reset keys
					$encode_rss_links = json_encode($all_links);
				}
				$page_data['rss_link'] = $encode_rss_links;
				$result = $this->Publisher_model->update_record('pinterest_boards', $page_data, $page);
				$removeError = removeCronJobError($userID, 'pinterest_error');
				// run cronjob for fetching rss feed
				run_php_background($cron_url);
				$this->response(['status' => true, 'message' => "Good Work!! We are setting up your awesome feed, Please Wait."], REST_Controller::HTTP_OK);
				// } else {
				// 	$this->response(['status' => false, 'message' => $response['error']], REST_Controller::HTTP_BAD_REQUEST);
				// }
			}
			//-------------------------------------------------Site mapping End------------------------------------------------//
			//---------------------------------------------Submit Process Starting---------------------------------------------//
		}
	}

	public function create_single_pinterest_rss_feed($userID, $board_id, $title, $img_path, $url, $timeslots)
	{
		$post_date_time = getNextPostTime("pinterest_scheduler", $userID, $board_id, $timeslots);

		$this_id = $this->Publisher_model->post_pinterest_rssschedule($userID, $board_id, $title, $img_path, $url, $post_date_time);
		return $this_id;
	}

	public function pinterest_rss_feed_onoff_POST()
	{
		$this->sessioncheck();
		$board_id = $this->post('page');
		$board_data['rss_active'] = $this->post('rss_active');
		$result = $this->Publisher_model->update_record('pinterest_boards', $board_data, $board_id);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function shopify_pinterest_automation_onoff_POST()
	{
		$this->sessioncheck();
		$board_id = $this->post('page');
		$board_data['shopify_active'] = $this->post('shopify_active');
		$result = $this->Publisher_model->update_record('pinterest_boards', $board_data, $board_id);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function pinterest_rss_update_timeslots_POST()
	{
		$this->sessioncheck();
		$board_id = trim($this->post('page'));
		$board_data['time_slots_rss'] = json_encode($this->post('time_slots'));
		$result = $this->Publisher_model->update_record('pinterest_boards', $board_data, $board_id);
		$count_slots = isset($_POST['time_slots']) ? count($this->post('time_slots')) : 0;
		if ($count_slots > 0) {
			$timeslots = implode(",", $this->post('time_slots'));
			$this->db->select('*')->from('pinterest_scheduler')->where('board_id', $board_id)->where('published', 0);
			$schedule_posts = $this->db->get()->result();
			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');
			foreach ($schedule_posts as $posts) {
				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$publish_datetime = getNextPostTime("pinterest_scheduler", $userID, $board_id, $timeslots, $for_update);
				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $publish_datetime;
				$this->Publisher_model->update_pinterest_rssschedule($primary_id, $publish_datetime);
			}
		}
		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function get_pinterest_rssscheduled_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'board_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'published';
		// $where[1]['value'] = 0;
		$where[1]['value'] = array(0, -1);

		$where[2]['key'] = 'image_link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'image_link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('pinterest_scheduler', 0, 20, null, 'publish_datetime', 'ASC');
		// get last scheduled post
		$where = [
			['key' => 'user_id', 'value' => $user_id],
			['key' => 'board_id', 'value' => $id],
			['key' => 'published', 'value' => 0],
		];
		// total posts count
		$count = $this->Publisher_model->list_records('pinterest_scheduler', 0, 10000, $where, 'publish_datetime', 'ASC');
		// scheduled until
		$scheduled_until = $this->Publisher_model->list_records('pinterest_scheduler', 0, 1, $where, 'publish_datetime', 'DESC');
		$scheduled_until = count($scheduled_until) > 0 ? utcToLocal($scheduled_until[0]->publish_datetime, $user->gmt, "F j, Y, g:i a") : '';
		$page = $this->Publisher_model->retrieve_record('facebook_pages', $id);
		// $result = $this->Publisher_model->list_records('pinterest_scheduler', 0, 10000, $where, 'publish_datetime', 'ASC');
		$page = $this->Publisher_model->retrieve_record('pinterest_boards', $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $page->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('pinterest_scheduler')->where('board_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = isset($query[0]['created_at']) ? $query[0]['created_at'] : '';

				$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");

				$board = $this->Publisher_model->get_allrecords('pinterest_boards', array('id' => $id));
				$board_row = $board[0];
				if (!empty($board_row->last_run)) {
					$last_run = $board_row->last_run;
				}

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		$this->db->select('*')->from('pinterest_scheduler')->where('board_id', $id)->where('user_id', $user_id);
		$this->db->like('image_link', 'cdn.shopify.com');
		$this->db->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get()->result_array();
		if (count($query) > 0) {
			$last_shopify_run = $query[0]['created_at'];
			if (empty($last_shopify_run)) {
				$last_shopify_run = '';
			} else {
				$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
			}
		}
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
			}

			$this->response([
				'status' => true,
				'data' => $new_result,
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run,
				'count' => count($count),
				'scheduled_until' => $scheduled_until
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response([
				'status' => true,
				'message' => 'Please try again',
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function get_pinterest_rssspublished_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'board_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'published';
		// $where[1]['value'] = 0;
		$where[1]['value'] = array(1);

		$where[2]['key'] = 'image_link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'image_link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('pinterest_scheduler', 0, 10000, null, 'publish_datetime', 'DESC');

		// $result = $this->Publisher_model->list_records('pinterest_scheduler', 0, 10000, $where, 'publish_datetime', 'ASC');
		$page = $this->Publisher_model->retrieve_record('pinterest_boards', $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $page->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('pinterest_scheduler')->where('board_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = $query[0]['created_at'];

				$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");

				$board = $this->Publisher_model->get_allrecords('pinterest_boards', array('id' => $id));
				$board_row = $board[0];
				if (!empty($board_row->last_run)) {
					$last_run = $board_row->last_run;
				}

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		$this->db->select('*')->from('pinterest_scheduler')->where('board_id', $id)->where('user_id', $user_id);
		$this->db->like('image_link', 'cdn.shopify.com');
		$this->db->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get()->result_array();
		if (count($query) > 0) {
			$last_shopify_run = $query[0]['created_at'];
			if (empty($last_shopify_run)) {
				$last_shopify_run = '';
			} else {
				$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
			}
		}
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
			}

			$this->response([
				'status' => true,
				'data' => $new_result,
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response([
				'status' => true,
				'message' => 'Please try again',
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function delete_pinterest_rss_post_all_POST()
	{
		$this->sessioncheck();
		$board_id = $this->post('page');
		$with_error = $this->post('error');
		$type = $this->post('type');

		if ($with_error == "all" && $type == 'rss') {
			$result = $this->db->query("SELECT * FROM pinterest_scheduler WHERE board_id = $board_id AND image_link NOT LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "all" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('pinterest_scheduler', 'board_id', $board_id);
			$result = $this->db->query("SELECT * FROM pinterest_scheduler WHERE board_id = $board_id AND image_link LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "error" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('pinterest_scheduler', 'board_id', $board_id);
			$result = $this->db->query("SELECT * FROM pinterest_scheduler WHERE board_id = $board_id AND image_link NOT LIKE '%cdn.shopify.com%' AND published =-1 AND error IS NOT NULL");
		} elseif ($with_error == "error" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('pinterest_scheduler', 'board_id', $board_id);
			$result = $this->db->query("SELECT * FROM pinterest_scheduler WHERE board_id = $board_id AND image_link LIKE '%cdn.shopify.com%' AND published =-1 AND error IS NOT NULL");
		}

		foreach ($result->result_array() as $key => $value) {
			$post_id = $value['id'];
			if ($value['post_type'] == 'past') {
				$past = true;
			} elseif ($value['post_type'] == 'latest') {
				$past = false;
			}

			if ($value['published'] == 1) {
				continue;
			}

			if ($this->Publisher_model->delete_record('pinterest_scheduler', $post_id)) {
				if (isset($past)) {
					$past ? resources_update('down', RSS_FEED_OLD_POST_FETCH_ID) : resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
				}
			}
		}

		$this->response(array(
			'status' => true,
			'message' => 'Your scheduled posts Removed Successfully',
		), REST_Controller::HTTP_OK);
	}

	public function shuffle_pinterest_rss_post_all_POST()
	{
		$this->sessioncheck();
		$board_id = $this->post('page');

		$query = $this->db->query("SELECT publish_datetime FROM pinterest_scheduler WHERE board_id =$board_id AND published = 0 ORDER BY rand()");
		$random_slots = $query->result_array();

		$query_all = $this->db->query("SELECT * FROM pinterest_scheduler WHERE board_id =$board_id AND published = 0 ORDER BY publish_datetime ASC");
		$all_posts = $query_all->result_array();
		foreach ($all_posts as $key => $post) {
			$post_data['publish_datetime'] = $random_slots[$key]['publish_datetime'];
			$updated = $this->Publisher_model->update_record('pinterest_scheduler', $post_data, $post['id']);
		}
		if ($all_posts) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts shuffled Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function store_shopify_credntials_POST()
	{
		// Assuming you are using CodeIgniter's input class
		// $this->session->set_userdata('apiKey', $apiKey);
		// $this->session->set_userdata('apiSecretKey', $apiSecretKey);
		// $this->session->set_userdata('adminApiAccessToken', $adminApiAccessToken);
		$user_id = App::Session()->get('userid');

		$apiKey = $this->input->post('apiKey');
		$apiSecretKey = $this->input->post('apiSecretKey');
		$adminApiAccessToken = $this->input->post('adminApiAccessToken');
		$storeName = $this->input->post('storeName');

		if (strpos($storeName, '.myshopify.com') === false) {
			$storeName .= '.myshopify.com';
		}

		$shopifyStore = $storeName;
		$apiVersion = '2024-01';
		$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
		$accessToken = $adminApiAccessToken;
		$headers = [
			'X-Shopify-Access-Token: ' . $accessToken,
		];

		$ch = curl_init($endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($httpCode === 200) {
			$result = json_decode($response, true);
			if (isset($result['products'])) {
				$this->db->set('shopify_apiKey', $apiKey);
				$this->db->set('shopify_apiSecretKey', $apiSecretKey);
				$this->db->set('shopify_adminApiAccessToken', $adminApiAccessToken);
				$this->db->set('shopify_storeName', $storeName);
				$this->db->where('id', $user_id);
				if ($this->db->update('user')) {
					$this->response(array(
						'status' => true,
						'message' => 'You Are all Set To Fetch Your Products',
					), REST_Controller::HTTP_OK);
				} else {
					$this->response(array(
						'status' => false,
						'message' => 'Somehing Went Wrong Please Try Again',
					), REST_Controller::HTTP_NOT_FOUND);
				}
			}
		} else {
			$this->response(['status' => false, 'message' => "Authentication failed. Please provide accurate information."], REST_Controller::HTTP_BAD_REQUEST);
		}
		// You can return a response if needed
		// $response = array('status' => 'success', 'message' => 'Credentials stored successfully');
		// echo json_encode($response);
	}

	public function disconnect_shopify_account_POST()
	{
		$user_id = $this->input->post('user_id');

		$this->db->where('user_id', $user_id);
		$this->db->where('posted', 0);
		$this->db->like('link', 'cdn.shopify.com', 'both');
		$this->db->delete('rsssceduler');

		$this->db->where('user_id', $user_id);
		$this->db->where('published', 0);
		$this->db->like('image_link', 'cdn.shopify.com', 'both');
		$this->db->delete('facebook_group_scheduler');

		$this->db->where('user_id', $user_id);
		$this->db->where('published', 0);
		$this->db->like('image_link', 'cdn.shopify.com', 'both');
		$this->db->delete('pinterest_scheduler');

		$this->db->set('shopify_apiKey', '');
		$this->db->set('shopify_apiSecretKey', '');
		$this->db->set('shopify_adminApiAccessToken', '');
		$this->db->set('shopify_storeName', '');
		$this->db->where('id', $user_id);
		if ($this->db->update('user')) {
			$this->response(array(
				'status' => true,
				'message' => 'Shopify Account Disconnected Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Somehing Went Wrong Please Try Again',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function delete_pinterest_rss_post_POST()
	{
		$this->sessioncheck();
		$post_id = $this->post('id');
		//Here get its time and date
		$post = $this->Publisher_model->retrieve_record('pinterest_scheduler', $post_id);
		$new_result = [];
		$past = false;
		if ($post->post_type == 'past') {
			$past = true;
		} elseif ($post->post_type == 'latest') {
			$past = false;
		}
		if ($this->Publisher_model->delete_record('pinterest_scheduler', $post_id)) {
			if (isset($past)) {
				$past ? resources_update('down', RSS_FEED_OLD_POST_FETCH_ID) : resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
			}
			$this->response(array(
				'status' => true,
				'data' => $new_result,
				'message' => 'Your scheduled post Removed Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'data' => '',
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function active_channels_GET()
	{
		// check if any channel is active or not
		$user_id = App::Session()->get('userid');
		$active_channels = $this->Publisher_model->get_active_channels_settings($user_id);
		$fbpages = $active_channels['fbpages'];
		$boards = $active_channels['boards'];
		$ig_accounts = $active_channels['ig_accounts'];
		$fb_groups = $active_channels['fb_groups'];
		$tiktoks = $active_channels['tiktoks'];
		if (count($fbpages) == 0 && count($boards) == 0 && count($ig_accounts) == 0 && count($fb_groups) == 0 && count($tiktoks) == 0) {
			$this->response(array(
				'status' => false,
				'message' => 'Please add atleast one channel',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => true,
			), REST_Controller::HTTP_OK);
		}
		// check if any channel is active or not
	}

	public function link_preview_GET()
	{
		$request_url = $this->get('url');
		if (substr($request_url, -1) != '/') {
			$request_url = $request_url . '/';
		}
		$response = array();
		$response['title'] = '';
		$response['image'] = '';
		$response['description'] = '';
		$response['url'] = $request_url;
		$response['status'] = false;

		if ($request_url != '') {
			$max_retry = 3;
			$retry = 0;

			while ($retry < $max_retry) {
				$response_ = $this->get_link_valid_meta($request_url);
				$title = $response_['title'];
				if ($title != '' && $title != null && !strpos($title, 'cURL Error')) {
					if (isset($response_['status']) && $response_['status'] === true) {
						$response_['url'] = $request_url;
						$this->response($response_, REST_Controller::HTTP_OK);
					} else {
						$retry++;
					}
				} else {
					$retry++;
				}
			}
			$this->response($response, REST_Controller::HTTP_OK);
		}
	}

	public function get_link_valid_meta($url)
	{
		$this->load->library('getMetaInfo');
		$response = array();
		$info = array();
		$info = $this->getmetainfo->get_info($url);
		try {
			if (!empty($info) && isset($info['title']) && isset($info['image'])) {
				$response['image'] = $info['image'];

				$entityReplacements = array(
					"&#039;" => "'",
					"&#39;" => "'",
					"039" => "'",
					"&#8211;" => "-",
					"&#8212;" => "--",
				);
				$response['title'] = str_replace(array_keys($entityReplacements), array_values($entityReplacements), $info['title']);
				// $response['title'] =  str_replace("&#039;","'",$info['title']);
				$response['description'] = isset($info['description']) ? $info['description'] : '';

				// $response['description'] = str_replace("&#039;","'",$response['description']);
				$response['description'] = isset($info['description']) ? str_replace(array_keys($entityReplacements), array_values($entityReplacements), $info['description']) : '';

				$response['status'] = true;

				return $response;
			} else {
				return $response['status'] = false;
			}
		} catch (Exception $e) {
			return $response['status'] = false;
		}
	}

	// instagram

	public function get_instagram_access_token_GET()
	{
		$this->Publisher_model->get_instagram_access_token();
	}

	// PUblish Single Media Posts - Instagram
	// Step 1 of 2: Create Container
	// change _GET to _POST
	// public function publish_ig_single_media_GET()
	public function publish_ig_single_media($instagram_id, $access_token, $img_url, $caption)
	{
		$user_id = App::Session()->get('userid');
		$container = $this->Publisher_model->create_ig_media_container($instagram_id, $access_token, $img_url, $caption);
		if (isset($container['id'])) {

			// Step 2 of 2: Publish Container
			$result = $this->Publisher_model->publish_ig_media_container($user_id, $container['id']);
			if (isset($result['id'])) {
				return array(
					'status' => true,
					'data' => $result,
					'message' => 'ig - post published Successfully',
				);
			} else {
				return array(
					'status' => false,
					'data' => $result,
					'message' => 'Some Problem occured, while publishing ig - post',
				);
			}
		} else {
			return array(
				'status' => false,
				'data' => $container,
				'message' => 'Some Problem occured, while creating container - ig',
			);
		}
	}

	// instagram RSS
	public function ig_rss_update_timeslots_POST()
	{
		$this->sessioncheck();
		$ig_id = trim($this->post('page'));

		$ig_data['time_slots_rss'] = json_encode($this->post('time_slots'));
		$result = $this->Publisher_model->update_record('instagram_users', $ig_data, $ig_id);

		$count_slots = count($this->post('time_slots'));

		$timeslots = implode(",", $this->post('time_slots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('instagram_scheduler')->where('ig_id', $ig_id)->where('published', 0);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$publish_datetime = getNextPostTime("instagram_scheduler", $userID, $ig_id, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $publish_datetime;

				$this->Publisher_model->update_ig_rssschedule($primary_id, $publish_datetime);
			}
		}

		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function get_ig_rssscheduled_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'ig_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'published';
		// $where[1]['value'] = 0;
		$where[1]['value'] = array(0, -1);

		$where[2]['key'] = 'image_link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'image_link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('instagram_scheduler', 0, 20, null, 'publish_datetime', 'ASC');
		$where = [
			['key' => 'user_id', 'value' => $user_id],
			['key' => 'ig_id', 'value' => $id],
			['key' => 'published', 'value' => array(0, -1)],
		];
		// total posts count
		$count = $this->Publisher_model->list_records('instagram_scheduler', 0, 10000, $where, 'publish_datetime', 'ASC');
		// scheduled until
		$scheduled_until = $this->Publisher_model->list_records('instagram_scheduler', 0, 1, $where, 'publish_datetime', 'ASC');
		$scheduled_until = count($scheduled_until) > 0 ? utcToLocal($scheduled_until[0]->publish_datetime, $user->gmt, "F j, Y, g:i a") : '';
		$page = $this->Publisher_model->retrieve_record('instagram_users', $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $page->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('instagram_scheduler')->where('ig_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				if (count($query) > 0) {
					$last_run = $query[0]['created_at'];
					$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");
				} else {
					$last_run = '';
				}

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		$this->db->select('*')->from('instagram_scheduler')->where('ig_id', $id)->where('user_id', $user_id);
		$this->db->like('image_link', 'cdn.shopify.com');
		$this->db->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get()->result_array();
		if (count($query) > 0) {
			$last_shopify_run = $query[0]['created_at'];
		}
		if (empty($last_shopify_run)) {
			$last_shopify_run = '';
		} else {
			$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
		}
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
			}

			$this->response([
				'status' => true,
				'data' => $new_result,
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run,
				'count' => count($count),
				'scheduled_until' => $scheduled_until
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response([
				'status' => true,
				'message' => 'Please try again',
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run,
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		}
	}

	public function get_ig_rssspublished_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'ig_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'published';
		// $where[1]['value'] = 0;
		$where[1]['value'] = array(1);

		$where[2]['key'] = 'image_link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'image_link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('instagram_scheduler', 0, 10000, null, 'publish_datetime', 'DESC');
		// $result = $this->Publisher_model->list_records('instagram_scheduler', 0, 10000, $where, 'publish_datetime', 'ASC');
		$page = $this->Publisher_model->retrieve_record('instagram_users', $id);
		$decoded_rss_link = json_decode($page->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $page->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('instagram_scheduler')->where('ig_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = $query[0]['created_at'];

				$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		$this->db->select('*')->from('instagram_scheduler')->where('ig_id', $id)->where('user_id', $user_id);
		$this->db->like('image_link', 'cdn.shopify.com');
		$this->db->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get()->result_array();
		$last_shopify_run = count($query) > 0 ? $query[0]['created_at'] : '';
		if (empty($last_shopify_run)) {
			$last_shopify_run = '';
		} else {
			$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
		}
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {

				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
			}

			$this->response([
				'status' => true,
				'data' => $new_result,
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response([
				'status' => true,
				'message' => 'Please try again',
				'time_slots' => $page->time_slots_rss,
				'rss_active' => $page->rss_active,
				'shopify_active' => $page->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		}
	}

	public function ig_rssfeed_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$id = $this->post('page');
		$timeslots = $this->post('timeslots') ? implode(",", $this->post('timeslots')) : '';

		$rss_link = $this->post('rss_link');

		$if_shopify_fetch = $this->post('if_shopify_fetch'); // Means this function is for deleting rss_links
		if (!empty($if_shopify_fetch) && $if_shopify_fetch == 'yes') {

			$data_sopify = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$shopifyStore = $data_sopify[0]->shopify_storeName;
			$apiVersion = '2024-01';
			$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
			$accessToken = $data_sopify[0]->shopify_adminApiAccessToken;
			$headers = [
				'X-Shopify-Access-Token: ' . $accessToken,
			];
			$ch = curl_init($endpoint);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpCode === 200) {
				$result = json_decode($response, true);
			} else {
				$this->response(['status' => false, 'message' => "Either your Credentails are wrong or Something Bad Happen"], REST_Controller::HTTP_BAD_REQUEST);
			}
			$src = array(); // Initialize $src as an empty array before the loop
			$new_products = 0;
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
				$this->db->select('url')->from('instagram_scheduler')->where('user_id', $userID)->where('ig_id', $id)->where('url', $FinalUrl);
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
				$this->create_single_ig_rss_feed($userID, $id, $title, $src, $FinalUrl, $timeslots);
				$new_products++;
				// print_r($this->db->last_query());
			}
			if ($new_products > 0) {
				$this->response(['status' => true, 'message' => 'Good Work! We are setting up your awesome feed, Please Wait.'], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => true, 'message' => 'Attension! There are no New Products to fetch right now.', 'produplicate' => true], REST_Controller::HTTP_OK);
			}
		}

		$if_rss_delete = $this->post('if_rss_delete'); // Means this function is for deleting rss_links
		if (!empty($if_rss_delete) && $if_rss_delete == 'yes') {
			if (!empty($rss_link)) {
				$this->db->select('rss_link')->from('instagram_users')->where('id', $id);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link)) {
					$this->response(['status' => true, 'message' => 'The selected rss is removed from input successfully'], REST_Controller::HTTP_OK);
				}
				$decoded_rss_link = json_decode($result[0]->rss_link, true); // Convert to an associative array
				$index = array_search($rss_link, $decoded_rss_link);
				if ($index !== false) {
					unset($decoded_rss_link[$index]);
					$decoded_rss_link = array_values($decoded_rss_link); // Reset keys
				}
				// Check if the array is empty
				if (empty($decoded_rss_link)) {
					$encode_updated_link = ''; // Set it to an empty string
				} else {
					$encode_updated_link = json_encode($decoded_rss_link);
				}
				$this->db->set('rss_link', $encode_updated_link);
				$this->db->where('id', $id);

				if ($this->db->update('instagram_users')) {
					$this->response(['status' => true, 'message' => 'The selected rss has been deleted successfully'], REST_Controller::HTTP_OK);
				} else {
					$this->response(['status' => false, 'message' => 'Something went wrong, please try again'], REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$this->response(['status' => false, 'message' => 'There is nothing to delete'], REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			//-----------------------------------------------Site mapping Start------------------------------------------------//
			$if_rss_fetch = $this->post('if_rss_fetch'); // Means this logic is for fetching sitemap 10 posts
			if (!empty($if_rss_fetch) && $if_rss_fetch == 'yes') {
				$sitemap_rss_link = $this->post('sitemap_rss_link'); // The rss link for which more posts are demanded //
				$this->db->select('rss_link')->from('instagram_users')->where('id', $id);
				$result = $this->db->get()->result();
				$decoded_rss_link = json_decode($result[0]->rss_link, true);
				$decoded_rss_link = $decoded_rss_link ?? [];
				if (in_array($sitemap_rss_link, $decoded_rss_link)) {
					limit_check(RSS_FEED_OLD_POST_FETCH_ID);
					// $response = ig_user_fetch_past_posts($sitemap_rss_link, $id, $userID, $timeslots, 1);
					$data = [
						'user_id' => $userID,
						'page_id' => $id,
						'type' => 'instagram_past',
						'url' => $sitemap_rss_link,
						'published' => 0
					];
					$this->db->insert('rss_links', $data);

					$cron_url = 'https://www.adublisher.com/fetchPastRssFeed';
				} else {
					limit_check(RSS_FEED_LATEST_POST_FETCH_ID);
					// $response = ig_user_fetch_more_posts($sitemap_rss_link, $id, $userID, $timeslots, 1);
					$data = [
						'user_id' => $userID,
						'page_id' => $id,
						'type' => 'instagram',
						'url' => $sitemap_rss_link,
						'published' => 0
					];
					$this->db->insert('rss_links', $data);
					$cron_url = 'https://www.adublisher.com/fetchRssFeed';
				}
				$response = array(
					'status' => true,
					'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
				);
				if ($response['status']) {
					// Store link in DB
					$store_rss_link[] = $this->post('sitemap_rss_link'); // The rss link for which more posts are demanded // 
					$this->db->select('rss_link')->from('instagram_users')->where('id', $id);
					$result = $this->db->get()->result();
					if (empty($result[0]->rss_link)) {
						$encode_rss_links = json_encode($store_rss_link);
					} else {
						$decoded_rss_link = json_decode($result[0]->rss_link, true);
						// Check if the link already exists in $decoded_rss_link
						if (($key = array_search($store_rss_link[0], $decoded_rss_link)) !== false) {
							$store_rss_link = []; // Set $store_rss_link to empty array if it already exists
						}
						$all_links = array_merge($decoded_rss_link, $store_rss_link);
						$all_links = array_values($all_links); // Reset keys
						$encode_rss_links = json_encode($all_links);
					}
					$ig_data['rss_link'] = $encode_rss_links;
					$result = $this->Publisher_model->update_record('instagram_users', $ig_data, $id);
					$removeError = removeCronJobError($userID, 'instagram_error');
					// run cronjob for fetching rss feed
					run_php_background($cron_url);
					$this->response(['status' => true, 'message' => $response['message']], REST_Controller::HTTP_OK);
				} else {
					$this->response(['status' => false, 'message' => $response['error']], REST_Controller::HTTP_BAD_REQUEST);
				}
			}
		}
	}

	public function checkAndResizeImage($data = '', $aspect_ratio = 1.91)
	{
		$image = $data['image'];

		list($width, $height, $type, $attr) = getimagesize($image);

		// Calculate new dimensions based on aspect ratio
		$new_width = $width;
		$new_height = $height;

		$current_aspect_ratio = $width / $height;
		if ($current_aspect_ratio > $aspect_ratio) {
			// Current aspect ratio is wider, so adjust height
			$new_height = $width / $aspect_ratio;
		} else {
			// Current aspect ratio is taller, so adjust width
			$new_width = $height * $aspect_ratio;
		}

		// Create resized image
		$src = imagecreatefromstring(file_get_contents($image));
		$dst = imagecreatetruecolor($new_width, $new_height);

		$filenameext = basename($image);
		$ext = pathinfo($filenameext, PATHINFO_EXTENSION);
		if ($ext == 'webp') {
			$ext = 'jpg';
		}

		// Adjusting the final file name with the correct path

		$file_name = 'uploads/instagram/' . date('Y-m-d') . '_' . time() . '_' . "rss_" . rand(0, 100) . "." . $ext;

		$final_file_name = SITEURL . $file_name;

		imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagedestroy($src);
		imagepng($dst, $file_name); // adjust format as needed
		imagedestroy($dst);

		try {
			$response_array = array('resized' => 1, 'image' => $final_file_name);
			return $response_array;
		} catch (Exception $ex) {
			//Catch error here
		}

		return array('resized' => 0, 'image' => $image);
	}



	public function create_single_ig_rss_feed($userID, $ig_id, $title, $img_path, $url, $timeslots)
	{
		$post_date_time = getNextPostTime("instagram_scheduler", $userID, $ig_id, $timeslots);
		$this_id = $this->Publisher_model->post_ig_rssschedule($userID, $ig_id, $title, $img_path, $url, $post_date_time);
		return $this_id;
	}

	public function ig_rss_feed_onoff_POST()
	{
		$this->sessioncheck();
		$ig_id = $this->post('page');
		$ig_data['rss_active'] = $this->post('rss_active');
		$result = $this->Publisher_model->update_record('instagram_users', $ig_data, $ig_id);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function shopify_insta_automation_onoff_POST()
	{
		$this->sessioncheck();
		$ig_id = $this->post('page');
		$ig_data['shopify_active'] = $this->post('shopify_active');
		$result = $this->Publisher_model->update_record('instagram_users', $ig_data, $ig_id);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function delete_ig_rss_post_all_POST()
	{
		$this->sessioncheck();
		$ig_id = $this->post('page');
		$this->db->select('image_link')->from('instagram_scheduler')->where('ig_id', $ig_id);
		$images = $this->db->get()->result();
		$directory = 'uploads/instagram/';
		foreach ($images as $image_to_unlink) {
			$image_name = basename($image_to_unlink->image_link);
			$image_full_path = $directory . $image_name;
			if (file_exists($image_full_path)) {
				unlink($image_full_path);
			}
		}
		$with_error = $this->post('error');
		$type = $this->post('type');
		if ($with_error == "all" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('instagram_scheduler', 'ig_id', $ig_id);
			$result = $this->db->query("SELECT * FROM instagram_scheduler WHERE ig_id = $ig_id AND image_link NOT LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "all" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('instagram_scheduler', 'ig_id', $ig_id);
			$result = $this->db->query("SELECT * FROM instagram_scheduler WHERE ig_id = $ig_id AND image_link LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "error" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('instagram_scheduler', 'ig_id', $ig_id);
			$result = $this->db->query("SELECT * FROM instagram_scheduler WHERE ig_id = $ig_id AND image_link NOT LIKE '%cdn.shopify.com%' AND published =-1 AND error IS NOT NULL");
		} elseif ($with_error == "error" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('instagram_scheduler', 'ig_id', $ig_id);
			$result = $this->db->query("SELECT * FROM instagram_scheduler WHERE ig_id = $ig_id AND image_link LIKE '%cdn.shopify.com%' AND published =-1 AND error IS NOT NULL");
		}

		foreach ($result->result_array() as $key => $value) {
			$post_id = $value['id'];
			if ($value['post_type'] == 'past') {
				$past = true;
			} elseif ($value['post_type'] == 'latest') {
				$past = false;
			}

			if ($value['published'] == 1) {
				continue;
			}

			if ($this->Publisher_model->delete_record('instagram_scheduler', $post_id)) {
				if (isset($past)) {
					$past ? resources_update('down', RSS_FEED_OLD_POST_FETCH_ID) : resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
				}
			}
		}

		if ($result) {
			$message = (isset($with_error) && $with_error == 'all') ? "Your scheduled posts removed successfully" : "Your rejected posts removed successfully";
			$this->response(array(
				'status' => true,
				'message' => $message,

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function delete_tiktok_rss_post_all_POST()
	{
		$this->sessioncheck();
		$page_id = $this->post('page');
		$with_error = $this->post('error');
		$type = $this->post('type');

		if ($with_error == "all" && $type == 'rss') {
			$result = $this->db->query("SELECT * FROM tiktok_scheduler WHERE tiktok_id = $page_id AND link NOT LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "all" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('tiktok_scheduler', 'page_id', $id);
			$result = $this->db->query("SELECT * FROM tiktok_scheduler WHERE tiktok_id = $page_id AND link LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "error" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('tiktok_scheduler', 'page_id', $id);
			$result = $this->db->query("SELECT * FROM tiktok_scheduler WHERE tiktok_id = $page_id AND link NOT LIKE '%cdn.shopify.com%' AND error IS NOT NULL");
		} elseif ($with_error == "error" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('tiktok_scheduler', 'page_id', $id);
			$result = $this->db->query("SELECT * FROM tiktok_scheduler WHERE tiktok_id = $page_id AND link LIKE '%cdn.shopify.com%' AND error IS NOT NULL");
		}

		foreach ($result->result_array() as $key => $value) {
			$post_id = $value['id'];
			if ($value['post_type'] == 'past') {
				$past = true;
			} elseif ($value['post_type'] == 'latest') {
				$past = false;
			}

			if ($value['published'] == 1) {
				continue;
			}

			if ($this->Publisher_model->delete_record('tiktok_scheduler', $post_id)) {
				if (isset($past)) {
					$past ? resources_update('down', RSS_FEED_OLD_POST_FETCH_ID) : resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
				}
			}
		}

		if ($result) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts Removed Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function shuffle_ig_rss_post_all_POST()
	{
		$this->sessioncheck();
		$ig_id = $this->post('page');

		$query = $this->db->query("SELECT publish_datetime FROM instagram_scheduler WHERE ig_id =$ig_id AND published = 0 ORDER BY rand()");
		$random_slots = $query->result_array();

		$query_all = $this->db->query("SELECT * FROM instagram_scheduler WHERE ig_id =$ig_id AND published = 0 ORDER BY publish_datetime ASC");
		$all_posts = $query_all->result_array();
		foreach ($all_posts as $key => $post) {
			$post_data['publish_datetime'] = $random_slots[$key]['publish_datetime'];
			$updated = $this->Publisher_model->update_record('instagram_scheduler', $post_data, $post['id']);
		}
		if ($all_posts) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts shuffled Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function delete_ig_rss_post_POST()
	{
		$this->sessioncheck();
		$post_id = $this->post('id');
		//Here get its time and date
		$this->db->select('image_link')->from('instagram_scheduler')->where('id', $post_id);
		$image = $this->db->get()->result();
		$directory = 'uploads/instagram/';
		$image_name = basename($image[0]->image_link);
		$image_full_path = $directory . $image_name;
		if (file_exists($image_full_path)) {
			unlink($image_full_path);
		}
		$post = $this->Publisher_model->retrieve_record('instagram_scheduler', $post_id);
		$type = $post->post_type;
		$new_result = [];
		if ($this->Publisher_model->delete_record('instagram_scheduler', $post_id)) {
			if ($type == 'past') {
				resources_update('down', RSS_FEED_OLD_POST_FETCH_ID);
			} elseif ($type == 'latest') {
				resources_update('down', RSS_FEED_LATEST_POST_FETCH_ID);
			}
			$this->response(array(
				'status' => true,
				'data' => $new_result,
				'message' => 'Your scheduled post Removed Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'data' => '',
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	// facebook groups

	public function get_fbgroups_access_token_GET()
	{
		$this->Publisher_model->get_fbgroups_access_token();
	}

	public function get_facebook_groups_GET()
	{
		$user_id = App::Session()->get('userid');
		$fb_groups = $this->Publisher_model->get_facebook_groups();
		$facebook_groups = json_decode($fb_groups, true);
		if ($facebook_groups['status'] == 'success' && count($facebook_groups['data']) > 0) {

			foreach ($facebook_groups['data'] as $group) {
				$data['user_id'] = $user_id;
				$data['group_id'] = $group['id'];
				$data['name'] = $group['name'];

				$where = array('user_id' => $user_id, 'group_id' => $group['id']);
				$result[] = $this->Publisher_model->create_or_update_record('facebook_groups', $data, $where);
				$this->db->where('channel_id', $result);
				$this->db->where('user_id', $user_id);
				$this->db->where('type', 'fb_groups');
				$this->db->set('active_deactive_status', 1);
				$this->db->update('channels_scheduler');
			}

			if ($result) {
				// $this->response(array(
				// 	'status' => true,
				// 	'message' => 'Facebook Pages Added Successfully',
				// ), REST_Controller::HTTP_OK);
				// redirect(SITEURL . 'facebook?status=true');
				redirect(SITEURL . 'schedule?status=true');
			} else {
				redirect(SITEURL . 'schedule?status=false');
			}
		} else {
			redirect(SITEURL . 'schedule?status=false');
		}
	}

	// facebook groups RSS

	public function get_fb_group_rssscheduled_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'fb_group_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'published';
		$where[1]['value'] = array(0, -1);

		$where[2]['key'] = 'image_link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'image_link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('facebook_group_scheduler', 0, 10000, null, 'publish_datetime', 'ASC');
		$group = $this->Publisher_model->retrieve_record('facebook_groups', $id);
		$decoded_rss_link = json_decode($group->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $group->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('facebook_group_scheduler')->where('fb_group_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = $query[0]['created_at'];

				$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		$this->db->select('*')->from('facebook_group_scheduler')->where('fb_group_id', $id)->where('user_id', $user_id);
		$this->db->like('image_link', 'cdn.shopify.com');
		$this->db->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get()->result_array();
		$last_shopify_run = $query[0]['created_at'];
		if (empty($last_shopify_run)) {
			$last_shopify_run = '';
		} else {
			$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
		}
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
			}

			$this->response([
				'status' => true,
				'data' => $new_result,
				'time_slots' => $group->time_slots_rss,
				'rss_active' => $group->rss_active,
				'shopify_active' => $group->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response([
				'status' => true,
				'message' => 'Please try again',
				'time_slots' => $group->time_slots_rss,
				'rss_active' => $group->rss_active,
				'shopify_active' => $group->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		}
	}

	public function get_fb_group_rssspublished_post()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);

		$where[0]['key'] = 'fb_group_id';
		$where[0]['value'] = $id;
		$where[1]['key'] = 'published';
		$where[1]['value'] = array(1);

		$where[2]['key'] = 'image_link';
		$where[2]['value'] = 'cdn.shopify.com';

		$where[3]['key'] = 'image_link';
		$where[3]['value'] = 'youtube.com';

		$this->db->where($where[0]['key'], $where[0]['value']);
		$this->db->where_in($where[1]['key'], $where[1]['value']);

		if ($activedivid == 'rss') {
			$this->db->not_like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'shopify') {
			$this->db->like($where[2]['key'], $where[2]['value']);
		} elseif ($activedivid == 'youtube') {
			// condition will be written once youtube is here
			// right now we will return nothing
			$this->db->like($where[3]['key'], $where[3]['value']);
		}

		$result = $this->Publisher_model->list_records('facebook_group_scheduler', 0, 10000, null, 'publish_datetime', 'DESC');
		$group = $this->Publisher_model->retrieve_record('facebook_groups', $id);
		$decoded_rss_link = json_decode($group->rss_link);
		if (empty($decoded_rss_link)) { // This means the rss link was never encoded before so you cant decode for the first time
			$decoded_rss_link = $group->rss_link;
		}
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$decoded_rss_link = '';
			$return_link_and_last_run[] = [
				'link' => $decoded_rss_link,
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run = [];
			foreach ($decoded_rss_link as $links) {
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('facebook_group_scheduler')->where('fb_group_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				$last_run = $query[0]['created_at'];

				$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");

				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}

		// For Shopify Last Run //
		$last_shopify_run = '';
		$this->db->select('*')->from('facebook_group_scheduler')->where('fb_group_id', $id)->where('user_id', $user_id);
		$this->db->like('image_link', 'cdn.shopify.com');
		$this->db->order_by('id', 'DESC')->limit(1);
		$query = $this->db->get()->result_array();
		$last_shopify_run = $query[0]['created_at'];
		if (empty($last_shopify_run)) {
			$last_shopify_run = '';
		} else {
			$last_shopify_run = utcToLocal($last_shopify_run, $user->gmt, "Y-m-d  H:i:s");
		}
		// End //

		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->image_link;
				$new_result[$key]['url'] = $row->url;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->error;
				$new_result[$key]['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
			}

			$this->response([
				'status' => true,
				'data' => $new_result,
				'time_slots' => $group->time_slots_rss,
				'rss_active' => $group->rss_active,
				'shopify_active' => $group->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response([
				'status' => true,
				'message' => 'Please try again',
				'time_slots' => $group->time_slots_rss,
				'rss_active' => $group->rss_active,
				'shopify_active' => $group->shopify_active,
				'rss_link' => $return_link_and_last_run,
				'last_shopify_run' => $last_shopify_run
			], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		}
	}

	public function fb_group_rssfeed_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$id = $this->post('page');
		$timeslots = $this->post('timeslots') ? implode(",", $this->post('timeslots')) : '';
		$rss_link = $this->post('rss_link');

		$if_shopify_fetch = $this->post('if_shopify_fetch'); // Means this function is for deleting rss_links
		if (!empty($if_shopify_fetch) && $if_shopify_fetch == 'yes') {
			$data_sopify = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$shopifyStore = $data_sopify[0]->shopify_storeName;
			$apiVersion = '2024-01';
			$endpoint = "https://{$shopifyStore}/admin/api/{$apiVersion}/products.json";
			$accessToken = $data_sopify[0]->shopify_adminApiAccessToken;
			$headers = [
				'X-Shopify-Access-Token: ' . $accessToken,
			];
			$ch = curl_init($endpoint);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpCode === 200) {
				$result = json_decode($response, true);
			} else {
				$this->response(['status' => false, 'message' => "Either your Credentails are wrong or Something Bad Happen"], REST_Controller::HTTP_BAD_REQUEST);
			}
			$src = array(); // Initialize $src as an empty array before the loop
			$new_products = 0;
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
				$this->db->select('url')->from('facebook_group_scheduler')->where('user_id', $userID)->where('fb_group_id', $id)->where('url', $FinalUrl);
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
				$this->create_single_fb_group_rss_feed($userID, $id, $title, $src, $FinalUrl, $timeslots);
				$new_products++;
			}
			if ($new_products > 0) {
				$this->response(['status' => true, 'message' => 'Good Work! We are setting up your awesome feed, Please Wait.'], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => true, 'message' => 'Attension! There are no New Products to fetch right now.', 'produplicate' => true], REST_Controller::HTTP_OK);
			}
		}

		$if_rss_delete = $this->post('if_rss_delete'); // Means this function is for deleting rss_links
		if (!empty($if_rss_delete) && $if_rss_delete == 'yes') {
			if (!empty($rss_link)) {
				$this->db->select('rss_link')->from('facebook_groups')->where('id', $id);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link)) {
					$this->response(['status' => true, 'message' => 'The selected rss is removed from input successfully'], REST_Controller::HTTP_OK);
				}
				$decoded_rss_link = json_decode($result[0]->rss_link, true); // Convert to an associative array
				$index = array_search($rss_link, $decoded_rss_link);
				if ($index !== false) {
					unset($decoded_rss_link[$index]);
					$decoded_rss_link = array_values($decoded_rss_link); // Reset keys
				}
				// Check if the array is empty
				if (empty($decoded_rss_link)) {
					$encode_updated_link = ''; // Set it to an empty string
				} else {
					$encode_updated_link = json_encode($decoded_rss_link);
				}
				$this->db->set('rss_link', $encode_updated_link);
				$this->db->where('id', $id);

				if ($this->db->update('facebook_groups')) {
					$this->response(['status' => true, 'message' => 'The selected rss has been deleted successfully'], REST_Controller::HTTP_OK);
				} else {
					$this->response(['status' => false, 'message' => 'Something went wrong, please try again'], REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$this->response(['status' => false, 'message' => 'There is nothing to delete'], REST_Controller::HTTP_BAD_REQUEST);
			}
		} else {
			// $group_row = $this->Publisher_model->retrieve_record('facebook_groups', $id);
			/*$rss_link = array_filter($rss_link);
																																																																																																																																																																																																																																																																																																																																																		 $this->db->select('rss_link')->from('facebook_groups')->where('id',$id);
																																																																																																																																																																																																																																																																																																																																																		 $query = $this->db->get()->result_array();

																																																																																																																																																																																																																																																																																																																																																		 $all_rss_links = '';
																																																																																																																																																																																																																																																																																																																																																		 if(isset($query[0]['rss_link'])){
																																																																																																																																																																																																																																																																																																																																																			 $all_rss_links =  json_decode($query[0]['rss_link']);
																																																																																																																																																																																																																																																																																																																																																			 if(empty($all_rss_links)){ // means the rss was never encoded before so can't decode that shit
																																																																																																																																																																																																																																																																																																																																																				 $all_rss_links =  array($query[0]['rss_link']);
																																																																																																																																																																																																																																																																																																																																																			 }
																																																																																																																																																																																																																																																																																																																																																		 }

																																																																																																																																																																																																																																																																																																																																																		 if(!empty($all_rss_links)){
																																																																																																																																																																																																																																																																																																																																																			 $filtered_rss_links = array_diff($rss_link, $all_rss_links);
																																																																																																																																																																																																																																																																																																																																																		 }
																																																																																																																																																																																																																																																																																																																																																		 else{
																																																																																																																																																																																																																																																																																																																																																			 $filtered_rss_links = $rss_link;
																																																																																																																																																																																																																																																																																																																																																		 }

																																																																																																																																																																																																																																																																																																																																																		 $if_rss_fetch = $this->post('if_rss_fetch'); // Means this logic is for fetching sitemap 10 posts
																																																																																																																																																																																																																																																																																																																																																		 if (empty($filtered_rss_links) && $if_rss_fetch != 'yes') {
																																																																																																																																																																																																																																																																																																																																																			 $this->response(['status' => false, 'message' => 'Please Provide a new rss link, Please fix and try again'], REST_Controller::HTTP_BAD_REQUEST);
																																																																																																																																																																																																																																																																																																																																																		 }*/
			$encode_rss_links = json_encode($rss_link);

			//-----------------------------------------------Site mapping Start------------------------------------------------//
			$if_rss_fetch = $this->post('if_rss_fetch'); // Means this logic is for fetching sitemap 10 posts
			if (!empty($if_rss_fetch) && $if_rss_fetch == 'yes') {

				$sitemap_rss_link = $this->post('sitemap_rss_link'); // The rss link for which more posts are demanded //
				$this->db->select('rss_link')->from('facebook_groups')->where('id', $id);
				$result = $this->db->get()->result();
				if (empty($result[0]->rss_link)) {
					$this->response(['status' => false, 'message' => 'Please store this Link First by submitting'], REST_Controller::HTTP_BAD_REQUEST);
				}
				$decoded_rss_link = json_decode($result[0]->rss_link, true); // Convert to an associative array
				$index = array_search($sitemap_rss_link, $decoded_rss_link);
				if (!isset($index)) {
					$this->response(['status' => false, 'message' => 'Please store this Link First by submitting'], REST_Controller::HTTP_BAD_REQUEST);
				}
				$parsed_url = parse_url($sitemap_rss_link);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
					$sitemapUrl = $main_domain . '/sitemap.xml';
				}
				$sitemapContent = file_get_contents($sitemapUrl);
				$xml = new SimpleXMLElement($sitemapContent);


				$desiredPostCount = 10; // Set the desired number of posts

				foreach ($xml->sitemap as $sitemap) {
					$loc = (string) $sitemap->loc;

					// Check if the <loc> element contains "post-sitemap"
					if (strpos($loc, "post-sitemap") !== false || strpos($loc, "sitemap-post") !== false) {
						$sitemapUrl = $loc; // Use the filtered URL
						// echo "Sitemap URL: " . $sitemapUrl . "<br>";
						// Fetching the blog posts of the link
						$sitemapContent = file_get_contents($sitemapUrl);
						// Parse the content of each sitemap to extract post URLs
						$sitemapXml = new SimpleXMLElement($sitemapContent);

						$postUrls = array();
						$isFirstIteration = true; // Initialize the flag variable

						foreach ($sitemapXml->url as $url) {
							if ($isFirstIteration) {
								$isFirstIteration = false; // Set the flag to false after the first iteration
								continue; // Skip the first iteration
							}
							$postUrl = (string) $url->loc; // Cast to string to get the URL
							// Check if the URL is already in the database
							$this->db->select('url')->from('facebook_group_scheduler')->where('url', $postUrl)->where('fb_group_id', $id);
							$query = $this->db->get()->result_array();

							// Check if the URL is already in the array
							$isDuplicate = false;
							foreach ($postUrls as $existingUrl) {
								if ($postUrl === $existingUrl) {
									$isDuplicate = true;
									break;
								}
							}

							// If it's not in the database and not a duplicate in the array, add it
							if (count($query) === 0 && !$isDuplicate) {
								// Concatenate "/feed" to the URL and add it to the array
								$postUrls[] = $postUrl;

								// If you have reached the desired count, break the loop
								if (count($postUrls) >= $desiredPostCount) {
									break;
								}
							}
						}

						if (!empty($postUrls)) {
							foreach ($postUrls as $solo_urls) {
								// Fetching Single Post data
								$data = array();
								$options = array(
									CURLOPT_URL => $solo_urls,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_FOLLOWLOCATION => true,
									CURLOPT_CONNECTTIMEOUT => 30,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_SSL_VERIFYPEER => false,
									CURLOPT_SSL_VERIFYHOST => false,
									CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
								);

								$curl = curl_init();
								curl_setopt_array($curl, $options);
								$response = curl_exec($curl);
								// print_r($response);exit;
								$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
								curl_close($curl);
								if ($httpCode >= 200 && $httpCode < 300) {
									//Count Words of post
									$headers = array(
										'Content-type: application/json'
									);
									$opts = array(
										'http' =>
										array(
											'method' => 'GET',
											'header' => $headers,
											'ignore_errors' => true
										)
									);
									$context = stream_context_create($opts);
									$dom = new DOMDocument();
									libxml_use_internal_errors(true);
									$dom->loadHTML($response);
									libxml_clear_errors();
									$metaTitle = "";
									$ogimage = "";
									$ogimagesecure = "";
									$metaImage = "";
									$metaPublishTime = "";
									$metaTags = $dom->getElementsByTagName('meta');
									foreach ($metaTags as $meta) {
										if ($meta->getAttribute('property') == 'article:published_time') {
											$metaPublishTime = $meta->getAttribute('content');
											$dateTime = new DateTime($metaPublishTime);
											$metaPublishTime = $dateTime->format("Y-m-d h:i:s");
										}
										if ($meta->getAttribute('property') == 'og:title') {
											$metaTitle = $meta->getAttribute('content');
										}

										if ($meta->getAttribute('property') == 'og:image') {
											$ogimage = $meta->getAttribute('content');
										}
										if ($meta->getAttribute('property') == 'og:image:secure_url') {
											$ogimagesecure = $meta->getAttribute('content');
										}

										if (empty($metaTitle) && $meta->getAttribute('name') == 'twitter:title') {
											$metaTitle = $meta->getAttribute('content');
										}

										if (empty($ogimage) && $meta->getAttribute('name') == 'twitter:image') {
											$ogimage = $meta->getAttribute('content');
										}
									}

									if ($ogimage && $ogimagesecure && $ogimage == $ogimagesecure) {
										$metaImage = $ogimage;
									} elseif ($ogimagesecure) {
										$metaImage = $ogimagesecure;
									} else {
										$metaImage = $ogimage;
									}

									if (empty($metaImage)) {
										$scripts = $dom->getElementsByTagName('script');
										foreach ($scripts as $script) {
											if (strpos($script->getAttribute('type'), 'ld+json') !== false) {
												$jsonLdData = json_decode($script->nodeValue, true);
												if (isset($jsonLdData['@graph'][0]['thumbnailUrl'])) {
													$metaImage = $jsonLdData['@graph'][0]['thumbnailUrl'];
													break;
												}
											}
										}
									}
									if (!$metaImage) {
										$metaImage = base_url('assets/general/images/no_image_found.jpg');
									}
									$this->create_single_fb_group_rss_feed($userID, $id, $metaTitle, $metaImage, $solo_urls, $timeslots);
								} else {
									echo 'No Data found for this rss link ' . $solo_urls . '<br>';
								}
								// Ending single post data
							}
							// foreach ending
						}
					}

					// If the desired count of posts is reached, break the main loop
					if (count($postUrls) >= $desiredPostCount) {
						break;
					}
				}

				// If no new data is found, respond accordingly
				if (empty($postUrls)) {
					$this->response(['status' => false, 'message' => 'Your provided link has no more new Posts Right Now'], REST_Controller::HTTP_BAD_REQUEST);
				}

				$this->response(['status' => true, 'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'], REST_Controller::HTTP_OK);
			} // if condition
			//-------------------------------------------------Site mapping End------------------------------------------------//
			//---------------------------------------------Submit Process Starting---------------------------------------------//
			if ($rss_link) {
				if ($timeslots) {
					//Feed first time
					$arrContextOptions = array(
						"ssl" => array(
							"verify_peer" => false,
							"verify_peer_name" => false,
						),
					);

					$feed = [];
					foreach ($rss_link as $links) {
						$single_feed = file_get_contents($links, false, stream_context_create($arrContextOptions));
						if (!$single_feed) {
							$false_link = $links;
						} else {
							$feed[] = $single_feed;
						}
					}
					if ($feed) {
						$lastIteration = false; // Initialize a variable to track the last iteration
						foreach ($feed as $data) {
							$rss = simplexml_load_string($data);
							if ($rss) {
								if (isset($rss->channel->item)) {
									$few_issues = [];
									foreach ($rss->channel->item as $item) {
										$response = $this->metaOfUrlt($item->link);
										if ($response) {
											$where_rss = [];
											$where_rss[0]['key'] = 'url';
											$where_rss[0]['value'] = $item->link;
											$where_rss[1]['key'] = 'fb_group_id';
											$where_rss[1]['value'] = $id;
											$where_rss[2]['key'] = 'user_id';
											$where_rss[2]['value'] = $userID;
											$present = $this->Publisher_model->count_records('facebook_group_scheduler', $where_rss);
											if (!$present) {
												$img_path = $response['image'];
												if (empty($img_path)) {
													$img_path = base_url('assets/general/images/no_image_found.jpg');
												}
												$this->create_single_fb_group_rss_feed($userID, $id, $item->title, $img_path, $item->link, $timeslots);
											}
										} else {
											$few_issues['errors'][] = $item->link;
										}
										// $group_data['rss_link'] = $rss_link;
										// $result = $this->Publisher_model->update_record('facebook_groups', $group_data, $id);
									}
								} else {
									$this->response(['status' => false, 'message' => 'Your provided link has not valid RSS feed, Please fix and try again'], REST_Controller::HTTP_NOT_FOUND);
								}
							} else {

								$this->response(['status' => false, 'message' => 'Your provided link has not valid RSS feed, Please fix and try again'], REST_Controller::HTTP_NOT_FOUND);
							}
						} //foreach
						$lastIteration = true;
						// Code to execute after the last iteration
						if ($lastIteration) {
							$group_data['rss_link'] = $encode_rss_links;
							$result = $this->Publisher_model->update_record('facebook_groups', $group_data, $id);
							$this->response(['status' => true, 'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'], REST_Controller::HTTP_OK);
						}
					} else {
						$this->response(['status' => false, 'message' => 'Your provided link has not valid RSS feed, Please fix and try again'], REST_Controller::HTTP_NOT_FOUND);
					}
				} else {

					$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_NOT_FOUND);
				}
			} else {
				$this->response(['status' => false, 'message' => 'Your provided link has not valid RSS feed, Please fix and try again'], REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}

	public function create_single_fb_group_rss_feed($userID, $fb_group_id, $title, $img_path, $url, $timeslots)
	{
		$post_date_time = getNextPostTime("facebook_group_scheduler", $userID, $fb_group_id, $timeslots);

		$this_id = $this->Publisher_model->post_fb_group_rssschedule($userID, $fb_group_id, $title, $img_path, $url, $post_date_time);
		return $this_id;
	}

	public function fb_group_rss_update_timeslots_POST()
	{
		$this->sessioncheck();
		$id = trim($this->post('page'));
		$group_data['time_slots_rss'] = json_encode($this->post('time_slots'));
		$result = $this->Publisher_model->update_record('facebook_groups', $group_data, $id);

		$count_slots = count($this->post('time_slots'));

		$timeslots = implode(",", $this->post('time_slots'));

		if ($count_slots > 0) {
			$this->db->select('*')->from('facebook_group_scheduler')->where('fb_group_id', $id)->where('published', 0);
			$schedule_posts = $this->db->get()->result();

			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

			foreach ($schedule_posts as $posts) {

				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$publish_datetime = getNextPostTime("facebook_group_scheduler", $userID, $id, $timeslots, $for_update);

				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $publish_datetime;

				$this->Publisher_model->update_fb_group_rssschedule($primary_id, $publish_datetime);
			}
		}

		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function fb_group_rss_feed_onoff_POST()
	{
		$this->sessioncheck();
		$id = $this->post('page');
		$group_data['rss_active'] = $this->post('rss_active');
		$result = $this->Publisher_model->update_record('facebook_groups', $group_data, $id);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function shopify_fb_group_automation_onoff_POST()
	{
		$this->sessioncheck();
		$id = $this->post('page');
		$group_data['shopify_active'] = $this->post('shopify_active');
		$result = $this->Publisher_model->update_record('facebook_groups', $group_data, $id);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function delete_fb_group_rss_post_all_POST()
	{
		$this->sessioncheck();
		$id = $this->post('page');
		$with_error = $this->post('error');
		$type = $this->post('type');
		if ($with_error == "all" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('facebook_group_scheduler', 'fb_group_id', $id);
			$result = $this->db->query("DELETE FROM facebook_group_scheduler WHERE fb_group_id = $id AND image_link NOT LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "all" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('facebook_group_scheduler', 'fb_group_id', $id);
			$result = $this->db->query("DELETE FROM facebook_group_scheduler WHERE fb_group_id = $id AND image_link LIKE '%cdn.shopify.com%'");
		} elseif ($with_error == "error" && $type == 'rss') {
			// $result = $this->Publisher_model->delete_multiple('facebook_group_scheduler', 'fb_group_id', $id);
			$result = $this->db->query("DELETE FROM facebook_group_scheduler WHERE fb_group_id = $id AND image_link NOT LIKE '%cdn.shopify.com%' AND published =-1 AND error IS NOT NULL");
		} elseif ($with_error == "error" && $type == 'shopify') {
			// $result = $this->Publisher_model->delete_multiple('facebook_group_scheduler', 'fb_group_id', $id);
			$result = $this->db->query("DELETE FROM facebook_group_scheduler WHERE fb_group_id = $id AND image_link LIKE '%cdn.shopify.com%' AND published =-1 AND error IS NOT NULL");
		}
		/*else {
																																																																																																																																																																																																																																		  $result = $this->db->query("DELETE FROM facebook_group_scheduler WHERE fb_group_id =$id AND published =-1 AND error IS NOT NULL");
																																																																																																																																																																																																																																	  }*/
		if ($result) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts Removed Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',

			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function shuffle_fb_group_rss_post_all_POST()
	{
		$this->sessioncheck();
		$id = $this->post('page');

		$query = $this->db->query("SELECT publish_datetime FROM facebook_group_scheduler WHERE fb_group_id =$id AND published = 0 ORDER BY rand()");
		$random_slots = $query->result_array();

		$query_all = $this->db->query("SELECT * FROM facebook_group_scheduler WHERE fb_group_id =$id AND published = 0 ORDER BY publish_datetime ASC");
		$all_posts = $query_all->result_array();
		foreach ($all_posts as $key => $post) {
			$post_data['publish_datetime'] = $random_slots[$key]['publish_datetime'];
			$updated = $this->Publisher_model->update_record('facebook_group_scheduler', $post_data, $post['id']);
		}
		if ($all_posts) {
			$this->response(array(
				'status' => true,
				'message' => 'Your scheduled posts shuffled Successfully',

			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function delete_fb_group_rss_post_POST()
	{
		$this->sessioncheck();
		$id = $this->post('id');
		//Here get its time and date
		$post = $this->Publisher_model->retrieve_record('facebook_group_scheduler', $id);
		$new_result = [];
		// if (!$post->published) {
		// 	$post_date_time = $post->publish_datetime;
		// 	$user_id = $post->user_id;
		// 	$fb_group_id = $post->fb_group_id;
		// 	//Here get last valid post of the page which is pending to post
		// 	$query = "SELECT * FROM facebook_group_scheduler WHERE user_id= $user_id AND fb_group_id = $fb_group_id AND published = 0 ORDER BY publish_datetime DESC LIMIT 1";
		// 	$last_scedule = $this->db->query($query);
		// 	if (count($last_scedule->result()) > 0) {

		// 		$last_id = $last_scedule->row()->id;
		// 		// Now update its posting time
		// 		$post_data['publish_datetime'] = $post_date_time;
		// 		$updated = $this->Publisher_model->update_record('facebook_group_scheduler', $post_data, $last_id);
		// 		$row = $this->Publisher_model->retrieve_record('facebook_group_scheduler', $last_id);
		// 		$user_id = App::Session()->get('userid');
		// 		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		// 		$new_result['id'] = $row->id;
		// 		$new_result['title'] = $row->post_title;
		// 		$new_result['link'] = $row->image_link;
		// 		$new_result['url'] = $row->url;
		// 		$new_result['posted'] = $row->published;
		// 		$new_result['error'] = $row->error;
		// 		$new_result['post_date'] = utcToLocal($row->publish_datetime, $user->gmt, "F j, Y, g:i a");
		// 		$new_result['post_time'] = utcToLocal($row->publish_datetime, $user->gmt, "H:i A");
		// 	}
		// }

		if ($this->Publisher_model->delete_record('facebook_group_scheduler', $id)) {
			$this->response(array(
				'status' => true,
				'data' => $new_result,
				'message' => 'Your scheduled post Removed Successfully',
			), REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => false,
				'data' => '',
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function get_google_access_token_GET()
	{
		$code = $this->input->get('code');
		// get google access token
		if (!empty($code)) {
			$google_access_token = get_google_access_token_by_api($code);
			if ($google_access_token['success']) {
				$access_token = $google_access_token['access_token'];
				$google_id = $google_access_token['google_id'];
				$get_youtube_channels = get_youtube_channels_by_api($access_token, $google_id);
				if ($get_youtube_channels['success']) {
					redirect(SITEURL . 'schedule?status=true&message=YouTube Channel activated!');
				} else {
					redirect(SITEURL . 'schedule?status=false&message=' . $get_youtube_channels['error']);
				}
			}
		} else {
			redirect(SITEURL . 'schedule?status=false&message=Something went wrong!');
		}
	}

	public function fetch_youtube_categories_GET()
	{
		$userID = App::Session()->get('userid');
		$access_token = $this->Publisher_model->fetch_access_token();
		if ($access_token) {
			// $user_ip_address = $_SERVER['HTTP_X_REAL_IP'];
			// $ipinfo = file_get_contents("http://ipinfo.io/".$user_ip_address);
			// $ipinfo = json_decode($ipinfo, true);
			// $regionCode = $ipinfo['country'];
			$category_ids = "2,23,27,24,1,20,26,10,25,22,15,28,17,19";
			$url = "https://www.googleapis.com/youtube/v3/videoCategories?part=snippet&id=" . $category_ids;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $access_token
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$decodeResponse = json_decode($response, true);
			if (isset($decodeResponse['items']) && count($decodeResponse['items']) > 0) {
				$items = $decodeResponse['items'];
				$this->response(array(
					'status' => true,
					'data' => $items,
					'message' => 'Categories fetched successfully!',
				), REST_Controller::HTTP_OK);
			}
		} else {
			$this->response(array(
				'status' => false,
				'data' => '',
				'message' => 'Some Problem occured',
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function save_category($category, $region)
	{
		$detail = $category['snippet'];
		$check = array(
			'category_id' => $category['id'],
			''
		);
		$data = array(
			'category_title' => $detail['title']
		);
		$category_check = $this->db->get_where('youtube_categories', $check);
		if ($category_check->row() != null) {
			$response = $this->db->update('youtube_categories', $data, $check);
		} else {
			$data['category_id'] = $category['id'];
			$data['active'] = '1';
			$data['region'] = $region;
			$response = $this->db->insert('youtube_categories', $data);
		}
		return $response;
	}

	public function recent_posts_GET()
	{
		$social_type = $this->get('social_type');
		$page_id = isset($_GET['sub_social']) ? $this->get('sub_social') : '';
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		// searching
		$search = $this->get('search');
		// post type
		$type = $this->get('type');
		// current page
		$current_page = $this->get('current_page');
		$paging = $this->get('paging');
		// offset and limit
		$offset = ($current_page - 1) * $paging;
		// limit
		$limit = $this->get('paging');
		// columns
		$columns = $this->get('columns');
		// ordering
		$order = $this->get('order');
		if (!empty($order)) {
			$order_column = $order[0]['column'];
			$order = $order[0]['dir'];
			$orderBy = $columns[$order_column]['data'];
		} else {
			$order = 'asc';
			$orderBy = 'published_at';
		}
		if ($orderBy == 'post') {
			$orderBy = 'published_at';
		}
		// dates
		$start_date = $this->get('date');
		$where_date = start_end_date($start_date);
		// conditioning
		$where = [];
		$where[] = [
			'key' => 'user_id',
			'value' => $user_id,
		];
		if (!empty($type)) {
			$where[] = [
				'key' => 'type',
				'value' => $type,
			];
		}
		if ($social_type == 'facebook') {
			$where[] = [
				'key' => 'page_id',
				'value' => $page_id,
			];

			$posts = $this->Publisher_model->dataTable_list_records('facebook_posts', $search, $offset, $limit, $where, $orderBy, $order, $where_date);
			$posts_total = $this->Publisher_model->dataTable_list_records('facebook_posts', $search, 0, 100000, $where, 'id', 'asc', $where_date);
			$response = format_fb_page_recent_posts($posts, $user);
		} else if ($social_type == 'tiktok') {
			$where[] = [
				'key' => 'tiktok_id',
				'value' => $page_id,
			];

			$posts = $this->Publisher_model->dataTable_list_records('tiktok_posts', $search, $offset, $limit, $where, $orderBy, $order, $where_date);
			$posts_total = $this->Publisher_model->dataTable_list_records('tiktok_posts', $search, 0, 100000, $where, 'id', 'asc', $where_date);
			$response = format_tiktok_recent_posts($posts, $user);
		} else {
			// facebook posts
			$fb_page_posts = $this->Publisher_model->dataTable_list_records('facebook_posts', $search, $offset, $limit, $where, $orderBy, $order, $where_date);
			$fb_page_posts_total = $this->Publisher_model->dataTable_list_records('facebook_posts', $search, 0, 100000, $where, 'id', 'asc', $where_date);
			$fb_page_posts_response = format_fb_page_recent_posts($fb_page_posts, $user);
			// tiktok posts
			$tiktok_posts = $this->Publisher_model->dataTable_list_records('tiktok_posts', $search, $offset, $limit, $where, $orderBy, $order, $where_date);
			$tiktok_posts_total = $this->Publisher_model->dataTable_list_records('tiktok_posts', $search, 0, 100000, $where, 'id', 'asc', $where_date);
			$tiktok_posts_response = format_tiktok_recent_posts($tiktok_posts, $user);
			$posts_total = array_merge($fb_page_posts_total, $tiktok_posts_total);
			$aaData = array_merge($fb_page_posts_response['post_array'], $tiktok_posts_response['post_array']);
			$response = [
				'status' => true,
				'message' => 'Posts fetched Successfully!',
				'post_array' => $aaData
			];
		}
		$this->response(
			[
				'status' => $response['status'],
				'message' => $response['message'],
				"iTotalRecords" => count($posts_total),
				"iTotalDisplayRecords" => count($posts_total),
				"current_page" => $current_page,
				"total_pages" => (count($posts_total) / $limit) > 0 ? ceil((count($posts_total) / $limit)) : 0,
				"aaData" => $response['post_array'],
			],
			REST_Controller::HTTP_OK
		);
	}

	public function get_recent_posts_GET()
	{
		$social_type = $this->get('social_type');
		$page_id = isset($_GET['sub_social']) ? $this->get('sub_social') : '';
		$user_id = App::Session()->get('userid');
		// conditioning
		$where = [];
		$where[] = [
			'key' => 'user_id',
			'value' => $user_id,
		];
		// user
		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		if ($social_type == 'facebook') {
			$where[] = [
				'key' => 'page_id',
				'value' => $page_id,
			];
			$posts = $this->Publisher_model->dataTable_list_records('facebook_posts', '', '', 5, $where, 'published_at', 'desc');
			$response = format_fb_page_recent_posts($posts, $user);
		} else {
			$fb_page_posts = $this->Publisher_model->dataTable_list_records('facebook_posts', '', '', 5, $where, 'published_at', 'desc');
			$fb_page_posts_response = format_fb_page_recent_posts($fb_page_posts, $user);
			$response = $fb_page_posts_response;
		}
		$this->response(
			[
				'status' => $response['status'],
				'message' => $response['message'],
				"aaData" => $response['post_array']
			],
			REST_Controller::HTTP_OK
		);
	}

	public function page_insights_GET()
	{
		$social_type = $this->get('page_type');
		$page_id = $this->get('page_id');
		$all = empty($page_id) ? true : false;
		$user_id = App::Session()->get('userid');
		$start_date = $this->get('date');
		$where_date = start_end_date($start_date);
		$where = array('user_id' => $user_id);
		$pages = [];
		if (empty($social_type) || $social_type == 'facebook') {
			if (!empty($page_id)) {
				$where['page_id'] = $page_id;
			}
			$facebook_pages = $this->Publisher_model->get_allrecords('facebook_pages', $where);
			$all_pages_insight = [];
			foreach ($facebook_pages as $key => $value) {
				$pages[$key] = $value->page_id;
			}
			// get pages insights from database
			$all_pages_insight[0] = array(
				'followers' => ['value' => 0, 'html' => ''],
				'post_reach' => ['value' => 0, 'html' => ''],
				'engagements' => ['value' => 0, 'html' => ''],
				'video_views' => ['value' => 0, 'html' => ''],
				'talking_about' => ['value' => 0, 'html' => ''],
				'link_clicks' => ['value' => 0, 'html' => ''],
				'ctr' => ['value' => 0, 'html' => ''],
				'eng_rate' => ['value' => 0, 'html' => ''],
				'reach_rate' => ['value' => 0, 'html' => ''],
			);
			$page_insights = $this->Publisher_model->get_page_insights($pages, $where_date);
			$date = date('d M, Y', strtotime($where_date['start_date'])) . ' - ' . date('d M, Y', strtotime($where_date['end_date']));
			// followers
			$followers_count = $this->Publisher_model->get_page_insights($pages, $where_date, 'followers');
			$followers_count = count($followers_count) > 0 ? $followers_count[0]->total_followers : 0;
			$followers_html = bar_chart($followers_count, 'followers_chart', $date, 'Followers');

			$all_pages_insight[0]['followers']['value'] = number_to_short($followers_count);
			$all_pages_insight[0]['followers']['html'] .= $followers_html;

			// post reach
			$reach_count = isset($page_insights[0]) ? $page_insights[0]->total_reach : 0;
			$reach_html = bar_chart($reach_count, 'post_reach_chart', $date, 'Post Reach');

			$all_pages_insight[0]['post_reach']['value'] = number_to_short($reach_count);
			$all_pages_insight[0]['post_reach']['html'] .= $reach_html;

			// post engagements
			$engagements_count = isset($page_insights[0]) ? $page_insights[0]->total_engagements : 0;
			$engagements_html = bar_chart($engagements_count, 'engagements_chart', $date, 'Engagements');

			$all_pages_insight[0]['engagements']['value'] = number_to_short($engagements_count);
			$all_pages_insight[0]['engagements']['html'] .= $engagements_html;

			// post insights
			$post_insights = $this->Publisher_model->get_post_insights($pages, $where_date);

			// video views
			$video_views = $this->Publisher_model->get_post_insights($pages, $where_date, 'video_views');
			$video_views_count = isset($video_views[0]) ? $video_views[0]->video_views : 0;
			$video_views_html = bar_chart($video_views_count, 'video_views_chart', $date, 'Video Views');

			$all_pages_insight[0]['video_views']['value'] = !empty($video_views_count) ? number_to_short($video_views_count) : 0;
			$all_pages_insight[0]['video_views']['html'] .= $video_views_html;

			// link clicks	
			$link_clicks = $this->Publisher_model->get_post_insights($pages, $where_date, 'link_clicks');
			$link_clicks_count = isset($link_clicks[0]) ? $link_clicks[0]->link_clicks : 0;
			$link_clicks_html = bar_chart($link_clicks_count, 'link_clicks_chart', $date, 'Link Clicks');

			$all_pages_insight[0]['link_clicks']['value'] = !empty($link_clicks_count) ? number_to_short($link_clicks_count) : 0;
			$all_pages_insight[0]['link_clicks']['html'] .= $link_clicks_html;

			// ctr
			$ctr_count = isset($post_insights[0]) ? $post_insights[0]->ctr : 0;
			$ctr_html = bar_chart($ctr_count, 'ctr_chart', $date, 'CTR');

			$all_pages_insight[0]['ctr']['value'] = !empty($ctr_count) ? number_to_short($ctr_count) . ' %' : '0 %';
			$all_pages_insight[0]['ctr']['html'] .= $ctr_html;

			// engagement reach
			$eng_rate_count = isset($post_insights[0]) ? $post_insights[0]->eng_rate : 0;
			$eng_rate_html = bar_chart($eng_rate_count, 'eng_rate_chart', $date, 'Eng Rate');

			$all_pages_insight[0]['eng_rate']['value'] = !empty($eng_rate_count) ? number_to_short($eng_rate_count) . ' %' : '0 %';
			$all_pages_insight[0]['eng_rate']['html'] .= $eng_rate_html;

			// reach rate
			$reach_rate_count = isset($post_insights[0]) ? $post_insights[0]->reach_rate : 0;
			$reach_rate_html = bar_chart($reach_rate_count, 'reach_rate_chart', $date, 'Reach Rate');

			$all_pages_insight[0]['reach_rate']['value'] = !empty($reach_rate_count) ? number_to_short($reach_rate_count) . ' %' : '0 %';
			$all_pages_insight[0]['reach_rate']['html'] .= $reach_rate_html;
		} else if ($social_type == 'tiktok') {
			if (!empty($page_id)) {
				$where['id'] = $page_id;
			}
			$tiktoks = $this->Publisher_model->get_allrecords('tiktok', $where);
			$all_pages_insight = [];
			foreach ($tiktoks as $key => $value) {
				$pages[$key] = $value->id;
			}
			// get pages insights from database
			$all_pages_insight[0] = array(
				'followers' => ['value' => 0, 'html' => ''],
				'post_reach' => ['value' => 0, 'html' => ''],
				'engagements' => ['value' => 0, 'html' => ''],
				'video_views' => ['value' => 0, 'html' => ''],
				'talking_about' => ['value' => 0, 'html' => ''],
				'link_clicks' => ['value' => 0, 'html' => ''],
				'ctr' => ['value' => 0, 'html' => ''],
				'eng_rate' => ['value' => 0, 'html' => ''],
				'reach_rate' => ['value' => 0, 'html' => ''],
			);
			$date = date('d M, Y', strtotime($where_date['start_date'])) . ' - ' . date('d M, Y', strtotime($where_date['end_date']));

			$post_insights = $this->Publisher_model->tiktok_post_insights($pages, $where_date);
			$post_insights = $post_insights[0];

			$followers_html = bar_chart(0, 'followers_chart', $date, 'Followers');
			$all_pages_insight[0]['followers']['value'] = 0;
			$all_pages_insight[0]['followers']['html'] .= $followers_html;

			// post reach
			$reach_count = $post_insights->view_count > 0 ? $post_insights->view_count : 0;
			$reach_html = bar_chart($reach_count, 'post_reach_chart', $date, 'Post Reach');

			$all_pages_insight[0]['post_reach']['value'] = number_to_short($reach_count);
			$all_pages_insight[0]['post_reach']['html'] .= $reach_html;

			// post engagements
			$engagements = $post_insights->like_count + $post_insights->comment_count + $post_insights->share_count;
			$engagements_count = $engagements;
			$engagements_html = bar_chart($engagements_count, 'engagements_chart', $date, 'Engagements');

			$all_pages_insight[0]['engagements']['value'] = number_to_short($engagements_count);
			$all_pages_insight[0]['engagements']['html'] .= $engagements_html;

			// video views
			$video_views_count = $post_insights->view_count;
			$video_views_html = bar_chart($video_views_count, 'video_views_chart', $date, 'Video Views');

			$all_pages_insight[0]['video_views']['value'] = !empty($video_views_count) ? number_to_short($video_views_count) : 0;
			$all_pages_insight[0]['video_views']['html'] .= $video_views_html;

			// link clicks	
			$link_clicks_count = 0;
			$link_clicks_html = bar_chart($link_clicks_count, 'link_clicks_chart', $date, 'Link Clicks');

			$all_pages_insight[0]['link_clicks']['value'] = !empty($link_clicks_count) ? number_to_short($link_clicks_count) : 0;
			$all_pages_insight[0]['link_clicks']['html'] .= $link_clicks_html;

			// ctr
			$ctr_count = 0;
			$ctr_html = bar_chart($ctr_count, 'ctr_chart', $date, 'CTR');

			$all_pages_insight[0]['ctr']['value'] = !empty($ctr_count) ? number_to_short($ctr_count) . ' %' : '0 %';
			$all_pages_insight[0]['ctr']['html'] .= $ctr_html;

			// engagement reach
			$eng_rate = $reach_count > 0 ? ($engagements / $reach_count) * 100 : 0;
			$eng_rate_count = $eng_rate;
			$eng_rate_html = bar_chart($eng_rate_count, 'eng_rate_chart', $date, 'Eng Rate');

			$all_pages_insight[0]['eng_rate']['value'] = !empty($eng_rate_count) ? number_to_short($eng_rate_count) . ' %' : '0 %';
			$all_pages_insight[0]['eng_rate']['html'] .= $eng_rate_html;

			// reach rate
			$reach_rate_count = 0;
			$reach_rate_html = bar_chart($reach_rate_count, 'reach_rate_chart', $date, 'Reach Rate');

			$all_pages_insight[0]['reach_rate']['value'] = !empty($reach_rate_count) ? number_to_short($reach_rate_count) . ' %' : '0 %';
			$all_pages_insight[0]['reach_rate']['html'] .= $reach_rate_html;
		}

		return $this->response(
			[
				'data' => $all_pages_insight
			],
			REST_Controller::HTTP_OK
		);
	}

	public function get_countires_data_GET()
	{
		$user_id = App::Session()->get('userid');
		$date = $this->get('date');
		$page_id = $this->get('page_id');
		$page_type = $this->get('page_type');
		$now = date('Y-m-d');
		$until = strtotime($now);
		if ($date == 'last_7_days') {
			$days = '-8 days';
		} else if ($date == 'last_14_days') {
			$days = '-15 days';
		} else if ($date == 'last_28_days') {
			$days = '-29 days';
		} else {
			$days = '-91 days';
		}
		$since = date('Y-m-d', strtotime($days));
		$since = strtotime($since);
		$country_data = [];
		$dates = [];
		$count = 0;
		$country_names = [];
		if ($page_type == 'facebook') {
			// get facebook pages
			$facebook_pages = !empty($page_id) ? $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id)) : $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id));
			foreach ($facebook_pages as $page) {
				$cache_key = 'get_countries_data_' . $days . '_' . $user_id . '_' . $page->page_id . '_' . $days;
				$cache_data = get_cache_data($cache_key, $user_id, ['page_id' => $page->page_id, 'access_token' => $page->access_token, 'since' => $since, 'until' => $until]);
				$cache_data = $cache_data['data'];
				if (count($dates) <= 0) {
					$dates_array = array_keys($cache_data);
					foreach ($dates_array as $key => $val) {
						$dates[$key] = date('y-m-d', $val);
					}
				}
				$count += count($cache_data);
				foreach ($cache_data as $key => $value) {
					foreach ($value as $name => $val) {
						if (isset($country_data[$name][$key])) {
							$country_data[$name][$key] += $val;
						} else {
							$country_data[$name][$key] = $val;
							array_push($country_names, $name);
						}
					}
				}
			}
		}
		$response = [
			'data' => $country_data,
			'dates' => $dates,
			'date_labels' => $dates,
			'country_names' => $country_names,
			'count' => $count
		];
		$this->response($response, REST_Controller::HTTP_OK);
	}

	public function get_cities_data_GET()
	{
		$user_id = App::Session()->get('userid');
		$date = $this->get('date');
		$page_id = $this->get('page_id');
		$page_type = $this->get('page_type');
		$now = date('Y-m-d');
		$until = strtotime($now);
		if ($date == 'last_7_days') {
			$days = '-8 days';
		} else if ($date == 'last_14_days') {
			$days = '-15 days';
		} else if ($date == 'last_28_days') {
			$days = '-29 days';
		} else {
			$days = '-91 days';
		}
		$since = date('Y-m-d', strtotime($days));
		$since = strtotime($since);
		$cities_data = [];
		$dates = [];
		$count = 0;
		$city_names = [];
		if ($page_type == 'facebook') {
			// get facebook pages
			$facebook_pages = !empty($page_id) ? $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id)) : $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id));
			foreach ($facebook_pages as $page) {
				$cache_key = 'get_cities_data_' . $days . '_' . $user_id . '_' . $page->page_id . '_' . $days;
				$cache_data = get_cache_data($cache_key, $user_id, ['page_id' => $page->page_id, 'access_token' => $page->access_token, 'since' => $since, 'until' => $until]);
				$cache_data = $cache_data['data'];
				if (count($dates) <= 0) {
					$dates_array = array_keys($cache_data);
					foreach ($dates_array as $key => $val) {
						$dates[$key] = date('y-m-d', $val);
					}
				}
				$count += count($cache_data);
				foreach ($cache_data as $key => $value) {
					foreach ($value as $name => $val) {
						if (isset($cities_data[$name][$key])) {
							$cities_data[$name][$key] += $val;
						} else {
							$cities_data[$name][$key] = $val;
							array_push($city_names, $name);
						}
					}
				}
			}
		}
		$response = [
			'data' => $cities_data,
			'dates' => $dates,
			'date_labels' => $dates,
			'city_names' => $city_names,
			'count' => $count
		];
		$this->response($response, REST_Controller::HTTP_OK);
	}

	public function refresh_insights_POST()
	{
		$social_account = $this->post('social');
		$page_id = $this->post('page');
		$user_id = App::Session()->get('userid');
		$where = [];
		if ($social_account == 'facebook') {
			$where['user_id'] = $user_id;
			$where['type'] = 'facebook';
			$where['published'] = 1;
			if ($page_id != 'all') {
				$where['pageid'] = $page_id;
			}
			$get_facebook_cronjobs = $this->Publisher_model->get_allrecords('analytics_cronjob', $where);
			foreach ($get_facebook_cronjobs as $cronjob) {
				$id = $cronjob->id;
				$data = array(
					'posts_count' => 0,
					'published' => 0,
					'posts_cronjob' => 0,
					'insight_cronjob' => 0,
					'response' => ''
				);
				$this->db->where('id', $id);
				$this->db->update('analytics_cronjob', $data);
			}
			$this->response(['status' => true, 'message' => 'Syncing in Progress...'], REST_Controller::HTTP_OK);
		} else {
			$where['user_id'] = $user_id;
			$where['type'] = 'facebook';
			$where['published'] = 1;
			$get_facebook_cronjobs = $this->Publisher_model->get_allrecords('analytics_cronjob', $where);
			foreach ($get_facebook_cronjobs as $cronjob) {
				$id = $cronjob->id;
				$data = array(
					'published' => 0,
					'posts_cronjob' => 0,
					'insight_cronjob' => 0,
					'posts_count' => 0,
					'response' => ''
				);
				$this->db->where('id', $id);
				$this->db->update('analytics_cronjob', $data);
			}
			$this->response(['status' => true, 'message' => 'Syncing in Progress...'], REST_Controller::HTTP_OK);
		}
	}

	public function check_insights_status_GET()
	{
		$page_id = $this->get('page_id');
		$page_type = $this->get('type');
		$user_id = App::Session()->get('userid');
		if ($page_type == 'facebook') {
			$facebook_page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id));
			if (count($facebook_page) > 0) {
				$response = check_fb_page_insight_status($facebook_page);
				$this->response(['status' => $response['refresh'], 'message' => $response['button_message']], REST_Controller::HTTP_OK);
			}
		} else if ($page_type == 'tiktok') {
			$tiktok = $this->Publisher_model->retrieve_record('tiktok', $page_id);
			if ($tiktok->published == 1) {
				$this->response(['status' => true, 'message' => "Sync Insights"], REST_Controller::HTTP_OK);
			}
		}
		$this->response(['status' => false, 'message' => 'Syncing in Progress ...'], REST_Controller::HTTP_OK);
	}

	public function get_post_info_GET()
	{
		$id = $this->get('id');
		$type = $this->get('type');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		$post = $this->Publisher_model->retrieve_record('facebook_posts', $id);
		$page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $post->page_id));
		$response = popup_div($post, $page, $user);
		$non_follower_reach = $post->reach - $post->follower_reach;
		$this->response(['status' => true, 'data' => $response, 'followers' => $post->follower_reach, 'non_followers' => $non_follower_reach], REST_Controller::HTTP_OK);
	}

	public function short_urls_GET()
	{
		$user_id = App::Session()->get('userid');
		$limit = $this->get('limit');
		$urls = [];
		$short_urls = $this->Publisher_model->get_allrecords('short_urls', array('user_id' => $user_id));
		foreach ($short_urls as $key => $url) {
			$url_link = '<a target="_blank" href="' . $url->url_link . '"><span>' . $url->url_link . '</span></a>';
			$url_short = '<span>' . $url->url_short . '</span> &nbsp; <a target="_blank" href="https://adub.link/' . $url->url_short . '"><i class="fa fa-external-link"></i></a>';
			$url_array = array(
				'sr' => $key + 1,
				'url' => $url_link,
				'short_url' => $url_short,
				'published' => date('M d, Y', strtotime($url->url_date))
			);
			array_push($urls, $url_array);
		}
		$this->response(["iTotalRecords" => count($urls), "iTotalDisplayRecords" => count($urls), "aaData" => $urls,], REST_Controller::HTTP_OK);
	}

	public function short_my_link_POST()
	{
		$response = [];
		$response['status'] = false;
		$response['link'] = '';
		$response['message'] = '';
		$user_id = App::Session()->get('userid');
		$alias = $this->post('url');
		$utm = $this->post('utm');

		if (strlen($alias) > 10) {

			if ($this->valid_url($alias)) {
				if ($utm) {
					// make utm encoded url
					$utm_details = [];
					$utm_check = false;
					$url_detail = getDomain($alias);
					if (!empty($url_detail['url'])) {
						$domain = $url_detail['url'];
						$utm_details = getUtm($domain, $user_id);
						if (count($utm_details) > 0) {
							$alias = make_utm_url($alias, $utm_details, 'social_profile', 'social_network');
						}
					}
					// make utm encoded url
				}
				$short_link = $this->get_or_create($alias);
				$response['link'] = 'https://adublisher.com/link/' . $short_link;
				$response['alias'] = $alias;
				$response['status'] = true;
			} else {
				$response['message'] = 'Provided url is not valid.';
			}
		} else {
			$response['message'] = "Please provide complete and valid url.";
		}
		echo json_encode($response);
	}

	public function valid_url($str)
	{
		return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}

	public function get_or_create($link)
	{
		$short_link = "";
		$result = $this->short_from_url($link);
		if ($result) {
			$short_link = $result->url_short;
		} else {

			$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
			while ($this->does_short_exist($short)) {
				$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
			}

			$this->save_new_short($link, $short);
			$short_link = $short;
		}
		return $short_link;
	}

	public function save_new_short($url, $alias)
	{
		$user_id = App::Session()->get('userid');
		$data = array(
			'url_short' => $alias,
			'url_link' => $url,
			'user_id' => $user_id
		);
		$this->db->insert('short_urls', $data);
	}

	public function short_from_url($url)
	{
		$alias = "";
		$this->db->select('url_short');
		$query = $this->db->get_where('short_urls', array('url_link' => $url), 1, 0);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function does_short_exist($alias)
	{
		$this->db->select('*');
		$query = $this->db->get_where('short_urls', array('url_short' => $alias), 1, 0);
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function save_url_utm_POST()
	{
		limit_check(URL_TRACKING_ID);
		$url = trim($this->post('url'));
		$campaign = $this->post('campaign');
		$medium = $this->post('medium');
		$source = $this->post('source');
		$custom_tags_name = $this->post('custom_tags_name');
		$custom_tags_value = $this->post('custom_tags_value');
		$user_id = check_user_login() ? App::Session()->get('userid') : '';
		if (strlen($url) > 10) {
			if ($this->valid_url($url)) {
				$getDomain = getDomain($url);
				$data = array(
					'url' => $getDomain['url'],
					'scheme' => $getDomain['scheme'],
					'user_id' => $user_id,
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->db->insert('tracking_urls', $data);
				$url_id = $this->db->insert_id();
				$utm = array(
					'campaign' => array(
						'type' => 'campaign',
						'value' => $campaign,
					),
					'medium' => array(
						'type' => 'medium',
						'value' => $medium,
					),
					'source' => array(
						'type' => 'source',
						'value' => $source,
					),
				);
				if (!empty($custom_tags_name)) {
					foreach ($custom_tags_name as $key => $name) {
						$utm[$name] = $custom_tags_value[$key];
					}
				}
				$this->save_utm_data($utm, $url_id);
				resources_update('up', URL_TRACKING_ID);
				$response = array(
					'status' => true,
					'message' => $url_id
				);
			} else {
				$response = array(
					'status' => false,
					'message' => 'Provided url is not valid.'
				);
			}
		} else {
			$response = array(
				'status' => false,
				'message' => 'Please provide complete and valid url.'
			);
		}
		$this->response($response);
	}

	public function delete_url_GET()
	{
		$id = $this->get('id');
		$utm = $this->Publisher_model->retrieve_record('tracking_urls', $id);
		if (!empty($utm)) {
			// delete utms codes
			$this->db->where('url_id', $utm->id);
			$this->db->delete('utm_urls');
			// delete url
			$this->db->where('id', $id);
			$this->db->delete('tracking_urls');
			resources_update('down', URL_TRACKING_ID);
			$response = [
				'status' => true,
				'message' => 'URL deleted successfully!'
			];
		} else {
			$response = [
				'status' => false,
				'message' => 'URL not found!'
			];
		}
		$this->response($response, REST_Controller::HTTP_OK);
	}

	public function update_url_POST($id = null)
	{
		if (!empty($id)) {
			$utm = $this->Publisher_model->retrieve_record('tracking_urls', $id);
			if (!empty($utm)) {
				// url
				$url = $this->post('url');
				// utm campaign
				$utm_campaign = $this->post('utm_campaign_value') != 'social_network' && $this->post('utm_campaign_value') != 'social_profile' ? $this->post('campaign_custom_value') : $this->post('utm_campaign_value');
				// utm medium
				$utm_medium = $this->post('utm_medium_value') != 'social_network' && $this->post('utm_medium_value') != 'social_profile' ? $this->post('medium_custom_value') : $this->post('utm_medium_value');
				// utm source
				$utm_source = $this->post('utm_source_value');
				// custom trackings
				$tracking_tags = $this->post('tracking_tag');
				$custom_trackings = [];
				// update url and scheme
				$getDomain = getDomain($url);
				$url_update = array(
					'url' => $getDomain['url'],
					'scheme' => $getDomain['scheme'],
				);
				$this->Publisher_model->update_record('tracking_urls', $url_update, $id);

				// delete previous utm tracks
				$this->Publisher_model->delete_multiple('utm_urls', 'url_id', $id);

				// update utm tracks
				$utm_update = [
					'campaign' => $utm_campaign,
					'medium' => $utm_medium,
					'source' => $utm_source,
				];
				if (!empty($tracking_tags)) {
					foreach ($this->post('tracking_tag') as $key => $tag) {
						$custom_tag_value = $this->post('tracking_tag_value')[$key] == 'custom' ? $this->post('tracking_tag_custom_value')[$key] : $this->post('tracking_tag_value')[$key];
						$utm_update[$tag] = $custom_tag_value;
					}
				}
				$this->update_utm_data($utm_update, $id);
				redirect(SITEURL . "edit_url/" . $id);
			} else {
				redirect(SITEURL . "url-tracking");
			}
		} else {
			redirect(SITEURL . "url-tracking");
		}
	}

	function track_status_POST()
	{
		$id = $this->post('id');
		$status = $this->post('status');
		$url_track = $this->Publisher_model->retrieve_record('tracking_urls', $id);
		if (!empty($url_track)) {
			$status = $status == 'ON' ? 1 : 0;
			$this->Publisher_model->update_record('tracking_urls', array('status' => $status), $id);
			$response = [
				'status' => true,
				'message' => 'Status updated Successfully!'
			];
		} else {
			$response = [
				'status' => false,
				'message' => 'URL not found!'
			];
		}
		$this->response($response, REST_Controller::HTTP_OK);
	}

	public function save_utm_data($utm, $url_id)
	{
		foreach ($utm as $key => $val) {
			$data = array(
				'url_id' => $url_id,
				'type' => $val['type'],
				'value' => $val['value'],
			);
			$this->db->insert('utm_urls', $data);
		}
		return true;
	}
	public function update_utm_data($utm, $id)
	{

		foreach ($utm as $key => $val) {
			$data = array(
				'type' => $key,
				'value' => $val,
				'url_id' => $id
			);
			$this->db->insert('utm_urls', $data);
		}
		return true;
	}

	public function url_tracks_GET()
	{
		$user_id = App::Session()->get('userid');
		$url_tracks = array();
		$tracking_urls = $this->Publisher_model->get_allrecords('tracking_urls', array('user_id' => $user_id));
		foreach ($tracking_urls as $key => $url) {
			$utms = $this->Publisher_model->get_allrecords('utm_urls', array('url_id' => $url->id));
			$tracks['sr'] = $key + 1;
			$full_url = $url->scheme . '://' . $url->url;
			$tracks['url'] = $full_url . ' <a class="px-2" target="_blank" href="' . $full_url . '"><i class="fa fa-external-link"></i></a>';
			$tracks['published'] = date('M d, Y', strtotime($url->created_at));
			foreach ($utms as $utm) {
				$tracks[$utm->type] = ucwords(preg_replace('/_/', ' ', $utm->value));
			}
			$status = $url->status ? "checked" : "";
			$switch = '<label class="switch">
							<input type="checkbox" class="track_status" data-id="' . $url->id . '" ' . $status . '>
							<div class="slider"></div>
							<div class="slider-card">
								<div class="slider-card-face slider-card-front"></div>
								<div class="slider-card-face slider-card-back"></div>
							</div>
						</label>';
			$tracks['status'] = $switch;
			$tracks['action'] = "";
			$tracks['action'] .= "<a class='btn delete_url text-danger' data-id='" . $url->id . "'><i class='fa fa-trash'></i></a>";
			$edit_url = SITEURL . 'edit_url/' . $url->id;
			$tracks['action'] .= "<a href='" . $edit_url . "' class='btn text-info'><i class='fa fa-pen'></i></a>";
			array_push($url_tracks, $tracks);
		}
		$this->response(["iTotalRecords" => count($url_tracks), "iTotalDisplayRecords" => count($url_tracks), "aaData" => $url_tracks,], REST_Controller::HTTP_OK);
	}

	public function url_redirect_GET($domain = null, $user_id = null)
	{
		if (!empty($domain) && !empty($user_id)) {
			// make utm encoded url
			$utm_details = getUtm($domain, $user_id);
			$make_utm_url = count($utm_details) > 0 ? make_utm_url('', $utm_details, 'social_profile', 'social_network') : '';
			// make utm encoded url
			$this->response(array('utm' => $make_utm_url), REST_Controller::HTTP_OK);
		}
	}

	public function user_features_GET()
	{
		$user_id = App::Session()->get('userid');
		// get package features
		$sql = "SELECT * from package_feature_user_limit where uid=" . $user_id;
		$query = $this->db->query($sql);
		$features = $query->result_array();
		$f_array = [];
		foreach ($features as $key => $value) {
			if ($value['fid'] == LINK_SHORTENER_ID) {
				$f_array["LINK_SHORTENER_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == URL_TRACKING_ID) {
				$f_array["URL_TRACKING_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_PUBLISHING_FB_ID) {
				$f_array["POST_PUBLISHING_FB_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_PUBLISHING_INST_ID) {
				$f_array["POST_PUBLISHING_INST_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_PUBLISHING_PIN_ID) {
				$f_array["POST_PUBLISHING_PIN_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_PUBLISHING_YT_ID) {
				$f_array["POST_PUBLISHING_YT_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_SCHEDULING_FB_ID) {
				$f_array["POST_SCHEDULING_FB_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_SCHEDULING_INST_ID) {
				$f_array["POST_SCHEDULING_INST_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_SCHEDULING_PIN_ID) {
				$f_array["POST_SCHEDULING_PIN_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == POST_SCHEDULING_YT_ID) {
				$f_array["POST_SCHEDULING_YT_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == GROUP_POSTING_ID) {
				$f_array["GROUP_POSTING_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == RSS_FEED_LATEST_POST_FETCH_ID) {
				$f_array["RSS_FEED_LATEST_POST_FETCH_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == RSS_FEED_OLD_POST_FETCH_ID) {
				$f_array["RSS_FEED_OLD_POST_FETCH_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == RSS_FEED_CATEGORY_FETCH_ID) {
				$f_array["RSS_FEED_CATEGORY_FETCH_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == RSS_FEED_POST_PUBLISH_ID) {
				$f_array["RSS_FEED_POST_PUBLISH_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == FACEBOOK_ANALYTICS_ID) {
				$f_array["FACEBOOK_ANALYTICS_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
			if ($value['fid'] == AUTHORIZE_SOCIAL_ACCOUNTS_ID) {
				$f_array["AUTHORIZE_SOCIAL_ACCOUNTS_ID"] = [
					'quota' => $value['quota'],
					'used' => $value['used'],
					'unlimited' => $value['is_unlimited'],
				];
			}
		}
		print_pre($f_array);
	}

	public function get_calendar_events_GET()
	{
		$events = [];
		$type = isset($_GET['type']) ? $this->get('type') : 'MONTH';
		// $fb_offset = $this->get('fb_offset');
		$start_date = $this->get('start');
		$end_date = $this->get('end');
		$start_date = date('Y-m-d', strtotime($start_date));
		// $start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
		$end_date = date('Y-m-d', strtotime('+1 day', strtotime($end_date)));
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		// get US holidays
		$year = date('Y', strtotime($start_date));
		$month = date('m', strtotime($start_date));
		$cache_key = 'us_holidays_events_' . $year . '_' . $month;
		$us_holidays = get_cache_data($cache_key, $user_id, array('year' => $year, 'month' => $month));
		foreach ($us_holidays['data'] as $date => $title) {
			// event array
			if ($type == 'DAY') {
				$start = date('Y-m-d', strtotime($date));
				$event['setAllDay'] = true;
				// $start = utcToLocal($date, $user->gmt, 'Y-m-d h:i');
			} elseif ($type == 'WEEK') {
				$start = date('Y-m-d', strtotime($date));
				$event['setAllDay'] = true;
				// $start = utcToLocal($date, $user->gmt, 'Y-m-d H:i');
			} else {
				$start = date('Y-m-d', strtotime($date));
				// $start = utcToLocal($date, $user->gmt, 'Y-m-d');
			}
			$event = [
				'id' => 'us_event',
				'title' => '<span title="' . $title . '"> ' . substr($title, 0, 18) . ' <i class="fa fa-ribbon text-warning"></i></span>',
				'start' => $start,
				'className' => 'us_events bg_dark_light',
			];
			array_push($events, $event);
		}
		// get facebook published posts
		$cache_key = 'fb_pub_calendar_events_' . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
		$fb_published_posts = get_cache_data($cache_key, $user_id, array('start_date' => $start_date, 'end_date' => $end_date));
		foreach ($fb_published_posts['data'] as $post) {
			$page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $post->page_id));
			if (count($page) > 0) {
				$page = $page[0];
			} else {
				$this->Publisher_model->delete_record('facebook_posts', $post->id);
			}
			// post data array
			$post_data = [
				'published_at' => $post->published_at,
				'post_title' => $post->post_title,
				'post_image' => !empty($post->post_image) ? BulkAssets . $post->post_image : '',
				'post_reach' => $post->reach,
				'post_engagements' => $post->engagements,
				'post_likes' => $post->likes,
			];
			// event title as 
			$title = calendar_event_title($page->page_name, $post_data, $user, 'facebook', $type);
			// event start date/time
			if ($type == 'DAY') {
				$start = utcToLocal($post->published_at, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} elseif ($type == 'WEEK') {
				$start = utcToLocal($post->published_at, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} else {
				$start = utcToLocal($post->published_at, $user->gmt, 'Y-m-d');
			}
			// event array
			$event = [
				'id' => 'facebook_posts-' . $post->id,
				'title' => $title,
				'start' => $start,
				'className' => 'published'
			];
			array_push($events, $event);
		}
		// get scheduled posts
		$cache_key = 'social_scheduled_calendar_events_' . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
		$fb_scheduled_posts = get_cache_data($cache_key, $user_id, array('start_date' => $start_date, 'end_date' => $end_date));
		foreach ($fb_scheduled_posts['data'] as $post) {
			$page_id = $post->channel_id;
			$post_type = $post->type;
			if ($post_type == 'facebook') {
				$page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'id' => $page_id));
			} else if ($post_type == 'pinterest') {
				$page = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $user_id, 'id' => $page_id));
			} else if ($post->type == 'tiktok') {
				$page = $this->Publisher_model->get_allrecords('tiktok', array('user_id' => $user_id, 'id' => $page_id));
			}
			if (count($page) > 0) {
				$page = $page[0];
			} else {
				$this->Publisher_model->delete_record('channels_scheduler', $post->id);
			}

			// post data array
			$post_data = [
				'published_at' => $post->post_datetime,
				'post_title' => $post->post_title,
				'post_image' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? $post->link : BulkAssets . $post->link,
				'post_reach' => 0,
				'post_engagements' => 0,
				'post_likes' => 0,
			];
			// post type
			$post_type = $post->type;
			// page name
			if ($post_type == 'facebook') {
				$page_name = $page->page_name;
			} else if ($post_type == 'pinterest') {
				$page_name = $page->name;
			} else if ($post->type == 'tiktok') {
				$page_name = $page->username;
			}
			// event title as
			$title = calendar_event_title($page_name, $post_data, $user, $post_type, $type);
			// event start date/time
			if ($type == 'DAY') {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$event['setAllDay'] = true;
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
			} elseif ($type == 'WEEK') {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$event['setAllDay'] = true;
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
			} else {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
			}
			// event array
			$event = [
				'id' => 'pending_' . $post->id,
				'title' => $title,
				'start' => $start,
				'className' => 'pending'
			];
			array_push($events, $event);
		}
		// get facebook rss posts
		$cache_key = 'fb_rss_scheduled_calendar_events_' . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
		$fb_rss_scheduled_posts = get_cache_data($cache_key, $user_id, array('start_date' => $start_date, 'end_date' => $end_date));
		foreach ($fb_rss_scheduled_posts['data'] as $post) {
			$page_id = $post->page_id;
			$page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'id' => $page_id));
			if (count($page) > 0) {
				$page = $page[0];
			} else {
				$this->Publisher_model->delete_record('rsssceduler', $post->id);
			}
			// post data array
			$post_data = [
				'published_at' => $post->post_datetime,
				'post_title' => $post->post_title,
				'post_image' => strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false ? $post->link : BulkAssets . $post->link,
				'post_reach' => 0,
				'post_engagements' => 0,
				'post_likes' => 0,
			];
			// event title as
			$title = calendar_event_title($page->page_name, $post_data, $user, 'facebook', $type);
			// event start date/time
			if ($type == 'DAY') {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} elseif ($type == 'WEEK') {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} else {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
			}
			// event array
			$event = [
				'id' => 'pending_' . $post->id,
				'title' => $title,
				'start' => $start,
				'className' => $post->posted == -1 ? 'error' : 'pending'
			];
			array_push($events, $event);
		}
		// get pinterest rss posts
		$cache_key = 'pinterest_rss_scheduled_calendar_events_' . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
		$pin_rss_scheduled_posts = get_cache_data($cache_key, $user_id, array('start_date' => $start_date, 'end_date' => $end_date));
		foreach ($pin_rss_scheduled_posts['data'] as $post) {
			$page_id = $post->board_id;
			$boards = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $user_id, 'id' => $page_id));
			if (count($boards) > 0) {
				$boards = $boards[0];
			} else {
				$this->Publisher_model->delete_record('pinterest_scheduler', $post->id);
			}
			// post data array
			$post_data = [
				'published_at' => $post->publish_datetime,
				'post_title' => $post->post_title,
				'post_image' => strpos($post->image_link, 'http://') !== false || strpos($post->image_link, 'https://') !== false ? $post->image_link : BulkAssets . $post->image_link,
				'post_reach' => 0,
				'post_engagements' => 0,
				'post_likes' => 0,
			];
			// event title as
			$title = calendar_event_title($boards->name, $post_data, $user, 'pinterest', $type);
			// event start date/time
			if ($type == 'DAY') {
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
				$start = utcToLocal($post->publish_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} elseif ($type == 'WEEK') {
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
				$start = utcToLocal($post->publish_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} else {
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
				$start = utcToLocal($post->publish_datetime, $user->gmt, 'Y-m-d');
			}
			// event array
			$event = [
				'id' => 'pending_' . $post->id,
				'title' => $title,
				'start' => $start,
				'className' => $post->published == -1 ? 'error' : 'pending'
			];
			array_push($events, $event);
		}
		// get instagram rss posts
		$cache_key = 'instagram_rss_scheduled_calendar_events_' . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
		$ig_rss_scheduled_posts = get_cache_data($cache_key, $user_id, array('start_date' => $start_date, 'end_date' => $end_date));
		foreach ($ig_rss_scheduled_posts['data'] as $post) {
			$page_id = $post->ig_id;
			$ig_user = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $user_id, 'id' => $page_id));
			if (count($ig_user) > 0) {
				$ig_user = $ig_user[0];
			} else {
				if (isset($post->page_id)) {
					$this->Publisher_model->delete_record('instagram_scheduler', $post->id);
				}
			}
			// post data array
			$post_data = [
				'published_at' => $post->publish_datetime,
				'post_title' => $post->post_title,
				'post_image' => strpos($post->image_link, 'http://') !== false || strpos($post->image_link, 'https://') !== false ? $post->image_link : BulkAssets . $post->image_link,
				'post_reach' => 0,
				'post_engagements' => 0,
				'post_likes' => 0,
			];
			// event title as
			$title = calendar_event_title($ig_user->instagram_username, $post_data, $user, 'instagram', $type);
			// event start date/time
			if ($type == 'DAY') {
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
				$start = utcToLocal($post->publish_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} elseif ($type == 'WEEK') {
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
				$start = utcToLocal($post->publish_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} else {
				$start = utcToLocal($post->publish_datetime, $user->gmt, 'Y-m-d');
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
			}
			// event array
			$event = [
				'id' => 'pending_' . $post->id,
				'title' => $title,
				'start' => $start,
				'className' => $post->published == -1 ? 'error' : 'pending'
			];
			array_push($events, $event);
		}
		// get tiktok rss posts
		$cache_key = 'tiktok_rss_scheduled_calendar_events_' . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
		$tiktok_rss_scheduled_posts = get_cache_data($cache_key, $user_id, array('start_date' => $start_date, 'end_date' => $end_date));
		foreach ($tiktok_rss_scheduled_posts['data'] as $post) {
			$page_id = $post->tiktok_id;
			$tiktoks = $this->Publisher_model->get_allrecords('tiktok', array('user_id' => $user_id, 'id' => $page_id));
			if (count($tiktoks) > 0) {
				$tiktoks = $tiktoks[0];
			} else {
				if (isset($post->page_id)) {
					$this->Publisher_model->delete_record('tiktok_scheduler', $post->id);
				}
			}
			// post data array
			$post_data = [
				'published_at' => $post->post_datetime,
				'post_title' => $post->post_title,
				'post_image' => strpos($post->url, 'http://') !== false || strpos($post->url, 'https://') !== false ? $post->url : BulkAssets . $post->url,
				'post_reach' => 0,
				'post_engagements' => 0,
				'post_likes' => 0,
			];
			// event title as
			$title = calendar_event_title($tiktoks->username, $post_data, $user, 'tiktok', $type);
			// event start date/time
			if ($type == 'DAY') {
				// $start = date('Y-m-d', strtotime($post->publish_datetime));
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} elseif ($type == 'WEEK') {
				// $start = date('Y-m-d', strtotime($post->post_datetime));
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
				$event['setAllDay'] = true;
			} else {
				$start = utcToLocal($post->post_datetime, $user->gmt, 'Y-m-d');
				// $start = date('Y-m-d', strtotime($post->post_datetime));
			}
			// event array
			$event = [
				'id' => 'pending_' . $post->id,
				'title' => $title,
				'start' => $start,
				'className' => $post->published == -1 ? 'error' : 'pending'
			];
			array_push($events, $event);
		}
		return $this->response(['status' => true, 'data' => $events], REST_Controller::HTTP_OK);
	}

	public function clear_calendar_cache_GET()
	{
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$type = $this->get('type');
		$date = $this->get('date');
		$user = get_auth_user();
		$user_id = $user->id;
		if ($type == 'DAY') {
			$start_date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
			$end_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
		} elseif ($type == 'WEEK') {
			$date = format_calendar_date($date);
			$start_date = date('Y-m-d', strtotime($date['start_date']));
			$end_date = date('Y-m-d', strtotime('+1 day', strtotime($date['end_date'])));
		} else {
			$date = format_calendar_date($date);
			$start_date = date('Y-m-d', strtotime($date['start_date']));
			$end_date = date('Y-m-d', strtotime('+1 day', strtotime($date['end_date'])));
		}
		$calendar_cache_keys = [
			'fb_pub_calendar_events_',
			'social_scheduled_calendar_events_',
			'fb_rss_scheduled_calendar_events_',
			'pinterest_rss_scheduled_calendar_events_',
			'instagram_rss_scheduled_calendar_events_',
			'tiktok_rss_scheduled_calendar_events_',
		];
		foreach ($calendar_cache_keys as $key) {
			$cache_key = $key . $user_id . '_' . $start_date . '_' . $end_date . '_' . $type;
			$this->cache->delete($cache_key);
		}
		return $this->response(['status' => true], REST_Controller::HTTP_OK);
	}

	public function get_event_info_POST()
	{
		$id = $this->post('id');
		$exploded_id = explode('-', $id);
		$table = $exploded_id[0];
		$post_id = $exploded_id[1];
		$post = $this->Publisher_model->retrieve_record($table, $post_id);
		$user = $this->Publisher_model->retrieve_record('user', $post->user_id);
		if ($table == 'facebook_posts') {
			$page = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $post->user_id, 'page_id' => $post->page_id));
			$page_data = [
				'page_thumbnail' => $page[0]->profile_pic,
				'page_name' => $page[0]->page_name
			];
			$followers_reach = $post->follower_reach;
			$non_follower_reach = $post->reach - $post->follower_reach;
		}
		$response = [
			'data' => event_info_body($post, $page_data, $user),
			'followers' => $followers_reach,
			'non_followers' => $non_follower_reach,
		];
		return $this->response($response, REST_Controller::HTTP_OK);
	}
	// TikTok APIS
	public function tiktok_redirect_GET()
	{
		$code = $this->get('code');
		if (!empty($code)) {
			$this->load->library('tiktok');
			$user = get_auth_user();
			$access_token = $this->tiktok->get_access_token($code);
			if ($access_token['access_token']) {
				$user_id = App::Session()->get('userid');
				$tiktok_account = $this->Publisher_model->get_allrecords('tiktok', array('user_id' => $user_id, 'open_id' => $access_token['open_id']));
				// get account user info
				$user_info = $this->tiktok->get_user_info($access_token['access_token']);
				$date = strtotime(utcToLocal(gmdate('Y-m-d H:i:s'), $user->gmt, 'Y-m-d H:i:s'));
				$expires_in = $date + $access_token['expires_in'];
				$refresh_expires_in = $date + $access_token['refresh_expires_in'];
				if (count($tiktok_account) > 0) {
					$id = $tiktok_account[0]->id;
					$user_info = $user_info['user'];
					$data = array(
						'username' => $user_info['display_name'],
						'profile_link' => $user_info['profile_deep_link'],
						'bio_description' => $user_info['bio_description'],
						'profile_pic' => !empty($user_info['avatar_url']) ? saveImageFromUrl($user_info['avatar_url'], $user_id, $access_token['open_id']) : '',
						'access_token' => $access_token['access_token'],
						'expires_in' => date('Y-m-d H:i:s', $expires_in),
						'refresh_token' => $access_token['refresh_token'],
						'refresh_expires_in' => date('Y-m-d H:i:s', $refresh_expires_in),
					);
					$this->Publisher_model->update_record('tiktok', $data, $id);
				} else {
					$user_info = $user_info['user'];
					$data = array(
						'user_id' => $user_id,
						'open_id' => $access_token['open_id'],
						'username' => $user_info['display_name'],
						'profile_link' => $user_info['profile_deep_link'],
						'bio_description' => $user_info['bio_description'],
						'profile_pic' => !empty($user_info['avatar_url']) ? saveImageFromUrl($user_info['avatar_url'], $user_id, $access_token['open_id']) : '',
						'access_token' => $access_token['access_token'],
						'expires_in' => date('Y-m-d H:i:s', $expires_in),
						'refresh_token' => $access_token['refresh_token'],
						'refresh_expires_in' => date('Y-m-d H:i:s', $refresh_expires_in),
					);
					$this->Publisher_model->create_record('tiktok', $data);
				}
				redirect(SITEURL . 'schedule');
			} else {
				return $access_token['error_description'];
			}
		}
	}

	public function tiktok_acc_active_POST()
	{
		$userID = App::Session()->get('userid');
		$channel_id = trim($this->post('channel_id'));
		$result = $this->Publisher_model->tiktok_acc_active($userID, $channel_id);
		if ($result) {
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

	public function tiktok_channel_slots_POST()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$tiktok_id = $this->post('tiktok_id');
		$count_slots = isset($_POST['timeslots']) ? $this->post('timeslots') : [];
		if (count($count_slots) > 0) {
			$timeslots = !empty($this->post('timeslots')) ? implode(",", $this->post('timeslots')) : '';
			$this->Publisher_model->update_tiktok_timeslots($userID, $tiktok_id, $timeslots);
			$this->response(['status' => true, 'message' => 'Your settings have been saved. Successfully'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function get_running_rss_status_POST()
	{
		$page_id = $this->post('page_id');
		$type = $this->post('type');
		$response = get_running_rss_fetch($page_id, $type);
		$this->response(['status' => $response['status'], 'message' => $response['message']], REST_Controller::HTTP_OK);
	}

	public function get_tiktok_rssscheduled_POST()
	{
		$this->sessioncheck();
		$id = trim($this->post('id'));
		$activedivid = $this->post('activedivid');
		$user_id = App::Session()->get('userid');
		$user = $this->Publisher_model->retrieve_record('user', $user_id);
		$where = [['key' => 'tiktok_id', 'value' => $id], ['key' => 'published', 'value' => array(0, -1)]];
		$result = $this->Publisher_model->list_records('tiktok_scheduler', 0, 20, $where, 'post_datetime', 'ASC');

		$where = [['key' => 'user_id', 'value' => $user_id], ['key' => 'tiktok_id', 'value' => $id], ['key' => 'published', 'value' => array(0, -1)],];
		$total_posts = $this->Publisher_model->list_records('tiktok_scheduler', 0, 10000, $where, 'post_datetime', 'ASC');

		$scheduled_until = $this->Publisher_model->list_records('tiktok_scheduler', 0, 1, $where, 'post_datetime', 'DESC');
		$scheduled_until = count($scheduled_until) > 0 ? utcToLocal($scheduled_until[0]->post_datetime, $user->gmt, "F j, Y, g:i a") : '';
		$page = $this->Publisher_model->retrieve_record('tiktok', $id);
		$decoded_rss_link = json_decode($page->rss_links, true);
		$decoded_rss_link = !is_array($decoded_rss_link) ? explode(',', $decoded_rss_link) : $decoded_rss_link;
		// now in this if we are checking if $page-rss_link is also empty 
		if (empty($decoded_rss_link)) {
			$return_link_and_last_run[] = [
				'link' => '',
				'last_run' => ''
			];
		} else {
			$return_link_and_last_run[] = [
				'link' => '',
				'last_run' => ''
			];
			foreach ($decoded_rss_link as $links) {
				if (empty($links)) {
					continue;
				}
				$parsed_url = parse_url($links);
				// Extract the protocol, domain, and append "sitemap.xml" to it
				if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
					$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				}

				$this->db->select('*')->from('rsssceduler')->where('page_id', $id)->where('user_id', $user_id);
				$this->db->like('url', $main_domain);
				$this->db->order_by('id', 'DESC')->limit(1);
				$query = $this->db->get()->result_array();
				if (count($query) > 0) {
					$last_run = $query[0]['created_at'];
					$last_run = utcToLocal($last_run, $user->gmt, "Y-m-d  H:i:s");
				} else {
					$last_run = '';
				}
				if (!empty($page->last_run)) {
					$last_run = $page->last_run;
				}
				$return_link_and_last_run[] = [
					'link' => $links,
					'last_run' => $last_run
				];
			}
		}
		// For Shopify Last Run //
		$last_shopify_run = '';
		if ($result) {
			$new_result = [];
			$user = $this->Publisher_model->retrieve_record('user', $user_id);
			foreach ($result as $key => $row) {
				$new_result[$key]['id'] = $row->id;
				$new_result[$key]['title'] = $row->post_title;
				$new_result[$key]['link'] = $row->url;
				$new_result[$key]['url'] = $row->link;
				$new_result[$key]['posted'] = $row->published;
				$new_result[$key]['error'] = $row->response;
				$new_result[$key]['post_date'] = utcToLocal($row->post_datetime, $user->gmt, "F j, Y, g:i a");
				$new_result[$key]['post_time'] = utcToLocal($row->post_datetime, $user->gmt, "H:i A");
			}
			$this->response(['status' => true, 'data' => $new_result, 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active ? $page->rss_active : 0, 'shopify_active' => 0, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run, 'count' => count($total_posts), 'scheduled_until' => $scheduled_until], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

		} else {
			//Set the response and exit
			$this->response(['status' => true, 'message' => 'Please try again', 'time_slots' => $page->time_slots_rss, 'rss_active' => $page->rss_active, 'shopify_active' => 0, 'rss_link' => $return_link_and_last_run, 'last_shopify_run' => $last_shopify_run], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code

		}
	}

	public function updatetiktokrssslots_POST()
	{
		$this->sessioncheck();
		$pageid = trim($this->post('page'));
		$page_data['time_slots_rss'] = json_encode($this->post('time_slots'));
		$result = $this->Publisher_model->update_record('tiktok', $page_data, $pageid);
		$count_slots = count($this->post('time_slots'));
		if ($count_slots > 0) {
			$timeslots = implode(",", $this->post('time_slots'));
			$this->db->select('*')->from('tiktok_scheduler')->where('tiktok_id', $pageid)->where('published', 0);
			$schedule_posts = $this->db->get()->result();
			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');
			foreach ($schedule_posts as $posts) {
				$user_id = $posts->user_id;
				$post_date_time = getNextPostTime("tiktok_scheduler", $user_id, $pageid, $timeslots, $for_update);
				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_date_time;
				$this->Publisher_model->update_record('tiktok_scheduler', $post_date_time, $posts->id);
			}
		}

		if ($result) {
			$this->response(['status' => true, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			//Set the response and exit
			$this->response(['status' => false, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}

	public function tiktok_rss_feed_onoff_POST()
	{
		$this->sessioncheck();
		$page = $this->post('page');
		$page_data['rss_active'] = $this->post('rss_active');
		$result = $this->Publisher_model->update_record('tiktok', $page_data, $page);
		if ($result) {
			$this->response(['status' => true, 'message' => 'Your changes have been saved successfully.'], REST_Controller::HTTP_OK);
		} else {
			$this->response(['status' => false, 'message' => 'Something went wrong!!! Please try again'], REST_Controller::HTTP_OK);
		}
	}

	public function tiktok_rss_feed_POST()
	{
		$this->sessioncheck();
		$userID = $this->post('publisher');
		$page = $this->post('page');
		$timeslots = implode(",", $this->post('timeslots'));
		$rss_link = $this->post('rss_link');
		$if_rss_delete = $this->post('if_rss_delete');
		$if_rss_fetch = $this->post('if_rss_fetch');
		$tiktok = $this->Publisher_model->retrieve_record('tiktok', $page);
		if (!empty($if_rss_delete) && $if_rss_delete == 'yes') {
			if (!empty($rss_link)) {
				$decoded_rss_link = json_decode($tiktok->rss_links, true);
				$decoded_rss_link = !is_array($decoded_rss_link) ? explode(',', $decoded_rss_link) : $decoded_rss_link;
				if (count($decoded_rss_link) <= 0) {
					$this->response(['status' => false, 'message' => 'The selected rss is removed from input (not found in database)'], REST_Controller::HTTP_BAD_REQUEST);
				}
				$index = array_search($rss_link, $decoded_rss_link);
				if ($index !== false) {
					unset($decoded_rss_link[$index]);
					$decoded_rss_link = array_values($decoded_rss_link); // Reset keys
				}
				// Check if the array is empty
				if (count($decoded_rss_link) <= 0) {
					$encode_updated_link = ''; // Set it to an empty string
				} else {
					if (count($decoded_rss_link) == 1 && empty($decoded_rss_link[0])) {
						$encode_updated_link = '';
					} else {
						$encode_updated_link = json_encode($decoded_rss_link);
					}
				}
				$this->Publisher_model->update_record('tiktok', array('rss_links' => $encode_updated_link), $page);
				$this->response(['status' => true, 'message' => 'The selected rss has been deleted successfully'], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => false, 'message' => 'There is nothing to delete'], REST_Controller::HTTP_BAD_REQUEST);
			}
		} else if (!empty($if_rss_fetch) && $if_rss_fetch == 'yes') {
			$sitemap_rss_link = $this->post('sitemap_rss_link');
			$decoded_rss_link = json_decode($tiktok->rss_links, true);
			$decoded_rss_link = !is_array($decoded_rss_link) ? explode(',', $decoded_rss_link) : $decoded_rss_link;
			if (array_search($sitemap_rss_link, $decoded_rss_link) !== false) {
				limit_check(RSS_FEED_OLD_POST_FETCH_ID);
				$response = tiktok_fetch_past_posts($sitemap_rss_link, $page, $userID, $timeslots, 1);
				$cron_url = 'https://www.adublisher.com/fetchPastRssFeed';
			} else {
				// latest posts
				limit_check(RSS_FEED_LATEST_POST_FETCH_ID);
				$response = tiktok_fetch_more_posts($sitemap_rss_link, $page, $userID, $timeslots, 1);
				$cron_url = 'https://www.adublisher.com/fetchRssFeed';
			}
			if ($response['status']) {
				if (count($decoded_rss_link) <= 0) {
					$encode_rss_links = json_encode($sitemap_rss_link);
				} else {
					if (($key = array_search($sitemap_rss_link, $decoded_rss_link)) !== false) {
						$encode_rss_links = [];
					} else {
						$encode_rss_links[] = $sitemap_rss_link;
					}
					$all_links = array_merge($decoded_rss_link, $encode_rss_links);
					$all_links = array_values($all_links);
					$encode_rss_links = json_encode($all_links);
				}
				$this->Publisher_model->update_record('tiktok', array('rss_links' => $encode_rss_links), $page);
				// run cronjob for fetching rss feed
				run_php_background($cron_url);
				$this->response(['status' => true, 'message' => $response['message']], REST_Controller::HTTP_OK);
			} else {
				$this->response(['status' => false, 'message' => $response['error']], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}
}
