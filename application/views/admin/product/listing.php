<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
        	<a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <span class="breadcrumb-item active">Products</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Overview</h2>
<div class="row gutters-tiny">
    <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-shadow">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-circle-o fa-2x text-info-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="<?php echo $total; ?>">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Products</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-shadow">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-warning fa-2x text-danger-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo" data-to="<?php echo $inactive; ?>">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Inactive</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('product/add'); ?>">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-archive fa-2x text-success-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-success">
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">New Product</div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="content-heading">
    Products (<?php echo $count; ?>) <a class="btn btn-primary btn-rounded btn-sm float-right" href="<?php echo site_url('product/sort'); ?>">Sort</a>
</div>
<div class="block block-rounded">
    <div class="block-content bg-body-light">
        <form id="filter-form">
            <input type="hidden" id="sort" name="sort" value="<?php echo ($this->input->get('sort')) ? $this->input->get('sort') : "id=desc"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Search</label>
                        <input type="text" class="form-control" name="search" value="<?php echo $this->input->get('search'); ?>" placeholder="Search products by ID, name...">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Category</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="category_id" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($filter_categories as $key => $filter_category) { ?>
                                        <option value="<?php echo $filter_category['id']; ?>" <?php echo ($this->input->get('category_id') == $filter_category['id']) ? "selected" : ""; ?>><?php echo ($filter_category['parent']) ? "--  " : ""; ?><?php echo $filter_category['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Status</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="inactive" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <option value="0" <?php echo (is_numeric($this->input->get('inactive')) && $this->input->get('inactive') == 0) ? "selected" : ""; ?>>Active</option>
                                    <option value="1" <?php echo ($this->input->get('inactive') == 1) ? "selected" : ""; ?>>Inactive</option>
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
                                Search
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo site_url('product/listing'); ?>" class="btn btn-alt-danger btn-block mb-4">
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="block-content">
        <table class="table table-striped table-vcenter">
            <thead>
                <tr>
                    <?php 
                        $sort_icon = "fa-unsorted";
                        if($this->input->get('sort') == "id=asc")
                            $sort_icon = "fa-sort-asc";
                        else if($this->input->get('sort') == "id=desc")
                            $sort_icon = "fa-sort-desc";
                    ?>
                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "id=asc") ? "id=desc" : "id=asc"; ?>">#&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                    <?php 
                        $sort_icon = "fa-unsorted";
                        if($this->input->get('sort') == "name=asc")
                            $sort_icon = "fa-sort-asc";
                        else if($this->input->get('sort') == "name=desc")
                            $sort_icon = "fa-sort-desc";
                    ?>
                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "name=asc") ? "name=desc" : "name=asc"; ?>">Product&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                    <?php 
                        $sort_icon = "fa-unsorted";
                        if($this->input->get('sort') == "c.name=asc")
                            $sort_icon = "fa-sort-asc";
                        else if($this->input->get('sort') == "c.name=desc")
                            $sort_icon = "fa-sort-desc";
                    ?>
                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "c.name=asc") ? "c.name=desc" : "c.name=asc"; ?>">Category&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                    <?php 
                        $sort_icon = "fa-unsorted";
                        if($this->input->get('sort') == "inactive=asc")
                            $sort_icon = "fa-sort-asc";
                        else if($this->input->get('sort') == "inactive=desc")
                            $sort_icon = "fa-sort-desc";
                    ?>
                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "inactive=asc") ? "inactive=desc" : "inactive=asc"; ?>">Status&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                    <th>Stock</th>
                    <?php 
                        $sort_icon = "fa-unsorted";
                        if($this->input->get('sort') == "created_on=asc")
                            $sort_icon = "fa-sort-asc";
                        else if($this->input->get('sort') == "created_on=desc")
                            $sort_icon = "fa-sort-desc";
                    ?>
                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "created_on=asc") ? "created_on=desc" : "created_on=asc"; ?>">Added On&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            	<?php if(!empty($products)) { ?>
                    <?php foreach($products as  $product) { ?>
                        <tr>
                            <th scope="row"><?php echo $product['id']; ?></th>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['category']; ?></td>
                            <td>
                            	<?php if($product['inactive']) { ?>
                            		<span class="badge badge-danger">Inactive</span>
                            	<?php } else { ?>
                            		<span class="badge badge-success">Active</span>
                            	<?php } ?>
                        	</td>
                            <td>
                                <?php if($product['total_stock']) { ?>
                                    <span class="badge badge-success"><?php echo $product['total_stock']; ?></span>
                                <?php } else { ?>
                                    <span class="badge badge-danger"><?php echo $product['total_stock']; ?></span>
                                <?php } ?>
                            </td>
                            <td><?php echo convert_db_time($product['created_on'], "d/m/Y H:i"); ?></td>
                            <td class="text-center">
                                <a class="btn btn-lg btn-circle btn-alt-primary mr-5 mb-5" href="<?php echo site_url('product/edit/'.$product['id']); ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-lg btn-circle btn-alt-danger mr-5 mb-5 delete-confirm" href="<?php echo site_url('product/delete/'.$product['id']); ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">No products added yet</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    	<?php if($pagination) { ?>
    		<nav aria-label="Products navigation">
                <?php echo $pagination; ?>
            </nav>
        <?php } ?>
    </div>
</div>