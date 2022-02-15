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
        echo " / Union Council: <strong>" . $school->ucTitle . "</strong>";
      } ?></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
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
              <?php if ($school->registrationNumber > 0) { ?>
                <h3>Reg. ID: <?php echo $school->registrationNumber ?></h3>
                <br />
              <?php } ?>
              <?php if (!empty($school->yearOfEstiblishment)) : ?>
                <?php echo "Established In: " . date("M, Y", strtotime($school->yearOfEstiblishment)); ?>
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
              <?php if (!empty($school->schoolMobileNumber)) : ?>
                <?php echo "Mobile #: " . $school->schoolMobileNumber; ?>
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
              <b>BISE Information</b><br>
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
                <strong>Address</strong><br>

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
              <?php


              if ($school->registrationNumber) { ?>
                <h3>Registration and renewal detail</h3>
                <table class="table table-bordered">
                  <tr>
                    <th>S/No.</th>
                    <th>Print</th>
                    <th>Session</th>
                    <th>Applied</th>
                    <th>Level</th>
                    <th>Status</th>
                  </tr>

                  <?php
                  $count = 1;
                  $stop_appy = TRUE;
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
                           ,`session_year`.`sessionYearTitle`
                       FROM `reg_type`,
                       `school`,
                       `school_type`,
                       `levelofinstitute`,
                       `gender`,
                       `session_year`  
                       WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                       AND `school_type`.`typeId` = `school`.`school_type_id`
                       AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                       AND `gender`.`genderId` = `school`.`gender_type_id`
                       AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                       AND school.`schools_id`= '" . $school_id . "'
                       AND `school`.`reg_type_id` = 1";
                  $registration_detail = $this->db->query($query)->result()[0];
                  if ($registration_detail) {
                  ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><a href="<?php echo site_url("print_file/school_session_detail/" . $registration_detail->school_id); ?>" target="new">Print</a></td>
                      <td><?php echo $registration_detail->sessionYearTitle; ?></td>
                      <td><?php echo $registration_detail->regTypeTitle; ?></td>
                      <td><?php echo $registration_detail->levelofInstituteTitle; ?></td>
                      <td>
                        <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $registration_detail->schools_id . "/" . $registration_detail->school_id . "/" . $registration_detail->session_year_id); ?>">Print Certificate<a>
                      </td>
                    </tr>
                  <?php } ?>
                  <?php
                  $query = "SELECT * FROM `session_year` 
                            WHERE `session_year`.`sessionYearId` > '" . $registration_detail->session_year_id . "'
                            AND status=0";
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
                      ,`session_year`.`sessionYearTitle`

                      FROM `reg_type`,
                      `school`,
                      `school_type`,
                      `levelofinstitute`,
                      `gender`,
                      `session_year`  
                      WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                      AND `school_type`.`typeId` = `school`.`school_type_id`
                      AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                      AND `gender`.`genderId` = `school`.`gender_type_id`
                      AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                      AND school.`schools_id`= '" . $school_id . "'
                      AND `school`.`session_year_id` = '" . $session->sessionYearId . "'";
                    $upgradation_and_renewals = $this->db->query($query)->result();
                    if ($upgradation_and_renewals) {
                      foreach ($upgradation_and_renewals as $upgradation_and_renewal) { ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><a href="<?php echo site_url("print_file/school_session_detail/" . $upgradation_and_renewal->school_id); ?>" target="new">Print</a></td>
                          <td><?php echo $upgradation_and_renewal->sessionYearTitle; ?></td>
                          <td><?php echo $upgradation_and_renewal->regTypeTitle; ?></td>
                          <td><?php echo $upgradation_and_renewal->levelofInstituteTitle; ?></td>
                          <td>
                            <?php if ($upgradation_and_renewal->status == 0) {

                              $query = "SELECT * FROM `forms_process` WHERE  `forms_process`.`school_id` = $upgradation_and_renewal->school_id";

                              $form_stauts = $this->db->query($query)->result()[0];
                              if (
                                $form_stauts->form_b_status == 1
                                and $form_stauts->form_c_status == 1
                                and $form_stauts->form_d_status == 1
                                and $form_stauts->form_e_status == 1
                                and $form_stauts->form_f_status == 1
                                and $form_stauts->form_g_status == 1
                                and $form_stauts->form_h_status == 1
                              ) {
                                $page_link = 'submit_bank_challan';
                              } else {
                                $page_link = 'section_b';
                              }

                              if ($form_stauts->form_b_status == 1) {
                                $page_link = 'section_c';
                              }
                              if ($form_stauts->form_c_status == 1) {
                                $page_link = 'section_d';
                              }
                              if ($form_stauts->form_d_status == 1) {
                                $page_link = 'section_e';
                              }
                              if ($form_stauts->form_e_status == 1) {
                                $page_link = 'section_f';
                              }
                              if ($form_stauts->form_f_status == 1) {
                                $page_link = 'section_g';
                              }
                              if ($form_stauts->form_g_status == 1) {
                                $page_link = 'section_h';
                              }
                              if ($form_stauts->form_h_status == 1) {
                                $page_link = 'submit_bank_challan';
                              }



                            ?>

                              <a class="btn btn-success" href="<?php echo site_url("form/$page_link/$upgradation_and_renewal->school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Complete Renewal Process</a>
                            <?php } else {   ?>
                              <?php if ($upgradation_and_renewal->status == 1) { ?>
                                <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $upgradation_and_renewal->schools_id . "/" . $upgradation_and_renewal->school_id . "/" . $upgradation_and_renewal->session_year_id); ?>">Print Certificate<a>
                                  <?php } else { ?>
                                    <a class="btn btn-success" href="<?php echo site_url("online_application/status/$upgradation_and_renewal->school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Application Inprogress</a>

                                <?php }
                              } ?>
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } else { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $session->sessionYearTitle; ?></td>

                        <td colspan="3" style="text-align: center;">
                          <a class="btn btn-success" style="margin: 1px;" href="<?php echo site_url("apply/renewal/$session->sessionYearId"); ?>">Apply for <?php echo $session->sessionYearTitle; ?> Renewal</a>
                        </td>
                        </td>
                      </tr>
                    <?php } ?>
                  <?php   }  ?>






                  <?php
                  $query = "SELECT * FROM `session_year` 
                            WHERE `session_year`.`sessionYearId` > '" . $registration_detail->session_year_id . "'
                            AND status=1";
                  $session = $this->db->query($query)->result()[0];
                  ?>

                  <?php
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
                      ,`session_year`.`sessionYearTitle`

                      FROM `reg_type`,
                      `school`,
                      `school_type`,
                      `levelofinstitute`,
                      `gender`,
                      `session_year`  
                      WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                      AND `school_type`.`typeId` = `school`.`school_type_id`
                      AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                      AND `gender`.`genderId` = `school`.`gender_type_id`
                      AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                      AND school.`schools_id`= '" . $school_id . "'
                      AND `school`.`session_year_id` = '" . $session->sessionYearId . "'
                      AND (`school`.`reg_type_id`=2 or `school`.`reg_type_id`=4)";
                  $renewal = $this->db->query($query)->result()[0];
                  if ($renewal) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><a href="<?php echo site_url("print_file/school_session_detail/" . $upgradation_and_renewal->school_id); ?>" target="new">Print</a></td>

                      <td><?php echo $renewal->sessionYearTitle; ?></td>
                      <td><?php echo $renewal->regTypeTitle; ?></td>
                      <td><?php echo $renewal->levelofInstituteTitle; ?></td>
                      <td>
                        <?php if ($renewal->status == 0) { ?>
                          <a class="btn btn-success" href="<?php echo site_url("form/section_b/$renewal->school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Complete Renewal Process</a>
                        <?php } else {   ?>
                          <?php if ($renewal->status == 1) { ?>
                            <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $renewal->schools_id . "/" . $renewal->school_id . "/" . $renewal->session_year_id); ?>">Print Certificate<a>
                              <?php } else { ?>
                                <a class="btn btn-success" href="<?php echo site_url("online_application/status/$renewal->school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Application Inprogress</a>

                            <?php }
                          } ?>
                      </td>
                    </tr>

                  <?php } else { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $session->sessionYearTitle; ?></td>
                      <td colspan="3" style="text-align: center;">
                        <a class="btn btn-success" style="margin: 1px;" href="<?php echo site_url("apply/renewal/$session->sessionYearId"); ?>">Apply for Renewal</a>
                        <a class="btn btn-warning" style="margin: 1px;" href="<?php echo site_url("apply/renewal_upgradation/$session->sessionYearId"); ?>">Apply for Upgradation + Renewal</a>

                      </td>
                    </tr>
                  <?php } ?>


                  <?php

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
                      ,`session_year`.`sessionYearTitle`

                      FROM `reg_type`,
                      `school`,
                      `school_type`,
                      `levelofinstitute`,
                      `gender`,
                      `session_year`  
                      WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                      AND `school_type`.`typeId` = `school`.`school_type_id`
                      AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                      AND `gender`.`genderId` = `school`.`gender_type_id`
                      AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                      AND school.`schools_id`= '" . $school_id . "'
                      AND `school`.`session_year_id` = '" . $session->sessionYearId . "'
                      AND `school`.`reg_type_id`=3";
                  $upgradation = $this->db->query($query)->result()[0];
                  if ($upgradation) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><a href="<?php echo site_url("print_file/school_session_detail/" . $upgradation_and_renewal->school_id); ?>" target="new">Print</a></td>

                      <td><?php echo $upgradation->sessionYearTitle; ?></td>
                      <td><?php echo $upgradation->regTypeTitle; ?></td>
                      <td><?php echo $upgradation->levelofInstituteTitle; ?></td>
                      <td>
                        <?php if ($upgradation->status == 0) { ?>
                          <a class="btn btn-success" href="<?php echo site_url("form/section_b/$upgradation->school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Complete Upgradation Process</a>
                        <?php } else {   ?>
                          <?php if ($upgradation->status == 1) { ?>
                            <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $upgradation->schools_id . "/" . $upgradation->school_id . "/" . $upgradation->session_year_id); ?>">Print Certificate<a>
                              <?php } else { ?>
                                <a class="btn btn-success" href="<?php echo site_url("online_application/status/$upgradation->school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Application Inprogress</a>

                            <?php }
                          } ?>
                      </td>

                    </tr>

                  <?php } else { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $session->sessionYearTitle; ?></td>
                      <td colspan="3" style="text-align: center;">
                        <a class="btn btn-warning" style="margin: 1px;" href="<?php echo site_url("apply/upgradation/$session->sessionYearId"); ?>">Apply for Upgradation</a>

                      </td>
                    </tr>
                  <?php } ?>


                </table>
              <?php } else { ?>

                <div style="text-align: center;">

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
                  $session_school_id = $registration[0]->schoolId;

                  ?>
                  <?php if ($registration) { ?>
                    <?php if ($registration[0]->status == 0) { ?>

                      <?php $query = "SELECT * FROM `forms_process` WHERE  `forms_process`.`school_id` = $session_school_id";

                      $form_stauts = $this->db->query($query)->result()[0];

                      $page_link = 'submit_bank_challan';
                      if ($form_stauts->form_b_status == 0) {
                        $page_link = 'section_b';
                      }
                      if ($form_stauts->form_c_status == 0) {
                        $page_link = 'section_c';
                      }
                      if ($form_stauts->form_d_status == 0) {
                        $page_link = 'section_d';
                      }
                      if ($form_stauts->form_e_status == 0) {
                        $page_link = 'section_e';
                      }
                      if ($form_stauts->form_f_status == 0) {
                        $page_link = 'section_f';
                      }
                      if ($form_stauts->form_g_status == 0) {
                        $page_link = 'section_g';
                      }
                      if ($form_stauts->form_h_status == 0) {
                        $page_link = 'section_h';
                      }
                      ?>


                      <h4>Registration Application not complete yet !</h4>
                      <?php if ($page_link != 'submit_bank_challan') { ?>
                        <p>
                          Please complete registration form by filling data in all the sections B,C,D,E,F,G,H forms.
                        </p>
                        <p style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">
                          براہ کرم تمام سیکشنز B,C,D,E,F,G,H فارمز میں ڈیٹا بھر کر رجسٹریشن فارم مکمل کریں۔
                        </p>
                      <?php } else { ?>
                        <?php
                        $biseverification = 0;
                        // $bise_verificaiton = 0;
                        if ($school->biseRegister == 'Yes') {
                          $biseverification = '1';
                          $query = "SELECT * FROM `bise_verification_requests` WHERE school_id = '" . $school->schoolId . "' AND status IN(1,2,0)";
                          $bise_verification = $this->db->query($query)->result();

                          if ($bise_verification and $bise_verification[0]->status == 1 or $bise_verification[0]->status == 2) {
                            $biseverified = 1;
                          } else {
                            $biseverified = 0;
                          }
                        } else {
                          $biseverified = 1;
                        }
                        if ($biseverified == 1) {
                        } else { ?>

                          <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 0px auto; width:100%; padding: 5px; background-color: white;">
                            <h3 style="text-align: center;">BISE Verificaiton In Progress </h3>
                            <h4 style="text-align: center;">
                              BISE Registration No. <?php echo $bise_verification[0]->registration_number; ?><br />
                              BISE Affiliation. <?php
                                                $query = "SELECT `bise`.`biseName` FROM `bise` WHERE `bise`.`biseId` = '" . $bise_verification[0]->bise_id . "'";
                                                $bise_affiliation_name = $this->db->query($query)->result()[0]->biseName;

                                                echo $bise_affiliation_name; ?><br />
                              Verification Status: <strong style="color:red">Pending</strong>
                              <h2 style="text-align: center;"><i class="fa fa-spinner" aria-hidden="true"></i></h2>
                              <p style="text-align: center;">
                                <strong>
                                  Your case will proceed further, after verification of BISE Registration / Affiliation. Keep visiting school portal. it will take 1,2 working days.

                                  <br />
                                  <p style="text-align: center; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px; direction: rtl;">
                                    آپ کا کیس BISE رجسٹریشن / الحاق کی تصدیق کے بعد آگے بڑھے گا۔ اسکول کے پورٹل کو وزٹ کرتے رہیں۔ اس میں 1,2 کام کے دن لگیں گے۔</p>
                                </strong>
                              </p>
                            </h4>

                          </div>
                          <br />

                        <?php  }  ?>


                      <?php } ?>

                      <a class="btn btn-success" href="<?php echo site_url("form/$page_link/$session_school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Complete Registration Process for <?php echo $session->sessionYearTitle; ?></a>
                    <?php } else { ?>
                      <h4>Your Application for Registration <?php echo $session->sessionYearTitle; ?> is In Progress </h4>
                      <strong>
                        <?php

                        switch ($registration[0]->status) {
                          case 0:
                            echo "Data Entery In Progress";
                            break;
                          case 2:
                            echo "Bank Challan Verification In Progress";
                            break;
                          case 3:
                            echo "Data Verification";
                            break;
                          case 4:
                            echo "Fowarded for Inspection Assignment";
                            break;
                          case 4:
                            echo "Inspection pending";
                            break;
                          case 5:
                            echo "Inspection Completed";
                            break;

                          case 8:
                            echo "Challan Not Verified";
                            break;
                          case 1:
                            echo "completed";
                            break;
                        }
                        ?>

                      </strong><br />
                      <br />
                      <a class="btn btn-success" href="<?php echo site_url("online_application/status/$session_school_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> Check Application Status </a>
                    <?php } ?>
                  <?php } else { ?>
                    <h4>Now Apply for Registration with PSRA</h4>
                    <p>Note:

                      As your school was established in <strong> <?php echo date("M, Y", strtotime($school->yearOfEstiblishment)); ?> </strong> , therefore you should register your school with PSRA for session <strong> <?php echo $session->sessionYearTitle; ?></strong>

                    </p><br />
                    <p style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">
                      اب PSRA کے ساتھ رجسٹریشن کے لیے درخواست دیں۔
                      چونکہ آپ کا اسکول <strong> <?php echo date("M, Y", strtotime($school->yearOfEstiblishment)); ?> </strong> میں قائم ہوا تھا، اس لیے آپ کو اپنے اسکول کو <strong> <?php echo $session->sessionYearTitle; ?></strong> کے سیشن کے لیے PSRA کے ساتھ رجسٹر کرنا چاہیے۔
                    </p>
                    <a class="btn btn-primary" href="<?php echo site_url("apply/registration/$session->sessionYearId"); ?>">Apply for Registration. <?php echo $session->sessionYearTitle; ?></a>
                  <?php } ?>

                </div>
              <?php }  ?>



            </div>
            <?php if (1 == 2) { ?>
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
        <?php } ?>


        </div>
      </div>
    </div>
  </section>
</div>