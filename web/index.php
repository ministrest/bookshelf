<?php
use Bookshelf\Core\Router;
use Bookshelf\Core\Session;

include('../vendor/autoload.php');

$session = new Session();
$session ->initSession();
$router = new Router();
$router->handleRequest($_GET);

