<ul id="menu">
  <?php if ($user_group_id != 12) { ?>
    <li id="dashboard"><a href="<?php echo $home; ?>"><i class="fa fa-dashboard fa-fw"></i> <span><?php echo $text_dashboard; ?></span></a></li>
    <li id="catalog"><a class="parent"><i class="fa fa-user fa-fw"></i><span><?php echo $text_catalog; ?></span></a>
      <ul>
        <?php if ($user_group_id == 1) { ?>
          <li><a href="<?php echo $project; ?>"><?php echo $text_project; ?></a></li>
          <li><a href="<?php echo $employee; ?>"><?php echo $text_employee; ?></a></li>
        <?php } else { ?>
          <li><a href="<?php echo $employee; ?>"><?php echo $text_employee; ?></a></li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>
  <?php if ($user_group_id != 12) { ?>
    <li id="extension"><a class="parent"><i class="fa fa-arrow-right fa-fw"></i> <span><?php echo $text_extension; ?></span></a>
      <ul>
        <li><a href="<?php echo $attendance; ?>"><?php echo $text_attendance; ?></a></li>
        <li><a href="<?php echo $task; ?>"><?php echo $text_task; ?></a></li>
      </ul>
    </li>
  <?php } else { ?>
    <li><a href="<?php echo $task; ?>"><?php echo $text_task; ?></a></li>
  <?php } ?>
  <?php if ($user_group_id == 1) { ?>
    <li id="reports"><a class="parent"><i class="fa fa-bar-chart-o fa-fw"></i> <span><?php echo $text_reports; ?></span></a>
      <ul>
        <li><a href="<?php echo $report_attendance; ?>"><?php echo $text_report_attendance; ?></a></li>
        <li><a href="<?php echo $task_report; ?>"><?php echo $text_task_report; ?></a></li>
        <li><a href="<?php echo $arc_task_report; ?>"><?php echo $text_arc_task_report; ?></a></li>
      </ul>
    </li>
    <li id="system"><a class="parent"><i class="fa fa-cog fa-fw"></i> <span><?php echo $text_system; ?></span></a>
      <ul>
        <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
        <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
        <li><a href="<?php echo $task_archive; ?>" <?php echo $text_task_archive; ?> onclick="return confirm('<?php echo $text_confirm; ?>') ? $('#form-project').submit() : false;"><?php echo $text_task_archive; ?></a></li>
        <li><a href="<?php echo $attendance_archive; ?>" <?php echo $text_attendance_archive; ?> onclick="return confirm('<?php echo $text_confirm; ?>') ? $('#form-project').submit() : false;"><?php echo $text_attendance_archive; ?></a></li>
      </ul>
    </li>
  <?php } ?>
</ul>