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
  </style>

</head>

<body>
  <div class="container">
    <table class="table">
      <tr>
        <td>
          <h5>PSRA Visit Proforma </h5>
          <h5 style="text-transform: uppercase;">
            School Name:</h5>
          <h5> Applied for ( _____________________________ )</h5>
          BISE REG. <strong>Yes - No</strong> -
          BISE REG. No. <strong>_____________</strong>
        </td>
        <td>
          <h6 style="line-height: 23px;">
            School Id # _________________ <br />

            Current Level: ________________<br />
            Session Year: _________________<br />

            Contact: ______________________

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
                <tr>
                  <td>B.Ed</td>
                  <td> <span style="margin-left: 5px;"></span>1. Yes <span style="margin-left: 20px;"></span> 2. No </td>
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
                        WHERE s.schoolId = '" . $school->schoolId . "'";
              $owner = $this->db->query($query)->row();
              $all_owners[$owner->owner_cnic] = $owner;
              $query = "SELECT * FROM `school_owners` WHERE school_id = '" . $school->schoolId . "'";
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
              } ?> <span style="margin-left: 3px;"></span> Co-Edu.



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
            <td style="height: 40px;"></td>
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
              1. Owned
              <span style="margin-left:15px;"></span>
              2. Rented: <small> Monthly Rent (Rs.):____________</small>
              <span style="margin-left:15px;"></span>
              3. Donated/Trusted
            </td>
            <td style="width:180px">
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
        <strong><i><small>(Only for New Registration)</small></i> Please confirm Year of Establishment</strong>
        <table class="table table-bordered">
          <tr>
            <th>Y.of.Estb.(Online Apply)</th>
            <th>First Student Enrollment Date</th>
            <th>First Teacher Appointment Date</th>
            <th>Rent Aggrement Date</th>
            <th>Confirm Year of Establishment</th>
            <th>Suggest Session</th>
          </tr>
          <tr style="height: 30px;">
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
            <table class="table  table-bordered">
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
            <table class="table  table-bordered">
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

            <strong>Registers Maintained</strong>
            <table class="table table-bordered">
              <tr>
                <th>Admission and withdrawal </th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>
                  Student Attendance </th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>
                  Student Fee Register
                </th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>
                  Teacher Attendance </th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>
                  Teacher Salary
                </th>
                <td>Yes</td>
                <td>No</td>
              </tr>




            </table>
            <br />


            <strong>IT Facility In School</strong>
            <table class="table table-bordered">
              <tr>
                <th>Computer Availability</th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>Internet Connection</th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>Mobile 3G / 4G Access</th>
                <td>Yes</td>
                <td>No</td>
              </tr>
            </table>
            <br />
            <strong>Others</strong>
            <table class="table table-bordered">
              <tr>
                <th>Is there a shared building for both Madrasa and School?</th>
                <td>Yes</td>
                <td>No</td>
              </tr>
              <tr>
                <th>Is there a Tuition Academy within the school?</th>
                <td>Yes</td>
                <td>No</td>
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

              <table class="table table_small  table-bordered">
                <tr>
                  <td colspan="2"><strong>Section-F: SECURITY MEASURES</strong></td>
                </tr>
                <tr>
                  <td>Security Status</td>
                  <td>Managed
                    <br />
                    Not Managed
                  </td>
                </tr>

                <!-- Type of Security Provided -->
                <tr>
                  <td>Type of Security Provided</td>
                  <td>Own Arrangement <br />
                    Provided By Authorized Security Company</td>
                </tr>

                <!-- Status of Security Personnel -->
                <tr>
                  <td>Status of Security Personnel</td>
                  <td>Trained <br />
                    Retired (Forces)<br />
                    Fresh</td>
                </tr>

                <!-- Security Personnel (in Nos) -->
                <tr>
                  <td>Security Personnel (in Nos)</td>
                  <td></td>
                </tr>

                <!-- Whether security is inline with instruction of Police Department -->
                <tr>
                  <td>Whether security is inline with instruction of Police Department ?</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- CCTVs Camera System Installed -->
                <tr>
                  <td>CCTVs Camera System Installed</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Number of CCTVs Cameras -->
                <tr>
                  <td>Number of CCTVs Cameras</td>
                  <td></td>
                </tr>

                <!-- DVR Maintained -->
                <tr>
                  <td>DVR Maintained</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- CCTVs Online Accessibility -->
                <tr>
                  <td>CCTVs Online Accessibility</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Emergency Exit Door Availability -->
                <tr>
                  <td>Emergency Exit Door Availability</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Number of Exit Doors -->
                <tr>
                  <td>Number of Exit Doors</td>
                  <td></td>
                </tr>

                <!-- Boundary Wall Height (In Feet) -->
                <tr>
                  <td>Boundary Wall Height (In Feet)</td>
                  <td></td>
                </tr>

                <!-- Barbed Wires Provided -->
                <tr>
                  <td>Barbed Wires Provided</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Watch Tower -->
                <tr>
                  <td>Watch Tower</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Number of Licensed Weapon(s) -->
                <tr>
                  <td>Number of Licensed Weapon(s)</td>
                  <td></td>
                </tr>

                <!-- License issued by whom -->
                <tr>
                  <td>License issued by whom:</td>
                  <td>DC, Home Deptt KPK, Ministry Of Interior Pakistan, Other</td>
                </tr>

                <!-- License No(s) -->
                <tr>
                  <td>License No(s):</td>
                  <td></td>
                </tr>

                <!-- Ammunition Status (In Nos.) -->
                <tr>
                  <td>Ammunition Status (In Nos.)</td>
                  <td></td>
                </tr>

                <!-- Metal Detector -->
                <tr>
                  <td>Metal Detector</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Walkthrough gate -->
                <tr>
                  <td>Walkthrough gate:</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>

                <!-- Main Gate Barrier -->
                <tr>
                  <td>Main Gate Barrier:</td>
                  <td>Yes <span style="margin-left:10px;"></span>No</td>
                </tr>
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
                  <tr>
                    <th style="width: 50%;">Exposed to floods:</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Drowning (In case of nearby canal):</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>School Building Condition (Walls, Doors, windows)</th>
                    <td>
                      Good <span style="margin-left: 10px;"></span> Satisfactory <span style="margin-left: 10px;"></span> Poor
                    </td>
                  </tr>
                  <tr>
                    <th>School Access route</th>
                    <td>
                      Safe <span style="margin-left: 10px;"></span> Unsafe
                    </td>
                  </tr>
                  <tr id="more_options" style="display: none;">
                    <th>If Unsafe: Describe the following</th>
                    <td>
                      Main road <span style="margin-left: 10px;"></span> Walk through the market <span style="margin-left: 10px;"></span> Narrow street <span style="margin-left: 10px;"></span> Open field <span style="margin-left: 10px;"></span> Standing Crops
                    </td>
                  </tr>
                  <tr>
                    <th>Other buildings adjacent to School</th>
                    <td>
                      Safe <span style="margin-left: 10px;"></span> Unsafe
                    </td>
                  </tr>
                  <tr>
                    <th>Safe assembly points available for <br>(i. Flood ii. Earthquake iii. Fire iii. Human induce)</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Teacher trained on School Based Disaster Risk Management</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>School Improvement plan developed</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>School Disaster Management plan developed</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Electrification condition</th>
                    <td>
                      Good <span style="margin-left: 10px;"></span> Satisfactory <span style="margin-left: 10px;"></span> Poor
                    </td>
                  </tr>
                  <tr>
                    <th>Proper ventilation system available</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Expose to Chemicals in School Laboratory</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Expose to Chemicals in school surrounding</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Exposed to road accident</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Safe drinking water available</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>Proper sanitation facilities available (Latrine, draining)</th>
                    <td>
                      Yes <span style="margin-left: 10px;"></span> No
                    </td>
                  </tr>
                  <tr>
                    <th>School Building Structure</th>
                    <td>
                      Single Story <span style="margin-left: 10px;"></span> Double Story
                    </td>
                  </tr>
                  <tr>
                    <th>School surrounded by the community</th>
                    <td>
                      Local <span style="margin-left: 10px;"></span> Outsider <span style="margin-left: 10px;"></span> Refugees
                    </td>
                  </tr>
                </tbody>
              </table>


            </td>
          </tr>

        </table>

        <br />
        <table class="table">
          <tr>
            <td>
              <strong>High Level Institute Teachers</strong>
              <table class="table table_large  ">
                <tr>
                  <th>#</th>
                  <th>Subject</th>
                  <th>Teacher Name</th>
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
              <table class="table table_large ">
                <tr>
                  <th>#</th>
                  <th>Subject</th>
                  <th>Teacher Name</th>
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
        <br />
        <table class="table">
          <tr>
            <td>
              <strong>Non-Teaching Staff Informaiton</strong>
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
                    <td> <span style="margin-left:20px"><span>Management Staff</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><span style="margin-left:20px"><span>Security Guard</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><span style="margin-left:20px"><span>Children Attendant / Aaya</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><span style="margin-left:20px"><span>Others Non Teaching Staff</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>1. Total Non-Teaching Staff</th>
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
                </thead>
                <tbody>
                  <tr>
                    <th>10 Years</th>
                    <th>Matric</th>
                    <td></td>
                    <td></td>
                    <td></td>
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
                  <tr>
                    <th colspan="2">Total Teaching Staff</th>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </table>
        <div class="pagebreak"> </div>
        <table class="table">
          <tr>
            <td>
              <table class="table table-bordered">
                <tr>
                  <th rowspan="2">Level</th>
                  <th>#</th>
                  <th rowspan="2" style="width: 90px;">Classes</th>
                  <th rowspan="2">Rooms <small style="display:blockx">(In Number)</small></th>
                  <th rowspan="2">Rooms Size <small>(sq feet)</small></th>
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
                $class_count = 1;
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
                      <th><?php echo $class_count++; ?></th>
                      <th style=""><?php echo $class->classTitle ?></th>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
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
                  <th colspan="2" style="text-align:right; height: 30px;">
                    <h4>Summary</h4>
                  </th>
                  <th style=" vertical-align:bottom; text-align: center;">

                    <small style="font-size: 8px;">Total Rooms</small>
                  </th>
                  <th style=" vertical-align:bottom; text-align: center;">

                    <small style="font-size: 8px;">AVG. Size</small>
                  </th>
                  <td colspan="2" style="margin: 0px; padding:0px;">
                    <table class="table table-bordered" style="margin: 0px !important; border:0px !important;">
                      <tr>
                        <th style=" vertical-align:bottom; text-align: center;">
                          <br />
                          <small style="font-size: 8px;">Boys</small>
                        </th>
                        <th style=" vertical-align:bottom; text-align: center;">
                          <br />
                          <small style="font-size: 8px;">Girls</small>
                        </th>

                      </tr>
                      <tr>
                        <th colspan="2" style="text-align: center;">
                          Total:
                        </th>
                      </tr>
                    </table>
                  </td>

                  <th style=" vertical-align:bottom; text-align: center;">

                    <small style="font-size: 8px;">Max Fee</small>
                  </th>
                  <th colspan="2" style="padding-top:10px;">

                    *Student Class Rooms Ratio. __________
                    <= 40<br />
                    <br />
                    *Student Teachers Ratio. ________ <= 40 </th>


                </tr>

              </table>
              <table class="table">
                <tr>
                  <th>Other Rooms</th>
                  <th colspan="2">Science Lab <span style="margin: 10px;"> Yes</span>
                    <span style="margin: 10px;"> No</span>
                  </th>

                  <th colspan="2">Computer Lab <span style="margin: 10px;"> Yes</span>
                    <span style="margin: 10px;"> No</span>
                  </th>
                </tr>
                <tr>
                  <td>
                    <table class="table table-bordered">
                      <tbody>

                        <tr>
                          <th style="width: 120px;">Staff Room (Male)</th>
                          <td style="width: 40px;"></td>
                        </tr>
                        <tr>
                          <th style="width: 120px;">Staff Room (Female)</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Principal Office</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Account Office</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th><small>Reception / Wating Area</small></th>
                          <td><small>Yes / No </small></td>
                        </tr>

                      </tbody>
                    </table>

                    <strong>Toilets <span style="margin-left: 10px;">Yes</span> <span style="margin-left: 10px;">No</span></strong>
                    <table class="table table-bordered">
                      <tbody>

                        <tr>
                          <th>Male </th>
                          <th>Female </th>
                          <th>Total </th>
                        </tr>
                        <tr>

                          <td style="height: 20px;"></td>
                          <td></td>
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
                          <th colspan="4">HIGH LEVEL ONLY: <span style="margin-left: 10px;"></span>Equipments:</th>

                        </tr>
                        <tr>
                          <td>1.</td>
                          <th>Science Lab</th>
                          <td>Yes</td>
                          <td>No</td>
                          <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 10px;"></span> (ii) Deficient</th>
                        </tr>

                      </tbody>
                    </table>
                    <br />
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th>#</th>
                          <th colspan="4">HIGH Sec. LEVEL ONLY: <span style="margin-left: 10px;"></span> Equipments:</th>

                        </tr>

                        <tr>
                          <td>1.</td>
                          <th>Physics</th>
                          <td>Yes</td>
                          <td>No</td>
                          <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 10px;"></span> (ii) Deficient</th>

                        </tr>
                        <tr>
                          <td>2.</td>
                          <th>Chemistry</th>
                          <td>Yes</td>
                          <td>No</td>
                          <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 10px;"></span> (ii) Deficient</th>

                        </tr>
                        <tr>
                          <td>3.</td>
                          <th>Biology</th>
                          <td>Yes</td>
                          <td>No</td>
                          <th style="text-align: center;"> (i) *Sufficient <span style="margin-left: 10px;"></span> (ii) Deficient</th>

                        </tr>
                      </tbody>
                    </table>
                    <h5>Total Number(s) of Science Labs ____________</5>
                  </td>
                  <td>
                    <table class="table table-bordered">

                      <tr>
                        <th>Total Computers </th>
                        <td style="width:30px"> </td>
                      </tr>
                      <tr>
                        <th>Working Computers</th>
                        <td> </td>
                      </tr>
                    </table>
                    <strong>Library <span style="margin-left: 10px;">Yes</span> <span style="margin-left: 10px;">No</span></strong>
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th>General Knowledge Books</th>
                          <td style="width:30px"></td>
                        </tr>
                        <tr>
                          <th>History Books</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Islamic Books</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Other Books</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Total Books</th>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>


              </table>


            </td>

          </tr>

        </table>


        <h5>Recommendation <span class="pull-right"> Visit Date: __________________ Time: ___________</span></h5>
        <table class="table table_small  table-bordered" style="border: 0px !important;">
          <tr>
            <th style="width:50px"></th>
            <th>Primary <br /><small>(PG to 5th)</small></th>
            <th>Middle <br />(6th to 8th)</th>
            <th>High <br />(9th to 10th)</th>
            <th>Higher Sec. <br />(11th to 2nd)</th>
            <th style="width: 150px; border: 0px !important;">Visited By</th>
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
            <td rowspan="2" style="border: 0px !important; width:50%">
              <table class="table">
                <tr>
                  <th>#</th>
                  <th>Name / Designation</th>
                  <th>Signature</th>
                </tr>
                <tr>
                  <th>1.</th>
                  <th></th>
                  <th></th>
                </tr>
                <tr>
                  <th>2.</th>
                  <th></th>
                  <th></th>
                </tr>
                <tr>
                  <th>3.</th>
                  <th></th>
                  <th></th>
                </tr>
              </table>
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

        <div class="box" style="height: 100px;">
          <small>In case it is not recommended, please provide specific reasons for the non-recommendation.</small>
        </div>



      </tbody>


    </table>
  </div>
  <footer>
    <!-- Your footer content goes here -->
    <p style="text-align:center; font-size:12px">

      <strong> Institute Stamp and Signature _________________________________________________. </strong>

      <br />

    </p>
  </footer>
</body>

</html>