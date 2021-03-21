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
                <a href="<?php echo site_url('product/edit/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Info</h5>
                    </div>
                    <p class="mb-1">Basic details of the item / product.</p>
                </a>
                <a href="<?php echo site_url('product/pricing/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
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
                    <div class="block block-rounded block-themed">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title">Basic Info</h3>
                            <div class="block-options">
                                <button type="submit" class="btn btn-sm btn-alt-primary">
                                    <i class="fa fa-save mr-5"></i>Save
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Name" value="<?php echo ($this->input->post('name')) ? $this->input->post('name') : $product['name']; ?>" class="form-control">
                                    <?php echo form_error('name'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-control js-select2" name="category_id" style="width: 100%;" data-placeholder="-- Choose --">
                                        <option value="">-- Choose --</option>
                                        <?php foreach ($categories as $key => $category) { ?>
                                            <option value="<?php echo $category['id']; ?>" <?php echo ($this->input->post('category_id') == $category['id'] || $product['category_id'] == $category['id']) ? "selected" : ""; ?>><?php echo ($category['parent']) ? "--  " : ""; ?><?php echo $category['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('category_id'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">SKU <span class="text-danger">*</span></label>
                                    <input type="text" name="sku" placeholder="SKU" value="<?php echo ($this->input->post('sku')) ? $this->input->post('sku') : $product['sku']; ?>" class="form-control">
                                    <?php echo form_error('sku'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control ckeditor" name="description" placeholder="Main Description" rows="8"><?php echo ($this->input->post('description')) ? $this->input->post('description') : $product['description']; ?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Specification</label>
                                    <textarea class="form-control ckeditor" name="specification" placeholder="Specification" rows="8"><?php echo ($this->input->post('specification')) ? $this->input->post('specification') : $product['specification']; ?></textarea>
                                    <?php echo form_error('specification'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block block-rounded block-themed">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title">Listing</h3>
                            <div class="block-options">
                                <button type="submit" class="btn btn-sm btn-alt-primary">
                                    <i class="fa fa-save mr-5"></i>Save
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="form-group row">
                                <label class="col-12">Featured</label>
                                <div class="col-12">
                                    <label class="css-control css-control-primary css-radio">
                                        <input type="radio" class="css-control-input" id="product-featured" name="featured" value="1" <?php echo ($this->input->post('featured') == "1" || $product['featured'] == "1") ? "checked" : ""; ?>>
                                        <span class="css-control-indicator"></span> Yes
                                    </label>
                                    <label class="css-control css-control-secondary css-radio">
                                        <input type="radio" class="css-control-input" id="product-not-featured" name="featured" value="1" <?php echo ($this->input->post('featured') == "0" || $product['featured'] == "0") ? "checked" : ""; ?>>
                                        <span class="css-control-indicator"></span> No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block block-rounded block-themed">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title">Meta Data</h3>
                            <div class="block-options">
                                <button type="submit" class="btn btn-sm btn-alt-primary">
                                    <i class="fa fa-save mr-5"></i>Save
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <label class="col-12" for="ecom-product-meta-title">Title</label>
                                <div class="col-12">
                                    <input type="text" class="js-maxlength form-control" name="meta_title" maxlength="50" data-always-show="true" data-placement="top" placeholder="Meta Title" value="<?php echo ($this->input->post('meta_title')) ? $this->input->post('meta_title') : $product['meta_title']; ?>">
                                    <div class="form-text text-muted font-size-sm">50 Characters Max</div>
                                    <?php echo form_error('meta_title'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="ecom-product-meta-tags">Tags</label>
                                <div class="col-12">
                                    <input type="text" class="js-tags-input form-control" data-height="34px" name="meta_tags" placeholder="Meta Tags" value="<?php echo ($this->input->post('meta_tags')) ? $this->input->post('meta_tags') : $product['meta_tags']; ?>">
                                    <?php echo form_error('meta_tags'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="ecom-product-meta-description">Description</label>
                                <div class="col-12">
                                    <textarea class="js-maxlength form-control" name="meta_description" maxlength="150" data-always-show="true" data-placement="top" placeholder="Meta Description" rows="2"><?php echo ($this->input->post('meta_description')) ? $this->input->post('meta_description') : $product['meta_description']; ?></textarea>
                                    <div class="form-text text-muted font-size-sm">150 Characters Max</div>
                                    <?php echo form_error('meta_description'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block block-rounded block-themed">
                        <div class="block-header bg-gd-primary">
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
			                            <input type="radio" class="css-control-input" id="product-active" name="inactive" value="0" <?php echo ($this->input->post('inactive') == "0" || $product['inactive'] == "0") ? "checked" : ""; ?>>
			                            <span class="css-control-indicator"></span> Yes
			                        </label>
			                        <label class="css-control css-control-secondary css-radio">
			                            <input type="radio" class="css-control-input" id="product-inactive" name="inactive" value="1" <?php echo ($this->input->post('inactive') == "1" || $product['inactive'] == "1") ? "checked" : ""; ?>>
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