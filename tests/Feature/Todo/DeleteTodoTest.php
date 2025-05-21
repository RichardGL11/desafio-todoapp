<?php

namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_delete_a_todo(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();
        $this->actingAs($user);
        $dashboard = $this->get('/home');
        $dashboard->assertSee($todo->title);
        $this->delete(route('todos.delete', $todo));
        $this->assertDatabaseMissing(Todo::class, [
            'id' => $todo->getKey(),
            'title' => $todo->title,
        ]);
        $this->assertDatabaseCount(Todo::class, 0);
        $dashboard = $this->get('/dashboard');
        $dashboard->assertDontSee($todo->title);
    }

    #[Test]
    public function test_only_the_owner_can_delete_todo(): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();
        $wrongUser = User::factory()->create();
        $this->actingAs($wrongUser);
        $response = $this->delete(route('todos.delete', $todo));
        $response->assertStatus(403);

        $this->assertDatabaseHas(Todo::class, [
            'id' => $todo->getKey(),
            'title' => $todo->title,
        ]);
        $this->assertDatabaseCount(Todo::class, 1);

    }
}
