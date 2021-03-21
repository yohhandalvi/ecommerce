<?php $this->load->view('admin/layout/alert'); ?>
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a>
            <span class="breadcrumb-item active">Orders</span>
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
                    <div class="font-size-sm font-w600 text-uppercase text-muted">All Orders</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-6">
        <a class="block block-rounded block-link-shadow">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-warning fa-2x text-danger-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo" data-to="<?php echo $pending; ?>">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Pending</div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="content-heading">
    Orders (<?php echo $count; ?>)
</div>
<div class="block block-rounded">
    <div class="block-content bg-body-light">
        <form id="filter-form">
            <input type="hidden" id="sort" name="sort" value="<?php echo ($this->input->get('sort')) ? $this->input->get('sort') : "id=desc"; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Search</label>
                        <input type="text" class="form-control" name="search" value="<?php echo $this->input->get('search'); ?>" placeholder="Search orders by ID, Order ID, customer name, mobile...">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label">Status</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="status" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($order_statuses as $key => $status) { ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($this->input->get('status') == $key) ? "selected" : ""; ?>><?php echo $status; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label">Payment</label>
                            <div class="form-group">
                                <select class="form-control js-select2" name="payment" style="width: 100%;">
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($order_payments as $key => $payment) { ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($this->input->get('payment') == $key) ? "selected" : ""; ?>><?php echo $payment; ?></option>
                                    <?php } ?>
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
                            <a href="<?php echo site_url('order/listing'); ?>" class="btn btn-alt-danger btn-block mb-4">
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
                            if($this->input->get('sort') == "order_id=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "order_id=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
                        <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "order_id=asc") ? "order_id=desc" : "order_id=asc"; ?>">Order ID&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "full_name=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "full_name=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "c.full_name=asc") ? "c.full_name=desc" : "c.full_name=asc"; ?>">Name&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "c.mobile=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "c.mobile=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "c.mobile=asc") ? "c.mobile=desc" : "c.mobile=asc"; ?>">Mobile&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "total=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "total=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "total=asc") ? "total=desc" : "total=asc"; ?>">Total&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "status=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "status=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "status=asc") ? "status=desc" : "status=asc"; ?>">Status&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "payment=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "payment=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "payment=asc") ? "payment=desc" : "payment=asc"; ?>">Payment&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
                        <?php 
                            $sort_icon = "fa-unsorted";
                            if($this->input->get('sort') == "created_on=asc")
                                $sort_icon = "fa-sort-asc";
                            else if($this->input->get('sort') == "created_on=desc")
                                $sort_icon = "fa-sort-desc";
                        ?>
	                    <th class="sort" data-sort="<?php echo ($this->input->get('sort') == "created_on=asc") ? "created_on=desc" : "created_on=asc"; ?>">Placed On&nbsp;&nbsp;<i class="fa <?php echo $sort_icon; ?>"></i></th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php if(!empty($orders)) { ?>
	                    <?php foreach($orders as  $order) { ?>
	                        <tr>
	                    		<th class="text-center" scope="row"><?php echo $order['id']; ?></th>
	                            <td>#<?php echo $order['order_id']; ?></td> 
                                <td><?php echo $order['customer_full_name']; ?></td>
	                            <td><?php echo ($order['customer_mobile']) ? $order['customer_mobile'] : "-"; ?></td>
                                <td><?php echo show_price($order['total'], $order['currency']); ?></td>
                                <td><?php echo get_order_status_text($order['status']); ?></td>
	                            <td><?php echo get_order_payment_text($order['payment']); ?></td>
	                            <td><?php echo convert_db_time($order['created_on'], "d/m/Y H:i"); ?></td>
	                            <td class="text-center">
	                                <a class="btn btn-lg btn-circle btn-alt-primary mr-5 mb-5" href="<?php echo site_url('order/view/'.$order['id']); ?>">
	                                    <i class="fa fa-eye"></i>
	                                </a>
	                            </td>
	                        </tr>
	                    <?php } ?>
	                <?php } else { ?>
	                    <tr>
	                        <td colspan="9">No orders placed yet</td>
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