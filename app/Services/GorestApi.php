<?php

namespace App\Services;

class GorestApi
{
    public static function getComments(int $page, string $perPage): string
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments?page=$page&per_page=$perPage",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        curl_setopt_array($curl, $options);
        $comments = curl_exec($curl);
        curl_close($curl);
        return $comments;
    }

    public static function getPosts(int $page, string $perPage): string
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/posts?page=$page&per_page=$perPage",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        curl_setopt_array($curl, $options);
        $posts = curl_exec($curl);
        curl_close($curl);
        return $posts;
    }

    public static function getComment(int $id): string
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments/$id",
            CURLOPT_HTTPHEADER => ['Content-Type' => 'application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ];
        curl_setopt_array($curl, $options);
        $comment = curl_exec($curl);
        curl_close($curl);
        return $comment;
    }

    public static function storeComment(string $auth): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments",
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: $auth"
            ],
            CURLOPT_RETURNTRANSFER => 1,
        ];
        $data = array('post_id' => $_POST['post_id'], 'name' => $_POST['title'],
            'email' => $_POST['email'], 'body' => $_POST['content']);
        $json_data = json_encode($data);
        $options[CURLOPT_POSTFIELDS] = $json_data;
        curl_setopt_array($curl, $options);
        $comment = curl_exec($curl);
        curl_close($curl);
        echo $comment;
    }

    public static function putComment(string $auth, string $id, ?array $params = null): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments/{$id}",
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: $auth"
            ],
            CURLOPT_RETURNTRANSFER => 1,
        ];
        if (isset($params)) {
            $data = array(
                'post_id' => $params['post_id'], 'name' => $params['title'],
                'email' => $params['email'], 'body' => $params['content']);
        } else {
            $_PUT = [];
            parse_raw_http_request($_PUT);
            $data = array(
                'post_id' => $_PUT['post_id'], 'name' => $_PUT['title'],
                'email' => $_PUT['email'], 'body' => $_PUT['content']);
        }
        $json_data = json_encode($data);
        $options[CURLOPT_POSTFIELDS] = $json_data;
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        curl_close($curl);
        echo $result;
    }

    public static function patchComment(string $auth, string $id): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments/{$id}",
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: $auth"
            ],
            CURLOPT_RETURNTRANSFER => 1,
        ];
        $_PATCH = [];
        parse_raw_http_request($_PATCH);
        $json_data = json_encode($_PATCH);
        $options[CURLOPT_POSTFIELDS] = $json_data;
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        curl_close($curl);
        echo $result;
    }

    public static function deleteComment(string $id, string $auth): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments/$id",
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: $auth"
            ],
            CURLOPT_RETURNTRANSFER => 1,
        ];
        curl_setopt_array($curl, $options);
        $deletedComment = curl_exec($curl);
        curl_close($curl);
        echo $deletedComment;
    }

    public static function deleteFewComments(array $commentsId): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer 3086eba9e5bfee101bf3da3994bac37fbdb9480c674e6790938678058c8ffce8'
            ],
            CURLOPT_RETURNTRANSFER => 0,
        ];
        curl_setopt_array($curl, $options);
        foreach ($commentsId as $commentId) {
            curl_setopt($curl, CURLOPT_URL, "https://gorest.co.in/public/v1/comments/$commentId");
            curl_exec($curl);
        }
        curl_close($curl);
    }

}
