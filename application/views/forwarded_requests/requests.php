<h4><?php echo $title ?></h4>
<table class="table table-bordered table_small">
  <tr>
    <th>#</th>
    <th></th>
    <th>School ID</th>
    <th>School Name</th>
    <th>Session</th>
    <th>Action</th>
  </tr>
  <?php
  $count = 1;
  foreach ($requests as $request) { ?>
    <tr>
      <td><?php echo $count++; ?></td>
      <td><?php
          $words = explode(" ", $request->regTypeTitle);
          $acronym = "";

          foreach ($words as $w) {
            echo strtoupper($w[0]);
          }
          ?></td>
      <td><?php echo $request->schools_id ?></td>
      <td><?php echo $request->schoolName ?></td>
      <td><?php echo $request->sessionYearTitle ?></td>
      <td>
        <button class="btn btn-link btn-sm" onclick="view_request_detail('<?php echo $request->school_id; ?>', '<?php echo $request->sessionYearId; ?>', '<?php echo $request->comment_id; ?>')">View Detail</button>
      </td>

    </tr>
  <?php } ?>

</table>