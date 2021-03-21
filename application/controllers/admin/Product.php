<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Category_model');
		$this->load->model('Currency_model');
		$this->load->model('Sort_model');
		$this->load->model('Product_model');
		$this->load->model('Product_stock_model');
	}

	public function listing()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get(); 

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['products'] = $this->Product_model->get_all_products(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Product_model->count_all_products($filters);
		$data['total'] = $this->Product_model->count_all_products();
		$data['inactive'] = $this->Product_model->count_all_products(['inactive' => 1]);
		$data['pagination'] = pagination(site_url('product/listing'), $data['count'], ROWS_PER_LISTING);

		$data['filter_categories'] = $this->Category_model->get_all_categories(null, null, ['select' => 'c.id, c.name, c.parent']);

		$data['tab'] = 'products';
		$data['title'] = 'Product Listing';
		$data['_view'] = 'admin/product/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function sort()
    {
        $this->authenticate(current_url());

        $filters['sort'] = 'sort=asc';
        $data['products'] = $this->Product_model->get_all_products(null, null, $filters);

        $data['tab'] = 'products';
		$data['title'] = 'Sort Products';
		$data['_view'] = 'admin/product/sort';
		$this->load->view('admin/layout/basetemplate', $data);
    }

	public function add()
	{
		$this->authenticate(current_url());

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category', 'required|xss_clean');
		$this->form_validation->set_rules('sku', 'SKU', 'required|check_field[products,sku,deleted|0]|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$this->form_validation->set_rules('specification', 'Specification', 'required|xss_clean');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'xss_clean');
		$this->form_validation->set_rules('meta_tags', 'Meta tags', 'xss_clean');
		$this->form_validation->set_rules('meta_description', 'Meta description', 'xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$data['sort'] = $this->Sort_model->get_new_sort_number(['table' => 'products']);
			$result = $this->Product_model->add($data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Product added successfully');
				redirect('product/edit/'.$result);
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the product');
				redirect('product/listing');
				exit;
			}
		}
		else
		{
			$data['categories'] = $this->Category_model->get_all_categories();

			$data['tab'] = 'products';
			$data['title'] = 'Add Product';
			$data['_view'] = 'admin/product/add';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category', 'required|xss_clean');
		$this->form_validation->set_rules('sku', 'SKU', 'required|check_field[products,sku,deleted|0&id !=|'.$id.']|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
		$this->form_validation->set_rules('specification', 'Specification', 'required|xss_clean');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'xss_clean');
		$this->form_validation->set_rules('meta_tags', 'Meta tags', 'xss_clean');
		$this->form_validation->set_rules('meta_description', 'Meta description', 'xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$result = $this->Product_model->update($id, $data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Product updated successfully');
				redirect('product/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the product');
				redirect('product/listing');
				exit;
			}
		}
		else
		{
			$data['categories'] = $this->Category_model->get_all_categories();

			$data['tab'] = 'products';
			$data['title'] = 'Edit Product';
			$data['_view'] = 'admin/product/edit';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function pricing($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$data['currencies'] = $this->Currency_model->get_all_currencies();

		foreach ($data['currencies'] as $currency)
		{
			$this->form_validation->set_rules('currencies['.$currency['id'].'][price]', 'Price', 'required|xss_clean');
			$this->form_validation->set_rules('currencies['.$currency['id'].'][tax_rate]', $currency['tax'].' rate', 'required|xss_clean');
			$this->form_validation->set_rules('currencies['.$currency['id'].'][price_excl_tax]', 'Price (excl tax)', 'required|xss_clean');
			$this->form_validation->set_rules('currencies['.$currency['id'].'][additional_shipping_cost]', 'Additional shipping cost', 'xss_clean');
		}

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$currencies = $data['currencies'];
			unset($data['currencies']);

			$this->Product_model->delete_product_prices($id);

			$product_prices = [];

			foreach ($currencies as $currency_id => $currency)
			{
				$product_prices[] = [
					'product_id' => $id,
					'currency_id' => $currency_id,
					'price' => $currency['price'],
					'tax_rate' => $currency['tax_rate'],
					'price_excl_tax' => $currency['price_excl_tax'],
					'additional_shipping_cost' => $currency['additional_shipping_cost']
				];
			}

			$this->Product_model->add_product_prices($product_prices);
			$this->session->set_flashdata('success_message', 'Product updated successfully');
			redirect('product/listing');
			exit;
		}
		else
		{
			$data['product_prices'] = $this->Product_model->get_all_product_prices($id);

			$data['tab'] = 'products';
			$data['title'] = 'Edit Product';
			$data['_view'] = 'admin/product/pricing';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function discount($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$this->form_validation->set_rules('has_discount', 'Has discount', 'required|xss_clean');

		if($this->input->post('has_discount'))
		{
			$this->form_validation->set_rules('discount_type', 'Type', 'required|xss_clean');
			$this->form_validation->set_rules('discount_value', 'Value', 'required|is_numeric|xss_clean');
		}

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$result = $this->Product_model->update($id, $data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Product updated successfully');
				redirect('product/discount/'.$id);
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the product');
				redirect('product/discount/'.$id);
				exit;
			}
		}
		else
		{
			$data['tab'] = 'products';
			$data['title'] = 'Update Product Discount';
			$data['_view'] = 'admin/product/discount';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function images($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$data['product_images'] = $this->Product_model->get_product_images($id);

		$data['tab'] = 'products';
		$data['title'] = 'Upload Product Images';
		$data['_view'] = 'admin/product/images';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function stock($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$this->form_validation->set_rules('quantity', 'Quantity', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = [
				'product_id' => $id,
				'quantity' => $this->input->post('quantity'),
				'action_by' => PRODUCT_STOCK_ACTION_BY_SYSTEM
			];

			$result = $this->Product_stock_model->add($data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Product stock updated successfully');
				redirect('product/stock/'.$id);
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the product stock');
				redirect('product/stock/'.$id);
				exit;
			}
		}
		else
		{
			$data['total_stock'] = $this->Product_stock_model->get_total_product_stock($id);
			$data['product_stock'] = $this->Product_stock_model->get_all_product_stock($id);

			$data['tab'] = 'products';
			$data['title'] = 'Manage Product Stock';
			$data['_view'] = 'admin/product/stock';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function all_reviews()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get();

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['product_reviews'] = $this->Product_model->get_product_reviews(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Product_model->count_all_product_reviews($filters);
		$data['total'] = $this->Product_model->count_all_product_reviews();
		$data['inactive'] = $this->Product_model->count_all_product_reviews(['inactive' => 1]);
		$data['pagination'] = pagination(site_url('product/reviews'), $data['count'], ROWS_PER_LISTING);

		$data['ratings'] = get_product_ratings();

		$data['tab'] = 'reviews';
		$data['title'] = 'View All Product Reviews';
		$data['_view'] = 'admin/product/all-reviews';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function reviews($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$data['product_reviews'] = $this->Product_model->get_product_reviews(null, null, ['product_id' => $id]);

		$data['tab'] = 'products';
		$data['title'] = 'View Product Reviews';
		$data['_view'] = 'admin/product/reviews';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function change_review_status($id = 0)
	{
		$this->authenticate(current_url());

		$data['product_review'] = $this->Product_model->get_product_review_by_id($id);

		if(empty($data['product_review']))
		{
			$this->session->set_flashdata('error_message', 'Review not found');
			redirect('product/reviews');
			exit;
		}

		$result = $this->Product_model->update_review($id, array('inactive' => ($data['product_review']['inactive']) ? 0 : 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Review status updated successfully');
			redirect('product/reviews');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while updating the review status');
			redirect('product/reviews');
			exit;
		}
	}

	public function delete_review($id = 0)
	{
		$this->authenticate(current_url());

		$data['product_review'] = $this->Product_model->get_product_review_by_id($id);

		if(empty($data['product_review']))
		{
			$this->session->set_flashdata('error_message', 'Review not found');
			redirect('product/reviews');
			exit;
		}

		$result = $this->Product_model->update_review($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Review deleted successfully');
			redirect('product/reviews');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the review');
			redirect('product/reviews');
			exit;
		}
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('product/listing');
			exit;
		}

		$result = $this->Product_model->update($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Product deleted successfully');
			redirect('product/listing');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the product');
			redirect('product/listing');
			exit;
		}
	}
}
