<?php

namespace App\DTO;

final readonly class TodoDTO
{
 public function __construct(
     public string $title,
     public string $description,
 ){}

    public static function make(string $title,string $description):TodoDTO
    {
        return new self(
            title: $title,
            description:$description
        );
    }
}
