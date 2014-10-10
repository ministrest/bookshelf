<?php

use Controller\ErrorController;

/**
 * @author Danil Vasiliev <danil.vasiliev@opensoftdev.ru>
 */
class Router
{
    /**
     * @param string $controllerName
     * @param string $actionName
     * @return mixed
     */
    public function run($controllerName, $actionName)
    {
        $className = $this->getControllerName($controllerName);
        $fullActionName = $this->getActionName($actionName);

        try {
            if (class_exists($className)) {
                $controller = new $className();
                if (method_exists($controller, $fullActionName)) {
                    $action = $fullActionName;
                } else {
                    throw new Exception('Method '.$fullActionName.' not exist');
                }
            } else {
                throw new Exception('Class '.$className.' not exist');
            }
        } catch (Exception $exception) {
            $controller = new ErrorController();
            $action = 'notFoundAction';
        }
        return $controller->$action();
    }

    /**
     * @param string $controllerName
     * @return string
     */
    private function getControllerName($controllerName)
    {
        $fullControllerName = $controllerName . 'Controller';
        $fullControllerName = ucfirst($fullControllerName);
        $className = 'Controller\\' . $fullControllerName;

        return $className;
    }

    /**
     * @param string $actionName
     * @return string
     */
    private function getActionName($actionName)
    {
        $explodedAction = explode("-", $actionName);
        $actionsCount = count($explodedAction);
        $fullActionName = $explodedAction[0];
        for ($i = 1; $i < $actionsCount; $i++) {
            $fullActionName .= ucfirst($explodedAction[$i]);
        }
        $fullActionName = $fullActionName . 'Action';
        return $fullActionName;

    }
}
