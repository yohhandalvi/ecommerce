<?php

function pr($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function lq()
{
	$ci =& get_instance();
	echo $ci->db->last_query();
	exit;
}

function display_price($amount)
{
	return "INR " . number_format($amount, 2);
}

function convert_db_time($datetime, $format = "d/m/Y")
{
	return date($format, strtotime($datetime));
}

function check_field($value, $data)
{
	$ci =& get_instance();
	$params = explode(",", $data);

	if(!empty($params[2]))
	{
		$filters = explode("&", $params[2]);

		if(!empty($filters))
		{
			foreach ($filters as $key => $filter)
			{
				$f = explode("|", $filter);
				$ci->db->where($f[0], $f[1]);
			}
		}
	}

	$ci->db->where($params[1], $value);
	$row = $ci->db->get($params[0])->row_array();

	if(empty($row))
	{
		return TRUE;
	}
	else
	{
		$ci->form_validation->set_message('check_field', '%s is already used');
		return FALSE;
	}
}

function show_image($image, $params = null)
{
	if(isset($params['thumbnail']))
	{
		$image_data = explode(".", $image);
		$extension = end($image_data);
		$folders = explode("/", $image);
		$url = str_replace(end($folders), "", $image)."thumb/".str_replace(".".$extension, "", end($folders))."_".$params['thumbnail'].".".$extension;
	}
	else
	{
		$url = $image;
	}

	return $url;
}

function get_original_image_url($image)
{
	$image_data = explode(".", $image);
	$extension = end($image_data);
	$image = preg_replace( '/_[^_]*$/', '', $image);
	$image = preg_replace( '/_[^_]*$/', '', $image);
	$image = $image.".".$extension;
	$image_data = explode("/", $image);
	$allowed_data = array_diff($image_data, ['thumb']);
	return implode("/", $allowed_data);
}

function base64_to_image($base64_string, $output_file)
{
    $ifp = fopen($output_file, 'wb'); 
    $data = explode(',', $base64_string);
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp); 
    return $output_file; 
}

function get_allowed_formats($type)
{
	$allowed_types = [
		'image' => ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png']
	];

	return isset($allowed_types[$type]) ? $allowed_types[$type] : [];
}

function get_product_ratings()
{
	$ratings = [
		'5' => '5',
		'4' => '4',
		'3' => '3',
		'2' => '2',
		'1' => '1'
	];

	return $ratings;
}
function get_order_statuses()
{
	$statuses = [
		'pending' => 'Pending',
		'placed' => 'Placed',
		'confirmed' => 'Confirmed',
		'shipped' => 'Shipped',
		'delivered' => 'Delivered',
		'cancelled' => 'Cancelled'
	];

	return $statuses;
}

function get_order_status_text($status)
{
	$statuses = get_order_statuses();
	return isset($statuses[$status]) ? $statuses[$status] : "-- Status Error --";
}

function check_status($status, $current_status, $icon = true)
{
	$statuses = [
		'pending' => 0,
		'placed' => 1,
		'confirmed' => 2,
		'shipped' => 3,
		'delivered' => 4,
		'cancelled' => -1
	];

	$number = 0;

	if($statuses[$status] <= $statuses[$current_status])
		$number = 1;
	else if(($statuses[$status] - 1) == $statuses[$current_status])
		$number = 2;

	if($number == 2)
	{
		if($current_status == 'cancelled')
		{
			$text = 'text-muted';
			$text .= ($icon) ? ' fa-times' : '';
			echo $text;
		}
		else
		{
			$text = 'text-warning';
			$text .= ($icon) ? ' fa-spinner fa-spin' : '';
			echo $text;
		}
	}
	else if($number == 1)
	{
		if($status == 'cancelled')
		{
			if($current_status == 'cancelled')
			{
				$text = 'text-success';
				$text .= ($icon) ? ' fa-check' : '';
				echo $text;
			}
			else
			{
				$text = 'text-danger';
				$text .= ($icon) ? ' fa-times' : '';
				echo $text;
			}
		}
		else
		{
			$text = 'text-success';
			$text .= ($icon) ? ' fa-check' : '';
			echo $text;
		}
	}
	else
	{
		$text = 'text-muted';
		$text .= ($icon) ? ' fa-times' : '';
		echo $text;
	}
}

function get_order_payments()
{
	$payments = [
		'cod' => 'Cash on Delivery'
	];

	return $payments;
}

function get_order_payment_text($payment)
{
	$payments = get_order_payments();
	return isset($payments[$payment]) ? $payments[$payment] : "-- Payment Error --";
}

function show_price($amount, $currency = null)
{
	if(is_null($currency))
	{
		$ci =& get_instance();
		$currency = $ci->currency_code;
	}
	return $currency . " " . number_format($amount, 2);
}

function ip_visitor_country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $country  = "Unknown";

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data_in = file_get_contents("http://api.db-ip.com/v2/free/".$ip);
    $ip_data = json_decode($ip_data_in, TRUE);

    pr($ip_data);

    return isset($ip_data['countryCode']) && $ip_data['countryCode'] !== "" && $ip_data['ipAddress'] !== "::1" ? $ip_data['countryCode'] : "IN";
}