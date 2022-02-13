<script>
  function remove_comment(comment_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url($this->uri->segment(1) . '/delete_comment'); ?>",
        data: {
          comment_id: comment_id
        }
      })
      .done(function(respose) {
        if (respose == 1) {
          $('#comment_' + comment_id).remove();
        } else {
          alert("Error in deletion");
        }
      });
  }
</script>

<?php
$user_id = $this->session->userdata('userId');
$query = "SELECT `status` FROM school WHERE schoolId= '" . $school_id . "'";
$status = $this->db->query($query)->result()[0]->status; ?>
<div style=" overflow-y: scroll; border:1px solid #9FC8E8; border-radius: 10px; height: 280px;  margin: 5px; padding: 5px; background-color: white;">
  <ul class="chat">
    <?php
    $count = 1;
    $pervious_user_id = 0;
    foreach ($comments as $comment) { ?>
      <li class="left clearfix" id="comment_<?php echo $comment->comment_id; ?>"><span class="chat-img pull-left">
          <?php if ($user_id == $comment->created_by) { ?>
            <span class="label label-danger"><?php echo $count++; ?></span>
            <!-- <img src="http://placehold.it/100/FA6F57/fff&amp;text=<?php //echo $count++; 
                                                                        ?>" class="comment_image_left"> -->
          <?php } else { ?>
            <span class="label label-primary"><?php echo $count++; ?></span>
            <!-- <img src="http://placehold.it/100/55C1E7/fff&amp;text=<?php //echo $count++; 
                                                                        ?>" class="comment_image_left"> -->
          <?php } ?>
        </span>
        <div class="chat-body clearfix">

          <?php if ($pervious_user_id != $comment->created_by) { ?>
            <div class="header">
              <strong class="primary-font" style="margin-left: 5px; font-weight: 701;">
                <?php echo $comment->userTitle; ?></strong>
              (<?php echo $comment->role_title; ?>)

              <small class="pull-right text-muted">
                <span class="glyphicon glyphicon-time" title="<?php echo $comment->created_date; ?>"></span>
                <?php //echo get_timeago($comment->created_date); 
                ?>
                <?php echo date('d M, Y h:m:s', strtotime($comment->created_date)); ?>
                <?php if ($user_id == $comment->created_by) { ?>
                  <?php if ($status != 1) { ?>
                    <i onclick="remove_comment('<?php echo $comment->comment_id; ?>')" class="fa fa-close" style="margin-left: 10px; margin-right: 3px; cursor: pointer;"></i>
                  <?php } ?>
                <?php } ?>
              </small>
            </div>
          <?php } ?>


          <p style="margin-left: 13px;">
            <?php if ($comment->mark_to) { ?>
              <?php $query = "SELECT  `users`.`userId`, `users`.`userTitle`, `roles`.`role_title` 
                           FROM
                           `roles`
                           INNER JOIN `users`
                           ON ( `roles`.`role_id` = `users`.`role_id` )
                           WHERE `users`.`userId` = '" . $comment->mark_to . "'
                            ORDER BY `roles`.`role_id`;";
              $marked_to = $this->db->query($query)->result()[0]; ?>
              <strong>@<?php echo $marked_to->userTitle; ?></strong> (<?php echo $marked_to->role_title; ?>)
            <?php } ?>

            <?php echo str_replace('\n', "\n", trim($comment->comment)); ?>
            <?php if ($pervious_user_id == $comment->created_by) { ?>
              <small class="pull-right text-muted">

                <span class="glyphicon glyphicon-time" title="<?php echo $comment->created_date; ?>"></span>
                <?php echo get_timeago($comment->created_date); ?>
                <?php if ($user_id == $comment->created_by) { ?>
                  <?php if ($status != 1) { ?>
                    <i onclick="remove_comment('<?php echo $comment->comment_id; ?>')" class="fa fa-close" style="margin-left: 10px; margin-right: 3px; cursor: pointer;"></i>
                  <?php } ?>
                <?php } ?>
              </small>

            <?php } ?>
            <?php //echo $comment->comment; 
            ?>
          </p>
        </div>
      </li>
      <!-- <li class="left clearfix"><span class="chat-img pull-left">
                <img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="comment_image_left">
              </span>
              <div class="chat-body clearfix">
                <div class="header">
                  <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                    <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                </div>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                  dolor, quis ullamcorper ligula sodales.
                </p>
              </div>
            </li> -->
    <?php
      $pervious_user_id = $comment->created_by;
    } ?>
  </ul>
</div>