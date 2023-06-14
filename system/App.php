<?php

use App\Controllers\CommentsController;
use App\Controllers\AppController;
use App\Controllers\GorestApiController;

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
            case strpos($urlWithoutQuery, '/api/gorestApi/comment/') !== false:
            case strpos($urlWithoutQuery, '/api/gorestApi/comments/put/') !== false:
            case strpos($urlWithoutQuery, '/api/gorestApi/comments/patch/') !== false:
                $id = substr($urlWithoutQuery, strrpos($urlWithoutQuery, '/') + 1);
                $urlWithoutQuery = substr($urlWithoutQuery, 0, strrpos($urlWithoutQuery, '/') + 1);
                break;
        }

        $commentsController = new CommentsController();
        $appController = new AppController();
        $gorestApiController = new GorestApiController();

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
            case '/api/gorestApi/comments':
                $gorestApiController->getComments($query);
                break;
            case '/api/gorestApi/comment/':
                $gorestApiController->getComment($id);
                break;
            case '/api/gorestApi/comments/store':
                $gorestApiController->storeComment();
                break;
            case '/api/gorestApi/comment/delete/':
                $gorestApiController->deleteComment($id);
                break;
            case '/api/gorestApi/comments/put/':
                $gorestApiController->putComment($id);
                break;
            case '/api/gorestApi/comments/patch/':
                $gorestApiController->patchComment($id);
                break;
            case '/api/swaggerDock':
                require PATH_TO_PROJECT . '/public/web/index.html';
                break;
            default:
                $appController->error();
                break;
        }
    }
}
