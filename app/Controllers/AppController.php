<?php

namespace App\Controllers;


use App\Traits\Render;

class AppController
{

    use Render;

    public function index(): void
    {
        if (isset($_COOKIE['database'])) {
            $this->render('index.html.twig', ['db' => $_COOKIE['database']]);
        } else {
            $this->render('index.html.twig', ['db' => 'Default database']);
        }
    }

    public function error(): void
    {
        $this->render('error.html.twig', []);
    }
}
