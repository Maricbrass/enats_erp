<?php
class ControllerCatalogEmployee extends Controller {
	private $error = array();

	public function index() {

		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		// echo "<pre>";print_r($user_group_id);exit;

		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/employee');

		$this->getList();
	}

	public function add() {

		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		

		$this->load->model('catalog/employee');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_employee->addEmployee($this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		// echo "<pre>";print_r($this->request->post);exit;
		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/employee');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm($this->request->get['employee_id'])) {
			$this->model_catalog_employee->editEmployee($this->request->get['employee_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		// echo "<pre>";print_r($this->request->post);exit;
		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/employee');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $employee_id) {
				$this->model_catalog_employee->deleteEmployee($employee_id);
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

			$this->response->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_numbers'])) {
			$filter_numbers = $this->request->get['filter_numbers'];
		} else {
			$filter_numbers = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_numbers'])) {
			$url .= '&filter_numbers=' . urlencode(html_entity_decode($this->request->get['filter_numbers'], ENT_QUOTES, 'UTF-8'));
		}

        if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
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
			'href' => $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/employee/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/employee/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['token'] = $this->session->data['token'];

		$data['employees'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_numbers'	  => $filter_numbers,
			'filter_email'	  => $filter_email,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$employee_total = $this->model_catalog_employee->getTotalEmployees();

		$results = $this->model_catalog_employee->getEmployees($filter_data);
		// echo "<pre>";print_r($results);exit;

		foreach ($results as $result) {
			$data['employees'][] = array(
				'employee_id' => $result['employee_id'],
				'name'        => $result['name'],
				'name'        => $result['name'],
				'numbers'     => $result['numbers'],
				'doje'        =>date("d-m-Y",strtotime($result['doje'])),
				'email'       => $result['email'],
				'address'     => $result['address'],
				'dob'         => date("d-m-Y",strtotime($result['dob'])),
				'edit'        => $this->url->link('catalog/employee/edit', 'token=' . $this->session->data['token'] . '&employee_id=' . $result['employee_id'] . $url, true)
			);
		}

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_numbers'  => $filter_numbers,
			'filter_email'	  => $filter_email,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_filter'] = $this->language->get('text_filter');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_address'] = $this->language->get('column_address');
		$data['column_numbers'] = $this->language->get('column_numbers');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_address'] = $this->language->get('column_address');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_numbers'] = $this->language->get('entry_numbers');
		$data['entry_email'] = $this->language->get('entry_email');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');


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

		$data['sort_name'] = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

	    $data['filter_name'] = $filter_name;
	    $data['filter_numbers'] = $filter_numbers;
	    $data['filter_email'] = $filter_email;

		$pagination = new Pagination();
		$pagination->total = $employee_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($employee_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($employee_total - $this->config->get('config_limit_admin'))) ? $employee_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $employee_total, ceil($employee_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['export'] = $this->url->link('catalog/employee/export', 'token=' . $this->session->data['token'] . $url, true);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/employee_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['employee_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_country'] = $this->language->get('text_country');
	    $data['text_experienced'] = $this->language->get('text_experienced');
	    $data['text_fresher'] = $this->language->get('text_fresher');
  

        $data['entry_login'] = $this->language->get('entry_login');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_father_name'] = $this->language->get('entry_father_name');
		$data['entry_surname'] = $this->language->get('entry_surname');
		$data['entry_dob'] = $this->language->get('entry_dob');
		$data['entry_doje'] = $this->language->get('entry_doje');
		$data['entry_dole'] = $this->language->get('entry_dole');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_numbers'] = $this->language->get('entry_numbers');
		$data['entry_pan'] = $this->language->get('entry_pan');
		$data['entry_adhaar'] = $this->language->get('entry_adhaar');
		$data['entry_bank_details'] = $this->language->get('entry_bank_details');
		$data['entry_emergency_contact_person_details'] = $this->language->get('entry_emergency_contact_person_details');
		$data['entry_emergency_contact_person_details1'] = $this->language->get('entry_emergency_contact_person_details1');
		$data['entry_laptop_model'] = $this->language->get('entry_laptop_model');
		
		$data['help_keyword'] = $this->language->get('help_keyword');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_upload'] = $this->language->get('button_upload');

		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

        if (isset($this->error['login'])) {
			$data['error_login'] = $this->error['login'];
		} else {
			$data['error_login'] = '';
		}

		if (isset($this->error['father_name'])) {
			$data['error_father_name'] = $this->error['father_name'];
		} else {
			$data['error_father_name'] = '';
		}
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		if (isset($this->error['surname'])) {
			$data['error_surname'] = $this->error['surname'];
		} else {
			$data['error_surname'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['numbers'])) {
			$data['error_numbers'] = $this->error['numbers'];
		} else {
			$data['error_numbers'] = '';
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}

		if (isset($this->error['doje'])) {
			$data['error_doje'] = $this->error['doje'];
		} else {
			$data['error_doje'] = '';
		}

		if (isset($this->error['dole'])) {
			$data['error_dole'] = $this->error['dole'];
		} else {
			$data['error_dole'] = '';
		}
		if (isset($this->error['dob'])) {
			$data['error_dob'] = $this->error['dob'];
		} else {
			$data['error_dob'] = '';
		}
		if (isset($this->error['pan'])) {
			$data['error_pan'] = $this->error['pan'];
		} else {
			$data['error_pan'] = '';
		}
		if (isset($this->error['adhaar'])) {
			$data['error_adhaar'] = $this->error['adhaar'];
		} else {
			$data['error_adhaar'] = '';
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
			'href' => $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['employee_id'])) {
			$data['action'] = $this->url->link('catalog/employee/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/employee/edit', 'token=' . $this->session->data['token'] . '&employee_id=' . $this->request->get['employee_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['employee_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$employee_info = $this->model_catalog_employee->getEmployee($this->request->get['employee_id']);
		}
		// echo "<pre>";print_r($employee_info);exit;
		$data['token'] = $this->session->data['token'];

		$user_id = $this->session->data['user_id'];

		if ($user_id != 1){
			$data['user_id'] = $this->session->data['user_id'];
		} elseif (!empty($employee_info)){
			$data['user_id'] = $employee_info['user_id'];
		} else {
			$data['user_id'] = '';
		}
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		if (isset($this->request->get['employee_id'])) {
			$data['employee_id'] =	$this->request->get['employee_id'];
		} else {
			$data['employee_id'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($employee_info)) {
			$data['name'] = $employee_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['login'])) {
			$data['login'] = $this->request->post['login'];
		} elseif (!empty($employee_info)) {
			$data['login'] = $employee_info['login'];
		}elseif(!empty($name_of_user) && ($user_group_id != 1)){
			$data['login'] = $name_of_user;
		} else {
			$data['login'] = '';
		}

		if (isset($this->request->post['father_name'])) {
			$data['father_name'] = $this->request->post['father_name'];
		} elseif (!empty($employee_info)) {
			$data['father_name'] = $employee_info['father_name'];
		} else {
			$data['father_name'] = '';
		}	
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($employee_info)) {
			$data['email'] = $employee_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['surname'])) {
			$data['surname'] = $this->request->post['surname'];
		} elseif (!empty($employee_info)) {
			$data['surname'] = $employee_info['surname'];
		} else {
			$data['surname'] = '';
		}

		if (isset($this->request->post['numbers'])) {
			$data['numbers'] = $this->request->post['numbers'];
		} elseif (!empty($employee_info)) {
			$data['numbers'] = $employee_info['numbers'];
		} else {
			$data['numbers'] = '';
		}

		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($employee_info)) {
			$data['address'] = $employee_info['address'];
		} else {
			$data['address'] = '';
		}

		if (isset($this->request->post['dob'])) {
			$data['dob'] = $this->request->post['dob'];
		} elseif (!empty($employee_info)) {
			$data['dob'] = $employee_info['dob'];
		} else {
			$data['dob'] = '';
		}

		if (isset($this->request->post['doje'])) {
			$data['doje'] = $this->request->post['doje'];
		} elseif (!empty($employee_info)) {
			$data['doje'] = $employee_info['doje'];
		} else {
			$data['doje'] = '';
		}

		if (isset($this->request->post['dole'])) {
			$data['dole'] = $this->request->post['dole'];
		} elseif (!empty($employee_info)) {
			$data['dole'] = $employee_info['dole'];
		} else {
			$data['dole'] = '';
		}

		if (isset($this->request->post['pan_no'])) {
			$data['pan_no'] = $this->request->post['pan_no'];
		} elseif (!empty($employee_info)) {
			$data['pan_no'] = $employee_info['pan'];
		} else {
			$data['pan_no'] = '';
		}

		if (isset($this->request->files['pan'])) {
			$target_file = DIR_IMAGE . basename($_FILES["pan"]["name"]);
		    move_uploaded_file($_FILES["pan"]["tmp_name"], $target_file);
			$data['pan'] = $target_file;
		} elseif (!empty($employee_info)) {
			$data['pan'] = $employee_info['pan_path'];
			$data['pan_path'] = $employee_info['pan_path'];
		} else {
			$data['pan'] = '';
			$data['pan_path'] = '';
		}

		if (isset($this->request->post['adhaar_no'])) {
			$data['adhaar_no'] = $this->request->post['adhaar_no'];
		} elseif (!empty($employee_info)) {
			$data['adhaar_no'] = $employee_info['adhaar'];
		} else {
			$data['adhaar_no'] = '';
		}

		if (isset($this->request->files['adhaar'])) {
			$target_file = DIR_IMAGE . basename($_FILES["adhaar"]["name"]);
		    move_uploaded_file($_FILES["adhaar"]["tmp_name"], $target_file);
			$data['adhaar'] = $target_file;
		} elseif (!empty($employee_info)) {
			$data['adhaar'] = $employee_info['adhaar_path'];
			$data['adhaar_path'] = $employee_info['adhaar_path'];
		} else {
			$data['adhaar'] = '';
			$data['adhaar_path'] = '';
		}

		if (isset($this->request->post['bank_details'])) {
			$data['bank_details'] = $this->request->post['bank_details'];
		} elseif (!empty($employee_info)) {
			$data['bank_details'] = $employee_info['bank_details'];
		} else {
			$data['bank_details'] = '';
		}

		if (isset($this->request->files['bank'])) {
			$target_file = DIR_IMAGE . basename($_FILES["bank"]["name"]);
		    move_uploaded_file($_FILES["bank"]["tmp_name"], $target_file);
			$data['bank'] = $target_file;
		} elseif (!empty($employee_info)) {
			$data['bank'] = $employee_info['bank_path'];
			$data['bank_path'] = $employee_info['bank_path'];
		} else {
			$data['bank'] = '';
			$data['bank_path'] = '';
		}

		if (isset($this->request->post['emergency_contact_person_details'])) {
			$data['emergency_contact_person_details'] = $this->request->post['emergency_contact_person_details'];
		} elseif (!empty($employee_info)) {
			$data['emergency_contact_person_details'] = $employee_info['emergency_contact_person_details'];
		} else {
			$data['emergency_contact_person_details'] = '';
		}

		if (isset($this->request->post['emergency_contact_person_details1'])) {
			$data['emergency_contact_person_details1'] = $this->request->post['emergency_contact_person_details1'];
		} elseif (!empty($employee_info)) {
			$data['emergency_contact_person_details1'] = $employee_info['emergency_contact_person_details1'];
		} else {
			$data['emergency_contact_person_details1'] = '';
		}

		// echo "<pre>";print_r($data);exit;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/employee_form', $data));
	}

	protected function validateForm() {


		if (!$this->user->hasPermission('modify', 'catalog/employee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!isset($this->request->get['employee_id'])){
			$user_id = $this->request->post['user_id'];
			$validate_exits = $this->db->query("SELECT user_id FROM oc_employee WHERE user_id = '$user_id'")->row;
			if ($validate_exits['user_id'] == $user_id) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
		}

		if(!empty($this->request->get['employee_id'])) {
			$employee_id = $this->request->get['employee_id'];
			$validate_user = $this->db->query("SELECT user_id FROM oc_employee WHERE employee_id = '$employee_id'")->row;
			if ($validate_user['user_id'] != $this->session->data['user_id'] && $this->session->data['user_id'] != 1) {
				$this->error['warning'] = $this->language->get('error_permission');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
	    $this->load->language('catalog/employee');

	    if (!$this->user->hasPermission('modify', 'catalog/employee')) {
	        $this->error['warning'] = $this->language->get('error_permission');
	    }

	    $this->load->model('catalog/employee');
	    $this->load->model('catalog/task');

	    foreach ($this->request->post['selected'] as $employee_id) {
	        $employee = $this->model_catalog_employee->getEmployee($employee_id);
	        $tasks = $this->model_catalog_task->getTasksByUserId($employee['user_id']);
	        if ($tasks) {
	            $this->error['warning'] = $this->language->get('error_employee_task');
	            break;
	        }
	    }

	    return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'employee_id' => $result['employee_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			// echo "<pre>";print_r($value);exit;
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete1() {
		// echo "<pre>";print_r($this->request->get);exit;
		$json = array();

		if (isset($this->request->get['filter_numbers'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'filter_numbers' => $this->request->get['filter_numbers'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp1($filter_data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'employee_id' => $result['employee_id'],
					'numbers'            => strip_tags(html_entity_decode($result['numbers'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['numbers'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function autocomplete2() {
		// echo "<pre>";print_r($this->request->get);exit;
		$json = array();

		if (isset($this->request->get['filter_email'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'filter_email' => $this->request->get['filter_email'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp2($filter_data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'employee_id' => $result['employee_id'],
					'email'            => strip_tags(html_entity_decode($result['email'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['email'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function autocomplete3() {
		// echo "<pre>";print_r($this->request->get['login']);exit;
		$json = array();

		if (isset($this->request->get['login'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'login' => $this->request->get['login'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp3($filter_data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'user_id' => $result['user_id'],
					'firstname' => $result['firstname'],
					'lastname' => $result['lastname'],
					'email' => $result['email'],
					'username'            => strip_tags(html_entity_decode($result['username'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['username'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function export() {
        $employee_data = "SELECT * FROM " . DB_PREFIX . "employee WHERE 1=1";
        $employees = $this->db->query($employee_data)->rows;
        // echo "<pre>";print_r($employee);exit;

        // $task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) BETWEEN '".$month_start."' AND '".$month_end."'")->rows;
        $csv_data = array(
            array('Name','Father name','Surname','Date of Birth','Number','Email','Address','Date of Joining','Date of Leaving','PAN number','Adhaar number','Bank Details','Emergency Contact')
        );
        foreach ($employees as $employee){
	        $csv_data[] = array(
	            'name'                      => $employee['name'],
	            'father_name'				=> $employee['father_name'],
	            'surname'					=> $employee['surname'],
	            'dob'						=> $employee['dob'],
	            'numbers'					=> $employee['numbers'],
	            'email'						=> $employee['email'],
	            'address'					=> $employee['address'],
	            'doje'						=> $employee['doje'],
	            'dole'						=> $employee['dole'],
	            'pan'						=> $employee['pan'],
	            'adhaar'					=> $employee['adhaar'],
	            'bank_details'				=> $employee['bank_details'],
	            'emergency_contact'			=> $employee['emergency_contact_person_details'] ." | ". $employee['emergency_contact_person_details1'] 
	        );
        }
        // echo "<pre>";print_r($csv_data);exit;
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Employee.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        foreach ($csv_data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }
}