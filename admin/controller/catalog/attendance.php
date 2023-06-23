<?php
class ControllerCatalogAttendance extends Controller {
	private $error = array();

	public function index() {

		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}
		// echo "<pre>";print_r($name_of_user);exit;

		$this->load->language('catalog/attendance');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/attendance');

		if ($user_group_id == 11) {
			$this->getForm();
		}	else {
			$this->getList();
		}
	}

	public function add() {
		// echo "<pre>";print_r($this->request->post);exit;
		// echo "<pre>";print_r($this->request->post['date']);exit;
		$this->load->language('catalog/attendance');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/attendance');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_attendance->addattendance($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		//echo "<pre>";print_r($this->request->post);exit;

		$this->load->language('catalog/attendance');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/attendance');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_catalog_attendance->editattendance($this->request->get['attendance_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/attendance');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/attendance');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $attendance_id) {
				$this->model_catalog_attendance->deleteattendance($attendance_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['start_time'])) {
			$start_time = $this->request->get['start_time'];
		} else {
			$start_time = null;
		}

		if (isset($this->request->get['end_time'])) {
			$end_time = $this->request->get['end_time'];
		} else {
			$end_time = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/attendance/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/attendance/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['attendances'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'start_time'  => $start_time,
			'end_time'  => $end_time,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);


		$attendance_total = $this->model_catalog_attendance->getTotalattendances($filter_data);

		$results = $this->model_catalog_attendance->getAttendances($filter_data);

		// echo "<pre>";print_r($results);exit;
		foreach ($results as $result) {
			$data['attendances'][] = array(
				'attendance_id'	  => $result['attendance_id'],
				'name'            => $result['name'],
				'office_in_time'  => $result['office_in_time'],
				'time'       => $result['time'],
				'date'       => date("d-m-Y",strtotime($result['date'])),
				'edit'            => $this->url->link('catalog/attendance/edit', 'token=' . $this->session->data['token'] . '&attendance_id=' . $result['attendance_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_filter'] = $this->language->get('text_filter');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_office_in_time'] = $this->language->get('column_office_in_time');
		$data['column_date_time'] = $this->language->get('column_date_time');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_office_in_time'] = $this->language->get('entry_office_in_time');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		$data['token'] = $this->session->data['token'];
		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['office_in_time'])) {
			$data['error_time'] = $this->error['office_in_time'];
		} else {
			$data['error_time'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['start_time'])) {
			$url .= '&start_time=' . $this->request->get['start_time'];
		}

		if (isset($this->request->get['end_time'])) {
			$url .= '&end_time=' . $this->request->get['end_time'];
		}

		$data['filter_name'] = $filter_name;
	    $data['start_time'] = $start_time;
	    $data['end_time'] = $end_time;

		$pagination = new Pagination();
        $pagination->total = $attendance_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($attendance_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($attendance_total - $this->config->get('config_limit_admin'))) ? $attendance_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $attendance_total, ceil($attendance_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/attendance_list', $data));
	}

	protected function getForm() {

		$data['user_group_id'] = $this->user->user_group_id;
		// echo "<pre>";print_r($data);exit;
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['attendance_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_office_in_time'] = $this->language->get('entry_office_in_time');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['office_in_time'])) {
			$data['error_time'] = $this->error['office_in_time'];
		} else {
			$data['error_time'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['attendance_id'])) {
			$data['action'] = $this->url->link('catalog/attendance/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/attendance/edit', 'token=' . $this->session->data['token'] . '&attendance_id=' . $this->request->get['attendance_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/attendance', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['attendance_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$attendance_info = $this->model_catalog_attendance->getattendance($this->request->get['attendance_id']);
		}


		$data['token'] = $this->session->data['token'];

		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		// echo "<pre>";print_r($user_group_id);exit;
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($attendance_info)) {
			$data['name'] = $attendance_info['name'];
		}elseif(!empty($name_of_user) && ($user_group_id != 1)){
			$data['name'] = $name_of_user;
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['office_in_time'])) {
			$data['office_in_time'] = $this->request->post['office_in_time'];
		} elseif (!empty($attendance_info)) {
			$data['office_in_time'] = $attendance_info['office_in_time'];
		} else {
			$data['office_in_time'] = '';
		}

		if (isset($this->request->post['user_id'])) {
			$data['user_id'] = $this->request->post['user_id'];
		} elseif (!empty($attendance_info)) {
			$data['user_id'] = $attendance_info['user_id'];
		} elseif(!empty($user_id) && ($user_group_id != 1)){
			$data['user_id'] = $user_id;
		} else {
			$data['user_id'] = '';
		}

		if (isset($this->request->post['date'])) {
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($attendance_info)) {
			$data['date'] = $attendance_info['date'];
		} else {
			$data['date'] = '';
		}

		if (isset($this->request->post['time'])) {
			$data['time'] = $this->request->post['time'];
		} elseif (!empty($attendance_info)) {
			$data['time'] = $attendance_info['time'];
		} else {
			$data['time'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/attendance_form', $data));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/attendance');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_attendance->autocompleteatt2($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'user_id' => $result['user_id'],
					'firstname'            => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['firstname'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validateForm() {


		if (!$this->user->hasPermission('modify', 'catalog/employee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// echo "<pre>";print_r($this->request->post['office_in_time']);exit;
		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (isset($this->request->post['date'])){
			$date = $this->request->post['date'];
			$user_id = $this->request->post['user_id'];
			$validate_date = $this->db->query("SELECT user_id FROM `oc_attendance_record` WHERE `date` = '$date' AND `user_id` = '$user_id'")->row;
			if ($validate_date['user_id'] == $user_id) {
				$this->error['office_in_time'] = $this->language->get('Already marked');
			}
		}

		if ((utf8_strlen($this->request->post['office_in_time']) < 4) || (utf8_strlen($this->request->post['office_in_time']) > 64)) {
			$this->error['office_in_time'] = $this->language->get('error_time');
		}

		return !$this->error;
	}

	public function autocomplete2() {
		$json = array();

		if (isset($this->request->get['name'])) {
			$this->load->model('catalog/attendance');

			$filter_data = array(
				'name' => $this->request->get['name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_attendance->autocompleteatt2($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'user_id' => $result['user_id'],
					'firstname' => $result['firstname'],
					'name'            => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}