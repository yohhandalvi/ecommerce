<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('currency/listing'); ?>">Currencies</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Currency - Edit</h2>
<form method="post">
	<div class="row gutters-tiny">
	    <div class="col-md-6">
            <div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Info</h3>
                    <div class="block-options">
                        <button type="submit" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-save mr-5"></i>Save
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
		            <div class="form-group row">
		            	<div class="col-md-12">
							<label class="form-control-label">Name <span class="text-danger">*</span></label>
							<input type="text" name="name" placeholder="Name" value="<?php echo ($this->input->post('name')) ? $this->input->post('name') : $currency['name']; ?>" class="form-control">
							<?php echo form_error('name'); ?>
			            </div>
		            </div>
		            <div class="form-group row">
		            	<div class="col-md-12">
							<label class="form-control-label">Symbol <span class="text-danger">*</span></label>
							<input type="text" name="symbol" placeholder="Symbol" value="<?php echo ($this->input->post('symbol')) ? $this->input->post('symbol') : $currency['symbol'] ?>" class="form-control">
							<?php echo form_error('symbol'); ?>
			            </div>
		            </div>
		            <div class="form-group row">
		            	<div class="col-md-12">
							<label class="form-control-label">Tax <span class="text-danger">*</span></label>
							<input type="text" name="tax" placeholder="Tax" value="<?php echo ($this->input->post('tax')) ? $this->input->post('tax') : $currency['tax'] ?>" class="form-control">
							<?php echo form_error('tax'); ?>
			            </div>
		            </div>
		            <?php if($currency['id'] > 1) { ?>
			            <div class="form-group row">
			            	<div class="col-md-12">
								<label class="form-control-label">Countries <span class="text-danger">*</span></label>
								<select class="form-control js-select2" multiple name="countries[]" style="width: 100%;" data-placeholder="-- Choose --">
									<option value="">-- Choose --</option>
									<?php foreach ($countries as $key => $c) { ?>
										<option value="<?php echo $c['id']; ?>" <?php echo (is_array($selected_countries) && in_array($c['id'], $selected_countries)) ? "selected" : ""; ?>><?php echo $c['name']; ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('countries[]'); ?>
							</div>
						</div>
					<?php } ?>
                </div>
            </div>
	    </div>
	</div>
</form>