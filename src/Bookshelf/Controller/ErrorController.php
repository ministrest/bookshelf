<?php
namespace Bookshelf\Controller;

/**
 * Class ErrorController
 * @package Bookshelf\Controller
 * @author Vasiliev Daniil
 */
class ErrorController
{
    /**
     * When our URI have wrong name for controller or their actions, this class will work
     */
    public function notFoundAction()
    {
        echo 'This page is not found(error 404)!';
    }
}

