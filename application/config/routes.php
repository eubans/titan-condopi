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
$route['default_controller'] = 'home/homepage';
$route['homepage'] = 'home/homepage';
$route['404_override'] = 'home/error404';
$route['translate_uri_dashes'] = FALSE;
$route['backend'] = "backend/dashboard";
$route['page/contact-us'] = "page/contact";
// $route['page/resources'] = "page/resources";
$route['article/(:any)'] = "page/article/$1";
$route['page/(:any)'] = "page/index/$1";
$route['blog/(:any)'] = "blog/detail/$1";
$route['category/(:any)'] = "blog/category/$1";
// $route['listing/(:any)'] = "home/detail/$1";
// /listing/for-sale/palmdale-california-93591/531
$route['listing/(:any)/(:any)/(:num)'] = "home/detail/$1/$2/$3";
$route['listing/(:num)'] = "home/detail_old/$1";
$route['listing'] = "home/listing";
$route['listing/type/(:any)'] = "home/listing/$1";
// new router prime
$route['prime'] = "orders/prime";
$route['prime-billing'] = "orders/primeBilling";
$route['submit-billing'] = "orders/submitBilling";
$route['submit-billing-auto'] = "orders/submitBillingAuto";
$route['billing/payment_status/(:num)'] = "orders/payment_status/$1";
$route['checkplancustomer'] = "orders/checkplancustomer";
$route['billing'] = "orders/billing";
$route['submit_billing_ads'] = "orders/submit_billing_ads";
$route['billing/payment_ads_status/(:num)'] = "orders/payment_ads_status/$1";
$route['submit-billing-ads-auto'] = "orders/submitBillinAdsgAuto";

$route['receipt/(:num)'] = "orders/receipt/$1";

