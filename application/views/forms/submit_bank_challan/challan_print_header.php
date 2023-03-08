<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>PSRA Renewal Challan Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
    <script src="script.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Academy Bank Challan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            background: rgb(204, 204, 204);
            font-family: 'Source Sans Pro', 'Regular' !important;

        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 21cm;
            /* height: 29.7cm;  */
            height: auto;
        }

        @media print {
            page[size="A4"] {
                width: 90%;
                margin: 0 auto;
                margin-top: 30px;
                /* height: 29.7cm;  */
                height: auto;
                font-size: 15px !important;
            }
        }

        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }

        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }

        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
                color: black;
            }

        }


        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            padding: 8px;
            line-height: 1;
            vertical-align: top;
            font-size: 14px !important;
            color: #333 !important;
        }
    </style>
</head>

<body>
    <page size='A4'>
        <div style="padding: 10px;" style="width: 100%;">
            <table style="width: 100%;">
                <tr>
                    <th><img style="width: 100px;" src="<?php echo base_url(); ?>assets/logo.png" class="img-responsive img" /></th>
                    <th>
                        <h3 style="text-align: center;">Public School Regulatory Authority Khyber Pakhtunkhwa</h4>
                            <h4 style="text-align: center;"><?php echo $title;  ?> Challan Form For Session <?php echo $session_detail->sessionYearTitle; ?>
                            </h4>


                    </th>
                </tr>
            </table>
            <hr />
            <h6 style="text-align: center;">The Bank of Khyber, A/C No.
                <b> PLS. 2000883401</b> On Account of: <b>Managing Director Private Schools Regulatory Authority</b>
            </h6>
            <table style="width: 100%;">
                <tr>
                    <th>Date: _______________</th>
                    <th style="text-align: center;">
                        <!--Receipt No: <span style="text-decoration: underline; ">
                 <strong><?php echo $school->schools_id + $school->district_id; ?><strong></span>
               -->


                    </th>
                    <th style="text-align: right;">Reference no:___________________<br />
                        (for bank use only)</th>
                </tr>
            </table>
            <div style="border: 1px solid #ddd; border-radius: 10px; margin-top: 5px; margin-bottom: 10px;  padding: 10px; font-size: 20px;">
                <table class="table">
                    <tr>
                        <td style="text-align: left;">School ID: <span style="text-decoration: underline; ">
                                <strong><?php echo $school->schools_id; ?><strong></span></td>
                        <td style="text-align: center;">
                            <?php if ($school->registrationNumber) { ?>
                                Registration ID: <span style="text-decoration: underline; ">
                                    <strong><?php echo $school->registrationNumber; ?><strong></span>
                            <?php } ?>
                        </td>
                        <td style="text-align: right;">Session: <span style="text-decoration: underline; ">
                                <strong><?php echo $session_detail->sessionYearTitle; ?></strong> <small> ( <?php echo $title;  ?> Challan )<small></span></td>
                    </tr>
                </table>

                <table class="table">
                    <tr>
                        <td>Institute Name: <span style="text-decoration: underline; ">
                                <strong><?php echo $school->schoolName; ?><strong></span></td>
                        <td colspan="2">District: <span style="text-decoration: underline; ">
                                <strong><?php $query = "SELECT `districtTitle` FROM `district` WHERE districtId = '" . $school->district_id . "'";
                                        echo $this->db->query($query)->result()[0]->districtTitle; ?></td>
                        <td colspan="4">Level of Institute: <span style="text-decoration: underline; ">
                                <strong><?php $query = "SELECT `levelofInstituteTitle` FROM `levelofinstitute` WHERE levelofInstituteId = '" . $school->level_of_school_id . "'";
                                        echo $this->db->query($query)->result()[0]->levelofInstituteTitle; ?></td>
                    </tr>
                </table>



            </div>
            <div style="margin: 10px;">