<?php $this->load->view('admin/layout/alert'); ?>
<?php if($message) { ?>
	<div class="alert alert-danger mb-4">
		<?php echo $message; ?>
	</div>
<?php } ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('cashback/listing'); ?>">Cashback</a>
            <span class="breadcrumb-item active">Add</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Cashback - Add</h2>
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
				        <label class="form-control-label">Name <span class="text-danger">*</span></label>
				        <input type="text" placeholder="Name" name="name" value="<?php echo $this->input->post('name') ?>" class="form-control">
				        <?php echo form_error('name'); ?>
				    </div>
				    <div class="form-group">
				        <label class="form-control-label">Description</label>
				        <textarea placeholder="Description" name="description" class="form-control"><?php echo $this->input->post('description') ?></textarea>
				        <?php echo form_error('description'); ?>
				    </div>
				    <div class="row">
				        <div class="col-md-4">
				            <div class="form-group for-shop">
				                <label class="form-control-label">Cashback Type <span class="text-danger">*</span></label>
				                <select name="type" class="form-control js-select2" style="width: 100%;">
				                    <?php
				                        $selected = '';
				                        if($this->input->post('type') == 'percent') {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="percent" <?php echo $selected; ?>>Percentage : %</option>
				                    <?php
				                        $selected = '';
				                        if($this->input->post('type') == 'amount') {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="amount" <?php echo $selected; ?>>Amount : INR</option>
				                </select>
			        			<?php echo form_error('amount'); ?>
				            </div>
				        </div>
				        <div class="col-md-4">
				            <div class="form-group for-shop">
				                <label class="form-control-label">Value <span class="text-danger">*</span></label>
				                <input type="text" placeholder="Number" name="value" value="<?php echo $this->input->post('value') ?>" class="form-control">
			        			<?php echo form_error('value'); ?>
				            </div>
				        </div>
				        <div class="col-md-4">
				            <div class="form-group for-shop">
				                <label class="form-control-label">Max Value </label>
				                <input type="text" placeholder="Number" name="max_value" value="<?php echo $this->input->post('max_value') ?>" class="form-control">
			        			<?php echo form_error('max_value'); ?>
				            </div>
				            <input type="checkbox" name="total_order" value="total order"> Apply on total orders<br>
				        </div>
				    </div>
				</div>
			</div>
			<div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Validity</h3>
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
				                <label class="form-control-label">From Date <span class="text-danger">*</span></label>
				                <input type="date" placeholder="Valid From Date" name="valid_from_date" value="<?php echo $this->input->post('valid_from_date') ?>" class="form-control">
			        			<?php echo form_error('valid_from_date'); ?>
				            </div>
				        </div>
				        <div class="col-md-6">
				            <div class="form-group">
				                <label class="form-control-label">To Date <span class="text-danger">*</span></label>
				                <input type="date" placeholder="Valid To Date" name="valid_to_date" value="<?php echo $this->input->post('valid_to_date') ?>" class="form-control">
			        			<?php echo form_error('valid_to_date'); ?>
				            </div>
				        </div>
				    </div>
				    <div class="row">
				        <div class="col-md-6">
				            <div class="form-group for-shop">
				                <label class="form-control-label">Total Available </label>
				                <input type="text" placeholder="Quantity" name="available" value="<?php echo $this->input->post('available') ?>" class="form-control">
			        			<?php echo form_error('available'); ?>
				            </div>
				        </div>
				        <div class="col-md-6">
				            <div class="form-group for-shop">
				                <label class="form-control-label">Total Avaible for 1 User </label>
				                <input type="text" placeholder="Quantity allowed for 1 user" name="available_for_single_user" value="<?php echo $this->input->post('available_for_single_user') ?>" class="form-control">
			        			<?php echo form_error('available_for_single_user'); ?>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			<div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Restrictions - Customers</h3>
                    <div class="block-options">
                        <button type="submit" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-save mr-5"></i>Add
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
				    <div class="row">
				        <div class="col-md-4">
				            <div class="form-group">
				                <label class="form-control-label">Limit To </label>
				                <select name="limit_to" class="form-control js-select2" onchange="changeLimitTo(this);">
				                    <?php
				                        $selected = '';
				                        if($this->input->post('limit_to') == "all") {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="all" <?php echo $selected; ?>>All</option>
				                    <?php
				                        $selected = '';
				                        if($this->input->post('limit_to') == "user_group") {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="user_group" <?php echo $selected; ?>>User Group</option>
				                    <?php
				                        $selected = '';
				                        if($this->input->post('limit_to') == "custom") {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="custom" <?php echo $selected; ?>>Select Customers</option>
				                </select>
				        		<?php echo form_error('limit_to'); ?>
				            </div>
				        </div>
				        <?php
				            $show = 'd-none';
				            if($this->input->post('limit_to') == "user_group") {
				                $show = '';
				            }
				        ?>
				        <div class="col-md-4 <?php echo $show; ?>" data-box="limit-user-group">
				            <div class="form-group row">
			                	<label class="form-control-label col-12">User Group <span class="text-danger">*</span></label>
				            	<div class="col-md-12">
					                <select name="limit_to_customer_group_id" class="form-control js-select2" style="width: 100%;">
					                    <option value="">-- Choose --</option>
					                    <?php foreach ($customer_groups as $customer_group) { ?>
					                        <option <?php echo ($this->input->post('limit_to_customer_group_id') && $this->input->post('limit_to_customer_group_id') == $customer_group['id']) ? 'selected' : ''; ?> value="<?= $customer_group['id'] ?>">
					                            <?php echo $customer_group['name']; ?>
					                        </option>
					                    <?php } ?>
					                </select>
				        			<?php echo form_error('limit_to_customer_group_id'); ?>
					            </div>
				            </div>
				        </div>
				        <?php
				            $show = 'd-none';
				            if($this->input->post('limit_to') == "custom") {
				                $show = '';
				            }
				        ?>
				        <div class="col-md-12 <?php echo $show; ?>" data-box="limit-custom">
				            <div class="form-group">
				                <label class="form-control-label d-block">Customers <span class="text-danger">*</span> <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#customerModal">Add</button></label>
				                <table class="table" id="customersTbl">
					                <tbody>
					                </tbody>
				                </table>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			<div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Restrictions - Products</h3>
                    <div class="block-options">
                        <button type="submit" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-save mr-5"></i>Add
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
				    <div class="row">
				        <div class="col-md-4">
				            <div class="form-group for-shop">
				                <label class="form-control-label">Apply Cashback To <span class="text-danger">*</span></label>
				                <select name="apply_cashback_to" class="form-control js-select2" style="width: 100%;" onchange="changeApplyTo(this);">
				                    <?php
				                        $selected = '';
				                        if($this->input->post('apply_cashback_to') == "all") {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="all" <?php echo $selected; ?>>All</option>
				                    <?php
				                        $selected = '';
				                        if($this->input->post('apply_cashback_to') == "custom") {
				                            $selected = 'selected';
				                        }
				                    ?>
				                    <option value="custom" <?php echo $selected; ?>>Select Products</option>
				                </select>
			        			<?php echo form_error('apply_cashback_to'); ?>
				            </div>
				        </div>
				        <?php
				            $show = 'd-none';
				            if($this->input->post('apply_cashback_to') == "custom") {
				                $show = '';
				            }
				        ?>
				        <div class="col-md-12 <?php echo $show; ?>" data-box="apply-custom">
				            <div class="form-group for-shop">
				                <label class="form-control-label d-block">Products <span class="text-danger">*</span> <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#productModal">Add</button></label>
				                <table class="table" id="productsTbl">
					                <tbody>
					                </tbody>
				                </table>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			<div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Status</h3>
                    <div class="block-options">
                        <button type="submit" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-save mr-5"></i>Add
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="form-group row">
                        <label class="col-12">Active</label>
                        <div class="col-12">
                            <label class="css-control css-control-primary css-radio">
	                            <input type="radio" class="css-control-input" id="cashback-active" name="inactive" value="0" checked>
	                            <span class="css-control-indicator"></span> Yes
	                        </label>
	                        <label class="css-control css-control-secondary css-radio">
	                            <input type="radio" class="css-control-input" id="cashback-inactive" name="inactive" value="1">
	                            <span class="css-control-indicator"></span> No
	                        </label>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</form>

<script>
    function changeLimitTo(field) {
        $("div[data-box='limit-user-group']").addClass("d-none");
        $("div[data-box='limit-custom']").addClass("d-none");
        if(field.value == "user_group") {
            $("div[data-box='limit-user-group']").removeClass("d-none");
        } else if (field.value == "custom") {
            $("div[data-box='limit-custom']").removeClass("d-none");
        }
    }
    function changeApplyTo(field) {
        $("div[data-box='apply-custom']").addClass("d-none");
        if (field.value == "custom") {
            $("div[data-box='apply-custom']").removeClass("d-none");
        }
    }

	$(document).on("click", ".btn-customer-add", function() {
    	var _this = $(this);
    	var id = _this.data('id');
    	var name = _this.data('name');
    	var email = _this.data('email');
    	var mobile = _this.data('mobile');
    	$("#customersTbl").find('tbody').append('<tr><td width="25%">'+name+'<input type="checkbox" class="d-none" name="limit_to_customers[]" checked value="'+id+'"></td><td width="25%">'+email+'</td><td width="25%">'+mobile+'</td><td><a href="javascript:void(0);" class="btn-customer-rm btn btn-danger btn-sm">Remove</a></td></tr>');
    	$("#customerModal").modal('hide');
    });

    $(document).on("click", ".btn-customer-rm", function() {
    	var _this = $(this);
    	_this.parents('tr').remove();
    });

    $(document).on("click", ".btn-product-add", function() {
    	var _this = $(this);
    	var id = _this.data('id');
    	var name = _this.data('name');
    	$("#productsTbl").find('tbody').append('<tr><td width="90%">'+name+'<input type="checkbox" class="d-none" name="apply_to_products[]" checked value="'+id+'"></td><td><a href="javascript:void(0);" class="btn-product-rm btn btn-danger btn-sm">Remove</a></td></tr>');
    	$("#productModal").modal('hide');
    });

    $(document).on("click", ".btn-product-rm", function() {
    	var _this = $(this);
    	_this.parents('tr').remove();
    });
</script>

<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Select Customers</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                	<thead>
	                	<tr>
	                		<th width="25%">Name</th>
	                		<th width="25%">Email</th>
	                		<th width="25%">Mobile</th>
	                		<th width="25%"></th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php foreach ($customers as $customer) { ?>
	                		<tr>
		                		<td><?php echo $customer['first_name'] . " " . $customer['last_name']; ?></td>
	                			<td><?php echo $customer['email']; ?></td>
	                			<td><?php echo ($customer['mobile']) ? $customer['mobile'] : '-'; ?></td>
		                		<td><a href="javascript:void(0);" class="btn-customer-add" data-name="<?php echo $customer['first_name'] . " " . $customer['last_name']; ?>" data-id="<?php echo $customer['id']; ?>" data-email="<?php echo $customer['email']; ?>" data-mobile="<?php echo ($customer['mobile']) ? $customer['mobile'] : '-'; ?>">Select</a></td>
		                	</tr>
			            <?php } ?>
			        </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Select Products</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                	<thead>
	                	<tr>
	                		<th width="20%">#</th>
	                		<th width="60%">Name</th>
	                		<th width="20%"></th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php foreach ($products as $product) { ?>
	                		<tr>
	                			<td><?php echo $product['id']; ?></td>
		                		<td><?php echo $product['name']; ?></td>
		                		<td><a href="javascript:void(0);" class="btn-product-add" data-name="<?php echo $product['name']; ?>" data-id="<?php echo $product['id']; ?>">Select</a></td>
		                	</tr>
			            <?php } ?>
			        </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>