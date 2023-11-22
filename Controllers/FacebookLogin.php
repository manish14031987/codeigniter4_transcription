<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Auth_model;
use Facebook\Facebook;
require_once APPPATH ."ThirdParty/facebook/vendor/autoload.php";
class FacebookLogin extends BaseController
{
	function __construct(){
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		
	}
    public function login()
    {
       $this->session = \Config\Services::session();
        $fb = new Facebook([
            'app_id' => '1990203758045194',
            'app_secret' => 'b54421479457003316129ef307161553',
            'default_graph_version' => 'v10.0',
        ]);

        // Generate Facebook login URL
        $helper = $fb->getRedirectLoginHelper();
       
		$permissions = ['email']; // Add any additional permissions you need
		$this->session->set('state', bin2hex(random_bytes(16)));
        //$loginUrl = $helper->getLoginUrl(base_url().'/callback', $permissions);
		$loginUrl = $fb->getRedirectLoginHelper()->getLoginUrl(base_url().'/callback',$permissions);
        return redirect()->to($loginUrl);
    }

    public function callback()
    {
		$session = \Config\Services::session();
		//pr(session('userdata'));
		$session->set('refer', end(explode('/', $_SERVER['HTTP_REFERER'])));
        $fb = new Facebook([
            'app_id' => '1990203758045194',
            'app_secret' => 'b54421479457003316129ef307161553',
            'default_graph_version' => 'v10.0',
        ]);

        $accessToken = $_POST['accessToken'];
		$userID = $_POST['userID'];

		try {
		  // Verify the access token with Facebook
		  $response = $fb->get('/me?fields=id,name,email', $accessToken);
		  $user = $response->getGraphUser();
			
		  // You can now use $user to access user data
		  $userId = $user->getID();
		  $userName = $user->getName();
		  
		  
		  
		  if($session->has('refer') && ($session->get('refer') == 'login'))
			{
				
				$user_role = 3;
				$user_status = 1;
			}
			 else
			 {
				$user_role = 2;
				$user_status = 0;
			 }
			$sendArray = array(
				'user_fullname' => $userName,
				'user_email' => $userId.'@gmail.com',
				'user_photo' => NULL,
				'user_social' => 'Facebook',
				'user_password' => '12345',
				'user_role' => $user_role,
				'user_status' => $user_status,
				'user_created' => date('Y-m-d H:i:s')
			);
			$userModel = new Auth_model();
			$output = $userModel->saveUpdateUserInfo_ajax($sendArray);
			//$session = \Config\Services::session();
			$session->remove('refer');
			if($session->has('return_url'))
			{
				//return redirect()->to($session->get('return_url'));
				echo json_encode(array('redirect' => $session->get('return_url')));
				exit;
			}
			else
			{
				//return redirect()->to(base_url());
				echo json_encode(array('redirect' => base_url()));
				exit;
			}
		
		



		  
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // Handle response exception
		  echo 'Graph returned an error: ' . $e->getMessage();
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // Handle SDK exception
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		}
    }
}
