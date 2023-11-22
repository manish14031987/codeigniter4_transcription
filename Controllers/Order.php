<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Order_model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;

class Order extends BaseController
{
	 protected $helpers = ['form'];
	
	public function __construct()
    {
		date_default_timezone_set('Asia/Kolkata');
        $this->request  = \Config\Services::request();
		$session = \Config\Services::session();
    }
	
	
	public function place_order_index(): string
    {
		//prd(phpinfo());
		$session = \Config\Services::session();
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'place-order';	// page name
		return view('includes/template', $data);
        
    }
	
	public function place_order_index1(): string
    {
		//prd(phpinfo());
		$session = \Config\Services::session();
		$data = [];
		$data['session'] = $session;
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'place-order1';	// page name
		return view('includes/template', $data);
        
    }
	
    public function order_list()
    {
		$session = \Config\Services::session();
		
		if(!empty(session('userdata')))
		{
			$session = \Config\Services::session();
			$data = [];
			$data['session'] = $session;
			$data['orders'] = $this->get_orders(session('userdata')['user_id']);
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			$data['main_content']	= 'order-list';	// page name
			return view('includes/template', $data);
		}
		else
		{
			return redirect()->to(base_url());
		}
        
    }
	
	public function get_orders($user_id)
	{
		$orderModel = new Order_model();
        return $orderModel->get_orders($user_id);
	}
	
	
	public function slugify($text, string $divider = '-')
	{
	  // replace non letter or digits by divider
	  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, $divider);

	  // remove duplicate divider
	  $text = preg_replace('~-+~', $divider, $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
		return 'n-a';
	  }

	  return $text;
	}


	public function upl1()
	{
		$session = \Config\Services::session();
		
		$originalFileName = $this->request->getPost('originalFileName');
		if ($session->has('file_data')) {
			$session_file_data = $session->get('file_data');
			$fileNames = array();
			foreach($session_file_data as $sfd)
			{
				if($originalFileName == $sfd['orig_name'])
				{
					echo json_encode(array('msg' => 'File is already exists in queue. Please try new one to upload.', 'status' => 'error', 'msgchk' => 'duplicate'));
					die;
				}
			
				$fileNames[] = $sfd['orig_name'];
			}
			
			
		}
		
		
		
		include  APPPATH.'Controllers/getID3/getid3/getid3.php';	
		$isLastChunk = $this->request->getPost('isLastChunk') === 'true';
		$chunk = $this->request->getFile('chunk');
		
		$originalFileExtension = $this->request->getPost('originalFileExtension');
		$videoID = $this->request->getPost('videoID'); // Unique identifier for each video

		// Specify the directory to store chunked files for this video
		$chunkedDir = WRITEPATH . 'chunked_uploads/' . $videoID . '/';
		$finalDir = WRITEPATH . 'uploads/';

		// Ensure the chunked upload directory exists for this video
		if (!is_dir($chunkedDir)) {
			mkdir($chunkedDir, 0777, true);
		}

		// Use the provided original file name and extension
		$newName = $this->slugify($originalFileName) . '-' . date('His') . '.' . $originalFileExtension;

		// Move the uploaded chunk to the chunked directory for this video
		$chunk->move($chunkedDir, $newName);

		if ($isLastChunk) {
			// All chunks have been uploaded, time to assemble the final video

			// Create an array to store the chunked file names for this video
			$chunkedFiles = [];

			// List the files in the chunked directory for this video
			$files = scandir($chunkedDir);

			foreach ($files as $file) {
				if ($file !== '.' && $file !== '..') {
					$chunkedFiles[] = $chunkedDir . $file;
				}
			}

			// Sort the files by name, which should be in the correct order
			sort($chunkedFiles);

			// Create and open the final file for writing
			$finalFilePath = $finalDir . $newName;


			$seconds = array();
			// Concatenate the chunks to assemble the final video
			foreach ($chunkedFiles as $chunkedFile) {
				$chunkData = file_get_contents($chunkedFile);
				file_put_contents($finalFilePath, $chunkData, FILE_APPEND); // Append chunks
				unlink($chunkedFile); // Remove the chunked file
				
				
				
				
				
				
				
			}
			
			
			$getID3 = new \getID3;
			$fileinfo = $getID3->analyze($finalFilePath);

			$allowedFormat = array('mp3', 'mp4', 'aac', 'aiff', 'avi', 'divx', 'dss', 'flv', 'mov', 'mxf', 'ogg', 'vob', 'wav', 'wmv');
			if (!in_array($fileinfo['fileformat'], $allowedFormat)) {
				echo json_encode(array('msg' => 'Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)', 'status' => 'error'));
				exit;
			}

			$seconds[] = (round($fileinfo['playtime_seconds']));
			
			
			$sessionData[] = array(
					'orig_name' => $originalFileName,
					'file_name' => $newName,
					'formatted_duration' => $fileinfo['playtime_string'],
					'file_size' => $fileinfo['filesize'],
					'duration' => (round($fileinfo['playtime_seconds'])),
				);

			// Remove the chunked directory for this video
			rmdir($chunkedDir);

			if ($session->has('file_data')) {
				$session_file_data = $session->get('file_data');
				$finalOutput = array_merge($session_file_data, $sessionData);
				$session->set('file_data', $finalOutput);
			} else {
				$session->set('file_data', $sessionData);
			}

			$html = '';
			echo json_encode(array('html' => $html, 'status' => 'success', 'filesCount' => count($session->get('file_data')), 'seconds' => implode(',', $seconds)));
			exit;
		}
	}

	
	public function upl()
	{
		$session = \Config\Services::session();
		include  APPPATH.'Controllers/getID3/getid3/getid3.php';

		$file = $this->request->getFiles('upl_file');
		$files = $file['upl_file'];

		$filesCount = count($files);
		$validationRules = [
			'upl_file[]' => [
				'rules' => 'uploaded[upl_file]|max_size[upl_file,10000000]|mime_in[upl_file,audio/mpeg,video/x-msvideo,video/mpeg,video/webm,video/mp4,video/quicktime]',
				'label' => 'File',
			],
		];

		if ($this->validate($validationRules)) {
			$i = 0;
			$seconds = array();

			foreach ($files as $f) {
				$ext = pathinfo($f->getClientName(), PATHINFO_EXTENSION);
				$videoName = $this->slugify($f->getClientName()) . '-' . date('His') . '.' . $ext;

				// Define the upload directory for chunks
				$chunkDirectory = WRITEPATH . 'chunked_uploads';

				// Check if the upload directory exists, and create it if not
				if (!is_dir($chunkDirectory)) {
					mkdir($chunkDirectory, 0755, true);
				}

				// Determine the chunk file name
				$chunkFileName = $videoName . '_part_' . $i;

				// Move the chunk to the chunk directory
				$f->move($chunkDirectory, $chunkFileName);

				// Increment the chunk index
				$i++;

				$getID3 = new \getID3;
				$fileinfo = $getID3->analyze($chunkDirectory . '/' . $chunkFileName);

				$allowedFormat = array('mp3', 'mp4', 'aac', 'aiff', 'avi', 'divx', 'dss', 'flv', 'mov', 'mxf', 'ogg', 'vob', 'wav', 'wmv');
				if (!in_array($fileinfo['fileformat'], $allowedFormat)) {
					echo json_encode(array('msg' => 'Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)', 'status' => 'error'));
					exit;
				}

				$seconds[] = (round($fileinfo['playtime_seconds']));
			}

			// Store $videoName and other information in session
			// You can modify this logic according to your requirements

			if ($session->has('file_data')) {
				$session_file_data = $session->get('file_data');
				$finalOutput = array_merge($session_file_data, $sessionData);
				$session->set('file_data', $finalOutput);
			} else {
				$session->set('file_data', $sessionData);
			}

			$html = '';
			echo json_encode(array('html' => $html, 'status' => 'success', 'filesCount' => count($session->get('file_data')), 'seconds' => implode(',', $seconds)));
			exit;
		} else {
			echo json_encode(array('msg' => 'Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)', 'status' => 'error'));
			exit;
		}
	}

	
	/*
	public function upl() 
	{
		
		$session = \Config\Services::session();
		
		//prd($data);
        include  APPPATH.'Controllers/getID3/getid3/getid3.php';

		$file = $this->request->getFiles('upl_file');
		$files = $file['upl_file'];
		
		
		
		
		
		$filesCount = count($files);
		$validationRules = [
				'upl_file[]' => [
					'rules' => 'uploaded[upl_file]|max_size[upl_file,10000000]|mime_in[upl_file,audio/mpeg,video/x-msvideo,video/mpeg,video/webm,video/mp4,video/quicktime]',
					'label' => 'File',
				],
			];
		if ($this->validate($validationRules)) {
		
		
		$i=0;	
		$seconds = array();
		foreach($files as $f ) {
		
		//$newName = $f->getRandomName();

		$ext = pathinfo($f->getClientName(), PATHINFO_EXTENSION);
		$newName = $this->slugify($f->getClientName()).'-'.date('His').'.'.$ext;
		$f->move(WRITEPATH.'uploads', $newName);
		////////////////////////////////////////////////////////////////////////////////////
		
		
		 // Get the uploaded chunk data and file information
        $request = service('request');
        $chunk = 1;
        $totalChunks = 10;
        $file = $request->getFile('file');

        // Define the upload directory
        $uploadDirectory = WRITEPATH.'uploads';

        // Check if the upload directory exists, and create it if not
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        // Determine the file name
		$ext = pathinfo($f->getClientName(), PATHINFO_EXTENSION);
		$filename = $this->slugify($f->getClientName()).'-'.date('His').'.'.$ext;
		
        
        $targetFile = $uploadDirectory . $filename . '.part_' . $chunk;

        // Move the chunk to the target file
        //$file->move($uploadDirectory, $targetFile);

        // Check if all chunks have been uploaded
        if ($chunk == $totalChunks) {
            // Combine all the chunks into the final file
            $finalFile = $uploadDirectory . $filename;
            for ($i = 1; $i <= $totalChunks; $i++) {
                $chunkFile = $uploadDirectory . $filename . '.part_' . $i;
                file_put_contents($finalFile, file_get_contents($chunkFile), FILE_APPEND);
                unlink($chunkFile); // Remove the temporary chunk
            }

            // Process the final file as needed (e.g., save to a database or perform other operations)
            // Your custom logic here...

            // Return a success response
            //return json_encode(['status' => 'success', 'message' => 'File uploaded successfully.']);
        }
		
		
		
		
		///////////////////////////////////////////////////////////////////////////////////
		/*
		if($f->move(WRITEPATH.'uploads', $newName))
		{
			$error = $f->getErrorString();
			// You can also log the error for debugging purposes.
			//log_message('error', 'File Upload Error: ' . $error);
			echo json_encode(array('msg' => $error, 'status' => 'error'));
		    exit;
		}
		else
		{
	
		}
		
		
		
		
		$getID3 = new \getID3;
		$fileinfo = $getID3->analyze(WRITEPATH.'uploads/'.$newName.'');
		//prd($fileinfo);
		$allowedFormat = array('mp3', 'mp4', 'aac', 'aiff', 'avi', 'divx', 'dss', 'flv', 'mov', 'mxf', 'ogg', 'vob', 'wav', 'wmv');
		if(!in_array($fileinfo['fileformat'], $allowedFormat))
		{
			echo json_encode(array('msg' => 'Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)
', 'status' => 'error'));
		    exit;
		}
		
		$seconds[] = (round($fileinfo['playtime_seconds']));
			
		
		$sessionData[] = array(
			'orig_name' => $f->getClientName(),
			'file_name' => $newName,
			'formatted_duration' => $fileinfo['playtime_string'],
			'file_size' => $fileinfo['filesize'],
			'duration' => (round($fileinfo['playtime_seconds'])),
		);
		}
		
		
		if($session->has('file_data'))
		{
			$session_file_data = $session->get('file_data');
			$finalOutput = array_merge($session_file_data, $sessionData);
			
			//print_r($finalOutput); die;
			//$session_file_data[] = $sessionData;
			$session->set('file_data',$finalOutput);
	
		}  
		else
		{
			$session->set('file_data',$sessionData);
		}
		
		$html = '';
		echo json_encode(array('html' => $html, 'status' => 'success', 'filesCount' => count($session->get('file_data')), 'seconds' => implode(',',$seconds)));
		exit;
		
		} 
		else 
		{
			echo json_encode(array('msg' => 'Invalid File Extension (Allowed formats: .MP3, .MP4, .AAC, .AIFF, .AVI, .DIVX, .DSS, .FLV, .MOV, .MXF, .OGG, .VOB, .WAV, .WMV)
', 'status' => 'error'));
		    exit;	
		}	
        
    }  
	*/
	function getSessionUploadFiles()
	{
		$data = array();
		$data['language'] = $this->get_langugae();
		$data['language_tat'] = $this->get_langugae_tat();
		$data['quality'] = $this->get_quality();
		$data['speakers'] = $this->get_speakers();
		$data['tat'] = $this->get_tat();
		$data['timestamp'] = $this->get_timestamp();
		$data['txt_format'] = $this->get_txt_format();
		$session = \Config\Services::session();
		$html = '';
		$lang_case = '';
		if($session->has('file_data'))
		{
			$htmlData = $session->get('file_data');
			
			$html = '';
			$html .= '<section class="order__sect sec_0" data-val="0">
					<form id="order_data">
						<div class="container">
							<div class="row">
								<div class="col-lg-9 order_option">';
			$html .= '<div class="order-area-flex">';
			$html .= '<div class="order_header order_option_flex">
						<table class="table table-border">
							<thead style="color: #fff;">
								<tr>
									<th>File Name</th>
									<th>Status</th>
									<th>Duration</th>
									<th>Trash</th>
								</tr>
							</thead>
							<tbody>';
			$i=0;	
			$seconds = array();
			$filesCount = count($htmlData);
			foreach($htmlData as $f ) {
			$newName = $f['file_name'];
			
			
			//$f->move(WRITEPATH.'uploads', $newName);
			//$getID3 = new \getID3;
			//$fileinfo = $getID3->analyze(WRITEPATH.'uploads/'.$newName.'');
			$seconds[] = $f['duration'];
					
				$html .= '<tr class="item_0">
							<td class="filenames"><p>'.$f['orig_name'].'</p><input type="hidden" id="loop_'.$i.'" value="'.$i.'"/></td>
							<td><img src="'.base_url().'assets/images/check.svg" alt="" /></td>
							<td><img src="'.base_url().'assets/images/stopwatch.svg" alt="" /><span class="me-4">'.$f['formatted_duration'].'</span></td>
							<td>
								<span><img src="'.base_url().'assets/images/trash.svg" onclick="removeItem('.$i.')" style="cursor: pointer;" /><span></span></span>
							</td>
						</tr>';
			$i++;	
			}		
			$html .= '</tbody>
						</table>
							</div>';
			
			
			if($session->has('formData'))
			{
				$selectedFields = $session->get('formData');
			}
			else
			{
				$selectedFields = array(
			'language' => '',
			'text_format' => '',
			'speakers' => '',
			'quality' => '',
			'timestamping' => '',
			'duration' => ''
			);
			}
			//prd($selectedFields)	;
			$lang_option = '';		
			foreach($data['language'] as $lang)
			{
				$selected = ($selectedFields['language'] == $lang['lang_id'])?'selected':'';
				$lang_option .= '<option value="'.$lang['lang_id'].'" data-price="0" '.$selected.'/>'.$lang['lang_name'].'</option>';
			}
			
			$html .= '<div class="area-wrap"><input type="hidden" id="seconds" value="'.implode(',',$seconds).'"/>';
			$html .= '<div class="order_content">
				<div class="order_info">
					<div class="order_info_flex">
						<p>
							<span class="me-3"><img src="assets/images/language.svg" alt="" /></span>Choose Language
						</p>
						<div class="language_opt">
							<select class="language" id="language" name="language" >
								'.$lang_option	.'
							</select>
						</div>
					</div>
				</div>
			</div>
			';		
			$txt_format_option = '';
			$j=1;
			foreach($data['txt_format'] as $tf)
			{
				if($selectedFields['text_format'] != '')
				{
					$checked = ($selectedFields['text_format'] == $tf['cttf_id'])?'checked':'';
				}
				else
				{
					$checked = ($j==1)?'checked="checked"':'';
				}
			
				$txt_format_option .= '<div class="order_flex">
										<div class="form-check">
											<input data-price="'.$tf['cttf_price'].'" type="radio" class="form-check-input text_format_class" id="text_format_'.$j.'" name="text_format" value="'.$tf['cttf_id'].'" '.$checked.' />
											<label class="form-check-label" for="text_format_'.$j.'"><p>'.$tf['cttf_name'].'</p></label>
										</div>
									</div>';
			$j++;
			}
			
			$html .= '<div class="order_content">
						<div class="order_info">
							<div class="order_contect_flex">
								<div class="colum-30">
									<p>
										<span class="me-3"><img src="assets/images/textformat.svg" alt="" /></span>Text format
									</p>
								</div>
								<div class="d-flex gap-5 ml-80 colum-60">
									
									'.$txt_format_option.'
									
								</div>
							</div>
						</div>
					</div>
					';
				
			$html .= '<div class="order_content">
						<div class="order_info">
							 <div class="order_contect_flex">
								<div class="colum-30">
									<p><span class="me-3"><img src="assets/images/language.svg" alt=""></span>Turnaround time</p>
								</div>
								 <div class="d-flex gap-5 ml-80 colum-60">		
								 <div id="tat_data" class="flex_loc"></div>
								</div>
							</div>
						</div>
					</div>	';

			$speakers_option = '';
			$k=1;
			foreach($data['speakers'] as $sp)
			{
				if($selectedFields['speakers'] != '')
				{
					$checked = ($selectedFields['speakers'] == $sp['cts_id'])?'checked':'';
				}
				else
				{
				$checked = ($k==1)?'checked="checked"':'';
				}
				
				$speakers_option .= '<div class="order_flex">
										<div class="form-check">
											<input data-price="'.$sp['cts_price'].'"  type="radio" class="form-check-input speakers_class" id="speakers_'.$k.'" name="speakers" value="'.$sp['cts_id'].'" '.$checked.' />
											<label class="form-check-label" for="speakers_'.$k.'"><p>'.$sp['cts_name'].'</p></label>
										</div>
									</div>';
			$k++;
			}
			$html .= '<div class="order_content">
						<div class="order_info">
							<div class="order_contect_flex">
								<div class="colum-30">
									<p>
										<span class="me-3"><img src="assets/images/people.svg" alt="" /></span>Number of speakers
									</p>
								</div>
								<div class="d-flex gap-5 ml-80 colum-60">
									
									'.$speakers_option.'
									
									
								</div>
							</div>
						</div>
					</div>
					';
			$quality_option = '';
			$l=1;
			foreach($data['quality'] as $q)
			{
				
				if($selectedFields['quality'] != '')
				{
				$checked = ($selectedFields['quality'] == $q['ctlq_id'])?'checked':'';
				}
				else
				{
					$checked = ($l==1)?'checked="checked"':'';
				}
				$quality_option .= '<div class="order_flex">
										<div class="form-check">
											<input data-price="'.$q['ctlq_price'].'"  type="radio" class="form-check-input quality_class" id="quality_'.$l.'" name="quality" value="'.$q['ctlq_id'].'" '.$checked.' />
											<label class="form-check-label" for="quality_'.$l.'"><p>'.$q['ctlq_name'].'</p></label>
										</div>
									</div>';
									$l++;
			}
			$html .= '<div class="order_content">
						<div class="order_info">
							<div class="order_contect_flex">
								<div class="colum-30">
									<p>
										<span class="me-3"><img src="assets/images/prize.svg" alt="" /></span>Low-quality audio Heavy accent
									</p>
								</div>
								<div class="d-flex gap-5 ml-80 colum-60">
									
									'.$quality_option.'
									
								</div>
							</div>
						</div>
					</div>
					';
			$timestamp_option = '';		
			foreach($data['timestamp'] as $t)
			{
				$selected = ($selectedFields['timestamping'] == $t['cttt_id'])?'selected':'';
				$timestamp_option .= '<option data-price="'.$t['cttt_price'].'"  value="'.$t['cttt_id'].'" '.$selected.'>'.$t['cttt_name'].'</option>';
			}
			$html .= '<div class="order_content">
						<div class="order_info">
							<div class="order_info_flex order_contect_flex">
								<p>
									<span class="me-3"><img src="assets/images/time.svg" alt="" /></span>Timestamping
								</p>
								<div class="gap-5 ml-80">
									<select class="language  timestamping_class" id="timestamping" name="timestamping">
									'.$timestamp_option.'	
									</select>
								</div>
							</div>
						</div>
					</div>
					';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			
			$order_summary = '';
			$j=0;
			for($i=0; $i<$filesCount; $i++)
			{
				$session = \Config\Services::session();	
				if(session('userdata'))
				{
				if((session('userdata'))['user_role'] == 3)
				{	
					/*
					$order_summary .= '<div class="price">
						<p>Duration:</p>
						<p id="tot_duration_'.$i.'">-</p>
						<input type="hidden" name="tot_duration_'.$i.'" id="hidden_tot_duration_'.$i.'"  value="" />
					</div>
					<div class="price">
						<p>Files:</p>
						<p id="tot_files">1</p>
					</div>
					<div class="price">
						<p>Price:</p>
						<p><span id="tot_price_'.$i.'">-</span></p>
						
					</div>';
					*/
					$order_summary .=
					'<input type="hidden" name="tot_duration_'.$i.'" id="hidden_tot_duration_'.$i.'"  value="" />
					<input type="hidden" name="tot_price_'.$i.'" id="hidden_tot_price_'.$i.'"  value="" />
					<div class="price-loop">
						<p>'.$htmlData[$j]['orig_name'].'</p>
						<p><a id="tot_duration_'.$i.'"></a> <span id="tot_price_'.$i.'"></span></p>
					  </div>';
				}
				elseif((session('userdata'))['user_role'] == 2)
				{
					/*
					$order_summary .= '<div class="price">
						<p>Duration:</p>
						<p id="tot_duration_'.$i.'">-</p>
						<input type="hidden" name="tot_duration_'.$i.'" id="hidden_tot_duration_'.$i.'"  value="" />
					</div>
					<div class="price">
						<p>Files:</p>
						<p id="tot_files">1</p>
						<input type="hidden" name="tot_price_'.$i.'" id="hidden_tot_price_'.$i.'"  value="" />
					</div>
					';
					*/
					
					$order_summary .=
					'<input type="hidden" name="tot_duration_'.$i.'" id="hidden_tot_duration_'.$i.'"  value="" />
					<input type="hidden" name="tot_price_'.$i.'" id="hidden_tot_price_'.$i.'"  value="" />
					<div class="price-loop">
						<p>'.$htmlData[$j]['orig_name'].'</p>
						<p><a id="tot_duration_'.$i.'"></a></p>
					  </div>';
				}
				}
				else
				{
					/*
					$order_summary .= '<div class="price">
						<p>Duration:</p>
						<p id="tot_duration_'.$i.'">-</p>
						<input type="hidden" name="tot_duration_'.$i.'" id="hidden_tot_duration_'.$i.'"  value="" />
					</div>
					<div class="price">
						<p>Files:</p>
						<p id="tot_files">1</p>
					</div>
					<div class="price">
						<p>Price:</p>
						<p><span id="tot_price_'.$i.'">-</span></p>
						<input type="hidden" name="tot_price_'.$i.'" id="hidden_tot_price_'.$i.'"  value="" />
					</div>';
					*/
					$order_summary .=
					'<input type="hidden" name="tot_duration_'.$i.'" id="hidden_tot_duration_'.$i.'"  value="" />
					<input type="hidden" name="tot_price_'.$i.'" id="hidden_tot_price_'.$i.'"  value="" />
					<div class="price-loop">
						<p>'.$htmlData[$j]['orig_name'].'</p>
						<p><a id="tot_duration_'.$i.'"></a> <span id="tot_price_'.$i.'"></span></p>
					  </div>';
				}
			$j++;	
			}
			
			
			if(session('userdata'))
			{
			if((session('userdata'))['user_role'] == 3)
			{
			
			$html .= '<div class="col-lg-3">
						<div class="order__summery">
							<h2 class="order_head">Order Summary</h2>
							<input id="duration_0" type="hidden" name="duration" value="" />
							
							'.$order_summary.'
							
							<div class="price">
								<p>Total Price:</p>
								<p><span id="final_tot_price">-</span></p>
							</div>
							<div class="total_price">
								<button type="submit" class="s-upload-show-uploaded-file-table-bottom__btn js-gtm-continue">Continue</button>
							</div>
						</div>
					</div>';
			}
			elseif((session('userdata'))['user_role'] == 2)
			{
				$html .= '<div class="col-lg-3">
						<div class="order__summery">
							<h2 class="order_head">Order Summary</h2>
							<input id="duration_0" type="hidden" name="duration" value="" />
							
							'.$order_summary.'
							
							
							<div class="total_price">
								<button type="submit" class="s-upload-show-uploaded-file-table-bottom__btn js-gtm-continue">Place Order</button>
							</div>
						</div>
					</div>';
			}
			}
			else
			{
			
			$html .= '<div class="col-lg-3">
						<div class="order__summery">
							<h2 class="order_head">Order Summary</h2>
							<input id="duration_0" type="hidden" name="duration" value="" />
							
							
							'.$order_summary.'
							
							<div class="price">
								<p>Total Price:</p>
								<p><span id="final_tot_price">-</span></p>
							</div>
							<div class="total_price">
								<button type="submit" class="s-upload-show-uploaded-file-table-bottom__btn js-gtm-continue">Continue</button>
							</div>
						</div>
					</div>';
			}
			
			
			$html .= '</div>';
					
			$html .= '</div>';
					
			$html .= '</form>';
			
			$html .= '</section>';
			echo json_encode(array('html' => $html, 'filecount' => $filesCount));
			exit;
		}
	}
	
	public function get_langugae()
	{
		$orderModel = new Order_model();
        return $orderModel->get_langugae();
	}
	public function get_langugae_tat()
	{
		$orderModel = new Order_model();
        return $orderModel->get_langugae_tat();
	}
	public function get_quality()
	{
		$orderModel = new Order_model();
        return $orderModel->get_quality();
	}
	public function get_speakers()
	{
		$orderModel = new Order_model();
        return $orderModel->get_speakers();
	}
	public function get_tat()
	{
		$orderModel = new Order_model();
        return $orderModel->get_tat();
	}
	public function get_timestamp()
	{
		$orderModel = new Order_model();
        return $orderModel->get_timestamp();
	}
	public function get_txt_format()
	{
		$orderModel = new Order_model();
        return $orderModel->get_txt_format();
	}

	public function update_tat()
	{
		$session = \Config\Services::session();
		if(session('userdata'))
		{
		if((session('userdata'))['user_role'] == 3)
		{
	
			//prd(rq());
			if ($this->request->isAJAX() && array_key_exists('lang', rq())) {
			
			
			if($session->has('formData'))
			{
				$selectedFields = $session->get('formData');
			}
			else
			{
				$selectedFields = array(
				'language' => '',
				'text_format' => '',
				'speakers' => '',
				'quality' => '',
				'timestamping' => '',
				'duration' => '',
				'tat' => ''
				);
			}
			
			//prd($selectedFields);
			$orderModel = new Order_model();
			$output =  $orderModel->update_tat(rq());
			$html = '';
			$i=1;
			$request = rq();
			foreach($output as $o)
			{
				//prd($selectedFields);
				//if(@$selectedFields['tat'] != '')
				//{
				 //   $checked = ($selectedFields['tat'] == $o['lang_tat'])?'checked':'';
				//}
				//else
				//{
					$checked = ($i==1)?'checked':'';
				//}
				$html .= '<div class="order_flex">
							<div class="form-check">
								<input data-price="'.$o['lang_price'].'" type="radio" class="form-check-input" id="taaa" name="tat" value="'.$o['lang_tat'].'" '.$checked.' />
								<label class="form-check-label" for="taaa"><p>'.$o['ctt_name'].'</p></label>
								<br/>
								<span>$'.$o['lang_price'].'</span>
							</div>
						</div>
						';
			$i++;			
			}
			echo json_encode(array('html' => $html));
			exit;
			}
		}
		elseif((session('userdata'))['user_role'] == 2)
		{
			//prd(rq());
			if ($this->request->isAJAX() && array_key_exists('lang', rq())) {
			
			
			if($session->has('formData'))
			{
				$selectedFields = $session->get('formData');
			}
			else
			{
				$selectedFields = array(
				'language' => '',
				'text_format' => '',
				'speakers' => '',
				'quality' => '',
				'timestamping' => '',
				'duration' => '',
				'tat' => ''
				);
			}
			
			//prd($selectedFields);
			$orderModel = new Order_model();
			$output =  $orderModel->update_tat(rq());
			$html = '';
			$j=1;
			$request = rq();
			foreach($output as $o)
			{
				//prd($selectedFields);
				//prd($selectedFields);
				//if(@$selectedFields['tat'] != '')
				//{
				 //   $checked = ($selectedFields['tat'] == $o['lang_tat'])?'checked':'';
				//}
				//else
				//{
					$checked = ($j==1)?'checked':'';
				//}
				$html .= '<div class="order_flex">
							<div class="form-check">
								<input data-price="0" type="radio" class="form-check-input" id="taaa" name="tat" value="'.$o['lang_tat'].'" '.$checked.' />
								<label class="form-check-label" for="taaa"><p>'.$o['ctt_name'].'</p></label>
								<br/>
								<span></span>
							</div>
						</div>
						';
			$j++;			
			}
			echo json_encode(array('html' => $html));
			exit;
			}
		}
		}
		else
		{
	
			//prd(rq());
			if ($this->request->isAJAX() && array_key_exists('lang', rq())) {
			
			$session->remove('formData');
			if($session->has('formData'))
			{
				$selectedFields = $session->get('formData');
			}
			else
			{
				$selectedFields = array(
				'language' => '',
				'text_format' => '',
				'speakers' => '',
				'quality' => '',
				'timestamping' => '',
				'duration' => '',
				'tat' => ''
				);
			}
			
			//prd($selectedFields);
			$orderModel = new Order_model();
			$output =  $orderModel->update_tat(rq());
			$html = '';
			$k=1;
			$request = rq();
			foreach($output as $o)
			{
				//prd($selectedFields);
				//if(@$selectedFields['tat'] != '')
				//{
				 //   $checked = ($selectedFields['tat'] == $o['lang_tat'])?'checked':'';
				//}
				//else
				//{
					$checked = ($k==1)?'checked':'';
				//}
				$html .= '<div class="order_flex">
							<div class="form-check">
								<input data-price="'.$o['lang_price'].'" type="radio" class="form-check-input" id="taaa" name="tat" value="'.$o['lang_tat'].'" '.$checked.' />
								<label class="form-check-label" for="taaa"><p>'.$o['ctt_name'].'</p></label>
								<br/>
								<span>$'.$o['lang_price'].'</span>
							</div>
						</div>
						';
			$k++;			
			}
			echo json_encode(array('html' => $html));
			exit;
			}
		
		
		}
	}
	
	public function calculatePrice()
	{
	
		$session = \Config\Services::session();
		
		if(session('userdata'))
		{
		if((session('userdata'))['user_role'] == 3)
		{
		
			if ($this->request->isAJAX() && array_key_exists('seconds', rq())) {
			$request = rq();
			$seconds = explode(',',$request['seconds']);
			
			
			
			$orderModel = new Order_model();
			$output = $orderModel->calculatePrice($request);
			
			if(!empty($output))
			{
				$total= 0;
				foreach($output as $o)
				{
					$total += $o['price'];
				}
			}
			
			$finalArr = array();
			$i=0;
			foreach($seconds as $s)
			{
				$hours = floor($s / 3600);
				$mins = floor($s / 60 % 60);
				$secs = floor($s % 60);
				$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			
				$finalArr[] = array(
					'mins' => $timeFormat,
					'price' => number_format((float)$total*ceil($s / 60), 2, '.', '')
				);
			$i++;
			}
			
			
			//prd($finalArr);
			echo json_encode($finalArr);
			exit;
			}
		}
		elseif((session('userdata'))['user_role'] == 2)
		{
			$request = rq();
			$seconds = explode(',',$request['seconds']);
			$finalArr = array();
			$i=0;
			foreach($seconds as $s)
			{
				$hours = floor($s / 3600);
				$mins = floor($s / 60 % 60);
				$secs = floor($s % 60);
				$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			
				$finalArr[] = array(
					'mins' => $timeFormat,
					'price' => 0
				);
			$i++;
			}
		
			echo json_encode($finalArr);
			exit;
		}
		}
		else
		{
		
			if ($this->request->isAJAX() && array_key_exists('seconds', rq())) {
			$request = rq();
			$seconds = explode(',',$request['seconds']);
			
			
			
			$orderModel = new Order_model();
			$output = $orderModel->calculatePrice($request);
			if(!empty($output))
			{
				$total= 0;
				foreach($output as $o)
				{
					$total += $o['price'];
				}
			}
			
			$finalArr = array();
			$i=0;
			foreach($seconds as $s)
			{
				$hours = floor($s / 3600);
				$mins = floor($s / 60 % 60);
				$secs = floor($s % 60);
				$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			
				$finalArr[] = array(
					'mins' => $timeFormat,
					'price' => number_format((float)$total*ceil($s / 60), 2, '.', '')
				);
			$i++;
			}
			
			
			//prd($finalArr);
			echo json_encode($finalArr);
			exit;
			}
		}
		
	}
	
	
	public function saveSessionData()
	{
		$session = \Config\Services::session();
		$request = rq();
		//prd($request['sessionData']);
		$newdata = [
			'sessionData'  => $request['sessionData']
		];
		$session->remove('sessionData');
		//$session->set($newdata);
		//$item = $session->get('sessionData');
		//prd($item);
	}
	
	public function getFormData()
	{
		//prd(rq());
		$request = rq();
		$session = \Config\Services::session();
		$request = rq();
		//prd($request['sessionData']);
		$newdata = [
			'formData'  => $request
		];
		$session->remove('formData');
		$session->set($newdata);
	}
	
	
	public function removeItem()
	{
		if(array_key_exists('itemnumber', rq()))
		{
		$session = \Config\Services::session();
		$htmlData = $session->get('file_data');
		unset($htmlData[$_POST['itemnumber']]); 
		$arr2 = array_values($htmlData);
		$session->set('file_data', $arr2);
		$remainfile = (empty($session->get('file_data')))?0:'-';
		if($remainfile == 0)
		{
			$session->remove('file_data');
			$session->remove('formData');
		}
		//print_r($this->session->userdata('file_data')); die;
		echo json_encode(array('msg' => 'Remove successfully', 'status' => 'success', 'remain' => $remainfile));
		exit;
		}
	}
	
	public function orderData()
	{
		$session = \Config\Services::session();
		
		if($session->has('userdata'))
		{
			
			$request = rq();
			$userInfo = $session->get('userdata');
			$filesInfo = $session->get('file_data');
			
			$order = array(
				'user_id' => $userInfo['user_id'],
				'order_items' => NULL,
				'order_transcation_id' => 0,
				'order_created' => date('Y-m-d H:i:s')
			);
			$orderitems = array();
			$i=0;
			foreach($filesInfo as $fi)
			{
				$orderitems[] = array(
					'item_name' => $fi['orig_name'],
					'item_file' => $fi['file_name'],
					'item_duration' => $fi['duration'],
					'item_size' => $fi['file_size'],
					'item_language' => $request['language'],
					'item_text_format' => $request['text_format'],
					'item_tat' => $request['tat'],
					'item_speakers' => $request['speakers'],
					'item_low_quality' => $request['quality'],
					'item_timestamping' => $request['timestamping'],
					'item_amount' => $request['tot_price_'.$i.'']
				);
			$i++;	
			}
			
			$transcation = array();
			
			$orderModel = new Order_model();
			$output = $orderModel->orderData($order, $orderitems,$transcation);
			//prd($output);
			if($output)
			{
				   $session = \Config\Services::session();
				   if((session('userdata'))['user_role'] == 3)
				   {
						echo json_encode(array('msg' => 'Order placed successfully.', 'status' => 'success', 'redirect' => base_url().'payment/'.encryptMyData($output).''));
						exit;
				   }
				   else
				   {
						echo json_encode(array('msg' => 'Order placed successfully.', 'status' => 'success', 'redirect' => base_url().'payment-success/'.encryptMyData($output).''));
						exit;
				   }
				
			}
			
		}
		else
		{
			$newdata = [
				'return_url'  => base_url().'place-order'
			];
			$session->remove('return_url');
			$session->set($newdata);
			echo json_encode(array('msg' => 'Redirect to login page', 'status' => 'redirect', 'redirect' => base_url().'login'));
			exit;
			
		}
	}
	
	
	
}
