<?php
require_once 'DB.php';
$dbInstance = DB::getInstance();
$stmt = $dbInstance->prepare(
    "SELECT Count(*) FROM comments "
);
$stmt->execute();


header('Content-Type: application/json; charset=utf-8');
echo json_encode(ceil(($stmt->fetchColumn()) / 5));