<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_update_a_todo():void
    {
       $user =  User::factory()->create();
       $todo = Todo::factory()->for($user)->create([
           'title'       => 'old title',
           'description' => 'old description',
       ]);

       $this->actingAs($user);
       $this->put(route('todos.update',$todo),[
         'title'       => 'new title',
         'description' => 'new description',
         'status'      => TodoStatusEnum::COMPLETED->value
       ]);
       $this->assertDatabaseCount(Todo::class,1);
       $this->assertDatabaseHas(Todo::class,[
           'title'       => 'new title',
           'description' => 'new description',
           'status'      => TodoStatusEnum::COMPLETED,
           'user_id'     => $user->getKey(),
       ]);
       $this->assertDatabaseMissing(Todo::class,[
           'title' => 'old title',
           'description' => 'old description'
       ]);
    }

    public function test_only_the_todo_owner_can_update()
    {
        $user =  User::factory()->create();
        $wrongUser = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        $this->actingAs($wrongUser);
        $response = $this->put(route('todos.update',$todo),[
            'title'       => 'new title',
            'description' => 'new description',
            'status'      => TodoStatusEnum::COMPLETED->value
        ]);
        $response->assertStatus(403);
    }
}
