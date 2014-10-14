<?php

namespace Bookshelf\Core;

use Exception;

/**
 * @author Aleksandr Kolobkov
 */
class Templater
{
    /**
     * @var array array of params
     * @var template class property that will content names of all js file
     * @var template class property that will content names of all css file
     * @var string template class property that content path to template dir
     */
    public $param = array();
    private $jsList;
    private $cssList;
    private $templateDir = '../src/Bookshelf/View/';

    /**
     * Magic function that check directory for templates files
     *
     * @param null $templateDir
     */
    public function __construct($templateDir = null)
    {
        if($this->checkDir($templateDir)) {
            $this->templateDir = $templateDir;
        }
    }

    /**
     * Method that will return list of js files
     *
     * @return mixed
     */
    public function getJsFileList()
    {
        return $this->jsList;
    }

    /**
     * Method that will return list of css files
     *
     * @return mixed
     */
    public function getCssFileList()
    {
        return $this->cssList;
    }

    /**
     * Method that fill template class property $jsList
     * Input data - List of js files
     *
     * @param $list
     */
    public function setJsFileList($list)
    {
        $this->jsList = $list;
    }

    /**
     * Method that fill template class property $cssList
     * Input data - List of css files
     *
     * @param $list
     */
    public function setCssFileList($list)
    {
        $this->cssList = $list;
    }

    /**
     * Method that add new element in list of js files
     *
     * @param $element
     */
    public function addElementInJsList($element)
    {
        array_push($this->jsList, $element);
    }

    /**
     * Method that add new element in list of css files
     *
     * @param $element
     */
    public function addElementInCssList($element)
    {
        array_push($this->cssList, $element);
    }

    /**
     * Method that render html page based on input data(controll and actions names) and params
     *
     * @param $controllerName
     * @param $actionName
     * @param $param
     */
    public function render($controllerName, $actionName, $param)
    {
        $templateName = $this->templateDir . $controllerName . DIRECTORY_SEPARATOR . ucfirst($actionName) . 'View.html';
        try {
            if (file_exists($templateName)) {
                ob_start();
                include($templateName);

                return ob_get_clean();
            } else {
                throw new Exception('no template file ' . $templateName . ' present in directory ' . $this->templateDir);
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

    /**
     * Check existence of dir and her readability
     * Throw template exception if dir not exists or not readable
     *
     * @param $dir
     * @throws TemplaterException
     */
    private function checkDir($dir)
    {
        if ($dir) {
            if(is_dir($dir) !== false) {
                if(is_readable($dir) !== false) {

                    return true;
                } else {
                    throw new TemplaterException('This ' . $dir . 'is not readable');
                }
            } else {
                throw new TemplaterException('This ' . $dir . ' is not exists');
            }
        }
    }
}

