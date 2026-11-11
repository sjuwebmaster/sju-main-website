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
|	https://codeigniter.com/userguide3/general/routing.html
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
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';

$route['login_check']       				= "Sju_management/login_check";
$route['dashboard']         				= "Sju_management/dashboard";
$route['logout']             				= "Sju_management/logout";
$route['side_menu']    					= "Sju_management/side_menu";
$route['home']             				= "Sju_management/dashboard";
$route['crumb']        					= "Sju_management/crumb";
$route['member_login']        			= "Sju_management/member_login";
$route['staff_registration_form']      = "Sju_management/staff_registration_form";
$route['get_district']        				= "Sju_management/get_district";
$route['get_constituency']        		= "Sju_management/get_constituency";
$route['save_staff']        			    = "Sju_management/save_staff";
$route['staff_view']        	            = "Sju_management/staff_view";
$route['staff_view_load']        	    = "Sju_management/staff_view_load";
$route['edit_staff']        	            = "Sju_management/edit_staff";
$route['update_staff']        	        = "Sju_management/update_staff";
$route['update_staff_status']         = "Sju_management/update_staff_status";
$route['mobile_number_check']       = "Sju_management/mobile_number_check";
$route['set_staff_permission']         = "Sju_management/set_staff_permission";
$route['save_staff_permission']       = "Sju_management/save_staff_permission";
//NEWS
$route['add_news']        			    = "Sju_management/add_news";
$route['save_news']        			    = "Sju_management/save_news";
$route['news_view']        			    = "Sju_management/news_view";
$route['news_view_load']        		= "Sju_management/news_view_load";
$route['update_news_status']        = "Sju_management/update_news_status";
$route['edit_news']        	            = "Sju_management/edit_news";
$route['update_news']      	            = "Sju_management/update_news";

//EVENTS
$route['add_event']        			    = "Sju_management/add_event";
$route['save_event']        			    = "Sju_management/save_event";
$route['events_view']        			= "Sju_management/events_view";
$route['events_view_load']        		= "Sju_management/events_view_load";
$route['update_event_status']       	= "Sju_management/update_event_status";
$route['edit_event']        			    = "Sju_management/edit_event";
$route['update_event']        			= "Sju_management/update_event";

//BOOKS
$route['add_book']        			    = "Sju_management/add_book";
$route['save_book']        			    = "Sju_management/save_book";
$route['books_view']        			    = "Sju_management/books_view";
$route['books_view_load']        		= "Sju_management/books_view_load";
$route['update_book_status']       	= "Sju_management/update_book_status";
$route['edit_book']        			    = "Sju_management/edit_book";
$route['update_book']        			= "Sju_management/update_book";

//SLIDERS
$route['add_slider']        			    = "Sju_management/add_slider";
$route['save_slider']        			    = "Sju_management/save_slider";
$route['slider_view']        			     = "Sju_management/slider_view";
$route['sliders_view_load']        		= "Sju_management/sliders_view_load";
$route['update_slider_status']       	= "Sju_management/update_slider_status";


//ANNOUNCEMENT
$route['add_announcement']        			    = "Sju_management/add_announcement";
$route['save_announcement']        			    = "Sju_management/save_announcement";
$route['announcements_view']        			= "Sju_management/announcements_view";
$route['announcements_view_load']        		= "Sju_management/announcements_view_load";
$route['update_announcement_status']       	= "Sju_management/update_announcement_status";
$route['edit_announcement']        			    = "Sju_management/edit_announcement";
$route['update_announcement']        			= "Sju_management/update_announcement";


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
