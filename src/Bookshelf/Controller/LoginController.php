<?php

namespace Bookshelf\Controller;
use Bookshelf\Core\Templater;

/**
 * @author Aleksandr Kolobkov
 */
class LoginController
{
    private $controllName='Login';
    private $templater;

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
     * In future will return LogIn page
     */
    public function loginAction($param)
    {
        $param['form'] = $this->getForm('a', 'b');
        $this->templater->show($this->controllName,'Login',$param);
    }

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

