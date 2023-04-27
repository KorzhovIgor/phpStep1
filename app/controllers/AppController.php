<?php
class AppController
{

    public function index() {
        return require_once '/home/user/Projects/Start/app/views/index.html';
    }

    public function error() {
        return require_once '/home/user/Projects/Start/app/views/error.html';
    }
}