<?php
use Bookshelf\Core\Router;

include('../vendor/autoload.php');

$router = new Router();
$router->handleRequest($_GET);

