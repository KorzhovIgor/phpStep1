<?php
require_once 'Comments.php';

$url = $_SERVER['REQUEST_URI'];
[$urlWithoutQuery, $query] = explode('?', $url);
$commentsModel = new Comments();

switch ($urlWithoutQuery) {
    case '/':
        require 'view.php';
        break;
    case '/api/comments/':
    case '/api/comments':
        header('Content-Type: application/json; charset=utf-8');
        echo $commentsModel->getAll($query);
        break;
    case '/api/comments/delete/':
        $commentsModel->delete($query);
        break;
    case '/api/comments/count':
        header('Content-Type: application/json; charset=utf-8');
        echo $commentsModel->getCountPages();
        break;
    case '/storeComments':
        if ((strlen($_POST['title']) > 0) || (strlen($_POST['content']) > 5)) {
            $commentsModel->store($_POST['title'], $_POST['content']);
        }
        break;
    default:
        require 'error.php';
        break;
}

