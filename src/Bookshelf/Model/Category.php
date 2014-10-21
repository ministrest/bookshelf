<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Model;

use Bookshelf\Core\Db;
use ReflectionObject;

/**
 * @author Danil Vasiliev <danil.vasiliev@opensoftdev.ru>
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return book
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'categories';
    }

    private static function factory($values)
    {
        $category = new self();
        $reflection = new ReflectionObject($category);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($category, $values['id']);
        $property->setAccessible(false);

        $category->setName($values['name']);

        return $category;
    }

    public static function getOneById($id)
    {
        $db = Db::getInstance();
        $tableCategories = self::getTableName();

        $sql = "SELECT * FROM $tableCategories WHERE id = $id LIMIT 1";
        $resultArray = $db->execute($sql);
        foreach ($resultArray as $result) {
            $category = self::factory($result);
        }

        return $category;
    }

}
