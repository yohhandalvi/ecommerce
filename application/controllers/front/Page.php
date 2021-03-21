<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Email_model');
        $this->load->model('Banner_model');
    }

    public function home()
    {
        $data['featured_products'] = $this->Product_model->get_all_products(10, 0, ['inactive' => 0, 'featured' => 1]);

        $home_main_banner = $this->Banner_model->get_banner_by_id(1);

        if(!empty($home_main_banner) && $home_main_banner['inactive'] == 0)
        {
            $data['banner_images'] = $this->Banner_model->get_all_banner_images(null, null, ['inactive' => 0, 'banner_id' => 1]);
        }

        $data['tab'] = 'home';
        $data['title'] = 'Home';
        $data['_view'] = 'front/page/home';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function about_us()
    {
        $data['tab'] = 'about-us';
        $data['title'] = 'About Us';
        $data['_view'] = 'front/page/about-us';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function contact_us()
    {
        $this->form_validation->set_rules('first_name', 'First name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
        $this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean');
        $this->form_validation->set_rules('message', 'Message', 'required|xss_clean');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Email_model->send_contact_mail($data['first_name'], $data['last_name'], $data['email'], $data['subject'], $data['message']);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Thank you for contacting us / we will revert back in 24-48 hours.');
                redirect('contact-us');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while contacting the team');
                redirect('contact-us');
                exit;
            }
        }
        else
        {
            $data['tab'] = 'contact-us';
            $data['title'] = 'Contact Us';
            $data['_view'] = 'front/page/contact-us';
            $this->load->view('front/layout/basetemplate', $data);
        }
    }

    public function privacy_policy()
    {
        $data['tab'] = 'privacy-policy';
        $data['title'] = 'Privacy Policy';
        $data['_view'] = 'front/page/privacy-policy';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function careers()
    {
        $data['tab'] = 'careers';
        $data['title'] = 'Careers';
        $data['_view'] = 'front/page/careers';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function terms_conditions()
    {
        $data['tab'] = 'terms-conditions';
        $data['title'] = 'Terms & Conditions';
        $data['_view'] = 'front/page/terms-conditions';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function help_faq()
    {
        $data['tab'] = 'help-faq';
        $data['title'] = 'Help & FAQs';
        $data['_view'] = 'front/page/help-faq';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function shipping_returns()
    {
        $data['tab'] = 'shipping-returns';
        $data['title'] = 'Shipping & Returns';
        $data['_view'] = 'front/page/shipping-returns';
        $this->load->view('front/layout/basetemplate', $data);
    }
}