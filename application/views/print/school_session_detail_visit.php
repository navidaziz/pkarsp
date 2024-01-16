<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Session Detail: <?php echo $school->schoolId; ?>-<?php echo $school_id; ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
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
    padding: 5px;
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
                <h4> Apply for <strong><?php echo $school->levelofInstituteTitle ?></strong> level, <strong><?php echo @$school->regTypeTitle; ?></strong></h4>
                <table class="table table-bordered">
                  <tr style="text-align: center;">
                    <th>Primary</th>
                    <th>Middle</th>
                    <th>High</th>
                    <th>High Secondary</th>
                    <th>
                      O Level and A level

                    </th>
                    <th>Gender of Education</th>
                    <th>Institute Timing</th>


                  </tr>
                  <tr style="text-align: center;">
                    <td><?php if ($school->levelofInstituteTitle == 'Primary') { ?>&#10004; <?php } ?></td>
                    <td><?php if ($school->levelofInstituteTitle == 'Middle') { ?>&#10004; <?php } ?></td>
                    <td><?php if ($school->levelofInstituteTitle == 'High') { ?>&#10004; <?php } ?></td>
                    <td><?php if ($school->levelofInstituteTitle == 'Higher Secondary') { ?>&#10004; <?php } ?></td>
                    <td>
                      <?php
                      $query = "select a_o_level, telePhoneNumber, schoolMobileNumber, principal_email FROM schools WHERE schoolId = '" . $schools_id . "'";
                      $school_more_info = $this->db->query($query)->row();
                      //var_dump($a_o_level);
                      ?>

                      <input type="radio" name="a_o_level" value="1" <?php if ($school_more_info->a_o_level === "1") {
                                                                        echo "checked";
                                                                      } ?> required /> Yes <span style="margin-left: 10px;"></span>
                      <input type="radio" name="a_o_level" value="0" <?php if ($school_more_info->a_o_level === "0") {
                                                                        echo "checked";
                                                                      } ?> required /> No
                    </td>
                    <td><?php echo " " . $school->genderOfSchoolTitle; ?></td>
                    <td> <input required type="radio" name="timing" value="morning" <?php if ($school_physical_facilities->timing == 'morning') {
                                                                                      echo 'checked';
                                                                                    } ?> /> Morning <span style="margin-left: 10px;"></span>
                      <input required type="radio" name="timing" value="evening" <?php if ($school_physical_facilities->timing == 'evening') {
                                                                                    echo 'checked';
                                                                                  } ?> /> Evening <span style="margin-left: 10px;"></span>

                      <input required type="radio" name="timing" value="both" <?php if ($school_physical_facilities->timing == 'both') {
                                                                                echo 'checked';
                                                                              } ?> /> Both
                    </td>
                  </tr>
            </tr>
          </table>


          </td>
          <td>
            <h4>
              School Id # <?php echo $school->schoolId; ?> <br />
              <?php if ($school->registrationNumber != 0) : ?>
                <?php echo "Registration # " . @$school->registrationNumber; ?><br />
              <?php endif; ?>
              Session Year: <?php echo @$school->sessionYearTitle; ?><br />
              Case: <?php echo @$school->regTypeTitle; ?><br />
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

          <hr>
        </div>
        <div class="col-md-12">
          <strong>Please confirm location of the school</strong>
          <table class="table table-bordered">
            <tr>
              <th style="width: 50px;">Location</th>
              <th style="width: 110px;">District</th>
              <th style="width: 110px;">Tehsil</th>
              <th style="width: 130px;">UC</th>
              <th>Address</th>
              <th style="width: 130px;">Latitude</th>
              <th style="width: 130px;">Longitude</th>
              <th style="width: 130px;">Land Type</th>

            </tr>
            <tr>
              <td></td>
              <td><?php echo $school->districtTitle; ?></td>
              <td><?php echo $school->tehsilTitle; ?></td>
              <td><?php echo $school->ucTitle; ?></td>
              <td><?php echo $school->address; ?></td>
              <td><?php echo $school->late; ?></td>
              <td><?php echo $school->longitude; ?></td>
              <td><input required type="radio" name="land_type" value="commercial" <?php if ($school_physical_facilities->land_type == 'commercial') {
                                                                                      echo 'checked';
                                                                                    } ?> /> Commercial <span style="margin-left: 10px;"></span>
                <input required type="radio" name="land_type" value="residential" <?php if ($school_physical_facilities->land_type == 'residential') {
                                                                                    echo 'checked';
                                                                                  } ?> /> Residential
                <br />
              </td>
            </tr>

          </table>
          <strong>Please confirm Year of Establishment</strong>
          <table class="table table-bordered">
            <tr>
              <th>Year of establisment online apply</th>
              <th>Fist Student Addmission Date</th>
              <th>First Teacher Appointment Date</th>
              <th>Rent Aggrement Date</th>
              <th>Confirm Year of establisment</th>
            </tr>
            <tr>
              <td><?php echo " " . $school->yearOfEstiblishment; ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          </table>


          <table class="table">
            <tr>
              <td>
                <table class="table table2 table-bordered">

                  <tr>
                    <th>Level</th>
                    <th>Classes</th>
                    <th>Rooms</th>
                    <th>Students</th>
                    <th>Max Fee</th>
                    <th>Publisher</th>
                  </tr>


                  <?php
                  $query = "SELECT * FROM levelofinstitute";
                  $levels = $this->db->query($query)->result();
                  foreach ($levels as $level) { ?>

                    <?php
                    $classes = $this->db->query("SELECT * FROM class 
                        WHERE class.level_id = " . $level->levelofInstituteId . "
                        order by level_id ASC, classId ASC")->result();
                    $count = 1;
                    $count2 = 1;
                    foreach ($classes  as $class) { ?>
                      <tr>
                        <?php if ($count == 1) { ?>
                          <th style="vertical-align: middle; text-align:center" rowspan="<?php echo count($classes); ?>"><?php echo $level->levelofInstituteTitle ?></th>
                        <?php
                          $count++;
                        } ?>
                        <th style=""><?php echo $class->classTitle ?></th>
                        <td></td>
                        <td style="text-align: center;"><?php $query = "SELECT SUM(`enrolled`) as enrolled  FROM `age_and_class` 
                                            WHERE class_id ='" . $class->classId . "'
                                            AND school_id = '" . $school_id . "'";
                                                        $query_result = $this->db->query($query)->result();
                                                        if ($query_result) {
                                                          $total_class_enrollment += $query_result[0]->enrolled;
                                                          echo $query_result[0]->enrolled;
                                                        }
                                                        ?></td>
                        <td></td>


                        <?php if ($count2 == 1) { ?>
                          <th style="vertical-align: middle; text-align:center" rowspan="<?php echo count($classes); ?>"></th>
                        <?php
                          $count2++;
                        } ?>
                      </tr>
                  <?php }
                  }
                  ?>
                  <tr>
                    <th></th>
                    <th style="text-align: right; ">Total</th>
                    <th>

                    </th>
                    <th style="text-align: center; "><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE  school_id = '" . $school_id . "'";
                                                      $query_result = $this->db->query($query)->result();
                                                      if ($query_result) {
                                                        $total_school_entrollment += $query_result[0]->enrolled;
                                                        echo $query_result[0]->enrolled;
                                                      }
                                                      ?></th>





                  </tr>

                </table>

              </td>
              <td>
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th style="width: 150px;">Total Class Rooms</th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Staff Rooms</th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Office</th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Total Rooms</th>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>
                        <strong> Owned </strong>

                        <span style="margin-top: 10px; display: block;"> </span>
                        <strong> Rented </strong>

                        <span id="building_rent">
                          (Monthly Rent Amount (Rs.):
                        </span> <span style="margin-top: 10px; display: block;"> </span>
                        <strong> Donated/Trusted </strong>

                        <span style="margin-top: 10px; display: block;"> </span>
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 150px;">Average Class Rooms Size (sq feet): </th>

                    </tr>
                    <tr>
                      <th>Total Area (in Marla): </th>
                    </tr>
                    <tr>
                      <th>Covered Area (in Marla):</th>
                    </tr>

                  </tbody>
                </table>
                <h5><strong class="">Whether the following facilities are available in the School?</strong></h5>
                <strong style="font-size: 15px; margin-top:5px;">Physical:</strong>
                <br>
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th>
                        Water </th>
                      <td style="width: 50px;">Yes</td>
                      <td style="width: 50px;">No</td>
                    </tr>


                    <tr>
                      <td colspan="3">
                        <strong> Toilets</strong>
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <td> Male </td>
                              <td>Female </td>
                              <td>Total </td>
                            </tr>
                            <tr>
                              <td style="height: 50px;"></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>




                    <tr>
                      <th>
                        Electricity </th>
                      <td style="width: 50px;">Yes</td>
                      <td style="width: 50px;">No</td>
                    </tr>


                    <tr>
                      <th>
                        Boundary Wall </th>
                      <td style="width: 50px;">Yes</td>
                      <td style="width: 50px;">No</td>
                    </tr>


                  </tbody>
                </table>



              </td>

              <td>

                <strong style="font-size: 15px; margin-top:5px;">Academic:</strong>
                <table class="table table-bordered">
                  <?php

                  $query = "SELECT * FROM physical_facilities_academic_meta WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                  $academics = $this->db->query($query)->result();
                  //var_dump($academics);
                  if (!empty($academics)) : ?>
                    <?php foreach ($academics as $academic) :
                      if ($academic->academicId == 2) { ?>
                        <tr>
                          <th><?php echo $academic->academicTitle; ?> </th>
                          <td>Yes</td>
                          <td>No</td>
                        </tr>
                        <tr>
                          <td colspan="3">

                            <table class="table table-bordered">

                              <?php foreach ($book_types as $library) :
                                $query = "SELECT numberOfBooks FROM school_library 
                                    WHERE `book_type_id` = '" . $library->bookTypeId . "'
                                    AND school_id = '" . $school_id . "'";
                                $library_book_total = $this->db->query($query)->result()[0]->numberOfBooks;
                              ?>
                                <tr>
                                  <th><?php echo $library->bookType; ?></th>
                                  <td style="width: 50px;"></td>
                                </tr>
                              <?php endforeach; ?>
                              <tr>
                                <th>Total Books</th>
                                <td></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <?php } else {
                        if ($academic->academicId == 4) {
                        ?>
                          <tr>
                            <th><?php echo $academic->academicTitle; ?> </th>
                            <td>Yes</td>
                            <td>No</td>
                          </tr>
                          <tr>
                            <th>Total Computer </th>
                            <td colspan="2"> </td>
                          </tr>
                          <?php } else {
                          if ($academic->academicId == 1) { ?>
                            <tr>
                              <th>
                                <?php echo $academic->academicTitle; ?>
                              </th>
                              <td>Yes</td>
                              <td>No</td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <table class="table table-bordered">
                                  <tr>
                                    <th colspan="3">
                                      For High Level only
                                    </th>
                                  </tr>
                                  <tr>
                                    <td>Combined</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                  </tr>
                                  <tr>
                                    <th colspan="3">
                                      For High Sec. level only
                                    </th>
                                  </tr>
                                  <tr>
                                    <td>Physics</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                  </tr>
                                  <tr>
                                    <td>Chemistery</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                  </tr>
                                  <tr>
                                    <td>Biology</td>
                                    <td>Yes</td>
                                    <td>No</td>
                                  </tr>
                                </table>
                            </tr>

                          <?php  } else { ?>
                            <tr>
                              <th><?php echo $academic->academicTitle; ?></th>
                              <td>Yes</td>
                              <td>No</td>
                            </tr>
                          <?php } ?>
                        <?php } ?>
                      <?php } ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <span class="text-danger">No Academic found.</span>
                  <?php endif; ?>
                </table>
              </td>
              <td>

                <?php $query = "SELECT * FROM physical_facilities_co_curricular_meta 
                  WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                $co_curriculars = $this->db->query($query)->result();
                ?>
                <?php if (!empty($co_curriculars)) { ?>
                  <strong>Co-Curricular:</strong>
                  <table class="table table-bordered">
                    <?php foreach ($co_curriculars as $co_curricular) : ?>
                      <tr>
                        <th><?php echo $co_curricular->coCurricularTitle; ?></th>
                        <td>Yes</td>
                        <td>No</td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                <?php } ?>

                <?php $query = "SELECT * FROM physical_facilities_others_meta 
                  WHERE  school_type_id like '%" . $school->school_type_id . "%'";
                $other = $this->db->query($query)->result();
                ?>
                <?php if (!empty($other)) { ?>
                  <strong>Others:</strong>
                  <table class="table table-bordered">
                    <?php foreach ($other as $oth) : ?>
                      <tr>
                        <th><?php echo $oth->otherTitle; ?></th>
                        <td>Yes</td>
                        <td>No</td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                <?php } ?>

                <strong> Head of institute contact detail</i> </strong>
                <?php
                $query = "select principal_cnic,principal,principal_contact_no FROM school WHERE schoolId = '" . $school_id . "'";
                $principal = $this->db->query($query)->row();
                ?>

                <table class="table">
                  <tr>
                    <td style="width: 10px;"> Name: </td>
                    <td> <input type="text" name="principal" value="<?php if ($principal->principal) {
                                                                      echo $principal->principal;
                                                                    } ?>" style="width: 100%;" required /></td>
                  </tr>
                  <tr>
                    <td> CNIC: </td>
                    <td> <input maxlength="15" id="principal_cnic" type="text" name="principal_cnic" value="<?php if ($principal->principal_cnic) {
                                                                                                              echo $principal->principal_cnic;
                                                                                                            } ?>" style="width: 100%;" required /></td>
                  </tr>
                  <tr>
                    <td> Contact: </td>
                    <td> <input maxlength="15" id="principal_contact_no" type="text" name="principal_contact_no" value="<?php if ($principal->principal_contact_no) {
                                                                                                                          echo $principal->principal_contact_no;
                                                                                                                        } ?>" style="width: 100%;" required /></td>
                  </tr>
                </table>


              </td>
            </tr>
          </table>

        </div>

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
  </page>
</body>

</html>