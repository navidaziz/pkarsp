<div class="modal-header">
  <h4 class="pull-left"> PSRA Fee Structure </h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
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

  <table class="table table-bordered">
    <tr>
      <th></th>
      <th></th>
      <th colspan="3" style="text-align: center;">Renewal</th>
      <th colspan="4" style="text-align: center;">Renewal+Upgradation</th>
      <th style="text-align: center;">Upgradation</th>
    </tr>
    <tr>
      <th>S/No</th>
      <th>Max Fee Range</th>
      <th>Processsing Fee</th>
      <th>Inspection Fee</th>
      <th>Renewal Fee</th>

      <th>Processsing Fee</th>
      <th>Inspection Fee</th>
      <th>Renewal</th>
      <th>Upgradation</th>

      <th>Upgradation</th>
    </tr>
    <?php
    $count = 1;
    foreach ($fee_structures as $fee_structure) { ?>
      <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo $fee_structure->fee_min; ?> <?php if ($fee_structure->fee_max != '99999999999') {
                                                      echo  " - " . $fee_structure->fee_max;
                                                    } ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_app_processsing_fee ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_app_inspection_fee ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_fee ?></td>

        <td>Rs. <?php echo $fee_structure->up_grad_app_processing_fee ?></td>
        <td>Rs. <?php echo $fee_structure->up_grad_inspection_fee ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_fee ?></td>
        <td>Rs. <?php echo $fee_structure->up_grad_fee ?></td>


        <td>Rs. <?php echo $fee_structure->up_grad_fee ?></td>
      </tr>
    <?php  } ?>
  </table>
</div>
<!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->