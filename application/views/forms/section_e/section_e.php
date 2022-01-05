  <!-- Modal -->
  <script>
    function update_class_fee_detail(class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_fee_from"); ?>",
        data: {
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
      <h4>S-ID: <?php echo $school->schools_id; ?>
        <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <?php $this->load->view('forms/navigation_bar');   ?>

      <div class="box box-primary box-solid">

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
                  padding: 5px !important;
                }
              </style>



              <p>
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION E</strong> (SCHOOL FEE DETAIL)<br />
                <small style="color: red;">
                  Note: please fill fee detail for all classes.
                </small>
              </h4>

              </small>
              </p>
              <table class="table table-bordered">
                <tr>
                  <th rowspan="2" style="text-align: center; vertical-align: middle;">Classes</th>

                </tr>
                <tr>

                  <?php
                  $query = "SELECT
                          `session_year`.`sessionYearTitle`
                          , `session_year`.`sessionYearId`
                          , `school`.`schoolId`
                          FROM
                          `school`
                          INNER JOIN `session_year` 
                          ON (`school`.`session_year_id` = `session_year`.`sessionYearId`)
                          WHERE `session_year`.`sessionYearId`<= $session_id
                          AND  `school`.`schools_id` = '" . $school->schools_id . "'
                          ORDER BY `session_year`.`sessionYearId` DESC LIMIT 3";
                  $sessions =  $this->db->query($query)->result();

                  asort($sessions);
                  foreach ($sessions  as $session) { ?>
                    <th colspan="4" style="text-align: center;"><?php echo $session->sessionYearTitle; ?></th>
                  <?php } ?>

                </tr>
                <tr>
                  <th></th>
                  <?php
                  foreach ($sessions  as $session) { ?>
                    <th style="text-align: center;">Admision </th>
                    <th style="text-align: center;">Tuition</th>
                    <th style="text-align: center;">Security</th>
                    <th style="text-align: center;">Others</th>
                  <?php } ?>
                </tr>

                <?php
                $form_complete = 1;
                foreach ($classes  as $class) {
                  $add = 1;
                ?>
                  <tr>
                    <th><?php echo $class->classTitle ?></th>
                    <?php

                    foreach ($sessions  as $session) {
                      $query = "SELECT 
                                  `fee`.`addmissionFee`
                                , `fee`.`tuitionFee`
                                , `fee`.`securityFund`
                                , `fee`.`otherFund`
                            FROM
                                `fee`  WHERE `fee`.`school_id` = '" . $session->schoolId . "'
                                AND `fee`.`class_id` ='" . $class->classId . "'";

                      $session_fee = $this->db->query($query)->result()[0];
                      if ($session_fee) {
                        $add = 1;
                      } else {
                        $add = 0;
                      }

                      $session_fee->addmissionFee = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->addmissionFee));
                      $session_fee->tuitionFee = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->tuitionFee));
                      $session_fee->securityFund = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->securityFund));
                      $session_fee->otherFund = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->otherFund));

                    ?>
                      <td style="text-align: center;"><?php //if (is_numeric($session_fee->addmissionFee)) {
                                                      echo $session_fee->addmissionFee;
                                                      //} 
                                                      ?></td>
                      <td style="text-align: center;"><?php //if (is_numeric($session_fee->tuitionFee)) {
                                                      echo $session_fee->tuitionFee;
                                                      //} 
                                                      ?></td>
                      <td style="text-align: center;"><?php //if (is_numeric($session_fee->securityFund)) {
                                                      echo $session_fee->securityFund;
                                                      //} 
                                                      ?></td>
                      <td style="text-align: center;"><?php //if (is_numeric($session_fee->otherFund)) {
                                                      echo $session_fee->otherFund;
                                                      //} 
                                                      ?></td>





                      <?php

                      if ($session->sessionYearId == $session_id) {
                        if ($add) {

                      ?>
                          <td style="text-align: center;">
                            <button type="button" class="btn btn-success btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_fee_detail(<?php echo $class->classId ?>)">
                              Edit
                            </button>

                          </td>

                        <?php  } else {

                          $form_complete = 0;
                        ?>
                          <td style="text-align: center;">
                            <button type="button" class="btn btn-danger btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_fee_detail(<?php echo $class->classId ?>)">
                              Add
                            </button>
                          </td>

                        <?php } ?>


                      <?php  } ?>

                    <?php } ?>

                  </tr>
                <?php } ?>


              </table>





            </div>


            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
                <a class="btn btn-link pull-left" href="<?php echo site_url("form/section_d/$session_id"); ?>">

                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Section D ( School Fee Detail ) </a>
                <?php if ($form_complete) { ?>
                  <a href="<?php echo site_url("form/complete_section_e/$session_id"); ?>" class="btn btn-primary">Add Section E Data</a>
                <?php } else { ?> <br /> <?php } ?>
                <?php if ($form_status->form_e_status == 1) { ?>
                  <a class="btn btn-link pull-right" href="<?php echo site_url("form/section_f/$session_id"); ?>">
                    Section F ( Security Measures )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>
                <?php } ?>
              </div>
            </div>

          </div>
        </div>


      </div>

  </div>
  </section>

  </div>