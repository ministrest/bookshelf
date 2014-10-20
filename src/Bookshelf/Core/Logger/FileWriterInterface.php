<?php

namespace Bookshelf\Core\Logger;

/**
 * @author Aleksandr Kolobkov
 */
interface FileWriterInterface
{
    /**
     * Abstract functiob that will write data from logger in file
     *
     * @param $message log message
     * @param $level log level
     * @param $data data that was constructed by logger
     * @param null $context some vars that will be used in future(for now this is not vars you are looking for)
     */
    public function write($message, $level, $data, $context = null);
}

