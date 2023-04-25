<?php
require_once 'DB.php';

$dbInstance = DB::getInstance();
$stmt = $dbInstance->prepare(
    "SELECT Count(*) FROM comments "
);
$stmt->execute();
$countLinks = ceil(($stmt->fetchColumn()) / 5);

$page = 0;
if (isset($query)) {
    $page = substr($query, 5) - 1;
}

if (($page >= $countLinks) || ($page < 0)) {
    if ($page >= $countLinks) {
        $startRecord = ($countLinks - 1) * 5;
    } else {
        $startRecord = 0;
    }
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

$preparedRequest = $dbInstance->prepare($sql);
$preparedRequest->execute();
$comments = json_encode($preparedRequest->fetchAll());

header('Content-Type: application/json; charset=utf-8');
echo $comments;
