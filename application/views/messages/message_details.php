<?php //var_dump($message_info);exit; 
?>
<style type="text/css">
fieldset {
    display: block;
    margin-inline-start: 2px;
    margin-inline-end: 2px;
    padding-block-start: 0.35em;
    padding-inline-start: 0.75em;
    padding-inline-end: 0.75em;
    padding-block-end: 0.625em;
    min-inline-size: min-content;
    border-width: 1px;
    border-style: groove;
    border: 1px solid #bbb;
    border-image: initial;
    font-size: 16px;

}

legend {
    width: auto;
    display: block;
    padding-inline-start: 2px;
    padding-inline-end: 2px;
    border-width: initial;
    border-style: none;
    border-color: initial;
    border-image: initial;
    font-size: 16px;

}

.message {
    overflow: hidden;
    text-overflow: ellipsis;

    letter-spacing: .2px;
    color: #202124;
    line-height: 20px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2 style="display:inline;">
            <?php echo @ucfirst($title); ?>
        </h2>
        <small><?php echo @$description; ?></small>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
            <!-- <li><a href="#">Examples</a></li> -->
            <li class="active"><?php echo @ucfirst($title); ?></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo @ucfirst($title); ?></h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">



                <div class="row">



                    <div class="col-md-12">
                        <div class=" col-sm-12 clearfix">
                            <a href="<?php echo base_url('messages/create_message'); ?>"
                                class=" pull-right btn btn-flat btn-primary"><i class="fa fa-edit"></i> Create
                                Message</a>
                        </div>
                        <fieldset style="background-color: #f9f6f6;">
                            <legend></legend>
                            <h3
                                style="text-align:center;width:100%;font-size:   24px;padding:10px;font-family: Arial, Helvetica, sans-serif;text-transform:  capitalize;margin-top:0 !important;margin-bottom: 0 !important; ">
                                <?php echo $message_info->subject; ?></h3>
                            <p class="" style="font-size: 14px;color:#e95837;text-align: center;"><i
                                    class="fa fa-clock-o" aria-hidden="true"></i>
                                <?php echo date("l , dS F Y", strtotime($message_info->created_date)); ?>
                                <span style="margin-left: 5px;"></span>

                                <?php
                                $query="SELECT userTitle FROM users WHERE userId = ?";
                                $user = $this->db->query($query, [$message_info->created_by])->row();
                                if($user){
                                  echo 'Author: <strong><i>'.$user->userTitle.'</i></strong>';
                                }
                               
                                ?>
                            </p>
                            <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12" style="min-height: 200px;">
                                <div style="background-color: #fff;padding:20px;">
                                    <div class="">
                                        <?php
                    echo $message_info->discription;
                    //str_replace('http://localhost/pkarsp/school/certificate', site_url("print_file/certificate/"), $message_info->discription);

                    ?>
                                    </div>

                                    <hr>
                                    <?php if (count($attachments)) {
                    $counter = 1; ?>
                                    <table class="table table-bordered bg-info">
                                        <?php foreach ($attachments as $attachment) {
                        if ($attachment->folder) {
                          $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
                          $attachment_url = $root . "uploads/" . $attachment->folder . "/";
                        } else {
                          $attachment_url = 'http://psra.gkp.pk/schoolReg/assets/images/';
                        }
                        echo "<br />";
                      ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><i class="fa fa-file"></i> <?php
                                                          $attach = explode('____', $attachment->attachment_name);


                                                          echo end($attach); ?>
                                            </td>
                                            <td>
                                                <a target="_blank" class="btn btn-link"
                                                    href="<?php echo  $attachment_url . '' . $attachment->attachment_name; ?>">
                                                    <i class="fa fa-download"></i> Download</a>
                                            </td>
                                        </tr>
                                        <?php  }  ?>
                                    </table>

                                    <?php } ?>

                                    <div>
                                        <p>
                                            <summary style="cursor: pointer;"><small>Message Read Logs: <i
                                                        class="fa fa-caret-down" aria-hidden="true"></i></small>
                                            </summary>
                                            <?php if ($message_read_logs): ?>
                                        <p>
                                        <ul style="font-size: 8px;">
                                            <?php foreach ($message_read_logs as $message_read_log): ?>
                                            <li>
                                                <strong>Read By:</strong>
                                                <?= htmlspecialchars($message_read_log->userTitle); ?>
                                                <em>on
                                                    <?= date('F j, Y H:m:s a', strtotime($message_read_log->read_date)); ?></em>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php else: ?>
                                        <p><em>No one has read this message yet.</em></p>
                                        <?php endif; ?>
                                        </p>
                                        </p>
                                    </div>
                                </div>


                            </div>



                        </fieldset>
                        <!--                           </div>
        </div> -->
                    </div>

                    <!-- /.box-body -->
                </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->