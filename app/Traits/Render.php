<?php

namespace App\Traits;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait Render
{
    public function render(string $path, array $params): void
    {
        $loader = new FilesystemLoader(PATH_TO_PROJECT . "/app/views/templates");
        $twig = new Environment($loader);
        echo $twig->render($path, $params);
    }

}