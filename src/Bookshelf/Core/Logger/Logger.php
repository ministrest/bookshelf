<?php
/**
 * @author Aleksandr Kolobkov
 */

namespace Bookshelf\Core\Logger;


use Bookshelf\Core\Writer\Writer;

/**
 * Class that construct and send log message to class that will write this message in file
 * All that you ned just create instance of this class than you want create log message and define loglevel
 */
class Logger implements LoggerInterface
{
    private $writer;

    public function __construct()
    {
        $this->writer = new FileWriter();
    }
    /**
     * Function will send emergency message and Loglevel
     *
     * @param $message emergency message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function emergency($message, $context = null)
    {
        $this->log(self::LEVEL_EMERGENCY, $message, $context);
    }

    /**
     * Function will send alert message and Loglevel
     *
     * @param $message alert message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function alert($message, $context = null)
    {
        $this->log(self::LEVEL_ALERT, $message, $context);
    }

    /**
     * Function will send error message and Loglevel
     *
     * @param $message error message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function error($message, $context = null)
    {
        $this->log(self::LEVEL_ERROR, $message, $context);
    }

    /**
     * Function will send warning message and Loglevel
     *
     * @param $message warning message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function warning($message, $context = null)
    {
        $this->log(self::LEVEL_WARNING, $message, $context);
    }

    /**
     * Function will send notice message and Loglevel
     *
     * @param $message notice message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function notice($message, $context = null)
    {
        $this->log(self::LEVEL_NOTICE, $message, $context);
    }

    /**
     * Function will send info message and Loglevel
     *
     * @param $message info message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function info($message, $context = null)
    {
        $this->log(self::LEVEL_INFO, $message, $context);
    }

    /**
     * Function will send debug message and Loglevel
     *
     * @param $message debug message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function debug($message, $context = null)
    {
        $this->log(self::LEVEL_DEBUG, $message, $context);
    }

    /**
     * Method construct log message from error message, loglevel and context and execute write to file
     *
     * @param $level Loglevel
     * @param $message log message
     * @param null $context some var that can be send in future(for now had default value - null)
     */
    public function log($level, $message, $context = null)
    {
        //write to file
        $convertedContext = $this->contextToString($context);
        $data = sprintf("%s %s %s %s \n", date('Y-m-d H:i:s'), $level, $message, $convertedContext);
        $this->writer->write($message, $level, $data, $convertedContext);
    }

    /**
     * @param $context
     * @return mixed|string
     */
    private function contextToString($context)
    {
        $type = gettype($context);
        switch ($type) {
            case 'array':
            case 'object':
                return print_r($context, true);
            default:
                return strval($context);
        }
    }
}
