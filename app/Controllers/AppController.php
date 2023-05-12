<?php

namespace App\Controllers;

class AppController
{

    public function index(): bool
    {
        return require_once PATH_TO_PROJECT . '/app/views/index.html';
    }

    public function error(): bool
    {
        return require_once PATH_TO_PROJECT . '/app/views/error.html';
    }
}
