<?php

require_once PATH_TO_PROJECT . '/app/models/Comment.php';
require_once PATH_TO_PROJECT . '/app/Request/CommentRequest.php';

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
            $startRecord = $page >= $countLinks ? ($countLinks - 1) * 5 : 0;
        } else {
            $startRecord = $page * 5;
        }
        $allComments = json_decode($this->commentsModel->getAll($startRecord));
        $countPages = json_decode($this->commentsModel->getCountPages());

        return require_once PATH_TO_PROJECT . '/app/views/Comments/index.php';
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
        if (http_response_code() != 400) {
            $this->commentsModel->store($validatedData['title'], $validatedData['content']);
            header('location: /comments');
        }
    }

    public function edit(string $id): bool
    {
        $comment = json_decode($this->commentsModel->getByID($id));

        return require_once PATH_TO_PROJECT . '/app/views/Comments/edit.php';
    }

    public function update(): void
    {
        $validatedData = CommentRequest::validateUpdate($_POST, $this->commentsModel);
        if (http_response_code() != 400) {
            $this->commentsModel->update($validatedData['id'], $validatedData['title'], $validatedData['content']);
            header("location: /comments");
        }
    }

    public function delete(string $id): void
    {
        $this->commentsModel->delete($id);
        header("location: /comments");
    }
}
