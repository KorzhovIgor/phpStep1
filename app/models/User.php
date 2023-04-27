<?php
require_once '/home/user/Projects/Start/database/DBConnection.php';

class User
{
    private static PDO $connection;

    public function __construct()
    {
        $this::$connection = DBConnection::getInstance();
    }

    public function store(string $firstname, string $lastname)
    {
        $params = [
            'firstname' => $firstname,
            'lastname' => $lastname,
        ];
        $sql = <<<SQL
            INSERT INTO users (firstname, lastname) 
            VALUES (:firstname, :lastname)
        SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute($params);
    }
}
