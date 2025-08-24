<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<?php  //p($transactions); ?>
<div class="container-fluid">
    <div class="row card p-3">
        <form id="OrdersForm" method="post">
            <div class="row">
            <?php  if(!empty($data['orders_id'])) { ?>
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
                <?php } ?>

                <div class="col-lg-3">
                    <label for="" class="p-0 m-0">Select Party Name</label>
                    <div class="input-group mb-2">
                        <select class="form-control p-0 px-2 form-select" name="party_id" id="partyList1">
                            <option value="">Select Party</option>
                        </select>
                    </div>
                </div>

                
                <div class="col-lg-3">
                    <label for="" class="p-0 m-0">Select Reference Name</label>
                    <div class="input-group mb-2">
                        <select class="form-control p-0 px-2 form-select" name="ref_id" id="reference">
                            <option value="">Select Reference</option>
                        </select>
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
                    <label for="" class="p-0 m-0">Select Invoice Format</label>
                    <div class="input-group mb-2">
                        <select class="form-control p-0 px-2 form-select" name="invoice_id" id="invoiceList">
                            <option value="">Select Invoice Format</option>
                        </select>
                    </div>
                </div>

                <div style="overflow-x: auto; width: 100%;">
                <table width="100%" class="table">
                    <thead>
                        <tr>
                            <td style="width:100px">Sr.No.</td>
                            <td style="width:200px">Frame Image</td>
                            <td style="width:250px">Location</td>
                            <td style="width:400px">Product</td>
                            <td style="width:100px">Extra Product</td>
                            <td style="width:200px">Size <small>(in inch)</small></td>
                            <td style="width:100px">Price</td>
                            <td style="width:100px">Qty.</td>
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
                </div>

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
    .select2-container {
        width: 100% !important;
    }
</style>

<?= $this->endSection('content') ?>

<?= $this->section('js') ?>
<script>
    let rowIndex = 1;

    function init() {
        // Call these functions immediately on page load
        getPartyNameList();
        getInvoiceFormateList();
        
        // If transactions exist, populate after a delay to ensure dropdowns are loaded
        if (<?= isset($transactions) ? 'true' : 'false' ?>) {
            setTimeout(() => {
                populateOrderDetails();
            }, 1000);
        }
    }

    function getPartyNameList() {
        $.ajax({
            url: '<?= base_url('orders/getPartyNameList') ?>',
            type: 'GET',
            success: function(response) {
                if (response.status) {
                    let partyId = '<?= $data['party_id'] ?? '' ?>';
                    let ref_id  = '<?= $data['ref_id'] ?? '' ?>';
                    let partyList = $('#partyList1');
                    let reference = $('#reference');
                    
                    partyList.empty();
                    reference.empty();
                    partyList.append('<option >Select Party</option>');
                    reference.append('<option >Select Party</option>');

                    $.each(response.data, function(index, party) {
                        let selected = (party.party_id == partyId) ? 'selected' : '';
                        partyList.append(`<option value="${party.party_id}" ${selected}>${party.party_name}</option>`);
                        reference.append(`<option value="${party.party_id}" ${selected}>${party.party_name}</option>`);
                    });

                    // Explicitly set the value after populating options
                    if (partyId) {
                        partyList.val(partyId);
                    }

                    if (ref_id) {
                        reference.val(ref_id);
                    }
                }
            }
        });
    }

    function getInvoiceFormateList() {
        $.ajax({
            url: '<?= base_url('orders/getInvoiceFormateList') ?>',
            type: 'GET', 
            success: function(response) {
                if (response.status) {
                    let invoiceId = '<?= $data['invoice_id'] ?? '' ?>';
                    let invoiceList = $('#invoiceList');
                    
                    invoiceList.empty();
                    invoiceList.append('<option value="">Select Invoice Format</option>');

                    $.each(response.data, function(index, invoice) {
                        let selected = (invoice.invoice_id == invoiceId) ? 'selected' : '';
                        invoiceList.append(`<option value="${invoice.invoice_id}" ${selected}>${invoice.invoice_name}</option>`);
                    });

                    // Explicitly set the value after populating options
                    if (invoiceId) {
                        invoiceList.val(invoiceId);
                    }
                }
            }
        });
    }

    function populateOrderDetails() {
        // Populate party list
        const partyId = <?= json_encode($data['party_id'] ?? '') ?>;
        if (partyId) {
            $('#partyList1').val(partyId);
        }

        // Populate order status
        const orderStatus = <?= json_encode($data['status'] ?? '') ?>;
        if (orderStatus) {
            $('#orderStatus').val(orderStatus).trigger('change');
        }

        // Populate invoice format
        const invoiceId = <?= json_encode($data['invoice_id'] ?? '') ?>;
        if (invoiceId) {
            $('#invoiceList').val(invoiceId);
        }

        // Populate transaction rows
        const transactions = <?= json_encode(isset($transactions) ? $transactions : []) ?>;
        if (transactions && transactions.length) {
            $('tbody').empty();
            rowIndex = 1;
            
            transactions.forEach(transaction => {
                addRow(transaction);
            });
        }
    }

    async function addRow(transaction = null) {
    try {
        // Fetch all required options asynchronously
        const [locationOptions, productOptions, frameImageOptions] = await Promise.all([
            fetchLocationOptions(),
            fetchProductOptions(),
            fetchFrameImageOptions(),
        ]);

        const transactionId = transaction ? transaction.transaction_id : '';

        // Generate new row
        const row = `<tr data-row-index="${rowIndex}">
                        <td>${rowIndex}</td>
                        <td width="200px">
                            ${transactionId ? `<input type="hidden" name="transaction_id[]" value="${transactionId}">` : ''}
                            <select name="frame_image_id[]" class="form-control select2-frame">
                                <option value="">Select Frame Image</option>
                                ${frameImageOptions}
                            </select>
                        </td>
                        <td width="350px">
                            <select multiple="multiple" name="location_id[${rowIndex}][]" class="form-control location-select select2-location" onchange="updateSizePriceQty(this, ${rowIndex})">
                                ${locationOptions}
                            </select>
                        </td>
                        <td width="400px">
                            <select multiple="multiple" name="product_id[${rowIndex}][]" class="form-control select2-product">
                                ${productOptions}
                            </select>
                        </td>
                        <td>
                            <textarea style="width:150px" name="extra_product[]" cols="30" rows="3" class="form-control"></textarea>
                        </td>
                        <td width="350px" class="size-price-qty-container-${rowIndex}">
                            <div class="location-fields">
                                <span class="d-flex" style="width:200px">
                                    <input type="number" style="width:auto" name="size1[${rowIndex}][]" class="form-control"> *
                                    <input type="number" style="width:auto" name="size2[${rowIndex}][]" class="form-control">
                                </span>
                            </div>
                        </td>
                        <td width="100px" class="price-container-${rowIndex}">
                            <input type="number" name="price[${rowIndex}][]" class="form-control">
                        </td>
                        <td width="100px" class="qty-container-${rowIndex}">
                            <input type="number" name="qty[${rowIndex}][]" value="1" class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeButton" onclick="removeRow(this, ${transactionId});">Remove</button>
                        </td>
                    </tr>`;

        // Append the new row to the table body
        $('tbody').append(row);

        // Re-initialize Select2 for only the new elements in the row
        $(`.select2-frame`, `tr[data-row-index="${rowIndex}"]`).select2();
        $(`.select2-location`, `tr[data-row-index="${rowIndex}"]`).select2();
        $(`.select2-product`, `tr[data-row-index="${rowIndex}"]`).select2();

        // Populate existing transaction data if provided
        if (transaction) {
            populateRowData(rowIndex, transaction);
        }

        // Increment the row index counter
        rowIndex++;
    } catch (error) {
        console.error('Error adding row:', error);
    }
}


    // function initializeSelect2() {
    //     return new Promise((resolve) => {
    //         $('.select2').select2({
    //             multiple: true,
    //             width: '100%',
    //             allowClear: true
    //         }).on('select2:select select2:unselect', function(e) {
    //             const $row = $(this).closest('tr');
    //             const rowIndex = $row.data('row-index');
    //             if($(this).hasClass('location-select')) {
    //                 const originalData = $row.data('originalData');
    //                 updateSizePriceQty(this, rowIndex, originalData);
    //             }
    //         });
    //         resolve();
    //     });
    // }

    async function populateRowData(rowIndex, transaction) {
        const row = $(`tr[data-row-index="${rowIndex}"]`);
        
        // Store original data
        const originalData = {
            sizes1: transaction.size1 ? transaction.size1.split(',') : [],
            sizes2: transaction.size2 ? transaction.size2.split(',') : [],
            prices: transaction.price ? transaction.price.split(',') : [],
            quantities: transaction.qty ? transaction.qty.split(',') : [],
            locationIds: transaction.location_id ? transaction.location_id.split(',') : []
        };
        row.data('originalData', originalData);
        
        // Set frame image
        row.find('select[name="frame_image_id[]"]').val(transaction.frame_image_id);
        
        // Set locations
        const locationSelect = row.find(`select[name="location_id[${rowIndex}][]"]`);
        locationSelect.val(originalData.locationIds).trigger('change');
        
        // Set products
        if (transaction.product_id) {
            const productIds = transaction.product_id.split(',');
            row.find(`select[name="product_id[${rowIndex}][]"]`).val(productIds).trigger('change');
        }
        
        // Set extra product
        row.find('textarea[name="extra_product[]"]').val(transaction.extra_product || '');

        // Force update of size/price/qty fields
        await new Promise(resolve => setTimeout(resolve, 200));
        updateSizePriceQty(locationSelect[0], rowIndex, originalData);
    }

    function updateSizePriceQty(selectElement, rowIndex, originalData = null) {
        const selectedLocations = $(selectElement).val() || [];
        const row = $(selectElement).closest('tr');
        originalData = originalData || row.data('originalData') || {};
        
        const sizeContainer = $(`.size-price-qty-container-${rowIndex}`);
        const priceContainer = $(`.price-container-${rowIndex}`);
        const qtyContainer = $(`.qty-container-${rowIndex}`);

        // Clear containers
        sizeContainer.empty();
        priceContainer.empty();
        qtyContainer.empty();

        selectedLocations.forEach((locationId, index) => {
            const locationName = $(`option[value="${locationId}"]`, selectElement).text();
            const originalIndex = originalData.locationIds ? 
                                originalData.locationIds.indexOf(locationId) : -1;

            const size1Value = originalIndex > -1 ? originalData.sizes1[originalIndex] : '';
            const size2Value = originalIndex > -1 ? originalData.sizes2[originalIndex] : '';
            const priceValue = originalIndex > -1 ? originalData.prices[originalIndex] : '';
            const qtyValue = originalIndex > -1 ? originalData.quantities[originalIndex] : '';

            sizeContainer.append(`
                <div class="location-fields">
                    <small>${locationName}</small>
                    <span class="d-flex" style="width:200px">
                        <input type="number" name="size1[${rowIndex}][]" class="form-control" value="${size1Value}">*
                        <input type="number" name="size2[${rowIndex}][]" class="form-control" value="${size2Value}">
                    </span>
                </div>
            `);

            priceContainer.append(`
                <div class="location-fields" style="width:100px">
                    <small>${locationName}</small>
                    <input type="number" name="price[${rowIndex}][]" class="form-control" value="${priceValue}">
                </div>
            `);

            qtyContainer.append(`
                <div class="location-fields"  style="width:100px">
                    <small>${locationName}</small>
                    <input type="number" name="qty[${rowIndex}][]" class="form-control" value="${qtyValue}">
                </div>
            `);
        });
    }

    function removeRow(button, transactionId) {
        if (!transactionId) {
            $(button).closest('tr').remove();
            return;
        }

        if (!confirm("Are you sure you want to delete this transaction?")) {
            return;
        }

        $.ajax({
            url: "/orders/transaction/delete", // Replace with your actual delete endpoint
            type: "POST",
            data: { transaction_id: transactionId }, // Send as form data
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $(button).closest('tr').remove();
                } else {
                    alert("Failed to delete transaction: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText); // Logs error details
                alert("Error deleting transaction. Please try again.");
            }
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        init();
        <?php  if(!empty($data['orders_id'])) { ?>
            const orderId = <?=$data['orders_id']?>; // Replace with actual order 
            populateRows(orderId);
        <?php } ?>
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

