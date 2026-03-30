<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ── API Users REST ───────────────────────────────────────────────────────────
// Genera automáticamente:
//   GET    /users          → UserController::index()
//   GET    /users/{id}     → UserController::show($id)
//   POST   /users          → UserController::create()
//   PUT    /users/{id}     → UserController::update($id)
//   DELETE /users/{id}     → UserController::delete($id)
$routes->resource('users', ['controller' => 'UserController']);