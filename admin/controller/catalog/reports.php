<?php 
class Controllercatalogreports extends Controller {

	public function index() {
			
			$url ="";
			if (isset($this->request->get['fromdate'])) {
	            $fromdate = $this->request->get['fromdate'];
	            $url .= '&fromdate='.$fromdate;
	        } else {
	            $fromdate = '';
	        }

	        if (isset($this->request->get['todate'])) {
	            $todate = $this->request->get['todate'];
	            $url .= '&todate='.$todate;
	        } else {
	            $todate = '';
	        }
			if(!empty($fromdate && $todate)){
				$data['attendances_header'] = $this->db->query("SELECT date FROM oc_attendance_record WHERE date >= '$fromdate' AND date <= '$todate' GROUP BY date")->rows;
				$data['attendances_body'] = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date >= '$fromdate' AND date <= '$todate' ORDER BY user_id, date, time")->rows;

				$data['username'] = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date >= '$fromdate' AND date <= '$todate' GROUP BY user_id")->rows;
			}elseif(!empty($fromdate)){
	        	$data['attendances_header'] = $this->db->query("SELECT date FROM oc_attendance_record WHERE date = '$fromdate' GROUP BY date")->rows;
				$data['attendances_body'] = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date = '$fromdate' ORDER BY user_id, date, time")->rows;

				$data['username'] = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date = '$fromdate' GROUP BY user_id")->rows;
			}elseif(!empty($todate)){
				$data['attendances_header'] = $this->db->query("SELECT date FROM oc_attendance_record WHERE date = '$todate' GROUP BY date")->rows;
				$data['attendances_body'] = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date = '$todate' ORDER BY user_id, date, time")->rows;

				$data['username'] = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date = '$todate' GROUP BY user_id")->rows;
			}else{
				$data['attendances_header'] = $this->db->query("SELECT date FROM oc_attendance_record GROUP BY date ORDER BY date DESC LIMIT 30")->rows;
				$data['attendances_body'] = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record ORDER BY user_id, date, time")->rows;

				$data['username'] = $this->db->query("SELECT user_id, name FROM oc_attendance_record GROUP BY user_id")->rows;
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('catalog/reports', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['url'] = $url;

			$data['button_add'] = $this->language->get('button_add');
			$data['token'] = $this->session->data['token'];
			$data['button_filter'] = $this->language->get('button_filter');
			$data['export'] = $this->url->link('catalog/reports/export', 'token=' . $this->session->data['token'] . $url, true);
			$data['archive'] = $this->url->link('catalog/reports/archive', 'token=' . $this->session->data['token'] . $url, true);
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/reports',$data));
	}
	public function archive() {
		$year = date('Y') - 1;
		$create_table_query = $this->db->query("CREATE TABLE IF NOT EXISTS `oc_attendance_".$year."` LIKE oc_attendance_record;");
		$insert_data = $this->db->query("INSERT IGNORE INTO `oc_attendance_" . $year . "` SELECT * FROM `oc_attendance_record` WHERE YEAR(`date`) = YEAR(NOW()) - 1;");
		$delete_last_data = $this->db->query("DELETE FROM `oc_attendance_record` WHERE YEAR(`date`) = YEAR(NOW()) - 1;");
		$this->response->redirect($this->url->link('catalog/reports', 'token=' . $this->session->data['token'], true));
	}
	public function export() {		
		$url ="";
		if (isset($this->request->get['fromdate'])) {
            $fromdate = $this->request->get['fromdate'];
            $url .= '&fromdate='.$fromdate;
        } else {
            $fromdate = '';
        }

        if (isset($this->request->get['todate'])) {
            $todate = $this->request->get['todate'];
            $url .= '&todate='.$todate;
        } else {
            $todate = '';
        }
		if(!empty($fromdate && $todate)){
			$attendances_header = $this->db->query("SELECT date FROM oc_attendance_record WHERE date >= '$fromdate' AND date <= '$todate' GROUP BY date")->rows;
			$attendances_body = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date >= '$fromdate' AND date <= '$todate' ORDER BY user_id, date, time")->rows;

			$username = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date >= '$fromdate' AND date <= '$todate' GROUP BY user_id")->rows;
		}elseif(!empty($fromdate)){
        	$attendances_header = $this->db->query("SELECT date FROM oc_attendance_record WHERE date = '$fromdate' GROUP BY date")->rows;
			$attendances_body = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date = '$fromdate' ORDER BY user_id, date, time")->rows;

			$username = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date = '$fromdate' GROUP BY user_id")->rows;
		}elseif(!empty($todate)){
			$attendances_header = $this->db->query("SELECT date FROM oc_attendance_record WHERE date = '$todate' GROUP BY date")->rows;
			$attendances_body = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date = '$todate' ORDER BY user_id, date, time")->rows;

			$username = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date = '$todate' GROUP BY user_id")->rows;
		}else{
			$attendances_header = $this->db->query("SELECT date FROM oc_attendance_record GROUP BY date ORDER BY date DESC LIMIT 30")->rows;
			$attendances_body = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record ORDER BY user_id, date, time")->rows;

			$username = $this->db->query("SELECT user_id, name FROM oc_attendance_record GROUP BY user_id")->rows;
		}

		$filename = "Attendance.csv";
		$file_path = DIR_DOWNLOAD .'/'. $filename;
		$fp = fopen($file_path, "w");
		$line = "";
		$line .= "Name";
		foreach($attendances_header as $header){
			$line .= ',' . $header['date'];
		}
		$line .= "\n";
		fputs($fp, $line);
		foreach($username as $user){
			$line = $user['name'];
			foreach($attendances_header as $header) {
				$found = false;
				foreach($attendances_body as $body) {
					if($body['user_id'] == $user['user_id'] && $body['date'] == $header['date']) {
						$line .= ',' . $body['office_in_time'];
						$found = true;
						break;
					}
				}
				if(!$found) {
					$line .= ',';
				}
			}
			$line .= "\n";
			fputs($fp, $line);
		}
		$html = file_get_contents($file_path);
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $html;
	}
}
?>
