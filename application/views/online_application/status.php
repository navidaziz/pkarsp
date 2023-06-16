  <!-- Modal -->
  <script>
    function update_class_fee_detail(class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_fee_from"); ?>",
        data: {
          schools_id: <?php echo $school->schoolId; ?>,
          class_id: class_id,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>
        }
      }).done(function(data) {

        $('#update_class_ages_body').html(data);
      });

      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="update_class_ages_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->load->view('forms/form_header');   ?>


    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <div class="box box-primary box-solid">


        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div style="text-align:center; margin:0px auto; width:70%; border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;   padding: 5px; background-color: white;">

                <h4> Online Applicaiton Status</h4>
                <h3> <?php echo $school->regTypeTitle ?> for <?php echo $school->levelofInstituteTitle; ?> Session: <?php echo $session_detail->sessionYearTitle; ?></h3>
                <p>
                  Your application has been successfully submitted online, and there is no need to submit any printed documents. PSRA officials will keep you informed about the progress of your application. Keep view PSRA school portal regularly. Make sure to regularly check the PSRA school portal for any updates.
                </p>
                <p style="direction: rtl;">
                  آپ کی درخواست کامیابی کے ساتھ آن لائن جمع کرائی گئی ہے، اور کوئی بھی پرنٹ شدہ دستاویزات جمع کرانے کی ضرورت نہیں ہے۔
                  <br />
                  PSRA کے اہلکار آپ کو آپ کی درخواست کی پیشرفت سے آگاہ کرتے رہیں گے۔
                  <br />
                  PSRA سکول پورٹل کو باقاعدگی سے دیکھیں۔
                  <br />
                  کسی بھی اپ ڈیٹ کے لیے "PSRA" اسکول پورٹل کو باقاعدگی سے چیک کرنا یقینی بنائیں۔
                </p>

                <h4>
                  <strong>
                    <?php echo get_session_request_status($school->status); ?>
                  </strong><br />
                  <br />





                  <a class="btn btn-warning" href="<?php echo site_url("school_dashboard"); ?>">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard
                    <i class="fa fa-dashboard"></i>
                  </a>
                  <a class="btn btn-primary" href="<?php echo site_url("section_c/update_section_c/$school_session_id"); ?>">
                    <i class="fa fa-edit" aria-hidden="true"></i> Edit Section C
                  </a>
                  <!-- <span style="margin-left: 20px;"></span>
                  <a target="_blank" class="btn btn-primary" href="<?php echo site_url("print_file/school_session_detail/" . $school->school_id); ?>">
                    <i class="fa fa-print" aria-hidden="true"></i> Print Data
                  </a> -->


                </h4>
                <?php
                $query = "SELECT section_e FROM school WHERE schoolId = '" . $school->school_id . "'";
                $section_e = $this->db->query($query)->row()->section_e;
                if ($section_e == 0) { ?>
                  <form action="<?php echo site_url('online_application/update_section_e') ?>" method="post">
                    <input type="hidden" value="<?php echo $school->school_id; ?>" name="school_id" />
                    <table class="table table-bordered">

                      <tr>
                        <th>Sessions</th>
                        <?php

                        $query = "SELECT * FROM class WHERE classId IN(SELECT class_id FROM fee WHERE school_id = '" . $school->school_id . "')";

                        $classes = $this->db->query($query)->result();
                        $query = "SELECT
                          `session_year`.`sessionYearTitle`
                          , `session_year`.`sessionYearId`
                          , `school`.`schoolId`
                          FROM
                          `school`
                          INNER JOIN `session_year` 
                          ON (`school`.`session_year_id` = `session_year`.`sessionYearId`)
                          WHERE  `school`.`schoolId` <= '" . $school->school_id . "'
                          AND school.schools_id = '" . $school->schools_id . "'
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
                                $number = $session_fee->tuitionFee;
                                $percentage = 10;
                                $result = $number + ($number * $percentage / 100);
                                $previous_session_max_fee[$class->classId] = $result;
                                $previous_session_fee[$class->classId] = $number;
                              } ?>
                              <?php if ($session_count == 2) { ?>
                                <small style="margin-left:15px;">Maximum expected value: <strong><?php echo round($previous_session_max_fee[$class->classId], 2); ?></strong></small>

                                <input required type="number" <?php if ($previous_session_max_fee[$class->classId] > 0) { ?> max="<?php echo round($previous_session_max_fee[$class->classId]); ?>" <?php } ?> name="fee[<?php echo $session_fee->feeId; ?>]" value="<?php echo $session_fee->tuitionFee; ?>" />

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
                <?php }  ?>







                <?php
                $bank_challan_button = 0;
                $query = "SELECT
                `bank_challans`.*,
                `session_year`.`sessionYearTitle`,
                `school`.`schools_id`,
                `school`.`status`
                    FROM
                      `school`,
                      `bank_challans`,
                      `session_year`
                    WHERE `school`.`schoolId` = `bank_challans`.`school_id`
                      AND `session_year`.`sessionYearId` = `bank_challans`.`session_id`
                      AND   `bank_challans`.`session_id` = '" . $session_id . "' 
                      AND   `bank_challans`.`school_id` = '" . $school->school_id . "'
                ORDER BY bank_challan_id ASC";
                $session_bank_challans = $this->db->query($query)->result(); ?>

                <!-- <table class="table">
                  <tr>
                    <th colspan="6">Bank Challan Detail</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Challan Type</th>
                    <th>STAN No</th>
                    <th>Deposit Date</th>
                    <th>Status</th>
                    <th>Remarks</th>
                  </tr>
                  <?php
                  $count = 1;
                  $bank_challan_button = 0;
                  foreach ($session_bank_challans as $session_bank_challan) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $session_bank_challan->challan_for; ?></td>
                      <td><?php echo $session_bank_challan->challan_no; ?></td>
                      <td> <?php echo date('d M, Y', strtotime($session_bank_challan->challan_date)); ?></td>
                      <td>

                        <?php if ($session_bank_challan->verified == 0) { ?>
                          Verification In Progress
                        <?php } ?>

                        <?php if ($session_bank_challan->verified == 1) { ?>
                          <?php echo $session_bank_challan->amount_deposit; ?> Verified.<br />

                        <?php } ?>

                        <?php if ($session_bank_challan->verified == 2) {
                          echo "Not Verified";
                          $bank_challan_button++;
                        } ?>
                      </td>
                      <td style="width: 40%; text-align: left;">
                        <strong>
                          <?php if ($session_bank_challan->verified == 2) {
                            echo $session_bank_challan->remarks;
                          } ?>
                        </strong>
                      </td>
                    </tr>
                  <?php  }  ?>
                  <?php if ($bank_challan_button >= 1 and $session_bank_challan->verified == 2 and $session_bank_challan->status == 8 and $session_bank_challan->challan_for != 'Deficiency') { ?>
                    <tr>
                      <td colspan="7">
                        <!-- <a class="btn btn-danger btn-sm" href="<?php echo site_url("form/submit_bank_challan/$school->school_id"); ?>">
                          Re Submit Bank Challan</a> -->


                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                  <h4>Re Submit Bank Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                  <form action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">

                    <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                    <input type="hidden" name="schools_id" value="<?php echo $school->schools_id; ?>" />
                    <input type="hidden" name="challan_for" value="<?php echo $session_bank_challan->challan_for ?>" />
                    <table class="table table-bordered">
                      <tr>
                        <td>Bank Transaction No (STAN)</td>
                        <td>Bank Transaction Date</td>
                      </tr>
                      <tr>
                        <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" class="form-control" />
                          <small>"STAN can be found on the upper right corner of bank generated receipt"</small>
                        </td>
                        <td><input required name="challan_date" type="date" class="form-control" />
                        </td>
                        <td><input type="submit" class="btn btn-danger " name="submit" value="Re Submit Bank Challan" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
                </td>
                </tr>
              <?php } ?>
              </table> -->

              <div class="row">
                <?php
                if ($school->status == 7) { ?>
                  <h3 style="text-align: center;">Deficiency</h3>
                  <?php $query = "SELECT * FROM deficiencies 
                                  WHERE status =0
                                  AND school_id = '" . $school->school_id . "'";
                  $deficiencies =  $this->db->query($query)->result();
                  foreach ($deficiencies as $deficiency) {

                    $query = "SELECT * FROM `bank_challans` WHERE  `bank_challans`.`deficiency_id`='" . $deficiency->deficiency_id . "'";
                    $d_bank_challan = $this->db->query($query)->result()[0];
                    if ($d_bank_challan->verified != 1) {
                  ?>
                      <div class="col-md-12">
                        <p><strong><?php echo $deficiency->deficiency_title; ?>
                            <?php //echo $deficiency->deficiency_type; 
                            ?></strong><br />
                          <?php echo $deficiency->deficiency_detail; ?></p>
                        <br />
                        <p style="text-align: center;">
                          <strong>Please print deficiency bank challan </strong><br />
                          <a target="_new" class="btn btn-danger" href="<?php echo site_url("deficiency/bank_challan/" . $deficiency->deficiency_id); ?>">Pint Deficiency Bank Challan</a>
                        </p>
                      </div>
                      <div class="col-md-12">
                        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                          <h4>Submit Deficiency Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                          <form action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">
                            <input type="hidden" name="deficiency_id" value="<?php echo $deficiency->deficiency_id; ?>" />
                            <input type="hidden" name="last_status" value="<?php echo $deficiency->last_status; ?>" />
                            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                            <input type="hidden" name="schools_id" value="<?php echo $school->schools_id; ?>" />
                            <input type="hidden" name="challan_for" value="Deficiency" />
                            <table class="table table-bordered">
                              <tr>
                                <td>Bank Transaction No (STAN)</td>
                                <td>Bank Transaction Date</td>
                              </tr>
                              <tr>
                                <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" class="form-control" />
                                  <small>"STAN can be found on the upper right corner of bank generated receipt"</small>
                                </td>
                                <td><input required name="challan_date" type="date" class="form-control" />
                                </td>
                                <td><input type="submit" class="btn btn-success" name="submit" value="Submit Bank Challan" />
                                </td>
                              </tr>
                            </table>
                          </form>
                        </div>
                      </div>
                    <?php } ?>
                  <?php } ?>
                  <h4></h4>
                <?php } ?>

              </div>
              </div>


            </div>

          </div>







        </div>
      </div>


  </div>

  </section>

  </div>