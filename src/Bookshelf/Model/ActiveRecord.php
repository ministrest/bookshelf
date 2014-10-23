<?php
/**
 * Created by PhpStorm.
 * User: aleksandr.kolobkov
 * Date: 17.10.2014
 * Time: 19:18
 */
namespace Bookshelf\Model;

use Exception;
use Bookshelf\Core\Db;
abstract class ActiveRecord
{
    public $array;
    private $db;
    public function __construct()
    {
        $this->db = new Db('bookshelf', 'hantim', 'uNjUDY0q');
    }

    public function create()
    {

    }

    public function save()
    {
        $this->db->insert($this->getTableName(), $this->getState());
    }

    public function get($id)
    {
        $array = $this->db->fetchOneBy($this->getTableName(), ['id' => $id]);
        if(!empty($array)) {
            $this->setState($array);
        } else {
            throw new Exception('Data not found');
        }
    }

    abstract protected function getState();

    abstract protected function getTableName();

    abstract protected function setState($array);



}