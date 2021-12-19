<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small>COVID-19 Vaccination Report of Students Age 12+</small>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url("admin/admission"); ?>">Admission</a></li>
      <li><a href="">COVID-19 Vaccination Report of Students Age 12+</a></li>
    </ol>
  </section>
  <style>
    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 2px;
    }
  </style>
  <!-- Main content -->
  <section class="content ">
    <div class="box box-primary box-solid">
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <h4><i class="fa fa-plus" aria-hidden="true"></i>Add Student</h4>
            <form action="<?php echo site_url("covid_vaccination_students/add_new_student"); ?>" method="POST" style="padding: 5px;">
              <input type="hidden" name="class_id" value="1" />
              <input type="hidden" name="section_id" value="1" />
              <input style="width:20px !important" type="hidden" name="student_class_no" value="1" />

              <table class="table">
                <thead>
                  <tr>
                    <td>
                      <strong> Addmission No: </strong>
                    </td>
                    <td>
                      <input style="width:90px !important; " type="text" name="student_admission_no" value="" required />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong> Student Name </strong>
                    </td>
                    <td>
                      <input type="text" name="student_name" value="" required />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong> Father Name </strong>
                    </td>
                    <td>
                      <input type="text" name="student_father_name" value="" required />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong> Father CNIC</strong>
                    </td>
                    <td>
                      <input style="width:110px !important; " type="text" id="father_nic" name="father_nic" value="" required />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong> Form B No.</strong>
                    </td>
                    <td>
                      <input style="width:110px !important; " id="form_b" type="text" id="form_b" name="form_b" value="" />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong> Date Of Birth
                      </strong>
                    </td>
                    <td>
                      <input min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="student_data_of_birth" value="" required />

                    </td>
                  </tr>
                  <tr>
                    <td><strong>Gender:</strong></td>
                    <td>
                      <input type="radio" name="gender" value="Male" required /> Male
                      <span style="margin-left: 10px;"></span>
                      <input type="radio" name="gender" value="Female" required /> Female
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Vaccinated</strong></td>
                    <td>
                      <input onclick="$('.dose_date').show();$('#remarks').hide();  $('#first_dose').prop('required', true); $('.remarks_filed').prop('required', false)" type="radio" name="vaccinated" value="Yes" required /> Yes
                      <span style="margin-left: 10px;"></span>
                      <input onclick="$('.dose_date').hide();$('#remarks').show();  $('#first_dose').prop('required', false); $('.remarks_filed').prop('required', true)" type="radio" name="vaccinated" value="No" required /> No
                    </td>
                  </tr>
                  <tr class="dose_date">
                    <td>
                      <strong> Ist Dose
                      </strong>
                    </td>
                    <td>
                      <input id="first_dose" min="" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="first_dose" value="" />

                    </td>
                  </tr>
                  <tr class="dose_date">
                    <td>
                      <strong> 2nd Dose
                      </strong>
                    </td>
                    <td>
                      <input id="second_dose" min="" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="second_dose" value="" />

                    </td>
                  </tr>
                  <tr id="remarks" style="display: none;">
                    <td>Remarks</td>
                    <td>
                      <input onclick="$('#Other_remarks').hide(); $('#other_field').prop('required', false)" class="remarks_filed" type="radio" name="remarks" value="parent refusal" /> Parent Refusal <br />
                      <input onclick="$('#Other_remarks').hide(); $('#other_field').prop('required', false)" class="remarks_filed" type="radio" name="remarks" value="Team not Visit" /> Team not Visit <br />
                      <input onclick="$('#Other_remarks').show();$('#other_field').prop('required', true)" class="remarks_filed" type="radio" name="remarks" value="Other" /> Other <br />
                      <span id="Other_remarks" style="display: none;">

                        <input id="other_field" type="text" name="other_remarks" />
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: center; vertical-align: middle;">
                      <input class="btn btn-danger btn-sm" type="submit" value="Add New Student" name="Add Student" />
                    </td>
                  </tr>

                </thead>
                <tbody>


                </tbody>
              </table>
            </form>
          </div>

          <div class="col-md-9">
            <h4> COVID-19 Vaccination Report of Students Age 12+</h4>
            <table class="table" id="main_table" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Admission No</th>
                  <th>Student Name</th>
                  <th>Father Name</th>
                  <th>Father CNIC</th>
                  <th>Form B</th>
                  <th>Date of Birth</th>
                  <th>Gender</th>
                  <th>Viccinated</th>
                  <th>First Dose</th>
                  <th>2nd Dose</th>
                  <th>Remarks</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($students as $student) : ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><span><?php echo $student->student_admission_no; ?></span></td>
                    <td><span><?php echo $student->student_name;  ?></span></td>
                    <td><?php echo $student->student_father_name;  ?></td>
                    <td><?php echo $student->father_nic; ?></td>
                    <td><?php echo $student->form_b; ?> </td>
                    <td><?php echo $student->student_data_of_birth; ?> </td>
                    <td><?php echo $student->gender;  ?></td>
                    <td><?php echo $student->vaccinated; ?> </td>
                    <td><?php echo $student->first_dose; ?> </td>
                    <td><?php echo $student->second_dose;  ?> </td>
                    <td><?php echo $student->remarks; ?> </td>

                    <td>
                      <a href="#" onclick="update_profile('<?php echo $student->student_id; ?>')"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                    </td>

                  </tr>
                <?php endforeach;  ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div id="general_model" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="general_model_body">


    </div>
  </div>
</div>

<script>
  function update_profile(student_id) {
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("covid_vaccination_students/update_student_profile"); ?>",
      data: {
        student_id: student_id,
        class_list: 'class_list'
      }
    }).done(function(data) {

      $('#general_model_body').html(data);
    });

    $('#general_model').modal('show');
  }
</script>


<script>
  $(document).ready(function() {
    $('#father_mobile_number').inputmask('(9999)-9999999');
    $('#father_nic').inputmask('99999-9999999-9');
    $('#form_b').inputmask('99999-9999999-9');

  });
</script>

<script>
  // $(document).ready(function() {
  //   $('#main_table').DataTable({
  //     "bPaginate": false,
  //     dom: 'Bfrtip',
  //     buttons: [
  //       'print'
  //     ]
  //   });
  // });
  $(document).ready(function() {
    $('#main_table').DataTable({
      "bPaginate": false,
      dom: 'Bfrtip',
      buttons: [
        'print', 'copy', 'excel', 'pdf'
      ]
    });
  });
</script>






<link href="<?php echo site_url(); ?>/assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />