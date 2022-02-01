<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
  .chat {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .chat li {
    margin-bottom: 5px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
  }

  .chat li.left .chat-body {
    margin-left: 10px;
  }

  .chat li.right .chat-body {
    margin-right: 60px;
  }


  .chat li .chat-body p {
    margin: 0;
    color: #777777;
  }

  .panel .slidedown .glyphicon,
  .chat .glyphicon {
    margin-right: 5px;
  }

  .panel-body {
    overflow-y: scroll;
    height: 250px;
  }

  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    background-color: #555;
  }

  .comment_image_left {
    width: 36px;
    margin-right: 10px;
  }

  .comment_image_right {
    width: 36px;
    margin-left: 10px;
  }

  .comment_textarea {
    overflow: hidden;
    border: 1px solid blue;
    border-radius: 5px;
    padding: 2px;
    width: 86%;
    min-height: 40px !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
    cursor: default;
    padding-left: 2px;
    padding-right: 5px;
    color: black !important;
    font-weight: bold !important;
  }
</style>
<style>
  .table2>tbody>tr>td,
  .table2>tbody>tr>th,
  .table2>tfoot>tr>td,
  .table2>tfoot>tr>th,
  .table2>thead>tr>td,
  .table2>thead>tr>th {
    padding: 2px;
    line-height: 1.42857143;
    vertical-align: top;
  }
</style>
<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
    School Detail - <?php echo $school->schools_id ?>
  </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

  <div class="row">
    <div class="col-md-12" style="padding-right: 1px; padding-left: 1px;">

      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 5px; background-color: white;">
        <div style="text-align:center">
          <h3>
            <?php echo ucwords(strtolower($school->schoolName)); ?><br />

          </h3>
          <h4> School ID: <?php echo $school->schools_id ?>
            <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> Reg. ID:
              <?php echo $school->registrationNumber ?>
            <?php } ?>
          </h4>
          <small>
            <?php if ($school->division) {
              echo "Zone: <strong>" . $school->division . "</strong>";
            } ?>
            <?php if ($school->districtTitle) {
              echo " / District: <strong>" . $school->districtTitle . "</strong>";
            } ?>
            <?php if ($school->tehsilTitle) {
              echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
            } ?>

            <?php if ($school->ucTitle) {
              echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
            } ?></small>
        </div>

        <table class="table2" style="width: 100%;">
          <tr>
            <td><strong>Contact Detail </strong><br />
              <?php if ($school->telePhoneNumber) { ?>Telephone: <?php echo $school->telePhoneNumber ?> <?php } ?><br />
            <?php if ($school->schoolMobileNumber) { ?>Mobile: <?php echo $school->schoolMobileNumber ?> <?php } ?><br />
          <?php if ($school->principal_email) { ?>Email: <?php echo $school->principal_email ?> <?php } ?><br />
        Level: <?php if (!empty($school->levelofInstituteTitle)) : ?>
          <?php echo $school->levelofInstituteTitle; ?>
        <?php endif; ?>
        <br />
        Type: <?php if (!empty($school->typeTitle)) : ?>
          <strong><?php echo $school->typeTitle; ?></strong>
          <?php if (!empty($school->schoolTypeOther)) : ?>
            <strong><?php echo $school->schoolTypeOther; ?></strong>
          <?php endif; ?>
        <?php endif; ?>
        <br />Gen. Edu. <?php if (!empty($school->genderOfSchoolTitle)) : ?>
          <strong><?php echo $school->genderOfSchoolTitle; ?></strong>
        <?php endif; ?>
            </td>
            <td>
              <strong>Owner Detail </strong><br />
              <?php if ($school->userTitle) { ?>Name: <?php echo $school->userTitle ?> <?php } ?><br />
            <?php if ($school->cnic) { ?>CNIC: <?php echo $school->cnic ?> <?php } ?><br />
          <?php if ($school->contactNumber) { ?>Contact No: <?php echo $school->contactNumber ?> <?php } ?><br />

        Institute established: <strong>
          <?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong>
        <br /> <?php if (!empty($school->biseregistrationNumber)) { ?>
          <?php echo "BISE Registration No: " . $school->biseregistrationNumber; ?>
          <?php if ($school->bise_verified == "Yes") { ?>
            <strong style="color:green"> Verified </strong>
            <br />
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
          <?php } else { ?>
            <strong style="color:red"> Not Verified </strong>
          <?php } ?>
        <?php } else { ?>
          BISE Rregistration: <strong>No</strong>
        <?php } ?>
        <br />

        First Appointment: <strong><?php echo date('d M, Y', strtotime($first_appointment_staff->appoinment_date)); ?></strong>
        ( <?php echo $first_appointment_staff->name ?> )<br />



            </td>
          </tr>
        </table>



      </div>

      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
          Session's History
        </h4>
        <?php $query = "SELECT
        `reg_type`.`regTypeTitle`,
        `school_type`.`typeTitle`,
        `levelofinstitute`.`levelofInstituteTitle`,
        `session_year`.`sessionYearTitle`,
        `school`.`renewal_code`,
        `school`.`status`,
        `school`.`created_date`,
        `school`.`updatedBy`,
        `school`.`updatedDate`,
        `school`.`schoolId`
        FROM
        `school`,
        `reg_type`,
        `gender`,
        `school_type`,
        `levelofinstitute`,
        `session_year`
        WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
        AND `gender`.`genderId` = `school`.`gender_type_id`
        AND `school_type`.`typeId` = `school`.`school_type_id`
        AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
        AND `session_year`.`sessionYearId` = `school`.`session_year_id`
        AND schools_id = '" . $school->schools_id . "'";
        $school_sessions = $this->db->query($query)->result(); ?>


        <table class="table table2">
          <tr>
            <th>Type</th>
            <th>Level</th>
            <th>Session</th>
            <th>Max Fee</th>
            <th style="color:red"><i class="fa fa-line-chart" aria-hidden="true"></i></th>
            <th>Enrolled</th>
            <th>Date</th>
            <th></th>
          </tr>
          <?php
          $previous_max = NULL;
          foreach ($school_sessions as $school_session) { ?>
            <?php if ($school_session->schoolId == $school_id and $school_session->schoolId != 1) { ?>
              <tr style="background-color: white !important; font-weight: bold;">
                <td colspan="8">Current Session</td>
              </tr>
            <?php } ?>
            <tr <?php if ($school_session->schoolId == $school_id) { ?> style="background-color: white !important; font-weight: bold;" <?php } ?> title="<?php echo  $school_session->schoolId; ?>">
              <td>
                <?php
                $words = explode(" ", $school_session->regTypeTitle);
                $acronym = "";

                foreach ($words as $w) {
                  echo strtoupper($w[0]);
                }
                ?></td>
              <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>
              <td>
                <a href="<?php echo site_url("print_file/school_session_detail/" . $school_session->schoolId); ?>" target="new">
                  <?php echo $school_session->sessionYearTitle; ?></a>
              </td>
              <td><?php
                  $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                  $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                  $max_tuition_fee = preg_replace(
                    '/[^0-9.]/',
                    '',
                    $this->db->query($query)->result()[0]->max_tution_fee
                  );
                  echo $max_tuition_fee;
                  ?> Rs.</td>
              <td><?php
                  if ($previous_max) {
                    $color = '';
                    $dec = $max_tuition_fee - $previous_max;
                    $inc = round(($dec / $max_tuition_fee) * 100, 2);
                    if ($inc > 10) {
                      $color = 'red';
                    } else {
                      $color = 'green';
                    }
                    if ($inc < 0) {
                      $color = 'red';
                    }
                  ?>
                  <span style="color:<?php echo $color; ?>"><?php echo  round(($dec / $max_tuition_fee) * 100, 2); ?></span>
                <?php   } ?>
              </td>
              <td><?php
                  $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                  echo $this->db->query($query)->result()[0]->total; ?></td>
              <td><?php
                  if ($school_session->updatedDate) {
                    echo date('d M, Y', strtotime($school_session->updatedDate));
                  }
                  ?></td>

              <td>
                <?php if ($school_session->status == 1) { ?>
                  <i class="fa fa-check" aria-hidden="true"></i>
                <?php } else { ?>
                  <i class="fa fa-spinner" aria-hidden="true"></i>
                <?php } ?>
              </td>
            </tr>
          <?php
            $previous_max = $max_tuition_fee;
          } ?>
        </table>

      </div>


    </div>




  </div>