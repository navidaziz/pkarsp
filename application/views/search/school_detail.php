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

        <table class="table table2">
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
          <?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong><br />

        <?php if (!empty($school->biseregistrationNumber)) { ?>
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

        <?php if ($session_request_detail->reg_type_id == 1) {  ?>
          <li>Institute Max Fee:
            <?php echo $max_tuition_fee; ?> Rs. </strong> per month.

          <?php } ?>

            </td>
          </tr>
        </table>



      </div>

      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
          Session's History
        </h4>
        <?php 
        $query = "SELECT
        `reg_type`.`regTypeTitle`,
        `levelofinstitute`.`levelofInstituteTitle`,
        `session_year`.`sessionYearTitle`,
        `school`.`renewal_code`,
        `school`.`status`,
        `school`.`created_date`,
        `school`.`updatedBy`,
        `school`.`updatedDate`,
        `school`.`schoolId`,
        `school`.`session_year_id`
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
        AND schools_id = '" . $school->schools_id . "' ORDER  BY `session_year`.`sessionYearId` ASC";
        $school_sessions = $this->db->query($query)->result(); ?>


        <table class="table table2">
          <tr>
            <th>Type</th>
            <th>Level</th>
            <th>Session</th>
            <th>Max Fee</th>
            <th style="color:red"><i class="fa fa-line-chart" aria-hidden="true"></i></th>
            <th>Student Enrollment</th>
            <th>Date</th>
            <th>Note Sheet</th>
            <th>Status</th>
            <th>Cerificate</th>
          </tr>
          <?php
          $previous_max = NULL;
          //var_dump($school_sessions);
          foreach ($school_sessions as $school_session) { ?>
            <?php if ($school_session->schoolId == $school_id and $school_session->schoolId != 1) { ?>
              <tr style="background-color: white !important; font-weight: bold;">
                <td colspan="9">Current Session</td>
              </tr>
            <?php } ?>
            <tr <?php if ($school_session->schoolId == $school_id) { ?> style="background-color: white !important; font-weight: bold;" <?php } ?> title="<?php echo  $school_session->schoolId; ?>">
              <td>
                <?php echo $school_session->regTypeTitle ?>
              </td>
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
                  $max_tuition_fee = (int) preg_replace("/[^0-9]/", "",  $max_tuition_fee );
                  echo $max_tuition_fee;
                  
                  ?> Rs.</td>
              <td><?php
                 if ($previous_max) {
                  $color = '';
                    $dec = $max_tuition_fee - $previous_max;
                    if($max_tuition_fee){
                    $inc = @round(($dec / $max_tuition_fee) * 100, 2);
                    }else{
                      $inc = 0;
                    }
                    if ($inc > 10) {
                      $color = 'red';
                    } else {
                      $color = 'green';
                    }
                    if ($inc < 0) {
                      $color = 'red';
                    }
                    
                  ?>
                  <span style="color:<?php echo $color; ?>"><?php echo  $inc; ?></span>
                <?php   } ?>
              </td>
              <td><?php
                  $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                  echo $this->db->query($query)->result()[0]->total; ?></td>
              <td><?php
                  if ($school_session->updatedDate) {
                    echo date('d M, y', strtotime($school_session->updatedDate));
                  }
                  ?></td>
              <td><a href="<?php echo site_url("print_file/note_sheet/" . $school_session->schoolId); ?>" target="new">
                  <i class="fa fa-print" aria-hidden="true"></i></a></td>
              <td>
                <?php if ($school_session->status == 1) { ?>
                  <i class="fa fa-check" aria-hidden="true"></i>
                <?php } else { ?>
                  <i class="fa fa-spinner" aria-hidden="true"></i>
                <?php } ?>
              </td>
              <td> <a target="_new" href="<?php echo site_url("print_file/certificate/" .  $school->schools_id . "/" . $school_session->schoolId . "/" . $school_session->session_year_id); ?>">
                  <i class="fa fa-print" aria-hidden="true"></i></a></td>
              <td>
            </tr>
          <?php
            $previous_max = $max_tuition_fee;
          } ?>
        </table>

      </div>


      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
          Fine's
        </h4>
        <?php $query = "SELECT `fine_amount`, `remarks`, `created_date`, `is_fined` FROM `school_fine_history` WHERE school_id = '" . $schools_id . "'";
        $fines = $this->db->query($query)->result(); ?>
        <table class="table">
          <tr>
            <th>#</th>
            <th>Remarks</th>
            <th>Fine(Rs.)</th>
            <th>Status</th>
          </tr>
          <?php
          $count = 1;
          foreach ($fines as $fine) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $fine->remarks ?></td>
              <td><?php echo $fine->fine_amount ?></td>
              <td><?php echo $fine->is_fined ?></td>
            </tr>
          <?php } ?>
        </table>

      </div>

      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
        <?php
        $query =
          "SELECT COUNT(`message_for_all`.`message_id`) as total FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where `message_school`.`school_id`=$school->schools_id";
        $query_result = $this->db->query($query);
        $total_messages = $query_result->result()[0]->total; ?>

        <h4><i class="fa fa-envelope-o"></i> Inbox Messages
          <span class="label label-primary pull-right"><?php echo $total_messages; ?></span>
        </h4>


        <?php
        $query =
          "SELECT message_for_all.*,`message_school`.`school_id` FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where `message_school`.`school_id`=$school->schools_id  order by `message_for_all`.`message_id`";
        $query_result = $this->db->query($query);
        $school_messages = $query_result->result(); ?>
        <table class="table">
          <?php
          foreach ($school_messages as $message) : ?>
            <tr>

              <td class=" message">
                <a target="_new" href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                  <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                </a>
                <small style="display: block; color:gray" class="pull-right">
                  <i class="fa fa-clock-o" aria-hidden="true"></i>
                  <?php echo date("d M, Y", strtotime($message->created_date)); ?>
              </td>

            </tr>

          <?php endforeach; ?>

        </table>

      </div>



    </div>




  </div>