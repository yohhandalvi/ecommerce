<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('shipping-rate/listing'); ?>">Shipping Rates</a>
            <span class="breadcrumb-item active">Add</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Shipping Rate - Add</h2>
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
				    <div class="form-group">
				        <label class="form-control-label">Amount From <span class="text-danger">*</span></label>
				        <input type="number" step="any" placeholder="Min cart amount" name="amount_from" value="<?php echo ($this->input->post('amount_from')) ? $this->input->post('amount_from') : $min_shipping_rate_amount; ?>" class="form-control" readonly>
				        <?php echo form_error('amount_from'); ?>
				    </div>
				    <div class="form-group">
				        <label class="form-control-label">Amount To</label>
				        <input type="number" step="any" placeholder="Upto cart amount (leave blank for marking all amounts above amount from)" name="amount_to" value="<?php echo $this->input->post('amount_to') ?>" class="form-control">
				        <?php echo form_error('amount_to'); ?>
				    </div>
				    <div class="form-group">
				        <label class="form-control-label">Shipping Fee</label>
				        <input type="number" step="any" placeholder="Shipping Fee (leave blank for 0 / free shipping)" name="shipping_fee" value="<?php echo $this->input->post('shipping_fee') ?>" class="form-control">
				        <?php echo form_error('shipping_fee'); ?>
				    </div>
				</div>
			</div>
		</div>
	</div>
</form>