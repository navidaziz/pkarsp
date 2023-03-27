<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($title)); ?>
    </h2>
    <br />
    <h4><?php echo $description; ?></h4>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <!-- <li><a href="#">Examples</a></li> -->
      <li class="active"><?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></li>
    </ol>
  </section>



  <!-- Main content -->
  <section class="content" style="padding-top: 0px !important;">

    <div class="box box-primary box-solid">


      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
          </div>
          <div class="col-md-6">
            <?php
            $userId = $this->session->userdata('userId');
            $query = "
              SELECT 
              `schools`.*,
              `district`.`districtTitle`,
              `users`.userEmail 
            FROM
              `schools` 
              INNER JOIN `district` 
                ON (
                  `schools`.`district_id` = `district`.`districtId`
                ) 
              INNER JOIN `users` 
                ON (
                  `users`.`userId` = `schools`.`owner_id`
                )
                WHERE  `schools`.owner_id = '" . $userId . "'";
            $school_detail  = $this->db->query($query)->result()[0];
            ?>
            <form method="post" action="<?php echo site_url('user_account/update_account_contact_details'); ?>">
              <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;   padding: 10px; background-color: white;">
                <h4>Institute Contact Detail</h4>
                <table class="table" style="">
                  <tr>
                    <td>Institute Landline No. </td>
                    <td><input class="form-control" data-mask="(999) 999-9999" type="text" id="telePhoneNumber" required="required" name="telePhoneNumber" name="telePhoneNumber" value="<?php echo $school_detail->telePhoneNumber ?>"> </td>
                  </tr>
                  <tr>
                    <td>Institute Mobile No. </td>
                    <td><input class="form-control" type="text" id="schoolMobileNumber" required="required" name="schoolMobileNumber" value="<?php echo $school_detail->schoolMobileNumber ?>"> </td>
                  </tr>

                  <tr>
                    <td>Institute Email Address. </td>
                    <td><input class="form-control" type="email" id="principal_email" required="required" name="principal_email" value="<?php echo $school_detail->principal_email ?>"> </td>
                  </tr>

                </table>

                <h4>Institute Account Email Address</h4>
                <h5>In the future, this email address may be used to recover the username and password for the online school account. It's possible that the email address will be the same as the "Institute Email Address" mentioned above.</h5>
                <table class="table" style="">

                  <tr>
                    <td>Account Email Address. </td>
                    <td><input class="form-control" type="email" id="userEmail" required="required" name="userEmail" value="<?php echo $school_detail->userEmail; ?>"> </td>
                  </tr>


                  <?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) { ?>
                    <tr>
                      <td colspan="2">
                        <?php if ($this->session->flashdata('msg_error')) { ?>
                          <div class="alert alert-block alert-danger fade in">
                            <?php echo $this->session->flashdata('msg_error'); ?>
                          </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('msg_success')) { ?>
                          <div class="alert alert-block alert-success fade in">
                            <?php echo $this->session->flashdata('msg_success'); ?>
                          </div>
                        <?php } ?>
                      </td>
                    <?php } ?>


                </table>
                <br />
                <input class="btn btn-success" type="submit" name="" value="Update Account Contact Detail">

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </section>

</div>

<script src="<?php echo base_url('assets/lib/plugins/input-mask/jquery.inputmask.js'); ?>"></script>

<script>
  $(document).ready(function() {
    $('#telePhoneNumber').inputmask('99999999999');
    $('#schoolMobileNumber').inputmask('(9999)-9999999');



  });
</script>