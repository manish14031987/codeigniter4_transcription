<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
class Admin_dashboard extends BaseController
{
	function __construct(){
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	
	public function dashboard_index()
    {
		
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
	
			$data = [];
			$db = \Config\Database::connect(); // Load the database connection
			
	
			
			$data['noncorporateuserCount'] =  $db->table('ci_tbl_user')->where('user_role', 3)->countAllResults();
			$data['corporateuserCount'] =  $db->table('ci_tbl_user')->where('user_role', 2)->countAllResults();
			$data['ordersCount'] =  $db->table('ci_tbl_orders')->countAllResults();
			$data['languagesCount'] =  $db->table('ci_tbl_language')->countAllResults();
			$data['languageitemsCount'] =  $db->table('ci_tbl_items')->countAllResults();
			$data['qualityCount'] =  $db->table('ci_tbl_low_quality')->countAllResults();
			$data['txtformatCount'] =  $db->table('ci_tbl_txt_format')->countAllResults();
			$data['speakerCount'] =  $db->table('ci_tbl_speakers')->countAllResults();
			$data['tatCount'] =  $db->table('ci_tbl_tat')->countAllResults();
			$data['timestampCount'] =  $db->table('ci_tbl_timestamp')->countAllResults();
			$data['session'] = $session;
			$data['title'] 		= 'Admin Dashboard'.' - '.WEB_TITLE;
			$data['main_content']	= 'admin/dashboard';	// page name
			return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	
}