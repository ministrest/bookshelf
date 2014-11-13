<?php
/**
 * @author Aleksandr Kolobkov
 */

namespace Bookshelf\Core\Logger;

use Bookshelf\Core\Exception\WriterException;

/**
 * Class write log message in file
 */
class FileWriter implements WriterInterface
{
    /**
     * Array for improper symbols for file name
     * @var array
     */
    private $symbols = array('\\', '/', '"', '?', ':', '*', '<', '>', '|');

    /**
     * @var string
     */
    private $pathToFile;


    /**
     * @param $pathToFile
     * @throws WriterException
     */
    public function __construct($pathToFile)
    {
        if ($this->checkPathToFile($pathToFile)) {
            $this->pathToFile = $pathToFile;
        }
    }

    /**
     * @param log $message string message that was send then logger was executed
     * @param log $level string
     * @param data $data string message constructed by logged from data
     * @param null $context string that will content data from different vars. For now not used.
     */
    public function write($message, $level, $data, $context = null)
    {
        file_put_contents($this->pathToFile . '.txt', $data, FILE_APPEND);
    }

    /**
     * @param $pathToFile
     * @throws WriterException
     */
    private function checkPathToFile($pathToFile)
    {
        if (is_writable(dirname($pathToFile))) {
            foreach ($this->symbols as $value) {
                if (strpos(basename($pathToFile), $value)) {
                    throw new WriterException('Improper filename');
                }
            }

            return true;
        } else {
            throw new WriterException("Cant write in this directory: $pathToFile");
        }
    }
}
