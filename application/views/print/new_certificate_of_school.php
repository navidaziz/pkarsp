<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <title>AdminLTE 2 | Invoice</title> -->
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/lib/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">
    /* @media print {
      @page {
        margin: 0;
      }

      body {
        padding: 25px;
      }

      .indent {
        text-indent: 50px;
      }

      hr {
        border-top: 1px solid black;
      }
    } */
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print();" style="line-he ight: 20px;">

  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <!-- <div class="row page-header"> -->
      <div class="row">
        <div class="col-xs-2">
          <img src="<?php echo base_url('assets/images/site_images/certificate-logo-1-in-print.jpg'); ?>" style="height: 100px; width: 100px;">
        </div>
        <div class="col-xs-8">
          <h2 class="text-center">PRIVATE SCHOOLS REGULATORY AUTHORITY</h>
            <h5 class="text-center">GOVERNMENT OF KHYBER PAKHTUNKHWA</h5>
        </div>
        <div class="col-xs-2">
          <img src="<?php echo base_url('assets/images/site_images/certificate-logo-2-in-print.png'); ?>" style="height: 108px; width: 128px;">
        </div>
      </div>
      <hr>
      <!-- </div> -->
      <div class="row" style="padding:0">
        <div class="col-xs-12">
          <p><strong class="pull-right">
              <u> Dated Peshawar the, <?php echo date('d.m.Y', strtotime($schools_info->cer_issue_date)); ?></u>
            </strong></p><br>
          <u><strong>No. MD(KP-PSRA)/3-1/
              <?php echo $schools_info->regTypeTitle; ?>
              /<?php echo @$schools_info->districtTitle; ?>/
              <?php echo date('Y', strtotime($schools_info->cer_issue_date)); ?>-<?php echo date('y', strtotime('+1 year', strtotime($schools_info->cer_issue_date))); ?>/<?php echo $schools_info->schools_id; ?>:</strong>
          </u> In accordance with the Provision of KP-PSRA Act, 2017, under sub-section (1) and (2) of Section 21 of the KP-PSRA Regulations, 2018, the Competent Authority in KP-PSRA has been pleased to accord approval of Provisional Registration to the Private Institution (s) named below:

        </div>
      </div>
      <br>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <style>
            .table {
              border: 1px solid #000000;
            }

            .table-bordered>thead>tr>th,
            .table-bordered>tbody>tr>th,
            .table-bordered>tfoot>tr>th,
            .table-bordered>thead>tr>td,
            .table-bordered>tbody>tr>td,
            .table-bordered>tfoot>tr>td {
              border: 1px solid #000000;
              font-size: 13px !important;
            }
          </style>

          <table class="table table-condensed table-bordered">
            <thead>
              <tr>
                <th>School Name</th>
                <th>Registration No.</th>
                <!-- <th>BISE Registration No.</th> -->
                <th>Level of Institution</th>
                <th>Gender of Institution</th>
                <th>Session</th>

              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <strong>
                    <?php echo strtoupper($schools_info->schoolName); ?>
                  </strong>
                  <br />
                  <small>
                    <i>
                      <strong> Address: </strong>


                      <?php
                      if (!empty($schools_info->address))
                        echo ucwords(strtolower($schools_info->address)) . "<strong> , </strong>";

                      ?>
                      <?php
                      if (!empty($schools_info->tehsilTitle))
                        echo ucwords(strtolower($schools_info->tehsilTitle)) . "<strong> , </strong>";

                      ?>
                      <?php
                      if (!empty($schools_info->districtTitle)) {
                        echo ucwords(strtolower($schools_info->districtTitle));
                      }
                      ?>
                    </i>
                  </small>
                </td>
                <td><?php echo @$schools_info->registrationNumber; ?></td>
                <!-- <td><?php echo @$schools_info->biseregistrationNumber;
                          ?></td> -->
                <td>
                  <?php
                  $query = "SELECT * FROM `levelofinstitute` 
                            WHERE levelofInstituteId <= '" . $schools_info->level_of_school_id . "'
                            AND school_type_id = '" . $schools_info->school_type_id . "'
                            ORDER BY `levelofInstituteId` ASC";
                  $levels = $this->db->query($query)->result();
                  $session_levels = array();
                  if ($schools_info->primary == 1) {
                    $session_levels[1] = 1;
                  }
                  if ($schools_info->middle == 1) {
                    $session_levels[2] = 2;
                  }
                  if ($schools_info->high == 1) {
                    $session_levels[3] = 3;
                  }
                  if ($schools_info->high_sec == 1) {
                    $session_levels[4] = 4;
                  }
                  //var_dump($session_levels);
                  ?>
                  <ul>
                    <?php foreach ($levels as $level) {
                      if (in_array($level->levelofInstituteId, $session_levels) and $level->levelofInstituteId <= $schools_info->level_of_school_id) {
                        echo '<li><strong>' . $level->levelofInstituteTitle . "</strong></li>";
                      }
                    } ?>
                  </ul>


                  <?php //echo @$lower_class->classTitle . " To " . @$schools_info->upper_class; 
                  ?>
                </td>
                <td><?php echo @$schools_info->genderOfSchoolTitle; ?></td>
                <td>
                  <strong><?php echo @$schools_info->sessionYearTitle; ?></strong>
                </td>
              </tr>
              <tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <h4><strong>This certificate can be verified through the KP-PSRA website at www.psra.gkp.pk</strong></h4>
          <br />
          <p><strong>Note: </strong>Registration to the Private Institution (s) granted shall automatically expire on 31st March every year. The Head of the Private Institution (s) shall be required to apply for Renewal for the next Academic Session one month prior to the expiry of registration granted to the institution (s).</p>
          <p class="indent">The school management/administration shall abide by all the norms & standards, categorization and fee regulations, issued from time to time, by this office. In case of failure or non-implementation, the authority shall have the right to cancel the registration for establishment/renewal/up-gradation of Private Institution (s).</p>
          <p class="indent">Further, in case of violation or concealing any information required under KP-PSRA Act, 2017 and Regulations, 2018, the administration/management of Private Institution (s) shall be held responsible for which this authority have all the powers to deal with the institute under relevant sections of laws and regulations.</p>
        </div>
      </div>
      <br>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-xs-7">
          <u><b>Endst: of even No. and dated.</b></u>
          <br />Copy Forwarded for information to the;
          <ol>
            <li>Chairman <?php echo @$schools_info->bise; ?>, Khyber Pakhtunkhwa.</li>
            <li>Director (Registration & Fee Regulations), KP-PSRA.</li>
            <!-- <li>Chairman District Scrutiny Committee concerned.</li> -->
            <li>Deputy Director (M&E/MIS), KP-PSRA.</li>
            <li>Principal of the school/college concerned.</li>
            <li>PS to Managing Director, KP-PSRA.</li>
            <li>Master File.</li>
          </ol>
        </div>
        <div class="col-xs-5 text-center" style="margin-top:50px;">
          <!--<b><span><img src="<?php echo base_url("assets/images/site_images/director_signature.png"); ?>" class="img img-responsive " style="max-height:300px; max-width: 200px;margin:0 auto;position:absolute;bottom:0;left: 70px;top:-175px;right:30px; "></span><br />
        <span>DIRECTOR</span><br />
        <span>(REGISTRATION & FEE REGULATIONS)</span></b>-->
        </div>
      </div>
      <br>

      <div class="clearfix"></div>
      <b>This is a computer generated document no signature required.</b>
      <b>Errors and omissions are excepted.</b>
      <hr>

      <div class="text-center" style="font-size: 14px;">
        <span>House No. 18 E, Jamal-ud-din Afghani Road, University Town, Peshawar <br />
          Registration# 091-9216197. MIS# 091-9216205.

        </span>

    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
</body>

</html>