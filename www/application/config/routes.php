<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
$route['404_override'] = '';

/**
 * route for admin, if not it will be override by home
 */
$route['login'] = 'login';
$route['user'] = 'user';
$route['login/(:any)'] = 'login/$1';
$route['user/(:any)'] = 'user/$1';
$route['admin'] = 'admin';
$route['admin/(:any)'] = 'admin/$1';
$route['admin/(:any)/(:any)'] = 'admin/$1/$2';
$route['admin/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3';
$route['admin/(:any)/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3/$4';
$route['admin/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3/$4/$5';
$route['admin/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3/$4/$5/$6';
$route['admin/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3/$4/$5/$6/$7';

$route['help'] = 'main/news/help';
$route['news'] = 'main/news/news';
$route['goi-y-dia-chi'] = 'main/news/goi-y-dia-chi';
$route['help/([a-z0-9-]+)/([a-z0-9-]+)-(:num).html'] = 'main/news/help/$1/$3';
$route['news/([a-z0-9-]+)/([a-z0-9-]+)-(:num).html'] = 'main/news/news/$1/$3';
$route['goi-y-dia-chi/([a-z0-9-]+)/([a-z0-9-]+)-(:num).html'] = 'main/news/goi-y-dia-chi/$1/$3';
$route['goi-y-dia-chi/([a-z0-9-]+)/([a-z0-9-]+)'] = 'main/news/goi-y-dia-chi/$1/$2';

//$route['([a-z0-9-]+)/g'] = 'main/servicegroup';
$route['([a-z0-9-]+)/([a-z0-9-]+)-(:num).htm'] = 'main/servicegroup/$2/$3/$1';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)-(:num).htm'] = 'main/servicegroup/$3/$4/$1/$2';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)-(:num).htm'] = 'main/servicegroup/$4/$5/$1/$2/$3';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)-(:num).htm'] = 'main/servicegroup/$5/$6/$1/$2/$3/$4';

$route['([a-z0-9-]+)/(:num)-([a-z0-9-]+).htm'] = 'main/service/$3/$2/$1';
$route['([a-z0-9-]+)/([a-z0-9-]+)/(:num)-([a-z0-9-]+).htm'] = 'main/service/$4/$3/$1/$2';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/(:num)-([a-z0-9-]+).htm'] = 'main/service/$5/$4/$1/$2/$3';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/(:num)-([a-z0-9-]+).htm'] = 'main/service/$6/$5/$1/$2/$3/$4';

$route['([a-z0-9-]+)'] = 'main/index/$1';
$route['main/(:any)'] = 'main/$1';
$route['main/(:any)/(:any)'] = 'main/$1/$2';
$route['main/(:any)/(:any)/(:any)'] = 'main/$1/$2/$3';
$route['([a-z0-9-]+)/([a-z0-9-]+)'] = 'main/district/$1/$2';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)'] = 'main/ward/$1/$2/$3';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)'] = 'main/street/$1/$2/$3/$4';
$route['([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)/([a-z0-9-]+)-(:num).html'] = 'main/serviceplace/$1/$2/$3/$4/$6';










/* End of file routes.php */
/* Location: ./application/config/routes.php */