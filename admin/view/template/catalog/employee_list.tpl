<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">  
        <?php if ($user_group_id == 1) {?>
          <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-employee').submit() : false;"><i class="fa fa-trash-o"></i></button>
        <?php }?>
      </div>
      <div class="pull-right" style="margin-right: 4px;">
        <a href="<?php echo $export; ?>" title="Export report" class="btn btn-primary"><i class="fa fa-download"></i> Export report</a>
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
    <div class="panel panel-default">
      <div class="panel-heading" style='height: 60px'>
        <h3 class="panel-title"><i class="fa fa-list" style="padding top:50px"></i> <?php echo $text_list; ?></h3>
        <button type="button" name="all" id="button-all" class="btn btn-primary pull-right"><i class="fa fa-o"></i> <?php echo $button_all; ?></button>
      </div>
      <div class="panel-body">
        <?php if ($user_group_id == 1) {?>
          <div class="well">
          <div class="row">
            <!-- <div class="col-sm-4"> -->
              <!-- <div class="form-group"> -->
                <!-- <label class="control-label" for="input-login"><?php echo $column_login; ?></label> -->
                <!-- <input type="text" name="filter_login" value="<?php echo $filter_login; ?>" placeholder="<?php echo $column_login; ?>" id="input-login" class="form-control" />  -->
              <!-- </div> -->
            <!-- </div> -->
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
            </div>


            <div class="col-sm-4"style="width:200px">
                <div class="form-group">
                  <label class="control-label" for="input-fromdate">Start Date</label>
                  <input type="date" name="fromdate" value="<?php echo $fromdate; ?>" id="input-fromdate" class="form-control" />
                </div>
              </div>
              <div class="col-sm-4"style="width:200px">
                <div class="form-group">  
                  <label class="control-label" for="input-todate">End Date</label>
                  <input type="date" name="todate" value="<?php echo $todate; ?>" id="input-todate" class="form-control" />
                 </div>
                </div>
                <div class="col-sm-4"style="width:200px">
                <div class="form-group">
                 <label for="leave">Period</label>
                  <select name="test" id="test" class="dropdown form-control" >
                    <option value="Date of Joining" class="dropdown-manu form-control" default >Date of Joining</option>
                    <option value="Date of Leaving" class="dropdown-manu form-control" >Date of Leaving</option>
                    <option value="<?php echo $test; ?>" selected hidden="hidden"><?php echo $test; ?></option>
                    <!-- <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option> -->
                  </select>
                  </div>
                </div>
                <div class="col-sm-13" style="padding: top 50px;padding-left:auto;">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button><br><br><br>
              <button type="button" id="button-clear" class="btn btn-primary pull-right"><i class="fa fa-trash-o"></i> <?php echo $button_clear; ?></button>
              <!-- <td class="text-right"><a href="<?php echo $employee['jloption']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td> -->

            </div>
        </div>
      <?php }?>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-employee">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'login') { ?>
                    <a href="<?php echo $sort_login; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_login; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_login; ?>"><?php echo $column_login; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'name') {?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'email') { ?>
                    <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'contact') { ?>
                    <a href="<?php echo $sort_numbers; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_numbers; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_numbers; ?>"><?php echo $column_numbers; ?></a>
                    <?php } ?></td>
                    <td class="text-left">Date of joining</td>
                    <td class="text-left">Date of leaving</td>
                  <td class="text-left"><?php if ($sort == 'address') { ?>
                    <a href="<?php echo $sort_address; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_address; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_address; ?>"><?php echo $column_address; ?></a>
                    <?php } ?></td>
                  
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
              <td class="text-left"><?php echo $employee['login']; ?></td>
              <td class="text-left"><?php echo $employee['name']; ?><?php if (date('m-d', strtotime($employee['dob'])) == date('m-d')) {echo "<span> 🎂</span>";}?></td>
              <!-- <td class="text-left"><?php echo $employee['dob']; ?></td> -->
              <td class="text-left"><?php echo $employee['email']; ?></td>
              <td class="text-left"><?php echo $employee['numbers']; ?></td>
              <td class="text-left"><?php echo $employee['doje']; ?></td>
              <td class="text-left"><?php echo $employee['dole']; ?></td>
              <td class="text-left"><?php echo $employee['address']; ?></td>
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
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  // console.log(url);

  var url = 'index.php?route=catalog/employee&token=<?php echo $token; ?>';
  var current_url = window.location.href;
  console.log(current_url);
  var filter_login = $('input[name=\'filter_login\']').val();

  if (filter_login) {
    url += '&filter_login=' + encodeURIComponent(filter_login);
  }
  var filter_name = $('input[name=\'filter_name\']').val();

  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }
 
//  var all = $('button[name=\'all\']').val();

    if (current_url == 'http://localhost/enats_erp/admin/index.php?route=catalog/employee&token=<?php echo $token; ?>&all=1') {
       url += '&all=' + 1;
    }
  var fromdate = $('input[name=\'fromdate\']').val();

    if (fromdate) {
      url += '&fromdate=' + encodeURIComponent(fromdate);
    }

    var todate = $('input[name=\'todate\']').val();

    if (todate) {
      url += '&todate=' + encodeURIComponent(todate);
    }

    var jl = $('select[name=\'test\']').val();
  
  if (jl) {
    url += '&test=' + encodeURIComponent(jl);
  }

 //return filter_sDate;

  location = url;
});  
</script>
<script type="text/javascript"><!--
$('input[name=\'filter_login\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete0&token=<?php echo $token; ?>&filter_login=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['login'],
            value: item['login']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_login\']').val(item['label']);
  }
});
--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['name']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_name\']').val(item['label']);
  }
});
--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_numbers\']').autocomplete({
  'source': function(request, response) {
    // console.log(request);
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete1&token=<?php echo $token; ?>&filter_numbers=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['numbers'],
            value: item['employee_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_numbers\']').val(item['label']);
  }
});
--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_email\']').autocomplete({
  'source': function(request, response) {
    // console.log(request);
    $.ajax({
      url: 'index.php?route=catalog/employee/autocomplete2&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          console.log(response);
          return {
            label: item['email'],
            value: item['employee_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_email\']').val(item['label']);
  }
});
--></script>
<script type="text/javascript">
$('#button-all').on('click', function() {
	var url = 'index.php?route=catalog/employee&token=<?php echo $token; ?>&all=1';
  location = url;
});
</script>
<script type="text/javascript">
$('#button-clear').on('click', function() {
	var url = 'index.php?route=catalog/employee&token=<?php echo $token; ?>';
  location = url;
});
</script>
<?php echo $footer; ?> 