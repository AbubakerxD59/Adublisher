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
class Updateprofile extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Publisher_model');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['pass_post']['limit'] = 500; // 500 requests per hour per user/key
      
    }


 

  
    public function profile_post()
    {
        $username=$this->post('username');
        $name = $this->post('name'); 
        $phone = $this->post('phone'); 
      	$userid = $this->post('userid'); 
        $fb_profile = $this->post('fb_profile');
        $fb_page = $this->post('fb_page');
        $image=$this->post('image');
        $gmt=$this->post('gmt');

    if($this->Publisher_model->check_valid($fb_profile,$fb_page,$name,$phone,$gmt)==false)
      {
        $this->response(array(
                     'status' => FALSE,
                  'message' => 'Please Provide Correct Information',
                    
              ), REST_Controller::HTTP_NOT_FOUND); 
      }
      else
      {
        if(empty($image))
        {
          $users = $this->Publisher_model->update_profile(array($name,$phone,$userid,$fb_profile,$fb_page,$gmt));
        }
        else
        {
            if($this->update_in_folder('file'))
            {
                $upload_data = $this->upload->data(); 
                $file_name = $upload_data['file_name'];
                $img_path= 'assets/publisher/useravatars/'.$file_name;
                $users = $this->Publisher_model->update_profile(array($name,$phone,$userid,$fb_profile,$fb_page,$gmt,$img_path));
            }
            else
            {
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'Problem In Image Uploading. Try Again',
                    
                ), REST_Controller::HTTP_NOT_FOUND);
            }
        }
        
          
		  if ($users)
            {
              $this->response(array(
                    'status' => True,
                    'message' => 'Profile Updated Successfully'
                ), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				
			}
            else
            {
                // Set the response and exit
                $this->response(array(
                    'status' => FALSE,
                    'message' => 'Some Problem Occured Try Later',
					
                ), REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    private function update_in_folder($image)
    {
        $directory_path=$_SERVER['DOCUMENT_ROOT']."/assets/publisher/useravatars/";
        $config['upload_path']    = $directory_path;
        $config['allowed_types']  = 'gif|jpg|png';
        $config['overwrite']       = TRUE;
        $this->load->library('upload',$config);
        if(!$this->upload->do_upload($image))
            return false;
        else 
            return true;    
    }

        
   
}
