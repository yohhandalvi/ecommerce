<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('banner/listing'); ?>">Banners</a>
            <a class="breadcrumb-item" href="<?php echo site_url('banner/images/'.$banner['id']); ?>">Banner Images</a>
            <span class="breadcrumb-item active">Add</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Banner Image - Add</h2>
<form method="post" enctype="multipart/form-data">
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
	                	<div class="col-md-5">
						    <div class="form-group">
						        <label class="form-control-label">Product</label>
						        <select name="product_id" class="form-control js-select2">
						        	<option value="0">-- Choose --</option>
						        	<?php foreach ($products as $key => $product) { ?>
							        	<option value="<?php echo $product['id']; ?>" <?php echo ($this->input->post('product_id') == $product['id']) ? "selected" : ""; ?>><?php echo $product['name']; ?></option>
							        <?php } ?>
						        </select>
						        <?php echo form_error('product_id'); ?>
						    </div>
					    </div>
					    <div class="col-md-2">
					    	<label class="form-control-label">&nbsp;</label>
					    	<br clear="all">
					    	<div class="text-center">- OR -</div>
					    </div>
					    <div class="col-md-5">
						    <div class="form-group">
						        <label class="form-control-label">Category</label>
						        <select name="category_id" class="form-control js-select2">
						        	<option value="0">-- Choose --</option>
						        	<?php foreach ($categories as $key => $category) { ?>
							        	<option value="<?php echo $category['id']; ?>" <?php echo ($this->input->post('category_id') == $category['id']) ? "selected" : ""; ?>><?php echo $category['name']; ?></option>
							        <?php } ?>
						        </select>
						        <?php echo form_error('category_id'); ?>
						    </div>
					    </div>
				    </div>
				    <hr>
				    <div class="form-group">
				        <label class="form-control-label">Image <span class="text-danger">*</span></label>
				        <br clear="all">
				        <input type="file" name="image">
				        <?php echo form_error('image'); ?>
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
	                            <input type="radio" class="css-control-input" id="banner-active" name="inactive" value="0" <?php echo ($this->input->post('inactive') == "0") ? "checked" : ""; ?>>
	                            <span class="css-control-indicator"></span> Yes
	                        </label>
	                        <label class="css-control css-control-secondary css-radio">
	                            <input type="radio" class="css-control-input" id="banner-inactive" name="inactive" value="1" <?php echo ($this->input->post('inactive') == "1") ? "checked" : ""; ?>>
	                            <span class="css-control-indicator"></span> No
	                        </label>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</form>