<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_update_a_todo(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);

        $this->actingAs($user);
        $this->put(route('todos.update', $todo), [
            'title' => 'new title',
            'description' => 'new description',
            'status' => TodoStatusEnum::COMPLETED->value,
        ]);
        $this->assertDatabaseCount(Todo::class, 1);
        $this->assertDatabaseHas(Todo::class, [
            'title' => 'new title',
            'description' => 'new description',
            'status' => TodoStatusEnum::COMPLETED,
            'user_id' => $user->getKey(),
        ]);
        $this->assertDatabaseMissing(Todo::class, [
            'title' => 'old title',
            'description' => 'old description',
        ]);
    }

    public function test_only_the_todo_owner_can_update()
    {
        $user = User::factory()->create();
        $wrongUser = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();

        $this->actingAs($wrongUser);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'new title',
            'description' => 'new description',
            'status' => TodoStatusEnum::COMPLETED->value,
        ]);
        $response->assertStatus(403);
    }

    #[DataProvider('title_validation_provider')]
    public function test_title_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => $input['title'],
            'description' => 'todo description',
        ]);

        $response->assertSessionHasErrors(['title' => $error]);
    }

    #[DataProvider('description_validation_provider')]
    public function test_description_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'title for todo',
            'description' => $input['description'],
        ]);

        $response->assertSessionHasErrors(['description' => $error]);
    }

    #[DataProvider('status_validation_provider')]
    public function test_status_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'title for todo',
            'description' => 'description',
            'status' => $input['status'],
        ]);

        $response->assertSessionHasErrors(['status' => $error]);
    }

    public static function title_validation_provider(): array
    {
        return [
            'missing title' => [
                'input' => ['title' => null],
                'error' => 'The title field is required.',
            ],
            'short title' => [
                'input' => ['title' => 'aa'],
                'error' => 'The title field must be at least 3 characters.',
            ],
            'long title' => [
                'input' => ['title' => str_repeat('a', 101)],
                'error' => 'The title field must not be greater than 100 characters.',
            ],
        ];
    }

    public static function description_validation_provider(): array
    {
        return [
            'missing description' => [
                'input' => ['description' => null],
                'error' => 'The description field is required.',
            ],
            'short description' => [
                'input' => ['description' => 'aa'],
                'error' => 'The description field must be at least 3 characters.',
            ],
            'long description' => [
                'input' => ['description' => str_repeat('a', 101)],
                'error' => 'The description field must not be greater than 100 characters.',
            ],
        ];
    }

    public static function status_validation_provider(): array
    {
        return [
            'wrong status' => [
                'input' => ['status' => 'aaa'],
                'error' => 'The selected status is invalid.',
            ],
        ];
    }
}
