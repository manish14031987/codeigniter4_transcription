<?php 
// app/Models/UserModel.php
namespace App\Models;

use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
use CodeIgniter\Email\Email;
class Order_model extends Model
{
    function __construct(){
		
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	
	public function get_langugae()
	{
		$sql = "SELECT * FROM ci_tbl_language WHERE lang_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	
	public function get_langugae_tat()
	{
		$sql = "SELECT * FROM ci_tbl_lang WHERE lang_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	public function get_quality()
	{
		$sql = "SELECT * FROM ci_tbl_low_quality WHERE ctlq_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	public function get_speakers()
	{
		$sql = "SELECT * FROM ci_tbl_speakers WHERE cts_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	public function get_tat()
	{
		$sql = "SELECT * FROM ci_tbl_tat WHERE ctt_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	public function get_timestamp()
	{
		$sql = "SELECT * FROM ci_tbl_timestamp WHERE cttt_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	public function get_txt_format()
	{
		$sql = "SELECT * FROM ci_tbl_txt_format WHERE cttf_status = 1";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	
	public function update_tat($filter)
	{
		$lngid = $filter['lang'];
		$sql = "SELECT lng.*, t.ctt_name FROM ci_tbl_lang as lng 
		INNER JOIN ci_tbl_tat as t ON t.ctt_id = lng.lang_tat
		WHERE lng.lang_name = $lngid";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	
	
	
	
	public function calculatePrice($filter)
	{
		$seconds = $filter['seconds'];
		$lang = @$filter['lang'];
		$tat = @$filter['tat'];
		$tat = ($tat == '')?0:$tat;
		$text_format = $filter['text_format'];
		$speakers = $filter['speakers'];
		$quality = $filter['quality'];
		$timestamping = $filter['timestamping'];
		
		
		
		$sql = "
		SELECT lang_price as price from ci_tbl_lang WHERE lang_name = $lang AND lang_tat = $tat
		UNION ALL
		SELECT ctlq_price as price from ci_tbl_low_quality WHERE ctlq_id = $quality 
		UNION ALL
		SELECT cts_price as price from ci_tbl_speakers WHERE cts_id = $speakers 
		UNION ALL
		SELECT cttf_price as price from ci_tbl_txt_format WHERE cttf_id = $text_format
		UNION ALL
		SELECT cttt_price as price from ci_tbl_timestamp WHERE cttt_id = $timestamping
		"
		;
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	
	public function orderData($order, $orderitems, $transcation)
	{
		$this->db->transBegin();
		
		//pr($order);
		//prd($orderitems);
		
		$db  = \Config\Database::connect();
		$item_builder = $db->table('ci_tbl_items');
		$order_builder = $db->table('ci_tbl_orders');
		$transcation_builder = $db->table('ci_tbl_transcation');
		$item_builder->insertBatch($orderitems);
		
		
		
		$i=0;
		$insertedIDs = array();
		foreach($orderitems as $oi)
		{
			$insertedIDs[] = $db->insertID()+$i;
		$i++;	
		}
		
		$order['order_items'] = implode(',',$insertedIDs);
		//prd($order);
		$order_builder->insert($order);
		$orderID = $db->insertID();
		
		
		$updateOrderIDinItems = "UPDATE ci_tbl_items SET order_id = $orderID WHERE item_id IN (".$order['order_items'].")";
		$rs = $this->db->query($updateOrderIDinItems);
		
		$transcation['order_id'] = $orderID;
		$transcation['payerid'] = '0';
		$transcation['paymentId'] = '0';
		$transcation['token'] = '0';
		$transcation['amount'] = '0';
		$transcation['status'] = '0';
		$transcation['created'] = '0';
		$transcation_builder->insert($transcation);
		$transcationID = $db->insertID();
		
		$updateTransid = "UPDATE ci_tbl_orders SET order_transcation_id = $transcationID WHERE order_id = $orderID";
		$this->db->query($updateTransid);
		
		
		if ($this->db->transStatus() === false) {
			$this->db->transRollback();
			return false;
		} else {
			$this->db->transCommit();
			return $orderID;
		}
	}
	
	
	public function get_orders($user_id)
	{
		$sql = "SELECT distinct too.order_id, tu.user_fullname, tu.user_email, tu.user_role, tr.payerid, tr.paymentId, tr.token,
		tr.amount, CASE WHEN tr.status = 1 THEN 'Success' ELSE 'Failed' END as pay_status, too.order_created
		FROM ci_tbl_orders as too
		INNER JOIN ci_tbl_user as tu  ON tu.user_id = too.user_id
		
		INNER JOIN ci_tbl_transcation as tr ON tr.order_id = too.order_id
		
WHERE tu.user_id = $user_id AND payerid != '0'
		ORDER BY too.order_id desc
		";
	
        $query = $this->db->query($sql);
       return $query->getResultArray();
	}
	
	
	
}