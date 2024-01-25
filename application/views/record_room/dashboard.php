<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title" style="display: inline;"></h4>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">
                ...
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Content Wrapper. Contains page content -->
<script>
    $(document).ready(function() {
        //skin-blue sidebar-mini
        $(".skin-blue").addClass("sidebar-collapse");
    });
</script>
<style>
    .table {
        background-color: transparent !important;
        margin: 2px;
        width: 99%;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        background-color: transparent !important;
    }
</style>

<div class="content-wrapper">

    <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">

        <!-- Small boxes (Stat box) -->
        <div class="row">

            <style>
                .block_div {
                    border: 1px solid #9FC8E8;
                    border-radius: 10px;
                    min-height: 3px;
                    margin: 3px;
                    padding: 10px;
                    background-color: white;
                }
            </style>
            <?php
            $userId = $this->session->userdata('userId');
            $query = "SELECT region_ids FROM users WHERE userId = '" . $userId . "'";
            $region_ids = $this->db->query($query)->row()->region_ids;
            $status = 2;
            $file_status = 1;
            $institute_type_id = 2;
            $request_type = 1;
            $query = "SELECT
         `schools`.schoolId as schools_id,
         `schools`.schoolName,
         `schools`.docs,
         `schools`.registrationNumber,
         `schools`.biseRegister,
         `schools`.`biseregistrationNumber`,
         `session_year`.`sessionYearTitle`,
         `session_year`.`sessionYearId`,
         `school`.`status`,
         `reg_type`.`regTypeTitle`,
         `school`.`schoolId` as school_id,
         `district`.`districtTitle`,
         `school`.`file_status`,
         `school`.`apply_date`,
         schools.isfined,
         school.status_remark,
         `schools`.`school_type_id`,
         school.visit,
         school.recommended,
         school.flag_color,
         school.flag_detail,
         `school`.`level_of_school_id`,
         `schools`.`yearOfEstiblishment`,
         (SELECT `tehsils`.`tehsilTitle` FROM `tehsils` WHERE `tehsils`.`tehsilId` = schools.tehsil_id) as tehsil,
         schools.address,
         (SELECT `levelofinstitute`.`levelofInstituteTitle` FROM `levelofinstitute`  WHERE `levelofinstitute`.`levelofInstituteId`= school.level_of_school_id) as level,
         
         schools.telePhoneNumber,
         schools.schoolMobileNumber,
         school.principal_contact_no,
         (SELECT `users`.`contactNumber` FROM users WHERE `users`.`userId`=schools.owner_id) as owner_contact_no,
         
         (SELECT s.status
         FROM school as s WHERE 
         s.schools_id = `schools`.`schoolId`
         AND  s.session_year_id = (`school`.`session_year_id`-1) and s.schools_id = schools.schoolId LIMIT 1) as previous_session_status,
         (SELECT COUNT(*)
         FROM school as s WHERE 
         s.schools_id = `schools`.`schoolId`
         AND  s.status != 1 and `s`.`file_status`=5) as deficient
         FROM
         `school`,
         `schools`,
         `session_year`,
         `reg_type`,
         `district` 
         WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
         AND `school`.`schools_id` = `schools`.`schoolId`
         AND `school`.`reg_type_id` = `reg_type`.`regTypeId` 
         AND schools.district_id = district.districtId
         AND `school`.`status`='" . $status . "'
         AND `school`.`file_status`= '" . $file_status . "'
         AND district.new_region IN(" . $region_ids . ")
         AND `school`.`reg_type_id`= '" . $request_type . "'
         ";

            //  "AND district.new_region IN(" . $region_ids . ") 
            //  
            //  
            //  AND `school`.`reg_type_id`= '" . $registration_type_id . "' 
            //  AND `schools`.`school_type_id`= '" . $institute_type_id . "' 
            //  ORDER BY `school`.`apply_date` ASC, 
            //  `school`.`schools_id` ASC, 
            //  `school`.`session_year_id` ASC ";
            $requests = $this->db->query($query)->result();

            ?>
            <section class="content" style="padding-top: 0px !important;">


                <div class="row">
                    <div class="col-md-12">
                        <div class="block_div" id="new_registration_list">
                            <h4>New Registration Appllied Cases</h4>
                            <div class="table-responsive">


                                <table class="table table-bordered table_small" id="<?php echo  str_replace(" ", "_", $title);  ?>" style="font-size:11px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Insti.ID</th>
                                            <th>File No.</th>
                                            <th>Level</th>
                                            <th>District</th>
                                            <th>School Name</th>
                                            <th>Session</th>
                                            <th>Flag</th>
                                            <th>Days</th>
                                            <th>Defic</th>
                                            <th>Note</th>
                                            <th>Fine</th>
                                            <th>Visit</th>
                                            <th>Reco.</th>
                                            <th>Remarks</th>

                                            <th>Tehsil</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            <th>YofEst</th>
                                            <th>BISE Reg.</td>
                                            <th>Documents</th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        $previous_school_id = 0;
                                        foreach ($requests as $request) {
                                            if ($request->previous_session_status != 8) {
                                        ?>

                                                <tr>
                                                    <td><?php echo $count++; ?> </td>
                                                    <td><?php echo $request->regTypeTitle; ?></td>

                                                    <td><?php echo $request->schools_id ?></td>
                                                    <td>
                                                        <?php
                                                        $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$request->schools_id'";
                                                        $file_numbers = $this->db->query($query)->result();
                                                        $fcount = 1;
                                                        foreach ($file_numbers as $file_number) {
                                                            if ($fcount > 1) {
                                                                echo ", ";
                                                            }
                                                            echo $file_number->file_number;

                                                            $fcount++;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($request->level_of_school_id == 1) {
                                                            echo "Primary";
                                                        } ?>
                                                        <?php if ($request->level_of_school_id == 2) {
                                                            echo "Middle";
                                                        } ?>
                                                        <?php if ($request->level_of_school_id == 3) {
                                                            echo "High";
                                                        } ?>
                                                        <?php if ($request->level_of_school_id == 4) {
                                                            echo "H.Sec";
                                                        } ?>
                                                        <?php if ($request->level_of_school_id == 5) {
                                                            echo "Academy";
                                                        } ?>
                                                    </td>
                                                    <td><?php echo $request->districtTitle; ?></td>
                                                    <td><?php echo substr($request->schoolName, 0, 45) ?></td>



                                                    <td><?php echo $request->sessionYearTitle ?></td>
                                                    <td><?php echo $request->flag_detail ?></td>
                                                    <td style="text-align: center;" title="<?php echo date('d M, Y', strtotime($request->apply_date)); ?>">
                                                        <?php
                                                        //strtotime($request->apply_date)
                                                        if ($request->apply_date) {
                                                            echo timeago(strtotime($request->apply_date));
                                                        }
                                                        ?></td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        $query = "SELECT COUNT(*) as total FROM `file_status_logs` WHERE `file_status` = 5 and schools_id = '" . $request->schools_id . "'";
                                                        $once_deficient = $this->db->query($query)->row()->total;
                                                        if ($once_deficient > 0) {
                                                            echo '<i title="Deficiency completed" class="fa fa-flag" style="color:red" aria-hidden="true">1</i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        $query = "SELECT COUNT(*) as total FROM `comments` WHERE school_id='" . $request->school_id . "' and schools_id = '" . $request->schools_id . "' and deleted=0";
                                                        $comments = $this->db->query($query)->row()->total;
                                                        if ($comments > 0) {
                                                            echo '<i title="Maybe notesheet completed" class="fa fa-comment" style="color:green" aria-hidden="true">1</i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($request->isfined == 1) { ?>
                                                            <i class="fa fa-ban" title="Fine on this school" style="color: red;">1</i>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo $request->visit; ?></td>
                                                    <td><?php echo $request->recommended; ?></td>


                                                    <td><?php echo $request->status_remark; ?></td>





                                                    <td><?php echo $request->tehsil; ?></td>
                                                    <td><?php echo $request->address; ?></td>
                                                    <td><?php echo $request->telePhoneNumber; ?>,
                                                        <?php echo $request->schoolMobileNumber; ?>,
                                                        <?php echo $request->principal_contact_no; ?>,
                                                        <?php echo $request->owner_contact_no; ?>,
                                                    </td>
                                                    <td><?php echo $request->yearOfEstiblishment; ?></td>
                                                    <td><?php
                                                        if ($request->biseRegister == 'Yes') {
                                                            echo 'Yes - ';
                                                        }
                                                        echo $request->biseregistrationNumber;
                                                        ?></td>


                                                    <td>
                                                        <?php if ($request->docs == 0) {
                                                            echo "No";
                                                        } ?>
                                                        <?php if ($request->docs == 1) {
                                                            echo "Yes";
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <button onclick="get_document_update_form('<?php echo $request->schools_id ?>')" class="btn btn-link btn-sm "> Update Doc / File No </button>
                                                    </td>

                                                </tr>
                                            <?php } ?>
                                        <?php

                                        } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="block_div" id="deficient_list">

                        </div>
                    </div>

                </div>
        </div>




        <div class="clearfix"></div>


        <!-- Main row -->
        <!-- /.row (main row) -->

</div>


</section>
</div>

<script>
    function get_document_update_form(schools_id) {
        $.ajax({
                method: "POST",
                url: "<?php echo site_url('record_room/school_detail'); ?>",
                data: {
                    schools_id: schools_id
                },
            })
            .done(function(respose) {
                $('#modal').modal('show');
                $('#modal_title').html("Update Documents Status");
                $('#modal_body').html(respose);
            });
    }

    // Get the input field
    var input = document.getElementById("search");

    // Execute a function when the user presses a key on the keyboard
    input.addEventListener("keypress", function(event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {

            search();
        }
    });

    function search() {
        var search = $('#search').val();
        var district_id = $('#district_id').val();
        var district_name = $('#district_id :selected').text();
        var search_by = $('input[name="search_type"]:checked').val();

        $.ajax({
                method: "POST",
                url: "<?php echo site_url('record_room/school_detail'); ?>",
                data: {
                    search: search,
                    district_id: district_id,
                    district_name: district_name,
                    search_by: search_by,
                    type: '<?php echo $type; ?>',
                    region: '',
                },
            })
            .done(function(respose) {
                //$('#search_result').html(respose);
                $('#modal').modal('show');
                $('#modal_title').html("School Case Details");
                $('#modal_body').html(respose);
            });
    }
</script>