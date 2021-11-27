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
        <th>District</th>
        <th>Student Name</th>

        <th>Father Name</th>
        <th>Date of Birth</th>
        <th>School Name</th>
        <?php for($i=4; $i<=15; $i++){ ?>
          <td><?php echo $i ?> years</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $students = array();
        $all_sections = $sections;
        foreach ($sections as $section_name => $students) {
          $count = 1;
          foreach ($students as $student) :
            $age = date_diff(date_create($student->student_data_of_birth), date_create('now'));
        ?>
            <tr>

              <td id="count_number"><?php echo $count++; ?></td>
              <td>Chitral </td>
              <td><span><?php echo $student->student_name;  ?></span></td>
              <td><?php echo $student->student_father_name;  ?></td>
              <td><?php echo $student->student_data_of_birth; ?> </td>
              <td>GCMHS B</td>
              <?php for($i=4; $i<=15; $i++){ ?>
          <td <?php if($age->y < 4 || $age->y > 15){ ?> style="background: #F2F2F2;" <?php } ?> <?php ?> ><?php 
          if($age->y==$i){
            echo $age->y;
          }
          ?></td>
          <?php } ?>
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
      document.title = "<?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> Age Wise List";
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