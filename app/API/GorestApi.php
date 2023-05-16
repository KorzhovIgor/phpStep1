<?php

namespace App\API;

class GorestApi
{
    public static function getComments(string $page, string $perPage): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://gorest.co.in/public/v2/comments");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}