<?php

namespace Fibi\Database;

use PDO;
use PDOException;

abstract class DbConnection
{
    protected PDO $pdo;

    public function __construct() {

        $protocol = "mysql";
        $host = "localhost";
        $port = 3306;
        $database = "cake_factory";
        $username = "root";
        $password = "admin";

        $dsn = "$protocol:host=$host;port=$port;dbname=$database;charset=utf8";

        try
        {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch (PDOException $ex)
        {
            die($ex->getMessage());
        }
        
    }

    public function close()
    {
        $this->pdo = null;
    }

    public function __destruct()
    {
        
    }
}

?>