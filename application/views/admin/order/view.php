<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('admin/orders'); ?>">Orders</a>
            <span class="breadcrumb-item active">View</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">
    <a class="btn btn-sm btn-secondary float-right" href="<?php echo site_url('order/invoice/print/'.$order['id']); ?>" target="_blank">
        <i class="fa fa-print mr-5"></i>Print
    </a>
    <a class="btn btn-sm btn-secondary float-right mr-5" href="<?php echo site_url('order/invoice/download/'.$order['id']); ?>" target="_blank">
        <i class="fa fa-download mr-5"></i>Download
    </a>
    Progress
</h2>
<div class="row gutters-tiny">
    <div class="col-md-6 col-xl-2">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fa fa-3x <?php check_status('cancelled', $order['status']); ?>"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase <?php check_status('cancelled', $order['status'], false); ?>">X. Cancelled</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-2">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fa fa-3x <?php check_status('pending', $order['status']); ?>"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase <?php check_status('pending', $order['status'], false); ?>">1. Pending</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-2">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fa fa-3x <?php check_status('placed', $order['status']); ?>"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase <?php check_status('placed', $order['status'], false); ?>">2. Placed</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-2">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fa fa-3x <?php check_status('confirmed', $order['status']); ?>"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase <?php check_status('confirmed', $order['status'], false); ?>">3. Confirmed</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-2">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fa fa-3x <?php check_status('shipped', $order['status']); ?>"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase <?php check_status('shipped', $order['status'], false); ?>">4. Shipped</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-2">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="fa fa-3x <?php check_status('delivered', $order['status']); ?>"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase <?php check_status('delivered', $order['status'], false); ?>">5. Delivered</div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2 class="content-heading">
    Customer
</h2>
<div class="row row-deck">
    <div class="col-lg-4">
        <a class="block block-rounded block-link-shadow text-center" href="<?php echo site_url('customer/view/'.$order['customer_id']); ?>">
            <div class="block-content pt-0 bg-gd-dusk">
                <div class="pull-r-l pull-b py-10 bg-black-op-25">
                    <div class="font-w600 mb-5 text-white">
                        <?php echo $order['customer_full_name']; ?><hr>
                        Email: <?php echo $order['customer_email']; ?><br>
                        Mobile: <?php echo $order['customer_mobile']; ?>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="row items-push text-center">
                    <div class="col-6">
                        <div class="mb-5"><i class="si si-bag fa-2x"></i></div>
                        <div class="font-size-sm text-muted"><?php echo $customer['total_orders']; ?> Orders</div>
                    </div>
                    <div class="col-6">
                        <div class="mb-5"><i class="si si-basket-loaded fa-2x"></i></div>
                        <div class="font-size-sm text-muted"><?php echo $customer['total_bought_products']; ?> Products</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-8">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Other Orders</h3>
            </div>
            <div class="block-content">
                <table class="table table-borderless table-sm table-striped">
                    <tbody>
                        <?php if(!empty($other_orders)) { ?>
                            <?php foreach($other_orders as $other_order) { ?>
                                <tr>
                                    <td>
                                        <a class="font-w600" href="<?php echo site_url('order/view/'.$other_order['id']); ?>">#<?php echo $other_order['order_id'] ?></a>
                                    </td>
                                    <td><?php echo get_order_status_text($other_order['status']); ?></td>
                                    <td class="d-none d-sm-table-cell"><?php echo convert_db_time($other_order['created_on'], "d/m/Y H:i"); ?></td>
                                    <td class="text-right">
                                        <span class="text-black"><?php echo show_price($other_order['total'], $other_order['currency']); ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<h2 class="content-heading">Addresses</h2>
<div class="row row-deck gutters-tiny">
    <div class="col-md-6">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Billing Address</h3>
            </div>
            <div class="block-content">
                <div class="font-size-lg text-black mb-5"><?php echo $order['customer_full_name'] ?></div>
                <address>
                    <?php echo $order['billing_address_line_1'] ?><br>
                    <?php if($order['billing_address_line_2']) { ?>
                        <?php echo $order['billing_address_line_2'] ?><br>
                    <?php } ?>
                    <?php if($order['billing_landmark']) { ?>
                        <?php echo $order['billing_landmark'] ?>, 
                    <?php } ?>
                    <?php echo $order['billing_city'] ?>, <?php echo $order['billing_state'] ?><br>
                    <?php echo $order['billing_country'] ?> - <?php echo $order['billing_pin_code'] ?><br><br>
                    <i class="fa fa-phone mr-5"></i> <?php echo $order['customer_mobile'] ?><br>
                    <i class="fa fa-envelope-o mr-5"></i> <a href="mailto:<?php echo $order['customer_email'] ?>"><?php echo $order['customer_email'] ?></a>
                </address>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Shipping Address</h3>
            </div>
            <div class="block-content">
                <div class="font-size-lg text-black mb-5"><?php echo $order['customer_full_name'] ?></div>
                <address>
                    <?php echo $order['shipping_address_line_1'] ?><br>
                    <?php if($order['shipping_address_line_2']) { ?>
                        <?php echo $order['shipping_address_line_2'] ?><br>
                    <?php } ?>
                    <?php if($order['shipping_landmark']) { ?>
                        <?php echo $order['shipping_landmark'] ?>, 
                    <?php } ?>
                    <?php echo $order['shipping_city'] ?>, <?php echo $order['shipping_state'] ?><br>
                    <?php echo $order['shipping_country'] ?> - <?php echo $order['shipping_pin_code'] ?><br><br>
                    <i class="fa fa-phone mr-5"></i> <?php echo $order['customer_mobile'] ?><br>
                    <i class="fa fa-envelope-o mr-5"></i> <a href="mailto:<?php echo $order['customer_email'] ?>"><?php echo $order['customer_email'] ?></a>
                </address>
            </div>
        </div>
    </div>
</div>
<h2 class="content-heading">Products (<?php echo count($order_items) ?>)</h2>
<div class="block block-rounded mb-0">
    <div class="block-content p-4">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px;"></th>
                        <th>Product</th>
                        <th class="text-center">QTY</th>
                        <th class="text-right" style="width: 10%;">UNIT</th>
                        <th class="text-right" style="width: 10%;">PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($order_items)) { ?>
                        <?php foreach ($order_items as $key => $order_item) { ?>
                            <tr>
                                <td>
                                    <a class="font-w600" href="<?php echo site_url('product/edit/'.$order_item['product_id']); ?>"><img width="100px" src="<?php echo show_image(base_url('uploads/products/images/'.$order_item['image']), ['thumbnail' => '500_500']); ?>"></a>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('product/edit/'.$order_item['product_id']); ?>"><?php echo $order_item['name'] ?></a>
                                </td>
                                <td class="text-center font-w600"><?php echo $order_item['quantity'] ?></td>
                                <td class="text-right"><?php echo show_price($order_item['price'], $order['currency']) ?></td>
                                <td class="text-right"><?php echo show_price($order_item['total'], $order['currency']) ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <td colspan="4" class="text-right font-w600">Subtotal:</td>
                        <td class="text-right"><?php echo show_price($order['subtotal'], $order['currency']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right font-w600">Shipping:</td>
                        <td class="text-right"><?php echo show_price($order['shipping_amount'], $order['currency']) ?></td>
                    </tr>
                    <?php if($order['discount_amount'] > 0) { ?>
                        <tr>
                            <td colspan="4" class="text-right font-w600">Discount:</td>
                            <td class="text-right">- <?php echo show_price($order['discount_amount'], $order['currency']) ?></td>
                        </tr>
                    <?php } ?>
                    <?php if($order['wallet_paid_amount'] > 0) { ?>
                        <tr>
                            <td colspan="4" class="text-right font-w600">Wallet:</td>
                            <td class="text-right">- <?php echo show_price($order['wallet_paid_amount'], $order['currency']) ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" class="text-right font-w600">Total:</td>
                        <td class="text-right"><?php echo show_price($order['total'], $order['currency']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<h2 class="content-heading">Instructions</h2>
<div class="block block-rounded mb-0">
    <div class="block-content p-4">
        <div class="font-size-lg text-black"><?php echo ($order['instructions']) ? $order['instructions'] : '-- None --'; ?></div>
    </div>
</div>
<h2 class="content-heading">Order Update</h2>
<form method="post">
    <div class="block block-rounded">
        <div class="block-content p-4">
            <div class="form-group">
                <h3 class="block-title mb-2">Status</h3>
                <select class="form-control js-select2" name="status">
                    <?php foreach ($order_statuses as $key => $order_status) { ?>
                        <option value="<?php echo $key; ?>" <?php echo $order['status'] == $key ? 'selected' :''; ?>><?php echo $order_status; ?></option>
                    <?php } ?>
                </select>
                <p class="text-muted mt-2">[Changing status will send an email to the customer marking the status update for their order.]</p>
            </div>
            <div class="form-group">
                <h3 class="block-title mb-2">Message</h3>
                <textarea type="text" class="form-control" name="message"></textarea>
            </div>
            <hr>
            <div class="form-group">
                <h3 class="block-title mb-2">Payment</h3>
                <select class="form-control js-select2" name="payment">
                    <?php foreach ($order_payments as $key => $order_payment) { ?>
                        <option value="<?php echo $key; ?>" <?php echo $order['payment'] == $key ? 'selected' :''; ?>><?php echo $order_payment; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn btn-success" type="submit">Update</button>
        </div>
    </div>
</form>