<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
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


// product routes
$routes->get('/product', 'Product::index',['filter' => 'authFilter']);
$routes->post('/getProductListAjax','Product::getProductListAjax');
$routes->post('/deleteProduct', 'Product::deleteProduct',['filter' => 'authFilter']);
$routes->get('/addOrUpdateProduct','Product::addOrUpdateProduct',['filter' => 'authFilter']);
$routes->get('/addOrUpdateProduct/(:num)','Product::addOrUpdateProduct/$1',['filter' => 'authFilter']);
$routes->post('/saveProduct','Product::saveProduct',['filter' => 'authFilter']);


// location routes
$routes->get('/location', 'Location::index',['filter' => 'authFilter']);
$routes->post('/getLocationListAjax','Location::getLocationListAjax');
$routes->post('/deleteLocation', 'Location::deleteLocation',['filter' => 'authFilter']);
$routes->get('/addOrUpdateLocation','Location::addOrUpdateLocation',['filter' => 'authFilter']);
$routes->get('/addOrUpdateLocation/(:num)','Location::addOrUpdateLocation/$1',['filter' => 'authFilter']);
$routes->post('/saveLocation','Location::saveLocation',['filter' => 'authFilter']);


// Invoice routes
$routes->get('/config/invoice', 'Invoice::index',['filter' => 'authFilter']);
$routes->post('/config/invoice/getInvoiceListAjax','Invoice::getInvoiceListAjax');
$routes->post('/config/invoice/deleteInvoice', 'Invoice::deleteInvoice',['filter' => 'authFilter']);
$routes->get('/config/invoice/addOrUpdateInvoice','Invoice::addOrUpdateInvoice',['filter' => 'authFilter']);
$routes->get('/config/invoice/addOrUpdateInvoice/(:num)','Invoice::addOrUpdateInvoice/$1',['filter' => 'authFilter']);
$routes->post('/config/invoice/saveInvoice','Invoice::saveInvoice',['filter' => 'authFilter']);


$routes->get('/config/price', 'Config::price',['filter' => 'authFilter']);
$routes->post('/config/price/getPriceListAjax', 'Config::getPriceListAjax',['filter' => 'authFilter']);
$routes->get('/config/price/addOrUpdatePrice', 'Config::addOrUpdatePrice',['filter' => 'authFilter']);
$routes->get('/config/price/addOrUpdatePrice/(:num)','Config::addOrUpdatePrice/$1',['filter' => 'authFilter']);
$routes->post('/config/price/savePrice','Config::savePrice',['filter' => 'authFilter']);
$routes->post('/config/price/deletePrice', 'Config::deletePrice',['filter' => 'authFilter']);


$routes->get('/profile', 'Home::profile',['filter' => 'authFilter']);
$routes->post('/updateProfile', 'Home::updateProfile',['filter' => 'authFilter']);


// Order routes 
$routes->get('/order', 'Order::index',['filter' => 'authFilter']);

