<?php

namespace Bookshelf\Controller;
use Bookshelf\Core\Templater;

/**
 * @author Aleksandr Kolobkov
 */
class LoginController
{
    /**
     * @var string default name for controller
     */
    private $controllName='Login';
    /**
     * @var var for Templater class instance
     */
    private $templater;

    /**
     * Magic function that create templater class instance
     */
    public function __construct()
    {
        $this->templater = new Templater();
    }
    /**
     * Default action for $this class
     */
    public function defaultAction()
    {
        $this->loginAction();
    }

    /**
     * Show html forms for logIn
     *
     * @param $param
     */
    public function loginAction($param)
    {
        $param['form'] = $this->getForm('a', 'b');
        $this->templater->show($this->controllName,'Login',$param);
    }

    /**
     * Create new html forms
     *
     * @param null $name
     * @param null $pass
     */
    public function getForm($name = null, $pass = null)
    {
        return $this->templater->render($this->controllName,'Form', [$name, $pass]);
    }

    /**
     * In future will return LogOut page
     */
    public function logoutAction()
    {
        echo "This is logout page";
    }

    /**
     * In future will return Register page
     */
    public function registerAction()
    {
        echo "This is register page";
    }
}

