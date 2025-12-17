<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// File: application/config/routes.php

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth Routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Home Routes
$route['home'] = 'home/index';
$route['home/search'] = 'home/search';
$route['news'] = 'home/arsip';
$route['home/detail/(:any)'] = 'home/detail/$1';
$route['home/like/(:num)'] = 'home/like/$1';

// Dashboard Routes (User)
$route['dashboard'] = 'dashboard/index';
$route['dashboard/create'] = 'dashboard/create';
$route['dashboard/edit/(:num)'] = 'dashboard/edit/$1';
$route['dashboard/delete/(:num)'] = 'dashboard/delete/$1';

// API Routes 
$route['api/like/(:num)'] = 'api/toggle_like/$1';
$route['api/comment/add'] = 'api/add_comment';
$route['api/comment/delete/(:num)'] = 'api/delete_comment/$1';

// Admin  Routes 
$route['admin'] = 'admin/index';                     
$route['admin/users'] = 'admin/users';          
$route['admin/users/ban/(:num)'] = 'admin/ban_user/$1';  
$route['admin/users/unban/(:num)'] = 'admin/unban_user/$1'; 
$route['admin/news'] = 'admin/news';               
$route['admin/news/delete/(:num)'] = 'admin/delete_news/$1'; 