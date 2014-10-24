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
class Category implements ModelInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
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

    /**
     * @param $values
     * @return Category
     */
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
        $options = ['id' => $id];
        $result = $db->fetchOneBy($tableCategories, $options);
        $category = self::factory($result);

        return $category;
    }

}
