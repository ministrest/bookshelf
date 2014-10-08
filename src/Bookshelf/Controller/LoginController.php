<?php

namespace Bookshelf\Controller;

/**
 * @author Aleksandr Kolobkov
 */
class LoginController
{
    /**
     * Default action for $this class
     */
    public function defaultAction()
    {
        $this->loginAction();
    }

    /**
     * In future will return LogIn page
     */
    public function loginAction()
    {
        echo "This is Login page";
    }

    /**
     * In future will return LogOut page
     */
    public function logoutAction()
    {
        echo "This is logout page";
    }

    /**
     * In future will return Register page
     */
    public function registerAction()
    {
        echo "This is register page";
    }
}

