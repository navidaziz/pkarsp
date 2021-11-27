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

    <table class="table table-bordered" id="main_table" style="font-size: 10px;">
      <thead>

        <th>#</th>
        <th>Add-No</th>
        <th><?php echo $this->lang->line('student_name'); ?></th>

        <th><?php echo $this->lang->line('student_father_name'); ?></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>`
        <th></th>


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
              <!-- <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td> -->
              <td><span><?php echo $student->student_admission_no; ?></span></td>
              <td><span><?php echo str_replace("Muhammad", "M. ", $student->student_name);  ?></span></td>
              <td><?php echo str_replace("Muhammad", "M. ", $student->student_father_name);  ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>





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
      document.title = "<?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?>       Subject ________________________       Monthly Test and Exam Result List ";
      $('#main_table').DataTable({
        dom: 'Bfrtip',
        "pageLength": 65,
        "lengthChange": false,
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });
    });
  </script>


</div>
<!-- /MESSENGER -->
</div>