<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 16.10.2014
 * Time: 15:16
 */

namespace Bookshelf\Core\Writer;

interface WriterInterface
{
    public function writeToFile($message, $level, $data, $context = null);
}