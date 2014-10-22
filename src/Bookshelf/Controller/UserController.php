<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 20.10.2014
 * Time: 16:21
 */
namespace Bookshelf\Controller;

use Bookshelf\Core\Templater;

class UserController
{
    private $templater;

    public function __construct()
    {
        $this->templater = new Templater();
    }


    public function addAction()
    {
        $this->templater->show('User', 'Add', null);
    }


}