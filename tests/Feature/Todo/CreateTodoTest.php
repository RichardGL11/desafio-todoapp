<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_create_a_todo():void
    {
       $user =  User::factory()->create();
       $this->actingAs($user);
      $response =  $this->post(route('todos.store',[
            'title' => 'Todo Title',
            'description' => 'todo description',
       ]));

       $this->assertDatabaseHas(Todo::class,[
           'title'       => 'Todo Title',
           'description' => 'todo description',
           'status'      => TodoStatusEnum::PENDING,
           'user_id'     => $user->getKey(),
       ]);

       $this->assertDatabaseCount(Todo::class,1);
       $response->assertStatus(201);
       $response->assertRedirect('/home');
    }
}
