<?php
/*
 * Front controller
 */

/*
 * Twig
 */
require_once dirname(__DIR__) . '/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

/**
 * Autoloader
 */
spl_autoload_register(function($class) {
    $root = dirname(__DIR__); // get parent dir (root of the site)
    $file = $root.'/'.str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

/**
 * Error and Exception handling
 */
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = new Core\Router();

// Add routes
$router->add('', ['controller' => 'Home', 'action'=>'index']);
$router->add('posts', ['controller' => 'Posts', 'action'=>'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);