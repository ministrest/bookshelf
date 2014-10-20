<?php
/**
 * @author Aleksandr Kolobkov
 */

namespace Bookshelf\Core\Logger;

/**
 * Class write log message in file
 */
class FileWriter implements FileWriterInterface
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $pathToDir;


    /**
     * @param null $filename string
     * @param null $pathToDir string
     */
    public function __construct($filename = null, $pathToDir =null)
    {
        if ($filename === null) {
            $filename = date('Y-m-d');
        }

        if ($pathToDir === null) {
            $pathToDir = '../src/Bookshelf/Core/Logger/';
        }

        $this->filename = $filename;
        $this->pathToDir = $pathToDir;
    }

    /**
     * @param log $message string message that was send then logger was executed
     * @param log $level string
     * @param data $data string message constructed by logged from data
     * @param null $context string that will content data from different vars. For now not used.
     */
    public function write($message, $level, $data, $context = null)
    {
        file_put_contents($this->pathToDir . $this->filename . '.txt', $data, FILE_APPEND);
    }
}
