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
  <page size='A4' style="min-height: 500px;">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice" style="padding-top:50px">
        <div class="col-md-12">
          <h5 style="text-align: right; margin-right:20px">Flag - A</h5>
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
                <p>Address: <?php echo  $school->address; ?></p>
                <b>
                  <?php echo "Tele-Phone #: " . $school->telePhoneNumber; ?> - <?php echo "Mobile #: " . $school->schoolMobileNumber; ?>
                </b>

              </td>
              <td>
                <h6>
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
                </h6>

              </td>
            </tr>

          </table>

          <hr>
        </div>






        <div class="col-md-12">



          <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

            <table class="table table2 table-bordered">
              <tr>
                <th colspan="17">
                  <h4>Sessions and class wise monthly fee comparison</h4>
                </th>
              </tr>

              <tr>
                <th>Session</th>
                <th>Level</th>
                <?php

                $query = "SELECT `school`.`session_year_id` FROM school WHERE schoolId = '" . $school_id . "'";
                $currentsessionid = $this->db->query($query)->row()->session_year_id;
                $previoussessionid = ($currentsessionid - 1);
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
                AND schools_id = " . $school->schoolId . "
                AND `school`.`session_year_id` IN ('" . $currentsessionid . "','" . $previoussessionid . "')
                ORDER BY `session_year`.`sessionYearId` ASC
                ";
                $school_sessions = $this->db->query($query)->result();

                $query = "select max(sessionYearId) as sessionYearId from session_year";
                $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;

                $classes = $this->db->query("SELECT * FROM class")->result();
                foreach ($classes  as $class) { ?>
                  <th><?php echo $class->classTitle ?></th>
                <?php } ?>

                <?php foreach ($school_sessions as $school_session) { ?>

              <tr>
                <td>
                  <?php echo $school_session->sessionYearTitle ?>
                </td>
                <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>
              <?php
                  foreach ($classes  as $class) {


                    $query = "SELECT
                    `fee`.`addmissionFee`
                    , `fee`.`tuitionFee`
                    , `fee`.`securityFund`
                    , `fee`.`otherFund`
                    FROM
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
                    if ($session_fee->tuitionFee == 0) {
                      echo '<td style="text-align:center">' . $session_fee->tuitionFee . '</td>';
                    } else {
                      echo '<td style="text-align:center">' . $session_fee->tuitionFee;


                      if ($pre_session_tution_fee) {
                        $incress = round((($current_fee - $pre_session_tution_fee) / $pre_session_tution_fee) * 100, 2);
                        if ($incress > 10) {
                          echo @" <small style='color:black;  font-weight: bold;'>" . $incress . "%</small>";
                        } else {
                          echo @" <small style='color:black;  font-weight: bold;'>" . $incress . "%</small>";
                        }
                      }
                      echo '</td>';
                    }
                  }
                  echo '</tr>';
                } ?>


            </table>
          </div>




          <p style=" font-size:8px; text-align: center; margin-top: 20px;">
            <?php
            $userId = $this->session->userdata('userId');
            $query = "SELECT
            `roles`.`role_title`,
            `users`.`userTitle`  
        FROM `roles`,
        `users` 
        WHERE `roles`.`role_id` = `users`.`role_id`
        AND `users`.`userId`='" . $userId . "'";
            $user_data = $this->db->query($query)->row();
            ?>
            <?php echo $user_data->userTitle; ?> <?php echo $user_data->role_title; ?>
            <span style="margin-left: 10px; margin-right:10px;">
              -
            </span>
            Printed at: <?php echo date("d, F, Y h:i:s A", time()); ?>
          </p>

      </section>
      <!-- /.content -->
      <div class="clearfix"></div>

    </div>

  </page>

</body>

</html>