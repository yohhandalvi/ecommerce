<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <span class="breadcrumb-item active">Customers</span>
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Customers</div>
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Inactive</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-shadow" href="<?php echo site_url('customer/add'); ?>">
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">New Customer</div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="content-heading">
    Customers (<?php echo $count; ?>)
</div>
<div class="block block-rounded">
    <div class="block-content bg-body-light">
        <form id="filter-form">
            <input type="hidden" id="sort" name="sort" value="<?php echo ($this->input->get('sort')) ? $this->input->get('sort') : "id=desc"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Search</label>
                        <input type="text" class="form-control" name="search" value="<?php echo $this->input->get('search'); ?>" placeholder="Search customers by ID, name, email, mobile...">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Group</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="customer_group_id" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($customer_groups as $key => $customer_group) { ?>
                                        <option value="<?php echo $customer_group['id']; ?>" <?php echo ($this->input->get('customer_group_id') == $customer_group['id']) ? "selected" : ""; ?>><?php echo $customer_group['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Status</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="inactive" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <option value="0" <?php echo (is_numeric($this->input->get('inactive')) && $this->input->get('inactive') == 0) ? "selected" : ""; ?>>Active</option>
                                    <option value="1" <?php echo ($this->input->get('inactive') == 1) ? "selected" : ""; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
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
                            <a href="<?php echo site_url('customer/listing'); ?>" class="btn btn-alt-danger btn-block mb-4">
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
                            if($this->input->get('sort') == "full_name=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "full_name=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "full_name=asc") ? "full_name=desc" : "full_name=asc"; ?>">Name&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "email=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "email=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "email=asc") ? "email=desc" : "email=asc"; ?>">Email&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "mobile=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "mobile=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "mobile=asc") ? "mobile=desc" : "mobile=asc"; ?>">Mobile&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "cg.name=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "cg.name=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "cg.name=asc") ? "cg.name=desc" : "cg.name=asc"; ?>">Group&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "inactive=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "inactive=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "wallet=asc") ? "wallet=desc" : "wallet=asc"; ?>">Status&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>

                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "wallet=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "wallet=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
                        <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "inactive=asc") ? "inactive=desc" : "inactive=asc"; ?>">wallet&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>

                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "created_on=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "created_on=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "created_on=asc") ? "created_on=desc" : "created_on=asc"; ?>">Registered On&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(!empty($customers)) { ?>
	                    <?php foreach($customers as  $customer) { ?>
	                        <tr>
	                    		<th class="text-center" scope="row"><?php echo $customer['id']; ?></th>
	                            <td><?php echo $customer['full_name']; ?></td>
	                            <td><?php echo $customer['email']; ?></td>
	                            <td><?php echo ($customer['mobile']) ? $customer['mobile'] : "-"; ?></td>
	                            <td><?php echo $customer['group']; ?></td>
	                            <td>
	                            	<?php if($customer['inactive']) { ?>
	                            		<span class="badge badge-danger">Inactive</span>
	                            	<?php } else { ?>
	                            		<span class="badge badge-success">Active</span>
	                            	<?php } ?>
                            	</td>
                                <td><?php echo show_price($customer['wallet']); ?></td>
	                            <td><?php echo convert_db_time($customer['created_on'], "d/m/Y H:i"); ?></td>
	                            <td class="text-center">
	                                <a class="btn btn-lg btn-circle btn-alt-primary mr-5 mb-5" href="<?php echo site_url('customer/view/'.$customer['id']); ?>">
	                                    <i class="fa fa-user"></i>
	                                </a>
	                                <a class="btn btn-lg btn-circle btn-alt-danger mr-5 mb-5 delete-confirm" href="<?php echo site_url('customer/delete/'.$customer['id']); ?>">
	                                    <i class="fa fa-trash"></i>
	                                </a>
	                            </td>

	                        </tr>
	                    <?php } ?>
	                <?php } else { ?>
	                    <tr>
	                        <td colspan="8">No customers added / registered yet</td>
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