<?php

namespace Bookshelf\Core;

/**
 * @author Aleksandr Kolobkov
 */
class Session
{
    /**
     * Method that return data in $_SESSION[$name] array
     *
     * @param $name key name
     * @return mixed value of $_SESSION[$name]
     */
    public function get($name, $default = null)
    {

        if (array_key_exists($name, $_SESSION)) {
            $default = $_SESSION[$name];
        }

        return $default;
    }

    /**
     * Method that input data in $_SESSION[$name]
     *
     * @param $name key name
     * @param $value value that assing to $_SESSION[$name]
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $key
     * @param string $message
     */
    public function addFlashMessage($key, $message)
    {
        $_SESSION['flashMessages'][$key][] = $message;
    }

    /**
     * @return array
     */
    public function getFlashMessages()
    {
        $messages = [];
        if (array_key_exists('flashMessages', $_SESSION)) {
            $messages =  $_SESSION['flashMessages'];
        }

        return $messages;
    }

    /**
     *  Method that initilizate session if session was don't started early
     */
    public function init()
    {
        $session_id = session_id();
        if (empty($session_id)) {
            session_start();
        }
    }

    /**
     * Method that will terminate session
     */
    public function terminate()
    {
        session_write_close();
    }

    /**
     * @param $name
     */
    public function delete($name)
    {
        unset($_SESSION[$name]);
    }
}
