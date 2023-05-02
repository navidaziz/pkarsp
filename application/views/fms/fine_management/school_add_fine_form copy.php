<div class="modal-body">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Fine</h4>
    </div>

    <form class="class=”form-horizontal”">
        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px; background-color: white;">
            <h4>School Detail</h4>
            <div class="row">
                <div class="col-md-12">
                    <label class="control-label" for="School_id">School Id</label>
                    <input type="number" value="" name="school_id" placeholder="School Id" class="form-control" id="school_id" />

                </div>
                <div class="col-md-4">
                    <label class="control-label" for="School_id">School Registration No</label>
                    <input type="number" value="" name="school_registration_no" placeholder="School Registration No" class="form-control" id="school_registration_no" />

                </div>
                <div class="col-md-12">
                    <label class="control-label" for="School_id">School Name</label>
                    <input required type="text" value="" name="school_name" placeholder="School Name" class="form-control" id="school_name" />

                </div>
                <div class="col-md-12">
                    <label class="control-label" for="School_id">District Name</label>
                    <input required type="text" value="" name="district_name" placeholder="District Name" class="form-control" id="district_name" />

                </div>
                <div class="col-md-12">
                    <label class="control-label" for="School_id">Tehsil Name</label>
                    <input required type="text" value="" name="tehsil_name" placeholder="Teshil Name" class="form-control" id="tehsil_name" />

                </div>

                <div class="col-md-12">
                    <label class="control-label" for="School_id">Address</label>
                    <input required type="text" value="" name="address" placeholder="Address" class="form-control" id="address" />

                </div>

                <div class="col-md-12">
                    <label class="control-label" for="School_id">Letter / File Number</label>
                    <input required type="text" value="" name="file_number" placeholder="Address" class="form-control" id="file_number" />

                </div>
                <h4>Fine Detail</h4>
                <div class="col-md-3">
                    <label class="control-label" for="File No.">Letter / File Number</label>
                    <input type="text" value="" name="file_number" placeholder="" class="form-control" id="file_number" />

                </div>
                <div class="col-md-3">
                    <label class="control-label" for="gender">Fine Category:</label>
                    <select class="form-control select2" id="fine_category" name="fine_category" style="width: 100%;">

                        <option value="">Select Fine Category</option>
                        <option value="1">Salary issue</option>
                        <option value="2">Fee related issue</option>
                        <option value="3">Observance of holidays, closure and opening etc. of schools</option>
                        <option value="4">Non observance of SOPs/hygiene etc</option>
                        <option value="5">Corporal Punishment / Mishandling</option>
                        <option value="6">Teacher Appointment/Termination</option>
                        <option value="7">SLC related Issues</option>
                        <option value="8">Gen/Misc</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="control-label" for="numberOfClassroom">Amount:</label>
                    <input onkeyup="inWords()" type="number" value="" name="amount" placeholder="Example 2000 etc." class="form-control" id="amount" />

                </div>




                <div class="col-md-3">
                    <label class="control-label" for="File Date">Date</label>
                    <input type="date" value="" name="file_date" placeholder="" class="form-control" id="file_date" />

                </div>

                <div class="col-md-12">
                    <div style="text-transform: capitalize; font-weight: bold;  margin:1px; padding:1px; text-align:right" id="number_to_words"></div>
                </div>
                <div class="col-md-12">
                    <label class="control-label" for="numberOfClassroom">Remarks:</label>
                    <textarea class="form-control" placeholder="Remarks about fine" cols="50" rows="5" name="remarks" id="remarks"></textarea>
                </div>

                <div class="col-sm-12" style="text-align: center;">

                    Account Password: <input type="password" name="password" id="password" class="form-control" style="width: 150px;" />
                    <button class="btn btn-danger" onclick="add_new_fine()">Add New Fine</button>
                </div>
            </div>

        </div>

    </form>
</div>
<script>
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

    function add_new_fine() {
        fine_category = $('#fine_category').val();
        if (fine_category == '') {
            alert("Fine Category Required");
            return false;
        }

        var amount = $('#amount').val();
        if (amount == '') {
            alert("Amount Required");
            return false;
        }

        var remarks = $('#remarks').val();
        if (remarks == '') {
            alert("Fine Detail Remarks Required");
            return false;
        }

        var password = $('#password').val();
        if (password == '') {
            alert("Account Password Required.");
            return false;
        }

        var file_number = $('#file_number').val();
        if (file_number == '') {
            alert("File Number Required.");
            return false;
        }

        var file_date = $('#file_date').val();
        if (file_date == '') {
            alert("File Date Required.");
            return false;
        }





        $.ajax({
                method: "POST",
                url: "<?php echo site_url('fines/add_fine'); ?>",
                data: {
                    schools_id: <?php echo $schools_id; ?>,
                    fine_category: fine_category,
                    amount: amount,
                    remarks: remarks,
                    password: password,
                    file_number: file_number,
                    file_date: file_date
                },
            })
            .done(function(respose) {
                if (respose == 0) {
                    alert("Error Try Again");

                } else {
                    $.ajax({
                            method: "POST",
                            url: "<?php echo site_url('fines/view_school_detail'); ?>",
                            data: {
                                schools_id: <?php echo $schools_id; ?>,
                            },
                        })
                        .done(function(respose) {
                            $('#view_school_detail_body').html(respose);
                        });
                }

            });



    }

    function add_payment(history_id) {


        var stan_no = $('#stan_no_' + history_id).val();
        if (stan_no == '') {
            alert("STAN Required.");
            return false;
        }
        var deposit_date = $('#deposit_date_' + history_id).val();
        if (deposit_date == '') {
            alert("Deposit Date Required.");
            return false;
        }
        var deposit_amount = $('#deposit_amount_' + history_id).val();
        if (deposit_amount == '') {
            alert("Deposit Amount Required.");
            return false;
        }

        var max = parseInt($('#deposit_amount_' + history_id).attr('max'));
        if (deposit_amount > max) {
            alert("paid amount must be less than or equal fined amount.");
            return false;
        }


        if (confirm("Are you sure you want to Add Payment ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fines/add_fine_payment'); ?>",
                    data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: history_id,
                        stan_no: stan_no,
                        deposit_date: deposit_date,
                        deposit_amount: deposit_amount
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {
                        $.ajax({
                                method: "POST",
                                url: "<?php echo site_url('fines/view_school_detail'); ?>",
                                data: {
                                    schools_id: <?php echo $schools_id; ?>,
                                },
                            })
                            .done(function(respose) {
                                $('#view_school_detail_body').html(respose);
                            });
                    }
                });
        } else {
            return false;
        }
    }


    function delete_fine(history_id) {
        if (confirm("Are you sure you want to delete ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fines/delete_fine'); ?>",
                    data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: history_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {
                        $.ajax({
                                method: "POST",
                                url: "<?php echo site_url('fines/view_school_detail'); ?>",
                                data: {
                                    schools_id: <?php echo $schools_id; ?>,
                                },
                            })
                            .done(function(respose) {
                                $('#view_school_detail_body').html(respose);
                            });
                    }
                });
        } else {
            return false;
        }
    }

    function delete_payment(history_id, fine_payment_id) {

        if (confirm("Are you sure you want to delete ?")) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fines/delete_fine_payment'); ?>",
                    data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: history_id,
                        fine_payment_id: fine_payment_id
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {
                        $.ajax({
                                method: "POST",
                                url: "<?php echo site_url('fines/view_school_detail'); ?>",
                                data: {
                                    schools_id: <?php echo $schools_id; ?>,
                                },
                            })
                            .done(function(respose) {
                                $('#view_school_detail_body').html(respose);
                            });
                    }
                });
        } else {
            return false;
        }
    }

    function waive_off_fine(fine_id) {
        wo_detail = $('#wo_' + fine_id).val();
        if (wo_detail == '') {
            alert("Wavie Off Detail Required");
            return false;
        } else {
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fines/waive_off_fine'); ?>",
                    data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: fine_id,
                        wo_detail: wo_detail
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {
                        $.ajax({
                                method: "POST",
                                url: "<?php echo site_url('fines/view_school_detail'); ?>",
                                data: {
                                    schools_id: <?php echo $schools_id; ?>,
                                },
                            })
                            .done(function(respose) {
                                $('#view_school_detail_body').html(respose);
                            });
                    }

                });

        }
    }

    function remove_wavid_off(fine_id) {

        if (confirm("Are you sure to remove ?")) {

            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('fines/remove_waive_off'); ?>",
                    data: {
                        schools_id: <?php echo $schools_id; ?>,
                        history_id: fine_id,
                    },
                })
                .done(function(respose) {
                    if (respose == 0) {
                        alert("Error Try Again");

                    } else {
                        $.ajax({
                                method: "POST",
                                url: "<?php echo site_url('fines/view_school_detail'); ?>",
                                data: {
                                    schools_id: <?php echo $schools_id; ?>,
                                },
                            })
                            .done(function(respose) {
                                $('#view_school_detail_body').html(respose);
                            });
                    }

                });
        }

    }
</script>