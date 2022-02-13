<div class="modal-header">
  <h4 style="border-left: 20px solid 
   <?php if ($gender_id == 1) { ?> #9FC8E8 <?php } else { ?> #FFC0CB <?php } ?>; padding-left:5px;" class="pull-left">

    <?php if ($gender_id == 1) { ?> Boys: <?php } else { ?> Girls: <?php } ?>
    Students in Class - <?php echo $class->classTitle ?></h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
      padding: 1px !important;
    }
  </style>

  <h5 style="color: red;">Note: For example age 3+ means “equal to or greater than 3 but less than 4 years”, similarly for 4+ , 5+ and so on.</h5>
  <form action="<?php echo site_url("form/update_class_ages_data") ?>" method="post">
    <table class="table table-bordered">

      <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
      <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
      <input type="hidden" name="gender_id" value="<?php echo $gender_id; ?>" />
      <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />

      <tr>
        <th style="text-align: center; background-color: <?php if ($gender_id == 1) { ?> #9FC8E8 <?php } else { ?> #FFC0CB <?php } ?>;">Age Range</th>
        <th colspan="2" style="text-align: center;  background-color: <?php if ($gender_id == 1) { ?> #9FC8E8 <?php } else { ?> #FFC0CB <?php } ?>;">Total <?php if ($gender_id == 1) { ?> Boys: <?php } else { ?> Girls: <?php } ?> Students In Class - <?php echo $class->classTitle ?></th>
      </tr>

      <?php
      $total_students = 0;
      foreach ($ages  as $age) { ?>
        <tr>
          <th style="text-align: center; background-color: <?php if ($gender_id == 1) { ?> #9FC8E8 <?php } else { ?> #FFC0CB <?php } ?>;"><?php echo $age->ageTitle; ?></th>
          <td style="text-align: center;"><?php $query = "SELECT `enrolled` FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND class_id ='" . $class_id . "'
                                            AND gender_id ='" . $gender_id . "'
                                            AND school_id = '" . $school_id . "'";
                                          $query_result = $this->db->query($query)->result();
                                          if ($query_result) {
                                            $total_students += $query_result[0]->enrolled;
                                          ?>
              <input class="age" value="<?php echo $query_result[0]->enrolled; ?>" id="<?php echo $class->ageId ?>" style="width: 50px;" type="number" min="0" name="class_age[<?php echo $age->ageId ?>]" />

            <?php } else { ?>

              <input required class="age" value="" id="<?php echo $class->ageId ?>" style="width: 50px;" type="number" min="0" name="class_age[<?php echo $age->ageId ?>]" />
            <?php }  ?>
          </td>
        </tr>


      <?php } ?>
      <tr>
        <td style="text-align: center;"> Total Students In Class <?php echo $class->classTitle ?></td>
        <td style="text-align: center;"><span class="total_students"><?php echo $total_students; ?></span></td>
      </tr>
      <?php $query = "SELECT SUM(`non_muslim`) as non_muslim, SUM(`disabled`) as disabled
                                  FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND class_id =  '" . $class_id . "'
                                  AND gender_id ='" . $gender_id . "' ";
      $query_result = $this->db->query($query)->result();
      ?>

      <tr>
        <th style="text-align: center; background-color: <?php if ($gender_id == 1) { ?> #9FC8E8 <?php } else { ?> #FFC0CB <?php } ?>;">Non-Muslims <?php if ($gender_id == 1) { ?> Boys <?php } else { ?> Girls <?php } ?> In Class <?php echo $class->classTitle ?></th>
        <td style="text-align: center;"><input required value="<?php if ($query_result) {
                                                                  echo $query_result[0]->non_muslim;
                                                                } ?>" style="width: 50px;" type="number" min="0" max="<?php echo $total_students; ?>" id="non_muslim" name="non_muslim" />
        </td>

      </tr>
      <tr>
        <th style="text-align: center; background-color: <?php if ($gender_id == 1) { ?> #9FC8E8 <?php } else { ?> #FFC0CB <?php } ?>;">Disabled <?php if ($gender_id == 1) { ?> Boys <?php } else { ?> Girls <?php } ?> In Class <?php echo $class->classTitle ?></th>
        <td style="text-align: center;"><input required value="<?php if ($query_result) {
                                                                  echo $query_result[0]->disabled;
                                                                } ?>" style="width: 50px;" type="number" min="0" max="<?php echo $total_students; ?>" id="disabled" name="disabled" /></td>
      </tr>
      <td colspan="2" style="text-align: center; padding: 5px !important;">
        <input type="submit" class="btn btn-primary" value="Update Class Age Wise Data" />

      </td>
      </tr>

    </table>
  </form>
  <script>
    $(document).on("keyup", ".age", function() {
      var sum = 0;
      $(".age").each(function() {
        sum += +$(this).val();
      });
      $(".total_students").html(sum);
      $("#non_muslim").attr({
        "max": sum, // substitute your own
        "min": 0 // values (or variables) here
      });
      $("#disabled").attr({
        "max": sum, // substitute your own
        "min": 0 // values (or variables) here
      });
    });
  </script>

</div>
<!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->