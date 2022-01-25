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
        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?>s Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">
      <?php $this->load->view('forms/navigation_bar');   ?>
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Submit Form</h3>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="padding: 3px;">


          <div class="row">
            <div class="col-md-4">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 15px; padding: 5px;">
                <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculate renewal fee challan ?</h4>
                <ol>
                  <li>According to data you entered, your institute charged max tuition fee
                    Rs. <strong><?php echo $max_tuition_fee; ?></strong> per month.</li>
                  <li>As per PSRA rule institute charged monthly fee between
                    <strong>Rs.<?php echo $fee_sturucture->fee_min; ?> </strong> and <strong> Rs.<?php echo $fee_sturucture->fee_max; ?></strong> pay
                    <ol>
                      <li> Application Processing Fee: <strong><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs. </strong></li>
                      <li> Inspection Fee: <strong><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</strong></li>
                      <li> Renewal Fee: <strong><?php echo $fee_sturucture->renewal_fee; ?> Rs. </strong></li>

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


              <table class="table table-bordered">
                <tr>
                  <th colspan="3">Session: <?php echo $session_detail->sessionYearTitle; ?> Renewal Due Date's</th>
                </tr>
                <tr>
                  <th>S/No</th>
                  <th>Last Date</th>
                  <th>Fine's</th>
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
            <div class="col-md-4">

              <table class="table table-bordered" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>Fee Category</th>
                    <th>Amount (Rs.)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Application Processing Fee</th>
                    <td><?php echo $fee_sturucture->renewal_app_processsing_fee; ?> Rs.</td>
                  </tr>
                  <tr>
                    <th>Inspection Fee</th>
                    <td><?php echo $fee_sturucture->renewal_app_inspection_fee; ?> Rs.</td>
                  </tr>
                  <tr>
                    <th>Renewal Fee</th>
                    <td><?php echo $fee_sturucture->renewal_fee; ?> Rs.</td>
                  </tr>

                  <tr>
                    <th>Total Session <?php echo $session_detail->sessionYearTitle; ?> Renewal Fee</th>
                    <td><?php echo $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee; ?> Rs.</td>
                  </tr>

                  <tr>
                    <th>Late Fee <?php
                                  if ($late_fee->fine_percentage) {
                                    echo  $late_fee->fine_percentage;
                                  } else {
                                    echo 100;
                                  }
                                  ?>%</th>
                    <td><?php
                        if ($late_fee->fine_percentage) {
                          echo  $fine = ($late_fee->fine_percentage * $total) / 100;
                        } else {
                          echo $fine =  (100 * $total) / 100;
                        } ?>
                      Rs.</td>
                  </tr>
                  <tr>
                    <th style="text-align: right;">
                      <h4>Total </h4>
                    </th>
                    <td>
                      <h4><?php echo $total + $fine; ?> Rs.</h4>
                    </td>

                  </tr>
                  <tr>
                    <th>Last Date</th>
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

            <div class="col-md-6">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 15px; padding: 5px;">
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
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 15px; padding: 5px;">
                <h4>Submit Renewal Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                <table class="table table-bordered">
                  <tr>
                    <th>Bank Transaction No (STAN)</th>
                    <th>Bank Transaction Date</th>
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