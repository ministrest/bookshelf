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
     * @param log $message log messge that was send then logger was executed
     * @param log $level log level
     * @param data $data message constructed by logged from log data
     * @param null $context vars that not used(for now)
     */
    public function writeToFile($message, $level, $data, $context = null)
    {
        file_put_contents('../src/Bookshelf/Core/Logger/' . date('Y-m-d') . '.txt', $data, FILE_APPEND);
    }
}

