<?php

/**
 * This function get the base path 
 * 
 * @param string $path
 * @return string
 */
 function base_path($path = '') {
     return __DIR__ . '/' . $path;
 }


/**
 * This is going to Load the View
 * 
 * @param string $name
 * @return void
 */
function loadView($name) {
    $viewPath = base_path("views/{$name}.view.php");

    // Check if the file exists
    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        echo "The view {$name} does not exists";
    }
   
}

/**
 * This function is going to Load the Partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name) {
    $partialPath = base_path("views/partials/{$name}.php");
    

    // Check if the file exists
    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "The partial {$name} does not exists";
    }
}

/**
 * This function inspect a value(e)
 * 
 * @param mixed $data
 * @return void
 */ 
function inspect($data) {
    echo '<pre>';
    (var_dump($data));
    echo '</pre>';
}

/**
 * Inspecta value and die
 * 
 * @param mixed $data
 * @return void
 */ 
 function inspectValueAndDie($data) {
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
 }