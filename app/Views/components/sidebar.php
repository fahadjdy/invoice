<?php

$menuList = [
    ['name' => 'Dashboards', 'icon' => "<i class='bx bxs-dashboard'></i>", 'url' => base_url('dashboard')],
    ['name' => 'Party', 'icon' => "<i class='bx bxs-user'></i>", 'url' => base_url('party')],
    ['name' => 'Product', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('product')],
    ['name' => 'Order', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('order')],
    ['name' => 'Invoice Formate', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('invoice')],
    ['name' => 'Profile', 'icon' => "<i class='bx bx-images'></i>", 'url' => base_url('Profile')],
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

                        echo $menu
                ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>


