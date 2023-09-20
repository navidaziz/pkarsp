<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mockup</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Highcharts library from CDN -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>

</head>
<style>
    .table_small>tbody>tr>td,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>td,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>thead>tr>th {
        padding: 2px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 9px;
        text-align: center;
    }

    .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl {
        max-width: 100%;
    }
</style>


<body>


    <!-- Dashboard Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                <?php
                $query = "SELECT * FROM session_year";
                $sessions  = $this->db->query($query)->result();

                ?>
                <table class="datatable table table_small table-bordered" id="yearly_and_monthly_progress_report">
                    <thead>
                        <tr>
                            <th colspan="7">Session Wise Registration / Renewals / Upgradation Report</th>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <?php foreach ($sessions as $session) { ?>
                                <th><?php echo $session->sessionYearTitle; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Registration</td>
                            <?php
                            $total_registration = 0;
                            foreach ($sessions as $session) {
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE renewal_code<=0 and session_year_id='" . $session->sessionYearId . "';";
                                $report = $this->db->query($query)->row();
                                $session->commulative_registration = $total_registration += $report->total;
                                $session->new_registration = $report->total;
                            ?>
                                <td><?php echo $report->total; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>Comulative</th>
                                <?php
                                foreach ($sessions as $session) { ?>
                            <td><?php echo $session->commulative_registration; ?></td>
                        <?php } ?>
                        </tr>
                        <tr>
                            <td>Renewals</td>
                            <?php
                            foreach ($sessions as $session) {
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE renewal_code>0 and session_year_id='" . $session->sessionYearId . "';";
                                $report = $this->db->query($query)->row();
                                $session->renewals = $report->total;
                            ?>
                                <td><?php echo $report->total; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>Renewals %</td>
                            <?php
                            foreach ($sessions as $session) {
                            ?>
                                <td><?php
                                    if ($session->commulative_registration - $session->new_registration > 0) {
                                        echo  round(($session->renewals / ($session->commulative_registration - $session->new_registration)) * 100, 2) . " % ";
                                    } ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>Remaining</td>
                            <?php
                            foreach ($sessions as $session) {
                            ?>
                                <td><?php echo ($session->commulative_registration - $session->new_registration) - $session->renewals; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td>Upgradation</td>
                            <?php foreach ($sessions as $session) {
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE upgrade = 1 and session_year_id='" . $session->sessionYearId . "';";
                                $report = $this->db->query($query)->row();
                            ?>
                                <td><?php echo $report->total; ?></td>
                            <?php } ?>
                        </tr>
                    </tbody>

                </table>

                <?php
                $query = "SELECT 
                IF(current_level=1,'Primary',
                  IF(current_level=2, 'Middle',
                    IF(current_level=3, 'High', 
                       IF(current_level=4, 'High Secondary',
                           IF(current_level=5, 'Academies', 'Others')
                         )))) as level,
                         current_level as current_level_id,
                         count(*) as total
                FROM `processed_cases` WHERE renewal_code<=0
                GROUP BY current_level;";
                $reports = $this->db->query($query)->result();
                ?>
                <table class="datatable table table_small table-bordered">
                    <thead>
                        <tr>
                            <th>Levels</th>
                            <th>Total</th>
                            <th>New Registered</th>
                            <th>Upgradation</th>
                            <th>Latest Renewals</th>
                            <th>Renewals %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report) { ?>
                            <tr>
                                <th><?php echo $report->level ?></th>
                                <td><?php echo $report->total ?></td>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code<=0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) and current_level='" . $report->current_level_id . "';";
                                $current_registered = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_registered->total; ?></th>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) and upgrade=1 and current_level='" . $report->current_level_id . "';";
                                $current_upgradation = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_upgradation->total; ?></th>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) and current_level='" . $report->current_level_id . "';";
                                $current_renewal = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_renewal->total; ?></th>
                                <th>
                                    <?php
                                    echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                                    ?>
                                </th>

                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <?php $query = "SELECT 
                                        current_level as current_level_id,
                                        count(*) as total
                                        FROM `processed_cases` WHERE renewal_code<=0";
                        $report = $this->db->query($query)->row();
                        ?>
                        <tr>
                            <th>Total</th>
                            <th><?php echo $report->total ?></th>

                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code<=0 and session_year_id='6' ";
                            $current_registered = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_registered->total; ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id='6' and upgrade=1 ;";
                            $current_upgradation = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_upgradation->total; ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id='6';";
                            $current_renewal = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_renewal->total; ?></th>
                            <th>
                                <?php
                                echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                                ?>
                            </th>

                        </tr>
                    </tfoot>
                </table>



                <?php
                $query = "SELECT 
                 if((`new_region` = 1),'Central',if((`new_region` = 2),'South',if((`new_region` = 3),'Malakand',if((`new_region` = 4),'Hazara',if((`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                 new_region,
                 count(*) as total
                 FROM `processed_cases` WHERE renewal_code<=0
                GROUP BY new_region;";
                $reports = $this->db->query($query)->result();
                ?>
                <table class="datatable table table_small ">
                    <thead>
                        <tr>
                            <th>Levels</th>
                            <th>Total</th>
                            <th>New Registered</th>
                            <th>Upgradation</th>
                            <th>Latest Renewals</th>
                            <th>Renewals %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report) { ?>
                            <tr>
                                <th><?php echo $report->region ?></th>
                                <td><?php echo $report->total ?></td>

                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code<=0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) 
                            and new_region='" . $report->new_region . "';";
                                $current_registered = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_registered->total; ?></th>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) and upgrade=1 
                            and new_region='" . $report->new_region . "';";
                                $current_upgradation = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_upgradation->total; ?></th>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) 
                            and new_region='" . $report->new_region . "';";
                                $current_renewal = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_renewal->total; ?></th>
                                <th>
                                    <?php
                                    if ($report->total - $current_registered->total) {
                                        echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                                    }
                                    ?>
                                </th>

                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <?php $query = "SELECT 
                                        current_level as current_level_id,
                                        count(*) as total
                                FROM `processed_cases` WHERE renewal_code<=0";
                        $report = $this->db->query($query)->row();
                        ?>
                        <tr>
                            <th>Total</th>
                            <th><?php echo $report->total ?></th>

                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code<=0 and session_year_id='6' ";
                            $current_registered = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_registered->total; ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id='6' and upgrade=1 ;";
                            $current_upgradation = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_upgradation->total; ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id='6';";
                            $current_renewal = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_renewal->total; ?></th>
                            <th>
                                <?php
                                echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                                ?>
                            </th>

                        </tr>
                    </tfoot>
                </table>



                <?php
                $query = "SELECT 
                 districtTitle,
                 districtId,
                 count(*) as total
                FROM `processed_cases` WHERE renewal_code<=0
                GROUP BY districtTitle;";
                $reports = $this->db->query($query)->result();
                ?>
                <table class="datatable table table_small ">
                    <thead>
                        <tr>
                            <th>District</th>
                            <th>Total</th>
                            <th>New Registered</th>
                            <th>Upgradation</th>
                            <th>Latest Renewals</th>
                            <th>Renewals %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report) { ?>
                            <tr>
                                <th><?php echo $report->districtTitle ?></th>
                                <td><?php echo $report->total ?></td>

                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code<=0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) 
                            and districtId='" . $report->districtId . "';";
                                $current_registered = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_registered->total; ?></th>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) and upgrade=1 
                            and districtId='" . $report->districtId . "';";
                                $current_upgradation = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_upgradation->total; ?></th>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id=(SELECT sessionYearId FROM `session_year` WHERE status=1) 
                            and districtId='" . $report->districtId . "';";
                                $current_renewal = $this->db->query($query)->row();
                                //$session->commulative_registration = $total_registration += $report->total;
                                //$session->new_registration = $report->total;
                                ?>
                                <th><?php echo $current_renewal->total; ?></th>
                                <th>
                                    <?php
                                    if ($report->total - $current_registered->total) {
                                        echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                                    }
                                    ?>
                                </th>

                            </tr>
                        <?php } ?>
                        <?php $query = "SELECT 
                                        current_level as current_level_id,
                                        count(*) as total
                                FROM `processed_cases` WHERE renewal_code<=0";
                        $report = $this->db->query($query)->row();
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th><?php echo $report->total ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code<=0 and session_year_id='6' ";
                            $current_registered = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_registered->total; ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id='6' and upgrade=1 ;";
                            $current_upgradation = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_upgradation->total; ?></th>
                            <?php
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` 
                            WHERE renewal_code>0 and session_year_id='6';";
                            $current_renewal = $this->db->query($query)->row();
                            //$session->commulative_registration = $total_registration += $report->total;
                            //$session->new_registration = $report->total;
                            ?>
                            <th><?php echo $current_renewal->total; ?></th>
                            <th>
                                <?php
                                echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                                ?>
                            </th>

                        </tr>
                    </tfoot>
                </table>


            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-7">

                        <?php
                        $query = "SELECT
                                    YEAR(cer_issue_date) as Year,
                                    SUM(IF(cer_issue_date,1,0)) as `total`,
                                    SUM(IF(MONTH(cer_issue_date)=04,1,0)) as `Apr`,
                                    SUM(IF(MONTH(cer_issue_date)=05,1,0)) as `May`,
                                    SUM(IF(MONTH(cer_issue_date)=06,1,0)) as `Jun`,
                                    SUM(IF(MONTH(cer_issue_date)=07,1,0)) as `Jul`,
                                    SUM(IF(MONTH(cer_issue_date)=08,1,0)) as `Aug`,
                                    SUM(IF(MONTH(cer_issue_date)=09,1,0)) as `Sep`,
                                    SUM(IF(MONTH(cer_issue_date)=10,1,0)) as `Oct`,
                                    SUM(IF(MONTH(cer_issue_date)=11,1,0)) as `Nov`,
                                    SUM(IF(MONTH(cer_issue_date)=12,1,0)) as `Dec`,
                                    SUM(IF(MONTH(cer_issue_date)=01,1,0)) as `Jan`,
                                    SUM(IF(MONTH(cer_issue_date)=02,1,0)) as `Feb`,
                                    SUM(IF(MONTH(cer_issue_date)=03,1,0)) as `Mar`
                                    FROM `processed_cases`
                                    GROUP BY YEAR(cer_issue_date)
                                    ORDER BY YEAR(cer_issue_date) DESC";
                        $reports  = $this->db->query($query)->result();

                        ?>
                        <table class="table table_small table-bordered" id="yearly_and_monthly_progress_report">
                            <tr>
                                <th colspan="14">Yearly and monthly progress report</th>
                            </tr>

                            <tr>
                                <th>Year</th>
                                <th>Apr</th>
                                <?php if (date('m') == '04') { ?> <td> * </td><?php } ?>
                                <th>May</th>
                                <?php if (date('m') == '05') { ?> <td> * </td><?php } ?>
                                <th>Jun</th>
                                <?php if (date('m') == '06') { ?> <td> * </td><?php } ?>
                                <th>Jul</th>
                                <?php if (date('m') == '07') { ?> <td> * </td><?php } ?>
                                <th>Aug</th>
                                <?php if (date('m') == '08') { ?> <td> * </td><?php } ?>
                                <th>Sep</th>
                                <?php if (date('m') == '09') { ?> <td> * </td><?php } ?>
                                <th>Oct</th>
                                <?php if (date('m') == '10') { ?> <td> * </td><?php } ?>
                                <th>Nov</th>
                                <?php if (date('m') == '11') { ?> <td> * </td><?php } ?>
                                <th>Dec</th>
                                <?php if (date('m') == '12') { ?> <td> * </td><?php } ?>
                                <th>Jan</th>
                                <?php if (date('m') == '01') { ?> <td> * </td><?php } ?>
                                <th>Feb</th>
                                <?php if (date('m') == '02') { ?> <td> * </td><?php } ?>
                                <th>Mar</th>
                                <?php if (date('m') == '03') { ?> <td> * </td><?php } ?>
                                <th>Yearly Total</th>
                            </tr>

                            <?php foreach ($reports as $report) { ?>
                                <tr>
                                    <th><?php echo $report->Year ?></td>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Apr ?></td>
                                    <?php if (date('m') == '04') { ?> <td class="current_month"> <?php echo $report->Apr; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->May ?></td>
                                    <?php if (date('m') == '05') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Jun ?></td>
                                    <?php if (date('m') == '06') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Jul ?></td>
                                    <?php if (date('m') == '07') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Aug ?></td>
                                    <?php if (date('m') == '08') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Sep ?></td>
                                    <?php if (date('m') == '09') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Oct ?></td>
                                    <?php if (date('m') == '10') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Nov ?></td>
                                    <?php if (date('m') == '11') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Dec ?></td>
                                    <?php if (date('m') == '12') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Jan ?></td>
                                    <?php if (date('m') == '01') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec + $report->Jan; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Feb ?></td>
                                    <?php if (date('m') == '02') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec + $report->Jan + $report->Feb; ?> </td><?php } ?>
                                    <td class="gradient-cell" style="color: black;"><?php echo $report->Mar ?></td>
                                    <?php if (date('m') == '03') { ?> <td class="current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec + $report->Jan + $report->Feb + $report->Mar; ?> </td><?php } ?>
                                    <td class="yearly_total" style="color: black;"><?php echo $report->total ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="col-md-5">

                        <?php
                        $query = "SELECT YEAR(pc.cer_issue_date) as year,
                        SUM(CASE WHEN pc.session_year_id = 1 THEN 1 ELSE 0 END) as `one`,
                        SUM(CASE WHEN pc.session_year_id = 2 THEN 1 ELSE 0 END) as `two`,
                        SUM(CASE WHEN pc.session_year_id = 3 THEN 1 ELSE 0 END) as `three`,
                        SUM(CASE WHEN pc.session_year_id = 4 THEN 1 ELSE 0 END) as `four`,
                        SUM(CASE WHEN pc.session_year_id = 5 THEN 1 ELSE 0 END) as `five`,
                        SUM(CASE WHEN pc.session_year_id = 6 THEN 1 ELSE 0 END) as `six`,
                        COUNT(0) as total_process
                            FROM 
                        `processed_cases` as pc
                        GROUP BY YEAR(pc.cer_issue_date)
                        ORDER BY YEAR(pc.cer_issue_date) DESC;";
                        $reports  = $this->db->query($query)->result();

                        ?>
                        <table class="table table_small table-bordered" id="yearly_and_monthly_progress_report">
                            <tr>
                                <th colspan="14">Session and Yearly Processed Files</th>
                            </tr>

                            <tr>
                                <th>Year</th>
                                <th>2018-19</th>
                                <th>2019-20</th>
                                <th>2020-21</th>
                                <th>2021-22</th>
                                <th>2022-23</th>
                                <th>2023-24</th>
                                <th>Total</th>
                            </tr>

                            <?php foreach ($reports as $report) { ?>
                                <tr>
                                    <th><?php echo $report->year ?></td>
                                    <td class="gradient-cell2" style="color: black;"><?php echo $report->one; ?></td>
                                    <td class="gradient-cell2" style="color: black;"><?php echo $report->two; ?></td>
                                    <td class="gradient-cell2" style="color: black;"><?php echo $report->three; ?></td>
                                    <td class="gradient-cell2" style="color: black;"><?php echo $report->four; ?></td>
                                    <td class="gradient-cell2" style="color: black;"><?php echo $report->five; ?></td>
                                    <td class="gradient-cell2" style="color: black;"><?php echo $report->six; ?></td>
                                    <td class="current_month" style="color: black;"><?php echo $report->total_process; ?></td>

                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <strong>Region Wise Visit/Visit Pending Report (New Registration and Upgradation)</strong>
                    <table class="table table_small table-bordered" style="text-align:center; font-size:10px" id="test _table">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                <th colspan="4" style="text-align: center;">New Registration</th>
                                <th colspan="4" style="text-align: center;">Upgradation</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;">Session</th>
                                <th style="text-align: center;">Total Registration+Upgradation</th>
                                <td>Registration</td>
                                <td>Visit Not Mentioned</td>
                                <td>Visited</td>
                                <td>Not Visited</td>
                                <td>Upgradation</td>
                                <td>Visit Not Mentioned</td>
                                <td>Visited</td>
                                <td>Not Visited</td>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                   sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_define`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_define`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) ";
                            if ($institute_type_id) {
                                $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                            }
                            if ($this->input->post('level_id')) {
                                $level_id = (int) $this->input->post('level_id');
                                $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                            }
                            $query .= " group by `district`.`new_region`";
                            $pending_files = $this->db->query($query)->result();
                            foreach ($pending_files as $pending) { ?>
                                <tr>
                                    <th style="text-align: center;"><?php echo $pending->region; ?></th>
                                    <td><?php echo $pending->reg_upg_total; ?></td>

                                    <td><?php echo $pending->registrations; ?></td>
                                    <td><?php echo $pending->reg_not_define; ?></td>
                                    <td><?php echo $pending->reg_visited_yes; ?></td>
                                    <td><?php echo $pending->reg_visited_no; ?></td>

                                    <td><?php echo $pending->re_up; ?></td>
                                    <td><?php echo $pending->re_up_not_define; ?></td>
                                    <td><?php echo $pending->re_up_visited_yes; ?></td>
                                    <td><?php echo $pending->re_up_visited_no; ?></td>


                                </tr>
                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <?php
                            $query = "SELECT sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_define`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_define`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`
                 from (((`school` 
                 join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                 join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                 join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                 ";
                            if ($institute_type_id) {
                                $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                            }
                            if ($this->input->post('level_id')) {
                                $level_id = (int) $this->input->post('level_id');
                                $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                            }
                            // $query .= " group by `district`.`new_region`";

                            $pending = $this->db->query($query)->row(); ?>
                            <tr>
                                <th style="text-align: center;">Total</th>
                                <th style="text-align: center;"><?php echo $pending->reg_upg_total; ?></th>

                                <th style="text-align: center;"><?php echo $pending->registrations; ?></th>
                                <th style="text-align: center;"><?php echo $pending->reg_not_define; ?></th>
                                <th style="text-align: center;"><?php echo $pending->reg_visited_yes; ?></th>
                                <th style="text-align: center;"><?php echo $pending->reg_visited_no; ?></th>

                                <th style="text-align: center;"><?php echo $pending->re_up; ?></th>
                                <th style="text-align: center;"><?php echo $pending->re_up_not_define; ?></th>
                                <th style="text-align: center;"><?php echo $pending->re_up_visited_yes; ?></th>
                                <th style="text-align: center;"><?php echo $pending->re_up_visited_no; ?></th>


                            </tr>
                        </tfoot>

                    </table>

                </div>
                <div class="col-md-12">
                    <div class="blo ck_div">
                        <strong>Region Wise Progress Summary Report </strong>
                        <div class="table-responsive">


                            <table class="table table_small table-bordered" style="text-align:center; font-size:10px" id="test _table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Region</th>
                                        <th style="text-align: center;">Applied</th>
                                        <th style="text-align: center;">Pending (Queue)</th>
                                        <th style="text-align: center;">Total Pending</th>
                                        <td>Reg.</td>
                                        <td>Ren.+Upgr</td>
                                        <td>Upgr</td>
                                        <td>Renewal</td>
                                        <td>Fin.Deficients</td>
                                        <td>(10%)</td>
                                        <td>Issue Pending</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    ";
                                    if ($institute_type_id) {
                                        $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                                    }
                                    if ($this->input->post('level_id')) {
                                        $level_id = (int) $this->input->post('level_id');
                                        $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                                    }
                                    $query .= " group by `district`.`new_region`";
                                    $pending_files = $this->db->query($query)->result();
                                    foreach ($pending_files as $pending) { ?>
                                        <tr>
                                            <th style="text-align: center;"><?php echo $pending->region; ?></th>
                                            <td><?php echo $pending->total_applied; ?></td>
                                            <td><?php echo $pending->previous_pending; ?></td>
                                            <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                                            <td><?php echo $pending->registrations; ?></td>
                                            <td><?php echo $pending->renewal_pgradations; ?></td>
                                            <td><?php echo $pending->upgradations; ?></td>
                                            <td><?php echo $pending->renewals; ?></td>
                                            <td><?php echo $pending->financially_deficient; ?></td>
                                            <td><?php echo $pending->marked_to_operation_wing; ?></td>
                                            <td><?php echo $pending->completed_pending; ?></td>

                                        </tr>
                                    <?php } ?>

                                </tbody>
                                <tfoot>
                                    <?php
                                    $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    ";
                                    if ($institute_type_id) {
                                        $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                                    }
                                    if ($this->input->post('level_id')) {
                                        $level_id = (int) $this->input->post('level_id');
                                        $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                                    }

                                    $pending = $this->db->query($query)->row(); ?>
                                    <tr>
                                        <th style="text-align: right;">Total: </th>
                                        <td><?php echo $pending->total_applied; ?></td>
                                        <td><?php echo $pending->previous_pending; ?></td>
                                        <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                                        <td><?php echo $pending->registrations; ?></td>
                                        <td><?php echo $pending->renewal_pgradations; ?></td>
                                        <td><?php echo $pending->upgradations; ?></td>
                                        <td><?php echo $pending->renewals; ?></td>
                                        <td><?php echo $pending->financially_deficient; ?></td>
                                        <td><?php echo $pending->marked_to_operation_wing; ?></td>
                                        <td><?php echo $pending->completed_pending; ?></td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="blo ck_div">
                        <strong>Session Wise Progress Summary Report </strong>
                        <div class="table-responsive">

                            <table class="table table_small table-bordered" style="text-align:center; font-size:10px" id="test _table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Session</th>
                                        <th style="text-align: center;">Applied</th>
                                        <th style="text-align: center;">Pending (Queue)</th>
                                        <th style="text-align: center;">Total Pending</th>
                                        <td>Reg.</td>
                                        <td>Ren.+Upgr</td>
                                        <td>Upgr</td>
                                        <td>Renewal</td>
                                        <td>Fin.Deficients</td>
                                        <td>(10%)</td>
                                        <td>Issue Pending</td>
                                        <td>Issued</td>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    ";
                                    if ($institute_type_id) {
                                        $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                                    }
                                    if ($this->input->post('level_id')) {
                                        $level_id = (int) $this->input->post('level_id');
                                        $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                                    }
                                    $query .= "group by `session_year`.`sessionYearTitle`";
                                    $pending_files = $this->db->query($query)->result();
                                    foreach ($pending_files as $pending) { ?>
                                        <tr>
                                            <th style="text-align: center;"><?php echo $pending->sessionYearTitle; ?></th>
                                            <td><?php echo $pending->total_applied; ?></td>
                                            <td><?php echo $pending->previous_pending; ?></td>
                                            <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                                            <td><?php echo $pending->registrations; ?></td>
                                            <td><?php echo $pending->renewal_pgradations; ?></td>
                                            <td><?php echo $pending->upgradations; ?></td>
                                            <td><?php echo $pending->renewals; ?></td>
                                            <td><?php echo $pending->financially_deficient; ?></td>
                                            <td><?php echo $pending->marked_to_operation_wing; ?></td>
                                            <td><?php echo $pending->completed_pending; ?></td>
                                            <td><?php echo $pending->total_issued; ?></td>

                                        </tr>
                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="bloc k_div">
                        <strong>Last 30 Days Progress Summary Report </strong>
                        <div class="table-responsive">
                            <table class="table table_small table-bordered" style="font-size: 4px; text-align:center !important">
                                <tr>
                                    <th style="position: sticky; width:100px"></th>
                                    <?php
                                    $working_days = 0;
                                    $current_date = time(); // get the current date and time as a Unix timestamp
                                    $one_month_ago = strtotime('-1 month', $current_date); // get the Unix timestamp for one month ago

                                    // loop through each day from one month ago until today and output the date in a desired format
                                    for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                                        $date = date('d-M', $i);

                                    ?>
                                        <th style="width: 20px;"> <?php echo $date;
                                                                    echo '<br />';
                                                                    if (date('N', $i) < 6) {
                                                                        $working_days++;
                                                                    }
                                                                    ?></th>
                                    <?php
                                    }
                                    ?>
                                    <th style="text-align: center;">30 Days Total</th>
                                    <th>Over All</th>
                                    <th>AVG/Day</th>
                                </tr>
                                <tr>
                                    <th style="position: sticky;">Daily Online Applied</th>
                                    <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                                        $date = date('Y-m-d', $i);
                                        $query = "SELECT COUNT(*) as total FROM school WHERE DATE(apply_date) = '" . $date . "'"; ?>
                                        <td>
                                            <?php echo $this->db->query($query)->row()->total;  ?>
                                        </td>
                                    <?php } ?>
                                    <th style="text-align: center;">
                                        <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(apply_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                                        echo $total = $this->db->query($query)->row()->total; ?>
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                <?php
                                $userId = $this->session->userdata('userId');
                                // if ($userId == 28727) {
                                $query = "SELECT users.userTitle, users.userId FROM `school`
                          INNER JOIN users ON(users.userId = school.note_sheet_completed)
                          AND school.file_status IN (10,4)
                          GROUP BY users.userId;";
                                $users = $this->db->query($query)->result();
                                foreach ($users as $user) {
                                ?>
                                    <tr>
                                        <th><small><?php echo $user->userTitle; ?></small></th>
                                        <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                                            $date = date('Y-m-d', $i);
                                            $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                                            $total = $this->db->query($query)->row()->total;
                                        ?>
                                            <td class="current_month">
                                                <?php echo $total;  ?>
                                            </td>
                                        <?php } ?>
                                        <th style="text-align: center;">
                                            <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                                            echo $total = $this->db->query($query)->row()->total; ?>
                                        </th>
                                        <th style="text-align: center;">
                                            <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'";
                                            echo $total = $this->db->query($query)->row()->total; ?>
                                        </th>
                                        <th>
                                            <?php if ($total) {
                                                echo round($total / $working_days, 2);
                                            }

                                            ?>
                                        </th>
                                        <!-- <th style="text-align: center;">
                        <?php
                                    // $query = "
                                    // SELECT AVG(total) AS avg_daily_entries
                                    // FROM (SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                                    // INNER JOIN users ON(users.userId = school.note_sheet_completed)
                                    // AND school.file_status IN (10,4)
                                    // AND users.userId = '" . $user->userId . "'
                                    //       GROUP BY DATE(note_sheet_completed_date)
                                    //       )
                                    // AS daily_counts;
                                    // ";
                                    //echo $total = round($this->db->query($query)->row()->avg_daily_entries, 2);
                        ?>
                      </th> -->
                                    </tr>
                                <?php } ?>
                                <?php //} 
                                ?>
                                <tr>
                                    <th style="position: sticky;">Daily Completed</th>
                                    <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                                        $date = date('Y-m-d', $i);
                                        $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                                        $total = $this->db->query($query)->row()->total;
                                    ?>
                                        <td style="background-color: rgba(0, 255, 0, <?php echo $total; ?>%);">
                                            <?php echo $total;  ?>
                                        </td>
                                    <?php } ?>
                                    <th style="text-align: center;">
                                        <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                                        echo $total = $this->db->query($query)->row()->total; ?>
                                    </th>
                                    <th style="text-align: center;">
                                        <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)";
                                        echo $total = $this->db->query($query)->row()->total; ?>
                                    </th>
                                    <th>
                                        <?php if ($total) {
                                            echo round($total / $working_days, 2);
                                        }

                                        ?>
                                    </th>
                                    <!-- <th style="text-align: center;">
                        <?php
                        // $query = "
                        // SELECT AVG(total) AS avg_daily_entries
                        // FROM (SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        // INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        // AND school.file_status IN (10,4)
                        // AND users.userId = '" . $user->userId . "'
                        //       GROUP BY DATE(note_sheet_completed_date)
                        //       )
                        // AS daily_counts;
                        // ";
                        //echo $total = round($this->db->query($query)->row()->avg_daily_entries, 2);
                        ?>
                      </th> -->
                                </tr>
                                <tr>
                                    <th style="position: sticky;">Daily Cer. Issued (MIS)</th>
                                    <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                                        $date = date('Y-m-d', $i);
                                        $query = "SELECT COUNT(*) as total FROM school WHERE DATE(cer_issue_date) = '" . $date . "'";
                                        $total = $this->db->query($query)->row()->total;
                                    ?>
                                        <td style="background-color: rgba(0, 255, 255, <?php echo $total; ?>%);">
                                            <?php echo  $total; ?>
                                        </td>
                                    <?php } ?>
                                    <th style="text-align: center;">
                                        <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(cer_issue_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                                        echo $total = $this->db->query($query)->row()->total; ?>
                                    </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </table>

                        </div>
                    </div>

                </div>


            </div>
        </div>

        <div class="col-md-9">
            <!-- Main content area -->
            <h2>Welcome to the Dashboard</h2>
            <p>This is your dashboard content.</p>
        </div>
    </div>
    </div>



    <!-- Include Bootstrap JS from CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.da taTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


    <script>
        function applyGradientColor(className) {
            // Get all elements with the specified class name
            var elements = document.querySelectorAll("." + className);

            // Initialize variables to track min and max values
            var minValue = Number.MAX_VALUE;
            var maxValue = Number.MIN_VALUE;

            // Loop through the elements to find min and max values
            elements.forEach(function(element) {
                var value = parseInt(element.textContent);
                if (!isNaN(value)) {
                    if (value > 0) {
                        minValue = Math.min(minValue, value);
                        maxValue = Math.max(maxValue, value);
                    }
                }
            });

            // Calculate the color gradient range (e.g., from red to green)
            var startColor = [0, 0, 255]; // Red
            var endColor = [0, 0, 5]; // Green

            // Apply gradient colors based on values
            elements.forEach(function(element) {
                var value = parseInt(element.textContent);
                if (!isNaN(value)) {
                    if (value > 0) {
                        var factor = (value - minValue) / (maxValue - minValue);
                        var opacity = 0.3 + factor * (1 - 0.3); // Adjust opacity as needed

                        var color = `rgba(100, 149, 237, ${opacity})`;
                        if (className == 'current_month') {
                            var color = `rgba(152,251,152, ${opacity})`;
                        }
                        element.style.backgroundColor = color;
                    }

                }
            });
        }

        // Helper function to interpolate between two colors
        function interpolateColor(startColor, endColor, factor) {
            var color = [];
            for (var i = 0; i < 3; i++) {
                color[i] = Math.round(startColor[i] + factor * (endColor[i] - startColor[i]));
            }
            return color;
        }

        // Apply gradient colors to elements with the specified class name
        applyGradientColor("gradient-cell");
        applyGradientColor("gradient-cell2");
        applyGradientColor("yearly_total");
        applyGradientColor("current_month");
        $(document).ready(function() {
            $('.datatable').DataTable({
                dom: 'Bfrtip',
                paging: false,
                title: 'abcd',
                "order": [],
                searching: false,
            });
        });
    </script>

    <style>
        .dt-button {
            font-size: 6px !important;
            border: 0px !important;
            color: #fff !important;
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .dataTables_filter,
        .dataTables_info {
            display: none;
        }
    </style>




</body>

</html>