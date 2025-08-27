<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
    
<div class="card">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-nowrap mb-0 table-hover"
                id="UserManagement_table">
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Party Name</th>
                        <th>Referral Name</th>
                        <th class="text-center">Total Transaction</th>
                        <th>Order Date</th>
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {

    var table = $("#UserManagement_table").DataTable({
        scrollY: false,
        scrollX: false,
        serverSide: false,
        processing: false,
        ajax: {
            url: 'getReferralListAjax', 
            type: "post"
        },
        columns: [
            { data: "orders_id" },
            { data: "party_name" },
            { data: "referral_name" },
            { data: "total_amount", className: "text-center" },
            { data: "created_at" }
        ],
        responsive: true,
        stateSave: true,
        dom: 'Bfrtip', // Buttons container
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'Export PDF',
                exportOptions: {
                    columns: [0, 1, 3, 4] // Exclude Referral Name column
                },
                title: function() {
                    var data = table.rows({ search: 'applied' }).data();
                    return data.length > 0 ? data[0].referral_name : 'Referral List';
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.defaultStyle.fontSize = 10;
                }
            },
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                exportOptions: {
                    columns: [0, 1, 3, 4] 
                }
            },
            {
                extend: 'csvHtml5',
                text: 'Export CSV',
                exportOptions: {
                    columns: [0, 1, 3, 4] 
                }
            }
        ]
    });

});
</script>
<?=$this->endSection('js')?>