<?php

namespace Bookshelf\Controller;

use Bookshelf\Core\Logger\Logger;
use Bookshelf\Core\Request;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;
use Bookshelf\Model\User;
use Bookshelf\Core\Validation\Constraint\EmailConstraint;
use Bookshelf\Core\Validation\Constraint\AlphabeticalConstraint;
use Bookshelf\Core\Validation\Constraint\NotBlankConstraint;
use Bookshelf\Core\Validation\Constraint\ConfirmConstraint;
use Bookshelf\Core\Validation\Validator;


/**
 * @author Aleksandr Kolobkov
 */
class UserController extends Controller
{

    /**
     * Default method that show user account page
     */
    public function defaultAction()
    {
        $email = $this->session->get('email');
        if (!empty($email)) {
            $user = User::findOneBy(['email' => $email]);
            $user->getContacts();
            $this->templater->show('User', 'AccountPage', $user);
        } else {
            $this->redirectTo("/login");
            exit;
        }
    }

    /**
     * Method that show page for change user data
     */
    public function showAction()

    {
        $user = User::findOneBy(['id' => $this->request->get('id')]);
        $this->templater->show('User', 'ChangeData', ['user' => $user]);
    }

    /**
     * Method that update user data after changing
     */
    public function changeUserDataAction()
    {
        $user = new User();
        $user->setFirstName($this->request->get('firstname'));
        $user->setEmail($this->request->get('email'));
        $user->setLastName($this->request->get('lastname'));
        $user->setPassword($this->request->get('password'));
        $errorArray = $this->validateUserUpdate($user);

        $userFromDb = User::findOneBy(['email' => $this->session->get('email')]);
        $userFromDb->getContacts();
        $user->setPassword($this->changePassword($userFromDb));
        $params['user'] = $user;
        if ($errorArray) {
            $params['user'] = $userFromDb;
            $params['errors'] = $errorArray;
            $this->templater->show('User', 'ChangeData', $params);
        }
        $this->session->set('email', $this->request->get('email'));
        $this->session->set('firstname', $this->request->get('firstname'));
        if ($user->save()) {
            $this->redirectTo("/user");
            exit;
        } else {
            $params['errors']['save_fail'][] = 'Произошёл сбой при попытке сменить данные пользователя. Пожалуйста повторите попытку позднее';
            $this->logger->emergency('Cant save user in DataBase');
            return $this->templater->show('User', 'ChangeData', $params);
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

    private function validateUserUpdate($user)
    {
        $constraints = [
            'firstname' => new AlphabeticalConstraint($user, 'firstname', "Имя должно состоять только из букв"),
            'lastname' => new AlphabeticalConstraint($user, 'lastname', "Фамилия должна состоять только из букв"),
            'firstnameBlank' => new NotBlankConstraint($user, 'firstname'),
            'lastnameBlank' => new NotBlankConstraint($user, 'lastname'),
            'emailName' => new EmailConstraint($user, 'email'),
            'emailBlank' => new NotBlankConstraint($user, 'email'),
            'passwordConfirm' => new ConfirmConstraint($user, $this->request->get('confirm_password'), 'password')
        ];

        return $this->validate($constraints);
    }

    private function changePassword($userFromDb)
    {
        $confirmPassword = $this->request->get('confirm_password');
        $password = $this->request->get('password');
        if (empty($password) && empty($confirmPassword)) {
            return $userFromDb->getPassword();
        } else {
            return $this->request->get('password');
        }
    }
}