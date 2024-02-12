<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>


<div class="content-wrapper">
	<section class="content-header">
		<div class='row'>
			<div class='col-md-6'>
				<div class='clearfix'>
					<h3 class='content-title pull-left'><?php echo $title; ?>
						<br />
						Dashboard
					</h3>
				</div>
				<small><?php echo @$description; ?></small>
			</div>
			<div class='col-md-6' style="font-size: 10px;">
				<ol class="breadcrumb">
					<li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
					<!-- <li><a href="#">Examples</a></li> -->
					<li class="active"><?php echo @ucfirst($title); ?>s</li>
				</ol>
				<div class='pull-right' id="fine_summary"></div>
			</div>
		</div>
	</section>

	<!-- Main content -->
	<section class="content">



		<div class="block_div">
			<h4>
				Search Institute by School Name, SID or Registration Number.
			</h4>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group col-md-3">
						<label for="email">Registered / Un-Registered</label>
						<select onchange="search_list()" class="form-control select2" name="reg_un_reg" id="reg_un_reg">
							<option value="">List</option>
							<option value="1">Registered List</option>
							<option value="2">Unregistered List</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="email">Institutes Level</label>
						<select onchange="search_list()" class="form-control select2" name="level" id="level">
							<option value="">Levels</option>
							<?php
							$query = "SELECT * FROM levelofinstitute";
							$levels = $this->db->query($query)->result();
							foreach ($levels as $level) {
							?>
								<option value="<?php echo $level->levelofInstituteId; ?>"><?php echo $level->levelofInstituteTitle; ?></option>
							<?php } ?>
							<option value="2">Unregistered List</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="email">District</label>
						<select onchange="search_list()" class="form-control select2" name="district_id" id="district_id">
							<option value="0">All Districts</option>
							<?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
							$districts = $this->db->query($query)->result();
							foreach ($districts as $district) {
							?>
								<option value="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="email">Institute Name, SID or Registration No</label>
						<input onkeyup="search_list()" type="text" id="search_list" name="search_list" value="" style="width: 100%; display: block;
                                padding-left: 8px;
                                padding-right: 20px;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                                color: #444;
                                line-height: 28px;" />
					</div>
					<div class="form-group col-md-1">
						<label for="email">Search</label>
						<button class="btn btn-primary" onclick="search_list()">Search</button>
					</div>
				</div>
			</div>
		</div>


		<script>
			function search_list() {
				var search = $('#search_list').val();
				var district_id = $('#district_id').val();
				var reg_un_reg = $('#reg_un_reg').val();
				var level = $('#level').val();

				$.ajax({
						method: "POST",
						url: "<?php echo site_url('fms/fine_management/search_detail'); ?>",
						data: {
							search: search,
							district_id: district_id,
							reg_un_reg: reg_un_reg,
							level: level
						},
					})
					.done(function(respose) {
						$('#search_result').html(respose);
					});
			}
		</script>



		<div id="search_result"></div>


		<div class="table-responsive">


			<table id="ajax_fine_list" class="table table-bordered table-striped" style="font-size: 10px !important;">
				<thead>

					<tr>
						<th>#</th>
						<th>School ID</th>
						<th>Reg No.</th>
						<th>School Name</th>
						<th>District</th>
						<th>Tehsil</th>
						<th>UC</th>
						<th>Address</th>
						<th>Level</th>
						<th>Frequency</th>
						<th>Total Fine</th>
						<th>Total Waived Off</th>
						<th>Total Fine Payable</th>
						<th>Total Fine Paid</th>
						<th>Total Fine Remaining</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody id="fine_school_list"></tbody>
			</table>
		</div>

	</section>
</div>




<script>
	function fined_school_list() {
		$.ajax({
				method: "POST",
				url: "<?php echo site_url("fms/fine_management/fined_school_list"); ?>",
				data: {},
			})
			.done(function(respose) {
				$('#fine_school_list').html(respose);
			});
	}

	function fined_summary() {
		$.ajax({
				method: "POST",
				url: "<?php echo site_url("fms/fine_management/fined_summary"); ?>",
				data: {},
			})
			.done(function(respose) {
				$('#fine_summary').html(respose);
			});
	}

	$(document).ready(function() {
		fined_school_list();
		fined_summary();
	});
</script>