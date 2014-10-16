<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 16.10.2014
 * Time: 14:26
 */

namespace Bookshelf\Core\Logger;


use Bookshelf\Core\Writer\Writer;

class Logger implements LoggerInterface
{
    public function emergency($message, $context = null)
    {
        $this->log(self::LEVEL_EMERGENCY, $message, $context);
    }

    public function alert($message, $context = null)
    {
        $this->log(self::LEVEL_ALERT, $message, $context);
    }

    public function error($message, $context = null)
    {
        $this->log(self::LEVEL_ERROR, $message, $context);
    }

    public function warning($message, $context = null)
    {
        $this->log(self::LEVEL_WARNING, $message, $context);
    }

    public function notice($message, $context = null)
    {
        $this->log(self::LEVEL_NOTICE, $message, $context);
    }

    public function info($message, $context = null)
    {
        $this->log(self::LEVEL_INFO, $message, $context);
    }

    public function debug($message, $context = null)
    {
        $this->log(self::LEVEL_DEBUG, $message, $context);
    }

    public function log($level, $message, $context = null)
    {
        //write to file
        $writer = new Writer();
        $data = date('Y-m-d H:i:s') . "\t" . $level . "\t" . $message . "\t" . $context . "\n";
        $writer->writeToFile($message, $level, $data, $context);
    }
} 