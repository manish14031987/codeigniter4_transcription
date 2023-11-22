<?php

namespace App\Controllers;

class Home extends BaseController
{
	
    public function index(): string
    {
		$session = \Config\Services::session();
		$data = [];
		
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'home';	// page name
		return view('includes/template', $data);
        //return view('home');
    }
}
