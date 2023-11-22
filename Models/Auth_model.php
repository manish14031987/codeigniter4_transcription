<?php 
// app/Models/UserModel.php
namespace App\Models;

use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
use CodeIgniter\Email\Email;
class Auth_model extends Model
{
    function __construct(){
		
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	
	public function saveUpdateUserInfo($filter)
	{
		
		//prd($filter);
		//$this->session = \Config\Services::session();
		$email = $filter['user_email'];
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email'";
		$rs = $this->db->query($sql);
		//prd($rs->getResultArray());
		if(count($rs->getResultArray()) > 0)
		{
			$arrayRs = $rs->getResultArray();
			
			if($arrayRs[0]['user_role'] == 2 && $arrayRs[0]['user_status'] == 0)
			{
				$this->session ->setFlashdata('msg', 'Admin not approve your account yet.');
				header('Location: '.base_url('corporate-user-login'));
				exit;
			}
			if($this->session->has('refer') && ($this->session->get('refer') == 'login'))
			{
				
				if($arrayRs[0]['user_role'] == 2)
				{
					$this->session ->setFlashdata('msg', 'You are corporate user. Please login here.');
					header('Location: '.base_url('corporate-user-login'));
					exit;
				}
			}
			
	
			//prd($this->session->has('refer'));
			
			//Login it
			 $user_data = array( 'userdata' => array(
				'user_id' => $arrayRs[0]['user_id'],
				'user_fullname' => $arrayRs[0]['user_fullname'],
				'user_email' => $arrayRs[0]['user_email'],
				'user_role' => $arrayRs[0]['user_role'],
				'logged_in' => TRUE
				)
			 );
            $this->session->set($user_data);
			//return redirect()->to('place-order');
		}
		else
		{
			
			if($this->session->has('refer') && ($this->session->get('refer') == 'login'))
			{
				$builder = $this->db->table('ci_tbl_user');
				$builder->insert($filter);
				//prd($this->db->affectedRows())
				if($this->db->affectedRows() > 0)
				{
					
					$user_data = array( 'userdata' => array(
						'user_id' => $this->db->insertID(),
						'user_fullname' => $filter['user_fullname'],
						'user_email' => $filter['user_email'],
						'user_role' => $filter['user_role'],
						'logged_in' => TRUE
					)
				 );
				$this->session->set($user_data);
				}
			}
			else
			{
				
				$builder = $this->db->table('ci_tbl_user');
				$builder->insert($filter);
				$this->session->setFlashdata('msg', 'Register successfully. Once admin approve your account, You can logged in.');
				header('Location: '.base_url('login'));
				//return redirect()->to(base_url().'corporate-user-login');
				exit;
			}
				
				
				
		 
				
				//return redirect()->to(base_url());
				
			
		}
	}
	public function corporate_user_signup_ajax($filter)
	{
		$sendArray = array(
			'user_fullname' => trim($filter['user_fullname']),
			'user_photo' => 'NULL',
			'user_social' => 'NULL',
			'user_email' =>  trim($filter['user_email']),
			'user_password' =>  trim($filter['user_password']),
			'user_role' => trim($filter['user_role']),
			'user_created' => date('Y-m-d H:i:s'), 
			'user_pin' => uniqid(),
			'user_status' => 0
		);
		
		// Check email exists or not
		$email = trim($filter['user_email']);
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email'";
		$rs = $this->db->query($sql);
		
		if(count($rs->getResultArray()) > 0)
		{
			$result = $rs->getResultArray()[0];
			
			$status = $result['user_status'];
			if($status == 0)
			{
				$email = service('email');
        
				$email->setTo($result['user_email']);
				$email->setFrom('no-reply@tridentdispatch.com', WEB_TITLE);
				$email->setSubject('Verify Password');
				
				$link = base_url().'email_verify/'.$result['user_pin'].'';
				
				// Set the email message as HTML content
				$message = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><title>Email Confirmation</title><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">@media screen{}a,body,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic}a[x-apple-data-detectors]{font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;color:inherit!important;text-decoration:none!important}div[style*="margin: 16px 0;"]{margin:0!important}body{width:100%!important;height:100%!important;padding:0!important;margin:0!important}table{border-collapse:collapse!important}a{color:#1a82e2}img{height:auto;line-height:100%;text-decoration:none;border:0;outline:0}</style></head><body style="background-color:#e9ecef"><div class="preheader" style="display:none;max-width:0;max-height:0;overflow:hidden;font-size:1px;line-height:1px;color:#fff;opacity:0">Please click on verify link to activate your account.</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" valign="top" style="padding:36px 24px"><a href="'.base_url().'" target="_blank" style="display:inline-block"><img src="'.base_url().'assets/images/logo.png" alt="Logo" border="0" width="200" style="display:block;width:200px;max-width:200px;min-width:200px"></a></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:36px 24px 0;border-top:3px solid #d4dadf"><h1 style="margin:0;font-size:32px;font-weight:700;letter-spacing:-1px;line-height:48px">Confirm Your Email Address</h1></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">Tap the button below to confirm your email address.</p></td></tr><tr><td align="left" bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#ffffff" style="padding:12px"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center" bgcolor="#1a82e2" style="border-radius:6px"><a href="'.$link.'" target="_blank" style="display:inline-block;padding:16px 36px;font-size:16px;color:#fff;text-decoration:none;border-radius:6px">Confirm Email</a></td></tr></table></td></tr></table></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">If that doesn\'t work, copy and paste the following link in your browser:</p><p style="margin:0"><a href="'.$link.'" target="_blank">'.$link.'</a></p></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px;border-bottom:3px solid #d4dadf"><p style="margin:0">Thanks & Regards,<br>'.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:24px"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666"><p style="margin:0"></p></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666">&copy; '.date('Y').' '.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr></table></body></html>';
				$email->setMessage($message);
				$email->setMailType('html'); // Set the email type to HTML
				if ($email->send()) {
					echo json_encode(array('msg' => 'User already register with us, Please verify user email.', 'status'=> 'info'));
					exit;
				}
				else
				{
					echo 'Error sending welcome email.';
					exit;
				}
			}
			else
			{
				echo json_encode(array('msg' => 'User already register with us, Please login.', 'status'=> 'info'));
				exit;
			}
		}
		else
		{
			//Inser then mail
			$builder = $this->db->table('ci_tbl_user');
			$builder->insert($sendArray);
			//prd($this->db->affectedRows())
			if($this->db->affectedRows() > 0)
			{
				//pr($sendArray);
				$email = service('email');
        
				$email->setTo($sendArray['user_email']);
				$email->setFrom('no-reply@tridentdispatch.com', WEB_TITLE);
				$email->setSubject('Verify Password');
				
				$link = base_url().'email_verify/'.$sendArray['user_pin'].'';
				
				// Set the email message as HTML content
				
				$message = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><title>Email Confirmation</title><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">@media screen{}a,body,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic}a[x-apple-data-detectors]{font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;color:inherit!important;text-decoration:none!important}div[style*="margin: 16px 0;"]{margin:0!important}body{width:100%!important;height:100%!important;padding:0!important;margin:0!important}table{border-collapse:collapse!important}a{color:#1a82e2}img{height:auto;line-height:100%;text-decoration:none;border:0;outline:0}</style></head><body style="background-color:#e9ecef"><div class="preheader" style="display:none;max-width:0;max-height:0;overflow:hidden;font-size:1px;line-height:1px;color:#fff;opacity:0">Please click on verify link to activate your account.</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" valign="top" style="padding:36px 24px"><a href="'.base_url().'" target="_blank" style="display:inline-block"><img src="'.base_url().'assets/images/logo.png" alt="Logo" border="0" width="200" style="display:block;width:200px;max-width:200px;min-width:200px"></a></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:36px 24px 0;border-top:3px solid #d4dadf"><h1 style="margin:0;font-size:32px;font-weight:700;letter-spacing:-1px;line-height:48px">Confirm Your Email Address</h1></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">Tap the button below to confirm your email address.</p></td></tr><tr><td align="left" bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#ffffff" style="padding:12px"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center" bgcolor="#1a82e2" style="border-radius:6px"><a href="'.$link.'" target="_blank" style="display:inline-block;padding:16px 36px;font-size:16px;color:#fff;text-decoration:none;border-radius:6px">Confirm Email</a></td></tr></table></td></tr></table></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">If that doesn\'t work, copy and paste the following link in your browser:</p><p style="margin:0"><a href="'.$link.'" target="_blank">'.$link.'</a></p></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px;border-bottom:3px solid #d4dadf"><p style="margin:0">Thanks & Regards,<br>'.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:24px"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666"><p style="margin:0"></p></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666">&copy; '.date('Y').' '.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr></table></body></html>';
				$email->setMessage($message);
				$email->setMailType('html'); // Set the email type to HTML
				echo json_encode(array('msg' => 'User register successfully. Please verify your email.', 'status'=> 'success'));
				exit;
			}
			else
			{
				echo json_encode(array('msg' => 'Something went wrong.', 'status'=> 'error'));
				exit;
			}
		}
	}
	
	public function signup_ajax($filter)
	{
		$sendArray = array(
			'user_fullname' => trim($filter['user_fullname']),
			'user_photo' => 'NULL',
			'user_social' => 'NULL',
			'user_email' =>  trim($filter['user_email']),
			'user_password' =>  trim($filter['user_password']),
			'user_role' => trim($filter['user_role']),
			'user_created' => date('Y-m-d H:i:s'), 
			'user_pin' => uniqid(),
			'user_status' => 0
		);
		
		// Check email exists or not
		$email = trim($filter['user_email']);
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email'";
		$rs = $this->db->query($sql);
		
		if(count($rs->getResultArray()) > 0)
		{
			$result = $rs->getResultArray()[0];
			
			$status = $result['user_status'];
			if($status == 0)
			{
				$email = service('email');
        
				$email->setTo($result['user_email']);
				$email->setFrom('no-reply@tridentdispatch.com', WEB_TITLE);
				$email->setSubject('Verify Password');
				
				$link = base_url().'email_verify/'.$result['user_pin'].'';
				
				// Set the email message as HTML content
				$message = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><title>Email Confirmation</title><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">@media screen{}a,body,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic}a[x-apple-data-detectors]{font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;color:inherit!important;text-decoration:none!important}div[style*="margin: 16px 0;"]{margin:0!important}body{width:100%!important;height:100%!important;padding:0!important;margin:0!important}table{border-collapse:collapse!important}a{color:#1a82e2}img{height:auto;line-height:100%;text-decoration:none;border:0;outline:0}</style></head><body style="background-color:#e9ecef"><div class="preheader" style="display:none;max-width:0;max-height:0;overflow:hidden;font-size:1px;line-height:1px;color:#fff;opacity:0">Please click on verify link to activate your account.</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" valign="top" style="padding:36px 24px"><a href="'.base_url().'" target="_blank" style="display:inline-block"><img src="'.base_url().'assets/images/logo.png" alt="Logo" border="0" width="200" style="display:block;width:200px;max-width:200px;min-width:200px"></a></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:36px 24px 0;border-top:3px solid #d4dadf"><h1 style="margin:0;font-size:32px;font-weight:700;letter-spacing:-1px;line-height:48px">Confirm Your Email Address</h1></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">Tap the button below to confirm your email address.</p></td></tr><tr><td align="left" bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#ffffff" style="padding:12px"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center" bgcolor="#1a82e2" style="border-radius:6px"><a href="'.$link.'" target="_blank" style="display:inline-block;padding:16px 36px;font-size:16px;color:#fff;text-decoration:none;border-radius:6px">Confirm Email</a></td></tr></table></td></tr></table></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">If that doesn\'t work, copy and paste the following link in your browser:</p><p style="margin:0"><a href="'.$link.'" target="_blank">'.$link.'</a></p></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px;border-bottom:3px solid #d4dadf"><p style="margin:0">Thanks & Regards,<br>'.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:24px"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666"><p style="margin:0"></p></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666">&copy; '.date('Y').' '.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr></table></body></html>';
				$email->setMessage($message);
				$email->setMailType('html'); // Set the email type to HTML
				if ($email->send()) {
					echo json_encode(array('msg' => 'User already register with us, Please verify user email.', 'status'=> 'info'));
					exit;
				}
				else
				{
					echo 'Error sending welcome email.';
					exit;
				}
			}
			else
			{
				echo json_encode(array('msg' => 'User already register with us, Please login.', 'status'=> 'info'));
				exit;
			}
		}
		else
		{
			//Inser then mail
			$builder = $this->db->table('ci_tbl_user');
			$builder->insert($sendArray);
			//prd($this->db->affectedRows())
			if($this->db->affectedRows() > 0)
			{
				//pr($sendArray);
				$email = service('email');
        
				$email->setTo($sendArray['user_email']);
				$email->setFrom('no-reply@tridentdispatch.com', WEB_TITLE);
				$email->setSubject('Verify Password');
				
				$link = base_url().'email_verify/'.$sendArray['user_pin'].'';
				
				// Set the email message as HTML content
				
				$message = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><title>Email Confirmation</title><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">@media screen{}a,body,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic}a[x-apple-data-detectors]{font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;color:inherit!important;text-decoration:none!important}div[style*="margin: 16px 0;"]{margin:0!important}body{width:100%!important;height:100%!important;padding:0!important;margin:0!important}table{border-collapse:collapse!important}a{color:#1a82e2}img{height:auto;line-height:100%;text-decoration:none;border:0;outline:0}</style></head><body style="background-color:#e9ecef"><div class="preheader" style="display:none;max-width:0;max-height:0;overflow:hidden;font-size:1px;line-height:1px;color:#fff;opacity:0">Please click on verify link to activate your account.</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" valign="top" style="padding:36px 24px"><a href="'.base_url().'" target="_blank" style="display:inline-block"><img src="'.base_url().'assets/images/logo.png" alt="Logo" border="0" width="200" style="display:block;width:200px;max-width:200px;min-width:200px"></a></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:36px 24px 0;border-top:3px solid #d4dadf"><h1 style="margin:0;font-size:32px;font-weight:700;letter-spacing:-1px;line-height:48px">Confirm Your Email Address</h1></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">Tap the button below to confirm your email address.</p></td></tr><tr><td align="left" bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#ffffff" style="padding:12px"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center" bgcolor="#1a82e2" style="border-radius:6px"><a href="'.$link.'" target="_blank" style="display:inline-block;padding:16px 36px;font-size:16px;color:#fff;text-decoration:none;border-radius:6px">Confirm Email</a></td></tr></table></td></tr></table></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">If that doesn\'t work, copy and paste the following link in your browser:</p><p style="margin:0"><a href="'.$link.'" target="_blank">'.$link.'</a></p></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px;border-bottom:3px solid #d4dadf"><p style="margin:0">Thanks & Regards,<br>'.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:24px"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666"><p style="margin:0"></p></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666">&copy; '.date('Y').' '.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr></table></body></html>';
				$email->setMessage($message);
				$email->setMailType('html'); // Set the email type to HTML
				echo json_encode(array('msg' => 'User register successfully. Please verify your email.', 'status'=> 'success'));
				exit;
			}
			else
			{
				echo json_encode(array('msg' => 'Something went wrong.', 'status'=> 'error'));
				exit;
			}
		}
	}
	
	public function email_verify($user_pin)
	{
		$sql = "UPDATE ci_tbl_user SET user_status = 1 WHERE user_pin = '$user_pin'";
		$rs = $this->db->query($sql);
		
		if($this->db->affectedRows() > 0) 
		{
			echo '<p>Email verification successfully</p><br/>
			redirecting....
			<script>
				
				  setTimeout(function() {
					window.location.replace("'.base_url().'login");
				  }, 2000);
				
				
			</script>
			';
			exit;
		}
		else
		{
			return redirect()->to(base_url().'login');
		}
	}
	
	public function ci_login_ajax($filter)
	{

		// Check email exists or not
		$email = trim($filter['user_email']);
		$password = trim($filter['user_password']);
		$role = trim($filter['user_role']);
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email' AND user_password = '$password'";
		$rs = $this->db->query($sql);
		
		if(count($rs->getResultArray()) > 0)
		{
			$result = $rs->getResultArray()[0];
			//pr($result);
			if($result['user_role'] != $role)
			{
				echo json_encode(array('msg' => 'You are not allowed to login this page.', 'status'=> 'error'));
				exit;
			}
			
			$user_data = array( 'userdata' => array(
					'user_id' => $result['user_id'],
					'user_fullname' => $result['user_fullname'],
					'user_email' => $result['user_email'],
					'user_role' => $result['user_role'],
					'logged_in' => TRUE
					)
				);
			$this->session->set($user_data);
			echo json_encode(array('msg' => 'Loggedin success. Redirecting....', 'status'=> 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Invalid email or password.', 'status'=> 'error'));
			exit;
		}
	}
	
	public function ci_corporate_user_login_ajax($filter)
	{

		// Check email exists or not
		$email = trim($filter['user_email']);
		$password = trim($filter['user_password']);
		$role = trim($filter['user_role']);
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email' AND user_password = '$password'";
		$rs = $this->db->query($sql);
		
		if(count($rs->getResultArray()) > 0)
		{
			$result = $rs->getResultArray()[0];
			//pr($result);
			if($result['user_role'] != $role)
			{
				echo json_encode(array('msg' => 'You are not allowed to login this page.', 'status'=> 'error'));
				exit;
			}
			
			if($result['user_status'] != 1)
			{
				echo json_encode(array('msg' => 'Please wait. Admin not approve your account yet.', 'status'=> 'error'));
				exit;
			}
			
			$user_data = array( 'userdata' => array(
					'user_id' => $result['user_id'],
					'user_fullname' => $result['user_fullname'],
					'user_email' => $result['user_email'],
					'user_role' => $result['user_role'],
					'logged_in' => TRUE
					)
				);
			$this->session->set($user_data);
			echo json_encode(array('msg' => 'Loggedin success. Redirecting....', 'status'=> 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Invalid email or password.', 'status'=> 'error'));
			exit;
		}
	}
	
	
	public function ci_forgot_ajax($filter)
	{

		// Check email exists or not
		$email = trim($filter['user_email']);
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email'";
		$rs = $this->db->query($sql);
		
		if(count($rs->getResultArray()) > 0)
		{	
			$result = $rs->getResultArray()[0];
			if($result['user_status'] == 0)
			{
				echo json_encode(array('msg' => 'Admin your account not approve yet.', 'status'=> 'error'));
				exit;
			}
			
			$emailID = $result['user_email'];
			$link = base_url().'password_generate/'.$result['user_pin'].'';
			
			$to = $emailID;
			$subject = "New Password";
			$message = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><title>Email Confirmation</title><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">@media screen{}a,body,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic}a[x-apple-data-detectors]{font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;color:inherit!important;text-decoration:none!important}div[style*="margin: 16px 0;"]{margin:0!important}body{width:100%!important;height:100%!important;padding:0!important;margin:0!important}table{border-collapse:collapse!important}a{color:#1a82e2}img{height:auto;line-height:100%;text-decoration:none;border:0;outline:0}</style></head><body style="background-color:#e9ecef"><div class="preheader" style="display:none;max-width:0;max-height:0;overflow:hidden;font-size:1px;line-height:1px;color:#fff;opacity:0">Please click on verify link to activate your account.</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" valign="top" style="padding:36px 24px"><a href="'.base_url().'" target="_blank" style="display:inline-block"><img src="'.base_url().'assets/images/logo.png" alt="Logo" border="0" width="200" style="display:block;width:200px;max-width:200px;min-width:200px"></a></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:36px 24px 0;border-top:3px solid #d4dadf"><h1 style="margin:0;font-size:32px;font-weight:700;letter-spacing:-1px;line-height:48px">Forgot Password?</h1></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">Tap the button below to create new password.</p></td></tr><tr><td align="left" bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#ffffff" style="padding:12px"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center" bgcolor="#1a82e2" style="border-radius:6px"><a href="'.$link.'" target="_blank" style="display:inline-block;padding:16px 36px;font-size:16px;color:#fff;text-decoration:none;border-radius:6px">Create new password</a></td></tr></table></td></tr></table></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">If that doesn\'t work, copy and paste the following link in your browser:</p><p style="margin:0"><a href="'.$link.'" target="_blank">'.$link.'</a></p></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px;border-bottom:3px solid #d4dadf"><p style="margin:0">Thanks & Regards,<br>'.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:24px"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666"><p style="margin:0"></p></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666">&copy; '.date('Y').' '.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr></table></body></html>';
			//prd($message);
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers
			$headers .= 'From: '.WEB_TITLE.' <no-reply@tridentdispatch.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";
			
			/*
			$email = service('email');
			$email->setTo($emailID);
			$email->setFrom('no-reply@tridentdispatch.com', WEB_TITLE);
			$email->setSubject('New Password');
			
			$link = base_url().'password_generate/'.$result['user_pin'].'';
			
			// Set the email message as HTML content
			$message = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><title>Email Confirmation</title><meta name="viewport" content="width=device-width,initial-scale=1"><style type="text/css">@media screen{}a,body,table,td{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table,td{mso-table-rspace:0;mso-table-lspace:0}img{-ms-interpolation-mode:bicubic}a[x-apple-data-detectors]{font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;color:inherit!important;text-decoration:none!important}div[style*="margin: 16px 0;"]{margin:0!important}body{width:100%!important;height:100%!important;padding:0!important;margin:0!important}table{border-collapse:collapse!important}a{color:#1a82e2}img{height:auto;line-height:100%;text-decoration:none;border:0;outline:0}</style></head><body style="background-color:#e9ecef"><div class="preheader" style="display:none;max-width:0;max-height:0;overflow:hidden;font-size:1px;line-height:1px;color:#fff;opacity:0">Please click on verify link to activate your account.</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" valign="top" style="padding:36px 24px"><a href="'.base_url().'" target="_blank" style="display:inline-block"><img src="'.base_url().'assets/images/logo.png" alt="Logo" border="0" width="200" style="display:block;width:200px;max-width:200px;min-width:200px"></a></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:36px 24px 0;border-top:3px solid #d4dadf"><h1 style="margin:0;font-size:32px;font-weight:700;letter-spacing:-1px;line-height:48px">Forgot Password?</h1></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">Tap the button below to create new password.</p></td></tr><tr><td align="left" bgcolor="#ffffff"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" bgcolor="#ffffff" style="padding:12px"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="center" bgcolor="#1a82e2" style="border-radius:6px"><a href="'.$link.'" target="_blank" style="display:inline-block;padding:16px 36px;font-size:16px;color:#fff;text-decoration:none;border-radius:6px">Create new password</a></td></tr></table></td></tr></table></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px"><p style="margin:0">If that doesn\'t work, copy and paste the following link in your browser:</p><p style="margin:0"><a href="'.$link.'" target="_blank">'.$link.'</a></p></td></tr><tr><td align="left" bgcolor="#ffffff" style="padding:24px;font-size:16px;line-height:24px;border-bottom:3px solid #d4dadf"><p style="margin:0">Thanks & Regards,<br>'.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:24px"><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tr><td align="center" valign="top" width="600"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px"><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666"><p style="margin:0"></p></td></tr><tr><td align="center" bgcolor="#e9ecef" style="padding:12px 24px;font-size:14px;line-height:20px;color:#666">&copy; '.date('Y').' '.WEB_TITLE.'</p></td></tr></table><!--[if (gte mso 9)|(IE)]><![endif]--></td></tr></table></body></html>';
			//prd($message);
			$email->setMessage($message);
			$email->setMailType('html'); // Set the email type to HTML
			if ($email->send()) {
			*/
			if (mail($to,$subject,$message,$headers)) {
				echo json_encode(array('msg' => 'An email sent to your email id, Please visit and reset your password.', 'status'=> 'success'));
				exit;
			}
			else
			{
				echo json_encode(array('msg' => 'Something went wrong. Please try again later.', 'status'=> 'error'));
				exit;
			}
			
		}
		else
		{
			echo json_encode(array('msg' => 'Invalid email.', 'status'=> 'error'));
			exit;
		}
	}
	
	
	public function password_generate($userpin)
	{
		$sql = "SELECT * FROM ci_tbl_user WHERE user_pin = '$userpin'";
		$rs = $this->db->query($sql);
		return ($rs->getResultArray());
		
	}
	
	public function new_pass_data($filter)
	{
		$password = $filter['user_password'];
		$userid = $filter['user_id'];
		$sql = "UPDATE ci_tbl_user SET user_password = '$password' WHERE user_id = $userid";
		$rs = $this->db->query($sql);
		
		return ($this->db->affectedRows() > 0)?true:false;
		
	}
	
	
	public function saveUpdateUserInfo_ajax($filter)
	{
		
		//prd($filter);
		//$this->session = \Config\Services::session();
		$email = $filter['user_email'];
		$sql = "SELECT * FROM ci_tbl_user WHERE user_email = '$email'";
		$rs = $this->db->query($sql);
		//prd($rs->getResultArray());
		if(count($rs->getResultArray()) > 0)
		{
			$arrayRs = $rs->getResultArray();
			
			if($arrayRs[0]['user_role'] == 2 && $arrayRs[0]['user_status'] == 0)
			{
				$this->session ->setFlashdata('msg', 'Admin not approve your account yet.');
				
				echo json_encode(array('redirect' => base_url('corporate-user-login')));
				exit;
			}
			if($this->session->has('refer') && ($this->session->get('refer') == 'login'))
			{
				
				if($arrayRs[0]['user_role'] == 2)
				{
					$this->session ->setFlashdata('msg', 'You are corporate user. Please login here.');
					echo json_encode(array('redirect' => base_url('corporate-user-login')));
					exit;
				}
			}
			
	
			//prd($this->session->has('refer'));
			
			//Login it
			 $user_data = array( 'userdata' => array(
				'user_id' => $arrayRs[0]['user_id'],
				'user_fullname' => $arrayRs[0]['user_fullname'],
				'user_email' => $arrayRs[0]['user_email'],
				'user_role' => $arrayRs[0]['user_role'],
				'logged_in' => TRUE
				)
			 );
            $this->session->set($user_data);
			//return redirect()->to('place-order');
		}
		else
		{
			
			if($this->session->has('refer') && ($this->session->get('refer') == 'login'))
			{
				$builder = $this->db->table('ci_tbl_user');
				$builder->insert($filter);
				//prd($this->db->affectedRows())
				if($this->db->affectedRows() > 0)
				{
					
					$user_data = array( 'userdata' => array(
						'user_id' => $this->db->insertID(),
						'user_fullname' => $filter['user_fullname'],
						'user_email' => $filter['user_email'],
						'user_role' => $filter['user_role'],
						'logged_in' => TRUE
					)
				 );
				$this->session->set($user_data);
				}
			}
			else
			{
				
				$builder = $this->db->table('ci_tbl_user');
				$builder->insert($filter);
				$this->session->setFlashdata('msg', 'Register successfully. Once admin approve your account, You can logged in.');
				echo json_encode(array('redirect' => base_url('login')));
				exit;
			}
				
				
				
		 
				
				//return redirect()->to(base_url());
				
			
		}
	}
	
}	
?>