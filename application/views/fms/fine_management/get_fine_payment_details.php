<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Fine Payment Detail</h5>
        <button onclick="location.reload();" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <div class="col-md-12">
                <div style="font-size:9px; background-color: #f0f0f0; border-radius:10px; padding:10px;">

                    <div style=" font-size:9px; background-color: #f0f0f0; border-radius:10px; padding:10px;">
                        <h5>Add Fine Payment</h5>
                        <table class="table">
                            <tr>

                                <th>STAN No</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>

                            <tr>

                                <td><input type="number" value="" name="stan_no" id="stan_no_<?php echo $fine->fine_id ?>" /> </td>
                                <td><input type="date" value="" name="challan_date" id="challan_date_<?php echo $fine->fine_id ?>" /> </td>
                                <td><input min="0" onkeyup="inWords2(<?php echo $fine->fine_id ?>)" max="<?php echo $fine->fine_amount; ?>" style="width: 100px;" type="number" value="" name="deposit_amount" id="deposit_amount_<?php echo $fine->fine_id ?>" />


                                </td>
                                <td><button onclick="add_payment(<?php echo $fine->fine_id ?>)" class="bt n btn-s uccess b tn-sm">Add Payment</button> </td>
                            </tr>
                            <tr id="inword_div_<?php echo $fine->fine_id; ?>" style="display:none">
                                <td colspan="4" style="text-align: right;">
                                    <small style="color: red;"> In Words: </small> <small style="color: green;" id="inword_<?php echo $fine->fine_id ?>"></small>
                                </td>
                            </tr>

                        </table>
                        <div id="payment_error"></div>

                    </div>
                    <br />


                    <table class="table table-bordered">
                        <tr>
                            <th colspan="5">Fine Payment History</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>STAN No</th>
                            <th>Date</th>
                            <th style="text-align: center;">Amount</th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM fine_payments WHERE fine_id = '" . $fine->fine_id . "' and is_deleted =0";
                        $fine_payments = $this->db->query($query)->result();
                        // $fine_payments = array();
                        $count = 1;
                        foreach ($fine_payments as $fine_payment) { ?>
                            <tr <?php if ($fine_payment->is_deleted == 1) { ?> style="  background-color: #bcbcbc; text-decoration: line-through; " <?php } ?>>
                                <td>
                                    <?php if ($fine_payment->is_deleted != 1) { ?>
                                        <button class="btn btn-link" style="padding: 0px; margin: 0px;" onclick="delete_payment('<?php echo $fine->fine_id ?>','<?php echo $fine_payment->fine_payment_id;  ?>')" aria-hidden="true"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    <?php } else ?>
                                </td>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $fine_payment->stan_no ?></td>
                                <td><?php echo $fine_payment->challan_date ?></td>
                                <td style="text-align: center;"><?php echo $fine_payment->deposit_amount ?></td>

                            </tr>
                        <?php     }
                        ?>

                        <tr>
                            <th colspan="4" style="text-align: right;">Fine Paid: (Rs) </th>
                            <th style="text-align: center;"><?php echo @number_format($fine->total_fine_paid, 2) ?></td>
                        </tr>

                        <tr>
                            <th colspan="4" style="text-align: right;">Total Fine Remaining: (Rs) </th>
                            <th style="text-align: center;"><?php echo @number_format($fine->fine_amount - $fine->total_waived_off - $fine->total_fine_paid, 2) ?> </th>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button onclick="location.reload();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
    function add_payment(fine_id) {


        var stan_no = $('#stan_no_' + fine_id).val();
        if (stan_no == '') {
            alert("STAN Required.");
            return false;
        }
        var challan_date = $('#challan_date_' + fine_id).val();
        if (challan_date == '') {
            alert("Deposit Date Required.");
            return false;
        }
        var deposit_amount = $('#deposit_amount_' + fine_id).val();
        if (deposit_amount == '') {
            alert("Deposit Amount Required.");
            return false;
        }

        var max = parseInt($('#deposit_amount_' + fine_id).attr('max'));
        if (deposit_amount > max) {
            alert("paid amount must be less than or equal fined amount.");
            return false;
        }


        if (confirm("Are you sure you want to Add Payment ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fms/fine_management/add_fine_payment'); ?>",
                    data: {

                        fine_id: fine_id,
                        stan_no: stan_no,
                        challan_date: challan_date,
                        deposit_amount: deposit_amount
                    },
                })
                .done(function(response) {
                    //convert json response to object
                    console.log(response);
                    var obj = JSON.parse(response);

                    if (obj.error == true) {
                        $('#payment_error').html(obj.msg);
                    } else {

                        get_fine_payment_details(fine_id);

                    }
                });
        } else {
            return false;
        }
    }

    function delete_payment(fine_id, fine_payment_id) {

        if (confirm("Are you sure you want to delete ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fms/fine_management/delete_fine_payment'); ?>",
                    data: {
                        fine_id: fine_id,
                        fine_payment_id: fine_payment_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {
                        get_fine_payment_details(fine_id);
                    }

                });
        } else {
            return false;
        }
    }