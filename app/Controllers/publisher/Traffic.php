<?php

defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/Mobile_Detect.php');

class Traffic extends CI_Controller
{


	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->model('publisher_model');

	}


	public function index($campaignid, $user)
	{

		$campaign = $this->publisher_model->retrieve_record('link', $campaignid);
		$user_data = $this->publisher_model->retrieve_record('user', $user);
		$url = $campaign->site_us_pc;
		$mysite = $url;
		$referer = @$_SERVER['HTTP_REFERER'];
		if ((empty($country_code) || empty($referer)) || (!empty($_SERVER['HTTP_USER_AGENT']) and preg_match('~(bot|crawl)~i', $_SERVER['HTTP_USER_AGENT']))) {
			redirect($url, 'refresh');
		} else if ($campaign->status != 'enable' && $campaign->deleted == "T" && $user_data->status != 'approve') {
			redirect($url, 'refresh');
		}
	}


	public function ip_info_v2($ip)
	{

		$output = NULL;
		try {
			// $ip = $_SERVER["REMOTE_ADDR"];
			if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_CLIENT_IP'];

			if (filter_var($ip, FILTER_VALIDATE_IP)) {
				//$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

				$ipdat = @json_decode(file_get_contents("http://pro.ip-api.com/json/" . $ip . "?key=0hWywHt9XPgxTPj"));
				if (@strlen(trim($ipdat->countryCode)) == 2) {
					$output = @$ipdat->countryCode;
				}
				/*if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2)
								  {
									  $output = $ipdat->geoplugin_countryCode; 
								  }
								  */


			}
			return $output;
		} catch (Exception $e) {
			return NULL;
		}



	}

	public function detectDevice($referer)
	{

		$detect = new Mobile_Detect;
		if ($detect->isMobile()) {
			$device = "mob";
		} else if ($detect->isTablet()) {
			$device = "tab";
		} else {
			$device = "pc";

		}

		return $device;

	}



}
