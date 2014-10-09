<?php
require_once "../src/AutoLoader.php";
AutoLoader::register();

if (isset($_GET['controller']) && isset($_GET['action']) ) {
    $className = $_GET['controller'].'Controller';
    $className = ucfirst($className);
    $className = 'Controller\\'.$className;
    $actionName = $_GET['action'];
    $explodeAction = explode("-", $actionName);

    for($i=1;$i<count($explodeAction); $i++) {
        $explodeAction[$i] = ucfirst($explodeAction[$i]);
    }
    $actionName = implode("", $explodeAction);
    $actionName = $actionName.'Action';
    $contr = new $className();

    if (method_exists($contr, $actionName)) {
        $contr->$actionName();
    } else {
        echo '<br /> This method is not exist!';
    }
}



