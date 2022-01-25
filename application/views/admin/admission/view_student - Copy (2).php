<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($school->schoolName)); ?>
    </h2><br />
    <small> Students Admission</small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <li><a href="#">School Dashboard</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content ">

    <div class="box box-primary box-solid">
      <div class="box-body">
        <div class="col-md-12">
          <div class="box border blue" id="messenger">
            <div class="box-title">
              <h4><i class="fa fa-book" aria-hidden="true"></i> <?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> List</h4>
              <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
            </div>
            <div class="box-body">

              <div class="table-re sponsive">

                <div class="row">
                  <!-- MESSENGER -->
                  <style>
                    input {
                      border: 1px solid gray;
                      padding: 0px !important;
                      font-size: 12px;
                    }
                  </style>


                  <div class="col-md-12" style="background-color: white; padding: 5px;">
                    <div style="padding: 5px; margin: 5px; border: 1px solid gray; border-radius: 5px;">
                      Search Student from overall data: <input type="text" name="search_student" id="search_student" value="" onkeyup="search_student()" />
                      <div id="student_search_result_list" style="padding: 10px;"></div>

                    </div>
                  </div>
                  <script>
                    function search_student() {
                      var search_student = $('#search_student').val();
                      if (search_student != "") {
                        $.ajax({
                          type: "POST",
                          url: "<?php echo site_url(ADMIN_DIR . "admission/search_student") ?>",
                          data: {
                            search_student: search_student
                          }
                        }).done(function(data) {
                          $("#student_search_result_list").html(data);
                        });

                      } else {
                        $("#student_search_result_list").html("");

                      }
                    }
                  </script>


                  <div class="col-md-12" style="background-color: white; padding: 5px;">
                    <h5>Add New Student</h5>
                    <form action="<?php echo site_url(ADMIN_DIR . "admission/add_new_student"); ?>" method="POST">
                      <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                      <input type="hidden" name="section_id" value="1" />
                      <?php
                      $query = "SELECT sessionYearId as session_id FROM `session_year` WHERE status=1 ORDER BY sessionYearId";
                      $session_id  = $this->db->query($query)->result()[0]->session_id;
                      ?>
                      <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />

                      <table class="tab le table-bo rdered" style="font-size:13px !important; width: 100%; border: 1px solid gray; padding: 5px; border-radius: 5px;">
                        <thead>

                          <tr>
                            <!-- <td>CN</td> -->
                            <td>Add-No</td>
                            <td>Student Name</td>

                            <td>Father Name</td>
                            <td>Form B</td>
                            <td>Date of birht</td>

                            <td>Add. Date</td>
                            <td>Address</td>
                            <td>Mobile No</td>
                            <td>Father NIC</td>

                            <td>Religion</td>
                            <td>Nationality</td>
                            <td>Disable
                            </td>
                            <td>Orphan</td>
                            <td>Add New</td>

                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <input style="width:20px !important" type="hidden" name="student_class_no" value="1" />


                            <td><input style="width:50px !important" type="text" name="student_admission_no" value="" />
                            </td>

                            <td><input type="text" name="student_name" value="" />
                            </td>

                            <td><input type="text" name="student_father_name" value="" />
                            </td>
                            <td>
                              <input id="form_b" type="text" name="form_b" value="" />
                            </td>
                            <td><input style="width: 100px;" type="date" name="student_data_of_birth" value="" />

                            </td>
                            <td><input style="width: 100px;" type="date" name="admission_date" value="" />

                            </td>

                            <td><input style="width: 90px;" type="text" name="student_address" value="" />

                            </td>
                            <td>
                              <input style="width: 90px;" type="text" name="father_mobile_number" value="" />

                            </td>
                            <td>
                              <input style="width: 100px;" type="text" name="father_nic" value="" />

                            </td>

                            <input style="width: 70px;" type="hidden" name="guardian_occupation" value="" />


                            <td>
                              <input style="width: 70px;" type="text" name="religion" value="" />

                            </td>
                            <td>
                              <input style="width: 70px;" type="text" name="nationality" value="" />

                            </td>

                            <input style="width: 40px;" type="hidden" name="private_public_school" value="" />

                            <input style="width: 70px;" type="hidden" name="school_name" value="" />
                            <td><input style="width: 30px;" type="text" name="is_disable" value="" /></td>

                            <td>
                              <input style="width: 40px;" type="text" name="orphan" value="" />

                            </td>
                            <td>
                              <input type="submit" name="add new student" value="Add New" />

                            </td>

                          </tr>
                        </tbody>
                      </table>
                    </form>
                  </div>






                  <div class="col-md-12" style="background-color: white; padding: 5px;">
                    <h4>All Students List</h4>
                    <table class="tab le table-bord ered" id="main_table" style="font-size:13px !important; width: 100%;">
                      <thead>

                        <tr>
                          <!-- <td></td> -->

                          <td>#</td>
                          <td>ANo.</td>

                          <td>Student Name</td>
                          <td>Father Name</td>
                          <td>Form B</td>
                          <td>Date of birth</td>
                          <td>Admiss. Date</td>
                          <td>Address</td>
                          <td>Mobile No</td>
                          <td>Father NIC</td>
                          <td>Reli.</td>
                          <td>Nation.</td>
                          <td>Disable</td>
                          <td>Orph.</td>

                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $list_sections = $this->student_model->getList("sections", "section_id", "section_title", $where = "");

                        ?>
                        <?php
                        $students = array();
                        $all_sections = $sections;
                        foreach ($sections as $section_name => $students) {
                          $count = 1;
                          foreach ($students as $student) :
                        ?>
                            <tr <?php if ($student->status == 2) { ?>style="background-color: #F7C6C5;" <?php } ?>>

                              <td id="count_number"><?php echo $count++; ?></td>


                              <td>
                                <input style="width:30px !important" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'student_admission_no')" id="student_admission_no_<?php echo $student->student_id; ?>" type="text" name="student_admission_no" value="<?php echo $student->student_admission_no; ?>" />
                              </td>

                              <td>

                                <input onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'student_name')" id="student_name_<?php echo $student->student_id; ?>" type="text" name="student_name" value="<?php echo $student->student_name; ?>" />
                              </td>

                              <td>
                                <input onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'student_father_name')" id="student_father_name_<?php echo $student->student_id; ?>" type="text" name="student_father_name" value="<?php echo $student->student_father_name; ?>" />
                              </td>


                              <td>
                                <input style="width: 100px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'form_b')" id="form_b_<?php echo $student->student_id; ?>" type="text" name="form_b" value="<?php echo $student->form_b; ?>" />

                              </td>
                              <td>
                                <input style="width: 80px;" onchange="update_student_record('<?php echo $student->student_id; ?>', 'student_data_of_birth')" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'student_data_of_birth')" id="student_data_of_birth_<?php echo $student->student_id; ?>" type="date" name="student_data_of_birth" value="<?php echo $student->student_data_of_birth; ?>" />

                              </td>






                              <td>
                                <input style="width: 80px;" onchange="update_student_record('<?php echo $student->student_id; ?>', 'admission_date')" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'admission_date')" id="admission_date_<?php echo $student->student_id; ?>" type="date" name="admission_date" value="<?php echo $student->admission_date; ?>" />

                              </td>

                              <td><?php //echo $student->student_address; 
                                  ?>
                                <input style="width: 90px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'student_address')" id="student_address_<?php echo $student->student_id; ?>" type="text" name="student_address" value="<?php echo $student->student_address; ?>" />

                              </td>
                              <td>
                                <input style="width: 90px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'father_mobile_number')" id="father_mobile_number_<?php echo $student->student_id; ?>" type="text" name="father_mobile_number" value="<?php echo $student->father_mobile_number; ?>" />

                              </td>
                              <td>
                                <input style="width: 100px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'father_nic')" id="father_nic_<?php echo $student->student_id; ?>" type="text" name="father_nic" value="<?php echo $student->father_nic; ?>" />

                              </td>

                              <td>
                                <input style="width: 40px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'religion')" id="religion_<?php echo $student->student_id; ?>" type="text" name="religion" value="<?php echo $student->religion; ?>" />

                              </td>
                              <td>
                                <input style="width: 60px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'nationality')" id="nationality_<?php echo $student->student_id; ?>" type="text" name="nationality" value="<?php echo $student->nationality; ?>" />

                              </td>

                              <td>
                                <input style="width: 30px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'is_disable')" id="is_disable_<?php echo $student->student_id; ?>" type="text" name="is_disable" value="<?php echo $student->is_disable; ?>" />

                              </td>


                              <td>
                                <input style="width: 40px;" onkeyup="update_student_record('<?php echo $student->student_id; ?>', 'orphan')" id="orphan_<?php echo $student->student_id; ?>" type="text" name="orphan" value="<?php echo $student->orphan; ?>" />

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
                        "pageLength": 65,
                        "lengthChange": false
                      });
                    });
                  </script>


                </div>

              </div>


            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
</div>





<!-- PAGE HEADER-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dat aTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

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
      if (field == 'student_class_no') {
        $('#studentclassno_' + student_id).html(msg);
      }
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