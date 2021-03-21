<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('front/layout/head'); ?>
</head>
<body>
    <div class="site-wrap">
        <header class="site-navbar" role="banner">
            <div class="site-navbar-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                            <form action="<?php echo site_url('shop'); ?>" class="site-block-top-search">
                                <span class="icon icon-search2"></span>
                                <input type="text" class="form-control border-0" name="search" placeholder="Search">
                            </form>
                        </div>
                        <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                            <div class="site-logo">
                                <a href="<?php echo site_url(); ?>" class="js-logo-clone"><?php echo PROJECT_NAME; ?></a>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                            <div class="site-top-icons">
                                <ul>
                                    <?php if($this->customer['id']) { ?>
                                        <li><a href="<?php echo site_url('my-account'); ?>"><span class="icon icon-person"></span></a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo site_url('account'); ?>"><span class="icon icon-person"></span></a></li>
                                    <?php } ?>
                                    <li class="site-cart">
                                        <a href="<?php echo site_url('cart'); ?>" class="site-cart">
                                            <span class="icon icon-shopping_cart"></span>
                                            <span class="count"><?php echo count($cart['items']); ?></span>
                                        </a>
                                    </li> 
                                    <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                                </ul>
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
            <nav class="site-navigation text-right text-md-center" role="navigation">
                <div class="container">
                    <ul class="site-menu js-clone-nav d-none d-md-block">
                        <li class="<?php echo (isset($tab) && $tab == 'home') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url(); ?>">Home</a>
                        </li>
                        <li class="has-children <?php echo (isset($tab) && $tab == 'shop') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('shop'); ?>">Shop</a>
                            <ul class="dropdown">
                                <?php foreach ($nav_categories as $key => $nav_category) { ?>
                                    <li class="<?php echo !empty($nav_category['children']) ? 'has-children' : ''; ?>">
                                        <a href="<?php echo site_url('shop?category_id='.$nav_category['id']); ?>"><?php echo $nav_category['name']; ?></a>
                                        <?php if(!empty($nav_category['children'])) { ?>
                                            <ul class="dropdown">
                                                <?php foreach ($nav_category['children'] as $key => $child_category) { ?>
                                                    <li><a href="<?php echo site_url('shop?category[]='.$child_category['id']); ?>"><?php echo $child_category['name']; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="<?php echo (isset($tab) && $tab == 'about-us') ? 'active' : ''; ?>"><a href="<?php echo site_url('about-us'); ?>">About</a></li>
                        <li class="<?php echo (isset($tab) && $tab == 'contact-us') ? 'active' : ''; ?>"><a href="<?php echo site_url('contact-us'); ?>">Contact</a></li>
                    </ul>
                </div>
            </nav>
        </header>