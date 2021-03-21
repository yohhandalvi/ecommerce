<?php if(!empty($banner_images)) { ?>
    <div id="banner-1" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <?php foreach ($banner_images as $key => $banner_image) { ?>
                <li data-target="#banner-1" data-slide-to="<?php echo $key; ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>"></li>
            <?php } ?>
        </ul>
        <div class="carousel-inner">
            <?php foreach ($banner_images as $key => $banner_image) { ?>
                <div class="carousel-item <?php echo ($key == 0) ? 'active' : ''; ?>">
                    <?php 
                        if($banner_image['product_id'])
                            $link = site_url('product/'.$banner_image['product_id']);
                        else if($banner_image['category_id'])
                            $link = site_url('shop?category_id='.$banner_image['category_id']);
                        else 
                            $link = false;
                    ?>
                    <?php if($link) { ?>
                        <a href="<?php echo $link; ?>">
                    <?php } ?>
                        <img src="<?php echo show_image(base_url('uploads/banners/images/'.$banner_image['image']), ['thumbnail' => '1200_700']); ?>" alt="Banner" width="100%">
                    <?php if($link) { ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#banner-1" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#banner-1" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
<?php } ?>
<div class="site-section site-section-sm site-blocks-1">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                <div class="icon mr-4 align-self-start">
                    <span class="icon-truck"></span>
                </div>
                <div class="text">
                    <h2 class="text-uppercase">Free Shipping</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                <div class="icon mr-4 align-self-start">
                    <span class="icon-refresh2"></span>
                </div>
                <div class="text">
                    <h2 class="text-uppercase">Free Returns</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="icon mr-4 align-self-start">
                    <span class="icon-help"></span>
                </div>
                <div class="text">
                    <h2 class="text-uppercase">Customer Support</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section site-blocks-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                <a class="block-2-item" href="#">
                    <figure class="image">
                        <img src="<?php echo base_url('resources/front/images/women.jpg'); ?>" alt="" class="img-fluid">
                    </figure>
                    <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Women</h3>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                <a class="block-2-item" href="#">
                    <figure class="image">
                        <img src="<?php echo base_url('resources/front/images/children.jpg'); ?>" alt="" class="img-fluid">
                    </figure>
                    <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Children</h3>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                <a class="block-2-item" href="#">
                    <figure class="image">
                        <img src="<?php echo base_url('resources/front/images/men.jpg'); ?>" alt="" class="img-fluid">
                    </figure>
                    <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Men</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="site-section block-3 site-blocks-2 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2>Featured Products</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="nonloop-block-3 owl-carousel">
                    <?php foreach ($featured_products as $key => $featured_product) { ?>
                        <div class="item">
                            <div class="block-4 text-center">
                                <figure class="block-4-image">
                                    <img src="<?php echo show_image(base_url('uploads/products/images/'.$featured_product['image']), ['thumbnail' => '500_500']); ?>" alt="<?php echo $featured_product['name']; ?>" class="img-fluid">
                                </figure>
                                <div class="block-4-text p-4">
                                    <h3><a href="<?php echo site_url('product/'.$featured_product['id']); ?>"><?php echo $featured_product['name']; ?></a></h3>
                                    <p class="mb-0"><?php echo $featured_product['category']; ?></p>
                                    <p class="text-primary font-weight-bold"><?php echo show_price($featured_product['price']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section block-8">
    <div class="container">
        <div class="row justify-content-center  mb-5">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2>Big Sale!</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-7 mb-5">
                <a href="#"><img src="<?php echo base_url('resources/front/images/blog_1.jpg'); ?>" alt="Image placeholder" class="img-fluid rounded"></a>
            </div>
            <div class="col-md-12 col-lg-5 text-center pl-md-5">
                <h2><a href="#">50% less in all items</a></h2>
                <p class="post-meta mb-4">By <a href="#">Carl Smith</a> <span class="block-8-sep">&bullet;</span> September 3, 2018</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam iste dolor accusantium facere corporis ipsum animi deleniti fugiat. Ex, veniam?</p>
                <p><a href="<?php echo site_url('shop'); ?>" class="btn btn-primary btn-sm">Shop Now</a></p>
            </div>
        </div>
    </div>
</div>