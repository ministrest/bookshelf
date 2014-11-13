<?php

namespace Bookshelf\Controller;

use Bookshelf\Core\Logger\Logger;
use Bookshelf\Core\Session;
use Bookshelf\Core\Templater;
use Bookshelf\Core\Exception\TemplaterException;
use Exception;
/**
 * @author Aleksandr Kolobkov
 */
class MainController extends Controller
{
    /**
     * @var string default name for controller
     */
    private $controllerName = 'Main';

    /**
     * Return default action for $this controller
     */
    public function defaultAction()
    {
        $book = new BooksController();
        $book->defaultAction();
    }

    /**
     * When execute will show Main/IndexView.html
     */
    public function indexAction()
    {
        if ($this->session->get('logInStatus', 0) === 1) {
            $this->templater->show($this->controllerName, 'AccountPage', ['name' => $this->session->get('email')]);
        } else {
            $login = new LoginController();
            $actionName = 'index';
            $param = array(
                "title" => 'Test',
                "text" => 'This is test so relax and be happy',
                "menu" => $login->showLoginForm()
            );
            $this->templater->show($this->controllerName, $actionName, $param);
        }
    }
}
