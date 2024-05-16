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
                                <table class="table table-bordered table_small" id="visits_list">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Institute ID</th>
                                            <th>School Name</th>
                                            <th>District</th>
                                            <th>Contact</th>
                                            <th>Already Registered</th>
                                            <th>Visit Reason</th>
                                            <th>Session</th>
                                            <th>Recommended</th>
                                            <th>Recommended levels</th>

                                            <th>Visited</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Function to clean the phone number
                                        function cleanPhoneNumber($number)
                                        {
                                            // Remove any non-digit characters
                                            return preg_replace('/\D/', '', $number);
                                        }
                                        $count = 1;
                                        $query = "SELECT v. visit_id, v.schools_id, v.school_id, v.visit_reason, v.primary_l, 
                                        v.middle_l, v.high_l, v.high_sec_l, v.academy_l, v.visited, 
                                        v.visit_date,
                                        v.recommendation,
                                        s.schoolName, s.registrationNumber,
                                        (SELECT tehsilTitle FROM `tehsils` WHERE tehsils.tehsilId=s.tehsil_id) as tehsil,
                                        (SELECT `ucTitle` FROM `uc` WHERE uc.ucId=s.uc_id) as uc,
                                        s.uc_text,
                                        s.address,
                                        d.districtTitle,
                                        sy.sessionYearTitle,
                                        ss.principal_contact_no,
                                        s.schoolMobileNumber,
                                        s.telePhoneNumber,
                                        v.visit_status,
                                        v.created_by
                                        FROM visits as v 
                                        INNER JOIN schools as s ON(s.schoolId = v.schools_id) 
                                        INNER JOIN district as d ON(d.districtId = s.district_id) 
                                        INNER JOIN school as ss ON(ss.schoolId = v.school_id)
                                        INNER JOIN session_year as sy ON(sy.sessionYearId = ss.session_year_id)
                                        WHERE is_deleted = 0
                                        AND v.visited='Yes'";
                                        $rows = $this->db->query($query)->result();
                                        foreach ($rows as $row) { ?>
                                            <tr>

                                                <td><?php echo $count++ ?></td>
                                                <td><?php echo $row->schools_id; ?></td>
                                                <td><?php echo $row->schoolName; ?></td>
                                                <td><?php echo $row->districtTitle; ?></td>


                                                <td><?php
                                                    $contact = array();

                                                    // Clean and add telePhoneNumber
                                                    $cleanedTelePhoneNumber = cleanPhoneNumber($row->telePhoneNumber);
                                                    if (!empty($cleanedTelePhoneNumber)) {
                                                        $contact[$cleanedTelePhoneNumber] = $cleanedTelePhoneNumber;
                                                    }

                                                    // Clean and add schoolMobileNumber
                                                    $cleanedSchoolMobileNumber = cleanPhoneNumber($row->schoolMobileNumber);
                                                    if (!empty($cleanedSchoolMobileNumber)) {
                                                        $contact[$cleanedSchoolMobileNumber] = $cleanedSchoolMobileNumber;
                                                    }

                                                    // Clean and add principal_contact_no
                                                    $cleanedPrincipalContactNo = cleanPhoneNumber($row->principal_contact_no);
                                                    if (!empty($cleanedPrincipalContactNo)) {
                                                        $contact[$cleanedPrincipalContactNo] = $cleanedPrincipalContactNo;
                                                    }

                                                    // Remove duplicates and output unique numbers
                                                    $uniqueNumbers = array_values(array_unique($contact));
                                                    foreach ($uniqueNumbers as $number) {
                                                        echo $number . "<br /> ";
                                                    }
                                                    ?></td>
                                                <td>

                                                    <?php
                                                    $query = "SELECT `level_of_school_id`,
                                                    `primary`, middle, high, high_sec FROM school 
                                                    WHERE schools_id = '" . $row->schools_id . "' 
                                                    AND  status = 1 ORDER BY schoolId DESC LIMIT 1";
                                                    $reg_levels = $this->db->query($query)->row(); ?>
                                                    <?php echo ($reg_levels->primary == 1 or $reg_levels->level_of_school_id == 1) ? 'Primary, ' : '' ?>
                                                    <?php echo ($reg_levels->middle == 1 or $reg_levels->level_of_school_id == 2) ? 'Middle, ' : '' ?>
                                                    <?php echo ($reg_levels->high == 1 or $reg_levels->level_of_school_id == 3) ? 'High, ' : '' ?>
                                                    <?php echo ($reg_levels->higher_sec == 1 or $reg_levels->level_of_school_id == 4) ? 'High Sec, ' : '' ?>
                                                </td>

                                                <td><?php echo $row->visit_reason; ?></td>
                                                <td><?php echo $row->sessionYearTitle; ?></td>
                                                <td><?php if ($row->recommendation == 'Recommended') { ?>
                                                        <span style="color: green;"><?php echo $row->recommendation; ?></span>
                                                    <?php } else { ?>
                                                        <span style="color: red;"><?php echo $row->recommendation; ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $row->primary_l == 1 ? 'Primary, ' : '' ?>
                                                    <?php echo $row->middle_l == 1 ? 'Middle, ' : '' ?>
                                                    <?php echo $row->high_l == 1 ? 'High, ' : ''; ?>
                                                    <?php echo $row->high_sec_l == 1 ? 'Higher Sec. ' : ''  ?>
                                                    <?php echo $row->academy_l == 1 ? 'Academy ' : ''  ?>
                                                </td>

                                                <td><?php echo $row->visit_status; ?></td>
                                                <td><?php echo date('d M, y', $row->visit_date); ?></td>
                                                <td>
                                                    <?php if ($row->visited == 'Yes') { ?>
                                                        <a target="new" class="btn btn-link btn-sm" style="padding: 0px; margin:0px font-size:10px !important" href="<?php echo site_url('visits/print_visit_report/' . $row->visit_id . '/' . $row->schools_id . '/' . $row->school_id); ?>">Print</a>
                                                    <?php } ?>

                                                </td>
                                            </tr>
                                        <?php } ?>
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