<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 90%;">
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
            <div class="col-lg-12 col-xs-12">
                <div class="block_div">


                    <table class="table table-bordered">
                        <td>
                            <strong>Search By</strong>
                            <span style="margin-left: 15px;"></span>
                            <input type="radio" name="search_type" class="search_type" value="school_id" checked /> School ID
                        </td>
                        <td>

                            <input type="text" id="search" name="search" placeholder="School ID" value="" class="form-control" />
                        </td>
                        <td><button onclick="search()">Search</button></td>
                        </tr>
                    </table>

                </div>
            </div>

            <?php
            $userId = $this->session->userdata('userId');
            $query = "select district_ids From users WHERE userId = '" . $userId . "'";
            $district_ids = $this->db->query($query)->row()->district_ids;
            if ($district_ids) {
                $districtId = "  " . $districtId . "  ";
            } else {
                $districtId = " 1=1 ";
            }

            $query = "SELECT * FROM district WHERE  " . $districtId . "  GROUP BY region ASC";
            $regions = $this->db->query($query)->result();
            foreach ($regions as $region) { ?>
                <div class="col-lg-3 col-xs-12">
                    <div class="sma ll-box" style="padding-bottom: 10px; background-color:#5C9ACC; color:white; ">
                        <div style="background-color: #5C9ACC; padding-left:5px; padding-right:5px">
                            <h3 style="padding: 3px;">
                                <?php if ($region->region == 1) {
                                    echo "Central";
                                } ?>
                                <?php if ($region->region == 2) {
                                    echo "South";
                                } ?>
                                <?php if ($region->region == 3) {
                                    echo "Malakand";
                                } ?>
                                <?php if ($region->region == 4) {
                                    echo "Hazara";
                                } ?>
                                <span class="pull-right" style="font-size: 25px;">
                                    <?php
                                    $query = "SELECT COUNT(0) as total FROM schools
                              INNER JOIN district ON district.districtId = schools.district_id
                              WHERE district.region = '$region->region'
                              AND schools.registrationNumber > 0";
                                    echo $this->db->query($query)->row()->total;
                                    ?>
                                </span>
                            </h3>
                        </div>
                        <div style="padding: 5px;">
                            <table class="table" style="text-align: center; font-size:12px">
                                <tr>

                                    <th colspan="6" style="text-align: center;">Pending Cases</th>
                                </tr>
                                <tr>

                                    <td>#</td>
                                    <td>District</td>
                                    <td>Total(Reg.)</td>
                                    <td>Reception</td>
                                    <td>Visit Pending</td>
                                    <td>Deficient</td>

                                </tr>
                                <?php

                                $query = "SELECT * FROM district WHERE   " . $districtId . "  AND  region = '$region->region'";
                                $districts = $this->db->query($query)->result();
                                $count = 1;
                                foreach ($districts as $district) { ?>


                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $district->districtTitle;  ?></td>
                                        <td>
                                            <?php
                                            $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE district.districtId = '$district->districtId'
                                            AND schools.registrationNumber > 0";
                                            echo $this->db->query($query)->row()->total;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND district.districtId = '$district->districtId'
                                        AND school.status!=1
                                        AND school.dairy_type != ''
                                        AND school.pending_type IS NULL
                                        ";
                                            echo $this->db->query($query)->row()->total;

                                            ?> -
                                            <?php
                                            $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND district.districtId = '$district->districtId'
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND school.status!=1
                                        AND school.dairy_type != ''";
                                            echo $this->db->query($query)->row()->total;

                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN school ON (school.schools_id = schools.schoolId)
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE district.districtId = '" . $district->districtId . "'
                                            AND visit_list=1
                                            AND school.status!=1";
                                            echo $this->db->query($query)->row()->total;
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN school ON (school.schools_id = schools.schoolId)
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE district.districtId = '" . $district->districtId . "'
                                            AND school.status!=1
                                            AND school.pending_type = 'Deficiency'";
                                            echo $this->db->query($query)->row()->total;
                                            ?>
                                            - <?php
                                                $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN school ON (school.schools_id = schools.schoolId)
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE district.districtId = '" . $district->districtId . "'
                                            AND school.status!=1
                                            AND school.pending_type = 'Deficiency'
                                            AND DATE(school.pending_date) = DATE(NOW())";
                                                echo $this->db->query($query)->row()->total;
                                                ?>


                                        </td>
                                    </tr>


                                <?php  }  ?>

                                <tr>
                                    <td style="text-align: right;" colspan="2">Total:</td>
                                    <td>
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE  
                                            district.region = '$region->region'
                                            AND " . $districtId . " 
                                            AND schools.registrationNumber > 0";
                                        echo $this->db->query($query)->row()->total;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND " . $districtId . " 
                                        AND school.status!=1
                                        AND school.dairy_type != ''
                                        AND school.pending_type IS NULL";
                                        echo $this->db->query($query)->row()->total;

                                        ?> -
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND " . $districtId . " 
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND school.status!=1
                                        AND school.dairy_type != ''";
                                        echo $this->db->query($query)->row()->total;

                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN school ON (school.schools_id = schools.schoolId)
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE visit_list=1
                                           AND  district.region = '$region->region'
                                            AND " . $districtId . " 
                                            AND school.status!=1";
                                        echo $this->db->query($query)->row()->total;
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN school ON (school.schools_id = schools.schoolId)
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE school.status!=1
                                            AND  district.region = '$region->region'
                                            AND " . $districtId . " 
                                            AND school.pending_type = 'Deficiency'";
                                        echo $this->db->query($query)->row()->total;
                                        ?>
                                        - <?php
                                            $query = "SELECT COUNT(0) as total FROM schools
                                            INNER JOIN school ON (school.schools_id = schools.schoolId)
                                            INNER JOIN district ON district.districtId = schools.district_id
                                            WHERE  school.status!=1
                                            AND  district.region = '$region->region'
                                            AND school.pending_type = 'Deficiency'
                                            AND " . $districtId . " 
                                            AND DATE(school.pending_date) = DATE(NOW())";
                                            echo $this->db->query($query)->row()->total;
                                            ?>


                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            <?php  }  ?>
            <script>
                function open_visit_modal() {
                    $('#modal').modal('show');
                    $('#modal_title').html("Add School In Visit List");
                    $.ajax({
                        url: '<?php echo base_url(); ?>record_room/get_visit_list_form',
                        type: 'POST',
                        data: {
                            'region': '1'
                        },
                        success: function(data) {
                            $('#modal_body').html(data);
                        }
                    });
                }

                function open_upgradation_modal() {
                    $('#modal').modal('show');
                    $('#modal_title').html("Add School In Upgradation Visit List");
                }
            </script>






            <div class="clearfix"></div>


            <!-- Main row -->
            <!-- /.row (main row) -->

        </div>


    </section>
</div>

<script>
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