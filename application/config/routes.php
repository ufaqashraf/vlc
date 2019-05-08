<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'connector.php';

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

// ================= Dynamic Routes -- Started ================================================

/*
 * 	Dynamic Slugs for
 * 		->	Listings
 * 		->	Pages
 * 		->	Tradeshows
 * */

$db = getDBConnector();

/*
 * Listings Route with High Priority
 * */
$db->select('l.slug as listing_slug');
$db->from('listings as l');
$query = $db->get();
$listing_slugs_arr = $query->result();

foreach( $listing_slugs_arr as $listing_slug )
{
	//$route[ '(' . $listing_slug->listing_slug . ')' ] = 'checkslug/listing/$1';
	$route[ '(' . $listing_slug->listing_slug . ')' ] = 'listing/show_by_slug/$1';
}
unset($listing_slugs_arr);
unset($listing_slug);

/*
 * Categories
 * */
$db->select('c.slug');
$db->from('categories as c');
$db->where('c.category_type', 'category');
$query = $db->get();
$cat_slugs_arr = $query->result();

foreach( $cat_slugs_arr as $cat_slug )
{


	$route[ 'category/(' . $cat_slug->slug . ')' ] = 'listing/index/$1';
	$route[ 'category/(' . $cat_slug->slug . ')/(:num)' ] = 'listing/index/$1/$2';
	$route[ 'category/(' . $cat_slug->slug . ')/(:num)/(:num)' ] = 'listing/index/$1/$2/$3';
	$route[ 'category/(' . $cat_slug->slug . ')/(:num)/(:num)/(:num)' ] = 'listing/index/$1/$2/$3/$4';
}
unset($cat_slugs_arr);
unset($cat_slug);

/*
 * buying-lead cats
 * */
$db->select('c.slug');
$db->from('categories as c');
$db->where('c.category_type', 'buying_lead');
$query = $db->get();
$cat_slugs_arr = $query->result();

foreach( $cat_slugs_arr as $cat_slug )
{
	$route[ 'buying-lead/(' . $cat_slug->slug . ')' ] = 'categories/buying_lead_show_by_slug/$1';
}
unset($cat_slugs_arr);
unset($cat_slug);

/*
 * seller-lead cats
 * */
$db->select('c.slug');
$db->from('categories as c');
$db->where('c.category_type', 'seller_lead');
$query = $db->get();
$cat_slugs_arr = $query->result();

foreach( $cat_slugs_arr as $cat_slug )
{
	$route[ 'seller-lead/(' . $cat_slug->slug . ')' ] = 'categories/seller_lead_show_by_slug/$1';
}
unset($cat_slugs_arr);
unset($cat_slug);

/*
 * Pages
 * */
$db->select('p.slug as page_slug');
$db->from('posts as p');
$db->where('type', 'page');
$query = $db->get();
$pages_slugs_arr = $query->result();

foreach( $pages_slugs_arr as $page_slug )
{
	$route[ '(' . $page_slug->page_slug . ')' ] = 'pages/show_by_slug/$1';
}
unset($pages_slugs_arr);
unset($page_slug);



/*
 * Tradeshow
 * */
$db->select('p.slug as tradeshow_slug');
$db->from('posts as p');
$db->where('type', 'tradeshow');
$query = $db->get();
$tradeshow_slugs_arr = $query->result();

foreach( $tradeshow_slugs_arr as $tradeshow_slug )
{
	$route[ 'tradeshow/(' . $tradeshow_slug->tradeshow_slug . ')' ] = 'tradeshows/show_by_slug/$1';
}
unset($tradeshow_slugs_arr);
unset($tradeshow_slug);

// ================= Dynamic Routes -- Ends ================================================

$route['default_controller'] = 'home';
$route['signup'] = 'Users/create_user';
$route['login'] = 'Users/login';
$route['dashboard'] = 'dashboard';
$route['flagreports'] = 'flagreports';
$route['about-us'] = 'Aboutus/index';
$route['jobslisting/(:any)'] = 'Jobslisting/index/$1';
$route['contact-us'] = 'Contactus/index';
$route['purchase/(:num)/(:any)'] = 'paymentplans/purchase/$1/$2';
$route['ad-post'] = 'Users/add_post';
$route['privacy-policy'] = 'Privacypolicy/index';
$route['payment-plans'] = 'Paymentplans/index';
$route['404_override'] = 'sorry';
$route['translate_uri_dashes'] = FALSE;

/**
 * Listing Route with less priority
*/
$route['add-buying-lead'] = 'Users/add_buying_lead';
$route['buying-leads'] = 'listing/buying_leads';
$route['add-seller-lead'] = 'Users/add_seller_lead';
$route['seller-leads'] = 'listing/seller_leads';
$route['listing/search'] = 'listing/search';
$route['listing/propertysearch'] = 'listing/propertysearch';
$route['listing/savesearch'] = 'listing/savesearch';
$route['listing/removesearch'] = 'listing/removesearch';
$route['listing/user_membership_check'] = 'listing/user_membership_check';
$route['listing/get_state_ajax'] = 'listing/get_state_ajax/$1';
$route['listing/get_city_ajax'] = 'listing/get_city_ajax/$1';
$route['listing/get_subchild_ajax'] = 'listing/get_subchild_ajax/$1';

$route['listing/get_formdb_ajax'] = 'listing/get_formdb_ajax/$1';
$route['listing/get_formdb_ajax2'] = 'listing/get_formdb_ajax2/$1';
$route['listing/(:any)/(:num)/(:num)/(:num)'] = 'listing/view/$1/$2/$3/$4';
$route['listing/(:any)/(:num)/(:num)'] = 'listing/view/$1/$2/$3';
$route['listing/(:any)/(:num)'] = 'listing/view/$1/$2';
$route['listing/(:any)'] = 'listing/index/$1';

