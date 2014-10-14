<?php

namespace Bookshelf\Core;

use Exception;

/**
 * Class Templater
 * @package Bookshelf\Core
 * @author Aleksandr Kolobkov
 */
class Templater
{
    /**
     * Dir for all template files
     *
     * @var null|string
     */
    private $templateDir = '../src/Bookshelf/View/';
    /**
     * In future will have names for all javascript files
     *
     * @var array
     */
    private $js = array(
        '1.js',
        '2.js'
    );

    /**
     * In future will have names for all css files
     *
     * @var array
     */
    private $css = array(
        '1.css',
        '2.css'
    );

    /**
     * Params for html page
     *
     * @var array
     */
    public $param = array();

    /**
     * Magic function that check directory for templates files
     *
     * @param null $templateDir
     */
    public function __construct($templateDir = null)
    {
        if ($templateDir !== null) {
            $this->templateDir = $templateDir;
        }
    }

    /**
     * Method that render html page based on inpit data(controll and actions names) and params
     *
     * @param $controllerName
     * @param $actionName
     * @param $param
     */
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

    /**
     * Add new elements in buffer that will added on html pages after render execute
     *
     * @param $controllerName
     * @param $actionName
     * @param $param
     */
    public function show($controllerName, $actionName, $param)
    {
        echo $this->render($controllerName, $actionName, $param);
    }
}

