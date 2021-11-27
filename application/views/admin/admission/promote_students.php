<!-- PAGE HEADER-->
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
    <div style="text-align: center; margin: 5px; padding:3px;">
      <form action="<?php echo site_url(ADMIN_DIR . "admission/promote_to_next_section") ?>" method="post">
        <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
        <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />

        <?php  ?>
        Promote Class <?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> Session
        <?php
        $classes = $this->student_model->getList("sessions", "session_id", "session", $where = "`sessions`.`status` = 0");
        echo form_dropdown("current_session", $classes, "", "class=\"form-co ntrol\" required style=\"\"");
        ?>

        Student
        To Class: <?php
                  $classes = $this->student_model->getList("classes", "class_id", "Class_title", $where = "class_id = '" . ($class_id + 1) . "'");
                  echo form_dropdown("to_class", $classes, "", "class=\"form-co ntrol\" required style=\"\"");
                  ?>
        Section
        <?php
        $classes = $this->student_model->getList("sections", "section_id", "section_title", $where = "");
        echo form_dropdown("to_section", $classes, "", "class=\"form-co ntrol\" required style=\"\"");
        ?>

        having session <?php
                        $classes = $this->student_model->getList("sessions", "session_id", "session", $where = "`sessions`.`status` IN(0,1)");
                        echo form_dropdown("new_session", $classes, "", "class=\"form-co ntrol\" required style=\"\"");
                        ?>

        <input type="submit" value="Promote" name="Promote" />
      </form>
    </div>
    </form>
    <table class="table table-bordered" id="main_table" style="font-size:12px !important">
      <thead>

        <tr>
          <td></td>

          <td>#</td>
          <th><?php echo $this->lang->line('student_class_no'); ?></th>
          <th><?php echo $this->lang->line('student_admission_no'); ?></th>
          <th><?php echo $this->lang->line('student_name'); ?></th>

          <th><?php echo $this->lang->line('student_father_name'); ?></th>
          <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
          <th><?php echo $this->lang->line('student_address'); ?></th>
          <th>Father Mobile No</th>
          <th>Father NIC</th>
          <th>Guardian Occupation</th>

          <th>Religion</th>
          <th>Nationality</th>
          <th>Admission Date</th>
          <th>Private / Public School</th>
          <th>School Name</th>
          <th>Orphan</th>

          <th><?php echo $this->lang->line('section_title'); ?></th>
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
            <tr <?php if ($student->status == 0) { ?>style="background-color: coral;" <?php } ?>>
              <td>
                <!-- <a class="btn btn-danger btn-sm" onclick="return confirm('are you sure? may remove student over data?')" href="<?php echo site_url(ADMIN_DIR . "students/remove_student/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student->student_id") ?>" >Remove student</a> -->

                <?php if ($student->status == 0) { ?>
                  <a onclick="return confirm('Are you sure?')" href="<?php echo site_url("student/active_student/$class_id/$section_id/$student->student_id") ?>"><i class="fa fa-undo"></i></a>
                <?php } else { ?>

                  <a onclick="return confirm('Are you sure?')" href="<?php echo site_url("student/dormant_student/$class_id/$section_id/$student->student_id") ?>"><i class="fa fa-times"></i></a>
                <?php   } ?>



              </td>
              <td id="count_number"><?php echo $count++; ?></td>
              <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td>
              <td><span><?php echo $student->student_admission_no; ?></span></td>
              <td><span><?php echo $student->student_name;  ?></span></td>
              <td><?php echo $student->student_father_name;  ?></td>
              <td><?php echo $student->student_data_of_birth; ?> </td>
              <td><?php echo $student->student_address; ?></td>
              <td><?php echo $student->father_mobile_number; ?></td>
              <td><?php echo $student->father_nic; ?></td>
              <td><?php echo $student->guardian_occupation; ?></td>
              <td><?php echo $student->religion; ?></td>
              <td><?php echo $student->nationality; ?></td>
              <td><?php echo $student->private_public_school; ?></td>
              <td><?php echo $student->school_name; ?></td>
              <td><?php echo $student->orphan; ?></td>






              <td><?php //echo $student->section_title; 
                  ?>
                <?php

                $sections = $this->student_model->getList("sections", "section_id", "section_title", $where = "");

                ?>
                <form target="_blank" action="<?php echo site_url("student/update_student_section") ?>" method="post">
                  <input type="hidden" name="student_id" value="<?php echo $student->student_id ?>" />
                  <input type="hidden" name="class_id" value="<?php echo $student->class_id ?>" />
                  <input type="hidden" name="section_id" value="<?php echo $student->section_id ?>" />
                  <?php
                  echo form_dropdown("student_section_id", array("0" => "Select Section") + $sections, "", "class=\"pull-right for m-control\" style=\"width:60px !important\" required  onchange=\"this.form.submit()\" ");
                  ?>
                </form>
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