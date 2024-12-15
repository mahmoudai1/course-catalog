<?php

namespace database;

use PDO;
use PDOException;

class DB
{
    private static ?DB $instance = null;

    private string $host = DB_HOST;
    private string $dbName = DB_NAME;
    private string $username = DB_USER;
    private string $password = DB_PASS;

    private ?PDO $connection = null;

    public static function get(): PDO|null
    {
        if (self::$instance === null)
        {
            self::$instance = new DB();
        }

        return self::$instance->connect();
    }

    public function connect(): PDO|null
    {
        if ($this->connection === null)
        {
            try
            {
                $this->connection = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbName}",
                    $this->username,
                    $this->password
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $e)
            {
                error_log("DB Connection error: " . $e->getMessage());
                http_response_code(500);
                header('HTTP/1.1 500 Internal Server Error');

                die("500 Internal Server Error");
            }
        }
        return $this->connection;
    }
}
