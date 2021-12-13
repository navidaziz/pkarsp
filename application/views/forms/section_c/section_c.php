  <!-- Modal -->
  <script>
    function update_class_ages_from(gender_id, class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_ages_from"); ?>",
        data: {

          gender_id: gender_id,
          class_id: class_id,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>
        }
      }).done(function(data) {

        $('#update_class_ages_body').html(data);
      });

      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="update_class_ages_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;">
        <?php echo ucwords(strtolower($school->schoolName)); ?>
      </h2>
      <br />
      <h4>S-ID: <?php echo $school->schools_id; ?> - REG No: <?php echo $school->registrationNumber ?></h4>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php $this->load->view('forms/navigation_bar');   ?>
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Section-C: Class & Age Wise Enrolment</h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">


            <div class="col-md-12">
              <style>
                .table>tbody>tr>td,
                .table>tbody>tr>th,
                .table>tfoot>tr>td,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>thead>tr>th {
                  padding: 1px !important;
                }
              </style>



              <p>
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>Boys</strong> Enrolment Class and Age wise.<br />
                <small style="color: red;">
                  Note: For example age 3+ means “equal to or greater than 3 but less than 4 years”, similarly for 4+ , 5+ and so on
                </small>
              </h4>

              </small>
              </p>
              <table class="table table-bordered">
                <tr>
                  <th rowspan="2" style="text-align: center; vertical-align: middle;">Classes</th>
                  <th colspan="19" style="text-align: center;">Age Categories</th>
                  <th colspan="4"></th>
                </tr>
                <tr>

                  <?php
                  $count = 1;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center;"><?php echo $age->ageTitle; ?></th>
                  <?php } ?>
                  <th style="text-align: center;">Total</th>
                  <th style="text-align: center;">Non-Muslims</th>
                  <th style="text-align: center;">Disabled</th>

                  <td style="text-align: center;"></td>
                </tr>

                <?php

                foreach ($classes  as $class) { ?>
                  <tr>
                    <th><?php echo $class->classTitle ?></th>
                    <?php
                    $total_class_enrollment = 0;
                    foreach ($ages  as $age) { ?>
                      <td style="text-align: center; background-color: bcd9ef;"><?php
                                                                                $query = "SELECT `enrolled` FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND class_id ='" . $class->classId . "'
                                            AND school_id = '" . $school_id . "'
                                            AND gender_id ='1'";
                                                                                $query_result = $this->db->query($query)->result();
                                                                                if ($query_result) {
                                                                                  $total_class_enrollment += $query_result[0]->enrolled;
                                                                                  echo $query_result[0]->enrolled;
                                                                                }
                                                                                ?></td>
                    <?php
                      $total_school_entrollment += $total_class_enrollment;
                    } ?>
                    <th style="text-align: center;"><?php echo $total_class_enrollment; ?></th>
                    <?php $query = "SELECT `non_muslim`,`disabled` FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND class_id ='" . $class->classId . "' 
                                  AND gender_id ='1' ";
                    $query_result = $this->db->query($query)->result();
                    ?>
                    <th style="text-align: center;"><?php if ($query_result) {
                                                      echo $query_result[0]->non_muslim;
                                                    } ?> </th>
                    <th style="text-align: center;"> <?php if ($query_result) {
                                                        echo $query_result[0]->disabled;
                                                      } ?> </th>

                    <td style="text-align: center;">
                      <?php if ($total_class_enrollment) { ?>
                        <button type="button" class="btn btn-success btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_ages_from(1, <?php echo $class->classId ?>)">
                          Edit
                        </button>

                      <?php  } else { ?>
                        <button type="button" class="btn btn-danger btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_ages_from(1, <?php echo $class->classId ?>)">
                          Add
                        </button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>

                <tr>
                  <th style="text-align: right; text-align: center;">Total</th>
                  <?php
                  $total_school_entrollment  = 0;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center;"><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND school_id = '" . $school_id . "'
                                            AND gender_id ='1'";
                                                    $query_result = $this->db->query($query)->result();
                                                    if ($query_result) {
                                                      $total_school_entrollment += $query_result[0]->enrolled;
                                                      echo $query_result[0]->enrolled;
                                                    }
                                                    ?></th>
                  <?php } ?>


                  <th style="text-align: center;"><?php echo $total_school_entrollment; ?></th>
                  <?php $query = "SELECT SUM(`non_muslim`) as non_muslim, SUM(`disabled`) as disabled
                                  FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND gender_id ='1' ";
                  $query_result = $this->db->query($query)->result();
                  ?>
                  <th style="text-align: center;"><?php if ($query_result) {
                                                    echo $query_result[0]->non_muslim;
                                                  } ?> </th>
                  <th style="text-align: center;"> <?php if ($query_result) {
                                                      echo $query_result[0]->disabled;
                                                    } ?> </th>
                  <td></td>
                </tr>
              </table>



              <h4 style="border-left: 20px solid #FFC0CB; padding-left:5px"><strong> Grils</strong> Enrolment Class and Age wise.<br />
                <small style="color: red;">
                  Note: For example age 3+ means “equal to or greater than 3 but less than 4 years”, similarly for 4+ , 5+ and so on
                </small>
              </h4>
              <table class="table table-bordered">
                <tr style="text-align: center; background-color: #FFC0CB;">
                  <th rowspan="2" style="text-align: center; vertical-align: middle; background-color: #FFC0CB;">Classes</th>
                  <th colspan="19" style="text-align: center; background-color: #FFC0CB;">Age Categories</th>
                  <th colspan="4" style="background-color: #FFC0CB;"></th>
                </tr>
                <tr>
                  <?php
                  $count = 1;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center; background-color: #FFC0CB;"><?php echo $age->ageTitle; ?></th>
                  <?php } ?>
                  <th style="background-color: #FFC0CB; text-align: center;">Total</th>
                  <th style="background-color: #FFC0CB; text-align: center;">Non-Muslims</th>
                  <th style="background-color: #FFC0CB; text-align: center;">Disabled</th>

                  <td style="text-align: center;"></td>
                </tr>

                <?php foreach ($classes  as $class) { ?>
                  <tr>
                    <th style="background-color: #FFC0CB;"><?php echo $class->classTitle ?></th>
                    <?php
                    $total_class_enrollment = 0;
                    foreach ($ages  as $age) { ?>
                      <td style="text-align: center; background-color: #ffd3db;"><?php $query = "SELECT `enrolled` FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND class_id ='" . $class->classId . "'
                                            AND school_id = '" . $school_id . "'
                                            AND gender_id = '2'";
                                                                                  $query_result = $this->db->query($query)->result();
                                                                                  if ($query_result) {
                                                                                    $total_class_enrollment += $query_result[0]->enrolled;
                                                                                    echo $query_result[0]->enrolled;
                                                                                  }
                                                                                  ?></td>
                    <?php
                      $total_school_entrollment += $total_class_enrollment;
                    } ?>
                    <th style="text-align: center; background-color: #FFC0CB;"><?php echo $total_class_enrollment; ?></th>
                    <?php $query = "SELECT `non_muslim`,`disabled` FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND class_id ='" . $class->classId . "' 
                                  AND gender_id ='2' ";
                    $query_result = $this->db->query($query)->result();
                    ?>
                    <th style="background-color: #FFC0CB; text-align: center;"><?php if ($query_result) {
                                                                                  echo $query_result[0]->non_muslim;
                                                                                } ?> </th>
                    <th style="background-color: #FFC0CB; text-align: center;"> <?php if ($query_result) {
                                                                                  echo $query_result[0]->disabled;
                                                                                } ?> </th>

                    <td style="text-align: center;">
                      <?php if ($total_class_enrollment) { ?>
                        <button type="button" class="btn btn-success btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_ages_from(2, <?php echo $class->classId ?>)">
                          Edit
                        </button>

                      <?php  } else { ?>
                        <button type="button" class="btn btn-danger btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_ages_from(2, <?php echo $class->classId ?>)">
                          Add
                        </button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>

                <tr>
                  <th style="text-align: right; background-color: #FFC0CB;">Total</th>
                  <?php
                  $total_school_entrollment  = 0;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center; background-color: #FFC0CB;"><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND school_id = '" . $school_id . "'
                                            AND gender_id = '2'";
                                                                                $query_result = $this->db->query($query)->result();
                                                                                if ($query_result) {
                                                                                  $total_school_entrollment += $query_result[0]->enrolled;
                                                                                  echo $query_result[0]->enrolled;
                                                                                }
                                                                                ?></th>
                  <?php } ?>


                  <th style="text-align: center; background-color: #FFC0CB;"><?php echo $total_school_entrollment; ?></th>
                  <?php $query = "SELECT SUM(`non_muslim`) as non_muslim, SUM(`disabled`) as disabled
                                  FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND gender_id ='2' ";
                  $query_result = $this->db->query($query)->result();
                  ?>
                  <th style="text-align: center; background-color: #FFC0CB;"><?php if ($query_result) {
                                                                                echo $query_result[0]->non_muslim;
                                                                              } ?> </th>
                  <th style="text-align: center; background-color: #FFC0CB;"> <?php if ($query_result) {
                                                                                echo $query_result[0]->disabled;
                                                                              } ?> </th>
                  <td></td>
                </tr>
              </table>





            </div>
            <div class="col-md-12">
              <table class="table table-bordered">
                <tr style="text-align: center; background-color: #8CAE12;">
                  <th rowspan="2" style="text-align: center; vertical-align: middle; background-color: #337AB7; color:white">Total School Enrolment<br />
                    Session: <?php echo $session_detail->sessionYearTitle; ?></th>
                  <th colspan="19" style="text-align: center; background-color: #337AB7; color:white">Age Categories</th>
                  <th colspan="3" style="background-color: #337AB7; color:white"></th>
                </tr>
                <tr>
                  <?php
                  $count = 1;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center; background-color: #337AB7; color:white"><?php echo $age->ageTitle; ?></th>
                  <?php } ?>
                  <th style="background-color: #337AB7; color:white; text-align: center;">Total</th>
                  <th style="background-color: #337AB7; color:white; text-align:center;">Non-Muslims</th>
                  <th style="background-color: #337AB7; color:white; text-align: center;">Disabled</th>
                </tr>

                <?php foreach ($classes  as $class) { ?>
                  <tr>
                    <th style=""><?php echo $class->classTitle ?></th>
                    <?php
                    $total_class_enrollment = 0;
                    foreach ($ages  as $age) { ?>
                      <td style="text-align: center;"><?php $query = "SELECT SUM(`enrolled`) as enrolled  FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND class_id ='" . $class->classId . "'
                                            AND school_id = '" . $school_id . "'";
                                                      $query_result = $this->db->query($query)->result();
                                                      if ($query_result) {
                                                        $total_class_enrollment += $query_result[0]->enrolled;
                                                        echo $query_result[0]->enrolled;
                                                      }
                                                      ?></td>
                    <?php
                      $total_school_entrollment += $total_class_enrollment;
                    } ?>
                    <th style="text-align: center; "><?php echo $total_class_enrollment; ?></th>
                    <?php $query = "SELECT SUM(`non_muslim`) as non_muslim,
                    SUM(`disabled`) as disabled FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'
                                  AND class_id ='" . $class->classId . "'  ";
                    $query_result = $this->db->query($query)->result();
                    ?>
                    <th style=" text-align: center;"><?php if ($query_result) {
                                                        echo $query_result[0]->non_muslim;
                                                      } ?> </th>
                    <th style=" text-align: center;"> <?php if ($query_result) {
                                                        echo $query_result[0]->disabled;
                                                      } ?> </th>


                  </tr>
                <?php } ?>
                <tr>
                  <th style="text-align: right; ">Total</th>
                  <?php
                  $total_school_entrollment  = 0;
                  foreach ($ages  as $age) { ?>
                    <th style="text-align: center; "><?php $query = "SELECT SUM(`enrolled`) as enrolled FROM `age_and_class` 
                                            WHERE age_id ='" . $age->ageId . "' 
                                            AND school_id = '" . $school_id . "'";
                                                      $query_result = $this->db->query($query)->result();
                                                      if ($query_result) {
                                                        $total_school_entrollment += $query_result[0]->enrolled;
                                                        echo $query_result[0]->enrolled;
                                                      }
                                                      ?></th>
                  <?php } ?>


                  <th style="text-align: center; "><?php echo $total_school_entrollment; ?></th>
                  <?php $query = "SELECT SUM(`non_muslim`) as non_muslim, SUM(`disabled`) as disabled
                                  FROM `school_enrolments`  
                                  WHERE  school_id ='" . $school_id . "'
                                  AND session_id =  '" . $session_id . "'";
                  $query_result = $this->db->query($query)->result();
                  ?>
                  <th style="text-align: center; "><?php if ($query_result) {
                                                      echo $query_result[0]->non_muslim;
                                                    } ?> </th>
                  <th style="text-align: center; "> <?php if ($query_result) {
                                                      echo $query_result[0]->disabled;
                                                    } ?> </th>
                  <td></td>
                </tr>

              </table>

            </div>


            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <a class="btn btn-link pull-left" href="<?php echo site_url("form/section_d/$session_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Section B ( Physical Facilities ) </a>
                <input class="btn btn-primary" type="submit" name="" value="Add Section C Data" />
                <a class="btn btn-link pull-right" href="<?php echo site_url("form/section_d/$session_id"); ?>">
                  Section D ( Employees Detail )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
              </div>
            </div>


          </div>
        </div>



      </div>

  </div>
  </section>

  </div>