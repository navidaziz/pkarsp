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
    <h5 class="modal-title pull-left" id="exampleModalLabel">Mark as Complete</h5>
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
<section style="padding:5px">
    <div class="row">
        <div class="col-md-12">
            <div style="padding:10px">
                <?php
                $query="SELECT file_status FROM school WHERE schoolId='".$school_id."' and schools_id = '".$schools_id."' and status=2";
                $file_status = $this->db->query($query)->row();
                if($file_status==1){ ?>
            <h5>
                <form action="<?php echo site_url("online_cases/change_file_status/$schools_id"); ?>" method="post">
                <input type="hidden" value="<?php echo $schools_id ?>" name="schools_id" />
                <input type="hidden" value="<?php echo $school_id ?>" name="school_id" />
            <input type="radio" name="file_status" value="4" /> Operation Wing<br />
            <input type="radio" name="file_status" value="10" /> Completed<br />
            <input type="submit" value="Change Status" name="Change Status" />
            </form>
            </h5>
            <?php }else{ ?>
            Status change not allowed
            <?php } ?>
            </div>
            </div>
            
    </div>
    </section>

