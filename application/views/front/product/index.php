<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <a href="<?php echo site_url('shop'); ?>">Shop</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo $product['name']; ?></strong></div>
        </div>
    </div>
</div>
<div class="site-section product">
    <div class="container">
        <?php $this->load->view('front/layout/alert'); ?>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo show_image(base_url('uploads/products/images/'.$product['image']), ['thumbnail' => '500_500']); ?>" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2 class="text-black"><?php echo $product['name']; ?></h2>
                <p class="mb-4"><?php echo $product['description']; ?></p>
                <p><strong class="text-primary h4"><?php echo show_price(round($product['price'], 2)); ?> <?php echo ($product['old_price'] != round($product['price'], 2)) ? '<strike><small>'.show_price($product['old_price']).'</small></strike>' : ''; ?></strong></p>
                <div class="mb-5">
                    <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                    </div>
                </div>
                <p>
                    <?php if($product['total_stock']) { ?>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm mr-4 btn-add-to-cart" data-quantity="1" data-id="<?php echo $product['id']; ?>">Add To Cart</a>
                    <?php } else { ?>
                        <span class="text-danger mr-4">Out of stock!</span>
                    <?php } ?>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wishlist" data-id="<?php echo $product['id']; ?>" data-action="change">Add To Wishlist</a>
                    <?php if(!empty($product['cashback'])) { ?>
                        <div class="mt-3 text-success">
                            Offer: <?php echo $product['cashback']['name']; ?>
                        </div>
                    <?php } ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 site-section-heading text-center pt-4">
                <h2>Specification</h2>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo $product['specification'] ?>
            </div>
        </div>
    </div>
</div>
<div class="bg-light py-3" id="review">
    <div class="container">
        <div class="row">
            <div class="col-md-12 site-section-heading text-center pt-4">
                <h2>Reviews</h2>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(!empty($product_reviews)) { ?>
                    <?php foreach($product_reviews as $product_review) { ?>
                        <div class="p-4 border mb-3">
                            <span class="d-block text-primary h6 text-uppercase"><?php echo ($product_review['anonymous']) ? 'Anonymous' : $product_review['customer']; ?><span class="text-muted float-right"><?php echo convert_db_time($product_review['created_on'], "F j, Y"); ?></span></span>
                            <div class="rating-container mb-4">
                                <div class="rating jq-ry-container" data-rateyo-rated-fill="gold" data-rateyo-star-width="20px" data-rateyo-full-star="true" data-rateyo-rating="<?php echo (int) $product_review['rating']; ?>" data-rateyo-spacing="5px"></div>
                            </div>
                            <hr>
                            <p class="mb-0"><?php echo $product_review['review']; ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <span class="text-danger">This product has no reviews yet, be the first to write a review.</span>
                    <?php if(!$this->customer['id']) { ?>
                        - <a href="<?php echo site_url('account?redirect_to='.urlencode(site_url('product/'.$product['id']))); ?>">Login</a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php if($this->customer['id']) { ?>
            <form method="post" action="<?php echo site_url('product/'.$product['id'].'#review'); ?>">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <label>Your rating</label>
                        <div class="rating-container mb-4">
                            <input type="hidden" name="rating" value="<?php echo ($this->input->post('rating')) ? (int) $this->input->post('rating') : 0; ?>">
                            <div class="rating jq-ry-container" data-rateyo-rated-fill="gold" data-rateyo-star-width="20px" data-rateyo-full-star="true" data-rateyo-rating="<?php echo ($this->input->post('rating')) ? (int) $this->input->post('rating') : 0; ?>" data-rateyo-spacing="5px"></div>
                        </div>
                        <?php echo form_error('rating'); ?>
                        <div class="form-group">
                            <label>Please write a review...</label>
                            <textarea name="review" class="form-control"><?php echo $this->input->post('review'); ?></textarea>
                            <?php echo form_error('review'); ?>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" value="1" name="anonymous" <?php echo ($this->input->post('anonymous')) ? 'checked': ''; ?>>&nbsp;&nbsp;Post as anonymous?
                            </label>
                            <?php echo form_error('anonymous'); ?>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</div>
<script>
    $(function () {
        $(".rating").rateYo().on("rateyo.set", function (e, data) {
            $("input[name=rating]").val(data.rating);
        });
    });
</script>
<div class="site-section block-3 site-blocks-2 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2>Related Products</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="nonloop-block-3 owl-carousel">
                    <?php if(!empty($related_products)) { ?>
                        <?php foreach ($related_products as $key => $related_product) { ?>
                            <?php $this->load->view('front/product/_related_product', ['product' => $related_product]); ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>