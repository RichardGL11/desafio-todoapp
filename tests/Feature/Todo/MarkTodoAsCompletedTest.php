<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use function PHPUnit\Framework\assertTrue;

class MarkTodoAsCompletedTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_create_mark_todo_as_completed():void
    {
       $user =  User::factory()->create();
       $todo = Todo::factory()->for($user)->createOne();
       $this->actingAs($user);
       $response = $this->from('/home')->get(route('todos.mark.completed',$todo));
       $response->assertRedirect('/home');
       $todo->refresh();
       assertTrue($todo->status == TodoStatusEnum::COMPLETED);
    }
}
