<?php

namespace App\Controllers;

class Welcome extends BaseController
{
	public function index():string
	{
        helper('general');

        //$this->load->view('layouts/publisher/client_side/landing-new');
        return view('layouts/publisher/client_side/landing-new');
	}
}
