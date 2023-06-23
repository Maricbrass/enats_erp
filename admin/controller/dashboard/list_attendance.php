<?php
class Controllerdashboardlistattendance extends Controller {
	public function index() {
		$this->load->language('dashboard/list_attendance');

		$data['token'] = $this->session->data['token'];
		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user_group_id;
		}

		if ($user_group_id == 1) {
			$current_date = date("Y-m-d");
			// echo "<pre>";print_r($current_date);exit;
			$data['attendances'] = $this->db->query("SELECT * FROM oc_attendance_record WHERE date = '$current_date' ORDER BY attendance_id DESC")->rows;
		}else {
			$data['attendances'] = $this->db->query("SELECT * FROM oc_attendance_record WHERE user_id = '$user_id' ORDER BY attendance_id DESC LIMIT 8")->rows;
		}

		return $this->load->view('dashboard/list_attendance', $data);
	}
}