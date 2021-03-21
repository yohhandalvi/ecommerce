<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <a href="<?php echo site_url('my-account'); ?>">My Account</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">View Order</strong></div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container order-view">
        <div class="row">
            <div class="col-md-12">
                <ul class="orderinfo">
                    <li>Order Number: <strong>#<?php echo $order['order_id']; ?></strong></li>
                    <li>Date: <strong><?php echo convert_db_time($order['created_on'], "F j, Y"); ?></strong></li>
                    <li>Total: <strong><?php echo show_price($order['total'], $order['currency']); ?></strong></li>
                    <li>Status: <strong><?php echo get_order_status_text($order['status']); ?></strong></li>
                    <li>Payment Method: <strong><?php echo get_order_payment_text($order['payment']); ?></strong></li>
                </ul>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Order Details</h2>
                <div>
                    <ul>
                        <?php foreach ($order_items as $key => $order_item) { ?>
                            <li><?php echo $order_item['name']; ?> × <?php echo $order_item['quantity']; ?> <span class="float-right"><?php echo show_price($order_item['total'], $order['currency']); ?></span></li>
                        <?php } ?>
                    </ul>
                    <p>Subtotal <span class="float-right"><?php echo show_price($order['subtotal'], $order['currency']); ?></span></p>
                    <p>Shipping Fee <span class="float-right"><?php echo ($order['shipping_amount']) ? show_price($order['shipping_amount'], $order['currency']) : 'Free'; ?></span></p>
                    <?php if($order['discount_amount'] > 0) { ?>
                        <p>Discount (<?php echo $order['discount_code']; ?>) <span class="float-right">- <?php echo show_price($order['discount_amount'], $order['currency']); ?></span></p>
                    <?php } ?>
                    <?php if($order['wallet_paid_amount'] > 0) { ?>
                        <p>Wallet <span class="float-right">- <?php echo show_price($order['wallet_paid_amount'], $order['currency']); ?></span></p>
                    <?php } ?>
                    <h4 class="mt-2">Total <span class="float-right"><?php echo show_price($order['total'], $order['currency']); ?></span></h4>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Customer Details</h2>
                <h6>Name: <?php echo $order['customer_full_name']; ?></h6>
                <h6>Phone: <?php echo $order['customer_mobile']; ?></h6>
                <h6>Email: <?php echo $order['customer_email']; ?></h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Billing Address</h2>
                <address>
                    <h5><?php echo $order['customer_full_name']; ?></h5>
                    <?php echo $order['billing_address_line_1'] ?><br>
                    <?php if($order['billing_address_line_2']) { ?>
                        <?php echo $order['billing_address_line_2'] ?><br>
                    <?php } ?>
                    <?php if($order['billing_landmark']) { ?>
                        <?php echo $order['billing_landmark'] ?>, 
                    <?php } ?>
                    <?php echo $order['billing_city'] ?>, <?php echo $order['billing_state'] ?><br>
                    <?php echo $order['billing_country'] ?> - <?php echo $order['billing_pin_code'] ?>
                </address>
            </div>
            <div class="col-md-6">
                <h2>Shipping Address</h2>
                <address>
                    <h5><?php echo $order['customer_full_name']; ?></h5>
                    <?php echo $order['shipping_address_line_1'] ?><br>
                    <?php if($order['shipping_address_line_2']) { ?>
                        <?php echo $order['shipping_address_line_2'] ?><br>
                    <?php } ?>
                    <?php if($order['shipping_landmark']) { ?>
                        <?php echo $order['shipping_landmark'] ?>, 
                    <?php } ?>
                    <?php echo $order['shipping_city'] ?>, <?php echo $order['shipping_state'] ?><br>
                    <?php echo $order['shipping_country'] ?> - <?php echo $order['shipping_pin_code'] ?>
                </address>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Instructions</h2>
                <span><?php echo ($order['instructions']) ? $order['instructions'] : "-- None --"; ?></span>
            </div>
        </div>
    </div>
</div>