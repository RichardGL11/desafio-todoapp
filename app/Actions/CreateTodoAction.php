<?php

namespace App\Actions;

use App\DTO\TodoDTO;
use App\Enums\TodoStatusEnum;
use App\Models\Todo;

class CreateTodoAction
{
    public static function execute(TodoDTO $todoDTO): void
    {
        Todo::query()->create([
            'title' => $todoDTO->title,
            'description' => $todoDTO->description,
            'status' => TodoStatusEnum::PENDING->value,
            'user_id' => auth()->user()->id,
        ]);

    }
}
