<?php
use Bookshelf\Core\Router;

require '../vendor/autoload.php';

$front= new Router();
$front->handleRequest($_GET);

