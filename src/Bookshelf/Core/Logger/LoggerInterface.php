<?php

namespace Bookshelf\Core\Logger;

/**
 * Interface for Logger
 */
interface LoggerInterface
{
    /**
     * Constants for LogLevel
     */
    const LEVEL_DEBUG = 'debug';
    const LEVEL_INFO = 'info';
    const LEVEL_NOTICE = 'notice';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';
    const LEVEL_ALERT = 'alert';
    const LEVEL_EMERGENCY = 'emergency';


    /**
     * Abstract function that will send message then project send emergency error
     * 
     * @param $message emergency message
     * @param $context some var that can be send in future(but not now just ignore this)
     */
    public function emergency($message, $context);

    /**
     * Abstract function that will send message then project send some alerts
     *
     * @param $message alert message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function alert($message, $context);

    /**
     * Abstract function that will send error message
     *
     * @param $message error message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function error($message, $context);

    /**
     * Abstract function that send some warning message
     *
     * @param $message warning message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function warning($message, $context);

    /**
     * Abstract function that will send message than notice something
     *
     * @param $message notice message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function notice($message, $context);

    /**
     * Abstract function that will send in log some usefull(or not) info
     *
     * @param $message info message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function info($message, $context);

    /**
     * Abstract function that will send some debug information
     *
     * @param $message debug message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function debug($message, $context);

    /**
     * Abstract function that will collect data from another log methods and construct log message send it to writer class
     *
     * @param $message log message
     * @param $context var that can be send in future(but not now just ignore this)
     */
    public function log($level, $message, $context);
}

