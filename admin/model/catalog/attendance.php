<?php
class ModelCatalogAttendance extends Model {
	public function addattendance($data) {

		if(!empty($data['user_id'])){
			$user_id = $data['user_id'];
		} else {
			$user_id = $this->session->data['user_id'];
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "attendance_record SET name = '" . $this->db->escape($data['name']) . "',date = '" . $this->db->escape($data['date']) . "',time = '" . $this->db->escape($data['time']) . "',user_id = '" . $this->db->escape($user_id) . "', office_in_time = '" . $this->db->escape($data['office_in_time']) . "'");

		$attendance_id = $this->db->getLastId();

		

		$this->cache->delete('attendance');

		return $attendance_id;
	}

	public function editattendance($attendance_id, $data) {

		// echo "<pre>";print_r($this->request->post);exit;
		$this->db->query("UPDATE " . DB_PREFIX . "attendance_record SET name = '" . $this->db->escape($data['name']) . "', office_in_time = '" . $this->db->escape($data['office_in_time']) . "' WHERE attendance_id = '" . (int)$attendance_id . "'");

		$this->cache->delete('attendance');
	}

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

		if(!empty($data['start_time']) && !empty($data['end_time'])){
			$sql .= " AND office_in_time >= '" . $this->db->escape($data['start_time']) . "' AND office_in_time <= '" . $this->db->escape($data['end_time']) . "'";
		}elseif(!empty($data['start_time'])) {
			$sql .= " AND office_in_time LIKE '" . $this->db->escape($data['start_time']) . "%'";
		}elseif(!empty($data['end_time'])) {
			$sql .= " AND office_in_time LIKE '" . $this->db->escape($data['end_time']) . "%'";
		}

		// echo "<pre>";print_r($sql);exit;

		$sort_data = array(
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