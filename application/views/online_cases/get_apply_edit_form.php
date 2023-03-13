<style>
    .table2>thead>tr>th,
    .table2>tbody>tr>th,
    .table2>tfoot>tr>th,
    .table2>thead>tr>td,
    .table2>tbody>tr>td,
    .table2>tfoot>tr>td {
        padding: 5px;
        line-height: 1;
        vertical-align: top;
        color: black !important;
        text-align: center;


    }
</style>

<div class="modal-header">
    <h5 class="modal-title pull-left" id="exampleModalLabel">Edit Session Apply Type</h5>
    <a href="<?php echo site_url("online_cases/combine_note_sheet/" . $school->schools_id) ?>" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
<section style="padding:5px">
    <div class="row">
        <div class="col-md-7">
            <div style="border:1px solid #CCCCCC; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; back ground-color: white;">
                <h4><?php echo ucwords(strtolower($school->schoolName)); ?></h4>
                <h6> School ID: <?php echo $school->schools_id ?>
                    <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> Reg. ID:
                        <?php echo $school->registrationNumber ?>
                    <?php } ?>
                    <span style="margin-left: 20px;"></span>
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
                </h6>
                <small><strong>Address:</strong>
                    <?php if ($school->division) {
                        echo "Region: <strong>" . $school->division . "</strong>";
                    } ?>
                    <?php if ($school->districtTitle) {
                        echo " / District: <strong>" . $school->districtTitle . "</strong>";
                    } ?>
                    <?php if ($school->tehsilTitle) {
                        echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
                    } ?>

                    <?php if ($school->ucTitle) {
                        echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
                    } ?>
                    <?php if ($school->ucTitle) {
                        echo " / <strong>" . $school->address . "</strong>";
                    } ?>
                </small>
                <hr />

                
            </div>

        </div>
       
<div class="col-md-5">
    <?php $query="SELECT school.schoolId, school.reg_type_id, reg_type.regTypeTitle, session_year.sessionYearTitle FROM `school`
                INNER JOIN reg_type ON (reg_type.regTypeId = school.reg_type_id)
                INNER JOIN session_year ON (session_year.sessionYearId = school.session_year_id)
                WHERE school.schoolId = '".$school_id."'
                AND school.schools_id = '".$schoolid."'"; 
        $session_detail = $this->db->query($query)->row();        
                ?>
    School Applied for Session <?php echo $session_detail->sessionYearTitle; ?> (<?php echo $session_detail->regTypeTitle;  ?>) <br />
    Do you want to change online apply for this session <?php echo $session_detail->sessionYearTitle; ?> 
    <form onsubmit="return confirm('Do you really want to to change apply?');" method="post" action="<?php echo site_url("online_cases/update_online_apply") ?>">
        <input type="hidden" name="schools_id" value="<?php echo $schoolid; ?>" />
        <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <select name="reg_type_id" style="width: 150px;">
                                <?php if ($school->registrationNumber <= 0) { ?>
                                    <option value="1"> New Registration</option>
                                <?php } else { ?>
                                <option <?php if ($session_detail->reg_type_id == 2) { ?> selected <?php } ?> value="2">Renewal</option>
                                <option <?php if ($session_detail->reg_type_id == 4) { ?> selected <?php } ?> value="4">Upgradation Renewal</option>
                                <?php } ?>
                            </select>
                            <input type="submit" name="change" value="Change Apply" />
    
    </form>
    
</div>
    </div>


    <div class="row">
        <div class="col-md-12">
           
            
        </div>
    </div>

          
       
    </div>

    <div class="modal-footer">
        <a class="btn btn-secondary " href="<?php echo site_url("online_cases/combine_note_sheet/" . $school->schools_id) ?>" class="close" aria-label="Close">Close</a>

    </div>
</section>

<script>
    // this is the id of the form
    $("#send_deficency_message").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data) {
                add_bank_challan('<?php echo $school_id; ?>');
            }
        });

    });


    $(document).ready(function() {
        //here  value for this is the document object and the id is not useful.
        $(".challan_heads").on('keyup', function(e) {

            if (e.key === 'Enter') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
                var value = $('[data-index="' + (index + 1).toString() + '"]').val();
                if (value == '0') {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                } else {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                    $('[data-index="' + (index + 1).toString() + '"]').val(value);
                }

            }
            if (e.key === 'ArrowLeft') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index - 1).toString() + '"]').focus();
                var value = $('[data-index="' + (index + 1).toString() + '"]').val();
                if (value == '0') {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                } else {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                    $('[data-index="' + (index + 1).toString() + '"]').val(value);
                }

            }

            if (e.key === 'ArrowRight') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
                var value = $('[data-index="' + (index + 1).toString() + '"]').val();
                if (value == '0') {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                } else {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                    $('[data-index="' + (index + 1).toString() + '"]').val(value);
                }

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
                url: "<?php echo site_url('online_cases/edit_bank_challan'); ?>",
                data: {
                    bank_challan_id: bank_challan_id
                },
            })
            .done(function(respose) {
                $('#request_detail_body').html(respose);
                // $('#modal').modal('show');
                // $('#modal_title').html("Edit Bank Challan");
                // $('#modal_body').html(respose);
                $('#request_detail').modal('show');

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


        if (total == 0) {
            alert("Enter bank challan amount detail.");
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>online_cases/add_stan_number",
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
                        add_bank_challan('<?php echo $school_id; ?>');
                    } else {
                        alert(data);
                    }
                }
            });
        }


    }

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


        if (total == 0) {
            alert("Enter bank challan amount detail.");
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>online_cases/update_bank_challan",
                type: "POST",
                data: {

                    bank_challan_id: school_session_id,
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
                        add_bank_challan('<?php echo $school_id; ?>');
                    } else {
                        alert(data);
                    }
                }
            });
        }


    }
</script>