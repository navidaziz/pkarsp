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
                <strong>Students Leaving Certificate List</strong>
                <button onclick="create_slc()" class="btn btn-success pull-right">Create SLC</button>
              </h3>
              <br />
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>SLC ID</th>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>Date Of Birth</th>
                    <th>School leaving date</th>
                    <th>SLC Issued Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($slc_list as $student_slc) : ?>
                    <tr>
                      <td><?php echo $student_slc->psra_student_id; ?></td>
                      <td><?php echo $student_slc->slc_id; ?></td>
                      <td><?php echo $student_slc->student_name; ?></td>
                      <td><?php echo $student_slc->student_father_name; ?></td>
                      <td><?php echo date('d M, Y', strtotime($student_slc->student_data_of_birth)); ?></td>
                      <td><?php echo date('d M, Y', strtotime($student_slc->school_leaving_date)); ?></td>
                      <td><?php echo date('d M, Y', strtotime($student_slc->slc_issue_date)); ?></td>
                      <td><?php //echo $student_slc->status;
                          if ($student_slc->status == 1) {
                            echo "Admit";
                          }
                          if ($student_slc->status == 2) {
                            echo "Struck Off";
                          }

                          if ($student_slc->status == 3) {
                            echo "SLC";
                          }

                          ?></td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
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
          <form action="<?php echo site_url(ADMIN_DIR . "admission/withdraw_student") ?>" method="post">


            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="student_name">Student Name</label>
                  <input type="text" class="form-control" name="student_name" placeholder="Student Name">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="father_name">Student Father Name</label>
                  <input type="text" class="form-control" name="father_name" placeholder="Student Father Name">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="admission_no">Admission No</label>
                  <input type="text" class="form-control" name="admission_no" placeholder="Admission No">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="admission_date">Admission Date</label>
                  <input type="text" class="form-control" name="admission_date" placeholder="Admission Date">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>


                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
              </div>
              <div class="col-md-6">
                <table class="table table-bordered" style="width: 100%;">

                  <tr>
                    <td>Schoool Leaving Date:</td>
                    <td> <input type="date" required name="school_leaving_date" id="school_leaving_date" value="" />
                    </td>
                  </tr>
                  <tr>
                    <td>SLC Issue Date:</td>
                    <td><input type="date" required name="slc_issue_date" id="slc_issue_date" value="" /></td>
                  </tr>
                  <tr>
                    <td>SLC File No:</td>
                    <td><input type="text" required name="slc_file_no" id="slc_file_no" value="" /></td>
                  </tr>
                  <tr>
                    <td>SLC Certificate No:</td>
                    <td><input type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" /></td>
                  </tr>
                  <tr>
                    <td>Character and Conduct</td>
                    <?php
                    $scales = array("Excellent", "Very Good", "Good", "Fair", "Poor")
                    ?>
                    <td>
                      <?php foreach ($scales as $scale) { ?>
                        <input type="radio" name="character_and_conduct" value="<?php echo $scale; ?>" required="">
                        <?php echo $scale; ?>
                        <span style="margin-left: 10px;"></span>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Academic Record</td>
                    <td>
                      <?php foreach ($scales as $scale) { ?>
                        <input type="radio" name="academic_record" value="<?php echo $scale; ?>" required="">
                        <?php echo $scale; ?>
                        <span style="margin-left: 10px;"></span>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>

                    <td colspan="2">
                      <?php $query = "SELECT class_title FROM classes WHERE class_id ='" . $students[0]->class_id . "'";
                      $class_name = $this->db->query($query)->result()[0]->class_title;
                      ?>
                      Student is currently in class - <strong><?php echo $class_name; ?>.
                        <input type="hidden" name="current_class" value="<?php echo $class_name; ?>" /> </strong>
                      <?php $query = "SELECT class_id, class_title FROM classes WHERE class_id >= '" . $students[0]->class_id . "' LIMIT 2";
                      $classes = $this->db->query($query)->result();
                      ?>

                      Promote to class
                      <select name="promoted_to_class">
                        <?php foreach ($classes as $class) { ?>
                          <option <?php if ($class->class_id == $students[0]->class_id) { ?> selected <?php } ?> value="<?php echo $class->class_title; ?>"><?php echo $class->class_title; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Withdrawal Reason:</td>
                    <td>
                      <input style="width: 100%;" type="text" required name="withdraw_reason" id="withdraw_reason" value="" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><input type="submit" class="btn btn-danger btn-sm" value="Withdraw Admission" /></td>
                  </tr>
                </table>
              </div>
            </div>
          </form>

        </div>

      </div>
    </div>
  </div>