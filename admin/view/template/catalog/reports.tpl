<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $export; ?>" title="Export report" class="btn btn-primary"><i class="fa fa-download"></i> Export report</a>
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
        <h3 class="panel-title"><i class="fa fa-list"></i>Attendance Report</h3>
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
              <div class="col-sm-3" style="text-align: start;">
                <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                <button type="button" id="button-clear" class="btn btn-primary pull-right"><i class="fa fa-trash-o"></i> <?php echo $button_clear; ?></button>
              </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left">Name</td>
            <!-- </tr>
            <tr> -->
              <td class="text-left">Parameter</td>
              <?php foreach ($attendances_header as $header) { ?>
                <td class="text-left"><?php echo date('d-m-y', strtotime($header['date'])); ?></td>
              <?php }?>
            </tr>
          </thead>
          <tbody>
            <?php if ($attendances_body) { ?>
              <?php foreach ($username as $user) { ?>
                
                <tr>
                <?php foreach ($attendances_header as $header) { ?>
                
              <?php }?>
                  <td class="text-left" rowspan="2"><?php echo $user['name']; ?></td>
                  <td class="text-left">Status</td>
                  <?php foreach ($attendances_header as $header) { ?>
                    <?php $found = false; ?>
                    <?php foreach ($attendances_body as $body) { ?>
                      <?php if ($body['name'] == $user['name'] && $body['date'] == $header['date']) { ?>
                        <td class="text-left"><?php echo $body['status']; $found = true; ?></td>
                        <?php } ?>
                    <?php } ?>
                    <?php if (!$found) { ?>
                      <td class="text-left"></td>
                    <?php } ?>
                  <?php } ?>
                </tr>


                <tr>
                  <!-- <td class="text-left"><?php echo $user['name']; ?></td> -->
                  <td class="text-left">Time</td>
                  <?php foreach ($attendances_header as $header) { ?>
                    <?php $found = false; ?>
                    <?php foreach ($attendances_body as $body) { ?>
                      <?php if ($body['name'] == $user['name'] && $body['date'] == $header['date']) { ?>
                        <td class="text-leftfound <?php if (date('H:i', strtotime($body['office_in_time'])) > '10:00:00') echo 'text-danger'; ?>"><?php echo $body['office_in_time']; $found = true; ?></td>
                      <?php } ?>
                    <?php } ?>
                    <?php if (!$found) { ?>
                      <td class="text-left"></td>
                    <?php } ?>
                  <?php } ?>
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
  var url = 'index.php?route=catalog/reports&token=<?php echo $token; ?>';

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
<script type="text/javascript">
$('#button-clear').on('click', function() {
	var url = 'index.php?route=catalog/reports&token=<?php echo $token; ?>';
  location = url;
});
</script>