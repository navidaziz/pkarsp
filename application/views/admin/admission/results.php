<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url(ADMIN_DIR . "admission/"); ?>"> Admission</a> </li>
        <li><?php if ($class_id) { ?>
            <?php echo $students[0]->Class_title . ""; ?>
          <?php } ?>
          <?php if ($section_id) { ?>
            <?php echo $students[0]->section_title . ""; ?>
          <?php } ?>
          <?php echo $title; ?> List</li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="col-md-6">
        <div class="clearfix">
          <h3 class="content-title pull-left">

            <?php if ($class_id) { ?>
              <?php echo $students[0]->Class_title . ""; ?>
            <?php } ?>
            <?php if ($section_id) { ?>
              <?php echo $students[0]->section_title . ""; ?>
            <?php } ?>
            <?php echo $title; ?> List</h3>
        </div>
        <div class="description" id="message"></div>
      </div>

    </div>
  </div>
</div>
<!-- /PAGE HEADER -->
<script>
  function update_student_section(student_id, section_id) {


    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR . "admission/update_student_record") ?>/",
      data: {
        student_id: student_id,
        value: section_id,
        field: 'section_id'
      }
    }).done(function(msg) {

      $("#message_" + student_id).html(msg);
      $("#message_" + student_id).fadeIn('slow');
      $("#message_" + student_id).delay(5000).fadeOut('slow');
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
      if (field == 'student_class_no') {
        $('#studentclassno_' + student_id).html(msg);
      }
      $("#class_no_" + student_id).html(msg);
      $("#class_no_" + student_id).fadeIn('slow');
      $("#class_no_" + student_id).delay(5000).fadeOut('slow');
    });

  }
</script>
<!-- PAGE MAIN CONTENT -->
<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-12" style="background-color: white; padding: 5px;">

    <table class="table table-bordered" id="main_table" style="font-size: 10px;">
      <thead>

        <th>#</th>
        <!-- <th>Class No</th> -->
        <!-- <td>Shift</td> -->
        <?php if (!$class_id) { ?>
          <th>Class</th>
        <?php } ?>
        <?php if (!$section_id) { ?>
          <th>Section</th>
        <?php } ?>
        <th>Add-No</th>
        <th><?php echo $this->lang->line('student_name'); ?></th>

        <th><?php echo $this->lang->line('student_father_name'); ?></th>
        <th>Status</th>
        <?php
        $exam_ids = "";
        $query = "SELECT * FROM exams WHERE exam_id > 10";
        $exams = $this->db->query($query)->result();
        foreach ($exams as $exam) {
          $exam_ids .= $exam->exam_id . ",";
        ?>
          <th><?php echo date("M, Y", strtotime($exam->created_date)); ?></th>
        <?php }  ?>

        <th>Average</th>
        <td>P</td>
        <td>A</td>
        <td>L</td>
        <td>R</td>

        </tr>
      </thead>
      <tbody>
        <?php
        $students = array();
        $all_sections = $sections;
        $count = 1;
        foreach ($sections as $section_name => $students) {

          foreach ($students as $student) :
        ?>
            <tr>

              <td id="count_number"><?php echo $count++; ?></td>
              <!-- <td>
                <span id="studentclassno_<?php echo $student->student_id; ?>" style="display: none;"> <?php echo $student->student_class_no; ?></span>
                <input autocomplete="off" style="width:50px !important" onkeyup="update_student_record('<?php echo $student->student_id; ?>','student_class_no')" id="student_class_no_<?php echo $student->student_id; ?>" type="text" name="student_class_no" value="<?php echo $student->student_class_no; ?>" />
                <span id="class_no_<?php echo $student->student_id; ?>"></span>
              </td>
              <td>
                G <input onchange="update_student_section('<?php echo $student->student_id; ?>', '1')" type="radio" name="section_id[<?php echo $student->student_id;  ?>]" value="1" <?php if ($student->section_id == 1) { ?> checked <?php } ?> />
                B <input onchange="update_student_section('<?php echo $student->student_id; ?>', '2')" type="radio" name="section_id[<?php echo $student->student_id;  ?>]" value="2" <?php if ($student->section_id == 2) { ?> checked <?php } ?> />
                Y <input onchange="update_student_section('<?php echo $student->student_id; ?>', '3')" type="radio" name="section_id[<?php echo $student->student_id;  ?>]" value="3" <?php if ($student->section_id == 3) { ?> checked <?php } ?> />
                R <input onchange="update_student_section('<?php echo $student->student_id; ?>', '4')" type="radio" name="section_id[<?php echo $student->student_id;  ?>]" value="4" <?php if ($student->section_id == 4) { ?> checked <?php } ?> />
                <span id="message_<?php echo $student->student_id; ?>"></span>
              </td> -->
              <!-- <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td> -->
              <?php if (!$class_id) { ?>
                <td><?php echo $student->Class_title; ?></td>
              <?php } ?>
              <?php if (!$section_id) { ?>
                <td style="border-left: 3px solid <?php echo $section_name; ?>;"><?php echo $section_name; ?></td>
              <?php } ?>
              <td><span><?php echo $student->student_admission_no; ?></span></td>
              <td><span><?php echo str_replace("Muhammad", "M. ", $student->student_name);  ?></span></td>
              <td><?php echo str_replace("Muhammad", "M. ", $student->student_father_name);  ?></td>
              <td><?php if ($student->status == 2) {
                    echo "Struck Off";
                  }  ?></td>
              <?php

              foreach ($exams as $exam) {
                $query = "SELECT AVG(percentage) as avg_percentage 
                          FROM `students_exams_subjects_marks` 
                          WHERE exam_id = '" . $exam->exam_id . "' 
                          AND student_id='" . $student->student_id . "'";
                $exam_result = $this->db->query($query)->result()[0];
              ?>
                <td><?php echo round($exam_result->avg_percentage, 2);  ?></td>
              <?php }  ?>
              <?php
              $query = "SELECT AVG(percentage) as avg_percentage 
              FROM `students_exams_subjects_marks` 
              WHERE exam_id IN  (" . trim($exam_ids, ',') . ")
              AND student_id='" . $student->student_id . "'";
              $exams_avg_result = $this->db->query($query)->result()[0];
              ?>
              <th><?php echo round($exams_avg_result->avg_percentage, 2); ?></th>

              <?php
              $query = "SELECT COUNT(IF(attendance='P',1,NULL)) as `present`, 
                               COUNT(IF(attendance='A',1,NULL)) as `absent`, 
                               COUNT(IF(attendance='L',1,NULL)) as `leave`, 
                               COUNT(IF(attendance2='A',1,NULL)) as `run` 
                               FROM `students_attendance` 
              WHERE  student_id='" . $student->student_id . "'";
              $attendance = $this->db->query($query)->result()[0];
              ?>
              <td><?php echo $attendance->present; ?></td>
              <td><?php echo $attendance->absent; ?></td>
              <td><?php echo $attendance->leave; ?></td>
              <td><?php echo $attendance->run; ?></td>





            </tr>
          <?php endforeach;  ?>
        <?php } ?>
      </tbody>

    </table>
  </div>
  <script>
    // $(document).ready(function() {
    //   $('#main_table').DataTable({
    //     "pageLength": 65,
    //     "lengthChange": false,
    //     buttons: [
    //       'copy', 'csv', 'excel', 'pdf', 'print'
    //     ]
    //   });
    // });

    $(document).ready(function() {
      document.title = "<?php if ($class_id) { ?>
      <?php echo $students[0]->Class_title . ""; ?>
    <?php } ?>
    <?php if ($section_id) { ?>
      <?php echo $students[0]->section_title . ""; ?>
    <?php } ?>
    <?php echo $title; ?> List "
    var table = $('#main_table').DataTable({
      "bPaginate": false,
      dom: 'Bfrtip',
      /* buttons: [
           'print'
           
           
       ],*/

      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
      }],
      "order": [
        [1, 'asc']
      ]
    });


    table.on('order.dt search.dt', function() {
      table.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
        table.cell(cell).invalidate('dom');
      });
    }).draw();
    });
  </script>


</div>
<!-- /MESSENGER -->
</div>