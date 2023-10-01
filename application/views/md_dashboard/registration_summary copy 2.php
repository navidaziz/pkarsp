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
        <h1>ِ10,665 </h1>
        <h5 style="display: inline;"> Schools Registered So Far</h5>
    </div>
    <p>
    <table class="table_small" style="width: 100%;">
        <tr></tr>

        <?php
        $query = "SELECT * FROM session_year";
        $sessions  = $this->db->query($query)->result();
        foreach ($sessions as $session) {
            $query = "SELECT COUNT(*) as total FROM `school` WHERE renewal_code<=0 and  status=1 and  session_year_id='" . $session->sessionYearId . "';";
            $report = $this->db->query($query)->row();
            $session->commulative_registration = $total_registration += $report->total;
            $session->new_registration = $report->total;

            $query = "SELECT COUNT(*) as total FROM `school` WHERE renewal_code>0 and session_year_id='" . $session->sessionYearId . "';";
            $report = $this->db->query($query)->row();
            $session->renewals = $report->total;
        }
        foreach ($sessions as $session) {
            if ($session->commulative_registration - $session->new_registration > 0) {
                $renewal_percantage = round(($session->renewals / ($session->commulative_registration - $session->new_registration)) * 100, 2);
            }
        ?><tr>
                <th style="width: 80px;"> <?php echo  str_replace("-20", "-", $session->sessionYearTitle); ?></th>
                <td>
                    <?php echo $session->new_registration; ?>
                </td>
                <td>
                    <?php if ($renewal_percantage) { ?>
                        <div class="progress" style="margin-top: 3px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $renewal_percantage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $renewal_percantage; ?>%;">
                                <small><?php echo $renewal_percantage ?> % </small>
                            </div>
                            <div class="progress-bar-danger" role="progressbar" aria-valuenow="<?php echo 100 - $renewal_percantage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo 100 - $renewal_percantage; ?>%;">
                                <small> <?php echo 100 - $renewal_percantage; ?> % </small>
                            </div>
                        </div>
                    <?php } ?>
                </td>
                <td>
                    <?php echo $session->renewals; ?> / <?php echo $session->commulative_registration; ?>
                </td>
            </tr>
        <?php } ?>

    </table>
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