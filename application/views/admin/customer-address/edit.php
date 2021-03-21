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
<h2 class="content-heading">Customer - Address</h2>
<form method="post">
	<div class="row gutters-tiny">
		<div class="col-md-4">
			<div class="list-group">
				<a href="<?php echo site_url('customer/edit/'.$customer_address['customer_id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Info</h5>
					</div>
					<p class="mb-1">Personal, contact info and status related to customer.</p>
				</a>
				<a href="<?php echo site_url('customer-address/listing/'.$customer_address['customer_id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Addresses</h5>
					</div>
					<p class="mb-1">Customer billing and shipping addresses list.</p>
				</a>
				<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Orders</h5>
					</div>
					<p class="mb-1">List of all the orders placed by the customer.</p>
				</a>
				<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Product Reviews</h5>
					</div>
					<p class="mb-1">All the reviews submitted the customer.</p>
				</a>
				<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
					<div class="d-flex w-100 justify-content-between">
						<h5 class="mb-1">Wishlist</h5>
					</div>
					<p class="mb-1">List all wishlisted products by the customer.</p>
				</a>
				<a href="<?php echo site_url('customer/wallet/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
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
			        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('customer-address/listing/'.$customer_address['customer_id']); ?>">
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
			        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('customer-address/add/'.$customer_address['customer_id']); ?>">
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
			<div class="row gutters-tiny">
			    <div class="col-md-12">
		            <div class="block block-rounded block-themed">
		                <div class="block-header">
		                    <h3 class="block-title">Basic Info</h3>
		                    <div class="block-options">
		                        <button type="submit" class="btn btn-sm btn-alt-primary">
		                            <i class="fa fa-save mr-5"></i>Save
		                        </button>
		                    </div>
		                </div>
		                <div class="block-content block-content-full">
								<div class="form-group">
									<label class="form-control-label">Name <span class="text-danger">*</span></label>
									<select class="form-control js-select2" name="name">
										<option value="">-- Choose --</option>
										<option value="home" <?php echo ($this->input->post('name') == "home" || $customer_address['name'] == "home") ? "selected" : ""; ?>>Home</option>
										<option value="work" <?php echo ($this->input->post('name') == "work" || $customer_address['name'] == "work") ? "selected" : ""; ?>>Work</option>
										<option value="other" <?php echo ($this->input->post('name') == "other" || $customer_address['name'] == "other") ? "selected" : ""; ?>>Other</option>
									</select>
									<?php echo form_error('name'); ?>
								</div>
								<div class="form-group">
									<label class="form-control-label">Address Line 1 <span class="text-danger">*</span></label>
									<textarea name="address_line_1" placeholder="Address Line 1" rows="3" class="form-control"><?php echo ($this->input->post('address_line_1')) ? $this->input->post('address_line_1') : $customer_address['address_line_1']; ?></textarea>
									<?php echo form_error('address_line_1'); ?>
								</div>
								<div class="form-group">
									<label class="form-control-label">Address Line 2</label>
									<textarea name="address_line_2" placeholder="Address Line 2" rows="3" class="form-control"><?php echo ($this->input->post('address_line_2')) ? $this->input->post('address_line_2') : $customer_address['address_line_2']; ?></textarea>
									<?php echo form_error('address_line_2'); ?>
								</div>
								<div class="form-group">
									<label class="form-control-label">Landmark</label>
									<input type="text" name="landmark" placeholder="Landmark" value="<?php echo ($this->input->post('address_line_2')) ? $this->input->post('address_line_2') : $customer_address['address_line_2']; ?>" class="form-control">
									<?php echo form_error('landmark'); ?>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label">City <span class="text-danger">*</span></label>
											<input type="text" name="city" placeholder="City" value="<?php echo ($this->input->post('city')) ? $this->input->post('city') : $customer_address['city']; ?>" class="form-control">
											<?php echo form_error('city'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label">Pin Code <span class="text-danger">*</span></label>
											<input type="text" name="pin_code" placeholder="Pin Code" value="<?php echo ($this->input->post('pin_code')) ? $this->input->post('pin_code') : $customer_address['pin_code']; ?>" class="form-control">
											<?php echo form_error('pin_code'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label">State <span class="text-danger">*</span></label>
											<select class="form-control js-select2" name="state_id">
												<option value="">-- Choose --</option>
												<?php foreach ($states as $key => $state) { ?>
													<option value="<?php echo $state['id']; ?>" <?php echo ($this->input->post('state_id') == $state['id'] || $customer_address['state_id'] == $state['id']) ? "selected" : ""; ?>><?php echo $state['name']; ?></option>
												<?php } ?>
											</select>
											<?php echo form_error('state_id'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label">Country <span class="text-danger">*</span></label>
											<select class="form-control js-select2" name="country_id">
												<option value="">-- Choose --</option>
												<?php foreach ($countries as $key => $country) { ?>
													<option value="<?php echo $country['id']; ?>" <?php echo ($this->input->post('country_id') == $country['id'] || $customer_address['country_id'] == $country['id']) ? "selected" : ""; ?>><?php echo $country['name']; ?></option>
												<?php } ?>
											</select>
											<?php echo form_error('country_id'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
	                                        <label class="css-control css-control-primary css-checkbox">
	                                            <input type="checkbox" class="css-control-input" name="is_default" value="1" <?php echo ($this->input->post('is_default') == 1 || $customer_address['is_default'] == 1) ? "checked" : ""; ?>>
	                                            <span class="css-control-indicator"></span>&nbsp;&nbsp;Default
	                                        </label>
											<?php echo form_error('is_default'); ?>
										</div>
									</div>
								</div>
							</div>
		                </div>
		            </div>
			    </div>
			</div>
		</div>
	</div>
</form>