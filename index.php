<?php

/**
 * Get the route path from the $_SERVER
 * Get the routes and search for the appropriate controller action
 * Make a call to that action. Otherwise throw a 404 response
 */

require('vendor/autoload.php');

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route as SymfonyRoute;
use Symfony\Component\Routing\RouteCollection;


use Symfony\Component\HttpFoundation\Request;
// $context = new RequestContext('/');
// $matcher = new UrlMatcher($routes, $context);

// $parameters = $matcher->match('/goo');

// var_dump($parameters, 'heraisfghjl');


// // Define all your routes using an array
// $routes = [
// 	// path => 'controller'
	
// ];

class Route
{
	const ALLOWED_METHODS = ['get', 'post', 'put', 'delete'];
	public static $registeredRoutes = [];
	public static function __callStatic (string $methodName, $arguments) {
		if (! in_array($methodName, self::ALLOWED_METHODS)) {
			die("{$methodName} is not an HTTP method");
		}

		list($path, $controllerAction) = $arguments;

		array_push(self::$registeredRoutes, new SymfonyRoute(
			$path, // path
			[ '_controller' => $controllerAction ], // default Values
			[], // requirements
			[], // options
			'', // host
			[], // schemes
			[ucwords($methodName)], // methods:GET|POST|etc
			'' // condition
		));
	}
}

// Route Collection
$routes = new RouteCollection();

// Define all routes here
Route::get('/foo', 'MyController');
Route::get('/posts', 'Controller@getAll');
Route::get('/posts/{id}', 'Controller@getOne');
Route::post('/posts', 'Controller@createOne');
Route::put('/posts/{id}', 'Controller@updateOne');
Route::delete('/posts/{id}', 'Controller@deleteOne');

// Add all the defined routes to the $routes object
array_walk(Route::$registeredRoutes, function ($route) use ($routes) {
	$routes->add($route->getPath().$route->getMethods()[0], $route);
});




$context = new RequestContext();
// $context->fromRequest(Request::createFromGlobals());

$matcher = new UrlMatcher($routes, $context);

extract([
	'pathInfo' => $_SERVER['PATH_INFO'] ?? '',
	'queryString' => $_SERVER['QUERY_STRING'] ?? '',
	'requestMethod' => $_SERVER['REQUEST_METHOD'],
	'requestURI' => $_SERVER['REQUEST_URI'],
]);

$parameters = $matcher->match($requestURI);

var_dump($_SERVER, $parameters, 'herer');


// var_dump($);





// var_dump(Route::$registeredRoutes, 'herer');













// $routes = require './routes.php';
// $controllers = require './controllers.php';

// $requestURI = explode("/", $requestURI);
// var_dump($requestURI, 'here');

// echo $controllers[$routes[$pathInfo]](); // this is where I can pass in all the route and query parameters

// var_dump($pathInfo, $routes, $queryString);//, $_GET, 'here');
