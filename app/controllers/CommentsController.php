<?php

require_once PATH_TO_PROJECT . '/app/models/Comment.php';

class CommentsController
{
    private Comment $commentsModel;

    public function __construct()
    {
        $this->commentsModel = new Comment();
    }

    public function index($query): string
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

    public function show($id)
    {
        $comment = json_decode($this->commentsModel->getByID($id));

        return require_once PATH_TO_PROJECT . '/app/views/Comments/show.php';
    }

    public function create()
    {
        return require_once PATH_TO_PROJECT . '/app/views/Comments/create.php';
    }

    public function store()
    {
        if ((strlen($_POST['title']) > 0) || (strlen($_POST['content']) > 5)) {
            $this->commentsModel->store($_POST['title'], $_POST['content']);
        }
        header('location: /comments');
    }

    public function edit(string $id)
    {
        $comment = json_decode($this->commentsModel->getByID($id));

        return require_once PATH_TO_PROJECT . '/app/views/Comments/edit.php';
    }

    public function update()
    {
        if ((strlen($_POST['title']) > 0) || (strlen($_POST['content']) > 5)) {
            $comment = $this->commentsModel->getByID($_POST['id']);
            if ($comment != null) {
                $this->commentsModel->update($_POST['id'], $_POST['title'], $_POST['content']);
            }
        }
        header('location: /comments');
    }

    public function delete(string $id)
    {
        $this->commentsModel->delete($id);
        header("location: /comments");
    }
}
