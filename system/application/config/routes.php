<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
/**
 *	-------------------------------------------------------------------------
 *	URI ROUTING
 *	-------------------------------------------------------------------------
 *	This file lets you re-map URI requests to specific controller functions.
 *
 *	Typically there is a one-to-one relationship between a URL string
 *	and its corresponding controller class/method. The segments in a
 *	URL normally follow this pattern:
 *
 *		example.com/class/method/id/
 *
 *	In some instances, however, you may want to remap this relationship
 *	so that a different class/function is called than the one
 *	corresponding to the URL.
 *
 *	Please see the user guide for complete details:
 *
 * 	http://codeigniter.com/user_guide/general/routing.html
 *
 *	-------------------------------------------------------------------------
 *	RESERVED ROUTES
 *	-------------------------------------------------------------------------
 *
 *	There are two reserved routes:
 *
 * 	$route['default_controller'] = 'welcome';
 *
 *	This route indicates which controller class should be loaded if the
 *	URI contains no data. In the above example, the "welcome" class
 *	would be loaded.
 *
 * 	$route['scaffolding_trigger'] = 'scaffolding';
 *
 *	This route lets you set a "secret" word that will trigger the
 *	scaffolding feature for added security. Note: Scaffolding must be
 *	enabled in the controller in which you intend to use it.	 The reserved
 *	routes must come before any wildcard or regular expression routes.
 *
 */
 
$route['default_controller'] = "designs/main";
$route['scaffolding_trigger'] = '';
$route['login'] = "users/login";
$route['register'] = "users/register";
$route['activate/(:any)'] = "users/activate_2/$1";
$route['recovery'] = "users/recovery";
$route['logout'] = "users/logout";
//$route['user/(:any)/designs'] = "users/designs/$1";
$route['users/all/(:any)'] = "users/index/$1";
$route['user/portfolio/(:any)'] = "users/portfolio/$1";
$route['user/services/(:any)'] = "users/services/$1";
$route['user/reviews/(:any)'] = "users/reviews/$1";
$route['user/subscribe/(:any)'] = "users/subscribe/$1";
$route['user/unsubscribe/(:any)'] = "users/unsubscribe/$1";
$route['user/reviews/(:any)'] = "users/reviews/$1";
$route['user/review/add/(:any)'] = "users/reviews_add/$1";
$route['user/review/del/(:num)'] = "users/reviews_del/$1";
$route['user/review/edit/(:num)'] = "users/reviews_edit/$1";
$route['user/(:any)'] = "users/designs/$1";
$route['designs/(:num).html'] = "designs/view/$1";
$route['designs/index/(:num)'] = "designs/index/$1";
$route['designs/search/(:num)'] = "designs/search/$1";
$route['news/(:num).html'] = "news/view/$1";
//$route['blogs/(:num).html'] = "blogs/view/$1";
$route['pages/(:any).html'] = "pages/view/$1";
$route['help/(:num).html'] = "help/view/$1";

$route['account/portfolio/add'] = 'account/portfolio_add';
$route['account/portfolio/del/(:num)'] = "account/portfolio_del/$1";
$route['account/portfolio/edit/(:num)'] = "account/portfolio_edit/$1";
$route['account/portfolio/up/(:num)'] = "account/portfolio_up/$1";
$route['account/portfolio/down/(:num)'] = "account/portfolio_down/$1";

// hide it!
$route['blogs'] = '404';
// hide it!
$route['account/ad'] = '404';
$route['account/balance'] = '404';
$route['account/balance_w'] = '404';
$route['account/categories_followers'] = '404';
$route['account/fail_r'] = '404';
$route['account/newa'] = '404';
$route['account/pay'] = '404';
$route['account/payments'] = '404';
$route['account/payments_view'] = '404';
$route['account/pay_no_auth'] = '404';
$route['account/purses'] = '404';
$route['account/purses_add'] = '404';
$route['account/purses_del'] = '404';
$route['account/result'] = '404';
$route['account/result_pay'] = '404';
$route['account/result_r'] = '404';
$route['account/succes_r'] = '404';
$route['account/tariff'] = '404';
$route['account/tariff_set'] = '404';
$route['account/transaction'] = '404';
$route['account/transfer'] = '404';
$route['account/users_followers'] = '404';
$route['account/withdraw'] = '404';
$route['account/withdraw_del'] = '404';

//$route['account/payments/(:num).html'] = "account/payments_view/$1";

//$route['users/([a-z]+)'] = "users/profile/$1";
/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
