<?php

class Email_model extends CI_Model {

	public function send_registration_email($name, $email, $password = null)
	{
		$data['data'] = array(
			'name' => $name,
			'email' => $email,
			'password' => $password
		);
		$data['_view'] = 'registration';
        $data['title'] = PROJECT_NAME.' Registration';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to([$email => $name], PROJECT_NAME." Registration", $html);
	}

	public function send_forgot_password_link($name, $email, $forgot_password_key)
	{
        $data['data'] = array(
			'name' => $name,
			'forgot_password_key' => $forgot_password_key
		);
		$data['_view'] = 'reset-password-link';
        $data['title'] = PROJECT_NAME.' Reset Password Mail';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to([$email => $name], PROJECT_NAME." Reset Password Mail", $html);
	}

	public function send_admin_forgot_password_link($name, $email, $forgot_password_key)
	{
        $data['data'] = array(
			'name' => $name,
			'forgot_password_key' => $forgot_password_key
		);
		$data['_view'] = 'admin-reset-password-link';
        $data['title'] = PROJECT_NAME.' Reset Password Mail';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to([$email => $name], PROJECT_NAME." Reset Password Mail", $html);
	}

	public function send_contact_mail($first_name, $last_name, $email, $subject, $message)
	{
        $data['data'] = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email,
			'subject' => $subject,
			'message' => $message
		);
		$data['_view'] = 'contact';
        $data['title'] = PROJECT_NAME.' Contact Mail';
        $html = $this->load->view('email/layout', $data, true);
        return $this->send_mail->send_to(EMAIL_ADMIN, PROJECT_NAME." Contact Mail", $html);
	}

	public function send_order_email($order_id, $action, $extra_params = null)
	{
		$invoice_as_attachment = $this->_generate_invoice($order_id);

		$this->load->model('Order_model');
		$order = $this->Order_model->get_order_by_id($order_id);

		switch ($action)
		{
			case 'placed':

				$data['order'] = array(
					'order_id' => $order['order_id'],
					'name' => $order['customer_full_name']
				);
				$data['_view'] = 'order-placed';
		        $data['title'] = 'Order Placed';
		        $html = $this->load->view('email/layout', $data, true);
		        $this->send_mail->send_to([$order['customer_email'] => $order['customer_full_name']], PROJECT_NAME." Order Placed", $html, $invoice_as_attachment);

				$data['order'] = array(
					'order_id' => $order['order_id'],
					'name' => PROJECT_NAME.' Admin'
				);
				$data['_view'] = 'admin-new-order-placed';
		        $data['title'] = 'New Order Placed';
		        $html = $this->load->view('email/layout', $data, true);
		        $this->send_mail->send_to(EMAIL_ADMIN, PROJECT_NAME." New Order Placed", $html, $invoice_as_attachment);

				break;

			case 'confirmed':

				$data['order'] = array(
					'order_id' => $order['order_id'],
					'name' => $order['customer_full_name'],
					'message' => $extra_params['message']
				);
				$data['_view'] = 'order-confirmed';
		        $data['title'] = 'Order Confirmed';
		        $html = $this->load->view('email/layout', $data, true);
		        $this->send_mail->send_to([$order['customer_email'] => $order['customer_full_name']], PROJECT_NAME." Order Confirmed", $html, $invoice_as_attachment);

				break;

			case 'shipped':

				$data['order'] = array(
					'order_id' => $order['order_id'],
					'name' => $order['customer_full_name'],
					'message' => $extra_params['message']
				);
				$data['_view'] = 'order-shipped';
		        $data['title'] = 'Order Shipped';
		        $html = $this->load->view('email/layout', $data, true);
		        $this->send_mail->send_to([$order['customer_email'] => $order['customer_full_name']], PROJECT_NAME." Order Shipped", $html, $invoice_as_attachment);

				break;

			case 'delivered':

				$data['order'] = array(
					'order_id' => $order['order_id'],
					'name' => $order['customer_full_name'],
					'message' => $extra_params['message']
				);
				$data['_view'] = 'order-delivered';
		        $data['title'] = 'Order Delivered';
		        $html = $this->load->view('email/layout', $data, true);
		        $this->send_mail->send_to([$order['customer_email'] => $order['customer_full_name']], PROJECT_NAME." Order Delivered", $html, $invoice_as_attachment);

				break;

			case 'cancelled':

				$data['order'] = array(
					'order_id' => $order['order_id'],
					'name' => $order['customer_full_name'],
					'message' => $extra_params['message']
				);
				$data['_view'] = 'order-cancelled';
		        $data['title'] = 'Order Cancelled';
		        $html = $this->load->view('email/layout', $data, true);
		        $this->send_mail->send_to([$order['customer_email'] => $order['customer_full_name']], PROJECT_NAME." Order Cancelled", $html, $invoice_as_attachment);

				break;
		}
	}

	public function _generate_invoice($order_id)
    {
    	$this->load->model('Order_model');
		$invoice_data['order'] = $this->Order_model->get_order_by_id($order_id);
		$invoice_data['order_items'] = $this->Order_model->get_order_items($order_id);

        $this->load->library('Pdf');
        $invoice_view = $this->load->view('email/invoice', $invoice_data, true);
        
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
        $invoice = $pdf->Output(PROJECT_NAME.' Invoice.pdf', 'S');

        $attachment['type'] = "application/pdf";
        $attachment['name'] = "Invoice";
        $attachment['content'] = $invoice;
        return $attachment;
    }
}
