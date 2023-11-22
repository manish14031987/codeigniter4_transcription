<?php 
// app/Models/UserModel.php
namespace App\Models;
use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
class Admin_user_model extends Model
{
    function __construct(){
		$this->db = \Config\Database::connect();
	}

    public function guest_user_rpt()
    {
	
		 $columns = array(
            0 => 'user_fullname',
            1 => 'user_email',
            2 => 'user_role',
            3 => 'user_status',
            4 => 'user_pin',
            5 => 'user_created'
        );
        $requestData = rq();
		
		
        $sql = "SELECT * FROM ci_tbl_user WHERE user_role = 3";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " AND (user_fullname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR user_email LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(user_role as CHAR) LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cast(user_status as CHAR) LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR user_created LIKE '" . $requestData['search']['value'] . "%' )";
        }

        $query = $this->db->query($sql);
        $totalFiltered = count($query->getResultArray());

        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['length'] . " OFFSET " . $requestData['start'] . "   ";
     
        $resArr = $this->db->query($sql);

        $data = array();
        
        $cnt = $requestData['start'] ? $requestData['start'] + 1 : 1;
        foreach ($resArr->getResultArray()as $rk => $row) {  // preparing an array
            $nestedData = array();
            $nestedData[] = $cnt++;
            $nestedData[] = $row['user_fullname'];
			$nestedData[] = $row['user_email'];
			//$nestedData[] = ($row['user_role'] == 3)?'Non Corporate User':'N/A';
            //$nestedData[] = ($row['user_status'] == 1)?'<span class="btn-xs btn-success">Activate</span>':'<span class="btn-xs btn-danger">Deactivate</span>';
            $nestedData[] = date('d-m-Y', strtotime($row["user_created"]));
			
			
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

	public function corporate_user_rpt()
    {
	
		 $columns = array(
            0 => 'user_fullname',
            1 => 'user_email',
            2 => 'user_role',
            3 => 'user_status',
            4 => 'user_pin',
            5 => 'user_created'
        );
        $requestData = rq();
        $sql = "SELECT * FROM ci_tbl_user WHERE user_role = 2";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " AND (user_fullname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR user_email LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(user_role as CHAR) LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cast(user_status as CHAR) LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR user_created LIKE '" . $requestData['search']['value'] . "%' )";
        }
		
        $query = $this->db->query($sql);
        $totalFiltered = count($query->getResultArray());

        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['length'] . " OFFSET " . $requestData['start'] . "   ";
     
        $resArr = $this->db->query($sql);

        $data = array();
        
        $cnt = $requestData['start'] ? $requestData['start'] + 1 : 1;
        foreach ($resArr->getResultArray()as $rk => $row) {  // preparing an array
            $nestedData = array();
            $nestedData[] = $cnt++;
            $nestedData[] = $row['user_fullname'];
			$nestedData[] = $row['user_email'];
			//$nestedData[] = ($row['user_role'] == 2)?'Corporate User':'N/A';
            $nestedData[] = ($row['user_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['user_id'].');" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger" onclick="changeStatus('.$row['user_id'].');" style="cursor:pointer;">Deactivate</span>'; 
            $nestedData[] = date('d-m-Y', strtotime($row["user_created"]));
           
			
			
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
	
	public function change_status($filter)
	{
		$user_id = $filter['status'];
		$sql = "UPDATE ci_tbl_user SET user_status = (CASE user_status WHEN 1 THEN 0 ELSE 1 END) WHERE user_id = $user_id";
		$this->db->query($sql);
		return true;
	}
}