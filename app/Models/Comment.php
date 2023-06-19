<?php

namespace App\Models;

use Database\DBConnection;
use PDO;

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

        return json_encode($preparedRequest->fetch());
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

    public function deleteFewRecords(array $comments): void
    {
        $placeholders = str_repeat('?, ', count($comments) - 1) . '?';
        $dbInstance = self::$connection;
        $sql = <<<SQL
            DELETE 
            FROM comments 
            WHERE id IN($placeholders)
        SQL;
        $preparedRequest = $dbInstance->prepare($sql);
        $preparedRequest->execute($comments);
    }

    public function getCountPages(int $countRecords = 10): string
    {
        $sql = <<<SQL
            SELECT Count(*) 
            FROM comments
        SQL;
        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->execute();

        return json_encode(ceil(($preparedRequest->fetchColumn()) / $countRecords));
    }

    public function getAll(string $startRecord, int $countRecords = 10): string
    {
        $sql = <<<SQL
            SELECT * 
            FROM comments 
            ORDER BY id DESC 
            LIMIT :countRecords
            OFFSET :startRecord
        SQL;

        $preparedRequest = self::$connection->prepare($sql);
        $preparedRequest->bindValue('countRecords', $countRecords, PDO::PARAM_INT);
        $preparedRequest->bindValue('startRecord', $startRecord, PDO::PARAM_INT);
        $preparedRequest->execute();

        return json_encode($preparedRequest->fetchAll());
    }
}
