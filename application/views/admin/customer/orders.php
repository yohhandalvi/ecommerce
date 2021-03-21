<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('customer/listing'); ?>">Customers</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Customer - Edit</h2>
<form method="post">
	<div class="row gutters-tiny">
		<div class="col-md-4">
			<div class="list-group">
				<a href="<?php echo site_url('customer/edit/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Info</h5>
					</div>
					<p class="mb-1">Personal, contact info and status related to customer.</p>
				</a>
				<a href="<?php echo site_url('customer-address/listing/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Addresses</h5>
					</div>
					<p class="mb-1">Customer billing and shipping addresses list.</p>
				</a>
				<a href="<?php echo site_url('customer/orders/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Orders</h5>
					</div>
					<p class="mb-1">List of all the orders placed by the customer.</p>
				</a>
				<a href="<?php echo site_url('customer/reviews/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Product Reviews</h5>
					</div>
					<p class="mb-1">All the reviews submitted by the customer.</p>
				</a>
				<a href="<?php echo site_url('customer/wishlist/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Wishlist</h5>
					</div>
					<p class="mb-1">List all wishlisted products by the customer.</p>
				</a>
				<a href="<?php echo site_url('customer/wallet/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Wallet</h5>
					</div>
					<p class="mb-1">List all wallet cashback of the customer.</p>
				</a>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row gutters-tiny">
			    <div class="col-md-12">
			    	<div class="block block-rounded block-themed">
			            <div class="block-content block-content-full">
					    	<div class="table-responsive">
						        <table class="table table-striped table-vcenter">
						            <thead>
						            	<tr class="border-double">
						                    <th>#</th>
						                    <th>Order ID</th>
						                    <th>Status</th>
						                    <th>Payment</th>
						                    <th>Total</th>
						                    <th>Placed On</th>
						                </tr>
						            </thead>
						            <tbody>
						            	<?php if(!empty($orders)) { ?>
						                    <?php foreach($orders as  $order) { ?>
						                        <tr>
						                    		<th class="text-center" scope="row"><?php echo $order['id']; ?></th>
						                            <td><a href="<?php echo site_url('order/view/'.$order['id']); ?>">#<?php echo $order['order_id']; ?></a></td>
						                            <td><?php echo get_order_status_text($order['status']); ?></td>
						                            <td><?php echo get_order_payment_text($order['payment']); ?></td>
						                            <td><?php echo show_price($order['total'], $order['currency']); ?></td>
						                            <td><?php echo convert_db_time($order['created_on'], "d/m/Y H:i"); ?></td>
						                        </tr>
						                    <?php } ?>
						                <?php } else { ?>
						                    <tr>
						                        <td colspan="6">No customers added / registered yet</td>
						                    </tr>
						                <?php } ?>
						            </tbody>
						        </table>
						    </div>
					    </div>
				    </div>
			    </div>
			</div>
		</div>
	</div>
</form>