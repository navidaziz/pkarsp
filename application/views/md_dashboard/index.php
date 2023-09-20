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
                <div id="summary"></div>
                <div id="level_wise_summary"></div>
                <div id="region_wise_summary"></div>
                <div id="district_wise_summary"></div>





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

            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('md_dashboard/'); ?>" + funcation_name,
                    data: {

                    }
                })
                .done(function(respose) {
                    $('#' + funcation_name).html(respose);
                });
        }

        get_report("summary");
        get_report("level_wise_summary");
        get_report("region_wise_summary");
        get_report("district_wise_summary");
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
    </style>




</body>

</html>