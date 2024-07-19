<?php

namespace App\DTOs;

class UserDto extends BaseDTO
{
    public $id;
    public $name;
    public $email;

    protected static function getFields()
    {
        return ['id', 'name', 'email'];
    }
}
