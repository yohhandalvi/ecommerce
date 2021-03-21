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
<h2 class="content-heading">Product - Images</h2>
<div class="row gutters-tiny">
    <div class="col-md-4">
        <div class="list-group">
            <a href="<?php echo site_url('product/edit/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Info</h5>
                </div>
                <p class="mb-1">Basic details of the item / product.</p>
            </a>
            <a href="<?php echo site_url('product/images/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
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
                        <h3 class="block-title">Upload</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <form id="dropzone" action="<?php echo site_url('upload/product/'.$product['id']); ?>"></form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gutters-tiny">
            <div class="col-md-12">
                <div class="block block-rounded block-themed">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title">Images</h3>
                    </div>
                    <div class="block-content block-content-full p-1">
                        <div class="gutters-tiny items-push">
                            <div class="js-draggable-items mb-0">
                                <div class="draggable-column">
                                    <?php if(!empty($product_images)) { ?>
                                        <?php foreach($product_images as $product_image) { ?>
                                            <div class="block draggable-item mb-1" id="data-<?php echo $product_image['id']; ?>">
                                                <div class="col-md-12 p-10 border">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <a class="btn btn-sm btn-rounded btn-alt-primary draggable-handler" href="javascript:void(0)">
                                                                <i class="si si-cursor-move"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-rounded btn-alt-secondary" href="<?php echo site_url('image/crop?back='.site_url('product/images/'.$product_image['product_id']).'&image='.show_image(base_url('uploads/products/images/'.$product_image['image']), ['thumbnail' => '500_500'])); ?>">
                                                                <i class="si si-crop"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-rounded btn-alt-danger delete-confirm" href="<?php echo site_url('upload/delete?id='.$product_image['id'].'&table=product_images&folder=uploads/products/images'); ?>">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <img class="img-fluid options-item" width="400" src="<?php echo show_image(base_url('uploads/products/images/'.$product_image['image']), ['thumbnail' => '500_500']); ?>" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        var dropzone = new Dropzone("#dropzone");

        $("#dropzone").addClass("dropzone");

        dropzone.on("completemultiple", function(multiple){});

        $(".draggable-column").sortable({
            stop: function( ) {
                var order = $(".draggable-column").sortable("serialize", {key:'data[]'});
                $.ajax({
                    data: order,
                    dataType: "JSON",
                    type: "POST",
                    url: SITE_URL+"sort?table=product_images",
                    success: function(response) {}
                })
            }
        });
    });
</script>