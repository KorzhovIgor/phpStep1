<?php

class AppController
{

    public function index()
    {
        return require_once PATH_TO_PROJECT . '/app/views/index.html';
    }

    public function error()
    {
        return require_once PATH_TO_PROJECT . '/app/views/error.html';
    }
}
