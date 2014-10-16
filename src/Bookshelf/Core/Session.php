<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 16.10.2014
 * Time: 11:08
 */

namespace Bookshelf\Core;

class Session
{
    public function __construct()
    {
        if(!isset($_SESSION['logInStatus'])) {
            $this->setSessionData('logInStatus', 0);
        }
    }

    public function getSessionData($name)
    {
        return $_SESSION[$name];
    }

    public function setSessionData($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function initSession()
    {
        $a = session_id();
        if(empty($a)) session_start();
    }

    public function terminateSession()
    {
        session_write_close();
    }
}