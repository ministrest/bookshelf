<?php

namespace Bookshelf\Controller;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;

/**
 * @author Aleksandr Kolobkov
 */
class LoginController
{
    /**
     * @var array temp var for test login function
     */
    private $userData = array(
        'email' => 'Test',
        'password' => '123',
        'loginStatus' => null
    );

    private $session;

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
        $this->session = new Session();
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
     */
    public function loginAction()
    {
        if($this->checkUsernameAndPassword($_POST['email'], $_POST['password'])) {
            $this->session->setSessionData('email', $_POST['email']);
            $this->session->setSessionData('logInStatus', 1);
            $this->templater->show($this->controllName, 'LoginSuccess', ['email' => $this->session->getSessionData('email')]);
        } else {
            echo 'Oops something wrong';
        }
    }

    /**
     * Method that create login form on page
     */
    public function getLoginForm()
    {
        return $this->templater->render($this->controllName, 'Form', null);
    }

    /**
     * In future will return LogOut page
     */
    public function logoutAction()
    {
        echo "This is logout page";
        $this->session->setSessionData('logInStatus', 0);
    }

    /**
     * Method that create register form
     */
    public function registerFormAction()
    {
        $this->templater->show($this->controllName, 'RegisterForm', null);
    }

    /**
     * Create register page and storage user data in array( for now)
     * If passwords don't match recreate register and fill username line with value from last try
     */
    public function registerAction()
    {
       if($this->checkRegistrationPassword($_POST['password'], $_POST['confirm_password'])) {
           $this->userData['email'] = $_POST['email'];
           $this->userData['password'] = $_POST['password'];
           echo "Welcome {$_POST['email']}";
       } else {
           $this->templater->param['loginValue'] = $_POST['email'];
           $this->templater->show($this->controllName, 'RegisterForm', null);
       }
    }

    public function sessionTestAction()
    {
        if($this->session->getSessionData('logInStatus') === 1){
            $param = ['email' => $this->session->getSessionData('email')];
            $this->templater->show($this->controllName, 'SessionTest', $param);
        } else {
            $this->templater->show($this->controllName, 'Form', null);
        }

    }

    /**
     * Method that check passwords match
     *
     * @param $password
     * @param $confirmPassword
     * @return bool
     */
    private function checkRegistrationPassword($password, $confirmPassword)
    {
        return ($password !== '' && $confirmPassword !== '' && $password === $confirmPassword);
    }

    /**
     * Method that check if this combination of username and password exist in our BD(in future)
     *
     * @param $username
     * @param $password
     * @return bool
     */
    private function checkUsernameAndPassword($username, $password)
    {
        return ($username === $this->userData['email'] && $password === $this->userData['password']);
    }
}

