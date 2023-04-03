<?php $this->load->view('forms/submit_bank_challan/challan_print_header');   ?>

<table class="table table_reg">
  <tr>
    <th>Challan For </th>
    <th>Security </th>
    <th> Total </th>
  </tr>
  <tr>
    <td>
      <?php if ($level_type == 1) { ?> <strong> Primary </strong> <?php } ?>
      <?php if ($level_type == 2) { ?> <strong> Middle </strong> <?php } ?>
      <?php if ($level_type == 3) { ?> <strong> High </strong> <?php } ?>
      <?php if ($level_type == 4) { ?> <strong> High Secondary </strong> <?php } ?>
    </td>
    <td>
      <?php if ($level_type == 1) { ?> <strong> 10,000 </strong> <?php } ?>
      <?php if ($level_type == 2) { ?> <strong> 15,000 </strong> <?php } ?>
      <?php if ($level_type == 3) { ?> <strong> 15,000 </strong> <?php } ?>
      <?php if ($level_type == 4) { ?> <strong> 25,000 </strong> <?php } ?>
    </td>
    <td>
      <?php if ($level_type == 1) { ?> <strong> 10,000 </strong> <?php } ?>
      <?php if ($level_type == 2) { ?> <strong> 15,000 </strong> <?php } ?>
      <?php if ($level_type == 3) { ?> <strong> 15,000 </strong> <?php } ?>
      <?php if ($level_type == 4) { ?> <strong> 25,000 </strong> <?php } ?>
    </td>
  </tr>

</table>
<?php $this->load->view('forms/submit_bank_challan/challan_print_footer');   ?>