<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login to Admin Dashboard <?=$profile['name']?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Pichforest" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.ico')?>">

    <!-- Bootstrap Css -->
    <link href="<?=base_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?=base_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="text-center mb-5">
                        <a href="<?=base_url()?>" class="auth-logo">
                           
                            <img src="<?=base_url('assets/images/profile/'.$profile['logo'])?>" alt="<?=$profile['name']?>" height="100px" class="auth-logo-dark">
                            <img src="<?=base_url('assets/images/profile/'.$profile['logo'])?>" alt="<?=$profile['name']?>" height="100px"
                                class="auth-logo-light">
                        </a>
                        <p class="font-size-15 text-muted mt-3">Admin Login</p>
                    </div>
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">

                                    <div>
                                        <h5>Welcome Back !</h5>
                                        <p class="text-muted">Sign in to continue to Admin Dashboard.</p>
                                    </div>

                                    <div class="mt-4 pt-3">
                                        <form action="<?=base_url('authLogin')?>" method="post" id="loginForm">

                                            <div class="mb-3">
                                                <label for="username" class="fw-semibold">Username</label>
                                                <input type="text" class="form-control" name="username" id="username"
                                                    placeholder="Enter username">
                                            </div>

                                            <div class="mb-3 mb-4">
                                                <label for="userpassword" class="fw-semibold">Password</label>
                                                <input type="password" class="form-control" name="password" id="password"
                                                    placeholder="Enter password">
                                            </div>

                                            <div class="row align-items-center">                                               
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                                            type="submit">Login Now</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4 bg-auth h-100 d-none d-lg-block">
                                    <div class="bg-overlay"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end account page -->


    <!-- JAVASCRIPT -->
    <script src="<?=base_url('assets/libs/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/metismenu/metisMenu.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/simplebar/simplebar.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/node-waves/waves.min.js')?>"></script>

    <script src="<?=base_url('assets/js/app.js')?>"></script>
    <script src="<?= base_url('assets/js/common.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.validate.js') ?>"></script>

    <script>
         // ------------------------- Validation -------------------
                         
         $("#loginForm").validate({
		rules: {
			username: { required: true },
			password: { required: true },
		},
		message: {
			username: { required: "username required" },
			password: { required: "password required" },
		},submitHandler:function(){
            $.ajax({
                type: "post",
                url: "authLogin",
                data: $('#loginForm').serialize(),
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        location.href= response.redirect_url;
                    }else{
                        errorToast(response.error);
                    }
                }
            });
        }
	});

    </script>

</body>

</html>