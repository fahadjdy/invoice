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