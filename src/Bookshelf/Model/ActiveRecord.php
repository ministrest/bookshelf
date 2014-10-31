<?php

namespace Bookshelf\Model;

use Bookshelf\Core\Db;
use Bookshelf\Core\Exception\DbException;

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
     * @param $field string
     * @param $value string
     * @return static
     */
    public static function findOneBy($field, $value)
    {
        $object = new static();
        $fetchResult = Db::getInstance()->fetchOneBy($object->getTableName(), [$field => $value]);
        $object->setState($fetchResult);

        return $object;
    }
    /**
     * Method that will find and return all objects from database by $key with value = $name
     *
     * @param $field string
     * @param $value string
     * @return array
     */
    public static function findBy($field, $value)
    {
        $ArrayOfObjects = [];
        $object = new static;
        $fetchResult = Db::getInstance()->fetchBy($object->getTableName(), [$field => $value]);
        foreach ($fetchResult as $array) {
            $object = new static;
            $ArrayOfObjects[$array['id']] = $object->setState($array);
        }

        return $ArrayOfObjects;
    }

    /**
     * Method that find All data from table
     *
     * @return array of objects
     */
    public static function findAll()
    {
        $model = new static();
        $fetchResult = Db::getInstance()->fetchAll($model->getTableName());
        $ArrayOfObjects = [];
        foreach ($fetchResult as $value) {
            $object = new static();
            $ArrayOfObjects[] = $object->setState($value);
        }

        return $ArrayOfObjects;
    }

    /**
     * Method that insert data in database if $id empty, if $id not empty will update data
     *
     * @return bool
     */
    public function save()
    {
        try {
            $propertyArray = $this->getState();
            if (empty($propertyArray['id'])) {
                unset($propertyArray['id']);
                Db::getInstance()->insert($this->getTableName(), $propertyArray);
            } else {
                Db::getInstance()->update($this->getTableName(), $propertyArray, ['id' => $propertyArray['id']]);
            }

            return true;
        } catch (DbException $e) {

            return false;
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
     * Return value of object property
     *
     * @return array
     */
    abstract protected function getState();

    /**
     * Return object table name
     *
     * @return string
     */
    abstract protected function getTableName();

    /**
     * Set value for object properties
     *
     * @param $array
     */
    abstract protected function setState($array);
}
