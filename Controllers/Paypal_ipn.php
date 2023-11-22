<?php 
// application/controllers/Paypal_ipn.php

class Paypal_ipn extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load necessary libraries and models here
    }

    public function ipn_listener() {
        // Retrieve the IPN data from PayPal
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();

        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Verify the IPN data with PayPal
        $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // Change to 'https://www.paypal.com/cgi-bin/webscr' for live transactions
        $ch = curl_init($paypal_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'cmd=_notify-validate&' . http_build_query($myPost));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.sandbox.paypal.com')); // Change to 'www.paypal.com' for live transactions

        $result = curl_exec($ch);
		mail("deepansuvyas@gmail.com","My subject",$result);
        curl_close($ch);
		/*
        if ($result == 'VERIFIED') {
            // IPN data is valid; process the transaction and save it to the database
            $transaction_id = $this->input->post('txn_id');
            $payer_email = $this->input->post('payer_email');
            $amount = $this->input->post('mc_gross');
            
            $paymentModel = new Payment_model();
            $paymentModel->updateTranscation($transaction_id, $payer_email, $amount);
        } else {
            // IPN data is invalid; log or handle the error
        }
		*/
		
    }
}