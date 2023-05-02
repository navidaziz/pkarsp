<div class="modal-body">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Fine Detail</h4>
    </div>
    <div class="row">
        <div class="col-md-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>School ID</th>
                        <td><?php echo $fine_summary->school_id; ?></td>
                    </tr>
                    <tr>
                        <th>School Name</th>
                        <td><?php echo $fine_summary->school_name; ?></td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td><?php echo $fine_summary->district_name; ?></td>
                    </tr>
                    <tr>
                        <th>Tehsil</th>
                        <td><?php echo $fine_summary->tehsil_name; ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo $fine_summary->address; ?></td>
                    </tr>
                    <tr>
                        <th>Density</th>
                        <td><?php echo $fine_summary->density; ?></td>
                    </tr>
                    <tr>
                        <th>Total Fine</th>
                        <td><?php echo $fine_summary->total_fine; ?></td>
                    </tr>
                    <tr>
                        <th>Waveoffed</th>
                        <td><?php echo $fine_summary->w_offed; ?></td>
                    </tr>
                    <tr>
                        <th>Total Paid</th>
                        <td><?php echo $fine_summary->paid_amount; ?></td>
                    </tr>
                    <tr>
                        <th>Total Due</th>
                        <td><?php echo $fine_summary->total_fine - $fine_summary->paid_amount; ?></td>
                    </tr>
                </thead>
                <tbody>



                </tbody>
            </table>
        </div>
        <div class="col-md-9">
            <?php
            $count = 1;

            foreach ($fines as $fine) {
                $total_paid = $fine->fine_amount - $fine->total_payment;
            ?>

                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;   margin: 5px; padding: 5px; background-color: white;">
                    <?php if ($fine->status != 0) { ?>

                        <div class="col-md-7" style="background-color: #f0f0f0; border-radius:10px">
                            <table class="table">
                                <tr>

                                    <td>File No</td>
                                    <td>Date</td>
                                    <td>Fine Amount</td>
                                    <td> Status </td>
                                </tr>
                                <tr>

                                    <td><?php echo $fine->file_number ?></td>
                                    <td><?php echo date("d m, Y", strtotime($fine->file_date)) ?></td>
                                    <td><?php echo $fine->fine_amount ?></td>
                                    <td>
                                        <?php if ($fine->status == 1 and $total_paid != 0) { ?>
                                            <span class="label label-danger label-sm ">Not Paid</span>

                                        <?php } else { ?>
                                            <span class="label label-success label-sm ">Paid</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>

                                    <td colspan="4">
                                        <small><?php echo $fine->fine_title ?> / <?php echo $fine->fine_channel_title ?></small>
                                        <p> <strong> <?php echo $fine->remarks ?> </strong></p>
                                        <br />
                                        <div style="text-align: left; font-size:9px; text-align:right">
                                            <span class="pull-left" style="font-size: 14px;">
                                                Download Attachment: <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </span>
                                            <small>
                                                <?php if ($fine->status == 1 and $fine->total_payment <= 0) { ?>
                                                    <button class="btn btn-danger" style="padding: 1px; margin: 0px; font-size: 9px;" onclick="delete_fine(<?php echo $fine->fine_id ?>)" aria-hidden="true"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>

                                                    <button onclick="$('#waive_off_form_<?php echo $fine->fine_id ?>').toggle()" class="btn btn-warning btn-sm" style="padding: 1px; margin: 0px; font-size: 9px;"> <span class="fa fa-hand-stop-o"></span> Waive Off</button>
                                                <?php } ?>
                                            </small>
                                        </div>

                                    </td>
                                </tr>
                            </table>

                            <div class="clearfix"></div>
                            <?php if ($fine->status == 1 and $total_paid != 0) { ?>

                                <div id="waive_off_form_<?php echo $fine->fine_id ?>" style="display: none; padding:10px">
                                    <table class="table">
                                        <tr>
                                            <td>Waived of file / notification no: <br /><input style="width: 100%;" type="text" id="waived_off_file_no_<?php echo $fine->fine_id ?>" name="waived_off_file_no" value="" /></td>
                                            <td>Waived off amount: <br /><input style="width: 100%;" min="1" max="<?php echo $fine->fine_amount ?>" type="number" id="waived_off_amount_<?php echo $fine->fine_id ?>" name="waived_off_amount" value="" /></td>
                                            <td>Waived date: <br /><input style="width: 100%;" type="date" id="waived_off_date_<?php echo $fine->fine_id ?>" name="waived_off_date" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <strong>Wavie off detail</strong>
                                                <br />
                                                <textarea style="width: 100%; padding:5px" id="wo_<?php echo $fine->fine_id ?>"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: center;">
                                                <button onclick="waive_off_fine('<?php echo $fine->fine_id ?>');" class="btn btn-warning"><span class="fa fa-hand-stop-o"></span> Add Waived Off Details</button>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            <?php } ?>

                        </div>


                        <div class="col-md-5">
                            <?php


                            if ($fine->status == 1) { ?>
                                <table class="ta ble">
                                    <tr>

                                        <th>STAN No</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Add</th>
                                    </tr>
                                    <?php



                                    if ($fine->total_payment != $fine->fine_amount) { ?>
                                        <tr>

                                            <td><input style="width: 100px;" type="number" value="" name="stan_no" id="stan_no_<?php echo $fine->fine_id ?>" /> </td>
                                            <td><input style="width: 130px;" type="date" value="" name="challan_date" id="challan_date_<?php echo $fine->fine_id ?>" /> </td>
                                            <td><input min="0" onkeyup="inWords2(<?php echo $fine->fine_id ?>)" max="<?php echo $fine->fine_amount; ?>" style="width: 100px;" type="number" value="" name="deposit_amount" id="deposit_amount_<?php echo $fine->fine_id ?>" />


                                            </td>
                                            <td><button onclick="add_payment(<?php echo $fine->fine_id ?>)" class="btn btn-success btn-sm">Add</button> </td>
                                        </tr>
                                        <tr id="inword_div_<?php echo $fine->fine_id; ?>" style="display:none">
                                            <td colspan="4" style="text-align: right;">
                                                <small style="color: red;"> In Words: </small> <small style="color: green;" id="inword_<?php echo $fine->fine_id ?>"></small>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                    $query = "SELECT * FROM fine_payments WHERE fine_id = '" . $fine->fine_id . "'";
                                    $fine_payments = $this->db->query($query)->result();
                                    // $fine_payments = array();
                                    foreach ($fine_payments as $fine_payment) { ?>
                                        <tr <?php if ($fine_payment->is_deleted == 1) { ?> style="  background-color: #bcbcbc; text-decoration: line-through; " <?php } ?>>
                                            <td><?php echo $fine_payment->stan_no ?></td>
                                            <td><?php echo $fine_payment->challan_date ?></td>
                                            <td><?php echo $fine_payment->deposit_amount ?></td>
                                            <td>
                                                <?php if ($fine_payment->is_deleted != 1) { ?>
                                                    <button class="btn btn-link" style="padding: 0px; margin: 0px;" onclick="delete_payment('<?php echo $fine->fine_id ?>','<?php echo $fine_payment->fine_payment_id;  ?>')" aria-hidden="true">×</button>
                                                <?php } else ?>
                                            </td>
                                        </tr>
                                    <?php     }
                                    ?>
                                    <tr>
                                        <th colspan="4" style="text-align: right;">
                                            <small>
                                                Total Fine: Rs. <?php echo $fine->fine_amount ?> <br />
                                                Fine Paid: Rs. <?php echo $fine->total_payment ?><br />
                                                Fine Remain: Rs. <?php echo $fine->fine_amount - $fine->total_payment ?>
                                            </small>
                                        </th>
                                    </tr>
                                </table>
                            <?php  } else { ?>
                                <div class="alert alert-warning">
                                    <strong> <span class="fa fa-hand-stop-o"></span> Fine Waived Off Detail</strong>
                                    <table class="table">
                                        <tr>
                                            <td>
                                                Fine No: <?php echo @$fine->waived_off_file_no; ?>
                                            </td>
                                            <td>
                                                Waived Amount: <?php echo @$fine->waived_off_amount; ?>
                                            </td>
                                            <td>
                                                Waived Amount: <?php echo @date("d M, Y", strtotime($fine->waived_off_date)); ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <br />
                                    <p><?php echo $fine->wo_detail; ?></p>
                                    <div style="text-align: right;">
                                        <button onclick="remove_wavid_off('<?php echo $fine->fine_id ?>')" class="btn btn-danger btn-sm">Remove Waived Off</button>
                                    </div>
                                </div>
                            <?php  } ?>
                        </div>

                        <div class="clearfix"></div>

                    <?php } else { ?>
                        <table class="table">
                            <tr>

                                <td>File No</td>
                                <td>Date</td>
                                <td>Fine Amount</td>
                                <td>Fine Detail</td>
                                <td> Status </td>
                                <td></td>
                            </tr>
                            <tr>

                                <td><?php echo $fine->file_number ?></td>
                                <td><?php echo date("d m, Y", strtotime($fine->file_date)) ?></td>
                                <td><?php echo $fine->fine_amount ?></td>
                                <td><small><?php echo $fine->fine_title ?> / <?php echo $fine->fine_channel_title ?></small>
                                    <p> <strong> <?php echo $fine->remarks ?> </strong></p>
                                </td>
                                <td>
                                    <span class="label label-danger label-sm ">Deleted</span>
                                </td>
                                <td><button onclick="restore_fine('<?php echo $fine->fine_id ?>')" class="btn btn-danger btn-sm">Restore</button>
                                </td>
                            </tr>

                        </table>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
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
                    url: "<?php echo site_url(ADMIN_DIR . 'fine_management/add_fine_payment'); ?>",
                    data: {

                        fine_id: fine_id,
                        stan_no: stan_no,
                        challan_date: challan_date,
                        deposit_amount: deposit_amount
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        get_add_fine_payment_form(<?php echo $fined_school_id; ?>);
                        fined_school_list();
                        fined_summary();
                    }
                });
        } else {
            return false;
        }
    }


    function delete_fine(fine_id) {
        if (confirm("Are you sure you want to delete ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url(ADMIN_DIR . 'fine_management/delete_fine'); ?>",
                    data: {
                        fine_id: fine_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        get_add_fine_payment_form(<?php echo $fined_school_id; ?>);
                        fined_school_list();
                        fined_summary();
                    }
                });
        } else {
            return false;
        }
    }

    function restore_fine(fine_id) {
        if (confirm("Are you sure you want to retore ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url(ADMIN_DIR . 'fine_management/retore_fine'); ?>",
                    data: {
                        fine_id: fine_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        get_add_fine_payment_form(<?php echo $fined_school_id; ?>);
                        fined_school_list();
                        fined_summary();
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
                    url: "<?php echo site_url(ADMIN_DIR . 'fine_management/delete_fine_payment'); ?>",
                    data: {
                        fine_id: fine_id,
                        fine_payment_id: fine_payment_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        get_add_fine_payment_form(<?php echo $fined_school_id; ?>);
                        fined_school_list();
                        fined_summary();
                    }

                });
        } else {
            return false;
        }
    }

    function waive_off_fine(fine_id) {

        var waived_off_file_no = $('#waived_off_file_no_' + fine_id).val();

        if (waived_off_file_no == '') {
            alert("File / Notification No. Required");
            return false;
        }

        var waived_off_amount = $('#waived_off_amount_' + fine_id).val();

        if (waived_off_amount == '') {
            alert("Waived off Amount Required");
            return false;
        }

        var max = parseInt($('#waived_off_amount_' + fine_id).attr('max'));
        if (waived_off_amount > max) {
            alert("Waived amount must be less than or equal fined amount.");
            return false;
        }

        var waived_off_date = $('#waived_off_date_' + fine_id).val();

        if (waived_off_date == '') {
            alert("Waived Date Required");
            return false;
        }



        wo_detail = $('#wo_' + fine_id).val();
        if (wo_detail == '') {
            alert("Wavie Off Detail Required");
            return false;
        } else {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url(ADMIN_DIR . 'fine_management/waive_off_fine'); ?>",
                    data: {
                        fine_id: fine_id,
                        wo_detail: wo_detail,
                        waived_off_file_no: waived_off_file_no,
                        waived_off_amount: waived_off_amount,
                        waived_off_date: waived_off_date
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        get_add_fine_payment_form(<?php echo $fined_school_id; ?>);
                        fined_school_list();
                        fined_summary();
                    }

                });

        }
    }

    function remove_wavid_off(fine_id) {

        if (confirm("Are you sure to remove ?")) {

            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url(ADMIN_DIR . 'fine_management/remove_waive_off'); ?>",
                    data: {
                        fine_id: fine_id,
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        get_add_fine_payment_form(<?php echo $fined_school_id; ?>);
                        fined_school_list();
                        fined_summary();
                    }

                });
        }

    }
</script>