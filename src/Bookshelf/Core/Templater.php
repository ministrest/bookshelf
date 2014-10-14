<?php

namespace Bookshelf\Core;

use Exception;

class Templater
{
    private $templateDir = '../src/Bookshelf/View/';
    private $js = array(
        '1.js',
        '2.js'
    );
    private $css = array(
        '1.css',
        '2.css'
    );
    public $param = array();

    public function __construct($templateDir = null)
    {
        if ($templateDir !== null) {
            $this->templateDir = $templateDir;
        }
    }

    public function render($controllerName, $actionName, $param)
    {

        $templateName = $this->templateDir . $controllerName . '/' . ucfirst($actionName) . 'View.html';
        try {
            if (file_exists($templateName)) {
                ob_start();
                include($templateName);

                return ob_get_clean();
            } else {
                throw new \Exception('no template file ' . $templateName . ' present in directory ' . $this->templateDir);
            }
        } catch (Exception $e) {}
    }

    public function show($controllerName, $actionName, $param)
    {
        echo $this->render($controllerName, $actionName, $param);
    }
}

