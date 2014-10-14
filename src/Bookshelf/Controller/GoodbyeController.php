<?php
namespace Bookshelf\Controller;
/**
 * Class GoodbyeController
 * @package Bookshelf\Controller
 * @author Vasiliev Daniil
 */
class GoodbyeController
{
    /**
     * Default action for this class
     */
    public function defaultAction()
    {
        $this->indexAction();
    }

    /**
     * Reaction on logout
     */
    public function sayGoodbyeAction(){
        echo 'Action Goodbye!';
    }

    /**
     * Reaction then we don't have $_GET param for action var
     */
    public function indexAction(){
        echo 'This is index page!';
    }
}

