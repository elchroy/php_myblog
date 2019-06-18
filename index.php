<?php

/**
 * Get the route path from the $_SERVER
 * Get the routes and search for the appropriate controller action
 * Make a call to that action. Otherwise throw a 404 response
 */

$routes = require './routes.php';
$controllers = require './controllers.php';


var_dump($_SERVER);//, $_GET, 'here');

extract([
	'pathInfo' => $_SERVER['PATH_INFO'] ?? '',
	'queryString' => $_SERVER['QUERY_STRING'] ?? '',
	'requestURI' => $_SERVER['REQUEST_URI'],
]);

$requestURI = explode("/", $requestURI);
var_dump($requestURI, 'here');

echo $controllers[$routes[$pathInfo]](); // this is where I can pass in all the route and query parameters

// var_dump($pathInfo, $routes, $queryString);//, $_GET, 'here');
