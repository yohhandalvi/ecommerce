<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
	<div class="content py-5 text-center">
		<nav class="breadcrumb bg-body-light mb-0">
			<a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
			<a class="breadcrumb-item" href="<?php echo site_url('cashback/listing'); ?>">Cashbacks</a>
			<span class="breadcrumb-item active">Wallet</span>
		</nav>
	</div>
</div>
<h2 class="content-heading">Add Wallet</h2> 
<form method="post">
	<div class="row gutters-tiny">
		<div class="col-md-12">
			<div class="block block-rounded block-themed">
				<div class="block-header bg-gd-primary">
					<h3 class="block-title">Info</h3>
					<div class="block-options">
						<button type="submit" class="btn btn-sm btn-alt-primary">
							<i class="fa fa-save mr-5"></i>Add
						</button>
					</div>
				</div>
				<div class="block-content block-content-full">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Customer <span class="text-danger">*</span></label>
								<select name="customer_id" class="form-control js-select2" style="width: 100%;">
									<option value="">-- Choose --</option>
									<?php if(!empty($customers)) { ?>
										<?php foreach ($customers as $key => $customer) { ?>
											<?php
											$selected = '';
											if($this->input->post('customer_id') == $customer['id']) {
												$selected = 'selected';
											}
											?>
											<option value="<?php echo $customer['id']; ?>" <?php echo $selected; ?>><?php echo $customer['full_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
								<?php echo form_error('customer_id'); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-control-label">Amount <span class="text-danger">*</span></label>
								<input type="text" placeholder="Amount" name="amount" value="<?php echo $this->input->post('amount') ?>" class="form-control">
								<?php echo form_error('amount'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>