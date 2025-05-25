<?php

namespace App\Actions;

use App\DTO\TodoDTO;
use App\Enums\TodoStatusEnum;
use App\Models\Todo;

class UpdateTodoAction
{
    public static function execute(TodoDTO $todoDTO,Todo $todo): void
    {
        $todo->title =  $todoDTO->title;
        $todo->description = $todoDTO->description;
        $todo->status = $todoDTO->status ?? $todo->status;
        $todo->update();
    }
}
