<?php


namespace Bookshelf\Core;

/**
 * @author Aleksandr Kolobkov
 */
class Session
{
    /**
     * When instance class is created checking LogInStatus session.
     * If this key don't exist in $_SESSION execute session method assign to this key value 0
     */
    public function __construct()
    {
        if(!isset($_SESSION['logInStatus'])) {
            $this->setSessionData('logInStatus', 0);
        }
    }

    /**
     * Method that return data in $_SESSION[$name] array
     *
     * @param $name key name
     * @return mixed value of $_SESSION[$name]
     */
    public function getSessionData($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Method that input data in $_SESSION[$name]
     *
     * @param $name key name
     * @param $value value that assing to $_SESSION[$name]
     */
    public function setSessionData($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     *  Method that initilizate session if session was don't started early
     */
    public function initSession()
    {
        $session_id = session_id();
        if(empty($session_id)) session_start();
    }

    /**
     * Method that will terminate session
     */
    public function terminateSession()
    {
        session_write_close();
    }
}

