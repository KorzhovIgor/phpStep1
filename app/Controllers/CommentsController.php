<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Request\CommentRequest;
use App\Services\GorestApi;
use App\Services\GorestApiAdapter;
use App\Traits\Render;

class CommentsController
{

    use Render;
    private Comment $commentsModel;
    private GorestApi $gorestApi;

    public function __construct()
    {
        $this->commentsModel = new Comment();
        $this->gorestApi = new GorestApi();
    }

    public function index($query): void
    {
        $rawPage = intval(substr($query, 5));
        $page = $rawPage <= 0 ? 1 : $rawPage;
        if ($_COOKIE['database'] == 'Default database') {
            $countLinks = json_decode($this->commentsModel->getCountPages());
            if (($page > $countLinks) || ($page <= 0)) {
                $startRecord = $page > $countLinks ? ($countLinks - 1) * 10 : 0;
            } else {
                $startRecord = ($page - 1) * 10;
            }
            $allComments = json_decode($this->commentsModel->getAll($startRecord));
            $countPages = json_decode($this->commentsModel->getCountPages());
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $dataFromApi = json_decode($this->gorestApi->getComments($page, 10));
            $allComments = GorestApiAdapter::CommentsGorestToMyComments($dataFromApi->data);
            $countPages = $dataFromApi->meta->pagination->pages;
        }
        $nextPage = $page < $countPages ? $page + 1 : null;
        $nextPageLink = $nextPage !== null ? URL . '/comments?page=' . $nextPage : null;
        $prevPage = $page > 1 ? $page - 1 : null;
        $prevPageLink = $prevPage !== null ? URL . '/comments?page=' . $prevPage : null;
        $this->render('comments/index.html.twig', ['comments' => $allComments,
            'nextPage' => $nextPageLink, 'prevPage' => $prevPageLink]);
    }

    public function getComments(string $query)
    {
        $page = intval(substr($query, 5)) - 1;
        if ($_COOKIE['database'] == 'Default database') {
            header("Content-type: application/json; charset=utf-8");
            echo $this->commentsModel->getAll($page * 20, 20);
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $dataFromApi = json_decode($this->gorestApi->getComments($page, 20));
            echo json_encode(GorestApiAdapter::CommentsGorestToMyComments($dataFromApi->data));
        }
    }

    public function indexInfiniteScroll(): void
    {
        if ($_COOKIE['database'] == 'Default database') {
            $allComments = json_decode($this->commentsModel->getAll(0, 20));
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $dataFromApi = json_decode($this->gorestApi->getComments(1, 20));
            $allComments = GorestApiAdapter::CommentsGorestToMyComments($dataFromApi->data);
        }
        $this->render('comments/indexInfinite.html.twig', ['comments' => $allComments]);
    }

    public function show(int $id): void
    {
        if ($_COOKIE['database'] == 'Default database') {
            $comment = json_decode($this->commentsModel->getByID($id));
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $comment = GorestApiAdapter::CommentGorestToMyComment(json_decode($this->gorestApi->getComment($id)));
        }
        $this->render('comments/show.html.twig', ['comment' => $comment, 'path' => 'show', 'db' => $_COOKIE['database']]);
    }

    public function create(): void
    {
        if ($_COOKIE['database'] == 'gorest REST API') {
            $postsForComments = json_decode($this->gorestApi->getPosts(1, 6));
        }
        $this->render('comments/create.html.twig', ['db' => $_COOKIE['database'], 'posts' => $postsForComments->data]);
    }

    public function store(): void
    {
        $validatedData = CommentRequest::validateStore($_POST);
        if (isset($validatedData['error_message'])) {
            header("HTTP/1.1 400 Bad Request");
        } else {
            if ($_COOKIE['database'] == 'Default database') {
                $this->commentsModel->store($validatedData['title'], $validatedData['content']);
            } else if ($_COOKIE['database'] == 'gorest REST API') {
                $this->gorestApi->storeComment(AUTH_GOREST_API);
            }
        }
        header('location: /comments');
    }

    public function edit(string $id): void
    {
        if ($_COOKIE['database'] == 'Default database') {
            $comment = json_decode($this->commentsModel->getByID($id));
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $comment = GorestApiAdapter::CommentGorestToMyComment(json_decode($this->gorestApi->getComment($id)));
        }
        $this->render('comments/edit.html.twig', ['comment' => $comment,
            'path' => 'edit', 'db' => $_COOKIE['database']]);
    }

    public function update(): void
    {
        if (isset($validatedData['error_message']) && ($_COOKIE['database'] == 'Default database')) {
            header("HTTP/1.1 400 Bad Request");
        } else {
            if ($_COOKIE['database'] == 'Default database') {
                $validatedData = CommentRequest::validateUpdate($_POST, $this->commentsModel);
                $this->commentsModel->update($validatedData['id'], $validatedData['title'], $validatedData['content']);
            } else if ($_COOKIE['database'] == 'gorest REST API') {
                $this->gorestApi->putComment(AUTH_GOREST_API, $_POST['id'], $_POST);
            }
        }
        header("location: /comments");
    }

    public function delete(string $id): void
    {
        if ($_COOKIE['database'] == 'Default database') {
            $this->commentsModel->delete($id);
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $this->gorestApi->deleteComment($id, AUTH_GOREST_API);
        }
        header("location: /comments");
    }

    public function deleteFewComments(): void
    {
        $records = json_decode($_POST['request']);
        if ($_COOKIE['database'] == 'Default database') {
            $this->commentsModel->deleteFewRecords($records);
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $this->gorestApi->deleteFewComments($records);
        }
    }
}
