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
                                            <th>File No.</th>
                                            <th>RegNo</th>
                                            <th>School Name</th>
                                            <th>Region</th>
                                            <th>District</th>
                                            <th>Contact</th>
                                            <th>Current Level</th>
                                            <th>Visit Reason</th>
                                            <td>Primary</td>
                                            <td>Middle</td>
                                            <td>High</td>
                                            <td>Higher Sec.</td>
                                            <td>Academy</td>
                                            <th>Session</th>
                                            <th>Recommended</th>
                                            <th>Recommended levels</th>
                                            <th>Applied Date</th>
                                            <th>Visited</th>
                                            <th>Date</th>

                                            <td>By</td>
                                            <th>DOCs</th>
                                            <th>NoteSheet</th>
                                            <th>File Status</th>
                                            <th>Issued</th>
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
                                        $query = "SELECT v. visit_id, v.schools_id, v.school_id, v.visit_reason, 
                                        v.primary_l,v.middle_l, v.high_l, v.high_sec_l, v.academy_l, 
                                        v.r_primary_l,v.r_middle_l, v.r_high_l, v.r_high_sec_l, v.r_academy_l, 
                                        v.visited, 
                                        v.visit_date,
                                        v.last_updated_by,
                                        v.recommendation,
                                        v.created_date,
                                        s.schoolName, s.registrationNumber,
                                        ss.level_of_school_id,
                                        (SELECT tehsilTitle FROM `tehsils` WHERE tehsils.tehsilId=s.tehsil_id) as tehsil,
                                        (SELECT `ucTitle` FROM `uc` WHERE uc.ucId=s.uc_id) as uc,
                                        s.uc_text,
                                        s.address,
                                        d.districtTitle,
                                        if((`d`.`new_region` = 1),'Central',if((`d`.`new_region` = 2),'South',if((`d`.`new_region` = 3),'Malakand',if((`d`.`new_region` = 4),'Hazara',if((`d`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                                        sy.sessionYearTitle,
                                        ss.principal_contact_no,
                                        ss.status,
                                        s.schoolMobileNumber,
                                        s.telePhoneNumber,
                                        s.docs,
                                        v.visit_status,
                                        ss.file_status,
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
                                            <td>
                                                <?php
                                                        $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$row->schools_id'";
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
                                            <td><?php echo $row->registrationNumber; ?></td>
                                            <td><?php echo $row->schoolName; ?></td>
                                            <td><?php echo $row->region; ?></td>
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
                                                <?php if($row->level_of_school_id==1){ echo "Primary"; } ?>
                                                <?php if($row->level_of_school_id==2){ echo "Middle"; } ?>
                                                <?php if($row->level_of_school_id==3){ echo "High"; } ?>
                                                <?php if($row->level_of_school_id==4){ echo "High Sec."; } ?>
                                            </td>

                                            <td><?php echo $row->visit_reason; ?></td>
                                            <td><?php echo $row->r_primary_l == 1 ? 'Primary, ' : '' ?></td>
                                            <td> <?php echo $row->r_middle_l == 1 ? 'Middle, ' : '' ?></td>
                                            <td>
                                                <?php echo $row->r_high_l == 1 ? 'High, ' : ''; ?></td>
                                            <td>
                                                <?php echo $row->r_high_sec_l == 1 ? 'Higher Sec. ' : ''  ?></td>
                                            <td>
                                                <?php echo $row->r_academy_l == 1 ? 'Academy ' : ''  ?></td>

                                            <td><?php echo $row->sessionYearTitle; ?></td>
                                            <td><?php if ($row->recommendation == 'Recommended') { ?>
                                                <span style="color: green;"><?php echo $row->recommendation; ?></span>
                                                <?php } else { ?>
                                                <span style="color: red;"><?php echo $row->recommendation; ?></span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $row->r_primary_l == 1 ? 'Primary, ' : '' ?>
                                                <?php echo $row->r_middle_l == 1 ? 'Middle, ' : '' ?>
                                                <?php echo $row->r_high_l == 1 ? 'High, ' : ''; ?>
                                                <?php echo $row->r_high_sec_l == 1 ? 'Higher Sec. ' : ''  ?>
                                                <?php echo $row->r_academy_l == 1 ? 'Academy ' : ''  ?>
                                            </td>
                                            <td><?php echo date('d M, Y', strtotime($row->created_date)); ?></td>
                                            <td><?php echo $row->visit_status; ?></td>
                                            <td><?php echo date('d M, Y', strtotime($row->visit_date)); ?></td>
                                            <td>
                                                <?php
                                                    $query = "SELECT userTitle FROM users WHERE userId = '" . $row->last_updated_by . "'";
                                                    $user = $this->db->query($query)->row();
                                                    if ($user) {
                                                        echo $user->userTitle;
                                                    }
                                                    ?>
                                            </td>
                                            <td>

                                                <?php 
                                                if($row->registrationNumber==""){
                                                if ($row->docs == 0) {
                                                            echo '<i style="color:red" class="fa fa-times-circle-o" aria-hidden="true"></i> No';
                                                        } ?>
                                                <?php if ($row->docs == 1) {
                                                            echo '<i style="color:green" class="fa fa-check-circle" aria-hidden="true"></i> Yes';
                                                        } 
                                                    }?>

                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                        $query = "SELECT COUNT(*) as total FROM `comments` WHERE school_id='" . $row->school_id . "' and schools_id = '" . $row->schools_id . "' and deleted=0";
                                                        $comments = $this->db->query($query)->row()->total;
                                                        if ($comments > 0) {
                                                            echo '<i title="Maybe notesheet completed" class="fa fa-comment" style="color:green" aria-hidden="true">Yes</i>';
                                                        }
                                                        ?>
                                            </td>
                                            <td>
                                                <?php echo file_status($row->file_status); ?>
                                            </td>
                                            <td>
                                                <?php if($row->status==1){
                                                    echo 'Issued';
                                                }else{
                                                    echo 'Pending';
                                                } ?>
                                            </td>

                                            <td>
                                                <?php if ($row->visited == 'Yes') { ?>
                                                <a target="new" class="btn btn-link btn-sm"
                                                    style="padding: 0px; margin:0px font-size:10px !important"
                                                    href="<?php echo site_url('visits/print_visit_report/' . $row->visit_id . '/' . $row->schools_id . '/' . $row->school_id); ?>">Print</a>
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