<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataMining extends CI_Controller {


function __construct()
{
    parent::__construct();
	$this->load->model('DataMining_model');	
	

}
function index()
	{
       
		$data = $this->DataMining_model->data_indexing();
		
    
	}
}
?>