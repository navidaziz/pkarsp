<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 80%; margin: auto;">
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
                <small><?php echo @$description; ?></small>
            </div>

        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="table-responsive">
            <table class="table table-bordered" id="visits">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>School Id</th>
                        <th>Registration No</th>
                        <th>Visit Reason</th>
                        <th>Primary</th>
                        <th>Middle</th>
                        <th>High</th>
                        <th>Higher Sec.</th>
                        <th>Academy</th>
                        <th>School Name</th>
                        <th>Session</th>
                        <th>Visited</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $query = "SELECT v.*,  
                    s.schoolName as school_name,
                    s.registrationNumber as registration_no,
                    session_year.sessionYearTitle as session
                    FROM visits as v
                    INNER JOIN schools as s ON(s.schoolId = v.schools_id)
                    INNER JOIN school as s_session ON(s_session.schoolId = v.school_id)
                    INNER JOIN session_year ON(session_year.sessionYearId = s_session.session_year_id)
                    WHERE v.is_deleted = 0
                    ";
                    $rows = $this->db->query($query)->result();
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td><a href="<?php echo site_url('visits/delete_visit/' . $row->visit_id); ?>" onclick="return confirm('Are you sure? you want to delete the record.')">Delete</a> </td>
                            <td><?php echo $count++ ?></td>
                            <td><?php echo $row->schools_id; ?></td>
                            <td><?php echo $row->registration_no; ?></td>
                            <td><?php echo $row->visit_reason; ?></td>
                            <td><?php if ($row->primary_l == 1) { ?> Primary <?php }  ?></td>
                            <td><?php if ($row->middle_l) { ?> Middle <?php }  ?></td>
                            <td><?php if ($row->high_l) { ?> High <?php }  ?></td>
                            <td><?php if ($row->high_sec_l) { ?> Higer Sec. <?php }  ?></td>
                            <td><?php if ($row->academy_l) { ?> Acadmey <?php }  ?></td>
                            <td><?php echo $row->school_name; ?></td>
                            <td><?php echo $row->session; ?></td>
                            <td><?php echo $row->visited; ?></td>

                            <td>
                                <button onclick="add_to_visit_list('<?php echo $row->visit_id; ?>')">Edit Visit</button>

                                <?php if ($row->visited == 'No') { ?>
                                    <button onclick="get_visit_form('<?php echo $row->visit_id; ?>')">Add Visit Report</button>
                                <?php } else { ?>
                                    <button onclick="get_visit_form('<?php echo $row->visit_id; ?>')">Update Visit Report</button>

                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div style="text-align: center;">
                <button onclick="get_visit_form('0')" class="btn btn-primary">Add Visit Report</button>
                <button onclick="add_to_visit_list('0')" class="btn btn-primary">Add To Visit List</button>
            </div>
        </div>
        <script>
            function add_to_visit_list(visit_id) {
                $('#modal').modal('show');
                if (visit_id == 0) {
                    $('#modal_title').html('Add To Visit List');
                } else {
                    $('#modal_title').html('Update Visit List');
                }
                $('#modal_body').html('wait . . . ');
                $.ajax({
                        method: "POST",
                        url: "<?php echo site_url('visits/get_add_to_visit_list_form'); ?>",
                        data: {
                            visit_id: visit_id
                        },
                    })
                    .done(function(respose) {

                        $('#modal_body').html(respose);
                    });
            }
        </script>
        <script>
            function get_visit_form(visit_id) {
                $('#modal').modal('show');
                $('#modal_title').html('Add Visit Report');
                $('#modal_body').html('wait . . . ');
                $.ajax({
                        method: "POST",
                        url: "<?php echo site_url('visits/get_visit_form'); ?>",
                        data: {
                            visit_id: visit_id
                        },
                    })
                    .done(function(respose) {

                        $('#modal_body').html(respose);
                    });
            }
        </script>


    </section>
</div>