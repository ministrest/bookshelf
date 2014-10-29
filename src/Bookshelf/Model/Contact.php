<?php

namespace Bookshelf\Model;

use Bookshelf\Core\Db;

/**
 * @author Kolobkov Aleksandr
 */
class Contact extends ActiveRecord
{
    /**
     * Property for user contact name
     *
     * @var string
     */
    private $contactName;

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
     * @var int
     */
    private $userId;

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * @param string $name
     */
    public function setContactName($name)
    {
        $this->contactName = $name;
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
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Method that return all contacts that have user with $userId
     *
     * @param $userId
     * @return array
     */
    public function getContactDataByUser($userId)
    {
        $db = Db::getInstance();
        $resultArray = $db->fetchBy($this->getTableName(), ['user_id' => $userId]);
        $contacts = [];
        foreach ($resultArray as $value) {
            $contacts["{$value['id']}"] = new Contact();
            $contacts["{$value['id']}"]->setState($value);
        }


        return $contacts;
    }

    /**
     * Function that return array with all property value for contact with $id
     *
     * @return array
     */
    protected function getState()
    {
        return [
            'name' => $this->contactName,
            'value' => $this->value,
            'user_id' => $this->userId,
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
    protected function setState($array)
    {
        $this->contactName = $array['name'];
        $this->value = $array['value'];
        $this->userId = $array['user_id'];
        $this->id = $array['id'];
    }
}
