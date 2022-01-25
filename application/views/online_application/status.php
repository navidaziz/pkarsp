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
            <div class="col-md-4">
              <div style="text-align:center">

                <h4> Online Applicaiton Status</h4>
                <h3> <?php echo $school->regTypeTitle ?> for <?php echo $school->levelofInstituteTitle; ?> Session: <?php echo $session_detail->sessionYearTitle; ?></h3>

                <?php
                echo  $query = "SELECT
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
                      AND   `bank_challans`.`school_id` = '" . $school->school_id . "'
                ORDER BY bank_challan_id ASC";
                $session_bank_challans = $this->db->query($query)->result(); ?>
                <h3>Bank Deposit Challan Detail</h3>
                <?php foreach ($session_bank_challans as $session_bank_challan) { ?>

                  <h5>
                    <span <?php if ($session_bank_challan->verified == 2) { ?> style="text-decoration: line-through;" <?php } ?>><?php echo $session_bank_challan->challan_for; ?> -
                      <?php echo $session_bank_challan->challan_no; ?> -
                      <?php echo date('F d m, Y', strtotime($session_bank_challan->challan_date)); ?>
                    </span>
                    -
                    <?php if ($session_bank_challan->verified == 0) { ?>
                      Bank Challan Verification Inprogress
                    <?php } ?>

                    <?php if ($session_bank_challan->verified == 1) { ?>
                      <?php echo $session_bank_challan->amount_deposit; ?> Verified.<br />

                    <?php } else {
                      echo "Not verified";
                    } ?>

                    <?php if ($session_bank_challan->verified == 2 and $session_bank_challan->status == 0) { ?>
                      Not Verified.
                      <br />
                      <p><?php echo $session_bank_challan->remarks; ?><br />
                        <?php if ($session_bank_challan->challan_for != 'Deficiency') { ?>
                          <a class="btn btn-danger btn-sm" href="<?php echo site_url("form/submit_bank_challan/$session_id"); ?>">
                            Re Submit Bank Challan</a>
                        <?php } ?>
                      </p>
                    <?php } else { ?>

                    <?php } ?>

                  </h5>

                <?php  }
                ?>



              </div>
              <div>
                <?php
                if ($school->status == 7) { ?>
                  <h3 style="text-align: center;">Deficiency</h3>
                  <?php $query = "SELECT * FROM deficiencies 
                                  WHERE status =0
                                  AND school_id = '" . $school->school_id . "'";
                  $deficiencies =  $this->db->query($query)->result();
                  foreach ($deficiencies as $deficiency) { ?>
                    <div class="col-md-6">
                      <p><strong><?php echo $deficiency->deficiency_title; ?>
                          <?php //echo $deficiency->deficiency_type; 
                          ?></strong><br />
                        <?php echo $deficiency->deficiency_detail; ?></p>
                      <br />
                      <p style="text-align: center;">
                        <strong>Please print deficiency bank challan </strong><br />
                        <a target="_new" class="btn btn-danger" href="<?php echo site_url("deficiency/bank_challan/" . $deficiency->deficiency_id); ?>">Pint Bank Challan</a>
                      </p>
                    </div>
                    <div class="col-md-6">
                      <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px;">
                        <h4>Submit Deficiency Challan for session <?php echo $session_detail->sessionYearTitle; ?></h4>
                        <form action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">
                          <input type="hidden" name="deficiency_id" value="<?php echo $deficiency->deficiency_id; ?>" />
                          <input type="hidden" name="last_status" value="<?php echo $deficiency->last_status; ?>" />
                          <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
                          <input type="hidden" name="challan_for" value="Deficiency" />
                          <table class="table table-bordered">
                            <tr>
                              <td>Bank Transaction No (STAN)</td>
                              <td>Bank Transaction Date</td>
                            </tr>
                            <tr>
                              <td><input required maxlength="6" name="challan_no" type="number" autocomplete="off" class="form-control" />
                                <small>"STAN can be found on the upper right corner of bank generated receipt"</small>
                              </td>
                              <td><input required name="challan_date" type="date" class="form-control" />
                              </td>
                              <td><input type="submit" class="btn btn-success" name="submit" value="Submit Bank Challan" />
                              </td>
                            </tr>
                          </table>
                        </form>
                      </div>
                    </div>
                  <?php } ?>
                  <h4></h4>
                <?php } ?>
              </div>
            </div>







          </div>
        </div>


      </div>

    </section>

  </div>