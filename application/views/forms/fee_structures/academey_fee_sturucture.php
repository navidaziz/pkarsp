<div class="modal-header">
  <h4 class="pull-left"> PSRA Academies Fee Structure </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <table class="table table-bordered">
    <tr>
      <th colspan="2"></th>
      <td></td>
      <th colspan="3" style="text-align: center;">Registration</th>
      <td></td>
      <th colspan="3" style="text-align: center;">Renewal</th>

    </tr>
    <tr>
      <th>#</th>
      <th style="">Max Fee Range</th>
      <td></td>
      <th>Application Processsing Fee</th>
      <th>Inspection Fee</th>
      <th>Security Fee</th>
      <td></td>
      <th>ApplicationProcesssing Fee</th>
      <th>Inspection Fee</th>
      <th>Renewal Fee</th>
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
        <td> <?php echo number_format($fee_structure->renewal_app_processsing_fee) ?></td>
        <td> <?php echo number_format($fee_structure->renewal_app_inspection_fee) ?></td>
        <td> <?php echo number_format($fee_structure->security) ?></td>
        <td></td>
        <td> <?php echo number_format($fee_structure->renewal_app_processsing_fee) ?></td>
        <td> <?php echo number_format($fee_structure->renewal_app_inspection_fee) ?></td>
        <td> <?php echo number_format($fee_structure->renewal_fee) ?></td>
        <td></td>

      </tr>
    <?php  } ?>
  </table>



</div>
<!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->