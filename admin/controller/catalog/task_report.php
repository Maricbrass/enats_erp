<?php 

class Controllercatalogtaskreport  extends Controller {

	public function index()
	{ 
		$this->document->setTitle($this->language->get('Task Report'));

		$this->load->model('catalog/task_report');

		$this->getList();

	}

	protected function getList()
	{

		$url ='';
		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		if (isset($this->request->get['user_id'])) {
			$user_id = $this->request->get['user_id'];
			$users = $this->db->query("SELECT * FROM oc_user")->rows;
			foreach ($users as $val) {
				$username[$val['user_id']] = $val['firstname'] . ' ' . $val['lastname'];
			}
			$data['username'] = $username;
			$url = '&user_id='.$user_id;
		} else {
			$users = $this->db->query("SELECT * FROM oc_user")->rows;
			foreach ($users as $val) {
				$username[$val['user_id']] = $val['firstname'] . ' ' . $val['lastname'];
			}
			$data['username'] = $username;
			$user_id = 0;
		}

		if (isset($this->request->get['project_id'])) {
			$data['project'] = array();
			$projects = $this->db->query("SELECT * FROM oc_project")->rows;
			foreach ($projects as $val) {
				$pro[$val['project_id']] = $val['project_name'];
			}
			$project_id = $this->request->get['project_id'];
			$data['project'] = $pro;
			$url .= '&project_id='.$project_id;
		} else {
			$data['project'] = array();
			$projects = $this->db->query("SELECT * FROM oc_project")->rows;
			foreach ($projects as $val) {
				$pro[$val['project_id']] = $val['project_name'];
			}
			$project_id = $val['project_id'];
			$data['project'] = $pro;
			$project_id = 0;
		}

		 if (isset($this->request->get['status'])) {
            $status = $this->request->get['status'];

            $work_status = array(
                'assigned' => 'assigned',
                'pending' => 'pending',
                'done' => 'done',
                'left' => 'left',
                'working' => 'working',
                'c/f-working' => 'c/f-working',
                'transfer' => 'transfer'
            );

            $data['work_status'] = $work_status;
        } else {
            $work_status = array(
                'assigned' => 'assigned',
                'pending' => 'pending',
                'done' => 'done',
                'left' => 'left',
                'working' => 'working',
                'c/f-working' => 'c/f-working',
                'transfer' => 'transfer'
            );
            $status = '';
            $data['work_status'] = $work_status;
        }

		if (isset($this->request->get['fromdate'])) {
			$fromdate = $this->request->get['fromdate'];
			$url .= '&fromdate='.$fromdate;
		} else {
			$fromdate = '';
		}

		if (isset($this->request->get['status'])) {
            $url .= '&status=' . $this->request->get['status'];
        }

		if (isset($this->request->get['todate'])) {
			$todate = $this->request->get['todate'];
			$url .= '&todate='.$todate;
		} else {
			$todate = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}


		$data['add'] = $this->url->link('catalog/task_report/export', 'token=' . $this->session->data['token'] . $url, true);

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
			'href' => $this->url->link('catalog/task_report', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['button_add'] = $this->language->get('button_add');
		

		$data['tasks'] = array();
		$data['user_id'] = array();

		$filter_data = array(
			'project_id' => $project_id,
			'user_id' => $user_id,
			'status' => $status,
			'fromdate'  => $fromdate,    
			'todate'  => $todate,    
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$task_data = $this->model_catalog_task_report->getTasks($filter_data);

		$data['tasks'] = array();
		$month_start = date('Y-m-01');
		$month_end = date('Y-m-t');
		// $task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) BETWEEN '".$month_start."' AND '".$month_end."'")->rows;
		foreach ($task_data as $task){
			$user_id = $task['user_id'];
			$user = $this->db->query("SELECT username FROM oc_user WHERE user_id = $user_id")->row;
			$project_id = $task['project_id'];
			$project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
			$data['tasks'][] = array(
				'date' 	        		    =>date("d-m-Y",strtotime($task['date_time'])),
				'project_name'          	=> $project['project_name'],
				'username'          		=> $task['username'],
				'user'          		    => $user['username'],
				'remark'      				=> $task['remark'],
				'subject'          		    => $task['subject'],
				'project_start_time'      	=> $task['project_start_time'],
				'start_date'      	        => date("d-m-Y",strtotime($task['date'])),
				'project_end_time'        	=> $task['project_end_time'],
				'task'   		        	=> $task['task'],
				'status'                	=> $task['status'],
				'commit_no'    				=> $task['commit_no'],
			);
			// echo "<pre>";print_r($data['tasks']);exit;
		}
		// echo "<pre>";print_r($data['tasks']);exit;
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$data['sort'] = $sort;
		$data['order'] = $order;


		$data['project_id'] = $project_id;
		$data['user_id'] = $user_id;
		$data['fromdate'] = $fromdate;
		$data['todate'] = $todate;
		$data['archive'] = $this->url->link('catalog/task_report/archive', 'token=' . $this->session->data['token'] . $url, true);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	   
		$this->response->setOutput($this->load->view('catalog/task_report',$data));
	}

   public function archive() {
	$year = date('Y');
	$create_table_query = $this->db->query("CREATE TABLE IF NOT EXISTS `oc_task_".$year."` LIKE oc_task;");
	// $last_month_start = date($year . '-m-01', strtotime('-1 month'));
	$last_month_end = date($year . '-m-t', strtotime('-1 month'));
	$insert_data = $this->db->query("INSERT IGNORE INTO `oc_task_" . $year . "` SELECT * FROM `oc_task`WHERE CAST(`date_time` AS DATE) <= '" . $last_month_end . "' AND `status` = 'done';");
	$delete_last_data = $this->db->query("DELETE FROM `oc_task` WHERE CAST(`date_time` AS DATE) <= '" . $last_month_end . "' AND `status` = 'done';");
	// echo "<pre>";print_r($delete_last_data);exit;
	$this->response->redirect($this->url->link('catalog/arc_task_report', 'token=' . $this->session->data['token'], true));
	// echo "<pre>";print_r($this->session->data);exit;
}


	public function export() {
		$task_data = "SELECT * FROM " . DB_PREFIX . "task WHERE 1=1";

		if (isset($this->request->get['user_id'])) {
			$user_id = $this->request->get['user_id'];
			$task_data .= " AND user_id = '" . $user_id . "%'";
		}
		if (isset($this->request->get['project_id'])) {
			$project_id = $this->request->get['project_id'];
			$task_data .= " AND project_id = '" . $project_id . "%'";
		}

		if (!empty($this->request->get['fromdate']) && !empty($this->request->get['todate'])) {
		  $from_date = date('Y-m-d H:i:s', strtotime($this->request->get['fromdate']));
		  $to_date = date('Y-m-d H:i:s', strtotime($this->request->get['todate']));
		  $task_data .= " AND DATE(date_time) >= '" . $this->db->escape($from_date) . "' AND DATE(date_time) <= '" . $this->db->escape($to_date) . "'";
		}elseif(!empty($this->request->get['fromdate'])){
		  $from_date = date('Y-m-d', strtotime($this->request->get['fromdate']));
		  $task_data .= " AND DATE(date_time) =  '" . $this->db->escape($from_date) . "'";
		  // echo "<pre>";print_r($task_data);exit;
		}elseif(!empty($this->request->get['todate'])){
		  $to_date = date('Y-m-d H:i:s', strtotime($this->request->get['todate']));
		  $task_data .= " AND DATE(date_time) = '" . $this->db->escape($to_date) . "'";
		}

		if (!empty($this->request->get['status'])) {
				$task_data .= " AND status LIKE '" . $this->db->escape($this->request->get['status']) . "%'";
			}

		$task_data .= " ORDER BY date_time ASC";
		// echo "<pre>";print_r($task_data);exit;
		$tasks = $this->db->query($task_data)->rows;
		$month_start = date('Y-m-01');
		$month_end = date('Y-m-t');
		// $task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) BETWEEN '".$month_start."' AND '".$month_end."'")->rows;
		$csv_data = array(
			array('Date','Employee','Project Name','Username','Subject','Task','Remark','Start Date','Project Start Time','Project End Time','Status','Commit No')
		);
		foreach ($tasks as $task){
			if($task['user_id'] != 0){
				$user_id = $task['user_id'];
				$user = $this->db->query("SELECT username FROM oc_user WHERE user_id = $user_id")->row; 
			}else{
				$user['username'] = '';
			}
			if (!empty($task['project_id'])) {
				$project_id = $task['project_id'];
				$project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
			}else{
				$project['project_name'] = '';
			}
			
			$csv_data[] = array(
				'date'                      => $task['date_time'],
				'employee'                  => $user['username'],
				'project_name'              => $project['project_name'],
				'username'                  => $task['username'],
				'subject'                   => $task['subject'],
				'task'                      => $task['task'],
				'remark'                    => $task['remark'],
				'start_date'                => $task['date'],
				'project_start_time'        => $task['project_start_time'],
				'project_end_time'          => $task['project_end_time'],
				'status'                    => $task['status'],
				'commit_no'                 => $task['commit_no'],
			);
		}
		// echo "<pre>";print_r($csv_data);exit;
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="Task report.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');
		foreach ($csv_data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}
}
?>
