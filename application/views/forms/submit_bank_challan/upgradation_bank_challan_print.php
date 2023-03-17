<?php $this->load->view('forms/submit_bank_challan/challan_print_header');   ?>
<table class="table">
  <tr>
    <th> Due's Date </th>
    <th>Upgradation Fee</th>
    <th> Late Fee % </th>
    <th> Late Fee Amount </th>
    <th> Total </th>
  </tr>
  <?php
  $count = 1;
  $previous_last_date = '';
  foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>

    <tr>
      <td style="width: 200px;">
        <?php if ($count == 1) { ?>

          <!-- <strong> 01 Apr, <?php echo date('Y', strtotime($session_fee_submission_date->last_date)); ?></strong> to  -->

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

      <td><?php $total = $fee_sturucture->up_grad_fee;
          echo number_format($total);
          ?></td>
      <?php if ($session_fee_submission_date->fine_percentage == 0) { ?>
        <td colspan="2"> <strong> Normal Fee </strong></td>
      <?php } else { ?>
        <td style="color:red"><?php echo $session_fee_submission_date->fine_percentage; ?> %</td>
        <td style="color:red">
          <?php
          $fine = 0;
          $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
          echo number_format($fine);
          ?>
        </td>
      <?php } ?>

      <td>
        <strong> <?php echo number_format($fine + $total);  ?> </strong>
      </td>
    </tr>



  <?php
    $count++;
  } ?>

</table>

<?php $this->load->view('forms/submit_bank_challan/challan_print_footer');   ?>