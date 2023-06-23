<?php
class Controllercatalogexptask extends Controller {
   public function index() {
    $month_start = date('Y-m-01');
    $month_end = date('Y-m-t');
    $task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) BETWEEN '".$month_start."' AND '".$month_end."'")->rows;
    $csv_data = array(
        array('Date', 'Project Name', 'Username','Employee','Remark','Subject','Start Date', 'Project Start Time', 'Project End Time', 'Task', 'Status', 'Commit No')
    );
    foreach ($task_data as $task){
        $user_id = $task['user_id'];
        $user = $this->db->query("SELECT username FROM oc_user WHERE user_id = $user_id")->row;
        $project_id = $task['project_id'];
        $project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
        $csv_data[] = array(
            $task['date_time'],
            $project['project_name'],
            $task['username'],
            $user['username'],
            $task['remark'],
            $task['subject'],
            $task['date'],
            $task['project_start_time'],
            $task['project_end_time'],
            $task['task'],
            $task['status'],
            $task['commit_no']
        );
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Task report.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    foreach ($csv_data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

}
?>
