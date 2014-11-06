<?php

namespace Bookshelf\Model;

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
     * @param mixed $value
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
    protected function initStateFromArray($array)
    {
        $this->type = $array['name'];
        $this->value = $array['value'];
        $this->userId = $array['user_id'];
        $this->id = $array['id'];
    }
}
