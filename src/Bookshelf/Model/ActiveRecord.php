<?php

namespace Bookshelf\Model;

use Bookshelf\Core\Db;

/**
 * @author Aleksandr Kolobkov
 */
abstract class ActiveRecord
{
    /**
     * @return mixed
     */
    abstract public function getId();

    /**
     * Method that will find object from Database by id
     *
     * @param $id
     * @return ActiveRecord
     */
    public static function find($id)
    {
        return self::findBy('id', $id);
    }

    /**
     * Method that will find object from database by $key with value = $name
     *
     * @param $key
     * @param $name
     * @return static
     */
    public static function findBy($key, $name)
    {
        $object = new static();
        $array = Db::getInstance()->fetchOneBy($object->getTableName(), [$key => $name]);
        $object->setState($array);

        return $object;
    }

    /**
     * Method that find All data from table
     *
     * @return array of objects
     */
    public static function findAll()
    {
        $model = new static();
        $array = Db::getInstance()->fetchAll($model->getTableName());
        $length = count($array);
        $arrayObjects = [];
        for ($i = 0; $i < $length; $i++) {
            $object = new static();
            $object->setState($array[$i]);
            $arrayObjects[$i] = $object;
        }

        return $arrayObjects;
    }

    /**
     * Method that insert data in database if $id empty, if $id not empty will update data
     */
    public function save()
    {
        $array = $this->getState();
        if (empty($array['id'])) {
            unset($array['id']);
            Db::getInstance()->insert($this->getTableName(), $array);
        } else {
            Db::getInstance()->update($this->getTableName(), $array, ['id' => $array['id']]);
        }
    }

    /**
     * Method that will delete data from table
     */
    public function delete()
    {
        Db::getInstance()->delete($this->getTableName(), ['id' => $this->getId()]);
    }

    /**
     * Abstract method for get property for object
     *
     * @return mixed
     */
    abstract protected function getState();

    /**
     * Abstract method for get table name
     *
     * @return mixed
     */
    abstract protected function getTableName();

    /**
     * Abstract method that will set value in object property
     *
     * @param $array
     * @return mixed
     */
    abstract protected function setState($array);
}
