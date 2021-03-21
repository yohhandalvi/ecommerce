<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('product/listing'); ?>">Products</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Product - Discount</h2>
<form method="post">
    <div class="row gutters-tiny">
        <div class="col-md-4">
            <div class="list-group">
                <a href="<?php echo site_url('product/edit/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Info</h5>
                    </div>
                    <p class="mb-1">Basic details of the item / product.</p>
                </a>
                <a href="<?php echo site_url('product/images/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Images</h5>
                    </div>
                    <p class="mb-1">Upload images for the product.</p>
                </a>
                <a href="<?php echo site_url('product/stock/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Stock</h5>
                    </div>
                    <p class="mb-1">Manage stock for the product.</p>
                </a>
                <a href="<?php echo site_url('product/discount/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Discount</h5>
                    </div>
                    <p class="mb-1">Apply discount to the product.</p>
                </a>
                <a href="<?php echo site_url('product/reviews/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Reviews</h5>
                    </div>
                    <p class="mb-1">All the reviews submitted by the customer.</p>
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row gutters-tiny">
                <div class="col-md-12">
                    <div class="block block-rounded block-themed">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title">Discount</h3>
                            <div class="block-options">
                                <button type="submit" class="btn btn-sm btn-alt-primary">
                                    <i class="fa fa-save mr-5"></i>Save
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="form-group row">
                                <label class="col-12">Has Discount?</label>
                                <div class="col-12">
                                    <label class="css-control css-control-primary css-radio">
                                        <input type="radio" class="css-control-input" id="product-active" name="has_discount" value="1" <?php echo ($this->input->post('has_discount') == "1" || $product['has_discount'] == "1") ? "checked" : ""; ?>>
                                        <span class="css-control-indicator"></span> Yes
                                    </label>
                                    <label class="css-control css-control-secondary css-radio">
                                        <input type="radio" class="css-control-input" id="product-inactive" name="has_discount" value="0" <?php echo ($this->input->post('has_discount') == "0" || $product['has_discount'] == "0") ? "checked" : ""; ?>>
                                        <span class="css-control-indicator"></span> No
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Type</label>
                                    <select name="discount_type" class="form-control js-select2">
                                        <option value="percent" <?php echo ($this->input->post('discount_type') == "percent" || $product['discount_type'] == "percent") ? "selected" : ""; ?>>Percentage : %</option>
                                        <option value="amount" <?php echo ($this->input->post('discount_type') == "amount" || $product['discount_type'] == "amount") ? "selected" : ""; ?>>Amount : INR</option>
                                    </select>
                                    <?php echo form_error('discount_type'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Value</label>
                                    <input type="number" step="any" name="discount_value" placeholder="Discount Value" value="<?php echo ($this->input->post('discount_value')) ? $this->input->post('discount_value') : $product['discount_value']; ?>" class="form-control">
                                    <?php echo form_error('discount_value'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>