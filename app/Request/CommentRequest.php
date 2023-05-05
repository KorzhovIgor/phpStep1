<?php

class CommentRequest
{
    public static function validateStore(array $post)
    {
        if ((strlen($post['title']) > 0) || (strlen($post['content']) > 5)) {
            return [
                'title' => $post['title'],
                'content' => $post['content']
            ];
        }
        header("HTTP/1.1 400 Bad Request");
    }

    public static function validateUpdate(array $post, Comment $commentsModel)
    {
        $comment = $commentsModel->getByID($post['id']);
        var_dump($comment);
        die();
        if ($comment === 'false') {
            header("HTTP/1.1 400 Bad Request");
        }
        $validatedData = self::validateStore($post);
        $validatedData['id'] = $post['id'];
        return $validatedData;
    }
}
