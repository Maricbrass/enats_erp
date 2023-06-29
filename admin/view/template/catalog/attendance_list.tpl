 <?php echo $header; ?><?php echo $column_left; ?>
 <div id="content">
   <div class="page-header">
     <div class="container-fluid">
       <div class="pull-right">
         <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
         <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-attendance').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
               <div class="form-group" style="padding: 0;">
                 <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                 <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
               </div>
             </div>
             <div class="col-sm-2">
               <div class="form-group" style="padding: 0;">
                 <label class="control-label" for="input-time">Start</label>
                 <input type="time" name="start_time" value="<?php echo $start_time; ?>" placeholder="<?php echo $entry_office_in_time; ?>" id="input-time" class="form-control" />
               </div>
             </div>
             <div class="col-sm-2">
               <div class="form-group" style="padding: 0;">
                 <label class="control-label" for="input-time">End</label>
                 <input type="time" name="end_time" value="<?php echo $end_time; ?>" placeholder="<?php echo $entry_office_in_time; ?>" id="input-time" class="form-control" />
               </div>
             </div>
             <div class="col-sm-4" style="padding-top:22px;padding-left:305px;">
               <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button><br><br>
              <button type="button" id="button-clear" class="btn btn-primary pull-right"><i class="fa fa-trash-o"></i> <?php echo $button_clear; ?></button>
               
              </div>
           </div>
         </div>
         <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-attendance">
           <div class="table-responsive">
             <table class="table table-bordered table-hover">
               <thead>
                 <tr>
                   <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                   <td class="text-left"><?php if ($sort == 'name') { ?>
                       <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                     <?php } else { ?>
                       <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                     <?php } ?>
                   </td>
                   <td class="text-left"><?php echo $column_office_in_time; ?></td>
                   <td class="text-left"><?php echo $column_date_time; ?></td>
                   <td class="text-left"><?php echo $column_status; ?></td>
                   <td class="text-right"><?php echo $column_action; ?></td>
                 </tr>
               </thead>
               <tbody>
                 <?php if ($attendances) { ?>
                   <?php foreach ($attendances as $attendance) {
                      // echo "<pre>";print_r($manufacturers);exit; 
                    ?>
                     <tr>
                       <td class="text-center"><?php if (in_array($attendance['attendance_id'], $selected)) { ?>
                           <input type="checkbox" name="selected[]" value="<?php echo $attendance['attendance_id']; ?>" checked="checked" />
                         <?php } else { ?>
                           <input type="checkbox" name="selected[]" value="<?php echo $attendance['attendance_id']; ?>" />
                         <?php } ?>
                       </td>
                       <td class="text-left"><?php echo $attendance['name']; ?></td>
                       <td class="text-left"><?php echo $attendance['office_in_time']; ?></td>
                       <td class="text-left"><?php echo $attendance['date'] . ' ' . $attendance['time']; ?></td>
                       <td class="text-left"><?php echo $attendance['status']?></td>                      
                       <td class="text-right"><a href="<?php echo $attendance['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
 <script type="text/javascript">
   $('#button-filter').on('click', function() {

     var url = 'index.php?route=catalog/attendance&token=<?php echo $token; ?>';

     var filter_name = $('input[name=\'filter_name\']').val();

     if (filter_name) {
       url += '&filter_name=' + encodeURIComponent(filter_name);
     }

     var start_time = $('input[name=\'start_time\']').val();

     if (start_time) {
       url += '&start_time=' + encodeURIComponent(start_time);
     }

     var end_time = $('input[name=\'end_time\']').val();

     if (end_time) {
       url += '&end_time=' + encodeURIComponent(end_time);
     }

     location = url;
   });
 </script>
 <script type="text/javascript">
   $('input[name=\'filter_name\']').autocomplete({
     'source': function(request, response) {
       $.ajax({
         url: 'index.php?route=catalog/attendance/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
         dataType: 'json',
         success: function(json) {
           response($.map(json, function(item) {
             return {
               label: item['firstname'],
               value: item['user_id']
             }
           }));
         }
       });
     },
     'select': function(item) {
       $('input[name=\'filter_name\']').val(item['label']);
     }
   });
 </script>
 <script type="text/javascript">
$('#button-clear').on('click', function() {
	var url = 'index.php?route=catalog/attendance&token=<?php echo $token; ?>';
  location = url;
});
</script>
 <?php echo $footer; ?>