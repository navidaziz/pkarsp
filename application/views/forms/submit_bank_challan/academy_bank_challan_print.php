<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>PSRA Renewal Challan Form</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Academy Bank Challan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style type="text/css">
    body {
      background: rgb(204, 204, 204);
      font-family: 'Source Sans Pro', 'Regular' !important;

    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 21cm;
      /* height: 29.7cm;  */
      height: auto;
    }

    @media print {
      page[size="A4"] {
        width: 90%;
        margin: 0 auto;
        margin-top: 30px;
        /* height: 29.7cm;  */
        height: auto;
        font-size: 15px !important;
      }
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

    }


    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 8px;
      line-height: 1;
      vertical-align: top;
      font-size: 12px !important;

    }
  </style>
</head>

<body>
  <page size='A4'>
    <div style="padding: 10px;" style="width: 100%;">
      <table style="width: 100%;">
        <tr>
          <th><img style="width: 100px;" src="<?php echo base_url(); ?>assets/logo.png" class="img-responsive img" /></th>
          <th>
            <h3 style="text-align: center;">Public School Regulatory Authority Khyber Pakhtunkhwa</h4>
              <h4 style="text-align: center;"><?php echo $title;  ?> Challan Form For Session <?php echo $session_detail->sessionYearTitle; ?>
              </h4>


          </th>
        </tr>
      </table>
      <hr />
      <h5 style="text-align: center;">The Bank of Khyber Any Branch A/C No.
        <b> PLS. 2000883401</b> On Account of: <b>Managing Director Private Schools Regulatory Authority</b>
      </h5>
      <div style="margin: 10px;">
        <table style="width: 100%;">
          <tr>
            <th>Date: _______________</th>
            <th>Receipt No: <span style="text-decoration: underline; ">
                <strong><?php echo $school->schools_id + $school->district_id; ?><strong></span></th>
            <th style="text-align: right;">Reference no:___________________<br />
              (for bank use only)</th>
          </tr>
        </table>
        <div style="border: 1px solid #ddd; border-radius: 10px; margin-top: 5px; margin-bottom: 10px;  padding: 10px; font-size: 20px;">
          <table class="table">
            <tr>
              <td style="text-align: left;">School ID: <span style="text-decoration: underline; ">
                  <strong><?php echo $school->schools_id; ?><strong></span></td>
              <td style="text-align: center;">
                <?php if ($school->registrationNumber) { ?>
                  Registration ID: <span style="text-decoration: underline; ">
                    <strong><?php echo $school->registrationNumber; ?><strong></span>
                <?php } ?>
              </td>
              <td style="text-align: right;">Session: <span style="text-decoration: underline; ">
                  <strong><?php echo $session_detail->sessionYearTitle; ?><strong></span></td>
            </tr>
          </table>
          <table class="table">
            <tr>
              <td>Institute Name: <span style="text-decoration: underline; ">
                  <strong><?php echo $school->schoolName; ?><strong></span></td>
              <td colspan="2">District: <span style="text-decoration: underline; ">
                  <strong><?php $query = "SELECT `districtTitle` FROM `district` WHERE districtId = '" . $school->district_id . "'";
                          echo $this->db->query($query)->result()[0]->districtTitle; ?></td>
              <td colspan="4">Type: <span style="text-decoration: underline; ">
                  <strong><?php $query = "SELECT `levelofInstituteTitle` FROM `levelofinstitute` WHERE levelofInstituteId = '" . $school->level_of_school_id . "'";
                          echo $this->db->query($query)->result()[0]->levelofInstituteTitle; ?></td>
            </tr>
          </table>
        </div>


        <table class="table" style="font-size: 11px;">
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
                <table class="table">
                  <tr>
                    <th> Due's Date </th>
                    <th> Late Fee % </th>
                    <th> Late Fee </th>
                    <th> Session <?php echo $session_detail->sessionYearTitle; ?> Registration Fee </th>
                    <th>Security</th>
                    <th>Total</th>
                  </tr>
                  <?php $security = $fee_sturucture->security; ?>
                  <?php
                  $count = 1;

                  var_dump($session_fee_submission_dates);

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
                            echo date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day'));
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

          </tbody>
        </table>

        <br /><br />
        <style>
          .table2 td,
          .table2 th {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid white !important;
          }
        </style>
        <table class="table table2" style="width: 100%; text-align: center;">
          <tr>
            <td style="width: 33%;"><strong>Applicant Signature</strong>
              <hr style="border:1px solid #333;width:100%;  margin-top: 60px;">
            </td>
            <td style="width: 33%;">
              <strong>Cashier</strong>
              <hr style="border:1px solid #333;width:100%;  margin-top: 60px;">
            </td>
            <td style="width: 33%;"><strong> Bank Officer</strong>
              <hr style="border:1px solid #333;width:100%; margin-top: 60px;">
            </td>
          </tr>
        </table>
      </div>
    </div>



  </page>
</body>



</html>