<p>Hi <?php echo $order['name']; ?>,</p>
<p>Your order #<?php echo $order['order_id'] ?> has been confirmed by us.</p>
<?php if($order['message']) { ?>
	<p>Message : <?php echo $order['message']; ?></p>
<?php } ?>