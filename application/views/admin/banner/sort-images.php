<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b mb-4">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('banner/listing'); ?>">Banners</a>
            <a class="breadcrumb-item" href="<?php echo site_url('banner/images/'.$banner['id']); ?>">Banner Images</a>
            <span class="breadcrumb-item active">Sort</span>
        </nav>
    </div>
</div>
<ul class="list-group" id="sortable">
    <?php if(!empty($banner_images)) { ?>
        <?php foreach($banner_images as $banner_image) { ?>
            <li id="data_<?php echo $banner_image['id'] ?>" class="list-group-item ui-state-default">
                <span class="fa fa-sort"></span><img width="75px" src="<?php echo base_url('uploads/banners/images/'.$banner_image['image']); ?>">
            </li>
        <?php } ?>
    <?php } ?>
</ul>
<input type="hidden" id="data-url" value="<?php echo site_url('sort?table=banner_images'); ?>">