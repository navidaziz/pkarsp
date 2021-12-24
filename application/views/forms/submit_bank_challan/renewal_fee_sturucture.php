<div class="modal-header">
  <h4 class="pull-left"> PSRA Renewal Fee Structure </h4>
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
      <th>S/No</th>
      <th>Max Fee Range</th>
      <th>Processsing Fee</th>
      <th>Inspection Fee</th>
      <th>Renewal Fee</th>
    </tr>
    <?php
    $count = 1;
    foreach ($fee_structures as $fee_structure) { ?>
      <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo $fee_structure->fee_min . "-" . $fee_structure->fee_max ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_app_processsing_fee ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_app_inspection_fee ?></td>
        <td>Rs. <?php echo $fee_structure->renewal_fee ?></td>
      </tr>
    <?php  } ?>
  </table>
</div>
<!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> -->