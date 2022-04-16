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

        <?php
        $biseverification = 0;
        // $bise_verificaiton = 0;
        if ($school->biseRegister == 'Yes') {
          $biseverification = '1';


          $query = "SELECT * FROM `bise_verification_requests` WHERE school_id = '" . $school->schools_id . "' AND status IN(1,2,0)";
          $bise_verification = $this->db->query($query)->result();
          if ($bise_verification and $bise_verification[0]->status == 1 or $bise_verification[0]->status == 2) {
            $biseverified = 1;
          } else {
            $biseverified = 0;
          }
        } else {
          $biseverified = 1;
        }


        if ($biseverified == 1) {
        ?>


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
            <div class="col-md-7" style="padding-right: 1px;  padding-left: 10px;">
              <div class="col-md-6" style="padding-right: 1px;  padding-left: 10px;">

                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                  <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> How system calculates <i>"Deposit Fee Challan" ?</i></h4>
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
                    <i class="fa fa-info-circle" aria-hidden="true"></i> PSRA Registration Fee Struture Detail</button>
                </div>
              </div>

              <div class="col-md-6" style="padding-right: 1px;  padding-left: 1px; min-height:450px; ">
                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 437px !important;  margin: 5px; padding: 5px; background-color: white;">
                  <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Due Dates</h4>
                  <table class="table table-bordered">

                    <tr>
                      <th>S.No.</th>
                      <th>Last Date</th>
                      <th>Fines</th>
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
                    <?php
                    $pecial_fine = 0;
                    if ($session_id == 1) { ?>
                      <tr>
                        <td colspan="2" style="text-align: center;"> Settle Areas 2018-19 Special Fine<br />1 Dec, 2019</td>
                        <td>
                          <strong>50,000 Rs.</strong> <br> Primary / Middle Level <br>
                          <strong>200,000 Rs. </strong> <br> High / Higher Level
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align: center;"> FATA 2018-19 Special Fine<br />01 Jan, 2020</td>
                        <td>
                          <strong>50,000 Rs.</strong> <br> Primary / Middle Level <br>
                          <strong>200,000 Rs. </strong> <br> High / Higher Level
                        </td>
                      </tr>



                    <?php
                      if ($school->level_of_school_id == 1  or  $school->level_of_school_id == 2) {
                        $special_fine = 50000;
                      }
                      if ($school->level_of_school_id == 3  or  $school->level_of_school_id == 4) {
                        $special_fine = 200000;
                      }
                    } ?>

                  </table>
                  <?php $bise_tdr = 0;
                  if ($bise_verification) {
                  ?>
                    <h4 style="text-align: center;">
                      BISE Registration No. <?php echo $bise_verification[0]->registration_number; ?><br />
                      BISE Affiliation. <?php
                                        $query = "SELECT `bise`.`biseName` FROM `bise` WHERE `bise`.`biseId` = '" . $bise_verification[0]->bise_id . "'";
                                        $bise_affiliation_name = $this->db->query($query)->result()[0]->biseName;

                                        echo $bise_affiliation_name; ?><br />
                      Verification Status:
                      <?php if ($bise_verification[0]->status == 1) { ?>
                        <strong style="color:green"> Verified </strong>
                        <?php if ($bise_verification[0]->tdr_amount) { ?>
                          <br />
                          BISE TDR Received: <strong><?php
                                                      $bise_tdr = $bise_verification[0]->tdr_amount;

                                                      echo $bise_verification[0]->tdr_amount; ?> Rs.</strong>
                        <?php } ?>
                      <?php } ?>
                      <?php if ($bise_verification[0]->status == 2) { ?>
                        <strong style="color:red">Not Verified</strong> <br />
                        <small>Remraks: <?php echo $bise_verification[0]->remarks; ?></small>
                      <?php } ?>

                    </h4>
                  <?php } ?>
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
                  <li>Click on <strong>"Submit bank challan"</strong></li>
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

            <div class="col-md-5" style="padding-right: 10px;  padding-left: 1px;">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Registration Fee Detail</h4>
                <table class="table" style="font-size: 13px;">

                  <tbody>



                    <tr>
                      <td colspan="2">

                        <table class="table table_reg" style="font-size: 13px;">
                          <tr>
                            <th style="width: 130px;"> Due's Date </th>
                            <th>Application Processing Fee</th>
                            <th>Inspection Fee</th>
                            <th style="width: 80px;"> Late Fee </th>

                            <?php
                            $query = "SELECT * FROM `levelofinstitute` 
                                WHERE `levelofinstitute`.`levelofInstituteId` = $school->level_of_school_id";
                            $level_securities = $this->db->query($query)->result()[0];

                            ?>
                            <th>Security Fee <br /><small>(<?php echo $level_securities->levelofInstituteTitle; ?>)</small></th>
                            <?php if ($session_id == 1) { ?>
                              <th>Fine <br /><small>2018-19 Special Fine (<?php echo $level_securities->levelofInstituteTitle; ?>)</small></th>
                            <?php } ?>
                            <th>Total</th>
                          </tr>
                          <?php
                          $count = 1;

                          foreach ($session_fee_submission_dates as $session_fee_submission_date) {
                            $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee;
                          ?>

                            <tr>
                              <th>
                                Upto <?php echo date('d M, Y', strtotime($session_fee_submission_date->last_date)); ?>
                              </th>

                              <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
                              <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>

                              <td>
                                <?php
                                $fine = 0;
                                $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                echo $session_fee_submission_date->fine_percentage . " % - ";
                                echo number_format($fine);
                                ?>
                              </td>
                              <!-- <td> -->
                              <?php //echo number_format($fine + $total);  
                              ?>
                              <!-- </td> -->
                              <td>
                                <?php $security = ($level_securities->security_fee - $bise_tdr);

                                echo number_format($security);
                                ?>

                              </td>
                              <?php if ($session_id == 1) { ?>
                                <td></td>
                              <?php } ?>
                              <td>
                                <strong>
                                  <?php if ($session_id == 1) { ?>
                                    <?php
                                    echo number_format($fine + $total + $security + $specialfine);
                                    ?>

                                  <?php } else { ?>

                                    <?php echo number_format($fine + $total + $security); ?>
                                  <?php } ?>
                                </strong>
                              </td>

                            </tr>



                          <?php } ?>
                          <?php if ($session_id == 1) { ?>
                            <tr>
                              <th> After 1 Dec, 2019 </th>
                              <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
                              <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>
                              <td>

                                <?php echo $session_fee_submission_dates['4']->fine_percentage; ?> % -

                                <?php
                                $fine = 0;
                                $fine = ($session_fee_submission_dates['4']->fine_percentage * $total) / 100;
                                echo number_format($fine);
                                ?>

                              </td>

                              <td>
                                <?php $security = ($level_securities->security_fee - $bise_tdr);

                                echo number_format($security);
                                ?>

                              </td>
                              <?php

                              $specialfine = 0; ?>

                              <td><?php
                                  //echo $school->district_id . " - ";
                                  $specialfine = $special_fine;
                                  echo number_format($special_fine); ?></td>


                              <td>
                                <strong>

                                  <?php
                                  // echo "$fine + $total + $security + $specialfine";
                                  echo number_format($fine + $total + $security + $specialfine);
                                  ?>

                                </strong>
                              </td>

                            </tr>
                          <?php } ?>
                        </table>
                      </td>

                    </tr>


                    <tr>
                      <td colspan="2" style="text-align:center;">
                        <a target="new" class="btn btn-primary" href="<?php echo site_url("form/print_registration_bank_challan/$school_id") ?>"> <i class="fa fa-print" aria-hidden="true"></i> Print PSRA Deposit Slip / Bank Challan</a>
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
        <?php } else { ?>
          <div class="row">

            <div class="col-md-12">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 0px auto; width:50%; padding: 5px; background-color: white;">
                <h3 style="text-align: center;">BISE Verificaiton In Progress </h3>
                <h4 style="text-align: center;">
                  BISE Registration No. <?php echo $bise_verification[0]->registration_number; ?><br />
                  BISE Affiliation. <?php
                                    $query = "SELECT `bise`.`biseName` FROM `bise` WHERE `bise`.`biseId` = '" . $bise_verification[0]->bise_id . "'";
                                    $bise_affiliation_name = $this->db->query($query)->result()[0]->biseName;

                                    echo $bise_affiliation_name; ?><br />
                  Verification Status: <strong style="color:red">Pending</strong>
                  <h2 style="text-align: center;"><i class="fa fa-spinner" aria-hidden="true"></i></h2>
                  <p style="text-align: center;">
                    <strong>
                      Your case will proceed further, after verification of BISE Registration / Affiliation. Keep visiting school portal. it will take 1,2 working days.

                      <br />
                      <p style="text-align: center; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px; direction: rtl;">
                        آپ کا کیس BISE رجسٹریشن / الحاق کی تصدیق کے بعد آگے بڑھے گا۔ اسکول کے پورٹل کو وزٹ کرتے رہیں۔ اس میں 1,2 کام کے دن لگیں گے۔</p>
                    </strong>
                  </p>
                </h4>

              </div>
            </div>
          </div>
        <?php } ?>


      </div>

    </div>
  </section>

</div>