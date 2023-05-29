<?php

namespace App\Controllers;

use App\API\GorestApi;
use App\API\GorestApiAdapter;
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
            $nextPage = $page < $countPages ? $page + 1 : null;
            $nextPageLink = $nextPage !== null ? URL . '/comments?page=' . $nextPage : null;
            $prevPage = $page > 1 ? $page - 1 : null;
            $prevPageLink = $prevPage!== null ? URL . '/comments?page=' . $prevPage : null;
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $dataFromApi = json_decode(GorestApi::getComments($page, 10));
            $allComments = GorestApiAdapter::CommentsGorestToMyComments($dataFromApi->data);
            $countPages = $dataFromApi->meta->pagination->pages;
            $nextPage = $page < $countPages ? $page + 1 : null;
            $nextPageLink = $nextPage !== null ? URL . '/comments?page=' . $nextPage : null;
            $prevPage = $page > 1 ? $page - 1 : null;
            $prevPageLink = $prevPage!== null ? URL . '/comments?page=' . $prevPage : null;
        }

        $this->render('comments/index.html.twig', ['comments' => $allComments,
            'nextPage' => $nextPageLink, 'prevPage' => $prevPageLink]);
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
        if ($_COOKIE['database'] == 'Default database') {
            $comment = json_decode($this->commentsModel->getByID($id));
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            $comment = GorestApiAdapter::CommentGorestToMyComment(json_decode(GorestApi::getComment($id)));
        }
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
            if ($_COOKIE['database'] == 'Default database') {
                $this->commentsModel->store($validatedData['title'], $validatedData['content']);
            } else if ($_COOKIE['database'] == 'gorest REST API') {
                GorestApi::storeComment($validatedData['title'], $validatedData['content']);
            }
        }
        header('location: /comments');
    }

    public function edit(string $id): void
    {
        $comment = json_decode($this->commentsModel->getByID($id));
        $this->render('comments/edit.html.twig', ['comment' => $comment, 'path' => 'edit']);
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
        if ($_COOKIE['database'] == 'Default database') {
            $this->commentsModel->delete($id);
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            GorestApi::deleteComment($id);
        }
        header("location: /comments");
    }

    public function deleteFewComments(): void
    {
        $records = json_decode($_POST['request']);
        if ($_COOKIE['database'] == 'Default database') {
            $this->commentsModel->deleteFewRecords($records);
        } else if ($_COOKIE['database'] == 'gorest REST API') {
            GorestApi::deleteFewComment($records);
        }
    }
}
