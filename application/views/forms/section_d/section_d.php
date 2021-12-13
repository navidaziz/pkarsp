  <!-- Modal -->
  <script>
    function get_employee_edit_form(employee_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/get_employee_edit_form"); ?>",
        data: {
          employee_id: employee_id,
          schools_id: <?php echo $school->schoolId; ?>,
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
      <h4>S-ID: <?php echo $school->schools_id; ?> - REG No: <?php echo $school->registrationNumber ?></h4>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php $this->load->view('forms/navigation_bar');   ?>

      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo @$description; ?></h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">

            <div class="col-md-12">



              <p>
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong><?php echo @$description; ?></strong><br />
                <small style="color: red;">
                  Note:
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
                  padding: 5px !important;
                }
              </style>

              <form action="<?php echo site_url("form/add_employee_date"); ?>" method="post">
                <input type="hidden" name="schools_id" value="<?php echo $school->schoolId; ?>" />
                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>F/Husband Name</th>
                      <th>CNIC</th>
                      <th>Gender</th>
                      <th>Type</th>
                      <th>Academic</th>
                      <th>Professional</th>
                      <th>Training In Months</th>
                      <th>Experience In Months</th>
                      <th>Designation</th>
                      <th>Appointment At</th>
                      <th>Net.Pay</th>
                      <th>Annual Increament</th>
                      <th>Action</th>
                    </tr>

                  </thead>
                  <tbody id="staff_tbody">
                    <tr>
                      <td>#</td>
                      <td><input type="text" name="schoolStaffName" style="widtd: 130px;" required /> </th>
                      <td><input type="text" name="schoolStaffFatherOrHusband" style="width: 130px;" required /> </td>
                      <td><input type="text" id="schoolStaffCnic" name="schoolStaffCnic" style="width: 110px;" required /> </td>
                      <td> <select class="sele ct2" id="schoolStaffGender" name="schoolStaffGender" required="required">
                          <?php if (!empty($gender)) : ?>
                            <option>Gender</option>
                            <?php foreach ($gender as $gen) : ?>
                              <option value="<?php echo $gen->genderId ?>"><?php echo $gen->genderTitle; ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            No gender found.
                          <?php endif; ?>
                        </select></td>
                      <td> <select style="width: 70px;" class="sele ct2" id="schoolStaffType" name="schoolStaffType" required="required">
                          <?php if (!empty($staff_type)) : ?>
                            <option>Type</option>
                            <?php foreach ($staff_type as $s_type) : ?>
                              <option value="<?php echo $s_type->staffTypeId ?>"><?php echo $s_type->staffTtitle; ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            No Staff Type Found.
                          <?php endif; ?>
                        </select></td>
                      <td><input type="text" name="schoolStaffQaulificationAcademic" style="width: 70px;" required /></td>
                      <td><input type="text" name="schoolStaffQaulificationProfessional" style="width: 70px;" required /></td>
                      <td><input type="number" name="TeacherTraining" style="width: 70px;" required /></td>
                      <td><input type="number" name="TeacherExperience" style="width: 70px;" required /></td>
                      <td><input type="text" name="schoolStaffDesignition" style="width: 70px;" required /></td>
                      <td><input type="date" name="schoolStaffAppointmentDate" style="width: 122px;" required /></td>
                      <td><input type="number" name="schoolStaffNetPay" style="width: 70px;" required /></td>
                      <td><input placeholder="10%, 20% etc" type="text" name="schoolStaffAnnualIncreament" style="width: 50px;" required /></td>

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
                        <h5 style="color:red;">Record Not Found.</h5>
                      </td>
                    <?php endif; ?>
                  </tbody>
                </table>

              </form>



            </div>

            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <a class="btn btn-link pull-left" href="<?php echo site_url("form/section_c/$session_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Section C ( Students Enrolment ) </a>
                <input class="btn btn-primary" type="submit" name="" value="Add Section D Data" />
                <a class="btn btn-link pull-right" href="<?php echo site_url("form/section_e/$session_id"); ?>">
                  Section E ( School Fee Detail )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
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