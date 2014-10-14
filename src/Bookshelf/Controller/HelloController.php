<?php
namespace Bookshelf\Controller;

/**
 * Class HelloController
 * @package Bookshelf\Controller
 * @author Aleksandr Kolobkov
 */
class HelloController
{
    /**
     *
     */
    public function sayHelloAction(){
        echo 'Action Hello!';
    }

    /**
     *
     */
    public function sayHelloFriendAction() {
        echo 'Action Hello friend!';
    }

    /**
     *
     */
    public function indexAction(){
        echo 'This is index page!';
    }
}
