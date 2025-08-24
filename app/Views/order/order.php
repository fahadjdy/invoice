<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
    
<div class="card">
    <div class="card-body">

        <?=$add?>

        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-nowrap mb-0 table-hover"
                id="orders_table">
                <thead>
                    <tr>
                        <th>Orders Id</th>
                        <th>Orders Name</th>
                        <th>Party Name</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
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
    var table = $("#orders_table").DataTable({
    processing: true,
    // serverSide: false,
    // order: [[0, 'desc']], // sort by orders_id descending
    ajax: {
        url: "<?=base_url('orders/getOrdersListAjax')?>",
        type: "post"
    },
    columns: [
        { data: "orders_id" },
        { data: "name" },
        { data: "party_name" },
        { data: "created_at" },
        { data: "updated_at" },
        { data: "action" }
    ],
    columnDefs: [
        { targets: 0, type: "num" }, // orders_id treated as number
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 10001, targets: 2 },
        { responsivePriority: 2, targets: -1 }
    ],
    responsive: true,
    stateSave: true
});

    // Delete action
    $(document).on('click', '.delete', function () {
        var orders_id = $(this).attr('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#34c3af",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, delete it!"
        }).then(function (t) {
            if (t.value) {
                $.ajax({
                    type: "post",
                    url: location.origin + "/orders/deleteOrders",
                    data: { orders_id: orders_id },
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
            }
        });
    });
});

</script>
<?=$this->endSection('js')?>