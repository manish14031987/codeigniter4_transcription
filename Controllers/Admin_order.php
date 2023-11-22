<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use App\Models\Admin_order_model;

class Admin_order extends BaseController
{
	
	 public function order_index()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Admin Orders'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/order';	// page name
		return view('admin/includes/template', $data);
		return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
        //return view('home');
    }
	
	public function order_rpt()
	{
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$userModel = new Admin_order_model();
        $output = $userModel->order_rpt();
		echo json_encode($output);
		}
        else
		{
			return redirect()->to(base_url());
		}
	}
	
	public function order_detail($id)
	{
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$id = decryptMyData($id);
		$data = [];
		
		$data['order_info'] = $this->order_info($id);
		$data['order_item'] = $this->order_item($id);
		
		$data['session'] = $session;
		$data['title'] 		= 'Admin Orders Detail #'.$id.''.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/order_detail';	// page name
		return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
	}
	
	public function order_info($id)
	{
		$userModel = new Admin_order_model();
        return $userModel->order_info($id);
	}
	public function order_item($id)
	{
		$userModel = new Admin_order_model();
        return $userModel->order_item($id);
	}
	
	public function downloadFile($filename) {
	
        $filepath = WRITEPATH . 'uploads/' . $filename;
		//prd($filepath);
        if (file_exists($filepath)) {
            //header('Content-Type: application/octet-stream');
           // header('Content-Disposition: attachment; filename="' . $filename . '"');
            //readfile($filepath);
			
			
			$this->response->setHeader('Content-Type', mime_content_type($filepath));
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . basename($filepath) . '"');
            readfile($filepath);
			
			
        } else {
            // Handle file not found error
            echo 'File not found';
        }
    }
}