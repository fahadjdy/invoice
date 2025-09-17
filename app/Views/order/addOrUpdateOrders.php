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


                <div class="col-lg-4">
                    <label for="">GST Type</label>
                    <select name="gst_type" >
                          <option value="Without GST" <?= (isset($data['gst_type']) && $data['gst_type'] == "Without GST") ? 'selected' : '' ?>>Without GST</option>
                        <option value="With GST" <?= (isset($data['gst_type']) && $data['gst_type'] == "With GST") ? 'selected' : '' ?>>With GST</option>                      
                    </select>
                </div>

                <div class="col-lg-4">
                    <label for="">Discount (kasar)</label>
                    <input type="number" name="discount" class="form-control" value="<?= (isset($data['discount'])) ? $data['discount'] : '0' ?>" >
                </div>

                <div style="overflow-x: auto; width: 100%;">
                <table width="100%" class="table">
                    <thead>
                        <tr>
                            <td style="width:100px !important">Sr.No.</td>
                            <td style="width:200px !important">Frame Image</td>
                            <td style="width:250px !important">Location</td>
                            <td style="width:400px !important">Product</td>
                            <!-- <td style="width:100px !important">Extra Product</td> -->
                            <td style="width:200px !important">Size <small>(in inch)</small></td>
                            <td style="width:100px !important">Price</td>
                            <td style="width:100px !important">Qty.</td>
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
                            <select multiple="multiple" name="location_id[${rowIndex}][]" onchange="updateSizePriceQty(this, ${rowIndex})" class="form-control location-select select2-location" >
                                ${locationOptions}
                            </select>
                        </td>
                        <td width="400px">
                            <select multiple="multiple" name="product_id[${rowIndex}][]" class="form-control select2-product" style="width:200px" >
                                ${productOptions}
                            </select>
                        </td>
                        <td width="350px" class="size-price-qty-container-${rowIndex}">
                            <div class="location-fields">
                                <span class="d-flex" style="width:200px">
                                    <input type="number" style="width:100px" name="size1[${rowIndex}][]" class="form-control"> *
                                    <input type="number" style="width:100px" name="size2[${rowIndex}][]" class="form-control">
                                </span>
                            </div>
                        </td>
                        <td width="100px" class="price-container-${rowIndex}">
                            <input type="number" style="width:auto" name="price[${rowIndex}][]" class="form-control">
                        </td>
                        <td width="100px" class="qty-container-${rowIndex}">
                            <input type="number" style="width:auto" name="qty[${rowIndex}][]" value="1" class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeButton" onclick="removeRow(this, ${transactionId});">Remove</button>
                        </td>
                    </tr>`;

        // Append the new row to the table body
        $('tbody').append(row);

        // Re-initialize Select2 for only the new elements in the row
        $(`.select2-frame`, `tr[data-row-index="${rowIndex}"]`).select2();
        
        $(`.select2-location`, `tr[data-row-index="${rowIndex}"]`).select2({allowClear: true});

        $(`.select2-product`, `tr[data-row-index="${rowIndex}"]`).select2({allowClear: true});


        $('.select2-product').on('select2:select', function (e) {
            let element = e.params.data.element;
            let $element = $(element);

            // Move the selected option to the end
            $element.detach();
            $(this).append($element);

            // Refresh Select2
            $(this).trigger("change");
        });


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
// console.log(transaction);
        // Store original data
        const originalData = {
            locationIds: transaction.location_id ? transaction.location_id.split(',') : [],
            productIds: transaction.product_id ? transaction.product_id.split(',') : [],
            sizes1: transaction.size1 ? transaction.size1.split(',') : [],
            sizes2: transaction.size2 ? transaction.size2.split(',') : [],
            prices: transaction.price ? transaction.price.split(',') : [],
            quantities: transaction.qty ? transaction.qty.split(',') : [],
        };

        row.data('originalData', originalData);

        // Set frame image
        row.find('select[name="frame_image_id[]"]')
        .val(transaction.frame_image_id)
        .trigger('change');

        // Set products (multi-select)
        const productSelect = row.find(`select[name="product_id[${rowIndex}][]"]`);
        productSelect.val(originalData.productIds).trigger('change');

          const locationSelect = row.find(`select[name="location_id[${rowIndex}][]"]`);
        locationSelect.val(originalData.locationIds).trigger('change');
        // Set extra product
        // row.find('textarea[name="extra_product[]"]').val(transaction.extra_product || '');

        // Force update of size/price/qty fields
        await new Promise(resolve => setTimeout(resolve, 100));
        console.log(locationSelect[0]);
// if location empty than loop it with product ===================================== 
    const conditionForPriceLoop = $(locationSelect[0]).closest('tr');
    const rawOriginalData = conditionForPriceLoop.data('originalData') || {};
    // console.log();
    const loop = (rawOriginalData.locationIds.length > 0) ? locationSelect[0] : productSelect[0];
// ===================


        updateSizePriceQty(loop, rowIndex);
    }

  function updateSizePriceQty(selectElement, rowIndex) {
    const selectedLocations = $(selectElement).val() || [];
    const row = $(selectElement).closest('tr');
    const originalData = row.data('originalData') || {};

    const sizeContainer = $(`.size-price-qty-container-${rowIndex}`);
    const priceContainer = $(`.price-container-${rowIndex}`);
    const qtyContainer = $(`.qty-container-${rowIndex}`);

    // Reset
    sizeContainer.empty();
    priceContainer.empty();
    qtyContainer.empty();

    selectedLocations.forEach((locationId, index) => {
        // Load old values for edit mode
        const size1Value = (originalData.sizes1 && originalData.sizes1[index]) || '';
        const size2Value = (originalData.sizes2 && originalData.sizes2[index]) || '';
        const priceValue = (originalData.prices && originalData.prices[index]) || '';
        const qtyValue   = (originalData.quantities && originalData.quantities[index]) || 1;

        sizeContainer.append(`
            <div class="location-fields">
                <small>Location ${index+1}</small>
                <span class="d-flex" style="width:200px">
                    <input type="number" name="size1[${rowIndex}][]" class="form-control" value="${size1Value}">
                    <input type="number" name="size2[${rowIndex}][]" class="form-control" value="${size2Value}">
                </span>
            </div>
        `);

        priceContainer.append(`
            <div class="location-fields" style="width:100px">
                <small>Location ${index+1}</small>
                <input type="number" name="price[${rowIndex}][]" class="form-control" value="${priceValue}">
            </div>
        `);

        qtyContainer.append(`
            <div class="location-fields" style="width:100px">
                <small>Location ${index+1}</small>
                <input type="number" name="qty[${rowIndex}][]" class="form-control" value="${qtyValue}">
            </div>
        `);
    });
}


    // Optional: call this whenever the product multi-select changes
    $(document).on('change', 'select[name^="location_id"]', function() {
        const rowIndex = $(this).closest('tr').data('row-index');
        // updateSizePriceQty(this, rowIndex);
    });

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


        // Trigger price calculation when size1 or size2 changes
//         $(document).on('input', 'input[name^="size1"], input[name^="size2"]', function() {
//     const $sizeInput = $(this);
//     const $row = $sizeInput.closest('tr');
//     const rowIndex = $row.data('row-index');

//     // Get the container of this product’s size fields
//     const $sizeFieldContainer = $sizeInput.closest('.product-fields');
//     const productIndex = $sizeFieldContainer.index(); // position in the row

//     // Get the corresponding price input
//     const $priceContainer = $(`.price-container-${rowIndex}`);
//     const $priceInput = $priceContainer.find('input[name^="price"]').eq(productIndex);

//     const size1 = parseFloat($sizeFieldContainer.find('input[name^="size1"]').val()) || 0;
//     const size2 = parseFloat($sizeFieldContainer.find('input[name^="size2"]').val()) || 0;

//     if (size1 > 0 && size2 > 0) {
//         // Calculate area in sqft
//         const sqft = (size1 * size2) / 144;

//         // Get the multi-select for this row
//         const $productSelect = $(`select[name="product_id[${rowIndex}][]"]`);
//         const selectedProductIds = $productSelect.val() || [];

//         // Get product ID corresponding to this product field
//         const productId = selectedProductIds[productIndex];

//         // Fetch price per sqft from the option’s data-price
//         const pricePerSqft = parseFloat($productSelect.find(`option[value="${productId}"]`).data('price')) || 0;

//         // Calculate total price
//         const totalPrice = (sqft * pricePerSqft).toFixed(2);

//         // Update only this product’s price input
//         $priceInput.val(totalPrice);
//     } else {
//         $priceInput.val('');
//     }
// });







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

<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple
    {
        width:300px !important
    }
</style>
<?= $this->endSection('js') ?>

