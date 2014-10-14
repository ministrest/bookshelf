<?php
namespace Bookshelf\Controller;

class IndexController
{
    public function defaultAction()
    {
        $this->indexAction();
    }

    public function indexAction(){
        return array(
            'user' => 'Alex'
        );
    }
}

