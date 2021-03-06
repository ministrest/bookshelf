<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Controller;

use Bookshelf\Core\Request;
use Bookshelf\Core\Templater;
use Bookshelf\Core\Validation\Constraint\EntityExistsConstraint;
use Bookshelf\Core\Validation\Constraint\CategoryIssetConstraint;
use Bookshelf\Core\Validation\Constraint\LinkConstraint;
use Bookshelf\Core\Validation\Constraint\NotBlankConstraint;
use Bookshelf\Core\Validation\Constraint\ChoiceConstraint;
use Bookshelf\Core\Validation\Constraint\UniqueConstraint;
use Bookshelf\Core\Validation\Constraint\UniqueFieldConstraint;
use Bookshelf\Core\Validation\Validator;
use Bookshelf\Model\Book;
use Bookshelf\Model\Category;

/**
 * @author Danil Vasiliev <daniil.vasilev@opensoftdev.ru>
 */
class BooksController
{
    /**
     * @var string default name for controller
     */
    private $controllerName = 'Books';

    /**
     * @var var for Templater class instance
     */
    private $templater;

    /**
     * @var array Request
     */
    private $request;

    /**
     * Magic function that create templater class instance
     */
    public function __construct()
    {
        $this->templater = new Templater();
        $this->request = new Request($_GET, $_POST);
    }

    public function defaultAction()
    {
        $orderBy = [
            'category_id' => 'ASC',
            'author' => 'ASC',
            'name' => 'ASC'
        ];

        $searchParameters = [];
        if ($this->request->isPost()) {
            $search = $this->request->get('search');
            $searchParameters = [
                'b.name' => $search,
                'author' => $search,
                'c.name' => $search
            ];
        }
        $bookObject = new Book();
        $books = $bookObject->search($orderBy, $searchParameters);

        $result = [];
        foreach ($books as $book) {
            $categoryName = $book->getCategory()->getName();
            if (!array_key_exists($categoryName, $result)) {
                $result[$categoryName] = array();
            }
            $result[$categoryName][] = $book;
        }

        return $this->templater->show($this->controllerName, 'Default', $result);
    }

    public function addAction()
    {
        $this->request->data['id'] = null;
        $errors = [];

        $categories = Category::findAll();

        if ($this->request->isPost()) {
            $book = new Book();
            $book->setName($this->request->get('name'));
            $book->setAuthor($this->request->get('author'));
            $book->setCategory(Category::find($this->request->get('category_id')));
            $book->setDescription($this->request->get('description'));
            $book->setRating($this->request->get('rating'));
            $book->setLink($this->request->get('link'));

            $errors = $this->validate($book);
            if (!$errors) {
                $book->save();
                return $this->defaultAction();
            }
        }

        return $this->templater->show($this->controllerName, 'Add', ['errors' => $errors, 'categories' => $categories]);
    }

    /**
     * @param Book $book
     * @return array
     */
    private function validate($book)
    {
        $nameNotBlank = new NotBlankConstraint($book, 'name');
        $nameUnique = new UniqueConstraint($book, 'name');
        $authorNotBlank = new NotBlankConstraint($book, 'author');
        $linkCorrect = new LinkConstraint($book, 'link');
        $ratingCorrect = new ChoiceConstraint($book, 'rating', $book->availableValues);
        $categoryIsset = new EntityExistsConstraint($book->getCategory(), 'id', 'category');

        $validator = new Validator();
        $validator->addConstraint($nameNotBlank);
        $validator->addConstraint($nameUnique);
        $validator->addConstraint($authorNotBlank);
        $validator->addConstraint($linkCorrect);
        $validator->addConstraint($ratingCorrect);
        $validator->addConstraint($categoryIsset);

        $errors = $validator->validate();

        return $errors;
    }
}
