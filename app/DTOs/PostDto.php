<?php

namespace App\DTOs;

class PostDto extends BaseDTO
{
    public $id;
    public $userId;
    public $title;
    public $body;

    protected static function getFields()
    {
        return ['id', 'user_id', 'title', 'body'];
    }
}
