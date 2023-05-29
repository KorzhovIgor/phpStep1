<?php

namespace App\API;

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

    public static function storeComment(string $name, string $body): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments",
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer 3086eba9e5bfee101bf3da3994bac37fbdb9480c674e6790938678058c8ffce8'
            ],
            CURLOPT_RETURNTRANSFER => 0,
        ];
        $data = array('post_id' => '38977', 'name' => $name, 'email' => 'thms@gmai.com', 'body' => $body);
        $json_data = json_encode($data);
        $options[CURLOPT_POSTFIELDS] = $json_data;
        curl_setopt_array($curl, $options);
        curl_exec($curl);
        curl_close($curl);
    }

    public static function deleteComment(string $id): void
    {
        $curl = curl_init();
        $options = [
            CURLOPT_URL => "https://gorest.co.in/public/v1/comments/$id",
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer 3086eba9e5bfee101bf3da3994bac37fbdb9480c674e6790938678058c8ffce8'
            ],
            CURLOPT_RETURNTRANSFER => 0,
        ];
        curl_setopt_array($curl, $options);
        curl_exec($curl);
        curl_close($curl);
    }

    public static function deleteFewComment(array $commentsId): void
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
            curl_setopt($curl,CURLOPT_URL, "https://gorest.co.in/public/v1/comments/$commentId");
            curl_exec($curl);
        }
        curl_close($curl);
    }

}
