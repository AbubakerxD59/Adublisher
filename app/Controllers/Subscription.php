<?php
defined('BASEPATH') OR
    exit('No direct script access allowed');
/**
 * Version: 1.0.0
 *
 * Description of Subscriptions Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 **/

// Subscriptions class
class Subscription extends CI_Controller {
	//Load libraries in Constructor.
	public function __construct() {
        parent::__construct();
        $this->load->library('stripe');
    }

	public function index() {
        $data['metaDescription'] = 'Stripe Manage Subscription Payment using Codeigniter';
        $data['metaKeywords'] = 'Stripe Manage Subscription Payment using Codeigniter';
        $data['title'] = "Stripe Manage Subscription Payment using Codeigniter - TechArise";
        $data['breadcrumbs'] = array('Stripe Manage Subscription Payment using Codeigniter' => '#');
        $this->load->view('subscription/index', $data);
    }


    // create subscription
    public function create() {
        $data['metaDescription'] = 'Stripe Manage Subscription Payment using Codeigniter';
        $data['metaKeywords'] = 'Stripe Manage Subscription Payment using Codeigniter';
        $data['title'] = "Stripe Manage Subscription Payment using Codeigniter - TechArise";
        $data['breadcrumbs'] = array('Stripe Manage Subscription Payment using Codeigniter' => '#');
         
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

        $token  = $this->input->post('stripeToken');
        $email  = $this->input->post('stripeEmail');
        $plan  = $this->input->post('plan');
        $interval  = $this->input->post('interval');
        $price  = $this->input->post('price');
        $currency  = $this->input->post('currency');

        $time = time();
        $plan = \Stripe\Plan::create(array( 
            "product" => [
                "name" => $plan,
                "type" => "service"
            ],
            "nickname" => $plan,
            "interval" => $interval,
            "interval_count" => "1",
            "currency" => $currency,
            "amount" => ($price*100) ,
        ));

        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source'  => $token,
        ]);

        $subscription = \Stripe\Subscription::create(array(
            "customer" => $customer->id,
            "items" => array(
                array(
                    "plan" => $plan->id,
                ),
            ),
        ));
        $data['price'] = $price;
        $this->session->set_flashdata('price', $price);  
        redirect('subscription/thankyou');
    }

    // successfully pay
    public function thankyou() {
        $data['metaDescription'] = 'Stripe Manage Subscription Payment using Codeigniter';
        $data['metaKeywords'] = 'Stripe Manage Subscription Payment using Codeigniter';
        $data['title'] = "Stripe Manage Subscription Payment using Codeigniter - TechArise";
        $data['breadcrumbs'] = array('Stripe Manage Subscription Payment using Codeigniter' => '#');
        
        $data['price'] = $this->session->flashdata('price');
        $this->load->view('subscription/thankyou', $data);   
    }
}
