<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <a href="<?php echo site_url('checkout'); ?>">Checkout</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Order Error</strong></div>
        </div>
    </div>
</div>
<div class="site-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<span class="icon-times-circle display-3 text-danger"></span>
				<h2 class="display-3 text-black">Error!</h2>
				<p class="lead mb-5"><?php echo ($this->session->flashdata('error_message')) ? $this->session->flashdata('error_message') : 'Order was not placed with us, please contact the admin or try again!'; ?></p>
			</div>
		</div>
	</div>
</div>