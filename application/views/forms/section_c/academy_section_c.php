  <!-- Modal -->
  <script>
    function add_students() {
      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="update_class_ages_body">
        <div class="modal-header">
          <h4 class="pull-left" style="">Add academy student detail</h4>
          <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="post" action="<?php echo site_url("form/add_academy_section_c_data"); ?>">
            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />

            <table class="table table-bordered">
              <tr>
                <th></th>
                <th>Total</th>
              </tr>
              <tr>
                <th>Male Students</th>
                <?php
                $query = "SELECT SUM(`enrolled`) as enrolled  FROM `age_and_class` 
                WHERE  class_id ='21'
                AND gender_id = '1'
                AND school_id = '" . $school_id . "'";
                $query_result = $this->db->query($query)->row();
                if ($query_result) {
                  $total_class_enrollment += $query_result->enrolled;
                  $males_total = $query_result->enrolled;
                } else {
                  $males_total = 0;
                }

                ?>
                <td><input required class="form-control" name="boys" value="<?php echo $males_total; ?>" /></td>
              </tr>
              <tr>
                <th>Female Students</th>
                <?php
                $query = "SELECT SUM(`enrolled`) as enrolled  FROM `age_and_class` 
                WHERE  class_id ='21'
                AND gender_id = '2'
                AND school_id = '" . $school_id . "'";
                $query_result = $this->db->query($query)->row();
                if ($query_result) {
                  $total_class_enrollment += $query_result->enrolled;
                  $females_total = $query_result->enrolled;
                } else {
                  $females_total = 0;
                }

                ?>
                <td><input required class="form-control" name="girls" value="<?php echo $females_total; ?>" /></td>
              </tr>
              <tr>
                <td colspan="2" style="text-align: center;">
                  <input class="btn btn-success" type="submit" name="save" value="Save Student Detail" />
                </td>
              </tr>
              <tr>




              </tr>
            </table>
          </form>
        </div>

      </div>
    </div>
  </div>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php $this->load->view('forms/form_header');   ?>



    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <?php $this->load->view('forms/navigation_bar');   ?>
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Section-C: Students Enrollment</h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">


            <div class="col-md-3">
              <p style="text-align: center;">
              <h4 style="padding-left:5px"><strong> Add students detail</strong><br />

              </h4>
              <button onclick="add_students()" class="btn btn-danger"> Add Academy student detail</button>
              </p>
            </div>

            <div class="col-md-3">
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px; text-align:center"><strong> Male students in academy </strong><br />

              </h4>

              <h2 style="text-align: center;">
                <?php
                if ($males_total) {
                  echo $males_total;
                } else {
                  echo 0;
                }
                ?>
              </h2>

            </div>

            <div class="col-md-3">
              <h4 style="border-left: 20px solid #FFC0CB; padding-left:5px; text-align:center"><strong> Female students in academy </strong><br />

              </h4>

              <h2 style="text-align: center;">
                <?php
                if ($females_total) {
                  echo $females_total;
                } else {
                  echo 0;
                }

                ?>
              </h2>
            </div>

            <div class="col-md-3">
              <h4 style="border-left: 20px solid blue; padding-left:5px; text-align:center"><strong> Total students</strong><br />

              </h4>

              <h2 style="text-align: center;">
                <?php
                echo $total_students = $females_total + $males_total;
                if ($total_students) {
                  $form_complete = 1;
                } else {
                  $form_complete = 0;
                }
                ?>
              </h2>
            </div>







          </div>
        </div>

        <div style="font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">

          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-success" href="<?php echo site_url("form/section_b/$school_id"); ?>">
                <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Physical Facilities )

              </a>

            </div>
            <div class="col-md-6">
              <?php if ($form_complete) {
                $form_input['form_c_status'] = 1;
                $this->db->where('school_id', $school_id);
                $this->db->update('forms_process', $form_input);
                $form_status->form_c_status = 1;
              } else {
                $form_input['form_c_status'] = 0;
                $this->db->where('school_id', $school_id);
                $this->db->update('forms_process', $form_input);
                $form_status->form_c_status = 0;
              } ?>
              <?php if ($form_status->form_c_status == 1) { ?>
                <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/section_d/$school_id"); ?>">
                  Next Section ( Employees Detail )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i>
                </a>
              <?php } ?>
            </div>

          </div>
        </div>

      </div>

  </div>
  </section>

  </div>