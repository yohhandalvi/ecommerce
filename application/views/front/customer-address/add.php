<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <a href="<?php echo site_url('my-account'); ?>">My Account</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Add New Address</strong></div>
        </div>
    </div>
</div>  
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black text-uppercase">Add New Address</h2>
                <form method="post">
                	<div class="p-3 p-lg-5 border">
						<div class="form-group row">
							<div class="col-md-12">
                                <label class="text-black">Name <span class="text-danger">*</span></label>
                                <select class="form-control" name="name">
									<option value="">-- Choose --</option>
									<option value="home" <?php echo ($this->input->post('name') == "home") ? "selected" : ""; ?>>Home</option>
									<option value="work" <?php echo ($this->input->post('name') == "work") ? "selected" : ""; ?>>Work</option>
									<option value="other" <?php echo ($this->input->post('name') == "other") ? "selected" : ""; ?>>Other</option>
								</select>
                                <?php echo form_error('name'); ?>
                            </div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label class="text-black">Address Line 1 <span class="text-danger">*</span></label>
								<textarea name="address_line_1" placeholder="" rows="3" class="form-control"><?php echo $this->input->post('address_line_1') ?></textarea>
								<?php echo form_error('address_line_1'); ?>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label class="text-black">Address Line 2</label>
								<textarea name="address_line_2" placeholder="Address Line 2" rows="3" class="form-control"><?php echo $this->input->post('address_line_2') ?></textarea>
								<?php echo form_error('address_line_2'); ?>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label class="text-black">Landmark</label>
								<input type="text" name="landmark" placeholder="Landmark" value="<?php echo $this->input->post('landmark') ?>" class="form-control">
								<?php echo form_error('landmark'); ?>
							</div>
						</div>
						<div class="form-group row">
                            <div class="col-md-6">
                                <label class="text-black">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" placeholder="" value="<?php echo $this->input->post('city') ?>" class="form-control">
                                <?php echo form_error('city'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-black">Pin Code <span class="text-danger">*</span></label>
                                <input type="text" name="pin_code" placeholder="" value="<?php echo $this->input->post('pin_code') ?>" class="form-control">
                                <?php echo form_error('pin_code'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="text-black">State <span class="text-danger">*</span></label>
                                <select class="form-control" name="state_id">
									<option value="">-- Choose --</option>
									<?php foreach ($states as $key => $state) { ?>
										<option value="<?php echo $state['id']; ?>" <?php echo ($this->input->post('state_id') == $state['id']) ? "selected" : ""; ?>><?php echo $state['name']; ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('state_id'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-black">Country <span class="text-danger">*</span></label>
                                <select class="form-control" name="country_id">
									<option value="">-- Choose --</option>
									<?php foreach ($countries as $key => $country) { ?>
										<option value="<?php echo $country['id']; ?>" <?php echo ($this->input->post('country_id') == $country['id']) ? "selected" : ""; ?>><?php echo $country['name']; ?></option>
									<?php } ?>
								</select>
								<?php echo form_error('country_id'); ?>
                            </div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
			                        <label class="css-control css-control-primary css-checkbox">
			                            <input type="checkbox" class="css-control-input" name="is_default" value="1" <?php echo ($this->input->post('is_default') == 0) ? "" : "checked"; ?>>
			                            <span class="css-control-indicator"></span>&nbsp;&nbsp;Default
			                        </label>
									<?php echo form_error('is_default'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
			                        <label class="css-control css-control-primary css-checkbox">
			                            <input type="checkbox" class="css-control-input" name="address[]" value="billing" <?php echo (!$this->input->post('address') || (is_array($this->input->post('address')) && !in_array("billing", $this->input->post('address')))) ? "" : "checked"; ?>>
			                            <span class="css-control-indicator"></span>&nbsp;&nbsp;Billing Address
			                        </label>
									<?php echo form_error('address[]'); ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
			                        <label class="css-control css-control-primary css-checkbox">
			                            <input type="checkbox" class="css-control-input" name="address[]" value="shipping" <?php echo (!$this->input->post('address') || (is_array($this->input->post('address')) && !in_array("shipping", $this->input->post('address')))) ? "" : "checked"; ?>>
			                            <span class="css-control-indicator"></span>&nbsp;&nbsp;Shipping Address
			                        </label>
									<?php echo form_error('address[]'); ?>
								</div>
							</div>
						</div>
						<div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary btn-lg btn-block" name="" value="Add">
                            </div>
                        </div>
					</div>
				</form>
			</div>
        </div>
    </div>
</div>