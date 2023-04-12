<script>
  function view_school_detail(schools_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('school_search/school_summary'); ?>",
        data: {
          schools_id: schools_id,
        },
      })
      .done(function(respose) {
        $('#modal').modal('show');
        $('#modal_title').html("School Case Details");
        $('#modal_body').html(respose);
      });

  }

  function create_message(schools_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('school_search/create_message'); ?>",
        data: {
          schools_id: schools_id,
        },
      })
      .done(function(respose) {
        $('#modal_body').html('');
        $('#modal').modal('show');
        $('#modal_title').html("Create Message");
        $('#modal_body').html(respose);
      });

  }
</script>


<div class="block_div">
  <h4><?php echo $title ?></h4>
  <table class="table table-bordered table_small" id="searchlist">
    <thead>
      <tr>
        <th>#</th>
        <th>Institute ID</th>
        <th>REG-No.</th>
        <th>School Name</th>
        <th>Year of Estb.</th>
        <th>Gender of Edu.</th>
        <th>Level</th>
        <th>District</th>
        <th>Tehsil</th>
        <th>UC</th>
        <th>Address</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 1;

      if ($search_list) {
        foreach ($search_list as $school) { ?>
          <tr <?php if ($school->registrationNumber <= 0) { ?> style="color:#b2aeae;" <?php } else { ?> style="color:black;" <?php } ?>>

            <td><?php echo $count++; ?></td>
            <td><?php echo $school->schools_id ?></td>
            <td><?php
                if ($school->registrationNumber) {
                  echo $school->registrationNumber;
                }
                ?></td>
            <td><?php echo $school->schoolName ?></td>


            <td><?php echo $school->yearOfEstiblishment ?></td>
            <td>
              <?php $query = "SELECT genderOfSchoolTitle FROM genderofschool 
        WHERE genderOfSchoolId = 
        (SELECT gender_type_id FROM school WHERE schools_id = '" . $school->schools_id . "' ORDER BY schoolId DESC LIMIT 1)
        ";
              $edu_gender = $this->db->query($query)->row();
              if ($edu_gender) { ?>
                <?php echo ucwords(strtolower($edu_gender->genderOfSchoolTitle)); ?>
              <?php } ?>
            </td>
            <td>
              <?php $query = "SELECT levelofInstituteTitle FROM levelofinstitute 
        WHERE levelofInstituteId = 
        (SELECT level_of_school_id FROM school WHERE schools_id = '" . $school->schools_id . "' ORDER BY schoolId DESC LIMIT 1)
        ";
              $level = $this->db->query($query)->row();
              if ($level) { ?>
                <?php echo ucwords(strtolower($level->levelofInstituteTitle)); ?>
              <?php } ?>
            </td>

            <td><?php echo ucwords(strtolower($school->districtTitle)) ?></td>
            <td>
              <?php $query = "SELECT tehsilTitle FROM tehsils WHERE tehsilId = '" . $school->tehsil_id . "'";
              $tehsil = $this->db->query($query)->row();
              if ($tehsil) { ?>
                <?php echo ucwords(strtolower($tehsil->tehsilTitle)); ?>
              <?php } ?>
            </td>
            <td>
              <?php $query = "SELECT ucTitle FROM uc WHERE ucId = '" . $school->uc_id . "'";
              $uc = $this->db->query($query)->row();
              if ($uc) { ?>
                <?php echo ucwords(strtolower($uc->ucTitle)); ?>
              <?php } else { ?>
                <?php echo ucwords(strtolower($uc->uc_text)); ?>
              <?php } ?>
            </td>
            <td><?php echo ucfirst(strtolower($school->address)); ?></td>

            <td>

              <button class="btn btn-link btn-sm" onclick="view_school_detail('<?php echo $school->schools_id; ?>')">View</button>

              <button class="btn btn-link btn-sm" onclick="create_message('<?php echo $school->schools_id; ?>')">Message</button>

            </td>

          </tr>
        <?php  }
      } else { ?>
        <tr>
          <td colspan="12">
            <div style="text-align: center;">
              <h4 style="color: #aaaaaa;">
                Record not found. please search with different institute name, ID or Registration Number.
              </h4>
            </div>
          </td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<style>
  .dt-buttons {
    display: inline;
  }

  table.dataTable.no-footer {
    margin-top: 10px;

  }
</style>
<script>
  $(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';

    $('#searchlist').on('error.dt', function(e, settings, techNote, message) {
      console.log('An error has been reported by DataTables: ', message);
    });
    //console.log('we are here');
    $('#searchlist').DataTable({
      dom: 'Bfrtip',
      paging: false,
      searching: true,
      buttons: [
        'copy', 'csv', 'excel', 'print', {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'LEGAL'
        }
      ]
    });
  });
</script>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title" style="display: inline;"></h4>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        ...
      </div>
      <div class="modal-footer" style="text-align: center;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>