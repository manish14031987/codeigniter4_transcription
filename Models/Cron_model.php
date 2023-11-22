<?php 
// app/Models/UserModel.php
namespace App\Models;

use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
use CodeIgniter\Email\Email;
class Cron_model extends Model
{
    function __construct(){
		
		$this->request = \Config\Services::request();
		date_default_timezone_set('Asia/Kolkata');
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	
	function delete_files()
	{
		$sql = "SELECT item_file FROM ci_tbl_items as ti
		INNER JOIN ci_tbl_orders as tos ON tos.order_id = ti.order_id
		INNER JOIN ci_tbl_transcation as txn ON txn.order_id = ti.order_id";
	$rs = $this->db->query($sql);
	return $rs->getResultArray();  
	}
	
	function get_order_id($filename)
	{
	$sql = "SELECT too.order_id, tu.user_email, tu.user_fullname FROM ci_tbl_items as ti 
	INNER JOIN ci_tbl_orders as too ON too.order_id = ti.order_id
	INNER JOIN ci_tbl_transcation as txn ON txn.order_id = ti.order_id
	INNER JOIN ci_tbl_user as tu ON tu.user_id = too.user_id
	WHERE ti.item_file = '$filename' AND txn.status = 1";
	$rs = $this->db->query($sql);
	//prd($rs->getResultArray());
	return $rs->getResultArray()[0];
	}
	
	public function get_files_by_order($id)
	{
		$sql = "SELECT item_file FROM ci_tbl_items WHERE order_id = $id";
		$rs = $this->db->query($sql);
		return $rs->getResultArray();
	}
	
	public function updateDownloadLink($downloadArray)
	{
		$order_id = $downloadArray['order_id'];
		$file_old_name = $downloadArray['file_old_name'];
		$new_file_download_url = $downloadArray['new_file_download_url'];
		$sql = "UPDATE ci_tbl_items SET item_file = '$new_file_download_url' WHERE order_id = $order_id AND item_file = '$file_old_name'";
		$rs = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	}
	

}