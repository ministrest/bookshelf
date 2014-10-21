<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Model;

use Bookshelf\Core\Db;
use ReflectionObject;

class Book implements ModelInterface
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
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $rating;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $category;

    /**
     * @var array
     */
    private $users = array();

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return book
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param array $users
     * @return book
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return Book
     */
    public function setLink($link)
    {
        $this->link = $link;

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
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     * @return Book
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'books';
    }

    private static function factory($values)
    {
        $book = new self();
        $reflection = new ReflectionObject($book);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($book, $values['id']);
        $property->setAccessible(false);

        $book->setName($values['name']);
        $book->setDescription($values['description']);
        $book->setRating($values['rating']);
        $book->setLink($values['link']);
        $book->setAuthor($values['author']);

        $category = Category::getOneById($values['category_id']);
        $book->setCategory($category);

        return $book;
    }

    public static function fetchAllBooks()
    {
        $db = Db::getInstance();
        $tableBooks = self::getTableName();

        $sql = "SELECT * FROM $tableBooks ORDER BY category_id, author, name";
        $resultArray = $db->execute($sql);

        $books = array();
        foreach ($resultArray as $result) {
            $books[] = self::factory($result);
        }

        return $books;
    }

}
