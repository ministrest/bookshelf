<?php

namespace Bookshelf\Controller;

use Bookshelf\Core\Request;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;
use Bookshelf\Model\User;
use Bookshelf\Model\Contact;
use Bookshelf\Core\Validation\Constraint\EmailConstraint;
use Bookshelf\Core\Validation\Constraint\NotBlankConstraint;
use Bookshelf\Core\Validation\Constraint\PhoneConstraint;
use Bookshelf\Core\Validation\Validator;
use InvalidArgumentException;

/**
 * @author Aleksandr Kolobkov
 */
class ContactsController extends Controller
{

    /**
     * Method that adding contact in base for user
     */
    public function  addContactAction()
    {
        $errors = [];
        $user = User::findOneBy(['id' => $this->request->get('user_id')]);
        if ($user) {
            if ($this->request->get('contact_type')) {
                try {
                    $contact = $user->createContact($this->request->get('contact_type'), $this->request->get('value'));
                    if (!$errors) {
                        $contact->save();
                        $this->redirectTo("/user/show/?id=" . $contact->getUser()->getId());
                        exit;
                    }
                    $errors = $this->checkDataByContactType($contact);
                } catch (InvalidArgumentException $e) {
                    $errors['type'] = ['Данный тип контакта не поддерживается'];
                }
            } else {
                $errors['type'] = ['Это поле не может быть пустым'];
            }
        } else {
            $errors['contact'] = 'Пользователь не найден';
        }

        return $this->templater->show('User', 'ChangeData', ['user' => User::findOneBy(['email' => $this->session->get('email')]), 'errors' => $errors]);
    }

    /**
     * Method that show page for change user contact data
     */
    public function showContactAction()
    {
        $user = User::findOneBy(['email' => $this->session->get('email')]);
        $id = $this->request->get('contact_id');
        $contacts = $user->getContacts();
        foreach ($contacts as $contact) {
            if ($id == $contact->getId()) {
                return $this->templater->show('Contact', 'ChangeContactsData', ['contact' => $contact]);
            }
        }
        $errors['contact'] = 'Контакт не найден';

        return $this->templater->show('User', 'ChangeData', ['user' => $user, 'errors' => $errors]);
    }

    /**
     * Method that update data for user contact then he want change it
     */
    public function changeDataAction()
    {
        $user = User::findOneBy(['email' => $this->session->get('email')]);
        $id = $this->request->get('contact_id');
        $contacts = $user->getContacts();
        foreach ($contacts as $contact) {
            if ($id == $contact->getId()) {

                $contact->setType($this->request->get('contact_type'));
                $contact->setValue($this->request->get('value'));

                $errors = $this->checkDataByContactType($contact);
                if (!$errors) {
                    $contact->save();
                    $this->redirectTo("/user/show/?id=" . $contact->getUser()->getId());
                    exit;
                }
            }
        }
        $errors['contact'] = 'Контакт не найден';

        return $this->templater->show('Contact', 'ChangeContactsData', ['contact' => $contacts[$id], 'errors' => $errors]);
    }

    /**
     * Method that delete contact from user
     */
    public function deleteContactsDataAction()
    {
        $user = User::findOneBy(['email' => $this->session->get('email')]);
        $id = $this->request->get('contact_id');
        $contacts = $user->getContacts();
        foreach ($contacts as $contact) {
            if ($id == $contact->getId()) {
                $contact->delete();
                $this->redirectTo("/user/show/?id=" . $contact->getUser()->getId());
                exit;
            }
        }
        $errors['contact'] = 'Немогу удалить несуществующий контакт';

        return $this->templater->show('User', 'ChangeData', ['user' => $user, 'errors' => $errors]);
    }

    /**
     * Method that check that type of contact was send by user
     *
     * @param Contact $contact
     * @return array
     */
    private function checkDataByContactType(Contact $contact)
    {
        $validator = new Validator();
        $notBlankValue = new NotBlankConstraint($contact, 'value');
        $validator->addConstraint($notBlankValue);
        if ($contact->getType() === Contact::EMAIL_TYPE) {
            $email = new EmailConstraint($contact, 'value');
            $validator->addConstraint($email);
        } elseif ($contact->getType() === Contact::PHONE_TYPE) {
            $phone = new PhoneConstraint($contact, 'value');
            $validator->addConstraint($phone);
        }

        return $validator->validate();
    }
}
