  <!-- Modal -->
  <script>
    function renewal_fee_sturucture() {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("registration_section/renewal_fee_sturucture"); ?>",
        data: {}
      }).done(function(data) {

        $('#renewal_sturucture_body').html(data);
      });

      $('#renewal_sturucture_model').modal('toggle');
    }
  </script>
  <div class="modal fade" id="renewal_sturucture_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 70%;">
      <div class="modal-content" id="renewal_sturucture_body">

        ...

      </div>
    </div>
  </div>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;"><?php echo ucwords(strtolower($school->schoolName)); ?>

      </h2>
      <br />
      <small>
        <h4>S-ID: <?php echo $school->schools_id; ?> <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      </small>
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

        <div class="box-body" style="padding: 3px;">

          <form method="post" action="<?php echo site_url("form/update_test_renewal/" . $session_id); ?>">
            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
            <input type="hidden" name="schools_id" value="<?php echo $school->schools_id; ?>" />


            Max Fee: <input name="max_fee" type="number" required />
            <input type="submit" name="update" />
          </form>

          <div class="row">

            <div class="col-md-4">

              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculate deposit fee challan?</h4>
                <ol>
                  <li>According to data you entered, your institute established <strong><?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong>, charged max tuition fee
                    <strong><?php echo $max_tuition_fee; ?> Rs. </strong> per month for Session: <strong><?php echo $session_detail->sessionYearTitle; ?></strong>.
                  </li>
                  <li>As per PSRA Fee Structure, Institute charged monthly fee between
                    <strong><?php echo $fee_sturucture->fee_min; ?> Rs. </strong> and <strong> <?php echo $fee_sturucture->fee_max; ?> Rs. </strong>
                    Must Deposit
                    <ol>
                      <li> Application Processing Fee: <strong><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs. </strong></li>
                      <li> Inspection Fee: <strong><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</strong></li>
                      <li> Upgradation Fee: <strong><?php echo $fee_sturucture->up_grad_fee; ?> Rs.</strong></li>
                      <li> Renewal Fee: <strong><?php echo $fee_sturucture->renewal_fee; ?> Rs.</strong></li>



                  </li>

                </ol>
                <li>In case of confusion and queries, please contact <strong>PSRA MIS Section</strong></li>
                </li>
                </ol>
                <button onclick="renewal_fee_sturucture()" class="btn btn-link">
                  <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Fee Struture Detail</button>
              </div>
            </div>

            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Due Date's</h4>
                <table class="table table-bordered">

                  <tr>
                    <th>S/No</th>
                    <th>Last Date</th>
                    <th>Fine's</th>
                  </tr>
                  <?php
                  $count = 1;
                  foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?></td>
                      <td>
                        <?php
                        if ($session_fee_submission_date->fine_percentage != 'fine') { ?>
                          <?php echo $session_fee_submission_date->fine_percentage; ?> %
                        <?php } else { ?>
                          <?php echo $session_fee_submission_date->detail; ?>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }
                  ?>
                  <?php $pecial_fine = 0; ?>

                </table>
              </div>
            </div>
            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Upgradateion + Renewal Fee Detail</h4>
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
                      <td><strong>Total Session <?php echo $session_detail->sessionYearTitle; ?> Upgradation + Renewal Fee </strong></td>
                      <td>
                        <strong>
                          <?php $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->up_grad_fee +  $fee_sturucture->renewal_fee;

                          echo number_format($total);
                          ?> Rs.
                        </strong>
                      </td>
                    </tr>

                    <?php if ($session_detail->status == 1) { ?>

                      <tr>
                        <td colspan="2">Late Fee Fine
                          <small>(Application Processing + Inspection Fee + Upgradation + Renewal)</small>
                        </td>

                      </tr>

                    <?php } ?>

                    <tr>
                      <?php if ($session_detail->status == 1) { ?>
                        <td colspan="2">
                          <table class="table">
                            <tr>
                              <th> Due's Date </th>
                              <th> Late Fee % </th>
                              <th> Late Fee Amount </th>
                              <th> Total </th>
                            </tr>
                            <?php
                            $count = 1;
                            foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>

                              <tr>
                                <th>
                                  <?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?>
                                </th>
                                <td><?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
                                <td>
                                  <?php
                                  $fine = 0;
                                  $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                  echo number_format($fine);
                                  ?>
                                  Rs.
                                </td>
                                <td>
                                  <?php echo number_format($fine + $total);  ?>
                                </td>
                              </tr>



                            <?php } ?>
                          </table>
                        </td>
                      <?php } else { ?>
                        <td>Late Fee Fine <br /><small><?php
                                                        if ($late_fee->fine_percentage) {
                                                          echo  $late_fee->fine_percentage;
                                                        } else {
                                                          echo 100;
                                                        }
                                                        ?>% on
                            (Application Processing + Inspection Fee + Upgradation + Renewal)</small>
                        </td>
                        <td><?php
                            if ($late_fee->fine_percentage) {
                              $fine = ($late_fee->fine_percentage * $total) / 100;
                            } else {
                              $fine =  (100 * $total) / 100;
                            }
                            echo number_format($fine);
                            ?>
                          Rs.</td>
                      <?php } ?>
                    </tr>
                    <?php if ($session_detail->status == 0) { ?>
                      <tr>
                        <td colspan="2" style="text-align: right;">
                          <h4>Total <?php echo number_format($total + $fine); ?> Rs.</h4>
                        </td>

                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="2" style="text-align:center;">
                        <a target="new" class="btn btn-primary" href="<?php echo site_url("form/print_renewal_upgradation_bank_challan/$school_id") ?>"> <i class="fa fa-print" aria-hidden="true"></i> Print PSRA Upgradation + Renewal Bank Challan From</a>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>



            </div>


          </div>
          <div class="row">
            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> How to apply for Upgradation + Renewal online ?</h3>
                <p>
                <ol>
                  <li>Click Print PSRA Upgradation + Renewal Bank Challan From</li>
                  <li>Deposit challan within due date.</li>
                  <li>Submit <strong>Bank STAN</strong> number and Transaction date</li>
                  <li>Click Submit Bank Challan button</li>
                  <li>View Upgradation + Renewal application status on school dashboard</li>
                  </ul>
                </ol>
                </p>


              </div>
            </div>
            <div class="col-md-6">
              <?php echo $query = "SELECT session_year_id, status FROM school WHERE reg_type_id = 2 AND  session_year_id = '" . ($session_id - 1) . "'";
              $previous_session = $this->db->query($query)->result()[0];
              var_dump($previous_session);
              if ($previous_session->status == 0) {
              ?>
                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                  Session Pending....
                </div>
              <?php } else { ?>
                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                  <h4>Submit bank challan for upgradation + renewal session <?php echo $session_detail->sessionYearTitle; ?></h4>
                  <form action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">
                    <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                    <input type="hidden" name="challan_for" value="Renewal Upgradation" />
                    <table class="table table-bordered">
                      <tr>
                        <td>Bank Transaction No (STAN)</td>
                        <td>Bank Transaction Date</td>
                      </tr>
                      <tr>
                        <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" class="form-control" />
                          <small>"STAN can be found on the upper right corner of bank generated receipt"</small>
                        </td>
                        <td><input required name="challan_date" type="date" class="form-control" />
                        </td>
                        <td><input type="submit" class="btn btn-success" name="submit" value="Submit Bank Challan" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>

              <?php } ?>
            </div>
          </div>
        </div>

      </div>
    </section>

  </div>