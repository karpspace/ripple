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

$route['test'] = 'UnitTest/index';

$route['generate/(:any)'] = 'Generate/$1';
$route['authenticate'] = 'Main/authenticate';
$route['logout'] = 'Main/logout';
$route['loginFail'] = 'Main/login/fail';
$route['login'] = 'Main/login';
$route['allCompanies'] = 'Main/allCompanies/1';
$route['allCompanies/(:any)'] = 'Main/allCompanies/$1';
$route['allContacts'] = 'Main/allContacts/1';
$route['allContacts/(:any)'] = 'Main/allContacts/$1';
$route['allUsers'] = 'Main/allUsers/1';
$route['allUsers/(:any)'] = 'Main/allUsers/$1';
$route['editUser/(:any)'] = 'Main/editUser/$1';
$route['removeUser/(:any)'] = 'Main/removeUser/$1';
$route['updateUser/(:any)'] = 'Main/updateUser/$1';
$route['addUser'] = 'Main/addUser';
$route['addUserExecute'] = 'Main/addUserExecute';
$route['activateUser/(:num)'] = 'Main/activateUser/$1';
$route['deactivateUser/(:num)'] = 'Main/deactivateUser/$1';

$route['searchCompaniesAjax'] = 'Main/searchCompaniesAjax';
$route['searchContactsAjax'] = 'Main/searchContactsAjax';
$route['editCompany/(:num)'] = 'Main/editCompany/$1';
$route['removeCompany/(:num)'] = 'Main/removeCompany/$1';

$route['updateCompany/(:num)'] = 'Main/updateCompany/$1';
$route['editContact/(:num)'] = 'Main/editContact/$1';
$route['updateContact/(:num)'] = 'Main/updateContact/$1';
$route['removeContact/(:num)'] = 'Main/removeContact/$1';
$route['default_controller'] = 'Main/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
