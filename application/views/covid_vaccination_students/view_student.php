<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      COVID-19 Vaccination Report of Students Age 12+
    </h2><br />
    <small><?php echo ucwords(strtolower($school->schoolName)); ?></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
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
          <div class="col-md-2">

            <form action="<?php echo site_url("covid_vaccination_students/add_new_student"); ?>" method="POST" style="padding: 5px;">
              <input type="hidden" name="class_id" value="1" />
              <input type="hidden" name="section_id" value="1" />
              <input type="hidden" name="student_class_no" value="1" />
              <div style=" font-size: 12px; border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 10px; padding: 10px; background-color: white;">

                <h4>Add Student</h4>
                <strong> Addmission No: </strong>
                <input style="width:100% !important; " type="text" name="student_admission_no" value="" required />
                <br />
                <strong> Student Name </strong>
                <br />
                <input style="width:100% !important; " type="text" name="student_name" value="" required />
                <br />
                <strong> Father Name </strong>
                <br />
                <input style="width:100% !important; " type="text" name="student_father_name" value="" required />
                <br />
                <strong> Father CNIC</strong>
                <br />
                <input style="width:100% !important; " type="text" id="father_nic" name="father_nic" value="" required />
                <br />
                <strong> Form B No.</strong>
                <br />
                <input style="width:100% !important; " id="form_b" type="text" id="form_b" name="form_b" value="" />
                <br />
                <strong> Date Of Birth
                </strong>
                <br />
                <input style="width:100% !important; " type="date" name="student_data_of_birth" value="" required />

                <br /><strong>Gender:</strong><br />
                <input type="radio" name="gender" value="Male" required /> Male
                <span style="margin-left: 10px;"></span>
                <input type="radio" name="gender" value="Female" required /> Female
                <br /><strong>Vaccinated</strong><br />
                <input onclick="$('.dose_date').show();$('#remarks').hide();  $('#first_dose').prop('required', true); $('.remarks_filed').prop('required', false)" type="radio" name="vaccinated" value="Yes" required /> Yes
                <span style="margin-left: 10px;"></span>
                <input onclick="$('.dose_date').hide();$('#remarks').show();  $('#first_dose').prop('required', false); $('.remarks_filed').prop('required', true)" type="radio" name="vaccinated" value="No" required /> No
                <div class="dose_date">

                  <strong> Ist Dose
                  </strong>
                  <br />
                  <input id="first_dose" style="width: 125px;" type="date" name="first_dose" value="" />
                  <br />
                  <strong> 2nd Dose
                  </strong>
                  <br />
                  <input id="second_dose" style="width: 125px;" type="date" name="second_dose" value="" />
                  <br />
                </div>
                <div id="remarks" style="display: none;">
                  Remarks<br />
                  <input onclick="$('#Other_remarks').hide(); $('#other_field').prop('required', false)" class="remarks_filed" type="radio" name="remarks" value="parent refusal" /> Parent Refusal <br />
                  <input onclick="$('#Other_remarks').hide(); $('#other_field').prop('required', false)" class="remarks_filed" type="radio" name="remarks" value="Team not Visit" /> Team not Visit <br />
                  <input onclick="$('#Other_remarks').show();$('#other_field').prop('required', true)" class="remarks_filed" type="radio" name="remarks" value="Other" /> Other <br />
                  <span id="Other_remarks" style="display: none;">

                    <input style="width: 100%;" id="other_field" type="text" name="other_remarks" />
                    <br />
                  </span>
                </div>
                <br />
                <span style="text-align: center;">
                  <input class="btn btn-danger btn-sm" type="submit" value="Add Student Report" name="Add Student" />
                </span>
              </div>
            </form>
          </div>

          <div class="col-md-10">
            <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"> COVID-19 Vaccination Report of Students Age 12+</h4>
            <table class="table" id="main_table" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Adm. No</th>
                  <th>Student Name</th>
                  <th>Father Name</th>
                  <th>Father CNIC</th>
                  <th>Form B</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Viccinated</th>
                  <th>1st Dose</th>
                  <th>2nd Dose</th>
                  <th>Remarks</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1;
                foreach ($students as $student) : ?>
                  <tr>
                    <td><a style="color: #F7C6C5;" onclick="return confirm('Are your sure you want to delete student record?')" href="<?php echo site_url("covid_vaccination_students/delete/$student->student_id"); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a> <?php echo $count++; ?></td>
                    <td><span><?php echo $student->student_admission_no; ?></span></td>
                    <td><span><?php echo $student->student_name;  ?></span></td>
                    <td><?php echo $student->student_father_name;  ?></td>
                    <td><?php echo $student->father_nic; ?></td>
                    <td><?php echo $student->form_b; ?> </td>
                    <td><?php echo date('d-m-y', strtotime($student->student_data_of_birth)); ?> </td>
                    <td><?php echo $student->gender;  ?></td>
                    <td><?php echo $student->vaccinated; ?> </td>
                    <td><?php
                        if ($student->first_dose != '') {
                          echo date('d-m-y', strtotime($student->first_dose));
                        }  ?></td>
                    <td><?php
                        if ($student->second_dose != '') {
                          echo date('d-m-y', strtotime($student->second_dose));
                        }  ?>
                    </td>
                    <td><?php echo $student->remarks; ?> </td>

                    <td>
                      <a href="#" onclick="update_profile('<?php echo $student->student_id; ?>')">Update</a>
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