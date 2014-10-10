<?php
namespace Controller;

class HelloController
{
    public function sayHelloAction(){
        echo 'Action Hello!';
    }

    public function sayHelloFriendAction() {
        echo 'Action Hello friend!';
    }

    public function indexAction(){
        echo 'This is index page!';
    }
}
