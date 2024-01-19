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
    require base_path("views/{$name}.view.php");
}

/**
 * This function is going to Load the Partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name) {
    require base_path("views/partials/{$name}.php");
}
