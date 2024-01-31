<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
// bringing the helpers.php file
require '../helpers.php';

use Framework\Router;

// creating a instance of the Router
$router = new Router();

// getting the routes
$routes = require base_path('routes.php');

// getting the current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 
// Route to the requested 
$router->route($uri);
