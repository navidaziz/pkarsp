<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


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
        padding: 0px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        background-color: transparent !important;
    }
</style>
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
$query = "SELECT
                IF(district.new_region=1,'Central', IF(district.new_region=2,'South', IF(district.new_region=3,'Malakand', IF(district.new_region=4,'Hazara', IF(district.new_region=5,'Peshawar', 'Other')))) ) as Region,
                 COUNT(*) as Total,
                 SUM(IF(schools.docs IS NULL, 1, 0)) as Not_Update,
                 SUM(IF(schools.docs=1, 1, 0)) as Doc_Yes,
                 SUM(IF(schools.docs=0, 1, 0)) as Doc_No  
                 FROM
                 `school`,
                 `schools`,
                 `session_year`,
                 `reg_type`,
                 `district` 
                 WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
                 AND `school`.`schools_id` = `schools`.`schoolId`
                 AND `school`.`reg_type_id` = `reg_type`.`regTypeId` 
                 AND `schools`.district_id = district.districtId
                 AND `school`.`status`='2'
                 AND district.new_region IN(" . $region_ids . ")
                 AND `school`.`file_status` IN ( 1,5 )
                 AND `school`.`reg_type_id`= '1'
                 AND `schools`.`school_type_id`= '1'  
                 GROUP BY district.new_region;";

$progress_reports = $this->db->query($query)->result();

?>


<div class="content-wrapper">

    <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">

        <!-- Small boxes (Stat box) -->
        <div class="row">





            <div class="row">
                <div class="col-md-12">

                </div>
            </div>

            <section class="content" style="padding-top: 0px !important;">


                <div class="row">
                    <div class="col-md-12">
                        <div class="block_div" id="new_registration_list">
                            <h4>Progress Report</h4>
                            <table class="table table-bordered" id="summary_report">
                                <thead>
                                    <tr>
                                        <th>Region</th>
                                        <th>Total</th>
                                        <th>Not Update</th>
                                        <th>Doc Yes</th>
                                        <th>Doc No</th>
                                    </tr>
                                </thead>
                                <?php foreach ($progress_reports as $progress_report) { ?>
                                    <tr>
                                        <th><?php echo $progress_report->Region ?></th>
                                        <td><?php echo $progress_report->Total ?></td>
                                        <td><?php echo $progress_report->Not_Update ?></td>
                                        <td><?php echo $progress_report->Doc_Yes ?></td>
                                        <td><?php echo $progress_report->Doc_No ?></td>

                                    </tr>
                                <?php } ?>
                                <tbody>

                            </table>

                        </div>
                        <div class="block_div" id="new_registration_list">

                            <h4>New Registration Appllied Cases</h4>
                            <div class="table-responsive">

                                <?php
                                $status = 2;
                                $file_status = "1,5";
                                $institute_type_id = 2;
                                $request_type = 1;
                                $query = "SELECT
                                    `schools`.schoolId as schools_id,
                                    `schools`.schoolName,
                                    `schools`.docs,
                                    `schools`.rr_note,
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
                                    AND `school`.`file_status` IN ( " . $file_status . " )
                                    AND district.new_region IN(" . $region_ids . ")
                                    AND `school`.`reg_type_id`= '" . $request_type . "'
                                    ORDER BY `school`.`schools_id` ASC, 
                                    `schools`.`docs` ASC
                                    ";

                                $requests = $this->db->query($query)->result();

                                ?>
                                <table class="table table-bordered table_small" id="table_new_registration" style="font-size:11px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
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
                                            <th>Note</th>
                                            <th>Contact</th>
                                            <th>YofEst</th>
                                            <th>BISE Reg.</td>
                                            <th>Doc</th>
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


                                                    <td><?php echo $request->rr_note; ?></td>
                                                    <td>
                                                        <?php
                                                        $mobile_number = array();
                                                        if ($request->telePhoneNumber) {
                                                            $mobile_number[preg_replace('/[^0-9]/', '', $request->telePhoneNumber)] = $request->telePhoneNumber;
                                                        }
                                                        if ($request->schoolMobileNumber) {
                                                            $mobile_number[preg_replace('/[^0-9]/', '', $request->schoolMobileNumber)] = $request->schoolMobileNumber;
                                                        }
                                                        if ($request->principal_contact_no) {
                                                            $mobile_number[preg_replace('/[^0-9]/', '', $request->principal_contact_no)] = $request->principal_contact_no;
                                                        }
                                                        if ($request->owner_contact_no) {
                                                            $mobile_number[preg_replace('/[^0-9]/', '', $request->owner_contact_no)] = $request->owner_contact_no;
                                                        }
                                                        echo rtrim(implode(", ", $mobile_number), ",");
                                                        ?>
                                                    </td>
                                                    <td><?php echo $request->yearOfEstiblishment; ?></td>
                                                    <td><?php
                                                        if ($request->biseRegister == 'Yes') {
                                                            echo 'Yes - ';
                                                        }
                                                        echo $request->biseregistrationNumber;
                                                        ?></td>


                                                    <td>
                                                        <?php
                                                        //echo $request->docs;
                                                        if ($request->docs === '0') {
                                                            echo '<i style="color:red" class="fa fa-times-circle-o" aria-hidden="true"></i> No';
                                                        } ?>
                                                        <?php if ($request->docs === '1') {
                                                            echo '<i style="color:green" class="fa fa-check-circle" aria-hidden="true"></i> Yes';
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
                        <div class="block_div" id="new_registration_list">
                            <h4>Missing File Numbers</h4>
                            <table class="table table-bordered table_small" id="missing_file_number">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School ID</th>
                                        <th>File No.</th>
                                        <th>School Name</th>
                                        <th>District Name</th>
                                        <th>Registration</th>
                                        <th>Last Renewal</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $query = "SELECT f.*, `district`.`districtTitle`,
                                    (SELECT sy.sessionYearTitle as sessionYearTitle
                                    FROM school
                                    INNER JOIN session_year AS sy ON (sy.sessionYearId = school.session_year_id)
                                    WHERE school.schools_id = f.schoolId AND school.status = 1
                                    AND school.renewal_code <=0 
                                    ORDER BY school.schoolId DESC LIMIT 1) as registration,
                                    (SELECT sy.sessionYearTitle as sessionYearTitle
                                    FROM school
                                    INNER JOIN session_year AS sy ON (sy.sessionYearId = school.session_year_id)
                                    WHERE school.schools_id = f.schoolId AND school.status = 1
                                    AND school.renewal_code >0 
                                    ORDER BY school.schoolId DESC LIMIT 1) as last_renewal
                                     FROM file_numbers as f 
                                    INNER JOIN district ON(f.district_id = district.districtId)
                                    WHERE f.file_no IS NULL
                                    AND district.new_region IN(" . $region_ids . ") ";
                                    $files = $this->db->query($query)->result();
                                    foreach ($files as $file) { ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $file->schoolId; ?></td>
                                            <td><?php echo $file->file_no; ?></td>
                                            <td><?php echo $file->schoolName; ?></td>
                                            <td><?php echo $file->districtTitle; ?></td>
                                            <td><?php echo $file->registrationNumber; ?></td>
                                            <td><?php echo $file->last_renewal; ?></td>
                                            <td><?php echo $file->rr_note; ?></td>
                                            <td>
                                                <button onclick="get_document_update_form('<?php echo $file->schoolId ?>')" class="btn btn-link btn-sm "> Only Add File No. </button>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
        </script>

        <script>
            $(document).ready(function() {
                $('#summary_report').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    title: 'Record Room Summary Report',
                    "order": [],
                    searching: true,
                    buttons: [

                        {
                            extend: 'print',
                            title: 'Record Room Summary Report',
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Record Room Summary Report',

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Record Room Summary Report',
                            pageSize: 'A4',

                        }
                    ]
                });
            });
            $(document).ready(function() {
                $('#missing_file_number').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    title: 'Record Room Missing File',
                    "order": [],
                    searching: true,
                    buttons: [

                        {
                            extend: 'print',
                            title: 'Record Room Missing File',

                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Record Room Missing File',

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Record Room Missing File',
                            pageSize: 'A4',

                        }
                    ]
                });
            });
            $(document).ready(function() {
                $('#table_new_registration').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    title: 'New Registration Cases',
                    "order": [],
                    searching: true,
                    buttons: [

                        {
                            extend: 'print',
                            title: 'New Registration Cases',

                        },
                        {
                            extend: 'excelHtml5',
                            title: 'New Registration Cases',

                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'New Registration Cases',
                            pageSize: 'A4',
                        }
                    ]
                });
            });
        </script>