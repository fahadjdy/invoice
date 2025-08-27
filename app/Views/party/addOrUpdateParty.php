<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row card p-3">



        <form id="PartyForm" method="post">
            <div class="row">

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Party Name</label>
                    <?= (isset($edit) ? '<input type="hidden" name="party_id" value="' . $edit . '">' : '') ?>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input maxlength="50" autocomplete="off" type="text" id="name" name="name" class="form-control p-0 px-2"
                            placeholder="name" required="" value="<?= (isset($data)) ? $data['name'] : '' ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Mobile Number</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        </div>
                        <input type="text" maxlength="10" id="contact" name="contact" class="form-control p-0 px-2"
                            placeholder="contact" required="" value="<?= (isset($data)) ? $data['contact'] : '' ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Address</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-home"></i></span>
                        </div>
                        <input type="text" id="address" name="address" class="form-control p-0 px-2" placeholder="address"
                            required="" value="<?= (isset($data)) ? $data['address'] : '' ?>">
                    </div>
                </div>


                <div class="col-lg-4">
                    <label for="" class="p-0 m-0">Email</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-home"></i></span>
                        </div>
                        <input type="text" id="email" autocomplete="off" name="email" class="form-control p-0 px-2" placeholder="email"
                            value="<?= (isset($data)) ? $data['email'] : '' ?>">
                    </div>
                </div>

                <label for="" class="p-0 m-0"> Status</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                    </div>
                    <select class="form-control p-0 px-2 form-select" name="status" id="status1">
                        <option value="1" <?= (isset($data['status']) && $data['status'] == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (isset($data['status']) && $data['status'] == 0) ? 'selected' : '' ?>>Deactive</option>
                    </select>
                </div>



                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-primary px-4" value="Submit" id="SubmitBtn">
                </div>
            </div>
        </form>

    </div>
</div>


<?= $this->endSection('content') ?>



<?= $this->section('js') ?>

<script>
    $(document).ready(function() {
        $('#PartyForm').on('submit', function(e) {
            e.preventDefault();

        });

        $('#PartyForm').validate({
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter party name.",
                }
            },
            submitHandler: function(form) {
                submitForm();
            }
        });

    });

    function submitForm() {
        var form = $('#PartyForm')[0];
        var fd = new FormData(form);
        var url = '<?= base_url('saveParty') ?>';
        $.ajax({
            type: "POST",
            url: url,
            data: fd,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.status) {
                    location.href = location.origin + '/party';
                    // successToast(response.message);
                } else {
                    errorToast(response.message);
                }

            }
        });
    }
</script>


<?= $this->endSection('js') ?>