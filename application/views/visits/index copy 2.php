<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Bootstrap Theme</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" style="padding: 10px;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<body>
    <div style="padding: 5px;">
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

            <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary">
                <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom" contenteditable="false" style="cursor: pointer;">
                    <svg class="bi pe-none me-2" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-5 fw-semibold">Visit List</span>
                </a>
                <div class="list-group list-group-flush border-bottom scrollarea">
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
                    <a href="#" class="list-group-item list-group-item-action active py-3 lh-sm" aria-current="true" contenteditable="false" style="cursor: pointer;">
                    <td><a href="<?php echo site_url('visits/delete_visit/' . $row->visit_id); ?>" onclick="return confirm('Are you sure? you want to delete the record.')">Delete</a> </td>
                                
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
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small>Wed</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <?php ?>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Tues</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Mon</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Wed</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Tues</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Mon</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Wed</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Tues</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Mon</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Wed</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Tues</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-sm" contenteditable="false" style="cursor: pointer;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <strong class="mb-1">List group item heading</strong>
                            <small class="text-body-secondary">Mon</small>
                        </div>
                        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
                    </a>
                </div>
            </div>

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

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>