<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Fine Amount Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Fine Category</th>
                            <th>Fine Type</th>
                            <th>Amount</th>
                        </tr>
                        <?php
                        $query = "SELECT fine_amount_details.*, 
                        fine_types.fine_type_category,
                        `fine_types`.`fine_title`
                        FROM `fine_amount_details` 
                        INNER JOIN fine_types ON (fine_types.fine_type_id = fine_amount_details.fine_type_id) 
                        WHERE fine_id = '" . $fine_id . "'";
                        $fine_amounts = $this->db->query($query)->result();
                        $count = 1;
                        foreach ($fine_amounts as $fine_amount) {
                        ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $fine_amount->fine_type_category; ?></td>
                                <td><?php echo $fine_amount->fine_title; ?></td>
                                <td><?php echo $fine_amount->amount; ?></td>
                            </tr>
                        <?php } ?>
                        <?php
                        $query = "SELECT SUM(fine_amount_details.amount) as total
                        FROM `fine_amount_details`
                        WHERE fine_id = '" . $fine_id . "'";
                        $fine_amount = $this->db->query($query)->row();

                        ?>
                        <tr>
                            <td style="text-align: right;" colspan="3">Total</td>
                            <td><?php echo $fine_amount->total; ?></td>

                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>