<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small>
      <?php if ($school->district_id) {
        echo "District: <strong>" . $school->districtTitle . "</strong>";
      } ?>
      <?php if ($school->tehsil_id) {
        echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
      } ?>
      <?php if ($school->pkNo) {
        echo " / Pk: <strong>" . $school->pkNo . "</strong>";
      } ?>
      <?php if ($school->uc_id) {
        echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
      } ?></small>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">School Dashboard</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content ">

    <div class="box box-primary box-solid">
      <div class="box-body">

        <div class="row">
          <div class="col-md-3">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
              <h2>School ID: <?php echo $school->schoolId ?></h2>
              <h3>Reg. ID: <?php echo $school->registrationNumber ?></h3>
              <br />
              <?php if (!empty($school->yearOfEstiblishment)) : ?>
                <?php echo "Established In: " . $school->yearOfEstiblishment; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->levelofInstituteTitle)) : ?>
                <?php echo "Institute Level: " . $school->levelofInstituteTitle; ?>
                <br>
              <?php endif; ?>

              <?php if (!empty($school->genderOfSchoolTitle)) : ?>
                <?php echo "Gender Education: " . $school->genderOfSchoolTitle; ?>
                <br>
              <?php endif; ?>

              <?php if (!empty($school->telePhoneNumber)) : ?>
                <?php echo "Tele-Phone #: " . $school->telePhoneNumber; ?>
                <br>
              <?php endif; ?>



              <?php if (!empty($school->typeTitle)) : ?>
                <?php echo "School System: " . $school->typeTitle; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->schoolTypeOther)) : ?>
                <?php echo "School Level: " . $school->schoolTypeOther; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->mediumOfInstruction)) : ?>
                <?php echo "Medium Of Instruction: " . $school->mediumOfInstruction; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->managementTitle)) : ?>
                <?php echo "Management: " . $school->managementTitle; ?>
                <br>
              <?php endif; ?>
              <b>Bise Information</b><br>
              <?php if (!empty($school->biseregistrationNumber)) : ?>
                <?php echo "Bise Register: " . $school->biseregistrationNumber; ?>
                <br>
              <?php endif; ?>
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
              <?php if (!empty($school->biseAffiliated)) : ?>
                <?php echo "Bise Affiliation: " . $school->biseAffiliated; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->biseName) && $school->bise_id != 10) : ?>
                <?php echo "Bise Affiliated With: " . $school->biseName; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($school->otherBiseName)) : ?>
                <?php echo "Bise Affiliated With: " . $school->otherBiseName; ?>
                <br>
              <?php endif; ?>
              <?php if (!empty($bank_transaction)) : ?>
                <?php $count = 1;
                foreach ($bank_transaction as $bt) {
                  echo "<strong>Transaction</strong> # $count: " . $bt['bt_no'] . ' ' . "<strong> Date</strong>: " . $bt['bt_date'] . "<br>";
                  $count++;
                }  ?>
                <br>
              <?php endif; ?>

              <address>
                <strong>Adress</strong><br>

                <?php if (!empty($school->address)) : ?>
                  <?php echo $school->address; ?>
                  <br />
                <?php endif; ?>

                <?php if (!empty($school->late)) : ?>
                  <b>Latitude:</b>
                  <?php echo @$school->late; ?>
                  <br />
                <?php endif; ?>
                <?php if (!empty($school->longitude)) : ?>
                  <b>Longitude:</b>
                  <?php echo @$school->longitude; ?>
                <?php endif; ?>
              </address>

            </div>
          </div>

          <div class="col-md-4">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
              <?php
              $query =
                "SELECT COUNT(`message_for_all`.`message_id`) as total FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where `message_school`.`school_id`=$school_id";
              $query_result = $this->db->query($query);
              $total_messages = $query_result->result()[0]->total; ?>

              <h4><i class="fa fa-envelope-o"></i> Inbox Messages
                <span class="label label-primary pull-right"><?php echo $total_messages; ?></span>
              </h4>


              <?php
              $query =
                "SELECT message_for_all.*,`message_school`.`school_id` FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where `message_school`.`school_id`=$school_id  order by `message_for_all`.`message_id` DESC LIMIT 10";
              $query_result = $this->db->query($query);
              $school_messages = $query_result->result(); ?>
              <table class="table">
                <?php
                foreach ($school_messages as $message) : ?>
                  <tr>

                    <td class=" message">
                      <a target="_new" href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                        <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                      </a>
                      <small style="display: block; color:gray" class="pull-right">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                    </td>

                  </tr>

                <?php endforeach; ?>

              </table>
              <?php if ($total_messages > 6) { ?>
                <div style="text-align: center;">
                  <a class="btn btn-primary btn-sm" href="<?php echo site_url('messages/inbox'); ?>"><i class="fa fa-envelope-o"></i> All Inbox Messages</a>
                </div>
              <?php } ?>
            </div>
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">

              <?php $query = "SELECT COUNT(*) as total FROM `message_for_all` 
                     WHERE `message_for_all`.`select_all`='yes'";
              $query_result = $this->db->query($query);
              $total_notifications = $query_result->result()[0]->total; ?>
              <h4><i class="fa fa-bell-o" aria-hidden="true"></i> PSRA Notifications
                <span class="label label-success pull-right"><?php echo $total_notifications; ?></span>
              </h4>

              <?php
              $query =
                "SELECT message_for_all.*,`message_school`.`school_id` FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where`message_for_all`.`select_all`='yes'  order by `message_for_all`.`message_id` DESC LIMIT 6";
              $query_result = $this->db->query($query);
              $notifications = $query_result->result(); ?>
              <table class="table">
                <?php
                foreach ($notifications as $message) : ?>
                  <tr>

                    <td class=" message">
                      <a target="_new" href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                        <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                      </a>
                      <small style="display: block; color:gray" class="pull-right">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                    </td>

                  </tr>

                <?php endforeach; ?>
              </table>
              <?php if ($total_notifications > 6) { ?>
                <div style="text-align: center;">
                  <a class="btn btn-success btn-sm" href="<?php echo site_url('messages/inbox'); ?>"><i class="fa fa-bell-o"></i> All Notifications</a>
                </div>
              <?php } ?>
            </div>
          </div>

          <div class="col-md-5">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">


              <?php if ($school->registrationNumber) { ?>
                <h3>Registration and renewal detail</h3>
                <table class="table table-bordered">
                  <tr>
                    <th>S/No.</th>
                    <th>Session</th>
                    <th>Applied</th>
                    <th>Level</th>
                    <th>Status</th>
                  </tr>
                  <?php
                  $count = 1;
                  $stop_appy = TRUE;
                  // echo  $query = "SELECT * FROM session_year WHERE sessionYearTitle >= '" . date('Y', strtotime($school->yearOfEstiblishment)) . "-" . (date('Y', strtotime($school->yearOfEstiblishment)) + 1) . "' ORDER BY sessionYearId ASC";
                  //$sessions = $this->db->query($query)->result();
                  $est_date = $this->input->post('year_of_es');
                  $est_year = date('Y', strtotime($school->yearOfEstiblishment));
                  $est_month = date('m', strtotime($school->yearOfEstiblishment));
                  if ($est_month >= 4) {
                    $session_year = $est_year;
                  } else {
                    $session_year = $est_year - 1;
                  }



                  $query = "SELECT * FROM `session_year` WHERE YEAR(`session_start`) >= '" . $session_year . "'";
                  $sessions = $this->db->query($query)->result();
                  foreach ($sessions as $session) {
                    $query = "SELECT
                      `reg_type`.`regTypeTitle`
                      , `school_type`.`typeTitle`
                      , `levelofinstitute`.`levelofInstituteTitle`
                      , `gender`.`genderTitle`
                      , `school`.`status`
                      , `school`.`status_type`
                      , `school`.`session_year_id`
                      , `school`.`schoolId` as school_id
                      , `school`.`schools_id`
                      , `school`.`status`

                  FROM `reg_type`,
                  `school`,
                  `school_type`,
                  `levelofinstitute`,
                  `gender`  
                  WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                  AND `school_type`.`typeId` = `school`.`school_type_id`
                  AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                  AND `gender`.`genderId` = `school`.`gender_type_id`
                  AND school.`schools_id`= '" . $school_id . "'
                  AND `school`.`session_year_id` = '" . $session->sessionYearId . "'";
                    $registaion_and_renewals = $this->db->query($query)->result();

                    if ($registaion_and_renewals) {
                      $registaion_and_renewal = $registaion_and_renewals[0]; ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $session->sessionYearTitle; ?></td>
                        <td><?php echo $registaion_and_renewal->regTypeTitle; ?></td>
                        <td><?php echo $registaion_and_renewal->levelofInstituteTitle; ?></td>

                        <td>
                          <?php if ($registaion_and_renewal->status == 0) { ?>
                            <a class="btn btn-success" href="<?php echo site_url("form/section_b/$registaion_and_renewal->session_year_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Complete Renewal Process</a>
                          <?php } else {   ?>
                            <?php if ($registaion_and_renewal->status == 1) { ?>
                              <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $registaion_and_renewal->schools_id . "/" . $registaion_and_renewal->school_id . "/" . $registaion_and_renewal->session_year_id); ?>">Print Certificate<a>
                                <?php } else { ?>
                                  <a class="btn btn-success" href="<?php echo site_url("online_application/status/$registaion_and_renewal->session_year_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i>Inprogress View Status</a>

                              <?php }
                            } ?>
                        </td>

                      </tr>
                    <?php   } else { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $session->sessionYearTitle; ?></td>
                        <td colspan="4" style="text-align: center;">
                          <?php if ($stop_appy) { ?>
                            <a class="btn btn-success" style="margin: 1px;" href="<?php echo site_url("apply/renewal/$session->sessionYearId"); ?>">Apply for Renewal</a>
                            <?php if ($session->status == 1) {  ?>
                              <a class="btn btn-warning" style="margin: 1px;" href="<?php echo site_url("apply/upgradation/$session->sessionYearId"); ?>">Upgradation</a>

                              <a class="btn btn-warning" style="margin: 1px;" href="<?php echo site_url("apply/renewal_upgradation/$session->sessionYearId"); ?>">Apply for Upgradation + Renewal</a>
                            <?php } ?>
                          <?php } else { ?>

                          <?php } ?>
                        </td>

                      </tr>
                  <?php
                      $stop_appy = FALSE;
                    }
                  } ?>
                </table>
              <?php } else { ?>
                <div style="text-align: center;">
                  <h4>Apply for PSRA institute Registration</h4>
                  <?php

                  $est_date = $this->input->post('year_of_es');
                  $est_year = date('Y', strtotime($school->yearOfEstiblishment));
                  $est_month = date('m', strtotime($school->yearOfEstiblishment));
                  if ($est_month >= 4) {
                    $session_year = $est_year;
                  } else {
                    $session_year = $est_year - 1;
                  }



                  $query = "SELECT * FROM `session_year` WHERE YEAR(`session_start`) >= '" . $session_year . "'";
                  $session = $this->db->query($query)->result()[0];


                  // $query = "SELECT * FROM session_year 
                  //         WHERE sessionYearTitle >= '" . date('Y', strtotime($school->yearOfEstiblishment)) . "-" . (date('Y', strtotime($school->yearOfEstiblishment)) + 1) . "' 
                  //         ORDER BY sessionYearId ASC LIMIT 1";
                  // $session = $this->db->query($query)->result()[0];

                  $query = "SELECT * FROM school 
                  WHERE schools_id = '" . $school_id . "' ";
                  $registration = $this->db->query($query)->result();
                  $registration_session_id = $registration[0]->session_year_id;
                  ?>
                  <?php if ($registration) { ?>
                    <?php if ($registration[0]->status == 0) { ?>
                      <a class="btn btn-success" href="<?php echo site_url("form/section_b/$registration_session_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Complete Registration Process <?php echo $session->sessionYearTitle; ?></a>
                    <?php }   ?>
                    <?php if ($registration[0]->status == 2) { ?>
                      <a class="btn btn-success" href="<?php echo site_url("online_application/status/$registration_session_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Bank Challan Verification Session <?php echo $session->sessionYearTitle; ?></a>
                    <?php } ?>
                  <?php } else { ?>
                    <a class="btn btn-primary" href="<?php echo site_url("apply/registration/$session->sessionYearId"); ?>">Apply for Registraion. <?php echo $session->sessionYearTitle; ?></a>
                  <?php } ?>

                </div>
              <?php  } ?>


            </div>

            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
              <h4>Other Online Requests</h4>
              <a class="btn btn-primary" href="<?php echo site_url('change/of_name'); ?>">
                <i class="fa fa-edit"></i>
                Change of Name</a>
              <a class="btn btn-success" href="<?php echo site_url('change/of_building'); ?>">
                <i class="fa fa-building"></i>
                Change of Building</a>

              <a class="btn btn-warning" href="<?php echo site_url('change/of_ownership'); ?>">
                <i class="fa fa-user" aria-hidden="true"></i>
                Change of Ownership</a>

            </div>
          </div>


        </div>
      </div>
    </div>
  </section>
</div>