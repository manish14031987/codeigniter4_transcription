<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Auth_model;
use Config\Facebook as FacebookConfig;
use Facebook\FacebookRedirectLoginHelper; 
class Auth extends BaseController
{
	
	function __construct(){
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		
	}
	
    public function login_index()
    {
		$session = \Config\Services::session();
		//pr(session('userdata'));
		if(empty(session('userdata')))
		{
			$data = [];
			$data['session'] = $session;
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			echo view('login', $data);
		}
		else{
			return redirect()->to(base_url());
		}
		
		
    }
	
	 public function signup_index()
    {
		$session = \Config\Services::session();
		//pr(session('userdata'));
		if(empty(session('userdata')))
		{
			$data = [];
			$data['session'] = $session;
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			echo view('signup', $data);
		}
		else{
			return redirect()->to(base_url());
		}
		
		
    }
	
	 public function corporate_user_login_index()
    {
		$session = \Config\Services::session();
		//pr(session('userdata'));
		if(empty(session('userdata')))
		{
			$data = [];
			$data['session'] = $session;
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			echo view('corporate-user-login', $data);
		}
		else{
			return redirect()->to(base_url());
		}
		
		
    }
	
	 public function corporate_user_signup_index()
    {
		$session = \Config\Services::session();
		//pr(session('userdata'));
		if(empty(session('userdata')))
		{
			$data = [];
			$data['session'] = $session;
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			echo view('corporate-user-signup', $data);
		}
		else{
			return redirect()->to(base_url());
		}
		
		
    }
	
	
	
	public function forgot_password_index()
    {
		$session = \Config\Services::session();
		//pr(session('userdata'));
		if(empty(session('userdata')))
		{
			$data = [];
			$data['session'] = $session;
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			echo view('forgot-password', $data);
		}
		else{
			return redirect()->to(base_url());
		}
		
		
    }
	
	public function google_login() {
		//prd($_SERVER);
		$session = \Config\Services::session();
		//pr(session('userdata'));
		$session->set('refer', end(explode('/', $_SERVER['HTTP_REFERER'])));
		
		
		require_once APPPATH ."ThirdParty/google/vendor/autoload.php";
		//echo 1; die;
		
	    $clientId = '39217135495-91meff5n9co177qnmviri6ukrh0ip14g.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUrl = base_url('Auth/google_callback');
		
	
        $client = new \Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        $client->addScope("email");
        $client->addScope("profile");
        
        // Generate the Google login URL
        $authUrl = $client->createAuthUrl();
        
        return redirect()->to($authUrl);
    }
    
    public function google_callback() {
		
		$session = \Config\Services::session();
		
	
		require_once APPPATH ."ThirdParty/google/vendor/autoload.php";
        $client = new \Google_Client();
		
		$clientId = '39217135495-91meff5n9co177qnmviri6ukrh0ip14g.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUrl = base_url('Auth/google_callback');
		
		
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUrl);
        
        // Get the authorization code from the query parameters
        $code = $_GET['code'];
        
        // Exchange the authorization code for an access token
        $token = $client->fetchAccessTokenWithAuthCode($code);
		//prd($token);  
		
		
		$accessToken = $token['access_token'];
		
		$q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$accessToken.''; 
		//$json = file_get_contents($q);
		
		
		// Initialize cURL session
		$ch = curl_init();

		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $q); // Replace with the URL you want to request
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

		// Execute the cURL session and store the result in $response
		$response = curl_exec($ch);

		// Check for cURL errors
		if (curl_errno($ch)) {
			echo 'cURL Error: ' . curl_error($ch);
		}

		// Close the cURL session
		curl_close($ch);

		// Output the response
		
		

		
		
		$userInfoArray = json_decode($response,true);
		//prd($userInfoArray);
		//return redirect()->to(base_url());
		
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
			'user_fullname' => $userInfoArray['name'],
			'user_email' => $userInfoArray['email'],
			'user_photo' => $userInfoArray['picture'],
			'user_social' => 'Google',
			'user_password' => '12345',
			'user_role' => $user_role,
			'user_status' => $user_status,
			'user_created' => date('Y-m-d H:i:s')
		);
		$userModel = new Auth_model();
        $output = $userModel->saveUpdateUserInfo($sendArray);
		//$session = \Config\Services::session();
		$session->remove('refer');
		if($session->has('return_url'))
		{
			return redirect()->to($session->get('return_url'));
		}
	    else
		{
			return redirect()->to(base_url());
		}
		
		
        // Use $token to access user's Google data
        // Implement your logic here
    }
	
	
	
	
	public function logout()
	{
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to(base_url());
	}
	
	public function signup_ajax()
	{
		$userModel = new Auth_model();
        $output = $userModel->signup_ajax(rq());
	}
	public function corporate_user_signup_ajax()
	{
		$userModel = new Auth_model();
        $output = $userModel->corporate_user_signup_ajax(rq());
	}
	
	
	public function email_verify($user_pin)
	{
		$userModel = new Auth_model();
        $userModel->email_verify($user_pin);
	}
	
	public function ci_login_ajax()
	{
		$userModel = new Auth_model();
        $output = $userModel->ci_login_ajax(rq());
	}
	
	public function ci_corporate_user_login_ajax()
	{
		$userModel = new Auth_model();
        $output = $userModel->ci_corporate_user_login_ajax(rq());
	}
	
	public function ci_forgot_ajax()
	{
		$userModel = new Auth_model();
        $output = $userModel->ci_forgot_ajax(rq());
	}
	
	public function password_generate($userpin)
	{
		
		
		$session = \Config\Services::session();
		//pr(session('userdata'));
		if(empty(session('userdata')))
		{
			$userModel = new Auth_model();
			$output  = $userModel->password_generate($userpin);
			$data = [];
			$data['userdata'] = $output;
			$data['session'] = $session;
			$data['title'] 		= 'Page Title';
			$data['heading']	= 'Welcome to infovistar.com';
			echo view('new-password', $data);
		}
		else{
			return redirect()->to(base_url());
		}
	}
	
	public function new_pass_data()
	{
		$userModel = new Auth_model();
        $output = $userModel->new_pass_data(rq());
		if($output)
		{
			echo json_encode(array('msg' => 'Password generate successfully.', 'status' => 'success'));
			exit;
		}
		else
		{
			echo json_encode(array('msg' => 'Something went wrong.', 'status' => 'error'));
			exit;
		}
	}
	

}
