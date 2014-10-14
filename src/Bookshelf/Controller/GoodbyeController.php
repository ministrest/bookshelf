<?php
namespace Bookshelf\Controller;

class GoodbyeController
{
    public function defaultAction()
    {
        $this->indexAction();
    }

    public function sayGoodbyeAction(){
        echo 'Action Goodbye!';
    }

    public function indexAction(){
        echo 'This is index page!';
    }
}
