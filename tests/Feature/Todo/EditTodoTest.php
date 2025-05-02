<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_see_the_edit_form_for_a_todo():void
    {
       $user =  User::factory()->create();
       $todo = Todo::factory()->for($user)->create();
       $this->actingAs($user);
       $response = $this->from('/home')->get(route('todos.edit',$todo));
       $response->assertSee($todo->id);
       $response->assertSee($todo->title);
       $response->assertSee($todo->description);
       $response->assertSee($todo->status);
    }
}
