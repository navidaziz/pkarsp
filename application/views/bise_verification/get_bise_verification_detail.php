<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">
    BISE Verification
  </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <h5 style="color: red;"></h5>


  <?php
  $query = "SELECT
  `schools`.`schoolName`
  , `schools`.`schoolId`
  , `bise`.`biseName`
  , `bise_verification_requests`.`id`
  , `bise_verification_requests`.`registration_number`
  , `bise_verification_requests`.`created_date`
  , `bise_verification_requests`.`id`
FROM
  `bise_verification_requests`
  INNER JOIN `schools` 
      ON (`bise_verification_requests`.`school_id` = `schools`.`schoolId`)
  LEFT JOIN `bise` 
      ON (`bise`.`biseId` = `bise_verification_requests`.`bise_id`)
      WHERE `bise_verification_requests`.`id` = '" . $id . "'";
  $session_bise_verification = $this->db->query($query)->result()[0];
  ?>

  <h4>School Name: <?php echo $session_bise_verification->schoolName ?></h4>
  <h4>School ID: <?php echo $session_bise_verification->schoolId ?></h4>
  <form action="<?php echo site_url("bise_verification/verify_bise_reg") ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $session_bise_verification->id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $session_bise_verification->schoolId; ?>" />
    <table class="table table-bordered">

      <tr>

        <th>Date</th>
        <th>BISE</th>
        <th>REG. No</th>
        <th>Verify</th>
      </tr>
      <tr>

        <td><?php echo date('d M, Y', strtotime($session_bise_verification->created_date)); ?></td>
        <td><?php echo $session_bise_verification->biseName; ?></td>
        <td><?php echo $session_bise_verification->registration_number; ?></td>
        <td> <span style="margin-left:10px ;"></span>
          <input onclick="$('#verified').show(); $('#not_verified').hide(); $('#bise_tdr').prop('required',true);" type="radio" name="bise_verified" value="Yes" required /> Verified
          <input onclick="$('#verified').hide(); $('#not_verified').show();$('#bise_tdr').prop('required',false);" type="radio" name="bise_verified" value="No" required /> Not Verified <br />
        </td>
      </tr>
      <tr id="verified" style="display: none;">
        <td colspan="4">

          <span>
            TDR Amount: <input min="0" type="number" id="bise_tdr" name="bise_tdr" value="" />
          </span>

          <input class="btn btn-primary" type="submit" value="Verified" name="verified" />
        </td>
      </tr>

      <tr id="not_verified" style="display: none;">

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
    </td>
    </tr>
  </form>

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