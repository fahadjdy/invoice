<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
    
<div class="card">
    <div class="card-body">

        <?=$add?>

        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-nowrap mb-0 table-hover"
                id="price_table">
                <thead>
                    <tr>
                        <th>Sq.Ft. ( From - To)</th>
                        <th> Price</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>


<?= $this->endSection() ?>




<?=$this->section('js')?>

<script>
$(document).ready(function () {

    var table = $("#price_table").DataTable({
        scrollY: false,
        scrollX: false,
        serverSide: false,
        processing: false,
        ajax: {
            url: location.origin + '/config/price/getPriceListAjax', // json datasource
            type: "post"
        },
        columns: [
            { data: "sqft" },
            { data: "price" },
            { data: "created_at" },
            { data: "updated_at" },
            { data: "status" },
            { data: "action" }
        ],
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 10001, targets: 2 },
            { responsivePriority: 2, targets: -1 }
        ],
        stateSave: true,
    });

      //   ===== for delete user ========== 
      $(document).on('click', '.delete', function () {
            var price_id = $(this).attr('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#34c3af",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, delete it!"
            }).then(function (t) {
                t.value && $.ajax({
                    type: "post",
                    url: location.origin + "/config/price/deletePrice",
                    data: { price_id: price_id },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status) {
                            Swal.fire("Deleted!", response.msg, "success");
                            table.ajax.reload();
                        } else {
                            Swal.fire("Sorry!", response.msg, "error");
                        }
                    }
                });

            });
        });
});
</script>
<?=$this->endSection('js')?>