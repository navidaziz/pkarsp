<style>
.radio, .checkbox {
	position: relative;
	display: block;
	margin-top: 0px !important;
	margin-bottom: 0px !important;
}
</style>

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url("student/class_and_section/"); ?>"> Classes and Sections</a> </li>
         <li> <a href="<?php echo site_url("student/students_list/".$this->session->userdata('class_id')."/".$this->session->userdata('section_id')); ?>"> Students List</a> </li>
        <li> <a href="<?php echo site_url("student/view_student/".$this->session->userdata('student_id')); ?>"> Detail</a> </li>
        <li ><?php echo $title; ?> </li>
        <span class="pull-right">
        <?php   
	  if($this->session->userdata('logged_in')){
	  ?>
        <?php echo "Welcome <i>".$this->session->userdata('student_name')."</i>"; ?> <a href="<?php echo site_url("student/logout/"); ?>"> Logout </a>
        <?php }else{ ?>
        <a href="<?php echo site_url("student/login/")."/".$students[0]->student_id; ?>"> login </a>
        <?php } ?>
        </span>
      </ul>
    </div>
    <div class="progress">
    <?php $calculated_value=(int) ($total_attempted_quetions*100)/$total_test_questions;  ?>
      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $calculated_value  ?>"
  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $calculated_value  ?>%"> <?php echo $calculated_value  ?>% Completed (<?php echo $total_attempted_quetions."/".$total_test_questions;  ?>) </div>
    </div>
  </div>
</div>
<div class="row"> 
  <script>
function submit_answer(question_id, answer){
	test_id = <?php echo $test_question[0]->test_id;  ?>;
		$( "#answer_form" ).submit();
		/*$.ajax({ type: "POST",
				 url: "<?php echo base_url("student/qustion_answer/"); ?>",
				 data:{test_id:test_id,
				 	   question_id:question_id,
					   answer:answer}
				  }).done(function(data) {
					  
					  $('#response').html(data);
					  
					  });	*/
	}
</script>
  <?php $this->load->view(PUBLIC_DIR."components/nav"); ?>
  <div class="col-md-12">
    <?php if($test_question){?>
    <p >
    <h4 style="text-align:center !important"><span style="color:green">Question No <?php echo $total_attempted_quetions+1; ?>.</span></h4>
    <h2 style="text-align:center !important">
      <?php
                    echo file_type(base_url("assets/uploads/".$test_question[0]->question_image), FALSE, 150,150);
                ?>
      <br />
       <?php echo $test_question[0]->question_title ?> </h2>
    </p>
  </div>
  <div class="col-md-offset-4 col-md-4 col-md-offset-4">
    <form id="answer_form" action="<?php echo base_url("student/qustion_answer/"); ?>" method="POST">
      <input type="hidden" name="question_id" value="<?php echo $test_question[0]->question_id; ?>" />
      <input type="hidden" name="test_id" value="<?php echo $test_question[0]->test_id; ?>" />
      <ul class="list-group">
        <li class="list-group-item">
          <div class="radio">
            <label>
              <input id="answer" onclick="submit_answer('<?php echo $test_question[0]->question_id; ?>', '<?php echo $test_question[0]->option_one ?>' )" type="radio" name="answer" value="<?php echo $test_question[0]->option_one ?>" >
              <?php echo $test_question[0]->option_one ?></label>
          </div>
        </li>
        <li class="list-group-item">
          <div class="radio">
            <label>
              <input id="answer"  onclick="submit_answer('<?php echo $test_question[0]->question_id; ?>', '<?php echo $test_question[0]->option_two ?>')" type="radio" name="answer" value="<?php echo $test_question[0]->option_two ?>" >
              <?php echo $test_question[0]->option_two ?></label>
          </div>
        </li>
        
        <?php if($test_question[0]->question_type != 'True/False'){ ?>
        
        <li class="list-group-item">
        
          <div class="radio">
            <label>
              <input id="answer" onclick="submit_answer('<?php echo $test_question[0]->question_id; ?>', '<?php echo $test_question[0]->option_three ?>')" type="radio" name="answer" value="<?php echo $test_question[0]->option_three ?>" >
              <?php echo $test_question[0]->option_three ?></label>
          </div>
        </li>
        <li class="list-group-item">
          <div class="radio">
            <label>
              <input id="answer" onclick="submit_answer('<?php echo $test_question[0]->question_id; ?>', '<?php echo $test_question[0]->option_four ?>')" type="radio" name="answer" value="<?php echo $test_question[0]->option_four ?>" >
              <?php echo $test_question[0]->option_four ?></label>
          </div>
        </li>
        <?php } ?>
        
      </ul>
      <span style="font-size:9px; text-align:center !important"><em><?php echo $test_question[0]->chapter_name." - ".$test_question[0]->question_type  ?></em></span>
    </form>
    <?php }else{ ?>
    <h4 style="text-align:center"><?php echo $title; ?></h4>
    <h3 style="text-align:center">Completed</h3>
    <h5 style="text-align:center"><em>Dear <strong><?php echo $this->session->userdata('student_name') ?></strong> you got <strong><?php echo $test_result->got_marks;  ?></strong> marks out of <strong><?php echo $test_result->total_questions;  ?></strong>. </em><?php //var_dump($test_result); ?></h5>
    <?php } ?>
  </div>
</div>
