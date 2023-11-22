<?php 
// app/Models/UserModel.php

namespace App\Models;

use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
class Admin_auth_model extends Model
{
    function __construct(){
		$this->db = \Config\Database::connect();
	}

    public function login_ajax($userData)
    {
	
	
		$sql = 'SELECT * FROM ci_tbl_user WHERE user_email = "'.$userData['user_email'].'" AND user_password = "'.$userData['user_password'].'" AND user_status = 1';	
		$result = $this->db->query($sql);
		return $result->getResultArray();	
		
    }
	
	
}