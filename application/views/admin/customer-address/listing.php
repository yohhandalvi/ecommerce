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
<h2 class="content-heading">Customer - Addresses</h2>
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
				<a href="<?php echo site_url('customer-address/listing/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Addresses</h5>
					</div>
					<p class="mb-1">Customer billing and shipping addresses list.</p>
				</a>
				<a href="<?php echo site_url('customer/orders/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
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
				<a href="<?php echo site_url('customer/wallet_view/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Wallet</h5>
					</div>
					<p class="mb-1">List all wallet cashback of the customer.</p>
				</a>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row gutters-tiny">
			    <div class="col-md-6 col-xl-6">
			        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('customer-address/listing/'.$this->uri->segment(3)); ?>">
			            <div class="block-content block-content-full block-sticky-options">
			                <div class="block-options">
			                    <div class="block-options-item">
			                        <i class="fa fa-circle-o fa-2x text-info-light"></i>
			                    </div>
			                </div>
			                <div class="py-20 text-center">
			                    <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="<?php echo $count; ?>">0</div>
			                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Addresses</div>
			                </div>
			            </div>
			        </a>
			    </div>
			    <div class="col-md-6 col-xl-6">
			        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('customer-address/add/'.$this->uri->segment(3)); ?>">
			            <div class="block-content block-content-full block-sticky-options">
			                <div class="block-options">
			                    <div class="block-options-item">
			                        <i class="fa fa-archive fa-2x text-success-light"></i>
			                    </div>
			                </div>
			                <div class="py-20 text-center">
			                    <div class="font-size-h2 font-w700 mb-0 text-success">
			                        <i class="fa fa-plus"></i>
			                    </div>
			                    <div class="font-size-sm font-w600 text-uppercase text-muted">New Address</div>
			                </div>
			            </div>
			        </a>
			    </div>
			</div>
			<div class="row row-deck gutters-tiny">
				<?php if(!empty($customer_addresses)) { ?>
                    <?php foreach($customer_addresses as  $customer_address) { ?>
		                <div class="col-sm-4">
		                    <div class="block">
		                        <div class="block-header block-header-default">
		                            <h3 class="block-title"><?php echo ucwords($customer_address['name']); ?> [<?php echo ucwords($customer_address['type']); ?>]</h3>
		                            <div class="block-options">
                                        <a class="btn-block-option" href="<?php echo site_url('customer-address/edit/'.$customer_address['id']); ?>">
                                            <i class="si si-pencil"></i>
                                        </a>
                                        <a class="btn-block-option delete-confirm" href="<?php echo site_url('customer-address/delete/'.$customer_address['id']); ?>">
                                            <i class="si si-trash"></i>
                                        </a>
                                    </div>
		                        </div>
		                        <div class="block-content">
		                            <p class="m-0"><?php echo $customer_address['address_line_1']; ?></p>
		                            <p class="m-0"><?php echo $customer_address['address_line_2']; ?></p>
		                            <p class="m-0"><?php echo $customer_address['landmark']; ?></p>
		                            <p class="m-0"><?php echo $customer_address['city']; ?>, <?php echo $customer_address['state']; ?>, <?php echo $customer_address['country']; ?></p>
		                            <p class="mb-4"><?php echo $customer_address['pin_code']; ?></p>
		                        </div>
		                    </div>
		                </div>
		            <?php } ?>
	            <?php } ?>
            </div>
		</div>
	</div>
</form>