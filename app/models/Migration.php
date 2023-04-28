<?php

require_once PATH_TO_PROJECT . '/database/DBConnection.php';

class Migration
{
    private static PDO $connection;

    public function __construct()
    {
        $this::$connection = DBConnection::getInstance();
    }

    function getAll(): array
    {
        $sql = <<<SQL
            SELECT * 
            FROM migrations     
         SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute();

        return $preparedRequest->fetchAll();
    }

    function store(string $name)
    {
        $params = [
            'name' => $name,
            'created_at' => date("Y-m-d"),
        ];
        $sql = <<<SQL
            INSERT INTO migrations (name, created_at) 
            VALUES (:name, :created_at)
        SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute($params);
    }
}