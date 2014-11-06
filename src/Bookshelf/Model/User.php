<?php

namespace Bookshelf\Model;

/**
 * @author Aleksandr Kolobkov
 */
class User extends ActiveRecord
{
    /**
     * Data about user contacts will be placed here
     *
     * @var Contact[]
     */
    private $contacts;

    /**
     * Data about user books will be placed here
     *
     * @var Book[]
     */
    private $books;


    /**
     * Property for user firstname
     *
     * @var string
     */
    private $firstName;

    /**
     * Property for user lastname
     *
     * @var string
     */
    private $lastName;

    /**
     * Property for user email
     *
     * @var string
     */
    private $email;

    /**
     * Property for user password
     *
     * @var string
     */
    private $password;

    /**
     * Property for user id
     *
     * @var int
     */
    private $id;

    /**
     * Method that will return array of book instances
     *
     * @return array
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * Method that will fill data about user books from outside
     *
     * @param array $booksData
     */
    public function setBooks($booksData)
    {
        $this->books = $booksData;
    }

    /**
     * Method that return data about user contacts
     *
     * @return array
     */
    public function getContacts()
    {
        if (empty($this->contacts)) {
            $this->fetchContacts();
        }

        return $this->contacts;
    }

    /**
     * Method that will add contacts to user
     *
     * @param $arrayOfContacts array
     */
    public function setContacts($arrayOfContacts)
    {
        foreach ($arrayOfContacts as $contact) {
            $contact->setUserId($this->getId());
            $contact->save();
            $contact->getId();
            $this->contacts[] = $contact;
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email string
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Return all property for user
     *
     * @return array
     */
    protected function toArray()
    {
        return [
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'id' => $this->id
        ];
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'users';
    }

    /**
     * Set value in user instance class from array
     *
     * @param $array
     */
    protected function initStateFromArray($array)
    {
        $this->firstName = $array['firstname'];
        $this->lastName = $array['lastname'];
        $this->email = $array['email'];
        $this->password = $array['password'];
        $this->id = $array['id'];
    }

    /**
     * Method that will take data from books table and fill property for class instance
     */
    private function fetchBooks()
    {
        // TODO will be added code that will search book database for all books for this user
    }

    /**
     * Method that will take data from contacts table and fill property for class instance
     */
    private function fetchContacts()
    {
        $this->contacts = Contact::findBy(['user_id' => $this->getId()]);
    }
}
