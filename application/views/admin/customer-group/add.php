<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('customer-group/listing'); ?>">Customer Groups</a>
            <span class="breadcrumb-item active">Add</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Customer Group - Add</h2>
<form method="post">
	<div class="row gutters-tiny">
	    <div class="col-md-12">
            <div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Basic Info</h3>
                    <div class="block-options">
                        <button type="submit" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-save mr-5"></i>Add
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
		            <div class="form-group row">
		            	<div class="col-md-12">
							<label class="form-control-label">Name <span class="text-danger">*</span></label>
							<input type="text" name="name" placeholder="Name" value="<?php echo $this->input->post('name') ?>" class="form-control">
							<?php echo form_error('name'); ?>
			            </div>
		            </div>
                </div>
            </div>
	    </div>
	</div>
</form>