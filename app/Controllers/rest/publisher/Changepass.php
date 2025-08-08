<?php

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
class Changepass extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Publisher_model');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['pass_post']['limit'] = 500; // 500 requests per hour per user/key
      
    }


 

  
    public function pass_post()
    {
        // $this->some_model->update_user( ... );
      $currentpass=$this->post('currentpass');
      $newpass=$this->post('newpass'); 
	  $username=$this->post('username'); 
      $users = $this->Publisher_model->change_password(array($currentpass,$newpass,$username));
          
		 
			if ($users)
            {
                // Set the response and exit
               // $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				
				  $this->response(array(
                    'status' => True,
                    'message' => 'Password Updated Successfully'
                ), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				
            }
            else
            {
                // Set the response and exit
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'Current Password is incorrect',
					
                ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
	
        
   
}
