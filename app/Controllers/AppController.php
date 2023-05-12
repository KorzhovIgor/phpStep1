<?php

namespace App\Controllers;


use App\Traits\Render;

class AppController
{

    use Render;

    public function index(): void
    {
        $this->render('index.html.twig', []);
    }

    public function error(): void
    {
        $this->render('error.html.twig', []);
    }
}
