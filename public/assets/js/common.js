// location.origin = "http://localhost/fine-alluminium.fahad-jadiya.com/";
function successToast(msg){
    var success = `<div class="toast-container  position-fixed top-0 end-0 p-2 p-lg-3">
   <div class="toast fade show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header ">
            <i class="mdi mdi-check-all me-2"></i>
            <strong class="me-auto ">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-white">
        ${msg}
        </div>
    </div>
</div>`;
$('body').append(success);

setTimeout(function(){
    $('.toast-container').hide();
},5000)
}



function errorToast(msg){
    var danger = `<div class="toast-container  position-fixed top-0 end-0 p-2 p-lg-3">
   <div class="toast fade show bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header ">
            <i class="mdi mdi-check-all me-2"></i>
            <strong class="me-auto ">Fail</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-white">
            ${msg}
        </div>
    </div>
</div>`;
$('body').append(danger);

setTimeout(function(){
    $('.toast-container').hide();
},5000)
}



function fillDropDown(id, dataUrl) {

    $.ajax({
        type: "POST",
        url: dataUrl,
        dataType: "JSON",
        async:false,
        success: function (response) {
            var html='';
           $.each(response,function(k,v){              
                 html += `<option value="` + v['id']+ `">` + v['data']  + `</option>`
           });                
           
            $(id).append(html);
        }
    });
}

function getPartyNameList(){
    $.ajax({
        type: "GET",
        url: location.origin + "/orders/getPartyNameList",
        dataType: "json",
        async: false,
        success: function (response) {
            if(response.status){
                var option = ``;
                $.each(response.data,function(index,value){
                    option += `<option value="${value.party_id}">${value.party_name}</option>`;
                });
                $('#partyList').html(option);
            }
        }
    });
}


function getInvoiceFormateList(){
    $.ajax({
        type: "GET",
        url: location.origin + "/orders/getInvoiceFormateList",
        dataType: "json",
        success: function (response) {
            if(response.status){
                var option = ``;
                $.each(response.data,function(index,value){
                    option += `<option value="${value.invoice_id}">${value.invoice_name}</option>`;
                });
                $('#invoiceList').html(option);
                $(document).trigger('setSelectedOption');
            }
        }
    });
}

function fetchProductOptions() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: `${location.origin}/orders/getProductList`,
            dataType: "json",
            success: function (response) {
                if (response && response.status && Array.isArray(response.data)) {
                    let options = response.data.map(product => 
                        `<option value="${product.product_id}" data-price="${product.price}">${product.product_name}</option>`
                    ).join('');
                    resolve(options);
                } else {
                    reject("Failed to fetch product data: Invalid response format.");
                }
            },
            error: function (xhr, status, error) {
                // Optional: log details of the error
                console.error("AJAX error:", status, error);
                reject("Error fetching product data: " + error);
            }
        });
    });
}



function fetchLocationOptions() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: location.origin + "/orders/getLocationList",
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    let options = '';
                    $.each(response.data, function (index, value) {
                        options += `<option value="${value.location_id}">${value.location_name}</option>`;
                    });
                    resolve(options);
                } else {
                    reject("Failed to fetch location data.");
                }
            },
            error: function () {
                reject("Error fetching location data.");
            }
        });
    });
}

function fetchFrameImageOptions() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "post",
            url: location.origin + "/orders/getFrameImageList",
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    let options = '';
                    $.each(response.data, function (index, value) {
                        options += `<option value="${value.frame_image_id}">${value.frame_image_name}</option>`;
                    });
                    resolve(options);
                } else {
                    reject("Failed to fetch Frame Image data.");
                }
            },
            error: function () {
                reject("Error fetching Frame Image data.");
            }
        });
    });
}


// Fetch existing order details
function fetchOrderDetails(orderId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: location.origin + `/orders/getOrderDetails/${orderId}`,
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    resolve(response.data);
                } else {
                    reject("Failed to fetch order details.");
                }
            },
            error: function () {
                reject("Error fetching order details.");
            }
        });
    });
}



// Fetch and populate existing rows
// async function populateRows(orderId) {
    async function populateRows(orderId) {
        try {
            // Fetch order details
            const orderDetails = await fetchOrderDetails(orderId); // Wait for the Promise to resolve
    
            // Fetch options for dropdowns
            const [locationOptions, productOptions, frameImageOptions] = await Promise.all([
                fetchLocationOptions(),
                fetchProductOptions(),
                fetchFrameImageOptions()
            ]);
    
            // Clear existing rows
            $('tbody').empty();
    
            let rowIndex = 1; // Initialize row index for numbering
    
            // Populate rows
            orderDetails.transactions.forEach(transaction => {
                const row = `<tr data-transaction-id="${transaction.transaction_id}">
                                <td>${rowIndex++}</td>
                                <td >
                                    <select name="frame_image_id[]" class="form-control">
                                        <option value="0">Select Frame Image</option>
                                        ${populateOptions(frameImageOptions, transaction.frame_image_id)}
                                    </select>
                                </td>
                                <td >
                                    <input type="hidden" name="transaction_id[]" value="${transaction.transaction_id}">
                                    <select name="location_id[]" class="form-control" id="locationList-${transaction.transaction_id}">
                                        <option value="">Select Location</option>
                                        ${populateOptions(locationOptions, transaction.location_id)}
                                    </select>
                                </td>
                                <td >
                                    <select multiple="multiple" name="product_id[${transaction.transaction_id}][]" class="form-control">
                                        ${populateOptions(productOptions, transaction.product_id)}
                                    </select>
                                </td>
                                <td>
                                    <textarea name="extra_product[]" cols="30" rows="3" class="form-control">${transaction.extra_product}</textarea>
                                </td>
                                <td >
                                    <span class="d-flex" style="width:200px">
                                        <input type="number" style="width:auto" name="size1[]" style="width: auto; min-width: 70px;" class="form-control" value="${transaction.size1}">
                                        *
                                        <input type="number" style="width:auto" name="size2[]" style="width: auto; min-width: 70px;" class="form-control" value="${transaction.size2}">
                                    </span>
                                </td>
                                <td >
                                    <input type="number" name="price[]" style="width: 100%; min-width: 60px;" class="form-control" value="${transaction.price}">
                                </td>
                                <td >
                                    <input type="number" name="qty[]" class="form-control" style="width: 100%; min-width: 60px;" value="${transaction.qty}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger removeButton" onClick="removeRow(this);">Remove</button>
                                </td>
                            </tr>`;
    
                $('tbody').append(row);
            });
    
            // Initialize Select2 for dropdowns
            $('select').select2();
        } catch (error) {
            console.error("Error in populateRows:", error);
        }
    }
    
    // Populate options and set selected value
    function populateOptions(options, selectedValues) {
        // Convert selectedValues to an array if it's a comma-separated string
        const selectedValuesArray = Array.isArray(selectedValues) ? selectedValues : selectedValues.split(',').map(value => value.trim());
    
        // Escape HTML function to prevent injection attacks
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    
        // Update options with selected attributes
        return options.replace(/<option value="([^"]*)">([^<]*)<\/option>/g, (match, value, text) => {
            const isSelected = selectedValuesArray.includes(value) ? ' selected' : '';
            return `<option value="${value}"${isSelected}>${escapeHtml(text)}</option>`;
        });
    }
    