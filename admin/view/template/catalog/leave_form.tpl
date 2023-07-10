<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-leave" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading mb-5">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="well" style="padding: 50px;">
                <label class="col-sm-1 control-label" for="input-date">Date:</label>
                <div class="col-sm-4">
                    <?php if (!empty($date)) { ?>
                        <input type="date" readonly name="date" value="<?php echo $date?>" id="input-date" class="form-control"/>
                    <?php } else { ?>
                        <input type="date" readonly name="date" value="<?=date("Y-m-d");?>" id="input-date" class="form-control"/>
                    <?php } ?>
                </div>
                 <label class="col-sm-1 control-label" for="input-time">Time:</label>
                <div class="col-sm-4">
                    <?php if (!empty($time)) { ?>
                    <input type="text" readonly name="time" value="<?php echo $time; ?>" id="input-time" class="form-control"/>
                    <?php } else {?>
                    <input type="text" readonly name="time" value="<?php date_default_timezone_set('Asia/Kolkata'); echo date("g:i A");?>" id="input-time" class="form-control"/>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($error_warning) { ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php } ?>
                <?php if ($success) { ?>
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php } ?>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-employee" class="form-horizontal">
                  <!-- <div class="form-group required"> -->
                    <!-- <label class="col-sm-1 control-label" for="input-name"><?php echo $entry_name; ?></label>
                        <div class="col-sm-2">
                            <input type="text" name="name" <?php if ($user_group_id != 1) echo "readonly"?> value="<?php echo $name;?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                            <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                            <?php if ($error_name) { ?>
                                <div class="text-danger"><?php echo $error_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-1 control-label" style="" for="input-time"><?php echo $entry_office_in_time; ?></label>
                        <div class="col-sm-2">
                            <input type="time" name="office_in_time" value="<?php echo $office_in_time; ?>" placeholder="<?php echo $entry_office_in_time; ?>" id="input-time" class="form-control" />
                            <?php if ($error_time) { ?>
                                <div class="text-danger"><?php echo $error_time; ?></div>
                            <?php } ?>
                        </div>
                    </div> -->
                    <!-- <div style=<?php if ($user_group_id != 1){echo 'display:none;';}?>>
                        <div class="form-group required">
                            <label class="col-sm-1 control-label" for="input-time">Time:</label>
                            <div class="col-sm-2">
                                <?php if (!empty($time)) { ?>
                                <input type="text" name="time" value="<?php echo  $time; ?>" id="input-time" class="form-control"/>
                                <?php } else {?>
                                <input type="text" name="time" value="<?php date_default_timezone_set('Asia/Kolkata'); echo date("g:i A");?>" id="input-time" class="form-control"/>
                                <?php } ?>
                            </div>
                        </div> -->
                        <div class="form-group required">
                            <label class="col-sm-1 control-label" for="input-date">Date:</label>
                            <div class="col-sm-2">
                                <?php if (!empty($date)) { ?>
                                    <input type="date" name="date" value="<?php echo $date?>" id="input-date" class="form-control"/>
                                <?php } else { ?>
                                    <input type="date" name="date" value="<?=date("Y-m-d");?>" id="input-date" class="form-control"/>
                                <?php } ?>
                            </div>
                        </div> 
                        <div class="form-group required">
                        <label class="col-sm-1 control-label" for="input-date">Status</label>
                        <div class="col-sm-2">           
                            <select name="status"class="form-control" id="status">
                             <option value="Present">Weekly Off</option>
                             <option value="Absent">Hoilday</option>
                             <!-- <option value="Half Day" >Half Day</option> -->
                             <option value="<?php echo $status; ?>" selected hidden="hidden"><?php echo $status; ?></option>
                            </select>
                       </div>
                       </div>
                    </div>
                </form>
            </div>
            <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-leave">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                    <td class="text-left">Date</td>
                    <td class="text-left">Status</td>
                  
                  <td class="text-left"><?php echo $column_action; ?></td>
                </tr>
              </thead>
            <tbody>
              <?php if ($employees) { ?>
              <?php foreach ($employees as $employee) {
              //echo "<pre>";print_r($employee);exit; ?>
              

              <tr>
              <td class="text-center"><?php if (in_array($employee['employee_id'], $selected)) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $employee['employee_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $employee['employee_id']; ?>" />
              <?php } ?></td>
              <!-- <td class="text-left"><?php echo $employee['login']; ?></td>
              <td class="text-left"><?php echo $employee['name']; ?><?php if (date('m-d', strtotime($employee['dob'])) == date('m-d')) {echo "<span> 🎂</span>";}?></td>
               <td class="text-left"><?php echo $employee['dob']; ?></td>
              <td class="text-left"><?php echo $employee['email']; ?></td>
              <td class="text-left"><?php echo $employee['numbers']; ?></td> -->
              <td class="text-left"><?php echo $employee['date']; ?></td>
              <td class="text-left"><?php echo $employee['status']; ?></td>
              <!-- <td class="text-left"><?php echo $employee['address']; ?></td> -->
              <td class="text-right"><a href="<?php echo $employee['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
              <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </div>
        </table>
        </form>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'name\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'index.php?route=catalog/attendance/autocomplete2&token=<?php echo $token; ?>&name=' +  encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['name'],
                        value: item['user_id']
                    }
                }));
            }
        });
    },
    'select': function(item) {
        $('input[name=\'name\']').val(item['label']);
        $('input[name=\'user_id\']').val(item['value']);
    }
});
//--></script>
<?php echo $footer; ?>