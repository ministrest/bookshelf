<?php
class AutoLoader
{
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * @param string $className
     */
    private function loadClass($className)
    {
        $fileName = $className . '.php';
        $replaceFileName = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $replaceFileName)) {
            require_once $replaceFileName;
        }
    }
}
