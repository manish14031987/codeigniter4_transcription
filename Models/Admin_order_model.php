<?php 
// app/Models/UserModel.php
namespace App\Models;
use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
class Admin_order_model extends Model
{
    function __construct(){
		$this->db = \Config\Database::connect();
	}

    public function order_rpt()
    {
	
		 $columns = array(
            0 => 'order_id',
			1 => 'user_fullname',
            2 => 'user_email, ',
            3 => 'pay_status',
            4 => 'order_created'
        );
        $requestData = rq();
		
		
        $sql = "SELECT distinct too.order_id, tu.user_fullname, tu.user_email, tu.user_role, tr.payerid, tr.paymentId, tr.token,
		tr.amount, CASE WHEN tr.status = 1 THEN 'Success' ELSE 'Failed' END as pay_status, too.order_created
		FROM ci_tbl_orders as too
		INNER JOIN ci_tbl_user as tu  ON tu.user_id = too.user_id
		INNER JOIN ci_tbl_transcation as tr ON tr.order_id = too.order_id
		";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " AND (user_fullname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR user_email LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(user_role as CHAR) LIKE '" . $requestData['search']['value'] . "%' ";
			//$sql .= " OR cast(pay_status as CHAR) LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR order_created LIKE '" . $requestData['search']['value'] . "%' )";
        }
		//prd($sql);
        $query = $this->db->query($sql);
        $totalFiltered = count($query->getResultArray());

        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['length'] . " OFFSET " . $requestData['start'] . "   ";
     
        $resArr = $this->db->query($sql);

        $data = array();
        
        $cnt = $requestData['start'] ? $requestData['start'] + 1 : 1;
        foreach ($resArr->getResultArray()as $rk => $row) {  // preparing an array
            $nestedData = array();
            $nestedData[] = $cnt++;
            $nestedData[] = '#'.$row['order_id'];
			$nestedData[] = $row['user_fullname'].'<br/>'.$row['user_email'];
			$nestedData[] = ($row['user_role'] == 3)?'Non Corporate User':'Corporate User';
            $nestedData[] = $row['pay_status'];
            $nestedData[] = date('d-m-Y h:i A', strtotime($row["order_created"]));
			$nestedData[] = '<a href="'.base_url().'admin/order_detail/'.encryptMyData($row['order_id']).'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>';
			
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data 
        );
       // array_walk_recursive($json_data);
        return $json_data;
	
    }
	
	public function order_item($id)
	{
		$sql = "SELECT ti.item_size, ti.item_duration, ti.order_id, ti.item_id, ti.item_name, ti.item_file, tl.lang_name as language, tf.cttf_name as text_format,
		tat.ctt_name as turn_around_time, ts.cts_name as speaker, tlq.ctlq_name as quality, tts.cttt_name as timestamping, ti.item_amount as price
		FROM ci_tbl_items as ti
		INNER JOIN ci_tbl_language as tl ON tl.lang_id = ti.item_language
		INNER JOIN ci_tbl_txt_format as tf ON tf.cttf_id = ti.item_text_format
		INNER JOIN ci_tbl_tat as tat ON tat.ctt_id = ti.item_tat
		INNER JOIN ci_tbl_speakers as ts ON ts.cts_id = ti.item_speakers
		INNER JOIN ci_tbl_low_quality as tlq ON tlq.ctlq_id = ti.item_low_quality
		INNER JOIN ci_tbl_timestamp as tts ON tts.cttt_id = ti.item_timestamping
		WHERE ti.order_id = $id";
		$resArr = $this->db->query($sql);
		return $resArr->getResultArray();
	}
	
	public function order_info($id)
	{
        $sql = "SELECT distinct too.order_id, tu.user_fullname, tu.user_email, tu.user_role, tr.payerid, tr.paymentId, tr.token,
		tr.amount, CASE WHEN tr.status = 1 THEN 'Success' ELSE 'Failed' END as pay_status, too.order_created
		FROM ci_tbl_orders as too
		INNER JOIN ci_tbl_user as tu  ON tu.user_id = too.user_id
		INNER JOIN ci_tbl_transcation as tr ON tr.order_id = too.order_id
		WHERE too.order_id =  $id";
		$resArr = $this->db->query($sql);
		return $resArr->getResultArray();
	}

}  