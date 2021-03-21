<p>Hi <?php echo $order['name']; ?>,</p>
<p>Your order #<?php echo $order['order_id'] ?> has been cancelled by us.</p>
<?php if($order['message']) { ?>
	<p>Cancellation Reason : <?php echo $order['message']; ?></p>
<?php } ?>