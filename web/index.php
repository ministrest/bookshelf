<?php
use Bookshelf\Core\Router;

require '../vendor/autoload.php';

include("../src/Bookshelf/Core/Templater.php");
$router = new Router();
$router->handleRequest($_GET);
#$addnewForm='addNewForm(Login,Login)';




//$front= new Router();
//$viewOptions = $front->handleRequest($_GET);
//create renderer
//pass controller, action to finda view file
//pass view options
//call render to display page

//echo sprintf('Hello %s', $viewOptions['user']);

