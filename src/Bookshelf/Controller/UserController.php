<?php

namespace Bookshelf\Controller;

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
        $currentUser = $this->getCurrentUser();
        if (!$currentUser) {
            $this->redirectTo("/login");
        }
        $this->render('User', 'AccountPage', ['user' => $currentUser]);
    }

    /**
     * Method that show page for change user data
     */
    public function showAction()
    {
        if($this->request->get('user_id')){
            $user = User::findOneBy(['id' => $this->request->get('user_id')]);
        } else {
            $user = $this->getCurrentUser();
        }
        $this->render('User', 'ChangeData', ['user' => $user]);
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

        $currentUser = $this->getCurrentUser();
        $user->setPassword($this->changePassword($user));
        $params['user'] = $user;
        if ($errorArray) {
            $params['user'] = $currentUser;
            $params['errors'] = $errorArray;
            $this->render('User', 'ChangeData', $params);
        }
        $this->session->set('email', $this->request->get('email'));
        $this->session->set('firstname', $this->request->get('firstname'));
        if ($user->save()) {
            $this->redirectTo("/user");
        } else {
            $params['errors']['save_fail'][] = 'Произошёл сбой при попытке сменить данные пользователя. Пожалуйста повторите попытку позднее';
            $this->logger->emergency('Cant save user in DataBase');
            return $this->render('User', 'ChangeData', $params);
        }
    }

    /**
     * This method updates user data
     */
    public function updateAction()
    {
        $idUser = $this->request->get('idUser');
        $currentUser = $this->getCurrentUser();
        if ($idUser > 0) {
            $user = User::findOneBy(['id' => $idUser]);
            $contacts = $user->getContacts();
            $this->templater->show('User', 'Update', ['currentUser' => $currentUser, 'user' => $user, 'contacts' => $contacts]);
        }
    }

    /**
     * This method helps to delete user
     */
    public function deleteAction()
    {
        if (isset($_GET['id'])) {
            $user = User::find($this->request->get('id'));

            if (!$user) {
                $this->addErrorMessage('Удаляемый пользователь не найден!');
            } else {
                $user->delete();
                $this->addSuccessMessage('Пользователь успешно удален!');
            }

            $this->redirectTo("/user/list");
        }
    }

    /**
     * This method shows all users from database
     */
    public function listAction()
    {
        $currentUser = $this->getCurrentUser();
        $users = User::findAll();
        $this->templater->show('User', 'List', ['currentUser' => $currentUser, 'users' => $users]);
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
     * Method that validate user information then user trying update his data
     *
     * @param User $user
     * @return array
     */
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

    /**
     * Method that return old password if passwords forms empty,
     * else return new password that was input in forms
     *
     * @param User $userFromDb
     * @return string
     */
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
