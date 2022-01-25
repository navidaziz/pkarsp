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
<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
    Request for <strong><?php echo $session_request_detail->regTypeTitle ?></strong>
    session <strong><?php echo $session_request_detail->sessionYearTitle ?></strong>
    for level <strong><?php echo $session_request_detail->levelofInstituteTitle ?></strong> on
    <strong><?php echo date("d M, Y", strtotime($session_request_detail->created_date)); ?></strong>


  </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

  <div class="row">
    <div class="col-md-4" style="padding-right: 1px; padding-left: 1px;">
      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 5px; padding: 5px; background-color: white;">
        <div style="text-align:center">
          <h2>
            <?php echo ucwords(strtolower($school->schoolName)); ?><br />

          </h2>
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



        <table class="table">
          <tr>
            <td>
              <strong>Contact Detail </strong><br />
              <?php if ($school->telePhoneNumber) { ?>Telephone: <?php echo $school->telePhoneNumber ?> <?php } ?><br />
            <?php if ($school->schoolMobileNumber) { ?>Mobile: <?php echo $school->schoolMobileNumber ?> <?php } ?><br />
          <?php if ($school->principal_email) { ?>Email: <?php echo $school->principal_email ?> <?php } ?><br />

            </td>
            <td>
              <strong>Owner Detail </strong><br />
              <?php if ($school->userTitle) { ?>Name: <?php echo $school->userTitle ?> <?php } ?><br />
            <?php if ($school->cnic) { ?>CNIC: <?php echo $school->cnic ?> <?php } ?><br />
          <?php if ($school->contactNumber) { ?>Contact No: <?php echo $school->contactNumber ?> <?php } ?><br />

            </td>
          </tr>
        </table>
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
            border-top: 1px solid #ddd;
          }
        </style>
        <table class="table table2">
          <tr>
            <th>Level</th>
            <th>Type</th>
            <th>Gender Education</th>
          </tr>
          <tr>
            <td>
              <?php if (!empty($school->levelofInstituteTitle)) : ?>
                <?php echo $school->levelofInstituteTitle; ?>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($school->typeTitle)) : ?>
                <?php echo $school->typeTitle; ?>
                <?php if (!empty($school->schoolTypeOther)) : ?>
                  <?php echo $school->schoolTypeOther; ?>
                <?php endif; ?>
              <?php endif; ?>
            </td>

            <td>
              <?php if (!empty($school->genderOfSchoolTitle)) : ?>
                <?php echo $school->genderOfSchoolTitle; ?>
              <?php endif; ?>
            </td>
          </tr>
        </table>

      </div>

      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
          Previous Session's Detail
        </h4>
        <?php if ($session_request_detail->reg_type_id == 1) { ?>
          <ol>
            <li>Institute established: <strong>
                <?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong></li>
            <li>
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
            </li>
            <li>First Appointment: <strong><?php echo date('d M, Y', strtotime($first_appointment_staff->appoinment_date)); ?></strong>
              ( <?php echo $first_appointment_staff->name ?> )

            </li>
            <li>Institute Max Fee:
              <strong><?php echo $max_tuition_fee; ?> Rs. </strong> per month.
            </li>
          </ol>
        <?php } ?>

        <?php if ($session_request_detail->reg_type_id == 2 or $session_request_detail->reg_type_id == 3 or $session_request_detail->reg_type_id == 4) {
          $query = "SELECT
          `reg_type`.`regTypeTitle`,
          `school_type`.`typeTitle`,
          `levelofinstitute`.`levelofInstituteTitle`,
          `session_year`.`sessionYearTitle`,
          `school`.`renewal_code`,
          `school`.`status`,
          `school`.`created_date`
          ,  `school`.`schoolId`
          FROM
          `school`,
          `reg_type`,
          `gender`,
          `school_type`,
          `levelofinstitute`,
          `session_year`
          WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
          AND  `gender`.`genderId` = `school`.`gender_type_id`
          AND `school_type`.`typeId` = `school`.`school_type_id`
          AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
          AND `session_year`.`sessionYearId` = `school`.`session_year_id`
          AND   schools_id = '" . $school->schools_id . "'
          AND school.status =1";
          $school_sessions = $this->db->query($query)->result(); ?>


          <table class="table table2">
            <tr>
              <th>Type</th>
              <th>Level</th>
              <th>Session</th>
              <th>Max Fee</th>
              <th>Enrolled</th>
              <th>Date</th>
            </tr>
            <?php foreach ($school_sessions as $school_session) { ?>
              <tr>
                <td><?php echo $school_session->regTypeTitle; ?></td>
                <td><?php echo $school_session->levelofInstituteTitle; ?></td>
                <td><?php echo $school_session->sessionYearTitle; ?></td>
                <td><?php
                    $query = "SELECT MAX(tuitionFee) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                    $max_tuition_fee = preg_replace(
                      '/[^0-9.]/',
                      '',
                      $this->db->query($query)->result()[0]->max_tution_fee
                    );
                    echo $max_tuition_fee;
                    ?> Rs.</td>
                <td><?php
                    $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                    echo $this->db->query($query)->result()[0]->total; ?></td>
                <td><?php echo date('d M, Y', strtotime($school_session->created_date)); ?></td>
              </tr>
            <?php   } ?>
          </table>
          <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
            Current Applied Session Detail
          </h4>
          <?php
          $query = "SELECT
          `reg_type`.`regTypeTitle`,
          `school_type`.`typeTitle`,
          `levelofinstitute`.`levelofInstituteTitle`,
          `session_year`.`sessionYearTitle`,
          `school`.`renewal_code`,
          `school`.`status`,
          `school`.`created_date`
          ,  `school`.`schoolId`
          FROM
          `school`,
          `reg_type`,
          `gender`,
          `school_type`,
          `levelofinstitute`,
          `session_year`
          WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
          AND  `gender`.`genderId` = `school`.`gender_type_id`
          AND `school_type`.`typeId` = `school`.`school_type_id`
          AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
          AND `session_year`.`sessionYearId` = `school`.`session_year_id`
          AND   schools_id = '" . $school->schools_id . "'
          AND `school`.`session_year_id` ='" . $session_request_detail->session_year_id . "'";
          $school_sessions = $this->db->query($query)->result(); ?>
          <table class="table table2">
            <tr>
              <th>Type</th>
              <th>Level</th>
              <th>Session</th>
              <th>Max Fee</th>
              <th>Enrolled</th>
              <th>Date</th>
            </tr>
            <?php foreach ($school_sessions as $school_session) { ?>
              <tr>
                <td><?php echo $school_session->regTypeTitle; ?></td>
                <td><?php echo $school_session->levelofInstituteTitle; ?></td>
                <td><?php echo $school_session->sessionYearTitle; ?></td>
                <td><?php
                    $query = "SELECT MAX(tuitionFee) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                    $max_tuition_fee = preg_replace(
                      '/[^0-9.]/',
                      '',
                      $this->db->query($query)->result()[0]->max_tution_fee
                    );
                    echo $max_tuition_fee;
                    ?> Rs.</td>
                <td><?php
                    $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                    echo $this->db->query($query)->result()[0]->total; ?></td>
                <td><?php echo date('d M, Y', strtotime($school_session->created_date)); ?></td>
              </tr>
            <?php   } ?>
          </table>
        <?php  } ?>
      </div>


    </div>

    <div class="col-md-8" style="padding-right: 1px; padding-left: 1px;">


      <div class="col-md-12" style="padding-right: 1px; padding-left: 1px;">

        <!-- </div> -->
        <div id="all_comments"> </div>
        <!-- inspection report -->
        <?php if ($session_request_detail->inspection_report) { ?>
          <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
            <h4>Inspection Report:</h4>
            <?php echo $session_request_detail->inspection_report;   ?>
          </div>
        <?php } ?>
        <?php if ($session_request_detail->status != 1) { ?>
          <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
            <div style="padding: 5px;">
              <?php
              $where['comment_id'] = $comment_id;
              $this->db->where($where);
              $this->db->select('`comments`.*, `users`.`userTitle`, `roles`.`role_title`');
              $this->db->from('comments');
              $this->db->join('users', 'users.userId = comments.created_by');
              $this->db->join('roles', 'roles.role_id  = users.role_id');
              $comment = $this->db->get()->row();

              ?>
              <p><strong class="primary-font"><?php echo $comment->userTitle; ?></strong>
                (<?php echo $comment->role_title; ?>) <small class="glyphicon glyphicon-time pull-right" title="<?php echo $comment->created_date; ?>"> <?php echo $comment->created_date; ?></small>
                <br />
                <?php echo $comment->comment; ?> :
              </p>

              <strong> Do you want Mark To:
                <span style="margin-left: 10px;"></span>
                <input id="marked_yes" name="marked" type="radio" onclick="$('#mark_to').show()" value="1" /> Yes
                <span style="margin-left: 5px;"></span>
                <input id="marked_no" name="marked" type="radio" onclick="$('#mark_to').hide()" value="0" checked /> No
              </strong>
              <span style="margin-left: 10px;"></span>
              <select class="form-control" style="display: inline; width: 200px; display:none" id="mark_to">
                <option value="">General Remark</option>
                <?php

                $query = "SELECT  `users`.`userId`, `users`.`userTitle`, `roles`.`role_title` 
                           FROM
                           `roles`
                           INNER JOIN `users`
                           ON ( `roles`.`role_id` = `users`.`role_id` )
                           WHERE `roles`.`role_id` !=15
                            ORDER BY `roles`.`role_id`;";
                $users = $this->db->query($query)->result();

                foreach ($users as $user) { ?>
                  <option value="<?php echo $user->userId; ?>"><?php echo $user->userTitle . " - " . $user->role_title; ?></option>

                <?php } ?>
              </select>
            </div>

            <ul class="chat">
              <li class="left clearfix">
                <span class="chat-img pull-left">
                  <img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="comment_image_left">
                </span>
                <textarea name="comment" id="comment" class="form-control comment_textarea" min - rows="1" onkeyup="autoheight(this)"></textarea>
                <button onclick="submit_comment()" class="btn btn-info pull-right"> Submit </button>
                <small id="error_message" style="color:gray; margin-left: 50px;"></small>

              </li>
            </ul>

          </div>
        <?php } ?>

      </div>



    </div>

  </div>
  <script>
    function show_registration_form() {
      if ($('#i_want').prop('checked') == true) {
        $('#registration_form').show();
        $('#account_password').val("");
        $('#account_password').prop('type', 'text');

      } else {
        $('#registration_form').hide();
        $('#account_password').val("");
        $('#account_password').prop('type', 'text');
      }
    }

    function allot_registration_number() {
      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }
        var reg_levels = [];
        $('.reg_levels:checked').each(function(i, e) {
          reg_levels.push($(this).val());
        });
        if (reg_levels.length === 0) {
          alert("Please select atleast one level for registration.");
          return false;
        }


        $.ajax({
            method: "POST",
            url: "<?php echo site_url('forwarded_requests/allot_registration_number'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              reg_levels: reg_levels
            }
          })
          .done(function(respose) {
            //$('#allotment_error').html(respose);
            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
              inspection_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }
          });


      } else {
        alert("Please click on i want registration number.");
      }
    }


    function grant_renewal_upgradation() {

      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }

        if ($(".is_upgrade").is(":checked") == false) {
          alert('Please check on "Do you want to upgrade Yes or Not"');
          return false;
        }
        var upgrade = '';
        var upgrade_levels = [];
        if ($(".is_upgrade").prop("checked")) {
          upgrade = 'Yes';
          $('.upgrade_levels:checked').each(function(i, e) {
            upgrade_levels.push($(this).val());
          });
          if (upgrade_levels.length === 0) {
            console.log("Array Empty.");
            alert("If you want to upgrade Please select recommended levels.");
            return false;
          }
        } else {
          upgrade = 'No';
        }

        var renewal_levels = [];
        $('.renewal_levels:checked').each(function(i, e) {
          renewal_levels.push($(this).val());
        });

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('forwarded_requests/grant_renewal_and_upgrade'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              upgrade: upgrade,
              renewal_levels: renewal_levels,
              upgrade_levels: upgrade_levels

            }
          })
          .done(function(respose) {

            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
              inspection_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }

          });


      } else {
        alert("Please click on i want registration number.");
      }
    }

    function grant_upgradation() {

      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }

        if ($(".is_upgrade").is(":checked") == false) {
          alert('Please check on "Do you want to upgrade Yes or Not"');
          return false;
        }
        var upgrade = '';
        var upgrade_levels = [];
        if ($(".is_upgrade").prop("checked")) {
          upgrade = 'Yes';
          $('.upgrade_levels:checked').each(function(i, e) {
            upgrade_levels.push($(this).val());
          });
          if (upgrade_levels.length === 0) {
            console.log("Array Empty.");
            alert("If you want to upgrade Please select recommended levels.");
            return false;
          }
        } else {
          upgrade = 'No';
        }

        var renewal_levels = [];
        $('.renewal_levels:checked').each(function(i, e) {
          renewal_levels.push($(this).val());
        });

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('forwarded_requests/grant_upgradation'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              upgrade: upgrade,
              renewal_levels: renewal_levels,
              upgrade_levels: upgrade_levels

            }
          })
          .done(function(respose) {

            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
              inspection_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }

          });


      } else {
        alert("Please click on i want registration number.");
      }
    }

    function grant_renewal() {

      if ($('#i_want').prop('checked') == true) {

        if ($('#account_password').val() == "") {
          alert("Account Password Required.");
          return false;
        }


        var renewal_levels = [];
        $('.renewal_levels:checked').each(function(i, e) {
          renewal_levels.push($(this).val());
        });
        if (renewal_levels.length === 0) {
          alert("Please select atleast one level for Renewal.");
          return false;
        }

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('forwarded_requests/grant_renewal'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              account_password: $('#account_password').val(),
              renewal_levels: renewal_levels
            }
          })
          .done(function(respose) {

            respose = JSON.parse(respose);
            if (respose.status == '1') {
              $('#renewal_option').html(respose.message);
              get_new_requests();
              completed_requests();
            }
            if (respose.status == '0') {
              $('#allotment_error').html(respose.message);
            }

          });


      } else {
        alert("Please click on i want registration number.");
      }
    }


    function submit_comment() {
      var comment = $('#comment').val();
      if (comment != "") {

        var mark_to = '';
        var marked = $("input[name='marked']:checked").val();

        if (marked == '1') {
          mark_to = $("#mark_to option:selected").val();
        }

        $.ajax({
            method: "POST",
            url: "<?php echo site_url('forwarded_requests/add_comment'); ?>",
            data: {
              session_id: <?php echo $session_id; ?>,
              school_id: <?php echo $school_id; ?>,
              schools_id: <?php echo $school->schools_id; ?>,
              comment_id: <?php echo $comment_id; ?>,
              comment: comment,
              mark_to: mark_to
            }
          })
          .done(function(respose) {
            if (respose == 1) {
              get_comments();
              $('#comment').val("");
              $('#mark_to').val('');
              $("#marked_yes").prop("checked", false);
              $("#marked_no").prop("checked", true);
              $('#mark_to').hide();
              get_new_requests();
              after_remarks();
            }
          });
      } else {
        $('#error_message').fadeIn('slow');
        $('#error_message').html('Please write comment.');
        $('#error_message').delay(1000).fadeOut('slow');

      }
    }

    function autoheight(x) {
      x.style.height = "5px";
      x.style.height = (15 + x.scrollHeight) + "px";
    }

    function get_comments() {

      $.ajax({
          method: "POST",
          url: "<?php echo site_url('forwarded_requests/get_comments'); ?>",
          data: {
            session_id: <?php echo $session_id; ?>,
            school_id: <?php echo $school_id; ?>,
            schools_id: <?php echo $school->schools_id; ?>
          }
        })
        .done(function(respose) {
          $('#all_comments').html(respose);
        });
    }

    function tage_users() {
      var user_ids = $('#users').val();

      $.ajax({
          method: "POST",
          url: "<?php echo site_url('forwarded_requests/tag_users'); ?>",
          data: {
            session_id: <?php echo $session_id; ?>,
            school_id: <?php echo $school_id; ?>,
            schools_id: <?php echo $school->schools_id; ?>,
            selected_users: user_ids,
          }
        })
        .done(function(respose) {
          if (respose == '1') {
            $('#tag_users_message').fadeIn('slow');
            $('#tag_users_message').html("Officers Tagged.");
            $('#tag_users_message').delay(1000).fadeOut('slow');
          }
        });

    }

    get_comments();
    $("#users").select2({
      placeholder: "Please Select User"
    });
    $("#tag_user").select2({
      placeholder: "Please Select User"
    });
  </script>