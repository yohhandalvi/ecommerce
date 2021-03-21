<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
        <?php $this->load->view('admin/layout/head'); ?>
    </head>
    <body>
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed side-trans-enabled">
            <nav id="sidebar">
                <div class="sidebar-content">
                    <div class="content-header content-header-fullrow px-15">
                        <div class="content-header-section sidebar-mini-visible-b">
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                            </span>
                        </div>
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="<?php echo site_url('admin/dashboard'); ?>">
                                    <i class="si si-fire text-primary"></i>
                                    <span class="font-size-xl text-dual-primary-dark"><?php echo PROJECT_NAME; ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="content-side content-side-full">
                        <ul class="nav-main">
                            <li>
                                <a class="<?php echo ($tab == 'dashboard') ? 'active' : ''; ?>" href="<?php echo site_url('admin/dashboard'); ?>"><i class="si si-cup"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                            </li>
                            <li class="nav-main-heading"><span class="sidebar-mini-visible">ECOM</span><span class="sidebar-mini-hidden">Ecommerce</span></li>
                            <li class="<?php echo ($tab == 'customer_groups' || $tab == 'customers') ? 'open' : ''; ?>">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-user"></i><span class="sidebar-mini-hide">Customers</span></a>
                                <ul>
                                    <li>
                                        <a class="<?php echo ($tab == 'customer_groups') ? 'active' : ''; ?>" href="<?php echo site_url('customer-group/listing'); ?>">Customer Group</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo ($tab == 'customers') ? 'active' : ''; ?>" href="<?php echo site_url('customer/listing'); ?>">All Customers</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="<?php echo ($tab == 'categories' || $tab == 'products' || $tab == 'discounts' || $tab == 'cashbacks' || $tab == 'shipping_rates') ? 'open' : ''; ?>">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-layers"></i><span class="sidebar-mini-hide">Catalog</span></a>
                                <ul>
                                    <li>
                                        <a class="<?php echo ($tab == 'categories') ? 'active' : ''; ?>" href="<?php echo site_url('category/listing'); ?>">Categories</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo ($tab == 'products') ? 'active' : ''; ?>" href="<?php echo site_url('product/listing'); ?>">Products</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo ($tab == 'discounts') ? 'active' : ''; ?>" href="<?php echo site_url('discount/listing'); ?>">Discounts</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo ($tab == 'cashbacks') ? 'active' : ''; ?>" href="<?php echo site_url('cashback/listing'); ?>">Cashbacks</a>
                                    </li>
                                    <li>
                                        <a class="<?php echo ($tab == 'shipping_rates') ? 'active' : ''; ?>" href="<?php echo site_url('shipping-rate/listing'); ?>">Shipping Rates</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="<?php echo ($tab == 'orders') ? 'active' : ''; ?>" href="<?php echo site_url('admin/order/listing'); ?>"><i class="si si-basket-loaded"></i><span class="sidebar-mini-hide">Orders</span></a>
                                <a class="<?php echo ($tab == 'wishlist') ? 'active' : ''; ?>" href="<?php echo site_url('admin/wishlist'); ?>"><i class="si si-list"></i><span class="sidebar-mini-hide">Wishlist</span></a>
                            </li>
                            <li class="<?php echo ($tab == 'currencies') ? 'open' : ''; ?>">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">Settings</span></a>
                                <ul>
                                    <li>
                                        <a class="<?php echo ($tab == 'currencies') ? 'active' : ''; ?>" href="<?php echo site_url('currency/listing'); ?>">Currencies</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-main-heading"><span class="sidebar-mini-visible">CONT</span><span class="sidebar-mini-hidden">Content</span></li>
                            <li>
                                <a class="<?php echo ($tab == 'banners') ? 'active' : ''; ?>" href="<?php echo site_url('banner/listing'); ?>"><i class="si si-screen-desktop"></i><span class="sidebar-mini-hide">Banners</span></a>
                            </li>
                            <li>
                                <a class="<?php echo ($tab == 'reviews') ? 'active' : ''; ?>" href="<?php echo site_url('product/reviews'); ?>"><i class="si si-book-open"></i><span class="sidebar-mini-hide">Reviews</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <header id="page-header">
                <div class="content-header">
                    <div class="content-header-section">
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="content-header-section">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">Admin</span>
                                <i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                                <a class="dropdown-item mb-0" href="<?php echo site_url('admin/logout') ?>">
                                    <i class="si si-logout mr-5"></i> Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="page-header-search" class="overlay-header">
                    <div class="content-header content-header-fullrow">
                        <form action="<?php echo site_url('product/listing'); ?>">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <input type="text" name="search" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
            </header>
            <main id="main-container">
                <div class="content">