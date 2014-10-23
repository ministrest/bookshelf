<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 17.10.2014
 * Time: 19:19
 */

namespace Bookshelf\Model;

class User extends ActiveRecord
{
    private $name;
    private $email;

    public function __construct($email = null)
    {
        $this->email = $email;
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    protected function getState()
    {
        return ['email' => $this->email, 'name' => $this->name];
    }

    protected function getTableName()
    {
        return 'users';
    }

    protected function setState($array)
    {
        $this->email = $array['email'];
        $this->name = $array['firstname'];
    }
} 