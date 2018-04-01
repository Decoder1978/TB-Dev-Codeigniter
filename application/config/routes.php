<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'torrents';
$route['404_override'] = '';

$route['announce'] = "announce";
//$route['members'] = "auth";

$route['staff'] = "moderator/staff_page";
$route['translate_uri_dashes'] = FALSE;
