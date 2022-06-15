<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Update Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- STYLESHEETS -->
  <!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css">
  <link href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- DATE RANGE PICKER -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <!-- UNIFORM -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/css/uniform.default.min.css" />
  <!-- ANIMATE -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/animatecss/animate.min.css" />
  <style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
      padding: 1px !important;
    }
  </style>
</head>

<body class="log in" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets/" . ADMIN_DIR . "img/background.jpg"); ?>);
    background-size: cover;
    ">

  <?php
  $userId = $this->session->userdata('userId');
  $query = "
  SELECT 
  `schools`.*,
  `district`.`districtTitle`,
  `tehsils`.`tehsilTitle`,
  `uc`.`ucTitle`,
  `users`.userEmail 
FROM
  `schools` 
  INNER JOIN `district` 
    ON (
      `schools`.`district_id` = `district`.`districtId`
    ) 
  INNER JOIN `tehsils` 
    ON (
      `tehsils`.`tehsilId` = `schools`.`tehsil_id`
    ) INNER JOIN `users` 
    ON (
      `users`.`userId` = `schools`.`owner_id`
    )
  LEFT JOIN `uc` 
    ON (`uc`.`ucId` = `schools`.`uc_id`)
    WHERE  `schools`.owner_id = '" . $userId . "'";
  $school_detail  = $this->db->query($query)->result()[0];
  ?>
  <!-- PAGE -->
  <section id="page">

    <section>
      <div class="container">
        <div class="row" style=" margin: 100px;">
          <form class="" method="post" enctype="multipart/form-data" id="" action="<?php echo base_url('profile_update/update_data'); ?>">

            <div class="col-md-6">
              <div style="text-align: center; color:black; font-size: 18px; margin: 0px auto;  width:100%; margin:15px">
                <br />
                <h2 style=""><?php echo ucwords(strtolower($school_detail->schoolName)); ?></h2>
                <br />
                <strong>
                  School ID: <?php echo $school_detail->schoolId; ?>
                  <?php if ($school_detail->registrationNumber > 0) { ?>
                    - Registration No: <?php echo $school_detail->registrationNumber; ?>
                  <?php } ?>
                </strong>
                <div>
                  District: <?php echo $school_detail->districtTitle; ?>,
                  Tehsil: <?php echo $school_detail->tehsilTitle; ?>,
                  <?php if ($school_detail->ucTitle) { ?>
                    UC: <?php echo $school_detail->ucTitle; ?>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;   padding: 10px; background-color: white;">
                <h4>Institute Contact Detail</h4>
                <table class="table" style="">
                  <tr>
                    <td>Institute Contact No. </td>
                    <td><input data-mask="(999) 999-9999" type="text" id="telePhoneNumber" required="required" name="telePhoneNumber" name="telePhoneNumber"  value="<?php echo $school_detail->telePhoneNumber ?>"> </td>
                  </tr>
                  <tr>
                    <td>Institute Contact No (Mobile). </td>
                    <td><input type="text" id="schoolMobileNumber" required="required" name="schoolMobileNumber" value="<?php echo $school_detail->schoolMobileNumber ?>"> </td>
                  </tr>

                  <tr>
                    <td>Institute Email Address. </td>
                    <td><input type="email" id="principal_email" required="required" name="principal_email" value="<?php echo $school_detail->principal_email ?>"> </td>
                  </tr>

                </table>

                <h4>School Account Email Address</h4>
                <h5>This email address used to recover username and password of online school account in future. Email address may be same as the above "Institute Email Address"</h5>
                <table class="table" style="">

                  <tr>
                    <td> User Account Email Address. </td>
                    <td><input type="email" id="userEmail" required="required" name="userEmail" value="<?php echo $school_detail->userEmail; ?>"> </td>
                  </tr>

                </table>
                <br />
                <input class="btn btn-success" type="submit" name="" value="Update and Continue">

              </div>
            </div>

          </form>
        </div>
      </div>


    </section>
    <!--/PAGE -->
    <!-- JAVASCRIPTS -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- JQUERY -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/jquery/jquery-2.0.3.min.js"></script>
    <!-- JQUERY UI-->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
    <!-- BOOTSTRAP -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/bootstrap-dist/js/bootstrap.min.js"></script>

    <!-- UNIFORM -->
    <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/jquery.uniform.min.js"></script>
    <!-- BACKSTRETCH -->
    <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/backstretch/jquery.backstretch.min.js"></script>
    <!-- CUSTOM SCRIPT -->
    <script src="<?php echo base_url('assets/lib/plugins/input-mask/jquery.inputmask.js'); ?>"></script>

<script>
  $(document).ready(function() {
    $('#telePhoneNumber').inputmask('(9999)-9999999');
    $('#cnic').inputmask('99999-9999999-9');
    $('#contactNumber').inputmask('(9999)-9999999');
    $('#telePhoneNumber').inputmask('(9999)-9999999');
    $('#schoolMobileNumber').inputmask('(9999)-9999999');

    $('#late').inputmask('99.9999999');
    $('#long').inputmask('99.9999999');


  });
</script>

    <!-- /JAVASCRIPTS -->
</body>

</html>