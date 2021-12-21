  <!-- Modal -->
  <script>
    function renewal_fee_sturucture() {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("apply/renewal_fee_sturucture"); ?>",
        data: {}
      }).done(function(data) {

        $('#renewal_sturucture_body').html(data);
      });

      $('#renewal_sturucture_model').modal('toggle');
    }
  </script>
  <div class="modal fade" id="renewal_sturucture_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
        <h4>S-ID: <?php echo $school->school_id; ?> <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
      </small>
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

        <div class="box-body" style="padding: 3px;">


          <div class="row">

            <div class="col-md-4">

              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculate deposit fee challan?</h4>
                <ol>
                  <li>According to data you entered, your institute charged max tuition fee
                    <strong><?php echo $max_tuition_fee; ?> Rs. </strong> per month.
                  </li>
                  <li>As per PSRA Registration and Renewal Fee Structure, Institute charged monthly fee between
                    <strong><?php echo $fee_sturucture->fee_min; ?> Rs. </strong> and <strong> <?php echo $fee_sturucture->fee_max; ?> Rs. </strong>
                    Must Deposit
                    <ol>
                      <li> Application Processing Fee: <strong><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs. </strong></li>
                      <li> Inspection Fee: <strong><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</strong></li>
                      <li> Security Fee (1st Time Registration)
                        <ol>
                          <?php
                          $query = "SELECT * FROM `levelofinstitute`";
                          $level_securities = $this->db->query($query)->result();
                          foreach ($level_securities as $level_security) {
                          ?>
                            <li><?php echo  $level_security->levelofInstituteTitle; ?> <strong> <?php echo  $level_security->security_fee; ?> Rs.</strong> </li>
                          <?php } ?>
                        </ol>
                      </li>

                  </li>

                </ol>
                <li>In case of confusion and queries, please contact <strong>PSRA MIS Section</strong></li>
                </li>
                </ol>
                <button onclick="renewal_fee_sturucture()" class="btn btn-link">
                  <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Renewal Fee Struture Detail</button>
              </div>
            </div>

            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Due Date's</h4>
                <table class="table table-bordered">

                  <tr>
                    <td>S/No</td>
                    <td>Last Date</td>
                    <td>Fine's</td>
                  </tr>
                  <?php
                  $count = 1;
                  $query = "SELECT * FROM `session_fee_submission_dates` WHERE  session_id = '" . $session_id . "'";
                  $session_fee_submission_dates = $this->db->query($query)->result();
                  foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?></td>
                      <td><?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
                    </tr>
                  <?php }
                  ?>

                </table>
              </div>
            </div>
            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Registration Fee Detail</h4>
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
                      <td><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs.</td>
                    </tr>
                    <tr>
                      <td>Inspection Fee</td>
                      <td><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</td>
                    </tr>
                    <tr>
                      <td>Renewal Fee</td>
                      <td><?php echo $fee_sturucture->renewal_fee; ?> Rs.</td>
                    </tr>

                    <tr>
                      <td>Total Session <?php echo $session_detail->sessionYearTitle; ?> Renewal Fee</td>
                      <td><?php echo $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee; ?> Rs.</td>
                    </tr>

                    <tr>
                      <td>Late Fee <?php
                                    if ($late_fee->fine_percentage) {
                                      echo  $late_fee->fine_percentage;
                                    } else {
                                      echo 100;
                                    }
                                    ?>%</td>
                      <td><?php
                          if ($late_fee->fine_percentage) {
                            echo  $fine = ($late_fee->fine_percentage * $total) / 100;
                          } else {
                            echo $fine =  (100 * $total) / 100;
                          } ?>
                        Rs.</td>
                    </tr>
                    <tr>

                      <td colspan="2" style="text-align: right;">
                        <h4>Total <?php echo $total + $fine; ?> Rs.</h4>
                      </td>

                    </tr>
                    <tr>
                      <td>Last Date</td>
                      <td><?php echo date('d M, Y', strtotime($late_fee->last_date)); ?></td>

                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:center;">
                        <a target="new" class="btn btn-success" href="<?php echo site_url("apply/print_renewal_bank_challan/$session_id") ?>"> <i class="fa fa-print" aria-hidden="true"></i> Print PSRA Renewal Bank Challan From</a>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>



            </div>

            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> How to apply for renewal online ?</h3>
                <p>
                <ol>
                  <li>Print bank challan form.</li>
                  <li>Deposit challan within due date.</li>
                  <li>Submit Deposit bank challan detail on apply online renewal</li>
                  <li>Click apply for online button</li>
                  <li>View renewal application status on school dashboard</li>
                  </ul>
                </ol>
                </p>


              </div>
            </div>
            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h4>Submit Renewal Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                <table class="table table-bordered">
                  <tr>
                    <td>Bank Transaction No (STAN)</td>
                    <td>Bank Transaction Date</td>
                  </tr>
                  <tr>
                    <td><input maxlength="6" type="number" autocomplete="off" class="form-control">
                      <p>"STAN can be found on the upper right corner of bank generated receipt"</p>
                    </td>
                    <td><input min="2014-05-11" max="<?php echo date("Y-m-d"); ?>" type="date" class="form-control">
                    </td>
                  </tr>
                </table>

              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

  </div>