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
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
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
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION E</strong> (SCHOOL FEE DETAIL)<br />
                <small style="color: red;">
                  Note: Please fill exact tuition fee details as this data will be used in making PSRA fee bank challan for you at the end of this application form.
                  <br />
                  <p style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl;">
                    براہ کرم ٹیوشن فیس کی صحیح تفصیلات پُر کریں کیونکہ اس ڈیٹا کو اس درخواست فارم کے آخر میں آپ کے لیے PSRA فیس بینک چالان بنانے میں استعمال کیا جائے گا۔
                  </p>
                </small>
              </h4>
            </div>
            <div class="col-md-3">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">

                <div style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl; line-height: 30px;">
                  <h4 style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl;"> ضروری انتباہ
                  </h4>
                  KP-PSRA ریگولیشنز ایکٹ 2018 کے مطابق کوئی بھی پرائیویٹ اسکول داخلہ فیس، سالانہ فیس اور کیپٹیشن فیس کسی بھی نام سے نہیں لے سکتا اور پشاور ہائی کورٹ نے ایک رٹ پٹیشن میں فیصلہ دیا جس کا نمبر WP-NO-1995- 2020 مورخہ 14.12.2021 ہے۔
                </div>

                <br />

                <h4 style="font-weight: bold;"> Warning</h4>
                <p style="font-size: 16px; line-height: 22px;">No private school can charge admission fee, annual fee and capitation fee under whatever name as per KP-PSRA Regulations Act 2018 and also peshawar high court judgment in a writ petition bearing number WP-NO-1995- of 2020 Dated 14.12.2021</p>




              </div>
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
                    <th colspan="" style="text-align: center;"><?php echo $session->sessionYearTitle; ?></th>
                  <?php } ?>

                </tr>
                <tr>
                  <th></th>
                  <?php
                  foreach ($sessions  as $session) { ?>
                    <th style="text-align: center; display: none;">Admision </th>
                    <th style="text-align: center;">Tuition Fee</th>
                    <th style="text-align: center; display: none;">Security</th>
                    <th style="text-align: center; display: none;">Others</th>
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

                      // $session_fee->addmissionFee = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->addmissionFee));
                      // $session_fee->tuitionFee = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->tuitionFee));
                      // $session_fee->securityFund = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->securityFund));
                      // $session_fee->otherFund = preg_replace('/[^0-9.]/', '', str_replace("Rs.", "", $session_fee->otherFund));

                    ?>
                      <td style="text-align: center; display: none;"><?php //if (is_numeric($session_fee->addmissionFee)) {
                                                                      echo $session_fee->addmissionFee;
                                                                      //} 
                                                                      ?></td>
                      <td style="text-align: center; "><?php //if (is_numeric($session_fee->tuitionFee)) {
                                                        echo $session_fee->tuitionFee;
                                                        //} 
                                                        ?></td>
                      <td style="text-align: center; display: none;"><?php //if (is_numeric($session_fee->securityFund)) {
                                                                      echo $session_fee->securityFund;
                                                                      //} 
                                                                      ?></td>
                      <td style="text-align: center; display: none;"><?php //if (is_numeric($session_fee->otherFund)) {
                                                                      echo $session_fee->otherFund;
                                                                      //} 
                                                                      ?></td>





                      <?php

                      if ($session->sessionYearId == $session_id and $school_id == $session->schoolId) {
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

              <div class="col-sm-12">
                <?php
                $query = "SELECT * FROM `fee_mentioned_in_form_or_prospectus` WHERE school_id = '" . $school_id . "'";
                $fee_mention = $this->db->query($query)->result()[0];

                ?>
                <form method="post" action="<?php echo site_url("form/complete_section_e/"); ?>">
                  <input type="hidden" value="<?php echo $school_id; ?>" name="school_id" />
                  <input type="hidden" value="<?php echo $fee_mention->feeMentionedInFormId; ?>" name="feeMentionedInFormId" />
                  Whether the above fees are mentioned in the prospectus/admission form ? <span style="margin-left: 15px;"></span>
                  <input value="Yes" required <?php if ($fee_mention->feeMentionedInForm == 'Yes') { ?> checked <?php } ?> type="radio" name="pro"> Yes <span style="margin-left: 15px;"></span>
                  <input value="No" required <?php if ($fee_mention->feeMentionedInForm == 'No') { ?> checked <?php } ?> type="radio" name="pro"> No <br>
                  Whether the fee structure is displayed both inside and outside school at a prominent place? <span style="margin-left: 15px;"></span>
                  <input value="Yes" required <?php if ($fee_mention->FeeMentionOutside == 'Yes') { ?> checked <?php } ?> type="radio" name="outside"> Yes <span style="margin-left: 15px;"></span>
                  <input value="No" required <?php if ($fee_mention->FeeMentionOutside == 'No') { ?> checked <?php } ?> type="radio" name="outside"> No

              </div>



            </div>


            <div class="col-md-12">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 30px;  margin: 10px; padding: 10px; background-color: white;">
                <a class="btn btn-success pull-left" href="<?php echo site_url("form/section_d/$school_id"); ?>">

                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( School Fee Detail ) </a>
                <?php if ($form_complete and $form_status->form_e_status == 0) { ?>
                  <input class="btn btn-danger" type="submit" name="Add Section E Data" value="Add Section E Data" />
                  <!-- <a href="<?php echo site_url("form/complete_section_e/$school_id"); ?>" class="btn btn-primary">Add Section E Data</a> -->
                <?php }  ?>

                <?php if ($form_complete and $form_status->form_e_status == 1) { ?>
                  <input class="btn btn-primary" type="submit" name="Add Section E Data" value="Update Section E Data" />
                  <!-- <a href="<?php echo site_url("form/complete_section_e/$school_id"); ?>" class="btn btn-primary">Add Section E Data</a> -->
                <?php }  ?>
                </form>
                <?php if ($form_status->form_e_status == 1) { ?>
                  <a class="btn btn-success pull-right" href="<?php echo site_url("form/section_f/$school_id"); ?>">
                    Next Section ( Security Measures )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>

                <?php } else { ?>
                  <br />
                <?php } ?>
              </div>
            </div>

          </div>
        </div>


      </div>

  </div>
  </section>

  </div>