  <!-- Modal -->
  <script>
    function update_class_fee_detail(class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_fee_from"); ?>",
        data: {
          schools_id: <?php echo $school->schoolId; ?>,
          class_id: class_id,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>
        }
      }).done(function(data) {

        $('#update_class_ages_body').html(data);
      });

      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="update_class_ages_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2 style="display:inline;">
        <?php echo ucwords(strtolower($school->schoolName)); ?>
      </h2>
      <br />
      <h4>S-ID: <?php echo $school->schools_id; ?> - REG No: <?php echo $school->registrationNumber ?></h4>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active"><?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <div class="box box-primary box-solid">


        <div class="box-body">
          <div class="row">

            <div class="col-md-12">


              <div style="text-align:center">

                <h4> Online Applicaiton Status</h4>
                <h3> <?php echo $school->regTypeTitle ?> Session: <?php echo $session_detail->sessionYearTitle; ?></h3>

                <?php
                $query = "SELECT
                `bank_challans`.*,
                `session_year`.`sessionYearTitle`,
                `school`.`schools_id`,
                `school`.`status`
                    FROM
                      `school`,
                      `bank_challans`,
                      `session_year`
                    WHERE `school`.`schoolId` = `bank_challans`.`school_id`
                      AND `session_year`.`sessionYearId` = `bank_challans`.`session_id`
                      AND   `bank_challans`.`session_id` = '" . $session_id . "' 
                ORDER BY bank_challan_id DESC LIMIT 1";
                $session_bank_challans = $this->db->query($query)->result(); ?>
                <h3>Bank Deposit Challan Detail</h3>
                <?php foreach ($session_bank_challans as $session_bank_challan) { ?>

                  <h5><?php echo $session_bank_challan->challan_for; ?> -
                    <?php echo $session_bank_challan->challan_no; ?> -
                    <?php echo date('F d m, Y', strtotime($session_bank_challan->challan_date)); ?> <br />
                    <?php if ($session_bank_challan->verified == 0) { ?>
                      Bank Challan Verification Inprogress
                    <?php } ?>

                    <?php if ($session_bank_challan->verified == 1) { ?>
                      <?php echo $session_bank_challan->amount_deposit; ?> Verified.<br />
                      <?php if ($session_bank_challan->status == 3) { ?>
                        Application Forworded to Registration Section.

                      <?php } ?>
                    <?php } ?>

                    <?php if ($session_bank_challan->verified == 2) { ?>
                      Not Verified.
                      <br />
                      <p><?php echo $session_bank_challan->remarks; ?><br />
                        <a class="btn btn-danger btn-sm" href="<?php echo site_url("form/submit_bank_challan/$session_id"); ?>">
                          Re Submit Bank Challan</a>
                      </p>
                    <?php } ?>

                  </h5>

                <?php  }
                ?>



              </div>





            </div>

          </div>
        </div>


      </div>

    </section>

  </div>