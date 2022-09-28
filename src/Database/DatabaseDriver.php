<?php

namespace Fibi\Database;

use PDO;
use PDOException;

class DatabaseDriver extends DbConnection
{
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function endTransaction()
    {
        $this->pdo->commit();
    }

    /**
     * Ejecuta una instrucción de base de datos de tipo insercion
     *
     * @param string $query
     * @param array $parameters
     * @return integer Cantidad de registros que fueron afectos
     */
    public function executeNonQuery(string $query, array $parameters = []) : int|string
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

    /**
     * Ejecuta una instrucción de base de datos de tipo lectura
     *
     * @param string $query
     * @param array $parameters
     * @return array Datos obtenidos
     */
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