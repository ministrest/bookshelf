<?php

namespace Bookshelf\Controller;
use Bookshelf\Core\Templater;

/**
 * @author Aleksandr Kolobkov
 */
class LoginController
{
    private $userData = array(
        'email' => 'Test',
        'password' => '123',
        'loginStatus' => null
    );

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
    public function defaultAction($param)
    {
        $this->loginAction($param);
    }

    /**
     * Show html forms for logIn
     *
     * @param $param
     */
    public function loginAction()
    {
        if($_POST['email'] === $this->userData['email'] && $_POST['password'] === $this->userData['password']) {
            echo "Welcome back {$_POST['email']}";
        } else {
            echo 'Oops something wrong';
        }
    }

    public function getLoginForm($param)
    {
        $this->templater->show($this->controllName, 'Form', $param);
    }

    /**
     * Create new html forms
     *
     * @param null $name
     * @param null $pass
     */
    public function getForm($name = null, $pass = null)
    {
        return $this->templater->render($this->controllName, 'Form', [$name, $pass]);
    }

    /**
     * In future will return LogOut page
     */
    public function logoutAction()
    {
        echo "This is logout page";
    }

    public function registerFormAction()
    {
        $this->templater->show($this->controllName, 'RegisterForm', null);
    }
    /**
     * In future will return Register page
     */
    public function registerAction()
    {
       if($this->checkRegistrationPassword($_POST['password'], $_POST['confirm_password'])) {
           $this->userData['email'] = $_POST['email'];
           $this->userData['password'] = $_POST['password'];
           echo "Welcome {$_POST['email']}";
       } else {
           $this->templater->param['loginValue'] = $_POST['email'];

           return $this->templater->show($this->controllName, 'RegisterForm', null);
       }
    }

    private function checkRegistrationPassword($password, $confirmPassword)
    {
        return ($password !== '' && $confirmPassword !== '' && $password === $confirmPassword);
    }
}

