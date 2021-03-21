<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Upload_model');
        $this->load->model('Sort_model');
    }

    public function listing($page = 0)
    {
        $this->authenticate(current_url());

        $filters = $this->input->get();

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['banners'] = $this->Banner_model->get_all_banners(ROWS_PER_LISTING, $offset, $filters);
        $data['count'] = $this->Banner_model->count_all_banners($filters);
        $data['total'] = $this->Banner_model->count_all_banners();
        $data['inactive'] = $this->Banner_model->count_all_banners(['inactive' => 1]);
        $data['pagination'] = pagination(site_url('banner/listing'), $data['count'], ROWS_PER_LISTING);

        $data['tab'] = 'banners';
        $data['title'] = 'Banner Listing';
        $data['_view'] = 'admin/banner/listing';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function images($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner'] = $this->Banner_model->get_banner_by_id($id);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $filters = $this->input->get();

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['banner_images'] = $this->Banner_model->get_all_banner_images(ROWS_PER_LISTING, $offset, $filters);
        $data['count'] = $this->Banner_model->count_all_banner_images($filters);
        $data['total'] = $this->Banner_model->count_all_banner_images();
        $data['inactive'] = $this->Banner_model->count_all_banner_images(['inactive' => 1]);
        $data['pagination'] = pagination(site_url('banner/images/'.$id), $data['count'], ROWS_PER_LISTING);

        $data['tab'] = 'banners';
        $data['title'] = 'Banner Image Listing';
        $data['_view'] = 'admin/banner/images';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function sort_images($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner'] = $this->Banner_model->get_banner_by_id($id);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $filters['sort'] = 'sort=asc';
        $data['banner_images'] = $this->Banner_model->get_all_banner_images(null, null, $filters);

        $data['tab'] = 'banners';
        $data['title'] = 'Sort Banner Images';
        $data['_view'] = 'admin/banner/sort-images';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function edit($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner'] = $this->Banner_model->get_banner_by_id($id);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $this->form_validation->set_rules('inactive', 'Status', 'required|is_numeric');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Banner_model->update_banner($id, $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Banner updated successfully');
                redirect('banner/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the banner');
                redirect('banner/listing');
                exit;
            }
        }
        else
        {
            $data['tab'] = 'banners';
            $data['title'] = 'Edit Banner';
            $data['_view'] = 'admin/banner/edit';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner'] = $this->Banner_model->get_banner_by_id($id);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $result = $this->Banner_model->update($id, array('deleted' => 1));

        if($result)
        {
            $this->session->set_flashdata('success_message', 'Banner deleted successfully');
            redirect('banner/listing');
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Some error occured while deleting the banner');
            redirect('banner/listing');
            exit;
        }
    }

    public function add_image($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner'] = $this->Banner_model->get_banner_by_id($id);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $this->form_validation->set_rules('image', 'Image', 'callback_file_check[["image", "image"]]');
        $this->form_validation->set_rules('product_id', 'Product', 'required|is_numeric');
        $this->form_validation->set_rules('category_id', 'Category', 'required|is_numeric');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $upload = $this->upload();

            if($upload['success'])
            {
                $data = $this->input->post();
                $data['image'] = $upload['data']['file_name'];
                $data['banner_id'] = $id;
                $data['sort'] = $this->Sort_model->get_new_sort_number(['table' => 'banner_images', 'column' => 'banner_id', 'value' => $id]);
                $result = $this->Banner_model->add_banner_image($data);

                if($result)
                {
                    $this->session->set_flashdata('success_message', 'Banner image addedd successfully');
                    redirect('banner/images/'.$id);
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while adding the banner image');
                    redirect('banner/images/'.$id);
                    exit;
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', $upload['message']);
                redirect('banner/images/'.$id);
                exit;
            }
        }
        else
        {
            $data['products'] = $this->Product_model->get_all_products(null, null, ['select' => 'p.id, p.name', 'sort' => 'name=asc']);
            $data['categories'] = $this->Category_model->get_all_categories(null, null, ['select' => 'c.id, c.name, c.parent']);

            $data['tab'] = 'banners';
            $data['title'] = 'Add Banner Image';
            $data['_view'] = 'admin/banner/add-image';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function edit_image($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner_image'] = $this->Banner_model->get_banner_image_by_id($id);

        if(empty($data['banner_image']))
        {
            $this->session->set_flashdata('error_message', 'Banner image not found');
            redirect('banner/listing');
            exit;
        }

        $data['banner'] = $this->Banner_model->get_banner_by_id($data['banner_image']['banner_id']);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $banner_id = $data['banner']['id'];

        $this->form_validation->set_rules('image', 'Image', 'callback_file_check[["image", "image", false]]');
        $this->form_validation->set_rules('product_id', 'Product', 'required|is_numeric');
        $this->form_validation->set_rules('category_id', 'Category', 'required|is_numeric');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();

            $upload = $this->upload();

            if($upload['success'])
            {
                $data['image'] = $upload['data']['file_name'];
            }

            $result = $this->Banner_model->update_banner_image($id, $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Banner image updated successfully');
                redirect('banner/images/'.$banner_id);
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the banner image');
                redirect('banner/images/'.$banner_id);
                exit;
            }
        }
        else
        {
            $data['products'] = $this->Product_model->get_all_products(null, null, ['select' => 'p.id, p.name', 'sort' => 'name=asc']);
            $data['categories'] = $this->Category_model->get_all_categories(null, null, ['select' => 'c.id, c.name, c.parent']);

            $data['tab'] = 'banners';
            $data['title'] = 'Edit Banner Image';
            $data['_view'] = 'admin/banner/edit-image';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete_image($id = 0)
    {
        $this->authenticate(current_url());

        $data['banner_image'] = $this->Banner_model->get_banner_image_by_id($id);

        if(empty($data['banner_image']))
        {
            $this->session->set_flashdata('error_message', 'Banner image not found');
            redirect('banner/listing');
            exit;
        }

        $data['banner'] = $this->Banner_model->get_banner_by_id($data['banner_image']['banner_id']);

        if(empty($data['banner']))
        {
            $this->session->set_flashdata('error_message', 'Banner not found');
            redirect('banner/listing');
            exit;
        }

        $result = $this->Banner_model->update_banner_image($id, array('deleted' => 1));

        if($result)
        {
            $this->session->set_flashdata('success_message', 'Banner image deleted successfully');
            redirect('banner/images/'.$data['banner_image']['banner_id']);
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Some error occured while deleting the banner image');
            redirect('banner/images/'.$data['banner_image']['banner_id']);
            exit;
        }
    }

    private function upload()
    {
        $config['upload_path']          = FCPATH.'uploads/banners/images/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['encrypt_name']         = TRUE;
        $config['file_ext_tolower']     = TRUE;

        if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'], 0777, true);
            mkdir($config['upload_path'].'thumb/', 0777, true);
        }

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('image'))
        {
            $response = [
                'success' => FALSE,
                'message' => $this->upload->display_errors()
            ];
        }
        else
        {
            $data = $this->upload->data();
            $thumbnail = $this->Upload_model->thumbnail($data['full_path'], $config['upload_path'].'thumb/', 1200, 700);

            $response = [
                'success' => TRUE,
                'message' => 'Uploaded successfully',
                'data' => [
                    'file_name' => $data['file_name']
                ]
            ];
        }

        return $response;
    }

    public function file_check($post, $params)
    {
        $data = json_decode($params);

        if(isset($data[2]) && $data[2] == false)
        {
            return TRUE;
        }

        $allowed_mime_type_arr = get_allowed_formats($data[1]);
        $mime = get_mime_by_extension($_FILES[$data[0]]['name']);

        if(isset($_FILES[$data[0]]['name']) && $_FILES[$data[0]]['name']!= "")
        {
            if(in_array($mime, $allowed_mime_type_arr))
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file');
                return false;
            }
        }
        else
        {
            $this->form_validation->set_message('file_check', 'Please choose a file to upload');
            return false;
        }
    }
}