<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b mb-4">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('product/listing'); ?>">Products</a>
            <span class="breadcrumb-item active">Sort</span>
        </nav>
    </div>
</div>
<ul class="list-group" id="sortable">
    <?php if(!empty($products)) { ?>
        <?php foreach($products as $product) { ?>
            <li id="data_<?php echo $product['id'] ?>" class="list-group-item ui-state-default">
                <span class="fa fa-sort"></span><?php echo $product['name']; ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul>
<input type="hidden" id="data-url" value="<?php echo site_url('sort?table=products'); ?>">