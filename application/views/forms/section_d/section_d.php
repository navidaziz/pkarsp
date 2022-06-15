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
  </script>
  <div class="modal fade" id="get_employee_edit_form_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="get_employee_edit_form_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;">
        <?php echo ucwords(strtolower($school->schoolName)); ?>
      </h2>
      <br />
      <h4>S-ID: <?php echo $school->schools_id; ?>
        <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <?php $this->load->view('forms/navigation_bar');   ?>

      <div class="box box-primary box-solid">

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">

            <div class="col-md-12">



              <p>
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong><?php echo @$description; ?></strong><br />
                <small style="color: red;">
                  Note: Please enter details of the Principal, Vice Principal, Teaching and Non-Teaching Staff (Others) of the session: <?php echo $session_detail->sessionYearTitle; ?>.
                </small>
              </h4>

              </small>
              </p>

              <style>
                .table>tbody>tr>td,
                .table>tbody>tr>th,
                .table>tfoot>tr>td,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>thead>tr>th {
                  padding: 1px !important;
                }
              </style>

              <form action="<?php echo site_url("form/add_employee_data"); ?>" method="post">
                <input type="hidden" name="schools_id" value="<?php echo $school->schoolId; ?>" />
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                <?php
                $query = "SELECT COUNT(*) total FROM `school_staff` 
                WHERE  lower(`school_staff`.`schoolStaffDesignition`) = 'principal' 
                AND school_id = '" . $school_id . "'";
                $total_pricipal = $this->db->query($query)->result()[0]->total;
                ?>


                <table class="table">

                  <thead>

                    <tr>
                      <td>#</th>
                      <td>Name</th>
                      <td>F/Husband Name</th>
                      <td>CNIC</th>
                      <td>Gender</th>
                      <td>Type</th>
                      <td>Academic Qualification</th>
                      <td>Professional Qualification</th>
                      <td>Training In Months</th>
                      <td>Experience In Months</th>
                      <td>Designation</th>
                      <td>Appointment At</th>
                      <td>Net.Pay</th>
                      <td>Annual Increament</th>
                      <td>Action</th>
                    </tr>

                  </thead>
                  <tbody id="staff_tbody">

                    <tr>
                      <td>#</td>
                      <td><input type="text" name="schoolStaffName" style="width: 130px;" required /> </th>
                      <td><input type="text" name="schoolStaffFatherOrHusband" style="width: 130px;" required /> </td>
                      <td><input type="text" id="schoolStaffCnic" name="schoolStaffCnic" style="width: 110px;" required /> </td>
                      <td> <select class="sele ct2" id="schoolStaffGender" name="schoolStaffGender" required="required">
                          <?php if (!empty($gender)) : ?>
                            <option value="">Gender</option>
                            <?php foreach ($gender as $gen) : ?>
                              <option value="<?php echo $gen->genderId ?>"><?php echo $gen->genderTitle; ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            No gender found.
                          <?php endif; ?>
                        </select></td>
                      <td> <select style="width: 70px;" class="sele ct2" id="schoolStaffType" name="schoolStaffType" required="required">
                          <?php if (!empty($staff_type)) : ?>
                            <option value="">Type</option>
                            <?php foreach ($staff_type as $s_type) : ?>
                              <option value="<?php echo $s_type->staffTypeId ?>"><?php echo $s_type->staffTtitle; ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            No Staff Type Found.
                          <?php endif; ?>
                        </select></td>
                      <td><input placeholder="MSc Math, MA urdu etc" type="text" name="schoolStaffQaulificationAcademic" style="width: 70px;" required />

                      </td>
                      <td><input min="0" placeholder="PST, CT, B.Ed, M.Ed, TT etc" type="text" name="schoolStaffQaulificationProfessional" style="width: 70px;" />

                      </td>
                      <td><input min="0" type="number" name="TeacherTraining" style="width: 70px;" /></td>
                      <td><input min="0" type="number" name="TeacherExperience" style="width: 70px;" /></td>
                      <td><input <?php if ($total_pricipal == 0) { ?> readonly value="Principal" <?php } ?> type="text" name="schoolStaffDesignition" style="width: 70px;" required /></td>
                      <td><input type="date" name="schoolStaffAppointmentDate" style="width: 122px;" required /></td>
                      <td><input min="0" type="number" name="schoolStaffNetPay" style="width: 70px;" required /></td>
                      <td><input min="0" max="100" placeholder="" type="number" name="schoolStaffAnnualIncreament" style="width: 50px;" required /> <strong>%</strong></td>

                      <td>

                        <input class="btn btn-success btn-sm" type="submit" name="Add" value="Add New" />
                      </td>
                    </tr>
                    <?php $counter = 1; ?>
                    <?php if (!empty($school_staff)) : ?>
                      <?php foreach ($school_staff as $st) : ?>
                        <tr id="staff_row_<?php echo $st->schoolStaffId; ?>">
                          <td><?php echo $counter; ?></td>
                          <td><?php echo $st->schoolStaffName; ?></td>
                          <td><?php echo $st->schoolStaffFatherOrHusband; ?></td>
                          <td><?php echo $st->schoolStaffCnic; ?></td>
                          <td><?php echo $st->genderTitle; ?></td>
                          <td><?php echo $st->staffTtitle; ?></td>
                          <td><?php echo $st->schoolStaffQaulificationAcademic; ?></td>
                          <td><?php echo $st->schoolStaffQaulificationProfessional; ?></td>
                          <td><?php echo $st->TeacherTraining; ?></td>
                          <td><?php echo $st->TeacherExperience; ?></td>
                          <td><?php echo $st->schoolStaffDesignition; ?></td>
                          <td><?php echo $st->schoolStaffAppointmentDate; ?></td>
                          <td><?php echo $st->schoolStaffNetPay; ?></td>
                          <td><?php echo $st->schoolStaffAnnualIncreament; ?></td>
                          <td>
                            <?php if ($school->status != 1) { ?>
                              <a href="javascript:void(0);" onclick="get_employee_edit_form(<?php echo $st->schoolStaffId; ?>)">
                                &nbsp;<i class="fa fa-edit"></i></a>
                              <a href="<?php echo site_url("form/delete_employee/$st->schoolStaffId/$school_id/$session_id"); ?>" title="Delete Staff" onclick="return confirm('Are you sure? you want to remove the employee?')"> &nbsp;<i class="fa fa-trash-o text-danger"></i>
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

              </form>



            </div>

            <div class="col-md-12">
              <div style="font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 50px;  margin: 10px; padding: 10px; background-color: white;">
                <a class="btn btn-success pull-left" href="<?php echo site_url("form/section_c/$school_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Students Enrollment ) </a>
                <?php if (count($school_staff) >= 3 and $form_status->form_d_status == 0) { ?>
                  <a href="<?php echo site_url("form/complete_section_d/$school_id"); ?>" class="btn btn-primary">Add Section D Data</a>
                <?php } else { ?>

                <?php } ?>
                <?php if ($form_status->form_d_status == 1) { ?>
                  <a class="btn btn-success pull-right" href="<?php echo site_url("form/section_e/$school_id"); ?>">
                    Next Section ( School Fee Detail )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                  <br />
                <?php } else {
                  echo "<br />";
                } ?>

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