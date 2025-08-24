<?php

$menuList = [
    ['name' => 'Dashboards', 'icon' => "<i class='bx bxs-dashboard'></i>", 'url' => base_url('dashboard')],
    ['name' => 'Party', 'icon' => "<i class='bx bxs-user'></i>", 'url' => base_url('party')],
    ['name' => 'Referral', 'icon' => "<i class='bx bxs-user'></i>", 'url' => base_url('referral')],
    ['name' => 'Order', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('order')],
    ['name' => 'Product', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('product')],
    ['name' => 'Location', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('location')],
    ['name' => 'Frame Image', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('frame-image')],
    // ['name' => 'Invoice Setting', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('config/invoice')],
    // ['name' => 'Price Setting', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('config/price')],
    // ['name' => 'Profile', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('profile')],
];

?>

<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php
                        $menu ='';
                         foreach ($menuList as $menuItem) {
                                $menu .= '<li><a href="'.$menuItem['url'].'"';
                                $menu .= 'class="waves-effect"' ;
                                $menu .= '">' .$menuItem['icon']. $menuItem['name'].'</a>';
                                $menu .= '</li>';                            
                        }

                        echo $menu;
                ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>


