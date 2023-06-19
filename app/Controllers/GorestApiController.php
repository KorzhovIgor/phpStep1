<?php

namespace App\Controllers;

use App\Services\GorestApi;

class GorestApiController
{
    private GorestApi $gorestApi;

    /**
     * @param $gorestApi
     */
    public function __construct($gorestApi)
    {
        $this->gorestApi = $gorestApi;
    }


    public function getComments($query)
    {
        $queryParams = explode('&', $query);
        $page = 1;
        $per_page = 10;
        foreach ($queryParams as $param) {
            if (str_contains($param, 'per_page=')) {
                $per_page = substr($param, 9);
            } else if (str_contains($param, 'page=')) {
                $page = substr($param, 5);
            }
        }
        header("Content-type: application/json; charset=utf-8");
        echo $this->gorestApi->getComments($page, $per_page);
    }

    public function getComment(string $id)
    {
        header("Content-type: application/json; charset=utf-8");
        echo $this->gorestApi->getComment($id);
    }

    public function storeComment(): void
    {
        $auth = getallheaders()['Authorization'];
        if ($auth) {
            header("Content-type: application/json; charset=utf-8");
            $this->gorestApi->storeComment($auth);
        } else {
            echo "Auth problem";
        }
    }

    public function putComment(string $id): void
    {
        $auth = getallheaders()['Authorization'];
        if ($auth) {
            header("Content-type: application/json; charset=utf-8");
            $this->gorestApi->putComment($auth, $id);
        } else {
            echo "Auth problem";
        }
    }

    public function patchComment(string $id): void
    {

        $auth = getallheaders()['Authorization'];
        if ($auth) {
            header("Content-type: application/json; charset=utf-8");
            $this->gorestApi->patchComment($auth, $id);
        } else {
            echo "Auth problem";
        }
    }

    public function deleteComment(string $id): void
    {
        $auth = getallheaders()['Authorization'];
        if ($auth) {
            header("Content-type: application/json; charset=utf-8");
            $this->gorestApi->deleteComment($id, $auth);
        } else {
            echo "Auth problem";
        }
    }

}
