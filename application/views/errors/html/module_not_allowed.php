<div class="content-wrapper">

	<section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">

		<div style=" margin:0px auto; width:100%; text-align:center !important;">
			<div style="margin:150px !important;">

				<h1 style="color: #d9534f;  font-size: 80px;  ">Access Denied</h1>
				<div class="content">
					<h3>Oops! Something went wrong</h3>
					<p>You are not allowed to access this module <span style="color:red;">( <i><?php echo $_GET['module'] ?></i> )</span>. If you suspect an error, please contact KPPSRA MIS Wing <a style="font-weight: bold; color:red" href="tel:+92091-9216205">
							<i class="fa fa-phone" aria-hidden="true"></i>
							091-9216205 </a> for assistance. Thank you.</p>
					<div class="btn-group">
						<a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Go Back</a>
					</div>
				</div>

			</div>

		</div>

	</section>
</div>