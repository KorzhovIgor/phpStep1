<?php
require_once 'DB.php';

if(isset($query)) {
    $commentId = substr($query, 3);
    $dbInstance = DBConnection::getInstance();
    $sql = <<<SQL
    DELETE 
    FROM comments 
    WHERE id = :commentId
SQL;
    $preparedRequest = $dbInstance->prepare($sql);
    $preparedRequest->bindValue(":commentId", $commentId);
    $preparedRequest->execute();
}

