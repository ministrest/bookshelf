<?php

namespace Bookshelf\Model;

use Bookshelf\Core\Db;

/**
 * @author Aleksandr Kolobkov
 */
abstract class ActiveRecord
{
    /**
     * Method that will find object from Database by id
     *
     * @param $id int
     * @return object
     */
    public static function find($id)
    {
        return self::findOneBy('id', $id);
    }

    /**
     * Method that will find and return only 1 object from database
     *
     * @param $key string
     * @param $name string
     * @return static
     */
    public static function findOneBy($key, $name)
    {
        $object = new static();
        $array = Db::getInstance()->fetchOneBy($object->getTableName(), [$key => $name]);
        $object->setState($array);

        return $object;
    }
    /**
     * Method that will find and return all objects from database by $key with value = $name
     *
     * @param $key string
     * @param $name string
     * @return array
     */
    public static function findBy($key, $name)
    {
        $objectArray = [];
        $object = new static;
        $array = Db::getInstance()->fetchBy($object->getTableName(), [$key => $name]);
        foreach ($array as $value) {
            $objectArray[$value['id']] = new static;
            $objectArray[$value['id']]->setState($value);
        }

        return $objectArray;
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
        $propertyArray = $this->getState();
        if (empty($propertyArray['id'])) {
            unset($propertyArray['id']);
            Db::getInstance()->insert($this->getTableName(), $propertyArray);
        } else {
            Db::getInstance()->update($this->getTableName(), $propertyArray, ['id' => $propertyArray['id']]);
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
     * @return int
     */
    abstract public function getId();

    /**
     * Abstract method for get property for object
     *
     * @return array
     */
    abstract protected function getState();

    /**
     * Abstract method for get table name
     *
     * @return string
     */
    abstract protected function getTableName();

    /**
     * Abstract method that will set value in object property
     *
     * @param $array
     */
    abstract protected function setState($array);
}
