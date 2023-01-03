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
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:90%;">
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
        padding: 3px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        background-color: transparent !important;
    }
</style>

<div class="content-wrapper">

    <section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;" />

    <!-- Small boxes (Stat box) -->
    <div class="row">

        <div class="col-lg-2">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php
                        $query = "SELECT COUNT(0) as total FROM school
                        WHERE DATE(school.dairy_date) = DATE(NOW())";
                        echo $this->db->query($query)->row()->total;
                        ?>
                    </h3>
                    <p>
                        Today Total Cases
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                </div>
                <!-- <a href="list_user.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a> -->
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php
                        $query = "SELECT COUNT(0) as total FROM school
                        WHERE DATE(school.dairy_date) = DATE(NOW())
                        AND school.dairy_type = 'Post'";
                        echo $this->db->query($query)->row()->total;
                        ?>
                    </h3>
                    <p>
                        Today Total By POST
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <!-- <a href="list_user.php" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a> -->
            </div>
        </div>
        <div class="col-lg-2">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php
                        $query = "SELECT COUNT(0) as total FROM school
                        WHERE DATE(school.dairy_date) = DATE(NOW())
                        AND school.dairy_type = 'Hand'";
                        echo $this->db->query($query)->row()->total;
                        ?>
                    </h3>
                    <p>
                        Today Total By HAND
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-hand-paper-o"></i>
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="block_div">
                <h1>Search School By School ID</h1>
                <table class="table">
                    <td>
                        <strong>Search By</strong>
                        <span style="margin-left: 15px;"></span>
                        <input type="radio" name="search_type" class="search_type" value="school_id" checked /> School ID
                    </td>
                    <td>

                        <input type="text" id="search" name="search" value="" class="form-control" />
                    </td>
                    <td><button class="btn btn-success" onclick="search()">Search</button></td>
                    <script>
                        function search() {
                            var search = $('#search').val();
                            var district_id = $('#district_id').val();
                            var district_name = $('#district_id :selected').text();
                            var search_by = $('input[name="search_type"]:checked').val();

                            $.ajax({
                                    method: "POST",
                                    url: "<?php echo site_url('reception/school_detail'); ?>",
                                    data: {
                                        search: search,
                                        district_id: district_id,
                                        district_name: district_name,
                                        search_by: search_by,
                                        type: '<?php echo $type; ?>',
                                        region: '<?php echo $region; ?>'
                                    },
                                })
                                .done(function(respose) {
                                    $('#modal_body').html(respose);
                                    $('#modal').modal('show');
                                    $('#modal_title').html("Assign Dairy Number");
                                });
                        }
                    </script>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $query = "SELECT * FROM district GROUP BY region ASC";
        $regions = $this->db->query($query)->result();
        foreach ($regions as $region) { ?>
            <div class="col-lg-3 col-xs-12">
                <div class="small-box bg-blue" style="padding-bottom: 10px;  ">
                    <div style="background-color: #004268;">
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
                            <span class="pull-right" style="font-size: 30px;">
                                <?php
                                $query = "SELECT COUNT(0) as total FROM school
                                INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                INNER JOIN district ON district.districtId = schools.district_id
                                WHERE district.region = '$region->region'
                                AND DATE(school.dairy_date) = DATE(NOW())";
                                echo $this->db->query($query)->row()->total;
                                ?>
                            </span>
                        </h3>
                    </div>
                    <div style="padding: 5px; min-height:370px;">
                        <table class="table">
                            <tr>

                                <th colspan="5" style="text-align: center;">Today Cases</th>
                            </tr>
                            <tr>

                                <td>#</td>
                                <td>District Name</td>
                                <td>By POST</td>
                                <td>By Hand</td>
                                <td>Total</td>


                            </tr>
                            <?php $query = "SELECT * FROM district WHERE region = '$region->region'";
                            $districts = $this->db->query($query)->result();
                            $count = 1;
                            foreach ($districts as $district) { ?>


                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $district->districtTitle;  ?></td>
                                    <td style="text-align: center;">
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND district.districtId = '$district->districtId'
                                        AND school.dairy_type = 'Post'";
                                        echo $this->db->query($query)->row()->total;

                                        ?>
                                    </td>

                                    <td style="text-align: center;">
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND district.districtId = '$district->districtId'
                                        AND school.dairy_type = 'Hand'";
                                        echo $this->db->query($query)->row()->total;

                                        ?>
                                    </td>

                                    <td style="text-align: center;">
                                        <?php
                                        $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND district.districtId = '$district->districtId'";
                                        echo $this->db->query($query)->row()->total;

                                        ?>
                                    </td>
                                </tr>


                            <?php  }  ?>
                            <tr>
                                <td colspan="2" style="text-align: right;">Total</td>
                                <td style="text-align: center;">
                                    <?php
                                    $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND school.dairy_type = 'Post'";
                                    echo $this->db->query($query)->row()->total;

                                    ?>
                                </td>

                                <td style="text-align: center;">
                                    <?php
                                    $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND DATE(school.dairy_date) = DATE(NOW())
                                        AND school.dairy_type = 'Hand'";
                                    echo $this->db->query($query)->row()->total;

                                    ?>
                                </td>

                                <td style="text-align: center;">
                                    <?php
                                    $query = "SELECT COUNT(0) as total FROM school
                                        INNER JOIN schools as schools ON schools.schoolId = school.schools_id
                                        INNER JOIN district ON district.districtId = schools.district_id
                                        WHERE district.region = '$region->region'
                                        AND DATE(school.dairy_date) = DATE(NOW())";
                                    echo $this->db->query($query)->row()->total;

                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        <?php  }  ?>





        <div class="clearfix"></div>


        <!-- Main row -->
        <!-- /.row (main row) -->

    </div>


    </section>
</div>