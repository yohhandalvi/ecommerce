<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <span class="breadcrumb-item active">Wishlist</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Overview</h2>
<div class="content-heading">
    In Wishlist (<?php echo $count; ?>)
</div>
<div class="block block-rounded">
    <div class="block-content bg-body-light">
        <form id="filter-form">
            <input type="hidden" id="sort" name="sort" value="<?php echo ($this->input->get('sort')) ? $this->input->get('sort') : "id=desc"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Product</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="product_id" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($products as $key => $product) { ?>
                                        <option value="<?php echo $product['id']; ?>" <?php echo ($this->input->get('product_id') == $product['id']) ? "selected" : ""; ?>><?php echo $product['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="row">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-alt-primary btn-block mb-4">
                                Check
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo site_url('admin/wishlist'); ?>" class="btn btn-alt-danger btn-block mb-4">
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="block-content">
    	<div class="table-responsive">
	        <table class="table table-striped table-vcenter">
	            <thead>
	            	<tr class="border-double">
                        <th width="25%">#</th>
                        <th width="25%">Name</th>
                        <th width="25%">Email</th>
	                    <th width="25%">Mobile</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(!empty($customers)) { ?>
	                    <?php foreach($customers as  $customer) { ?>
	                        <tr>
	                            <th scope="row"><?php echo $customer['id']; ?></th>
                                <td><?php echo $customer['full_name']; ?></td>
                                <td><?php echo $customer['email']; ?></td>
	                            <td><?php echo ($customer['mobile']) ? $customer['mobile'] : '-'; ?></td>
	                        </tr>
	                    <?php } ?>
	                <?php } else { ?>
	                    <tr>
	                        <td colspan="4">No customers added this to wishlist yet</td>
	                    </tr>
	                <?php } ?>
	            </tbody>
	        </table>
	    </div>
    </div>
	<?php if($pagination) { ?>
	    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
	        <?php echo $pagination; ?>
	    </div>
	<?php } ?>
</div>