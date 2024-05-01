<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<style>
    .table_small>thead>tr>th,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>tbody>tr>td,
    .table_small>tfoot>tr>td {
        padding: 3px;
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 11px !important;
        color: black;
        margin: 0px !important;
    }
</style>
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
<div class="content-wrapper">
    <section class="content-header">
        <div class='row'>
            <div class='col-md-6'>
                <div class='clearfix'>
                    <h3 class='content-title pull-left'><?php echo $title; ?> </h3>
                </div>
                <small><?php echo $description; ?></small>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="tabbable header-tabs">
            <?php $this->load->view("visits/menu"); ?>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="box_tab3">
                    <!-- TAB 1 -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">


                                <?php
                                // Function to clean the phone number
                                function cleanPhoneNumber($number)
                                {
                                    // Remove any non-digit characters
                                    return preg_replace('/\D/', '', $number);
                                }
                                $count = 1;
                                $query = "SELECT `schools`.schoolId as schools_id, 
                                        `schools`.schoolName, 
                                        `schools`.registrationNumber, 
                                        `schools`.biseRegister, 
                                        `schools`.`biseregistrationNumber`, 
                                        `schools`.`docs`, 
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
                                        school.visit, 
                                        school.recommended, 
                                        school.flag_color, 
                                        school.flag_detail, 
                                        `school`.`level_of_school_id`, 
                                        `schools`.`yearOfEstiblishment`, 
                                        (SELECT `tehsils`.`tehsilTitle` FROM `tehsils` WHERE `tehsils`.`tehsilId` = schools.tehsil_id) as tehsil,
                                         schools.address, 
                                         (SELECT `levelofinstitute`.`levelofInstituteTitle` FROM `levelofinstitute` WHERE `levelofinstitute`.`levelofInstituteId`= school.level_of_school_id) as level, 
                                         schools.telePhoneNumber, 
                                         schools.schoolMobileNumber, 
                                         school.principal_contact_no, 
                                         (SELECT `users`.`contactNumber` FROM users WHERE `users`.`userId`=schools.owner_id) as owner_contact_no, 
                                         (SELECT s.status FROM school as s WHERE s.schools_id = `schools`.`schoolId` AND s.session_year_id = (`school`.`session_year_id`-1) and s.schools_id = schools.schoolId LIMIT 1) as previous_session_status, 
                                         (SELECT COUNT(*) FROM school as s WHERE s.schools_id = `schools`.`schoolId` AND s.status != 1 and `s`.`file_status`=5) as deficient 
                                         FROM `school`, `schools`, `session_year`, `reg_type`, `district` 
                                         WHERE `session_year`.`sessionYearId` = `school`.`session_year_id` 
                                         AND `school`.`schools_id` = `schools`.`schoolId` 
                                         AND `school`.`reg_type_id` = `reg_type`.`regTypeId` 
                                         AND schools.district_id = district.districtId 
                                         AND district.new_region IN(1,2,3,4,5) 
                                         AND `school`.`status`='2' 
                                         AND `school`.`file_status`!= '10' 
                                         AND `school`.`reg_type_id` IN(1,4) 
                                         AND `schools`.`school_type_id`= '1' 
                                         AND (school.visit IS NULL or school.visit = 'No')
                                         ORDER BY `school`.`apply_date` ASC, 
                                         `school`.`schools_id` ASC, `school`.`session_year_id` ASC;";
                                $requests = $this->db->query($query)->result();
                                ?>
                                <table class="table table-bordered table_small" id="visits_list" style="font-size:11px">
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
                                            <th>Docs</th>
                                            <th>Days</th>
                                            <th>Defic</th>
                                            <th>Note</th>
                                            <th>Fine</th>

                                            <th>Visit</th>
                                            <th>Reco.</th>
                                            <th>Remarks</th>

                                            <th>YofEst</th>
                                            <th>BISE Reg.</td>
                                            <th>Status</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        $previous_school_id = 0;
                                        foreach ($requests as $request) {
                                            if ($request->previous_session_status != 8) {
                                        ?>


                                                <tr style="<?php if ($request->flag_color) { ?>
            background-color: <?php echo $request->flag_color; ?>; <?php } ?> <?php if ($request->deficient > 0) { ?> color:red; <?php if ($list_type == 1) { ?> display:no ne;<?php } ?> <?php } ?>">
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
                                                    <td>

                                                        <?php if ($request->docs == 0) {
                                                            echo '<i style="color:red" class="fa fa-times-circle-o" aria-hidden="true"></i> No';
                                                        } ?>
                                                        <?php if ($request->docs == 1) {
                                                            echo '<i style="color:green" class="fa fa-check-circle" aria-hidden="true"></i> Yes';
                                                        } ?>

                                                    </td>
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


                                                    <td><?php echo $request->yearOfEstiblishment; ?></td>
                                                    <td><?php
                                                        if ($request->biseRegister == 'Yes') {
                                                            echo 'Yes - ';
                                                        }
                                                        echo $request->biseregistrationNumber;
                                                        ?></td>

                                                    <td><?php echo file_status($request->file_status); ?></td>

                                                </tr>

                                        <?php
                                                $previous_school_id =  $request->schools_id;
                                            }
                                        } ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        <script>
            function get_add_to_visit_list_form(visit_id) {
                $.ajax({
                        method: "POST",
                        url: "<?php echo site_url('visits/get_add_to_visit_list_form'); ?>",
                        data: {
                            visit_id: visit_id
                        },
                    })
                    .done(function(respose) {
                        $('#modal').modal('show');
                        $('#modal_title').html('Visits');
                        $('#modal_body').html(respose);
                    });
            }
        </script>


    </section>
</div>
<style>
    .dt-buttons {
        display: inline;
    }

    table.dataTable.no-footer {
        margin-top: 10px;

    }

    .dataTables_filter {
        display: inline;
        float: right;
    }
</style>
<script>
    $(document).ready(function() {
        document.title = "List of Not Visited Institutes upto (<?php echo date('d-m-y h:m:s') ?>)";
        $('#visits_list').DataTable({
            dom: 'Bfrtip',
            paging: false,
            searching: true,
            ordering: true, // Enable sorting
            buttons: [
                'copy', 'csv', 'excel', 'print', {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                },

            ],

        });
    });
</script>