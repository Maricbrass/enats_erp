<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-list"></i>Attendance List</h3>
  </div>
  <div class="panel-body"></div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <?php if ($user_group_id == 1) {?>
            <td class="text-left">Name</td>
          <?php }?>
          <td class="text-left">Office in time</td>
          <td class="text-left">Date and time of attendance</td>
        </tr>
      </thead>
      <tbody>
        <?php if ($attendances) { ?>
        <?php foreach ($attendances as $attendance) {
        // echo "<pre>";print_r($manufacturers);exit; ?>
        <tr>
        <?php if ($user_group_id == 1) {?>
          <td class="text-left"><?php echo $attendance['name']; ?></td>
        <?php }?>
        <td class="text-left <?php if (date('H:i', strtotime($attendance['office_in_time'])) > '10:00:00') echo 'text-danger'; ?>"><?php echo $attendance['office_in_time']; ?></td>
        <td class="text-left"><?php echo $attendance['date'] . ' | ' . $attendance['time']; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
        <td class="text-center" colspan="7">No result</td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>