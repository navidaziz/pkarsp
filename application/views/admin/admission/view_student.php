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
                      <strong> Addmission No: </strong><br />
                      <input style="width:90px !important; " type="text" name="student_admission_no" value="" required />
                    </td>

                    <td>
                      <strong> Student Name </strong><br />
                      <input type="text" name="student_name" value="" required />
                    </td>

                    <td>
                      <strong> Father Name </strong><br />
                      <input type="text" name="student_father_name" value="" required />
                    </td>
                    <td>
                      <strong> Father CNIC</strong><br />
                      <input style="width:110px !important; " type="text" id="father_nic" name="father_nic" value="" required />

                    </td>
                    <td>
                      <strong> Form B No.</strong><br />
                      <input style="width:110px !important; " id="form_b" type="text" id="form_b" name="form_b" value="" />
                    </td>
                    <td>
                      <strong> Date Of Birth
                      </strong><br />
                      <input min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="student_data_of_birth" value="" required />

                    </td>

                    <td>
                      <strong>Date of Admission</strong><br />
                      <input min="<?php echo date("Y") - 5; ?>-12-31" max="<?php echo date("Y-m-d"); ?>" style=" width: 125px;" type="date" name="admission_date" value="" required />

                    </td>


                    <td>
                      <strong> Contact Number</strong><br />
                      <input style="width:95px !important; " type="tel" id="father_mobile_number" name="father_mobile_number" value="" required />

                    </td>

                    <td> <strong>Student Address </strong><br /> <input type="text" name="student_address" value="" required />

                    </td>
                  </tr>
                  <tr>
                    <td><strong>Gender:</strong><br /> <input type="radio" name="gender" value="Male" required />
                      Male
                      <span style="margin-left: 10px;"></span>

                      <input type="radio" name="gender" value="Female" required />
                      Female
                    </td>
                    <td><strong>Disable </strong><br />
                      <input type="radio" name="is_disable" value="Yes" required />
                      Yes
                      <span style="margin-left: 10px;"></span>

                      <input type="radio" name="is_disable" value="No" required />
                      No
                    </td>
                    <td><strong>Orphan: </strong><br /> <input type="radio" name="orphan" value="Yes" required />
                      Yes
                      <span style="margin-left: 10px;"></span>

                      <input type="radio" name="orphan" value="No" required />
                      No
                    </td>
                    <td colspan="2"> <strong> Religion:</strong><br />
                      <input type="radio" name="religion" value="Muslim" required />
                      Muslim
                      <span style="margin-left: 10px;"></span>

                      <input type="radio" name="religion" value="Non Muslim" required />
                      Non Muslim
                    </td>
                    <td colspan="2"> <strong>Nationality:</strong><br />
                      <input type="radio" id="pakistani" name="nationality" onclick="$('#other_nationality').hide(); $( '#foreigner' ).prop( 'checked' , false );" value="Pakistan" required />
                      Pakistani
                      <span style="margin-left: 10px;"></span>

                      <input id="foreigner" type="radio" required onclick="$('#other_nationality').show(); $( '#pakistani' ).prop( 'checked' , false ); " /> Foreigner

                      <div style="display: none;" id="other_nationality"><input type="radio" name="nationality" value="Afghani" required /> Afghani
                        <span style="margin-left: 10px;"></span>
                        <input type="radio" name="nationality" value="Non Afghani" required /> Non Afghani

                      </div>


                    </td>
                    <td>
                      <strong>Domicile</strong><br />
                      <select name="domicile_id" required>
                        <option value="">Select Domicile</option>
                        <?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
                        $districts = $this->db->query($query)->result();
                        foreach ($districts as $district) { ?>
                          <option value="<?php echo $district->districtId ?>"><?php echo $district->districtTitle ?></option>
                        <?php } ?>
                      </select>
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
                <th>Domicile</th>
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
                      <td>
                        <?php
                        $query = "SELECT districtTitle FROM district WHERE districtId = '" . $students[0]->domicile_id . "'";
                        echo $this->db->query($query)->result()[0]->districtTitle; ?>
                      </td>
                      <td>
                        <button onclick="update_profile('<?php echo $student->student_id; ?>')" class="btn btn-link btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit</button>

                        <a href="<?php echo site_url(ADMIN_DIR . "admission/view_student_profile/" . $student->student_id) ?>">View</a>
                      </td>

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
      url: "<?php echo site_url(ADMIN_DIR . "admission/update_student_profile"); ?>",
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