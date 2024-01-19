<?php
// bringing the helpers.php file
require '../helpers.php';


require base_path('Router.php');

// creating a new instance of the Router
$router = new Router();

$routes = require base_path('routes.php');

// getting the current route
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
