<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Facebook as FacebookConfig;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;

class FacebookAuth extends Controller
{
    public function login()
    {
		require_once APPPATH ."ThirdParty/facebook/vendor/autoload.php";
        $facebookConfig = new FacebookConfig();
        $fb = new Facebook([
            'app_id' => $facebookConfig->appID,
            'app_secret' => $facebookConfig->appSecret,
            'default_graph_version' => 'v12.0',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // Define the permissions you need

        $loginUrl = $helper->getLoginUrl(site_url('facebookauth/callback'), $permissions);
        return redirect()->to($loginUrl);
    }

    public function callback()
    {
        $facebookConfig = new FacebookConfig();
        $fb = new Facebook([
            'app_id' => $facebookConfig->appID,
            'app_secret' => $facebookConfig->appSecret,
            'default_graph_version' => 'v12.0',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookSDKException $e) {
            // Handle SDK errors
            return redirect()->to('login/error');
        }

        if (!isset($accessToken)) {
            return redirect()->to('login/error');
        }

        $response = $fb->get('/me?fields=id,name,email', $accessToken);
        $user = $response->getGraphUser();

        // Check if the user already exists in your database based on their Facebook email
        // Example: $existingUser = $this->userModel->findUserByEmail($user['email']);

        if ($existingUser) {
            // Log in the existing user
            // Example: $this->userModel->login($existingUser);
        } else {
            // Create a new user account
            // Example: $this->userModel->createUserFromFacebook($user);
        }
 return redirect()->to('dashboard');
    }
}