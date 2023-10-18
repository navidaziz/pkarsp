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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


</head>
<style>
    .table_small2>tbody>tr>td,
    .table_small2>tbody>tr>th,
    .table_small2>tfoot>tr>td,
    .table_small2>tfoot>tr>th,
    .table_small2>thead>tr>td,
    .table_small2>thead>tr>th {
        padding: 3px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 10px;
        text-align: center;
        border: 0px !important;
    }

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
        border: 0.1px solid gray !important;
        font-weight: bold !important;
        color: black !important;
    }



    .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl {
        max-width: 100%;
    }

    .female {
        background-color: #FFB1CB;
        width: 100%;
        display: block;
        margin-top: 2px;
        padding: 2px;
        color: #fff;

    }

    .male {
        background-color: #01A6EA;
        width: 100%;
        display: block;
        margin-top: 2px;
        padding: 2px;
        color: #fff;
    }

    .female_male {
        background-color: #FFCC10;
        width: 100%;
        display: block;
        margin-top: 1px;
        padding: 2px;
        color: #fff;
    }
</style>


<body>


    <!-- Dashboard Content -->
    <div class="container" style="padding-top: 5px;">
        <div class="row">
            <div class="col-md-4">
                <div id="registration_summary"></div>
                <!-- <div id="container2" style="height: 280px;"></div> -->





                <div id="region_wise_summary_chart"></div>
                <div id="region_wise_summary"></div>
                <div id="district_wise_summary"></div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-7">
                        <div id="yearly_monthly_summary"></div>
                    </div>
                    <div class="col-md-5">
                        <div id="yearly_monthly_session_summary"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="daily_progress_report"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="region_progress_report"></div>
                        <div id="session_progress_report"></div>

                        <div id="students_summary_report"></div>
                    </div>
                </div>




            </div>

            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-7">
                        <div id="container" style="width:300px"></div>

                    </div>


                </div>
            </div>
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

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
        function get_report(funcation_name) {
            $('#' + funcation_name).html('<h5 style="text-align: center;" class="linear-background"></h5>');
            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('md_dashboard/'); ?>" + funcation_name,
                    data: {

                    }
                })
                .done(function(respose) {
                    $('#' + funcation_name).html(respose);
                    applyGradientColor("new_registrations");
                    applyGradientColor("commulative_registration");
                    applyGradientColor("renewals");
                    applyGradientColor("renewals_remanings");




                    applyGradientColor("y_m_summary_report");
                    applyGradientColor("y_m_current_month");
                    applyGradientColor("y_m_s_s_report");
                    applyGradientColor("y_m_s_s_current_year_report");
                    applyGradientColor("district_precentage");
                    applyGradientColor("district_total");
                    applyGradientColor("daily_progress");
                    applyGradientColor("daily_apply");
                    applyGradientColor("days_total");
                    applyGradientColor("daily_over_all");
                    applyGradientColor("days_avg");
                    applyGradientColor("daily_completed");





                    applyGradientColor("district_reg_total");
                    applyGradientColor("district_upgradation");
                    applyGradientColor("district_registration");

                    applyGradientColor("region_registered");
                    applyGradientColor("region_upgradation");
                    applyGradientColor("region_total");
                    applyGradientColor("region_precentage");

                    applyGradientColor("level_total_registered");
                    applyGradientColor("level_new_registration");
                    applyGradientColor("level_upgradation");
                    applyGradientColor("level_renewal_total");
                    applyGradientColor("level_precentage");

                    applyGradientColor("registration_total");
                    applyGradientColor("registration_other");

                    applyGradientColor("re_upg_total");
                    applyGradientColor("re_upg_other");

                    applyGradientColor("upgra");
                    applyGradientColor("renew");

















                });
        }

        get_report("registration_summary");
        get_report("summary");
        get_report("level_wise_summary");
        get_report("region_wise_summary");
        get_report("district_wise_summary");
        get_report("yearly_monthly_summary");
        get_report("yearly_monthly_session_summary");
        get_report("region_progress_report");
        get_report("session_progress_report");
        get_report("daily_progress_report");
        get_report("other_summary");



        //get_report("students_summary_report");
    </script>

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
                        if (className == 'y_m_current_month') {
                            var color = `rgba(152,251,152, ${opacity})`;
                        }
                        if (className == 'y_m_s_s_current_year_report') {
                            var color = `rgba(152,251,152, ${opacity})`;
                        }
                        if (className == 'new_registrations') {
                            var color = `rgba(44, 175, 253, ${opacity})`;
                        }
                        if (className == 'renewals') {
                            var color = `rgba(152,251,152, ${opacity})`;
                        }
                        if (className == 'renewals_remanings') {
                            var color = `rgba(255, 180, 180, ${opacity})`;
                        }

                        if (className == 'daily_apply') {
                            var color = `rgba(238, 108, 77, ${opacity})`;
                        }

                        if (className == 'daily_completed') {
                            var color = `rgba(251, 203, 4, ${opacity})`;
                        }

                        if (className == 'days_total') {
                            var color = `rgba( 245, 245, 219, ${opacity})`;
                        }

                        if (className == 'daily_over_all') {
                            var color = `rgba( 90, 209, 253, ${opacity})`;
                        }

                        if (className == 'days_avg') {
                            var color = `rgba(147, 176, 217, ${opacity})`;
                        }

                        if (className == 'registration_total') {
                            var color = `rgba(241,194,50, ${opacity})`;
                        }
                        if (className == 'registration_other') {
                            var color = `rgba(241,194,50, ${opacity})`;
                        }
                        if (className == 're_upg_total') {
                            var color = `rgba(102,211,252, ${opacity})`;
                        }
                        if (className == 're_upg_other') {
                            var color = `rgba(102,211,252, ${opacity})`;
                        }
                        if (className == 'upgra') {
                            var color = `rgba(102,211,252, ${opacity})`;
                        }

                        if (className == 'renew') {
                            var color = `rgba(166,77,121, ${opacity})`;
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
        applyGradientColor("gradient-cell");

        // $(document).ready(function() {
        //     $('.datatable').DataTable({
        //         dom: 'Bfrtip',
        //         paging: false,
        //         title: 'abcd',
        //         "order": [],
        //         searching: false,
        //     });
        // });
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

        .linear-background {
            animation-duration: 1s;
            animation-fill-mode: forwards;
            animation-iteration-count: infinite;
            animation-name: placeHolderShimmer;
            animation-timing-function: linear;
            background: #f6f7f8;
            background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
            background-size: 1000px 104px;
            height: 30px;
            position: relative;
            overflow: hidden;
        }
    </style>



</body>

</html>