<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

// Auth Routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';
$route['do_login'] = 'auth/do_login';
$route['do_register'] = 'auth/do_register';

// Home Routes
$route[''] = 'home/index';
$route['home'] = 'home/index';

// News Routes
$route['news/(:any)'] = 'news/detail/$1';
$route['news/like/(:num)'] = 'news/toggle_like/$1';
$route['news/comment/(:num)'] = 'news/add_comment/$1';

// Dashboard Routes
$route['dashboard'] = 'dashboard/index';
$route['dashboard/create'] = 'dashboard/create';
$route['dashboard/store'] = 'dashboard/store';
$route['dashboard/edit/(:num)'] = 'dashboard/edit/$1';
$route['dashboard/update/(:num)'] = 'dashboard/update/$1';
$route['dashboard/delete/(:num)'] = 'dashboard/delete/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;