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
    /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */



  }

  .table {
    margin: 1px !important;
  }

  .box {
    border: 1px solid lightgray;
    border-radius: 10px;
    min-height: 10px;
    margin: 2px;
    padding: 5px;
    background-color: white;
  }

  .table_small>thead>tr>th,
  .table_small>tbody>tr>th,
  .table_small>tfoot>tr>th,
  .table_small>thead>tr>td,
  .table_small>tbody>tr>td,
  .table_small>tfoot>tr>td {
    padding: 1px;
    line-height: 1;
    vertical-align: top;
    font-size: 11px !important;
    /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */


  }

  .table_large>thead>tr>th,
  .table_large>tbody>tr>th,
  .table_large>tfoot>tr>th,
  .table_large>thead>tr>td,
  .table_large>tbody>tr>td,
  .table_large>tfoot>tr>td {
    padding: 5px;
    line-height: 1;
    vertical-align: top;
    font-size: 13px !important;
    /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */


  }

  .table_medium>thead>tr>th,
  .table_medium>tbody>tr>th,
  .table_medium>tfoot>tr>th,
  .table_medium>thead>tr>td,
  .table_medium>tbody>tr>td,
  .table_medium>tfoot>tr>td {
    padding: 3px;
    line-height: 1;
    vertical-align: top;
    font-size: 12px !important;
    /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */


  }

  .table-bordered>thead>tr>th,
  .table-bordered>tbody>tr>th,
  .table-bordered>tfoot>tr>th,
  .table-bordered>thead>tr>td,
  .table-bordered>tbody>tr>td,
  .table-bordered>tfoot>tr>td {
    border: 1px solid black !important;
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
              </td>
              <td>
                <small>
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
                </small>

              </td>
            </tr>

          </table>

        </div>
        <div class="col-md-12">
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

                <?php if ($school_more_info->a_o_level === "1") {
                  echo "&#10004;";
                } ?> <span style="margin-left: 3px;"></span> Yes

                <span style="margin-left: 30px;"></span>
                <?php if ($school_more_info->a_o_level === "0") {
                  echo "&#10004;";
                } ?>
                <span style="margin-left: 3px;"></span>
                No
              </td>
              <td>

                <?php
                if ($school->genderOfSchoolTitle == 'Boys') {
                  echo "&#10004;";
                } ?> <span style="margin-left: 3px;"></span> Boys <span style="margin-left: 20px;"></span>
                <?php if ($school->genderOfSchoolTitle === "Girls") {
                  echo "&#10004;";
                } ?> <span style="margin-left: 3px;"></span> Girls <span style="margin-left: 20px;"></span>
                <?php if ($school->genderOfSchoolTitle === "Co-education") {
                  echo "&#10004;";
                } ?> <span style="margin-left: 3px;"></span> Co-education



              </td>
              <td>
                <?php if ($school_physical_facilities->timing == 'morning') {
                  echo '&#10004;';
                } ?> <span style="margin-left: 3px;"></span> Morning

                <span style="margin-left: 10px;"></span>
                <?php if ($school_physical_facilities->timing == 'evening') {
                  echo '&#10004;';
                } ?> <span style="margin-left: 3px;"></span> Evening
                <span style="margin-left: 10px;"></span>
                <?php if ($school_physical_facilities->timing == 'both') {
                  echo '&#10004;';
                } ?> <span style="margin-left: 3px;"></span> Both
              </td>
            </tr>
          </table>
          <strong>Please confirm address of the school</strong>
          <table class="table table-bordered">
            <tr>
              <th style="width: 110px;">District</th>
              <th style="width: 110px;">Tehsil</th>
              <th style="width: 130px;">UC</th>
              <th style="width:300px">Address</th>
              <th style="width: 100px;">Latitude</th>
              <th style="width: 100px;">Longitude</th>
            </tr>
            <tr>
              <td><?php echo $school->districtTitle; ?></td>
              <td><?php echo $school->tehsilTitle; ?></td>
              <td><?php echo $school->ucTitle; ?></td>
              <td><?php echo $school->address; ?></td>
              <td><?php echo $school->late; ?></td>
              <td><?php echo $school->longitude; ?></td>
            </tr>
            <tr>
              <td style="height: 20px;"></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          </table>
          <br />
          <table class="table table-bordered">
            <tr>
              <th>Property Possession</th>
              <th>Land Type</th>
              <th style="width: 100px;">Total Area</th>
              <th style="width: 100px;">Covered Area</th>
            </tr>
            <tr>
              <td>
                Owned Rented: <small> Monthly Rent (Rs.):______________</small> Donated/Trusted
              </td>
              <td>
                <?php if ($school_physical_facilities->land_type == 'commercial') {
                  echo '&#10004;';
                } ?> <span style="margin-left: 3px;"></span> Commercial <span style="margin-left: 30px;"></span>
                Residential <?php if ($school_physical_facilities->land_type == 'residential') {
                              echo '&#10004;';
                            } ?>

              </td>
              <td><small>In Marla: </small></td>
              <td><small>In Marla: </small></td>
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
              <th>Suggest Session</th>
            </tr>
            <tr>
              <td><?php echo " " . $school->yearOfEstiblishment; ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          </table>
          <br />
          <table class="table">
            <td>
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Portrait of Quid-e-Azam</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Portrait of Allama Iqbal</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Waiting Area for visitor</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>

                  <tr>
                    <th>Furniture provided to all students</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Furniture provided to all staff</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Cross-ventilation in the classroom exists</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>

                  <tr>
                    <th>Notice Board exist</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Class bell exist</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>National Flag exist</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>

                  <tr>
                    <th>School Fee details displayed outside (attach pictures)</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Annual calendar displayed for each class</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>


              </table>

            </td>
            <td>
              <table class="table table-bordered">
                <tbody>

                  <tr>
                    <th>
                      Water </th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
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
                  <tr>
                    <th>Exam Hall</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Play Ground</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Play area exist</th>
                    <td style="width: 50px;">Yes</td>
                    <td style="width: 50px;">No</td>
                  </tr>
                  <tr>
                    <th>Canteen</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Hostel (For Student)</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Hostel (For Staff)</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Transport</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>First Aid</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>



                </tbody>
              </table>
            </td>
            <td>
              Registers Maintained
              <table class="table table-bordered">
                <tr>
                  <th>Admission and withdrawal </th>
                  <td>Yes</td>
                  <td>No</td>
                </tr>
                <tr>
                  <th>
                    Student Attend </th>
                  <td>Yes</td>
                  <td>No</td>
                </tr>
                <tr>
                  <th>
                    Teacher Attend: </th>
                  <td>Yes</td>
                  <td>No</td>
                </tr>
                <tr>
                  <th>
                    Teacher Salary Registers
                  </th>
                  <td>Yes</td>
                  <td>No</td>
                </tr>
                <tr>
                  <td colspan="3"><strong>Internet Facility</strong></td>
                </tr>

                <table class="table table-bordered">
                  <tr>
                    <th>Computer Facility</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Internet Facility</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                  <tr>
                    <th>Mobile 3G / 4G</th>
                    <td>Yes</td>
                    <td>No</td>
                  </tr>
                </table>

              </table>

            </td>

          </table>
          <table class="table">
            <tr>
              <td>
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th>#</th>
                      <th>Vehicle No.</th>
                      <th>Model Year</th>
                      <th>Type of Vehicle</th>
                      <th>Date of expiry of last fitness Certificate</th>
                      <th>Total Seats</th>
                    </tr>
                    <tr>
                      <th style="height: 100px;"></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>

                  </tbody>
                </table>
              </td>
              <td>

                <table class="table table-bordered">
                  <tr>
                    <td>Account Type:</td>
                    <td>
                      <span style="margin-left: 30px;"></span> Individual
                      <span style="margin-left: 30px;"></span> Designated
                      <span style="margin-left: 30px;"></span> Joint
                    </td>
                  </tr>
                  <tr>
                    <td>Bank Account No:</td>
                    <td> </td>
                  </tr>
                  <tr>
                    <td>Bank Title:</td>
                    <td> </td>
                  </tr>
                  <tr>
                    <td>Bank Branch Code:</td>
                    <td> </td>
                  </tr>
                  <tr>
                    <td>Bank Branch Address:</td>
                    <td> </td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>




          <table class="table">
            <tr>
              <td>
                <table class="table table-bordered">
                  <tr>
                    <th rowspan="2">Level</th>
                    <th rowspan="2">Classes</th>
                    <th rowspan="2">Rooms</th>
                    <th rowspan="2">Rooms Size (sq feet)</th>
                    <th colspan="2">Students</th>
                    <th rowspan="2" style="width: 80px;">Max Tuition Fee</th>
                    <th rowspan="2">Regional language</th>
                    <th rowspan="2" style="width: 200px;">Publisher's textbooks are being taught in each levels</th>

                  </tr>

                  <tr>
                    <th>Boys</th>
                    <th>Girls</th>
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
                    <th colspan="2" style="text-align:right; height: 50px;">
                      <h4>Summary</h4>
                    </th>
                    <th style=" vertical-align:bottom; text-align: center;">

                      <small style="font-size: 8px;">Total Rooms</small>
                    </th>
                    <th style=" vertical-align:bottom; text-align: center;">

                      <small style="font-size: 8px;">AVG. Size</small>
                    </th>

                    <th style=" vertical-align:bottom; text-align: center;"><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE  school_id = '" . $school_id . "'";
                                                                            $query_result = $this->db->query($query)->result();
                                                                            if ($query_result) {
                                                                              $total_school_entrollment += $query_result[0]->enrolled;
                                                                              echo $query_result[0]->enrolled;
                                                                            }
                                                                            ?>
                      <br />
                      <small style="font-size: 8px;">Boys</small>
                    </th>
                    <th style=" vertical-align:bottom; text-align: center;"><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE  school_id = '" . $school_id . "'";
                                                                            $query_result = $this->db->query($query)->result();
                                                                            if ($query_result) {
                                                                              $total_school_entrollment += $query_result[0]->enrolled;
                                                                              echo $query_result[0]->enrolled;
                                                                            }
                                                                            ?>
                      <br />
                      <small style="font-size: 8px;">Girls</small>
                    </th>

                    <th style=" vertical-align:bottom; text-align: center;">

                      <small style="font-size: 8px;">Max Tuition Fee</small>
                    </th>
                    <th colspan="2"></th>


                  </tr>

                </table>
                <table class="table">
                  <tr>
                    <th>Other Rooms</th>
                    <th colspan="2">Science Lab <span style="margin: 10px;"> Yes</span>
                      <span style="margin: 10px;"> No</span>
                    </th>

                  </tr>
                  <tr>
                    <td>
                      <table class="table table-bordered">
                        <tbody>

                          <tr>
                            <th style="width: 150px;">Staff Rooms</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th>Principal Office</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th>Account Assistant Office</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th>Reception</th>
                            <td></td>
                          </tr>

                        </tbody>
                      </table>

                      <strong>Toilets</strong>
                      <table class="table table-bordered">
                        <tbody>

                          <tr>
                            <th>Male </th>
                            <td style="width: 100px;"></td>
                          </tr>
                          <tr>
                            <th>Female </th>
                            <td></td>
                          </tr>
                          <tr>
                            <th>Total </th>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>

                    </td>

                    <td colspan="2">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th>#</th>
                            <th colspan="3">HIGH LEVEL ONLY</th>
                            <td>Equipment:</td>
                          </tr>
                          <tr>
                            <td>1.</td>
                            <th>Science Lab</th>
                            <td>Yes</td>
                            <td>No</td>
                            <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 30px;"></span> (ii) Deficient</th>
                          </tr>

                        </tbody>
                      </table>
                      <br />
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th>#</th>
                            <th colspan="3">HIGH Sec. LEVEL ONLY</th>
                            <td>Equipment:</td>
                          </tr>

                          <tr>
                            <td>1.</td>
                            <th>Physics</th>
                            <td>Yes</td>
                            <td>No</td>
                            <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 30px;"></span> (ii) Deficient</th>

                          </tr>
                          <tr>
                            <td>2.</td>
                            <th>Chemistery</th>
                            <td>Yes</td>
                            <td>No</td>
                            <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 30px;"></span> (ii) Deficient</th>

                          </tr>
                          <tr>
                            <td>3.</td>
                            <th>Biology</th>
                            <td>Yes</td>
                            <td>No</td>
                            <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 30px;"></span> (ii) Deficient</th>

                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <table class="table table-bordered">
                        <tr>
                          <th>Computer Lab </th>
                          <td>Yes</td>
                          <td>No</td>
                        </tr>
                        <tr>
                          <th>Total Computers </th>
                          <td colspan="2"> </td>
                        </tr>
                        <tr>
                          <th>Working Computers</th>
                          <td colspan="2"> </td>
                        </tr>
                      </table>

                    </td>
                    <td>
                      <div class="box">
                        <strong>Library</strong>
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <th>General Knowledge Books</th>
                              <th>History Books</th>
                              <th>Islamic Books</th>
                              <th>Other Books</th>
                              <th>Total Books</th>
                            </tr>

                            <tr>
                              <td style="height: 30px;"></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </td>
                  </tr>

                </table>


              </td>

            </tr>

          </table>




        </div>

        <div class="col-md-12">




          <table class="table">
            <tr>
              <td>
                <strong>High Level Institute Teachers</strong>
                <table class="table table_medium  table-bordered">
                  <tr>
                    <th>#</th>
                    <th style="width: 130px;">Subject</th>
                    <th style="width: 200px;">Teacher Name</th>
                    <th>Qualification</th>
                    <th>Prof. Degree</th>
                  </tr>
                  <?php
                  $count = 1;
                  $subjects = array("Bio-Chem", "Math-Phy", "IT", "", "", "", "", "", "");
                  foreach ($subjects as $subject) {
                  ?>
                    <tr>
                      <th><?php echo $count++; ?></th>
                      <td>SST <?php echo $subject; ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <?php } ?>
                </table>
              </td>
              <td>
                <strong>High Sec. level Institute Teachers</strong>
                <table class="table table_medium table-bordered">
                  <tr>
                    <th>#</th>
                    <th style="width: 130px;">Subject</th>
                    <th style="width: 200px;">Teacher Name</th>
                    <th>Qualification</th>
                    <th>Prof. Degree</th>
                  </tr>
                  <?php
                  $count = 1;
                  $subjects = array("Urdu", "English", "Math", "Biology", "Physic", "Chemistry", "IT", "Pak.Study", "Islamiyat");
                  foreach ($subjects as $subject) {
                  ?>
                    <tr>
                      <th><?php echo $count++; ?></th>
                      <td>SS <?php echo $subject; ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <?php } ?>
                </table>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td>
                <strong>Staff informaiton</strong>

                <table class="table table_large table-bordered">
                  <thead>

                    <tr>
                      <th>Category</th>
                      <th>Male</th>
                      <th>Female</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Teaching Staff</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Non-Teaching Staff</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Total</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td>
                <strong>Teaching Staff Qualification</strong>
                <table class="table table_large table-bordered">
                  <thead>
                    <tr>
                      <th>Education </th>
                      <th>Qualification</th>
                      <th>Male</th>
                      <th>Female</th>
                      <th>Total</th>
                    </tr>
                    <tr>
                      <th>12 Years</th>
                      <th>FA / FSc</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th>14 Years</th>
                      <th>BA / BSc</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th rowspan="2">16 Years</th>
                      <th>Graduation BS 4 Years</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Post Graduation MA / MSc</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <th>18 Years</th>
                      <th>MS / M.Phil</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <th>PhD</th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    </tbody>
                </table>
              </td>
            </tr>
          </table>

          <table class="table table_large ">
            <tr>
              <td>
                <strong>Head of the school institute</strong>
                <table class="table table_large table-bordered">
                  <tr>
                    <th style="width: 30px;">Name</th>
                    <td></td>
                  </tr>
                  <tr>
                    <th>CNIC</th>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Contact</th>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <table class="table">
                        <tr>
                          <td style="vertical-align: bottom; height: 60px;">

                            ______________<br />

                            <small> Signature</small>
                          </td>
                          <td style="vertical-align: bottom; height: 60px;">
                            _____________<br />
                            <small> Stamp of school </small>
                          </td>
                          <td style="vertical-align: bottom; height: 60px;">
                            _____________<br />
                            <small>Visit Date</small>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>


              </td>
              <td style="width: 60%;">
                <strong>Detail of Board of Direcotors / Owners</strong>
                <table class="table table_large table-bordered">
                  <tr>
                    <th>#</th>
                    <th>Owner Name</th>
                    <th>Father Name</th>
                    <th>Owner CNIC</th>
                  </tr>
                  <tr>
                    <td>1.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>2.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>3.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                </table>

              </td>
            </tr>
          </table>

          <h4>Recommendation</h4>
          <table class="table table_large table-bordered">
            <tr>
              <th></th>
              <th>Primary <br />(PG to 5th)</th>
              <th>Middle <br />(6th to 8th)</th>
              <th>High <br />(9th to 10th)</th>
              <th>High Sec <br />(11th to 2nd)</th>
              <th style="width: 200px;">Officer Signature</th>
              <th style="width: 200px;">Official Signature</th>
            </tr>
            <tr>
              <th style="height: 50px;">Not Recommended</th>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td rowspan="2">
                Visit Date: __________________<br />
                <br />
                Name: _____________________<br />
                <br />
                <br />
                <br />
                <br />
                Signature: ________________
              </td>
              <td rowspan="2">
                Visit Date: __________________<br />
                <br />
                Name: _____________________<br />
                <br />
                <br />
                <br />
                <br />
                Signature: ________________
              </td>
            </tr>
            <tr>
              <th style="height: 50px;">Recommended</th>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <small>Signature</small>
              </td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>
                <div class="box" style="height: 200px;">
                  If the institute is not recommended, kindly provide a comprehensive explanation outlining the specific reasons for the non-recommendation, in accordance with regulation, norms, and standards.
                </div>
              </td>
            </tr>
          </table>

        </div>







      </section>
      <!-- /.content -->
      <div class="clearfix"></div>
    </div>
  </page>
</body>

</html>