<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - dashboardwidgets_GET()
* - deleteCampaign_post()
* - addCategory_post()
* - editCategory_post()
* - deleteCategory_post()
* - addDomainArticle_post()
* - editDomainArticle_post()
* - getArticleDomains_get()
* - deleteDomainArticle_post()
* - addDomain_post()
* - editDomain_post()
* - deleteDomain_post()
* - addPackage_post()
* - editPackage_post()
* - deletePackage_post()
* - getPackageFeatures_GET()
* - updatePackageFeatures_POST()
* - addFeature_post()
* - editFeature_post()
* - deleteFeature_post()
* - redirectLinksettings_post()
* - systemDomain_post()
* - userActiveDomain_post()
* - userDefaultDomain_post()
* - getAdvDomains_get()
* - setUpdateAdvDomains_post()
* - getGenrates_get()
* - setUpdateGenrates_post()
* - updateGenrates_post()
* - updateGenassignAdv_post()
* - editPublisher_post()
* - deletePublisher_post()
* - payPublisher_post()
* - editCountry_post()
* - addAdmin_post()
* - updateUserDomains_post()
* - publisherReport_GET()
* - countryReport_GET()
* - campaignReport_GET()
* - getcountrywise_GET()
* - metaOfUrl_post()
* - get_site_meta_tags()
* - addCampaign_post()
* - updateCampaign_post()
* - get_campaigns_post()
* - notify_articles()
* - clean()
* - make_comparer()
* - users_roles_GET()
* - update_roles_GET()
* - edit_announcement_GET()
* - delete_announcement_GET()
* - create_announcement_GET()
* - top_users_GET()
* - prepare_email()
* Classes list:
* - Users extends REST_Controller
*/
defined('BASEPATH') OR exit('No direct script access allowed');

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
class Usersadmin extends REST_Controller
	{

	function __construct()
		{
		// Construct the parent class
		parent::__construct();
		$this->load->model('Admin_model');
        $this->load->model('Publisher_model');
        is_admin_logged_in();
		$this->load->library('email');
		}
	public function dashboardwidgets_GET()
		{
		$is_logged_in = App::Session()->get('admin_user_id');
		if (!isset($is_logged_in) || $is_logged_in != true)
			{
			redirect(SITEURL);
			}
		$userID = App::Session()->get('admin_user_id');
		$username = App::Session()->get('admin_username');
		$phone = App::Session()->get('admin_phone');
		$name = App::Session()->get('admin_name');
		$email = App::Session()->get('admin_email');
		$avatar = App::Session()->get('admin_avatar');

		$data['name'] = $name;
		$data['phone'] = $phone;
		$data['email'] = $email;
		$data['avatar'] = $avatar;

		$data['widgets'] = $this->Admin_model->dashboard();
		$this->response(array('status' => TRUE, 'Message' => 'data found', 'data' => $data,), REST_Controller::HTTP_OK);
		}

	public function deleteCampaign_post()
		{
        
		$id = $this->post('id');
		$result = $this->Admin_model->delete_record('link', $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function addCategory_post()
		{
		is_admin_logged_in();
		$data = [];
		$data['categury'] = $this->post('categury');
		$result = $this->Admin_model->create_record('link_cat', $data);

		if ($result)
			{
			$this->response(['status' => True, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function editCategory_post()
		{
		is_admin_logged_in();
		$id = $this->post('id');
		$data['categury'] = $this->post('categury');
		$result = $this->Admin_model->update_record('link_cat', $data, $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function deleteCategory_post()
		{
		is_admin_logged_in();
		$id = $this->post('id');
		$result = $this->Admin_model->delete_record('link_cat', $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function addDomainArticle_post()
		{

		$data = [];
		$data['domain'] = $this->post('domain');
		$data['status'] = $this->post('status');
		$data['username'] = $this->post('username');
		$data['password'] = $this->post('password');
		$data['property_id'] = $this->post('property');
		$result = $this->Admin_model->create_record('articledomains', $data);

		if ($result)
			{
			$this->response(['status' => True, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function editDomainArticle_post()
		{

		$id = $this->post('id');
		$data['domain'] = $this->post('domain');
		$data['status'] = $this->post('status');
		$data['username'] = $this->post('username');
		$data['password'] = $this->post('password');
		$data['property'] = $this->post('property');
		$data['rates_priority'] = $this->post('rates_priority');

		$result = $this->Admin_model->update_record('articledomains', array('status' => $data['status'], 'domain' => $data['domain'], 'username' => $data['username'], 'password' => $data['password'], 'property_id' => $data['property'], 'rates_priority' => $data['rates_priority']), $id);

		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function getArticleDomains_get()
		{

		$result = $this->Admin_model->list_records('articledomains', 0, 1000, array('key' => 'status', 'value' => 'active'));

		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}
	public function deleteDomainArticle_post()
		{

		$id = $this->post('id');
		$result = $this->Admin_model->delete_record('articledomains', $id);
		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function addDomain_post()
		{

		$data = [];
		$data['domain'] = $this->post('domain');
		$data['status'] = $this->post('status');
		$result = $this->Admin_model->create_record('domains', $data);

		if ($result)
			{
			$this->response(['status' => True, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function editDomain_post()
		{

		$id = $this->post('id');
		$data['domain'] = $this->post('domain');
		$data['status'] = $this->post('status');
		$result = $this->Admin_model->update_record('domains', array('status' => $data['status'], 'domain' => $data['domain']), $id);
		$res = $this->Admin_model->update_multiple('user_domains', array('status' => $data['status']), 'domain_id', $id);

		if ($result || $res)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function deleteDomain_post()
		{

		$id = $this->post('id');
		$result = $this->Admin_model->delete_record('domains', $id);
		$multiple = $this->Admin_model->delete_multiple('user_domains', 'domain_id', $id);

		if ($result || $multiple)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	//Packages
	public function addPackage_post()
		{

		$data = [];
		$data['name'] = $this->post('name');
		$data['price'] = $this->post('price');
		$data['status'] = $this->post('status');
		$result = $this->Admin_model->create_record('packages', $data);

		if ($result)
			{
			$this->response(['status' => True, 'message' => 'Please try again'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function editPackage_post()
		{

		$id = $this->post('id');
		$data['name'] = $this->post('name');
		$data['price'] = $this->post('price');
		$data['status'] = $this->post('status');
		$result = $this->Admin_model->update_record('packages', array('status' => $data['status'], 'name' => $data['name'], 'price' => $data['price']), $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function deletePackage_post()
		{

		$id = $this->post('id');
		$result = $this->Admin_model->delete_record('packages', $id);
		$multiple = $this->Admin_model->delete_multiple('package_to_features', 'pid', $id);
		$multiple = $this->Admin_model->delete_multiple('package_to_user', 'pid', $id);
		$multiple = $this->Admin_model->delete_multiple('package_feature_user_limit', 'pid', $id);

		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function getPackageFeatures_GET()
		{
		$active = $this->Admin_model->getPackageFeatures($this->get('pid'));
		$all_features = $this->Admin_model->getFeatures();
		$have_this = [];
		foreach ($all_features as $key => $data)
			{
			$have_this = search($active, 'fid', $data['id']);
			if ($have_this)
				{
				$all_features[$key]['status'] = "active";
				$all_features[$key]['limit'] = $have_this[0]['feature_limit'];
				}
			else
				{
				$all_features[$key]['status'] = "inactive";
				$all_features[$key]['limit'] = 0;

				}
			}
		$results = $all_features;
		$this->response(['data' => $results, ], REST_Controller::HTTP_OK);
		}

	public function updatePackageFeatures_POST()
		{
		$value = $this->post('value');
		$action = $this->post('action');
		$pid = $this->post('pid');
		$fid = $this->post('fid');
		$where[0]['key'] = 'pid';
		$where[0]['value'] = $pid;
		$where[1]['key'] = 'fid';
		$where[1]['value'] = $fid;

		if ($action == "feature_limit")
			{

			//update limit
			$data['feature_limit'] = $value;
			$this
				->Admin_model
				->update_record_mc('package_to_features', $data, $where);

			}
		else if ($action == "status")
			{
			$exists = $this
				->Admin_model
				->list_records('package_to_features', 0, 1, $where);
			if ($value == "active")
				{
				if (!$exists)
					{
					//Create record.
					$data['feature_limit'] = 0;
					$data['pid'] = $pid;
					$data['fid'] = $fid;
					$result = $this
						->Admin_model
						->create_record('package_to_features', $data);
					}
				}
			else
				{
				//delete record
				if ($exists)
					{
					$this
						->Admin_model
						->delete_record('package_to_features', $exists[0]->id);
					}
				}
			}
		else
			{
			//do nothing
			
			}
		$this->response(['status' => True, 'message' => 'updated'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		
		}
	//Packaged end
	//Features Start
	public function addFeature_post()
		{

		$data = [];
		$data['name'] = $this->post('name');
		$data['status'] = $this->post('status');
		$result = $this->Admin_model->create_record('package_features', $data);

		if ($result)
			{
			$this->response(['status' => True, 'message' => 'Added'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function editFeature_post()
		{

		$id = $this->post('id');
		$data['name'] = $this->post('name');
		$data['status'] = $this->post('status');
		$result = $this->Admin_model->update_record('package_features', array('status' => $data['status'], 'name' => $data['name']), $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function deleteFeature_post()
		{

		$id = $this->post('id');
		$result = $this->Admin_model->delete_record('package_features', $id);
		$multiple = $this->Admin_model->delete_multiple('package_to_features', 'fid', $id);
		$multiple = $this->Admin_model->delete_multiple('package_feature_user_limit', 'fid', $id);

		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	//Features End
	public function redirectLinksettings_post()
		{

		$data['direct_link'] = $this->post('direct_link');
		$result = $this->Admin_model->update_record('system_settings', array('direct_link' => $data['direct_link']));
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function systemDomain_post()
		{

		$id = $this->post('id');
		$data['domain_id'] = $this->post('domain_id');
		$result = $this->Admin_model->update_record('system_domain', array('domain_id' => $data['domain_id']), $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function userActiveDomain_post()
		{

		$id = trim($this->post('id'));
		$domain = trim($this->post('domain'));

		$result = $this->Admin_model->update_record('user', array('domain' => $domain), $id);

		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function userDefaultDomain_post()
		{

		$id = trim($this->post('id'));
		$domain_default = trim($this->post('domain_default'));

		$result = $this->Admin_model->update_record('user', array('domain_default' => $domain_default), $id);

		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function getAdvDomains_get()
		{

		$id = $this->input->get('res_id');

		$table = "user_cdomains";
		$exists = $this->Admin_model->list_records($table, 0, 1000, array('key' => 'user_id', 'value' => $id), 'id', 'DESC');
		if ($exists)
			{

			$sql = "SELECT a.id, a.domain, u.status  FROM `articledomains` as a LEFT JOIN $table as u  on a.id = u.domain_id WHERE u.user_id = " . $id;
			$query = $this
				->db
				->query($sql);
			$newone = $query->result_array();

			}
		else
			{

			$newone = $this
				->Admin_model
				->list_records('articledomains', 0, 10000);
			foreach ($newone as $key => $value)
				{

				$newone[$key]->status = "inactive";

				}

			}
		$this->response(['status' => TRUE, 'data' => $newone], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		

		
		}

	public function setUpdateAdvDomains_post()
		{
		$id = trim($this->post('res_id'));
		$table = "user_cdomains";
		$rates = $this->post('domains');
		$rates = json_decode($rates);
		$exists = $this->Admin_model->list_records($table, 0, 1000, array('key' => 'user_id', 'value' => $id), 'id', 'DESC');
		if ($exists)
			{

			foreach ($rates as $key => $val)
				{

				$where_user_rate[0]['key'] = "user_id";
				$where_user_rate[0]['value'] = $id;
				$where_user_rate[1]['key'] = "domain_id";
				$where_user_rate[1]['value'] = $val->id;
				$update = $this
					->Admin_model
					->update_record_mc($table, array('status' => $val->value), $where_user_rate);

				}

			}
		else
			{
			foreach ($rates as $key => $val)
				{

				$data_user_rate['user_id'] = $id;
				$data_user_rate['domain_id'] = $val->id;
				$data_user_rate['status'] = $val->value;
				$created_result = $this
					->Admin_model
					->create_record($table, $data_user_rate);

				}

			}

		$this->response(['status' => TRUE, 'data' => "Success"], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		
		}

	public function getGenrates_get()
		{

		$id = $this->input->get('res_id');
		$table = $this->input->get('identifier') . "_rates";

		$exists = $this->Admin_model->list_records($table, 0, 1000, array('key' => 'f_id', 'value' => $id), 'id', 'DESC');
		if ($exists)
			{

			$sql = "SELECT c.id, c.code, c.name,u.rate  FROM `country` as c LEFT JOIN $table as u  on c.id = u.c_id WHERE u.f_id = " . $id;
			$query = $this
				->db
				->query($sql);
			$newone = $query->result_array();
			}
		else
			{
			$newone = $this
				->Admin_model
				->list_records('country', 0, 1000);
			}
		$this->response(['status' => TRUE, 'data' => $newone], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		
		}

	public function setUpdateGenrates_post()
		{
		$id = trim($this->post('res_id'));
		$table = $this->input->post('identifier') . "_rates";
		$rates = $this->post('rates');
		$rates = json_decode($rates);
		$exists = $this->Admin_model->list_records($table, 0, 1000, array('key' => 'f_id', 'value' => $id), 'id', 'DESC');
		if ($exists)
			{

			foreach ($rates as $key => $val)
				{

				$where_user_rate[0]['key'] = "f_id";
				$where_user_rate[0]['value'] = $id;
				$where_user_rate[1]['key'] = "c_id";
				$where_user_rate[1]['value'] = $val->id;
				$update = $this
					->Admin_model
					->update_record_mc($table, array('rate' => $val->value), $where_user_rate);

				}
			}
		else
			{
			foreach ($rates as $key => $val)
				{

				$data_user_rate['f_id'] = $id;
				$data_user_rate['c_id'] = $val->id;
				$data_user_rate['rate'] = $val->value;
				$created_result = $this
					->Admin_model
					->create_record($table, $data_user_rate);
				}

			}

		$this->response(['status' => TRUE, 'data' => "Success"], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		
		}
	public function updateGenrates_post()
		{

		$id = trim($this->post('res_id'));
		$value = trim($this->post('value'));

		$table = $this->input->post('identifier');

		$result = $this->Admin_model->update_record($table, array('rates_priority' => $value), $id);
		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}

	public function updateGenassignAdv_post()
		{

		$id = trim($this->post('res_id'));
		$value = trim($this->post('value'));
		$table = $this->input->post('identifier');

		$result = $this->Admin_model->update_record($table, array('adv_priority' => $value), $id);
		if ($result)
			{

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}

	public function editPublisher_post()
		{

		$id = trim($this->post('id'));
		$email_to = $this->post('email');
		$message = $this->post('message');

		$datauser['status'] = trim($this->post('status'));

		$result = $this->Admin_model->update_record('user', array('status' => $datauser['status']), $id);
		$data_acm['acm_id'] = trim($this->post('acm_id'));
		$data_acm['user_id'] = $id;
		$exists = $this->Admin_model->list_records('acm_users', 0, 1000, array('key' => 'user_id', 'value' => $id), 'id', 'DESC');
		if ($exists)
			{

			$result2 = $this
				->Admin_model
				->update_multiple('acm_users', array('acm_id' => $data_acm['acm_id']), 'user_id', $id);

			}
		else
			{

			$result2 = $this
				->Admin_model
				->create_record('acm_users', $data_acm);
			}

		if ($result || $result2)
			{

			if ($message != "")
				{

				$this
					->email
					->from('support@adublisher.com', 'Adublisher');
				$this
					->email
					->to($email_to);
				// $this->email->cc('another@another-example.com');
				// $this->email->bcc('them@their-example.com');
				$this
					->email
					->subject('Account Status Update');
				$this
					->email
					->message($message);
				$this
					->email
					->send();

				}

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function deletePublisher_post()
		{

		$id = $this->post('id');
		$user = $this->Publisher_model->retrieve_record('user', $id);
		$result = $this->Admin_model->delete_record('user', $id);

		if ($result)
			{
			$multiple = $this
				->Admin_model
				->delete_multiple('user_domains', 'user_id', $id);
			$multiple = $this
				->Admin_model
				->delete_multiple('acm_users', 'user_id', $id);
			$multiple = $this
				->Admin_model
				->delete_multiple('facebook_pages', 'user_id', $id);
			$multiple = $this
				->Admin_model
				->delete_multiple('sceduler', 'user_id', $id);
			$multiple = $this
				->Admin_model
				->delete_multiple('tempclick', 'user', $user->username);
			$multiple = $this
				->Admin_model
				->delete_multiple('click', 'user', $user->username);
			$multiple = $this
				->Admin_model
				->delete_multiple('fake', 'user', $user->username);
			$multiple = $this
				->Admin_model
				->delete_multiple('recomendation', 'userid', $id);
			$multiple = $this
				->Admin_model
				->delete_multiple('menu_assign', 'user', $id);

			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	public function payPublisher_post()
		{

		$id = $this->post('id');
		$amount = $this->post('amount');
		$paid_amu = $this->db->query("Select paid_amu from user where id=" . $id)->row()->paid_amu;
		$total_paid = $amount;
		if ($paid_amu > 0)
			{
			$total_paid = round($amount + $paid_amu, 2);
			}
		$result = $this->Admin_model->update_record('user', array('paid_amu' => $total_paid), $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}

	public function editCountry_post()
		{
		$id = $this->post('id');
		$amount = $this->post('amount');
		$result = $this->Admin_model->update_record('country', array('rate' => $amount), $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}

	public function addAdmin_post()
		{

		$data = [];
		$data['name'] = $this->post('name');
		$data['username'] = $this->post('username');
		$data['email'] = $this->post('email');
		$data['password'] = MD5($this->post('password'));
		$result = $this->Admin_model->create_record('admin', $data);
		if ($result)
			{
			$this->response(['status' => True, 'message' => 'Admin Added successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}

	//update_user_domains_rest
	public function updateUserDomains_post()
		{
		$id = $this->post('id');
		$domains = $this->post('domains');
		$multiple = $this->Admin_model->delete_multiple('user_domains', 'user_id', $id);

		if ($multiple >= 0)
			{
			if ($domains)
				{
				$allDomains = explode("_", $domains);
				$data_user_domain = [];
				foreach ($allDomains as $key => $value)
					{
					$data_user_domain['user_id'] = $id;
					$data_user_domain['domain_id'] = $value;
					$data_user_domain['status'] = "active";

					$created_result = $this
						->Admin_model
						->create_record('user_domains', $data_user_domain);

					}

				}
			$this->response(['status' => True, 'message' => 'domains updated successfully'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}

	public function publisherReport_GET()
		{
		$result = $this->Admin_model->publiserAnalytics();
		if ($result)
			{
			$response['status'] = true;
			$response['message'] = "data found successfully";
			$response['data'] = $result;
			}
		else
			{
			$response['status'] = false;
			$response['message'] = "No data found, Please provide Valid Date Range";
			}
		$this->response($response, REST_Controller::HTTP_OK);

		}
	public function countryReport_GET()
		{
		$result = $this->Admin_model->countryAnalytics();
		if ($result)
			{
			$response['status'] = true;
			$response['message'] = "data found successfully";
			$response['data'] = $result;
			}
		else
			{
			$response['status'] = false;
			$response['message'] = "No data found, Please provide Valid Date Range";
			}
		$this->response($response, REST_Controller::HTTP_OK);

		}
	public function campaignReport_GET()
		{
		$result = $this->Admin_model->campaignAnalytics();
		if ($result)
			{
			$response['status'] = true;
			$response['message'] = "data found successfully";
			$response['data'] = $result;
			}
		else
			{
			$response['status'] = false;
			$response['message'] = "No data found, Please provide Valid Date Range";
			}
		$this->response($response, REST_Controller::HTTP_OK);

		}

	public function getcountrywise_GET()
		{

		$rangedata = [];
		$rangedata['start'] = $this->get('start');
		$rangedata['end'] = $this->get('end');
		$rangedata['username'] = $this->get('username');

		$response = [];
		$response_table = "";
		if ($rangedata['start'] != "" || $rangedata['end'] != "")
			{
			$response = [];
			$total_clicks = 0;
			$total_earn = 0;
			$result = $this
				->Admin_model
				->getcountrywise($rangedata);

			if ($result)
				{

				foreach ($result as $row)
					{
					$response_table .= "<tr>
                <td><img src='assets/general/flags/" . $row['code'] . ".png'></td>
                <td>" . $row['country'] . "</td>
                <td>" . $row['click'] . "</td>
                <td>$" . $row['earn'] . "</td>
            </tr>";
					$total_clicks += $row['click'];
					$total_earn += $row['earn'];
					}
				$data['summary'] = '<table class="table">
                <tbody>
                   <tr>
                    <td style="padding-left: 0px;">EARNING: $ ' . round($total_earn, 2) . '</td>
                    <td>CLICKS: ' . $total_clicks . '</td>
                    </tr>
                </tbody>
            </table>';
				}

			$data['table'] = $response_table;
			$response['status'] = true;
			$response['message'] = "data found successfully";
			$response['data'] = $data;

			}
		else
			{

			$response['status'] = false;
			$response['message'] = "No data found, Please provide Valid Date Range";

			}

		$this->response($response, REST_Controller::HTTP_OK);
		}

	public function metaOfUrl_post()
		{

		$request_url = @$this->post('url');
		$amazon = preg_match("/(^(https?:\/\/(?:www\.)?|(?:www\.))?|\s(https?:\/\/(?:www\.)?|(?:www\.))?)amazon\.com/", $request_url);
		if ($amazon)
			{
			$this
				->load
				->library('amazon');
			$info = $this
				->amazon
				->get_info($request_url);
			$response['title'] = $info['title'];
			$response['image'] = $info['image'];
			$response['status'] = true;
			echo json_encode($response);
			exit;
			}
		if ($request_url != '')
			{
			$this
				->load
				->library('getMetaInfo');
			$info = $this
				->getmetainfo
				->get_info($request_url);
			$response['title'] = $info['title'];
			$response['image'] = $info['image'];
			$response['status'] = true;

			}
		else
			{
			$response['title'] = '';
			$response['image'] = '';
			$response['status'] = false;
			}
		echo json_encode($response);
		}
	public function get_site_meta_tags($url)
		{

		require_once 'amazon/vendor/autoload.php';

		$data = array();
		$curl = curl_init();

		curl_setopt_array($curl, array(CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_POSTFIELDS => "", CURLOPT_HTTPHEADER => array("cache-control: no-cache"),));

		$response = curl_exec($curl);
		//print_r($response );die;
		$err = curl_error($curl);
		curl_close($curl);

		if ($err)
			{
			echo "cURL Error #:" . $err;
			}
		else
			{
			$html = HtmlDomParser::str_get_html($response);
			print_r($html);
			die;
			/*foreach($html->find('#productTitle') as $element) {
				$data['title'] = $element->plaintext;
			}
			foreach($html->find('div#imgTagWrapperId img') as $element) {
				$data['image'] = $element->src;
			}*/
			return $data;
			}

		}
	public function addCampaign_post()
		{
		$data = [];
		$data['text'] = addslashes($this->post('cpname'));
		$data['caption'] = $this->post('cpname');
		$data['description'] = $this->post('cpname');
		$data['img'] = $this->post('cpimg');
		$data['site_us_pc'] = $this->post('cpuspc');
		$data['status'] = $this->post('cpstatus');
		$data['categury'] = $this->post('cpcat');
		$data['star'] = $this->post('star');
		$link = $this->Admin_model->create_record('link', $data);
		if ($link)
			{
			$this->response($link, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}
		}
	public function updateCampaign_post()
		{
		$id = $this->post('id');
		$data['text'] = addslashes($this->post('cpname'));
		$data['caption'] = $this->post('cpname');
		$data['description'] = $this->post('cpname');
		$data['img'] = $this->post('cpimg');
		$data['site_us_pc'] = $this->post('cpuspc');
		$data['status'] = $this->post('cpstatus');
		$data['categury'] = $this->post('cpcat');
		$data['star'] = $this->post('star');
		$result = $this->Admin_model->update_record('link', $data, $id);
		if ($result)
			{
			$this->response(['status' => TRUE, 'data' => $result], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			
			}
		else
			{
			//Set the response and exit
			$this->response(['status' => FALSE, 'message' => 'Please try again'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			
			}

		}

	public function get_campaigns_post()
		{

		//$request=NULL,$cat=NULL,$popularity=NULL,$keyword=NULL
		$userID = App::Session()->get('linked_publisher');
		$user = $this->Publisher_model->retrieve_record('user', $userID);
		$username = $user->username;
		$page = @$this->post('page');
		$request = @$this->post('request');
		$cat = @$this->post('cat');
		$domain = @$this->post('domain');
		$popularity = @$this->post('popularity');
		$keyword = @$this->post('keyword');
		//$user_domain = $this->Publisher_model->get_userdomainAdmin($userID);

		$campaign_results = $this->Publisher_model->get_campaigns($request, $cat, $popularity, $keyword, $page, $domain);

		$campaigns = [];
		$data = [];
		$i = 0;
		foreach ($campaign_results['campaigns'] as $row)
			{

			$campaigns[$i]['campaign_link'] = $row->site_us_pc;
			$cplink = get_cp_link($row->id, $user,  $row->site_us_pc);
			$campaigns[$i]['cplink'] = $cplink;
			$campaign_link = $row->site_us_pc;
			$text_of_campaign = $this->clean(ucwords(strtolower(stripslashes($row->text))));
			$caption = $this->clean(ucwords(strtolower(stripslashes($row->caption))));
			$withcaption = $text_of_campaign . " " . $cplink;
			if (strlen($caption) > 0)
				{

				$withcaption = $caption . " " . $cplink;
				}

			if (strlen($text_of_campaign) > 120)
				{
				$text_of_campaign = substr($text_of_campaign, 0, 120) . " ...";
				}

			$campaigns[$i]['withcaption'] = $withcaption;
			$campaigns[$i]['withoutcaption'] = $cplink;
			$total_clicks = $this
				->Publisher_model
				->get_clicks($popularity, $row->id);
			$campaigns[$i]['total_clicks'] = cnf($total_clicks, 1);
			$campaigns[$i]['img'] = $row->img;
			$campaigns[$i]['campaign_heading'] = $text_of_campaign;

			$i++;
			}

		if ($request == "filter")
			{
			//usort($campaigns, $this->make_comparer(['total_clicks', SORT_DESC]));
			
			}
		$data['campaigns'] = $campaigns;
		$data['count'] = $campaign_results['count'];
		$data['pagesize'] = $campaign_results['pagesize'];
		$this->response(['status' => TRUE, 'data' => $data, 'message' => 'campaigns request fullfilled'], REST_Controller::HTTP_OK);

		}

	public function notify_articles($user_id, $article_id, $status, $message = "")
		{

		$title = "";
		$type = "";
		$notification = "";
		if ($status == 'locked')
			{
			$title = "Your Article has been Approved";
			$type = "info";
			$notification = "We have reviewed your article and its approved. soon it will be published and you will be notified.";

			}
		else if ($status == 'rework')
			{

			$title = "Your Article Needs improvements";
			$type = "warning";
			$notification = $message; //"After reviewing your article we found, its not upto the mark. Please update and make sure it's your original content. Also make sure it do not have any grammar and punctuation mistakes.";
			
			}
		else if ($status == 'published')
			{

			$title = "Your Article has been published";
			$type = "success";
			$notification = "Your Article is published. soon you will be getting earning from it.";

			}

		$data = [];
		$data['title'] = $title;
		$data['text'] = $notification;
		$data['user_id'] = $user_id;
		$data['seen'] = 0;
		$data['type'] = $type;
		$data['subject_id'] = $article_id;
		$data['link'] = SITEURL . 'preview/' . $article_id;

		$result = $this->Admin_model->create_record('notifications', $data);

		if ($result)
			{
			$user = $this
				->Publisher_model
				->retrieve_record('user', $user_id);
			$this
				->email
				->set_mailtype('html');
			$this
				->email
				->from('support@adublisher.com', 'Adublisher.com');
			$this
				->email
				->to($user->email);
			// $this->email->cc('another@another-example.com');
			// $this->email->bcc('them@their-example.com');
			$this
				->email
				->subject($title);
			$notification = $this->prepare_email($title, $user->fname, $notification, $data['link']);

			//$notification . "<br><br><a href='".$data['link']."'> Click here to preview Article </a>";
			$this
				->email
				->message($notification);
			$this
				->email
				->send();
			return true;
			}
		else
			{
			return false;
			}
		}

	function clean($string)
		{

		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return $string = str_replace('-', ' ', preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
		
		}

	public function make_comparer()
		{

		$criteria = func_get_args();
		foreach ($criteria as $index => $criterion)
			{
			$criteria[$index] = is_array($criterion) ? array_pad($criterion, 3, null) : array($criterion, SORT_ASC, null);
			}

		return function ($first, $second) use ($criteria)
			{
			foreach ($criteria as $criterion)
				{
				// How will we compare this round?
				list($column, $sortOrder, $projection) = $criterion;
				$sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

				// If a projection was defined project the values now
				if ($projection)
					{
					$lhs = call_user_func($projection, $first[$column]);
					$rhs = call_user_func($projection, $second[$column]);
					}
				else
					{
					$lhs = $first[$column];
					$rhs = $second[$column];
					}

				// Do the actual comparison; do not return if equal
				if ($lhs < $rhs)
					{
					return -1 * $sortOrder;
					}
				else if ($lhs > $rhs)
					{
					return 1 * $sortOrder;
					}
				}

			return 0; // tiebreakers exhausted, so $first == $second
			
			};
		}

	public function users_roles_GET()
		{
		$datas = $this->Publisher_model->get_roles($this->get('user_id'));
		$menus = '<div class="row demo-checkbox">';
		$count = 0;
		foreach ($datas as $data)
			{
			if ($data['status'] == 'Active')
				{
				$menus .= '<div  class="form-group m-t-0  m-b-0 col-md-6" >
                        <input type="checkbox" name="' . $data['menu_id'] . '" id="md_checkbox' . $count . '"class="check_status filled-in chk-col-deep-purple all_checkboxes" checked>
                        <label for="md_checkbox' . $count . '">' . $data['menu_name'] . '</label>
                        </div>';
				}
			else
				{
				$menus .= '<div  class="form-group m-t-0  m-b-0 col-md-6" >
                        <input type="checkbox" id="md_checkbox' . $count . '" name="' . $data['menu_id'] . '"class="check_status filled-in chk-col-deep-purple all_checkboxes" >
                        <label for="md_checkbox' . $count . '">' . $data['menu_name'] . '</label>
                        </div>';
				}
			$count++;
			}

		$menus .= '</div>';
		$this->response(['menu' => $menus, 'data' => $datas, 'count' => $count, ], REST_Controller::HTTP_OK);
		}

	public function update_roles_GET()
		{

		$result = $this->Publisher_model->update_roles($this->get('user_id'), $this->get('roles'));
		$this->response($result, REST_Controller::HTTP_OK);
		}

	public function edit_announcement_GET()
		{

		$announce_id = $this->get('announce_id');
		$status = $this->get('status');
		$text = $this->get('text');

		if (strlen(trim($announce_id)) == 0 || strlen(trim($status)) == 0 || strlen(trim($text)) == 0)
			{
			$this->response(array('status' => FALSE, 'Message' => 'Something went wrong',), REST_Controller::HTTP_NOT_FOUND);
			}

		if ($this->Publisher_model->edit_announcement($announce_id, $status, $text))
			{
			$this->response(array('status' => TRUE, 'Message' => 'Announcement Status Is Changed',), REST_Controller::HTTP_OK);
			}
		else
			{
			$this->response(array('status' => FALSE, 'Message' => 'Something went wrong',), REST_Controller::HTTP_NOT_FOUND);
			}
		}

	public function delete_announcement_GET()
		{
		$announce_id = $this->get('announce_id');

		if ($this->Publisher_model->delete_announcement($announce_id))
			{
			$this->response(array('status' => TRUE, 'Message' => 'Announcement is deleted',), REST_Controller::HTTP_OK);
			}
		else
			{
			$this->response(array('status' => TRUE, 'Message' => 'Something Went Wrong',), REST_Controller::HTTP_NOT_FOUND);
			}
		}

	public function create_announcement_GET()
		{
		$text = $this->get('text');
		if (strlen(trim($text)) == 0)
			{
			$this->response(array('status' => TRUE, 'Message' => 'Something Went Wrong',), REST_Controller::HTTP_NOT_FOUND);
			}
		else
			{
			if ($this
				->Publisher_model
				->create_announcement($text))
				{
				$this->response(array('status' => TRUE, 'Message' => 'Announcement Is Created',), REST_Controller::HTTP_OK);
				}
			$this->response(array('status' => FALSE, 'Message' => 'Announcement Is Created',), REST_Controller::HTTP_NOT_FOUND);

			}
		}

	public function top_users_GET()
		{

		$top_users_data = $this->Publisher_model->top_users($this->get('start'), $this->get('end'));
		if ($top_users_data !== false)
			{
			if (count($top_users_data) > 0)
				{

				$this->response(array('status' => TRUE, 'data' => $top_users_data,), REST_Controller::HTTP_OK);
				}
			else
				{
				$this->response(array('status' => TRUE, 'data' => '',), REST_Controller::HTTP_OK);
				}
			}
		else
			{
			$this->response(array('status' => FALSE, 'data' => 'No Data Found',), REST_Controller::HTTP_OK);
			}
		}

	public function prepare_email($title, $user_name, $notification, $link)
		{

		return '<!doctype html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title><?=$title?>
        </title>
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
                                                    <p>Hi ' . $user_name . ',</p>
                                                    <p>' . $title . '</p>
                                                    <p>' . $notification . '</p>
                                                    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left">
                                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td> <a href="' . $link . '" target="_blank">Click to Open Article</a> </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <p>Good luck!</p>
                                                    <br>
                                                    <p>Your Sincere,</p>
                                                    <p>Team Adublisher</p>
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

                                            <br> Need Help ? <a href="https://www.adublisher.com/#contact">Get In Touch</a>.
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

		}

	}