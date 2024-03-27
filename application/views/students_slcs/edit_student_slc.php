  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content-header">
      <h2 style="display:inline;"><?php echo ucwords(strtolower($school->schoolName)); ?>
        <small style="margin-left: 5px;"> (<?php
                                            $query = "SELECT typeTitle FROM `school_type` WHERE typeId = '" . $school->school_type_id . "'";
                                            $school_type = $this->db->query($query)->row()->typeTitle;
                                            echo $school_type; ?>)
        </small>
      </h2>
      <br />
      <small>
        <h4>Institute ID: <?php echo $school->schools_id; ?> <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      </small>
      <ol class="breadcrumb">
        <li><a class="btn btn-warning btn-sm" href="<?php echo site_url('students_slcs'); ?>"> <i class="fa fa-arrow-left" aria-hidden="true"></i> SLC Lists </a></li>
        <li class="active"><?php echo @ucfirst($title); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <div class="box box-primary box-solid">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <h3 style="border-left: 20px solid #9FC8E8; padding-left:5px">
                <strong><?php echo $title; ?></strong>
              </h3>
              <br />
              <?php if ($school->registrationNumber > 0) { ?>
                <form action="<?php echo site_url("students_slcs/update_slc") ?>" method="post">
                  <input type="hidden" name="school_id" value="<?php echo $school->schools_id; ?>" />
                  <input type="hidden" name="slc_id" value="<?php echo $student_slc->slc_id; ?>" />
                  <?php
                  //get current session 
                  $query = "SELECT sessionYearId FROM session_year WHERE status=1";
                  $session_id = $this->db->query($query)->row()->sessionYearId;
                  ?>
                  <input type="hidden" name="session_id" value="<?php echo $student_slc->session_id; ?>" />

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="student_name">Student Name</label>
                        <input required type="text" class="form-control" value="<?php echo $student_slc->student_name; ?>" name="student_name" placeholder="Student Name">
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                      </div>
                      <div class="form-group">
                        <label for="father_name">Father Name</label>
                        <input required type="text" class="form-control" value="<?php echo $student_slc->father_name; ?>" name="father_name" placeholder="Father Name">
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                      </div>


                      <div class="form-group">
                        <label for="admission_no">Gender</label>
                        <input required type="radio" value="Male" name="gender" <?php if ($student_slc->gender == 'Male') {
                                                                                  echo 'checked';
                                                                                } ?> /> Male

                        <input required type="radio" value="Female" name="gender" <?php if ($student_slc->gender == 'Female') {
                                                                                    echo 'checked';
                                                                                  } ?> /> Female
                      </div>
                      <div class="form-group">
                        <label for="admission_no">Student Data of Birth</label>
                        <input required type="date" class="form-control" value="<?php echo $student_slc->student_data_of_birth; ?>" name="student_data_of_birth" placeholder="Admission No">
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                      </div>
                      <div class="form-group">
                        <label for="admission_no">Admission No</label>
                        <input required type="text" class="form-control" value="<?php echo $student_slc->admission_no; ?>" name="admission_no" placeholder="Admission No">
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                      </div>
                      <div class="form-group">
                        <label for="admission_date">Admission Date</label>
                        <input required type="date" class="form-control" value="<?php echo $student_slc->admission_date; ?>" name="admission_date" placeholder="Admission Date">
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                      </div>

                    </div>
                    <div class="col-md-6">
                      <table class="table table-bordered" style="width: 100%;">

                        <tr>
                          <td>Schoool Leaving Date:</td>
                          <td> <input required type="date" required value="<?php echo $student_slc->school_leaving_date; ?>" name="school_leaving_date" id="school_leaving_date" />
                          </td>
                        </tr>
                        <tr>
                          <td>SLC Issue Date:</td>
                          <td><input required type="date" required value="<?php echo $student_slc->slc_issue_date; ?>" name="slc_issue_date" id="slc_issue_date" /></td>
                        </tr>
                        <tr>
                          <td>SLC File No:</td>
                          <td><input required type="text" required value="<?php echo $student_slc->slc_file_no; ?>" name="slc_file_no" id="slc_file_no" /></td>
                        </tr>
                        <tr>
                          <td>SLC Certificate No:</td>
                          <td><input required type="text" required value="<?php echo $student_slc->slc_certificate_no; ?>" name="slc_certificate_no" id="slc_certificate_no" /></td>
                        </tr>
                        <tr>
                          <td>Character and Conduct</td>
                          <?php
                          $scales = array("Excellent", "Very Good", "Good", "Fair", "Poor")
                          ?>
                          <td>
                            <?php foreach ($scales as $scale) { ?>
                              <input <?php if ($student_slc->character_and_conduct == $scale) {
                                        echo 'checked';
                                      } ?> required type="radio" name="character_and_conduct" value="<?php echo $scale; ?>">
                              <?php echo $scale; ?>
                              <span style="margin-left: 10px;"></span>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Academic Record</td>
                          <td>
                            <?php foreach ($scales as $scale) { ?>
                              <input <input <?php if ($student_slc->academic_record == $scale) {
                                              echo 'checked';
                                            } ?> required type="radio" name="academic_record" value="<?php echo $scale; ?>">
                              <?php echo $scale; ?>
                              <span style="margin-left: 10px;"></span>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>

                          <td colspan="2">
                            In which class is the student currently enrolled?
                            <input required type="text" name="current_class" value="<?php echo $student_slc->current_class; ?>" placeholder="Nursery, KG, Ist etc" />
                            <br />
                            Would you recommend promoting the student to the next class?
                            <input <?php if ($student_slc->promoted_to_class) {
                                      echo 'checked';
                                    } ?> required type="radio" onclick="$('#promation_div').show(); $('#promoted_to_class').attr('required', true)" value="Yes" name="promotion_suggestion" /> Yes

                            <input <?php if (!$student_slc->promoted_to_class) {
                                      echo 'checked';
                                    } ?> required type="radio" onclick="$('#promation_div').hide(); $('#promoted_to_class').attr('required', false)" value="No" name="promotion_suggestion" /> No
                            <br />
                            <div style="display: none;" id="promation_div">
                              Promote to class <input type="text" id="promoted_to_class" name="promoted_to_class" value="<?php echo $student_slc->promoted_to_class; ?>" placeholder="Nursery, KG, Ist etc" />
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Addmission Withdrawal Reason:</td>
                          <td>
                            <input required style="width: 100%;" type="text" required name="leaving_reason" id="leaving_reason" value="<?php echo $student_slc->leaving_reason; ?>" />
                          </td>
                        </tr>
                        <tr style="text-align: center;">
                          <td colspan="2"><input type="submit" class="btn btn-success btn-sm" value="Update School Leaving Certificate" /></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </form>

              <?php } else { ?>
                <h4>
                  The online <strong>school leaving certificate system </strong> is exclusively accessible to registered schools only.
                </h4>

              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>