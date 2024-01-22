<?php

namespace Framework;

use App\Controllers\ErrorController;

// creating a class called Router
class Router {
    // creating a protected property called routes
    protected $routes = [];


    /**
     * This method add a new route
     * 
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action) {
        // getting the controller and the method
        [$controller, $controllerMethod] = explode('@', $action);

        // adding the route to the routes array
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * This method add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
     function get($uri, $controller) {
         $this->registerRoute('GET', $uri, $controller);
     }


    /**
     * This method add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
     function post($uri, $controller) {
        $this->registerRoute('POST', $uri, $controller);
     }


    /**
     * This method add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
     function put($uri, $controller) {
        $this->registerRoute('PUT', $uri, $controller);
     }


    /**
     * This method add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
     function delete($uri, $controller) {
         $this->registerRoute('DELETE', $uri, $controller);
     }

    /**
     * This function would route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
     public function route($uri) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
         // looping through the routes
         foreach ($this->routes as $route) {
            // split the current route uri into an array
            $uriSegments = explode('/', trim($uri, '/'));
            // split the route uri into an array
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

            // checking if the route segments and the uri segments are the same
            if (count($uriSegments) === count($routeSegments) && $requestMethod === strtoupper($route['method'])) {
                $params = [];
                $match = true;

                // looping through the route segments
                for ($i = 0; $i < count($uriSegments); $i++) {
                    // check if uri does not match the route and the route segment is not a parameter
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    // check if the route segment is a parameter and add it to the params array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }

                    if ($match) {
                         //extracting the controller and the method
                        $controller = 'App\\Controllers\\' . $route['controller'];
                        $controllerMethod = $route['controllerMethod'];

                        // instantiating the controller and calling the method
                        $controllerInstance = new $controller();
                        $controllerInstance->$controllerMethod($params);

                        return;

                    }
                }
            }

         }

         // if the route does not exists
         ErrorController::notFound();
     }


}