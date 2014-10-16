<?php
/**
 * This code belongs to of Opensoft company
 */

namespace Bookshelf\Core;

use PDO;
use PDOException;
use PDOStatement;
use Bookshelf\Core\Exception\DbException;

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
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $dbUser;

    /**
     * @var string
     */
    private $dbPassword;

    /**
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPassword
     */
    public function __construct($dbName, $dbUser, $dbPassword)
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }

    /**
     * @param string $sql
     * @param array $options
     * @throws DbException
     */
    public function execute($sql, $options = [])
    {
        try {
            $dbConnect = $this->getConnection($this->dbName, $this->dbUser, $this->dbPassword);
            $this->statement = $dbConnect->prepare($sql);
            $result = $this->statement->execute($options);

            if ($result === false) {
                throw DbException::executionFailed();
            }
        } catch (PDOException $e) {
            //logging logic could be placed here
            throw DbException::executionFailed();
        }
    }

    /**
     * @param string $tableName
     * @return array
     */
    public function fetchAll($tableName)
    {
        $sql = "SELECT * FROM $tableName";
        try {
            $this->execute($sql);
            $resultArray = $this->getStatement()->fetchAll(PDO::FETCH_ASSOC);
        } catch (DbException $e){
            $resultArray = [];
            //to do logger
        }

        return $resultArray;
    }

    /**
     * @param string $tableName
     * @param $fetchOptions
     * @return array
     */
    public function fetchOneBy($tableName, $fetchOptions)
    {
        $optionKeys = array_keys($fetchOptions);
        $optionValues = array_values($fetchOptions);
        foreach ($optionKeys as &$value) {
            $value .= ' = ?';
        }
        $condition = implode(' AND ', $optionKeys);

        $sql = "SELECT * FROM $tableName WHERE $condition LIMIT 1";
        try {
            $this->execute($sql, $optionValues);
            $result = $this->getStatement()->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                $result = null;
            }
        } catch (DbException $e) {
            $result = null;
            // to do logger
        }

        return $result;
    }

    /**
     * @param string $tableName
     * @param array $deleteOptions
     */
    public function delete($tableName, $deleteOptions = [])
    {
        if (!$deleteOptions) {
            $sql = "DELETE FROM $tableName";
            $optionValues = [];
        } else {
            $optionKeys = array_keys($deleteOptions);
            $optionValues = array_values($deleteOptions);
            foreach ($optionKeys as &$value) {
                $value = $value . '= ?';
            }
            $condition = implode(' AND ', $optionKeys);

            $sql = "DELETE FROM $tableName WHERE $condition";
        }
        try {
            $this->execute($sql, $optionValues);
        } catch (DbException $e) {
            throw DbException::deleteFailed($tableName, implode(', ', $optionValues), $e);
        }
    }

    /**
     * @param string $tableName
     * @param array $insertOptions
     */
    public function insert($tableName, $insertOptions)
    {
        $optionKeys = array_keys($insertOptions);
        $optionValues = array_values($insertOptions);
        $valuesCount = count($optionValues);
        $bindArray = [];
        for($i = 0; $i < $valuesCount; $i++ ) {
            $bindArray[] = '?';
        }
        $keys = implode(', ', $optionKeys);
        $values = implode(', ', $bindArray);

        $sql = "INSERT INTO $tableName ($keys) VALUES($values)";
        try {
            $this->execute($sql, $optionValues);
        } catch (DbException $e) {
            throw DbException::insertFailed($tableName, $keys, implode(', ', $optionValues), $e);
        }
    }

    /**
     * @param string $tableName
     * @param array $newValues
     * @param array $conditions
     */
    public function update($tableName, array $newValues, array $conditions = [])
    {
        $updateKeys = array_keys($newValues);
        $updateValues = array_values($newValues);
        foreach ($updateKeys as &$value) {
            $value .= ' = ?';
        }
        $values = implode(', ', $updateKeys);

        if (!$conditions) {
            $sql = "UPDATE $tableName SET $values";
            $conditionValues = [];
        } else {
            $conditionKeys = array_keys($conditions);
            $conditionValues = array_values($conditions);
            foreach ($conditionKeys as &$value) {
                $value .= ' = ?';
            }
            $condition = implode(' AND ', $conditionKeys);
            $sql = "UPDATE $tableName SET $values WHERE $condition";
        }

        try {
            $valuesArray = array_merge($updateValues, $conditionValues);
            $this->execute($sql, $valuesArray);
        } catch (DbException $e) {
            throw DbException::updateFailed($tableName, implode(', ', $valuesArray), $e);
        }
    }

    public function getStatement()
    {
        try {
            if (!$this->statement) {
                throw new PDOException;
            }
        } catch (PDOException $e) {
            throw DbException::executionFailed();
        }

        return $this->statement;
    }

    /**
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPassword
     * @return PDO
     */
    private function getConnection($dbName, $dbUser, $dbPassword)
    {
        if (!$this->connection) {
            $this->connection = new PDO("pgsql:host=localhost; dbname=$dbName", $dbUser, $dbPassword);
        }

        return $this->connection;
    }
}
