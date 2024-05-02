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

    <!-- Header Bar -->
    <nav class="navbar fixed-top" style="z-index: 1;">
        <a class="navbar-brand" href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '#'; ?>"><i class="fa fa-arrow-left"></i></a>
        <a class="navbar-brand" href="#">PSRA Visit APP</a>


        <div class="pull-right" id="">
            <a class="navbar-brand" href="<?php echo site_url("visits/index") ?>"><i class="fa fa-home"></i></a>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <div class="col-sm-12">

                <main id="main" class="con tainer" style="height: 100%; padding:0px; margin-top:60px; ">
                    <div class="row">
                        <div class="col-xs-12 col-lg-offset-3 col-lg-6">

                            <?php if ($school) { ?>
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading pull-left">Ins. ID: <?php echo $school->schools_id; ?></h4>
                                    <h4 class="alert-heading pull-right">
                                        <?php if ($school->registrationNumber > 0) { ?> REG. No:
                                            <?php echo $school->registrationNumber ?>
                                        <?php } else {
                                            echo '<span style="color:#721c24">Not Registered Yet!</span>';
                                        } ?>
                                    </h4>
                                    <div style="clear: both;"></div>
                                    <h4><?php echo $school->schoolName; ?></h4>
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
                                    <hr>



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
                                            <p class="mb-0" style="text-align: left; color:inherit">
                                                <small>
                                                    <strong style="color:#3c763d">Other Contact No:</strong>
                                                    <span style="display: block; color:#3c763d">Mobile#:
                                                        <strong style="color:#3c763d">
                                                            <a style="color:#0000CD" href="tel:<?php echo $school->owner_no; ?>"><?php echo $school->owner_no; ?></a>
                                                        </strong>
                                                    </span>
                                                </small>
                                            </p>
                                        </div>
                                    </div>




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
                            <style>
                                .list-group-item-1 {
                                    position: -webkit-sticky;
                                    /* For Safari */
                                    position: sticky;
                                    top: 0;
                                    z-index: 1;
                                    background-color: #DFEFD8 !important;
                                    color: #3B763D !important;
                                    font-weight: bold;
                                    border: 1px solid #3B763D;
                                }
                            </style>
                            <ul class="list-group" style="font-size: 12px; height:430px;  overflow-y: auto; color:black; margin-bottom:50px">
                                <li class="list-group-item list-group-item-1">
                                    <strong style="color: #3B763D !important;">Visit List</strong>
                                </li>
                                <li class="list-group-item list-group-item-1" style="margin-bottom: 3px;">
                                    <div class="row">
                                        <div class="col-xs-4" style="color: #3B763D !important;">
                                            Visit Reason
                                        </div>
                                        <div class="col-xs-6" style="color: #3B763D !important;">
                                            Levels
                                        </div>

                                        <div class="col-xs-2" style="color: #3B763D !important;">
                                            Visited
                                        </div>
                                    </div>
                                </li>
                                <?php
                                $count = 1;
                                $query = "SELECT * FROM visits";
                                $rows = $this->db->query($query)->result();
                                foreach ($rows as $row) {

                                    $labels = array();

                                    if ($row->primary_l == 1) {
                                        $labels[] = "Primary";
                                    }

                                    if ($row->middle_l == 1) {
                                        $labels[] = "Middle";
                                    }

                                    if ($row->high_l == 1) {
                                        $labels[] = "High";
                                    }

                                    if ($row->high_sec_l == 1) {
                                        $labels[] = "Higher Sec.";
                                    }

                                    if ($row->academy_l == 1) {
                                        $labels[] = "Academy";
                                    }
                                ?>
                                    <a href="<?php echo site_url("visits/institute_visit_report/" . $row->visit_id . "/" . $row->schools_id . "/" . $row->school_id . '/a') ?>">
                                        <li class="list-group-item" style="background-color: transparent;">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <?php //echo $count++ 
                                                    ?> <?php echo $row->visit_reason; ?>
                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo implode(', ', $labels);  ?>

                                                </div>
                                                <div class="col-xs-2">
                                                    <?php echo $row->session; ?>
                                                </div>
                                                <div class="col-xs-2">
                                                    <?php echo $row->visited; ?>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                <?php } ?>
                            </ul>


                        </div>
                    </div>

                </main>

            </div>

        </div>
    </div>
    <footer class="footer fixed-bottom">
        <div class="container text-center" style=" color: white;">
            &copy; 2024 PSRA. All rights reserved.
        </div>
    </footer>
</body>

</html>