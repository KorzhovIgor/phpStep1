<?php

namespace App\Request;

use App\Models\Comment;

class CommentRequest
{
    public static function validateStore(array $post): array
    {
        if ((strlen($post['title']) > 0) && (strlen($post['content']) > 5)) {
            return [
                'title' => $post['title'],
                'content' => $post['content']
            ];
        } else {
            return [
                'error_message' => "wrong data",
            ];
        }
    }

    public static function validateUpdate(array $post, Comment $commentModel): array
    {
        $comment = $commentModel->getByID($post['id']);
        if ($comment === 'false') {
            return [
                'error_message' => "wrong id",
            ];
        }
        $validatedData = self::validateStore($post);
        $validatedData['id'] = $post['id'];

        return $validatedData;
    }
}
