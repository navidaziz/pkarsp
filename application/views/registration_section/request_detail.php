<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
  .chat {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .chat li {
    margin-bottom: 5px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
  }

  .chat li.left .chat-body {
    margin-left: 10px;
  }

  .chat li.right .chat-body {
    margin-right: 60px;
  }


  .chat li .chat-body p {
    margin: 0;
    color: #777777;
  }

  .panel .slidedown .glyphicon,
  .chat .glyphicon {
    margin-right: 5px;
  }

  .panel-body {
    overflow-y: scroll;
    height: 250px;
  }

  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    background-color: #555;
  }

  .comment_image_left {
    width: 36px;
    margin-right: 10px;
  }

  .comment_image_right {
    width: 36px;
    margin-left: 10px;
  }

  .comment_textarea {
    overflow: hidden;
    border: 1px solid blue;
    border-radius: 5px;
    padding: 2px;
    width: 86%;
    min-height: 40px !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
    cursor: default;
    padding-left: 2px;
    padding-right: 5px;
    color: black !important;
    font-weight: bold !important;
  }
</style>
<style>
  .table2>tbody>tr>td,
  .table2>tbody>tr>th,
  .table2>tfoot>tr>td,
  .table2>tfoot>tr>th,
  .table2>thead>tr>td,
  .table2>thead>tr>th {
    padding: 2px;
    line-height: 1.42857143;
    vertical-align: top;
  }
</style>
<!-- <div class="modal-header">


</div> -->
<div class="modal-body">

  <div class="row">
    <div class="col-md-4" style="padding-right: 1px; padding-left: 1px;">
      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 5px; background-color: white;">
        <div style="text-align:center">
          <h3>
            <?php echo ucwords(strtolower($school->schoolName)); ?><br />

          </h3>
          <h4> School ID: <?php echo $school->schools_id ?>
            <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> Reg. ID:
              <?php echo $school->registrationNumber ?>
            <?php } ?>
          </h4>
          <small>
            <?php if ($school->division) {
              echo "Zone: <strong>" . $school->division . "</strong>";
            } ?>
            <?php if ($school->districtTitle) {
              echo " / District: <strong>" . $school->districtTitle . "</strong>";
            } ?>
            <?php if ($school->tehsilTitle) {
              echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
            } ?>

            <?php if ($school->ucTitle) {
              echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
            } ?></small>
        </div>

        <table class="table table2">
          <tr>
            <td><strong>Contact Detail </strong><br />
              <?php if ($school->telePhoneNumber) { ?>Telephone: <?php echo $school->telePhoneNumber ?> <?php } ?><br />
            <?php if ($school->schoolMobileNumber) { ?>Mobile: <?php echo $school->schoolMobileNumber ?> <?php } ?><br />
          <?php if ($school->principal_email) { ?>Email: <?php echo $school->principal_email ?> <?php } ?><br />
        Level: <?php if (!empty($school->levelofInstituteTitle)) : ?>
          <?php echo $school->levelofInstituteTitle; ?>
        <?php endif; ?>
        <br />
        Type: <?php if (!empty($school->typeTitle)) : ?>
          <strong><?php echo $school->typeTitle; ?></strong>
          <?php if (!empty($school->schoolTypeOther)) : ?>
            <strong><?php echo $school->schoolTypeOther; ?></strong>
          <?php endif; ?>
        <?php endif; ?>
        <br />Gen. Edu. <?php if (!empty($school->genderOfSchoolTitle)) : ?>
          <strong><?php echo $school->genderOfSchoolTitle; ?></strong>
        <?php endif; ?>
            </td>
            <td>
              <strong>Owner Detail </strong><br />
              <?php if ($school->userTitle) { ?>Name: <?php echo $school->userTitle ?> <?php } ?><br />
            <?php if ($school->cnic) { ?>CNIC: <?php echo $school->cnic ?> <?php } ?><br />
          <?php if ($school->contactNumber) { ?>Contact No: <?php echo $school->contactNumber ?> <?php } ?><br />

        Institute established: <strong>
          <?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong><br />

        <?php if (!empty($school->biseregistrationNumber)) { ?>
          <?php echo "BISE Registration No: " . $school->biseregistrationNumber; ?>
          <?php if ($school->bise_verified == "Yes") { ?>
            <strong style="color:green"> Verified </strong>
            <br />
            <?php if (!empty($school->primaryRegDate)) : ?>
              <?php echo "Primary Registeration Date: " . $school->primaryRegDate; ?>
              <br>
            <?php endif; ?>
            <?php if (!empty($school->middleRegDate)) : ?>
              <?php echo "Middle Registeration Date: " . $school->middleRegDate; ?>
              <br>
            <?php endif; ?>
            <?php if (!empty($school->highRegDate)) : ?>
              <?php echo "High Registeration Date: " . $school->highRegDate; ?>
              <br>
            <?php endif; ?>
            <?php if (!empty($school->interRegDate)) : ?>
              <?php echo "H.Secy/Inter College Registeration Date: " . $school->interRegDate; ?>
              <br>
            <?php endif; ?>
          <?php } else { ?>
            <strong style="color:red"> Not Verified </strong>
          <?php } ?>
        <?php } else { ?>
          BISE Rregistration: <strong>No</strong>
        <?php } ?>
        <br />
        First Appointment: <strong><?php echo date('d M, Y', strtotime($first_appointment_staff->appoinment_date)); ?></strong>
        ( <?php echo $first_appointment_staff->name ?> )<br />



            </td>
          </tr>
        </table>



      </div>

      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
          Session's History
        </h4>
        <?php

        $query = "SELECT
        `reg_type`.`regTypeTitle`,
        `levelofinstitute`.`levelofInstituteTitle`,
        `session_year`.`sessionYearTitle`,
        `school`.`renewal_code`,
        `school`.`status`,
        `school`.`created_date`,
        `school`.`updatedBy`,
        `school`.`updatedDate`,
        `school`.`schoolId`
        FROM
        `school`,
        `reg_type`,
        `gender`,
        
        `levelofinstitute`,
        `session_year`
        WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
        AND `gender`.`genderId` = `school`.`gender_type_id`
        
        AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
        AND `session_year`.`sessionYearId` = `school`.`session_year_id`
        AND schools_id = '" . $school->schools_id . "'
        AND session_year.sessionYearId <= '" . $session_request_detail->session_year_id . "'";
        $school_sessions = $this->db->query($query)->result(); ?>


        <table class="table table2">
          <tr>
            <th>Type</th>
            <th>Level</th>
            <th>Session</th>
            <th>Max Fee</th>
            <th style="color:red"><i class="fa fa-line-chart" aria-hidden="true"></i></th>
            <th>S-T</th>
            <th>Date</th>
            <th>N-S.</th>
            <th></th>
          </tr>
          <?php
          $previous_max = NULL;
          foreach ($school_sessions as $school_session) { ?>
            <?php if ($school_session->schoolId == $school_id and $school_session->schoolId != 1) { ?>
              <tr style="background-color: white !important; font-weight: bold;">
                <td colspan="9">Current Session</td>
              </tr>
            <?php } ?>
            <tr <?php if ($school_session->schoolId == $school_id) { ?> style="background-color: white !important; font-weight: bold;" <?php } ?> title="<?php echo  $school_session->schoolId; ?>">
              <td>
                <?php
                $words = explode(" ", $school_session->regTypeTitle);
                $acronym = "";

                foreach ($words as $w) {
                  echo strtoupper($w[0]);
                }
                ?></td>
              <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>
              <td>
                <a href="<?php echo site_url("print_file/school_session_detail/" . $school_session->schoolId); ?>" target="new">
                  <?php echo $school_session->sessionYearTitle; ?></a>
              </td>
              <td><?php
                  $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                  $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                  $max_tuition_fee = preg_replace(
                    '/[^0-9.]/',
                    '',
                    $this->db->query($query)->result()[0]->max_tution_fee
                  );
                  echo $max_tuition_fee;
                  ?> Rs.</td>
              <td><?php
                  if ($previous_max) {
                    $color = '';
                    $dec = $max_tuition_fee - $previous_max;
                    $inc = round(($dec / $max_tuition_fee) * 100, 2);
                    if ($inc > 10) {
                      $color = 'red';
                    } else {
                      $color = 'green';
                    }
                    if ($inc < 0) {
                      $color = 'red';
                    }
                  ?>
                  <span style="color:<?php echo $color; ?>"><?php echo  round(($dec / $max_tuition_fee) * 100, 2); ?></span>
                <?php   } ?>
              </td>
              <td><?php
                  $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                  echo $this->db->query($query)->result()[0]->total; ?></td>
              <td><?php
                  if ($school_session->updatedDate) {
                    echo date('d M, y', strtotime($school_session->updatedDate));
                  }
                  ?></td>
              <td><a href="<?php echo site_url("print_file/note_sheet/" . $school_session->schoolId); ?>" target="new">
                  <i class="fa fa-print" aria-hidden="true"></i></a></td>
              <td>
                <?php if ($school_session->status == 1) { ?>
                  <i class="fa fa-check" aria-hidden="true"></i>
                <?php } else { ?>
                  <i class="fa fa-spinner" aria-hidden="true"></i>
                <?php } ?>
              </td>
            </tr>
          <?php
            $previous_max = $max_tuition_fee;
          } ?>
        </table>

      </div>


      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
          Fine's
        </h4>
        <?php $query = "SELECT `fine_amount`, `remarks`, `created_date`, `is_fined` FROM `school_fine_history` WHERE school_id = '" . $schools_id . "'";
        $fines = $this->db->query($query)->result(); ?>
        <table class="table">
          <tr>
            <th>#</th>
            <th>Remarks</th>
            <th>Fine(Rs.)</th>
            <th>Status</th>
          </tr>
          <?php
          $count = 1;
          foreach ($fines as $fine) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $fine->remarks ?></td>
              <td><?php echo $fine->fine_amount ?></td>
              <td><?php echo $fine->is_fined ?></td>
            </tr>
          <?php } ?>
        </table>

      </div>

    </div>


    <div class="col-md-8" style="padding-right: 1px; padding-left: 1px;">
      <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
        Request for <strong><?php echo $session_request_detail->regTypeTitle ?></strong>
        session <strong><?php echo $session_request_detail->sessionYearTitle ?></strong>
        for level <strong><?php echo $session_request_detail->levelofInstituteTitle ?></strong> on
        <strong><?php echo date("d M, Y", strtotime($session_request_detail->created_date)); ?></strong>


      </h4>
      <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 10px;">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="col-md-12" style="padding-right: 1px; padding-left: 1px;">

        <!-- <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;"> -->

        <table class="table table-bordered table2" style="font-size: 13px;">
          <thead>
            <tr>
              <th>#</th>
              <th>Type</th>
              <th>STAN</th>
              <th>Date</th>
              <th>Application Processing Fee</th>
              <th>Inspection Fee</th>
              <th>Renewal Fee</th>
              <th>Upgradation Fee:</th>
              <th>Late Fee </th>
              <th>Security Fee:</th>
              <th>Fine</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>

            <?php $count = 1;
            foreach ($bank_challans as $bank_challan) { ?>
              <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $bank_challan->challan_for; ?></td>
                <td><?php echo $bank_challan->challan_no; ?></td>
                <td><?php echo date('d M, Y', strtotime($bank_challan->challan_date)); ?></td>
                <td><?php echo $bank_challan->application_processing_fee; ?></td>
                <td><?php echo $bank_challan->inspection_fee; ?></td>
                <td><?php echo $bank_challan->renewal_fee; ?></td>
                <td><?php echo $bank_challan->upgradation_fee; ?></td>
                <td><?php echo $bank_challan->late_fee; ?></td>
                <td><?php echo $bank_challan->security_fee; ?></td>
                <td><?php echo $bank_challan->fine; ?></td>
                <td><?php echo $bank_challan->total_deposit_fee; ?></td>

              </tr>
            <?php  } ?>

          </tbody>
        </table>

        <div style="border:1px solid #9FC8E8; border-radius: 10px;  margin: 5px; padding: 5px; background-color: white;">
          <strong> Is There Any Deficiency:
            <span style="margin-left: 10px;"></span>
            <input id="deficiency_yes" name="deficiency" type="radio" onclick="$('#deficiency_body').show()" value="1" /> Yes
            <span style="margin-left: 5px;"></span>
            <input id="deficiency_no" name="deficiency" type="radio" onclick="$('#deficiency_body').hide()" value="0" checked /> No
          </strong>
          <div id="deficiency_body" style="display: none;">
            <form method="post" action="<?php echo site_url("registration_section/send_deficiency"); ?>">

              <input type="hidden" value="<?php echo $session_id; ?>" name="session_id" />
              <input type="hidden" value="<?php echo $school_id; ?>" name="school_id" />
              <input type="hidden" value="<?php echo $school->schools_id; ?>" name="schools_id" />
              <table class="table">
                <tr>
                  <td>Deficiency Title: <input required name="deficiency_title" class="form-control" type="text" /><br />
                    Deficiency Detail:<br />
                    <textarea name="deficiency_detail" required rows="16" class="form-control"></textarea>
                  </td>
                  <td>
                    Bank Challan
                    <table class="table" style="width: 100%;">

                      <tr>
                        <td style="width: 200px;">
                          Application Processing Fee:</td>
                        <td><input class="deficiency_value" type="number" name="application_processing_fee" min="0" required /> </td>
                      </tr>
                      <tr>
                        <td>
                          Inspection Fee:
                        </td>
                        <td><input class="deficiency_value" type="number" name="inspection_fee" required min="0" /> </td>
                      </tr>


                      <tr>
                        <td> Renewal Fee:</td>
                        <td><input class="deficiency_value" type="number" name="renewal_fee" required min="0" /> </td>
                      </tr>


                      <tr>
                        <td>
                          Late Fee:
                        </td>
                        <td><input class="deficiency_value" type="number" name="late_fee" required min="0" /> </td>
                      </tr>
                      <tr>
                        <td>
                          Security Fee:
                        </td>
                        <td><input class="deficiency_value" type="number" name="security_fee" required min="0" /> </td>
                      </tr>
                      <tr>
                        <td>
                          Up-Gradation Fee:</td>
                        <td><input class="deficiency_value" type="number" name="upgradation_fee" required min="0" /> </td>
                      </tr>
                      <tr>
                        <td>
                          Renewal and Up-Gradation Fee:
                        </td>
                        <td><input class="deficiency_value" type="number" name="renewal_and_upgradation_fee" required min="0" /> </td>
                      </tr>
                      <tr>
                        <td>
                          Fine:
                        </td>
                        <td><input class="deficiency_value" type="number" name="fine" required min="0" /> </td>
                      </tr>

                      <tr>
                        <td>
                          Total Fee:
                        </td>
                        <td>
                          <strong id="totaldepositfee"></strong>
                          <input type="hidden" id="total_deposit_fee" name="total_deposit_fee" value="yes" required min="0" />
                        </td>
                      </tr>

                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: center;">
                    <input onclick="return confirm('Are you sure you want to submit?');" class="btn btn-danger" type="submit" value="Send Deficiency" name="Send_Deficiency" />
                  </td>
                </tr>
              </table>

            </form>
            <script>
              $(document).on("keyup", ".deficiency_value", function() {
                var sum = 0;
                $(".deficiency_value").each(function() {
                  sum += +$(this).val();
                });
                $("#total_deposit_fee").val(sum);
                $("#totaldepositfee").html(sum);

              });
            </script>
          </div>
        </div>

        <!-- </div> -->
        <div id="all_comments"> </div>
        <!-- inspection report -->
        <?php if ($session_request_detail->inspection_report) { ?>
          <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
            <h4>Inspection Report:</h4>
            <?php echo $session_request_detail->inspection_report;   ?>
          </div>
        <?php } ?>
        <?php if ($session_request_detail->status != 1) { ?>
          <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
            <div style="padding: 5px;">
              <?php $user_id = $this->session->userdata('userId'); ?>

              <strong> Do you want Mark To:
                <span style="margin-left: 10px;"></span>
                <input id="marked_yes" name="marked" type="radio" onclick="$('#mark_to').show()" value="1" /> Yes
                <span style="margin-left: 5px;"></span>
                <input id="marked_no" name="marked" type="radio" onclick="$('#mark_to').hide()" value="0" checked /> No
              </strong>
              <span style="margin-left: 10px;"></span>
              <select class="form-control" style="display: inline; width: 200px; display:none" id="mark_to">
                <option value="">General Remark</option>
                <?php

                $query = "SELECT  `users`.`userId`, `users`.`userTitle`, `roles`.`role_title` 
                           FROM
                           `roles`
                           INNER JOIN `users`
                           ON ( `roles`.`role_id` = `users`.`role_id` )
                           WHERE `roles`.`role_id` !=15
                            ORDER BY `roles`.`role_id`;";
                $users = $this->db->query($query)->result();

                foreach ($users as $user) { ?>
                  <option value="<?php echo $user->userId; ?>"><?php echo $user->userTitle . " - " . $user->role_title; ?></option>

                <?php } ?>
              </select>
            </div>

            <ul class="chat">
              <li class="left clearfix">
                <span class="chat-img pull-left">
                  <img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="comment_image_left">
                </span>
                <textarea name="comment" id="comment" class="form-control comment_textarea" min - rows="1" onkeyup="autoheight(this)"></textarea>
                <button onclick="submit_comment()" class="btn btn-info pull-right"> Submit </button>
                <small id="error_message" style="color:gray; margin-left: 50px;"></small>

              </li>
            </ul>

          </div>
        <?php } ?>

        <?php if ($session_request_detail->status != 1 and $session_request_detail->inspection == 1) { ?>


          <div id="renewal_option" style=" text-align:center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 5px; background-color: white;">

            <!-- Registration section -->
            <?php if ($session_request_detail->reg_type_id == 1) { ?>
              <h4>
                Do you want to allot a registration number?
                <input onclick="show_registration_form()" style="margin-left: 10px;" type="checkbox" name="i_want" id="i_want" />
              </h4>

              <h4 id="registration_form" style="display: none;">
                <table class="table" style="text-align: center;">
                  <tr>
                    <th style="text-align: center;">Allot Registration levels</th>
                  </tr>
                  <tr>
                    <td>
                      <?php
                      $query = "SELECT * FROM `levelofinstitute` 
                            WHERE `levelofinstitute`.`levelofInstituteId` <= '" . $session_request_detail->level_of_school_id . "'
                            ORDER BY `levelofinstitute`.`levelofInstituteId` ASC";



                      $levelofinstitutes = $this->db->query($query)->result();
                      foreach ($levelofinstitutes as $levelofinstitute) { ?>
                        <input <?php if ($session_request_detail->level_of_school_id == $levelofinstitute->levelofInstituteId) {
                                  echo 'checked';
                                } ?> class="reg_levels" name="reg_levels[]" value="<?php echo $levelofinstitute->levelofInstituteId;  ?>" type="checkbox" /> <?php echo $levelofinstitute->levelofInstituteTitle ?>
                        <span style="margin-right: 15px;"></span>
                      <?php } ?>
                    </td>

                  </tr>
                </table>

                Please Enter Account Password:
                <input class="form-control" style="width:150px;" type="text" onclick="$('#account_password').prop('type','password')" id="account_password" name="account_password" value="" autocomplete="off" />
                <br />
                <br />
                <button class="btn btn-success " onclick="allot_registration_number()">Allot Registration No.</button>
                <p id="allotment_error"></p>
              </h4>


            <?php } ?>
            <!-- Renewal Section -->
            <?php if ($session_request_detail->reg_type_id == 2) { ?>

              <h4>
                Do you want to Grant Renewal?
                <input onclick="show_registration_form()" style="margin-left: 10px;" type="checkbox" name="i_want" id="i_want" />
              </h4>

              <h4 id="registration_form" style="display: none;">
                <table class="table" style="text-align: center;">
                  <tr>
                    <th style="text-align: center;">Mention Renewal levels</th>
                  </tr>
                  <tr>
                    <td>
                      <?php
                      $query = "SELECT * FROM `levelofinstitute` 
                            WHERE `levelofinstitute`.`levelofInstituteId` <= '" . $session_request_detail->level_of_school_id . "'
                            ORDER BY `levelofinstitute`.`levelofInstituteId` ASC";
                      $levelofinstitutes = $this->db->query($query)->result();

                      foreach ($levelofinstitutes as $levelofinstitute) { ?>
                        <input <?php if ($session_request_detail->level_of_school_id == $levelofinstitute->levelofInstituteId) {
                                  echo 'checked';
                                } else {
                                  if ($school->primary_level == 1 and $levelofinstitute->levelofInstituteId == 1) {
                                    echo 'checked';
                                  }
                                  if ($school->middle_level == 1 and $levelofinstitute->levelofInstituteId == 2) {
                                    echo 'checked';
                                  }
                                  if ($school->high_level == 1 and $levelofinstitute->levelofInstituteId == 3) {
                                    echo 'checked';
                                  }
                                  if ($school->h_sec_college_level == 1 and $levelofinstitute->levelofInstituteId == 4) {
                                    echo 'checked';
                                  }
                                }

                                ?> class="renewal_levels" name="renewal_levels[]" value="<?php echo $levelofinstitute->levelofInstituteId;  ?>" type="checkbox" /> <?php echo $levelofinstitute->levelofInstituteTitle ?>
                        <span style="margin-right: 15px;"></span>
                      <?php } ?>
                    </td>

                  </tr>
                </table>

                Please Enter Account Password:
                <input class="form-control" style="width:150px;" type="text" onclick="$('#account_password').prop('type','password')" id="account_password" name="account_password" value="" autocomplete="off" />
                <button class="btn btn-success " onclick="grant_renewal()">Grant Renewal</button>
                <p id="allotment_error"></p>
              </h4>

            <?php } ?>

            <!-- UpgradationSection -->
            <?php if ($session_request_detail->reg_type_id == 3) { ?>
              <h4>
                Do you want to continue the upgradation process?
                <input onclick="show_registration_form()" style="margin-left: 10px;" type="checkbox" name="i_want" id="i_want" />
              </h4>

              <h4 id="registration_form" style="display: none;">
                <table class="table" style="text-align: center;">
                  <tr>
                    <th style="text-align: center;">Upgradation</th>
                    <th style="text-align: center;">Other Levels</th>
                  </tr>
                  <tr>

                    <td><strong>
                        Is the inspection report recommend the upgradation?
                        <input required onclick="$('.upgradationlist').show();" type="radio" class="is_upgrade" name="is_upgrade" value="1" /> Yes <span style="margin-right: 15px;"></span>
                        <input required onclick="$('.upgradationlist').hide();" type="radio" class="is_upgrade" name="is_upgrade" value="0" /> No <span style="margin-right: 25px;"></span> </strong>
                      <span class="upgradationlist" id="upgrade_list" style="display: none;">
                        <?php
                        $query = "SELECT * FROM `levelofinstitute` 
                            WHERE `levelofinstitute`.`levelofInstituteId` > '" . $session_request_detail->level_of_school_id . "'
                            ORDER BY `levelofinstitute`.`levelofInstituteId` ASC";
                        $levelofinstitutes = $this->db->query($query)->result();
                        foreach ($levelofinstitutes as $levelofinstitute) { ?>
                          <input class="upgrade_levels" type="checkbox" name="upgrade_levels[]" value="<?php echo $levelofinstitute->levelofInstituteId;  ?>" /> <?php echo $levelofinstitute->levelofInstituteTitle ?>
                          <span style="margin-right: 15px;"></span>
                        <?php } ?>
                      </span>
                    </td>
                    <td class="upgradationlist" id="upgradationlist" style="display: none;">
                      <?php
                      $query = "SELECT * FROM `levelofinstitute` 
                            WHERE `levelofinstitute`.`levelofInstituteId` <= '" . $session_request_detail->level_of_school_id . "'
                            ORDER BY `levelofinstitute`.`levelofInstituteId` ASC";
                      $levelofinstitutes = $this->db->query($query)->result();

                      foreach ($levelofinstitutes as $levelofinstitute) { ?>
                        <input <?php if ($session_request_detail->level_of_school_id == $levelofinstitute->levelofInstituteId) {
                                  echo 'checked';
                                } else {
                                  if ($school->primary_level == 1 and $levelofinstitute->levelofInstituteId == 1) {
                                    echo 'checked';
                                  }
                                  if ($school->middle_level == 1 and $levelofinstitute->levelofInstituteId == 2) {
                                    echo 'checked';
                                  }
                                  if ($school->high_level == 1 and $levelofinstitute->levelofInstituteId == 3) {
                                    echo 'checked';
                                  }
                                  if ($school->h_sec_college_level == 1 and $levelofinstitute->levelofInstituteId == 4) {
                                    echo 'checked';
                                  }
                                }

                                ?> class="upgrade_levels" name="upgrade_levels[]" value="<?php echo $levelofinstitute->levelofInstituteId;  ?>" type="checkbox" /> <?php echo $levelofinstitute->levelofInstituteTitle ?>
                        <span style="margin-right: 15px;"></span>
                      <?php } ?>
                    </td>
                  </tr>
                </table>
                Please Enter Account Password:
                <input class="form-control" style="width:150px;" type="text" onclick="$('#account_password').prop('type','password')" id="account_password" name="account_password" value="" autocomplete="off" />
                <button class="btn btn-success " onclick="grant_upgradation()">Complete Upgradation</button>
                <p id="allotment_error"></p>
              </h4>

            <?php } ?>

            <!-- Upgradation and Renewal Section -->
            <?php if ($session_request_detail->reg_type_id == 4) { ?>
              <h4>
                Do you want to process the Upgradation and Renewal?
                <input onclick="show_registration_form()" style="margin-left: 10px;" type="checkbox" name="i_want" id="i_want" />
              </h4>

              <h4 id="registration_form" style="display: none;">
                <table class="table" style="text-align: center;">
                  <tr>
                    <th style="text-align: center;">Other Levels</th>
                    <th style="text-align: center;">Upgradation</th>
                  </tr>
                  <tr>
                    <td>
                      <?php
                      $query = "SELECT * FROM `levelofinstitute` 
                            WHERE `levelofinstitute`.`levelofInstituteId` <= '" . $session_request_detail->level_of_school_id . "'
                            ORDER BY `levelofinstitute`.`levelofInstituteId` ASC";
                      $levelofinstitutes = $this->db->query($query)->result();
                      foreach ($levelofinstitutes as $levelofinstitute) { ?>
                        <input class="renewal_levels" name="renewal_levels[]" value="<?php echo $levelofinstitute->levelofInstituteId;  ?>" type="checkbox" checked /> <?php echo $levelofinstitute->levelofInstituteTitle ?>
                        <span style="margin-right: 15px;"></span>
                      <?php } ?>
                    </td>
                    <td><strong>
                        Is the inspection report recommended the upgradation?
                        <input required onclick="$('#upgrade_list').show();" type="radio" class="is_upgrade" name="is_upgrade" value="1" /> Yes <span style="margin-right: 15px;"></span>
                        <input required onclick="$('#upgrade_list').hide();" type="radio" class="is_upgrade" name="is_upgrade" value="0" /> No <span style="margin-right: 25px;"></span> </strong>
                      <span id="upgrade_list" style="display: none;">
                        <?php
                        $query = "SELECT * FROM `levelofinstitute` 
                            WHERE `levelofinstitute`.`levelofInstituteId` > '" . $session_request_detail->level_of_school_id . "'
                            ORDER BY `levelofinstitute`.`levelofInstituteId` ASC";
                        $levelofinstitutes = $this->db->query($query)->result();
                        foreach ($levelofinstitutes as $levelofinstitute) { ?>
                          <input class="upgrade_levels" type="checkbox" name="upgrade_levels[]" value="<?php echo $levelofinstitute->levelofInstituteId;  ?>" /> <?php echo $levelofinstitute->levelofInstituteTitle ?>
                          <span style="margin-right: 15px;"></span>
                        <?php } ?>
                      </span>
                    </td>
                  </tr>
                </table>

                Please Enter Account Password:
                <input class="form-control" style="width:150px;" type="text" onclick="$('#account_password').prop('type','password')" id="account_password" name="account_password" value="" autocomplete="off" />
                <button class="btn btn-success " onclick="grant_renewal_upgradation()">Grant Renewal</button>
                <p id="allotment_error"></p>
              </h4>

            <?php } ?>

          </div>

        <?php } ?>

        <?php if ($session_request_detail->status == 1 and  $session_request_detail->inspection == 1) { ?>
          <div class="block_div" style="text-align: center;">
            <h4>
              <?php if ($session_request_detail->reg_type_id == 1) { ?> Registered Successfully. <?php } ?>
              <?php if ($session_request_detail->reg_type_id == 2) { ?> Registration Renew Successfully. <?php } ?>
            </h4>
          </div>
        <?php } ?>
        <?php if ($session_request_detail->inspection == 0 and $session_request_detail->status == 3) { ?>
          <div class="block_div" style="text-align: center;">
            <h4>
              Please Forward Request for inspection.
              <form method="post" onSubmit="return confirm('Are you sure you want to forward?');" action="<?php echo site_url("registration_section/forward_for_inspection"); ?>">
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                <input class="btn btn-warning" type="submit" value="Forward" name="Forward" />
              </form>
            </h4>
          </div>
        <?php } ?>

        <?php if ($session_request_detail->inspection == 0 and $session_request_detail->status == 4) { ?>
          <div class="block_div" style="text-align: center;">
            <h4>
              Assign Inspection To:
              <form method="post" onSubmit="return confirm('Are you sure you want to assign?');" action="<?php echo site_url("registration_section/inspection_assignment"); ?>">
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                <select style="width: 200px;" class="form-control" name="inspection_by">
                  <?php

                  $query = "SELECT  `users`.`userId`, `users`.`userTitle`, `roles`.`role_title` 
                           FROM
                           `roles`
                           INNER JOIN `users`
                           ON ( `roles`.`role_id` = `users`.`role_id` )
                           AND  `roles`.`role_id` !=15;";
                  $users = $this->db->query($query)->result();

                  foreach ($users as $user) { ?>
                    <option value="<?php echo $user->userId; ?>"><?php echo $user->userTitle . " - " . $user->role_title; ?></option>

                  <?php } ?>
                </select>
                <input class="btn btn-warning" type="submit" value="Assign" name="Assign" />
              </form>
            </h4>
          </div>
        <?php } ?>

        <?php if ($session_request_detail->inspection == 0 and $session_request_detail->status == 5) { ?>
          <div class="block_div" style="text-align: center;">
            <h4>
              Submit inspection report
              <form method="post" onSubmit="return confirm('Are you sure you want to submit inspection report?');" onkeyup="autoheight(this)" action="<?php echo site_url("registration_section/submit_inspection_report"); ?>">
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                <textarea class="form-control comment_textarea" onkeyup="autoheight(this)" style="width: 100% !important; min-height:50px" name="inspection_report"></textarea>
                <input class="btn btn-warning" type="submit" value="Submit Inspection Report" name="Submit Inspection Report" />
              </form>
            </h4>
          </div>
        <?php } ?>
      </div>



    </div>

  </div>
  <script>
    function show_registration_form() {
      if ($('#i_want').prop('checked') == true) {
        $('#registration_form').show();
        $('#account_password').val("");
        $('#account_password').prop('type', 'text');

      } else {
        $('#registration_form').hide();
        $('#account_password').val("");
        $('#account_password').prop('type', 'text');
      }
    }

    function allot_registration_number() {
      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }
        var reg_levels = [];
        $('.reg_levels:checked').each(function(i, e) {
          reg_levels.push($(this).val());
        });
        if (reg_levels.length === 0) {
          alert("Please select atleast one level for registration.");
          return false;
        }


        $.ajax({
            method: "POST",
            url: "<?php echo site_url('registration_section/allot_registration_number'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              reg_levels: reg_levels
            }
          })
          .done(function(respose) {
            //$('#allotment_error').html(respose);
            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
              inspection_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }
          });


      } else {
        alert("Please click on i want registration number.");
      }
    }


    function grant_renewal_upgradation() {

      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }

        if ($(".is_upgrade").is(":checked") == false) {
          alert('Please check on "Do you want to upgrade Yes or Not"');
          return false;
        }
        var upgrade = '';
        var upgrade_levels = [];
        if ($(".is_upgrade").prop("checked")) {
          upgrade = 'Yes';
          $('.upgrade_levels:checked').each(function(i, e) {
            upgrade_levels.push($(this).val());
          });
          if (upgrade_levels.length === 0) {
            console.log("Array Empty.");
            alert("If you want to upgrade Please select recommended levels.");
            return false;
          }
        } else {
          upgrade = 'No';
        }

        var renewal_levels = [];
        $('.renewal_levels:checked').each(function(i, e) {
          renewal_levels.push($(this).val());
        });

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('registration_section/grant_renewal_and_upgrade'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              upgrade: upgrade,
              renewal_levels: renewal_levels,
              upgrade_levels: upgrade_levels

            }
          })
          .done(function(respose) {

            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
              inspection_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }

          });


      } else {
        alert("Please click on i want registration number.");
      }
    }

    function grant_upgradation() {

      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }

        if ($(".is_upgrade").is(":checked") == false) {
          alert('Please check on "Do you want to upgrade Yes or Not"');
          return false;
        }
        var upgrade = '';
        var upgrade_levels = [];
        if ($(".is_upgrade").prop("checked")) {
          upgrade = 'Yes';
          $('.upgrade_levels:checked').each(function(i, e) {
            upgrade_levels.push($(this).val());
          });
          if (upgrade_levels.length === 0) {
            console.log("Array Empty.");
            alert("If you want to upgrade Please select recommended levels.");
            return false;
          }
        } else {
          upgrade = 'No';
        }

        var renewal_levels = [];
        $('.renewal_levels:checked').each(function(i, e) {
          renewal_levels.push($(this).val());
        });

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('registration_section/grant_upgradation'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              upgrade: upgrade,
              renewal_levels: renewal_levels,
              upgrade_levels: upgrade_levels

            }
          })
          .done(function(respose) {

            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
              inspection_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }

          });


      } else {
        alert("Please click on i want registration number.");
      }
    }

    function grant_renewal() {

      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }


        var renewal_levels = [];
        $('.renewal_levels:checked').each(function(i, e) {
          renewal_levels.push($(this).val());
        });
        if (renewal_levels.length === 0) {
          alert("Please select atleast one level for Renewal.");
          return false;
        }

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('registration_section/grant_renewal'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              renewal_levels: renewal_levels
            }
          })
          .done(function(respose) {

            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }

          });


      } else {
        alert("Please click on i want registration number.");
      }
    }


    function submit_comment() {
      var comment = $('#comment').val();
      if (comment != "") {

        var mark_to = '';
        var marked = $("input[name='marked']:checked").val();

        if (marked == '1') {
          mark_to = $("#mark_to option:selected").val();
        }

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('registration_section/add_comment'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              comment: comment,
              mark_to: mark_to
            }
          })
          .done(function(respose) {
            if (respose == 1) {
              get_comments();
              $('#comment').val("");
              $('#mark_to').val('');
              $("#marked_yes").prop("checked", false);
              $("#marked_no").prop("checked", true);
              $('#mark_to').hide()
            }
          });
      } else {
        $('#error_message').fadeIn('slow');
        $('#error_message').html('Please write comment.');
        $('#error_message').delay(1000).fadeOut('slow');
      }
    }

    function autoheight(x) {
      x.style.height = "5px";
      x.style.height = (15 + x.scrollHeight) + "px";
    }

    function get_comments() {

      $.ajax({
          method: "POST",
          url: "<?php echo site_url('registration_section/get_comments'); ?>",
          data: {
            session_id: <?php echo $session_id; ?>,
            school_id: <?php echo $school_id; ?>,
            schools_id: <?php echo $school->schools_id; ?>
          }
        })
        .done(function(respose) {
          $('#all_comments').html(respose);
        });
    }

    function tage_users() {
      var user_ids = $('#users').val();

      $.ajax({
          method: "POST",
          url: "<?php echo site_url('registration_section/tag_users'); ?>",
          data: {
            session_id: <?php echo $session_id; ?>,
            school_id: <?php echo $school_id; ?>,
            schools_id: <?php echo $school->schools_id; ?>,
            selected_users: user_ids,
          }
        })
        .done(function(respose) {
          if (respose == '1') {
            $('#tag_users_message').fadeIn('slow');
            $('#tag_users_message').html("Officers Tagged.");
            $('#tag_users_message').delay(1000).fadeOut('slow');
          }
        });

    }

    get_comments();
    $("#users").select2({
      placeholder: "Please Select User"
    });
    $("#tag_user").select2({
      placeholder: "Please Select User"
    });
  </script>