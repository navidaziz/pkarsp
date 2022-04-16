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
<script>
  function renewal_fee_sturucture() {
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("form/renewal_fee_sturucture"); ?>",
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
      <li class="active"><?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></li>
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
          <div class="col-md-7" style="padding-right: 1px;  padding-left: 10px;">
            <div class="col-md-7">

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
                    In case of confusion and queries, please contact <strong>PSRA MIS Section</strong>
                    <button onclick="renewal_fee_sturucture()" class="btn btn-link">
                      <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Registration Fee Struture Detail</button>
              </div>


            </div>

            <div class="col-md-5">
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
                      <td>Upto <?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?></td>
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

            <div class="col-md-6">
              <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> How to submit bank challan online ?</h3>
              <p>
              <ol>
                <li>Print PSRA Deposit Slip / Bank Challan</li>
                <li>Deposit Fee as per due dates</li>
                <li>Take computerized bank challan having STAN No. from the bank</li>
                <li>Submit <strong>Bank STAN</strong> number and Transaction date</li>
                <li>Click on Submit bank challan</li>
                <li>View Registration application status on school dashboard</li>
                </ul>
              </ol>
              </p>
            </div>

            <div class="col-md-6">
              <div style="direction: rtl; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px;">
                <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> بینک چالان آن لائن کیسے جمع کریں؟</h3>
                <p>
                <ol>
                  <li>PSRA ڈپازٹ سلپ/بینک چالان پرنٹ کریں۔</li>
                  <li>مقررہ تاریخوں کے مطابق فیس جمع کروائیں۔</li>
                  <li>بینک سے اسٹین نمبر والا کمپیوٹرائزڈ بینک چالان لیں۔</li>
                  <li>بینک STAN نمبر اور لین دین کی تاریخ جمع کروائیں۔</li>
                  <li>بینک چالان جمع کروائیں پر کلک کریں۔</li>
                  <li>اسکول کے ڈیش بورڈ پر رجسٹریشن کی درخواست کی حیثیت دیکھیں</li>
                  </ul>
                </ol>
                </p>
              </div>
            </div>

          </div>

          <div class="col-md-5">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
              <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Up-Gradation And Renewal Fee Detail</h4>
              <table class="table">
                <thead>

                </thead>
                <tbody>
                  <tr>
                    <td>
                      <table class="table table_reg">
                        <tr>
                          <th style="width: 150px;"> Due's Date </th>
                          <th>Application Processing Fee</th>
                          <th>Inspection Fee</th>
                          <th>Upgradation Fee</th>
                          <th>Renewal Fee</th>
                          <th style="width: 150px;"> Late Fee </th>
                          <th> Total </th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>
                          <?php $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee + $fee_sturucture->up_grad_fee; ?>

                          <tr>
                            <th>
                              Upto <?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?>
                            </th>
                            <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
                            <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>
                            <td><?php echo number_format($fee_sturucture->up_grad_fee); ?></td>
                            <td><?php echo number_format($fee_sturucture->renewal_fee); ?></td>

                            <td><?php echo $session_fee_submission_date->fine_percentage; ?> % - <?php
                                                                                                  $fine = 0;
                                                                                                  $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                                                                                  echo number_format($fine);
                                                                                                  ?>
                            </td>
                            <td>
                              <strong> <?php echo number_format($fine + $total);  ?> </strong>
                            </td>
                          </tr>



                        <?php } ?>
                      </table>
                    </td>

                  <tr>
                    <td style="text-align:center;">
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


              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h4>Submit Bank Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                <form action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">
                  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                  <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                  <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                  <input type="hidden" name="challan_for" value="Upgradation Renewal" />
                  <table class="table table-bordered">
                    <tr>
                      <td>Bank Transaction No (STAN)</td>
                      <td>Bank Transaction Date</td>
                    </tr>
                    <tr>
                      <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" class="form-control" />

                      </td>
                      <td><input required name="challan_date" type="date" class="form-control" />
                      </td>
                      <td><input type="submit" class="btn btn-success" name="submit" value="Submit Bank Challan" />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <p>"STAN can be found on the upper right corner of bank generated receipt"</p>
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