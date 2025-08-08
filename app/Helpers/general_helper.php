<?php //if (!defined('BASEPATH'))
//	exit('No direct script access allowed');

if (!function_exists('updateCronJobError')) {
	function updateCronJobError($user_id, $error_column_name, $channel_name, $function_name, $error_msg)
	{
		$CI = &get_instance();
		$CI->load->database();
		// $json_error_msg_to_be_stored_in_db = json_encode($error_msg);
		$CI->db->where('id', $user_id);
		$CI->db->set($error_column_name, $error_msg);
		$CI->db->update('user');
		// die();
		// $CI->db->set('user_id', $user_id);
		// $CI->db->set('channel_name', $channel_name);
		// $CI->db->set('function_name', $function_name);
		// $CI->db->set('error_channel	', $error_column_name);
		// $CI->db->set('error	', $error_msg);
		// $CI->db->insert('errors');

		return $error_msg;
	}
}

if (!function_exists('removeCronJobError')) {
	function removeCronJobError($user_id, $error_column_name)
	{
		$CI = &get_instance();
		$CI->load->database();
		$CI->db->where('id', $user_id);
		$CI->db->set($error_column_name, null); // Set the 'error_column' to an empty string
		$CI->db->update('user'); // Update the 'user' table
		// die();
		// $CI->db->where('user_id', $user_id);
		// $CI->db->where('error_channel', $error_column_name);
		// $CI->db->set('status', 1);
		// $CI->db->update('errors');

		return TRUE;
	}
}

if (!function_exists('utcToLocal')) {
	function utcToLocal($time, $zone, $format = "Y-m-d h:i:s")
	{
		$dt = new DateTime($time, new DateTimeZone('UTC'));
		$dt->setTimezone(new DateTimeZone($zone));
		return $dt->format($format);
	}
}
if (!function_exists('search')) {
	function search($array, $key, $value)
	{
		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$results[] = $array;
			}

			foreach ($array as $subarray) {
				$results = array_merge($results, search($subarray, $key, $value));
			}
		}

		return $results;
	}
}

function format_page_insights($api_array, $divisor)
{
	$response = array(
		'followers' => ['html' => '', 'value' => 0],
		'post_reach' => ['html' => '', 'value' => 0],
		'engagements' => ['html' => '', 'value' => 0],
		'video_views' => ['html' => '', 'value' => 0]
	);
	foreach ($api_array['data'] as $key => $value) {
		// followers
		if ($value['name'] == 'page_daily_follows') {
			foreach ($value['values'] as $follower_key => $follower_values) {
				$response['followers']['html'] .= bar_chart($follower_values['value'], 'followers_chart', date('l, d M', strtotime($follower_values['end_time'])), 'Followers');
				$response['followers']['value'] += $follower_values['value'];
			}
		}
		// post reach
		if ($value['name'] == 'page_impressions_unique') {
			foreach ($value['values'] as $post_reach_key => $post_reach_values) {
				$response['post_reach']['html'] .= bar_chart($post_reach_values['value'], 'post_reach_chart', date('l, d M', strtotime($post_reach_values['end_time'])), 'Post Reach');
				$response['post_reach']['value'] += $post_reach_values['value'];
			}
		}
		// post engagements
		if ($value['name'] == 'page_post_engagements') {
			foreach ($value['values'] as $post_engagements_key => $post_engagements_values) {
				$response['engagements']['html'] .= bar_chart($post_engagements_values['value'], 'engagements_chart', date('l, d M', strtotime($post_engagements_values['end_time'])), 'Engagements');
				$response['engagements']['value'] += $post_engagements_values['value'];
			}
		}
		// videoviews
		if ($value['name'] == 'page_video_views') {
			foreach ($value['values'] as $video_views_key => $video_views_values) {
				$response['video_views']['html'] .= bar_chart($video_views_values['value'], 'video_views_chart', date('l, d M', strtotime($video_views_values['end_time'])), 'Video Views');
				$response['video_views']['value'] += $video_views_values['value'];
			}
		}
	}
	return $response;
}

function format_all_page_insights($api_array)
{
	$response = [];
	foreach ($api_array['data'] as $key => $value) {
		// followers
		if ($value['name'] == 'page_daily_follows') {
			foreach ($value['values'] as $follower_key => $follower_values) {
				$response[date('Y-m-d', strtotime($follower_values['end_time']))]['followers'] = $follower_values['value'];
				// $response['followers']['html'] .= bar_chart($follower_values['value'], 'followers_chart', date('l, d M', strtotime($follower_values['end_time'])), 'Followers');
				// $response['followers']['value'] += $follower_values['value'];
			}
		}
		// post reach
		if ($value['name'] == 'page_impressions_unique') {
			foreach ($value['values'] as $post_reach_key => $post_reach_values) {
				$response[date('Y-m-d', strtotime($post_reach_values['end_time']))]['post_reach'] = $post_reach_values['value'];

				// $response['post_reach']['html'] .= bar_chart($post_reach_values['value'], 'post_reach_chart', date('l, d M', strtotime($post_reach_values['end_time'])), 'Post Reach');
				// $response['post_reach']['value'] += $post_reach_values['value'];
			}
		}
		// post engagements
		if ($value['name'] == 'page_post_engagements') {
			foreach ($value['values'] as $post_engagements_key => $post_engagements_values) {
				$response[date('Y-m-d', strtotime($post_engagements_values['end_time']))]['engagements'] = $post_engagements_values['value'];
				// $response['engagements']['html'] .= bar_chart($post_engagements_values['value'], 'engagements_chart', date('l, d M', strtotime($post_engagements_values['end_time'])), 'Engagements');
				// $response['engagements']['value'] += $post_engagements_values['value'];
			}
		}
		// videoviews
		if ($value['name'] == 'page_video_views') {
			foreach ($value['values'] as $video_views_key => $video_views_values) {
				$response[date('Y-m-d', strtotime($video_views_values['end_time']))]['video_views'] = $video_views_values['value'];
				// $response['video_views']['html'] .= bar_chart($video_views_values['value'], 'video_views_chart', date('l, d M', strtotime($video_views_values['end_time'])), 'Video Views');
				// $response['video_views']['value'] += $video_views_values['value'];
			}
		}
	}
	return $response;
}

function format_page_post_insights($posts_array, $key, $divisor)
{
	$response = array(
		'html' => '',
		'value' => 0
	);
	if ($divisor == '1') {
		$start = 1;
		$end = 7;
	} else {
		$start = 1;
		$end = 7;
	}
	for ($i = $start; $i <= $end; $i++) {
		if (count($posts_array) > 0) {
			foreach ($posts_array as $value) {
				if ($key == 'link_clicks') {
					$value_count = $value->link_clicks;
				} elseif ($key == 'ctr') {
					$value_count = $value->ctr;
				} elseif ($key == 'eng_rate') {
					$value_count = $value->eng_rate;
				} elseif ($key == 'reach_rate') {
					$value_count = $value->reach_rate;
				} elseif ($key == 'talking_about') {
					$value_count = 0;
				}
				$response['html'] .= bar_chart($value_count, $key . '_chart', date('l, d M', strtotime('-' . $i . ' days')), ucwords(str_replace('_', ' ', $key)));
				$response['value'] += $value_count;
			}
		} else {
			$response['html'] .= bar_chart(0, $key . '_chart', date('l, d M', strtotime('-' . $i . ' days')), ucwords(str_replace('_', ' ', $key)));
			$response['value'] = 0;
		}
	}
	return $response;
}

function bar_chart($value, $chart_name, $date, $title_name)
{
	$class = $value > 0 ? 'chart__bar ' . $chart_name . ' active_chart__bar' : 'chart__bar ' . $chart_name;
	$title = $date . ' ,' . $value . ' ' . strtolower($title_name);
	$div = '<div class="mx-1 ' . $class . '" title="' . $title . '" ></div>';
	return $div;
}

if (!function_exists('localToUTC')) {
	function localToUTC($time, $zone, $format = "Y-m-d h:i:s")
	{
		// check if 00:00
		$exploded_time = explode(" ", $time);
		if (count($exploded_time) > 1 && $exploded_time[1] == ":00") {
			$exploded_time[1] = '00:00:00';
			$time = implode(' ', $exploded_time);
		}
		$dt = new DateTime($time, new DateTimeZone($zone));
		$dt->setTimezone(new DateTimeZone('UTC'));
		return $dt->format($format);
	}

	if (!function_exists('array_mesh_country')) {
		function array_mesh_country($result, $result_r)
		{
			$data = array_merge_recursive($result, $result_r);
			$sum = array_reduce($data, function ($a, $b) {
				if (isset($a[$b['country']])) {
					$a[$b['country']]['click'] += $b['click'];
					$a[$b['country']]['earn'] += $b['earn'];
				} else {
					$a[$b['country']] = $b;
				}
				return $a;
			});
			$earn = array();
			if ($sum) {
				foreach ($sum as $key => $row) {
					$earn[$key] = $row['earn'];
				}

				array_multisort($earn, SORT_DESC, $sum);
			}


			return $sum;
		}
	}
	if (!function_exists('array_mesh_campaign')) {
		function array_mesh_campaign($result, $result_r)
		{
			$data = array_merge_recursive($result, $result_r);
			$sum = array_reduce($data, function ($a, $b) {
				if (isset($a[$b['cpid']])) {
					$a[$b['cpid']]['click'] += $b['click'];
					$a[$b['cpid']]['earn'] += $b['earn'];
				} else {
					$a[$b['cpid']] = $b;
				}
				return $a;
			});
			$earn = array();
			if ($sum) {
				foreach ($sum as $key => $row) {
					$earn[$key] = $row['earn'];
				}
				array_multisort($earn, SORT_DESC, $sum);
			}




			return $sum;
		}
	}
	if (!function_exists('cnf')) {
		function cnf($n, $precision = 3)
		{
			if ($n < 900) {
				// Default
				$n_format = number_format($n);
			} else if ($n < 900000) {
				// Thausand
				$n_format = number_format($n / 1000, $precision) . ' K';
			} else if ($n < 900000000) {
				// Million
				$n_format = number_format($n / 1000000, $precision) . ' M';
			} else if ($n < 900000000000) {
				// Billion
				$n_format = number_format($n / 1000000000, $precision) . ' B';
			} else {
				// Trillion
				$n_format = number_format($n / 1000000000000, $precision) . ' T';
			}
			return $n_format;
		}
	}


	if (!function_exists('publisher_annoucements')) {
		function publisher_annoucements()
		{
			$CI = &get_instance();
			$CI->load->model('Publisher_model');
			return $CI->Publisher_model->get_latest_announcements();
		}
	}



	if (!function_exists('publisher_notifications')) {
		function publisher_notifications()
		{
			$CI = &get_instance();
			$CI->load->model('Publisher_model');
			return $CI->Publisher_model->get_latest_notifications();
		}
	}

	if (!function_exists('get_link_settings')) {
		function get_link_settings($user_id)
		{
			$CI = &get_instance();
			$CI->load->model('Admin_model');
			return $CI->Admin_model->get_link_settings($user_id);
		}
	}
	if (!function_exists('resources_update')) {
		function resources_update($type, $fid, $user_id = null)
		{
			$CI = &get_instance();
			$CI->load->model('Publisher_model');
			return $CI->Publisher_model->resources_update($type, $fid, $user_id);
		}
	}

	if (!function_exists('user_pr')) {
		function user_pr($fid = null, $user_id = null)
		{
			$CI = &get_instance();
			$CI->load->model('Publisher_model');
			$results = $CI->Publisher_model->userPackageDetails($user_id);
			if ($results['ptu']->active != '1') {
				$results['pxn'] = pxn($user_id);
			} else {
				$results['pxn'] = '';
			}
			if ($fid) {
				foreach ($results['ptr'] as $ptr) {
					if ($ptr->fid == $fid) {
						$results['ptr'] = $ptr;
						break;
					}
				}
			}
			return $results;
		}
	}
	if (!function_exists('get_time_slot')) {
		function get_time_slot($time_slots)
		{
			if (!is_array($time_slots)) {
				$slots = explode(',', $time_slots);
			}
			$response = '';
			foreach ($slots as $key => $slot) {
				$time = $slot % 12 ? $slot % 12 : 12;
				$zone = $slot >= 12 ? "PM" : "AM";
				$response .= "span class='badge badge-success mx-1'>" . $time . $zone . "</span>";
			}
			return $response;
		}
	}
	//package Expire Notification

	if (!function_exists('pxn')) {
		function pxn($user_id = is_null)
		{
			$CI = &get_instance();
			if (!empty($user_id)) {
				$user = $CI->Publisher_model->retrieve_record('user', $user_id);
				$team_role = $user->team_role;
			} else {
				$team_role = $_SESSION['team_role'];
			}

			if ($team_role == 'owner') {
				return '<div class="row m-0 p-10">
      <div class="col-md-12"><div class="alert alert-warning">
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span> </button>
                    <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning
                    </h3> Your package has been expired, please upgrade your package to get awesome features for you. click <a href="' . SITEURL . 'payments-and-subscriptions"> Here </a> to goto subscription page.
                </div></div></div>';
			} else {
				return '<div class="row m-0 p-10">
        <div class="col-md-12"><div class="alert alert-warning">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span> </button>
                      <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning
                      </h3> Your employee\'r package has been expired, you cannot do anything untill he renew his package.
                  </div></div></div>';
			}
		}
	}
	if (!function_exists('loader')) {
		function loader()
		{
			return '';
		}
	}
	if (!function_exists('limit_check')) {
		function limit_check($fid, $mode = null, $user_id = null)
		{
			$CI = &get_instance();
			$upr = user_pr($fid, $user_id);
			// $account = $upr['ptu']->active;
			$feature_det = $upr['ptr'];
			// doing this for testing phase, will remove this when deploying
			if (empty($user_id)) {
				$user_id = App::Session()->get('userid');
			}
			if ($user_id != '2139') {
				return true;
			}
			if ($mode == 1) { // mode 1 for sidebar
				if ($feature_det->is_unlimited) {
					return true;
				} elseif ($feature_det->quota == 0) {
					return false;
				} else {
					return true;
				}
			} elseif ($mode == 2) { // mode 2 for cronjobs
				if ($feature_det->is_unlimited) {
					return true;
				} elseif ($feature_det->quota == 0) {
					return false;
				} else {
					$limit = $upr['ptr']->quota;
					$left = $limit - $upr['ptr']->used;
					if ($left < 1) {
						return false;
					} else {
						return true;
					}
				}
			}
			if ($feature_det->is_unlimited) {
				return true;
			} else {
				$limit = $upr['ptr']->quota;
				$left = $limit - $upr['ptr']->used;
				if ($left < 1) {
					echo json_encode(['status' => FALSE, 'message' => 'Your resource limit has been reached'], REST_Controller::HTTP_OK);
					exit();
				}
			}
		}
	}



	if (!function_exists('get_cp_link')) {
		function get_cp_link($cp_id, $user, $campaign_link)
		{
			$CI = &get_instance();
			$CI->load->model('Publisher_model');
			$link_setting = $CI->Publisher_model->get_link_settings($user->id);
			if ($user->direct_link == "direct") {
				return $campaign_link . '?&utm_medium=' . $user->username . '&utm_campaign=' . $cp_id . '&utm_source=facebook&utm_term=adublisher';
			} else {
				//Get redirect domain
				$user_domain = $CI->Publisher_model->get_redirect_domain($user);
				if ($user_domain) {
					return $user_domain . '/ref/' . $cp_id . '/' . $user->id;
				} else {
					return $campaign_link . '?&utm_medium=' . $user->username . '&utm_campaign=' . $cp_id . '&utm_source=facebook';
				}
			}
		}
	}

	if (!function_exists('print_pre')) {
		function print_pre($data, $die = NULL)
		{
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			if ($die) {
				die();
			}
		}
	}

//	function dd($data)
//	{
//		if (is_array($data)) {
//			foreach ($data as $value) {
//				print_pre($value);
//				echo '<br>';
//			}
//		} else {
//			print_pre($data);
//			echo '<br>';
//		}
//		die();
//	}

	if (!function_exists('get_create_shortlink')) {
		function get_create_shortlink($link)
		{
			$CI = &get_instance();
			$CI->load->model('Shorty_model');
			$short_link = $CI->Shorty_model->get_or_create($link);
			return ADUBSHORTLINK . $short_link;
		}
	}



	if (!function_exists('notification_icon')) {
		function notification_icon($type)
		{
			$icon = "";
			if ($type == "info") {

				$icon = "<div class='btn btn-info btn-circle'><i class='fa  fa-info'></i></div>";
			} else if ($type == "success") {

				$icon = "<div class='btn btn-success btn-circle'><i class='fa  fa-check'></i></div>";
			} else if ($type == "warning") {

				$icon = "<div class='btn btn-warning btn-circle'><i class='fa fa-warning'></i></div>";
			} else if ($type == "error") {

				$icon = "<div class='btn btn-danger btn-circle'><i class='fa  fa-times'></i></div>";
			}

			return $icon;
		}
	}

	if (!function_exists('article_badge')) {
		function article_badge($type)
		{
			$icon = "";
			if ($type == "pending") {

				$icon = "<span class='badge badge-special badge-info'><i class='fa   fa-clock-o'></i> " . ucfirst($type) . "</span>";
			} else if ($type == "locked") {

				$icon = "<span class='badge badge-special badge-warning'><i class='fa  fa-lock'></i> Approved</span>";
			} else if ($type == "rework") {

				$icon = "<span class='badge badge-special badge-danger'><i class='fa  fa-edit'></i> " . ucfirst($type) . "</span>";
			} else if ($type == "published") {

				$icon = "<span class='badge badge-special badge-success'><i class='fa  fa-check-circle-o'></i> " . ucfirst($type) . "</span>";
			} else {
				$icon = "<span class='badge badge-special badge-info'><i class='fa  fa-edit'></i> " . ucfirst($type) . "</span>";
			}
			return $icon;
		}
	}

	if (!function_exists('article_badge_admin')) {
		function article_badge_admin($type)
		{
			$icon = "";
			if ($type == "pending") {

				$icon = "<span class='badge badge-special badge-info'><i class='fa   fa-clock-o'></i> " . ucfirst($type) . "</span>";
			} else if ($type == "locked") {

				$icon = "<span class='badge badge-special badge-warning'><i class='fa  fa-lock'></i> Approved</span>";
			} else if ($type == "rework") {

				$icon = "<span class='badge badge-special badge-danger'><i class='fa  fa-edit'></i> " . ucfirst($type) . "ing</span>";
			} else if ($type == "published") {

				$icon = "<span class='badge badge-special badge-success'><i class='fa  fa-check-circle-o'></i> " . ucfirst($type) . "</span>";
			} else {
				$icon = "<span class='badge badge-special badge-info'><i class='fa  fa-edit'></i> " . ucfirst($type) . "</span>";
			}
			return $icon;
		}
	}


	if (!function_exists('is_admin_logged_in')) {
		function is_admin_logged_in()
		{
			$CI = &get_instance();
			$is_logged_in = $CI->session->userdata('admin_user_id');
			if (!isset($is_logged_in) || $is_logged_in != true) {
				echo 'You don\'t have permission to access this page.';
				die();
			}
		}
	}
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 10)
	{
		$characters = '0123456789abcdefg56789hijklm0123456789nopqrstu0123456789vwxyzABCDE0123456789FGHIJK0123456789LMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

if (!function_exists('daysBetween')) {
	function daysBetween($dt1, $dt2)
	{
		return date_diff(
			date_create($dt2),
			date_create($dt1)
		)->format('%r%a');
	}
}

if (!function_exists('get_trans_template')) {
	function get_trans_template($trans)
	{
		$date = date("Y-m-d", strtotime($trans->created));

		return '<tr>
  <td>' . $trans->txn_id . '</td>
  <td>' . $trans->membership_id . '</td>
  <td>' . $trans->total . '</td>
  <td>' . $trans->pp . '</td>
  <td>' . $date . '</td>
  </tr>';
	}
}
if (!function_exists('show_decimal')) {
	function show_decimal($number)
	{

		return number_format($number, 2);
	}
}
if (!function_exists('get_google_auth')) {
	function get_google_auth($userid = null)
	{
		$CI = &get_instance();
		$CI->load->database();
		if (empty($userid)) {
			$user_id = App::Session()->get('userid');
		} else {
			$user_id = $userid;
		}
		$where = array(
			'user_id' => $user_id
		);
		$query = $CI->db->get_where('google_users', $where);
		$response = $query->row();
		return $response;
	}
}

if (!function_exists('user_check')) {
	function user_check($user_id = null)
	{
		$CI = &get_instance();
		$CI->load->database();
		$where = array(
			'id' => $user_id
		);
		$query = $CI->db->get_where('user', $where);
		$response = $query->row();
		if ($response) {
			$expiry = $response->mem_expire;
			if (!empty($expiry)) {
				$now = date('Y-m-d H:i:s');
				if (strtotime($now) >= strtotime($expiry)) {
					return array(
						'status' => false,
						'message' => 'Your membership has been expired!'
					);
				} else {
					return array(
						'status' => true
					);
				}
			} else {
				return array(
					'status' => false,
					'message' => 'Your membership has been expired!'
				);
			}
		} else {
			return array(
				'status' => false,
				'message' => 'User not found!'
			);
		}
	}
}

if (!function_exists('getUtm')) {
	function getUtm($domain, $user_id = null)
	{
		$CI = &get_instance();
		$CI->load->model('Publisher_model');
		$where = array(
			'user_id' => empty($user_id) ? App::Session()->get('userid') : $user_id,
			'url' => $domain
		);
		$url = $CI->Publisher_model->get_allrecords('tracking_urls', $where);
		if (count($url) > 0) {
			if ($url[0]->status) {
				$utm_codes = $CI->Publisher_model->get_allrecords('utm_urls', array('url_id' => $url[0]->id));
				if (count($utm_codes) > 0) {
					foreach ($utm_codes as $utm) {
						if ($utm->type == 'campaign') {
							$utms['campaign'] = $utm->value;
						}
						if ($utm->type == 'medium') {
							$utms['medium'] = $utm->value;
						}
						if ($utm->type == 'source') {
							$utms['source'] = $utm->value;
						}
						$utm_array = ['campaign', 'medium', 'source'];
						if (!in_array($utm->type, $utm_array)) {
							$utms[$utm->type] = $utm->value;
						}
					}
				}
			} else {
				$utms = [];
			}
		} else {
			$utms = [];
		}
		return $utms;
	}
}

if (!function_exists('make_utm_url')) {
	function make_utm_url($url, $utm_codes, $profile_name, $type)
	{
		$CI = &get_instance();
		$CI->load->model('Publisher_model');
		$user_id = App::Session()->get('userid');
		$user_info = $CI->Publisher_model->get_allrecords('user', array('id' => $user_id));

		$utm = '';
		if (count($utm_codes) > 0) {
			$utm_array = array(
				'campaign' => 'utm_campaign',
				'medium' => 'utm_medium',
				'source' => 'utm_source',
			);
			foreach ($utm_codes as $utm_name => $utm_value) {
				$utm_name = isset($utm_array[$utm_name]) ? $utm_array[$utm_name] : $utm_name;
				if ($utm_value == 'social_network') {
					$utm .= str_replace(' ', '+', $utm_name) . '=' . str_replace(' ', '+', $type);
				} else if ($utm_value == 'social_profile') {
					$utm .= str_replace(' ', '+', $utm_name) . '=' . str_replace(' ', '+', $profile_name);
				} else {
					$utm .= str_replace(' ', '+', $utm_name) . '=' . str_replace(' ', '+', $utm_value);
				}
				$utm .= '&';
			}
			$utm = trim($utm, '&');
			// make url, utm coded url
			$return_url = $url . '?' . $utm;
		} else {
			$return_url = $url;
		}
		return $return_url;
	}
}

if (!function_exists('check_for')) {
	function check_for($string, $find)
	{
		$words = explode(' ', $string);
		foreach ($words as $word) {
			if ($word === $find) {
				return true;
			}
		}
	}
}
if (!function_exists('getDomain')) {
	function getDomain($url)
	{
		$parsedUrl = parse_url($url);
		return array(
			'url' => isset($parsedUrl['host']) ? $parsedUrl['host'] : '',
			'scheme' => isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : '',
		);
	}
}

if (!function_exists('getCountryCodeByTimezone')) {
	function getCountryCodeByTimezone($timezone)
	{
		try {
			// Create an IntlTimeZone object
			$tz = IntlTimeZone::createTimeZone($timezone);
			$countryCode = $tz->getID();

			return $countryCode ?: 'Unknown';
		} catch (Exception $e) {
			return 'Unknown';
		}
	}
}
if (!function_exists('remove_file')) {
	function remove_file($file_name)
	{
		if (!empty($file_name)) {
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $file_name;
			if (file_exists($delete_path)) {
				unlink($delete_path);
			}
		}
		return true;
	}
}

if (!function_exists('move_to_s3_bucket')) {
	function move_to_s3_bucket($file)
	{
		$CI = &get_instance();
		// Load Library
		if (!empty($_FILES[$file])) {
			// get user id
			$userID = App::Session()->get('userid');
			// make file nmae
			$_FILES[$file]["name"] = str_replace(' ', '_', $_FILES[$file]["name"]);
			$fileName = $userID . "_" . time() . "_" . $_FILES[$file]["name"];
			// configurations
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/";
			$config['allowed_types'] = 'avi|mpeg|qt|mov|quicktime|mkv|flv|mp4|webm|ogg';
			$config['max_size'] = '102400';
			$config['overwrite'] = false;
			$config['file_name'] = $fileName;
			// upload file to server
			$CI->load->library('upload', $config);
			// on upload error
			if (!$CI->upload->do_upload('file')) {
				return array(
					'status' => false,
					'error' => $CI->upload->display_errors()
				);
			} else {
				// file path for s3 bucket
				$file_path = 'assets/bulkuploads/' . $fileName;
				$basename = pathinfo($fileName, PATHINFO_BASENAME);
				$key = 'assets/bulkuploads/' . $basename;
				// load s3 library
				$CI->load->library('s3_upload');
				// move to aws s3 bucket
				$aws = $CI->s3_upload->move_to_aws($key, $file_path);
				if ($aws) {
					unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $file_path);
					return array(
						'status' => true,
						'file_name' => $key
					);
				} else {
					return array(
						'status' => false,
						'error' => "Try Again!"
					);
				}
			}
		}
	}
}

if (!function_exists('get_from_s3bucket')) {
	function get_from_s3bucket($key, $mode = 0)
	{
		$CI = &get_instance();
		if (!empty($key)) {
			$CI->load->library('s3_upload');
			// move to aws s3 bucket
			$file_name = str_replace('assets/bulkuploads/', '', $key);
			$aws = $CI->s3_upload->get_from_aws($key);
			if ($aws) {
				if ($mode == 1) { //for url
					$file_name = $aws['@metadata']['effectiveUri'];
				} else { //for file
					$destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $file_name;
					$fileHandle = fopen($destinationPath, 'wb');
					// Write the video content to local storage using fput
					fwrite($fileHandle, $aws['Body']);
					// Close the file stream
					fclose($fileHandle);
				}
				return array(
					'status' => true,
					'file_name' => $file_name
				);
			} else {
				return array(
					'status' => false,
					'error' => 'Try Again!'
				);
			}
		}
	}
}

if (!function_exists('remove_from_s3bucket')) {
	function remove_from_s3bucket($key)
	{
		$CI = &get_instance();
		if (!empty($key)) {
			$CI->load->library('s3_upload');
			$response = $CI->s3_upload->remove_from_aws($key);
			return array(
				'status' => true,
				'message' => 'Video removed from S3 Bucket'
			);
		}
	}
}

if (!function_exists('get_youtube_settings')) {
	function get_youtube_settings()
	{
		$CI = &get_instance();
		$CI->load->database();
		$userid = App::Session()->get('userid');
		$query = $CI->db->get_where('youtube_settings', array('user_id' => $userid));
		$response = $query->row();
		return $response;
	}
}
if (!function_exists('page_insight_api')) {
	function page_insight_api($page_id, $access_token)
	{
		$data = [];
		$data['insights'] = array(
			'followers' => 0,
			'impressions' => 0,
			'engagements' => 0,
			'likes' => 0,
			'love' => 0,
			'haha' => 0,
			'wow' => 0,
			'cry' => 0,
			'anger' => 0,
			// 'reactions' => 0,
			'shares' => 0,
			'link_clicks' => 0,
			'photo_views' => 0,
			'video_views' => 0,
		);
		$CI = &get_instance();
		$CI->load->library('facebook');
		// time period day
		$metric = 'page_fans';
		$period = 'day';
		$page_insight = $CI->facebook->request('get', '/' . $page_id . '/insights?access_token=' . $access_token . '&metric=' . $metric . '&period=' . $period);
		if (isset($page_insight['data']) && count($page_insight) > 0) {
			foreach ($page_insight['data'] as $p_ins) {
				if ($p_ins['name'] == 'page_fans') {
					foreach ($p_ins['values'] as $page_followers) {
						$data['insights']['followers'] = $page_followers['value'];
					}
				}
			}
		}
		$metric_array = [
			'page_post_engagements', //number of times people have engaged with posts
			'page_impressions_unique', //nunumber of peopl ewho had any content from your Page or about your Page enter their screen
			'page_actions_post_reactions_like_total', //daily total post "like" reactions of a page.
			'page_actions_post_reactions_love_total', //daily total post "love" reactions of a page.
			'page_actions_post_reactions_wow_total', //daily total post "wow" reactions of a page.
			'page_actions_post_reactions_haha_total', //daily total post "haha" reactions of a page.
			'page_actions_post_reactions_sorry_total', //daily total post "sorry" reactions of a page.
			'page_actions_post_reactions_anger_total', //daily total post "anger" reactions of a page.
			'page_video_views', // number of times your Page's videos played for at least 3 seconds or more.
		];
		$metric = implode(',', $metric_array);
		$period = 'days_28';
		$page_insight = $CI->facebook->request('get', '/' . $page_id . '/insights?access_token=' . $access_token . '&metric=' . $metric . '&period=' . $period);
		if (isset($page_insight['data']) && count($page_insight) > 0) {
			foreach ($page_insight['data'] as $p_ins) {
				// number of times people have engaged with page posts
				if ($p_ins['name'] == 'page_post_engagements') {
					foreach ($p_ins['values'] as $page_engagements) {
						$data['insights']['engagements'] = $page_engagements['value'];
					}
				}
				// number of times any content enters a user's screen
				if ($p_ins['name'] == 'page_impressions_unique') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['impressions'] = $page_impressions['value'];
					}
				}
				// total like reactions
				if ($p_ins['name'] == 'page_actions_post_reactions_like_total') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['likes'] = $page_impressions['value'];
					}
				}
				// total love reactions
				if ($p_ins['name'] == 'page_actions_post_reactions_love_total') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['love'] = $page_impressions['value'];
					}
				}
				// total wow reactions
				if ($p_ins['name'] == 'page_actions_post_reactions_wow_total') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['wow'] = $page_impressions['value'];
					}
				}
				// total haha reactions
				if ($p_ins['name'] == 'page_actions_post_reactions_haha_total') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['haha'] = $page_impressions['value'];
					}
				}
				// total sorry reactions
				if ($p_ins['name'] == 'page_actions_post_reactions_sorry_total') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['cry'] = $page_impressions['value'];
					}
				}
				// total anger reactions
				if ($p_ins['name'] == 'page_actions_post_reactions_anger_total') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['anger'] = $page_impressions['value'];
					}
				}
				// page video views
				if ($p_ins['name'] == 'page_video_views') {
					foreach ($p_ins['values'] as $page_impressions) {
						$data['insights']['video_views'] = $page_impressions['value'];
					}
				}
			}
		}
		return $data;
	}
}

function update_page_insights($where, $page_insight)
{
	$CI = &get_instance();
	$page_insight_db = $CI->Publisher_model->get_allrecords_array('page_insights', $where);
	if (count($page_insight_db) > 0) {
		$insight = $page_insight['insights'];
		$data = array(
			'followers' => $insight['followers'],
			'impressions' => $insight['impressions'],
			'engagements' => $insight['engagements'],
			'likes' => $insight['likes'],
			'love' => $insight['love'],
			'haha' => $insight['haha'],
			'wow' => $insight['wow'],
			'cry' => $insight['cry'],
			'anger' => $insight['anger'],
			'shares' => $insight['shares'],
			'link_clicks' => $insight['link_clicks'],
			'photo_views' => $insight['photo_views'],
			'video_views' => $insight['video_views'],
		);
		$CI->db->where('id', $page_insight_db[0]['id']);
		$CI->db->update('page_insights', $data);
	}
	return true;
}

function create_or_update_page_insights($page_id, $user_id, $page_insight)
{
	$CI = &get_instance();
	$CI->load->database();
	$page_insight_db = $CI->Publisher_model->get_allrecords('page_insights', array('user_id' => $user_id, 'page_id' => $page_id));
	if (count($page_insight_db) > 0) {
		$row = $page_insight_db[0];
		$data = $page_insight['insights'];
		$CI->db->where('id', $row->id);
		$CI->db->update('page_insights', $data);
	} else {
		$data = $page_insight['insights'];
		$data['page_id'] = $page_id;
		$data['user_id'] = $user_id;
		$CI->db->insert('page_insights', $data);
	}
	return true;
}

if (!function_exists('recent_posts_api')) {
	function recent_posts_api($page_id, $user_id, $access_token, $limit = 10, $after = null)
	{
		$CI = &get_instance();
		$CI->load->library('facebook');
		// get page detail
		// $post_image = $CI->facebook->request('get', '/' . $page_id . '/picture?redirect=0', $access_token);
		// $post_profile_pic = '';
		// if (isset($post_image['data'])) {
		// 	$post_profile_pic = saveImageFromUrl($post_image['data']['url'], $user_id, $page_id);
		// }
		// get previous posts
		$limit = '100';
		$fields_array = ['full_picture', 'created_time', 'message', 'status_type'];
		$fields = implode(',', $fields_array);
		$posts = $CI->facebook->request('get', '/' . $page_id . '/feed?fields=' . $fields . '&limit=' . (int) $limit . '&after=' . $after, $access_token);
		if (isset($posts['data'])) {
			// store posts upto 3 months
			$published = isset($posts['data']) ? date('Y-m-d H:i:s', strtotime(end($posts['data'])['created_time'])) : '0';
			$previous_date = date('Y-m-d 00:00:00', strtotime('-91 days'));
			if ((strtotime($previous_date) >= strtotime($published))) {
				$posts['paging']['cursors']['after'] = '';
			}
			return $posts;
		} else {
			return [];
		}
	}
}

function fb_page_fetch_more_posts($url, $page, $userID, $timeslots, $mode)
{
	$CI = &get_instance();
	$CI->load->database();
	$page_detail = $CI->Publisher_model->retrieve_record('facebook_pages', $page);
	$links = $CI->Publisher_model->appendFeedToUrl($url);
	$userAgent = user_agent();
	$contextOptions = ['http' => ['user_agent' => $userAgent, 'ignore_errors' => true]];
	$context = stream_context_create($contextOptions);
	$file = file_get_contents($links, FALSE, $context);
	$single_feed = simplexml_load_string((string) $file);

	if (empty($single_feed)) {
		$false_link = $links;
	} else {
		$feed[] = $single_feed;
	}
	if ($feed) {
		foreach ($feed as $data) {
			if (!empty($data)) {
				$i = 1;
				if (isset($data->channel->item)) {
					$items_count = count($data->channel->item);
					$few_issues = [];
					foreach ($data->channel->item as $item) {
						$items_count--;
						$item = $data->channel->item[$items_count];
						if ($i > 10) {
							break;
						}
						// utm checks on url
						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($item->link);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $userID);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						$utmPostUrl = $item->link;
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $page_detail->page_name, 'facebook');
						}
						// utm checks end
						$where_rss = [];
						$where_rss[0]['key'] = 'url';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'page_id';
						$where_rss[1]['value'] = $page;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $userID;
						$present = $CI->Publisher_model->count_records('rsssceduler', $where_rss);
						if (!$present) {
							$i++;
							$img_path = base_url('assets/images/download.png');
							if (limit_check(RSS_FEED_LATEST_POST_FETCH_ID, 2, $userID)) {
								resources_update('up', RSS_FEED_LATEST_POST_FETCH_ID, $userID);
								create_single_rss_feed($userID, $page, $item->title, $img_path, $utmPostUrl, $timeslots, 'latest');
								create_rss_image($userID, $page, $utmPostUrl, "facebook");
							} else {
								$response = [
									'status' => false,
									'error' => 'Your resource limit has been reached'
								];
							}
						}
					}
				} else {
					$response = array(
						'status' => false,
						'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
					);
				}
			} else {
				$response = array(
					'status' => false,
					'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
				);
			}
		}
		$removeError = removeCronJobError($userID, 'facebook_page_error');
		$response = array(
			'status' => true,
			'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
		);
		// Set the flag to true after the foreach loop
		$cron_url = 'https://www.adublisher.com/fetchRssLinkImages';
		run_php_background($cron_url);
	} else {
		$response = array(
			'status' => false,
			'error' => 'Your provided link has not valid RSS feed, Please fix and try again.'
		);
	}
	return $response;
}

function pin_board_fetch_more_posts($url, $page, $userID, $timeslots, $mode)
{
	$CI = &get_instance();
	$links = $CI->Publisher_model->appendFeedToUrl($url);
	$userAgent = user_agent();
	$contextOptions = ['http' => ['user_agent' => $userAgent, 'ignore_errors' => true]];
	$context = stream_context_create($contextOptions);
	$file = @file_get_contents($links, FALSE, $context);
	if ($file === false || empty($file)) {
		return [
			"status" => false
		];
	}
	$single_feed = @simplexml_load_string((string) $file);
	if ($single_feed === false || empty($single_feed)) {
		return [
			"status" => false
		];
	}
	$feed[] = $single_feed;
	if (count($feed) > 0) {
		foreach ($feed as $data) {
			if (!empty($data)) {
				if (isset($data->channel->item)) {
					foreach ($data->channel->item as $item) {
						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($item->link);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $userID);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						$utmPostUrl = $item->link;
						$pin_user = $CI->Publisher_model->get_allrecords('pinterest_users', ['user_id' => $userID]);
						$pin_user = $pin_user[0];
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $pin_user->username, 'pinterest');
						}
						$where_rss[0]['key'] = 'url';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'board_id';
						$where_rss[1]['value'] = $page;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $userID;
						$present = $CI->Publisher_model->count_records('pinterest_scheduler', $where_rss);
						if (!$present) {
							$img_path = base_url('assets/images/download.png');
							if (limit_check(RSS_FEED_LATEST_POST_FETCH_ID, 2, $userID)) {
								resources_update('up', RSS_FEED_LATEST_POST_FETCH_ID, $userID);
								create_single_pinterest_rss_feed($userID, $page, $item->title, $img_path, $utmPostUrl, $timeslots, 'latest');
								create_rss_image($userID, $page, $utmPostUrl, "pinterest");
							} else {
								$response = [
									'status' => false,
									'error' => 'Your resource limit has been reached'
								];
								break;
							}
						}
					}
				} else {
					$response = array(
						'status' => false,
						'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
					);
				}
			} else {
				$response = array(
					'status' => false,
					'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
				);
			}
		}
		$response = array(
			'status' => true,
			'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
		);
		$cron_url = 'https://www.adublisher.com/fetchRssLinkImages';
		run_php_background($cron_url);
	} else {
		$response = array(
			'status' => false,
			'error' => 'Your provided link has not valid RSS feed, Please fix and try again.'
		);
	}
	return $response;
}

function ig_user_fetch_more_posts($url, $page, $userID, $timeslots, $mode)
{
	$CI = &get_instance();
	$links = $CI->Publisher_model->appendFeedToUrl($url);
	$userAgent = user_agent();
	$contextOptions = [
		'http' => [
			'user_agent' => $userAgent,
			'ignore_errors' => true
		]
	];
	$context = stream_context_create($contextOptions);
	sleep(1);
	$file = file_get_contents($links, FALSE, $context);
	sleep(1);
	$single_feed = simplexml_load_string((string) $file);
	if ($mode == 1) {
		if (!$single_feed || empty($single_feed)) {
			$response = array(
				'status' => false,
				'error' => 'Your provided link has not valid RSS feed, Please fix and try again.'
			);
		} else {
			$data = [
				'user_id' => $userID,
				'page_id' => $page,
				'type' => 'instagram',
				'url' => $url,
				'published' => 0
			];
			$CI->db->insert('rss_links', $data);
			$response = array(
				'status' => true,
				'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
			);
		}
		return $response;
	}
	foreach ($single_feed as $data) {
		if (!empty($data)) {
			$i = 1;
			if (isset($data->channel->item)) {
				$items_count = count($data->channel->item);
				$few_issues = [];
				foreach ($data->channel->item as $item) {
					$items_count--;
					$item = $data->channel->item[$items_count];
					if ($i > 10) {
						break;
					}
					$metaOfUrlt = metaOfUrlt($item->link, 'instagram');
					sleep(rand(2, 5));
					if (count($metaOfUrlt) > 0) {
						// utm checks on url
						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($item->link);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $userID);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						$utmPostUrl = $item->link;
						$ig_user = $CI->Publisher_model->get_allrecords('instagram_users', ['user_id' => $userID]);
						$ig_user = $ig_user[0];
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $ig_user->instagram_username, 'instagram');
						}
						// utm checks end
						$where_rss = [];
						$where_rss[0]['key'] = 'url';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'ig_id';
						$where_rss[1]['value'] = $page;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $userID;
						// $where_rss[3]['key'] = 'published';
						// $where_rss[3]['value'] = 0;
						$present = $CI->Publisher_model->count_records('instagram_scheduler', $where_rss);
						if (!$present) {
							$i++;
							$img_path = $metaOfUrlt['image'];
							if (empty($img_path)) {
								$img_path = base_url('assets/general/images/no_image_found.jpg');
							}
							if (limit_check(RSS_FEED_LATEST_POST_FETCH_ID, 2, $userID)) {
								resources_update('up', RSS_FEED_LATEST_POST_FETCH_ID, $userID);
								create_single_ig_rss_feed($userID, $page, $item->title, $img_path, $utmPostUrl, $timeslots, 'latest');
							} else {
								$response = [
									'status' => false,
									'error' => 'Your resource limit has been reached'
								];
								break;
							}
						}
					} else {
						$few_issues['errors'][] = $item->link;
					}
				}
			} else {
				$response = array(
					'status' => false,
					'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
				);
			}
		} else {
			$response = array(
				'status' => false,
				'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
			);
		}
	}
	$response = array(
		'status' => true,
		'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
	);
	return $response;
}

function tiktok_fetch_more_posts($url, $page, $userID, $timeslots, $mode)
{
	$CI = &get_instance();
	$CI->load->database();
	$tiktok = $CI->Publisher_model->retrieve_record('tiktok', $page);
	$links = $CI->Publisher_model->appendFeedToUrl($url);
	$userAgent = user_agent();
	ini_set('user_agent', $userAgent);
	$contextOptions = ['http' => ['user_agent' => $userAgent, 'ignore_errors' => true]];
	$context = stream_context_create($contextOptions);
	$file = file_get_contents($links, FALSE, $context);
	$single_feed = simplexml_load_string((string) $file);
	if ($mode == 1) {
		if (!$single_feed || empty($single_feed)) {
			$response = array(
				'status' => false,
				'error' => 'Your provided link has not valid RSS feed, Please fix and try again.'
			);
		} else {
			$data = [
				'user_id' => $userID,
				'page_id' => $tiktok->id,
				'type' => 'tiktok',
				'url' => $url,
				'published' => 0
			];
			$CI->db->insert('rss_links', $data);
			$response = array(
				'status' => true,
				'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
			);
		}
		return $response;
	}

	if (empty($single_feed)) {
		$false_link = $links;
	} else {
		$feed[] = $single_feed;
	}
	if ($feed) {
		foreach ($feed as $data) {
			// $rss = simplexml_load_string($data);
			if (!empty($data)) {
				$i = 1;
				if (isset($data->channel->item)) {
					$items_count = count($data->channel->item);
					$few_issues = [];
					foreach ($data->channel->item as $item) {
						$items_count--;
						$item = $data->channel->item[$items_count];
						if ($i > 10) {
							break;
						}
						$metaOfUrlt = metaOfUrlt($item->link, 'other');
						if (count($metaOfUrlt) > 0) {
							// utm checks on url
							$utm_details = [];
							$utm_check = false;
							$url_detail = getDomain($item->link);
							if (!empty($url_detail['url'])) {
								$domain = $url_detail['url'];
								$utm_details = getUtm($domain, $userID);
								if (count($utm_details) > 0) {
									$utm_check = true;
								}
							}
							$utmPostUrl = $item->link;
							if ($utm_check) {
								$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $tiktok->username, 'tiktok');
							}
							// utm checks end

							$where_rss = [];
							$where_rss[0]['key'] = 'link';
							$where_rss[0]['value'] = $utmPostUrl;
							$where_rss[1]['key'] = 'tiktok_id';
							$where_rss[1]['value'] = $tiktok->id;
							$where_rss[2]['key'] = 'user_id';
							$where_rss[2]['value'] = $userID;
							// $where_rss[3]['key'] = 'posted';
							// $where_rss[3]['value'] = 0;
							$present = $CI->Publisher_model->count_records('tiktok_scheduler', $where_rss);
							if (!$present) {
								$i++;
								$img_path = $metaOfUrlt['image'];
								if (empty($img_path)) {
									$img_path = base_url('assets/general/images/no_image_found.jpg');
								}
								if (limit_check(RSS_FEED_LATEST_POST_FETCH_ID, 2, $userID)) {
									resources_update('up', RSS_FEED_LATEST_POST_FETCH_ID, $userID);
									create_tiktok_single_rss_feed($userID, $tiktok->id, $item->title, $img_path, $utmPostUrl, $timeslots, 'latest');
								} else {
									$response = [
										'status' => false,
										'error' => 'Your resource limit has been reached'
									];
								}
							}
						} else {
							$few_issues['errors'][] = $item->link;
						}
					}
				} else {
					$response = array(
						'status' => false,
						'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
					);
				}
			} else {
				$response = array(
					'status' => false,
					'error' => 'Your provided link has not valid RSS feed, Please fix and try again'
				);
			}
		}
		// Set the flag to true after the foreach loop
		$removeError = removeCronJobError($userID, 'facebook_page_error');
		$response = array(
			'status' => true,
			'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
		);
	} else {
		$response = array(
			'status' => false,
			'error' => 'Your provided link has not valid RSS feed, Please fix and try again.'
		);
	}
	return $response;
}

function fb_page_fetch_past_posts($url, $page_id, $user_id, $timeslots, $mode)
{
	$CI = &get_instance();
	$CI->load->database();
	$CI->load->library('getMetaInfo');

	if (empty($url)) {
		$response = [
			'status' => false,
			'error' => 'Feed URL is empty!'
		];
	} else {
		// facebook page
		$fb_page = $CI->Publisher_model->retrieve_record('facebook_pages', $page_id);
		// auth user
		$user = $CI->Publisher_model->retrieve_record('user', $user_id);
		// update last run for pinterest board
		$CI->Publisher_model->update_last_run($fb_page->id, 'last_run', 'facebook_pages');
		// check user membership and user existence
		$user_check = user_check($user_id);
		if ($user_check['status']) {
			$parsed_url = parse_url($url);
			// Extract the protocol, domain, and append "sitemap.xml" to it
			if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
				$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				$http_domain = 'http://' . $parsed_url['host'];
				$sitemapUrl = $main_domain . '/sitemap.xml';
			}
			// context options
			$arrContextOptions = array('http' => ['method' => "GET", 'header' => "User-Agent: curl/7.68.0\r\n", 'ignore_errors' => true], "ssl" => array("verify_peer" => false, "verify_peer_name" => false,));
			// load xml from sitemap.xml
			$xml = simplexml_load_file($sitemapUrl);
			if (!$xml) {
				$sitemapContent = file_get_contents($sitemapUrl, false, stream_context_create($arrContextOptions));
				if (!empty($sitemapContent)) {
					$xml = simplexml_load_string($sitemapContent);
				}
			}

			if (count($xml) > 0) {
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
				$selectedSitemap = $filteredSitemaps[0];
				$desiredPostCount = 10;
				$loc = (string) $selectedSitemap->loc;
				if (
					strpos($loc, "post-sitemap") !== false ||
					strpos($loc, "sitemap-post") !== false ||
					strpos($loc, "sitemap-") !== false
				) {
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
					// Create a new SimpleXMLElement object to mimic the original structure
					$newSitemapXml = new SimpleXMLElement('<urlset></urlset>');
					foreach ($urlLastModArray as $lastModTimestamp => $urls) {
						foreach ($urls as $urlData) {
							$urlNode = $newSitemapXml->addChild('url');
							$urlNode->addChild('loc', $urlData['loc']);
							$urlNode->addChild('lastmod', $urlData['lastmod']);
						}
					}
					// descending order complete with same structure as xml//
					$postCount = 0;
					foreach ($newSitemapXml->url as $url) {
						$utmPostUrl = '';
						if ($postCount >= $desiredPostCount) {
							break;
						}
						$postUrl = (string) $url->loc; // Cast to string to get the URL
						if ($postUrl == $main_domain . '/' || $postUrl == $http_domain . '/') {
							continue; // Skip the first iteration
						}
						// Check if the URL is already in the database
						// utm checks on url
						$utmPostUrl = $postUrl;

						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($utmPostUrl);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $user_id);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $fb_page->page_name, 'facebook');
						}
						// utm check on url
						$where_rss = [];
						$where_rss[0]['key'] = 'url';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'page_id';
						$where_rss[1]['value'] = $page_id;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $user_id;
						$present = $CI->Publisher_model->count_records('rsssceduler', $where_rss);
						if (!$present) {
							$data['image'] = base_url('assets/images/download.png');
							if (limit_check(RSS_FEED_OLD_POST_FETCH_ID, 2, $user->id)) {
								resources_update('up', RSS_FEED_OLD_POST_FETCH_ID, $user->id);
								create_single_rss_feed($user->id, $page_id, $data['title'], $data['image'], $utmPostUrl, $timeslots, 'past');
								create_rss_image($user->id, $page_id, $utmPostUrl, "facebook");
								// increase post count
								$postCount++;
							} else {
								$response = [
									'status' => false,
									'message' => 'Your resource limit has been reached'
								];
								break;
							}
						}
					}
					$response = [
						'status' => true,
						'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
					];
					$cron_url = 'https://www.adublisher.com/fetchRssLinkImages';
					run_php_background($cron_url);
				} else {
					$response = [
						'status' => false,
						'error' => 'Sitemap Data not found!'
					];
				}
			} else {
				$response = [
					'status' => false,
					'error' => 'Failed to fetch the RSS feed'
				];
			}
		} else {
			$response = [
				'status' => false,
				'error' => $user_check['message']
			];
		}
	}
	return $response;
}

function pin_board_fetch_past_posts($url, $board_id, $user_id, $mode)
{
	$CI = &get_instance();
	$CI->load->database();
	$CI->load->library('getMetaInfo');

	if (empty($url)) {
		$response = [
			'status' => false,
			'error' => 'Feed URL is empty!'
		];
	} else {
		// pinterest board
		$pin_board = $CI->Publisher_model->retrieve_record('pinterest_boards', $board_id);
		// pinterest user
		$pin_user = $CI->Publisher_model->get_allrecords('pinterest_users', ['user_id' => $user_id]);
		$pin_user = $pin_user[0];
		// auth user
		$user = $CI->Publisher_model->retrieve_record('user', $user_id);
		// update last run for pinterest board
		$CI->Publisher_model->update_last_run($pin_board->id, 'last_run', 'pinterest_boards');
		// check user membership and user existence
		$user_check = user_check($user_id);
		if ($user_check['status']) {
			$parsed_url = parse_url($url);
			// Extract the protocol, domain, and append "sitemap.xml" to it
			if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
				$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				$http_domain = 'http://' . $parsed_url['host'];
				$sitemapUrl = $main_domain . '/sitemap.xml';
			}
			// context options
			$arrContextOptions = array('http' => ['method' => "GET", 'header' => "User-Agent: curl/7.68.0\r\n", 'ignore_errors' => true], "ssl" => array("verify_peer" => false, "verify_peer_name" => false,));
			// load xml from sitemap.xml
			$xml = @simplexml_load_file($sitemapUrl);
			if ($xml == false) {
				$response = [
					'status' => false,
				];
				return $response;
			} else {
				$sitemapContent = file_get_contents($sitemapUrl, false, stream_context_create($arrContextOptions));
				if (!empty($sitemapContent)) {
					$xml = simplexml_load_string($sitemapContent);
				}
			}
			if (count($xml) > 0) {
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
				$selectedSitemap = $filteredSitemaps[0];
				$desiredPostCount = 10;
				$loc = (string) $selectedSitemap->loc;
				if (
					strpos($loc, "post-sitemap") !== false ||
					strpos($loc, "sitemap-post") !== false ||
					strpos($loc, "sitemap-") !== false
				) {
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
					// Create a new SimpleXMLElement object to mimic the original structure
					$newSitemapXml = new SimpleXMLElement('<urlset></urlset>');
					foreach ($urlLastModArray as $lastModTimestamp => $urls) {
						foreach ($urls as $urlData) {
							$urlNode = $newSitemapXml->addChild('url');
							$urlNode->addChild('loc', $urlData['loc']);
							$urlNode->addChild('lastmod', $urlData['lastmod']);
						}
					}
					// descending order complete with same structure as xml//
					$postCount = 0;
					foreach ($newSitemapXml->url as $url) {
						$utmPostUrl = '';
						if ($postCount >= $desiredPostCount) {
							break;
						}
						$postUrl = (string) $url->loc; // Cast to string to get the URL
						if ($postUrl == $main_domain . '/' || $postUrl == $http_domain . '/') {
							continue; // Skip the first iteration
						}
						// Check if the URL is already in the database
						// utm checks on url
						$utmPostUrl = $postUrl;

						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($utmPostUrl);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $user_id);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $pin_user->username, 'pinterest');
						}
						// utm check on url
						$where_rss = [];
						$where_rss[0]['key'] = 'url';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'board_id';
						$where_rss[1]['value'] = $board_id;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $user_id;
						// $where_rss[3]['key'] = 'published';
						// $where_rss[3]['value'] = 0;
						$present = $CI->Publisher_model->count_records('pinterest_scheduler', $where_rss);
						if ($present > 0) {
							continue;
						} else {
							$data["image"] = base_url('assets/images/download.png');
							if (limit_check(RSS_FEED_OLD_POST_FETCH_ID, 2, $user->id)) {
								resources_update('up', RSS_FEED_OLD_POST_FETCH_ID, $user->id);
								$CI->Publisher_model->create_single_pinterest_rss_feed($user->id, $pin_board->id, $data['title'], $data['image'], $utmPostUrl, $pin_board->time_slots_rss, 'past');
								create_rss_image($user->id, $pin_board->id, $utmPostUrl, "pinterest");
								// increase post count
								$postCount++;
							} else {
								$response = [
									'status' => false,
									'message' => 'Your resource limit has been reached'
								];
								break;
							}
						}
					}
					$response = [
						'status' => true,
						'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
					];
					$cron_url = 'https://www.adublisher.com/fetchRssLinkImages';
					run_php_background($cron_url);
				} else {
					$response = [
						'status' => false,
						'error' => 'Sitemap Data not found!'
					];
				}
			} else {
				$response = [
					'status' => false,
					'error' => 'Failed to fetch the RSS feed'
				];
			}
		} else {
			$response = [
				'status' => false,
				'error' => $user_check['message']
			];
		}
	}
	return $response;
}


function ig_user_fetch_past_posts($url, $page_id, $user_id, $timeslots, $mode)
{
	$CI = &get_instance();
	$CI->load->database();
	$CI->load->library('getMetaInfo');

	if (empty($url)) {
		$response = [
			'status' => false,
			'error' => 'Feed URL is empty!'
		];
	} else {
		// instagram user
		$ig_user = $CI->Publisher_model->retrieve_record('instagram_users', $page_id);
		// auth user
		$user = $CI->Publisher_model->retrieve_record('user', $user_id);
		// update last run for pinterest board
		$CI->Publisher_model->update_last_run($ig_user->id, 'last_run', 'instagram_users');
		// check user membership and user existence
		$user_check = user_check($user_id);
		if ($user_check['status']) {
			$parsed_url = parse_url($url);
			sleep(1);
			// Extract the protocol, domain, and append "sitemap.xml" to it
			if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
				$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				$http_domain = 'http://' . $parsed_url['host'];
				$sitemapUrl = $main_domain . '/sitemap.xml';
			}
			// context options
			$arrContextOptions = array('http' => ['method' => "GET", 'header' => "User-Agent: curl/7.68.0\r\n", 'ignore_errors' => true], "ssl" => array("verify_peer" => false, "verify_peer_name" => false,));
			// load xml from sitemap.xml
			$xml = simplexml_load_file($sitemapUrl);
			sleep(1);
			if (!$xml) {
				$sitemapContent = file_get_contents($sitemapUrl, false, stream_context_create($arrContextOptions));
				sleep(1);
				if (!empty($sitemapContent)) {
					$xml = simplexml_load_string($sitemapContent);
				}
			}
			if (count($xml) > 0) {
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
				$selectedSitemap = $filteredSitemaps[0];
				$desiredPostCount = 10;
				$loc = (string) $selectedSitemap->loc;
				if (
					strpos($loc, "post-sitemap") !== false ||
					strpos($loc, "sitemap-post") !== false ||
					strpos($loc, "sitemap-") !== false
				) {
					$sitemapUrl = $loc; // Use the filtered URL
					$sitemapXml = simplexml_load_file($sitemapUrl);
					sleep(1);
					if (!$sitemapXml) {
						sleep(1);
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
					// Create a new SimpleXMLElement object to mimic the original structure
					$newSitemapXml = new SimpleXMLElement('<urlset></urlset>');
					foreach ($urlLastModArray as $lastModTimestamp => $urls) {
						foreach ($urls as $urlData) {
							$urlNode = $newSitemapXml->addChild('url');
							$urlNode->addChild('loc', $urlData['loc']);
							$urlNode->addChild('lastmod', $urlData['lastmod']);
						}
					}
					// descending order complete with same structure as xml//
					$postCount = 0;
					foreach ($newSitemapXml->url as $url) {
						$utmPostUrl = '';
						if ($postCount >= $desiredPostCount) {
							break;
						}
						$postUrl = (string) $url->loc; // Cast to string to get the URL
						if ($postUrl == $main_domain . '/' || $postUrl == $http_domain . '/') {
							continue; // Skip the first iteration
						}
						// Check if the URL is already in the database
						// utm checks on url
						$utmPostUrl = $postUrl;

						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($utmPostUrl);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $user_id);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $ig_user->instagram_username, 'instagram');
						}
						// utm check on url
						$where_rss = [];
						$where_rss[0]['key'] = 'url';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'ig_id';
						$where_rss[1]['value'] = $page_id;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $user_id;
						// $where_rss[3]['key'] = 'published';
						// $where_rss[3]['value'] = 0;
						$present = $CI->Publisher_model->count_records('instagram_scheduler', $where_rss);
						if ($present > 0) {
							continue;
						} else {
							// get url info and save it to database
							$CI->load->library('getMetaInfo');
							// Fetching Single Post data
							$data = $CI->getmetainfo->get_info($postUrl, 'instagram');
							if (empty($data['image'])) {
								continue;
							} else {
								if (limit_check(RSS_FEED_OLD_POST_FETCH_ID, 2, $user->id)) {
									resources_update('up', RSS_FEED_OLD_POST_FETCH_ID, $user->id);
									create_single_ig_rss_feed($user->id, $page_id, $data['title'], $data['image'], $utmPostUrl, $timeslots, 'past');
									// increase post count
									$postCount++;
								} else {
									$response = [
										'status' => false,
										'message' => 'Your resource limit has been reached'
									];
									break;
								}
							}
						}
					}
					$response = [
						'status' => true,
						'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
					];
				} else {
					$response = [
						'status' => false,
						'error' => 'Sitemap Data not found!'
					];
				}
			} else {
				$response = [
					'status' => false,
					'error' => 'Failed to fetch the RSS feed'
				];
			}
		} else {
			$response = [
				'status' => false,
				'error' => $user_check['message']
			];
		}
	}
	return $response;
}

function tiktok_fetch_past_posts($url, $page_id, $user_id, $timeslots, $mode)
{
	$CI = &get_instance();
	$CI->load->database();
	$CI->load->library('getMetaInfo');

	if (empty($url)) {
		$response = [
			'status' => false,
			'error' => 'Feed URL is empty!'
		];
	} else {
		// facebook page
		$tiktok = $CI->Publisher_model->retrieve_record('tiktok', $page_id);
		// auth user
		$user = $CI->Publisher_model->retrieve_record('user', $user_id);
		// update last run for tiktok
		$CI->Publisher_model->update_last_run($tiktok->id, 'last_run', 'tiktok');
		// check user membership and user existence
		$user_check = user_check($user_id);
		if ($user_check['status']) {
			$parsed_url = parse_url($url);
			// Extract the protocol, domain, and append "sitemap.xml" to it
			if (isset($parsed_url['scheme']) && isset($parsed_url['host'])) {
				$main_domain = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				$http_domain = 'http://' . $parsed_url['host'];
				$sitemapUrl = $main_domain . '/sitemap.xml';
			}
			// context options
			$arrContextOptions = array('http' => ['method' => "GET", 'header' => "User-Agent: curl/7.68.0\r\n", 'ignore_errors' => true], "ssl" => array("verify_peer" => false, "verify_peer_name" => false,));
			// load xml from sitemap.xml
			$xml = simplexml_load_file($sitemapUrl);
			if (!$xml) {
				$sitemapContent = file_get_contents($sitemapUrl, false, stream_context_create($arrContextOptions));
				if (!empty($sitemapContent)) {
					$xml = simplexml_load_string($sitemapContent);
				}
			}
			if ($mode == '1') {
				if (count($xml) == 0) {
					$response = array(
						'status' => false,
						'error' => 'Provided Feed URL do not has valid Sitemap Data!'
					);
				} else {
					$data = [
						'user_id' => $user_id,
						'page_id' => $tiktok->id,
						'type' => 'tiktok_past',
						'url' => $url,
						'published' => 0
					];
					$CI->db->insert('rss_links', $data);
					$response = array(
						'status' => true,
						'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
					);
				}
				return $response;
			}
			print_pre($xml);
			if (count($xml) > 0) {
				$filteredSitemaps = [];
				foreach ($xml->sitemap as $sitemap) {
					$loc = (string) $sitemap->loc;
					// Check if the <loc> element contains "post-sitemap" or "sitemap-post"
					if (strpos($loc, "post-sitemap") !== false || strpos($loc, "sitemap-post") !== false || strpos($loc, "sitemap-") !== false) {
						$filteredSitemaps[] = $sitemap;
					}
				}
				print_pre($filteredSitemaps);
				usort($filteredSitemaps, function ($a, $b) {
					$numberA = intval(preg_replace('/\D/', '', $a->loc));
					$numberB = intval(preg_replace('/\D/', '', $b->loc));
					return $numberB - $numberA; // Sort in descending order
				});
				$selectedSitemap = $filteredSitemaps[0];
				$desiredPostCount = 10;
				$loc = (string) $selectedSitemap->loc;
				if (
					strpos($loc, "post-sitemap") !== false ||
					strpos($loc, "sitemap-post") !== false ||
					strpos($loc, "sitemap-") !== false
				) {
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
					// Create a new SimpleXMLElement object to mimic the original structure
					$newSitemapXml = new SimpleXMLElement('<urlset></urlset>');
					print_pre('1');
					foreach ($urlLastModArray as $lastModTimestamp => $urls) {
						foreach ($urls as $urlData) {
							$urlNode = $newSitemapXml->addChild('url');
							$urlNode->addChild('loc', $urlData['loc']);
							$urlNode->addChild('lastmod', $urlData['lastmod']);
						}
					}
					// descending order complete with same structure as xml//
					$postCount = 0;
					foreach ($newSitemapXml->url as $url) {
						print_pre('post_count:' . $postCount);
						$utmPostUrl = '';
						if ($postCount >= $desiredPostCount) {
							break;
						}
						$postUrl = (string) $url->loc; // Cast to string to get the URL
						if ($postUrl == $main_domain . '/' || $postUrl == $http_domain . '/') {
							continue; // Skip the first iteration
						}
						// Check if the URL is already in the database
						// utm checks on url
						$utmPostUrl = $postUrl;

						$utm_details = [];
						$utm_check = false;
						$url_detail = getDomain($utmPostUrl);
						if (!empty($url_detail['url'])) {
							$domain = $url_detail['url'];
							$utm_details = getUtm($domain, $user_id);
							if (count($utm_details) > 0) {
								$utm_check = true;
							}
						}
						if ($utm_check) {
							$utmPostUrl = make_utm_url($utmPostUrl, $utm_details, $tiktok->username, 'tiktok');
						}
						// utm check on url
						$where_rss = [];
						$where_rss[0]['key'] = 'link';
						$where_rss[0]['value'] = $utmPostUrl;
						$where_rss[1]['key'] = 'tiktok_id';
						$where_rss[1]['value'] = $tiktok->id;
						$where_rss[2]['key'] = 'user_id';
						$where_rss[2]['value'] = $user_id;
						// $where_rss[3]['key'] = 'posted';
						// $where_rss[3]['value'] = 0;
						$present = $CI->Publisher_model->count_records('tiktok_scheduler', $where_rss);
						print_pre('present' . $present);
						if ($present > 0) {
							continue;
						} else {
							// get url info and save it to database
							$CI->load->library('getMetaInfo');
							// Fetching Single Post data
							$data = $CI->getmetainfo->get_info($postUrl, 'other');
							print_pre($data);
							if (empty($data['image'])) {
								continue;
							} else {
								if (limit_check(RSS_FEED_OLD_POST_FETCH_ID, 2, $user->id)) {
									resources_update('up', RSS_FEED_OLD_POST_FETCH_ID, $user->id);
									create_tiktok_single_rss_feed($user->id, $tiktok->id, $data['title'], $data['image'], $utmPostUrl, $timeslots, 'past');
									// increase post count
									$postCount++;
								} else {
									$response = [
										'status' => false,
										'message' => 'Your resource limit has been reached'
									];
									break;
								}
							}
						}
					}
					$response = [
						'status' => true,
						'message' => 'Good Work!! We are setting up your awesome feed, Please Wait.'
					];
				} else {
					$response = [
						'status' => false,
						'error' => 'Sitemap Data not found!'
					];
				}
			} else {
				$response = [
					'status' => false,
					'error' => 'Failed to fetch the RSS feed'
				];
			}
		} else {
			$response = [
				'status' => false,
				'error' => $user_check['message']
			];
		}
	}
	return $response;
}

function create_single_pinterest_rss_feed($userID, $board_id, $title, $img_path, $url, $timeslots, $post_type = null)
{
	$CI = &get_instance();
	$post_date_time = getNextPostTime("pinterest_scheduler", $userID, $board_id, $timeslots);

	$this_id = $CI->Publisher_model->post_pinterest_rssschedule($userID, $board_id, $title, $img_path, $url, $post_date_time, $post_type);
	return $this_id;
}

function metaOfUrlt($request_url, $mode = null)
{
	$CI = &get_instance();
	$response['image'] = '';
	$response['title'] = '';
	$response['status'] = false;

	if (!empty($request_url)) {
		$CI->load->library('getMetaInfo');
		$info = $CI->getmetainfo->get_info($request_url, $mode);

		if (!empty($info['image'])) {
			$response['image'] = $info['image'];
			$response['status'] = true;
		}
		if (!empty($info['title'])) {
			$response['title'] = $info['title'];
			$response['status'] = true;
		}
		// Do not set status and image when cURL error occurs
	}
	return $response;
}

function create_single_rss_feed($userID, $page, $title, $img_path, $url, $timeslots, $post_type = null)
{
	$CI = &get_instance();
	$post_date_time = getNextPostTime("rsssceduler", $userID, $page, $timeslots);
	$this_id = $CI->Publisher_model->post_rssschedule($userID, $page, $title, $img_path, $url, $post_date_time, $post_type);
	return $this_id;
}

function create_tiktok_single_rss_feed($userID, $page, $title, $img_path, $url, $timeslots, $post_type = null)
{
	$CI = &get_instance();
	$post_date_time = getNextPostTime("tiktok_scheduler", $userID, $page, $timeslots);
	print_pre($post_date_time);
	$this_id = $CI->Publisher_model->post_tiktok_rssschedule($userID, $page, $title, $img_path, $url, $post_date_time, $post_type);
	return $this_id;
}

function create_single_ig_rss_feed($userID, $ig_id, $title, $img_path, $url, $timeslots, $post_type = null)
{
	$CI = &get_instance();
	$post_date_time = getNextPostTime("instagram_scheduler", $userID, $ig_id, $timeslots);
	$this_id = $CI->Publisher_model->post_ig_rssschedule($userID, $ig_id, $title, $img_path, $url, $post_date_time, $post_type);
	return $this_id;
}

function getNextPostTime($table, $userID, $page, $timeslots, $for_update = array())
{
	$CI = &get_instance();
	$CI->load->database();
	$user = $CI->Publisher_model->retrieve_record('user', $userID);
	$time_slots_arr = is_array($timeslots) ? $timeslots : explode(",", $timeslots);
	$time_slots_size = count($time_slots_arr);
	$last_time_slot_element = $time_slots_arr[$time_slots_size - 1];
	if ($table == "bulkupload") {
		// ================================= For Update ============================================// 
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
		}
		// ============================= End of Bulk Upload ========================================// 
	} else if ($table == "channels_scheduler") {
		// ================================= For Update ============================================// 
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE channel_id = $page AND user_id = $userID AND status = 1 ORDER BY post_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
		}
		// ============================= End of Channel Scheduler ==================================// 
	} else if ($table == "pinterest_scheduler") {
		// ================================= For Update ============================================// 
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		}
		// ============================== End of Pinterest Scheduler ===============================// 
	} else if ($table == "instagram_scheduler") {
		// ================================= For Update ============================================// 
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		}
		// ============================= End of Instagram Scheduler ================================// 
	} else if ($table == "facebook_group_scheduler") {
		// ================================= For Update ============================================// 
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		}
		// ========================== End of Facebbok Group Scheduler ===============================// 
	} elseif ($table == "youtube_scheduler") {
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE channel_id = $page AND user_id = $userID AND published = 1 ORDER BY publish_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY publish_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->publish_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT publish_datetime FROM $table WHERE channel_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		}
	} elseif ($table == "tiktok_scheduler") {
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE tiktok_id = $page AND user_id = $userID AND published = 1 ORDER BY post_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE tiktok_id = $page AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE tiktok_id = $page AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
		}
	}
	// Start of Youtube Scheduling
	else {
		// ================================= For Update ============================================// 
		if (!empty($for_update) && $for_update['get_first_slot'] == true) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID AND posted = 1 ORDER BY post_datetime DESC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = '';
			}
		} elseif (!empty($for_update) && isset($for_update['get_next_slot'])) {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID ORDER BY post_datetime ASC LIMIT 1");
			if ($last_scedule->num_rows() > 0) {
				$last_scedule->row()->post_datetime = $for_update['get_next_slot'];
			}
		}
		// ================================= For Insert ============================================// 
		else {
			$last_scedule = $CI->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
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
	if (empty($next_hour)) {
		$next_hour = "00";
	}
	$next_post_date_time = $last_date . " " . $next_hour . ":00";
	return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
}

function saveImageFromUrl($url, $user_id, $page_id = '', $name = 'profile_pic')
{
	$image = file_get_contents($url);
	if ($image === false) {
		return  "";
	}
	// Create a new file in the assets folder
	$ext = 'webp';
	$filename = $user_id . '_' . $page_id . '_' . $name . '.' . $ext;
	$destinationPath = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $filename;
	if (file_exists($destinationPath)) {
		remove_file($filename);
	}
	$fileHandle = fopen($destinationPath, 'wb');
	// Write the video content to local storage using fput
	$write = fwrite($fileHandle, $image);
	// Close the file stream
	fclose($fileHandle);
	if ($write) {
		return $filename;
	} else {
		return '';
	}
}

function tiktok_image_url($url, $value)
{
	$fetch_from_url = metaOfUrlt($url, 'other');
	$image_path = isset($fetch_from_url['image']) && !empty($fetch_from_url['image']) ? saveImageFromUrl($fetch_from_url['image'], $value->user_id, $value->id, rand()) : '';
	return $image_path;
}

function getImageExtensionFromUrl($url)
{
	// Parse the URL to get the path
	$path = parse_url($url, PHP_URL_PATH);
	// Extract the extension from the path
	$extension = pathinfo($path, PATHINFO_EXTENSION);

	return $extension;
}

if (!function_exists('check_for_url')) {
	function check_for_url($string)
	{
		$lines = explode("\n", $string);
		foreach ($lines as $line) {
			$url_check = getDomain($line);
			if (!empty($url_check['url'])) {
				return $line;
			}
		}
		return false;
	}
}

if (!function_exists('make_utm_string')) {
	function make_utm_string($string, $utm_codes, $profile_name, $type)
	{

		$lines = explode("\n", $string);
		foreach ($lines as $line) {
			$url_check = getDomain($line);
			if (!empty($url_check['url'])) {
				$utm_url = make_utm_url($line, $utm_codes, $profile_name, $type);
			}
		}
		$pattern = '/(https?:\/\/[^\s]+)/';
		$resultant_string = preg_replace($pattern, $utm_url, $string);

		return $resultant_string;
	}
}

if (!function_exists('utm_check_details')) {
	function utm_check_details($link)
	{
		$data = [];
		$data['utm_check'] = false;
		$url_detail = getDomain($link);
		if (!empty($url_detail['url'])) {
			$domain = $url_detail['url'];
			$utm_details = getUtm($domain);
			$data['utm_details'] = $utm_details;
			if (count($utm_details) > 0) {
				$data['utm_check'] = true;
			}
		}
		return $data;
	}
}

function run_php_background($url)
{
	$cmd = "curl --silent ";
	$cmd .= "'" . $url . "'";
	$cmd .= " > /dev/null 2>&1 &";
	exec($cmd, $output, $exit);
	return true;
}

if (!function_exists('post_insight')) {
	function post_insight($post_id, $access_token)
	{
		$CI = &get_instance();
		$CI->load->library('facebook');
		$period = 'lifetime';
		$metric_array = [
			'post_clicks', //total post clicks
			'post_clicks_by_type', //clicks by type
			'post_impressions_unique', //number of people who have seen the post (reach)
			'post_impressions', //number of times the post has entered a feed (views)
			'post_impressions_fan', //number of people who has seen the post and liked the page
			'post_reactions_by_type_total', //number of reactions by type
			'post_activity_by_action_type_unique', //number of unique people who interact with post (like, share, comment)
		];
		$metric = implode(',', $metric_array);
		$post_insight = $CI->facebook->request('get', '/' . $post_id . '/insights?access_token=' . $access_token . '&metric=' . $metric . '&period=' . $period);
		return $post_insight;
	}
}
if (!function_exists('comment_count')) {
	function comment_count($post_id, $access_token)
	{
		$CI = &get_instance();
		$CI->load->library('facebook');
		$comment_count = $CI->facebook->request('get', '/' . $post_id . '/comments?access_token=' . $access_token . '&summary=1');
		return $comment_count;
	}
}
if (!function_exists('shares_count')) {
	function shares_count($post_id, $access_token)
	{
		$CI = &get_instance();
		$CI->load->library('facebook');
		$shares_count = $CI->facebook->request('get', '/' . $post_id . '/sharedposts?access_token=' . $access_token . '&summary=1');
		return $shares_count;
	}
}
function increasing_chart()
{
	$increasing_chart = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" fill="currentColor" viewBox="0 0 256 256" style="color: hsla(146, 100%, 40%, 1);"><path d="M240,56v64a8,8,0,0,1-16,0V75.31l-82.34,82.35a8,8,0,0,1-11.32,0L96,123.31,29.66,189.66a8,8,0,0,1-11.32-11.32l72-72a8,8,0,0,1,11.32,0L136,140.69,212.69,64H168a8,8,0,0,1,0-16h64A8,8,0,0,1,240,56Z"></path></svg>';
	return $increasing_chart;
}

function post_div($page, $title, $published, $post_image, $post_id, $user, $type = null)
{
	if ($type == 'facebook') {
		$page_name = $page->page_name;
		$logo = BulkAssets . $page->profile_pic;
	} else if ($type == 'tiktok') {
		$page_name = $page->username;
		$logo = BulkAssets . $page->profile_pic;
	}
	$published_at = utcToLocal($published, $user->gmt, 'Y-m-d H:i:s');
	$content_div = '';
	$content_div .= '<div class="post__content__data">';
	$content_div .= '<div class="post__text__content">';
	$content_div .= '<div class="d-flex align-items-center"><div><img class="rounded-pill" style="width:25px;" src="' . $logo . '"></img></div><p class="post__header px-1" data-id="' . $post_id . '" date-type="' . $type . '">' . $page_name . '</p></div>';
	$content_div .= '<p class="post__description" title="' . $title . '">' . $title . '</p>';
	// $content_div .= '<span class="post__date">' . utcToLocal($published, $user->gmt, 'D, j M') . ' at ' . utcToLocal($published, $user->gmt, 'H:i') . '</span>';
	$content_div .= '<span class="post__date">' . date("D, j M", strtotime($published_at)) . ' at ' . date("H:i", strtotime($published_at)) . '</span>';
	$content_div .= '</div>';
	$content_div .= '<div class="post__img__container">';
	$content_div .= '<img src="' . SITEURL . "assets/bulkuploads/" . $post_image . '" alt="Post Image">';
	$content_div .= '</div>';
	$content_div .= '</div>';
	return $content_div;
}

function clean_response($string)
{
	$pos = strpos($string, '=');
	if ($pos !== false) {
		$response = substr($string, $pos + 1);
	} else {
		$response = '';
	}
	return $response;
}
function calendar_event_title($page_name, $post, $user, $type = null, $date_type = null)
{
	if ($type == 'facebook') {
		$img = 'images/facebook_logo.png';
	} elseif ($type == 'pinterest') {
		$img = 'images/pinterest_logo.png';
	} elseif ($type == 'instagram') {
		$img = 'images/instagram_logo.png';
	} elseif ($type == 'tiktok') {
		$img = 'images/tiktok_logo.png';
	}

	$title = '<div class="d-flex" style="flex-wrap:wrap; overflow-x:hidden;">';
	$title .= '<div>';
	$title .= '<div class="d-flex">';
	$title .= '<img src="' . GeneralAssets . $img . '" width="20px">';
	$title .= '<p class="small-font-size m-0">' . $page_name . '</p>';
	$title .= '</div>';
	$title .= '</div>';
	$title .= '<div>';
	$title .= '<span class="text-dark small-font-size">' . utcToLocal($post['published_at'], $user->gmt, 'h:i A') . '</span>';
	$title .= '</div>';
	$title .= '</div>';
	$title .= '<div class="event_post_title">';
	if (!empty($post['post_title'])) {
		$title .= '<p class="post_title m-0" title="' . $post['post_title'] . '">' . $post['post_title'] . '</p>';
	}
	$title .= '</div>';
	$title .= '<div>';
	if (!empty($post['post_image'])) {
		$image = $post['post_image'];
		$title .= '<img src="' . $image . '" loading="lazy" class="w-100 mt-2 post_image">';
	}
	$title .= '</div>';
	$title .= '<div class="d-flex justify-content-between mt-2 px-1 text-dark" style="font-weight: bolder;">';
	$title .= '<div><span><i class="fa fa-earth-americas mr-1" title="Reach"></i>' . $post['post_reach'] . '</span></div>';
	$title .= '<div><span><i class="fa fa-users mr-1" title="Engagements"></i>' . $post['post_engagements'] . '</span></div>';
	$title .= '<div><span><i class="fa fa-thumbs-up mr-1" title="Likes"></i>' . $post['post_likes'] . '</span></div>';
	$title .= '</div>';
	return $title;
}

function get_cache_data($key, $user_id = null, $array = null)
{
	$CI = &get_instance();
	$CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	// Check if data exists in cache
	$cached_data = $CI->cache->get($key);

	// $CI->cache_delete('');
	if (!empty($cached_data) && count($cached_data) > 0) {
		// Data found in cache
		$response = [
			'data' => $cached_data
		];
		return $response;
	} else {
		$time = 60 * 60;
		// Get published facebook posts
		if (strpos($key, 'fb_pub_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('facebook_posts', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data,
			];
		}
		// Get scheduled facebook posts
		if (strpos($key, 'social_scheduled_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('channels_scheduler', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data
			];
		}
		// Get scheduled pnterest posts
		if (strpos($key, 'pin_scheduled_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('channels_scheduler', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data
			];
		}
		// Get rss scheduled facebook posts
		if (strpos($key, 'fb_rss_scheduled_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('rsssceduler', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data
			];
		}
		// Get rss scheduled pinterest posts
		if (strpos($key, 'pinterest_rss_scheduled_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('pinterest_scheduler', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data
			];
		}
		// Get rss scheduled instagram posts
		if (strpos($key, 'instagram_rss_scheduled_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('instagram_scheduler', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data
			];
		}
		// Get rss scheduled tiktok posts
		if (strpos($key, 'tiktok_rss_scheduled_calendar_events') !== false) {
			$data = $CI->Publisher_model->calendar_events('tiktok_scheduler', array('user_id' => $user_id), array('start_date' => $array['start_date'], 'end_date' => $array['end_date']));
			$response = [
				'data' => $data
			];
		}
		// Get US holidays
		if (strpos($key, 'us_holidays_events') !== false) {
			$data = $CI->Publisher_model->us_holidays($array['year'], $array['month']);
			$response = [
				'data' => $data
			];
			$time = 60 * 60 * 24;
		}
		// Get all Countries
		if (strpos($key, 'get_country_name') !== false) {
			$data = $CI->Publisher_model->country_full_name($user_id);
			$response = [
				'data' => $data
			];
			$time = 60 * 60 * 24 * 365;
		}
		if (strpos($key, 'get_countries_data') !== false) {
			$data = $CI->Publisher_model->country_data($array['page_id'], $array['access_token'], $array['since'], $array['until']);
			$response = [
				'data' => $data
			];
			$time = 60 * 60 * 24;
		}
		if (strpos($key, 'get_cities_data') !== false) {
			$data = $CI->Publisher_model->city_data($array['page_id'], $array['access_token'], $array['since'], $array['until']);
			$response = [
				'data' => $data
			];
			$time = 60 * 60 * 24;
		}
		// Store data in cache
		$CI->cache->save($key, $data, $time); // Cache for 1 hour (3600 seconds)

		return $response;
	}
}

function format_calendar_date($date)
{
	$date_array = explode(", ", $date);
	$year = $date_array[1];
	$date = explode(' – ', $date_array[0]);
	$end_date = $date[1];
	$date = explode(' ', $date[0]);
	$month = date('m', strtotime($date[0]));
	$start_date = $date[1];
	$start_date = $year . '-' . $month . '-' . $start_date;
	$end_date = $year . '-' . $month . '-' . $end_date;
	return [
		'start_date' => $start_date,
		'end_date' => $end_date,
	];
}

function array_grouping_with_date($array)
{
	$result = array();
	$count = count($array);
	if ($count >= 30) {
		$group_size = 10;
	} else {
		$group_size = ceil($count / 7);
	}
	if ($group_size > 1) {
		$length = 0;
		$i = 0;
		$group_count = 0;
		$date_time = '';
		foreach ($array as $datetime => $value_array) {
			$sliced_array = [];
			$temp_array = [];
			if ($i % $group_size != 0) {
				$date_time = '';
				$i++;
				continue;
			}
			$new_datetime = date('Y-m-d', strtotime('+' . ($group_size - 1) . ' days', $datetime));
			$date_time = empty($date_time) ? strtotime($new_datetime) : $date_time;
			$start = $group_count * $group_size;
			$length += $group_size;
			$sliced_array = array_slice($array, $start, $length);
			foreach ($sliced_array as $key => $country_array) {
				foreach ($country_array as $name => $value) {
					$temp_array[$name] = isset($temp_array[$name]) ? $temp_array[$name] += $value : $temp_array[$name] = $value;
				}
			}
			$result[$date_time] = $temp_array;
			$group_count++;
			$i++;
		}
	} else {
		$result = $array;
	}
	return $result;
}
function fetch_fb_post_insight($post_id, $access_token)
{
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
		'id' => ''
	];
	$post_insight = post_insight($post_id, $access_token);
	if (isset($post_insight['data']) && count($post_insight['data']) > 0) {
		$data['id'] = $post_id;
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
	}
	return $data;
}

function event_info_body($post, $page, $user)
{
	// post image
	$image_source = !empty($post->post_image) ? $post->post_image : GeneralAssets . 'images/facebook_logo.png';
	// page thumnail
	$page_thumbail = !empty($page['page_thumbnail']) ? SITEURL . 'assets/bulkuploads/' . $page['page_thumbnail'] : GeneralAssets . 'images/facebook_logo.png';
	// reach rate
	$reach_rate = $post->impressions > 0 ? number_format(($post->reach / $post->impressions) * 100, 1) : '0';
	$reach_rate = fmod($reach_rate, 1) == 0 ? (int) $reach_rate : $reach_rate;
	// publish date/time
	$published_at = utcToLocal($post->published_at, $user->gmt, 'Y-m-d H:i:s');
	$date = date('d F Y', strtotime($published_at));
	$time = date('h:i A', strtotime($published_at));
	$published_at = $date . ' at ' . $time;
	// div body
	$div = '<div class="popup-body p-0 m-0">
						<div class="d-flex justify-content-between pl-3 pb-3">
							<span><b>Post Analytic</b></span>
                            <span class="close-button">&times;</span>
                        </div>
                <div class="row g-0 m-0">
                    <div class="col-12 col-md-7">
                        <div class="popup__post__content__area">
                            <div class="popup__heading__area px-3 pt-3 ">
								<div class="popup__title__img m-0">
									<img class="round" src=' . $page_thumbail . '>
								</div>
								<div>
									<p class="popup__head__page__name m-0">' . $page['page_name'] . '</p>
									<p class="popup__head__description">' . $published_at . '</p>
								</div>
                            </div>';
	if ($post->post_title) {
		$div .= '<div class="post__title px-3 pb-3">
							<p class="m-0">' . $post->post_title . '</p>
							</div>';
	}
	$div .= '<div class="popup__post__image__area">
                                <img src="' . SITEURL . "assets/bulkuploads/" . $image_source . '" alt="">
                            </div>
							<div class="popup__post__footer">
                                <div class="icon__group">
                                    <i class="fa fa-thumbs-up"></i>
                                    <span>' . $post->likes . '</span>
                                </div>
                                <div class="icon__group">
                                    <i class="fa fa-comment"></i>
                                    <span>' . $post->comments . '</span>
                                </div>
                                <div class="icon__group">
                                    <i class="fa fa-share"></i>
                                    <span>' . $post->shares . '</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="popup__post__analytics__area">
                            <div class="popup__post__analytics__container">
                                <div class="row g-0  m-0">
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Impressions
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->impressions . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Reach
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->reach . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Engagements
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->engagements . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Reactions
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->reactions . '
                                            </p>
                                        </div>
                                    </div>';
	if ($post->reach > 0) {
		$div .= '<div class="col-12 p-0 border-bottom">
																		<div class="m-2">
																			<p class="large__heading">
																				Reach
																			</p>
																			<p class="small__heading">
																				Followers vs Non-followers
																			</p>
																		</div>
																		<div class="d-flex justify-content-center">
																			<canvas id="reach_chart"></canvas>
																		</div>
																	</div>';
	}
	$div .= '<div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Comments
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->comments . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Shares
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->shares . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Post Clicks
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->post_clicks . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Link Clicks
                                            </p>
                                            <p class="large__heading">
                                                ' . $post->link_clicks . '
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
	return $div;
}

function popup_div($post, $page, $user)
{
	$facebook_post_url = "https://www.facebook.com/" . $post->post_id;
	$image_source = !empty($post->post_image) ? $post->post_image : $post->profile_pic;
	$page_thumbail = !empty($page[0]->profile_pic) ? SITEURL . 'assets/bulkuploads/' . $page[0]->profile_pic : '';
	$video_views = $post->type == 'Video' ? $post->video_views : '--';
	$link_clicks = $post->type == 'Link' ? $post->link_clicks : '--';
	$link_clicks = !empty($link_clicks) ? $link_clicks : '0';
	$reach_rate = $post->impressions > 0 ? number_format(($post->reach / $post->impressions) * 100, 1) : '0';
	$reach_rate = fmod($reach_rate, 1) == 0 ? (int) $reach_rate : $reach_rate;
	$published_at = utcToLocal($post->published_at, $user->gmt, 'Y-m-d H:i:s');
	$date = date('d F Y', strtotime($published_at));
	$time = date('h:i A', strtotime($published_at));
	$published_at = $date . ' at ' . $time;
	$post_comments = !empty($post->comments) ? $post->comments : '0';
	$post_shares = !empty($post->shares) ? $post->shares : '0';
	$post_impressions = !empty($post->impressions) ? $post->impressions : '0';
	$post_reach = !empty($post->reach) ? $post->reach : '0';
	$post_engagements = !empty($post->engagements) ? $post->engagements : '0';
	$post_reactions = !empty($post->reactions) ? $post->reactions : '0';
	$post_clicks = !empty($post->post_clicks) ? $post->post_clicks : '0';
	$eng_rate = !empty($post->eng_rate) ? $post->eng_rate : '0';
	$ctr = !empty($post->ctr) ? $post->ctr : '0';
	$div = '<div class="popup-body p-0 m-0">
						<div class="d-flex justify-content-between pl-4">
							<span><b>Post Analytic</b></span>
                            <span class="close-button">&times;</span>
                        </div>
                <div class="row g-0 m-0">
                    <div class="col-12 col-md-7">
                        <div class="popup__post__content__area">
                            <div class="popup__heading__area px-3 pt-3 ">
								<div class="popup__title__img m-0">
									<img class="round" src=' . $page_thumbail . '>
								</div>
								<div>
									<p class="popup__head__page__name m-0">' . $page[0]->page_name . '</p>
									<p class="popup__head__description">' . $published_at . '</p>
								</div>
                            </div>';
	if ($post->post_title) {
		$div .= '<div class="post__title px-3 pb-3">
							<p class="m-0">' . $post->post_title . '</p>
							</div>';
	}
	$div .= '<div class="popup__post__image__area">
                                <img src="' . SITEURL . "assets/bulkuploads/" . $image_source . '" alt="">
                            </div>
							<div class="popup__post__footer">
                                <div class="icon__group">
                                    <i class="fa fa-thumbs-up"></i>
                                    <span>' . $post->likes . '</span>
                                </div>
                                <div class="icon__group">
                                    <i class="fa fa-comment"></i>
                                    <span>' . $post->comments . '</span>
                                </div>
                                <div class="icon__group">
                                    <i class="fa fa-share"></i>
                                    <span>' . $post->shares . '</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="popup__post__analytics__area">
                            <div class="popup__post__analytics__container">
                                <div class="row g-0  m-0">
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Impressions
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_impressions . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Reach
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_reach . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Engagements
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_engagements . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Reactions
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_reactions . '
                                            </p>
                                        </div>
                                    </div>';
	if ($post->reach > 0) {
		$div .= '<div class="col-12 p-0 border-bottom">
										<div class="m-2">
											<p class="large__heading">
												Reach
											</p>
											<p class="small__heading">
												Followers vs Non-followers
											</p>
										</div>
										<div class="d-flex justify-content-center">
											<canvas id="reach_chart"></canvas>
										</div>
									</div>';
	}
	$div .= '<div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Comments
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_comments . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Shares
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_shares . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Post Clicks
                                            </p>
                                            <p class="large__heading">
                                                ' . $post_clicks . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Link Clicks
                                            </p>
                                            <p class="large__heading">
                                                ' . $link_clicks . '
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Video Views
                                            </p>
                                            <p class="large__heading">
                                                ' . $video_views . '
                                            </p>
                                        </div>
                                    </div>
									<div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Reach Rate
                                            </p>
                                            <p class="large__heading">
                                                ' . $reach_rate . '%
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Engagement Rate
                                            </p>
                                            <p class="large__heading">
                                                ' . $eng_rate . '%
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="analytics_container m-2 analytics__small__container">
                                            <p class="small__heading">
                                                Click Through Rate
                                            </p>
                                            <p class="large__heading">
                                                ' . $ctr . '%
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="post__analytics__button__holder">
                                    <a target="_blank" href="' . $facebook_post_url . '" class="btn btn-colored mlight-3">
                                        View Post
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
	return $div;
}
function recent_post_action_div()
{
	$action_div = '';
	$action_div .= '<div class="overview__post__menu">';
	$action_div .= '<button class="menu__list__post__toggler">';
	$action_div .= '<i class="bx bx-dots-horizontal-rounded"></i>';
	$action_div .= '</button>';
	$action_div .= '<div class="menu__list__post" style="display:none;">';
	$action_div .= '<a href="#" class="nav-link">Reuse Post</a>';
	$action_div .= '<a href="#" class="nav-link">Share Post</a>';
	$action_div .= '<a href="#" class="nav-link">View Post</a>';
	$action_div .= '</div>';
	$action_div .= '</div>';
	return $action_div;
}
// gooogle and youtube functions
function get_google_access_token_by_api($code = null)
{
	if (!empty($code)) {
		$url = "https://oauth2.googleapis.com/token";
		$data = array(
			"client_id" => GOOGLE_CLIENT_ID,
			"client_secret" => GOOGLE_CLIENT_SECRET,
			"grant_type" => 'authorization_code',
			"redirect_uri" => SITEURL . "get_google_access_token",
			"code" => $code,
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
		));

		$response = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($response, true);
		if (isset($response['access_token'])) {
			$access_token = $response['access_token'];
			if ($access_token) {
				$google_user_info = get_google_user_info_by_api($access_token);
				if ($google_user_info['success']) {
					$google_user_info = $google_user_info['user_info'];
					$check_google_auth = check_google_auth($google_user_info['id']);
					if ($check_google_auth) {
						update_google_user($response, $google_user_info);
					} else {
						create_google_user($response, $google_user_info);
					}
					return array(
						'success' => true,
						'access_token' => $access_token,
						'google_id' => $google_user_info['id']
					);
				} else {
					return array(
						'success' => false,
						'message' => 'Something went wrong!'
					);
				}
			} else {
				return array(
					'success' => false,
					'message' => 'Something went wrong!'
				);
			}
		} else {
			return array(
				'success' => false,
				'message' => $response['error']
			);
		}
	}
}

function get_google_user_info_by_api($access_token = null, $insert_id = null)
{
	if (!empty($access_token)) {
		$url = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $access_token;

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		]);
		$response = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($response, true);
		if (count($response) > 0) {
			if (isset($response['id'])) {
				save_google_info($response);
				return array(
					'success' => true,
					'user_info' => $response
				);
			} else {
				$error = $response['error'];
				return array(
					'success' => false,
					'message' => $error->message

				);
			}
		} else {
			return array(
				'success' => false,
				'message' => 'Something went wrong!'
			);
		}
	} else {
		return array(
			'success' => false,
			'message' => 'Access token not found!'
		);
	}
}

function check_google_auth($google_id = null)
{
	if (!empty($google_id)) {
		$user_id = App::Session()->get('userid');
		$CI = &get_instance();
		$CI->load->database();
		$where = array(
			'user_id' => $user_id,
			'google_id' => $google_id
		);
		$query = $CI->db->get_where('google_users', $where);
		if ($query->row() != null) {
			return true;
		} else {
			return false;
		}
	}
}

function create_google_user($data, $google_info)
{
	$user_id = App::Session()->get('userid');
	$column['user_id'] = $user_id;
	$column['google_id'] = $google_info['id'];
	$column['access_token'] = $data['access_token'];
	if (isset($data['refresh_token'])) {
		$column['refresh_token'] = $data['refresh_token'];
	}
	$column['scopes'] = $data['scope'];
	$column['expires_in'] = $data['expires_in'];
	$column['expires_at'] = calculate_expire_date($data['expires_in']);
	$CI = &get_instance();
	$CI->load->database();
	$response = $CI->db->insert('google_users', $column);
	$insert_id = $CI->db->insert_id();
	return $insert_id;
}

function update_google_user($data, $google_info)
{
	$CI = &get_instance();
	$CI->load->database();
	$user_id = App::Session()->get('userid');
	$column['user_id'] = $user_id;
	$column['google_id'] = $google_info['id'];
	$column['access_token'] = $data['access_token'];
	if (isset($data['refresh_token'])) {
		$column['refresh_token'] = $data['refresh_token'];
	}
	$column['scopes'] = $data['scope'];
	$column['expires_in'] = $data['expires_in'];
	$column['expires_at'] = calculate_expire_date($data['expires_in']);
	$where = array(
		'user_id' => $user_id,
		'google_id' => $google_info['id']
	);
	$response = $CI->db->update('google_users', $column, $where);
	return $response;
}

function calculate_expire_date($date = null)
{
	$add_time = round($date / 60) . ' minutes';
	$expiry_date = date("Y-m-d H:i:s", strtotime('+' . $add_time, strtotime(date('Y-m-d H:i:s'))));
	return $expiry_date;
}

function save_google_info($data)
{
	$user_id = App::Session()->get('userid');
	$column = array(
		'google_id' => $data['id'],
		'google_name' => $data['name'],
		'google_email' => $data['email'],
	);
	$CI = &get_instance();
	$query = $CI->db->get_where('user', array('id' => $user_id));
	if ($query->row() != null) {
		$response = $CI->db->update('user', $column, array('id' => $user_id));
		if ($response) {
			return true;
		} else {
			return false;
		}
	}
}

function get_youtube_channels_by_api($access_token = null, $google_id = null)
{
	if (!empty($access_token)) {
		$user_id = App::Session()->get('userid');

		$url = "https://www.googleapis.com/youtube/v3/channels?";
		$data["part"] = "snippet";
		$data["mine"] = 1;
		foreach ($data as $key => $value) {
			$url .= $key . '=' . $value . '&';
		}
		$url = rtrim($url, '&');

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
		$response = json_decode($response, true);
		if (isset($response['items'])) {
			$channels = $response['items'];
			foreach ($channels as $key => $channel) {
				if (limit_check(AUTHORIZE_SOCIAL_ACCOUNTS_ID, 2)) {
					$channel_detail = $channel['snippet'];
					$channel_id = $channel['id'];
					$channel_title = $channel_detail['title'];
					$channel_description = $channel_detail['description'];
					$thumbnails = $channel_detail['thumbnails'];
					if (isset($thumbnails['high'])) {
						$channel_thumbnail = saveImageFromUrl($thumbnails['high']['url'], $user_id, $channel_id);
					} elseif (isset($thumbnails['medium'])) {
						$channel_thumbnail = saveImageFromUrl($thumbnails['medium']['url'], $user_id, $channel_id);
					} else {
						$channel_thumbnail = saveImageFromUrl($thumbnails['default']['url'], $user_id, $channel_id);
					}
					$country = $channel_detail['country'];
					$column = array(
						'channel_id' => $channel_id,
						'google_id' => $google_id,
						'channel_title' => $channel_title,
						'channel_description' => $channel_description,
						'channel_thumbnail' => $channel_thumbnail,
						'country' => $country,
						'active' => 1,
						'user_id' => $user_id,
					);
					update_or_create_channel($channel_id, $column);
				}
			}
			$response = [
				'success' => true,
				'message' => 'Your Youtube Account is Successfully Attached With Adublisher.com'
			];
		} else {
			$errors = $response['error']['errors'];
			$response = [];
			$response['success'] = false;
			$response['error'] = '';
			foreach ($errors as $key => $val) {
				$response['error'] .= $val['message'];
			}
		}
		curl_close($curl);
		return $response;
	}
}

function update_or_create_channel($channel_id, $channel)
{
	$user_id = App::Session()->get('userid');
	$CI = &get_instance();
	$query = $CI->db->get_where('youtube_channels', array('user_id' => $user_id, 'channel_id' => $channel_id));
	if ($query->row() != null) {
		$response = $CI->db->update('youtube_channels', $channel, array('user_id' => $user_id, 'channel_id' => $channel_id));
	} else {
		$channel['channel_active'] = '0';
		$response = $CI->db->insert('youtube_channels', $channel);
		resources_update('up', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
	}
	return $response;
}

function fetch_channel_access_token($google_id)
{
	$where = array(
		'user_id' => App::Session()->get('userid'),
		'google_id' => $google_id
	);
	$CI = &get_instance();
	$CI->load->database();
	$query = $CI->db->get_where('google_users', $where);
	$response = $query->row();
	if (!empty($response)) {
		if (!empty($response->expires_at)) {
			$now = strtotime(date('Y-m-d H:i:s'));
			$expires_at = strtotime($response->expires_at);
			if ($now >= $expires_at) {
				$google_user_info = array(
					'id' => $google_id
				);
				refresh_access_token($response->refresh_token, $google_user_info);
				fetch_channel_access_token($google_id);
			} else {
				$access_token = $response->access_token;
			}
		} else {
			$access_token = '';
		}
	} else {
		$access_token = '';
	}
	return $access_token;
}

function refresh_access_token($refresh_token, $google_user_info)
{
	$url = "https://oauth2.googleapis.com/token";
	$data = array(
		"client_id" => GOOGLE_CLIENT_ID,
		"client_secret" => GOOGLE_CLIENT_SECRET,
		"grant_type" => 'refresh_token',
		"refresh_token" => $refresh_token,
	);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $data,
	));

	$response = curl_exec($curl);
	curl_close($curl);

	$response = json_decode($response, true);
	if (isset($response['access_token'])) {
		$return_response = update_google_user($response, $google_user_info);
		if ($return_response) {
			return array(
				'success' => true
			);
		} else {
			return array(
				'success' => false,
				'message' => 'Something went wrong!'
			);
		}
	} else {
		return array(
			'success' => false,
			'message' => $response['error']
		);
	}
}
function refresh_posts($user_id, $page_id, $time_slots, $rss_table, $id_column, $status_column, $feed_id)
{
	$count_slots = count($time_slots);
	$timeslots = implode(",", $time_slots);
	$CI = &get_instance();
	$CI->load->database();
	// update timeslots
	if ($rss_table == 'pinterest_scheduler') {
		refresh_pinterest_timeslots($page_id, $time_slots, $user_id);
	} else if ($rss_table == 'rsssceduler') {
		if ($count_slots > 0) {
			$CI->db->select('*')->from($rss_table)->where($id_column, $page_id);
			$schedule_posts = $CI->db->get()->result();
			$for_update = array('get_first_slot' => true, 'get_next_slot' => '');
			foreach ($schedule_posts as $posts) {
				$primary_id = $posts->id;
				$userID = $posts->user_id;
				$post_date_time = getNextPostTime($rss_table, $userID, $page_id, $timeslots, $for_update);
				$for_update['get_first_slot'] = false;
				$for_update['get_next_slot'] = $post_date_time;
				$CI->Publisher_model->update_rssschedule($primary_id, $post_date_time);
			}
		}
	} else if ($rss_table == 'channels_scheduler') {
		$where['user_id'] = $user_id;
		$where[$status_column] = 0;
		if ($page_id != 'all') {
			$where['channel_id'] = $page_id;
		}
		$schedule_posts = $CI->Publisher_model->get_allrecords($rss_table, $where);
		$for_update = array('get_first_slot' => true, 'get_next_slot' => '');
		foreach ($schedule_posts as $post) {
			// $type = $post->type;
			// if($type == 'facebook'){
			// 	$page = $CI->Publisher_model->retrieve_record('facebook_pages', $post->channel_id);
			// } else if ($type == 'pinterest') {
			// 	$page = $CI->Publisher_model->retrieve_record('pinterest_boards', $post->channel);
			// } else if ($type == 'instagram') {
			// 	$page = $CI->Publisher_model->retrieve_record('instagram_users', $post->channel);
			// } else if ($type == 'tiktok') {
			// 	$page = $CI->Publisher_model->retrieve_record('tiktok', $post->channel);
			// } else if ($type == 'youtube') {
			// 	$page = $CI->Publisher_model->retrieve_record('youtube_channels', $post->channel);
			// }
			$post_datetime = getNextPostTime("channels_scheduler", $user_id, $post->channel_id, $timeslots, $for_update);
			$for_update['get_first_slot'] = false;
			$for_update['get_next_slot'] = $post_datetime;
			$CI->Publisher_model->UpdatescheduleOnChannel($post->id, $post_datetime);
		}
	}
	// resechedule posts with error
	if ($rss_table == 'rsssceduler') { //facebook rss feed
		$data = [
			'posted' => 0,
			'error' => '',
		];
		$CI->db->where('user_id', $user_id);
		$CI->db->where('page_id', $page_id);
		$CI->db->where('posted', '-1');
		$CI->db->update($rss_table, $data);
	} else if ($rss_table == 'pinterest_scheduler') { //pinterest rss feed
		$data = [
			'published' => 0,
			'error' => '',
		];
		$CI->db->where('user_id', $user_id);
		$CI->db->where('board_id', $page_id);
		$CI->db->where('published', '-1');
		$CI->db->update($rss_table, $data);
	} else if ($rss_table == 'channels_scheduler') {
		$data = [
			'status' => 0,
			'response' => '',
		];
		$CI->db->where('user_id', $user_id);
		if ($page_id != 'all') {
			$CI->db->where('channel_id', $page_id);
		}
		$CI->db->where('status', '-1');
		$CI->db->update($rss_table, $data);
	}

	// validate each post
	if ($rss_table != 'channels_scheduler') {
		$posts = $CI->db->select('*')->from($rss_table)->where($id_column, $page_id)->where('user_id', $user_id)->where_in($status_column, array('-1', '0'));
		$posts = $CI->db->get()->result();
		foreach ($posts as $key => $post) {
			$response = (string) $key + 1;
			$CI->db->where('id', $feed_id);
			$CI->db->update('refresh_feeds', array('response' => $response));
			$validate_post = validate_post($post);
			if ($validate_post['status']) {
				if ($validate_post['type'] == 'pinterest') {
					$image_column = 'image_link';
				} else {
					$image_column = 'link';
				}
				$CI->db->where('id', $post->id);
				$CI->db->update($rss_table, array($image_column => $validate_post['image']));
			} else {
				$CI->Publisher_model->delete_record($rss_table, $post->id);
			}
		}
	}

	return true;
}

function refresh_pinterest_timeslots($page_id, $timeslots, $user_id)
{
	$CI = &get_instance();
	$board_id = $page_id;
	$board_data['time_slots_rss'] = json_encode($timeslots);
	$CI->Publisher_model->update_record('pinterest_boards', $board_data, $board_id);

	$count_slots = count($timeslots);

	$timeslots = implode(",", $timeslots);

	if ($count_slots > 0) {
		$CI->db->select('*')->from('pinterest_scheduler')->where('board_id', $board_id)->where('published', 0);
		$schedule_posts = $CI->db->get()->result();

		$for_update = array('get_first_slot' => true, 'get_next_slot' => '');

		foreach ($schedule_posts as $posts) {

			$primary_id = $posts->id;
			$userID = $posts->user_id;
			$publish_datetime = getNextPostTime("pinterest_scheduler", $user_id, $board_id, $timeslots, $for_update);

			$for_update['get_first_slot'] = false;
			$for_update['get_next_slot'] = $publish_datetime;

			$CI->Publisher_model->update_pinterest_rssschedule($primary_id, $publish_datetime);
		}
	}
	return true;
}
function bulkupload_limit_check($user_id, $page_id)
{
	$CI = &get_instance();
	$CI->load->database();
	$fb_page = $CI->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id));
	$response = [
		'status' => false,
		'message' => 'Something went wrong!'
	];
	if (!empty($fb_page)) {
		$now = date('Y-m-d H:i:s');
		$fb_page = $fb_page[0];
		$published_posts = (int) $fb_page->published_posts;
		$last_post_time = $fb_page->last_post;
		if (!empty($last_post_time)) {
			$diff_in_minutes = strtotime($now) - strtotime($last_post_time);
			$diff_in_minutes = $diff_in_minutes / 60;
			if ((int) $diff_in_minutes >= 15) {
				$data = [
					'published_posts' => 1,
					'last_post' => $now
				];
				$CI->db->where('user_id', $user_id);
				$CI->db->where('page_id', $page_id);
				$CI->db->update('facebook_pages', $data);
				$response = [
					'status' => true
				];
			} else {
				if ($published_posts >= 3) {
					$mins = 15 - (int) $diff_in_minutes;
					$response = [
						'status' => false,
						'message' => 'Bulkupload limit of 3 posts for page ' . $fb_page->page_name . ' has reached. You can bulkupload again after ' . $mins . ' mins!'
					];
				} else {
					$data = [
						'published_posts' => $published_posts + 1,
						'last_post' => $now
					];
					$CI->db->where('user_id', $user_id);
					$CI->db->where('page_id', $page_id);
					$CI->db->update('facebook_pages', $data);
					$response = [
						'status' => true
					];
				}
			}
		} else {
			$response = [
				'status' => true
			];
		}
	}
	return $response;
}

function bulkupload_limit_update($user_id, $page_id, $type = 'up')
{
	$CI = &get_instance();
	$CI->load->database();
	$fb_page = $CI->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id, 'page_id' => $page_id));
	$response = [
		'status' => false,
		'message' => 'Something went wrong!'
	];
	if (!empty($fb_page)) {
		$fb_page = $fb_page[0];
		$published_posts = empty($fb_page->published_posts) ? 0 : $fb_page->published_posts;
		if ($type == 'up') {
			$data = array(
				'published_posts' => $published_posts + 1,
				'last_post' => date('Y-m-d H:i:s')
			);
		} else {
			$data = array(
				'published_posts' => $published_posts - 1,
			);
		}
		$CI->db->where('user_id', $user_id);
		$CI->db->where('page_id', $page_id);
		$CI->db->update('facebook_pages', $data);
		$response = [
			'status' => true
		];
	}
	return $response;
}

function validate_post($post)
{
	$CI = &get_instance();
	$response = [];
	$post_url = $post->url;
	$type = isset($post->board_id) ? 'pinterest' : 'other';
	$CI->load->library('getMetaInfo');
	$info = isImage($post_url) ? $post_url : $CI->getmetainfo->get_info($post_url, $type);
	if (empty($info['image'])) {
		$response = [
			'status' => false,
		];
	} else {
		$response = [
			'status' => true,
			'type' => $type,
			'image' => $info['image'],
		];
	}
	return $response;
}

function fb_page_publish_now($post, $page, $user_id)
{
	$CI = &get_instance();
	$CI->load->library('facebook');
	$user_id = $post->user_id;
	$postData = [];
	$postData["message"] = $post->post_title;
	$postData["link"] = $post->url;
	$posting = $CI->facebook->request('POST', "/" . $page->page_id . "/feed", $postData, (string) $page->access_token);
	if (isset($posting['error'])) {
		$post_data_this['posted'] = -1;
		$post_data_this['error'] = $posting['message'];
		$CI->Publisher_model->update_record('rsssceduler', $post_data_this, $post->id);
		$response = array(
			'status' => false,
			'error' => $posting['message']
		);
	} else {
		$post_data_this['posted'] = 1;
		$CI->Publisher_model->update_record('rsssceduler', $post_data_this, $post->id);
		$response = array(
			'status' => true,
			'message' => 'Your post has been Published Successfully!'
		);
	}
	return $response;
}

function isImage($url)
{
	// Initialize a new cURL session
	$ch = curl_init($url);

	// Set options to only retrieve the HTTP headers
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	// Execute the request
	curl_exec($ch);

	// Get the HTTP status code
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	// Check if the request was successful (HTTP status code 200) and if the content-type is an image
	if ($httpCode == 200 && strstr(curl_getinfo($ch, CURLINFO_CONTENT_TYPE), 'image/')) {
		if (strpos($url, "bulkuploads")) {
			return true;
		} else {
			$imageInfo = getimagesize($url);
		}
		if ($imageInfo !== false) {
			return true; // The URL is an image
		}
	}

	// Close the cURL session
	curl_close($ch);

	return false; // The URL is not an image
}
function fetchImage($url, $type)
{
	$data = array();
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_USERAGENT => user_agent(),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$pinterest_active = false;
	if ($type == 'pinterest') {
		$pinterest_active = true;
	}

	if ($err) {
		// echo "cURL Error #:" . $err;
		return ['title' => "cURL Error #:" . $err, 'image' => ''];
	} else {
		// variable to save image url
		$meta_image = '';
		$dom = new DOMDocument();
		@$dom->loadHTML($response);
		$tags = $dom->getElementsByTagName('img');
		// fetch images  if pinterest channel is active 
		if ($pinterest_active) {
			$pinterest_image = fetch_pinterest_image($tags);
			if ($pinterest_image != '' && $pinterest_image != null) {
				$meta_image = $pinterest_image;
			}
		}
		if (empty($meta_image)) {
			if ($meta_image == "") {
				$json_ld = get_string_between($response, '<script type="application/ld+json" class="yoast-schema-graph">', "</script>");
				if ($json_ld) {
					$data = json_decode($json_ld, true);
					if ($data) {
						if (isset($data['@graph'])) {
							if (isset($data['@graph'][0]['thumbnailUrl'])) {
								$meta_image = $data['@graph'][0]['thumbnailUrl'];
							}
						}
					}
				}
			}
			if (empty($meta_image) && $meta_image == "") {
				$ogimage = "";
				$ogimagesecure = "";
				$meta_image = "";
				$metaTags = $dom->getElementsByTagName('meta');
				foreach ($metaTags as $meta) {
					if ($meta->getAttribute('property') == 'og:image') {
						$ogimage = $meta->getAttribute('content');
					}
					if ($meta->getAttribute('property') == 'og:image:secure_url') {
						$ogimagesecure = $meta->getAttribute('content');
					}
					if (empty($ogimage) && $meta->getAttribute('name') == 'twitter:image') {
						$ogimage = $meta->getAttribute('content');
					}
				}

				if ($ogimage && $ogimagesecure && $ogimage == $ogimagesecure) {
					$meta_image = $ogimage;
				} elseif ($ogimagesecure) {
					$meta_image = $ogimagesecure;
				} else {
					$meta_image = $ogimage;
				}
			}
			if (empty($meta_image)) {
				$thumbnails = $dom->getElementsByTagName('div');
				foreach ($thumbnails as $thumbnail) {
					if (check_for($thumbnail->getAttribute('class'), 'thumbnail')) {
						$image = $thumbnail->getElementsByTagName('img')->item(0);
						$src = $image->getAttribute('src');
						$meta_image = $src;
					}
				}
			}
		}
		return $meta_image;
	}
}

function get_string_between($string, $start, $end)
{
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0)
		return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

function get_aspect_ratio($image)
{
	$pin_image = false;
	if ($image != '' && $image != null) {
		$height = $image->getAttribute('height');
		$width = $image->getAttribute('width');
		if ($height == "" || $height == null || $width == "" || $width == null) {
			$dimensions = getimagesize($image->getAttribute('src'));
			$width = round($dimensions[0]);
			$height = round($dimensions[1]);
		}
		$heightArray = array("1128", "900", "1000", "1024");
		$widthArray = array("564", "700", "1500", "512", "513");
		if (in_array($height, $heightArray) && in_array($width, $widthArray)) {
			$pin_image = true;
		}
	}
	return $pin_image;
}
function fetch_pinterest_image($tags)
{
	// $pinterest_aspect_ratio = $CI->CI->config->item('pinterest_aspect_ratio');
	$meta_image = '';
	$pin_image = false;
	foreach ($tags as $tag) {
		if (get_aspect_ratio($tag)) {
			$image = $tag->getAttribute('src');
			if ($tag->hasAttribute('data-lazy-src')) {
				$image = $tag->getAttribute("data-lazy-src");
			}
			$pin_image = true;
			$pinterest_image = $image;
			break;
		}
	}
	if ($pin_image && $pinterest_image != '' && $pinterest_image != null) {
		$meta_image = $pinterest_image;
	}

	return $meta_image;
}

function get_fb_page_profile_pic($user_id, $page_id, $access_token)
{
	$CI = &get_instance();
	$CI->load->library('facebook');
	$post_image = $CI->facebook->request('get', '/' . $page_id . '/picture?redirect=0&', $access_token);
	$post_profile_pic = isset($post_image['data']['url']) ? saveImageFromUrl($post_image['data']['url'], $user_id, $page_id) : "";
	return $post_profile_pic;
}

function format_fb_page_recent_posts($posts, $user)
{
	$CI = &get_instance();
	if (count($posts) > 0) {
		$post_array = [];
		foreach ($posts as $key => $post) {
			$facebook_pages = $CI->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $post->user_id, 'page_id' => $post->page_id));
			if (count($facebook_pages) > 0) {
				$facebook_page = $facebook_pages[0];
			}
			$page_name = isset($facebook_page->page_name) ? $facebook_page->page_name : '';
			$post->post_image = !empty($post->post_image) ? $post->post_image : $post->profile_pic;
			$post_array[$key]['post'] = post_div($facebook_page, $post->post_title, $post->published_at, $post->post_image, $post->id, $user, 'facebook');
			// type
			$post_array[$key]['type'] = $post->type;
			// reach
			$post_array[$key]['reach'] = !empty($post->reach) ? $post->reach : 0;
			// reach rate
			$reach_rate = $post->impressions > 0 ? number_format(($post->reach / $post->impressions) * 100, 1) : '0';
			$reach_rate = fmod($reach_rate, 1) == 0 ? (int) $reach_rate : $reach_rate;
			$reach_rate = $reach_rate > 0 ? $reach_rate . ' %' . increasing_chart() : $reach_rate . ' %';
			$post_array[$key]['reach_rate'] = '<span class="d-flex">' . $reach_rate . '</span>';
			$post_array[$key]['eng_rate'] = $post->eng_rate > 0 ? '<span class="d-flex">' . $post->eng_rate . '%' . increasing_chart() . '</span>' : '0%';
			$post_array[$key]['reactions'] = !empty($post->reactions) ? $post->reactions : 0;
			$post_array[$key]['comments'] = number_format($post->comments);
			$post_array[$key]['shares'] = number_format($post->shares);
			$post_array[$key]['video_views'] = number_format($post->video_views);
			$post_array[$key]['link_clicks'] = $post->type == 'Link' ? number_format($post->link_clicks) : '--';
			$post_array[$key]['ctr'] = $post->ctr > 0 ? '<span class="d-flex">' . $post->ctr . '%' . increasing_chart() . '</span>' : '0%';
			$post_array[$key]['published'] = date('M d, Y', strtotime($post->published_at));
			$post_array[$key]['action'] = recent_post_action_div();
		}
		$response = [
			'status' => true,
			'message' => 'Posts fetched Successfully!',
			'post_array' => $post_array,
		];
	} else {
		$response = [
			'status' => false,
			'message' => 'Syncing is in Progress!',
			'post_array' => []
		];
	}
	return $response;
}
function format_tiktok_recent_posts($posts, $user)
{
	$CI = &get_instance();
	if (count($posts) > 0) {
		$post_array = [];
		foreach ($posts as $key => $post) {
			$tiktoks = $CI->Publisher_model->get_allrecords('tiktok', array('user_id' => $post->user_id, 'id' => $post->tiktok_id));
			if (count($tiktoks) > 0) {
				$tiktok = $tiktoks[0];
			}
			$post_array[$key]['post'] = post_div($tiktok, $post->post_title, $post->published_at, $post->cover_image, $post->id, $user, 'tiktok');
			// type
			$post_array[$key]['type'] = 'Video';
			// reach
			$post_array[$key]['reach'] = '0';
			// reach rate
			$reach_rate = '0%';
			$post_array[$key]['reach_rate'] = '<span class="d-flex">' . $reach_rate . '</span>';
			$post_array[$key]['eng_rate'] = '0%';
			$post_array[$key]['reactions'] = number_format($post->like_count);
			$post_array[$key]['comments'] = number_format($post->comment_count);
			$post_array[$key]['shares'] = number_format($post->share_count);
			$post_array[$key]['video_views'] = number_format($post->view_count);
			$post_array[$key]['link_clicks'] = '-';
			$post_array[$key]['ctr'] = '0%';
			$post_array[$key]['published'] = date('M d, Y', strtotime($post->published_at));
			$post_array[$key]['action'] = recent_post_action_div();
		}
		$response = [
			'status' => true,
			'message' => 'Posts fetched Successfully!',
			'post_array' => $post_array,
		];
	} else {
		$response = [
			'status' => false,
			'message' => 'Syncing is in Progress!',
			'post_array' => []
		];
	}
	return $response;
}
function check_fb_page_insight_status($facebook_pages)
{
	$CI = &get_instance();
	$refresh = true;
	$userID = App::Session()->get('userid');
	foreach ($facebook_pages as $value) {
		$data = array(
			'user_id' => $userID,
			'pageid' => $value->page_id,
			'type' => 'facebook',
			'published' => 0,
			'created_at' => date("Y-m-d H:i:s")
		);
		// check for facebook pages cronjob
		$where = array('user_id' => $userID, 'pageid' => $value->page_id, 'type' => 'facebook');
		$check = $CI->Publisher_model->get_allrecords('analytics_cronjob', $where);
		if (count($check) == 0) {
			$refresh = false;
			$CI->db->insert('analytics_cronjob', $data);
		} else {
			foreach ($check as $val) {
				if ($val->published == 0) {
					$refresh = false;
				}
			}
		}
		// check for faceboko posts cronjob
		if (!$refresh) {
			$where_post = array('user_id' => $userID, 'page_id' => $value->page_id, 'published' => '0');
			$posts = $CI->Publisher_model->get_allrecords('facebook_posts_cronjob', $where_post);
			if (count($posts) > 0) {
				$refresh = false;
			}
		}
	}
	if ($refresh) {
		$button_message = 'Sync Insights';
		$refresh = true;
	} else {
		$button_message = 'Syncing in Progress ...';
		$refresh = false;
	}
	$response = [
		'button_message' => $button_message,
		'refresh' => $refresh,
	];
	return $response;
}

function cleanString($string)
{
	$cleaned_string = trim($string, '-');
	$cleaned_string = str_replace('%0D%0A', '', $cleaned_string);
	// $cleaned_string = trim($cleaned_string);
	return $cleaned_string;
}

function check_analytics($accounts)
{
	$CI = &get_instance();
	$user = get_auth_user();
	// facebook
	foreach ($accounts['facebook_pages'] as $page) {
		$data = array(
			'user_id' => $user->id,
			'pageid' => $page->page_id,
			'type' => 'facebook',
			'published' => 0,
			'created_at' => date("Y-m-d H:i:s")
		);
		// check for facebook pages cronjob
		$check = $CI->Publisher_model->get_allrecords('analytics_cronjob', array('user_id' => $user->id, 'pageid' => $page->page_id));
		if (count($check) == 0) {
			$CI->Publisher_model->create_record('analytics_cronjob', $data);
			run_php_background("https://www.adublisher.com/updateFacebookPostsAndAnalytics");
		}
	}
	// tiktok
	foreach ($accounts['tiktoks'] as $tiktok) {
		$data = array(
			'user_id' => $user->id,
			'pageid' => $tiktok->id,
			'type' => 'tiktok',
			'published' => 0,
			'created_at' => date("Y-m-d H:i:s")
		);
		// check for facebook pages cronjob
		$check = $CI->Publisher_model->get_allrecords('analytics_cronjob', array('user_id' => $user->id, 'pageid' => $tiktok->id));
		if (count($check) == 0) {
			$CI->Publisher_model->create_record('analytics_cronjob', $data);
			run_php_background("https://www.adublisher.com/tiktokAnalytics");
		}
	}
}

function convertImageToJpeg($sourceImagePath, $destinationJpegPath, $quality = 80)
{
	$source_image = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $sourceImagePath;
	$destinationJpegPath = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $destinationJpegPath;
	if (!file_exists($source_image)) {
		return false; // Source image does not exist
	}
	// Get the image type
	$imageType = exif_imagetype($sourceImagePath);
	// Create image resource based on the image type
	switch ($imageType) {
		case IMAGETYPE_JPEG:
			$sourceImage = imagecreatefromjpeg($sourceImagePath);
			break;
		case IMAGETYPE_PNG:
			$sourceImage = imagecreatefrompng($sourceImagePath);
			break;
		case IMAGETYPE_GIF:
			$sourceImage = imagecreatefromgif($sourceImagePath);
			break;
		case IMAGETYPE_WEBP:
			$sourceImage = imagecreatefromwebp($sourceImagePath);
			break;
		// Add more image types as needed
		default:
			return false; // Unsupported image type
	}
	// Check if image resource was created successfully
	if (!$sourceImage) {
		return false; // Failed to create image resource
	}
	// Create the JPEG image
	$make_new = imagejpeg($sourceImage, $destinationJpegPath, $quality);
	print_pre($make_new);

	return true; // Conversion successful
}

function infinity_preloader()
{
	$preloader = '<svg class="ip" viewBox="0 0 256 128" width="256px" height="128px" xmlns="http://www.w3.org/2000/svg">
		<defs>
			<linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0">
				<stop offset="0%" stop-color="#5ebd3e" />
				<stop offset="33%" stop-color="#ffb900" />
				<stop offset="67%" stop-color="#f78200" />
				<stop offset="100%" stop-color="#e23838" />
			</linearGradient>
			<linearGradient id="grad2" x1="1" y1="0" x2="0" y2="0">
				<stop offset="0%" stop-color="#e23838" />
				<stop offset="33%" stop-color="#973999" />
				<stop offset="67%" stop-color="#009cdf" />
				<stop offset="100%" stop-color="#5ebd3e" />
			</linearGradient>
		</defs>
		<g fill="none" stroke-linecap="round" stroke-width="16">
			<g class="ip__track" stroke="#ddd">
				<path d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56"/>
				<path d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64"/>
			</g>
			<g stroke-dasharray="180 656">
				<path class="ip__worm1" stroke="url(#grad1)" stroke-dashoffset="0" d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56"/>
				<path class="ip__worm2" stroke="url(#grad2)" stroke-dashoffset="358" d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64"/>
			</g>
		</g>
	</svg>';
	return $preloader;
}
function publish_ig_single_media($instagram_id, $access_token, $img_url, $caption, $user_id = null)
{
	$CI = &get_instance();
	$container = $CI->Publisher_model->create_ig_media_container($instagram_id, $access_token, $img_url, $caption);
	print_pre($container);
	if (isset($container['id'])) {
		// Step 2 of 2: Publish Container
		$result = $CI->Publisher_model->publish_ig_media_container($user_id, $container['id']);
		print_pre($result);
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

function publish_reels_to_instagram($instagram_id, $access_token, $video_path, $caption, $user_id = null)
{
	$CI = &get_instance();
	print_pre($video_path);
	$container = $CI->Publisher_model->create_ig_media_container($instagram_id, $access_token, $video_path, $caption, "video_url");
	print_pre($container);
	if (isset($container['id'])) {
		$container_publish = false;
		while (!$container_publish) {
			$container_status = $CI->Publisher_model->get_ig_media_container_status($user_id,  $container["id"]);
			if (isset($container_status["status_code"])) {
				if ($container_status["status_code"] == "EXPIRED" || $container_status["status_code"] == "ERROR") {
					break;
				}
				if ($container_status["status_code"] == "FINISHED" || $container_status["status_code"] == "PUBLISHED") {
					$container_status = true;
					break;
				}
				sleep(5);
			} else {
				break;
			}
		}
		// Step 2 of 2: Publish Container
		// for resumeable large files
		$result = $CI->Publisher_model->upload_ig_video($user_id, $container['id'], $video_path);
		if ($container_publish) {
			$result = $CI->Publisher_model->publish_ig_media_container($user_id, $container['id']);
		} else {
			return array(
				'status' => false,
				'data' => $container_status,
				'message' => 'Some Problem occured, while publishing ig - post',
			);
		}
		print_pre($result);
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

function notify_via_email($postData, $page, $type, $error_message)
{
	$CI = &get_instance();
	$user = $CI->Publisher_model->retrieve_record('user', $page->user_id);
	$setting = $CI->Publisher_model->get_allrecords('settings');
	$setting = $setting[0];
	$array = array(
		'email' => $user->email,
		'username' => $user->username,
		'body' => post_publishing_email($user, $postData, $page, $type, $error_message, $setting),
		'company_name' => $setting->company,
		'site_email' => $setting->site_email,
		'subject' => 'Post publishing failed!',
		'type' => 'post_publishing_fail',
		'status' => 0,
	);
	$CI->Publisher_model->create_record('email_cron', $array);
	run_php_background('https://www.adublisher.com/emailSending');
	return true;
}

function make_image_url($image)
{
	$newPath = str_replace("/var/www/html/Adublisher/", SITEURL, $image);
	return $newPath;
}

function post_publishing_email($user, $post, $page, $type, $error_message, $setting)
{
	$CI = &get_instance();
	$site_logo = AccountUpload . $setting->logo;
	$alt_image = GeneralAssets . 'images/no_image_found.jpg';
	$account_page_name = '';
	$post_image = $post['image'];
	$publish_date = utcToLocal(gmdate('Y-m-d H:i:s'), $user->gmt, 'l, M jS Y, h:i A');
	$type = strtolower($type);
	if ($type == 'facebook') {
		$href_link = "www.facebook.com/" . $page->page_id;
		$page_name = $page->page_name;
		$account_page_name = $user->facebook_name . ' - ' . $page_name;
		$image_url = !empty($page->profile_pic) ? BulkAssets . $page->profile_pic : GeneralAssets . '/images/facebook_logo.png';
		$post_image = $post['image'];
	} else if ($type == 'pinterest') {
		$pinterest_user = $CI->Publisher_model->get_allrecords('pinterest_users', ['user_id' => $page->user_id]);
		$pinterest_user = $pinterest_user[0];
		$href_link = "www.pinterest.com/" . $pinterest_user->username . '/' . $page->name;
		$page_name = $pinterest_user->username;
		$account_page_name = $page_name . ' - ' . $page->name;
		$image_url = !empty($page->profile_pic) ? BulkAssets . $page->profile_pic : GeneralAssets . '/images/pinterest_logo.png';
		$post_image = make_image_url($post['image']);
	} else if ($type == 'tiktok') {
		$page_name = $page->username;
		$href_link = "www.tiktok.com/" . $page_name;
		$image_url = !empty($page->profile_pic) ? BulkAssets . $page->profile_pic : GeneralAssets . '/images/tiktok_logo.png';
		$logo = GeneralAssets . '/images/tiktok_logo.png';
		$error_message = str_replace('_', ' ', $error_message);
	} else if ($type == 'instagram') {
		$href_link = "#";
		$page_name = $page->instagram_username;
		$account_page_name = $page->fb_page_name . ' - ' . $page_name;
		$image_url = !empty($user->facebook_dp) ? BulkAssets . $user->facebook_dp : GeneralAssets . '/images/facebook_logo.png';
		$post_image = !empty($post['image']) ? BulkAssets . $post['image'] : '';
	}
	$post_image = isImage($post_image) ? $post_image : $alt_image;

	$div = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#F0F0F0" style="font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 17px; line-height: 28px; font-weight: 400; letter-spacing: 0.444px;">
				<tbody>
					<tr>
						<td style="background-color: #ffffff;" align="center" valign="top" bgcolor="#ffffff">
							<table style="width: 100%px; max-width: 800px;" border="0" width="100%" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td height="30"></td>
									</tr>
									<tr>
										<td align="center"><img src="' . $site_logo . '"
												alt="Adublisher" style="border:0;width:128px" /></td>
									</tr>
									<tr>
										<td height="20"></td>
									</tr>
									<tr>
										<td>
											<p
												style="text-align: center; margin: 0; font-family: Helvetica, Arial, sans-serif; font-size: 26px; color: #222222;">
												Hello ' . $user->email . '</p>
										</td>
									</tr>
									<tr>
										<td align="center"><img src="' . AccountAssets . 'images/line.png"
												alt="line" width="251" height="43"></td>
									</tr>
									<tr>
										<td height="30"> </td>
									</tr>
									<tr>
										<td class="container-padding content"
											style="background-color: #ffffff; padding: 12px 24px 12px 24px;" align="left">
											<p>
											We are sorry for the inconvenience, but your <b>' . $type . '</b> post for <a href="' . $href_link . '" style="color: #0066ff;">@' . $page_name . '</a>  published for <b>' . $publish_date . '</b> failed and was not published due to:
											</p>
											<div class="warning__box" style="background-color: #fde0e0;padding: 10px;margin: 1.22rem 0;border: 1.4px solid #ff0000;border-radius: 6px; color: #000; font-size: 15px; line-height: 28px; font-weight: 500;">
												<p style="margin: 0;">
												' . strtoupper($error_message) . '
												</p>
											</div>
											<p>
												Long, messy URLs can clutter social media posts and make tracking performance a nightmare. With attention spans shrinking and platforms prioritizing clean aesthetics, every character counts. But manually shortening
											</p>
										</td>
									</tr>
									<tr>
										<td align="center" style="background-color:#0005; border-radius:10px;">
											<div style="width:50%;">
												<span style="margin-top:10px;">';
	if (isset($logo)) {
		$div .= '
													<img src="' . $logo . '" style="border-radius: 50%;" width="25px">';
	} else {
		$div .= '<b>' . $account_page_name . '</b>';
	}
	$div .= '
													<img src="' . $image_url . '" style="border-radius: 50%;" width="25px">
												</span>
											</div>
											<div style="width:50%;  margin-top:10px;">
												<span style="text-align:center;">' . cleanString(urldecode($post['title'])) . '</span>
												<img style="border-radius:10px; width:100%;" src="' . $post_image . '" alt="ALT IMAGE">
											</div>
										</td>
									</tr>
									<tr>
										<td height="50"></td>
									</tr>
									<tr>
										<td style="border-bottom: 1px solid #DDDDDD;"> </td>
									</tr>
									<tr>
										<td height="25"></td>
									</tr>
									<tr>
										<td style="text-align: center;" align="center">
											<table border="0" width="95%" cellspacing="0" cellpadding="0" align="center">
												<tbody>
													<tr>
														<td style="font-family: Helvetica, Arial, sans-serif;" align="left"
															valign="top">
															<p style="text-align: left; color: #585858; font-size: 16px; font-weight: 500; line-height: 28px;">
																This email is sent to you directly from
																<a href="' . SITEURL . '">Adublisher</a>
																The information above is gathered from the user input. 
																<br><br>
																@' . date('Y') . '
																<a href="' . SITEURL . '" style="color: #0059ff;">@Adublisher</a>. 
																All rights reserved.
															</p>
														</td>
														<td width="30"> </td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';
	print_pre($div);
	return $div;
}

function debug($user_id)
{
	$users = [
		"2210"
	];
	if (in_array($user_id, $users)) {
		return true;
	}
	return false;
}

function user_agent()
{
	$agent[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:53.0) Gecko/20100101 Firefox/53.0";
	$agent[] = "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0; Trident/5.0)";
	$agent[] = "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0; MDDCJS)";
	$agent[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.79 Safari/537.36 Edge/14.14393";
	$agent[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
	$agent[] = "Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3";
	$agent[] = "Mozilla/5.0 (iPhone14,6; U; CPU iPhone OS 15_4 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/19E241 Safari/602.1";
	$agent[] = "Mozilla/5.0 (iPhone14,3; U; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/19A346 Safari/602.1";
	$agent[] = "Mozilla/5.0 (iPhone13,2; U; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/15E148 Safari/602.1";
	$agent[] = "Mozilla/5.0 (iPhone12,1; U; CPU iPhone OS 13_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/15E148 Safari/602.1";
	$agent[] = "Mozilla/5.0 (iPhone12,1; U; CPU iPhone OS 13_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/15E148 Safari/602.1";
	$agent[] = "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Mobile/15E148 Safari/604.1";
	$agent[] = "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/69.0.3497.105 Mobile/15E148 Safari/605.1";
	$agent[] = "Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/13.2b11866 Mobile/16A366 Safari/605.1.15";
	$agent[] = "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1";
	$agent[] = "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1";
	$agent[] = "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A5370a Safari/604.1";
	$agent[] = "Mozilla/5.0 (iPhone9,3; U; CPU iPhone OS 10_0_1 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/14A403 Safari/602.1";
	$agent[] = "Mozilla/5.0 (iPhone9,4; U; CPU iPhone OS 10_0_1 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/14A403 Safari/602.1";
	$agent[] = "Mozilla/5.0 (Apple-iPhone7C2/1202.466; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543 Safari/419.3";
	$agent[] = "Mozilla/5.0 (Windows Phone 10.0; Android 6.0.1; Microsoft; RM-1152) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Mobile Safari/537.36 Edge/15.15254";
	$agent[] = "Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; RM-1127_16056) AppleWebKit/537.36(KHTML, like Gecko) Chrome/42.0.2311.135 Mobile Safari/537.36 Edge/12.10536";
	$agent[] = "Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/13.1058";
	$agent[] = "Mozilla/5.0 (Linux; Android 12; SM-X906C Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/80.0.3987.119 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 11; Lenovo YT-J706X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 7.0; Pixel C Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0.1; SGP771 Build/32.2.A.0.253; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/52.0.2743.98 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0.1; SHIELD Tablet K1 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 7.0; SM-T827R4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.116 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 5.0.2; SAMSUNG SM-T550 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/3.3 Chrome/38.0.2125.102 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 4.4.3; KFTHWI Build/KTU84M) AppleWebKit/537.36 (KHTML, like Gecko) Silk/47.1.79 like Chrome/47.0.2526.80 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 5.0.2; LG-V410/V41020c Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/34.0.1847.118 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246";
	$agent[] = "Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36";
	$agent[] = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/601.3.9 (KHTML, like Gecko) Version/9.0.2 Safari/601.3.9";
	$agent[] = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36";
	$agent[] = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1";
	$agent[] = "Mozilla/5.0 (Linux; Android 12; SM-S906N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/80.0.3987.119 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 10; SM-G996U Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 10; SM-G980F Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.96 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 9; SM-G973U Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 8.0.0; SM-G960F Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.84 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/60.0.3112.107 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 7.0; SM-G930VC Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/58.0.3029.83 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0.1; SM-G935S Build/MMB29K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0.1; SM-G920V Build/MMB29K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 5.1.1; SM-G928X Build/LMY47X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.83 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 12; Pixel 6 Build/SD1A.210817.023; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/94.0.4606.71 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 11; Pixel 5 Build/RQ3A.210805.001.A1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.159 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 10; Google Pixel 4 Build/QD1A.190821.014.C2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 10; Google Pixel 4 Build/QD1A.190821.014.C2; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 Build/OPD1.170811.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/59.0.3071.125 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 7.1.1; Google Pixel Build/NMF26F; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/54.0.2840.85 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0.1; Nexus 6P Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.83 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 9; J8110 Build/55.0.A.0.552; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/71.0.3578.99 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 7.1.1; G8231 Build/41.2.A.0.219; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/59.0.3071.125 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0.1; E6653 Build/32.2.A.0.253) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 10; HTC Desire 21 pro 5G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.127 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 10; Wildfire U20 5G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.136 Mobile Safari/537.36";
	$agent[] = "Mozilla/5.0 (Linux; Android 6.0; HTC One X10 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/61.0.3163.98 Mobile Safari/537.36";
	return $agent[RAND(0, 60)];
}
function pin_board_publish_now($post, $board, $pinterest_user)
{
	$CI = &get_instance();
	$pinterest_user = $pinterest_user[0];
	// check for access token validity
	$access_token = check_pinterest_access_token($pinterest_user);
	if (strlen($post->post_title) > 101) {
		$post_title = $post->post_title;
		$title = !empty($post_title) ? substr($post_title, 0, 100) : $post_title;
	} else {
		$title = $post->post_title;
	}
	$image_link = isImage($post->image_link) ? $post->image_link : fetchImage($post->url, 'pinterest');
	$data = [
		'title' => $title,
		'description' => $title,
		'link' => $post->url,
		'board_id' => $board->board_id,
		'image' => $image_link,
		'content_type' => 'image_url',
		'access_token' => $access_token
	];
	$result = $CI->Publisher_model->publish_pin_curl($data);
	$result = json_decode($result, true);
	if ($result) {
		$post_data_this['error'] = '';
		$post_data_this['published'] = 0;
		foreach ($result as $key => $value) {
			if ($key == "id") {
				$post_data_this['error'] = $value;
				$post_data_this['published'] = 1;
				$post_data_this["post_id"] = $value;
			}
		}
		if (isset($result['code']) && $result['message']) {
			$post_data_this['error'] = "Error code = " . $result['code'] . " and message = " . $result['message'];
			$post_data_this['published'] = -1;
		}
		$CI->Publisher_model->update_record('pinterest_scheduler', $post_data_this, $post->id);
		$response = array(
			'status' => true,
			'message' => 'Your post has been Published Successfully!'
		);
	} else {
		$post_data_this['error'] = "Internal Error found, no other information available";
		$post_data_this['published'] = -1;
		$CI->Publisher_model->update_record('pinterest_scheduler', $post_data_this, $post->id);
		$response = array(
			'status' => false,
			'error' => $post_data_this['error']
		);
	}
	return $response;
}

function ig_media_publish_now($post_data, $ig_user)
{
	$CI = &get_instance();
	$container = $CI->Publisher_model->create_ig_media_container($ig_user->instagram_id, $ig_user->access_token, $post_data->image_link, $post_data->post_title);
	print_pre($container);
	if (isset($container['id'])) {
		$result = $CI->Publisher_model->publish_ig_media_container($post_data->user_id, $container['id']);
		print_pre($result);
		if (isset($result['id'])) {
			$response =  array(
				'status' => true,
				'data' => $result,
				'message' => 'ig - post published Successfully',
			);
		} else {
			$response =  array(
				'status' => false,
				'data' => $result,
				'message' => $result["error"]["message"]
			);
		}
	} else {
		$response =  array(
			'status' => false,
			'data' => $container,
			'message' => $container["error"]["message"]
		);
	}
	if (!$response["status"]) {
		$CI->Publisher_model->update_record("instagram_scheduler", ["error" => $response["message"]], $post_data->id);
	}
	return $response;
}

function fb_page_queue_publish_now($post, $page)
{
	$CI = &get_instance();
	$CI->load->library('facebook');
	$user_id = $post->user_id;
	$postData = [];
	$user_id = $post->user_id;
	$comment = $post->post_comment;
	$access_token = (string) $page->access_token;
	$quote = empty($post->link) && empty($post->site_us_pc) && empty($post->video_path) ? true : false;
	if ($quote) { //for quote
		$postData["message"] = $post->post_title;
		$result = $CI->facebook->request('POST', "/" . $page->page_id . "/feed", $postData, $access_token);
		if (isset($result['id'])) {
			$postId = $result['id'];
			if (!empty($comment)) {
				if (!empty($postId)) {
					$CI->Publisher_model->publish_comments($postId, $comment, $access_token);
				}
			}
			$response = array(
				'status' => true,
				'message' => 'Your post has been Published Successfully!',
				'post_id' => $result['id']
			);
		} else {
			$response = array(
				'status' => false,
				'error' => $result['message']
			);
		}
	} else if (strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false) { //for link
		$postData["message"] = $post->post_title;
		if (!empty($post->site_us_pc)) {
			$postData["link"] = $post->site_us_pc;
		}
		$result = $CI->facebook->request('POST', "/" . $page->page_id . "/feed", $postData, $access_token);
		if (isset($result['id'])) {
			$postId = $result['id'];
			if (!empty($comment)) {
				if (!empty($postId)) {
					$CI->Publisher_model->publish_comments($postId, $comment, $access_token);
				}
			}
			$response = array(
				'status' => true,
				'message' => 'Your post has been Published Successfully!',
				'post_id' => $result['id']
			);
		} else {
			$response = array(
				'status' => false,
				'error' => $result['message']
			);
		}
	} else if (!empty($post->video_path)) { //for video
		$file_url = get_from_s3bucket($post->video_path, 1);
		if ($file_url['status']) {
			$file_name = $file_url['file_name'];
			$postData = [
				'description' => $post->post_title,
				'file_url' => $file_name
			];
			$result = $CI->facebook->request('POST', '/' . $page->page_id . '/videos', $postData, $access_token);
			// remove file from s3 bucket
			if (isset($result['id'])) {
				remove_from_s3bucket($post->video_path);
				$postId = $result['id'];
				if (!empty($comment)) {
					if (!empty($postId)) {
						$CI->Publisher_model->publish_comments($postId, $comment, $access_token);
					}
				}
				$response = array(
					'status' => true,
					'message' => 'Your post has been Published Successfully!',
					'post_id' => $result['id']
				);
			} else {
				$response = array(
					'status' => false,
					'error' => $result['message']
				);
			}
		} else {
			$response = array(
				'status' => false,
				'error' => 'Error processing Video'
			);
		}
	} else { //for image
		$image_path = BulkAssets . $post->link;
		$postData["url"] = $image_path;
		$postData['caption'] = !empty($post->post_title) ? $post->post_title : "";
		$comment = $post->post_comment;
		$result = $CI->facebook->request('POST', "/" . $page->page_id . "/photos", $postData, $access_token);
		if (isset($result['id'])) {
			$postId = $result['id'];
			if (!empty($comment)) {
				if (!empty($postId)) {
					$CI->Publisher_model->publish_comments($postId, $comment, $access_token);
				}
			}
		}
	}
	if ($result) {
		if (isset($result['id'])) {
			$response = "Published id =" . $result['id'];
			$status = 1;
		}
		if (isset($result['error'])) {
			$response = $result['message'];
			$status = -1;
		}
	} else {
		$response = "Internal Error found, no other information available";
		$status = -1;
	}
	$dataUpdate = array(
		'status' => $status,
		'response' => $response
	);
	$CI->Publisher_model->update_record('channels_scheduler', $dataUpdate, $post->id);
	if ($status == 1) {
		$response = array(
			'status' => true,
			'message' => 'Your post has been Published Successfully!',
			'post_id' => $result['id']
		);
	} else {
		resources_update('down', POST_SCHEDULING_FB_ID, $user_id);
		$response = array(
			'status' => false,
			'error' => $result['message']
		);
	}
	return $response;
}

function pin_board_queue_publish_now($post, $board, $pinterest_user)
{
	$CI = &get_instance();
	$user_id = $post->user_id;
	$title = $post->post_title;
	$title = strlen($title) > 101 ? substr($title, 0, 95) : $title;
	if (strpos($post->link, 'http://') !== false || strpos($post->link, 'https://') !== false) {
		$image_path = $post->link;
		$content_type = "image_url";
	} else {
		$image_path = BulkAssets . $post->link;
		$content_type = "image_path";
	}
	$request_url = empty($post->site_us_pc) ? '' : $post->site_us_pc;
	if (!empty($post->video_path)) { //for video
		$data = [
			'title' => $title,
			'description' => $title,
			'link' => $post->url,
			'video_path' => $post->video_path,
			'board_id' => $board->board_id,
			'access_token' => $pinterest_user[0]->access_token
		];
		$result = $CI->Publisher_model->publish_video_pin_curl($data);
		if (isset($result['id'])) {
			remove_file($post->video_path);
			remove_from_s3bucket($post->video_path);
		}
	} else { //for image, link
		$image_link = $image_path;
		// $image_link = isImage($image_path) ? $image_path : fetchImage($request_url, 'pinterest');
		$data = [
			'title' => $title,
			'description' => $title,
			'board_id' => $board->board_id,
			'link' => $request_url,
			'image' => $image_link,
			'content_type' => $content_type,
			'access_token' => $pinterest_user[0]->access_token,
		];
		$result = $CI->Publisher_model->publish_pin_curl($data);
		$result = json_decode($result, true);
	}
	$response = "";
	$status = 0;
	$post_id = '';
	if ($result) {
		foreach ($result as $key => $value) {
			if ($key == "id") {
				$post_id = $value;
				$response = $value;
				$status = 1;
			}
		}

		if (isset($result['code']) && $result['message']) {
			$response = "Error code = " . $result['code'] . " and message = " . $result['message'];
			$status = -1;
		}
	} else {
		$response = "Internal Error found, no other information available";
		$status = -1;
	}

	$dataUpdate = array(
		'status' => $status,
		'response' => $response
	);

	$CI->Publisher_model->update_record('channels_scheduler', $dataUpdate, $post->id);

	if ($status == 1) {
		$response = array(
			'status' => true,
			'message' => 'Your post has been Published Successfully!',
			'post_id' => $post_id
		);
	} else {
		resources_update('down', POST_SCHEDULING_PIN_ID, $user_id);
		$response = array(
			'status' => false,
			'error' => $result['message']
		);
	}
	return $response;
}

function ig_user_queue_publish_now($post, $ig_user, $user_id)
{
	$CI = &get_instance();
	$CI->load->library('facebook');
	// check user membership and user existence
	$user_check = user_check($user_id);
	if ($user_check['status']) {
		if (strpos($post->link, 'http') !== false) {
			$image_path = $post->link;
		} else {
			$image_path = SITEURL . "assets/bulkuploads/" . $post->link;
		}

		if ($post->post_title == "") {
			$post->post_title = " ";
		} else {
			$post->post_title = str_replace('\r\n', "\n", $post->post_title);
		}
		// Step 1 of 2: Create Container
		$postData = array(
			'image_url' => $image_path,
			'caption' => $post->post_title,
		);
		$container = $CI->facebook->request('POST', $ig_user->instagram_id . '/media', $postData, $ig_user->access_token);
		if (isset($container['id'])) {
			// Step 2 of 2: Publish Container
			$result = $CI->Publisher_model->publish_ig_media_container($post->user_id, $container['id']);
			if (isset($result['id'])) {
				$status = 1;
				$response = 'success. post id = ' . $result['id'];
			} else {
				$status = -1;
				$response = 'Error while publishing IG media container.';
			}
		} else {
			$status = -1;
			$response = 'error message = ' . $container['error']['message'] . ' error code = ' . $container['error']['code'];
		}

		$dataUpdate = array(
			'status' => $status,
			'response' => $response
		);

		$CI->Publisher_model->update_record('channels_scheduler', $dataUpdate, $post->id);

		if ($status == 1) {
			$response = [
				'status' => true,
				'message' => 'Your post has been Published Successfully!'
			];
		} else {
			$response = [
				'status' => false,
				'error' => $response
			];
		}
	} else {
		$response = [
			'status' => false,
			'error' => $user_check['message']
		];
	}
	return $response;
}

function get_all_social_accounts()
{
	$CI = &get_instance();
	$user_id = App::Session()->get('userid');
	$accounts = [];
	// facebook
	$fb_pages = $CI->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $user_id));
	foreach ($fb_pages as $fb_page) {
		array_push($accounts, $fb_page);
	}
	// pinterest
	$pinterest_boards = $CI->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $user_id));
	foreach ($pinterest_boards as $pinterest_board) {
		array_push($accounts, $pinterest_board);
	}
	// instagram
	$ig_accounts = $CI->Publisher_model->get_allrecords('instagram_users', array('user_id' => $user_id));
	foreach ($ig_accounts as $ig_account) {
		array_push($accounts, $ig_account);
	}
	// tiktok
	$tiktoks = $CI->Publisher_model->get_allrecords('tiktok', array('user_id' => $user_id));
	foreach ($tiktoks as $tiktok) {
		array_push($accounts, $tiktok);
	}
	return $accounts;
}

function start_end_date($start_date)
{
	$end_date = date('Y-m-d H:i:s');
	$divisor = '';
	if ($start_date == 'last_7_days') {
		$start_date = date('Y-m-d H:i:s', strtotime('-7 days'));
		$days = 7;
	} elseif ($start_date == 'last_14_days') {
		$start_date = date('Y-m-d H:i:s', strtotime('-14 days'));
		$days = 14;
	} elseif ($start_date == 'last_28_days') {
		$start_date = date('Y-m-d H:i:s', strtotime('-28 days'));
		$days = 28;
	} elseif ($start_date == 'last_90_days') {
		$start_date = date('Y-m-d H:i:s', strtotime('-90 days'));
		$days = 90;
	}
	return [
		'start_date' => $start_date,
		'end_date' => $end_date,
		'days' => $days
	];
}

function number_to_short($n, $precision = 1)
{
	if (empty($n)) {
		return $n;
	}
	if ($n >= 1000000000000) {
		$n = ($n / 1000000000000);
		$unit = 'T';
	} elseif ($n >= 1000000000) {
		$n = ($n / 1000000000);
		$unit = 'B';
	} elseif ($n >= 1000000) {
		$n = ($n / 1000000);
		$unit = 'M';
	} elseif ($n >= 1000) {
		$n = ($n / 1000);
		$unit = 'K';
	} else {
		return (int) $n;
	}
	return number_format($n, $precision) . $unit;
}

function generate_verify_token($length = 32)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$verify_token = '';
	for ($i = 0; $i < $length; $i++) {
		$verify_token .= $characters[rand(0, $charactersLength - 1)];
	}
	return $verify_token;
}

function get_running_rss_fetch($page_id, $type)
{
	$user = get_auth_user();
	$CI = &get_instance();
	$where = [
		'user_id' => $user->id,
		'page_id' => $page_id,
		'type' => $type . '_past',
		'published' => '2',
	];
	$rss_fetch_cronjobs = $CI->Publisher_model->get_allrecords('rss_links', $where);
	if (count($rss_fetch_cronjobs) > 0) {
		$response = [
			'status' => false,
			'message' => 'RSS cronjob is running!'
		];
	} else {
		$response = [
			'status' => true,
			'message' => 'Cronjob has finished!'
		];
	}
	return $response;
}


if (!function_exists('sendVerificationEmail')) {

	function sendVerificationEmail($name, $title, $text, $to, $link)
	{

		$CI = &get_instance();
		$CI->load->library('email');
		$body = '<!doctype html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?=$title?></title>
<style>
img {
    border: none;
    -ms-interpolation-mode: bicubic;
    max-width: 100%;
}

body {
    background-color: #f6f6f6;
    font-family: sans-serif;
    -webkit-font-smoothing: antialiased;
    font-size: 14px;
    line-height: 1.4;
    margin: 0;
    padding: 0;
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

table {
    border-collapse: separate;
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
    width: 100%;
}

table td {
    font-family: sans-serif;
    font-size: 14px;
    vertical-align: top;
}



.body {
    background-color: #f6f6f6;
    width: 100%;
}


.container {
    display: block;
    Margin: 0 auto !important;

    max-width: 580px;
    padding: 10px;
    width: 580px;
}


.content {
    box-sizing: border-box;
    display: block;
    Margin: 0 auto;
    max-width: 580px;
    padding: 10px;
}


.main {
    background: #ffffff;
    border-radius: 3px;
    width: 100%;
}

.wrapper {
    box-sizing: border-box;
    padding: 20px;
}

.content-block {
    padding-bottom: 10px;
    padding-top: 10px;
}

.footer {
    clear: both;
    Margin-top: 10px;
    text-align: center;
    width: 100%;
}

.footer td,
.footer p,
.footer span,
.footer a {
    color: #999999;
    font-size: 12px;
    text-align: center;
}

h1,
h2,
h3,
h4 {
    color: #000000;
    font-family: sans-serif;
    font-weight: 400;
    line-height: 1.4;
    margin: 0;
    Margin-bottom: 30px;
}

h1 {
    font-size: 35px;
    font-weight: 300;
    text-align: center;
    text-transform: capitalize;
}

p,
ul,
ol {
    font-family: sans-serif;
    font-size: 14px;
    font-weight: normal;
    margin: 0;
    Margin-bottom: 15px;
}

p li,
ul li,
ol li {
    list-style-position: inside;
    margin-left: 5px;
}

a {
    color: #3498db;
    text-decoration: underline;
}

.btn {
    box-sizing: border-box;
    width: 100%;
}

.btn>tbody>tr>td {
    padding-bottom: 15px;
}

.btn table {
    width: auto;
}

.btn table td {
    background-color: #ffffff;
    border-radius: 5px;
    text-align: center;
}

.btn a {
    background-color: #ffffff;
    border: solid 1px #3498db;
    border-radius: 5px;
    box-sizing: border-box;
    color: #3498db;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    margin: 0;
    padding: 5px 10px;
    text-decoration: none;
    text-transform: capitalize;
}

.btn-primary table td {
    background-color: #3498db;
}

.btn-primary a {
    background-color: #3498db;
    border-color: #3498db;
    color: #ffffff;
}


.last {
    margin-bottom: 0;
}

.first {
    margin-top: 0;
}

.align-center {
    text-align: center;
}

.align-right {
    text-align: right;
}

.align-left {
    text-align: left;
}

.clear {
    clear: both;
}

.mt0 {
    margin-top: 0;
}

.mb0 {
    margin-bottom: 0;
}

.preheader {
    color: transparent;
    display: none;
    height: 0;
    max-height: 0;
    max-width: 0;
    opacity: 0;
    overflow: hidden;
    mso-hide: all;
    url:
        visibility: hidden;
    width: 0;
}

.powered-by a {
    text-decoration: none;
}

hr {
    border: 0;
    border-bottom: 1px solid #f6f6f6;
    Margin: 20px 0;
}


@media only screen and (max-width: 620px) {
    table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
    }

    table[class=body] p,
    table[class=body] ul,
    table[class=body] ol,
    table[class=body] td,
    table[class=body] span,
    table[class=body] a {
        font-size: 16px !important;
    }

    table[class=body] .wrapper,
    table[class=body] .article {
        padding: 10px !important;
    }

    table[class=body] .content {
        padding: 0 !important;
    }

    table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
    }

    table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
    }

    table[class=body] .btn table {
        width: 100% !important;
    }

    table[class=body] .btn a {
        width: 100% !important;
    }

    table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
    }
}


@media all {
    .ExternalClass {
        width: 100%;
    }

    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
        line-height: 100%;
    }

    .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important;
    }

    .btn-primary table td:hover {
        background-color: #34495e !important;
    }

    .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
    }
}
</style>
</head>

<body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">

                    <!-- START CENTERED WHITE CONTAINER -->
                    <table class="main">

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class="wrapper">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <p>Dear ' . $name . ',</p>
                                            <p>' . $title . '</p>
                                            <p>' . $text . '</p>
                                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                                <tbody>
                                                    <tr>
                                                        <td align="left">
                                                            <table border="0" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td> ' . $link . '</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p>We look forward to seeing you there. </p>
                                            <br />
                                            <p>Best Regards,</p>
                                            <p><b>Team Adublisher</b></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                    <div class="footer">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">

                                    <br /> Need Help ? <a href="http://www.adublisher.com">Get In Touch</a>.
                                </td>
                            </tr>

                        </table>
                    </div>

                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>

</html>';
		$CI->email->set_mailtype('html');
		$CI->email->from('support@adublisher.com', 'adublisher.com');
		$CI->email->to($to);
		$CI->email->subject($title);
		$CI->email->message($body);
		if ($CI->email->send()) {
			return true;
		} else {
			var_dump($CI->email->print_debugger());
			die;
			// return false;
		}
	}
}

function generateTableOfContents($htmlContent)
{
	// Create a DOMDocument object
	$dom = new DOMDocument();
	@$dom->loadHTML($htmlContent);
	// Get all H2 elements
	$h2Elements = $dom->getElementsByTagName('h2');
	$h2_check = false;
	// Create an unordered list to hold the table of contents
	$toc = '<ul class="table-of-content-lists" style="list-style: none;">';
	// Iterate over each H2 element and create a list item
	foreach ($h2Elements as $h2) {
		$h2_check = true;
		$toc .= '<li>';
		$toc .= '<a href="#' . createSlug($h2->textContent) . '">';
		$toc .= $h2->textContent;
		$toc .= '</a>';
		$toc .= '</li>';
	}
	$toc .= '</ul>';
	$response = [
		'status' => $h2_check,
		'body' => $toc
	];
	return $response;
}

function createSlug($string)
{
	// Convert to lowercase
	$string = strtolower($string);

	// Replace any sequence of non-alphanumeric characters with a single hyphen
	$string = preg_replace('/[^a-z0-9]+/', '-', $string);

	// Replace multiple hyphens with a single hyphen
	$string = preg_replace('/-+/', '-', $string);

	// Remove leading and trailing hyphens
	$slug = trim($string, '-');

	return $slug;
}

function formatHtmlContent($htmlContent)
{
	$dom = new DOMDocument();
	@$dom->loadHTML($htmlContent);
	// Select all H2 elements
	$h2Elements = $dom->getElementsByTagName('h2');
	foreach ($h2Elements as $h2) {
		// Create a link element
		$id = strtolower(str_replace(' ', '-', $h2->textContent));
		$h2->setAttribute('id', $id);
	}
	return $dom->saveHTML();
}
function check_user_login()
{
//	return (App::Auth()->is_User()) ? true : false;
    return session()->get('isLoggedIn');
}

function get_auth_user()
{
	$CI = &get_instance();
	$userID = App::Session()->get('userid');
	$user = $CI->Publisher_model->retrieve_record('user', $userID);
	return $user;
}

function refresh_tiktok_access_token($access_token)
{
	$CI = &get_instance();
	$user = get_auth_user();
	$tiktok = $CI->Publisher_model->get_allrecords('tiktok', array('user_id' => $user->id, 'access_token' => $access_token));
	if (count($tiktok) > 0) {
		$tiktok = $tiktok[0];
		$date = strtotime(utcToLocal(gmdate('Y-m-d H:i:s'), $user->gmt, 'Y-m-d H:i:s'));
		$expires_in = strtotime($tiktok->expires_in);
		if ($date >= $expires_in) {
			$CI->load->library('tiktok');
			$refresh_token = $CI->tiktok->refresh_access_token($tiktok->refresh_token);
			$expires_in = $date + $refresh_token['expires_in'];
			$refresh_expires_in = $date + $refresh_token['refresh_expires_in'];
			$data = array(
				'access_token' => $refresh_token['access_token'],
				'expires_in' => date('Y-m-d H:i:s', $expires_in),
				'refresh_token' => $refresh_token['refresh_token'],
				'refresh_expires_in' => date('Y-m-d H:i:s', $refresh_expires_in),
			);
			$CI->Publisher_model->update_record('tiktok', $data, $tiktok->id);
			return $refresh_token['access_token'];
		} else {
			return $access_token;
		}
	} else {
		return $access_token;
	}
}

function refresh_pinterest_access_token($access_token)
{
	$CI = &get_instance();
	$user = get_auth_user();
	if ($user->id != '2210') {
		return $access_token;
	}
	$pinterest_users = $CI->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $user->id, 'access_token' => $access_token));
	if (count($pinterest_users) > 0) {
		$pinterest = $pinterest_users[0];
		$date = strtotime(utcToLocal(gmdate('Y-m-d H:i:s'), $user->gmt, 'Y-m-d H:i:s'));
		$expires_in = $pinterest->expires_in;
		$refresh_token = $pinterest->refresh_token;
		if ($date >= $expires_in) {
			$client_id = PINTEREST_CLIENT_ID;
			$client_secret = PINTEREST_CLIENT_SECRET;
			$encoded = base64_encode("{$client_id}:{$client_secret}");
			// Set up the request
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.pinterest.com/v5/oauth/token',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=' . $refresh_token . '&scope=boards:read,pins:read,boards:write,pins:write',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/x-www-form-urlencoded',
					'Authorization: Basic ' . $encoded,
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			$response = json_decode($response, true);
			if (isset($response['access_token'])) {
				$expires_in = $date + $response['expires_in'];
				$refresh_token_expires_in = $date + $response['refresh_token_expires_in'];
				$data = [
					'access_token' => $response['access_token'],
					'refresh_token' => $response['refresh_token'],
					'expires_in' => $response['expires_in'],
					'refresh_token_expires_in' => $response['refresh_token_expires_in'],
				];
				$CI->Publisher_model->update_record('pinterest_users', $data, $pinterest->id);
				return $response['access_token'];
			}
		}
	}
	return $access_token;
}

function user_account_get($access_token)
{
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.pinterest.com/v5/user_account',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer ' . $access_token,
			'Cookie: _ir=0'
		),
	));
	$data = json_decode(curl_exec($curl), true);
	return $data;
}

function url_segments($segment = null)
{
	$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri_segments = explode('/', $uri_path);
	$segments = isset($uri_segments[2]) ? $uri_segments[2] : $uri_segments[1];
	if ($segment == $segments) {
		return true;
	} else {
		return false;
	}
}

function format_utc($utc_offset)
{
	if ($utc_offset > 0) {
		if ($utc_offset < 10) {
			$utc_offset = "UTC+0" . $utc_offset;
		} else {
			$utc_offset = "UTC+" . $utc_offset;
		}
	} else {
		$utc_offset = "UTC-" . $utc_offset;
	}
	return $utc_offset;
}

function check_pinterest_access_token($pinterest_user)
{
	$CI = &get_instance();
	$access_token = $pinterest_user->access_token;
	$now = time();
	$expires_in = $pinterest_user->expires_in;
	if ($now >= $expires_in) {
		$access_token = $CI->Publisher_model->refresh_pinterest_access_token($pinterest_user->refresh_token, $pinterest_user->id);
	}
	return $access_token;
}

function fetchUrlFromComment(string $string)
{
	$response = [
		"link" => "",
		"hasLink" => false,
	];
	$pattern = '/\b(?:https?|ftp):\/\/\S+\b/';
	preg_match_all($pattern, $string, $matches);
	if (!empty($matches[0])) {
		$response["link"] = $matches[0];
		$response["hasLink"] = true;
	}
	return $response;
}

function create_rss_image($user_id, $page_id, $link, $type)
{
	$CI = &get_instance();
	$data = [
		"user_id" => $user_id,
		"page_id" => $page_id,
		"link" => $link,
		"type" => $type,
		"status" => 0
	];
	$CI->Publisher_model->create_record('rss_images', $data);
	return true;
}

function isDefaultImage($link){
	return $link == "http://www.adublisher.com/assets/images/download.png" ? true : false;
}
