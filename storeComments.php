<?php
require_once './DB.php';

if (isset($_POST['title']) && isset($_POST['content'])) {
    if ((strlen($_POST['title']) > 0) || (strlen($_POST['content']) > 5)) {
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'created_at' => date("Y-m-d"),
        ];
        $connection = DB::getInstance();
        $sql = "INSERT INTO comments (title, content, created_at) VALUES (:title, :content, :created_at)";
        $preparedRequest = $connection->prepare($sql);
        $preparedRequest->execute($data);
    }
}