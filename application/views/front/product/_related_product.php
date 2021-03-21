<div class="item">
    <div class="block-4 text-center">
        <figure class="block-4-image">
            <img src="<?php echo show_image(base_url('uploads/products/images/'.$product['image']), ['thumbnail' => '500_500']); ?>" alt="Image placeholder" class="img-fluid">
        </figure>
        <div class="block-4-text p-4">
            <h3><a href="<?php echo site_url('product/'.$product['id']); ?>"><?php echo $product['name']; ?></a></h3>
            <p class="mb-0"><?php echo $product['description']; ?></p>
            <p class="text-primary font-weight-bold">
                <?php if($product['total_stock']) { ?>
                    <?php echo show_price(round($product['price'], 2)); ?> <?php echo ($product['old_price'] != round($product['price'], 2)) ? '<strike><small>'.show_price($product['old_price']).'</small></strike>' : ''; ?>
                    <?php if($product['cashback_id']) { ?>
                        <div class="mt-0 text-success">
                            Offer: <?php echo $product['cashback_value']; ?><?php echo ($product['cashback_type'] == 'amount') ? ' INR' : '%'; ?> cashback!
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    Out of stock!
                <?php } ?>
            </p>
        </div>
    </div>
</div>