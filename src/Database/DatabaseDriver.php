<?php

namespace Fibi\Database;

use PDO;
use PDOException;

class DatabaseDriver extends DbConnection
{
    public function beginTransaction()
    {

    }

    public function endTransaction()
    {

    }

    /**
     * Ejecuta una sentencia de base de datos
     *
     * @param string $query
     * @param array $parameters
     * @return integer
     */
    public function executeNonQuery(string $query, array $parameters = []) : int
    {
        try
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($parameters);
            $rowCount = $statement->rowCount();
            $statement = null;
            return $rowCount;
        }
        catch (PDOException $ex)
        {
            die($ex->getMessage());
        }
    }

    public function executeReader(string $query, array $parameters = []) : array
    {
        try
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($parameters);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $ex)
        {
            die($ex->getMessage());
        }
    }

}

?>