<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
        </div>
    </div>
</div>
<?php if($cart['items']) { ?>
    <form class="col-md-12" method="post">
        <div class="site-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="site-blocks-table col-md-12">
                        <?php $this->load->view('front/layout/alert'); ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <?php if(!$check_stock) { ?>
                                        <th>Stock</th>
                                    <?php } ?>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart['items'] as $item) { ?>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="<?php echo show_image(base_url('uploads/products/images/'.$item['image']), ['thumbnail' => '500_500']); ?>" alt="Image" class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 text-black"><?php echo $item['name']; ?></h2>
                                        </td>
                                        <td><?php echo show_price($item['price']); ?></td>
                                        <td>
                                            <div class="input-group mb-3" style="max-width: 120px;margin: auto;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                                </div>
                                                <input type="text" name="items[<?php echo $item['id'] ?>]" class="form-control text-center" value="<?php echo $item['quantity']; ?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo show_price($item['total']); ?></td>
                                        <?php if(!$check_stock) { ?>
                                            <td><?php echo ($item['total_stock'] > $item['quantity']) ? '<i class="icon-check text-success"></i>' : '<span class="text-danger">'.(($item['total_stock'] < 0) ? 0 : $item['total_stock']).'</span>'; ?></td>
                                        <?php } ?>
                                        <td><a href="javascript:remove_product('<?php echo $item['id']; ?>', true);" class="btn btn-primary btn-sm">X</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <button class="btn btn-primary btn-sm btn-block">Update Cart</button>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-outline-primary btn-sm btn-block" href="<?php echo site_url('shop'); ?>">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="text-black h4" for="coupon">Coupon</label>
                                <p>Enter your coupon code if you have one.</p>
                            </div>
                            <div class="col-md-8 mb-3 mb-md-0">
                                <input type="text" class="form-control py-3" name="discount_code" placeholder="Coupon Code">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-sm">Apply Coupon</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pl-5">
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 text-right border-bottom mb-5">
                                        <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <span class="text-black">Subtotal</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black"><?php echo show_price($cart['subtotal']); ?></strong>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <span class="text-black">Shipping</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black"><?php echo ($cart['shipping_amount']) ? show_price($cart['shipping_amount']) : 'Free'; ?></strong>
                                    </div>
                                </div>
                                <?php if($cart['discount_code']) { ?>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="text-black">Discount (<?php echo $cart['discount_code']; ?>)&nbsp;<a href="<?php echo site_url('cart/discount/remove'); ?>">×</a></span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong class="text-black">- <?php echo show_price($cart['discount_amount']); ?></strong>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <span class="text-black">Total</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black"><?php echo show_price($cart['total']); ?></strong>
                                    </div>
                                </div>
                                <?php if(!empty($cart['cashbacks_applied'])) { ?>
                                    <hr>
                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <span class="text-black">Cashback</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong class="text-black"><?php echo show_price($cart['cashback_amount']); ?></strong>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a class="btn btn-primary btn-lg py-3 btn-block" href="<?php echo site_url('checkout') ?>">Proceed To Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } else { ?>
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="site-blocks-table col-md-12">
                    <h3>Oops! Looks like your cart is empty.</h3>
                    <hr>
                    <p class="mb-0">Browse the <a href="<?php echo site_url('shop'); ?>">shop</a> to find a product you would like for yourself / gift for someone!</p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>