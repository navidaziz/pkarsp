<div class="modal-header">
  <h4 class="pull-left"> PSRA Fee Structure </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <table class="table table-bordered">
    <tr>
      <th colspan="2"></th>
      <td></td>
      <th colspan="2" style="text-align: center;">Registration</th>
      <td></td>
      <th colspan="3" style="text-align: center;">Renewal</th>
      <td></td>
      <?php if ($school_type_id == 1) { ?>
        <th colspan="4" style="text-align: center;">Renewal+Upgradation</th>
        <td></td>
        <th style="text-align: center;">Upgradation</th>
        <td></td>
      <?php } ?>
      <?php if ($school_type_id == 7) { ?>
        <th></th>
      <?php } ?>
    </tr>
    <tr>
      <th>#</th>
      <th style="width: 100px;">Max Fee Range</th>
      <td></td>
      <th>Processsing Fee</th>
      <th>Inspection Fee</th>
      <td></td>
      <th>Renewal Fee</th>
      <?php if ($school_type_id == 7) { ?>
        <th>Security</th>
      <?php } ?>
      <?php if ($school_type_id == 1) { ?>
        <th>Processsing Fee</th>
        <th>Inspection Fee</th>
        <td></td>
        <th>Processsing Fee</th>
        <th>Inspection Fee</th>
        <th>Renewal Fee</th>
        <th>Upgradation Fee</th>
        <td></td>
        <th>Upgradation Fee</th>
      <?php } ?>
    </tr>
    <?php
    $count = 1;
    foreach ($fee_structures as $fee_structure) { ?>
      <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo $fee_structure->fee_min; ?> <?php if ($fee_structure->fee_max != '99999999999') {
                                                      echo  " - " . $fee_structure->fee_max;
                                                    } else {
                                                      echo " and above";
                                                    } ?></td>
        <td></td>
        <td> <?php echo $fee_structure->renewal_app_processsing_fee ?></td>
        <td> <?php echo $fee_structure->renewal_app_inspection_fee ?></td>
        <td></td>
        <td> <?php echo $fee_structure->renewal_app_processsing_fee ?></td>
        <td> <?php echo $fee_structure->renewal_app_inspection_fee ?></td>
        <td> <?php echo $fee_structure->renewal_fee ?></td>
        <td></td>
        <?php if ($school_type_id == 7) { ?>
          <td> <?php echo $fee_structure->security ?></td>
        <?php } ?>
        <?php if ($school_type_id == 1) { ?>
          <td> <?php echo $fee_structure->up_grad_app_processing_fee ?></td>
          <td> <?php echo $fee_structure->up_grad_inspection_fee ?></td>
          <td> <?php echo $fee_structure->renewal_fee ?></td>
          <td> <?php echo $fee_structure->up_grad_fee ?></td>
          <td></td>
          <td> <?php echo $fee_structure->up_grad_fee ?></td>
        <?php } ?>
      </tr>
    <?php  } ?>
  </table>
  <h4>Fee for initial registration for security purposes</h4>
  <table class="table">
    <tr>
      <th>Primary</th>
      <th>Middle</th>
      <th>High</th>
      <th>H.Sec / Inter College</th>
    </tr>
    <tr>
      <td>10,000 Rs.</td>
      <td>15,000 Rs.</td>
      <td>15,000 Rs.</td>
      <td>25,000 Rs.</td>
    </tr>
  </table>


</div>
<!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->