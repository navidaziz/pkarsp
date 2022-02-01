<script>
  function view_school_detail(schools_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('search/view_school_detail'); ?>",
        data: {
          schools_id: schools_id,
        },
      })
      .done(function(respose) {
        $('#view_school_detail_body').html(respose);
      });
    $('#view_school_detail').modal('toggle');
  }
</script>

<div class="modal fade" id="view_school_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 50% !important;">
    <div class="modal-content" id="view_school_detail_body">

      ...

    </div>
  </div>
</div>

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