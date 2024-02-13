<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo $title ?></h5>
        <button onclick="location.reload();" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <div class="col-md-12">
                <ol>
                    <?php $query = "SELECT `activity_logs`.*, users.userTitle 
                    FROM `activity_logs` 
                    INNER JOIN users ON (users.userId = activity_logs.created_by)
                    WHERE fine_id = '" . $fine_id . "'";
                    $activity_logs = $this->db->query($query)->result();
                    if ($activity_logs) {
                        foreach ($activity_logs as $activity_log) { ?>
                            <li><?php echo $activity_log->table; ?> -
                                <?php echo $activity_log->activity; ?> (activity performed by <?php echo $activity_log->userTitle; ?>)
                                on dated: <?php echo date("d M, Y h:m:s a", strtotime($activity_log->created_date));  ?>
                            </li>
                        <?php } ?>
                    <?php } else {
                        echo "No activity logs";
                    } ?>
                </ol>
            </div>
        </div>

        <div class="modal-footer">
            <button onclick="location.reload();" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
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