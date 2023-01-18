<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
    <h4>
        <table class="table">
            <tr>
                <td><i class="fa fa-info-circle" aria-hidden="true"></i> Institute ID:
                    <strong><?php echo $school->schools_id ?></strong>
                </td>
                <td>
                    Registration ID: <strong style='color:green'><?php echo $school->registrationNumber  ?> </strong>
                </td>
                <td>
                    File No: <strong><?php
                                        $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schools_id'";
                                        $file_numbers = $this->db->query($query)->result();
                                        $count = 1;
                                        foreach ($file_numbers as $file_number) {
                                            if ($count > 1) {
                                                echo ", ";
                                            }
                                            echo $file_number->file_number;

                                            $count++;
                                        }
                                        ?></strong>

                </td>
                <td>
                    <?php if ($school->isfined) { ?>
                        <!-- <button style="color:red">
                    <i class="fa fa-fire" aria-hidden="true"></i> Fine on school
                </button> -->
                    <?php } ?>
                </td>
                <td>
                    School Name: <strong><?php echo $school->schoolName ?></strong>
                </td>
                <td>
                    District: <strong><?php echo $school->districtTitle ?>
                </td>
                <td>
                    ( Region: <?php echo $school->region ?> )</strong>
                </td>
                <td>
                    Address: <strong><?php echo $school->address ?></strong>
                </td>
                <td>
                    Contact No: <strong><?php echo $school->telePhoneNumber . ", " . $school->schoolMobileNumber  ?></strong><br />

                </td>
            </tr>
        </table>
    </h4>
    <?php

    $query = "SELECT
        `reg_type`.`regTypeTitle`,
        `levelofinstitute`.`levelofInstituteTitle`,
        `session_year`.`sessionYearTitle`,
        `session_year`.`sessionYearId`,
        `school`.`renewal_code`,
        `school`.`schoolId`,
        `school`.`status`,
        `school`.`created_date`,
        `school`.`updatedBy`,
        `school`.`updatedDate`,
        `school`.`schoolId`,
        `school`.`visit_list`,
        `school`.`visit_type`,
        `school`.`visit_entry_date`,
        `school`.`cer_issue_date`,
        school.pending_type,
        school.pending_date,
        school.pending_reason,
        school.dairy_type,
        school.dairy_no,
        school.dairy_date
        FROM
        `school`,
        `reg_type`,
        `gender`,
        
        `levelofinstitute`,
        `session_year`
        WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
        AND `gender`.`genderId` = `school`.`gender_type_id`
        
        AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
        AND `session_year`.`sessionYearId` = `school`.`session_year_id`
        AND schools_id = " . $schoolid . "
        AND school.status != 1
        ORDER BY `session_year`.`sessionYearId` ASC
        ";
    $school_sessions = $this->db->query($query)->result();

    $query = "select max(sessionYearId) as sessionYearId from session_year";
    $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;

    ?>



    <table class="table table2 table-bordered">
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
        $previous_max = NULL;
        $count = 0;
        if ($school_sessions) {
            foreach ($school_sessions as $school_session) { ?>

                <tr>
                    <td style="text-align: center; background-color:#CCFFFF !important; "><?php echo $school_session->sessionYearTitle; ?></td>
                    <td style="text-align: center; background-color:#CCFFFF !important; ">
                        <select class="challan_heads" id="challan_for_<?php echo $school_session->schoolId; ?>" data-index="<?php echo $count++; ?>" autofocus>
                            <?php if ($school->registrationNumber <= 0) { ?>
                                <option value="Registration">Registration</option>
                            <?php } else { ?>
                                <option value="">Challan For</option>
                                <option value="Renewal">Renewal</option>
                                <option value="Upgradation Renewal">Upgradation Renewal</option>
                                <option value="Upgradation">Upgradation</option>
                            <?php } ?>
                        </select>

                    </td>
                    <td style="text-align: center; background-color:lightpink !important; ">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" id="stan_no_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" />
                    </td>
                    <td style="text-align: center; background-color:lightpink !important; ">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" id="stan_date_<?php echo $school_session->schoolId; ?>" style="width: 100px;" type="date" max="<?php echo date("Y-m-d"); ?>" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="application_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="renewal_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="inspection_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="upgradation_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="late_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="fine_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgreen !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="security_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>

                    <td style="text-align: center; background-color:gray !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="penalty_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; background-color:lightgray !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="miscellaneous_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <th id="total_<?php echo $school_session->schoolId; ?>" style="min-width:80px; text-align:center">0.00</th>
                    <td><input class="challan_heads" data-index="<?php echo $count++; ?>" onclick="add_bank_stan_no('<?php echo $school_session->schoolId; ?>')" type="button" name="add" value="Add" /> </td>
                </tr>
                <?php
                $query = "SELECT * FROM bank_challans WHERE school_id = '" . $school_session->schoolId . "' and schools_id = " . $schoolid . "";
                $school_session_challans = $this->db->query($query)->result();
                foreach ($school_session_challans as $school_session_challan) { ?>
                    <tr>

                        <td colspan=""></td>

                        <td><?php echo $school_session_challan->challan_for; ?></td>
                        <td><?php echo $school_session_challan->challan_no; ?></td>
                        <td><?php echo date("d M, Y", strtotime($school_session_challan->challan_date)); ?></td>
                        <td><?php echo number_format($school_session_challan->application_processing_fee, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->renewal_fee, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->inspection_fee, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->upgradation_fee, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->late_fee, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->fine, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->security_fee, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->penalty, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->miscellaneous, 2); ?></td>
                        <td><?php echo number_format($school_session_challan->total_deposit_fee, 2); ?></td>
                        <td><a href="#" onclick="edit_bank_challan('<?php echo $school_session_challan->bank_challan_id; ?>')">Edit</a></td>
                    </tr>
                <?php } ?>


            <?php
                $previous_max = $max_tuition_fee;
            }
        } else { ?>
            <tr>
                <td colspan="12">
                    Not applied for registartion.
                </td>
            </tr>
        <?php }
        $school_session->schoolId = 0;
        ?>

        <tr style="background-color: lightgray;">
            <td style="text-align: center;">
                Others
            </td>
            <td style="text-align: center;">
                <select class="challan_heads" id="challan_for_<?php echo $school_session->schoolId; ?>" data-index="<?php echo $count++; ?>">

                    <option value="">Others Challan For</option>
                    <option value="Change of Name">Change of Name</option>
                    <option value="Change of Location">Change of Location</option>
                    <option value="Change of Ownership">Change of Ownership</option>
                    <option value="Penalty">Operation Penalty</option>
                    <option value="Miscellaneous">Miscellaneous</option>
                    <option value="Applicant Certificate">Application Certificate</option>

                </select>

            </td>
            <td style="text-align: center;">
                <input class="challan_heads" data-index="<?php echo $count++; ?>" id="stan_no_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" />
            </td>
            <td style="text-align: center;">
                <input class="challan_heads" data-index="<?php echo $count++; ?>" id="stan_date_<?php echo $school_session->schoolId; ?>" style="width: 100px;" type="date" max="<?php echo date("Y-m-d"); ?>" />
            </td>
            <td colspan="9">
                Total Amount: <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="application_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
            </td>

            <th id="total_<?php echo $school_session->schoolId; ?>" style="min-width:80px; text-align:center">0.00</th>
            <td><input class="challan_heads" data-index="<?php echo $count++; ?>" onclick="add_bank_stan_no('<?php echo $school_session->schoolId; ?>')" type="button" name="add" value="Add" /> </td>
        </tr>

        <?php
        $query = "SELECT * FROM bank_challans WHERE school_id = '0' and schools_id = " . $schoolid . "";
        $school_session_challans = $this->db->query($query)->result();
        foreach ($school_session_challans as $school_session_challan) { ?>
            <tr>

                <td colspan=""></td>

                <td><?php echo $school_session_challan->challan_for; ?></td>
                <td><?php echo $school_session_challan->challan_no; ?></td>
                <td><?php echo date("d M, Y", strtotime($school_session_challan->challan_date)); ?></td>
                <td><?php echo number_format($school_session_challan->application_processing_fee, 2); ?></td>
                <td><?php echo number_format($school_session_challan->renewal_fee, 2); ?></td>
                <td><?php echo number_format($school_session_challan->inspection_fee, 2); ?></td>
                <td><?php echo number_format($school_session_challan->upgradation_fee, 2); ?></td>
                <td><?php echo number_format($school_session_challan->late_fee, 2); ?></td>
                <td><?php echo number_format($school_session_challan->fine, 2); ?></td>
                <td><?php echo number_format($school_session_challan->security_fee, 2); ?></td>
                <td><?php echo number_format($school_session_challan->penalty, 2); ?></td>
                <td><?php echo number_format($school_session_challan->miscellaneous, 2); ?></td>
                <td><?php echo number_format($school_session_challan->total_deposit_fee, 2); ?></td>
                <td><a href="#" onclick="edit_bank_challan('<?php echo $school_session_challan->bank_challan_id; ?>')">Edit</a></td>
            </tr>
        <?php } ?>


    </table>





</div>


<script>
    $(document).ready(function() {
        //here  value for this is the document object and the id is not useful.
        $(".challan_heads").on('keyup', function(e) {

            if (e.key === 'Enter') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
            }
            if (e.key === 'ArrowLeft') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index - 1).toString() + '"]').focus();
            }

            if (e.key === 'ArrowRight') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
            }



        });
    });




    function formatMoney(number, decPlaces, decSep, thouSep) {
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSep = typeof decSep === "undefined" ? "." : decSep;
        thouSep = typeof thouSep === "undefined" ? "," : thouSep;
        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
        var j = (j = i.length) > 3 ? j % 3 : 0;

        return sign +
            (j ? i.substr(0, j) + thouSep : "") +
            i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
            (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }

    // document.getElementById("b").addEventListener("click", event => {
    //     document.getElementById("x").innerText = "Result was: " + formatMoney(document.getElementById("d").value);
    // });

    var total = 0;

    function add_all_heads(school_session_id) {


        //var statn_number = $('#stan_no_' + school_session_id).val();
        //var date_of_deposit = $('#stan_date_' + school_session_id).val();
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
        total = application_fee + renewal_fee + inspection_fee + upgradation_fee + security + late_fee + change_of_name + change_of_building + change_of_ownership + penalty + miscellaneous + fine;

        $('#total_' + school_session_id).html(formatMoney(total, 2, ".", ","));


    }





    function edit_bank_challan(bank_challan_id) {

        $.ajax({
                method: "POST",
                url: "<?php echo site_url('bank_challan_entry/edit_bank_challan'); ?>",
                data: {
                    bank_challan_id: bank_challan_id
                },
            })
            .done(function(respose) {
                //$('#search_result').html(respose);
                $('#modal').modal('show');
                $('#modal_title').html("Edit Bank Challan");
                $('#modal_body').html(respose);
            });


    }

    function add_bank_stan_no(school_session_id) {


        challan_for = $("#challan_for_" + school_session_id).val();
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
                url: "<?php echo base_url(); ?>bank_challan_entry/add_stan_number",
                type: "POST",
                data: {
                    school_session_id: school_session_id,
                    school_id: <?php echo $schoolid; ?>,
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
                    } else {
                        alert(data);
                    }
                }
            });
        }


    }
</script>