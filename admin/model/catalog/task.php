<?php
class ModelCatalogTask extends Model {
	public function addTask($data) {
		// echo "<pre>";print_r($data);exit;
		$target_file = DIR_IMAGE .'screenshot/'.basename($_FILES["screenshot"]["name"]);
        move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file);
	    $file_name = 'screenshot/' . basename($_FILES["screenshot"]["name"]);

		$user_group_id = $this->user->user_group_id;
		if($user_group_id == 12){
			$data['status'] = "pending";
		}

		if($user_group_id == 11){
			$notify = '1';
		}else{
			$notify = '0';
		}

		date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
		$date_time = date('Y-m-d H:i:s');
		// echo "<pre>";print_r($date_time);exit;

		$this->db->query("INSERT INTO " . DB_PREFIX . "task SET project_id = '" . $this->db->escape($data['project_id']) . "',screenshot_path = '" . $file_name . "',username = '" . $this->db->escape($data['username']) . "',user_id = '" . $this->db->escape($data['user_id']) . "',subject = '" . $this->db->escape($data['subject']) . "',remark = '" . $this->db->escape($data['remark']) . "',project_start_time = '" . $this->db->escape($data['project_start_time']) . "',date = '" . $this->db->escape($data['date']) . "',project_end_time = '" . $this->db->escape($data['project_end_time']) . "',task = '" . $this->db->escape($data['task']) . "',status = '" . $this->db->escape($data['status']) . "',notification = '" . $notify . "',date_time = '" . $date_time . "',commit_no = '" . $this->db->escape($data['commit_no']) . "'");

		$task_id = $this->db->getLastId();

		$this->cache->delete('task');

		return $task_id;
	}

	public function editTask($task_id, $data) {
	 // echo "<pre>";print_r($this->request->post);exit;

		date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
		$date_time = date('Y-m-d H:i:s');

		if(isset($_FILES["screenshot"]["name"]) && $_FILES["screenshot"]["name"] != ''){	
			$target_file = DIR_IMAGE . "screenshot/" .basename($_FILES["screenshot"]["name"]);
			move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file);
			$file_name = "screenshot/" . basename($_FILES["screenshot"]["name"]);
			$screenshot = $file_name;
		} else {
			$screenshot = $data['screenshot_path'];
		}

		$current_remark = $this->db->query("SELECT remark FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'")->row['remark'];

		if ($data['remark'] !== $current_remark) {
		  	$task = $this->db->query("SELECT notification FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'");
			$notification = $task->row['notification'];

			// Alternate between 0 and 1
			if ($notification == 1) {
			    $notify = 0;
			} else {
			    $notify = 1;
			}
		} else {
		  // The remark is the same as before, so don't update the notification field
		  $notify = $data['notification'];
		}

		// Update the task record
		$this->db->query("UPDATE " . DB_PREFIX . "task SET
		  screenshot_path = '" . $file_name . "',
		  username = '" . $this->db->escape($data['username']) . "',
		  project_id = '" . $this->db->escape($data['project_id']) . "',
		  user_id = '" . $this->db->escape($data['user_id']) . "',
		  subject = '" . $this->db->escape($data['subject']) . "',
		  remark = '" . $this->db->escape($data['remark']) . "',
		  project_start_time = '" . $this->db->escape($data['project_start_time']) . "',
		  project_end_time = '" . $this->db->escape($data['project_end_time']) . "',
		  task = '" . $this->db->escape($data['task']) . "',
		  status = '" . $this->db->escape($data['status']) . "',
		  notification = '" . $notify . "',
		  date_time = '" . $date_time . "',
		  commit_no = '" . $this->db->escape($data['commit_no']) . "'
		WHERE task_id = '" . (int)$task_id . "'");

		$this->cache->delete('task');
	}

	public function deleteTask($task_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'");

		$this->cache->delete('task');
	}

	public function gettask($task_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'task_id=" . (int)$task_id . "') AS keyword FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'");
		return $query->row;
	}

	public function autocompletetas($data = array()){
		// echo "<pre>";print_r($data);exit;
		$sql = "SELECT * FROM oc_project WHERE 1=1";

		if (!empty($data['filter_project'])) {
			$sql .= " AND project_name LIKE '" . $this->db->escape($data['filter_project']) . "%'";
		}

		$sql .= " GROUP BY project_name";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function autocomplete2($data = array()){
		// echo "<pre>";print_r($data);exit;
		$sql = "SELECT * FROM oc_user WHERE 1=1";

		if (!empty($data['username'])) {
			$sql .= " AND username LIKE '" . $this->db->escape($data['username']) . "%'";
		}

		$sql .= " GROUP BY username";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTasksByUserId($user_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "task WHERE user_id = '" . (int)$user_id . "'");

    return $query->rows;
    }


	public function getTasks($data = array()) {

		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		// echo "<pre>";print_r($user_group_id);exit;
		if ($user_group_id == 11) {
			$sql = "SELECT * FROM " . DB_PREFIX . "task";
			$sql .= " WHERE user_id LIKE '" . $user_id . "%'";

			if (!empty($data['project_id'])) {
				$sql .= " AND project_id LIKE '" . $this->db->escape($data['project_id']) . "%'";
			}

			if (!empty($data['status'])) {
				$sql .= " AND status LIKE '" . $this->db->escape($data['status']) . "%'";
			}

		} elseif($user_group_id == 1) {
			$sql = "SELECT * FROM " . DB_PREFIX . "task WHERE 1=1";

			if (!empty($data['project_id'])) {
				$sql .= " AND project_id = '" . $this->db->escape($data['project_id']) . "%'";
			}

			if (!empty($data['user_id'])) {
				$sql .= " AND user_id = '" . $this->db->escape($data['user_id']) . "%'";
			}

			if (!empty($data['status'])) {
				$sql .= " AND status LIKE '" . $this->db->escape($data['status']) . "%'";
			}
		} elseif ($user_group_id == 12) {
			$project_id = $this->db->query("SELECT project_id FROM oc_project WHERE user_id = '$user_id'")->row;
			$p_id = $project_id['project_id'];
			$sql = "SELECT * FROM " . DB_PREFIX . "task";
			$sql .= " WHERE project_id = '$p_id'";
			if (!empty($data['status'])) {
				$sql .= " AND status LIKE '" . $this->db->escape($data['status']) . "%'";
			}
			// echo "<pre>";print_r($sql);exit;
		}

		// echo "<pre>";print_r($sql);exit;

		$sort_data = array(
			'project_id',
			'user_id',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY date_time";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

	public function getTotalTasks($data = array()) {

		$user_group_id = $this->user->user_group_id;
		$user_id = $this->session->data['user_id'];

		if($user_group_id == 1){
			$query = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "task WHERE 1=1";
            	if (!empty($data['project_id'])) {
				$query .= " AND project_id = '" . $this->db->escape($data['project_id']) . "%'";
			}

			if (!empty($data['user_id'])) {
				$query .= " AND user_id = '" . $this->db->escape($data['user_id']) . "%'";
			}

			if (!empty($data['status'])) {
				$query .= " AND status LIKE '" . $this->db->escape($data['status']) . "%'";
			}
		}elseif($user_group_id == 11){
			$query = "SELECT COUNT(*) AS total FROM " . DB_PREFIX ."task WHERE user_id = $user_id";
			if (!empty($data['project_id'])) {
				$query .= " AND project_id LIKE '" . $this->db->escape($data['project_id']) . "%'";
			}

			if (!empty($data['status'])) {
				$query .= " AND status LIKE '" . $this->db->escape($data['status']) . "%'";
			}
		// echo "<pre>";print_r($query);exit;
		}elseif($user_group_id == 12){
			$project_id = $this->db->query("SELECT project_id FROM oc_project WHERE user_id = '$user_id'")->row;
			$p_id = $project_id['project_id'];
			$query = "SELECT COUNT(*) AS total FROM " . DB_PREFIX ."task WHERE project_id = $p_id";
			if (!empty($data['status'])) {
				$query .= " AND status LIKE '" . $this->db->escape($data['status']) . "%'";
			}
		}
        
        $sql = $this->db->query($query);
		return $sql->row['total'];
	}
}

