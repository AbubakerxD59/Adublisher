<?php
use voku\helper\HtmlDomParser;
require_once 'amazon/vendor/autoload.php';
class Amazon
{
	function get_info($url){
		
		$data = array();
		$curl = curl_init();
	
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		//print_r($response );die;	
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$html = HtmlDomParser::str_get_html($response);
			foreach($html->find('#productTitle') as $element) {
				$data['title'] = $element->plaintext;
			}
			foreach($html->find('div#imgTagWrapperId img') as $element) {
				$data['image'] = $element->src;
			}
		 return $data;
		}
			
	}
}
