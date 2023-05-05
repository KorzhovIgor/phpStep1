<?php

require_once PATH_TO_PROJECT . '/database/DBConnection.php';

class Comment
{
    private static PDO $connection;

    public function __construct()
    {
        $this::$connection = DBConnection::getInstance();
    }

    public function store(string $title, string $content): void
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

    public function getByID(string $id)
    {
        $sql = <<<SQL
            SELECT * 
            FROM comments 
            WHERE id = ?
        SQL;

        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute([$id]);

        return $preparedRequest->fetch(PDO::FETCH_ASSOC);
    }

    public function update(string $id, string $title, string $content): void
    {
        $sql = <<<SQL
            UPDATE comments 
            SET title = ?, content = ? 
            WHERE id = ?
        SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute([$title, $content, $id]);
    }


    public function delete(string $id): void
    {
        $dbInstance = self::$connection;
        $sql = <<<SQL
            DELETE 
            FROM comments 
            WHERE id = :id
        SQL;
        $preparedRequest = $dbInstance->prepare($sql);
        $preparedRequest->bindValue(":id", $id);
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

        return json_encode(ceil(($preparedRequest->fetchColumn()) / 10));
    }

    public function getAll(string $startRecord): string
    {
        $sql = <<<SQL
            SELECT * 
            FROM comments 
            ORDER BY id DESC 
            LIMIT 10 
            OFFSET {$startRecord}
        SQL;

        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute();

        return json_encode($preparedRequest->fetchAll());
    }
}
