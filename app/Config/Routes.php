<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('movements', 'Movement\MovementsGetController::search');
$routes->get('movements/(:num)', 'Movement\MovementGetController::find/$1');
$routes->post('movements', 'Movement\MovementPostController::create');
$routes->put('movements/(:num)', 'Movement\MovementPutController::put/$1');
$routes->delete('movements/(:num)', 'Movement\MovementDeleteController::do/$1');

$routes->get('teachers', 'Teacher\TeachersGetController::search');
$routes->get('teachers/(:num)', 'Teacher\TeacherGetController::find/$1');
$routes->post('teachers', 'Teacher\TeacherPostController::create');
$routes->put('teachers/(:num)', 'Teacher\TeacherPutController::put/$1');
$routes->delete('teachers/(:num)', 'Teacher\TeacherDeleteController::do/$1');

$routes->get('users', 'User\UsersGetController::search');
$routes->get('users/(:num)', 'User\UserGetController::find/$1');
$routes->post('users', 'User\UserPostController::create');
$routes->put('users/(:num)', 'User\UserPutController::put/$1');
$routes->delete('users/(:num)', 'User\UserDeleteController::do/$1');