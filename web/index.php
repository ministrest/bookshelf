<?php
use Bookshelf\Core\Router;

require '../vendor/autoload.php';

include("../src/Bookshelf/Core/Templater.php");
$router = new Router();
$router->handleRequest($_GET);
