<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 16.10.2014
 * Time: 13:03
 */

namespace Bookshelf\Core\Logger;

interface LoggerInterface
{
    const LEVEL_DEBUG = 'debug';
    const LEVEL_INFO = 'info';
    const LEVEL_NOTICE = 'notice';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';
    const LEVEL_ALERT = 'alert';
    const LEVEL_EMERGENCY = 'emergency';



    public function emergency($message, $context);

    public function alert($message, $context);

    public function error($message, $context);

    public function warning($message, $context);

    public function notice($message, $context);

    public function info($message, $context);

    public function debug($message, $context);

    public function log($level, $message, $context);
}