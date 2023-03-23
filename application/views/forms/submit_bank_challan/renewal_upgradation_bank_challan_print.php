<?php $this->load->view('forms/submit_bank_challan/challan_print_header');   ?>

<table class="table">
  <tr>
    <th> Due's Date </th>
    <th>Application Processing Fee</th>
    <th>Inspection Fee</th>
    <th>Renewal Fee</th>
    <th>Upgradation Fee</th>
    <th> Late Fee % </th>
    <th> Late Fee Amount </th>
    <th> Total </th>
  </tr>
  <?php
  $count = 1;
  foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>

    <tr>
      <td style="width: 200px;">
        <?php if ($count == 1) { ?>

          <span>Up to </span>

        <?php } else { ?>
          <?php if ($count >= sizeof($session_fee_submission_dates)) { ?>
            After
          <?php } else { ?>
            <strong> <?php echo $previous_last_date; ?> </strong> to
          <?php } ?>
        <?php } ?>
        <?php
        $previous_last_date = date('d M, Y', strtotime($session_fee_submission_date->last_date . ' +1 day'));
        if ($count >= sizeof($session_fee_submission_dates)) {
          echo "<strong>" . date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day')) . "</strong>";
        } else {
          echo "<strong>" . date('d M, Y', strtotime($session_fee_submission_date->last_date)) . "</strong>";
        }
        ?>


      </td>
      <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
      <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>
      <td><?php echo number_format($fee_sturucture->renewal_fee); ?></td>
      <td><?php echo number_format($fee_sturucture->up_grad_fee);
          $total = ($fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee + $fee_sturucture->up_grad_fee);
          ?></td>

      <?php if ($session_fee_submission_date->fine_percentage == 0) { ?>
        <td colspan="2"> <strong> Normal Fee </strong></td>
      <?php } else { ?>
        <td><?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
        <td>
          <?php
          $fine = 0;
          $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
          echo number_format($fine);
          ?>
        </td>
      <?php } ?>
      <th>
        <?php echo number_format($fine + $total);  ?>
      </th>
    </tr>



  <?php
    $count++;
  } ?>
</table>

<?php $this->load->view('forms/submit_bank_challan/challan_print_footer');   ?>