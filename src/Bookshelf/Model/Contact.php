<?php

namespace Bookshelf\Model;

/**
 * @author Kolobkov Aleksandr
 */
class Contact extends ActiveRecord
{
    const SKYPE_TYPE = 'Skype';
    const PHONE_TYPE = 'Телефон';
    const EMAIL_TYPE = 'Email';

    /**
     * Property for user contact name
     *
     * @var string
     */
    private $type;

    /**
     * Property for value of user contact
     *
     * @var string
     */
    private $value;

    /**
     * Property for id of user contact
     *
     * @var int
     */
    private $id;

    /**
     * Property very storage user id who had this contact
     *
     * @var User
     */
    private $user;

    public  static $allowableTypes = array(self::SKYPE_TYPE, self::PHONE_TYPE, self::EMAIL_TYPE);

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $name
     */
    public function setType($name)
    {
        $this->type = $name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Function that return array with all property value for contact with $id
     *
     * @return array
     */
    protected function toArray()
    {
        return [
            'name' => $this->type,
            'value' => $this->value,
            'user_id' => $this->user->getId(),
            'id' => $this->id
        ];
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'contacts';
    }

    /**
     * Method that set value in property for class instance
     *
     * @param $array
     */
    protected function initStateFromArray($array)
    {
        $this->type = $array['name'];
        $this->value = $array['value'];
        $this->id = $array['id'];
    }
}
