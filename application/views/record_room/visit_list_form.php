<style>
    .block_div {
        border: 1px solid #9FC8E8;
        border-radius: 10px;
        min-height: 3px;
        margin: 3px;
        padding: 10px;
        background-color: white;
    }
</style>
<div class="block_div">
    <script>
        function search() {
            var search = $('#search').val();
            var district_id = $('#district_id').val();
            var district_name = $('#district_id :selected').text();
            var search_by = $('input[name="search_type"]:checked').val();

            $.ajax({
                    method: "POST",
                    url: "<?php echo site_url('record_room/school_detail'); ?>",
                    data: {
                        search: search,
                        district_id: district_id,
                        district_name: district_name,
                        search_by: search_by,
                        type: '<?php echo $type; ?>',
                        region: '<?php echo $region; ?>'
                    },
                })
                .done(function(respose) {
                    $('#search_result').html(respose);
                });
        }
    </script>

    <table class="table table-bordered">
        <td>
            <strong>Search By</strong>
            <span style="margin-left: 15px;"></span>
            <input type="radio" name="search_type" class="search_type" value="school_id" checked /> School ID
        </td>
        <td>

            <input type="text" id="search" name="search" value="" class="form-control" />
        </td>
        <td><button onclick="search()">Search</button></td>
        </tr>
    </table>

</div>

<div class="block_div" id="completed_request">
    <div id="search_result" style="overflow-x:auto;">
        <h4>Search school by School ID.</h4>
    </div>
</div>