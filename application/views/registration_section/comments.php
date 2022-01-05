<script>
  function remove_comment(comment_id) {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('registration_section/delete_comment'); ?>",
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
$status = $this->db->query($query)->result()[0]->status;

foreach ($comments as $comment) { ?>
  <li class="left clearfix" id="comment_<?php echo $comment->comment_id; ?>"><span class="chat-img pull-left">
      <img src="http://placehold.it/50/55C1E7/fff&amp;text=U" alt="User Avatar" class="comment_image_left">
    </span>
    <div class="chat-body clearfix">
      <div class="header">
        <strong class="primary-font"><?php echo $comment->userTitle; ?></strong> (<?php echo $comment->role_title; ?>) <small class="pull-right text-muted">
          <span class="glyphicon glyphicon-time" title="<?php echo $comment->created_date; ?>"></span>
          <?php echo get_timeago($comment->created_date); ?>
          <?php if ($user_id == $comment->created_by) { ?>
            <?php if ($status != 1) { ?>
              <i onclick="remove_comment('<?php echo $comment->comment_id; ?>')" class="fa fa-close" style="margin-left: 10px; margin-right: 3px; cursor: pointer;"></i>
            <?php } ?>
          <?php } ?>
        </small>
      </div>
      <p>
        <?php echo $comment->comment; ?>
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
<?php } ?>