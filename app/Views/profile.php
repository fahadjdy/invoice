<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
 <!-- Row -->

 <?php echo form_open_multipart('updateProfile');?>
                <div class="row">
                    <div class="col-sm-4 col-12 p-1 text-center">
                        <img src="<?php echo base_url('assets/images/profile/').$data['logo']; ?>" width="200px" alt="logo" srcset="">
                        <input type="hidden" name="old_logo" value="<?php echo $data['logo']; ?>">
                        <div class="form-group">
                            <label for="b_img" style="opacity: 1 !important;">Select Logo</label>
                            <div class="input-group ">
                                <div class="custom-file " style="box-shadow: none !important;filter: none !important;">
                                    <input type="file" accept="image/x-png,image/jpg,image/jpeg" class="custom-file-input" style="box-shadow: none !important;" name="logo" id="inputGroupFile04">
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-12">
                        <div class="row">
                            <div class="col-sm-6 col-12 p-1">
                                <label for="">Compony Name</label>
                                <input type="text" value="<?php echo $data['name']; ?>" name="name" class="form-control" placeholder="Compony Name">
                            </div>
                            <div class="col-sm-6 col-12 p-1">
                                <label for="">Mobile Number</label>
                                <input type="text" value="<?php echo $data['contact']; ?>" name="contact" class="form-control" placeholder="Mobile Number">
                            </div>
                            <div class="col-sm-6 col-12 p-1">
                                <label for="">Email</label>
                                <input type="text" value="<?php echo $data['email']; ?>" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-12 p-1">
                        <label for="">Adress</label>
                        <textarea name="address" class="form-control" id="" cols="30" rows="5"><?php echo $data['address'] ?></textarea>
                    </div>
                    <div class="col-12 p-1 ">
                        <label for=" ">Terms & Condition</label>
                        <textarea name="terms_condition" class="form-control " id=" " cols="30 " rows="5 "><?=@$data['terms_condition'] ?></textarea>
                    </div>
                   
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <input type="submit" value="Save" class="btn btn-primary" name="Save">
                    </div>
                </div>
                <?php echo form_close();?>
                <!-- End Row -->
<?= $this->endSection() ?>