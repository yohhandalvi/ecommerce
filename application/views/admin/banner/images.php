<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('banner/listing'); ?>">Banners</a>
            <span class="breadcrumb-item active">Banner Images</span>
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Banner Images</div>
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Inactive Banner Images</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('banner/add-image/'.$banner['id']); ?>">
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Upload Image</div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="content-heading">
    <?php echo $banner['name']; ?> : Banner Images (<?php echo $count; ?>) <a class="btn btn-primary btn-rounded btn-sm float-right" href="<?php echo site_url('banner/sort-images/'.$banner['id']); ?>">Sort</a>
</div>
<div class="block block-rounded">
    <div class="block-content">
    	<div class="table-responsive">
	        <table class="table table-striped table-vcenter">
	            <thead>
	            	<tr class="border-double">
                        <th>Image</th>
                        <th>Linked To</th>
                        <th>Status</th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(!empty($banner_images)) { ?>
	                    <?php foreach($banner_images as  $banner_image) { ?>
	                        <tr>
	                            <th scope="row">
                                    <img class="img-fluid options-item" width="100" src="<?php echo show_image(base_url('uploads/banners/images/'.$banner_image['image']), ['thumbnail' => '1200_700']); ?>" alt="">
                                </th>
                                <td><?php echo $banner_image['linked']; ?></td>
                                <td>
                                    <?php if($banner_image['inactive']) { ?>
                                        <span class="badge badge-danger">Inactive</span>
                                    <?php } else { ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php } ?>
                                </td>
	                            <td class="text-center">
	                                <a class="btn btn-lg btn-circle btn-alt-primary mr-5 mb-5" href="<?php echo site_url('banner/edit-image/'.$banner_image['id']); ?>">
	                                    <i class="fa fa-pencil"></i>
	                                </a>
	                                <a class="btn btn-lg btn-circle btn-alt-danger mr-5 mb-5 delete-confirm" href="<?php echo site_url('banner/delete-image/'.$banner_image['id']); ?>">
	                                    <i class="fa fa-trash"></i>
	                                </a>
	                            </td>
	                        </tr>
	                    <?php } ?>
	                <?php } else { ?>
	                    <tr>
	                        <td colspan="3">No banner images added yet</td>
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