<?php echo $header; ?><?php echo $column_left; ?> 
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">

    <?php if (!empty($bduser)) { ?>
      <?php foreach($bduser as $bd){?>
        <div class="alert alert-info"><i class="fa fa-birthday-cake"></i><b> Its <?php echo $bd['name']; ?>'s birthday. <?php echo $bd['dob']; ?> </b>
         <button type="button" class="close" data-dismiss="alert">&times;</button>
       </div>
      <?php }?>
    <?php } ?>

    <?php if (!empty($bduserr)) { ?>
      <?php foreach($bduserr as $doje1){?>
        <div class="alert alert-info"><i class="fa fa-user"></i><b> Its <?php echo $doje1['name']; ?>'s joining date. <?php echo $doje1['doje']; ?> </b>
         <button type="button" class="close" data-dismiss="alert">&times;</button>
       </div>
      <?php }?>
    <?php } ?>

    <?php if (!empty($user_data)) { ?>
      <?php foreach($user as $bd){?>
        <div class="modal fade" id="birthdayPopup_<?php echo $bd['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="birthdayPopupLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="birthdayPopupLabel"><?php echo $bd['text_birthday_popup_title']; ?><span style="font-size: 25px;">🎂</span></h5>
              </div>
              <div class="modal-body">
                <p><?php echo sprintf($bd['text_birthday_popup_message'], $bd['name']); ?><span style="font-size: 25px;">🎊🎉</span></p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $bd['text_close']; ?></button>
              </div>
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function() {
            $('#birthdayPopup_<?php echo $bd['user_id']; ?>').modal('show');
            $('body').addClass('modal-open');
          });
        </script>
      <?php }?>
    <?php } ?>
    <?php if ($user_group_id == 1) {?>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_attendance; ?></div>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_task; ?></div>
    <?php } elseif($user_group_id == 11) {?>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_task; ?></div>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_attendance; ?></div>
    <?php } else {?>
      <div class="col-lg-12 col-md-9 col-sm-9"><?php echo $list_task; ?></div>
    <?php }?>
  </div>
</div>
<style>
  .modal.fade {
    position: relative;
    padding: 0!important;
  }
  .modal-open {
    overflow: hidden;
  }
</style>
<?php echo $footer; ?>
