<?php

require_once '../bootstrap/base-path.php';
require_once PATH_TO_PROJECT . '/app/controllers/CommentsController.php';
require_once PATH_TO_PROJECT . '/app/controllers/AppController.php';

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
            default:
                $appController->error();
                break;
        }
    }
}
