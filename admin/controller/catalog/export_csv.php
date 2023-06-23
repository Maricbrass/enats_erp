<?php
class Controllercatalogexportcsv extends Controller {
	public function index() {

		$month_start = date('Y-m-01');
		$month_end = date('Y-m-t');
		
		$attendances_header = $this->db->query("SELECT date FROM oc_attendance_record WHERE date BETWEEN '".$month_start."' AND '".$month_end."' GROUP BY date")->rows;
		$attendances_body = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date BETWEEN '".$month_start."' AND '".$month_end."' ORDER BY user_id, date, time")->rows;
		$username = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date BETWEEN '".$month_start."' AND '".$month_end."' GROUP BY user_id")->rows;

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
		exit;
	}
}
?>
