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
              <h4><i class="fa fa-book" aria-hidden="true"></i> <?php echo $title; ?></h4>
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
                  <div class="col-md-4">
                    <!-- MESSENGER -->

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Classes

                          </th>
                          <th>Total

                          </th>

                          <th>View Students</th>

                          <!-- <th><i class="fa fa-edit"></i></th>
                          <th><i class="fa fa-eye"></i></th>
                          <th>Promote</th>
                          <th colspan="3" style="text-align: center;">

                            <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/all_students_data") . "/"; ?>">
                              <i class="fa fa-print"></i> Student Overall Data</a>
                            <br />
                            <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/asc_report"); ?>">Annual School Census Report</a>

                          </th> -->
                        </tr>
                      </thead>
                      </body>
                      <?php foreach ($classes as $class) { ?>

                        <?php
                        $count = 1; ?>
                        <tr>
                          <?php if ($count == 1) { ?>
                            <th style="text-align: center;"><?php echo $class->class_title; ?>

                            </th>
                          <?php
                            $count++;
                          } ?>

                          <th><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.class_id = $class->class_id
                              AND s.status IN(1,2) AND school_id = $school_id";
                              echo $this->db->query($query)->result()[0]->total;
                              ?></th>


                          <td>
                            <a href="<?php echo site_url(ADMIN_DIR . "admission/view_students") . "/$class->class_id/$section->section_id"; ?>">
                              Admit Student </a>
                          </td>
                          <!-- <td>
                              <a href="<?php echo site_url(ADMIN_DIR . "admission/promote_students") . "/$class->class_id/$section->section_id"; ?>">
                                Promote</a>
                            </td> -->
                          <!-- <td>
                            <a href="<?php echo site_url(ADMIN_DIR . "admission/students_list") . "/$class->class_id/$section->section_id"; ?>">
                              <i class="fa fa-eye"></i></a>
                          </td> -->

                        </tr>


                      <?php } ?>
                      <tr>
                        <th>Total Students</th>
                        <th><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.status IN(1,2)  AND school_id = $school_id";
                            echo $this->db->query($query)->result()[0]->total;
                            ?></th>
                      </tr>
                      <tr>
                        <th>School Leaving Certificates</th>
                        <th><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.status IN(3)  AND school_id = $school_id";
                            echo $this->db->query($query)->result()[0]->total;
                            ?></th>
                      </tr>
                      <tr>
                        <th>Trashed Students</th>
                        <th><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.status IN(0)  AND school_id = $school_id";
                            echo $this->db->query($query)->result()[0]->total;
                            ?></th>
                      </tr>
                    </table>

                  </div>

                  <div class="col-md-8">
                    <table class="table">
                      <tr>
                        <th style="text-align: right;">Search Student Profile:
                          <input style="width: 300px" placeholder="By Student ID, Adminssion No, Name, Father Name" type="text" name="search_student" id="student_search" value="" />
                          <button onclick="search_student()">Search</button>

                        </th>
                      </tr>
                    </table>
                    <div style="padding: 1px; margin: 5px; border: 1px solid #9FC8E8; border-radius: 5px;">
                      <div id="student_search_result_list" style="padding: 10px; font-size: 10px;">
                      </div>

                    </div>
                  </div>

                  <script>
                    $('#student_search').keypress(function(event) {
                      var keycode = (event.keyCode ? event.keyCode : event.which);
                      if (keycode == '13') {
                        search_student();
                      }
                      event.stopPropagation();
                    });

                    function search_student() {

                      var search_student = $('#student_search').val();
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
                        $("#student_search_result_list").html("not found");

                      }
                    }
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