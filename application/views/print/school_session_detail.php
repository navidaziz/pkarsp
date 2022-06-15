<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Session Detail: <?php echo $school->schoolId; ?>-<?php echo $school_id; ?></title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style type="text/css">
    body {
      background: rgb(204, 204, 204);
      font-family: 'Source Sans Pro', 'Regular' !important;

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
      /* height: 29.7cm;  */
      height: auto;
    }

    @media print {
      page[size="A4"] {
        width: 98%;
        margin: 0 auto;
        margin-top: 30px;
        /* height: 29.7cm;  */
        height: auto;
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
      font-size: 12px !important;

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

    }
  </style>
</head>

<body>
  <page size='A4'>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <div class="col-md-12">
          <table class="table">
            <tr>
              <td>
                <h3 style="text-transform: uppercase;"><?php echo @$school->schoolName; ?> <?php if (!empty($school->ppcCode)) {
                                                                                              echo " - PPC Code" . $school->ppcCode;
                                                                                            } ?></h3>

                <address>
                  <?php if ($school->district_id) {
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

              </td>
              <td>
                <h6>
                  School Id # <?php echo $school->schoolId; ?> <br />
                  <?php if ($school->registrationNumber != 0) : ?>
                    <?php echo "Registration # " . @$school->registrationNumber; ?><br />
                  <?php endif; ?>
                  Session Year: <?php echo @$school->sessionYearTitle; ?><br />
                  Case: <?php echo @$school->regTypeTitle; ?>
                </h6>

              </td>
            </tr>

          </table>

          <hr>
        </div>
        <div class="col-md-12">
          <table class="table table2 table-bordered">
            <tr>
              <td>

                <table class="table">
                  <tr>

                    <td class="text-center"><strong style="font-size: 20px;">Section-A: Institute Basic Detail</strong></td>
                  </tr>
                  <tbody>
                    <tr>
                      <td style="font-size: 14px !important; line-height: 18px;">
                        <?php if (!empty($school->yearOfEstiblishment)) : ?>
                          <?php echo "Established In: " . $school->yearOfEstiblishment; ?>
                          <br>
                        <?php endif; ?>
                        <?php if (!empty($school->telePhoneNumber)) : ?>
                          <?php echo "Tele-Phone #: " . $school->telePhoneNumber; ?>
                          <br>
                        <?php endif; ?>
                        <?php if (!empty($school->genderOfSchoolTitle)) : ?>
                          <?php echo "School For: " . $school->genderOfSchoolTitle; ?>
                          <br>
                        <?php endif; ?>
                        <?php if (!empty($school->levelofInstituteTitle)) : ?>
                          <?php echo "School Level: " . $school->levelofInstituteTitle; ?>
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

                        <?php if (!empty($school->late)) : ?>
                          <b>Latitude:</b>
                          <?php echo @$school->late; ?>
                          <br />
                        <?php endif; ?>
                        <?php if (!empty($school->longitude)) : ?>
                          <b>Longitude:</b>
                          <?php echo @$school->longitude; ?>
                        <?php endif; ?>
                        <strong>View Location: </strong>
                        <br />
                        <a onclick="sendCordinates(<?php echo $school->late; ?>,<?php echo $school->longitude; ?>);" data-toggle="modal" data-target="#viewMap" href="#" class="glyphicon glyphicon-map-marker">View Location</a>
                        <br />
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
                        <?php if (!empty($school_bank->bankAccountNumber)) : ?>
                          <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                              <p class="lead">Account Information</p>
                              <div class="table-responsive">
                                <table class="table table-striped">
                                  <tr>
                                    <th style="width:50%">Account Name:</th>
                                    <td><?php if ($school_bank->bankAccountName) {
                                          echo $school_bank->bankAccountName;
                                        } ?></td>
                                  </tr>
                                  <tr>
                                    <th>Account Number:</th>
                                    <td><?php if ($school_bank->bankAccountNumber) {
                                          echo $school_bank->bankAccountNumber;
                                        } ?></td>
                                  </tr>
                                  <tr>
                                    <th>Branch Code</th>
                                    <td><?php if ($school_bank->bankBranchCode) {
                                          echo $school_bank->bankBranchCode;
                                        } ?></td>
                                  </tr>
                                  <tr>
                                    <th>Account Title:</th>
                                    <td><?php if ($school_bank->accountTitle) {
                                          echo $school_bank->accountTitle;
                                        } ?></td>
                                  </tr>
                                  <tr>
                                    <th>Branch Address:</th>
                                    <td><?php if ($school_bank->bankBranchAddress) {
                                          echo $school_bank->bankBranchAddress;
                                        } ?></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        <?php endif; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </td>
              <td>

                <table class="table">
                  <tr>

                    <td colspan="2" class="text-center"><strong style="font-size: 20px;">Section-B: Physical Facilities</strong></td>
                  </tr>
                  <tbody>

                    <tr>
                      <td style="width:50%;"><b>Building</b></td>
                      <td><?php echo $school_physical_facilities->physicalBuildingTitle; ?></td>
                    </tr>
                    <?php if ($school_physical_facilities->physicalBuildingTitle == 'Rented') { ?>
                      <tr>
                        <td style="width:50%;"><b>Rent Amount</b></td>
                        <td><?php echo $school_physical_facilities->rent_amount; ?></td>
                      </tr>
                    <?php } ?>
                    <?php if (!empty($school_physical_facilities->numberOfClassRoom)) : ?>
                      <tr>
                        <td><b>Class Rooms</b></td>
                        <td>
                          <?php echo $school_physical_facilities->numberOfClassRoom; ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php if (!empty($school_physical_facilities->numberOfOtherRoom)) : ?>
                      <tr>
                        <td><b>Other Rooms</b></td>
                        <td>
                          <?php echo $school_physical_facilities->numberOfOtherRoom; ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php if (!empty($school_physical_facilities->totalArea)) : ?>
                      <tr>
                        <td><b>Total Area</b></td>
                        <td>
                          <?php echo $school_physical_facilities->totalArea; ?> Marlas
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php if (!empty($school_physical_facilities->coveredArea)) : ?>
                      <tr>
                        <td><b>Covered Area</b></td>
                        <td>
                          <?php echo $school_physical_facilities->coveredArea; ?> Marlas
                        </td>
                      </tr>
                    <?php endif; ?>

                    <?php $physical_count = count($school_physical_facilities_physical); ?>
                    <?php if ($physical_count > 0) : ?>
                      <tr>
                        <td><b>Physical Facilities Availible</b></td>
                        <td>
                          <?php $counter = 1; ?>
                          <?php foreach ($school_physical_facilities_physical as $physical) : ?>
                            <?php echo $physical->physicalTitle; ?>
                            <?php if ($physical_count == $counter) : ?>
                              <?php echo "."; ?>
                              <?php else : ?>,
                            <?php endif; ?>
                            <?php $counter++; ?>
                          <?php endforeach; ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php if (!empty($school_physical_facilities->numberOfLatrines)) : ?>
                      <tr>
                        <td><b>Number Of Toilets</b></td>
                        <td>
                          <?php echo $school_physical_facilities->numberOfLatrines; ?>
                        </td>
                      </tr>
                    <?php endif; ?>

                    <?php $academic_count = count($school_physical_facilities_academic); ?>
                    <?php if ($academic_count > 0) : ?>
                      <tr>
                        <td><b>academic Facilities Availible</b></td>
                        <td>
                          <?php $counter = 1; ?>
                          <?php foreach ($school_physical_facilities_academic as $academic) : ?>
                            <?php echo $academic->academicTitle; ?>
                            <?php if ($physical_count == $counter) : ?>
                              <?php echo "."; ?>
                              <?php else : ?>,
                            <?php endif; ?>
                            <?php $counter++; ?>
                          <?php endforeach; ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php if (!empty($school_physical_facilities->numberOfComputer)) : ?>
                      <tr>
                        <td><b>Number Of Computer</b></td>
                        <td>
                          <?php echo $school_physical_facilities->numberOfComputer; ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php $curricular_count = count($school_physical_facilities_co_curricular); ?>
                    <?php if ($curricular_count > 0) : ?>
                      <tr>
                        <td><b>Co curricular Facilities Availible</b></td>
                        <td>
                          <?php $counter = 1; ?>
                          <?php foreach ($school_physical_facilities_co_curricular as $curricular) : ?>
                            <?php echo $curricular->coCurricularTitle; ?>
                            <?php if ($curricular_count == $counter) : ?>
                              <?php echo "."; ?>
                              <?php else : ?>,
                            <?php endif; ?>
                            <?php $counter++; ?>
                          <?php endforeach; ?>
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php $other_count = count($school_physical_facilities_other); ?>
                    <?php if ($other_count > 0) : ?>
                      <tr>
                        <td><b>Other Facilities Availible</b></td>
                        <td>
                          <?php $counter = 1; ?>
                          <?php foreach ($school_physical_facilities_other as $other) : ?>
                            <?php echo $other->otherTitle; ?>
                            <?php if ($other_count == $counter) : ?>
                              <?php echo "."; ?>
                              <?php else : ?>,
                            <?php endif; ?>
                            <?php $counter++; ?>
                          <?php endforeach; ?>
                        </td>
                      </tr>
                    <?php endif; ?>

                  </tbody>
                </table>

            </tr>
          </table>
        </div>
        <div class="col-md-12">
          <?php //if ($library_count > 0) { 
          ?>
          <table class="table table2 table-bordered">
            <tr>
              <td colspan="<?php echo count($school_library); ?>" class="text-center">
                <strong style="font-size: 20px;">Library details</strong>
              </td>
            </tr>
            <?php $library_count = count($school_library); ?>

            <tr>
              <?php foreach ($school_library as $library) : ?>

                <td><b><?php echo $library->bookType; ?></b></td>


              <?php endforeach; ?>
            </tr>
            <tr>
              <?php foreach ($school_library as $library) : ?>
                <td>
                  <?php echo $library->numberOfBooks; ?>
                  <span class="pull-right no-print">

                  </span>
                </td>

              <?php endforeach; ?>
            </tr>
          </table>
          <?php //} 
          ?>
        </div>
        <div class="col-md-12">
          <table class="table table2 table-bordered">
            <tr>
              <th colspan="24" style="text-align: center;">
                <strong style="font-size: 20px;">
                  Section-C: Class & Age Wise Enrollement
                </strong>
              </th>
            </tr>
            <tr>
              <th rowspan="2">
                Classes
              </th>
              <th colspan="19">Age Categories</th>
              <th colspan="3"></th>
            </tr>
            <tr>
              <?php

              //     $level_of_school_id = $this->data['school']->level_of_school_id;
              //     $query = "SELECT classes_ids FROM `levelofinstitute` 
              // WHERE levelofInstituteId='" . $level_of_school_id . "'";
              //     $classes_ids = $this->db->query($query)->result()[0]->classes_ids;
              //     $query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";

              $classes = $this->db->query("SELECT * FROM class")->result();
              $ages = $this->db->query("SELECT * FROM age")->result();
              $count = 1;
              foreach ($ages  as $age) { ?>
                <th><?php echo $age->ageTitle; ?></th>
              <?php } ?>
              <th>Total</th>
              <th>Non-Muslims</th>
              <th>Disabled</th>
            </tr>

            <?php foreach ($classes  as $class) { ?>
              <tr>
                <th style=""><?php echo $class->classTitle ?></th>
                <?php
                $total_class_enrollment = 0;
                foreach ($ages  as $age) { ?>
                  <td style="text-align: center;"><?php $query = "SELECT SUM(`enrolled`) as enrolled  FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND class_id ='" . $class->classId . "'
                                            AND school_id = '" . $school_id . "'";
                                                  $query_result = $this->db->query($query)->result();
                                                  if ($query_result) {
                                                    $total_class_enrollment += $query_result[0]->enrolled;
                                                    echo $query_result[0]->enrolled;
                                                  }
                                                  ?></td>
                <?php
                  $total_school_entrollment += $total_class_enrollment;
                } ?>
                <th style="text-align: center; "><?php echo $total_class_enrollment; ?></th>
                <?php $query = "SELECT SUM(`non_muslim`) as non_muslim,
                    SUM(`disabled`) as disabled FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND class_id ='" . $class->classId . "'  ";
                $query_result = $this->db->query($query)->result();
                ?>
                <th style=" text-align: center;"><?php if ($query_result) {
                                                    echo $query_result[0]->non_muslim;
                                                  } ?> </th>
                <th style=" text-align: center;"> <?php if ($query_result) {
                                                    echo $query_result[0]->disabled;
                                                  } ?> </th>


              </tr>
            <?php } ?>
            <tr>
              <th style="text-align: right; ">Total</th>
              <?php
              $total_school_entrollment  = 0;
              foreach ($ages  as $age) { ?>
                <th style="text-align: center; "><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND school_id = '" . $school_id . "'";
                                                  $query_result = $this->db->query($query)->result();
                                                  if ($query_result) {
                                                    $total_school_entrollment += $query_result[0]->enrolled;
                                                    echo $query_result[0]->enrolled;
                                                  }
                                                  ?></th>
              <?php } ?>


              <th style="text-align: center; "><?php echo $total_school_entrollment; ?></th>
              <?php $query = "SELECT SUM(`non_muslim`) as non_muslim, SUM(`disabled`) as disabled
                                  FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'";
              $query_result = $this->db->query($query)->result();
              ?>
              <th style="text-align: center; "><?php if ($query_result) {
                                                  echo $query_result[0]->non_muslim;
                                                } ?> </th>
              <th style="text-align: center; "> <?php if ($query_result) {
                                                  echo $query_result[0]->disabled;
                                                } ?> </th>

            </tr>

          </table>

        </div>
        <br />
        <div class="col-md-12">
          <table class="table table2 table-bordered">
            <thead>
              <tr>
                <th colspan="14" style="text-align: center;">
                  <strong style="font-size: 20px;">Section-D: Staff Detail</strong>
                </th>
              </tr>
              <tr>
                <th>#</th>
                <th style="width: 130px;">Name</th>
                <th style="width: 130px;">F/Husband Name</th>
                <th style="width: 100px;">CNIC</th>
                <th>Gender</th>
                <th>Type</th>
                <th>Academic</th>
                <th>Professional</th>
                <th>Training In Months</th>
                <th>Experience In Months</th>
                <th>Designation</th>
                <th>Appointment At</th>
                <th>Net.Pay</th>
                <th>Annual Increament</th>

              </tr>
            </thead>
            <tbody>
              <?php $counter = 1; ?>

              <?php foreach ($school_staff as $st) : ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $st->schoolStaffName; ?></td>
                  <td><?php echo $st->schoolStaffFatherOrHusband; ?></td>
                  <td><?php echo $st->schoolStaffCnic; ?></td>
                  <td><?php echo $st->genderTitle; ?></td>
                  <td><?php echo $st->staffTtitle; ?></td>
                  <td><?php echo $st->schoolStaffQaulificationAcademic; ?></td>
                  <td><?php echo $st->schoolStaffQaulificationProfessional; ?></td>
                  <td><?php echo $st->TeacherTraining; ?></td>
                  <td><?php echo $st->TeacherExperience; ?></td>
                  <td><?php echo $st->schoolStaffDesignition; ?></td>
                  <td><?php echo $st->schoolStaffAppointmentDate; ?></td>
                  <td><?php echo $st->schoolStaffNetPay; ?></td>
                  <td><?php echo $st->schoolStaffAnnualIncreament; ?></td>

                </tr>
                <?php $counter++; ?>
              <?php endforeach; ?>


            </tbody>
          </table>
        </div>
        <br />
        <div class="col-md-12">
          <table class="table table2 table-bordered">
            <tr>
              <th colspan="15">
                <strong style="font-size: 20px;"> Section-E: Student Dues/Funds Details</strong>
              </th>
            </tr>

            <tr>
              <th>Fee's</th>
              <?php
              $admission_fee_row = "";
              $tuitionFee_row = "";
              $securityFund_row = "";
              $otherFund_row = "";
              foreach ($classes  as $class) { ?>

                <th><?php echo $class->classTitle ?></th>
              <?php

                $query = "SELECT
                        `fee`.`addmissionFee`
                        , `fee`.`tuitionFee`
                        , `fee`.`securityFund`
                        , `fee`.`otherFund`
                        FROM
                        `fee` WHERE `fee`.`school_id` = '" . $school_id . "'
                        AND `fee`.`class_id` ='" . $class->classId . "'";

                $session_fee = $this->db->query($query)->result()[0];
               // $session_fee->addmissionFee = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->addmissionFee));
                $admission_fee_row .= '<td>' . $session_fee->addmissionFee . '</td>';
               // $session_fee->tuitionFee = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->tuitionFee));
                $tuitionFee_row .= '<td>' . $session_fee->tuitionFee . '</td>';
               // $session_fee->securityFund = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->securityFund));
                $securityFund_row .= '<td>' . $session_fee->securityFund . '</td>';
               // $session_fee->otherFund = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->otherFund));
                $otherFund_row .= '<td>' . $session_fee->otherFund . '</td>';
              } ?>
            </tr>
            <tr>
              <th>Admission Fee</th><?php echo $admission_fee_row; ?>
            </tr>
            <tr>
              <th>Security Fee</th>
              <?php echo $securityFund_row; ?>
            </tr>
            <tr>
              <th>Others</th>
              <?php echo $otherFund_row; ?>
            </tr>
            <tr>
              <th>Tuition Fee</th>
              <?php echo $tuitionFee_row; ?>
            </tr>

          </table>
        </div>
        <br />

        <div class="col-md-12">
          <table class="table">
            <tr>
              <td>
                <table class="table table-bordered ">
                  <tr>
                    <td colspan="2"><strong style="font-size: 20px;">Section-F: SECURITY MEASURES</strong></td>
                  </tr>
                  <tbody>
                    <?php if ($school_security_measures) { ?>


                      <tr>
                        <td><b>Security Status</b></td>
                        <td><?php echo $school_security_measures->securityStatusTitle; ?></td>
                      </tr>
                      <?php if (!empty($school_security_measures->securityProvidedTitle)) : ?>
                        <tr>
                          <td><b>Security Provided</b></td>
                          <td>
                            <?php echo $school_security_measures->securityProvidedTitle; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->SecurityPersonnelTitle)) : ?>
                        <tr>
                          <td><b>Security Personnel (in Nos)</b></td>
                          <td>
                            <?php echo $school_security_measures->SecurityPersonnelTitle; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->securityPersonnel)) : ?>
                        <tr>
                          <td><b>Status of Security personnel</b></td>
                          <td>
                            <?php echo $school_security_measures->securityPersonnel; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->security_according_to_police_dept)) : ?>
                        <tr>
                          <td><b>Security is inline with instruction of Police Department</b></td>
                          <td>
                            <?php echo $school_security_measures->security_according_to_police_dept; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->cameraInstallation)) : ?>
                        <tr>
                          <td><b>CCTVs Camera System Installed</b></td>
                          <td>
                            <?php echo $school_security_measures->cameraInstallation; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->camraNumber)) : ?>
                        <tr>
                          <td><b>Number of CCTVs Cameras</b></td>
                          <td>
                            <?php echo $school_security_measures->camraNumber; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->dvrMaintained)) : ?>
                        <tr>
                          <td><b>DVR Maintained</b></td>
                          <td>
                            <?php echo $school_security_measures->dvrMaintained; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->cameraOnline)) : ?>
                        <tr>
                          <td><b>CCTVs Online Accessibility</b></td>
                          <td>
                            <?php echo $school_security_measures->cameraOnline; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->exitDoorsNumber)) : ?>
                        <tr>
                          <td><b>Number of Exit Doors</b></td>
                          <td>
                            <?php echo $school_security_measures->exitDoorsNumber; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->emergencyDoorsNumber)) : ?>
                        <tr>
                          <td><b>Emergency Exit Door Availability</b></td>
                          <td>
                            <?php echo $school_security_measures->emergencyDoorsNumber; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->boundryWallHeight)) : ?>
                        <tr>
                          <td><b>Boundary Wall Height (In Feet)</b></td>
                          <td>
                            <?php echo $school_security_measures->boundryWallHeight; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->wiresProvided)) : ?>
                        <tr>
                          <td><b>Barbed Wires Provided</b></td>
                          <td>
                            <?php echo $school_security_measures->wiresProvided; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->watchTower)) : ?>
                        <tr>
                          <td><b>Watch Tower</b></td>
                          <td>
                            <?php echo $school_security_measures->watchTower; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->licensedWeapon)) : ?>
                        <tr>
                          <td><b>Number of Licensed Weapon(s)</b></td>
                          <td>
                            <?php echo $school_security_measures->licensedWeapon; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->licenseIssuedTitle)) : ?>
                        <tr>
                          <td><b>License issued by</b></td>
                          <td>
                            <?php echo $school_security_measures->licenseIssuedTitle; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->licenseNumber)) : ?>
                        <tr>
                          <td><b>License No(s)</b></td>
                          <td>
                            <?php echo $school_security_measures->licenseNumber; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->ammunitionStatus)) : ?>
                        <tr>
                          <td><b>Ammunition Status (In Nos.)</b></td>
                          <td>
                            <?php echo $school_security_measures->ammunitionStatus; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->metalDetector)) : ?>
                        <tr>
                          <td><b>Metal Detector</b></td>
                          <td>
                            <?php echo $school_security_measures->metalDetector; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->walkThroughGate)) : ?>
                        <tr>
                          <td><b>Walkthrough gate</b></td>
                          <td>
                            <?php echo $school_security_measures->walkThroughGate; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_security_measures->gateBarrier)) : ?>
                        <tr>
                          <td><b>Main Gate Barrier</b></td>
                          <td>
                            <?php echo $school_security_measures->gateBarrier; ?>
                          </td>
                        </tr>
                      <?php endif; ?>


                      <!-- /.row -->
                    <?php } ?>

                  </tbody>
                </table>
              </td>
              <td>
                <table class="table table-bordered">
                  <tr>
                    <td colspan="2">
                      <strong style="font-size: 20px;">Section-G: HAZARDS WITH ASSOCIATED RISKS</strong>
                    </td>
                  </tr>
                  <tbody>
                    <?php if ($school_hazards_with_associated_risks) { ?>

                      <tr>
                        <td><b>Exposed to floods</b></td>
                        <td><?php echo $school_hazards_with_associated_risks->exposedToFlood; ?></td>
                      </tr>
                      <?php if (!empty($school_hazards_with_associated_risks->drowning)) : ?>
                        <tr>
                          <td><b>Drowning (In case of nearby canal)</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->drowning; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->buildingCondition)) : ?>
                        <tr>
                          <td><b>School Building Condition (Walls, Doors, windows)</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->buildingCondition; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->accessRoute)) : ?>
                        <tr>
                          <td><b>School Access route</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->accessRoute; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php $hazards_with_associated_risks_unsafe_list_count = count($hazards_with_associated_risks_unsafe_list); ?>
                      <?php if ($hazards_with_associated_risks_unsafe_list_count > 0) : ?>
                        <tr>
                          <td><b>In case of unsafe Access route</b></td>
                          <td>
                            <?php $counter1 = 1; ?>
                            <?php foreach ($hazards_with_associated_risks_unsafe_list as $hz_list_item) : ?>
                              <?php echo $hz_list_item->unSafeListTitle; ?>
                              <?php if ($hazards_with_associated_risks_unsafe_list_count == $counter1) : ?>
                                <?php echo "."; ?>
                                <?php else : ?>,
                              <?php endif; ?>
                              <?php $counter1++; ?>
                            <?php endforeach; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->adjacentBuilding)) : ?>
                        <tr>
                          <td><b>Other buildings adjacent to School</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->adjacentBuilding; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->safeAssemblyPointsAvailable)) : ?>
                        <tr>
                          <td><b>Safe assembly points available for <br>(i. Flood ii. Earthquake iii. Fire iii. Human induce)</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->safeAssemblyPointsAvailable; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->disasterTraining)) : ?>
                        <tr>
                          <td><b>Teacher trained on School Based Disaster Risk Management</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->disasterTraining; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->schoolImprovementPlan)) : ?>
                        <tr>
                          <td><b>School Improvement plan developed</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->schoolImprovementPlan; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->schoolDisasterManagementPlan)) : ?>
                        <tr>
                          <td><b>School Disaster Management plan developed</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->schoolDisasterManagementPlan; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->electrificationTitle)) : ?>
                        <tr>
                          <td><b>Electrification condition</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->electrificationTitle; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->ventilationSystemAvailable)) : ?>
                        <tr>
                          <td><b>Proper ventilation system available</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->ventilationSystemAvailable; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->chemicalsSchoolLaboratory)) : ?>
                        <tr>
                          <td><b>Expose to Chemicals in School Laboratory</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->chemicalsSchoolLaboratory; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->chemicalsSchoolSurrounding)) : ?>
                        <tr>
                          <td><b>Expose to Chemicals in school surrounding</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->chemicalsSchoolSurrounding; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->roadAccident)) : ?>
                        <tr>
                          <td><b>Exposed to road accident</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->roadAccident; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->safeDrinkingWaterAvailable)) : ?>
                        <tr>
                          <td><b>Safe drinking water available</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->safeDrinkingWaterAvailable; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->sanitationFacilities)) : ?>
                        <tr>
                          <td><b>Proper sanitation facilities available (Latrine, draining)</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->sanitationFacilities; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->buildingStructure)) : ?>
                        <tr>
                          <td><b>School Building Structure</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->buildingStructure; ?>
                          </td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($school_hazards_with_associated_risks->hazardsSurroundedTitle)) : ?>
                        <tr>
                          <td><b>School surrounded by the community</b></td>
                          <td>
                            <?php echo $school_hazards_with_associated_risks->hazardsSurroundedTitle; ?>
                          </td>
                        </tr>
                      <?php endif; ?>



                    <?php } ?>

                  </tbody>
                </table>
              </td>
            </tr>
            <td colspan="2">
              <table class="table table2 table-bordered">
                <thead class="small_font">
                  <tr>
                    <th colspan="4">
                      <strong style="font-size: 20px;"> Section-H: Fee Concession</strong>
                    </th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Concession Type</th>
                    <th>Total Students On Fee Concession</th>
                    <th>Fee Concession (In Precentage)</th>

                  </tr>
                </thead>
                <tbody class="small_font">
                  <?php $counter = 1; ?>
                  <?php
                  $query = "SELECT * FROM `concession_type`";
                  $fee_cencession_types = $this->db->query($query)->result();

                  ?>
                  <?php foreach ($fee_cencession_types as $fee_cencession_type) :
                    $query = "SELECT * FROM `fee_concession`
                            WHERE school_id = '" . $school_id . "'
                            AND concession_id = '" . $fee_cencession_type->concessionTypeId . "'";
                    $concession = $this->db->query($query)->result()[0];
                  ?>
                    <tr>
                      <th><?php echo $counter; ?></th>
                      <th><?php echo $fee_cencession_type->concessionTypeTitle; ?></th>
                      <td><?php echo $concession->numberOfStudent; ?></td>
                      <td><?php echo (int) $concession->percentage; ?>
                        <strong><?php if ($concession->percentage) { ?> % <?php } ?></strong>
                      </td>

                    </tr>
                    <?php $counter++; ?>
                  <?php endforeach; ?>
                </tbody>


              </table>
            </td>
          </table>

        </div>



      </section>
      <!-- /.content -->
      <div class="clearfix"></div>
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal -->
    <div class="modal fade" id="modal_one" role="dialog" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="modal_one_title">title will be goes dynamically</h4>
          </div>
          <div id="modal_one_content_goes_here" style="padding: 30px;">

          </div>
        </div>

      </div>
    </div>
    <div id="viewMap" tabindex="-1" role="dialog" class="modal in">
      <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceIn">
          <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">×</span> <span class="sr-only">Close</span> </button>
            <h4 class="modal-title">Map View</h4>
          </div>
          <div class="modal-body">
            <div id="mapBody">
            </div>

            <script>
              function sendCordinates(id1, id2) {
                if (typeof id1 == 'undefined')
                  return false;
                var latitude = parseFloat(id1);
                var longitude = parseFloat(id2);
                document.getElementById('mapBody').innerHTML = "<div id='map' style='width:100%;height:400px;'></div>";
                var positionMap = {
                  lat: latitude,
                  lng: longitude
                };
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 14,
                  center: new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude)),
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var marker = new google.maps.Marker({
                  position: positionMap,
                  animation: google.maps.Animation.BOUNCE
                });
                marker.setMap(map, marker);
                var infowindow = new google.maps.InfoWindow({
                  content: "School Location"
                });
                infowindow.open(map, marker);
              }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTbYZF_kDxKNopcvej6oh-eVs1z9Xq2J0&callback=sendCordinates"></script>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      function load_form_in_modal(id, title, url) {

        $.ajax({
          type: 'POST',
          url: "<?php echo base_url('') ?>" + url,
          data: {
            "id": id
          },
          success: function(data) {
            $('#modal_one').modal('show');
            $("#modal_one_content_goes_here").html(data);
            $("#modal_one_title").html(title);
          },
          error: function(data) {
            // alert("getUcsByTehsilsId :s"+data);
          }
        });
        // $('#myModal').modal('show');

      }
    </script>