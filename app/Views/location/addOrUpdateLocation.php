<?= $this->extend('layouts/base') ?>

<?=$this->section('content')?>

<div class="container-fluid">
    <div class="row card p-3">



        <form id="LocationForm" method="post">
            <div class="row">
               

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Location Name</label>
                    <?=(isset($edit) ? '<input type="hidden" name="location_id" value="' . $edit . '">' : '')?>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="text" id="name" name="name" class="form-control p-0 px-2"
                            placeholder="name" required="" value="<?=(isset($data)) ? $data['name'] : ''?>">
                    </div>
                </div>

                <!-- <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Location code</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="text" id="code" name="code" class="form-control p-0 px-2"
                            placeholder="Location code" required="" value="<?=(isset($data)) ? $data['code'] : ''?>">
                    </div>
                </div> -->

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
            $('#LocationForm').on('submit', function (e) {
                e.preventDefault();

            });

            $('#LocationForm').validate({
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter Location name.",
                    }
                },
                submitHandler: function (form) {
                    submitForm();
                }
            });

        });

    function submitForm() {
        var form = $('#LocationForm')[0];
        var fd = new FormData(form);
        var url = '<?=base_url('saveLocation')?>';
        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function (response) {

                if(response.status){
                    location.href = location.origin + '/location';
                    // successToast(response.message);
                }else{
                    errorToast(response.message);
                }

            }
        });
    }

</script>


<?=$this->endSection('js')?>