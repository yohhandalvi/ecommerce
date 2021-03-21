<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'front/page/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/**
 * Admin Routes
 */

// User Routes
$route['admin'] = 'admin/user';
$route['admin/dashboard'] = 'admin/user/dashboard';
$route['admin/logout'] = 'admin/user/logout';
$route['admin/forgot-password'] = 'admin/user/forgot_password';
$route['admin/reset-password'] = 'admin/user/reset_password';

// Customer Routes
$route['customer/listing'] = 'admin/customer/listing';
$route['customer/add'] = 'admin/customer/add';
$route['customer/edit/(:num)'] = 'admin/customer/edit/$1';
$route['customer/view/(:num)'] = 'admin/customer/view/$1';
$route['customer/orders/(:num)'] = 'admin/customer/orders/$1';
$route['customer/reviews/(:num)'] = 'admin/customer/reviews/$1';
$route['customer/wishlist/(:num)'] = 'admin/customer/wishlist/$1';
$route['customer/wallet/(:num)'] = 'admin/customer/wallet/$1';
$route['customer/delete/(:num)'] = 'admin/customer/delete/$1';

// Customer Type Routes
$route['customer-group/listing'] = 'admin/customer_group/listing';
$route['customer-group/add'] = 'admin/customer_group/add';
$route['customer-group/edit/(:num)'] = 'admin/customer_group/edit/$1';
$route['customer-group/delete/(:num)'] = 'admin/customer_group/delete/$1';

// Customer Address Routes
$route['customer-address/listing/(:num)'] = 'admin/customer_address/listing/$1';
$route['customer-address/add/(:num)'] = 'admin/customer_address/add/$1';
$route['customer-address/edit/(:num)'] = 'admin/customer_address/edit/$1';
$route['customer-address/delete/(:num)'] = 'admin/customer_address/delete/$1';

// Product Routes
$route['product/listing'] = 'admin/product/listing';
$route['product/add'] = 'admin/product/add';
$route['product/sort'] = 'admin/product/sort';
$route['product/reviews'] = 'admin/product/all_reviews';
$route['product/edit/(:num)'] = 'admin/product/edit/$1';
$route['product/pricing/(:num)'] = 'admin/product/pricing/$1';
$route['product/delete/(:num)'] = 'admin/product/delete/$1';
$route['product/images/(:num)'] = 'admin/product/images/$1';
$route['product/stock/(:num)'] = 'admin/product/stock/$1';
$route['product/discount/(:num)'] = 'admin/product/discount/$1';
$route['product/reviews/(:num)'] = 'admin/product/reviews/$1';
$route['product/delete-review/(:num)'] = 'admin/product/delete_review/$1';
$route['product/change-review-status/(:num)'] = 'admin/product/change_review_status/$1';

// Category Routes
$route['category/listing'] = 'admin/category/listing';
$route['category/add'] = 'admin/category/add';
$route['category/edit/(:num)'] = 'admin/category/edit/$1';
$route['category/delete/(:num)'] = 'admin/category/delete/$1';

// Discount Routes
$route['discount/listing'] = 'admin/discount/listing';
$route['discount/add'] = 'admin/discount/add';
$route['discount/edit/(:num)'] = 'admin/discount/edit/$1';
$route['discount/delete/(:num)'] = 'admin/discount/delete/$1';

// Cashback Routes
$route['cashback/listing'] = 'admin/cashback/listing';
$route['cashback/add'] = 'admin/cashback/add';
$route['cashback/wallet'] = 'admin/cashback/wallet';
$route['cashback/for'] = 'admin/cashback/for';
$route['cashback/edit/(:num)'] = 'admin/cashback/edit/$1';
$route['cashback/delete/(:num)'] = 'admin/cashback/delete/$1';

// Shipping Rate Routes
$route['shipping-rate/listing'] = 'admin/shipping-rate/listing';
$route['shipping-rate/add'] = 'admin/shipping-rate/add';
$route['shipping-rate/edit/(:num)'] = 'admin/shipping-rate/edit/$1';
$route['shipping-rate/delete/(:num)'] = 'admin/shipping-rate/delete/$1';

// Order Routes
$route['order/listing'] = 'admin/order/listing';
$route['order/view/(:num)'] = 'admin/order/view/$1';
$route['order/invoice/download/(:num)'] = 'admin/order/invoice/download/$1';
$route['order/invoice/print/(:num)'] = 'admin/order/invoice/print/$1';

// Upload Routes
$route['upload/product/(:num)'] = 'admin/upload/product/$1';
$route['upload/delete'] = 'admin/upload/delete';

// Banner Routes
$route['banner/listing'] = 'admin/banner/listing';
$route['banner/images/(:num)'] = 'admin/banner/images/$1';
$route['banner/edit/(:num)'] = 'admin/banner/edit/$1';
$route['banner/delete/(:num)'] = 'admin/banner/delete/$1';
$route['banner/sort-images/(:num)'] = 'admin/banner/sort-images/$1';
$route['banner/add-image/(:num)'] = 'admin/banner/add-image/$1';
$route['banner/edit-image/(:num)'] = 'admin/banner/edit-image/$1';
$route['banner/delete-image/(:num)'] = 'admin/banner/delete-image/$1';

// Currency Routes
$route['currency/listing'] = 'admin/currency/listing';
$route['currency/add'] = 'admin/currency/add';
$route['currency/edit/(:num)'] = 'admin/currency/edit/$1';
$route['currency/delete/(:num)'] = 'admin/currency/delete/$1';

// Image Routes
$route['image/crop'] = 'admin/image/crop';

// Sort Routes
$route['sort'] = 'admin/sort/index';

/**
 * Site Routes
 */

// Page Routes
$route['about-us'] = 'front/page/about_us';
$route['contact-us'] = 'front/page/contact_us';
$route['privacy-policy'] = 'front/page/privacy_policy';
$route['terms-conditions'] = 'front/page/terms_conditions';
$route['careers'] = 'front/page/careers';
$route['help-faq'] = 'front/page/help_faq';
$route['shipping-returns'] = 'front/page/shipping_returns';

// Shop Routes
$route['shop'] = 'front/shop/index';
$route['shop/ajax'] = 'front/shop/ajax';

// Cart Routes
$route['cart'] = 'front/cart/index';
$route['cart/manage'] = 'front/cart/manage';
$route['cart/clear'] = 'front/cart/clear';
$route['cart/discount/remove'] = 'front/cart/remove_discount';

// Checkout Routes
$route['checkout'] = 'front/checkout/index';
$route['checkout/confirm'] = 'front/checkout/confirm';
$route['checkout/error'] = 'front/checkout/error';

// Order Routes
$route['order/invoice/(:num)'] = 'front/order/invoice/$1';
$route['order/(:num)'] = 'front/order/index/$1';

// Product Routes
$route['product/(:num)'] = 'front/product/index/$1';
$route['product/wishlist'] = 'front/product/wishlist';

// Customer Routes
$route['account'] = 'front/customer/account';
$route['logout'] = 'front/customer/logout';
$route['my-account'] = 'front/customer/my_account';
$route['forgot-password'] = 'front/customer/forgot_password';
$route['reset-password'] = 'front/customer/reset_password';

// Customer Address Routes
$route['customer/address/add'] = 'front/customer_address/add';
$route['customer/address/edit/(:num)'] = 'front/customer_address/edit/$1';
$route['customer/address/delete/(:num)'] = 'front/customer_address/delete/$1';