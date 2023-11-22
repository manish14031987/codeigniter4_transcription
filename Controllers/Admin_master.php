<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use App\Models\Admin_master_model;
class Admin_master extends BaseController
{
	function __construct(){
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	
	public function lang_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];

		$data['session'] = $session;
		$data['title'] 		= 'Language Master'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/lang_master';	// page name
		return view('admin/includes/template', $data);
		
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	public function lang_ajax()
    {
		$userModel = new Admin_master_model();
        $output = $userModel->lang_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Language insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
    }
	public function lang_rpt()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->lang_rpt();
		echo json_encode($output);
	}
	public function edit_lang()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_lang(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	public function edit_lang_price()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_lang_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	public function change_lang_status()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->change_lang_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	public function delete_lang()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->delete_lang(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	//////////////////////////////////////////////////////////////////////////////
		
	public function language_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		
		
		$data['tat'] = $this->tat_dropdown();
		$data['language'] = $this->lng_dropdown();
		$data['session'] = $session;
		$data['title'] 		= 'Language Master'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/language_master';	// page name
		return view('admin/includes/template', $data);
		
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	
	public function tat_dropdown()
	{
		$userModel = new Admin_master_model();
        return $userModel->tat_dropdown();
	}
	public function lng_dropdown()
	{
		$userModel = new Admin_master_model();
        return $userModel->lng_dropdown();
	}
	public function language_ajax()
    {
		$userModel = new Admin_master_model();
        $output = $userModel->language_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Language insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
    }
	
	public function language_rpt()
	{
		$tat_json = $this->tat_dropdown();
		$lang_json = $this->lng_dropdown();
		$userModel = new Admin_master_model();
        $output = $userModel->language_rpt($tat_json, $lang_json);
		echo json_encode($output);
	}
	
	public function edit_language_tat()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_language_tat(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language TAT update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function edit_language()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_language(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function edit_language_price()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_language_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function change_language_status()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->change_language_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	public function delete_language()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->delete_language(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Language delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	
	
	
	public function quality_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Quality Master'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/quality_master';	// page name
		return view('admin/includes/template', $data);
		//return view('admin/quality_master', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	public function quality_ajax()
    {
		$userModel = new Admin_master_model();
        $output = $userModel->quality_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Quality insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
    }
	
	public function quality_rpt()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->quality_rpt();
		echo json_encode($output);
	}
	
	public function edit_quality()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_quality(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Quality update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function edit_quality_price()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_quality_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Quality Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function change_quality_status()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->change_quality_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Quality status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	public function delete_quality()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->delete_quality(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Quality delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	
	
	
	
	public function text_format_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Text Format Master'.' - '.WEB_TITLE;
		
		//return view('admin/text_format_master', $data);
		$data['main_content']	= 'admin/text_format_master';	// page name
		return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	public function textformat_ajax()
    {
		$userModel = new Admin_master_model();
        $output = $userModel->textformat_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Text Format insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
    }
	
	public function textformat_rpt()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->textformat_rpt();
		echo json_encode($output);
	}
	
	public function edit_textformat()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_textformat(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Text Format update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function edit_textformat_price()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->edit_textformat_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Text Format Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}
	
	public function change_textformat_status()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->change_textformat_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Text Format status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	public function delete_textformat()
	{
		$userModel = new Admin_master_model();
        $output = $userModel->delete_textformat(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Text Format delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	
	
	
	public function speaker_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Speaker Master'.' - '.WEB_TITLE;
		
		//return view('admin/speaker_master', $data);
		$data['main_content']	= 'admin/speaker_master';	// page name
		return view('admin/includes/template', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	
	public function speaker_ajax()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->speaker_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Speaker insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
	}

	public function speaker_rpt()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->speaker_rpt();
		echo json_encode($output);
	}

	public function edit_speaker()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->edit_speaker(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Speaker update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}

	public function edit_speaker_price()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->edit_speaker_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Speaker Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}

	public function change_speaker_status()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->change_speaker_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Speaker status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}

	public function delete_speaker()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->delete_speaker(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Speaker delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	
	public function tat_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'TAT Master'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/tat_master';	// page name
		return view('admin/includes/template', $data);
		//return view('admin/tat_master', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	public function tat_ajax()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->tat_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Turn Around Time insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
	}

	public function tat_rpt()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->tat_rpt();
		echo json_encode($output);
	}

	public function edit_tat()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->edit_tat(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Turn Around Time update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}

	public function edit_tat_price()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->edit_tat_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Turn Around Time Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}

	public function change_tat_status()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->change_tat_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Turn Around Time status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}

	public function delete_tat()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->delete_tat(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Turn Around Time delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
	////////////////////////////////////////
	public function timestamp_view()
    {
		$session = \Config\Services::session();
		$userdata = session('userdata');
		if(!empty(session('userdata')) && ($userdata['user_role'] == 1))
		{
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Timestamp Master'.' - '.WEB_TITLE;
		$data['main_content']	= 'admin/timestamp_master';	// page name
		return view('admin/includes/template', $data);
		//return view('admin/timestamp_master', $data);
		}
        else
		{
			return redirect()->to(base_url());
		}
    }
	
	public function timestamp_ajax()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->timestamp_ajax(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Timestamp insert successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
	}

	public function timestamp_rpt()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->timestamp_rpt();
		echo json_encode($output);
	}

	public function edit_timestamp()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->edit_timestamp(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Timestamp update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}

	public function edit_timestamp_price()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->edit_timestamp_price(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Timestamp Price update successfully.', 'status' => 'success', 'id' => $request['pk']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['pk']));
			exit;
		}
	}

	public function change_timestamp_status()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->change_timestamp_status(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Timestamp status update successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}

	public function delete_timestamp()
	{
		$userModel = new Admin_master_model();
		$output = $userModel->delete_timestamp(rq());
		if($output)
		{
			$request = rq();
			echo json_encode(array('msg' => 'Timestamp delete successfully.', 'status' => 'success', 'id' => $request['id']));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error', 'id' => $request['id']));
			exit;
		}
	}
	
}