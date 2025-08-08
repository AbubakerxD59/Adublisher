<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - dashboard()
* - get_link_settings()
* - publiserAnalytics()
* - countryAnalytics()
* - campaignAnalytics()
* - getcountrywise()
* - getFeatures()
* - getPackageFeatures()
* - updatePackageFeatures()
* - process_login()
* - userwithacms()
* - userwithclicks()
* - userweeklyclicks()
* - userpayamount()
* - check_logged()
* - logged_id()
* - create_record()
* - retrieve_record()
* - update_record()
* - delete_record()
* - update_multiple()
* - delete_multiple()
* - update_record_mc()
* - list_records()
* - count_records()
* - _check_array_keys()
* - show_publishers()
* - show_menus()
* - get_announcements()
* - __get_top_users()
* - __get_top_countries()
* - __get_top_campaigns()
* Classes list:
* - Admin_model extends CI_Model
*/
class Admin_model extends CI_Model
	{

	function __construct()
		{
		parent::__construct();
		}
	function dashboard()
		{

		$result = [];

		//Today data
		$sql = "SELECT ROUND(sum(earn), 2) as today_earning, count(cpid) as today_clicks FROM `click` WHERE DATE(date)= DATE(NOW())";
		$query = $this->db->query($sql);
		$result['today_earning'] = ($query->row()->today_earning) ? $query->row()->today_earning : 0;
		$result['today_clicks'] = ($query->row()->today_clicks) ? $query->row()->today_clicks : 0;

		$sql = "select  a.country , b.code , count(a.earn) as count , ROUND(sum(a.earn), 2) as total_earn from click as a , country as b where DATE(a.date) = DATE(NOW()) AND a.country = b.name group by a.country order by count desc";
		$query = $this->db->query($sql);
		$result['today_summary'] = $query->result_array();
		$sql = "select id,  username  from user where status='approve'";
		$result['all_users_dropdown'] = $this->db->query($sql)->result_array();

		$sql = "select  count(id) as count , status  from user group by status";
		$results = $this->db->query($sql)->result_array();
		$users = [];
		$users['all'] = 0;
		foreach ($results as $key => $user)
			{
			$users[$user['status']] = $user['count'];
			$users['all'] += $user['count'];
			}
		$result['all_users'] = $users;

		//SELECT COUNT(id) FROM `link` WHERE deleted = 'F' group by status	Active Campaings
		//SELECT COUNT(id) FROM `link` WHERE deleted = 'F' group by status	Inactive Campaings
		$sql = "select  count(id) as count , status  from link WHERE deleted = 'F' group by status";
		$results = $this->db->query($sql)->result_array();
		$links = [];
		$links['all'] = 0;
		$links['disable'] = 0;
		foreach ($results as $key => $link)
			{
			$links[$link['status']] = $link['count'];
			$links['all'] += $link['count'];
			}

		$result['all_campaings'] = $links;

		// All time Data
		$sql = "SELECT ROUND(sum(earn), 3) as alltime_earning  , count(cpid) as alltime_clicks FROM `click`";
		$query = $this->db->query($sql);
		$click_query = $query->row_array();

		$sql = "SELECT device, ROUND(sum(earn), 3) as earning  , count(cpid) as clicks FROM `click` group by device";
		$query = $this->db->query($sql);
		//$result['weekly_devices']= $query->result_array();
		foreach ($query->result_array() as $key => $val)
			{
			$result['weekly_devices_label'][$key] = $val['device'] . " " . $val['clicks'] . " / $" . $val['earning'];
			$result['weekly_devices_clicks'][$key] = $val['clicks'];

			}

		$sql = "SELECT country, ROUND(sum(earn), 3) as earning  , count(cpid) as clicks FROM `click` group by country order by earning desc limit 10 ";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val)
			{
			$result['weekly_country_label'][$key] = $val['country'] . " " . $val['clicks'] . " / $" . $val['earning'];
			$result['weekly_country_clicks'][$key] = $val['clicks'];

			}

		$sql = "SELECT ROUND(sum(earning), 3) as alltime_earning  , sum(total_click) as alltime_clicks FROM `revenue`";
		$revenue_query = $this->db->query($sql)->row_array();

		$result['weekly_earning'] = $click_query['alltime_earning'] ? $click_query['alltime_earning'] : 0;
		$result['weekly_clicks'] = $click_query['alltime_clicks'] ? $click_query['alltime_clicks'] : 0;

		$result['alltime_earning'] = $click_query['alltime_earning'] + $revenue_query['alltime_earning'];
		$result['alltime_clicks'] = $click_query['alltime_clicks'] + $revenue_query['alltime_clicks'];
		$sql = "SELECT ROUND(sum(paid_amu) , 3)  as total_paid FROM user";
		$query = $this->db->query($sql);
		$result['total_paid'] = $query->row()->total_paid;
		$result['top_users'] = $this->__get_top_users();
		return $result;
		}
	function get_link_settings($user_id)
		{
			$sql = "SELECT direct_link FROM `user` WHERE id = $user_id";
			$link_query = $this->db->query($sql)->row_array();
			return $link_query['direct_link'];
			
		}

	/*function affiliate_get_link_settings($user_id)
		{

		$sql = "SELECT direct_link FROM `user` WHERE id = $user_id";
		$link_query = $this->db->query($sql)->row_array();
		return $link_query['direct_link'];
		
		}*/
	function publiserAnalytics()
		{

		$sql = "select  user, count(user) c, ROUND( sum(earn) , 3) as e  from click group by user order by c desc limit 10";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val)
			{
			$result['weekly_topuser_label'][$key] = $val['user'] . " " . $val['c'] . " / $" . $val['e'];
			$result['weekly_topuser_clicks'][$key] = $val['c'];
			}
		$result['top_users'] = $this->__get_top_users();
		return $result;

		}
	function countryAnalytics()
		{

		$sql = "select  country, count(user) c, ROUND( sum(earn) , 3) as e  from click group by country order by c desc limit 10";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val)
			{
			$result['weekly_country_label'][$key] = $val['country'] . " " . $val['c'] . " / $" . $val['e'];
			$result['weekly_country_clicks'][$key] = $val['c'];
			}
		$sql = "select  a.country , b.code , count(a.earn) as count , ROUND(sum(a.earn), 3) as total_earn from click as a , country as b where DATE(a.date) = DATE(NOW()) AND a.country = b.name group by a.country order by count desc";
		$query = $this->db->query($sql);
		$result['today_summary'] = $query->result_array();
		$sql = "select id,  username  from user where status='approve'";
		$result['all_users_dropdown'] = $this->db->query($sql)->result_array();
		$sql = "SELECT ROUND(sum(earn), 2) as today_earning, count(cpid) as today_clicks FROM `click` WHERE DATE(date)= DATE(NOW())";
		$query = $this->db->query($sql);
		$result['today_earning'] = ($query->row()->today_earning) ? $query->row()->today_earning : 0;
		$result['today_clicks'] = ($query->row()->today_clicks) ? $query->row()->today_clicks : 0;

		return $result;
		}
	function campaignAnalytics()
		{

		$sql = "select  country, count(user) c, ROUND( sum(earn) , 3) as e  from click group by country order by c desc limit 10";
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $key => $val)
			{
			$result['weekly_campaign_label'][$key] = $val['country'] . " " . $val['c'] . " / $" . $val['e'];
			$result['weekly_campaign_clicks'][$key] = $val['c'];
			}
		$result['top_campaigns'] = $this->__get_top_campaigns();
		return $result;
		}
	function getcountrywise($rangedata)
		{
		$statistics = [];

		if ($rangedata['start'] != "" || $rangedata['end'] != "")
			{

			$myusername = $rangedata['username'];
			$start = $rangedata['start'];
			$end = $rangedata['end'];

			if (trim($myusername) != "")
				{

				$sql = "select  a.country , b.code , count(a.earn) as click , round(sum(a.earn), 3) as earn from click as a , country as b where a.user = '$myusername' AND a.date >= DATE('$start')  AND  a.date <= DATE('$end') AND a.country = b.name group by a.country order by click desc";
				$query = $this->db->query($sql);
				$statistics = $query->result_array();
				if ($start <= "2018-02-06")
					{

					$sql = "select  id  from user where username='" . $myusername . "' LIMIT 1";
					$user = $this->db->query($sql)->result_array();
					$user_id = $user[0]['id'];
					$sql_r = "select c.name as country , c.code, sum(r.total_click) as click,  round(sum(r.earning),4) earn   from revenue as r , country as c where r.country =c.name AND  r.user_id = " . $user_id . " group by country order by click desc";
					$query_r = $this->db->query($sql_r);
					$result_r = $query_r->result_array();
					$sum = array_mesh_country($statistics, $result_r);
					return $sum;
					}

				}
			else
				{

				$sql = "select  a.country , b.code , count(a.earn) as click , round(sum(a.earn), 3) as earn from click as a , country as b where  a.date >= DATE('$start')  AND  a.date <= DATE('$end') AND a.country = b.name group by a.country order by click desc";
				$query = $this->db->query($sql);
				$statistics = $query->result_array();
				if ($start <= "2018-02-06")
					{
					$sql_r = "select c.name as country , c.code, sum(r.total_click) as click,  round(sum(r.earning),4) earn   from revenue as r , country as c where r.country = c.name group by country order by click desc";
					$query_r = $this->db->query($sql_r);
					$result_r = $query_r->result_array();
					$sum = array_mesh_country($statistics, $result_r);
					return $sum;
					}
				}

			return $statistics;
			}
		return false;

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
	public function updatePackageFeatures($user_id, $roles)
		{
		for ($i = 0;$i < count($roles);$i++)
			{
			$this->db->set('status', $roles[$i]['status']);
			$this->db->where('user', $user_id);
			$this->db->where('menu_id', $roles[$i]['menu_id']);
			$this->db->update('menu_assign');

			}
		if ($this->db->affected_rows() >= 0)
			{
			return true;
			}
		else
			{
			return false;
			}

		}
	function process_login($login_array_input = NULL)
		{

		if (!isset($login_array_input) OR count($login_array_input) != 2) return false;
		//set its variable
		$username = $login_array_input[0];
		$password = $login_array_input[1];
		// select data from database to check user exist or not?
		$sql = "SELECT * FROM `admin` WHERE `username`= '" . $login_array_input[0] . "' and status='admin'";
		//echo $sql;die;
		$query = $this->db->query($sql);
		//var_dump($query->num_rows() );die;
		if ($query->num_rows() > 0)
			{
			$row = $query->row();
			if (MD5($password) == $row->password)
				{
				App::Session()->set('admin_user_id', $row->id);
				App::Session()->set('admin_username', $row->username);
				App::Session()->set('admin_name', $row->name);
				App::Session()->set('admin_email', $row->email);
				App::Session()->set('admin_avatar', $row->img);
				App::Session()->set('linked_publisher', $row->linked_publisher);
				return true;
				}
			return false;
			}
		return false;
		}
	function userwithacms()
		{

		$sql = "SELECT `user`.*, acm_users.acm_id FROM `user` left JOIN acm_users ON `user`.id = acm_users.user_id  order by id DESC";
		$query = $this->db->query($sql);
		return $query->result();
		}
	function userwithclicks()
		{

		$users = $this->list_records('user', 0, 1000, null);
		$result = [];
		$i = 0;
		foreach ($users as $user)
			{
			$result[$i]['id'] = $user->id;
			$result[$i]['name'] = $user->fname;
			$result[$i]['username'] = $user->username;
			$result[$i]['img'] = $user->img;
			//array(['key' => 'country' , 'value' => 'United States'],['key' => 'user' , 'value' =>$user->username ])
			$where[1] = array('key' => 'user', 'value' => $user->username);

			$where[0] = array('key' => 'country', 'value' => 'United States');
			$result[$i]['usa'] = $this->count_records('click', $where);

			$where[0] = array('key' => 'country', 'value' => 'United Kingdom');
			$result[$i]['uk'] = $this->count_records('click', $where);

			$where[0] = array('key' => 'country', 'value' => 'Australia');
			$result[$i]['aus'] = $this->count_records('click', $where);

			$where[0] = array('key' => 'country', 'value' => 'India');
			$result[$i]['ind'] = $this->count_records('click', $where);

			$where[0] = array('key' => 'country', 'value' => 'Pakistan');
			$result[$i]['pak'] = $this->count_records('click', $where);

			$result[$i]['total'] = $this->count_records('click', array($where[1]));
			$result[$i]['other'] = $result[$i]['total'] - $result[$i]['pak'] - $result[$i]['ind'] - $result[$i]['aus'] - $result[$i]['uk'] - $result[$i]['usa'];

			$query = $this->db->query("select ROUND(sum(earn) , 2) as earn from click where user = '" . $user->username . "'");
			$result[$i]['earn'] = $query->row()->earn;

			$i++;
			}

		return $result;
		}
	function userweeklyclicks()
		{

		$users = $this->list_records('user', 0, 1000, null);
		$result = [];
		$i = 0;
		foreach ($users as $user)
			{
			$result[$i]['id'] = $user->id;
			$result[$i]['name'] = $user->fname;
			$result[$i]['username'] = $user->username;
			$result[$i]['img'] = $user->img;
			$where[1] = array('key' => 'user', 'value' => $user->username);
			$result[$i]['currentWeek'] = $this->db->query("Select truncate(sum(earn),3) as earning from click where user='" . $user->username . "' && date between DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())-1 DAY) and curdate()")->row()->earning;

			$result[$i]['week2'] = $this->db->query("Select truncate(sum(earn),3) as earning from click where user='" . $user->username . "' && date between DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+6 DAY) and DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+0 DAY)")->row()->earning;

			$result[$i]['week3'] = $this->db->query("Select truncate(sum(earn),3) as earning from click where user='" . $user->username . "' && date between DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+13 DAY) and DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+7 DAY)")->row()->earning;

			$result[$i]['week4'] = $this->db->query("Select truncate(sum(earn),3) as earning from click where user='" . $user->username . "' && date between DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+20 DAY) and DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+14 DAY)")->row()->earning;

			$result[$i]['week5'] = $this->db->query("Select truncate(sum(earn),3) as earning from click where user='" . $user->username . "' && date between DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+27 DAY) and DATE_SUB(DATE(NOW()), INTERVAL DAYOFWEEK(NOW())+21 DAY)")->row()->earning;

			$query = $this->db->query("select ROUND(sum(earn),3) as earn from click where user = '" . $user->username . "'");
			$result[$i]['totalearn'] = $query->row()->earn;

			$i++;
			}

		return $result;
		}
	function userpayamount()
		{

		$users = $this->list_records('user', 0, 1000, null);
		$result = [];
		$i = 0;
		foreach ($users as $user)
			{
			$result[$i]['id'] = $user->id;
			$result[$i]['name'] = $user->fname;
			$result[$i]['username'] = $user->username;
			$result[$i]['img'] = $user->img;
			$query = $this->db->query("select ROUND(sum(earn) , 2) as earn from click where user = '" . $user->username . "'");
			$result[$i]['totalearn'] = $query->row()->earn;
			$query = $this->db->query("select ROUND(sum(earning) , 2) as earn from revenue where user_id = '" . $user->id . "'");
			$result[$i]['totalearn'] += $query->row()->earn;
			$result[$i]['paidamount'] = $user->paid_amu;

			$i++;
			}

		return $result;
		}
	function check_logged()
		{
		return (App::Session()->get('admin_user_id')) ? TRUE : FALSE;
		}
	function logged_id()
		{
		return ($this->check_logged()) ? App::Session()->get('admin_user_id') : '';
		}
	function create_record($table, $params = null)
		{

		//print_r($params);
		//$params = $this->_check_array_keys( $params, $this->field_keys );
		foreach ($params as $key => $value)
			{
			$this->db->set($key, $value);
			}
		//$this->db->set( 'created_datetime', "NOW()", FALSE );
		//$this->db->set( 'modified_datetime', "NOW()", FALSE );
		$this->db->insert($table);
		return $this->db->insert_id();
		}
	function retrieve_record($table, $id = null, $where = null, $orderBy = null, $order = null)
		{
		if (isset($where["key"]))
			{
			$this->db->where($where["key"], $where["value"]);
			}
		elseif ($where)
			{
			foreach ($where as $where_item)
				{
				$this->db->where($where_item["key"], $where_item["value"]);
				}
			}
		if ($orderBy != null)
			{
			$this->db->order_by($orderBy, $order);
			}
		$query = $this->db->get_where($table, array('id' => $id), 1);
		return $query->row();
		}
	function update_record($table, $params = null, $id = null)
		{
		//$params["modified_datetime"] = "NOW()";
		if ($id != null)
			{
			$this->db->where('id', $id);
			}
		$this->db->update($table, $params);
		return $this->db->affected_rows();
		}
	function delete_record($table, $id = null)
		{
		$this->db->delete($table, array('id' => $id));
		return $this->db->affected_rows();
		}
	function update_multiple($table, $params = null, $column = null, $id = null)
		{
		//$params["modified_datetime"] = "NOW()";
		$this->db->where($column, $id);
		$this->db->update($table, $params);
		return $this->db->affected_rows();
		}
	function delete_multiple($table, $column, $id)
		{
		$this->db->delete($table, array($column => $id));
		return $this->db->affected_rows();
		}
	function update_record_mc($table, $params = null, $where = null)
		{

		if (isset($where["key"]))
			{

			$this->db->where($where["key"], $where["value"]);
			}
		elseif ($where)
			{
			foreach ($where as $where_item)
				{
				$this->db->where($where_item["key"], $where_item["value"]);
				}
			}
		$this->db->update($table, $params);
		return $this->db->affected_rows();
		}
	function list_records($table, $offset = 0, $limit = 20, $where = null)
		{

		if (isset($where["key"]))
			{

			$this->db->where($where["key"], $where["value"]);
			}
		elseif ($where)
			{
			foreach ($where as $where_item)
				{
				$this->db->where($where_item["key"], $where_item["value"]);
				}
			}
		$query = $this->db->get($table, $limit, $offset);
		return $query->result();
		}
	function count_records($table, $where)
		{
		foreach ($where as $where_item)
			{

			$this->db->where($where_item["key"], $where_item["value"]);
			}
		$this->db->from($table);
		return $this->db->count_all_results();
		}
	private function _check_array_keys($table, $params, $validator)
		{
		foreach ($params as $key => $val)
			{
			if (!in_array($key, $validator))
				{
				unset($params[$key]);
				}
			}
		return $params;
		}
	public function show_publishers()
		{
		return ($this->db->select('id,name,img,email,username,status')->from('user')->get()->result_array());

		}
	public function show_menus()
		{
		return ($this->db->select('id,menu_name')->from('menus')->get()->result_array());
		}
	public function get_announcements()
		{
		return $this->db->select('*')->from('announce')->get()->result_array();
		}
	private function __get_top_users()
		{
		$this->db->trans_start();
		$this->db->select('user  ,img ,count(earn) as count , SUM(earn) as earning');
		$this->db->from('click')->where('date', date('Y-m-d'));
		$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
		return ($this->db->limit(10)->get()->result_array());

		}
	private function __get_top_countries()
		{
		$this->db->trans_start();
		$this->db->select('user  ,img ,count(earn) as count , SUM(earn) as earning');
		$this->db->from('click')->where('date', date('Y-m-d'));
		$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
		return ($this->db->limit(10)->get()->result_array());

		}
	private function __get_top_campaigns()
		{
		$this->db->trans_start();
		$this->db->select('user  ,img ,count(earn) as count , SUM(earn) as earning');
		$this->db->from('click')->where('date', date('Y-m-d'));
		$this->db->group_by('user')->join('user', 'user.username=click.user')->order_by('earning', 'desc');
		return ($this->db->limit(10)->get()->result_array());

		}
	}

