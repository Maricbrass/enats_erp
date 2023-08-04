<?php
class ModelCatalogLeave extends Model {
	public function addattendance($data) {

		if(!empty($data['user_id'])){
			$user_id = $data['user_id'];
		} else {
			$user_id = $this->session->data['user_id'];
		}
	 // $name=$this->db->query("select name from oc_employee where 1=1");
	  
	  $sql = "SELECT employee_id,name FROM oc_employee";
		$query = $this->db->query($sql);
		$emp_id = $query->rows;
		// $sql1 = "SELECT name from oc_employee where employee_id = $emp_id";
		// $query1 = $this->db->query($sql1);
		// $name = $query1->rows['name'];
		//$employee_name = $_POST['name'];
		//$sql_select_employee_id = "SELECT id FROM employee WHERE name = '$employee_name'";

		$n = $query->num_rows;
		$row = $query->row;
		$employee_id_row = $row['employee_id'];
		$employee_name = $row['name'];
		
		$rows = $query->rows;
		
		for($i=0;$i<$n;$i++)
		{
			$employee_id = $rows[$i]['employee_id'];
			$employee_name = $rows[$i]['name'];
			//echo $employee_id;
			//echo $employee_name;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attendance_record SET employee_id = '$employee_id',name = '$employee_name', date = '" . $this->db->escape($data['date']) . "',status = '" . $this->db->escape($data['status']) ."';");
		
		//echo "<pre>";print_r("INSERT into " . DB_PREFIX . "attendance_record SET employee_id = '$employee_id',name = '$employee_name', date = '" . $this->db->escape($data['date']) . "',status = '" . $this->db->escape($data['status']) ."';");
	}
		//employee_id = $employee_id,name = $employee_name,


	//	$query = "INSERT INTO oc_attendance_record (name,user_id, date, status) VALUES (:name, :user_id, :date, :status)";


	$attendance_id = $this->db->getLastId();
		//$query = $this->db->query($sql);
		//echo "<pre>";print_r($m);
		//echo "<pre>";print_r($m);
		//echo "<pre>";print_r($this->request->post);exit;
		

		$this->cache->delete('attendance');

		return $attendance_id;
	}

	public function editattendance($attendance_id, $data) {

		// echo "<pre>";print_r($this->request->post);exit;
		$this->db->query("UPDATE " . DB_PREFIX . "attendance_record SET name = '" . $this->db->escape($data['name']) . "', office_in_time = '" . $this->db->escape($data['office_in_time']) ."',status = '" . $this->db->escape($data['status']). "' WHERE attendance_id = '" . (int)$attendance_id . "'");

		$this->cache->delete('attendance');
	}
	// public function lateattendance($attendance_id, $data) {

	// 	$sql = "SELECT * FROM " . DB_PREFIX . "attendance_record WHERE 1=1";
	// 	//$officeintime = "SELECT office_in_time FROM " . DB_PREFIX . "attendance_record WHERE 1=1";

	// 	// if () {
			
	// 	// } else {
			
	// 	// }

	// 	// if (!empty($data['filter_name'])) {
	// 	// 	$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
	// 	// }

	// 	if(!empty($data['start_time']) && !empty($data['end_time'])){
	// 		$sql .= " AND office_in_time >= '" . $this->db->escape($data['start_time']) . "' AND office_in_time <= '" . $this->db->escape($data['end_time']) . "'";
	// 	}elseif(!empty($data['start_time'])) {
	// 		$sql .= " AND office_in_time LIKE '" . $this->db->escape($data['start_time']) . "%'";
	// 	}elseif(!empty($data['end_time'])) {
	// 		$sql .= " AND office_in_time LIKE '" . $this->db->escape($data['end_time']) . "%'";
	// 	}

	// }

	public function deleteattendance($attendance_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'attendance_id=" . (int)$attendance_id . "'");

		$this->cache->delete('attendance');
	}

	public function getattendance($attendance_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'attendance_id=" . (int)$attendance_id . "') AS keyword FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");

		return $query->row;
	}

	public function autocompleteatt2($data = array()){
		$sql = "SELECT * FROM oc_user WHERE user_group_id = 11";

		if (!empty($data['name'])) {
			$sql .= " AND firstname LIKE '" . $this->db->escape($data['name']) . "%'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND firstname LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY firstname";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}
	public function getAttendances($data = array()) {
		// echo "<pre>"; print_r($data);exit;
		$sql = "SELECT * FROM " . DB_PREFIX . "attendance_record WHERE 1=1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		// $d=mktime(10,00,00);
		// $time1=date("H:i:s",$d);
		// if ($time1<'office_in_time'){
		// 		// $this->db->query("UPDATE INTO " . DB_PREFIX . "attendance_record SET status = 'Late' Where office_in_time >'10:00:00'");
		// $sql.= " AND status = 'Late'";
		// }
		if(!empty($data['start_time']) && !empty($data['end_time'])){
			$sql .= " AND office_in_time >= '" . $this->db->escape($data['start_time']) . "' AND office_in_time <= '" . $this->db->escape($data['end_time']) . "'";
		}elseif(!empty($data['start_time'])) {
			$sql .= " AND office_in_time >= '" . $this->db->escape($data['start_time']) . "'";
		}elseif(!empty($data['end_time'])) {
			$sql .= " AND office_in_time <= '" . $this->db->escape($data['end_time']) . "'";
		}

		// echo "<pre>";print_r($sql);exit;

		$sort_data = array(
			'name',
			'date',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query->rows);exit;
		return $query->rows;
    }

	public function getemployees() {

	}

	public function getAttandanceStores($attendance_id) {
		$attendance = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");

		foreach ($query->rows as $result) {
			$attendance[] = $result['store_id'];
		}

		return $attendance;
	}


	public function getTotalattendances($data = array()) {
		$query = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attendance_record WHERE 1=1";
         // echo "<pre>";print_r($data);exit;
		if (!empty($data['filter_name'])) {
			$query .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if(!empty($data['start_time']) && !empty($data['end_time'])){
			$query .= " AND office_in_time >= '" . $this->db->escape($data['start_time']) . "' AND office_in_time <= '" . $this->db->escape($data['end_time']) . "'";
		}elseif(!empty($data['start_time'])) {
			$query .= " AND office_in_time LIKE '" . $this->db->escape($data['start_time']) . "%'";
		}elseif(!empty($data['end_time'])) {
			$query .= " AND office_in_time LIKE '" . $this->db->escape($data['end_time']) . "%'";
		}
        
        $sql = $this->db->query($query);
		return $sql->row['total'];
	}
}