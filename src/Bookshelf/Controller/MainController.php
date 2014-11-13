<?php

namespace Bookshelf\Controller;

/**
 * @author Aleksandr Kolobkov
 */
class MainController extends Controller
{
    /**
     * Return default action for $this controller
     */
    public function defaultAction()
    {
        $this->redirectTo('/books');
        exit;
    }
}
