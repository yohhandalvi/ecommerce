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
<h2 class="content-heading">Product - Edit</h2> 
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
                <a href="<?php echo site_url('product/pricing/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Pricing</h5>
                    </div>
                    <p class="mb-1">Manage product pricing.</p>
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
                <a href="<?php echo site_url('product/discount/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
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
                    <?php foreach ($currencies as $currency) { ?>
                        <?php
                            $price = null;
                            $tax_rate = null;
                            $price_excl_tax = null;
                            $additional_shipping_cost = null;
                        ?>
                        <?php if(!empty($product_prices)) { ?>
                            <?php foreach ($product_prices as $product_price) { ?>
                                <?php if($product_price['currency_id'] == $currency['id']) { ?>
                                    <?php
                                        $price = $product_price['price'];
                                        $tax_rate = $product_price['tax_rate'];
                                        $price_excl_tax = $product_price['price_excl_tax'];
                                        $additional_shipping_cost = $product_price['additional_shipping_cost'];
                                        break;
                                    ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <div class="block block-rounded block-themed">
                            <div class="block-header bg-gd-primary">
                                <h3 class="block-title">Pricing - <?php echo $currency['name'] ?></h3>
                                <div class="block-options">
                                    <button type="submit" class="btn btn-sm btn-alt-primary">
                                        <i class="fa fa-save mr-5"></i>Save
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="form-control-label">MRP <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="currencies[<?php echo $currency['id']; ?>][price]" min="0" placeholder="Price" value="<?php echo ($this->input->post('currencies['.$currency['id'].'][price]')) ? $this->input->post('currencies['.$currency['id'].'][price]') : $price; ?>" class="form-control">
                                        <?php echo form_error('currencies['.$currency['id'].'][price]'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="form-control-label"><?php echo $currency['tax']; ?> Rate % <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="currencies[<?php echo $currency['id']; ?>][tax_rate]" min="0" placeholder="GST Rate %" value="<?php echo ($this->input->post('currencies['.$currency['id'].'][tax_rate]')) ? $this->input->post('currencies['.$currency['id'].'][tax_rate]') : $tax_rate; ?>" class="form-control">
                                        <?php echo form_error('currencies['.$currency['id'].'][tax_rate]'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="form-control-label">Price (excl tax) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="currencies[<?php echo $currency['id']; ?>][price_excl_tax]" min="0" placeholder="Price (excl tax)" value="<?php echo ($this->input->post('currencies['.$currency['id'].'][price_excl_tax]')) ? $this->input->post('currencies['.$currency['id'].'][price_excl_tax]') : $price_excl_tax; ?>" class="form-control">
                                        <?php echo form_error('currencies['.$currency['id'].'][price_excl_tax]'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label class="form-control-label">Additional Shipping Cost</label>
                                        <input type="number" name="currencies[<?php echo $currency['id']; ?>][additional_shipping_cost]" min="0" placeholder="Additional Shipping Cost" value="<?php echo ($this->input->post('currencies['.$currency['id'].'][additional_shipping_cost]')) ? $this->input->post('currencies['.$currency['id'].'][additional_shipping_cost]') : $additional_shipping_cost; ?>" class="form-control">
                                        <?php echo form_error('currencies['.$currency['id'].'][additional_shipping_cost]'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</form>