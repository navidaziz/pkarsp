<h4><?php echo $title ?></h4>
<table class="table table-bordered table_small">
  <tr>
    <th>#</th>

    <th>S-ID</th>
    <th>School Name</th>
    <th>REG-No.</th>
    <th>District</th>
    <th></th>
  </tr>
  <?php
  $count = 1;

  foreach ($search_list as $school) { ?>
    <tr>

      <td><?php echo $count++; ?></td>

      <td><?php echo $school->schools_id ?></td>
      <td><?php echo $school->schoolName ?></td>
      <td><?php echo $school->registrationNumber ?></td>
      <td><?php echo $school->districtTitle ?></td>

      <td>
        <button class="btn btn-link btn-sm" onclick="view_school_detail('<?php echo $school->schools_id; ?>')">View</button>
      </td>

    </tr>
  <?php  } ?>

</table>