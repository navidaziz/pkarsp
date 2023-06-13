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
        <li><a class="btn btn-warning btn-sm" href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Dashboard </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
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
                <strong>List of School Leaving Certificates for Students</strong>
                <button onclick="create_slc()" class="btn btn-success pull-right">Create SLC</button>
              </h3>
              <br />
              <?php if ($school->registrationNumber > 0) { ?>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>SLC Code</th>
                      <th>Admission No</th>
                      <th>Student Name</th>
                      <th>Father Name</th>
                      <th>Gender</th>
                      <th>Date Of Birth</th>
                      <th>Admission Date</th>
                      <th>School leaving Date</th>
                      <th>SLC Issued Date</th>
                      <th>File No</th>
                      <th>SLC Certificate No</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $count = 1;
                    foreach ($slc_list as $student_slc) : ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $student_slc->slc_code; ?></td>
                        <td><?php echo $student_slc->admission_no; ?></td>
                        <td><?php echo $student_slc->student_name; ?></td>
                        <td><?php echo $student_slc->father_name; ?></td>
                        <td><?php echo $student_slc->gender; ?></td>
                        <td><?php echo date('d M, Y', strtotime($student_slc->student_data_of_birth)); ?></td>
                        <td><?php echo $student_slc->admission_date; ?></td>
                        <td><?php echo date('d M, Y', strtotime($student_slc->school_leaving_date)); ?></td>
                        <td><?php echo date('d M, Y', strtotime($student_slc->slc_issue_date)); ?></td>
                        <td><?php echo $student_slc->slc_file_no; ?></td>
                        <td><?php echo $student_slc->slc_certificate_no; ?></td>
                        <td>
                          <a href="<?php echo site_url("students_slcs/edit_student_slc/" . $student_slc->slc_id); ?>">Edit</a>
                          <span style="margin-left:10px ;"></span>
                          <a target="new" href="<?php echo site_url("students_slcs/slc_certificate/" . $student_slc->slc_id); ?>">Print</a>
                        </td>

                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

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


  <script>
    function create_slc() {
      $('#withdrawal_model_title').html("Create Student Leaving Certificate");

      $('#withdrawal').modal('show');
    }
  </script>


  <div id="withdrawal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 70%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title pull-left" id="withdrawal_model_title">Title</h5>
          <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <br />
        </div>
        <div class="modal-body">
          <form action="<?php echo site_url("students_slcs/add_slc") ?>" method="post">
            <input type="hidden" name="school_id" value="<?php echo $school->schools_id; ?>" />
            <?php
            //get current session 
            $query = "SELECT sessionYearId FROM session_year WHERE status=1";
            $session_id = $this->db->query($query)->row()->sessionYearId;
            ?>
            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="student_name">Student Name</label>
                  <input required type="text" class="form-control" name="student_name" placeholder="Student Name">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="father_name">Father Name</label>
                  <input required type="text" class="form-control" name="father_name" placeholder="Father Name">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>


                <div class="form-group">
                  <label for="admission_no">Gender</label>
                  <input required type="radio" value="Male" name="gender" /> Male

                  <input required type="radio" value="Female" name="gender" /> Female
                </div>
                <div class="form-group">
                  <label for="admission_no">Student Data of Birth</label>
                  <input required type="date" class="form-control" name="student_data_of_birth" placeholder="Admission No">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="admission_no">Admission No</label>
                  <input required type="text" class="form-control" name="admission_no" placeholder="Admission No">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="admission_date">Admission Date</label>
                  <input required type="date" class="form-control" name="admission_date" placeholder="Admission Date">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>

              </div>
              <div class="col-md-6">
                <table class="table table-bordered" style="width: 100%;">

                  <tr>
                    <td>Schoool Leaving Date:</td>
                    <td> <input required type="date" required name="school_leaving_date" id="school_leaving_date" value="" />
                    </td>
                  </tr>
                  <tr>
                    <td>SLC Issue Date:</td>
                    <td><input required type="date" required name="slc_issue_date" id="slc_issue_date" value="" /></td>
                  </tr>
                  <tr>
                    <td>SLC File No:</td>
                    <td><input required type="text" required name="slc_file_no" id="slc_file_no" value="" /></td>
                  </tr>
                  <tr>
                    <td>SLC Certificate No:</td>
                    <td><input required type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" /></td>
                  </tr>
                  <tr>
                    <td>Character and Conduct</td>
                    <?php
                    $scales = array("Excellent", "Very Good", "Good", "Fair", "Poor")
                    ?>
                    <td>
                      <?php foreach ($scales as $scale) { ?>
                        <input required type="radio" name="character_and_conduct" value="<?php echo $scale; ?>" required="">
                        <?php echo $scale; ?>
                        <span style="margin-left: 10px;"></span>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Academic Record</td>
                    <td>
                      <?php foreach ($scales as $scale) { ?>
                        <input required type="radio" name="academic_record" value="<?php echo $scale; ?>" required="">
                        <?php echo $scale; ?>
                        <span style="margin-left: 10px;"></span>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>

                    <td colspan="2">
                      In which class is the student currently enrolled?
                      <input required type="text" name="current_class" value="" placeholder="Nursery, KG, Ist etc" />
                      <br />
                      Would you recommend promoting the student to the next class?
                      <input required type="radio" onclick="$('#promation_div').show(); $('#promoted_to_class').attr('required', true)" value="Yes" name="promotion_suggestion" /> Yes

                      <input required type="radio" onclick="$('#promation_div').hide(); $('#promoted_to_class').attr('required', false)" value="No" name="promotion_suggestion" /> No
                      <br />
                      <div style="display: none;" id="promation_div">
                        Promote to class <input type="text" id="promoted_to_class" name="promoted_to_class" value="" placeholder="Nursery, KG, Ist etc" />
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Addmission Withdrawal Reason:</td>
                    <td>
                      <input required style="width: 100%;" type="text" required name="leaving_reason" id="leaving_reason" value="" />
                    </td>
                  </tr>
                  <tr style="text-align: center;">
                    <td colspan="2"><input type="submit" class="btn btn-danger btn-sm" value="Create and Save School Leaving Certificate" /></td>
                  </tr>
                </table>
              </div>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>