<?php

namespace Tests\Feature\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_create_a_todo(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('todos.create'));
        $response = $this->post(route('todos.store', [
            'title' => 'Todo Title',
            'description' => 'todo description',
        ]));

        $this->assertDatabaseHas(Todo::class, [
            'title' => 'Todo Title',
            'description' => 'todo description',
            'status' => TodoStatusEnum::PENDING,
            'user_id' => $user->getKey(),
        ]);

        $this->assertDatabaseCount(Todo::class, 1);
        $response->assertStatus(201);
        $response->assertRedirect('/home');
    }

    #[DataProvider('title_validation_provider')]
    public function test_title_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('todos.store', [
            'title' => $input['title'],
            'description' => 'todo description',
        ]));

        $response->assertSessionHasErrors(['title' => $error]);
    }

    #[DataProvider('title_description_provider')]
    public function test_description_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('todos.store', [
            'title' => 'title for todo',
            'description' => $input['description'],
        ]));

        $response->assertSessionHasErrors(['description' => $error]);
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

    public static function title_description_provider(): array
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
}
