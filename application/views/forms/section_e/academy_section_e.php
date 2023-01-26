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
      <h4>Institute ID: <?php echo $school->schools_id; ?>
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
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION E</strong> (Institute Courses and Max Fee Detail)<br />
                <small style="color: red;">
                  Note: Please fill exact tuition fee details as this data will be used in making PSRA fee bank challan for you at the end of this application form.
                  <br />
                  <p style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl;">
                    براہ کرم ٹیوشن فیس کی صحیح تفصیلات پُر کریں کیونکہ اس ڈیٹا کو اس درخواست فارم کے آخر میں آپ کے لیے PSRA فیس بینک چالان بنانے میں استعمال کیا جائے گا۔
                  </p>
                </small>
              </h4>
            </div>
            <div class="col-md-5">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 15px; background-color: white;">

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

            <div class="col-md-7">
              <form action="<?php echo site_url("form/update_class_fee") ?>" method="post">
                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 15px; background-color: white;">
                  <h4>Academy Courses Detail</h4>
                  <ul style="list-style: none;">
                    <?php

                    $query = "SELECT * FROM academy_courses 
		                          WHERE school_id ='" . $school_id . "'";
                    $session_courses = $this->db->query($query)->row_array();

                    $courses = array(
                      "fcta" => 'Formal Cource Teaching Academy / Center',
                      "ccpa" => 'Cadet College Preparation Academy / Center',
                      "frca" => 'Forces Recuitment Coaching Academy / Center',
                      "css_pms" => 'CSS / PMS Coaching Academy / Center',
                      "etea" => 'ETEA Coaching Academy / Center',
                      "language" => 'Language Academy / Center'
                    );
                    foreach ($courses as $index => $course) { ?>
                      <li>
                        <h4>
                          <input <?php if ($session_courses["$index"] == 1) { ?> checked <?php } ?> type="checkbox" name="courses[]" value="<?php echo $index; ?>" />
                          <span style="margin-left: 20px;"></span>
                          <?php echo $course; ?>
                        </h4>
                      </li>
                    <?php  } ?>
                  </ul>



                  <?php $class_id = 16;
                  $form_complete = 0;
                  ?>
                  <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                  <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />
                  <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                  <?php
                  $query = "SELECT * FROM fee WHERE school_id = '" . $school_id . "' AND class_id = '" . $class_id . "'";
                  $class_fees = $this->db->query($query)->result()[0];
                  if ($class_fees) {
                    $form_complete = 1;
                    $form_input['form_e_status'] = 1;
                    $form_input['form_f_status'] = 1;
                    $form_input['form_g_status'] = 1;
                    $form_input['form_h_status'] = 1;
                    $this->db->where('school_id', $school_id);
                    $this->db->update('forms_process', $form_input);
                    $form_status->form_e_status = 1;
                  }
                  ?>
                  <input min="0" type="hidden" name="otherFund" value="<?php echo $class_fees->otherFund; ?>" />
                  <input min="0" type="hidden" name="addmissionFee" value="<?php echo $class_fees->addmissionFee; ?>" />
                  <input min="0" type="hidden" name="securityFund" value="<?php echo $class_fees->securityFund; ?>" />
                  <br />
                  <h4>Maximum fee charged per student (Per Month) / (Per Course)
                    <span style="margin-left: 20px;"></span>
                    <input class="form-control" style="width: 200px;" required min="0" type="number" name="tuitionFee" value="<?php echo $class_fees->tuitionFee; ?>" />
                  </h4>
                  <p>

                    <?php

                    $query = "SELECT * FROM `fee_mentioned_in_form_or_prospectus` WHERE school_id = '" . $school_id . "'";
                    $fee_mention = $this->db->query($query)->result()[0];
                    ?>

                    Whether the above fees are mentioned in the prospectus / admission form ? <span style="margin-left: 15px;"></span>
                    <input value="Yes" required <?php if ($fee_mention->feeMentionedInForm == 'Yes') { ?> checked <?php } ?> type="radio" name="pro"> Yes <span style="margin-left: 15px;"></span>
                    <input value="No" required <?php if ($fee_mention->feeMentionedInForm == 'No') { ?> checked <?php } ?> type="radio" name="pro"> No <br>
                    Whether the fee structure is displayed both inside and outside school at a prominent place? <span style="margin-left: 15px;"></span>
                    <input value="Yes" required <?php if ($fee_mention->FeeMentionOutside == 'Yes') { ?> checked <?php } ?> type="radio" name="outside"> Yes <span style="margin-left: 15px;"></span>
                    <input value="No" required <?php if ($fee_mention->FeeMentionOutside == 'No') { ?> checked <?php } ?> type="radio" name="outside"> No

                  </p>




                  <p style="text-align: center;">
                    <br />
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Update Courses and Fee Detail" />
                  </p>
              </form>


            </div>
          </div>

          <div class="col-sm-12">


          </div>



        </div>


        <div class="col-md-12">
          <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 30px;  margin: 10px; padding: 10px; background-color: white;">
            <a class="btn btn-success pull-left" href="<?php echo site_url("form/section_d/$school_id"); ?>">

              <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( Institute Employees Detail ) </a>



            <?php if ($form_status->form_e_status == 1) { ?>
              <a class="btn btn-success pull-right" href="<?php echo site_url("form/submit_bank_challan/$school_id"); ?>"> Next Section (Bank Challan) <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>

              <br />
              <br />
            <?php } else { ?>
              <br />
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