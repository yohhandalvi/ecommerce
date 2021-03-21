<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('cashback/listing'); ?>">Cashbacks</a>
            <span class="breadcrumb-item active">For</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Cashback</h2> 
<div class="row gutters-tiny">
    <div class="col-md-6 col-xl-6">
        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('cashback/wallet'); ?>">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-archive fa-2x text-success-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-success">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Wallet</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-6">
        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('cashback/add'); ?>">
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Product</div>
                </div>
            </div>
        </a>
    </div>
</div>