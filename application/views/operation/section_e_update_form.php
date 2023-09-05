<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <!-- <h2 style="display:inline;">
      <?php //echo ucwords(strtolower($title)); 
      ?>
    </h2>
    <br />
    <small><?php echo ucwords(strtolower($description)); ?></small> -->
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <tr>
            <td>
              <h3 style="text-transform: uppercase;"><?php echo @$school->schoolName; ?> <?php if (!empty($school->ppcCode)) {
                                                                                            echo " - PPC Code" . $school->ppcCode;
                                                                                          } ?></h3>

              <address>
                <?php if ($school->districtTitle) {
                  echo "District: <strong>" . $school->districtTitle . "</strong>";
                } ?>
                <?php if ($school->tehsilTitle) {
                  echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
                } ?>
                <?php if ($school->pkNo) {
                  echo " / Pk: <strong>" . $school->pkNo . "</strong>";
                } ?>
                <?php if ($school->ucTitle) {
                  echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
                } ?>
                <?php if (!empty($school->location)) { ?>
                  <?php echo " (<strong>" . $school->location . ") </strong>"; ?>
                <?php } ?>
              </address>
              <p>Address: <?php echo  $school->address; ?></p>
              <b>
                <?php echo "Tele-Phone #: " . $school->telePhoneNumber; ?> - <?php echo "Mobile #: " . $school->schoolMobileNumber; ?>
              </b>

            </td>
            <td>
              <ol class="breadcrumb">
                <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
                <li><a href="<?php echo site_url('operation/index') ?>">Section E opened list</a></li>
                <li class="active"><?php echo @ucfirst($title); ?></li>
              </ol>
              <h4>
                School Id # <?php echo $school->schoolId; ?> <br />
                <?php if ($school->registrationNumber != 0) : ?>
                  <?php echo "Registration # " . @$school->registrationNumber; ?><br />
                <?php endif; ?>

                File No: <strong><?php
                                  $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schoolId'";
                                  $file_numbers = $this->db->query($query)->result();
                                  $count = 1;
                                  foreach ($file_numbers as $file_number) {
                                    if ($count > 1) {
                                      echo ", ";
                                    }
                                    echo $file_number->file_number;

                                    $count++;
                                  }
                                  ?></strong><br />
              </h4>

            </td>
          </tr>

        </table>
      </div>

    </div>
  </section>

  <!-- Main content -->
  <section class="content" style="padding-top: 0px !important;">

    <div class="box box-primary box-solid">



      <div class="col-lg-12 col-xs-12">

      </div>


      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="block_div">
              <?php
              $query = "SELECT section_e, status FROM school 
                WHERE schoolId = '" . $school_id . "'
                AND schools_id = '" . $schools_id . "'
                AND session_year_id = '" . $session_id . "'
                ";
              $school_session = $this->db->query($query)->row();
              if ($school_session->section_e == 0 and $school_session->status == 2) { ?>
                <form action="<?php echo site_url('operation/update_section_e') ?>" method="post">
                  <input type="hidden" value="<?php echo $school_id; ?>" name="school_id" />
                  <input type="hidden" value="<?php echo $schools_id; ?>" name="schools_id" />
                  <input type="hidden" value="<?php echo $session_id; ?>" name="session_id" />
                  <table class="table table-bordered" style="width: 100%;">
                    <tr>
                      <th>Sessions</th>
                      <?php

                      $query = "SELECT * FROM class WHERE classId IN(SELECT class_id FROM fee WHERE school_id = '" . $school_id . "')";

                      $classes = $this->db->query($query)->result();
                      $query = "SELECT
                          `session_year`.`sessionYearTitle`
                          , `session_year`.`sessionYearId`
                          , `school`.`schoolId`
                          FROM
                          `school`
                          INNER JOIN `session_year` 
                          ON (`school`.`session_year_id` = `session_year`.`sessionYearId`)
                          WHERE  `school`.`schoolId` <= '" . $school_id . "'
                          AND school.schools_id = '" . $schools_id . "'
                          ORDER BY `school`.`schoolId` DESC LIMIT 2";
                      $sessions =  $this->db->query($query)->result();

                      asort($sessions);
                      foreach ($sessions  as $session) { ?>
                        <th style="text-align: center;"><?php echo $session->sessionYearTitle; ?></th>
                      <?php } ?>
                    </tr>
                    <tr>
                      <th>Classes</th>
                      <?php
                      foreach ($sessions  as $session) { ?>
                        <th style="text-align: center;">Maximum tuition fee in class</th>
                      <?php } ?>
                    </tr>

                    <?php
                    $form_complete = 1;
                    $previous_session_max_fee = array();
                    $previous_session_fee = array();

                    $query = "SELECT  MAX(`fee`.`tuitionFee`) as tuitionFee
                                FROM
                                    `fee`  WHERE `fee`.`school_id` = '" . $session->schoolId . "'";

                    $session_max_fee = $this->db->query($query)->row()->tuitionFee;


                    foreach ($classes  as $class) {
                      $add = 1;
                    ?>
                      <tr>
                        <th><?php echo $class->classTitle ?></th>
                        <?php
                        $session_count = 1;
                        foreach ($sessions  as $session) {
                          $query = "SELECT 
                                      `fee`.`addmissionFee`
                                    ,  `fee`.`feeId`
                                    , `fee`.`tuitionFee`
                                    , `fee`.`securityFund`
                                    , `fee`.`otherFund`
                                FROM
                                    `fee`  WHERE `fee`.`school_id` = '" . $session->schoolId . "'
                                    AND `fee`.`class_id` ='" . $class->classId . "'";

                          $session_fee = $this->db->query($query)->result()[0];
                          if ($session_fee) {
                            $add = 1;
                          } else {
                            $add = 0;
                          }

                        ?>
                          </td>
                          <td style="text-align: center; ">
                            <?php if ($session_count == 1) { ?>
                              <strong><?php echo $session_fee->tuitionFee; ?> </strong>
                            <?php } ?>
                            <?php if ($session_count == 1) {
                              @$number = (int) $session_fee->tuitionFee;
                              @$percentage = 10;
                              @$result = $number + ($number * $percentage / 100);
                              @$previous_session_max_fee[$class->classId] = $result;
                              @$previous_session_fee[$class->classId] = $number;
                            } ?>
                            <?php if ($session_count == 2) { ?>
                              <?php if ($session_fee->feeId) { ?>
                                <small style="margin-left:15px;">Maximum expected value:

                                  <strong><?php echo round($previous_session_max_fee[$class->classId], 2); ?></strong></small>

                                <input required type="number" <?php if ($previous_session_max_fee[$class->classId] > 0) { ?> max="<?php echo round($previous_session_max_fee[$class->classId], 2); ?>" <?php } ?> name="fee[<?php echo $session_fee->feeId; ?>]" value="<?php echo $session_fee->tuitionFee; ?>" />

                                <span style="margin-left: 5px; color:green">
                                  <?php

                                  $diff = $session_fee->tuitionFee - $previous_session_fee[$class->classId];
                                  if ($previous_session_fee[$class->classId]) {
                                    $percentage = ($diff / $previous_session_fee[$class->classId]) * 100;
                                  } else {
                                    $percentage = 0;
                                  }
                                  //printf("%2d", $percentage);
                                  echo round($percentage, 2);
                                  //$incress =  round((($session_fee->tuitionFee - $previous_session_fee[$class->classId]) / ($diff) * 100, 2);
                                  //echo round(((($session_fee->tuitionFee - $previous_session_fee[$class->classId]) / $session_fee->tuitionFee) * 100), 2);
                                  ?> %
                                </span>

                              <?php } else { ?>
                                <button type="button" onclick="add_class_fee('<?php echo $class->classId ?>', '<?php echo $class->classTitle; ?>', '<?php echo $session->schoolId; ?>')" class="btn btn-danger btn-sm">Add Class Fee</button>
                              <?php } ?>

                            <?php } ?>


                            <small style="margin-left: 10px;">
                              <i>
                                <?php
                                //$f = new NumberFormatter("in", NumberFormatter::SPELLOUT);
                                //echo ucwords(strtolower(convertNumberToWord($session_fee->tuitionFee)));
                                ?>
                              </i>
                            </small>
                          </td>


                        <?php
                          $session_count++;
                        } ?>

                      </tr>
                    <?php } ?>


                  </table>
                  <input class="btn btn-success" type="submit" name="update_section_e" value="Update Section E (Fee Data)" />
                  <br />
                  <br />
                  <p style="text-align: ;">
                    After updating, please remember to submit section E as well.
                  </p>

                  <input class="btn btn-danger" type="submit" name="update_section_e" value="Submit Section E" />


                </form>
              <?php } else {
                if ($school_session->status != 2) {
                  echo "Section E not allowed to update. <br />";
                }
                echo "Section E not open. if you want to open contact MIS wing.";
              }  ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  function add_class_fee(class_id, class_name, school_id) {
    $('.title').html('Add ' + class_name + ' Fee');
    $('#school_id').val(school_id);
    $('#class_id').val(class_id);

    $('#add_fee').modal('toggle');
  }
</script>
<!-- Modal -->
<div class="modal fade" id="add_fee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?php echo site_url("operation/add_class_fee"); ?>" method="post">
      <input type="text" name="schools_id" id="schools_id" value="<?php echo $schools_id; ?>" />
      <input type="text" name="school_id" id="school_id" value="" />
      <input type="text" name="session_id" id="session_id" value="<?php echo $session_id; ?>" />
      <input type="text" name="class_id" id="class_id" value="" />
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title title"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <tr>
              <th class="title"></th>
              <td><input type="number" class="form-control" name="tuitionFee" id="tuitionFee" /></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>