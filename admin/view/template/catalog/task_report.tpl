<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" title="Export report" class="btn btn-primary"><i class="fa fa-download"></i> Export report</a>
      </div>
      <h1>Report</h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>">Reports</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i>Task Report</h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row" style="align-items: end; display: flex;">
            <div class="col-sm-2">
              <div class="form-group" style="padding: 0;">
                <label class="control-label" for="input-project">Start Date</label>
                <input type="date" name="fromdate" value="<?php echo $fromdate; ?>" id="input-fromdate" class="form-control" />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group" style="padding: 0;">
                <label class="control-label" for="input-project">End Date</label>
                <input type="date" name="todate" value="<?php echo $todate; ?>" id="input-todate" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group" style="padding: 0;">
                <label class="control-label" for="input-project">Project Name</label>
                <select name="project_id" id="project_id" class="dropdown-header form-control">
                  <?php foreach ($project as $skey => $svalue) { //echo "<pre>";print_r($project_id);exit; 
                  ?>
                    <?php if ($skey == $project_id) { ?>
                      <option value="<?php echo $skey ?>" class="dropdown-manu form-control" selected="selected"><?php echo $svalue; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $skey ?>" class="dropdown-manu form-control"><?php echo $svalue ?></option>
                    <?php } ?>
                  <?php } ?>
                  <option value="" selected="selected" class="dropdown-manu form-control">Select project</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group" style="padding: 0;">
                <label class="control-label" for="input-user_id">User</label>
                <select name="user_id" id="user_id" class="dropdown form-control">
                  <?php foreach ($username as $skey => $svalue) { //echo "<pre>";print_r($user_id);exit; 
                  ?>
                    <?php if ($skey == $user_id) { ?>
                      <option value="<?php echo $skey ?>" class="dropdown-manu form-control" selected="selected"><?php echo $svalue; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $skey ?>" class="dropdown-manu form-control"><?php echo $svalue ?></option>
                    <?php } ?>
                  <?php } ?>
                  <option value="" selected="selected" class="dropdown-manu form-control">Select User</option>
                </select>
              </div>
            </div>
             <div class="col-sm-4">
              <div class="form-group" style="padding: 0;">
                <label class="control-label" for="input-project">Status</label>
                <select name="status" id="status" class="dropdown form-control">
                  <?php if (!$work_status) { //echo $project_id;exit;?>
                    <option value="" selected="selected" class="dropdown-manu form-control">Please select</option>
                  <?php } else { //echo $project_id;exit; ?>
                    <option value="" class="dropdown-manu form-control">Please select</option>
                  <?php } ?>
                  <?php foreach ($work_status as $skey => $svalue) { //echo "<pre>";print_r($user_id);exit; 
                  ?>
                    <?php if ($skey == $status) { ?>
                      <option value="<?php echo $skey ?>" class="dropdown-manu form-control" selected="selected">
                        <?php echo $svalue; ?>
                      </option>
                    <?php } else { ?>
                      <option value="<?php echo $skey ?>" class="dropdown-manu form-control">
                        <?php echo $svalue ?>
                      </option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3" style="text-align: start;">
              <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left">Date</td>
              <td class="text-left">Employee</td>
              <td class="text-left">Project</td>
              <td class="text-left">Username</td>
              <td class="text-left">Subject</td>
              <td class="text-left">Task/problem</td>
              <td class="text-left">Remark</td>
              <td class="text-left">Start Date</td>
              <td class="text-left">Project Start Time</td>
              <td class="text-left">Project End Time</td>
              <td class="text-left">Status</td>
            </tr>
          </thead>
          <tbody>
            <?php if ($tasks) { ?>
              <?php foreach ($tasks as $task) {
                //echo "<pre>";print_r($tasks);exit; 
              ?>
                <tr>
                  <td class="text-left"><?php echo $task['date']; ?></td>
                  <td class="text-left"><?php echo $task['user']; ?></td>
                  <td class="text-left"><?php echo $task['project_name']; ?></td>
                  <td class="text-left"><?php echo $task['username']; ?></td>
                  <td class="text-left"><?php echo $task['subject']; ?></td>
                  <td class="text-left"><?php echo $task['task']; ?></td>
                  <td class="text-left"><?php echo $task['remark']; ?></td>
                  <td class="text-left"><?php echo $task['start_date']; ?></td>
                  <td class="text-left"><?php echo $task['project_start_time']; ?></td>
                  <td class="text-left"><?php echo $task['project_end_time']; ?></td>
                  <td class="text-left"><?php echo $task['status']; ?></td>
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
  </div>
</div>
<script type="text/javascript">
  $('#button-filter').on('click', function() {
    var url = 'index.php?route=catalog/task_report&token=<?php echo $token; ?>';

    var project_id = $('select[name=\'project_id\']').val();

    if (project_id) {
      url += '&project_id=' + encodeURIComponent(project_id);
    }

    var user_id = $('select[name=\'user_id\']').val();

    if (user_id) {
      url += '&user_id=' + encodeURIComponent(user_id);
    }

    var status = $('select[name=\'status\']').val();

    if (status) {
      url += '&status=' + encodeURIComponent(status);
    }

    var fromdate = $('input[name=\'fromdate\']').val();

    if (fromdate) {
      url += '&fromdate=' + encodeURIComponent(fromdate);
    }

    var todate = $('input[name=\'todate\']').val();

    if (todate) {
      url += '&todate=' + encodeURIComponent(todate);
    }

    location = url;
  });
</script>