<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <a href="<?php echo site_url('cart'); ?>">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
        </div>
    </div>
</div>
<?php if($cart['items']) { ?>
    <form method="post">
        <div class="site-section">
            <div class="container">
                <?php $this->load->view('front/layout/alert'); ?>
                <?php if(!$this->customer['id']) { ?>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="border p-4 rounded" role="alert">
                                Returning customer? <a href="<?php echo site_url('account'); ?>">Click here</a> to login
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <?php if(!$this->customer['id']) { ?>
                            <h2 class="h3 mb-3 text-black">Billing Details</h2>
                            <div class="p-3 p-lg-5 border">
                                <div class="form-group">
                                    <label class="text-black">Country <span class="text-danger">*</span></label>
                                    <select class="form-control" name="billing[country_id]">
                                        <option value="">-- Choose --</option>
                                        <?php foreach($countries as $country) { ?>
                                            <option value="<?php echo $country['id']; ?>" <?php echo ($this->input->post('billing[country_id]') == $country['id']) ? 'selected' : ''; ?>><?php echo $country['name']; ?></option>    
                                        <?php } ?>   
                                    </select>
                                    <?php echo form_error('billing[country_id]'); ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-black">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="first_name" value="<?php echo $this->input->post('first_name'); ?>">
                                        <?php echo form_error('first_name'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-black">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="last_name" value="<?php echo $this->input->post('last_name'); ?>">
                                        <?php echo form_error('last_name'); ?>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <div class="col-md-6">
                                        <label class="text-black">Email Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $this->input->post('email'); ?>">
                                        <?php echo form_error('email'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-black">Mobile</label>
                                        <input type="text" class="form-control" name="mobile" value="<?php echo $this->input->post('mobile'); ?>">
                                        <?php echo form_error('mobile'); ?>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-3">You will be signed up with this email account automatically and will receive the account login info via email.</p>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <select class="form-control" name="billing[name]">
                                            <option value="">-- Choose --</option>
                                            <option value="home" <?php echo ($this->input->post('billing[name]') == "home") ? "selected" : ""; ?>>Home</option>
                                            <option value="work" <?php echo ($this->input->post('billing[name]') == "work") ? "selected" : ""; ?>>Work</option>
                                            <option value="other" <?php echo ($this->input->post('billing[name]') == "other") ? "selected" : ""; ?>>Other</option>
                                        </select>
                                        <?php echo form_error('billing[name]'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="text-black">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="billing[address_line_1]" placeholder="Address line 1" value="<?php echo $this->input->post('billing[address_line_1]'); ?>">
                                        <?php echo form_error('billing[address_line_1]'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="billing[address_line_2]" placeholder="Address line 2"  value="<?php echo $this->input->post('billing[address_line_2]'); ?>">
                                    <?php echo form_error('billing[address_line_2]'); ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-black">Landmark </label>
                                        <input type="text" class="form-control" name="billing[landmark]" value="<?php echo $this->input->post('billing[landmark]'); ?>">
                                        <?php echo form_error('billing[landmark]'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-black">City <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="billing[city]" value="<?php echo $this->input->post('billing[city]'); ?>">
                                        <?php echo form_error('billing[city]'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="text-black">State <span class="text-danger">*</span></label>
                                        <select class="form-control" name="billing[state_id]">
                                            <option value="">-- Choose --</option>
                                            <?php foreach($states as $state) { ?>
                                                <option value="<?php echo $state['id']; ?>" <?php echo ($this->input->post('billing[state_id]') == $state['id']) ? 'selected' : ''; ?>><?php echo $state['name']; ?></option>    
                                            <?php } ?>   
                                        </select>
                                        <?php echo form_error('billing[state_id]'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-black">Pin Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="billing[pin_code]" value="<?php echo $this->input->post('billing[pin_code]'); ?>">
                                        <?php echo form_error('billing[pin_code]'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="c_ship_different_address" class="text-black" data-toggle="collapse" href="#ship_different_address" role="button" aria-expanded="false" aria-controls="ship_different_address"><input type="checkbox" value="1" name="different_shipping" <?php echo ($this->input->post('different_shipping')) ? 'checked' : ''; ?>>&nbsp;&nbsp;Ship to a different address?</label>
                                    <div class="collapse <?php echo ($this->input->post('different_shipping')) ? 'show' : ''; ?>" id="ship_different_address">
                                        <div class="py-2">
                                            <div class="form-group">
                                                <label class="text-black">Country <span class="text-danger">*</span></label>
                                                <select class="form-control" name="shipping[country_id]">
                                                    <option value="">-- Choose --</option>
                                                    <?php foreach($countries as $country) { ?>
                                                        <option value="<?php echo $country['id']; ?>" <?php echo ($this->input->post('shipping[country_id]') == $country['id']) ? 'selected' : ''; ?>><?php echo $country['name']; ?></option>    
                                                    <?php } ?>   
                                                </select>
                                                <?php echo form_error('shipping[country_id]'); ?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <select class="form-control" name="shipping[name]">
                                                        <option value="">-- Choose --</option>
                                                        <option value="home" <?php echo ($this->input->post('shipping[name]') == "home") ? "selected" : ""; ?>>Home</option>
                                                        <option value="work" <?php echo ($this->input->post('shipping[name]') == "work") ? "selected" : ""; ?>>Work</option>
                                                        <option value="other" <?php echo ($this->input->post('shipping[name]') == "other") ? "selected" : ""; ?>>Other</option>
                                                    </select>
                                                    <?php echo form_error('shipping[name]'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label class="text-black">Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="shipping[address_line_1]" placeholder="Address line 1" value="<?php echo $this->input->post('shipping[address_line_1]'); ?>">
                                                    <?php echo form_error('shipping[address_line_1]'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="shipping[address_line_2]" placeholder="Address line 2"  value="<?php echo $this->input->post('shipping[address_line_2]'); ?>">
                                                <?php echo form_error('shipping[address_line_2]'); ?>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label class="text-black">Landmark </label>
                                                    <input type="text" class="form-control" name="shipping[landmark]" value="<?php echo $this->input->post('shipping[landmark]'); ?>">
                                                    <?php echo form_error('shipping[landmark]'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-black">City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="shipping[city]" value="<?php echo $this->input->post('shipping[city]'); ?>">
                                                    <?php echo form_error('shipping[city]'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label class="text-black">State <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="shipping[state_id]">
                                                        <option value="">-- Choose --</option>
                                                        <?php foreach($states as $state) { ?>
                                                            <option value="<?php echo $state['id']; ?>" <?php echo ($this->input->post('shipping[state_id]') == $state['id']) ? 'selected' : ''; ?>><?php echo $state['name']; ?></option>    
                                                        <?php } ?>   
                                                    </select>
                                                    <?php echo form_error('shipping[state_id]'); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-black">Pin Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="shipping[pin_code]" value="<?php echo $this->input->post('shipping[pin_code]'); ?>">
                                                    <?php echo form_error('shipping[pin_code]'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="text-black">Instructions</label>
                                    <textarea name="instructions" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."><?php echo $this->input->post('instructions'); ?></textarea>
                                </div>
                            </div>
                        <?php } else { ?>
                            <h2 class="h3 mb-3 text-black">Select Address</h2>
                            <div class="p-3 p-lg-5 border">
                                <a href="<?php echo site_url('customer/address/add'); ?>" class="btn btn-primary mb-2">Add New Address</a>
                                <hr>
                                <label class="text-black mb-3">Billing Address</label>
                                <?php if(!empty($billing_addresses)) { ?>
                                    <div class="row">
                                        <?php foreach($billing_addresses as $billing_address) { ?>
                                            <div class="col-md-6">
                                                <address>
                                                    <h5><input type="radio" value="<?php echo $billing_address['id']; ?>" name="billing_customer_address_id" <?php echo ($billing_address['is_default'] == 1) ? 'checked' : ''; ?>> <?php echo ucfirst($billing_address['name']); ?></h5>
                                                    <?php echo $billing_address['address_line_1']; ?><br>
                                                    <?php echo $billing_address['address_line_2']; ?><br>
                                                    <?php echo $billing_address['city'].", ".$billing_address['state'].", ".$billing_address['country']; ?><br>
                                                    <?php echo $billing_address['pin_code']; ?><br>
                                                </address>
                                                <hr>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <p class="mb-0">No billing addresses added yet!</p>
                                <?php } ?>
                                <?php echo form_error('billing_customer_address_id'); ?>
                                <hr>
                                <label class="text-black mb-3">Shipping Address</label>
                                <?php if(!empty($shipping_addresses)) { ?>
                                    <div class="row">
                                        <?php foreach($shipping_addresses as $shipping_address) { ?>
                                            <div class="col-md-6">
                                                <address>
                                                    <h5><input type="radio" value="<?php echo $shipping_address['id']; ?>" name="shipping_customer_address_id" <?php echo ($shipping_address['is_default'] == 1) ? 'checked' : ''; ?>> <?php echo ucfirst($shipping_address['name']); ?></h5>
                                                    <?php echo $shipping_address['address_line_1']; ?><br>
                                                    <?php echo $shipping_address['address_line_2']; ?><br>
                                                    <?php echo $shipping_address['city'].", ".$shipping_address['state'].", ".$shipping_address['country']; ?><br>
                                                    <?php echo $shipping_address['pin_code']; ?><br>
                                                </address>
                                                <hr>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <p class="mb-0">No shipping addresses added yet!</p>
                                <?php } ?>
                                <?php echo form_error('shipping_customer_address_id'); ?>
                                <hr>
                                <div class="form-group">
                                    <label class="text-black">Instructions</label>
                                    <textarea name="instructions" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."><?php echo $this->input->post('instructions'); ?></textarea>
                                    <?php echo form_error('instructions'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                                <div class="p-3 p-lg-5 border">
                                    <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                                    <div class="input-group w-75">
                                        <input type="text" class="form-control" name="discount_code" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" name="apply">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black">Your Order</h2>
                                <div class="p-3 p-lg-5 border">
                                    <table class="table site-block-order-table mb-5">
                                        <thead>
                                            <th>Product</th>
                                            <th class="text-right">Total</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cart['items'] as $item) { ?>
                                                <tr>
                                                    <td><?php echo $item['name']; ?> <strong class="mx-2">x</strong> <?php echo $item['quantity']; ?></td>
                                                    <td class="text-right"><?php echo show_price($item['total']); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Subtotal</strong></td>
                                                <td class="text-black text-right"><?php echo show_price($cart['subtotal']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Shipping</strong></td>
                                                <td class="text-black text-right"><?php echo ($cart['shipping_amount']) ? show_price($cart['shipping_amount']) : 'Free'; ?></td>
                                            </tr>
                                            <?php if($cart['discount_code']) { ?>
                                                <tr>
                                                    <td class="text-black font-weight-bold"><strong>Discount (<?php echo $cart['discount_code']; ?>)</strong></td>
                                                    <td class="text-black text-right">- <?php echo show_price($cart['discount_amount']); ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Total</strong></td>
                                                <td class="text-black font-weight-bold text-right"><strong><?php echo show_price($cart['total']); ?></strong></td>
                                            </tr>
                                            <?php if($cart['cashbacks_applied']) { ?>
                                                <tr>
                                                    <td class="text-black"><strong>Cashback </strong></td>
                                                    <td class="text-black text-right"><?php echo show_price($cart['cashback_amount']); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="border p-3 mb-3">
                                        <h3 class="h6 mb-0"><a class="d-block" role="button" aria-expanded="false" aria-controls="collapsebank"><label><input type="radio" name="payment" value="cod" checked>&nbsp;&nbsp;&nbsp;Cash on Delivery</label></a></h3>
                                        <div class="py-2">
                                            <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                        </div>
                                    </div>
                                    <?php if($this->customer['id']) { ?>
                                        <div class="form-group row ml-0">
                                            <label class="mb-0" style="width: 100%;">
                                                <input value="1" name="wallet" type="checkbox" <?php echo ($wallet_balance) ? '' : 'disabled'; ?>>&nbsp;&nbsp;Use Wallet Balance [<?php echo show_price($wallet_balance); ?>]</a>
                                            </label>
                                            <?php echo form_error('wallet'); ?>
                                        </div>
                                        <hr>
                                    <?php } ?>
                                    <div class="form-group row ml-0">
                                        <label class="mb-0" style="width: 100%;">
                                            <input value="1" name="terms" type="checkbox">&nbsp;&nbsp;I accept the <a href="<?php echo site_url('terms-conditions'); ?>">Terms & Conditions</a>
                                        </label>
                                        <?php echo form_error('terms'); ?>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-lg py-3 btn-block" name="place">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } else { ?>
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="site-blocks-table col-md-12">
                    <h3>Oops! Looks like your cart is empty.</h3>
                    <hr>
                    <p class="mb-0">Browse the <a href="<?php echo site_url('shop'); ?>">shop</a> to find a product you would like for yourself / gift for someone!</p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>