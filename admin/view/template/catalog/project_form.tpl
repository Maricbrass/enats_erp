<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-project" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-project" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project_name"><?php echo $entry_project_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="project_name" value="<?php echo $project_name; ?>" placeholder="<?php echo $entry_project_name; ?>" id="input-project_name" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project_company"><?php echo $entry_project_company; ?></label>
            <div class="col-sm-10">
            <input type="text" <?php if ($user_group_id != 1) echo "readonly"?> name="project_company" value="<?php echo $project_company; ?>" placeholder="<?php echo $entry_project_company; ?>" id="input-name" class="form-control" />
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-contact_person"><?php echo $entry_contact_person; ?></label>
            <div class="col-sm-10">
              <input type="text" name="contact_person" value="<?php echo $contact_person; ?>" placeholder="<?php echo $entry_contact_person; ?>" id="input-contact_person" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
            <div class="col-sm-10">
              <input type="tel" name="phone" value="<?php echo $phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project_start_date"><?php echo $entry_project_start_date; ?></label>
            <div class="col-sm-10">
              <input type="date" name="project_start_date" value="<?php echo $project_start_date; ?>" id="input-project_start_date" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-project_end_date"><?php echo $entry_project_end_date; ?></label>
            <div class="col-sm-10">
              <input type="date" name="project_end_date" value="<?php echo $project_end_date; ?>" id="input-project_end_date" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'project_company\']').autocomplete({
    'source': function(request, response) {
        $.ajax({
            url: 'index.php?route=catalog/project/autocompleteemp1&token=<?php echo $token; ?>&project_company=' +  encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        label: item['username'],
                        value: item['user_id'],
                    }
                }));
            }
        });
    },
    'select': function(item) {
        $('input[name=\'user_id\']').val(item['value']);
        $('input[name=\'project_company\']').val(item['label']);
    }
});
//--></script>
<?php echo $footer; ?>