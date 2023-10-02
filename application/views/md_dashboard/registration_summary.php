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
    </div>



    <p>

    <div id="summary"></div>
    <div id="other_summary"></div>
    <div id="level_wise_summary"></div>
    <div id="level_wise_summary_chart" style="height: 200px;"></div>





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