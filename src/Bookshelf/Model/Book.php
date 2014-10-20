<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Model;

use Bookshelf\Core\Db;

class Book implements ModelInterface
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $description;

    /**
     * @var
     */
    private $rating;

    /**
     * @var
     */
    private $link;

    /**
     * @var
     */
    private $author;

    private $category;

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

    private static function factory($id, $name, $description, $rating, $link, $author, $categoryId)
    {
        $book = new self();
        $reflection = new \ReflectionObject($book);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($book, $id);
        $property->setAccessible(false);

        $book->setName($name);
        $book->setDescription($description);
        $book->setRating($rating);
        $book->setLink($link);
        $book->setAuthor($author);

        $category = Category::getOneByBook($categoryId);
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

            $books[] = self::factory($result['id'], $result['name'], $result['description'], $result['rating'],
                $result['link'], $result['author'], $result['category_id']);
        }

        return $books;
    }

}
