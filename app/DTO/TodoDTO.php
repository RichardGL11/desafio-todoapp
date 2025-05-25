<?php

namespace App\DTO;

use App\Enums\TodoStatusEnum;

final readonly class TodoDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public TodoStatusEnum|string|null $status = null
    ) {}

    public static function make(string $title, string $description, TodoStatusEnum|string|null $status = null): TodoDTO
    {
        return new self(
            title: $title,
            description: $description,
            status: $status
        );
    }
}
