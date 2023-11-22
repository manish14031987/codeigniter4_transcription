<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use App\Models\Admin_auth_model;
class Admin_auth extends BaseController
{
	function __construct(){
	$this->request = \Config\Services::request();
	date_default_timezone_set('Asia/Kolkata');
	$this->db = \Config\Database::connect();
	$this->session = \Config\Services::session();
	$this->session->start();
	
	
	
	}
	
		
	 public function login_index()
    {
		$session = \Config\Services::session();
		if(empty(session('userdata')))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Admin Login'.' - '.WEB_TITLE;
		
		return view('admin/login', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	
	public function login_ajax()
	{
		$data = [
            'user_email' => $this->request->getPost('email'),
            'user_password' => $this->request->getPost('password'),
        ];
		$userModel = new Admin_auth_model();
        $output = $userModel->login_ajax($data);
		if($output)
		{ 
			$output = $output[0];
	
			
			$sessionData = array( 'userdata' => array(
				'user_id' => $output['user_id'],
                'fullname' => $output['user_fullname'],
				'user_fullname' => $output['user_fullname'],
                'user_email' => $output['user_email'],
				'user_role' => $output['user_role'],
                'logged_in' => true
				)
            );
            $this->session->set($sessionData);
			echo json_encode(array('msg' => 'Login successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Invalid email & password', 'status' => 'error'));
			exit;
		}
		}
	public function logout()
	{
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to('admin/login');
	}
}