<?php

namespace Bookshelf\Controller;

/**
 * @author Aleksandr Kolobkov
 */
class MainController
{
    /**
     * Return default action for $this controller
     */
    public function defaultAction()
    {
        $this->indexAction();
    }

    /**
     * Return index page
     */
    public function indexAction()
    {
        echo "Hello World";
    }
}

