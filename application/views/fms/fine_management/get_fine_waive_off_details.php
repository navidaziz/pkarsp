<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Fine Waive Off Detail</h5>
        <button onclick="location.reload();" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <div class="col-md-12">
                <div>
                    <form onsubmit="return false;" id="form_<?php echo $fine->fine_id ?>">
                        <input type="hidden" id="fine_id" name="fine_id" value="<?php echo $fine->fine_id ?>" />

                        <div id="waive_off_form_<?php echo $fine->fine_id ?>">
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
                    <?php $query = "SELECT * FROM `fine_waived_off` 
                    WHERE fine_id = '" . $fine->fine_id . "' and is_deleted = 0";
                    $fine_waived_offs = $this->db->query($query)->result();
                    if ($fine_waived_offs) { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="9">Fine waived off detail</th>
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
                                        <td><?php echo $fine_waived_off->wo_detail; ?></td>
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
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button onclick="location.reload();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
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
                        get_fine_waive_off_details(fine_id)
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
                    console.log(response);
                    //convert json response to object
                    var obj = JSON.parse(response);


                    if (obj.error == true) {
                        $('#waive_off_error_' + fine_id).html(obj.msg);
                    } else {
                        get_fine_waive_off_details(fine_id)

                    }


                });

        }
    }
</script>