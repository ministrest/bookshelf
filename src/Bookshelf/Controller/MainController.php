<?php

namespace Bookshelf\Controller;
use Bookshelf\Core\Templater;

/**
 * @author Aleksandr Kolobkov
 */
class MainController
{
    /**
     * @var string default name for controller
     */
    private $controllName='Main';
    /**
     * @var var for templater instance
     */
    private $templater;

    /**
     * Magic function that create templater instance
     */
    public function __construct()
    {
        $this->templater= new Templater();
    }

    /**
     * Return default action for $this controller
     */
    public function defaultAction()
    {
        $this->indexAction();
    }

    /**
     * When execute will show Main/IndexView.html
     */
    public function indexAction()
    {
        $para = array();
        $login = new LoginController();
        $actionName = 'index';
        $param = array(
            "title" => 'Test',
            "text" => 'This is test so relax and be happy',
            "menu" => $login->getForm($para)
        );
        $this->templater->show($this->controllName, $actionName, $param);
    }
}

