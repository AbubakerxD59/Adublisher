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
class Recommended extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
     
    $this->load->model('Publisher_model');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
     
    }

        
public function webfeed_get()
  {

 
    $username = $this->get('user');
    $userID = $this->get('response');
    $width = $this->get('width');

    $post_height = "200px";
    $image_height = "150px";
  if($width <= 500){

        $post_height = "150px";
        $image_height = "100px";

    }
   else if($width >= 500 && $width <= 768){

        $post_height = "250px";
        $image_height = "200px";

    }else if($width >= 769 && $width <=1024 ){
        $post_height = "300px";
        $image_height = "250px";

    }else if($width >= 1223 && $width <=1823 ){

      $post_height = "400px";
      $image_height = "330px";

    }else if($width >= 1824 ){
      $post_height = "570px";
      $image_height = "500px";
    }
    $user_domain =$this->Publisher_model->get_userdomain($username);
    $request = "";
    $cat = "";
    $popularity = "";
    $keyword= "";

    $page =  rand (1 ,19);
    $campaign_results=$this->Publisher_model->get_campaigns($request,$cat,$popularity,$keyword,$page);
    $campaigns = [];
    $data = [];
    $i = 0;
    $counter = $page =  rand (0 ,5);
    $end_counter = $counter + 1;
    $campaign_results['campaigns'] = array_slice($campaign_results['campaigns'],$counter,$end_counter,true);
    foreach($campaign_results['campaigns'] as $row){
      
        $cplink ='';  
        if($user_domain){

          $cplink = $user_domain . '/ref/' . $row->id . '/' . $userID;
        }
        $campaigns[$i]['cplink'] = $cplink;
        $campaigns[$i]['campaign_link'] = $row->site_us_pc;
        $campaign_link = $row->site_us_pc;
        $text_of_campaign = $this->clean(ucwords(strtolower(stripslashes($row->text))));
        $caption = $this->clean(ucwords(strtolower(stripslashes($row->caption))));
        $withcaption = $text_of_campaign . " " .$user_domain . '/ref/' .  $row->id . '/' . $userID;
        if(strlen($caption) >  0){
            $withcaption = $caption . " " .$user_domain . '/ref/' .  $row->id . '/' . $userID;
        }
        
        $withoutcaption = $user_domain . '/ref/' .  $row->id . '/' . $userID;

        if(strlen($text_of_campaign) > 120){
            $text_of_campaign = substr($text_of_campaign, 0, 120) . " ...";
        }
         $campaigns[$i]['withcaption']  = $withcaption;

         $campaigns[$i]['withoutcaption'] = $withoutcaption;

    $total_clicks=$this->Publisher_model->get_clicks('',$row->id);
    $campaigns[$i]['total_clicks'] = $total_clicks;
    $campaigns[$i]['img'] = $row->img;
    $campaigns[$i]['campaign_heading'] = $text_of_campaign;
          
      $i++;   
      break;
    }


     $html = '

     
    <div class="au-wc au-bp au-g-dl " style="height:380px;width:350px;visibility: visible; overflow: visible;">
   <!-- <div class="au-wc au-bp au-g-dl " style="visibility: visible; overflow: visible;">-->
      <div class="au-text-top au-text-right au-branding au-bl-sponsored-by-revcontent" style="top: 0px;">
         <div class="au-branding-label au-brand-content">Ads by Adublisher</div>
      </div>

      <div class="au-clearfix au-row au-t-10 au-g-dl-1 au-g-d-1">
         <div class="row-item">
            <div class="au-p au-p-pt">
               <div id="au-row-container">
                  <div class="au-row au-t-6  au-g-dl-3  au-g-d-3  au-g-t-3  au-g-p-1  au-photo-top">';

          $internals = "";
          foreach($campaigns as $campaign)
              {
              
              $cp = $campaign['cplink'];
           
              $internals .= '
             <!-- <div class="au-item"  style="height: '.$post_height.';">-->
              <div class="au-item"  style="height:350px;width:350px;">
                  <div class="au-item-wrapper">
                     <a href="'. $cp.'"  target="_blank" class="au-cta" title="'.$campaign['campaign_heading'].'" rel="nofollow">
                        <div class="au-photo-container">
                           <div class="au-photo-scale">
                             <!-- <div class="au-photo" style="background-image: url(' . $campaign['img'] . '); height: '.$image_height.';" >  -->
                             <div class="au-photo" style="height:280px;width:350px;background-image: url(' . $campaign['img'] . ');" >
                              </div>
                           </div>
                        </div>
                        <div class="au-content">
                           <div class="au-headline" > ' . $campaign['campaign_heading'] .'</div>
                        </div>
                     </a>
                  </div>
              </div>';

              }

          $html .= $internals. '
                 </div> 
               </div>
            </div>
         </div>
      </div>
   </div>';



    $data['html'] = $html;
    $this->response([
                    'status' => TRUE,
                    'data' => $data,
                    'message' => 'campaigns request fullfilled'
                ], REST_Controller::HTTP_OK);

  }
     

function clean($string) {
  
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return  $string = str_replace('-', ' ', preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
}

  
     public function make_comparer() {
      // Normalize criteria up front so that the comparer finds everything tidy
      $criteria = func_get_args();
      foreach ($criteria as $index => $criterion) {
          $criteria[$index] = is_array($criterion)
              ? array_pad($criterion, 3, null)
              : array($criterion, SORT_ASC, null);
      }
   
      return function($first, $second) use ($criteria) {
          foreach ($criteria as $criterion) {
              // How will we compare this round?
              list($column, $sortOrder, $projection) = $criterion;
              $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;
   
              // If a projection was defined project the values now
              if ($projection) {
                  $lhs = call_user_func($projection, $first[$column]);
                  $rhs = call_user_func($projection, $second[$column]);
              }
              else {
                  $lhs = $first[$column];
                  $rhs = $second[$column];
              }
   
              // Do the actual comparison; do not return if equal
              if ($lhs < $rhs) {
                  return -1 * $sortOrder;
              }
              else if ($lhs > $rhs) {
                  return 1 * $sortOrder;
              }
          }
   
          return 0; // tiebreakers exhausted, so $first == $second
      };
  }
}
