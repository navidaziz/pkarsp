<style>
    .table2>thead>tr>th,
    .table2>tbody>tr>th,
    .table2>tfoot>tr>th,
    .table2>thead>tr>td,
    .table2>tbody>tr>td,
    .table2>tfoot>tr>td {
        padding: 5px;
        line-height: 1;
        vertical-align: top;
        color: black !important;
        text-align: center;


    }
</style>

<div class="modal-header">
    <h5 class="modal-title pull-left" id="exampleModalLabel">Change status</h5>
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
<section style="padding:5px">
    <div class="row">
        <div class="col-md-12">
            <div style="padding:10px">
                <?php
                $query = "SELECT file_status, `status` FROM school WHERE schoolId='" . $school_id . "' and schools_id = '" . $schools_id . "' and status=2";
                $filestatus = $this->db->query($query)->row();

                if ($filestatus->file_status == 1 or is_null($filestatus->file_status)) { ?>
                    <h5>
                        <form action="<?php echo site_url("online_cases/change_file_status/$schools_id"); ?>" method="post">
                            <input type="hidden" value="<?php echo $schools_id ?>" name="schools_id" />
                            <input type="hidden" value="<?php echo $school_id ?>" name="school_id" />
                            <input onchange="$('.status_remark').prop('required',false); $('#reasonlist').hide()" required type="radio" name="file_status" value="4" /> Operation Wing<br />
                            <input onchange="$('.status_remark').prop('required',false); $('#reasonlist').hide()" required type="radio" name="file_status" value="10" /> Completed<br />
                            <input onchange="$('.status_remark').prop('required',true); $('#reasonlist').show()" required type="radio" name="file_status" value="3" /> Pending Due to Previous Session<br />
                            <h4>Previous Session Pendency Reason</h4>
                            <?php
                            $status_remarks = array('10%', 'Financial Deficent', 'Fine', 'Other', 'Upgradation');
                            ?>
                            <div id="reasonlist" style="display:none">
                                <?php foreach ($status_remarks as $status_remark) { ?>
                                    <input required type="radio" value="<?php echo $status_remark; ?>" class="status_remark" name="status_remark" />
                                    <?php echo $status_remark; ?>
                                    <span style="margin: 10px;"></span>
                                <?php } ?>
                            </div>

                            <input type="submit" value="Change Status" name="Change Status" />
                        </form>
                    </h5>
                <?php } else { ?>
                    Status change not allowed<br />
                    File Status <?php echo $filestatus->file_status; ?>
                <?php } ?>
            </div>
        </div>

    </div>
</section>