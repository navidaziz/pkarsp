<div id="re_admit" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="readmit_model_title">Title</h5>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br />
      </div>
      <div class="modal-body">
        <h4 id="re_admit_body">Please Wait .....</h4>
        <p style="text-align: center;">


        <form action="<?php echo site_url(ADMIN_DIR . "admission/re_admit_again") ?>" method="post" style="text-align: center;">
          <input type="hidden" name="student_id" id="studentID" value="" />
          <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
          <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
          Admission No: <input type="text" name="admission_no" id="admission_no" value="" />
          <br />
          Re-Admission Detail:
          <input required type="text" class="form-control" style="margin: 10px;" name="re_admit_again_reason" />
          <input type="submit" class="btn btn-success btn-sm" value="Admit Again" />
        </form>
        </p>
      </div>

    </div>
  </div>
</div>

<script>
  function re_admit(student_id, name, father_name, add_no) {
    $('#readmit_model_title').html("Student Re Admit Form");
    var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
    $('#admission_no').val(add_no);

    $('#studentID').val(student_id);
    $('#re_admit_body').html(body);
    $('#re_admit').modal('show');
  }
</script>

<div id="withdrawal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="withdrawal_model_title">Title</h5>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br />
      </div>
      <div class="modal-body">
        <h4 id="withdrawal_admit_body">Please Wait .....</h4>
        <p style="text-align: center;">
        <form action="<?php echo site_url(ADMIN_DIR . "admission/withdraw_student") ?>" method="post" style="text-align: center;">
          <input type="hidden" name="student_id" id="stID" value="" />
          <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
          <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
          <table class="" style="width: 100%;">

            <tr>
              <th>Admission No:</th>
              <td><input type="text" required name="admission_no" id="adNo" value="" /></td>
            </tr>
            <tr>
              <th>Admission Date:</th>
              <td><input type="date" required name="admission_date" id="add_date" value="" /></td>
            </tr>
            <tr>
              <th>Schoool Leaving Date:</th>
              <td> <input type="date" required name="school_leaving_date" id="school_leaving_date" value="" />
              </td>
            </tr>
            <tr>
              <th>SLC Issue Date:</th>
              <td><input type="date" required name="slc_issue_date" id="slc_issue_date" value="" /></td>
            </tr>
            <tr>
              <th>SLC File No:</th>
              <td><input type="text" required name="slc_file_no" id="slc_file_no" value="" /></td>
            </tr>
            <tr>
              <th>SLC Certificate No:</th>
              <td><input type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" /></td>
            </tr>
            <tr>
              <th>Withdrawal Reason:</th>
              <td>
                <textarea style="width: 100%;" name="withdraw_reason"></textarea>
              </td>
            </tr>
            <tr>
              <td colspan="2"><input type="submit" class="btn btn-danger btn-sm" value="Withdraw" /></td>
            </tr>
          </table>
        </form>
        </p>
      </div>

    </div>
  </div>
</div>

<script>
  function withdraw(student_id, name, father_name, add_no, admission_date) {
    $('#withdrawal_model_title').html("Student Withdraw Form");
    var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + '<br /> Admission Date: ' + admission_date + '<br /> ';
    $('#adNo').val(add_no);
    $('#add_date').val(admission_date);


    $('#stID').val(student_id);
    $('#withdrawal_admit_body').html(body);
    $('#withdrawal').modal('show');
  }
</script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dat aTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url(ADMIN_DIR . "admission/"); ?>"> Admission</a> </li>
        <li><?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> List</li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="col-md-6">
        <div class="clearfix">
          <h3 class="content-title pull-left"> <?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> List</h3>
        </div>
        <div class="description" id="message"></div>
      </div>

    </div>
  </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-12" style="background-color: white; padding: 5px;">

    <table class="table table-bordered" id="main_table" style="font-size:11px !important">
      <thead>

        <tr>

          <td>#</td>
          <th>C/No</th>
          <th>Add. No</th>
          <th>Name</th>

          <th>Father Name</th>
          <!-- <th>DOB</th>
          <th>Address</th>
          <th>Mobile No</th>
          <th>Father NIC</th>
          <th>Guardian Occupation</th>

          <th>Religion</th>
          <th>Nationality</th>
          <th>Admission Date</th>
          <th>Private / Public School</th>
          <th>School Name</th>
          <th>Orphan</th> -->
          <th>Struck Off Reason</th>
          <td>Action</td>

        </tr>
      </thead>
      <tbody>
        <?php
        $students = array();
        $all_sections = $sections;
        foreach ($sections as $section_name => $students) {
          $count = 1;
          foreach ($students as $student) :
        ?>
            <tr>

              <td id="count_number"><?php echo $count++; ?></td>
              <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td>
              <td><span><?php echo $student->student_admission_no; ?></span></td>
              <td><span><?php echo $student->student_name;  ?></span></td>
              <td><?php echo $student->student_father_name;  ?></td>
              <!--<td><?php echo $student->student_data_of_birth; ?> </td>
              <td><?php echo $student->student_address; ?></td>
              <td><?php echo $student->father_mobile_number; ?></td>
              <td><?php echo $student->father_nic; ?></td>
              <td><?php echo $student->guardian_occupation; ?></td>
              <td><?php echo $student->religion; ?></td>
              <td><?php echo $student->nationality; ?></td>
              <td><?php echo $student->private_public_school; ?></td>
              <td><?php echo $student->school_name; ?></td>
              <td><?php echo $student->orphan; ?></td> 

              <td></td>-->
              <td><?php
                  $query = "SELECT sh.`history_type`, sh.remarks, sh.`create_date`, u.user_title 
                             FROM `student_history` as sh, `users` as u 
                             WHERE sh.created_by = u.user_id 
                             AND `history_type`='Struck Off'
                             AND sh.student_id = '" . $student->student_id . "'";
                  $struck_off_detail = $this->db->query($query)->result()[0];

                  ?>
                <i>"<?php echo $struck_off_detail->remarks; ?>" </i><br />
                By <strong><?php echo $struck_off_detail->user_title; ?></strong>
                Dated:
                <?php echo date("d M, Y", strtotime($struck_off_detail->create_date)); ?>
              </td>
              <td> <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>
              </td>

              <td> <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>
              </td>


            </tr>
          <?php endforeach;  ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <script>
    $(document).ready(function() {
      $('#main_table').DataTable({
        "pageLength": 50,
        "lengthChange": false
      });
    });
  </script>


</div>
<!-- /MESSENGER -->
</div>
<script>
  function update_student_info(student_id) {

    var student_class_no = $('#student_class_no_' + student_id).val();
    var student_name = $('#student_name_' + student_id).val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("student/update_student_info") ?>/" + student_id,
      data: {
        student_class_no: student_class_no,
        student_name: student_name
      }
    }).done(function(msg) {
      $('#class_number').html(student_class_no);
      $('#count_number').html(student_class_no);
      $("#message").html(msg);
      $("#message").fadeIn('slow');
      $("#message").delay(5000).fadeOut('slow');

    });

  }





  function update_student_record(student_id, field) {

    var value = $('#' + field + '_' + student_id).val();

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR . "admission/update_student_record") ?>/",
      data: {
        student_id: student_id,
        value: value,
        field: field
      }
    }).done(function(msg) {
      $("#message").html(msg);
      $("#message").fadeIn('slow');
      $("#message").delay(5000).fadeOut('slow');
    });

  }

  function update_student_admission_no(student_id) {

    var student_admission_no = $('#student_admission_no_' + student_id).val();

    $.ajax({
      type: "POST",
      url: "<?php echo site_url("student/update_student_admission_no") ?>/" + student_id,
      data: {
        student_admission_no: student_admission_no
      }
    }).done(function(msg) {
      /*//alert(msg);  
      						$("#message").html(msg);
      						$("#message").fadeIn('slow');
      						$("#message").delay(5000).fadeOut('slow');*/
    });

  }
</script>



<link href="<?php echo site_url(); ?>/assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />