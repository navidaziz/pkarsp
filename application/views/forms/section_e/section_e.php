  <!-- Modal -->
  <script>
    function update_class_fee_detail(class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_fee_from"); ?>",
        data: {
          schools_id: <?php echo $school->schoolId; ?>,
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
        <?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?>
      </h2>
      <br />
      <small><?php echo @$description; ?></small>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo @$description; ?></h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <h3><?php echo $school->schoolName; ?></h3>
              <h4>S-ID: <?php echo $school->schoolId; ?> - REG No: <?php echo $school->registrationNumber ?></h4>

            </div>
            <div class="col-md-9">
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
                  Note:
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
                  $sessions =  $this->db->query("SELECT * FROM `session_year` 
                  WHERE `session_year`.`sessionYearId`<= $session_id
                  ORDER BY `session_year`.`sessionYearId` DESC LIMIT 3")->result();
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
                                `school` INNER JOIN `fee` 
                                ON (`school`.`schoolId` = `fee`.`school_id`)
                                WHERE `school`.`schools_id` = '" . $school->schoolId . "'
                                AND `fee`.`class_id` ='" . $class->classId . "'
                                AND `school`.`session_year_id`='" . $session->sessionYearId . "';";
                      $session_fee = $this->db->query($query)->result()[0];

                    ?>
                      <td style="text-align: center;"><?php if (is_numeric($session_fee->addmissionFee)) {
                                                        echo $session_fee->addmissionFee;
                                                      } ?></td>
                      <td style="text-align: center;"><?php if (is_numeric($session_fee->tuitionFee)) {
                                                        echo $session_fee->tuitionFee;
                                                      } ?></td>
                      <td style="text-align: center;"><?php if (is_numeric($session_fee->securityFund)) {
                                                        echo $session_fee->securityFund;
                                                      } ?></td>
                      <td style="text-align: center;"><?php if (is_numeric($session_fee->otherFund)) {
                                                        echo $session_fee->otherFund;
                                                      } ?></td>




                      <?php if ($session_fee) {
                        $add = 1;
                      } else {
                        $add = 0;
                      } ?>

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


                      <?php } ?>

                    <?php } ?>

                  </tr>
                <?php } ?>


              </table>

              <?php

              echo $form_complete;

              ?>




            </div>

          </div>
        </div>


      </div>

  </div>
  </section>

  </div>