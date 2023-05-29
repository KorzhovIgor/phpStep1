<?php

namespace App\API;

use stdClass;

class GorestApiAdapter
{
    public static function CommentsGorestToMyComments(array $gorestComments): array
    {
        $comments = [];
        foreach ($gorestComments as $key => $gorestComment) {
            $comment = new StdClass();
            $comment->id = $gorestComment->id;
            $comment->title = $gorestComment->name;
            $comment->content = $gorestComment->body;
            $comments[$key] = $comment;
        }

        return $comments;
    }

    public static function CommentGorestToMyComment(StdClass $gorestComment): stdClass
    {
        $comment = new StdClass();
        $comment->id = $gorestComment->data->id;
        $comment->title = $gorestComment->data->name;
        $comment->content = $gorestComment->data->body;
        return $comment;
    }
}
