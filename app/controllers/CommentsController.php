<?php
require_once '/home/user/Projects/Start/app/models/Comment.php';
class CommentsController
{
    private Comment $commentsModel;

    public function __construct() {
        $this->commentsModel = new Comment();
    }

    public function index($query): string {
        $page = substr($query, 5) - 1;
        $allComments = json_decode($this->commentsModel->getAll($page));
        $countPages = json_decode($this->commentsModel->getCountPages());
        return require_once '/home/user/Projects/Start/app/views/Comments/index.php';
    }

    public function show($id) {
        $comment = json_decode($this->commentsModel->getByID($id));
        return require_once '/home/user/Projects/Start/app/views/Comments/show.php';
    }

    public function create() {
        return require_once '/home/user/Projects/Start/app/views/Comments/create.php';
    }

    public function store() {
        if ((strlen($_POST['title']) > 0) || (strlen($_POST['content']) > 5)) {
            $this->commentsModel->store($_POST['title'], $_POST['content']);
        }
        header('location: /comments');
    }

    public function edit(string $id) {
        $comment = json_decode($this->commentsModel->getByID($id));
        return require_once '/home/user/Projects/Start/app/views/Comments/edit.php';
    }

    public function update() {
        if ((strlen($_POST['title']) > 0) || (strlen($_POST['content']) > 5)) {
            $comment = $this->commentsModel->getByID($_POST['id']);
            if ($comment != NULL) {
                $this->commentsModel->update($_POST['id'], $_POST['title'], $_POST['content']);
            }
        }
        header('location: /comments');
    }

    public function delete(string $id) {
        $this->commentsModel->delete($id);
        header("location: /comments");
    }
}
