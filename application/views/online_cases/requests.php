<?php $this->load->helper('project_helper'); ?>
<h4> <?php echo  $title . " " . $institute_type;  ?>
  <span class="label label-primary pull-right"><?php echo sizeof($requests); ?></span>
</h4>
<div class="table-responsive">


  <table class="table table-bordered table_small" id="<?php echo  str_replace(" ", "_", $title);  ?>" style="font-size:11px">
    <thead>
      <tr>
        <th>#</th>
        <?php if ($list_type == 5) { ?>
          <th>Type</th>
          <th>Contact</th>
        <?php } ?>
        <th>Insti.ID</th>
        <th>File No.</th>
        <th>Level</th>
        <th>District</th>
        <th>School Name</th>
        <th>Session</th>
        <th>Flag</th>
        <th>Docs</th>
        <th>Days</th>
        <th>Defic</th>
        <th>Note</th>
        <th>Fine</th>
        <?php if ($request_type == 1 || $request_type == 4) { ?>
          <th>Visit</th>
          <th>Reco.</th>
        <?php } ?>
        <?php if ($list_type == 3) { ?>
          <th>Remarks</th>
        <?php } ?>
        <th>Action</th>
        <?php if ($request_type == 1 || $request_type == 4) { ?>
          <th>Tehsil</th>
          <th>Address</th>
          <th>Contact</th>
          <th>YofEst</th>
          <th>BISE Reg.</td>
          <?php } ?>


      </tr>
    </thead>
    <tbody>
      <?php
      $count = 1;
      $previous_school_id = 0;
      foreach ($requests as $request) {
        if ($request->previous_session_status != 8) {
      ?>

          <?php if ($request->deficient == 0  or 1 == 1) { ?>
            <tr style="<?php if ($request->flag_color) { ?>
            background-color: <?php echo $request->flag_color; ?>; <?php } ?> <?php if ($request->deficient > 0) { ?> color:red; <?php if ($list_type == 1) { ?> display:no ne;<?php } ?> <?php } ?>">

              <?php if ($previous_school_id != $request->schools_id) { ?>
                <td><?php echo $count++; ?> </td>
                <?php if ($list_type == 5) { ?>
                  <td><?php echo $request->regTypeTitle; ?></td>
                  <td><?php echo $request->telePhoneNumber; ?>,
                    <?php echo $request->schoolMobileNumber; ?>,
                    <?php echo $request->principal_contact_no; ?>,
                    <?php echo $request->owner_contact_no; ?></td>
                <?php } ?>
                <td><?php echo $request->schools_id ?></td>
                <td>
                  <?php
                  $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$request->schools_id'";
                  $file_numbers = $this->db->query($query)->result();
                  $count = 1;
                  foreach ($file_numbers as $file_number) {
                    if ($count > 1) {
                      echo ", ";
                    }
                    echo $file_number->file_number;

                    $count++;
                  }
                  ?>
                </td>
                <td>
                  <?php if ($request->level_of_school_id == 1) {
                    echo "Primary";
                  } ?>
                  <?php if ($request->level_of_school_id == 2) {
                    echo "Middle";
                  } ?>
                  <?php if ($request->level_of_school_id == 3) {
                    echo "High";
                  } ?>
                  <?php if ($request->level_of_school_id == 4) {
                    echo "H.Sec";
                  } ?>
                  <?php if ($request->level_of_school_id == 5) {
                    echo "Academy";
                  } ?>
                </td>
                <td><?php echo $request->districtTitle; ?></td>
                <td><?php echo substr($request->schoolName, 0, 45) ?></td>



              <?php } else { ?>
                <td colspan=" 6">
                </td>
                <?php if ($list_type == 5) { ?>
                  <td></td>
                  <td></td>
                <?php } ?>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>

              <?php } ?>
              <td><?php echo $request->sessionYearTitle ?></td>
              <td><?php echo $request->flag_detail ?></td>
              <td>
                <?php if ($request_type == 1) { ?>
                  <?php if ($request->docs == 0) {
                    echo '<i style="color:red" class="fa fa-times-circle-o" aria-hidden="true"></i> No';
                  } ?>
                  <?php if ($request->docs == 1) {
                    echo '<i style="color:green" class="fa fa-check-circle" aria-hidden="true"></i> Yes';
                  } ?>
                <?php } ?>
              </td>
              <td style="text-align: center;" title="<?php echo date('d M, Y', strtotime($request->apply_date)); ?>">
                <?php
                //strtotime($request->apply_date)
                if ($request->apply_date) {
                  echo timeago(strtotime($request->apply_date));
                }
                ?></td>
              <td style="text-align: center;">
                <?php
                $query = "SELECT COUNT(*) as total FROM `file_status_logs` WHERE `file_status` = 5 and schools_id = '" . $request->schools_id . "'";
                $once_deficient = $this->db->query($query)->row()->total;
                if ($once_deficient > 0) {
                  echo '<i title="Deficiency completed" class="fa fa-flag" style="color:red" aria-hidden="true">1</i>';
                }
                ?>
              </td>
              <td style="text-align: center;">
                <?php
                $query = "SELECT COUNT(*) as total FROM `comments` WHERE school_id='" . $request->school_id . "' and schools_id = '" . $request->schools_id . "' and deleted=0";
                $comments = $this->db->query($query)->row()->total;
                if ($comments > 0) {
                  echo '<i title="Maybe notesheet completed" class="fa fa-comment" style="color:green" aria-hidden="true">1</i>';
                }
                ?>
              </td>
              <td style="text-align: center;">
                <?php if ($request->isfined == 1) { ?>
                  <i class="fa fa-ban" title="Fine on this school" style="color: red;">1</i>
                <?php } ?>
              </td>
              <?php if ($request_type == 1 || $request_type == 4) { ?>
                <td><?php echo $request->visit; ?></td>
                <td><?php echo $request->recommended; ?></td>
              <?php } ?>
              <?php if ($list_type == 3) { ?>
                <td><?php echo $request->status_remark; ?></td>
              <?php } ?>



              <td>
                <?php if ($request->registrationNumber) { ?>
                  <!--<a href="<?php echo site_url("online_cases/combine_note_sheet/$request->schools_id"); ?>">Notesheet</a>-->
                  <a href="javascript:void(0)"><span onclick="search('<?php echo $request->schools_id; ?>')">Notesheet</span></a>
                <?php } else { ?>
                  <a href="<?php echo site_url("online_cases/single_note_sheet/$request->schools_id/$request->school_id"); ?>"> New Registration </a>
                <?php } ?>
              </td>

              <?php if ($request_type == 1 or $request_type == 4) { ?>
                <td><?php echo $request->tehsil; ?></td>
                <td><?php echo $request->address; ?></td>
                <td><?php echo $request->telePhoneNumber; ?>,
                  <?php echo $request->schoolMobileNumber; ?>,
                  <?php echo $request->principal_contact_no; ?>,
                  <?php echo $request->owner_contact_no; ?>,
                </td>
                <td><?php echo $request->yearOfEstiblishment; ?></td>
                <td><?php
                    if ($request->biseRegister == 'Yes') {
                      echo 'Yes - ';
                    }
                    echo $request->biseregistrationNumber;
                    ?></td>
              <?php } ?>


            </tr>
          <?php } ?>
      <?php
          $previous_school_id =  $request->schools_id;
        }
      } ?>
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
    $('#<?php echo  str_replace(" ", "_", $title);  ?>').DataTable({
      dom: 'Bfrtip',
      paging: false,
      title: '<?php echo $title;  ?>',
      "order": [],
      searching: true,
      buttons: [

        {
          extend: 'print',
          title: '<?php echo str_replace(" ", "-", $title) . "-Date: " . Date("d-M-Y");  ?>',
          exportOptions: {
            <?php if ($request_type == 2) { ?>
              //columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            <?php } ?>
            <?php if ($request_type == 1) { ?>
              // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            <?php } ?>
            <?php if ($request_type == 4) { ?>
              //columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            <?php } ?>
          }
        },
        {
          extend: 'excelHtml5',
          title: '<?php echo str_replace(" ", "-", $title) . "-Date: " . Date("d-M-Y");  ?>',
          exportOptions: {
            <?php if ($request_type == 2) { ?>
              // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            <?php } ?>
            <?php if ($request_type == 1) { ?>
              // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            <?php } ?>
            <?php if ($request_type == 4) { ?>
              //columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            <?php } ?>
          }
        },
        {
          extend: 'pdfHtml5',
          title: '<?php echo str_replace(" ", "-", $title) . "-Date: " . Date("d-M-Y");  ?>',
          pageSize: 'A4',
          exportOptions: {
            <?php if ($request_type == 2) { ?>
              // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            <?php } ?>
            <?php if ($request_type == 1) { ?>
              // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            <?php } ?>
            <?php if ($request_type == 4) { ?>
              // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            <?php } ?>
          }
        }
      ]
    });
  });
</script>