<?php
use Bookshelf\Core\Router;

require_once "../vendor/autoload.php";

if (isset($_GET['controller']) && isset($_GET['action']) ) {
    $controllerName = $_GET['controller'];
    $actionName = $_GET['action'];
    $router = new Router();
    $router->run($controllerName, $actionName);
}
