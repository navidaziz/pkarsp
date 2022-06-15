<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" />
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small> <?php echo $students[0]->Class_title . ""; ?> Students list</a></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <li><a href="<?php echo site_url("admin/admission"); ?>">Admission</a></li>
      <li><a href=""><?php echo $students[0]->Class_title . ""; ?> Students list</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content ">

    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
      <h4>
        Add New Student in Class <?php echo $students[0]->Class_title . ""; ?>
        <i class="fa fa-plus pull-right" onclick="$('#add_student_form').toggle()" style="margin-right: 10px;" aria-hidden="true"></i>
      </h4>

      <div class="row" style="display: none;" id="add_student_form">
        <div class="col-md-12">
          <div style="display: none;" id="student_profile_message"></div>
          <form id="addStudentForm" action="<?php echo site_url(ADMIN_DIR . "admission/add_new_student"); ?>" method="POST" style="padding: 5px;">
            <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
            <input type="hidden" name="section_id" value="1" />
            <input type="hidden" name="student_class_no" value="1" />

            <style>
              .table>thead>tr>th,
              .table>tbody>tr>th,
              .table>tfoot>tr>th,
              .table>thead>tr>td,
              .table>tbody>tr>td,
              .table>tfoot>tr>td {
                padding: 2px;
              }

              .required:after {
                content: " *";
                color: red;

              }

              .dt-button {
                float: right;
              }

              .dataTables_wrapper .dataTables_filter {
                /* float: right; */
                text-align: right;
                float: left;
                margin-bottom: 2px;
              }
            </style>

            <script>
              function change_masking(value) {
                if (value == 'Pakistani') {
                  $('#father_nic').inputmask('99999-9999999-9');
                  $('#form_b').inputmask('99999-9999999-9');
                  $('#father_nic').prop('placeholder', '11111-111111-1');
                  $('#form_b').inputmask('99999-9999999-9');
                  $('#form_b').prop('placeholder', '11111-111111-1');
                }
                if (value == 'Afghani') {
                  $('#father_nic').inputmask('aa999-9999999-9');
                  $('#father_nic').prop('placeholder', 'FC111-111111-1');
                  $('#form_b').inputmask('aa999-9999999-9');
                  $('#form_b').prop('placeholder', 'FC111-111111-1');
                }

                if (value == 'Other') {
                  $('#father_nic').inputmask('remove');
                  $('#form_b').inputmask('remove');
                  $('#father_nic').prop('placeholder', 'XXXXXXXXXXXXXX');
                  $('#form_b').prop('placeholder', 'XXXXXXXXXXXXXX');

                }
              }
            </script>


            <div class="form-group col-md-4" style="padding-right: 2px; padding-left: 2px;">
              <table class="table">
                <tr>
                  <td style="width: 100px;"><label class="required" for="inputEmail4">Admission No</label>
                    <input class="form-control" placeholder="Admission No" type="text" name="student_admission_no" value="" required />
                  </td>
                  <td><label class="required" for="inputEmail4">Student Name</label>
                    <input class="form-control" placeholder="Student Name" type="text" id="student_name" name="student_name" value="" required />
                  </td>
                  <td>
                    <label class="required" for="inputEmail4">Father Name</label>
                    <input class="form-control" placeholder="Father Name" type="text" id="student_father_name" name="student_father_name" value="" required />
                  </td>
                </tr>
              </table>
            </div>



            <div class="form-group col-md-3" style="padding-right: 2px; padding-left: 2px;">
              <label class="required" for="inputEmail4">Nationality</label>
              <br />
              <input checked onchange="$('#province_div').show(); $('#ditrict_domicile').prop('required',true); $('#domicile_id').prop('required',true); $('#province').prop('required',true);  change_masking('Pakistani')" class="form-check-input" type="radio" id="pakistani" name="nationality" onclick="$('#other_nationality').hide(); $( '#foreigner' ).prop( 'checked' , false ); $('#afghani' ).prop( 'checked' , false );" value="Pakistani" required />
              Pakistani
              <span style="margin-left: 10px;"></span>

              <input onclick="$('#province_div').hide(); $('#ditrict_domicile').prop('required',false); $('#domicile_id').prop('required',false); $('#province').prop('required',false);  change_masking('Afghani'); $('#other_nationality').show(); $('#pakistani' ).prop( 'checked' , false ); $('#afghani' ).prop( 'checked' , true ); " class="form-check-input" id="foreigner" type="radio" required onclick="" /> Foreigner

              <span style="display: none;" id="other_nationality"> (
                <input id="afghani" onchange="change_masking('Afghani')" class="form-check-input" type="radio" name="nationality" value="Afghani" required /> Afghani
                <span style="margin-left: 2px;"></span>
                <input onchange="change_masking('Other')" class="form-check-input" type="radio" name="nationality" value="Non Afghani" required /> Non Afghani
                )
              </span>
            </div>



            <div class="form-group col-md-5" style="padding-right: 2px; padding-left: 2px;">
              <table class="table">
                <tr>
                  <td>
                    <label class="required" for="inputEmail4">Father CNIC</label>
                    <input class="form-control" placeholder="11111-1111111-1" type="text" id="father_nic" name="father_nic" value="" required />
                  </td>
                  <td>
                    <label for="inputEmail4">Student Form-B</label>
                    <input class="form-control" placeholder="11111-1111111-1" id="form_b" type="text" id="form_b" name="form_b" value="" />
                  </td>
                  <td>
                    <label class="required" for="inputEmail4">Contact No </label>
                    <input class="form-control" style="padding: 0 1px;" placeholder="(0311)-1111111" id="father_mobile_number" type="text" id="father_mobile_number" name="father_mobile_number" value="" />
                  </td>
                  <td>
                    <label class="required" for="inputEmail4">Date Of Birth</label>
                    <input class="form-control" min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" type="date" name="student_data_of_birth" value="" required />
                  </td>
                </tr>
              </table>
            </div>
        </div>

        <div class="col-md-12">


          <div class="form-group col-md-6">
            <table class="table">
              <tr>
                <td style="width: 130px;">

                  <label class="required" for="inputEmail4">Addmission Date</label>
                  <input class="form-control" min="<?php echo date("Y") - 5; ?>-12-31" max="<?php echo date("Y-m-d"); ?>" type="date" name="admission_date" value="" required />

                </td>
                <td>
                  <label class="required" for="inputEmail4">Gender</label><br />
                  <input type="radio" name="gender" value="Male" required />
                  Male
                  <span style="margin-left: 1px;"></span>
                  <input type="radio" name="gender" value="Female" required />
                  Female
                </td>
                <td>

                  <label class="required" for="inputEmail4">Disable</label><br />
                  <input type="radio" name="is_disable" value="Yes" required />
                  Yes
                  <span style="margin-left: 1px;"></span>
                  <input type="radio" name="is_disable" value="No" required />
                  No


                </td>
                <td>
                  <label class="required" for="inputEmail4">Orphan</label><br />
                  <input type="radio" name="orphan" value="Yes" required />
                  Yes
                  <span style="margin-left: 1px;"></span>
                  <input type="radio" name="orphan" value="No" required />
                  No
                </td>
                <td>
                  <label class="required" for="inputEmail4">Religion</label><br />
                  <input type="radio" name="religion" value="Muslim" required />
                  Muslim
                  <span style="margin-left: 10px;"></span>
                  <input type="radio" name="religion" value="Non Muslim" required />
                  Non Muslim
                </td>
              </tr>
            </table>
          </div>
          <div class="form-group col-md-3" style="padding-right: 2px; padding-left: 2px;">
            <table class="table" id="province_div">
              <tr>
                <td>
                  <div>
                    <label class="required" for="inputEmail4">Mention Province</label><br />
                    <select class="form-control" name="province" id="province" onchange="show_ditrict_list()" required>
                      <option value="">Select Province</option>
                      <option value="Khyber Pakhtunkhwa" selected>Khyber Pakhtunkhwa</option>
                      <option value="Punjab">Punjab</option>
                      <option value="Sindh">Sindh</option>
                      <option value="Baloachistan">Baloachistan</option>
                      <option value="Islamabad">Islamabad Capital Territory</option>
                      <option value="Gilgit baltistan">Gilgit Baltistan</option>
                      <option value="Azad Jammu Kashmir">Azad Jammu Kashmir</option>
                    </select>
                  </div>
                </td>
                <td>
                  <div>
                    <label class="required" for="inputEmail4">Domicile District</label><br />
                    <select class="form-control" onchange="set_district_of_domicile()" id="domicile_id" name="domicile_id" required>
                      <option value="">Select Domicile District</option>
                      <?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
                      $districts = $this->db->query($query)->result();
                      foreach ($districts as $district) { ?>
                        <option value="<?php echo $district->districtTitle ?>"><?php echo $district->districtTitle ?></option>
                      <?php } ?>
                    </select>
                    <input style="display: none;" class="form-control" placeholder="Domicile District Name" id="ditrict_domicile" id="ditrict_domicile" type="text" value="" />

                  </div>
                </td>
              </tr>
            </table>
          </div>
          <div class="form-group col-md-2" style="padding-right: 2px; padding-left: 2px;">
            <table class="table" id="province_div">
              <tr>
                <td> <label class="required" for="inputEmail4">Student Address</label><br />
                  <input class="form-control" type="text" name="student_address" value="" required />

              </tr>
            </table>
          </div>
          <script>
            function set_district_of_domicile() {
              $('#ditrict_domicile').val($('#domicile_id').val());
            }

            function show_ditrict_list() {

              if ($('#province').val() == 'Khyber Pakhtunkhwa' || $('#province').val() == '') {
                $('#ditrict_domicile').hide();
                $('#domicile_id').show();
                $('#ditrict_domicile').prop('required', ture);
                $('#domicile_id').prop('required', false);
              } else {

                $('#ditrict_domicile').show();
                $('#domicile_id').hide();
                $('#ditrict_domicile').prop('required', false);
                $('#domicile_id').prop('required', true);
              }
            }
          </script>




          <div class="form-group col-md-1" style="padding-right: 2px; padding-left: 2px; text-align:center; ">

            <input class="btn btn-success btn-sm" style="margin-top: 10px;" type="submit" value="Add New Student" name="Add Student" />
          </div>
        </div>
      </div>

      </form>
    </div>
    <script>
      $(document).ready(function() {

        $('#addStudentForm').submit(function(e) {

          if (check_student_profile()) {
            alert();

          } else {
            e.preventDefault();
          }
        });
      });

      function check_student_profile() {

        student_name = $('#student_name').val();
        student_father_name = $('#student_father_name').val();
        father_nic = $('#father_nic').val();
        form_b = $('#form_b').val();
        $.ajax({
          type: "POST",
          url: "<?php echo site_url(ADMIN_DIR . "admission/check_student_profile"); ?>",
          data: {
            student_name: student_name,
            student_father_name: student_father_name,
            father_nic: father_nic,
            form_b: form_b
            //data: $('#addStudentForm').serialize()
          }
        }).done(function(data) {
          if (data) {
            $('#student_profile_message').show();
            $('#student_profile_message').html(data);

            return false;
          } else {
            $('#student_profile_message').show();
            $('#student_profile_message').html(data);
            return true;
          }
        });


      }
    </script>

    <div class="row">
      <div class="col-md-12">

        <table class="table" id="main_table" style="font-size: 12px;">

          <thead>
            <tr>
              <th colspan="17">Student List</th>
            </tr>

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
                    $query = "SELECT districtTitle FROM district WHERE districtId = '" . $student->domicile_id . "'";
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
    $('#father_mobile_number').inputmask('(0399)-9999999');
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