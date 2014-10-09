<?php
class AutoLoader
{
    public static function register()
    {
        $autoloader = new Autoloader();
        spl_autoload_register(array($autoloader, 'loadClass'));
    }

    /**
     * @param string $className
     */
    public function loadclass ($className)
    {
        $fileName = $className . '.php';
        $replaceFileName = str_replace('\\', '/', $fileName);
        if (file_exists(__DIR__.'/'.$replaceFileName)) {
            require_once $replaceFileName;
        }
        else {
            echo '<br /> This class is not exist!';
            exit;
        }
    }
}