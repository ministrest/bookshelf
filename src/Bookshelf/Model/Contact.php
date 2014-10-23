<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 17.10.2014
 * Time: 20:18
 */

namespace Bookshelf\Model;


class Contact extends ActiveRecord
{
    private $name;
    private $value;

    public function __construct($name = null, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
        parent::__construct();
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

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }






    protected function getState()
    {
        return ['name' => $this->name, 'value' => $this->value];
    }

    protected function getTableName()
    {
        return 'contacts';
    }

    protected  function setState($array)
    {
        $this->value = $array['value'];
        $this->name = $array['name'];
    }
} 