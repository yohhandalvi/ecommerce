<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends SiteController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Order_model');
	}

	public function index($id = 0)
	{
		$this->authenticate(current_url());

		$data['order'] = $this->Order_model->get_order_by_id($id);

		if(empty($data['order']))
		{
			$this->session->set_flashdata('error_message', 'Order not found');
			redirect('my-account');
			exit;
		}

		$data['order_items'] = $this->Order_model->get_order_items($id);

        $data['title'] = 'Order View';
        $data['_view'] = 'front/order/index';
        $this->load->view('front/layout/basetemplate', $data);
	}

	public function invoice($id = 0)
	{
        $this->authenticate(current_url());

        $data['order'] = $this->Order_model->get_order_by_id($id);

		if(empty($data['order']))
		{
			$this->session->set_flashdata('error_message', 'Order not found');
			redirect('my-account');
			exit;
		}

        if(in_array($data['order']['status'], array('pending', 'cancelled')))
        {
			$this->session->set_flashdata('error_message', 'Order not found');
            redirect('my-account');
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

        $pdf->Output('invoice.pdf', 'I');
	}
}
