<?php 
// app/Models/UserModel.php
namespace App\Models;
use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
use CodeIgniter\Email\Email;
class Payment_model extends Model
{
    function __construct(){
		
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	
	public function order_info($orderid)
	{
		$sql = "SELECT ti.order_id, ti.item_duration as duration, ti.item_id, ti.item_name, ti.item_file, tl.lang_name as language, tf.cttf_name as text_format,
		tat.ctt_name as turn_around_time, ts.cts_name as speaker, tlq.ctlq_name as quality, tts.cttt_name as timestamping, ti.item_amount as price
		FROM ci_tbl_items as ti
		INNER JOIN ci_tbl_language as tl ON tl.lang_id = ti.item_language
		INNER JOIN ci_tbl_txt_format as tf ON tf.cttf_id = ti.item_text_format
		INNER JOIN ci_tbl_tat as tat ON tat.ctt_id = ti.item_tat
		INNER JOIN ci_tbl_speakers as ts ON ts.cts_id = ti.item_speakers
		INNER JOIN ci_tbl_low_quality as tlq ON tlq.ctlq_id = ti.item_low_quality
		INNER JOIN ci_tbl_timestamp as tts ON tts.cttt_id = ti.item_timestamping
		WHERE ti.order_id = $orderid";
		$resArr = $this->db->query($sql);
		return $resArr->getResultArray();
	}
	
	public function updateTranscation()
	{
		$request = rq();
		$order_id = $request['order_id'];
		$paymentId = $request['paymentId'];
		$token = $request['token'];
		$payerID = $request['PayerID'];
		$amount = $request['amount'];
		$status = ($request['page'] == 'success')?1:0;
		$date = date('Y-m-d H:i:s');
		
		
		
		$updateOrderIDinItems = "UPDATE ci_tbl_transcation SET payerid = '$payerID', paymentId = '$payerID', token = '$payerID', amount = '$amount', status = '$status', created = '$date' WHERE order_id = $order_id";
		$this->db->query($updateOrderIDinItems);
		return ($this->db->affectedRows() > 0)?true:false;
	}
}