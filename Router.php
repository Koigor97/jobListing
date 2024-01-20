<?php

// creating a class called Router

class Router {
    // creating a protected property called routes
    protected $routes = [];


    /**
     * This method add a new route
     * 
     * @param string $method
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function registerRoute($method, $uri, $controller) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
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
     * Load error page
     *
     * @param in $httpCode
     * @return void
     */
    public function loadErrorPage($httpCode = 404) {
        http_response_code($httpCode);
        loadView("errors/{$httpCode}");
        exit;
    }
      

    /**
     * This function would route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
     public function route($uri, $method) {
         // looping through the routes
         foreach ($this->routes as $route) {
             // checking if the route matches the uri and the method
             if ($route['uri'] === $uri && $route['method'] === $method) {
                 // getting the controller
                 require base_path($route['controller']);
                 // calling the controller
                 return;
             }
         }

         // if the route does not exists
         $this->loadErrorPage();
     }


}