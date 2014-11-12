<?php

namespace Bookshelf\Controller;

use Bookshelf\Core\Logger\Logger;
use Bookshelf\Core\Request;
use Bookshelf\Core\Validation\Constraint\EmailConstraint;
use Bookshelf\Core\Validation\Constraint\AlphabeticalConstraint;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;
use Bookshelf\Core\Validation\Constraint\NotBlankConstraint;
use Bookshelf\Core\Validation\Constraint\ConfirmConstraint;
use Bookshelf\Core\Validation\Constraint\UniqueConstraint;
use Bookshelf\Core\Validation\Validator;
use Bookshelf\Model\User;
use Bookshelf\Model\ActiveRecord;

/**
 * @author Aleksandr Kolobkov
 */
class LoginController
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var string default name for controller
     */
    private $controllName = 'Login';
    /**
     * @var Templater
     */
    private $templater;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * Function that create templater class instance
     */
    public function __construct()
    {
        $this->templater = new Templater();
        $this->request = new Request($_GET, $_POST);
        $this->session = new Session();
        $this->logger = new Logger('../logs/');
    }

    /**
     * Default action for $this class
     */
    public function defaultAction()
    {
        $this->showLoginForm();
    }

    /**
     * Search user in Db and set email and firstname in session
     */
    public function loginAction()
    {
        $user = User::findOneBy([
            'email' => $this->request->get('email'),
            'password' => $this->request->get('password')
        ]);

        if ($user) {
            $this->session->set('email', $user->getEmail());
            $this->session->set('firstname', $user->getFirstName());
            header("Location: /books");
            exit;
        }

        $params = [
            'email' => $this->request->get('email'),
            'errors' => ['email' => ['Пользователя нет']]
        ];

        return $this->templater->show($this->controllName, 'Form', $params);


        $user = new User;
        $user->setEmail($this->request->get('email'));
        $user->setPassword($this->request->get('password'));
        $errorArray = $this->loginValidate($user);
        if ($errorArray) {
            $params = [
                'email' => $this->request->get('email'),
                'errors' => $errorArray
            ];

            return $this->templater->show($this->controllName, 'Form', $params);
        }
        $user = User::findOneBy(['email' => $this->request->get('email')]);
        $this->session->set('email', $user->getEmail());
        $this->session->set('firstname', $user->getFirstName());
        header("Location: /");
        exit;
    }

    /**
     * Method that create login form on page
     */
    public function showLoginForm()
    {
        return $this->templater->show($this->controllName, 'Form');
    }

    /**
     * Delete email from session
     */
    public function logoutAction()
    {
        $this->session->delete('email');
        $this->session->delete('firstname');
        header("Location: /");
        exit;
    }

    /**
     * Method that create register form
     */
    public function registerFormAction()
    {
        $user = new User();
        $this->templater->show($this->controllName, 'RegisterForm', ['user' => $user]);
    }

    /**
     * Create register page
     * If found error then recreate register and fill username line with value from last try
     */
    public function registerAction()
    {
        $user = new User();
        $user->setFirstName($this->request->get('firstname'));
        $user->setEmail($this->request->get('email'));
        $user->setLastName($this->request->get('lastname'));
        $user->setPassword($this->request->get('password'));
        $params['user'] = $user;

        $errorArray = $this->registrationValidate($user);
        if ($errorArray) {
            $params['errors'] = $errorArray;

            return $this->templater->show($this->controllName, 'RegisterForm', $params);
        }
        if ($user->save()) {
            $this->session->set('email', $user->getEmail());
            $this->session->set('firstname', $user->getFirstName());
            header("Location: /");
            exit;
        } else {
            $params['errors']['save_fail'][] = 'На данный момент регистрация не возможна, пожалуйста повторите попытку позднее';
            $this->logger->emergency('Cant save user in DataBase');
            return $this->templater->show($this->controllName, 'RegisterForm', $params);
        }

    }

    /**
     * Method that used constraints from array for data validate
     *
     * @param $constraints array
     * @return array
     */
    private function validate($constraints)
    {
        $validator = new Validator();
        foreach ($constraints as $constraint) {
            $validator->addConstraint($constraint);
        }

        return $validator->validate();
    }

    /**
     * @param ActiveRecord $model
     * @return array
     */
    private function loginValidate(ActiveRecord $user)
    {
        $constraintList = [
            'emailBlank' => new NotBlankConstraint($user, 'email'),
            'passwordBlank' => new NotBlankConstraint($user, 'password'),
        ];

        $errors = $this->validate($constraintList);

        if (!empty($errors)) {
            $findUser = User::findOneBy([
                'email' => $this->request->get('email'),
                'password' => $this->request->get('password')
            ]);
            if (!$findUser) {
                $errors['email'][] = 'Пользователя не существует';
            }
        }

        return $errors;
    }

    /**
     * @param ActiveRecord $model
     * @return array
     */
    private function registrationValidate(ActiveRecord $model)
    {
        $constraintList = [
            'firstnameBlank' => new NotBlankConstraint($model, 'firstname'),
            'lastnameBlank' => new NotBlankConstraint($model, 'lastname'),
            'emailBlank' => new NotBlankConstraint($model, 'email'),
            'passwordBlank' => new NotBlankConstraint($model, 'password'),
            'firstname' => new AlphabeticalConstraint($model, 'firstname', "Имя должно состоять только из букв"),
            'lastname' => new AlphabeticalConstraint($model, 'lastname', "Фамилия должна состоять только из букв"),
            'emailUnique' => new UniqueConstraint($model, 'email'),
            'emailName' => new EmailConstraint($model, 'email'),
            'passwordConfirm' => new ConfirmConstraint($model, $this->request->get('confirm_password'), 'password')
        ];

        return $this->validate($constraintList);
    }
}
