<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/support/ticket/(:num)', 'Support::ticket/$1');
$routes->get('/chat', 'Home::index', ['as' => 'chat']);
$routes->add('/chat/(:alphanum)', 'Chat::index/$1');
$routes->add('/chat/(:alphanum)/leave', 'Chat::leave/$1');
$routes->add('/chat/(:alphanum)/return', 'Chat::leaveprivate/$1');

$routes->add('/admin/room/edit/(:num)','Roommanager::edit/$1');
$routes->add('/admin/dashboard','Admin::dashboard');
$routes->add('/admin/dashboard/rooms','Admin::dashboardrooms');
$routes->add('/admin/dashboard/room/view/(:num)','Admin::dashboardroomview/$1');
$routes->add('/admin/dashboard/users','Admin::dashboardusers');
$routes->add('/admin/dashboard/users/groups','Admin::dashboardusergroups');
$routes->add('/admin/dashboard/users/group/view/(:num)','Admin::dashboardusergroupview/$1');
$routes->add('/admin/dashboard/users/group/remove/(:num)','Admin::removeUsersGroup/$1');
$routes->add('/admin/dashboard/user/view/(:num)','Admin::dashboarduserview/$1');
$routes->add('/admin/dashboard/user/edit/(:num)','Admin::dashboarduseredit/$1');
$routes->add('/admin/dashboard/user/save/(:num)','Admin::dashboardusersave/$1');
$routes->add('/admin/dashboard/ajax/(:alpha)','Admin::ajax/$1');
$routes->add('/admin/dashboard/messages','Admin::messagemanager');
$routes->add('/admin/dashboard/messages/(:num)','Admin::messagemanager/$1');
$routes->add('/admin/dashboard/message/view','Admin::messageview');
$routes->add('/admin/dashboard/message/view/(:num)','Admin::messageview/$1');
$routes->add('/admin/chatpics','Admin::chatpicmanager');
$routes->add('/admin/chatpics/groups','Admin::chatpicmanagergroups');
$routes->add('/admin/dashboard/flags/delete/(:num)','Admin::flagdelete/$1');
$routes->add('/admin/message/send/(:num)','Admin::messagesend/$1');



$routes->get('/chatpics', 'Chatpics::index');
//$routes->get('/chatpics/pbimporter', 'Chatpics::pbImporter');
//$routes->get('/chatpics/pbimporter/keyword/(:alphanum)', 'Chatpics::keywordSearch/$1');
//$routes->get('/chatpics/pbimporter/keyword/(:alphanum)/(:num)', 'Chatpics::keywordSearch/$1/$2');




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
