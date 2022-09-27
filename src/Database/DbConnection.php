<?php

namespace Fibi\Database;

use PDO;
use PDOException;

/**
 * Se encarga de la conexión a la base de datos
 */
abstract class DbConnection
{
    /**
     * PHP Database Object se encargara de todas las ejecuciones y llamadas
     * a la base de datos
     *
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * Conecta PHP a la base de datos
     */
    public function __construct() 
    {
        $protocol = $_ENV["PROTOCOL"];
        $host = $_ENV["HOST"];
        $port = $_ENV["PORT"];
        $database = $_ENV["DATABASE"];
        $username = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];

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

    /**
     * Cierra la conexión de la base de datos
     *
     * @return void
     */
    public function close() : void
    {
        $this->pdo = null;
    }
}

?>