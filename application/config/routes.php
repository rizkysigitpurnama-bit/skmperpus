<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'survei';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ================== ROUTE PROJECT SKM ==================
$route['rekap']              = 'survei/rekap';
$route['admin']               = 'auth/login';
$route['admin/login']         = 'auth/login';
$route['admin/logout']        = 'auth/logout';
$route['admin/dashboard']     = 'dashboard/index';
$route['admin/export']        = 'dashboard/export';
