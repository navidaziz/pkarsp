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

        <td>#</td>
        <td>CN</td>
        <td>Add-No</td>
        <td><?php echo $this->lang->line('student_name'); ?></td>

        <td><?php echo $this->lang->line('student_father_name'); ?></td>
        <td><?php echo $this->lang->line('student_data_of_birth'); ?></td>
        <td>Form B</td>
        <td>Add. Date</td>
        <td><?php echo $this->lang->line('student_address'); ?></td>
        <td>Mobile No</td>
        <td>Father NIC</td>
        <td>Occupation</td>
        <td>Status</td>
        <td>Religion</td>
        <td>Nationality</td>
        <td>P/ G </td>
        <td>School</td>
        <td>Orphan</td>
        <td>Vaccinated</td>
        <td>Disable</td>
        <td>Ehsaas</td>
        <td>Class</td>
        <td>Section</td>
        <td>Session</td>
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
              <td><?php echo $student->student_data_of_birth; ?> </td>
              <td><?php echo $student->form_b; ?> </td>
              <td><?php echo $student->admission_date; ?></td>
              <td><?php echo $student->student_address; ?></td>
              <td><?php echo $student->father_mobile_number; ?></td>
              <td><?php echo $student->father_nic; ?></td>
              <td><?php echo $student->guardian_occupation; ?></td>
              <td><?php
                  if ($student->status == 2) {
                    echo "Struck Off";
                  }
                  ?></td>
              <td><?php echo $student->religion; ?></td>
              <td><?php echo $student->nationality; ?></td>

              <td><?php echo $student->private_public_school; ?></td>
              <td><?php echo $student->school_name; ?></td>
              <td><?php echo $student->orphan; ?></td>
              <td><?php echo $student->vaccinated; ?></td>
              <td><?php echo $student->is_disable; ?></td>
              <td><?php echo $student->ehsaas; ?></td>
              <td><?php echo $student->Class_title; ?></td>
              <td><?php echo $student->section_title; ?></td>
              <td>1</td>



            </tr>
          <?php endforeach;  ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <script>
    $(document).ready(function() {
      document.title = "<?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> List";

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