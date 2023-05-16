<?php

namespace App\Controllers;

use App\API\GorestApi;
use App\Models\Comment;
use App\Request\CommentRequest;
use App\Traits\Render;

class CommentsController
{

    use Render;
    private Comment $commentsModel;

    public function __construct()
    {
        $this->commentsModel = new Comment();
    }

    public function index($query): void
    {
        $page = substr($query, 5) - 1;
        if ($_COOKIE['database'] == 'Default database') {
            $countLinks = json_decode($this->commentsModel->getCountPages());
            if (($page >= $countLinks) || ($page < 0)) {
                $startRecord = $page >= $countLinks ? ($countLinks - 1) * 10 : 0;
            } else {
                $startRecord = $page * 10;
            }
            $allComments = json_decode($this->commentsModel->getAll($startRecord));
            $countPages = json_decode($this->commentsModel->getCountPages());
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $allComments = json_decode(GorestApi::getComments($page, 10));
            var_dump($allComments);
            die();
        }

        $this->render('comments/index.html.twig', ['comments' => $allComments, 'countLinks' => $countPages]);
    }

    public function getComments(string $query)
    {
        $page = substr($query, 5) - 1;
        header("Content-type: application/json; charset=utf-8");
        echo $this->commentsModel->getAll($page * 20, 20);
    }

    public function indexInfiniteScroll(string $query): void
    {
        $page = substr($query, 5) - 1;
        $countLinks = json_decode($this->commentsModel->getCountPages(20));
        if (($page >= $countLinks) || ($page < 0)) {
            $startRecord = $page >= $countLinks ? ($countLinks - 1) * 20 : 0;
        } else {
            $startRecord = $page * 20;
        }
        $allComments = json_decode($this->commentsModel->getAll($startRecord, 20));

        $this->render('comments/indexInfinite.html.twig', ['comments' => $allComments]);
    }

    public function show(int $id): void
    {
        $comment = json_decode($this->commentsModel->getByID($id));
        $this->render('comments/show.html.twig', ['comment' => $comment, 'path' => 'show']);
    }

    public function create(): void
    {
        $this->render('comments/create.html.twig', []);
    }

    public function store(): void
    {
        $validatedData = CommentRequest::validateStore($_POST);
        if (isset($validatedData['error_message'])) {
            header("HTTP/1.1 400 Bad Request");
        } else {
            $this->commentsModel->store($validatedData['title'], $validatedData['content']);
        }
        header('location: /comments');
    }

    public function edit(string $id): void
    {
        global $urlWithoutQuery;
        $comment = json_decode($this->commentsModel->getByID($id));
        $this->render('comments/edit.html.twig', ['comment' => $comment, 'url' => $urlWithoutQuery,
            'path' => 'edit']);
    }

    public function update(): void
    {
        $validatedData = CommentRequest::validateUpdate($_POST, $this->commentsModel);
        if (isset($validatedData['error_message'])) {
            header("HTTP/1.1 400 Bad Request");
        } else {
            $this->commentsModel->update($validatedData['id'], $validatedData['title'], $validatedData['content']);
        }
        header("location: /comments");
    }

    public function delete(string $id): void
    {
        $this->commentsModel->delete($id);
        header("location: /comments");
    }

    public function deleteFewComments(): void
    {
        $records = json_decode($_POST['request']);
        $this->commentsModel->deleteFewRecords($records);
    }
}
