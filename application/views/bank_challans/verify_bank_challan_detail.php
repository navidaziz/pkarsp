<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
    Bank Challan Bank Challan Verification
  </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <h5 style="color: red;"></h5>


  <?php
  $query = "SELECT
    `bank_challans`.*,
    `session_year`.`sessionYearTitle`,
    `school`.`schools_id`,
    `schools`.`schoolName`,
    `schools`.`yearOfEstiblishment`,
    `schools`.biseRegister,
    `schools`.biseregistrationNumber
    FROM
    `school`,
    `bank_challans`,
    `session_year`,
    `schools`
    WHERE `school`.`schoolId` = `bank_challans`.`school_id`
    AND `session_year`.`sessionYearId` = `bank_challans`.`session_id`
    AND `schools`.`schoolId` = `school`.`schools_id`
    AND `bank_challans`.`bank_challan_id` = '" . $bank_challan_id . "'";
  $session_bank_challan = $this->db->query($query)->result()[0];
  ?>

  <h4>School Name: <?php echo $session_bank_challan->schoolName ?></h4>
  <h4>School ID: <?php echo $session_bank_challan->schools_id ?></h4>
  <form action="<?php echo site_url("bank_challans/verified_bank_challan") ?>" method="post">
    <input type="hidden" name="bank_challan_id" value="<?php echo $session_bank_challan->bank_challan_id; ?>" />
    <table class="table table-bordered">

      <tr>
        <th>Challan Type</th>
        <th title="System Trace Audit Number">STAN</th>
        <th>Deposit Date</th>
        <th>Vefiried:</td>
      </tr>
      <tr>

        <td><?php echo $session_bank_challan->challan_for; ?> - <?php echo $session_bank_challan->sessionYearTitle; ?></td>
        <td><?php echo $session_bank_challan->challan_no; ?></td>
        <td><?php echo date('d M, Y', strtotime($session_bank_challan->challan_date)); ?></td>
        <td><input onclick="$('#amount_tr').show();$('#amount_deposit').prop('required',true);$('#remarks_tr').hide();$('#remarks').prop('required',false);" type="radio" name="verified" value="yes" required /> Yes
          <span style="margin-left:10px"></span>
          <input onclick="$('#amount_tr').hide();$('#amount_deposit').prop('required',false);$('#remarks_tr').show();$('#remarks').prop('required',true);" type="radio" name="verified" value="no" required /> No
        </td>
      </tr>
      <tr id="amount_tr" style="display: none;">
        <td colspan="4">
          <table class="table" style="width: 100%;">
            <?php if ($session_bank_challan->challan_for == 'Renewal' or $session_bank_challan->challan_for == 'Registration' or $session_bank_challan->challan_for == 'Upgradation' or $session_bank_challan->challan_for == 'Renewal Upgradation' or $session_bank_challan->challan_for == 'Deficiency') { ?>
              <tr>
                <td style="width: 200px;">
                  Application Processing Fee:</td>
                <td><input class="bank_challan_values" type="number" name="application_processing_fee" min="0" required /> </td>
              </tr>
              <tr>
                <td>
                  Inspection Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="inspection_fee" required min="0" /> </td>
              </tr>

              <?php if ($session_bank_challan->challan_for == 'Renewal' or $session_bank_challan->challan_for == 'Deficiency') { ?>
                <tr>
                  <td> Renewal Fee:</td>
                  <td><input class="bank_challan_values" type="number" name="renewal_fee" required min="0" /> </td>
                </tr>
              <?php } ?>

              <tr>
                <td>
                  Late Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="late_fee" required min="0" /> </td>
              </tr>

            <?php } ?>
            <?php if ($session_bank_challan->challan_for == 'Registration' or $session_bank_challan->challan_for == 'Deficiency') { ?>
              <tr>
                <td>
                  Security Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="security_fee" required min="0" /> </td>
              </tr>
            <?php } ?>



            <?php if ($session_bank_challan->challan_for == 'Upgradation' or $session_bank_challan->challan_for == 'Deficiency') { ?>
              <tr>
                <td>
                  Up-Gradation Fee:</td>
                <td><input class="bank_challan_values" type="number" name="upgradation_fee" required min="0" /> </td>
              </tr>
            <?php } ?>

            <?php if ($session_bank_challan->challan_for == 'Renewal Upgradation' or $session_bank_challan->challan_for == 'Deficiency') { ?>
              <tr>
                <td>
                  Renewal and Up-Gradation Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="renewal_and_upgradation_fee" required min="0" /> </td>
              </tr>
            <?php } ?>
            <?php if ($session_bank_challan->challan_for == 'Renewal' or $session_bank_challan->challan_for == 'Registration' or $session_bank_challan->challan_for == 'Upgradation' or $session_bank_challan->challan_for == 'Renewal Upgradation' or $session_bank_challan->challan_for == 'Deficiency') { ?>
              <tr>
                <td>
                  Fine:
                </td>
                <td><input class="bank_challan_values" type="number" name="fine" required min="0" /> </td>
              </tr>
            <?php } ?>
            <?php if ($session_bank_challan->challan_for == 'Change Of Name') { ?>
              <tr>
                <td>
                  Change of Name Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="change_of_name_fee" required min="0" /> </td>
              </tr>
            <?php } ?>
            <?php if ($session_bank_challan->challan_for == 'Change Of Ownership') { ?>
              <tr>
                <td>
                  Change of Ownership Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="change_of_ownership_fee" required min="0" /> </td>
              </tr>
            <?php } ?>
            <?php if ($session_bank_challan->challan_for == 'Change Of Building') { ?>
              <tr>
                <td>
                  Change of Building Fee:
                </td>
                <td><input class="bank_challan_values" type="number" name="change_of_building_fee" required min="0" /> </td>
              </tr>
            <?php } ?>
            <tr>
              <td style="text-align: right;">
                <strong>Total Fee: </strong>
              </td>
              <td>
                <strong id="bankchallantotal">00.00</strong>
                <input type="hidden" id="total_deposit_fee" name="total_deposit_fee" value="yes" required min="0" />
              </td>
            </tr>

            <?php
            $query = "SELECT * FROM `bise_verification_requests` WHERE school_id = '" . $session_bank_challan->schools_id . "' AND status IN(1,2,0)";
            $bise_verification = $this->db->query($query)->result();
            if ($bise_verification and $bise_verification[0]->status == 1 or $bise_verification[0]->status == 2) {
              $bise_tdr = $bise_verification[0]->tdr_amount;
            } else {
              $bise_tdr = 0;
            }

            ?>



            <?php if (strtolower($session_bank_challan->biseRegister) == 'yes' and  $session_bank_challan->challan_for == 'Registration') { ?>
              <tr>
                <td colspan="2">
                  <h5 style="text-align: center;">
                    BISE Registration No. <?php echo $session_bank_challan->biseregistrationNumber; ?><br />
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

                  </h5>
                </td>

              </tr>
            <?php } ?>

            <input min="0" type="hidden" id="bise_tdr" name="bise_tdr" value="<?php echo $bise_tdr; ?>" />

            <tr>
              <td colspan="2" style="text-align: center;">
                <input class="btn btn-primary" type="submit" value="Verified" name="verified" />
              </td>
            </tr>
          </table>
        </td>
      </tr>
  </form>
  <tr id="remarks_tr" style="display: none;">

    <td colspan="4">
      <form action="<?php echo site_url("bank_challans/verified_bank_challan") ?>" method="post">
        <input type="hidden" name="bank_challan_id" value="<?php echo $session_bank_challan->bank_challan_id; ?>" />
        Remarks:
        <textarea id="remarks" name="remarks" style="width: 100%;" cols="50"> </textarea>
        <p style="text-align: center;">
          <input class="btn btn-danger" type="submit" value="Not Verified" name="verified" />
        </p>
      </form>
    </td>
  </tr>
  </table>




</div>

<script>
  $(document).on("keyup", ".bank_challan_values", function() {
    var sum = 0;
    $(".bank_challan_values").each(function() {
      sum += +$(this).val();
    });
    $("#total_deposit_fee").val(sum);
    $("#bankchallantotal").html(sum);

  });
</script>