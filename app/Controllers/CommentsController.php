<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Request\CommentRequest;

class CommentsController
{
    private Comment $commentsModel;

    public function __construct()
    {
        $this->commentsModel = new Comment();
    }

    public function index($query): bool
    {
        $page = substr($query, 5) - 1;
        $countLinks = json_decode($this->commentsModel->getCountPages());
        if (($page >= $countLinks) || ($page < 0)) {
            $startRecord = $page >= $countLinks ? ($countLinks - 1) * 10 : 0;
        } else {
            $startRecord = $page * 10;
        }
        $allComments = json_decode($this->commentsModel->getAll($startRecord));
        $countPages = json_decode($this->commentsModel->getCountPages());

        return require_once PATH_TO_PROJECT . '/app/views/Comments/index.php';
    }

    public function getComments($query)
    {
        $page = substr($query, 5) - 1;
        header("Content-type: application/json; charset=utf-8");
        echo $this->commentsModel->getAll($page * 20, 20);
    }

    public function indexInfiniteScroll($query): bool
    {
        $page = substr($query, 5) - 1;
        $countLinks = json_decode($this->commentsModel->getCountPages(20));
        if (($page >= $countLinks) || ($page < 0)) {
            $startRecord = $page >= $countLinks ? ($countLinks - 1) * 20 : 0;
        } else {
            $startRecord = $page * 20;
        }
        $allComments = json_decode($this->commentsModel->getAll($startRecord, 20));

        return require_once PATH_TO_PROJECT . '/app/views/Comments/indexInfinite.php';
    }

    public function show($id): bool
    {
        $comment = json_decode($this->commentsModel->getByID($id));

        return require_once PATH_TO_PROJECT . '/app/views/Comments/show.php';
    }

    public function create(): bool
    {
        return require_once PATH_TO_PROJECT . '/app/views/Comments/create.php';
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

    public function edit(string $id): bool
    {
        $comment = json_decode($this->commentsModel->getByID($id));

        return require_once PATH_TO_PROJECT . '/app/views/Comments/edit.php';
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
