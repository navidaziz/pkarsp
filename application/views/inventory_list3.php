<html>

<head>
	<title>Inventory Management System</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		/* CSS to set a fixed height for the table and add scrollbar */
		.table-wrapper {
			margin: auto;
			width: 1140px;
			height: 400px;
			/* Set the desired height for the table */
			overflow-y: scroll;
		}

		.fixed-header {
			position: sticky;
			top: 0;
			z-index: 1;
			background-color: #ccc;
		}

		.border-right {
			border-right: 1px solid #ccc;
		}

		.page-heading {
			text-align: center;
			font-weight: bold;
			font-size: 40px;
			margin-top: 20px;
			margin-bottom: 60px;
		}

		/* Limit the maximum width of the image */
		#modalImage {
			max-width: 100%;
			height: auto;
		}

		/* Center the image within the modal */
		.image-wrapper {
			text-align: center;
		}
	</style>
</head>

<body>

	<?php if ($this->session->flashdata('error_message')) : ?>
		<div class="alert alert-danger">
			<?php echo $this->session->flashdata('error_message'); ?>
		</div>
	<?php endif; ?>
	<h1 class="page-heading">Inventory Management System</h1>

	<div class="container">
		<div class="row">
			<!-- Add new item form -->
			<div class="col-md-4 border-right" style="background-color: #ADD8E6">
				<h2>Add New Item</h2>
				<form action="<?php echo base_url('inventory/add_item'); ?>" method="post" enctype="multipart/form-data">
					<label for="item_name">Item Name:</label>
					<input type="text" id="item_name" name="name"><br><br>
					<span class="text-danger"><?php echo form_error('name'); ?></span><br><br>
					<label for="item_category">Item Category:</label>
					<select id="category_id" name="category_id">
						<option value="" disabled selected>Select a category</option>
						<?php foreach ($categories as $category) : ?>
							<option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
						<?php endforeach; ?>
					</select> <br><br>
					<label for="item_quantity">Item Quantity:</label>
					<input type="text" id="item_quantity" name="quantity"><br><br>
					<label for="item_description">Description:</label>
					<input type="text" id="item_description" name="description"><br><br>
					<!-- File Upload Field -->
					<label for="item_image">Item Image:</label>
					<input type="file" id="item_image" name="item_image"><br><br>
					<button type="submit" class="btn btn-primary">Add Item</button>
				</form>
			</div>

			<!-- Add new category form -->
			<div class="col-md-4 border-right" style="background-color: #BAB86C">
				<h2>Add Category</h2>
				<form action="<?php echo base_url('inventory/add_category'); ?>" method="post">
					<div class="form-group">
						<label for="category_name">Category Name:</label>
						<input type="text" name="category_name" id="category_name" class="form-control" required>
					</div>
					<button type="submit" class="btn btn-primary">Add Category</button>
				</form>
			</div>

			<!-- Add new official form -->
			<div class="col-md-4" style="background-color: #FFE5B4">
				<h2>Add Official</h2>
				<form method="post" action="<?php echo base_url('inventory/add_official'); ?>">
					<label for="offical_designation">Designation:</label>
					<input type="text" id="offical_designation" name="offical_designation"><br><br>
					<label for="wing">Wing/Section:</label>
					<select id="offical_wing" name="offical_wing">
						<option value="" disabled selected>Select a wing/section</option>
						<?php foreach ($wings as $wing) : ?>
							<option value="<?= $wing['id']; ?>"><?= $wing['wing_name']; ?></option>
						<?php endforeach; ?>
					</select><br><br>
					<button type="submit" class="btn btn-primary">Add Official</button>
				</form>
			</div>
		</div>
	</div>

	<hr>


	<!-- List all items -->
	<h2 style="padding-left: 190px;">List of All Items</h2>
	<div style="padding-left: 190px;">
		<input type="text" id="name-search" placeholder="Search by Name" />
		<input type="text" id="category-search" placeholder="Search by Category" />
	</div>

	<div class="table-wrapper">
		<table id="items-table" class="table table-bordered table-sm solid-border">
			<thead class="fixed-header">
				<tr>
					<th>S.No</th>
					<th>Item Name</th>
					<th>Item Category</th>
					<th>Item Quantity</th>
					<th>Avialable Quantity</th>
					<th>Item Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody style="background-color: #F8F6F0">
				<?php //print_r($items);
				//exit; 
				?>
				<?php $serialNumber = 1; ?>
				<?php foreach ($items as $item) { ?>
					<tr>
						<?php //print_r($item);
						?>
						<td><?php echo $serialNumber; ?></td>
						<td><?php echo $item->name; ?></td>
						<td><?php echo $item->category_name; ?></td>
						<td><?php echo $item->quantity; ?></td>
						<td><?php echo $item->quantity_available; ?></td>
						<td><?php echo $item->description; ?></td>
						<td>
							<?php if ($item->quantity_available > 0) { ?>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-itemname="<?php echo $item->name; ?>" data-itemid="<?php echo $item->id; ?>" data-originalimagepath="<?php echo $item->image_path; ?>" data-quantityavailable="<?php echo $item->quantity_available; ?>">
									Allot Item
								</button>
								<!-- 	<button onclick="document.getElementById('overlay').style.display='block'">Allot</button>-->
							<?php } else { ?>
								<button disabled class="btn btn-primary">Allot Item</button>
							<?php } ?>

							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addQuantityModal" data-itemid="<?php echo $item->id; ?>" data-itemdescription="<?php echo $item->description; ?>">
								Add Quantity
							</button>
							<!-- Check if image_path is available and enable/disable the button -->
							<?php if ($item->image_path) : ?>
								<button class="btn btn-primary view-image-button" data-toggle="modal" data-target="#imageModal" data-image="<?= 'https://psra.gkp.pk/' . $item->image_path; ?>">View Image</button>
							<?php else : ?>
								<button class="btn btn-secondary" disabled>View Image</button>
							<?php endif; ?>
						</td>
					</tr>
					<?php $serialNumber++; ?>
				<?php } ?>
			</tbody>

			<tfoot>
				<tr id="sum-row" style="font-weight: bold; display: none;">
					<td colspan="3" style="text-align: right;">Total</td>
					<td id="total-quantity"></td>
					<td id="total-available-quantity"></td>
					<td colspan="2"></td>
				</tr>
			</tfoot>

		</table>
	</div>
	<hr>
	<!-- The Modal for allot items -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Allot Item</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form id="myForm" style="display: none;" action="<?php echo base_url('inventory/allot_item'); ?>" method="post" enctype="multipart/form-data"> <!-- Hide the form initially -->
						<div class="form-group">

							<input type="hidden" id="allot_id" name="allot_id"><br><br>
							<input type="hidden" id="original_image_path" name="original_image_path"><br><br>
							<!--<p>Original Name: <span id="original_image_path"></span></p>-->
							<p>Item Name: <span id="name_item"></span></p>
							<p>Available Quantity: <span id="quantity_available"></span></p>
							<label for="official_desig">Official Designation:</label>
							<select id="official_desig" name="official_desig">
								<?php foreach ($officials as $official) : ?>
									<option value="<?= $official['id']; ?>"><?= $official['designation']; ?></option>
								<?php endforeach; ?>
							</select><br><br>
							<label for="allot_quantity">Allot Quantity:</label>
							<input type="number" class="form-control" id="allot_quantity" name="allot_quantity"><br><br>
							<label for="allot_desc">Description:</label>
							<input type="text" class="form-control" id="allot_desc" name="allot_desc"><br><br>
							<label for="allotment_date">Allotment Date:</label>
							<input type="date" class="form-control" id="allotment_date" name="allotment_date"><br><br>
							<label for="item_image_allot">Item Image:</label>
							<input type="file" id="item_image_allot" name="item_image_allot"><br><br>
							<button type="submit" class="btn btn-primary">Allot</button>
						</div>
					</form>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>

	<!-- The Add Quantity Modal -->
	<div class="modal fade" id="addQuantityModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Quantity</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form id="addQuantityForm" action="<?php echo base_url('inventory/add_quantity'); ?>" method="post">
						<input type="hidden" id="addQuantityItemId" name="item_id">
						<div class="form-group">
							<label for="addQuantity">Quantity:</label>
							<input type="number" class="form-control" id="addQuantity" name="add_quantity" min="1" required>
						</div>
						<div class="form-group">
							<label for="itemDescription">Description:</label>
							<input type="text" class="form-control" id="itemDescription" name="item_description" value="" required>
						</div>
						<button type="submit" class="btn btn-primary">Add</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Hidden Modal for showing image of all items-->
	<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="imageModalLabel">View Image</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="image-wrapper">
						<img id="modalImage" src="" alt="Item Image">
					</div>
				</div>
			</div>
		</div>
	</div>

	<h2 style="padding-left: 190px;">List of Alloted Items</h2>
	<div style="padding-left: 190px;">
		<input type="text" id="item-name-search" placeholder="Search by Item Name" />
		<input type="text" id="item-category-search" placeholder="Search by Category" />
		<input type="text" id="official-designation-search" placeholder="Search by Official Designation" />
		<input type="text" id="wing-name-search" placeholder="Search by Wing Name" />
	</div>
	<div class="table-wrapper">
		<table id="allotted-items-table" class="table table-bordered table-sm solid-border">
			<thead class="fixed-header">
				<tr>
					<th>S.No</th>
					<th>Item Name</th>
					<th>Category Name</th>
					<th>Official Designation</th>
					<th>Wing Name</th>
					<th>Quantity Remaining</th>
					<th>Item Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody style="background-color: #F8F6F0">
				<?php $serialNumber = 1; ?>
				<?php foreach ($allotedItems as $allotedItem) { ?>
					<tr>
						<td><?php echo $serialNumber; ?></td>
						<td><?php echo $allotedItem->item_name; ?></td>
						<td><?php echo $allotedItem->category_name; ?></td>
						<td><?php echo $allotedItem->official_designation; ?></td>
						<td><?php echo $allotedItem->wing_name; ?></td>
						<td><?php echo $allotedItem->quantity_remaining; ?></td>
						<td><?php echo $allotedItem->item_desc; ?></td>
						<td>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2" data-itemname="<?php echo $allotedItem->item_name; ?>" data-itemid="<?php echo $allotedItem->id; ?>" data-quantityremaining="<?php echo $allotedItem->quantity_remaining; ?>" data-officialdesig="<?php echo $allotedItem->official_designation; ?>">
								Return Item
							</button>

							<?php if (!empty($allotedItem->image_path)) : ?>
								<button class="btn btn-primary view-image-button" data-toggle="modal" data-target="#imageModal" data-image="<?= 'https://psra.gkp.pk/' . $allotedItem->item_image_path; ?>">View Image</button>
							<?php elseif (!empty($allotedItem->item_image_path)) : ?>
								<button class="btn btn-primary view-image-button" data-toggle="modal" data-target="#imageModal" data-image="<?= 'https://psra.gkp.pk/' . $allotedItem->item_image_path; ?>">View Image</button>
							<?php else : ?>
								<button class="btn btn-secondary" disabled>View Image</button>
							<?php endif; ?>
						</td>
					</tr>
					<?php $serialNumber++; ?>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr id="sum-row-allotted" style="font-weight: bold; display: none;">
					<td colspan="5" style="text-align: right;">Total</td>
					<td id="total-quantity-remaining"></td>
					<td colspan="2"></td>
				</tr>
			</tfoot>
		</table>
	</div>

	<hr>
	<!-- The Modal for return items -->
	<div class="modal fade" id="myModal2">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Return Item</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form id="myForm2" style="display: none;" action="<?php echo base_url('inventory/return_item'); ?>" method="post"> <!-- Hide the form initially -->
						<div class="form-group">

							<input type="hidden" id="return_id" name="id_allot"><br><br>
							<p>Item Name: <span id="name_item_return"></span></p>
							<p>Alloted to: <span id="offical_desig_return"></span></p>
							<p>Alloted Quantity: <span id="quantity_remaining"></span></p>
							<label for="allot_quantity">Return Quantity:</label>
							<input type="number" class="form-control" id="return_quantity" name="return_quantity"><br><br>
							<label for="allotment_date">Return Date:</label>
							<input type="date" class="form-control" id="return_date" name="return_date"><br><br>
							<button type="submit" class="btn btn-primary">Return Item</button>
						</div>
					</form>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>


	<!-- Script to handle allot item form display -->
	<script>
		$(document).ready(function() {
			// Show the form when the "Open Form" button is clicked
			$("button[data-target='#myModal']").click(function() {
				var itemName = $(this).data("itemname");
				var itemId = $(this).data("itemid");
				var originalImagePath = $(this).data("originalimagepath");
				var quantityAvailable = $(this).data("quantityavailable");

				alert(originalImagePath);

				$("#name_item").text(itemName);
				$("#allot_id").val(itemId);
				$("#original_image_path").val(originalImagePath);
				$("#quantity_available").text(quantityAvailable);
				$("#allot_quantity").attr("max", quantityAvailable);
				$("#allot_quantity").val(""); // Clear the previously entered value

				// Add client-side validation for the allotted quantity
				$("#myForm").submit(function(e) {
					var allottedQuantity = parseInt($("#allot_quantity").val());
					if (allottedQuantity <= 0 || allottedQuantity > quantityAvailable) {
						e.preventDefault(); // Prevent form submission
						if (allottedQuantity <= 0) {
							alert("Allotted quantity must be greater than zero.");
						} else {
							alert("Allotted quantity cannot exceed the available quantity.");
						}
					}
				});

				$("#myForm").show();
			});

		});
	</script>

	<!-- Script to handle add quantiy button in list of items -->
	<script>
		$(document).ready(function() {
			// Handle click on "Add Quantity" button
			$("button[data-target='#addQuantityModal']").click(function() {
				var itemId = $(this).data("itemid");
				var itemDescription = $(this).data('itemdescription');
				$("#addQuantityItemId").val(itemId);
				$("#itemDescription").val(itemDescription);
				$("#addQuantity").val(""); // Clear the previously entered value
			});
		});
	</script>

	<!-- Script to handle return item form display -->
	<script>
		$(document).ready(function() {
			// Show the form when the "Open Form" button is clicked
			$("button[data-target='#myModal2']").click(function() {
				var itemName = $(this).data("itemname");
				var itemId = $(this).data("itemid");
				var quantityRemaining = $(this).data("quantityremaining");
				var officialDesignation = $(this).data("officialdesig");


				$("#name_item_return").text(itemName);
				$("#return_id").val(itemId);
				$("#quantity_remaining").text(quantityRemaining);
				$("#offical_desig_return").text(officialDesignation);
				$("#return_quantity").attr("max", quantityRemaining);
				$("#return_quantity").val(""); // Clear the previously entered value

				// Add client-side validation for the returned quantity
				$("#myForm2").submit(function(e) {
					var returnedQuantity = parseInt($("#return_quantity").val());
					if (returnedQuantity <= 0 || returnedQuantity > quantityRemaining) {
						e.preventDefault(); // Prevent form submission
						if (returnedQuantity <= 0) {
							alert("Returned quantity must be greater than zero.");
						} else {
							alert("Returned quantity cannot exceed the alloted quantity.");
						}
					}
				});

				$("#myForm2").show();
			});

		});
	</script>


	<script type="text/javascript">
		// Get the input elements and table
		const nameSearchInput = document.getElementById('name-search');
		const categorySearchInput = document.getElementById('category-search');
		const table = document.getElementById('items-table');
		const headerRow = table.rows[0];
		const sumRow = document.getElementById('sum-row');


		// Add event listeners to the search inputs
		nameSearchInput.addEventListener('input', performSearch);
		categorySearchInput.addEventListener('input', performSearch);

		// Function to perform the search
		function performSearch() {
			const nameFilter = nameSearchInput.value.toLowerCase();
			const categoryFilter = categorySearchInput.value.toLowerCase();
			const totalQuantityCell = document.getElementById('total-quantity');
			const totalAvailableQuantityCell = document.getElementById('total-available-quantity');

			let totalQuantity = 0;
			let totalAvailableQuantity = 0;
			let rowCount = 0;
			// Iterate through each row of the table (excluding the header row)
			for (let i = 1; i < table.rows.length; i++) {
				const row = table.rows[i];
				const itemName = row.cells[1].textContent.toLowerCase();
				const itemCategory = row.cells[2].textContent.toLowerCase();

				// Check if the row matches the search criteria
				const nameMatch = itemName.includes(nameFilter);
				const categoryMatch = itemCategory.includes(categoryFilter);

				// Show/hide the row based on the search criteria
				row.style.display = nameMatch && categoryMatch ? '' : 'none';

				if (nameMatch && categoryMatch) {
					// Calculate the sum of quantity and available quantity
					totalQuantity += parseInt(row.cells[3].textContent);
					totalAvailableQuantity += parseInt(row.cells[4].textContent);
					rowCount++;
				}
				// Update the total quantity and total available quantity in the sum row
				totalQuantityCell.textContent = totalQuantity.toString();
				totalAvailableQuantityCell.textContent = totalAvailableQuantity.toString();

				// Show/hide the sum row based on the number of matched rows
				sumRow.style.display = rowCount > 0 ? 'table-row' : 'none';
			}
		}
	</script>

	<script type="text/javascript">
		// Get the input elements and table
		const itemNameSearchInput = document.getElementById('item-name-search');
		const itemCategorySearchInput = document.getElementById('item-category-search');
		const officialDesignationSearchInput = document.getElementById('official-designation-search');
		const wingNameSearchInput = document.getElementById('wing-name-search');
		const tableAllottedItems = document.getElementById('allotted-items-table');
		const headerRowAllot = tableAllottedItems.rows[0];
		const sumRowAllotted = document.getElementById('sum-row-allotted');

		// Add event listeners to the search inputs
		itemNameSearchInput.addEventListener('input', performSearchAllotted);
		itemCategorySearchInput.addEventListener('input', performSearchAllotted);
		officialDesignationSearchInput.addEventListener('input', performSearchAllotted);
		wingNameSearchInput.addEventListener('input', performSearchAllotted);

		// Function to perform the search
		function performSearchAllotted() {
			const itemNameFilter = itemNameSearchInput.value.toLowerCase();
			const itemCategoryFilter = itemCategorySearchInput.value.toLowerCase();
			const officialDesignationFilter = officialDesignationSearchInput.value.toLowerCase();
			const wingNameFilter = wingNameSearchInput.value.toLowerCase();
			const totalQuantityRemainingCell = document.getElementById('total-quantity-remaining');

			let totalQuantityRemaining = 0;
			let rowCountAllotted = 0;

			//  alert(rowCountAllotted);
			// Iterate through each row of the table (excluding the header row)
			for (let i = 1; i < tableAllottedItems.rows.length; i++) {
				const rowAllotted = tableAllottedItems.rows[i];
				const itemNameAllotted = rowAllotted.cells[1].textContent.toLowerCase();
				const itemCategoryAllotted = rowAllotted.cells[2].textContent.toLowerCase();
				const officialDesignation = rowAllotted.cells[3].textContent.toLowerCase();
				const wingName = rowAllotted.cells[4].textContent.toLowerCase();

				// Check if the row matches the search criteria
				const itemNameMatch = itemNameAllotted.includes(itemNameFilter);
				const itemCategoryMatch = itemCategoryAllotted.includes(itemCategoryFilter);
				const officialDesignationMatch = officialDesignation.includes(officialDesignationFilter);
				const wingNameMatch = wingName.includes(wingNameFilter);

				// Show/hide the row based on the search criteria
				rowAllotted.style.display = itemNameMatch && itemCategoryMatch && officialDesignationMatch && wingNameMatch ? '' : 'none';

				if (itemNameMatch && itemCategoryMatch && officialDesignationMatch && wingNameMatch) {
					// Calculate the sum of quantity remaining
					totalQuantityRemaining += parseInt(rowAllotted.cells[5].textContent);
					rowCountAllotted++;
				}
				// Update the total quantity remaining in the sum row
				totalQuantityRemainingCell.textContent = totalQuantityRemaining.toString();
				// Show/hide the sum row based on the number of matched rows
				sumRowAllotted.style.display = rowCountAllotted > 0 ? 'table-row' : 'none';
			}

		}
	</script>

	<script>
		// script for displaying image
		$(document).ready(function() {
			$('.view-image-button').click(function() {
				var imageURL = $(this).data('image');
				$('#modalImage').attr('src', imageURL);
			});
		});
	</script>

</body>

</html>