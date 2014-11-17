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
        return self::findOneBy(['id' => $id]);
    }

    /**
     * Method that will find and return only 1 object from database
     *
     * @param array $conditions
     * @return null|static
     */
    public static function findOneBy(array $conditions)
    {
        $object = new static();
        $fetchResult = Db::getInstance()->fetchOneBy($object->getTableName(), $conditions);
        if (!$fetchResult) {
            return null;
        }
        $object->initStateFromArray($fetchResult);

        return $object;
    }

    /**
     * Method that will return array of objects
     * property for this objects will be found(or not) in database
     *
     * @param array $conditions
     * @return array|null
     */
    public static function findBy(array $conditions)
    {
        $arrayOfObjects = [];
        $object = new static;
        $fetchResult = Db::getInstance()->fetchBy($object->getTableName(), $conditions);
        if (!$fetchResult) {
            return null;
        }
        foreach ($fetchResult as $objectState) {
            $object = new static;
            $object->initStateFromArray($objectState);
            $arrayOfObjects[] = $object;
        }

        return $arrayOfObjects;
    }

    /**
     * Method that find All data from table
     *
     * @return array|null
     */
    public static function findAll()
    {
        $model = new static();
        $fetchResult = Db::getInstance()->fetchAll($model->getTableName());
        if (!$fetchResult) {
            return null;
        }
        $arrayOfObjects = [];
        foreach ($fetchResult as $objectState) {
            $object = new static();
            $object->initStateFromArray($objectState);
            $arrayOfObjects[] = $object;
        }

        return $arrayOfObjects;
    }

    /**
     * Method that insert data in database if $id empty, if $id not empty will update data
     *
     * @return bool
     */
    public function save()
    {
        try {
            $instanceState = $this->toArray();
            if (empty($instanceState['id'])) {
                unset($instanceState['id']);
                $dataFromInsert = Db::getInstance()->insert($this->getTableName(), $instanceState);
                $this->initStateFromArray($dataFromInsert);
            } else {
                Db::getInstance()->update($this->getTableName(), $instanceState, ['id' => $instanceState['id']]);
            }

            return true;
        } catch (DbException $e) {
            return false;
        }
    }

    /**
     * @param null $tableName
     * @param array $conditions
     */
    public function delete($tableName = null, array $conditions = [])
    {
        if (!$tableName) {
            $tableName = $this->getTableName();
        }

        if (!$conditions) {
            $conditions = ['id' => $this->getId()];
        }

        Db::getInstance()->delete($tableName, $conditions);
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
    abstract protected function toArray();

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
    abstract protected function initStateFromArray($array);
}
