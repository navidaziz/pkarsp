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
</style>


<body>


    <!-- Dashboard Content -->
    <div class="container" style="margin:10px;">
        <div class="row">
            <div class="col-md-5">

                <?php
                $query = "SELECT * FROM session_year";
                $sessions  = $this->db->query($query)->result();

                ?>
                <table class="table table_small" id="yearly_and_monthly_progress_report">
                    <tr>
                        <th colspan="14">Session Wise Registration / Renewals / Upgradation Report</th>
                    </tr>

                    <tr>
                        <th>Type</th>
                        <?php foreach ($sessions as $session) { ?>
                            <th><?php echo $session->sessionYearTitle; ?></th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Registration</th>
                        <?php foreach ($sessions as $session) {
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE renewal_code<=0 and session_year_id='" . $session->sessionYearId . "';";
                            $report = $this->db->query($query)->row();
                        ?>
                            <th><?php echo $report->total; ?></th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Renewals</th>
                        <?php foreach ($sessions as $session) {
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE renewal_code>0 and session_year_id='" . $session->sessionYearId . "';";
                            $report = $this->db->query($query)->row();
                        ?>
                            <th><?php echo $report->total; ?></th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th>Upgradation</th>
                        <?php foreach ($sessions as $session) {
                            $query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE upgrade = 1 and session_year_id='" . $session->sessionYearId . "';";
                            $report = $this->db->query($query)->row();
                        ?>
                            <th><?php echo $report->total; ?></th>
                        <?php } ?>
                    </tr>


                </table>
            </div>
            <div class="col-md-5">

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
                <table class="table table_small" id="yearly_and_monthly_progress_report">
                    <tr>
                        <th colspan="14">Yearly and monthly progress report</th>
                    </tr>

                    <tr>
                        <th>Year</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th>Jun</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Yearly Total</th>
                    </tr>

                    <?php foreach ($reports as $report) { ?>
                        <tr>
                            <th><?php echo $report->Year ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Apr ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->May ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Jun ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Jul ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Aug ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Sep ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Oct ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Nov ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Dec ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Jun ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Feb ?></td>
                            <td class="gradient-cell" style="color: black;"><?php echo $report->Mar ?></td>
                            <td class="yearly_total" style="color: black;"><?php echo $report->total ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-3">
                <div id="chart-container"></div>
                <!-- Sidebar navigation here -->
                <ul class="list-group">
                    <li class="list-group-item">Item 1</li>
                    <li class="list-group-item">Item 2</li>
                    <li class="list-group-item">Item 3</li>
                </ul>
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
        applyGradientColor("yearly_total");
    </script>




</body>

</html>