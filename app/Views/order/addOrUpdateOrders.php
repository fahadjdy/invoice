<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row card p-3">
        <form id="OrdersForm" method="post">
            <div class="row">
                <div class="col-lg-1">
                    <label for="" class="p-0 m-0">Orders Id</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" readonly type="text" class="form-control p-0 px-2"
                            placeholder="Orders orders_id" required="" value="<?= (isset($data)) ? $data['orders_id'] : '' ?>">
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="" class="p-0 m-0">Select Party Name</label>
                    <div class="input-group mb-2">
                        <select class="form-control p-0 px-2 form-select" name="party_id" id="partyList"></select>
                    </div>
                </div>

                <div class="col-lg-5">
                    <label for="" class="p-0 m-0">Orders Name</label>
                    <?= (isset($edit) ? '<input type="hidden" name="orders_id" value="' . $edit . '">' : '') ?>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="text" id="name" name="name" class="form-control p-0 px-2"
                            placeholder="name" required="" value="<?= (isset($data['name'])) ? $data['name'] : '' ?>">
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="" class="p-0 m-0 ">Select Order Status</label>
                    <div class="input-group mb-3">
                        <select class="form-control p-0 px-2 form-select" name="status" id="status1">
                            <option value="1" <?= (isset($data['status']) && $data['status'] == 1) ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= (isset($data['status']) && $data['status'] == 0) ? 'selected' : '' ?>>Deactive</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <label for="" class="p-0 m-0">Select Invoice Format</label>
                    <div class="input-group mb-2">
                        <select class="form-control p-0 px-2 form-select" name="invoice_id" id="invoiceList"></select>
                    </div>
                </div>

                <table width="100%" class="table">
                    <thead>
                        <tr>
                            <td>Sr.No.</td>
                            <td>Frame Image</td>
                            <td>Location</td>
                            <td>Product</td>
                            <td>Extra Product</td>
                            <td>Size <small>(in inch)</small></td>
                            <td>Price</td>
                            <td>Qty.</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-center">
                                <button type="button" class="addButton" onClick="addRow();"> + </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-primary px-4" value="Submit" id="SubmitBtn">
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .addButton {
        border: 0px solid #000;
        border-radius: 30px;
        padding: 10px 20px;
    }
    .removeButton {
        border: 0px;
        background-color: #dc3545;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<?= $this->endSection('content') ?>

<?= $this->section('js') ?>

<script>
    let rowIndex = 1;

    function init() {
        getPartyNameList();
        getInvoiceFormateList();
        if ('<?= isset($transactions) ?>') {
            populateOrderDetails();
        }

    }

    $(document).on('setSelectedOption', function() {
        var invoiceId = <?= json_encode($data['invoice_id'] ?? null) ?>;
        $(`#invoiceList option[value="${invoiceId}"]`).prop('selected', true);
    });

    function populateOrderDetails() {
        // Populate party list')
        $.each($('#partyList option'), function(index, option) {
            if (option.value == '<?= $data['party_id'] ?? null ?>') {
                $(option).prop('selected', true);
            }
        });

        // Populate transaction rows
        const transactions = <?= json_encode(isset($transactions) ? $transactions : []) ?>;
        transactions.forEach(transaction => {
            addRow(fetchProductOptions);
        });


    }
    
   
async function addRow() {
    try {
        // Get the next row index and transaction ID
       
        // let rowIndex = $('tbody tr').length + 1;

        // Fetch options for location and product dropdowns
        const [locationOptions, productOptions , invoiceFormateOptions] = await Promise.all([
            fetchLocationOptions(),
            fetchProductOptions(),
            fetchFrameImageOptions()
        ]);

        // Construct the new row
        const row = `<tr>
                        <td>${rowIndex}</td>
                          <td width="20%"><select  name="frame_image_id[]" class="form-control">${invoiceFormateOptions}</select></td>
                        <td width="10%"><select name="location_id[]" class="form-control" id="locationList">${locationOptions}</select></td>
                        <td width="20%"><select multiple="multiple"  name="product_id[${rowIndex}][]" class="form-control">${productOptions}</select></td>
                        <td><textarea name="extra_product[]" cols="30" rows="3" class="form-control"></textarea></td>
                        <td width="15%"><span class="d-flex"><input type="number" name="size1[]" class="form-control">*<input type="number" name="size2[]" class="form-control"></span></td>
                        <td width="10%"><input type="number" name="price[]" class="form-control"></td>
                        <td width="5%"><input type="number" name="qty[]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger removeButton" onClick="removeRow(this);">Remove</button></td>
                    </tr>`;

        // Append the new row to the table body
        $('tbody').append(row);
        $('select').select2();
    } catch (error) {
        console.error(error);
    }
}
        
    function removeRow(button) {
        $(button).closest('tr').remove();
        var transaction_id = $(button).closest('tr').attr('data-transaction-id');
        if(transaction_id !== null){
            $.ajax({
                type: "POST",
                url: location.origin + "/orders/transaction/delete",
                data: {transaction_id : transaction_id},
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        successToast(response.message);
                    }else{
                        failToast(response.message);                        
                    }
                }
            });
        }
    }

    $(document).ready(function() {
        init();
        
        const orderId = <?= (isset($data)) ? $data['orders_id'] : '' ?>; // Replace with actual order ID
        populateRows(orderId);

        $('#OrdersForm').validate({
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter Orders name.",
                }
            },
            submitHandler: function(form) {
                submitForm();
            }
        });
    });

    function submitForm() {
        var form = $('#OrdersForm')[0];
        var fd = new FormData(form);
        $.ajax({
            type: "POST",
            url: location.origin + "/orders/saveOrders",
            data: fd,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(response) {
                location.href = location.origin + "/order";
            }
        });
    }
</script>

<?= $this->endSection('js') ?>
