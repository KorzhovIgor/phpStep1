<?php
require_once '/home/user/Projects/Start/app/models/Comment.php';

class CommentFactory
{
    private Comment $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function run() {
        $params = [
            'title' => self::getRandomString(random_int(4, 30)),
            'content' => self::getRandomString(random_int(30, 50)),
        ];
        $this->comment->store($params['title'], $params['content']);
    }

    protected static function getRandomString(int $length = 16): string {
        $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringLength = strlen($stringSpace);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString = $randomString . $stringSpace[rand(0, $stringLength - 1)];
        }
        return $randomString;
    }

}

