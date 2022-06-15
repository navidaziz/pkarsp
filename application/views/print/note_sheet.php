<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Session Detail: <?php echo $school->schoolId; ?>-<?php echo $school_id; ?></title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style type="text/css">
    body {
      background: rgb(204, 204, 204);
      /* //font-family: 'Source Sans Pro', 'Regular' !important; */

    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 70%;
      min-height: 29.7cm;
      /* height: auto; */
      font-size: 16px !important;

    }

    @media print {
      page[size="A4"] {
        width: 95%;
        margin: 0 auto;
        margin-top: 10px;
        /* height: 29.7cm;  */
        height: auto;
        font-size: 22px !important;
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


    }

    .table2>thead>tr>th,
    .table2>tbody>tr>th,
    .table2>tfoot>tr>th,
    .table2>thead>tr>td,
    .table2>tbody>tr>td,
    .table2>tfoot>tr>td {
      padding: 5px;
      line-height: 1;
      vertical-align: top;
      color: black !important;

    }
  </style>
</head>

<body>
  <page size='A4'>
    <div class="wrapper">
      <section class="invoice" style="margin-left: 10px; margin-right: 10px;">
        <!-- title row -->
        <!-- <div class="row page-header"> -->
        <br />
        <div class="col-md-12">
          <table class="table2" style="width: 100%;">
            <tr>
              <td> <img src="<?php echo base_url('assets/images/site_images/certificate-logo-1-in-print.jpg'); ?>" style="height: 100px; width: 100px;">
              </td>
              <td>
                <h4 class="text-center">PRIVATE SCHOOLS REGULATORY AUTHORITY</h4>
                <h5 class="text-center">GOVERNMENT OF KHYBER PAKHTUNKHWA</h5>
                <p style="text-align: center;">
                  <small>Office: House No. 18/E, Jamal Ud Din Afghani Road,<br />
                    University Town, Peshawar<br />
                    Phone# 091-5700247-8. Fax# 09415700246
                  </small>
                </p>
              </td>
              <td> <img src="<?php echo base_url('assets/images/site_images/certificate-logo-2-in-print.png'); ?>" style="height: 108px; width: 128px;">
              </td>
            </tr>
          </table>

        </div>


        <hr>

        <div class="col-md-12">
          <p>
            <?php //var_dump($school); 
            ?>
            <i>
            School Name: <strong> <?php echo $school->schoolName; ?> , </strong>
            School ID:<strong> <?php echo $school->schools_id; ?> </strong>
            <br />

            Application for <strong><?php echo $session_request_detail->regTypeTitle ?></strong>
            of  <strong><?php echo $session_request_detail->levelofInstituteTitle ?> level</strong> 
            for session <strong><?php echo $session_request_detail->sessionYearTitle ?></strong>
            on date, 
            <strong><?php echo date("d M, Y", strtotime($session_request_detail->created_date)); ?></strong>
  </i>
            <br />
            <br />
            As per schedule notification the following required fee has been deposit by the above school administration, as per schedule and KP-PSRA notification for fee slab and security mentioned against each.
          </p>
          <br />

          <table class="table table-bordered table2" style="font-size: 16px;">
            <thead>
              <tr>
                <th>#</th>
                <th>Type</th>
                <th>STAN</th>
                <th>Date</th>
                <th>Application Processing Fee</th>
                <th>Inspection Fee</th>
                <th>Renewal Fee</th>
                <th>Upgradation Fee</th>
                <th>Late Fee</th>
                <th>Security Fee</th>
                <th>Fine</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>

              <?php $count = 1;
              foreach ($bank_challans as $bank_challan) { ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo $bank_challan->challan_for; ?></td>
                  <td><?php echo $bank_challan->challan_no; ?></td>
                  <td><?php echo date('d M, Y', strtotime($bank_challan->challan_date)); ?></td>
                  <td><?php echo $bank_challan->application_processing_fee; ?></td>
                  <td><?php echo $bank_challan->inspection_fee; ?></td>
                  <td><?php echo $bank_challan->renewal_fee; ?></td>
                  <td><?php echo $bank_challan->upgradation_fee; ?></td>
                  <td><?php echo $bank_challan->late_fee; ?></td>

                  <td><?php echo $bank_challan->security_fee; ?></td>


                  <td><?php echo $bank_challan->fine; ?></td>
                  <td><?php echo $bank_challan->total_deposit_fee; ?></td>
                  <!-- <td><?php
                            $query = "SELECT * FROM users WHERE userId = '" . $bank_challan->verified_by . "'";
                            $verified_by = $this->db->query($query)->result()[0]->userTitle;
                            echo $verified_by;
                            ?></td> -->
                </tr>
              <?php  } ?>

            </tbody>
          </table>

          <div>
            <?php
            $count = 1;
            $pervious_user_id = 0;
            foreach ($comments as $comment) { ?>
              <p style="margin-left: 13px;">
                <strong>
                  <?php echo $count++; ?>.
                </strong>


                <?php if ($pervious_user_id != $comment->created_by) { ?>

                  <strong> <?php echo $comment->role_title; ?> </strong> (<?php echo $comment->userTitle; ?>)

                  <small style="float: right;">
                    <?php echo date("D d M, Y", strtotime($comment->created_date)); ?>
                  </small>
                  <br />

                <?php } ?>



                <?php if ($comment->mark_to) { ?>
                  <?php $query = "SELECT  `users`.`userId`, `users`.`userTitle`, `roles`.`role_title` 
                           FROM
                           `roles`
                           INNER JOIN `users`
                           ON ( `roles`.`role_id` = `users`.`role_id` )
                           WHERE `users`.`userId` = '" . $comment->mark_to . "'
                            ORDER BY `roles`.`role_id`;";
                  $marked_to = $this->db->query($query)->result()[0]; ?>
                  <strong>@<?php echo $marked_to->userTitle; ?></strong> (<?php echo $marked_to->role_title; ?>) ->
                <?php } else { ?> <span style="margin-left: 15px;"></span> <?php } ?>



                <?php echo str_replace('\n', "\n", trim($comment->comment)); ?>
                <?php if ($pervious_user_id == $comment->created_by) { ?>
                  <small style="float: right;">
                    <?php echo date("D d M, Y", strtotime($comment->created_date)); ?>
                  </small>
                  <br />
                <?php } ?>


              </p>



              <?php $pervious_user_id = $comment->created_by; ?>
            <?php } ?>

          </div>

        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>

</html>