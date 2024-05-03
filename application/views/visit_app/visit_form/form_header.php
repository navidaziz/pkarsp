<!DOCTYPE html>
<html lang="en">

<head>
    <title>PSRA Visit Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site_url('assets/visits/styles.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

</style>

<body>

    <style>
        #preloader {
            display: none;
            position: fixed;
            z-index: 100000000;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: transparent;
            /* Add your additional styling here */
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        hr {
            margin-top: 1px;
            margin-bottom: 1px;
            border: 0;
            border-top: 1px solid #eee;
        }
    </style>
    <!-- Add a preloader element -->
    <div id="preloader" style="display: bloack;">
        <!-- <img src="https://psra.gkp.pk/institute/assets/loader.png" /> -->
    </div>
    <script>
        $(document).ready(function() {
            // Show preloader when the document is ready
            $('#preloader').show();

            // Hide preloader when the entire window (including all frames, objects, and images) is fully loaded
            setTimeout(function() {
                $('#preloader').hide();
            }, 100); // Adjust the delay time as needed

            // Show preloader when any AJAX request starts
            $(document).ajaxStart(function() {
                $('#preloader').show();
            });

            // Hide preloader when all AJAX requests complete
            $(document).ajaxStop(function() {
                $('#preloader').hide();
            });
        });
    </script>
    <nav class="navbar fixed-top" style="z-index: 1;">
        <a class="navbar-brand" href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '#'; ?>"><i class="fa fa-arrow-left" style="color: white;"></i></a>
        <a class="navbar-brand" href="#">S-ID: <?php echo $school->schools_id; ?> (<?php echo $input->visit_reason; ?>)</a>
        <div class="pull-right" id="">
            <a class="navbar-brand" href="<?php echo site_url("visit_app/school_detail/" . $school->schools_id) ?>"><i class="fa fa-home" style="color: white;"></i></a>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <main id="main" class="con tainer" style="height: 100%; padding:0px; margin-top:60px; ">
                    <div class="row">
                        <div class="col-xs-12 col-lg-offset-3 col-lg-6">
                            <?php if ($school) { ?>
                                <div class="alert alert-success" role="alert" style="margin-bottom: 5px;">

                                    <h4>
                                        <?php if ($school->registrationNumber > 0) { ?> REGISTRATION NO:
                                            <?php echo $school->registrationNumber ?>
                                        <?php } else {
                                            echo '<span style="color:#721c24">Not Registered Yet!</span>';
                                        } ?>
                                    </h4>
                                    <h4 class="alert-heading"><?php echo $school->schoolName; ?></h4>

                                    <hr>
                                    <?php if ($form == 'a') { ?>

                                        <p class="mb-0" style="text-align: left; color:inherit !important">
                                            <small style="color: inherit;">

                                                <?php if ($school->division) {
                                                    echo "Region: <strong style='color: inherit;' >" . $school->division . "</strong>";
                                                } else {
                                                    echo "Region: Null";
                                                } ?>
                                                <?php if ($school->districtTitle) {
                                                    echo " , District: <strong style='color: inherit;' >" . $school->districtTitle . "</strong>";
                                                } else {
                                                    echo "District: Null";
                                                } ?>
                                                <?php if ($school->tehsilTitle) {
                                                    echo " , Tehsil: <strong style='color: inherit;' >" . $school->tehsilTitle . "</strong>";
                                                } else {
                                                    echo " , Tehsil: Null";
                                                } ?>

                                                <?php if ($school->ucTitle) {
                                                    echo " , Unionconsil: <strong style='color: inherit;' >" . $school->ucTitle . "</strong>";
                                                } else {
                                                    echo " , Unionconsil: Null";
                                                } ?>

                                                <?php if ($school->address) {
                                                    echo " , Address:  <strong style='color: inherit;' >" . $school->address . "</strong>";
                                                } else {
                                                    echo " Address: Null";
                                                } ?>
                                            </small>
                                            <small>

                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <p class="mb-0" style="text-align: left; color:inherit">
                                                            <small>
                                                                <strong style="color:#3c763d">School Contact Details</strong>
                                                                <span style="display: block; color:#3c763d">Phone#: <strong>
                                                                        <a style="color:#0000CD" href="tel:<?php echo $school->phone_no; ?>"><?php echo $school->phone_no; ?></a>
                                                                    </strong>
                                                                </span>
                                                                <span style="display: block; color:#3c763d">Mobile#:
                                                                    <strong style="color:#3c763d">
                                                                        <a style="color:#0000CD" href="tel:<?php echo $school->mobile_no; ?>"><?php echo $school->mobile_no; ?></a>
                                                                    </strong>
                                                                </span>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <?php
                                                        $query = "SELECT principal_cnic,
                                                            principal,
                                                            principal_contact_no 
                                                            FROM school 
                                                            WHERE schoolId = '" . $school_id . "'";
                                                        $principal = $this->db->query($query)->row();
                                                        ?>
                                                        <strong style="color:#3c763d">(Principal / Director Info)</strong>
                                                        <span style="display: block; color:#3c763d">Name: <strong style="color:#3c763d"><?php echo $principal->principal; ?></strong></span>
                                                        <!-- <span style="display: block; color:#3c763d">CNIC: <strong style="color:#3c763d"><?php echo $principal->principal_cnic; ?></strong></span> -->
                                                        <span style="display: block; color:#3c763d">Contact No:
                                                            <strong style="color:#3c763d">
                                                                <a style="color:#0000CD" href="tel:<?php echo $principal->principal_contact_no; ?>">
                                                                    <?php echo $principal->principal_contact_no; ?>
                                                                </a>
                                                            </strong></span>
                                                    </div>
                                                    <?php if ($input->a == 0 and $input->picture_1) { ?>
                                                        <div class="col-xs-12" style="margin-top: 10px;">
                                                            <strong style="color:#3c763d">Detail of Owner / Owners </strong>
                                                            <?php
                                                            $all_owners = array();
                                                            $query = "SELECT u.userTitle as owner_name,
                                                        u.cnic as owner_cnic,
                                                        u.contactNumber as owner_contact_no FROM `schools` as s 
                                                            INNER JOIN users as u ON(u.userId = s.owner_id)
                                                            WHERE s.schoolId = '" . $input->schools_id . "'";
                                                            $owner = $this->db->query($query)->row();
                                                            $all_owners[$owner->owner_cnic] = $owner;
                                                            $query = "SELECT * FROM `school_owners` WHERE school_id = '" . $input->schools_id . "'";
                                                            $owners = $this->db->query($query)->result();
                                                            if ($owners) {
                                                                foreach ($owners as $owner) {
                                                                    $all_owners[$owner->owner_cnic] = $owner;
                                                                }
                                                            }

                                                            ?>

                                                            <style>
                                                                .table1>thead>tr>th,
                                                                .table1>tbody>tr>th,
                                                                .table1>tfoot>tr>th,
                                                                .table1>thead>tr>td,
                                                                .table1>tbody>tr>td,
                                                                .table1>tfoot>tr>td {
                                                                    color: #3c763d !important;
                                                                }
                                                            </style>
                                                            <table class="table1 table1_small">
                                                                <tr>
                                                                    <td>#</td>
                                                                    <td>Owner CNIC</td>
                                                                    <td>Owner Name</td>
                                                                    <td>Father Name</td>
                                                                    <td>Contact No.</td>
                                                                </tr>
                                                                <?php
                                                                $count = 1;
                                                                foreach ($all_owners as $owner_cnic => $owner) { ?>
                                                                    <tr>
                                                                        <td><?php echo $count++; ?></td>
                                                                        <td><?php echo $owner_cnic; ?></td>
                                                                        <td><?php echo $owner->owner_name; ?></td>
                                                                        <td><?php echo $owner->owner_father_name; ?></td>
                                                                        <td><?php echo $owner->owner_contact_no; ?></td>
                                                                    </tr>
                                                                <?php } ?>

                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </small>

                                        </p>
                                    <?php } ?>

                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger" role="alert" style="display: none;">
                                    <h4 class="alert-heading">Apologies!</h4>

                                    <p style="color: inherit;">Instititute not found.</p>
                                    <hr>
                                    <p class="mb-0">

                                    </p>
                                </div>
                            <?php } ?>
                            <?php if ($input->a == 1 and $input->picture_1 and $input->visited == 'No') { ?>
                                <style>
                                    .btn-form {
                                        display: inline-block;
                                        position: relative;
                                        width: 40px;
                                        margin: 1% 0 0 0;
                                        height: 40px;
                                        text-transform: uppercase;
                                        text-decoration: none;
                                        cursor: pointer;
                                        border: 1px solid black;
                                        border-radius: 25px;
                                        font-weight: 500;
                                        font-size: 1.2em;
                                        color: black;
                                        text-align: center;
                                        vertical-align: middle;
                                        background: lightgray;
                                        transition: color 0.25s ease;
                                        margin-left: 3px;
                                        box-shadow: 0 4px 2px -2px white;
                                        box
                                    }

                                    .complete {
                                        background: #DFEFD8;
                                        color: #3c763d;
                                        border: 1px solid #3c763d;
                                    }

                                    .current_btn {
                                        background: #F8D7D9;
                                        color: #721C23;
                                        border: 1px solid #721C23;
                                    }
                                </style>
                                <div id="sticky-header" style="position: sticky; top: 50px; z-index: 1000; background-color: #37404A;">
                                    <?php $this->load->helper('url');

                                    // Get the total segments in the URI
                                    $total_segments = $this->uri->total_segments();

                                    // Get the last segment
                                    $current_form = $this->uri->segment($total_segments);
                                    ?>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/a") ?>" class="btn btn-light btn-sm btn-form <?php if ($input->a == 1) {
                                                                                                                                                                                        echo 'complete';
                                                                                                                                                                                    } ?>
                                                                                                                                                                                <?php if ($current_form == 'a') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>
                                                                                                                                                                                ">A
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span>
                                    </a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/b") ?>" class="btn btn-light btn-sm btn-form <?php if ($input->b == 1) {
                                                                                                                                                                                        echo 'complete';
                                                                                                                                                                                    } ?>
                                                                                                                                                                                <?php if ($current_form == 'b') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">B
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/c") ?>" class="btn btn-light btn-sm btn-form <?php if ($input->c == 1) {
                                                                                                                                                                                        echo 'complete';
                                                                                                                                                                                    } ?>
                                                                                                                                                                                <?php if ($current_form == 'c') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">C
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/d") ?>" class="btn btn-light btn-sm btn-form <?php if ($input->d == 1) {
                                                                                                                                                                                        echo 'complete';
                                                                                                                                                                                    } ?>
                                                                                                                                                                                <?php if ($current_form == 'd') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">D
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/e") ?>" class="btn btn-light btn-sm btn-form <?php if ($input->e == 1) {
                                                                                                                                                                                        echo 'complete';
                                                                                                                                                                                    } ?>
                                                                                                                                                                                <?php if ($current_form == 'e') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">E
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/f") ?>" class="btn btn-dark btn-sm btn-form <?php if ($input->f == 1) {
                                                                                                                                                                                    echo 'complete';
                                                                                                                                                                                } ?>
                                                                                                                                                                                <?php if ($current_form == 'f') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">F
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/g") ?>" class="btn btn-dark btn-sm btn-form <?php if ($input->g == 1) {
                                                                                                                                                                                    echo 'complete';
                                                                                                                                                                                } ?>
                                                                                                                                                                                <?php if ($current_form == 'g') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">G
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>
                                    <a href="<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/h") ?>" class="btn btn-dark btn-sm btn-form <?php if ($input->h == 1) {
                                                                                                                                                                                    echo 'complete';
                                                                                                                                                                                } ?>
                                                                                                                                                                                <?php if ($current_form == 'h') {
                                                                                                                                                                                    echo 'current_btn';
                                                                                                                                                                                } ?>">H
                                        <span style="font-size: 7px; display:block; color:inherit; margin-top:-6px">Form</span></a>

                                    <hr style="margin-top:6px; margin-bottom:10px" />
                                </div>
                            <?php } ?>