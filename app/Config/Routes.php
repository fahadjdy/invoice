<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->post('/authLogin', 'Auth::authLogin');



$routes->get('/dashboard', 'Home::index',['filter' => 'authFilter']);


// party routes
$routes->get('/party', 'Party::index',['filter' => 'authFilter']);
$routes->post('/getPartyListAjax','Party::getPartyListAjax');
$routes->post('/deleteParty', 'Party::deleteParty',['filter' => 'authFilter']);
$routes->get('/addOrUpdateParty','Party::addOrUpdateParty',['filter' => 'authFilter']);
$routes->get('/addOrUpdateParty/(:num)','Party::addOrUpdateParty/$1',['filter' => 'authFilter']);
$routes->post('/saveParty','Party::saveParty',['filter' => 'authFilter']);

// Invoice routes
$routes->get('/invoice', 'Invoice::index',['filter' => 'authFilter']);
$routes->post('/getInvoiceListAjax','Invoice::getInvoiceListAjax');
$routes->post('/deleteInvoice', 'Invoice::deleteInvoice',['filter' => 'authFilter']);
$routes->get('/addOrUpdateInvoice','Invoice::addOrUpdateInvoice',['filter' => 'authFilter']);
$routes->get('/addOrUpdateInvoice/(:num)','Invoice::addOrUpdateInvoice/$1',['filter' => 'authFilter']);
$routes->post('/saveInvoice','Invoice::saveInvoice',['filter' => 'authFilter']);


$routes->get('/profile', 'Home::profile',['filter' => 'authFilter']);
$routes->get('/product', 'Home::product',['filter' => 'authFilter']);

// Order routes 
$routes->get('/order', 'Order::index',['filter' => 'authFilter']);

