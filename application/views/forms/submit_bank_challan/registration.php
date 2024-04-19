  <div class="content-wrapper">
    <?php $this->load->view('forms/form_header');   ?>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <?php $this->load->view('forms/navigation_bar');   ?>
      <div class="box box-primary box-solid">
        <div class="box-body">

          <div class="row">

            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Registration Fee Detail</h4>
                <div class="table-responsive">
                  <table class="table" style="font-size: 13px;">
                    <thead>
                      <tr>
                        <th>Fee Category</th>
                        <th>Amount (Rs.)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Application Processing Fee</td>
                        <td>Rs. <?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
                      </tr>
                      <tr>
                        <td>Inspection Fee</td>
                        <td>Rs. <?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>
                      </tr>
                      <tr>
                        <td><strong> Session <?php echo $session_detail->sessionYearTitle; ?> Registration Fee </strong></td>
                        <td>
                          <strong>
                            <?php $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee;

                            echo number_format($total);
                            ?> Rs.
                          </strong>
                        </td>

                      </tr>

                      <tr>
                        <td colspan="2">
                          <style>
                            .table_reg>tbody>tr>td,
                            .table_reg>tbody>tr>th,
                            .table_reg>tfoot>tr>td,
                            .table_reg>tfoot>tr>th,
                            .table_reg>thead>tr>td,
                            .table_reg>thead>tr>th {
                              padding: 3px;
                              line-height: 1.42857143;
                              vertical-align: top;
                              border-top: 1px solid #ddd;
                              text-align: center;
                            }
                          </style>

                          <table class="table table_reg">
                            <tr>
                              <th> Due's Date </th>
                              <th>Registration Fee </th>
                              <th> Late Fee % </th>
                              <th> Late Fee </th>

                              <th>Total</th>
                            </tr>
                            <?php $count = 1;
                            $previous_last_date = '';
                            foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>

                              <tr>
                                <td style="width: 200px;">
                                  <?php if ($count == 1) { ?>

                                    <span>Up to </span>

                                  <?php } else { ?>
                                    <?php if ($count >= sizeof($session_fee_submission_dates)) { ?>
                                      After
                                    <?php } else { ?>
                                      <strong> <?php echo $previous_last_date; ?> </strong> to
                                    <?php } ?>
                                  <?php } ?>
                                  <?php
                                  $previous_last_date = date('d M, Y', strtotime($session_fee_submission_date->last_date . ' +1 day'));
                                  if ($count >= sizeof($session_fee_submission_dates)) {
                                    echo "<strong>" . date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day')) . "</strong>";
                                  } else {
                                    echo "<strong>" . date('d M, Y', strtotime($session_fee_submission_date->last_date)) . "</strong>";
                                  }
                                  ?>


                                </td>

                                <td>
                                  <?php echo number_format($total);  ?>
                                </td>
                                <?php if ($session_fee_submission_date->fine_percentage == 0) { ?>
                                  <td colspan="2"> <strong> Normal Fee </strong></td>
                                <?php } else { ?>
                                  <td style="color: red;">

                                    <?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
                                  <td style="color: red;">

                                    <?php
                                    $fine = 0;
                                    $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                    echo number_format($fine);
                                    ?>

                                  </td>
                                <?php } ?>


                                <td>
                                  <strong>


                                    <?php echo number_format($fine + $total + $security); ?>

                                  </strong>
                                </td>

                              </tr>



                            <?php
                              $count++;
                            } ?>

                          </table>
                        </td>

                      </tr>


                      <tr>
                        <td colspan="2" style="text-align:center;">
                          <h5>برائے مہربانی نیچے دیے ہوئے بینک چالان پرنٹ کریں اور بینک میں جمع کر لیں</h5>
                          <a target="new" class="btn btn-warning" href="<?php echo site_url("form/print_registration_bank_challan/$school_id") ?>"> <i class="fa fa-print" aria-hidden="true"></i> Print PSRA Registration Challan</a>
                          <?php if ($school->biseRegister != 'Yes') { ?>

                            <?php if ($school->level_of_school_id == 1) { ?>
                              <a target="_blank" class="btn btn-warning" href="<?php echo site_url('print_file/security_slip/1/' . $schools_id) ?>">
                                <i class="fa fa-print"></i> Primary Security Challan</a>
                            <?php } ?>
                            <?php if ($school->level_of_school_id == 2) { ?>
                              <a target="_blank" class="btn btn-warning" href="<?php echo site_url('print_file/security_slip/2/' . $schools_id) ?>">
                                <i class="fa fa-print"></i> Middle Security Challan</a>
                            <?php } ?>
                            <?php if ($school->level_of_school_id == 3) { ?>
                              <a target="_blank" class="btn btn-warning" href="<?php echo site_url('print_file/security_slip/3/' . $schools_id) ?>">
                                <i class="fa fa-print"></i> High Security Challan</a>
                            <?php } ?>
                            <?php if ($school->level_of_school_id == 4) { ?>
                              <a target="_blank" class="btn btn-warning" href="<?php echo site_url('print_file/security_slip/4/' . $schools_id) ?>">
                                <i class="fa fa-print"></i> Higher Secondary Security Challan</a>
                            <?php } ?>

                          <?php } ?>

                          <?php if ($school->biseRegister == 'Yes') { ?>
                            <div style="border:1px solid #9FC8E8; border-radius: 10px; color:red; min-height: 100px;  margin: 5px; padding: 5px;">

                              <p>
                                As soon as the PSRA official examines the case or processes it, he or she will inform you of the security associated with it.
                              </p>
                              <p>
                                جیسے ہی اہلکار کیس کی جانچ کرے گا یا اس پر کارروائی کرے گا، وہ آپ کو اس سے منسلک سیکیورٹی کے بارے میں مطلع کرے گا۔
                              </p>
                            </div>
                          <?php } ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">

              <?php $this->load->view('forms/submit_bank_challan/online_apply');   ?>
            </div>
          </div>
          <div class="row">

            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>
                  <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculate <i>"Deposit Fee Challan" ?</i>
                </h4>
                <ol>
                  <li>According to the data you have entered, your institute was established in <strong><?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong>.
                    For session <strong><?php echo $session_detail->sessionYearTitle; ?></strong> your institute
                    charged Max Fee
                    <strong><?php echo $max_tuition_fee; ?> Rs. </strong> per month.
                  </li>
                  <li>As per PSRA Registration and Renewal Fee Structure, Institute charging monthly fee between
                    <strong><?php echo $fee_sturucture->fee_min; ?> Rs. </strong> and <strong> <?php echo $fee_sturucture->fee_max; ?> Rs. </strong>
                    Must Deposit
                    <ol>
                      <li> Application Processing Fee: <strong><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs. </strong></li>
                      <li> Inspection Fee: <strong><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</strong></li>
                      <li> Security Fee (1st Time Registration)
                        <ol>
                          <?php
                          $query = "SELECT * FROM `levelofinstitute`
                              WHERE school_type_id = '" . $school->school_type_id . "'
                              ";
                          $level_securities = $this->db->query($query)->result();
                          foreach ($level_securities as $level_security) {
                          ?>
                            <li><?php echo  $level_security->levelofInstituteTitle; ?> <strong> <?php echo  $level_security->security_fee; ?> Rs.</strong> </li>
                          <?php } ?>
                        </ol>
                      </li>

                  </li>

                </ol>
                <li>In case of confusion and queries, please contact <strong>PSRA MIS Section <a style="font-weight: bold; color:red" href="tel:+92091-9216205">
                      <i class="fa fa-phone" aria-hidden="true"></i>
                      091-9216205 </a></strong></li>
                </li>
                </ol>
                <button onclick="renewal_fee_sturucture()" class="btn btn-link">
                  <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Registration Fee Struture Detail</button>
              </div>
            </div>

            <?php //$this->load->view('forms/submit_bank_challan/cut_off_dates');
            ?>
            <div class="col-md-6">
              <?php $this->load->view('forms/submit_bank_challan/online_apply_instructions');
              ?>
            </div>





          </div>


        </div>


      </div>
    </section>

  </div>