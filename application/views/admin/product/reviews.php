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
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
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
			            <div class="block-content block-content-full">
					    	<div class="table-responsive">
						        <table class="table table-striped table-vcenter">
						            <thead>
						            	<tr class="border-double">
						                    <th>#</th>
						                    <th>Customer</th>
						                    <th>Rating</th>
						                    <th>Message</th>
						                    <th>Anonymous?</th>
						                    <th>Posted On</th>
						                    <th>Status</th>
						                </tr>
						            </thead>
						            <tbody>
						            	<?php if(!empty($product_reviews)) { ?>
						                    <?php foreach($product_reviews as  $product_review) { ?>
						                        <tr>
						                    		<th class="text-center" scope="row"><?php echo $product_review['customer_id']; ?></th>
						                            <td><a href="<?php echo site_url('customer/view/'.$product_review['customer_id']); ?>"><?php echo $product_review['customer']; ?></a></td>
						                            <td><?php echo $product_review['rating']; ?></td>
						                            <td><?php echo $product_review['review']; ?></td>
						                            <td>
						                            	<?php if($product_review['anonymous']) { ?>
					                                        <span class="badge badge-success">Yes</span>
					                                    <?php } else { ?>
					                                        <span class="badge badge-danger">No</span>
					                                    <?php } ?>
						                            </td>
						                            <td><?php echo convert_db_time($product_review['created_on'], "d/m/Y H:i"); ?></td>
						                            <td>
						                            	<?php if($product_review['inactive']) { ?>
					                                        <span class="badge badge-danger">Hidden</span>
					                                    <?php } else { ?>
					                                        <span class="badge badge-success">Visible</span>
					                                    <?php } ?>
						                            </td>
						                        </tr>
						                    <?php } ?>
						                <?php } else { ?>
						                    <tr>
						                        <td colspan="7">No reviews posted yet</td>
						                    </tr>
						                <?php } ?>
						            </tbody>
						        </table>
						    </div>
					    </div>
				    </div>
			    </div>
			</div>
		</div>
	</div>
</form>