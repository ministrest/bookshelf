<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Controller;

use Bookshelf\Core\Logger\Logger;
use Bookshelf\Core\Request;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;

abstract class Controller {
    /**
     * @var var for Logger class instance
     */
    private $logger;

    /**
     * @var var for Templater class instance
     */
    protected  $templater;

    /**
     * @var array Request
     */
    protected  $request;

    /**
     * @var Session
     */
    protected  $session;

    public function __construct()
    {
        $this->logger= new Logger('../logs/');
        $this->templater = new Templater();
        $this->request = new Request($_GET, $_POST);
        $this->session = new Session();
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     */
    protected function render($controllerName, $actionName, $params = [])
    {
        $params['flashMessages'] = $this->session->getFlashMessages();
        $this->templater->show($controllerName, $actionName, $params);
        $this->session->delete('flashMessages');
    }


    protected  function redirectTo($route)
    {
        header('Location: ' . $route);
        exit;
    }
}