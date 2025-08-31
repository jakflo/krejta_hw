<?php

namespace App;

use \PDO;
use \PDOException;

class Db
{
    
    private PDO $conn;

    public function __construct()
    {
        $this->connect();
    }

    public function sendSQL(string $sql, array $parameters = [])
    {
        try {
            $prepared = $this->conn->prepare($sql);
            $prepared->execute($parameters);
        } catch (PDOException $e) {
//            echo "<br>{$sql}<br>";
//            print_r($parameters);
            throw $e;
        }
        return $prepared;
    }

    public function queryAll(string $sql, array $parameters = [])
    {
        $prepared = $this->sendSQL($sql, $parameters);
        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    public function queryColumn(string $sql, string $column_name, array $parameters = [])
    {
        $result = $this->queryAll($sql, $parameters);
        return array_column($result, $column_name);
    }
    
    // vrati prvni radek
    public function queryRow(string $sql, array $parameters = [])
    {
        $prepared = $this->sendSQL($sql, $parameters);
        $row = $prepared->fetch(PDO::FETCH_ASSOC);
        $prepared->closeCursor();
        return $row;
    }
    
    // vrati prvni sloupec prvniho radku
    public function queryField(string $sql, array $parameters = [])
    {
        $row = $this->queryRow($sql, $parameters);
        $sloupce = array_keys($row);
        return $row[$sloupce[0]];
    }

    public function getLastId()
    {
        return $this->queryField("SELECT LAST_INSERT_ID()");
    }
    
    private function connect()
    {
        $cfg = new \Config\Loader('db');
        $this->conn = new PDO("mysql:host={$cfg->getProp('host')};dbname={$cfg->getProp('dbname')}", $cfg->getProp('username'), $cfg->getProp('password'));
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
}