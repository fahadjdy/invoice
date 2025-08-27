<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
    
<div class="card">
    <div class="card-body">

        <?=$add?>

        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-nowrap mb-0 table-hover"
                id="frame_image_table">
                <thead>
                    <tr>
                        <th>Frame Image</th>
                        <th>Frame name</th>
                        <th>Status</th>
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

    var table = $("#frame_image_table").DataTable({
        scrollY: false,
        scrollX: false,
        serverSide: false,
        processing: false,
        ajax: {
            url: location.origin + '/getFrameImageListAjax', // json datasource
            type: "post"
        },
         order: [[3, 'desc']],
        columns: [
            { 
                data: "url",
                render: function (data, type, row) {
                    // Make sure to handle cases where data might be null or empty
                    return data ? `<img src="${location.origin+'/assets/images/FrameImage/'+data}" alt="${row.name}" style="max-width: 70px; max-height: 70px;" />` : 'No image';
                }
            },
            { data: "name" },
            { data: "status" },
            { data: "created_at" },
            { data: "updated_at" },
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
            var frame_image_id = $(this).attr('id');
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
                    url: location.origin + "/deleteFrameImage",
                    data: { frame_image_id: frame_image_id },
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