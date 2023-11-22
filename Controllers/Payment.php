<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\Payment_model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
require_once APPPATH . 'ThirdParty/paypal/vendor/autoload.php';
use Omnipay\Omnipay;
class Payment extends BaseController
{
	public function __construct()
    {
       $this->request  = \Config\Services::request();
    } 
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function payment_view($order_id)
	{
		if($order_id)
		{
				$session = \Config\Services::session();
				
				$order_id = decryptMyData($order_id);
				
		
		$session = \Config\Services::session();
		$data['order_info'] = $this->order_info($order_id);
		$data['order_id'] = $order_id;
		$data['session'] = $session;
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'payment';	// page name
		return view('includes/template', $data);
		
		}
		else
		{
			redirect(base_url());
		}
		
	}
	
	public function payment_success_corporate_user_view($order_id)
	{
		$data['order_info'] = $this->order_info(decryptMyData($order_id));
		$data['order_id'] = decryptMyData($order_id);
		$session = \Config\Services::session();
		
		$session->remove('file_data');
		
		$data['session'] = $session;
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'payment_success_corporate_user';	// page name
		return view('includes/template', $data);
		
	}
	
	public function order_info($order_id)
	{
		$paymentModel = new Payment_model();
		return $paymentModel->order_info($order_id);
	}
	
	public function payment_data()
	{
		$request = rq();
		define('CLIENT_ID', 'AVwW_Xvg1FmM9sT4vPBoIxAXy7JNnIKMvhskK8B51u1z0lryGFdjTCoAUrkeBHHzO3_LBKZdK8spbBJe');
		define('CLIENT_SECRET', 'EGEgEtjsRN-JmqXj44Yc7U8n3u8LWNcGoJ_rwMX1mdUHYJeEuXtOCRhR7gqAQCfLDAbZkgsd5Avq_Aj6');
		define('PAYPAL_RETURN_URL', base_url().'paypal/success/'.$request['order_id'].'');
		define('PAYPAL_CANCEL_URL', base_url().'paypal/cancel/'.$request['order_id'].'');
		define('PAYPAL_CURRENCY', 'USD'); // set your currency here

		
		$price = decryptMyData($request['final_price']);
		$order_id = decryptMyData($request['order_id']);
		
		$gateway = Omnipay::create('PayPal_Rest');
		$gateway->setClientId(CLIENT_ID);
		$gateway->setSecret(CLIENT_SECRET);
		$gateway->setTestMode(true); //set it to 'false' when go live

		try {
			$response = $gateway->purchase(array(
				'amount' => $price,
				'currency' => PAYPAL_CURRENCY,
				'returnUrl' => PAYPAL_RETURN_URL,
				'cancelUrl' => PAYPAL_CANCEL_URL,
			))->send();

			if ($response->isRedirect()) {
				$response->redirect(); // this will automatically forward the customer
			} else {
				// not successful
				echo $response->getMessage();
			}
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function payment_success_view($order_id)
	{
		$data['order_info'] = $this->order_info(decryptMyData($order_id));
		$data['order_id'] = decryptMyData($order_id);
		$session = \Config\Services::session();
		$session->remove('file_data');
		$data['session'] = $session;
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'payment_success';	// page name
		return view('includes/template', $data);
	}
	
	public function payment_cancel_view($order_id)
	{
		$data['order_info'] = $this->order_info(decryptMyData($order_id));
		$data['order_id'] = decryptMyData($order_id);
		$session = \Config\Services::session();
		$data['session'] = $session;
		$data['title'] 		= 'Page Title';
		$data['heading']	= 'Welcome to infovistar.com';
		$data['main_content']	= 'payment_cancel';	// page name
		return view('includes/template', $data);
	}
	
	public function updateTranscation()
	{
		$paymentModel = new Payment_model();
		$output = $paymentModel->updateTranscation(rq());
		
	

	}
	
}