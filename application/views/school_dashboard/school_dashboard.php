<!-- Content Wrapper. Contains page content -->
<style>
.btn-outline-primary {
    color: #007bff;
    background-color: transparent;
    background-image: none;
    border-color: #007bff;
}

.btn-outline-success {
    color: #007bff;
    background-color: transparent;
    background-image: none;
    border-color: #008d4c;
}

.btn-outline-warning {
    color: #007bff;
    background-color: transparent;
    background-image: none;
    border-color: #e08e0b;
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2 style="display:inline;">
            <?php echo ucwords(strtolower($school->schoolName)); ?>
            <small style="margin-left: 10px;">
                <?php if (!empty($school->typeTitle)) : ?>
                (<?php echo $school->typeTitle; ?>)

                <?php endif; ?>
            </small>
        </h2>
        <h4>Institute ID: <?php echo $school->schoolId ?>
            <?php if ($school->registrationNumber > 0) { ?>
            <span>Reg. ID: <?php echo $school->registrationNumber ?></span>
            <?php } ?>
        </h4>
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
        <!-- detail modal -->
        <div id="institute_detail" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title pull-left">Institute Detail</h5>
                        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
                            <h4 style="text-align: center;">Other Detail</h4>
                            <?php if (!empty($school->yearOfEstiblishment)) : ?>
                            <?php echo "Established In: " . $school->yearOfEstiblishment; ?>
                            <br>
                            <?php endif; ?>
                            <?php if (!empty($school->levelofInstituteTitle)) : ?>
                            <?php echo "At the time of registration (Level): " . $school->levelofInstituteTitle; ?>
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
                            <?php if (!empty($school->biseregistrationNumber)) :
                $query = "SELECT COUNT(*) as total 
                        FROM bise_verification_requests
                        WHERE school_id = '" . $school->schoolId . "'";
                $bise_verification_record = $this->db->query($query)->result()[0];
                if ($bise_verification_record->total == 0 and $school->registrationNumber <= 0) {

                  $bise_verification['school_id'] = $school->schoolId;
                  $bise_verification['registration_number'] = $school->biseregistrationNumber;
                  $bise_verification['tdr_amount'] = 0;
                  $bise_verification['bise_id'] = $school->bise_id;
                  $this->db->insert('bise_verification_requests', $bise_verification);
                }
              ?>


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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end detail modal -->
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#institute_detail">
            Institute Detail
        </button>
        <!-- end Button trigger modal -->
    </section>
    <!-- Main content -->
    <section class="content ">

        <div class="box box-primary box-solid">
            <div class="box-body">

                <div class="row">






                    <?php if ($school->school_type_id == 1) { ?>
                    <div class="col-md-3">

                        <?php
              $query = "SELECT * FROM `session_year` WHERE status = 1";
              $session = $this->db->query($query)->row();
              $query = "SELECT * FROM `enrollments` 
                        WHERE schools_id = '" . $school->schoolId . "'
                        AND session_id = '" . $session->sessionYearId . "'";
              $enrollment = $this->db->query($query)->row();
              //var_dump($enrollment);
              if ($enrollment) {
                $school_enrollment =  $enrollment->enrollment;
                $fresh_enrolment =  $enrollment->fresh_enrolment;
                $gov_schools =  $enrollment->gov_schools;
                $private_schools =  $enrollment->private_schools;
                $drop_out =  $enrollment->drop_out;
              } else {
                $school_enrollment =  0;
                $fresh_enrolment =  0;
                $gov_schools =  0;
                $private_schools =  0;
                $drop_out =  0;
              }
              ?>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <th>New Enrolment For Session <?php echo $session->sessionYearTitle; ?></th>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post"
                                            action="<?php echo site_url('temp_controller/add_enrollement'); ?>">
                                            <input type="hidden" name="schools_id"
                                                value="<?php echo  $school->schoolId; ?>" />
                                            <input type="hidden" name="session_id"
                                                value="<?php echo  $session->sessionYearId; ?>" />
                                            <div class="form-group">
                                                <label for="fresh_enrolment">Fresh / New Enrolment </label>
                                                <small id="fresh_enrolment" class="form-text text-muted"
                                                    style="color: red; display:block; font-weight: bold;">Students
                                                    enrolled for the first time.</small>
                                                <input required min="0" value="<?php echo $fresh_enrolment; ?>"
                                                    name="fresh_enrolment" id="fresh_enrolment" type="number"
                                                    class="form-control" placeholder="">

                                            </div>
                                            <div class="form-group">
                                                <label for="gov_schools">Students From Government Schools</label>
                                                <small id="gov_schools" class="form-text text-muted"
                                                    style="color: red; display:block; font-weight: bold;">Students
                                                    enrolled in your school from government schools.</small>

                                                <input required min="0" value="<?php echo $gov_schools; ?>"
                                                    name="gov_schools" id="gov_schools" type="number"
                                                    class="form-control" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="private_schools">Students From Other Private Schools</label>
                                                <small id="private_schools" class="form-text text-muted"
                                                    style="color: red; display:block; font-weight: bold;">Students
                                                    enrolled in your school from other private schools.</small>

                                                <input required min="0" value="<?php echo $private_schools; ?>"
                                                    name="private_schools" id="private_schools" type="number"
                                                    class="form-control" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="drop_out">Re-enrolment</label>
                                                <small id="drop_out" class="form-text text-muted"
                                                    style="color: red; display:block; font-weight: bold;">Re-enrolment
                                                    of students who returned to your school after dropped out.</small>

                                                <input required min="0" value="<?php echo $drop_out; ?>" name="drop_out"
                                                    id="drop_out" type="number" class="form-control" placeholder="">
                                            </div>
                                            <div style="text-align: center;">
                                                <button type="submit" class="btn btn-primary">Add Enrolment
                                                    Data</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="alert "
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">


                            <h4>Staff Statement</h4>
                            <style>
                            .blink_me {
                                animation: blinker 1s linear infinite;
                            }

                            @keyframes blinker {
                                50% {
                                    opacity: 0;
                                }
                            }
                            </style>
                            <div class="alert alert-warning blink_me" style="color: black !important;">
                                Please update staff statement of session <?php echo $session->sessionYearTitle; ?>
                            </div>
                            <div style="text-align: center;">
                                <a class="btn btn-warning"
                                    href="<?php echo site_url("staff_statement/staff_list") ?>">Update Staff
                                    Statement</a>
                            </div>
                        </div>


                        <div class="alert "
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">


                            <h4>Session <?php echo $session->sessionYearTitle; ?> Enrollment</h4>
                            <div class="alert alert-danger">
                                Please enter the <strong>total</strong> number of newly enrolled students in your school
                                for session <strong><?php echo $session->sessionYearTitle; ?></strong> and submit and
                                submit online.
                                <br />
                                You need to update this figure daily
                            </div>
                            <div style="text-align: center;">
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal">
                                    New Enrollment Information
                                </button>
                            </div>
                        </div>
                        <div class="alert "
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">

                            <?php
                $query = "SELECT * FROM `session_year` WHERE status = 1";
                $session = $this->db->query($query)->row();
                $query = "SELECT * FROM `enrollments` 
              WHERE schools_id = '" . $school->schoolId . "'
              AND session_id = '" . $session->sessionYearId . "'";
                $enrollment = $this->db->query($query)->row();
                if ($enrollment) {
                  $school_enrollment =  $enrollment->enrollment;
                } else {
                  $school_enrollment = 0;
                }
                ?>
                            <h4>Online School Leaving Certificate</h4>
                            <div class="alert alert-success">
                                PSRA has launched an online platform to facilitate the issuance of student
                                <strong>School Leaving Certificate</strong> for registered schools.
                            </div>
                            <div style="text-align: center;">
                                <a class="btn btn-success" href="<?php echo site_url('students_slcs'); ?>">
                                    <i class="fa fa-certificate" aria-hidden="true"></i> School Leaving Certificates
                                </a>
                            </div>

                        </div>
                    </div>
                    <?php } ?>


                    <div <?php if ($school->school_type_id == 1) { ?>class="col-md-5" <?php } ?>
                        <?php if ($school->school_type_id == 7) { ?>class="col-md-8" <?php } ?>>
                        <div
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
                            <?php
              if ($school->registrationNumber) { ?>
                            <h3>Registration and Renewals Detail</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size: 12px; width:100%">
                                    <tr>
                                        <th>#</th>
                                        <th>Session</th>
                                        <th>Applied</th>
                                        <th>Level</th>
                                        <th>Print</th>
                                        <th>Status</th>
                                    </tr>

                                    <?php
                    $count = 1;
                    $stop_appy = TRUE;
                    $reg_detail = get_registration_detail($school_id);
                    if ($reg_detail) {
                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <!-- <a href="<?php echo site_url("print_file/school_session_detail/" . $reg_detail->school_id); ?>" target="new"><?php echo $reg_detail->sessionYearTitle; ?></a> -->
                                            <?php echo $reg_detail->sessionYearTitle; ?>
                                        </td>
                                        <td><?php echo $reg_detail->regTypeTitle; ?></td>
                                        <td><?php echo $reg_detail->levelofInstituteTitle; ?></td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" target="_blank"
                                                href="<?php echo site_url("print_file/school_session_detail/" . $reg_detail->school_id); ?>">
                                                <i class="fa fa-print" aria-hidden="true"></i> Print Application
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($reg_detail->isRejected == 0) { ?> <i class="fa fa-check"
                                                aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-times"
                                                aria-hidden="true"></i> <?php } ?>
                                            <?php if (1 == 2) { ?>
                                            <!-- <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $reg_detail->schools_id . "/" . $reg_detail->school_id . "/" . $reg_detail->session_year_id); ?>">Print Certificate<a> -->
                                            <?php } ?>

                                        </td>
                                    </tr>

                                    <?php } ?>


                                    <!-- Renewal -->

                                    <?php
                    $query = "SELECT * FROM `session_year` 
                            WHERE `session_year`.`sessionYearId` > '" . $reg_detail->session_year_id . "'";
                    // AND status=0";
                    $sessions = $this->db->query($query)->result();
                    foreach ($sessions as $session) {
                      $query = "SELECT
                      `reg_type`.`regTypeTitle`
                      , `school_type`.`typeTitle`
                      , `levelofinstitute`.`levelofInstituteTitle`
                      , `school`.`status`
                      , `school`.`upgrade`
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
                      `session_year`  
                      WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                      AND `school_type`.`typeId` = `school`.`school_type_id`
                      AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                      AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                      AND school.`schools_id`= '" . $school_id . "'
                      AND `school`.`session_year_id` = '" . $session->sessionYearId . "'";
                      $upgradation_and_renewals = $this->db->query($query)->result();
                      $upgradation = false;
                      if ($upgradation_and_renewals) {
                        foreach ($upgradation_and_renewals as $upgradation_and_renewal) {
                    ?>



                                    <?php if ($upgradation_and_renewal->status == 0) {
                            $page_link = get_last_link($upgradation_and_renewal->school_id);
                            if ($page_link != 'submit_bank_challan') { ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <small>
                                                <h4><?php echo $upgradation_and_renewal->regTypeTitle; ?> Application
                                                    not complete yet !</h4>
                                                <p>
                                                    Please complete
                                                    <?php echo $upgradation_and_renewal->regTypeTitle; ?> form by
                                                    filling data in all the sections B,C,D,E,F,G,H forms.
                                                </p>
                                                <p
                                                    style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">
                                                    براہ کرم تمام سیکشنز B,C,D,E,F,G,H فارمز میں ڈیٹا بھر کر
                                                    <?php echo $upgradation_and_renewal->regTypeTitle; ?> فارم مکمل
                                                    کریں۔
                                                </p>
                                            </small>
                                            <a class="btn btn-success"
                                                href="<?php echo site_url("form/$page_link/$upgradation_and_renewal->school_id"); ?>">
                                                <i class="fa fa-spinner" aria-hidden="true"></i> Complete
                                                <?php echo $upgradation_and_renewal->regTypeTitle; ?> Process for
                                                <?php echo $upgradation_and_renewal->sessionYearTitle; ?></a>

                                        </td>
                                    </tr>
                                    <?php } else {

                            ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <small>
                                                <h4><?php echo $upgradation_and_renewal->regTypeTitle; ?> Application
                                                    not complete yet !</h4>
                                                <p>
                                                    To Complete the
                                                    <?php echo $upgradation_and_renewal->regTypeTitle; ?> Process,
                                                    Please deposit bank challan and insert STAN Number and Transaction
                                                    Date written on Computerized Bank Challan to us by clicking on the
                                                    Button Shown below.
                                                </p>
                                                <p
                                                    style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">

                                                    <?php echo $upgradation_and_renewal->regTypeTitle; ?> کا عمل مکمل
                                                    کرنے کے لیے، براہ کرم بینک چالان جمع کرائیں اور نیچے دکھائے گئے بٹن
                                                    پر کلک کرکے کمپیوٹرائزڈ بینک چالان پر لکھا ہوا STAN نمبر اور لین دین
                                                    کی تاریخ درج کریں۔
                                                </p>
                                            </small>
                                            <a class="btn btn-success"
                                                href="<?php echo site_url("form/$page_link/$upgradation_and_renewal->school_id"); ?>">
                                                <i class="fa fa-spinner" aria-hidden="true"></i> Complete
                                                <?php echo $upgradation_and_renewal->regTypeTitle; ?> Process for
                                                <?php echo $upgradation_and_renewal->sessionYearTitle; ?></a>

                                        </td>
                                    </tr>
                                    <?php } ?>

                                    <?php } else {   ?>
                                    <?php if ($upgradation_and_renewal->status == 1) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <!-- <a href="<?php echo site_url("print_file/school_session_detail/" . $upgradation_and_renewal->school_id); ?>" target="new"><?php echo $upgradation_and_renewal->sessionYearTitle; ?></a> -->
                                            <?php echo $upgradation_and_renewal->sessionYearTitle; ?>
                                        </td>
                                        <td><?php echo $upgradation_and_renewal->regTypeTitle; ?></td>
                                        <td><?php echo $upgradation_and_renewal->levelofInstituteTitle; ?>
                                            <?php if ($upgradation_and_renewal->upgrade) { ?>
                                            <i class="fa fa-level-up" aria-hidden="true"></i>
                                            <?php } ?>
                                        </td>
                                        <td>

                                            <a class="btn btn-warning btn-sm" target="_blank"
                                                href="<?php echo site_url("print_file/school_session_detail/" . $upgradation_and_renewal->school_id); ?>">
                                                <i class="fa fa-print" aria-hidden="true"></i> Print Application
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($reg_detail->isRejected == 0) { ?> <i class="fa fa-check"
                                                aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-times"
                                                aria-hidden="true"></i> <?php } ?>
                                            <?php if (1 == 2) { ?>
                                            <!-- <a target="_new" href="<?php echo site_url("school_dashboard/certificate/" . $upgradation_and_renewal->schools_id . "/" . $upgradation_and_renewal->school_id . "/" . $upgradation_and_renewal->session_year_id); ?>">Print Certificate<a> -->
                                            <?php } ?>

                                        </td>
                                    </tr>


                                    <?php if ($session->status == 1) { ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            <a href="<?php echo site_url("update_sectionc/updatesectionc/$upgradation_and_renewal->school_id"); ?>"
                                                class="btn btn-success"> <i class="fa fa-user-plus"
                                                    aria-hidden="true"></i>
                                                Update <?php echo $upgradation_and_renewal->sessionYearTitle; ?>
                                                Enrollment
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>


                                    <?php

                              if ($session->status == 1) {
                                $query = "SELECT COUNT(*) as total FROM school 
                                      WHERE `school`.`reg_type_id`=3 
                                      AND status != 1 
                                      AND school.`schools_id`= '" . $school_id . "'";
                                $upgradation_status = $this->db->query($query)->result()[0]->total;
                                if ($upgradation_status == 0) {
                                  $upgradation = true;
                                }
                              } ?>






                                    <?php } else { ?>
                                    <tr>
                                        <td colspan="6">
                                            <h4>Your Application for
                                                <?php echo $upgradation_and_renewal->regTypeTitle; ?>
                                                <?php echo $session->sessionYearTitle; ?> is In Progress </h4>


                                            <div class="btn btn-outline-primary" style="width: 100%;">
                                                <i class="fa fa-spinner" aria-hidden="true"></i> &#160;

                                                <?php echo get_session_request_status($upgradation_and_renewal->status); ?>
                                                &#160;&#160;&#160;&#160;

                                                <!-- <a target="_blank" class="btn btn-link" href="<?php echo site_url("print_file/school_session_detail/" . $upgradation_and_renewal->school_id); ?>">
                                      Print Data
                                    </a> -->
                                                <a href="<?php echo site_url("online_application/status/$upgradation_and_renewal->school_id"); ?>"
                                                    class="btn btn-primary">
                                                    See Detail
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php }
                          } ?>



                                    <?php } ?>
                                    <?php
                        $query = "SELECT  (`primary_level`+`middle_level`+`high_level`+`h_sec_college_level`) as total 
                      FROM schools WHERE schools.`schoolId`= '" . $school_id . "'";
                        $upgradation_code = $this->db->query($query)->result()[0]->total;
                        if ($upgradation and $upgradation_code != 4) { ?>
                                    <tr style="display:none;">
                                        <td colspan="6" style="text-align: center;">
                                            <p class="btn btn-outline-warning">
                                                Apply For <?php echo $session->sessionYearTitle; ?>

                                                <a onclick="return confirm('Are you sure?')" class="btn btn-warning"
                                                    style="margin: 1px;"
                                                    href="<?php echo site_url("apply/upgradation/$session->sessionYearId"); ?>">Upgradation</a>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <tr>

                                        <td colspan="5" style="text-align: center;">
                                            <?php
                            $query = "SELECT COUNT(*) as total FROM school WHERE schools_id ='" . $school_id . "' 
                                    AND session_year_id = '" . ($session->sessionYearId - 1) . "'";
                            $apply = $this->db->query($query)->result()[0]->total; ?>

                                            <?php if ($session->status == 1) { ?>
                                            <p class="btn btn-outline-success" <?php if ($apply <= 0) { ?>
                                                style="border-color: #D6D6D6" <?php } ?>>
                                                Apply For <?php echo $session->sessionYearTitle; ?>
                                                <?php if ($apply > 0) { ?>
                                                <a onclick="return confirm('Are you sure? only renewal')"
                                                    class="btn btn-danger" style="margin: 1px;"
                                                    href="<?php echo site_url("apply/renewal/$session->sessionYearId"); ?>">
                                                    Renewal Only</a>
                                                <?php
                                  // var_dump($school);
                                  if ($school->school_type_id != 7) { ?>
                                                <a onclick="return confirm('Are you sure? you want to apply for Upgradation + Renewal')"
                                                    class="btn" style="background-color:lightgray; margin-left: 20px;"
                                                    href="<?php echo site_url("apply/renewal_upgradation/$session->sessionYearId"); ?>">Upgradation
                                                    + Renewal</a>
                                                <?php } ?>
                                                <?php } else { ?>
                                                <a class="btn btn-success"
                                                    style="margin: 1px; background-color: #E6E6E6; border-color: #D6D6D6"
                                                    data-toggle="tooltip" data-placement="top" title="" href=" # "
                                                    data-original-title="Please apply and complete previous session data entry.">
                                                    Renewal Only</a>
                                                <?php if ($school->school_type_id != 7) { ?>
                                                <a class="btn btn-warning"
                                                    style="margin: 1px; background-color: #E6E6E6; border-color: #D6D6D6"
                                                    data-toggle="tooltip" data-placement="top" title="" href=" # "
                                                    data-original-title="Please apply and complete previous session data entry.">Upgradation
                                                    + Renewal</a>
                                                <?php } ?>
                                                <?php  } ?>
                                            </p>
                                            <?php } else { ?>
                                            <?php if ($apply > 0) { ?>
                                            <a onclick="return confirm('Are you sure?')" class="btn btn-success"
                                                style="margin: 1px;"
                                                href="<?php echo site_url("apply/renewal/$session->sessionYearId"); ?>">Apply
                                                for <?php echo $session->sessionYearTitle; ?> Renewal</a>
                                            <?php } else { ?>
                                            <a class="btn btn-success"
                                                style="margin: 1px; background-color: #E6E6E6; border-color: #D6D6D6"
                                                data-toggle="tooltip" data-placement="top" title="" href=" # "
                                                data-original-title="Please apply and complete previous session data entry.">Apply
                                                for <?php echo $session->sessionYearTitle; ?> Renewal</a>
                                            <?php } ?>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <?php } ?>



                                    <?php   }  ?>




                                </table>
                            </div>
                            <?php } else { ?>

                            <div style="text-align: center;">

                                <?php
                  // session desions 

                  $est_month = (int) date('m', strtotime($school->yearOfEstiblishment));
                  $est_year = date('Y', strtotime($school->yearOfEstiblishment));

                  if ($est_month >= 3) {
                    $session_year = $est_year;
                  } else {
                    $session_year = $est_year - 1;
                  }


                  $query = "SELECT school_type_id FROM schools WHERE schoolId = '" . $school_id . "'";
                  $school_type_id = $this->db->query($query)->row()->school_type_id;
                  if ($school_type_id  == 7) {
                    $query = "SELECT * FROM `session_year`  ORDER BY sessionYearId DESC LIMIT 1";
                    $session = $this->db->query($query)->result()[0];
                  } else {
                    $query = "SELECT * FROM `session_year` WHERE YEAR(`session_start`) >= '" . $session_year . "'";
                    $session = $this->db->query($query)->result()[0];
                  }
                  // $query = "SELECT * FROM `session_year` WHERE YEAR(`session_start`) >= '" . $session_year . "'";
                  // $session = $this->db->query($query)->result()[0];

                  $query = "SELECT * FROM school 
                  WHERE schools_id = '" . $school_id . "' ";
                  $registration = $this->db->query($query)->result();
                  $registration_session_id = $registration[0]->session_year_id;
                  $session_school_id = $registration[0]->schoolId;

                  ?>
                                <?php if ($registration) { ?>
                                <?php if ($registration[0]->status == 0) {
                      $page_link = get_last_link($session_school_id);
                    ?>

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
                      if ($biseverified == 1 or 1 == 1) {
                      } else {



                      ?>

                                <div
                                    style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 0px auto; width:100%; padding: 5px; background-color: white;">
                                    <h3 style="text-align: center;">BISE Verificaiton Also In Progress </h3>
                                    <h4 style="text-align: center;">
                                        BISE Registration No.
                                        <?php echo $bise_verification[0]->registration_number; ?><br />
                                        BISE Affiliation. <?php
                                              $query = "SELECT `bise`.`biseName` FROM `bise` WHERE `bise`.`biseId` = '" . $bise_verification[0]->bise_id . "'";
                                              $bise_affiliation_name = $this->db->query($query)->result()[0]->biseName;

                                              echo $bise_affiliation_name; ?><br />
                                        Verification Status: <strong style="color:red">Pending</strong>
                                        <h2 style="text-align: center;"><i class="fa fa-spinner" aria-hidden="true"></i>
                                        </h2>
                                        <!-- <p style="text-align: center;">
                              <strong>
                                Your case will proceed further, after verification of BISE Registration / Affiliation. Keep visiting school portal. it will take 1,2 working days.

                                <br />
                                <p style="text-align: center; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px; direction: rtl;">
                                  آپ کا کیس BISE رجسٹریشن / الحاق کی تصدیق کے بعد آگے بڑھے گا۔ اسکول کے پورٹل کو وزٹ کرتے رہیں۔ اس میں 1,2 کام کے دن لگیں گے۔</p>
                              </strong>
                            </p> -->
                                    </h4>

                                </div>
                                <br />

                                <?php  }  ?>

                                <h4>Registration Application not complete yet !</h4>
                                <?php if ($page_link != 'submit_bank_challan') { ?>
                                <p>
                                    Please complete registration form by filling data in all the sections B,C,D,E,F,G,H
                                    forms.
                                </p>
                                <p
                                    style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">
                                    براہ کرم تمام سیکشنز B,C,D,E,F,G,H فارمز میں ڈیٹا بھر کر رجسٹریشن فارم مکمل کریں۔
                                </p>
                                <a class="btn btn-success"
                                    href="<?php echo site_url("form/$page_link/$session_school_id"); ?>"> <i
                                        class="fa fa-spinner" aria-hidden="true"></i> Complete Registration Process for
                                    <?php echo $session->sessionYearTitle; ?></a>
                                <?php } else {
                        //if ($biseverified == 1) {
                      ?>
                                <p>
                                    To Complete the Registration Process, Please deposit bank challan and insert STAN
                                    Number and Transaction Date written on Computerized Bank Challan to us by clicking
                                    on the Button Shown below.
                                </p>
                                <p
                                    style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">

                                    رجسٹریشن کا عمل مکمل کرنے کے لیے، براہ کرم بینک چالان جمع کرائیں اور نیچے دکھائے گئے
                                    بٹن پر کلک کرکے کمپیوٹرائزڈ بینک چالان پر لکھا ہوا STAN نمبر اور لین دین کی تاریخ
                                    درج کریں۔
                                </p>


                                <a class="btn btn-success"
                                    href="<?php echo site_url("form/$page_link/$session_school_id"); ?>"> <i
                                        class="fa fa-spinner" aria-hidden="true"></i> Complete Registration Process for
                                    <?php echo $session->sessionYearTitle; ?></a>
                                <?php //} 
                        ?>

                                <?php } ?>
                                <?php } else { ?>
                                <h4>Your Application for Registration <?php echo $session->sessionYearTitle; ?> is In
                                    Progress </h4>


                                <div class="btn btn-outline-primary" style="width: 100%; padding:10px">
                                    <i class="fa fa-spinner" aria-hidden="true"></i> &#160;
                                    <?php echo get_session_request_status($registration[0]->status); ?>
                                    &#160;&#160;&#160;&#160;
                                    <!-- <a target="_blank" class="btn btn-link" href="<?php echo site_url("print_file/school_session_detail/" . $session_school_id); ?>">
                          Print Data
                        </a> -->
                                    <a class="btn btn-primary"
                                        href="<?php echo site_url("online_application/status/$session_school_id"); ?>">
                                        See Detail
                                    </a>

                                </div>
                                <?php } ?>
                                <?php } else { ?>



                                <?php if ($session->sessionYearId) { ?>
                                <?php if ($school_type_id == 7) { ?>
                                <h4>Now Apply for Academy Registration with PSRA</h4>
                                <?php } else { ?>
                                <h4>Now Apply for Registration with PSRA</h4>
                                <?php } ?>
                                <?php if ($school_type_id != 7) { ?>
                                <p>Note:

                                    As your school was established in <strong>
                                        <?php echo date("M, Y", strtotime($school->yearOfEstiblishment)); ?> </strong> ,
                                    therefore you should register your school with PSRA for session <strong>
                                        <?php echo $session->sessionYearTitle; ?></strong>

                                </p><br />
                                <p
                                    style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; line-height: 25px;">
                                    اب PSRA کے ساتھ رجسٹریشن کے لیے درخواست دیں۔
                                    چونکہ آپ کا اسکول <strong>
                                        <?php echo date("M, Y", strtotime($school->yearOfEstiblishment)); ?> </strong>
                                    میں قائم ہوا تھا، اس لیے آپ کو اپنے اسکول کو <strong>
                                        <?php echo $session->sessionYearTitle; ?></strong> کے سیشن کے لیے PSRA کے ساتھ
                                    رجسٹر کرنا چاہیے۔
                                </p>
                                <?php } ?>
                                <a onclick="return confirm('Are you sure?')" class="btn btn-primary"
                                    href="<?php echo site_url("apply/registration/$session->sessionYearId"); ?>">Apply
                                    for Registration. <?php echo $session->sessionYearTitle; ?></a>
                                <?php } else {
                      echo "<h4>The session hasn't started yet. The new session will start in April.</h4>";
                    } ?>
                                <?php } ?>

                            </div>

                            <?php }  ?>



                        </div>
                        <?php if (1 == 2) { ?>
                        <div
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
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
                        <?php } ?>
                    </div>

                    <div class="col-md-4">
                        <div
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
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
                            <ul class="list-group">
                                <?php
                foreach ($school_messages as $message) : ?>
                                <li class="list-group-item">
                                    <a target="_new"
                                        href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                                        <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                                    </a>
                                    <small style="display: block; color:gray" class="pull-right">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                                    </small>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            </table>
                            <?php if ($total_messages > 6) { ?>
                            <div style="text-align: center;">
                                <a class="btn btn-primary btn-sm" href="<?php echo site_url('messages/inbox'); ?>"><i
                                        class="fa fa-envelope-o"></i> All Inbox Messages</a>
                            </div>
                            <?php } ?>
                        </div>
                        <div
                            style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">

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
                            <ul class="list-group">
                                <?php
                foreach ($notifications as $message) : ?>

                                <li class="list-group-item">
                                    <a target="_new"
                                        href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                                        <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                                    </a>
                                    <small style="display: block; color:gray" class="pull-right">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                                    </small>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if ($total_notifications > 6) { ?>
                            <div style="text-align: center;">
                                <a class="btn btn-success btn-sm" href="<?php echo site_url('messages/inbox'); ?>"><i
                                        class="fa fa-bell-o"></i> All Notifications</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>



<script>
// $(document).ready(function() {
//   $('#exampleModal').modal('show');
// });
</script>