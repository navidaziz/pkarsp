  <!-- Modal -->
  <script>
    function renewal_fee_sturucture() {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/renewal_fee_sturucture"); ?>",
        data: {
          school_type_id: <?php echo $school->school_type_id; ?>
        }
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
        <h4>S-ID: <?php echo $school->schools_id; ?>
          <?php if ($school->registrationNumber) { ?> - REG No: <?php echo $school->registrationNumber ?> <?php } ?></h4>
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



          <form method="post" action="<?php echo site_url("form/update_test_date"); ?>">
            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
            <input type="hidden" name="schools_id" value="<?php echo $school->schools_id; ?>" />

            Levels:
            <select name="level">
              <?php $query = "SELECT * FROM `levelofinstitute`";
              $levels = $this->db->query($query)->result();
              foreach ($levels as $level) { ?>
                <option <?php if ($level->levelofInstituteId == $school->level_of_school_id) { ?> selected <?php } ?> value="<?php echo $level->levelofInstituteId; ?>"><?php echo $level->levelofInstituteTitle; ?></option>
              <?php  } ?>
            </select>
            year of establishment: <input name="year_of_es" type="month" value="<?php echo $school->yearOfEstiblishment ?>" />
            Max Fee: <input name="max_fee" type="number" value="<?php echo $max_tuition_fee; ?>" />
            <input type="submit" name="update" />
          </form>

          <div class="row">
            <div class="col-md-6" style="padding-right: 1px;  padding-left: 10px;">
              <div class="col-md-6" style="padding-right: 1px;  padding-left: 10px;">

                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 500px;  margin: 5px; padding: 5px; background-color: white;">
                  <h4>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculate <i>"Deposit Fee Challan" ?</i>
                  </h4>
                  <ol>
                    <li>According to the data you have entered, your institute was established in <strong><?php echo date('M Y', strtotime($school->yearOfEstiblishment)); ?></strong>.
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
                        <li>Annual Renewal Fee: <strong><?php echo $fee_sturucture->renewal_fee; ?> Rs.</strong></li>
                        <li> Security Fee (1st Time Registration)
                          <ol style="list-style: none;">
                            <li><strong><?php echo $security = $fee_sturucture->security; ?> Rs.</strong> (Refundable)</li>
                          </ol>
                        </li>

                    </li>

                  </ol>
                  <li>In case of confusion and queries, please contact <strong>PSRA MIS Section</strong></li>
                  </li>
                  </ol>
                  <button onclick="renewal_fee_sturucture()" class="btn btn-link">
                    <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Academy Registration Fee Struture Detail</button>
                </div>
              </div>

              <div class="col-md-6" style="padding-right: 1px;  padding-left: 1px; min-height:450px; ">
                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 500px !important;  margin: 5px; padding: 5px; background-color: white;">
                  <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Due Dates</h4>
                  <table class="table table-bordered">

                    <tr>
                      <th>S.No.</th>
                      <th>Last Date</th>
                      <th>Fines</th>
                    </tr>
                    <?php
                    $count = 1;
                    $s_no = 1;
                    foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>
                      <tr>
                        <th><?php echo $s_no++; ?></th>
                        <th style="width: 210px;">

                          <?php if ($count == 1) { ?> <strong> 01 Jan, <?php echo date('Y', strtotime($session_fee_submission_date->last_date)); ?></strong> to <?php } else { ?>
                            <?php if ($count >= sizeof($session_fee_submission_dates)) { ?>
                              After
                            <?php } else { ?>
                              <strong> <?php echo date('d M, Y', strtotime($previous_last_date)); ?> </strong> to
                            <?php } ?>
                          <?php } ?>
                          <strong>
                            <?php
                            $previous_last_date = date('d M, Y', strtotime($session_fee_submission_date->last_date . ' +1 day'));
                            if ($count >= sizeof($session_fee_submission_dates)) {
                              echo date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day'));
                            } else {

                              echo date('d M, Y', strtotime($session_fee_submission_date->last_date));
                            }
                            $count++;
                            ?>
                          </strong>
                        </th>
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


                  </table>

                </div>
              </div>

              <div class="col-md-6" style="font-size: 12px;">
                <h5> <i class="fa fa-info-circle" aria-hidden="true"></i> How to submit bank challan online ?</h5>
                <p>
                <ol>
                  <li>Print PSRA Deposit Slip / Bank Challan</li>
                  <li>Deposit Fee as per due dates</li>
                  <li>Take computerized bank challan having STAN No. from the bank</li>
                  <li>Submit <strong>Bank STAN</strong> number and Transaction date</li>
                  <li>Click on <strong>"Submit bank challan"</strong></li>
                  <li>View Registration application status on school dashboard</li>
                  </ul>
                </ol>
                </p>
              </div>

              <div class="col-md-6" style="font-size: 11px;">
                <div style="direction: rtl; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px;">
                  <h5> <i class="fa fa-info-circle" aria-hidden="true"></i> بینک چالان آن لائن کیسے جمع کریں؟</h5>
                  <p>
                  <ol>
                    <li>PSRA ڈپازٹ سلپ/بینک چالان پرنٹ کریں۔</li>
                    <li>مقررہ تاریخوں کے مطابق فیس جمع کروائیں۔</li>
                    <li>بینک سے STAN No والا کمپیوٹرائزڈ بینک چالان لیں۔</li>
                    <li>بینک STAN نمبر اور لین دین کی تاریخ جمع کروائیں۔</li>
                    <li style="direction: rtl;"> کلک کریں۔ "Submit bank challan"</li>
                    <li>اسکول کے ڈیش بورڈ پر رجسٹریشن کی درخواست کی حیثیت دیکھیں</li>
                    </ul>
                  </ol>
                  </p>
                </div>
              </div>


            </div>

            <div class="col-md-6" style="padding-right: 10px;  padding-left: 1px;">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 500px;  margin: 5px; padding: 5px; background-color: white;">
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
                      <td>Rs. <?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
                    </tr>
                    <tr>
                      <td>Inspection Fee</td>
                      <td>Rs. <?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>
                    </tr>
                    <tr>
                      <td>Annual Renewal Fee</td>
                      <td>Rs. <?php echo number_format($fee_sturucture->renewal_fee); ?></td>
                    </tr>

                    <tr>
                      <th><strong> Session <?php echo $session_detail->sessionYearTitle; ?> Total Registration Fee </strong></th>
                      <th>
                        <strong>
                          <?php $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee;

                          echo number_format($total);
                          ?> Rs.
                        </strong>
                      </th>

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
                            <th> Late Fee % </th>
                            <th> Late Fee </th>
                            <th> Session <?php echo $session_detail->sessionYearTitle; ?> Registration Fee </th>
                            <th>Security</th>
                            <th>Total</th>
                          </tr>
                          <?php
                          $count = 1;
                          //var_dump($session_fee_submission_dates);
                          foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>

                            <tr>

                              <th style="width: 210px;">

                                <?php if ($count == 1) { ?> <strong> 01 Jan, <?php echo date('Y', strtotime($session_fee_submission_date->last_date)); ?></strong> to <?php } else { ?>
                                  <?php if ($count >= sizeof($session_fee_submission_dates)) { ?>
                                    After
                                  <?php } else { ?>
                                    <strong> <?php echo date('d M, Y', strtotime($previous_last_date)); ?> </strong> to
                                  <?php } ?>
                                <?php } ?>
                                <strong>
                                  <?php
                                  $previous_last_date = date('d M, Y', strtotime($session_fee_submission_date->last_date . ' +1 day'));
                                  if ($count >= sizeof($session_fee_submission_dates)) {
                                    if ($count == 1) {
                                      echo date('d M, Y', strtotime($session_fee_submission_date->last_date));
                                    } else {
                                      echo date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day'));
                                    }
                                  } else {

                                    echo date('d M, Y', strtotime($session_fee_submission_date->last_date));
                                  }
                                  $count++;
                                  ?>
                                </strong>
                              </th>


                              <?php if ($session_fee_submission_date->fine_percentage == 0) { ?>
                                <td colspan="2"> <strong> Normal Fee </strong></td>
                              <?php } else { ?>
                                <td>

                                  <?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
                                <td>
                                  <?php
                                  $fine = 0;
                                  $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                  echo number_format($fine);
                                  ?>

                                </td>
                              <?php } ?>
                              <td>
                                <?php echo number_format($fine + $total);  ?>
                              </td>
                              <td>
                                <?php $security = ($security);

                                echo number_format($security);
                                ?>

                              </td>
                              <?php if ($session_id == 1) { ?>
                                <td></td>
                              <?php } ?>
                              <td>
                                <strong>
                                  <?php echo number_format($fine + $total + $security); ?>

                                </strong>
                              </td>

                            </tr>



                          <?php } ?>

                        </table>
                      </td>

                    </tr>


                    <tr>
                      <td colspan="2" style="text-align:center;">
                        <a target="new" class="btn btn-primary" href="<?php echo site_url("form/academy_bank_challan_print/$school_id") ?>"> <i class="fa fa-print" aria-hidden="true"></i> Print PSRA Deposit Slip / Bank Challan</a>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>

              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                <h4>Submit Bank Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                <form action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">
                  <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                  <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
                  <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
                  <input type="hidden" name="challan_for" value="Registration" />
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

            </div>



          </div>

          <div class="row">



            <div class="col-md-5">

            </div>
          </div>



        </div>

      </div>
    </section>

  </div>