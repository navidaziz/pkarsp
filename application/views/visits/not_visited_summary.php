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

                                <table class="table table-bordered" id="visits_list">
                                    <thead>
                                        <tr>

                                            <th>Regions</th>
                                            <th>Districts</th>
                                            <?php
                                            $options = array("New Registration", "Renewal", "Upgradation", "Change of Location", "Closure of School");
                                            foreach ($options as $option) { ?>
                                                <th><?php echo $option; ?></th>
                                            <?php }  ?>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $query = "SELECT `d`.`new_region`,
                                        `d`.`new_region` AS `new_region`,if((`d`.`new_region` = 1),'Central',if((`d`.`new_region` = 2),'South',if((`d`.`new_region` = 3),'Malakand',if((`d`.`new_region` = 4),'Hazara',if((`d`.`new_region` = 5),'Peshawar','Others'))))) AS `region`
                                         FROM district as d 
                                         GROUP BY d.new_region
                                         ORDER BY d.new_region ASC";
                                        $regions = $this->db->query($query)->result();
                                        foreach ($regions as $region) {  ?>
                                            <?php $query = "SELECT
                                            `d`.`districtId`,
                                            `d`.`districtTitle`,
                                            `d`.`new_region` AS `new_region`,if((`d`.`new_region` = 1),'Central',if((`d`.`new_region` = 2),'South',if((`d`.`new_region` = 3),'Malakand',if((`d`.`new_region` = 4),'Hazara',if((`d`.`new_region` = 5),'Peshawar','Others'))))) AS `region`
                                            FROM district as d
                                            WHERE d.new_region = $region->new_region
                                            ORDER BY d.new_region ASC, d.districtTitle ASC
                                            ";
                                            $rows = $this->db->query($query)->result();
                                            $count = 1;
                                            foreach ($rows as $row) {

                                            ?>
                                                <tr>

                                                    <td style="text-align: right;"><?php echo $count++ ?></td>
                                                    <td><?php echo $row->districtTitle; ?></td>
                                                    <?php
                                                    $total = 0;
                                                    $options = array("New Registration", "Renewal", "Upgradation", "Change of Location", "Closure of School");
                                                    foreach ($options as $option) {
                                                        $query = "SELECT COUNT(v.visit_id) as total FROM visits as v 
                                                    INNER JOIN schools as s ON(s.schoolId = v.schools_id)
                                                    WHERE s.district_id = '" . $row->districtId . "'
                                                    AND v.visit_reason = '" . $option . "'
                                                    AND visited ='No'";
                                                        $count_visits = $this->db->query($query)->row()->total;
                                                        $total += $count_visits;
                                                    ?>
                                                        <td style="text-align: center;"><?php echo $count_visits; ?></td>
                                                    <?php }  ?>
                                                    <td style="text-align: center;"><?php echo $total; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>

                                                <th><?php echo $region->region; ?></th>
                                                <th>Total</th>
                                                <?php
                                                $total = 0;
                                                $options = array("New Registration", "Renewal", "Upgradation", "Change of Location", "Closure of School");
                                                foreach ($options as $option) {
                                                    $query = "SELECT COUNT(v.schools_id) as total FROM visits as v 
                                                    INNER JOIN schools as s ON(s.schoolId = v.schools_id)
                                                    INNER JOIN district as d ON(d.districtId = s.district_id)
                                                    WHERE d.new_region = '" . $region->new_region . "'
                                                    AND v.visit_reason = '" . $option . "'
                                                    AND visited ='No'";
                                                    $count_visits = $this->db->query($query)->row()->total;
                                                    $total += $count_visits;
                                                ?>
                                                    <th style="text-align: center;"><?php echo $count_visits; ?></th>
                                                <?php }  ?>
                                                <th style="text-align: center;"><?php echo $total; ?></th>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>

                                            <th></th>
                                            <th>Total</th>
                                            <?php
                                            $total = 0;
                                            $options = array("New Registration", "Renewal", "Upgradation", "Change of Location", "Closure of School");
                                            foreach ($options as $option) {
                                                $query = "SELECT COUNT(v.visit_id) as total FROM visits as v 
                                                    INNER JOIN schools as s ON(s.schoolId = v.schools_id)
                                                    INNER JOIN district as d ON(d.districtId = s.district_id)
                                                    AND v.visit_reason = '" . $option . "'
                                                    AND visited ='No'";
                                                $count_visits = $this->db->query($query)->row()->total;
                                                $total += $count_visits;
                                            ?>
                                                <th style="text-align: center;"><?php echo $count_visits; ?></th>
                                            <?php }  ?>
                                            <th style="text-align: center;"><?php echo $total; ?></th>
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>







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
        document.title = "List of Not Visited Region Wise Summary Till Now (<?php echo date('d-m-y h:m:s') ?>)";
        $('#visits_list').DataTable({
            dom: 'Bfrtip',
            paging: false,
            searching: false,
            ordering: false, // Enable sorting
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