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
            <a href="<?php echo site_url('product/images/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Images</h5>
                </div>
                <p class="mb-1">Upload images for the product.</p>
            </a>
            <a href="<?php echo site_url('product/stock/'.$product['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start active">
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
                        <h3 class="block-title">Total Stock</h3>
                    </div>
                    <div class="block-content block-content-full p-3">
                        <h3 class="font-w300 mb-0 <?php echo ($total_stock > 0) ? 'text-success' : 'text-danger'; ?>"><?php echo $total_stock; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gutters-tiny">
            <div class="col-md-12">
                <div class="block block-rounded block-themed">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title">Manage Stock</h3>
                    </div>
                    <div class="block-content block-content-full p-3">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Quantity / Stock <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="quantity" value="<?php echo $this->input->post('quantity'); ?>" placeholder="Enter the quantity for the product stock">
                                        <?php echo form_error('quantity'); ?>
                                    </div>
                                    <hr class="row">
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-alt-success btn-block">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gutters-tiny">
            <div class="col-md-12">
                <div class="block block-rounded block-themed">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title">Stock History</h3>
                    </div>
                    <div class="block-content block-content-full p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-vcenter mb-0">
                                <thead>
                                    <tr class="border-double">
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Added On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($product_stock)) { ?>
                                        <?php foreach($product_stock as  $ps) { ?>
                                            <tr class="table-<?php echo ($ps['quantity'] > 0) ? 'success' : 'danger'; ?>">
                                                <td class="text-center"><?php echo $ps['quantity']; ?></td>
                                                <td class="text-center"><?php echo convert_db_time($ps['created_on'], "d/m/Y H:i:s"); ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="2">Product stock hasn't been updated yet</td>
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