<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
    <h4>
        Edit Bank Challan
    </h4>

    <table class="table table2">
        <tr>
            <th style="text-align: center; background-color:#CCFFFF !important; " colspan="2"></th>
            <th style="text-align: center; background-color:lightpink !important; " colspan="2">STAN / Date of deposit</th>
            <th style="text-align: center; background-color:lightgreen !important;" colspan="7">Fee for Registration / Renewal / Upgradation</th>
            <th style="text-align: center; background-color:gray !important;">Operation</th>
            <th style="text-align: center; background-color:lightgray !important;">Others</th>
            <th colspan="2" style="text-align: center;"> Total (Rs.)</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color:#CCFFFF !important; ">Session</th>
            <th style="text-align: center; background-color:#CCFFFF !important; ">Challan For</th>
            <th style="text-align: center; background-color:lightpink !important; ">STAN No</th>
            <th style="text-align: center; background-color:lightpink !important; ">Date</th>
            <th style="text-align: center; background-color:lightgreen !important;">App. Pro.</th>
            <th style="text-align: center; background-color:lightgreen !important;">Renewal</th>
            <th style="text-align: center; background-color:lightgreen !important;">Inspection</th>
            <th style="text-align: center; background-color:lightgreen !important;">Upgradation</th>
            <th style="text-align: center; background-color:lightgreen !important;">Late</th>
            <th style="text-align: center; background-color:lightgreen !important;">Fine</th>
            <th style="text-align: center; background-color:lightgreen !important;">Security</th>
            <th style="text-align: center; background-color:gray !important;">Penalty</th>
            <th style="text-align: center; background-color:lightgray !important;">Miscellaneous</th>
            <th style="text-align: center;">Total</th>
            <th>Action</th>
        </tr>
        <?php
        $query = "SELECT * FROM bank_challans WHERE bank_challan_id = '" . $bank_challan_id . "'";
        $challan = $this->db->query($query)->result()[0];

        ?>
        <tr>
            <td style="text-align: center; background-color:#CCFFFF !important; "></td>
            <td style="text-align: center; background-color:#CCFFFF !important; ">
                <select id="challan_for">

                    <option value="">Challan For</option>
                    <option value="Registration" <?php if ($challan->challan_for == 'Registration') { ?> selected <?php } ?>>Registration</option>
                    <option value="Renewal" <?php if ($challan->challan_for == 'Renewal') { ?> selected <?php } ?>>Renewal</option>
                    <option value="Upgradation Renewal" <?php if ($challan->challan_for == 'Upgradation Renewal') { ?> selected <?php } ?>>Upgradation Renewal</option>
                    <option value="Upgradation" <?php if ($challan->challan_for == 'Upgradation') { ?> selected <?php } ?>>Upgradation</option>

                </select>

            </td>
            <td style="text-align: center; background-color:lightpink !important; ">
                <input value="<?php echo $challan->challan_no; ?>" id="stan_no_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" />
            </td>
            <td style="text-align: center; background-color:lightpink !important; ">
                <input value="<?php echo $challan->challan_date; ?>" id="stan_date_<?php echo $bank_challan_id; ?>" style="width: 100px;" type="date" max="<?php echo date("Y-m-d"); ?>" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->application_processing_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="application_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->renewal_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="renewal_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->inspection_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="inspection_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->upgradation_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="upgradation_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->late_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="late_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->fine; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="fine_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgreen !important;">
                <input value="<?php echo $challan->security_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="security_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>

            <td style="text-align: center; background-color:gray !important;">
                <input value="<?php echo $challan->penalty; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="penalty_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <td style="text-align: center; background-color:lightgray !important;">
                <input value="<?php echo $challan->miscellaneous; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="miscellaneous_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
            </td>
            <th id="total_<?php echo $bank_challan_id; ?>" style="min-width:80px; text-align:center">
                <?php echo number_format($challan->total_deposit_fee, 2); ?>
            </th>
            <td><input onclick="update_bank_challan('<?php echo $bank_challan_id; ?>')" type="button" name="Update" value="Update" /> </td>
        </tr>


    </table>
    <p id="update_message" style="text-align: center;"></p>

</div>
<script>
    function update_bank_challan(school_session_id) {

        challan_for = $("#challan_for").val();
        // alert(challan_for);
        if (challan_for == '') {
            alert("Challan for field is required.");
            return false;
        }
        var statn_number = $('#stan_no_' + school_session_id).val();
        var date_of_deposit = $('#stan_date_' + school_session_id).val();
        application_fee = parseInt($('#application_' + school_session_id).val());
        if (isNaN(application_fee)) application_fee = 0;
        renewal_fee = parseInt($('#renewal_' + school_session_id).val());
        if (isNaN(renewal_fee)) renewal_fee = 0;
        inspection_fee = parseInt($('#inspection_' + school_session_id).val());
        if (isNaN(inspection_fee)) inspection_fee = 0;
        upgradation_fee = parseInt($('#upgradation_' + school_session_id).val());
        if (isNaN(upgradation_fee)) upgradation_fee = 0;
        security = parseInt($('#security_' + school_session_id).val());
        if (isNaN(security)) security = 0;
        late_fee = parseInt($('#late_' + school_session_id).val());
        if (isNaN(late_fee)) late_fee = 0;
        change_of_name = parseInt($('#name_' + school_session_id).val());
        if (isNaN(change_of_name)) change_of_name = 0;
        change_of_building = parseInt($('#building_' + school_session_id).val());
        if (isNaN(change_of_building)) change_of_building = 0;
        change_of_ownership = parseInt($('#ownership_' + school_session_id).val());
        if (isNaN(change_of_ownership)) change_of_ownership = 0;
        penalty = parseInt($('#penalty_' + school_session_id).val());
        if (isNaN(penalty)) penalty = 0;
        miscellaneous = parseInt($('#miscellaneous_' + school_session_id).val());
        if (isNaN(miscellaneous)) miscellaneous = 0;
        fine = parseInt($('#fine_' + school_session_id).val());
        if (isNaN(fine)) fine = 0;

        var total = application_fee + renewal_fee + inspection_fee + upgradation_fee + security + late_fee + change_of_name + change_of_building + change_of_ownership + penalty + miscellaneous + fine;
        if (isNaN(total)) total = 0;


        if (statn_number == "") {
            alert("STAN No is required.");
            return false;
        }
        if (statn_number.toString().length < 4) {
            alert("STAN number is not less than 4 digit.");
            return false;
        }

        if (date_of_deposit == "") {
            alert("Date of deposit is required.");
            return false;
        }


        // if (application_fee == "") {
        //     alert("Application processing fee is required.");
        //     return false;
        // }


        // if (renewal_fee == "") {
        //     alert("Renewal fee is required.");
        //     return false;
        // }


        // if (inspection_fee == "") {
        //     alert("Inspection fee is required.");
        //     return false;
        // }


        // if (upgradation_fee == "") {
        //     alert("Upgradation fee is required.");
        //     return false;
        // }

        // var fine = $('#fine_' + school_session_id).val();
        // if (fine == "") {
        //     alert("Fine is required.");
        //     return false;
        // }


        // if (security == "") {
        //     alert("Security is required.");
        //     return false;
        // }


        // if (late_fee == "") {
        //     alert("Late fee is required.");
        //     return false;
        // }


        // if (change_of_name == "") {
        //     alert("Change of name fee is required.");
        //     return false;
        // }


        // if (change_of_building == "") {
        //     alert("Change of building fee is required.");
        //     return false;
        // }



        // if (change_of_ownership == "") {
        //     alert("Change of Ownership fee is required.");
        //     return false;
        // }


        // if (penalty == "") {
        //     alert("Operation penalty is required.");
        //     return false;
        // }


        // if (miscellaneous == "") {
        //     alert("Miscellaneous fee is required.");
        //     return false;
        // }

        if (total == 0) {
            alert("Enter bank challan amount detail.");
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>bank_challan_entry/update_bank_challan",
                type: "POST",
                data: {

                    bank_challan_id: <?php echo $bank_challan_id; ?>,
                    statn_number: statn_number,
                    date_of_deposit: date_of_deposit,
                    application_fee: application_fee,
                    renewal_fee: renewal_fee,
                    inspection_fee: inspection_fee,
                    upgradation_fee: upgradation_fee,
                    security: security,
                    late_fee: late_fee,
                    change_of_name: change_of_name,
                    change_of_building: change_of_building,
                    change_of_ownership: change_of_ownership,
                    penalty: penalty,
                    miscellaneous: miscellaneous,
                    fine: fine,
                    challan_for: challan_for
                },
                success: function(data) {
                    console.log(data);
                    if (data == 'success') {
                        search();
                        get_bank_challan_list();
                        $('#update_message').html("Bank challan update successfully.");
                    } else {
                        alert(data);
                    }
                }
            });
        }


    }
</script>