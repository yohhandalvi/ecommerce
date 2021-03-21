<p>Hi <?php echo $order['name']; ?>,</p>
<p>Your order #<?php echo $order['order_id'] ?> has been succesfully delivered.</p>
<?php if($order['message']) { ?>
	<p>Message : <?php echo $order['message']; ?></p>
<?php } ?>