  <!-- Modal -->
  <script>
    function get_employee_edit_form(employee_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/get_employee_edit_form"); ?>",
        data: {
          employee_id: employee_id,
          schools_id: <?php echo $school->schools_id; ?>,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>

        }
      }).done(function(data) {

        $('#get_employee_edit_form_body').html(data);
      });

      $('#get_employee_edit_form_model').modal('toggle');
    }

    function get_employee_add_form() {
      $('#get_employee_add_form_model').modal('toggle');
    }
  </script>

  <div class="modal fade" id="get_employee_edit_form_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="get_employee_edit_form_body">

        ...

      </div>
    </div>
  </div>
  <div class="modal fade" id="get_employee_add_form_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="">
        <div class="modal-header">
          <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">Add New Employee Detail</h4>
          <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <h5 style="color: red;">Note: All fields are mandatory.</h5>
          <form action="<?php echo site_url("form/add_employee_data"); ?>" method="post">
            <input type="hidden" name="schools_id" value="<?php echo $school->schoolId; ?>" />
            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
            <table class="table table-bordered">

              <tr>
                <th>Designation</th>
                <?php if ($school->school_type_id != 7) { ?>
                  <?php
                  $query = "SELECT COUNT(*) total FROM `school_staff` 
                WHERE  lower(`school_staff`.`schoolStaffDesignition`) = 'principal' 
                AND school_id = '" . $school_id . "'";
                  $total_pricipal = $this->db->query($query)->result()[0]->total;
                  ?>
                  <td><input class="form-control" <?php if ($total_pricipal == 0) { ?> readonly value="Principal" <?php } ?> type="text" name="schoolStaffDesignition" required /></td>
                <?php } else { ?>
                  <?php
                  $query = "SELECT COUNT(*) total FROM `school_staff` 
                WHERE  lower(`school_staff`.`schoolStaffDesignition`) = 'director' 
                AND school_id = '" . $school_id . "'";
                  $total_pricipal = $this->db->query($query)->result()[0]->total;
                  ?>
                  <td><input class="form-control" <?php if ($total_pricipal == 0) { ?> readonly value="Director" <?php } ?> type="text" name="schoolStaffDesignition" required /></td>

                <?php } ?>
              </tr>

              <tr>
                <th>Employee Type</th>
                <td> <select class="form-control" id="schoolStaffType" name="schoolStaffType" required="required">
                    <?php if (!empty($staff_type)) : ?>
                      <option value="">Type</option>
                      <?php foreach ($staff_type as $s_type) : ?>
                        <option value="<?php echo $s_type->staffTypeId ?>"><?php echo $s_type->staffTtitle; ?></option>
                      <?php endforeach; ?>
                    <?php else : ?>
                      No Employee Type Found.
                    <?php endif; ?>
                  </select></td>
              </tr>

              <tr>
                <th>Employee Name</th>
                <td><input class="form-control" type="text" name="schoolStaffName" required /> </td>
              </tr>
              <tr>
                <th> Father / Hasband Name</th>
                <td><input class="form-control" type="text" name="schoolStaffFatherOrHusband" required /> </td>
              </tr>
              <tr>
                <th>Employee CNIC</th>
                <td><input class="form-control" type="text" id="schoolStaffCnic" name="schoolStaffCnic" required /> </td>
              </tr>
              <tr>
                <th>Gender</th>
                <td> <select class="form-control" id="schoolStaffGender" name="schoolStaffGender" required="required">
                    <?php if (!empty($gender)) : ?>
                      <option value="">Gender</option>
                      <?php foreach ($gender as $gen) : ?>
                        <option value="<?php echo $gen->genderId ?>"><?php echo $gen->genderTitle; ?></option>
                      <?php endforeach; ?>
                    <?php else : ?>
                      No gender found.
                    <?php endif; ?>
                  </select></td>
              </tr>



              <?php if ($school->school_type_id == 7) { ?>
                <tr>
                  <th>Job Nature</th>
                  <td><input onclick="$('.gov_sector').attr('required', false); $('.gov_sector').prop('checked', false); $('.gov_noc').prop('checked', false); $('#gov_sector_div').hide(); $('#gov_noc_div').hide();" type="radio" name="job_nature" value="permanent" required /> Permanent Staff
                    <spna style="margin-left: 10px;"></spna>
                    <input onclick="$('.gov_sector').attr('required', true); $('#gov_sector_div').show();" type="radio" name="job_nature" value="visiting" required /> Visiting Staff
                    <br />
                    <div id="gov_sector_div" style="padding: 10px; border:1px solid gray; margin-top: 5px; display:none">
                      <strong>Govt: Sectot Staff </strong>
                      <spna style="margin-left: 15px;"></spna>
                      <input class="gov_sector" onclick="$('.gov_noc').attr('required', true); $('#gov_noc_div').show();" type="radio" name="gov_sector" value="yes" /> Yes
                      <spna style="margin-left: 10px;"></spna>
                      <input class="gov_sector" onclick="$('.gov_noc').attr('required', false); $('.gov_noc').prop('checked', false); $('#gov_noc_div').hide();" type="radio" name="gov_sector" value="no" /> No
                    </div>

                    <div id="gov_noc_div" style="padding: 10px; border:1px solid gray; margin-top: 5px; display:none">
                      <strong>NOC in Case of Govt: Sector Staff: </strong>
                      <spna style="margin-left: 15px;"></spna>
                      <input class="gov_noc" type="radio" name="gov_noc" value="yes" /> Yes
                      <spna style="margin-left: 10px;"></spna>
                      <input class="gov_noc" type="radio" name="gov_noc" value="no" /> No
                    </div>
                  </td>
                </tr>
              <?php } ?>
              <tr>
                <th>Academic Qaulification</th>
                <td><input class="form-control" placeholder="MSc Math, MA urdu etc" type="text" name="schoolStaffQaulificationAcademic" required />
              </tr>
              <tr>
                <th>Professional Qaulification</th>
                </td>
                <td><input class="form-control" min="0" placeholder="PST, CT, B.Ed, M.Ed, TT etc" type="text" name="schoolStaffQaulificationProfessional" />

                </td>
              </tr>
              <?php if ($school->school_type_id != 7) { ?>
                <tr>
                  <th>Professional Training (Months)</th>
                  <td><input class="form-control" min="0" type="number" name="TeacherTraining" /></td>
                </tr>
                <tr>
                  <th>Experience (Months)</th>
                  <td><input class="form-control" min="0" type="number" name="TeacherExperience" /></td>
                </tr>
              <?php } else { ?>
                <input class="form-control" min="0" type="hidden" value="0" name="TeacherTraining" />
                <input class="form-control" min="0" type="hidden" value="0" name="TeacherExperience" />
              <?php } ?>
              <tr>
                <th>Appointment Date</th>
                <td><input class="form-control" type="date" name="schoolStaffAppointmentDate" required /></td>
              </tr>
              <tr>
                <th>Monthly Pay</th>
                <td><input class="form-control" min="0" type="number" name="schoolStaffNetPay" required /></td>
              </tr>
              <?php if ($school->school_type_id != 7) { ?>
                <tr>
                  <th>Annual Increament (%)</th>
                  <td><input class="form-control" min="0" max="100" placeholder="" type="number" name="schoolStaffAnnualIncreament" required /> <strong>%</strong></td>
                </tr>
              <?php } else { ?>
                <input class="form-control" min="0" max="100" placeholder="" type="hidden" value="0" name="schoolStaffAnnualIncreament" required />
              <?php } ?>
              <tr>
                <th>Save</th>
                <td>

                  <input class="btn btn-success btn-sm" type="submit" name="Add" value="Add New Employee" />
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php $this->load->view('forms/form_header');   ?>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <?php $this->load->view('forms/navigation_bar');   ?>


      <div class="box box-primary box-solid">

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-7">
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong><?php echo @$description; ?></strong><br />
                <small style="color: red; display:inline">
                  Note: Please enter details of the Principal, Vice Principal, Teaching and Non-Teaching Staff (Others) of the session: <?php echo $session_detail->sessionYearTitle; ?>.
                </small>

              </h4>
            </div>

            <div class="col-md-5">
              <button onclick="get_employee_add_form()" class="btn btn-danger pull-right">Add New Employee</button>
            </div>
          </div>

          <div class="row">
            <div class="col-md-5">
              <h4>Teaching Staff</h4>
              <?php
              $query = "SELECT COUNT(*) as total FROM `school_staff` 
              WHERE `school_staff`.`schoolStaffType`= 1
              AND `school_staff`.`schoolStaffGender`=1
              AND school_id =" . $school_id;
              $male_teachers = $this->db->query($query)->row()->total;
              $query = "SELECT COUNT(*) as total FROM `school_staff` 
              WHERE `school_staff`.`schoolStaffType`= 1
              AND `school_staff`.`schoolStaffGender`=2
              AND school_id =" . $school_id;
              $female_teachers = $this->db->query($query)->row()->total;
              ?>
              <table class="table table-bordered" style="text-align: center;">
                <tr>
                  <th style="text-align: center;">Male</th>
                  <th style="text-align: center;">Female</th>
                  <th style="text-align: center;">Total</th>
                </tr>
                <tr>
                  <td><strong><?php echo $male_teachers; ?></strong></td>
                  <td><strong><?php echo $female_teachers; ?></strong></td>
                  <td><strong><?php echo $male_teachers + $female_teachers ?></strong></td>
                </tr>
              </table>
            </div>
            <div class="col-md-5">
              <h4>Non Teaching Staff</h4>
              <?php
              $query = "SELECT COUNT(*) as total FROM `school_staff` 
              WHERE `school_staff`.`schoolStaffType`= 2
              AND `school_staff`.`schoolStaffGender`=1
              AND school_id =" . $school_id;
              $male_teachers = $this->db->query($query)->row()->total;
              $query = "SELECT COUNT(*) as total FROM `school_staff` 
              WHERE `school_staff`.`schoolStaffType`= 2
              AND `school_staff`.`schoolStaffGender`=2
              AND school_id =" . $school_id;
              $female_teachers = $this->db->query($query)->row()->total;
              ?>
              <table class="table table-bordered" style="text-align: center;">
                <tr>
                  <th style="text-align: center;">Male</th>
                  <th style="text-align: center;">Female</th>
                  <th style="text-align: center;">Total</th>
                </tr>
                <tr>
                  <td><strong><?php echo $male_teachers; ?></strong></td>
                  <td><strong><?php echo $female_teachers; ?></strong></td>
                  <td><strong><?php echo $male_teachers + $female_teachers ?></strong></td>
                </tr>
              </table>
            </div>
            <div class="col-md-2">
              <h4>Total Staff</h4>
              <?php
              $query = "SELECT COUNT(*) as total FROM `school_staff` 
              WHERE `school_staff`.`schoolStaffType`= 2
              AND `school_staff`.`schoolStaffGender`=1
              AND school_id =" . $school_id;
              $male_teachers = $this->db->query($query)->row()->total;
              $query = "SELECT COUNT(*) as total FROM `school_staff` 
              WHERE  school_id =" . $school_id;
              $total = $this->db->query($query)->row()->total;
              ?>
              <table class="table table-bordered" style="text-align: center;">
                <tr>
                  <th style="text-align: center;">Total</th>
                </tr>
                <tr>
                  <td><strong><?php echo $total; ?></strong></td>
                </tr>
              </table>
            </div>

          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-warning">
                <p style="text-align: center; color:black">
                  The employees data in section E of the institute is automatically retrieved from the previous session. Go through the list and remove any employee who have left the institute and also add new employees.
                </p>
                <p style="text-align: center; color:black">
                  انسٹی ٹیوٹ کے سیکشن (ای) میں ملازمین کا ڈیٹا خود بخود پچھلے سیشن سے حاصل کیا جاتا ہے۔ فہرست کو دیکھیں اور انسٹی ٹیوٹ چھوڑنے والے کسی بھی ملازم کو ہٹا دیں اور نئے ملازمین کو بھی شامل کریں۔
                </p>
              </div>
              <div class="table-responsive" style="background-color: white !important; padding:3px">

                <table class="table" id="employeeTable" style="font-size: 12px; background-color: white; margin-top:5px">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Designation</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>F/Husband Name</th>
                      <th>CNIC</th>
                      <th>Gender</th>

                      <th>Academic Qualification</th>
                      <th>Professional Qualification</th>
                      <?php if ($school->school_type_id != 7) { ?>
                        <th>Training</th>
                        <th>Experience</th>
                      <?php } ?>

                      <th>Appointment At</th>
                      <th>Net.Pay</th>
                      <?php if ($school->school_type_id != 7) { ?>
                        <th>Annual Increament</th>
                      <?php } ?>
                      <?php if ($school->school_type_id == 7) { ?>
                        <th>Job Nature</th>
                        <th>Govt: Sectot Staff</th>
                        <th>Gov: NOC</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="staff_tbody">
                    <?php $counter = 1; ?>
                    <?php if (!empty($school_staff)) : ?>
                      <?php foreach ($school_staff as $st) : ?>
                        <tr id="staff_row_<?php echo $st->schoolStaffId; ?>">
                          <td><?php echo $counter; ?></td>
                          <td><?php echo $st->schoolStaffDesignition; ?></td>
                          <td><?php echo $st->staffTtitle; ?></td>
                          <td><?php echo $st->schoolStaffName; ?></td>
                          <td><?php echo $st->schoolStaffFatherOrHusband; ?></td>
                          <td><?php echo $st->schoolStaffCnic; ?></td>
                          <td><?php echo $st->genderTitle; ?></td>

                          <td><?php echo $st->schoolStaffQaulificationAcademic; ?></td>
                          <td><?php echo $st->schoolStaffQaulificationProfessional; ?></td>
                          <?php if ($school->school_type_id != 7) { ?>
                            <td><?php echo $st->TeacherTraining; ?> (M)</td>
                            <td><?php echo $st->TeacherExperience; ?> (M)</td>
                          <?php } ?>

                          <td><?php echo $st->schoolStaffAppointmentDate; ?></td>
                          <td><?php echo $st->schoolStaffNetPay; ?></td>
                          <?php if ($school->school_type_id != 7) { ?>

                            <td><?php echo $st->schoolStaffAnnualIncreament; ?> <strong>%</strong></td>
                          <?php } ?>
                          <?php if ($school->school_type_id == 7) { ?>
                            <td><?php echo $st->job_nature; ?></td>
                            <td><?php echo $st->gov_sector; ?></td>
                            <td><?php echo $st->gov_noc; ?></td>
                          <?php } ?>
                          <td>
                            <?php if ($school->status != 1) { ?>
                              <a href="javascript:void(0);" onclick="get_employee_edit_form(<?php echo $st->schoolStaffId; ?>)">
                                &nbsp;<i class="fa fa-edit"></i></a>
                              <a href="<?php echo site_url("form/delete_employee/$st->schoolStaffId/$school_id/$session_id"); ?>" title="Delete Employee" onclick="return confirm('Are you sure? you want to remove the employee?')"> &nbsp;<i class="fa fa-trash-o text-danger"></i>
                              </a>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php $counter++; ?>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <td colspan="15" id="empty_td_staff">

                      </td>
                    <?php endif; ?>
                  </tbody>
                </table>
                <script>
                  $(document).ready(function() {
                    $('#employeeTable').DataTable({
                      "paging": false,
                      "info": false
                    });

                  });
                </script>
                <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
                <style>
                  .dataTables_filter {
                    margin-bottom: 10px;
                  }
                </style>

              </div>

            </div>


          </div>

          <div style="font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

            <div class="row">
              <div class="col-md-4">
                <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/section_c/$school_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Students Enrollment ) </a>

              </div>
              <div class="col-md-4">
                <?php if (count($school_staff) >= 3 and $form_status->form_d_status == 0) { ?>
                  <a href="<?php echo site_url("form/complete_section_d/$school_id"); ?>" class="btn btn-primary" style="margin: 2px;">Add Section D Data</a>
                <?php } ?>
              </div>
              <div class="col-md-4">
                <?php if ($form_status->form_d_status == 1) { ?>
                  <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/section_e/$school_id"); ?>">
                    Next Section ( School Fee Detail )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                <?php } ?>
              </div>

            </div>
          </div>
        </div>


      </div>

  </div>
  </section>

  </div>

  <script>
    $(document).ready(function() {
      $('#schoolStaffCnic').inputmask('99999-9999999-9');

    });
  </script>