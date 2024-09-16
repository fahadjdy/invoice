<?= $this->extend('layouts/base') ?>

<?=$this->section('content')?>

<div class="container-fluid">
    <div class="row card p-3">



        <form id="PriceForm" method="post">
            <div class="row">
               

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">From Sq.Ft.</label>
                    <?=(isset($edit) ? '<input type="hidden" name="price_id" value="' . $edit . '">' : '')?>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="number" id="from_sqft" name="from_sqft" class="form-control p-0 px-2"
                            placeholder="Example : 1 " required="" value="<?=(isset($data)) ? $data['from_sqft'] : ''?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">To Sq.Ft.</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="number" id="to_sqft" name="to_sqft" class="form-control p-0 px-2"
                            placeholder="Example : 9" required="" value="<?=(isset($data)) ? $data['to_sqft'] : ''?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Price</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="number" id="price" name="price" class="form-control p-0 px-2"
                            placeholder="Example : 450" required="" value="<?=(isset($data)) ? $data['price'] : ''?>">
                    </div>
                </div>

                <label for="" class="p-0 m-0"> Status</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                    </div>
                    <select class="form-control p-0 px-2 form-select" name="status" id="status1">
                        <option value="1" <?=(isset($data['status']) && $data['status'] == 1) ? 'selected':''?>>Active</option>
                        <option value="0" <?=(isset($data['status']) && $data['status'] == 0) ? 'selected':''?>>Deactive</option>
                    </select>
                </div>

               

                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-primary px-4" value="Submit" id="SubmitBtn">
                </div>
            </div>
        </form>

    </div>
</div>


<?=$this->endSection('content')?>



<?=$this->section('js')?>

<script>
   
        $(document).ready(function () {
            $('#PriceForm').on('submit', function (e) {
                e.preventDefault();

            });

            $('#PriceForm').validate({
                rules: {
                    to_sqft: {
                        required: true
                    },
                    from_sqft: {
                        required: true
                    }
                },
                messages: {
                    to_sqft: {
                        required: "Please enter to sq.ft. ",
                    },
                    from_sqft: {
                        required: "Please enter from sq.ft. ",
                    }
                },
                submitHandler: function (form) {
                    submitForm();
                }
            });

        });

    function submitForm() {
        var form = $('#PriceForm')[0];
        var fd = new FormData(form);
        var url = '<?=base_url('config/price/savePrice')?>';
        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function (response) {

                if(response.status){
                    location.href = location.origin + '/config/price';
                    // successToast(response.message);
                }else{
                    errorToast(response.message);
                }

            }
        });
    }

</script>


<?=$this->endSection('js')?>