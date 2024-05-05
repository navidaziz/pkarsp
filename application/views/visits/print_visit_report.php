<!DOCTYPE html>
<html lang="en">

<head>
  <title>PSRA Visit Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 5px;
      line-height: 1;
      vertical-align: top;
      font-size: 11px !important;
      color: black;
      margin: 0px !important;
    }

    .table_small>thead>tr>th,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>tbody>tr>td,
    .table_small>tfoot>tr>td {
      padding: 2px;
      line-height: 1;
      vertical-align: top;
      border-top: 1px solid #ddd;
      font-size: 10px !important;
      color: black;
      margin: 0px !important;
    }

    .table_large>thead>tr>th,
    .table_large>tbody>tr>th,
    .table_large>tfoot>tr>th,
    .table_large>thead>tr>td,
    .table_large>tbody>tr>td,
    .table_large>tfoot>tr>td {
      padding: 2px;
      line-height: 1.9;
      vertical-align: top;
      border-top: 1px solid #ddd;
      font-size: 10px !important;
      color: black;
      margin: 0px !important;
    }

    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
      border: 1px solid black !important;
    }



    .table {
      margin: 1px !important;
    }

    @media print {
      body {
        counter-reset: page;
      }


      footer {
        display: block;
        position: fixed;
        bottom: 0;
        width: 100%;

      }

      @media print {
        .pagebreak {
          clear: both;
          page-break-after: always;
        }
      }

    }

    h4 {
      font-size: 14px;
      font-weight: bold;
      margin: 1px;
      padding: 1px;
    }
  </style>

</head>

<body>
  <div class="container">
    <table class="table">
      <tr>
        <td>
          <h3>PSRA Visit Report</h3>
          <h5 style="text-transform: uppercase;"><?php echo @$school->schoolName; ?></h5>
          <h5>Registered Level:
            <?php
            //last renewal
            $query = "SELECT reg_type_id, upgradation_levels, level_of_school_id,
                                        `primary`, `middle`, `high`, `high_sec`,
                                        l.levelofInstituteTitle 
                                        FROM school 
                                        INNER JOIN levelofinstitute as l ON(l.levelofInstituteId=school.level_of_school_id)
                                        WHERE schools_id ='" . $school->schools_id . "' 
                                        AND status=1;";
            $last_renewal = $this->db->query($query)->row();
            $renewal_issued = array();
            $renewal_issued[$last_renewal->levelofInstituteTitle] = $last_renewal->levelofInstituteTitle;
            if ($last_renewal->primary == 1) {
              $renewal_issued['Primary'] = 'Primary';
            }
            if ($last_renewal->middle == 1) {
              $renewal_issued['Middle'] = 'Middle';
            }
            if ($last_renewal->high == 1) {
              $renewal_issued['High'] = 'High';
            }
            if ($last_renewal->high_sec == 1) {
              $renewal_issued['Higher Secondary'] = 'Higher Secondary';
            }
            if ($last_renewal->academy == 1) {
              $renewal_issued['Academy'] = 'Academy';
            }

            echo implode(", ", $renewal_issued);




            ?>

          </h5>
          <h5> Visit for <strong><?php echo @$session->regTypeTitle; ?>

              (
              <?php
              $visit_level_for = array();
              if ($input->primary_l == 1) {
                $visit_level_for['Primary'] = 'Primary';
              }
              if ($input->middle_l == 1) {
                $visit_level_for['Middle'] = 'Middle';
              }
              if ($input->high_l == 1) {
                $visit_level_for['High'] = 'High';
              }
              if ($input->high_sec_l == 1) {
                $visit_level_for['Higher Secondary'] = 'Higher Secondary';
              }
              if ($input->academy_l == 1) {
                $visit_level_for['Academy'] = 'Academy';
              }

              echo implode(", ", $visit_level_for); ?>
              )

              for session <?php echo $session->sessionYearTitle; ?></strong>
          </h5>
          <?php if ($school->biseRegister or $school->biseregistrationNumber) { ?>
            BISE REG. <strong><?php echo $school->biseRegister; ?></strong> -
            BISE REG. No. <strong><?php echo $school->biseregistrationNumber; ?></strong>
          <?php } ?>
        </td>
        <td>
          <h6 style="line-height: 16px;">
            School Id # <?php echo $school->schools_id; ?> <br />
            <?php if ($school->registrationNumber != 0) : ?>
              <?php echo "Registration # " . @$school->registrationNumber; ?><br />
            <?php endif; ?>

            Visit ID: <?php echo $input->visit_id ?><br />
            Session Year: <?php echo $session->sessionYearTitle; ?><br />
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
            <?php
            $query = "SELECT telePhoneNumber, schoolMobileNumber FROM schools WHERE schoolId = '" . $school->schools_id . "'";
            $contact = $this->db->query($query)->row();
            ?>
            Contact: <?php echo $contact->telePhoneNumber; ?> <br />
            <?php echo $contact->schoolMobileNumber; ?>

          </h6>


        </td>
      </tr>

    </table>


    <table style="width: 100%; margin-top: 3px; margin-bottom: 10px;">

      <tbody>

        <table class="table table_large ">
          <tr>
            <td style="width: 30%;">
              <?php
              $query = "SELECT principal_cnic,
                                   principal,
                                   principal_contact_no 
                            FROM school 
                            WHERE schoolId = '" . $school_id . "'";
              $principal = $this->db->query($query)->row();
              ?>
              <strong>(Principal / Director Info)</strong>
              <table class="table table_large ">
                <tr>
                  <td> Name: </td>
                  <td><?php echo $principal->principal; ?></td>
                </tr>
                <tr>
                  <td> CNIC: </td>
                  <td><?php echo $principal->principal_cnic; ?></td>
                </tr>
                <tr>
                  <td> Contact No: </td>
                  <td> <?php echo $principal->principal_contact_no; ?> </td>
                </tr>

              </table>


            </td>
            <td>
              <strong>Detail of Owner / Owners </strong>
              <?php
              $all_owners = array();
              $query = "SELECT u.userTitle as owner_name,
                               u.cnic as owner_cnic,
                               u.contactNumber as owner_contact_no FROM `schools` as s 
                        INNER JOIN users as u ON(u.userId = s.owner_id)
                        WHERE s.schoolId = '" . $school->schools_id . "'";
              $owner = $this->db->query($query)->row();
              $all_owners[$owner->owner_cnic] = $owner;
              $query = "SELECT * FROM `school_owners` WHERE school_id = '" . $school->schools_id . "'";
              $owners = $this->db->query($query)->result();
              if ($owners) {
                foreach ($owners as $owner) {
                  $all_owners[$owner->owner_cnic] = $owner;
                }
              }

              ?>
              <table class="table table_large ">
                <tr>
                  <th>#</th>
                  <th>Owner CNIC</th>
                  <th>Owner Name</th>
                  <th>Father Name</th>
                  <th>Contact No.</th>
                </tr>
                <?php
                $count = 1;
                foreach ($all_owners as $owner_cnic => $owner) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $owner_cnic; ?></td>
                    <td><?php echo $owner->owner_name; ?></td>
                    <td><?php echo $owner->owner_father_name; ?></td>
                    <td><?php echo $owner->owner_contact_no; ?></td>
                  </tr>
                <?php } ?>
                <?php for ($i = $count; $i <= 3; $i++) { ?>
                  <tr>
                    <td><?php echo $i; ?>.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                <?php } ?>


              </table>

            </td>
          </tr>
        </table>
        <table class="table table-bordered">
          <tr style="text-align: center;">

            <th>O Level and A level</th>
            <th>Gender of Education</th>
            <th>Institute Timing</th>

            <th>Property Possession</th>
            <th>Land Type</th>
            <th>Total Area</th>
            <th>Covered Area</th>
          </tr>
          <tr style="text-align: center;">
            <td><?php echo $input->o_a_levels; ?></td>
            <td><?php echo $input->gender_of_edu; ?></td>
            <td><?php echo $input->timing; ?></td>
            <td>
              <?php echo $input->property_posession;
              if ($input->property_posession == 'Rented') {
                echo 'Rs: ' . $input->rent_amount . ' Per/Month';
              }
              ?>
            </td>
            <td><?php echo $input->land_type; ?></td>

            <td><?php echo $input->covered_area; ?> Marla</td>
            <td><?php echo $input->total_area; ?> Marla</td>
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
            <th style="width: 100px;">Altitude</th>
          </tr>
          <tr>
            <td style="height: 20px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $input->latitude; ?></td>
            <td><?php echo $input->longitude; ?></td>
            <td><?php echo $input->altitude; ?></td>
          </tr>

        </table>
        <br />
        <table class="table table-bordered">
          <tr>

          </tr>
          <tr>

          </tr>

        </table>
        <strong><i><small>(Only for New Registration)</small></i> Please confirm Year of Establishment</strong>
        <table class="table table-bordered">
          <tr>
            <th>Y.of.Estb.(Online Apply)</th>
            <th>First Student Enrollment Date</th>
            <th>First Teacher Appointment Date</th>
            <th>Rent Aggrement Date</th>
            <th>Confirm Year of Establishment</th>

          </tr>
          <tr>
            <td><?php echo $school->yearOfEstiblishment; ?></td>
            <td><?php echo $input->first_enrollement_date; ?></td>
            <td><?php echo $input->first_teacher_appointment_date; ?></td>
            <td><?php echo $input->rent_aggrement_date; ?></td>
            <td><?php echo $input->year_of_establisment; ?></td>

          </tr>

        </table>
        <br />
        <table class="table">
          <td>
            <table class="table  table-bordered">

              <tr>
                <td>Portrait of Quaid-e-Azam</td>
                <td><?php echo $input->portrait_quaid; ?></td>
              </tr>
              <tr>
                <td>Portrait of Allama Iqbal</td>
                <td><?php echo $input->portrait_iqbal; ?></td>
              </tr>
              <tr>
                <td>Furnitures Provided to All Students</td>
                <td><?php echo $input->student_furnitures; ?></td>
              </tr>
              <tr>
                <td>Furnitures Provided to All Staff</td>
                <td><?php echo $input->staff_furnitures; ?></td>
              </tr>
              <tr>
                <td>Cross Ventilation in class rooms</td>
                <td><?php echo $input->cross_ventilation; ?></td>
              </tr>
              <tr>
                <td>Notice board</td>
                <td><?php echo $input->notice_board; ?></td>
              </tr>
              <tr>
                <td>Class Bell Exist</td>
                <td><?php echo $input->class_bell; ?></td>
              </tr>
              <tr>
                <td>National Flag Exist</td>
                <td><?php echo $input->national_flag; ?></td>
              </tr>
              <tr>
                <td>Fee Details Displayed outside</td>
                <td><?php echo $input->fee_displayed; ?></td>
              </tr>
              <tr>
                <td>Annual Calendar Displayed for each class</td>
                <td><?php echo $input->annual_displayed; ?></td>
              </tr>

            </table>
          </td>
          <td>
            <table class="table  table-bordered">
              <tr>
                <td>Water</td>
                <td><?php echo $input->water; ?></td>
              </tr>
              <tr>
                <td>Electricity</td>
                <td><?php echo $input->electricity; ?></td>
              </tr>

              <tr>
                <td>Boundary Wall</td>
                <td><?php echo $input->boundary_wall; ?></td>
              </tr>
              <tr>
                <td>Exam Hall</td>
                <td><?php echo $input->exam_hall; ?></td>
              </tr>
              <tr>
                <td>Play Ground</td>
                <td><?php echo $input->play_ground; ?></td>
              </tr>
              <tr>
                <td>Play Area</td>
                <td><?php echo $input->play_area; ?></td>
              </tr>
              <tr>
                <td>Canteen</td>
                <td><?php echo $input->canteen; ?></td>
              </tr>
              <tr>
                <td>Students Hostel</td>
                <td><?php echo $input->stud_hostel; ?></td>
              </tr>
              <tr>
                <td>Staff Hostel</td>
                <td><?php echo $input->staff_hostel; ?></td>
              </tr>
              <tr>
                <td>Transport</td>
                <td><?php echo $input->transport; ?></td>
              </tr>
              <tr>
                <td>First Aid</td>
                <td><?php echo $input->first_aid; ?></td>
              </tr>

            </table>

          </td>
          <td>

            <strong>Registers Maintained</strong>
            <table class="table table-bordered">
              <tr>
                <td>Admi. / Withdrawal Reg.</td>
                <td><?php echo $input->admi_withdreal_reg; ?></td>
              </tr>

              <tr>
                <td>Stud. Attendance Reg.</td>
                <td><?php echo $input->stu_attend_reg; ?></td>
              </tr>
              <tr>
                <td>Students Fee Reg.</td>
                <td><?php echo $input->stu_fee_reg; ?></td>
              </tr>
              <tr>
                <td>Teach. Attendance Reg.</td>
                <td><?php echo $input->tecah_attend_reg; ?></td>
              </tr>
              <tr>
                <td>Teachers Salary Reg.</td>
                <td><?php echo $input->tecah_salary_reg; ?></td>
              </tr>

            </table>

            <br />


            <strong>IT Facility In School</strong>
            <table class="table table-bordered">
              <tr>
                <td>Computer Availability</td>
                <td><?php echo $input->computer_available; ?></td>
              </tr>
              <tr>
                <td>Internet / DSL Connection</td>
                <td><?php echo $input->internet_connection; ?></td>
              </tr>
              <tr>
                <td>Mobile 3G / 4G Access</td>
                <td><?php echo $input->mobile_connectivity; ?></td>
              </tr>

            </table>
            <br />
            <strong>Others</strong>
            <table class="table table-bordered">
              <tr>
                <td>Shared building for Madrasa and School</td>
                <td><?php echo $input->mardrasa; ?></td>
              </tr>
              <tr>
                <td>Tuition Academy within the school</td>
                <td><?php echo $input->academy; ?></td>
              </tr>
            </table>

          </td>

        </table>


        <table class="table">
          <tr>
            <td style="width:52%">
              <strong>(If transportation is available) List of Institutional Vehicles</strong>

              <table class="table table_small table-bordered">
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
                    <th style="height: 70px;"></th>
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
              <strong>Institute Bank Account <span style="margin-left: 10px;"></span> Yes <span style="margin-left: 10px;"></span> No</strong>
              <table class="table table_small table-bordered">
                <tr>
                  <td>Account Type:</td>
                  <td>
                    <span style="margin-left: 2px;"></span> 1. Individual
                    <span style="margin-left: 10px;"></span> 2. Designated
                    <span style="margin-left: 10px;"></span> 3. Joint
                  </td>
                </tr>
                <tr>
                  <th>Bank Account No:</th>
                  <td> </td>
                </tr>
                <tr>
                  <th>Bank Title:</th>
                  <td> </td>
                </tr>
                <tr>
                  <th>Bank Branch Code:</th>
                  <td> </td>
                </tr>
                <tr>
                  <th>Bank Branch Address:</th>
                  <td> </td>
                </tr>
              </table>

            </td>
          </tr>
        </table>
        <div class="pagebreak"> </div>
        <table class="table">
          <tr>
            <td>
              <table class="table table_small table-bordered ">
                <tr>
                  <td colspan="2"><strong>Section-F: SECURITY MEASURES</strong></td>
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
                        <td><b>Security Personnel (In Number)</b></td>
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
              <table class="table table_small table-bordered">
                <tr>
                  <td colspan="2">
                    <strong>Section-G: HAZARDS WITH ASSOCIATED RISKS</strong>
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

        </table>


        <style>
          .figure-caption {
            font-size: 12px;
            font-weight: bold;
            color: black;
            text-align: left;
            display: block;

          }
        </style>

        <div class="row">
          <?php if ($input->picture_1 != NULL) { ?>
            <div class="col-xs-4">
              <img style="height: 200px; width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->picture_1; ?>" />
              <small class="text-right"><i>Officials With Institute Signboard</i></small>
            </div>
          <?php } ?>

          <?php if ($input->high_lab_image != NULL) { ?>
            <div class="col-xs-4">
              <img style="height: 200px; width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->high_lab_image; ?>" />
              <small class="text-right"><i>High School Lab Image</i></small>
            </div>
          <?php } ?>

          <?php if ($input->physics_lab_image != NULL) { ?>
            <div class="col-xs-4">
              <img style="height: 200px; width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->physics_lab_image; ?>" />
              <small class="text-right"><i>Higher Secondary Physics Lab Image</i></small>
            </div>
          <?php } ?>

          <?php if ($input->biology_lab_image != NULL) { ?>
            <div class="col-xs-4">
              <img style="height: 200px; width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->biology_lab_image; ?>" />
              <small class="text-right"><i>Higher Secondary Biology Lab Image</i></small>
            </div>
          <?php } ?>

          <?php if ($input->chemistry_lab_image != NULL) { ?>
            <div class="col-xs-4">
              <img style="height: 200px; width:100%; border:1px solid white; border-radius:5px" src="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $input->chemistry_lab_image; ?>" />
              <small class="text-right"><i>Higher Sec. Chemistry Lab Image</i></small>
            </div>
          <?php } ?>
        </div>

        <div class="pagebreak"> </div>
        <table class="table">
          <tr>
            <td>
              <table class="table table-bordered">
                <tr>
                  <th rowspan="2">Level</th>
                  <th rowspan="2">#</th>
                  <th rowspan="2" style="width: 100px;">Classes</th>
                  <th rowspan="2">Rooms (In Number)</th>
                  <th rowspan="2">Rooms Size (sq feet)</th>
                  <th colspan="3">Students</th>
                  <th rowspan="2">Max Fee</th>
                  <th rowspan="2">Regional language</th>
                </tr>
                <tr>
                  <th>Boys</th>
                  <th>Girls</th>
                  <th>Total</th>
                </tr>

                <?php
                $levels = NULL;
                if ($input->primary_l == 1) {
                  $levels[] = 1;
                }

                if ($input->middle_l == 1) {
                  $levels[] = 2;
                }

                if ($input->high_l == 1) {
                  $levels[] = 3;
                }

                if ($input->high_sec_l == 1) {
                  $levels[] = 4;
                }

                if ($input->academy_l == 1) {
                  $levels[] = 5;
                }
                $o_a_levels = 0;
                if ($input->o_a_levels == 'No') {
                  $o_a_levels = '16,17,18,19,20';
                }
                $rooms = 1;
                $query = "SELECT * FROM levelofinstitute WHERE levelofInstituteId IN(" . implode(', ', $levels) . ")";
                $levels = $this->db->query($query)->result();
                foreach ($levels as $level) {
                  $classes = $this->db->query("SELECT * FROM class 
                    WHERE class.level_id = " . $level->levelofInstituteId . "
                    AND classId NOT IN (" . $o_a_levels . ")
                    order by level_id ASC, classId ASC")->result();
                  $count = 1;

                  foreach ($classes  as $class) {

                    $query = "SELECT * FROM visit_details 
                                WHERE visit_id ='" . $visit_id . "'
                                AND school_id ='" . $school_id . "' 
                                AND schools_id ='" . $schools_id . "'
                                AND class_id = '" . $class->classId . "'";
                    $class_detail = $this->db->query($query)->row();
                ?>

                    <tr>
                      <?php if ($count == 1) { ?>
                        <th style="vertical-align: middle; text-align:center" rowspan="<?php echo count($classes); ?>"><?php echo $level->levelofInstituteTitle ?></th>
                      <?php
                        $count++;
                      } ?>
                      <th><?php echo $rooms++; ?></th>
                      <th><?php echo $class->classTitle ?></th>
                      <td>
                        <?php echo $class_detail->rooms; ?>
                      </td>
                      <td></td>
                      <td>
                        <?php echo $class_detail->boys; ?>
                      </td>
                      <td>
                        <?php echo $class_detail->girls; ?>
                      </td>
                      <td>
                        <?php echo $class_detail->boys + $class_detail->girls; ?>
                      </td>
                      <td>
                        <?php echo $class_detail->max_fee; ?>
                      </td>

                      <td></td>
                    </tr>
                  <?php } ?>
                  <?php ?>

                <?php } ?>
                <?php
                $query = "SELECT SUM(rooms) as rooms,
                SUM(boys) as boys,
                SUM(girls) as girls,
                MAX(max_fee) as max_fee
                FROM visit_details 
                 WHERE visit_id ='" . $visit_id . "'
                 AND school_id ='" . $school_id . "' 
                 AND schools_id ='" . $schools_id . "'
                 AND class_id = '" . $class->classId . "'";
                $class_summary = $this->db->query($query)->row();
                ?>
                <tr>

                  <th colspan="3" style="text-align: right;">
                    <h4> Total Rooms</h4>
                  </th>
                  <td>
                    <h4> <?php echo $class_summary->rooms; ?></h4>
                  </td>
                  <td></td>
                  <td>
                    <h4> <?php echo $class_summary->boys; ?></h4>
                  </td>
                  <td>
                    <h4> <?php echo $class_summary->girls; ?></h4>
                  </td>
                  <td>
                    <h4> <?php echo $class_summary->boys + $class_summary->girls; ?></h4>
                  </td>
                  <td>
                    <h4> <?php echo $class_summary->max_fee; ?></h4>
                  </td>
                  <td></td>
                </tr>
              </table>

              <table class="table">
                <tr>
                  <td>
                    <h4>Rooms</h4>
                    <table class="table table-bordered">
                      <tr>
                        <th>Staff Rooms (M)</th>
                        <td><?php echo $input->male_staff_rooms; ?></td>
                      </tr>
                      <tr>
                        <th>Staff Rooms (F)</th>
                        <td><?php echo $input->female_staff_rooms; ?></td>
                      </tr>
                      <tr>
                        <th>Principal Office</th>
                        <td><?php echo $input->principal_office; ?></td>
                      </tr>
                      <tr>
                        <th>Account Office</th>
                        <td><?php echo $input->account_office; ?></td>
                      </tr>
                      <tr>
                        <th>Reception</th>
                        <td><?php echo $input->reception; ?></td>
                      </tr>
                      <tr>
                        <th>Waiting Area</th>
                        <td><?php echo $input->waiting_area; ?></td>
                      </tr>
                    </table>
                    <h4>Toilets</h4>
                    <table class="table table-bordered">
                      <tr>
                        <th>Males</th>
                        <th>Females</th>
                        <th>Total</th>
                      </tr>
                      <tr>
                        <td><?php echo $input->male_washrooms; ?></td>
                        <td><?php echo $input->female_washrooms; ?></td>
                        <td><?php echo $input->male_washrooms + $input->female_washrooms; ?></td>
                      </tr>
                    </table>


                  </td>

                  <td colspan="2">

                    <?php if ($input->high_l == 1 && $input->high_sec_l == 0) { ?>
                      <h4>High Level Science Lab</h4>
                    <?php } ?>
                    <?php if ($input->high_sec_l == 1) { ?>
                      <h4>High Sec. Science Labs</h4>
                    <?php } ?>
                    <table class="table table-bordered">
                      <tr>
                        <th colspan="2">Labs</th>
                        <th>Equipments</th>
                      </tr>
                      <?php if ($input->high_l == 1 && $input->high_sec_l == 0) { ?>
                        <tr>
                          <th>High Level</th>
                          <td><?php echo $input->high_level_lab; ?></td>
                          <td><?php echo ($input->high_level_lab == 'Yes') ? $input->high_level_lab_equipment : 'N/A'; ?></td>
                        </tr>
                      <?php } ?>
                      <?php if ($input->high_sec_l == 1) { ?>
                        <tr>
                          <th>Physics Lab</th>
                          <td><?php echo $input->physics_lab; ?></td>
                          <td><?php echo ($input->physics_lab == 'Yes') ? $input->physics_lab_equipment : 'N/A'; ?></td>
                        </tr>
                        <tr>
                          <th>Biology Lab</th>
                          <td><?php echo $input->biology_lab; ?>
                          </td>
                          <td><?php echo ($input->biology_lab == 'Yes') ? $input->biology_lab_equipment : 'N/A'; ?></td>
                        </tr>
                        <tr>
                          <th>Chemistry Lab</th>
                          <td><?php echo $input->chemistry_lab; ?></td>
                          <td><?php echo ($input->chemistry_lab == 'Yes') ? $input->chemistry_lab_equipment : 'N/A'; ?></td>
                        </tr>
                      <?php } ?>
                    </table>

                    <h4>Computer Lab</h4>
                    <table class="table table-bordered">
                      <tr>

                        <th>Computer Lab</th>
                        <td><?php echo $input->computer_lab; ?></td>
                        <td><?php echo $input->total_working_computers + $input->total_not_working_computers; ?></td>
                      </tr>
                    </table>
                    <h4>Library</h4>

                    <table class="table table-bordered">
                      <tr>
                        <th>Library</th>
                        <td><?php echo $input->library; ?></td>
                      </tr>
                      <?php if ($input->library == 'Yes') { ?>
                        <tr>
                          <th>Library Books Total</th>
                          <td><?php echo $input->library_books; ?></td>
                        </tr>
                      <?php } ?>
                    </table>
                  </td>
                  <td>
                    <h4>Max Fee</h4>
                    <table class="table table-bordered">
                      <tr>
                        <td><?php echo $max_fee = $class_summary->max_fee; ?></td>
                        <td>
                          Fee Category:
                          <?php
                          if ($max_fee <= 2000) {
                            echo 'Category 1';
                          } elseif ($max_fee > 2000 && $max_fee <= 3500) {
                            echo 'Category 2';
                          } elseif ($max_fee > 3500 && $max_fee <= 6000) {
                            echo 'Category 3';
                          } elseif ($max_fee > 6000 && $max_fee <= 10000) {
                            echo 'Category 4';
                          } elseif ($max_fee > 10000 && $max_fee <= 15000) {
                            echo 'Category 5';
                          } elseif ($max_fee > 15000 && $max_fee <= 20000) {
                            echo 'Category 6';
                          } elseif ($max_fee > 20000) {
                            echo 'Category 7';
                          }
                          ?>
                        </td>
                      </tr>
                      <tr>


                      </tr>
                    </table>
                    <h4>Staff</h4>
                    <table class="table table-bordered">
                      <tr>
                        <th></th>
                        <th>Non Teaching</th>
                        <th>Teaching</th>
                        <th>Total</th>
                      </tr>
                      <tr>
                        <th>Males</th>
                        <td><?php echo $input->non_teaching_male_staff; ?></td>
                        <td><?php echo $input->teaching_male_staff; ?></td>
                        <td><strong><?php echo $input->non_teaching_male_staff + $input->teaching_male_staff; ?></strong></td>
                      </tr>
                      <tr>
                        <th>Females</th>
                        <td><?php echo $input->non_teaching_female_staff; ?></td>
                        <td><?php echo $input->teaching_female_staff; ?></td>
                        <td><strong><?php echo $input->non_teaching_female_staff + $input->teaching_female_staff; ?></strong></td>
                      </tr>

                      <tr>
                        <th>Total</th>
                        <td><strong><?php echo $input->non_teaching_male_staff + $input->non_teaching_female_staff; ?></strong></td>
                        <td><strong><?php echo $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                        <td><strong><?php echo $total_teachers = $input->non_teaching_male_staff + $input->non_teaching_female_staff + $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                      </tr>
                    </table>
                    <br />
                    <table class="table table-bordered">
                      <tr>
                        <th>Student Teacher Radio</th>
                        <td><?php
                            $total_students = $class_summary->boys + $class_summary->girls;
                            echo round($total_students / $total_teachers, 1); ?></td>
                      </tr>
                      <tr>
                        <th>Student Class Rooms Radio</th>
                        <td><?php echo round($total_students / $class_summary->rooms, 1); ?></td>
                      </tr>
                    </table>

              </table>

            </td>
          </tr>


        </table>


        </td>

        </tr>

    </table>
    <div class="row" style="margin-bottom: 30px;">
      <div class="col-xs-12">
        <div class="col-xs-12">
          <h4>Final Report <small class="pull-right">Time Taken:
              <?php
              $visit_start = new DateTime($input->visit_start);
              $visit_end = new DateTime($input->visit_end);

              // Calculate the difference between visit_end and visit_start
              $time_taken = $visit_end->diff($visit_start);

              // Format the difference as a string
              //$time_taken_formatted = $time_taken->format('%y years, %m months, %d days, %H hours, %I minutes, %S seconds');
              echo $time_taken_formatted = $time_taken->format('%H hours, %I minutes, %S seconds');

              ?>

            </small></h4>
          <p>
            Institute <strong><?php echo $school->schoolName; ?></strong> (S-ID <strong><?php echo $school->schools_id ?></strong>) was visited by
            <strong><?php echo $input->visited_by_officers; ?></strong> and
            <strong><?php echo $input->visited_by_officials; ?> </strong>
            <?php if ($input->recommendation == 'Recommended') { ?>
              and <strong>recommended</strong> for the following levels:
            <?php } ?>


            <?php if ($input->recommendation == 'Not Recommended') { ?>
              and <strong>not recommended</strong> for levels any level.

              <strong>Reasons: </strong>
              <?php echo $input->not_recommendation_remarks; ?>


            <?php } ?>
          <p>
          <table class="table table-bordered" style="border: 0px !important;">
            <tr>
              <th style="width:50px"></th>

              <th>Primary <small>(PG to 5th)</small></th>
              <th>Middle (6th to 8th)</th>
              <th>High (9th to 10th)</th>
              <th>Higher Secondary (11th to 12th)</th>
            </tr>

            <tr>
              <th>Recommended</th>
              <td style="vertical-align: bottom; text-align:center">
                <?php
                if ($school->school_type_id == 1) {
                  echo ($input->r_primary_l == 1) ? "<span style='font-size:30px;'>&#10003;</span>" : "<span style='font-size:30px;'>&#10005;</span>";
                }
                ?>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <?php if ($school->school_type_id == 1) {
                  echo ($input->r_middle_l == 1) ? "<span style='font-size:30px;'>&#10003;</span>" : "<span style='font-size:30px;'>&#10005;</span>";
                } ?>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <?php if ($school->school_type_id == 1) {
                  echo ($input->r_high_l == 1) ? "<span style='font-size:30px;'>&#10003;</span>" : "<span style='font-size:30px;'>&#10005;</span>";
                } ?>
              </td>
              <td style="vertical-align: bottom; text-align:center">
                <?php if ($school->school_type_id == 1) {
                  echo ($input->r_high_sec_l == 1) ? "<span style='font-size:30px;'>&#10003;</span>" : "<span style='font-size:30px;'>&#10005;</span>";
                } ?>
              </td>
            </tr>
          </table>
          <strong>Visiter Note:</strong>
          <p> <?php echo $input->other_remarks; ?></p>


          </p>
        </div>
      </div>

    </div>




    </tbody>


    </table>
  </div>
  <footer>
    <!-- Your footer content goes here -->
    <p style="text-align:center; font-size:12px">
      <small>
        School Id # <?php echo $school->schools_id; ?> -

        <?php echo "Visit ID # " . @$input->visit_id;  ?> -

        Session Year: <?php echo @$session->sessionYearTitle; ?> -
        Case: <?php echo @$session->regTypeTitle; ?> - File No: <?php
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
        Printer on date: <?php echo date("d M, Y h:m:s a"); ?>
      </small>

    </p>
  </footer>
</body>

</html>