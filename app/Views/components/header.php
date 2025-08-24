<header id="page-topbar">
    <div class="navbar-header ">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box d-flex justify-content-start align-items-center ">
                <h4 class="text-white">cPanel</h4>
                <!-- <img src="assets/images/logo-light.png" alt="logo-light" height="23">                       -->
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 vertinav-toggle header-item waves-effect"
                id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <button type="button"
                class="btn btn-sm px-3 font-size-16 horinav-toggle header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <div class=" d-flex justify-content-center align-items-center">
                <h4 class="mb-sm-0 font-size-16 fw-bold">
                    <?= $pageTitle ?>
                </h4>
            </div>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user " src="<?= base_url('assets/images/alt-img.png') ?>"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">
                        <?= session()->get('username') ?>
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <h6 class="dropdown-header">Welcome
                        <?= session()->get('username') ?>
                    </h6>
                    <a class="dropdown-item" href="<?= base_url('profile') ?>"><i
                            class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span
                            class="align-middle" key="t-profile">Profile</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('logout') ?>"><i
                            class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span
                            class="align-middle" key="t-logout">Logout</span></a>
                </div>
            </div>


        </div>
    </div>
</header>