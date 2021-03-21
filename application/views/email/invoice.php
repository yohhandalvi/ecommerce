<style type="text/css">
	.text-right
	{
		text-align: right;
	}
	.text-center
	{
		text-align: center;
	}
</style>
<br>
<br>
<table>
	<thead>
		
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="text-center">
				<img src="<?php echo FCPATH."resources/logo.png"; ?>" width="110px" >
			</td>
           
		</tr>
	</tbody>
</table>
<h3>Order #<?php echo $order['id']; ?></h3>
<br>
<h4>Name </h4><?php echo $order['customer_full_name']; ?>
<br>
<h4>Shipping Address </h4>
<?php echo $order['shipping_address_line_1'] ?><br>
<?php if($order['shipping_address_line_2']) { ?>
<?php echo $order['shipping_address_line_2'] ?><br>
<?php } ?>
<?php if($order['shipping_landmark']) { ?>
<?php echo $order['shipping_landmark'] ?>, 
<?php } ?>
<?php echo $order['shipping_city'] ?>, <?php echo $order['shipping_state'] ?><br>
<?php echo $order['shipping_country'] ?> - <?php echo $order['shipping_pin_code'] ?>
<br>
<h4>Order Date </h4>
<?php echo date("d F Y", strtotime($order['created_on'])); ?>
<br>
<h4>Order Total </h4>
<?php echo show_price($order['total'], $order['currency']); ?>
<br>
<br>
<div id="invoice-items-details" class="pt-2">
    <table class="table" border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th width="25">#</th>
                <th class="text-center" width="220">Name</th>
                <th class="text-center">Price</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($order_items)) { ?>
                <?php foreach ($order_items as $key => $order_item) { ?>
                    <tr>
                        <td scope="row" width="25"><?php echo $key + 1; ?></td>
                        <td width="220">
                            <?php echo $order_item['name']; ?>
                        </td>
                        <td class="text-center"><?php echo show_price($order_item['price'], $order['currency']); ?></td>
                        <td class="text-center"><?php echo $order_item['quantity']; ?></td>
                        <td class="text-right"><?php echo show_price($order_item['total'], $order['currency']); ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td colspan="4" class="text-right">Subtotal</td>
                <td class="text-right"><?php echo show_price($order['subtotal'], $order['currency']); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Shipping</td>
                <?php if($order['shipping_amount'] > 0) { ?>
                    <td class="text-right">+ <?php echo show_price($order['shipping_amount'], $order['currency']); ?></td>
                <?php } else { ?>
                    <td class="text-right">Free</td>
                <?php } ?>
            </tr>
            <?php if($order['discount_id']) { ?>
                <tr>
                    <td colspan="4" class="text-right">Discount</td>
                    <td class="text-right">- <?php echo show_price($order['discount_amount'], $order['currency']); ?></td>
                </tr>
            <?php } ?>
            <?php if($order['wallet_paid_amount']) { ?>
                <tr>
                    <td colspan="4" class="text-right">Wallet</td>
                    <td class="text-right">- <?php echo show_price($order['wallet_paid_amount'], $order['currency']); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" class="text-right"><h4>Total</h4></td>
                <td class="text-right"><?php echo show_price($order['total'], $order['currency']); ?></td>
            </tr>
        </tbody>
    </table>
</div>