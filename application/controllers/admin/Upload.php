<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends AdminController {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Sort_model');
		$this->load->model('Upload_model');
		$this->load->model('Product_model');
	}

	public function product($id = 0)
	{
		$this->authenticate(current_url());

		$config['upload_path']          = FCPATH.'uploads/products/images/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['encrypt_name']      	= TRUE;
        $config['file_ext_tolower']     = TRUE;
        // $config['min_width']            = 1000;
        // $config['min_height']           = 1000;

        if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'], 0777, true);
            mkdir($config['upload_path'].'thumb/', 0777, true);
        }

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('file'))
        {
        	$response = [
        		'success' => FALSE,
        		'message' => $this->upload->display_errors()
        	];
        }
        else
        {
            $data = $this->upload->data();
            $thumbnail = $this->Upload_model->thumbnail($data['full_path'], $config['upload_path'].'thumb/');
            $table = 'product_images';

            $file_data = [
            	'product_id' => $id,
            	'image' => $data['file_name'],
            	'name' => $data['orig_name'],
            	'sort' => $this->Sort_model->get_new_sort_number(['table' => $table, 'column' => 'product_id', 'value' => $id])
            ];

            $this->Upload_model->insert_file($table, $file_data);

            $response = [
        		'success' => TRUE,
        		'message' => 'Uploaded successfully',
        		'data' => [
        			'file' => base_url('uploads/products/images/'.$data['file_name'])
        		]
        	];
        }

        echo json_encode($response);
        exit;
	}

	public function delete()
	{
		$id = $this->input->get('id');
		$table = $this->input->get('table');
		$folder = $this->input->get('folder');
		$this->Upload_model->delete_file($table, $id, $folder);
		redirect($this->agent->referrer());
	}

}