<?php

namespace App\DTOs;

abstract class BaseDto
{
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function fromModel($model)
    {
        $attributes = array_intersect_key($model->toArray(), array_flip(static::getFields()));
        return new static($attributes);
    }

    protected static function getFields()
    {
        return [];
    }
}
