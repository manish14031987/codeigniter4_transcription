<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use App\Models\Admin_user_model;
class Admin_user extends BaseController
{
	function __construct(){
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	 public function guest_user_index()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$session = \Config\Services::session();
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Non Corporate Users'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/guest-user';	// page name
		return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
        //return view('home');
    }
	
	 public function corporate_user_index()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Corporate Users'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/corporate-user';	// page name
		return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
        //return view('home');
    }
	
	public function guest_user_rpt()
	{
		$userModel = new Admin_user_model();
        $output = $userModel->guest_user_rpt();
		echo json_encode($output);
	}
	public function corporate_user_rpt()
	{
		$userModel = new Admin_user_model();
        $output = $userModel->corporate_user_rpt();
		echo json_encode($output);
	}
	public function change_status()
	{
		$userModel = new Admin_user_model();
        $output = $userModel->change_status(rq());
		echo json_encode($output);
	}
	
}