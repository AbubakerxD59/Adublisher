<?php
defined('BASEPATH') or exit('No direct script access allowed');
//require(APPPATH.'libraries/REST_Controller.php');

/*class home extends REST_Controller  {*/
class Home extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		$this->load->helper('url');
		$this->load->helper('general_helper');
		$this->load->model('Publisher_model');
	}

	public function mail_test()
	{
		$this->load->library('email');

		$test_config['protocol'] = 'smtp';
		$test_config['smtp_host'] = 'ssl://email-smtp.eu-west-1.amazonaws.com';
		$test_config['smtp_port'] = '465';
		$test_config['smtp_user'] = 'AKIAIE4RYUEIYB4OEZHQ';
		$test_config['smtp_pass'] = 'BCw5TIJEfS3sjgJE3SkDuvKdC01qlmYfBwPlbBLunTEo';
		$test_config['newline']      = "\r\n";

		$this->email->initialize($test_config);

		$this->email->from('support@adublisher.com', 'From at Test.com');
		$this->email->to('shabbypro@gmail.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();
		/*

	$config = array(
		'protocol' => 'smtp',
		'smtp_host' => 'email-smtp.eu-west-1.amazonaws.com',
		'smtp_user' => 'AKIAIE4RYUEIYB4OEZHQ',
		'smtp_pass' => 'BCw5TIJEfS3sjgJE3SkDuvKdC01qlmYfBwPlbBLunTEo',
		'smtp_port' => 465,
		'mailtype' => 'html',
		'newline' => "\r\n",
		'smtp_crypto' => 'tls'		
	);

	$this->email->initialize($config);
	$this->email->print_debugger();
	//$this->email->set_newline("\r\n");
	$this->email->from('support@adublisher.com', 'Test From');
	$this->email->to('zubair.kwe@gmail.com', 'Test To');
	$this->email->subject('Test');
	$this->email->message('test');
	$this->email->send();*/
	}


	public function revenue_fetch()
	{
		$this->Publisher_model->revenue_fetch();
	}

	public function index()
	{
		if (!$this->Publisher_model->check_logged()) {
			$packages = $this->Publisher_model->getPakcages();
			$data['packages'] = $packages;
			$this->load->view('layouts/publisher/landing', $data);
		} else {

			redirect(SITEURL . "dashboard");
		}
	}

	public function error_logs(){
		$this->load->view('layouts/publisher/error_page');
	}

	/*public function error_logs_api()
	{
		$draw = $this->input->get('draw');
	    $start = $this->input->get('start');
	    $length = $this->input->get('length');

	    // Your existing query
	    $this->db->select('errors.*, user.fname as first_name, user.lname as last_name');
	    $this->db->from('errors');
	    $this->db->join('user', 'errors.user_id = user.id', 'INNER JOIN');

	    $this->db->limit($length, $start);

	    $data['error_logs'] = $this->db->get()->result_array();

	    // Get total records without limit for pagination
	    $totalRecords = $this->db->count_all_results('errors');

	    // Prepare response for DataTables
	    $response = array(
	        'draw' => intval($draw),
	        'recordsTotal' => $totalRecords,
	        'recordsFiltered' => $totalRecords,
	        'data' => $data['error_logs'],
	    );

	    $this->output->set_content_type('application/json');
	    $this->output->set_output(json_encode($response));
	    // $this->load->view('layouts/publisher/error_page');
	}*/

	public function error_logs_api()
	{
	    $draw = $this->input->get('draw');
	    $start = $this->input->get('start');
	    $length = $this->input->get('length');
	    $search = $this->input->get('search')['value']; // Get search value

	    // Your modified query
	    $this->db->select('errors.*, user.fname as first_name, user.lname as last_name, user.username as uname');
	    $this->db->from('errors');
	    $this->db->join('user', 'errors.user_id = user.id', 'INNER JOIN');
	    $this->db->order_by('errors.user_id','ASC');

	    // Apply search condition
	    if (!empty($search)) {
	        $this->db->group_start();
	        $this->db->like('errors.user_id', $search);
	        $this->db->or_like('user.fname', $search);
	        $this->db->or_like('user.lname', $search);
	        $this->db->or_like('user.username', $search);
	        $this->db->or_like('errors.error_channel', $search);
	        $this->db->or_like('errors.channel_name', $search);
	        $this->db->or_like('errors.error', $search);
	        $this->db->or_like('errors.date_time', $search);
	        $this->db->or_like('errors.status', $search); // Adjust based on your actual column name
	        $this->db->group_end();
	    }

	    $this->db->limit($length, $start);

	    $data['error_logs'] = $this->db->get()->result_array();

	    // Get total records without limit for pagination
	    $totalRecords = $this->db->count_all_results('errors');

	    // Prepare response for DataTables
	    $response = array(
	        'draw' => intval($draw),
	        'recordsTotal' => $totalRecords,
	        'recordsFiltered' => $totalRecords,
	        'data' => $data['error_logs'],
	    );

	    $this->output->set_content_type('application/json');
	    $this->output->set_output(json_encode($response));
	    // $this->load->view('layouts/publisher/error_page');
	}

	// public function error_logs_api()
	// {
	//     $draw = $this->input->get('draw');
	//     $start = $this->input->get('start');
	//     $length = $this->input->get('length');
	//     $search = $this->input->get('search')['value']; // Get search value

	//     // Your modified query
	//     $this->db->select('errors.*, user.username as uname');
	//     $this->db->from('errors');
	//     $this->db->join('user', 'errors.user_id = user.id', 'INNER JOIN');

	//     // Apply search condition
	//     if (!empty($search)) {
	//         $this->db->group_start();
	//         $this->db->like('errors.user_id', $search);
	//         $this->db->or_like('user.username', $search);
	//         $this->db->or_like('errors.error_channel', $search);
	//         $this->db->or_like('errors.channel_name', $search);
	//         $this->db->or_like('errors.error', $search);
	//         $this->db->or_like('errors.date_time', $search);
	//         $this->db->or_like('errors.status', $search); // Adjust based on your actual column name
	//         $this->db->group_end();
	//     }

	//     $this->db->limit($length, $start);

	//     $data['error_logs'] = $this->db->get()->result_array();

	//     // Get total records without limit for pagination
	//     $totalRecords = $this->db->count_all_results('errors');

	//     // Prepare response for DataTables
	//     $response = array(
	//         'draw' => intval($draw),
	//         'recordsTotal' => $totalRecords,
	//         'recordsFiltered' => $totalRecords,
	//         'data' => $data['error_logs'],
	//     );

	//     $this->output->set_content_type('application/json');
	//     $this->output->set_output(json_encode($response));
	//     // $this->load->view('layouts/publisher/error_page');
	// }




	public function signin()
	{
		if (!$this->Publisher_model->check_logged()) {

			$this->load->view('layouts/publisher/signin');
		} else {

			redirect(SITEURL . "dashboard");
		}
	}

	public function sessioncheck()
	{

		if (!$this->Publisher_model->check_logged()) {

			redirect(SITEURL);
		} else {

			$m_id = App::Session()->get('membership_id');
			$team_role = App::Session()->get('team_role');
			if ($m_id == 0 &&  $team_role == 'owner') {
				redirect(SITEURL . 'payments-and-subscriptions?notice=nomem');
			} else if ($m_id == 0 &&  $team_role == 'affiliate') {

				//redirect(SITEURL.'dashboard?notice=nomem');	

			}
		}
	}

	public function testing()
	{
		$month_ago = date('Y-m-d', strtotime('-1 month'));
		echo '<pre>'; print_r($month_ago); exit;
		// $query = $this->db->where('short_urls.url_addedd <=', );	`
	}

	public function dashboard()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$username = App::Session()->get('MMP_username');
		$phone = App::Session()->get('phone');
		$name = App::Session()->get('fullname');
		$email = App::Session()->get('email');
		$data['name'] = $name;
		$data['phone'] = $phone;
		$data['email'] = $email;

		$data['user'] = $this->Publisher_model->retrieve_record('user', $userID);
		$this->load->library('facebook');
		$data['user_pages'] = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $userID));

		$data['pinterest_login_url'] = $this->Publisher_model->get_pinterest_login_url();
		$data['pinterest_boards'] = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $userID));

		$data['pinterest_account'] = $this->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $userID));

		$data['instagram_login_url'] = $this->Publisher_model->get_instagram_login_url();
		$data['ig_accounts'] = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $userID, 'active' => 'y'));

		$data['connect_facebook_groups'] = $this->Publisher_model->get_fbgroups_login_url();
		$data['fb_groups'] = $this->Publisher_model->get_allrecords('facebook_groups', array('user_id' => $userID, 'active' => 'y'));

		// facebook login
		$data['connect_facebook'] = $this->Publisher_model->get_facebook_login_url();

		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$team_role = App::Session()->get('team_role');
		if ($team_role == "affiliate") {
			$this->load->view('templates/publisher/header', $roles_data);
			$this->load->view('layouts/publisher/affiliate-dashboard', $data);
		} else {
			$this->load->view('templates/publisher/header', $roles_data);
			$this->load->view('layouts/publisher/owner-dashboard', $data);
		}
	}

	public function settings()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/settings');
	}

	public function user_error_log(){
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$get_connected_channels = $this->Publisher_model->get_channels_settings($userID);


		$fb_pages = &$get_connected_channels['fbpages'];
		foreach ($fb_pages as &$page) {
		    $error_coulmn_data = $this->Publisher_model->get_error_column_from_error_table($userID, $page['page_name']);
		    if(!empty($error_coulmn_data)){
		    	$page['error'] = $error_coulmn_data[0]['error'];
			    $page['date'] = date('Y-m-d', strtotime($error_coulmn_data[0]['date_time']));
		    } else {
		    	$page['error'] = 'Looks Good';
		    }

		    $table = 'rsssceduler';
		    $select_cols = 'url,post_datetime,error';
		    $where = array('user_id' => $userID, 'page_id' => $page['id'], 'posted' => -1);
		    $rss_error_links = $this->Publisher_model->get_rss_error_links($table, $select_cols, $where);

		    $page['rss_error_array'] = array();

		    if (!empty($rss_error_links)) {
		        foreach ($rss_error_links as $rss_error_link) {
		            $page['rss_error_array'][] = array(
		                'url' => $rss_error_link['url'],
		                'rss_date' => date('Y-m-d', strtotime($rss_error_link['post_datetime'])),
		                'rss_error' => $rss_error_link['error'],
		            );
		        }
		    } else {
		        // If no RSS error links found, set default values
		        $page['rss_error_array'][] = array(
		            'url' => '',
		            'rss_date' => date('Y-m-d'),
		            'rss_error' => 'Looks Good',
		        );
		    }
		}
		unset($page);

		$pinterest_boards = &$get_connected_channels['boards'];
		foreach ($pinterest_boards as &$board) {
		    $error_coulmn_data = $this->Publisher_model->get_error_column_from_error_table($userID, $board['name']);
		    if(!empty($error_coulmn_data)){
			    $board['error'] = $error_coulmn_data[0]['error'];
			    $board['date'] = date('Y-m-d', strtotime($error_coulmn_data[0]['date_time']));
			} else {
		    	$board['error'] = 'Looks Good';
			}

			$table = 'pinterest_scheduler';
		    $select_cols = 'url,publish_datetime,error';
		    $where = array('user_id' => $userID, 'board_id' => $board['id'], 'published' => -1);
		    $rss_error_links = $this->Publisher_model->get_rss_error_links($table, $select_cols, $where);

		    $board['rss_error_array'] = array(); // Initialize the array

		    if (!empty($rss_error_links)) {
		        foreach ($rss_error_links as $rss_error_link) {
		            $board['rss_error_array'][] = array(
		                'url' => $rss_error_link['url'],
		                'rss_date' => date('Y-m-d', strtotime($rss_error_link['publish_datetime'])),
		                'rss_error' => $rss_error_link['error'],
		            );
		        }
		    } else {
		        // If no RSS error links found, set default values
		        $board['rss_error_array'][] = array(
		            'url' => '',
		            'rss_date' => date('Y-m-d'),
		            'rss_error' => 'Looks Good',
		        );
		    }
		}
		unset($board);

		$ig_accounts = &$get_connected_channels['ig_accounts'];
		foreach ($ig_accounts as &$account) {
		    $error_coulmn_data = $this->Publisher_model->get_error_column_from_error_table($userID, $account['instagram_username']);
		    if(!empty($error_coulmn_data)){
		    	$account['error'] = $error_coulmn_data[0]['error'];
			    $account['date'] = date('Y-m-d', strtotime($error_coulmn_data[0]['date_time']));
		    } else {
		    	$account['error'] = 'Looks Good';
		    }

		    $table = 'instagram_scheduler';
		    $select_cols = 'url,publish_datetime,error';
		    $where = array('user_id' => $userID, 'ig_id' => $account['id'], 'published' => -1);
		    $rss_error_links = $this->Publisher_model->get_rss_error_links($table, $select_cols, $where);

		    $account['rss_error_array'] = array(); // Initialize the array

		    if (!empty($rss_error_links)) {
		        foreach ($rss_error_links as $rss_error_link) {
		            $account['rss_error_array'][] = array(
		                'url' => $rss_error_link['url'],
		                'rss_date' => date('Y-m-d', strtotime($rss_error_link['publish_datetime'])),
		                'rss_error' => $rss_error_link['error'],
		            );
		        }
		    } else {
		        // If no RSS error links found, set default values
		        $account['rss_error_array'][] = array(
		            'url' => '',
		            'rss_date' => date('Y-m-d'),
		            'rss_error' => 'Looks Good',
		        );
		    }
		}
		unset($account);

		$fb_groups = &$get_connected_channels['fb_groups'];
		foreach ($fb_groups as &$group) {
			$error_coulmn_data = $this->Publisher_model->get_error_column_from_error_table($userID, $group['name']);
		    if(!empty($error_coulmn_data)){
			    $group['error'] = $error_coulmn_data[0]['error'];
			    $group['date'] = date('Y-m-d', strtotime($error_coulmn_data[0]['date_time']));
			} else {
			    $group['error'] = 'Looks Good';
			}

			$table = 'facebook_group_scheduler';
		    $select_cols = 'url,publish_datetime,error';
		    $where = array('user_id' => $userID, 'fb_group_id' => $group['id'], 'published' => -1);
		    $rss_error_links = $this->Publisher_model->get_rss_error_links($table, $select_cols, $where);

		    $group['rss_error_array'] = array(); // Initialize the array

		    if (!empty($rss_error_links)) {
		        foreach ($rss_error_links as $rss_error_link) {
		            $group['rss_error_array'][] = array(
		                'url' => $rss_error_link['url'],
		                'rss_date' => date('Y-m-d', strtotime($rss_error_link['publish_datetime'])),
		                'rss_error' => $rss_error_link['error'],
		            );
		        }
		    } else {
		        // If no RSS error links found, set default values
		        $group['rss_error_array'][] = array(
		            'url' => '',
		            'rss_date' => date('Y-m-d'),
		            'rss_error' => 'Looks Good',
		        );
		    }
		}
		unset($group);

		// $error_log['user_errors'] = $this->Publisher_model->get_user_errors($userID);
		$data['get_connected_channels'] = $get_connected_channels;
		$this->load->view('templates/publisher/header', $data);
		$this->load->view('layouts/publisher/user_error_log');	
	}


	public function affiliatemarketing()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/affiliatemarketing');
	}

	public function affiliateteam()
	{

		$this->sessioncheck();
		$team_id 		= App::Session()->get('team_id');
		$userID = App::Session()->get('userid');
		$data['roles'] 	= $this->Publisher_model->get_active_roles($userID);
		$data['user']    = $this->Publisher_model->retrieve_record('user', $userID);
		$team_where[0]['key'] = "team_id";
		$team_where[0]['value'] = $team_id;
		$users 	= $this->Publisher_model->list_records('user', 0, 1000, $team_where);
		foreach ($users as $key => $user) {
			$query = $this->db->query("select ROUND(sum(earn) , 2) as earn from click where user = '" . $user->username . "'");
			$earning = $query->row()->earn;
			$query = $this->db->query("select ROUND(sum(earning) , 2) as earn from revenue where user_id = '" . $user->id . "'");
			$users[$key]->totalearn = $earning + $query->row()->earn;
		}
		$data['users']  = $users;
		$data['team'] 	= $this->Publisher_model->retrieve_record('team', $team_id);
		$this->load->view('templates/publisher/header', $data);
		$this->load->view('layouts/publisher/affiliateteam');
	}
	public function	affiliatemanage()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/affiliatemanage');
	}
	public function affiliatemanageppcrates()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$data['countries'] = $this->Publisher_model->list_records('country', 0, 1000, null, 'id', 'ASC');
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/affiliatemanageppcrates', $data);
	}
	public function affiliatechangedomain()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$data = $this->Publisher_model->changedomainowner($userID);
		$data['user'] = $user;
		$this->load->view('layouts/publisher/affiliatechangedomain', $data);
	}
	public function affiliatemanageredirectdomain()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = $userID;
		$data['domains'] = $this->Publisher_model->list_records('domains', 0, 2000, $where, 'id', 'DESC');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/affiliatemanageredirectdomain', $data);
	}
	public function affiliatemanageanalyticsdomain()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$where[0]['key'] = 'user_id';
		$where[0]['value'] = $userID;
		$data['domains'] = $this->Publisher_model->list_records('articledomains', 0, 2000, $where, 'id', 'DESC');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/affiliatemanageanalyticsdomain', $data);
	}

	public function affiliatetrafficsummary()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if (App::Session()->get('team_role') != 'owner') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$user = $this->Publisher_model->retrieve_record('user', $userID);
			$data = $this->Publisher_model->changedomainowner($userID);
			$data['user'] = $user;
			$this->load->view('layouts/publisher/affiliatetrafficsummary', $data);
		}
	}
	public function affiliatetrafficsummaryuserwise()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if (App::Session()->get('team_role') != 'owner') {
			$this->load->view('layouts/publisher/access_denied');
		} else {

			$this->load->view('layouts/publisher/affiliatetrafficsummaryuserwise');
		}
	}
	public function affiliatetrafficsummarycampaignwise()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if (App::Session()->get('team_role') != 'owner') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$this->load->view('layouts/publisher/affiliatetrafficsummarycampaignwise');
		}
	}
	public function affiliatetrafficsummarycountrywise()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);

		if (App::Session()->get('team_role') != 'owner') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$team_id = App::Session()->get('team_id');
			$team_where[0]['key'] = "team_id";
			$team_where[0]['value'] = $team_id;
			$data['users'] 	= $this->Publisher_model->list_records('user', 0, 1000, $team_where);
			$this->load->view('layouts/publisher/affiliatetrafficsummarycountrywise', $data);
		}
	}
	public function paymentsubscriptions()
	{


		if (!$this->session_exists()) {
			redirect(SITEURL . 'signin');
		}

		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if (App::Session()->get('team_role') != 'owner') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$data['user']    = $this->Publisher_model->retrieve_record('user', $userID);
			$data['packages'] = $this->Publisher_model->getPakcages();
			$where[0]['key'] = 'user_id';
			$where[0]['value'] =  $userID;
			$data['transections'] = $this->Publisher_model->list_records('payments', $offset = 0, $limit = 10000, $where, 'id', 'DESC');
			$data['data']  = Stats::userHistory(App::Auth()->uid, 'expire');
			$data['totals'] = Stats::userTotals();
			$this->load->view('layouts/publisher/paymentsubscriptions', $data);
		}
	}


	public function thankyou()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Website Widgets', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);

		if (App::Session()->get('team_role') != 'owner') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$this->load->view('layouts/publisher/thankyou');
		}
	}


	public function widgetArea()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Website Widgets', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if ($role_status->status == 'InActive') {

			$this->load->view('layouts/publisher/access_denied');
		} else {

			$results['all_categories'] = $this->Publisher_model->get_allrecords('link_cat', '');
			$this->load->view('layouts/publisher/widgets', $results);
		}
	}


	public function campaigns()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Campaign', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);

		if ($role_status->status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {

			$keyword = $this->input->post_get('keyword');
			$popularity = $this->input->post_get('popularity');
			$cat = $this->input->post_get('cat');
			$request = $this->input->post_get('request');
			$all_pages = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $userID));
			$data = $this->get_campaigns($request, $cat, 'all', $keyword);
			$data['pages'] = (array) $all_pages;
			$all_boards =  $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $userID));
			$data['boards'] = (array) $all_boards;
			$all_ig_users =  $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $userID, 'active' => 'y'));
			$data['ig_users'] = (array) $all_ig_users;
			$data['fb_groups'] = $this->Publisher_model->get_allrecords('facebook_groups', array('user_id' => $userID, 'active' => 'y'));
			$data['instagram_login_url'] = $this->Publisher_model->get_instagram_login_url();
			$data['pinterest_login_url'] = $this->Publisher_model->get_pinterest_login_url();
			$team_role = App::Session()->get('team_role');
			if ($team_role == 'owner') {
				$this->load->view('layouts/publisher/affiliatecampaigns', $data);
			} else {
				$this->load->view('layouts/publisher/campaigns', $data);
			}
		}
	}
	public function affiliateaddcampaign()
	{

		$data['categories'] = $this->Publisher_model->list_records('link_cat', 0, 1000);
		$this->load->view('templates/publisher/header');
		$this->load->view('layouts/publisher/affiliateaddcampaign', $data);
	}
	public function affiliateeditcampaign($id)
	{

		$where[0]['key'] = 'user_id';
		$where[0]['value'] = App::Session()->get('userid');
		$data['campaign'] = $this->Publisher_model->retrieve_record('link', $id, $where);
		$data['categories'] = $this->Publisher_model->list_records('link_cat', 0, 1000);

		$this->load->view('templates/publisher/header');
		$this->load->view('layouts/publisher/affiliateeditcampaign', $data);
	}
	public function add_new_menu($id)
	{

		$this->Publisher_model->add_new_menu($id);
	}


	public function facebookbulkupload()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Facebook Bulk Upload', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$status = @$role_status->status;


		if ($status == "" || $status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$this->load->library('facebook');
			$all_pages = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $userID, 'active_deactive_status' => 1));
			$data['user_pages'] =  $all_pages;
			$this->load->view('layouts/publisher/facebookbulkupload', $data);
		}
	}

	public function contentbulkupload()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Facebook Bulk Upload', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$status = @$role_status->status;

		if ($status == "" || $status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$data['user'] = $this->Publisher_model->retrieve_record('user', $userID);

			$this->load->library('facebook');
			$data['user_pages'] = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $userID));

			$data['pinterest_login_url'] = $this->Publisher_model->get_pinterest_login_url();
			$data['pinterest_boards'] = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $userID));

			$data['pinterest_account'] = $this->Publisher_model->get_allrecords('pinterest_users', array('user_id' => $userID));

			$data['instagram_login_url'] = $this->Publisher_model->get_instagram_login_url();
			$data['ig_accounts'] = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $userID, 'active' => 'y'));

			$data['connect_facebook_groups'] = $this->Publisher_model->get_fbgroups_login_url();
			$data['fb_groups'] = $this->Publisher_model->get_allrecords('facebook_groups', array('user_id' => $userID, 'active' => 'y'));

			// facebook login
			$data['connect_facebook'] = $this->Publisher_model->get_facebook_login_url();
			
			$this->load->view('layouts/publisher/contentbulkupload', $data);
		}
	}

	public function get_fbgroups_access_token_GET()
	{
		$this->Publisher_model->get_fbgroups_access_token();
	}

	// public function rssfeed(){

	//     $this->sessioncheck();
	// 	$userID = App::Session()->get('userid');
	// 	$role_status=$this->Publisher_model->get_specific_role('Rss Feed',$userID);
	// 	$roles_data['roles']=$this->Publisher_model->get_active_roles($userID);
	// 	$this->load->view('templates/publisher/header',$roles_data);
	//     $status = @$role_status->status;
	// 	if($status == "" || $status=='InActive')
	// 	{
	// 		$this->load->view('layouts/publisher/access_denied');
	// 	}
	//     else{
	//         $this->load->library('facebook');
	//         $all_pages = $this->Publisher_model->get_allrecords('facebook_pages' , array('user_id' => $userID));
	//         $data['user_pages'] =  $all_pages;
	// 		$this->load->view('layouts/publisher/rssfeed' , $data);

	//     }
	// }
	public function rssfeed()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Rss Feed', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$status = @$role_status->status;
		if ($status == "" || $status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$this->load->library('facebook');
			$all_pages = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $userID, 'active_deactive_status' => 1));

			$data['user_pages'] =  $all_pages;
			$pinterest_boards = $this->Publisher_model->get_allrecords('pinterest_boards', array('user_id' => $userID, 'active_deactive_status' => 1));
			$data['pinterest_boards'] =  $pinterest_boards;
			$data['ig_accounts'] = $this->Publisher_model->get_allrecords('instagram_users', array('user_id' => $userID, 'active' => 'y', 'active_deactive_status' => 1));
			$data['fb_groups'] = $this->Publisher_model->get_allrecords('facebook_groups', array('user_id' => $userID, 'active' => 'y', 'active_deactive_status' => 1));
			$data['pinterest_login_url'] = $this->Publisher_model->get_pinterest_login_url();
			$data['instagram_login_url'] = $this->Publisher_model->get_instagram_login_url();

			$this->db->select('used,quota')->from('package_feature_user_limit')->where('uid',$userID)->where('fid',1);
			$query = $this->db->get()->result();
			$data['package_feature_user_limit'] = $query[0]->used; 
			$data['package_feature_user_quota'] = $query[0]->quota; 
			// $data['package_feature_user_limit'];
			// $data['package_feature_user_quota'];

			$this->load->view('layouts/publisher/rssfeed', $data);
		}
	}

	public function instagrambulkupload()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Instagram Bulk Upload', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$status = @$role_status->status;


		if ($status == "" || $status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {

			$data['user'] = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$data['user'] = $data['user'][0];
			$this->load->view('layouts/publisher/instagrambulkupload', $data);
		}
	}

	public function instagramstorybulkupload()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Instagram Bulk Upload', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$status = @$role_status->status;


		if ($status == "" || $status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {

			$data['user'] = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$data['user'] = $data['user'][0];
			$this->load->view('layouts/publisher/instagramstorybulkupload', $data);
		}
	}
	public function facebook()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Facebook Auto Post', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if ($role_status->status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$this->load->library('facebook');
			$user = $this->Publisher_model->retrieve_record('user', $userID);
			// Check if user is logged in
			$registered = "not_registered";
			$user_pages = [];
			if ($user->facebook_id != "") {
				// $this->facebook->set_access_token($user->facebook_permanent_token);
				/*	if($user->facebook_dp == ""){
							$this->facebook->user_setDefaultAccessToken($user->facebook_permanent_token);
							$user_live = $this->facebook->request('get', '/me/picture?redirect=false&height=300');
							$user->facebook_dp = "";

							if(!isset($user_live['error']))
							{
								
									$user->facebook_dp= $user_live['data']['url'];
									$user_data = [];
									$user_data['facebook_dp'] = $user_live['data']['url'];
									$result = $this->Publisher_model->update_record('user', $user_data , $userID);

							}
						} */
				$registered = "registered";
				$all_pages = $this->Publisher_model->get_allrecords('facebook_pages', array('user_id' => $userID, 'active_deactive_status' => 1));


				if ($all_pages) {

					foreach ($all_pages as $row) { {
							//if($row->image_url == ""){
							//$this->facebook->set_access_token($row->access_token);
							/*$picture = $this->facebook->request('get',  '/'.$row->page_id.'/picture?redirect=false&height=300',$row->access_token);
									if(!isset($picture['error']))
									{
										$row->image_url = $picture['data']['url'];
									}else{
										$row->image_url = "";
									}
									$user_page_data = [];
									$user_page_data['image_url'] = $picture['data']['url'];
									$result_update_page = $this->Publisher_model->update_record('facebook_pages', $user_page_data , $row->id);
							*/
							//	}
							$user_pages[] = (array)$row;
						}
					}
				}
			}

			$user->posting_start = utcToLocal($user->posting_start, $user->gmt, "h:i A");
			$user->posting_end = utcToLocal($user->posting_end, $user->gmt, "h:i A");
			$data['user'] = $user;
			$data['registered'] =  $registered;
			$data['user_pages'] =  $user_pages;
			$data['user_domains'] = [];
			$data['user_domains'] = $this->Publisher_model->get_allrecords('articledomains', array('user_id' => $userID, 'status' => 'active'));
			$this->load->view('layouts/publisher/facebook', $data);
		}
	}
	public function redirect()
	{
		$this->load->library('facebook');
		$access_token = $this->Publisher_model->get_facebook_access_token();
		
		if ($access_token) {
			$userID = App::Session()->get('userid');
			$user = $this->facebook->request('get', '/me?fields=id,name,email,picture', $access_token);

			if (!isset($user['error'])) {
				$data = $user;
			}
			$user_data = [];
			$user_data['facebook_id'] = $data['id'];
			$user_data['facebook_name'] = $data['name'];
			$user_data['facebook_email'] = $data['email'];
			$user_data['facebook_permanent_token'] = $access_token;
			$user_data['facebook_permanent_token_genarated_date'] = date("Y-m-d");
			$result = $this->Publisher_model->update_record('user', $user_data, $userID);
			$pages = $this->facebook->request('get', '/me/accounts?id,name', $access_token);
			// if (!isset($pages['error'])) {
			// 	$multiple = $this->Publisher_model->delete_multiple('facebook_pages', 'user_id', $userID);
			// 	$user_pages = $pages['data'];
			// }
			$user_pages = $pages['data'];
			if ($user_pages) {
				foreach ($user_pages as $page) {
					// check page will check if there is already a page with same page id and user id
					$where = array('id' => $page['id'], 'user_id' => $userID);
					$check_page = $this->Publisher_model->check_page('facebook_pages', $where);
					if(!empty($check_page)){
						//Now if there is already page we will update its active_deactive_status to 1.
						$params = array('id' => $page['id'], 'user_id' => $userID, 'name' => $page['name'], 'access_token' => $page['access_token']);
						$get_primary_id_in_return_of_table = $this->Publisher_model->update_active_deactive_status('facebook_pages', $params);
						if($get_primary_id_in_return_of_table){
							$this->db->where('channel_id',$get_primary_id_in_return_of_table)->where('user_id',$userID);
							$this->db->where('type','facebook');
							$this->db->set('active_deactive_status',1);
							$this->db->update('channels_scheduler');
						}
					}
					else {
						$page_data['user_id'] = $userID;
						$page_data['page_id'] = $page['id'];
						$page_data['page_name'] = $page['name'];
						$page_data['image_url'] = '';
						$page_data['access_token'] =  $page['access_token'];

						$users = $this->Publisher_model->create_record('facebook_pages', $page_data);
					}

				}
			} else {
				redirect(SITEURL . 'facebook?status=false');
			}
			if ($result) {
				redirect(SITEURL . 'facebook?status=true');
			} else {
				redirect(SITEURL . 'facebook?status=false');
			}
		} else {
			redirect(SITEURL . 'facebook?status=false');
		}
	}

	public function redirectaddpage()
	{

		$this->load->library('facebook');
		$results = $this->facebook->callback_method();
		$userID = App::Session()->get('userid');
		$user = $this->facebook->request('get', '/me?fields=id,name,email,picture', $results);
		if (!isset($user['error'])) {
			$data = $user;
			$user_data = [];
			$user_data['facebook_id'] = $data['id'];
			$user_data['facebook_name'] = $data['name'];
			$user_data['facebook_email'] = $data['email'];
			$user_data['facebook_permanent_token'] = $results;
			$user_data['facebook_permanent_token_genarated_date'] = date("Y-m-d");

			$result = $this->Publisher_model->update_record('user', $user_data, $userID);
			$pages = $this->facebook->request('get', '/me/accounts?id,name');
			if (!isset($pages['error'])) {
				//$multiple = $this->Publisher_model->delete_multiple('facebook_pages', 'user_id' ,$userID);
				$user_pages = $pages['data'];
				if ($user_pages) {
					foreach ($user_pages as $page) {

						$check_page = [];
						$check_page[0]['key'] = "page_id";
						$check_page[0]['value'] = $page['id'];
						$check_page[1]['key'] = "user_id";
						$check_page[1]['value'] = $userID;
						$exists = $this->Publisher_model->list_records('facebook_pages', 0, 1, $check_page, 'id', 'DESC');
						if ($exists) {
							$page_id =  $exists[0]->id;
							$page_data_update['access_token'] =  $page['access_token'];
							$result = $this->Publisher_model->update_record('facebook_pages', $page_data_update, $page_id);
							continue;
						} else {

							$page_data['user_id'] = $userID;
							$page_data['page_id'] = $page['id'];
							$page_data['page_name'] = $page['name'];
							$page_data['image_url'] = '';
							$page_data['access_token'] =  $page['access_token'];
							$new_page = $this->Publisher_model->create_record('facebook_pages', $page_data);
						}
					}
				}
			}

			redirect(SITEURL . 'facebookbulkupload?status=true');
		} else {

			redirect(SITEURL . 'facebookbulkupload?status=false');
		}
	}


	public function get_campaigns($request = NULL, $cat = NULL, $popularity = NULL, $keyword = NULL)
	{
		$this->sessioncheck();

		$userID = App::Session()->get('userid');
		$username = App::Session()->get('MMP_username');
		$all_categories = $this->Publisher_model->get_allrecords('link_cat', '');
		$results['all_categories'] = $all_categories;
		$data['all_domains'] = $this->Publisher_model->get_domains();
		$user_id = App::Session()->get('userid');
		$data['save_filter'] = $this->Publisher_model->already_save_filter($user_id);
		$rates = '';
		$rpmcodes = array("us", "uk", "au", "ca", "in");
		$rpmnames = array("United States", "United Kingdom", "Australia", "Canada", "India");
		$count = 0;
		foreach ($rpmnames as  $value) {
			$todayrpm = $this->Publisher_model->get_rates($value);
			$todayrpm = round($todayrpm * 1000, 2);
			$rates .= '<div class="chart-text m-r-8" style="    margin-right: 10px;">
				            <h4 class="m-b-0 m-r-5" ><small style="font-size: 65%;font-weight: 600;">$' . sprintf('%0.2f', $todayrpm) . '</small></h4>
				            <h4 class="m-t-0 text-center m-r-5"><small style="font-size: 65%;font-weight: 500;text-align:center;text-transform: uppercase;">' . $rpmcodes[$count] . '</small></h4>
				        
				    </div>';
			$count++;
		}
		$todayrpm = $this->Publisher_model->get_avg_rates();
		$todayrpm = round($todayrpm * 1000, 2);

		$rates .= '<div class="chart-text m-r-8" style="    margin-right: 10px;">
                                    <h4 class="m-b-0 m-r-5"><small style="font-size: 65%;font-weight: 600;">$' . sprintf('%0.2f', $todayrpm) . '</small></h4>
                                    <h4 class="m-t-0 text-center m-r-5"><small style="font-size: 65%;font-weight: 500;text-align:center;text-transform: uppercase;">Other</small></h4>
                                
                            </div>';


		$data['all_categories'] = $all_categories;
		$data['rates'] = $rates;
		return $data;
	}
	public function add_paymentmethod()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$paypal_email   = $this->input->post_get('paypal_email');
		$payoneer_email = $this->input->post_get('payoneer_email');
		$user_data['paypal_email'] = $paypal_email;
		$user_data['payoneer_email'] = $payoneer_email;
		$result = $this->Publisher_model->update_record('user', $user_data, $userID);
		redirect(SITEURL . 'payment-method');
	}
	public function paymentmethod()
	{

		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$data['user'] = $this->Publisher_model->retrieve_record('user', $userID);
		if (App::Session()->get('team_role') != 'affiliate') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$this->load->view('layouts/publisher/payment_method', $data);
			$this->load->view('templates/publisher/footer');
		}
	}




	public function logout()
	{
		App::Session()->endSession();
		// $this->session->sess_destroy();
		redirect(SITEURL);
	}


	public function  session_exists()
	{

		return (App::Session()->get('userid')) ? TRUE : FALSE;
	}

	public function changepassword()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Change Password', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if ($role_status->status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {

			//$this->load->view('templates/publisher/header',$roles_data);
			$this->load->view('layouts/publisher/changepass');
		}
		$this->load->view('templates/publisher/footer');
	}
	public function trafficsummary()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Traffic Summary', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);

		if ($role_status->status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$data = $this->Publisher_model->trafficsummary();

			$this->load->view('layouts/publisher/trafficsummary', $data);
		}
	}
	public function earningsummary()
	{

		$this->sessioncheck();
		$this->load->view('templates/publisher/header');
		$this->load->view('layouts/publisher/earningsummary');
	}
	public function editprofile()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$role_status = $this->Publisher_model->get_specific_role('Update Profile', $userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		if ($role_status->status == 'InActive') {
			$this->load->view('layouts/publisher/access_denied');
		} else {
			$userdata = $this->Publisher_model->get_allrecords('user', array('id' => $userID));
			$data['fname'] = $userdata[0]->fname;
			$data['lname'] = $userdata[0]->lname;
			$data['ph'] = $userdata[0]->ph;
			$data['email'] = $userdata[0]->email;
			$data['username'] = $userdata[0]->username;
			$data['fb_profile'] = $userdata[0]->fbprofile;
			$data['fb_page'] = $userdata[0]->fbpage;
			$data['gmt'] = $userdata[0]->gmt;
			$this->load->view('layouts/publisher/editprofile', $data);
		}
	}

	public function signup()
	{
		if (!$this->Publisher_model->check_logged()) {

			$this->load->view('layouts/publisher/signup');
		} else {

			redirect(SITEURL . "dashboard");
		}
	}

	public function user_exists_ajax()
	{
		$username = $this->input->post_get('username');
		if ($this->Publisher_model->check_username($username)) {
			echo "notexists";
		} else {
			echo "exists";
		}
	}

	public function annoucement_area()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$data['announces'] = $this->Publisher_model->get_active_announcements();
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/annoucement_area', $data);
	}

	public function notifications_area()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$data['notifications'] = $this->Publisher_model->get_notifications();
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/notifications_area', $data);
	}

	public function create_article()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$data['categories'] = $this->Publisher_model->list_records('link_cat', 0, 1000);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/createarticle', $data);
	}

	public function manage_article()
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		//$data['announces']=$this->Publisher_model->get_active_announcements();
		$data['articles'] = $this->Publisher_model->get_user_articles($userID);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/manage_article', $data);
	}

	public function edit_article($article_id)
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		//$data['announces']=$this->Publisher_model->get_active_announcements();
		$data['articles'] = $this->Publisher_model->get_article_content($article_id);
		$data['categories'] = $this->Publisher_model->list_records('link_cat', 0, 1000);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/edit_article', $data);
	}

	public function preview_article($article_id)
	{
		$this->sessioncheck();
		$userID = App::Session()->get('userid');
		$data['articles'] = $this->Publisher_model->get_article_content($article_id);
		$roles_data['roles'] = $this->Publisher_model->get_active_roles($userID);
		$this->load->view('templates/publisher/header', $roles_data);
		$this->load->view('layouts/publisher/preview_article', $data);
	}

	function terms()
	{

		$this->load->view('layouts/publisher/terms');
	}

	function privacy()
	{

		$this->load->view('layouts/publisher/privacy');
	}

	function termsfb()
	{

		$this->load->view('layouts/publisher/termsfb');
	}

	public function forgot()
	{

		$this->load->view('layouts/publisher/forgotpass');
	}

	public function get_pinterest_access_token()
	{
		$this->load->model('Publisher_model');
		$this->Publisher_model->get_pinterest_access_token();
	}

	public function get_pinterest_boards()
	{
		$this->load->model('Publisher_model');
		$this->Publisher_model->get_pinterest_boards();
		if ("::1" == $_SERVER['REMOTE_ADDR']) {
			redirect('http://localhost/adublisher/contentbulkupload/');
		} else {
			redirect(SITEURL . 'contentbulkupload/');
		}
	}

	// public function pinterest_rssfeed(){

	//     $this->sessioncheck();
	// 	$userID = App::Session()->get('userid');
	// 	$role_status=$this->Publisher_model->get_specific_role('Rss Feed',$userID);
	// 	$roles_data['roles']=$this->Publisher_model->get_active_roles($userID);
	// 	$this->load->view('templates/publisher/header',$roles_data);
	//     $status = @$role_status->status;
	// 	if($status == "" || $status=='InActive')
	// 	{
	// 		$this->load->view('layouts/publisher/access_denied');
	// 	}
	//     else{
	// 		$pinterest_boards = $this->Publisher_model->get_allrecords('pinterest_boards' , array('user_id' => $userID));
	// 		$data['pinterest_boards'] =  $pinterest_boards;
	//         $this->load->library('facebook');
	//         $all_pages = $this->Publisher_model->get_allrecords('facebook_pages' , array('user_id' => $userID));
	//         $data['user_pages'] =  $all_pages;
	// 		$data['pinterest_login_url'] = $this->Publisher_model->get_pinterest_login_url();
	// 		$this->load->view('layouts/publisher/pinterest_rssfeed' , $data);
	//     }
	// }

}
