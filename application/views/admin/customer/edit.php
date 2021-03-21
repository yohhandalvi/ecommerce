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
				<a href="<?php echo site_url('customer/edit/'.$customer['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
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
		                <div class="block-header">
		                    <h3 class="block-title">Basic Info</h3>
		                    <div class="block-options">
		                        <button type="submit" class="btn btn-sm btn-alt-primary">
		                            <i class="fa fa-save mr-5"></i>Save
		                        </button>
		                    </div>
		                </div>
		                <div class="block-content block-content-full">
				            <div class="form-group row">
				                <div class="col-md-4">
									<label class="form-control-label">Title</label>
									<select class="form-control js-select2" name="title" style="width: 100%;" data-placeholder="-- Choose --">
										<option value="">-- Choose --</option>
										<option value="mr" <?php echo ($this->input->post('title') == "mr" || $customer['title'] == "mr") ? "selected" : ""; ?>>Mr</option>
										<option value="mrs" <?php echo ($this->input->post('title') == "mrs" || $customer['title'] == "mrs") ? "selected" : ""; ?>>Mrs</option>
										<option value="miss" <?php echo ($this->input->post('title') == "miss" || $customer['title'] == "miss") ? "selected" : ""; ?>>Miss</option>
									</select>
									<?php echo form_error('title'); ?>
								</div>
								<div class="col-md-4">
									<label class="form-control-label">First Name <span class="text-danger">*</span></label>
									<input type="text" name="first_name" placeholder="First Name" value="<?php echo ($this->input->post('first_name')) ? $this->input->post('first_name') : $customer['first_name']; ?>" class="form-control">
									<?php echo form_error('first_name'); ?>
								</div>
								<div class="col-md-4">
									<label class="form-control-label">Last Name <span class="text-danger">*</span></label>
									<input type="text" name="last_name" placeholder="Last Name" value="<?php echo ($this->input->post('last_name')) ? $this->input->post('last_name') : $customer['last_name']; ?>" class="form-control">
									<?php echo form_error('last_name'); ?>
								</div>
				            </div>
				            <div class="form-group row">
				                <div class="col-12">
									<label class="form-control-label">Group <span class="text-danger">*</span></label>
									<select class="form-control js-select2" name="customer_group_id" style="width: 100%;" data-placeholder="-- Choose --">
										<option value="">-- Choose --</option>
										<?php foreach ($customer_groups as $key => $customer_group) { ?>
											<option value="<?php echo $customer_group['id']; ?>" <?php echo ($this->input->post('customer_group_id') == $customer_group['id'] || $customer['customer_group_id'] == $customer_group['id']) ? "selected" : ""; ?>><?php echo $customer_group['name']; ?></option>
										<?php } ?>
									</select>
									<?php echo form_error('customer_group_id'); ?>
					            </div>
				            </div>
							<div class="form-group row">
				                <div class="col-12">
									<label class="form-control-label">Date Of Birth</label>
									<input type="date" name="date_of_birth" placeholder="Date Of Birth" value="<?php echo ($this->input->post('date_of_birth')) ? $this->input->post('date_of_birth') : $customer['date_of_birth']; ?>" class="form-control">
									<?php echo form_error('date_of_birth'); ?>
								</div>
							</div>
							<div class="form-group row">
				                <div class="col-12">
									<label class="form-control-label">Gender</label>
									<select class="form-control js-select2" name="gender">
										<option value="">-- Choose --</option>
										<option value="male" <?php echo ($this->input->post('gender') == "male" || $customer['gender'] == "male") ? "selected" : ""; ?>>Male</option>
										<option value="female" <?php echo ($this->input->post('gender') == "female" || $customer['gender'] == "female") ? "selected" : ""; ?>>Female</option>
										<option value="other" <?php echo ($this->input->post('gender') == "other" || $customer['gender'] == "other") ? "selected" : ""; ?>>Other</option>
									</select>
									<?php echo form_error('gender'); ?>
								</div>
							</div>
		                </div>
		            </div>
			        <div class="block block-rounded block-themed">
			            <div class="block-header">
			                <h3 class="block-title">Contact</h3>
			                <div class="block-options">
			                    <button type="submit" class="btn btn-sm btn-alt-primary">
			                        <i class="fa fa-save mr-5"></i>Save
			                    </button>
			                </div>
			            </div>
			            <div class="block-content block-content-full">
			                <div class="form-group row">
				                <div class="col-12">
									<label class="form-control-label">Email <span class="text-danger">*</span></label>
									<input type="text" name="email" placeholder="Email" value="<?php echo ($this->input->post('email')) ? $this->input->post('email') : $customer['email']; ?>" class="form-control">
									<?php echo form_error('email'); ?>
								</div>
							</div>
							<div class="form-group row">
				                <div class="col-12">
									<label class="form-control-label">Mobile</label>
									<input type="text" name="mobile" placeholder="Mobile" value="<?php echo ($this->input->post('mobile')) ? $this->input->post('mobile') : $customer['mobile']; ?>" class="form-control">
									<?php echo form_error('mobile'); ?>
								</div>
							</div>
			            </div>
			        </div>
			        <div class="block block-rounded block-themed">
			            <div class="block-header">
			                <h3 class="block-title">Status</h3>
			                <div class="block-options">
			                    <button type="submit" class="btn btn-sm btn-alt-primary">
			                        <i class="fa fa-save mr-5"></i>Save
			                    </button>
			                </div>
			            </div>
			            <div class="block-content block-content-full">
			                <div class="form-group row">
			                    <label class="col-12">Active</label>
			                    <div class="col-12">
			                        <label class="css-control css-control-primary css-radio">
			                            <input type="radio" class="css-control-input" id="customer-active" name="inactive" value="0" <?php echo ($this->input->post('inactive') == "0" || $customer['inactive'] == "0") ? "checked" : ""; ?>>
			                            <span class="css-control-indicator"></span> Yes
			                        </label>
			                        <label class="css-control css-control-secondary css-radio">
			                            <input type="radio" class="css-control-input" id="customer-inactive" name="inactive" value="1" <?php echo ($this->input->post('inactive') == "1" || $customer['inactive'] == "1") ? "checked" : ""; ?>>
			                            <span class="css-control-indicator"></span> No
			                        </label>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</form>