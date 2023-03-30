<?php $this->load->helper('project_helper'); ?>
<h4> <?php echo  $title;  ?>
  <span class="label label-primary pull-right"><?php echo sizeof($requests); ?></span>
</h4>
<table class="table table-bordered table_small" style="font-size:11px">
  <tr>
    <th>#</th>

    <th>School ID</th>
    <th>School Name</th>
    <th>District</th>
    <th>Session</th>
    <th><i class="fa fa-clock-o" aria-hidden="true"></i></th>
    <th><i class="fa fa-flag" aria-hidden="true"></i></th>
    <th><i class="fa fa-comment" aria-hidden="true"></i></th>
    <th><i class="fa fa-ban" aria-hidden="true"></i></th>
    <th>Action</th>

  </tr>
  <?php
  $count = 1;
  $previous_school_id = 0;
  foreach ($requests as $request) {
    if ($request->previous_session_status != 8) {
  ?>

      <?php if ($request->deficient == 0  or 1 == 1) { ?>
        <tr <?php if ($request->deficient > 0) { ?> style="color:red; <?php if ($list_type == 1) { ?> display:none;<?php } ?> " <?php } ?>">

          <?php if ($previous_school_id != $request->schools_id) { ?>
            <td><?php echo $count++; ?> </td>

            <td><?php echo $request->schools_id ?></td>
            <td><?php echo substr($request->schoolName, 0, 45) ?></td>
            <td><?php echo $request->districtTitle; ?></td>
          <?php } else { ?>
            <td colspan="4"></td>
          <?php } ?>
          <td><?php echo $request->sessionYearTitle ?></td>
          <td title="<?php echo date('d M, Y', strtotime($request->apply_date)); ?>">
            <?php
            //strtotime($request->apply_date)
            if ($request->apply_date) {
              echo timeago(strtotime($request->apply_date));
            }
            ?></td>
          <td>
            <?php
            $query = "SELECT COUNT(*) as total FROM `file_status_logs` WHERE `file_status` = 5 and schools_id = '" . $request->schools_id . "'";
            $once_deficient = $this->db->query($query)->row()->total;
            if ($once_deficient > 0) {
              echo '<i title="Deficiency completed" class="fa fa-flag" style="color:red" aria-hidden="true"></i>';
            }
            ?>
          </td>
          <td>
            <?php
            $query = "SELECT COUNT(*) as total FROM `comments` WHERE school_id='" . $request->school_id . "' and schools_id = '" . $request->schools_id . "' and deleted=0";
            $comments = $this->db->query($query)->row()->total;
            if ($comments > 0) {
              echo '<i title="Maybe notesheet completed" class="fa fa-comment" style="color:green" aria-hidden="true"></i>';
            }
            ?>
          </td>
          <td>
            <?php if ($request->isfined == 1) { ?>
              <i class="fa fa-ban" title="Fine on this school" style="color: red;"></i>
            <?php } ?>
          </td>


          <td>




            <?php if ($request->registrationNumber) { ?>
              <!--<a href="<?php echo site_url("online_cases/combine_note_sheet/$request->schools_id"); ?>">Notesheet</a>-->
              <a href="#"><span onclick="search('<?php echo $request->schools_id; ?>')">Notesheet</span></a>
            <?php } else { ?>
              <a href="<?php echo site_url("online_cases/single_note_sheet/$request->schools_id/$request->school_id"); ?>"> New Registration </a>
            <?php } ?>
          </td>


        </tr>
      <?php } ?>
  <?php
      $previous_school_id =  $request->schools_id;
    }
  } ?>

</table>