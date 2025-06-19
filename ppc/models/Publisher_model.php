<?php

use DirkGroenen\Pinterest\Pinterest;

/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - process_login()
 * - register()
 * - add_new_menu()
 * - check_logged()
 * - logged_id()
 * - getPakcages()
 * - getFeatures()
 * - getPackageFeatures()
 * - changedomain()
 * - changedomainowner()
 * - scedule_posts()
 * - scedule_posts_cron()
 * - time_pop()
 * - update_domain_name()
 * - get_domain_from_url()
 * - get_domains()
 * - get_campaigns()
 * - commingPosts()
 * - sceduler_posts()
 * - bulksceduler_posts()
 * - rsssceduler_posts()
 * - selectactivefacebookusers()
 * - get_rsspages()
 * - is_exists()
 * - selectactivefacebookpages()
 * - get_clicks()
 * - get_clicks_date_wise()
 * - get_userdomainAdmin()
 * - get_userdomain()
 * - get_rates()
 * - get_avg_rates()
 * - get_acm()
 * - trafficsummary()
 * - dashboard_widget()
 * - update_profile()
 * - get_allrecords()
 * - update_paymenthod()
 * - getNextPost()
 * - getLastID()
 * - check_username()
 * - check_email()
 * - create_record()
 * - retrieve_record()
 * - update_record_mc()
 * - update_bulkupload
 * - update_record()
 * - delete_record()
 * - update_multiple()
 * - delete_multiple()
 * - list_records()
 * - count_records()
 * - _check_array_keys()
 * - campaign_click_earn()
 * - show_table()
 * - owner_show_table()
 * - owner_specific_country_click()
 * - specific_country_click()
 * - getcountrywise()
 * - get_roles()
 * - get_active_roles()
 * - update_roles()
 * - get_specific_role()
 * - check_valid()
 * - get_gmt_status()
 * - edit_announcement()
 * - delete_announcement()
 * - create_announcement()
 * - get_active_announcements()
 * - get_latest_announcements()
 * - get_latest_notifications()
 * - get_notifications()
 * - affiliateownertrafficsummary()
 * - top_users()
 * - identify_fraud()
 * - update_clicks()
 * - change_announcement_seen()
 * - post_bulkschedule()
 * - post_rssschedule()
 * - post_igbulkschedule()
 * - get_user_articles()
 * - get_article_content()
 * - update_article()
 * - delete_article()
 * - already_save_filter()
 * - update_save_filter()
 * - save_filter()
 * - revenue_fetch()
 * - reset_password()
 * Classes list:
 * - Publisher_model extends CI_Model
 */
class Publisher_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function process_login($username, $password)
	{

		// set its variable
		$password = md5($password);
		// select data from database to check user exist or not?
		$sql = "SELECT * FROM `user` WHERE `username`= '" . $username . "' and password = '" . $password . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$user_id = $row->id;

			if ($row->status == "approve") {

				if ($row->team_role == 'owner') {

					App::Session()->set('team_owner_id', $user_id);
				} else {

					$sql = "SELECT * FROM user WHERE team_id=" . $row->team_id . " AND team_role = 'owner'";
					$owner_user = $this->db->query($sql)->row();
					App::Session()->set('team_owner_id', $owner_user->id);
				}

				App::Session()->set('userid', $user_id);
				App::Session()->set('MMP_username', $row->username);
				App::Session()->set('fullname', $row->fname . ' ' . $row->lname);
				App::Session()->set('email', $row->email);
				App::Session()->set('country', $row->country);
				App::Session()->set('userlevel', $row->userlevel);
				App::Session()->set('type', $row->type);
				App::Session()->set('membership_id', $row->membership_id);
				App::Session()->set('mem_expire', $row->mem_expire);
				App::Session()->set('avatar', $row->img);
				App::Session()->set('MMP_domain', $row->domain);
				App::Session()->set('phone', $row->ph);
				App::Session()->set('team_role', $row->team_role);
				App::Session()->set('team_id', $row->team_id);
				App::Session()->set('status', $row->status);
			}
			return $row;
		}
		return false;
	}
	function owner_dashboard()
	{

		$result = [];
		$team_id = App::Session()->get('team_id');
		$owner_id = App::Session()->get('userid');
		//Today data
		$sql = "SELECT ROUND(sum(earn), 2) as today_earning, count(cpid) as today_clicks FROM `click` WHERE DATE(date)= DATE(NOW()) AND user in(SELECT username from user where team_id = $team_id)";
		$query = $this->db->query($sql);
		$result['today_earning'] = ($query->row()->today_earning) ? $query->row()->today_earning : 0;
		$result['today_clicks'] = ($query->row()->today_clicks) ? $query->row()->today_clicks : 0;

		// All time Data
		$sql = "SELECT ROUND(sum(earn), 3) as alltime_earning  , count(cpid) as alltime_clicks FROM `click`  WHERE user in(SELECT username from user where team_id = $team_id)";
		$query = $this->db->query($sql);
		$click_query = $query->row_array();

		$sql = "SELECT device , count(cpid) as clicks FROM `click` WHERE user in(SELECT username from user where team_id = $team_id) group by device";
		$query = $this->db->query($sql);
		//$result['weekly_devices']= $query->result_array();
		foreach ($query->result_array() as $key => $val) {
			$result['weekly_devices_label'][$key] = $val['device'];
			$result['weekly_devices_clicks'][$key] = $val['clicks'];
		}

		$sql = "SELECT country, ROUND(sum(earn), 2) as earning  , count(cpid) as clicks FROM `click` WHERE user in(SELECT username from user where team_id = $team_id) group by country order by clicks desc limit 5";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val) {
			$result['weekly_country_label'][$key] = $val['country'];
			$result['weekly_country_clicks'][$key] = $val['clicks'];
		}
		if (isset($result['weekly_country_label'])) {
			$result['weekly_country_label'] = array_reverse($result['weekly_country_label']);
			$result['weekly_country_clicks'] = array_reverse($result['weekly_country_clicks']);
		} else {
			$result['weekly_country_label'] = null;
			$result['weekly_country_clicks'] = null;
		}

		//Data for Graphs Start
		$timestamp = strtotime("-7 days");
		$days = array();
		for ($i = 0; $i < 7; $i++) {
			$days['days'][$i] = strftime('%A', $timestamp);
			$end = date("Y-m-d");
			$startd = date('Y-m-d', $timestamp);
			$queryclicks = $this->db->query("SELECT  count(cpid) as clicks FROM click WHERE date = '$startd'  AND user in(SELECT username from user where team_id = $team_id)");
			$queryclicks = $queryclicks->row();
			$days['clicks'][$i] = $queryclicks->clicks;
			$timestamp = strtotime('+1 day', $timestamp);
		}
		$result['weekdays'] = @$days['days'];
		$result['weekclicks'] = @$days['clicks'];
		//Data for Graphs End

		$sql = "SELECT ROUND(sum(earning), 3) as alltime_earning  , sum(total_click) as alltime_clicks FROM `revenue` WHERE user_id in(SELECT id from user where team_id = $team_id)";
		$revenue_query = $this->db->query($sql)->row_array();
		$result['weekly_earning'] = $click_query['alltime_earning'] ? $click_query['alltime_earning'] : 0;
		$result['weekly_clicks'] = $click_query['alltime_clicks'] ? $click_query['alltime_clicks'] : 0;

		$result['alltime_earning'] = $click_query['alltime_earning'] + $revenue_query['alltime_earning'];
		$result['alltime_clicks'] = $click_query['alltime_clicks'] + $revenue_query['alltime_clicks'];

		$sql = "SELECT ROUND(sum(paid_amu) , 3)  as total_paid FROM user where team_id = $team_id";
		$query = $this->db->query($sql);
		$result['total_paid'] = $query->row()->total_paid;

		//Total resources counting
		$resources = [];
		$upr = $this->userPackageDetails();
		foreach ($upr['ptr'] as $ptr) {

			if ($ptr->fid == BULKIMAGES_FEATURE_ID) {
				$res = $this->makeresourcescol($ptr, "bulkupload");

				$resources = array_merge($resources, $res);
			}
			if ($ptr->fid == CAMPAIGNS_FEATURE_ID) {
				$res = $this->makeresourcescol($ptr, "campaigns");
				$resources = array_merge($resources, $res);
			}
			if ($ptr->fid == AFFILIATE_FEATURE_ID) {
				$res = $this->makeresourcescol($ptr, "affiliates");
				$resources = array_merge($resources, $res);
			}
		}
		$result['resources'] = $resources;
		$result['resources']['package_to_user'] = $upr['ptu'];
		$result['resources']['package'] = $upr['pkg'][0];

		return $result;
	}
	function makeresourcescol($ptr, $for)
	{
		$resources = [];
		$resources[$for] = $ptr->used;
		$resources[$for . '_quota'] = $ptr->quota;
		$resources[$for . '_left'] = $ptr->quota - $ptr->used;
		$dvi = $ptr->used / $ptr->quota;
		$resources[$for . '_percent'] = round(($dvi * 100), 0);

		$rounded = round($resources[$for . '_percent'] / 5) * 5;
		$resources[$for . '_percent_c'] = $rounded;
		if ($rounded < 50) {
			$resources[$for . '_class'] = "css-bar-success";
		} else if ($rounded >= 50 && $rounded <= 70) {
			$resources[$for . '_class'] = "css-bar-warning";
		} else {
			$resources[$for . '_class'] = "css-bar-danger";
		}
		return $resources;
	}
	function register_affiliate($fname, $lname, $email, $mobile, $username, $hash, $salt, $fbpage, $fbprofile, $gmt, $team_id)
	{
		$this->db->query("insert into user(fname,lname,email,ph,username,hash,salt,fbpage,fbprofile,gmt,status,team_role,team_id)values('" . $fname . "','" . $lname . "','" . $email . "','" . $mobile . "','" . $username . "','" . $hash . "','" . $salt . "','" . $fbpage . "','" . $fbprofile . "','" . $gmt . "','approve','affiliate','" . $team_id . "')");
		$user_id = $this->db->insert_id();
		//Assign default system domain to him
		$domain_data['domain_id'] = 2;
		$domain_data['user_id'] = $user_id;
		$domain_data['status'] = 'active';
		$user_domains = $this->create_record('user_domains', $domain_data);
		$all_menus = $this->list_records('menus');
		if ($all_menus) {
			foreach ($all_menus as $key => $row) {
				$role_data = [];
				$status = "Active";
				if ($row->type == "private") {
					$status = "InActive";
				}
				$role_data['menu_id'] = $row->id;
				$role_data['user'] = $user_id;
				$role_data['status'] = $status;
				$result = $this->create_record('menu_assign', $role_data);
			}
		}
	}

	function resources_update($type, $fid, $user_id = null)
	{
		if ($user_id) {
			$userID = $user_id;
		} else {
			$userID = App::Session()->get('userid');
		}
		if ($type == 'up') {
			$this->db->set('used', 'used + 1', FALSE);
		}
		if ($type == 'down') {
			$this->db->set('used', 'used - 1', FALSE);
		}
		$this->db->where('fid', $fid);
		$this->db->where('uid', $userID);
		$this->db->update('package_feature_user_limit');
	}

	function register($name, $email, $mobile, $username, $password, $fbpage, $fbprofile, $image, $gmt, $pid)
	{
		$password = md5($password);
		$this->db->query("insert into user(fname,email,ph,username,password,fbpage,fbprofile,img,gmt,status,team_role)values('" . $name . "','" . $email . "','" . $mobile . "','" . $username . "','" . $password . "','" . $fbpage . "','" . $fbprofile . "','" . $image . "','" . $gmt . "','approve','owner')");
		$user_id = $this->db->insert_id();
		//Get package
		$package = $this->getPakcages($pid);
		$package = $package[0];
		//Create Trial subscription
		$subscription_data['pid'] = $pid;
		$subscription_data['uid'] = $user_id;
		$subscription_data['tid'] = 0;
		$subscription_data['start_date'] = date("Y-m-d");
		$subscription_data['end_date'] = date('Y-m-d', strtotime("+" . $package->trial_days . " days"));
		$subscription_data['trial_days'] = $package->trial_days;
		$subscription = $this->create_record('package_to_user', $subscription_data);

		//Assign default system domain to him
		$domain_data['domain_id'] = 2;
		$domain_data['user_id'] = $user_id;
		$domain_data['status'] = 'active';
		$user_domains = $this->create_record('user_domains', $domain_data);
		//Create a team for him
		$team_data['name'] = "Team Alpha";
		$team_data['added'] = date("Y-m-d");
		$team_data['owner'] = $user_id;
		$team_id = $this->create_record('team', $team_data);
		$user_update_data['team_id'] = $team_id;
		$user_update = $this->Publisher_model->update_record('user', $user_update_data, $user_id);

		if ($package->features) {
			//Add limits to user's
			foreach ($package->features as $key => $row) {
				$feature_data = [];
				$feature_data['pid'] = $pid;
				$feature_data['uid'] = $user_id;
				$feature_data['fid'] = $row['id'];
				$feature_data['quota'] = $row['limit'];
				$feature_data['used'] = 0;
				$result = $this->create_record('package_feature_user_limit', $feature_data);
			}
		}
		$all_menus = $this->list_records('menus');
		if ($all_menus) {
			foreach ($all_menus as $key => $row) {
				$role_data = [];
				$status = "Active";
				if ($row->type == "private") {
					$status = "InActive";
				}
				$role_data['menu_id'] = $row->id;
				$role_data['user'] = $user_id;
				$role_data['status'] = $status;
				$result = $this->create_record('menu_assign', $role_data);
			}
		}
		$rates = $this->list_records('country', 0, 1000);
		foreach ($rates as $key => $val) {
			$data_user_rate['f_id'] = $team_id;
			$data_user_rate['c_id'] = $val->id;
			$data_user_rate['rate'] = $val->rate;
			$created_result = $this->Publisher_model->create_record('team_rates', $data_user_rate);
		}
	}

	function add_new_menu($menu_id, $status = "InActive")
	{

		$sql = "select * from user";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val) {

			$role_data['menu_id'] = $menu_id;
			$role_data['user'] = $val['id'];
			$role_data['status'] = $status;
			$result = $this->create_record('menu_assign', $role_data);
		}
	}
	function check_logged()
	{

		return (App::Auth()->is_User()) ? TRUE : FALSE;
	}

	function logged_id()
	{
		return ($this->check_logged()) ? App::Session()->get('user_id') : '';
	}

	//######## Packages ##########//

	public function userPackageDetails($userID = null)
	{
		if (!$userID) {
			$userID = App::Session()->get('team_owner_id');
			$membership_id = App::Session()->get('membership_id');
			$trial_used = App::Session()->get('trial_used');
		} else {
			$user = $this->retrieve_record('user', $userID);
			$membership_id = $user->membership_id;
			$trial_used = $user->trial_used;
		}
		$package_where = [];
		$package_where[0]['key'] = 'uid';
		$package_where[0]['value'] = $userID;

		$package_where[0]['key'] = 'mid';
		$package_where[0]['value'] = $membership_id;

		$this->db->select('*');
		$this->db->from('package_to_user');
		$this->db->where('uid', $userID);
		$data['ptu'] = $this->db->get()->result();
		$data['ptu'] = $data['ptu'][0];

		if ($membership_id == 0) {
			$data['ptu']->active = 0;
		}

		if ($trial_used == 1) {
			$data['ptu']->trial_used = 1;
		} else {
			$data['ptu']->trial_used = 0;
		}

		$resources_where[0]['key'] = 'uid';
		$resources_where[0]['value'] = $userID;
		$data['ptr'] = $this->list_records('package_feature_user_limit', 0, 100, $resources_where);
		$data['pkg'] = $this->getPakcages($data['ptu']->mid);
		return $data;
	}

	public function userPackageforCron($user)
	{
		if ($user->team_role == 'owner') {
			$userID = $user->id;
		} else {
			$sql = "SELECT * FROM user WHERE team_id=" . $user->team_id . " AND team_role = 'owner'";
			$owner_user = $this->db->query($sql)->row();
			$userID = $owner_user->id;
		}
		$package_where[0]['key'] = 'uid';
		$package_where[0]['value'] = $userID;
		$data = $this->list_records('package_to_user', 0, 1, $package_where, 'id', 'desc');
		return $data[0];
	}
	public function getPakcages($id = NULL)
	{
		$query = $this->db->query("SELECT * FROM packages WHERE active = '1' ORDER BY (id = 4) DESC");
		// $query = $this->db->query("SELECT * FROM packages  WHERE  active = '1'");
		if ($id) {
			$query = $this->db->query("SELECT * FROM packages  WHERE  active = '1' AND id =" . $id);
		}
		$packages = $query->result();
		foreach ($packages as $keyone => $pkg) {

			$active = $this->getPackageFeatures($pkg->id); //this alos includes the all features
			$all_features = $this->getFeatures();
			$have_this = [];
			foreach ($all_features as $key => $data) {
				$have_this = search($active, 'fid', $data['id']);
				if ($have_this) {
					$all_features[$key]['status'] = "active";
					$all_features[$key]['limit'] = $have_this[0]['feature_limit'];
				} else {
					$all_features[$key]['status'] = "inactive";
					$all_features[$key]['limit'] = 0;
				}
			}
			$packages[$keyone]->features = $all_features;
		}
		return $packages;
	}

	public function getFeatures()
	{
		$this->db->select('*')->from('package_features');
		return ($this->db->get()->result_array());
	}
	public function getPackageFeatures($id)
	{

		$this->db->select('*')->from('package_to_features')->where('pid', $id);
		return ($this->db->join('package_features', 'package_features.id=package_to_features.fid')->get()->result_array());
	}
	function changedomain($userID)
	{
		$allDomains = "SELECT  domains.*  FROM domains, user_domains  
        WHERE user_domains.domain_id=domains.id
            AND user_domains.user_id = $userID
            order by domains.id DESC";
		$allDomains = $this->db->query($allDomains);
		$sql = "SELECT * FROM user WHERE id=$userID";
		$result = $this->db->query($sql)->row();
		$domain_id = $result->domain;
		$domain_default = $result->domain_default;
		$domain = $this->db->query("SELECT domain FROM domains WHERE status ='active' AND id = $domain_id")->row()->domain;
		if ($domain == "") {
			$domain = $this->db->query("SELECT domain FROM domains WHERE id = $domain_default")->row()->domain;
		}
		if ($domain == "") {
			$domain = "NO ACTIVE DOMAIN";
		}
		$results = [];
		$results['current_domain'] = $domain;
		$results['all_domains'] = $allDomains->result();
		return $results;
	}

	function changedomainowner($userID)
	{
		$allDomains = "SELECT * FROM domains where user_id = $userID";
		$allDomains = $this->db->query($allDomains);
		if (count($allDomains->result()) > 0) {
			$sql = "SELECT * FROM user WHERE id=$userID";
			$result = $this->db->query($sql)->row();
			$domain_id = $result->domain;
			$domain_default = $result->domain_default;
			$domain_sql = $this->db->query("SELECT domain FROM domains WHERE status ='active' AND id = $domain_id");
			$domain = $domain_sql->row();
			if (!empty($domain)) {
				$domain = $domain->domain;
			} else {
				$domain = "";
			}
			if ($domain == "") {
				$domain = $this->db->query("SELECT domain FROM domains WHERE id = $domain_default");
			}
			if ($domain == "") {
				$domain = "NO ACTIVE DOMAIN";
			}
			$results = [];
			$results['current_domain'] = $domain;
			$results['all_domains'] = $allDomains->result();
			return $results;
		} else {
			$results = [];
			$results['current_domain'] = '';
			$results['all_domains'] = [];
			return $results;
		}
	}

	// Pass page id
	function scedule_posts($id)
	{

		$page = $this->retrieve_record('facebook_pages', $id);
		$user = $this->retrieve_record('user', $page->user_id);
		$user_domain = $this->get_userdomain($user->username);
		$multiple = $this->delete_multiple('sceduler', 'page_id', $id);
		$diffrence = $page->number_of_posts; // - $page->posts_today;
		if ($diffrence > 0) {

			$this_post_id = $page->last_post_id;

			$current_time = strtotime(gmdate("Y-m-d h:i:s"));
			$last_post_time = strtotime($page->last_post_datetime);
			$hours_next = date("h", $current_time - $last_post_time);
			$interval = ceil($hours_next / $diffrence);
			$interval_main = $interval;
			for ($i = 1; $i <= $diffrence; $i++) {

				$interval_main = $interval * $i;
				//$postId = $this->getNextPost($this_post_id);
				$postId = $this->getNextPostRenew($this_post_id, $page, $user);
				$post = $this->retrieve_record('link', $postId);
				$current_time = strtotime(gmdate("Y-m-d h:i:s"));
				$next_time = date('Y-m-d h:i:s', strtotime("+" . $interval_main . " hour", $current_time));
				$sceduler_data = [];
				$sceduler_data['post_id'] = $postId;
				$sceduler_data['page_id'] = $id;
				$sceduler_data['post_title'] = $post->text;
				$sceduler_data['user_id'] = $user->id;
				$sceduler_data['link'] = $user_domain . "/ref/" . $postId . "/" . $user->id;
				$sceduler_data['post_datetime'] = $next_time;
				$result = $this->create_record('sceduler', $sceduler_data);
				$this_post_id = $postId;
			}
		} else {
			$multiple = $this->delete_multiple('sceduler', 'page_id', $id);
		}
	}

	// Pass page id
	function scedule_posts_auto_withslots($id, $user)
	{

		$page = $this->retrieve_record('facebook_pages', $id);
		$multiple = $this->delete_multiple('sceduler', 'page_id', $id);
		$page_data = [];
		$page_data['posts_today'] = 0;
		$page_data['last_sceduled'] = localToUTC(date("Y-m-d H:i"), SERVER_TZ, "Y-m-d");
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page->id);
		$this_post_id = $page->last_post_id;
		$first_id = $this->getFirstID($user, $id);

		if ($this_post_id == $first_id || $this_post_id == NULL || $this_post_id == 0 || $this_post_id == "" || $this_post_id == 1) {
			$this_post_id = $this->getLAST_ID($user, $id);
		}

		if (!$this_post_id) {
			echo "facing error";
			return false;
		}

		$slots = json_decode($page->time_slots_auto);

		foreach ($slots as $key => $slot) {

			//$postId = $this->getNextPost($this_post_id, $user);
			$postId = $this->getNextPostRenew($this_post_id, $page, $user);
			$post = $this->retrieve_record('link', $postId);
			$next_post_date_time = date('Y-m-d') . " " . $slot . ":00";
			$next_time = localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
			$sceduler_data = [];
			$sceduler_data['post_id'] = $postId;
			$sceduler_data['page_id'] = $id;
			$sceduler_data['post_title'] = $post->text;
			$sceduler_data['user_id'] = $user->id;
			$sceduler_data['link'] = get_cp_link($postId, $user, $post->site_us_pc);
			$sceduler_data['post_datetime'] = $next_time;

			$result = $this->create_record('sceduler', $sceduler_data);
			$this_post_id = $postId;
			$page_data['last_post_id'] = $postId;
			$this->update_record('facebook_pages', $page_data, $id);
		}
	}

	// Pass page id
	function scedule_posts_cron($id, $user)
	{
		$page = $this->retrieve_record('facebook_pages', $id);
		$multiple = $this->delete_multiple('sceduler', 'page_id', $id);
		$page_data = [];
		$page_data['posts_today'] = 0;
		$page_data['last_sceduled'] = localToUTC(date("Y-m-d H:i"), SERVER_TZ, "Y-m-d"); //date("Y-m-d");//localToUTC(date("Y-m-d") , SERVER_TZ , "Y-m-d");
		$result = $this->Publisher_model->update_record('facebook_pages', $page_data, $page->id);
		$diffrence = $page->number_of_posts; // - $page->posts_today;
		//echo "<br>";
		$this_post_id = $page->last_post_id;
		//echo "<br>";
		$first_id = $this->getFirstID($user, $id);
		// echo "<br>";
		// echo $this_post_id = $this->getLAST_ID($user);

		if ($this_post_id == $first_id || $this_post_id == NULL || $this_post_id == 0 || $this_post_id == "" || $this_post_id == 1) {
			$this_post_id = $this->getLAST_ID($user, $id);
		}
		if (!$this_post_id) {
			echo "facing error";
			return false;
		}
		$current_time = strtotime($user->posting_start);
		$last_post_time = strtotime($user->posting_end);
		$hours_next = round(($last_post_time - $current_time) / 60, 2);
		$interval = ceil($hours_next / $page->number_of_posts);

		$interval_main = $interval;
		for ($i = 1; $i <= $diffrence; $i++) {

			$interval_main = $interval * $i;
			//$postId = $this->getNextPost($this_post_id, $user);
			$postId = $this->getNextPostRenew($this_post_id, $page, $user);


			$post = $this->retrieve_record('link', $postId);

			//$current_time   = strtotime(date("Y-m-d")." ".$user->posting_start);
			// $next_time = date('Y-m-d h:i:s' , strtotime( "+".$interval_main." hour", $current_time));
			$dt = new DateTime($page_data['last_sceduled'] . " " . $user->posting_start);
			$dt->modify('+' . $interval_main . ' minutes');
			$next_time = $dt->format('Y-m-d H:i'); //localToUTC( , SERVER_TZ , "Y-m-d H:i");
			$sceduler_data = [];
			$sceduler_data['post_id'] = $postId;
			$sceduler_data['page_id'] = $id;
			$sceduler_data['post_title'] = $post->text;
			$sceduler_data['user_id'] = $user->id;
			$sceduler_data['link'] = get_cp_link($postId, $user, $post->site_us_pc);
			$sceduler_data['post_datetime'] = $next_time;
			$result = $this->create_record('sceduler', $sceduler_data);
			$this_post_id = $postId;

			$page_data['last_post_id'] = $postId;
			$this->update_record('facebook_pages', $page_data, $id);

			//echo "<li>". $result. " : " .$post->text;
			//echo "</li>";
		}
	}
	function get_link_settings($user_id)
	{
		$sql = "SELECT direct_link FROM `user` WHERE id = $user_id";
		$link_query = $this->db->query($sql)->row_array();
		return $link_query['direct_link'];
	}
	function time_pop($time)
	{
		$df = "G:i:s"; // Use a simple time format to find the difference
		$ts1 = strtotime(date($df)); // Timestamp of current local time
		$ts2 = strtotime(gmdate($df)); // Timestamp of current UTC time
		$diff2 = $ts1 - $ts2;
		$diff = date("H", $diff2);
		$ts3 = $diff / 3600;
		$sign = "+";
		if ($diff2 < 0) {
			$sign = "-";
		}
		return strtotime($sign . $diff . " hour", strtotime($time));
	}

	function update_domain_name($value, $id)
	{
		$this->db->where('id', $id);
		$this->db->set('domain', $value);
		$this->db->update('link');
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	function get_domain_from_url()
	{
		$this->db->distinct('site_us_pc');
		$this->db->select('id,site_us_pc');
		$this->db->where('status', 'enable');
		$this->db->where('deleted', 'F');
		$this->db->from('link');
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result_array() : false;
	}
	function get_domains()
	{
		$userID = App::Session()->get('userid');
		$sql = "SELECT * FROM user WHERE id=" . $userID;
		$result = $this->db->query($sql)->row();
		$adv_priority = $result->adv_priority;
		$team_owner_id = App::Session()->get('team_owner_id');
		if ($adv_priority == "custom") {
			$sql = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE a.user_id = $team_owner_id AND u.status ='active' AND a.status ='active' AND u.user_id = " . $userID;
			$query = $this->db->query($sql);
			return $query->result_array();
		} else {
			$this->db->select('domain');
			$this->db->where('status', 'active');
			$this->db->where('user_id', $team_owner_id);
			$this->db->from('articledomains');
			$query = $this->db->get();
			return $query->num_rows() > 0 ? $query->result_array() : false;
		}
	}
	function owner_get_campaigns($request = NULL, $cat = NULL, $popularity = NULL, $keyword = NULL, $page = 1, $domain = NULL, $team_id = null)
	{
		$owner_id = App::Session()->get('team_owner_id');
		if (in_array('all', $cat)) {
			$cat = 'all';
		}
		$parsed_domain = parse_url($domain);
		$domain = count($parsed_domain) > 0 && isset($parsed_domain['host']) ? str_replace('www.', '', $parsed_domain['host']) : $domain;
		$pagesize = 20;
		$start = ($page - 1) * $pagesize;
		$userID = App::Session()->get('userid');
		$sql = "SELECT * FROM user WHERE id=" . $userID;
		$resultQQ = $this->db->query($sql)->row();
		$adv_priority = $resultQQ->adv_priority;
		$all_domain_query = "";
		if ($adv_priority == "custom") {
			$sql_QQ = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE u.status ='active' AND a.status ='active' AND a.user_id = $owner_id  AND  u.user_id = " . $userID;
			$query_QQ = $this->db->query($sql_QQ);
			$result_domains_QQ = $query_QQ->result_array();

			foreach ($result_domains_QQ as $row) {
				$domainQQ = $search_keyword = trim($row['domain']);
				$parsed = parse_url($domainQQ);
				if (count($parsed) > 0 && isset($parsed['host'])) {
					$domainQQ = $parsed['host'];
					$domainQQ = str_replace('www.', '', $domainQQ);
				}
				$all_domain_query .= " site_us_pc LIKE '%" . $domainQQ . "%' OR ";
			}
			$all_domain_query = "AND " . substr($all_domain_query, 0, (strlen($all_domain_query) - 3));
		}
		if ($request == "recomended") {
			$keyword_query = "select * from recomendation where userid = $userID AND search_keyword != '' ";
			$keyword_query = $this->db->query($keyword_query)->result();
			$string_inner = "";
			foreach ($keyword_query as $row) {
				$search_keyword = trim($row->search_keyword);
				$string_inner .= " text LIKE '%" . $search_keyword . "%' OR ";
			}
			$string_inner = substr($string_inner, 0, (strlen($string_inner) - 3));
			if (!empty($string_inner)) {
				$query = "select * from link where ( $string_inner  ) AND status='enable' AND link.user_id = $owner_id AND deleted = 'F' $all_domain_query order by id desc ";
			} else {
				$query = "select * from link where status='enable' AND link.user_id = $owner_id AND deleted = 'F' $all_domain_query order by id desc ";
			}
		} else if ($request == "search") {
			$keyword_query = "select * from recomendation where search_keyword = '$keyword' AND userid= $userID LIMIT 1";
			$keyword_query = $this->db->query($keyword_query);
			if ($keyword_query->num_rows() > 0) {
				$this->db->query("UPDATE recomendation SET search_keyword_count = search_keyword_count+1 WHERE search_keyword = '$keyword'");
			} else {
				$this->db->query("INSERT INTO recomendation(userid, search_keyword , search_category , search_keyword_count , search_category_count ) VALUES(
            '$userID', '$keyword' ,  '$cat' , 1 , 0)");
			}
			$query = "select *  from link where text LIKE '%$keyword%' AND status='enable' AND user_id = $owner_id AND deleted = 'F' $all_domain_query  order by id desc  ";
		} else if ($request == "filter") {
			$popularity_q = "";
			$domain_query = "";
			if ($domain != "") {
				if ($domain != "all") {
					$domain_query = "AND site_us_pc LIKE '%$domain%'";
				} else {
					$domain_query = $all_domain_query;
				}
			}
			$domain_query = trim($domain_query) == "AND" ? "" : $domain_query;
			if ($popularity != "") {
				if ($popularity == "today") {
					$startd = date("Y-m-d");
					$end = date("Y-m-d");
					$popularity_q = "AND b.date >= '$startd' AND b.date <= '$end'";
					if ($cat != "" and $cat != "all") {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.user_id = $owner_id AND a.categury IN (" . implode(',', array_map('intval', $cat)) . ") AND a.deleted = 'F' $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					} else {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.user_id = $owner_id AND a.deleted = 'F'  $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					}
				} else if ($popularity == "week") {
					$end = date("Y-m-d");
					$startd = date('Y-m-d', strtotime("-6 days"));
					$popularity_q = "AND b.date >= '$startd' AND b.date <= '$end'";
					if ($cat != "" and $cat != "all") {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.user_id = $owner_id AND a.categury IN (" . implode(',', array_map('intval', $cat)) . ") AND a.deleted = 'F' $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					} else {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.user_id = $owner_id AND a.deleted = 'F'  $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					}
				} else if ($popularity == "month") {
					$end = date("Y-m-d");
					$startd = date('Y-m-d', strtotime("-30 days"));
					$popularity_q = "AND b.date >= '$startd' AND b.date <= '$end'";
				} else if ($popularity == "all") {
					if ($cat != "" and $cat != "all") {
						$query = "select * from link  where status='enable' AND user_id = $owner_id AND categury IN (" . implode(',', array_map('intval', $cat)) . ") $domain_query AND deleted = 'F'   order by total_click DESC";
					} else {
						$query = "select * from link where status='enable' AND user_id = $owner_id  $domain_query AND deleted = 'F'  order by total_click DESC";
					}
				}
			} else {
				if ($cat != "" and $cat != "all") {
					$query = "select * from link  where status='enable' AND user_id = $owner_id AND categury IN (" . implode(',', array_map('intval', $cat)) . ") $domain_query AND deleted = 'F'   order by id desc   ";
				} else {
					$query = "select * from link where status='enable' AND user_id = $owner_id  $domain_query AND deleted = 'F'  order by id desc  ";
				}
			}
		} else {
			$query = "select * from link where status='enable' AND user_id = $owner_id AND deleted = 'F'  order by id desc";
		}
		$count_query = $this->db->query($query);
		$campaign_query = $this->db->query($query . " limit " . $start . ", " . $pagesize);
		$response = [];
		$response['count'] = $count_query->num_rows();
		$response['pagesize'] = $pagesize;
		$response['campaigns'] = $campaign_query->result();
		return $response;
	}


	function get_campaigns($request = NULL, $cat = NULL, $popularity = NULL, $keyword = NULL, $page = 1, $domain = NULL)
	{

		if ((is_array($cat) && in_array('all', $cat)) && count($cat) == 1) {
			$cat = 'all';
		}
		$pagesize = 40;
		$start = ($page - 1) * $pagesize;
		$userID = App::Session()->get('userid');
		$sql = "SELECT * FROM user WHERE id=" . $userID;
		$resultQQ = $this->db->query($sql)->row();
		$adv_priority = $resultQQ->adv_priority;
		$all_domain_query = "";
		if ($adv_priority == "custom") {

			$sql_QQ = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE u.status ='active' AND u.user_id = " . $userID;
			$query_QQ = $this->db->query($sql_QQ);
			$result_domains_QQ = $query_QQ->result_array();

			foreach ($result_domains_QQ as $row) {
				$domainQQ = $search_keyword = trim($row['domain']);
				$all_domain_query .= " site_us_pc LIKE '%" . $domainQQ . "%' OR ";
			}
			$all_domain_query = "AND " . substr($all_domain_query, 0, (strlen($all_domain_query) - 3));
		}
		//echo $all_domain_query; die();
		if ($request == "recomended") {
			$keyword_query = "select * from recomendation where userid = $userID AND search_keyword != '' ";
			$keyword_query = $this->db->query($keyword_query)->result();
			$string_inner = "";
			foreach ($keyword_query as $row) {
				$search_keyword = trim($row->search_keyword);
				$string_inner .= " text LIKE '%" . $search_keyword . "%' OR ";
			}
			$string_inner = substr($string_inner, 0, (strlen($string_inner) - 3));
			$query = "select * from link where $string_inner  AND status='enable' AND deleted = 'F' $all_domain_query order by id desc ";
		} else if ($request == "search") {
			$keyword_query = "select * from recomendation where search_keyword = '$keyword' AND userid= $userID LIMIT 1";
			$keyword_query = $this->db->query($keyword_query);
			if ($keyword_query->num_rows() > 0) {
				$this->db->query("UPDATE recomendation SET search_keyword_count = search_keyword_count+1 WHERE search_keyword = '$keyword'");
			} else {
				$this->db->query("INSERT INTO recomendation(userid, search_keyword , search_category , search_keyword_count , search_category_count ) VALUES(
            '$userID', '$keyword' ,  '$cat' , 1 , 0)");
			}
			$query = "select *  from link where text LIKE '%$keyword%' AND status='enable' AND deleted = 'F' $all_domain_query  order by id desc  ";
		} else if ($request == "filter") {

			$popularity_q = "";
			$domain_query = "";

			if ($domain != "") {
				if ($domain != "all") {
					$domain_query = "AND site_us_pc LIKE '$domain%'";
				} else {
					$domain_query = $all_domain_query;
				}
			}
			if ($popularity != "") {
				if ($popularity == "today") {
					$startd = date("Y-m-d");
					$end = date("Y-m-d");
					$popularity_q = "AND b.date >= '$startd' AND b.date <= '$end'";
					if ($cat != "" and $cat != "all") {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.categury IN (" . implode(',', array_map('intval', $cat)) . ") AND a.deleted = 'F' $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					} else {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.deleted = 'F'  $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					}
				} else if ($popularity == "week") {
					$end = date("Y-m-d");
					$startd = date('Y-m-d', strtotime("-6 days"));
					$popularity_q = "AND b.date >= '$startd' AND b.date <= '$end'";
					if ($cat != "" and $cat != "all") {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.categury IN (" . implode(',', array_map('intval', $cat)) . ") AND a.deleted = 'F' $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					} else {
						$query = "select a.* , count(b.cpid) as total_clicks from link as a , click as b where a.status='enable' AND a.deleted = 'F'  $domain_query $popularity_q AND b.cpid=a.id group by  a.id order by total_clicks desc ";
					}
				} else if ($popularity == "month") {
					$end = date("Y-m-d");
					$startd = date('Y-m-d', strtotime("-30 days"));
					$popularity_q = "AND b.date >= '$startd' AND b.date <= '$end'";
				} else if ($popularity == "all") {
					if ($cat != "" and $cat != "all") {
						$query = "select * from link  where status='enable' AND categury IN (" . implode(',', array_map('intval', $cat)) . ") $domain_query AND deleted = 'F'   order by total_click DESC";
					} else {
						$query = "select * from link where status='enable'  $domain_query AND deleted = 'F'  order by total_click DESC";
					}
				}
			} else {
				if ($cat != "" and $cat != "all") {
					$query = "select * from link  where status='enable' AND categury IN (" . implode(',', array_map('intval', $cat)) . ") $domain_query AND deleted = 'F'   order by id desc   ";
				} else {
					$query = "select *  from link where status='enable'  $domain_query AND deleted = 'F'  order by id desc  ";
				}
			}
		} else {
			$query = "select *  from link where status='enable' AND deleted = 'F'  order by id desc";
		}

		$count_query = $this->db->query($query);
		$campaign_query = $this->db->query($query . " limit " . $start . ", " . $pagesize);
		$response = [];
		$response['count'] = $count_query->num_rows();
		$response['pagesize'] = $pagesize;
		$response['campaigns'] = $campaign_query->result();
		return $response;
	}

	function commingPosts($postId)
	{
		$query = $this->db->query("SELECT * FROM link  WHERE deleted = 'F' AND id  > " . $postId);
		return $query->result();
	}

	function sceduler_posts()
	{
		$time = gmdate('Y-m-d H:i');
		//die();
		//$time = localToUTC(date("Y-m-d H:i") , SERVER_TZ , "Y-m-d H:i");
		$query = $this->db->query("SELECT * FROM sceduler  WHERE status = 0 AND post_datetime  <= '" . $time . "'");
		return $query->result();
	}

	function bulksceduler_posts($table)
	{

		$time = gmdate('Y-m-d H:i');
		if ($table == 'bulkupload') {
			$query = $this->db->query("SELECT * FROM $table  WHERE status = 0 AND post_datetime  <= '" . $time . "'");
		} else {
			$query = $this->db->query("SELECT * FROM $table  WHERE  post_datetime  <= '" . $time . "'");
		}
		return $query->result();
	}

	function getScheduledPostsFromChannels($table = 'channels_scheduler', $type = 'facebook')
	{
		$time = gmdate('Y-m-d H:i:s');
		$query = $this->db->query("SELECT * FROM $table  WHERE type= '" . $type . "' AND status=0 AND post_datetime  <= '" . $time . "'");
		return $query->result();
	}

	function getYoutubeScheduledVideos($table = 'youtube_scheduler')
	{
		$time = gmdate('Y-m-d H:i');
		$youtubeSql = "SELECT * FROM $table WHERE published = 0 AND publish_datetime <= '" . $time . "'";
		$query = $this->db->query($youtubeSql);
		return $query->result();
	}


	function rsssceduler_posts($table)
	{

		$time = gmdate('Y-m-d H:i');
		//$time = localToUTC(date("Y-m-d H:i") , SERVER_TZ , "Y-m-d H:i");
		if ($table == 'instagram_scheduler' || $table == 'facebook_group_scheduler') {
			$query = $this->db->query("SELECT * FROM $table  WHERE publish_datetime  <= '" . $time . "'  AND published = 0");
		} elseif ($table == 'pinterest_scheduler') {
			$query = $this->db->query("SELECT * FROM $table  WHERE publish_datetime  <= '" . $time . "'  AND published = 0");
		} else if ($table == 'tiktok_scheduler') {
			$query = $this->db->query("SELECT * FROM $table  WHERE post_datetime  <= '" . $time . "'  AND published = 0");
		} else {
			$query = $this->db->query("SELECT * FROM $table  WHERE post_datetime  <= '" . $time . "'  AND posted = 0");
		}
		return $query->result();
	}

	function selectactivefacebookusers()
	{

		$query = $this->db->query("SELECT * FROM user  WHERE  facebook_id != '' AND active = 'y'");
		return $query->result();
	}

	function get_rsspages($user_id)
	{
		$query = $this->db->query("SELECT * FROM facebook_pages WHERE rss_link != '' AND rss_link != 'null' AND rss_link IS NOT NULL AND time_slots_rss != '' AND time_slots_rss != 'null' AND time_slots_rss IS NOT NULL AND user_id = $user_id");
		return $query->result();
	}

	function get_allpages($user_id)
	{
		$query = $this->db->query("SELECT * FROM facebook_pages WHERE time_slots_rss != '' AND time_slots_rss != 'null' AND time_slots_rss IS NOT NULL AND user_id = $user_id");
		return $query->result();
	}

	function get_active_fb_groups()
	{
		$query = $this->db->query("SELECT * FROM facebook_groups  WHERE active = 'y'");
		return $query->result();
	}

	function select_active_pinterest_users()
	{

		$query = $this->db->query("SELECT * FROM pinterest_users  WHERE active = 'y'");
		return $query->result();
	}

	function get_rss_boards($user_id)
	{

		$query = $this->db->query("SELECT * FROM pinterest_boards WHERE rss_link != '' AND rss_link != 'null' AND rss_link IS NOT NULL AND time_slots_rss != '' AND time_slots_rss != 'null' AND time_slots_rss IS NOT NULL AND user_id = $user_id");
		return $query->result();
	}
	function get_all_boards($user_id)
	{

		$query = $this->db->query("SELECT * FROM pinterest_boards WHERE time_slots_rss != '' AND time_slots_rss != 'null' AND time_slots_rss IS NOT NULL AND user_id = $user_id");
		return $query->result();
	}

	function get_rss_active_ig_uesrs()
	{
		$query = $this->db->query("SELECT * FROM instagram_users WHERE active = 'y' AND rss_link != '' AND rss_link != 'null' AND rss_link IS NOT NULL AND time_slots_rss != '' AND time_slots_rss IS NOT NULL");
		return $query->result();
	}

	function get_all_active_ig_uesrs()
	{
		$query = $this->db->query("SELECT * FROM instagram_users WHERE active = 'y' AND time_slots_rss != '' AND time_slots_rss IS NOT NULL");
		return $query->result();
	}


	function is_exists($table, $like = NULL, $where = NULL)
	{

		$this->db->select('*');
		$this->db->from($table);

		if (isset($where["key"])) {
			$this->db->where($where["key"], $where["value"]);
		} elseif ($where) {
			foreach ($where as $where_item) {
				$this->db->where($where_item["key"], $where_item["value"]);
			}
		}
		if (isset($like["key"])) {
			$this->db->like($like["key"], $like["value"]);
		} elseif ($like) {
			foreach ($like as $like_item) {
				$this->db->like($like_item["key"], $like_item["value"]);
			}
		}

		$is_exist = $this->db->get()->num_rows;

		if ($is_exist) {
			return 1;
		} else {
			return 0;
		}
	}
	function selectactivefacebookpages($userid)
	{

		$query = $this->db->query("SELECT * FROM facebook_pages  WHERE  user_id =$userid AND time_slots_auto IS NOT NULL  AND auto_posting = 'on' ");
		return $query->result();
	}

	function get_clicks($popularity = "", $id = 0)
	{

		$popularity_query = ' cpid= ' . $id;

		if ($popularity != "") {
			$popularity_q = "";

			if ($popularity == "today") {
				$startd = date("Y-m-d");
				$end = date("Y-m-d");
				$popularity_q = " date >= '$startd' AND date <= '$end' AND";
			} else if ($popularity == "week") {
				$end = date("Y-m-d");
				$startd = date('Y-m-d', strtotime("-6 days"));
				$popularity_q = " date >= '$startd' AND date <= '$end' AND";
			} else if ($popularity == "month") {
				$end = date("Y-m-d");
				$startd = date('Y-m-d', strtotime("-30 days"));
				$popularity_q = " date >= '$startd' AND date <= '$end' AND";
			}

			$popularity_query = $popularity_q . '  cpid= ' . $id;
		}

		if ($popularity == "all") {
			$query = "select total_click from link where id =" . $id;
			return $this->db->query($query)->row()->total_click;
		} else {
			$query = "select count(cpid) as totalclicks from click where $popularity_query  ";
			return $this->db->query($query)->row()->totalclicks;
		}
	}

	function get_clicks_date_wise($popularity = NULL, $id = 0)
	{
		$popularity = ' cpid= ' . $id;
		if ($popularity != NULL) {
			$popularity = $popularity . ' AND cpid= ' . $id;
		}
		$query = "select count(cpid) as totalclicks from click where $popularity  ";
		return $this->db->query($query)->row()->totalclicks;
	}

	function get_userdomainAdmin($id)
	{
		$sql = "SELECT * FROM user WHERE id='$id'";
		$result = $this->db->query($sql)->row();
		$userID = $result->id;

		$domain_id = $result->domain;
		$domain = "";
		$domain = $this->db->query("SELECT domain FROM domains WHERE status ='active' AND id = $domain_id");

		if (count($domain->result()) > 0) {
			$domain = $domain->row()->domain;
		} else if ($domain == "") {

			$domain_id = $result->domain_default;
			$domain = $this->db->query("SELECT domain FROM domains WHERE id = $domain_id"); //-row()->domain;
			if (count($domain->result()) > 0) {
				$domain = $domain->row()->domain;
			}
		} else {
			$sql = "SELECT * FROM system_domain LIMIT 1";
			$domain_id = $this->db->query($sql)->row()->domain_id;
			$domain = $this->db->query("SELECT domain FROM domains WHERE id = $domain_id")->row()->domain;
		}

		return $domain;
	}
	function get_userdomain($username)
	{

		$sql = "SELECT * FROM user WHERE username='$username'";
		$result = $this->db->query($sql)->row();
		$userID = $result->id;

		$domain_id = $result->domain;
		$domain = "";
		$domain = $this->db->query("SELECT domain FROM domains WHERE status ='active' AND id = $domain_id");

		if (count($domain->result()) > 0) {
			$domain = $domain->row()->domain;
		} else if ($domain == "") {

			$domain_id = $result->domain_default;
			$domain = $this->db->query("SELECT domain FROM domains WHERE id = $domain_id"); //-row()->domain;
			if (count($domain->result()) > 0) {
				$domain = $domain->row()->domain;
			}
		} else {
			$sql = "SELECT * FROM system_domain LIMIT 1";
			$domain_id = $this->db->query($sql)->row()->domain_id;
			$domain = $this->db->query("SELECT domain FROM domains WHERE id = $domain_id")->row()->domain;
		}

		return $domain;
	}

	function get_redirect_domain($user)
	{
		if ($user->team_role == 'owner') {
			$domain_id = $user->domain;
		} else {
			$sql = "SELECT * FROM user WHERE team_id=" . $user->team_id . " AND team_role = 'owner'";
			$owner_user = $this->db->query($sql)->row();
			$domain_id = $owner_user->domain;
		}
		if ($domain_id) {
			// $domain = $this->db->query("SELECT domain FROM domains WHERE status ='active' AND id = ".$domain_id." AND user_id = ".$user->id);
			$domain = $this->db->query("SELECT domain FROM domains WHERE id = '$domain_id' AND status ='active' AND user_id = '$user->id'");
		}
		$response = $domain->result();
		if (count($response) > 0) {
			$domain = $domain->row()->domain;
			return $domain;
		} else {
			return false;
		}
	}
	function get_rates($value)
	{
		$query = "SELECT * from country where name= '$value' ";
		$domain_query = $this->db->query($query);
		$row = $domain_query->row();
		return $row ? $row->rate : 0;
	}
	function get_avg_rates()
	{
		$query = "SELECT AVG(rate) as rpm FROM country WHERE name != 'United States' AND name != 'United Kingdom' AND name !='Australia' AND name !='Canada'  AND name !='India' ";
		$domain_query = $this->db->query($query);
		$row = $domain_query->row();
		return $row->rpm;
	}
	function get_acm($userid)
	{
		$acm_query = "SELECT acm_users.user_id, accountmanager.* FROM accountmanager INNER JOIN acm_users ON accountmanager.id = acm_users.acm_id where acm_users.user_id='" . $userid . "'";
		$acm_query = $this->db->query($acm_query);
		if ($acm_query->num_rows() > 0) {
			return $acm_query->row();
		} else {
			return false;
		}
	}
	function trafficsummary()
	{
		$result = [];
		// Today data
		$username = App::Session()->get('MMP_username');

		$sql = "SELECT ROUND(sum(earn), 3) as today_earning, count(cpid) as today_clicks FROM `click` WHERE DATE(date)= DATE(NOW()) AND user= '" . $username . "'";
		$query = $this->db->query($sql);
		$result['today_earning'] = $query->row()->today_earning;
		$result['today_clicks'] = $query->row()->today_clicks;
		$sql = "select  a.country , b.code , count(a.earn) as count , ROUND(sum(a.earn), 3) as total_earn from click as a , country as b where DATE(a.date) = DATE(NOW()) AND a.country = b.name  AND a.user= '" . $username . "' group by a.country order by a.country  desc";
		$query = $this->db->query($sql);
		$result['today_summary'] = $query->result_array();
		return $result;
	}

	function dashboard_widget($username, $user_id = NULL)
	{

		$results = array();
		if ($user_id == NULL) {

			$user_id = App::Session()->get('userid'); //1762

		}

		//Data for Graphs Start
		$timestamp = strtotime("-7 days");
		$days = array();
		for ($i = 0; $i < 8; $i++) {
			$days['days'][$i] = strftime('%A', $timestamp);
			$end = date("Y-m-d");
			$startd = date('Y-m-d', $timestamp);
			$queryclicks = $this->db->query("SELECT sum(earn) as earn , count(cpid) as clicks FROM click WHERE date = '$startd'  AND user='$username'");
			$queryclicks = $queryclicks->row();
			$days['clicks'][$i] = $queryclicks->clicks;
			$days['earn'][$i] = round($queryclicks->earn, 3);
			$timestamp = strtotime('+1 day', $timestamp);
		}
		$results['weekdays'] = $days['days'];
		$results['weekclicks'] = $days['clicks'];
		$results['weekearn'] = $days['earn'];
		//Data for Graphs End


		// Today Calculations start
		$todayclick = $this->db->query("SELECT * FROM click WHERE date=CURDATE() && user='$username'");
		$todayclick = $todayclick->num_rows();
		$todayclick = round($todayclick, 0);
		$todayearn = $this->db->query("SELECT sum(earn) as todayearn FROM click WHERE date=CURDATE() && user='$username'");
		$todayearn = $todayearn->row();
		$todayearn = round($todayearn->todayearn, 3);
		if ($todayclick == 0 || $todayearn == 0) {
			$todaycpc = 0;
			$todayrpm = 0;
			$todayearn = 0;
		} else {
			$todaycpc = $todayearn / $todayclick;
			$todayrpm = round($todaycpc * 1000, 2);
		}
		$results['todayclick'] = cnf($todayclick, 2);
		$results['todayearn'] = $todayearn ? $todayearn : 0;
		$results['todayrpm'] = $todayrpm;
		// Today Calculations End
		// Yesterday Calculations start
		$startd = date('Y-m-d', strtotime("-1 days"));
		$yesterday = $this->db->query("SELECT sum(earn) as yesterday , count(earn) as yesterdayclicks FROM click WHERE date >= '$startd' AND date <= '$startd' AND user='$username'");
		$yesterday = $yesterday->row();
		$results['yesterday_earn'] = $yesterday->yesterday ? $yesterday->yesterday : 0;
		$results['yesterday_clicks'] = cnf($yesterday->yesterdayclicks, 2);
		// Yesterday Calculations end


		// Weekely Calculations Start
		$end = date("Y-m-d");
		$startd = date('Y-m-d', strtotime("-7 days"));
		$weekquery = $this->db->query("SELECT sum(earn) as weekearn , count(earn) as weekclicks FROM click WHERE user='$username'");
		$weekquery = $weekquery->row();
		$results['week_earn'] = $weekquery->weekearn ? $weekquery->weekearn : 0;
		$results['week_clicks'] = cnf($weekquery->weekclicks, 2);
		// weekly Calculations end
		// All Time Calculations start
		$sql = "SELECT ROUND(sum(earn), 3) as alltime_earning  , count(cpid) as alltime_clicks FROM `click` WHERE user='$username'";
		$clik_query = $this->db->query($sql);
		$sql = "SELECT ROUND(sum(earning), 3) as alltime_earning  , sum(total_click) as alltime_clicks FROM `revenue` WHERE user_id='$user_id'";
		$revenue_query = $this->db->query($sql);
		$results['alltime_earning'] = $clik_query->row()->alltime_earning + $revenue_query->row()->alltime_earning;
		$results['alltime_clicks'] = cnf($clik_query->row()->alltime_clicks + $revenue_query->row()->alltime_clicks, 2);
		// All Time Calculations End
		// Balance Calculations start
		$totalpaid_query = $this->db->query("SELECT paid_amu FROM user WHERE username='$username'");
		$totalpaid_row = $totalpaid_query->row();
		$totalpaid = $totalpaid_row->paid_amu;
		$results['total_paid'] = round(@$totalpaid, 3);
		$results['totalpending'] = @($results['alltime_earning'] - $totalpaid);
		// Balance Calculations End
		// All time top earners
		$sql = "select id, user, count(user) c, ROUND( sum(earn) , 3) as e , fname as name from click  LEFT JOIN  user ON user.username = click.user  group by user order by c desc limit 10";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val) {
			if ($val['user'] != $username) {
				$val['name'] = substr($val['name'], 0, 1) . "***";
			}

			$results['alltime_top_earning'][] = $val;
		}

		// End All time top Earners
		//$results['totalcpc'] = $totalcpc;
		//$results['totalrpm'] = $totalrpm;
		return $results;
	}
	function update_profile($pass_array_input)
	{

		$name = $pass_array_input[0];
		$phone = $pass_array_input[1];
		$userid = $pass_array_input[2];
		$fbprofile = $pass_array_input[3];
		$fbpage = $pass_array_input[4];
		$gmt = $pass_array_input[5];

		if (count($pass_array_input) == 7) {
			$img = $pass_array_input[6];

			$sqlupdate = "Update  `user` set name='" . $name . "' ,ph='" . $phone . "' ,fbprofile='" . $fbprofile . "' ,fbpage='" . $fbpage . "' ,img='" . $img . "',gmt='" . $gmt . "' WHERE `id`= '" . $userid . "' ";
		} else {
			$sqlupdate = "Update  `user` set name='" . $name . "' ,ph='" . $phone . "' ,fbprofile='" . $fbprofile . "' ,fbpage='" . $fbpage . " ',gmt='" . $gmt . "'  WHERE `id`= '" . $userid . "' ";
		}

		$sqlupdatequery = $this->db->query($sqlupdate);
		$sql = "SELECT * FROM `user` WHERE `id`= '" . $userid . "' and active='y'";
		$query = $this->db->query($sql);
		$row = $query->row();
		App::Session()->set('fullname', $row->name);
		App::Session()->set('email', $row->email);
		App::Session()->set('avatar', $row->avatar);
		App::Session()->set('MMP_domain', $row->domain);
		App::Session()->set('phone', $row->ph);
		return true;
	}

	function get_allrecords($table, $where = null)
	{
		// $where=array('id' => $id);
		if ($where != '') {
			$query = $this->db->get_where($table, $where);
		} else {
			$query = $this->db->get($table);
		}
		return $query->result();
	}
	function get_allrecords_array($table, $where = null)
	{
		// $where=array('id' => $id);
		if ($where != '') {
			$query = $this->db->get_where($table, $where);
		} else {
			$query = $this->db->get($table);
		}
		return $query->result_array();
	}
	function update_paymenthod($modpay_bank, $modpay_paypal, $acc_no, $payname, $bankname, $bank_branch, $paypal_email, $modpay_payoneer, $payoneer_email, $modpay_mobicash, $mobicashid, $mobicashemail, $modpay_easypaisa, $easypaisaid, $easypaisaemail, $mobile, $myusername)
	{
		if (isset($modpay_bank)) {
			if ($payname != '' || $acc_no != '' || $bankname != '' || $bank_branch != '') {
				$this->db->query("UPDATE user SET payname='" . $payname . "', acc_no='" . $acc_no . "', bankname='" . $bankname . "',  bank_branch='" . $bank_branch . "', mode_of_pay='bank' WHERE username='" . $myusername . "'");
			}
		}
		if (isset($modpay_paypal)) {
			if ($payname != '' || $paypal_email != '') {
				$this->db->query("UPDATE user SET payname='" . $payname . "', paypal_email='" . $paypal_email . "', mode_of_pay='paypal' WHERE username='" . $myusername . "'");
			}
		}
		if (isset($modpay_payoneer)) {
			if ($payname != '' || $payoneer_email != '') {
				$this->db->query("UPDATE user SET payname='" . $payname . "', paypal_email='" . $paypal_email . "', mode_of_pay='payoneer' WHERE username='" . $myusername . "'");
			}
		}
		if (isset($modpay_mobicash)) {
			if ($payname != '' || $mobicashid != '' || $mobile != '' || $mobicashemail != '') {
				$this->db->query("UPDATE user SET payname='" . $payname . "', paypal_email='" . $mobicashemail . "',paytm='" . $mobicashid . "', ifsc_code='" . $mobile . "', mode_of_pay='mobicash' WHERE username='" . $myusername . "'");
			}
		}
		if (isset($modpay_easypaisa)) {
			if ($payname != '' || $easypaisaid != '' || $mobile != '' || $easypaisaemail != '') {
				$this->db->query("UPDATE user SET payname='" . $payname . "', paypal_email='" . $easypaisaemail . "',paytm='" . $easypaisaid . "', ifsc_code='" . $mobile . "', mode_of_pay='easypaisa' WHERE username='" . $myusername . "'");
			}
		}
	}

	function getNextPost($postId, $user = NULL)
	{

		try {


			if ($user->team_role == 'owner') {
				$user_id = $user->id;
			} else {

				$sql = "SELECT * FROM user WHERE team_id=" . $user->team_id . " AND team_role = 'owner'";
				$owner_user = $this->db->query($sql)->row();
				$user_id = $owner_user->id;
			}

			if ($user->adv_priority == "custom") {
				$sql_QQ = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE u.status ='active' AND a.user_id = $user_id  AND u.user_id = " . $user->id;
				$query_QQ = $this->db->query($sql_QQ);
				$result_domains_QQ = $query_QQ->result_array();
				$all_domain_query = "";
				if ($result_domains_QQ) {
					foreach ($result_domains_QQ as $row) {
						$domainQQ = $search_keyword = trim($row['domain']);
						$all_domain_query .= " site_us_pc LIKE '%" . $domainQQ . "%' OR ";
					}
					$all_domain_query = substr($all_domain_query, 0, (strlen($all_domain_query) - 3));
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE ( " . $all_domain_query . " ) AND id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id desc LIMIT 1");
				} else {
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id desc LIMIT 1");
				}
			} else {
				$next_id_query = $this->db->query("SELECT id FROM link  WHERE  id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND user_id = $user_id  order by id desc LIMIT 1");
			}

			$next_id_row = $next_id_query->row();
			if ($next_id_row) {
				$next_id = $next_id_row->id;
			} else {
				$next_id = NULL;
			}
			return $next_id;
		} catch (Exception $x) {

			return false;
		}
	}

	function getNextPostRenew($postId, $page, $user)
	{
		try {
			if (!$page->domains_auto) {
				return false;
			} else {
				$page_domains = json_decode($page->domains_auto);
				$page_domains = implode(",", $page_domains);
				$sql = "SELECT * FROM articledomains WHERE id in (" . $page_domains . ")";
				$query_domains = $this->db->query($sql);
				$result_domains = $query_domains->result_array();
				$domain_selected_query = "";
				foreach ($result_domains as $row) {
					$domain_selected = trim($row['domain']);
					$domain_selected_query .= " site_us_pc LIKE '%" . $domain_selected . "%' OR ";
				}
				$domain_selected_query = substr($domain_selected_query, 0, (strlen($domain_selected_query) - 3));
			}
			if ($user->team_role == 'owner') {
				$user_id = $user->id;
			} else {
				$sql = "SELECT * FROM user WHERE team_id=" . $user->team_id . " AND team_role = 'owner'";
				$owner_user = $this->db->query($sql)->row();
				$user_id = $owner_user->id;
			}
			if ($user->adv_priority == "custom") {
				$sql_QQ = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE u.status ='active' AND a.user_id = $user_id  AND u.user_id = " . $user->id . " AND a.id in (" . $page_domains . ")";
				$query_QQ = $this->db->query($sql_QQ);
				$result_domains_QQ = $query_QQ->result_array();
				$all_domain_query = "";
				if ($result_domains_QQ) {
					foreach ($result_domains_QQ as $row) {
						$domainQQ = $search_keyword = trim($row['domain']);
						$all_domain_query .= " site_us_pc LIKE '%" . $domainQQ . "%' OR ";
					}
					$all_domain_query = substr($all_domain_query, 0, (strlen($all_domain_query) - 3));
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE ( " . $all_domain_query . " ) AND id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id desc LIMIT 1");
					// $next_id_query = $this->db->query("SELECT id FROM link  WHERE ( " . $all_domain_query . " ) AND id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND id not in (SELECT post_id from sceduler WHERE user_id = $user->id AND page_id = $page->id) AND user_id = $user_id order by id desc LIMIT 1");
				}
			} else {
				$next_id_query = $this->db->query("SELECT id FROM link  WHERE  ( " . $domain_selected_query . " ) AND id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id desc LIMIT 1");
				// $next_id_query = $this->db->query("SELECT id FROM link  WHERE  ( " . $domain_selected_query . " ) AND id  < " . $postId . " AND deleted = 'F' AND status = 'enable' AND user_id = $user_id AND id not in (SELECT post_id from sceduler WHERE user_id = $user->id AND page_id = $page->id) order by id desc LIMIT 1");
			}
			$next_id = null;
			if (isset($next_id_query)) {
				$next_id_row = $next_id_query->row();
				if ($next_id_row) {
					$next_id = $next_id_row->id;
				} else {
					$next_id = NULL;
				}
			}
			return $next_id;
		} catch (Exception $x) {

			return false;
		}
	}


	function getLastID()
	{

		$next_id_query = $this->db->query("SELECT id FROM link WHERE deleted = 'F' AND status = 'enable' order by id desc LIMIT 1");
		$next_id_row = $next_id_query->row();
		$next_id = $next_id_row->id;
		return $next_id;
	}


	function getLAST_ID($user, $page_id, $type = null)
	{
		try {
			if ($type == 'facebook') {
				$page = $this->retrieve_record('facebook_pages', $page_id);
			} elseif ($type == 'pinterest') {
				$page = $this->retrieve_record('pinterest_boards', $page_id);
			} else {
				$page = $this->retrieve_record('facebook_pages', $page_id);
			}
			if (!$page->domains_auto) {
				return false;
			} else {

				$page_domains = json_decode($page->domains_auto);
				$page_domains = implode(",", $page_domains);
				$sql = "SELECT * FROM articledomains WHERE id in (" . $page_domains . ")";
				$query_domains = $this->db->query($sql);
				$result_domains = $query_domains->result_array();
				$domain_selected_query = "";
				foreach ($result_domains as $row) {
					$domain_selected = trim($row['domain']);
					$domain_selected_query .= " site_us_pc LIKE '%" . $domain_selected . "%' OR ";
				}
				$domain_selected_query = substr($domain_selected_query, 0, (strlen($domain_selected_query) - 3));
			}

			if ($user->team_role == 'owner') {
				$user_id = $user->id;
			} else {
				$sql = "SELECT * FROM user WHERE team_id=" . $user->team_id . " AND team_role = 'owner'";
				$owner_user = $this->db->query($sql)->row();
				$user_id = $owner_user->id;
			}
			if ($user->adv_priority == "custom") {

				$sql_QQ = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE u.status ='active' AND a.user_id = $user_id  AND u.user_id = " . $user->id . " AND a.id in (" . $page_domains . ")";
				$query_QQ = $this->db->query($sql_QQ);
				$result_domains_QQ = $query_QQ->result_array();
				$all_domain_query = "";
				foreach ($result_domains_QQ as $row) {
					$domainQQ = $search_keyword = trim($row['domain']);
					$all_domain_query .= " site_us_pc LIKE '%" . $domainQQ . "%' OR ";
				}

				$all_domain_query = substr($all_domain_query, 0, (strlen($all_domain_query) - 3));
				if ($all_domain_query) {
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE ( " . $all_domain_query . " )  AND deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id desc LIMIT 1");
				} else {
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE  deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id desc LIMIT 1");
				}
			} else {
				if ($domain_selected_query) {
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE  ( " . $domain_selected_query . " ) AND deleted = 'F' AND status = 'enable' AND user_id = $user_id  order by id desc LIMIT 1");
				}
				// $next_id_query = $this->db->query("SELECT id FROM link  WHERE   deleted = 'F' AND status = 'enable' AND user_id = $user_id  order by id desc LIMIT 1");
			}
			if ($next_id_query) {
				$next_id_row = $next_id_query->row();
				if (isset($next_id_row->id)) {
					$next_id = $next_id_row->id;
					return $next_id;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (Exception $x) {
			return false;
		}
	}

	function getFirstID($user, $page_id, $type = null)
	{
		try {
			if ($type == 'facebook') {
				$page = $this->retrieve_record('facebook_pages', $page_id);
			} elseif ($type == 'pinterest') {
				$page = $this->retrieve_record('pinterest_boards', $page_id);
			} else {
				$page = $this->retrieve_record('facebook_pages', $page_id);
			}
			if (!$page->domains_auto) {
				return false;
			} else {
				$page_domains = json_decode($page->domains_auto);
				$page_domains = implode(",", $page_domains);
				$sql = "SELECT * FROM articledomains WHERE id in (" . $page_domains . ")";
				$query_domains = $this->db->query($sql);
				$result_domains = $query_domains->result_array();
				$domain_selected_query = "";
				foreach ($result_domains as $row) {
					$domain_selected = trim($row['domain']);
					$domain_selected_query .= " site_us_pc LIKE '%" . $domain_selected . "%' OR ";
				}
				$domain_selected_query = substr($domain_selected_query, 0, (strlen($domain_selected_query) - 3));
			}
			if ($user->team_role == 'owner') {
				$user_id = $user->id;
			} else {
				$sql = "SELECT * FROM user WHERE team_id=" . $user->team_id . " AND team_role = 'owner'";
				$owner_user = $this->db->query($sql)->row();
				$user_id = $owner_user->id;
			}
			if ($user->adv_priority == "custom") {
				$sql_QQ = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN user_cdomains as u  on a.id = u.domain_id WHERE u.status ='active'  AND a.user_id = $user_id  AND u.user_id = " . $user->id . " AND a.id in (" . $page_domains . ")";
				$query_QQ = $this->db->query($sql_QQ);
				$result_domains_QQ = $query_QQ->result_array();
				$all_domain_query = "";
				foreach ($result_domains_QQ as $row) {
					$domainQQ = $search_keyword = trim($row['domain']);
					$all_domain_query .= " site_us_pc LIKE '%" . $domainQQ . "%' OR ";
				}
				$all_domain_query = substr($all_domain_query, 0, (strlen($all_domain_query) - 3));
				$next_id_query = "";
				if ($all_domain_query) {
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE ( " . $all_domain_query . " )  AND deleted = 'F' AND status = 'enable' AND user_id = $user_id order by id asc LIMIT 1");
				}
			} else {

				if ($domain_selected_query) {
					$next_id_query = $this->db->query("SELECT id FROM link  WHERE  ( " . $domain_selected_query . " ) AND deleted = 'F' AND status = 'enable' AND user_id = $user_id  order by id asc LIMIT 1");
				}
			}
			if ($next_id_query) {
				$next_id_row = $next_id_query->row();
				if (isset($next_id_row->id)) {
					$next_id = $next_id_row->id;
					return $next_id;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} catch (Exception $x) {
			return false;
		}
	}
	function check_username($username)
	{

		$sql = "SELECT * FROM `user` WHERE `username`= '" . $username . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
	}
	function check_email($email)
	{

		$sql = "SELECT * FROM `user` WHERE `email`= '" . $email . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	function check_page($table, $where = null)
	{

		$this->db->select('*')->from($table)->where('page_id', $where['id'])->where('user_id', $where['user_id']);
		$query = $this->db->get()->result_array();
		return $query;
	}

	function create_record($table, $params = null)
	{
		// print_r($params);
		// $params = $this->_check_array_keys( $params, $this->field_keys );
		foreach ($params as $key => $value) {
			$this->db->set($key, $value);
		}
		// $this->db->set( 'created_datetime', "NOW()", FALSE );
		// $this->db->set( 'modified_datetime', "NOW()", FALSE );
		$this->db->insert($table);
		return $this->db->insert_id();
	}

	function update_active_deactive_status($table, $params = null)
	{

		$this->db->select('id')->from($table);
		$this->db->where('page_id', $params['id']); // $params['id'] stands for either page_id, board_id, fb_page_id(insta_id) or group_id
		$this->db->where('user_id', $params['user_id']);
		$primary_id = $this->db->get()->result_array();
		$primary_id = $primary_id[0]['id'];
		if (!empty($primary_id)) {
			$this->db->where('page_id', $params['id']); // $params['id'] stands for either page_id, board_id, fb_page_id(insta_id) or group_id
			$this->db->where('user_id', $params['user_id']);
			$this->db->set('page_name', $params['name']); // $params['name'] stands for either page_name, board_name, fb_page_name, group_name
			$this->db->set('access_token', $params['access_token']);
			$this->db->set('active_deactive_status', 1);
			if ($this->db->update($table)) {
				return $primary_id;
			} else {
				return false;
			}
		}
	}

	// create or update record
	function create_or_update_record($table, $params = null, $where = null)
	{
		if (is_array($where)) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		} else {
			$this->db->where($where);
		}

		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			$this->db->where($where);
			$this->db->set('active_deactive_status', 1);
			$this->db->update($table, $params);
			return $query->row()->id;
		} else {
			return $this->create_record($table, $params);
		}
	}

	function retrieve_record($table, $id = null, $where = null, $orderBy = null, $order = null)
	{
		if (isset($where["key"])) {
			$this->db->where($where["key"], $where["value"]);
		} elseif ($where) {
			foreach ($where as $where_item) {
				$this->db->where($where_item["key"], $where_item["value"]);
			}
		}
		if ($orderBy != null) {
			$this->db->order_by($orderBy, $order);
		}
		$query = $this->db->get_where($table, array('id' => $id), 1);
		return $query->row();
	}
	function update_record_mc($table, $params = null, $where = null)
	{
		if (isset($where["key"])) {

			$this->db->where($where["key"], $where["value"]);
		} elseif ($where) {
			foreach ($where as $where_item) {
				$this->db->where($where_item["key"], $where_item["value"]);
			}
		}
		$this->db->update($table, $params);
		return $this->db->affected_rows();
	}
	function update_bulkupload($table, $params = null, $where = null)
	{
		if (is_array($params) && count($params) > 0) {
			foreach ($params as $key => $value) {
				$this->db->set($key, $value);
			}
		}
		if (is_array($where) && count($where) > 0) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->update($table);
		return $this->db->affected_rows();
	}
	function update_record($table, $params = null, $id = null)
	{
		// $params["modified_datetime"] = "NOW()";
		$this->db->where('id', $id);
		$this->db->update($table, $params);
		return $this->db->affected_rows();
	}
	function delete_record($table, $id = null)
	{
		$this->db->delete($table, array('id' => $id));
		return $this->db->affected_rows();
	}
	function delete_where($table, $where)
	{
		$result = '';
		if ($where != NULL) {
			foreach ($where as $key => $val) {
				$this->db->where($key, $val);
			}
			$result = $this->db->delete($table);
		}
		return $result;
	}

	public function renewAutoPostsList($page_id, $type = null)
	{
		if ($type == 'facebook') {
			$page = $this->retrieve_record('facebook_pages', $page_id);
		} elseif ($type == 'pinterest') {
			$page = $this->retrieve_record('pinterest_boards', $page_id);
		} else {
			$page = $this->retrieve_record('facebook_pages', $page_id);
		}
		$user = $this->retrieve_record('user', $page->user_id);
		if ($page->auto_posting == "on") {
			$selected_domains = json_decode($page->domains_auto, true);
			if (count($selected_domains) > 0) {
				$this_post_id = !empty($page->last_post_id) ? $page->last_post_id : 0;
				$slots = !empty($page->time_slots_auto) ? json_decode($page->time_slots_auto) : [];
				$where_scheduled = [
					['key' => 'page_id', 'value' => $page_id],
					['key' => 'user_id', 'value' => $page->user_id],
				];
				$already_scheduled = $this->count_records('sceduler', $where_scheduled);
				$fortill = count($slots) - $already_scheduled;
				if ($fortill > 0) {
					for ($i = 0; $i < $fortill; $i++) {
						$postId = $this->getNextPostRenew($this_post_id, $page, $user);
						if (!$postId) {
							$postId = $this->getLAST_ID($user, $page_id, $type);
							if (!$postId) {
								continue;
							}
						}
						$post = $this->retrieve_record('link', $postId);
						$next_time = $this->getNextPostTime('sceduler', $page->user_id, $page_id, $page->time_slots_auto);
						$sceduler_data = [];
						$sceduler_data['post_id'] = $postId;
						$sceduler_data['page_id'] = $page_id;
						$sceduler_data['post_title'] = $post->text;
						$sceduler_data['user_id'] = $user->id;
						$sceduler_data['link'] = get_cp_link($postId, $user, $post->site_us_pc);
						$sceduler_data['type'] = $type;
						$sceduler_data['post_datetime'] = $next_time;
						$result = $this->create_record('sceduler', $sceduler_data);
						$this_post_id = $postId;
						$page_data['last_post_id'] = $postId;
						if ($type == 'facebook') {
							$this->update_record('facebook_pages', $page_data, $page_id);
						} elseif ($type == 'pinterest') {
							$this->update_record('pinterest_boards', $page_data, $page_id);
						}
					}
				}
			} else {
				$page_data['last_post_id'] = null;
				$this->update_record('facebook_pages', $page_data, $page_id);
			}
		}
	}
	public function delete_autopostsingle($postId, $type = null)
	{
		$post = $this->retrieve_record('sceduler', $postId);
		if ($type == 'facebook' || empty($type)) {
			$page = $this->retrieve_record('facebook_pages', $post->page_id);
		} elseif ($type == 'pinterest') {
			$page = $this->retrieve_record('pinterest_boards', $post->page_id);
		}
		$user = $this->retrieve_record('user', $post->user_id);
		$this_post_id = !empty($page->last_post_id) ? $page->last_post_id : 0;
		$postId_new = $this->getNextPostRenew($this_post_id, $page, $user);
		$post_new = $this->retrieve_record('link', $postId_new);
		$sceduler_data = [];
		$sceduler_data['post_id'] = $postId_new;
		$sceduler_data['post_title'] = $post_new->text;
		$sceduler_data['link'] = get_cp_link($postId, $user, $post_new->site_us_pc);
		$result = $this->update_record('sceduler', $sceduler_data, $postId);
		$page_data['last_post_id'] = $postId_new;
		if ($type == 'facebook' || empty($type)) {
			$this->update_record('facebook_pages', $page_data, $post->page_id);
		} else {
			$this->update_record('pinterest_boards', $page_data, $post->page_id);
		}
		$new_result = [];
		$new_result['id'] = $postId;
		$new_result['img'] = $post_new->img;
		$new_result['text'] = $post_new->text;
		$new_result['link'] = $sceduler_data['link'];
		$new_result['post_date'] = utcToLocal($post->post_datetime, $user->gmt, "F j, Y, g:i a");
		$new_result['post_time'] = utcToLocal($post->post_datetime, $user->gmt, "H:i A");
		return $new_result;
	}

	public function managedomainsupdateauto()
	{

		$pageid = trim($_POST['page']);
		$type = $_POST['type'];
		$result = [];
		if (isset($_POST['domains'])) {
			if ($type == 'facebook') {
				$page = $this->retrieve_record('facebook_pages', $pageid);
			} elseif ($type == 'pinterest') {
				$page = $this->retrieve_record('pinterest_boards', $pageid);
			} else {
				$page = $this->retrieve_record('facebook_pages', $pageid);
			}
			$user = $this->retrieve_record('user', $page->user_id);
			//Get Higest ID from scheduled posts
			$last_scedule = $this->db->query("SELECT post_id from sceduler where page_id = $pageid order by post_id DESC LIMIT 1");
			if ($last_scedule->result()) {
				$this_post_id = $last_scedule->row()->post_id;
			} else {
				$this_post_id = $page->last_post_id;
				$first_id = $this->getFirstID($user, $pageid, $type);
				if ($this_post_id == $first_id || $this_post_id == NULL || $this_post_id == 0 || $this_post_id == "" || $this_post_id == 1) {
					$this_post_id = $this->getLAST_ID($user, $pageid, $type);
				}
			}

			$page_data['domains_auto'] = json_encode($_POST['domains']);
			$page_data['last_post_id'] = $this_post_id;
			if ($type == 'facebook') {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			} elseif ($type == 'pinterest') {
				$result = $this->update_record('pinterest_boards', $page_data, $pageid);
			} else {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			}
			$result_delete = $this->delete_multiple('sceduler', 'page_id', $pageid);
			$result_posting = $this->renewAutoPostsList($pageid, $type);
		} else {
			$result_delete = $this->delete_multiple('sceduler', 'page_id', $pageid);
			$page_data['domains_auto'] = NULL;
			$page_data['last_post_id'] = NULL;
			if ($type == 'facebook') {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			} elseif ($type == 'pinterest') {
				$result = $this->update_record('pinterest_boards', $page_data, $pageid);
			} else {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			}
		}
		return $result;
	}

	public function managetimeslotsupdateauto()
	{
		$pageid = trim($_POST['page']);
		$type = $_POST['type'];
		$result = [];
		if (isset($_POST['time_slots'])) {
			$time_slots = $_POST['time_slots'];
			$page_data['time_slots_auto'] = json_encode($time_slots);
			if ($type == 'facebook') {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			} elseif ($type == 'pinterest') {
				$result = $this->update_record('pinterest_boards', $page_data, $pageid);
			} else {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			}
			$this->delete_multiple('sceduler', 'page_id', $pageid);
			$this->renewAutoPostsList($pageid, $type);
		} else {
			$page_data['time_slots_auto'] = NULL;
			$page_data['last_post_id'] = NULL;
			if ($type == 'facebook') {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			} elseif ($type == 'pinterest') {
				$result = $this->update_record('pinterest_boards', $page_data, $pageid);
			} else {
				$result = $this->update_record('facebook_pages', $page_data, $pageid);
			}
			$this->delete_multiple('sceduler', 'page_id', $pageid);
		}
		return $result;
	}

	public function managetyoutubeimeslotsupdateauto()
	{
		$pageid = trim($_POST['page']);

		$result = [];
		if (isset($_POST['time_slots'])) {
			$page_data['channel_slots'] = json_encode($_POST['time_slots']);
			$result = $this->update_record('youtube_channels', $page_data, $pageid);
		} else {
			$page_data['channel_slots'] = NULL;
			$result = $this->update_record('youtube_channels', $page_data, $pageid);
		}
		return $result;
	}

	public function post_youtube_channel_slots($user_id, $id, $timeslots)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('youtube_channels');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_slots', $timeslots);
			$this->db->update('youtube_channels');
			return true;
		} else {
			return false;
		}
	}

	public function update_tiktok_timeslots($user_id, $id, $timeslots)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('tiktok');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_slots', $timeslots);
			$this->db->update('tiktok');
			return true;
		} else {
			return false;
		}
	}

	public function getNextPostTime($table, $userID, $page, $timeslots)
	{

		$time_slots_arr = json_decode($timeslots);
		$user = $this->retrieve_record('user', $userID);

		$time_slots_size = count($time_slots_arr);
		$last_time_slot_element = $time_slots_arr[$time_slots_size - 1];
		if ($table == "bulkupload") {
			$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND event_id = 0 AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
		} elseif ($table == "pinterest_scheduler") {
			$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE board_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		} elseif ($table == "instagram_scheduler") {
			$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE ig_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		} elseif ($table == "facebook_group_scheduler") {
			$last_scedule = $this->db->query("SELECT publish_datetime FROM $table WHERE fb_group_id = $page AND user_id = $userID ORDER BY publish_datetime DESC LIMIT 1");
		} else {
			$last_scedule = $this->db->query("SELECT post_datetime FROM $table WHERE page_id = $page AND user_id = $userID ORDER BY post_datetime DESC LIMIT 1");
		}

		$lastpostscheduled_already = "";
		if (count($last_scedule->result()) > 0) {
			$lastpostscheduled_already = @$last_scedule->row()->post_datetime;
			if ($table == "pinterest_scheduler" || $table == "instagram_scheduler" || $table == "facebook_group_scheduler") {
				$lastpostscheduled_already = @$last_scedule->row()->publish_datetime;
			}
		}

		$next_post_DT = "";
		$lastpostscheduled_local = localToUTC(date("Y-m-d H:i:s"), SERVER_TZ, "Y-m-d  H:i:s");
		//echo $lastpostscheduled_already ." ---- ". $lastpostscheduled_local."<br>";

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


		// echo $last_hour ."----".$last_time_slot_element."<br>";
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
		return localToUTC($next_post_date_time, $user->gmt, "Y-m-d  H:i:s");
	}
	function update_multiple($table, $params = null, $column = null, $id = null)
	{
		// $params["modified_datetime"] = "NOW()";
		$this->db->where($column, $id);
		$this->db->update($table, $params);
		return $this->db->affected_rows();
	}
	function delete_multiple($table, $column, $id)
	{
		$this->db->delete($table, array($column => $id));
		return $this->db->affected_rows();
	}
	function list_records($table, $offset = 0, $limit = 20, $where = null, $orderBy = null, $order = null)
	{
		if (isset($where["key"])) {
			$this->db->where($where["key"], $where["value"]);
		} elseif ($where) {
			foreach ($where as $where_item) {
				if (is_array($where_item['value'])) {
					$this->db->where_in($where_item["key"], $where_item["value"]);
				} else {
					$this->db->where($where_item["key"], $where_item["value"]);
				}
			}
		}
		if ($orderBy != null) {
			$this->db->order_by($orderBy, $order);
		}
		$query = $this->db->get($table, $limit, $offset);
		return $query->result();
	}

	function dataTable_list_records($table, $search, $offset = 0, $limit = 20, $where = null, $orderBy = null, $order = null, $date = null, $groupBy = null)
	{
		foreach ($where as $where_item) {
			$this->db->where($where_item["key"], $where_item["value"]);
		}
		if (!empty($date)) {
			$this->db->where('published_at >=', $date['start_date']);
			$this->db->where('published_at <=', $date['end_date']);
		}
		if (!empty($search)) {
			$this->db->like('post_title', $search);
			$this->db->or_where('post_id', $search);
		}
		if ($orderBy != null) {
			$this->db->order_by($orderBy, $order);
		}
		if ($groupBy != null) {
			$this->db->group_by($groupBy);
		}
		$query = $this->db->get($table, $limit, $offset);
		return $query->result();
	}

	function get_page_insights($pages, $date, $insight = null)
	{
		if (empty($insight)) {
			// $this->db->select_sum('total_followers');
			$this->db->select_sum('total_reach');
			$this->db->select_sum('total_engagements');
			$this->db->select_sum('total_video_views');
			$this->db->select('published_at');
			$this->db->where_in('page_id', $pages);
			$this->db->where('published_at >=', $date['start_date']);
			$this->db->where('published_at <=', $date['end_date']);
			// $this->db->group_by('published_at');
			$this->db->order_by('published_at', 'ASC');
			$query = $this->db->get('facebook_page_daily_insights');
			$insights = $query->result();
		} elseif ($insight == 'followers') {
			$this->db->select('total_followers');
			$this->db->where_in('page_id', $pages);
			$this->db->order_by('published_at', 'DESC');
			$this->db->limit('1');
			$query = $this->db->get('facebook_page_daily_insights');
			$insights = $query->result();
		}
		return $insights;
	}

	function tiktok_post_insights($pages, $date)
	{
		if (empty($insight)) {
			// $this->db->select_sum('total_followers');
			$this->db->select_sum('view_count');
			$this->db->select_sum('like_count');
			$this->db->select_sum('comment_count');
			$this->db->select_sum('share_count');
			$this->db->select('published_at');
			$this->db->where_in('tiktok_id', $pages);
			$this->db->where('published_at >=', $date['start_date']);
			$this->db->where('published_at <=', $date['end_date']);
			// $this->db->group_by('published_at');
			$this->db->order_by('published_at', 'ASC');
			$query = $this->db->get('tiktok_posts');
			$insights = $query->result();
		}
		return $insights;
	}

	function get_post_insights($pages, $date, $type = null)
	{
		$this->db->select_sum('ctr');
		$this->db->select_sum('eng_rate');
		$this->db->select_sum('reach_rate');
		$this->db->select('published_at');
		if ($type == 'link_clicks') {
			$this->db->select_sum('link_clicks');
			$this->db->where('type', 'Link');
		}
		if ($type == 'video_views') {
			$this->db->select_sum('video_views');
			$this->db->where('type', 'Video');
		}
		$this->db->where_in('page_id', $pages);
		$this->db->where('published_at >=', $date['start_date']);
		$this->db->where('published_at <=', $date['end_date']);
		// $this->db->group_by('published_at');
		$this->db->order_by('published_at', 'ASC');
		$query = $this->db->get('facebook_posts');
		$insights = $query->result();
		return $insights;
	}

	function get_posts_insights_sum($type, $where, $date)
	{
		$this->db->select($type);
		if (!empty($date)) {
			$this->db->where('published_at >=', $date['start_date']);
			$this->db->where('published_at <=', $date['end_date']);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->from('facebook_posts');
		$data = $this->db->get();
		$response = $data->result_array();
		$total_count = [];
		foreach ($response as $key => $value) {
			foreach ($value as $count) {
				$total_count[$key] = $count;
			}
		}
		return $total_count;
	}

	function count_records($table, $where = NULL)
	{
		if ($where != NULL) {
			foreach ($where as $where_item) {
				// if ($where_item['key'] == 'url') {
				// 	$this->db->like('url', $where_item["value"]);
				// } else {
				// 	$this->db->where($where_item["key"], $where_item["value"]);
				// }
				$this->db->where($where_item["key"], $where_item["value"]);
			}
		}
		$this->db->from($table);
		return $this->db->count_all_results();
	}
	private function _check_array_keys($table, $params, $validator)
	{
		foreach ($params as $key => $val) {
			if (!in_array($key, $validator)) {
				unset($params[$key]);
			}
		}
		return $params;
	}

	public function campaign_click_earn($username)
	{
		$user_id = App::Session()->get('userid');

		$this->db->select('cpid,text, SUM(earn) as Earn, count(click.cpid) as click,img');
		$this->db->group_by('cpid');
		$this->db->from('click');
		$this->db->join('link', 'click.cpid = link.id');
		$this->db->order_by('click', 'desc');
		$this->db->where('click.user', $username);
		$this->db->limit(10);
		$click_query = $this->db->get()->result_array();
		// if($click_query){
		foreach ($click_query as $key => $value) {
			$this->db->select('campaign_id,SUM(earning) as Earn, total_click as click');
			$this->db->from('revenue');
			$this->db->where('user_id', $user_id);
			$this->db->where('campaign_id', $value['cpid']);
			$revenue_query = $this->db->get()->row_array();

			if (isset($revenue_query['Earn'])) {
				$click_query[$key]['Earn'] = $value['Earn'] + $revenue_query['Earn'];
				$click_query[$key]['click'] = cnf($value['click'] + $revenue_query['click'], 2);
			} else {
				$click_query[$key]['click'] = cnf($value['click'], 2);
			}
		}
		/* }else{
																																																																																																																															   $this->db->select('link.id,text, SUM(revenue.earning) as Earn, SUM(revenue.total_click) as click,img');
																																																																																																																																$this->db->group_by('link.id');
																																																																																																																																$this->db->from('link');
																																																																																																																																$this->db->join('revenue','revenue.campaign_id = link.id');
																																																																																																																																$this->db->order_by('click', 'desc');
																																																																																																																																$this->db->where('revenue.user_id',$user_id);
																																																																																																																																$this->db->limit(10);
																																																																																																																																$click_query=$this->db->get()->result_array();
																																																																																																																														}*/
		//  echo "<pre>";
		//   print_r($click_query);die();
		return $click_query;
	}
	public function show_table($start, $end, $username = NULL)
	{
		$user_id = App::Session()->get('userid');
		$this->db->select('cpid,text, SUM(earn) as earn, count(click.cpid) as click , count(click.cpid) as vclick, img');
		$this->db->group_by('cpid');
		$this->db->from('click');
		$this->db->join('link', 'click.cpid = link.id');
		$this->db->order_by('click', 'desc');
		if ($username) {
			$this->db->where('click.user', $username);
		}

		$this->db->where('date >=', $start);
		$this->db->where('date <=', $end);
		//$this->db->limit(3);
		$query = $this->db->get();
		$click_query = $query->result_array();
		if (strtotime($start) < strtotime('-30 days')) {
			if ($username) {
				$sql_r = "select c.id as cpid , c.text , round(sum(r.earning),4) earn  , sum(r.total_click) as click , sum(r.total_click) as vclick , c.img  from revenue as r , link as c where r.campaign_id = c.id AND  r.user_id = " . $user_id . " group by r.campaign_id order by click desc";
			} else {
				$sql_r = "select c.id as cpid , c.text , round(sum(r.earning),4) earn  , sum(r.total_click) as click , sum(r.total_click) as vclick , c.img  from revenue as r , link as c where r.campaign_id = c.id group by r.campaign_id order by click desc";
			}
			$query_r = $this->db->query($sql_r);
			$result_r = $query_r->result_array();
			$sum = array_mesh_campaign($click_query, $result_r);
			return $sum;
		}

		return $click_query;
	}
	public function owner_show_table($start, $end, $username = NULL)
	{
		$user_id = App::Session()->get('userid');
		$this->db->select('cpid,text, SUM(earn) as earn, count(click.cpid) as click , count(click.cpid) as vclick, img');
		$this->db->group_by('cpid');
		$this->db->from('click')->where('link.user_id', $user_id);
		$this->db->join('link', 'click.cpid = link.id');
		$this->db->order_by('click', 'desc');
		if ($username) {
			$this->db->where('click.user', $username);
		}

		$this->db->where('date >=', $start);
		$this->db->where('date <=', $end);
		//$this->db->limit(3);
		$query = $this->db->get();
		$click_query = $query->result_array();
		if (strtotime($start) < strtotime('-30 days')) {
			if ($username) {
				$sql_r = "select c.id as cpid , c.text , round(sum(r.earning),4) earn  , sum(r.total_click) as click , sum(r.total_click) as vclick , c.img  from revenue as r , link as c where r.campaign_id = c.id AND  r.user_id = " . $user_id . " AND  c.user_id = " . $user_id . "  group by r.campaign_id order by click desc";
			} else {
				$sql_r = "select c.id as cpid , c.text , round(sum(r.earning),4) earn  , sum(r.total_click) as click , sum(r.total_click) as vclick , c.img  from revenue as r , link as c where r.campaign_id = c.id AND c.user_id = " . $user_id . "  group by r.campaign_id order by click desc";
			}
			$query_r = $this->db->query($sql_r);
			$result_r = $query_r->result_array();
			$sum = array_mesh_campaign($click_query, $result_r);
			return $sum;
		}

		return $click_query;
	}
	public function owner_specific_country_click($cpid, $user = NULL, $start = null, $end = null)
	{

		$user_id = App::Session()->get('userid');
		$this->db->select('country,code, SUM(earn) as earn, count(earn) as click , cpid');
		$this->db->from('click');
		if ($user) {
			$user_id = App::Session()->get('userid');
			$this->db->where('user', $user);
		}
		$this->db->where('cpid', $cpid);
		$this->db->group_by('cpid,country');
		$this->db->order_by('click', 'desc');
		$this->db->join('country', 'country.name=click.country');
		$this->db->where('date >=', $start);
		$this->db->where('date <=', $end);
		$query = $this->db->get();
		$click_query = $query->result_array();

		if (strtotime($start) < strtotime('-30 days')) {
			if ($user) {
				$sql_r = "select c.name as country , c.code,  round(sum(r.earning),4) earn  , sum(r.total_click) as click , r.campaign_id as cpid from revenue as r , country as c where r.country = c.name AND r.campaign_id=" . $cpid . "  AND r.user_id = " . $user_id . " group by country order by earn desc";
			} else {
				$sql_r = "select c.name as country , c.code,  round(sum(r.earning),4) earn  , sum(r.total_click) as click , r.campaign_id as cpid from revenue as r , country as c where r.country = c.name AND r.campaign_id=" . $cpid . "  group by country order by earn desc";
			}
			$query_r = $this->db->query($sql_r);
			$result_r = $query_r->result_array();
			$sum = array_mesh_country($click_query, $result_r);
			return $sum;
		}
		return $click_query;
	}
	public function specific_country_click($cpid, $user = NULL, $start = null, $end = null)
	{

		$this->db->select('country,code, SUM(earn) as earn, count(earn) as click , cpid');
		$this->db->from('click');
		if ($user) {
			$user_id = App::Session()->get('userid');
			$this->db->where('user', $user);
		}
		$this->db->where('cpid', $cpid);
		$this->db->group_by('cpid,country');
		$this->db->order_by('click', 'desc');
		$this->db->join('country', 'country.name=click.country');
		$this->db->where('date >=', $start);
		$this->db->where('date <=', $end);
		$query = $this->db->get();
		$click_query = $query->result_array();

		if (strtotime($start) < strtotime('-30 days')) {
			if ($user) {
				$sql_r = "select c.name as country , c.code,  round(sum(r.earning),4) earn  , sum(r.total_click) as click , r.campaign_id as cpid from revenue as r , country as c where r.country = c.name AND r.campaign_id=" . $cpid . "  AND r.user_id = " . $user_id . " group by country order by earn desc";
			} else {
				$sql_r = "select c.name as country , c.code,  round(sum(r.earning),4) earn  , sum(r.total_click) as click , r.campaign_id as cpid from revenue as r , country as c where r.country = c.name AND r.campaign_id=" . $cpid . "  group by country order by earn desc";
			}
			$query_r = $this->db->query($sql_r);
			$result_r = $query_r->result_array();
			$sum = array_mesh_country($click_query, $result_r);
			return $sum;
		}
		return $click_query;
	}
	function getcountrywise($rangedata)
	{
		if ($rangedata['start'] != "" || $rangedata['end'] != "") {
			$team_id = App::Session()->get('team_id');
			$myusername = $rangedata['username'];
			if ($myusername) {
				$sql = "SELECT * FROM user WHERE username='$myusername'";
				$uresult = $this->db->query($sql)->row();
				$user_id = $uresult->id;
				$start = $rangedata['start'];
				$end = $rangedata['end'];
				$sql = "select  a.country as country , b.code , count(a.earn) as click , round(sum(a.earn), 3) as earn from click as a , country as b where a.user = '$myusername' AND a.date >= DATE('$start')  AND  a.date <= DATE('$end') AND a.country = b.name group by a.country order by earn desc";
				$query = $this->db->query($sql);
				$result = $query->result_array();

				if (strtotime($start) < strtotime('-30 days')) {
					$sql_r = "select c.name as country , c.code,  round(sum(r.earning),4) earn  , sum(r.total_click) as click from revenue as r , country as c where r.country =c.name AND  r.user_id = " . $user_id . " group by country order by earn desc";
					$query_r = $this->db->query($sql_r);
					$result_r = $query_r->result_array();
					$sum = array_mesh_country($result, $result_r);
					return $sum;
				}
			} else {
				$start = $rangedata['start'];
				$end = $rangedata['end'];
				$sql = "select  a.country as country , b.code , count(a.earn) as click , round(sum(a.earn), 3) as earn from click as a , country as b where a.user in(SELECT username from user where team_id = $team_id) AND a.date >= DATE('$start')  AND  a.date <= DATE('$end') AND a.country = b.name group by a.country order by earn desc";
				$query = $this->db->query($sql);
				$result = $query->result_array();
				if (strtotime($start) < strtotime('-30 days')) {
					$sql_r = "select c.name as country , c.code,  round(sum(r.earning),4) earn  , sum(r.total_click) as click from revenue as r , country as c where r.country =c.name AND  r.user_id in(SELECT id from user where team_id = $team_id) group by country order by earn desc";
					$query_r = $this->db->query($sql_r);
					$result_r = $query_r->result_array();
					$sum = array_mesh_country($result, $result_r);
					return $sum;
				}
			}


			return $result;
		}
		return false;
	}
	public function get_roles($user_id)
	{
		$this->db->select('menu_id,menu_name,status')->from('menu_assign')->where('user', $user_id);
		return ($this->db->join('menus', 'menus.id=menu_assign.menu_id')->get()->result_array());
	}

	public function get_active_roles($user_id)
	{
		$this->db->select('menu_id,menu_name,status')->from('menu_assign')->where('user', $user_id)->where('status', 'Active');
		return ($this->db->join('menus', 'menus.id=menu_assign.menu_id')->get()->result_array());
	}

	public function get_user_errors($user_id)
	{
		$this->db->select('*')->from('errors')->where('user_id', $user_id);
		return $this->db->get()->result_array();
	}

	public function update_roles($user_id, $roles)
	{
		for ($i = 0; $i < count($roles); $i++) {
			$this->db->set('status', $roles[$i]['status']);
			$this->db->where('user', $user_id);
			$this->db->where('menu_id', $roles[$i]['menu_id']);
			$this->db->update('menu_assign');
		}
		if ($this->db->affected_rows() >= 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_specific_role($role, $user_id)
	{
		$this->db->select('status')->from('menu_assign')->where('user', $user_id)->where('menu_name', $role);
		return ($this->db->join('menus', 'menus.id=menu_assign.menu_id')->get()->row());
	}

	public function check_valid($fb_profile, $fb_page, $name, $phone, $gmt)
	{

		if (strlen(trim($fb_profile)) > 0 && strlen(trim($fb_page)) > 0 && strlen(trim($name)) > 0 && strlen(trim($phone)) > 0 && strlen(trim($gmt))) {
			return true;
		} else {
			return false;
		}
	}

	public function get_gmt_status($gmt, $user_id)
	{
		$this->db->select('gmt');
		$this->db->from('user');
		return $this->db->where('id', $user_id)->get()->row()->gmt;
	}

	public function edit_announcement($id, $status, $text)
	{

		$this->db->set([

			'status' => $status,
			'text' => $text
		])->where('id', $id)->update('announce');

		if ($this->db->affected_rows() >= 0) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_announcement($id)
	{
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->delete('announce');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	public function create_announcement($text)
	{
		$data = ['status' => 'Active', 'text' => $text];
		$this->db->trans_start();
		$this->db->insert('announce', $data);
		$this->db->trans_complete();
		return ($this->db->trans_status() === FALSE) ? false : true;
	}

	public function get_active_announcements()
	{
		return $this->db->select('*')->from('announce')->where('status', 'Active')->get()->result_array();
	}

	public function get_latest_announcements()
	{
		$announces = $this->db->select('*')->from('announce')->order_by("id", "desc")->limit(5)->where('status', 'Active')->get()->result_array();
		return $announces;
	}

	public function get_latest_notifications()
	{

		$notifications = $this->db->select('*')->from('notifications')->order_by("id", "desc")->limit(20)->where('user_id', App::Session()->get('userid'))->get()->result_array();
		return $notifications;
	}

	public function get_notifications()
	{

		$notifications = $this->db->select('*')->from('notifications')->order_by("id", "desc")->where('user_id', App::Session()->get('userid'))->get()->result_array();
		return $notifications;
	}
	public function affiliateownertrafficsummary($team_id, $start, $end)
	{

		$users = [];
		if ($start < date('Y-m-d', strtotime("-1 week"))) {
			$this->db->select('user , user.fname as name , avatar as img ,count(earn) as count , SUM(earn) as earning');
			$this->db->from('click')->where('date >=', $start)->where('date <=', $end)->where('user.team_id =', $team_id);
			$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
			$click_query = $this->db->get()->result_array();

			$this->db->select('round(sum(R.earning),3) as earning,SUM(R.total_click) as count,U.username as user, U.fname as name,  U.avatar as img');
			$this->db->from('revenue R')->where('U.team_id =', $team_id);
			$this->db->join('user U', 'U.id = R.user_id');
			$this->db->group_by('U.username');
			$this->db->order_by('count', 'DESC');
			$revenue_result = $this->db->get()->result_array();

			$users = $revenue_result;
			foreach ($revenue_result as $key => $value) {
				foreach ($click_query as $click_key => $click_revenue) {
					if ($click_revenue['user'] == $value['user']) {
						$users[$key] = array('name' => $click_revenue['name'], 'user' => $click_revenue['user'], 'img' => $click_revenue['img'], 'count' => $click_revenue['count'] + $value['count'], 'earning' => $click_revenue['earning'] + $value['earning']);
						unset($click_query[$click_key]);
						break;
					}
				}
			}
			$users = array_merge_recursive($users, $click_query);
			$sort = array();
			foreach ($users as $k => $v) {
				$sort['earning'][$k] = $v['earning'];
			}
			if (isset($sort['earning']) && count($sort['earning']) > 0) {
				array_multisort($sort['earning'], SORT_DESC, $users);
			}
			return $users; //array_slice($users, 0, 10);

		} else {
			$this->db->trans_start();
			$this->db->select('user ,user.fname as name  ,count(earn) as count , SUM(earn) as earning');
			$this->db->from('click')->where('date >=', $start)->where('date <=', $end)->where('user.team_id =', $team_id);
			$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
			$data = $this->db->limit(10)->get()->result_array();
			return ($this->db->trans_complete() === false) ? false : $data;
		}
	}

	public function top_users($start, $end)
	{

		$users = [];
		if ($start < date('Y-m-d', strtotime("-1 week"))) {

			$this->db->select('user  ,img ,count(earn) as count , SUM(earn) as earning');
			$this->db->from('click')->where('date >=', $start)->where('date <=', $end);
			$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
			$click_query = $this->db->get()->result_array();

			$this->db->select('round(sum(R.earning),3) as earning,SUM(R.total_click) as count,U.username as user,U.img');
			$this->db->from('revenue R');
			$this->db->join('user U', 'U.id = R.user_id');
			$this->db->group_by('U.username');
			$this->db->order_by('count', 'DESC');

			$revenue_result = $this->db->get()->result_array();
			$users = $revenue_result;
			foreach ($revenue_result as $key => $value) {
				foreach ($click_query as $click_key => $click_revenue) {
					if ($click_revenue['user'] == $value['user']) {
						$users[$key] = array('user' => $click_revenue['user'], 'img' => $click_revenue['img'], 'count' => $click_revenue['count'] + $value['count'], 'earning' => $click_revenue['earning'] + $value['earning']);
						unset($click_query[$click_key]);
						break;
					}
				}
			}
			$users = array_merge_recursive($users, $click_query);
			$sort = array();
			foreach ($users as $k => $v) {
				$sort['earning'][$k] = $v['earning'];
			}
			array_multisort($sort['earning'], SORT_DESC, $users);
			return $users; //array_slice($users, 0, 10);

		} else {

			$this->db->trans_start();
			$this->db->select('user  ,img ,count(earn) as count , SUM(earn) as earning');
			$this->db->from('click')->where('date >=', $start)->where('date <=', $end);
			$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
			$data = $this->db->limit(10)->get()->result_array();
			return ($this->db->trans_complete() === false) ? false : $data;
		}
		/* $this->db->trans_start();
																																																																																																																														$this->db->select('user  ,img ,count(earn) as count , SUM(earn) as earning');
																																																																																																																														$this->db->from('click')->where('date >=',$start)->where('date <=',$end);
																																																																																																																														$this->db->group_by('user')->join('user','user.username=click.user')->order_by('earning','desc');
																																																																																																																														$data=$this->db->limit(10)->get()->result_array();
																																																																																																																														return ($this->db->trans_complete()===false) ? false : $data;*/
	}

	public function identify_fraud($campaignid, $ip)
	{
		$end_time = date('Y-m-d H:i:s', strtotime('-24 hours', time()));
		return $this->db->select('*')->from('click')->where('cpid', $campaignid)->where('ip', $ip)->where('time >', $end_time)->count_all_results();
	}

	public function update_clicks($campaignid)
	{

		$this->db->where('id', $campaignid);
		$this->db->set('total_click', 'total_click+1', FALSE)->update('link');
	}

	public function change_announcement_seen($announce_id, $pub_id)
	{
		$data = array('seen' => '1',);
		$this->db->trans_start();
		$this->db->where('id', $announce_id)->where('Type', $pub_id)->update('announce', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	public function post_bulkschedule($userID, $page, $title, $img_path, $next_post_date_time, $event = 0)
	{

		$data = ['user_id' => $userID, 'page_id' => $page, 'post_title' => $title, 'event_id' => $event, 'link' => $img_path, 'post_datetime' => $next_post_date_time];
		$this->db->trans_start();
		$this->db->insert('bulkupload', $data);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
		// return $this->db->trans_status() ? true : false;

	}

	public function updateBulkSchedule($primary_id, $post_datetime)
	{
		$data = [
			'post_datetime' => $post_datetime
		];

		$this->db->trans_start();
		$this->db->where('id', $primary_id);
		$this->db->update('bulkupload', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			return true;
		} else {
			return false;
		}
	}


	public function post_rssschedule($userID, $page, $title, $img_path, $url, $post_date_time, $post_type = null)
	{
		$data = [
			'user_id' => $userID,
			'page_id' => $page,
			'post_title' => $title,
			'link' => $img_path,
			'url' => $url,
			'post_datetime' => $post_date_time,
			'post_type' => $post_type
		];
		$this->db->trans_start();
		$insert_query = $this->db->insert_string('rsssceduler', $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
	}

	public function post_tiktok_rssschedule($userID, $page, $title, $img_path, $url, $post_date_time, $post_type = null)
	{
		$data = [
			'user_id' => $userID,
			'tiktok_id' => $page,
			'post_title' => $title,
			'url' => $img_path,
			'link' => $url,
			'post_datetime' => $post_date_time,
			'post_type' => $post_type
		];
		$this->db->trans_start();
		$insert_query = $this->db->insert_string('tiktok_scheduler', $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
	}

	public function update_last_run($id, $column, $table)
	{
		$date = date("Y-m-d H:i:s");
		$this->db->where('id', $id);
		$this->db->update($table, array($column => $date));
	}

	public function update_rssschedule($primary_id, $post_date_time)
	{
		$data = [
			'post_datetime' => $post_date_time
		];
		$update_query = $this->db->update_string('rsssceduler', $data, ['id' => $primary_id]);

		$this->db->query($update_query);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function post_igbulkschedule($userID, $type, $title, $img_path, $next_post_date_time)
	{

		$data = [
			'user_id' => $userID,
			'post_type' => $type,
			'post_title' => $title,
			'link' => $img_path,
			'post_datetime' => $next_post_date_time

		];
		$this->db->trans_start();
		$this->db->insert('igbulkupload', $data);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
		// return $this->db->trans_status() ? true : false;

	}

	public function get_user_articles($userid)
	{

		return $this->db->select('*')->from('article')->order_by('id', 'desc')->where('user_id', $userid)->get()->result_array();
	}

	public function get_article_content($article_id)
	{

		$user_id = App::Session()->get('userid');
		return $this->db->select('*')->from('article')->where('id', $article_id)->where('user_id', $user_id)->get()->row();
	}

	public function update_article($title, $content, $article_id, $category, $tags, $image_path)
	{
		$data = ['title' => $title, 'content' => $content, 'category' => $category, 'tags' => $tags, 'image' => $image_path, 'status' => 'resubmitted'];
		$this->db->trans_start();
		$this->db->where('id', $article_id);
		$this->db->update('article', $data);
		$this->db->trans_complete();
		return $this->db->trans_status() === FALSE ? false : true;
	}

	public function delete_article($article_id)
	{

		$this->db->where('id', $article_id);
		$this->db->delete('article');
		if ($this->db->affected_rows() == '1') {
			return true;
		} else {
			return false;
		}
	}
	public function already_save_filter($user_id)
	{
		$this->db->select('popularity,domain,cat');
		$this->db->from('user_settings');
		$this->db->where('user_id', $user_id);
		return $this->db->get()->row();
	}
	public function update_save_filter($user_id, $data)
	{
		$this->db->set('popularity', $data['popularity']);
		$this->db->set('domain', $data['domain']);
		$this->db->set('cat', $data['cat']);
		$this->db->where('user_id', $user_id);
		$this->db->update('user_settings');
		return ($this->db->affected_rows() > 0) ? true : false;
	}
	public function save_filter($user_id, $data)
	{
		$this->db->set('popularity', $data['popularity']);
		$this->db->set('domain', $data['domain']);
		$this->db->set('cat', $data['cat']);
		$this->db->set('user_id', $user_id);
		$this->db->insert('user_settings');
	}
	public function revenue_fetch()
	{
		$this->db->select('*');
		$this->db->from('click');
		$this->db->where('time < ', 'NOW()', FALSE);
		//$this->db->limit(20);
		$result = $this->db->get()->result_array();
		/*$result = $this->db->get()->num_rows();
																																																																																																																													 var_dump($result);die;*/

		foreach ($result as $value) {
			if (is_null($value['country'])) {
				var_dump($value['country']);
			}
			//print_r($value);die;
			$this->db->select('id');
			$this->db->from('user');
			$this->db->where('username', $value['user']);
			$user_id = $this->db->get()->row_array()['id'];

			$this->db->select('id');
			$this->db->from('country');
			$this->db->where('name', $value['country']);
			$country_id = $this->db->get()->row_array()['id'];

			$this->db->select('total_click');
			$this->db->from('link');
			$this->db->where('id', $value['cpid']);
			$total_click = $this->db->get()->row_array()['total_click'];

			$campaign_id = $value['cpid'];
			$earning = $value['earn'];
			//echo $this->db->last_query();die;


			$this->db->select('*');
			$this->db->from('revenue');
			$this->db->where('campaign_id', $campaign_id);
			$this->db->where('country_id', $country_id);
			$is_exist = $this->db->get()->num_rows;
			//var_dump($is_exist);die;
			if ($is_exist) {
				//update

				$this->db->set('earning', 'usage+' . $earning, FALSE);
				$this->db->set('total_click', $total_click);
				$this->db->update('revenue');
				//after update delete
				$this->db->where('user', $value['user']);
				$this->db->where('cpid', $campaign_id);
				$this->db->where('country', $value['country']);
				$this->db->where('time', $value['time']);
				$this->db->where('earn', $value['earn']);
				$this->db->where('property_id', $value['property_id']);
				$this->db->delete('click');
			} else {
				//insert
				if (is_null($country_id)) {
					var_dump($value['country']);
				}
				die;
				// $this->db->set('campaign_id', $campaign_id);
				// $this->db->set('user_id', $user_id);
				// $this->db->set('country_id', $country_id);
				// $this->db->set('earning', $earning);
				// $this->db->set('total_click', $total_click);
				// $this->db->insert('revenue');
				// //after Insert delete
				// $this->db->where('user', $value['user']);
				// $this->db->where('cpid', $campaign_id);
				// $this->db->where('country', $value['country']);
				// $this->db->where('time', $value['time']);
				// $this->db->where('earn', $value['earn']);
				// $this->db->where('property_id', $value['property_id']);
				// $this->db->delete('click');
			}
		}
	}

	function reset_password($email, $pass)
	{
		// Generate salt
		// $salt = bin2hex(random_bytes(16)); // Generate a random 16-byte binary string and convert to hex
		// // Generate hash with password_hash function
		// $hash = password_hash($pass . $salt, PASSWORD_DEFAULT);
		$salt = Utility::randNumbers();
		$hash = App::Auth()->create_hash($pass, $salt);
		// select data from database to check user exist or not?
		$sql = "SELECT * FROM `user` WHERE `email`= '" . $email . "'";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0) {
			$sqlupdate = "Update  `user` set hash='" . $hash . "', salt='" . $salt . "' WHERE `email`= '" . $email . "' ";
			$sqlupdatequery = $this->db->query($sqlupdate);
			return true;
		}
		return false;
	}
	/*	function reset_password($email, $pass)
																																																														   {
																																																															   $newpass = md5($pass);
																																																															   // select data from database to check user exist or not?
																																																															   $sql = "SELECT * FROM `user` WHERE `email`= '" . $email . "'";
																																																															   $query = $this->db->query($sql);
																																																															   //echo $this->db->last_query();die;
																																																															   if ($query->num_rows() > 0) {
																																																																   $sqlupdate = "Update  `user` set password='" . $newpass . "'   WHERE `email`= '" . $email . "' ";
																																																																   $sqlupdatequery = $this->db->query($sqlupdate);
																																																																   return true;
																																																															   }
																																																															   return false;
																																																														   }*/

	public function channel_settings($data)
	{

		$this->db->where('user_id', $data['user_id']);
		$q = $this->db->get('user_channel_settings');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $data['user_id']);
			$this->db->set('updated_at', date('Y-m-d H:i:s'));
			$this->db->update('user_channel_settings', $data);
		} else {
			$this->db->insert('user_channel_settings', $data);
		}
	}

	public function get_channel_settings($user_id)
	{
		$this->db->select('facebook, pinterest');
		$this->db->from('user_channel_settings');
		$this->db->where('user_id', $user_id);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function get_pinterest_login_url()
	{
		$client_id = PINTEREST_CLIENT_ID;
		$client_secret = PINTEREST_CLIENT_SECRET;
		$redirect_url = SITEURL . "pinterest_callback/";
		$pinterest = new Pinterest($client_id, $client_secret);
		$login_url = $pinterest->auth->getLoginUrl($redirect_url, array('boards:read', 'pins:read', 'boards:write', 'pins:write'));
		return $login_url;
	}

	public function get_pinterest_access_token()
	{
		$code = $_GET["code"];
		$redirect_uri = SITEURL . "pinterest_callback/";
		$client_id = PINTEREST_CLIENT_ID;
		$client_secret = PINTEREST_CLIENT_SECRET;
		$encoded = base64_encode("{$client_id}:{$client_secret}");
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
			CURLOPT_POSTFIELDS => 'grant_type=authorization_code&code=' . $code . '&redirect_uri=' . $redirect_uri . '&scope=boards:read,pins:read,boards:write,pins:write,user_accounts:read',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic ' . $encoded,
			),
		));
		$data = json_decode(curl_exec($curl), true);
		dd([$data]);
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if ($http_code != '200') {
			redirect(SITEURL . 'social-accounts');
			throw new Exception('Error : Failed to receieve access token');
		}
		$user_id = App::Session()->get('userid');
		$pinterest_data['user_id'] = $user_id;
		$pinterest_data['access_token'] = $data['access_token'];
		$pinterest_data['refresh_token'] = $data['refresh_token'];
		$pinterest_data['expires_in'] = $data['expires_in'];
		$pinterest_data['refresh_token_expires_in'] = $data['refresh_token_expires_in'];
		$pinterest_user = $this->get_allrecords('pinterest_users', array('user_id' => $user_id));
		if (count($pinterest_user) > 0) {
			$pinterest_user = $pinterest_user[0];
			$this->db->where('id', $pinterest_user->id);
			$this->db->set(['active' => 'y', 'updated_at' => date('Y-m-d H:i:s')]);
			$this->db->update('pinterest_users', $pinterest_data);
		} else {
			$this->db->insert('pinterest_users', $pinterest_data);
		}
		redirect(SITEURL . 'get_pinterest_boards/');
	}

	public function refresh_pinterest_access_token($refresh_token)
	{
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

		// Send the request and parse the response
		$data = json_decode(curl_exec($curl), true);
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		// if ($http_code != '200') {
		// 	throw new Exception('Error : '.$data['message'].'');
		// 	// throw new Exception('Error : Failed to refresh access token');
		// }
		return $data;
	}

	public function get_pinterest_boards()
	{
		$user_id = App::Session()->get('userid');
		$access_token = $this->db->select('access_token')->from('pinterest_users')->where('user_id', $user_id)->get()->row('access_token');
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.pinterest.com/v5/boards',
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
		$response = curl_exec($curl);
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		$boards = json_decode($response, true);
		if ($http_code != 200) {
			throw new Exception('Error : Failed to get user information');
		}
		$board_owner = "";
		if (isset($boards['items'])) {
			$boards = $boards['items'];
			$board_owner = isset($boards[0]['owner']['username']) ? $boards[0]['owner']['username'] : '';
			foreach ($boards as $board) {
				if (!limit_check(AUTHORIZE_SOCIAL_ACCOUNTS_ID, 2)) {
					continue;
				}
				$board_id = $board['id'];
				$board_name = $board['name'];
				$board_description = $board['description'];
				$board_privacy = $board['privacy'];
				$followers = $board['follower_count'];
				$pinterest_board = $this->get_allrecords('pinterest_boards', array('board_id' => $board_id, 'user_id' => $user_id));
				if (count($pinterest_board) > 0) {
					$pinterest_board = $pinterest_board[0];
					// update pinterest board
					$where = [
						['key' => 'id', 'value' => $pinterest_board->id]
					];
					$update = array(
						'name' => $board_name,
						'description' => $board_description,
						'follower_count' => $followers,
						'privacy' => $board_privacy,
						'active_deactive_status' => 1,
						'updated_at' => date('Y-m-d H:i:s')
					);
					$this->update_record_mc('pinterest_boards', $update, $where);
					$where = [
						['key' => 'user_id', 'value' => $user_id],
						['key' => 'channel_id', 'value' => $pinterest_board->id],
						['key' => 'type', 'value' => 'pinterest'],
					];
					$update = ['active_deactive_status' => '1'];
					$this->update_record_mc('channels_scheduler', $update, $where);
				} else {
					$data = [
						'user_id' => $user_id,
						'board_id' => $board_id,
						'name' => $board_name,
						'description' => $board_description,
						'follower_count' => $followers,
						'privacy' => $board_privacy
					];
					$this->db->insert('pinterest_boards', $data);
					resources_update('up', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
				}
			}
			$this->db->set('username', $board_owner);
			//start Updating username
			$this->db->where('user_id', $user_id);
			//$this->db->set('updated_at', date('Y-m-d H:i:s'));
			$this->db->update('pinterest_users');
			//ending Updating username
		}
	}

	public function post_pinterest_rssschedule($userID, $board_id, $title, $img_path, $url, $post_date_time, $post_type = null)
	{
		$data = [
			'user_id' => $userID,
			'board_id' => $board_id,
			'post_title' => $title,
			'image_link' => $img_path,
			'url' => $url,
			'publish_datetime' => $post_date_time,
			'post_type' => $post_type
		];
		$this->db->trans_start();
		$insert_query = $this->db->insert_string('pinterest_scheduler', $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
	}

	public function update_pinterest_rssschedule($primary_id, $publish_datetime)
	{
		$data = [
			'publish_datetime' => $publish_datetime
		];
		$update_query = $this->db->update_string('pinterest_scheduler', $data, ['id' => $primary_id]);

		$this->db->query($update_query);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function post_boards_channel_slots($user_id, $id, $timeslots)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('pinterest_boards');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('updated_at', date('Y-m-d H:i:s'));
			$this->db->set('channel_slots', $timeslots);
			$this->db->update('pinterest_boards');
			return true;
		} else {
			return false;
		}
	}

	public function post_fbpages_channel_slots($user_id, $id, $timeslots)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('facebook_pages');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_slots', $timeslots);
			$this->db->update('facebook_pages');
			return true;
		} else {
			return false;
		}
	}

	public function post_ig_channel_slots($user_id, $id, $timeslots)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('instagram_users');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_slots', $timeslots);
			$this->db->update('instagram_users');
			return true;
		} else {
			return false;
		}
	}

	public function post_fbgroup_channel_slots($user_id, $id, $timeslots)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('facebook_groups');
		if ($q->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_slots', $timeslots);
			$this->db->update('facebook_groups');
			return true;
		} else {
			return false;
		}
	}

	public function get_error_column_from_error_table($userID, $channel_name)
	{
		$this->db->select('error,date_time')->from('errors')->where('user_id', $userID)->where('channel_name', $channel_name)->where('status', 0);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_rss_error_links($table, $select_cols, $where)
	{
		$this->db->select($select_cols)->from($table)->where($where);
		$query = $this->db->get()->result_array();
		return $query;
	}

	public function get_channels_settings($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('active_deactive_status', 1);
		$q = $this->db->get('facebook_pages');
		if ($q->num_rows() > 0) {
			$fbpages = $q->result_array();
		} else {
			$fbpages = [];
		}

		$this->db->where('user_id', $user_id);
		$this->db->where('active_deactive_status', 1);
		$q = $this->db->get('pinterest_boards');
		if ($q->num_rows() > 0) {
			$boards = $q->result_array();
		} else {
			$boards = [];
		}

		$this->db->where(['user_id' => $user_id, 'active' => 'y']);
		$this->db->where('active_deactive_status', 1);
		$q = $this->db->get('instagram_users');
		if ($q->num_rows() > 0) {
			$ig_accounts = $q->result_array();
		} else {
			$ig_accounts = [];
		}

		$this->db->where(['user_id' => $user_id, 'active' => 'y']);
		$this->db->where('active_deactive_status', 1);
		$q = $this->db->get('facebook_groups');
		if ($q->num_rows() > 0) {
			$fb_groups = $q->result_array();
		} else {
			$fb_groups = [];
		}

		$this->db->where(['user_id' => $user_id, 'active' => '1']);
		$q = $this->db->get('youtube_channels');
		if ($q->num_rows() > 0) {
			$yt_channels = $q->result_array();
		} else {
			$yt_channels = [];
		}

		$this->db->where(['user_id' => $user_id]);
		$q = $this->db->get('tiktok');
		if ($q->num_rows() > 0) {
			$tiktoks = $q->result_array();
		} else {
			$tiktoks = [];
		}

		$data = [
			'fbpages' => $fbpages,
			'boards' => $boards,
			'ig_accounts' => $ig_accounts,
			'fb_groups' => $fb_groups,
			'yt_channels' => $yt_channels,
			'tiktoks' => $tiktoks
		];
		return $data;
	}

	// fb_channel_active
	public function fb_channel_active($user_id, $id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('facebook_pages')->row();

		if ($q->channel_active == 1) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$status = 0;
			$this->db->set('channel_active', $status);
			$this->db->update('facebook_pages');
			return true;
		} elseif ($q->channel_active == 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$status = 1;
			$this->db->set('channel_active', $status);
			$this->db->update('facebook_pages');
			return true;
		} else {
			return false;
		}
	}

	public function board_channel_active($user_id, $id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('pinterest_boards')->row();

		if ($q->channel_active == 1) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$status = 0;
			$this->db->set('channel_active', $status);
			$this->db->update('pinterest_boards');
			return true;
		} elseif ($q->channel_active == 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$status = 1;
			$this->db->set('channel_active', $status);
			$this->db->update('pinterest_boards');
			return true;
		} else {
			return false;
		}
	}

	public function ig_channel_active($user_id, $id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('instagram_users')->row();

		if ($q->channel_active == 1) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 0);
			$this->db->update('instagram_users');
			return true;
		} elseif ($q->channel_active == 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 1);
			$this->db->update('instagram_users');
			return true;
		} else {
			return false;
		}
	}

	public function fbgroup_channel_active($user_id, $id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('facebook_groups')->row();

		if ($q->channel_active == 1) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 0);
			$this->db->update('facebook_groups');
			return true;
		} elseif ($q->channel_active == 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 1);
			$this->db->update('facebook_groups');
			return true;
		} else {
			return false;
		}
	}

	public function yt_channel_active($user_id, $id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('youtube_channels')->row();

		if ($q->channel_active == 1) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 0);
			$this->db->update('youtube_channels');
			return true;
		} elseif ($q->channel_active == 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 1);
			$this->db->update('youtube_channels');
			return true;
		} else {
			return false;
		}
	}

	public function tiktok_acc_active($user_id, $id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$q = $this->db->get('tiktok')->row();

		if ($q->channel_active == 1) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 0);
			$this->db->update('tiktok');
			return true;
		} elseif ($q->channel_active == 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('id', $id);
			$this->db->set('channel_active', 1);
			$this->db->update('tiktok');
			return true;
		} else {
			return false;
		}
	}

	public function get_active_channels_settings($user_id)
	{
		$this->db->select('id, page_id, page_name, channel_active, channel_slots, access_token');
		$this->db->from('facebook_pages');
		$this->db->where(['user_id' => $user_id, 'channel_active' => 1, 'active_deactive_status' => 1]);
		$q = $this->db->get();

		if ($q->num_rows() > 0) {
			$fbpages = $q->result_array();
		} else {
			$fbpages = [];
		}

		$this->db->select('*');
		$this->db->from('pinterest_boards');
		$this->db->where(['user_id' => $user_id, 'channel_active' => 1]);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			$boards = $q->result_array();
		} else {
			$boards = [];
		}

		$this->db->select('*');
		$this->db->from('instagram_users');
		$this->db->where('user_id', $user_id);
		$this->db->where('channel_active', 1);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			$ig_accounts = $q->result_array();
		} else {
			$ig_accounts = [];
		}

		$this->db->select('*');
		$this->db->from('facebook_groups');
		$this->db->where(['user_id' => $user_id, 'channel_active' => 1]);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			$fb_groups = $q->result_array();
		} else {
			$fb_groups = [];
		}

		$this->db->select('*');
		$this->db->from('youtube_channels');
		$this->db->where(['user_id' => $user_id, 'active' => '1', 'channel_active' => '1']);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			$yt_channels = $q->result_array();
		} else {
			$yt_channels = [];
		}

		$this->db->select('*');
		$this->db->from('tiktok');
		$this->db->where(['user_id' => $user_id, 'channel_active' => '1']);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			$tiktoks = $q->result_array();
		} else {
			$tiktoks = [];
		}

		$data = [
			'fbpages' => $fbpages,
			'boards' => $boards,
			'ig_accounts' => $ig_accounts,
			'yt_channels' => $yt_channels,
			'tiktoks' => $tiktoks,
			'fb_groups' => $fb_groups
		];
		return $data;
	}

	// the $fbpage_pinboard_fbgroup_instapageid either contains page_id, board_id, fb_group_id or fb_page_id(insta_id) //
	public function scheduleOnChannel($userID, $channel_id, $title, $img_path, $site_us_pc, $next_post_date_time, $type, $post_comment = null, $video_path = null)
	{
		$data = ['user_id' => $userID, 'channel_id' => $channel_id, 'post_title' => $title, 'type' => $type, 'link' => $img_path, 'site_us_pc' => $site_us_pc, 'video_path' => $video_path, 'post_datetime' => $next_post_date_time, 'post_comment' => $post_comment];
		$this->db->trans_start();
		$this->db->insert('channels_scheduler', $data);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
	}

	public function UpdatescheduleOnChannel($primary_id, $post_datetime)
	{
		$data = [
			'post_datetime' => $post_datetime
		];

		$this->db->trans_start();
		$this->db->where('id', $primary_id);
		$this->db->update('channels_scheduler', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			return true;
		} else {
			return false;
		}
	}


	public function publish_fbpost($userID, $page_id, $title, $file_name, $access_token, $comment = null)
	{
		$this->load->library('facebook');

		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$image_path = "http://localhost/adublisher/assets/bulkuploads/" . $file_name;
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/adublisher/assets/bulkuploads/" . $file_name;
		} else {
			$image_path = SITEURL . "assets/bulkuploads/" . $file_name;
			$delete_path = $_SERVER['DOCUMENT_ROOT'] . "/assets/bulkuploads/" . $file_name;
		}
		$postData = [];

		$postData["url"] = $image_path;
		if ($title == "") {
			$postData["caption"] = "";
		} else {
			$postData["caption"] = str_replace('\r\n', "\n", $title);
		}
		$posting = $this->facebook->request('POST', "/" . $page_id . "/photos", $postData, $access_token);
		$postId = isset($posting['id']) ? $posting['id'] : '';
		// publish comment on facebook post
		if (!empty($postId)) {
			if (!empty($comment)) {
				$comment_post = $this->Publisher_model->publish_comments($postId, $comment, $access_token);
			}
		}
		// publish comment on facebook post

		if (file_exists($delete_path)) {
			unlink($delete_path);
		}
		if (isset($posting['error'])) {
			return json_encode(['error' => $posting['error'] . ' ' . $posting['message']]);
		} else {
			return true;
		}
	}

	public function get_channels_scheduler($user_id, $channel_id)
	{
		$this->db->select('*');
		$this->db->from('channels_scheduler');
		$this->db->where('user_id', $user_id);
		$this->db->where('channel_id', $channel_id);
		// $this->db->where('status', 0);
		$this->db->order_by('post_datetime', 'ASC');
		$this->db->limit(1);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			$data = $q->row_array();
		} else {
			$data = [];
		}
		return $data;
	}

	public function publish_pin_curl($data)
	{
		if (isset($data['content_type'])) {
			$access_token = refresh_pinterest_access_token($data['access_token']);
			$curlopt_postfields = '';
			$link = rtrim($data['link']);
			if ($data['content_type'] == 'image_path') {
				$image = file_get_contents($data['image']);
				$image = base64_encode($image);
				$curlopt_postfields = '{
					"title": "' . urldecode(cleanString($data['title'])) . '",
					"description": "' . $data['description'] . '",
					"link": "' . $link . '",
					"board_id": "' . $data['board_id'] . '",
					"media_source": {
						"source_type": "image_base64",
						"content_type": "image/jpeg",
						"data" : "' . $image . '"
					}
				}';
			} elseif ($data['content_type'] == 'image_url') {
				$curlopt_postfields = '{
					"title": "' . urldecode(cleanString($data['title'])) . '",
					"description": "' . $data['description'] . '",
					"link": "' . $link . '",
					"board_id": "' . $data['board_id'] . '",
					"media_source": {
						"source_type": "image_url",
						"url":  "' . $data['image'] . '"
					}
				}';
			}
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.pinterest.com/v5/pins',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => '' . $curlopt_postfields . '',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $data['access_token'],
					'Content-Type: application/json',
					'Cookie: _ir=0'
				),
			));

			$result = curl_exec($curl);
			// $result = json_decode($result, true);
			curl_close($curl);
			return $result;
		} else {
			return false;
		}
	}

	public function publish_video_pin_curl($data)
	{
		// Video intent 
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.pinterest.com/v5/media',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{ "media_type": "video" }',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $data['access_token']
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		if (isset($response['media_id'])) {
			$response_data = [
				'data' => $data,
				'response' => $response
			];
			$upload_params = $this->pin_upload_params($response_data);
			if ($upload_params['status']) {
				$response = $upload_params['response'];
			} else {
				$response = array(
					'code' => $upload_params['code'],
					'message' => $upload_params['message'],
				);
			}
		} else {
			return $response;
		}
		return $response;
	}

	public function pin_upload_params($response)
	{
		$data = $response['data'];
		$response_data = $response['response'];
		$upload_params = $response_data['upload_parameters'];
		// $curl_url = $response_data['upload_url'];
		$curl_url = 'https://pinterest-media-upload.s3-accelerate.amazonaws.com/';
		$postfields = [];
		$postfields = $upload_params;
		$video_path = get_from_s3bucket($data['video_path']);
		if ($video_path['status']) {
			$video_path = $video_path['file_name'];
			$postfields['file'] = new CURLFILE("assets/bulkuploads/" . $video_path);
			// Upload video to Pinterest AWS S3
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $curl_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $postfields,
			));
			$response = curl_exec($curl);
			$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if ($httpCode == '204') {
				$response_data = array(
					'access_token' => $data['access_token'],
					'media_id' => $response_data['media_id'],
					'title' => $data['title'],
					'description' => $data['description'],
					'board_id' => $data['board_id'],
					'media_source' => array(
						'source_type' => 'video_id',
						"media_id" => $response_data['media_id'],
						'cover_image_content_type' => 'image/png',
						'cover_image_url' => '',
						'cover_image_data' => '',
						'cover_image_key_frame_time' => 9999999,
					)
				);
				$upload_video = $this->pin_upload_video($response_data);
				if ($upload_video['status']) {
					$response = array(
						'status' => true,
						'response' => $upload_video['response']
					);
				} else {
					$response = [
						'status' => false,
						'code' => $upload_video['code'],
						'message' => $upload_video['message'],
					];
				}
			} else {
				$error = $response;
				$response = [
					'status' => false,
					'code' => $httpCode,
					'message' => $error
				];
			}
		} else {
			$response = [
				'status' => false,
				'code' => '400',
				'message' => 'Something went wrong!'
			];
		}
		return $response;
	}

	public function pin_upload_video($response_data)
	{
		$postfields = array(
			'title' => $response_data['title'],
			'description' => $response_data['description'],
			'board_id' => $response_data['board_id'],
			'media_source' => $response_data['media_source'],
		);
		$postfields = json_encode($postfields);
		// Video upload
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.pinterest.com/v5/pins',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $postfields,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $response_data['access_token'],
				'Content-Type: application/json',
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response, true);
		if (isset($response['id'])) {
			$response = array(
				'status' => true,
				'response' => $response
			);
		} else {
			$response = array(
				'status' => false,
				'code' => $response['code'],
				'message' => $response['message']
			);
		}
		return $response;
	}

	public function create_single_pinterest_rss_feed($userID, $board_id, $title, $img_path, $url, $timeslots, $post_type = null)
	{
		$post_date_time = $this->getNextPostTime("pinterest_scheduler", $userID, $board_id, $timeslots);

		$this_id = $this->post_pinterest_rssschedule($userID, $board_id, $title, $img_path, $url, $post_date_time, $post_type);
		return $this_id;
	}

	public function metaOfUrlt($request_url)
	{
		$response['image'] = '';
		$response['status'] = false;
		if ($request_url != '') {
			$this->load->library('getMetaInfo');
			$info = $this->getmetainfo->get_info($request_url);
			$response['image'] = $info['image'];
			$response['status'] = true;
		}
		return $response;
	}

	// instagram
	public function get_instagram_login_url()
	{
		$instagram_redirect_uri = SITEURL . "get_instagram_access_token";
		$permissions = $this->config->item('instagram_permissions');
		$scopes = implode(',', $permissions);
		$login_url = 'https://www.facebook.com/v23.0/dialog/oauth?client_id=' . INSTAGRAM_CLIENT_ID . '&redirect_uri=' . $instagram_redirect_uri . '&scope=' . $scopes;
		return $login_url;
	}

	public function get_instagram_access_token()
	{
		$this->load->library('facebook');
		$code = $this->input->get('code');
		$instagram_redirect_uri = SITEURL . "get_instagram_access_token";
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v23.0/oauth/access_token?client_id=' . INSTAGRAM_CLIENT_ID . '&redirect_uri=' . $instagram_redirect_uri . '&client_secret=' . INSTAGRAM_CLIENT_SECRET . '&code=' . $code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
		));
		$response = curl_exec($curl);
		$response = json_decode($response, true);
		curl_close($curl);
		if (isset($response['access_token'])) {
			$access_token = $response['access_token'];
			$result = $this->get_user_ig_account_id($access_token);
			return $result;
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Something went wrong while getting access_token',
				'result' => $response
			]);
			return false;
		}
	}

	public function get_user_ig_account_id($access_token = null)
	{
		if (!empty($access_token)) {
			$this->load->library('facebook');
			$ig_access_token = $access_token;
			$pages = $this->facebook->request('get', '/me/accounts', $ig_access_token);
			$fb_pages = $pages['data'];
			foreach ($fb_pages as $fb_page) {
				$fb_id = $fb_page['id'];
				$fb_page_name = $fb_page['name'];
				$instagram_info = $this->facebook->request('get', $fb_id . '?fields=instagram_business_account', $ig_access_token);
				if (isset($instagram_info['instagram_business_account']['id'])) {
					$fb_page_id = $instagram_info['id'];
					$ig_account_id = $instagram_info['instagram_business_account']['id'];
					break;
				} else {
					echo json_encode([
						'status' => 'error',
						'message' => 'Please Attach Business or Professional Instagram Account',
						'result' => $instagram_info
					]);
					return false;
				}
			}
			if (isset($ig_account_id)) {
				$result = $this->get_user_ig_account_details($ig_account_id, $fb_page_id, $fb_page_name, $ig_access_token);
				return $result;
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Something went wrong while getting ig account_id',
					'result' => $instagram_info
				]);
				return false;
			}
		}
	}

	public function get_user_ig_account_details($ig_account_id, $fb_page_id, $fb_page_name, $ig_access_token)
	{
		$this->load->library('facebook');
		$user_id = App::Session()->get('userid');
		$ig_account_info = $this->facebook->request('get', $ig_account_id . '?fields=id,username', $ig_access_token);
		if (isset($ig_account_info['id'])) {
			$data = [
				'user_id' => $user_id,
				'instagram_id' => $ig_account_id,
				'fb_page_id' => $fb_page_id,
				'fb_page_name' => $fb_page_name,
				'access_token' => $ig_access_token,
				'instagram_username' => $ig_account_info['username'],
			];

			if (!limit_check(AUTHORIZE_SOCIAL_ACCOUNTS_ID, 2)) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Your resource limit has been reached',
					'result' => []
				]);
				return false;
			}
			$where = [
				'user_id' => $user_id,
				'instagram_id' => $ig_account_id
			];
			$check = $this->get_allrecords('instagram_users', $where);
			if (count($check) <= 0) {
				resources_update('up', AUTHORIZE_SOCIAL_ACCOUNTS_ID);
			}
			$where = array('user_id' => $user_id, 'instagram_id' => $ig_account_id);
			$result = $this->create_or_update_record('instagram_users', $data, $where);
			if ($result) {
				$this->db->where('user_id', $user_id);
				$this->db->where('channel_id', $result);
				$this->db->where('type', 'instagram');
				$this->db->set('active_deactive_status', 1);
				$this->db->update('channels_scheduler');
				redirect(SITEURL . 'schedule');
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'failed to add ig account details in db, please try again',
					'result' => $ig_account_info
				]);
				return false;
			}
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Something went wrong while getting ig account details',
				'result' => $ig_account_info
			]);
			return false;
		}
	}

	// create_ig_media_container
	public function create_ig_media_container($instagram_id, $access_token, $img_url, $caption)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v23.0/' . $instagram_id . '/media',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
				'image_url' => $img_url,
				// 'caption' => $caption,
			),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $access_token,
				'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.Od.AAA.0.0.Bj21fJ.AWWmDetS3aY; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
			),
		));

		$response = curl_exec($curl);
		$response = json_decode($response, true);
		curl_close($curl);

		return $response;
	}

	// publish_ig_media_container
	public function publish_ig_media_container($user_id, $media_container_id)
	{
		$ig_user = $this->db->get_where('instagram_users', [
			'user_id' => $user_id
		])->row_array();

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v23.0/' . $ig_user['instagram_id'] . '/media_publish',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('creation_id' => $media_container_id),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $ig_user['access_token'],
				'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.Od.AAA.0.0.Bj21fJ.AWWmDetS3aY; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
			),
		));

		$response = json_decode(curl_exec($curl), true);
		curl_close($curl);

		return $response;
	}

	public function create_single_ig_rss_feed($userID, $ig_id, $title, $img_path, $url, $timeslots)
	{
		$post_date_time = $this->getNextPostTime("instagram_scheduler", $userID, $ig_id, $timeslots);
		$this_id = $this->post_ig_rssschedule($userID, $ig_id, $title, $img_path, $url, $post_date_time);
		return $this_id;
	}


	public function post_ig_rssschedule($userID, $ig_id, $title, $img_path, $url, $post_date_time, $post_type = null)
	{
		$data = [
			'user_id' => $userID,
			'ig_id' => $ig_id,
			'post_title' => $title,
			'image_link' => $img_path,
			'url' => $url,
			'publish_datetime' => $post_date_time,
			'post_type' => $post_type
		];

		$this->db->trans_start();
		$insert_query = $this->db->insert_string('instagram_scheduler', $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
	}

	public function update_ig_rssschedule($primary_id, $publish_datetime)
	{
		$data = [
			'publish_datetime' => $publish_datetime
		];
		$update_query = $this->db->update_string('instagram_scheduler', $data, ['id' => $primary_id]);

		$this->db->query($update_query);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_fbgroups_login_url()
	{
		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$redirect_uri = "https://localhost/adublisher/get_fbgroups_access_token";
		} else {
			$redirect_uri = SITEURL . "get_fbgroups_access_token";
		}

		$facebook_app_id = $this->config->item('facebook_app_id');

		$scope = 'publish_to_groups';
		$login_url = 'https://www.facebook.com/v23.0/dialog/oauth?client_id=' . $facebook_app_id . '&redirect_uri=' . $redirect_uri . '&scope=' . $scope;
		return $login_url;
	}

	public function get_fbgroups_access_token()
	{
		$code = $this->input->get('code');
		$user_id = App::Session()->get('userid');

		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			$redirect_uri = "https://localhost/adublisher/get_fbgroups_access_token";
		} else {
			$redirect_uri = SITEURL . "get_fbgroups_access_token";
		}

		$facebook_app_id = $this->config->item('facebook_app_id');
		$facebook_app_secret = $this->config->item('facebook_app_secret');

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v23.0/oauth/access_token?client_id=' . $facebook_app_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $facebook_app_secret . '&code=' . $code,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.Jn.AAA.0.0.BkSOzI.AWVaiyiSlPg; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
			),
		));

		$response = curl_exec($curl);
		$response = json_decode($response, true);

		if (isset($response['access_token'])) {
			// set token to session
			App::Session()->set('fbgroups_access_token', $response['access_token']);

			$update_data['fbgroups_access_token'] = $response['access_token'];

			$result = $this->Publisher_model->update_record('user', $update_data, $user_id);

			if ($result) {
				$error_column_name = 'facebook_group_error';
				$removeError = removeCronJobError($user_id, $error_column_name); // helper function
				if ("::1" == $_SERVER['REMOTE_ADDR']) {
					redirect('http://localhost/adublisher/get_facebook_groups/');
				} else {
					redirect(SITEURL . 'get_facebook_groups/');
				}
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Something went wrong while storing access_token',
				]);
				return false;
			}
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Something went wrong while getting access_token',
				'result' => $response
			]);
			return false;
		}
	}

	public function get_facebook_groups()
	{
		$user_id = App::session()->get('userid');
		$user = $this->db->get_where('user', ['id' => $user_id])->row_array();
		$access_token = $user['fbgroups_access_token'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v23.0/me/groups',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $access_token,
				'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.MJ.AAA.0.0.BkHT_Y.AWXFao6XXeU; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
			),
		));

		$response = curl_exec($curl);
		$response = json_decode($response, true);

		curl_close($curl);

		$data = [];

		if (isset($response['data']) && count($response['data']) > 0) {
			foreach ($response['data'] as $key => $value) {
				if (isset($value['privacy'])) {
					$data[$key] = $value;
				}
			}
			return json_encode([
				'status' => 'success',
				'data' => $data
			]);
		} else {
			$error = isset($response['error']['message']) ? $response['error']['message'] : 'Something went wrong while getting fb groups';
			return json_encode([
				'status' => 'error',
				'message' => $error,
				'response' => $response
			]);
		}
	}



	public function publish_to_facebook_group($group_id, $uri, $message, $is_link = true, $image = null)
	{
		$user_id = App::Session()->get('userid');
		$user = $this->db->get_where('user', ['id' => $user_id])->row_array();
		$access_token = $user['facebook_permanent_token'];
		// $access_token = $user['fbgroups_access_token'];
		// print_r($access_token);
		// exit;
		// $access_token = 'EAAB2OowfWm0BO7m76DWkZB06IaMJJDNp88A4UI5P6Wh0nfsUQDgErjOAMNkZBbglAfeVLi3lRkJ8CXkBl7q3tZAt8p5NXkuLLnRD4mslXjCZCzkgvkCRIb1W2pe2G49XxL9JcZBsoS8eWIzxH0bZB4IfKuUfek3oDoPKWwKCbJm9DwhprLyJszxhQ3sZBA77I78';
		$is_link ? $url = 'link' : $url = 'url';
		$is_link ? $caption = 'message' : $caption = 'caption';
		$is_link ? $param = 'feed' : $param = 'photos';

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v23.0/' . $group_id . '/' . $param,
			// CURLOPT_URL => 'https://graph.facebook.com/v23.0/' . $group_id . '/photos',
			// CURLOPT_URL => 'https://graph.facebook.com/v23.0/' . $group_id . '/feed',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array($url => $uri, $caption => $message),
			// CURLOPT_POSTFIELDS => array('url' => $uri, 'caption' => $message),
			// CURLOPT_POSTFIELDS => array('link' => $uri, 'message' => $message),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $access_token,
				'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.rj.AAA.0.0.BkIVvj.AWXk5Wrb8iA; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
			),
		));

		$response = json_decode(curl_exec($curl), true);
		curl_close($curl);
		return $response;
	}

	public function publish_shopify_product_to_facebook_group($group_id, $imageURL, $message)
	{
		// Get the user access token or any other required credentials
		$user_id = App::Session()->get('userid');
		$user = $this->db->get_where('user', ['id' => $user_id])->row_array();
		$access_token = $user['facebook_permanent_token'];
		// $access_token = $user['fbgroups_access_token'];

		// Set the URL for the Facebook Graph API endpoint
		$url = 'https://graph.facebook.com/v23.0/' . $group_id . '/photos';

		// Prepare the POST data
		$postData = array(
			'url' => $imageURL,
			'caption' => $message,
		);

		// Set up cURL for making the request
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
			CURLOPT_POSTFIELDS => $postData,
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $access_token,
				'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.rj.AAA.0.0.BkIVvj.AWXk5Wrb8iA; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
			),
		));

		// Execute cURL and decode the response
		$response = json_decode(curl_exec($curl), true);

		// Close cURL session
		curl_close($curl);

		return $response;
	}

	/*
																																																														  
																																																														  */

	/*public function publish_to_facebook_group($group_id, $uri, $message, $is_link = true)
																																																														  {
																																																															  $user_id = App::Session()->get('userid');
																																																															  $user = $this->db->get_where('user', ['id' => $user_id])->row_array();
																																																															  $access_token = $user['fbgroups_access_token'];

																																																															  // $user_access_token = 'EAAB2OowfWm0BO7m76DWkZB06IaMJJDNp88A4UI5P6Wh0nfsUQDgErjOAMNkZBbglAfeVLi3lRkJ8CXkBl7q3tZAt8p5NXkuLLnRD4mslXjCZCzkgvkCRIb1W2pe2G49XxL9JcZBsoS8eWIzxH0bZB4IfKuUfek3oDoPKWwKCbJm9DwhprLyJszxhQ3sZBA77I78';

																																																															  // Check if the group was created by a page
																																																															  // $getGroupInfo = $this->getGroupInfo($group_id, $access_token);

																																																															  // $getGroupAdmins = $this->getGroupAdmins($group_id, $access_token);

																																																															  // $getFacebookgroupsData = $this->getFacebookgroupsData($user_access_token);

																																																															  // $getFacebookPagesData = $this->getFacebookPagesData($user_access_token);

																																																															  // echo '<pre>';
																																																															  // print_r($getFacebookgroupsData);
																																																															  // echo '<br>';
																																																															  // print_r($getFacebookPagesData);
																																																															  // exit;

																																																															  $group_id = '1347820459454723';
																																																															  $pageAccessToken = 'EAAB2OowfWm0BO0CpBz3LI7SdJ49zzqJHbDXVlrM42tE8waI9RET7OXMiYjzEBYIxaQiIR5DYp8ShGUiiWZCFOoLtPaZBNxxX7xqPkiZCOTmVYBX92ZA1gTDlnt90AzxYQvNdtL9NsaebjuVSFdodZAXi2IIXWZBUY5MfA3PhKGiA8Qa1eqfzqt4d1fwgpCa3JfZAYmEXvIZD';

																																																															  $this->postToGroup($group_id, $uri, $message, $is_link, $pageAccessToken);

																																																															  /*if ($groupInfo && isset($groupInfo['parent'])) {
																																																																  $pageAccessToken = $this->getPageAccessToken($groupInfo['parent']['id']); 
																																																															  } else {
																																																																  return $this->postToGroup($group_id, $uri, $message, $is_link, $access_token);
																																																															  }*/
	// }


	/*private function getPageAccessToken($page_id)
																																																													   {
																																																														   // Implement the logic to get the page access token based on the page_id
																																																														   // This might involve querying your database or making additional API requests
																																																														   // Return the page access token
																																																													   }*/

	/*private function postToGroup($group_id, $uri, $message, $is_link, $access_token)
																																																													   {
																																																														   // Your existing code for posting to the group
																																																														   $is_link ? $url = 'link' : $url = 'url';
																																																														   $is_link ? $caption = 'message' : $caption = 'caption';
																																																														   $is_link ? $param = 'feed' : $param = 'photos';

																																																														   $curl = curl_init();

																																																														   curl_setopt_array($curl, array(
																																																															   CURLOPT_URL => "https://graph.facebook.com/v23.0/$group_id/$param",
																																																															   CURLOPT_RETURNTRANSFER => true,
																																																															   CURLOPT_ENCODING => '',
																																																															   CURLOPT_MAXREDIRS => 10,
																																																															   CURLOPT_TIMEOUT => 0,
																																																															   CURLOPT_FOLLOWLOCATION => true,
																																																															   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
																																																															   CURLOPT_CUSTOMREQUEST => 'POST',
																																																															   CURLOPT_POSTFIELDS => array($url => $uri, $caption => $message),
																																																															   CURLOPT_HTTPHEADER => array(
																																																																   'Authorization: Bearer ' . $access_token,
																																																																   // 'Cookie: fr=0yU8dJnv4LQIcuLWc..Bjv9Me.rj.AAA.0.0.BkIVvj.AWXk5Wrb8iA; sb=HtO_YzSXeVGcyZ-4M5ajz7IE'
																																																															   ),
																																																														   ));

																																																														   $response = json_decode(curl_exec($curl), true);
																																																														   curl_close($curl);
																																																														   return $response;
																																																													   }*/

	// private function getGroupAdmins($group_id, $access_token)
	// {
	//     $url = "https://graph.facebook.com/v23.0/$group_id/admins?access_token=$access_token";

	//     $curl = curl_init();
	//     curl_setopt_array($curl, array(
	//         CURLOPT_URL => $url,
	//         CURLOPT_RETURNTRANSFER => true,
	//         CURLOPT_CUSTOMREQUEST => 'GET',
	//     ));

	//     $response = json_decode(curl_exec($curl), true);
	//     curl_close($curl);

	//     return $response;
	// }
	// private function getGroupInfo($group_id, $access_token)
	// {
	//     $url = "https://graph.facebook.com/v23.0/$group_id?fields=id,name,parent,members.admin_only&access_token=$access_token";

	//     $curl = curl_init();
	//     curl_setopt_array($curl, array(
	//         CURLOPT_URL => $url,
	//         CURLOPT_RETURNTRANSFER => true,
	//         CURLOPT_CUSTOMREQUEST => 'GET',
	//     ));

	//     $response = json_decode(curl_exec($curl), true);
	//     curl_close($curl);

	//     return $response;
	// }
	// private function getFacebookgroupsData($user_access_token) {

	// 	$url = "https://graph.facebook.com/v12.0/me/groups?access_token=$user_access_token";

	//     $curl = curl_init();

	//     curl_setopt_array($curl, array(
	//         CURLOPT_URL => $url,
	//         CURLOPT_RETURNTRANSFER => true,
	//         CURLOPT_TIMEOUT => 30,
	//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//         CURLOPT_CUSTOMREQUEST => "GET",
	//     ));

	//     $response = curl_exec($curl);
	//     $err = curl_error($curl);

	//     curl_close($curl);

	//     if ($err) {
	//         echo "cURL Error #:" . $err;
	//     } else {
	//         return json_decode($response, true);
	//     }
	// }
	// private function getFacebookPagesData($user_access_token) {

	//     $url = "https://graph.facebook.com/v12.0/me/accounts?access_token=$user_access_token";

	//     $curl = curl_init();

	//     curl_setopt_array($curl, array(
	//         CURLOPT_URL => $url,
	//         CURLOPT_RETURNTRANSFER => true,
	//         CURLOPT_TIMEOUT => 30,
	//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//         CURLOPT_CUSTOMREQUEST => "GET",
	//     ));

	//     $response = curl_exec($curl);
	//     $err = curl_error($curl);

	//     curl_close($curl);

	//     if ($err) {
	//         echo "cURL Error #:" . $err;
	//     } else {
	//         return json_decode($response, true);
	//     }
	// }

	public function post_fb_group_rssschedule($userID, $fb_group_id, $title, $img_path, $url, $post_date_time)
	{
		$data = [
			'user_id' => $userID,
			'fb_group_id' => $fb_group_id,
			'post_title' => $title,
			'image_link' => $img_path,
			'url' => $url,
			'publish_datetime' => $post_date_time

		];
		$this->db->trans_start();
		$insert_query = $this->db->insert_string('facebook_group_scheduler', $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		$this->db->query($insert_query);
		$this_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status()) {
			return $this_id;
		} else {
			return false;
		}
	}

	public function update_fb_group_rssschedule($primary_id, $publish_datetime)
	{
		$data = [
			'publish_datetime' => $publish_datetime
		];
		$update_query = $this->db->update_string('facebook_group_scheduler', $data, ['id' => $primary_id]);

		$this->db->query($update_query);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function create_single_fb_group_rss_feed($userID, $fb_group_id, $title, $img_path, $url, $timeslots)
	{
		$post_date_time = $this->getNextPostTime("facebook_group_scheduler", $userID, $fb_group_id, $timeslots);

		$this_id = $this->post_fb_group_rssschedule($userID, $fb_group_id, $title, $img_path, $url, $post_date_time);
		return $this_id;
	}

	// facebook login

	public function get_facebook_login_url()
	{
		$this->load->library('facebook');
		$login_url = $this->facebook->login_url();
		return $login_url;
	}

	public function get_facebook_access_token()
	{
		$this->load->library('facebook');
		$code = $this->input->get('code');
		$facebook_app_id = FACEBOOK_CLIENT_ID;
		$facebook_app_secret = FACEBOOK_CLIENT_SECRET;
		$redirect_uri = $this->config->item('facebook_login_redirect_url');
		$params = 'client_id=' . $facebook_app_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $facebook_app_secret . '&code=' . $code;
		$response = $this->facebook->request('POST', 'oauth/access_token?' . $params, [], '');
		if (isset($response['access_token'])) {
			$result = $this->get_fb_exchange_token($facebook_app_id, $facebook_app_secret, $response['access_token']);
			return $result;
		} else {
			return false;
		}
	}

	public function get_fb_exchange_token($app_id, $app_secret, $access_token)
	{
		$this->load->library('facebook');
		$params = 'grant_type=fb_exchange_token&client_id=' . $app_id . '&client_secret=' . $app_secret . '&fb_exchange_token=' . $access_token;
		$response = $this->facebook->request('GET', 'oauth/access_token?' . $params, '');
		if (isset($response['access_token'])) {
			return $response['access_token'];
		} else {
			return false;
		}
	}

	// Google
	public function get_google_login_url()
	{
		$url = "https://accounts.google.com/o/oauth2/v2/auth?";
		$scopes = [
			'https://www.googleapis.com/auth/userinfo.profile', // Scope for user profile
			'https://www.googleapis.com/auth/userinfo.email', //Scope for user email
			'https://www.googleapis.com/auth/youtube', //Scope for authentication
			'https://www.googleapis.com/auth/youtube.readonly', //Scope for channel listing
			'https://www.googleapis.com/auth/youtubepartner', //Scope for channel listing
			'https://www.googleapis.com/auth/youtube.upload', //Scope for video publishing	
			'https://www.googleapis.com/auth/youtube.force-ssl',
			'https://www.googleapis.com/auth/analytics.readonly',
			'https://www.googleapis.com/auth/analytics',
			'https://www.googleapis.com/auth/analytics.manage.users'
		];
		$data['scope'] = implode(' ', $scopes);
		$data['prompt'] = "consent";
		$data['access_type'] = "offline";
		$data['include_granted_scopes'] = "true";
		$data['response_type'] = "code";
		$data['state'] = "state_parameter_passthrough_value";
		$data['redirect_uri'] = SITEURL . "get_google_access_token";
		$data['client_id'] = GOOGLE_CLIENT_ID;
		foreach ($data as $key => $val) {
			$url .= $key . '=' . $val . '&';
		}
		return rtrim($url, "&");
	}

	public function tiktok_url()
	{
		$this->load->library('tiktok');
		$auth_url = $this->tiktok->getAuthUrl();
		return $auth_url;
	}

	public function updated_access_token($google_auth)
	{
		$google_data = is_array($google_auth) ? $google_auth[0] : $google_auth;
		$url = "https://oauth2.googleapis.com/token";
		$data = array(
			"client_id" => GOOGLE_CLIENT_ID,
			"client_secret" => GOOGLE_CLIENT_SECRET,
			"grant_type" => 'refresh_token',
			"refresh_token" => $google_data->refresh_token,
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
			$return_response = $this->save_google_access_token($response);
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

	public function save_google_access_token($data)
	{
		$user_id = App::Session()->get('userid');
		$column['user_id'] = $user_id;
		$column['access_token'] = $data['access_token'];
		if (isset($data['refresh_token'])) {
			$column['refresh_token'] = $data['refresh_token'];
		}
		$column['scopes'] = $data['scope'];
		$column['expires_in'] = $data['expires_in'];
		$add_time = round($data['expires_in'] / 60) . ' minutes';
		$column['expires_at'] = date("Y-m-d H:i:s", strtotime('+' . $add_time, strtotime(date('Y-m-d H:i:s'))));
		// check if already loggedin
		$query = $this->db->get_where('google_users', array('user_id' => $user_id));
		if ($query->row() != null) {
			$response = $this->db->update('google_users', $column, array('user_id' => $user_id));
		} else {
			$response = $this->db->insert('google_users', $column);
		}
		return $response;
	}
	//Youtube

	public function publish_to_youtube($data, $video_path, $thumbnail_path, $access_token)
	{
		echo 'here';
		// upload video
		$posting = $this->video_upload($video_path, $access_token);
		echo '<pre>';
		print_r($posting);
		// get uploaded video id
		if ($posting['status']) {
			$video_id = $posting['data']['id'];
			// update video's metaData
			$update_metaData = $this->update_video_metaData($video_id, $data, $access_token);
			echo '<pre>';
			print_r($update_metaData);
			if (!empty($thumbnail_path)) {
				$update_thumbnail = $this->update_video_thumbnail($video_id, $thumbnail_path, $access_token);
				echo '<pre>';
				print_r($update_thumbnail);
			}
			if ($update_metaData['status']) {
				return array(
					'status' => true,
					'message' => 'Video uploaded successfully!'
				);
			} else {
				return array(
					'status' => false,
					'error' => $update_metaData['error']
				);
			}
		} else {
			return array(
				'status' => false,
				'error' => sset($posting['data']['error']) ? $posting['data']['error']['message'] : $posting['data']
			);
		}

		if (isset($posting['error'])) {
			return array(
				'error' => $posting['error']['message']
			);
		} else {
			return true;
		}
	}

	public function publish_video($data, $video_path, $thumbnail_path, $access_token)
	{
		// upload video
		$posting = $this->video_upload($video_path, $access_token);
		// get uploaded video id
		if ($posting['status']) {
			$video_id = $posting['data']['id'];
			// update video's metaData
			$update_metaData = $this->update_video_metaData($video_id, $data, $access_token);
			if (!empty($thumbnail_path)) {
				$update_thumbnail = $this->update_video_thumbnail($video_id, $thumbnail_path, $access_token);
			}
			if ($update_metaData['status']) {
				return array(
					'status' => true,
					'message' => 'Video uploaded successfully!'
				);
			} else {
				return array(
					'status' => false,
					'error' => $update_metaData['error']
				);
			}
		} else {
			return array(
				'status' => false,
				'error' => $posting['data']['error']['message']
			);
		}

		if (isset($posting['error'])) {
			return array(
				'error' => $posting['error']['message']
			);
		} else {
			return true;
		}
	}

	public function video_upload($video_path, $access_token)
	{
		if ($access_token) {
			// YouTube video insert api url
			$uploadUrl = 'https://www.googleapis.com/upload/youtube/v3/videos';
			// Set the cURL options for the resumable upload
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $uploadUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array(
				'media' => new CURLFILE("assets/bulkuploads/" . $video_path)
			));
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'Authorization: Bearer ' . $access_token,
			]);
			// Execute the request
			$response = curl_exec($ch);
			// Close the cURL session and the video file
			curl_close($ch);
			$decodedResponse = json_decode($response, true);
			if (isset($decodedResponse['id'])) {
				return array(
					'status' => true,
					'data' => $decodedResponse
				);
			} else {
				return array(
					'status' => false,
					'data' => $decodedResponse
				);
			}
		} else {
			return array(
				'status' => false,
				'data' => 'Failed to receieve access token!'
			);
		}
	}

	public function update_video_metaData($video_id, $postData, $access_token)
	{
		if ($access_token) {
			$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,status";

			$postFields = (object) array();
			$postFields->id = $video_id;
			$postFields->snippet = (object) array();
			$postFields->snippet->title = $postData['video_title'];
			if (!empty($postData['video_description'])) {
				$postFields->snippet->description = $postData['video_description'];
			}
			$postFields->snippet->categoryId = $postData['video_category'];
			if (!empty($postData['tags'])) {
				$postFields->snippet->tags = explode(',', $postData['tags']);
			}
			$postFields->status = (object) array();
			$postFields->status->embeddable = true;
			$postFields->status->license = "youtube";
			if (!empty($postData['privacyStatus'])) {
				$postFields->status->privacyStatus = $postData['privacyStatus'];
			}
			$postFields->status->selfDeclaredMadeForKids = $postData['kids'] == '1' ? true : false;

			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'PUT',
				CURLOPT_POSTFIELDS => json_encode($postFields),
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $access_token,
					'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);
			$jsonDecoded = json_decode($response, true);
			curl_close($curl);
			if (isset($jsonDecoded['kind'])) {
				return array(
					'status' => true,
					'message' => 'Video uploaded successfully!'
				);
			} else {
				return array(
					'status' => false,
					'error' => $jsonDecoded['error']['message']
				);
			}
		} else {
			return array(
				'status' => false,
				'error' => 'Failed to receieve access token!'
			);
		}
	}

	public function update_video_thumbnail($video_id, $thumbanil_path, $access_token)
	{
		if ($access_token) {
			$url = "https://www.googleapis.com/upload/youtube/v3/thumbnails/set?videoId=" . $video_id;

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
				CURLOPT_POSTFIELDS => array(
					'media' => new CURLFILE("assets/bulkuploads/" . $thumbanil_path)
				),
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $access_token
				),
			));
			$response = curl_exec($curl);
			$jsonDecoded = json_decode($response, true);
			curl_close($curl);
			if (isset($jsonDecoded['kind'])) {
				return array(
					'status' => true,
					'message' => 'Video uploaded successfully!'
				);
			} else {
				return array(
					'status' => false,
					'error' => $jsonDecoded['error']['message']
				);
			}
		} else {
			return false;
		}
	}

	public function schedule_video_to_youtube($channel_id, $data, $publish_date)
	{
		if (!empty($channel_id)) {
			$user_id = App::Session()->get('userid');
			$dataArray = array(
				'user_id' => $user_id,
				'channel_id' => $channel_id,
				'video_title' => $data['video_title'],
				'video_description' => $data['video_description'],
				'video_category' => $data['video_category'],
				'privacy_status' => $data['privacyStatus'],
				'kids' => $data['kids'],
				'tags' => $data['tags'],
				'video_link' => $data['video_path'],
				'thumbnail_link' => $data['thumbnail_link'],
				'publish_datetime' => $publish_date,
				'published' => 0,
			);
			$this->db->trans_start();
			$query = $this->db->insert('youtube_scheduler', $dataArray);
			$this->db->trans_complete();
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function fetch_access_token()
	{
		$google_row = get_google_auth();
		if (!empty($google_row)) {
			$this_response = $this->updated_access_token($google_row);
			if ($this_response) {
				$google = get_google_auth();
				return $google->access_token;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function fetch_user_access_token($user_id)
	{

		$google_row = get_google_auth($user_id);
		if (!empty($google_row)) {
			$this_response = $this->updated_access_token($google_row);
			if ($this_response) {
				$google = get_google_auth($user_id);
				return $google->access_token;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function publish_comments($post_id, $commentData, $access_token)
	{
		$postData = array(
			'message' => $commentData
		);
		$response = $this->facebook->request('post', '/' . $post_id . '/comments', $postData, $access_token);
		if (isset($response['id'])) {
			return array(
				'status' => true
			);
		} else {
			return array(
				'status' => false,
				'error' => $response['error']['message']
			);
		}
	}

	public function fetchDataWithCurl($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL verification (optional, adjust based on security needs)
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Curl');
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public function appendFeedToUrl($url)
	{
		if (!strpos($url, 'feed') || !strpos($url, 'rss')) {
			if (substr($url, -5) !== '/feed') {
				$url .= 'feed';
			}
		}
		return $url;
	}

	public function random_post($page, $post)
	{
		$this->db->where('user_id', $page->user_id);
		$this->db->where('page_id', $page->id);
		$this->db->where('post_id !=', $post->id);
		$this->db->where('post_title !=', $post->post_title);
		$this->db->order_by('RAND()')->limit(1);
		$query = $this->db->get('sceduler');
		$post = $query->result();
		return $post;
	}

	public function calendar_events($table, $where, $date, $offset = null, $count = false)
	{
		$user = get_auth_user();
		$start_date = utcToLocal($date['start_date'], $user->gmt, 'Y-m-d');
		$end_date = utcToLocal($date['end_date'], $user->gmt, 'Y-m-d');
		$this->db->cache_on();
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}

		if ($table == 'channels_scheduler') { // scheduled posts
			$date_column = 'post_datetime';
			$this->db->where('status', 0);
		} elseif ($table == 'facebook_posts') { // facebook published posts
			$date_column = 'published_at';
		} elseif ($table == 'rsssceduler') { // facebook rss scheduled posts
			$date_column = 'post_datetime';
			$this->db->where_in('posted', array(-1, 0));
		} elseif ($table == 'pinterest_scheduler') { // pinterest rss scheduled posts
			$date_column = 'publish_datetime';
			$this->db->where_in('published', array(-1, 0));
		} elseif ($table == 'instagram_scheduler') { // instagram rss scheduled posts
			$date_column = 'publish_datetime';
			$this->db->where_in('published', array(-1, 0));
		} elseif ($table == 'tiktok_scheduler') {
			$date_column = 'post_datetime';
		}

		$this->db->where($date_column . ' >= ', $date['start_date']);
		$this->db->where($date_column . ' <= ', $date['end_date']);
		$this->db->order_by($date_column, 'ASC');
		$this->db->cache_off();
		if ($count) {
			$query = $this->db->get($table);
			$events = $query->result();
			return count($events);
		} else {
			$query = $this->db->get($table, 100);
			$events = $query->result();
			return $events;
		}
	}

	public function us_holidays($year, $month)
	{
		$api_key = CALENDARIFIC_API_KEY;
		$country = 'US';
		$year = !empty($year) ? $year : date('Y');
		$url = 'https://calendarific.com/api/v2/holidays?api_key=' . $api_key . '&country=' . $country . '&year=' . $year . '&month=' . $month;
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
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		$holidays = [];
		if (isset($response->meta)) {
			$meta = $response->meta;
			if ($meta->code == '200') {
				$response = $response->response;
				$holidays_array = $response->holidays;
				$temp = [];
				foreach ($holidays_array as $key => $holiday) {
					$holidays[$holiday->date->iso] = $holiday->name;
				}
				$holidays = array_unique($holidays);
			}
		}
		return $holidays;
	}

	public function country_data($page_id, $access_token, $since, $until)
	{
		$url = 'https://graph.facebook.com/v23.0/' . $page_id . '/insights?';
		$query_params = [
			'access_token' => $access_token,
			'since' => $since,
			'until' => $until,
			'metric' => 'page_fans_country',
			'period' => 'day'
		];
		$params = http_build_query($query_params, '&');
		$url .= $params;

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
		));
		$response = curl_exec($curl);
		$response = json_decode($response);
		$country_data = [];
		if (count($response->data) > 0) {
			$data = $response->data[0];
			foreach ($data->values as $key => $value) {
				$temp_country_data = [];
				foreach ($value->value as $code => $val) {
					$cache_key = 'get_country_name_' . $code;
					$country_name = get_cache_data($cache_key, $code);
					$country_name = $country_name['data'];
					$country_name = empty($country_name) ? $code : $country_name;
					$temp_country_data[$country_name] = $val;
				}
				arsort($temp_country_data);
				$temp_country_data = array_slice($temp_country_data, 0, 5);
				foreach ($temp_country_data as $country => $data) {
					$country_data[strtotime($value->end_time)][$country] = $data;
				}
			}
		}
		$result = array_grouping_with_date($country_data);
		return $result;
	}

	public function city_data($page_id, $access_token, $since, $until)
	{
		$url = 'https://graph.facebook.com/v23.0/' . $page_id . '/insights?';
		$query_params = [
			'access_token' => $access_token,
			'since' => $since,
			'until' => $until,
			'metric' => 'page_fans_city',
			'period' => 'day'
		];
		$params = http_build_query($query_params, '&');
		$url .= $params;

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
		));
		$response = curl_exec($curl);
		$response = json_decode($response);
		$city_data = [];
		$city_array = [];
		if (count($response->data) > 0) {
			$data = $response->data[0];
			foreach ($data->values as $key => $value) {
				$temp_city_data = [];
				foreach ($value->value as $city_name => $val) {
					if (count($city_array) > 0) {
						if (in_array($city_name, $city_array)) {
							$temp_city_data[$city_name] = $val;
						}
					} else {
						$temp_city_data[$city_name] = $val;
					}
				}
				arsort($temp_city_data);
				$temp_city_data = array_slice($temp_city_data, 0, 5);
				foreach ($temp_city_data as $city => $data) {
					if (!in_array($city, $city_array)) {
						array_push($city_array, $city);
					}
					$city_data[strtotime($value->end_time)][$city] = $data;
				}
			}
		}
		$result = array_grouping_with_date($city_data);
		return $result;
	}

	public function country_full_name($code)
	{
		$url = 'https://restcountries.com/v3.1/alpha/' . $code;
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
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		$common_name = '';
		if (count($response) > 0) {
			$response = $response[0];
			$name = $response->name;
			$common_name = $name->common;
		}
		return $common_name;
	}
}
