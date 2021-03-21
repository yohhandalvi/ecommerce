<?php if($this->input->get('view') == 'list') { ?>
    <div class="col-sm-12 mb-4" data-aos="fade-up">
        <div class="block-4 text-center border">
            <figure class="block-4-image">
                <a href="<?php echo site_url('product/'.$product['id']); ?>"><img src="<?php echo show_image(base_url('uploads/products/images/'.$product['image']), ['thumbnail' => '500_500']); ?>" alt="<?php echo $product['name']; ?>" class="img-fluid"></a>
            </figure>
            <div class="block-4-text p-4">
                <h3><a href="<?php echo site_url('product/'.$product['id']); ?>"><?php echo $product['name']; ?></a></h3>
                <p class="mb-0"><?php echo $product['description']; ?></p>
                <p class="text-primary font-weight-bold"><?php echo show_price(round($product['price'], 2)); ?> <?php echo ($product['old_price'] != round($product['price'], 2)) ? '<strike><small>'.show_price($product['old_price']).'</small></strike>' : ''; ?></p>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
        <div class="block-4 text-center border">
            <figure class="block-4-image">
                <a href="<?php echo site_url('product/'.$product['id']); ?>"><img src="<?php echo show_image(base_url('uploads/products/images/'.$product['image']), ['thumbnail' => '500_500']); ?>" alt="<?php echo $product['name']; ?>" class="img-fluid"></a>
            </figure>
            <div class="block-4-text p-4">
                <h3><a href="<?php echo site_url('product/'.$product['id']); ?>"><?php echo $product['name']; ?></a></h3>
                <p class="mb-0"><?php echo $product['description']; ?></p>
                <p class="text-primary font-weight-bold">
                    <?php if($product['total_stock']) { ?>
                        <?php echo show_price(round($product['price'], 2)); ?> <?php echo ($product['old_price'] != round($product['price'], 2)) ? '<strike><small>'.show_price($product['old_price']).'</small></strike>' : ''; ?>
                        <?php if(!empty($product['cashback'])) { ?>
                            <div class="mt-0 text-success">
                                Offer: <?php echo $product['cashback']['name']; ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        Out of stock!
                    <?php } ?>
                </p>
            </div>
        </div>
    </div>
<?php } ?>