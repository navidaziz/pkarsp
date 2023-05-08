<style>
    btn {
        margin: 2px !important;
        padding: 2px !important;
    }

    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-dark {
        color: #fff;
        background-color: #343a40;
        border-color: #343a40;
    }
</style>
<div class="modal" id="fine_model" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 70%;" id="fine_modal_body">

    </div>
</div>
<script>
    function get_fine_waive_off_details(fine_id) {
        $('#fine_modal_body').html('Please wait......');
        $('#fine_model').modal('show');
        $.ajax({
                method: "POST",
                url: "<?php echo site_url('fms/fine_management/get_fine_waive_off_details'); ?>",
                data: {
                    school_id: <?php echo $school->school_id; ?>,
                    fine_id: fine_id
                },
            })
            .done(function(respose) {
                $('#fine_modal_body').html(respose);
            });
    }

    function get_fine_payment_details(fine_id) {
        $('#fine_modal_body').html('Please wait......');
        $('#fine_model').modal('show');
        $.ajax({
                method: "POST",
                url: "<?php echo site_url('fms/fine_management/get_fine_payment_details'); ?>",
                data: {
                    school_id: <?php echo $school->school_id; ?>,
                    fine_id: fine_id
                },
            })
            .done(function(respose) {
                $('#fine_modal_body').html(respose);
            });
    }

    function get_fine_add_form() {
        $('#fine_modal_body').html('Please wait......');
        $('#fine_model').modal('show');
        $.ajax({
                method: "POST",
                url: "<?php echo site_url('fms/fine_management/get_fine_add_form'); ?>",
                data: {
                    school_id: <?php echo $school->school_id; ?>,
                },
            })
            .done(function(respose) {
                $('#fine_modal_body').html(respose);
            });

    }
</script>


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
                                <td><?php echo @number_format($fine_summary->fine_amount, 2); ?></td>
                                <td><?php echo @number_format($fine_summary->total_waived_off, 2); ?></td>
                                <td><?php echo @number_format($fine_summary->fine_amount - $fine_summary->total_waived_off, 2); ?></td>
                                <td><?php echo @number_format($fine_summary->total_fine_paid, 2); ?></td>
                                <td><?php echo @number_format(($fine_summary->fine_amount - $fine_summary->total_waived_off) - $fine_summary->total_fine_paid, 2); ?></td>
                                <td><button onclick="get_fine_add_form()" class="btn btn-danger btn-sm">Add New Fine</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px; margin:5px;  padding: 5px; background-color: white;">

                    <table class="table" style="font-size: 12px;">
                        <tr>
                            <th></th>
                            <th>Fine ID</th>
                            <th>File No</th>
                            <th>Letter No</th>
                            <th>Date</th>
                            <th>Detail</th>
                            <th><i class="fa fa-file-pdf-o" aria-hidden="true"></i></th>
                            <th>Total Fine</th>
                            <th>Total Waived Off</th>
                            <th>Total Fine Payable</th>
                            <th>Total Fine Paid</th>
                            <th>Total Fine Remaining</th>
                            <th> Status </th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        $count = 1;
                        foreach ($fines as $fine) {
                            //$total_paid = ($fine->fine_amount - $fine_summary->total_waived_off) - $fine_summary->total_fine_paid;
                        ?>

                            <tr <?php if ($fine->is_deleted == 1) { ?> style="color:#b2aeae !important; background:#e1e4e5;" <?php } ?>>
                                <td>
                                    <?php if ($fine->is_deleted == 0 and $fine->total_waived_off == 0 and $fine->total_fine_paid == 0) { ?>
                                        <button class="btn btn-danger btn-sm" onclick="delete_fine(<?php echo $fine->fine_id ?>)" aria-hidden="true"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    <?php } ?>
                                    <?php if ($fine->is_deleted == 1) { ?>
                                        <button class="btn btn-dark btn-sm" onclick="restore_fine('<?php echo $fine->fine_id ?>')" class="btn btn-danger btn-sm"><i class="fa fa-undo" aria-hidden="true"></i></button>
                                    <?php } ?>
                                </td>
                                <td><strong><?php echo $fine->fine_id ?></strong></td>
                                <td><?php echo $fine->file_number ?></td>
                                <td><?php echo $fine->letter_no; ?></td>
                                <td><?php echo date("d M, Y", strtotime($fine->file_date)) ?></td>
                                <td>
                                    <span class="pull-left"><?php echo $fine->fine_title ?> / <?php echo $fine->fine_channel_title ?></span>
                                    <br />
                                    <p> <strong> <?php echo $fine->remarks ?> </strong></p>
                                </td>
                                <td>
                                    <a style="font-size: 14px !important;" target="new" href="<?php echo $fine->fine_file; ?>">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td><?php echo @number_format($fine->fine_amount, 2); ?></td>
                                <td><?php echo @number_format($fine->total_waived_off, 2); ?></td>
                                <td><?php echo @number_format($fine->fine_amount - $fine->total_waived_off, 2); ?></td>
                                <td><?php echo @number_format($fine->total_fine_paid, 2); ?></td>
                                <td><?php echo @number_format(($fine->fine_amount - $fine->total_waived_off) - $fine->total_fine_paid, 2); ?></td>

                                <td>
                                    <?php if ($fine->status == 1 and $fine->is_deleted == 0) { ?>
                                        <span class="label label-danger label-sm ">Not Paid</span>
                                    <?php  } ?>
                                    <?php if ($fine->status == 2 and $fine->is_deleted == 0) { ?>
                                        <span class="label label-success label-sm ">Paid</span>
                                    <?php } ?>
                                </td>


                                <td style="width:160px">
                                    <small>
                                        <?php if ($fine->is_deleted == 0) { ?>
                                            <button class="btn btn-danger btn-sm" onclick="get_fine_waive_off_details(<?php echo $fine->fine_id; ?>)">Waive Off</button>
                                            <button class="btn btn-primary btn-sm" onclick="get_fine_payment_details(<?php echo $fine->fine_id; ?>)">Payment</button>

                                        <?php } ?>
                                        <?php if ($fine->is_deleted == 1) {
                                            echo 'Removed';
                                        } ?>
                                    </small>
                                </td>
                            </tr>


                        <?php } ?>
                        <tr>
                            <th colspan="7" style="text-align: right;">Total</th>
                            <th><?php echo @number_format($fine_summary->fine_amount, 2); ?></th>
                            <th><?php echo @number_format($fine_summary->total_waived_off, 2); ?></th>
                            <th><?php echo @number_format($fine_summary->fine_amount - $fine_summary->total_waived_off, 2); ?></th>
                            <th><?php echo @number_format($fine_summary->total_fine_paid, 2); ?></th>
                            <th><?php echo @number_format(($fine_summary->fine_amount - $fine_summary->total_waived_off) - $fine_summary->total_fine_paid, 2); ?></th>
                            <th colspan="2"></th>
                        </tr>

                    </table>

                </div>



            </div>
        </div>
    </section>
</div>





<script>
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



    // function remove_wavid_off(fine_id) {

    //     if (confirm("Are you sure to remove ?")) {

    //         $.ajax({
    //                 method: "POST",
    //                 url: "<?php echo site_url('fms/fine_management/remove_waive_off'); ?>",
    //                 data: {
    //                     fine_id: fine_id,
    //                 },
    //             })
    //             .done(function(respose) {
    //                 if (respose == 0) {
    //                     alert("Error Try Again");

    //                 } else {

    //                     location.reload();
    //                     fined_school_list();
    //                     fined_summary();
    //                 }

    //             });
    //     }

    // }


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