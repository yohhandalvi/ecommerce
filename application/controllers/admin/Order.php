<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Email_model');
		$this->load->model('Order_model');
		$this->load->model('Customer_model');
	}

	public function listing()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get();

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['orders'] = $this->Order_model->get_all_orders(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Order_model->count_all_orders($filters);
		$data['total'] = $this->Order_model->count_all_orders();
		$data['pending'] = $this->Order_model->count_all_orders(['status' => 'placed']);
		$data['pagination'] = pagination(site_url('order/listing'), $data['count'], ROWS_PER_LISTING);

		$data['order_statuses'] = get_order_statuses();
		$data['order_payments'] = get_order_payments();

		$data['tab'] = 'orders';
		$data['title'] = 'Order Listing';
		$data['_view'] = 'admin/order/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function view($id = 0)
	{
		$this->authenticate(current_url());

		$data['order'] = $this->Order_model->get_order_by_id($id);

		if(empty($data['order']))
		{
			$this->session->set_flashdata('error_message', 'Order not found');
			redirect('order/listing');
			exit;
		}

		$this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('payment', 'Payment', 'required|xss_clean');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            if($data['order']['status'] != $this->input->post('status'))
            {
                if(in_array($this->input->post('status'), ['confirmed', 'shipped', 'delivered', 'cancelled']))
                {
                    $this->Email_model->send_order_email($id, $this->input->post('status'), ['message' => $this->input->post('message')]);
                }
            }

            $data = $this->input->post();
            unset($data['message']);
            $result = $this->Order_model->update($id, $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Order updated successfully');
                redirect('order/view/'.$id);
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the order');
                redirect('order/view/'.$id);
                exit;
            }
        }
        else
        {
			$data['order_statuses'] = get_order_statuses();
			$data['order_payments'] = get_order_payments();
			$data['order_items'] = $this->Order_model->get_order_items($id);
			$data['customer'] = $this->Customer_model->get_customer_by_id($data['order']['customer_id']);
			$data['other_orders'] = $this->Order_model->get_all_orders(4, 0, ['exclude_ids' => [$id], 'customer_id' => $data['order']['customer_id']]);

			$data['tab'] = 'orders';
			$data['title'] = 'View Order';
			$data['_view'] = 'admin/order/view';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function invoice($action = null, $id = 0)
	{
        $data['order'] = $this->Order_model->get_order_by_id($id);

		if(empty($data['order']))
		{
			$this->session->set_flashdata('error_message', 'Order not found');
			redirect('order/listing');
			exit;
		}

        if(in_array($data['order']['status'], array('pending', 'cancelled')))
        {
			$this->session->set_flashdata('error_message', 'Order not found');
            redirect('order/listing');
			exit;
        }

        $data['order_items'] = $this->Order_model->get_order_items($id);

        $this->load->library('Pdf');
        $invoice_view = $this->load->view('email/invoice', $data, true);
        
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->SetTitle(PROJECT_NAME);
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->SetRightMargin(30);
        $pdf->setFooterMargin(20);

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set margins
		$pdf->SetMargins(12, 20, 35);

        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');

        $pdf->AddPage();
        $pdf->writeHTML($invoice_view, true, false, true, false, '');

        if($action == 'print')
        {
        	$pdf->IncludeJS("print();");
        	$pdf->Output('invoice.pdf', 'I');
        }
        else
        {
        	$pdf->Output('invoice.pdf', 'I');
        }
	}
}
