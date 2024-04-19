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
              <th>land Type</th>
              <th style="width: 100px;">Total Area</th>
              <th style="width: 100px;">Covered Area</th>
            </tr>
            <tr>
              <td>
                Owned
                <br />
                Rented:Monthly Rent <small>(Rs.):_________</small>
                <br />
                Donated/Trusted
              </td>
              <td>
                Commercial <?php if ($school_physical_facilities->land_type == 'commercial') {
                              echo '&#10004;';
                            } ?> <br />
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
              <tr>
                <td colspan="3">
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

                  </table>
                </td>
              </tr>


            </tbody>
          </table>


          <table class="table">
            <tr>
              <td>
                <table class="table table2 table-bordered">
                  <tr>
                    <th rowspan="2">Level</th>
                    <th rowspan="2">Classes</th>
                    <th rowspan="2">Rooms</th>
                    <th rowspan="2">Rooms Size (sq feet)</th>
                    <th colspan="2">Students</th>
                    <th rowspan="2" style="width: 80px;">Max Fee</th>
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
                    <th style="height: 50px;"></th>
                    <th style="text-align: right; "></th>
                    <th>
                    <th></th>

                    </th>
                    <th style="text-align: center; "><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE  school_id = '" . $school_id . "'";
                                                      $query_result = $this->db->query($query)->result();
                                                      if ($query_result) {
                                                        $total_school_entrollment += $query_result[0]->enrolled;
                                                        echo $query_result[0]->enrolled;
                                                      }
                                                      ?></th>


                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>


                  </tr>

                </table>
                <table class="table">
                  <tr>
                    <th>Rooms</th>
                    <th colspan="2">Science Lab <span style="margin: 10px;"> Yes</span>
                      <span style="margin: 10px;"> No</span>
                    </th>

                  </tr>
                  <tr>
                    <td>
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th>Total Class Rooms</th>
                            <td style="width: 50px;"></td>
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
                          <tr>
                            <th>Principal Office</th>
                            <td style="width: 50px;"></td>
                          </tr>
                          <tr>
                            <th>Account Assistant Office</th>
                            <td style="width: 50px;"></td>
                          </tr>

                          <tr>
                            <th>Reception</th>
                            <td style="width: 50px;"></td>
                          </tr>

                        </tbody>
                      </table>
                    </td>

                    <td colspan="2">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th colspan="3">HIGH LEVEL ONLY</th>
                            <td>Equipment:</td>
                          </tr>
                          <tr>
                            <td>Science Lab</td>
                            <td>Yes</td>
                            <td>No</td>
                            <td> (i) *Sufficient (ii) Deficient</td>
                          </tr>

                        </tbody>
                      </table>
                      <br />
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th colspan="3">HIGH Sec. LEVEL ONLY</th>
                            <td>Equipment:</td>
                          </tr>

                          <tr>

                            <td>Physics</td>
                            <td>Yes</td>
                            <td>No</td>
                            <td> (i) *Sufficient (ii) Deficient</td>
                          </tr>
                          <tr>
                            <td>Chemistery</td>
                            <td>Yes</td>
                            <td>No</td>
                            <td>(i) *Sufficient (ii) Deficient</td>
                          </tr>
                          <tr>
                            <td>Biology</td>
                            <td>Yes</td>
                            <td>No</td>
                            <td>(i) *Sufficient (ii) Deficient</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <div class="box">
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
                      </div>
                    </td>
                    <td>
                      <div class="box">
                        <strong>Computer Lab</strong>
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
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
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
                <table class="table table_medium  table-bordered">
                  <tr>
                    <th>#</th>
                    <th style="width: 120px;">Subject</th>
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
                      <th>SST <?php echo $subject; ?></th>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <?php } ?>
                </table>
              </td>
              <td>
                <table class="table table_medium table-bordered">
                  <tr>
                    <th>#</th>
                    <th style="width: 110px;">Subject</th>
                    <th style="width: 200px;">Teacher Name</th>
                    <th>Qualification</th>
                    <th>Prof. Degree</th>
                  </tr>
                  <?php
                  $count = 1;
                  $subjects = array("Urdu", "English", "Math", "Biology", "Physic", "Chemistry", "Computer Science", "Pakistan Study", "Islamiyat");
                  foreach ($subjects as $subject) {
                  ?>
                    <tr>
                      <th><?php echo $count++; ?></th>
                      <th>SS <?php echo $subject; ?></th>
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
                <h4>Staff informaiton</h4>

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
                <h4>Teaching Staff Qualification</h4>
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
                <h4>Head of the school institute</h4>
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
                </table>
              </td>
              <td>
                <h4>Detail of Board of Direcotors / Owners</h4>
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
              <th>Primary (PG to 5th Class)</th>
              <th>Middle (6th Class to 8th Class)</th>
              <th>High (9th Class to 10th Class)</th>
              <th>High Sec (11th Class to 2nd Class)</th>
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