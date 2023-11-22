<?php 
// app/Models/UserModel.php
namespace App\Models;
use CodeIgniter\Model; 
use CodeIgniter\Database\RawSql;
class Admin_master_model extends Model
{
    function __construct(){
		$this->db = \Config\Database::connect();
	}
	
	public function lang_ajax($filter)
	{
		$filter['price'] = 0;
		if($filter['language'] == '' || $filter['price'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'lang_name' => trim($filter['language']),
			'lang_price' => trim($filter['price']),
			'lang_status' => 1,
			'lang_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_language WHERE lang_name = "'.trim($filter['language']).'"';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_language')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Language already used.', 'status' => 'error'));
			exit;
		}
	}
   
    public function lang_rpt()
	{

		 $columns = array(
            0 => 'lang_name',
			1 => 'lang_tat',
            2 => 'lang_price',
            3 => 'lang_status'
        );
        $requestData = rq();
		
		
        $sql = "SELECT * FROM ci_tbl_language
		";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " WHERE 1=1 AND (lang_name LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR lang_price LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(lang_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
            $nestedData[] = '<a href="#" id="inline-language_'.$row['lang_id'].'" data-type="text" data-pk="'.$row['lang_id'].'" data-title="Enter Language Name">'.$row['lang_name'].'</a>
			<script>$("#inline-language_'.$row['lang_id'].'").editable({
				type: "text",
				pk: '.$row['lang_id'].',
				name: "language",
				title: "Enter username",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_lang",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['lang_id'].'").text(value.msg);
				}
				
			});</script>
			';
			
			/*
			$nestedData[] = '<a href="#" id="inline-price_'.$row['lang_id'].'" data-type="text" data-pk="'.$row['lang_id'].'" data-title="Enter Language Price">'.$row['lang_price'].'</a>
			<script>$("#inline-price_'.$row['lang_id'].'").editable({
				type: "text",
				pk: '.$row['lang_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_lang_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['lang_id'].'").text(value.msg);
				}
				
			});</script>';*/
			
            $nestedData[] = ($row['lang_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['lang_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStatus('.$row['lang_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
           $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_language('.$row['lang_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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
	
	public function edit_lang($filter)
	{
		
		$sql = "UPDATE ci_tbl_language SET lang_name = '".trim($filter['value'])."' WHERE lang_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	}
	public function edit_lang_tat($filter)
	{
		
		$sql = "UPDATE ci_tbl_language SET lang_tat = '".trim($filter['value'])."' WHERE lang_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	}
	
	public function edit_lang_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_language SET lang_price = '".trim($filter['value'])."' WHERE lang_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	
	public function change_lang_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_language SET lang_status = '".trim($filter['status'])."' WHERE lang_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_lang($filter)
	{
		//check used in order
		$check = "SELECT * FROM ci_tbl_items WHERE item_language = '".$filter['id']."'";
		$query = $this->db->query($check);
		if(count($query->getResultArray()) > 0)
		{
			echo json_encode(array('msg' => 'You can\'t delete this, It is used in order.', 'status' => 'error'));
			exit;
		}
		$sql = "DELETE FROM ci_tbl_language WHERE lang_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	public function language_ajax($filter)
	{
		
		if($filter['language'] == '' || $filter['price'] == '' || $filter['tat'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'lang_name' => trim($filter['language']),
			'lang_tat' =>  trim($filter['tat']),
			'lang_price' => trim($filter['price']),
			'lang_status' => 1,
			'lang_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_lang WHERE lang_name = "'.trim($filter['language']).'" AND lang_tat = "'.trim($filter['tat']).'" ';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_lang')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Language & Tat already used.', 'status' => 'error'));
			exit;
		}
	}
   
    public function language_rpt($tat_json, $lang_json)
	{
		
		 $tat_array = array();
		 foreach($tat_json as $tj)
		 {
			$tat_array[] = array(
			'value' => $tj['ctt_id'],
			'text' => $tj['ctt_name']
			);
		 }
		 
		 $lang_array = array();
		 foreach($lang_json as $lj)
		 {
			$lang_array[] = array(
			'value' => $lj['lang_id'],
			'text' => $lj['lang_name']
			);
		 }
		
		 $columns = array(
            0 => 'lang_name',
			1 => 'lang_tat',
            2 => 'lang_price',
            3 => 'lang_status'
        );
        $requestData = rq();
		
		
        $sql = "SELECT tl.lang_status, tl.lang_id, tl.lang_price, tt.ctt_name, ctl.lang_name FROM ci_tbl_lang as tl
		INNER JOIN ci_tbl_tat as tt ON tt.ctt_id = tl.lang_tat
		INNER JOIN ci_tbl_language as ctl ON ctl.lang_id = tl.lang_name
		";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " WHERE 1=1 AND (ctl.lang_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR tt.ctt_name LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR tl.lang_price LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(tl.lang_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
            $nestedData[] = '<a href="#" id="inline-language_'.$row['lang_id'].'" data-type="select" data-pk="'.$row['lang_id'].'" data-title="Enter Language Name">'.$row['lang_name'].'</a>
			<script>
			$("#inline-language_'.$row['lang_id'].'").editable({
				pk: '.$row['lang_id'].',
				name: "language_tat",
				prepend: "not selected",
				source: '.json_encode($lang_array).',
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_language",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['lang_id'].'").text(value.msg);
				}
				
			}); 
			</script>
			
			';
			
			
			 $nestedData[] = '<a href="#" id="inline-language-tat_'.$row['lang_id'].'" data-type="select"  data-pk="'.$row['lang_id'].'" data-title="Select TAT">'.$row['ctt_name'].'</a>
			<script>
			$("#inline-language-tat_'.$row['lang_id'].'").editable({
				pk: '.$row['lang_id'].',
				name: "language_tat",
				prepend: "not selected",
				source: '.json_encode($tat_array).',
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_language_tat",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['lang_id'].'").text(value.msg);
				}
				
			}); 
			</script>
			';
			
			
			
			$nestedData[] = '<a href="#" id="inline-price_'.$row['lang_id'].'" data-type="text" data-pk="'.$row['lang_id'].'" data-title="Enter Language Price">'.$row['lang_price'].'</a>
			<script>$("#inline-price_'.$row['lang_id'].'").editable({
				type: "text",
				pk: '.$row['lang_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_language_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['lang_id'].'").text(value.msg);
				}
				
			});</script>';
			
            $nestedData[] = ($row['lang_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['lang_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStatus('.$row['lang_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
           $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_language('.$row['lang_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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
	
	public function edit_language($filter)
	{
		
		$sql = "UPDATE ci_tbl_lang SET lang_name = '".trim($filter['value'])."' WHERE lang_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	}
	public function edit_language_tat($filter)
	{
		
		$sql = "UPDATE ci_tbl_lang SET lang_tat = '".trim($filter['value'])."' WHERE lang_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	}
	
	public function edit_language_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_lang SET lang_price = '".trim($filter['value'])."' WHERE lang_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	
	public function change_language_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_lang SET lang_status = '".trim($filter['status'])."' WHERE lang_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_language($filter)
	{
		//check used in order
		$check = "SELECT * FROM ci_tbl_items WHERE item_language = '".$filter['id']."'";
		$query = $this->db->query($check);
		if(count($query->getResultArray()) > 0)
		{
			echo json_encode(array('msg' => 'You can\'t delete this, It is used in order.', 'status' => 'error'));
			exit;
		}
		
		$sql = "DELETE FROM ci_tbl_lang WHERE lang_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	public function quality_ajax($filter)
	{
		if($filter['quality'] == '' || $filter['price'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'ctlq_name' => trim($filter['quality']),
			'ctlq_price' => trim($filter['price']),
			'ctlq_status' => 1,
			'ctlq_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_low_quality WHERE ctlq_name = "'.trim($filter['quality']).'"';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_low_quality')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Quality already used.', 'status' => 'error'));
			exit;
		}
	}
   
    public function quality_rpt()
	{
		
	
		 $columns = array(
            0 => 'ctlq_name',
            1 => 'ctlq_price',
            2 => 'ctlq_status'
        );
        $requestData = rq();
		
		
        $sql = "SELECT * FROM ci_tbl_low_quality";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " WHERE 1=1 AND (ctlq_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR ctlq_price LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(ctlq_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
            $nestedData[] = '<a href="#" id="inline-quality_'.$row['ctlq_id'].'" data-type="text" data-pk="'.$row['ctlq_id'].'" data-title="Enter Quality Name">'.$row['ctlq_name'].'</a>
			<script>$("#inline-quality_'.$row['ctlq_id'].'").editable({
				type: "text",
				pk: '.$row['ctlq_id'].',
				name: "language",
				title: "Enter Quality",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_quality",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['ctlq_id'].'").text(value.msg);
				}
				
			});</script>
			';
			
			
			$nestedData[] = '<a href="#" id="inline-price_'.$row['ctlq_id'].'" data-type="text" data-pk="'.$row['ctlq_id'].'" data-title="Enter Quality Price">'.$row['ctlq_price'].'</a>
			<script>$("#inline-price_'.$row['ctlq_id'].'").editable({
				type: "text",
				pk: '.$row['ctlq_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_quality_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['ctlq_id'].'").text(value.msg);
				}
				
			});</script>';
			
            $nestedData[] = ($row['ctlq_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['ctlq_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStatus('.$row['ctlq_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
           $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_quality('.$row['ctlq_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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
	
	public function edit_quality($filter)
	{
		
		$sql = "UPDATE ci_tbl_low_quality SET ctlq_name = '".trim($filter['value'])."' WHERE ctlq_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	}
	
	public function edit_quality_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_low_quality SET ctlq_price = '".trim($filter['value'])."' WHERE ctlq_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	
	public function change_quality_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_low_quality SET ctlq_status = '".trim($filter['status'])."' WHERE ctlq_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_quality($filter)
	{
		//check used in order
		$check = "SELECT * FROM ci_tbl_items WHERE item_low_quality = '".$filter['id']."'";
		$query = $this->db->query($check);
		if(count($query->getResultArray()) > 0)
		{
			echo json_encode(array('msg' => 'You can\'t delete this, It is used in order.', 'status' => 'error'));
			exit;
		}
		
		$sql = "DELETE FROM ci_tbl_low_quality WHERE ctlq_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function textformat_ajax($filter)
	{
		if($filter['textformat'] == '' || $filter['price'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'cttf_name' => trim($filter['textformat']),
			'cttf_price' => trim($filter['price']),
			'cttf_status' => 1,
			'cttf_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_txt_format WHERE cttf_name = "'.trim($filter['textformat']).'"';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_txt_format')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Text Format already used.', 'status' => 'error'));
			exit;
		}
	}
   
    public function textformat_rpt()
	{
		
	
		 $columns = array(
            0 => 'cttf_name',
            1 => 'cttf_price',
            2 => 'cttf_status'
        );
        $requestData = rq();
		
		
        $sql = "SELECT * FROM ci_tbl_txt_format";
        $query = $this->db->query($sql);
        $totalData = count($query->getResultArray());
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) { 
            $sql .= " WHERE 1=1 AND (cttf_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cttf_price LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cast(cttf_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
            $nestedData[] = '<a href="#" id="inline-textformat_'.$row['cttf_id'].'" data-type="text" data-pk="'.$row['cttf_id'].'" data-title="Enter Text Format Name">'.$row['cttf_name'].'</a>
			<script>$("#inline-quality_'.$row['cttf_id'].'").editable({
				type: "text",
				pk: '.$row['cttf_id'].',
				name: "language",
				title: "Enter Quality",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_quality",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['cttf_id'].'").text(value.msg);
				}
				
			});</script>
			';
			
			
			$nestedData[] = '<a href="#" id="inline-price_'.$row['cttf_id'].'" data-type="text" data-pk="'.$row['cttf_id'].'" data-title="Enter Quality Price">'.$row['cttf_price'].'</a>
			<script>$("#inline-price_'.$row['cttf_id'].'").editable({
				type: "text",
				pk: '.$row['cttf_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_textformat_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['cttf_id'].'").text(value.msg);
				}
				
			});</script>';
			
            $nestedData[] = ($row['cttf_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['cttf_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStatus('.$row['cttf_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
           $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_textformat('.$row['cttf_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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
	
	public function edit_textformat($filter)
	{
		
		$sql = "UPDATE ci_tbl_txt_format SET cttf_name = '".trim($filter['value'])."' WHERE cttf_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	}
	
	public function edit_textformat_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_txt_format SET cttf_price = '".trim($filter['value'])."' WHERE cttf_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	
	public function change_textformat_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_txt_format SET cttf_status = '".trim($filter['status'])."' WHERE cttf_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_textformat($filter)
	{
		//check used in order
		$check = "SELECT * FROM ci_tbl_items WHERE item_low_quality = '".$filter['id']."'";
		$query = $this->db->query($check);
		if(count($query->getResultArray()) > 0)
		{
			echo json_encode(array('msg' => 'You can\'t delete this, It is used in order.', 'status' => 'error'));
			exit;
		}
		
		$sql = "DELETE FROM ci_tbl_txt_format WHERE cttf_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
        return ($this->db->affectedRows() > 0)?true:false;
	} 

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	public function speaker_ajax($filter)
	{
		if($filter['speaker'] == '' || $filter['price'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'cts_name' => trim($filter['speaker']),
			'cts_price' => trim($filter['price']),
			'cts_status' => 1,
			'cts_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_speakers WHERE cts_name = "'.trim($filter['speaker']).'"';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_speakers')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Speaker already used.', 'status' => 'error'));
			exit;
		}
	}

	public function speaker_rpt()
	{
		

		 $columns = array(
			0 => 'cts_name',
			1 => 'cts_price',
			2 => 'cts_status'
		);
		$requestData = rq();
		
		
		$sql = "SELECT * FROM ci_tbl_speakers";
		$query = $this->db->query($sql);
		$totalData = count($query->getResultArray());
		$totalFiltered = $totalData;

		if (!empty($requestData['search']['value'])) { 
			$sql .= " WHERE 1=1 AND (cts_name LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cts_price LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cast(cts_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
			$nestedData[] = '<a href="#" id="inline-speaker_'.$row['cts_id'].'" data-type="text" data-pk="'.$row['cts_id'].'" data-title="Enter Speaker Name">'.$row['cts_name'].'</a>
			<script>$("#inline-speaker_'.$row['cts_id'].'").editable({
				type: "text",
				pk: '.$row['cts_id'].',
				name: "language",
				title: "Enter Speaker",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_speaker",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['cts_id'].'").text(value.msg);
				}
				
			});</script>
			';
			
			
			$nestedData[] = '<a href="#" id="inline-price_'.$row['cts_id'].'" data-type="text" data-pk="'.$row['cts_id'].'" data-title="Enter Speaker Price">'.$row['cts_price'].'</a>
			<script>$("#inline-price_'.$row['cts_id'].'").editable({
				type: "text",
				pk: '.$row['cts_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_speaker_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['cts_id'].'").text(value.msg);
				}
				
			});</script>';
			
			$nestedData[] = ($row['cts_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['cts_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStatus('.$row['cts_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
		   $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_speaker('.$row['cts_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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

	public function edit_speaker($filter)
	{
		
		$sql = "UPDATE ci_tbl_speakers SET cts_name = '".trim($filter['value'])."' WHERE cts_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	}

	public function edit_speaker_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_speakers SET cts_price = '".trim($filter['value'])."' WHERE cts_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 

	public function change_speaker_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_speakers SET cts_status = '".trim($filter['status'])."' WHERE cts_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_speaker($filter)
	{
		
		$sql = "DELETE FROM ci_tbl_speakers WHERE cts_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function tat_ajax($filter)
	{
		$filter['price'] = 0;
		if($filter['tat'] == '' || $filter['price'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'ctt_name' => trim($filter['tat']),
			'ctt_price' => trim($filter['price']),
			'ctt_status' => 1,
			'ctt_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_tat WHERE ctt_name = "'.trim($filter['tat']).'"';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_tat')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Turn Around Time already used.', 'status' => 'error'));
			exit;
		}
	}
	
	public function tat_dropdown()
	{
		$sql = "SELECT * FROM ci_tbl_tat WHERE ctt_status = 1";
		$query = $this->db->query($sql);
		return $query->getResultArray();
	}
	
	public function lng_dropdown()
	{
		$sql = "SELECT * FROM ci_tbl_language WHERE lang_status = 1";
		$query = $this->db->query($sql);
		return $query->getResultArray();
	}
	public function tat_rpt()
	{
		

		 $columns = array(
			0 => 'ctt_name',
			1 => 'ctt_price',
			2 => 'ctt_status'
		);
		$requestData = rq();
		
		
		$sql = "SELECT * FROM ci_tbl_tat";
		$query = $this->db->query($sql);
		$totalData = count($query->getResultArray());
		$totalFiltered = $totalData;

		if (!empty($requestData['search']['value'])) { 
			$sql .= " WHERE 1=1 AND (ctt_name LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR ctt_price LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cast(ctt_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
			$nestedData[] = '<a href="#" id="inline-tat_'.$row['ctt_id'].'" data-type="text" data-pk="'.$row['ctt_id'].'" data-title="Enter Turn Around Time Name">'.$row['ctt_name'].'</a>
			<script>$("#inline-tat_'.$row['ctt_id'].'").editable({
				type: "text",
				pk: '.$row['ctt_id'].',
				name: "language",
				title: "Enter Turn Around Time",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_tat",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['ctt_id'].'").text(value.msg);
				}
				
			});</script>
			';
			
			/*
			$nestedData[] = '<a href="#" id="inline-price_'.$row['ctt_id'].'" data-type="text" data-pk="'.$row['ctt_id'].'" data-title="Enter Turn Around Time Price">'.$row['ctt_price'].'</a>
			<script>$("#inline-price_'.$row['ctt_id'].'").editable({
				type: "text",
				pk: '.$row['ctt_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_tat_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['ctt_id'].'").text(value.msg);
				}
				
			});</script>';*/
			
			$nestedData[] = ($row['ctt_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStatus('.$row['ctt_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStatus('.$row['ctt_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
		   $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_tat('.$row['ctt_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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

	public function edit_tat($filter)
	{
		
		$sql = "UPDATE ci_tbl_tat SET ctt_name = '".trim($filter['value'])."' WHERE ctt_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	}

	public function edit_tat_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_tat SET ctt_price = '".trim($filter['value'])."' WHERE ctt_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 

	public function change_tat_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_tat SET ctt_status = '".trim($filter['status'])."' WHERE ctt_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_tat($filter)
	{
		
		$sql = "DELETE FROM ci_tbl_tat WHERE ctt_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 

	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function timestamp_ajax($filter)
	{
		if($filter['timestamp'] == '' || $filter['price'] == '')
		{
			echo json_encode(array('msg' => 'All fields are required.', 'status' => 'error'));
			exit;
		}
		$sendArray = array(
			'cttt_name' => trim($filter['timestamp']),
			'cttt_price' => trim($filter['price']),
			'cttt_status' => 1,
			'cttt_created' => date('Y-m-d H:i:s')
		);
		
		$sql = 'SELECT * FROM ci_tbl_timestamp WHERE cttt_name = "'.trim($filter['timestamp']).'"';	
		$result = $this->db->query($sql);
		if(empty($result->getResultArray()))
		{
			
			$this->db->table('ci_tbl_timestamp')->insert($sendArray);
			//$this->db->insert('ci_tbl_lang', $sendArray);
			return ($this->db->affectedRows() > 0)?true:false;
			
		}
		else
		{
			echo json_encode(array('msg' => 'Timestamp already used.', 'status' => 'error'));
			exit;
		}
	}

	public function timestamp_rpt()
	{
		

		 $columns = array(
			0 => 'cttt_name',
			1 => 'cttt_price',
			2 => 'cttt_status'
		);
		$requestData = rq();
		
		
		$sql = "SELECT * FROM ci_tbl_timestamp";
		$query = $this->db->query($sql);
		$totalData = count($query->getResultArray());
		$totalFiltered = $totalData;

		if (!empty($requestData['search']['value'])) { 
			$sql .= " WHERE 1=1 AND (cttt_name LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cttt_price LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR cast(cttt_status as char) LIKE '" . $requestData['search']['value'] . "%' )";
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
			$nestedData[] = '<a href="#" id="inline-timestamp_'.$row['cttt_id'].'" data-type="text" data-pk="'.$row['cttt_id'].'" data-title="Enter Timestamp Name">'.$row['cttt_name'].'</a>
			<script>$("#inline-timestamp_'.$row['cttt_id'].'").editable({
				type: "text",
				pk: '.$row['cttt_id'].',
				name: "language",
				title: "Enter Timestamp",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_timestamp",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['cttt_id'].'").text(value.msg);
				}
				
			});</script>
			';
			
			
			$nestedData[] = '<a href="#" id="inline-price_'.$row['cttt_id'].'" data-type="text" data-pk="'.$row['cttt_id'].'" data-title="Enter Timestamp Price">'.$row['cttt_price'].'</a>
			<script>$("#inline-price_'.$row['cttt_id'].'").editable({
				type: "text",
				pk: '.$row['cttt_id'].',
				name: "price",
				title: "Price",
				mode: "inline",
				inputclass: "form-control-sm",
				url: "'.base_url().'Admin_master/edit_timestamp_price",
				type: "POST",
				dataType: "json",
				validate: function(value){
				   $("#msg_'.$row['cttt_id'].'").text(value.msg);
				}
				
			});</script>';
			
			$nestedData[] = ($row['cttt_status'] == 1)?'<span class="btn-xs btn-success" onclick="changeStimestampus('.$row['cttt_id'].', 0);" style="cursor:pointer;">Activate</span>':'<span class="btn-xs btn-danger"  onclick="changeStimestampus('.$row['cttt_id'].', 1);" style="cursor:pointer;">Deactivate</span>';
			
		   $nestedData[] = '<span class="btn-xs btn-danger" onclick="delete_timestamp('.$row['cttt_id'].');" style="cursor:pointer;">Delete</span>';
			
			
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

	public function edit_timestamp($filter)
	{
		
		$sql = "UPDATE ci_tbl_timestamp SET cttt_name = '".trim($filter['value'])."' WHERE cttt_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	}

	public function edit_timestamp_price($filter)
	{
		
		$sql = "UPDATE ci_tbl_timestamp SET cttt_price = '".trim($filter['value'])."' WHERE cttt_id = '".$filter['pk']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 

	public function change_timestamp_status($filter)
	{
		
		$sql = "UPDATE ci_tbl_timestamp SET cttt_status = '".trim($filter['status'])."' WHERE cttt_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	} 
	public function delete_timestamp($filter)
	{
		
		$sql = "DELETE FROM ci_tbl_timestamp WHERE cttt_id = '".$filter['id']."'";
		$query = $this->db->query($sql);
		return ($this->db->affectedRows() > 0)?true:false;
	}

}