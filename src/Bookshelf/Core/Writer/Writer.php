<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 16.10.2014
 * Time: 15:15
 */

namespace Bookshelf\Core\Writer;

class Writer implements WriterInterface
{
    public function writeToFile($message, $level, $data, $context = null)
    {
        echo $data;
    }
}