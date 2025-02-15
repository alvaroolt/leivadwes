<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once('../vendor/autoload.php');

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use App\Models\Blog;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'symblog',
    'username'  => 'symblog',
    'password'  => 'symblog',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);


// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();

$map->get('index', '/symblogComposerCopia/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);

$map->get('addBlog', '/symblogComposerCopia/blogs/add', [
    'controller' => 'App\Controllers\BlogsController',
    'action' => 'getAddBlogAction'
]);
$map->post('saveBlog', '/symblogComposerCopia/blogs/add', [
    'controller' => 'App\Controllers\BlogsController',
    'action' => 'getAddBlogAction'
]);

$map->get('contact', '/symblogComposerCopia/contact', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'contactAction'
]);

$map->get('about', '/symblogComposerCopia/about', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'aboutAction'
]);

$map->get('show', '/symblogComposerCopia/blogs/show', [
    'controller' => 'App\Controllers\BlogsController',
    'action' => 'showBlogAction'
]);
$map->get('addUser', '/symblogComposerCopia/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUserAction'
]);

$map->post('saveUser', '/symblogComposerCopia/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUserAction'
]);

$map->get("formLogin", "/symblogComposerCopia/formLogin", [
    "controller" => "App\Controllers\AuthController",
    "action" => "formLogin"
]);

$map->post("login", "/symblogComposerCopia/formLogin", [
    "controller" => "App\Controllers\AuthController",
    "action" => "postLogin"
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);
if (!$route) {
    echo "No route";
} else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];

    $controller = new $controllerName;
    echo $controller->$actionName($request);
}
