<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dat aTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small> Students Admission</small>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo site_url("admin/admission"); ?>">Admission</a></li>
      <li><a href=""><?php echo $students[0]->Class_title . ""; ?> Students list</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content ">

    <div class="box box-primary box-solid">




      <div class="box-body">

        <div class="row">




          <div class="col-md-12">
            <h4><i class="fa fa-plus" aria-hidden="true"></i> Add New Student in Class <?php echo $students[0]->Class_title . ""; ?></h4>
            <form action="<?php echo site_url(ADMIN_DIR . "admission/add_new_student"); ?>" method="POST" style="padding: 5px;">
              <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
              <input type="hidden" name="section_id" value="1" />
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

              <table class="table">
                <thead>



                  <tr>
                    <input style="width:20px !important" type="hidden" name="student_class_no" value="1" />


                    <td>
                      Addmission No:
                      <input type="text" name="student_admission_no" value="" required />
                    </td>

                    <td>
                      Student Name
                      <input type="text" name="student_name" value="" required />
                    </td>

                    <td>
                      Father Name
                      <input type="text" name="student_father_name" value="" required />
                    </td>
                    <td>
                      Form B No.
                      <input id="form_b" type="text" id="form_b" name="form_b" value="" />
                    </td>
                    <td>
                      Date Of Birth<input style="width: 130px;" type="date" name="student_data_of_birth" value="" required />

                    </td>

                    <td>
                      Date of Admission<input style="width: 130px;" type="date" name="admission_date" value="" required />

                    </td>


                    <td>
                      Contact Number
                      <input type="tel" id="father_mobile_number" name="father_mobile_number" value="" required />

                    </td>
                    <td>
                      Father NIC
                      <input type="text" id="father_nic" name="father_nic" value="" />

                    </td>
                  </tr>
                  <tr>
                    <td>Gender: <input type="radio" name="gender" value="Male" required />
                      Male
                      <span style="margin-left: 20px;"></span>

                      <input type="radio" name="gender" value="Female" required />
                      Female
                    </td>
                    <td>Disable
                      <input type="radio" name="is_disable" value="Yes" required />
                      Yes
                      <span style="margin-left: 20px;"></span>

                      <input type="radio" name="is_disable" value="No" required />
                      No
                    </td>
                    <td>Orphan: <input type="radio" name="orphan" value="Yes" required />
                      Yes
                      <span style="margin-left: 20px;"></span>

                      <input type="radio" name="orphan" value="No" required />
                      No
                    </td>
                    <td>Religion
                      <input type="radio" name="religion" value="Muslim" required />
                      Muslim
                      <span style="margin-left: 20px;"></span>

                      <input type="radio" name="religion" value="Non Muslim" required />
                      Non Muslim
                    </td>
                    <td colspan="2">Nationality:
                      <input type="radio" name="nationality" value="Pakistan" required />
                      Pakistani
                      <span style="margin-left: 20px;"></span>

                      <input type="radio" name="nationality" value="Foreigner" required />
                      Foreigner
                    </td>

                    <td> Student Address <input type="text" name="student_address" value="" required />

                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                      <input class="btn btn-success btn-sm" type="submit" value="Add New Student" name="Add Student" />
                    </td>

                  </tr>

                </thead>
                <tbody>


                </tbody>
              </table>
            </form>
          </div>
          <div class="col-md-12">
            <h4><i class="fa fa-book" aria-hidden="true"></i> Class <?php echo $students[0]->Class_title . ""; ?> <?php echo $title; ?> List</h4>

            <table class="table" id="main_table" style="font-size: 12px;">

              <thead>

                <th>#</th>

                <th>Admission No</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Form B</th>
                <th>Admission Date</th>
                <th>Address</th>
                <th>Mobile No</th>
                <th>Father NIC</th>
                <th>Religion</th>
                <th>Nationality</th>
                <th>Orphan</th>

                <th>Disable</th>
                <th>Class</th>
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
                      <td><span><?php echo $student->student_admission_no; ?></span></td>
                      <td><span><?php echo $student->student_name;  ?></span></td>
                      <td><?php echo $student->student_father_name;  ?></td>
                      <td><?php echo $student->gender;  ?></td>
                      <td><?php echo $student->student_data_of_birth; ?> </td>
                      <td><?php echo $student->form_b; ?> </td>
                      <td><?php echo $student->admission_date; ?></td>
                      <td><?php echo $student->student_address; ?></td>
                      <td><?php echo $student->father_mobile_number; ?></td>
                      <td><?php echo $student->father_nic; ?></td>
                      <td><?php echo $student->religion; ?></td>
                      <td><?php echo $student->nationality; ?></td>
                      <td><?php echo $student->orphan; ?></td>
                      <td><?php echo $student->is_disable; ?></td>
                      <td><?php echo $student->Class_title; ?></td>


                    </tr>
                  <?php endforeach;  ?>
                <?php } ?>
              </tbody>
            </table>
          </div>







        </div>

      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function() {
    $('#father_mobile_number').inputmask('(9999)-9999999');
    $('#father_nic').inputmask('99999-9999999-9');
    $('#form_b').inputmask('99999-9999999-9');

  });
</script>

<script>
  $(document).ready(function() {
    document.title = "<?php echo $students[0]->Class_title . ""; ?> Students List";

    var table = $('#main_table').DataTable({
      "bPaginate": false,
      dom: 'Bfrtip',
      buttons: [
        'print'


      ],

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






<link href="<?php echo site_url(); ?>/assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />