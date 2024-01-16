<?php
$query = "select sessionYearId from session_year WHERE session_year.status=1";
$current_session = $this->db->query($query)->row()->sessionYearId;
?>
<div class="jumbotron" style="padding: 9px;">
    <table class="table2" style="width: 100%;">
        <tr>
            <td> <img src="<?php echo base_url('assets/images/site_images/certificate-logo-1-in-print.jpg'); ?>" style="height: 50px; width: 50px;">
            </td>
            <td style="text-align: center;">
                <strong style="font-size: 13px;">PRIVATE SCHOOLS REGULATORY AUTHORITY</strong>
                <small>GOVERNMENT OF KHYBER PAKHTUNKHWA</small>

            </td>
            <td> <img src="<?php echo base_url('assets/images/site_images/certificate-logo-2-in-print.png'); ?>" style="height: 50px; width: 60px;">
            </td>
        </tr>
    </table>
    <div style="text-align: center;">
        <h1>
            <?php
            $query = "SELECT COUNT(*) as total FROM `school` 
            WHERE renewal_code<=0 and status=1 ";
            $registered_schools = $this->db->query($query)->row()->total;
            echo number_format($registered_schools);
            ?>
        </h1>
        <h5 style="display: inline;"> Schools Registered So Far</h5>
        <?php
        $query = "SELECT COUNT(*) as total FROM `schools` 
            WHERE registrationNumber>0 and isfined=1 ";
        $reg_school_fined = $this->db->query($query)->row()->total;

        ?>
        <p><small>
                <i>
                    Currently,<strong><?php echo number_format($reg_school_fined); ?></strong> registered schools portals blocked due to fines.
                </i>
            </small></p>
    </div>



    <p>


    <div id="summary"></div>
    <div id="other_summary"></div>
    <div id="level_pie_chart" style="height: 250px;"></div>
    <div id="level_wise_summary"></div>
    <div id="level_wise_summary_chart" style="height: 270px;"></div>
    <div id="fee_category" style="height: 300px;"></div>


    <?php
    $query = "
    SELECT
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) = 0 THEN 1 ELSE 0 END) as cat_zero,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 0 AND 2000 AND CAST(f.max_fee AS SIGNED) <= 2000 THEN 1 ELSE 0 END) as cat_one,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 2000 AND CAST(f.max_fee AS SIGNED) <= 3500 THEN 1 ELSE 0 END) as cat_two,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 3500 AND CAST(f.max_fee AS SIGNED) <= 6000 THEN 1 ELSE 0 END) as cat_three,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 6000 AND CAST(f.max_fee AS SIGNED) <= 10000 THEN 1 ELSE 0 END) as cat_four,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 10000 AND CAST(f.max_fee AS SIGNED) <= 15000 THEN 1 ELSE 0 END) as cat_five,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 15000 AND CAST(f.max_fee AS SIGNED) <= 20000 THEN 1 ELSE 0 END) as cat_six,
        SUM(CASE WHEN CAST(f.max_fee AS SIGNED) > 20000 THEN 1 ELSE 0 END) as cat_seven
    FROM current_session_max_fee AS f;";

    $results = $this->db->query($query)->row();
    ?>


    <script>
        Highcharts.chart('fee_category', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Current session, fee categories wise distribution'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    '0',
                    '1-2000',
                    '2001-3500',
                    '3501-6000',
                    '6000-10000',
                    '10001-15000',
                    '15000-20000',
                    'Above 20000'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0,
                    borderWidth: 0,
                    groupPadding: 0,
                    shadow: false
                }
            },
            series: [{
                name: 'Fee Category',
                data: [
                    <?php echo $results->cat_zero; ?>,
                    <?php echo $results->cat_one; ?>,
                    <?php echo $results->cat_two; ?>,
                    <?php echo $results->cat_three; ?>,
                    <?php echo $results->cat_four; ?>,
                    <?php echo $results->cat_five; ?>,
                    <?php echo $results->cat_six; ?>,
                    <?php echo $results->cat_seven; ?>
                ]

            }]
        });
    </script>




    <br />

    </p>

    <style>
        .progress-bar {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: black;
            text-align: center;
            white-space: nowrap;
            background-color: #98FB98;
            transition: width .6s ease;
            font-size: small;
        }

        .progress-bar-danger {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: black;
            text-align: center;
            white-space: nowrap;
            background-color: #FFB4B4;
            transition: width .6s ease;
            font-size: small;
        }
    </style>



</div>