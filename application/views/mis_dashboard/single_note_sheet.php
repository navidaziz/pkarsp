<!doctype html>
<?php date_default_timezone_set("Asia/Karachi"); ?>
<html>

<head>
  <meta charset="utf-8">
  <title>S-ID: <?php echo $school->schools_id; ?></title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <style type="text/css">
    body {
      background: rgb(204, 204, 204);
      /* //font-family: 'Source Sans Pro', 'Regular' !important; */

    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 70%;
      min-height: 29.7cm;
      /* height: auto; */
      font-size: 16px !important;

    }

    @media print {
      page[size="A4"] {
        width: 95%;
        margin: 0 auto;
        margin-top: 10px;
        /* height: 29.7cm;  */
        height: auto;
        font-size: 16px !important;
      }
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      .hide_buttons {
        display: none;
      }

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

    }


    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 8px;
      line-height: 1;
      vertical-align: top;


    }

    .table2>thead>tr>th,
    .table2>tbody>tr>th,
    .table2>tfoot>tr>th,
    .table2>thead>tr>td,
    .table2>tbody>tr>td,
    .table2>tfoot>tr>td {
      padding: 5px;
      line-height: 1;
      vertical-align: top;
      color: black !important;
      text-align: center;

    }

    ol {
      padding-left: 10px;
    }

    ol>li::marker {
      font-weight: bold;
    }

    ol>li>p {
      margin-left: 10px;
    }
  </style>
</head>

<body>


  <!-- Modal -->
  <div class="modal fade" id="request_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 90% !important;">
      <div class="modal-content" id="request_detail_body" style="font-size: 12px;">



      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="mark_as_complete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="mark_as_complete_modal_body" style="font-size: 12px;">



      </div>
    </div>
  </div>

  <page size='A4'>
    <div class="wrapper">
      <section class="invoice" style="margin-left: 10px; margin-right: 10px;">
        <!-- title row -->
        <!-- <div class="row page-header"> -->
        <br />
        <div class="col-md-12">
          <table class="table2" style="width: 100%;">
            <tr>
              <td> <img src="<?php echo base_url('assets/images/site_images/certificate-logo-1-in-print.jpg'); ?>" style="height: 100px; width: 100px;">
              </td>
              <td>
                <h4 class="text-center">PRIVATE SCHOOLS REGULATORY AUTHORITY</h4>
                <h5 class="text-center">GOVERNMENT OF KHYBER PAKHTUNKHWA</h5>
                <p style="text-align: center;">
                  <small>Office: House No. 18/E, Jamal Ud Din Afghani Road,<br />
                    University Town, Peshawar<br />
                    Phone# 091-5700247-8. Fax# 09415700246
                  </small>
                </p>
              </td>
              <td> <img src="<?php echo base_url('assets/images/site_images/certificate-logo-2-in-print.png'); ?>" style="height: 108px; width: 128px;">
              </td>
            </tr>
          </table>

        </div>


        <hr>

        <div class="col-md-12">
          <table style="width: 100%;">
            <tr>
              <td>
                <div>
                  <h4>
                    <?php echo ucwords(strtolower($school->schoolName)); ?><br />

                  </h4>
                  <h5> School ID: <?php echo $school->schools_id ?>
                    <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> REG. ID:
                      <?php echo $school->registrationNumber ?>
                    <?php } ?>
                    <span style="margin-left: 20px;"></span>
                    File No: <?php
                              $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schools_id'";
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
                  </h5>
                  <small><strong>Address:</strong>
                    <?php if ($school->division) {
                      echo "Region: <strong>" . $school->division . "</strong>";
                    } ?>
                    <?php if ($school->districtTitle) {
                      echo " / District: <strong>" . $school->districtTitle . "</strong>";
                    } ?>
                    <?php if ($school->tehsilTitle) {
                      echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
                    } ?>

                    <?php if ($school->ucTitle) {
                      echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
                    } ?>
                    <?php if ($school->address) {
                      echo " / <strong>" . $school->address . "</strong>";
                    } ?>
                  </small>
                </div>
              </td>
              <td style="width: 250px; vertical-align: top;">
                <strong>School Contact Details</strong>
                <ol style="margin-left: 5px;">
                  <li>Phone No: <strong><?php echo $school->phone_no; ?></strong></li>
                  <li>Mobile No: <strong><?php echo $school->mobile_no; ?></strong></li>
                  <li>Owner No: <strong><?php echo $school->owner_no; ?></strong></li>
                  <oul>
              </td>
            </tr>
          </table>
          <br />
          <ol class="notesheet_para">

            <?php if ($school->registrationNumber > 0) {

              $query = "SELECT
                        `levelofinstitute`.`levelofInstituteTitle` as school_level,
                        `session_year`.`sessionYearTitle` as `session`,
                        `school`.`level_of_school_id` as lates_level_id
                        FROM
                        `school`,
                        `levelofinstitute`,
                        `session_year`
                        WHERE  `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                        AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                        AND schools_id = " . $schools_id . "
                      AND school.status=1 ORDER BY `school`.`session_year_id` DESC";
              $lastest_renewal = $this->db->query($query)->row();
            ?>
              <li>
                <p>It is pertinent to mention here that the subject school is already registered with KP-PSRA up to
                  <strong><?php echo $lastest_renewal->school_level; ?> level</strong> for the session <strong><?php echo $lastest_renewal->session; ?></strong>.
                </p>
              </li>

              <li>
                <p><i>Previous Sessions Registration, Renewal and Upgradation</i></p>
                <table class="table table-bordered table2" style="font-size: 14px;">
                  <tr>
                    <th>#</h>
                    <th>Session</th>
                    <th>Applied For</th>
                    <th>School Level</th>
                    <th>Max Fee</th>
                    <th>Total Students</th>
                    <th>Teaching Staff</th>
                    <th>Non Teaching Staff</th>
                    <th>Certificate Issued</th>

                  </tr>
                  <?php

                  $query = "SELECT
                          `reg_type`.`regTypeTitle`,
                          `levelofinstitute`.`levelofInstituteTitle`,
                          `session_year`.`sessionYearTitle`,
                          `session_year`.`sessionYearId`,
                          `school`.`renewal_code`,
                          `school`.`status`,
                          `school`.`created_date`,
                          `school`.`updatedBy`,
                          `school`.`updatedDate`,
                          `school`.`schoolId`,
                          `school`.`visit_list`,
                          `school`.`visit_type`,
                          `school`.`visit_entry_date`,
                          `school`.`cer_issue_date`,
                          school.pending_type,
                          school.pending_date,
                          school.pending_reason,
                          school.dairy_type,
                          school.dairy_no,
                          school.dairy_date
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
                          AND schools_id = " . $schools_id . "
                          AND school.schoolId < '" . $school_id . "'
                          ORDER BY `session_year`.`sessionYearId` ASC";
                  $school_sessions = $last_session = $this->db->query($query)->result();

                  $query = "select max(sessionYearId) as sessionYearId from session_year";
                  $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;

                  $error = array();


                  if ($school_sessions) {
                    $count = 1;
                    foreach ($school_sessions as $school_session) { ?>

                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                          <i class="fa fa-print" aria-hidden="true"></i> <?php echo $school_session->sessionYearTitle; ?>
                        </td>
                        <td>
                          <?php echo $school_session->regTypeTitle; ?>
                        <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>

                        <td><?php
                            $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                            $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                            $max_tuition_fee = (int) preg_replace(
                              '/[^0-9.]/',
                              '',
                              $this->db->query($query)->result()[0]->max_tution_fee
                            );
                            echo $max_tuition_fee;
                            ?> Rs.</td>

                        <td style="text-align: center;"><?php
                                                        $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                                                        $enrollment = $this->db->query($query)->result()[0]->total;
                                                        if ($enrollment) {
                                                          echo $enrollment;
                                                        } else {
                                                          echo "Section C Missing";
                                                        }

                                                        ?></td>


                        <td style="text-align: center;">
                          <?php
                          $query = "SELECT COUNT(`schoolStaffId`) as total FROM `school_staff`
                    WHERE `school_staff`.`school_id`= '" . $school_session->schoolId . "'
                    AND `school_staff`.`schoolStaffType` = 1";
                          echo $this->db->query($query)->row()->total; ?>
                        </td>

                        <td style="text-align: center;">
                          <?php
                          $query = "SELECT COUNT(`schoolStaffId`) as total FROM `school_staff`
                    WHERE `school_staff`.`school_id`= '" . $school_session->schoolId . "'
                    AND `school_staff`.`schoolStaffType` = 2";
                          echo $this->db->query($query)->row()->total; ?>

                        </td>



                        <td>
                          <?php
                          if ($school_session->status == 1) {
                            echo date('d M, y', strtotime($school_session->cer_issue_date));
                          }
                          if ($school_session->status == 0) {
                            $error[] = 1;
                            echo "Online Submission Pending";
                          }
                          if ($school_session->status == 2) {
                            $error[] = 1;
                            echo "Not Issued";
                          }
                          ?></td>

                      </tr>
                      <?php //if ($school_session->sessionYearId == $current_session_id) {
                      ?>

                      <?php  //}
                      ?>
                    <?php
                      $previous_max = $max_tuition_fee;
                    }
                  } else { ?>
                    <tr>
                      <td colspan="12">
                        Not applied for registartion.
                      </td>
                    </tr>
                  <?php } ?>

                </table>
              </li>



            <?php  } else { ?>

              <?php
              $query = "SELECT
                          `reg_type`.`regTypeTitle`,
                          `levelofinstitute`.`levelofInstituteTitle`,
                          `session_year`.`sessionYearTitle`,
                          `session_year`.`sessionYearId`,
                          `school`.`renewal_code`,
                          `school`.`status`,
                          `school`.`created_date`,
                          `school`.`updatedBy`,
                          `school`.`updatedDate`,
                          `school`.`schoolId`,
                          `school`.`visit_list`,
                          `school`.`visit_type`,
                          `school`.`visit_entry_date`,
                          `school`.`cer_issue_date`,
                          school.pending_type,
                          school.pending_date,
                          school.pending_reason,
                          school.dairy_type,
                          school.dairy_no,
                          school.dairy_date,
                          `schools`.`yearOfEstiblishment`,
                          schools.biseRegister,
                          schools.biseregistrationNumber,
                          schools.biseAffiliated,
                          school.gender_type_id
                          
                          FROM
                          `school`,
                          `reg_type`,
                          `gender`,
                          `schools`,
                          `levelofinstitute`,
                          `session_year`
                          WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                          AND `gender`.`genderId` = `school`.`gender_type_id`
                          AND schools.schoolId = school.schools_id
                          AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                          AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                          AND schools.schoolId = " . $school->schools_id . "
                          AND school.status IN (0,2)
                          ORDER BY `session_year`.`sessionYearId` ASC";
              $school_sessions = $last_session = $this->db->query($query)->row();


              ?>
              <li>
                <p>
                  It is submitted that the school administration has applied for <strong>New Registration</strong> of
                  <strong><?php echo $school_sessions->levelofInstituteTitle; ?> Level (<?php if ($school_sessions->gender_type_id == 1) {
                                                                                          echo "Boys";
                                                                                        } ?> <?php if ($school_sessions->gender_type_id == 2) {
                                                                                                echo "Boys";
                                                                                              } ?><?php if ($school_sessions->gender_type_id == 3) {
                                                                                                    echo "Co Education";
                                                                                                  } ?>)</strong>
                  for session <strong><?php echo $school_sessions->sessionYearTitle; ?>. </strong>
                </p>
              </li>
              <li>
                <p>
                  According to online application, the school was established in <strong><?php echo $school_sessions->yearOfEstiblishment; ?></strong>

                  <?php
                  $query = "SELECT MIN(DATE(schoolStaffAppointmentDate)) as min_appointment_date FROM `school_staff` WHERE school_id='" . $school_sessions->schoolId . "'";
                  $min_appoinment_date = $this->db->query($query)->row()->min_appointment_date;
                  ?>
                  <?php if ($min_appoinment_date) { ?>
                    and on the date of <strong><?php echo date("D d M, Y", strtotime($min_appoinment_date)); ?></strong>, its first staff was appointed.
                  <?php } else { ?>
                    .
                  <?php } ?>

                </p>
              </li>

              <?php if ($school_sessions->biseRegister == 'Yes') { ?>
                <li>
                  <p>The school has been registered with the Board with registration number. <strong><?php echo $school_sessions->biseregistrationNumber;  ?></strong> <strong><?php echo $school_sessions->biseregistrationNumber;  ?></strong></p>
                </li>
              <?php } else { ?>
                <li>
                  <p>School is not registered with any Board.</p>
                </li>
              <?php } ?>


            <?php } ?>

            <?php if (in_array("1", $error)) { ?>
              <p style="text-align:center; color:red">
                The note sheet for this session cannot be completed due to a pending issue from the previous session.
              </p>
            <?php } else { ?>

              <?php
              $query = "SELECT
                    `levelofinstitute`.`levelofInstituteTitle` as school_level,
                    `session_year`.`sessionYearTitle` as `session`,
                    `school`.`level_of_school_id` as lates_level_id,
                    `reg_type`.`regTypeTitle`
                    FROM
                    `school`,
                    `levelofinstitute`,
                    `session_year`,
                    reg_type
                    WHERE  `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                    AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                    AND school.reg_type_id = reg_type.regTypeId
                    AND schoolId = " . $school_id . "
                  AND school.status=2 ORDER BY `school`.`session_year_id` ASC";
              $apply_for_sessions = $this->db->query($query)->result();
              ?>
              <li> School Applied for
                <?php foreach ($apply_for_sessions as $apply_for_session) { ?>
                  <strong>
                    <?php echo $apply_for_session->regTypeTitle; ?>

                    <?php echo $apply_for_session->school_level; ?> level</strong> for session <strong><?php echo $apply_for_session->session; ?>,</strong>
                <?php } ?>




                <!-- <p><i>School apply for</i></p> -->
                <table class="table table-bordered table2" style="">
                  <tr>
                    <th>#</th>
                    <th>Session</th>
                    <th>Applied For</th>
                    <th>Level</th>

                    <th>Max Fee</th>
                    <th>Students</th>
                    <th>Teaching Staff</th>
                    <th>Non Teaching Staff</th>
                    <th class="hide_buttons">Status</th>
                    <th>Online Applied</th>
                  </tr>
                  <?php

                  $query = "SELECT
                          `reg_type`.`regTypeTitle`,
                          `levelofinstitute`.`levelofInstituteTitle`,
                          `session_year`.`sessionYearTitle`,
                          `session_year`.`sessionYearId`,
                          `school`.`renewal_code`,
                          `school`.`status`,
                          `school`.`created_date`,
                          `school`.`updatedBy`,
                          `school`.`updatedDate`,
                          `school`.`schoolId`,
                          `school`.`visit_list`,
                          `school`.`visit_type`,
                          `school`.`visit_entry_date`,
                          `school`.`cer_issue_date`,
                          school.pending_type,
                          school.pending_date,
                          school.pending_reason,
                          school.dairy_type,
                          school.dairy_no,
                          school.dairy_date,
                          `school`.`file_status`,
                          `school`.`apply_date`
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
                          AND school.status=2
                          AND school.schoolId = " . $school_id . "
                          ORDER BY `session_year`.`sessionYearId` ASC
                ";
                  $school_sessions = $this->db->query($query)->result();

                  $query = "select max(sessionYearId) as sessionYearId from session_year";
                  $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;


                  if ($school_sessions) {
                    $count = 1;
                    foreach ($school_sessions as $school_session) { ?>

                      <tr <?php if ($school_session->file_status == 5) { ?> class="alert-warning" <?php } ?>>
                        <td><?php echo $count++; ?></td>
                        <td>
                          <?php echo $school_session->sessionYearTitle; ?>
                        </td>
                        <th>
                          <?php echo $school_session->regTypeTitle; ?>
                          <small>
                            <button style="padding: 0px; margin:0px; font-size:9px" class="btn btn-link btn-sm hide_buttons" onclick="update_session_apply(<?php echo $school_session->schoolId ?>)">Edit Apply</button>
                          </small>
                        <th><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>

                        <td><?php
                            $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                            $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                            $max_tuition_fee = (int) preg_replace(
                              '/[^0-9.]/',
                              '',
                              $this->db->query($query)->result()[0]->max_tution_fee
                            );
                            echo $max_tuition_fee;
                            ?> Rs.</td>

                        <td style="text-align: center;"><?php
                                                        $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                                                        $enrollment = $this->db->query($query)->result()[0]->total;
                                                        if ($enrollment) {
                                                          echo $enrollment;
                                                        } else {
                                                          echo "Section C Missing";
                                                        }

                                                        ?></td>

                        <td style="text-align: center;">
                          <?php
                          $query = "SELECT COUNT(`schoolStaffId`) as total FROM `school_staff`
                    WHERE `school_staff`.`school_id`= '" . $school_session->schoolId . "'
                    AND `school_staff`.`schoolStaffType` = 1";
                          echo $this->db->query($query)->row()->total; ?>
                        </td>

                        <td style="text-align: center;">
                          <?php
                          $query = "SELECT COUNT(`schoolStaffId`) as total FROM `school_staff`
                    WHERE `school_staff`.`school_id`= '" . $school_session->schoolId . "'
                    AND `school_staff`.`schoolStaffType` = 2";
                          echo $this->db->query($query)->row()->total; ?>

                        </td>


                        <td class="hide_buttons"><?php

                                                  if (!is_null($school_session->file_status)) {
                                                    echo "New";
                                                    if ($school_session->file_status == 5) {
                                                      echo " - Deficient";
                                                    }
                                                  } else {
                                                    echo "Old";
                                                  }
                                                  ?>
                          <small>
                            <button style="padding: 0px; margin:0px; font-size:9px" class="btn btn-link btn-sm hide_buttons" onclick="add_bank_challan(<?php echo $school_session->schoolId ?>)">Add Challan</button>
                          </small>
                        </td>

                        <td>
                          <?php
                          if ($school_session->apply_date) {
                            echo date('d M, Y', strtotime($school_session->apply_date));
                          } ?>
                        </td>


                      </tr>
                      <?php //if ($school_session->sessionYearId == $current_session_id) {
                      ?>

                      <?php  //}
                      ?>
                    <?php
                      $previous_max = $max_tuition_fee;
                    }
                  } else { ?>
                    <tr>
                      <td colspan="12">
                        Not applied for registartion.
                      </td>
                    </tr>
                  <?php } ?>

                </table>


              <li>
                <p><i>Session / Class wise students enrollment</i></p>
              </li>
              <?php $classes = $this->db->query("SELECT * FROM class")->result(); ?>
              <table class="table table-bordered table2" style="font-size: 11px;">
                <tr>
                  <th>#</th>
                  <th>Session</th>
                  <?php foreach ($classes  as $class) { ?> <td>
                      <small>
                        <?php echo $class->classTitle; ?>
                      </small>
                    </td> <?php } ?>
                </tr>
                <tr>
                  <?php
                  $count = 1;
                  foreach ($school_sessions as $school_session) { ?>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $school_session->sessionYearTitle ?></td>
                    <?php foreach ($classes  as $class) { ?>
                      <?php $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'
                    AND `age_and_class`.`class_id` = '" . $class->classId . "'";
                      $enrollment = $this->db->query($query)->row()->total; ?>
                      <td>
                        <?php echo $enrollment; ?>
                      </td>
                    <?php } ?>
                </tr>
              <?php  } ?>
              </table>

              <li>
                <p><i>Session / class wise monthly tuition fee</i></p>
              </li>
              <?php $classes = $this->db->query("SELECT * FROM class")->result(); ?>
              <table class="table table-bordered table2" style="font-size: 11px;">
                <tr>
                  <th>#</th>
                  <th>Session</th>
                  <?php foreach ($classes  as $class) { ?>
                    <th>
                      <small>
                        <?php echo $class->classTitle; ?>
                      </small>
                    </th>
                  <?php } ?>
                </tr>


                <?php $query = "SELECT
                          `reg_type`.`regTypeTitle`,
                          `levelofinstitute`.`levelofInstituteTitle`,
                          `session_year`.`sessionYearTitle`,
                          `session_year`.`sessionYearId`,
                          `school`.`renewal_code`,
                          `school`.`status`,
                          `school`.`created_date`,
                          `school`.`updatedBy`,
                          `school`.`updatedDate`,
                          `school`.`schoolId`,
                          `school`.`visit_list`,
                          `school`.`visit_type`,
                          `school`.`visit_entry_date`,
                          `school`.`cer_issue_date`,
                          school.pending_type,
                          school.pending_date,
                          school.pending_reason,
                          school.dairy_type,
                          school.dairy_no,
                          school.dairy_date
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
                          AND schools_id = " . $schools_id . "
                          AND school.status = 1
                          ORDER BY `session_year`.`sessionYearId` DESC LIMIT 1
                ";
                $last_session = $this->db->query($query)->result();  ?>
                <?php
                $count = 0;
                foreach ($last_session as $school_session) { ?>
                  <tr style="background-color: lightgray;">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $school_session->sessionYearTitle ?></td>
                    <?php
                    foreach ($classes  as $class) {
                      $query = "SELECT `fee`.`tuitionFee`  FROM
                         `fee` WHERE `fee`.`school_id` = '" . $school_session->schoolId . "'
                         AND `fee`.`class_id` ='" . $class->classId . "'";
                      $session_fee = $this->db->query($query)->result()[0];

                      if ($session_fee->tuitionFee == 0) { ?>
                        <td style="text-align:center"> <?php $session_fee->tuitionFee ?> </td>
                      <?php   } else { ?>
                        <td style="text-align:center">
                          <?php echo $session_fee->tuitionFee; ?>
                        </td>
                      <?php } ?>
                    <?php } ?>

                  </tr>
                <?php } ?>

                <tr>
                  <?php
                  $fee_increase = array();
                  foreach ($school_sessions as $school_session) { ?>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $school_session->sessionYearTitle ?></td>
                    <?php
                    foreach ($classes  as $class) {
                      $query = "SELECT `fee`.`tuitionFee`  FROM
                         `fee` WHERE `fee`.`school_id` = '" . $school_session->schoolId . "'
                         AND `fee`.`class_id` ='" . $class->classId . "'";
                      $session_fee = $this->db->query($query)->result()[0];

                      $previous_session_id = $school_session->sessionYearId - 1;
                      if ($previous_session_id) {
                        $query = "SELECT schoolId FROM school WHERE session_year_id = $previous_session_id
                        AND school.schools_id = '" . $school->schools_id . "'
                        ";
                        $previous_school_id = $this->db->query($query)->row()->schoolId;
                      } else {
                        $previous_school_id = 0;
                      }
                      if ($previous_school_id) {
                        $query = "SELECT
                        `fee`.`addmissionFee`
                        , `fee`.`tuitionFee`
                        , `fee`.`securityFund`
                        , `fee`.`otherFund`
                        FROM
                        `fee` WHERE `fee`.`school_id` = '" . $previous_school_id . "'
                        AND `fee`.`class_id` ='" . $class->classId . "'";
                        $pre_session_tution_fee = preg_replace("/[^0-9.]/", "", $this->db->query($query)->result()[0]->tuitionFee);
                      }
                      $current_fee = preg_replace("/[^0-9.]/", "", $session_fee->tuitionFee);
                      if ($session_fee->tuitionFee == 0) { ?>
                        <td style="text-align:center"> <?php $session_fee->tuitionFee ?> </td>
                      <?php   } else { ?>
                        <td style="text-align:center">
                          <?php

                          if ($pre_session_tution_fee) {
                            $incress = round((($current_fee - $pre_session_tution_fee) / $pre_session_tution_fee) * 100, 2);
                            if ($incress > 10) {
                              echo '<strong>';
                              echo $session_fee->tuitionFee;
                              echo '</strong>';
                              $fee_increase[$school_session->sessionYearTitle][$class->classTitle] = round($incress);
                              echo @" <small style='color:red;  font-weight: bold;'>" . $incress . "%</small>";
                            } else {

                              echo $session_fee->tuitionFee;
                              //echo @" <small style='color:green'>" . $incress . " %</small>";
                            }
                          } else {
                            echo $session_fee->tuitionFee;
                          } ?>
                        </td>
                      <?php } ?>
                    <?php } ?>
                </tr>
              <?php  } ?>
              </table>

              <li>
                <p>
                  As per schedule notification the following required fee has been deposited by the above school administration.
                </p>
              </li>

              <table class="table table-bordered table2" style="font-size: 12px;">
                <thead>
                  <tr>
                    <th colspan="2"></th>
                    <th colspan="2">
                      STAN/Date
                    </th>
                    <th colspan="8">
                      PSRA Fee Heads
                    </th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Session</th>
                    <th>Type</th>
                    <th>STAN</th>
                    <th>Date</th>
                    <th>App. Proce.</th>
                    <th>Inspection</th>
                    <th>Renewal</th>
                    <th>Upgradation</th>
                    <th>Late</th>
                    <th>Security</th>
                    <th>Fine</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $count = 1;
                  foreach ($school_sessions as $school_session) { ?>
                    <?php
                    $query = "SELECT * FROM `bank_challans` 
                            WHERE schools_id = '" . $school->schools_id . "'
                            AND school_id = '" . $school_session->schoolId . "'";
                    $bank_challans = $this->db->query($query)->result();
                    if ($bank_challans) {
                      foreach ($bank_challans as $bank_challan) { ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><?php echo $school_session->sessionYearTitle ?></td>
                          <td><?php echo $bank_challan->challan_for; ?></td>
                          <td><?php echo $bank_challan->challan_no; ?></td>
                          <td><?php echo date('d M, Y', strtotime($bank_challan->challan_date)); ?></td>
                          <td><?php echo number_format($bank_challan->application_processing_fee); ?></td>
                          <td><?php echo number_format($bank_challan->inspection_fee); ?></td>
                          <td><?php echo number_format($bank_challan->renewal_fee); ?></td>
                          <td><?php echo number_format($bank_challan->upgradation_fee); ?></td>
                          <td><?php echo number_format($bank_challan->late_fee); ?></td>
                          <td><?php echo number_format($bank_challan->security_fee); ?></td>
                          <td><?php echo number_format($bank_challan->fine); ?></td>
                          <td><?php echo number_format($bank_challan->total_deposit_fee); ?></td>
                          <!-- <td><?php
                                    $query = "SELECT * FROM users WHERE userId = '" . $bank_challan->verified_by . "'";
                                    $verified_by = $this->db->query($query)->result()[0]->userTitle;
                                    echo $verified_by;
                                    ?></td> -->
                        </tr>
                      <?php  } ?>
                    <?php } else { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $school_session->sessionYearTitle ?></td>
                        <td colspan="23" style="text-align: center;">
                          No bank challan has been entered yet.
                        </td>
                      </tr>
                    <?php } ?>
                  <?php } ?>

                </tbody>
              </table>

              <?php
              //var_dump($fee_increase);
              if ($fee_increase) {
                $class_count = 0;
              ?>
                <!-- <li>
                As per para 3. of notesheet, the school administration increase max tuition fee for
                <?php foreach ($fee_increase as $session => $classes) { ?>
                  session <?php echo $session  ?>
                  <?php foreach ($classes as $class => $increase) { ?>
                    <strong> <?php echo $class . " - " . $increase; ?>% , </strong>
                  <?php
                    $class_count++;
                  } ?>
                <?php } ?>
                which <?php if ($class_count == 1) { ?> is <?php } ?> <?php if ($class_count > 1) { ?> are <?php } ?> beyond the 10%, this voilation of PSRA Act/Regulation.
              </li> -->
              <?php } ?>
              <br />
              <div>
                <?php
                $query = "SELECT *, users.userTitle, roles.role_title, DATE(comments.created_date) as created_date FROM comments 
              INNER JOIN users ON(users.userId = comments.created_by)
              INNER JOIN roles ON(roles.role_id = users.role_id)
              WHERE schools_id = '" . $schools_id . "' 
              AND school_id ='" . $school_id . "'
              AND deleted =0";
                $comments = $this->db->query($query)->result();
                //var_dump($comments);
                ?>
                <?php
                $count = 1;
                foreach ($comments as $comment) { ?>
                  <li style="margin-bottom:5px;">

                    <?php echo str_replace('\n', "<br />", str_replace('\r', '', $comment->comment)); ?>
                    <a class="hide_buttons" href="<?php echo site_url("online_cases/delete_comment/" . $comment->comment_id . "/" . $comment->schools_id); ?>"> x </a>

                    <small style="float: right;">
                      <strong> <?php echo $comment->role_title; ?> </strong> (<?php echo $comment->userTitle; ?>)
                      <strong> <?php echo date("D d M, Y", strtotime($comment->created_date));  ?> </strong>
                    </small>

                  </li>
                <?php } ?>

              </div>


              <!-- <div class="alert alert-warning" role="alert">
              Deficiency in session .......
            </div> -->

              <br />
              <br />

              <br />

              <br />

              <br />

              <br />

              <br />
            <?php } ?>


        </div>

      </section>
      <!-- /.content -->
    </div>
    <style>
      .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #CCCCCC;
        color: white;
        text-align: center;
      }
    </style>

    <div class="footer hide_buttons">
      <?php
      $query = "SELECT file_status FROM school WHERE schoolId ='" . $school_id . "'";
      echo $file_status = $this->db->query($query)->row()->file_status;

      ?>
      <?php if ($file_status == '10' or $file_status == '4') { ?>

      <?php } else { ?>
        <style type="text/css" media="print">
          * {
            display: none;
          }
        </style>
        <script>
          $(document).on('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
              alert("I'm sorry! \n Note sheet can be printed after they are marked as complete.\nThanks");
              e.cancelBubble = true;
              e.preventDefault();

              e.stopImmediatePropagation();
            }
          });
        </script>
      <?php } ?>

      <section style="width: 70%; margin:0px auto; margin-bottom:5px;">

        <form action="<?php echo site_url("online_cases/add_comment"); ?>" method="post">
          <?php
          $query = "SELECT session_year_id FROM school WHERE schools_id = '" . $school->schools_id . "' AND schoolId = '" . $school_id . "'";
          $session_year_id = $this->db->query($query)->row()->session_year_id;
          ?>


          <input type="hidden" name="session_id" value="<?php echo $session_year_id; ?>" />
          <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
          <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />

          <table class="table">
            <tr>
              <td><textarea name="comment" id="comment" onkeyup="autoheight(this)" style="width: 100%; height:40px; border-radius: 9px;"></textarea></td>
              <td style="width: 180px;">
                <button class="btn btn-primary btn-sm" onclick="submit_comment()" style="margin:2px; background-color:#A6A6A6; border:1px solid #A6A6A6;">Add Note Sheet Para </button>
              </td>
            </tr>

          </table>
        </form>
        <a class="btn btn-warning btn-sm" href="<?php echo site_url("online_cases"); ?>">Back To Dashboard</a>
        <?php if ($file_status == 4 or $file_status == 10) { ?>
          <button class="btn btn-info btn-sm" onclick="window.print();"> <i class="fa fa-print" aria-hidden="true"></i> Print Note Sheet</button>
        <?php } ?>
        <button class="btn btn-danger btn-sm" onclick="mark_as_complete('<?php echo $school_id; ?>')">Mark as completed</a>
      </section>


    </div>

    <script>
      function autoheight(x) {
        x.style.height = "5px";
        x.style.height = (15 + x.scrollHeight) + "px";
      }

      function get_comments() {

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('registration_section/get_comments'); ?>",
            data: {
              session_id: <?php echo $session_year_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>
            }
          })
          .done(function(respose) {
            $('#all_comments').html(respose);
          });
      }
    </script>


</body>

<script>
  function update_session_apply(school_id) {
    $('#request_detail_body').html('Please Wait .....');

    $.ajax({
      type: "POST",
      url: "<?php echo site_url("online_cases/get_apply_edit_form"); ?>",
      data: {
        school_id: school_id,
        schools_id: '<?php echo $school->schools_id ?>'
      }
    }).done(function(data) {

      $('#request_detail_body').html(data);
    });

    $('#request_detail').modal('show');
  }

  function add_bank_challan(school_id) {
    $('#request_detail_body').html('Please Wait .....');
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("online_cases/get_session_challan_form"); ?>",
      data: {
        school_id: school_id,
        schools_id: '<?php echo $school->schools_id ?>'
      }
    }).done(function(data) {

      $('#request_detail_body').html(data);
    });

    $('#request_detail').modal('show');
  }

  function mark_as_complete(school_id) {
    $('#request_detail_body').html('Please Wait .....');
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("online_cases/mark_as_complete_form"); ?>",
      data: {
        school_id: school_id,
        schools_id: '<?php echo $school->schools_id ?>'
      }
    }).done(function(data) {

      $('#mark_as_complete_modal_body').html(data);
    });

    $('#mark_as_complete_modal').modal('show');
  }
</script>


</html>