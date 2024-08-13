<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->renderSection('title') ?>
    </title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('assets/css/app.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark">

  

    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div> -->

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include('components/header') ?>

        <!-- ========== Left Sidebar Start ========== -->
        <?= $this->include('components/sidebar') ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <?= $this->renderSection('content') ?>
                    </div> <!-- end row-->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer position-fixed">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Fahadjdy.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Fahad Jadiya
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!-- JAVASCRIPT -->
    <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/metismenu/metisMenu.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/simplebar/simplebar.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/node-waves/waves.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/common.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.validate.js') ?>"></script>


    <!-- Sweet Alerts css/js -->
    <link href="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />
    <script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/sweet-alerts.init.js') ?>"></script>

    <!-- Datable  -->
    <link rel="stylesheet" href="<?= base_url('assets/libs/datatable/jquery.dataTables.min.css') ?>">
    <script src="<?= base_url('assets/libs/datatable/jquery.dataTables.min.js')?>"></script>
    <script src="<?= base_url('assets/libs/datatable/dataTables.responsive.min.js')?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/libs/datatable/responsive.dataTables.min.css') ?>">
    
    <?= $this->renderSection('js') ?>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
   
</body>

</html>