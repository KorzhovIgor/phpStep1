<?php

use App\Controllers\CommentsController;
use App\Controllers\AppController;

class App
{

    public function run()
    {
        $urlWithoutQuery = strtok($_SERVER["REQUEST_URI"], '?');
        $query = $_SERVER['QUERY_STRING'];

        switch (true) {
            case strpos($urlWithoutQuery, '/comment/delete/') !== false:
            case strpos($urlWithoutQuery, '/comment/') !== false:
            case strpos($urlWithoutQuery, '/comments/edit/') !== false:
                $id = substr($urlWithoutQuery, strrpos($urlWithoutQuery, '/') + 1);
                $urlWithoutQuery = substr($urlWithoutQuery, 0, strrpos($urlWithoutQuery, '/') + 1);
                break;
        }

        $commentsController = new CommentsController();
        $appController = new AppController();

        switch ($urlWithoutQuery) {
            case '/':
                $appController->index();
                break;
            case '/comments':
                $commentsController->index($query);
                break;
            case '/comments/deleteFewComments':
                $commentsController->deleteFewComments();
                break;
            case '/comments/infiniteScroll':
                $commentsController->indexInfiniteScroll($query);
                break;
            case '/comment/':
                $commentsController->show($id);
                break;
            case '/comments/create':
                $commentsController->create();
                break;
            case '/comments/store':
                $commentsController->store();
                break;
            case '/comments/edit/':
                $commentsController->edit($id);
                break;
            case '/comments/update':
                $commentsController->update();
                break;
            case '/comment/delete/':
                $commentsController->delete($id);
                break;
            case '/api/comments/':
                $commentsController->getComments($query);
                break;
            default:
                $appController->error();
                break;
        }
    }
}
