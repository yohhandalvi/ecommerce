<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <a class="breadcrumb-item" href="<?php echo site_url('banner/listing'); ?>">Banners</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Banner - Edit</h2>
<form method="post" enctype="multipart/form-data">
	<div class="row gutters-tiny">
		<div class="col-md-12">
			<div class="block block-rounded block-themed">
                <div class="block-header bg-gd-primary">
                    <h3 class="block-title">Status</h3>
                    <div class="block-options">
                        <button type="submit" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-save mr-5"></i>Save
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="form-group row">
                        <label class="col-12">Active</label>
                        <div class="col-12">
                            <label class="css-control css-control-primary css-radio">
	                            <input type="radio" class="css-control-input" id="banner-active" name="inactive" value="0" <?php echo ($this->input->post('inactive') == "0" || $banner['inactive'] == "0") ? "checked" : ""; ?>>
	                            <span class="css-control-indicator"></span> Yes
	                        </label>
	                        <label class="css-control css-control-secondary css-radio">
	                            <input type="radio" class="css-control-input" id="banner-inactive" name="inactive" value="1" <?php echo ($this->input->post('inactive') == "1" || $banner['inactive'] == "1") ? "checked" : ""; ?>>
	                            <span class="css-control-indicator"></span> No
	                        </label>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</form>