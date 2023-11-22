<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Cron_model;


class Admin_cron extends BaseController
{
	
	function __construct(){
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		
	}
	
    public function delete_files()
    {
		$userModel = new Cron_model();
        $output = $userModel->delete_files();
		if($output)
		{
			$map = directory_map(WRITEPATH.'uploads/');
			$leftFIles = array();
			foreach($output as $o)
			{
				$leftFIles[] = $o['item_file'];
			}
		}
		
		//pr($map);
		
		
		array_push($leftFIles, 'index.html');
		//pr($leftFIles);
		$arr_1 = array_diff($map, $leftFIles);
		
		foreach($arr_1 as $file) 
		{
			//echo WRITEPATH.'uploads/'.$file; die;
			//if(is_file($file)) 
			
				// Delete the given file
				@unlink(WRITEPATH.'uploads/'.$file);
		}

	}
	
	
	public function upload_files()
	{
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		ini_set('max_execution_time', 0);
		include(APPPATH.'Libraries/BoxAPI.class.php');
		date_default_timezone_set('Asia/Kolkata');
		$client_id = '220wfvp8kstcq17csbaigo4ndsdsqkk4';
        $client_secret = 'sOdDfaYR1ESL7nNWjiYwym0v0s4bJW5h';
	    $redirect_uri = 'https://get-transcription.com/upload_files';
	 
		$box = new \Box_API($client_id, $client_secret, $redirect_uri);
		
		if(!$box->load_token()){
			if(isset($_GET['code'])){
				$token = $box->get_token($_GET['code'], true);
				if($box->write_token($token, 'file')){
					$box->load_token();
				}
			} else {
				$box->get_code();
			}
		}
	
		$getAllUploadedFileName = array();
		$allfiles = $box->get_files('223265898935');
		
		if($allfiles)
		{
			foreach($allfiles as $allfile)
			{
				$getAllUploadedFileName[] = $allfile['name'];
			}
		}
		
		$userModel = new Cron_model();
        $output = $userModel->delete_files();
		//prd($output);
		if($output)
		{
			$map = directory_map(WRITEPATH.'uploads/');
			//prd($map );
			$leftFIles = array();
			foreach($output as $o)
			{
				$leftFIles[] = $o['item_file'];
			}
		}
		//
		array_push($leftFIles, 'index.html');
		//prd($leftFIles);
		$arr_1 = array_diff($map, $leftFIles);
		//prd($arr_1);

		foreach($arr_1 as $file) 
		{
				
		
				$timeInterval = time() - filemtime(WRITEPATH.'uploads/'.$file);
				//prd($timeInterval);
				if($timeInterval > 36000){
				@unlink(WRITEPATH.'uploads/'.$file);
				}
		}
		
		$orderFolderId = '';
		
		$new_array = array_values(array_unique($leftFIles));
		
		
		$substringToRemove = "dailytranscription.box.com";

		// Use array_filter to remove elements containing the specified substring
		$result = array_filter($new_array, function ($element) use ($substringToRemove) {
			return strpos($element, $substringToRemove) === false;
		});
		
		$result = array_filter($result, function($value) {
			return !empty($value);
		});
		
		$substringToRemove = "index.php";

		// Use array_filter to remove elements containing the specified substring
		$result_final = array_filter($result, function ($element) use ($substringToRemove) {
			return strpos($element, $substringToRemove) === false;
		});
		//prd($result_final);
		foreach($result_final as $lf){
			
			$orderids[] = $this->get_order_id($lf);
			
		}	
		$orderids = array_values(array_filter(array_unique($orderids, SORT_REGULAR)));
		//prd($orderids);
		
		
			if($orderids)
			{
				$orderFolderID_upload = array();
				foreach($orderids as $orderid)
				{
					
					$id = $orderid['order_id'];
					$email = $orderid['user_email'];
					
					//check folder exists there or not
					$createFolder = $box->create_folder($email,'223265898935');
					
					if(@$createFolder['id'])
					{
						//folder created
						$createInnerFolder = $box->create_folder('order_'.$id, $createFolder['id']);
						if(@$createInnerFolder['id'])
						{
							$orderFolderID = $createInnerFolder['id'];
							//folder created
							$files = $this->get_files_by_order($id);
							if($files)
							{
								$i=1;
								foreach($files as $file)
								{
									$filename = 'order_'.$id.'_item_'.$i;
									$ext = pathinfo($file['item_file'], PATHINFO_EXTENSION);
									$newfilename = $filename.'.'.$ext;
									$fileItem = $file['item_file']; 
									
									//CHECK FILE SIZE
									$fileSize = filesize(WRITEPATH.'uploads/'.$fileItem);
									if($fileSize > '500000000000')
									{
										$getFileInfo = $this->uploadChunk(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										
									}
									else
									{	
										$getFileInfo = $box->put_file(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										
									}
									$i++;	
								}
							}
							
							
							
						}
						else
						{
							//folder already exists
							$orderFolderID = $createFolder['context_info']['conflicts'][0]['id'];
							//folder created
							$files = $this->get_files_by_order($id);
							if($files)
							{
								$i=1;
								foreach($files as $file)
								{
									$filename = 'order_'.$id.'_item_'.$i;
									$ext = pathinfo($file['item_file'], PATHINFO_EXTENSION);
									$newfilename = $filename.'.'.$ext;
									$fileItem = $file['item_file']; 
									
									//CHECK FILE SIZE
									$fileSize = filesize(WRITEPATH.'uploads/'.$fileItem);
									if($fileSize > '500000000000')
									{
										$getFileInfo = $this->uploadChunk(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										
									}
									else
									{	
										$getFileInfo = $box->put_file(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										
									}
									$i++;	
								}
							}
							
							
							
						}
					
						$orderFolderID_upload[] = $orderFolderID;
						/*
						$folderItems = $box->get_folder_items($orderFolderID);
						
						$fileIDs = array();
						foreach ($folderItems['entries'] as $item) {
							if ($item['type'] == 'file') {
								$fileIDs = $item['id'];
								$params['shared_link']['access'] = 'open'; //open|company|collaborators
								$filDownInfo = ($box->share_file($fileIDs, $params));
								$downloadURL = $filDownInfo['shared_link']['download_url'];
								if($downloadURL)
								{
									// update this url
									$downloadArray = array(
										'order_id' => $id,
										'file_old_name' => $fileItem,
										'new_file_download_url' => $downloadURL
									);
									
									$userModel = new Cron_model();
									$updateCheck = $userModel->updateDownloadLink($downloadArray);
									if($updateCheck)
									{
										unlink(WRITEPATH.'uploads/'.$fileItem);
									}
								}
								
							}
						}
						*/	
					
					}
					else
					{
						
						$emailFolderID = $createFolder['context_info']['conflicts'][0]['id'];
						
						$orderFolder = $box->create_folder('order_'.$id, $emailFolderID);
						if(@$orderFolder['id'])
						{
							$orderFolderID  =  $orderFolder['id'];
							$files = $this->get_files_by_order($id);
							
							if($files)
							{
								$i=1;
								foreach($files as $file)
								{
									$filename = 'order_'.$id.'_item_'.$i;
									$ext = pathinfo($file['item_file'], PATHINFO_EXTENSION);
									$newfilename = $filename.'.'.$ext;
									$fileItem = $file['item_file']; 
									
									//CHECK FILE SIZE
									$fileSize = filesize(WRITEPATH.'uploads/'.$fileItem);
									if($fileSize > '500000000000')
									{
										$getFileInfo = $this->uploadChunk(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										
									}
									else
									{	
										$getFileInfo = $box->put_file(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										
									}
									$i++;	
								}
							}
							
							
						}
						else
						{
							$orderFolderID = $orderFolder['context_info']['conflicts'][0]['id'];
						
							$files = $this->get_files_by_order($id);
							
							if($files)
							{
								
								// Remove items with the specified URL
								$filteredArray = array_filter($files, function ($item) {
									return strpos($item['item_file'], 'https://dailytranscription.box.com/') !== 0;
								});

								// Reset array keys
								$files = array_values($filteredArray);
								
								
								$i=1;
								foreach($files as $file)
								{
									$filename = 'order_'.$id.'_item_'.$i;
									$ext = pathinfo($file['item_file'], PATHINFO_EXTENSION);
									$newfilename = $filename.'.'.$ext;
									$fileItem = $file['item_file']; 
									
									//CHECK FILE SIZE
									$fileSize = filesize(WRITEPATH.'uploads/'.$fileItem);
									//prd($fileSize)
									if($fileSize > '500000000000000')
									{
										$getFileInfo = $this->uploadChunk(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										if ($getFileInfo !== null) {
											//if ($getFileInfo->was_successful()) {
												//echo 'File '.WRITEPATH.'uploads/'.$fileItem.' uploaded successfully!<br/>';
											//} else {
											//	echo 'File '.WRITEPATH.'uploads/'.$fileItem.' upload failed. Error: ' . //$getFileInfo->get_message().'</br>';
											//}
										} else {
											echo 'File '.WRITEPATH.'uploads/'.$fileItem.' upload failed. No response received.<br/>';
										}

										
									}
									else
									{	
										$getFileInfo = $box->put_file(WRITEPATH.'uploads/'.$fileItem, $newfilename, $orderFolderID);
										if ($getFileInfo !== null) {
											//if ($getFileInfo->was_successful()) {
											//	echo 'File '.WRITEPATH.'uploads/'.$fileItem.' uploaded successfully!<br/>';
											//} else {
											//	echo 'File '.WRITEPATH.'uploads/'.$fileItem.' upload failed. Error: ' . //$getFileInfo->get_message().'</br>';
											//}
										} else {
											echo 'File '.WRITEPATH.'uploads/'.$fileItem.' upload failed. No response received.<br/>';
										}
									}
									
									
									$i++;	
								}
							}
							
								
							
							
							
							
							
							
							
							
							
						}
							
						$orderFolderID_upload[] = $orderFolderID;
						
						/*
						$folderItems = $box->get_folder_items($orderFolderID);
						prd($folderItems);
						$fileIDs = array();
						foreach ($folderItems['entries'] as $item) {
							if ($item['type'] == 'file') {
								$fileIDs = $item['id'];
								$params['shared_link']['access'] = 'open'; //open|company|collaborators
								$filDownInfo = ($box->share_file($fileIDs, $params));
								$downloadURL = $filDownInfo['shared_link']['download_url'];
								if($downloadURL)
								{
									// update this url
									$downloadArray = array(
										'order_id' => $id,
										'file_old_name' => $fileItem,
										'new_file_download_url' => $downloadURL
									);
									
									$userModel = new Cron_model();
									$updateCheck = $userModel->updateDownloadLink($downloadArray);
									if($updateCheck)
									{
										unlink(WRITEPATH.'uploads/'.$fileItem);
									}
								}
								
							}
						}
						*/
							
							
					}
						
						
					
					
					
				}
				
			
				foreach($orderFolderID_upload as $orderFolderID)
				{
				$folderItems = $box->get_folder_items($orderFolderID);
				
				$fileIDs = array();
				//$downloadArray = array();
				$i=0;
				foreach ($folderItems['entries'] as $item) {
					
					//$fileItem = $files[$i]['item_file']; 
				
					if ($item['type'] == 'file') {
						$fileIDs = $item['id'];
						$params['shared_link']['access'] = 'open'; //open|company|collaborators
						$filDownInfo = ($box->share_file($fileIDs, $params));
						//prd($filDownInfo);
						$downloadURL = $filDownInfo['shared_link']['download_url'];
						if($downloadURL)
						{
							// update this url
							$downloadArray = array(
								'order_id' => $id,
								'file_old_name' => $filDownInfo['name'],
								'new_file_download_url' => $downloadURL
							);
							
							$userModel = new Cron_model();
							$updateCheck = $userModel->updateDownloadLink($downloadArray);
							if($updateCheck)
							{
								unlink(WRITEPATH.'uploads/'.$filDownInfo['name']);
							}
							
							
						}
						
					}
					
				$i++;
				}
				
				
				/*
				
				*/
				
				}
				
				
			}
			else
			{
				//echo 'No one order id found';
				//exit;
			}
			
		
		
	}
	
	
	public function get_order_id($filename)
	{
		$userModel = new Cron_model();
        return $userModel->get_order_id($filename);
	}
	
	public function get_files_by_order($id)
	{
		$userModel = new Cron_model();
        return $userModel->get_files_by_order($id);
	}
	
	public function post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
	
	
	public function sendEmail($to, $subject, $message)
	{
		$email = \Config\Services::email();
		$config['mailType'] = 'html';
		$config['charset']  = 'iso-8859-1';
		$config['wordWrap'] = true;
		$config['SMTPHost'] = 'u4-ww3becm5nrgs@c110248.sgvps.net';
		
		$email->initialize($config);
		
		$email->setFrom('no-reply@get-transcription.com', 'Get Transcroption');
		$email->setTo($to);
		$email->setSubject($subject);
		$email->setMessage($message);
		
		return $email->send();
	}
	
	public function email()
	{
		$to = 'amitmaism32@gmail.com';
		$subject = "This is a test mail";
		$message = 'Normal Msg';
		$output = $this->sendEmail($to, $subject, $message );
		if($output)
		{
			echo 'Email Sent successfully';
		}
	
		//mail($to,$subject,$message);
	}
	
	
	
	
	
	
	public function uploadChunk($filepath, $newfilename, $folder)
	{
		
		ini_set('post_max_size', '1024M');
		ini_set('upload_max_filesize', '1024M');
		$fileSize = filesize($filepath);
		$accessJson = json_decode(file_get_contents(base_url().'token.box'), true);
		$access_token = $accessJson['access_token']; // Replace with your access token
		// Specify the file to upload
		//$filePath = FCPATH.'uploads/file.mp4';
		$filePath = $filepath;
		// Set the file name
		//$fileName = 'file.mp4';
		$fileName = $newfilename;
		// Create a session for the chunked upload
		$session_data = array(
			'folder_id' => $folder, // Set the parent folder ID where you want to upload
			'file_name' => $fileName,
			'file_size' => $fileSize, // Include the file size
		);
		//pr($session_data);
		$session_data_json = json_encode($session_data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://upload.box.com/api/2.0/files/upload_sessions');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $access_token,
			'Content-Type: application/json',
			'Content-Length: ' . strlen($session_data_json)
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $session_data_json);
		$response = curl_exec($ch);
		
		if ($response === false) {
			echo 'Error: ' . curl_error($ch);
		} else {
			$session_info = json_decode($response, true);
			// echo "<pre>";
			//print_r($session_info);
			
			if (isset($session_info['id'])) {
				$session_id = $session_info['id'];
				// Open the file for reading
				$fileHandle = fopen($filePath, 'rb');
				$sha1_hash = sha1_file($filePath);
				// Base64 encode the SHA-1 hash
				$base64_encoded_sha1 = base64_encode(pack('H*', $sha1_hash));
				
				$chunkNumber = 1; // Initialize a variable to keep track of the chunk number
				$chunkSize = $session_info['part_size']; 
				// Initialize the chunked upload
				//$commit_data['parts']  = array();
				while (!feof($fileHandle)) {
					//$chunk = fread($fileHandle, $session_info['part_size']); // Set your chunk size here (1MB in this example)
					$chunk = fread($fileHandle, $chunkSize);

					$chunkSize = strlen($chunk); // Adjust chunk size for the last chunk if needed
					
					$digest = sha1($chunk);

					// Base64 encode the actual SHA-1 hash
					$base64_encoded_digest = base64_encode(pack('H*', $digest));
					///echo "Actual".$base64_encoded_actual."<br>";			

					// Calculate the offset
					/* $startOffset = ($chunkNumber - 1) * $chunkSize;
					$endOffset = $startOffset + $chunkSize - 1; */
					
					$startOffset = ($chunkNumber - 1) * $session_info['part_size'];
					$endOffset = $startOffset + strlen($chunk) - 1;
					
					// Upload a chunk
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://upload.box.com/api/2.0/files/upload_sessions/{$session_id}");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");										
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Authorization: Bearer ' . $access_token,
						'Content-Length: ' . strlen($chunk),
						'Content-Type: application/octet-stream',
						'Content-Range: bytes ' . $startOffset . '-' . $endOffset . '/' . $fileSize, // Include the Content-Range header
						'Digest: sha=' . $base64_encoded_digest, // Include the Base64 encoded SHA-1 hash
					));
					curl_setopt($ch, CURLOPT_POSTFIELDS, $chunk);
					$response = curl_exec($ch);
					
					$part_data = json_decode($response, true); 
					
					
					// Add the part information to the commit data
					$commit_data['parts'][] = array(
						'part_id' => $part_data['part']['part_id'], // Replace with the actual part ID
						'offset' => $part_data['part']['offset'],
						'size' => $part_data['part']['size'],
						'sha1' => $part_data['part']['sha1'],
					);
					
					//echo "<pre>";
					//print_r($part_data);
					
					if ($response === false) {
						echo 'Error: ' . curl_error($ch);
						break;
					}
					$chunkNumber++;
				}
				
				
				// Close the file handle
				fclose($fileHandle);
				$commit_data_json = json_encode($commit_data);
				
				
				
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://upload.box.com/api/2.0/files/upload_sessions/{$session_id}/commit");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer ' . $access_token,
					'Content-Type: application/json',
					'Digest: sha=' . $base64_encoded_sha1, // Include the Base64 encoded SHA-1 hash
				));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $commit_data_json);

				$response = curl_exec($ch);
				echo $commit_data_json;
				//echo '-----------------M-------------';
				//echo "<pre>";
				//print_r(json_decode($response, true));
				//die;
				
				
				
				
				
				
				/* $sha1_hash = sha1_file($filePath);
				// Base64 encode the SHA-1 hash
				$base64_encoded_sha1 = base64_encode(pack('H*', $sha1_hash));

				// Finish the upload
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://upload.box.com/api/2.0/files/upload_sessions/{$session_id}/commit");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer ' . $access_token,
					'Digest: sha=' . $base64_encoded_sha1, // Include the Base64 encoded SHA-1 hash
				));
				$response = curl_exec($ch);
				echo "step3".$response;
				die;
				if ($response === false) {
					echo 'Error: ' . curl_error($ch);
				} else {
					echo 'Video upload completed.';
				} */
			} else {
				echo 'Error creating upload session: ' . json_encode($session_info);
			}
		}
	}
	
}