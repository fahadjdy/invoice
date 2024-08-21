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
            }
        }
    });
}

function fetchProductOptions() {
    // This example assumes you have a method to fetch product options
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: location.origin + "/orders/getProductList",
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    let options = '';
                    $.each(response.data, function (index, value) {
                        options += `<option value="${value.product_id}">${value.product_name}</option>`;
                    });
                    resolve(options);
                } else {
                    reject("Failed to fetch product data.");
                }
            },
            error: function () {
                reject("Error fetching product data.");
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
async function populateRows(orderId) {
    try {
        // Fetch order details
        const orderDetails = await fetchOrderDetails(orderId);

        // Fetch options for dropdowns
        const [locationOptions, productOptions] = await Promise.all([
            fetchLocationOptions(),
            fetchProductOptions()
        ]);

        // Clear existing rows
        $('tbody').empty();

        // Populate rows
        orderDetails.transactions.forEach(transaction => {
            const row = `<tr data-transaction-id="${transaction.transaction_id}">
                            <td>${rowIndex}</td>
                            <td><select name="location_id[]" class="form-control" id="locationList-${transaction.transaction_id}">${populateOptions(locationOptions, transaction.location_id)}</select></td>
                            <td><select name="product_id[]" class="form-control">${populateOptions(productOptions, transaction.product_id)}</select></td>
                            <td><textarea name="extra_product[]" cols="30" rows="3" class="form-control">${transaction.extra_product}</textarea></td>
                            <td width="15%"><span class="d-flex"><input type="number" name="size1[]" class="form-control" value="${transaction.size1}">*<input type="number" name="size2[]" class="form-control" value="${transaction.size2}"></span></td>
                            <td width="10%"><input type="number" name="price[]" class="form-control" value="${transaction.price}"></td>
                            <td width="5%"><input type="number" name="qty[]" class="form-control" value="${transaction.qty}"></td>
                            <td><button type="button" class="btn btn-danger removeButton" onClick="removeRow(this);">Remove</button></td>
                        </tr>`;

            $('tbody').append(row);
        });

    } catch (error) {
        console.error(error);
    }
}

// Populate options and set selected value
function populateOptions(options, selectedValue) {
    return options.replace(/<option value="([^"]*)">([^<]*)<\/option>/g, (match, value, text) => {
        const isSelected = value == selectedValue ? ' selected' : '';
        return `<option value="${value}"${isSelected}>${text}</option>`;
    });
}