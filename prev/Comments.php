<?php
require_once 'DB.php';

class Comments
{
    private static PDO $connection;

    public function __construct()
    {
        $this::$connection = DBConnection::getInstance();
    }

    public function store(string $title, string $content)
    {
        $params = [
            'title' => $title,
            'content' => $content,
            'created_at' => date("Y-m-d"),
        ];
        $sql = <<<SQL
            INSERT INTO comments (title, content, created_at) 
            VALUES (:title, :content, :created_at)
        SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute($params);
    }

    public function delete(string $query)
    {
        $commentId = substr($query, 3);
        $dbInstance = self::$connection;
        $sql = <<<SQL
            DELETE 
            FROM comments 
            WHERE id = :commentId
        SQL;
        $preparedRequest = $dbInstance->prepare($sql);
        $preparedRequest->bindValue(":commentId", $commentId);
        $preparedRequest->execute();
    }

    public function getCountPages(): string
    {
        $sql = <<<SQL
            SELECT Count(*) 
            FROM comments
        SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute();

        return json_encode(ceil(($preparedRequest->fetchColumn()) / 5));
    }

    public function getAll(string $query): string
    {
        $countLinks = json_decode($this->getCountPages());
        $page = substr($query, 5) - 1;
        if (($page >= $countLinks) || ($page < 0)) {
            $startRecord = $page >= $countLinks ? ($countLinks - 1) * 5 : 0;
        } else {
            $startRecord = $page * 5;
        }

        $sql = <<<SQL
            SELECT * 
            FROM comments 
            ORDER BY id DESC 
            LIMIT 5 
            OFFSET {$startRecord}
        SQL;

        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute();

        return json_encode($preparedRequest->fetchAll());
    }
}
