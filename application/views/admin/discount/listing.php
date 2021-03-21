<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <span class="breadcrumb-item active">Discounts</span>
        </nav>
    </div>
</div>
<h2 class="content-heading">Overview</h2>
<div class="row gutters-tiny">
    <div class="col-md-6 col-xl-6">
        <a class="block block-rounded block-link-shadow">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-circle-o fa-2x text-info-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="<?php echo $total; ?>">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Discounts</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-6">
        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('discount/add'); ?>">
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">New Discount</div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="content-heading">
    Discounts (<?php echo $count; ?>)
</div>
<div class="block block-rounded">
    <div class="block-content bg-body-light">
        <form id="filter-form">
            <input type="hidden" id="sort" name="sort" value="<?php echo ($this->input->get('sort')) ? $this->input->get('sort') : "id=desc"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Search</label>
                        <input type="text" class="form-control" name="search" value="<?php echo $this->input->get('search'); ?>" placeholder="Search discounts by ID, name, code...">
                    </div>
                    <hr class="row">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-alt-primary btn-block mb-4">
                                Search
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo site_url('discount/listing'); ?>" class="btn btn-alt-danger btn-block mb-4">
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="block-content">
    	<div class="table-responsive">
	        <table class="table table-striped table-vcenter">
	            <thead>
	            	<tr class="border-double">
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "id=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "id=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "id=asc") ? "id=desc" : "id=asc"; ?>">#&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "name=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "name=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "name=asc") ? "name=desc" : "name=asc"; ?>">Name&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "code=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "code=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
                        <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "code=asc") ? "code=desc" : "code=asc"; ?>">Code&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "valid_from_date=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "valid_from_date=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
                        <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "valid_from_date=asc") ? "valid_from_date=desc" : "valid_from_date=asc"; ?>">Valid From&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "valid_to_date=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "valid_to_date=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
                        <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "valid_to_date=asc") ? "valid_to_date=desc" : "valid_to_date=asc"; ?>">Valid To&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(!empty($discounts)) { ?>
	                    <?php foreach($discounts as  $discount) { ?>
	                        <tr>
	                            <th scope="row"><?php echo $discount['id']; ?></th>
                                <td><?php echo $discount['name']; ?></td>
	                            <td><?php echo $discount['code']; ?></td>
                                <td><?php echo convert_db_time($discount['valid_from_date'], "d/m/Y") ?></td>
                                <td <?php echo time() > strtotime($discount['valid_to_date']) ? 'class="text-danger"' : '' ?>><?php echo convert_db_time($discount['valid_to_date'], "d/m/Y") ?></td>
	                            <td class="text-center">
	                                <a class="btn btn-lg btn-circle btn-alt-primary mr-5 mb-5" href="<?php echo site_url('discount/edit/'.$discount['id']); ?>">
	                                    <i class="fa fa-pencil"></i>
	                                </a>
	                                <a class="btn btn-lg btn-circle btn-alt-danger mr-5 mb-5 delete-confirm" href="<?php echo site_url('discount/delete/'.$discount['id']); ?>">
	                                    <i class="fa fa-trash"></i>
	                                </a>
	                            </td>
	                        </tr>
	                    <?php } ?>
	                <?php } else { ?>
	                    <tr>
	                        <td colspan="6">No discounts added yet</td>
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