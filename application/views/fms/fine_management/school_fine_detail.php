<div class="content-wrapper">
    <section class="content-header">
        <div class="row">

            <div class="col-md-6">
                <div class="clearfix">
                    <h4><?php echo $school->school_name; ?></h4>

                    <h5> School ID: <?php echo $school->school_id; ?>
                        <span style="margin-left: 10px;">
                            REG: <?php echo $school->reg_number; ?>
                        </span>

                        <span style="margin-left: 10px;">
                            (<?php echo $school->level; ?>)
                        </span>
                    </h5>

                </div>
                <div class="description">District: <?php echo $school->district_name; ?> /
                    Tehsil: <?php echo $school->tehsil_name; ?> /
                    UC: <?php echo $school->uc; ?> /
                    Address: <?php echo $school->address; ?> /
                    Contact: <?php echo $school->contact_number; ?>
                </div>
            </div>

            <div class="col-md-6" style="font-size: 10px;">
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
                        <li><a href="<?php echo site_url("fms/fine_management"); ?>"> Fine Dashboard </a></li>
                        <li class="active"><?php echo @ucfirst($title); ?></li>
                    </ol>
                    <table class="table table-bordered table-striped" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>Total Fine</th>

                                <th>Total Waived Off</th>
                                <th>Total Fine Payable</th>
                                <th>Total Fine Paid</th>
                                <th>Total Fine Remaining</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo @number_format($fine_summary->original_fine_amount, 2); ?></td>
                                <td><?php echo @number_format($fine_summary->total_waived_off, 2); ?></td>
                                <td><?php echo @number_format($fine_summary->original_fine_amount - $fine_summary->total_waived_off, 2); ?></td>
                                <td><?php echo @number_format($fine_summary->total_fine_paid, 2); ?></td>
                                <td><?php echo @number_format(($fine_summary->original_fine_amount - $fine_summary->total_waived_off) - $fine_summary->total_fine_paid, 2); ?></td>
                                <td><button onclick="$('#add_new_fine_form').toggle()" class="btn btn-danger btn-sm">Add New Fine</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h4><i class="fa fa-list"></i>Fine Detail</h4>
            </div>

            <div class="box-body">


                <div class="row">
                    <div class="col-md-12" id="add_new_fine_form" style="display: n one;">
                        <form class="for m-inline" action="<?php echo site_url("fms/fine_management/add_fine"); ?>" id="add_fine" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="school_id" value="<?php echo $school_id ?>" />
                            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px; background-color: white; padding:10px">
                                <h4>Fine Detail</h4>
                                <div class="row">
                                    <div class="col-md-5">

                                        <table class="table">


                                            <tr>
                                                <td style="width: 450px;">File Number</td>
                                                <td><input required type="text" value="<?php echo set_value("file_number"); ?>" name="file_number" placeholder="File Number" id="file_number" />
                                                    <?php echo form_error("file_number", "<p class=\"text-danger\">", "</p>"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Letter Number</td>
                                                <td><input required type="text" value="<?php echo set_value("letter_no"); ?>" name="letter_no" placeholder="Letter Number" id="letter_name" />
                                                    <?php echo form_error("file_number", "<p class=\"text-danger\">", "</p>"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    letter Date
                                                </td>
                                                <td>
                                                    <input required type="date" value="<?php echo set_value("file_date"); ?>" name="file_date" placeholder="" id="file_date" />
                                                    <?php echo form_error("file_date", "<p class=\"text-danger\">", "</p>"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Fine Types
                                                </td>
                                                <td>
                                                    <select required class="select2" id="fine_type_id" name="fine_type_id" style="width: 100%;">
                                                        <option value="">Select Fine Type</option>
                                                        <?php
                                                        $query = "SELECT * FROM `fine_types`";
                                                        $fine_types = $this->db->query($query)->result();
                                                        foreach ($fine_types as $fine_type) { ?>
                                                            <option <?php if ($fine_type->fine_type_id == set_value("fine_type_id")) { ?> selected <?php } ?> value="<?php echo $fine_type->fine_type_id; ?>"><?php echo $fine_type->fine_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error("fine_type_id", "<p class=\"text-danger\">", "</p>"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Channel</td>
                                                <td><?php
                                                    $query = "SELECT * FROM `fine_channels`";
                                                    $fine_channels = $this->db->query($query)->result();
                                                    foreach ($fine_channels as $fine_channel) { ?>
                                                        <input <?php if ($fine_channel->fine_channel_id == set_value("fine_channel_id")) { ?> checked <?php } ?> required type="radio" name="fine_channel_id" id="fine_channel_id" value="<?php echo $fine_channel->fine_channel_id; ?>" />
                                                        <?php echo $fine_channel->fine_channel_title; ?> <br />
                                                    <?php } ?>

                                                    <?php echo form_error("fine_channel_id", "<p class=\"text-danger\">", "</p>"); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Amount </td>
                                                <td>
                                                    <input required onkeyup="inWords()" type="number" value="<?php echo set_value("fine_amount"); ?>" name="fine_amount" placeholder="Example 2000 etc." id="amount" />
                                                    <?php echo form_error("fine_amount", "<p class=\"text-danger\">", "</p>"); ?>

                                                </td>
                                            </tr>


                                        </table>
                                        <div style="text-transform: capitalize;  text-align:left">

                                            <small style="color: red;"> In Words: </small> <small style="color: green;" id="number_to_words"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-7">

                                        <label class="control-label" for="numberOfClassroom">Fine Detail</label>
                                        <br />
                                        <textarea required placeholder="Fine Detail" cols="" rows="11" name="remarks" style="width: 100%;" id="remarks"><?php echo set_value("remarks"); ?></textarea>
                                        <?php echo form_error("remarks", "<p class=\"text-danger\">", "</p>"); ?>
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    Fine File: <input type="file" name="fine_file" id="fine_file" style="display: inline;" />
                                                    <?php echo form_error("fine_file", "<p class=\"text-danger\">", "</p>"); ?>

                                                </td>
                                                <td>
                                                    <input class="btn btn-success btn-sm" style="margin-top: 10px;" type="submit" value="Add Fine" name="Add Fine">

                                                </td>
                                            </tr>
                                        </table>


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $count = 1;

                    foreach ($fines as $fine) {
                        $total_paid = $fine->fine_amount - $fine->total_payment;
                    ?>
                        <div class="row">


                            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px; margin:5px;  padding: 5px; background-color: white;">
                                <?php if ($fine->status != 0) { ?>

                                    <div class="col-md-7">
                                        <div style="background-color: #f0f0f0; border-radius:10px; padding:10px;">
                                            <table class="table" style="font-size: 10px;">
                                                <tr>
                                                    <td>Fine ID</td>
                                                    <td>File No</td>
                                                    <td>Letter No</td>
                                                    <td>Date</td>
                                                    <td>Fine Amount</td>
                                                    <td>Waived Off</td>
                                                    <td>Fine Payable</td>
                                                    <td> Status </td>
                                                    <th><i class="fa fa-file-pdf-o" aria-hidden="true"></i></th>
                                                </tr>
                                                <tr>
                                                    <td><strong><?php echo $fine->fine_id ?></strong></td>
                                                    <td><?php echo $fine->file_number ?></td>
                                                    <td><?php echo $fine->letter_no; ?></td>
                                                    <td><?php echo date("d M, Y", strtotime($fine->file_date)) ?></td>
                                                    <td><?php echo number_format($fine->original_fine_amount, 2) ?></td>
                                                    <td><?php echo number_format($fine->waived_off_amount, 2) ?></td>
                                                    <td><?php echo number_format($fine->fine_amount, 2) ?></td>
                                                    <td>
                                                        <?php
                                                        if ($fine->status == 1 and $total_paid != 0) { ?>
                                                            <span class="label label-danger label-sm ">Not Paid</span>

                                                        <?php } else { ?>
                                                            <?php if ($fine->status == 3) { ?>
                                                                <span class="label label-warning label-sm ">Waived Off</span>
                                                            <?php  } else { ?>
                                                                <span class="label label-success label-sm ">Paid</span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a style="font-size: 14px !important;" target="new" href="<?php echo site_url($fine->fine_file); ?>">
                                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td colspan="9">
                                                        <p> <strong> <?php echo $fine->remarks ?> </strong></p>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9">
                                                        <span class="pull-left"><?php echo $fine->fine_title ?> / <?php echo $fine->fine_channel_title ?></span>
                                                        <small class="pull-right">
                                                            <?php if ($fine->status == 1 and $fine->total_payment <= 0) { ?>
                                                                <button class="btn btn-danger" style="padding: 1px; margin: 0px; font-size: 9px;" onclick="delete_fine(<?php echo $fine->fine_id ?>)" aria-hidden="true"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                                            <?php } ?>

                                                            <?php if ($fine->status == 1 and $fine->total_payment < $fine->fine_amount) { ?>
                                                                <button onclick="$('#waive_off_form_<?php echo $fine->fine_id ?>').toggle()" class="btn btn-warning btn-sm" style="padding: 1px; margin: 0px; font-size: 9px;"> <span class="fa fa-hand-stop-o"></span> Waive Off</button>
                                                            <?php } ?>
                                                        </small>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div>
                                                <?php $query = "SELECT * FROM `fine_waived_off` where fine_id = '$fine->fine_id'";
                                                $fine_waived_offs = $this->db->query($query)->result();
                                                if ($fine_waived_offs) { ?>
                                                    <table class="table" style="font-size: 9px;">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="7">Fine waived off detail</th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th>#</th>
                                                                <th>Notification</th>
                                                                <th>Notification</th>
                                                                <th>Fine Amount</th>
                                                                <th>Waived Off Amount</th>
                                                                <th>Total Fine Remaining</th>
                                                                <th>Detail</th>
                                                                <th><i class="fa fa-file-pdf-o" aria-hidden="true"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $count = 1;
                                                            foreach ($fine_waived_offs as $fine_waived_off) { ?>

                                                                <tr <?php if ($fine_waived_off->is_deleted == 1) { ?> style="  background-color: #bcbcbc; text-decoration: line-through; " <?php } ?>>
                                                                    <td>
                                                                        <?php if ($fine_waived_off->is_deleted != 1) { ?>
                                                                            <button class="btn btn-link" style="padding: 0px; margin: 0px;" onclick="delete_waived_off('<?php echo $fine->fine_id ?>','<?php echo $fine_waived_off->fine_waived_off_id;  ?>')" aria-hidden="true"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                        <?php } else ?>
                                                                    </td>
                                                                    <td><?php echo $count++; ?></td>
                                                                    <td><?php echo $fine_waived_off->waived_off_file_no; ?></td>
                                                                    <td><?php echo date("d M, Y", strtotime($fine_waived_off->waived_off_date)); ?></td>
                                                                    <td><?php echo $fine_waived_off->fine_amount; ?></td>
                                                                    <td><?php echo $fine_waived_off->waived_off_amount; ?></td>
                                                                    <td><?php echo $fine_waived_off->fine_remained; ?></td>
                                                                    <td>
                                                                        <i class="fa fa-info-circle" style="font-size: 13px;" aria-hidden="true"></i>
                                                                        <?php //echo $fine_waived_off->wo_detail; 
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <a style="font-size: 14px !important;" target="new" href="<?php echo site_url($fine_waived_off->waived_off_file); ?>">
                                                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                                        </a>

                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>

                                            </div>

                                            <div class="clearfix"></div>
                                            <?php if ($fine->status == 1 and $total_paid != 0) { ?>
                                                <form onsubmit="return false;" id="form_<?php echo $fine->fine_id ?>">
                                                    <input type="hidden" id="fine_id" name="fine_id" value="<?php echo $fine->fine_id ?>" />

                                                    <div id="waive_off_form_<?php echo $fine->fine_id ?>" style="display: none; padding:10px">
                                                        <h5>Add Waive Off Details</h5>
                                                        <table class="table">
                                                            <tr>
                                                                <td>Waived of Notification No: <br /><input style="width: 100%;" type="text" id="waived_off_file_no_<?php echo $fine->fine_id ?>" name="waived_off_file_no" value="" /></td>
                                                                <td>Notification date: <br /><input style="width: 100%;" type="date" id="waived_off_date_<?php echo $fine->fine_id ?>" name="waived_off_date" value="" /></td>
                                                                <td>Waived off amount: <br /><input onkeyup="inWords3(<?php echo $fine->fine_id ?>)" style="width: 100%;" min="1" max="<?php echo $fine->fine_amount ?>" type="number" id="waived_off_amount_<?php echo $fine->fine_id ?>" name="waived_off_amount" value="" />
                                                                    <div style="text-transform: capitalize;  text-align:left">

                                                                        <small style="color: red;"> In Words: </small> <small style="color: green;" id="number_to_words_waived_<?php echo $fine->fine_id ?>"></small>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <strong>Wavie off detail</strong>
                                                                    <br />
                                                                    <textarea style="width: 100%; padding:5px" name="wo_detail" id="wo_<?php echo $fine->fine_id ?>"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="text-align: center;">
                                                                    <span>
                                                                        Waived Notification File: <input style="display: inline;" type="file" name="waived_off_file" id="waived_off_file_<?php echo $fine->fine_id ?>" />
                                                                    </span>
                                                                    <button onclick="waive_off_fine('<?php echo $fine->fine_id ?>');" class="btn btn-warning"><span class="fa fa-hand-stop-o"></span> Waive Off </button>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div id="waive_off_error_<?php echo $fine->fine_id ?>"></div>

                                                    </div>
                                                </form>
                                            <?php } ?>


                                        </div>
                                    </div>

                                    <div class="col-md-5">


                                        <?php if ($fine->status == 1) { ?>
                                            <?php if ($fine->total_payment != $fine->fine_amount) { ?>
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

                                                            <td><input style="width: 100px;" type="number" value="" name="stan_no" id="stan_no_<?php echo $fine->fine_id ?>" /> </td>
                                                            <td><input style="width: 100px;" type="date" value="" name="challan_date" id="challan_date_<?php echo $fine->fine_id ?>" /> </td>
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
                                                    <div id="payment_error_<?php echo $fine->fine_id; ?>"></div>

                                                </div>
                                                <br />
                                            <?php } ?>
                                            <div style="font-size:9px; background-color: #f0f0f0; border-radius:10px; padding:10px;">

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
                                                        <th style="text-align: center;"><?php echo @number_format($fine->total_payment, 2) ?></td>
                                                    </tr>

                                                    <!-- <tr>
                                    <th colspan="4" style="text-align: right;">Total Fine Payable: (Rs) </th>
                                    <th style="text-align: center;"><?php echo @number_format($fine->fine_amount, 2) ?></td>
                                </tr> -->
                                                    <tr>
                                                        <th colspan="4" style="text-align: right;">Total Fine Remaining: (Rs) </th>
                                                        <th style="text-align: center;"><?php echo @number_format($fine->fine_amount - $fine->total_payment, 2) ?> </th>
                                                    </tr>

                                                </table>
                                            </div>

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
                                                <p> <strong> <?php echo $fine->remarks ?> </strong>
                                                    <br />
                                                    <span>
                                                        <a style="font-size: 14px !important;" target="new" href="<?php echo site_url($fine->fine_file); ?>">
                                                            View / Download Attachment: <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                        </a>
                                                    </span>
                                                </p>
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
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>
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
                    var obj = JSON.parse(response);
                    console.log(obj.msg);

                    if (obj.error == true) {
                        $('#payment_error_' + fine_id).html(obj.msg);
                    } else {
                        location.reload();

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
                    url: "<?php echo site_url('fms/fine_management/delete_fine'); ?>",
                    data: {
                        fine_id: fine_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        location.reload();
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
                    url: "<?php echo site_url('fms/fine_management/retore_fine'); ?>",
                    data: {
                        fine_id: fine_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        location.reload();
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

                        location.reload();
                        fined_school_list();
                        fined_summary();
                    }

                });
        } else {
            return false;
        }
    }

    function delete_waived_off(fine_id, fine_waived_off_id) {

        if (confirm("Are you sure you want to delete ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fms/fine_management/delete_waived_off'); ?>",
                    data: {
                        fine_id: fine_id,
                        fine_waived_off_id: fine_waived_off_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        location.reload();
                        fined_school_list();
                        fined_summary();
                    }

                });
        } else {
            return false;
        }
    }


    function waive_off_fine(fine_id) {




        // var waived_off_file_no = $('#waived_off_file_no_' + fine_id).val();

        // if (waived_off_file_no == '') {
        //     alert("File / Notification No. Required");
        //     return false;
        // }

        // var waived_off_amount = $('#waived_off_amount_' + fine_id).val();

        // if (waived_off_amount == '') {
        //     alert("Waived off Amount Required");
        //     return false;
        // }

        // var max = parseInt($('#waived_off_amount_' + fine_id).attr('max'));
        // if (waived_off_amount > max) {
        //     alert("Waived amount must be less than or equal fined amount.");
        //     return false;
        // }

        // var waived_off_date = $('#waived_off_date_' + fine_id).val();

        // if (waived_off_date == '') {
        //     alert("Waived Date Required");
        //     return false;
        // }

        // if ($('#waived_off_file_' + fine_id).get(0).files.length === 0) {
        //     alert("Waive off notification file in PDF required");
        //     return false;
        // } else {
        //     var fileExtension = ['pdf'];
        //     if ($.inArray($('#waived_off_file_' + fine_id).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        //         alert("only pdf file required");
        //         return false;
        //     }
        // }



        wo_detail = $('#wo_' + fine_id).val();
        if (wo_detail == '') {
            alert("Wavie Off Detail Required");
            return false;
        } else {
            // Get form
            var form = $('#form_' + fine_id)[0];

            // FormData object 
            var data = new FormData(form);
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fms/fine_management/waive_off_fine'); ?>",
                    enctype: 'multipart/form-data',
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    data: data,

                })
                .done(function(response) {
                    //convert json response to object
                    var obj = JSON.parse(response);
                    console.log(obj.msg);

                    if (obj.error == true) {
                        $('#waive_off_error_' + fine_id).html(obj.msg);
                    } else {
                        location.reload();

                    }


                });

        }
    }

    function remove_wavid_off(fine_id) {

        if (confirm("Are you sure to remove ?")) {

            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fms/fine_management/remove_waive_off'); ?>",
                    data: {
                        fine_id: fine_id,
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {

                        location.reload();
                        fined_school_list();
                        fined_summary();
                    }

                });
        }

    }


    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];



    function inWords() {

        num = $('#amount').val();
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        $('#number_to_words').text(str)
    }

    function inWords2(fine_id) {
        $('#inword_div_' + fine_id).show();
        num = $('#deposit_amount_' + fine_id).val();

        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        $('#inword_' + fine_id).text(str);


    }

    function inWords3(fine_id) {
        $('#inword_div_' + fine_id).show();
        num = $('#waived_off_amount_' + fine_id).val();


        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        $('#number_to_words_waived_' + +fine_id).text(str);


    }
</script>