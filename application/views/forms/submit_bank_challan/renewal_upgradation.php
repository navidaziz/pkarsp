<div class="content-wrapper">
  <?php $this->load->view('forms/form_header');   ?>

  <!-- Main content -->
  <section class="content" style="padding-top: 0px !important;">
    <?php $this->load->view('forms/navigation_bar');   ?>
    <div class="box box-primary box-solid">

      <div class="box-body" style="padding: 3px;">

        <div class="row">
          <div class="col-md-7" style="padding-right: 1px;  padding-left: 10px;">
            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculates <i>"Deposit Fee Challan" ?</i></h4>
                <ol>
                  <li>According to the data you have entered,
                    For session <strong><?php echo $session_detail->sessionYearTitle; ?></strong> your institute
                    charged Max Tuition Fee
                    <strong><?php echo $max_tuition_fee; ?> Rs. </strong> per month.
                  </li>
                  <li>As per PSRA Registration and Renewal Fee Structure, Institute charging monthly fee between
                    <strong><?php echo $fee_sturucture->fee_min; ?> Rs. </strong> and <strong> <?php echo $fee_sturucture->fee_max; ?> Rs. </strong>
                    Must Deposit
                    <ol>
                      <li> Application Processing Fee: <strong><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs. </strong></li>
                      <li> Inspection Fee: <strong><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</strong></li>
                      <li> Upgradation Fee: <strong><?php echo $fee_sturucture->up_grad_fee; ?> Rs.</strong></li>
                      <li> Renewal Fee: <strong><?php echo $fee_sturucture->renewal_fee; ?> Rs.</strong></li>



                    </ol>
                    In case of confusion and queries, please contact <strong>PSRA MIS Section
                      <a style="font-weight: bold; color:red" href="tel:+92091-9216205">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        091-9216205 </a></strong></strong>
                    <br />

                    <button onclick="renewal_fee_sturucture()" class="btn btn-link">
                      <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Registration Fee Struture Detail</button>
              </div>


            </div>
            <?php $this->load->view('forms/submit_bank_challan/cut_off_dates');   ?>
            <?php $this->load->view('forms/submit_bank_challan/online_apply_instructions');   ?>
          </div>

          <div class="col-md-5">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
              <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Upgradation-Renewal Fee Detail</h4>
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
                    <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?> Rs.</td>
                  </tr>
                  <tr>
                    <td>Inspection Fee</td>
                    <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?> Rs.</td>
                  </tr>
                  <tr>
                    <td>Upgradation Fee</td>
                    <td><?php echo $fee_sturucture->up_grad_fee; ?> Rs.</td>
                  </tr>
                  <tr>
                    <td>Renewal Fee</td>
                    <td><?php echo $fee_sturucture->renewal_fee; ?> Rs.</td>
                  </tr>

                  <tr>
                    <td><strong>Total Session <?php echo $session_detail->sessionYearTitle; ?> Upgradation-Renewal Fee </strong></td>
                    <td>
                      <strong>
                        <?php $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee + $fee_sturucture->up_grad_fee;

                        echo number_format($total);
                        ?> Rs.
                      </strong>
                    </td>
                  </tr>



                  <tr>
                    <td colspan="2">
                      <table class="table">
                        <tr>
                          <th> Due's Date </th>
                          <th>Upgradation-Renewal Fee</th>
                          <th> Late Fee % </th>
                          <th> Late Fee Amount </th>
                          <th> Total </th>
                        </tr>
                        <?php
                        $count = 1;
                        $previous_last_date = '';
                        foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>

                          <tr>
                            <td style="width: 200px;">
                              <?php if ($count == 1) { ?>

                                <!-- <strong> 01 Apr, <?php echo date('Y', strtotime($session_fee_submission_date->last_date)); ?></strong> to  -->

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

                            <td><?php echo number_format($total) ?></td>
                            <?php if ($session_fee_submission_date->fine_percentage == 0) { ?>
                              <td colspan="2"> <strong> Normal Fee </strong></td>
                            <?php } else { ?>
                              <td style="color:red"><?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
                              <td style="color:red">
                                <?php
                                $fine = 0;
                                $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                echo number_format($fine);
                                ?>
                              </td>
                            <?php } ?>

                            <td>
                              <strong> <?php echo number_format($fine + $total);  ?> </strong>
                            </td>
                          </tr>



                        <?php
                          $count++;
                        } ?>
                      </table>
                    </td>

                  <tr>
                    <td colspan="2" style="text-align:center;">
                      <a target="new" class="btn btn-primary" href="<?php echo site_url("form/print_renewal_upgradation_bank_challan/$school_id") ?>"> <i class="fa fa-print" aria-hidden="true"></i> Print PSRA Upgradation + Renewal Bank Challan From</a>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>
            <?php $query = "SELECT school.session_year_id, 
                                     school.status, 
                                     session_year.sessionYearTitle 
                                     FROM school, session_year 
                              WHERE 
                              school.session_year_id = session_year.sessionYearId
                              AND schools_id = '" . $schools_id . "' 
                              AND  session_year_id = '" . ($session_id - 1) . "'";
            $previous_session = $this->db->query($query)->result()[0];
            if ($previous_session->status == 0) {
            ?>

              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                Please submit previous session <?php echo $previous_session->sessionYearTitle; ?> STAN No and Date First then you are allow to submit this session STAN No.
              </div>
            <?php } else { ?>
              <?php $this->load->view('forms/submit_bank_challan/online_apply');   ?>
            <?php } ?>
          </div>


        </div>

      </div>

    </div>
  </section>

</div>