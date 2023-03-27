<div class="content-wrapper">
  <?php $this->load->view('forms/form_header');   ?>
  <section class="content">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo @ucfirst($title); ?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
              <?php
              $query = "SELECT COUNT(*) as total FROM message_for_all 
              WHERE message_id IN(SELECT message_id FROM message_school WHERE school_id = '" . $school->schools_id . "')
             ORDER BY `message_id` DESC";

              $query_result = $this->db->query($query);
              $total_messages = $query_result->result()[0]->total; ?>

              <h4><i class="fa fa-envelope-o"></i> Inbox Messages
                <span class="label label-primary pull-right"><?php echo $total_messages; ?></span>
              </h4>


              <?php
              $query = "SELECT * FROM message_for_all 
                 WHERE message_id IN(SELECT message_id FROM message_school WHERE school_id = '" . $school->schools_id . "')
                ORDER BY `message_id` DESC";
              $query_result = $this->db->query($query);
              $school_messages = $query_result->result(); ?>
              <ul class="list-group">
                <?php
                foreach ($school_messages as $message) : ?>
                  <li class="list-group-item">
                    <a target="_new" href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                      <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                    </a>
                    <small style="display: block; color:gray" class="pull-right">
                      <i class="fa fa-clock-o" aria-hidden="true"></i>
                      <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                    </small>
                  </li>

                <?php endforeach; ?>
              </ul>

            </div>
          </div>
          <div class="col-md-6">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">

              <?php $query = "SELECT COUNT(*) as total FROM `message_for_all` 
                     WHERE `message_for_all`.`select_all`='yes'";
              $query_result = $this->db->query($query);
              $total_notifications = $query_result->result()[0]->total; ?>
              <h4><i class="fa fa-bell-o" aria-hidden="true"></i> PSRA Notifications
                <span class="label label-success pull-right"><?php echo $total_notifications; ?></span>
              </h4>

              <?php
              $query =
                "SELECT message_for_all.* FROM `message_for_all`
                where`message_for_all`.`select_all`='yes'  
                order by `message_for_all`.`message_id` DESC";
              $query_result = $this->db->query($query);
              $notifications = $query_result->result(); ?>
              <ul class="list-group">
                <?php
                foreach ($notifications as $message) : ?>
                  <li class="list-group-item">
                    <a style="overflow-wrap: break-word;" target="_new" href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                      <strong style="font-size: 14px;"> <?php echo $message->subject; ?></strong>
                    </a>
                    <small style="display: block; color:gray" class="pull-right">
                      <i class="fa fa-clock-o" aria-hidden="true"></i>
                      <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                    </small>
                  </li>
                <?php endforeach; ?>
              </ul>

            </div>
          </div>
        </div>
      </div>
  </section>
</div>