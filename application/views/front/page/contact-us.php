<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Contact</strong></div>
        </div>
    </div>
</div>  
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Get In Touch</h2>
                <?php $this->load->view('front/layout/alert'); ?>
            </div>
            <div class="col-md-7">
                <form method="post">
                    <div class="p-3 p-lg-5 border">
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
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="" value="<?php echo $this->input->post('email'); ?>">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="subject" value="<?php echo $this->input->post('subject'); ?>">
                                <?php echo form_error('subject'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="text-black">Message <span class="text-danger">*</span></label>
                                <textarea name="message" cols="30" rows="7" class="form-control"><?php echo $this->input->post('message'); ?></textarea>
                                <?php echo form_error('message'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Send Message">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5 ml-auto">
                <div class="p-4 border mb-3">
                    <span class="d-block text-primary h6 text-uppercase">New York</span>
                    <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
                </div>
                <div class="p-4 border mb-3">
                    <span class="d-block text-primary h6 text-uppercase">London</span>
                    <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
                </div>
                <div class="p-4 border mb-3">
                    <span class="d-block text-primary h6 text-uppercase">Canada</span>
                    <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
                </div>
            </div>
        </div>
    </div>
</div>