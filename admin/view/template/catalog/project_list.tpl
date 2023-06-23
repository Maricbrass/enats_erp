<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-project').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-project_name"><?php echo $entry_project_name; ?></label>
                <input type="text" name="filter_project_name" value="<?php echo $filter_project_name; ?>" placeholder="<?php echo $entry_project_name; ?>" id="input-project_name" class="form-control" />
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-project">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_project_company;?></td>
                  <td class="text-left"><?php echo $column_contact_person;?></td>
                  <td class="text-left"><?php echo $column_phone;?></td>
                  <td class="text-left"><?php echo $column_email;?></td>
                  <td class="text-left"><?php echo $column_project_start_date;?></td>
                  <td class="text-left"><?php echo $column_project_end_date;?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($projects) { ?>
                <?php foreach ($projects as $project) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($project['project_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $project['project_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $project['project_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $project['project_name']; ?></td>
                  <td class="text-left"><?php echo $project['project_company']; ?></td>
                  <td class="text-left"><?php echo $project['contact_person']; ?></td>
                  <td class="text-left"><?php echo $project['phone']; ?></td>
                  <td class="text-left"><?php echo $project['email']; ?></td>
                  <td class="text-left"><?php echo $project['project_start_date']; ?></td>
                  <td class="text-left"><?php echo $project['project_end_date']; ?></td>
                  <td class="text-right"><a href="<?php echo $project['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
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
  var url = 'index.php?route=catalog/project&token=<?php echo $token; ?>';

  var filter_project_name = $('input[name=\'filter_project_name\']').val();

  if (filter_project_name) {
    url += '&filter_project_name=' + encodeURIComponent(filter_project_name);
  }

  location = url;
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_project_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/project/autocomplete&token=<?php echo $token; ?>&filter_project_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['project_name'],
            value: item['project_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'filter_project_name\']').val(item['label']);
  }
});
//--></script>
<?php echo $footer; ?>