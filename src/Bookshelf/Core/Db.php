<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core;

use Bookshelf\Core\Exception\DbException;
use PDO;
use PDOException;
use PDOStatement;

/**
 * @author Danil Vasiliev <danil.vasiliev@opensoftdev.ru>
 */
class Db
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var PDOStatement
     */
    private $statement;

    /**
     * @param string $sql
     * @param array $optionsArray
     * @throws DbException
     */
    public function execute($sql, $optionsArray = array()) {
        try {
            $dbConnect = $this->getConnection();
            $this->statement = $dbConnect->prepare($sql);
            $result = $this->statement->execute($optionsArray);

            if ($result === false) {
                throw DbException::executionFailed();
            }
        } catch (PDOException $e)  {
            //logging logic could be placed here
            throw DbException::executionFailed();
        }
    }
    /**
     * @param string $tableName
     * @return array
     */
    public function fetchAll($tableName) {
        $sql = "SELECT * FROM $tableName";
        try {
            $this->execute($sql);
            $resultArray = $this->getStatement()->fetchAll(PDO::FETCH_ASSOC);
        } catch (DbException $e){
            $resultArray = null;
        }
        echo '<pre/>';

        return $resultArray;
    }
    /**
     * @param string $tableName
     * @param $fetchArray
     * @return array
     */
    public function fetchOneBy($tableName, $fetchArray) {
        $keysArray = array_keys($fetchArray);
        $valuesArray = array_values($fetchArray);
        foreach ($keysArray as &$value) {
            $value = $value.' = ?';
        }
        $condition = implode($keysArray, ' AND ');

        $sql = "SELECT * FROM $tableName WHERE $condition LIMIT 1";
        try {
            $this->execute($sql, $valuesArray);
            $result = $this->getStatement()->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                $result = null;
            }
        } catch (DbException $e) {
            $result = null;
        }

        return $result;
    }

    /**
     * @param string $tableName
     * @param array $deleteArray
     */
    public function delete($tableName, $deleteArray = array()) {
        $keysArray = array_keys($deleteArray);
        $valuesArray = array_values($deleteArray);
        foreach ($keysArray as &$value) {
            $value = $value.'= ?';
        }
        $condition = implode($keysArray, ' AND ');
        if ($keysArray == []) {
            $condition = 'TRUE';
        }

        $sql = "DELETE FROM $tableName WHERE $condition";
        try {
            $this->execute($sql, $valuesArray);
        } catch (DbException $e) {
            throw DbException::deleteFailed($tableName, implode(', ', $valuesArray), $e);
        }
    }

    /**
     * @param string $tableName
     * @param array $insertArray
     */
    public function insert($tableName, $insertArray) {
        $keysArray = array_keys($insertArray);
        $valuesArray = array_values($insertArray);
        $valuesCount = count($valuesArray);
        $bindArray = [];
        for($i = 0; $i < $valuesCount; $i++ ) {
            $bindArray[] = '?';
        }
        $keys = implode(', ', $keysArray);
        $values = implode(', ', $bindArray);

        $sql = "INSERT INO $tableName ($keys) VALUES($values)";
        try {
            $this->execute($sql, $valuesArray);
        } catch (DbException $e) {
            throw DbException::insertFailed($tableName, $keys, implode(', ', $valuesArray), $e);
        }
    }

    /**
     * @param string $tableName
     * @param array $newValues
     * @param array $conditions
     */
    public function update($tableName, array $newValues, array $conditions = array()) {
        $conditionKeys = array_keys($conditions);
        $conditionValues = array_values($conditions);
        foreach ($conditionKeys as &$value) {
            $value = $value . ' = ?';
        }
        $condition = implode($conditionKeys, ' AND ');
        if ($conditions == []) {
            $condition = 'TRUE';
        }
        $updateKeys = array_keys($newValues);
        $updateValues = array_values($newValues);
        foreach ($updateKeys as &$value) {
            $value = $value . ' = ?';
        }
        $values = implode($updateKeys, ', ');

        $sql = "UPDATE $tableName SET $values WHERE $condition";
        try {
            $valuesArray = array_merge($updateValues, $conditionValues);
            $this->execute($sql, $valuesArray);
        } catch (DbException $e) {
            throw DbException::updateFailed($tableName, implode(', ', $valuesArray), $e);
        }
    }
    public function getStatement(){
        try {
            if (!$this->statement) {
                throw new PDOException;
            }
        } catch (PDOException $e) {
            throw DbException::executionFailed();
        }
        return $this->statement;
    }
    private function getConnection() {
        if (!$this->connection) {
            $this->connection = new PDO('pgsql:host=localhost; dbname=BookShelf', 'postgres', 'postgres');
        }
        return $this->connection;
    }
}



