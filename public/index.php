<?php
// bringing the helpers.php file
require '../helpers.php';
// gettig the router.php file
require base_path('Router.php');
// bringing the Database.php file
require base_path('Database.php');

// creating a instance of the Router
$router = new Router();

// getting the routes
$routes = require base_path('routes.php');

// getting the current URI and HTTP method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Route to the requested 
$router->route($uri, $method);
