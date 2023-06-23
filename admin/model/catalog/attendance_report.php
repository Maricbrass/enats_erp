<?php
class ModelCatalogTaskReport extends Model {

  public function getTasks($data = array()) {


    if (!empty($data['fromdate']) && !empty($data['todate'])) {
      $from_date = date('Y-m-d H:i:s', strtotime($data['fromdate']));
      $to_date = date('Y-m-d H:i:s', strtotime($data['todate']));
      $sql .= " AND DATE(date_time) >= '" . $this->db->escape($from_date) . "' AND DATE(date_time) <= '" . $this->db->escape($to_date) . "'";
    }elseif(!empty($data['fromdate'])){
      $from_date = date('Y-m-d', strtotime($data['fromdate']));
      $sql .= " AND DATE(date_time) =  '" . $this->db->escape($from_date) . "'";
      // echo "<pre>";print_r($sql);exit;
    }elseif(!empty($data['todate'])){
      $to_date = date('Y-m-d H:i:s', strtotime($data['todate']));
      $sql .= " AND DATE(date_time) = '" . $this->db->escape($to_date) . "'";
    }

    $query = $this->db->query($sql);

    // echo "<pre>";print_r($query->rows);exit;

    return $query->rows;
  }

}
?>