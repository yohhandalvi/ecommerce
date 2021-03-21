<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Account</strong></div>
        </div>
    </div>
</div>  
<div class="site-section">
    <div class="container">
        <?php $this->load->view('front/layout/alert'); ?>
        <div class="row">
            <div class="col-md-6">
                <h2 class="h3 mb-3 text-black text-uppercase">Login</h2>
                <form method="post">
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="l_email" placeholder="" value="<?php echo $this->input->post('l_email'); ?>">
                                <?php echo form_error('l_email'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="l_password" placeholder="" value="<?php echo $this->input->post('l_password'); ?>">
                                <?php echo form_error('l_password'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <a href="<?php echo site_url('forgot-password'); ?>">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary btn-lg btn-block" name="type" value="Login">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2 class="h3 mb-3 text-black text-uppercase">Register</h2>
                <form method="post">
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="text-black">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="r_first_name"  value="<?php echo $this->input->post('r_first_name'); ?>">
                                <?php echo form_error('r_first_name'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-black">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="r_last_name" value="<?php echo $this->input->post('r_last_name'); ?>">
                                <?php echo form_error('r_last_name'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="r_email" placeholder="" value="<?php echo $this->input->post('r_email'); ?>">
                                <?php echo form_error('r_email'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="text-black">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="r_password" placeholder="" value="<?php echo $this->input->post('r_password'); ?>">
                                <?php echo form_error('r_password'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-black">Retype Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="r_retype_password" placeholder="" value="<?php echo $this->input->post('r_retype_password'); ?>">
                                <?php echo form_error('r_retype_password'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Mobile</label>
                                <input type="text" class="form-control" name="r_mobile" placeholder="" value="<?php echo $this->input->post('r_mobile'); ?>">
                                <?php echo form_error('r_mobile'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="text-black">Gender</label>
                                <select class="form-control" name="r_gender">
                                    <option>-- Choose --</option>
                                    <option value="male" <?php echo ($this->input->post('r_gender') == 'male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo ($this->input->post('r_gender') == 'female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="other" <?php echo ($this->input->post('r_gender') == 'other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <?php echo form_error('r_gender'); ?>
                            </div>
                            <div class="col-md-6">
                                <label class="text-black">Date of Birth</label>
                                <input type="date" class="form-control" name="r_date_of_birth" placeholder="" value="<?php echo $this->input->post('r_date_of_birth'); ?>">
                                <?php echo form_error('r_date_of_birth'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>
                                    <input type="checkbox" name="r_newsletter" value="1" <?php echo ($this->input->post('r_newsletter')) ? 'checked' : ''; ?>>&nbsp;&nbsp;&nbsp;Subscribe to newsletter
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary btn-lg btn-block" name="type" value="Register">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>