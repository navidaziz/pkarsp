<h4>Completed Requests</h4>
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
  foreach ($completed_requests as $requests) { ?>
    <tr>
      <td><?php echo $count++; ?></td>
      <td><?php
          $words = explode(" ", $requests->regTypeTitle);
          $acronym = "";

          foreach ($words as $w) {
            echo strtoupper($w[0]);
          }
          ?></td>
      <td><?php echo $requests->schools_id ?></td>
      <td><?php echo $requests->schoolName ?></td>
      <td><?php echo $requests->sessionYearTitle ?></td>
      <td>
        <button class="btn btn-link btn-sm" onclick="view_request_detail('<?php echo $requests->school_id; ?>', '<?php echo $requests->sessionYearId; ?>')">View Detail</button>
      </td>

    </tr>
  <?php } ?>

</table>