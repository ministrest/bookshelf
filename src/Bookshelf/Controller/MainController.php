<?php

namespace Bookshelf\Controller;

use Bookshelf\Core\Logger\Logger;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;
use Bookshelf\Core\TemplaterException;
use Exception;
/**
 * @author Aleksandr Kolobkov
 */
class MainController
{
    /**
     * @var string default name for controller
     */
    private $controllName = 'Main';

    /**
     * @var var for templater instance
     */
    private $templater;

    private $session;

    /**
     * Magic function that create templater and session instance
     */
    public function __construct()
    {
        try {
            $this->session = new Session();
            $this->templater = new Templater();
        } catch (TemplaterException $e) {
            throw new Exception ('Controller error');
        }
    }

    /**
     * Return default action for $this controller
     */
    public function defaultAction()
    {
        $this->indexAction();
    }

    /**
     * When execute will show Main/IndexView.html
     */
    public function indexAction()
    {
        if ($this->session->get('logInStatus', 0) === 1) {
            $this->templater->show($this->controllName, 'AccountPage', ['name' => $this->session->get('email')]);
        } else {
            $login = new LoginController();
            $actionName = 'index';
            $param = array(
                "title" => 'Test',
                "text" => 'This is test so relax and be happy',
                "menu" => $login->getLoginForm()
            );
            $this->templater->show($this->controllName, $actionName, $param);
        }
    }
}

