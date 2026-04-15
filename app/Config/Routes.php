<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('users', 'User\IndexController::index');
$routes->get('users/(:num)', 'User\ShowController::show/$1');
$routes->post('users', 'User\CreateController::create');
$routes->put('users/(:num)', 'User\UpdateController::update/$1');
$routes->delete('users/(:num)', 'User\DeleteController::delete/$1');

$routes->get('movements', 'Movement\MovementsGetController::search');
$routes->get('movements/(:num)', 'Movement\MovementGetController::find/$1');
$routes->post('movements', 'Movement\MovementPostController::create');
$routes->put('movements/(:num)', 'Movement\MovementPutController::put/$1');
$routes->delete('movements/(:num)', 'Movement\MovementDeleteController::do/$1');