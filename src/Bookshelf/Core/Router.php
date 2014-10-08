<?php
namespace Bookshelf\Core;

use Exception;
use Bookshelf\Controller\ErrorController;

/**
 * @author Aleksandr Kolobkov
 */
class Router
{
    const DEFAULT_CONTROLLER = 'Main';

    /**
     * @param $input
     * @return mixed
     */
    public function handleRequest($input)
    {
        try {
            $controller = $this->getControllerName($input);
            if (class_exists($controller)) {
                $controllerInstance = new $controller;
                $action = $this->getActionName($input);
                if (!method_exists($controllerInstance, $action)) {
                    throw new Exception('Method ' . $action . ' not exist');
                }
            } else {
                throw new Exception('Class ' . $controller . ' not exist');
            }
        } catch (Exception $exception) {
            $controllerInstance = new ErrorController();
            $action = 'notFoundAction';
        }

        return $controllerInstance->$action;
    }

    /**
     * Get first part of controller name and construct full name with namespace and return this name
     *
     * @param $input  Had first part of controller name
     * @return string
     */
    private function getControllerName($input)
    {
        $name = self::DEFAULT_CONTROLLER;
        if (isset($input['c'])) {
            $name = ucfirst(strtolower($input['c']));
        }

        return 'Bookshelf\Controller\\' . $name . 'Controller';
    }

    /**
     * Get first part of action name and construct full name than return this name
     *
     * @param $input Had first part of action name
     * @return string
     */
    private function getActionName($input)
    {
        $name = 'default';
        if (isset($input['a'])) {
            if (stripos($input['a'], '-') === false) {
                $name = strtolower($input['a']);
            } else {
                $explodedAction = explode("-", strtolower($input['a']));
                $actionCount = count($explodedAction);
                $name = $explodedAction[0];
                for ($i = 1; $i < $actionCount; $i++) {
                    $name .= ucfirst($explodedAction[$i]);
                }
            }
        }

        return $name.'Action';
    }

}

