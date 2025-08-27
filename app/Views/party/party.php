<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
    
<div class="card">
    <div class="card-body">

        <?=$add?>

        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-nowrap mb-0 table-hover"
                id="UserManagement_table">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Party Name</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Created At</th>
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

    var table = $("#UserManagement_table").DataTable({
        scrollY: false,
        scrollX: false,
        serverSide: false,
        processing: false,
        ajax: {
            url: 'getPartyListAjax',
            type: "post"
        },
        columns: [
            { 
                data: null, 
                render: function (data, type, row, meta) {
                    return meta.row + 1; 
                },
                className: "text-center"
            },
            { data: "name" },
            { data: "address" },
            { data: "status" },
            { data: "created_at" },
            { data: "action" }
        ],
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 10001, targets: 2 },
            { responsivePriority: 2, targets: -1 }
        ],
        // stateSave: true,
    });

      //   ===== for delete user ========== 
      $(document).on('click', '.delete', function () {
            var party_id = $(this).attr('id');
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
                    url: location.origin + "/deleteParty",
                    data: { party_id: party_id },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.is_deleted) {
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