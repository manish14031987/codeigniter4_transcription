<?php
namespace App\Controllers;

class Admin_download extends BaseController
{
	
	 public function download_index()
    {
		$session = \Config\Services::session();
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Admin Downloads'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/download';	// page name
		return view('admin/includes/template', $data);
		
        //return view('home');
    }
	
}