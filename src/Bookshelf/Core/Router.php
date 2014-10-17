<?php
namespace Bookshelf\Core;

use Bookshelf\Core\Logger\Logger;
use Exception;
use Bookshelf\Controller\ErrorController;

/**
 * @author Aleksandr Kolobkov
 */
class Router
{
    const DEFAULT_CONTROLLER = 'Main';
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    /**
     * Action that handle all request
     *
     * @param $input
     * @return mixed
     */
    public function handleRequest($input)
    {
        try {
            $controller = $this->getControllerName($input);
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                $action = $this->getActionName($input);
                if (!method_exists($controllerInstance, $action)) {
                    $this->logger->error("Controller not found in Router:handlerequest. Reason: Method $action in $controller not exists");
                    throw new Exception('Method ' . $action . ' not exist');
                }
            } else {
                $this->logger->error("Controller not found in Router:handlerequest. Reason: Class $controller not exists");
                throw new Exception('Class ' . $controller . ' not exist');
            }
        } catch (Exception $exception) {
            $controllerInstance = new ErrorController();
            $action = 'notFoundAction';
        }

        return $controllerInstance->$action();
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
            $inputInLowerCase = strtolower($input['c']);
            if (stripos($inputInLowerCase, '-') === false) {
                $name = ucfirst($inputInLowerCase);
            } else {
                $name = $this->explodeName($inputInLowerCase);
            }
        }

        return 'Bookshelf\\Controller\\' . $name . 'Controller';
    }

    /**
     * Get first part of action name and construct full name than return this name
     *
     * @param $input Had first part of action name
     * @return string action name
     */
    private function getActionName($input)
    {
        $name = 'default';
        if (isset($input['a'])) {
            $inputInLowerCase = strtolower($input['a']);
            if (stripos($inputInLowerCase, '-') === false) {
                $name = $inputInLowerCase;
            } else {
                $name = $this->explodeName($inputInLowerCase);
                }
            }

        return $name . 'Action';
    }

    /**
     * Crete action name if $_GET param had '-'
     *
     * @param $input get param from URL
     * @return string action name
     */
    private function explodeName($input)
    {
        $explodedAction = explode('-', $input);
        $actionCount = count($explodedAction);
        $name = $explodedAction[0];
        for ($i = 1; $i < $actionCount; $i++) {
            $name .= ucfirst($explodedAction[$i]);
        }

        return $name;
    }
}

