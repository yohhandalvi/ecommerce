<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <span class="breadcrumb-item active">Reviews</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Overview</h2>
<div class="row gutters-tiny">
    <div class="col-md-6 col-xl-6">
        <a class="block block-rounded block-link-shadow">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-circle-o fa-2x text-info-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="<?php echo $total; ?>">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Reviews</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-6">
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
</div>
<div class="content-heading">
    Reviews (<?php echo $count; ?>)
</div>
<div class="block block-rounded">
    <div class="block-content bg-body-light">
        <form id="filter-form">
            <input type="hidden" id="sort" name="sort" value="<?php echo ($this->input->get('sort')) ? $this->input->get('sort') : "id=desc"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Search</label>
                        <input type="text" class="form-control" name="search" value="<?php echo $this->input->get('search'); ?>" placeholder="Search reviews by ID, product, customer, rating...">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Rating</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="rating" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($ratings as $key => $rating) { ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($this->input->get('rating') == $key) ? "selected" : ""; ?>><?php echo $rating; ?></option>
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
                            <a href="<?php echo site_url('products/reviews'); ?>" class="btn btn-alt-danger btn-block mb-4">
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
                            if($this->input->get('sort') == "p.name=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "p.name=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "p.name=asc") ? "p.name=desc" : "p.name=asc"; ?>">Product&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "c.full_name=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "c.full_name=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "c.full_name=asc") ? "c.full_name=desc" : "c.full_name=asc"; ?>">Customer&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "rating=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "rating=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "rating=asc") ? "rating=desc" : "rating=asc"; ?>">Rating&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "review=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "review=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "review=asc") ? "review=desc" : "review=asc"; ?>">Review&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "anonymous=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "anonymous=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "anonymous=asc") ? "anonymous=desc" : "anonymous=asc"; ?>">Anonymous&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "inactive=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "inactive=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
                        <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "inactive=asc") ? "inactive=desc" : "inactive=asc"; ?>">Status&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "created_on=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "created_on=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "created_on=asc") ? "created_on=desc" : "created_on=asc"; ?>">Posted On&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(!empty($product_reviews)) { ?>
	                    <?php foreach($product_reviews as  $product_review) { ?>
	                        <tr>
	                    		<th class="text-center" scope="row"><?php echo $product_review['id']; ?></th>
                                <td><a href="<?php echo site_url('product/edit/'.$product_review['product_id']); ?>"><?php echo $product_review['product']; ?></a></td>
                                <td><a href="<?php echo site_url('customer/view/'.$product_review['customer_id']); ?>"><?php echo $product_review['customer']; ?></a></td>
                                <td><?php echo $product_review['rating']; ?></td>
                                <td><?php echo $product_review['review']; ?></td>
                                <td>
                                    <?php if($product_review['anonymous']) { ?>
                                        <span class="badge badge-danger">Yes</span>
                                    <?php } else { ?>
                                        <span class="badge badge-success">No</span>
                                    <?php } ?>
                                </td>
	                            <td>
	                            	<?php if($product_review['inactive']) { ?>
	                            		<span class="badge badge-danger">Inactive</span>
	                            	<?php } else { ?>
	                            		<span class="badge badge-success">Active</span>
	                            	<?php } ?>
                            	</td>
	                            <td><?php echo convert_db_time($product_review['created_on'], "d/m/Y H:i"); ?></td>
	                            <td class="text-center">
	                                <a class="btn btn-lg btn-circle btn-alt-primary mr-5 mb-5" href="<?php echo site_url('product/change-review-status/'.$product_review['id']); ?>">
	                                    <i class="fa fa-user"></i>
	                                </a>
	                                <a class="btn btn-lg btn-circle btn-alt-danger mr-5 mb-5 delete-confirm" href="<?php echo site_url('product/delete-review/'.$product_review['id']); ?>">
	                                    <i class="fa fa-trash"></i>
	                                </a>
	                            </td>
	                        </tr>
	                    <?php } ?>
	                <?php } else { ?>
	                    <tr>
	                        <td colspan="9">No reviews added yet</td>
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